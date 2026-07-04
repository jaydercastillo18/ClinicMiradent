<?php $__env->startSection('title', 'Editar Paciente'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Editar Paciente</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Modifica el expediente clínico de <strong><?php echo e($paciente->nombre); ?> <?php echo e($paciente->apellido); ?></strong>.</p>
        </div>
        <div>
            <?php if(request()->ajax()): ?>
            <button type="button" class="btn btn-light border d-flex align-items-center gap-2" data-ui-dismiss="modal" style="font-weight: 500; padding: 10px 18px; border-radius: 10px;">
                <i data-lucide="x" style="width: 18px; height: 18px;"></i> Cerrar
            </button>
            <?php else: ?>
            <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-light border d-flex align-items-center gap-2" style="font-weight: 500; padding: 10px 18px; border-radius: 10px;">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> Volver al listado
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Error Summary Alert -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-3 mb-4" role="alert" style="background-color: #f2faf6; color: #0e301e; border-radius: 12px; padding: 16px 20px;">
            <i data-lucide="alert-circle" style="width: 24px; height: 24px; flex-shrink: 0; color: #1b5c3a; margin-top: 2px;"></i>
            <div>
                <h6 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Por favor corrige los siguientes errores:</h6>
                <ul class="mb-0 ps-3" style="font-size: 0.9rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('pacientes.update', $paciente->id)); ?>" method="POST" data-axios-submit data-axios-no-reload="true" data-axios-close-modal="true" id="form-editpaciente">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

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
                                <input type="text" name="nombre" id="nombre" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nombre', $paciente->nombre)); ?>" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-12 col-md-6">
                                <label for="apellido" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Apellidos <span class="text-primary">*</span></label>
                                <input type="text" name="apellido" id="apellido" class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('apellido', $paciente->apellido)); ?>" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- DNI -->
                            <div class="col-12 col-md-4">
                                <label for="dni" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">DNI / Documento <span class="text-primary">*</span></label>
                                <input type="text" name="dni" id="dni" class="form-control <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('dni', $paciente->dni)); ?>" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-12 col-md-4">
                                <label for="telefono" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Teléfono de Contacto</label>
                                <input type="text" name="telefono" id="telefono" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('telefono', $paciente->telefono)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-4">
                                <label for="email" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $paciente->email)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Fecha Nacimiento -->
                            <div class="col-12 col-md-4">
                                <label for="fecha_nacimiento" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('fecha_nacimiento', $paciente->fecha_nacimiento)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Género -->
                            <div class="col-12 col-md-4">
                                <label for="genero" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Género</label>
                                <select name="genero" id="genero" class="form-select <?php $__errorArgs = ['genero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino" <?php echo e(old('genero', $paciente->genero) == 'Masculino' ? 'selected' : ''); ?>>Masculino</option>
                                    <option value="Femenino" <?php echo e(old('genero', $paciente->genero) == 'Femenino' ? 'selected' : ''); ?>>Femenino</option>
                                    <option value="Otro" <?php echo e(old('genero', $paciente->genero) == 'Otro' ? 'selected' : ''); ?>>Otro</option>
                                </select>
                                <?php $__errorArgs = ['genero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Tipo Sangre -->
                            <div class="col-12 col-md-4">
                                <label for="tipo_sangre" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Grupo Sanguíneo</label>
                                <select name="tipo_sangre" id="tipo_sangre" class="form-select <?php $__errorArgs = ['tipo_sangre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                    <option value="">Seleccionar...</option>
                                    <?php $__currentLoopData = ['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB-', 'AB+']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blood): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($blood); ?>" <?php echo e(old('tipo_sangre', $paciente->tipo_sangre) == $blood ? 'selected' : ''); ?>><?php echo e($blood); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tipo_sangre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Dirección -->
                            <div class="col-12">
                                <label for="direccion" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Dirección de Domicilio</label>
                                <textarea name="direccion" id="direccion" rows="2" class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; border-color: var(--border-color);"><?php echo e(old('direccion', $paciente->direccion)); ?></textarea>
                                <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                <textarea name="antecedentes_medicos" id="antecedentes_medicos" rows="3" class="form-control <?php $__errorArgs = ['antecedentes_medicos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; border-color: var(--border-color);"><?php echo e(old('antecedentes_medicos', $paciente->antecedentes_medicos)); ?></textarea>
                                <?php $__errorArgs = ['antecedentes_medicos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Alergias -->
                            <div class="col-12">
                                <label for="alergias" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Alergias Conocidas</label>
                                <textarea name="alergias" id="alergias" rows="2" class="form-control <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; border-color: var(--border-color);"><?php echo e(old('alergias', $paciente->alergias)); ?></textarea>
                                <?php $__errorArgs = ['alergias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Medicamentos Habituales -->
                            <div class="col-12">
                                <label for="medicamentos_habituales" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Medicamentos de Uso Diario</label>
                                <textarea name="medicamentos_habituales" id="medicamentos_habituales" rows="2" class="form-control <?php $__errorArgs = ['medicamentos_habituales'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-radius: 8px; border-color: var(--border-color);"><?php echo e(old('medicamentos_habituales', $paciente->medicamentos_habituales)); ?></textarea>
                                <?php $__errorArgs = ['medicamentos_habituales'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                <input type="text" name="contacto_emergencia_nombre" id="contacto_emergencia_nombre" class="form-control <?php $__errorArgs = ['contacto_emergencia_nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('contacto_emergencia_nombre', $paciente->contacto_emergencia_nombre)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['contacto_emergencia_nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Teléfono Contacto -->
                            <div class="col-12">
                                <label for="contacto_emergencia_telefono" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Teléfono</label>
                                <input type="text" name="contacto_emergencia_telefono" id="contacto_emergencia_telefono" class="form-control <?php $__errorArgs = ['contacto_emergencia_telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('contacto_emergencia_telefono', $paciente->contacto_emergencia_telefono)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['contacto_emergencia_telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Parentesco -->
                            <div class="col-12">
                                <label for="contacto_emergencia_parentesco" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Parentesco / Relación</label>
                                <input type="text" name="contacto_emergencia_parentesco" id="contacto_emergencia_parentesco" class="form-control <?php $__errorArgs = ['contacto_emergencia_parentesco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('contacto_emergencia_parentesco', $paciente->contacto_emergencia_parentesco)); ?>" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                                <?php $__errorArgs = ['contacto_emergencia_parentesco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Action Panel -->
                <div class="card border-0 shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color) !important; background-color: #fafbfc;">
                    <div class="card-body p-4 d-flex flex-column gap-3">
                        <button type="submit" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2 fw-semibold" style="background-color: var(--primary); border-color: var(--primary); border-radius: 10px; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(32,127,84,0.15);">
                            <i data-lucide="check" style="width: 18px; height: 18px;"></i>
                            Guardar Cambios
                        </button>
                        
                        <?php if(request()->ajax()): ?>
                        <button type="button" class="btn btn-outline-secondary w-100 py-3" data-ui-dismiss="modal" style="border-radius: 10px; font-weight: 500; font-size: 0.95rem;">
                            Cancelar
                        </button>
                        <?php else: ?>
                        <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-outline-secondary w-100 py-3" style="border-radius: 10px; font-weight: 500; font-size: 0.95rem; text-align: center; text-decoration: none;">
                            Cancelar y volver
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const existingPatients = <?php echo json_encode($existingPatients ?? [], 15, 512) ?>;
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        const dniInput = document.getElementById('dni');
        
        // Container for warning alert
        const formContainer = document.querySelector('form');
        const warningAlert = document.createElement('div');
        warningAlert.className = 'alert border-0 shadow-sm d-none flex-column gap-2 mb-4';
        warningAlert.style.borderRadius = '12px';
        warningAlert.style.padding = '16px 20px';
        warningAlert.style.transition = 'all 0.3s ease';
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

            const iconContainer = document.getElementById('warning_icon_container');
            const titleEl = document.getElementById('warning_title');
            const msgEl = document.getElementById('warning_message');

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
                msgEl.appendChild(document.createTextNode(' ya pertenece a otro paciente registrado: '));
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
                msgEl.appendChild(document.createTextNode('Ya existe otro paciente con el nombre '));
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
            
            checkDuplicates();
        });
        
        // Run once on load to highlight if editing invalid input format initially
        checkDuplicates();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/editpaciente.blade.php ENDPATH**/ ?>