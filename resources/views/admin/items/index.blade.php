@extends('layouts.admin')

@section('title', 'Kelola alat')

@section('content')
    <div class="page-head">
        <div>
            <h1>Kelola alat</h1>
            <p>Satu baris mewakili satu unit alat fisik, dengan kode unik untuk QR.</p>
        </div>
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary">+ Tambah alat</a>
    </div>

    @error('delete')
        <div class="alert alert-error" role="alert">
            <svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v5M12 18v.01"/></svg>
            <div>{{ $message }}</div>
        </div>
    @enderror

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Kondisi</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="mono">{{ $item->code }}</td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td><span class="tag tag-{{ $item->lab_id % 3 }}">{{ $item->lab->name }}</span></td>
                        <td>
                            @if ($item->item_condition === 'baik')
                                <span class="badge badge-green">Baik</span>
                            @else
                                <span class="badge badge-amber">Perbaikan</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.items.qr', $item) }}" class="btn btn-ghost btn-sm">QR</a>
                                <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-ghost btn-sm">Ubah</a>
                                <form method="POST" action="{{ route('admin.items.destroy', $item) }}" data-confirm="Hapus alat {{ $item->code }}? Tindakan ini tidak bisa dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted" style="padding: 32px; text-align: center">Belum ada alat. Tambahkan yang pertama.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $items->links('partials.pagination') }}
@endsection
