<?php
namespace App\Support;

class MovimientoInventarioRegistry
{
    protected static array $models = [];

    public static function register(string $model): void
    {
        static::$models[] = $model;
    }

    public static function all(): array
    {
        return static::$models;
        
    }
}