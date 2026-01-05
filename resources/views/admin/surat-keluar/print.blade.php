<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Surat Keluar - {{ $suratKeluar->nomor_surat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            padding: 2cm;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11pt;
            margin: 2px 0;
        }
        
        .info-box {
            margin-bottom: 30px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .info-label {
            width: 180px;
            font-weight: bold;
        }
        
        .info-separator {
            width: 20px;
        }
        
        .info-value {
            flex: 1;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .badge-red {
            background-color: #fee;
            color: #c00;
            border: 1px solid #c00;
        }
        
        .badge-orange {
            background-color: #ffe;
            color: #c60;
            border: 1px solid #c60;
        }
        
        .badge-yellow {
            background-color: #ffc;
            color: #960;
            border: 1px solid #960;
        }
        
        .content-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .content-section h3 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        
        .content-text {
            text-align: justify;
            margin-bottom: 20px;
            white-space: pre-line;
        }
        
        .footer {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            @page {
                margin: 2cm;
            }
        }
        
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
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background-color: #374151;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button onclick="window.print()" class="print-button no-print">🖨️ Print / Save as PDF</button>

    <!-- Header -->
    <div class="header">
        <h1>BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA</h1>
        <p>Jl. Angkasa I No. 2, Kemayoran, Jakarta Pusat 10720</p>
        <p>Telp: (021) 4246321 | Fax: (021) 4246703 | Website: www.bmkg.go.id</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nomor Surat</div>
            <div class="info-separator">:</div>
            <div class="info-value"><strong>{{ $suratKeluar->nomor_surat }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tujuan</div>
            <div class="info-separator">:</div>
            <div class="info-value">{{ $suratKeluar->tujuan_surat }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Surat</div>
            <div class="info-separator">:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d F Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Dikirim</div>
            <div class="info-separator">:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($suratKeluar->tanggal_kirim)->format('d F Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Sifat</div>
            <div class="info-separator">:</div>
            <div class="info-value">
                <span class="badge 
                    @if($suratKeluar->sifat === 'Sangat Segera') badge-red
                    @elseif($suratKeluar->sifat === 'Segera') badge-orange
                    @else badge-yellow
                    @endif">
                    {{ $suratKeluar->sifat }}
                </span>
            </div>
        </div>
        @if($suratKeluar->surat_masuk_id)
        <div class="info-row">
            <div class="info-label">Surat Masuk Terkait</div>
            <div class="info-separator">:</div>
            <div class="info-value">{{ $suratKeluar->suratMasuk->nomor_surat ?? '-' }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Perihal</div>
            <div class="info-separator">:</div>
            <div class="info-value"><strong>{{ $suratKeluar->perihal }}</strong></div>
        </div>
    </div>

    <!-- Content -->
    @if($suratKeluar->isi_surat)
    <div class="content-section">
        <h3>ISI SURAT</h3>
        <div class="content-text">{{ $suratKeluar->isi_surat }}</div>
    </div>
    @endif

    <!-- Footer / Signature -->
    <div class="footer">
        <div class="signature-box">
            <p>Jakarta, {{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d F Y') }}</p>
            <p style="margin-bottom: 10px;">Kepala BMKG,</p>
            <div class="signature-line">
                <p><strong>( .............................. )</strong></p>
                <p>NIP. ...................................</p>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Metadata Footer -->
    <div style="margin-top: 50px; padding-top: 20px; border-top: 1px solid #ccc; font-size: 9pt; color: #666;">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
        <p>Dokumen ini dicetak dari sistem E-Disposisi BMKG</p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>