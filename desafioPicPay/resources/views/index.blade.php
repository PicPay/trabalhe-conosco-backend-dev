@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
    Dashboard-1
    @parent
@stop
{{-- page level styles --}}
@section('header_styles')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/c3/css/c3.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/toastr/css/toastr.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/switchery/css/switchery.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/new_dashboard.css')}}"/>
@stop
@section('content')
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 col-12">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="bg-primary top_cards">
                                <div class="row icon_margin_left">

                                    <div class="col-lg-5 col-5 icon_padd_left">
                                        <div class="float-left">
                                        <span class="fa-stack fa-sm">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-shopping-cart fa-stack-1x fa-inverse text-primary sales_hover"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-7 icon_padd_right">
                                        <div class="float-right cards_content">
                                            <span class="number_val" id="sales_count"></span><i
                                                    class="fa fa-long-arrow-up fa-2x"></i>
                                            <br/>
                                            <span class="card_description">Sales</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="bg-success top_cards">
                                <div class="row icon_margin_left">
                                    <div class="col-lg-5  col-5 icon_padd_left">
                                        <div class="float-left">
                                        <span class="fa-stack fa-sm">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-eye fa-stack-1x fa-inverse text-success visit_icon"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-7 icon_padd_right">
                                        <div class="float-right cards_content">
                                            <span class="number_val" id="visitors_count"></span><i
                                                    class="fa fa-long-arrow-up fa-2x"></i>
                                            <br/>
                                            <span class="card_description">Visitors</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="bg-warning top_cards">
                                <div class="row icon_margin_left">
                                    <div class="col-lg-5 col-5 icon_padd_left">
                                        <div class="float-left">
                                        <span class="fa-stack fa-sm">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-usd fa-stack-1x fa-inverse text-warning revenue_icon"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-7 icon_padd_right">
                                        <div class="float-right cards_content">
                                            <span class="number_val" id="revenue_count"></span><i
                                                    class="fa fa-long-arrow-up fa-2x"></i>
                                            <br/>
                                            <span class="card_description">Revenue</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="bg-mint top_cards">
                                <div class="row icon_margin_left">
                                    <div class="col-lg-5 col-5 icon_padd_left">
                                        <div class="float-left">
                                        <span class="fa-stack fa-sm">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-users  fa-stack-1x fa-inverse text-mint sub"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-7 icon_padd_right">
                                        <div class="float-right cards_content">
                                            <span class="number_val" id="subscribers_count"></span><i
                                                    class="fa fa-long-arrow-down fa-2x"></i>
                                            <br/>
                                            <span class="card_description">Subscribers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- /.inner -->
        </div>
        <!-- /.outer -->
    </div>
    <!-- /#content -->
@stop
@section('footer_scripts')
    <script type="text/javascript" src="{{asset('assets/vendors/slimscroll/js/jquery.slimscroll.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/raphael/js/raphael.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/d3/js/d3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/c3/js/c3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/toastr/js/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/switchery/js/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.resize.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.stack.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.time.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotspline/js/jquery.flot.spline.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.categories.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/flotchart/js/jquery.flot.pie.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/vendors/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/jquery_newsTicker/js/newsTicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/countUp.js/js/countUp.min.js')}}"></script>
    <!--end of plugin scripts-->
    <script type="text/javascript" src="{{asset('assets/js/pages/new_dashboard.js')}}"></script>

@stop
