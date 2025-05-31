 <form id="form-presensi-data" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="mapel">Pertemuan Ke</label>
            <input type="hidden" class="form-control" id="id_kbm" name="id_kbm" value="{{ $id }}">
            <select name="id" id="id" class="form-control">
                <option value="" selected disabled>Pilih Pertemuan</option>
                @php
                    $pertemuan = 0;
                @endphp
                @foreach ($presensi as $item)
                    {{ $pertemuan++ }}
                    <option value="{{ $item->id }}"> Pertemuan ke - {{ $pertemuan }} </option>
                @endforeach
                    <option value="baru"> Pertemuan Baru </option>
            </select>
            <div class="invalid-feedback" id="error-id"></div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="memuat">Presensi</button>
    </div>
</form>

<script>
$(document).ready(function () {
    $('#form-presensi-data').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('g.kbm.create.presensi') }}", // sesuaikan route
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#memuat').attr('disabled', 'disabled');
                $('#memuat').html(
                    '<i class="fa fa-spinner fa-spin mr-1"></i> Memuat...');
            },
            complete: function() {
                $('#memuat').removeAttr('disabled');
                $('#memuat').html('Presensi');
            },
            success: function (res) {
                window.location.href = res.redirect_url;
            },
            error: function (xhr) {
                submitButton.prop('disabled', false).text('Presensi');
                let response = xhr.responseJSON;
                if (response.errors) {
                    for (const key in response.errors) {
                        $(`#error-${key}`).text(response.errors[key][0]).show();
                    }
                }
            }
        });
    });
});
</script>
