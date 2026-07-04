<?php $__env->startSection('title', 'Agenda de Citas'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .striking-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }
    
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .table-modern th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        border-top: none;
    }
    .table-modern td {
        padding: 14px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }
    .table-modern tbody tr:hover td {
        background-color: #f8fafc;
    }

    .btn-action-soft {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .btn-edit-soft {
        background-color: #f1f5f9;
        color: #64748b;
    }
    .btn-edit-soft:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    .btn-delete-soft {
        background-color: #fef2f2;
        color: #ef4444;
    }
    .btn-delete-soft:hover {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    .search-pill-inline {
        background: white;
        border-radius: 100px;
        padding: 4px 4px 4px 16px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        width: 100%;
        max-width: 350px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .search-pill-inline input {
        border: none;
        background: transparent;
        outline: none;
        flex-grow: 1;
        font-size: 0.85rem;
        padding-left: 8px;
        color: #334155;
    }
    .search-pill-inline button {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 100px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .avatar-compact {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        color: #0369a1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
    }

    .pagination-modern nav ul.pagination {
        margin-bottom: 0;
        gap: 2px;
    }
    .pagination-modern nav ul.pagination li.page-item .page-link {
        border-radius: 6px;
        border: none;
        color: #475569;
        font-weight: 500;
        padding: 4px 10px;
        font-size: 0.85rem;
        background: transparent;
    }
    .pagination-modern nav ul.pagination li.page-item.active .page-link {
        background-color: var(--primary);
        color: white;
    }

    .active-toggle {
        background-color: var(--primary) !important;
        color: white !important;
    }
    .fc {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .fc .fc-toolbar-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.35rem;
        color: var(--text-main);
    }
    .fc .fc-button-primary {
        background-color: white;
        border-color: var(--border-color);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: capitalize;
        border-radius: 8px;
        box-shadow: none !important;
        transition: all 0.2s;
    }
    .fc .fc-button-primary:hover {
        background-color: #f1f5f9;
        color: var(--text-main);
        border-color: var(--border-color);
    }
    .fc .fc-button-active, .fc .fc-button-primary:active {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }
    .fc .fc-today-button {
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .fc .fc-col-header-cell-cushion {
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-decoration: none;
    }
    .fc .fc-daygrid-day-number {
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.9rem;
        text-decoration: none;
        padding: 6px;
    }
    .fc-event {
        cursor: pointer;
        font-size: 0.8rem;
        padding: 3px 6px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        border: 0 !important;
    }
    .fc-event:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }
    @media (max-width: 768px) {
        .fc-view-harness {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }
        .fc-view-harness .fc-scrollgrid {
            min-width: 640px !important;
        }
    }
    @media (max-width: 576px) {
        .fc .fc-toolbar.fc-header-toolbar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .fc .fc-toolbar.fc-header-toolbar .fc-toolbar-chunk {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .fc .fc-toolbar-title {
            font-size: 1.05rem !important;
            text-align: center !important;
            white-space: nowrap !important;
        }
        .fc .fc-button {
            padding: 4px 8px !important;
            font-size: 0.75rem !important;
        }
        #calendar {
            min-height: 500px !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Agenda de Citas</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Organiza y planifica las consultas y tratamientos odontológicos de la clínica.</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Toggle Buttons -->
            <div class="btn-group border shadow-sm rounded-3 overflow-hidden bg-white" role="group" style="padding: 2px;">
                <button type="button" class="btn btn-sm btn-light px-3 py-2 active-toggle" id="btn-view-calendar" style="border: 0; font-weight: 600; border-radius: 6px;">
                    <i data-lucide="calendar" class="me-1" style="width: 16px; height: 16px;"></i> Calendario
                </button>
                <button type="button" class="btn btn-sm btn-light px-3 py-2 text-muted" id="btn-view-list" style="border: 0; font-weight: 600; border-radius: 6px;">
                    <i data-lucide="list" class="me-1" style="width: 16px; height: 16px;"></i> Lista
                </button>
            </div>
            
            <button type="button" class="btn btn-primary  d-flex align-items-center gap-2" data-ui-toggle="modal" data-ui-target="#createCitaModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s;">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i> Agendar Cita
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert" style="background-color: var(--primary-light); color: var(--primary-hover); border-radius: 12px; padding: 14px 20px;">
            <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
            <div style="font-weight: 500;"><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <!-- ====================================================
         VIEW: CALENDAR
         ==================================================== -->
    <div id="view-calendar-wrapper" class="mb-5">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
            <div class="card-body p-4">
                <!-- Color Legend -->
                <div class="d-flex flex-wrap gap-3 mb-3 justify-content-end" style="font-size: 0.8rem;">
                    <div class="d-flex align-items-center gap-1">
                        <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #3b82f6;"></span>
                        <span class="text-muted fw-medium">Pendiente</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #f59e0b;"></span>
                        <span class="text-muted fw-medium">Confirmada</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #8b5cf6;"></span>
                        <span class="text-muted fw-medium">En Espera</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #22c55e;"></span>
                        <span class="text-muted fw-medium">Completada</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="rounded-circle" style="width: 10px; height: 10px; background-color: #ef4444;"></span>
                        <span class="text-muted fw-medium">Cancelada</span>
                    </div>
                </div>
                <!-- Interactive Calendar Element -->
                <div id="calendar" style="min-height: 650px;"></div>
            </div>
        </div>
    </div>

    <!-- ====================================================
         VIEW: LIST
         ==================================================== -->
    <div id="view-list-wrapper" class="d-none mb-5">
        
        <!-- Search & Filter Bar -->
        <div class="mb-4">
            <form id="filterCitasForm" action="<?php echo e(route('citas.index')); ?>" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                <!-- Search Pill -->
                <div class="search-pill-inline">
                    <i data-lucide="search" style="color: #94a3b8; width: 16px; height: 16px;"></i>
                    <input type="text" name="search" placeholder="Nombre, apellido o DNI..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">Buscar</button>
                </div>
                
                <!-- Filters -->
                <select name="status" class="form-select bg-white shadow-sm filter-auto-submit" style="width: auto; border-radius: 100px; font-size: 0.85rem; border: 1px solid #e2e8f0; cursor: pointer; padding-left: 16px; padding-right: 32px;">
                    <option value="Todas" <?php echo e(request('status') === 'Todas' ? 'selected' : ''); ?>>Todos los Estados</option>
                    <option value="pendiente" <?php echo e(request('status') === 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                    <option value="confirmada" <?php echo e(request('status') === 'confirmada' ? 'selected' : ''); ?>>Confirmada</option>
                    <option value="en_espera" <?php echo e(request('status') === 'en_espera' ? 'selected' : ''); ?>>En Espera</option>
                    <option value="completada" <?php echo e(request('status') === 'completada' ? 'selected' : ''); ?>>Completada</option>
                    <option value="cancelada" <?php echo e(request('status') === 'cancelada' ? 'selected' : ''); ?>>Cancelada</option>
                </select>

                <input type="date" name="date" class="form-control bg-white shadow-sm filter-auto-submit" style="width: auto; border-radius: 100px; font-size: 0.85rem; border: 1px solid #e2e8f0; cursor: pointer; padding-left: 16px;" value="<?php echo e(request('date')); ?>">

                <?php if(request('search') || (request('status') && request('status') !== 'Todas') || request('date')): ?>
                    <a href="<?php echo e(route('citas.index')); ?>" class="btn btn-light d-inline-flex align-items-center justify-content-center" style="border-radius: 100px; font-size: 0.85rem; border: 1px solid #e2e8f0;">
                        <i data-lucide="x" style="width: 14px; height: 14px; margin-right: 4px;"></i> Limpiar
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Listing Card -->
        <div class="striking-card">
            <?php if($citas->isEmpty()): ?>
                <div class="text-center p-5">
                    <div class="p-3 mx-auto mb-3 bg-light rounded-circle text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i data-lucide="calendar-x" style="width: 30px; height: 30px;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #0f172a;">Sin resultados</h5>
                    <p class="text-muted" style="font-size: 0.9rem;">No se encontraron citas agendadas que coincidan con la búsqueda.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th class="ps-4">Paciente</th>
                                <th>Fecha y Hora</th>
                                <th>Tratamiento</th>
                                <th>Odontóloga</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $pacienteNombre = $cita->paciente?->nombre ?? '(sin nombre)';
                                    $pacienteApellido = $cita->paciente?->apellido ?? '';
                                    $pacienteDni = $cita->paciente?->dni ?? '—';
                                    $pacienteTel = $cita->paciente?->telefono ?? '';
                                    $servicioNombre = $cita->servicio?->nombre ?? '(sin tratamiento)';
                                    $docNombre = $cita->doctora?->user?->name ?? '(sin asignar)';
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-compact">
                                                <?php echo e(strtoupper(substr($pacienteNombre, 0, 1) . substr($pacienteApellido, 0, 1))); ?>

                                            </div>
                                            <div>
                                                <h6 class="mb-0" style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">
                                                    <?php echo e($pacienteNombre); ?> <?php echo e($pacienteApellido); ?>

                                                </h6>
                                                <code style="font-size: 0.75rem; color: #64748b; background: transparent;">DNI: <?php echo e($pacienteDni); ?></code>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold" style="color: #334155;">
                                            <?php echo e(\Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y')); ?>

                                        </div>
                                        <div class="text-primary" style="font-size: 0.8rem; font-weight: 600;">
                                            <?php echo e(\Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A')); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-slate-700 fw-medium" style="font-size: 0.85rem;">
                                            <i data-lucide="activity" style="width: 14px; height: 14px; color: #64748b;"></i>
                                            <?php echo e($servicioNombre); ?>

                                        </span>
                                    </td>
                                    <td class="text-muted" style="font-size: 0.85rem;">
                                        <?php echo e($docNombre); ?>

                                    </td>
                                    <td>
                                        <?php
                                            $badgeBg = match($cita->estado) {
                                                'completada' => 'bg-success text-white',
                                                'confirmada' => 'bg-warning text-dark',
                                                'en_espera'  => 'bg-secondary text-white',
                                                'pendiente'  => 'bg-info text-white',
                                                default      => 'bg-danger text-white',
                                            };
                                        ?>
                                        <span class="badge <?php echo e($badgeBg); ?>" style="font-size: 0.65rem; border-radius: 6px; padding: 4px 8px; text-transform: uppercase;">
                                            <?php echo e($cita->estado); ?>

                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <!-- Action Edit Modal -->
                                            <button type="button" class="btn-action-soft btn-edit-soft edit-cita-btn"
                                                data-ui-toggle="modal"
                                                data-ui-target="#editCitaModal"
                                                data-id="<?php echo e($cita->id); ?>"
                                                data-update-url="<?php echo e(route('citas.update', ['id' => $cita->id])); ?>"
                                                data-paciente-id="<?php echo e($cita->paciente_id); ?>"
                                                data-paciente-nombre="<?php echo e($pacienteNombre); ?> <?php echo e($pacienteApellido); ?>"
                                                data-paciente-telefono="<?php echo e($pacienteTel); ?>"
                                                data-doctora-id="<?php echo e($cita->doctora_id); ?>"
                                                data-doctora-nombre="<?php echo e($docNombre); ?>"
                                                data-servicio-id="<?php echo e($cita->servicio_id); ?>"
                                                data-servicio-nombre="<?php echo e($servicioNombre); ?>"
                                                data-fecha-hora="<?php echo e(str_replace(' ', 'T', $cita->fecha_hora)); ?>"
                                                data-motivo="<?php echo e($cita->motivo); ?>"
                                                data-diagnostico="<?php echo e($cita->diagnostico); ?>"
                                                data-notas="<?php echo e($cita->notas_tratamiento); ?>"
                                                data-estado="<?php echo e($cita->estado); ?>"
                                                title="Editar Cita">
                                                <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>
                                            </button>

                                            <!-- Soft Delete Cancel Appointment -->
                                            <form action="<?php echo e(route('citas.destroy', $cita->id)); ?>" method="POST" class="m-0 p-0" data-axios-delete data-axios-no-reload="true" data-confirm="¿Está seguro de cancelar esta cita?">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-action-soft btn-delete-soft" title="Cancelar Cita">
                                                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-light py-2 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2 border-top">
                    <div class="text-slate-500" style="font-size: 0.8rem;">
                        Mostrando <strong class="text-dark"><?php echo e($citas->firstItem() ?? 0); ?></strong> a <strong class="text-dark"><?php echo e($citas->lastItem() ?? 0); ?></strong> de <strong class="text-dark"><?php echo e($citas->total()); ?></strong>
                    </div>
                    <div class="pagination-modern">
                        <?php echo e($citas->links()); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: AGENDAR CITA
     ============================================== -->
<div class="modal fade" id="createCitaModal" tabindex="-1" aria-labelledby="createCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="createCitaModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Agendar Nueva Cita
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo e(route('citas.store')); ?>" method="POST" data-axios-submit data-axios-reset="true" data-axios-no-reload="true" data-axios-close-modal="true">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Paciente -->
                        <div class="col-12">
                            <label for="create_paciente_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Paciente <span class="text-primary">*</span></label>
                            <select name="paciente_id" id="create_paciente_id" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="" disabled selected>Seleccione un paciente...</option>
                                <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($paciente->id); ?>"><?php echo e($paciente->nombre); ?> <?php echo e($paciente->apellido); ?> (DNI: <?php echo e($paciente->dni); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Odontologa -->
                        <div class="col-12 col-sm-6">
                            <label for="create_doctora_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Odontóloga <span class="text-primary">*</span></label>
                            <select name="doctora_id" id="create_doctora_id" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <?php $__currentLoopData = $doctoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($doc->id); ?>"><?php echo e($doc->user->name); ?> - <?php echo e($doc->especialidad); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Servicio -->
                        <div class="col-12 col-sm-6">
                            <label for="create_servicio_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Tratamiento <span class="text-primary">*</span></label>
                            <select name="servicio_id" id="create_servicio_id" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="" disabled selected>Seleccione tratamiento...</option>
                                <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($serv->id); ?>"><?php echo e($serv->nombre); ?> (S/. <?php echo e(number_format($serv->precio, 2)); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Fecha y Hora -->
                        <div class="col-12">
                            <label for="create_fecha_hora" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha y Hora <span class="text-primary">*</span></label>
                            <input type="datetime-local" name="fecha_hora" id="create_fecha_hora" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Motivo -->
                        <div class="col-12">
                            <label for="create_motivo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Motivo / Descripción de consulta</label>
                            <textarea name="motivo" id="create_motivo" rows="2" class="form-control" placeholder="Ej. Dolor en molar inferior izquierdo, control brackets..." style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>

                        <!-- estado Inicial -->
                        <div class="col-12">
                            <label for="create_estado" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">estado Inicial <span class="text-primary">*</span></label>
                            <select name="estado" id="create_estado" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="pendiente" selected>Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_espera">En Espera</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Agendar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: EDITAR / DETALLE CITA (CLINICAL LOGS & WHATSAPP)
     ============================================== -->
<div class="modal fade" id="editCitaModal" tabindex="-1" aria-labelledby="editCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="editCitaModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Detalle e Historial de Cita
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editCitaForm" action="" method="POST" data-axios-submit data-axios-no-reload="true" data-axios-close-modal="true">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Left Panel: Summary & WhatsApp -->
                        <div class="col-12 col-md-5 border-end border-light-subtle pe-md-4">
                            <!-- Diagnostic Header -->
                            <div class="p-4 rounded-4 mb-4" style="background: linear-gradient(145deg, var(--jade-50), #ffffff); border: 1px solid var(--jade-100);">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px; background: #ffffff; color: var(--jade-600); border: 1px solid var(--jade-100);">
                                        <i data-lucide="user" style="width: 22px; height: 22px;"></i>
                                    </div>
                                    <div>
                                        <span class="d-block text-jade-600 text-uppercase fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Paciente Actual</span>
                                        <span class="fw-bold text-slate-800 d-block lh-sm" id="display_paciente_nombre" style="font-size: 1.1rem; font-family: 'Outfit', sans-serif;">Paciente</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px; background: #ffffff; color: var(--jade-500); border: 1px solid var(--jade-100);">
                                        <i data-lucide="activity" style="width: 22px; height: 22px;"></i>
                                    </div>
                                    <div>
                                        <span class="d-block text-jade-600 text-uppercase fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Tratamiento Actual</span>
                                        <span class="fw-medium text-slate-700 d-block lh-sm" id="display_servicio_nombre" style="font-size: 0.95rem;">Tratamiento</span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px; background: #ffffff; color: var(--jade-500); border: 1px solid var(--jade-100);">
                                        <i data-lucide="stethoscope" style="width: 22px; height: 22px;"></i>
                                    </div>
                                    <div>
                                        <span class="d-block text-jade-600 text-uppercase fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Atendido por</span>
                                        <span class="text-slate-700 d-block lh-sm" id="display_doctora_nombre" style="font-size: 0.95rem;">Odontóloga</span>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Reminder Share -->
                            <div class="p-4 rounded-4" style="background: rgba(37, 211, 102, 0.05); border: 1px solid rgba(37, 211, 102, 0.2);">
                                <h6 class="fw-bold d-flex align-items-center gap-2 mb-2" style="color: #128C7E; font-size: 0.9rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                                    Recordatorio WhatsApp
                                </h6>
                                <p class="text-muted mb-3" style="font-size: 0.8rem; line-height: 1.5;">Notifica al paciente sobre su cita programada con un mensaje personalizado.</p>
                                <button type="button" class="btn w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 transition" id="whatsapp-reminder-btn" style="background-color: #25D366; color: white; border: none; border-radius: 10px; font-size: 0.85rem; box-shadow: 0 4px 12px rgba(37,211,102,0.2);">
                                    <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                                    Enviar Recordatorio
                                </button>
                            </div>
                        </div>

                        <!-- Right Panel: Core Editable Fields -->
                        <div class="col-12 col-md-7 ps-md-4">
                            <div class="row g-3">
                                <!-- Paciente Select -->
                                <div class="col-12">
                                    <label for="edit_paciente_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Paciente <span class="text-primary">*</span></label>
                                    <select name="paciente_id" id="edit_paciente_id" class="form-select" required style="border-radius: 8px; height: 40px; border-color: var(--border-color); font-size: 0.85rem;">
                                        <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($paciente->id); ?>"><?php echo e($paciente->nombre); ?> <?php echo e($paciente->apellido); ?> (DNI: <?php echo e($paciente->dni); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Odontologa Select -->
                                <div class="col-12 col-sm-6">
                                    <label for="edit_doctora_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Odontóloga <span class="text-primary">*</span></label>
                                    <select name="doctora_id" id="edit_doctora_id" class="form-select" required style="border-radius: 8px; height: 40px; border-color: var(--border-color); font-size: 0.85rem;">
                                        <?php $__currentLoopData = $doctoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($doc->id); ?>"><?php echo e($doc->user->name); ?> - <?php echo e($doc->especialidad); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Servicio Select -->
                                <div class="col-12 col-sm-6">
                                    <label for="edit_servicio_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Tratamiento <span class="text-primary">*</span></label>
                                    <select name="servicio_id" id="edit_servicio_id" class="form-select" required style="border-radius: 8px; height: 40px; border-color: var(--border-color); font-size: 0.85rem;">
                                        <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($serv->id); ?>"><?php echo e($serv->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Fecha y Hora -->
                                <div class="col-12 col-sm-6">
                                    <label for="edit_fecha_hora" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha y Hora <span class="text-primary">*</span></label>
                                    <input type="datetime-local" name="fecha_hora" id="edit_fecha_hora" class="form-control" required style="border-radius: 8px; height: 40px; border-color: var(--border-color); font-size: 0.85rem;">
                                </div>

                                <!-- estado -->
                                <div class="col-12 col-sm-6">
                                    <label for="edit_estado" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">estado de Cita <span class="text-primary">*</span></label>
                                    <select name="estado" id="edit_estado" class="form-select" required style="border-radius: 8px; height: 40px; border-color: var(--border-color); font-size: 0.85rem;">
                                        <option value="pendiente">Pendiente</option>
                                        <option value="confirmada">Confirmada</option>
                                        <option value="en_espera">En Espera</option>
                                        <option value="completada">Completada</option>
                                        <option value="cancelada">Cancelada</option>
                                    </select>
                                </div>

                                <!-- Motivo -->
                                <div class="col-12">
                                    <label for="edit_motivo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Motivo de Consulta</label>
                                    <textarea name="motivo" id="edit_motivo" rows="2" class="form-control" style="border-radius: 8px; border-color: var(--border-color); font-size: 0.85rem;"></textarea>
                                </div>

                                <!-- Clinical Logs: Diagnostico -->
                                <div class="col-12">
                                    <label for="edit_diagnostico" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Diagnóstico Dental</label>
                                    <textarea name="diagnostico" id="edit_diagnostico" rows="2" class="form-control" placeholder="Ej. Caries penetrante en pieza 16, gingivitis localizada..." style="border-radius: 8px; border-color: var(--border-color); font-size: 0.85rem;"></textarea>
                                </div>

                                <!-- Clinical Logs: Notas de Tratamiento -->
                                <div class="col-12">
                                    <label for="edit_notas" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Procedimiento / Notas del Tratamiento</label>
                                    <textarea name="notas_tratamiento" id="edit_notas" rows="2" class="form-control" placeholder="Ej. Remoción de caries, colocación de resina compuesta 3M en pieza 16..." style="border-radius: 8px; border-color: var(--border-color); font-size: 0.85rem;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js" defer></script>
<script>
    // Base URL for citas update - generated by Blade to ensure correct prefix
    const CITAS_UPDATE_BASE_URL = '<?php echo e(url("/admin/citas")); ?>';
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle view logic
        const btnViewCalendar = document.getElementById('btn-view-calendar');
        const btnViewList = document.getElementById('btn-view-list');
        const viewCalendarWrapper = document.getElementById('view-calendar-wrapper');
        const viewListWrapper = document.getElementById('view-list-wrapper');

        btnViewCalendar.addEventListener('click', function() {
            btnViewCalendar.classList.add('active-toggle');
            btnViewCalendar.classList.remove('text-muted');
            btnViewList.classList.remove('active-toggle');
            btnViewList.classList.add('text-muted');
            viewCalendarWrapper.classList.remove('d-none');
            viewListWrapper.classList.add('d-none');
            
            // Re-render calendar to fix sizing issues
            if (window.calendarObj) {
                window.calendarObj.render();
            }
        });

        btnViewList.addEventListener('click', function() {
            btnViewList.classList.add('active-toggle');
            btnViewList.classList.remove('text-muted');
            btnViewCalendar.classList.remove('active-toggle');
            btnViewCalendar.classList.add('text-muted');
            viewCalendarWrapper.classList.add('d-none');
            viewListWrapper.classList.remove('d-none');
        });

        // Parse search query to switch default view to list if filtering
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search') || urlParams.has('status')) {
            btnViewList.click();
        }

        // Initialize FullCalendar
        const calendarEl = document.getElementById('calendar');
        const createCitaModal = window.miradentModal('#createCitaModal');
        const editCitaModal = window.miradentModal('#editCitaModal');

        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                firstDay: 1,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                events: '<?php echo e(route("citas.api")); ?>',
                editable: false,
                selectable: true,
                select: function(info) {
                    // When selecting a date/slot, pre-populate create modal datetime-local
                    const startStr = info.startStr;
                    // Format appropriately for datetime-local
                    let localDateTime = startStr;
                    if (startStr.length === 10) {
                        localDateTime = startStr + 'T09:00';
                    } else {
                        localDateTime = startStr.substring(0, 16);
                    }
                    document.getElementById('create_fecha_hora').value = localDateTime;
                    createCitaModal.show();
                },
                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    populateEditModal(info.event.id, props);
                    editCitaModal.show();
                }
            });
            calendar.render();
            window.calendarObj = calendar;
        }

        // Modal Populate Handler
        function populateEditModal(id, props) {
            const editForm = document.getElementById('editCitaForm');
            // Use URL pre-generated by Blade (from list view) or build from base URL (from calendar)
            editForm.action = props.updateUrl || (CITAS_UPDATE_BASE_URL + '/' + id);
            
            // Set dynamic header titles
            document.getElementById('display_paciente_nombre').textContent = props.paciente_nombre;
            document.getElementById('display_servicio_nombre').textContent = props.servicio_nombre;
            document.getElementById('display_doctora_nombre').textContent = props.doctora_nombre;
            
            // Set select values
            document.getElementById('edit_paciente_id').value = props.paciente_id;
            if (document.getElementById('edit_paciente_id').tomselect) {
                document.getElementById('edit_paciente_id').tomselect.setValue(props.paciente_id, true);
            }
            
            document.getElementById('edit_doctora_id').value = props.doctora_id;
            if (document.getElementById('edit_doctora_id').tomselect) {
                document.getElementById('edit_doctora_id').tomselect.setValue(props.doctora_id, true);
            }
            
            document.getElementById('edit_servicio_id').value = props.servicio_id;
            if (document.getElementById('edit_servicio_id').tomselect) {
                document.getElementById('edit_servicio_id').tomselect.setValue(props.servicio_id, true);
            }
            
            // Set editable form inputs
            document.getElementById('edit_fecha_hora').value = props.fecha_hora_formatted.substring(0, 16);
            document.getElementById('edit_estado').value = props.estado;
            document.getElementById('edit_motivo').value = props.motivo ?? '';
            document.getElementById('edit_diagnostico').value = props.diagnostico ?? '';
            
            // support notes mapping from either list view dataset or calendar props JSON
            document.getElementById('edit_notas').value = props.notes ?? props.notas_tratamiento ?? '';
            
            // Configure WhatsApp button click handler
            const whatsappBtn = document.getElementById('whatsapp-reminder-btn');
            whatsappBtn.onclick = function() {
                if (!props.paciente_telefono) {
                    alert('Este paciente no tiene registrado un número telefónico.');
                    return;
                }
                
                // Format friendly date and time separately in Spanish
                const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                const timeOptions = { hour: '2-digit', minute: '2-digit' };
                const parsedDate = new Date(document.getElementById('edit_fecha_hora').value);
                const dateStr = parsedDate.toLocaleDateString('es-ES', dateOptions);
                const timeStr = parsedDate.toLocaleTimeString('es-ES', timeOptions);

                // Get selected texts dynamically to reflect any changes made on editing
                const pacienteSelect = document.getElementById('edit_paciente_id');
                const selectedPacienteName = pacienteSelect.options[pacienteSelect.selectedIndex].text.split(' (DNI:')[0];
                
                const servicioSelect = document.getElementById('edit_servicio_id');
                const selectedServicioName = servicioSelect.options[servicioSelect.selectedIndex].text;

                // Sanitize phone number (Peru prefix)
                let phone = props.paciente_telefono.replace(/\D/g, '');
                if (phone.length === 9) {
                    phone = '51' + phone;
                }

                // Construct text template matching exact user spec
                const messageText = `Hola ${selectedPacienteName}. Te recordamos tu cita odontológica en Miradent el ${dateStr} a las ${timeStr} para tu tratamiento de ${selectedServicioName}. ¡Por favor confírmanos tu asistencia!`;
                
                // Generate WhatsApp URL
                const waUrl = `https://wa.me/${phone}?text=${encodeURIComponent(messageText)}`;
                window.open(waUrl, '_blank');
            };
        }

        // Add event handlers to list view buttons
        bindListEditButtons();

        // Initialize TomSelect on dropdowns for better searching
        const selectSelectors = [
            '#create_paciente_id', '#create_doctora_id', '#create_servicio_id',
            '#edit_paciente_id', '#edit_doctora_id', '#edit_servicio_id'
        ];
        
        selectSelectors.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    controlInput: '<input autocomplete="off">'
                });
            }
        });

        // Sync Axios with Calendar and List View
        document.body.addEventListener('miradent:form-success', async function(e) {
            // Update Calendar
            if (window.calendarObj) {
                window.calendarObj.refetchEvents();
            }

            // Update List View silently via AJAX
            try {
                const response = await fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                });
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const currentList = document.querySelector('#view-list-wrapper .striking-card');
                const newList = doc.querySelector('#view-list-wrapper .striking-card');
                
                if (currentList && newList) {
                    currentList.innerHTML = newList.innerHTML;
                    // Re-bind edit buttons in the new HTML
                    bindListEditButtons();
                }
            } catch (err) {
                console.error('Failed to sync list view:', err);
                if (typeof showMiradentAlert === 'function') {
                    showMiradentAlert('Fallo al refrescar la lista de citas', 'warning');
                }
            }
        });

        // Filter Form AJAX Submission
        const filterForm = document.getElementById('filterCitasForm');
        if (filterForm) {
            // Bind auto-submitting inputs
            document.querySelectorAll('.filter-auto-submit').forEach(input => {
                input.addEventListener('change', () => filterForm.dispatchEvent(new Event('submit', { cancelable: true })));
            });

            filterForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const url = new URL(this.action);
                const formData = new FormData(this);
                url.search = new URLSearchParams(formData).toString();

                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                    });
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');

                    const currentList = document.querySelector('#view-list-wrapper .striking-card');
                    const newList = doc.querySelector('#view-list-wrapper .striking-card');

                    if (currentList && newList) {
                        currentList.innerHTML = newList.innerHTML;
                        bindListEditButtons();
                        // URL sólo cambia después de una respuesta exitosa
                        history.pushState({ filterUrl: url.toString() }, '', url);
                    }
                } catch (err) {
                    console.error('Failed to apply filters:', err);
                    if (typeof showMiradentAlert === 'function') {
                        showMiradentAlert('Error al aplicar los filtros', 'danger');
                    }
                }
            });

            window.addEventListener('popstate', async function(e) {
                const url = (e.state && e.state.filterUrl) ? e.state.filterUrl : window.location.href;
                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                    });
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');

                    const currentList = document.querySelector('#view-list-wrapper .striking-card');
                    const newList = doc.querySelector('#view-list-wrapper .striking-card');

                    if (currentList && newList) {
                        currentList.innerHTML = newList.innerHTML;
                        bindListEditButtons();
                    }

                    // Sincronizar inputs del filtro con la URL actual
                    const params = new URLSearchParams(window.location.search);
                    filterForm.querySelectorAll('[name]').forEach(input => {
                        const val = params.get(input.name) ?? '';
                        if (input.tagName === 'SELECT') {
                            input.value = val;
                        } else {
                            input.value = val;
                        }
                    });
                } catch (err) {
                    console.error('Failed to restore filters on popstate:', err);
                }
            });
        }

        function bindListEditButtons() {
            document.querySelectorAll('.edit-cita-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const props = {
                        updateUrl: this.getAttribute('data-update-url'),
                        paciente_id: this.getAttribute('data-paciente-id'),
                        paciente_nombre: this.getAttribute('data-paciente-nombre'),
                        paciente_telefono: this.getAttribute('data-paciente-telefono'),
                        doctora_id: this.getAttribute('data-doctora-id'),
                        doctora_nombre: this.getAttribute('data-doctora-nombre'),
                        servicio_id: this.getAttribute('data-servicio-id'),
                        servicio_nombre: this.getAttribute('data-servicio-nombre'),
                        fecha_hora_formatted: this.getAttribute('data-fecha-hora'),
                        motivo: this.getAttribute('data-motivo'),
                        diagnostico: this.getAttribute('data-diagnostico'),
                        notas_tratamiento: this.getAttribute('data-notas'),
                        estado: this.getAttribute('data-estado')
                    };
                    populateEditModal(id, props);
                });
            });
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/citas.blade.php ENDPATH**/ ?>