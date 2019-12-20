
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="api-base-url" content="{{ url('/') }}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ isset(Auth::user()->id)?json_encode(Auth::user()):'null' }}">
    <meta name="user-id" content="{{ isset(Auth::user()->id)?Auth::user()->id:'null' }}">
    <title>{{$general_setting['website_name']}}</title>


</head>

<body class="theme-red">
<!-- Page Loader -->
<section id="app">

@yield('head')
<!-- #Top Bar -->
    <section class="content">
        <div class="container-fluid" style="padding: 0;">
            <update-runner></update-runner>
        </div>
    </section>

</section>

</body>
<!-- Jquery Core Js -->
<script src="{{asset('user/plugins/jquery/jquery.min.js')}}"></script>

<script src="{{ asset('js/app.js') }}"></script>
</html>



