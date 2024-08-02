<div id="IDPinjam">ID Peminjaman {{ $idPinjam }}
    <form method="POST" action="{{ route('barangkembali.updatestatus', $idPinjam) }}">
        @csrf
        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Pinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @if (isset($peminjaman->detailBarang) && count($peminjaman->detailBarang) > 0)
                    @foreach ($peminjaman->detailBarang as $p)
                        <tr>
                            <td>{{ $p->id }} <input type="hidden" name="prodID{{ $i }}"
                                    value="{{ $p->id }}"></td>
                            <td>{{ $p->nama_barang }}</td>
                            <td>{{ $p->pivot->total_barang_dipinjam }}</td>
                            <td>{{ $p->pivot->created_at }}</td>
                            <td style="text-align: center">
                                <input type="text" name="statKembali{{ $i }}"
                                    id="statKembali{{ $i }}" class="form-control"
                                    value="{{ $p->pivot->status_barang_kembali }}">
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center; font-size:20px; font-weight:bold;" colspan="8">Tidak ada
                            barang yang
                            dipinjam
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <input type="hidden" name="totProd" value="{{ $i }}">
        {{-- <input type="hidden" name="tipeCat" value="{{ $_GET['kategori'] }}"> --}}
        <input type="submit" value="Barang Kembali"
            onclick="return confirm('Apakah yakin ingin menyelesaikan peminjaman dengan ID {{ $idPinjam }}?')">
    </form>
</div>
