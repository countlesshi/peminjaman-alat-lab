<h1>Pesan Alat</h1>

<p>
    <strong>{{ $item->name }}</strong> ({{ $item->code }})<br>
    {{ $item->lab->name }}
</p>

<p><a href="{{ route('borrower.catalog') }}">← Kembali ke katalog</a></p>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('borrower.loans.store', $item) }}">
    @csrf

    <div>
        <label>Mulai</label><br>
        <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" required>
    </div>

    <div>
        <label>Selesai</label><br>
        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" required>
    </div>

    <button type="submit">Pesan</button>
</form>