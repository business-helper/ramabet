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

                    <div class="admintab-wrap edu-tab1 mg-t-30">
                        <div class="tab-content">
                            <div class="sparkline13-list">
                                <form class="form-horizontal" method="post" action="{{route('admin.addBalance')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <fieldset>
                                    <!-- Form Name -->
                                    <legend>
                                        Add Balance
                                        <span style="float: right; font-size: 14px; margin-right: 20px;">Current Balance : {{$wallet}}</span>
                                    </legend>

                                    <!-- Deposit Chips*-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textinput">Deposit Chips*</label>
                                        <div class="col-md-9">
                                            <input id="amount" name="amount" type="number" placeholder="Amount" class="form-control input-md" value="0">
                                        </div>
                                    </div>
                                    <!-- Total Amount-->
                                    <div class="form-group" style="margin-top: 50px;margin-bottom: 50px">
                                        <label class="col-md-3 control-label" for="total_amount">Total Amount</label>
                                        <div class="col-md-9">
                                            <input id="total_amount" name="total_amount" type="text" placeholder="Amount" class="form-control input-md" value="{{$wallet}}">
                                        </div>
                                    </div>
                                    <!-- Remark -->
                                    <div class="form-group">
                                        <label class="col-md-3  control-label" for="remark">Remark</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="remark" name="remark" value="" style="height: 300px"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" style="text-align: center">{{isset($msg)?$msg:''}}</label>
                                    </div>
                                    <!-- Button -->
                                    <div class="form-group">
                                        <div class="col-md-12" style="text-align: center;">
                                            <button id="submit" type="submit" name="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>

                                </fieldset>
                                </form>
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
            $('#balance').addClass('active1');
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
        $(document).on("change paste keyup","#amount", function() {
            //console.log( $(this).val() );
            var wallet='{{$wallet}}';
            var amount=$('#amount').val();
            if ($('#amount').val()==''){
                amount=0;
            }
            $('#total_amount').val(parseFloat(amount)+parseFloat(wallet));

        });
        function handleClick(cb,field,id) {
            //console.log("Clicked, new value = " +eventid+ cb.checked);
            $.ajax({
                url: 'https://odds24ex.com/api/check_set',
                type: 'post',
                data: { id:id,value:cb.checked,field:field,table_name:'InPlay'} ,
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
