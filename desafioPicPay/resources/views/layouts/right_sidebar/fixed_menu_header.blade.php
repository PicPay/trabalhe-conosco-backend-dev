<div id="request_list">
    <div class="request_scrollable">
        <ul class="nav nav-tabs m-t-15">
            <li class="nav-item">
                <a class="nav-link active text-center" href="#settings" data-toggle="tab">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="#favourites" data-toggle="tab">Favorites</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="settings">
                <div id="settings_section">
                    <div class="layout_styles mx-3">
                        <div class="row">
                            <div class="col-12 m-t-35">
                                <h4>Layout settings</h4>
                            </div>
                        </div>
                        <form autocomplete="off">
                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left m-t-20">Fixed Header</div>
                                    <div class="float-right m-t-15">
                                        <div id="setting_fixed_nav">
                                            <input class="make-switch" data-on-text="ON" data-off-text="OFF" type="checkbox"
                                                   data-size="small" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left m-t-20">Fixed Menu</div>
                                    <div class="float-right m-t-15">
                                        <div id="setting_fixed_menunav">
                                            <input class="make-switch" data-on-text="ON" data-off-text="OFF" name="radioBox" type="checkbox"
                                                   data-size="small" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="float-left m-t-20">No Breadcrumb</div>
                                    <div class="float-right m-t-15">
                                        <div id="setting_breadcrumb">
                                            <input class="make-switch" data-on-text="ON" data-off-text="OFF" type="checkbox"
                                                   data-size="small">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mx-3">
                        <div class="row">
                            <div class="col-12 m-t-35">
                                <h4 class="setting_title">General Settings</h4>
                            </div>
                        </div>
                        <div class="data m-t-5">
                            <div class="row">
                                <div class="col-2"><i class="fa fa-bell-o setting_ions text-info"></i></div>
                                <div class="col-7">
                                    <span class="chat_name">Notifications</span><br/>
                                    Get new notifications
                                </div>
                                <div class="col-2 checkbox float-right">
                                    <label class="text-info">
                                        <input type="checkbox" value="" checked>
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="data">
                            <div class="row">
                                <div class="col-2"><i class="fa fa-envelope-o setting_ions text-danger"></i>
                                </div>
                                <div class="col-7">
                                    <span class="chat_name">Messages</span><br/>
                                    Get new messages
                                </div>
                                <div class="col-2 checkbox float-right">
                                    <label class="text-danger">
                                        <input type="checkbox" value="" checked>
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="data">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fa fa-exclamation-triangle setting_ions text-warning"></i>
                                </div>
                                <div class="col-7">
                                    <span class="chat_name">Warnings</span><br/>
                                    Get new warnings
                                </div>
                                <div class="col-2 checkbox float-right">
                                    <label class="text-warning">
                                        <input type="checkbox" value="" checked>
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="data">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fa fa-calendar texlayout_stylest-primary setting_ions"></i>
                                </div>
                                <div class="col-7">
                                    <span class="chat_name">Events</span><br/>
                                    Show new events
                                </div>
                                <div class="col-2 checkbox float-right">
                                    <label class="text-primary">
                                        <input type="checkbox" value="" >
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="favourites">
                <div id="requests" class="mx-3">
                    <div class="m-t-35">
                        <h4 class="setting_title">Favorites</h4>
                    </div>
                    <div class="data m-t-10">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/images1.jpg')}}" class="message-img avatar rounded-circle" alt="avatar1"></div>
                            <div class="col-8 message-data"><span class="chat_name">Philip J. Webb</span><br/>
                                Available
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/8.jpg')}}" class="message-img avatar rounded-circle" alt="avatar1">
                            </div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Nancy T. Strozier</span><br/>
                                Away
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/3.jpg')}}" class="message-img avatar rounded-circle" alt="avatar1">
                            </div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Robbinson</span><br/>
                                Offline
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="setting_title">Contacts</h4>
                    <div class="data m-t-10">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/7.jpg')}}" class="message-img avatar rounded-circle" alt="avatar1">
                            </div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Chester Hardesty</span><br/>
                                Busy
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/2.jpg')}}" class="message-img avatar rounded-circle"
                                     alt="avatar1"></div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Peter</span><br/>
                                Online
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/6.jpg')}}" class="message-img avatar rounded-circle" alt="avatar1">
                            </div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Devin Hartsell</span><br/>
                                Available
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/4.jpg')}}" class="message-img avatar rounded-circle"
                                     alt="avatar1"></div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Kimy Zorda</span><br/>
                                Available
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="data">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets/img/mailbox_imgs/5.jpg')}}" class="message-img avatar rounded-circle"
                                     alt="avatar1"></div>
                            <div class="col-8 message-data">
                                <span class="chat_name">Jessica Bell</span><br/>
                                Offline
                            </div>
                            <div class="col-1">
                                <i class="fa fa-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#content -->
<div id="right">
    <div class="right_content">
        <div class="well-small dark m-t-15">
            <div class="row m-0">
                <div class="col-lg-12 p-d-0">
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('blue_black_skin.css','css')">
                        <div class="skin_blue skin_size b_t_r"></div>
                        <div class="skin_blue_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('green_black_skin.css','css')">
                        <div class="skin_green skin_size b_t_r"></div>
                        <div class="skin_green_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('purple_black_skin.css','css')">
                        <div class="skin_purple skin_size b_t_r"></div>
                        <div class="skin_purple_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('orange_black_skin.css','css')">
                        <div class="skin_orange skin_size b_t_r"></div>
                        <div class="skin_orange_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('red_black_skin.css','css')">
                        <div class="skin_red skin_size b_t_r"></div>
                        <div class="skin_red_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <div class="skinmulti_btn" onclick="javascript:loadjscssfile('mint_black_skin.css','css')">
                        <div class="skin_mint skin_size b_t_r"></div>
                        <div class="skin_mint_border skin_shaddow skin_size b_b_r"></div>
                    </div>
                    <!--</div>-->
                    <div class="skin_btn skinsingle_btn skin_blue b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('blue_skin.css','css')"></div>
                    <div class="skin_btn skinsingle_btn skin_green b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('green_skin.css','css')"></div>
                    <div class="skin_btn skinsingle_btn skin_purple b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('purple_skin.css','css')"></div>
                    <div class="skin_btn  skinsingle_btn skin_orange b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('orange_skin.css','css')"></div>
                    <div class="skin_btn skinsingle_btn skin_red b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('red_skin.css','css')"></div>
                    <div class="skin_btn skinsingle_btn skin_mint b_r height_40 skin_shaddow"
                         onclick="javascript:loadjscssfile('mint_skin.css','css')"></div>
                </div>
                <div class="col-lg-12 text-center m-t-15">
                    <button class="btn btn-dark button-rounded"
                            onclick="javascript:loadjscssfile('black_skin.css','css')">Dark
                    </button>
                    <button class="btn btn-secondary button-rounded default_skin"
                            onclick="javascript:loadjscssfile('default_skin.css','css')">Default
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- # right side -->