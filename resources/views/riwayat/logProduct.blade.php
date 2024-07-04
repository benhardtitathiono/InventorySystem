<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>ID Batch</th>
            <th>Stok Masuk</th>
            <th>Stok Keluar</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totQuanIn = 0;
            $totQuanOut = 0;
        @endphp
        @foreach ($logProduct as $lp)
            <tr>
                <td>{{ $lp->id }}</td>
                <td>{{ $lp->nama_barang }}</td>
                <td>{{ $lp->batch_product }}</td>
                @if ($lp->quantity_in == null or 0)
                    <td>0</td>
                @else
                    <td>{{ $lp->quantity_in }}</td>
                    @php
                        $totQuanIn += $lp->quantity_in;
                    @endphp
                @endif

                @if ($lp->quantity_out == null or 0)
                    <td>0</td>
                @else
                    <td>{{ $lp->quantity_out }}</td>
                    @php
                        $totQuanOut += $lp->quantity_out;
                    @endphp
                @endif
                <td>{{ $lp->tanggal }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td id="jumlah" colspan='3'>jumlah</td>
            <td>{{ $totQuanIn }}</td>
            <td>{{ $totQuanOut }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
