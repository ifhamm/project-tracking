<!DOCTYPE html>
<html>

<head>
    <title>Export PDF</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body>
    {{-- <h1>Data Part untuk {{ $parts->customer }}</h1> --}}

    <table>
        <thead>
            <tr>
                <th>No. Part</th>
                <th>Nama Part</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parts as $part)
                <tr>
                    <td>{{ $part->part_number }}</td>
                    <td>{{ $part->part_name }}</td>
                    <td>{{ $part->incoming_date->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
