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
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                  <i class="nav-icon fas fa-plus"></i>  Tambah Data
                </button>
                <br><br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama KBM</th>
                      <th>Guru</th>
                      <th>Waktu</th>
                      <th><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($kbm as $item)
                    <tr>
                        <td>{{ $loop->iteration; }}</td>
                        <td>
                            {{ $item->mapel->nama_mapel }} <br>
                            {{ $item->kelas->nama_kelas }}
                        </td>
                        <td>
                            {{ $item->guru->nip }} <br>
                            {{ $item->guru->nama }}
                        </td>
                        <td>
                            {{ hariNum($item->hari) }} <br>
                            {{ $item->jam_mulai }} - {{ $item->jam_selesai }} <br>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-primary btn-xs btn-presensi open-modal" data-url="{{ route('a.kbm.create', $item->id) }}" id="btn-presensi">
                                <i class="nav-icon fas fa-qrcode"></i> Presensi
                            </button>    
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-default" 
                            data-id="{{ $item->id }}"
                            data-guru= "{{ $item->guru->nip }}"
                            data-mapel="{{ $item->mapel->id }}"
                            data-kelas="{{ $item->kelas->id }}"
                            data-hari="{{ $item->hari }}"
                            data-jam_mulai="{{ $item->jam_mulai }}"
                            data-jam_selesai="{{ $item->jam_selesai }}">
                                <i class="nav-icon fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-xs btn-hapus" data-id="{{ $item->id }}" id="btn-hapus">
                                <i class="nav-icon fas fa-trash"></i> Hapus
                            </button>                              
                          </center>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title" id="title" >Tambah KBM</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-tambah-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="mapel">Guru</label>
                    <select name="nip" id="nip" class="form-control">
                        <option value="" selected disabled>Pilih Guru</option>
                        @foreach ($guru as $item)
                            <option value="{{ $item->nip }}"> [ {{ $item->nip }} ] - {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error-nip"></div>
                </div>
                <div class="form-group">
                    <label for="mapel">Mapel</label>
                    <select name="kode_mapel" id="kode_mapel" class="form-control">
                        <option value="" selected disabled>Pilih Mapel</option>
                        @foreach ($mapel as $item)
                            <option value="{{ $item->id }}"> {{ $item->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error-kode_mapel"></div>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kode_kelas" id="kode_kelas" class="form-control">
                        <option value="" selected disabled>Pilih kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}"> {{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error-kode_kelas"></div>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                        <select name="hari" id="hari" class="form-control">
                            <option value="" selected disabled> Pilih Hari</option>
                            @for ($hari = 1; $hari <= 7; $hari++)
                                <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ hariNum($hari) }}</option>
                            @endfor
                        </select>
                    <div class="invalid-feedback" id="error-hari"></div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}">
                            <div class="invalid-feedback" id="error-jam_mulai"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                         <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}">
                            <div class="invalid-feedback" id="error-jam_selesai"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
            </div>
          </form>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
    $(document).ready(function() {
       
        $('#modal-default').on('show.bs.modal', function (event) {
            $(this).removeAttr('aria-hidden');
            
            var edit = false;
            var button = $(event.relatedTarget); 
            var id_kbm = button.data('id'); 
            var guru = button.data('guru');
            var mapel = button.data('mapel');
            var kelas = button.data('kelas');
            var hari = button.data('hari');
            var jam_mulai = button.data('jam_mulai');
            var jam_selesai = button.data('jam_selesai');

            if (id_kbm) {
                $('#title').text('Edit Mapel');
                $('#nip').val(guru);
                $('#kode_mapel').val(mapel);
                $('#kode_kelas').val(kelas);
                $('#hari').val(hari);
                $('#jam_mulai').val(jam_mulai);
                $('#jam_selesai').val(jam_selesai);
                $('#form-tambah-data').data('edit', true);
                $('#form-tambah-data').data('id', id_kbm);
            } else {
                $('#title').text('Tambah mapel');
                $('#nip').val('');
                $('#kode_mapel').val('');
                $('#kode_kelas').val('');
                $('#hari').val('');
                $('#jam_mulai').val('');
                $('#jam_selesai').val('');
                $('#form-tambah-data').data('edit', false);
                $('#form-tambah-data').data('id', null);
            }
        });

        $('#form-tambah-data').on('submit', function(e) {
            e.preventDefault();

            const formData  = new FormData(this);
            const isEdit    = $(this).data('edit');
            const idKBM     = $(this).data('id');

            const url = isEdit
              ? '/kbm/edit/' + idKBM
              : "{{ route('a.kbm.add') }}";

            const method    = 'POST'; 
            
            // Clear previous error messages
            $('.invalid-feedback').text('').hide();
            $.ajax({
                type: method,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#simpan').attr('disabled', 'disabled');
                    $('#simpan').html(
                        '<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan');
                },
                complete: function() {
                    $('#simpan').removeAttr('disabled');
                    $('#simpan').html('Simpan');
                },
                success: function(response) {
                  if (response.status === 'warning') {
                        Toast.fire({
                            icon: 'warning',
                            title: response.message
                        });
                    } else {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('#form-tambah-data')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 2500);
                    }
                },
                error: function(xhr) {
                      if (xhr.responseJSON && xhr.responseJSON.errors) {
                          const errors = xhr.responseJSON.errors;

                          $.each(errors, function(key, value) {
                              let inputField = $('#' + key);
                              let errorFeedback = $('#error-' + key);

                              inputField.addClass('is-invalid'); // Tambahkan class is-invalid
                              errorFeedback.text(value[0]).show(); // Tampilkan pesan error
                          });

                      } else if (xhr.responseJSON && xhr.responseJSON.error) {
                          Swal.fire({
                              icon: 'error',
                              title: 'Gagal!',
                              text: xhr.responseJSON.error
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Gagal!',
                              text: 'Kesalahan tidak terduga. Silakan coba lagi.'
                          });
                      }
                  }
            });

        });

        $('.btn-hapus').on('click', function (e) {

            var button = $(this); 
            var idKBM = button.data('id') 
            var url = "{{ route('a.kbm.delete', ':id') }}".replace(':id', idKBM);
            var method = 'DELETE';

            Swal.fire({
                title: "Hapus Data",
                text: "Apakah Anda yakin ingin menghapus data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: method,
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            idKBM : idKBM
                        },
                        
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            button.attr('disabled', 'disabled');
                            button.html(
                                '<i class="fa fa-spinner fa-spin mr-1"></i> Menghapus');
                        },
                        complete: function() {
                            button.removeAttr('disabled');
                            button.html('<i class="nav-icon fas fa-trash"></i> Hapus');
                        },

                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            $('#form-tambah-data')[0].reset();
                            setTimeout(function() {
                                location.reload();
                            }, 2500);
                        },
                        error: function(xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;

                            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.error
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Kesalahan tidak terduga. Silakan coba lagi.'
                                });
                            }
                        }
                    });
                }
            });
        })
    });
    
    </script>
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