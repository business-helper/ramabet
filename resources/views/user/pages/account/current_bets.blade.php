@extends('user.Layout.page_template1')

@section('head')
    <style>
        .bet_btn1{
            width: 100px;
            border: 1px solid #000;
            border-radius: 3px;
            color: #2185d0;
            display: inline-block;
            margin: 0 20px 10px 0;
            padding: 3px 8px 4px;
            cursor: pointer;background-color: transparent;}
        .bet_btn2{
            width: 100px;
            border: 1px solid #000;
            border-radius: 3px;
            color: #2185d0;
            display: inline-block;
            margin: 0 20px 10px 0;
            padding: 3px 8px 4px;
            cursor: pointer;background-color: transparent;}
        .seleted_bet_btn1{
            background: #2185d0!important;
            color: #fff!important;
        }
        .seleted_bet_btn2{
            background: #cae0e8!important;
            color: #084e83!important;
        }
    </style>
@stop
@section('left_content')
    @include('pages.home.left_content0')
@stop
@section('content')
    <div class="account_table" style="padding-left: 10px;padding-right: 10px">
        {{--<div class="title">About You</div>--}}
        <h1>My Betting</h1>

        <div class="bet_btn1 seleted_bet_btn1" data-value="current_bets">Current</div>
        <div class="bet_btn1" data-value="past_bets">Past</div>

        <div class="current_bets  bet_divs">
            <div class="bet_btn2 seleted_bet_btn2" data-value=".matched_div">Matched</div>
            <div class="bet_btn2" data-value=".unmatched_div">Unmatched</div>
        </div>
        <div class="past_bets bet_divs hidden">
            <div class="bet_btn2 seleted_bet_btn2" data-value=".settled">Settled</div>
            <div class="bet_btn2" data-value=".cancelled">Cancelled</div>
        </div>

        <div class="current_bets bet_divs show">
            <div class="matched_div data_div" >
                <table class="table table-hover current_bets">
                    <thead class="table_head">
                    <tr>
                        <th>Date</th>
                        <th>Placed</th>
                        <th>type</th>
                        <th>Odds</th>
                        <th>Stake</th>
                        <th>Profit/Loss</th>
                        <th>Teams</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bet_data['matched_bet'] as $item)
                        <tr>
                            <td>{{$item->bet_date}}</td>
                            <td>{{$item->runnerName}}</td>
                            <td>{{$item->bet_type}}</td>
                            <td>{{$item->odd}}</td>
                            <td>{{$item->stake}}</td>
                            <td>
                                {{(float)$item->price-(float)$item->stake}}
                            </td>
                            <td>{{$item->teams}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="unmatched_div data_div hidden">
                <table class="table table-hover current_bets">
                    <thead class="table_head">
                    <tr>
                        <th>Date</th>
                        <th>Placed</th>
                        <th>type</th>
                        <th>Odds</th>
                        <th>Stake</th>
                        <th>Profit/Loss</th>
                        <th>Teams</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bet_data['unmatched_bet'] as $item)
                        <tr>
                            <td>{{$item->bet_date}}</td>
                            <td>{{$item->runnerName}}</td>
                            <td>{{$item->bet_type}}</td>
                            <td>{{$item->odd}}</td>
                            <td>{{$item->stake}}</td>
                            <td>
                                {{(float)$item->price-(float)$item->stake}}
                            </td>
                            <td>{{$item->teams}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="past_bets bet_divs hidden">
            <div class="settled data_div show" data-value="">
                <table class="table table-hover past_bets">
                    <thead class="table_head">
                    <tr>
                        <th>Date</th>
                        <th>Placed</th>
                        <th>Odds</th>
                        <th>Stake</th>
                        <th>Amount</th>
                        <th>Teams</th>
                        <th>State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($past_bets as $item)
                        <tr>
                            <td>{{$item->bet_date}}</td>
                            <td>{{$item->runnerName}}</td>
                            <td>{{$item->odd}}</td>
                            <td>{{$item->stake}}</td>
                            <td>{{(float)$item->price-(float)$item->stake}}</td>
                            <td>{{$item->teams}}</td>
                            <td>{{$item->remarks}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="data_div cancelled hidden">
                <table class="table table-hover cancel_bets">
                    <thead class="table_head">
                    <tr>
                        <th>Date</th>
                        <th>Placed</th>
                        <th>Odds</th>
                        <th>Stake</th>
                        <th>Total Amount</th>
                        <th>Potential Profit</th>
                        <th>Teams</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cancel_bets as $item)
                        <tr>
                            <td>{{$item->bet_date}}</td>
                            <td>{{$item->runnerName}}</td>
                            <td>{{$item->odd}}</td>
                            <td>{{$item->stake}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{(float)$item->price-(float)$item->stake}}</td>
                            <td>{{$item->teams}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('right_content')
@stop
@include("Layout.footer")
@section('script')
    <script>
        $(document).ready(function() {
            $('.bet_btn1').click(function () {
                $('.bet_btn1').removeClass('seleted_bet_btn1');
                $(this).addClass('seleted_bet_btn1');
                var value = $(this).data('value');
                $('.bet_divs').addClass('hidden');
                $('.bet_divs').removeClass('show');
                $('.'+value).removeClass('hidden');
                $('.'+value).addClass('show');
            });
            $('.current_bets .bet_btn2').click(function () {
                $('.current_bets .bet_btn2').removeClass('seleted_bet_btn2');
                $(this).addClass('seleted_bet_btn2');
                $('.current_bets .data_div').removeClass('show');
                $('.current_bets .data_div').addClass('hidden');
                var value = $(this).data('value');
                $(value).removeClass('hidden');
                $(value).addClass('show');
            });
            $('.past_bets .bet_btn2').click(function () {
                $('.past_bets .bet_btn2').removeClass('seleted_bet_btn2');
                $(this).addClass('seleted_bet_btn2');
                $('.past_bets .data_div').removeClass('show');
                $('.past_bets .data_div').addClass('hidden');
                var value = $(this).data('value');
                $(value).removeClass('hidden');
                $(value).addClass('show');
            });
        });
    </script>
@stop