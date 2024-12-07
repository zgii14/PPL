<!DOCTYPE html>
<html>

    <head>
        <title>Laporan Bulanan</title>
        <style>
            /* General Reset */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Body Styling */
            body {
                font-family: Arial, sans-serif;
                padding: 15px;
                color: #333;
            }

            /* Header Styling */
            h1 {
                text-align: center;
                font-size: 22px;
                margin-bottom: 5px;
            }

            h4 {
                text-align: center;
                font-size: 16px;
                color: #555;
                margin-bottom: 15px;
            }

            hr {
                margin: 10px 0;
                border: none;
                height: 1px;
                background-color: #555;
            }

            /* Table Styling */
            table {
                width: 100%;
                border: 1px solid #ddd;
                border-collapse: collapse;
                margin: 10px 0;
                font-size: 14px;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            th {
                background-color: #555;
                color: white;
            }

            tbody tr:nth-child(odd) {
                background-color: #f9f9f9;
            }

            /* Total Container */
            .total-container {
                margin-top: 15px;
                font-size: 16px;
                font-weight: bold;
                text-align: right;
            }

            /* Responsive Styles */
            @media (max-width: 768px) {
                h1 {
                    font-size: 20px;
                }

                table th,
                table td {
                    font-size: 12px;
                }
            }
        </style>
    </head>

    <body>
        <!-- Main Report Title Section -->
        <h1>Laporan Bulanan</h1>
        <h4>Bulan: {{ \Carbon\Carbon::create($tahun, $bulan)->format("F") }} Tahun: {{ $tahun }}</h4>
        <hr />

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Paket Laundry</th>
                    <th>Jumlah (kg)</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($laporan as $item)
                    @foreach ($item["pesanan"] as $index => $pesanan)
                        <tr>
                            <td>
                                @if ($index == 0)
                                    {{ $no++ }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($index == 0)
                                    {{ $item["user"] }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $pesanan["paket"] }}</td>
                            <td>{{ $pesanan["jumlah"] }} kg</td>
                            <td>Rp {{ number_format($pesanan["total_harga"], 0, ",", ".") }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan["tanggal"])->format("d-m-Y H:i") }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <!-- Total Keseluruhan -->
        <div class="total-container">
            Total Keseluruhan: Rp {{ number_format($totalKeseluruhan, 0, ",", ".") }}
        </div>
    </body>

</html>
