
<html>
<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>
</head>
<body>
<div class="w3-container">
        <form class="w3-container w3-display-middle w3-card-4 w3-padding-16" action="https://pay.skrill.com" method="post">
            <div class="w3-container w3-teal w3-padding-16">Paywith Skrill</div>
            <h2 class="w3-text-blue">Payment Form{{Auth::user()->id}}</h2>
            <p>Demo Skrill form - Integrating Skrill in laravel</p>
            <input type="hidden" name="cancel_url" value="{{url('account/summary')}}">
            <input type="hidden" name="return_url" value="{{url('account/summary')}}">
            <input type="hidden" name="logo_url" value="https://oddsexch.com/public/img/logo-skyexchange.png">
            <input type="hidden" name="pay_to_email" value="demoqco@sun-fish.com">
            <input type="hidden" name="status_url" value="{{url('skrill_state/'.Auth::user()->id)}}">
            <input type="hidden" name="language" value="EN">
            <input type="hidden" name="currency" value="USD">
            <input type="hidden" name="detail1_description" value="Description:">
            <input type="hidden" name="detail1_text" value="Romeo and Juliet (W.Shakespeare)">
            <label class="w3-text-blue"><b>Enter Amount</b></label>
            <input class="w3-input w3-border" style="margin-top: 10px;margin-bottom: 10px" type="number" name="amount" value="0">
            <input class="w3-btn w3-blue" type="submit" value="Pay with Skrill">
        </form>
</div>
</body>
</html>