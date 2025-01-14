<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pegawai;
use App\Models\NaskahKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;


class NaskahKeluarController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10); // Default per page is 10
            $search = $request->query('search', ''); // Search parameter
            $filter = $request->query('filter', ''); // Filter by status
            $tglNaskah = $request->query('tgl_naskah', ''); // Filter by date
    
            // Start the query to get NaskahKeluar, ordered by 'tgl_naskah'
            $query = NaskahKeluar::orderBy('tgl_naskah', 'desc');
            
            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_naskah', 'like', "%{$search}%")
                      ->orWhere('jenis_naskah', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%")
                      ->orWhere('asal_naskah', 'like', "%{$search}%")
                      ->orWhere('tujuan', 'like', "%{$search}%");
                });
            }
    
            // Apply status filter if provided
            if ($filter) {
                $query->where('status', $filter);
            }
    
            // Apply date filter if provided
            if ($tglNaskah) {
                $query->whereDate('tgl_naskah', '=', $tglNaskah);
            }
    
            // Get the paginated result
            $naskahKeluar = $query->paginate($perPage);
    
            // Return the response
            return response()->json([
                'message' => 'Data naskah keluar berhasil diambil.',
                'data' => $naskahKeluar
            ]);
        } catch (\Exception $e) {
            // Handle any errors and return error response
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data naskah keluar.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_naskah'     => 'required|unique:naskah_keluars,no_naskah',
            'jenis_naskah'  => 'required|string',
            'perihal'       => 'required|string',
            'asal_naskah'   => 'required|string',
            'tujuan'        => 'required|string',
            'file'          => 'required|mimes:doc,docx,pdf|max:10240',
            'tgl_naskah'    => 'required|date',
        ], [
            'no_naskah.required'   => 'Nomor naskah harus diisi.',
            'no_naskah.unique'     => 'Nomor naskah sudah ada.',
            'jenis_naskah.required'=> 'Jenis naskah harus diisi.',
            'perihal.required'     => 'Perihal harus diisi.',
            'asal_naskah.required' => 'Asal naskah harus diisi.',
            'tujuan.required'      => 'Tujuan harus diisi.',
            'file.required'        => 'File naskah harus diunggah.',
            'file.mimes'           => 'Hanya file dengan ekstensi .doc, .docx, dan .pdf yang diperbolehkan.',
            'file.max'             => 'File tidak boleh lebih dari 10MB.',
            'tgl_naskah.required'  => 'Tanggal naskah harus diisi.',
            'tgl_naskah.date'      => 'Tanggal naskah tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validasi gagal',
                'messages' => $validator->errors()
            ], 400);
        }

        try {
            $file = $request->file('file');
            $fileName = $request->no_naskah . '-' . str_replace(' ', '_', strtolower($request->perihal)) . '.' . $file->getClientOriginalExtension();
            $path = 'naskah_keluar/' . $request->jenis_naskah . '/' . now()->year . '/' . now()->month . '/' . now()->day;
            $filePath = $file->storeAs($path, $fileName, 'public');

            // Identifying the user making the request
            $idPengguna = null;
            if (auth()->user() instanceof Admin) {
                $idPengguna = auth()->user()->nip;
            } elseif (auth()->user() instanceof Pegawai) {
                $idPengguna = auth()->user()->nip;
            }

            if($request->tujuan=='kadis'){
                $naskahKeluar = NaskahKeluar::create([
                    'id_pengguna'   => $idPengguna,
                    'no_naskah'     => $request->no_naskah,
                    'jenis_naskah'  => $request->jenis_naskah,
                    'perihal'       => $request->perihal,
                    'tujuan'        => $request->tujuan,
                    'asal_naskah'   => $request->asal_naskah,
                    'file'          => $filePath,
                    'tgl_naskah'    => $request->tgl_naskah,
                    'status'        => 'Menunggu Validasi',
                    'is_valid'      => null,
                    'catatan'       => null,
                    'updated_by'    => null,
                ]);
            }else{
                $naskahKeluar = NaskahKeluar::create([
                    'id_pengguna'   => $idPengguna,
                    'no_naskah'     => $request->no_naskah,
                    'jenis_naskah'  => $request->jenis_naskah,
                    'asal_naskah'   => $request->asal_naskah,
                    'perihal'       => $request->perihal,
                    'tujuan'        => $request->tujuan,
                    'file'          => $filePath,
                    'tgl_naskah'    => $request->tgl_naskah,
                    'status'        => 'Diproses',
                    'is_valid'      => null,
                    'catatan'       => null,
                    'updated_by'    => null,
                ]);
            }
            return response()->json([
                'message' => 'Naskah keluar berhasil disimpan.',
                'data' => $naskahKeluar
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan data.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input dari request
            $validatedData = $request->validate([
                'jenis_naskah' => 'sometimes|string|max:255',
                'perihal' => 'sometimes|string|max:255',
                'asal_naskah' => 'sometimes|string|max:255', // Menambahkan asal naskah
                'tujuan' => 'sometimes|string|max:255',
                'tgl_naskah' => 'sometimes|date',
                'status' => 'sometimes|in:Menunggu Validasi,Diterima,Ditolak,Diproses',
                'file' => 'nullable|mimes:doc,docx,pdf|max:2048',
            ], [
                'jenis_naskah.required' => 'Jenis naskah wajib diisi.',
                'perihal.required' => 'Perihal wajib diisi.',
                'asal_naskah.required' => 'Asal naskah wajib diisi.',
                'tujuan.required' => 'Tujuan wajib diisi.',
                'tgl_naskah.required' => 'Tanggal naskah wajib diisi.',
                'status.required' => 'Status wajib diisi.',
                'file.mimes' => 'File harus berupa dokumen dengan format doc, docx, atau pdf.',
                'file.max' => 'Ukuran file maksimal 2MB.',
            ]);
            
            // Mencari NaskahKeluar berdasarkan ID
            $naskahKeluar = NaskahKeluar::where('id_naskah_keluar', $id)->firstOrFail();
            
            // Mengganti file jika ada file yang diunggah
            if ($request->hasFile('file')) {
                // Menghapus file lama jika ada
                if ($naskahKeluar->file) {
                    Storage::disk('public')->delete($naskahKeluar->file);
                }
                
                // Mengunggah file baru
                $file = $request->file('file');
                $fileName = $naskahKeluar->no_naskah . '-' . str_replace(' ', '_', strtolower($request->perihal)) . '.' . $file->getClientOriginalExtension();
                $path = 'naskah_keluar/' . $request->jenis_naskah . '/' . now()->year . '/' . now()->month . '/' . now()->day;
                $filePath = $file->storeAs($path, $fileName, 'public');
                $validatedData['file'] = $filePath;
            }
            
            // Menentukan status berdasarkan tujuan
            if ($naskahKeluar->tujuan == 'kadis') {
                $validatedData['status'] = 'Menunggu Validasi';
            } else {
                $validatedData['status'] = 'Diproses';
            }
            
            // Memperbarui data NaskahKeluar
            $naskahKeluar->update($validatedData);
            
            return response()->json([
                'message' => 'Data naskah keluar berhasil diperbarui.',
                'data' => $naskahKeluar,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data naskah keluar tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui data naskah keluar.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            // Mencari NaskahKeluar berdasarkan ID
            $naskahKeluar = NaskahKeluar::where('id_naskah_keluar', $request->id_naskah_keluar)->firstOrFail();
            
            // Jika is_valid adalah true
            if ($request->is_valid || $request->is_valid == 'true') {
                // Update status naskah keluar menjadi Diproses dan catatan
                $naskahKeluar->update([
                    "is_valid" => true,
                    "catatan" => $request->catatan,
                    "updated_by" => $request->user->nip,
                    "status" => "Diproses"
                ]);
                
                // Menyiapkan pesan untuk WhatsApp
                $phoneNumber = env('WHATSAPP_PHONE_NUMBER'); 
                $message = urlencode(
                    "*Naskah Keluar:* #{$naskahKeluar->no_naskah}\n" .  
                    "*Status:* {$naskahKeluar->status}\n" .               
                    "*Catatan:* {$naskahKeluar->catatan}"            
                );
                $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$message}";
            } 
    
            // Jika is_valid adalah false
            if (!$request->is_valid || $request->is_valid == 'false') {
                // Update status naskah keluar menjadi Ditolak dan catatan
                $naskahKeluar->update([
                    "is_valid" => false,
                    "catatan" => $request->catatan,
                    "updated_by" => $request->user->nip,
                    "status" => "Ditolak"
                ]);
        
                // Menyiapkan pesan untuk WhatsApp
                $phoneNumber = env('WHATSAPP_PHONE_NUMBER'); 
                $message = urlencode(
                    "*Naskah Keluar:* #{$naskahKeluar->no_naskah}\n" .  
                    "*Status:* {$naskahKeluar->status}\n" .               
                    "*Catatan:* {$naskahKeluar->catatan}"            
                );
                $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$message}";
            }
            
            return response()->json([
                'whatsapp_url' => $whatsappUrl,
                "status_code" => 200,
                "status" => "sukses"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses permintaan.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal'
            ], 500);
        }
    }
    
    public function accepet(Request $request)
    {
        try {
            $naskahKeluar = NaskahKeluar::where('id_naskah_keluar', $request->id_naskah_keluar)->firstOrFail();
            
            // Memeriksa status naskah keluar apakah 'Diproses'
            if ($naskahKeluar->status == 'Diproses') {
                // Update status naskah keluar menjadi 'Diterima'
                $naskahKeluar->update([
                    "status" => "Diterima"
                ]);
            }

            return response()->json([
                'message' => "Naskah berhasil diterima",
                "status_code" => 200,
                "status" => "sukses"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses permintaan.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal'
            ], 500);
        }
    }

    public function destroy($id)
{
    try {
        $naskahKeluar = NaskahKeluar::where('id_naskah_keluar', $id)->firstOrFail();

        // Menghapus file jika ada
        if ($naskahKeluar->file) {
            Storage::disk('public')->delete($naskahKeluar->file);
        }

        // Menghapus data naskah keluar
        $naskahKeluar->delete();

        return response()->json([
            'message' => 'Data naskah keluar berhasil dihapus.',
            'status_code' => 200,
            'status' => 'sukses'
        ], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Data naskah keluar tidak ditemukan.',
            'error' => $e->getMessage(),
            'status_code' => 404,
            'status' => 'gagal'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat menghapus data naskah keluar.',
            'error' => $e->getMessage(),
            'status_code' => 500,
            'status' => 'gagal'
        ], 500);
    }
}

public function show($id)
{
    try {
        $naskahKeluar = NaskahKeluar::findOrFail($id);

        return response()->json([
            'message' => 'Data naskah keluar berhasil ditemukan.',
            'data' => $naskahKeluar,
            'status_code' => 200,
            'status' => 'sukses'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Data naskah keluar tidak ditemukan.',
            'error' => $e->getMessage(),
            'status_code' => 404,
            'status' => 'gagal'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memproses permintaan.',
            'error' => $e->getMessage(),
            'status_code' => 500,
            'status' => 'gagal'
        ], 500);
    }
}

public function downloadFile($id)
{
    try {
        // Mencari data naskah keluar berdasarkan ID
        $naskahKeluar = NaskahKeluar::findOrFail($id);

        // Memeriksa apakah file ada
        if (!Storage::disk('public')->exists($naskahKeluar->file)) {
            return response()->json([
                'message' => 'File tidak ditemukan.',
                'status_code' => 404,
                'status' => 'gagal'
            ], 404);
        }

        // Mendownload file
        return Storage::disk('public')->download($naskahKeluar->file);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Data naskah keluar tidak ditemukan.',
            'error' => $e->getMessage(),
            'status_code' => 404,
            'status' => 'gagal'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memproses permintaan.',
            'error' => $e->getMessage(),
            'status_code' => 500,
            'status' => 'gagal'
        ], 500);
    }
}

}
