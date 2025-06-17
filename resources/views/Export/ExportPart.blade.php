<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Komponen - PT Dirgantara Indonesia</title>
    <style>
        :root {
            --primary: #1a56db;
            --primary-dark: #0e3aaa;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #0d9b60;
            --border: #dee2e6;
            --header-bg: #f0f4f9;
            --row-hover: #f8fbff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        html,
        body {
            height: 100%;
        }

        body {
            background-color: #f9fbfd;
            color: #333;
            padding: 30px 20px;
            position: relative;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: transparent;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .company-logo {
            position: absolute;
            top: 20px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 2;
        }

        .company-logo img {
            height: 45px;
            filter: brightness(0) invert(1);
        }

        .company-logo span {
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            padding: 20px 30px;
            background: var(--header-bg);
            border-bottom: 1px solid var(--border);
        }

        .info-card {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            flex: 1;
            margin: 0 10px;
        }

        .info-card h3 {
            color: var(--secondary);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .info-card p {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
        }

        .report-title {
            padding: 25px 30px 15px;
            text-align: center;
        }

        .report-title h2 {
            color: var(--primary);
            font-size: 22px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .report-title p {
            color: var(--secondary);
            font-size: 15px;
        }

        .table-container {
            padding: 0 30px 30px;
            overflow-x: auto;
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            background: white;
        }

        thead {
            background: linear-gradient(to bottom, #f0f4f9, #e3e9f1);
        }

        th {
            padding: 16px 15px;
            text-align: left;
            font-weight: 600;
            color: var(--primary-dark);
            border-bottom: 2px solid var(--border);
            position: sticky;
            top: 0;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid var(--border);
            color: #444;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background-color: var(--row-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .no-data {
            padding: 30px;
            text-align: center;
            color: var(--secondary);
            font-style: italic;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            opacity: 0.08;
            pointer-events: none;
        }

        .watermark img {
            width: 600px;
            height: auto;
        }

        .footer {
            padding: 25px 30px;
            text-align: right;
            background: var(--header-bg);
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .footer-info {
            text-align: left;
            color: var(--secondary);
            font-size: 13px;
        }

        .footer-info strong {
            color: var(--primary);
        }

        .footer p {
            color: var(--secondary);
            font-size: 13px;
            margin: 0;
        }

        .signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
            gap: 40px;
        }


        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .status-active {
            background: #e3f9ee;
            color: var(--success);
        }

        @media print {
            body {
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
                min-height: auto;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="company-logo">
                <img src="https://www.indonesian-aerospace.com/assets/img/logo/logo.png" alt="PT Dirgantara Indonesia">
            </div>
            <h1>Laporan Inventaris Komponen</h1>
        </div>

        <div class="report-info">
            <div class="info-card">
                <h3>Nama Pelanggan</h3>
                <p>{{ $customerName }}</p> <!-- Diubah dari $parts->first()->customer -->
            </div>
            <div class="info-card">
                <h3>Tanggal Laporan</h3>
                <p>{{ date('d F Y') }}</p>
            </div>
            <div class="info-card">
                <h3>Status Laporan</h3>
                <p><span class="status-badge status-active">Aktif</span></p>
            </div>
        </div>

        <div class="report-title">
            <h2>Detail Komponen Pesawat</h2>
            <p>Daftar komponen yang tercatat dalam sistem manajemen inventaris</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No. WBS</th>
                        <th>Tanggal Masuk</th>
                        <th>Customer</th> <!-- Kolom baru -->
                        <th>No. Part</th>
                        <th>Nama Part</th>
                        <th>No. Seri</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($parts as $part)
                        <tr>
                            <td>{{ $part->no_wbs }}</td>
                            <td>{{ $part->incoming_date }}</td>
                            <td>{{ $part->customer }}</td> <!-- Kolom baru -->
                            <td>{{ $part->part_number }}</td>
                            <td>{{ $part->part_name }}</td>
                            <td>{{ $part->no_seri }}</td>
                            <td>{{ $part->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div class="footer-info">
                <p><strong>Catatan:</strong> Laporan ini dibuat secara otomatis oleh sistem. Untuk informasi lebih
                    lanjut hubungi Divisi Produksi.</p>
                <p>Dicetak pada {{ date('d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="watermark">
        <img src="https://www.indonesian-aerospace.com/assets/img/logo/logo.png" alt="Watermark">
    </div>
</body>

</html>
