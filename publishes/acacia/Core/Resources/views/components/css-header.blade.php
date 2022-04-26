{{--<link rel="stylesheet" href="{{ asset('vendor/acacia/assets/main.ca397e4a.css') }}">--}}
<?php
    function getAcaciaCss() {
        $prefix = 'vendor/acacia/';
        if (!file_exists(public_path("{$prefix}manifest.json"))) return '#';
        $manifest = json_decode(file_get_contents(public_path("{$prefix}manifest.json")),true);
        $css = collect($manifest['Core/Js/main.ts'])->get('css')[0];
        return $prefix.$css;
    }
?>
<link rel="stylesheet" href="{{ asset(getAcaciaCss()) }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

