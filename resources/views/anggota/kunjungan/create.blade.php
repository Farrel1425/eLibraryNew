<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kunjungan Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
            --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,0 1000,300 1000,1000 0,700"/><polygon fill="rgba(255,255,255,0.03)" points="0,300 1000,600 1000,1000 0,1000"/></svg>');
            pointer-events: none;
            z-index: 0;
        }

        .form-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px 20px;
            position: relative;
            z-index: 1;
        }

        .library-icon {
            position: absolute;
            top: -45px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 70px;
            background: var(--success-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.2);
            z-index: 10;
        }

        .library-icon i {
            font-size: 2rem;
            color: white;
        }

        .card {
            width: 100%;
            max-width: 480px;
            border: none;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            box-shadow:
                0 25px 45px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: visible;
            animation: slideUp 0.6s ease-out;
            margin-top: 45px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-gradient);
        }

        .card-header {
            background: transparent !important;
            border: none;
            padding: 3.5rem 2rem 1.5rem;
            text-align: center;
            position: relative;
        }

        .card-header h4 {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-header .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        .card-body {
            padding: 1.5rem 2rem 2.5rem;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .alert-success {
            background: rgba(17, 153, 142, 0.15);
            color: #0d7377;
            border: 1px solid rgba(17, 153, 142, 0.2);
        }

        .alert-success::before {
            background: var(--success-gradient);
        }

        .alert-warning {
            background: rgba(252, 74, 26, 0.15);
            color: #b8610a;
            border: 1px solid rgba(252, 74, 26, 0.2);
        }

        .alert-warning::before {
            background: var(--warning-gradient);
        }

        .alert-danger {
            background: rgba(252, 70, 107, 0.15);
            color: #b91c1c;
            border: 1px solid rgba(252, 70, 107, 0.2);
        }

        .alert-danger::before {
            background: var(--danger-gradient);
        }

        /* Form Styles */
        .form-label {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control.is-invalid {
            border-color: rgba(252, 70, 107, 0.5);
            background: rgba(252, 70, 107, 0.1);
        }

        .invalid-feedback {
            color: #fc466b;
            font-weight: 500;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Button Styles */
        .btn-success {
            background: var(--success-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(17, 153, 142, 0.4);
            background: linear-gradient(135deg, #0d7377 0%, #2dd4bf 100%);
        }

        .btn-success:hover::before {
            left: 100%;
        }

        .btn-success:active {
            transform: translateY(-1px);
        }

        /* Input Group Icon */
        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-right: none;
            color: rgba(255, 255, 255, 0.8);
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-book {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            font-size: 2rem;
            animation: float 6s ease-in-out infinite;
        }

        .floating-book:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-book:nth-child(2) {
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-book:nth-child(3) {
            top: 40%;
            left: 5%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .form-wrapper {
                padding: 60px 10px 20px;
            }

            .card {
                max-width: 100%;
                margin: 10px;
                margin-top: 35px;
            }

            .card-header {
                padding: 3rem 1.5rem 1rem;
            }

            .card-body {
                padding: 1rem 1.5rem 2rem;
            }

            .library-icon {
                width: 60px;
                height: 60px;
                top: -30px;
            }

            .library-icon i {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 320px) {
            .library-icon {
                width: 50px;
                height: 50px;
                top: -25px;
            }

            .library-icon i {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="floating-elements">
    <i class="fas fa-book floating-book"></i>
    <i class="fas fa-book-open floating-book"></i>
    <i class="fas fa-graduation-cap floating-book"></i>
</div>

<div class="form-wrapper">
    <div class="card">
        <div class="library-icon">
            <i class="fas fa-book-reader"></i>
        </div>

        <div class="card-header">
            <h4>Form Kunjungan</h4>
            <div class="subtitle">Perpustakaan SMP K 2 Harapan</div>
        </div>

        <div class="card-body">
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Alert untuk NIS tidak ditemukan --}}
            @if(session('error'))
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form Input NIS --}}
            <form method="POST" action="{{ route('anggota.kunjungan.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="nis" class="form-label">
                        <i class="fas fa-id-card me-2"></i>
                        Masukkan NIS Anda
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input
                            type="text"
                            name="nis"
                            id="nis"
                            class="form-control @error('nis') is-invalid @enderror"
                            placeholder="Contoh: 1234567890"
                            value="{{ old('nis') }}"
                            autofocus
                            autocomplete="off"
                        >
                    </div>
                    @error('nis')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Catat Kunjungan
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-light opacity-75">
                    <i class="fas fa-info-circle me-1"></i>
                    Pastikan NIS yang dimasukkan benar dan sudah terdaftar
                </small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nisInput = document.getElementById('nis');

        // Focus input saat halaman dimuat
        nisInput.focus();

        // Format input (hanya angka)
        nisInput.addEventListener('input', function(e) {
            // Hapus karakter non-digit
            this.value = this.value.replace(/\D/g, '');

            // Batasi panjang NIS (maksimal 15 digit)
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15);
            }

            // Hapus class invalid jika user mulai mengetik
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });

        // Animasi saat input focus
        nisInput.addEventListener('focus', function() {
            this.closest('.input-group').style.transform = 'scale(1.02)';
            this.closest('.input-group').style.transition = 'transform 0.3s ease';
        });

        nisInput.addEventListener('blur', function() {
            this.closest('.input-group').style.transform = 'scale(1)';
        });

        // Auto-hide alerts setelah 5 detik
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }, 5000);
        });
    });

    // Smooth scroll dan animasi
    window.addEventListener('load', function() {
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.body.style.overflow = 'auto';
        }, 600);
    });
</script>

</body>
</html>
