@extends('layouts.plantilla')

@section('title', 'Registro de Auditoría')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge" style="background-color: var(--primary-light); color: var(--primary); font-weight: 600; font-size: 0.75rem; padding: 6px 12px; border-radius: 20px;">
                    Módulo de Seguridad
                </span>
            </div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main); font-family: 'Outfit', sans-serif;">
                Registro de Auditoría
            </h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">
                Historial completo de movimientos de datos en la plataforma.
            </p>
        </div>
        <div>
            <button class="btn btn-outline-secondary d-flex align-items-center gap-2" onclick="loadAuditLogs(1)" style="font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s;">
                <i data-lucide="refresh-cw" style="width: 18px; height: 18px;"></i>
                Actualizar
            </button>
        </div>
    </div>

    <!-- Audit Table Card -->
    <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap mb-0" style="font-size: 0.9rem;">
                    <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Fecha y Hora</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Usuario</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Acción</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Módulo (Modelo)</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Dirección IP</th>
                            <th class="px-4 py-3 text-end text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Detalles</th>
                        </tr>
                    </thead>
                    <tbody id="audit-table-body">
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem; color: var(--primary) !important;">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-3 mb-0 fw-medium" style="color: #475569;">Cargando registros de auditoría...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación Asíncrona -->
            <div class="px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                <span class="text-muted fw-medium" id="pagination-info" style="font-size: 0.85rem;">Mostrando resultados...</span>
                <div class="d-flex gap-2">
                    <button id="btn-prev" class="btn btn-sm d-flex align-items-center justify-content-center gap-1" onclick="loadAuditLogs(current_page - 1)" disabled style="background-color: #fff; color: #475569; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-weight: 500; transition: all 0.2s;">
                        <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i> Anterior
                    </button>
                    <button id="btn-next" class="btn btn-sm d-flex align-items-center justify-content-center gap-1" onclick="loadAuditLogs(current_page + 1)" disabled style="background-color: #fff; color: #475569; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-weight: 500; transition: all 0.2s;">
                        Siguiente <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalles Auditoría -->
<div class="modal fade" id="auditDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="background-color: #f8fafc; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                    <i data-lucide="file-code" class="text-primary" style="width: 22px; height: 22px;"></i>
                    Detalles de la Acción
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" style="border-radius: 50%; box-shadow: none;"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <pre id="auditDetailsContent" class="p-3 rounded-3" style="max-height: 400px; overflow-y: auto; font-size: 0.85rem; border: 1px solid #e2e8f0; background-color: #0f172a; color: #e2e8f0; font-family: 'Fira Code', monospace;"></pre>
            </div>
            <div class="modal-footer border-top-0 px-4 pb-4 pt-0 bg-white">
                <button type="button" class="btn btn-primary px-4 d-flex align-items-center gap-2" data-ui-dismiss="modal" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600;">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let current_page = 1;

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);
    }

    function formatAction(action) {
        if (action === 'created') {
            return `<span class="badge d-inline-flex align-items-center gap-1" style="background-color: #ecfdf5; color: #059669; padding: 6px 12px; border-radius: 20px; font-weight: 600;"><i data-lucide="plus-circle" style="width: 14px; height: 14px;"></i> Creado</span>`;
        } else if (action === 'updated') {
            return `<span class="badge d-inline-flex align-items-center gap-1" style="background-color: #fffbeb; color: #d97706; padding: 6px 12px; border-radius: 20px; font-weight: 600;"><i data-lucide="edit-3" style="width: 14px; height: 14px;"></i> Actualizado</span>`;
        } else if (action === 'deleted') {
            return `<span class="badge d-inline-flex align-items-center gap-1" style="background-color: #fef2f2; color: #dc2626; padding: 6px 12px; border-radius: 20px; font-weight: 600;"><i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Eliminado</span>`;
        } else if (action === 'restored') {
            return `<span class="badge d-inline-flex align-items-center gap-1" style="background-color: #f0fdfa; color: #0d9488; padding: 6px 12px; border-radius: 20px; font-weight: 600;"><i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i> Restaurado</span>`;
        } else {
            return `<span class="badge d-inline-flex align-items-center gap-1 bg-light text-secondary border" style="padding: 6px 12px; border-radius: 20px; font-weight: 600;">${escapeHtml(action)}</span>`;
        }
    }

    function formatUser(user) {
        if (user) {
            const name = escapeHtml(user.name || 'Usuario');
            const initial = escapeHtml((user.name || 'U').substring(0, 1).toUpperCase());
            const role = escapeHtml(user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '');
            return `
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, var(--primary), #0f5132); font-size: 1rem;">
                        ${initial}
                    </div>
                    <div>
                        <div class="fw-bold text-slate-800" style="font-size: 0.95rem;">${name}</div>
                        <div class="text-muted" style="font-size: 0.8rem; font-weight: 500;">${role}</div>
                    </div>
                </div>
            `;
        }
        return `
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-secondary bg-light fw-bold shadow-sm border" style="width: 38px; height: 38px; font-size: 1rem;">
                    <i data-lucide="cpu" style="width: 18px; height: 18px;"></i>
                </div>
                <div>
                    <div class="fw-bold text-slate-800" style="font-size: 0.95rem;">Sistema</div>
                    <div class="text-muted" style="font-size: 0.8rem; font-weight: 500;">Automático</div>
                </div>
            </div>
        `;
    }

    function classBasename(namespace) {
        if (!namespace) return '';
        const parts = namespace.split('\\');
        return escapeHtml(parts[parts.length - 1]);
    }

    function loadAuditLogs(page = 1) {
        const tbody = document.getElementById('audit-table-body');
        
        axios.get(`{{ route('auditoria.index') }}?page=${page}`)
            .then(response => {
                const paginator = response.data;
                const logs = paginator.data;
                current_page = paginator.current_page;
                
                tbody.innerHTML = ''; // Safely clear

                if (logs.length === 0) {
                    const tr = document.createElement('tr');
                    const td = document.createElement('td');
                    td.colSpan = 6;
                    td.className = 'text-center py-5 text-muted';
                    td.innerHTML = `
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background-color: #f1f5f9; color: #94a3b8;">
                                <i data-lucide="shield" style="width: 32px; height: 32px;"></i>
                            </div>
                            <p class="mb-0 fw-medium" style="color: #475569;">Aún no hay registros de auditoría</p>
                        </div>
                    `;
                    tr.appendChild(td);
                    tbody.appendChild(tr);
                } else {
                    logs.forEach(log => {
                        const dateObj = new Date(log.created_at);
                        const formattedDate = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                        const formattedTime = dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute:'2-digit' });
                        
                        const safeDetails = log.details ? btoa(unescape(encodeURIComponent(typeof log.details === 'string' ? log.details : JSON.stringify(log.details)))) : '';
                        
                        const tr = document.createElement('tr');
                        tr.style.borderBottom = '1px solid #f1f5f9';
                        tr.style.transition = 'all 0.2s';

                        const tdDate = document.createElement('td');
                        tdDate.className = 'px-4 py-3 fw-medium';
                        tdDate.style.whiteSpace = 'nowrap';
                        tdDate.style.fontSize = '0.85rem';
                        tdDate.textContent = formattedDate;
                        const timeSpan = document.createElement('span');
                        timeSpan.className = 'text-muted ms-1';
                        timeSpan.textContent = formattedTime;
                        tdDate.appendChild(timeSpan);

                        const tdUser = document.createElement('td');
                        tdUser.className = 'px-4 py-3';
                        tdUser.innerHTML = formatUser(log.user); // formatUser is already escaping inputs properly

                        const tdAction = document.createElement('td');
                        tdAction.className = 'px-4 py-3';
                        tdAction.innerHTML = formatAction(log.action); // formatAction uses static html strings

                        const tdModel = document.createElement('td');
                        tdModel.className = 'px-4 py-3';
                        const spanModel = document.createElement('span');
                        spanModel.className = 'fw-bold';
                        spanModel.style.color = '#0f172a';
                        spanModel.textContent = classBasename(log.model_type);
                        const spanId = document.createElement('span');
                        spanId.className = 'badge bg-light text-muted border ms-1';
                        spanId.style.fontSize = '0.7rem';
                        spanId.textContent = '#' + (log.model_id || '');
                        tdModel.appendChild(spanModel);
                        tdModel.appendChild(spanId);

                        const tdIp = document.createElement('td');
                        tdIp.className = 'px-4 py-3 text-muted fw-medium';
                        tdIp.style.fontSize = '0.85rem';
                        tdIp.innerHTML = '<i data-lucide="globe" style="width: 14px; height: 14px; margin-right: 4px; margin-top: -2px; color: #cbd5e1;"></i>';
                        tdIp.appendChild(document.createTextNode(log.ip_address || ''));

                        const tdBtn = document.createElement('td');
                        tdBtn.className = 'px-4 py-3 text-end';
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-sm d-flex align-items-center justify-content-center ms-auto';
                        btn.style.backgroundColor = '#f1f5f9';
                        btn.style.color = '#475569';
                        btn.style.border = 'none';
                        btn.style.borderRadius = '8px';
                        btn.style.padding = '6px 14px';
                        btn.style.fontWeight = '600';
                        btn.style.transition = 'all 0.2s';
                        btn.innerHTML = '<i data-lucide="eye" style="width: 16px; height: 16px; margin-right: 6px;"></i> Ver Data';
                        btn.onmouseover = function() { this.style.backgroundColor='#e2e8f0'; this.style.color='#0f172a'; };
                        btn.onmouseout = function() { this.style.backgroundColor='#f1f5f9'; this.style.color='#475569'; };
                        btn.onclick = function() { viewAuditDetailsDynamic(safeDetails); };
                        tdBtn.appendChild(btn);

                        tr.appendChild(tdDate);
                        tr.appendChild(tdUser);
                        tr.appendChild(tdAction);
                        tr.appendChild(tdModel);
                        tr.appendChild(tdIp);
                        tr.appendChild(tdBtn);

                        tbody.appendChild(tr);
                    });
                }
                
                document.getElementById('pagination-info').innerText = `Mostrando ${paginator.from || 0} a ${paginator.to || 0} de ${paginator.total} registros`;
                document.getElementById('btn-prev').disabled = !paginator.prev_page_url;
                document.getElementById('btn-next').disabled = !paginator.next_page_url;

                if (typeof lucide !== 'undefined') {
                    window.lucide?.createIcons();
                }
            })
            .catch(error => {
                console.error('Error fetching audit logs:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-5 text-danger">
                            <i data-lucide="alert-triangle" style="width: 48px; height: 48px; opacity: 0.5;" class="mb-3"></i>
                            <p class="mb-0 fw-medium">Error al cargar los registros. Por favor, intenta de nuevo.</p>
                        </td>
                    </tr>
                `;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
    }

    function viewAuditDetailsDynamic(base64Data) {
        let rawData = '';
        if (base64Data) {
            try {
                rawData = decodeURIComponent(escape(atob(base64Data)));
            } catch(e) {
                rawData = base64Data;
            }
        }
        
        try {
            const parsed = JSON.parse(rawData);
            document.getElementById('auditDetailsContent').innerText = JSON.stringify(parsed, null, 2);
        } catch (e) {
            document.getElementById('auditDetailsContent').innerText = rawData || 'Sin detalles disponibles.';
        }
        window.miradentModal('#auditDetailsModal').show();
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadAuditLogs();
    });
</script>
@endsection
