<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'route_prefix' => env('ACACIA_ROUTE_PREFIX','admin'),
    'sidebar' => [
        'heading' => env("ACACIA_SIDEBAR_HEADING","Acacia Backend"),
    ]
];