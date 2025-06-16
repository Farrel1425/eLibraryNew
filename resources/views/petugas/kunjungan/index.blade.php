@extends('layouts.petugas')

@section('title', 'Monitoring Kunjungan')

@section('content')
<!-- Main Content -->
<div class="container mt-4" id="mainContent">

    <div class="mb-3">
        <h3>Monitoring Kunjungan Anggota</h3>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <strong>Tanggal:</strong> {{ $tanggal }}
        </div>
        <div>
            <span class="badge bg-secondary fs-6">
                Total: {{ $total }} kunjungan
            </span>
        </div>
    </div>

    @if($kunjungan->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="visitTable">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th class="align-middle" style="width: 50px;">No</th>
                        <th class="align-middle">Nama Anggota</th>
                        <th class="align-middle">NIS</th>
                        <th class="align-middle" style="width: 150px;">Waktu Kunjungan</th>
                    </tr>
                </thead>
                <tbody id="visitTableBody">
                    @foreach($kunjungan as $index => $data)
                        <tr class="visit-row">
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $data->anggota->nama_anggota ?? '-' }}</td>
                            <td class="text-center align-middle">{{ $data->anggota->nis ?? '-' }}</td>
                            <td class="text-center align-middle">
                                {{ \Carbon\Carbon::parse($data->waktu_kunjungan)->format('H:i:s') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4">
            <i class="fas fa-users fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">Tidak ada kunjungan hari ini</p>
        </div>
    @endif

</div>

<style>
    /* Table Styling - Same as book template */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .visit-row {
        transition: all 0.2s ease;
    }

    .visit-row:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .badge {
        font-size: 0.75rem;
    }

    #resultCount {
        padding: 0.5rem 0.75rem;
    }

    .table thead th {
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

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
</style>

<script>
(function() {
    'use strict';

    // Simple initialization - same pattern as book template
    const VisitMonitor = {
        init: function() {
            this.initPageEvents();
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

    // Initialize when DOM ready with delay to avoid conflicts
    function initializeVisit() {
        if (typeof VisitMonitor !== 'undefined') {
            VisitMonitor.init();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeVisit, 100);
        });
    } else {
        setTimeout(initializeVisit, 100);
    }
})();
</script>
@endsection
