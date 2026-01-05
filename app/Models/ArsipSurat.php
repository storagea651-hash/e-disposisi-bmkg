<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arsip_surat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis_surat',
        'surat_masuk_id',
        'surat_keluar_id',
        'tanggal_arsip',
        'keterangan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_arsip' => 'date',
        ];
    }

    /**
     * Relasi ke tabel surat_masuk (Many to One)
     * Arsip bisa terkait dengan surat masuk
     */
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke tabel surat_keluar (Many to One)
     * Arsip bisa terkait dengan surat keluar
     */
    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }
}