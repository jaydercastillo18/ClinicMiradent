<?php

if (!function_exists('image_url')) {
    /**
     * Get the correct image URL, preserving base64 data URIs and external URLs without prepending root URL via asset().
     * If $type and $id are provided and the image is Base64, it returns a lightweight controller URL (/img/{type}/{id})
     * to prevent bloating HTML pages or API payloads beyond Vercel's 4.5MB Serverless function limit.
     */
    function image_url(?string $path, ?string $default = null, ?string $type = null, $id = null): ?string
    {
        if (empty($path)) {
            return $default;
        }

        if (str_starts_with($path, 'data:image')) {
            if ($type !== null && $id !== null) {
                return url("/img/{$type}/{$id}");
            }
            return $path;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }

        return asset($path);
    }
}
