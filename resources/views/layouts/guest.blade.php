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
            background-color: #1d4ed8 !important;
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
    </style>
</head>

<body class="font-sans text-gray-900 antialiased ">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 ">
        {{-- <div>
            <a href="/">
                 <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> 
            </a>
        </div> --}}
        <div class="w-96 bg-blue-500 shadow-lg rounded-2xl box-shadow-form  p-8 relative">
            <div class="w-24 h-24 bg-blue-700 rounded-full mx-auto -mt-16 flex items-center justify-center button-3d">
                <svg class="w-16 h-16 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 12c2.76 0 5-2.24 5-5S14.76 2 12 2 7 4.24 7 7s2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z" />
                </svg>
                {{-- <span class="text-1xl font-bold text-white">Troyca</span> --}}
            </div>

            <div class="rounded-lg relative  mb-10 ">
                {{ $slot }}
            </div>
        </div>

    </div>
</body>

</html>
