<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page?->title ?? config('app.name') }}</title>
    <link href="{{ asset('assets/stitch/css/fonts.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg: #f8f9fa;
            --surface: #ffffff;
            --surface-2: #eef1f4;
            --text: #191c1d;
            --muted: #44474d;
            --brand: #0a1d37;
            --gold: #c79a4a;
            --line: #dbe1e7;
            --ok: #25d366;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            width: min(1240px, 92%);
            margin: 0 auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
        }

        .topbar-inner {
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            color: var(--brand);
            font-weight: 800;
            font-size: 24px;
            text-decoration: none;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .top-links {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .top-links a {
            text-decoration: none;
            color: var(--muted);
            font-weight: 600;
            font-size: 14px;
        }

        .top-cta {
            text-decoration: none;
            background: var(--brand);
            color: #fff;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 700;
            font-size: 14px;
        }

        .hero {
            min-height: 620px;
            position: relative;
            display: grid;
            align-items: center;
            overflow: hidden;
            background:
                radial-gradient(1200px 400px at 80% 90%, rgba(199,154,74,.22), transparent 55%),
                linear-gradient(120deg, #071528 0%, #102846 56%, #1f3f66 100%),
                url('{{ asset('assets/stitch/images/img01.jpg') }}') center/cover no-repeat;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(7, 21, 40, .76) 0%, rgba(7, 21, 40, .28) 55%, rgba(7, 21, 40, .14) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: #fff;
            max-width: 760px;
            padding: 42px 0;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(34px, 5.5vw, 56px);
            line-height: 1.05;
            letter-spacing: -.02em;
        }

        .hero p {
            margin: 18px 0 0;
            color: #d7e4f6;
            font-size: 18px;
            line-height: 1.65;
            max-width: 64ch;
            white-space: pre-line;
        }

        .hero-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .btn {
            text-decoration: none;
            border-radius: 12px;
            padding: 13px 20px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-gold {
            background: var(--gold);
            color: #241400;
        }

        .btn-dark {
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.1);
            color: #fff;
        }

        .section {
            padding: 78px 0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            margin-bottom: 24px;
        }

        .section-header .eyebrow {
            display: block;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: var(--gold);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .section-header h2 {
            margin: 0;
            color: var(--brand);
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.15;
        }

        .section-header a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(10, 29, 55, .06);
        }

        .card-image {
            height: 210px;
            background: var(--surface-2);
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card-body {
            padding: 16px;
        }

        .card-body h3 {
            margin: 0;
            font-size: 34px;
            font-size: 32px;
            font-size: 30px;
            font-size: 28px;
            font-size: 26px;
            font-size: 24px;
            line-height: 1.2;
            color: var(--brand);
        }

        .meta {
            margin-top: 8px;
            color: var(--muted);
            font-size: 14px;
        }

        .price {
            margin-top: 10px;
            color: #d97706;
            font-weight: 800;
            font-size: 30px;
            font-size: 22px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
        }

        .panel h3 {
            margin: 0 0 8px;
            color: var(--brand);
            font-size: 22px;
        }

        .panel p {
            margin: 0;
            color: var(--muted);
            line-height: 1.62;
            white-space: pre-line;
        }

        .services {
            background: #f1f4f7;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .service-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 20px;
        }

        .service-card h4 {
            margin: 0 0 8px;
            color: var(--brand);
            font-size: 22px;
            font-size: 20px;
        }

        .service-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.58;
            font-size: 14px;
            white-space: pre-line;
        }

        .cta-final {
            background: linear-gradient(160deg, #ffffff 0%, #f6f8fb 55%, #eef3f9 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 34px;
            text-align: center;
        }

        .cta-final h2 {
            margin: 0;
            color: var(--brand);
            font-size: clamp(28px, 4vw, 46px);
            line-height: 1.15;
        }

        .cta-final p {
            margin: 12px auto 0;
            max-width: 64ch;
            color: var(--muted);
            line-height: 1.62;
            white-space: pre-line;
        }

        .cta-buttons {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-wa {
            background: var(--ok);
            color: #fff;
        }

        footer {
            margin-top: 60px;
            padding: 28px 0 42px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 14px;
        }

        @media (max-width: 1040px) {
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .top-links { display: none; }
            .cards { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .service-grid { grid-template-columns: 1fr; }
            .hero { min-height: 540px; }
        }
    </style>
</head>
<body>
@php
    $hero = $sections->firstWhere('section_key', 'hero');
    $about = $sections->firstWhere('section_key', 'about');
    $services = $sections->firstWhere('section_key', 'service');
    $contact = $sections->firstWhere('section_key', 'contact');
@endphp

<header class="topbar">
    <div class="container topbar-inner">
        <a class="brand" href="/">{{ $page?->title ?? 'LuxuryEstate' }}</a>
        <nav class="top-links">
            <a href="#destacadas">Propiedades</a>
            <a href="#servicios">Servicios</a>
            <a href="#about">Nosotros</a>
        </nav>
        <a class="top-cta" href="#contact">Contactar</a>
    </div>
</header>

<section class="hero" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1>{{ $hero?->title ?? 'Tu proximo hogar comienza aqui' }}</h1>
            <p>{{ $hero?->body ?? 'Expertos en encontrar el espacio perfecto para ti con asesoria personalizada y propiedades destacadas.' }}</p>
            <div class="hero-buttons">
                <a class="btn btn-gold" href="#destacadas">Ver propiedades</a>
                <a class="btn btn-dark" href="#contact">Contactar asesor</a>
            </div>
        </div>
    </div>
</section>

<main class="container">
    <section class="section" id="destacadas">
        <div class="section-header">
            <div>
                <span class="eyebrow">Descubre lo mejor</span>
                <h2>Propiedades destacadas</h2>
            </div>
            <a href="#">Ver todas</a>
        </div>

        @if($featuredProperties->isEmpty())
            <div class="panel">
                <h3>Sin propiedades destacadas</h3>
                <p>Marca propiedades como destacadas en el panel para verlas aqui.</p>
            </div>
        @else
            <div class="cards">
                @foreach($featuredProperties as $property)
                    @php $cover = $property->images->first(); @endphp
                    <article class="card">
                        <div class="card-image">
                            @if($cover)
                                <img src="{{ Storage::url($cover->image_path) }}" alt="{{ $cover->alt_text ?: $property->title }}">
                            @endif
                        </div>
                        <div class="card-body">
                            <h3>{{ $property->title }}</h3>
                            <p class="meta">{{ strtoupper($property->operation_type) }} - {{ ucfirst($property->property_type) }} @if($property->city) - {{ $property->city }} @endif</p>
                            <p class="price">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="section services" id="servicios">
        <div class="section-header">
            <div>
                <h2>{{ $services?->title ?? 'Nuestros servicios' }}</h2>
            </div>
        </div>

        <div class="service-grid">
            <article class="service-card">
                <h4>Compra</h4>
                <p>{{ $services?->body ?? 'Acompanamiento integral para encontrar y comprar la propiedad correcta.' }}</p>
            </article>
            <article class="service-card">
                <h4>Venta</h4>
                <p>Posicionamos tu propiedad para vender al mejor precio y en el menor tiempo posible.</p>
            </article>
            <article class="service-card">
                <h4>Alquiler</h4>
                <p>Gestion operativa y comercial para propietarios e inquilinos con procesos claros.</p>
            </article>
            <article class="service-card">
                <h4>Asesoria</h4>
                <p>Soporte legal y comercial en cada etapa de la operacion inmobiliaria.</p>
            </article>
        </div>
    </section>

    <section class="section" id="about">
        <div class="grid-2">
            <article class="panel">
                <h3>{{ $about?->title ?? 'Compromiso con la excelencia' }}</h3>
                <p>{{ $about?->body ?? 'Trabajamos con transparencia, experiencia y foco en resultados para cada cliente.' }}</p>
            </article>
            <article class="panel">
                <img src="{{ asset('assets/stitch/images/img08.jpg') }}" alt="" style="width:100%;height:220px;object-fit:cover;border-radius:10px;margin-bottom:12px;">
                <h3>{{ $contact?->title ?? 'Contacto directo' }}</h3>
                <p>{{ $contact?->body ?? 'Escribinos para coordinar una visita o recibir asesoramiento personalizado.' }}</p>
            </article>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="cta-final">
            <h2>{{ $contact?->subtitle ?? 'Agenda una visita hoy' }}</h2>
            <p>{{ $contact?->body ?? 'Nuestro equipo esta listo para ayudarte a encontrar la propiedad ideal.' }}</p>
            <div class="cta-buttons">
                <a class="btn btn-wa" href="#">WhatsApp</a>
                <a class="btn btn-gold" href="#destacadas">Ver destacadas</a>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        {{ $page?->title ?? 'LuxuryEstate' }} - Diseno adaptado y contenido autogestionable.
    </div>
</footer>
</body>
</html>
