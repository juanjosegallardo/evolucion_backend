<?php

namespace App\Traits;

trait MetadatosClaseTrait
{
    protected static array $metadataCache = [];

    protected static function instance(): static
    {
        return static::$metadataCache[static::class]
            ??= new static;
    }

    public static function morph(): string
    {
        return static::instance()->getMorphClass();
    }

    public static function table(): string
    {
        return static::instance()->getTable();
    }
}
