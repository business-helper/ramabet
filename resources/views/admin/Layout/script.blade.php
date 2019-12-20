<!-- Jquery Core Js -->
<script src="{{asset('user/plugins/jquery/jquery.min.js')}}"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
<!-- Bootstrap Core Js -->
<script src="{{asset('user/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
{{--<script src="{{asset('user/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>--}}

<!-- Slimscroll Plugin Js -->
<script src="{{asset('user/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
<!-- Waves Effect Plugin Js -->
<script src="{{asset('user/plugins/node-waves/waves.js')}}"></script>

<!-- Custom Js -->
<script src="{{asset('user/js/admin.js')}}"></script>
<script src="{{asset('user/js/pages/ui/notifications.js')}}"></script>

<script src="{{asset('user/js/demo.js')}}"></script>
<!-- Chart Plugins Js -->
{{--<script src="{{asset('user/plugins/flot-charts/excanvas.js')}}"></script>--}}
{{--<script src="{{asset('user/plugins/chartjs/Chart.bundle.js')}}"></script>--}}
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('user/plugins/jquery-datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

<script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>

{{--<script src="{{asset('user/js/slick.js')}}"></script>--}}
<!-- Scripts -->
<script src="{{ asset('js/jquery.ba-postmessage.js') }}"></script>
<script src="{{ asset('js/anima.js') }}"></script>
<script src="{{ asset('js/admin/app.js') }}"></script>

{{--search--}}
<script>
    function setBetSlip() {
        $('#tabs ul .betslipe_tab').addClass('active');
        $('#tabs ul .open_bets_tab').removeClass('active');
        $('#tabs .tab-content #betsipe').addClass('active');
        $('#tabs .tab-content #openbet').removeClass('active');
        $('#tabs .tab-content #betsipe').addClass('in');
        $('#tabs .tab-content #openbet').removeClass('in');
    }

    function setOpenBet() {
        $('#tabs ul .betslipe_tab').removeClass('active');
        $('#tabs ul .open_bets_tab').addClass('active');
        $('#tabs .tab-content #betsipe').removeClass('active');
        $('#tabs .tab-content #openbet').addClass('active');
        $('#tabs .tab-content #betsipe').removeClass('in');
        $('#tabs .tab-content #openbet').addClass('in');
    }
    function myajax(url,data,reload){
        $.ajax({
            url: url,
            type: 'post',
            data: {parameter:JSON.stringify(data)} ,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(response){
                //console.log(response);
                var obj = JSON.parse(response);
                console.log(obj);
                if (reload==true){
                    location.reload();
                }

            },
            error: function(response){
                console.log(response);
                //alert('error');
            }
        });
    }
    $(document).ready(function () {
        console.log('testmessage');
        window.addEventListener('message', Anima.handleTokenResponse, false);
        //console.log('user info',params);
        $("#search").on("input", function (e) {
            var input = $(this);
            var val = input.val();

            if (input.data("lastval") != val) {
                input.data("lastval", val);
                //your change action goes here
                console.log(val);
                if (val != '') {
                    $.ajax({
                        url: '{{url('api/search')}}',
                        type: 'post',
                        data: {key_word: val},
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (response) {
                            //console.log(response);
                            var obj = JSON.parse(response);
                            console.log(obj);
                            $('#searchList').html('');
                            if (obj.data.length > 0) {
                                obj.data.forEach(function (item, index) {
                                    //console.log(item);
                                    var html = '<li style="display: list-item;"><a href="https://odds24ex.com/event/detail/' + item['eventId'] + '?market_type=MATCH_ODDS' + '">' + item['teams'] + '</a></li>';
                                    $('#searchList').append(html);
                                });
                            }
                            else {
                                $('#searchList').html('');
                                var html = '<li id="noMatching" ><p class="no-matching">No events found matching ...</p></li>';
                                $('#searchList').append(html);
                            }


                        },
                        error: function (response) {
                            console.log(response);
                            //alert('error');
                        }
                    });
                }
                else {
                    $('#searchList').html('');
                    var html = '<li id="noMatching" ><p class="no-matching">No events found matching ...</p></li>';
                    $('#searchList').append(html);
                }

            }

        });
        $("#search").focusout(function () {
            //$('#searchResult').css("display", "none").fadeIn(2000);
            $('#searchResult').fadeToggle("slow");
            var inputValue = $(this).val();
            if (inputValue == "") {
                $(this).parents('.input_item').removeClass('focused');
            }
        });
        $("#search").focusin(function () {
            $("#searchResult").fadeIn(2000);
            $(this).parents('.input_item').addClass('focused');
        });
        $('.list-group-item').click(function () {
            //$(this).parents('.list-group').addClass('disappear');

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#myonoffswitch').change(function () {
            if (this.checked) {
                //Do stuff
                var div = $("#oneclick_bet_div");
                div.addClass('appear1');
                div.removeClass('disappear1');
                $("#oneclick_bet_text").css('display', 'none');
            }
            else {
                var div = $("#oneclick_bet_div");
                div.addClass('disappear1');
                div.removeClass('appear1');
                $("#oneclick_bet_text").css('display', 'block');
            }
        });
        $('#cancelall').click(function () {
            $('#bet_noti').text(0);
        });
    });
</script>
<script>

</script>
<script>
    function clearfunction(n) {
        document.getElementById('stake' + n).value = "0";
    }
</script>
<script type="text/javascript" language="javascript">

</script>

<script type="text/javascript">

</script>

