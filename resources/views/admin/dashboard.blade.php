<h1>Dashboard Admin</h1>
<p>Halo, {{ auth()->user()->name }}</p>

<p><a href="{{ route('admin.items.index') }}">Kelola alat</a></p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Keluar</button>
</form>