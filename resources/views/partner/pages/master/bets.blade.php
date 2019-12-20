<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('admin.Layout.head')
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
</head>
<body class="">

<div class="preloader-single shadow-inner mg-tb-30" style="position: absolute;top: 0;left: 0;width: 100%;z-index: 1000;height: 100%">
    <div class="ts_preloading_box">
        <div id="ts-preloader-absolute22">
            <div class="tsperloader22" id="first_tsperloader22"></div>
            <div class="tsperloader22" id="second_tsperloader22"></div>
            <div class="tsperloader22" id="third_tsperloader22"></div>
        </div>
    </div>
</div>

<!--[if lt IE 8]>

<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Start Left menu area -->
<!-- End Left menu area -->
<!-- Start Welcome area -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div style="float: right" class="btn btn-default add_sports">Add</div>
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1>Bets List</h1>
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
                                    <th data-field="master">Master</th>
                                    <th data-field="distributor">Distributor</th>
                                    <th data-field="client">Client</th>
                                    <th data-field="bet_type">Back/Lay</th>
                                    <th data-field="stake">Stake</th>
                                    <th data-field="odd">Odd</th>
                                    <th data-field="runner_name">runnerName</th>
                                </tr>
                                </thead>
                                <tbody>

                                @for($i=0;$i<count($bets);$i++)
                                    @php
                                        $item=$bets[$i];
                                    @endphp
                                    <tr>
                                        <td></td>
                                        <td>{{$item->bet_id}}</td>
                                        <td>{{$item->master_name}}</td>
                                        <td>{{$item->distributor_name}}</td>
                                        <td>{{$item->username}}</td>
                                        <td>{{$item->bet_type}}</td>
                                        <td>{{$item->stake}}</td>
                                        <td>{{$item->odd}}</td>
                                        <td>{{$item->runnerName}}</td>
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
@include('admin.Layout.script')
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
</body>

</html>