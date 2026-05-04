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
    <div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500">
        <a href="{{ url('/') }}" class="hover:underline">Inicio</a>
        <span>/</span>
        <a href="{{ route('properties.index') }}" class="hover:underline">Propiedades</a>
        <span>/</span>
        <span class="text-slate-700">{{ $property->title }}</span>
    </div>

    <div class="mb-8 flex items-center justify-between gap-4">
        <a href="{{ route('properties.index') }}" class="text-primary font-label-md hover:underline">Volver a propiedades</a>
        <button
            type="button"
            id="copy-link-btn"
            class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm hover:bg-slate-200 transition-all"
            data-url="{{ route('properties.show', $property->slug) }}"
        >
            Copiar link
        </button>
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
                <p class="text-secondary font-label-md">{{ $property->city ?: 'Ubicacion a confirmar' }}</p>
                <h1 class="font-headline-lg mt-2">{{ $property->title }}</h1>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 border-t border-slate-200 pt-5">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Operacion</p>
                        <p class="font-medium text-slate-800">{{ strtoupper($property->operation_type) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Tipo</p>
                        <p class="font-medium text-slate-800">{{ ucfirst($property->property_type) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Ciudad</p>
                        <p class="font-medium text-slate-800">{{ $property->city ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Dormitorios</p>
                        <p class="font-medium text-slate-800">{{ $property->bedrooms ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Banos</p>
                        <p class="font-medium text-slate-800">{{ $property->bathrooms ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Area</p>
                        <p class="font-medium text-slate-800">
                            @if($property->area_m2)
                                {{ number_format((float) $property->area_m2, 0, ',', '.') }} m²
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-span-2 md:col-span-3">
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Direccion</p>
                        <p class="font-medium text-slate-800">{{ $property->address ?: '-' }}</p>
                    </div>
                </div>

                @if($property->short_description)
                    <p class="mt-5 text-on-surface-variant">{{ $property->short_description }}</p>
                @endif

                @if($property->long_description)
                    <div class="mt-4 text-on-surface-variant whitespace-pre-line">{{ $property->long_description }}</div>
                @endif
            </article>

            @php
                $mapQuery = trim(implode(', ', array_filter([$property->address, $property->city])));
                $googleMapsUrl = trim((string) $property->google_maps_url);
                $mapUrl = null;
                $mapEmbed = null;

                if ($googleMapsUrl !== '') {
                    $mapUrl = $googleMapsUrl;

                    if (str_contains($googleMapsUrl, 'output=embed')) {
                        $mapEmbed = $googleMapsUrl;
                    } elseif (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $googleMapsUrl, $matches)) {
                        $coordinates = $matches[1] . ',' . $matches[2];
                        $mapEmbed = 'https://www.google.com/maps?q=' . urlencode($coordinates) . '&output=embed';
                    } else {
                        $mapEmbedQuery = null;
                        $parsedUrl = parse_url($googleMapsUrl);

                        if (!empty($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $params);
                            $mapEmbedQuery = $params['q'] ?? $params['query'] ?? null;
                        }

                        if (!$mapEmbedQuery && str_contains($googleMapsUrl, '/place/')) {
                            $mapEmbedQuery = $googleMapsUrl;
                        }

                        if ($mapEmbedQuery) {
                            $mapEmbed = 'https://www.google.com/maps?q=' . urlencode($mapEmbedQuery) . '&output=embed';
                        }
                    }
                } elseif ($mapQuery !== '') {
                    $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapQuery);
                    $mapEmbed = 'https://www.google.com/maps?q=' . urlencode($mapQuery) . '&output=embed';
                }
            @endphp

            <section class="bg-white rounded-xl border border-slate-200 p-6 mt-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <h2 class="font-headline-md">Ubicacion</h2>
                    @if($mapUrl)
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="text-secondary font-label-md hover:underline">Ver en Google Maps</a>
                    @endif
                </div>

                @if($mapEmbed)
                    <div class="rounded-lg overflow-hidden border border-slate-200">
                        <iframe
                            title="Mapa de ubicacion"
                            src="{{ $mapEmbed }}"
                            width="100%"
                            height="320"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                @else
                    <p class="text-slate-500">No hay ubicacion configurada para esta propiedad.</p>
                @endif
            </section>
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <p class="text-on-surface-variant font-label-md">Precio</p>
                <p class="font-headline-lg text-primary mt-1">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</p>

                @php
                    $waText = rawurlencode("Hola, me interesa la propiedad: {$property->title} ({$property->city}).");
                    $digitsOnly = preg_replace('/\D+/', '', (string) $property->whatsapp_number);
                    $waLink = $digitsOnly ? "https://wa.me/{$digitsOnly}?text={$waText}" : null;
                @endphp

                @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="mt-5 w-full inline-flex items-center justify-center bg-[#25D366] text-white px-5 py-3 rounded-lg font-label-md hover:brightness-95 transition-all">
                        Consultar por WhatsApp
                    </a>
                @else
                    <button type="button" disabled class="mt-5 w-full inline-flex items-center justify-center bg-slate-300 text-slate-600 px-5 py-3 rounded-lg font-label-md cursor-not-allowed">
                        WhatsApp no configurado
                    </button>
                @endif
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
                        <label for="phone" class="block font-label-md text-on-surface-variant mb-2">Telefono</label>
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
<script>
    (function () {
        const copyBtn = document.getElementById('copy-link-btn');
        if (!copyBtn) return;

        copyBtn.addEventListener('click', async () => {
            const url = copyBtn.getAttribute('data-url');
            if (!url) return;

            const originalLabel = copyBtn.textContent;

            try {
                await navigator.clipboard.writeText(url);
                copyBtn.textContent = 'Link copiado';
                setTimeout(() => {
                    copyBtn.textContent = originalLabel;
                }, 1800);
            } catch (e) {
                window.prompt('Copia este link:', url);
            }
        });
    })();
</script>
</body>
</html>
