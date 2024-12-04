@extends("layouts.app")

@section("title")
    Dashboard Laundry
@endsection

@section("content")
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Laundry</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Dashboard</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="section-lead">Lihat ringkasan pesanan dan pendapatan.</p>

            <!-- Card Statistics -->
            <div class="row mb-4">
                <!-- Card Pesanan Hari Ini -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $pesananHariIni }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Pesanan Selesai -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pesanan Selesai</h4>
                            </div>
                            <div class="card-body">
                                {{ $pesananSelesai }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Pendapatan Harian -->
                @if (auth()->user()->role !== "pelanggan")
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Pendapatan Hari Ini</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($pendapatanHarian, 0, ",", ".") }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role == "admin")
                    <!-- Card Pendapatan Bulanan -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Pendapatan Bulanan</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($pendapatanBulanan, 0, ",", ".") }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Charts -->
            @if (auth()->user()->role == "admin")
                <div class="row mb-4">
                    <!-- Orders Per Hour Chart -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pesanan per Jam (Hari Ini)</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="ordersPerHourChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Per Day Chart -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pesanan per Hari (30 Hari Terakhir)</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="ordersChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Monthly Income Chart -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pendapatan Bulanan (30 Hari Terakhir)</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="incomeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push("scripts")
        <script>
            // Orders Per Hour Chart
            var ordersPerHourChart = new Chart(document.getElementById('ordersPerHourChart'), {
                type: 'line',
                data: {
                    labels: @json($ordersPerHour->pluck("hour")), // Jam yang ditampilkan di sumbu X
                    datasets: [{
                        label: 'Jumlah Pesanan per Jam',
                        data: @json($ordersPerHour->pluck("count")), // Jumlah pesanan per jam
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true,
                            },
                            beginAtZero: true,
                            type: 'linear'
                        }
                    }
                }
            });

            // Orders Per Day Chart
            var ordersChart = new Chart(document.getElementById('ordersChart'), {
                type: 'line',
                data: {
                    labels: @json($ordersPerDay->pluck("date")),
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: @json($ordersPerDay->pluck("count")),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true,
                            },
                            beginAtZero: true,
                            type: 'linear'
                        }
                    }
                }
            });

            // Monthly Income Chart
            var incomeChart = new Chart(document.getElementById('incomeChart'), {
                type: 'bar',
                data: {
                    labels: @json($monthlyIncome->pluck("date")),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: @json($monthlyIncome->pluck("income")),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
  
    @endpush
@endsection
