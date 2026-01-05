<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Surat Masuk - {{ $suratMasuk->nomor_surat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border: 3px solid #000;
        }
        
        /* Header */
        .header-row {
            display: table;
            width: 100%;
            border-bottom: 3px solid #000;
        }
        
        .logo-cell {
            display: table-cell;
            width: 140px;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border-right: 3px solid #000;
        }
        
        .logo-box {
            width: 90px;
            height: 90px;
            margin: 0 auto;
            background-color: #e8e8e8;
            border: 2px solid #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14pt;
            color: #666;
        }
        
        .header-text {
            display: table-cell;
            padding: 10px;
            vertical-align: middle;
        }
        
        .header-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            padding: 8px 0;
            border-bottom: 2px solid #000;
        }
        
        .header-subtitle {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            padding: 8px 0;
        }
        
        /* Main Table */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table.main-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            vertical-align: top;
        }
        
        /* Column widths */
        .col-label-left {
            width: 18%;
            background-color: #fff;
        }
        
        .col-value-left {
            width: 32%;
            background-color: #fff;
        }
        
        .col-label-right {
            width: 18%;
            background-color: #fff;
        }
        
        .col-value-right {
            width: 32%;
            background-color: #fff;
        }
        
        /* Sifat checkboxes */
        .sifat-container {
            display: flex;
            gap: 25px;
            margin-top: 5px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        input[type="checkbox"] {
            width: 14px;
            height: 14px;
        }
        
        /* Perihal row */
        .perihal-cell {
            min-height: 80px;
        }
        
        /* Ditujukan row */
        .ditujukan-cell {
            min-height: 100px;
        }
        
        .disposisi-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 15px;
            margin-top: 8px;
        }
        
        .option-item {
            display: flex;
            align-items: flex-start;
            gap: 5px;
        }
        
        /* Catatan row */
        .catatan-row td {
            padding: 0;
        }
        
        .catatan-container {
            display: flex;
            min-height: 140px;
        }
        
        .catatan-left {
            flex: 1;
            padding: 10px;
            border-right: 2px solid #000;
        }
        
        .catatan-right {
            width: 250px;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .signature-box {
            margin-top: 60px;
        }
        
        .signature-name {
            text-decoration: underline;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .signature-nip {
            font-size: 9pt;
        }
        
        /* Print button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #1f2937;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 1000;
            font-weight: bold;
        }
        
        .print-button:hover {
            background-color: #374151;
        }
        
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            
            .no-print {
                display: none;
            }
            
            .container {
                border: 3px solid #000;
            }
            
            @page {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button onclick="window.print()" class="print-button no-print">🖨️ Print / Save as PDF</button>

    <div class="container">
        <!-- Header -->
        <div class="header-row">
            <div class="logo-cell">
                <div class="logo-box">BMKG</div>
            </div>
            <div class="header-text">
                <div class="header-title">STASIUN METEOROLOGI JUWATA TARAKAN</div>
                <div class="header-subtitle">FORM DISPOSISI SURAT</div>
            </div>
        </div>

        <!-- Main Content -->
        <table class="main-table">
            <!-- Row 1: Surat Dari & Diterima tgl -->
            <tr>
                <td class="col-label-left">Surat Dari</td>
                <td class="col-value-left">{{ $suratMasuk->surat_dari }}</td>
                <td class="col-label-right">Diterima tgl:</td>
                <td class="col-value-right">{{ $suratMasuk->diterima_tanggal->format('d/m/Y') }}</td>
            </tr>

            <!-- Row 2: Nomor Surat & No. Agenda -->
            <tr>
                <td class="col-label-left">Nomor Surat</td>
                <td class="col-value-left">{{ $suratMasuk->nomor_surat }}</td>
                <td class="col-label-right">No. Agenda:</td>
                <td class="col-value-right">{{ $suratMasuk->no_agenda }}</td>
            </tr>

            <!-- Row 3: Empty cells & Sifat -->
            <tr>
                <td class="col-label-left"></td>
                <td class="col-value-left"></td>
                <td class="col-label-right">Sifat:</td>
                <td class="col-value-right">
                    <div class="sifat-container">
                        <label class="checkbox-label">
                            <input type="checkbox" {{ $suratMasuk->sifat == 'Sangat Segera' ? 'checked' : '' }}>
                            <span>Sangat segera</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" {{ $suratMasuk->sifat == 'Segera' ? 'checked' : '' }}>
                            <span>Segera</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" {{ $suratMasuk->sifat == 'Rahasia' ? 'checked' : '' }}>
                            <span>Rahasia</span>
                        </label>
                    </div>
                </td>
            </tr>

            <!-- Row 4: Perihal -->
            <tr>
                <td class="col-label-left">Perihal</td>
                <td colspan="3" class="perihal-cell">{{ $suratMasuk->perihal }}</td>
            </tr>

            <!-- Row 5: Ditujukan Kepada Sdr -->
            <tr>
                <td class="col-label-left">Ditujukan Kepada Sdr</td>
                <td colspan="3" class="ditujukan-cell">
                    @if($suratMasuk->disposisi->count() > 0)
                        @php
                            $latestDisposisi = $suratMasuk->disposisi->first();
                            $tujuan = strtolower($latestDisposisi->tujuan_disposisi);
                        @endphp
                        <div class="disposisi-options">
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'tata usaha') || str_contains($tujuan, 'keuangan') || str_contains($tujuan, 'tu') ? 'checked' : '' }}>
                                <span>Petugas Tata Usaha dan Keuangan</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'tanggapan') || str_contains($tujuan, 'saran') ? 'checked' : '' }}>
                                <span>Memberi Tanggapan / Saran</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'ppk') ? 'checked' : '' }}>
                                <span>PPK</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'proses') || str_contains($tujuan, 'lanjut') ? 'checked' : '' }}>
                                <span>Proses Lebih Lanjut</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'operasional') && !str_contains($tujuan, 'koordinator') ? 'checked' : '' }}>
                                <span>Operasional</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'koordinasi') || str_contains($tujuan, 'konfirmasi') ? 'checked' : '' }}>
                                <span>Koordinasi / Konfirmasi</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox" {{ str_contains($tujuan, 'koordinator') ? 'checked' : '' }}>
                                <span>Koordinator Operasional</span>
                            </div>
                        </div>
                        <div style="margin-top: 12px; font-weight: normal;">
                            <strong>Tujuan:</strong> {{ $latestDisposisi->tujuan_disposisi }}
                        </div>
                    @else
                        <div class="disposisi-options">
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Petugas Tata Usaha dan Keuangan</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Memberi Tanggapan / Saran</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>PPK</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Proses Lebih Lanjut</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Operasional</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Koordinasi / Konfirmasi</span>
                            </div>
                            <div class="option-item">
                                <input type="checkbox">
                                <span>Koordinator Operasional</span>
                            </div>
                        </div>
                        <div style="margin-top: 12px; color: #999; font-style: italic;">
                            Belum ada disposisi
                        </div>
                    @endif
                </td>
            </tr>

            <!-- Row 6: Catatan -->
            <tr class="catatan-row">
                <td class="col-label-left" style="padding: 10px;">Catatan:</td>
                <td colspan="3" style="padding: 0;">
                    <div class="catatan-container">
                        <div class="catatan-left">
                            @if($suratMasuk->disposisi->count() > 0)
                                @php
                                    $latestDisposisi = $suratMasuk->disposisi->first();
                                @endphp
                                {{ $latestDisposisi->catatan_disposisi }}
                                <div style="margin-top: 15px; font-size: 9pt; color: #555;">
                                    <div><strong>Status:</strong> {{ $latestDisposisi->status }}</div>
                                    <div><strong>Tanggal Disposisi:</strong> {{ $latestDisposisi->tanggal_disposisi->format('d/m/Y') }}</div>
                                    <div><strong>Oleh:</strong> {{ $latestDisposisi->user->name }}</div>
                                </div>
                            @else
                                <span style="color: #999; font-style: italic;">Belum ada catatan disposisi</span>
                            @endif
                        </div>
                        <div class="catatan-right">
                            <div style="font-weight: bold;">Kepala Stasiun</div>
                            <div class="signature-box">
                                <div class="signature-name">Muhammad Sulam Khilmi</div>
                                <div class="signature-nip">NIP. 19751022 199603 1001</div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer info -->
    <div style="margin-top: 20px; text-align: center; font-size: 9pt; color: #666;" class="no-print">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB | Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>
</body>
</html>