<form method="POST" action="{{ route('product.updateStock', $pap->id) }}">
    @csrf
    {{-- @method('PUT') --}}
    <div class="form-group">
        <label for="idProd">ID produk</label>
        <input type="text" class="form-control" name="idProd" id="idProd" aria-describedby="idHelp"
            value="{{ $pap->id }}" readonly>

        <label for="nameProd">Name produk</label>
        <input type="text" class="form-control" name="nameProd" id="nameProd" aria-describedby="nameHelp"
            value="{{ $pap->nama_barang }}">

        <label for="satuanProd">Satuan produk</label>
        <input type="text" class="form-control" name="satuanProd" id="satuanProd" aria-describedby="satuanHelp"
            value="{{ $pap->satuan }}">

        <label for="description">Deskripsi</label>
        <input type="text" class="form-control" name="descProd" id="descProd" aria-describedby="descHelp"
            value="{{ $pap->deskripsi }}">

        <label class="stok" for="stok">Stok</label><br>
        Stok Sekarang: {{ $pap->jumlah }}<input class="form-control" type="number" name="stokProdQuan"
            id="stokProdQuan">

        <label for="tgglEx">Tanggal Kadaluwarsa</label>
        <input type="date" class="form-control" name="dateExProd" id="dateExProd" aria-describedby="dateExHelp"
            min="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}">

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
