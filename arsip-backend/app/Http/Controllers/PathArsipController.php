<?php

namespace App\Http\Controllers;

use App\Models\PathArsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PathArsipController extends Controller
{
    /**
     * Tampilkan semua arsip (opsional: filter berdasarkan folder).
     */
    public function index(Request $request)
    {
        $query = PathArsip::query();

        // Jika ada folder_id pada request, filter berdasarkan folder_id
        if ($request->has('folder_id')) {
            $query->whereHas('folders', function($q) use ($request) {
                $q->where('folders.id', $request->input('folder_id'));
            });
        }

        // Ambil data arsip
        $arsips = $query->get();

        return response()->json([
            'status_code'=>200,
            'status_text'=>'Success',
            'messages'=>"Berhasil Mendapatkan data berkas arsip",
            'data'=>$arsips
        ]);
    }

    /**
     * Buat data arsip tanpa file.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validator = Validator::make($request->all(), [
            'nama_berkas' => 'required|string|max:255',
            'no_berkas' => 'required|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'jml_item' => 'nullable|integer',
            'retensi_waktu' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            // Membuat data arsip baru tanpa file
            $arsip = PathArsip::create([
                'nama_berkas' => $request->input('nama_berkas'),
                'no_berkas' => $request->input('no_berkas'),
                'perihal' => $request->input('perihal'),
                'jml_item' => $request->input('jml_item'),
                'retensi_waktu' => $request->input('retensi_waktu'),
            ]);
    
            return response()->json([
                'message' => 'Data arsip berhasil dibuat.',
                'arsip' => $arsip,
            ], 201);
        } catch (\Exception $e) {
            // Menangani error jika terjadi masalah saat penyimpanan
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat arsip: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update data arsip.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_berkas' => 'sometimes|string|max:255',
            'no_berkas' => 'sometimes|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'jml_item' => 'nullable|integer',
            'retensi_waktu' => 'sometimes|date',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            // Mencari arsip berdasarkan ID, jika tidak ditemukan akan melempar ModelNotFoundException
            $arsip = PathArsip::findOrFail($id);
            
            // Mengupdate data arsip
            $arsip->update($request->only([
                'nama_berkas',
                'no_berkas',
                'perihal',
                'jml_item',
                'retensi_waktu'
            ]));

            return response()->json([
                'message' => 'Data arsip berhasil diperbarui.',
                'arsip' => $arsip,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Arsip tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui arsip: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus arsip berdasarkan ID.
     */
    public function destroy($id)
    {
        try {
            // Mencari arsip berdasarkan ID
            $arsip = PathArsip::findOrFail($id);

            // Menghapus arsip
            $arsip->delete();

            return response()->json([
                'message' => 'Data arsip berhasil dihapus.',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Arsip tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus arsip: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan arsip berdasarkan ID.
     */
    public function show($id)
    {
        try {
            // Mengambil arsip dengan folder dan file yang terkait
            $arsip = PathArsip::with('folders.files')->findOrFail($id);
            
            return response()->json([
                'status_code'=>200,
                'status_text'=>'Success',
                'messages'=>"Berhasil Mendapatkan data berkas arsip",
                'data'=>$arsip
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Arsip tidak ditemukan.',
            ], 404);
        }
    }
    
    
}
