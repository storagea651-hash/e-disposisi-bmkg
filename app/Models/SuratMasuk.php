<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_masuk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_surat',
        'surat_dari',
        'tanggal_surat',
        'diterima_tanggal',
        'no_agenda',
        'sifat',
        'perihal',
        'file_surat',
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
            'diterima_tanggal' => 'date',
        ];
    }

    /**
     * Relasi ke tabel disposisi (One to Many)
     * Satu surat masuk bisa memiliki banyak disposisi
     */
    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke tabel surat_keluar (One to Many)
     * Satu surat masuk bisa menghasilkan banyak surat keluar
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke tabel arsip_surat (One to One)
     * Satu surat masuk memiliki satu arsip
     */
    public function arsip()
    {
        return $this->hasOne(ArsipSurat::class, 'surat_masuk_id');
    }
}