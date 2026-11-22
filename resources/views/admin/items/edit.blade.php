<h1>Ubah Alat</h1>

<form method="POST" action="{{ route('admin.items.update', $item) }}">
    @csrf
    @method('PUT')
    @include('admin.items._form')
    <button type="submit">Perbarui</button>
    <a href="{{ route('admin.items.index') }}">Batal</a>
</form>