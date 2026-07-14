@extends('layouts.plantilla')

@section('title', 'Perfil de la Doctora')

@section('styles')
<style>
    .profile-card {
        border: 1px solid var(--border-color);
        border-radius: 16px;
        background-color: #fff;
    }

    .avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 20px;
    }

    .avatar-img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-light);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .avatar-upload-label {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--primary);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-md);
        transition: all 0.2s ease;
    }

    .avatar-upload-label:hover {
        background-color: var(--primary-hover);
        transform: scale(1.1);
    }

    .avatar-wrapper input {
        display: none;
    }
</style>
@endsection

@section('content')
@php
    $avatarUrl = $doctora?->avatar_url ?? asset('images/avatar_placeholder.svg');
@endphp
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-3 border-bottom">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge" style="background-color: var(--primary-light); color: var(--primary); font-weight: 600; font-size: 0.75rem; padding: 6px 12px; border-radius: 20px;">
                    Ajustes de Cuenta
                </span>
            </div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main); font-family: 'Outfit', sans-serif;">
                Perfil de la Doctora
            </h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Administra tus credenciales personales, colegiatura e información pública.
            </p>
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="border-radius: 12px; background-color: #ecfdf5; color: #065f46;">
        <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
        <span class="fw-semibold">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px; background-color: #f2faf6; color: #0e301e;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i data-lucide="alert-triangle" style="width: 20px; height: 20px;"></i>
            <span class="fw-bold">Por favor corrige los siguientes errores:</span>
        </div>
        <ul class="mb-0 ps-4" style="font-size: 0.9rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Summary Card -->
        <div class="col-12 col-lg-4">
            <div class="card profile-card border-0 shadow-sm p-4 text-center">
                <form action="{{ route('doctora.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileCardForm" data-axios-submit data-axios-refresh="true">
                    @csrf
                    @method('PUT')

                    <div class="avatar-wrapper">
                        <img src="{{ $avatarUrl }}" alt="Avatar Doctora" class="avatar-img" id="avatarPreview">
                        <label for="avatarInput" class="avatar-upload-label" title="Subir nueva foto">
                            <i data-lucide="camera" style="width: 18px; height: 18px;"></i>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewImage(event)">
                    </div>

                    <h5 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">{{ Auth::user()->name }}</h5>
                    <p class="text-primary fw-semibold mb-3" style="font-size: 0.875rem;">
                        {{ $doctora?->especialidad ?? 'Perfil pendiente' }}
                    </p>

                    <div class="border-top pt-3 mt-3 text-start">
                        <div class="mb-2 d-flex justify-content-between" style="font-size: 0.85rem;">
                            <span class="text-muted">DNI / COP:</span>
                            <span class="fw-semibold text-slate-700">
                                {{ $doctora?->cop_formatted ?? '' }}
                            </span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between" style="font-size: 0.85rem;">
                            <span class="text-muted">Email de Contacto:</span>
                            <span class="fw-semibold text-slate-700">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size: 0.85rem;">
                            <span class="text-muted">Teléfono:</span>
                            <span class="fw-semibold text-slate-700">{{ $doctora?->telefono ?? '' }}</span>
                        </div>
                    </div>

                    @if($doctora && $doctora->bio)
                    <div class="border-top pt-3 mt-3 text-start">
                        <h6 class="fw-bold mb-2 text-slate-800" style="font-size: 0.85rem; font-family: 'Outfit', sans-serif;">Sobre mí:</h6>
                        <p class="text-muted mb-0" style="font-size: 0.825rem; line-height: 1.5; text-align: justify;">
                            {{ $doctora->bio }}
                        </p>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Right Column: Editing Profile Fields -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                <h5 class="fw-bold mb-3 text-slate-800" style="font-family: 'Outfit', sans-serif;">
                    Información Profesional y de Acceso
                </h5>
                <p class="text-muted mb-4" style="font-size: 0.875rem;">
                    Completa la información que se mostrará a los pacientes y los detalles de autenticación del sistema.
                </p>

                <!-- Profile Editing Form -->
                <form action="{{ route('doctora.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileMainForm" data-axios-submit data-axios-refresh="true">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre Completo <span class="text-primary">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Correo Electrónico <span class="text-primary">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Specialty -->
                        <div class="col-12 col-md-6">
                            <label for="especialidad" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Especialidad Médica <span class="text-primary">*</span></label>
                            <input type="text" name="especialidad" id="especialidad" class="form-control" value="{{ old('especialidad', $doctora->especialidad ?? '') }}" required placeholder="Ej. Ortodoncia y Ortopedia Maxilar" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- COP Code -->
                        <div class="col-12 col-md-6">
                            <label for="COP" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">N° Colegiatura Odontológica (COP) <span class="text-primary">*</span></label>
                            <input type="text" name="COP" id="COP" class="form-control" value="{{ old('COP', $doctora->COP ?? '') }}" required placeholder="Número de colegiatura" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Contact Telephone -->
                        <div class="col-12">
                            <label for="telefono" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Teléfono de Contacto</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $doctora->telefono ?? '') }}" placeholder="Ej. 987654321" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Biography / Professional Bio -->
                        <div class="col-12">
                            <label for="bio" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Biografía Profesional</label>
                            <textarea name="bio" id="bio" rows="4" class="form-control" placeholder="Escribe un breve resumen de tu trayectoria profesional, estudios y enfoque clínico..." style="border-radius: 8px; border-color: var(--border-color);">{{ old('bio', $doctora->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Hidden Avatar File Transporter -->
                    <input type="file" name="avatar" id="avatarHiddenInput" style="display: none;">

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 600;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Show preview instantly
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Sync the selected file to the main form's hidden input
        try {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('avatarHiddenInput').files = dt.files;
        } catch (_) {
            // DataTransfer not supported — admin.js compression will still work
            // because it reads from FormData which includes the card form's input
        }
    }
</script>
@endsection

