<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>{{ config('app.name') }}</title>
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> @livewireStyles

    @livewireStyles
</head>
<body class="bg-gray-50 antialiased">
    {{ $slot }}

    @livewireScripts
</body>
</html>
