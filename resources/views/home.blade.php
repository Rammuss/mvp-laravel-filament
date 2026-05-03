<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page?->title ?? config('app.name') }}</title>
    <style>
        :root {
            --bg: #f8f9fa;
            --surface: #ffffff;
            --surface-soft: #eef1f4;
            --text: #0f172a;
            --muted: #475569;
            --brand: #0a1d37;
            --accent: #c58b2d;
            --line: #dbe2ea;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Tahoma, sans-serif;
            color: var(--text);
            background: var(--bg);
        }

        .container {
            width: min(1200px, 92%);
            margin-inline: auto;
        }

        .nav {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
            background: color-mix(in oklab, white 85%, transparent);
            border-bottom: 1px solid var(--line);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 68px;
            gap: 16px;
        }

        .brand {
            font-weight: 800;
            font-size: 22px;
            color: var(--brand);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 600;
            font-size: 14px;
        }

        .hero {
            padding: 72px 0 44px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 24px;
            align-items: stretch;
        }

        .hero-card {
            background: linear-gradient(135deg, #0a1d37 0%, #10294d 60%, #17335b 100%);
            color: white;
            border-radius: 18px;
            padding: 34px;
            border: 1px solid #1c3f70;
            box-shadow: 0 18px 40px rgba(10, 29, 55, .18);
        }

        .hero-card h1 {
            margin: 0;
            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.05;
            letter-spacing: -.02em;
        }

        .hero-card p {
            margin: 14px 0 0;
            color: #dbe7f9;
            max-width: 58ch;
            line-height: 1.6;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--accent);
            color: #1d1300;
        }

        .btn-ghost {
            background: transparent;
            color: #e2e8f0;
            border-color: #395780;
        }

        .hero-side {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 20px;
        }

        .hero-side h3 {
            margin: 0 0 8px;
            font-size: 18px;
            color: var(--brand);
        }

        .hero-side p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
            white-space: pre-line;
        }

        .section {
            padding: 14px 0 30px;
        }

        .section h2 {
            font-size: 34px;
            margin: 0 0 18px;
            color: var(--brand);
        }

        .property-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }

        .property-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(10, 29, 55, .05);
        }

        .property-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
            background: var(--surface-soft);
        }

        .property-content {
            padding: 16px;
        }

        .property-content h3 {
            margin: 0 0 8px;
            font-size: 34px;
            font-size: 24px;
            line-height: 1.15;
        }

        .property-meta {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .property-price {
            margin-top: 10px;
            font-size: 30px;
            font-size: 18px;
            font-weight: 800;
            color: var(--accent);
        }

        .simple-blocks {
            display: grid;
            gap: 14px;
        }

        .simple-block {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
        }

        .simple-block h3 {
            margin: 0 0 8px;
            color: var(--brand);
            font-size: 24px;
            font-size: 21px;
        }

        .simple-block p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
            white-space: pre-line;
        }

        .footer {
            border-top: 1px solid var(--line);
            margin-top: 36px;
            padding: 24px 0 40px;
            color: var(--muted);
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
@php
    $hero = $sections->firstWhere('section_key', 'hero');
    $about = $sections->firstWhere('section_key', 'about');
    $contact = $sections->firstWhere('section_key', 'contact');
    $otherSections = $sections->filter(fn ($section) => ! in_array($section->section_key, ['hero', 'about', 'contact'], true));
@endphp

<nav class="nav">
    <div class="container nav-inner">
        <a href="/" class="brand">{{ $page?->title ?? 'Inmo' }}</a>
        <div class="nav-links">
            <a href="#destacadas">Destacadas</a>
            @if($about)<a href="#about">Nosotros</a>@endif
            @if($contact)<a href="#contact">Contacto</a>@endif
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container hero-grid">
        <section class="hero-card" id="hero">
            <h1>{{ $hero?->title ?? 'Propiedades premium para vivir e invertir' }}</h1>
            <p>{{ $hero?->body ?? 'Explora una seleccion de propiedades destacadas con ubicaciones estrategicas y acompanamiento profesional en cada paso.' }}</p>
            <div class="cta-row">
                <a class="btn btn-primary" href="#destacadas">Ver destacadas</a>
                <a class="btn btn-ghost" href="/admin">Panel admin</a>
            </div>
        </section>

        <aside class="hero-side">
            <h3>{{ $hero?->subtitle ?? 'Asesoria inmobiliaria confiable' }}</h3>
            <p>
                {{ $about?->body ?? 'Gestiona propiedades, destacadas y contenido desde un solo panel autogestionable.' }}
            </p>
        </aside>
    </div>
</header>

<main class="container">
    <section class="section" id="destacadas">
        <h2>Propiedades destacadas</h2>
        @if($featuredProperties->isEmpty())
            <div class="simple-block">
                <h3>Sin destacadas por ahora</h3>
                <p>Marca propiedades como destacadas en el panel para mostrarlas aqui.</p>
            </div>
        @else
            <div class="property-grid">
                @foreach($featuredProperties as $property)
                    @php $cover = $property->images->first(); @endphp
                    <article class="property-card">
                        @if($cover)
                            <img class="property-image" src="{{ Storage::url($cover->image_path) }}" alt="{{ $cover->alt_text ?: $property->title }}">
                        @endif
                        <div class="property-content">
                            <h3>{{ $property->title }}</h3>
                            <p class="property-meta">
                                {{ strtoupper($property->operation_type) }} - {{ ucfirst($property->property_type) }}
                                @if($property->city) - {{ $property->city }} @endif
                            </p>
                            <p class="property-price">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    @if($otherSections->isNotEmpty())
        <section class="section">
            <h2>Mas informacion</h2>
            <div class="simple-blocks">
                @foreach($otherSections as $section)
                    <article class="simple-block" id="{{ $section->section_key }}">
                        <h3>{{ $section->title ?: ucfirst($section->section_key) }}</h3>
                        @if($section->subtitle)
                            <p><strong>{{ $section->subtitle }}</strong></p>
                        @endif
                        @if($section->body)
                            <p>{{ $section->body }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if($about)
        <section class="section" id="about">
            <h2>{{ $about->title ?: 'Sobre nosotros' }}</h2>
            <div class="simple-block">
                @if($about->subtitle)
                    <h3>{{ $about->subtitle }}</h3>
                @endif
                <p>{{ $about->body }}</p>
            </div>
        </section>
    @endif

    @if($contact)
        <section class="section" id="contact">
            <h2>{{ $contact->title ?: 'Contacto' }}</h2>
            <div class="simple-block">
                @if($contact->subtitle)
                    <h3>{{ $contact->subtitle }}</h3>
                @endif
                <p>{{ $contact->body }}</p>
            </div>
        </section>
    @endif
</main>

<footer class="footer">
    <div class="container">
        {{ $page?->title ?? 'Inmo' }} - Panel autogestionable activo.
    </div>
</footer>
</body>
</html>
