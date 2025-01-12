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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->integer('nip')->index()->primary();
            $table->string('id_admin', 36)->index()->unique();
            $table->string('nama')->index();
            $table->string('email')->unique()->index();
            $table->string('password');   
            $table->string('username')->unique()->index();   
            $table->string('bidang')->index();   
            $table->enum('status',['aktif','tidak aktif'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
