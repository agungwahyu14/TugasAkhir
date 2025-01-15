<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\PathArsip;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class FolderController extends Controller
{
    /**
     * Tampilkan semua folder dan subfolder (opsional: folder root saja).
     */
    public function index()
    {
        // Retrieve all folders
        $folders = Folder::all();
    
        // Create an associative array with the parent_id as key
        $grouped = $folders->groupBy('parent_id');
    
        // Now we want to form the tree structure, starting with top-level folders
        $foldersTree = $this->buildFolderTree($grouped, null);
    
        return response()->json($foldersTree);
    }
    
    private function buildFolderTree($grouped, $parentId)
    {
        $folders = isset($grouped[$parentId]) ? $grouped[$parentId] : [];
    
        foreach ($folders as &$folder) {
            // Recursively build the tree for children
            $folder->children = $this->buildFolderTree($grouped, $folder->id);
        }
    
        return $folders;
    }
    
    

    /**
     * Tampilkan isi folder tertentu (subfolder dan arsip).
     */
    public function show($id)
    {
        $folder = Folder::with(['children', 'arsips', 'files'])->findOrFail($id);
        return response()->json($folder);
    }

    /**
     * Buat folder baru.
     */
    public function store(Request $request)
    {
        // Validasi input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id', // ID folder induk
            'path_arsip_id' => 'nullable|exists:path_arsips,id', // ID path arsip (jika folder terkait dengan path arsip)
        ]);
    
        // Jika validasi gagal, kembalikan respons JSON dengan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat folder baru
            $folder = Folder::create([
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id'),
            ]);
    
            // Jika folder terkait dengan path arsip, hubungkan folder ke path arsip
            if ($request->has('path_arsip_id')) {
                $pathArsip = PathArsip::findOrFail($request->input('path_arsip_id'));
                $pathArsip->folders()->attach($folder->id);
            }
    
            // Kembalikan respons sukses
            return response()->json([
                'message' => 'Folder berhasil dibuat.',
                'folder' => $folder,
            ], 201);
    
        } catch (\Exception $e) {
            // Menangani kesalahan lainnya
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat folder: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unggah file ke folder tertentu.
     */
    public function uploadFile(Request $request, $folderId)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:2048', // Maksimal 2MB
        ]);
    
        // Jika validasi gagal, kembalikan respons JSON dengan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            // Temukan folder berdasarkan ID
            $folder = Folder::findOrFail($folderId);
    
            // Simpan file ke subdirektori berdasarkan nama folder
            $filePath = $request->file('file')->store('files/' . $folder->name, 'public');
    
            // Buat data file baru untuk file yang di-upload
            $file = File::create([
                'name' => $request->file('file')->getClientOriginalName(),
                'extension' => $request->file('file')->getClientOriginalExtension(),
                'size' => $request->file('file')->getSize(),
                'path' => $filePath,
                'folder_id' => $folder->id,
            ]);
    
            // Kembalikan respons sukses
            return response()->json([
                'message' => 'File berhasil diunggah.',
                'file' => $file,
                'file_path' => $filePath,
            ], 201);
    
        } catch (ModelNotFoundException $e) {
            // Menangani jika folder tidak ditemukan
            return response()->json([
                'message' => 'Folder tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            // Menangani kesalahan lainnya (seperti kesalahan saat penyimpanan file)
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengunggah file: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Menghapus folder beserta file terkait.
     */
    public function destroy($id)
    {
        // Mencari folder berdasarkan ID
        $folder = Folder::findOrFail($id);

        // Menghapus folder beserta subfolder dan arsipnya (Jika ada)
        // Menggunakan soft delete jika folder memiliki relasi, atau force delete jika ingin menghapus langsung
        $folder->delete(); // jika menggunakan soft delete
        // $folder->forceDelete(); // jika ingin menghapus secara permanen

        return response()->json([
            'message' => 'Folder berhasil dihapus.',
        ]);
    }

    /**
     * Menghapus file dari folder.
     */
    public function destroyFile($folderId, $fileId)
    {
        // Cari folder berdasarkan ID
        $folder = Folder::findOrFail($folderId);

        // Cari file berdasarkan ID
        $file = File::where('folder_id', $folderId)->findOrFail($fileId);

        // Hapus file dari penyimpanan (disk)
        if (\Storage::exists('public/' . $file->path)) {
            \Storage::delete('public/' . $file->path);
        }

        // Hapus data file dari database
        $file->delete();

        return response()->json([
            'message' => 'File berhasil dihapus dari folder.',
        ]);
    }

    /**
     * Menghapus folder dan file terkait (tidak hanya soft delete).
     */
    public function forceDelete($id)
    {
        // Mencari folder berdasarkan ID
        $folder = Folder::findOrFail($id);

        // Menghapus file terkait sebelum menghapus folder
        foreach ($folder->files as $file) {
            if (\Storage::exists('public/' . $file->path)) {
                \Storage::delete('public/' . $file->path);
            }
            $file->delete();
        }

        // Menghapus folder beserta subfolder dan arsipnya
        $folder->forceDelete();

        return response()->json([
            'message' => 'Folder dan file terkait berhasil dihapus.',
        ]);
    }

    public function attachArsipToFolder($folderId, $pathArsipId)
    {
        try {
            // Fetch the folder and PathArsip from the database
            $folder = Folder::findOrFail($folderId);
            $pathArsip = PathArsip::findOrFail($pathArsipId);
            if ($folder->parent_id) {
                // If the folder has a parent, find the parent folder and attach PathArsip to the parent folder only
                $parentFolder = Folder::findOrFail($folder->parent_id);
                $parentFolder->arsips()->attach($pathArsip->id);
            } else {
                // If there's no parent folder, attach PathArsip to the current folder
                $folder->arsips()->attach($pathArsip->id);
            }
    
            // Return success response
            return response()->json([
                'message' => 'Folder berhasil dihubungkan dengan PathArsip',
            ]);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'message' => 'Gagal menghubungkan Folder dengan PathArsip',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    

    /**
     * Menghapus hubungan Folder dengan PathArsip
     */
    public function detachArsipFromFolder($folderId, $pathArsipId)
    {
        try {
            $folder = Folder::findOrFail($folderId);
            $pathArsip = PathArsip::findOrFail($pathArsipId);

            // Menghapus hubungan antara Folder dan PathArsip
            $folder->arsips()->detach($pathArsip->id);

            return response()->json([
                'message' => 'Hubungan Folder dengan PathArsip berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus hubungan Folder dengan PathArsip',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
