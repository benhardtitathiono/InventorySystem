<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Tanggal Ditambahkan</th>
            <th>Terakhir Diperbarui</th>
            <th>Tanggal Dihapus</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($bp) && count($bp) > 0)
            @foreach ($bp as $bp)
                <tr>
                    <td>{{ $bp->id }}</td>
                    <td class="editable" id="td-nama_barang-{{ $bp->id }}">{{ $bp->nama_barang }}</td>
                    <td class="editable" id="td-deskripsi-{{ $bp->id }}">{{ $bp->deskripsi }}</td>
                    <td id="td-jumlah-{{ $bp->id }}">{{ $bp->jumlah }}</td>
                    <td id="td-created_at-{{ $bp->id }}">{{ $bp->created_at }}</td>
                    <td id="td-updated_at-{{ $bp->id }}">{{ $bp->updated_at }}</td>
                    <td id="td-deleted_at-{{ $bp->id }}">{{ $bp->deleted_at }}</td>

                    <td style="text-align: center">
                        <form action="{{ route('productpinjam.restore', $bp->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-xs">Pulihkan produk</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <td style="text-align: center; font-size:20px; font-weight:bold;" colspan="8">Tidak ada barang yang
                dihapus
            </td>
        @endif
    </tbody>
</table>
