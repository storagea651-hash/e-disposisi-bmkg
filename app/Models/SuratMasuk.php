<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'surat_dari',
        'tanggal_surat',
        'diterima_tanggal',
        'no_agenda',
        'perihal',
        'file_surat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'diterima_tanggal' => 'date',
        ];
    }

    /**
     * Relasi ke tabel disposisi (One to One)
     * Satu surat masuk punya satu disposisi pimpinan
     */
    public function disposisi()
    {
        return $this->hasOne(\App\Models\Disposisi::class, 'surat_masuk_id');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_masuk_id');
    }

    public function arsip()
    {
        return $this->hasOne(ArsipSurat::class, 'surat_masuk_id');
    }
}
