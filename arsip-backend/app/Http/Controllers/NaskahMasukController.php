<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pegawai;
use App\Models\NaskahMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NaskahMasukController extends Controller
{

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10); 
            $search = $request->query('search', ''); 
            $filter = $request->query('filter', '');  
            $tglNaskah = $request->query('tgl_naskah', ''); 
            $query = NaskahMasuk::orderBy('tgl_naskah', 'desc');
            
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_naskah', 'like', "%{$search}%")
                      ->orWhere('jenis_naskah', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%");
                });
            }
    
            if ($filter) {
                $query->where('status', $filter);
            }
            if ($tglNaskah) {
                $query->whereDate('tgl_naskah', '=', $tglNaskah);
            }
            $naskahMasuk = $query->paginate($perPage);
            return response()->json([
                'message' => 'Data naskah masuk berhasil diambil.',
                'data' => $naskahMasuk
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data naskah masuk.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_naskah'     => 'required|unique:naskah_masuks,no_naskah',
            'jenis_naskah'  => 'required|string',
            'perihal'       => 'required|string',
            'tujuan'        => 'required|string',
            'file'          => 'required|mimes:doc,docx,pdf|max:10240', 
            'tgl_naskah'    => 'required|date',
        ], [
            'no_naskah.required'   => 'Nomor naskah harus diisi.',
            'no_naskah.unique'     => 'Nomor naskah sudah ada.',
            'jenis_naskah.required'=> 'Jenis naskah harus diisi.',
            'perihal.required'     => 'Perihal harus diisi.',
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
            $path = 'naskah_masuk/' . $request->jenis_naskah . '/' . now()->year . '/' . now()->month . '/' . now()->day;
            $filePath = $file->storeAs($path, $fileName, 'public');
            $idPengguna = null;
            if (auth()->user() instanceof Admin) {
                $idPengguna = auth()->user()->nip; 
            } elseif (auth()->user() instanceof Pegawai) {
                $idPengguna = auth()->user()->nip; 
            }
            
            if($request->tujuan=='kadis'){
                $naskahMasuk = NaskahMasuk::create([
                    'id_pengguna'   => $idPengguna,
                    'no_naskah'     => $request->no_naskah,
                    'jenis_naskah'  => $request->jenis_naskah,
                    'perihal'       => $request->perihal,
                    'tujuan'        => $request->tujuan,
                    'file'          => $filePath,
                    'tgl_naskah'    => $request->tgl_naskah,
                    'status'        => 'Menunggu Validasi',
                    'is_valid'      => null,
                    'catatan'       => null,
                    'updated_by'    => null,
                ]);
            }else{
                $naskahMasuk = NaskahMasuk::create([
                    'id_pengguna'   => $idPengguna,
                    'no_naskah'     => $request->no_naskah,
                    'jenis_naskah'  => $request->jenis_naskah,
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
                'message' => 'Naskah masuk berhasil disimpan.',
                'data' => $naskahMasuk
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
            
            $validatedData = $request->validate([
                'jenis_naskah' => 'required|string|max:255',
                'perihal' => 'required|string|max:255',
                'tujuan' => 'required|string|max:255',
                'tgl_naskah' => 'required|date',
                'status' => 'required|in:Menunggu Validasi,Diterima,Ditolak,Diproses',
                'file' => 'nullable|mimes:doc,docx,pdf|max:2048',
            ], [
                'jenis_naskah.required' => 'Jenis naskah wajib diisi.',
                'perihal.required' => 'Perihal wajib diisi.',
                'tujuan.required' => 'Tujuan wajib diisi.',
                'tgl_naskah.required' =>  'Tanggal naskah wajib diisi.',
                'status.required' => 'Status wajib diisi.',
                'file.mimes' => 'File harus berupa dokumen dengan format doc, docx, atau pdf.',
                'file.max' => 'Ukuran file maksimal 2MB.',
            ]);
    
            
            $naskahMasuk = NaskahMasuk::findOrFail($id);
            if ($request->hasFile('file')) {
                if ($naskahMasuk->file) {
                    Storage::disk('public')->delete($naskahMasuk->file);
                }
                $file = $request->file('file');
                $fileName = $naskahMasuk->no_naskah . '-' . str_replace(' ', '_', strtolower($request->perihal)) . '.' . $file->getClientOriginalExtension();
                $path = 'naskah_masuk/' . $request->jenis_naskah . '/' . now()->year . '/' . now()->month . '/' . now()->day;
                $filePath = $file->storeAs($path, $fileName, 'public');
                $validatedData['file'] = $filePath;
            }
            if($naskah->tujuan=='kadis'){
                $validatedData['status'] = 'Menunggu Validasi';
            }else{
                $validatedData['status'] = 'Diproses';
            }
            $naskahMasuk->update($validatedData);
    
            return response()->json([
                'message' => 'Data naskah masuk berhasil diperbarui.',
                'data' => $naskahMasuk,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data naskah masuk tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui data naskah masuk.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    

}
