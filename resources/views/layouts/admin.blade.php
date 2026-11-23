<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body>
@php
    $initials = mb_strtoupper(collect(explode(' ', auth()->user()->name))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp

<div class="shell">
    <aside class="sidebar">
        @include('partials.brand')

        <nav class="side-nav" aria-label="Menu admin">
            <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.items.index') }}" @class(['is-active' => request()->routeIs('admin.items.*')])>
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"/><path d="M12 12l8-4.5M12 12v9M12 12L4 7.5"/></svg>
                Kelola alat
            </a>
            <a href="{{ route('admin.loans.index') }}" @class(['is-active' => request()->routeIs('admin.loans.*')])>
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
                Semua peminjaman
            </a>
        </nav>

        <div class="side-user">
            <div class="side-user-info">
                <div class="avatar avatar-accent" aria-hidden="true">{{ $initials }}</div>
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ auth()->user()->role }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ondark btn-sm">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        @include('partials.flash')
        @yield('content')
    </main>
</div>
</body>
</html>
