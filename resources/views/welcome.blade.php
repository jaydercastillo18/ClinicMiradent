@extends('layouts.public')

@section('title', 'Miradent Centro Odontológico')

@section('styles')
<style>
    :root {
        --home-jade-950: #003f32;
        --home-jade-900: #005644;
        --home-jade-800: #006b55;
        --home-jade-700: #00846a;
        --home-jade-600: #00a884;
        --home-jade-100: #dff8f1;
        --home-jade-50: #f4fffb;
        --home-white: #ffffff;
        --home-border: #c7eee4;
    }

    .home-page {
        color: var(--home-jade-950);
        background: var(--home-white);
    }

    .home-shell {
        width: min(1180px, calc(100% - 32px));
        margin: 0 auto;
    }

    .home-hero {
        min-height: calc(100svh - 78px);
        display: grid;
        align-items: center;
        padding: 108px 0 44px;
        background:
            linear-gradient(180deg, rgba(244, 255, 251, 0.95), rgba(255, 255, 255, 1) 72%),
            repeating-linear-gradient(90deg, rgba(0, 168, 132, 0.05) 0 1px, transparent 1px 86px);
        border-bottom: 1px solid var(--home-border);
    }

    .home-hero-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.04fr) minmax(360px, 0.96fr);
        gap: clamp(32px, 5vw, 68px);
        align-items: center;
    }

    .home-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border: 1px solid var(--home-border);
        border-radius: 999px;
        background: var(--home-white);
        color: var(--home-jade-800);
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .home-eyebrow-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--home-jade-600);
        box-shadow: 0 0 0 5px rgba(0, 168, 132, 0.12);
    }

    .home-title {
        margin: 22px 0 18px;
        max-width: 720px;
        color: var(--home-jade-950);
        font-size: clamp(2.5rem, 8vw, 8.5rem);
        line-height: 0.84;
        letter-spacing: 0;
        font-weight: 800;
    }

    .home-title span {
        display: block;
        color: var(--home-jade-600);
    }

    .home-lead {
        max-width: 650px;
        color: var(--home-jade-800);
        font-size: clamp(1.05rem, 1.5vw, 1.25rem);
        line-height: 1.75;
    }

    .home-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 32px;
    }

    .home-btn {
        display: inline-flex;
        min-height: 52px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 0 24px;
        font-weight: 800;
        text-decoration: none;
        transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
    }

    .home-btn:hover {
        transform: translateY(-2px);
    }

    .home-btn-primary {
        background: var(--home-jade-700);
        color: var(--home-white);
        border: 1px solid var(--home-jade-700);
    }

    .home-btn-primary:hover {
        background: var(--home-jade-950);
        color: var(--home-white);
    }

    .home-btn-secondary {
        background: var(--home-white);
        color: var(--home-jade-900);
        border: 1px solid var(--home-border);
    }

    .home-btn-secondary:hover {
        border-color: var(--home-jade-700);
        color: var(--home-jade-950);
    }

    .home-proof {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 36px;
        max-width: 650px;
    }

    .home-proof-item {
        border: 1px solid var(--home-border);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.88);
        padding: 18px;
    }

    .home-proof-number {
        display: block;
        color: var(--home-jade-700);
        font-size: clamp(1.45rem, 2.8vw, 2rem);
        font-weight: 800;
        line-height: 1;
    }

    .home-proof-label {
        display: block;
        margin-top: 8px;
        color: var(--home-jade-800);
        font-size: 0.86rem;
        line-height: 1.35;
    }

    .home-visual {
        position: relative;
        display: grid;
        gap: 16px;
    }

    .home-portrait {
        position: relative;
        min-height: 560px;
        overflow: hidden;
        border: 1px solid var(--home-border);
        border-radius: 28px;
        background: var(--home-jade-50);
        box-shadow: 0 30px 80px rgba(0, 84, 66, 0.14);
    }

    .home-portrait img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .home-portrait-fallback {
        min-height: inherit;
        display: grid;
        place-items: center;
        padding: 48px;
        color: var(--home-jade-700);
        text-align: center;
    }

    .home-portrait-fallback img {
        width: min(270px, 70%);
        height: auto;
        object-fit: contain;
    }

    .home-status-card {
        position: absolute;
        left: 18px;
        right: 18px;
        bottom: 18px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 14px;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.72);
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.92);
        padding: 16px;
        backdrop-filter: blur(16px);
    }

    .home-status-icon {
        display: grid;
        width: 46px;
        height: 46px;
        place-items: center;
        border-radius: 15px;
        background: var(--home-jade-100);
        color: var(--home-jade-800);
    }

    .home-status-card strong,
    .home-status-card span {
        display: block;
    }

    .home-status-card strong {
        color: var(--home-jade-950);
        font-size: 0.95rem;
    }

    .home-status-card span {
        color: var(--home-jade-700);
        font-size: 0.82rem;
    }

    .home-status-pill {
        border-radius: 999px;
        background: var(--home-jade-700);
        color: var(--home-white);
        padding: 8px 12px;
        font-size: 0.76rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .home-floating-badge {
        position: absolute;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(12px);
        padding: 10px 18px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 800;
        color: var(--home-jade-950);
        box-shadow: 0 12px 30px rgba(0, 84, 66, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.9);
        z-index: 10;
    }

    .home-floating-badge i {
        color: var(--home-jade-600);
        width: 18px;
        height: 18px;
    }

    @keyframes floatBadge {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }

    .home-section {
        padding: clamp(72px, 10vw, 112px) 0;
    }

    .home-section-soft {
        background: var(--home-jade-50);
        border-block: 1px solid var(--home-border);
    }

    .home-section-head {
        display: grid;
        grid-template-columns: minmax(0, 0.85fr) minmax(240px, 0.45fr);
        gap: 28px;
        align-items: end;
        margin-bottom: 34px;
    }

    .home-kicker {
        color: var(--home-jade-700);
        font-size: 0.78rem;
        font-weight: 900;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .home-heading {
        margin-top: 10px;
        color: var(--home-jade-950);
        font-size: clamp(2rem, 4vw, 3.8rem);
        line-height: 1;
        letter-spacing: 0;
    }

    .home-section-copy {
        color: var(--home-jade-800);
        font-size: 1rem;
        line-height: 1.65;
    }

    .home-care-grid,
    .home-services-grid,
    .home-promos-grid,
    .home-testimonials-grid {
        display: grid;
        gap: 18px;
    }

    .home-care-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    .home-services-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .home-promos-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .home-testimonials-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .home-card {
        border: 1px solid var(--home-border);
        border-radius: 24px;
        background: var(--home-white);
        padding: 24px;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .home-card:hover {
        transform: translateY(-4px);
        border-color: var(--home-jade-600);
        box-shadow: 0 22px 60px rgba(0, 84, 66, 0.1);
    }

    .home-care-icon,
    .home-service-icon {
        display: grid;
        width: 48px;
        height: 48px;
        place-items: center;
        border-radius: 16px;
        background: var(--home-jade-100);
        color: var(--home-jade-800);
        margin-bottom: 18px;
    }

    .home-card h3 {
        color: var(--home-jade-950);
        font-size: 1.08rem;
        line-height: 1.25;
    }

    .home-card p {
        margin-top: 12px;
        color: var(--home-jade-800);
        font-size: 0.94rem;
        line-height: 1.65;
    }

    .home-service-card {
        overflow: hidden;
        padding: 0;
    }

    .home-service-media,
    .home-case-media {
        height: 220px;
        background: var(--home-jade-50);
        overflow: hidden;
    }

    .home-service-media img,
    .home-case-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .home-service-card:hover .home-service-media img,
    .home-case-card:hover .home-case-media img {
        transform: scale(1.04);
    }

    .home-service-body {
        padding: 24px;
    }

    .home-tag {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        background: var(--home-jade-100);
        color: var(--home-jade-800);
        padding: 6px 10px;
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .home-service-meta {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 16px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid var(--home-border);
    }

    .home-price {
        color: var(--home-jade-700);
        font-size: 1.45rem;
        font-weight: 900;
    }

    .home-duration {
        color: var(--home-jade-800);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .home-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 0;
        background: transparent;
        padding: 0;
        color: var(--home-jade-700);
        cursor: pointer;
        font: inherit;
        font-weight: 900;
        text-decoration: none;
    }

    .home-results-section {
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 1), rgba(244, 255, 251, 0.78)),
            radial-gradient(circle at 82% 12%, rgba(0, 168, 132, 0.1), transparent 34%);
    }

    .home-results {
        display: grid;
        grid-template-columns: minmax(0, 0.82fr) minmax(320px, 0.72fr);
        gap: clamp(30px, 5vw, 68px);
        align-items: center;
    }

    .home-results-copy {
        max-width: 680px;
    }

    .home-result-points {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .home-result-point {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        border: 1px solid var(--home-border);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.82);
        color: var(--home-jade-800);
        padding: 0 13px;
        font-size: 0.82rem;
        font-weight: 800;
        box-shadow: 0 12px 32px rgba(0, 84, 66, 0.06);
    }

    .home-result-point i {
        width: 16px;
        height: 16px;
        color: var(--home-jade-700);
    }

    .home-case-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 168, 132, 0.24);
        border-radius: 32px;
        background: var(--home-white);
        box-shadow: 0 26px 70px rgba(0, 84, 66, 0.13);
    }

    .home-case-compare {
        position: relative;
        height: clamp(320px, 38vw, 470px);
        overflow: hidden;
        isolation: isolate;
        background: var(--home-jade-50);
        cursor: ew-resize;
    }

    .home-case-compare:focus-visible {
        outline: 3px solid rgba(0, 168, 132, 0.32);
        outline-offset: -8px;
    }

    .home-case-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        user-select: none;
        pointer-events: none;
    }

    .home-case-image-after {
        z-index: 1;
    }

    .home-case-image-before {
        z-index: 2;
        clip-path: inset(0 50% 0 0);
    }

    .home-case-compare::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 3;
        background: linear-gradient(180deg, rgba(0, 63, 50, 0), rgba(0, 63, 50, 0.22));
        pointer-events: none;
    }

    .home-case-label {
        position: absolute;
        z-index: 5;
        bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.94);
        color: var(--home-jade-900);
        padding: 8px 12px;
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        box-shadow: 0 10px 26px rgba(0, 63, 50, 0.14);
    }

    .home-case-label-before {
        left: 18px;
    }

    .home-case-label-after {
        right: 18px;
    }

    .home-case-control {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        z-index: 6;
        width: 2px;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 0 0 1px rgba(0, 84, 66, 0.16), 0 0 28px rgba(0, 84, 66, 0.22);
        pointer-events: none;
    }

    .home-case-control span {
        position: absolute;
        top: 50%;
        left: 50%;
        display: grid;
        width: 54px;
        height: 54px;
        place-items: center;
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 999px;
        background: var(--home-jade-700);
        color: var(--home-white);
        transform: translate(-50%, -50%);
        box-shadow: 0 18px 38px rgba(0, 63, 50, 0.28);
    }

    .home-case-control i {
        width: 24px;
        height: 24px;
    }

    .home-case-compare:hover .home-case-image-before,
    .home-case-compare:focus .home-case-image-before {
        animation: homeCompareReveal 3.4s ease-in-out infinite;
    }

    .home-case-compare:hover .home-case-control,
    .home-case-compare:focus .home-case-control {
        animation: homeCompareSweep 3.4s ease-in-out infinite;
    }

    .home-case-body {
        padding: 24px 26px 26px;
        border-top: 1px solid var(--home-border);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(244, 255, 251, 0.74));
    }

    .home-case-body h3 {
        color: var(--home-jade-950);
        font-size: 1.12rem;
        line-height: 1.25;
    }

    .home-case-body p {
        margin-top: 9px;
        color: var(--home-jade-800);
        line-height: 1.55;
    }

    @keyframes homeCompareReveal {

        0%,
        100% {
            clip-path: inset(0 68% 0 0);
        }

        50% {
            clip-path: inset(0 24% 0 0);
        }
    }

    @keyframes homeCompareSweep {

        0%,
        100% {
            left: 32%;
        }

        50% {
            left: 76%;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .home-case-compare:hover .home-case-image-before,
        .home-case-compare:focus .home-case-image-before,
        .home-case-compare:hover .home-case-control,
        .home-case-compare:focus .home-case-control {
            animation: none;
        }
    }

    .home-promo-section {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(180deg, rgba(244, 255, 251, 0.94), rgba(255, 255, 255, 0.98)),
            repeating-linear-gradient(135deg, rgba(0, 168, 132, 0.055) 0 1px, transparent 1px 18px);
        border-block: 1px solid var(--home-border);
    }

    .home-promo-head {
        align-items: center;
        margin-bottom: 28px;
    }

    .home-promo-intro {
        max-width: 620px;
        margin-top: 14px;
    }

    .home-promo-see-all {
        min-height: 46px;
        padding: 0 18px;
        border: 1px solid var(--home-border);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.84);
    }

    .home-promos-grid {
        gap: 22px;
    }

    .home-promos-grid-single {
        grid-template-columns: 1fr;
    }

    .home-promo-card {
        position: relative;
        overflow: hidden;
        min-height: 430px;
        display: grid;
        grid-template-rows: minmax(230px, 0.95fr) auto;
        border: 1px solid rgba(0, 168, 132, 0.24);
        border-radius: 30px;
        background: var(--home-white);
        box-shadow: 0 24px 64px rgba(0, 84, 66, 0.1);
        transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
    }

    .home-promo-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 168, 132, 0.5);
        box-shadow: 0 30px 80px rgba(0, 84, 66, 0.14);
    }

    .home-promo-no-image {
        min-height: 320px;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
    }

    .home-promo-no-image .home-promo-body {
        align-content: center;
    }

    .home-promos-grid-single .home-promo-card {
        min-height: 420px;
        grid-template-columns: minmax(0, 1.14fr) minmax(330px, 0.86fr);
        grid-template-rows: 1fr;
    }

    .home-promos-grid-single .home-promo-no-image {
        grid-template-columns: 1fr;
    }

    .home-promo-media {
        position: relative;
        overflow: hidden;
        min-height: 240px;
        background: var(--home-jade-50);
    }

    .home-promos-grid-single .home-promo-media {
        min-height: 420px;
    }

    .home-promo-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.35s ease, filter 0.35s ease;
    }

    .home-promo-media::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 63, 50, 0.02), rgba(0, 63, 50, 0.24));
        pointer-events: none;
    }

    .home-promo-card:hover .home-promo-media img {
        transform: scale(1.04);
    }

    .home-promo-card.status-expirada .home-promo-media img {
        filter: grayscale(0.16) saturate(0.82);
    }

    .home-promo-body {
        display: grid;
        align-content: start;
        padding: 26px;
    }

    .home-promos-grid-single .home-promo-body {
        align-content: center;
        padding: clamp(28px, 4vw, 46px);
    }

    .home-promo-topline {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 16px;
    }

    .home-promo-status,
    .home-promo-discount {
        display: inline-flex;
        min-height: 32px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0 12px;
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .home-promo-status {
        border: 1px solid var(--home-border);
        background: var(--home-jade-100);
        color: var(--home-jade-900);
    }

    .home-promo-card.status-expirada .home-promo-status {
        border-color: #e2e8f0;
        background: #f8fafc;
        color: #64748b;
    }

    .home-promo-card.status-iniciar .home-promo-status {
        border-color: #fde68a;
        background: #fffbeb;
        color: #8a5a00;
    }

    .home-promo-discount {
        background: var(--home-jade-950);
        color: var(--home-white);
    }

    .home-promo-body h3 {
        color: var(--home-jade-950);
        font-size: clamp(1.35rem, 2.5vw, 2.25rem);
        line-height: 1.05;
    }

    .home-promo-body p {
        margin-top: 13px;
        color: var(--home-jade-800);
        line-height: 1.62;
    }

    .home-promo-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
        color: var(--home-jade-700);
        font-size: 0.88rem;
        font-weight: 800;
    }

    .home-promo-meta span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .home-promo-meta i {
        width: 17px;
        height: 17px;
    }

    .home-promo-actions {
        margin-top: 24px;
    }

    .home-promo-link {
        display: inline-flex;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 999px;
        padding: 0 18px;
        font-weight: 900;
        text-decoration: none;
        transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    .home-promo-link:hover {
        transform: translateY(-2px);
    }

    .home-promo-link-primary {
        border: 1px solid var(--home-jade-700);
        background: var(--home-jade-700);
        color: var(--home-white);
    }

    .home-promo-link-primary:hover {
        background: var(--home-jade-950);
        color: var(--home-white);
    }

    .home-promo-link-secondary {
        border: 1px solid var(--home-border);
        background: var(--home-white);
        color: var(--home-jade-900);
    }

    .home-promo-link-secondary:hover {
        border-color: var(--home-jade-700);
        color: var(--home-jade-950);
    }

    .home-promo-empty {
        min-height: 300px;
        grid-template-rows: 1fr;
    }

    .home-promo-empty .home-promo-body {
        align-content: center;
    }

    .home-quote {
        min-height: 260px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .home-stars {
        display: flex;
        gap: 4px;
        color: var(--home-jade-600);
    }

    .home-quote blockquote {
        margin: 22px 0;
        color: var(--home-jade-950);
        font-size: 1.05rem;
        line-height: 1.7;
    }

    .home-quote-author {
        color: var(--home-jade-700);
        font-weight: 900;
    }

    .home-cta {
        padding: clamp(72px, 10vw, 116px) 0;
        background: var(--home-jade-50);
        color: var(--home-jade-950);
        position: relative;
        overflow: hidden;
    }

    .home-cta-box {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) auto;
        gap: 28px;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .home-cta h2 {
        color: var(--home-jade-950);
        font-size: clamp(2.1rem, 5vw, 4.7rem);
        line-height: 0.98;
        letter-spacing: -0.02em;
    }

    .home-cta p {
        max-width: 720px;
        margin-top: 16px;
        color: var(--home-jade-800);
        font-size: 1.1rem;
        line-height: 1.7;
    }

    .home-cta .home-btn-primary {
        background: var(--home-jade-600);
        border-color: var(--home-jade-600);
        color: var(--home-white);
    }

    .home-entry-popup {
        position: fixed;
        inset: 0;
        z-index: 80;
        display: grid;
        place-items: center;
        padding: 20px;
        background: rgba(0, 31, 25, 0.54);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        backdrop-filter: blur(10px);
        transition: opacity 0.24s ease, visibility 0.24s ease;
    }

    .home-entry-popup.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .home-entry-popup-card {
        position: relative;
        width: min(860px, 100%);
        max-height: min(720px, calc(100svh - 40px));
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(320px, 1fr);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.72);
        border-radius: 30px;
        background: var(--home-white);
        box-shadow: 0 34px 100px rgba(0, 31, 25, 0.36);
        transform: translateY(18px) scale(0.98);
        transition: transform 0.24s ease;
    }

    .home-entry-popup.is-open .home-entry-popup-card {
        transform: translateY(0) scale(1);
    }

    .home-entry-popup-media {
        position: relative;
        min-height: 390px;
        overflow: hidden;
        background: var(--home-jade-50);
    }

    .home-entry-popup-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .home-entry-popup-media::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 63, 50, 0), rgba(0, 63, 50, 0.34));
    }

    .home-entry-popup-fallback {
        min-height: inherit;
        display: grid;
        place-items: center;
        padding: 42px;
        color: var(--home-jade-700);
    }

    .home-entry-popup-fallback i {
        width: 72px;
        height: 72px;
    }

    .home-entry-popup-body {
        display: grid;
        align-content: center;
        padding: clamp(28px, 4vw, 46px);
    }

    .home-entry-popup-close {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 2;
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        border: 1px solid rgba(0, 84, 66, 0.14);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        color: var(--home-jade-900);
        cursor: pointer;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .home-entry-popup-close:hover {
        transform: translateY(-1px);
        background: var(--home-jade-100);
    }

    .home-entry-popup-close i {
        width: 20px;
        height: 20px;
    }

    .home-entry-popup-kicker {
        display: inline-flex;
        width: fit-content;
        min-height: 34px;
        align-items: center;
        border: 1px solid var(--home-border);
        border-radius: 999px;
        background: var(--home-jade-100);
        color: var(--home-jade-900);
        padding: 0 12px;
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .home-entry-popup-body h2 {
        margin-top: 16px;
        color: var(--home-jade-950);
        font-size: clamp(2rem, 4vw, 3.35rem);
        line-height: 0.96;
        letter-spacing: 0;
    }

    .home-entry-popup-body p {
        margin-top: 16px;
        color: var(--home-jade-800);
        line-height: 1.65;
    }

    .home-entry-popup-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 26px;
    }

    .home-entry-popup-note {
        margin-top: 16px;
        color: var(--home-jade-700);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .home-popup-lock {
        overflow: hidden;
    }

    @media (max-width: 980px) {

        .home-hero-grid,
        .home-section-head,
        .home-results,
        .home-cta-box {
            grid-template-columns: 1fr;
        }

        .home-portrait {
            min-height: 440px;
        }

        .home-care-grid,
        .home-services-grid,
        .home-promos-grid,
        .home-testimonials-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .home-promos-grid-single,
        .home-promos-grid-single .home-promo-card {
            grid-template-columns: 1fr;
        }

        .home-promos-grid-single .home-promo-card {
            grid-template-rows: auto auto;
        }

        .home-promos-grid-single .home-promo-media {
            min-height: 320px;
        }

        .home-entry-popup-card {
            grid-template-columns: 1fr;
            overflow-y: auto;
        }

        .home-entry-popup-media {
            min-height: 260px;
        }
    }

    @media (max-width: 640px) {
        .home-hero {
            min-height: 0;
            padding: 56px 0 36px;
        }

        .home-title {
            font-size: clamp(3.4rem, 20vw, 4.8rem);
        }

        .home-proof,
        .home-care-grid,
        .home-services-grid,
        .home-promos-grid,
        .home-testimonials-grid {
            grid-template-columns: 1fr;
        }

        .home-portrait {
            min-height: 300px;
        }

        .home-status-card {
            grid-template-columns: auto 1fr;
        }

        .home-status-pill {
            grid-column: 1 / -1;
            width: fit-content;
        }

        .home-promo-head {
            gap: 18px;
        }

        .home-promo-card,
        .home-promos-grid-single .home-promo-card {
            min-height: auto;
            grid-template-columns: 1fr;
            grid-template-rows: auto auto;
            border-radius: 24px;
        }

        .home-promo-media,
        .home-promos-grid-single .home-promo-media {
            min-height: 240px;
        }

        .home-promo-body,
        .home-promos-grid-single .home-promo-body {
            padding: 24px;
        }

        .home-promo-link {
            width: 100%;
        }

        .home-entry-popup {
            padding: 14px;
        }

        .home-entry-popup-card {
            border-radius: 24px;
        }

        .home-entry-popup-body {
            padding: 26px;
        }

        .home-entry-popup-actions .home-btn {
            width: 100%;
        }

        .home-case-compare {
            height: 310px;
        }
    }
</style>
@endsection

@section('content')
@php
$serviciosHome = collect($servicios ?? [])->take(3);
$promocionesHome = collect($promociones ?? [])->take(2);
$promocionesHomeCount = $promocionesHome->count();
$popupPromo = $promocionesHome->firstWhere('status_class', 'status-vigente');
$casoPrincipal = collect($casosExito ?? [])->first();
$testimoniosHome = collect($testimonios ?? [])->take(3);
$heroImage = $doctora->avatar ?: ($casoPrincipal?->after_image ?? ($serviciosHome->first()?->image ?? ''));
$homePopupImage = $popupPromo?->image ?: $heroImage;
@endphp

<div class="home-page">
    <section class="home-hero">
        <div class="home-shell home-hero-grid">
            <div>
                <div class="home-eyebrow">
                    <span class="home-eyebrow-dot"></span>
                    Clínica dental en Chimbote
                </div>
                <h1 class="home-title">Miradent<br><span>Dental</span></h1>
                <p class="home-lead">
                    Odontología estética, preventiva e integral con una experiencia clara, tranquila y personalizada.
                    Cuidamos cada detalle para que tu sonrisa se vea natural, saludable y segura desde la primera visita.
                </p>

                <div class="home-actions">
                    <a href="{{ route('public.reservar-cita') }}" class="home-btn home-btn-primary">
                        <i data-lucide="calendar-check"></i>
                        Reservar cita
                    </a>
                    <a href="{{ route('public.servicios') }}" class="home-btn home-btn-secondary">
                        <i data-lucide="sparkles"></i>
                        Ver tratamientos
                    </a>
                </div>

                <div class="home-proof">
                    <div class="home-proof-item">
                        <span class="home-proof-number">+2,500</span>
                        <span class="home-proof-label">Sonrisas renovadas con éxito</span>
                    </div>
                    <div class="home-proof-item">
                        <span class="home-proof-number">100%</span>
                        <span class="home-proof-label">Atención y cuidado personalizado</span>
                    </div>
                    <div class="home-proof-item">
                        <span class="home-proof-number">Top</span>
                        <span class="home-proof-label">Tecnología y equipos de última generación</span>
                    </div>
                </div>
            </div>

            <div class="home-visual">
                <div class="home-portrait">
                    @if($heroImage)
                    <img src="{{ $heroImage }}" alt="Miradent atención dental premium" width="900" height="1100" fetchpriority="high">
                    @else
                    <div class="home-portrait-fallback">
                        <img src="{{ $publicAssets->logo }}" alt="Miradent">
                    </div>
                    @endif

                    <div class="home-floating-badge" style="top: 24px; right: 24px; animation-delay: 0s;">
                        <i data-lucide="star"></i>
                        +6 años de exp.
                    </div>
                    <div class="home-floating-badge" style="top: 84px; right: 24px; animation-delay: 1.5s;">
                        <i data-lucide="shield-check"></i>
                        {{ $doctora->cop ?: 'COP-50039' }}
                    </div>

                    <div class="home-status-card">
                        <div class="home-status-icon">
                            <i data-lucide="badge-check"></i>
                        </div>
                        <div>
                            <strong>{{ $doctora->name ?: 'Atención Miradent' }}</strong>
                            <span>{{ $doctora->specialty ?: 'Odontología integral y estética' }}</span>
                        </div>
                        <div class="home-status-pill">Evaluación inicial</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section" style="background: var(--home-jade-950); margin-top: 60px; padding: 100px 0; position: relative; overflow: hidden; border-radius: 40px; margin-left: 16px; margin-right: 16px;">
        <!-- Background decorations -->
        <div style="position: absolute; top: -150px; left: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(0,168,132,0.15) 0%, transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -200px; right: -100px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(0,168,132,0.1) 0%, transparent 70%); border-radius: 50%;"></div>

        <div class="home-shell" style="position: relative; z-index: 2;">
            <div style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
                <div style="flex: 1 1 500px;">
                    <div class="home-kicker" style="color: var(--home-jade-100); opacity: 0.9; display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); padding: 8px 16px; border-radius: 99px; border: 1px solid rgba(255,255,255,0.1);">
                        <i data-lucide="shield" style="width: 14px; height: 14px;"></i> Garantía de Excelencia
                    </div>
                    <h2 class="home-heading" style="color: var(--home-white); font-size: clamp(2rem, 3.5vw, 3.2rem); margin-top: 20px; line-height: 1.15;">
                        ¿Por qué deberías elegirnos a nosotros, Clínica Miradent?
                    </h2>
                </div>
                <div style="flex: 1 1 350px; display: flex; flex-direction: column; gap: 24px; align-items: flex-start;">
                    <p style="color: var(--home-jade-100); opacity: 0.85; font-size: 1.1rem; line-height: 1.6; margin: 0;">
                        Respaldados por <strong style="color: white; font-weight: 600;">6 años de experiencia</strong> devolviendo confianza a través de sonrisas perfectas. No somos una clínica más; diseñamos una experiencia dental de primer nivel donde tu tranquilidad, estética y resultados duraderos son nuestra prioridad absoluta.
                    </p>
                    <a href="{{ route('public.reservar-cita') }}" style="display: inline-flex; align-items: center; justify-content: center; background: var(--home-jade-600); color: white; border: none; padding: 16px 32px; font-size: 1.05rem; font-weight: 700; border-radius: 99px; box-shadow: 0 10px 30px rgba(0,168,132,0.3); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 15px 40px rgba(0,168,132,0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 30px rgba(0,168,132,0.3)';">
                        <i data-lucide="calendar-check" style="width: 20px; height: 20px; margin-right: 10px;"></i> Agendar mi primera visita
                    </a>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 40px; align-items: stretch;">

                <!-- Columna Izquierda: Los 4 beneficios (Más pequeños) -->
                <div style="flex: 1 1 400px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-content: start;">
                    @foreach($loMasImportante as $item)
                    <article style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 24px 20px; backdrop-filter: blur(10px); transition: transform 0.3s ease, background 0.3s ease, border-color 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(0,168,132,0.4)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.transform='translateY(0)'; this.style.borderColor='rgba(255, 255, 255, 0.08)';">
                        <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(0, 168, 132, 0.15); color: var(--home-jade-100); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; border: 1px solid rgba(0, 168, 132, 0.3); box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <i data-lucide="{{ $item['icon'] }}" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h3 style="color: var(--home-white); font-size: 1.15rem; font-weight: 700; margin-bottom: 10px; font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; line-height: 1.3;">{{ $item['title'] }}</h3>
                        <p style="color: var(--home-jade-100); opacity: 0.75; font-size: 0.95rem; line-height: 1.5; margin: 0;">{{ $item['desc'] }}</p>
                    </article>
                    @endforeach
                </div>

                <!-- Columna Derecha: Misión y Visión -->
                <div style="flex: 1 1 400px; display: flex; flex-direction: column; gap: 24px;">

                    <!-- Misión -->
                    <article style="background: linear-gradient(145deg, rgba(0, 168, 132, 0.15) 0%, rgba(0, 0, 0, 0.2) 100%); border: 1px solid rgba(0, 168, 132, 0.4); border-radius: 24px; padding: 32px; position: relative; overflow: hidden; flex: 1; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                        <div style="position: absolute; right: -20px; top: -20px; opacity: 0.08; transform: rotate(-15deg);">
                            <i data-lucide="target" style="width: 140px; height: 140px; color: var(--home-white);"></i>
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; position: relative; z-index: 1;">
                            <div style="background: var(--home-jade-500); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 15px rgba(0,168,132,0.4);">
                                <i data-lucide="target" style="width: 22px; height: 22px;"></i>
                            </div>
                            <h3 style="color: var(--home-white); font-size: 1.6rem; font-weight: 800; font-family: 'Outfit', sans-serif; margin: 0; letter-spacing: -0.02em;">Nuestra Misión</h3>
                        </div>
                        <p style="color: var(--home-jade-50); font-size: 1.05rem; line-height: 1.6; opacity: 0.9; margin: 0; position: relative; z-index: 1;">
                            Transformar vidas a través de la salud y estética dental, brindando una atención cálida, personalizada y de excelencia. Con <strong style="color: var(--home-white); font-weight: 700;">6 años de trayectoria profesional</strong>, nos dedicamos a devolverle a cada paciente la seguridad de sonreír sin miedos, utilizando tecnología de punta y procedimientos libres de dolor.
                        </p>
                    </article>

                    <!-- Visión -->
                    <article style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.06) 0%, rgba(0, 0, 0, 0.1) 100%); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 24px; padding: 32px; position: relative; overflow: hidden; flex: 1; display: flex; flex-direction: column; justify-content: center; backdrop-filter: blur(10px);">
                        <div style="position: absolute; right: -20px; bottom: -20px; opacity: 0.05; transform: rotate(15deg);">
                            <i data-lucide="eye" style="width: 140px; height: 140px; color: var(--home-white);"></i>
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; position: relative; z-index: 1;">
                            <div style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--home-white);">
                                <i data-lucide="eye" style="width: 22px; height: 22px;"></i>
                            </div>
                            <h3 style="color: var(--home-white); font-size: 1.6rem; font-weight: 800; font-family: 'Outfit', sans-serif; margin: 0; letter-spacing: -0.02em;">Nuestra Visión</h3>
                        </div>
                        <p style="color: var(--home-jade-50); font-size: 1.05rem; line-height: 1.6; opacity: 0.8; margin: 0; position: relative; z-index: 1;">
                            Posicionarnos como la clínica dental referente en innovación y trato humano, donde cada paciente sienta que está en las mejores manos. Aspiramos a seguir creciendo y ser reconocidos por nuestra ética profesional, resultados naturales y compromiso inquebrantable con tu bienestar.
                        </p>
                    </article>

                </div>
            </div>

            <!-- Trust Banner Bottom -->
            <div style="margin-top: 50px; padding: 28px; background: rgba(0, 0, 0, 0.2); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); display: flex; align-items: center; justify-content: center; gap: 40px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 14px; color: var(--home-white);">
                    <div style="background: rgba(0,168,132,0.2); padding: 10px; border-radius: 50%;"><i data-lucide="shield-check" style="color: var(--home-jade-600); width: 22px; height: 22px;"></i></div>
                    <span style="font-weight: 600; font-size: 1.1rem; font-family: 'Outfit', sans-serif;">Odontología Certificada</span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; color: var(--home-white);">
                    <div style="background: rgba(251,191,36,0.15); padding: 10px; border-radius: 50%;"><i data-lucide="star" style="color: #fbbf24; width: 22px; height: 22px;"></i></div>
                    <span style="font-weight: 600; font-size: 1.1rem; font-family: 'Outfit', sans-serif;">5.0 Estrellas en satisfacción</span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; color: var(--home-white);">
                    <div style="background: rgba(0,168,132,0.2); padding: 10px; border-radius: 50%;"><i data-lucide="microscope" style="color: var(--home-jade-600); width: 22px; height: 22px;"></i></div>
                    <span style="font-weight: 600; font-size: 1.1rem; font-family: 'Outfit', sans-serif;">Materiales Clínicos Premium</span>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section home-section-soft">
        <div class="home-shell">
            <div class="home-section-head">
                <div>
                    <div class="home-kicker">Tratamientos</div>
                    <h2 class="home-heading">Tratamientos integrales y personalizados para transformar tu sonrisa.</h2>
                </div>
                <a href="{{ route('public.servicios') }}" class="home-link">
                    Ver catálogo completo <i data-lucide="arrow-right"></i>
                </a>
            </div>

            <div class="home-services-grid">
                @forelse($serviciosHome as $servicio)
                <article class="home-card home-service-card fade-up">
                    <div class="home-service-media">
                        @if($servicio->image)
                        <img src="{{ $servicio->image }}" alt="{{ $servicio->name }}" width="720" height="440" loading="lazy">
                        @else
                        <div class="home-portrait-fallback">
                            <i data-lucide="{{ $servicio->category_icon }}" style="width:64px;height:64px;"></i>
                        </div>
                        @endif
                    </div>
                    <div class="home-service-body">
                        <span class="home-tag">{{ $servicio->category ?: 'Tratamiento' }}</span>
                        <h3 style="margin-top:14px;">{{ $servicio->name }}</h3>
                        <p>{{ $servicio->description_home }}</p>
                        <div class="home-service-meta">
                            <div>
                                <div class="home-duration">{{ $servicio->duration }} min</div>
                                <div class="home-price">{{ $servicio->price_display }}</div>
                            </div>
                            <button
                                type="button"
                                class="home-link btn-open-modal"
                                data-name="{{ $servicio->name }}"
                                data-desc="{{ $servicio->description }}"
                                data-category="{{ $servicio->category }}"
                                data-price="{{ $servicio->price }}"
                                data-duration="{{ $servicio->duration }}"
                                data-img="{{ $servicio->image }}"
                                data-wa-url="{{ $servicio->whatsapp_url }}">
                                Detalles
                            </button>
                        </div>
                    </div>
                </article>
                @empty
                <article class="home-card fade-up">
                    <div class="home-service-icon"><i data-lucide="smile"></i></div>
                    <h3>Evaluación dental integral</h3>
                    <p>Agenda una consulta para revisar tu salud dental y recibir una ruta de tratamiento personalizada.</p>
                    <a href="{{ route('public.reservar-cita') }}" class="home-link" style="margin-top:18px;">Reservar evaluación</a>
                </article>
                @endforelse
            </div>
        </div>
    </section>
    <!-- INSTALACIONES -->
    @if($instalaciones && $instalaciones->count() > 0)
    <section class="home-section" style="padding: 100px 0; background-color: var(--home-white);">
        <div class="home-shell">
            <div style="text-align: center; max-width: 700px; margin: 0 auto 50px;">
                <div class="home-kicker">Tour Virtual</div>
                <h2 class="home-heading">Nuestras Instalaciones</h2>
                <p class="home-section-copy" style="margin-top: 16px;">
                    Hemos diseñado un espacio pensado en tu tranquilidad, con tecnología de vanguardia y ambientes clínicos impecables.
                </p>
            </div>

            <div class="instalaciones-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                @foreach($instalaciones as $inst)
                <div style="border-radius: 24px; overflow: hidden; box-shadow: var(--home-shadow); position: relative; aspect-ratio: 4/3;">
                    <img src="{{ asset($inst->imagen_path) }}" alt="{{ $inst->titulo }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" loading="lazy">
                    @if($inst->titulo)
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 24px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); color: white;">
                        <h4 style="margin: 0; font-size: 1.1rem; font-weight: 600;">{{ $inst->titulo }}</h4>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- LA EXPERIENCIA MIRADENT -->
    @if(isset($loMasImportante) && count($loMasImportante) > 0)
    <section class="home-section" style="padding: 100px 0; background-color: var(--home-jade-50); border-radius: 40px; margin: 0 16px 100px;">
        <div class="home-shell">
            <div style="text-align: center; max-width: 700px; margin: 0 auto 60px;">
                <div class="home-kicker" style="color: var(--home-jade-600);">¿Por qué elegirnos?</div>
                <h2 class="home-heading" style="color: var(--home-jade-950);">La Experiencia Miradent</h2>
                <p class="home-section-copy" style="margin-top: 16px; color: var(--home-jade-800);">
                    Nuestra filosofía combina odontología de alto nivel con un trato humano cálido y cercano.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 32px;">
                @foreach($loMasImportante as $item)
                <div style="background: var(--home-white); padding: 40px 32px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,168,132,0.05); text-align: center; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 64px; height: 64px; background: var(--home-jade-100); color: var(--home-jade-600); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i data-lucide="{{ $item['icon'] }}" style="width: 32px; height: 32px;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; color: var(--home-jade-950); margin-bottom: 16px;">{{ $item['title'] }}</h3>
                    <p style="color: var(--home-slate-600); line-height: 1.6; margin: 0;">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <section class="home-section home-results-section">
        <div class="home-shell">
            <div class="home-results">
                <div class="home-results-copy">
                    <div class="home-kicker">Antes y después</div>
                    <h2 class="home-heading">Resultados que se ven limpios, naturales y cuidados.</h2>
                    <p class="home-section-copy" style="margin-top:18px;">
                        El objetivo no es cambiar tu identidad: es recuperar armonía, confianza y salud con decisiones clínicas bien explicadas.
                    </p>
                    <div class="home-result-points">
                        <span class="home-result-point"><i data-lucide="sparkles"></i> Acabado natural</span>
                        <span class="home-result-point"><i data-lucide="shield-check"></i> Cuidado clínico</span>
                        <span class="home-result-point"><i data-lucide="smile"></i> Confianza al sonreír</span>
                    </div>
                    <div class="home-actions">
                        <a href="{{ route('public.casos') }}" class="home-btn home-btn-secondary">
                            Ver resultados reales
                        </a>
                    </div>
                </div>

                @if($casoPrincipal && $casoPrincipal->has_images)
                <article class="home-case-card home-case-card-feature fade-up">
                    <div class="home-case-compare" tabindex="0" aria-label="Comparador de antes y después: {{ $casoPrincipal->title }}">
                        <img class="home-case-image home-case-image-after" src="{{ $casoPrincipal->after_image }}" alt="Después: {{ $casoPrincipal->title }}" draggable="false" loading="lazy">
                        <img class="home-case-image home-case-image-before" src="{{ $casoPrincipal->before_image }}" alt="Antes: {{ $casoPrincipal->title }}" draggable="false" loading="lazy">
                        <span class="home-case-label home-case-label-before">Antes</span>
                        <span class="home-case-label home-case-label-after">Después</span>
                        <span class="home-case-control" aria-hidden="true">
                            <span><i data-lucide="move-horizontal"></i></span>
                        </span>
                    </div>
                    <div class="home-case-body">
                        <h3>{{ $casoPrincipal->title }}</h3>
                        <p>{{ $casoPrincipal->description_short }}</p>
                    </div>
                </article>
                @else
                <article class="home-card fade-up">
                    <div class="home-care-icon"><i data-lucide="image-plus"></i></div>
                    <h3>Nuevos casos en preparación</h3>
                    <p>Pronto mostraremos más resultados clínicos reales de pacientes Miradent.</p>
                </article>
                @endif
            </div>
        </div>
    </section>

    <section class="home-section home-promo-section" style="padding: 100px 0; background: linear-gradient(180deg, rgba(0,168,132,0.03) 0%, var(--home-white) 100%); border-top: 1px solid rgba(0,168,132,0.05);">
        <div class="home-shell">
            <div class="home-section-head home-promo-head" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; margin-bottom: 60px; gap: 40px;">
                <div style="flex: 1 1 500px;">
                    <div class="home-kicker" style="color: var(--home-jade-600); background: rgba(0,168,132,0.1); display: inline-flex; padding: 6px 14px; border-radius: 99px; font-weight: 700; margin-bottom: 16px;">
                        <i data-lucide="tag" style="width: 16px; height: 16px; margin-right: 6px;"></i> Promociones Especiales
                    </div>
                    <h2 class="home-heading" style="font-size: clamp(2.4rem, 4vw, 3.4rem); line-height: 1.1; margin-bottom: 0;">
                        Beneficios exclusivos para que empieces a cuidarte hoy mismo.
                    </h2>
                </div>
                <div style="flex: 1 1 300px; display: flex; flex-direction: column; align-items: flex-start; gap: 20px;">
                    <p class="home-section-copy home-promo-intro" style="font-size: 1.1rem; color: var(--home-jade-800); opacity: 0.8; margin: 0; line-height: 1.6;">
                        Aprovecha nuestras campañas con fechas claras. Separa tu cita al instante por WhatsApp mientras las ofertas sigan vigentes y ahorra en tu tratamiento.
                    </p>
                    <a href="{{ route('public.promociones') }}" class="home-btn" style="background: white; color: var(--home-jade-800); border: 2px solid rgba(0,168,132,0.2); border-radius: 99px; font-weight: 700; padding: 12px 28px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='var(--home-jade-50)'; this.style.borderColor='var(--home-jade-300)';" onmouseout="this.style.background='white'; this.style.borderColor='rgba(0,168,132,0.2)';">
                        Ver todas las promociones <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>

            <style>
                .premium-promo-card {
                    display: flex;
                    flex-direction: column;
                    background: #fff;
                    border-radius: 32px;
                    overflow: hidden;
                    box-shadow: 0 15px 50px rgba(0, 168, 132, 0.08);
                    border: 1px solid rgba(0, 168, 132, 0.1);
                    transition: all 0.4s ease;
                    text-decoration: none;
                }

                .premium-promo-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 25px 60px rgba(0, 168, 132, 0.15);
                    border-color: rgba(0, 168, 132, 0.2);
                }

                @media(min-width: 900px) {
                    .premium-promo-card {
                        flex-direction: row;
                        align-items: stretch;
                        min-height: 420px;
                    }
                }

                .premium-promo-image-wrapper {
                    position: relative;
                    width: 100%;
                    min-height: 300px;
                    background: var(--home-jade-50);
                    flex-shrink: 0;
                }

                @media(min-width: 900px) {
                    .premium-promo-image-wrapper {
                        width: 48%;
                        min-height: auto;
                    }
                }

                .premium-promo-image-wrapper img {
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .premium-promo-floating-discount {
                    position: absolute;
                    top: 24px;
                    right: 24px;
                    background: #ff3b30;
                    color: white;
                    font-weight: 900;
                    font-size: 1.4rem;
                    padding: 12px 20px;
                    border-radius: 16px;
                    box-shadow: 0 10px 25px rgba(255, 59, 48, 0.4);
                    z-index: 10;
                    transform: rotate(4deg);
                    font-family: 'Outfit', sans-serif;
                    letter-spacing: -0.5px;
                    border: 3px solid white;
                }

                .premium-promo-content {
                    padding: 40px 30px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    flex-grow: 1;
                }

                @media(min-width: 900px) {
                    .premium-promo-content {
                        padding: 60px;
                    }
                }

                .premium-promo-status {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 16px;
                    background: var(--home-jade-100);
                    color: var(--home-jade-800);
                    border-radius: 99px;
                    font-size: 0.8rem;
                    font-weight: 800;
                    letter-spacing: 1px;
                    text-transform: uppercase;
                    margin-bottom: 24px;
                    width: fit-content;
                }

                .premium-promo-title {
                    font-family: 'Outfit', sans-serif;
                    font-size: clamp(2rem, 3.5vw, 2.8rem);
                    font-weight: 800;
                    color: var(--home-jade-950);
                    line-height: 1.1;
                    margin-bottom: 20px;
                }

                .premium-promo-desc {
                    font-size: 1.15rem;
                    color: var(--home-jade-800);
                    line-height: 1.6;
                    margin-bottom: 30px;
                    opacity: 0.85;
                }

                .premium-promo-meta {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    color: var(--home-jade-800);
                    font-size: 1rem;
                    font-weight: 700;
                    margin-bottom: 40px;
                    background: rgba(0, 168, 132, 0.05);
                    border: 1px solid rgba(0, 168, 132, 0.1);
                    padding: 12px 20px;
                    border-radius: 16px;
                    width: fit-content;
                }

                .premium-promo-btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                    background: var(--home-jade-600);
                    color: white;
                    padding: 18px 36px;
                    border-radius: 99px;
                    font-weight: 800;
                    font-size: 1.1rem;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    width: fit-content;
                    border: none;
                    box-shadow: 0 10px 25px rgba(0, 168, 132, 0.3);
                }

                .premium-promo-btn:hover {
                    background: var(--home-jade-700);
                    transform: scale(1.05);
                    box-shadow: 0 15px 35px rgba(0, 168, 132, 0.4);
                }
            </style>

            <div style="display: flex; flex-direction: column; gap: 40px;">
                @forelse($promocionesHome as $promo)
                @php($promoIsVigente = $promo->status_class === 'status-vigente')
                <article class="premium-promo-card fade-up">
                    @if($promo->image)
                    <div class="premium-promo-image-wrapper">
                        <img src="{{ $promo->image }}" alt="{{ $promo->title }}" loading="lazy">
                        @if($promo->discount_label)
                        <div class="premium-promo-floating-discount">
                            {{ $promo->discount_label }}
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="premium-promo-content">
                        <div class="premium-promo-status">
                            <span style="width: 8px; height: 8px; background: currentColor; border-radius: 50%; display: inline-block;"></span>
                            {{ $promo->status_label }}
                        </div>
                        <h3 class="premium-promo-title">{{ $promo->title }}</h3>
                        <p class="premium-promo-desc">{{ $promo->description_short }}</p>

                        @if($promo->ends_at)
                        <div class="premium-promo-meta">
                            <i data-lucide="calendar-clock" style="width: 22px; height: 22px; color: var(--home-jade-600);"></i>
                            <span>{{ $promo->status_class === 'status-expirada' ? 'Finalizó el' : 'Disponible hasta el' }} {{ $promo->ends_at }}</span>
                        </div>
                        @endif

                        <div>
                            @if($promoIsVigente)
                            <a href="{{ $promo->whatsapp_url }}" target="_blank" class="premium-promo-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg> Aprovecha esta promoción
                            </a>
                            @else
                            <a href="{{ route('public.promociones') }}" class="premium-promo-btn" style="background: var(--home-jade-100); color: var(--home-jade-800); box-shadow: none;">
                                Ver promociones vigentes <i data-lucide="arrow-right" style="width: 20px; height: 20px;"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </article>
                @empty
                <div style="text-align: center; padding: 60px; background: rgba(0,168,132,0.05); border-radius: 24px;">
                    <i data-lucide="gift" style="width: 60px; height: 60px; color: var(--home-jade-600); margin-bottom: 20px; opacity: 0.5;"></i>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--home-jade-900);">No hay promociones vigentes en este momento</h3>
                    <p style="color: var(--home-jade-700); margin-bottom: 30px;">Mantente atento a nuestras próximas campañas y beneficios exclusivos.</p>
                    <a href="{{ route('public.reservar-cita') }}" class="premium-promo-btn">
                        Agendar cita regular <i data-lucide="calendar-check" style="width: 20px; height: 20px;"></i>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION: EL PROCESO (How it works) -->
    <section class="home-section" style="background: var(--home-white); border-top: 1px solid rgba(0,168,132,0.05); padding: 100px 0;">
        <div class="home-shell">
            <div style="text-align: center; max-width: 600px; margin: 0 auto 60px auto;">
                <div class="home-kicker" style="color: var(--home-jade-600); background: rgba(0,168,132,0.1); display: inline-flex; padding: 6px 14px; border-radius: 99px; font-weight: 700; margin-bottom: 16px;">
                    <i data-lucide="route" style="width: 16px; height: 16px; margin-right: 6px;"></i> ¿Cómo empezamos?
                </div>
                <h2 class="home-heading" style="font-size: clamp(2.2rem, 4vw, 3rem); line-height: 1.1; margin-bottom: 20px;">
                    Tu camino hacia una sonrisa más sana
                </h2>
                <p style="color: var(--home-jade-800); font-size: 1.1rem; opacity: 0.8;">
                    En Miradent, diseñamos un proceso claro y sin complicaciones para que te sientas seguro en cada paso de tu tratamiento.
                </p>
            </div>

            <style>
                .home-process-grid {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 30px;
                }

                @media(min-width: 768px) {
                    .home-process-grid {
                        grid-template-columns: repeat(4, 1fr);
                        gap: 20px;
                    }
                }

                .home-process-step {
                    background: #fff;
                    padding: 40px 30px;
                    border-radius: 32px;
                    box-shadow: 0 10px 30px rgba(0, 168, 132, 0.05);
                    border: 1px solid rgba(0, 168, 132, 0.08);
                    text-align: center;
                    position: relative;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .home-process-step:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 40px rgba(0, 168, 132, 0.1);
                    border-color: rgba(0, 168, 132, 0.2);
                }

                .home-process-icon-wrap {
                    width: 80px;
                    height: 80px;
                    background: var(--home-jade-50);
                    color: var(--home-jade-600);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 24px auto;
                }

                .home-process-icon-wrap i {
                    width: 36px;
                    height: 36px;
                }

                .home-process-num {
                    position: absolute;
                    top: -15px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: var(--home-jade-600);
                    color: white;
                    width: 36px;
                    height: 36px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    font-weight: 900;
                    font-size: 1.1rem;
                    font-family: 'Outfit', sans-serif;
                    box-shadow: 0 6px 15px rgba(0, 168, 132, 0.3);
                    border: 3px solid white;
                }

                .home-process-step h3 {
                    font-family: 'Outfit', sans-serif;
                    font-size: 1.4rem;
                    font-weight: 800;
                    color: var(--home-jade-950);
                    margin-bottom: 12px;
                }

                .home-process-step p {
                    color: var(--home-jade-700);
                    font-size: 1rem;
                    line-height: 1.6;
                }
            </style>

            <div class="home-process-grid">
                <div class="home-process-step fade-up">
                    <div class="home-process-num">1</div>
                    <div class="home-process-icon-wrap"><i data-lucide="clipboard-list"></i></div>
                    <h3>Evaluación Integral</h3>
                    <p>Revisamos a detalle el estado de tu salud bucal, analizando cada aspecto de forma profesional.</p>
                </div>
                <div class="home-process-step fade-up" style="transition-delay: 100ms;">
                    <div class="home-process-num">2</div>
                    <div class="home-process-icon-wrap"><i data-lucide="search"></i></div>
                    <h3>Diagnóstico Transparente</h3>
                    <p>Te explicamos exactamente qué necesitas, sin palabras complicadas y con un presupuesto claro.</p>
                </div>
                <div class="home-process-step fade-up" style="transition-delay: 200ms;">
                    <div class="home-process-num">3</div>
                    <div class="home-process-icon-wrap"><i data-lucide="tool"></i></div>
                    <h3>Tratamiento Especializado</h3>
                    <p>Aplicamos técnicas modernas y sin dolor, enfocándonos siempre en tu comodidad y tranquilidad.</p>
                </div>
                <div class="home-process-step fade-up" style="transition-delay: 300ms;">
                    <div class="home-process-num">4</div>
                    <div class="home-process-icon-wrap"><i data-lucide="smile"></i></div>
                    <h3>Sonrisa Renovada</h3>
                    <p>Te guiamos en el mantenimiento para que tu nueva sonrisa perdure hermosa por muchísimos años.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section">
        <div class="home-shell">
            <div class="home-section-head">
                <div>
                    <div class="home-kicker">Pacientes</div>
                    <h2 class="home-heading">La confianza también se nota en cómo te atienden.</h2>
                </div>
                <a href="{{ route('public.testimonios') }}" class="home-link">
                    Leer testimonios <i data-lucide="arrow-right"></i>
                </a>
            </div>

            <div class="home-testimonials-grid">
                @forelse($testimoniosHome as $testimonio)
                <article class="home-card home-quote fade-up">
                    <div>
                        <div class="home-stars">
                            @for($i = 0; $i < ($testimonio->estrellas ?? 5); $i++)
                                <i data-lucide="star"></i>
                                @endfor
                        </div>
                        <blockquote>"{{ $testimonio->testimonio }}"</blockquote>
                    </div>
                    <div class="home-quote-author">{{ $testimonio->nombre_paciente }}</div>
                </article>
                @empty
                <article class="home-card home-quote fade-up">
                    <div>
                        <div class="home-stars">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star"></i>
                                @endfor
                        </div>
                        <blockquote>"Una atención clara, amable y enfocada en hacerme sentir tranquila desde el inicio."</blockquote>
                    </div>
                    <div class="home-quote-author">Paciente Miradent</div>
                </article>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION: PREGUNTAS FRECUENTES -->
    <section class="home-section" style="background: rgba(0,168,132,0.02); padding: 100px 0;">
        <div class="home-shell">
            <div style="display: flex; flex-wrap: wrap; gap: 60px; align-items: flex-start;">
                <div style="flex: 1 1 400px; position: sticky; top: 40px;">
                    <div class="home-kicker" style="color: var(--home-jade-600); background: rgba(0,168,132,0.1); display: inline-flex; padding: 6px 14px; border-radius: 99px; font-weight: 700; margin-bottom: 16px;">
                        <i data-lucide="help-circle" style="width: 16px; height: 16px; margin-right: 6px;"></i> Preguntas Frecuentes
                    </div>
                    <h2 class="home-heading" style="font-size: clamp(2.4rem, 4vw, 3.2rem); line-height: 1.1; margin-bottom: 24px;">
                        Resolvemos tus principales dudas
                    </h2>
                    <p style="color: var(--home-jade-800); font-size: 1.15rem; opacity: 0.8; margin-bottom: 30px; line-height: 1.6;">
                        Sabemos que ir al dentista puede generar dudas. Aquí te respondemos las inquietudes más comunes de nuestros pacientes antes de su primera cita.
                    </p>
                    <a href="{{ $doctora->whatsapp_url }}" target="_blank" class="home-btn" style="background: white; border: 2px solid rgba(0,168,132,0.15); color: var(--home-jade-800); font-weight: 700; padding: 14px 30px; border-radius: 99px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='var(--home-jade-50)'; this.style.borderColor='var(--home-jade-300)';" onmouseout="this.style.background='white'; this.style.borderColor='rgba(0,168,132,0.15)';">
                        ¿Tienes otra duda? Escríbenos <i data-lucide="message-circle" style="width: 20px; height: 20px;"></i>
                    </a>
                </div>

                <style>
                    .home-faq-list {
                        display: flex;
                        flex-direction: column;
                        gap: 16px;
                    }

                    .home-faq-item {
                        background: #fff;
                        border-radius: 24px;
                        border: 1px solid rgba(0, 168, 132, 0.08);
                        box-shadow: 0 5px 20px rgba(0, 168, 132, 0.04);
                        overflow: hidden;
                        transition: all 0.3s ease;
                    }

                    .home-faq-item:hover {
                        border-color: rgba(0, 168, 132, 0.2);
                        box-shadow: 0 10px 30px rgba(0, 168, 132, 0.08);
                    }

                    .home-faq-question {
                        width: 100%;
                        text-align: left;
                        background: none;
                        border: none;
                        padding: 28px 30px;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        font-family: 'Outfit', sans-serif;
                        font-size: 1.25rem;
                        font-weight: 800;
                        color: var(--home-jade-950);
                        cursor: pointer;
                    }

                    .home-faq-question i {
                        color: var(--home-jade-600);
                        transition: transform 0.4s ease;
                        background: var(--home-jade-50);
                        padding: 6px;
                        border-radius: 50%;
                        width: 36px;
                        height: 36px;
                    }

                    .home-faq-item.is-active .home-faq-question i {
                        transform: rotate(180deg);
                        background: var(--home-jade-600);
                        color: white;
                    }

                    .home-faq-answer {
                        padding: 0 30px;
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.5s ease, padding 0.5s ease;
                        color: var(--home-jade-800);
                        font-size: 1.1rem;
                        line-height: 1.6;
                        opacity: 0.9;
                    }

                    .home-faq-item.is-active .home-faq-answer {
                        padding: 0 30px 30px 30px;
                        max-height: 400px;
                    }
                </style>

                <div style="flex: 1 1 500px;" class="home-faq-list">
                    <div class="home-faq-item is-active fade-up">
                        <button class="home-faq-question" onclick="this.parentElement.classList.toggle('is-active')">
                            ¿Duele el tratamiento en Miradent? <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="home-faq-answer">
                            No. Nuestro enfoque principal es que tengas una experiencia clínica completamente libre de dolor. Utilizamos técnicas modernas y anestesia local de alta calidad para garantizar tu comodidad en todo momento.
                        </div>
                    </div>
                    <div class="home-faq-item fade-up">
                        <button class="home-faq-question" onclick="this.parentElement.classList.toggle('is-active')">
                            ¿Qué métodos de pago aceptan? <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="home-faq-answer">
                            Aceptamos todas las tarjetas de crédito y débito, transferencias bancarias, Yape/Plin, y efectivo. Además, contamos con opciones de financiamiento y promociones especiales dependiendo del tipo de tratamiento.
                        </div>
                    </div>
                    <div class="home-faq-item fade-up">
                        <button class="home-faq-question" onclick="this.parentElement.classList.toggle('is-active')">
                            ¿Cada cuánto tiempo debo hacerme una limpieza dental? <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="home-faq-answer">
                            Recomendamos una profilaxis dental (limpieza profesional) cada 6 meses. Sin embargo, si tienes problemas de encías o usas brackets, lo ideal puede ser cada 3 o 4 meses para evitar la acumulación de placa y sarro.
                        </div>
                    </div>
                    <div class="home-faq-item fade-up">
                        <button class="home-faq-question" onclick="this.parentElement.classList.toggle('is-active')">
                            ¿La evaluación inicial tiene costo? <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="home-faq-answer">
                            El costo de nuestra evaluación incluye un diagnóstico integral y el diseño de tu plan de tratamiento personalizado. Si decides iniciar tu tratamiento con nosotros en la misma cita, este monto será considerado a cuenta de tu procedimiento.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-cta">
        <!-- Decoración abstracta de fondo -->
        <div style="position: absolute; bottom: 0; right: 0; width: 60%; height: 100%; background: radial-gradient(circle at 100% 100%, rgba(0, 168, 132, 0.1) 0%, transparent 60%);"></div>

        <div class="home-shell home-cta-box">
            <div>
                <div class="home-kicker" style="color:var(--home-jade-600);">Tu primera visita</div>
                <h2>Agenda una evaluación y sal con un plan claro.</h2>
                <p>
                    Cuéntanos qué quieres mejorar y revisaremos contigo las opciones más convenientes para tu sonrisa.
                </p>
            </div>
            <a href="{{ $doctora->whatsapp_url }}" target="_blank" class="home-btn home-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                Escribir por WhatsApp
            </a>
        </div>
    </section>

    <div id="homeEntryPopup" class="home-entry-popup" role="dialog" aria-modal="true" aria-labelledby="homeEntryPopupTitle" aria-hidden="true">
        <div class="home-entry-popup-card" role="document">
            <button type="button" class="home-entry-popup-close" data-home-popup-close aria-label="Cerrar aviso">
                <i data-lucide="x"></i>
            </button>

            <div class="home-entry-popup-media">
                @if($homePopupImage)
                <img src="{{ $homePopupImage }}" alt="{{ $popupPromo ? $popupPromo->title : 'Miradent atención dental' }}">
                @else
                <div class="home-entry-popup-fallback">
                    <i data-lucide="sparkles"></i>
                </div>
                @endif

                {{-- Flotante de Descuento (Desde la BD) --}}
                @if($popupPromo && $popupPromo->discount_percentage > 0)
                <div style="position: absolute; top: 24px; left: 24px; background: #e11d48; color: white; padding: 12px 18px; border-radius: 16px; font-weight: 900; box-shadow: 0 10px 25px rgba(225, 29, 72, 0.5); transform: rotate(-4deg); z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1; border: 3px solid white;">
                    <span style="font-size: 2.2rem; margin-bottom: 6px; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">-{{ $popupPromo->discount_percentage }}%</span>
                    <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.95; font-weight: 700;">Descuento</span>
                </div>
                @endif
            </div>

            <div class="home-entry-popup-body">
                @if($popupPromo)
                <span class="home-entry-popup-kicker">Promoción vigente</span>
                <h2 id="homeEntryPopupTitle">{{ $popupPromo->title }}</h2>
                <p>{{ $popupPromo->description_short }}</p>
                @if($popupPromo->ends_at)
                <p class="home-entry-popup-note">Disponible hasta {{ $popupPromo->ends_at }}.</p>
                @endif
                <div class="home-entry-popup-actions">
                    <a href="{{ $popupPromo->whatsapp_url }}" target="_blank" class="home-btn home-btn-primary" data-home-popup-close>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Aprovecha esta promoción
                    </a>
                    <button type="button" class="home-btn home-btn-secondary" data-home-popup-close>
                        Ver después
                    </button>
                </div>
                @else
                <span class="home-entry-popup-kicker">Bienvenido a Miradent</span>
                <h2 id="homeEntryPopupTitle">Empieza con una evaluación clara.</h2>
                <p>Cuéntanos qué quieres mejorar y te ayudamos a encontrar el tratamiento más conveniente para tu sonrisa.</p>
                <div class="home-entry-popup-actions">
                    <a href="{{ route('public.reservar-cita') }}" class="home-btn home-btn-primary" data-home-popup-close>
                        <i data-lucide="calendar-check"></i>
                        Reservar cita
                    </a>
                    <button type="button" class="home-btn home-btn-secondary" data-home-popup-close>
                        Ver página
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const defaultTitle = document.title;
        const comebackTitle = 'Vuelve a Miradent | Tenemos descuentos';

        document.addEventListener('visibilitychange', () => {
            document.title = document.hidden ? comebackTitle : defaultTitle;
        });

        const popup = document.getElementById('homeEntryPopup');
        const storageKey = 'miradent_home_entry_popup_closed';

        if (!popup || sessionStorage.getItem(storageKey) === '1') {
            return;
        }

        const closePopup = () => {
            popup.classList.remove('is-open');
            popup.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('home-popup-lock');
            sessionStorage.setItem(storageKey, '1');
        };

        const openPopup = () => {
            popup.hidden = false;
            popup.setAttribute('aria-hidden', 'false');
            document.body.classList.add('home-popup-lock');
            requestAnimationFrame(() => popup.classList.add('is-open'));
            window.lucide?.createIcons();
        };

        popup.querySelectorAll('[data-home-popup-close]').forEach((element) => {
            element.addEventListener('click', closePopup);
        });

        popup.addEventListener('click', (event) => {
            if (event.target === popup) {
                closePopup();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && popup.classList.contains('is-open')) {
                closePopup();
            }
        });

        window.setTimeout(openPopup, 750);
    });
</script>
@endsection
