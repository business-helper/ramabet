<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">


<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">


<div class="content py-5  bg-secondary" style="height: 100%">
    <div class="col-md-6 offset-md-3">
        <img src="https://odds24ex.com/public/img/logo-skyexchange.png" style="width: 100%;height: auto;"/>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <span class="anchor" id="formPayment"></span>
                <hr class="my-5">

                <!-- form card cc payment -->
                <div class="card card-outline-secondary">
                    <div class="card-body">
                        <h3 class="text-center">Request withdraw Change</h3>
                        <hr>
                        <form class="form" role="form" autocomplete="off" method="post" action= "{{ action('HomeController@withdraw_edit') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <label class="col-md-12">Amount</label>
                            </div>
                            <input type="hidden" class="form-control text-right" name="w_id" value="{{$data->no}}"/>
                            <div class="form-inline">
                                <div class="input-group" style="width: 100%">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="text" class="form-control text-right" name="amount" value="{{$data->amount}}" required disabled>
                                    <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12">Withdraw way</label>
                            </div>
                            <div class="form-inline">
                                <div class="input-group" style="width: 100%">
                                    <select id="getway" name="getway" class="form-control">
                                        <option value="paypal"{{$data->getway=='paypal'?'selected':''}} >Paypal</option>
                                        <option value="skrill"{{$data->getway=='skrill'?'selected':''}} >Skrill</option>
                                        <option value="neteller"{{$data->getway=='neteller'?'selected':''}} >Neteller</option>
                                        <option value="bitcoin"{{$data->getway=='bitcoin'?'selected':''}} >Bitcoin</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-md-12">account info</label>
                            </div>
                            <div class="form-inline">
                                <div class="input-group" style="width: 100%">
                                    <input type="text" class="form-control text-right" name="account_info" value="{{$data->account_info}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12">Description</label>
                            </div>
                            <div class="form-inline">
                                <div class="input-group" style="width: 100%">
                                    <input type="text" class="form-control text-right" name="description" value="{{$data->description}}" required>
                                </div>
                            </div>
                            @if(isset($message))
                                <div class="row" style="color: red">
                                    <label class="col-md-12">{{$message}}</label>
                                </div>
                            @endif
                            <hr>
                            <div class="form-group row">
                                <div class="col-6">
                                    <a href="{{url('account/summary')}}" class="btn btn-success btn-lg btn-block">Back</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /form card cc payment -->
            </div>
        </div>
    </div>
</div>
