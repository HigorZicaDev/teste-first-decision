<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teste First Decision</title>
    {{-- FAVICON --}}
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-ico">
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bundle vite javascript + tailwind v4 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased">
    
    <main class="w-full flex justify-center items-center">
        <div class=" w-full">
            @yield('content')
        </div>
    </main>

    {{-- @include('components._site.footer') --}}


    <script src="https://cdn.jsdelivr.net/npm/starting-point-ui@0.24.1" type="module"></script>

</body>
</html>