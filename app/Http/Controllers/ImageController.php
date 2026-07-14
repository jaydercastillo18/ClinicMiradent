<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    /**
     * Sirve imágenes almacenadas como base64 o rutas en la base de datos de manera ligera,
     * evitando que el HTML de las vistas crezca exponencialmente superando el límite de Vercel (4.5 MB).
     */
    public function show(string $type, int $id)
    {
        $tableMap = [
            'servicio'      => ['table' => 'servicios', 'field' => 'imagen_path'],
            'servicios'     => ['table' => 'servicios', 'field' => 'imagen_path'],
            'promocion'     => ['table' => 'promociones', 'field' => 'imagen_path'],
            'promociones'   => ['table' => 'promociones', 'field' => 'imagen_path'],
            'instalacion'   => ['table' => 'instalaciones', 'field' => 'imagen_path'],
            'instalaciones' => ['table' => 'instalaciones', 'field' => 'imagen_path'],
            'caso_antes'    => ['table' => 'casos_exito', 'field' => 'antes_img'],
            'caso_despues'  => ['table' => 'casos_exito', 'field' => 'despues_img'],
            'doctora'       => ['table' => 'doctoras', 'field' => 'avatar'],
        ];

        if (!isset($tableMap[$type])) {
            abort(404);
        }

        $config = $tableMap[$type];
        $row = DB::table($config['table'])->where('id', $id)->select($config['field'])->first();

        if (!$row || empty($row->{$config['field']})) {
            abort(404);
        }

        $path = $row->{$config['field']};

        // Si es una cadena base64 en la base de datos (ej: data:image/webp;base64,.....)
        if (str_starts_with($path, 'data:image/')) {
            if (preg_match('/^data:(image\/[a-zA-Z0-9\-\.\+]+);base64,(.+)$/s', $path, $matches)) {
                $mime = $matches[1];
                $binary = base64_decode($matches[2]);
                return response($binary, 200)
                    ->header('Content-Type', $mime)
                    ->header('Cache-Control', 'public, max-age=31536000, immutable');
            }
        }

        // Si es archivo físico
        if (!str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
            $localPath = public_path($path);
            if (file_exists($localPath)) {
                return response()->file($localPath, [
                    'Cache-Control' => 'public, max-age=31536000, immutable'
                ]);
            }
        }

        // Si es URL externa, redireccionar
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return redirect()->away($path);
        }

        abort(404);
    }
}
