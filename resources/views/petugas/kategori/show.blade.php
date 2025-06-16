@extends('layouts.petugas')

@section('title', 'Detail Kategori Buku')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
        --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-detail-container .container-fluid {
        max-width: calc(100% - 20px);
        margin: 0 auto;
        padding-left: 10px;
        padding-right: 10px;
    }

    .header-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--info-gradient);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: var(--info-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        margin: 0;
        line-height: 1.6;
    }

    .breadcrumb-nav {
        background: rgba(102, 126, 234, 0.1);
        border-radius: 50px;
        padding: 0.8rem 1.5rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .breadcrumb {
        margin: 0;
        background: none;
        padding: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "→";
        color: #667eea;
        font-weight: bold;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .breadcrumb-item a:hover {
        color: #764ba2;
        text-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
    }

    .breadcrumb-item.active {
        color: #1e293b;
        font-weight: 700;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--success-gradient);
    }

    .detail-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .detail-title i {
        color: #11998e;
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-name {
        font-size: 2.2rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        text-align: center;
        padding: 1rem;
        border-radius: 16px;
        background-color: rgba(102, 126, 234, 0.05);
        border: 2px solid rgba(102, 126, 234, 0.1);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .detail-item {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(102, 126, 234, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .detail-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: var(--transition);
        transform-origin: bottom;
    }

    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .detail-item:hover::before {
        transform: scaleY(1);
    }

    .detail-label {
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-label i {
        font-size: 1rem;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 600;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .detail-value.empty {
        color: #94a3b8;
        font-style: italic;
    }

    .stats-card {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        text-align: center;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .stats-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .stats-label {
        font-size: 1.2rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .btn-modern {
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        min-width: 160px;
        justify-content: center;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.4s, height 0.4s;
    }

    .btn-modern:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary-modern {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-success-modern {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
    }

    .btn-secondary-modern {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
        box-shadow: 0 8px 25px rgba(100, 116, 139, 0.3);
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        color: white;
        text-decoration: none;
    }

    .btn-primary-modern:hover {
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }

    .btn-success-modern:hover {
        box-shadow: 0 12px 35px rgba(17, 153, 142, 0.4);
    }

    .btn-secondary-modern:hover {
        box-shadow: 0 12px 35px rgba(100, 116, 139, 0.4);
    }

    .btn-modern i {
        font-size: 1.1rem;
        z-index: 1;
        position: relative;
    }

    .btn-modern span {
        z-index: 1;
        position: relative;
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

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .category-name {
            font-size: 1.8rem;
        }

        .header-card, .detail-card {
            padding: 1.5rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-modern {
            justify-content: center;
        }

        .stats-number {
            font-size: 2.5rem;
        }

        .detail-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="category-detail-container">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav fade-in-up">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('petugas.kategori.index') }}">
                        <i class="fas fa-list-alt me-1"></i>
                        Daftar Kategori
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-eye me-1"></i>
                    Detail Kategori
                </li>
            </ol>
        </nav>


        <!-- Detail Section -->
        <div class="detail-card fade-in-up" style="animation-delay: 0.2s;">
            <h3 class="detail-title">
                <i class="fas fa-bookmark"></i>
                Informasi Kategori
            </h3>

            <!-- Category Name -->
            <div class="category-name">
                {{ $kategori->nama_kategori }}
            </div>

            <!-- Detail Grid -->
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </div>
                    <div class="detail-value {{ $kategori->deskripsi ? '' : 'empty' }}">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-books"></i>
                        Jumlah Buku
                    </div>
                    <div class="detail-value">
                        {{ number_format($kategori->jumlah_buku, 0, ',', '.') }} Buku
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-calendar-plus"></i>
                        Tanggal Dibuat
                    </div>
                    <div class="detail-value">
                        {{ $kategori->created_at->format('d F Y') }}
                        <br>
                        <small style="color: #64748b;">{{ $kategori->created_at->format('H:i') }} WIB</small>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-calendar-edit"></i>
                        Terakhir Diperbarui
                    </div>
                    <div class="detail-value">
                        {{ $kategori->updated_at->format('d F Y') }}
                        <br>
                        <small style="color: #64748b;">{{ $kategori->updated_at->format('H:i') }} WIB</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('petugas.kategori.index') }}" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('petugas.kategori.edit', $kategori->id) }}" class="btn-modern btn-primary-modern">
                    <i class="fas fa-edit"></i>
                    <span>Edit Kategori</span>
                </a>
                @if($kategori->jumlah_buku > 0)
                <a href="{{ route('petugas.buku.index', ['kategori' => $kategori->id]) }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-book-open"></i>
                    <span>Lihat Buku</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced hover effects for cards
        const cards = document.querySelectorAll('.header-card, .detail-card, .stats-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = 'var(--hover-shadow)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--card-shadow)';
            });
        });

        // Parallax effect for stats card
        const statsCard = document.querySelector('.stats-card');
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;

            if (statsCard) {
                statsCard.style.transform = `translateY(${rate}px)`;
            }
        });

        // Counter animation for book count
        const statsNumber = document.querySelector('.stats-number');
        const targetNumber = parseInt(statsNumber.textContent);
        let currentNumber = 0;
        const increment = Math.ceil(targetNumber / 50);

        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= targetNumber) {
                currentNumber = targetNumber;
                clearInterval(timer);
            }
            statsNumber.textContent = currentNumber.toLocaleString('id-ID');
        }, 30);

        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn-modern');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });

    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
