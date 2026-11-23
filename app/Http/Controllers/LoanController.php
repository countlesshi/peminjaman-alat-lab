<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function create(Item $item): View
    {
        abort_if($item->item_condition !== 'baik', 404);

        $item->load('lab');

        return view('borrower.loans.create', compact('item'));
    }

    public function store(Request $request, Item $item): RedirectResponse
    {
        $data = $request->validate([
            'start_at' => ['required', 'date', 'after:now'],
            'end_at' => ['required', 'date', 'after:start_at'],
        ]);

        if ($item->item_condition !== 'baik') {
            return back()
                ->withErrors(['start_at' => 'Alat ini sedang dalam perbaikan.'])
                ->withInput();
        }

        $conflict = DB::transaction(function () use ($item, $data, $request) {
            // Kunci baris alat: kalau dua orang memesan di saat yang sama,
            // permintaannya diproses bergantian, bukan bersamaan.
            Item::whereKey($item->id)->lockForUpdate()->first();

            $bentrok = Loan::where('item_id', $item->id)
                ->overlapping($data['start_at'], $data['end_at'])
                ->exists();

            if ($bentrok) {
                return true;
            }

            Loan::create([
                'user_id' => $request->user()->id,
                'item_id' => $item->id,
                'start_at' => $data['start_at'],
                'end_at' => $data['end_at'],
                'status' => 'dipesan',
            ]);

            return false;
        });

        if ($conflict) {
            return back()
                ->withErrors(['start_at' => 'Jadwal bentrok dengan reservasi lain. Coba pilih waktu yang berbeda.'])
                ->withInput();
        }

        return redirect()->route('borrower.catalog')
            ->with('status', 'Reservasi berhasil dibuat.');
    }

    public function index(Request $request): View
    {
        $loans = $request->user()->loans()
            ->with('item.lab')
            ->orderByDesc('start_at')
            ->paginate(10);

        return view('borrower.loans.index', compact('loans'));
    }
}