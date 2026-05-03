<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page?->title ?? config('app.name') }}</title>
    <style>
        :root {
            --bg: #f6f6f8;
            --card: #ffffff;
            --text: #111827;
            --muted: #4b5563;
            --line: #e5e7eb;
            --brand: #d97706;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px 16px 64px;
        }
        .header {
            margin-bottom: 18px;
        }
        .header h1 {
            margin: 0;
            font-size: 36px;
        }
        .section {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
        }
        .section h2 {
            margin: 0 0 8px 0;
            font-size: 28px;
        }
        .section h3 {
            margin: 0 0 12px 0;
            color: var(--brand);
            font-size: 18px;
            font-weight: 600;
        }
        .section p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
            white-space: pre-line;
        }
        .empty {
            background: #fff7ed;
            border: 1px dashed #fdba74;
            color: #9a3412;
            border-radius: 12px;
            padding: 16px;
        }
        .section-title {
            margin: 28px 0 14px;
            font-size: 30px;
        }
        .property-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        .property-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        .property-image {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            background: #e5e7eb;
        }
        .property-content {
            padding: 14px;
        }
        .property-content h3 {
            margin: 0 0 6px 0;
            font-size: 20px;
            color: var(--text);
        }
        .property-meta {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }
        .property-price {
            margin-top: 10px;
            font-size: 18px;
            font-weight: 700;
            color: var(--brand);
        }
    </style>
</head>
<body>
    <main class="wrap">
        <header class="header">
            <h1>{{ $page?->title ?? 'Landing' }}</h1>
        </header>

        @forelse($sections as $section)
            <section class="section" id="{{ $section->section_key }}">
                @if($section->title)
                    <h2>{{ $section->title }}</h2>
                @endif

                @if($section->subtitle)
                    <h3>{{ $section->subtitle }}</h3>
                @endif

                @if($section->body)
                    <p>{{ $section->body }}</p>
                @endif
            </section>
        @empty
            <div class="empty">
                No hay secciones visibles para la pagina <strong>home</strong>.
                Cargalas desde el panel en <strong>Sections</strong>.
            </div>
        @endforelse

        <h2 class="section-title">Propiedades destacadas</h2>
        @if($featuredProperties->isEmpty())
            <div class="empty">
                No hay propiedades destacadas publicadas.
                Marca <strong>is_featured</strong> en Properties para mostrarlas aqui.
            </div>
        @else
            <section class="property-grid">
                @foreach($featuredProperties as $property)
                    @php
                        $cover = $property->images->first();
                    @endphp
                    <article class="property-card">
                        @if($cover)
                            <img
                                class="property-image"
                                src="{{ asset('storage/' . $cover->image_path) }}"
                                alt="{{ $cover->alt_text ?: $property->title }}"
                            >
                        @endif
                        <div class="property-content">
                            <h3>{{ $property->title }}</h3>
                            <p class="property-meta">
                                {{ strtoupper($property->operation_type) }} · {{ ucfirst($property->property_type) }}
                                @if($property->city)
                                    · {{ $property->city }}
                                @endif
                            </p>
                            <p class="property-price">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </section>
        @endif
    </main>
</body>
</html>
