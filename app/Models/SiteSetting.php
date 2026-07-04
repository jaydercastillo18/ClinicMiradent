<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function yapeQrUrl(): ?string
    {
        $path = static::get('yape_qr_path');

        if (!$path) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) {
            return asset($path);
        }

        return Storage::url($path);
    }
}
