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
        .dropdown {
            position: inherit;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 5px 5px;
            z-index: 10;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content div:hover{
            background-color: #b9bbbe;
        }
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Projects <span class="table-project-n">Data</span> Table</h1>
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id">ID</th>
                                        <th data-field="name" data-editable="">User Name</th>
                                        <th data-field="email" data-editable="">Amount</th>
                                        <th data-field="getway" data-editable="">Method</th>
                                        {{--<th data-field="complete">Create_date</th>--}}
                                        <th data-field="date" data-editable="">Date</th>
                                        <th data-field="before" data-editable="">Before</th>
                                        <th data-field="after" data-editable="">After</th>
                                        {{--<th data-field="price" data-editable="true">Price</th>--}}
                                        <th data-field="action">Pay</th>
                                        <th data-field="action1">Remark</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @for($i=0;$i<count($data);$i++)
                                        <tr>
                                            <td></td>
                                            <td>{{$data[$i]->no}}</td>
                                            <td>{{$data[$i]->name}}</td>
                                            <td>{{$data[$i]->amount}}</td>
                                            <td>{{$data[$i]->getway}}</td>
                                            {{--<td class="datatable-ct"><span class="pie">1/6</span>--}}
                                            <td>{{$data[$i]->date}}</td>
                                            <td>{{$data[$i]->before_amount}}</td>
                                            <td>{{$data[$i]->after_amount}}</td>
                                            <td class="datatable-ct">
                                                <a href="https://www.paypal.com" target="_blank">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                {{--<a href="{{ url('payout') }}"--}}
                                                   {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('pay_form').submit();">--}}
                                                    {{--<i class="fa fa-check"></i>--}}
                                                {{--</a>--}}
                                                {{--<form id="pay_form" action="{{ url('payout') }}" method="POST" style="display: none;">--}}
                                                    {{--{{ csrf_field() }}--}}
                                                    {{--<input type="text" name="id" value="{{$data[$i]->no}}"/>--}}
                                                {{--</form>--}}
                                            </td>
                                            <td class="datatable-ct">
                                                <div class="dropdown">
                                                    <span style="width: 100%;height: 100%">{{$data[$i]->remark}}</span>
                                                    <div class="dropdown-content">
                                                        <div><a href="{{url('admin/withdraw_process/'.$data[$i]->no.'/non process')}}">non process</a></div>
                                                        <div><a href="{{url('admin/withdraw_process/'.$data[$i]->no.'/success')}}">success</a></div>
                                                        <div><a href="{{url('admin/withdraw_process/'.$data[$i]->no.'/cancel')}}">cancel</a></div>
                                                        <div><a href="{{url('admin/withdraw_process/'.$data[$i]->no.'/delete')}}">delete</a></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            $('#payment_history').addClass('active');
            $('#payment_history .has-arrow').attr('aria-expanded','true');
            $('#request_withdraw').addClass('active1');
            $('#payment_history ul').addClass('show');
            $('.breadcome-menu').html('');
            $('.breadcome-menu').append('' +
                '<li>' +
                '<a href="">Home</a>' +
                '<span class="bread-slash">/</span>' +
                '</li>' +
                '<li>' +
                '<span class="bread-blod">Payment Situation</span>\n' +
                '</li>');
        });

    </script>
@stop
