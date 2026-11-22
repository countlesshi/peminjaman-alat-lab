<h1>Katalog Alat</h1>
<p>Halo, {{ auth()->user()->name }}</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Keluar</button>
</form>