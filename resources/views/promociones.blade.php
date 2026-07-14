@extends('layouts.plantilla')

@section('title', 'Campañas Promocionales')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Campañas y Promociones</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Gestiona campañas publicitarias, descuentos por tratamiento y vigencia de ofertas.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-ui-toggle="modal" data-ui-target="#createPromoModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 10px 18px; border-radius: 10px; transition: all 0.2s;">
                <i data-lucide="plus" style="width: 18px; height: 18px;"></i> Nueva Promoción
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

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
        <div class="card-body p-4">
            <form action="{{ route('promociones.index') }}" method="GET" class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-slate-700" style="font-size: 0.85rem;">Buscar Promoción</label>
                    <div class="input-group" style="flex-wrap: nowrap;">
                        <span class="input-group-text bg-light border-end-0 text-muted px-3" style="border-radius: 10px 0 0 10px; border-color: var(--border-color);">
                            <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0 shadow-none" placeholder="Título o descripción de la campaña..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-medium text-slate-700" style="font-size: 0.85rem;">Estado Administrativo</label>
                    <select name="status" class="form-select bg-white" style="background-color: #f2faf6; border-radius: 10px; border-color: var(--border-color); height: 42px; font-size: 0.85rem;">
                        <option value="Todas" {{ request('status') === 'Todas' ? 'selected' : '' }}>Todas</option>
                        <option value="activas" {{ request('status') === 'activas' ? 'selected' : '' }}>Activas</option>
                        <option value="inactivas" {{ request('status') === 'inactivas' ? 'selected' : '' }}>Inactivas</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary); border-color: var(--primary); height: 42px; border-radius: 10px; font-weight: 500;">
                        Filtrar
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('promociones.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 42px; width: 50px; border-radius: 10px; color: var(--text-muted);">
                        <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Campaigns Grid -->
    @if($promociones->isEmpty())
    <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
        <div class="p-4 mx-auto mb-4" style="background-color: var(--primary-light); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <i data-lucide="gift" style="width: 40px; height: 40px;"></i>
        </div>
        <h4 style="font-weight: 600; font-family: 'Outfit', sans-serif;">Sin campañas registradas</h4>
        <p class="text-muted">No se encontraron campañas vigentes o históricas en el panel.</p>
    </div>
    @else
    <div class="row g-4 mb-5">
        @foreach($promociones as $promo)
        @php
        $isExpired = false;
        $today = \Carbon\Carbon::today();
        if ($promo->fecha_fin && \Carbon\Carbon::parse($promo->fecha_fin)->isPast() && !\Carbon\Carbon::parse($promo->fecha_fin)->isToday()) {
        $isExpired = true;
        }
        $isUpcoming = false;
        if ($promo->fecha_inicio && \Carbon\Carbon::parse($promo->fecha_inicio)->isFuture()) {
        $isUpcoming = true;
        }
        @endphp
        <div class="col-12 col-md-6 col-lg-4" data-axios-removable>
            <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative {{ !$promo->activo || $isExpired ? 'opacity-75' : '' }}" style="border-radius: 16px; border: 1px solid var(--border-color) !important; transition: all 0.2s;">
                <!-- Discount Tag Overlay -->
                @if($promo->descuento_porcentaje > 0)
                <span class="position-absolute top-0 start-0 m-3 badge shadow-sm" style="background-color: var(--primary); color: white; border-radius: 8px; z-index: 10; font-size: 0.75rem; padding: 6px 10px;">
                    {{ $promo->descuento_porcentaje }}% DCTO
                </span>
                @endif

                <!-- Validity status tag -->
                @php
                $promoStatusStyle = $isExpired
                ? 'background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;'
                : ($isUpcoming
                ? 'background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;'
                : (!$promo->activo
                ? 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;'
                : 'background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;'));
                $promoStatusLabel = $isExpired ? 'Expirado' : ($isUpcoming ? 'Por Iniciar' : (!$promo->activo ? 'Inactivo' : 'Vigente'));
                $fullStyleAttr = 'style="border-radius: 8px; z-index: 10; font-size: 0.65rem; letter-spacing: 0.5px; ' . $promoStatusStyle . '"';
                @endphp
                <span class="position-absolute top-0 end-0 m-3 badge px-3 py-2 shadow-sm text-uppercase fw-bold" {!! $fullStyleAttr !!}>
                    {{ $promoStatusLabel }}
                </span>

                <!-- Header banner image -->
                <div class="position-relative" style="height: 180px; overflow: hidden; background-color: #f8fafc;">
                    @if($promo->imagen_path)
                    <img src="{{ image_url($promo->imagen_path) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $promo->titulo }}" loading="lazy">
                    @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, var(--primary) 0%, #1b5c3a 100%);">
                        <i data-lucide="gift" style="width: 48px; height: 48px; opacity: 0.7;"></i>
                    </div>
                    @endif
                </div>

                <!-- Card Content -->
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-slate-800" style="font-family: 'Outfit', sans-serif; font-size: 1.15rem;">
                        {{ $promo->titulo }}
                    </h5>
                    <p class="text-muted mb-4 flex-grow-1" style="font-size: 0.85rem; line-height: 1.5;">
                        {{ $promo->descripcion ?: 'Sin descripción detallada.' }}
                    </p>

                    <!-- Date Ranges -->
                    <div class="border-top border-light-subtle pt-3 mt-auto">
                        <div class="d-flex align-items-center gap-2 text-muted mb-1" style="font-size: 0.8rem;">
                            <i data-lucide="calendar" style="width: 14px; height: 14px;"></i>
                            <span>Vigencia:</span>
                        </div>
                        <div class="fw-medium text-slate-700" style="font-size: 0.85rem; padding-left: 22px;">
                            @if($promo->fecha_inicio || $promo->fecha_fin)
                            {{ $promo->fecha_inicio ? \Carbon\Carbon::parse($promo->fecha_inicio)->format('d/m/Y') : 'Inicio inmediato' }}
                            al
                            {{ $promo->fecha_fin ? \Carbon\Carbon::parse($promo->fecha_fin)->format('d/m/Y') : 'Indefinido' }}
                            @else
                            Sin límites de fecha.
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="card-footer bg-light border-top-0 px-4 py-3 d-flex justify-content-between align-items-center">
                    <!-- Toggle switch form for active state -->
                    <form action="{{ route('promociones.update', $promo->id) }}" method="POST" class="d-inline" data-axios-submit data-axios-refresh="true">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="titulo" value="{{ $promo->titulo }}">
                        <input type="hidden" name="descuento_porcentaje" value="{{ $promo->descuento_porcentaje }}">
                        <input type="hidden" name="fecha_inicio" value="{{ $promo->fecha_inicio }}">
                        <input type="hidden" name="fecha_fin" value="{{ $promo->fecha_fin }}">
                        <input type="hidden" name="descripcion" value="{{ $promo->descripcion }}">
                        <input type="hidden" name="activo" value="{{ $promo->activo ? 0 : 1 }}">
                        <div class="form-check form-switch p-0 m-0 d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input class="form-check-input m-0" type="checkbox" role="switch" onchange="this.form.requestSubmit()" {{ $promo->activo ? 'checked' : '' }} style="cursor: pointer; width: 36px; height: 20px;">
                            <span class="fw-semibold text-slate-600" style="font-size: 0.8rem;">
                                {{ $promo->activo ? 'Visible' : 'Oculto' }}
                            </span>
                        </div>
                    </form>

                    <div class="d-flex gap-2">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-sm btn-light border p-2 edit-promo-btn"
                            data-ui-toggle="modal"
                            data-ui-target="#editPromoModal"
                            data-id="{{ $promo->id }}"
                            data-update-url="{{ route('promociones.update', $promo->id) }}"
                            data-titulo="{{ $promo->titulo }}"
                            data-descripcion="{{ $promo->descripcion }}"
                            data-descuento="{{ $promo->descuento_porcentaje }}"
                            data-fecha-inicio="{{ $promo->fecha_inicio }}"
                            data-fecha-fin="{{ $promo->fecha_fin }}"
                            data-activo="{{ $promo->activo }}"
                            data-imagen="{{ image_url($promo->imagen_path, '') }}"
                            title="Editar Campaña">
                            <i data-lucide="edit-3" style="width: 14px; height: 14px; color: var(--text-muted);"></i>
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('promociones.destroy', $promo->id) }}" method="POST" data-axios-delete data-confirm="¿Está seguro de que desea eliminar esta promoción?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger p-2" title="Eliminar Campaña">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- ==============================================
     MODAL: CREAR PROMOCIÓN
     ============================================== -->
<div class="modal fade" id="createPromoModal" tabindex="-1" aria-labelledby="createPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="createPromoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Crear Campaña Promocional
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('promociones.store') }}" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-reset="true" data-axios-refresh="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Titulo -->
                        <div class="col-12">
                            <label for="create_titulo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Título de la Campaña <span class="text-primary">*</span></label>
                            <input type="text" name="titulo" id="create_titulo" class="form-control" required placeholder="Ej. Campaña de Ortodoncia Familiar" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Descuento -->
                        <div class="col-12">
                            <label for="create_descuento" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descuento (%) <span class="text-primary">*</span></label>
                            <input type="number" name="descuento_porcentaje" id="create_descuento" min="0" max="100" class="form-control" required placeholder="Ej. 15" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Fecha Inicio / Fin -->
                        <div class="col-12 col-sm-6">
                            <label for="create_fecha_inicio" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="create_fecha_inicio" class="form-control" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="create_fecha_fin" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Término</label>
                            <input type="date" name="fecha_fin" id="create_fecha_fin" class="form-control" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Imagen Banner -->
                        <div class="col-12">
                            <label for="create_imagen" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Imagen de Campaña (Banner / Antes-Después)</label>
                            <input type="file" name="imagen" id="create_imagen" class="form-control" accept="image/*" style="border-radius: 8px; border-color: var(--border-color);">
                            <small class="text-muted" style="font-size: 0.75rem;">Formatos admitidos: JPG, PNG, WebP. Peso máximo: 2MB.</small>
                        </div>

                        <!-- Descripcion -->
                        <div class="col-12">
                            <label for="create_descripcion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción detallada</label>
                            <textarea name="descripcion" id="create_descripcion" rows="3" class="form-control" placeholder="Describe los tratamientos incluidos, condiciones, etc." style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>

                        <!-- Visible al Publico -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem; display: block;">Estado de Publicación</label>
                            <input type="hidden" name="activo" value="0">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input" type="checkbox" name="activo" id="create_activo" value="1" checked style="cursor: pointer;">
                                <label class="form-check-label text-muted más-2" for="create_activo" style="font-size: 0.85rem;">Hacer esta campaña activa de inmediato</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Crear Promoción</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: EDITAR PROMOCIÓN
     ============================================== -->
<div class="modal fade" id="editPromoModal" tabindex="-1" aria-labelledby="editPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="editPromoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Modificar Campaña Promocional
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editPromoForm" action="" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-refresh="true">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Preview Image thumbnail if exists -->
                        <div class="col-12 text-center d-none" id="edit_preview_container">
                            <div class="position-relative d-inline-block rounded-3 overflow-hidden border mb-2" style="max-height: 120px; max-width: 240px;">
                                <img src="" id="edit_preview_img" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        </div>

                        <!-- Titulo -->
                        <div class="col-12">
                            <label for="edit_titulo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Título de la Campaña <span class="text-primary">*</span></label>
                            <input type="text" name="titulo" id="edit_titulo" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Descuento -->
                        <div class="col-12">
                            <label for="edit_descuento" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descuento (%) <span class="text-primary">*</span></label>
                            <input type="number" name="descuento_porcentaje" id="edit_descuento" min="0" max="100" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Fecha Inicio / Fin -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_fecha_inicio" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="edit_fecha_inicio" class="form-control" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="edit_fecha_fin" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Término</label>
                            <input type="date" name="fecha_fin" id="edit_fecha_fin" class="form-control" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Nueva Imagen Banner -->
                        <div class="col-12">
                            <label for="edit_imagen" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Cambiar Imagen (Dejar vacío para conservar actual)</label>
                            <input type="file" name="imagen" id="edit_imagen" class="form-control" accept="image/*" style="border-radius: 8px; border-color: var(--border-color);">
                        </div>

                        <!-- Descripcion -->
                        <div class="col-12">
                            <label for="edit_descripcion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción detallada</label>
                            <textarea name="descripcion" id="edit_descripcion" rows="3" class="form-control" style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>

                        <!-- Activo status switch -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem; display: block;">Estado de Publicación</label>
                            <input type="hidden" name="activo" value="0">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input" type="checkbox" name="activo" id="edit_activo" value="1" style="cursor: pointer;">
                                <label class="form-check-label text-muted más-2" for="edit_activo" style="font-size: 0.85rem;">Mostrar esta campaña en la web pública</label>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-promo-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const titulo = this.getAttribute('data-titulo');
                const descripcion = this.getAttribute('data-descripcion');
                const descuento = this.getAttribute('data-descuento');
                const fechaInicio = this.getAttribute('data-fecha-inicio');
                const fechaFin = this.getAttribute('data-fecha-fin');
                const activo = this.getAttribute('data-activo');
                const imagen = this.getAttribute('data-imagen');

                // Update form action route
                const form = document.getElementById('editPromoForm');
                form.action = this.getAttribute('data-update-url');

                // Set inputs
                document.getElementById('edit_titulo').value = titulo;
                document.getElementById('edit_descuento').value = descuento;
                document.getElementById('edit_fecha_inicio').value = fechaInicio ?? '';
                document.getElementById('edit_fecha_fin').value = fechaFin ?? '';
                document.getElementById('edit_descripcion').value = descripcion ?? '';
                document.getElementById('edit_activo').checked = (activo == '1');

                // Set image thumbnail preview
                const previewContainer = document.getElementById('edit_preview_container');
                const previewImg = document.getElementById('edit_preview_img');
                if (imagen) {
                    previewImg.src = imagen;
                    previewContainer.classList.remove('d-none');
                } else {
                    previewContainer.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection

@endsection