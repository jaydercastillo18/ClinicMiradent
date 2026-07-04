@extends('layouts.plantilla')
@section('title', 'Registrar Paciente')
@section('content')
@php $esModal = request()->has('modal') || request()->ajax(); @endphp
<div class="{{ request()->ajax() ? '' : 'container-fluid p-0' }}">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 pb-3" style="border-bottom: 2px solid #e2e8f0;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div style="width:36px;height:36px;background:var(--primary,#1a7a52);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="user-plus" style="width:18px;height:18px;color:#fff;"></i>
                </div>
                <h1 class="h4 mb-0 fw-bold" style="color: #0f172a; font-family: 'Outfit', sans-serif;">Registrar Nuevo Paciente</h1>
            </div>
            <p class="text-muted mb-0 ms-1" style="font-size: 0.88rem;">Completa los datos para crear el expediente clínico.</p>
        </div>
        <div>
            @if(request()->ajax())
            <button type="button" class="btn btn-light border d-flex align-items-center gap-2" data-ui-dismiss="modal" style="font-weight: 500; padding: 8px 16px; border-radius: 10px; font-size: 0.9rem;">
                <i data-lucide="x" style="width: 16px; height: 16px;"></i> Cerrar
            </button>
            @else
            <a href="{{ route('pacientes.index') }}" class="btn btn-light border d-flex align-items-center gap-2" style="font-weight: 500; padding: 8px 16px; border-radius: 10px; font-size: 0.9rem;">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Volver al listado
            </a>
            @endif
        </div>
    </div>

    <!-- Error Summary Alert -->
    @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-3 mb-4" role="alert" style="background-color: #f2faf6; color: #0e301e; border-radius: 12px; padding: 16px 20px;">
        <i data-lucide="alert-circle" style="width: 24px; height: 24px; flex-shrink: 0; color: #1b5c3a; margin-top: 2px;"></i>
        <div>
            <h6 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Por favor corrige los siguientes errores:</h6>
            <ul class="mb-0 ps-3" style="font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('pacientes.store') }}" method="POST" data-axios-submit data-axios-no-reload="true" data-axios-close-modal="true" id="form-regpaciente">
        @csrf

        <div class="row g-4">
            <!-- Left Side: General Info -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-semibold mb-1 d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                            <i data-lucide="user" class="text-primary" style="width: 20px; height: 20px; color: var(--primary);"></i>
                            Datos Generales del Paciente
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Información básica de identificación y localización.</p>
                        <hr class="mt-3 mb-0" style="color: var(--border-color)">
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Nombres -->
                            <div class="col-12 col-md-6">
                                <label for="nombre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombres <span class="text-primary">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej. Alejandro" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Apellidos -->
                            <div class="col-12 col-md-6">
                                <label for="apellido" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Apellidos <span class="text-primary">*</span></label>
                                <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" placeholder="Ej. Mendoza" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- DNI -->
                            <div class="col-12 col-md-4">
                                <label for="dni" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">DNI / Documento <span class="text-primary">*</span></label>
                                <input type="text" name="dni" id="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" placeholder="Ej. 74859632" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="col-12 col-md-4">
                                <label for="telefono" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Teléfono de Contacto</label>
                                <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" placeholder="Ej. 987654321" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-4">
                                <label for="email" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Ej. paciente@ejemplo.com" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fecha Nacimiento -->
                            <div class="col-12 col-md-4">
                                <label for="fecha_nacimiento" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento') }}" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Género -->
                            <div class="col-12 col-md-4">
                                <label for="genero" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Género</label>
                                <select name="genero" id="genero" class="form-select @error('genero') is-invalid @enderror" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                    <option value="" selected>Seleccionar...</option>
                                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genero')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo Sangre -->
                            <div class="col-12 col-md-4">
                                <label for="tipo_sangre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Grupo Sanguíneo</label>
                                <select name="tipo_sangre" id="tipo_sangre" class="form-select @error('tipo_sangre') is-invalid @enderror" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                    <option value="" selected>Seleccionar...</option>
                                    @foreach(['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB-', 'AB+'] as $blood)
                                    <option value="{{ $blood }}" {{ old('tipo_sangre') == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_sangre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="col-12">
                                <label for="direccion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Dirección de Domicilio</label>
                                <textarea name="direccion" id="direccion" rows="2" class="form-control @error('direccion') is-invalid @enderror" placeholder="Ej. Calle Los Pinos 145, Dpto 302, San Borja" style="border-radius: 8px; border-color: var(--border-color);">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Medical Info -->
                <div class="card border-0 shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-semibold mb-1 d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                            <i data-lucide="clipboard-list" class="text-primary" style="width: 20px; height: 20px; color: var(--primary);"></i>
                            Antecedentes Clínicos e Historial
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Historial médico relevante para tratamientos dentales seguros.</p>
                        <hr class="mt-3 mb-0" style="color: var(--border-color)">
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Antecedentes Médicos -->
                            <div class="col-12">
                                <label for="antecedentes_medicos" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Enfermedades Preexistentes / Antecedentes</label>
                                <textarea name="antecedentes_medicos" id="antecedentes_medicos" rows="3" class="form-control @error('antecedentes_medicos') is-invalid @enderror" placeholder="Ej. Hipertensión bajo medicación, diabetes controlada, asma, etc." style="border-radius: 8px; border-color: var(--border-color);">{{ old('antecedentes_medicos') }}</textarea>
                                @error('antecedentes_medicos')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alergias -->
                            <div class="col-12">
                                <label for="alergias" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Alergias Conocidas</label>
                                <textarea name="alergias" id="alergias" rows="2" class="form-control @error('alergias') is-invalid @enderror" placeholder="Ej. Alergia a la penicilina, analgésicos, látex, etc. (Escribe 'Ninguna' si no tiene)" style="border-radius: 8px; border-color: var(--border-color);">{{ old('alergias') }}</textarea>
                                @error('alergias')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Medicamentos Habituales -->
                            <div class="col-12">
                                <label for="medicamentos_habituales" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Medicamentos de Uso Diario</label>
                                <textarea name="medicamentos_habituales" id="medicamentos_habituales" rows="2" class="form-control @error('medicamentos_habituales') is-invalid @enderror" placeholder="Ej. Tomo aspirina diaria, insulina, anticoagulantes, etc." style="border-radius: 8px; border-color: var(--border-color);">{{ old('medicamentos_habituales') }}</textarea>
                                @error('medicamentos_habituales')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Emergency & Actions -->
            <div class="col-12 col-lg-4">
                <!-- Emergency Contact Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-semibold mb-1 d-flex align-items-center gap-2" style="color: var(--text-main); font-family: 'Outfit', sans-serif;">
                            <i data-lucide="shield-alert" class="text-primary" style="width: 20px; height: 20px;"></i>
                            Contacto de Emergencia
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">En caso de alguna eventualidad clínica.</p>
                        <hr class="mt-3 mb-0" style="color: var(--border-color)">
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Nombre Contacto -->
                            <div class="col-12">
                                <label for="contacto_emergencia_nombre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Nombre Completo</label>
                                <input type="text" name="contacto_emergencia_nombre" id="contacto_emergencia_nombre" class="form-control @error('contacto_emergencia_nombre') is-invalid @enderror" value="{{ old('contacto_emergencia_nombre') }}" placeholder="Ej. María Mendoza" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('contacto_emergencia_nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono Contacto -->
                            <div class="col-12">
                                <label for="contacto_emergencia_telefono" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Teléfono</label>
                                <input type="text" name="contacto_emergencia_telefono" id="contacto_emergencia_telefono" class="form-control @error('contacto_emergencia_telefono') is-invalid @enderror" value="{{ old('contacto_emergencia_telefono') }}" placeholder="Ej. 912345678" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('contacto_emergencia_telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Parentesco -->
                            <div class="col-12">
                                <label for="contacto_emergencia_parentesco" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Parentesco / Relación</label>
                                <input type="text" name="contacto_emergencia_parentesco" id="contacto_emergencia_parentesco" class="form-control @error('contacto_emergencia_parentesco') is-invalid @enderror" value="{{ old('contacto_emergencia_parentesco') }}" placeholder="Ej. Madre, Esposo(a), Hermano" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                @error('contacto_emergencia_parentesco')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Action Panel -->
                <div class="card border-0 shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color) !important; background-color: #fafbfc;">
                    <div class="card-body p-4 d-flex flex-column gap-3">
                        <button type="submit" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2 fw-semibold" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(32,127,84,0.15);">
                            <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                            Guardar Paciente
                        </button>

                        @if($esModal)
                        <button type="button" class="btn btn-outline-secondary w-100 py-3" data-ui-dismiss="modal" style="border-radius: 10px; font-weight: 500; font-size: 0.95rem;">
                            Cancelar
                        </button>
                        @else
                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary w-100 py-3" style="border-radius: 10px; font-weight: 500; font-size: 0.95rem;">
                            Cancelar y volver
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script id="existing-patients-data" type="application/json">
    @json($existingPatients ?? [])
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const existingPatients = JSON.parse(document.getElementById('existing-patients-data').textContent || '[]');
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        const dniInput = document.getElementById('dni');

        // Container for warning alert
        const formContainer = document.querySelector('form');
        const warningAlert = document.createElement('div');
        warningAlert.className = 'alert border-0 shadow-sm d-none flex-column gap-2 mb-4';
        warningAlert.style.borderRadius = '12px';
        warningAlert.style.padding = '16px 20px';
        warningAlert.style.backgroundColor = '#f2faf6';
        warningAlert.style.borderLeft = '4px solid #1b5c3a';

        const alertContentWrapper = document.createElement('div');
        alertContentWrapper.className = 'd-flex align-items-center gap-3';
        
        const iconContainer = document.createElement('div');
        iconContainer.id = 'warning_icon_container';
        
        const textWrapper = document.createElement('div');
        const titleEl = document.createElement('div');
        titleEl.id = 'warning_title';
        titleEl.style.fontWeight = '600';
        titleEl.style.fontSize = '0.95rem';
        titleEl.style.color = '#0e301e';
        
        const msgEl = document.createElement('div');
        msgEl.id = 'warning_message';
        msgEl.style.fontSize = '0.85rem';
        msgEl.style.color = '#334155';
        
        textWrapper.appendChild(titleEl);
        textWrapper.appendChild(msgEl);
        
        alertContentWrapper.appendChild(iconContainer);
        alertContentWrapper.appendChild(textWrapper);
        
        warningAlert.appendChild(alertContentWrapper);

        // Insert alert right before the form
        formContainer.parentNode.insertBefore(warningAlert, formContainer);

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);
        }

        function checkDuplicates() {
            const nombre = nombreInput.value.trim().toLowerCase();
            const apellido = apellidoInput.value.trim().toLowerCase();
            const dni = dniInput.value.trim();

            let nameMatch = null;
            let dniMatch = null;

            if (nombre && apellido) {
                nameMatch = existingPatients.find(p =>
                    String(p.nombre ?? '').trim().toLowerCase() === nombre &&
                    String(p.apellido ?? '').trim().toLowerCase() === apellido
                );
            }

            if (dni) {
                dniMatch = existingPatients.find(p => String(p.dni ?? '').trim() === dni);
            }

            if (dniMatch) {
                warningAlert.className = 'alert border-0 shadow-sm d-flex flex-column gap-2 mb-4';
                warningAlert.style.backgroundColor = '#f2faf6';
                warningAlert.style.borderLeft = '4px solid #1b5c3a';

                iconContainer.innerHTML = '';
                const iDni = document.createElement('i');
                iDni.setAttribute('data-lucide', 'alert-circle');
                iDni.className = 'text-primary';
                iDni.style.width = '22px';
                iDni.style.height = '22px';
                iconContainer.appendChild(iDni);
                
                titleEl.textContent = '¡DNI ya registrado!';
                titleEl.style.color = '#0e301e';
                
                msgEl.innerHTML = '';
                msgEl.appendChild(document.createTextNode('El DNI '));
                const s1 = document.createElement('strong');
                s1.textContent = dni;
                msgEl.appendChild(s1);
                msgEl.appendChild(document.createTextNode(' ya pertenece a un paciente registrado: '));
                const s2 = document.createElement('strong');
                s2.textContent = `${dniMatch.nombre} ${dniMatch.apellido}`;
                msgEl.appendChild(s2);
                msgEl.appendChild(document.createTextNode('. Por favor, verifica el documento para evitar expedientes duplicados.'));
                dniInput.classList.add('is-invalid');

                if (typeof lucide !== 'undefined') lucide.createIcons();
            } else if (nameMatch) {
                warningAlert.className = 'alert border-0 shadow-sm d-flex flex-column gap-2 mb-4';
                warningAlert.style.backgroundColor = '#f2faf6';
                warningAlert.style.borderLeft = '4px solid #1b5c3a';

                iconContainer.innerHTML = '';
                const iName = document.createElement('i');
                iName.setAttribute('data-lucide', 'alert-triangle');
                iName.className = 'text-primary';
                iName.style.width = '22px';
                iName.style.height = '22px';
                iconContainer.appendChild(iName);

                titleEl.textContent = 'Posible paciente duplicado';
                titleEl.style.color = '#b45309';
                
                msgEl.innerHTML = '';
                msgEl.appendChild(document.createTextNode('Ya existe un paciente con el nombre '));
                const s3 = document.createElement('strong');
                s3.textContent = `${nameMatch.nombre} ${nameMatch.apellido}`;
                msgEl.appendChild(s3);
                msgEl.appendChild(document.createTextNode(` (DNI: ${nameMatch.dni}). Verifica si es la misma persona para no duplicar su ficha clínica.`));
                dniInput.classList.remove('is-invalid');

                if (typeof lucide !== 'undefined') lucide.createIcons();
            } else {
                warningAlert.className = 'alert border-0 shadow-sm d-none flex-column gap-2 mb-4';
                dniInput.classList.remove('is-invalid');
            }
        }

        // Add real-time event listeners
        nombreInput.addEventListener('input', checkDuplicates);
        apellidoInput.addEventListener('input', checkDuplicates);

        // Strict input sanitization and length helper for DNI (8 digits in Peru)
        dniInput.addEventListener('input', function() {
            // Keep only alphanumeric characters (for DNI/CE)
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');

            // Limit DNI length to 8 characters if numeric, else 12 for CE
            const onlyDigits = /^\d+$/.test(this.value);
            if (onlyDigits && this.value.length > 8) {
                this.value = this.value.substring(0, 8);
            } else if (this.value.length > 12) {
                this.value = this.value.substring(0, 12);
            }

            // Run once on load to highlight if editing invalid input format initially
            checkDuplicates();
        });
        checkDuplicates();
    });
</script>
@endsection
