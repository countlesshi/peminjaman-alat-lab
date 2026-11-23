{{-- Pemakaian: @include('partials.status', ['loan' => $loan]) --}}
@php
    $map = [
        'dipesan' => ['badge-blue', 'Dipesan'],
        'dipinjam' => ['badge-amber', 'Dipinjam'],
        'dikembalikan' => ['badge-green', 'Dikembalikan'],
    ];
    [$cls, $label] = $map[$loan->status] ?? ['badge-blue', ucfirst($loan->status)];
@endphp
<span class="badge {{ $cls }}">{{ $label }}</span>
@if ($loan->isLate())
    <strong class="late">TERLAMBAT</strong>
@endif
