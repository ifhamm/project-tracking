<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Part untuk Customer: {{ $customerName }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 20px; font-size: 11px; }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        h2 { font-size: 16px; color: #444; margin-top: 30px; border-bottom: 1px solid #eee; padding-bottom: 5px;}
        table { width: 100%; border-collapse: collapse; margin-top: 15px; page-break-inside: auto; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; word-wrap: break-word; }
        th { background-color: #f2f2f2; font-size: 10px; }
        .part-container { margin-bottom: 30px; page-break-inside: avoid; } /* Hindari page break di tengah info part */
        .info-table td:first-child { font-weight: bold; width: 130px; }
        .section-title { font-size: 13px; font-weight: bold; margin-top: 20px; margin-bottom: 8px; color: #555; }
        .no-breakdown { font-style: italic; color: #777; }
        .page-break { page-break-after: always; } /* Jika ingin paksa page break setelah setiap part utama */
    </style>
</head>
<body>
    <h1>Laporan Part untuk Customer: {{ $customer }}</h1>

    @if($parts->isEmpty())
        <p>Tidak ada data part yang ditemukan untuk customer ini.</p>
    @else
        @foreach($parts as $part)
            <div class="part-container">
                <h2>Part: {{ $part->part_name ?? 'N/A' }} (IWO: {{ $part->no_iwo }})</h2>

                <div class="section-title">Informasi Utama Part</div>
                <table class="info-table">
                    <tr>
                        <td>No. IWO</td>
                        <td>{{ $part->no_iwo }}</td>
                    </tr>
                    <tr>
                        <td>No. WBS</td>
                        <td>{{ $part->no_wbs ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>{{ $part->customer ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Masuk</td>
                        <td>{{ $part->incoming_date ? \Carbon\Carbon::parse($part->incoming_date)->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Part</td>
                        <td>{{ $part->part_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. Seri</td>
                        <td>{{ $part->no_seri ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>{{ $part->description ?? '-' }}</td>
                    </tr>
                    @if($part->akunMekanik)
                    <tr>
                        <td>Mekanik</td>
                        <td>{{ $part->akunMekanik->nama_lengkap ?? 'N/A' }} ({{ $part->id_credentials }})</td>
                    </tr>
                    @endif
                </table>

                @if($part->breakdownParts && $part->breakdownParts->count() > 0)
                    <div class="section-title">Breakdown Parts</div>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama BDP</th>
                                <th>No. BDP</th>
                                <th>No. BDP Eqv.</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>No. OP</th>
                                <th>Tgl OP</th>
                                <th>Defect</th>
                                <th>No. MT</th>
                                <th>Qty MT</th>
                                <th>Tgl MT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($part->breakdownParts as $index => $bdp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bdp->bdp_name ?? '-' }}</td>
                                <td>{{ $bdp->bdp_number }}</td>
                                <td>{{ $bdp->bdp_number_eqv ?? '-' }}</td>
                                <td>{{ $bdp->quantity ?? '-' }}</td>
                                <td>{{ $bdp->unit ?? '-' }}</td>
                                <td>{{ $bdp->op_number ?? '-' }}</td>
                                <td>{{ $bdp->op_date ? \Carbon\Carbon::parse($bdp->op_date)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $bdp->defect ?? '-' }}</td>
                                <td>{{ $bdp->mt_number ?? '-' }}</td>
                                <td>{{ $bdp->mt_quantity ?? '-' }}</td>
                                <td>{{ $bdp->mt_date ? \Carbon\Carbon::parse($bdp->mt_date)->format('d-m-Y') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="no-breakdown">Tidak ada data breakdown part untuk part ini.</p>
                @endif
            </div>
            {{-- Jika Anda ingin setiap data Part utama berada di halaman baru --}}
            {{-- @if(!$loop->last)
                <div class="page-break"></div>
            @endif --}}
        @endforeach
    @endif

</body>
</html>