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
        .item-details {
            margin-left: 20px;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    @if ($startDate && $endDate)
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    @endif
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
            @php
                $totalBarang = 0; // Variabel untuk menyimpan total barang
            @endphp
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['No'] }}</td>
                    <td>{{ $row['Tanggal'] }}</td>
                    <td>{{ $row['Tipe'] }}</td>
                    <td>{{ $row['Deskripsi'] }}</td>
                    <td>
                        <div class="item-details">
                            @foreach ($row['Items'] as $item)
                                <p>{{ $item['name'] }} ({{ $item['size'] }}) - Total: {{ $item['quantity'] }}</p>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $row['Total Kuantitas'] }}</td>
                </tr>
                @php
                    $totalBarang += $row['Total Kuantitas']; // Menambahkan total kuantitas ke variabel $totalBarang
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Total Barang</strong></td>
                <td><strong>{{ $totalBarang }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
