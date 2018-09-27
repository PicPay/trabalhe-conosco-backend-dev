<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
        | Admire
        @show
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('assets/img/logo1.ico')}}"/>
    <!-- global styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/components.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/custom.css')}}"/>
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <!-- end of global styles-->
    @yield('header_styles')
</head>

<body class="fixedMenu_left fixedNav_position">
<div class="preloader" style=" position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 100000;
  backface-visibility: hidden;
  background: #ffffff;">
    <div class="preloader_img" style="width: 200px;
  height: 200px;
  position: absolute;
  left: 48%;
  top: 48%;
  background-position: center;
z-index: 999999">
        <img src="{{asset('assets/img/loader.gif')}}" style=" width: 40px;" alt="loading...">
    </div>
</div>
<div id="wrap">
    <div id="top" class="fixed">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid m-0">
                <a class="navbar-brand" href="index">
                    <h4><img src="{{asset('assets/img/logo1.ico')}}" class="admin_img" alt="logo"> ADMIRE ADMIN</h4>
                </a>
                <div class="menu mr-sm-auto">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
                <div class="top_search_box d-none d-md-flex">
                    <form class="header_input_search">
                        <input type="text" placeholder="Search" name="search">
                        <button type="submit">
                            <span class="font-icon-search"></span>
                        </button>
                        <div class="overlay"></div>
                    </form>
                </div>
                <div class="topnav dropdown-menu-right">
                    <div class="btn-group small_device_search" data-toggle="modal"
                         data-target="#search_modal">
                        <i class="fa fa-search text-primary"></i>
                    </div>
                    <div class="btn-group">
                        <div class="notifications no-bg">
                            <a class="btn btn-default btn-sm messages" data-toggle="dropdown" id="messages_section"> <i
                                    class="fa fa-envelope-o fa-1x"></i>
                                <span class="badge badge-pill badge-warning notifications_badge_top">8</span>
                            </a>
                            <div class="dropdown-menu drop_box_align" role="menu" id="messages_dropdown">
                                <div class="popover-header">You have 8 Messages</div>
                                <div id="messages">
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/5.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data"><strong>hally</strong>
                                                sent you an image.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/8.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data"><strong>Meri</strong>
                                                invitation for party.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/7.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <strong>Remo</strong>
                                                meeting details .
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/6.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <strong>David</strong>
                                                upcoming events list.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/5.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data"><strong>hally</strong>
                                                sent you an image.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/8.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data"><strong>Meri</strong>
                                                invitation for party.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/7.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <strong>Remo</strong>
                                                meeting details .
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/6.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <strong>David</strong>
                                                upcoming events list.
                                                <br>
                                                <small>add to timeline</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="popover-footer">
                                    <a href="mail_inbox" class="text-white">Inbox</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="notifications messages no-bg">
                            <a class="btn btn-default btn-sm" data-toggle="dropdown" id="notifications_section"> <i
                                    class="fa fa-bell-o"></i>
                                <span class="badge badge-pill badge-danger notifications_badge_top">9</span>
                            </a>
                            <div class="dropdown-menu drop_box_align" role="menu" id="notifications_dropdown">
                                <div class="popover-header">You have 9 Notifications</div>
                                <div id="notifications">
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/1.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>Remo</strong>
                                                sent you an image
                                                <br>
                                                <small class="primary_txt">just now.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/2.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>clay</strong>
                                                business propasals
                                                <br>
                                                <small class="primary_txt">20min Back.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/3.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>John</strong>
                                                meeting at Ritz
                                                <br>
                                                <small class="primary_txt">2hrs Back.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/6.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>Luicy</strong>
                                                Request Invitation
                                                <br>
                                                <small class="primary_txt">Yesterday.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/1.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>Remo</strong>
                                                sent you an image
                                                <br>
                                                <small class="primary_txt">just now.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/2.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>clay</strong>
                                                business propasals
                                                <br>
                                                <small class="primary_txt">20min Back.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/3.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>John</strong>
                                                meeting at Ritz
                                                <br>
                                                <small class="primary_txt">2hrs Back.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/6.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>Luicy</strong>
                                                Request Invitation
                                                <br>
                                                <small class="primary_txt">Yesterday.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('assets/img/mailbox_imgs/1.jpg')}}" class="message-img avatar rounded-circle"
                                                     alt="avatar1"></div>
                                            <div class="col-10 message-data">
                                                <i class="fa fa-clock-o"></i>
                                                <strong>Remo</strong>
                                                sent you an image
                                                <br>
                                                <small class="primary_txt">just now.</small>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="popover-footer">
                                    <a href="#" class="text-white">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="notifications request_section no-bg">
                            <a class="btn btn-default btn-sm messages" id="request_btn"> <i
                                    class="fa fa-sliders" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="user-settings no-bg">
                            <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                                <img src="{{asset('assets/img/admin.jpg')}}" class="admin_img2 img-thumbnail rounded-circle avatar-img"
                                     alt="avatar"> <strong>Micheal</strong>
                                <span class="fa fa-sort-down white_bg"></span>
                            </button>
                            <div class="dropdown-menu admire_admin">
                                <a class="dropdown-item title" href="#">
                                    Admire Admin</a>
                                <a class="dropdown-item" href="edit_user"><i class="fa fa-cogs"></i>
                                    Account Settings</a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user"></i>
                                    User Status
                                </a>
                                <a class="dropdown-item" href="mail_inbox"><i class="fa fa-envelope"></i>
                                    Inbox</a>

                                <a class="dropdown-item" href="lockscreen"><i class="fa fa-lock"></i>
                                    Lock Screen</a>
                                <a class="dropdown-item" href="login2"><i class="fa fa-sign-out"></i>
                                    Log Out</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- /.navbar -->
        <!-- /.head -->
    </div>
    <!-- /#top -->
    <div class="wrapper fixedNav_top">
        <div id="left" class="fixed">
            <div class="menu_scroll left_scrolled">
                <div class="left_media">
                    <div class="media user-media">
                        <div class="user-media-toggleHover">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="user-wrapper">
                            <a class="user-link" href="#">
                                <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture"
                                     src="{{asset('assets/img/admin.jpg')}}">
                                <p class="user-info menu_hide">Welcome Micheal</p>
                            </a>
                        </div>
                    </div>
                    <hr/>
                </div>
                <ul id="menu">
                    <li {!! (Request::is('index1')? 'class="active"':"") !!}>
                    <a href="{{ URL::to('index1') }} ">
                        <i class="fa fa-home"></i>
                        <span class="link-title menu_hide">&nbsp;&nbsp;Dashboard 1</span>
                    </a>
                    </li>
                    <li {!! (Request::is('index')? 'class="active"':"") !!}>
                    <a href="{{ URL::to('index') }} ">
                        <i class="fa fa-tachometer"></i>
                        <span class="link-title menu_hide">&nbsp;Dashboard 2
                            </span>
                    </a>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('general_components')|| Request::is('cards')|| Request::is('izitoast')|| Request::is('transitions') || Request::is('buttons')|| Request::is('icons')|| Request::is('tooltips')|| Request::is('animations')|| Request::is('sliders')|| Request::is('notifications')|| Request::is('p_notify')|| Request::is('modal')|| Request::is('sortable')|| Request::is('sweet_alert')|| Request::is('cropper')|| Request::is('file_upload')|| Request::is('jstree')|| Request::is('grids_layout') ? 'active' : '') !!}">
                        <a href="javascript:;">
                            <i class="fa fa-anchor"></i>
                            <span class="link-title menu_hide">&nbsp; Components</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('general_components') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('general_components') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; General Components
                            </a>
                            </li>
                            <li {!! (Request::is('cards') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('cards') }}">
                                <i class="fa fa-angle-right"></i>
                                <span class="link-title">&nbsp;Cards</span>
                            </a>
                            </li>
                            <li {!! (Request::is('transitions') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('transitions') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Transitions
                            </a>
                            </li>
                            <li {!! (Request::is('buttons') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('buttons') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Buttons
                            </a>
                            </li>
                            <li {!! (Request::is('icons') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('icons') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Icons
                            </a>
                            </li>
                            <li {!! (Request::is('tooltips') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('tooltips') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Tooltips
                            </a>
                            </li>
                            <li {!! (Request::is('animations') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('animations') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Animations
                            </a>
                            </li>

                            <li {!! (Request::is('sliders') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('sliders') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Sliders
                            </a>
                            </li>
                            <li {!! (Request::is('notifications') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('notifications') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Notifications
                            </a>
                            </li>
                            <li {!! (Request::is('p_notify') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('p_notify') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; P-Notify
                            </a>
                            </li>
                            <li {!! (Request::is('izitoast') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('izitoast') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Izi-Toast
                            </a>
                            </li>
                            <li {!! (Request::is('cropper') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('cropper') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Cropper
                            </a>
                            </li>
                            <li {!! (Request::is('file_upload') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('file_upload') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; File Upload
                            </a>
                            </li>
                            <li {!! (Request::is('jstree') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('jstree') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp;Js Tree
                            </a>
                            </li>
                            <li {!! (Request::is('modal') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('modal') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Modals
                            </a>
                            </li>


                            <li {!! (Request::is('sortable') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('sortable') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Sortable
                            </a>
                            </li>
                            <li {!! (Request::is('sweet_alert') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('sweet_alert') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Sweet alerts
                            </a>
                            </li>
                            <li {!! (Request::is('grids_layout') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('grids_layout') }}">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Grid View
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is ('widgets1')|| Request::is('widgets2')|| Request::is('widgets3')? 'active':'' )!!}">
                        <a href="javascript:;">
                            <i class="fa fa-th-large"></i>
                            <span class="link-title menu_hide">&nbsp; Widgets</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('widgets1')? 'class="active"':"") !!}>
                            <a href="{{URL::to('widgets1')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Widgets 1
                            </a>
                            </li>
                            <li {!! (Request::is('widgets2')? 'class="active"':"") !!}>
                            <a href="{{URL::to('widgets2')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Widgets 2
                            </a>
                            </li>
                            <li {!! (Request::is('widgets3')? 'class="active"':"") !!}>
                            <a href="{{URL::to('widgets3')}} ">
                                <i class="fa fa-angle-right"></i>
                                <span class="link-title">&nbsp; Widgets 3 </span>
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is ('form_elements')|| Request::is('form_layouts')|| Request::is('form_validations')|| Request::is('form_editors')|| Request::is('radio_checkbox')|| Request::is('form_wizards')|| Request::is('datetime_picker')|| Request::is('ratings')? 'active':'' )!!}">
                        <a href="javascript:;">
                            <i class="fa fa-pencil"></i>
                            <span class="link-title menu_hide">&nbsp; Forms</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('form_elements')? 'class="active"':"") !!}>
                            <a href="{{URL::to('form_elements')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Form Elements
                            </a>
                            </li>
                            <li {!! (Request::is('form_layouts')? 'class="active"':"") !!}>
                            <a href="{{URL::to('form_layouts')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Form Layouts
                            </a>
                            </li>
                            <li {!! (Request::is('form_validations')? 'class="active"':"") !!}>
                            <a href="{{URL::to('form_validations')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Form Validations
                            </a>
                            </li>
                            <li {!! (Request::is('form_editors')? 'class="active"':"") !!}>
                            <a href="{{URL::to('form_editors')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Form Editors
                            </a>
                            </li>
                            <li {!! (Request::is('radio_checkbox')? 'class="active"':"") !!}>
                            <a href="{{URL::to('radio_checkbox')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Radio and Checkbox
                            </a>
                            </li>
                            <li {!! (Request::is('form_wizards')? 'class="active"':"") !!}>
                            <a href="{{URL::to('form_wizards')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Wizards
                            </a>
                            </li>
                            <li {!! (Request::is('datetime_picker')? 'class="active"':"") !!}>
                            <a href="{{URL::to('datetime_picker')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Date Time Picker
                            </a>
                            </li>
                            <li {!! (Request::is('ratings')? 'class="active"':"") !!}>
                            <a href="{{URL::to('ratings')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Ratings
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('simple_tables')|| Request::is('simple_datatables')|| Request::is('datatables') || Request::is('advanced_tables')? 'active':'')!!}">
                        <a href="#">
                            <i class="fa fa-th"></i>
                            <span class="link-title menu_hide">&nbsp; Tables</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('simple_tables')? 'class="active"':"") !!}>
                            <a href="{{URL::to('simple_tables')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Simple Tables
                            </a>
                            </li>

                            <li {!! (Request::is('simple_datatables')? 'class="active"':"") !!}>
                            <a href="{{URL::to('simple_datatables')}} ">
                                <i class="fa fa-angle-right"></i>
                                <span class="link-title">&nbsp; Simple Data Tables</span>

                            </a>
                            </li>
                            <li {!! (Request::is('datatables')? 'class="active"':"") !!}>
                            <a href="{{URL::to('datatables')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Data Tables
                            </a>
                            </li>
                            <li {!! (Request::is('advanced_tables')? 'class="active"':"") !!}>
                            <a href="{{URL::to('advanced_tables')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Advanced Tables
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('charts')|| Request::is('advanced_charts') || Request::is('chartist')|| Request::is('rickshaw')? 'active':'')!!}">
                        <a href="#">
                            <i class="fa fa-bar-chart"></i>
                            <span class="link-title menu_hide">&nbsp; Charts</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('charts')? 'class="active"':"") !!}>
                            <a href="{{URL::to('charts')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Flot Charts
                            </a>
                            </li>
                            <li {!! (Request::is('advanced_charts')? 'class="active"':"") !!}>
                            <a href="{{URL::to('advanced_charts')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Advanced Charts
                            </a>
                            </li>
                            <li {!! (Request::is('chartist')? 'class="active"':"") !!}>
                            <a href="{{URL::to('chartist')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Chartist
                            </a>
                            </li>
                            <li {!! (Request::is('rickshaw')? 'class="active"':"") !!}>
                            <a href="{{URL::to('rickshaw')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Rickshaw Charts
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li  class="dropdown_menu {!! (Request::is('users')|| Request::is('add_user') || Request::is('edit_user') || Request::is('view_user')|| Request::is('delete_user')? 'active':'')!!}">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="link-title menu_hide">&nbsp; Users</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('users')? 'class="active"':"") !!}>
                            <a href="{{URL::to('users')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; User Grid
                            </a>
                            </li>
                            <li {!! (Request::is('add_user')? 'class="active"':"") !!}>
                            <a href="{{URL::to('add_user')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Add User
                            </a>
                            </li>
                            <li {!! (Request::is('view_user')? 'class="active"':"") !!}>
                            <a href="{{URL::to('view_user')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; User Profile
                            </a>
                            </li>
                            <li {!! (Request::is('delete_user')? 'class="active"':"") !!}>
                            <a href="{{URL::to('delete_user')}} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Delete User
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li {!! (Request::is('calendar')? 'class="active"':"") !!}>
                    <a href="{{ URL::to('calendar') }} ">
                        <i class="fa fa-calendar"></i>
                        <span class="link-title menu_hide">&nbsp; Calendar</span>
                        <span class="badge badge-pill badge-primary float-right calendar_badge menu_hide">7</span>
                    </a>
                    </li>
                    <li  {!! (Request::is('gallery')|| Request::is('video_gallery') ? 'class="active"' : '') !!}>
                    <a href="#">
                        <i class="fa fa-picture-o"></i>
                        <span class="link-title menu_hide">&nbsp; Galleries</span>
                        <span class="fa arrow menu_hide"></span>
                    </a>
                    <ul>
                        <li {!! (Request::is('gallery')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('gallery') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Gallery
                        </a>
                        </li>
                        <li {!! (Request::is('video_gallery')? 'class="active"':"") !!}>
                        <a href="{{ URL::to('video_gallery') }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Video Gallery
                        </a>
                        </li>
                    </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('mail_compose')|| Request::is('mail_inbox') || Request::is('mail_view')|| Request::is('mail_sent')|| Request::is('mail_spam')|| Request::is('mail_draft')|| Request::is('mail_trash') ? 'active' : '') !!}">
                        <a href="#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="link-title menu_hide">&nbsp; Email</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('mail_compose')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_compose') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Compose
                            </a>
                            </li>
                            <li {!! (Request::is('mail_inbox')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_inbox') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Inbox
                            </a>
                            </li>
                            <li {!! (Request::is('mail_view')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_view') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; View
                            </a>
                            </li>
                            <li {!! (Request::is('mail_sent')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_sent') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Sent
                            </a>
                            </li>
                            <li {!! (Request::is('mail_spam')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_spam') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Spam
                            </a>
                            </li>
                            <li {!! (Request::is('mail_draft')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_draft') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Draft
                            </a>
                            </li>
                            <li {!! (Request::is('mail_trash')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('mail_trash') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Trash
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li  class="dropdown_menu {!! (Request::is('maps')|| Request::is('jqvmaps') ? 'active' : '') !!}">
                        <a href="#">
                            <i class="fa fa-map-marker"></i>
                            <span class="link-title menu_hide">&nbsp; Maps</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('maps')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('maps') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Google Maps
                            </a>
                            </li>
                            <li {!! (Request::is('jqvmaps')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('jqvmaps') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Vector Maps
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('404')|| Request::is('500') || Request::is('login')|| Request::is('register')|| Request::is('lockscreen')|| Request::is('invoice')|| Request::is('blank') ? 'active' : '') !!}">
                        <a href="javascript:;">
                            <i class="fa fa-file"></i>
                            <span class="link-title menu_hide">&nbsp; Pages</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('404')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('404') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; 404
                            </a>
                            </li>
                            <li {!! (Request::is('500')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('500') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; 500
                            </a>
                            </li>
                            <li {!! (Request::is('login1')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('login1') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Login 1
                            </a>
                            </li>
                            <li {!! (Request::is('login2')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('login2') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Login 2
                            </a>
                            </li>
                            <li {!! (Request::is('login3')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('login3') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Login 3
                            </a>
                            </li>
                            <li {!! (Request::is('register1')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('register1') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Register 1
                            </a>
                            </li>
                            <li {!! (Request::is('register2')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('register2') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Register 2
                            </a>
                            </li>
                            <li {!! (Request::is('register3')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('register3') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Register 3
                            </a>
                            </li>
                            <li {!! (Request::is('lockscreen')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('lockscreen') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Lock Screen 1
                            </a>
                            </li>
                            <li {!! (Request::is('lockscreen2')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('lockscreen2') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Lock Screen 2
                            </a>
                            </li>
                            <li {!! (Request::is('lockscreen3')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('lockscreen3') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Lock Screen 3
                            </a>
                            </li>
                            <li {!! (Request::is('invoice')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('invoice') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Invoice
                            </a>
                            </li>
                            <li {!! (Request::is('blank')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('blank') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Blank Page
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu {!! (Request::is('boxed')|| Request::is('fixed-header-boxed') || Request::is('fixed-header-menu')|| Request::is('fixed-header')|| Request::is('fixed-menu-boxed')|| Request::is('fixed-menu')|| Request::is('no-header')|| Request::is('no-left-sidebarr') ? 'active' : '') !!}">
                        <a href="javascript:;">
                            <i class="fa fa-th"></i>
                            <span class="link-title menu_hide">&nbsp; Layouts</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul>
                            <li {!! (Request::is('boxed')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('boxed') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Boxed Layout
                            </a>
                            </li>
                            <li {!! (Request::is('fixed-header-boxed')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('fixed-header-boxed') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Boxed &amp; Fixed Header
                            </a>
                            </li>
                            <li {!! (Request::is('fixed-header-menu')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('fixed-header-menu') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Fixed Header &amp; Menu
                            </a>
                            </li>
                            <li {!! (Request::is('fixed-header')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('fixed-header') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Fixed Header
                            </a>
                            </li>
                            <li {!! (Request::is('fixed-menu-boxed')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('fixed-menu-boxed') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Boxed &amp; Fixed Menu
                            </a>
                            </li>
                            <li {!! (Request::is('fixed-menu')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('fixed-menu') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; Fixed Menu
                            </a>
                            </li>
                            <li {!! (Request::is('no-header')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('no-header') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; No Header
                            </a>
                            </li>
                            <li {!! (Request::is('no-left-sidebar')? 'class="active"':"") !!}>
                            <a href="{{ URL::to('no-left-sidebar') }} ">
                                <i class="fa fa-angle-right"></i>
                                &nbsp; No Left Sidebar
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown_menu">
                        <a href="javascript:;">
                            <i class="fa fa-sitemap"></i>
                            <span class="link-title menu_hide">&nbsp; Multi Level Menu</span>
                            <span class="fa arrow menu_hide"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 1
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="sub-menu sub-submenu">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 3
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 3
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 3
                                                    <span class="fa arrow"></span>
                                                </a>
                                                <ul class="sub-menu sub-submenu">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 4
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 4
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="fa fa-angle-right"></i>
                                                            &nbsp;Level 4
                                                            <span class="fa arrow"></span>
                                                        </a>
                                                        <ul class="sub-menu sub-submenu">
                                                            <li>
                                                                <a href="javascript:;">
                                                                    <i class="fa fa-angle-right"></i>
                                                                    &nbsp;Level 5
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">
                                                                    <i class="fa fa-angle-right"></i>
                                                                    &nbsp;Level 5
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">
                                                                    <i class="fa fa-angle-right"></i>
                                                                    &nbsp;Level 5
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-angle-right"></i>
                                                    &nbsp;Level 4
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 1
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right"></i>
                                    &nbsp;Level 1
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-angle-right"></i>
                                            &nbsp;Level 2
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /#menu -->
            </div>
        </div>
        <!-- /#left -->

        <div id="content" class="bg-container">
            <!-- Content -->
            @yield('content')
            <!-- Content end -->
        </div>
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <form>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="float-right" aria-hidden="true">&times;</span>
                        </button>
                        <div class="input-group search_bar_small">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <span class="input-group-append">
        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
      </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /#content -->
    @include('layouts/right_sidebar/fixed_menu_header')

</div>
<!-- /#wrap -->
<!-- global scripts-->
<script type="text/javascript" src="{{asset('assets/js/components.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
<!-- end of global scripts-->
<!-- page level js -->
@yield('footer_scripts')
<!-- end page level js -->
</body>
</html>