@extends('user.Layout.page_template')
@section('head')


@stop
@section('left_content')
    @include('pages.home.left_content0')
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
@section('right_content')
@stop
@include("Layout.footer")
@section('script')
    <script>

    </script>
@stop
