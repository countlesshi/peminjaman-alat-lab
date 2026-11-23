@extends('layouts.admin')

@section('title', 'QR ' . $item->code)

@section('content')
    <a href="{{ route('admin.items.index') }}" class="link-back no-print">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
        Daftar alat
    </a>

    <div class="page-head no-print">
        <div>
            <h1>Label QR</h1>
            <p>Cetak, lalu tempel di alat. Scan untuk membuka halaman serah-terima.</p>
        </div>
        <button type="button" class="btn btn-primary" data-print>Cetak label</button>
    </div>

    <div class="qr-label">
        <div class="qr-label-head">
            <strong>Pinjam Alat Lab</strong>
            <span class="tag tag-{{ $item->lab_id % 3 }}">{{ $item->lab->name }}</span>
        </div>

        <div class="qr-box" role="img" aria-label="QR code untuk {{ $item->name }}">
            {!! $svg !!}
        </div>

        <div>
            <div class="qr-name">{{ $item->name }}</div>
            <div class="mono muted">{{ $item->code }}</div>
        </div>
        <div class="qr-foot">Scan untuk melihat jadwal dan serah-terima</div>
    </div>

    <p class="muted no-print" style="font-size: 13px">Isi QR: <span class="mono">{{ $url }}</span></p>
@endsection
