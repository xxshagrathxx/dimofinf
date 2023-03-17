<!DOCTYPE html>
<html lang="en">
    <title>@yield('title')</title>
    @include('includes.header')
<body>
    @yield('styles')
    @yield('scripts_top')
    <div class="container-scroller">
        @include('includes.topnav')

        <div class="container-fluid page-body-wrapper">
            @include('includes.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                
                @include('includes.footer')
            </div>
        </div>
    </div>
    @yield('scripts_bot')
    @include('includes.footer_scripts')
</body>

</html>

