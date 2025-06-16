@extends('layouts.petugas')

@section('title', 'Daftar Anggota')

@section('content')
<!-- Main Content -->
<div class="container mt-4" id="mainContent">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Anggota</h3>
        <a href="{{ route('petugas.anggota.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="row mb-3">
        <!-- Search Column -->
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchInput"
                       placeholder="Cari anggota berdasarkan NIS, nama, atau no HP..." autocomplete="off">
                <button class="btn btn-outline-secondary" type="button" onclick="resetSearch()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Filter Column -->
        <div class="col-md-4">
            <div class="d-flex gap-2">
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="non-aktif">Non Aktif</option>
                </select>
                <select class="form-select" id="genderFilter">
                    <option value="">Semua Gender</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
                <button class="btn btn-outline-secondary" onclick="MemberManager.clearAllFilters()" title="Reset Filter">
                    <i class="fas fa-refresh"></i>
                </button>
            </div>
        </div>

        <!-- Total Count Column -->
        <div class="col-md-2 d-flex justify-content-end align-items-center">
            <span class="badge bg-secondary fs-6" id="resultCount">
                Total: {{ $anggota->where('status_anggota', 'Aktif')->count() }} anggota
            </span>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped table-hover" id="memberTable">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="align-middle" style="width: 50px;">No</th>
                    <th class="align-middle" style="width: 120px;">NIS</th>
                    <th class="align-middle">Nama</th>
                    <th class="align-middle" style="width: 130px;">No HP</th>
                    <th class="align-middle" style="width: 120px;">Jenis Kelamin</th>
                    <th class="align-middle" style="width: 100px;">Status</th>
                    <th class="align-middle" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="memberTableBody">
                @forelse ($anggota as $item)
                    <tr class="member-row" data-search="{{ strtolower($item->nis . ' ' . $item->nama_anggota . ' ' . $item->no_hp . ' ' . $item->jenis_kelamin . ' ' . $item->status_anggota) }}">
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="text-center align-middle">
                            <span class="badge bg-info">{{ $item->nis }}</span>
                        </td>
                        <td class="align-middle">
                            <strong>{{ $item->nama_anggota }}</strong>
                        </td>
                        <td class="text-center align-middle">
                            <span class="text-muted">{{ $item->no_hp }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $item->jenis_kelamin == 'Laki-laki' ? 'bg-primary' : 'bg-pink' }}">
                                {{ $item->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-{{ $item->status_anggota === 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $item->status_anggota }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('petugas.anggota.show', $item->id) }}"
                                   class="btn btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('petugas.anggota.edit', $item->id) }}"
                                   class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger delete-btn"
                                        onclick="confirmDelete('{{ $item->nama_anggota }}', '{{ route('petugas.anggota.destroy', $item->id) }}')"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyRow">
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada anggota yang tersedia</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="text-center py-4" style="display: none;">
        <i class="fas fa-search fa-2x text-muted mb-2"></i>
        <p class="text-muted mb-0">Tidak ditemukan anggota yang sesuai</p>
        <small class="text-muted">Coba gunakan kata kunci yang berbeda</small>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Data untuk JavaScript -->
<!-- FIXED: Pass data anggota aktif saja ke JavaScript -->
<div id="pageData"
     data-original-count="{{ $anggota->where('status_anggota', 'Aktif')->count() }}"
     data-total-active="{{ $anggota->where('status_anggota', 'Aktif')->count() }}"
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

    .member-row {
        transition: all 0.2s ease;
    }

    .member-row:hover {
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

    .bg-pink {
        background-color: #e91e63 !important;
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

    /* Additional styles for better alignment */
    .form-select {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 6px;
    }
</style>

<script>
(function() {
    'use strict';

    // Namespace untuk halaman anggota - mencegah konflik dengan layout
    const MemberManager = {
        // FIXED: Ambil data dari attribute data-total-active yang sudah dihitung di server
        totalActiveMembers: parseInt(document.getElementById('pageData')?.getAttribute('data-total-active') || '0'),

        init: function() {
            this.initSearch();
            this.initFilterEvents(); // Changed from addFilterDropdown
            this.initDeleteHandlers();
            this.initAlerts();
            this.initPageEvents();
            // UPDATED: Gunakan data yang sudah dihitung dari server
            this.updateInitialCount();
        },

        // SIMPLIFIED: Gunakan data yang sudah dihitung dari server-side
        updateInitialCount: function() {
            const resultCount = document.getElementById('resultCount');
            if (resultCount) {
                // Data sudah dihitung di server, tidak perlu hitung ulang
                resultCount.textContent = `Total: ${this.totalActiveMembers} anggota`;
                console.log('Debug - Total anggota:', this.totalActiveMembers);
            }
        },

        // SIMPLIFIED: Fungsi ini sekarang hanya untuk validasi, karena data utama sudah dari server
        countActiveMembers: function() {
            const rows = document.querySelectorAll('.member-row');
            let activeCount = 0;

            rows.forEach((row) => {
                const statusCell = row.cells[5];
                if (statusCell) {
                    const statusBadge = statusCell.querySelector('.badge');
                    if (statusBadge) {
                        const statusText = statusBadge.textContent.trim().toLowerCase();
                        if (statusText === 'aktif') {
                            activeCount++;
                        }
                    }
                }
            });

            return activeCount;
        },

        // UPDATED: Initialize filter events instead of adding HTML
        initFilterEvents: function() {
            // Add event listeners untuk dropdown yang sudah ada di HTML
            const statusFilter = document.getElementById('statusFilter');
            const genderFilter = document.getElementById('genderFilter');

            if (statusFilter) {
                statusFilter.addEventListener('change', () => this.filterMembers());
            }

            if (genderFilter) {
                genderFilter.addEventListener('change', () => this.filterMembers());
            }
        },

        clearAllFilters: function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('genderFilter').value = '';
            this.filterMembers();
        },

        initSearch: function() {
            const self = this;
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) return;

            let searchTimeout;

            // Real-time search with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => self.filterMembers(), 300);
            });

            // Enter key support
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    self.filterMembers();
                }
            });

            // Global reset function
            window.resetSearch = function() {
                searchInput.value = '';
                self.filterMembers();
            };
        },

        // UPDATED: Menggunakan data totalActiveMembers yang sudah dihitung dari server
        filterMembers: function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilter')?.value.toLowerCase() || '';
            const genderFilter = document.getElementById('genderFilter')?.value.toLowerCase() || '';
            const rows = document.querySelectorAll('.member-row');
            const noResults = document.getElementById('noResults');
            const resultCount = document.getElementById('resultCount');
            let visibleCount = 0;

            // Show/hide rows based on search and filters
            rows.forEach((row) => {
                let matchesSearch = true;
                let matchesStatus = true;
                let matchesGender = true;

                const cells = row.cells;
                if (!cells || cells.length < 6) return;

                const nisCell = cells[1]?.querySelector('.badge');
                const nis = nisCell ? nisCell.textContent.toLowerCase().trim() : '';

                const nama = cells[2]?.textContent.toLowerCase().trim() || '';
                const noHp = cells[3]?.textContent.toLowerCase().trim() || '';

                const genderBadge = cells[4]?.querySelector('.badge');
                const jenisKelamin = genderBadge ? genderBadge.textContent.toLowerCase().trim() : '';

                const statusBadge = cells[5]?.querySelector('.badge');
                const status = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';

                // Filter berdasarkan search term
                if (searchTerm) {
                    if (searchTerm === 'aktif') {
                        matchesSearch = status === 'aktif';
                    } else if (searchTerm === 'non aktif' || searchTerm === 'nonaktif' || searchTerm === 'tidak aktif' || searchTerm === 'non-aktif') {
                        matchesSearch = status !== 'aktif' && status !== '';
                    } else if (searchTerm === 'laki-laki' || searchTerm === 'laki' || searchTerm === 'pria') {
                        matchesSearch = jenisKelamin === 'laki-laki';
                    } else if (searchTerm === 'perempuan' || searchTerm === 'wanita') {
                        matchesSearch = jenisKelamin === 'perempuan';
                    } else {
                        // Untuk pencarian umum lainnya (NIS, nama, no HP)
                        matchesSearch = nis.includes(searchTerm) ||
                                       nama.includes(searchTerm) ||
                                       noHp.includes(searchTerm);
                    }
                }

                // Filter berdasarkan status dropdown
                if (statusFilter) {
                    if (statusFilter === 'aktif') {
                        matchesStatus = status === 'aktif';
                    } else if (statusFilter === 'non-aktif') {
                        matchesStatus = status !== 'aktif' && status !== '';
                    }
                }

                // Filter berdasarkan gender dropdown
                if (genderFilter) {
                    if (genderFilter === 'laki-laki') {
                        matchesGender = jenisKelamin === 'laki-laki';
                    } else if (genderFilter === 'perempuan') {
                        matchesGender = jenisKelamin === 'perempuan';
                    }
                }

                // Tampilkan row jika semua kondisi terpenuhi
                const shouldShow = matchesSearch && matchesStatus && matchesGender;

                if (shouldShow) {
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

            // FIXED: Update result count menggunakan data yang sudah dihitung dari server
            if (resultCount) {
                const hasFilters = searchTerm || statusFilter || genderFilter;
                if (!hasFilters) {
                    // Tanpa filter: gunakan data yang sudah dihitung dari server
                    resultCount.textContent = `Total: ${this.totalActiveMembers} anggota`;
                } else {
                    // Dengan filter: tampilkan hasil filter dari total anggota aktif
                    resultCount.textContent = `Ditemukan: ${visibleCount}`;
                }

                console.log('Debug - Visible count:', visibleCount, 'Has filters:', hasFilters);
            }

            // Show/hide no results message
            const memberTable = document.getElementById('memberTable');
            if (noResults && memberTable) {
                const hasFilters = searchTerm || statusFilter || genderFilter;
                if (visibleCount === 0 && hasFilters) {
                    noResults.style.display = 'block';
                    memberTable.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    memberTable.style.display = 'table';
                }
            }
        },

        resetDeleteButton: function(button) {
            if (button) {
                button.innerHTML = '<i class="fas fa-trash"></i>';
                button.disabled = false;
            }
        },

        initDeleteHandlers: function() {
            const self = this;

            // Global delete confirmation function
            window.confirmDelete = function(memberName, actionUrl) {
                const clickedButton = event.target.closest('.delete-btn');

                if (clickedButton) {
                    clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    clickedButton.disabled = true;
                }

                setTimeout(() => {
                    const confirmed = confirm(`Apakah Anda yakin ingin menghapus anggota "${memberName}"?\n\nTindakan ini tidak dapat dibatalkan!`);

                    if (confirmed) {
                        const form = document.getElementById('deleteForm');
                        if (form) {
                            form.action = actionUrl;
                            form.submit();
                        }
                    } else {
                        self.resetDeleteButton(clickedButton);
                    }
                }, 50);
            };

            document.querySelectorAll('.delete-btn').forEach(button => {
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
            });
        },

        initAlerts: function() {
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
            document.addEventListener('visibilitychange', function() {
                console.log(document.hidden ? 'Page hidden' : 'Page visible');
            });

            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    console.log('Page loaded from cache');
                }
            });
        }
    };

    window.MemberManager = MemberManager;

    function initializeMember() {
        if (typeof MemberManager !== 'undefined') {
            MemberManager.init();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeMember, 100);
        });
    } else {
        setTimeout(initializeMember, 100);
    }
})();
</script>
@endsection
