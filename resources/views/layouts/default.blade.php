<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("layouts.header")
    <body>
        <div id="app">
            @yield('content')
        </div>
        <script>

        </script>
        @include('layouts.scripts')
    </body>
</html>
