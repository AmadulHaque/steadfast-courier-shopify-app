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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100">

        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-2 text-center text-2xl leading-9">{{ config('app.name', 'Laravel') }}</h1>
        </div>

        <div class="mt-4 w-full sm:max-w-md  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="get" action="{{ route('authenticate') }}">
                @csrf
                <div>
                    <label for="shop" class="block text-sm font-medium leading-6 text-gray-900">Shop URL</label>
                    <div class="mt-2">
                        <input type="text" name="shop" id="shop"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="yoursite url" aria-describedby="shop-description">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
