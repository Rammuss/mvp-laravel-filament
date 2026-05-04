<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyLead;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $operation = $request->string('operation')->toString();
        $type = $request->string('type')->toString();
        $city = $request->string('city')->toString();
        $currency = $request->string('currency')->toString();
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        $propertiesQuery = Property::query()
            ->where('is_published', true)
            ->with(['images' => function ($query) {
                $query->orderByDesc('is_cover')->orderBy('sort_order');
            }]);

        if ($operation !== '') {
            $propertiesQuery->where('operation_type', $operation);
        }

        if ($type !== '') {
            $propertiesQuery->where('property_type', $type);
        }

        if ($city !== '') {
            $propertiesQuery->where('city', $city);
        }

        if ($currency !== '') {
            $propertiesQuery->where('currency', $currency);
        }

        if (is_numeric($priceMin)) {
            $propertiesQuery->where('price', '>=', (float) $priceMin);
        }

        if (is_numeric($priceMax)) {
            $propertiesQuery->where('price', '<=', (float) $priceMax);
        }

        $properties = $propertiesQuery
            ->latest('updated_at')
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'operations' => Property::query()
                ->where('is_published', true)
                ->select('operation_type')
                ->distinct()
                ->orderBy('operation_type')
                ->pluck('operation_type'),
            'types' => Property::query()
                ->where('is_published', true)
                ->select('property_type')
                ->distinct()
                ->orderBy('property_type')
                ->pluck('property_type'),
            'cities' => Property::query()
                ->where('is_published', true)
                ->select('city')
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->distinct()
                ->orderBy('city')
                ->pluck('city'),
            'currencies' => Property::query()
                ->where('is_published', true)
                ->select('currency')
                ->whereNotNull('currency')
                ->where('currency', '!=', '')
                ->distinct()
                ->orderBy('currency')
                ->pluck('currency'),
            'filters' => [
                'operation' => $operation,
                'type' => $type,
                'city' => $city,
                'currency' => $currency,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
            ],
        ]);
    }

    public function show(string $slug): View
    {
        $property = Property::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->with(['images' => function ($query) {
                $query->orderByDesc('is_cover')->orderBy('sort_order');
            }])
            ->firstOrFail();

        $relatedProperties = Property::query()
            ->where('is_published', true)
            ->whereKeyNot($property->id)
            ->with(['images' => function ($query) {
                $query->orderByDesc('is_cover')->orderBy('sort_order');
            }])
            ->latest('updated_at')
            ->limit(3)
            ->get();

        return view('properties.show', [
            'property' => $property,
            'relatedProperties' => $relatedProperties,
        ]);
    }

    public function storeLead(Request $request, string $slug): RedirectResponse
    {
        $property = Property::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        PropertyLead::query()->create([
            'property_id' => $property->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return redirect()
            ->route('properties.show', $property->slug)
            ->with('lead_success', 'Consulta enviada. Te contactaremos pronto.');
    }
}
