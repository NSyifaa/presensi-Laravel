@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-chalkboard-teacher"></i> Data KBM</h3>
            </div>
            <div class="card-body">
                <h5>Tahun Akademik : {{ $taAktif->tahun }} {{ $taAktif->semester == 1 ? 'Ganjil' : 'Genap' }}</h5>
                <br>
                <div class="row">
                  @foreach ($kelas as $item)
                    <div class="col-md-4 mb-4">
                      <div class="card shadow-sm h-100 border-primary">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-column align-items-center mb-3 text-center">
                              <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-2" style="width:48px; height:48px;">
                                <i class="fas fa-chalkboard fa-lg"></i>
                              </span>
                              <div>
                                <h5 class="card-title mb-1 fw-bold">{{ $item->nama_kelas }}</h5>
                              </div>
                              <div>
                                <small class="text-muted"> ( {{ $item->jurusan->nama_jurusan }} )</small>
                              </div>
                            </div>
                          <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item px-0 py-1 border-0">
                              <i class="fas fa-layer-group text-primary me-2"></i>
                              <span class="fw-semibold">Kode Kelas:</span>
                              <span class="text-dark">{{ $item->kode_kelas }}</span>
                            </li>
                            <li class="list-group-item px-0 py-1 border-0">
                              <i class="fas fa-calendar-check text-success me-2"></i>
                              <span class="fw-semibold">Jumlah KBM:</span>
                              <span class="text-dark">{{ $item->kbm()->count() }}</span>
                            </li>
                          </ul>
                          <a href="{{ route('a.kbm.detail', ['id' => $item->id]) }}" class="btn btn-outline-primary mt-auto w-100 fw-semibold">
                            <i class="fas fa-eye me-1"></i> Lihat KBM
                          </a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection