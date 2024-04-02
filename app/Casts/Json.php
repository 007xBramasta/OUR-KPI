<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Json implements CastsAttributes
{
    protected $depth;

    public function __construct($depth = null)
    {
        $this->depth = $depth;
    }

    public function get($model, $key, $value, $attributes)
    {
        return $this->decodeJson($value);
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }

    protected function decodeJson($value)
    {
        // Decode JSON with depth control
        $decoded = json_decode($value, true, $this->depth ?? 512, JSON_THROW_ON_ERROR);

        // Convert to associative array if it's not already
        return is_array($decoded) ? $decoded : [$decoded];
    }
}
