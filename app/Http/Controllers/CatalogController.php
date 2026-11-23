<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $labs = Lab::with(['items' => fn ($q) => $q
            ->where('item_condition', 'baik')
            ->orderBy('code')])
            ->orderBy('name')
            ->get();

        return view('borrower.catalog', compact('labs'));
    }
}