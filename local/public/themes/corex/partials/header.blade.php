<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
  <div class="m-container m-container--fluid m-container--full-height">
    <div class="m-stack m-stack--ver m-stack--desktop">

      <!-- BEGIN: Brand -->
      <div class="m-stack__item m-brand  m-brand--skin-dark ">
        <div class="m-stack m-stack--ver m-stack--general">
          <div class="m-stack__item m-stack__item--middle m-brand__logo">
            <a href="/" class="m-brand__logo-wrapper">
              <img alt="" width="210" src="{{ asset('local/public/img/logo/logo.png') }}" />
            </a>
          </div>
          <div class="m-stack__item m-stack__item--middle m-brand__tools">
            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
              <span></span>
            </a>

            <!-- BEGIN: Topbar Toggler -->
            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
              <i class="flaticon-more"></i>
            </a>

            <!-- BEGIN: Topbar Toggler -->
          </div>
        </div>
      </div>

      <!-- END: Brand -->
      <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

        <!-- BEGIN: Horizontal Menu -->

        <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
        <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
          <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">

            <?php
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            if ($user_role == 'Admin' || $user_role == 'SalesHead' || $user->hasPermissionTo('view-allreport')) {
            ?>
              <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Reports</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:1000px"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
                  <div class="m-menu__subnav">
                    <ul class="m-menu__content">
                      <?php

                      if ($user->hasPermissionTo('view-dispatchedReport')) {
                      ?>
                        <li class="m-menu__item">
                          <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Sales Report</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
                          <ul class="m-menu__inner">
                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('client_order_report')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Client Orders Report</span></a></li>

                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('client_paymentRecieved_report')}}" class="m-menu__link "><i class="fa fa-rupee-sign"></i> <span class="m-menu__link-text" style="padding-left:14px"> Payment Received Report</span></a></li>
                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('getChartReport')}}" class="m-menu__link "><i class="fa fa-rupee-sign"></i> <span class="m-menu__link-text" style="padding-left:14px">Order and Payment Graph</span></a></li>

                            <!--<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="../../../header/actions.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">IPO Reports</span></a></li>
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="../../../header/actions.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-1"></i><span class="m-menu__link-text">Finance Margins</span></a></li>
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="../../../header/actions.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-graphic-2"></i><span class="m-menu__link-text">Revenue Reports</span></a></li>  -->
                          </ul>
                        </li>

                        <li class="m-menu__item">
                          <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Stages Report</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
                          <ul class="m-menu__inner">
                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('stageCompletdFilter')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Stages Completed</span></a></li>

                          </ul>
                        </li>
                      <?php
                      }
                      ?>

                      <li class="m-menu__item">
                        <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Dispatched Report</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
                        <ul class="m-menu__inner">
                          <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('dispatchedReport')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Dispatched Report</span></a></li>

                        </ul>
                      </li>

                      <?php

                      if ($user->hasPermissionTo('view-dispatchedReport')) {
                      ?>
                        <li class="m-menu__item">
                          <h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Misc. Report</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
                          <ul class="m-menu__inner">
                            <!-- <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('sap_chklistGraph')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">SAP Check List</span></a></li> -->
                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{route('pendingProcessReport')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Pending Process</span></a></li>

                          </ul>
                        </li>

                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </li>

            <?php
            }
            ?>



          </ul>
        </div>

        <!-- END: Horizontal Menu -->

        <!-- BEGIN: Topbar -->
        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
          <div class="m-stack__item m-topbar__nav-wrapper">
            <ul class="m-topbar__nav m-nav m-nav--inline">
              <?php
              $user = auth()->user();
              $userRoles = $user->getRoleNames();
              $user_role = $userRoles[0];

              use App\Helpers\AyraHelp;
              use Carbon\Carbon;

              if ($user_role == 'Admin' || $user_role == 'SalesHead'  || Auth::user()->id == 156) {
                $ticket_arr = \DB::table('ticket_list')
                  // ->join('ticket_assign_to', 'ticket_list.ticket_id', '=', 'ticket_assign_to.ticket_id')
                  //->where('ticket_assign_to.assign_to', Auth::user()->id)
                  // ->select('ticket_list.*', 'ticket_assign_to.read_status')
                  ->get();
              } else {
                $ticket_arr = \DB::table('ticket_list')
                  ->join('ticket_assign_to', 'ticket_list.ticket_id', '=', 'ticket_assign_to.ticket_id')
                  ->where('ticket_assign_to.assign_to', Auth::user()->id)
                  ->select('ticket_list.*', 'ticket_assign_to.read_status')
                  ->get();
              }



              if (count($ticket_arr) > 0) {
                $tcount = count($ticket_arr);
                $ajticket = 'danger';
                $ajbadgeticket = 'warning';
              } else {
                $ajticket = 'default';
                $tcount = 0;
                $ajbadgeticket = 'default';
              }
              ?>

              <!-- <a title="View All Tickets" href="{{route('view_ticket_data')}}" class="btn btn-{{$ajticket}} m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="fa flaticon-chat"></i>
                  <span class="ajCountTIC m-badge m-badge--{{$ajbadgeticket}}">{{$tcount}}</span>

                </span>
              </a> -->
              <?php
              if ($user_role == 'Admin' || $user_role == 'SalesHead') {
                if(Auth::user()->id==1|| Auth::user()->id==171){
                  ?>
                  <a title="GET Sales wise ON Payment details" href="javascript::void(0)" id="getMTDPAYMENT_CLIENT" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                    <span>PAYMENT
  
  
  
                    </span>
                  </a>
                <?php
                }
                if(Auth::user()->id==171 || Auth::user()->id==1){
                  ?>
                  <a title="GET Payment and Orders" href="{{route('payment_order_withFilter')}}" id="getMTDPAYMENT_CLIENT_PAY_ORDER" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                    <span> Filter  
                    </span>
                  </a>
                <?php
                }

              ?>
                <a title="GET MTD ON EMAIL" href="javascript::void(0)" id="getMTD" class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                  <span>MTD
                  </span>
                </a>
               
              <?php
              }

              ?>

              <?php
              if ($user_role == 'Admin' || $user_role == 'SalesHead' ||  Auth::user()->id == 156) {
              
                if($user_role=='SalesHead'){
                  ?>
                   <a title="Brand Wise Details" href="{{route('getMTDBrandDetails')}}"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                  <span>Brand
                  </span>
                </a>
                   <!-- <a title="Brand Wise Details" href="javascript::void(0)" id="getMTD_Brand" class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                  <span>Brand
                  </span>
                </a> -->
                  <?php
                }
                $orderEditArrCount = \DB::table('order_edit_requests')
                  ->where('status', 2)
                  ->count();
              } else {
                $orderEditArrCount = \DB::table('order_edit_requests')
                  ->where('status', 2)
                  ->where('created_by', Auth::user()->id)
                  ->count();
              }

              if ($orderEditArrCount > 0) {
              ?>
                <a title="Order Edit Request" href="{{route('view_order_edit_request')}}" class="btn btn-brand m-btn btn-sm 	m-btn m-btn--icon">
                  <span>Order Edit <span class="m-badge m-badge"> {{$orderEditArrCount}}</span>
                  </span>
                </a>
              <?php
              }






              if ($user_role == 'Intern' || $user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'CourierTrk' || $user_role == 'SalesHead') {
              ?>
                <!-- <a href="{{ route('getAllLeadUntouch')}}" class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon">
                  <span>
                    <i class="fa flaticon-plus"></i>
                    
                  </span>
                </a> -->
                <?php
                if (Auth::user()->id == 1591 || Auth::user()->id == 1601 || Auth::user()->id == 1621 || Auth::user()->id == 1611 || Auth::user()->id == 1621 || Auth::user()->id == 1631 || Auth::user()->id == 1641  || Auth::user()->id == 1651 || Auth::user()->id == 1661 || Auth::user()->id == 1671 || Auth::user()->id == 1681 || Auth::user()->id == 1691 || Auth::user()->id == 1701) {

                } else {
                ?>
                  <a href="{{ route('getAllAvaibleLeadData')}}" class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon">
                    <span>
                      <i class="fa flaticon-plus"></i>
                      <span>Verified Lead </span>
                    </span>
                  </a>
                  

                <?php
                }

                ?>

                <?php
                if($user_role == 'Admin' || $user_role == 'SalesHead'){
                  $boticketCount = DB::table('bo_tickets')
                  ->where('status','!=',3)
                 
                  ->count();
                 
                    ?>
                     <a title="All Assinged List" href="{{ route('getAllComplainList')}}" class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon">
                      <span>
                      <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">{{$boticketCount}}</span></span>
                        <span>Complain </span>
                      </span>
                    </a>
  
                    <?php
  
                  

                }else{
                  $boticketCount = DB::table('bo_tickets')
                  ->where('status','!=',3)
                  ->where('assinged_to', Auth::user()->id)
                  ->count();
                  if($boticketCount>0){
                    ?>
                     <a title="My Assinged List" href="{{ route('getAllComplainList')}}" class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon">
                      <span>
                      <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">{{$boticketCount}}</span></span>
                        <span>Complain </span>
                      </span>
                    </a>
  
                    <?php
  
                  }
                }
               
               

                 ?>
               

                <!-- <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                  <span>
                    <i class="fa flaticon-users"></i>
                    <span>Client</span>
                  </span>
                </a>
                <a href="javascript::void(0)" id="btnAddSampleV1" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                  <span>
                    <i class="fa flaticon-interface-3"></i>
                    <span>Sample</span>
                  </span>
                </a> -->

                <?php
                if ($user_role == 'Admin' ||  $user_role == 'CourierTrk' || $user_role == 'SalesHead' || Auth::user()->id==89 || Auth::user()->id==253) {
                ?>
                  <a href="javascript::void(0)" onclick="print_SampeBO()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                    <span>
                      <i class="fa flaticon-technology"></i>
                      <span>Sample</span>
                    </span>
                  </a>
                <?php

                }

                ?>




              <?php
              }

              ?>
              <?php
              if (Auth::user()->id == 146 || Auth::user()->id == 124 || Auth::user()->id == 189 || Auth::user()->id == 89 || Auth::user()->id == 206 || Auth::user()->id==253) {
              ?>
                <a href="javascript::void(0)" onclick="print_SampeBO()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                  <span>
                    <i class="fa flaticon-technology"></i>
                    <span>Print Sample</span>
                  </span>
                </a>
                <!-- href="{{route('getSampleLabelPrint')}}" -->
                <a  href="{{route('getSampleLabelPrintEntry')}}"  class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                  <span>
                    <i class="fa flaticon-technology"></i>
                    <span>Print LABEL</span>
                  </span>
                </a>

              <?php
              }
              ?>


              <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                <!-- <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                   <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                   <span class="m-nav__link-icon"><i class="flaticon-alarm"></i></span>
                 </a> -->
                <div class="m-dropdown__wrapper">
                  <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                  <div class="m-dropdown__inner">
                    <div class="m-dropdown__header m--align-center" style="background: url(assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
                      <span class="m-dropdown__header-title">9 New</span>
                      <span class="m-dropdown__header-subtitle">User Notifications</span>
                    </div>
                    <div class="m-dropdown__body">
                      <div class="m-dropdown__content">
                        <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                          <li class="nav-item m-tabs__item">

                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                              Notes
                            </a>
                          </li>
                          <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">Sample</a>
                          </li>
                          <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">All Logs</a>
                          </li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                              <div class="m-list-timeline m-list-timeline--skin-light">
                                <div class="m-list-timeline__items">
                                  <?php
                                  $alert_arr = AyraHelp::getAlarm();

                                  foreach ($alert_arr as $key => $alerm) {

                                    if ($alerm->activity_type == 1) {
                                  ?>

                                      <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--{{$alerm->lable}}"></span>
                                        <span class="m-list-timeline__text">{{$alerm->message}}</span>
                                        <span class="m-list-timeline__time">Just now</span>
                                      </div>


                                  <?php
                                    }
                                  }
                                  ?>


                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                              <div class="m-list-timeline m-list-timeline--skin-light">
                                <div class="m-list-timeline__items">






                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                            <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                              <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                  <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items">
                                      <?php
                                      $alert_arr = AyraHelp::getAlarm();

                                      foreach ($alert_arr as $key => $alerm) {


                                      ?>

                                        <div class="m-list-timeline__item">
                                          <span class="m-list-timeline__badge m-list-timeline__badge--{{$alerm->lable}}"></span>
                                          <span class="m-list-timeline__text">{{$alerm->message}}</span>
                                          <span class="m-list-timeline__time">Just now</span>
                                        </div>


                                      <?php

                                      }
                                      ?>


                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <?php
              $EMPdata = AyraHelp::getEMPDetail(Auth::user()->id);
              if (!$EMPdata) {
                $avatar_URL = asset('local/public/img/avatar.jpg');
              } else {

                if (empty($EMPdata->photo)) {
                  $avatar_URL = asset('local/public/img/avatar.jpg');
                } else {
                  $avatar_URL = asset('/local/public/uploads/photos') . "/" . $EMPdata->photo;
                }
              }
              ?>
              {{Auth::user()->name}}
              <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                  <span class="m-topbar__userpic">
                    <img src="{{$avatar_URL}}" class="m--img-rounded m--marginless" alt="" />
                  </span>
                  <span class="m-topbar__username m--hide" id="myName">{{Auth::user()->name}}</span>
                </a>
                <div class="m-dropdown__wrapper">
                  <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                  <div class="m-dropdown__inner">
                    <div class="m-dropdown__header m--align-center" style="background: url({{ asset('local/public/themes/corex/assets/app/media/img/bg/bg-2.jpg') }}">
                      <div class="m-card-user m-card-user--skin-dark">
                        <div class="m-card-user__pic">
                          <img src="{{$avatar_URL}}" id="myPIC" class="m--img-rounded m--marginless" alt="" />


                        </div>
                        <div class="m-card-user__details">
                          <span class="m-card-user__name m--font-weight-500">{{Auth::user()->name}}</span>
                          <a href="" class="m-card-user__email m--font-weight-300 m-link">{{Auth::user()->email}}</a>
                        </div>
                      </div>
                    </div>
                    <div class="m-dropdown__body">
                      <div class="m-dropdown__content">
                        <ul class="m-nav m-nav--skin-light">
                          <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text">Section</span>
                          </li>
                          <li class="m-nav__item">
                            <a href="{{route('user.profile')}}" class="m-nav__link">
                              <i class="m-nav__link-icon flaticon-profile-1"></i>
                              <span class="m-nav__link-title">
                                <span class="m-nav__link-wrap">
                                  <span class="m-nav__link-text">My Profile</span>
                                  <span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
                                </span>
                              </span>
                            </a>
                          </li>




                          <li class="m-nav__separator m-nav__separator--fit">
                          </li>
                          <li class="m-nav__item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                            </form>

                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </div>

        <!-- END: Topbar -->
      </div>
    </div>
  </div>
</header>

<!-- END: Header -->

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">








  <!-- m_modal_print -->

 

  <div class="modal fade" id="m_modal_6SamplePrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-content">

        <div class="modal-body">
          <!--begin::Portlet-->
          <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                  <h3 class="m-portlet__head-text">
                    Sample Print Action
                  </h3>
                </div>
              </div>
              <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                  <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link " data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab">
                      <i class="flaticon-multimedia"></i> New
                    </a>
                  </li>
                  <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_tab_content" role="tab">
                      <i class="flaticon-cogwheel-2"></i> OLD
                    </a>
                  </li>

                </ul>
              </div>
            </div>
            <div class="m-portlet__body">
              <div class="tab-content">
                <div class="tab-pane " id="m_portlet_base_demo_1_tab_content" role="tabpanel">
                  <!-- new forms  -->
                  <form method="post" action="{{route('printSamplewithFilterV2')}}">
                    @csrf
                    <div class="form-group m-form__group">
                      <label for="exampleSelect1">Select Sample Category</label>
                      <select class="form-control m-input" id="exampleSelect1" name="txtSampleCat">
                        <?php
                         $today = \Carbon\Carbon::today();
      
                         if($today->dayOfWeek == \Carbon\Carbon::MONDAY){
                           $fromD=date('Y-m-d', strtotime("-3 days"));
                           $toD=date('Y-m-d');
                           $dateStr=$fromD."-To-".$toD;
                         }else{
                          $fromD=date('Y-m-d', strtotime("-1 days"));
                          $toD=date('Y-m-d');
                          $dateStr=$fromD."-To-".$toD;
                         }

                        $sampleCatArr = DB::table('samples_category')->where('is_deleted', 0)
                          ->get();
                        foreach ($sampleCatArr as $key => $rowData) {
                          $count =AyraHelp::getSampleCountYestardayToYet($rowData->id);
                        ?>
                          <option title="{{$dateStr}}" value="{{$rowData->id}}">{{$rowData->name}}-<span >[{{$count}}]</span></option>
                        <?php
                        }

                        ?>
                      </select>
                    </div>

                    <div class="form-group m-form__group">
                      <label>Date From</label>
                      <div class="input-group">
                        <input type="text" id="print_sample_datev2" name="print_sample_date_v2" class="form-control" aria-label="Text input with dropdown button">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-calendar glyphicon-th"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_yesterday_v2">Yestarday</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_today1_v2">Today</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_7days1_v2">7 Days Before</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_15days1_v2">15 Days Before</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_next_month1_v2">Next Month Before</a>
                          </div>
                        </div>
                      </div>

                    </div>
                    <button type="submit" id="btnPrintSampelNow" class="btn btn-warning">
                      <span>
                        <i class="fa flaticon-technology"></i>
                        <span>New Print Sample</span>
                      </span>
                    </button>

                  </form>

                  <!-- new forms  -->
                </div>
                <div class="tab-pane active" id="m_portlet_base_demo_2_tab_content" role="tabpanel">
                  <!-- old ways  -->
                  <form method="post" action="{{route('printSamplewithFilter')}}">
                    @csrf
                    <div class="m-form__group form-group">
                      <label for="">Select Sample Category</label>
                      <div class="m-radio-inline">
                        <label class="m-radio">
                          <input type="radio" name="samplePrintCat" value="2"> OILS
                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input type="radio" name="samplePrintCat" value="1"> STANDARD COSMETIC
                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input checked type="radio" name="samplePrintCat" value="3"> GENERAL CHANGES
                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input checked type="radio" name="samplePrintCat" value="4"> AS PER BENCHMARK/NPD
                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input checked type="radio" name="samplePrintCat" value="5"> MODIFICATIONS

                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input checked type="radio" name="samplePrintCat" value="6"> ALL

                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input checked type="radio" name="samplePrintCat" value="7"> ALL Except OILS

                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input type="radio" name="samplePrintCat" value="8"> ALL Except OILS Latest

                          <span></span>
                        </label>
                        <label class="m-radio">
                          <input type="radio" name="samplePrintCat" value="9"> All Formulation Pending

                          <span></span>
                          <label class="m-radio">
                            <input type="radio" name="samplePrintCat" value="10"> All Priority Samples

                            <span></span>
                          </label>
                          <label class="m-radio">
                            <input type="radio" name="samplePrintCat" value="11"> Big Brand

                            <span></span>
                          </label>
                          <label class="m-radio">
                            <input type="radio" name="samplePrintCat" value="12"> Except Big Brand

                            <span></span>
                          </label>

                      </div>

                    </div>
                    <!-- data data  -->
                    <div class="form-group m-form__group row">
													<div class="col-lg-4 m-form__group-sub">
														<label class="form-control-label">* Date From:</label>
                            <div class="input-group">
                        <input type="text" id="print_sample_date" name="print_sample_date" class="form-control" aria-label="Text input with dropdown button">
                        <div class="input-group-append">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-calendar glyphicon-th"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_yesterday">Yestarday</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_today1">Today</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_7days1">7 Days</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_15days1">15 Days</a>
                            <a class="dropdown-item" href="javascript::void(0)" id="aj_next_month1">Next Month</a>
                          </div>
                        </div>
                      </div>
													</div>
													<div class="col-lg-4 m-form__group-sub">
														<label class="form-control-label">* Date To:</label>
                            <input type="text" id="m_datepicker_1" name="print_sample_date_to" class="form-control" aria-label="">

													</div>
                          <div class="col-lg-4 m-form__group-sub">
                          <button style="margin-top: 25px;" type="submit" id="btnPrintSampelNow" class="btn btn-primary">
                      <span>
                        <i class="fa flaticon-technology"></i>
                        <span>Print Sample</span>
                      </span>
                    </button>
                          </div>
												
												</div>
										

                    <!-- data data  -->

                   
                   

                  </form>
                  <?php
                  if (Auth::user()->id == 27 ||  Auth::user()->id == 1 || Auth::user()->id == 126 || Auth::user()->id == 124 || Auth::user()->id == 90 ||  Auth::user()->id == 171  || Auth::user()->id == 156) {

                  ?>


                    <select style="margin-top:25px" name="printChemistSample" id="SelectPrintChemistSample" class="form-control">
                      <option select value="">---Select Chemist- --</option>
                      <?php
                      $activeChemietArr = AyraHelp::getChemist();
                      foreach ($activeChemietArr as $key => $rowData) {
                      ?>
                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                      <?php
                      }
                      ?>


                    </select>
                  <?php
                  }
                  ?>

                  <!-- foteer  -->
                  <div class="modal-footer">
                    <?php
                    if (Auth::user()->id == 27 || Auth::user()->id == 1 || Auth::user()->id == 126 || Auth::user()->id == 124 || Auth::user()->id == 90 || Auth::user()->id == 171 || Auth::user()->id == 156) {
                    ?>
                      <a href="javascript::void(0)" id="btnViewSamplePendingList" class="btn btn-secondary">View Pending</a>
                      <a href="javascript::void(0)" id="btnViewSampleAssingedList" class="btn btn-warning">Assigned Samples</a>
                      <a href="javascript::void(0)" id="btnViewSampleStandardList" class="btn btn-accent">STANDARD</a>
                      <a href="javascript::void(0)" id="btnViewSampleBenchmarkList" class="btn btn-accent">Bechmark</a>
                    <?php
                    }
                    ?>

                  </div>
                  <!-- foteer  -->
                  <!-- old ways  -->
                </div>

              </div>
            </div>
          </div>

          <!--end::Portlet-->

          <!-- modal content -->

          <!--model content -->




        </div>

      </div>
    </div>
  </div>


   <!-- m_modal_6SamplePrintLBL -->
   
