<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Satuan</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Terakhir Diperbarui</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pap as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td class="editable" id="td-nama_barang-{{ $p->id }}">{{ $p->nama_barang }}</td>
                <td class="editable" id="td-satuan-{{ $p->id }}">{{ $p->satuan }}</td>
                <td class="editable" id="td-deskripsi-{{ $p->id }}">{{ $p->deskripsi }}</td>
                <td id="td-jumlah-{{ $p->id }}">{{ $p->jumlah }}</td>
                <td id="td-created_at-{{ $p->id }}">{{ $p->updated_at }}</td>

                <td style="text-align: center">
                    <form action="{{ route('product.restore', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-xs">Pulihkan produk</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
