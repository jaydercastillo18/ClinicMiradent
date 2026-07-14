import axios from 'axios';

function showMiradentAlert(message, type = 'success') {
    const main = document.querySelector('.content-main');

    if (!main) {
        return;
    }

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} border-0 shadow-sm d-flex align-items-center gap-3 mb-4 miradent-js-alert`;
    alert.setAttribute('role', 'alert');
    alert.style.borderRadius = '12px';
    alert.style.padding = '14px 20px';

    const icon = document.createElement('i');
    icon.setAttribute('data-lucide', type === 'success' ? 'check-circle' : 'alert-circle');
    icon.style.width = '24px';
    icon.style.height = '24px';
    icon.style.flexShrink = '0';

    const text = document.createElement('div');
    text.style.fontWeight = '500';
    text.textContent = message;

    alert.append(icon, text);

    main.querySelectorAll('.miradent-js-alert').forEach((item) => item.remove());
    main.prepend(alert);

    if (window.lucide) {
        window.lucide.createIcons();
    }

    setTimeout(() => alert.remove(), 4500);
}

function clearValidationErrors(form) {
    form.querySelectorAll('.is-invalid').forEach((el) => {
        el.classList.remove('is-invalid');
    });
    form.querySelectorAll('.invalid-feedback.miradent-axios-error').forEach((el) => {
        el.remove();
    });
}

function renderValidationErrors(form, errors) {
    clearValidationErrors(form);
    
    for (const [field, messages] of Object.entries(errors)) {
        let input = form.querySelector(`[name="${field}"]`);
        
        if (!input && field.includes('.')) {
            const parts = field.split('.');
            const arrayName = `${parts[0]}[${parts.slice(1).join('][')}]`;
            input = form.querySelector(`[name="${arrayName}"]`);
        }

        if (input) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback miradent-axios-error';
            errorDiv.textContent = messages[0];
            input.parentNode.insertBefore(errorDiv, input.nextSibling);
        }
    }
}

function getAxiosErrorMessage(error) {
    const status = error.response?.status;
    const data = error.response?.data;

    if (!error.response) {
        return 'No se pudo conectar con el servidor. Compruebe su conexión a internet.';
    }

    if (status === 401) {
        window.location.href = '/login';
        return 'Su sesión ha terminado. Redirigiendo al inicio de sesión...';
    }

    if (status === 403) {
        return 'Acceso denegado. No tiene permisos para realizar esta acción.';
    }

    if (status === 419) {
        return 'La página o el token de seguridad ha expirado. Por favor, recargue la página e inténtelo de nuevo.';
    }

    if (status === 422) {
        return data?.message || 'Los datos proporcionados no son válidos. Por favor, revise el formulario.';
    }

    if (status === 429) {
        return 'Demasiadas peticiones. Por favor, espere unos segundos e inténtelo de nuevo.';
    }

    if (status === 500) {
        return 'Ha ocurrido un error interno en el servidor. Por favor, inténtelo más tarde.';
    }

    if (error instanceof Error && !error.response) {
        return error.message || 'No se pudo completar la operación. Revise los datos e inténtelo nuevamente.';
    }

    return data?.message || 'No se pudo completar la operación. Revise los datos e inténtelo nuevamente.';
}

function logAxiosError(context, error) {
    const type = error.isLogicError
        ? 'Logic Error (success:false)'
        : !error.config
        ? 'JS Error'
        : !error.response
        ? 'Network Error'
        : `HTTP ${error.response.status}`;

    console.error(`[Miradent ${type} - ${context}]`, {
        url: error.config?.url ?? 'Desconocida',
        method: error.config?.method?.toUpperCase() ?? 'Desconocido',
        status: error.response?.status ?? 'N/A',
        message: error.response?.data?.message ?? error.message ?? 'Sin mensaje',
    });
}

function toggleSubmitButton(form, disabled) {
    const button = form.querySelector('[type="submit"]');

    if (!button) {
        return;
    }

    if (disabled) {
        button.dataset.originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>';
        return;
    }

    button.disabled = false;
    button.innerHTML = button.dataset.originalHtml || button.innerHTML;
}

function dispatchAxiosSuccessEvent(form, detail) {
    form.dispatchEvent(new CustomEvent('miradent:form-success', {
        bubbles: true,
        detail: detail,
    }));
}

const modalInstances = new WeakMap();

class MiradentModal {
    constructor(element) {
        this.element = element;
        modalInstances.set(element, this);
    }

    show() {
        if (!this.element) {
            return;
        }

        document.querySelectorAll('.modal.show').forEach((modal) => {
            if (modal !== this.element) {
                getMiradentModal(modal).hide();
            }
        });

        this.element.style.display = 'block';
        this.element.removeAttribute('aria-hidden');
        this.element.setAttribute('aria-modal', 'true');
        this.element.setAttribute('role', 'dialog');

        requestAnimationFrame(() => {
            this.element.classList.add('show');
            document.body.classList.add('modal-open');
        });

        const focusable = this.element.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');

        if (focusable) {
            focusable.focus({ preventScroll: true });
        }
    }

    hide() {
        if (!this.element) {
            return;
        }

        this.element.classList.remove('show');
        this.element.setAttribute('aria-hidden', 'true');
        this.element.removeAttribute('aria-modal');

        setTimeout(() => {
            if (!this.element.classList.contains('show')) {
                this.element.style.display = 'none';
            }

            if (!document.querySelector('.modal.show')) {
                document.body.classList.remove('modal-open');
            }
        }, 150);
    }
}

function resolveElement(target) {
    if (!target) {
        return null;
    }

    if (target instanceof Element) {
        return target;
    }

    return document.querySelector(target);
}

function getMiradentModal(target) {
    const element = resolveElement(target);

    if (!element) {
        return null;
    }

    return modalInstances.get(element) || new MiradentModal(element);
}

function closeOpenDropdowns(exceptToggle = null) {
    document.querySelectorAll('[data-ui-toggle="dropdown"][aria-expanded="true"]').forEach((toggle) => {
        if (toggle === exceptToggle) {
            return;
        }

        toggle.setAttribute('aria-expanded', 'false');
        toggle.closest('.dropdown')?.querySelector('.dropdown-menu')?.classList.remove('show');
    });
}

function toggleDropdown(toggle) {
    const menu = toggle.closest('.dropdown')?.querySelector('.dropdown-menu');

    if (!menu) {
        return;
    }

    const isOpen = menu.classList.contains('show');
    closeOpenDropdowns(isOpen ? null : toggle);
    menu.classList.toggle('show', !isOpen);
    toggle.setAttribute('aria-expanded', String(!isOpen));
}

function activateTab(toggle) {
    const target = resolveElement(toggle.dataset.uiTarget);

    if (!target) {
        return;
    }

    const tabList = toggle.closest('[role="tablist"]') || toggle.closest('.nav') || document;
    tabList.querySelectorAll('[data-ui-toggle="pill"]').forEach((item) => {
        item.classList.remove('active');
        item.setAttribute('aria-selected', 'false');
    });

    toggle.classList.add('active');
    toggle.setAttribute('aria-selected', 'true');

    const container = target.parentElement || document;
    container.querySelectorAll('.tab-pane').forEach((pane) => {
        pane.classList.remove('active', 'show');
    });

    target.classList.add('active', 'show');
}

window.miradentModal = getMiradentModal;

document.addEventListener('click', function (event) {
    const dismiss = event.target.closest('[data-ui-dismiss="modal"]');
    const toggle = event.target.closest('[data-ui-toggle]');

    if (dismiss) {
        event.preventDefault();
        getMiradentModal(dismiss.closest('.modal'))?.hide();
    }

    if (!toggle) {
        closeOpenDropdowns();
        return;
    }

    if (toggle.dataset.uiToggle === 'modal') {
        event.preventDefault();
        const modal = getMiradentModal(toggle.dataset.uiTarget);

        if (modal) {
            setTimeout(() => modal.show(), dismiss ? 150 : 0);
        }
    }

    if (toggle.dataset.uiToggle === 'dropdown') {
        event.preventDefault();
        toggleDropdown(toggle);
    }

    if (toggle.dataset.uiToggle === 'pill') {
        event.preventDefault();
        activateTab(toggle);
    }
});

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal')) {
        getMiradentModal(event.target)?.hide();
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') {
        return;
    }

    closeOpenDropdowns();
    const openModal = document.querySelector('.modal.show');

    if (openModal) {
        getMiradentModal(openModal)?.hide();
    }
});

// ─── Global image compression (keeps uploads under Vercel's 4.5 MB limit) ────
const IMG_MAX_WIDTH   = 1200;  // px
const IMG_JPEG_QUALITY = 0.82; // 82%

function compressImageFile(file) {
    return new Promise((resolve) => {
        if (!file.type.startsWith('image/') || file.size === 0) {
            resolve(file);
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                let width  = img.width;
                let height = img.height;

                if (width > IMG_MAX_WIDTH) {
                    height = Math.round(height * IMG_MAX_WIDTH / width);
                    width  = IMG_MAX_WIDTH;
                }

                const canvas = document.createElement('canvas');
                canvas.width  = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);

                canvas.toBlob(function (blob) {
                    const baseName = file.name.replace(/\.[^/.]+$/, '');
                    resolve(new File([blob], baseName + '.jpg', { type: 'image/jpeg' }));
                }, 'image/jpeg', IMG_JPEG_QUALITY);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

async function buildCompressedFormData(form) {
    const raw = new FormData(form);
    const out = new FormData();
    const jobs = [];

    for (const [key, value] of raw.entries()) {
        if (value instanceof File && value.size > 0 && value.type.startsWith('image/')) {
            jobs.push(compressImageFile(value).then((compressed) => ({ key, value: compressed })));
        } else {
            out.append(key, value);
        }
    }

    const results = await Promise.all(jobs);
    results.forEach(({ key, value }) => out.append(key, value));
    return out;
}
// ─────────────────────────────────────────────────────────────────────────────

async function submitAxiosForm(form) {
    if (form.dataset.axiosSubmitting === 'true') {
        return;
    }

    form.dataset.axiosSubmitting = 'true';
    toggleSubmitButton(form, true);
    clearValidationErrors(form);

    try {
        const formData = await buildCompressedFormData(form);
        const response = await axios.post(form.action, formData);
        
        // Evitar que el sistema parezca que funcionó si el backend devuelve success: false con status 200
        if (response.data && response.data.success === false) {
            const err = new Error(response.data.message || 'Operación fallida.');
            err.response = response;
            err.config = response.config;
            err.isLogicError = true;
            throw err;
        }

        const modalElement = form.closest('.modal');
        const openModal = modalElement ? getMiradentModal(modalElement) : null;

        if (form.dataset.axiosCloseModal === 'true' && openModal) {
            openModal.hide();
        } else if (openModal && form.dataset.axiosNoReload !== 'true') {
            // Legacy behavior compatibility: close modal on success before reload
            openModal.hide();
        }

        showMiradentAlert(response.data?.message || 'Operación realizada correctamente.');
        dispatchAxiosSuccessEvent(form, response.data);

        if (form.dataset.axiosReset === 'true') {
            form.reset();
        }

        if (form.dataset.axiosRedirect) {
            setTimeout(() => {
                window.location.href = form.dataset.axiosRedirect;
            }, 650);
            return;
        }

        if (form.dataset.axiosRefresh === 'true') {
            setTimeout(() => window.location.reload(), 650);
            return;
        } 
        
        // Solo restaurar el botón si no vamos a recargar/redirigir
        toggleSubmitButton(form, false);
        delete form.dataset.axiosSubmitting;
    } catch (error) {
        logAxiosError('Submit', error);

        const status = error.response?.status;
        showMiradentAlert(getAxiosErrorMessage(error), 'danger');

        if (status === 422 && error.response?.data?.errors) {
            renderValidationErrors(form, error.response.data.errors);
        }

        toggleSubmitButton(form, false);
        delete form.dataset.axiosSubmitting;
    }
}

async function deleteAxiosResource(form) {
    if (form.dataset.axiosSubmitting === 'true') {
        return;
    }

    const confirmation = form.getAttribute('data-confirm');

    if (confirmation && !window.confirm(confirmation)) {
        return;
    }

    form.dataset.axiosSubmitting = 'true';
    toggleSubmitButton(form, true);

    try {
        const response = await axios.delete(form.action);
        
        if (response.data && response.data.success === false) {
            const err = new Error(response.data.message || 'Operación fallida.');
            err.response = response;
            err.config = response.config;
            err.isLogicError = true;
            throw err;
        }

        const modalElement = form.closest('.modal');
        const openModal = modalElement ? getMiradentModal(modalElement) : null;
        
        let removable = null;
        if (form.dataset.axiosRemoveTarget) {
            removable = document.querySelector(form.dataset.axiosRemoveTarget);
        } else {
            removable = form.closest('[data-axios-removable]') || form.closest('tr') || form.closest('.card') || form;
        }

        if (removable) {
            removable.remove();
        }

        if (form.dataset.axiosCloseModal === 'true' && openModal) {
            openModal.hide();
        } else if (openModal && form.dataset.axiosNoReload !== 'true') {
            openModal.hide();
        }

        showMiradentAlert(response.data?.message || 'Registro eliminado correctamente.');
        dispatchAxiosSuccessEvent(form, response.data);

        if (form.dataset.axiosRedirect) {
            setTimeout(() => {
                window.location.href = form.dataset.axiosRedirect;
            }, 650);
            return;
        }

        if (form.dataset.axiosRefresh === 'true') {
            // Keep timeout for alert visibility before reloading
            setTimeout(() => window.location.reload(), 650);
            return;
        }

        toggleSubmitButton(form, false);
        delete form.dataset.axiosSubmitting;
    } catch (error) {
        logAxiosError('Delete', error);

        showMiradentAlert(getAxiosErrorMessage(error), 'danger');
        toggleSubmitButton(form, false);
        delete form.dataset.axiosSubmitting;
    }
}

document.addEventListener('submit', function (event) {
    const submitForm = event.target.closest('form[data-axios-submit]');
    if (submitForm) {
        event.preventDefault();
        submitAxiosForm(submitForm);
        return;
    }

    const deleteForm = event.target.closest('form[data-axios-delete]');
    if (deleteForm) {
        event.preventDefault();
        deleteAxiosResource(deleteForm);
        return;
    }
});
