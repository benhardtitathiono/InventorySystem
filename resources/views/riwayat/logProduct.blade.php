<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>ID Batch</th>
            <th>Stok Masuk</th>
            <th>Stok Keluar</th>
            <!-- <th>Stok Tersisa</th> -->
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logProduct as $lp)
            <tr>
                <td>{{ $lp->id }}</td>
                <td>{{ $lp->nama_barang }}</td>
                <td>{{ $lp->batch_product }}</td>
                @if ($lp->simpan_quantity_in == null or 0)
                    <td>0</td>
                @else
                    <td>{{ $lp->simpan_quantity_in  }}</td>
                @endif

                @if ($lp->quantity_out == null or 0)
                    <td>0</td>
                @else
                    <td>{{ $lp->quantity_out }}</td>
                @endif
            
                <!-- @if ($lp->jumlah == null or 0)
                <td>0</td>
                @else
                    <td>{{ $lp->jumlah  }}</td>
                @endif-->
                <td>{{ $lp->tanggal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
