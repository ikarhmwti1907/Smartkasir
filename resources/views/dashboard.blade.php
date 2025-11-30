@extends('layouts.app')

@section('content')

<style>
/* ========================
   FINANCIAL DASHBOARD
======================== */

.finance-card {
    border-radius: 18px;
    padding: 22px;
    color: #FFFFFF;
    position: relative;
    overflow: hidden;
    transition: 0.25s ease;
    margin-bottom: 20px;
    width: 100%;
    /* sesuaikan col */
    text-align: center;
    /* teks di tengah */
}

.finance-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.25);
}

.finance-card::after {
    content: "";
    position: absolute;
    top: -20%;
    right: -25%;
    width: 140px;
    height: 140px;
    background: rgba(255, 255, 255, 0.12);
    border-radius: 50%;
    filter: blur(10px);
}

.bg-income {
    background: linear-gradient(135deg, #1F3A5F, #284d78);
}

.bg-transaksi {
    background: linear-gradient(135deg, #F47C20, #d96b1c);
}

.bg-barang {
    background: linear-gradient(135deg, #37475A, #41556b);
}

.finance-card h4 {
    font-weight: 600;
    margin-bottom: 5px;
}

.finance-card .value {
    font-size: 28px;
    font-weight: 700;
}

/* ========================
   CARD + TABLE CLEAN UI
======================== */

.card {
    border-radius: 14px !important;
}

.card-body {
    padding: 22px !important;
}

.table thead {
    background: #ECECEC;
}

/* ========================
       ANIMATION
======================== */
.fade-in {
    animation: fadeIn 0.45s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<div class="container mt-4 fade-in">
    <!-- CARD UTAMA DI TENGAH -->
    <div class="row g-3 justify-content-center">
        <!-- Total Pendapatan -->
        <div class="col-12 col-md-4">
            <div class="finance-card bg-income shadow">
                <h4>Total Pendapatan</h4>
                <div class="value">Rp {{ number_format($pendapatan,0,',','.') }}</div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-12 col-md-4">
            <div class="finance-card bg-transaksi shadow">
                <h4>Total Transaksi</h4>
                <div class="value">{{ $totalTransaksi }}</div>
            </div>
        </div>

        <!-- Total Barang -->
        <div class="col-12 col-md-4">
            <div class="finance-card bg-barang shadow">
                <h4>Total Barang</h4>
                <div class="value">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>

    <!-- GRAFIK & TRANSAKSI TERBARU -->
    <div class="row mt-4">
        <!-- Grafik Pendapatan -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Grafik Pendapatan Bulanan</h5>
                    <canvas id="incomeChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm mt-3 mt-lg-0">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Transaksi Terbaru</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent as $tr)
                            <tr>
                                <td>{{ $tr->created_at->format('d/m H:i') }}</td>
                                <td>Rp {{ number_format($tr->total,0,',','.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('incomeChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabel),
        datasets: [{
            label: "Pendapatan",
            data: @json($chartData),
            borderWidth: 3,
            tension: 0.35,
            borderColor: "#F47C20",
            pointBackgroundColor: "#F47C20"
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                grid: {
                    color: "rgba(0,0,0,0.15)"
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>

@endsection