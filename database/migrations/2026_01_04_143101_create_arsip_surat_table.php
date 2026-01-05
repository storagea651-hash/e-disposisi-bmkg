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
        Schema::create('arsip_surat', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_surat', ['Surat Masuk', 'Surat Keluar']);
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluar')->onDelete('cascade');
            $table->date('tanggal_arsip');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_surat');
    }
};