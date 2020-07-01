<?php
/**
 * @var \App\Markov\Dictionary[] $dictionaries
 * @var \App\Markov\Generator $generator
 * @var string $title
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">

{{--    @dump($generator)--}}

    <ul class="flex p-3">
        @foreach($dictionaries as $dictionary)
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="{{ route('index', $dictionary->slug()) }}">
                    {{ $dictionary->title() }}
                </a>
            </li>
        @endforeach
    </ul>

    <hr>

    <main class="text-center">
        <h1 class="text-3xl my-4">
            {{ $title }}
        </h1>

        @foreach(range(1, 25) as $index)
            <div class="text-lg mb-2">
                {{ $generator->generate() }}
            </div>
        @endforeach
    </main>

</body>
</html>
