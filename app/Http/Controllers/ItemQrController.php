<?php

namespace App\Http\Controllers;

use App\Models\Item;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ItemQrController extends Controller
{
    public function show(Item $item): View
    {
        $item->load('lab');

        $url = route('admin.items.scan', $item);

        $renderer = new ImageRenderer(
            new RendererStyle(240, 2),
            new SvgImageBackEnd()
        );

        $svg = (new Writer($renderer))->writeString($url);

        $svg = ltrim(Str::after($svg, '?>'));

        return view('admin.items.qr', compact('item', 'url', 'svg'));
    }

    public function scan(Item $item): View
    {
        $item->load('lab');

        $loans = $item->loans()
            ->with('user')
            ->where(function ($q) {
                $q->whereDate('start_at', today())
                  ->orWhere('status', 'dipinjam');
            })
            ->orderBy('start_at')
            ->get();

        return view('admin.items.scan', compact('item', 'loans'));
    }
}