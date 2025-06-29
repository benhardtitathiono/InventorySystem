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
            <a href="#modalCreate" data-toggle="modal" class="btn btn-info">Tambah produk baru</a>
            {{-- <a href="#modalDetailBarang" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteProductList('@php echo $_GET['kategori'] @endphp')">Lihat Data
                Yang Dihapus</a> --}}
            {{-- <a href="#modalDetailBarang" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteProductList(@php echo $_GET['kategori'] @endphp)">Lihat Data
                Yang Dihapus</a> --}}
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Identitas Peminjam</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Terakhir Diperbarui</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($pinjam) && count($pinjam) > 0)
                    @foreach ($pinjam as $p)
                        <tr>
                            <td>{{ $p->pinjamID }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->created_at }}</td>
                            <td>{{ $p->updated_at }}</td>

                            <td style="text-align: center">
                                <a href="#modalDetailBarang" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getDetailBarangForm({{ $p->pinjamID }})">Barang Kembali</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="modal fade" id="modalDetailBarang" tabindex="-1" role="basic" aria-hidden="true">
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
            $('#listProduct').DataTable({
                responsive: true,

                "pagingType": "full_numbers",

                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All']
                ],

                order: [
                    [1, 'asc']
                ],

                columnDefs: [{
                    // data: null,
                    // defaultContent: 'Tidak ada data produk',
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

        function getDetailBarangForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('barangkembali.status') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        // function getUpdateStokOutForm(id) {
        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ route('product.getUpdateStokOutForm') }}',
        //         data: {
        //             '_token': '<?php echo csrf_token(); ?>',
        //             'id': id
        //         },
        //         success: function(data) {
        //             $('#modalContent').html(data.msg)
        //         }
        //     });
        // }

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

        // function getLogProduct(id) {
        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ route('log.getLogProduct') }}',
        //         data: {
        //             '_token': '<?php echo csrf_token(); ?>',
        //             'id': id
        //         },
        //         success: function(data) {
        //             $('#modalContent').html(data.msg)
        //         }
        //     });
        // }
    </script>
@endsection
