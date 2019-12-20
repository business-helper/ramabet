@extends('Layout.mobile.page')
@section('head')

    <style>
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
            height: 25px!important;
            vertical-align: .3em!important;
        }
        .footer p{
            margin:0!important;
            margin-top:-20px!important;
        }
        .table_div {
            margin-top: 0px!important;
        }

        .link_title{
            display: inline-block;
            margin-top: 100px;
        }
        .link_title h1{
            text-transform: uppercase;
            font-family: 'Squada One', cursive;
            font-weight: 800;
            display: block;
            background: #FFF;
            padding: 2px 10px;
            color: #333;
            font-size: 35px;
            text-align: center;
            text-decoration: none;
            position: relative;
            z-index: 1;
            text-shadow:
                    1px 1px 0px #FFF,
                    2px 2px 0px #999,
                    3px 3px 0px #FFF;
            background-image: -webkit-linear-gradient(top, transparent 0%, rgba(0,0,0,.05) 100%);
            -webkit-transition: 1s all;
            background-image: -webkit-linear-gradient(left top,
            transparent 0%, transparent 25%,
            rgba(0,0,0,.15) 25%, rgba(0,0,0,.15) 50%,
            transparent 50%, transparent 75%,
            rgba(0,0,0,.15) 75%);
            background-size: 4px 4px;
            box-shadow:
                    0 0 0 1px rgba(0,0,0,.4) inset,
                    0 0 20px -5px rgba(0,0,0,.4),
                    0 0 0px 3px #FFF inset;

        }
        .link_title h1hover {
            color: #d90075;
        }

        .link_title p{
            color: #443737;
            font-size: 12px;
            font-family: 'Cardo', serif;
            font-weight: normal;
            font-style: italic;
            letter-spacing: 0.1em;
            line-height: 2.2em;
            text-shadow: 0.07em 0.07em 0 rgba(207, 255, 15, 0.8);
        }

    </style>
@stop

@section('content')
    <div style="margin-top: 30px; margin-bottom: 30px;">
        @foreach($link_list as $link_item)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="{{asset('img/link/'.$link_item->img)}}" alt="Card Thumbnail" style="padding: 0px; margin-top: 5px;">
                    <div class="caption">
                        <h4>{{$link_item->name}}</h4>
                        <p style="font-size: 14px">{{$link_item->content}}</p>
                        <a href="{{$link_item->link}}" class="btn btn-primary center-block" role="button">Join now</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $('.footer #home').addClass('footer_active');
        $('#soccer').css('display','block');
        $('#tennis').css('display','block');
    </script>
@stop