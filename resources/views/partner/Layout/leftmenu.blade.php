<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        {{--<div class="sidebar-header">
            <a href="{{url('/admin/dashboard')}}"><img style="height: 50px;padding: 5px;" class="main-logo" src="{{asset('/img/logo-skyexchange.png')}}" alt="" /></a>
            <strong><a href="{{url('/admin/dashboard')}}"><img src="{{asset('/img/logo-skyexchange.png')}}" alt="" /></a></strong>
        </div>--}}
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li class="">
                        <a  href="{{url('admin/dashboard')}}">
                            <span class="icon-wrap"><i class="fas fa-home"></i></span>
                            <span class="mini-click-non">Dashboard</span>
                        </a>

                    </li>
                    <li id="master">
                        <a title="Master" class="has-arrow" href="all-professors.html" aria-expanded="false">
                            <span class="icon-wrap">
                                <i class="fas fa-user-secret"></i>
                            </span> <span class="mini-click-non">Master</span></a>
                        <ul class="submenu-angle" aria-expanded="false">

                            <li id="balance"><a title="Sports List" href="{{url('admin/master/balance')}}"><span class="mini-sub-pro">Balance</span></a></li>
                            <li id="import_rate"><a title="Bet List" href="{{url('admin/master/import_rate')}}"><span class="mini-sub-pro">Import Rate</span></a></li>

                            <li id="detail"><a title="Bet List" href="{{url('admin/master/detail')}}"><span class="mini-sub-pro">News</span></a></li>
                            <li id="commentary"><a title="Bet List" href="{{url('admin/master/commentary')}}"><span class="mini-sub-pro">Commentary</span></a></li>
                            {{--<li><a title="Edit Professor" href="edit-professor.html"><span class="mini-sub-pro">Edit SubAdmin</span></a></li>
                            <li><a title="Professor Profile" href="professor-profile.html"><span class="mini-sub-pro">SubAdmin Profile</span></a></li>--}}
                        </ul>
                    </li>
                    <li id="client_list">
                        <a title="Master" class="has-arrow" href="all-professors.html" aria-expanded="false">
                            <span class="icon-wrap">
                                <i class="fas fa-list-ul"></i>
                            </span> <span class="mini-click-non">ClientList</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            @if(Auth::user('admin')->is_super==0)
                                <li id="master_item"><a title="Sports List" href="{{url('admin/client/master')}}"><span class="mini-sub-pro">Masters</span></a></li>
                            @endif
                            @if(Auth::user('admin')->is_super==0 || Auth::user('admin')->is_super==1)
                                <li id="distributor_item"><a title="Bet List" href="{{url('admin/client/distributor')}}"><span class="mini-sub-pro">Distributors</span></a></li>
                            @endif
                            <li id="client_list"><a title="Bet List" href="{{url('admin/client/client')}}"><span class="mini-sub-pro">Clients</span></a></li>
                        </ul>
                    </li>
                    <li id="Event">
                        <a class="has-arrow" href="all-professors.html" aria-expanded="false"><span class="icon-wrap"><i class="fa fa-futbol-o" ></i></span> <span class="mini-click-non">Event</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li id="pre_event">
                                <a title="PreEvent" href="{{url('admin/pre_event/1')}}" aria-expanded="false"><span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span> <span class="mini-click-non">PreEvent</span></a>
                            </li>
                            <li id="live_event">
                                <a title="Live Event" href="{{url('admin/live_event/1')}}" aria-expanded="false"><span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span> <span class="mini-click-non">LiveEvent</span></a>
                            </li>
                        </ul>
                    </li>
                    @if(auth('admin')->user()->is_super==0)
                    <li id="subadmin">
                        <a class="has-arrow" href="all-professors.html" aria-expanded="false"><span class="icon-wrap"><i class="fas fa-user-tie"></i></span> <span class="mini-click-non">SubAdmin</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li id="all_subadmin"><a title="All Professors" href="{{url('admin/all_subadmin')}}"><span class="mini-sub-pro">All SubAdmin</span></a></li>
                            <li id="add_subadmin"><a title="Add Subadmin" href="{{url('admin/add_subadmin')}}"><span class="mini-sub-pro">Add SubAdmin</span></a></li>
                            {{--<li><a title="Edit Professor" href="edit-professor.html"><span class="mini-sub-pro">Edit SubAdmin</span></a></li>
                            <li><a title="Professor Profile" href="professor-profile.html"><span class="mini-sub-pro">SubAdmin Profile</span></a></li>--}}
                        </ul>
                    </li>
                    @endif
                    <li id="player">
                        <a class="has-arrow" href="all-students.html" aria-expanded="false"><span class="icon-wrap"><i class="fas fa-users"></i></span> <span class="mini-click-non">Players</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li id="all_player"><a title="All Player" href="{{route('admin.all_player')}}"><span class="mini-sub-pro">All Players</span></a></li>
                            <li><a title="Add Player" href="{{route('admin.add_player')}}"><span class="mini-sub-pro">Add Players</span></a></li>
                            {{--<li><a title="Edit Students" href="edit-student.html"><span class="mini-sub-pro">Edit Players</span></a></li>--}}
                            {{--<li><a title="Students Profile" href="student-profile.html"><span class="mini-sub-pro">Players Profile</span></a></li>--}}
                        </ul>
                    </li>
                    <li id="betting">
                        <a class="has-arrow" href="all-professors.html" aria-expanded="false">
                            <span class="icon-wrap">
                                <i class="fas fa-thumbs-up"></i>
                            </span> <span class="mini-click-non">Betting</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li id="sports_list"><a title="Sports List" href="{{url('admin/betting/sports_list')}}"><span class="mini-sub-pro">Sports List</span></a></li>
                            <li id="bet_list"><a title="Bet List" href="{{url('admin/betting/bet_list')}}"><span class="mini-sub-pro">Bet List</span></a></li>
                            <li id="tournament_list"><a title="Bet List" href="{{url('admin/betting/tournament_list')}}"><span class="mini-sub-pro">Tournament List</span></a></li>
                            {{--<li><a title="Edit Professor" href="edit-professor.html"><span class="mini-sub-pro">Edit SubAdmin</span></a></li>
                            <li><a title="Professor Profile" href="professor-profile.html"><span class="mini-sub-pro">SubAdmin Profile</span></a></li>--}}
                        </ul>
                    </li>
                    <li id="payment_history">
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="icon-wrap"><i class="fas fa-money-check-alt"></i></span> <span class="mini-click-non">Payment Situation</span></a>
                        <ul class="submenu-angle form-mini-nb-dp" aria-expanded="false">
                            <li id="deposit_history"><a title="Basic Form Elements" href="{{route('admin.deposit_history')}}"><span class="mini-sub-pro">Deposit History</span></a></li>
                            <li id="request_withdraw"><a title="Advance Form Elements" href="{{route('admin.withdraw_request')}}"><span class="mini-sub-pro">Request Withdraw</span></a></li>
                            {{--<li id="withdraw_history"><a title="Password Meter" href="admin.withdraw_history"><span class="mini-sub-pro">Withdraw  History</span></a></li>--}}
                            {{--<li><a title="Multi Upload" href="multi-upload.html"><span class="mini-sub-pro">Multi Upload</span></a></li>--}}
                            {{--<li><a title="Text Editor" href="tinymc.html"><span class="mini-sub-pro">Text Editor</span></a></li>--}}
                            {{--<li><a title="Dual List Box" href="dual-list-box.html"><span class="mini-sub-pro">Dual List Box</span></a></li>--}}
                        </ul>
                    </li>
                    <li id="setting">
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="icon-wrap"><i class="fas fa-tools"></i></span> <span class="mini-click-non">Setting</span></a>
                        <ul class="submenu-angle form-mini-nb-dp" aria-expanded="false">
                            <li id="general_setting"><a title="Basic Form Elements" href="{{route('admin.general_setting')}}">
                                    <span class="mini-sub-pro">General Setting</span>
                                </a>
                            </li>
                            <li id="customize_like_setting"><a title="Link List" href="{{route('admin.customize_like_setting')}}">
                                    <span class="mini-sub-pro">Link List</span>
                                </a>
                            </li>
                            {{--<li id="withdraw_history"><a title="Password Meter" href="admin.withdraw_history"><span class="mini-sub-pro">Withdraw  History</span></a></li>--}}
                            {{--<li><a title="Multi Upload" href="multi-upload.html"><span class="mini-sub-pro">Multi Upload</span></a></li>--}}
                            {{--<li><a title="Text Editor" href="tinymc.html"><span class="mini-sub-pro">Text Editor</span></a></li>--}}
                            {{--<li><a title="Dual List Box" href="dual-list-box.html"><span class="mini-sub-pro">Dual List Box</span></a></li>--}}
                        </ul>
                    </li>
                    {{--<li>
                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><span class="educate-icon educate-course icon-wrap"></span> <span class="mini-click-non">Courses</span></a>
                    <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="All Courses" href="all-courses.html"><span class="mini-sub-pro">All Courses</span></a></li>
                    <li><a title="Add Courses" href="add-course.html"><span class="mini-sub-pro">Add Course</span></a></li>
                    <li><a title="Edit Courses" href="edit-course.html"><span class="mini-sub-pro">Edit Course</span></a></li>
                    <li><a title="Courses Profile" href="course-info.html"><span class="mini-sub-pro">Courses Info</span></a></li>
                    <li><a title="Product Payment" href="course-payment.html"><span class="mini-sub-pro">Courses Payment</span></a></li>
                    </ul>
                    </li>
                    <li>
                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><span class="educate-icon educate-library icon-wrap"></span> <span class="mini-click-non">Library</span></a>
                    <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="All Library" href="library-assets.html"><span class="mini-sub-pro">Library Assets</span></a></li>
                    <li><a title="Add Library" href="add-library-assets.html"><span class="mini-sub-pro">Add Library Asset</span></a></li>
                    <li><a title="Edit Library" href="edit-library-assets.html"><span class="mini-sub-pro">Edit Library Asset</span></a></li>
                    </ul>
                    </li>
                    <li>
                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><span class="educate-icon educate-department icon-wrap"></span> <span class="mini-click-non">Departments</span></a>
                    <ul class="submenu-angle" aria-expanded="false">
                    <li><a title="Departments List" href="departments.html"><span class="mini-sub-pro">Departments List</span></a></li>
                    <li><a title="Add Departments" href="add-department.html"><span class="mini-sub-pro">Add Departments</span></a></li>
                    <li><a title="Edit Departments" href="edit-department.html"><span class="mini-sub-pro">Edit Departments</span></a></li>
                    </ul>
                    </li>--}}
                    {{--<li>
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="educate-icon educate-message icon-wrap"></span> <span class="mini-click-non">Mailbox</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="Inbox" href="mailbox.html"><span class="mini-sub-pro">Inbox</span></a></li>
                            <li><a title="View Mail" href="mailbox-view.html"><span class="mini-sub-pro">View Mail</span></a></li>
                            <li><a title="Compose Mail" href="mailbox-compose.html"><span class="mini-sub-pro">Compose Mail</span></a></li>
                        </ul>
                    </li>--}}
                    {{--<li>
                    <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="educate-icon educate-interface icon-wrap"></span> <span class="mini-click-non">Interface</span></a>
                    <ul class="submenu-angle interface-mini-nb-dp" aria-expanded="false">
                    <li><a title="Google Map" href="google-map.html"><span class="mini-sub-pro">Google Map</span></a></li>
                    <li><a title="Data Maps" href="data-maps.html"><span class="mini-sub-pro">Data Maps</span></a></li>
                    <li><a title="Pdf Viewer" href="pdf-viewer.html"><span class="mini-sub-pro">Pdf Viewer</span></a></li>
                    <li><a title="X-Editable" href="x-editable.html"><span class="mini-sub-pro">X-Editable</span></a></li>
                    <li><a title="X-Editable" href="x-editable.html"><span class="mini-sub-pro">X-Editable</span></a></li>
                    <li><a title="Code Editor" href="code-editor.html"><span class="mini-sub-pro">Code Editor</span></a></li>
                    <li><a title="Tree View" href="tree-view.html"><span class="mini-sub-pro">Tree View</span></a></li>
                    <li><a title="Preloader" href="preloader.html"><span class="mini-sub-pro">Preloader</span></a></li>
                    <li><a title="Images Cropper" href="images-cropper.html"><span class="mini-sub-pro">Images Cropper</span></a></li>
                    </ul>
                    </li>--}}
                    {{--<li>
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="educate-icon educate-charts icon-wrap"></span> <span class="mini-click-non">Charts</span></a>
                        <ul class="submenu-angle chart-mini-nb-dp" aria-expanded="false">
                            <li><a title="Bar Charts" href="bar-charts.html"><span class="mini-sub-pro">Bar Charts</span></a></li>
                            <li><a title="Line Charts" href="line-charts.html"><span class="mini-sub-pro">Line Charts</span></a></li>
                            <li><a title="Area Charts" href="area-charts.html"><span class="mini-sub-pro">Area Charts</span></a></li>
                            <li><a title="Rounded Charts" href="rounded-chart.html"><span class="mini-sub-pro">Rounded Charts</span></a></li>
                            <li><a title="C3 Charts" href="c3.html"><span class="mini-sub-pro">C3 Charts</span></a></li>
                            <li><a title="Sparkline Charts" href="sparkline.html"><span class="mini-sub-pro">Sparkline Charts</span></a></li>
                            <li><a title="Peity Charts" href="peity.html"><span class="mini-sub-pro">Peity Charts</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="educate-icon educate-data-table icon-wrap"></span> <span class="mini-click-non">Data Tables</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="Peity Charts" href="static-table.html"><span class="mini-sub-pro">Static Table</span></a></li>
                            <li><a title="Data Table" href="data-table.html"><span class="mini-sub-pro">Data Table</span></a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow" href="mailbox.html" aria-expanded="false"><span class="educate-icon educate-apps icon-wrap"></span> <span class="mini-click-non">App views</span></a>
                        <ul class="submenu-angle app-mini-nb-dp" aria-expanded="false">
                            <li><a title="Notifications" href="notifications.html"><span class="mini-sub-pro">Notifications</span></a></li>
                            <li><a title="Alerts" href="alerts.html"><span class="mini-sub-pro">Alerts</span></a></li>
                            <li><a title="Modals" href="modals.html"><span class="mini-sub-pro">Modals</span></a></li>
                            <li><a title="Buttons" href="buttons.html"><span class="mini-sub-pro">Buttons</span></a></li>
                            <li><a title="Tabs" href="tabs.html"><span class="mini-sub-pro">Tabs</span></a></li>
                            <li><a title="Accordion" href="accordion.html"><span class="mini-sub-pro">Accordion</span></a></li>
                        </ul>
                    </li>
                    <li id="removable">
                        <a class="has-arrow" href="#" aria-expanded="false"><span class="educate-icon educate-pages icon-wrap"></span> <span class="mini-click-non">Pages</span></a>
                        <ul class="submenu-angle page-mini-nb-dp" aria-expanded="false">
                            <li><a title="Login" href="login.html"><span class="mini-sub-pro">Login</span></a></li>
                            <li><a title="Register" href="register.html"><span class="mini-sub-pro">Register</span></a></li>
                            <li><a title="Lock" href="lock.html"><span class="mini-sub-pro">Lock</span></a></li>
                            <li><a title="Password Recovery" href="password-recovery.html"><span class="mini-sub-pro">Password Recovery</span></a></li>
                            <li><a title="404 Page" href="404.html"><span class="mini-sub-pro">404 Page</span></a></li>
                            <li><a title="500 Page" href="500.html"><span class="mini-sub-pro">500 Page</span></a></li>
                        </ul>
                    </li>--}}
                </ul>
            </nav>
        </div>
    </nav>
</div>