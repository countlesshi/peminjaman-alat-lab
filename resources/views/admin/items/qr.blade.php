<style>
    @media print { .no-print { display: none; } }
</style>

<p class="no-print"><a href="{{ route('admin.items.index') }}">← Daftar alat</a></p>

<div style="width:240px">
    {!! $svg !!}
</div>

<p>
    <strong>{{ $item->name }}</strong><br>
    {{ $item->code }} - {{ $item->lab->name }}
</p>

<p class="no-print"><small>Isi QR: {{ $url }}</small></p>

<button class="no-print" onclick="window.print()">Cetak</button>