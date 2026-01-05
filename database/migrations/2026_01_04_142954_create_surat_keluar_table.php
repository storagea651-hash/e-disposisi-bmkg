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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('tujuan_surat');
            $table->date('tanggal_surat');
            $table->enum('sifat', ['Sangat Segera', 'Segera', 'Rahasia']);
            $table->text('perihal');
            $table->string('file_surat')->nullable(); // untuk upload file surat (PDF)
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuk')->onDelete('set null'); // relasi jika surat keluar merupakan balasan dari surat masuk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};