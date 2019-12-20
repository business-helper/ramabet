<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="api-base-url" content="{{ url('/') }}" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="user-id" content="{{ isset(Auth::user()->id)?Auth::user()->id:'null' }}">
<meta name="is_super" content="{{ isset(Auth::user()->is_super)?Auth::user()->is_super:'null' }}">
<meta name="user" content="{{ isset(Auth::user()->id)?json_encode(Auth::user()):'null' }}">
<title>{{$general_setting['website_name']}}</title>
<!-- Favicon-->
<link rel="icon" href="{{asset('user/favicon.ico')}}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- Bootstrap Core Css -->
<link href="{{asset('user/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Waves Effect Css -->
<link href="{{asset('user/plugins/node-waves/waves.min.css')}}" rel="stylesheet" />

<!-- Animation Css -->
<link href="{{asset('user/plugins/animate-css/animate.min.css')}}" rel="stylesheet" />

<!-- Morris Chart Css-->
<link href="{{asset('user/plugins/morrisjs/morris.min.css')}}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
{{--<link href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />--}}

<!-- Bootstrap DatePicker Css -->
{{--<link href="{{asset('user/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />--}}

<!-- Wait Me Css -->
{{--<link href="{{asset('user/plugins/waitme/waitMe.css')}}" rel="stylesheet" />--}}

<!-- Bootstrap Select Css -->
<link href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" />
<!-- Custom Css -->
<link href="{{asset('user/css/style.css')}}?v=1" rel="stylesheet">

<!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
<link href="{{asset('user/css/themes/all-themes.css')}}" rel="stylesheet" />
<!-- JQuery DataTable Css -->
<link href="{{asset('user/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<!-- Scripts -->
<script>

    window.Laravel = '{!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!}';
</script>


@if(isset($current_sport))
    <style>
        .list-group a{
            height: 30px!important;
            padding-top: 5px;
        }
        .list-group a img{
            height: 15px;
            width: 15px;
        }
        .current_sports{
            background-color: {{$current_sport->color}};
            color: #fff!important;
        }
        .current_sports:hover{
            background-color: {{$current_sport->color}}!important;
            color: white!important;
        }

    </style>

@endif