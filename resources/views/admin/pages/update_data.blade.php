@extends('admin.Layout.pagetemplate')
@section('head')
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
    <updatedata></updatedata>
    @include('admin.Layout.footer')
@stop
@section('script')
    <!-- morrisjs JS
    ============================================ -->
    <script src="{{asset('admin/js/morrisjs/raphael-min.js')}}"></script>
    <script src="{{asset('admin/js/morrisjs/morris.js')}}"></script>
    {{--    <script src="{{asset('admin/js/morrisjs/morris-active.js')}}"></script>--}}

    <script type="text/javascript">
        //console.log("{/{json_encode($users)}}");
        Morris.Area({
            element: 'extra-area-chart',
            data: [{
                period: "{{json_decode($photograph,true)[0]['period']}}",
                Soccer: "{{json_decode($photograph,true)[0]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[0]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[0]['Tennis']}}"
            }, {
                period: "{{json_decode($photograph,true)[1]['period']}}",
                Soccer: "{{json_decode($photograph,true)[1]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[1]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[1]['Tennis']}}"
            }, {
                period: "{{json_decode($photograph,true)[2]['period']}}",
                Soccer: "{{json_decode($photograph,true)[2]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[2]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[2]['Tennis']}}"
            }, {
                period: "{{json_decode($photograph,true)[3]['period']}}",
                Soccer: "{{json_decode($photograph,true)[3]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[3]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[3]['Tennis']}}"
            }, {
                period: "{{json_decode($photograph,true)[4]['period']}}",
                Soccer: "{{json_decode($photograph,true)[4]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[4]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[4]['Tennis']}}"
            }, {
                period: "{{json_decode($photograph,true)[5]['period']}}",
                Soccer: "{{json_decode($photograph,true)[5]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[5]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[5]['Tennis']}}"
            },{
                period: "{{json_decode($photograph,true)[6]['period']}}",
                Soccer: "{{json_decode($photograph,true)[6]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[6]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[6]['Tennis']}}"
            },{
                period: "{{json_decode($photograph,true)[7]['period']}}",
                Soccer: "{{json_decode($photograph,true)[7]['Soccer']}}",
                Cricket: "{{json_decode($photograph,true)[7]['Cricket']}}",
                Tennis: "{{json_decode($photograph,true)[7]['Tennis']}}"
            }],
            xkey: 'period',
            ykeys: ['Soccer', 'Cricket', 'Tennis'],
            labels: ['Soccer', 'Cricket', 'Tennis'],
            pointSize: 3,
            fillOpacity: 0,
            pointStrokeColors:['#006DF0', '#933EC5', '#65b12d'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 1,
            hideHover: 'auto',
            lineColors: ['#006DF0', '#933EC5', '#65b12d'],
            resize: true

        });
    </script>
@stop

