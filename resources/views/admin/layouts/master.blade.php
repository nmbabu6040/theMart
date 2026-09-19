<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.head')

<body>
    <div class="main-wrapper">

        @include('admin.layouts.sidebar')

        <div class="page-wrapper">

            @include('admin.layouts.header')

            @yield('content')

            @include('admin.layouts.footer')

        </div>
    </div>

    @include('admin.layouts.scripts')
</body>

</html>
