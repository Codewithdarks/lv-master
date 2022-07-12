<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>@yield('page-title') | {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ url('images/fav.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    @yield('custom-css')
</head>

<body>

<div class="main-wrapper d-flex flex-column h-100">

    <!-- start header -->
    @include('layouts.panel.includes.header')
    <!-- end header -->


    <main>
        <div class="container">
            <div class="row justify-content-center" id="SuccessBox" style="display: none;">
                <div class="col-4"><div class="alert alert-success">Payment setting save Sucessfully.</div></div>
            </div>
            <div class="row justify-content-center" id="ErrorBox" style="display: none;">
                <div class="col-4"><div class="alert alert-danger">Something Went Wrong!</div></div>
            </div>
            @if(Session::has('success'))
                <div class="row justify-content-center nofify-box">
                    <div class="col-4"><div class="alert alert-success">{{ Session::get('success') }}</div></div>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="row justify-content-center nofify-box">
                    <div class="col-4"><div class="alert alert-success">{{ Session::get('error') }}</div></div>
                </div>
            @endif
        </div>
        @yield('content')
    </main>
    <!-- end main -->

    <!-- start footer -->
    @include('layouts.panel.includes.footer')
    <!-- end footer -->
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function() {
            $(".nofify-box").hide()
        }, 3000);
    });
</script>
@yield('custom-js')

</body>

</html>
