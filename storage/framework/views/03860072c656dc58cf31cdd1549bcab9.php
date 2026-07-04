<?php $__env->startSection('title', 'Testimonios'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1" style="font-weight: 700; color: var(--text-main);">Testimonios de Pacientes</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Gestiona las reseñas y comentarios que se muestran en el sitio público.</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2"
                data-ui-toggle="modal" data-ui-target="#createTestimonioModal"
                style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i> Nuevo Testimonio
        </button>
    </div>

    <!-- Alerts -->
    <?php if(session('success')): ?>
        <div class="alert border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert"
             style="background-color: var(--primary-light); color: var(--primary-hover); border-radius: 12px; padding: 14px 20px;">
            <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
            <div style="font-weight: 500;"><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
        <div class="card-body p-4">
            <form action="<?php echo e(route('testimonios.index')); ?>" method="GET" class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group" style="flex-wrap: nowrap;">
                        <span class="input-group-text bg-light border-end-0 text-muted px-3" style="border-radius: 10px 0 0 10px; border-color: var(--border-color);">
                            <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0 shadow-none"
                               placeholder="Buscar por nombre o testimonio..."
                               value="<?php echo e($search); ?>"
                               style="border-radius: 0 10px 10px 0; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="status" class="form-select bg-white shadow-none"
                            style="border-radius: 10px; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                        <option value="Todas" <?php echo e($status === null || $status === 'Todas' ? 'selected' : ''); ?>>Todos los estados</option>
                        <option value="activas"   <?php echo e($status === 'activas'   ? 'selected' : ''); ?>>Visibles</option>
                        <option value="inactivas" <?php echo e($status === 'inactivas' ? 'selected' : ''); ?>>Ocultos</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"
                            style="background-color: var(--primary); border-color: var(--primary); height: 42px; border-radius: 10px; font-weight: 500;">
                        Filtrar
                    </button>
                    <?php if($search || ($status && $status !== 'Todas')): ?>
                        <a href="<?php echo e(route('testimonios.index')); ?>"
                           class="btn btn-light border d-flex align-items-center justify-content-center"
                           style="height: 42px; width: 50px; border-radius: 10px; color: var(--text-muted);">
                            <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de testimonios -->
    <?php if($testimonios->isEmpty()): ?>
        <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
            <div class="p-4 mx-auto mb-4" style="background-color: var(--primary-light); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-lucide="message-square" style="width: 40px; height: 40px;"></i>
            </div>
            <h4 style="font-weight: 600; font-family: 'Outfit', sans-serif;">Sin testimonios</h4>
            <p class="text-muted">No se encontraron testimonios con los filtros actuales.</p>
            <?php if($search || ($status && $status !== 'Todas')): ?>
                <a href="<?php echo e(route('testimonios.index')); ?>" class="btn btn-outline-secondary px-4 mt-2" style="border-radius: 10px;">Limpiar Filtros</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php $__currentLoopData = $testimonios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                        <div class="card-body p-4 d-flex flex-column gap-3">

                            <!-- Estado + Estrellas -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="color: #f59e0b; font-size: 1rem; letter-spacing: 2px;">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php echo $i <= $testimonio->estrellas ? '★' : '☆'; ?>

                                    <?php endfor; ?>
                                </div>
                                <?php if($testimonio->activo): ?>
                                    <span class="badge" style="font-size: 0.75rem; border-radius: 8px; padding: 5px 10px; background-color: var(--primary-light); color: var(--primary);">
                                        Visible
                                    </span>
                                <?php else: ?>
                                    <span class="badge" style="font-size: 0.75rem; border-radius: 8px; padding: 5px 10px; background-color: #f1f5f9; color: #64748b;">
                                        Oculto
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Texto -->
                            <p class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.6; flex: 1;">
                                "<?php echo e(Str::limit($testimonio->testimonio, 140)); ?>"
                            </p>

                            <!-- Paciente y fecha -->
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--border-color) !important;">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-main);"><?php echo e($testimonio->nombre_paciente); ?></div>
                                    <?php if($testimonio->fecha): ?>
                                        <div style="font-size: 0.78rem; color: #94a3b8;"><?php echo e($testimonio->fecha->format('d/m/Y')); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button"
                                            class="btn btn-sm d-flex align-items-center justify-content-center"
                                            style="width: 34px; height: 34px; border-radius: 8px; background: var(--primary-light); color: var(--primary); border: none;"
                                            data-testimonio="<?php echo e(json_encode($testimonio)); ?>"
                                            onclick="openEditModal(this.dataset.testimonio)"
                                            title="Editar">
                                        <i data-lucide="pencil" style="width: 15px; height: 15px;"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm d-flex align-items-center justify-content-center"
                                            style="width: 34px; height: 34px; border-radius: 8px; background: #fef2f2; color: #ef4444; border: none;"
                                            data-id="<?php echo e($testimonio->id); ?>"
                                            data-nombre="<?php echo e($testimonio->nombre_paciente); ?>"
                                            onclick="confirmDelete(this.dataset.id, this.dataset.nombre)"
                                            title="Eliminar">
                                        <i data-lucide="trash-2" style="width: 15px; height: 15px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="createTestimonioModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif;">Nuevo Testimonio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('testimonios.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body px-4 py-3 d-flex flex-column gap-3">
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Nombre del Paciente</label>
                        <input type="text" name="nombre_paciente" class="form-control" required maxlength="120"
                               placeholder="Ej. María López" style="border-radius: 10px;">
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Testimonio</label>
                        <textarea name="testimonio" class="form-control" rows="4" required maxlength="1000"
                                  placeholder="Escribe el comentario del paciente..."
                                  style="border-radius: 10px; resize: none;"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Calificación</label>
                            <select name="estrellas" class="form-select" style="border-radius: 10px;">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e($i === 5 ? 'selected' : ''); ?>><?php echo e($i); ?> ★</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Fecha</label>
                            <input type="date" name="fecha" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" style="border-radius: 10px;">
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Visibilidad</label>
                        <select name="activo" class="form-select" style="border-radius: 10px;">
                            <option value="1">Visible en el sitio</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600;">
                        Guardar Testimonio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editTestimonioModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif;">Editar Testimonio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTestimonioForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body px-4 py-3 d-flex flex-column gap-3">
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Nombre del Paciente</label>
                        <input type="text" name="nombre_paciente" id="edit_nombre" class="form-control" required maxlength="120" style="border-radius: 10px;">
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Testimonio</label>
                        <textarea name="testimonio" id="edit_testimonio" class="form-control" rows="4" required maxlength="1000"
                                  style="border-radius: 10px; resize: none;"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Calificación</label>
                            <select name="estrellas" id="edit_estrellas" class="form-select" style="border-radius: 10px;">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?> ★</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Fecha</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control" style="border-radius: 10px;">
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Visibilidad</label>
                        <select name="activo" id="edit_activo" class="form-select" style="border-radius: 10px;">
                            <option value="1">Visible en el sitio</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600;">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminar -->
<div class="modal fade" id="deleteTestimonioModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow text-center p-4" style="border-radius: 20px;">
            <div class="mx-auto mb-3" style="width: 56px; height: 56px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="trash-2" style="width: 26px; height: 26px; color: #ef4444;"></i>
            </div>
            <h6 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">¿Eliminar testimonio?</h6>
            <p class="text-muted mb-3" style="font-size: 0.85rem;" id="deleteTestimonioName"></p>
            <form id="deleteTestimonioForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4" style="border-radius: 10px; font-weight: 600;">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function openEditModal(testimonioData) {
        const t = JSON.parse(testimonioData);
        document.getElementById('edit_nombre').value    = t.nombre_paciente;
        document.getElementById('edit_testimonio').value = t.testimonio;
        document.getElementById('edit_estrellas').value = t.estrellas;
        document.getElementById('edit_fecha').value     = t.fecha ?? '';
        document.getElementById('edit_activo').value    = t.activo ? '1' : '0';
        document.getElementById('editTestimonioForm').action = '/testimonios/' + t.id;
        const modal = new bootstrap.Modal(document.getElementById('editTestimonioModal'));
        modal.show();
    }

    function confirmDelete(id, nombre) {
        document.getElementById('deleteTestimonioName').textContent = nombre;
        document.getElementById('deleteTestimonioForm').action = '/testimonios/' + id;
        const modal = new bootstrap.Modal(document.getElementById('deleteTestimonioModal'));
        modal.show();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/testimonios.blade.php ENDPATH**/ ?>