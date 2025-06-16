@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="dashboard-container">
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="dashboard-title">Dashboard Petugas</h1>
                <p class="dashboard-subtitle">Selamat datang kembali! Berikut adalah ringkasan aktivitas perpustakaan hari ini.</p>
            </div>
            <div class="header-right">
                <div class="date-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="current-date"></span>
                </div>
                <div class="time-info">
                    <i class="fas fa-clock"></i>
                    <span id="current-time"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="dashboard-grid">
        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Total Anggota</div>
                <div class="card-value">{{ $totalAnggota ?? 0 }}</div>
                <div class="card-description">Jumlah seluruh anggota aktif</div>
                <div class="card-trend {{ ($trendAnggota ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ ($trendAnggota ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                    <span>{{ ($trendAnggota ?? 0) >= 0 ? '+' : '' }}{{ $trendAnggota ?? 0 }}% dari bulan lalu</span>
                </div>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-icon success">
                <i class="fas fa-book"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Total Buku</div>
                <div class="card-value">{{ $totalBuku ?? 0 }}</div>
                <div class="card-description">Buku tersedia di perpustakaan</div>
                <div class="card-trend {{ ($bukuBulanLalu ?? 0) > 0 ? 'positive' : 'neutral' }}">
                    <i class="fas fa-{{ ($bukuBulanLalu ?? 0) > 0 ? 'arrow-up' : 'minus' }}"></i>
                    <span>{{ ($bukuBulanLalu ?? 0) > 0 ? '+' . $bukuBulanLalu . ' buku baru' : 'Stabil' }}</span>
                </div>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-icon warning">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Sedang Dipinjam</div>
                <div class="card-value">{{ $bukuDipinjam ?? 0 }}</div>
                <div class="card-description">Buku sedang dipinjam</div>
                <div class="card-trend neutral">
                    <i class="fas fa-minus"></i>
                    <span>Aktif</span>
                </div>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up" data-aos-delay="400">
            <div class="card-icon danger">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="card-content">
                <div class="card-title">Denda Aktif</div>
                <div class="card-value">Rp {{ number_format($totalDendaAktif ?? 0, 0, ',', '.') }}</div>
                <div class="card-description">Total denda yang belum dibayar</div>
                <div class="card-trend {{ ($totalDendaAktif ?? 0) > 0 ? 'negative' : 'positive' }}">
                    <i class="fas fa-{{ ($totalDendaAktif ?? 0) > 0 ? 'exclamation-triangle' : 'check' }}"></i>
                    <span>{{ ($totalDendaAktif ?? 0) > 0 ? 'Perlu perhatian' : 'Tidak ada denda' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section" data-aos="fade-up" data-aos-delay="500">
        <h2 class="section-title">Aksi Cepat</h2>
        <div class="quick-actions-grid">
            <a href="{{ route('petugas.anggota.create') }}" class="quick-action-card">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-content">
                    <h3>Tambah Anggota</h3>
                    <p>Daftarkan anggota baru</p>
                </div>
            </a>

            <a href="{{ route('petugas.buku.create') }}" class="quick-action-card">
                <div class="action-icon">
                    <i class="fas fa-book-medical"></i>
                </div>
                <div class="action-content">
                    <h3>Tambah Buku</h3>
                    <p>Input buku baru</p>
                </div>
            </a>

            <a href="{{ route('petugas.peminjaman.create') }}" class="quick-action-card">
                <div class="action-icon">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div class="action-content">
                    <h3>Proses Peminjaman</h3>
                    <p>Catat peminjaman buku</p>
                </div>
            </a>

            <a href="{{ route('petugas.pengembalian.index') }}" class="quick-action-card">
                <div class="action-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="action-content">
                    <h3>Proses Pengembalian</h3>
                    <p>Terima pengembalian buku</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities & Charts Section -->
    <div class="dashboard-content-grid">
        <!-- Recent Activities -->
        <div class="content-card recent-activities" data-aos="fade-right" data-aos-delay="600">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Aktivitas Terbaru
                </h3>
                <a href="#" class="view-all-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                    <div class="activity-item">
                        <div class="activity-avatar {{ $aktivitas['avatar_class'] ?? 'primary' }}">
                            <i class="{{ $aktivitas['icon'] ?? 'fas fa-info' }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $aktivitas['title'] ?? 'Aktivitas' }}</div>
                            <div class="activity-description">{{ $aktivitas['description'] ?? 'Deskripsi tidak tersedia' }}</div>
                            <div class="activity-time">{{ $aktivitas['formatted_time'] ?? 'Waktu tidak tersedia' }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="activity-item">
                        <div class="activity-avatar primary">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Belum Ada Aktivitas</div>
                            <div class="activity-description">Tidak ada aktivitas terbaru untuk ditampilkan</div>
                            <div class="activity-time">-</div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="content-card chart-section" data-aos="fade-left" data-aos-delay="700">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Statistik Mingguan
                </h3>
                <div class="chart-controls">
                    <button class="btn-chart active" data-chart="peminjaman">Peminjaman</button>
                    <button class="btn-chart" data-chart="kunjungan">Kunjungan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Section -->
    <div class="alerts-section" data-aos="fade-up" data-aos-delay="800">
        <h2 class="section-title">Peringatan & Notifikasi</h2>
        <div class="alerts-grid">
            @if(($bukuAkanJatuhTempo ?? 0) > 0)
            <div class="alert-card warning">
                <div class="alert-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="alert-content">
                    <h4>Buku Akan Jatuh Tempo</h4>
                    <p>{{ $bukuAkanJatuhTempo }} buku akan jatuh tempo dalam 2 hari ke depan</p>
                    <a href="{{ route('petugas.peminjaman.index') }}" class="alert-action">Lihat Detail</a>
                </div>
            </div>
            @endif

            @if(($bukuTerlambat ?? 0) > 0)
            <div class="alert-card danger">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>Buku Terlambat</h4>
                    <p>{{ $bukuTerlambat }} buku sudah melewati batas waktu peminjaman</p>
                    <a href="{{ route('petugas.peminjaman.index') }}" class="alert-action">Kelola Peminjaman</a>
                </div>
            </div>
            @endif

            @if(($stokMenupis ?? 0) > 0)
            <div class="alert-card danger">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>Stok Buku Menipis</h4>
                    <p>{{ $stokMenupis }} judul buku memiliki stok tersisa kurang dari 3 eksemplar</p>
                    <a href="{{ route('petugas.buku.index') }}" class="alert-action">Kelola Stok</a>
                </div>
            </div>
            @endif

            <div class="alert-card info">
                <div class="alert-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>Laporan Bulanan</h4>
                    <p>Laporan aktivitas bulan ini siap untuk diunduh</p>
                    <a href="#" class="alert-action">Unduh Laporan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Container */
.dashboard-container {
    padding: 0;
    max-width: 100%;
}

/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

.header-right {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.date-info, .time-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 0 2rem;
}

.dashboard-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(226, 232, 240, 0.5);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), #a78bfa);
}

.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.card-icon {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
}

.card-icon.primary { background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; }
.card-icon.success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.card-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.card-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

.card-content {
    flex: 1;
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.card-description {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.card-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.85rem;
    font-weight: 500;
}

.card-trend.positive { color: #10b981; }
.card-trend.negative { color: #ef4444; }
.card-trend.neutral { color: #6b7280; }

/* Quick Actions */
.quick-actions-section {
    padding: 0 2rem;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.quick-action-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid #e2e8f0;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.action-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0 0 0.25rem 0;
}

.action-content p {
    font-size: 0.9rem;
    color: #64748b;
    margin: 0;
}

/* Dashboard Content Grid */
.dashboard-content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding: 0 2rem;
    margin-bottom: 2rem;
}

.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    text-transform: none;
    letter-spacing: normal;
}

.view-all-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

.view-all-link:hover {
    text-decoration: underline;
}

.card-body {
    padding: 1.5rem;
}

/* Recent Activities */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.activity-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.activity-avatar.primary { background: #dbeafe; color: #2563eb; }
.activity-avatar.success { background: #d1fae5; color: #10b981; }
.activity-avatar.warning { background: #fef3c7; color: #f59e0b; }
.activity-avatar.danger { background: #fee2e2; color: #ef4444; }

.activity-title {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.activity-description {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.activity-time {
    color: #9ca3af;
    font-size: 0.8rem;
}

/* Chart Section */
.chart-controls {
    display: flex;
    gap: 0.5rem;
}

.btn-chart {
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-chart.active,
.btn-chart:hover {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
}

.chart-container {
    height: 300px;
    position: relative;
}

/* Alerts Section */
.alerts-section {
    padding: 0 2rem;
    margin-bottom: 2rem;
}

.alerts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.alert-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    border-left: 4px solid;
}

.alert-card.warning { border-left-color: #f59e0b; }
.alert-card.danger { border-left-color: #ef4444; }
.alert-card.info { border-left-color: #2563eb; }

.alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.alert-card.warning .alert-icon { background: #fef3c7; color: #f59e0b; }
.alert-card.danger .alert-icon { background: #fee2e2; color: #ef4444; }
.alert-card.info .alert-icon { background: #dbeafe; color: #2563eb; }

.alert-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0 0 0.5rem 0;
}

.alert-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0 0 1rem 0;
}

.alert-action {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

.alert-action:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-content-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-grid {
        padding: 0 1rem;
    }

    .quick-actions-section,
    .alerts-section {
        padding: 0 1rem;
    }

    .dashboard-header {
        padding: 1.5rem 1rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .dashboard-title {
        font-size: 2rem;
    }

    .dashboard-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }

    .alerts-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Update current time and date
function updateDateTime() {
    const now = new Date();
    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const timeOptions = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };

    document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
    document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
}

// Update every second
setInterval(updateDateTime, 1000);
updateDateTime();

// Chart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Chart buttons
    const chartButtons = document.querySelectorAll('.btn-chart');
    chartButtons.forEach(button => {
        button.addEventListener('click', function() {
            chartButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const chartType = this.getAttribute('data-chart');
            updateChart(chartType);
        });
    });

    // Initialize chart if Chart.js is available
    if (typeof Chart !== 'undefined') {
        initializeChart();
    }
});

function initializeChart() {
    const ctx = document.getElementById('weeklyChart');
    if (!ctx) return;

    // Data from Laravel (passed via Blade)
    const chartData = @json($chartData ?? ['labels' => [], 'peminjaman' => [], 'kunjungan' => []]);

    window.weeklyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Peminjaman',
                data: chartData.peminjaman,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    grid: {
                        color: '#f1f5f9'
                    }
                }
            }
        }
    });
}

function updateChart(type) {
    if (!window.weeklyChart) return;

    const chartData = @json($chartData ?? ['labels' => [], 'peminjaman' => [], 'kunjungan' => []]);

    if (type === 'peminjaman') {
        window.weeklyChart.data.datasets[0].label = 'Peminjaman';
        window.weeklyChart.data.datasets[0].data = chartData.peminjaman;
        window.weeklyChart.data.datasets[0].borderColor = '#2563eb';
        window.weeklyChart.data.datasets[0].backgroundColor = 'rgba(37, 99, 235, 0.1)';
    } else if (type === 'kunjungan') {
        window.weeklyChart.data.datasets[0].label = 'Kunjungan';
        window.weeklyChart.data.datasets[0].data = chartData.kunjungan;
        window.weeklyChart.data.datasets[0].borderColor = '#10b981';
        window.weeklyChart.data.datasets[0].backgroundColor = 'rgba(16, 185, 129, 0.1)';
    }

    window.weeklyChart.update();
}
</script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
