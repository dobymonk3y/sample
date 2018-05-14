<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','Sample')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <div class="container">
        @include('shared._messages')
        @yield('content')
        @include('layouts.footer')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>