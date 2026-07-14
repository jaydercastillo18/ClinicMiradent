<?php

if (!function_exists('image_url')) {
    /**
     * Get the correct image URL, preserving base64 data URIs and external URLs without prepending root URL via asset().
     */
    function image_url(?string $path, ?string $default = null): ?string
    {
        if (empty($path)) {
            return $default;
        }

        if (str_starts_with($path, 'data:image') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }

        return asset($path);
    }
}
