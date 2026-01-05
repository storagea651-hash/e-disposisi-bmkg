<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_keluar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_surat',
        'tujuan_surat',
        'tanggal_surat',
        'sifat',
        'perihal',
        'file_surat',
        'surat_masuk_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    /**
     * Relasi ke tabel surat_masuk (Many to One)
     * Surat keluar bisa merupakan balasan dari surat masuk
     */
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke tabel arsip_surat (One to One)
     * Satu surat keluar memiliki satu arsip
     */
    public function arsip()
    {
        return $this->hasOne(ArsipSurat::class, 'surat_keluar_id');
    }
}