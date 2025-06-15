@extends('layout.halaman_utama_admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modalContent.css') }}" type="text/css">
@endsection

@section('konten')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    <div class="page-content">
        <form action="{{ route('log.logpap') }}" id="dateReportForm">
            <input type="date" class="form-control" name="dateReport" id="dateReport" aria-describedby="dateReport"
                max="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}" value="{{ $date }}">
            {{-- <button type="submit" class="btn btn-primary">Cari</button> --}}
        </form>
        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID Product</th>
                    <th>Nama Produk</th>
                    <th>Total Stok Masuk</th>
                    <th>Total Stok Keluar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if (!$logpap->isEmpty())
                    @foreach ($logpap as $lp)
                        <tr>
                            <td>{{ $lp->id }}</td>
                            <td>{{ $lp->nama_barang }}</td>
                            @if ($lp->totquanin == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $lp->totquanin }}</td>
                            @endif

                            @if ($lp->totquanout == null or 0)
                                <td>0</td>
                            @else
                                <td>{{ $lp->totquanout }}</td>
                            @endif
                            <td>{{ $lp->tanggal }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center; font-size:20px; font-weight:bold;" colspan="7">Tidak aktivitas
                            keluar
                            masuk produk
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endsection

    @section('javascript')
        <script>
            document.getElementById('dateReport').addEventListener('change', function(event) {
                event.preventDefault();
                document.getElementById('dateReportForm').submit();
            });
            // $('#dateReport').change(function(event) {
            //     event.preventDefault();
            //     $('#dateReportForm')[0].submit();
            // })
        </script>
    @endsection
