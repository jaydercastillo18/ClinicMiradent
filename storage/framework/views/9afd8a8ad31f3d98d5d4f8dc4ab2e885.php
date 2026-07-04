<?php $__env->startSection('title', 'Reservar Cita Premium | Miradent'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .booking-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 168, 132, 0.12);
        border-radius: 32px;
        box-shadow: 0 40px 80px -20px rgba(0, 84, 66, 0.15), 0 0 0 4px rgba(255, 255, 255, 0.5) inset;
        padding: clamp(32px, 6vw, 56px);
        margin-top: -20px;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--jade-800);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-input {
        width: 100%;
        background: #ffffff;
        border: 2px solid var(--jade-100);
        border-radius: 16px;
        padding: 16px 20px;
        font-size: 1rem;
        color: var(--jade-950);
        transition: all 0.2s ease;
        outline: none;
        font-family: inherit;
    }
    .form-input:focus {
        background: #ffffff;
        border-color: var(--jade-400);
        box-shadow: 0 0 0 4px rgba(0, 168, 132, 0.1);
    }
    .form-input::placeholder {
        color: #94a3b8;
    }

    .step-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--jade-100);
    }

    .step-number {
        display: grid;
        place-items: center;
        width: 28px;
        height: 28px;
        background: var(--jade-100);
        color: var(--jade-700);
        border-radius: 50%;
        font-size: 0.85rem;
    }

    .choice-card {
        border: 2px solid var(--jade-100);
        border-radius: 20px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .choice-card:hover {
        border-color: var(--jade-300);
        background: var(--jade-50);
        transform: translateY(-2px);
    }

    .choice-card.selected {
        border-color: var(--jade-600);
        background: var(--jade-50);
        box-shadow: 0 10px 20px rgba(0, 168, 132, 0.08);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--jade-700);
        color: #ffffff;
        padding: 18px 32px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.05rem;
        width: 100%;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-submit:hover:not(:disabled) {
        background: var(--jade-950);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 63, 50, 0.15);
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .yape-card {
        background: #ffffff;
        border: 2px dashed var(--jade-200);
        border-radius: 24px;
        padding: 32px 24px;
        text-align: center;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-[140px] pb-10" style="padding-top: 100px; padding-bottom: 40px; background: linear-gradient(180deg, var(--jade-50) 0%, #ffffff 100%); position: relative; overflow: hidden;">
    <!-- Decoración de fondo -->
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(0, 168, 132, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(0, 168, 132, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container-premium text-center" style="position: relative; z-index: 2;">
        <span class="badge-jade" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(4px); display: inline-block; margin-bottom: 16px;">Reserva en 1 minuto</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-jade-950 mt-5 mb-4 tracking-tight" style="font-family: 'Outfit', sans-serif; font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.1; margin-bottom: 16px;">Tu cita empieza aquí</h1>
        <p class="text-jade-800 text-lg max-w-xl mx-auto leading-relaxed" style="max-width: 600px; margin: 0 auto; padding: 0 20px;">Ingresa tus datos y te contactaremos de inmediato por WhatsApp para confirmar tu espacio.</p>
    </div>
</section>

<section class="pb-24" style="padding-bottom: 96px; position: relative;">
    <div class="container-premium" style="max-width: 800px; margin: 0 auto; position: relative; z-index: 2;">
        <div class="booking-card fade-up" id="bookingForm">
            <!-- Datos -->
            <div class="mb-10">
                <div class="step-title">
                    <span class="step-number">1</span>
                    TUS DATOS PERSONALES
                </div>

                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <div>
                        <label class="form-label">Nombre completo *</label>
                        <input id="b_nombre" type="text" required class="form-input" placeholder="Ej. María García López">
                    </div>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px;">
                            <label class="form-label">Teléfono *</label>
                            <input id="b_telefono" type="tel" required class="form-input" placeholder="Ej. 987654321">
                        </div>
                        <div style="flex: 1; min-width: 250px;">
                            <label class="form-label">Correo (opcional)</label>
                            <input id="b_correo" type="email" class="form-input" placeholder="tucorreo@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Motivo de consulta</label>
                        <textarea id="b_motivo" rows="2" class="form-input" placeholder="Limpieza, evaluación, dolor de muela..."></textarea>
                    </div>
                    <div>
                        <label class="form-label">Preferencia de horario</label>
                        <input id="b_horario" type="text" class="form-input" placeholder="Ej. Sábado por la tarde / después de las 5pm">
                    </div>
                </div>
            </div>

            <!-- Elección referido -->
            <div>
                <div class="step-title">
                    <span class="step-number">2</span>
                    ¿TIENES UN REFERIDO?
                </div>

                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div class="choice-card" data-choice="si" onclick="selectChoice('si')" style="flex: 1; min-width: 250px;">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--jade-100); color: var(--jade-700); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--jade-950); font-size: 1.125rem;">Sí, tengo referido</div>
                                <div style="font-size: 0.875rem; font-weight: 500; color: var(--jade-600); margin-top: 2px;">Tu reserva es 100% gratuita</div>
                            </div>
                        </div>
                    </div>
                    <div class="choice-card" data-choice="no" onclick="selectChoice('no')" style="flex: 1; min-width: 250px;">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--jade-100); color: var(--jade-700); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-lucide="user" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--jade-950); font-size: 1.125rem;">No tengo referido</div>
                                <div style="font-size: 0.875rem; font-weight: 500; color: var(--jade-600); margin-top: 2px;">S/ 15 fee de reserva por evaluación</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Referido -->
            <div id="panelSi" class="hidden mt-10" style="border-top: 2px dashed rgba(0, 168, 132, 0.2); margin-top: 32px; padding-top: 32px;">
                <div style="display: flex; justify-content: center; margin-bottom: 24px;">
                    <div style="background: var(--jade-100); color: var(--jade-800); padding: 8px 16px; border-radius: 99px; font-weight: 800; font-size: 0.875rem; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="gift" style="width: 16px; height: 16px;"></i>
                        BENEFICIO: RESERVA GRATIS
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label" for="referido_nombre">Nombre completo del paciente que te refiere *</label>
                        <input type="text" id="referido_nombre" name="referido_nombre" class="form-input"
                               placeholder="Ej. María García López"
                               oninput="resetValidacion()" autocomplete="off">
                    </div>
                    <div style="flex: 1; min-width: 180px;">
                        <label class="form-label" for="referido_dni">DNI del paciente que te refiere (opcional)</label>
                        <input type="text" id="referido_dni" name="referido_dni" class="form-input"
                               placeholder="Ej. 12345678"
                               oninput="resetValidacion()" maxlength="8"
                               pattern="\d{8}" inputmode="numeric">
                    </div>
                </div>

                <div id="validationResult" class="hidden" style="margin-top: 16px; padding: 14px 18px; border-radius: 12px; font-size: 0.9rem; font-weight: 700; border: 2px solid transparent;"></div>

                <div style="display: flex; gap: 16px; margin-top: 24px; flex-wrap: wrap;">
                    <button id="btnValidar" onclick="validarReferidoDB()" class="btn-submit" style="background: var(--jade-800); flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i data-lucide="search" style="width: 20px; height: 20px;"></i> Validar Referido
                    </button>

                    <button id="btnEnviarSi" onclick="enviarReferido()" class="btn-submit hidden" style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg> Enviar a WhatsApp (Gratis)
                    </button>
                </div>
            </div>

            <!-- Panel No Referido / Yape -->
            <div id="panelNo" class="hidden mt-10" style="border-top: 2px dashed rgba(0, 168, 132, 0.2); margin-top: 32px; padding-top: 32px;">
                <div class="yape-card" style="max-width: 500px; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center;">
                    <div style="display: flex; justify-content: center; margin-bottom: 16px;">
                        <span style="background: #742284; color: white; padding: 6px 16px; border-radius: 99px; font-size: 0.75rem; font-weight: 800; letter-spacing: 1px;">MÉTODO DE PAGO</span>
                    </div>
                    <h4 class="text-2xl font-extrabold text-jade-950 mb-2" style="font-size: 1.5rem; margin-bottom: 8px;">Paga S/ 15 con Yape</h4>
                    <p class="text-jade-700 text-sm mb-6 mx-auto" style="margin-bottom: 24px; color: var(--jade-700); max-width: 300px;">Para confirmar tu espacio en la agenda, realiza el pago de la evaluación inicial.</p>

                    <?php if($yapeQrUrl): ?>
                    <img src="<?php echo e($yapeQrUrl); ?>" alt="Yape QR" style="margin: 0 auto 16px auto; width: 200px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; display: block;">
                    <?php else: ?>
                    <div style="margin: 0 auto 24px auto; width: 160px; height: 160px; background: var(--jade-50); border: 1px solid var(--jade-100); display: flex; align-items: center; justify-content: center; border-radius: 24px;">
                        <i data-lucide="qr-code" style="width: 56px; height: 56px; color: var(--jade-400);"></i>
                    </div>
                    <?php endif; ?>

                    <div style="font-size: 1rem; color: var(--jade-800); background: var(--jade-50); padding: 12px 24px; border-radius: 12px; display: inline-block; margin-top: 8px;">
                        Titular Yape: <span style="font-weight: 800; color: var(--jade-950); margin-left: 4px;"><?php echo e($yapePhone ?: $doctora->phone); ?></span>
                    </div>
                </div>

                <div style="max-width: 500px; margin: 24px auto 0 auto;">
                    <button id="btnEnviarNo" onclick="enviarPago()" class="btn-submit" disabled style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Ya realicé el pago • Enviar comprobante
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function selectChoice(choice) {
        document.querySelectorAll('.choice-card').forEach(c => c.classList.remove('selected'));
        document.querySelector(`[data-choice="${choice}"]`).classList.add('selected');

        const si = document.getElementById('panelSi');
        const no = document.getElementById('panelNo');
        const btnSi = document.getElementById('btnEnviarSi');
        const btnNo = document.getElementById('btnEnviarNo');

        if (choice === 'si') {
            si.classList.remove('hidden');
            no.classList.add('hidden');
            btnSi.disabled = false;
            btnNo.disabled = true;
        } else {
            si.classList.add('hidden');
            no.classList.remove('hidden');
            btnSi.disabled = true;
            btnNo.disabled = false;
        }
    }

    function getBasicData() {
        return {
            nombre: document.getElementById('b_nombre').value.trim(),
            telefono: document.getElementById('b_telefono').value.trim(),
            correo: document.getElementById('b_correo').value.trim(),
            motivo: document.getElementById('b_motivo').value.trim(),
            horario: document.getElementById('b_horario').value.trim(),
        };
    }

    function validateBasic() {
        const d = getBasicData();
        if (!d.nombre || !d.telefono) {
            alert('Por favor completa tu nombre y teléfono para poder contactarte.');
            return null;
        }
        return d;
    }

    function openWA(msg) {
        const phone = '<?php echo e($doctora->clean_phone); ?>';
        if (!phone) {
            alert('Contáctanos directamente por teléfono.');
            return;
        }
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(msg)}`, '_blank');
    }

    let isReferidoValid = false;

    function mostrarResultadoValidacion(resultDiv, valido, message) {
        // Usar creación segura de nodos — nunca innerHTML con datos del servidor
        resultDiv.textContent = '';

        const icono = document.createElement('span');
        icono.setAttribute('aria-hidden', 'true');
        icono.textContent = valido ? '✓ ' : '✗ ';

        const texto = document.createElement('span');
        texto.textContent = message;

        resultDiv.appendChild(icono);
        resultDiv.appendChild(texto);
        resultDiv.classList.remove('hidden');

        if (valido) {
            resultDiv.style.background = '#f0fdf4';
            resultDiv.style.borderColor = '#bbf7d0';
            resultDiv.style.color = '#15803d';
        } else {
            resultDiv.style.background = '#fff1f2';
            resultDiv.style.borderColor = '#fecdd3';
            resultDiv.style.color = '#be123c';
        }
    }

    function resetValidacion() {
        isReferidoValid = false;
        document.getElementById('btnEnviarSi').classList.add('hidden');
        document.getElementById('btnValidar').classList.remove('hidden');
        const resultDiv = document.getElementById('validationResult');
        resultDiv.classList.add('hidden');
        resultDiv.textContent = '';
        resultDiv.style.borderColor = 'transparent';
    }

    async function validarReferidoDB() {
        const nombre = document.getElementById('referido_nombre').value.trim();
        const dni = document.getElementById('referido_dni').value.trim();

        if (!nombre || nombre.length < 3) {
            alert('Ingresa el nombre completo del paciente que te refiere.');
            return;
        }
        if (dni && !/^\d{8}$/.test(dni)) {
            alert('El DNI del referido debe contener exactamente 8 dígitos numéricos.');
            return;
        }

        const btnValidar = document.getElementById('btnValidar');
        const textoOriginal = btnValidar.textContent;
        btnValidar.textContent = 'Validando...';
        btnValidar.disabled = true;

        try {
            const response = await window.axios.post('<?php echo e(route("public.validar-referido")); ?>', {
                referido_nombre: nombre,
                referido_dni: dni,
            });

            const data = response.data;
            const resultDiv = document.getElementById('validationResult');

            if (data.valid) {
                isReferidoValid = true;
                mostrarResultadoValidacion(resultDiv, true, data.message);
                btnValidar.classList.add('hidden');
                document.getElementById('btnEnviarSi').classList.remove('hidden');
                document.getElementById('btnEnviarSi').disabled = false;
            } else {
                isReferidoValid = false;
                mostrarResultadoValidacion(resultDiv, false, data.message);
            }
        } catch (error) {
            const resultDiv = document.getElementById('validationResult');
            const status = error.response?.status;

            let msg = 'Ocurrió un error al validar. Intenta nuevamente.';
            if (status === 422) {
                msg = 'Revisa los datos ingresados e intenta de nuevo.';
            } else if (status === 429) {
                msg = 'Demasiados intentos. Espera un momento antes de intentar nuevamente.';
            }

            mostrarResultadoValidacion(resultDiv, false, msg);
        } finally {
            btnValidar.textContent = textoOriginal;
            btnValidar.disabled = false;
        }
    }

    function enviarReferido() {
        if (!isReferidoValid) {
            alert('Primero debes validar el referido.');
            return;
        }
        const datos = validateBasic();
        if (!datos) return;

        const refNombre = document.getElementById('referido_nombre').value.trim();
        if (!refNombre) {
            alert('Indica el nombre del referido para validar la promoción.');
            return;
        }

        let msg = `Hola Miradent, quiero reservar una cita.\n\n`;
        msg += `*Mis Datos:*\n- Nombre: ${datos.nombre}\n- Teléfono: ${datos.telefono}\n`;
        if (datos.correo) msg += `- Correo: ${datos.correo}\n`;
        if (datos.motivo) msg += `- Motivo: ${datos.motivo}\n`;
        if (datos.horario) msg += `- Preferencia: ${datos.horario}\n`;
        msg += `\n*Vengo referido por:* ${refNombre}\n\nAplico a la reserva gratuita por referido validado.`;

        openWA(msg);
    }

    function enviarPago() {
        const datos = validateBasic();
        if (!datos) return;

        let msg = `Hola Miradent, quiero reservar una cita.\n\n`;
        msg += `*Mis Datos:*\n- Nombre: ${datos.nombre}\n- Teléfono: ${datos.telefono}\n`;
        if (datos.correo) msg += `- Correo: ${datos.correo}\n`;
        if (datos.motivo) msg += `- Motivo: ${datos.motivo}\n`;
        if (datos.horario) msg += `- Preferencia: ${datos.horario}\n`;
        msg += `\n*Ya realicé el pago del fee (S/ 15) por Yape.*\nTe envío la captura del comprobante a continuación:`;

        openWA(msg);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/reservar_cita.blade.php ENDPATH**/ ?>