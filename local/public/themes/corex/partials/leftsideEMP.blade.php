

<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
   <!-- BEGIN: Aside Menu -->
   <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
   
      <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
         <li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="#" class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{Auth::user()->name}}</span>
            <span class="m-menu__link-badge"></span> </span></span></a>
         </li>
         <?php
            $route_name=AyraHelp::getRouteName();
             $user = auth()->user();
                 $userRoles = $user->getRoleNames();
                 $user_role = $userRoles[0];           
            
            ?>
         

            <!-- ajcode for new menu -->
            <?php
            if($user_role=='Admin'){
               ?>

           

         <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">
            HRMS</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
          
            <div class="m-menu__submenu ">
               <span class="m-menu__arrow"></span>
               <ul class="m-menu__subnav">
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('employee')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Employee</span></a>              
                </li>
                 
                <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('jobRole')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Job Roles</span></a>              
                </li>
               
              

                 
               </ul>
            </div>
         </li>


         

         


         
            <?php 
            }
            ?>

            <!-- ajcode for new menu -->

      </ul>
   </div>
   <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
<div class="m-grid__item m-grid__item--fluid m-wrapper">
