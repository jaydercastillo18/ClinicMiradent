<?php $__env->startSection('title', 'Testimonios | Miradent'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .quote-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 28px;
        padding: 32px;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px -10px rgba(0, 84, 66, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        overflow: hidden;
    }
    .quote-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 168, 132, 0.08);
        border-color: var(--jade-200);
    }
    .quote-icon {
        position: absolute;
        top: -10px;
        right: -10px;
        color: rgba(0, 168, 132, 0.05);
        width: 120px;
        height: 120px;
        z-index: 0;
        transform: rotate(10deg);
    }
    .quote-content {
        position: relative;
        z-index: 1;
    }
    .empty-state-card {
        background: linear-gradient(180deg, #ffffff 0%, var(--jade-50) 100%);
        border: 2px dashed var(--jade-200);
        border-radius: 40px;
        padding: 70px 30px;
        max-width: 650px;
        margin: 0 auto;
        box-shadow: 0 20px 40px rgba(0, 84, 66, 0.04);
    }
    .empty-icon-box {
        width: 90px;
        height: 90px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 28px auto;
        box-shadow: 0 15px 30px rgba(0, 168, 132, 0.12);
        color: var(--jade-500);
    }
    .btn-experience {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: #ffffff;
        color: var(--jade-800);
        padding: 18px 40px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 1.1rem;
        border: 2px solid var(--jade-200);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(0,0,0,0.03);
    }
    .btn-experience:hover {
        background: var(--jade-50);
        border-color: var(--jade-400);
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 168, 132, 0.15);
        color: var(--jade-950);
    }
    
    /* Layout Classes para reemplazar Tailwind */
    .testimonios-page-header {
        padding-top: 140px;
        padding-bottom: 48px;
        text-align: center;
    }
    .testimonios-page-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 20px 0 16px 0;
        font-family: 'Outfit', sans-serif;
    }
    .testimonios-page-header p {
        font-size: 1.1rem;
        color: var(--jade-800);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .testimonios-grid-container {
        padding-bottom: 96px;
        max-width: 1152px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .testimonios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 64px;
    }
    .quote-stars {
        display: flex;
        gap: 6px;
        color: #fbbf24;
        margin-bottom: 24px;
    }
    .quote-text {
        font-size: 1.125rem;
        line-height: 1.7;
        color: var(--jade-900);
        font-weight: 500;
        margin-bottom: 32px;
    }
    .quote-author {
        padding-top: 20px;
        border-top: 1px solid rgba(0, 168, 132, 0.15);
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 10;
    }
    .quote-author-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--jade-100), var(--jade-200));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--jade-800);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1.25rem;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }
    .quote-author-name {
        font-weight: 800;
        color: var(--jade-950);
        font-size: 1rem;
    }
    .quote-author-role {
        font-size: 0.6875rem;
        color: var(--jade-500);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }
    .testimonios-action {
        text-align: center;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="testimonios-page-header">
    <div class="container-premium text-center">
        <span class="badge-jade">Lo que dicen nuestros pacientes</span>
        <h1>Testimonios</h1>
        <p>Historias reales de personas que confiaron en nosotros y ahora lucen su mejor sonrisa.</p>
    </div>
</section>

<section class="testimonios-grid-container">
    <div class="container-premium">
        
        <?php if($testimonios->isNotEmpty()): ?>
        <div class="testimonios-grid">
            <?php $__currentLoopData = $testimonios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="quote-card fade-up" <?php echo 'style="animation-delay: ' . ($loop->index * 0.1) . 's;"'; ?>>
                <svg class="quote-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                
                <div class="quote-content">
                    <div class="quote-stars">
                        <?php for($i = 0; $i < ($testimonio->estrellas ?? 5); $i++): ?>
                            <i data-lucide="star" style="width:20px;height:20px; fill:currentColor; filter:drop-shadow(0 1px 1px rgba(0,0,0,0.1));"></i>
                        <?php endfor; ?>
                    </div>
                    <blockquote class="quote-text">
                        "<?php echo e($testimonio->testimonio); ?>"
                    </blockquote>
                </div>
                <div class="quote-author">
                    <div class="quote-author-avatar">
                        <?php echo e(substr($testimonio->nombre_paciente, 0, 1)); ?>

                    </div>
                    <div>
                        <div class="quote-author-name"><?php echo e($testimonio->nombre_paciente); ?></div>
                        <div class="quote-author-role">Paciente Miradent</div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="testimonios-action fade-up">
            <a href="<?php echo e($doctora->whatsapp_url); ?>" target="_blank" class="btn-experience">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px; color:#10b981;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                <span>Compartir mi propia experiencia</span>
            </a>
        </div>
        
        <?php else: ?>
        <div class="empty-state-card text-center fade-up">
            <div class="empty-icon-box">
                <i data-lucide="message-square-heart" style="width:48px;height:48px;"></i>
            </div>
            <h3 style="font-size:2rem; font-weight:800; color:var(--jade-950); margin-bottom:16px; font-family:'Outfit', sans-serif;">Aún no hay testimonios</h3>
            <p style="color:var(--jade-700); font-size:1.1rem; max-width:500px; margin:0 auto 40px auto; line-height:1.6;">Nuestro muro de sonrisas está esperando. ¡Sé el primero en contarnos cómo fue tu atención en Miradent!</p>
            
            <a href="<?php echo e($doctora->whatsapp_url); ?>" target="_blank" class="btn-experience">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px; color:#10b981;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                <span>Escribir mi experiencia por WhatsApp</span>
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/public_testimonios.blade.php ENDPATH**/ ?>