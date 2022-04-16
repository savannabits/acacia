<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'route_prefix' => env('ACACIA_ROUTE_PREFIX','admin'),
    'sidebar' => [
        'heading' => env("ACACIA_SIDEBAR_HEADING","Acacia Backend"),
    ],
    "seeder" => [
        "seed_menu" => env('ACACIA_SEED_MENU',true),
    ],
    'dev_modules' => explode(",", env('ACACIA_DEV_MODULES','AcaciaFields,AcaciaSchematics,AcaciaRelationships')),
    'special_modules' => explode(",", env('ACACIA_SPECIAL_MODULES','Core')),
    'finished_modules' => explode(",", env('ACACIA_FINISHED_MODULES','')),
];
