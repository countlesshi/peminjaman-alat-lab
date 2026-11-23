@extends('layouts.admin')

@section('title', 'Detail ' . $item->code)

@section('content')
    <a href="{{ route('admin.loans.index') }}" class="link-back">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
        Semua peminjaman
    </a>

    @error('loan')
        <div class="alert alert-error" role="alert">
            <svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v5M12 18v.01"/></svg>
            <div>{{ $message }}</div>
        </div>
    @enderror

    <section class="scan-head">
        <span style="font-size: 13px; font-weight: 600; letter-spacing: .06em; color: #A9B8B3">DETAIL ALAT</span>
        <h1>{{ $item->name }}</h1>
        <p class="meta"><span class="mono">{{ $item->code }}</span> · {{ $item->lab->name }}</p>

        @if ($item->item_condition === 'baik')
            <span class="badge badge-green">Kondisi baik</span>
        @else
            <span class="badge badge-amber">Sedang dalam perbaikan</span>
        @endif
    </section>

    <h2 style="font-size: 18px">Reservasi hari ini dan alat yang sedang dipinjam</h2>

    <div class="loan-list">
        @forelse ($loans as $loan)
            <article @class(['loan-card', 'is-late' => $loan->isLate()])>
                <div class="loan-card-top">
                    <div>
                        <strong>{{ $loan->user->name }}</strong>
                        <div class="mono muted" style="font-size: 13px">
                            {{ $loan->start_at->isToday() ? '' : $loan->start_at->format('d M') . ' ' }}{{ $loan->start_at->format('H:i') }}–{{ $loan->end_at->format('H:i') }}
                        </div>
                    </div>
                    <div>@include('partials.status', ['loan' => $loan])</div>
                </div>

                @if ($loan->status === 'dipesan')
                    <form method="POST" action="{{ route('admin.loans.handover', $loan) }}" data-once>
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-block">Serahkan</button>
                    </form>
                @elseif ($loan->status === 'dipinjam')
                    <form method="POST" action="{{ route('admin.loans.receive', $loan) }}" data-once>
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-dark btn-block">Terima Kembali</button>
                    </form>
                @endif
            </article>
        @empty
            <p class="empty">Tidak ada reservasi hari ini.</p>
        @endforelse
    </div>
@endsection
