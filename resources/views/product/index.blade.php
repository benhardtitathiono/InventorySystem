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
            @can('staf')
            <a href="#modalCreate" data-toggle="modal" class="btn btn-info">Tambah produk baru</a>
            <a href="#modalEditProduct" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteProductList('@php echo $_GET['kategori'] @endphp')">Lihat Data
                Yang Dihapus</a>
            {{-- <a href="#modalEditProduct" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteProductList(@php echo $_GET['kategori'] @endphp)">Lihat Data
                Yang Dihapus</a> --}}
            @endcan
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Terakhir Diperbarui</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($pap) && count($pap) > 0)
                    @foreach ($pap as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td class="editable" id="td-nama_barang-{{ $p->id }}">{{ $p->nama_barang }}</td>
                            <td class="editable" id="td-satuan-{{ $p->id }}">{{ $p->satuan }}</td>
                            <td class="editable" id="td-deskripsi-{{ $p->id }}">{{ $p->deskripsi }}</td>
                            <td id="td-jumlah-{{ $p->id }}">{{ $p->jumlah }}</td>
                            <td id="td-created_at-{{ $p->id }}">{{ $p->created_at }}</td>
                            <td id="td-updated_at-{{ $p->id }}">{{ $p->updated_at }}</td>

                            <td style="text-align: center">
                                <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getUpdateStokForm({{ $p->id }})">Tambah Stok</a>
                                <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getUpdateStokOutForm({{ $p->id }})">Kurang Stok</a>
                                @can('staf')
                                <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getLogProduct({{ $p->id }})">Log Stok</a>
                                <a href="#modalEditProduct" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getStokBatchProduct({{ $p->id }})">Stok Batch</a>
                                @endcan
                                <form method="POST" action="{{ route('product.destroy', $p->id) }}">
                                    @csrf
                                    @can('staf')
                                    {{-- @method('DELETE') --}}
                                    <input type="submit" value="Hapus" class="btn btn-danger"
                                        onclick="return confirm('Apakah yakin ingin menghapus produk dengan ID {{ $p->id }} - {{ $p->nama_barang }}?')">
                                    @endcan
                                </form>
                            </td>
                        </tr>
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


    <div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
        @can('staf')
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah produk baru</h4>
                    
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nameProd">Nama Produk</label>
                            <input type="text" class="form-control" name="nameProduct" id="nameProd"
                                aria-describedby="nameHelp" placeholder="Nama produk">

                            <label for="satuanProd">Satuan</label>
                            <input type="text" class="form-control" name="satuanProd" id="satuanProd"
                                aria-describedby="satuanHelp" placeholder="Satuan">

                            <label for="descProd">Deskripsi</label>
                            <input type="text" class="form-control" name="descProd" id="descProd"
                                aria-describedby="descHelp" placeholder="Deskripsi">

                            <label for="jumlahProd">Stok</label>
                            <input type="number" class="form-control" name="jumlahProd" id="jumlahProd"
                                aria-describedby="jumlahHelp" placeholder="Stok awal" min="0">

                            <label for="tgglEx">Tanggal Kadaluwarsa</label>
                            <input type="date" class="form-control" name="dateExProd" id="dateExProd"
                                aria-describedby="dateExHelp"
                                min="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}">

                            <select name="tipeProd" id="tipeProd" class="form-control" aria-describedby="tipeHelp">
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        @endcan
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        //untuk pencarian
        document.getElementById('dt-search-0').addEventListener('click', function() {
            var input = document.getElementById('search-input').value;
            var regex = /^[a-zA-Z0-9\s\-\.]+$/;
            
            if (!regex.test(input)) {
                document.getElementById('error-message').textContent = 'Input hanya boleh mengandung huruf, angka, spasi, tanda sambung, dan titik.';
            } else {
                document.getElementById('error-message').textContent = '';
                // Lakukan aksi pencarian
                console.log('Search input is valid:', input);
            }
        });


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

        function getUpdateStokForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('product.getUpdateStokForm') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function getUpdateStokOutForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('product.getUpdateStokOutForm') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function getDeleteProductList(tipe) {
            $.ajax({
                type: 'POST',
                url: "{{ url('productabispakaiterhapus') }}/" + tipe,
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function getLogProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('log.getLogProduct') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }

        function getStokBatchProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('log.getStokBatchProduct') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg)
                }
            });
        }
    </script>
@endsection
