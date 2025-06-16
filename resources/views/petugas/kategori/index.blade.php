@extends('layouts.petugas')

@section('title', 'Daftar Kategori Buku')

@section('content')
<!-- Main Content -->
<div class="container mt-4" id="mainContent">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Kategori</h3>
        <a href="{{ route('petugas.kategori.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Compact Search Section -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div style="width: 50%;">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchInput"
                       placeholder="Cari kategori..." autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" onclick="resetSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div>
            <span class="badge bg-secondary fs-6" id="resultCount">
                Total: {{ count($kategoris) }} kategori
            </span>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped table-hover" id="categoryTable">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="align-middle" style="width: 50px;">No</th>
                    <th class="align-middle">Nama Kategori</th>
                    <th class="align-middle">Deskripsi</th>
                    <th class="align-middle" style="width: 100px;">Jumlah Buku</th>
                    <th class="align-middle" style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                @forelse ($kategoris as $kategori)
                    <tr class="category-row" data-search="{{ strtolower($kategori->nama_kategori . ' ' . ($kategori->deskripsi ?? '')) }}">
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <strong>{{ $kategori->nama_kategori }}</strong>
                        </td>
                        <td class="align-middle">
                            <span class="text-muted">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-info">{{ $kategori->jumlah_buku }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('petugas.kategori.show', $kategori->id) }}"
                                   class="btn btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('petugas.kategori.edit', $kategori->id) }}"
                                   class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger delete-btn"
                                        onclick="confirmDelete('{{ $kategori->nama_kategori }}', '{{ route('petugas.kategori.destroy', $kategori->id) }}')"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada kategori yang tersedia</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="text-center py-4" style="display: none;">
        <i class="fas fa-search fa-2x text-muted mb-2"></i>
        <p class="text-muted mb-0">Tidak ditemukan kategori yang sesuai</p>
        <small class="text-muted">Coba gunakan kata kunci yang berbeda</small>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Data untuk JavaScript -->
<div id="pageData" data-original-count="{{ count($kategoris) }}" style="display: none;"></div>

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

    .category-row {
        transition: all 0.2s ease;
    }

    .category-row:hover {
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
</style>

<script>
(function() {
    'use strict';

    // Namespace untuk halaman kategori - mencegah konflik dengan layout
    const CategoryManager = {
        originalRowCount: {{ count($kategoris) }},

        init: function() {
            this.initSearch();
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
                searchTimeout = setTimeout(() => self.searchCategories(), 300);
            });

            // Enter key support
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    self.searchCategories();
                }
            });

            // Global reset function
            window.resetSearch = function() {
                searchInput.value = '';
                self.searchCategories();
            };
        },

        searchCategories: function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.category-row');
            const noResults = document.getElementById('noResults');
            const resultCount = document.getElementById('resultCount');
            let visibleCount = 0;

            // Show/hide rows based on search
            rows.forEach((row) => {
                const searchData = row.getAttribute('data-search');
                const isVisible = searchData && searchData.includes(searchTerm);

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
            if (resultCount) {
                if (searchTerm === '') {
                    resultCount.textContent = `Total: ${this.originalRowCount} kategori`;
                } else {
                    resultCount.textContent = `Ditemukan: ${visibleCount} dari ${this.originalRowCount} kategori`;
                }
            }

            // Show/hide no results message
            const categoryTable = document.getElementById('categoryTable');
            if (noResults && categoryTable) {
                if (visibleCount === 0 && searchTerm !== '') {
                    noResults.style.display = 'block';
                    categoryTable.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    categoryTable.style.display = 'table';
                }
            }
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
            window.confirmDelete = function(categoryName, actionUrl) {
                // Temukan tombol yang diklik
                const clickedButton = event.target.closest('.delete-btn');

                // Tampilkan loading effect
                if (clickedButton) {
                    clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    clickedButton.disabled = true;
                }

                // Tampilkan konfirmasi dengan delay kecil untuk memastikan UI update
                setTimeout(() => {
                    const confirmed = confirm(`Apakah Anda yakin ingin menghapus kategori "${categoryName}"?\n\nTindakan ini tidak dapat dibatalkan!`);

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
    function initializeCategory() {
        if (typeof CategoryManager !== 'undefined') {
            CategoryManager.init();
        }
    }

    // Tunggu layout selesai load dulu, baru jalankan kategori
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeCategory, 100);
        });
    } else {
        setTimeout(initializeCategory, 100);
    }
})();
</script>
@endsection
