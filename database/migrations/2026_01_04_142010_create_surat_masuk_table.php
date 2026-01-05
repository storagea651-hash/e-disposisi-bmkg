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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('surat_dari');
            $table->date('tanggal_surat');
            $table->date('diterima_tanggal');
            $table->string('no_agenda')->unique();
            $table->enum('sifat', ['Sangat Segera', 'Segera', 'Rahasia']);
            $table->text('perihal');
            $table->string('file_surat')->nullable(); // untuk upload file surat (PDF)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};