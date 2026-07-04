<style>
/* ───── OLD NAVBAR (kept for compatibility in other contexts) ───── */
/* Note: Public pages now use the inline premium navbar from layout */
        .navbar-miradent {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid var(--jade-100);
            transition: all 0.4s ease;
            padding: 0;
        }
        .navbar-miradent.scrolled {
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            height: 72px;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo img { height: 38px; width: auto; }
        .nav-links {
            display: flex; align-items: center; gap: 2rem;
            list-style: none;
        }
        .nav-links a {
            color: var(--slate-700); text-decoration: none;
            font-weight: 500; font-size: 0.9rem;
            position: relative; padding-bottom: 2px;
            transition: color 0.2s;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -2px; left: 0;
            width: 0; height: 2px; background: var(--primary);
            transition: width 0.3s ease;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
        .nav-cta {
            background: var(--primary); color: white !important;
            padding: 0.65rem 1.5rem; border-radius: 50px;
            font-weight: 600; font-size: 0.875rem;
            text-decoration: none !important;
            transition: all 0.3s;
            display: flex; align-items: center; gap: 6px;
            white-space: nowrap;
        }
        .nav-cta::after { display: none !important; }
        .nav-cta:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(32,127,84,0.35);
        }
        .nav-hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer; padding: 4px;
        }
        .nav-hamburger span {
            width: 24px; height: 2px; background: var(--slate-700);
            border-radius: 2px; transition: all 0.3s;
        }
        .mobile-menu {
            display: none; position: fixed; top: 72px; left: 0; right: 0;
            background: white; border-bottom: 1px solid var(--slate-100);
            padding: 1.5rem 2rem; z-index: 999;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            flex-direction: column; gap: 1.25rem;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            color: var(--slate-700); text-decoration: none;
            font-weight: 500; font-size: 1rem;
            padding: 0.5rem 0; border-bottom: 1px solid var(--slate-100);
        }
        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu .nav-cta {
            display: inline-flex; width: fit-content;
            border: none !important; padding: 0.75rem 1.75rem;
        }
        @media (max-width: 1100px) {
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
        }
        @media (min-width: 1101px) {
            .nav-links { gap: 1.5rem; }
        }

        
        /* ───── STATUS BAR ───── */
        .status-bar {
            background: var(--slate-900); color: white;
            padding: 1rem 0;
        }
        .status-bar-inner {
            max-width: 1280px; margin: 0 auto; padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem;
        }
        .status-indicator { display: flex; align-items: center; gap: 10px; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .status-dot.open { background: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,0.25); animation: pulse-dot 2s infinite; }
        .status-dot.closed { background: #f87171; }
        .status-bar-contact { display: flex; gap: 1.5rem; flex-wrap: wrap; }
        .status-bar-contact a {
            color: rgba(255,255,255,0.7); text-decoration: none;
            font-size: 0.85rem; display: flex; align-items: center; gap: 6px;
            transition: color 0.2s;
        }
        .status-bar-contact a:hover { color: var(--jade-300); }

        </style>

<!-- ═══════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════ -->
    <nav class="navbar-miradent" id="navbar">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                <img src="{{ $publicAssets->logo }}" alt="Miradent Centro Odontológico">
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">Inicio</a></li>
                <li><a href="{{ route('public.servicios') }}" class="nav-item {{ request()->routeIs('public.servicios') ? 'active' : '' }}">Tratamientos</a></li>
                <li><a href="{{ route('public.promociones') }}" class="nav-item {{ request()->routeIs('public.promociones') ? 'active' : '' }}">Promociones</a></li>
                <li><a href="{{ route('public.casos') }}" class="nav-item {{ request()->routeIs('public.casos') ? 'active' : '' }}">Antes y Después</a></li>
                <li><a href="{{ route('public.testimonios') }}" class="nav-item {{ request()->routeIs('public.testimonios') ? 'active' : '' }}">Testimonios</a></li>
                <li><a href="{{ route('public.horarios') }}" class="nav-item {{ request()->routeIs('public.horarios') ? 'active' : '' }}">Horarios</a></li>
                <li><a href="{{ route('public.contacto') }}" class="nav-item {{ request()->routeIs('public.contacto') ? 'active' : '' }}">Contacto</a></li>
                <li><a href="{{ route('public.reservar-cita') }}" class="nav-cta" id="navCtaBtn">
                    <i data-lucide="calendar" style="width:16px;height:16px;"></i>
                    Reservar Cita
                </a></li>
            </ul>
            <button class="nav-hamburger" id="hamburgerBtn" aria-label="Menú">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('public.servicios') }}" class="nav-item {{ request()->routeIs('public.servicios') ? 'active' : '' }}">Tratamientos</a>
        <a href="{{ route('public.promociones') }}" class="nav-item {{ request()->routeIs('public.promociones') ? 'active' : '' }}">Promociones</a>
        <a href="{{ route('public.casos') }}" class="nav-item {{ request()->routeIs('public.casos') ? 'active' : '' }}">Antes y Después</a>
        <a href="{{ route('public.testimonios') }}" class="nav-item {{ request()->routeIs('public.testimonios') ? 'active' : '' }}">Testimonios</a>
        <a href="{{ route('public.horarios') }}" class="nav-item {{ request()->routeIs('public.horarios') ? 'active' : '' }}">Horarios</a>
        <a href="{{ route('public.contacto') }}" class="nav-item {{ request()->routeIs('public.contacto') ? 'active' : '' }}">Contacto</a>
        <a href="{{ route('public.reservar-cita') }}" class="nav-cta" style="display:inline-flex;width:fit-content;">
            <i data-lucide="calendar" style="width:16px;height:16px;"></i>
            Reservar Cita
        </a>
    </div>

    <!-- ═══════════════════════════════════════
         STATUS BAR
    ═══════════════════════════════════════ -->
    <div class="status-bar" style="margin-top:72px;">
        <div class="status-bar-inner">
            <div class="status-indicator">
                <span {!! 'style="font-size:0.85rem;font-weight:600;color:' . $doctora->status_color . ';"' !!}>
                    {{ $doctora->status_label }}

                </span>
                <span {!! 'style="font-size:0.8rem;color:rgba(255,255,255,0.55); ' . $doctora->status_style . '"' !!}>· {{ $doctora->status_text }}</span>
            </div>
            <div class="status-bar-contact">
                <a href="{{ $doctora->whatsapp_url }}" target="_blank" {!! 'style="' . $doctora->whatsapp_style . '"' !!}>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                    {{ $doctora->phone }}

                </a>
                <a href="{{ url('/contacto') }}">
                    <i data-lucide="map-pin" style="width:14px;height:14px;"></i>
                    Jr. Unión 637, Miramar Alto, Chimbote
                </a>
            </div>
        </div>
    </div>


    
<script id="navbar-js">
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll shadow
    const nav = document.getElementById('navbar');
    if (nav) {
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        });
    }

    // Mobile hamburger
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu   = document.getElementById('mobileMenu');
    if (hamburgerBtn && mobileMenu) {
        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
        });
    }
});
</script>
