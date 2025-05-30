@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-clipboard"></i> Presensi</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3 d-flex flex-column align-items-center">
                        <div id="reader" style="width: 100%;"></div>
                        <div class="alert alert-info mt-3 w-100 text-center">
                            <strong>Petunjuk:</strong> Arahkan kamera ke QR Code untuk melakukan presensi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('template/dist/js/html5-qrcode.min.js') }}"></script>
    <script>
        const method    = "POST";
        const formData  = new FormData();

        function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            const url       = "/siswa/presensi/{id}".replace('{id}', decodedText); 

        console.log(url);
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
                    // Tampilkan overlay loading
                    $('body').append('<div id="loading-overlay" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
                    // Pause kamera QR
                    html5QrcodeScanner.clear();
                },
                complete: function() {
                    $('#loading-overlay').remove();
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                },
                success: function(response) {
                    $('#loading-overlay').remove();
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

                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan: ';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + ' '; 
                            $('#error-' + key).text(value[0]).show();
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage += xhr.responseJSON.error; // Menambahkan error umum
                    } else {
                        errorMessage += 'Kesalahan tidak terduga. Silakan coba lagi'; // Pesan default
                    }
                    
                    alert(errorMessage);
                }
            });
        }

        function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
            // console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 100 },
        /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
    
@endsection