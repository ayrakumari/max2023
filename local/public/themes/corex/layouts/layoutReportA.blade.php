<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
    <?php 
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        ?>
        {!! meta_init() !!}
        <meta name="keywords" content="@get('keywords')">
        <meta name="description" content="@get('description')">
        <meta name="author" content="@get('author')">
        <meta name="BASE_URL" content="{{ url('/') }}" />
        <meta name="UUID" content="{{Auth::user()->id}}" />
        <meta name="BASE_URL" content="{{ url('/') }}" />        
        <meta name="UNIB" content="{{ $user_role }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@get('title')</title>       
		
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

        <link href="{{ asset('local/public/themes/corex/assets/vendors/base/vendors.bundle.css') }} " rel="stylesheet" type="text/css" />      
        <link href="{{ asset('local/public/themes/corex/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('local/public/themes/corex/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('local/public/themes/corex/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ asset('local/public/img/logo/favicon.ico') }}" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

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
							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav ">
									
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i
											 class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Reports</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:1000px">
											<div class="m-menu__subnav">
												<ul class="m-menu__content">
													<li class="m-menu__item">
														<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Order Stage Report</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
														<ul class="m-menu__inner">
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('orderStagesReport')}}"      class="m-menu__link "><i class="m-menu__link-icon flaticon-map"></i><span class="m-menu__link-text">Pending Order start</span></a></li>
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('getOrderStageDaysWise')}}"  class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">Daywise Stage </span></a></li>
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('getStagesReportbyteam')}}"  class="m-menu__link "><i class="m-menu__link-icon flaticon-clipboard"></i><span class="m-menu__link-text">All Stage wise Report</span></a></li>
															
														</ul>
													</li>
													<li class="m-menu__item">
														<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Sales Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
														<ul class="m-menu__inner">
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('getMonthlySalesReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--line"><span></span></i><span class="m-menu__link-text">Monthly Sales Report</span></a></li>
															
														</ul>
													</li>
													<li class="m-menu__item">
														<h3 class="m-menu__heading m-menu__toggle"><span class="m-menu__link-text">Sample  Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></h3>
														<ul class="m-menu__inner">
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="{{ route('reportSalesGraph')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sample and Client feedback
																		</span></a></li>
															
														</ul>
													</li>
													
												</ul>
											</div>
										</div>
									</li>
									
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
            if($user_role=='Admin' || $user_role=='SalesUser'){
              ?>
            <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-users"></i>
                <span>Add Client</span>
              </span>
            </a>
            <a href="{{ route('sample.create') }}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-interface-3"></i>
                <span>Add Sample</span>
              </span>
            </a>
            <a href="{{ route('qcform.creates') }}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-edit-1"></i>
                <span>Add Order</span>
              </span>
            </a>
              <?php
            }

            ?>
            
            <a href="javascript::void(0)" onclick="print_SampeBO()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-technology"></i>
                <span>Print Sample</span>
              </span>
            </a>

               
                <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click"
                m-dropdown-persistent="1">
                 <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                   <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                   <span class="m-nav__link-icon"><i class="flaticon-alarm"></i></span>
                 </a>
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
                                     $alert_arr=AyraHelp::getAlarm();
                                   
                                     foreach ($alert_arr as $key => $alerm) {
                                       
                                        if($alerm->activity_type==1){
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
                                            $alert_arr=AyraHelp::getAlarm();
                                          
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

              <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
               m-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                  <span class="m-topbar__userpic">
                    <img src="{{ asset('local/public/img/avatar.jpg') }}" class="m--img-rounded m--marginless" alt="" />
                  </span>
                  <span class="m-topbar__username m--hide">{{Auth::user()->name}}</span>
                </a>
                <div class="m-dropdown__wrapper">
                  <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                  <div class="m-dropdown__inner">
                    <div class="m-dropdown__header m--align-center" style="background: url({{ asset('local/public/themes/corex/assets/app/media/img/bg/bg-2.jpg') }}">
                      <div class="m-card-user m-card-user--skin-dark">
                        <div class="m-card-user__pic">
                          <img src="{{ asset('local/public/img/avatar.jpg') }}" class="m--img-rounded m--marginless" alt="" />


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
                          <li class="m-nav__item">
                            <a href="#" class="m-nav__link">
                              <i class="m-nav__link-icon flaticon-share"></i>
                              <span class="m-nav__link-text">Activity</span>
                            </a>
                          </li>
                          <li class="m-nav__item">
                            <a href="#" class="m-nav__link">
                              <i class="m-nav__link-icon flaticon-chat-1"></i>
                              <span class="m-nav__link-text">Messages</span>
                            </a>
                          </li>
                          <li class="m-nav__separator m-nav__separator--fit">
                          </li>


                          <li class="m-nav__separator m-nav__separator--fit">
                          </li>
                          <li class="m-nav__item">
                            <a href="{{ route('logout') }}"    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
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
              <li id="m_quick_sidebar_toggle_" class="m-nav__item">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                  <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                </a>
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

            @partial('leftside')

				

					

					<!-- END: Subheader -->
					<div class="m-content">
         
				</div>
			</div>

			<!-- end:: Body -->
            @partial('footer')
			
		</div>

		<!-- end:: Page -->

		

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>

		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->
		

		<!-- begin::Quick Nav -->

		<!--begin::Global Theme Bundle -->
		<script src="{{ asset('local/public/themes/corex/assets/vendors/base/vendors.bundle.js') }} " type="text/javascript"></script>
		<script src="{{ asset('local/public/themes/corex/assets/demo/default/base/scripts.bundle.js') }} " type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="{{ asset('local/public/themes/corex/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		
		<script src="{{ asset('local/public/themes/corex/assets/app/js/datalist.js') }} " type="text/javascript"></script>

    <script src="{{ asset('local/public/themes/corex/assets/js/ajax_client_list_.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/ajax_sample_list_.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/ajax_orders_list_.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/stock.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/purchase.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/vendors.js') }}" type="text/javascript"></script>
    <!-- <script src = "{{ asset('local/public/themes/corex/assets/charts_loader.js') }}"></script> -->
    <script type = "text/javascript">
              google.charts.load('current', {packages: ['corechart']});     
    </script>
    <script src="{{ asset('local/public/themes/corex/assets/js/form_validation.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/js/ayra.js') }}" type="text/javascript"></script>
    <script src="{{ asset('local/public/themes/corex/assets/app/js/dashboard.js') }} " type="text/javascript"></script>
    <script type="text/javascript">
      BASE_URL=$('meta[name="BASE_URL"]').attr('content');
      UID=$('meta[name="UUID"]').attr('content');
      _TOKEN=$('meta[name="csrf-token"]').attr('content');
      _UNIB_RIGHT=$('meta[name="UNIB"]').attr('content');     
      
    </script>
        <script type="text/javascript">
       
          function chkInternetStatus() {
              if(navigator.onLine) {
                  //alert("Hurray! You're online!!!");
              } else {
                  alert("Oops! You're offline. Please check your network connection...");
              }
          }

          setInterval(function(){
            chkInternetStatus();
          }, 5000);

          </script>
		<!--end::Global Theme Bundle -->
	</body>

	<!-- end::Body -->
</html>