<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.header')
</head>

<body>
    <div class="main-wrapper">

        @include('components.sidebar')

        <div class="page-wrapper">
            @yield('content')
            <footer>
                <p>Copyright © {{ date('Y') }} M-ESSENCE. All Rights Reserved.</p>
            </footer>
        </div>
    </div>

    @yield('scripts')
    <!-- Libs JS -->
    @include('components.footer')

</body>

</html>
