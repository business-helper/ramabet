@extends('admin.Layout.pagetemplate')
@section('head')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('user/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <style>
        #tab-review-design .active{
            background-color: rgba(213, 213, 213, 0.53) !important;
        }
    </style>
@stop
@section('content')
    <div class="block-header">
        <h2>Sports</h2>
    </div>
    <!-- Basic Examples -->
    <sport_names></sport_names>


@stop
@section('script')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('user/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>
    <script>
        $( document ).ready(function() {
            console.log('ready');
            $('#betting_menu a').addClass('toggled');
            $('#betting_menu ul').css('display','block');
        });
    </script>
@stop
