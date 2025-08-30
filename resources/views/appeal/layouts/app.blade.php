<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.header')

<body style="display: none;" onload="document.body.style.display = 'block'">
    @include('layouts.topbar')
    @include('appeal.layouts.sidebar')
    <main class="main-content" class="page-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

    </main>
    @include('layouts.footer')
    @include('layouts.script')
</body>

</body>

</html>
