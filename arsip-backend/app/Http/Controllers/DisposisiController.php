<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    /**
     * Menampilkan semua data disposisi.
     */
    public function index(Request $request)
    {
        try {
            // Ambil query parameter dari request
            $search = $request->input('search');
            $perPage = $request->input('per_page', 10); // Default 10 data per halaman
            $filters = $request->only(['jenis_disposisi', 'tujuan']); // Filter berdasarkan kolom tertentu
    
            // Query dasar
            $query = Disposisi::query();
    
            // Tambahkan filter jika ada
            if (!empty($filters)) {
                foreach ($filters as $key => $value) {
                    $query->where($key, $value);
                }
            }
    
            // Tambahkan pencarian jika ada
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('perihal', 'LIKE', "%{$search}%")
                      ->orWhere('isi_disposisi', 'LIKE', "%{$search}%")
                      ->orWhere('tujuan', 'LIKE', "%{$search}%");
                });
            }
    
            // Dapatkan hasil dengan paginasi
            $disposisis = $query->paginate($perPage);
    
            return response()->json([
                'message' => 'Data disposisi berhasil ditemukan.',
                'data' => $disposisis,
                'status_code' => 200,
                'status' => 'sukses',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data disposisi.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal',
            ], 500);
        }
    }
    

    /**
     * Menyimpan data disposisi baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengguna' => 'nullable|integer',
            'jenis_disposisi' => 'required|string|max:100',
            'isi_disposisi' => 'required|string',
            'perihal' => 'required|string|max:150',
            'tujuan' => 'required|string|max:150',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'tgl_waktu' => 'required|date',
        ], [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'file' => ':attribute harus berupa file yang valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
                'status_code' => 422,
                'status' => 'gagal',
            ], 422);
        }

        try {
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('disposisis', 'public');
            }

            $disposisi = Disposisi::create(array_merge(
                $request->only(['id_pengguna', 'jenis_disposisi', 'isi_disposisi', 'perihal', 'tujuan', 'tgl_waktu']),
                ['file' => $filePath]
            ));

            return response()->json([
                'message' => 'Data disposisi berhasil disimpan.',
                'data' => $disposisi,
                'status_code' => 201,
                'status' => 'sukses',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data disposisi.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal',
            ], 500);
        }
    }

    /**
     * Menampilkan detail data disposisi.
     */
    public function show($id)
    {
        try {
            $disposisi = Disposisi::findOrFail($id);

            return response()->json([
                'message' => 'Data disposisi berhasil ditemukan.',
                'data' => $disposisi,
                'status_code' => 200,
                'status' => 'sukses',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data disposisi tidak ditemukan.',
                'error' => $e->getMessage(),
                'status_code' => 404,
                'status' => 'gagal',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data disposisi.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal',
            ], 500);
        }
    }

    /**
     * Menghapus data disposisi.
     */
    public function destroy($id)
    {
        try {
            $disposisi = Disposisi::findOrFail($id);

            if ($disposisi->file && Storage::disk('public')->exists($disposisi->file)) {
                Storage::disk('public')->delete($disposisi->file);
            }

            $disposisi->delete();

            return response()->json([
                'message' => 'Data disposisi berhasil dihapus.',
                'status_code' => 200,
                'status' => 'sukses',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data disposisi tidak ditemukan.',
                'error' => $e->getMessage(),
                'status_code' => 404,
                'status' => 'gagal',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data disposisi.',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'status' => 'gagal',
            ], 500);
        }
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'id_pengguna' => 'nullable|integer',
        'jenis_disposisi' => 'sometimes|string|max:100',
        'isi_disposisi' => 'sometimes|string',
        'perihal' => 'sometimes|string|max:150',
        'tujuan' => 'sometimes|string|max:150',
        'file' => 'nullable|max:2048',
        'tgl_waktu' => 'sometimes|date',
    ], [
        'required' => ':attribute wajib diisi.',
        'integer' => ':attribute harus berupa angka.',
        'string' => ':attribute harus berupa teks.',
        'max' => ':attribute tidak boleh lebih dari :max karakter.',
        'mimes' => ':attribute harus berupa file dengan format: :values.',
        'file' => ':attribute harus berupa file yang valid.',
        'date' => ':attribute harus berupa tanggal yang valid.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors(),
            'status_code' => 422,
            'status' => 'gagal',
        ], 422);
    }

    try {
        $disposisi = Disposisi::findOrFail($id);

        // Handle file upload if exists
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($disposisi->file && Storage::disk('public')->exists($disposisi->file)) {
                Storage::disk('public')->delete($disposisi->file);
            }

            // Store new file
            $filePath = $request->file('file')->store('disposisis', 'public');
            $disposisi->file = $filePath;
        }

        // Update other fields
        $disposisi->update($request->only([
            'id_pengguna',
            'jenis_disposisi',
            'isi_disposisi',
            'perihal',
            'tujuan',
            'tgl_waktu',
        ]));

        return response()->json([
            'message' => 'Data disposisi berhasil diperbarui.',
            'data' => $disposisi,
            'status_code' => 200,
            'status' => 'sukses',
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Data disposisi tidak ditemukan.',
            'error' => $e->getMessage(),
            'status_code' => 404,
            'status' => 'gagal',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memperbarui data disposisi.',
            'error' => $e->getMessage(),
            'status_code' => 500,
            'status' => 'gagal',
        ], 500);
    }
}
}
