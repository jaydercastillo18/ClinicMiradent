@extends('layouts.plantilla')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge" style="background-color: var(--primary-light); color: var(--primary); font-weight: 600; font-size: 0.75rem; padding: 6px 12px; border-radius: 20px;">
                    Configuración de Acceso
                </span>
            </div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main); font-family: 'Outfit', sans-serif;">
                Gestión de Usuarios
            </h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">
                Administra las cuentas de la clínica (Doctora y Asistentes).
            </p>
        </div>
        <div>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-ui-toggle="modal" data-ui-target="#newUsuarioModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s; box-shadow: 0 4px 10px rgba(32, 127, 84, 0.2);">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
                Nuevo Usuario
            </button>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap mb-0" style="font-size: 0.9rem;">
                    <thead style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Usuario</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Email de Acceso</th>
                            <th class="px-4 py-3 text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Nivel de Acceso</th>
                            <th class="px-4 py-3 text-end text-muted border-0" style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                            <tr data-axios-removable style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), #0f5132); font-size: 1.1rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-slate-800" style="font-size: 0.95rem; color: #0f172a;">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-light text-muted border mt-1" style="font-size: 0.7rem; font-weight: 500;">Tú (Sesión Actual)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-muted" style="font-weight: 500;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i data-lucide="mail" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($user->role === 'doctora')
                                        <span class="badge" style="background-color: var(--primary-light); color: var(--primary); padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                            <i data-lucide="shield-check" style="width: 12px; height: 12px; margin-right: 4px; margin-top: -2px;"></i> Doctora (Admin)
                                        </span>
                                    @else
                                        <span class="badge bg-light text-slate-700 border" style="padding: 6px 12px; border-radius: 20px; font-weight: 600;">
                                            <i data-lucide="user" style="width: 12px; height: 12px; margin-right: 4px; margin-top: -2px;"></i> Asistente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm d-flex align-items-center justify-content-center" data-user="{{ $user }}" onclick="openEditUsuarioModal(JSON.parse(this.dataset.user))" style="width: 34px; height: 34px; background-color: #f1f5f9; color: #475569; border: none; border-radius: 8px; transition: all 0.2s;" title="Editar Usuario" onmouseover="this.style.backgroundColor='#e2e8f0'; this.style.color='#0f172a';" onmouseout="this.style.backgroundColor='#f1f5f9'; this.style.color='#475569';">
                                            <i data-lucide="edit-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" data-axios-delete data-confirm="¿Está seguro de que desea eliminar a este usuario? Ya no podrá acceder al sistema." class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background-color: #fef2f2; color: #ef4444; border: none; border-radius: 8px; transition: all 0.2s;" title="Eliminar Usuario" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#dc2626';" onmouseout="this.style.backgroundColor='#fef2f2'; this.style.color='#ef4444';">
                                                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background-color: #f1f5f9; color: #94a3b8;">
                                            <i data-lucide="users" style="width: 32px; height: 32px;"></i>
                                        </div>
                                        <p class="mb-0 fw-medium" style="color: #475569;">No hay otros usuarios registrados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="newUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="background-color: #f8fafc; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                    <i data-lucide="user-plus" class="text-primary" style="width: 22px; height: 22px;"></i>
                    Nuevo Usuario
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" style="border-radius: 50%; box-shadow: none;"></button>
            </div>
            <form action="{{ route('usuarios.store') }}" method="POST" data-axios-submit data-axios-reset="true" data-axios-refresh="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre Completo</label>
                        <input type="text" name="name" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Correo Electrónico (Login)</label>
                        <input type="email" name="email" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Contraseña</label>
                        <input type="password" name="password" class="form-control" required minlength="8" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Rol / Nivel de Acceso</label>
                        <select name="role" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                            <option value="asistente">Asistente</option>
                            <option value="doctora">Doctora (Administradora)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" data-ui-dismiss="modal" style="border-radius: 10px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600;">
                        <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-3" style="background-color: #f8fafc; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                    <i data-lucide="edit" class="text-primary" style="width: 22px; height: 22px;"></i>
                    Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" style="border-radius: 50%; box-shadow: none;"></button>
            </div>
            <form id="editUsuarioForm" action="" method="POST" data-axios-submit data-axios-refresh="true">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre Completo</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Correo Electrónico</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiarla" minlength="8" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Rol / Nivel de Acceso</label>
                        <select name="role" id="edit_role" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                            <option value="asistente">Asistente</option>
                            <option value="doctora">Doctora (Administradora)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" data-ui-dismiss="modal" style="border-radius: 10px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600;">
                        <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditUsuarioModal(user) {
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('editUsuarioForm').action = `/admin/usuarios/${user.id}`;
        window.miradentModal('#editUsuarioModal').show();
    }
</script>
@endsection
