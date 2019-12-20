@extends('Layout.mobile.page')
@section('head')
    <style>
        .right_title{
            text-align: left;
            background-color: rebeccapurple;
            color: white;
        }
        #pathbackUI{
            display: flex;
            background-color: rebeccapurple;
            width: 100%;
            padding-left: 5px;
            padding-top: 5px;
            height: 30px;
            position: absolute;
            top:85px;
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
            /*display: flex;*/
        }
        table .left_item{
            width: 100%;
            background-color: #3ce97b;
        }
        table .right_item{
            background-color: #ff876a;
        }
        tbody .selectTemp div{
            /*width: 50%;*/
            margin: 0;
            text-align: center;

            margin: 2px;
            cursor: pointer;
        }
        table{
            background-color: white;
        }
        .table_div .title{
            background-color: #284257;
            color: white;
        }
        table tbody tr td{
            text-align: left;
        }
        table tbody tr td .set_market{
            border-radius: 50%;
            background-color: #b9bbbe;
            font-size: 15px;
            text-align: center;
            width: 20px;
            height: 20px;
        }
        table tbody tr td a{
            padding: 0;
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
        table tbody tr td .deactive_make:before{
            position: absolute;
            content: '';
            background-color: #898989;
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
            content: ':';
        }
        .table_div .title{
            padding: 10px;
            background-color: #284257;
            color: white;
        }
        /*bet slip*/
        #betSlipBoard .itemleft{
            width:60%;text-align: left;
        }
        #betSlipBoard .item20{
            width: 20%;text-align: center
        }
        #betSlipBoard .itemright{
            width: 20%;text-align: right
        }
        .backSlipHeader{
            background-color: #b9bbbe;
        }
        .bet_input{
            background-color: #a1cbef;
        }
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        /*checkbox*/
        input[type=checkbox] + label {
            display: block;
            margin: 0.2em;
            cursor: pointer;
            padding: 0.2em;
            font-weight: normal;
        }

        input[type=checkbox] {
            display: none;
        }

        input[type=checkbox] + label:before {
            content: "\2714";
            border: 0.1em solid #000;
            border-radius: 0.2em;
            display: inline-block;
            width: 1em;
            height: 1em;
            /* padding-left: 0.1em; */
            padding-bottom: 0.4em;
            margin-right: 0.2em;
            vertical-align: bottom;
            color: transparent;
            transition: .2s;
            font-size: 1em;
            line-height: 1;
            margin-bottom: 2px;
            border-color: red;
        }

        input[type=checkbox] + label:active:before {
            transform: scale(0);
        }

        input[type=checkbox]:checked + label:before {
            background-color: MediumSeaGreen;
            border-color: MediumSeaGreen;
            color: #fff;
        }

        input[type=checkbox]:disabled + label:before {
            transform: scale(1);
            border-color: #aaa;
        }

        input[type=checkbox]:checked:disabled + label:before {
            transform: scale(1);
            background-color: #bfb;
            border-color: #bfb;
        }
        .nav-tabs .active a{
            background: #757175;
            background: -moz-linear-gradient(top, #757175 0%, #000000 100%);
            background: -webkit-linear-gradient(top, #757175 0%, #000000 100%);
            background: linear-gradient(to bottom, #757175 0%, #000000 100%);
            color: #FFA40C!important;
        }
        .nav-tabs li a{
            font-weight: bold;
            font-size: 15px;
            background-color: #FFA40C!important;
            background: #FFA40C;
            background: -moz-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);
            background: -webkit-linear-gradient(top, #FFA40C 0%, #FFA40C 100%);
            background: linear-gradient(to bottom, #FFA40C 0%, #FFA40C 100%);
            color: black!important;
            border: 0!important;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .nav-tabs li a span{
            font-size: 20px;
        }
        .nav-tabs li{
            margin-bottom: 0px;!important;
        }
        .active_market{
            background-color: #3ce97b!important;
        }
    </style>
    <style>
        .flow-text{
            position: absolute;
            overflow: hidden;
            width: 80%;
            top: 50px;!important;
            height: 30px;
            margin: auto;
        }
        .flow-text:hover .target{
            animation-play-state: paused;
        }
        .target {
            position: relative;
            -webkit-animation: mymove 5s infinite; /* Safari 4.0 - 8.0 */
            -webkit-animation-timing-function: linear; /* Safari 4.0 - 8.0 */
            animation: mymove 5s infinite;
            animation-timing-function: linear;
        }

        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes mymove {
            from {right: 0;}
            to {left: 80%;}
        }

        @keyframes mymove {
            from {left: 80%;}
            to {left: 0%;}
        }
        .header {
            height: 70px;
            z-index: 1;
        }
        .icon-size{
            height: 160px;!important;
        }
        /*#icon-div{*/
        /*margin-top: 50px;!important;*/
        /*}*/
        .footer #sports:before {
            content: none;
        }
        .footer{
            height:55px;
        }
        .svg-inline--fa {
            height: 25px;!important;
            vertical-align: .3em;!important;
        }
        .footer p{
            margin:0;!important;
            margin-top:-20px;!important;
        }
    </style>
@stop

@section('content')
    <div style="padding-top: 15px;">
        <div id="pathbackUI" style="position: fixed;top: 65px;width: 100%;z-index: 1">
            <div class="path_item" style="display: flex">
                    <div id="" class="" type="button" data-toggle="" onclick="display_path(0,'Sports')">Sports</div>
                   {{-- <div id="" class="" type="button" data-toggle="" onclick="display_path(1,'Sports')"> >Cricket
                    </div>--}}
                    {{--<div id="" class="" type="button" data-toggle="" onclick="display_path(1,'Sports')"> >asian
                    </div>--}}
            </div>
        </div>
        <div class="table_div" >
            <table class="table table-hover">
                <tbody id="table_content">
                @foreach($sports_list as $item)
                <tr>
                    <td>
                        <div onclick="display_path(1,{{$item->import_id}})">{{$item->name}}</div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>


    </div>
@stop

@section('script')
    <script>

    </script>
    <script>
        function display_league(level,name) {
            $('#pathbackUI .path_item').html('');
            $('#pathbackUI .path_item').append('<div id="" class="" type="button" data-toggle="" onclick="display_path(0,\'Sports\')">' +
                'Sports' +
                '</div>');
            $('#pathbackUI .path_item').append('<div id="" class="" type="button" data-toggle="" onclick="display_path(1,\''+name+'\')"> >' +
                name +
                '</div>');
            display_path(level,name);
            //console.log(id);

        }
        function display_path(level,import_id) {
            //console.log(name);
            switch (level) {
                case 0:
                    $('#pathbackUI .path_item').html('');
                    $('#pathbackUI .path_item').append('<div id="" class="" type="button" data-toggle="" onclick="display_path(0,\'Sports\')">' +
                        'Sports' +
                        '</div>');
                    $('#table_content').html('');
                    $('#table_content').append('<tr>' +
                            '<td>' +
                                '<div onclick="display_path(1,\'Cricket\')">Cricket</div>' +
                            '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td>' +
                                '<div onclick="display_path(1,\'Soccer\')">Soccer</div>' +
                            '</td>' +
                        '</tr>' +
                        '<tr>\n' +
                            '<td>' +
                                '<div onclick="display_path(1,\'Tennis\')">Tennis</div>' +
                            '</td>' +
                        '</tr>');
                    break;
                case 1:

                    $.ajax({
                        url: 'https://oddsexch.com/api/getLeague',
                        type: 'post',
                        data: { level:level,import_id:import_id} ,
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function(response){
                            //console.log(response);
                            var obj = JSON.parse(response);
                            //alert(obj.message);
                            $('#pathbackUI .path_item').html('');
                            obj.data.path.forEach(function (value,index) {
                                console.log(value);
                                console.log(index);
                                $('#pathbackUI .path_item').append('<div id="" class="" type="button" data-toggle="" onclick="display_path(' +index+
                                    ',\''+value+'\')">' +
                                    value +
                                    '></div>');
                            });
                            //$('#charge_dlg').modal('toggle');
                            $('#table_content').html('');
                            obj.data.child_items.forEach(item=>{
                                console.log(item);
                                $('#table_content').append('<tr>' +
                                    '<td>' +
                                    '<div onclick="display_path(2,\''+item+'\')">' +
                                    item +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            //console.log(obj);


                        },
                        error: function(response){
                            console.log(response);
                            //alert('error');
                        }
                    });
                    break;
                case 2:
                    $.ajax({
                        url: 'https://oddsexch.com/api/getLeague',
                        type: 'post',
                        data: { level:level,name:name} ,
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function(response){
                            //console.log(response);
                            var obj = JSON.parse(response);
                            //console.log(obj);
                            $('#pathbackUI .path_item').html('');
                            obj.data.path.forEach(function (value,index) {
                                console.log(value);
                                console.log(index);
                                $('#pathbackUI .path_item').append('<div id="" class="" type="button" data-toggle="" onclick="display_path(' +index+
                                    ',\''+value+'\')">' +
                                    value +
                                    '></div>');
                            });
                            //alert(obj.message);
                            //$('#charge_dlg').modal('toggle');
                            $('#table_content').html('');
                            obj.data.events.forEach(item=>{
                                console.log(item);
                                $('#table_content').append('<tr>' +
                                    '<td>' +
                                    ' <a href="https://oddsexch.com/mobile/event/detail/'+item['id']+'" class="">' +
                                    item['teams'] +
                                    '</a>' +
                                    '</td>' +
                                    '</tr>');
                            });
                            //console.log(obj);


                        },
                        error: function(response){
                            console.log(response);
                            //alert('error');
                        }
                    });
                    break;
            }
        }
        //////////////////////////////

    </script>
    <script type="text/javascript">
        $('.footer #sports').addClass('footer_active');
    </script>
@stop