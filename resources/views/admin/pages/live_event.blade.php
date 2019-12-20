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
        <h2>Live Events</h2>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Live Events
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="add_master">Add Master</a></li>
                                {{--<li><a href="javascript:void(0);">Another action</a></li>--}}
                                {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                    <ul id="tab-review-design" class="tab-review-design">
                        @foreach($sport_names as $item)
                            <li class="btn btn-default {{$sport==$item->import_id?'active':''}}" style="margin-top: 10px;">
                                <a style="color: black;" href="{{url('admin/pre_event/'.$item->import_id)}}">{{$item->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>Event_id</th>
                                <th>StartDate</th>
                                <th>Team</th>
                                <th>Score</th>
                                <th>Bet</th>
                                <th>Stake</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{$total_bet_count}}</th>
                                <th>{{$total_stake}}</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>
                                        {{$item->id}}
                                    </td>
                                    <td>
                                        {{$item->time}}
                                    </td>
                                    <td>
                                        {{$item->name}}
                                    </td>
                                    <td>
                                        {{$item->ss}}
                                    </td>
                                    <td>
                                        {{$item->bet_count}}
                                    </td>
                                    <td>
                                        {{$item->stake}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->

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
            $('#event_menu a').addClass('toggled');
            $('#event_menu ul').css('display','block');
        });
    </script>
@stop

