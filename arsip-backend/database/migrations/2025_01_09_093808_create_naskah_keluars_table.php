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
        Schema::create('naskah_keluars', function (Blueprint $table) {
            $table->id('id_naskah_keluar');
            $table->integer('id_pengguna')->index()->nullable();
            $table->integer('no_naskah')->unique()->index();
            $table->string('jenis_naskah')->index();
            $table->string('perihal')->index();
            $table->string('asal_naskah')->index();
            $table->string('tujuan')->index(); 
            $table->string('file')->index(); 
            $table->date('tgl_naskah');
            $table->enum('status', ['Menunggu Validasi', 'Diterima', 'Ditolak','Diproses'])->index();
            $table->boolean('is_valid')->nullable()->index();
            $table->text('catatan')->nullable(); 
            $table->integer('updated_by')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskah_keluars');
    }
};
