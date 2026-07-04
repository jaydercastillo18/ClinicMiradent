<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/miradent_icono_vectorizado.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Miradent') - Panel Administrativo</title>

    <!-- Google Fonts: Outfit (Headings) & Plus Jakarta Sans (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

    <!-- Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])

    <!-- TomSelect (Searchable Dropdowns) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS Variables & Layout Styling -->
    <style>
        /* Transiciones suaves entre páginas (Chrome/Edge). Se ignora en navegadores
           sin soporte y se desactiva si el usuario prefiere menos movimiento. */
        @media (prefers-reduced-motion: no-preference) {
            @view-transition {
                navigation: auto;
            }
        }

        :root {
            /* Palette Color: STRICT Jade Green & White Only */
            --primary: #00A884;
            --primary-hover: #00876a;
            --primary-light: #EAFBF7;

            --sidebar-bg: #004d3c;
            --sidebar-hover: #006650;
            --sidebar-active: #006650;
            --sidebar-text: #99dcce;
            --sidebar-text-active: #ffffff;

            --bg-body: #EAFBF7;
            --bg-content: #ffffff;

            --text-main: #004d3c;
            --text-muted: #0D97A5;
            --border-color: #cceee6;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #064e3b 0%, #022c22 100%); /* Premium Dark Jade */
            color: var(--sidebar-text-active);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            color: white;
            background: rgba(0,0,0,0.1);
        }

        .sidebar-brand img {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: transform 0.3s;
        }
        
        .sidebar-brand:hover img {
            transform: scale(1.05);
        }

        .sidebar-menu {
            padding: 20px 16px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Elegante Custom Scrollbar para el Sidebar */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .menu-header {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6ee7b7; /* Mint green para alto contraste */
            font-weight: 800;
            padding: 16px 12px 8px;
            opacity: 0.9;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link i,
        .sidebar-link svg {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
            opacity: 0.8;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transform: translateX(6px);
        }

        .sidebar-link:hover i,
        .sidebar-link:hover svg {
            transform: scale(1.15) rotate(-5deg);
            opacity: 1;
            color: #6ee7b7;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, #047857 100%);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 8px 16px rgba(4, 120, 87, 0.4);
        }

        .sidebar-link.active i,
        .sidebar-link.active svg {
            color: #ffffff !important;
            opacity: 1;
        }

        .sidebar-footer {
            padding: 20px;
            background: rgba(0, 0, 0, 0.15);
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            gap: 4px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
        }

        /* --- MAIN WRAPPER --- */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 260px;
            min-height: 100vh;
            min-width: 0; /* Add this to prevent flex child from expanding body */
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 70px;
            background-color: var(--bg-content);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--shadow-sm);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .sidebar-toggle:hover {
            background-color: var(--border-color);
        }

        .search-box {
            position: relative;
            width: 280px;
            display: none;
            /* Show on tablets/desktops */
        }

        @media (min-width: 768px) {
            .search-box {
                display: block;
            }
        }

        .search-box input {
            background-color: var(--bg-body);
            border: 1px solid var(--border-color);
            padding: 8px 16px 8px 40px;
            border-radius: 20px;
            font-size: 0.875rem;
            width: 100%;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(32, 127, 84, 0.15);
            background-color: white;
        }

        .search-box i,
        .search-box svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            width: 16px;
            height: 16px;
            pointer-events: none;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            position: relative;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .topbar-btn:hover {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        .topbar-btn .badge-pulse {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 10px;
            height: 10px;
            background-color: #1b5c3a;
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0% {
                box-shadow: 0 0 0 0 rgba(27, 92, 58, 0.7);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(27, 92, 58, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(27, 92, 58, 0);
            }
        }

        .no-caret::after {
            display: none !important;
        }

        .notification-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .notification-item:hover {
            background-color: var(--primary-light) !important;
        }

        .notification-item.item-cita {
            border-left-color: #1b5c3a;
            /* Jade for pending appointments */
        }

        .notification-item.item-pago {
            border-left-color: #4fc380;
            /* Jade medium for debts */
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-main);
            padding: 4px 8px;
            border-radius: 20px;
            transition: background-color 0.2s;
        }

        .user-profile:hover {
            background-color: var(--bg-body);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            padding: 2px;
        }

        .user-info {
            display: none;
            flex-direction: column;
            line-height: 1.2;
        }

        @media (min-width: 576px) {
            .user-info {
                display: flex;
            }
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* --- CONTENT MAIN --- */
        .content-main {
            flex-grow: 1;
            padding: 30px;
            background-color: var(--bg-content);
            min-width: 0; /* Important to prevent horizontal overflow in flex layout */
            /* Contenido principal en fondo blanco */
        }
        
        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -260px;
            }

            .main-wrapper {
                margin-left: 0;
            }

            /* Sidebar active state on mobile */
            body.sidebar-open .sidebar {
                left: 0;
                box-shadow: var(--shadow-lg);
            }

            body.sidebar-open .main-wrapper::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(2px);
                z-index: 998;
                transition: opacity 0.3s;
            }
        }

        @media (max-width: 768px) {
            .content-main {
                padding: 16px;
            }

            .topbar {
                padding: 0 16px;
            }
        }

        @media (max-width: 480px) {
            .content-main {
                padding: 12px;
            }

            .dropdown-menu[aria-labelledby="notificationsDropdown"] {
                width: calc(100vw - 24px) !important;
                max-width: 360px;
            }
        }

        /* --- Recordatorio Toast Popup --- */
        .miradent-alert-toast {
            position: fixed;
            bottom: 24px;
            right: -400px;
            width: 340px;
            max-height: 90vh;
            z-index: 1050;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(32, 127, 84, 0.2);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            display: flex;
            flex-direction: column;
        }

        .miradent-alert-toast.show {
            right: 24px;
            opacity: 1;
        }

        @media (max-width: 400px) {
            .miradent-alert-toast {
                width: calc(100vw - 24px);
                right: -100vw;
            }

            .miradent-alert-toast.show {
                right: 12px;
            }
        }

        .miradent-toast-header {
            background: linear-gradient(135deg, rgba(32, 127, 84, 0.08), rgba(16, 185, 129, 0.03));
            border-bottom: 1px solid rgba(32, 127, 84, 0.08);
            border-radius: 16px 16px 0 0;
        }

        @keyframes pulse-toast-icon {
            0% {
                box-shadow: 0 0 0 0 rgba(32, 127, 84, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(32, 127, 84, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(32, 127, 84, 0);
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <a href="{{ url('/admin/dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/miradent_logo_vectorizado.svg') }}" alt="Miradent" style="height: 36px; width: auto; object-fit: contain; border-radius: 8px;">
        </a>

        <div class="sidebar-menu">
            <div class="menu-header">Principal</div>

            <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/admin/pacientes') }}" class="sidebar-link {{ request()->is('admin/pacientes*') ? 'active' : '' }}">
                <i data-lucide="users"></i>
                <span>Pacientes</span>
            </a>

            <a href="{{ url('/admin/citas') }}" class="sidebar-link {{ request()->is('admin/citas*') ? 'active' : '' }}">
                <i data-lucide="calendar"></i>
                <span>Citas</span>
            </a>

            @if(auth()->user()->role === 'doctora')
            <a href="{{ route('finanzas.index') }}" class="sidebar-link {{ request()->is('admin/finanzas*') || request()->is('admin/pagos*') || request()->is('admin/gastos*') ? 'active' : '' }}">
                <i data-lucide="dollar-sign"></i>
                <span>Caja y Finanzas</span>
            </a>
            @endif

            <div class="menu-header">Gestión y Promoción</div>

            <a href="{{ route('servicios.index') }}" class="sidebar-link {{ request()->is('admin/servicios*') ? 'active' : '' }}">
                <i data-lucide="heart-handshake"></i>
                <span>Servicios</span>
            </a>

            <a href="{{ route('promociones.index') }}" class="sidebar-link {{ request()->is('admin/promociones*') ? 'active' : '' }}">
                <i data-lucide="gift"></i>
                <span>Promociones</span>
            </a>

            <a href="{{ route('casos-exito.index') }}" class="sidebar-link {{ request()->routeIs('casos-exito.*') ? 'active' : '' }}">
                <i data-lucide="sparkles"></i>
                <span>Antes y Después</span>
            </a>

            <a href="{{ route('testimonios.index') }}" class="sidebar-link {{ request()->routeIs('testimonios.*') ? 'active' : '' }}">
                <i data-lucide="star"></i>
                <span>Testimonios</span>
            </a>

            <a href="{{ route('instalaciones.index') }}" class="sidebar-link {{ request()->routeIs('instalaciones.*') ? 'active' : '' }}">
                <i data-lucide="image"></i>
                <span>Instalaciones</span>
            </a>

            @if(auth()->user()->role === 'doctora')
            <a href="{{ route('reportes.index') }}" class="sidebar-link {{ request()->is('admin/reportes*') ? 'active' : '' }}">
                <i data-lucide="bar-chart-2"></i>
                <span>Reportes</span>
            </a>
            @endif

            @if(auth()->user()->role === 'doctora')
            <div class="menu-header">Administración Segura</div>
            <a href="{{ route('usuarios.index') }}" class="sidebar-link {{ request()->is('admin/usuarios*') ? 'active' : '' }}">
                <i data-lucide="users"></i>
                <span>Usuarios</span>
            </a>
            <a href="{{ route('auditoria.index') }}" class="sidebar-link {{ request()->is('admin/auditoria*') ? 'active' : '' }}">
                <i data-lucide="shield"></i>
                <span>Auditoría</span>
            </a>
            <a href="{{ url('/admin/configuracion') }}" class="sidebar-link {{ request()->is('admin/configuracion*') ? 'active' : '' }}">
                <i data-lucide="settings"></i>
                <span>Configuración</span>
            </a>
            <a href="{{ route('payment-settings.edit') }}" class="sidebar-link {{ request()->is('admin/configuracion-pagos*') ? 'active' : '' }}">
                <i data-lucide="credit-card"></i>
                <span>Configuración de Pagos</span>
            </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <div>Miradent Admin v1.0</div>
            <div>© 2026 Clínica Dental</div>
        </div>
    </aside>

    <!-- Main Wrapper (Topbar + Dynamic Content) -->
    <div class="main-wrapper">

        <!-- Top Header Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <!-- Hamburger Menu for Mobile -->
                <button class="sidebar-toggle" id="toggle-sidebar" aria-label="Toggle Navigation">
                    <i data-lucide="menu"></i>
                </button>

                <!-- Styled Search Area -->
                <div class="search-box">
                    <i data-lucide="search"></i>
                    <input type="text" placeholder="Buscar paciente, cita...">
                </div>
            </div>

            <div class="topbar-right">
                <!-- Notifications via Axios -->
                <div class="dropdown">
                    <button class="topbar-btn dropdown-toggle no-caret" id="notificationsDropdown" data-ui-toggle="dropdown" aria-expanded="false" aria-label="Notificaciones" onclick="loadNotificaciones()">
                        <i data-lucide="bell"></i>
                        <span id="notifBadge" class="badge-pulse" style="display: none;"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-0" aria-labelledby="notificationsDropdown" style="width: 360px; max-height: 450px; overflow-y: auto; background-color: var(--bg-content); border-radius: 16px; margin-top: 10px;">
                        <li class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: var(--primary-light); border-radius: 16px 16px 0 0;">
                            <span class="fw-bold text-slate-800" style="font-size: 1rem; color: var(--primary); font-family: 'Outfit', sans-serif;">Notificaciones</span>
                            <span id="notifCountLabel" class="badge bg-primary text-white" style="font-size: 0.75rem; border-radius: 6px;">Cargando...</span>
                        </li>
                        
                        <div id="notifContainer">
                            <li class="p-4 text-center text-muted">
                                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                                <p class="mb-0" style="font-size: 0.85rem;">Cargando notificaciones...</p>
                            </li>
                        </div>

                        <li class="p-2 text-center bg-white border-top" style="background-color: #f8fafc; border-radius: 0 0 16px 16px;">
                            <span class="text-muted" style="font-size: 0.75rem; font-weight: 500; letter-spacing: 0.5px;">
                                <i data-lucide="shield-check" style="width: 14px; height: 14px; margin-top: -2px;"></i> Miradent Clinical Suite
                            </span>
                        </li>
                    </ul>
                </div>

                <script>
                    let notifsLoaded = false;

                    function escapeHtml(value) {
                        return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#039;'
                        })[char]);
                    }

                    function loadNotificaciones() {
                        if (notifsLoaded) return; // Prevent multiple clicks from spamming the server
                        const container = document.getElementById('notifContainer');
                        
                        axios.get('{{ route("admin.notificaciones") }}')
                            .then(response => {
                                const { citas, pagos, total } = response.data;
                                const badge = document.getElementById('notifBadge');
                                const label = document.getElementById('notifCountLabel');
                                
                                if (total > 0) {
                                    badge.style.display = 'block';
                                    label.textContent = total + ' pendientes';
                                    label.classList.remove('bg-success');
                                    label.classList.add('bg-primary');
                                } else {
                                    badge.style.display = 'none';
                                    label.textContent = 'Al día';
                                    label.classList.remove('bg-primary');
                                    label.classList.add('bg-success');
                                }

                                if (total === 0) {
                                    container.innerHTML = `
                                        <li class="p-5 text-center text-muted">
                                            <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                                <i data-lucide="check-circle-2" class="text-success" style="width: 24px; height: 24px;"></i>
                                            </div>
                                            <p class="mb-1" style="font-size: 0.95rem; font-weight: 600; color: #334155;">¡Todo al día!</p>
                                            <p class="mb-0" style="font-size: 0.8rem; color: #64748b;">No tienes tareas pendientes.</p>
                                        </li>
                                    `;
                                    window.lucide?.createIcons();
                                    notifsLoaded = true;
                                    return;
                                }

                                let html = '';
                                
                                // Citas
                                if (citas.length > 0) {
                                    html += `
                                        <li class="dropdown-header d-flex align-items-center gap-2 text-slate-500 fw-bold px-4 pt-3 pb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; background: #f8fafc;">
                                            <i data-lucide="calendar-clock" style="width: 14px; height: 14px; color: var(--primary);"></i> Citas por Confirmar (${citas.length})
                                        </li>
                                    `;
                                    citas.forEach(c => {
                                        const paciente = escapeHtml(c.paciente || 'Paciente');
                                        const detalle = escapeHtml(c.detalle || '');
                                        const url = escapeHtml(c.url || '#');
                                        html += `
                                            <li class="px-4 py-3 border-bottom" style="transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                                                <a href="${url}" class="d-flex flex-column text-decoration-none">
                                                    <span class="text-slate-800 fw-bold" style="font-size: 0.9rem;">${paciente}</span>
                                                    <span class="text-slate-500 mb-2" style="font-size: 0.8rem;">${detalle}</span>
                                                    <span class="text-primary fw-semibold" style="font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                                        Gestionar cita <i data-lucide="arrow-right" style="width: 12px; height: 12px;"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        `;
                                    });
                                }

                                // Pagos
                                if (pagos.length > 0) {
                                    html += `
                                        <li class="dropdown-header d-flex align-items-center gap-2 text-slate-500 fw-bold px-4 pt-3 pb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; background: #fff1f2; border-top: 1px solid #f1f5f9;">
                                            <i data-lucide="alert-triangle" style="width: 14px; height: 14px; color: #e11d48;"></i> Clientes con Deudas (${pagos.length})
                                        </li>
                                    `;
                                    pagos.forEach(p => {
                                        const badgeClass = p.estado_pago === 'parcial' ? 'bg-warning text-dark' : 'bg-danger';
                                        const paciente = escapeHtml(p.paciente || 'Paciente');
                                        const estado = escapeHtml(p.estado_pago || 'pendiente').toUpperCase();
                                        const monto = escapeHtml(p.monto || '0.00');
                                        const url = escapeHtml(p.url || '#');
                                        html += `
                                            <li class="px-4 py-3 border-bottom" style="transition: background 0.2s;" onmouseover="this.style.background='#fffbfa'" onmouseout="this.style.background='white'">
                                                <a href="${url}" class="d-flex flex-column text-decoration-none">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-slate-800 fw-bold" style="font-size: 0.9rem;">${paciente}</span>
                                                        <span class="badge ${badgeClass}" style="font-size: 0.65rem;">${estado}</span>
                                                    </div>
                                                    <span class="text-slate-500 mb-2" style="font-size: 0.85rem;">Saldo pendiente: S/. ${monto}</span>
                                                    <span class="text-danger fw-semibold" style="font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                                        Cobrar saldo <i data-lucide="arrow-right" style="width: 12px; height: 12px;"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        `;
                                    });
                                }

                                container.innerHTML = html;
                                window.lucide?.createIcons();
                                notifsLoaded = true;
                            })
                            .catch(error => {
                                console.error('Error fetching notificaciones:', error);
                                container.innerHTML = `
                                    <li class="p-3 text-center text-danger">
                                        <i data-lucide="alert-circle" class="mb-2"></i>
                                        <p style="font-size: 0.8rem;">Error al cargar notificaciones.</p>
                                    </li>
                                `;
                                window.lucide?.createIcons();
                            });
                    }

                    // Check initial count on load without rendering everything
                    document.addEventListener('DOMContentLoaded', () => {
                        axios.get('{{ route("admin.notificaciones") }}')
                            .then(response => {
                                const { citas, pagos, total } = response.data;
                                if (total > 0) {
                                    document.getElementById('notifBadge').style.display = 'block';
                                    
                                    // Trigger Toast
                                    const toast = document.getElementById('miradent-reminder-toast');
                                    const closeBtn = document.getElementById('close-reminder-toast');
                                    const toastContent = document.getElementById('toast-dynamic-content');
                                    const toastActions = document.getElementById('toast-dynamic-actions');

                                    if (toast && !sessionStorage.getItem('miradent_toast_dismissed')) {
                                        let html = '';
                                        if (citas.length > 0) {
                                            html += `
                                                <li class="d-flex align-items-center gap-2 text-slate-600 mb-1">
                                                    <i data-lucide="calendar" class="text-primary" style="width: 14px; height: 14px;"></i>
                                                    <span><strong>${citas.length}</strong> cita${citas.length > 1 ? 's' : ''} por confirmar</span>
                                                </li>
                                            `;
                                        }
                                        if (pagos.length > 0) {
                                            html += `
                                                <li class="d-flex align-items-center gap-2 text-slate-600">
                                                    <i data-lucide="dollar-sign" class="text-primary" style="width: 14px; height: 14px;"></i>
                                                    <span><strong>${pagos.length}</strong> cliente${pagos.length > 1 ? 's' : ''} con saldo pendiente</span>
                                                </li>
                                            `;
                                        }
                                        toastContent.innerHTML = html;

                                        let actionsHtml = '';
                                        if (pagos.length > 0) {
                                            actionsHtml += `
                                                <a href="{{ route('finanzas.index') }}" class="btn btn-primary flex-grow-1 py-1 px-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-size: 0.75rem; font-weight: 600;">
                                                    Ver Caja
                                                </a>
                                            `;
                                        }
                                        if (citas.length > 0) {
                                            actionsHtml += `
                                                <a href="{{ url('/admin/citas') }}" class="btn btn-outline-success flex-grow-1 py-1 px-2" style="border-radius: 8px; font-size: 0.75rem; font-weight: 600;">
                                                    Ver Citas
                                                </a>
                                            `;
                                        }
                                        toastActions.innerHTML = actionsHtml;
                                        
                                        if (window.lucide) lucide.createIcons();

                                        setTimeout(() => toast.classList.add('show'), 1500);

                                        if (closeBtn) {
                                            closeBtn.addEventListener('click', () => {
                                                toast.classList.remove('show');
                                                sessionStorage.setItem('miradent_toast_dismissed', 'true');
                                            });
                                        }
                                    }
                                }
                            })
                            .catch(e => console.log('Silently failing notification toast load.'));
                    });
                </script>

                <!-- Quick Help -->
                <button class="topbar-btn d-none d-sm-flex" aria-label="Soporte/Ayuda">
                    <i data-lucide="help-circle"></i>
                </button>

                <!-- Doctor's Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="user-profile dropdown-toggle" id="profileDropdown" data-ui-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()?->doctora)
                        <img src="{{ Auth::user()->doctora->avatar_url }}" alt="Avatar Doctora" class="user-avatar">
                        @endif
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()?->name ?? '' }}</span>
                            <span class="user-role">{{ Auth::check() && Auth::user()->role === 'doctora' ? 'Dentista / Propietaria' : 'Asistente' }}</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="profileDropdown" style="background-color: var(--bg-content)">
                        @if(auth()->check() && auth()->user()->role === 'doctora')
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ url('/admin/doctora') }}">
                                <i data-lucide="user" class="text-muted" style="width: 16px;"></i> Perfil Profesional
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->role === 'doctora')
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ url('/admin/configuracion') }}">
                                <i data-lucide="settings" class="text-muted" style="width: 16px;"></i> Configuración
                            </a>
                        </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider bg-white" style="background-color: #f2faf6;">
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-primary" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').requestSubmit();">
                                <i data-lucide="log-out" style="width: 16px;"></i> Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Main Content Wrapper -->
        <main class="content-main">
            @yield('content')
        </main>
    </div>

    <!-- Sidebar toggle & icon initialization (Axios/forms logic lives in resources/js/admin.js) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide Icons
            window.lucide?.createIcons();

            // Responsive Sidebar Toggle
            const toggleBtn = document.getElementById('toggle-sidebar');
            const body = document.body;

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    body.classList.toggle('sidebar-open');
                });
            }

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && body.classList.contains('sidebar-open')) {
                    const sidebar = document.querySelector('.sidebar');
                    if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
                        body.classList.remove('sidebar-open');
                    }
                }
            });
        });
    </script>

    <!-- Recordatorio Flotante (Popup Toast) -->
    <div id="miradent-reminder-toast" class="miradent-alert-toast p-0">
        <div class="miradent-toast-header d-flex justify-content-between align-items-center px-3 py-2">
            <div class="d-flex align-items-center gap-2 text-primary">
                <div class="p-1 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; animation: pulse-toast-icon 2s infinite; background-color: var(--primary) !important;">
                    <i data-lucide="bell" style="width: 14px; height: 14px;"></i>
                </div>
                <strong style="font-size: 0.85rem; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--primary);">Pendientes de Hoy</strong>
            </div>
            <button type="button" class="btn-close" id="close-reminder-toast" aria-label="Close" style="font-size: 0.75rem; box-shadow: none;"></button>
        </div>
        <div class="p-3 overflow-auto" style="max-height: 40vh;">
            <p class="text-slate-700 mb-2" style="font-size: 0.8rem; font-weight: 500;">
                {{ Auth::user()->name }}, tiene actividades pendientes:
            </p>
            <ul id="toast-dynamic-content" class="list-unstyled mb-3" style="font-size: 0.8rem; line-height: 1.6;">
            </ul>
            <div id="toast-dynamic-actions" class="d-flex gap-2">
            </div>
        </div>
    </div>

    <!-- TomSelect JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js" defer></script>

    @yield('scripts')
</body>

</html>
