<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLoanController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'status' => ['nullable', Rule::in(['dipesan', 'dipinjam', 'dikembalikan'])],
        ]);

        $loans = Loan::with(['user', 'item.lab'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('start_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.loans.index', compact('loans'));
    }

    public function handover(Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'dipesan') {
            return back()->withErrors([
                'loan' => 'Hanya reservasi berstatus "dipesan" yang bisa diserahkan.',
            ]);
        }

        $loan->update(['status' => 'dipinjam']);

        return back()->with('status', 'Alat diserahkan kepada peminjam.');
    }

    public function receive(Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'dipinjam') {
            return back()->withErrors([
                'loan' => 'Hanya alat berstatus "dipinjam" yang bisa diterima kembali.',
            ]);
        }

        $loan->update([
            'status' => 'dikembalikan',
            'returned_at' => now(),
        ]);

        return back()->with('status', 'Alat sudah diterima kembali.');
    }
}