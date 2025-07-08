<table class="table">
    <thead>
        <tr>
            <th>ID Peminjaman</th>
            <th>Nama Barang</th>
            <th>Jumlah Dipinjam</th>
            <th>Status Pengembalian</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row->peminjaman_id }}</td>
                <td>{{ $row->nama_barang }}</td>
                <td>{{ $row->total_barang_dipinjam }}</td>
                <td>{{ $row->status_barang_kembali ?? 'Belum dikembalikan' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>