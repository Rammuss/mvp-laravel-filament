<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $property->title }} | {{ config('app.name') }}</title>
    <link href="{{ asset('assets/stitch/css/fonts.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="bg-background text-on-background font-body-md">
<main class="py-12 px-6 max-w-container-max mx-auto">
    <div class="mb-8 flex items-center justify-between gap-4">
        <a href="{{ route('properties.index') }}" class="text-primary font-label-md hover:underline">← Volver a propiedades</a>
        <a href="{{ url('/') }}" class="text-slate-500 font-label-md hover:underline">Inicio</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <section class="lg:col-span-2">
            @php
                $images = $property->images;
                $cover = $images->first();
            @endphp

            <div class="bg-white rounded-xl overflow-hidden border border-slate-200">
                <div class="h-[420px] bg-slate-100">
                    @if($cover)
                        <img
                            class="w-full h-full object-cover"
                            src="{{ Storage::url($cover->image_path) }}"
                            alt="{{ $cover->alt_text ?: $property->title }}"
                        />
                    @else
                        <img class="w-full h-full object-cover" src="{{ asset('assets/stitch/images/img02.jpg') }}" alt="Sin imagen" />
                    @endif
                </div>
            </div>

            @if($images->count() > 1)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    @foreach($images as $image)
                        <div class="h-24 rounded-lg overflow-hidden border border-slate-200 bg-slate-100">
                            <img class="w-full h-full object-cover" src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text ?: $property->title }}" />
                        </div>
                    @endforeach
                </div>
            @endif

            <article class="bg-white rounded-xl border border-slate-200 p-6 mt-6">
                <p class="text-secondary font-label-md">{{ $property->city ?: 'Ubicación a confirmar' }}</p>
                <h1 class="font-headline-lg mt-2">{{ $property->title }}</h1>

                <div class="flex flex-wrap gap-4 mt-4 text-on-surface-variant font-label-md">
                    <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">sell</span>{{ strtoupper($property->operation_type) }}</span>
                    <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">home</span>{{ ucfirst($property->property_type) }}</span>
                    @if($property->bedrooms)
                        <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">bed</span>{{ $property->bedrooms }}</span>
                    @endif
                    @if($property->bathrooms)
                        <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">bathtub</span>{{ $property->bathrooms }}</span>
                    @endif
                    @if($property->area_m2)
                        <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">square_foot</span>{{ number_format((float) $property->area_m2, 0, ',', '.') }} m²</span>
                    @endif
                </div>

                @if($property->short_description)
                    <p class="mt-5 text-on-surface-variant">{{ $property->short_description }}</p>
                @endif

                @if($property->long_description)
                    <div class="mt-4 text-on-surface-variant whitespace-pre-line">{{ $property->long_description }}</div>
                @endif
            </article>
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <p class="text-on-surface-variant font-label-md">Precio</p>
                <p class="font-headline-lg text-primary mt-1">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</p>

                @php
                    $waText = rawurlencode("Hola, me interesa la propiedad: {$property->title} ({$property->city}).");
                    $waLink = "https://wa.me/?text={$waText}";
                @endphp

                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="mt-5 w-full inline-flex items-center justify-center bg-[#25D366] text-white px-5 py-3 rounded-lg font-label-md hover:brightness-95 transition-all">
                    Consultar por WhatsApp
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="font-headline-md mb-4">Enviar consulta</h2>

                @if(session('lead_success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                        {{ session('lead_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('properties.leads.store', $property->slug) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block font-label-md text-on-surface-variant mb-2">Nombre *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md" />
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block font-label-md text-on-surface-variant mb-2">Teléfono</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md" />
                        @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block font-label-md text-on-surface-variant mb-2">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md" />
                        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="message" class="block font-label-md text-on-surface-variant mb-2">Mensaje *</label>
                        <textarea id="message" name="message" rows="4" required class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md">{{ old('message', "Hola, me interesa esta propiedad.") }}</textarea>
                        @error('message') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full bg-secondary text-white py-3 rounded-lg font-label-md hover:brightness-90 transition-all">
                        Enviar consulta
                    </button>
                </form>
            </div>
        </aside>
    </div>

    @if($relatedProperties->isNotEmpty())
        <section class="mt-14">
            <h2 class="font-headline-md mb-6">Otras propiedades</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProperties as $related)
                    @php $relatedCover = $related->images->first(); @endphp
                    <article class="bg-white rounded-xl overflow-hidden border border-slate-200">
                        <div class="h-44 bg-slate-100">
                            @if($relatedCover)
                                <img class="w-full h-full object-cover" src="{{ Storage::url($relatedCover->image_path) }}" alt="{{ $relatedCover->alt_text ?: $related->title }}" />
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="text-secondary font-label-md">{{ $related->city }}</p>
                            <h3 class="font-label-md text-lg mt-1">{{ $related->title }}</h3>
                            <p class="text-primary font-headline-md mt-3">{{ $related->currency }} {{ number_format((float) $related->price, 0, ',', '.') }}</p>
                            <a href="{{ route('properties.show', $related->slug) }}" class="inline-block mt-3 text-secondary font-label-md hover:underline">Ver detalle</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</main>
</body>
</html>

