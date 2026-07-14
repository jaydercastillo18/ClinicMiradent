<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ImageUploadService
{
    /**
     * Sube y procesa una imagen, devolviendo la ruta pública.
     *
     * @param UploadedFile $file Archivo subido
     * @param string $directory Directorio de destino relativo a public (e.g. 'uploads/instalaciones')
     * @param int $maxWidth Ancho máximo al que se redimensionará
     * @param int $quality Calidad de compresión WebP
     * @return string Ruta relativa (e.g. 'uploads/instalaciones/foto.webp')
     */
    public function upload(UploadedFile $file, string $directory, int $maxWidth = 1200, int $quality = 80): string
    {
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
        return $this->uploadCustomName($file, $directory, $fileName, $maxWidth, $quality);
    }

    /**
     * Sube y procesa una imagen usando un nombre de archivo personalizado.
     *
     * @param UploadedFile $file Archivo subido
     * @param string $directory Directorio de destino relativo a public
     * @param string $fileName Nombre de archivo completo (e.g. 'avatar.jpg')
     * @param int $maxWidth Ancho máximo al que se redimensionará
     * @param int $quality Calidad de compresión
     * @return string Ruta relativa o Data URI en base64 para persistencia en Vercel
     */
    public function uploadCustomName(UploadedFile $file, string $directory, string $fileName, int $maxWidth = 1200, int $quality = 80): string
    {
        $format = Str::endsWith(strtolower($fileName), ['.jpg', '.jpeg']) ? Format::JPEG : Format::WEBP;

        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getRealPath());
        $image->scaleDown(width: $maxWidth);
        $encoded = $image->encodeUsingFormat($format, $quality);

        // Intentar guardar en disco local (para desarrollo o servidores clásicos)
        try {
            $uploadPath = public_path($directory);
            if (!File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }
            $encoded->save($uploadPath . '/' . $fileName);
        } catch (\Throwable $e) {
            // En Vercel Serverless el sistema de archivos es de solo lectura, ignorar
        }

        // Devolver como Data URI base64 para que se guarde directamente en la base de datos MySQL/TiDB
        // y esté accesible de forma permanente sin requerir S3 o almacenamiento de archivos.
        $mime = $format === Format::JPEG ? 'image/jpeg' : 'image/webp';
        return 'data:' . $mime . ';base64,' . base64_encode((string) $encoded);
    }

    /**
     * Elimina una imagen del almacenamiento público.
     *
     * @param string|null $path Ruta relativa a public
     * @return void
     */
    public function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        $oldFilePath = public_path($path);

        if (File::exists($oldFilePath)) {
            File::delete($oldFilePath);
        }
    }
}
