    <div class="modal-body">
        <div class="text-center">
            <label for="nama kbm">{{ $kbm->mapel->nama_mapel }} - {{ $kbm->kelas->nama_kelas }}</label> <br>
            <label for="guru">({{ $kbm->guru->nip }}) - {{ $kbm->guru->nama }}</label>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle text-center">No</th>
                        <th rowspan="2" class="align-middle text-center">Siswa</th>
                        @php
                            $pertemuan = $presensi->count();
                        @endphp
                        <th colspan="{{ $pertemuan }}" class="text-center">Pertemuan Ke</th>
                        <th colspan="4" class="text-center">Kehadiran</th>   
                    </tr>
                    <tr>
                        @foreach ($presensi as $item)
                            <th class="text-center">{{ $item->pertemuan_ke }}</th>
                        @endforeach
                        <th class="text-center">H</th>
                        <th class="text-center">S</th>
                        <th class="text-center">I</th>
                        <th class="text-center">A</th>
                    </tr>    
                </thead>
                <tbody>
                    @php
                        // Kumpulan siswa unik dari semua presensi
                        $daftarSiswa = collect();

                        foreach ($presensi as $p) {
                            foreach ($p->logPresensi as $log) {
                                $daftarSiswa->put($log->siswa->nis, $log->siswa);
                            }
                        }

                        // Menyusun data status presensi per siswa per pertemuan
                        $dataPresensi = [];
                        foreach ($presensi as $p) {
                            foreach ($p->logPresensi as $log) {
                                $dataPresensi[$log->siswa->nis][$p->pertemuan_ke] = $log->status;
                            }
                        }

                        // Rekap kehadiran
                        function countStatus($logs, $status) {
                            return collect($logs)->filter(fn($s) => $s === $status)->count();
                        }
                    @endphp
                
                    @foreach ($daftarSiswa as $siswaId => $siswa)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>[{{ $siswa->nis }}] - {{ $siswa->nama }}</td>

                        {{-- Status per pertemuan --}}
                        @for ($i = 1; $i <= $pertemuan; $i++)
                            @php
                                $status = $dataPresensi[$siswaId][$i] ?? '-';
                            @endphp
                            <td class="text-center">
                                @if(in_array($status, ['Hadir', 'Izin', 'Sakit', 'Alpa']))
                                    <span class="badge badge-{{ warnaStatus($status) }} rounded-circle" title="{{ $status }}">{{ substr($status, 0, 1) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        @endfor

                        {{-- Total status --}}
                        <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Hadir') }}</td>
                        <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Sakit') }}</td>
                        <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Izin') }}</td>
                        <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Alpa') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <a href="{{ route('g.presensi.kbm.pdf', $kbm->id) }}" target="_blank" class="btn btn-info"><i class="fas fa-file"></i> Export PDF</a>
    </div>
<script>
