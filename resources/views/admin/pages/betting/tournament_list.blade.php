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
                        {{--<div style="float: right" class="btn btn-default add_sports">Add Sport</div>--}}
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Tournament List</h1>
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
                                        <th data-field="league">Tournament</th>
                                        <th data-field="name">Name</th>
                                        <th data-field="action">is Active</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0;$i<count($league_list);$i++)
                                        @php
                                            $item=$league_list[$i];
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>{{$i}}</td>
                                            <td>{{json_decode($item->league,true)['name']}}</td>
                                            <td>{{$item->name}}</td>
                                            {{--<td class="datatable-ct">
                                                --}}{{--<button onclick="EditSport({{json_encode($item)}})" data-toggle="tooltip" title="" class="pd-setting-ed sports_edit" data-original-title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>--}}{{--
                                                <button onclick="DelSport({{json_encode($item)}})" data-toggle="tooltip" title="" class="pd-setting-ed sports_edit" data-original-title="Edit"><i class="fas fa-trash-alt"></i></button>
                                            </td>--}}
                                            <td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,{{$item->id}});" {{$item->is_active=='true'?'checked':''}}></label>
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
    <div id="PrimaryModalhdbgcl" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title text-center"></h4>
                    <span id="sports_edit_type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group-inner">
                        <label>Sport Id</label>
                        <input id="sports_id" type="text" class="form-control" placeholder="Enter Sport Id" />
                    </div>
                    <div class="form-group-inner">
                        <label>Sport Name</label>
                        <input id="sports_name" type="text" class="form-control" placeholder="Enter Sport Name" />
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal" href="#">Cancel</a>
                    <button class="btn btn-default" id="change_odd">Submit</button>
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
            $('#tournament_list').addClass('active1');
            $('#betting').addClass('active');
            $('#betting .has-arrow').attr('aria-expanded','true');
            $('#betting ul').addClass('show');
            $('.breadcome-menu').html('');
            $('.breadcome-menu').append('' +
                '<li>' +
                '<a href="">Home</a>' +
                '<span class="bread-slash">/</span>' +
                '</li>' +
                '<li>' +
                '<span class="bread-blod">Betting</span>\n' +
                '</li>');
        });

    </script>
    <script>
        $('.add_sports').click(function () {
            $('#PrimaryModalhdbgcl #sports_edit_type').text('add');
            $('#PrimaryModalhdbgcl #change_odd').text('Submit');
            $('#PrimaryModalhdbgcl').modal();
        });
        function handleClick(cb,id) {
            //console.log("Clicked, new value = " +eventid+ cb.checked);
            $.ajax({
                url: 'https://odds24ex.com/api/check_set',
                type: 'post',
                data: { id:id,value:cb.checked,field:'is_active',table_name:'league_list'} ,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response){
                    //console.log(response);
                    var obj = JSON.parse(response);
                    console.log(obj);
                },
                error: function(response){
                    console.log(response);
                    //alert('error');
                }
            });
        }
    </script>
@stop
