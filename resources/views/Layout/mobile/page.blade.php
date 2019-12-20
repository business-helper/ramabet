<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Styles -->

    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        body{background-color: #F0ECE1;}

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .header{width: 100%;background-color: #F44336;border-color: #F44336;color: white;position: fixed;padding-top: 5px;top: 0%;height: 85px;z-index: 100;}
        .myButton {padding: 7px;width: 19.2vw;margin-right: 1.06667vw;background-image: linear-gradient(-180deg, #F72424 0%, #BB1C00 100%);border-color: #000;height: 8.53333vw; /* border: 0.26667vw solid #710B0B; */box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5);line-height: 40px;color: #fff;border-radius: 1.06667vw;margin-top: 5px;}
        .header .myButton:active {position:relative;top:1px;}
        .myButton1 {padding: 7px;width: 19.2vw;margin-right: 1.06667vw;background-image: linear-gradient(-180deg, #666666 0%, #333333 100%);border-color: #000;height: 8.53333vw; /* border: 0.26667vw solid #710B0B; */box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5);line-height: 40px;color: #fff;border-radius: 1.06667vw;margin-top: 5px;}
        .footer {width: 100%;background-color: #F44336;border-color: #F44336;color: white;position: fixed;bottom: 0%;}
        .footer div div{text-align: center;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 20%;}
        .footer div div a{color: white;}
        .footer #sports:before{content: '';position: absolute;top: -4.26667vw;width: 20%;height: 8.53333vw;background-color: #F44336;pointer-events: none;z-index: -1;left: 40%;border-radius: 50% 50% 0px 0px;}
        .content{padding-top: 60px;padding-bottom: 180px;min-height: 1000px;}
        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {  }

        .footer_active{background: #F44336;background: -moz-linear-gradient(top, #F44336 0%, #89ADA9 100%);background: -webkit-linear-gradient(top, #F44336 0%, #89ADA9 100%);background: linear-gradient(to bottom, #F44336 0%, #89ADA9 100%);}
        .active_market{background-color: #3ce97b!important;}
        .set_market{border-radius: 50%;background-color: #b9bbbe;font-size: 15px;text-align: center;width: 20px;height: 20px;}
        .black_btn{margin-right: 1.06667vw;background-image: linear-gradient(-180deg, #666666 0%, #333333 100%);border-color: #000;height: 8.53333vw; /* border: 0.26667vw solid #710B0B; */box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5); /* line-height: 8.53333vw; */color: #fff;border-radius: 5px;margin-top: 0.26667vw;}




        .table_head tr th{text-align: center;font-weight:100;}
        .selectTemp{display: flex;width: 80px;margin: auto}
        .selectTemp .left_item{background-color: #72BAEE;}
        .selectTemp .right_item{background-color: #F9A8B9;}
        .selectTemp .deactive{background-color: #ddd;}
        .selectTemp div{margin: 0;text-align: center;margin-left: 4px;cursor: pointer;width: 40px}
        .event_title{padding-left: 30px;text-align: left;}
        .event_title p{font-weight:100;color: #18191b;margin: 0;}
        .event_title .title_span{color: #2789CE;}
        .right_title{text-align: left;background-color: rebeccapurple;color: white;}
        #pathbackUI{display: flex;background-color: #212121;width: 100%;padding-left: 5px;}
        .path_item{color: #fe950e;display: flex;}
        .path_item svg{margin-top: 5px;}
        .list-group-item{padding: 0 0 0 15px!important;text-align: left;}
        .list-group a::before {content: "";position: absolute;top:30%;right: 4px;width: 9px;height: 9px;background-color: red;border-radius: 50%;}
        /*table*/
        table{background-color: white;}
        .table_div .title{padding: 10px;background-color: #284257;color: white;}
        .table_div{margin-top: 20px;}
        .table_div .table>tbody>tr>td {padding: 0!important;vertical-align: middle!important;}
        .table_div table tbody tr td .set_market{border-radius: 50%;background-color: #b9bbbe;font-size: 15px;text-align: center;width: 20px;height: 20px;}

        .table_div table tbody tr td{position: relative;}
        .table_div table tbody tr td .active_make:before{position: absolute;content: '';background-color: #81d973;border-radius: 4px;width: 8px;height: 8px;left: 10px;top: 35%;}
        .table_div table tbody tr td .deactive_make:before{position: absolute;content: '';background-color: #898989;border-radius: 4px;width: 8px;height: 8px;left: 10px;top: 35%;}
        .active1{background-color: #3c6586 !important;}
        .active2{background-color: #a4707b !important;}
        .hide{display: none;}
        /*today table*/
        .path_span{position: relative;margin-right: 20px;}
        .path_span:after{content: '';position: absolute;right: -15px;top: 20%;width: 0;height: 0;border-top: 5px solid transparent;border-left: 10px solid black;border-bottom: 5px solid transparent;}
        .table_div .title{padding: 10px;background-color: #284257;color: white;}
        /*bet slip*/
        #betSlipBoard .itemleft{width:60%;text-align: left;}
        #betSlipBoard .item20{width: 20%;text-align: center}
        #betSlipBoard .itemright{width: 20%;text-align: right}
        .backSlipHeader{background-color: #b9bbbe;}
        .bet_input{background-color: #a1cbef;}
        input[type=number]::-webkit-inner-spin-button {-webkit-appearance: none;}
        /*checkbox*/
        input[type=checkbox] + label {display: block;margin: 0.2em;cursor: pointer;padding: 0.2em;font-weight: normal;}
        input[type=checkbox] {display: none;}
        input[type=checkbox] + label:before {content: "\2714";border: 0.1em solid #000;border-radius: 0.2em;display: inline-block;width: 1em;height: 1em; /* padding-left: 0.1em; */padding-bottom: 0.4em;margin-right: 0.2em;vertical-align: bottom;color: transparent;transition: .2s;font-size: 1em;line-height: 1;margin-bottom: 2px;border-color: red;}
        input[type=checkbox] + label:active:before {transform: scale(0);}
        input[type=checkbox]:checked + label:before {background-color: MediumSeaGreen;border-color: MediumSeaGreen;color: #fff;}
        input[type=checkbox]:disabled + label:before {transform: scale(1);border-color: #aaa;}
        input[type=checkbox]:checked:disabled + label:before {transform: scale(1);background-color: #bfb;border-color: #bfb;}
        /*button*/
        .third { /* border-color: #1c4d6d; */color: #fff;box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;transition: all 150ms ease-in-out;}
        .third:hover {box-shadow: 0 0 10px 0 #3ce97b inset, 0 0 10px 4px #3ce97b;}
        .second { /* border-color: #1c4d6d; */color: #fff;box-shadow: 0 0 40px 40px #616562 inset, 0 0 0 0 #3ce97b;transition: all 150ms ease-in-out;}
        .second:hover {box-shadow: 0 0 10px 0 #e94a45 inset, 0 0 10px 4px #e94a45;}
        .row{margin: 0!important;}


        .suggestion-wrap {position: initial;z-index: 4;top: 43px;left: 10px;width: 100%;background: #fff;border-top: 1px solid #E0E6E6;border-radius: 0 0 4px 4px;box-shadow: 0 4px 4px rgba(0,0,0,0.5);box-sizing: border-box;}
        .suggestion-wrap ul {max-height: 210px;overflow: hidden;overflow-y: auto;padding-left: 0;}
        .suggestion-wrap li {height: 32px;line-height: 32px;list-style: none;text-indent: 6px;}
        .suggestion-wrap .no-matching, .suggestion-wrap p, .suggestion-wrap a {margin: 0;color: #666666;cursor: default;}
        .suggestion-wrap p, .suggestion-wrap a {color: #1E1E1E;cursor: pointer;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}

    </style>
    @yield("head")
</head>
<body style="padding: 0;">

@include("Layout.mobile.header")
<div class="text-center content">
    @yield("content")
</div>
<div class="footer">
    @include("Layout.mobile.footer")
</div>
<script>
    $('.selectTemp .betting_item').click(function () {
        //console.log(eventId);
        var runnerName=$(this).children('#runnerName').val();
        var runnerId=$(this).children('#runnerId').val();
        var eventId=$(this).children('#eventId').val();
        var odd=$(this).children('#odd').val();
        var market_type=$(this).children('#market_type').val();
        var market_name=$(this).children('#market_name').val();
        var teams=$(this).children('#teams').val();
        var bet_type=$(this).children('#bet_type').val();
        console.log(eventId);
        $('#myModal').modal();
        var uid='{!!isset(Auth::user()->id)?Auth::user()->id:0!!}';
        $('#myModal #eventId').val(eventId);
        $('#myModal #runnerId').val(runnerId);
        $('#myModal #market_type').val(market_type);
        $('#myModal #bet_type').val(bet_type);
        $('#myModal #market_name').val(market_name);
        $('#myModal #runnerName').val(runnerName);
        $('#myModal #teams').val(teams);
        $('#myModal #runner_name').text(runnerName);

        $('#myModal #odds').val(odd);
        $('#myModal #stake').val('100');
        if (bet_type=='availableToBack'){
            bet_type_name='(Bet For)';
            backgraoud_col='#72BAEE';
        }
        else{
            bet_type_name='(Bet Against)';
            backgraoud_col='#F9A8B9';
        }
        $('#myModal .modal-content').css('background-color',backgraoud_col);
        $( ".odds" ).on("change paste keyup", function() {
            //console.log( $(this).val() );
            var stack=$(this).parents().children('.item20').children('.stake').val();
            $(this).parents().children('.itemright').children('.price').text(($(this).val()*stack).toFixed(2));
            calctotalprice();

        });
        $( ".stake" ).on("change paste keyup", function() {
            //console.log( $(this).val() );
            var odds=$(this).parents().children('.item20').children('.odds').val();
            $(this).parents().children('.itemright').children('.price').text(($(this).val()*odds).toFixed(2));
            calctotalprice();
        });

        //console.log($('#betSlipBoard').children().length);

    });

    //place bet
    $('#placebets').click(function () {
        //alert('d');
        if($('#confirm').prop("checked") == true){
            //alert("Checkbox is checked.");
            var sum=0.0;
            var senddata=[];
            var odds=$('#myModal #odds').val();
            var stake=$('#myModal #stake').val();
            var price=(odds*stake).toFixed(2);
            sum+=parseFloat(price);
            var data={};
            var eventId=$('#myModal #eventId').val();
            var runnerId=$('#myModal #runnerId').val();
            var market_type=$('#myModal #market_type').val();
            var bet_type=$('#myModal #bet_type').val();
            var market_name=$('#myModal #market_name').val();
            var runnerName=$('#myModal #runnerName').val();
            var teams=$('#myModal #teams').val();
            data['eventId']=eventId;
            data['runnerId']=runnerId;
            data['market_type']=market_type;
            data['bet_type']=bet_type;
            data['market_name']=market_name;
            data['runnerName']=runnerName;
            data['teams']=teams;
            data['odd']=odds;
            data['stake']=stake;
            data['price']=price;
            senddata.push(data);
            console.log(senddata);
            var uid='{!!isset(Auth::user()->id)?Auth::user()->id:0!!}';
            if (uid){
                $.ajax({
                    url: '{{url("/api/addBetting")}}',
                    type: 'post',
                    data: { data:senddata,userid:uid} ,
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function(response){
                        //console.log(response);
                        var obj = JSON.parse(response);
                        alert(obj.message);
                        location.reload();
                        $('#charge_dlg').modal('toggle');
                        console.log(obj);
                        $('#betSlipBoard').html('');


                    },
                    error: function(response){
                        console.log(response);
                        //alert('error');
                    }
                });
            }
            else{
                alert('Please Login');
            }
            //
            $('#total_price').text(sum.toFixed(2));
        }
        else{
            alert("Please confirm your bets.");
        }
    });
    $('#cancelall').click(function () {
        $('#myModal').modal('toggle');

    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#preloader').css('display','none');
    });
    function getFixure(id) {
        alert(id);
    }
    //////////////////////////////
    function getLeague(id,body) {
        //alert(id);
        //console.log(body);
        $('.list-group').html('');
        for (var i=0;i<body.length;i++){
            var league = JSON.parse(body[i]['league']);
            //var participants=JSON.parse(body[i]['Participants']);
            //console.log(participants);

            if (league['id']==id){
                //console.log(body[i]['Fixture']['Participants']);
                $('.list-group').append('<a href="{{url('/event/detail')}}/' +
                    body[i]['id']+
                    '" class="list-group-item">' +JSON.parse(body[i]['home'])['name']+' v ' +
                    JSON.parse(body[i]['away'])['name']+
                    ' </a>');

            }
        }
    }
    function getDetail(fixtureid) {
        //alert(fixtureid);
    }
    //    refresh
    $(document).ready(function() {
        setInterval(oddFresh, 5000);
        oddFresh();
        function oddFresh() {
            ///alert('sdf');
            $.ajax({
                url: 'https://odds24ex.com/api/oddFresh',
                type: 'post',
                data: {},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //console.log(response);
                    var obj = JSON.parse(response);
                    //console.log(obj);
                    var notification = obj.data;
                    for (var i = 0; i < notification.length; i++) {
                        if ($('#' + notification[i].id).length)         // use this if you are using
                        {
                            //console.log(notification[i].value);

                            if (parseFloat($('#' + notification[i].id +' p').text()) != parseFloat(notification[i].value.price)) {
                                $('#' + notification[i].id + ' p').text(notification[i].value.price);
                                $('#' + notification[i].id +' span').val(notification[i].value.size);
                                $('#' + notification[i].id).fadeToggle(500);
                                $('#' + notification[i].id).fadeToggle(500);
                                $('#' + notification[i].id).fadeToggle(500);
                                $('#' + notification[i].id).fadeToggle(500);
                                $('#' + notification[i].id).fadeToggle(500);
                                $('#' + notification[i].id).fadeToggle(500);
                            }
                        }
                        else{
                            console.log('no');
                            //console.log(notification[i].id);
                        }
                    }


                },
                error: function (response) {
                    console.log(response);
                    //alert('error');
                }
            });


        }
    });

</script>
<script type="text/javascript">
    $('.refresh').click(function () {
        location.reload();
    });
    $(document).ready(function() {
        setInterval(getNotification, 5000);
        getNotification();
        function getNotification() {
            ///alert('sdf');
            var user_id='{{isset(auth()->user()->id)?auth()->user()->id:''}}';
            $.ajax({
                url: 'https://odds24ex.com/api/getNotification_user',
                type: 'post',
                data: {user_id:user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //console.log(response);
                    var obj = JSON.parse(response);
                    //console.log(obj);

                    if (obj.data.length==0){
                        $('#noti_count').css('color','white');
                        $('#noti_count .notification_count').text('');
                    }
                    else {
                        $('#noti_count .notification_count').text(obj.data.length);
                        $('#noti_count').css('color','red');
                    }
                    $('#notification').html('');
                    obj.data.forEach(function(item, index) {
                        //console.log(item);
                        var html='<li id="'+item['id']+'" style="display: list-item" class="noti_item">' +
                            '<a href="'+item['data']['content']['link']+'">' +
                            '<span class="notification-date">' +item['data']['repliedTime']['date']+
                            '</span>' +
                            '<p>' +item['data']['content']['message']+
                            '</p>' +
                            '</a>' +
                            '</li>';
                        $('#notification').append(html);
                        $('.noti_item').click(function () {
                            var id = $(this).attr("id");
                            console.log(id);
                            $.get('/markAsRead/'+id);
                        });
                    });

                },
                error: function (response) {
                    console.log(response);
                    //alert('error');
                }
            });


        }
        //GMT time setting
        setInterval(getTime, 1000);
        function getTime() {
            var today = new Date();
            var str = today.toGMTString();  // deprecated! use toUTCString()
            $('#gmt_time').text(str);
        }

        //console.log(str);
    });

</script>
{{--virtural keyboard--}}
<script>
    $(function() {

        // $('textarea').focus();

        var $caps = $('.capslock'),
            $char = $('.char');

        $caps.click(function() {
            if($caps.hasClass('on')) {
                $('.char,.capslock').each(function() {
                    $(this).text($(this).text().toLowerCase());
                });
                $caps.removeClass('on');

            } else {
                $('.char,.capslock').each(function() {
                    $(this).text($(this).text().toUpperCase());
                });
                $caps.addClass('on');
            }
        });

        $('li').click(function() {
            var t = this;
            $(this).addClass('touch');
            setTimeout(function() {
                $(t).removeClass('touch');
            },100);
        });

        var lastFocus,
            selectionStart,
            selectionEnd;

        $('textarea,input').on('focus', function() {
            $('textarea,input').removeClass('focus');
            $(this).addClass('focus');
        });

        $('textarea,input').on('blur', function() {
            lastFocus = this;
            selStart = this.selectionStart;
            selEnd = this.selectionEnd;
        });

        $('.char').click(function() {
            var char = $(this).text();
            sendChar(char);
        });

        $('.return').click(function() {
            sendChar('\n');
        });

        $('.space').click(function() {
            sendChar(' ');
        });

        $('.backspace').click(function() {
            backspace();
        });

        $('.string').click(function() {
            var char = $(this).text();
            sendString(char);
        });

        function sendString(char) {
            var orig = $(lastFocus).val();
            var updated =  char;
            $(lastFocus).val(updated);
            //console.log(orig.length);
            selEnd=selStart+char.length;

            $(lastFocus).focus();
            lastFocus.selectionStart = selEnd;
            lastFocus.selectionEnd = selEnd;
        }

        function backspace() {
            var orig = $(lastFocus).val();
            var updated = orig.substring(0, selStart-1) + orig.substring(selEnd, orig.length);
            $(lastFocus).val(updated);
            selEnd = --selStart;
            $(lastFocus).focus();
            lastFocus.selectionStart = selStart;
            lastFocus.selectionEnd = selEnd;
        }

        function sendChar(char) {
            var orig = $(lastFocus).val();
            var updated =  orig.substring(0, selStart) + char + orig.substring(selEnd, orig.length);
            $(lastFocus).val(updated);
            //console.log(orig.length);
            selEnd=selStart+char.length;

            $(lastFocus).focus();
            lastFocus.selectionStart = selEnd;
            lastFocus.selectionEnd = selEnd;
        };


    });
    function change_value(id,flag,step) {
        var value;
        if ($('#'+id).val()==''){
            value=0;
        }
        else{
            value=parseFloat($('#'+id).val());
        }
        switch (flag) {
            case 'in':
                $('#'+id).val(parseFloat(parseFloat(value)+parseFloat(step)).toFixed(2));
                break;
            case  'de':
                $('#'+id).val(parseFloat(parseFloat(value)-parseFloat(step)).toFixed(2));
                break;
        };
        $('#'+id).focus();
    }
    //document.getElementById("keyboard").focus();
    $('.set_market').click(function () {
        var event_id=$(this).attr("id").split("_")[0];
        var state='';
        var market_type='MATCH_ODDS';
        if ($(this).hasClass('active_market')) {
            $(this).removeClass('active_market');
            state='true';
        }
        else{
            $(this).addClass('active_market');
            state='false';
        }
        var uid='{!!isset(Auth::user()->id)?Auth::user()->id:0!!}';
        if (uid) {
            $.ajax({
                url: 'https://odds24ex.com/api/addMarket',
                type: 'post',
                data: {event_id: event_id, state: state,user_id:uid,market_type:market_type},

                success: function (response) {
                    var obj = JSON.parse(response);
                    console.log(obj);
                },
                error: function (response) {
                    alert('error');
                    console.log(response);
                    //alert('error');
                }
            });
        }
        else {
            alert('Please Login');
        }
    });
</script>
{{--search--}}
<script>
    $("#search").on("input", function(e) {
        var input = $(this);
        var val = input.val();

        if (input.data("lastval") != val) {
            input.data("lastval", val);
            //your change action goes here
            console.log(val);
            if (val!=''){
                $.ajax({
                    url: '{{url('api/search')}}',
                    type: 'post',
                    data: {key_word:val},
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (response) {
                        //console.log(response);
                        var obj = JSON.parse(response);
                        console.log(obj);
                        $('#searchList').html('');
                        if (obj.data.length>0){
                            obj.data.forEach(function(item, index) {
                                //console.log(item);
                                var html='<li style="display: list-item;"><a href="https://odds24ex.com/mobile/event/detail/'+item['eventId']+'?market_type=MATCH_ODDS'+'">'+item['teams']+'</a></li>';
                                $('#searchList').append(html);
                            });
                        }
                        else{
                            $('#searchList').html('');
                            var html='<li id="noMatching" ><p class="no-matching">No events found matching ...</p></li>';
                            $('#searchList').append(html);
                        }


                    },
                    error: function (response) {
                        console.log(response);
                        //alert('error');
                    }
                });
            }
            else{
                $('#searchList').html('');
                var html='<li id="noMatching" ><p class="no-matching">No events found matching ...</p></li>';
                $('#searchList').append(html);
            }

        }

    });
    $("#search").focusout(function(){
        $('#searchResult').fadeToggle("slow");;
    });
    $("#search").focusin(function(){
        $("#searchResult").fadeIn(2000);
    });
</script>
@yield("script")
</body>
</html>
