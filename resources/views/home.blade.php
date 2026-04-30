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
                No hay secciones visibles para la página <strong>home</strong>.
                Cárgalas desde el panel en <strong>Sections</strong>.
            </div>
        @endforelse
    </main>
</body>
</html>
