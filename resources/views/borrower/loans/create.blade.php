@extends('layouts.borrower')

@section('title', 'Pesan ' . $item->name)

@section('content')
    @php
        // Jadwal ditampilkan untuk jam 08:00 sampai 18:00, 48px per jam.
        $startHour = 8;
        $endHour = 18;
        $px = 48;
        $dayStart = $date->copy()->setTime($startHour, 0);
        $dayEnd = $date->copy()->setTime($endHour, 0);
    @endphp

    <a href="{{ route('borrower.catalog') }}" class="link-back">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
        Kembali ke katalog
    </a>

    <div class="split">
        {{-- Kiri: form pemesanan --}}
        <section class="card panel">
            <div class="panel-meta">
                <span class="tag tag-{{ $item->lab_id % 3 }}">{{ $item->lab->name }}</span>
                <h1>Pesan {{ $item->name }}</h1>
                <span class="muted"><span class="mono">{{ $item->code }}</span> · {{ $item->lab->name }}</span>
            </div>

            @include('partials.errors')

            <form method="POST" action="{{ route('borrower.loans.store', $item) }}" data-once style="display: flex; flex-direction: column; gap: 20px">
                @csrf

                <div class="row2">
                    <div class="field">
                        <label for="start_at">Mulai</label>
                        <input id="start_at" name="start_at" type="datetime-local"
                               class="input @error('start_at') is-invalid @enderror"
                               value="{{ old('start_at', $date->format('Y-m-d') . 'T09:00') }}" required>
                    </div>
                    <div class="field">
                        <label for="end_at">Selesai</label>
                        <input id="end_at" name="end_at" type="datetime-local"
                               class="input @error('end_at') is-invalid @enderror"
                               value="{{ old('end_at', $date->format('Y-m-d') . 'T11:00') }}" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="min-height: 48px; font-size: 16px">Pesan alat</button>
                    <a href="{{ route('borrower.catalog') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </section>

        {{-- Kanan: jadwal alat pada tanggal yang dipilih --}}
        <section class="card panel">
            <div>
                <h2>Jadwal {{ $item->name }}</h2>
                <p class="muted" style="margin-top: 4px">{{ $date->copy()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>

            <form method="GET" action="{{ route('borrower.loans.create', $item) }}" class="date-form">
                <div class="field">
                    <label for="date">Lihat tanggal lain</label>
                    <input id="date" name="date" type="date" class="input" value="{{ $date->format('Y-m-d') }}" data-autosubmit>
                </div>
                <noscript><button type="submit" class="btn btn-ghost">Tampilkan</button></noscript>
            </form>

            <div class="tl" style="height: {{ ($endHour - $startHour) * $px }}px" aria-label="Jadwal alat">
                @for ($h = $startHour; $h < $endHour; $h++)
                    <div class="tl-line" style="top: {{ ($h - $startHour) * $px }}px">
                        <span class="tl-hour">{{ sprintf('%02d:00', $h) }}</span>
                    </div>
                @endfor

                @foreach ($loans as $loan)
                    @php
                        $from = max($loan->start_at->timestamp, $dayStart->timestamp);
                        $to = min($loan->end_at->timestamp, $dayEnd->timestamp);
                        $mine = $loan->user_id === auth()->id();
                    @endphp
                    @if ($to > $from)
                        <div class="tl-block {{ $mine ? 'is-mine' : '' }}"
                             style="top: {{ round(($from - $dayStart->timestamp) / 3600 * $px) }}px; height: {{ max(28, round(($to - $from) / 3600 * $px)) }}px">
                            <strong>{{ $mine ? 'Pesananmu' : 'Sudah dipesan' }}</strong>
                            <span class="mono">{{ $loan->start_at->format('H:i') }}–{{ $loan->end_at->format('H:i') }}</span>
                        </div>
                    @endif
                @endforeach
            </div>

            <p class="tl-note">Jadwal ditampilkan untuk jam {{ sprintf('%02d:00', $startHour) }}–{{ sprintf('%02d:00', $endHour) }}. Reservasi di luar jam itu tetap dicek saat kamu memesan.</p>

            <div class="legend">
                <span><i class="l-blue"></i>Sudah dipesan orang lain</span>
                <span><i class="l-mine"></i>Pesananmu</span>
            </div>
        </section>
    </div>
@endsection
