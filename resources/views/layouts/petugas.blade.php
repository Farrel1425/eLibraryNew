<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Petugas - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <h4>SIPUS PETUGAS</h4>
        </div>

        <div class="menu-section">
            <div class="menu-title">Menu Utama</div>
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('dashboard.petugas') }}" class="nav-link" data-page="dashboard">
                        <i class="fas fa-home"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.anggota.index') }}" class="nav-link" data-page="anggota">
                        <i class="fas fa-users"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Anggota</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.kategori.index') }}" class="nav-link" data-page="kategori">
                        <i class="fas fa-tags"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.buku.index') }}" class="nav-link" data-page="buku">
                        <i class="fas fa-book"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Buku</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.kunjungan.index') }}" class="nav-link" data-page="kunjungan">
                        <i class="fas fa-door-open"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Kunjungan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link" data-page="peminjaman">
                        <i class="fas fa-book-reader"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Peminjaman</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link" data-page="pengembalian">
                        <i class="fas fa-undo"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Pengembalian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('petugas.denda.index') }}" class="nav-link" data-page="denda">
                        <i class="fas fa-money-bill-wave"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Denda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('anggota.kunjungan.create') }}" class="nav-link" data-page="form-kunjungan">
                        <i class="fas fa-user-check"></i>
                        <i class="fas fa-spinner fa-spin loading-spinner" style="display: none;"></i>
                        <span class="menu-text">Form Input Kunjungan</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="settings-section">
            <a href="#" class="special-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Enhanced Script with Active Menu Detection -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link[data-page]');

            // Set active menu berdasarkan URL saat ini
            setActiveMenu();

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Skip jika link kosong atau #
                    if (this.getAttribute('href') === '#' || !this.getAttribute('href')) {
                        return;
                    }

                    // Set active pada menu yang diklik
                    setActiveMenuOnClick(this);

                    // Tampilkan loading spinner
                    showLoadingSpinner(this);

                    // Disable semua link menu untuk mencegah double click
                    disableAllMenuLinks();

                    // Set timeout untuk fallback jika halaman gagal load
                    setTimeout(() => {
                        hideLoadingSpinner(this);
                        enableAllMenuLinks();
                    }, 5000); // 5 detik timeout
                });
            });
        });

        // Fungsi untuk menentukan menu aktif berdasarkan URL
        function setActiveMenu() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link[data-page]');

            // Hapus semua kelas active
            navLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Mapping URL patterns ke data-page
            const urlMappings = {
                'dashboard.petugas': 'dashboard',
                'petugas.anggota': 'anggota',
                'petugas.kategori': 'kategori',
                'petugas.buku': 'buku',
                'petugas.kunjungan': 'kunjungan',
                'petugas.peminjaman': 'peminjaman',
                'petugas.pengembalian': 'pengembalian',
                'anggota.kunjungan.create': 'form-kunjungan'
            };

            // Cari berdasarkan pola URL
            let activePageFound = false;
            for (const [urlPattern, pageType] of Object.entries(urlMappings)) {
                if (currentPath.includes(urlPattern.replace('.', '/')) ||
                    currentPath.includes(urlPattern.replace(/\./g, '/'))) {
                    const activeLink = document.querySelector(`[data-page="${pageType}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                        activePageFound = true;
                        break;
                    }
                }
            }

            // Fallback: jika tidak ada yang cocok, cek berdasarkan kata kunci dalam URL
            if (!activePageFound) {
                if (currentPath.includes('/anggota')) {
                    document.querySelector('[data-page="anggota"]')?.classList.add('active');
                } else if (currentPath.includes('/kategori')) {
                    document.querySelector('[data-page="kategori"]')?.classList.add('active');
                } else if (currentPath.includes('/buku')) {
                    document.querySelector('[data-page="buku"]')?.classList.add('active');
                } else if (currentPath.includes('/kunjungan')) {
                    if (currentPath.includes('/create') || currentPath.includes('/form')) {
                        document.querySelector('[data-page="form-kunjungan"]')?.classList.add('active');
                    } else {
                        document.querySelector('[data-page="kunjungan"]')?.classList.add('active');
                    }
                } else if (currentPath.includes('/peminjaman')) {
                    document.querySelector('[data-page="peminjaman"]')?.classList.add('active');
                } else if (currentPath.includes('/pengembalian')) {
                    document.querySelector('[data-page="pengembalian"]')?.classList.add('active');
                } else if (currentPath.includes('/denda')) {
                    document.querySelector('[data-page="denda"]')?.classList.add('active');
                } else if (currentPath.includes('/dashboard') || currentPath === '/' || currentPath.includes('/home')) {
                    document.querySelector('[data-page="dashboard"]')?.classList.add('active');
                }
            }
        }

        // Fungsi untuk set active menu saat diklik
        function setActiveMenuOnClick(clickedLink) {
            const navLinks = document.querySelectorAll('.nav-link[data-page]');

            // Hapus semua kelas active
            navLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Tambahkan kelas active pada menu yang diklik
            clickedLink.classList.add('active');
        }

        function showLoadingSpinner(linkElement) {
            const mainIcon = linkElement.querySelector('i:not(.loading-spinner)');
            const loadingSpinner = linkElement.querySelector('.loading-spinner');
            const menuText = linkElement.querySelector('.menu-text');

            if (mainIcon && loadingSpinner && menuText) {
                mainIcon.style.display = 'none';
                loadingSpinner.style.display = 'inline-block';
                menuText.style.opacity = '0.7';
                linkElement.style.pointerEvents = 'none';
                linkElement.classList.add('loading-state');
            }
        }

        function hideLoadingSpinner(linkElement) {
            const mainIcon = linkElement.querySelector('i:not(.loading-spinner)');
            const loadingSpinner = linkElement.querySelector('.loading-spinner');
            const menuText = linkElement.querySelector('.menu-text');

            if (mainIcon && loadingSpinner && menuText) {
                mainIcon.style.display = 'inline-block';
                loadingSpinner.style.display = 'none';
                menuText.style.opacity = '1';
                linkElement.style.pointerEvents = 'auto';
                linkElement.classList.remove('loading-state');
            }
        }

        function disableAllMenuLinks() {
            const allLinks = document.querySelectorAll('.nav-link[data-page]');
            allLinks.forEach(link => {
                if (!link.classList.contains('active')) {
                    link.style.pointerEvents = 'none';
                    link.style.opacity = '0.6';
                }
            });
        }

        function enableAllMenuLinks() {
            const allLinks = document.querySelectorAll('.nav-link[data-page]');
            allLinks.forEach(link => {
                if (!link.classList.contains('loading-state')) {
                    link.style.pointerEvents = 'auto';
                    link.style.opacity = '1';
                }
            });
        }

        // Reset loading state saat halaman selesai dimuat
        window.addEventListener('load', function() {
            const allLinks = document.querySelectorAll('.nav-link[data-page]');
            allLinks.forEach(link => {
                hideLoadingSpinner(link);
            });
            enableAllMenuLinks();
            setActiveMenu(); // Set ulang active menu
        });

        // Reset loading state saat user kembali ke halaman (back button)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const allLinks = document.querySelectorAll('.nav-link[data-page]');
                allLinks.forEach(link => {
                    hideLoadingSpinner(link);
                });
                enableAllMenuLinks();
                setActiveMenu(); // Set ulang active menu
            }
        });

        // Update active menu saat URL berubah (untuk SPA atau history navigation)
        window.addEventListener('popstate', function() {
            setActiveMenu();
        });
    </script>
    @stack('scripts')
</body>

<style>
    /* === CSS Variables === */
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1e40af;
        --secondary-color: #64748b;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --dark-bg: #0f172a;
        --dark-secondary: #1e293b;
        --sidebar-width: 280px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* === Reset & Base Styles === */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* === Sidebar Styles === */
    .sidebar {
        width: var(--sidebar-width);
        background: linear-gradient(180deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .sidebar ul li{
        width: 100%;
    }

    .sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(37, 99, 235, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        pointer-events: none;
    }

    .sidebar-logo {
        padding: 2rem 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        flex-shrink: 0;
    }

    .sidebar-logo h4 {
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #60a5fa, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .sidebar-logo::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), #a78bfa);
        border-radius: 1px;
    }

    /* === Menu Section === */
    .menu-section {
        padding: 1.5rem 1rem;
        flex: 1;
        overflow-y: auto;
    }

    .menu-title {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        padding-left: 1rem;
    }

    .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.875rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 12px;
        margin: 0 0.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: var(--transition);
    }

    .nav-link:hover::before {
        left: 100%;
    }

    .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(8px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .nav-link.active {
        color: white;
        background: linear-gradient(135deg, var(--primary-color), #a78bfa);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        transform: translateX(8px);
    }

    .nav-link.active:hover {
        background: linear-gradient(135deg, var(--primary-dark), #9333ea);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
    }

    .nav-link i {
        width: 20px;
        margin-right: 0.75rem;
        font-size: 1.1rem;
        text-align: center;
    }

    /* === Loading Spinner Styles === */
    .loading-spinner {
        color: #60a5fa !important;
        animation: spin 1s linear infinite;
        margin-right: 0.75rem !important;
        width: 20px;
    }

    .nav-link.loading-state {
        background: rgba(255, 255, 255, 0.15) !important;
        cursor: not-allowed;
    }

    .nav-link.loading-state:hover {
        transform: translateX(8px);
    }

    .menu-text {
        transition: opacity 0.3s ease;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* === Settings Section === */
    .settings-section {
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
    }

    .special-button {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.5rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .special-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        color: white;
        text-decoration: none;
    }

    .special-button i {
        margin-right: 0.5rem;
    }

    /* === Main Content === */
    .main-content {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .content-wrapper {
        padding: 2rem;
        max-width: 100%;
        width: 100%;
    }

    /* === Responsive Design === */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: var(--sidebar-width);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }

        .content-wrapper {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .sidebar {
            width: 100%;
        }

        .sidebar-logo h4 {
            font-size: 1.25rem;
        }

        .nav-link {
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
        }

        .nav-link i {
            margin-right: 0.5rem;
        }
    }

    /* === Scrollbar Styling === */
    .menu-section::-webkit-scrollbar {
        width: 4px;
    }

    .menu-section::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }

    .menu-section::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .menu-section::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* === Additional Utility Classes === */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</html>
