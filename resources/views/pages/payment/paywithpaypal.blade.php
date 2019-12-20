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
        @if ($message = Session::get('success'))
        <div class="w3-panel w3-green w3-display-container">
            <span onclick="this.parentElement.style.display='none'"
    				class="w3-button w3-green w3-large w3-display-topright">&times;</span>
            <p>{!! $message !!}</p>
        </div>
        <?php Session::forget('success');?>
        @endif

        @if ($message = Session::get('error'))
        <div class="w3-panel w3-red w3-display-container">
            <span onclick="this.parentElement.style.display='none'"
    				class="w3-button w3-red w3-large w3-display-topright">&times;</span>
            <p>{!! $message !!}</p>
        </div>
        <?php Session::forget('error');?>
        @endif

    	<form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form"
          action="{!! URL::to('paypal') !!}">
    	  <div class="w3-container w3-teal w3-padding-16">Paywith Paypal</div>
    	  {{ csrf_field() }}
    	  <h2 class="w3-text-blue">Payment Form</h2>
    	  <p>Demo PayPal form - Integrating paypal in laravel</p>
    	  <label class="w3-text-blue"><b>Enter Amount</b></label>
    	  <input class="w3-input w3-border" id="amount" type="text" name="amount"></p>
    	  <button class="w3-btn w3-blue">Pay with PayPal</button>
    	</form>
    </div>
</body>
</html>