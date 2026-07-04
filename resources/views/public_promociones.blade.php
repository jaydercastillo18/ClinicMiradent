@extends('layouts.public')

@section('title', 'Promociones | Miradent')

@section('styles')
<style>
    .promo-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 28px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px -10px rgba(0, 84, 66, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .promo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 168, 132, 0.12);
        border-color: var(--jade-200);
    }

    .promo-img-wrap {
        position: relative;
        width: 100%;
        height: 240px;
        overflow: hidden;
        background: var(--jade-50);
    }

    .promo-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .promo-card:hover .promo-img-wrap img {
        transform: scale(1.08);
    }

    .promo-discount-badge {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: linear-gradient(135deg, var(--jade-600), var(--jade-800));
        color: white;
        padding: 8px 18px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 1.15rem;
        box-shadow: 0 8px 20px rgba(0, 168, 132, 0.4);
        z-index: 10;
        border: 2px solid rgba(255, 255, 255, 0.2);
        letter-spacing: 0.02em;
    }

    .promo-status-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 6px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        z-index: 10;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-Reservar ahora ya ! ! {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--jade-50);
        color: var(--jade-800);
        padding: 12px 26px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.95rem;
        border: 2px solid var(--jade-100);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }

    .btn-Reservar ahora ya ! !:hover {
        background: var(--jade-600);
        color: #ffffff;
        border-color: var(--jade-600);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 168, 132, 0.25);
    }

    .empty-state-card {
        background: linear-gradient(180deg, #ffffff 0%, var(--jade-50) 100%);
        border: 2px dashed var(--jade-200);
        border-radius: 40px;
        padding: 70px 30px;
        max-width: 650px;
        margin: 0 auto;
        box-shadow: 0 20px 40px rgba(0, 84, 66, 0.04);
    }

    .empty-icon-box {
        width: 90px;
        height: 90px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 28px auto;
        box-shadow: 0 15px 30px rgba(0, 168, 132, 0.12);
        color: var(--jade-500);
    }

    /* Layout Classes para reemplazar Tailwind */
    .promos-page-header {
        padding-top: 140px;
        padding-bottom: 48px;
        text-align: center;
    }

    .promos-page-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 20px 0 16px 0;
        font-family: 'Outfit', sans-serif;
    }

    .promos-page-header p {
        font-size: 1.1rem;
        color: var(--jade-800);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .promos-grid-container {
        padding-bottom: 96px;
        max-width: 1152px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }

    .promos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 32px;
    }

    .promo-card-body {
        padding: 32px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .promo-card-body h4 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 0 0 12px 0;
        font-family: 'Outfit', sans-serif;
        line-height: 1.2;
    }

    .promo-card-body p {
        font-size: 1rem;
        color: var(--jade-700);
        line-height: 1.6;
        flex: 1;
        margin: 0 0 24px 0;
    }

    .promo-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 24px;
        margin-top: auto;
        border-top: 1px solid rgba(0, 168, 132, 0.15);
    }

    .promo-date-col {
        display: flex;
        flex-direction: column;
    }

    .promo-date-label {
        font-size: 0.7rem;
        color: var(--jade-500);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .promo-date-value {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--jade-800);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--jade-50);
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid var(--jade-100);
    }
</style>
@endsection

@section('content')

<section class="promos-page-header">
    <div class="container-premium text-center">
        <span class="badge-jade">Ofertas especiales</span>
        <h1>Promociones</h1>
        <p>Aprovecha descuentos exclusivos por tiempo limitado en nuestros mejores tratamientos dentales.</p>
    </div>
</section>

<section class="promos-grid-container">
    <div class="container-premium">
        @if($promociones->isNotEmpty())
        <div class="promos-grid">
            @foreach($promociones as $promo)
            <div class="promo-card fade-up" {!! 'style="animation-delay: ' . ($loop->index * 0.1) . 's;"' !!}>
                @if($promo->image)
                <div class="promo-img-wrap">
                    <img src="{{ $promo->image }}" alt="{{ $promo->title }}" loading="lazy">
                    <span class="promo-status-badge" style="background: rgba(255,255,255,0.92); color: var(--jade-800);">{{ $promo->status_label }}</span>
                    @if($promo->discount_label)
                    <span class="promo-discount-badge" @style([$promo->discount_style ?? ''])>{{ $promo->discount_label }}</span>
                    @endif
                </div>
                @endif

                <div class="promo-card-body">
                    <h4>{{ $promo->title }}</h4>
                    <p>{{ $promo->description }}</p>

                    <div class="promo-card-footer">
                        <div class="promo-date-col">
                            <span class="promo-date-label">Válido hasta</span>
                            <span class="promo-date-value">
                                <i data-lucide="calendar-clock" style="width:16px;height:16px;"></i> {{ $promo->ends_at }}
                            </span>
                        </div>
                        <a href="{{ $promo->whatsapp_url }}" target="_blank" class="btn-Reservar ahora ya!!">
                            Reservar ahora ya!! <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state-card text-center fade-up">
            <div class="empty-icon-box">
                <i data-lucide="ticket" style="width:48px;height:48px;"></i>
            </div>
            <h3 style="font-size: 2rem; font-weight: 800; color: var(--jade-950); margin-bottom: 16px; font-family: 'Outfit', sans-serif;">No hay promociones</h3>
            <p style="color: var(--jade-700); font-size: 1.1rem; line-height: 1.6; margin-bottom: 32px;">En este momento no tenemos campañas activas, pero siempre ofrecemos precios competitivos en todos nuestros tratamientos.</p>
            <a href="{{ url('/') }}" style="display: inline-flex; align-items: center; gap: 8px; background: var(--jade-600); color: #fff; padding: 16px 32px; border-radius: 999px; font-weight: 800; text-decoration: none; box-shadow: 0 10px 20px rgba(0,168,132,0.3);">
                Volver al inicio
            </a>
        </div>
        @endif
    </div>
</section>

@endsection