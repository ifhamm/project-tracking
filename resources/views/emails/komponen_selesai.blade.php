<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 650px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            background-color: #0F2A4A;
            padding: 25px 30px;
            color: #ffffff;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .email-body {
            padding: 30px;
        }

        .email-body p {
            margin-bottom: 15px;
        }

        .email-details {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 5px;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .email-details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .email-details ul li {
            padding: 8px 0;
            border-bottom: 1px dashed #e0e0e0;
        }

        .email-details ul li:last-child {
            border-bottom: none;
        }

        .email-details strong {
            display: inline-block;
            width: 120px;
            color: #555;
        }

        .email-footer {
            background-color: #0F2A4A;
            color: #ffffff;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
            border-top: 5px solid #E4002B;
        }

        .email-footer p {
            margin: 0;
        }

        .debug-info {
            font-size: 10px;
            color: #999;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>Notifikasi Penyelesaian Komponen</h1>
        </div>

        <div class="email-body">
            <p>Yth. Tim Terkait,</p>
            <p>Dengan hormat kami sampaikan bahwa komponen berikut telah selesai melalui proses pengerjaan:</p>

            <div class="email-details">
                <ul>
                    <li><strong>Nomor WBS:</strong> {{ $komponen->no_wbs }}</li>
                    <li><strong>Incoming Date:</strong> {{ $komponen->incoming_date ?? '-' }}</li>
                    <li><strong>Part Name:</strong> {{ $komponen->part_name ?? '-' }}</li>
                    <li><strong>Part Number:</strong> {{ $komponen->part_number ?? '-' }}</li>
                    <li><strong>Serial Number:</strong> {{ $komponen->no_seri ?? '-' }}</li>
                </ul>
            </div>

            <p>Mohon dapat segera ditindaklanjuti sesuai dengan prosedur operasional berikutnya.</p>
            <p>Terima kasih atas perhatian dan kerja sama Bapak/Ibu.</p>
            <br>
            <p>Hormat kami,</p>
            <p>Tim Operasional PT Dirgantara Indonesia</p>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} PT Dirgantara Indonesia. All rights reserved.</p>
            <p>Bandung, Indonesia</p>
        </div>


    </div>
</body>

</html>
