<h1>Tambah Alat</h1>

<form method="POST" action="{{ route('admin.items.store') }}">
    @csrf
    @include('admin.items._form')
    <button type="submit">Simpan</button>
    <a href="{{ route('admin.items.index') }}">Batal</a>
</form>