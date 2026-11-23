<h1>Detail Alat</h1>

<p><a href="{{ route('admin.loans.index') }}">← Semua peminjaman</a></p>

@if (session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

@error('loan')
    <p style="color:red">{{ $message }}</p>
@enderror

<h2>{{ $item->name }}</h2>
<p>
    Kode: {{ $item->code }}<br>
    Lab: {{ $item->lab->name }}<br>
    Kondisi: {{ $item->item_condition }}
</p>

@if ($item->item_condition === 'perbaikan')
    <p style="color:red"><strong>Alat ini sedang dalam perbaikan.</strong></p>
@endif

<h3>Reservasi hari ini dan alat yang sedang dipinjam</h3>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Peminjam</th>
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
            <tr><td colspan="5">Tidak ada reservasi hari ini.</td></tr>
        @endforelse
    </tbody>
</table>