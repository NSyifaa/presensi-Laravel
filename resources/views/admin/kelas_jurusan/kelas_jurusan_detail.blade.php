@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-chalkboard-teacher"></i>  Detail Data Kelas Siswa</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered table-sm">  
                            <tbody>
                                <tr>
                                    <td><b>Tahun Akademik</b></td>
                                    <td>{{ $kelas->periode->tahun }}</td>
                                </tr>
                                <tr>
                                    <td><b>Nama Kelas</b></td>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td><b>Kelas</b> </td>
                                    <td>{{ $kelas->kode_kelas }}</td>
                                </tr>
                                <tr>
                                    <td><b>Jurusan</b></td>
                                    <td>{{ $kelas->jurusan->nama_jurusan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('a.kelas') }}" class="btn btn-warning btn-sm">
                        <i class="nav-icon fas fa-chevron-left"></i> kembali
                        </a>
                        <br><br>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                            <th>No</th>
                            <th><center>NIS</center></th>
                            <th>Nama Siswa</th>
                            <th><center>Aksi</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration; }}</td>
                                <td>{{ $item->nama_siswa }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->kelas->kode_kelas }}</td>
                                <td>
                                <center>
                                    <button type="button" class="btn btn-danger btn-xs btn-hapus" data-id="{{ $item->id }}" id="btn-hapus">
                                        <i class="nav-icon fas fa-trash"></i> Hapus
                                    </button>                              
                                </center>
                                </td>
                            </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="title" >Tambah Jurusan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-data" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select name="kode_jurusan" id="kode_jurusan" class="form-control">
                                <option value="" selected disabled>Pilih jurusan</option>
                                @foreach ($jurusan as $item)
                                <option value="{{ $item->kode_jurusan }}"> [ {{ $item->kode_jurusan }} ] - {{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-kode_jurusan"></div>
                        </div> --}}
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

    {{-- <script>
      $(document).ready(function() {
        
        $('#modal-default').on('show.bs.modal', function (event) {
          $(this).removeAttr('aria-hidden');
            
            var edit = false;
            var button  = $(event.relatedTarget); 
            var idKelas = button.data('id'); 
            var nama    = button.data('nama');
            var jurusan = button.data('jurusan');
            var kelas   = button.data('kelas');

            if (idKelas) {
                $('#title').text('Edit Kelas');
                $('#nama').val(nama);
                $('#kode_jurusan').val(jurusan);
                $('#kode_kelas').val(kelas);
                $('#form-tambah-data').data('edit', true);
                $('#form-tambah-data').data('id', idKelas);
            } else {
                $('#title').text('Tambah Kelas');
                $('#nama').val('');
                $('#kode_jurusan').val('');
                $('#kode_kelas').val('');
                $('#form-tambah-data').data('edit', false);
                $('#form-tambah-data').data('id', null);
            }
        });

        $('#form-tambah-data').on('submit', function(e) {
            e.preventDefault();

            const formData  = new FormData(this);
            const isEdit    = $(this).data('edit');
            const idKelas   = $(this).data('id');

            const url = isEdit
              ? '/kelas_jurusan/edit/' + idKelas
              : "{{ route('a.kelas.add') }}";

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
            var id_kelas = button.data('id') 
            var url = "{{ route('a.kelas.delete', ':id') }}".replace(':id', id_kelas);
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
                            id : id_kelas
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
     --}}
@endsection