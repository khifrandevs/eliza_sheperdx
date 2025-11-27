{{-- resources/views/superadmin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    @include('departemen.layouts.head')
</head>
<body>
    <div class="container-scroller">
        @include('departemen.layouts.banner')
        @include('departemen.layouts.nav')
        <div class="container-fluid page-body-wrapper">
            @include('departemen.layouts.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('konten')
                </div>
                @include('departemen.layouts.footer')
            </div>
        </div>
    </div>
    @include('departemen.layouts.scripts')
    @yield('scripts')
</body>
</html>
