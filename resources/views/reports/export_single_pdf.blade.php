<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>Item</th>
                <th>Total Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data['No'] }}</td>
                <td>{{ $data['Tanggal'] }}</td>
                <td>{{ $data['Tipe'] }}</td>
                <td>{{ $data['Deskripsi'] }}</td>
                <td>
                    @foreach ($data['Items'] as $item)
                        <p>{{ $item['name'] }} ({{ $item['size'] }}) - Total: {{ $item['quantity'] }}</p>
                    @endforeach
                </td>
                <td>{{ $data['Total Kuantitas'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
