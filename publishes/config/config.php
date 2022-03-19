<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'route_prefix' => env('ACACIA_ROUTE_PREFIX','admin'),
    'sidebar' => [
        'heading' => env("ACACIA_SIDEBAR_HEADING","Acacia Backend"),
    ],
    'dev_modules' => explode(",", env('DEV_MODULES','AcaciaFields,AcaciaSchematics,AcaciaRelationships'))
];
