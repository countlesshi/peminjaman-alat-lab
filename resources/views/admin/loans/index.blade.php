<h1>Semua Peminjaman</h1>

<p><a href="{{ route('admin.dashboard') }}">← Dashboard</a></p>

@if (session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

@error('loan')
    <p style="color:red">{{ $message }}</p>
@enderror

<form method="GET" action="{{ route('admin.loans.index') }}">
    <label>Filter status:</label>
    <select name="status" onchange="this.form.submit()">
        <option value="">Semua</option>
        @foreach (['dipesan', 'dipinjam', 'dikembalikan'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</form>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($loans as $loan)
            <tr>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->item->name }} ({{ $loan->item->code }})</td>
                <td>{{ $loan->start_at->format('d M Y H:i') }}</td>
                <td>{{ $loan->end_at->format('d M Y H:i') }}</td>
                <td>
                    {{ $loan->status }}
                    @if ($loan->isLate())
                        <strong style="color:red">TERLAMBAT</strong>
                    @endif
                </td>
                <td>
                    @if ($loan->status === 'dipesan')
                        <form method="POST" action="{{ route('admin.loans.handover', $loan) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Serahkan</button>
                        </form>
                    @elseif ($loan->status === 'dipinjam')
                        <form method="POST" action="{{ route('admin.loans.receive', $loan) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Terima Kembali</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada data.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $loans->links() }}