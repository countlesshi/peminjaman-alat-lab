@extends('layouts.borrower')

@section('title', 'Riwayat saya')

@section('content')
    <div class="page-head">
        <div>
            <h1>Riwayat saya</h1>
            <p>Semua reservasi alat yang pernah kamu buat.</p>
        </div>
        <a href="{{ route('borrower.catalog') }}" class="btn btn-primary">+ Pesan alat</a>
    </div>

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th scope="col">Alat</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Jadwal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Dikembalikan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr>
                        <td>
                            {{ $loan->item->name }}
                            <span class="sub">{{ $loan->item->code }}</span>
                        </td>
                        <td>{{ $loan->item->lab->name }}</td>
                        <td class="when">
                            {{ $loan->start_at->format('d M Y') }}<br>
                            {{ $loan->start_at->format('H:i') }}–{{ $loan->end_at->format('H:i') }}
                        </td>
                        <td>@include('partials.status', ['loan' => $loan])</td>
                        <td class="when">{{ $loan->returned_at?->format('d M Y H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted" style="padding: 32px; text-align: center">Belum ada reservasi. Mulai dari katalog alat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $loans->links('partials.pagination') }}
@endsection
