@extends('layouts.petugas')

@section('title', 'Daftar Buku')

@section('content')
<!-- Main Content -->
<div class="container mt-4" id="mainContent">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Buku</h3>
        <a href="{{ route('petugas.buku.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Section - Updated to match Anggota layout -->
    <div class="row mb-3">
        <!-- Search Column -->
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchInput"
                       placeholder="Cari buku berdasarkan judul, penulis, atau kategori..." autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Filter Column -->
        <div class="col-md-4">
            <div class="d-flex gap-2">
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="tidak tersedia">Tidak Tersedia</option>
                </select>
                <button class="btn btn-outline-secondary" onclick="resetSearch()" title="Reset semua filter">
                    <i class="fas fa-undo"></i>
                </button>
            </div>
        </div>

        <!-- Total Count Column -->
        <div class="col-md-2 d-flex justify-content-end align-items-center">
            <span class="badge bg-secondary fs-6" id="resultCount">
                Total: {{ $buku->where('status_buku', 'Tersedia')->count() }} buku tersedia
            </span>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped table-hover" id="bookTable">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="align-middle" style="width: 50px;">No</th>
                    <th class="align-middle">Judul</th>
                    <th class="align-middle">Penulis</th>
                    <th class="align-middle">Kategori</th>
                    <th class="align-middle" style="width: 80px;">Stok</th>
                    <th class="align-middle" style="width: 100px;">Status</th>
                    <th class="align-middle" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="bookTableBody">
                @forelse ($buku as $item)
                    <tr class="book-row"
                        data-search="{{ strtolower($item->judul . ' ' . $item->penulis . ' ' . ($item->kategori ? $item->kategori->nama_kategori : '') . ' ' . $item->status_buku) }}"
                        data-status="{{ strtolower($item->status_buku) }}">
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle" title="{{ $item->judul }}" style="max-width: 300px;">
                            <strong>{{ Str::limit($item->judul, 40, '...') }}</strong>
                        </td>
                        <td class="align-middle">{{ $item->penulis }}</td>
                        <td class="text-center align-middle">
                            @if($item->kategori)
                                <span class="badge bg-primary">{{ $item->kategori->nama_kategori }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-danger' }}">{{ $item->stok }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $item->status_buku == 'Tersedia' ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->status_buku }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('petugas.buku.show', $item->id) }}"
                                   class="btn btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('petugas.buku.edit', $item->id) }}"
                                   class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger delete-btn"
                                        onclick="confirmDelete('{{ $item->judul }}', '{{ route('petugas.buku.destroy', $item->id) }}')"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada buku yang tersedia</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="text-center py-4" style="display: none;">
        <i class="fas fa-search fa-2x text-muted mb-2"></i>
        <p class="text-muted mb-0">Tidak ditemukan buku yang sesuai</p>
        <small class="text-muted">Coba gunakan kata kunci yang berbeda atau ubah filter status</small>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Data untuk JavaScript -->
<div id="pageData"
     data-original-count="{{ count($buku) }}"
     data-tersedia-count="{{ $buku->where('status_buku', 'Tersedia')->count() }}"
     data-tidak-tersedia-count="{{ $buku->where('status_buku', 'Tidak Tersedia')->count() }}"
     style="display: none;">
</div>

<style>
    /* Main Content Animation */
    .fade-in {
        animation: fadeInUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Existing Styles */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .book-row {
        transition: all 0.2s ease;
    }

    .book-row:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .input-group {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 6px;
        overflow: hidden;
    }

    .form-select {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 6px;
        border: 1px solid #ced4da;
    }

    .badge {
        font-size: 0.75rem;
    }

    #resultCount {
        padding: 0.5rem 0.75rem;
    }

    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .table thead th {
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Book specific styles */
    .book-row td:nth-child(2) {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Additional styles for better alignment */
    .gap-2 {
        gap: 0.5rem !important;
    }
</style>

<script>
(function() {
    'use strict';

    // Namespace untuk halaman buku - mencegah konflik dengan layout
    const BookManager = {
        originalRowCount: {{ count($buku) }},
        tersediaCount: {{ $buku->where('status_buku', 'Tersedia')->count() }},
        tidakTersediaCount: {{ $buku->where('status_buku', 'Tidak Tersedia')->count() }},

        init: function() {
            this.initSearch();
            this.initFilter();
            this.initDeleteHandlers();
            this.initAlerts();
            this.initPageEvents();
        },

        initSearch: function() {
            const self = this;
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) return;

            let searchTimeout;

            // Real-time search with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => self.filterBooks(), 300);
            });

            // Enter key support
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    self.filterBooks();
                }
            });

            // Global reset function - updated to match anggota layout
            window.resetSearch = function() {
                searchInput.value = '';
                document.getElementById('statusFilter').value = '';
                self.filterBooks();
            };

            // Function untuk clear search input saja (tombol X)
            window.clearSearch = function() {
                searchInput.value = '';
                self.filterBooks();
            };
        },

        initFilter: function() {
            const self = this;
            const statusFilter = document.getElementById('statusFilter');

            if (!statusFilter) return;

            statusFilter.addEventListener('change', function() {
                self.filterBooks();
            });
        },

        filterBooks: function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.book-row');
            const noResults = document.getElementById('noResults');
            const resultCount = document.getElementById('resultCount');
            let visibleCount = 0;

            // Show/hide rows based on search and filter
            rows.forEach((row) => {
                const searchData = row.getAttribute('data-search');
                const statusData = row.getAttribute('data-status');

                const matchesSearch = !searchTerm || (searchData && searchData.includes(searchTerm));
                const matchesStatus = !statusFilter || statusData === statusFilter;
                const isVisible = matchesSearch && matchesStatus;

                if (isVisible) {
                    row.style.display = '';
                    visibleCount++;
                    // Update row number
                    const firstCell = row.cells[0];
                    if (firstCell) {
                        firstCell.textContent = visibleCount;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Update result count
            this.updateResultCount(searchTerm, statusFilter, visibleCount);

            // Show/hide no results message
            const bookTable = document.getElementById('bookTable');
            if (noResults && bookTable) {
                if (visibleCount === 0 && (searchTerm !== '' || statusFilter !== '')) {
                    noResults.style.display = 'block';
                    bookTable.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    bookTable.style.display = 'table';
                }
            }
        },

        updateResultCount: function(searchTerm, statusFilter, visibleCount) {
            const resultCount = document.getElementById('resultCount');
            if (!resultCount) return;

            let countText = '';

            if (searchTerm === '' && statusFilter === '') {
                // Tampilkan hanya buku tersedia sebagai default
                countText = `Total: ${this.tersediaCount} buku tersedia`;
            } else if (statusFilter === 'tersedia') {
                if (searchTerm === '') {
                    countText = `Total: ${this.tersediaCount} buku tersedia`;
                } else {
                    countText = `Ditemukan: ${visibleCount} dari ${this.tersediaCount} buku tersedia`;
                }
            } else if (statusFilter === 'tidak tersedia') {
                if (searchTerm === '') {
                    countText = `Total: ${this.tidakTersediaCount} buku tidak tersedia`;
                } else {
                    countText = `Ditemukan: ${visibleCount} dari ${this.tidakTersediaCount} buku tidak tersedia`;
                }
            } else {
                // Jika ada pencarian tapi tidak ada filter status
                if (searchTerm !== '') {
                    countText = `Ditemukan: ${visibleCount} dari ${this.originalRowCount} buku`;
                } else {
                    countText = `Total: ${this.originalRowCount} buku`;
                }
            }

            resultCount.textContent = countText;
        },

        // Function untuk reset tombol delete ke kondisi semula
        resetDeleteButton: function(button) {
            if (button) {
                button.innerHTML = '<i class="fas fa-trash"></i>';
                button.disabled = false;
            }
        },

        initDeleteHandlers: function() {
            const self = this;

            // Global delete confirmation function
            window.confirmDelete = function(bookTitle, actionUrl) {
                // Temukan tombol yang diklik
                const clickedButton = event.target.closest('.delete-btn');

                // Tampilkan loading effect
                if (clickedButton) {
                    clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    clickedButton.disabled = true;
                }

                // Tampilkan konfirmasi dengan delay kecil untuk memastikan UI update
                setTimeout(() => {
                    const confirmed = confirm(`Apakah Anda yakin ingin menghapus buku "${bookTitle}"?\n\nTindakan ini tidak dapat dibatalkan!`);

                    if (confirmed) {
                        // Jika dikonfirmasi, submit form
                        const form = document.getElementById('deleteForm');
                        if (form) {
                            form.action = actionUrl;
                            form.submit();
                        }
                    } else {
                        // Jika dibatalkan, reset tombol ke kondisi semula
                        self.resetDeleteButton(clickedButton);
                    }
                }, 50);
            };

            // Remove old event listeners untuk menghindari duplikasi
            document.querySelectorAll('.delete-btn').forEach(button => {
                // Clone node untuk menghapus semua event listener
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
            });
        },

        initAlerts: function() {
            // Auto-hide success alert
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'all 0.3s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }, 5000);
            }
        },

        initPageEvents: function() {
            // Handle page visibility changes
            document.addEventListener('visibilitychange', function() {
                console.log(document.hidden ? 'Page hidden' : 'Page visible');
            });

            // Prevent loading screen from showing on back button
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    console.log('Page loaded from cache');
                }
            });
        }
    };

    // Initialize ketika DOM ready dengan delay untuk menghindari konflik
    function initializeBook() {
        if (typeof BookManager !== 'undefined') {
            BookManager.init();
        }
    }

    // Tunggu layout selesai load dulu, baru jalankan buku
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeBook, 100);
        });
    } else {
        setTimeout(initializeBook, 100);
    }
})();
</script>
@endsection
