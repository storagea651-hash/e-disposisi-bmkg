<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'disposisi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surat_masuk_id',
        'user_id',
        'tujuan_disposisi',
        'catatan_disposisi',
        'tanggal_disposisi',
        'status',

        // ⬇⬇⬇ TAMBAHAN UNTUK PIMPINAN ⬇⬇⬇
        'sifat',
        'diteruskan_kepada',
        'dengan_hormat_harap',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_disposisi' => 'date',

            // ⬇⬇⬇ INI PENTING ⬇⬇⬇
            'diteruskan_kepada' => 'array',
            'dengan_hormat_harap' => 'array',
        ];
    }


    /**
     * Relasi ke tabel surat_masuk (Many to One)
     * Disposisi terkait dengan satu surat masuk
     */
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke tabel users (Many to One)
     * Disposisi dibuat oleh satu user (pimpinan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

