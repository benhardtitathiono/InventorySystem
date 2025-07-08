<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID Batch</th>
            <th>Nama Produk</th>
            <th>Stok Keluar</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logBatch as $lb)
            <tr>
                <td>{{ $lb->batch_product_id }}</td>
                <td>{{ $lb->nama_barang }}</td>
                @if ($lb->quantity_out == null or 0)
                    <td>0</td>
                @else
                    <td>{{ $lb->quantity_out }}</td>
                @endif
                <td>{{ $lb->tanggal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
