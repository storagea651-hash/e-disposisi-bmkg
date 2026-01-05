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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // pimpinan yang membuat disposisi
            $table->string('tujuan_disposisi'); // pegawai/unit tujuan
            $table->text('catatan_disposisi');
            $table->date('tanggal_disposisi');
            $table->enum('status', ['Belum Selesai', 'Sedang Diproses', 'Selesai'])->default('Belum Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};