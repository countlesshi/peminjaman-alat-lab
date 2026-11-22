@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div>
    <label>Lab</label><br>
    <select name="lab_id" required>
        <option value="">-- pilih lab --</option>
        @foreach ($labs as $lab)
            <option value="{{ $lab->id }}" @selected(old('lab_id', $item->lab_id) == $lab->id)>
                {{ $lab->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label>Kode</label><br>
    <input type="text" name="code" value="{{ old('code', $item->code) }}" required>
</div>

<div>
    <label>Nama alat</label><br>
    <input type="text" name="name" value="{{ old('name', $item->name) }}" required>
</div>

<div>
    <label>Kondisi</label><br>
    <select name="item_condition" required>
        @foreach (['baik', 'perbaikan'] as $kondisi)
            <option value="{{ $kondisi }}" @selected(old('item_condition', $item->item_condition ?? 'baik') == $kondisi)>
                {{ ucfirst($kondisi) }}
            </option>
        @endforeach
    </select>
</div>