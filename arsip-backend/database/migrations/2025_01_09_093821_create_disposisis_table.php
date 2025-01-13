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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id('id_disposisi');
            $table->integer('id_pengguna')->index()->nullable();
            $table->string('jenis_disposisi')->index();
            $table->string('isi_disposisi')->index();
            $table->string('perihal')->index();
            $table->string('tujuan')->index(); 
            $table->string('file')->index(); 
            $table->date('tgl_waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
