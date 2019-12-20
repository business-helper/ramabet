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


    <div class="row" style="margin: 10px">
        <h1>Summary</h1>
        <div class="col-md-4 col-sm-12" style="background-color: white;height: 100px">
            <h4>Your Balances</h4>
            <span style="font-size: 3rem;color: #3f9ae5;">{{$wallet}}</span>
            <span style="font-size: 2.5rem">$</span>
        </div>
        <div class="col-md-8 col-sm-12" style="background-color: white;height: 100px">
            <h4>Welcome</h4>
            <span>View your account details here. You can manage funds, review and change your setting and see the performance of your betting activity.</span>
        </div>
    </div>
    <div class="row" style="text-align: center;">
        <div class="dropdown col-sm-5" >
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Deposit by ...
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="{{'/paywithskrill'}}">skrill/neteller/bitcoin</a></li>
                {{--<li><a href="#">neteller</a></li>--}}
                <li><a href="{{url('/paywithpaypal')}}">paypal</a></li>
                {{--<li><a href="#">bitcoin</a></li>--}}
            </ul>
        </div>
        <div class="dropdown col-sm-5">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Withdraw by ...
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="{{url('account/withdraw/skrill')}}">skrill</a></li>
                <li><a href="{{url('account/withdraw/neteller')}}">neteller</a></li>
                <li><a href="{{url('account/withdraw/paypal')}}">paypal</a></li>
                <li><a href="{{url('account/withdraw/bitcoin')}}">bitcoin</a></li>
            </ul>
        </div>
    </div>
    <div class="account_table" style="padding-left: 10px;padding-right: 10px">
        {{--<div class="title">About You</div>--}}
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