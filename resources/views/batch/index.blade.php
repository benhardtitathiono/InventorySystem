@extends('layout.halaman_utama_admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modalContent.css') }}" type="text/css">
@endsection

@section('konten')
    <div class="page-content">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('error') }}</p>
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div style="margin-bottom: 10px">
            {{-- <a href="#modalEditProduct" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteProductList('@php echo $_GET['kategori'] @endphp')">Lihat Data
                Yang Dihapus</a> --}}
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="listBatch" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Sisa Stok</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Kadaluwarsa</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($bp) && count($bp) > 0)
                    @foreach ($bp as $bp)
                        @php
                            $sisaHari = \Carbon\Carbon::now('Asia/Jakarta')->diffInDays(
                                \Carbon\Carbon::parse($bp->tanggal_kadaluarsa),
                                false,
                            );
                        @endphp

                        @if ($sisaHari >= 0 and $sisaHari <= 30)
                            @if ($bp->jumlah > 0)
                                <tr class="tanggal_exp">
                                    <td>{{ $bp->id }}</td>
                                    <td>{{ $bp->nama_barang }}</td>
                                    <td>{{ $bp->jumlah }}</td>
                                    <td>{{ $bp->tanggal_masuk }}</td>
                                    <td>{{ $bp->tanggal_kadaluarsa }} Kurang dari {{ $sisaHari }}
                                        hari lagi expire
                                    </td>
                                    <td style="text-align: center">
                                        {{-- <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                            onclick="getLogProduct({{ $p->id }})">Log Stok</a> --}}
                                        <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs">Log
                                            Stok</a>
                                        {{-- <form method="POST" action="{{ route('product.destroy', $p->id) }}"> --}}
                                        {{-- @csrf --}}
                                        <input type="submit" value="Hapus" class="btn btn-danger"
                                            onclick="return confirm('Apakah yakin ingin menghapus produk dengan ID {{ $bp->id }} - {{ $bp->nama_barang }}?')">
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                            @endif
                        @elseif ($sisaHari < 0)
                            @if ($bp->jumlah > 0)
                                <tr class="tanggal_exp">
                                    <td>{{ $bp->id }}</td>
                                    <td>{{ $bp->nama_barang }}</td>
                                    <td>{{ $bp->jumlah }}</td>
                                    <td>{{ $bp->tanggal_masuk }}</td>
                                    <td>{{ $bp->tanggal_kadaluarsa }} sudah expire sejak {{ $sisaHari }} hari lalu
                                    </td>
                                    <td style="text-align: center">
                                        {{-- <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                            onclick="getLogProduct({{ $p->id }})">Log Stok</a> --}}
                                        <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs">Log
                                            Stok</a>
                                        {{-- <form method="POST" action="{{ route('product.destroy', $p->id) }}"> --}}
                                        {{-- @csrf --}}
                                        <input type="submit" value="Hapus" class="btn btn-danger"
                                            onclick="return confirm('Apakah yakin ingin menghapus produk dengan ID {{ $bp->id }} - {{ $bp->nama_barang }}?')">
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                            @endif
                        @else
                            @if ($bp->jumlah > 0)
                                <tr>
                                    <td>{{ $bp->id }}</td>
                                    <td>{{ $bp->nama_barang }}</td>
                                    <td>{{ $bp->jumlah }}</td>
                                    <td>{{ $bp->tanggal_masuk }}</td>
                                    <td>{{ $bp->tanggal_kadaluarsa }}</td>
                                    <td style="text-align: center">
                                        {{-- <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                            onclick="getLogProduct({{ $p->id }})">Log Stok</a> --}}
                                        <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs">Log
                                            Stok</a>
                                        {{-- <form method="POST" action="{{ route('product.destroy', $p->id) }}"> --}}
                                        {{-- @csrf --}}
                                        <input type="submit" value="Hapus" class="btn btn-danger"
                                            onclick="return confirm('Apakah yakin ingin menghapus produk dengan ID {{ $bp->id }} - {{ $bp->nama_barang }}?')">
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endif

            </tbody>
        </table>

        <div class="modal fade" id="modalEditProduct" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-wide">
                <div class="modal-content">
                    <div class="modal-body" id="modalContent">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#listBatch').DataTable({
                responsive: true,

                "pagingType": "full_numbers",

                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All']
                ],

                order: [
                    [4, 'asc']
                ],

                columnDefs: [{
                    className: 'dtr-control',
                    target: '_all',
                    orderable: true
                }],

                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },

                language: {
                    emptyTable: 'Tidak ada data produk',
                    info: "Tampilan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: 'Tidak ada data produk',
                    infoFiltered: "(Pencarian dari _MAX_ total data)",
                    lengthMenu: "Tampilkan _MENU_ Data",
                    zeroRecords: 'Tidak ada data produk'
                },
            });
        });

        // function getDeleteProductList(tipe) {
        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ url('productabispakaiterhapus') }}/" + tipe,
        //         data: {
        //             '_token': '<?php echo csrf_token(); ?>',
        //         },
        //         success: function(data) {
        //             $('#modalContent').html(data.msg)
        //         }
        //     });
        // }
    </script>
@endsection
