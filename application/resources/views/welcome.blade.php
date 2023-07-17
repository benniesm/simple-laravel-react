<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @viteReactRefresh
        @vite('resources/js/react-app.jsx')
    </head>
    <body style="margin:0;padding:0;">
        <div id="app"></div>
    </body>
</html>
