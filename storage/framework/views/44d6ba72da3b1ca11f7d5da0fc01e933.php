<?php $__env->startSection('title', 'Directorio de Pacientes'); ?>

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
        transition: background-color 0.2s;
    }

    .table-modern tbody tr:hover td {
        background-color: #f8fafc;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* Botones de acción suaves y compactos */
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
        transform: translateY(-2px);
    }

    .btn-delete-soft {
        background-color: #fef2f2;
        color: #ef4444;
    }

    .btn-delete-soft:hover {
        background-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-2px);
    }

    .btn-history-soft {
        background-color: #ecfdf5;
        color: #10b981;
        font-weight: 600;
        font-size: 0.8rem;
        border-radius: 8px;
        padding: 6px 12px;
        border: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-history-soft:hover {
        background-color: #d1fae5;
        color: #047857;
        transform: translateY(-2px);
    }

    /* Barra de Búsqueda Flotante - Ajustada */
    .search-pill {
        background: white;
        border-radius: 100px;
        padding: 4px 4px 4px 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 450px;
        transition: all 0.3s;
    }

    .search-pill:focus-within {
        border-color: var(--primary);
        box-shadow: 0 4px 20px rgba(32, 127, 84, 0.1);
    }

    .search-pill input {
        border: none;
        background: transparent;
        outline: none;
        flex-grow: 1;
        font-size: 0.9rem;
        padding-left: 10px;
        color: #334155;
    }

    .search-pill button {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 100px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .search-pill button:hover {
        background: #047857;
    }

    .avatar-modern {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
    }

    .avatar-blue {
        background: #e0f2fe;
        color: #0369a1;
    }

    .avatar-green {
        background: #d1fae5;
        color: #047857;
    }

    .avatar-purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .avatar-orange {
        background: #ffedd5;
        color: #c2410c;
    }

    .avatar-pink {
        background: #fce7f3;
        color: #be185d;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <!-- Top Header -->
    <div class="row align-items-center mb-4 pb-2">
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-light text-primary border" style="font-weight: 700; font-size: 0.7rem; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i data-lucide="users" style="width: 10px; height: 10px; margin-right: 4px;"></i> Directorio
                </span>
            </div>
            <h1 class="mb-1" style="font-weight: 800; color: #0f172a; font-family: 'Outfit', sans-serif; font-size: 1.8rem; letter-spacing: -0.5px;">
                Pacientes
            </h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Administra expedientes y perfiles de contacto.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <div class="col-12 col-md-4 text-md-end">
                <a href="<?php echo e(route('pacientes.create')); ?>" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm btn-create-paciente" style="background: var(--primary); border: none; font-weight: 600; padding: 10px 20px; border-radius: 10px; font-size: 0.9rem;">
                    <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i>
                    Nuevo Paciente
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if(session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border-radius: 10px; padding: 12px 16px; font-size: 0.9rem;">
            <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
            <div style="font-weight: 500;"><?php echo e(session('success')); ?></div>
        </div>
        <?php endif; ?>

        <!-- Search & Filters -->
        <div class="mb-4">
            <form action="<?php echo e(route('pacientes.index')); ?>" method="GET">
                <div class="search-pill">
                    <i data-lucide="search" style="color: #94a3b8; width: 18px; height: 18px;"></i>
                    <input type="text" name="search" placeholder="Escribe un nombre, DNI o teléfono..." value="<?php echo e(request('search')); ?>">
                    <button type="submit">Buscar</button>
                </div>
                <?php if(request('search')): ?>
                <div class="mt-2 ms-2">
                    <a href="<?php echo e(route('pacientes.index')); ?>" class="text-danger d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 500; text-decoration: none;">
                        <i data-lucide="x" style="width: 12px; height: 12px;"></i> Limpiar búsqueda
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Patients Listing Card -->
        <div class="striking-card mb-4">
            <?php if($pacientes->isEmpty()): ?>
            <div class="text-center py-5 px-3">
                <div class="mx-auto mb-3 text-slate-300" style="width: 64px; height: 64px;">
                    <i data-lucide="users" style="width: 100%; height: 100%;"></i>
                </div>
                <?php if(request('search')): ?>
                <h5 style="font-weight: 700; color: #0f172a;">Sin resultados</h5>
                <p class="text-muted mb-4" style="font-size: 0.95rem;">No encontramos a nadie llamado "<strong><?php echo e(request('search')); ?></strong>"</p>
                <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-light btn-sm px-3" style="border-radius: 8px; font-weight: 500;">Volver a la lista</a>
                <?php else: ?>
                <h5 style="font-weight: 700; color: #0f172a;">Agenda vacía</h5>
                <p class="text-muted mb-4" style="font-size: 0.95rem;">Aún no tienes pacientes registrados en el sistema.</p>
                <a href="<?php echo e(route('pacientes.create')); ?>" class="btn btn-primary btn-sm px-3" style="border-radius: 8px; font-weight: 500;">
                    Registrar primer paciente
                </a>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th class="ps-4">Paciente</th>
                            <th>DNI</th>
                            <th>Edad</th>
                            <th>Contacto</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $avatarClasses = ['avatar-blue', 'avatar-green', 'avatar-purple', 'avatar-orange', 'avatar-pink'];
                        ?>
                        <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $colorClass = $avatarClasses[$paciente->id % count($avatarClasses)];
                        ?>
                        <tr id="paciente-row-<?php echo e($paciente->id); ?>">
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-modern <?php echo e($colorClass); ?>">
                                        <?php echo e(strtoupper(substr($paciente->nombre, 0, 1) . substr($paciente->apellido, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #0f172a; font-size: 0.9rem;"><?php echo e($paciente->nombre); ?> <?php echo e($paciente->apellido); ?></h6>
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            Reg: <?php echo e($paciente->created_at->format('d/m/Y')); ?>

                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code style="font-family: monospace; font-size: 0.85rem; font-weight: 600; color: #334155; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    <?php echo e($paciente->dni); ?>

                                </code>
                            </td>
                            <td>
                                <?php if($paciente->fecha_nacimiento): ?>
                                <span style="font-weight: 500; color: #334155; font-size: 0.85rem;"><?php echo e(\Carbon\Carbon::parse($paciente->fecha_nacimiento)->age); ?> años</span>
                                <?php else: ?>
                                <span class="text-muted" style="font-size: 0.8rem; font-style: italic;">N/R</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1" style="font-size: 0.8rem;">
                                    <?php if($paciente->telefono): ?>
                                    <div class="d-flex align-items-center gap-2 text-slate-700">
                                        <i data-lucide="phone" style="width: 12px; height: 12px; color: #64748b;"></i>
                                        <span><?php echo e($paciente->telefono); ?></span>
                                    </div>
                                    <?php endif; ?>

                                    <?php if($paciente->email): ?>
                                    <div class="d-flex align-items-center gap-2 text-slate-500">
                                        <i data-lucide="mail" style="width: 12px; height: 12px;"></i>
                                        <span class="text-truncate" style="max-width: 150px;"><?php echo e($paciente->email); ?></span>
                                    </div>
                                    <?php endif; ?>

                                    <?php if(!$paciente->telefono && !$paciente->email): ?>
                                    <span class="text-slate-400" style="font-style: italic;">Sin contacto</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <!-- Ver Historial -->
                                    <a href="<?php echo e(route('pacientes.show', $paciente->id)); ?>" class="btn-history-soft" title="Ver Expediente">
                                        <i data-lucide="folder-open" style="width: 14px; height: 14px;"></i>
                                        Abrir
                                    </a>

                                    <!-- Editar -->
                                    <a href="<?php echo e(route('pacientes.edit', $paciente->id)); ?>" class="btn-action-soft btn-edit-soft" title="Editar">
                                        <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="<?php echo e(route('pacientes.destroy', $paciente->id)); ?>" method="POST" class="d-inline" data-axios-delete data-axios-no-reload="true" data-axios-remove-target="#paciente-row-<?php echo e($paciente->id); ?>" data-confirm="¿Estás seguro de eliminar a <?php echo e($paciente->nombre); ?>?">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-action-soft btn-delete-soft" title="Eliminar">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="bg-light py-2 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2 border-top" style="border-radius: 0 0 16px 16px;">
                <div class="text-slate-500" style="font-size: 0.8rem;">
                    Mostrando <span class="fw-bold text-dark"><?php echo e($pacientes->firstItem() ?? 0); ?></span> - <span class="fw-bold text-dark"><?php echo e($pacientes->lastItem() ?? 0); ?></span> de <span class="fw-bold text-dark"><?php echo e($pacientes->total()); ?></span>
                </div>
                <div class="pagination-modern mt-3 mt-md-0">
                    <?php echo e($pacientes->links()); ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Modal Dinámico para Crear y Editar Pacientes -->
<div class="modal fade" id="pacienteDynamicModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1060;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="pacienteDynamicModalContent" style="background-color: transparent; border: none; box-shadow: none;">
            <!-- Contenido cargado vía AJAX -->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

    <?php $__env->startSection('scripts'); ?>
    <style>
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

        .pagination-modern nav ul.pagination li.page-item:not(.active) .page-link:hover {
            background-color: #e2e8f0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalElement = document.getElementById('pacienteDynamicModal');
            const modalContent = document.getElementById('pacienteDynamicModalContent');
            
            // MOVER EL MODAL AL BODY PARA EVITAR QUE LA SIDEBAR LO CUBRA
            if (modalElement) {
                document.body.appendChild(modalElement);
            }

            let modalInstance = null;
            if (window.miradentModal) {
                modalInstance = window.miradentModal(modalElement);
            } else if (typeof bootstrap !== 'undefined') {
                modalInstance = new bootstrap.Modal(modalElement);
            }

            // 1. Manejar clicks en Nuevo y Editar
            document.body.addEventListener('click', async function(e) {
                const link = e.target.closest('a.btn-create-paciente, a.btn-edit-soft');
                if (!link) return;

                e.preventDefault();
                const url = link.href;

                modalContent.innerHTML = '<div style="padding:60px;text-align:center;"><div class="spinner-border text-primary" role="status"></div></div>';
                if (modalInstance) modalInstance.show();

                try {
                    const separator = url.includes('?') ? '&' : '?';
                    const response = await fetch(url + separator + 'modal=1', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    modalContent.innerHTML = html;

                    // Re-ejecutar scripts del contenido cargado
                    modalContent.querySelectorAll('script').forEach(oldScript => {
                        const s = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(a => s.setAttribute(a.name, a.value));
                        s.textContent = oldScript.textContent;
                        oldScript.parentNode.replaceChild(s, oldScript);
                    });

                    if (typeof lucide !== 'undefined') lucide.createIcons();

                } catch (err) {
                    modalContent.innerHTML = '<div class="alert alert-danger m-3">Error al cargar el formulario.</div>';
                }
            });

            // Escuchar éxito de formulario para cerrar modal
            document.body.addEventListener('miradent:form-success', function() {
                if (modalInstance) modalInstance.hide();
            });

            // 2. Manejar la búsqueda GET
            const searchForm = document.querySelector('form[action="<?php echo e(route("pacientes.index")); ?>"]');
            if (searchForm) {
                searchForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const btn = searchForm.querySelector('button[type="submit"]');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                    btn.disabled = true;

                    const formData = new FormData(searchForm);
                    const params = new URLSearchParams(formData);
                    const url = searchForm.action + '?' + params.toString();
                    const fetchUrl = '<?php echo e(route("pacientes.buscar")); ?>?' + params.toString();

                    try {
                        const response = await window.axios.get(fetchUrl);
                        renderTable(response.data);

                        // Actualizar URL sin recargar
                        window.history.pushState({}, '', url);
                    } catch (error) {
                        console.error('Search error:', error);
                    } finally {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                });
            }

            // 3. Insertar o actualizar filas en éxito
            document.body.addEventListener('miradent:form-success', function(e) {
                if (e.detail && e.detail.paciente) {
                    const paciente = e.detail.paciente;

                    const existingRow = document.getElementById('paciente-row-' + paciente.id);
                    if (existingRow) {
                        // Flash animation for update
                        existingRow.style.backgroundColor = '#d1fae5';
                        setTimeout(() => {
                            existingRow.replaceWith(createRowNode(paciente));
                        }, 400);
                    } else {
                        const tbody = document.querySelector('.table-modern tbody');
                        if (tbody && !document.getElementById('paciente-row-' + paciente.id)) {
                            // Check if empty state exists and remove it
                            const emptyState = tbody.querySelector('td[colspan="5"]');
                            if (emptyState) emptyState.parentElement.remove();

                            tbody.insertBefore(createRowNode(paciente), tbody.firstChild);
                            const newRow = document.getElementById('paciente-row-' + paciente.id);
                            if (newRow) {
                                newRow.style.backgroundColor = '#e0f2fe';
                                setTimeout(() => newRow.style.backgroundColor = '', 800);
                            }
                        } else if (!tbody) {
                            // Tabla no existe (estado vacío). Refrescar la capa silenciosamente.
                            syncPacientesView();
                        }
                    }
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            });

            async function syncPacientesView() {
                try {
                    const response = await fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');

                    const currentCard = document.querySelector('.striking-card.mb-4');
                    const newCard = doc.querySelector('.striking-card.mb-4');

                    if (currentCard && newCard) {
                        currentCard.innerHTML = newCard.innerHTML;
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                } catch (err) {
                    console.error('Failed to sync pacientes view:', err);
                    if (typeof showMiradentAlert === 'function') {
                        showMiradentAlert('Fallo al refrescar la vista de pacientes', 'warning');
                    }
                }
            }

            function renderTable(data) {
                const pacientes = data.data || data;
                const tbody = document.querySelector('.table-modern tbody');
                if (!tbody) {
                    syncPacientesView();
                    return;
                }

                tbody.innerHTML = ''; // Limpiar usando innerHTML solo para vaciar es seguro

                if (pacientes.length === 0) {
                    const tr = document.createElement('tr');
                    const td = document.createElement('td');
                    td.colSpan = 5;
                    td.className = "text-center py-4 text-muted";
                    td.textContent = "No se encontraron resultados";
                    tr.appendChild(td);
                    tbody.appendChild(tr);
                    return;
                }

                pacientes.forEach(p => tbody.appendChild(createRowNode(p)));
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }

            function createRowNode(p) {
                const initial = (p.nombre.charAt(0) + p.apellido.charAt(0)).toUpperCase();
                const colorClasses = ['avatar-blue', 'avatar-green', 'avatar-purple', 'avatar-orange', 'avatar-pink'];
                const colorClass = colorClasses[p.id % colorClasses.length];

                const tr = document.createElement('tr');
                tr.id = 'paciente-row-' + p.id;
                tr.style.transition = 'background-color 0.8s';

                // Col 1: Avatar & Name
                const td1 = document.createElement('td');
                td1.className = 'ps-4';
                const div1 = document.createElement('div');
                div1.className = 'd-flex align-items-center gap-3';

                const avatar = document.createElement('div');
                avatar.className = `avatar-modern ${colorClass}`;
                avatar.textContent = initial;

                const nameContainer = document.createElement('div');
                const h6 = document.createElement('h6');
                h6.className = 'mb-0';
                h6.style.fontWeight = '700';
                h6.style.color = '#0f172a';
                h6.style.fontSize = '0.9rem';
                h6.textContent = `${p.nombre} ${p.apellido}`;

                const regSpan = document.createElement('span');
                regSpan.className = 'text-muted';
                regSpan.style.fontSize = '0.75rem';
                regSpan.textContent = `Reg: ${p.creado ? p.creado.split(' ')[0] : ''}`;

                nameContainer.appendChild(h6);
                nameContainer.appendChild(regSpan);
                div1.appendChild(avatar);
                div1.appendChild(nameContainer);
                td1.appendChild(div1);

                // Col 2: DNI
                const td2 = document.createElement('td');
                const code = document.createElement('code');
                code.style.fontFamily = 'monospace';
                code.style.fontSize = '0.85rem';
                code.style.fontWeight = '600';
                code.style.color = '#334155';
                code.style.background = '#f8fafc';
                code.style.padding = '2px 6px';
                code.style.borderRadius = '4px';
                code.style.border = '1px solid #e2e8f0';
                code.textContent = p.dni || '';
                td2.appendChild(code);

                // Col 3: Edad
                const td3 = document.createElement('td');
                if (p.edad !== undefined && p.edad !== null) {
                    const edadSpan = document.createElement('span');
                    edadSpan.style.fontWeight = '500';
                    edadSpan.style.color = '#334155';
                    edadSpan.style.fontSize = '0.85rem';
                    edadSpan.textContent = `${p.edad} años`;
                    td3.appendChild(edadSpan);
                } else {
                    const nrSpan = document.createElement('span');
                    nrSpan.className = 'text-muted';
                    nrSpan.style.fontSize = '0.8rem';
                    nrSpan.style.fontStyle = 'italic';
                    nrSpan.textContent = 'N/R';
                    td3.appendChild(nrSpan);
                }

                // Col 4: Contacto
                const td4 = document.createElement('td');
                const contactDiv = document.createElement('div');
                contactDiv.className = 'd-flex flex-column gap-1';
                contactDiv.style.fontSize = '0.8rem';

                if (p.telefono) {
                    const telDiv = document.createElement('div');
                    telDiv.className = 'd-flex align-items-center gap-2 text-slate-700';
                    telDiv.innerHTML = '<i data-lucide="phone" style="width: 12px; height: 12px; color: #64748b;"></i>';
                    const span = document.createElement('span');
                    span.textContent = p.telefono;
                    telDiv.appendChild(span);
                    contactDiv.appendChild(telDiv);
                }
                if (p.email) {
                    const mailDiv = document.createElement('div');
                    mailDiv.className = 'd-flex align-items-center gap-2 text-slate-500';
                    mailDiv.innerHTML = '<i data-lucide="mail" style="width: 12px; height: 12px;"></i>';
                    const span = document.createElement('span');
                    span.className = 'text-truncate';
                    span.style.maxWidth = '150px';
                    span.textContent = p.email;
                    mailDiv.appendChild(span);
                    contactDiv.appendChild(mailDiv);
                }
                if (!p.telefono && !p.email) {
                    const sinContacto = document.createElement('span');
                    sinContacto.className = 'text-slate-400';
                    sinContacto.style.fontStyle = 'italic';
                    sinContacto.textContent = 'Sin contacto';
                    contactDiv.appendChild(sinContacto);
                }
                td4.appendChild(contactDiv);

                // Col 5: Acciones
                const td5 = document.createElement('td');
                td5.className = 'text-end pe-4';
                const actionDiv = document.createElement('div');
                actionDiv.className = 'd-flex justify-content-end align-items-center gap-2';

                const aHistory = document.createElement('a');
                aHistory.href = `/admin/pacientes/${p.id}`;
                aHistory.className = 'btn-history-soft';
                aHistory.title = 'Ver Expediente';
                aHistory.innerHTML = '<i data-lucide="folder-open" style="width: 14px; height: 14px;"></i> Abrir';

                const aEdit = document.createElement('a');
                aEdit.href = `/admin/pacientes/${p.id}/edit`;
                aEdit.className = 'btn-action-soft btn-edit-soft';
                aEdit.title = 'Editar';
                aEdit.innerHTML = '<i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>';

                const form = document.createElement('form');
                form.action = `/admin/pacientes/${p.id}`;
                form.method = 'POST';
                form.className = 'd-inline';
                form.setAttribute('data-axios-delete', '');
                form.setAttribute('data-axios-no-reload', 'true');
                form.setAttribute('data-axios-remove-target', `#paciente-row-${p.id}`);
                form.setAttribute('data-confirm', `¿Estás seguro de eliminar a ${p.nombre}?`);

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                const btnSubmit = document.createElement('button');
                btnSubmit.type = 'submit';
                btnSubmit.className = 'btn-action-soft btn-delete-soft';
                btnSubmit.title = 'Eliminar';
                btnSubmit.innerHTML = '<i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>';

                form.appendChild(csrf);
                form.appendChild(method);
                form.appendChild(btnSubmit);

                actionDiv.appendChild(aHistory);
                actionDiv.appendChild(aEdit);
                actionDiv.appendChild(form);
                td5.appendChild(actionDiv);

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);

                return tr;
            }

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[char]);
            }
        });
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/pacientes.blade.php ENDPATH**/ ?>