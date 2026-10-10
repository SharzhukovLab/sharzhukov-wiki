<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    /**
     * Получить значение по ключу (с кэшированием).
     */
    public static function get(string $key, $default = null)
    {
        $all = Cache::rememberForever('settings.all', function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $all[$key] ?? $default;
    }

    /**
     * Получить URL изображения.
     * Приоритет: загруженный файл из storage → fallback значение.
     */
    public static function image(string $key, ?string $fallback = null): ?string
    {
        $value = self::get($key);
        if (empty($value)) {
            // Пробуем fallback из другой настройки
            $fallbackKey = $key . '_fallback';
            $value = self::get($fallbackKey, $fallback);
        }

        if (empty($value)) {
            return $fallback;
        }

        // 1. Полный URL (http://, https://) — возвращаем как есть
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // 2. Путь из public/ (начинается с /) — это asset, БЕЗ storage/
        //    Пример: /img/branding/minimal-black.png → https://site/img/branding/minimal-black.png
        if (str_starts_with($value, '/')) {
            return asset(ltrim($value, '/'));
        }

        // 3. Относительный путь в storage (загруженный файл через админку)
        //    Пример: settings/logo.png → https://site/storage/settings/logo.png
        return asset('storage/' . $value);
    }

    /**
     * Установить значение.
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
