<h1>Daftar Alat</h1>

<p>
    <a href="{{ route('admin.dashboard') }}">← Dashboard</a> |
    <a href="{{ route('admin.items.create') }}">+ Tambah alat</a>
</p>

@if (session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

@error('delete')
    <p style="color:red">{{ $message }}</p>
@enderror

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Lab</th>
            <th>Kondisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->lab->name }}</td>
                <td>{{ $item->item_condition }}</td>
                <td>
                    <a href="{{ route('admin.items.edit', $item) }}">Ubah</a>
                    <a href="{{ route('admin.items.qr', $item) }}">QR</a>

                    <form method="POST" action="{{ route('admin.items.destroy', $item) }}"
                          style="display:inline"
                          onsubmit="return confirm('Hapus alat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada alat.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $items->links() }}