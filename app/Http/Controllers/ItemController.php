<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Lab;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::with('lab')->orderBy('code')->paginate(10);

        return view('admin.items.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.items.create', [
            'item' => new Item(),
            'labs' => Lab::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'lab_id' => ['required', 'exists:labs,id'],
            'code' => ['required', 'string', 'max:20', 'unique:items,code'],
            'name' => ['required', 'string', 'max:100'],
            'item_condition' => ['required', Rule::in(['baik', 'perbaikan'])],
        ]);

        Item::create($data);

        return redirect()->route('admin.items.index')
            ->with('status', 'Alat berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        return view('admin.items.edit', [
            'item' => $item,
            'labs' => Lab::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $data = $request->validate([
            'lab_id' => ['required', 'exists:labs,id'],
            'code' => ['required', 'string', 'max:20', Rule::unique('items', 'code')->ignore($item->id)],
            'name' => ['required', 'string', 'max:100'],
            'item_condition' => ['required', Rule::in(['baik', 'perbaikan'])],
        ]);

        $item->update($data);

        return redirect()->route('admin.items.index')
            ->with('status', 'Alat berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        if ($item->loans()->exists()) {
            return back()->withErrors([
                'delete' => 'Alat ini punya riwayat peminjaman, jadi tidak bisa dihapus. Ubah kondisinya jadi "perbaikan" saja.',
            ]);
        }

        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('status', 'Alat berhasil dihapus.');
    }
}
