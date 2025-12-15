<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \Illuminate\Support\Facades\Cookie::get('app_theme', $defaultTheme) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="turbo-cache-control" content="no-preview">
        <title>{{ $title ?? 'Simple Blog' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
