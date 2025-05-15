<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
        }
        .email-header {
            background-color: #f7f7f7;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            color: #0f2a4a;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #f7f7f7;
            padding: 10px 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .email-footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Notifikasi Penyelesaian Komponen</h1>
        </div>
        <div class="email-body">
            <p>Yth. Tim Terkait,</p>
            <p>Komponen berikut telah selesai dikerjakan:</p>
            <ul>
                <li><strong>Nomor WBS:</strong> {{ $komponen->no_wbs }}</li>
                <li><strong>Nama Komponen:</strong> {{ $komponen->part_name ?? '-' }}</li>
                <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</li>
            </ul>
            <p>Mohon ditindaklanjuti sesuai dengan prosedur berikutnya.</p>
            <p>Terima kasih atas perhatian dan kerja samanya.</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} PT Dirgantara Indonesia. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
