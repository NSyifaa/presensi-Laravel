@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-calendar-alt"></i> Dashboard</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-school fa-2x me-3 text-white"></i>
                            <div class="mx-3">
                                <h4 class="alert-heading mb-1">Selamat Datang di Dashboard Siswa!</h4>
                                <p class="mb-0">Lihat jadwal pelajaran hari ini, pantau kehadiran, dan akses fitur penting lainnya dengan mudah di sini.</p>
                            </div>
                        </div>
                        <!-- Jadwal Pelajaran Hari Ini -->
                        <div class="card shadow border-0 mt-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-calendar-day"></i> Jadwal Pelajaran Hari Ini - ({{ hariNum($hariIniAngka) }})</h5>
                            </div>
                            <div class="card-body p-0">
                                @if(count($kbmHariIni) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($kbmHariIni as $jadwal)
                                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 text-center" style="min-width:70px;">
                                                        <span class="fw-bold">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</small>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $jadwal->mapel->nama_mapel }}</div>
                                                        <div class="text-muted small">{{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->guru->nama }}</div>
                                                    </div>
                                                </div>
                                                <a href="/siswa/presensi" class="btn btn-primary btn-xs">
                                                    <i class="nav-icon fas fa-qrcode"></i> Presensi
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="p-4 text-center text-muted">
                                        Tidak ada jadwal pelajaran hari ini.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection