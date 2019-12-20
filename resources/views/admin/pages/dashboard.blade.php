@extends('admin.Layout.pagetemplate')
@section('head')
    <style>

    </style>
    @stop
@section('content')
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">Ended Events</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{$count['ended_count']}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">help</i>
                </div>
                <div class="content">
                    <div class="text">Live Events</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{{$count['inplay_count']}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">forum</i>
                </div>
                <div class="content">
                    <div class="text">Notifications</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20">{{$count['noti_count']}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">Users</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20">{{$count['user_count']}}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Event Chart</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <canvas id="line_chart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{--<line_chart label="{{json_encode($label_list)}}"></line_chart>--}}
    <div class="row clearfix">
        <!-- Task Info -->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Time Status</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Import_ID</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($time_state as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->import_id}}</td>
                                    <td>{{$item->description}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>BetFair Sports</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Import_ID</th>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sport_names as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->import_id}}</td>
                                    <td>{{$item->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Task Info -->

    </div>
    <input id="label" value="{{json_encode($label_list)}}" type="hidden">
    <input id="datasets" value="{{json_encode($datasets)}}" type="hidden">
@stop
@section('script')
    <script>
        $(function () {
            new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
        });

        function getChartJs(type) {
            var config = null;
            if (type === 'line') {
                config = {
                    type: 'line',
                    data: {
                        labels: JSON.parse($('#label').val()),
                        datasets: JSON.parse($('#datasets').val())
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'bar') {
                config = {
                    type: 'bar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: 'rgba(0, 188, 212, 0.8)'
                        }, {
                            label: "My Second dataset",
                            data: [28, 48, 40, 19, 86, 27, 90],
                            backgroundColor: 'rgba(233, 30, 99, 0.8)'
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'radar') {
                config = {
                    type: 'radar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [65, 25, 90, 81, 56, 55, 40],
                            borderColor: 'rgba(0, 188, 212, 0.8)',
                            backgroundColor: 'rgba(0, 188, 212, 0.5)',
                            pointBorderColor: 'rgba(0, 188, 212, 0)',
                            pointBackgroundColor: 'rgba(0, 188, 212, 0.8)',
                            pointBorderWidth: 1
                        }, {
                            label: "My Second dataset",
                            data: [72, 48, 40, 19, 96, 27, 100],
                            borderColor: 'rgba(233, 30, 99, 0.8)',
                            backgroundColor: 'rgba(233, 30, 99, 0.5)',
                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                            pointBackgroundColor: 'rgba(233, 30, 99, 0.8)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'pie') {
                config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [225, 50, 100, 40],
                            backgroundColor: [
                                "rgb(233, 30, 99)",
                                "rgb(255, 193, 7)",
                                "rgb(0, 188, 212)",
                                "rgb(139, 195, 74)"
                            ],
                        }],
                        labels: [
                            "Pink",
                            "Amber",
                            "Cyan",
                            "Light Green"
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            return config;
        }
    </script>

    @stop


