@extends('layouts.borrower')

@section('title', 'Katalog alat')

@section('content')
    <div class="page-head">
        <div>
            <h1>Katalog alat</h1>
            <p>Pilih alat, lalu tentukan tanggal dan jam pemakaian.</p>
        </div>

        <div class="search">
            <label class="sr-only" for="cari">Cari alat</label>
            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5B6770" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
            <input id="cari" type="search" class="input" placeholder="Cari nama atau kode alat" data-catalog-search>
        </div>
    </div>

    <div class="chips" role="group" aria-label="Filter lab">
        <button type="button" class="chip is-active" aria-pressed="true" data-lab-filter="all">Semua lab</button>
        @foreach ($labs as $lab)
            <button type="button" class="chip" aria-pressed="false" data-lab-filter="{{ $lab->id }}">{{ $lab->name }}</button>
        @endforeach
    </div>

    <div class="cards" data-catalog-grid>
        @foreach ($labs as $lab)
            @foreach ($lab->items as $item)
                @php
                    $booked = $item->loans;
                    $first = $booked->first();
                @endphp
                <article class="card item-card"
                         data-lab="{{ $lab->id }}"
                         data-text="{{ mb_strtolower($item->name . ' ' . $item->code) }}">
                    <div class="item-top">
                        <span class="tag tag-{{ $lab->id % 3 }}">{{ $lab->name }}</span>
                        <span class="item-code">{{ $item->code }}</span>
                    </div>

                    <div>
                        <h3>{{ $item->name }}</h3>
                    </div>

                    <div>
                        @if ($first)
                            <span class="badge badge-blue">
                                Dipesan {{ $first->start_at->format('H:i') }}–{{ $first->end_at->format('H:i') }}@if ($booked->count() > 1) +{{ $booked->count() - 1 }} lagi @endif
                            </span>
                        @else
                            <span class="badge badge-green">Tersedia hari ini</span>
                        @endif
                    </div>

                    <a href="{{ route('borrower.loans.create', $item) }}" class="btn btn-primary">Pesan</a>
                </article>
            @endforeach
        @endforeach
    </div>

    <p class="empty" data-empty hidden>Tidak ada alat yang cocok dengan pencarianmu.</p>
@endsection
