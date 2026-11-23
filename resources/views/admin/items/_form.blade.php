@include('partials.errors')

<div class="field">
    <label for="lab_id">Lab</label>
    <select id="lab_id" name="lab_id" class="select @error('lab_id') is-invalid @enderror" required>
        <option value="">-- pilih lab --</option>
        @foreach ($labs as $lab)
            <option value="{{ $lab->id }}" @selected(old('lab_id', $item->lab_id) == $lab->id)>{{ $lab->name }}</option>
        @endforeach
    </select>
    @error('lab_id')<span class="field-error">{{ $message }}</span>@enderror
</div>

<div class="field">
    <label for="code">Kode</label>
    <input id="code" name="code" type="text" maxlength="20" class="input mono @error('code') is-invalid @enderror"
           value="{{ old('code', $item->code) }}" placeholder="contoh: KOM-001" required>
    @error('code')<span class="field-error">{{ $message }}</span>@enderror
</div>

<div class="field">
    <label for="name">Nama alat</label>
    <input id="name" name="name" type="text" maxlength="100" class="input @error('name') is-invalid @enderror"
           value="{{ old('name', $item->name) }}" placeholder="contoh: Laptop #01" required>
    @error('name')<span class="field-error">{{ $message }}</span>@enderror
</div>

<div class="field">
    <label for="item_condition">Kondisi</label>
    <select id="item_condition" name="item_condition" class="select @error('item_condition') is-invalid @enderror" required>
        @foreach (['baik' => 'Baik', 'perbaikan' => 'Perbaikan'] as $value => $label)
            <option value="{{ $value }}" @selected(old('item_condition', $item->item_condition ?? 'baik') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('item_condition')<span class="field-error">{{ $message }}</span>@enderror
</div>
