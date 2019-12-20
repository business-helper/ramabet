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
        /*button*/
        .third {
            /* border-color: #1c4d6d; */
            color: #fff;
            box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;
            transition: all 150ms ease-in-out;
        }
        .third:hover {
            box-shadow: 0 0 10px 0 #3ce97b inset, 0 0 10px 4px #3ce97b;
        }
        .second {
            /* border-color: #1c4d6d; */
            color: #fff;
            box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;
            transition: all 150ms ease-in-out;
        }
        .second:hover {
            box-shadow: 0 0 10px 0 #e94a45 inset, 0 0 10px 4px #e94a45;
        }

        .btn:hover, .btn:focus {
            color: black;
            outline: 0;
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
            z-index: 100;
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
    @if(isset($account))
        @php
        $account_info=json_decode($account,true);
        @endphp
        @include('pages.mobile.account.submenu')
        <h3>Account Detail</h3>
        <div class="table_div" style="padding-left: 10px;padding-right: 10px">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{action('ApiController@update_user')}}" class="review-content-section" method="post">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="devit-card-custom">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{$account_info['name']}}"/>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="email" class="form-control" placeholder="Email" value="{{$account_info['email']}}"/>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Password" value=""/>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light black_btn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{action('ApiController@update_user')}}" class="review-content-section" method="post">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="devit-card-custom">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Password" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Password" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>Conform Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Password" value=""/>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light black_btn">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif


@stop

@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
    <script>
        $('.footer #account').addClass('footer_active');
    </script>
@stop