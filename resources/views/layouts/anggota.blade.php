<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Perpustakaan SMPK 2 Harapan' }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-book-open"></i> Perpustakaan SMPK 2 Harapan</h1>
            <p>Portal Digital Siswa - Jelajahi Dunia Pengetahuan</p>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Selamat datang, {{ $userName ?? 'Nama Pengguna' }} ({{ $userClass ?? 'Kelas' }})</span>
              
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Konten Halaman -->
        @yield('content')
    </div>
</body>
</html>
