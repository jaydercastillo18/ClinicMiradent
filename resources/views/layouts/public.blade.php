<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ $publicAssets->favicon }}">
    <title>@yield('title', 'Clínica Dental Miradent | Sonrisas que Transforman Vidas - Chimbote')</title>
    <meta name="description" content="Clínica Dental Miradent en Chimbote. Tratamientos de ortodoncia, blanqueamiento, implantes, limpiezas y estética dental. Agenda tu cita hoy mismo.">
    <meta name="keywords" content="dentista chimbote, clínica dental chimbote, ortodoncia chimbote, implantes dentales, blanqueamiento dental">

    <script src="https://unpkg.com/lucide@latest" defer fetchpriority="low"></script>
    @vite('resources/css/app.css')

    @yield('styles')

    <style>
        /* Transiciones suaves entre páginas (Chrome/Edge). Se ignora en navegadores
           sin soporte y se desactiva si el usuario prefiere menos movimiento. */
        @media (prefers-reduced-motion: no-preference) {
            @view-transition {
                navigation: auto;
            }
        }

        /* El navbar persiste visualmente entre páginas en vez de parpadear */
        .nav-premium {
            view-transition-name: site-navbar;
        }

        /* ESTILOS GLOBALES PREMIUM (NAV, FOOTER, MODAL) */
        :root {
            --jade-50: #f4fffb;
            --jade-100: #dff8f1;
            --jade-600: #00a884;
            --jade-700: #00846a;
            --jade-800: #006b55;
            --jade-900: #005644;
            --jade-950: #003f32;
        }

        .container-premium {
            width: min(1200px, calc(100% - 40px));
            margin: 0 auto;
        }

        /* NAVEGACIÓN */
        .nav-premium {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 84, 66, 0.08);
            z-index: 50;
            transition: all 0.3s ease;
        }

        .nav-premium.scrolled {
            box-shadow: 0 10px 30px rgba(0, 84, 66, 0.05);
            padding: 4px 0;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 24px;
            height: 78px;
        }

        /* Hacer el menú más amplio que el contenido normal */
        .nav-premium .container-premium {
            width: min(1880px, calc(100% - 32px));
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
        }

        .nav-logo span {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--jade-950);
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: none;
            list-style: none;
            gap: 18px;
            /* Reducido de 32px a 20px */
            margin: 0;
            padding: 0;
        }

        @media (min-width: 1150px) {

            /* Aumentado a 1150px para que se haga hamburguesa antes en laptops pequeñas */
            .nav-links {
                display: flex;
                gap: 22px;
                margin-left: auto;
            }

            .nav-actions {
                margin-left: 4px;
            }

            .nav-hamburger {
                display: none;
            }
        }

        .nav-links a {
            color: #475569;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.82rem;
            /* Ligeramente más pequeño */
            transition: all 0.3s ease;
            position: relative;
            padding: 7px 0;
            letter-spacing: 0;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--jade-600);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .nav-links a:hover {
            color: var(--jade-700);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a.active {
            color: var(--jade-800);
            font-weight: 800;
        }

        .nav-actions {
            margin-left: auto;
        }

        @media (min-width: 1150px) {
            .nav-actions {
                margin-left: 16px;
            }
        }

        .nav-cta {
            display: none; /* Hide on mobile to prevent overflow */
            align-items: center;
            gap: 8px;
            background: var(--jade-600);
            color: #fff;
            padding: 12px 26px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(0, 168, 132, 0.25);
            border: 2px solid transparent;
        }

        @media (min-width: 768px) {
            .nav-cta {
                display: inline-flex;
            }
        }

        .nav-cta:hover {
            background: var(--jade-700);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 168, 132, 0.35);
        }

        .nav-hamburger {
            background: none;
            border: none;
            color: var(--jade-900);
            cursor: pointer;
            padding: 8px;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 16px;
            padding: 20px;
            background: #fff;
            border-top: 1px solid rgba(0, 84, 66, 0.08);
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu a {
            color: var(--jade-900);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* PIE DE PÁGINA */
        .footer-premium {
            background: var(--jade-950);
            color: rgba(255, 255, 255, 0.7);
            padding: 100px 0 40px;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .footer-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--jade-600), var(--jade-400), var(--jade-600));
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 60px;
            position: relative;
            z-index: 2;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: 2fr 1fr 1fr 1.5fr;
            }
        }

        .footer-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 24px;
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
        }

        .footer-premium a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a {
            display: block;
            margin-bottom: 12px;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(4px);
        }

        .footer-socials {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .footer-socials a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-socials a:hover {
            background: var(--jade-600);
            border-color: var(--jade-600);
            transform: translateY(-4px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 80px;
            padding-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: center;
            font-size: 0.85rem;
            position: relative;
            z-index: 2;
        }

        @media (min-width: 768px) {
            .footer-bottom {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }
        }

        /* WHATSAPP FLOTANTE */
        .wa-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            box-shadow: 0 10px 24px rgba(37, 211, 102, 0.3);
            z-index: 90;
            transition: transform 0.2s;
            text-decoration: none;
        }

        .wa-float:hover {
            transform: scale(1.1);
        }

        /* MODALES */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(6px);
            z-index: 100;
            display: none;
            place-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: grid;
        }

        .modal-content {
            background: #fff;
            border-radius: 28px;
            width: 100%;
            max-width: 860px;
            overflow-y: auto;
            max-height: 90vh;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
        }

        .modal-grid {
            display: flex;
            flex-direction: column;
        }

        .badge-jade {
            background: var(--jade-100);
            color: var(--jade-800);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 900;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* TOP BAR PREMIUM */
        .top-bar-premium {
            background: var(--jade-950);
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.8rem;
            padding: 8px 0;
            z-index: 51;
            position: relative;
        }
        
        .top-bar-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        @media(min-width: 768px) {
            .top-bar-inner {
                justify-content: space-between;
            }
        }
        
        .top-bar-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: white;
        }
        
        .top-bar-status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
            display: inline-block;
        }
        
        .top-bar-info {
            display: none;
            gap: 16px;
            align-items: center;
        }
        @media (min-width: 768px) {
            .top-bar-info {
                display: flex;
            }
        }
        .top-bar-info span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="top-bar-premium">
        <div class="container-premium top-bar-inner">
            <div class="top-bar-status">
                <span class="top-bar-status-dot"></span>
                <span>{{ $doctora->status_label ?? 'Abierto ahora' }}</span>
            </div>
            <div class="top-bar-info">
                <span><i data-lucide="map-pin" style="width: 14px; height: 14px;"></i> Jr. Unión 637, Miramar Alto, Chimbote</span>
                <span style="opacity: 0.5;">|</span>
                <span><i data-lucide="phone" style="width: 14px; height: 14px;"></i> {{ $doctora->phone ?? '900 000 000' }}</span>
            </div>
        </div>
    </div>

    <!-- NAV -->
    <nav class="nav-premium" id="nav">
        <div class="container-premium nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                <img src="{{ $publicAssets->logo }}" alt="Miradent" style="height: 48px;">
            </a>

            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Inicio</a></li>
                <li><a href="{{ route('public.nosotros') }}" class="{{ request()->routeIs('public.nosotros') ? 'active' : '' }}">La Doctora</a></li>
                <li><a href="{{ route('public.servicios') }}" class="{{ request()->routeIs('public.servicios') ? 'active' : '' }}">Tratamientos</a></li>
                <li><a href="{{ route('public.promociones') }}" class="{{ request()->routeIs('public.promociones') ? 'active' : '' }}">Promociones</a></li>
                <li><a href="{{ route('public.casos') }}" class="{{ request()->routeIs('public.casos') ? 'active' : '' }}">Resultados</a></li>
                <li><a href="{{ route('public.testimonios') }}" class="{{ request()->routeIs('public.testimonios') ? 'active' : '' }}">Testimonios</a></li>
                <li><a href="{{ route('public.horarios') }}" class="{{ request()->routeIs('public.horarios') ? 'active' : '' }}">Horarios</a></li>
                <li><a href="{{ route('public.contacto') }}" class="{{ request()->routeIs('public.contacto') ? 'active' : '' }}">Contacto</a></li>
            </ul>

            <div class="nav-actions flex items-center gap-3">
                <a href="{{ route('public.reservar-cita') }}" class="nav-cta">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    <span>Reservar Cita</span>
                </a>
                <button class="nav-hamburger" id="hamburgerBtn" aria-label="Abrir menú">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu container-premium" id="mobileMenu">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ route('public.servicios') }}">Tratamientos</a>
            <a href="{{ route('public.promociones') }}">Promociones</a>
            <a href="{{ route('public.casos') }}">Antes y Después</a>
            <a href="{{ route('public.testimonios') }}">Testimonios</a>
            <a href="{{ route('public.horarios') }}">Horarios</a>
            <a href="{{ route('public.contacto') }}">Contacto</a>
            <a href="{{ route('public.reservar-cita') }}" class="nav-cta" style="width:fit-content;margin-top:.5rem">Reservar Cita</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- FOOTER PREMIUM -->
    <footer class="footer-premium" style="background: var(--jade-950); color: #cbd5e1; padding: 80px 0 40px; position: relative; overflow: hidden;">
        <!-- Decoración de fondo suave -->
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(0,168,132,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
        
        <style>
            .footer-link {
                color: #cbd5e1;
                text-decoration: none;
                transition: color 0.3s ease;
            }
            .footer-link:hover {
                color: #ffffff;
            }
        </style>
        <div class="container-premium">
            <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px;">
                <!-- Columna 1: Marca y descripción -->
                <div>
                    <div style="margin-bottom: 24px;">
                        <img src="{{ $publicAssets->logo_white ?? $publicAssets->logo }}" alt="Miradent" style="height: 40px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                    </div>
                    <p style="line-height: 1.6; margin-bottom: 24px;">
                        Transformamos vidas a través de sonrisas saludables y estéticas. Odontología premium con atención personalizada y tecnología de vanguardia en Chimbote.
                    </p>
                </div>

                <!-- Columna 2: Enlaces Rápidos -->
                <div>
                    <div class="footer-title" style="color: white; font-weight: 600; margin-bottom: 20px; letter-spacing: 0.05em; text-transform: uppercase; font-size: 0.9rem;">Enlaces Rápidos</div>
                    <div class="footer-links" style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ url('/') }}" class="footer-link">Inicio</a>
                        <a href="{{ route('public.servicios') }}" class="footer-link">Tratamientos</a>
                        <a href="{{ route('public.casos') }}" class="footer-link">Casos Clínicos</a>
                        <a href="{{ route('public.testimonios') }}" class="footer-link">Testimonios de Pacientes</a>
                    </div>
                </div>

                <!-- Columna 3: Pacientes -->
                <div>
                    <div class="footer-title" style="color: white; font-weight: 600; margin-bottom: 20px; letter-spacing: 0.05em; text-transform: uppercase; font-size: 0.9rem;">Atención al Paciente</div>
                    <div class="footer-links" style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ route('public.promociones') }}" class="footer-link">Promociones Especiales</a>
                        <a href="{{ route('public.horarios') }}" class="footer-link">Nuestros Horarios</a>
                        <a href="{{ route('public.contacto') }}" class="footer-link">Ubicación y Contacto</a>
                        <a href="{{ route('public.reservar-cita') }}" style="color: var(--jade-500); font-weight: 600;">Agendar Cita Ahora</a>
                    </div>
                </div>

                <!-- Columna 4: Contacto -->
                <div>
                    <div class="footer-title" style="color: white; font-weight: 600; margin-bottom: 20px; letter-spacing: 0.05em; text-transform: uppercase; font-size: 0.9rem;">Contáctanos</div>
                    <div class="footer-links" style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; gap: 12px; margin-bottom: 4px;">
                            <i data-lucide="map-pin" style="width: 20px; height: 20px; color: var(--jade-500); flex-shrink: 0; margin-top: 2px;"></i>
                            <span style="line-height: 1.5;">Jr. Unión 637, Miramar Alto<br>Chimbote, Perú</span>
                        </div>
                        <a href="{{ $doctora->phone_url }}" style="display: flex; gap: 12px; color: #cbd5e1; text-decoration: none;">
                            <i data-lucide="phone" style="width: 20px; height: 20px; color: var(--jade-500); flex-shrink: 0;"></i>
                            <span>{{ $doctora->phone ?? '+51 900 000 000' }}</span>
                        </a>
                        <div style="display: flex; gap: 12px;">
                            <i data-lucide="clock" style="width: 20px; height: 20px; color: var(--jade-500); flex-shrink: 0;"></i>
                            <span style="line-height: 1.5;">Lunes a Viernes<br>9:00 AM - 12:00 PM · 4:00 PM - 8:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom" style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 60px; padding-top: 30px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; font-size: 0.9rem;">
                <div>
                    &copy; {{ $publicAssets->year ?? date('Y') }} Clínica Odontológica Miradent. Todos los derechos reservados.
                </div>
                <div style="display: flex; gap: 24px;">
                    <a href="#" style="color: #94a3b8; text-decoration: none;">Política de Privacidad</a>
                    <a href="#" style="color: #94a3b8; text-decoration: none;">Términos de Servicio</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- FLOATING WHATSAPP -->
    <a href="{{ $doctora->whatsapp_url }}" target="_blank" class="wa-float" aria-label="Contactar por WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-7 h-7">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
    </a>

    <!-- PREMIUM SERVICE MODAL -->
    <div id="serviceModal" class="modal-overlay" onclick="if (event.target.id === 'serviceModal') closeServiceModal()">
        <div class="modal-content" onclick="event.stopImmediatePropagation()" style="max-width: 600px;">
            <div class="modal-grid">
                <!-- Top: Image Banner -->
                <div id="modalImageCol" style="position: relative; background: #f8fafc; height: 240px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; border-bottom: 1px solid #e2e8f0;">
                    <button onclick="closeServiceModal()" style="position: absolute; top: 16px; right: 16px; background: white; border: none; padding: 8px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="x" style="width: 20px; height: 20px; color: #64748b;"></i>
                    </button>
                    <img id="modalImage" style="display:none; width: 100%; height: 100%; object-fit: contain; padding: 12px;" alt="">
                    <div id="modalImageFallback" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; height: 100%; width: 100%; background: linear-gradient(135deg, var(--jade-50), #ffffff);">
                        <i data-lucide="smile" style="width: 64px; height: 64px; margin-bottom: 8px; opacity: 0.5; color: var(--jade-600);"></i>
                        <span style="font-size: 0.75rem; font-weight: 500; letter-spacing: 1.5px; opacity: 0.7; color: var(--jade-600);">MIRADENT</span>
                    </div>
                </div>

                <!-- Bottom: Info -->
                <div style="padding: 32px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <span id="modalBadge" class="badge-jade"></span>
                    </div>

                    <h3 id="modalTitle" style="font-family: 'Outfit', sans-serif; font-size: clamp(1.5rem, 3vw, 1.8rem); font-weight: 700; color: var(--jade-950); line-height: 1.2; margin-bottom: 16px; margin-top: 0;"></h3>

                    <div style="background: #f8fafc; border: 1px solid #f1f5f9; padding: 16px; border-radius: 16px; margin-bottom: 24px;">
                        <p id="modalDesc" style="font-size: 0.95rem; line-height: 1.6; color: var(--jade-800); margin: 0;"></p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <!-- Price -->
                        <div style="border: 1px solid #e2e8f0; background: white; border-radius: 16px; padding: 16px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--jade-50); color: var(--jade-600); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <div style="text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: var(--jade-600); font-weight: 700; margin-bottom: 2px;">PRECIO</div>
                                <div id="modalPrice" style="font-size: 1.15rem; font-weight: 700; color: var(--jade-800); font-family: 'Outfit', sans-serif;"></div>
                            </div>
                        </div>
                        <!-- Duration -->
                        <div style="border: 1px solid #e2e8f0; background: white; border-radius: 16px; padding: 16px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--jade-50); color: var(--jade-600); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <div style="text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: var(--jade-600); font-weight: 700; margin-bottom: 2px;">DURACIÓN</div>
                                <div id="modalDuration" style="font-size: 1.15rem; font-weight: 700; color: var(--jade-800); font-family: 'Outfit', sans-serif;"></div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 32px; flex-wrap: wrap;">
                        <a id="modalWaBtn" href="#" target="_blank"
                            style="flex: 1 1 200px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: var(--jade-700); color: white; padding: 14px; border-radius: 16px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: background 0.2s; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                            Agendar por WhatsApp
                        </a>
                        <button onclick="closeServiceModal()"
                            style="flex: 1 1 120px; border: 1px solid var(--jade-200); background: transparent; color: var(--jade-900); padding: 14px; border-radius: 16px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background 0.2s;">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Lucide icons
        function initIcons() {
            if (window.lucide) lucide.createIcons();
        }

        // Navbar scroll
        const nav = document.getElementById('nav');
        if (nav) {
            window.addEventListener('scroll', () => {
                nav.classList.toggle('scrolled', window.scrollY > 12);
            });
        }

        // Hamburger
        const hamburger = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (hamburger && mobileMenu) {
            hamburger.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });
        }

        // === MODERN SERVICE MODAL ===
        let currentModal = null;

        function openServiceModal(data) {
            const modal = document.getElementById('serviceModal');
            const img = document.getElementById('modalImage');
            const fallback = document.getElementById('modalImageFallback');

            document.getElementById('modalTitle').textContent = data.name || '';
            document.getElementById('modalDesc').textContent = data.desc || '';
            document.getElementById('modalBadge').textContent = data.category || '';

            const priceEl = document.getElementById('modalPrice');
            priceEl.textContent = data.price ? 'S/. ' + parseFloat(data.price).toFixed(2) : 'Consultar';

            document.getElementById('modalDuration').textContent = (data.duration || '45') + ' min';

            const waBtn = document.getElementById('modalWaBtn');
            waBtn.href = data.wa || '#';

            if (data.img) {
                img.src = data.img;
                img.alt = data.name;
                img.style.display = 'block';
                fallback.style.display = 'none';
            } else {
                img.style.display = 'none';
                fallback.style.display = 'flex';
            }

            modal.classList.add('active');
            initIcons();
        }

        function closeServiceModal() {
            const modal = document.getElementById('serviceModal');
            modal.classList.remove('active');
        }

        // Bind all service modals
        function bindServiceModals() {
            document.querySelectorAll('.btn-open-modal, [data-service-modal]').forEach(el => {
                if (el.dataset.bound) return;
                el.dataset.bound = '1';
                el.addEventListener('click', () => {
                    const d = {
                        name: el.dataset.name || el.getAttribute('data-name'),
                        desc: el.dataset.desc || el.getAttribute('data-desc') || '',
                        category: el.dataset.category || el.getAttribute('data-category'),
                        price: el.dataset.price || el.getAttribute('data-price'),
                        duration: el.dataset.duration || el.getAttribute('data-duration'),
                        img: el.dataset.img || el.getAttribute('data-img'),
                        wa: el.dataset.waUrl || el.getAttribute('data-wa-url') || '#'
                    };
                    openServiceModal(d);
                });
            });
        }
        bindServiceModals();

        // Expose for any additional pages
        window.bindMiradentModals = bindServiceModals;
        window.openMiradentService = openServiceModal;

        // Re-init icons after yield content
        document.addEventListener('DOMContentLoaded', () => {
            (window.requestIdleCallback || window.setTimeout)(initIcons, 0);
        });
    </script>

    @yield('scripts')
</body>

</html>
