<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        .button-3d:active {
            box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.4), inset -8px -8px 16px rgba(255, 255, 255, 0.1);
        }

        .circle-3d {
            box-shadow: 12px 12px 24px rgba(143, 141, 141, 0.4), -12px -12px 24px rgba(255, 255, 255, 0.1);
        }

        .bg-blue-600 {
            background-color: #FDB758 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .box-shadow-form {
            box-shadow:
                inset -3px -3px 3px rgba(201, 201, 201, 0.6),
                /* Sombra interna blanca hacia el lado contrario */
                -4px -4px 6px rgba(190, 190, 190, 0.4),
                /* Sombra externa negra hacia el lado contrario */
                4px 4px 6px rgba(163, 163, 163, 0.2);
            /* Sombra externa adicional negra hacia el lado contrario */
        }

        .input-3d,
        .button-3d {
            box-shadow:
                inset 1px 1px 3px rgba(255, 255, 255, 0.6),
                1px 3px 3px rgba(0, 0, 0, 0.4),
                -4px -4px 10px rgba(105, 105, 105, 0.2);
        }

        .fondo-login {
            background-image: url('images/fondo-login.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: left;
            height: 100vh;
            width: 100%;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased fondo-login  ">
    <div class=" min-h-screen  mx-auto flex flex-col sm:justify-center items-stretch  pt-6 sm:pt-0 justify-evenly ">
        {{-- <div>
            <a href="/">
                 <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> 
            </a>
        </div> --}}
        <div class="w-96 bg-blue-500 shadow-lg rounded-2xl box-shadow-form  p-8 relative  ml-28"
            style="background-color: #ADADF7;">
            <div class="w-24 h-24 bg-blue-700 rounded-full mx-auto -mt-16 flex items-center justify-center button-3d"
                style="background-color: #ADADF7;">
                <img src="{{ asset('images/logo.png') }}" class="" alt="Logo">
            </div>

            <div class="rounded-lg relative  mb-10  ">
                {{ $slot }}
            </div>
        </div>

    </div>
</body>

</html>
