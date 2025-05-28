 <form id="form-tambah-data" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="mapel">Pertemuan Ke</label>
            <select name="nip" id="nip" class="form-control">
                <option value="" selected disabled>Pilih Pertemuan</option>
                @foreach ($guru as $item)
                    <option value="{{ $item->nip }}"> [ {{ $item->nip }} ] - {{ $item->nama }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="error-nip"></div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
    </div>
</form>