 <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Siswa</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($logPresensi as $item)
        <tr id="baris-presensi-{{ $item->id }}">
            <td>{{ $loop->iteration; }}</td>
            <td>
                {{ $item->nis }} <br>
                {{ $item->siswa->nama }}
            </td>
            <td>
                <button type="button" class="btn btn-lg" data-toggle="modal" data-target="#modal-default" 
                    data-id="{{ $item->id }}"
                    data-status="{{ $item->status }}">
                @if ($item->status == 'Hadir')
                    <span id="badge-status-{{ $item->id }}" class="badge badge-{{ warnaStatus($item->status) }}"> Hadir <i class="nav-icon fas fa-chevron-down"></i> </span> 
                @elseif ($item->status == 'Izin')
                    <span id="badge-status-{{ $item->id }}" class="badge badge-{{ warnaStatus($item->status) }}"> Izin <i class="nav-icon fas fa-chevron-down"></i> </span> 
                @elseif ($item->status == 'Sakit')
                    <span id="badge-status-{{ $item->id }}" class="badge badge-{{ warnaStatus($item->status) }}"> Sakit <i class="nav-icon fas fa-chevron-down"></i> </span> 
                @else
                    <span id="badge-status-{{ $item->id }}" class="badge badge-{{ warnaStatus($item->status) }}"> Alpa <i class="nav-icon fas fa-chevron-down"></i> </span> 
                @endif
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>