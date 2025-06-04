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
                                <h4 class="alert-heading mb-1">Selamat Datang di Dashboard Guru!</h4>
                                <p class="mb-0">Kelola Presensi Kegiatan Belajar Mengajar, pantau kehadiran, dan akses fitur penting lainnya dengan mudah di sini.</p>
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
                                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 text-center" style="min-width:70px;">
                                                        <span class="fw-bold">{{ \Carbon\Carbon::parse($kbm->jam_mulai)->format('H:i') }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($kbm->jam_selesai)->format('H:i') }}</small>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $kbm->mapel->nama_mapel }}</div>
                                                        <div class="text-muted small">{{ $kbm->kelas->nama_kelas }} - {{ $kbm->guru->nama }}</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-xs btn-presensi open-modal" data-url="{{ route('g.kbm.create', $kbm->id) }}" id="btn-presensi">
                                                    <i class="nav-icon fas fa-qrcode"></i> Presensi
                                                </button>
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
        <!-- Modal Dinamis -->
    <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="modalShowLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalShowLabel">Presensi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="mdLd" class="p-4 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div>Loading content...</div>
                </div>
                <div class="modal-body" id="mdBd" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
    $(document).on("click", ".open-modal", function () {
        $("#mdBd").hide();
        $("#mdLd").show();
        $("#modalShow").modal({
            backdrop: "static",
            keyboard: false,
        });
        $("#modalShow").modal("show");

        $("#mdBd").load($(this).data("url"), function (response, status, xhr) {
            if (status === "success") {
                setTimeout(function () {
                    $("#mdBd").show();
                    $("#mdLd").hide();
                }, 200);
            } else {
                console.error("Gagal load konten modal:", xhr.statusText);
                $("#mdLd").html('<div class="text-danger">Gagal memuat data.</div>');
            }
        });
    });
    </script>
    
@endsection