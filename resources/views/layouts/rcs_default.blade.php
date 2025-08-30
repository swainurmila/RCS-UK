@if (request()->routeIs('login.view') || request()->routeIs('registration') || request()->routeIs('forgot.password'))
    @include('includes.head')
    @yield('content')
    @yield('js')

    </div>
    </body>

    </html>
@else
    @include('includes.header')
    @include('includes.sidebar')
    @yield('content')

    @include('includes.footer')
    @yield('js')
    </body>

    </html>
@endif
