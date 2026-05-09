<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction ?? 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Baxin Store')</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Bagisto Default CSS + JS (Vue app, components, product grid) -->
    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'shop')

    <!-- Baxin Modern Custom CSS -->
    <link rel="stylesheet" href="https://baxin.store/themes/baxin-modern/assets/css/app.css">

    @stack('styles')
</head>
<body>

<div id="app">
    @include('baxin-modern::layouts.header')

    <main class="min-h-screen">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        @yield('content')

        {!! view_render_event('bagisto.shop.layout.body.after') !!}
    </main>

    @include('baxin-modern::layouts.footer')
</div>

    @stack('scripts')
</body>
</html>
