<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArsipRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna memiliki izin untuk membuat request ini.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Setujui semua request untuk saat ini
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk request ini.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_berkas' => 'required|string|max:255',
            'no_berkas' => 'required|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'jml_item' => 'nullable|integer',
            'retensi_waktu' => 'required|date',
        ];
    }

    /**
     * Menentukan pesan validasi khusus.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nama_berkas.required' => 'Nama berkas wajib diisi.',
            'nama_berkas.string' => 'Nama berkas harus berupa teks.',
            'nama_berkas.max' => 'Nama berkas tidak boleh lebih dari 255 karakter.',
            
            'no_berkas.required' => 'Nomor berkas wajib diisi.',
            'no_berkas.string' => 'Nomor berkas harus berupa teks.',
            'no_berkas.max' => 'Nomor berkas tidak boleh lebih dari 255 karakter.',
            
            'perihal.string' => 'Perihal harus berupa teks.',
            'perihal.max' => 'Perihal tidak boleh lebih dari 255 karakter.',
            
            'jml_item.integer' => 'Jumlah item harus berupa angka.',
            
            'retensi_waktu.required' => 'Retensi waktu wajib diisi.',
            'retensi_waktu.date' => 'Retensi waktu harus berupa tanggal yang valid.',
        ];
    }
}
