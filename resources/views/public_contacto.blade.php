@extends('layouts.public')

@section('title', 'Contacto | Miradent')

@section('styles')
<style>
    .contact-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 28px;
        box-shadow: 0 15px 40px -10px rgba(0, 84, 66, 0.08);
        overflow: hidden;
    }
    .profile-image-container {
        position: relative;
        padding: 6px;
        background: linear-gradient(135deg, var(--jade-100), var(--jade-50));
        border-radius: 50%;
        width: 160px;
        height: 160px;
        flex-shrink: 0;
    }
    @media (min-width: 768px) {
        .profile-image-container {
            width: 190px;
            height: 190px;
        }
    }
    .profile-image {
        border-radius: 50%;
        width: 100%;
        height: 100%;
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .info-card {
        background: #ffffff;
        border: 1px solid var(--jade-100);
        border-radius: 20px;
        padding: 16px 20px;
        display: flex;
        gap: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .info-card:hover {
        border-color: var(--jade-300);
        box-shadow: 0 10px 25px rgba(0, 168, 132, 0.06);
        transform: translateY(-2px);
    }
    .icon-box {
        width: 44px;
        height: 44px;
        background: var(--jade-50);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--jade-600);
        flex-shrink: 0;
    }
    .btn-whatsapp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #25D366;
        color: #ffffff;
        padding: 16px 28px;
        border-radius: 18px;
        font-weight: 800;
        font-size: 1.05rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        width: 100%;
        box-shadow: 0 8px 20px rgba(37, 211, 102, 0.25);
    }
    .btn-whatsapp:hover {
        background: #128C7E;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(37, 211, 102, 0.35);
    }
    .map-container {
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid var(--jade-100);
        box-shadow: 0 15px 35px rgba(0, 84, 66, 0.06);
        height: 100%;
        min-height: 420px;
        position: relative;
    }

    /* Layout Classes para reemplazar Tailwind */
    .contacto-page-header {
        padding-top: 140px;
        padding-bottom: 32px;
        text-align: center;
    }
    .contacto-page-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 16px 0 12px 0;
        font-family: 'Outfit', sans-serif;
    }
    .contacto-page-header p {
        font-size: 1.1rem;
        color: var(--jade-800);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .doctora-card-container {
        padding-bottom: 48px;
        max-width: 900px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .doctora-flex {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: center;
        text-align: center;
    }
    @media (min-width: 768px) {
        .doctora-flex {
            flex-direction: row;
            text-align: left;
        }
    }
    .doctora-info {
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    @media (min-width: 768px) {
        .doctora-info {
            align-items: flex-start;
        }
    }
    .doctora-info h2 {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 12px;
        font-family: 'Outfit', sans-serif;
    }
    .doctora-info p {
        font-size: 1rem;
        color: var(--jade-800);
        line-height: 1.6;
        margin-bottom: 20px;
        max-width: 500px;
    }
    .badge-cop {
        display: inline-flex;
        align-items: center;
        gap: 16px;
        padding: 12px 20px;
        background: var(--jade-50);
        border: 1px solid var(--jade-100);
        border-radius: 16px;
        text-align: left;
    }
    .badge-cop-icon {
        width: 40px;
        height: 40px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--jade-600);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        flex-shrink: 0;
    }
    .clinica-container {
        padding-bottom: 80px;
        max-width: 1152px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .clinica-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        background: rgba(240, 253, 250, 0.5); /* jade-50/50 */
        padding: 24px;
        border-radius: 36px;
        border: 1px solid var(--jade-50);
    }
    @media (min-width: 900px) {
        .clinica-grid {
            grid-template-columns: 1fr 1fr;
            padding: 40px;
        }
    }
    .clinica-info-col {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .clinica-info-col h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 24px;
        font-family: 'Outfit', sans-serif;
    }
    .clinica-cards {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }
    .info-card-content-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--jade-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }
    .info-card-content-value {
        font-weight: 800;
        color: var(--jade-950);
        font-size: 1rem;
        line-height: 1.4;
    }
    .info-card-content-value a {
        color: inherit;
        text-decoration: none;
    }
    .info-card-content-value a:hover {
        color: var(--jade-600);
    }
    .horario-table {
        width: 100%;
        font-size: 0.9rem;
    }
    .horario-table td {
        padding: 4px 0;
    }
    .horario-table td:first-child {
        font-weight: 700;
        color: var(--jade-900);
    }
    .horario-table td:last-child {
        text-align: right;
        font-weight: 700;
        color: var(--jade-600);
    }
</style>
@endsection

@section('content')

<section class="contacto-page-header">
    <div class="container-premium text-center">
        <span class="badge-jade">Contacto y Ubicación</span>
        <h1>Conoce a tu especialista</h1>
        <p>Estamos aquí para cuidar de tu sonrisa con profesionalismo, calidez y tecnología de vanguardia.</p>
    </div>
</section>

@if($doctora->name)
<section class="doctora-card-container">
    <div class="container-premium">
        <div class="contact-card" style="padding: 40px;">
            <div class="doctora-flex">
                <!-- Foto de perfil -->
                <div>
                    <div class="profile-image-container fade-up">
                        <img src="{{ $doctora->avatar }}" alt="{{ $doctora->name }}" class="profile-image">
                    </div>
                </div>

                <!-- Detalles -->
                <div class="doctora-info fade-up" style="animation-delay: 0.1s;">
                    @if($doctora->specialty)
                    <div style="margin-bottom: 12px;">
                        <span class="badge-jade" style="background: var(--jade-100); color: var(--jade-800); padding: 6px 14px; font-size: 0.75rem;">{{ $doctora->specialty }}</span>
                    </div>
                    @endif

                    <h2>{{ $doctora->name }}</h2>

                    @if($doctora->bio)
                    <p>{{ $doctora->bio }}</p>
                    @endif

                    <!-- Insignia COP siempre visible -->
                    <div class="badge-cop">
                        <div class="badge-cop-icon">
                            <i data-lucide="shield-check" style="width:20px;height:20px;"></i>
                        </div>
                        <div>
                            <div style="font-size:0.65rem; font-weight:800; color:var(--jade-500); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:2px;">Certificación Oficial</div>
                            <div style="font-weight:800; color:var(--jade-950); font-size:0.9rem;">Colegio Odontológico del Perú — COP {{ $doctora->cop ?: '50039' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="clinica-container">
    <div class="container-premium">
        <div class="clinica-grid">
            <!-- Info -->
            <div class="clinica-info-col fade-up">
                <h3>Nuestra Clínica</h3>

                <div class="clinica-cards">
                    <div class="info-card">
                        <div class="icon-box">
                            <i data-lucide="map-pin" style="width:20px;height:20px;"></i>
                        </div>
                        <div>
                            <div class="info-card-content-label">Dirección Exacta</div>
                            <div class="info-card-content-value">Jirón Unión 637, Miramar Alto,<br>Chimbote, Ancash, Perú</div>
                        </div>
                    </div>

                    @if($doctora->phone)
                    <div class="info-card">
                        <div class="icon-box">
                            <i data-lucide="phone" style="width:20px;height:20px;"></i>
                        </div>
                        <div>
                            <div class="info-card-content-label">Llámanos Directo</div>
                            <div class="info-card-content-value"><a href="{{ $doctora->phone_url }}">{{ $doctora->phone }}</a></div>
                        </div>
                    </div>
                    @endif

                    <div class="info-card">
                        <div class="icon-box">
                            <i data-lucide="clock" style="width:20px;height:20px;"></i>
                        </div>
                        <div style="width:100%;">
                            <div class="info-card-content-label">Horario de Atención</div>
                            
                            <div style="width:100%;">
                                @if(is_iterable($horarios) && count($horarios) > 0)
                                    <table class="horario-table">
                                    @foreach($horarios as $h)
                                        <tr>
                                            <td>{{ is_array($h) ? ($h['day'] ?? '') : ($h->day ?? '') }}</td>
                                            <td><span style="background:var(--jade-50); padding:2px 8px; border-radius:6px;">{{ is_array($h) ? ($h['start'] ?? '') : ($h->start ?? '') }} - {{ is_array($h) ? ($h['end'] ?? '') : ($h->end ?? '') }}</span></td>
                                        </tr>
                                    @endforeach
                                    </table>
                                @else
                                    <div class="info-card-content-value" style="font-weight:700; font-size:0.9rem;">{{ $doctora->horario ?: 'Previa cita programada' }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ $doctora->whatsapp_url }}" target="_blank" class="btn-whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg> 
                        Agendar por WhatsApp
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div class="fade-up" style="animation-delay: 0.2s; height:100%;">
                <div class="map-container relative bg-jade-50">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7879.7154963744215!2d-78.58233867042712!3d-9.076721342526092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa556765862ba9fd1%3A0x50c89b9575aad271!2sCentro%20Odontol%C3%B3gico%20Miradent!5e0!3m2!1ses-419!2spe!4v1782104133526!5m2!1ses-419!2spe" width="100%" height="100%" style="border:0; position: absolute; inset: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection