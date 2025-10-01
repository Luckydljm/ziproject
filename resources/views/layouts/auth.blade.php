<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.header')
</head>

<body>
    @yield('content')

    @yield('scripts')
    <!-- Libs JS -->
    @include('components.footer')

</body>

</html>
