<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Propiedades | {{ config('app.name') }}</title>
    <link href="{{ asset('assets/stitch/css/fonts.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="bg-background text-on-background font-body-md">
<main class="py-16 px-6 max-w-container-max mx-auto">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
        <div>
            <span class="text-secondary font-label-md uppercase tracking-widest">Catálogo</span>
            <h1 class="font-headline-lg mt-2">Todas las propiedades</h1>
        </div>
        <a href="{{ url('/') }}" class="text-primary font-label-md hover:underline">Volver al inicio</a>
    </div>

    <form method="GET" action="{{ route('properties.index') }}" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 grid grid-cols-1 md:grid-cols-6 gap-4 mb-10">
        <div>
            <label for="operation" class="block font-label-md text-on-surface-variant mb-2">Operación</label>
            <select id="operation" name="operation" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md">
                <option value="">Todas</option>
                @foreach($operations as $op)
                    <option value="{{ $op }}" @selected($filters['operation'] === $op)>{{ strtoupper($op) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="type" class="block font-label-md text-on-surface-variant mb-2">Tipo</label>
            <select id="type" name="type" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md">
                <option value="">Todos</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" @selected($filters['type'] === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="city" class="block font-label-md text-on-surface-variant mb-2">Ciudad</label>
            <select id="city" name="city" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md">
                <option value="">Todas</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" @selected($filters['city'] === $city)>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="currency" class="block font-label-md text-on-surface-variant mb-2">Moneda</label>
            <select id="currency" name="currency" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md">
                <option value="">Todas</option>
                @foreach($currencies as $currency)
                    <option value="{{ $currency }}" @selected($filters['currency'] === $currency)>{{ $currency }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="price_min" class="block font-label-md text-on-surface-variant mb-2">Precio mínimo</label>
            <input id="price_min" name="price_min" value="{{ $filters['price_min'] }}" type="number" step="1" min="0" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md" />
        </div>

        <div>
            <label for="price_max" class="block font-label-md text-on-surface-variant mb-2">Precio máximo</label>
            <input id="price_max" name="price_max" value="{{ $filters['price_max'] }}" type="number" step="1" min="0" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md" />
        </div>

        <div class="md:col-span-6 flex flex-wrap gap-3 pt-2">
            <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-lg font-label-md hover:brightness-90 transition-all">Filtrar</button>
            <a href="{{ route('properties.index') }}" class="bg-slate-100 text-slate-700 px-6 py-3 rounded-lg font-label-md hover:bg-slate-200 transition-all">Limpiar</a>
        </div>
    </form>

    @if($properties->isEmpty())
        <div class="bg-white rounded-xl p-8 border border-slate-200">
            <p class="text-on-surface-variant">No se encontraron propiedades con esos filtros.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($properties as $property)
                @php
                    $cover = $property->images->first();
                @endphp
                <article class="bg-white rounded-xl overflow-hidden property-card-shadow hover:-translate-y-1 transition-transform duration-300">
                    <div class="h-56 overflow-hidden relative">
                        @if($cover)
                            <img
                                class="w-full h-full object-cover"
                                src="{{ Storage::url($cover->image_path) }}"
                                alt="{{ $cover->alt_text ?: $property->title }}"
                            />
                        @else
                            <img class="w-full h-full object-cover" src="{{ asset('assets/stitch/images/img02.jpg') }}" alt="Sin imagen" />
                        @endif
                        @if($property->is_featured)
                            <div class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">DESTACADO</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-secondary font-label-md">{{ $property->city ?: 'Ubicación a confirmar' }}</p>
                        <h2 class="font-headline-md my-2">{{ $property->title }}</h2>
                        <div class="flex flex-wrap items-center gap-4 text-on-surface-variant font-label-sm mb-4">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">sell</span>
                                {{ strtoupper($property->operation_type) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">home</span>
                                {{ ucfirst($property->property_type) }}
                            </span>
                            @if($property->area_m2)
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">square_foot</span>
                                    {{ number_format((float) $property->area_m2, 0, ',', '.') }} m²
                                </span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center border-t border-surface-container pt-4">
                            <span class="font-headline-md text-primary">
                                {{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}
                            </span>
                            <span class="text-secondary font-label-md">Próximamente</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $properties->links() }}
        </div>
    @endif
</main>
</body>
</html>

