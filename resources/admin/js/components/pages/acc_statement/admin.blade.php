@extends('admin.Layout.pagetemplate')
@section('head')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('user/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <style>
        .date_filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            padding: 0 20px;
        }

        .date_filter input {
            width: 200px;
            margin: 5px;
        }
        .date_filter button{
            margin: 5px;
            width: 100px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    </style>

@stop
@section('content')

    <div class="block-header">
        <h2>Master</h2>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Account Statement
                    </h2>
                    <ul class="header-dropdown m-r--5">

                    </ul>
                </div>
                <div class="date_filter header">
                    <form method="GET"  id="filter_form">
                        <input type="hidden" name="user_id" value="{{isset($_GET['user_id'])?$_GET['user_id']:''}}" />
                        <input type="date"  name="start_date" class="form-control" placeholder="Date start..." value="{{isset($_GET['start_date'])?$_GET['start_date']:''}}">
                        <input type="date"  name="end_date" value="{{isset($_GET['start_date'])?$_GET['end_date']:''}}" class="form-control" placeholder="Date end...">
                        <input type="text"  name="search" value="{{isset($_GET['search'])?$_GET['search']:''}}" class="form-control" placeholder="Search">
                        <button type="submit" class="btn bg-amber waves-effect" >Filter</button>
                        <button type="button" class="btn bg-light-green waves-effect" onclick="clear();">Clear</button>
                    </form>

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Before Amount</th>
                                <th>After Amount</th>
                            </tr>

                            </thead>
                            <tbody>
                            @for($i=0;$i<count($statements);$i++)
                                @php
                                    $item=$statements[$i];
                                @endphp
                                <tr >
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->datetime}}</td>
                                    <td>{{$item->remark}}</td>
                                    <td>{{round($item->before_amount)}}</td>
                                    <td>{{round($item->after_amount)}}</td>
                                    <td>{{round($item->change_amount)}}</td>
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


@stop
@section('script')
    <script>
        function clear(){
            console.log("clear");
            $('#filter_form').find('input').val("");
        }
        $( document ).ready(function() {
            console.log('ready');
            $('#client_menu a').addClass('toggled');
            $('#client_menu ul').css('display','block');
        });
    </script>
    <script>

    </script>
@stop
