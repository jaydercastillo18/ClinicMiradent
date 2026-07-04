@extends('errors.layout')

@section('code', '500')
@section('title', 'Error del Servidor')
@section('message', '¡Vaya! Algo salió mal en nuestros servidores. Nuestro equipo técnico ya ha sido notificado y estamos trabajando para solucionarlo.')

@section('icon-svg')
<!-- Icono Servidor Roto (Lucide Server Crash SVG) -->
<svg xmlns="https://chatgpt.com/backend-api/estuary/content?id=file_000000005668720ea45444fcd114170f&ts=494781&p=fs&cid=1&sig=88880e79953516c33d3dce2e0fed9cc4d8f15516a11afde8b892d81710ef333b&v=0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M6 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2" />
    <path d="M6 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2" />
    <path d="M6 6h.01" />
    <path d="M6 18h.01" />
    <path d="m13 6-4 6h6l-4 6" />
</svg>
@endsection