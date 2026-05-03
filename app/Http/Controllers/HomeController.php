<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Property;
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

        $featuredProperties = Property::query()
            ->where('is_published', true)
            ->where('is_featured', true)
            ->with(['images' => function ($query) {
                $query->orderByDesc('is_cover')->orderBy('sort_order');
            }])
            ->latest('updated_at')
            ->limit(6)
            ->get();

        return view('home', [
            'page' => $page,
            'sections' => $page?->sections ?? collect(),
            'featuredProperties' => $featuredProperties,
        ]);
    }
}
