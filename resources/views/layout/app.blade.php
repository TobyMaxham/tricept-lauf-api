<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <link type="text/css" rel="stylesheet" href="https://cdn.elnu.de/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

@include('layout.navbar')

@yield('main')

@include('layout.footer')

<script src="https://cdn.elnu.de/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.elnu.de/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.elnu.de/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>
