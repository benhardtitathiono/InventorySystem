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
            <a href="#modalCreate" data-toggle="modal" class="btn btn-info">Tambah Barang Baru</a>
            <a href="#modalEditBarang" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteBarangList('@php echo $_GET['kategori'] @endphp')">Lihat Data Yang Dihapus</a>
            <form method="POST" action="{{ route('productpinjam.getBorrowForm') . '?kategori=' . $_GET['kategori'] }}">
                @csrf
                <button type="submit" class="btn btn-info" id="borrowForm">Tambah Peminjaman Baru</button>
            </form>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="listBarang" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Unit</th>
                    <th>Unit Terpinjam</th>
                    <th>Unit Tersedia/Kembali</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Terakhir Diperbarui</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($barangPinjam) && count($barangPinjam) > 0)
                    @foreach ($barangPinjam as $bp)
                        <tr>
                            <td>{{ $bp->id }}</td>
                            <td class="editable" id="td-nama_barang-{{ $bp->id }}">{{ $bp->nama_barang }}</td>
                            <td class="editable" id="td-deskripsi-{{ $bp->id }}">{{ $bp->deskripsi }}</td>
                            <td id="td-jumlah-{{ $bp->id }}">{{ $bp->jumlah }}</td>
                            <!-- <td>{{ $bp->jumlah - $bp->totalBarangDipinjam }}</td> -->
                            <td>{{ $bp->stok_terpinjam }}</td>
                            <td>{{ $bp->stok_tersedia }}</td>
                            <td id="td-created_at-{{ $bp->id }}">{{ $bp->created_at }}</td>
                            <td id="td-updated_at-{{ $bp->id }}">{{ $bp->updated_at }}</td>

                            <td style="text-align: center">
                                {{-- <a href="#modalEditBarang" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getBorrowForm({{ $bp->id }})">Peminjaman</a> --}}
                                <form method="POST" action="{{ route('productpinjam.destroy', $bp->id) }}">
                                    @csrf
                                    <input type="submit" value="Hapus" class="btn btn-danger"
                                        onclick="return confirm('Apakah yakin ingin menghapus barang dengan ID {{ $bp->id }} - {{ $bp->nama_barang }}?')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="modal fade" id="modalEditBarang" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-wide">
                <div class="modal-content">
                    <div class="modal-body" id="modalContent">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah barang baru</h4>
                </div>
                <form id="formBorrow" method="POST" action="{{ route('productpinjam.store') }}"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="nameBarang">Nama Barang</label>
                            <input type="text" class="form-control" name="nameBarang" id="nameBarang"
                                aria-describedby="nameHelp" placeholder="Nama Barang">

                            <label for="descBarang">Deskripsi</label>
                            <input type="text" class="form-control" name="descBarang" id="descBarang"
                                aria-describedby="descHelp" placeholder="Deskripsi">

                            <label for="jumlahBarang">Stok</label>
                            <input type="number" class="form-control" name="jumlahBarang" id="jumlahBarang"
                                aria-describedby="jumlahHelp" placeholder="Stok awal" min="1">

                            <label for="tipeBarang">Poli</label>
                            <select name="tipeBarang" id="tipeBarang" class="form-control" aria-describedby="tipeHelp">
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#listBarang').DataTable({
                responsive: true,

                "pagingType": "full_numbers",

                order: [
                    [1, 'asc']
                ],

                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All']
                ],

                columnDefs: [{
                    // data: null,
                    // defaultContent: 'Tidak ada data barang2',
                    className: 'dtr-control',
                    orderable: true,
                    target: '_all'
                }],

                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                

                language: {
                    emptyTable: 'Tidak ada data barang',
                    info: "Tampilan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: 'Tidak ada data barang',
                    infoFiltered: "(Pencarian dari _MAX_ total data)",
                    lengthMenu: "Tampilkan _MENU_ Data",
                    zeroRecords: 'Tidak ada data barang'
                },
            });
        });

        function getDeleteBarangList(tipe) {
            $.ajax({
                type: 'POST',
                url: "{{ url('productpinjamterhapus') }}/" + tipe,
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

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
