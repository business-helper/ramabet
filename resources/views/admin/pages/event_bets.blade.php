@extends('admin.Layout.pagetemplate')
@section('head')
    <!-- x-editor CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('admin/css/editor/select2.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/editor/datetimepicker.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/editor/bootstrap-editable.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/editor/x-editor-style.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('admin/css/data-table/bootstrap-table.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/data-table/bootstrap-editable.css')}}">
    <style>

    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-pro">
                    <a href="index.html"><img class="main-logo" src="{{asset('admin/img/logo/logo.png')}}" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    @include('admin.Layout.header')
    <!-- Static Table Start -->
    <div class="data-table-area mg-b-15">
        <div class="single-pro-review-area mt-t-30 mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-payment-inner-st">
                            {{--<ul id="" class="tab-review-design">
                                <li class="{{$sport==1?'active':''}}"><a href="{{url('admin/pre_event/1')}}">Soccer</a></li>
                                <li class="{{$sport==3?'active':''}}"><a href="{{url('admin/pre_event/3')}}">Cricket</a></li>
                                <li class="{{$sport==13?'active':''}}"><a href="{{url('admin/pre_event/13')}}">Tennis</a></li>
                            </ul>--}}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="sparkline13-list">
                                        <div class="sparkline13-hd">
                                            <div class="main-sparkline13-hd">
                                                <h1>Betting<span class="table-project-n">Data</span> Table</h1>
                                            </div>
                                        </div>
                                        <div class="sparkline13-graph">
                                            <div class="datatable-dashv1-list custom-datatable-overright">
                                                <div id="toolbar">
                                                    <select class="form-control dt-tb">
                                                        <option value="">Export Basic</option>
                                                        <option value="all">Export All</option>
                                                        <option value="selected">Export Selected</option>
                                                    </select>
                                                </div>
                                                <table id="table1" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                    <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="eventid">EventId</th>
                                                        <th data-field="userid">UserId</th>
                                                        <th data-field="date" data-editable="">Bet Time</th>
                                                        <th data-field="odd" data-editable="">odd</th>
                                                        <th data-field="stake" data-editable="">stake</th>
                                                        <th data-field="market" data-editable="">Market</th>
                                                        <th data-field="Team" data-editable="">Team</th>
                                                        <th data-field="bettype" data-editable="">Bet type</th>
                                                        <th data-field="Runner Name">Runner Name</th>
                                                        <th data-field="Remarks">Remarks</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                {{$item->eventId}}
                                                            </td>
                                                            <td>
                                                                {{$item->user_id}}
                                                            </td>
                                                            <td>
                                                                {{$item->bet_date}}
                                                            </td>
                                                            <td>
                                                                {{$item->odd}}
                                                            </td>
                                                            <td>
                                                                {{$item->stake}}
                                                            </td>
                                                            <td>
                                                                {{$item->market_type}}
                                                            </td>
                                                            <td>
                                                                {{$item->teams}}
                                                            </td>
                                                            <td>
                                                                {{$item->bet_type}}
                                                            </td>
                                                            <td>
                                                                {{$item->runnerName}}
                                                            </td>
                                                            <td>
                                                                {{$item->remarks}}
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

        </div>
    </div>
    <!-- Static Table End -->
    @include('admin.Layout.footer')
@stop
@section('script')
    <!-- data table JS
		============================================ -->
    <script src="{{asset('admin/js/data-table/bootstrap-table.js')}}"></script>
    <script src="{{asset('admin/js/data-table/tableExport.js')}}"></script>
    <script src="{{asset('admin/js/data-table/data-table-active.js')}}"></script>
    <script src="{{asset('admin/js/data-table/bootstrap-table-editable.js')}}"></script>
    <script src="{{asset('admin/js/data-table/bootstrap-editable.js')}}"></script>
    <script src="{{asset('admin/js/data-table/bootstrap-table-resizable.js')}}"></script>
    <script src="{{asset('admin/js/data-table/colResizable-1.5.source.js')}}"></script>
    <script src="{{asset('admin/js/data-table/bootstrap-table-export.js')}}"></script>
    <!--  editable JS
		============================================ -->
    <script src="{{asset('admin/js/editable/jquery.mockjax.js')}}"></script>
    <script src="{{asset('admin/js/editable/mock-active.js')}}"></script>
    <script src="{{asset('admin/js/editable/select2.js')}}"></script>
    <script src="{{asset('admin/js/editable/moment.min.js')}}"></script>
    <script src="{{asset('admin/js/editable/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('admin/js/editable/bootstrap-editable.js')}}"></script>
    <script src="{{asset('admin/js/editable/xediable-active.js')}}"></script>
    <!-- Chart JS
		============================================ -->
    <script src="{{asset('admin/js/chart/jquery.peity.min.js')}}"></script>
    <script src="{{asset('admin/js/peity/peity-active.js')}}"></script>
    <!-- tab JS
		============================================ -->
    <script src="{{asset('admin/js/tab.js')}}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            console.log('ready');
            $('#pre_event').addClass('active');
            $('.breadcome-menu').html('');
            $('.breadcome-menu').append('' +
                '<li>' +
                '<a href="">Home</a>' +
                '<span class="bread-slash">/</span>' +
                '</li>' +
                '<li>' +
                '<span class="bread-blod">Live Event</span>\n' +
                '</li>');
        });

    </script>
@stop

