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
    'dev_modules' => explode(",", env('DEV_MODULES','AcaciaFields,AcaciaSchematics,AcaciaRelationships'))
];
