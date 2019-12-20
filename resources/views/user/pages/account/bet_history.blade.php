@extends('user.Layout.page_template')

@section('head')

@stop

@section('content')
    @php
        // $account_info=json_decode($account,true);
    @endphp
    <h5>Betting History</h5>
    @php
        //var_dump($current_bet);
    @endphp
    <div class="table_div" style="padding-left: 10px;padding-right: 10px">
        <table class="table table-hover">
            <thead class="table_head">
            <tr>
                <th>Id</th>
                <th>Date</th>
                <th>Placed</th>
                <th>Odds</th>
                <th>Stake</th>
                <th>State</th>
            </tr>
            </thead>
            <tbody>
            @foreach($old_bet as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->at_update}}</td>
                    <td>{{$item->bet_type}}</td>
                    <td>{{$item->odd}}</td>
                    <td>{{$item->stake}}</td>
                    <td>{{$item->profit}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@stop
@section('script')
@stop