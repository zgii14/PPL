<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Bulanan</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                font-size: 14px;
                color: #333;
            }

            h1 {
                text-align: center;
                font-size: 20px;
            }

            p {
                text-align: center;
                font-size: 14px;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }

            tr.subtotal-row {
                background-color: #f9f9f9;
            }

            footer {
                margin-top: 30px;
                font-size: 12px;
                color: #555;
                text-align: center;
            }

            .summary {
                margin-top: 20px;
            }

            .summary ul {
                list-style: none;
                padding: 0;
            }

            .summary li {
                margin-bottom: 5px;
            }
        </style>
    </head>

    <body>
        <h1>Laporan Bulanan</h1>
        <p>Bulan: {{ now()->format("F Y") }}</p>

        <!-- Tabel Laporan -->
        <table>
            <thead>
                <tr>
                    <th>Nama Pelanggan</th>
                    <th>Nama Paket</th>
                    <th>Tanggal Pesanan</th>
                    <th>Jumlah (Kg)</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td rowspan="{{ $item["pesanan"]->count() }}">{{ $item["user"] }}</td>
                        @foreach ($item["pesanan"] as $index => $pesanan)
                            @if ($index > 0)
                    <tr>
                @endif
                <td>{{ $pesanan["paket"] }}</td>
                <td>{{ \Carbon\Carbon::parse($pesanan["created_at"])->format("d-m-Y") }}</td>
                <td>{{ $pesanan["jumlah"] }} Kg</td>
                <td>Rp {{ number_format($pesanan["total_harga"], 0, ",", ".") }}</td>
                </tr>
                @endforeach
                <tr class="subtotal-row">
                    <td colspan="4"><strong>Subtotal:</strong></td>
                    <td><strong>Rp {{ number_format($item["subtotal"], 0, ",", ".") }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total Keseluruhan:</strong></td>
                    <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ",", ".") }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Ringkasan -->
        <div class="summary">
            <ul>
                <li><strong>Total Pesanan:</strong> {{ $laporan->sum(fn($item) => $item["pesanan"]->count()) }}</li>
                <li><strong>Total Pendapatan:</strong> Rp {{ number_format($totalKeseluruhan, 0, ",", ".") }}</li>
            </ul>
        </div>

        <!-- Footer -->
        <footer>
            <p>Laporan ini dibuat oleh {{ auth()->user()->name }} pada {{ now()->format("d-m-Y H:i") }}.</p>
            <p>© {{ now()->year }} Laundry Lubis. Semua hak cipta dilindungi.</p>
        </footer>
    </body>

</html>
