<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $page = Page::query()
            ->where('slug', 'home')
            ->with(['sections' => function ($query) {
                $query->where('is_visible', true)->orderBy('sort_order');
            }])
            ->first();

        return view('home', [
            'page' => $page,
            'sections' => $page?->sections ?? collect(),
        ]);
    }
}
