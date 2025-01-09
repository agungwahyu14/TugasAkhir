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
        Schema::create('naskah_masuks', function (Blueprint $table) {
            $table->integer('id_naskah_masuk')->unique()->index()->primary();
            $table->integer('id_pengguna')->index();
            $table->integer('no_naskah')->unique()->index();
            $table->string('jenis_naskah')->index();
            $table->string('perihal')->index();
            $table->string('tujuan')->index(); 
            $table->string('file')->index(); 
            $table->date('tgl_naskah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskah_masuks');
    }
};
