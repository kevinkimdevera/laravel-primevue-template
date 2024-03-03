<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name') }}</title>

    {{-- Compiled Assets --}}
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
  </head>
  <body>
    <div id="app">

    </div>
  </body>
</html>
