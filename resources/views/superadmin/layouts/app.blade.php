{{-- resources/views/superadmin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    @include('superadmin.layouts.head')
</head>
<body>
    <div class="container-scroller">
        @include('superadmin.layouts.banner')
        @include('superadmin.layouts.nav')
        <div class="container-fluid page-body-wrapper">
            @include('superadmin.layouts.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('konten')
                </div>
                @include('superadmin.layouts.footer')
            </div>
        </div>
    </div>
    @include('superadmin.layouts.scripts')
    @yield('scripts')
</body>
</html>
