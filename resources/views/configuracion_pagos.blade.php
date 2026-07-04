@extends('layouts.plantilla')

@section('title', 'Configuración de Pagos')

@section('styles')
<style>
    .config-wrapper {
        background-color: #f8fafc;
        border-radius: 24px;
        padding: 2rem;
    }
    
    .striking-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }

    /* Input Moderno */
    .modern-input {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s;
        font-size: 0.95rem;
        color: #0f172a;
    }
    .modern-input:focus {
        background-color: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        outline: none;
    }

    /* File Input Personalizado */
    .file-drop-area {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 2rem;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .file-drop-area:hover, .file-drop-area.dragover {
        background-color: #f0fdf4;
        border-color: var(--primary);
    }
    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
    }
    
    /* QR Display Showcase */
    .qr-showcase {
        background: linear-gradient(145deg, #0f172a, #1e293b);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.2);
        overflow: hidden;
    }
    .qr-showcase::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(32,127,84,0.4) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
    }
    .qr-image-wrapper {
        position: relative;
        z-index: 2;
        padding: 10px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        transition: transform 0.3s;
    }
    .qr-image-wrapper:hover {
        transform: scale(1.02);
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="config-wrapper">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge" style="background-color: var(--primary); color: white; font-weight: 700; font-size: 0.75rem; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 10px rgba(32,127,84,0.3);">
                        <i data-lucide="wallet" style="width: 12px; height: 12px; margin-right: 4px; margin-top: -2px;"></i> Facturación
                    </span>
                </div>
                <h1 class="mb-1" style="font-weight: 800; color: #0f172a; font-family: 'Outfit', sans-serif; font-size: 2rem; letter-spacing: -0.5px;">
                    Configuración de Pagos
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem; color: #64748b;">
                    Administra el código QR y cuenta receptora para los pacientes.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Current QR Showcase -->
            <div class="col-12 col-lg-5">
                <div class="qr-showcase h-100">
                    <div class="position-relative z-index-2 w-100 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                            <i data-lucide="scan-line" style="color: #34d399; width: 24px; height: 24px;"></i>
                            <h5 class="text-white fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">QR Activo</h5>
                        </div>
                        <p style="color: #94a3b8; font-size: 0.85rem;">Este es el código que ven los pacientes al reservar</p>
                    </div>

                    @if($yapeQrUrl)
                        <div class="qr-image-wrapper">
                            <img src="{{ $yapeQrUrl }}" alt="QR de Yape/Plin" class="img-fluid" style="border-radius: 10px; max-width: 240px; display: block;">
                        </div>
                    @else
                        <div class="qr-image-wrapper" style="width: 220px; height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f1f5f9;">
                            <i data-lucide="qr-code" style="width: 64px; height: 64px; color: #cbd5e1; margin-bottom: 12px;"></i>
                            <span class="text-muted fw-bold" style="font-size: 0.9rem;">Sin código QR</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Settings Form -->
            <div class="col-12 col-lg-7">
                <div class="striking-card p-4 p-md-5 h-100">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary-light), #d1fae5); color: var(--primary);">
                                <i data-lucide="upload-cloud" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-slate-800" style="font-family: 'Outfit', sans-serif;">Actualizar Datos</h4>
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Sube una nueva imagen o cambia el número asociado.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('payment-settings.update') }}" method="POST" enctype="multipart/form-data" data-axios-submit data-axios-refresh="true">
                        @csrf
                        @method('PUT')

                        <!-- Custom File Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-slate-700 mb-2" style="font-size: 0.95rem;">Nueva Imagen del QR</label>
                            
                            <div class="file-drop-area" id="fileDropArea">
                                <i data-lucide="image-plus" style="width: 42px; height: 42px; color: var(--primary); margin-bottom: 12px;"></i>
                                <span class="fw-bold text-slate-700 mb-1" id="fileNameDisplay" style="font-size: 1.05rem;">Haz clic o arrastra una imagen</span>
                                <span class="text-muted text-center" style="font-size: 0.85rem;">Formatos soportados: JPG, PNG, WEBP (Max: 4MB).<br>Si no seleccionas nada, se conservará la imagen actual.</span>
                                <input type="file" name="yape_qr" id="yape_qr" class="file-input" accept="image/png,image/jpeg,image/webp">
                            </div>
                        </div>

                        <!-- Phone Input -->
                        <div class="mb-4">
                            <label for="yape_phone" class="form-label fw-bold text-slate-700 mb-2" style="font-size: 0.95rem;">Número Titular a mostrar</label>
                            <div class="position-relative">
                                <i data-lucide="smartphone" class="position-absolute" style="top: 14px; left: 16px; width: 18px; height: 18px; color: #64748b;"></i>
                                <input type="text" name="yape_phone" id="yape_phone" class="form-control modern-input w-100" style="padding-left: 44px;" value="{{ old('yape_phone', $yapePhone) }}" placeholder="Ej. 987 654 321">
                            </div>
                            <small class="text-muted d-block mt-2" style="font-size: 0.8rem;"><i data-lucide="info" style="width: 12px; height: 12px; margin-top: -2px; display: inline-block;"></i> Si se deja en blanco, el sistema mostrará el número de WhatsApp de la doctora por defecto.</small>
                        </div>

                        <div class="mt-5 pt-4 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5 py-3 d-flex align-items-center gap-2" style="background: linear-gradient(135deg, var(--primary), #0f5132); border: none; border-radius: 14px; font-weight: 700; font-size: 1.05rem; box-shadow: 0 8px 20px rgba(32, 127, 84, 0.3); transition: transform 0.2s, box-shadow 0.2s;">
                                <i data-lucide="upload" style="width: 20px; height: 20px;"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('yape_qr');
        const fileDropArea = document.getElementById('fileDropArea');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const icon = fileDropArea.querySelector('i');

        // Update name when file is selected
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.style.color = 'var(--primary)';
                
                // Change icon
                if (typeof lucide !== 'undefined') {
                    const iconElement = document.createElement('i');
                    iconElement.setAttribute('data-lucide', 'check-circle-2');
                    iconElement.style.width = '42px';
                    iconElement.style.height = '42px';
                    iconElement.style.color = '#10b981';
                    iconElement.style.marginBottom = '12px';
                    
                    fileDropArea.replaceChild(iconElement, icon);
                    lucide.createIcons({
                        root: fileDropArea
                    });
                }
            } else {
                fileNameDisplay.textContent = 'Haz clic o arrastra una imagen';
                fileNameDisplay.style.color = '';
            }
        });

        // Drag and drop effects
        fileDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileDropArea.classList.add('dragover');
        });

        ['dragleave', 'dragend', 'drop'].forEach(eventName => {
            fileDropArea.addEventListener(eventName, (e) => {
                fileDropArea.classList.remove('dragover');
            });
        });
    });
</script>
@endsection
