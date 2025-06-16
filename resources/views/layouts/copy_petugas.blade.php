<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin_style.css') }}">

    <!-- JS -->
    <script src="{{ asset('assets/js/admin_script.js') }}"></script> --}}

</head>
<body>
    <div class="container-fluid">
        <!-- Mobile Toggle Button -->
        <button class="mobile-toggle" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar slide-in-left">
                <div class="sidebar-logo">
                    <h4>SIPUS PETUGAS</h4>
                </div>

                <!-- Menu Utama -->
                <div class="menu-section">
                    <div class="menu-title">Menu Utama</div>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.petugas') }}" class="nav-link active tooltip-custom" data-tooltip="Dashboard Utama">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.kategori.index') }}" class="nav-link tooltip-custom" data-tooltip="Kelola Kategori Buku">
                                <i class="fas fa-list"></i>
                                <span>Kategori</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.buku.index') }}" class="nav-link tooltip-custom" data-tooltip="Kelola Data Buku">
                                <i class="fas fa-book"></i>
                                <span>Buku</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.anggota.index') }}" class="nav-link tooltip-custom" data-tooltip="Kelola Data Anggota">
                                <i class="fas fa-users"></i>
                                <span>Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link tooltip-custom" data-tooltip="Kelola Peminjaman">
                                <i class="fas fa-arrow-up-right-from-square"></i>
                                <span>Peminjaman</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link tooltip-custom" data-tooltip="Kelola Pengembalian">
                                <i class="fas fa-undo-alt"></i>
                                <span>Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.kunjungan.index') }}" class="nav-link tooltip-custom" data-tooltip="Monitor Kunjungan">
                                <i class="fas fa-chart-line"></i>
                                <span>Monitoring Kunjungan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Pengaturan -->
                <div class="settings-section">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link tooltip-custom" data-tooltip="Pengaturan Profil">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    </ul>

                    <a href="{{ route('anggota.kunjungan.create') }}" class="special-button" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Form Input Kunjungan
                    </a>

                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link tooltip-custom" data-tooltip="Keluar dari Sistem" onclick="handleLogout(event)">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
