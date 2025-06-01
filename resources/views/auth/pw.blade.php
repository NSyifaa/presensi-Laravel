@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-key"></i> Ganti Password</h3>
            </div>
            <form class="form-horizontal" id="form-ganti-password" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Masukkan Password Baru">
                                <div class="invalid-feedback" id="error-new_password"></div>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi Password Baru">
                                <div class="invalid-feedback" id="error-new_password_confirmation"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="btn-ganti" data-id="{{ $user->id }}">Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
   <script>
    $('#btn-ganti').on('click', function () {
        const button = $(this);
        const id = $(this).data('id');
        const url = "{{ route('password.update', $user->id) }}";

        console.log('URL:', url);
        
        const data = {
            new_password: $('input[name="new_password"]').val(),
            new_password_confirmation: $('input[name="new_password_confirmation"]').val(),
            _token: $('input[name="_token"]').val()
        };

        if (!data.new_password || !data.new_password_confirmation) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Semua field harus diisi.'
            });
            return;
        }
        if (data.new_password !== data.new_password_confirmation) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Password baru dan konfirmasi password tidak cocok.'
            });
            return;
        }

        Swal.fire({
            title: "Ganti Password",
            text: "Apakah Anda yakin ingin mengganti password?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ganti!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function () {
                        button.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
                    },
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message || 'Password berhasil diubah.'
                        });
                        setTimeout(() => {
                            window.location.href = '/logout';
                        }, 2500);
                    },
                    error: function (xhr) {
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
                        },
                    complete: function () {
                        button.removeAttr('disabled').html('Ganti Password');
                    }
                });
            }
        });
    });
</script>

@endsection