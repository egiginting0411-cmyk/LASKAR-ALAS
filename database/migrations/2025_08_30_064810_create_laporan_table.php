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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sektor');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('uraian_kegiatan');
            $table->string('dokumentasi');
            $table->string('saksi');
            $table->string('petak_hutan');
            $table->enum('status', ['proses', 'divalidasi'])->default('proses');
            $table->string('tanda_tangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
