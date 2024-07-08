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
            <a href="#modalCreate" data-toggle="modal" class="btn btn-info">Tambah identitas peminjam baru</a>
            <a href="#modalEditIdentitasPeminjam" data-toggle="modal" class="btn btn-info"
                onclick="getDeleteIdentitasList()">Lihat Data
                Yang Dihapus</a>

        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="listIdentitas" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Terakhir Diperbarui</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($identity))
                    @foreach ($identity as $i)
                        <tr>
                            <td>{{ $i->id }}</td>
                            <td class="editable" id="td-nama_barang-{{ $i->id }}">{{ $i->nama }}</td>
                            <td id="td-created_at-{{ $i->id }}">{{ $i->created_at }}</td>
                            <td id="td-created_at-{{ $i->id }}">{{ $i->updated_at }}</td>


                            <td style="text-align: center">
                                <a href="#modalEditIdentitasPeminjam" data-toggle="modal" class="btn btn-warning btn-xs"
                                    onclick="getLogIdentitasPeminjam({{ $i->id }})">Log Peminjam</a>
                                <form method="POST" action="{{ route('identitas.destroy', $i->id) }}">
                                    @csrf
                                    <input type="submit" value="Hapus" class="btn btn-danger"
                                        onclick="return confirm('Apakah yakin ingin menghapus identitas peminjam dengan ID {{ $i->id }} - {{ $i->nama }}?')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td style="text-align: center; font-size:20px; font-weight:bold;" colspan="5">Tidak ada identitas
                    </td>
                @endif

            </tbody>
        </table>

        <div class="modal fade" id="modalEditIdentitasPeminjam" tabindex="-1" role="basic" aria-hidden="true">
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
                    <h4 class="modal-title">Tambah identitas peminjam baru</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('identitas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nameIdentitas">Nama Identitas Peminjam</label>
                            <input type="text" class="form-control" name="nameIdentitas" id="nameIdentitas"
                                aria-describedby="nameIdentitasHelp" placeholder="Nama Identitas Peminjam">

                            {{-- <label for="descProd">Deskripsi</label>
                            <input type="text" class="form-control" name="descProd" id="descProd"
                                aria-describedby="descHelp" placeholder="Deskripsi"> --}}
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#listIdentitas').DataTable({
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
                    emptyTable: 'Tidak ada data identitas',
                    info: "Tampilan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: 'Tidak ada data identitas',
                    infoFiltered: "(Pencarian dari _MAX_ total data)",
                    lengthMenu: "Tampilkan _MENU_ Data",
                    zeroRecords: 'Tidak ada data identitas'
                },
            });
        });

        // function getUpdateStokForm(id) {
        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ route('product.getUpdateStokForm') }}',
        //         data: {
        //             '_token': '<?php echo csrf_token(); ?>',
        //             'id': id
        //         },
        //         success: function(data) {
        //             $('#modalContent').html(data.msg)
        //         }
        //     });
        // }

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

        function getDeleteIdentitasList() {
            $.ajax({
                type: 'GET',
                url: '{{ route('identitas.getDeleteIdentitasList') }}',
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
