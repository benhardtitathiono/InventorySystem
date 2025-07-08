<div id="IDPinjam">
    <h4>ID Peminjaman: {{ $idPinjam }}</h4>
    <h5>Nama Peminjam: {{ $peminjaman->identitasPeminjam->nama ?? '-' }}</h5>

    <form method="POST" action="{{ route('barangkembali.updatestatus', $idPinjam) }}">
        @csrf
        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Dipinjam</th>
                    <th>Tanggal Pinjam</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @if ($peminjaman->detailBarang->isNotEmpty())
                    @foreach ($peminjaman->detailBarang as $barang)
                        <tr>
                            <td>
                                {{ $barang->id }}
                                <input type="hidden" name="prodID" value="{{ $barang->id }}">
                            </td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->pivot->total_barang_dipinjam }}</td>
                            <td>{{ \Carbon\Carbon::parse($barang->pivot->created_at)->format('d-m-Y H:i') }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center font-weight-bold">Tidak ada barang yang dipinjam</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <input type="hidden" name="totProd" value="{{ $i - 1 }}">
        <input type="hidden" name="statKembali" value="kembali">
        <input type="submit" value="Barang Kembali"
            onclick="return confirm('Apakah yakin ingin menyelesaikan peminjaman dengan ID {{ $idPinjam }}?')">
    </form>
</div>
