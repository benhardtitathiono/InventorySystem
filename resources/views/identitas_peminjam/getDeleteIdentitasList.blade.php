<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Tanggal Ditambahkan</th>
            <th>Terakhir Diperbarui</th>
            <th>Tanggal Dihapus</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($identity as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td class="editable" id="td-nama_barang-{{ $i->id }}">{{ $i->nama }}</td>
                <td id="td-created_at-{{ $i->id }}">{{ $i->created_at }}</td>
                <td id="td-updated_at-{{ $i->id }}">{{ $i->updated_at }}</td>
                <td id="td-deleted_at-{{ $i->id }}">{{ $i->deleted_at }}</td>

                <td style="text-align: center">
                    <form action="{{ route('identitas.restore', $i->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-xs">Pulihkan identitas</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
