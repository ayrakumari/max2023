<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <?php
            use Illuminate\Support\Facades\Auth;
            $route_name = AyraHelp::getRouteName();
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            if ($user_role == 'QAQC') {

                if ($route_name == 'client') {
                    $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
                    $menu_style = "display: block;overflow:hidden;";
                } else {
                    $menu_class = 'm-menu__item  m-menu__item--submenu';
                    $menu_style = "";
                }
                $strL = "QAQC";

            ?>
                <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                        <span class="m-menu__link-text">{{$strL}}</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="m-menu__submenu " style="{{$menu_style}}">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                                    <span class="m-menu__link-text">---</span></span>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Order List</span>

                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php


            }

            if ($user_role == 'LeadMgmt') {

                if ($route_name == 'client') {
                    $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
                    $menu_style = "display: block;overflow:hidden;";
                } else {
                    $menu_class = 'm-menu__item  m-menu__item--submenu';
                    $menu_style = "";
                }
                $strL = "LeadMgmt";

            ?>
                <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                        <span class="m-menu__link-text">{{$strL}}</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="m-menu__submenu " style="{{$menu_style}}">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                                    <span class="m-menu__link-text">---</span></span>
                            </li>
                            <li class="m-menu__item " aria-haspopup="true"><a href="#" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Lead  List</span>

                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php


            }



            ?>







            </li>

            <li class="m-menu__item  m-menu__item" aria-haspopup="false">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="m-menu__link "><i class="m-menu__link-icon flaticon-user" style="color:#FFF"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> Log Out
                            <span class="m-menu__link-badge"></span> </span></span></a>



            </li>


            <!-- ajcode for new menu -->

        </ul>

    </div>
    <!-- END: Aside Menu -->
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- END: Left Aside -->
<div class="m-grid__item m-grid__item--fluid m-wrapper">