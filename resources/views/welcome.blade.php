<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Styles -->
    </head>
    <body>
        <div class="container" id="app">
            <div class="row">
                <div class="col-md-12">
                    <h1>Blog Posts</h1>
                    <blog></blog>
                </div>
            </div>
        </div>
    </body>
</html>
