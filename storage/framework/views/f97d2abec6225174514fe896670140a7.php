<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Miradent</title>
    
    <!-- Fuente cargada de forma asíncrona para mejorar el rendimiento -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    
    <style>
        /* =========================================================
           VARIABLES DE PERSONALIZACIÓN
           Aquí puedes modificar los colores, fondos y tipografías
           ========================================================= */
        :root {
            --primary: #2A9D8F; /* Verde Jade - Color principal */
            --primary-glow: rgba(42, 157, 143, 0.4);
            --bg-dark: #0f172a; /* Fondo base oscuro */
            --bg-card: rgba(30, 41, 59, 0.7); /* Fondo de la tarjeta (cristal) */
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --error-bg-number: rgba(255, 255, 255, 0.02); /* Color del número gigante */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        /* Contenedor principal 100% alto y ancho */
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* =========================================================
           FONDO Y ANIMACIONES
           ========================================================= */
        /* Número gigante en el fondo */
        .giant-bg-text {
            position: absolute;
            font-size: 40vw;
            font-weight: 800;
            color: var(--error-bg-number);
            z-index: 0;
            user-select: none;
            line-height: 1;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: nowrap;
        }

        /* Formas geométricas flotantes */
        .blob {
            position: absolute;
            filter: blur(100px);
            z-index: 0;
            opacity: 0.5;
            animation: float 12s infinite ease-in-out alternate;
        }

        .blob-1 {
            width: 50vw;
            height: 50vw;
            max-width: 600px;
            max-height: 600px;
            background: var(--primary);
            top: -20%;
            left: -10%;
            border-radius: 50%;
        }

        .blob-2 {
            width: 40vw;
            height: 40vw;
            max-width: 500px;
            max-height: 500px;
            background: #1e40af; /* Azul zafiro profundo */
            bottom: -15%;
            right: -5%;
            border-radius: 50%;
            animation-delay: -6s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 80px) scale(1.1); }
        }

        /* =========================================================
           TARJETA CENTRAL (GLASSMORPHISM)
           ========================================================= */
        .error-container {
            position: relative;
            z-index: 10;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 32px;
            padding: 4rem 3rem;
            text-align: center;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(40px);
        }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* =========================================================
           ELEMENTOS INTERNOS
           ========================================================= */
        .error-icon-wrapper {
            color: var(--primary);
            width: 90px;
            height: 90px;
            margin: 0 auto 1.5rem;
            filter: drop-shadow(0 0 20px var(--primary-glow));
            animation: pulse 3s infinite ease-in-out;
        }

        .error-icon-wrapper svg {
            width: 100%;
            height: 100%;
        }

        @keyframes pulse {
            0% { transform: scale(1) translateY(0); }
            50% { transform: scale(1.05) translateY(-10px); }
            100% { transform: scale(1) translateY(0); }
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .error-message {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        /* =========================================================
           BOTÓN INTERACTIVO
           ========================================================= */
        .btn-return {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, var(--primary) 0%, #207a6f 100%);
            color: white;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 25px -5px var(--primary-glow);
            cursor: pointer;
        }

        .btn-return:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 35px -5px var(--primary-glow);
            filter: brightness(1.15);
        }

        .btn-return svg {
            width: 22px;
            height: 22px;
            transition: transform 0.3s ease;
        }

        .btn-return:hover svg {
            transform: translateX(-5px);
        }

        /* Estilos específicos para cuando hay una imagen personalizada */
        .error-image-mode {
            width: 250px !important;
            height: 250px !important;
            margin-bottom: 2rem !important;
        }

        .error-custom-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
            animation: pulse 3s infinite ease-in-out;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .giant-bg-text { font-size: 50vw; }
            .error-container { padding: 3rem 2rem; }
            .error-title { font-size: 2rem; }
            .error-message { font-size: 1rem; }
            .btn-return { padding: 1rem 2rem; width: 100%; }
        }
    </style>
</head>
<body>

    <!-- Animaciones CSS Puras de Fondo -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <!-- Número Gigante de Fondo -->
    <div class="giant-bg-text"><?php echo $__env->yieldContent('code'); ?></div>

    <!-- Contenedor Principal (Tarjeta Glassmorphism) -->
    <div class="error-container">
        
        <!-- Icono SVG Inline o Imagen Personalizada -->
        <div class="error-icon-wrapper <?php echo e(View::hasSection('image-url') ? 'error-image-mode' : ''); ?>">
            <?php if (! empty(trim($__env->yieldContent('image-url')))): ?>
                <img src="<?php echo $__env->yieldContent('image-url'); ?>" alt="Error Image" class="error-custom-image">
            <?php else: ?>
                <?php echo $__env->yieldContent('icon-svg'); ?>
            <?php endif; ?>
        </div>

        <h1 class="error-title"><?php echo $__env->yieldContent('title'); ?></h1>
        <p class="error-message"><?php echo $__env->yieldContent('message'); ?></p>
        
        <a href="<?php echo e(url('/')); ?>" class="btn-return">
            <!-- Icono Arrow Left (SVG Inline) -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7"/>
                <path d="M19 12H5"/>
            </svg>
            Regresar al inicio
        </a>
    </div>

</body>
</html>
<?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/errors/layout.blade.php ENDPATH**/ ?>