<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk Folder
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama folder
            $table->foreignId('parent_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel untuk Arsip (path_arsips) yang bisa memiliki banyak folder
        Schema::create('path_arsips', function (Blueprint $table) {
            $table->id();
            $table->string('nama_berkas'); // Nama file
            $table->string('no_berkas'); // Nomor berkas
            $table->string('perihal')->nullable(); // Perihal
            $table->integer('jml_item')->nullable(); // Jumlah item
            $table->date('retensi_waktu'); // Retensi waktu
            $table->timestamps();
        });

        // Tabel pivot untuk hubungan banyak-ke-banyak antara arsip dan folder
        Schema::create('folder_path_arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('folders')->onDelete('cascade');
            $table->foreignId('path_arsip_id')->constrained('path_arsips')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel untuk Files yang terhubung dengan folder
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama file
            $table->string('extension'); // Ekstensi file
            $table->bigInteger('size'); // Ukuran file dalam byte
            $table->string('path'); // Path lokasi file di server
            $table->foreignId('folder_id')->constrained('folders')->onDelete('cascade'); // Relasi ke tabel folders
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_path_arsip');
        Schema::dropIfExists('files');
        Schema::dropIfExists('path_arsips');
        Schema::dropIfExists('folders');
    }
};
