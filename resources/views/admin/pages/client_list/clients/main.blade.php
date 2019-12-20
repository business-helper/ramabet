@extends('admin.Layout.pagetemplate')
@section('head')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('user/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
    <div class="block-header">
        <h2>Client</h2>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Client Table
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="add_master">Add Client</a></li>
                                {{--<li><a href="javascript:void(0);">Another action</a></li>--}}
                                {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>P|L Share</th>
                                <th>Comm</th>
                                <th>P|L</th>
                                <th>State</th>
                                <th>Chips</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            {{--<tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                            </tfoot>--}}
                            <tbody>
                            @for($i=0;$i<count($client);$i++)
                                @php
                                    $item=$client[$i];
                                @endphp
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->profit_loss_per}}%</td>
                                    <td>{{$item->comm}}%</td>
                                    <td>{{$item->profit_loss_amount}}%</td>
                                    <td>
                                        {{$item->state}}
                                        <ul class="" style="float: right; margin: -5px 0; padding: 0;">
                                            <li class="dropdown" style="list-style: none">
                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a href="{{url('admin/admin_state/'.$item->id.'/normal/users')}}">normal</a></li>
                                                    <li><a href="{{url('admin/admin_state/'.$item->id.'/block/users')}}">block</a></li>
                                                    <li><a href="{{url('admin/admin_state/'.$item->id.'/delete/users')}}">delete</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <div style="display: flex">
                                            <span style="flex: 1">{{$item->wallet}}</span>
                                            <button  onclick="Balance('Deposit',{{json_encode($item)}})" title="depost" class="pd-setting-ed">
                                                D
                                            </button>
                                            <button  onclick="Balance('Withdraw',{{json_encode($item)}})" title="withdraw" class="pd-setting-ed">
                                                W
                                            </button>
                                        </div>
                                    </td>
                                    <td class="datatable-ct">
                                        <button  onclick="EditMaster({{json_encode($item)}})" title="Edit" class="pd-setting-ed">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button  onclick="Reset({{json_encode($item)}})" title="Reset Password" class="pd-setting-ed">
                                            <i class="fas fa-unlock-alt"></i>
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
    <!-- #END# Exportable Table -->
    {{--add master dlg--}}
    <div id="add_master_dlg" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
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
                        <input id="master_id" type="hidden" class="form-control" />
                    </div>
                    <div class="form-group-inner">
                        <label>Name</label>
                        <input id="name" type="text" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Email</label>
                        <input id="email" type="email" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>P|L Share</label>
                        <input id="profit_loss_per" type="number" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Comm</label>
                        <input id="comm" type="number" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group-inner">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" placeholder="" />
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal" href="#">Cancel</a>
                    <button class="btn btn-default" id="add_master">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{--deposit dlg--}}
    <div id="balance_dlg" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-color-modal bg-color-4">
                    <h4 class="modal-title text-center"><span class="balance_type"></span></h4>
                    <span id="type" style="display: none">
                    </span>
                    <div class="modal-close-area modal-close-df" style="position: absolute; right: 10px; top: 10px;">
                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <input id="master_id" type="hidden" class="form-control" />
                    <!-- Deposit Chips*-->
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-xs-2" style="text-align: right">
                                <label class="control-label" for="total_amount"><span class="balance_type"></span> Chips:*</label>
                            </div>
                            <div class="col-xs-5">
                                <input id="total_amount" name="total_amount" type="number" placeholder="Amount" class="form-control input-md" value="">
                            </div>
                            <div class="col-xs-5" style="text-align: left">
                                Amount to Pay:<span id="pay_amount">100</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-xs-2" style="text-align: right">

                            </div>
                            <div class="col-xs-5" style="text-align: left">
                                <span style="font-weight: bold;text-align: left">Admin</span>
                            </div>
                            <div class="col-xs-5" style="text-align: left">
                                <span style="font-weight: bold;text-align: left" >Master</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-xs-2" style="text-align: right">
                                <label class="control-label" for="">Current Chips:</label>
                            </div>
                            <div class="col-xs-5" style="text-align: left">
                                <span class="admin_balance"></span>
                                <input id="subadmin_amount" name="subadmin_amount" type="hidden">
                            </div>
                            <div class="col-xs-5" style="text-align: left">
                                <span class="sub_balance"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">

                        <div class="row">
                            <div class="col-xs-2" style="text-align: right">
                                <label class="control-label" for="remark">Remark</label>
                            </div>
                            <div class="col-xs-5">
                                <textarea class="form-control" id="admin_remark" name="remark" value="" style="height: 150px">Deposit chips to bettech Rs: </textarea>
                            </div>
                            <div class="col-xs-5">
                                <textarea class="form-control" id="sub_remark" name="remark" value="" style="height: 150px">Deposit chips by Admin</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal" href="#">Cancel</a>
                    <button class="btn btn-default" id="deposit_withdraw" >Submit</button>
                </div>
            </div>
        </div>
    </div>
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
            $('#client_menu a').addClass('toggled');
            $('#client_menu ul').css('display','block');
        });
    </script>
    <script>
        function Balance(type,item) {
            $('#balance_dlg .sub_balance').text(item.wallet);
            $('#balance_dlg #master_id').val(item.id);
            $('#balance_dlg #subadmin_amount').val(item.wallet);
            $('#balance_dlg .admin_balance').text({{Auth::user('admin')->wallet}});
            $('#balance_dlg #type').text('update');
            $('#balance_dlg .balance_type').text(type);
            $('#balance_dlg #total_amount').val(0);
            $('#balance_dlg').modal();
        }
        $(document).on("change paste keyup","#total_amount", function() {
            //console.log( $(this).val() );
            var admin_balance='{{Auth::user('admin')->wallet}}';
            var sub_balance=$('#balance_dlg #subadmin_amount').val();
            var amount=$('#balance_dlg #total_amount').val();
            if ($('#balance_dlg #total_amount').val()==''){
                amount=0;
            }

            $('#balance_dlg #pay_amount').text(amount);
            console.log($('#balance_dlg .balance_type').text());
            if ($('#balance_dlg .balance_type').text()=='DepositDeposit') {
                $('#balance_dlg .admin_balance').text(parseFloat(admin_balance)-parseFloat(amount));
                $('#balance_dlg .sub_balance').text(parseFloat(sub_balance)+parseFloat(amount));
                $('#balance_dlg #admin_remark').text('Deposit chips to bettech Rs: '+amount);
            }
            else{
                $('#balance_dlg .admin_balance').text(parseFloat(admin_balance)+parseFloat(amount));
                $('#balance_dlg .sub_balance').text(parseFloat(sub_balance)-parseFloat(amount));
                $('#balance_dlg #admin_remark').text('Withdraw chips to bettech Rs: '+amount);
                $('#balance_dlg #s_remark').text('Withdraw chips to bettech Rs: '+amount);
            }

        });
        $('#deposit_withdraw').click(function () {
            $('#balance_dlg').modal('toggle');
            var send_data={};
            send_data.type= $('#balance_dlg #type').text();
            send_data.table_name= 'users';
            send_data.data={
                //'id':$('#add_master_dlg #master_id').val(),
                'wallet':$('#balance_dlg .sub_balance').text(),
            };
            send_data.condition=[];
            send_data.condition.push(['id',$('#balance_dlg #master_id').val()]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('{{url('api/table_edit')}}',send_data,false);

            send_data={};
            send_data.type= $('#balance_dlg #type').text();
            send_data.table_name= 'users';
            send_data.data={
                'wallet':$('#balance_dlg .admin_balance').text(),
            };
            send_data.condition=[];
            send_data.condition.push(['id',{{Auth::user('admin')->id}}]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('{{url('api/table_edit')}}',send_data,false);
            //wallet history admin
            send_data={};
            send_data.type= 'insert';
            send_data.table_name= 'wallet_history';
            send_data.data={
                //'id':$('#add_master_dlg #master_id').val(),
                'change_amount':$('#balance_dlg #total_amount').val(),
                'before_amount':'{{Auth::user('admin')->wallet}}',
                'after_amount':$('#balance_dlg .admin_balance').text(),
                'remark':$('#balance_dlg #admin_remark').text(),
                't_id':'{{Auth::user('admin')->id}}',
                'user_id':'{{Auth::user('admin')->id}}',
                'user_type':1,
            };
            send_data.condition=[];
            send_data.condition.push(['id',{{Auth::user('admin')->id}}]);
            myajax('{{url('/api/table_edit')}}',send_data,false);

            //wallet history master
            send_data={};
            send_data.type= 'insert';
            send_data.table_name= 'wallet_history';
            send_data.data={
                //'id':$('#add_master_dlg #master_id').val(),
                'change_amount':$('#balance_dlg #total_amount').val(),
                'before_amount':$('#balance_dlg #subadmin_amount').val(),
                'after_amount':$('#balance_dlg .sub_balance').text(),
                'remark':$('#balance_dlg #sub_remark').text(),
                't_id':$('#balance_dlg #master_id').val(),
                'user_id':$('#balance_dlg #master_id').val(),
                'user_type':1,
            };
            send_data.condition=[];
            send_data.condition.push(['id',{{Auth::user('admin')->id}}]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('{{url('api/table_edit')}}',send_data,true);
        });
        function EditMaster(item) {
            //window.location.href = url;
            $('#add_master_dlg #master_id').val(item.id);
            $('#add_master_dlg #name').val(item.name);
            $('#add_master_dlg #email').val(item.email);
            $('#add_master_dlg #profit_loss_per').val(item.profit_loss_per);
            $('#add_master_dlg #comm').val(item.comm);
            //$('#add_master_dlg #master_id').val(item.id);
            //$('#add_master_dlg #password').val(item.password);
            $('#add_master_dlg .modal-header .modal-title').text('Update Client');
            $('#add_master_dlg #type').text('update');
            $('#add_master_dlg #add_master').text('Save');
            $('#add_master_dlg').modal();
        }
        $('.add_master').click(function () {
            $('#add_master_dlg #type').text('insert');
            $('#add_master_dlg .modal-header .modal-title').text('Add Client');
            $('#add_master_dlg #change_odd').text('Submit');
            $('#add_master_dlg').modal();
        });
        $('#add_master').click(function () {
            $('#add_master_dlg').modal('toggle');
            var send_data={};
            send_data.type= $('#add_master_dlg #type').text();
            send_data.table_name= 'users';
            //send_data.data=[];
            send_data.data={
                //'id':$('#add_master_dlg #master_id').val(),
                'name':$('#add_master_dlg #name').val(),
                'email':$('#add_master_dlg #email').val(),
                'profit_loss_per':$('#add_master_dlg #profit_loss_per').val(),
                'comm':$('#add_master_dlg #comm').val(),
                'password':$('#add_master_dlg #password').val(),
                'distributor_id':'{{Auth::user('admin')->id}}'
            };
            // send_data.data.push({"field":'id',"value":$('#PrimaryModalhdbgcl #sports_id').val()});
            // send_data.data.push({"field":'title',"value":$('#PrimaryModalhdbgcl #sports_name').val()});
            send_data.condition=[];
            send_data.condition.push(['id',$('#add_master_dlg #master_id').val()]);
            //console.log(typeof send_data,JSON.stringify(send_data));
            myajax('{{url('api/table_edit')}}',send_data,true);
        });
        function Reset(item) {
            //$('#add_master_dlg').modal('toggle');
            var send_data={};
            send_data.type= $('#add_master_dlg #type').text();
            send_data.table_name= 'users';
            //send_data.data=[];
            send_data.data={
                'password':'123456789',
            };
            send_data.condition=[];
            send_data.condition.push(['id',item.id]);
            myajax('{{url('api/table_edit')}}',send_data,false);
        }
    </script>
@stop
