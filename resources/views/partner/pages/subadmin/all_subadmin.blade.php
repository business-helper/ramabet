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
                                        <th data-field="name" data-editable="">Name</th>
                                        <th data-field="email" data-editable="">Email</th>
                                        <th data-field="phone" data-editable="">Phone</th>
                                        {{--<th data-field="complete">Create_date</th>--}}
                                        <th data-field="date" data-editable="">Date</th>
                                        {{--<th data-field="task" data-editable="">Wallet</th>--}}
                                        <th data-field="action1" data-editable="">state</th>
                                        {{--<th data-field="price" data-editable="true">Price</th>--}}
                                        <th data-field="action">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0;$i<count($subadmin);$i++)
                                    <tr>
                                        <td></td>
                                        <td>{{$subadmin[$i]->id}}</td>
                                        <td>{{$subadmin[$i]->name}}</td>
                                        <td>{{$subadmin[$i]->email}}</td>
                                        <td>+8801962067309</td>
                                        {{--<td class="datatable-ct"><span class="pie">1/6</span>--}}
                                        <td>{{$subadmin[$i]->created_at}}</td>
                                        </td>
                                        {{--<td>{{$subadmin[$i]->wallet}}</td>--}}
                                        {{--<td>$5455</td>--}}
                                        <td class="datatable-ct">
                                            <div class="dropdown">
                                                <span style="width: 100%;height: 100%">{{$subadmin[$i]->state}}</span>
                                                <div class="dropdown-content">
                                                    <div><a href="{{url('admin/admin_state/'.$subadmin[$i]->id.'/normal')}}">normal</a></div>
                                                    <div><a href="{{url('admin/admin_state/'.$subadmin[$i]->id.'/block')}}">block</a></div>
                                                    <div><a href="{{url('admin/admin_state/'.$subadmin[$i]->id.'/delete')}}">delete</a></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="datatable-ct"><a href="{{url('admin/edit_subadmin/'.$subadmin[$i]->id)}}" title="Edit"><i class="fa fa-check"></i></a>
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
            $('#all_subadmin').addClass('active1');
            $('#subadmin').addClass('active');
            $('#subadmin .has-arrow').attr('aria-expanded','true');
            $('#subadmin ul').addClass('show');
            $('.breadcome-menu').html('');
            $('.breadcome-menu').append('' +
                '<li>' +
                '<a href="">Home</a>' +
                '<span class="bread-slash">/</span>' +
                '</li>' +
                '<li>' +
                '<span class="bread-blod">All SubAdmin</span>\n' +
                '</li>');
        });

    </script>
@stop
