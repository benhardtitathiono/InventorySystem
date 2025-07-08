@extends('layout.halaman_utama_admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modalContent.css') }}" type="text/css">
@endsection

@section('konten')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    <div class="page-content">
        <table id="listProduct" class="table">
            <thead>
                <tr>
                    <th>ID Product</th>
                    <th>Nama Produk</th>
                    <th>Total Barang Dipinjam</th>
                    <th>Bulan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $row)
                    <tr>
                        <td>{{ $row->id_barang }}</td>
                        <td>{{ $row->nama_barang }}</td>
                        <td>{{ $row->total_dipinjam }}</td>
                        <td>{{ $row->bulan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data peminjaman bulan ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endsection
