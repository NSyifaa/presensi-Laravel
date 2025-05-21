@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-university"></i> Data Jurusan</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                  <i class="nav-icon fas fa-plus"></i>  Tambah Data
                </button>
                <br><br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Jurusan</th>
                      <th><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($jurusan as $item)
                    <tr>
                        <td>{{ $loop->iteration; }}</td>
                        <td>
                            [ {{ $item->kode_jurusan }} ] <br>
                            {{ $item->nama_jurusan }}
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-default" data-id="{{ $item->kode_jurusan }}" data-nama="{{ $item->nama_jurusan }}">
                                <i class="nav-icon fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-xs btn-hapus" data-id="{{ $item->kode_jurusan }}" id="btn-hapus">
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
            <h4 class="modal-title" id="title" >Tambah Jurusan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-tambah-data" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="kode_jurusan">Kode Jurusan</label>
                <input type="text" class="form-control" name="kode_jurusan" id="kode_jurusan" placeholder="Kode Jurusan">
                <div class="invalid-feedback" id="error-kode_jurusan"></div>
              </div>
              <div class="form-group">
                <label for="jurusan">Nama Jurusan</label>
                <input type="text" class="form-control" name="jurusan" id="jurusan" placeholder="Masukan Jurusan">
                <div class="invalid-feedback" id="error-jurusan"></div>
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

    <script>
      $(document).ready(function() {
        
        $('#modal-default').on('show.bs.modal', function (event) {
          $(this).removeAttr('aria-hidden');
            
            var edit = false;
            var button = $(event.relatedTarget); 
            var id_jurusan = button.data('id'); 
            var nama = button.data('nama');

            if (id_jurusan) {
                $('#title').text('Edit Jurusan');
                $('#jurusan').val(nama);
                $('#kode_jurusan').val(id_jurusan);
                $('#kode_jurusan').attr('readonly', true);
                $('#form-tambah-data').data('edit', true);
                $('#form-tambah-data').data('id', id_jurusan);
            } else {
                $('#title').text('Tambah Jurusan');
                $('#kode_jurusan').val('');
                $('#jurusan').val('');
                $('#kode_jurusan').attr('readonly', false);
                $('#form-tambah-data').data('edit', false);
                $('#form-tambah-data').data('id', null);
            }
        });

        $('#form-tambah-data').on('submit', function(e) {
            e.preventDefault();

            const formData  = new FormData(this);
            const isEdit    = $(this).data('edit');
            const idJurusan = $(this).data('id');

            const url = isEdit
              ? '/jurusan/edit/' + idJurusan
              : "{{ route('a.jurusan.add') }}";

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
            var id_jurusan = button.data('id') 
            var url = "{{ route('a.jurusan.delete', ':id') }}".replace(':id', id_jurusan);
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
                            id_periode: id_jurusan
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
    
@endsection