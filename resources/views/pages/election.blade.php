@extends('Layout.page')
@section('head')

    <style>
        .right_title{
            text-align: left;
            background-color: rebeccapurple;
            color: white;
        }
        #pathbackUI{
            display: flex;
            background-color: #212121;
            width: 100%;
            padding-left: 5px;
        }
        .path_item{
            color: #fe950e;
            display: flex;
        }
        .path_item svg{
            margin-top: 5px;
        }
        .list-group-item{
            padding: 0 0 0 15px!important;
            text-align: left;
        }
        .list-group a::before {
            content: "";
            position: absolute;
            top:30%;
            right: 4px;
            width: 9px;
            height: 9px;
            background-color: red;
            border-radius: 50%;
        }
        /*table*/
        .table_head tr th{
            text-align: center;
        }
        tbody .selectTemp{
            display: flex;
        }
        table .left_item{
            background-color: #3ce97b;
        }
        table .right_item{
            background-color: #ff876a;
        }
        tbody .selectTemp div{
            width: 50%;
            margin: 0;
            text-align: center;

            margin: 2px;
            cursor: pointer;
        }
        table{
            background-color: white;
        }
        .table_div .title{
            padding: 10px;
            background-color: #284257;
            color: white;
        }
        .table_div{
            margin-top: 20px;
        }
        table tbody tr td a{
            padding-left: 20px;
        }
        table tbody tr td a .title_span{
            color: #2789CE;
            font-weight: bold;
        }
        table tbody tr td a .score_span{
            color: #508D0E;
            font-weight: bold;
        }
        table tbody tr td{
            position: relative;
        }
        table tbody tr td .active_make:before{
            position: absolute;
            content: '';
            background-color: #2ecc71;
            border-radius: 4px;
            width: 8px;
            height: 8px;
            left: 10px;
            top: 35%;
        }
        .active1{
            background-color: #2dc378 !important;
        }
        .active2{
            background-color: #c76459 !important;
        }
        .hide{
            display: none;
        }
        /*today table*/
        .path_span{
            position: relative;
            margin-right: 20px;
        }
        .path_span:after{
            content: '';
            position: absolute;
            right: -15px;
            top: 20%;
            width: 0;
            height: 0;
            border-top: 5px solid transparent;
            border-left: 10px solid black;
            border-bottom: 5px solid transparent;
        }
        .table_div .title{
            padding: 10px;
            background-color: #284257;
            color: white;
        }
    </style>
@stop
@section('left_content')
    <div id="pathbackUI" style="">
        <div class="path_item">
            <div class="dropdown">
                <div class="dropdown-toggle" type="button" data-toggle="dropdown" style="display: flex">Sports
                    <span class="caret" style="margin-top: 9px"></span>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/')}}">Sports</a></li>
                </ul>
            </div>
        </div>
        <div class="path_item">
            <svg height="10" width="10">
                <polyline points="0,0 5,5 0,10 " style="fill:none;stroke:#ffffff;stroke-width:1" />
                <polyline points="5,0 10,5 5,10 " style="fill:none;stroke:#ffffff;stroke-width:1" />
                Sorry, your browser does not support inline SVG.
            </svg>
            Election
        </div>
    </div>
    <div class="list-group">
        <a href="#" class="list-group-item">First item</a>
        <a href="#" class="list-group-item">Second item</a>

    </div>
@stop
@section('content')
    <div style="padding-left: 10px;padding-right: 10px">
        {{--<div style="width: 100%;height: 200px;background-size: cover ;background-image: url('{{asset('img/KV01.jpg')}}')">--}}

        {{--</div>--}}
        <div class="table_div" style="padding: 10px">
            <div class="title">Highlights</div>
            <table class="table table-hover">
                <thead class="table_head">
                <tr>
                    <th></th>
                    <th>1</th>
                    <th>x</th>
                    <th>2</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="javascript:voit(0)" class="active_make">
                            <span class="title_span">Alanyaspor</span>
                            <span class="score_span">2-0</span>
                            <span class="title_span">sivasspor</span>
                            <span class="score_span">In-Play52'</span>
                        </a>

                    </td>
                    <td>
                        <div class="selectTemp">
                            <div class="left_item">123</div>
                            <div class="right_item">234</div>
                        </div>
                    </td>
                    <td>
                        <div class="selectTemp">
                            <div class="left_item">123</div>
                            <div class="right_item">234</div>
                        </div>
                    </td>
                    <td>
                        <div class="selectTemp">
                            <div class="left_item">123</div>
                            <div class="right_item">234</div>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>


@stop
@section('right_content')
    <div class="right_title">
        <span>Bet Slip</span>
    </div>
@stop
@section('script')
    <script>
        {{--table item click--}}
        $('.selectTemp .left_item').click(function () {
            $(this).toggleClass('active1');

        });

        $('.selectTemp .right_item').click(function () {
            $(this).toggleClass('active2');
        });
        $('.list-group-item').click(function () {
            alert($(this).text());
        });
    </script>
@stop