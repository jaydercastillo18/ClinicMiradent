<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentSettingRequest;
use App\Models\SiteSetting;
use App\Services\ImageUploadService;

class PaymentSettingController extends Controller
{
    /**
     * Display the payment settings form (Yape QR image).
     */
    public function edit()
    {
        $yapeQrUrl = SiteSetting::yapeQrUrl();
        $yapePhone = SiteSetting::get('yape_phone');

        return view('configuracion_pagos', compact('yapeQrUrl', 'yapePhone'));
    }

    /**
     * Update the Yape QR image and/or payment phone.
     */
    public function update(PaymentSettingRequest $request, ImageUploadService $imageService)
    {
        $validated = $request->validated();

        if ($request->hasFile('yape_qr')) {
            $oldPath = SiteSetting::get('yape_qr_path');

            if ($oldPath) {
                $imageService->delete($oldPath);
            }

            $path = $imageService->upload($request->file('yape_qr'), 'uploads/payments', 800);

            SiteSetting::set('yape_qr_path', $path);
        }

        SiteSetting::set('yape_phone', $validated['yape_phone'] ?? null);

        return $this->backSavedResponse($request, 'Configuración de pagos actualizada correctamente.');
    }
}
