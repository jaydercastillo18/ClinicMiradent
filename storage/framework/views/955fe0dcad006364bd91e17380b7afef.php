<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/miradent_icono_vectorizado.svg')); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miradent - Acceso Privado</title>
    <meta name="description" content="Panel administrativo privado de Clínica Dental Miradent.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --jade:       #2eb87a;
            --jade-light: #3dd68c;
            --jade-dark:  #1a8a57;
            --jade-pale:  rgba(46,184,122,0.08);
            --gold:       #c9a84c;
            --gold-light: #e8c96d;
            --gold-pale:  rgba(201,168,76,0.15);
            --white:      #ffffff;
            --cream:      #f7faf8;
            --font:       'Outfit', sans-serif;
        }

        html, body {
            height: 100%;
            font-family: var(--font);
        }

        /* Full-screen background with logo */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background layer */
        .bg-layer {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #e8f5ef 0%, #f0faf5 35%, #ffffff 65%, #fefbf0 100%);
            z-index: 0;
        }

        /* Logo background large, centered, faded */
        .bg-logo {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: min(680px, 92vw);
            height: min(680px, 92vw);
            object-fit: contain;
            opacity: 0.07;
            pointer-events: none;
            z-index: 1;
            animation: floatLogo 12s ease-in-out infinite alternate;
            filter: saturate(0.4);
        }

        @keyframes floatLogo {
            from { transform: translate(-50%, -50%) scale(1); opacity: 0.07; }
            to   { transform: translate(-50%, -50%) scale(1.04); opacity: 0.10; }
        }

        /* Decorative jade orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }

        .orb-1 {
            top: -120px; left: -120px;
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(46,184,122,0.14) 0%, transparent 70%);
            animation: breathe 9s ease-in-out infinite alternate;
        }

        .orb-2 {
            bottom: -100px; right: -80px;
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
            animation: breathe 11s ease-in-out infinite alternate-reverse;
        }

        .orb-3 {
            top: 40%; right: 8%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(46,184,122,0.08) 0%, transparent 70%);
            animation: breathe 7s ease-in-out infinite alternate;
        }

        @keyframes breathe {
            from { transform: scale(1); }
            to   { transform: scale(1.2); }
        }

        /* Main wrapper */
        .wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Login card */
        .card {
            background: rgba(255,255,255,0.90);
            backdrop-filter: blur(28px) saturate(1.4);
            -webkit-backdrop-filter: blur(28px) saturate(1.4);
            border: 1px solid rgba(46,184,122,0.16);
            border-radius: 28px;
            padding: 52px 48px 48px;
            width: 100%;
            max-width: 440px;
            box-shadow:
                0 2px 0 0 rgba(201,168,76,0.25),
                0 24px 64px -12px rgba(46,184,122,0.12),
                0 8px 24px rgba(0,0,0,0.06);
            animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(36px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Logo top */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 36px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.15s both;
        }

        .logo-img-wrap {
            width: 90px;
            height: 90px;
            border-radius: 22px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 0 0 1px rgba(46,184,122,0.15),
                0 4px 20px rgba(46,184,122,0.10),
                0 2px 0 rgba(201,168,76,0.3) inset;
            margin-bottom: 16px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo-img-wrap:hover {
            transform: translateY(-2px);
            box-shadow:
                0 0 0 1px rgba(46,184,122,0.25),
                0 8px 28px rgba(46,184,122,0.18),
                0 2px 0 rgba(201,168,76,0.4) inset;
        }

        .logo-img-wrap img {
            width: 72px;
            height: 72px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #1a4d33;
        }

        .brand-name span {
            color: var(--jade);
        }

        /* Gold accent divider */
        .gold-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 30px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.25s both;
        }

        .gold-divider::before,
        .gold-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.35), transparent);
        }

        .gold-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 6px rgba(201,168,76,0.5);
        }

        /* Title area */
        .form-head {
            margin-bottom: 28px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.3s both;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a4d33;
            letter-spacing: -0.025em;
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 0.875rem;
            color: #6b9e82;
            font-weight: 400;
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 0.855rem;
            font-weight: 500;
            margin-bottom: 22px;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fdd;
            color: #a03030;
        }

        .alert-success {
            background: #f0fdf6;
            border: 1px solid rgba(46,184,122,0.25);
            color: var(--jade-dark);
        }

        /* Field */
        .field {
            margin-bottom: 18px;
            opacity: 0;
            animation: fadeIn 0.5s ease var(--d, 0.38s) both;
        }

        .field:nth-child(1) { --d: 0.38s; }
        .field:nth-child(2) { --d: 0.46s; }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #3a7a55;
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .input-wrap input {
            width: 100%;
            padding: 14px 46px 14px 44px;
            border: 1.5px solid rgba(46,184,122,0.22);
            border-radius: 14px;
            font-family: var(--font);
            font-size: 0.92rem;
            font-weight: 400;
            color: #1a4d33;
            background: rgba(240,250,245,0.7);
            outline: none;
            transition: all 0.22s ease;
        }

        .input-wrap input::placeholder { color: #9abfaa; }

        .input-wrap input:hover {
            border-color: rgba(46,184,122,0.4);
            background: rgba(240,250,245,0.9);
        }

        .input-wrap input:focus {
            background: #fff;
            border-color: var(--jade);
            box-shadow: 0 0 0 4px rgba(46,184,122,0.12);
        }

        .field-icon {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            color: #9abfaa;
            pointer-events: none;
            display: flex;
            transition: color 0.2s;
        }

        .field-icon svg {
            width: 17px; height: 17px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .input-wrap input:focus ~ .field-icon { color: var(--jade); }

        .eye-btn {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; padding: 5px;
            display: flex; align-items: center;
            color: #9abfaa;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: var(--jade); }
        .eye-btn svg {
            width: 17px; height: 17px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        /* Remember row */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 28px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.56s both;
        }

        .check {
            width: 17px; height: 17px;
            border: 1.5px solid rgba(46,184,122,0.35);
            border-radius: 5px;
            appearance: none;
            cursor: pointer;
            flex-shrink: 0;
            position: relative;
            transition: all 0.18s ease;
            background: transparent;
        }

        .check:checked {
            background: var(--jade);
            border-color: var(--jade);
        }

        .check:checked::after {
            content: '';
            position: absolute;
            left: 3px; top: 0px;
            width: 8px; height: 5px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(-45deg);
        }

        .check-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6b9e82;
            cursor: pointer;
        }

        /* Submit button */
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--jade) 0%, var(--jade-dark) 100%);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: var(--font);
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.22s ease;
            box-shadow:
                0 1px 0 rgba(201,168,76,0.4) inset,
                0 6px 20px rgba(46,184,122,0.30);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.64s both;
        }

        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.15) 50%, transparent 70%);
            transform: translateX(-130%);
            transition: transform 0.55s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow:
                0 1px 0 rgba(201,168,76,0.5) inset,
                0 12px 32px rgba(46,184,122,0.38);
        }

        .btn:hover::after { transform: translateX(130%); }
        .btn:active { transform: translateY(0); }

        .btn-arrow {
            width: 17px; height: 17px;
            stroke: rgba(255,255,255,0.8); fill: none;
            stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
            transition: transform 0.2s;
        }
        .btn:hover .btn-arrow { transform: translateX(4px); }

        /* Footer */
        .card-footer {
            text-align: center;
            margin-top: 28px;
            opacity: 0;
            animation: fadeIn 0.5s ease 0.75s both;
        }

        .secure-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #9abfaa;
        }

        .secure-badge svg {
            width: 13px; height: 13px;
            stroke: var(--gold); fill: none;
            stroke-width: 2; stroke-linecap: round;
        }

        .gold-line {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.3), transparent);
            margin-bottom: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 500px) {
            .card { padding: 40px 28px 36px; }
            .form-title { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    <!-- Background -->
    <div class="bg-layer"></div>
    <img class="bg-logo" src="<?php echo e(asset('images/miradent_logo_vectorizado.svg')); ?>" alt="" role="presentation" aria-hidden="true">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Card -->
    <div class="wrapper">
        <div class="card">

            <!-- Logo -->
            <div class="logo-area">
                <div class="logo-img-wrap">
                    <img src="<?php echo e(asset('images/miradent_logo_vectorizado.svg')); ?>" alt="Logo Miradent">
                </div>
                <div class="brand-name">Mira<span>dent</span></div>
            </div>

            <!-- Gold divider -->
            <div class="gold-divider">
                <div class="gold-dot"></div>
                <div class="gold-dot"></div>
                <div class="gold-dot"></div>
            </div>

            <!-- Title -->
            <div class="form-head">
                <h1 class="form-title">Bienvenida</h1>
                <p class="form-subtitle">Ingresa tus credenciales para acceder al panel.</p>
            </div>

            <!-- Alerts -->
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span style="display:block;"><?php echo e($error); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-5"/></svg>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div class="field">
                    <label class="field-label" for="email">Correo electrónico</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email"
                               value="<?php echo e(old('email')); ?>"
                               placeholder="Ingresa tu correo"
                               required autocomplete="email" autofocus>
                        <span class="field-icon">
                            <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
                        </span>
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <label class="field-label" for="password">Contraseña</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password"
                               placeholder="********"
                               required autocomplete="current-password">
                        <span class="field-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <button type="button" class="eye-btn" id="eyeBtn" aria-label="Mostrar contraseña">
                            <svg id="eyeIco" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="remember-row">
                    <input class="check" type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label class="check-label" for="remember">Recordar mi sesión</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn">
                    Ingresar al Panel
                    <svg class="btn-arrow" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>

            <!-- Footer -->
            <div class="card-footer">
                <div class="gold-line"></div>
                <div class="secure-badge">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Acceso privado y seguro &mdash; Clínica clínica Miradent
                </div>
            </div>

        </div>
    </div>

<script>
    const btn = document.getElementById('eyeBtn');
    const pwd = document.getElementById('password');
    const ico = document.getElementById('eyeIco');
    const eyeOpen = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    const eyeOff  = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    if (btn) btn.addEventListener('click', () => {
        const v = pwd.type === 'password';
        pwd.type = v ? 'text' : 'password';
        ico.innerHTML = v ? eyeOff : eyeOpen;
    });
</script>

</body>
</html>
<?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/login.blade.php ENDPATH**/ ?>