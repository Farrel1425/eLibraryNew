@extends('layouts.anggota')

@section('content')

        <!-- Navigation -->
        <div class="navigation">
            <button class="nav-btn active" onclick="showSection('books')">
                <i class="fas fa-books"></i>
                Koleksi Buku
            </button>
            <button class="nav-btn" onclick="showSection('loans')">
                <i class="fas fa-clipboard-list"></i>
                Peminjaman Saya
            </button>
            <button class="nav-btn" onclick="showSection('about')">
                <i class="fas fa-info-circle"></i>
                Tentang Perpustakaan
            </button>
        </div>

        <!-- Books Section -->
        <div id="books" class="content-section active">
            <div class="card">
                <h2><i class="fas fa-book"></i> Koleksi Buku Perpustakaan</h2>
                
                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-number">2,847</div>
                        <div>Total Buku</div>
                    </div>
                    <div class="stat-card green">
                        <div class="stat-number">2,156</div>
                        <div>Buku Tersedia</div>
                    </div>
                    <div class="stat-card purple">
                        <div class="stat-number">691</div>
                        <div>Sedang Dipinjam</div>
                    </div>
                </div>

                <!-- Search -->
                <input type="text" class="search-box" placeholder="🔍 Cari buku berdasarkan judul atau pengarang..." id="searchInput">

                <!-- Books Grid -->
                <div class="books-grid" id="booksGrid">
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-book"></i></div>
                        <div class="book-title">Matematika SMP Kelas 8</div>
                        <div class="book-author">Dr. Soekarno</div>
                        <div class="book-status available">Tersedia</div>
                    </div>
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-flask"></i></div>
                        <div class="book-title">IPA Terpadu SMP</div>
                        <div class="book-author">Prof. Habibie</div>
                        <div class="book-status borrowed">Dipinjam</div>
                    </div>
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-globe"></i></div>
                        <div class="book-title">Geografi Indonesia</div>
                        <div class="book-author">Drs. Kartini</div>
                        <div class="book-status available">Tersedia</div>
                    </div>
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-language"></i></div>
                        <div class="book-title">Bahasa Inggris SMP</div>
                        <div class="book-author">Ms. Sarah Johnson</div>
                        <div class="book-status available">Tersedia</div>
                    </div>
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-history"></i></div>
                        <div class="book-title">Sejarah Nusantara</div>
                        <div class="book-author">Prof. Sutomo</div>
                        <div class="book-status borrowed">Dipinjam</div>
                    </div>
                    <div class="book-card">
                        <div class="book-cover"><i class="fas fa-paint-brush"></i></div>
                        <div class="book-title">Seni Budaya SMP</div>
                        <div class="book-author">Dra. Dewi Sartika</div>
                        <div class="book-status available">Tersedia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans Section -->
        <div id="loans" class="content-section">
            <div class="card">
                <h2><i class="fas fa-clipboard-list"></i> Riwayat Peminjaman Buku</h2>
                
                <table class="loan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Matematika SMP Kelas 8</td>
                            <td>15 Mei 2025</td>
                            <td>29 Mei 2025</td>
                            <td><span class="book-status borrowed">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Bahasa Indonesia SMP</td>
                            <td>10 Mei 2025</td>
                            <td>20 Mei 2025</td>
                            <td><span class="book-status available">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>IPA Terpadu Kelas 8</td>
                            <td>5 Mei 2025</td>
                            <td>19 Mei 2025</td>
                            <td><span class="book-status available">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Sejarah Indonesia</td>
                            <td>1 Mei 2025</td>
                            <td>15 Mei 2025</td>
                            <td><span class="book-status available">Dikembalikan</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h2><i class="fas fa-chart-bar"></i> Statistik Peminjaman</h2>
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-number">1</div>
                        <div>Buku Dipinjam</div>
                    </div>
                    <div class="stat-card green">
                        <div class="stat-number">3</div>
                        <div>Buku Dikembalikan</div>
                    </div>
                    <div class="stat-card red">
                        <div class="stat-number">0</div>
                        <div>Keterlambatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div id="about" class="content-section">
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> Tentang Perpustakaan SMPK 2 Harapan</h2>
                
                <div class="about-content">
                    <p>Perpustakaan SMPK 2 Harapan merupakan jantung pembelajaran di sekolah kami. Didirikan pada tahun 1985, perpustakaan ini telah menjadi pusat sumber belajar yang mendukung kegiatan akademik siswa dan guru.</p>

                    <h3><i class="fas fa-bullseye"></i> Visi</h3>
                    <p>Menjadi perpustakaan sekolah terdepan yang menyediakan sumber informasi berkualitas dan layanan prima untuk mendukung terciptanya generasi yang gemar membaca dan berpengetahuan luas.</p>

                    <h3><i class="fas fa-rocket"></i> Misi</h3>
                    <p>1. Menyediakan koleksi buku dan sumber informasi yang relevan dengan kurikulum<br>
                    2. Memberikan layanan perpustakaan yang profesional dan ramah<br>
                    3. Menciptakan lingkungan belajar yang nyaman dan kondusif<br>
                    4. Mengembangkan minat baca siswa melalui berbagai program literasi</p>

                    <h3><i class="fas fa-cogs"></i> Fasilitas</h3>
                    <div class="facility-grid">
                        <div class="facility-card">
                            <div class="facility-icon"><i class="fas fa-book-reader"></i></div>
                            <h4>Ruang Baca</h4>
                            <p>Ruang baca yang nyaman dengan kapasitas 60 siswa</p>
                        </div>
                        <div class="facility-card">
                            <div class="facility-icon"><i class="fas fa-laptop"></i></div>
                            <h4>Komputer & Internet</h4>
                            <p>10 unit komputer dengan akses internet gratis</p>
                        </div>
                        <div class="facility-card">
                            <div class="facility-icon"><i class="fas fa-tv"></i></div>
                            <h4>Audio Visual</h4>
                            <p>Ruang multimedia untuk pembelajaran interaktif</p>
                        </div>
                        <div class="facility-card">
                            <div class="facility-icon"><i class="fas fa-wifi"></i></div>
                            <h4>WiFi Gratis</h4>
                            <p>Akses internet nirkabel di seluruh area perpustakaan</p>
                        </div>
                    </div>

                    <h3><i class="fas fa-clock"></i> Jam Operasional</h3>
                    <p><strong>Senin - Jumat:</strong> 07.00 - 15.30 WIB<br>
                    <strong>Sabtu:</strong> 07.00 - 12.00 WIB<br>
                    <strong>Minggu & Hari Libur:</strong> Tutup</p>

                    <h3><i class="fas fa-phone"></i> Kontak</h3>
                    <p><strong>Alamat:</strong> Jl. Harapan Bangsa No. 123, Jakarta Timur<br>
                    <strong>Telepon:</strong> (021) 8765-4321<br>
                    <strong>Email:</strong> perpustakaan@smpk2harapan.sch.id</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation functionality
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Remove active class from all nav buttons
            const navBtns = document.querySelectorAll('.nav-btn');
            navBtns.forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(card => {
                const title = card.querySelector('.book-title').textContent.toLowerCase();
                const author = card.querySelector('.book-author').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Add some interactivity to book cards
        document.querySelectorAll('.book-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.book-title').textContent;
                const status = this.querySelector('.book-status').textContent;
                
                if (status === 'Tersedia') {
                    alert(`Buku "${title}" tersedia untuk dipinjam! Silakan hubungi petugas perpustakaan.`);
                } else {
                    alert(`Buku "${title}" sedang dipinjam. Silakan coba lagi nanti.`);
                }
            });
        });

        // Welcome animation
        window.addEventListener('load', function() {
            const header = document.querySelector('.header');
            header.style.transform = 'translateY(-50px)';
            header.style.opacity = '0';
            
            setTimeout(() => {
                header.style.transition = 'all 0.6s ease';
                header.style.transform = 'translateY(0)';
                header.style.opacity = '1';
            }, 100);
        });
    </script>

@endsection