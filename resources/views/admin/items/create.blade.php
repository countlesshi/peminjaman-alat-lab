@extends('layouts.admin')

@section('title', 'Tambah alat')

@section('content')
    <a href="{{ route('admin.items.index') }}" class="link-back">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
        Daftar alat
    </a>

    <div class="page-head">
        <h1>Tambah alat</h1>
    </div>

    <form method="POST" action="{{ route('admin.items.store') }}" class="card form-card" data-once>
        @csrf
        @include('admin.items._form')

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.items.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
@endsection
