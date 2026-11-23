@extends('layouts.admin')

@section('title', 'Semua peminjaman')

@section('content')
    <div class="page-head">
        <div>
            <h1>Semua peminjaman</h1>
            <p>Serahkan alat saat mahasiswa datang, terima kembali saat selesai.</p>
        </div>

        <form method="GET" action="{{ route('admin.loans.index') }}">
            <div class="field">
                <label for="status" style="font-size: 13px; color: var(--muted)">Filter status</label>
                <select id="status" name="status" class="select" style="height: 44px; font-size: 15px" data-autosubmit>
                    <option value="">Semua</option>
                    @foreach (['dipesan' => 'Dipesan', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <noscript><button type="submit" class="btn btn-ghost btn-sm">Terapkan</button></noscript>
        </form>
    </div>

    @error('loan')
        <div class="alert alert-error" role="alert">
            <svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v5M12 18v.01"/></svg>
            <div>{{ $message }}</div>
        </div>
    @enderror

    @isset($stats)
        <div class="stats">
            <div class="stat stat-blue"><span>Dipesan</span><strong>{{ $stats['dipesan'] }}</strong></div>
            <div class="stat stat-amber"><span>Dipinjam</span><strong>{{ $stats['dipinjam'] }}</strong></div>
            <div class="stat stat-red"><span>Terlambat</span><strong>{{ $stats['terlambat'] }}</strong></div>
            <div class="stat stat-green"><span>Dikembalikan</span><strong>{{ $stats['dikembalikan'] }}</strong></div>
        </div>
    @endisset

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th scope="col">Peminjam</th>
                    <th scope="col">Alat</th>
                    <th scope="col">Jadwal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr>
                        <td><strong>{{ $loan->user->name }}</strong></td>
                        <td>
                            {{ $loan->item->name }}
                            <span class="sub">{{ $loan->item->code }}</span>
                        </td>
                        <td class="when">
                            {{ $loan->start_at->format('d M Y') }}<br>
                            {{ $loan->start_at->format('H:i') }}–{{ $loan->end_at->format('H:i') }}
                        </td>
                        <td>@include('partials.status', ['loan' => $loan])</td>
                        <td>
                            @if ($loan->status === 'dipesan')
                                <form method="POST" action="{{ route('admin.loans.handover', $loan) }}" data-once>
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm">Serahkan</button>
                                </form>
                            @elseif ($loan->status === 'dipinjam')
                                <form method="POST" action="{{ route('admin.loans.receive', $loan) }}" data-once>
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-dark btn-sm">Terima Kembali</button>
                                </form>
                            @else
                                <span class="muted">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted" style="padding: 32px; text-align: center">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $loans->links('partials.pagination') }}
@endsection
