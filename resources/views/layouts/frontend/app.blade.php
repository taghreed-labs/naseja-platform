<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NASEJA')</title>
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @endif

    {{-- CSS الرئيسي للموقع --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>

<body>
    {{-- محتوى الصفحة --}}
    @yield('content')

    {{-- JavaScript --}}
    @yield('scripts')
</body>

</html>
