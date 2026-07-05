<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShortLinkRedirectController extends Controller
{
    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $link = Link::query()
            ->where('code', $code)
            ->firstOrFail();

        $link->clicks()->create([
            'ip_address' => $request->ip(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }
}
