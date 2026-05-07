//Biar navbar/footer ga copy-paste.
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>
<body>

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

</body>
</html>