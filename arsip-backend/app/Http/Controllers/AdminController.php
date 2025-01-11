<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar Admin.
     */
    public function index()
    {
        try {
            $admins = Admin::where('status','aktif')->get();
            return $this->templateRESPONSEAPI(true, 'Data Admin berhasil ditemukan.', $admins, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal mengambil data Admin.', null, 500, true);
        }
    }

    /**
     * Menambahkan Admin baru.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'nip' => 'required|integer|unique:admins,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email|unique:pegawais,email',
            'password' => 'required|string|min:6',
            'username' => 'required|string|max:255|unique:admins,username',
            'bidang' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.integer' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'id_admin.required' => 'ID Admin wajib diisi.',
            'id_admin.integer' => 'ID Admin harus berupa angka.',
            'id_admin.unique' => 'ID Admin sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'bidang.required' => 'Bidang wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus salah satu dari: aktif, tidak aktif.',
        ]);

        if ($validator->fails()) {
            return $this->templateRESPONSEAPI(false, 'Data tidak valid.', $validator->errors(), 422, true);
        }

        try {
            $lastIdAdmin = Admin::max('id_admin');
            $newIdAdmin = $lastIdAdmin ? $lastIdAdmin + 1 : 1;

            $admin = Admin::create([
                'nip' => $request->nip,
                'id_admin' => $newIdAdmin,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'username' => $request->username,
                'bidang' => $request->bidang,
                'status' => $request->status,
            ]);

            return $this->templateRESPONSEAPI(true, 'Admin berhasil ditambahkan.', $admin, 201);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal menambahkan Admin.', null, 500, true);
        }
    }

    /**
     * Menampilkan detail Admin berdasarkan ID.
     */
    public function show($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            return $this->templateRESPONSEAPI(true, 'Admin ditemukan.', $admin, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Admin tidak ditemukan.', null, 404, true);
        }
    }

    /**
     * Mengubah data Admin berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|integer|unique:admins,nip,' . $id,
            'id_admin' => 'required|integer|unique:admins,id_admin,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id . '|unique:pegawais,email',
            'password' => 'nullable|string|min:6',
            'username' => 'required|string|max:255|unique:admins,username,' . $id,
            'bidang' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.integer' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'id_admin.required' => 'ID Admin wajib diisi.',
            'id_admin.integer' => 'ID Admin harus berupa angka.',
            'id_admin.unique' => 'ID Admin sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'bidang.required' => 'Bidang wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus salah satu dari: aktif, tidak aktif.',
        ]);

        if ($validator->fails()) {
            return $this->templateRESPONSEAPI(false, 'Data tidak valid.', $validator->errors(), 422, true);
        }

        try {
            $admin = Admin::findOrFail($id);
            $admin->update([
                'nip' => $request->nip,
                'id_admin' => $request->id_admin,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->has('password') ? bcrypt($request->password) : $admin->password,
                'username' => $request->username,
                'bidang' => $request->bidang,
                'status' => $request->status,
            ]);

            return $this->templateRESPONSEAPI(true, 'Admin berhasil diperbarui.', $admin, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal memperbarui Admin.', null, 500, true);
        }
    }

    /**
     * Menghapus Admin (Menonaktifkan Admin dengan mengubah status).
     */
    public function deactivate($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->status = 'tidak aktif';
            $admin->save();

            return $this->templateRESPONSEAPI(true, 'Admin berhasil dinonaktifkan.', $admin, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal menonaktifkan Admin.', null, 500, true);
        }
    }

    /**
     * Mengaktifkan kembali Admin.
     */
    public function activate($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->status = 'aktif';
            $admin->save();

            return $this->templateRESPONSEAPI(true, 'Admin berhasil diaktifkan.', $admin, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal mengaktifkan Admin.', null, 500, true);
        }
    }

    /**
     * Menghapus Admin secara permanen.
     */
    public function destroy($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();

            return $this->templateRESPONSEAPI(true, 'Admin berhasil dihapus.', null, 200);
        } catch (Exception $e) {
            return $this->templateRESPONSEAPI(false, 'Gagal menghapus Admin.', null, 500, true);
        }
    }
}
