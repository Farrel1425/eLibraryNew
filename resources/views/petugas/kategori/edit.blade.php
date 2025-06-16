@extends('layouts.petugas')

@section('title', 'Edit Kategori')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('petugas.kategori.index') }}" class="text-decoration-none">
                    <i class="fas fa-list-alt"></i> Daftar Kategori
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fas fa-edit"></i> Edit Kategori
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">
                <i class="fas fa-edit text-primary"></i>
                Edit Kategori Buku
            </h3>
            <p class="text-muted mb-0">Perbarui informasi kategori "{{ $kategori->nama_kategori }}" dalam sistem perpustakaan</p>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Oops! Ada masalah dengan input Anda:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-edit text-success"></i>
                Update Informasi Kategori
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('petugas.kategori.update', $kategori->id) }}" method="POST" id="categoryForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">
                        <i class="fas fa-tag text-primary"></i>
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <div class="position-relative">
                        <input type="text"
                               name="nama_kategori"
                               class="form-control"
                               id="nama_kategori"
                               maxlength="50"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               placeholder="Masukkan nama kategori (contoh: Fiksi, Non-Fiksi, Sains)"
                               required>
                        <div class="form-text d-flex justify-content-between">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Nama kategori harus unik dan maksimal 50 karakter
                            </small>
                            <small class="text-muted" id="nameCount">0/50</small>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="form-label">
                        <i class="fas fa-align-left text-primary"></i>
                        Deskripsi <span class="text-muted">(opsional)</span>
                    </label>
                    <div class="position-relative">
                        <textarea name="deskripsi"
                                  class="form-control"
                                  id="deskripsi"
                                  rows="4"
                                  maxlength="255"
                                  placeholder="Masukkan deskripsi kategori untuk memberikan informasi lebih detail tentang jenis buku yang termasuk dalam kategori ini...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        <div class="form-text d-flex justify-content-between">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb"></i>
                                Deskripsi membantu pengguna memahami jenis buku dalam kategori ini
                            </small>
                            <small class="text-muted" id="descCount">0/255</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('petugas.kategori.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-header {
        border-bottom: 1px solid #e9ecef;
        border-radius: 10px 10px 0 0 !important;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .breadcrumb {
        background: none;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #6c757d;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: #0d6efd;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counters
        const nameInput = document.getElementById('nama_kategori');
        const descInput = document.getElementById('deskripsi');
        const nameCount = document.getElementById('nameCount');
        const descCount = document.getElementById('descCount');

        function updateCharCount(input, counter, max) {
            const current = input.value.length;
            counter.textContent = `${current}/${max}`;

            if (current > max * 0.8) {
                counter.style.color = '#dc3545';
            } else if (current > max * 0.6) {
                counter.style.color = '#fd7e14';
            } else {
                counter.style.color = '#6c757d';
            }
        }

        nameInput.addEventListener('input', function() {
            updateCharCount(this, nameCount, 50);
        });

        descInput.addEventListener('input', function() {
            updateCharCount(this, descCount, 255);
        });

        // Initialize counters
        updateCharCount(nameInput, nameCount, 50);
        updateCharCount(descInput, descCount, 255);

        // Form submission with loading state
        const form = document.getElementById('categoryForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            // Validate form
            if (!validateForm()) {
                e.preventDefault();
                return;
            }

            // Add loading state
            const icon = submitBtn.querySelector('i');
            const text = submitBtn.innerHTML.replace(/<i[^>]*><\/i>\s*/, '');

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memperbarui...';
            submitBtn.disabled = true;
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.transition = 'all 0.3s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }
            }, 5000);
        });
    });

    // Form validation
    function validateForm() {
        const nameInput = document.getElementById('nama_kategori');
        const name = nameInput.value.trim();

        if (name.length < 2) {
            showError('Nama kategori harus minimal 2 karakter!');
            nameInput.focus();
            return false;
        }

        if (name.length > 50) {
            showError('Nama kategori maksimal 50 karakter!');
            nameInput.focus();
            return false;
        }

        return true;
    }

    function showError(message) {
        // Create temporary alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert before form card
        const formCard = document.querySelector('.card');
        formCard.parentNode.insertBefore(alertDiv, formCard);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    // Confirmation before leaving with unsaved changes
    let formChanged = false;
    const formInputs = document.querySelectorAll('#categoryForm input, #categoryForm textarea');
    const originalValues = {};

    formInputs.forEach(input => {
        originalValues[input.name] = input.value;
        input.addEventListener('input', function() {
            formChanged = (this.value !== originalValues[this.name]);
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Reset form changed flag on successful submission
    document.getElementById('categoryForm').addEventListener('submit', function() {
        formChanged = false;
    });
</script>
@endsection
