<!-- Jquery Core Js -->
<script src="{{asset('user/plugins/jquery/jquery.min.js')}}"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
<!-- Bootstrap Core Js -->
<script src="{{asset('user/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{asset('user/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{asset('user/plugins/node-waves/waves.js')}}"></script>

{{--<!-- Jquery CountTo Plugin Js -->
<script src="{{asset('user/plugins/jquery-countto/jquery.countTo.js')}}"></script>

<!-- Morris Plugin Js -->
<script src="{{asset('user/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('user/plugins/morrisjs/morris.js')}}"></script>

<!-- ChartJs -->
<script src="{{asset('user/plugins/chartjs/Chart.bundle.js')}}"></script>--}}

<!-- Flot Charts Plugin Js -->
{{--<script src="{{asset('user/plugins/flot-charts/jquery.flot.js')}}"></script>
<script src="{{asset('user/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
<script src="{{asset('user/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
<script src="{{asset('user/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
<script src="{{asset('user/plugins/flot-charts/jquery.flot.time.js')}}"></script>--}}

<!-- Sparkline Chart Plugin Js -->
{{--<script src="{{asset('user/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>--}}

<!-- Custom Js -->
<script src="{{asset('user/js/admin.js')}}"></script>
{{--<script src="{{asset('user/js/pages/index.js')}}"></script>--}}

<!-- Demo Js -->
<script src="{{asset('user/js/demo.js')}}"></script>

{{--<script src="{{asset('user/js/slick.js')}}"></script>--}}
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