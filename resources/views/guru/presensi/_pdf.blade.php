<!DOCTYPE html>
<html>
<head>
    <title>Presensi {{ $kbm->mapel->nama_mapel }} - {{ $kbm->kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #eee; text-align: center; }
        td.text-center { text-align: center; }
        td.text-left { text-align: left; }

        /* Badge manual karena mPDF tidak selalu mendukung class-chain */
        .badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
        }
        .badge-Hadir { background-color: #28a745; }
        .badge-Sakit { background-color: #ffc107; color: #000; }
        .badge-Izin  { background-color: #17a2b8; }
        .badge-Alpa  { background-color: #dc3545; }
    </style>
</head>
<body>
    <table style="width: 100%; margin-bottom: 10px;">
        <tr style="border: 0px;">
            <td style="width: 15%; border: 0px">
                <img src="{{ public_path('img/logoMaarif.jpeg') }}" alt="Logo" style="max-height: 80px;">
            </td>
            <td style="text-align: center; border: 0px">
                <h2 style="margin: 0;">SMK Ma'arif NU Tonjong</h2>
                <p style="margin: 0;">Alamat: Jl. Raya Tonjong No. 127, Tonjong, Kec. Tonjong, Kab. Brebes Prov. Jawa Tengah</p>
                <p style="margin: 0;">Email: admin@maarif.com | Telp: 0123-456789</p>
            </td>
        </tr>
    </table>
    <hr style="border-top: 2px solid #000; margin-bottom: 20px;">
    <h2 style="text-align:center; margin: 0;"><b>Laporan Presensi</b></h2>
    <h3 style="text-align:center;"><b>{{ $kbm->tahunAjaran->tahun}} - {{ $kbm->tahunAjaran->semester == 1 ? 'Ganjil' : 'Genap' }}</b></h3>
    <h4 style="margin: 0;">{{ $kbm->mapel->nama_mapel }} - {{ $kbm->kelas->nama_kelas }}</h4>
    <h4 style="margin: 0;">({{ $kbm->guru->nip }}) - {{ $kbm->guru->nama }}</h4>
    @php
        function countStatus($logs, $status) {
            return collect($logs)->filter(fn($s) => $s === $status)->count();
        }
    @endphp
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Siswa</th>
                <th colspan="{{ $pertemuan }}">Pertemuan Ke</th>
                <th colspan="4">Kehadiran</th>
            </tr>
            <tr>
                @foreach ($presensi as $item)
                    <th>{{ $item->pertemuan_ke }}</th>
                @endforeach
                <th>H</th>
                <th>S</th>
                <th>I</th>
                <th>A</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftarSiswa as $siswaId => $siswa)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">[{{ $siswa->nis }}] - {{ $siswa->nama }}</td>
                @for ($i = 1; $i <= $pertemuan; $i++)
                    @php $status = $dataPresensi[$siswaId][$i] ?? '-'; @endphp
                    <td class="text-center">
                        @php
                            $colors = [
                                'Hadir' => '#28a745',
                                'Sakit' => '#ffc107',
                                'Izin'  => '#17a2b8',
                                'Alpa'  => '#dc3545',
                            ];
                            $color = $colors[$status] ?? '#6c757d'; // fallback abu
                            $textColor = ($status === 'Sakit') ? '#000' : '#fff';
                        @endphp
                        @if(in_array($status, ['Hadir', 'Izin', 'Sakit', 'Alpa']))
                            <span style="color:{{ $color }}; font-weight:bold;">
                                {{ substr($status, 0, 1) }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                @endfor
                <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Hadir') }}</td>
                <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Sakit') }}</td>
                <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Izin') }}</td>
                <td class="text-center">{{ countStatus($dataPresensi[$siswaId] ?? [], 'Alpa') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
