@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-users"></i> Data Siswa </h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">
                  <i class="nav-icon fas fa-plus"></i>  Tambah Data
                </button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-import">
                  <i class="nav-icon fas fa-file-excel"></i>  import Data
                </button>
                <br><br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Siswa</th>
                      <th>Jurusan</th>
                      <th>No HP</th>
                      <th>Alamat</th>
                      <th><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration; }}</td>
                        <td>
                            {{ $item->nis }} <br>
                            {{ $item->nama }}
                        </td>
                        <td>
                            {{ $item->jurusan->nama_jurusan }}
                        </td>
                        <td>
                            {{ $item->no_hp }}
                        </td>
                        <td>
                            {{ $item->alamat }}
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-default" 
                            data-id="{{ $item->nis }}" 
                            data-nama="{{ $item->nama }}"
                            data-jurusan="{{ $item->jurusan->kode_jurusan }}"
                            data-kelamin="{{ $item->kelamin }}"
                            data-no_hp="{{ $item->no_hp }}"
                            data-alamat="{{ $item->alamat }}">
                                <i class="nav-icon fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-xs btn-hapus" data-id="{{ $item->nis }}" id="btn-hapus">
                                <i class="nav-icon fas fa-trash"></i> Hapus
                            </button>                              
                            <button type="button" class="btn btn-warning btn-xs btn-reset" data-id="{{ $item->nis }}" id="btn-reset">
                                <i class="nav-icon fas fa-sync"></i> Reset Password
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
                    <h4 class="modal-title" >Tambah Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-data" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="number" class="form-control" name="nis" id="nis" placeholder="NIS">
                            <div class="invalid-feedback" id="error-nis"></div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Siswa">
                            <div class="invalid-feedback" id="error-nama"></div>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control">
                                <option value="" selected disabled>Pilih jurusan</option>
                                @foreach ($jurusan as $item)
                                <option value="{{ $item->kode_jurusan }}"> [ {{ $item->kode_jurusan }} ] - {{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-jurusan"></div>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Jenis Kelamin</label>
                            <select name="kelamin" id="kelamin" class="form-control">
                                <option value="" selected disabled>Pilih Kelamin</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback" id="error-kelamin"></div>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <div class="invalid-feedback" id="error-no_hp"></div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" cols="20" rows="3"></textarea>
                            <div class="invalid-feedback" id="error-alamat"></div>
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

    <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="nav-icon fas fa-file-excel"></i> Import Data Siswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-import-data" action="{{ route('a.siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-6" >
                                <center>
                                    <h6><b>Template Excel</b></h6>
                                    <a href="{{ route('a.siswa.download') }}" class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-file-excel"></i> Download
                                    </a>
                                </center>
                            </div>
                            <div class="form-group col-lg-6">
                                <center>
                                    <h6><b>Data Jurusan</b></h6>
                                    <a href="{{ route('a.jurusan.export') }}" class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-university"></i> Export
                                    </a>
                                </center>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload file</label>
                            <input type="file" id="file" name="file" class="form-control-file" accept=".xls,.xlsx" required>
                            <div class="invalid-feedback" id="error-file"></div>
                        </div> 
                    </div>
                    <div class="modal-footer pull-right">
                        <button type="submit" class="btn btn-primary" name="impor" id="btn-import"><i class="nav-icon fas fa-file-excel"></i>Import Data</button>
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
                var nis = button.data('id'); 
                var nama = button.data('nama');
                var jurusan = button.data('jurusan');
                var kelamin = button.data('kelamin');
                var no_hp = button.data('no_hp');
                var alamat = button.data('alamat');

                if (nis) {
                    $('#title').text('Edit Siswa');
                    $('#nis').val(nis);
                    $('#nis').attr('readonly', true);
                    $('#nama').val(nama);
                    $('#jurusan').val(jurusan);
                    $('#kelamin').val(kelamin);
                    $('#no_hp').val(no_hp);
                    $('#alamat').val(alamat);
                    $('#form-tambah-data').data('edit', true);
                    $('#form-tambah-data').data('id', nis);
                } else {
                    $('#title').text('Tambah Siswa');
                    $('#nis').val('');
                    $('#nis').attr('readonly', false);
                    $('#nama').val('');
                    $('#jurusan').val('');
                    $('#kelamin').val('');
                    $('#no_hp').val('');
                    $('#alamat').val('');
                    $('#form-tambah-data').data('edit', false);
                    $('#form-tambah-data').data('id', null);
                }
            });

            $('#form-tambah-data').on('submit', function(e) {
                e.preventDefault();

                const formData  = new FormData(this);
                const isEdit    = $(this).data('edit');
                const nis = $(this).data('id');

                const url = isEdit
                ? '/siswa/edit/' + nis
                : "{{ route('a.siswa.add') }}";

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
                var nis = button.data('id') 
                var url = "{{ route('a.siswa.delete', ':id') }}".replace(':id', nis);
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
                                id_periode: nis
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
            
            $('#form-import-data').on('submit', function(e) {
                e.preventDefault();

                const formData  = new FormData(this);
                const url = "{{ route('a.siswa.import') }}";
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
                        $('#btn-import').attr('disabled', 'disabled');
                        $('#btn-import').html(
                            '<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan');
                    },
                    complete: function() {
                        $('#btn-import').removeAttr('disabled');
                        $('#btn-import').html('Import Data');
                    },
                    success: function(response) {
                    if (response.status === 'warning') {
                            Toast.fire({
                                icon: 'warning',
                                title: response.message
                            });
                        } else {
                            $('#modal-import').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            $('#form-import-data')[0].reset();
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

               $('.btn-reset').on('click', function (e) {
                var button = $(this);
                var nip = button.data('id');
                var url = "{{ route('a.siswa.reset_pw', ':id') }}".replace(':id', nip);
                var method = 'POST';

                Swal.fire({
                    title: "Reset Password",
                    text: "Apakah Anda yakin ingin reset password siswa ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Reset!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: method,
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function() {
                                button.attr('disabled', 'disabled');
                                button.html('<i class="fa fa-spinner fa-spin mr-1"></i> Mereset...');
                            },
                            complete: function() {
                                button.removeAttr('disabled');
                                button.html('<i class="nav-icon fas fa-sync"></i> Reset Password');
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.error || 'Terjadi kesalahan tak terduga.'
                                });
                            }
                        });
                    }
                });
            });
        });
       
    </script>
    @if (session('download_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Download',
                text: '{{ session('download_error') }}',
            });
        </script>
    @endif

    
@endsection