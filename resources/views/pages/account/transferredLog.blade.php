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
    <h1>Transfer Statement</h1>
    <div class="account_table" style="padding-left: 10px;padding-right: 10px">
        <h1>Transfer Statement</h1>
        <table class="table table-hover">
            <thead class="table_head">
            <tr>
                <th>Date</th>
                <th>Transaction No</th>
                <th>Payment</th>
                <th>Amount</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @foreach($wallet_info as $item)
                <tr>
                    <td>{{$item->datetime}}</td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->remark}}</td>
                    <td>{{$item->change_amount}}</td>
                    <td>{{$item->after_amount}}</td>
                    {{--<td>
                        <div class="dropdown">
                            <span style="width: 100%;height: 100%"><i class="fas fa-check"></i></span>
                            <div class="dropdown-content">
                                <div><a href="{{url('account/withdraw/edit/'.Crypt::encrypt($item->no))}}">Edit </a></div>
                                <div><a href="{{url('/account/cancel/'.Crypt::encrypt($item->no))}}">Cancel </a></div>
                            </div>
                        </div>
                    </td>--}}
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