<h1>Katalog Alat</h1>
<p>Halo, {{ auth()->user()->name }}</p>

<p><a href="{{ route('borrower.loans.index') }}">Riwayat Saya</a></p>

@if (session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

@foreach ($labs as $lab)
    <h2>{{ $lab->name }}</h2>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lab->items as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td><a href="{{ route('borrower.loans.create', $item) }}">Pesan</a></td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada alat tersedia.</td></tr>
            @endforelse
        </tbody>
    </table>
@endforeach

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Keluar</button>
</form>