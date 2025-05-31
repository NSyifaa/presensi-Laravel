@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-clipboard-check"></i> Laporan Presensi</h3>
            </div>
            <div class="card-body">
                <h5>Tahun Akademik : {{ $taAktif->tahun }} {{ $taAktif->semester == 1 ? 'Ganjil' : 'Genap' }}</h5>
                <br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Kelas</th>
                      <th><center>Kelas</center></th>
                      <th>Jurusan</th>
                      <th><center>Jumlah KBM</center></th>
                      <th><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($kelas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td><center>{{ $item->kode_kelas }}</center></td>
                        <td>{{ $item->jurusan->nama_jurusan }}</td>
                        <td><center>{{ $item->kbm()->count() }}</center></td>
                        <td>
                          <center>
                            <a href="{{ route('a.presensi.kbm', ['id' => $item->id]) }}" class="btn btn-info btn-xs">
                                <i class="nav-icon fas fa-info-circle"></i> Detail
                            </a>
                          </center>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
@endsection