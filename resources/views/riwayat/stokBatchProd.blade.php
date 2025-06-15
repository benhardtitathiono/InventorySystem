<table id="listProduct" class="table">
    <thead>
        <tr>
            <th>ID Batch</th>
            <th>Stok Masuk</th>
            <th>Stok Keluar</th>
            <th>Tanggal Kadaluwarsa</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($stokBatchProduct) && count($stokBatchProduct) > 0)
            @foreach ($stokBatchProduct as $sbp)
                @php
                    $sisaHari = \Carbon\Carbon::now('Asia/Jakarta')->diffInDays(
                        \Carbon\Carbon::parse($sbp->tanggal_kadaluwarsa),
                        false,
                    );
                @endphp

                @if ($sisaHari >= 0 and $sisaHari <= 30)
                    <tr class="tanggal_exp">
                        @if ($sbp->tot_in - $sbp->tot_out != 0)
                            <td>{{ $sbp->batch_product }}</td>
                            @if ($sbp->tot_in == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_in }}</td>
                            @endif

                            @if ($sbp->tot_out == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_out }}</td>
                            @endif
                            <td>{{ $sbp->tanggal_kadaluwarsa }} Kurang dari {{ $sisaHari }} hari
                                lagi
                                expire
                            </td>
                        @endif
                    </tr>
                @elseif ($sisaHari < 0)
                    <tr class="tanggal_exp">
                        @if ($sbp->tot_in - $sbp->tot_out != 0)
                            <td>{{ $sbp->batch_product }}</td>
                            @if ($sbp->tot_in == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_in }}</td>
                            @endif

                            @if ($sbp->tot_out == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_out }}</td>
                            @endif
                            <td>{{ $sbp->tanggal_kadaluwarsa }} sudah expire sejak
                                {{ $sisaHari }}
                                hari lalu
                            </tdlass=>
                        @endif
                    </tr>
                @else
                    <tr>
                        @if ($sbp->tot_in - $sbp->tot_out != 0)
                            <td>{{ $sbp->batch_product }}</td>
                            @if ($sbp->tot_in == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_in }}</td>
                            @endif

                            @if ($sbp->tot_out == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $sbp->tot_out }}</td>
                            @endif
                            <td>{{ $sbp->tanggal_kadaluwarsa }}</td>
                        @endif
                    </tr>
                @endif
            @endforeach
        @else
            <tr colspan="4"> Tidak ada stok tersisa </tr>
        @endif
    </tbody>
</table>
