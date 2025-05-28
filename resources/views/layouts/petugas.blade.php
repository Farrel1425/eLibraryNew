<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Perpustakaan Petugas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container-fluid {
            padding: 0;
        }
        .row {
            margin: 0;
        }
        .col-md-2 {
            padding: 0;
            background-color: #343a40;
        }
        .col-md-10 {
            padding: 20px;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }
        .nav-item {
            margin-bottom: 10px;
        }
        .nav-item i {
            width: 20px;
            text-align: center;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: white;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }
        .content {
            padding: 20px;
        }
        .app-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0d6efd;
        }
        .sidebar-logo {
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 min-m-screen">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0 d-flex flex-column">
                <div class="sidebar-logo">
                    <h4 class="mb-0">SIPUS PETUGAS</h4>
                </div>

                <!-- Bagian Navigasi Utama -->
                <div class="flex-grow-1 px-3">
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase ">Menu Utama</div>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.petugas') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.kategori.index') }}" class="nav-link">
                                <i class="fas fa-list me-2"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.buku.index') }}" class="nav-link">
                                <i class="fas fa-book me-2"></i> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.anggota.index') }}" class="nav-link">
                                <i class="fas fa-users me-2"></i> Anggota
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link">
                                <i class="fas fas fa-arrow-up-right-from-square me-2"></i> Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link">
                                <i class="fas fa-arrow-down-to-line me-2"></i> Pengembalian

                        </li>
                    </ul>
                </div>

               <!-- Bagian Pengaturan (tetap di bawah) -->
                <div class="px-3 mb-3">
                    <div class="text-muted small text-uppercase mb-2">Pengaturan</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                       <li class="nav-item">
                            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
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
