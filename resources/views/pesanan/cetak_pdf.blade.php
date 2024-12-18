<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Struk Pesanan</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f9;
            }

            .container {
                width: 100%;
                max-width: 600px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background-color: #ffffff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            h1,
            h2,
            p {
                margin: 0;
                padding: 5px 0;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #ddd;
                padding-bottom: 10px;
            }

            .header h1 {
                font-size: 22px;
                color: #333;
                margin: 0;
            }

            .header p {
                font-size: 12px;
                color: #777;
            }

            .details {
                margin: 15px 0;
                font-size: 14px;
                color: #555;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
                font-size: 13px;
            }

            th {
                background-color: #f7f7f7;
                color: #333;
            }

            td {
                color: #555;
            }

            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #888;
                border-top: 2px solid #ddd;
                padding-top: 10px;
            }

            .footer p {
                margin: 0;
            }

            .footer a {
                text-decoration: none;
                color: #007BFF;
            }

            .footer a:hover {
                text-decoration: underline;
            }

            .stamp {
                text-align: right;
                /* Letakkan elemen ke kanan */
                margin-top: 20px;
            }

            .stamp img {
                width: 100px;
                opacity: 0.8;
                display: inline-block;
                /* Pastikan gambar tetap proporsional */
            }

            .stamp p {
                font-size: 12px;
                color: #555;
                margin-top: 5px;
                text-align: right;
                /* Teks di bawah gambar tetap sejajar kanan */
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>Laundry Lubis</h1>
                <p>Alamat: Jl. WR. Supratman, Kandang Limun, Kec. Muara Bangka Hulu, Kota Bengkulu</p>
                <p>Telp: 083173289305</p>
            </div>

            <div class="details">
                <p><strong>Tanggal Pesanan:</strong> {{ $pesanan->created_at->format("d-m-Y H:i") }}</p>
                <p><strong>Nama Pelanggan:</strong> {{ $pesanan->user->name }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Paket</th>
                        <th>Jumlah (Kg)</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $pesanan->id }}</td>
                        <td>{{ $pesanan->paket->nama_paket }}</td>
                        <td>{{ $pesanan->jumlah }} Kg</td>
                        <td>
                            @switch($pesanan->status)
                                @case(0)
                                    Penjemputan
                                @break

                                @case(1)
                                    Penjemputan
                                @break

                                @case(2)
                                    Cuci
                                @break

                                @case(3)
                                    Kering
                                @break

                                @case(4)
                                    Lipat
                                @break

                                @case(5)
                                    Pengantaran
                                @break

                                @case(6)
                                    Selesai
                                @break

                                @default
                                    Status Tidak Diketahui
                            @endswitch
                        </td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ",", ".") }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="stamp">
                <img src="{{ public_path("asset/images/stempel.png") }}" alt="Stempel Laundry Lubis">
                <p>Staff Laundry Lubis</p>
            </div>

            <div class="footer">
                <p>Terima kasih atas pesanan Anda!</p>
                <p>Untuk informasi lebih lanjut, kunjungi <a href="http://laundrylubis.com">Laundry Lubis</a></p>
            </div>
        </div>
    </body>

</html>
