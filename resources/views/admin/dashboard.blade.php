@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-head">
        <div>
            <h1>Dashboard</h1>
            <p>Halo, {{ auth()->user()->name }}. Ringkasan peminjaman lab hari ini.</p>
        </div>
    </div>

    @isset($stats)
        <div class="stats">
            <div class="stat stat-blue"><span>Dipesan</span><strong>{{ $stats['dipesan'] }}</strong></div>
            <div class="stat stat-amber"><span>Dipinjam</span><strong>{{ $stats['dipinjam'] }}</strong></div>
            <div class="stat stat-red"><span>Terlambat</span><strong>{{ $stats['terlambat'] }}</strong></div>
            <div class="stat stat-green"><span>Dikembalikan</span><strong>{{ $stats['dikembalikan'] }}</strong></div>
        </div>
    @endisset

    <div class="quick">
        <a href="{{ route('admin.loans.index') }}">
            <strong>Semua peminjaman</strong>
            <span>Serahkan alat saat mahasiswa datang, terima kembali saat selesai.</span>
        </a>
        <a href="{{ route('admin.items.index') }}">
            <strong>Kelola alat</strong>
            <span>Tambah, ubah, hapus alat, dan cetak label QR untuk ditempel di alat.</span>
        </a>
    </div>
@endsection
