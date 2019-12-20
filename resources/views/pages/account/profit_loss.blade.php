@extends('Layout.page')
@section('head')

@stop
@section('left_content')
    @include('pages.home.left_content0')
@stop
@section('content')
    @php
        // $account_info=json_decode($account,true);
    @endphp
    <div class="account_table" style="padding-left: 10px;padding-right: 10px">
        <h1>Betting Profit and Loss</h1>
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


@stop
@section('right_content')
    @include('pages.home.right_content')
@stop
@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop