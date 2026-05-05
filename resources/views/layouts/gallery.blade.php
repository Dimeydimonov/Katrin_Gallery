<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'KatArts — Галерея Катерини Перепелиці' }}</title>
    <meta name="description" content="Художня галерея Катерини Перепелиці — живопис, портрети, резин арт. Одеса, Україна.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Raleway:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}?v={{ filemtime(public_path('css/gallery.css')) }}">
    @stack('styles')
</head>
<body class="gallery-layout">

    {{-- Custom cursor --}}
    <div class="cursor-dot"></div>
    <div class="cursor-ring"></div>

    {{-- Gold decorative background overlay --}}
    <div class="gold-bg-overlay" aria-hidden="true"></div>

    @include('components.header')

    <main>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')

    <script src="{{ asset('js/gallery.js') }}?v={{ filemtime(public_path('js/gallery.js')) }}"></script>

@stack('scripts')
</body>
</html>
