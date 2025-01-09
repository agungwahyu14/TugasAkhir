<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller 
{
    /**
     * Fungsi untuk merespons API dengan format standar.
     *
     * @param bool $success Status operasi (true/false)
     * @param string $message Pesan yang ingin ditampilkan
     * @param mixed $data Data yang ingin dikirimkan dalam response (optional)
     * @param int $status HTTP status code (default: 200)
     * @param bool $error Menentukan apakah ada error atau tidak (default: false)
     * @return JsonResponse
     */
    public function templateRESPONSEAPI(bool $success, string $message, $data = null, int $status = 200, bool $error = false): JsonResponse
    {
        // Struktur response API standar
        $response = [
            'status_code' => $status,   // Status HTTP code
            'status' => $success ? 'sukses' : 'gagal',  // Status: sukses/gagal
            'message' => $message,      // Pesan yang ingin ditampilkan
            'data' => $data,            // Data yang ingin dikirimkan (jika ada)
            'error' => $error           // Menunjukkan apakah terjadi error
        ];

        // Jika status bukan 200, tambahkan ke dalam response
        if ($status !== 200) {
            $response['status_code'] = $status;
        }

        return response()->json($response, $status);
    }
}
