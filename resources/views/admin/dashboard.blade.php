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
                        <div class="row mb-4">
                            <!-- Siswa Small Box -->
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>{{ $siswa->count() }}</h3>
                                        <p>Jumlah Siswa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <a href="/siswa" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Guru Small Box -->
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $guru->count() }}</h3>
                                        <p>Jumlah Guru</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <a href="/guru" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- Kelas/Jurusan Small Box -->
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $kelas->count() }}</h3>
                                        <p>Total Kelas/Jurusan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <a href="kelas_jurusan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal KBM Hari Ini -->
                        <div class="card shadow border-0 mt-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-calendar-day"></i> KBM Aktif Hari Ini - ({{ hariNum($hariIniAngka) }})</h5>
                            </div>
                            <div class="card-body p-0">
                                @if(count($kbmHariIni) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($kbmHariIni as $kbm )
                                            <li class="list-group-item d-flex align-items-center">
                                                <div class="me-3 text-center" style="min-width:70px;">
                                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($kbm->jam_mulai)->format('H:i') }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($kbm->jam_selesai)->format('H:i') }}</small>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $kbm->mapel->nama_mapel }}</div>
                                                    <div class="text-muted small">{{ $kbm->kelas->nama_kelas }} - {{ $kbm->guru->nama }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="p-4 text-center text-muted">
                                        Tidak ada KBM aktif hari ini.
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