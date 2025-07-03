<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'image',
    ];

    public $timestamps = true;

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }
        return $setting->value;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function setValue(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get a setting image path by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getImage(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }
        return $setting->image;
    }

    /**
     * Set a setting image path by key.
     *
     * @param string $key
     * @param string $imagePath
     * @return void
     */
    public static function setImage(string $key, string $imagePath): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['image' => $imagePath]
        );
    }
}
