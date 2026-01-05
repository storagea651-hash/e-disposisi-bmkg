<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use App\Models\User;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pimpinan = User::where('role', 'pimpinan')->first();

        // Create 10 Surat Masuk
        for ($i = 1; $i <= 10; $i++) {
            $surat = SuratMasuk::create([
                'nomor_surat' => 'SM/2026/' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'surat_dari' => $this->getRandomSender(),
                'tanggal_surat' => now()->subDays(rand(1, 30)),
                'diterima_tanggal' => now()->subDays(rand(0, 25)),
                'no_agenda' => 'AG-2026-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'sifat' => $this->getRandomSifat(),
                'perihal' => $this->getRandomPerihal(),
            ]);

            // Create disposisi for some surat (70% chance)
            if (rand(1, 10) <= 7) {
                Disposisi::create([
                    'surat_masuk_id' => $surat->id,
                    'user_id' => $pimpinan->id,
                    'tujuan_disposisi' => $this->getRandomTujuan(),
                    'catatan_disposisi' => $this->getRandomCatatan(),
                    'tanggal_disposisi' => now()->subDays(rand(0, 20)),
                    'status' => $this->getRandomStatus(),
                ]);
            }
        }

        // Create 5 Surat Keluar
        for ($i = 1; $i <= 5; $i++) {
            SuratKeluar::create([
                'nomor_surat' => 'SK/2026/' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tujuan_surat' => $this->getRandomTujuanSurat(),
                'tanggal_surat' => now()->subDays(rand(1, 30)),
                'sifat' => $this->getRandomSifat(),
                'perihal' => $this->getRandomPerihal(),
                'surat_masuk_id' => rand(1, 3) == 1 ? rand(1, 5) : null,
            ]);
        }

        echo "✅ Dummy data berhasil dibuat!\n";
        echo "- 10 Surat Masuk\n";
        echo "- ~7 Disposisi\n";
        echo "- 5 Surat Keluar\n";
    }

    private function getRandomSender()
    {
        $senders = [
            'Kementerian Dalam Negeri',
            'Kementerian Keuangan',
            'Badan Pusat Statistik',
            'BPPT',
            'Kementerian ESDM',
            'Kementerian Perhubungan',
            'LAPAN',
            'Gubernur Kalimantan Timur',
        ];
        return $senders[array_rand($senders)];
    }

    private function getRandomSifat()
    {
        $sifat = ['Sangat Segera', 'Segera', 'Rahasia'];
        return $sifat[array_rand($sifat)];
    }

    private function getRandomPerihal()
    {
        $perihal = [
            'Laporan Cuaca Ekstrem Wilayah Kalimantan',
            'Permohonan Data Klimatologi Tahun 2025',
            'Undangan Rapat Koordinasi Nasional',
            'Permintaan Informasi Gempa Bumi',
            'Laporan Hasil Analisis Kualitas Udara',
            'Permohonan Kerjasama Penelitian',
            'Pengajuan Anggaran Tahun 2026',
            'Laporan Bencana Alam dan Mitigasi',
        ];
        return $perihal[array_rand($perihal)];
    }

    private function getRandomTujuan()
    {
        $tujuan = [
            'Kepala Bidang Klimatologi',
            'Kepala Seksi Data dan Informasi',
            'Kepala Bagian Umum',
            'Kepala Stasiun Meteorologi',
            'Koordinator Pelayanan Jasa',
        ];
        return $tujuan[array_rand($tujuan)];
    }

    private function getRandomCatatan()
    {
        $catatan = [
            'Mohon segera ditindaklanjuti',
            'Untuk dipelajari dan dilaporkan',
            'Koordinasikan dengan bagian terkait',
            'Mohon segera disiapkan laporan',
            'Untuk diketahui dan ditindaklanjuti',
        ];
        return $catatan[array_rand($catatan)];
    }

    private function getRandomStatus()
    {
        $status = ['Belum Selesai', 'Sedang Diproses', 'Selesai'];
        return $status[array_rand($status)];
    }

    private function getRandomTujuanSurat()
    {
        $tujuan = [
            'Kementerian Dalam Negeri',
            'Badan Nasional Penanggulangan Bencana',
            'Gubernur Kalimantan Timur',
            'Walikota Balikpapan',
            'BPPT Jakarta',
        ];
        return $tujuan[array_rand($tujuan)];
    }
}