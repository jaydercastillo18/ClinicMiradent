<?php $__env->startSection('title', 'La Doctora | Miradent Chimbote'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* ── HERO ────────────────────────────────────────── */
    .hero-doctora {
        padding: calc(78px + 72px) 0 80px;
        background:
            linear-gradient(170deg, #eafbf7 0%, #ffffff 65%),
            repeating-linear-gradient(90deg, rgba(0,168,132,0.04) 0 1px, transparent 1px 92px);
        border-bottom: 1px solid rgba(0,84,66,0.08);
        overflow: hidden;
        position: relative;
    }
    .hero-doctora::before {
        content: '';
        position: absolute;
        top: -120px; right: -120px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,168,132,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
        width: min(1100px, calc(100% - 40px));
        margin: 0 auto;
    }
    @media (max-width: 860px) {
        .hero-grid { grid-template-columns: 1fr; gap: 40px; }
        .hero-img-col { order: -1; }
    }

    /* Foto con decoraciones */
    .photo-frame {
        position: relative;
        display: flex;
        justify-content: center;
    }
    .photo-frame::before {
        content: '';
        position: absolute;
        inset: -16px;
        border-radius: 40px;
        background: linear-gradient(135deg, var(--jade-200), var(--jade-50));
        z-index: 0;
    }
    .photo-frame img {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 400px;
        border-radius: 32px;
        object-fit: cover;
        box-shadow: 0 32px 80px rgba(0,84,66,0.18);
        display: block;
    }
    .photo-badge {
        position: absolute;
        z-index: 2;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--jade-900);
        white-space: nowrap;
    }
    .photo-badge.badge-top { top: 24px; right: -16px; }
    .photo-badge.badge-bottom { bottom: 24px; left: -16px; }
    .photo-badge-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    @media (max-width: 600px) {
        .photo-badge { display: none; }
        .photo-frame::before { display: none; }
    }

    /* Info hero */
    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--jade-50);
        border: 1px solid var(--jade-200);
        color: var(--jade-700);
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 20px;
    }
    .hero-name {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(2.2rem, 4.5vw, 3.6rem);
        font-weight: 900;
        color: var(--jade-950);
        line-height: 1.05;
        margin-bottom: 8px;
    }
    .hero-specialty {
        font-size: 1.1rem;
        color: var(--jade-600);
        font-weight: 600;
        margin-bottom: 20px;
    }
    .hero-cop {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--jade-900);
        color: #fff;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 24px;
    }
    .hero-bio {
        font-size: 1.02rem;
        line-height: 1.8;
        color: var(--jade-800);
        margin-bottom: 32px;
    }
    .hero-btns {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .btn-jade-solid {
        display: inline-flex; align-items: center; gap: 10px;
        background: var(--jade-600); color: #fff;
        padding: 14px 28px; border-radius: 14px;
        font-weight: 800; font-size: 0.95rem;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(0,168,132,0.3);
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .btn-jade-solid:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,168,132,0.4); color: #fff; }
    .btn-jade-outline {
        display: inline-flex; align-items: center; gap: 10px;
        background: transparent; color: var(--jade-700);
        border: 2px solid var(--jade-300);
        padding: 14px 28px; border-radius: 14px;
        font-weight: 700; font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s;
    }
    .btn-jade-outline:hover { background: var(--jade-50); border-color: var(--jade-500); color: var(--jade-800); }

    /* ── STATS ───────────────────────────────────────── */
    .stats-band {
        background: linear-gradient(135deg, var(--jade-900) 0%, #022c22 100%);
        padding: 48px 0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        width: min(1100px, calc(100% - 40px));
        margin: 0 auto;
    }
    @media (max-width: 760px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    .stat-item {
        text-align: center;
        padding: 20px 16px;
        border-right: 1px solid rgba(255,255,255,0.1);
    }
    .stat-item:last-child { border-right: none; }
    .stat-num {
        font-family: 'Outfit', sans-serif;
        font-size: 2.6rem;
        font-weight: 900;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 6px;
    }
    .stat-num span { color: var(--jade-400); }
    .stat-label {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.65);
        font-weight: 500;
        line-height: 1.4;
    }

    /* ── SECCIONES ───────────────────────────────────── */
    .section-doctora {
        padding: 80px 0;
    }
    .section-doctora.alt { background: #f8fdfb; }
    .container-doctora {
        width: min(1100px, calc(100% - 40px));
        margin: 0 auto;
    }
    .section-label {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--jade-50); color: var(--jade-700);
        border: 1px solid var(--jade-100);
        padding: 5px 14px; border-radius: 999px;
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        margin-bottom: 14px;
    }
    .section-title {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(1.7rem, 3.5vw, 2.5rem);
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 16px;
        line-height: 1.15;
    }
    .section-sub {
        font-size: 1.05rem;
        color: var(--jade-700);
        line-height: 1.7;
        max-width: 640px;
    }

    /* Especialidades */
    .especialidades-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 48px;
    }
    @media (max-width: 760px) { .especialidades-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 500px) { .especialidades-grid { grid-template-columns: 1fr; } }
    .esp-card {
        background: #fff;
        border: 1px solid rgba(0,84,66,0.1);
        border-radius: 20px;
        padding: 28px 24px;
        transition: all 0.3s ease;
    }
    .esp-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(0,168,132,0.12);
        border-color: var(--jade-300);
    }
    .esp-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: var(--jade-50);
        display: flex; align-items: center; justify-content: center;
        color: var(--jade-600);
        margin-bottom: 16px;
    }
    .esp-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 8px;
    }
    .esp-desc {
        font-size: 0.88rem;
        color: var(--jade-700);
        line-height: 1.6;
    }

    /* Formación */
    .formacion-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 48px;
    }
    @media (max-width: 640px) { .formacion-grid { grid-template-columns: 1fr; } }
    .formacion-item {
        background: #fff;
        border: 1px solid rgba(0,84,66,0.08);
        border-radius: 20px;
        padding: 28px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .formacion-dot {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: var(--jade-50);
        display: flex; align-items: center; justify-content: center;
        color: var(--jade-600);
        flex-shrink: 0;
    }
    .formacion-year {
        font-size: 0.75rem;
        color: var(--jade-500);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .formacion-titulo {
        font-weight: 800;
        color: var(--jade-950);
        font-size: 0.98rem;
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .formacion-lugar {
        font-size: 0.85rem;
        color: var(--jade-600);
    }

    /* Filosofia / valores */
    .valores-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 48px;
    }
    @media (max-width: 760px) { .valores-grid { grid-template-columns: 1fr; } }
    .valor-card {
        background: #fff;
        border-radius: 24px;
        padding: 36px 28px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,84,66,0.06);
        transition: transform 0.3s;
    }
    .valor-card:hover { transform: translateY(-5px); }
    .valor-icon {
        width: 64px; height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--jade-50), var(--jade-100));
        display: flex; align-items: center; justify-content: center;
        color: var(--jade-600);
        margin: 0 auto 20px;
    }
    .valor-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--jade-950);
        margin-bottom: 10px;
    }
    .valor-desc {
        font-size: 0.9rem;
        color: var(--jade-700);
        line-height: 1.65;
    }

    /* Quote */
    .quote-section {
        background: linear-gradient(135deg, var(--jade-800) 0%, var(--jade-950) 100%);
        padding: 80px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .quote-section::before {
        content: '"';
        position: absolute;
        top: -40px; left: 50%;
        transform: translateX(-50%);
        font-size: 20rem;
        color: rgba(255,255,255,0.03);
        font-family: Georgia, serif;
        line-height: 1;
        pointer-events: none;
    }
    .quote-text {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 700;
        color: #fff;
        max-width: 800px;
        margin: 0 auto 24px;
        line-height: 1.4;
        position: relative;
    }
    .quote-author {
        font-size: 0.9rem;
        color: var(--jade-300);
        font-weight: 600;
    }

    /* CTA final */
    .cta-section {
        padding: 100px 20px;
        text-align: center;
        background: #fff;
    }
    .cta-title {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 900;
        color: var(--jade-950);
        margin-bottom: 16px;
    }
    .cta-sub {
        font-size: 1.05rem;
        color: var(--jade-700);
        margin-bottom: 36px;
        max-width: 520px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-doctora">
    <div class="hero-grid">

        
        <div class="hero-img-col photo-frame fade-up">
            <img src="<?php echo e($doctora->avatar); ?>" alt="<?php echo e($doctora->name); ?>">

            <div class="photo-badge badge-top">
                <div class="photo-badge-icon" style="background:#eafbf7;">
                    <i data-lucide="award" style="width:20px;height:20px;color:var(--jade-600);"></i>
                </div>
                <div>
                    <div style="font-size:0.7rem;color:#64748b;font-weight:600;">Colegiada</div>
                    <div><?php echo e($doctora->cop ?: 'COP 50039'); ?></div>
                </div>
            </div>

            <div class="photo-badge badge-bottom">
                <div class="photo-badge-icon" style="background:#fff7ed;">
                    <i data-lucide="star" style="width:20px;height:20px;color:#f59e0b;"></i>
                </div>
                <div>
                    <div style="font-size:0.7rem;color:#64748b;font-weight:600;">Calificación</div>
                    <div>5.0 ★ Google</div>
                </div>
            </div>
        </div>

        
        <div class="fade-up" style="animation-delay:0.15s;">
            <div class="hero-tag">
                <i data-lucide="stethoscope" style="width:14px;height:14px;"></i>
                Odontóloga de Confianza
            </div>

            <h1 class="hero-name"><?php echo e($doctora->name ?: 'Dra. Miranda'); ?></h1>

            <?php if($doctora->specialty): ?>
                <p class="hero-specialty"><?php echo e($doctora->specialty); ?></p>
            <?php else: ?>
                <p class="hero-specialty">Odontología General y Estética Dental</p>
            <?php endif; ?>

            <div class="hero-cop">
                <i data-lucide="shield-check" style="width:13px;height:13px;"></i>
                <?php echo e($doctora->cop ?: 'COP 50039'); ?> — Habilitada
            </div>

            <p class="hero-bio">
                <?php echo e($doctora->bio ?: 'Especialista en estética dental, rehabilitación oral y diseño de sonrisa con más de 6 años de experiencia. En Miradent, cada tratamiento está pensado para devolverte la confianza y la salud de tu sonrisa.'); ?>

            </p>

            <div class="hero-btns">
                <a href="<?php echo e($doctora->whatsapp_url); ?>" target="_blank" class="btn-jade-solid">
                    <i data-lucide="calendar-check" style="width:18px;height:18px;"></i>
                    Agendar Evaluación
                </a>
                <a href="<?php echo e(route('public.servicios')); ?>" class="btn-jade-outline">
                    <i data-lucide="list" style="width:18px;height:18px;"></i>
                    Ver Tratamientos
                </a>
            </div>
        </div>
    </div>
</section>


<section class="stats-band">
    <div class="stats-grid">
        <div class="stat-item fade-up">
            <div class="stat-num">6<span>+</span></div>
            <div class="stat-label">Años de<br>Experiencia</div>
        </div>
        <div class="stat-item fade-up" style="animation-delay:0.1s;">
            <div class="stat-num">500<span>+</span></div>
            <div class="stat-label">Pacientes<br>Atendidos</div>
        </div>
        <div class="stat-item fade-up" style="animation-delay:0.2s;">
            <div class="stat-num">5<span>★</span></div>
            <div class="stat-label">Calificación<br>en Google</div>
        </div>
        <div class="stat-item fade-up" style="animation-delay:0.3s;">
            <div class="stat-num">100<span>%</span></div>
            <div class="stat-label">Compromiso<br>con el Paciente</div>
        </div>
    </div>
</section>


<section class="section-doctora">
    <div class="container-doctora">
        <div class="fade-up">
            <div class="section-label"><i data-lucide="sparkles" style="width:13px;height:13px;"></i> Áreas de Especialización</div>
            <h2 class="section-title">Lo que la Dra. Miranda<br>hace por tu sonrisa</h2>
            <p class="section-sub">Tratamientos integrales que combinan estética, función y salud bucal con tecnología moderna.</p>
        </div>

        <div class="especialidades-grid">
            <div class="esp-card fade-up">
                <div class="esp-icon"><i data-lucide="smile" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Estética Dental</div>
                <div class="esp-desc">Diseño de sonrisa, carillas, blanqueamiento y restauraciones con resultados naturales.</div>
            </div>
            <div class="esp-card fade-up" style="animation-delay:0.08s;">
                <div class="esp-icon"><i data-lucide="align-center" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Ortodoncia</div>
                <div class="esp-desc">Brackets metálicos, cerámicos y alineadores invisibles para corregir tu mordida.</div>
            </div>
            <div class="esp-card fade-up" style="animation-delay:0.16s;">
                <div class="esp-icon"><i data-lucide="zap" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Endodoncia</div>
                <div class="esp-desc">Tratamiento de conductos para salvar dientes con infección o daño pulpar severo.</div>
            </div>
            <div class="esp-card fade-up" style="animation-delay:0.24s;">
                <div class="esp-icon"><i data-lucide="layers" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Implantes Dentales</div>
                <div class="esp-desc">Solución permanente y de alta calidad para dientes perdidos con materiales biocompatibles.</div>
            </div>
            <div class="esp-card fade-up" style="animation-delay:0.32s;">
                <div class="esp-icon"><i data-lucide="shield" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Odontología Preventiva</div>
                <div class="esp-desc">Limpiezas, selladores y flúor para proteger tu salud bucal a largo plazo.</div>
            </div>
            <div class="esp-card fade-up" style="animation-delay:0.40s;">
                <div class="esp-icon"><i data-lucide="users" style="width:26px;height:26px;"></i></div>
                <div class="esp-title">Atención Familiar</div>
                <div class="esp-desc">Cuidamos a niños, jóvenes y adultos con paciencia, calidez y trato personalizado.</div>
            </div>
        </div>
    </div>
</section>


<section class="section-doctora alt">
    <div class="container-doctora">
        <div class="fade-up">
            <div class="section-label"><i data-lucide="graduation-cap" style="width:13px;height:13px;"></i> Formación Académica</div>
            <h2 class="section-title">Preparación que<br>respalda cada tratamiento</h2>
            <p class="section-sub">Formación sólida y actualización constante para ofrecerte la mejor odontología.</p>
        </div>

        <div class="formacion-grid">
            <div class="formacion-item fade-up">
                <div class="formacion-dot">
                    <i data-lucide="book-open" style="width:22px;height:22px;"></i>
                </div>
                <div>
                    <div class="formacion-year">Título Universitario</div>
                    <div class="formacion-titulo">Cirujano Dentista</div>
                    <div class="formacion-lugar">Universidad Nacional del Santa — Chimbote</div>
                </div>
            </div>

            <div class="formacion-item fade-up" style="animation-delay:0.1s;">
                <div class="formacion-dot">
                    <i data-lucide="award" style="width:22px;height:22px;"></i>
                </div>
                <div>
                    <div class="formacion-year">Habilitación Profesional</div>
                    <div class="formacion-titulo">Colegio Odontológico del Perú</div>
                    <div class="formacion-lugar"><?php echo e($doctora->cop ?: 'COP 50039'); ?> — Activa</div>
                </div>
            </div>

            <div class="formacion-item fade-up" style="animation-delay:0.2s;">
                <div class="formacion-dot">
                    <i data-lucide="sparkles" style="width:22px;height:22px;"></i>
                </div>
                <div>
                    <div class="formacion-year">Especialización</div>
                    <div class="formacion-titulo">Estética Dental y Diseño de Sonrisa</div>
                    <div class="formacion-lugar">Cursos y talleres nacionales certificados</div>
                </div>
            </div>

            <div class="formacion-item fade-up" style="animation-delay:0.3s;">
                <div class="formacion-dot">
                    <i data-lucide="refresh-cw" style="width:22px;height:22px;"></i>
                </div>
                <div>
                    <div class="formacion-year">Actualización Constante</div>
                    <div class="formacion-titulo">Capacitaciones en Ortodoncia e Implantes</div>
                    <div class="formacion-lugar">Congresos y diplomados anuales</div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-doctora">
    <div class="container-doctora">
        <div class="text-center fade-up" style="margin-bottom:0;">
            <div class="section-label" style="margin:0 auto 14px;"><i data-lucide="heart" style="width:13px;height:13px;"></i> Mi Filosofía</div>
            <h2 class="section-title" style="margin:0 auto 14px;">Por qué mis pacientes<br>confían en mí</h2>
            <p class="section-sub" style="margin:0 auto;">Tres pilares que guían cada consulta y cada tratamiento en Miradent.</p>
        </div>

        <div class="valores-grid">
            <div class="valor-card fade-up">
                <div class="valor-icon">
                    <i data-lucide="shield-check" style="width:30px;height:30px;"></i>
                </div>
                <div class="valor-title">Seguridad ante todo</div>
                <div class="valor-desc">Equipos esterilizados, materiales certificados y protocolos de bioseguridad en cada atención sin excepción.</div>
            </div>
            <div class="valor-card fade-up" style="animation-delay:0.12s;">
                <div class="valor-icon">
                    <i data-lucide="heart-handshake" style="width:30px;height:30px;"></i>
                </div>
                <div class="valor-title">Trato personalizado</div>
                <div class="valor-desc">Escucho tus miedos, entiendo tus necesidades y diseño un plan de tratamiento hecho especialmente para ti.</div>
            </div>
            <div class="valor-card fade-up" style="animation-delay:0.24s;">
                <div class="valor-icon">
                    <i data-lucide="trending-up" style="width:30px;height:30px;"></i>
                </div>
                <div class="valor-title">Resultados reales</div>
                <div class="valor-desc">Mi trabajo habla por sí solo. Cada sonrisa transformada es el mejor testimonio de mi compromiso con la excelencia.</div>
            </div>
        </div>
    </div>
</section>


<section class="quote-section">
    <div class="quote-text fade-up">
        "Mi misión es devolverte la confianza de sonreír sin miedo.
        Porque una sonrisa sana es el mejor accesorio que puedes llevar."
    </div>
    <div class="quote-author fade-up" style="animation-delay:0.2s;">
        — <?php echo e($doctora->name ?: 'Dra. Miranda'); ?>, Fundadora de Miradent
    </div>
</section>


<section class="cta-section">
    <div class="fade-up">
        <div class="section-label" style="margin:0 auto 20px;">
            <i data-lucide="calendar" style="width:13px;height:13px;"></i> Primer Paso
        </div>
        <h2 class="cta-title">¿Lista para transformar<br>tu sonrisa?</h2>
        <p class="cta-sub">Agenda tu evaluación gratuita hoy. Sin compromiso, sin esperas largas. Te atendemos con la misma calidez de siempre.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo e($doctora->whatsapp_url); ?>" target="_blank" class="btn-jade-solid" style="font-size:1.05rem; padding:16px 36px;">
                <i data-lucide="message-circle" style="width:20px;height:20px;"></i>
                Escribir por WhatsApp
            </a>
            <a href="<?php echo e(route('public.reservar-cita')); ?>" class="btn-jade-outline" style="font-size:1.05rem; padding:16px 36px;">
                <i data-lucide="calendar-plus" style="width:20px;height:20px;"></i>
                Reservar Cita Online
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/public_doctora.blade.php ENDPATH**/ ?>