<h1>Riwayat Saya</h1>

<p><a href="{{ route('borrower.catalog') }}">← Katalog</a></p>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Alat</th>
            <th>Lab</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Status</th>
            <th>Dikembalikan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($loans as $loan)
            <tr>
                <td>{{ $loan->item->name }} ({{ $loan->item->code }})</td>
                <td>{{ $loan->item->lab->name }}</td>
                <td>{{ $loan->start_at->format('d M Y H:i') }}</td>
                <td>{{ $loan->end_at->format('d M Y H:i') }}</td>
                <td>
                    {{ $loan->status }}
                    @if ($loan->isLate())
                        <strong style="color:red">TERLAMBAT</strong>
                    @endif
                </td>
                <td>{{ $loan->returned_at?->format('d M Y H:i') ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada reservasi.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $loans->links() }}