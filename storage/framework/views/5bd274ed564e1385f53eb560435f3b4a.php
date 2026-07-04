<?php $__env->startSection('title', 'Servicios y Tratamientos | Miradent'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .services-hero {
        padding: calc(78px + 64px) 0 48px;
        background:
            linear-gradient(180deg, rgba(234, 251, 247, 0.95), rgba(255, 255, 255, 1)),
            repeating-linear-gradient(90deg, rgba(0, 168, 132, 0.045) 0 1px, transparent 1px 92px);
        border-bottom: 1px solid rgba(0, 84, 66, 0.08);
        text-align: center;
    }

    .services-title {
        max-width: 860px;
        margin: 18px auto 14px;
        color: var(--jade-950);
        font-family: 'Outfit', sans-serif;
        font-size: clamp(2.4rem, 5vw, 4.35rem);
        font-weight: 900;
        line-height: 0.95;
        letter-spacing: 0;
    }

    .services-copy {
        max-width: 700px;
        margin: 0 auto;
        color: var(--jade-800);
        font-size: 1.04rem;
        line-height: 1.7;
    }

    .services-catalog {
        padding: 34px 0 96px;
        background: #ffffff;
    }

    .services-container {
        width: min(1160px, calc(100% - 40px));
        margin: 0 auto;
    }

    .services-filter-card {
        max-width: 980px;
        margin: 0 auto 34px;
        padding: 22px;
        border: 1px solid rgba(0, 168, 132, 0.18);
        border-radius: 26px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 22px 60px rgba(0, 84, 66, 0.08);
    }

    .services-search-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 12px;
        align-items: center;
        margin-bottom: 20px;
    }

    .services-search-field {
        position: relative;
    }

    .services-search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        width: 19px;
        height: 19px;
        color: var(--jade-500);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .services-search-input {
        width: 100%;
        height: 52px;
        border: 1px solid var(--jade-200);
        border-radius: 999px;
        background: var(--jade-50);
        color: var(--jade-950);
        padding: 0 18px 0 48px;
        font-size: 0.94rem;
        font-weight: 600;
        outline: none;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .services-search-input:focus {
        border-color: var(--jade-500);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 168, 132, 0.1);
    }

    .services-search-button {
        display: inline-flex;
        min-width: 128px;
        height: 52px;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 999px;
        background: var(--jade-600);
        color: #ffffff;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 900;
        box-shadow: 0 12px 26px rgba(0, 168, 132, 0.24);
        transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .services-search-button:hover {
        background: var(--jade-700);
        transform: translateY(-2px);
        box-shadow: 0 16px 34px rgba(0, 168, 132, 0.3);
    }

    .services-filter-label {
        margin-bottom: 14px;
        color: var(--jade-500);
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-align: center;
        text-transform: uppercase;
    }

    .services-filter-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
        align-items: stretch;
    }

    .service-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px -10px rgba(0, 84, 66, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        position: relative;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 168, 132, 0.1);
        border-color: var(--jade-200);
    }
    .service-img-wrap {
        position: relative;
        width: 100%;
        height: 228px;
        overflow: hidden;
        background: var(--jade-50);
        cursor: pointer;
    }
    .service-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .service-card:hover .service-img-wrap img {
        transform: scale(1.08);
    }
    .service-category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--jade-800);
        padding: 6px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        z-index: 10;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .service-icon-fallback {
        width: 100%;
        height: 228px;
        background: linear-gradient(135deg, var(--jade-50), #ffffff);
        background-image:
            radial-gradient(var(--jade-100) 1px, transparent 1px),
            linear-gradient(135deg, var(--jade-50), #ffffff);
        background-size: 18px 18px, 100% 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .service-icon-fallback-badge {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 24px -8px rgba(0, 84, 66, 0.18);
        border: 1px solid var(--jade-100);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    /* Se usa una clase (no el selector de etiqueta "i") porque lucide.createIcons()
       reemplaza <i data-lucide> por un <svg>; un selector "i" deja de aplicar
       en cuanto el ícono se renderiza. */
    .service-icon-fallback-svg {
        width: 34px;
        height: 34px;
        color: var(--jade-500);
        transition: transform 0.4s ease;
    }
    .service-card:hover .service-icon-fallback-badge {
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 16px 32px -8px rgba(0, 84, 66, 0.28);
    }
    .service-card:hover .service-icon-fallback-svg {
        color: var(--jade-700);
    }
    
    .pill {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid var(--jade-200);
        color: var(--jade-700);
        font-weight: 800;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .pill:hover {
        background: var(--jade-50);
        border-color: var(--jade-400);
    }
    .pill.active {
        background: var(--jade-600);
        color: #ffffff;
        border-color: var(--jade-600);
        box-shadow: 0 4px 12px rgba(0, 168, 132, 0.25);
    }
    
    .price-tag {
        font-size: 1.28rem;
        font-weight: 900;
        color: var(--jade-800);
        font-family: 'Outfit', sans-serif;
        white-space: nowrap;
    }
    
    .btn-agendar {
        display: inline-flex;
        width: 100%;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--jade-600);
        color: #ffffff;
        padding: 10px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.86rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 168, 132, 0.2);
    }
    .btn-agendar:hover {
        background: var(--jade-700);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 168, 132, 0.3);
    }
    .btn-details {
        display: inline-flex;
        width: 100%;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        font-size: 0.86rem;
        font-weight: 800;
        border: 2px solid var(--jade-100);
        color: var(--jade-700);
        border-radius: 999px;
        transition: all 0.3s ease;
        background: #ffffff;
        cursor: pointer;
    }
    .btn-details:hover {
        background: var(--jade-50);
        border-color: var(--jade-200);
    }

    .service-card-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 20px;
    }

    .service-title {
        margin-bottom: 9px;
        color: var(--jade-950);
        font-family: 'Outfit', sans-serif;
        font-size: 1.05rem;
        font-weight: 900;
        line-height: 1.16;
    }

    .service-description {
        flex: 1;
        margin-bottom: 18px;
        color: var(--jade-700);
        font-size: 0.86rem;
        line-height: 1.55;
    }

    .service-info {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(204, 238, 230, 0.7);
    }

    .service-info-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 12px;
        align-items: end;
        margin-bottom: 16px;
    }

    .service-meta-label {
        margin-bottom: 5px;
        color: var(--jade-500);
        font-size: 0.66rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .service-duration {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--jade-100);
        border-radius: 999px;
        background: var(--jade-50);
        color: var(--jade-800);
        padding: 6px 9px;
        font-size: 0.78rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .service-duration i {
        width: 15px;
        height: 15px;
    }

    .service-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .services-help {
        margin-top: 58px;
    }

    .services-help-card {
        position: relative;
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        gap: 24px;
        align-items: center;
        overflow: hidden;
        border: 1px solid rgba(0, 168, 132, 0.22);
        border-radius: 30px;
        background:
            linear-gradient(135deg, rgba(234, 251, 247, 0.98), rgba(255, 255, 255, 1)),
            radial-gradient(circle at 12% 20%, rgba(0, 168, 132, 0.13), transparent 28%);
        padding: clamp(24px, 4vw, 34px);
        box-shadow: 0 24px 70px rgba(0, 84, 66, 0.1);
    }

    .services-help-icon {
        display: grid;
        width: 70px;
        height: 70px;
        place-items: center;
        border-radius: 22px;
        background: var(--jade-600);
        color: #ffffff;
        box-shadow: 0 18px 34px rgba(0, 168, 132, 0.28);
    }

    .services-help-icon i {
        width: 34px;
        height: 34px;
    }

    .services-help-text h3 {
        color: var(--jade-950);
        font-family: 'Outfit', sans-serif;
        font-size: clamp(1.5rem, 3vw, 2.25rem);
        font-weight: 900;
        line-height: 1.04;
    }

    .services-help-text p {
        max-width: 660px;
        margin-top: 10px;
        color: var(--jade-800);
        font-size: 0.98rem;
        line-height: 1.65;
    }

    .services-help-button {
        display: inline-flex;
        min-height: 52px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        background: var(--jade-600);
        color: #ffffff;
        padding: 0 22px;
        font-size: 0.92rem;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 14px 30px rgba(0, 168, 132, 0.24);
        transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .services-help-button:hover {
        background: var(--jade-700);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 18px 38px rgba(0, 168, 132, 0.32);
    }

    .services-help-button i {
        width: 19px;
        height: 19px;
    }

    @media (max-width: 1180px) {
        .services-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 860px) {
        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .services-search-form {
            grid-template-columns: 1fr;
        }

        .services-search-button {
            width: 100%;
        }

        .services-help-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .services-help-icon {
            margin: 0 auto;
        }

        .services-help-text p {
            margin-right: auto;
            margin-left: auto;
        }

        .services-help-button {
            width: 100%;
        }
    }

    @media (max-width: 620px) {
        .services-hero {
            padding-top: calc(78px + 42px);
        }

        .services-container {
            width: min(100% - 28px, 520px);
        }

        .services-grid {
            grid-template-columns: 1fr;
        }

        .services-filter-card {
            padding: 18px;
            border-radius: 22px;
        }

        .service-img-wrap,
        .service-icon-fallback {
            height: 240px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="services-hero">
    <div class="container-premium text-center">
        <span class="badge-jade">Catálogo completo</span>
        <h1 class="services-title">Nuestros tratamientos</h1>
        <p class="services-copy">Procedimientos de alta calidad con tecnología de punta y resultados naturales. Elige la opción que mejor se adapte a tu sonrisa.</p>
    </div>
</section>

<section class="services-catalog">
    <div class="services-container">

        <!-- Search + Filters -->
        <div class="services-filter-card">
            <form action="<?php echo e(route('public.servicios')); ?>" method="GET" class="services-search-form">
                <div class="services-search-field">
                    <i data-lucide="search" class="services-search-icon"></i>
                    <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Buscar tratamiento: ortodoncia, blanqueamiento, implantes..."
                           class="services-search-input">
                </div>
                <button type="submit" class="services-search-button">
                    Buscar
                </button>
            </form>

            <div>
                <div class="services-filter-label">Filtrar por categoría</div>
                <div class="services-filter-list">
                    <?php $__currentLoopData = $categoriaFiltros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($filter->url); ?>" class="pill <?php echo e($filter->class ?? ''); ?>">
                            <?php echo e($filter->label); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="services-grid">
            <?php $__empty_1 = true; $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="service-card fade-up" <?php echo 'style="animation-delay: ' . ($loop->index * 0.05) . 's;"'; ?>>
                <?php if($servicio->image): ?>
                <div class="service-img-wrap btn-open-modal"
                     data-name="<?php echo e($servicio->name); ?>"
                     data-desc="<?php echo e($servicio->description); ?>"
                     data-category="<?php echo e($servicio->category); ?>"
                     data-price="<?php echo e($servicio->price); ?>"
                     data-duration="<?php echo e($servicio->duration); ?>"
                     data-img="<?php echo e($servicio->image); ?>"
                     data-wa-url="<?php echo e($servicio->whatsapp_url); ?>">
                    <img src="<?php echo e($servicio->image); ?>" alt="<?php echo e($servicio->name); ?>" loading="lazy">
                    <span class="service-category-badge"><?php echo e($servicio->category); ?></span>
                </div>
                <?php else: ?>
                <div class="service-icon-fallback btn-open-modal cursor-pointer"
                     data-name="<?php echo e($servicio->name); ?>"
                     data-desc="<?php echo e($servicio->description); ?>"
                     data-category="<?php echo e($servicio->category); ?>"
                     data-price="<?php echo e($servicio->price); ?>"
                     data-duration="<?php echo e($servicio->duration); ?>"
                     data-img="<?php echo e($servicio->image); ?>"
                     data-wa-url="<?php echo e($servicio->whatsapp_url); ?>">
                    <span class="service-category-badge"><?php echo e($servicio->category); ?></span>
                    <div class="service-icon-fallback-badge">
                        <i data-lucide="<?php echo e($servicio->category_icon ?? 'activity'); ?>" class="service-icon-fallback-svg"></i>
                    </div>
                </div>
                <?php endif; ?>

                <div class="service-card-body">
                    <h4 class="service-title"><?php echo e($servicio->name); ?></h4>
                    <p class="service-description">
                        <?php echo e($servicio->description_short); ?>

                    </p>

                    <div class="service-info">
                        <div class="service-info-row">
                            <div>
                                <div class="service-meta-label">Duración</div>
                                <div class="service-duration">
                                    <i data-lucide="clock"></i> <?php echo e($servicio->duration); ?> min
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="service-meta-label">Precio</div>
                                <div class="price-tag"><?php echo e($servicio->price_display); ?></div>
                            </div>
                        </div>

                        <div class="service-actions">
                            <button class="btn-open-modal btn-details flex-1"
                                    data-name="<?php echo e($servicio->name); ?>" data-desc="<?php echo e($servicio->description); ?>"
                                    data-category="<?php echo e($servicio->category); ?>" data-price="<?php echo e($servicio->price); ?>"
                                    data-duration="<?php echo e($servicio->duration); ?>" data-img="<?php echo e($servicio->image); ?>"
                                    data-wa-url="<?php echo e($servicio->whatsapp_url); ?>">
                                Detalles
                            </button>
                            <a href="<?php echo e($servicio->whatsapp_url); ?>" target="_blank" class="btn-agendar flex-1">
                                Agendar <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-20 bg-white rounded-[40px] border border-jade-100 shadow-sm text-center">
                <div class="w-20 h-20 bg-jade-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="search-x" class="w-10 h-10 text-jade-400"></i>
                </div>
                <h5 class="font-extrabold text-jade-950 text-2xl mb-3" style="font-family: 'Outfit', sans-serif;">No encontramos tratamientos</h5>
                <p class="text-jade-600 text-lg mb-6">Prueba cambiando el término de búsqueda o selecciona otra categoría.</p>
                <a href="<?php echo e(route('public.servicios')); ?>" class="inline-flex items-center gap-2 bg-jade-100 text-jade-800 px-6 py-3 rounded-full font-bold hover:bg-jade-200 transition">
                    Limpiar filtros
                </a>
            </div>
            <?php endif; ?>
        </div>

        <div class="services-help">
            <div class="services-help-card">
                <div class="services-help-icon">
                    <i data-lucide="stethoscope"></i>
                </div>
                <div class="services-help-text">
                    <h3>¿No sabes qué tratamiento necesitas?</h3>
                    <p><?php echo e($doctora->trust_text); ?></p>
                </div>
                <a href="<?php echo e($doctora->consultation_url); ?>" target="_blank" class="services-help-button">
                    <i data-lucide="calendar-check"></i>
                    <span>Solicitar evaluación</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/public_servicios.blade.php ENDPATH**/ ?>