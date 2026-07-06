<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/admin/app.js'])
    </head>
    <body class="antialiased bg-background text-text">
        <div id="app"></div>
    </body>
</html>
