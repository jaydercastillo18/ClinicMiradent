@extends('layouts.plantilla')

@section('title', 'Galería de Instalaciones')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Galería de Instalaciones</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Gestiona las fotos de las instalaciones que se muestran en el tour virtual de la página de inicio.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-ui-toggle="modal" data-ui-target="#createInstalacionModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s;">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i> Nueva Foto
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert" style="background-color: var(--primary-light); color: var(--primary-hover); border-radius: 12px; padding: 14px 20px;">
            <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
            <div style="font-weight: 500;">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; padding: 14px 20px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
        <div class="card-body p-4">
            <form action="{{ route('instalaciones.index') }}" method="GET" class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-slate-700" style="font-size: 0.85rem;">Buscar</label>
                    <div class="input-group" style="flex-wrap: nowrap;">
                        <span class="input-group-text bg-light border-end-0 text-muted px-3" style="border-radius: 10px 0 0 10px; border-color: var(--border-color);">
                            <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0 shadow-none" placeholder="Buscar por título..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-medium text-slate-700" style="font-size: 0.85rem;">Estado en Landing</label>
                    <select name="status" class="form-select bg-white" style="background-color: #f2faf6; border-radius: 10px; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                        <option value="Todas" {{ request('status') === 'Todas' ? 'selected' : '' }}>Todas</option>
                        <option value="activas" {{ request('status') === 'activas' ? 'selected' : '' }}>Visibles / Activas</option>
                        <option value="inactivas" {{ request('status') === 'inactivas' ? 'selected' : '' }}>Ocultas / Inactivas</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary); border-color: var(--primary); height: 42px; border-radius: 10px; font-weight: 500;">
                        Filtrar
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('instalaciones.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 42px; width: 50px; border-radius: 10px; color: var(--text-muted);">
                            <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Grid -->
    @if($instalaciones->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
            <div class="p-4 mx-auto mb-4" style="background-color: var(--primary-light); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-lucide="image" style="width: 40px; height: 40px;"></i>
            </div>
            <h4 style="font-weight: 600; font-family: 'Outfit', sans-serif;">Sin fotos en la galería</h4>
            <p class="text-muted">Aún no has subido fotos de las instalaciones para mostrar en la página principal.</p>
        </div>
    @else
        <div class="row g-4 mb-5">
            @foreach($instalaciones as $instalacion)
                <div class="col-12 col-md-6 col-lg-4" data-axios-removable>
                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative {{ !$instalacion->activo ? 'opacity-75' : '' }}" style="border-radius: 16px; border: 1px solid var(--border-color) !important; transition: all 0.2s;">
                        
                        <!-- Order Badge -->
                        <span class="position-absolute top-0 start-0 m-3 badge shadow-sm" style="background-color: var(--primary); color: white; border-radius: 8px; z-index: 10; font-size: 0.75rem; padding: 6px 10px;">
                            Orden: {{ $instalacion->orden }}
                        </span>

                        <!-- Status badge -->
                        @if($instalacion->activo)
                            <span class="position-absolute top-0 end-0 m-3 badge px-3 py-2 shadow-sm text-uppercase fw-bold" style="border-radius: 8px; z-index: 10; font-size: 0.65rem; letter-spacing: 0.5px; background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">
                                Visible
                            </span>
                        @else
                            <span class="position-absolute top-0 end-0 m-3 badge px-3 py-2 shadow-sm text-uppercase fw-bold" style="border-radius: 8px; z-index: 10; font-size: 0.65rem; letter-spacing: 0.5px; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                Oculto
                            </span>
                        @endif

                        <!-- Photo -->
                        <div style="height: 220px; overflow: hidden; background-color: #f8fafc; border-bottom: 1px solid var(--border-color);">
                            @if($instalacion->imagen_path)
                                <img src="{{ asset($instalacion->imagen_path) }}" class="w-100 h-100" style="object-fit: cover;" alt="Instalación" loading="lazy">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted bg-white" style="background-color: #f2faf6; font-size: 0.85rem;">
                                    Sin foto
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold mb-3 text-slate-800 text-center" style="font-family: 'Outfit', sans-serif; font-size: 1.1rem;">
                                {{ $instalacion->titulo ?? 'Sin título' }}
                            </h5>
                            
                            <!-- Actions -->
                            <div class="d-flex align-items-center gap-2 border-top border-light-subtle pt-3 mt-auto">
                                <button type="button" class="btn btn-light border flex-grow-1 d-flex align-items-center justify-content-center gap-2" 
                                    data-ui-toggle="modal" data-ui-target="#editInstalacionModal{{ $instalacion->id }}" style="height: 38px; border-radius: 8px; font-weight: 500; font-size: 0.85rem; color: var(--text-main); background-color: #f8fafc;">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i> Editar
                                </button>
                                <button type="button" class="btn btn-light border text-danger d-flex align-items-center justify-content-center" 
                                    data-ui-toggle="modal" data-ui-target="#deleteInstalacionModal{{ $instalacion->id }}" style="height: 38px; width: 38px; border-radius: 8px; background-color: #fef2f2; border-color: #fecaca !important;" title="Eliminar Foto">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px; color: #dc2626;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editInstalacionModal{{ $instalacion->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                            <div class="modal-header bg-dark text-white border-0 py-3 px-4">
                                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif;">Editar Foto de Instalación</h5>
                                <button type="button" class="btn-close btn-close-white" data-ui-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('instalaciones.update', $instalacion->id) }}" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-refresh="true">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Título (Opcional)</label>
                                        <input type="text" name="titulo" class="form-control" value="{{ $instalacion->titulo }}" placeholder="Ej: Cómoda Sala de Espera" style="border-radius: 10px; height: 42px; font-size: 0.9rem;">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Orden de aparición</label>
                                        <input type="number" name="orden" class="form-control" value="{{ $instalacion->orden }}" style="border-radius: 10px; height: 42px; font-size: 0.9rem;">
                                        <small class="text-muted">Menor número aparece primero (ej: 0, 1, 2)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Reemplazar Foto</label>
                                        <input type="file" name="imagen" class="form-control" style="font-size: 0.8rem; border-radius: 8px;" accept="image/*">
                                        <small class="text-muted">Deja en blanco si no deseas cambiar la foto actual.</small>
                                        @if($instalacion->imagen_path)
                                            <div class="mt-3 text-center">
                                                <img src="{{ asset($instalacion->imagen_path) }}" class="rounded shadow-sm" style="max-height: 120px; max-width: 100%; object-fit: cover;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-slate-700 d-block" style="font-size: 0.85rem;">Estado de Visibilidad</label>
                                        <div class="form-check form-switch mt-2">
                                            <input type="hidden" name="activo" value="0">
                                            <input class="form-check-input" type="checkbox" name="activo" value="1" id="editActivoSwitch{{ $instalacion->id }}" {{ $instalacion->activo ? 'checked' : '' }} style="cursor: pointer; width: 44px; height: 22px;">
                                            <label class="form-check-label ps-2 text-muted" for="editActivoSwitch{{ $instalacion->id }}" style="font-size: 0.85rem;">Mostrar en el carrusel de la página pública</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                                    <button type="button" class="btn btn-light flex-grow-1 border" data-ui-dismiss="modal" style="height: 42px; border-radius: 10px; font-weight: 600;">Cancelar</button>
                                    <button type="submit" class="btn btn-primary flex-grow-1" style="background-color: var(--primary); border-color: var(--primary); height: 42px; border-radius: 10px; font-weight: 600;">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DELETE MODAL -->
                <div class="modal fade" id="deleteInstalacionModal{{ $instalacion->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                            <div class="modal-body p-4 text-center">
                                <div class="text-primary mb-3">
                                    <i data-lucide="alert-triangle" style="width: 48px; height: 48px;"></i>
                                </div>
                                <h5 class="fw-bold mb-2 text-slate-800" style="font-family: 'Outfit', sans-serif;">¿Eliminar esta foto?</h5>
                                <p class="text-muted mb-4" style="font-size: 0.85rem;">Esta acción la removerá de la galería de forma permanente.</p>
                                
                                <form action="{{ route('instalaciones.destroy', $instalacion->id) }}" method="POST" data-axios-delete data-confirm="¿Está seguro de que desea eliminar esta foto?">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-light border w-50" data-ui-dismiss="modal" style="height: 40px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">Cancelar</button>
                                        <button type="submit" class="btn btn-primary w-50" style="height: 40px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- CREATE MODAL -->
<div class="modal fade" id="createInstalacionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-3 px-4">
                <h5 class="modal-title fw-bold" style="font-family: 'Outfit', sans-serif;">Subir Nueva Foto</h5>
                <button type="button" class="btn-close btn-close-white" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('instalaciones.store') }}" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-reset="true" data-axios-refresh="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Título (Opcional)</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Recepción principal" style="border-radius: 10px; height: 42px; font-size: 0.9rem;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Orden de aparición</label>
                        <input type="number" name="orden" class="form-control" value="0" style="border-radius: 10px; height: 42px; font-size: 0.9rem;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-slate-700" style="font-size: 0.85rem;">Foto de Instalación</label>
                        <input type="file" name="imagen" class="form-control" required accept="image/*" style="font-size: 0.8rem; border-radius: 8px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-slate-700 d-block" style="font-size: 0.85rem;">Estado de Visibilidad</label>
                        <div class="form-check form-switch mt-2">
                            <input type="hidden" name="activo" value="0">
                            <input class="form-check-input" type="checkbox" name="activo" value="1" id="activoSwitch" checked style="cursor: pointer; width: 44px; height: 22px;">
                            <label class="form-check-label ps-2 text-muted" for="activoSwitch" style="font-size: 0.85rem;">Mostrar en la página pública inmediatamente</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light flex-grow-1 border" data-ui-dismiss="modal" style="height: 42px; border-radius: 10px; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn btn-primary flex-grow-1" style="background-color: var(--primary); border-color: var(--primary); height: 42px; border-radius: 10px; font-weight: 600;">Subir Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
