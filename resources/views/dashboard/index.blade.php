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

        <div class="content-wrapper">
            <h3>SELAMAT DATANG DI SISTEM PENGADAAN BARANG HABIS PAKAI</h3>
            <h1>KLINIK PRATAMA UBAYA</h1>
            <h4>Jl. Tenggilis Mejoyo Blk. AN No.20, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</h4>
        </div>
    </div>


@endsection