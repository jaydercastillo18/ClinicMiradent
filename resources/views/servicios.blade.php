@extends('layouts.plantilla')

@section('title', 'Catálogo de Servicios')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Servicios y Tratamientos</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Administración de tratamientos dentales, tarifas y especialidades.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-ui-toggle="modal" data-ui-target="#createServiceModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s;">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i> Registrar Tratamiento
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

    <!-- Search & Quick Filters -->
    <div class="row g-3 align-items-center justify-content-between mb-4">
        <!-- Category Filter Pills -->
        <div class="col-12 col-xl-8">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('servicios.index', ['search' => request('search')]) }}" class="btn btn-sm pill-filter {{ !request('category') || request('category') === 'Todas' ? 'active' : '' }}">
                    Todas
                </a>
                @foreach(['Prevención', 'Ortodoncia', 'Endodoncia', 'Estética', 'Cirugía', 'Implantes'] as $cat)
                    <a href="{{ route('servicios.index', ['category' => $cat, 'search' => request('search')]) }}" class="btn btn-sm pill-filter {{ request('category') === $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Search input box -->
        <div class="col-12 col-md-6 col-xl-4">
            <form action="{{ route('servicios.index') }}" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="input-group" style="flex-wrap: nowrap;">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3" style="border-radius: 10px 0 0 10px; border-color: var(--border-color);">
                        <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar tratamiento..." value="{{ request('search') }}" style="border-radius: 0; border-color: var(--border-color); height: 42px; font-size: 0.875rem; box-shadow: none;">
                    @if(request('search'))
                        <a href="{{ route('servicios.index', ['category' => request('category')]) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center border-start-0" style="border-color: var(--border-color); border-radius: 0; background-color: var(--bg-content)">
                            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                        </a>
                    @endif
                    <button class="btn btn-primary px-3" type="submit" style="background-color: var(--primary); border-color: var(--primary); border-radius: 0 10px 10px 0; font-weight: 500;">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Catalog Grid -->
    @if($servicios->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
            <div class="p-4 mx-auto mb-4" style="background-color: var(--primary-light); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <i data-lucide="heart-handshake" style="width: 40px; height: 40px;"></i>
            </div>
            <h4 style="font-weight: 600; font-family: 'Outfit', sans-serif;">Sin tratamientos</h4>
            <p class="text-muted">No se encontraron servicios registrados que coincidan con la búsqueda o el filtro actual.</p>
            <div>
                <a href="{{ route('servicios.index') }}" class="btn btn-outline-secondary px-4 mt-2" style="border-radius: 10px;">Limpiar Filtros</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($servicios as $servicio)
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3" data-axios-removable>
                    <div class="card border-0 shadow-sm h-100 service-card position-relative {{ !$servicio->activo ? 'inactive-card' : '' }}" style="border-radius: 16px; border: 1px solid var(--border-color) !important; overflow: hidden; transition: all 0.2s;">
                        
                        <!-- Card Image header -->
                        <div class="service-img-container position-relative service-img-clickable"
                             data-ui-toggle="modal" 
                             data-ui-target="#viewServiceModal"
                             data-id="{{ $servicio->id }}"
                             data-update-url="{{ route('servicios.update', $servicio->id) }}"
                             data-nombre="{{ $servicio->nombre }}"
                             data-categoria="{{ $servicio->categoria }}"
                             data-precio="{{ number_format($servicio->precio, 2) }}"
                             data-precio-raw="{{ $servicio->precio }}"
                             data-duracion="{{ $servicio->duracion_minutos }}"
                             data-descripcion="{{ $servicio->descripcion }}"
                             data-descripcion-raw="{{ $servicio->descripcion }}"
                             data-activo="{{ $servicio->activo ? 'Activo' : 'Inactivo' }}"
                             data-activo-val="{{ $servicio->activo }}"
                             data-created="{{ $servicio->created_at ? $servicio->created_at->format('d/m/Y H:i') : '' }}"
                             data-updated="{{ $servicio->updated_at ? $servicio->updated_at->format('d/m/Y H:i') : '' }}"
                             data-imagen="{{ image_url($servicio->imagen_path, '', 'servicio', $servicio->id) }}"
                             style="height: 160px; overflow: hidden; cursor: pointer; border-bottom: 1px solid var(--border-color);">
                            @if($servicio->imagen_path)
                                <img src="{{ image_url($servicio->imagen_path, '', 'servicio', $servicio->id) }}" alt="{{ $servicio->nombre }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary-light), #e0f2fe); color: var(--primary);">
                                </div>
                            @endif
                            <div class="service-img-overlay">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <i data-lucide="eye" style="width: 24px; height: 24px;"></i>
                                    <span style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Ver Detalles</span>
                                </div>
                            </div>
                        </div>

                        <!-- Top Header inside card -->
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <!-- Category Badge -->
                                @php
                                    $catBg = match($servicio->categoria) {
                                        'Prevención'  => '#e0f2fe',
                                        'Ortodoncia'  => '#e0e7ff',
                                        'Endodoncia'  => '#ffedd5',
                                        'Estética'    => '#fce7f3',
                                        default       => '#ccfbf1',
                                    };
                                    $catColor = match($servicio->categoria) {
                                        'Prevención'  => '#0369a1',
                                        'Ortodoncia'  => '#4338ca',
                                        'Endodoncia'  => '#c2410c',
                                        'Estética'    => '#be185d',
                                        default       => '#0f766e',
                                    };
                                @endphp
                                <span class="badge text-uppercase fw-bold" @style([
                                    'font-size: 0.65rem',
                                    'letter-spacing: 0.5px',
                                    'padding: 5px 10px',
                                    'border-radius: 6px',
                                    "background-color: {$catBg}",
                                    "color: {$catColor}"
                                ])>
                                    {{ $servicio->categoria }}
                                </span>

                                <!-- Status Badge/Indicator -->
                                @if($servicio->activo)
                                    <span class="badge fw-semibold" style="background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: 0.7rem; padding: 4px 8px; border-radius: 20px;">
                                        Activo
                                    </span>
                                @else
                                    <span class="badge fw-semibold" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 0.7rem; padding: 4px 8px; border-radius: 20px;">
                                        Inactivo
                                    </span>
                                @endif
                            </div>

                            <!-- Title & Description -->
                            <h5 class="fw-bold mb-2 text-slate-800" style="font-family: 'Outfit', sans-serif; line-height: 1.3;">{{ $servicio->nombre }}</h5>
                            <p class="text-muted flex-grow-1" style="font-size: 0.85rem; line-height: 1.5;">{{ Str::limit($servicio->descripcion, 100, '...') }}</p>
                            
                            <!-- Cost & Duration Specs -->
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3" style="border-color: rgba(0,0,0,0.05) !important;">
                                <div class="d-flex align-items-center gap-1 text-slate-700" style="font-size: 0.85rem;">
                                    <i data-lucide="clock" class="text-muted" style="width: 16px; height: 16px;"></i>
                                    <span>{{ $servicio->duracion_minutos }} min</span>
                                </div>
                                <div>
                                    <span class="text-muted fw-medium" style="font-size: 0.8rem;">Precio:</span>
                                    <span class="fw-bold text-dark más-1" style="font-size: 1.1rem; font-family: 'Outfit', sans-serif;">S/. {{ number_format($servicio->precio, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Card Actions Menu Footer -->
                        <div class="card-footer bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between border-top">
                            <!-- Quick Edit (Triggers Modal Populator) -->
                            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 px-3 edit-service-btn" 
                                data-ui-toggle="modal" 
                                data-ui-target="#editServiceModal"
                                data-id="{{ $servicio->id }}"
                                data-update-url="{{ route('servicios.update', $servicio->id) }}"
                                data-nombre="{{ $servicio->nombre }}"
                                data-categoria="{{ $servicio->categoria }}"
                                data-precio="{{ $servicio->precio }}"
                                data-duracion="{{ $servicio->duracion_minutos }}"
                                data-descripcion="{{ $servicio->descripcion }}"
                                data-activo="{{ $servicio->activo }}"
                                data-imagen="{{ image_url($servicio->imagen_path, '', 'servicio', $servicio->id) }}"
                                style="border-radius: 8px; font-weight: 500;">
                                <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                Editar
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" data-axios-delete data-confirm="¿Está seguro de que desea eliminar este tratamiento? Las citas agendadas históricas seguirán vinculadas.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center p-2" style="border-radius: 8px;" title="Eliminar Tratamiento">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2 mt-5">
            <span class="text-muted" style="font-size: 0.85rem;">
                Mostrando {{ $servicios->firstItem() }} al {{ $servicios->lastItem() }} de {{ $servicios->total() }} tratamientos
            </span>
            {{ $servicios->links() }}
        </div>
    @endif
</div>

<!-- ==============================================
     MODAL: REGISTRAR SERVICIO
     ============================================== -->
<div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="createServiceModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Registrar Nuevo Tratamiento
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
             <form action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-reset="true" data-axios-refresh="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-12">
                            <label for="create_nombre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre del Tratamiento <span class="text-primary">*</span></label>
                            <input type="text" name="nombre" id="create_nombre" class="form-control" placeholder="Ej. Implante Dental Titanio" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Categoria -->
                        <div class="col-12 col-sm-6">
                            <label for="create_categoria" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Categoría <span class="text-primary">*</span></label>
                            <select name="categoria" id="create_categoria" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <option value="" disabled selected>Seleccionar...</option>
                                <option value="Prevención">Prevención</option>
                                <option value="Ortodoncia">Ortodoncia</option>
                                <option value="Endodoncia">Endodoncia</option>
                                <option value="Estética">Estética</option>
                                <option value="Cirugía">Cirugía</option>
                                <option value="Implantes">Implantes</option>
                                <option value="General">General / Diagnóstico</option>
                            </select>
                        </div>

                        <!-- Duracion -->
                        <div class="col-12 col-sm-6">
                            <label for="create_duracion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Duración (Minutos) <span class="text-primary">*</span></label>
                            <input type="number" name="duracion_minutos" id="create_duracion" class="form-control" placeholder="Ej. 60" min="1" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Precio -->
                        <div class="col-12">
                            <label for="create_precio" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Costo / Tarifa (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" name="precio" id="create_precio" class="form-control" placeholder="Ej. 350.00" min="0" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Imagen -->
                        <div class="col-12">
                            <label for="create_imagen" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Foto del Tratamiento (Opcional)</label>
                            <input type="file" name="imagen" id="create_imagen" class="form-control" accept="image/*" style="border-radius: 8px; border-color: var(--border-color);">
                            <div class="form-text text-muted" style="font-size: 0.75rem;">Formatos recomendados: JPG, PNG, WEBP. Máx. 10MB.</div>
                        </div>

                        <!-- Descripcion -->
                        <div class="col-12">
                            <label for="create_descripcion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción</label>
                            <textarea name="descripcion" id="create_descripcion" rows="3" class="form-control" placeholder="Describe brevemente de qué trata el tratamiento y qué incluye." style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>

                        <!-- Activo -->
                        <div class="col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="activo" id="create_activo" value="1" checked style="cursor: pointer;">
                                <label class="form-check-label fw-medium text-slate-700" for="create_activo" style="cursor: pointer;">¿Servicio activo y disponible?</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Registrar Tratamiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: EDITAR SERVICIO (DYNAMIC ACTIONS)
     ============================================== -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="editServiceModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Editar Tratamiento
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editServiceForm" action="" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-refresh="true">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-12">
                            <label for="edit_nombre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre del Tratamiento <span class="text-primary">*</span></label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Categoria -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_categoria" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Categoría <span class="text-primary">*</span></label>
                            <select name="categoria" id="edit_categoria" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <option value="Prevención">Prevención</option>
                                <option value="Ortodoncia">Ortodoncia</option>
                                <option value="Endodoncia">Endodoncia</option>
                                <option value="Estética">Estética</option>
                                <option value="Cirugía">Cirugía</option>
                                <option value="Implantes">Implantes</option>
                                <option value="General">General / Diagnóstico</option>
                            </select>
                        </div>

                        <!-- Duracion -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_duracion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Duración (Minutos) <span class="text-primary">*</span></label>
                            <input type="number" name="duracion_minutos" id="edit_duracion" class="form-control" min="1" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Precio -->
                        <div class="col-12">
                            <label for="edit_precio" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Costo / Tarifa (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control" min="0" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Imagen -->
                        <div class="col-12">
                            <label for="edit_imagen" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Foto del Tratamiento (Opcional)</label>
                            <input type="file" name="imagen" id="edit_imagen" class="form-control" accept="image/*" style="border-radius: 8px; border-color: var(--border-color);">
                            <div class="form-text text-muted" style="font-size: 0.75rem;">Deja vacío para conservar la foto actual.</div>
                            
                            <div id="edit_imagen_preview_container" class="mt-2 d-none">
                                <span class="text-muted d-block mb-1" style="font-size: 0.80rem;">Foto actual:</span>
                                <div class="d-flex align-items-center gap-3">
                                    <img id="edit_imagen_preview" src="" alt="Foto actual del servicio" class="img-thumbnail" style="max-height: 90px; object-fit: cover; border-radius: 8px;">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input border-danger" type="checkbox" name="eliminar_imagen" id="eliminar_imagen" value="1" style="cursor: pointer;">
                                        <label class="form-check-label text-danger fw-medium" for="eliminar_imagen" style="cursor: pointer; font-size: 0.85rem;">
                                            Eliminar foto actual
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descripcion -->
                        <div class="col-12">
                            <label for="edit_descripcion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" rows="3" class="form-control" style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>

                        <!-- Activo -->
                        <div class="col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="activo" id="edit_activo" value="1" style="cursor: pointer;">
                                <label class="form-check-label fw-medium text-slate-700" for="edit_activo" style="cursor: pointer;">¿Servicio activo y disponible?</label>
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

<!-- ==============================================
     MODAL: DETALLES DE SERVICIO (VIEW)
     ============================================== -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            
            <!-- Top Image Banner -->
            <div class="position-relative d-flex align-items-center justify-content-center" style="background-color: #f8fafc; height: 240px; border-bottom: 1px solid #f1f5f9;">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3 bg-white p-2 shadow-sm transition" data-ui-dismiss="modal" aria-label="Close" style="border-radius: 50%; opacity: 0.9; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;"></button>
                <img id="view_imagen" src="" alt="Servicio" class="p-3" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                <!-- Fallback icon container -->
                <div id="view_imagen_fallback" class="d-none w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <div class="rounded-circle mb-2 d-flex align-items-center justify-content-center" style="background-color: var(--jade-50); color: var(--jade-400); width: 64px; height: 64px;">
                        <i data-lucide="image" style="width: 32px; height: 32px;"></i>
                    </div>
                </div>
            </div>

            <div class="modal-body p-4 p-md-4">
                <!-- Status & Category badges -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span id="view_categoria" class="badge text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px; padding: 6px 12px; border-radius: 8px;"></span>
                    <span id="view_activo" class="badge" style="font-size: 0.7rem; padding: 6px 12px; border-radius: 8px; font-weight: 600;"></span>
                </div>
                
                <!-- Title -->
                <h3 id="view_nombre" class="fw-bold mb-3 text-slate-900" style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; line-height: 1.2;"></h3>
                
                <!-- Description -->
                <div class="p-3 mb-4 rounded-4" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                    <p id="view_descripcion" class="text-slate-700 mb-0" style="font-size: 0.9rem; line-height: 1.6; white-space: pre-line; margin: 0;"></p>
                </div>
                
                <!-- Key metrics grid -->
                <div class="row g-3 mb-2">
                    <div class="col-6">
                        <div class="p-3 rounded-4 d-flex align-items-center gap-3 border" style="background-color: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <div class="text-jade-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: var(--jade-50); width: 40px; height: 40px;">
                                <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <small class="text-slate-500 d-block fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Duración</small>
                                <strong id="view_duracion" class="text-slate-800" style="font-size: 1.05rem; font-family: 'Outfit', sans-serif;"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-4 d-flex align-items-center gap-3 border" style="background-color: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <div class="text-jade-600 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: var(--jade-50); width: 40px; height: 40px;">
                                <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <small class="text-slate-500 d-block fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Precio Base</small>
                                <strong id="view_precio" class="text-slate-800" style="font-size: 1.15rem; font-family: 'Outfit', sans-serif;"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Audit info -->
                <div class="d-flex flex-wrap gap-4 text-muted pt-3 border-top" style="font-size: 0.75rem; border-color: #f1f5f9 !important;">
                    <div class="d-flex align-items-center gap-1">
                        <i data-lucide="calendar" style="width: 14px; height: 14px;"></i> 
                        <span>Creado: <span id="view_created" class="text-slate-700 fw-medium"></span></span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i> 
                        <span>Editado: <span id="view_updated" class="text-slate-700 fw-medium"></span></span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 bg-light border-top d-flex gap-3 justify-content-end" style="border-color: #f1f5f9 !important;">
                <button type="button" class="btn btn-light border px-4 py-2" data-ui-dismiss="modal" style="border-radius: 10px; font-weight: 600; color: #475569;">Cerrar</button>
                <button type="button" id="view_btn_edit" class="btn btn-primary px-4 py-2 d-flex align-items-center gap-2" data-ui-dismiss="modal" data-ui-toggle="modal" data-ui-target="#editServiceModal" style="border-radius: 10px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 168, 132, 0.2);">
                    <i data-lucide="edit-3" style="width: 16px; height: 16px;"></i> Editar Servicio
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-service-btn');
        const editForm = document.getElementById('editServiceForm');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const updateUrl = this.getAttribute('data-update-url');
                const nombre = this.getAttribute('data-nombre');
                const categoria = this.getAttribute('data-categoria');
                const precio = this.getAttribute('data-precio');
                const duracion = this.getAttribute('data-duracion');
                const descripcion = this.getAttribute('data-descripcion');
                const activo = this.getAttribute('data-activo');
                const imagen = this.getAttribute('data-imagen');
                
                // Set form action URL dynamically
                editForm.action = this.getAttribute('data-update-url');
                
                // Populate modal inputs
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_categoria').value = categoria;
                document.getElementById('edit_precio').value = precio;
                document.getElementById('edit_duracion').value = duracion;
                document.getElementById('edit_descripcion').value = descripcion;
                
                // Populate active toggle switch state
                document.getElementById('edit_activo').checked = (activo === '1');
                
                // Handle Image Preview
                const previewContainer = document.getElementById('edit_imagen_preview_container');
                const previewImg = document.getElementById('edit_imagen_preview');
                const btnEliminar = document.getElementById('eliminar_imagen');
                if (imagen) {
                    previewImg.src = imagen;
                    previewContainer.classList.remove('d-none');
                    if (btnEliminar) btnEliminar.checked = false;
                } else {
                    previewImg.src = '';
                    previewContainer.classList.add('d-none');
                }
            });
        });

        // View Service Modal Population
        const viewClickables = document.querySelectorAll('.service-img-clickable');
        const viewNombre = document.getElementById('view_nombre');
        const viewCategoria = document.getElementById('view_categoria');
        const viewActivo = document.getElementById('view_activo');
        const viewDescripcion = document.getElementById('view_descripcion');
        const viewDuracion = document.getElementById('view_duracion');
        const viewPrecio = document.getElementById('view_precio');
        const viewCreated = document.getElementById('view_created');
        const viewUpdated = document.getElementById('view_updated');
        const viewImagen = document.getElementById('view_imagen');
        const viewImagenFallback = document.getElementById('view_imagen_fallback');
        const viewBtnEdit = document.getElementById('view_btn_edit');
        
        viewClickables.forEach(clickable => {
            clickable.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const updateUrl = this.getAttribute('data-update-url');
                const nombre = this.getAttribute('data-nombre');
                const categoria = this.getAttribute('data-categoria');
                const precio = this.getAttribute('data-precio');
                const duracion = this.getAttribute('data-duracion');
                const descripcion = this.getAttribute('data-descripcion') || 'Sin descripción';
                const activo = this.getAttribute('data-activo');
                const activoVal = this.getAttribute('data-activo-val');
                const created = this.getAttribute('data-created');
                const updated = this.getAttribute('data-updated');
                const imagen = this.getAttribute('data-imagen');
                
                // Populate text/HTML
                viewNombre.textContent = nombre;
                viewCategoria.textContent = categoria;
                viewActivo.textContent = activo;
                viewDescripcion.textContent = descripcion;
                viewDuracion.textContent = `${duracion} minutos`;
                viewPrecio.textContent = `S/. ${precio}`;
                viewCreated.textContent = created;
                viewUpdated.textContent = updated;
                
                // Badges styling
                let catBg = '#ccfbf1', catCol = '#0f766e';
                if (categoria === 'Prevención') { catBg = '#e0f2fe'; catCol = '#0369a1'; }
                else if (categoria === 'Ortodoncia') { catBg = '#e0e7ff'; catCol = '#4338ca'; }
                else if (categoria === 'Endodoncia') { catBg = '#ffedd5'; catCol = '#c2410c'; }
                else if (categoria === 'Estética') { catBg = '#fce7f3'; catCol = '#be185d'; }
                viewCategoria.style.backgroundColor = catBg;
                viewCategoria.style.color = catCol;
                
                if (activoVal === '1') {
                    viewActivo.className = 'badge más-2 style="background-color: rgba(27, 92, 58, 0.1)" text-primary border border-success-subtle';
                } else {
                    viewActivo.className = 'badge más-2 bg-secondary-subtle text-secondary border border-secondary-subtle';
                }
                
                // Image or Fallback
                if (imagen) {
                    viewImagen.src = imagen;
                    viewImagen.classList.remove('d-none');
                    viewImagenFallback.classList.add('d-none');
                } else {
                    viewImagen.src = '';
                    viewImagen.classList.add('d-none');
                    viewImagenFallback.classList.remove('d-none');
                }
                
                // Set data attributes on the edit button in the view modal
                viewBtnEdit.setAttribute('data-id', id);
                viewBtnEdit.setAttribute('data-update-url', updateUrl);
                viewBtnEdit.setAttribute('data-nombre', nombre);
                viewBtnEdit.setAttribute('data-categoria', categoria);
                viewBtnEdit.setAttribute('data-precio', this.getAttribute('data-precio-raw'));
                viewBtnEdit.setAttribute('data-duracion', duracion);
                viewBtnEdit.setAttribute('data-descripcion', this.getAttribute('data-descripcion-raw'));
                viewBtnEdit.setAttribute('data-activo', activoVal);
                viewBtnEdit.setAttribute('data-imagen', imagen);
            });
        });
        
        if (viewBtnEdit) {
            viewBtnEdit.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const categoria = this.getAttribute('data-categoria');
                const precio = this.getAttribute('data-precio');
                const duracion = this.getAttribute('data-duracion');
                const descripcion = this.getAttribute('data-descripcion');
                const activo = this.getAttribute('data-activo');
                const imagen = this.getAttribute('data-imagen');
                
                editForm.action = this.getAttribute('data-update-url');
                
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_categoria').value = categoria;
                document.getElementById('edit_precio').value = precio;
                document.getElementById('edit_duracion').value = duracion;
                document.getElementById('edit_descripcion').value = descripcion;
                document.getElementById('edit_activo').checked = (activo === '1');
                
                const previewContainer = document.getElementById('edit_imagen_preview_container');
                const previewImg = document.getElementById('edit_imagen_preview');
                const btnEliminar2 = document.getElementById('eliminar_imagen');
                if (imagen && imagen !== '' && imagen !== 'null') {
                    previewImg.src = imagen;
                    previewContainer.classList.remove('d-none');
                    if (btnEliminar2) btnEliminar2.checked = false;
                } else {
                    previewImg.src = '';
                    previewContainer.classList.add('d-none');
                }
            });
        }
    });
</script>
@endsection

@section('styles')
<style>
    .pill-filter {
        background-color: #f1f5f9;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .pill-filter:hover {
        background-color: #e2e8f0;
        color: var(--text-main);
    }
    .pill-filter.active {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(32, 127, 84, 0.2);
    }
    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md) !important;
        border-color: var(--primary) !important;
    }
    .inactive-card {
        background-color: #fafbfc;
        opacity: 0.75;
        border-style: dashed !important;
    }
    
    /* Clickable service image styles with hover overlay */
    .service-img-container img {
        transition: transform 0.3s ease;
    }
    .service-img-container:hover img {
        transform: scale(1.06);
    }
    .service-img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(14, 30, 23, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
        color: white;
        backdrop-filter: blur(2px);
    }
    .service-img-container:hover .service-img-overlay {
        opacity: 1;
    }
</style>
@endsection
@endsection
