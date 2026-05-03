<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $page?->title ?? 'LuxuryEstate' }}</title>
    <link href="{{ asset('assets/stitch/css/fonts.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="bg-background text-on-background font-body-md">
<header class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm">
    <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-full">
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-slate-900" data-icon="menu">menu</span>
            <span class="text-xl font-bold text-slate-900 uppercase tracking-wider font-inter font-semibold tracking-tight">LuxuryEstate</span>
        </div>
        <nav class="hidden md:flex gap-8 items-center">
            <a class="text-slate-900 font-bold border-b-2 border-amber-500 hover:text-amber-600 transition-colors" href="#destacadas">Propiedades</a>
            <a class="text-slate-500 font-medium hover:text-amber-600 transition-colors" href="#servicios">Servicios</a>
            <a class="text-slate-500 font-medium hover:text-amber-600 transition-colors" href="#nosotros">Nosotros</a>
        </nav>
        <a href="#contacto" class="bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md active:scale-95 transition-transform duration-150">Contactar</a>
    </div>
</header>

<main class="pt-16">
    <section class="relative h-[707px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img alt="Hero" class="w-full h-full object-cover" src="{{ asset('assets/stitch/images/img01.jpg') }}" />
            <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-transparent"></div>
        </div>
        <div class="relative z-10 px-6 md:px-16 max-w-4xl">
            <h1 class="font-headline-xl text-white mb-4">Tu próximo hogar comienza aquí</h1>
            <p class="font-body-lg text-white/90 mb-10 max-w-xl">Expertos en encontrar el espacio perfecto para ti. Brindamos asesoría personalizada y acceso a las propiedades más exclusivas del mercado.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('properties.index') }}" class="bg-secondary-container text-on-secondary-container px-8 py-4 rounded-xl font-headline-md hover:brightness-110 transition-all">Ver propiedades</a>
                <a href="#contacto" class="bg-white/10 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-headline-md hover:bg-white/20 transition-all">Contactar asesor</a>
            </div>
        </div>
    </section>

    <section class="relative z-20 -mt-16 px-6 max-w-container-max mx-auto">
        <div class="bg-white p-8 rounded-xl shadow-xl grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label class="block font-label-md text-on-surface-variant mb-2">Tipo</label>
                <select class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                    <option>Casa</option>
                    <option>Terreno</option>
                    <option>Alquiler</option>
                </select>
            </div>
            <div>
                <label class="block font-label-md text-on-surface-variant mb-2">Zona / Ciudad</label>
                <input class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md focus:ring-2 focus:ring-primary focus:border-transparent outline-none" placeholder="Ej. Palermo, Nordelta" type="text" />
            </div>
            <div>
                <label class="block font-label-md text-on-surface-variant mb-2">Rango de precio</label>
                <select class="w-full p-3 bg-surface-container border border-outline-variant rounded-lg font-body-md focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                    <option>Hasta USD 200,000</option>
                    <option>USD 200,000 - 500,000</option>
                    <option>Más de USD 500,000</option>
                </select>
            </div>
            <button class="w-full bg-secondary text-white py-4 rounded-lg font-headline-md hover:brightness-90 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined" data-icon="search">search</span>
                Buscar
            </button>
        </div>
    </section>

    <section id="destacadas" class="py-24 px-6 max-w-container-max mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <span class="text-secondary font-label-md uppercase tracking-widest">Descubre lo mejor</span>
                <h2 class="font-headline-lg mt-2">Propiedades Destacadas</h2>
            </div>
            <a class="text-primary font-label-md flex items-center gap-2 hover:underline" href="{{ route('properties.index') }}">Ver todas las propiedades <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span></a>
        </div>

        @if($featuredProperties->isEmpty())
            <div class="bg-white rounded-xl p-8 border border-slate-200">
                <p class="text-on-surface-variant">No hay propiedades destacadas todavía.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProperties as $property)
                    @php
                        $cover = $property->images->first();
                    @endphp
                    <div class="bg-white rounded-xl overflow-hidden property-card-shadow hover:-translate-y-2 transition-transform duration-300">
                        <div class="h-48 overflow-hidden relative">
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
                            <h3 class="font-headline-md my-2">{{ $property->title }}</h3>
                            <div class="flex items-center gap-4 text-on-surface-variant font-label-sm mb-4">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">sell</span> {{ strtoupper($property->operation_type) }}</span>
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">home</span> {{ ucfirst($property->property_type) }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-surface-container pt-4">
                                <span class="font-headline-md text-primary">{{ $property->currency }} {{ number_format((float) $property->price, 0, ',', '.') }}</span>
                                <button class="text-secondary font-label-md hover:underline">Ver detalle</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section id="servicios" class="bg-surface-container-low py-24 px-6">
        <div class="max-w-container-max mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-headline-lg">Nuestros Servicios</h2>
                <p class="text-on-surface-variant font-body-md mt-4 max-w-2xl mx-auto">Te acompañamos en cada paso del camino, brindando soluciones integrales para todas tus necesidades inmobiliarias.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-xl text-center property-card-shadow">
                    <div class="w-16 h-16 bg-primary-fixed flex items-center justify-center rounded-full mx-auto mb-6"><span class="material-symbols-outlined text-primary text-3xl">home</span></div>
                    <h3 class="font-headline-md mb-3">Compra</h3>
                    <p class="text-on-surface-variant text-sm">Encontramos el hogar de tus sueños con la mejor asesoría del mercado.</p>
                </div>
                <div class="bg-white p-8 rounded-xl text-center property-card-shadow">
                    <div class="w-16 h-16 bg-secondary-fixed flex items-center justify-center rounded-full mx-auto mb-6"><span class="material-symbols-outlined text-secondary text-3xl">sell</span></div>
                    <h3 class="font-headline-md mb-3">Venta</h3>
                    <p class="text-on-surface-variant text-sm">Maximizamos el valor de tu propiedad con estrategias de marketing premium.</p>
                </div>
                <div class="bg-white p-8 rounded-xl text-center property-card-shadow">
                    <div class="w-16 h-16 bg-tertiary-fixed flex items-center justify-center rounded-full mx-auto mb-6"><span class="material-symbols-outlined text-on-tertiary-fixed-variant text-3xl">key</span></div>
                    <h3 class="font-headline-md mb-3">Alquiler</h3>
                    <p class="text-on-surface-variant text-sm">Gestión eficiente de contratos para propietarios e inquilinos exigentes.</p>
                </div>
                <div class="bg-white p-8 rounded-xl text-center property-card-shadow">
                    <div class="w-16 h-16 bg-error-container flex items-center justify-center rounded-full mx-auto mb-6"><span class="material-symbols-outlined text-error text-3xl">gavel</span></div>
                    <h3 class="font-headline-md mb-3">Asesoría Legal</h3>
                    <p class="text-on-surface-variant text-sm">Seguridad jurídica en cada transacción con nuestro equipo legal experto.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="nosotros" class="py-24 px-6 max-w-container-max mx-auto">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="lg:w-1/2">
                <span class="text-secondary font-label-md uppercase tracking-widest">Nuestra esencia</span>
                <h2 class="font-headline-lg mt-2 mb-6">Compromiso con la Excelencia y la Transparencia</h2>
                <p class="text-on-surface-variant font-body-md mb-10">Llevamos más de 15 años transformando la industria inmobiliaria, enfocándonos en lo que realmente importa: la confianza de nuestros clientes.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="flex gap-4"><span class="material-symbols-outlined text-secondary text-4xl">verified_user</span><div><h4 class="font-label-md text-primary mb-1">Confianza</h4><p class="text-xs text-on-surface-variant">Transacciones seguras y transparentes garantizadas.</p></div></div>
                    <div class="flex gap-4"><span class="material-symbols-outlined text-secondary text-4xl">workspace_premium</span><div><h4 class="font-label-md text-primary mb-1">Experiencia</h4><p class="text-xs text-on-surface-variant">Décadas de conocimiento profundo en el mercado local.</p></div></div>
                    <div class="flex gap-4"><span class="material-symbols-outlined text-secondary text-4xl">handshake</span><div><h4 class="font-label-md text-primary mb-1">Acompañamiento</h4><p class="text-xs text-on-surface-variant">Estamos contigo desde la primera visita hasta la firma.</p></div></div>
                    <div class="flex gap-4"><span class="material-symbols-outlined text-secondary text-4xl">visibility</span><div><h4 class="font-label-md text-primary mb-1">Transparencia</h4><p class="text-xs text-on-surface-variant">Información clara y sin letra chica en todo momento.</p></div></div>
                </div>
            </div>
            <div class="lg:w-1/2 relative">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-secondary-container rounded-xl -z-10"></div>
                <img alt="Equipo" class="rounded-xl shadow-2xl relative z-10 w-full" src="{{ asset('assets/stitch/images/img07.jpg') }}" />
            </div>
        </div>
    </section>

    <section class="bg-primary text-white py-24 px-6">
        <div class="max-w-container-max mx-auto text-center mb-16">
            <h2 class="font-headline-lg">Lo que dicen nuestros clientes</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-4xl mx-auto">
            <div class="bg-white/5 border border-white/10 p-10 rounded-2xl relative">
                <span class="material-symbols-outlined text-secondary-container text-5xl absolute -top-4 -left-4 bg-primary">format_quote</span>
                <p class="font-body-md italic mb-8">"Encontrar mi departamento en Palermo fue un proceso sencillo gracias a LuxuryEstate. La transparencia y el trato personalizado marcaron la diferencia."</p>
                <div class="flex items-center gap-4"><div class="w-12 h-12 rounded-full bg-surface-container-high overflow-hidden"><img alt="Cliente" class="w-full h-full object-cover" src="{{ asset('assets/stitch/images/img03.jpg') }}" /></div><div><p class="font-label-md">María González</p><p class="text-xs text-white/60">Propietaria en Palermo</p></div></div>
            </div>
            <div class="bg-white/5 border border-white/10 p-10 rounded-2xl relative">
                <span class="material-symbols-outlined text-secondary-container text-5xl absolute -top-4 -left-4 bg-primary">format_quote</span>
                <p class="font-body-md italic mb-8">"Vendí mi casa en tiempo récord. El marketing que realizaron fue impecable y las fotos parecían de revista."</p>
                <div class="flex items-center gap-4"><div class="w-12 h-12 rounded-full bg-surface-container-high overflow-hidden"><img alt="Cliente" class="w-full h-full object-cover" src="{{ asset('assets/stitch/images/img04.jpg') }}" /></div><div><p class="font-label-md">Ricardo Martínez</p><p class="text-xs text-white/60">Inversor inmobiliario</p></div></div>
            </div>
        </div>
    </section>

    <section id="contacto" class="py-24 px-6">
        <div class="max-w-4xl mx-auto bg-surface-container rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary-fixed opacity-30 rounded-full blur-3xl"></div>
            <h2 class="font-headline-xl text-primary mb-6">Agenda una visita hoy</h2>
            <p class="font-body-lg text-on-surface-variant mb-10 max-w-lg mx-auto">Nuestros asesores están listos para mostrarte tu próximo hogar. ¡Comienza hoy el cambio que buscas!</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a class="bg-[#25D366] text-white px-10 py-5 rounded-full font-headline-md flex items-center justify-center gap-3 hover:shadow-lg hover:scale-105 transition-all" href="#">WhatsApp</a>
                <a class="bg-primary text-white px-10 py-5 rounded-full font-headline-md hover:brightness-125 transition-all" href="#">Ver contacto completo</a>
            </div>
        </div>
    </section>
</main>

<footer class="w-full py-12 px-6 md:px-16 bg-slate-50 border-t border-slate-200">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
        <div class="flex flex-col gap-4">
            <span class="text-lg font-black text-slate-900 uppercase tracking-wider">LuxuryEstate</span>
            <p class="text-sm font-inter leading-relaxed text-slate-600">Líderes en el mercado inmobiliario de alta gama, conectando personas con espacios extraordinarios desde hace más de una década.</p>
        </div>
        <div class="flex flex-col gap-4">
            <h4 class="font-bold text-slate-900">Enlaces rápidos</h4>
            <div class="flex flex-col gap-2">
                <a class="text-amber-600 font-semibold hover:underline transition-all" href="#destacadas">Propiedades</a>
                <a class="text-slate-600 hover:underline hover:text-slate-900 transition-all" href="#servicios">Servicios</a>
                <a class="text-slate-600 hover:underline hover:text-slate-900 transition-all" href="#nosotros">Nosotros</a>
                <a class="text-slate-600 hover:underline hover:text-slate-900 transition-all" href="#">Privacidad</a>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <h4 class="font-bold text-slate-900">Newsletter</h4>
            <p class="text-sm text-slate-600">Suscríbete para recibir las últimas oportunidades exclusivas.</p>
            <div class="flex gap-2">
                <input class="bg-white border border-slate-200 rounded px-4 py-2 text-sm w-full outline-none focus:border-amber-500" placeholder="Tu email" type="email" />
                <button class="bg-primary text-white px-4 py-2 rounded text-sm font-bold">Unirse</button>
            </div>
        </div>
    </div>
    <div class="mt-12 pt-8 border-t border-slate-200 text-center">
        <p class="text-sm font-inter leading-relaxed text-slate-600 opacity-80">© 2026 LuxuryEstate. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
