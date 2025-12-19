<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/database/migrations',
        __DIR__ . '/database/seeders',
        __DIR__ . '/config',
    ])
    ->withSkip([
        // Skip vendor and storage
        __DIR__ . '/vendor',
        __DIR__ . '/storage',
        __DIR__ . '/bootstrap/cache',
        // Skip file that causes Rector parser error
        __DIR__ . '/app/Modules/ModuleServiceProvider.php',
    ])
    ->withSets([
        // PHP 7.4 compatibility
        SetList::PHP_74,

        // Laravel upgrade sets (5.2 -> 6.0)
        // Apply incrementally: each set upgrades TO that version
//        LaravelSetList::LARAVEL_53,  // 5.2 -> 5.3
//        LaravelSetList::LARAVEL_54,  // 5.3 -> 5.4
//        LaravelSetList::LARAVEL_55,  // 5.4 -> 5.5
//        LaravelSetList::LARAVEL_56,  // 5.5 -> 5.6
//        LaravelSetList::LARAVEL_57,  // 5.6 -> 5.7
//        LaravelSetList::LARAVEL_58,  // 5.7 -> 5.8
//        LaravelSetList::LARAVEL_60,  // 5.8 -> 6.0

        // Laravel 6.0 -> 7.0 upgrade (completed)
//        LaravelSetList::LARAVEL_70,

        // Laravel 7.0 -> 8.0 upgrade
        LaravelSetList::LARAVEL_80,

        // Laravel code quality improvements
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
    ])
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
