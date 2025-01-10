<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    // Store new Pegawai
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'nip' => 'required|integer|unique:pegawais,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawais,email|unique:admins,email',
            'password' => 'required|string|min:6',
            'username' => 'required|string|max:255|unique:pegawais,username',
            'bidang' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.integer' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'bidang.required' => 'bidang wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus salah satu dari: aktif, tidak aktif.',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return $this->templateRESPONSEAPI(false, 'Data tidak valid.', $validator->errors(), 422, true);
        }

        try {
            $lastIdAdmin = Admin::max('id_admin');
            $newIdAdmin = $lastIdAdmin ? $lastIdAdmin + 1 : 1;
            // Create the new Pegawai
            $pegawai = Pegawai::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'id_admin'=>$newIdAdmin,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'username' => $request->username,
                'bidang' => $request->bidang,
                'status' => $request->status,
            ]);

            // Return success response
            return $this->templateRESPONSEAPI(true, 'Pegawai berhasil ditambahkan.', $pegawai, 201);
        } catch (Exception $e) {
            // Return error response
            return $this->templateRESPONSEAPI(false, 'Gagal menambahkan Pegawai.', null, 500, true);
        }
    }

    // Update existing Pegawai
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'nip' => 'required|integer|unique:pegawai,nip,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawais,email,' . $id . '|unique:admins,email',
            'username' => 'required|string|max:255|unique:pegawai,username,' . $id,
            'bidang' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.integer' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'bidang.required' => 'bidang wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus salah satu dari: aktif, tidak aktif.',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return $this->templateRESPONSEAPI(false, 'Data tidak valid.', $validator->errors(), 422, true);
        }

        try {
            // Find the Pegawai by ID
            $pegawai = Pegawai::findOrFail($id);

            // Update Pegawai details
            $pegawai->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'bidang' => $request->jabatan,
                'status' => $request->status,
            ]);

            // Return success response
            return $this->templateRESPONSEAPI(true, 'Pegawai berhasil diperbarui.', $pegawai, 200);
        } catch (Exception $e) {
            // Return error response
            return $this->templateRESPONSEAPI(false, 'Gagal memperbarui Pegawai.', null, 500, true);
        }
    }

    // Delete Pegawai
    public function destroy($id)
    {
        try {
            // Find the Pegawai by ID and delete
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();

            // Return success response
            return $this->templateRESPONSEAPI(true, 'Pegawai berhasil dihapus.', null, 200);
        } catch (Exception $e) {
            // Return error response
            return $this->templateRESPONSEAPI(false, 'Gagal menghapus Pegawai.', null, 500, true);
        }
    }

    // Fetch all Pegawai
    public function index()
    {
        try {
            $pegawais = Pegawai::all();
            return $this->templateRESPONSEAPI(true, 'Data Pegawai ditemukan.', $pegawais, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal mengambil data Pegawai.', null, 500, true);
        }
    }

    // Fetch a single Pegawai
    public function show($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            return $this->templateRESPONSEAPI(true, 'Data Pegawai ditemukan.', $pegawai, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Data Pegawai tidak ditemukan.', null, 404, true);
        }
    }

        /**
     * Menghapus Pegawai (Menonaktifkan Pegawai dengan mengubah status).
     */
    public function deactivate($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->status = 'tidak aktif';
            $pegawai->save();

            return $this->templateRESPONSEAPI(true, 'Pegawai berhasil dinonaktifkan.', $pegawai, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal menonaktifkan Pegawai.', null, 500, true);
        }
    }

    /**
     * Mengaktifkan kembali Pegawai.
     */
    public function activate($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->status = 'aktif';
            $pegawai->save();

            return $this->templateRESPONSEAPI(true, 'Pegawai berhasil diaktifkan.', $pegawai, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal mengaktifkan Pegawai.', null, 500, true);
        }
    }
}
