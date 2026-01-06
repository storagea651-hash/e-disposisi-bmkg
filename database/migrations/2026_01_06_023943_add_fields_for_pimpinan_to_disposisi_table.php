<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // field baru untuk pimpinan (checkbox multi disimpan sebagai JSON)
            $table->enum('sifat', ['Sangat Segera', 'Segera', 'Rahasia'])->nullable()->after('tanggal_disposisi');

            $table->json('diteruskan_kepada')->nullable()->after('sifat');
            $table->json('dengan_hormat_harap')->nullable()->after('diteruskan_kepada');

            // optional: biar konsisten dengan nama lama, kamu bisa tetap pakai catatan_disposisi
            // jadi tidak perlu kolom catatan baru.
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropColumn(['sifat', 'diteruskan_kepada', 'dengan_hormat_harap']);
        });
    }
};
