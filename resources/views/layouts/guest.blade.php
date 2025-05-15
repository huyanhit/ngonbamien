<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Administrator') }}</title>
        @vite(['resources/css/admin.css'])
    </head>
    <body>
        {{ $slot }}
    </body>
    <script src="{{Request::root()}}/js/jquery.min.js" ></script>
    <script>
        $('#password-addon').click(function () {

            let pass = $(this).parent().find('.password-input');
            let icon = $(this).parent().find('.password-addon');
            let type = pass.attr('type');
            (type === 'password')? pass.attr('type', 'text'): pass.attr('type', 'password');
            (type === 'password')? icon.html('<i class="ri-eye-fill"></i>'): '<i class="ri-eye-close-fill"></i>';
        })
    </script>
</html>

