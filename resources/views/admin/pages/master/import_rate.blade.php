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
                        {{--<div style="float: right" class="btn btn-default add_sports">Add</div>--}}
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Import Rate</h1>
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
                                        <th data-field="market_type">Market Type</th>
                                        <th data-field="market_info">MarketInfo</th>
                                        <th data-field="market_rate">MarketRate</th>
                                        <th data-field="status">Status</th>
                                        <th data-field="setting">Stetting</th>
                                        <th data-field="bet">bet</th>
                                        <th data-field="comm">Comm</th>
                                        <th data-field="limits">Limits</th>
                                        <th data-field="active">Active</th>
                                        <th data-field="bets">Bets</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0;$i<count($import_rate);$i++)
                                        @php
                                            $item=$import_rate[$i];
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->market_type}}</td>
                                            <td>{{$item->market_info}}</td>
                                            <td>
                                                <div class="market_rate_input" style="display:flex;">
                                                    <input id="market_rate" name="market_rate" type="number" placeholder="market_rate" class="form-control input-md" value="{{$item->market_rate}}">
                                                    <button  onclick="Update($(this),{{json_encode($item)}})" data-toggle="tooltip" title="" class="update pd-setting-ed sports_edit" data-original-title="Edit">
                                                        U
                                                    </button>
                                                </div>

                                            </td>
                                            <td>{{$item->status}}</td>
                                            <td>
                                                <button onclick="Setting({{json_encode($item)}})" data-toggle="tooltip" title="" class="pd-setting-ed sports_edit" data-original-title="Edit">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                            </td>
                                            {{--<td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,{{$item->id}});" {{$item->is_active=='true'?'checked':''}}></label>
                                            </td>--}}
                                            <td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,'is_bet',{{$item->id}});" {{$item->is_bet=='true'?'checked':''}}></label>
                                            </td>
                                            <td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,'is_comm',{{$item->id}});" {{$item->is_comm=='true'?'checked':''}}></label>
                                            </td>
                                            <td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,'is_limit',{{$item->id}});" {{$item->is_limit=='true'?'checked':''}}></label>
                                            </td>
                                            <td style="text-align: center">
                                                <label><input type='checkbox' onclick="handleClick(this,'is_active',{{$item->id}});" {{$item->is_active=='true'?'checked':''}}></label>
                                            </td>
                                            <td>
                                                <button onclick="BetView({{json_encode($item)}})" data-toggle="tooltip" title="" class="pd-setting-ed sports_edit" data-original-title="Edit">
                                                    V
                                                </button>
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
                    <span id="type" style="display: none"></span>
                    <div class="modal-close-area modal-close-df">
                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group-inner">
                        {{--<label>Sport Id</label>--}}
                        <input id="id" type="hidden" class="form-control" placeholder="Enter Sport Id" />
                    </div>
                    <div class="form-group-inner">
                        <label>Sport</label>
                        <input id="sport" type="text" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Commentary</label>
                        <input id="commentary" type="text" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Show Text</label>
                        <input id="show_text" type="text" class="form-control" placeholder="" />
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
            $('#import_rate').addClass('active1');
            $('#master').addClass('active');
            $('#master .has-arrow').attr('aria-expanded','true');
            $('#master ul').addClass('show');
            $('.breadcome-menu').html('');
            $('.breadcome-menu').append('' +
                '<li>' +
                '<a href="">Home</a>' +
                '<span class="bread-slash">/</span>' +
                '</li>' +
                '<li>' +
                '<span class="bread-blod">Master</span>\n' +
                '</li>');
        });

    </script>
    <script>
        $('.add_sports').click(function () {
            $('#PrimaryModalhdbgcl #type').text('insert');
            $('#PrimaryModalhdbgcl #change_odd').text('Submit');
            $('#PrimaryModalhdbgcl').modal();
        });
        function EditSport(sports) {
            console.log(sports.id);
            $('#PrimaryModalhdbgcl #id').val(sports.id);
            $('#PrimaryModalhdbgcl #sport').val(sports.sport);
            $('#PrimaryModalhdbgcl #commentary').val(sports.commentary);
            $('#PrimaryModalhdbgcl #show_text').val(sports.show_text);

            $('#PrimaryModalhdbgcl #type').text('update');
            $('#PrimaryModalhdbgcl #change_odd').text('Save');
            $('#PrimaryModalhdbgcl').modal();
        }
        function Update(button,item){
            //console.log(typeof button);
            var send_data={};
            send_data.type= 'update';
            send_data.table_name= 'import_rate';
            send_data.data={
                //'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                'market_rate':button.parent('.market_rate_input').find('input').val(),
            };
            send_data.condition=[];
            send_data.condition.push(['id',item.id]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('https://odds24ex.com/api/table_edit',send_data,false);
        }
        function BetView(item){
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=1000,height=600,left=100,top=100`;

            open("{{url('/admin/master/bets/')}}"+"/"+item.id, 'test', params);

        }
        function Setting(item){
            window.open("{{url('/admin/general_setting')}}");
        }
        $('#change_odd').click(function () {
            $('#PrimaryModalhdbgcl').modal('toggle');
            var send_data={};
            send_data.type= $('#PrimaryModalhdbgcl #type').text();
            send_data.table_name= 'commentary';
            //send_data.data=[];
            send_data.data={
                //'id':$('#PrimaryModalhdbgcl #sports_id').val(),
                'sport':$('#PrimaryModalhdbgcl #sport').val(),
                'commentary':$('#PrimaryModalhdbgcl #commentary').val(),
                'show_text':$('#PrimaryModalhdbgcl #show_text').val(),
            };
            // send_data.data.push({"field":'id',"value":$('#PrimaryModalhdbgcl #sports_id').val()});
            // send_data.data.push({"field":'title',"value":$('#PrimaryModalhdbgcl #sports_name').val()});
            send_data.condition=[];
            send_data.condition.push(['id',$('#PrimaryModalhdbgcl #id').val()]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('https://odds24ex.com/api/table_edit',send_data,true);
        });
        function handleClick(cb,field,id) {
            //console.log("Clicked, new value = " +eventid+ cb.checked);
            $.ajax({
                url: 'https://odds24ex.com/api/check_set',
                type: 'post',
                data: { id:id,value:cb.checked,field:field,table_name:'import_rate'} ,
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
