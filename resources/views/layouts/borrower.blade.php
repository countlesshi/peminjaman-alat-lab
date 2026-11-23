<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body>
@php
    $initials = mb_strtoupper(collect(explode(' ', auth()->user()->name))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp

<header class="topbar">
    <div class="topbar-left">
        @include('partials.brand')
        <nav class="nav" aria-label="Menu utama">
            <a href="{{ route('borrower.catalog') }}" @class(['is-active' => request()->routeIs('borrower.catalog', 'borrower.loans.create')])>Katalog</a>
            <a href="{{ route('borrower.loans.index') }}" @class(['is-active' => request()->routeIs('borrower.loans.index')])>Riwayat Saya</a>
        </nav>
    </div>

    <div class="topbar-right">
        <div class="user">
            <div class="avatar" aria-hidden="true">{{ $initials }}</div>
            <span>{{ auth()->user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
        </form>
    </div>
</header>

<main class="page">
    @include('partials.flash')
    @yield('content')
</main>
</body>
</html>
