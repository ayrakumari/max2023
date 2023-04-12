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
         if ($user_role == 'chemist' || Auth::user()->id==89) {

            if ($route_name == 'client') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block;overflow:hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
            $strL = "R&D";

         ?>
            <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                  <span class="m-menu__link-text">{{$strL}}</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
               <div class="m-menu__submenu " style="{{$menu_style}}">
                  <span class="m-menu__arrow"></span>
                  <ul class="m-menu__subnav">
                     <!-- <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                     <span class="m-menu__link-text">Ingredients Suppliers</span></span>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Suppliers</span>

                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetBrandList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Brands</span>
                  </a>
               </li> -->
                     <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingredients')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients </span>
                  </a>
               </li> -->
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.formulation')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">RND Formulation </span>
                        </a>
                     </li>
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.formulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">RND Formulation List </span>
                        </a>
                     </li>

                     <?php 
                      if(Auth::user()->id==206 || Auth::user()->id==89 || Auth::user()->id==249 ){
                        ?>

                     <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FormulationBase')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation Base</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('IngredientsFormulationBaseList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation Base List </span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('IngredientsFormulationBaseListFrom')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Formulation List  From Base  </span>
                  </a>
               </li>
               
               
                        <?php
                      }
                     ?>



                     <!-- 
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetCategoryList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Category</span>
                  </a>
               </li> -->





                  </ul>
               </div>
            </li>
         <?php


         }



         if (Auth::user()->id == 172 || Auth::user()->id==253 ) {
            $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
            $menu_style = "display: block; overflow: hidden;";

         ?>
            <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                  <span class="m-menu__link-text">Samples</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
               <div class="m-menu__submenu " style="{{$menu_style}}">
                  <span class="m-menu__arrow"></span>
                  <ul class="m-menu__subnav">
                     <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                           <span class="m-menu__link-text">Samples</span></span>
                     </li>
                     <?php
                      if (Auth::user()->id==253) {
                         ?>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sample.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Sample List(ID Wise)</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Samples(ID Wise) Dispatech only</span>
                           </a>
                        </li>

                         <?php






                      }
                     if (Auth::user()->id == 172) {
                     ?>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Sample Technical Documents </span>
                           </a>
                        </li>

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Finish Product Price</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ingredientsPrice')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Ingredients Price</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FAQAboutIngredentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Technical Questions </span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ordertechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Order Technical Documents </span>
                           </a>
                        </li>

                     <?php
                     }

                     ?>
                  </ul>
               </div>
            </li>
         <?php
         }
         ?>



         <?php


         $userHeadAccess = 0;
         if ($user->id == 90000) {
            $userHeadAccess = 1;
         }
         $userHeadAccess;

         if ($user_role !== 'User' || $userHeadAccess == 1) {

         ?>
            <?php
            if ($route_name == 'client') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }

            if ($route_name == 'clientv1') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }

            ?>
            <?php
            if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 90 || Auth::user()->id ==146 || Auth::user()->id == 176 || Auth::user()->id == 85 || Auth::user()->id == 234) {

               $dataP_arr = DB::table('payment_recieved_from_client')->where('payment_status', 0)->orderBy('id', 'desc')->where('is_deleted', 0)->get();
               $date_from = '2020-03-12 16:10:00';


               $paymentOrderArr = DB::table('qc_forms')->where('is_deleted', 0)->where('created_at', '>=', $date_from)->where('account_approval', 0)->get();

               $totP = count($paymentOrderArr) + count($dataP_arr);


            ?>
               <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle">
                     <i class="m-menu__link-icon flaticon-clipboard"></i>
                     <span class="m-menu__link-text">
                        Account
                        <span class="m-badge m-badge--warning">
                           {{$totP}}

                        </span>
                     </span>
                     <i class="m-menu__ver-arrow la la-angle-right"></i>
                  </a>
                  <div class="m-menu__submenu " style="{{$menu_style}}">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">BO Clients V1</span></span></li>

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('paymentRecievedLIST')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                              <span class="m-menu__link-text">Payment List
                                 <span class="m-badge m-badge--warning">
                                    {{count($dataP_arr)}}

                                 </span>
                              </span>
                           </a>
                        </li>
                       

                        <?php
                        if (Auth::user()->id == 85 || Auth::user()->id == 234) {
                        } else {
                        ?>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('orderApprovalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                                 <span class="m-menu__link-text">Order Approval List
                                    <span class="m-badge m-badge--warning">
                                       {{count($paymentOrderArr)}}
                                    </span>
                                 </span>
                              </a>
                           </li>
                        <?php
                        }
                        ?>






                     </ul>
                  </div>
               </li>

            <?php


            }

            //--------account
            if ($user_role == 'AdminOK') {
            ?>
               <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle">
                     <i class="m-menu__link-icon flaticon-clipboard"></i>
                     <span class="m-menu__link-text">
                        Clients v1
                        <span class="m-menu__link-badge">

                        </span>
                     </span>
                     <i class="m-menu__ver-arrow la la-angle-right"></i>
                  </a>
                  <div class="m-menu__submenu " style="{{$menu_style}}">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">BO Clients V1</span></span></li>

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('clientv1')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Client List</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('clientv1Leads')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Client Leads</span>
                           </a>
                        </li>



                     </ul>
                  </div>
               </li>

            <?php



            }
            //--------account


            ?>
            <?php
            /*
             <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle">
                     <i class="m-menu__link-icon flaticon-clipboard"></i>
                     <span class="m-menu__link-text">
                        Clients
                        <span class="m-menu__link-badge">

                        </span>
                     </span>
                     <i class="m-menu__ver-arrow la la-angle-right"></i>
                  </a>
                  <div class="m-menu__submenu " style="{{$menu_style}}">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Clients</span></span></li>
                        @can('view-client-list')
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('client.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Client List</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessListOwn')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> My Lead</span></a>

                           @endcan
                           <?php
                           if ($userHeadAccess == 1) {
                           ?>

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('client.notes')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Client Notes</span>
                           </a>
                        </li>
                     <?php
                           }
                     ?>

                     @can('view-notes-list')
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{route('client.notes')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Client Notes</span>
                        </a>
                     </li>
                     @endcan
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getQutatationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Quotation List</span></a>

                     </ul>
                  </div>
               </li>
            */
            ?>


            <?php

            if ($userHeadAccess == 1 || $user_role == 'CourierTrk' || $user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'Staff' || $user->hasPermissionTo('view-client-list')) {
               if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == 156) {
                  $strM = "All";
               } else {
                  $strM = "My";
               }
            ?>
               <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle">
                     <i class="m-menu__link-icon flaticon-clipboard"></i>
                     <span class="m-menu__link-text">
                        {{$strM}} Leads
                        <span class="m-menu__link-badge">

                        </span>
                     </span>
                     <i class="m-menu__ver-arrow la la-angle-right"></i>
                  </a>
                  <div class="m-menu__submenu " style="{{$menu_style}}">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Clients</span></span></li>
                        @can('view-client-list')
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('clientLeadV3')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text"> {{$strM}} Leads List</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('AddNewLead')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Add New Lead</span></a>



                           - </li>

                        <?php
                        if (Auth::user()->id == 1 || Auth::user()->id == 90 || Auth::user()->id == 171) {
                        ?>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('combinedLeadTransfer')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Combined Lead Transfer </span></a>


                           </li>

                        <?php
                        }
                        if (Auth::user()->id == 1) {
                        ?>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('oncreditList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> On Credit List </span></a>

                           </li>

                        <?php
                        }
                        ?>


                        @endcan
                     </ul>
                  </div>
               </li>
            <?php
            }
            ?>
            <!---menu--->
            <?php
            if ($route_name == 'sample') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
            ?>
            <?php
            // if (Auth::user()->id == 159 || Auth::user()->id == 160 || Auth::user()->id == 162 || Auth::user()->id == 161 || Auth::user()->id == 162 || Auth::user()->id == 163 || Auth::user()->id == 164  || Auth::user()->id == 165 || Auth::user()->id == 166 || Auth::user()->id == 167 || Auth::user()->id == 168 || Auth::user()->id == 169 || Auth::user()->id == 170) {
            if (Auth::user()->id == 1593) {

            ?>
               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        Lead Management </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true">
                           <a href="{{ route('getINDMartDataLeadManagerView_Intern')}}" class="m-menu__link ">
                              <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">All Leads</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>


               <?php


               ?>
               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        Assigned Leads <span class="m-badge m-badge--warning" title="Assign Lead Count Today"></span> </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Assigned Leads</span></a>
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getQutatationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Quotation List</span></a> -->
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getAllLeadUntouch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh Leads</span></a> -->




                        </li>








                     </ul>
                  </div>
               </li>


            <?php
            }

            if ($user_role == 'Intern') {


            ?>
               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        My Leads <span class="m-badge m-badge--warning" title="Assign Lead Count Today"></span> </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">My Leads</span></a>
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getQutatationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Quotation List</span></a> -->
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getAllLeadUntouch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh Leads</span></a> -->




                        </li>








                     </ul>
                  </div>
               </li>

               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        Samples <span class="m-badge m-badge--warning" title="Assign Lead Count Today"></span> </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sample.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Sample List(ID Wise)</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Samples(ID Wise) Dispatech only</span>
                           </a>
                        </li>
                     </ul>
                  </div>

               </li>

               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        Lead Management </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true">
                           <a href="{{ route('getINDMartDataLeadManagerView_Intern')}}" class="m-menu__link ">
                              <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">All Leads</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>


               <!-- ajasss -->
               <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                        Pricing </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu ">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">

                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Finish Product Price</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ingredientsPrice')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Ingredients Price</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
               <!-- ajasss -->
            <?php

            } else {
            ?>
               <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                  <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                     <span class="m-menu__link-text">Samples</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                  <div class="m-menu__submenu " style="{{$menu_style}}">
                     <span class="m-menu__arrow"></span>
                     <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                              <span class="m-menu__link-text">Samples</span></span>
                        </li>

                        <?php
                        if ($user_role == 'Admin' || Auth::user()->id==249 || Auth::user()->id==219 ) {
                        ?>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sample.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Sample List(ID Wise)</span>
                              </a>
                           </li>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Samples(ID Wise) Dispatech only</span>
                           </a>
                          </li>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Sample List(Item Wise)</span>
                              </a>
                           </li>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleHighPriority')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">High Priority Samples List</span>
                              </a>
                           </li>

                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Technical Documents </span>
                              </a>
                           </li>


                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('samplePendingAprrovalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Pending Approval List</span>
                              </a>
                           </li>
                           <?php
                        } else {

                           if ($user_role != 'chemist') {
                              if (Auth::user()->id == 217 ||  Auth::user()->id == 202) {
                              } else {

                                 if(Auth::user()->id == 241){

                                    ?>
                                  
                     
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sample.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Sample List(ID Wise)</span>
                              </a>
                           </li>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Samples(ID Wise) Dispatech only</span>
                           </a>
                          </li>
                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Sample List(Item Wise)</span>
                              </a>
                           </li>
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleHighPriority')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">High Priority Samples List</span>
                              </a>
                           </li> -->

                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Technical Documents </span>
                              </a>
                           </li>


                           <li class="m-menu__item " aria-haspopup="true"><a href="{{route('samplePendingAprrovalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Pending Approval List</span>
                              </a>
                           </li>
                           <?php
                        

                                 }else{
                                    ?>
                                    <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleListSales')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                          <span class="m-menu__link-text">Sample List</span>
                                       </a>
                                    </li>
                              <?php
                                 }
                          

                              }
                           }
                           ?>

                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationListSales')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Sample List[Item Wise]</span>
                              </a>
                           </li> -->

                           <?php
                           if ($user_role == 'SalesHead') {

                           ?>
                              <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Sample Formulation List</span>
                                 </a>
                              </li>
                              <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleHighPriority')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">High Priority Samples List</span>
                                 </a>
                              </li>

                              <?php
                           }
                           if ($user_role != 'chemist') {
                              if (Auth::user()->id == 217 ||  Auth::user()->id == 202) {
                              } else {
                              ?>
                                 <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                       <span class="m-menu__link-text">Technical Documents </span>
                                    </a>
                                 </li>
                        <?php
                              }
                           }
                        }
                        ?>

                        @can('sample-pending-view')
                        <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('sample.pending.feedback')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Sample Pending Feedback</span>
                           </a>
                        </li> -->
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FAQAboutIngredentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Technical Questions </span>
                           </a>
                        </li>
                        @endcan


                     </ul>
                  </div>
               </li>
            <?php
            }
            ?>

            <!---menu--->

            <!---menu--->
            <?php
            if ($route_name == 'orders') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
            ?>


            <?php

            if ($user_role == 'Intern') {
               //echo "Ayra";
            } else {

               if (Auth::user()->id == 130 || Auth::user()->id == 131) {
               } else {
            ?>
                  <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                     <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
                        <span class="m-menu__link-text">Orders</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                     <div class="m-menu__submenu " style="{{$menu_style}}">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform.creates')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">Add New Order</span>
                              </a>
                           </li> -->
                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform.list')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Orders List</span>
                           </a>
                        </li> -->
                           <?php
                           if (Auth::user()->id == 1 || Auth::user()->id==249) {
                           ?>
                              <li class="m-menu__item " aria-haspopup="true"><a href="{{route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Orders List</span>
                                 </a>
                              </li>
                              <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Dispatch Orders List</span>
                                 </a>
                              </li>
                              
                              <li class="m-menu__item " aria-haspopup="true"><a href="{{route('v1_getOrderslistPending')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Pending Orders List</span>
                                 </a>
                              </li>

                              <?php
                           } else {
                              if ($user_role != 'chemist') {
                                 if (Auth::user()->id == 217 ||  Auth::user()->id == 202) {
                                 } else {
                              ?>
                                    <li class="m-menu__item " aria-haspopup="true"><a href="{{route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                          <span class="m-menu__link-text">Orders List</span>
                                       </a>
                                    </li>
                           <?php
                                 }
                              }
                           }
                           ?>

                           <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('orderList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Orders Statges</span>
                           </a>
                        </li> -->
                           <?php
                           if ($user_role != 'chemist') {
                              if (Auth::user()->id == 217 ||  Auth::user()->id == 202 || Auth::user()->id == 234 ) {
                              } else {
                           ?>
                                 <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                       <span class="m-menu__link-text">Orders Dispatched</span>
                                    </a>
                                 </li>
                                 <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ordertechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                       <span class="m-menu__link-text">Order Technical Doc </span>
                                    </a>
                                 </li>
                           <?php
                              }
                           }
                           ?>

                           <?php

                           if ($user_role == 'Admin' || $user_role == 'CourierTrk' || Auth::user()->id == 84) {
                           ?>
                              <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform_getList_BulkList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Bulk Orders List </span>
                                 </a>
                              </li> -->
                           <?php
                           }
                           ?>
                           {{-- <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                        <span class="m-menu__link-text">Orders</span></span>
                     </li> --}}
                           {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('orders.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Orders List</span>
                           </a>
                  </li> --}}
                  {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('backOrderUpload')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Upload Orders</span>
                  </a>
                  </li> --}}


      </ul>
   </div>
   </li>

<?php
               }
            }

?>
<!-- added export account  -->
<?php
            if (Auth::user()->id == 143 || Auth::user()->id == 76 ||  Auth::user()->id == 158 ||  Auth::user()->id == 178 || Auth::user()->id == 165) {

               if ($route_name == 'getINDMartDataLeadManagerViewExport') {
                  $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
                  $menu_style = "display: block; overflow: hidden;";
               } else {
                  $menu_class = 'm-menu__item  m-menu__item--submenu';
                  $menu_style = "";
               }
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Foreign Lead</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Foreign Lead</span></span>
            </li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('getINDMartDataLeadManagerViewExport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Foreign Lead List</span>
               </a>
            </li>

         </ul>
      </div>
   </li>

<?php

            }
?>

<!-- added export account  -->


<?php
            if ($user_role == 'Admin' || Auth::user()->id == 95 || Auth::user()->id == 132 ||  Auth::user()->id == 176) {
               $sirCount = AyraHelp::getSaleInvoiceRequestCount();
?>
   <!-- invoice -->
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Invoices Request <span class="m-badge m-badge--warning">
               {{$sirCount}}

            </span>

         </span>
         <i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">

            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('getSalesInoviceRequest')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Sales Invoice Request
                     <span class="m-badge m-badge--warning">
                        {{$sirCount}}


                     </span>
                  </span>
               </a>
            </li>


         </ul>
      </div>
   </li>


   <!-- invoice -->

<?php
            }
?>

<!---menu--->
{{-- OrderItemMaterial --}}
<!---menu--->
<?php
            if ($route_name == 'stocks') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
?>
<?php
            if ($user_role == 'AdminA' || $user_role == 'StockA' || $user_role == 'StaffA') {
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover" class="m-menu__item">
      <a href="javascript:;" class="m-menu__link m-menu__toggle">
         <i class="m-menu__link-icon flaticon-business"></i>
         <span class="m-menu__link-text">Stock</span>
         <i class="m-menu__ver-arrow la la-angle-right"></i>
      </a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Stock</span></span>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.entry')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Stock Entry</span>
               </a>
            </li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Stock List</span>
               </a>
            </li>
            {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
            <span class="m-menu__link-text">Issue List</span>
            </a>
   </li> --}}
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('recievedOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Pending received Items</span>
      </a>
   </li>
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Wastage List</span>
   </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Return List</span>
   </a>
   </li> --}}
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stock.req.alert')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Pending Issues Items</span>
      </a>
   </li>


   </ul>
</div>
</li>
<!---menu--->
<?php
            }
?>

<!---menu--->
<?php
            if ($route_name == 'purchase') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
?>
<?php
            if ($user_role == 'Admin' || $user_role == 'Staff' || Auth::user()->id == 88) {


?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover" class="m-menu__item">
      <a href="javascript:;" class="m-menu__link m-menu__toggle">
         <i class="m-menu__link-icon flaticon-business"></i>
         <span class="m-menu__link-text">Purchase</span>
         <i class="m-menu__ver-arrow la la-angle-right"></i>
      </a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Purchase</span></span>
            </li>
            {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('purchaseList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
            <span class="m-menu__link-text">Purchase List</span>
            </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Vendor List</span>
   </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Quotation Infomation</span>
   </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Enquery</span>
   </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('stocks.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Return List</span>
   </a>
   </li> --}}
   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('purchasedOrdersList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Pending Purchase Orders</span>
   </a>
   </li>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('purchase.req.alert')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Pending for Purchase</span>
      </a>
   </li>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('purchase.reserved')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Pending for Reserved</span>
      </a>
   </li>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('vendors.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Vendors List</span>
      </a>
   </li> --}}


   {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('vendors.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
   <span class="m-menu__link-text">Vendors List</span>
   </a>
   </li> --}}
   <?php
               if (Auth::user()->hasPermissionTo('viewPurchaseListPermission')) {
   ?>


      <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseListLB')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Purchase LABEL BOX</span></a> -->
      <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseListLabelBox')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Purchase LABEL BOX</span></a>

      </li>

      <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Purchase BOM</span></a> -->

      <!-- </li> -->


   <?php

               }
   ?>
   <?php
               if (Auth::user()->hasPermissionTo('viewProductionListPermission')) {
   ?>
      <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform.qcFROMProductionList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
            <span class="m-menu__link-text">Production </span>
         </a>
      </li>
   <?php
               }
   ?>
   </ul>
   </div>
   </li>
   <!---menu--->
<?php
            }

?>

<!---menu--->
<?php
            if ($user_role == 'Admin'  || $user_role == 'SalesHead' || $user_role == 'SalesUser'  || Auth::user()->id == 103 || Auth::user()->id == 102 || Auth::user()->id == 84 ||  Auth::user()->id == 202) {

               if ($route_name == 'ingredient-list' || $route_name == 'ingredient-brand-list') {
                  $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
                  $menu_style = "display: block; overflow: hidden;";
               } else {
                  $menu_class = 'm-menu__item  m-menu__item--submenu';
                  $menu_style = "";
               }


               if ($user_role == 'SalesUser' || Auth::user()->id == 202) {
                  $strL = "PRICING";
               } else {
                  $strL = "R&D";
               }

?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">{{$strL}}</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">


            <?php
               if ($user_role == 'SalesUser' || Auth::user()->id == 202) {
            ?>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Finish Product Price</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ingredientsPrice')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Price</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('NewProductProductDevlopmentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Product Development</span>
                  </a>
               </li>


            <?php
               } else {
            ?>
               <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                     <span class="m-menu__link-text">Ingredients Suppliers</span></span>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Suppliers</span>

                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetBrandList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Brands</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingredients')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients </span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.formulation')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation </span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.formulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation List </span>
                  </a>
               </li>
              
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FormulationBase')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation Base</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('IngredientsFormulationBaseList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">RND Formulation Base List </span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('IngredientsFormulationBaseListFrom')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Formulation List  From Base  </span>
                  </a>
               </li>
               



               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetCategoryList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Ingredients Category</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('finishProductCategory')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Finish Prouduct Category</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('finishProductSubCategory')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Finish Prouduct Sub Category</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Finish Product</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('NewProductProductDevlopmentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Product Development</span>
                  </a>
               </li>
            <?php
               }
            ?>


         </ul>
      </div>
   </li>
   <!---menu--->

<?php
            }
?>


<?php
            if ($user_role == 'SalesHead') {
?>
   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            All Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">

            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getMonthlySalesReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Monthly Sales Report
                  </span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('client_paymentRecieved_report')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">payment Received Report
                  </span></a>
            </li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('feedbackSampleGraph')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Feedback Sample PIE Chart </span></a>
            </li>

         </ul>
      </div>
   </li>

<?php
            }

?>


<!---menu--->
<?php
            if ($route_name == 'sample') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
?>
<?php
            if ($user_role == 'Admin' || $user_role == 'Staff') {
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Operation Health</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <?php
               if (Auth::user()->hasPermissionTo('orderStatgeMaintain')) {
            ?>
               <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                     <span class="m-menu__link-text">Operation Health</span></span>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('operationsHealth.create')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Add New Operation</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('operationsHealth.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Operation List</span>
                  </a>
               </li>
            <?php
               }
            ?>

            <?php
               if (Auth::user()->hasPermissionTo('designStageMaintainPermission')) {
            ?>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('sapCheckList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">SAP CheckList</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('operationPlan')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Operation Plan</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getOperationHealthPlanList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Operation Plan List</span>
                  </a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('orderPlanList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Order Plan</span>
                  </a>
               </li>




            <?php
               }
            ?>

         </ul>
      </div>
   </li>
<?php

            }
?>

<!---menu--->

<?php

            if ($user_role != 'Admin') {

?>

   <?php
               if (Auth::user()->id == 95 || Auth::user()->id == 84) {
   ?>
      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
         <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
               Packaging Catalog List</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

         <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getOrderStageDaysWisev1')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Stage Completed Graph </span></a>
               </li>

               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLog')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Add Packaging Catalog</span></a>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLogList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Packaging Catalog List</span></a>
               </li>


            </ul>
         </div>
      </li>
   <?php
               }
   ?>


   <?php
               if (Auth::user()->id == 88 || Auth::user()->id == 84) {
   ?>
      <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('dispatchedReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Dispatch Grapgh </span></a>
      </li>

<?php
               }
            }

?>




<!---menu--->
<!-- ajcode -->

<?php

            if ($user_role == 'Intern') {
               echo "Ayra";
            } else {
               if ($user_role != 'Admin') {

                  if (Auth::user()->id != 95 || Auth::user()->id != 84) {

                     if ($user_role != 'chemist') {
                        if (Auth::user()->id == 2173 ||  Auth::user()->id == 2023) {
                        } else {
?>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                     Packaging Catalog List..</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

               <div class="m-menu__submenu ">
                  <span class="m-menu__arrow"></span>
                  <ul class="m-menu__subnav">

                     <?php
                        if (Auth::user()->id == 85 || Auth::user()->id == 234) {
                     ?>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLog')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Add Packaging Catalog</span></a>
                        </li>

                     <?php
                        }
                     ?>

                     <?php
                        if ($user_role != 'chemist') {
                     ?>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLogList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Packaging Catalog List</span></a>
                        </li>
                     <?php
                        }
                     ?>



                  </ul>
               </div>
            </li>
         <?php
                        }

                     }
         ?>

<?php
                  }
               }
            }

?>

<?php


            if ($user_role == 'SalesUser' || $user_role == 'SalesHead' || $user_role == 'Staff') {


               //if (Auth::user()->id == 159 || Auth::user()->id == 160 || Auth::user()->id == 162 || Auth::user()->id == 161 || Auth::user()->id == 162 || Auth::user()->id == 163 || Auth::user()->id == 164  || Auth::user()->id == 165 || Auth::user()->id == 166 || Auth::user()->id == 167 || Auth::user()->id == 168 || Auth::user()->id == 169 || Auth::user()->id == 170) {
               if (Auth::user()->id == 1595) {
               } else {



                  if (Auth::user()->hasPermissionTo('LeadManagementSalesDashboard')) {


?>
         <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
                  Leads <span class="m-badge m-badge--warning" title="Assign Lead Count Today"></span> </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu ">
               <span class="m-menu__arrow"></span>
               <ul class="m-menu__subnav">
                  <?php
                     if (Auth::user()->hasPermissionTo('LeadManagementSalesDashboard_Access')) {
                  ?>

                     <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessListOwnClient')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> My Lead</span></a>
                     
                     </li>
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessListOwnClient')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Add New Lead</span></a>
                     
                     </li> -->
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getLeadsAcceessList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Leads</span></a>
                     </li>

                     <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getQutatationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Quotation List</span></a> -->
                     <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getAllLeadUntouch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh Leads</span></a> -->
                     <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getAllAvaibleLeadData')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh Leads</span></a>



                     </li>


                  <?php
                     }
                  ?>





               </ul>
            </div>
         </li>
<?php

                  }
               }
            }
?>


<?php
            if (Auth::user()->hasPermissionTo('LeadManagement')) {

               if (Auth::user()->id == 1 || Auth::user()->id == 90 ||  Auth::user()->id == 217 || Auth::user()->id == 134 || Auth::user()->id == 141 ||  Auth::user()->id == 202 || Auth::user()->id==221) {
?>
      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
         <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
               Lead Management</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
         <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
               <?php
                  if (Auth::user()->hasPermissionTo('LeadManagement_FreshLead')) {
               ?>
                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getINDMartDatav2')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads</span>
                     </a>
                  </li>
                  <!-- <li class="m-menu__item " aria-haspopup="true">
                              <a href="{{ route('getINDMartDataNEW')}}" class="m-menu__link ">
                                 <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                 <span class="m-menu__link-text">DEMO TESTING</span>
                              </a>
                           </li> -->
                  <?php
                     if (Auth::user()->id == 90 || Auth::user()->id == 1 ||  Auth::user()->id == 171 ||  Auth::user()->id == 217 ||  Auth::user()->id == 202 ) {
                  ?>
                     <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getclaimleadGraph')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Claim Lead graph</span>
                        </a>
                     </li>
                     <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getDatewiseLeadAssign')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Lead Assigned List</span>
                        </a>
                     </li>

                     <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getAllAvaibleLeadData')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh & Verified Leads</span></a>


                     <?php

                     }
                     ?>




                     <!-- <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getLeadManagerReport')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Lead Manager Report</span>
                        </a>
                     </li> -->
                     <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getLeadReports')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Leads Reports</span>
                        </a>
                     </li>
                     <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getLeadReports_Dist')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Leads Distribution </span>
                        </a>
                     </li>
                     <!-- <li class="m-menu__item " aria-haspopup="true">
                        <a href="{{ route('getLeadStagesGrapgh')}}" class="m-menu__link ">
                           <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                           <span class="m-menu__link-text">Leads Stages Grapgh </span>
                        </a>
                     </li> -->
                     <?php
                     if (Auth::user()->id == 1 || Auth::user()->id == 90 ||  Auth::user()->id == 171) {
                     ?>
                        <li class="m-menu__item " aria-haspopup="true">
                           <a href="{{ route('getLeadInboutCallGrapgh')}}" class="m-menu__link ">
                              <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Leads Inboud Call </span>
                           </a>
                        </li>
                     <?php
                     }
                     ?>




                  <?php
                  }

                  ?>





            </ul>
         </div>
      </li>



<?php

               }
            }
?>

<!---menu--->
<!-- ajcode -->
<?php
            if ($route_name == 'rawclientdata') {
               $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
               $menu_style = "display: block; overflow: hidden;";
            } else {
               $menu_class = 'm-menu__item  m-menu__item--submenu';
               $menu_style = "";
            }
?>
<?php
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            if ($user_role == 'Admin' || $user_role == 'SalesUser' || Auth::user()->id == 102) {
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Client Raw Data</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Client Raw Data</span></span>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rawclientdata.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Raw Data List</span>
               </a>
            </li>
         </ul>
      </div>
   </li>
   {{-- <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
   <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
      <span class="m-menu__link-text">EXPORT & IMPORT</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
   <div class="m-menu__submenu " style="{{$menu_style}}">
      <span class="m-menu__arrow"></span>
      <ul class="m-menu__subnav">
         <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
               <span class="m-menu__link-text">Items</span></span>
         </li>
         <li class="m-menu__item " aria-haspopup="true"><a href="{{route('import-export')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
               <span class="m-menu__link-text">Items</span>
            </a>
         </li>
      </ul>
   </div>
   </li> --}}



<?php
            }
            if ($user_role == 'Admin') {
?>

   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            Users Management</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Users Management</span></span></li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="{{ route('users.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Users</span></a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="{{ route('roles.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Roles</span></a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="{{ route('permissions.index')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Permissions</span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('jobRole')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Job Roles</span></a>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getINDMartData')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fresh Leads</span></a>



         </ul>
      </div>
   </li>

   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle">
         <i class="m-menu__link-icon flaticon-interface-7"></i>
         <span class="m-menu__link-text">
            Team Management</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Teams Management</span></span></li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
               <a href="{{route('boteamList')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Teams List</span></a>
            </li>
         </ul>
      </div>
   </li>

   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            All Reports</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">All Reports</span></span></li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('reportSampleReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Samples Report
                  </span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('reportSalesGraph')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sales Report
                  </span></a>
            </li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getStagesReportbyteam')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Stages By Reports
                  </span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getMonthlySalesReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Monthly Sales Report
                  </span></a>
            </li>


            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('feedbackSampleGraph')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Feedback Sample PIE Chart </span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('orderStagesReport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Order Stage Report </span></a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getOrderStageDaysWisev1')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Stage Report by Daywise</span></a>
            </li> -->
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('BoReports')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">My Reports</span></a> -->
   </li>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLog')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Packaging Options Catalog</span></a>
   </li>
   </ul>
   </div>
   </li>


   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            Pakaging Catalog</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLog')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Add Packaging Catalog</span></a>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('packagingOptionCategLogList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Packaging Catalog List</span></a>
            </li>


         </ul>
      </div>
   </li>

<?php
            }

?>
<!---menu--->

<!-- ajcode for new menu -->
<?php
            if (Auth::user()->id == 17141) {
?>

   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            Order List</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>

      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">All Orders</span></a>

            </li>
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseListLB')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Purchase Label</span></a> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseListLabelBox')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Purchase Label</span></a>

            </li>

            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('boPurchaseList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Purchase BOM</span></a>

            </li> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('vendors.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Vendors List</span>
               </a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('getOrderStageDaysWisev1')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Stage Report by Daywise</span></a>


            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('stageCompletdFilterV1')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Stages Completed Filter</span></a>

            </li>
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform.list')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">OLD Orders List</span>
               </a>
            </li> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFROMPurchaseListPrintedLabel')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Printed BOX LABEL</span>
               </a>
            </li>

            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform.purchaselist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Purchase List </span>
               </a>
            </li>

         </ul>
      </div>
   </li>
   <?php
               if ($user_role == 'AdminA' || $user->hasPermissionTo('view-employee')) {
   ?>

      <!-- <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-text">
            HRMS</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
          
            <div class="m-menu__submenu ">
               <span class="m-menu__arrow"></span>
               <ul class="m-menu__subnav">
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('hrms_dashboard')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">HRMS Dashboard</span></a>
               
               </li>
              
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('employee')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Employee</span></a>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('upload_epm_attendance')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Attendance</span></a>
               
                  </li>
                 
               
              

                 
               </ul>
            </div>
         </li> -->

   <?php
               }
   ?>







<?php
            }
         }
?>

<!-- hrms -->

<?php
if (Auth::user()->id == 27) {

   if ($route_name == 'ingredient-list' || $route_name == 'ingredient-brand-list') {
      $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
      $menu_style = "display: block; overflow: hidden;";
   } else {
      $menu_class = 'm-menu__item  m-menu__item--submenu';
      $menu_style = "";
   }
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">R&D</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <!-- <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Ingredients Suppliers</span></span>
            </li> -->
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Ingredients Suppliers</span>

               </a>
            </li> -->
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetBrandList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Ingredients Brands</span>
               </a>
            </li> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingredients')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Ingredients </span>
               </a>
            </li>

            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingrednetCategoryList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Ingredients Category</span>
               </a>
            </li> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Finish Product</span>
               </a>
            </li>
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('NewProductProductDevlopment')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Product Development</span>
                     </a>
                  </li> -->
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('NewProductProductDevlopmentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Product Development</span>
               </a>
            </li>

         </ul>
      </div>
   </li>
   <!---menu--->

<?php
}
?>






<?php
if (Auth::user()->id == 174 || Auth::user()->id == 185) {
   $sirCount = AyraHelp::getSaleInvoiceRequestCount();


   if ($route_name == 'get-sales-invoice') {
      $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
      $menu_style = "display: block; overflow: hidden;";
   } else {
      $menu_class = 'm-menu__item  m-menu__item--submenu';
      $menu_style = "";
   }
?>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">


      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Invoices Request <span class="m-badge m-badge--warning">
               {{$sirCount}}
            </span>

         </span>
         <i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">

            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('getSalesInoviceRequest')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Sales Invoice Request
                     <span class="m-badge m-badge--warning">
                        {{$sirCount}}

                     </span>
                  </span>
               </a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Orders List
                  </span>
               </a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Finish Product Price</span>
                     </a>
                  </li>


         </ul>
      </div>
   </li>
   </li>


<?php

}
?>

<!-- packegng  lead  -->


<?php
if (Auth::user()->id == 173) {
?>
   <!-- <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
      <a href="{{route('QCAccess')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text" style='color:#FFFFFF'>QC LIST</span>
               <span class="m-menu__link-badge"></span> </span></span>
      </a>
   </li> -->
   <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">All Orders</span></a>
      <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Orders Dispatched</span>
      </a>
   </li> -->


   <?php

}
   ?>


   <?php
   if (Auth::user()->id == 88 || Auth::user()->id == 196 || Auth::user()->id == 219 || Auth::user()->id == 212 ) {
   ?>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">All Orders</span></a>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">All Dispatched Orders </span></a>
  
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sample.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Sample List(ID Wise)</span>
                           </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">Samples(ID Wise) Dispatech only</span>
                           </a>
                        </li>
   <?php

   }

   if (Auth::user()->id == 88 || Auth::user()->id == 147) {
   ?>
      <!-- <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
      <a href="{{route('QCAccess')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-user"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text" style='color:#FFFFFF'>QC LIST</span>
               <span class="m-menu__link-badge"></span> </span></span>
      </a>
   </li> -->
   <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">All Orders</span></a>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Orders Dispatched</span>
      </a>
   </li>
   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('getSalesInoviceRequest')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
         <span class="m-menu__link-text">Sales Invoice Request

         </span>
      </a>
   </li>


<?php

   }
?>


<?php
if (Auth::user()->id == 27 ||  Auth::user()->id == 146 || Auth::user()->id == 124 ||  Auth::user()->id == 187 || Auth::user()->id == 189) {

   if ($route_name == 'sample') {
      $menu_class = 'm-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--hover';
      $menu_style = "display: block; overflow: hidden;";
   } else {
      $menu_class = 'm-menu__item  m-menu__item--submenu';
      $menu_style = "";
   }
?>

   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle">
         <i class="m-menu__link-icon flaticon-clipboard"></i>
         <span class="m-menu__link-text">
            MY Leads
            <span class="m-menu__link-badge">

            </span>
         </span>
         <i class="m-menu__ver-arrow la la-angle-right"></i>
      </a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Clients</span></span></li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('clientLeadV3')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">My Leads List</span>
               </a>
            </li>
            <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('AddNewLead')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text"> Add New Lead</span></a>



               - </li>

            <?php


            ?>


         </ul>
      </div>
   </li>


   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Samples</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Samples</span></span>
            </li>
            <?php
            if (Auth::user()->id == 27 || Auth::user()->id == 146 || Auth::user()->id == 188 || Auth::user()->id == 189) {
               if(Auth::user()->id==146){
                  ?>
                   <li class="m-menu__item " aria-haspopup="true"><a href="{{route('paymentRecievedLIST_SAMPLE')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

<span class="m-menu__link-text">Payment List Samples
  
</span>
</a>
</li>
                  <?php
               }
            ?>
            
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleListOils')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Oils Sample List</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Sample Formulation List</span>
                  </a>
               </li>


               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleListCosmatic_OILView')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                     <span class="m-menu__link-text">Cosmatic Sample List</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleHistory')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                     <span class="m-menu__link-text">Samples History</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Technical Documents </span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FAQAboutIngredentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Technical Questions </span>
                  </a>
               </li>




               <?php
            } else {
               if (Auth::user()->id == 187) {
               ?>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Sample Formulation</span>
                     </a>
                  </li>


               <?php

               } else {
               ?>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleFormulationList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Sample Formulation</span>
                     </a>
                  </li>

                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleListCosmatic')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                        <span class="m-menu__link-text">Cosmatic Sample List</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampleHistory')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>

                        <span class="m-menu__link-text">Samples History</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('sampletechnicalList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Technical Documents </span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('FAQAboutIngredentList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Technical Questions </span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.formulation')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Formulation</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.ingredients')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Ingredients </span>
                     </a>
                  </li>

            <?php
               }
            }

            ?>
         </ul>
      </div>
   </li>
   <li class="{{$menu_class}}" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i>
         <span class="m-menu__link-text">Orders</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu " style="{{$menu_style}}">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link">
                  <span class="m-menu__link-text">Orders List</span></span>
            </li>
            <?php

            if (Auth::user()->id == 124) {
            ?>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Orders List</span>
                  </a>
               </li>
            <?php
            }
            ?>

            <?php

            if (Auth::user()->id == 146 || Auth::user()->id == 27 || Auth::user()->id == 189) {



            ?>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('v1_getOrderslist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Orders List</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('getBulkOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Bulk Orders List</span>
                  </a>
               </li>
               <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Orders Dispatched</span>
                  </a>
               </li>



            <?php
            }

            ?>


         </ul>
      </div>
   </li>

<?php

}
?>

<!-- packegng  lead  -->
<?php

if (Auth::user()->id == 4 || Auth::user()->id == 1 || Auth::user()->id == 158 || Auth::user()->id == 156) {
?>
   <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
      <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
            Packaging Lead </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu ">
         <span class="m-menu__arrow"></span>
         <ul class="m-menu__subnav">

            <li class="m-menu__item " aria-haspopup="true">
               <a href="{{ route('getPackingLead')}}" class="m-menu__link ">
                  <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Packaging Lead </span>
               </a>
            </li>


         </ul>
      </div>
   </li>



<?php

}

?>


<!-- packegng  lead  -->

<?php
if (Auth::user()->hasPermissionTo('LeadManagement')) {

   if (Auth::user()->id == 134 || Auth::user()->id == 141 || Auth::user()->id==221) {
?>
      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
         <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">
               Lead Management </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
         <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
               <?php
               if (Auth::user()->id == 134 || Auth::user()->id == 141 || Auth::user()->id==221) {
               ?>
                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getclaimleadGraph')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Claim Lead graph</span>
                     </a>
                  </li>

                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getDatewiseLeadAssign')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Lead Assigned List</span>
                     </a>
                  </li>


               <?php

               }
               if (Auth::user()->hasPermissionTo('LeadManagement_FreshLead')) {
               ?>
                  <!-- <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getINDMartData')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads</span>
                     </a>
                  </li> -->


                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getINDMartDataLeadManagerView')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads List</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getLeadReports')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads Reports</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getLeadReports_Dist')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads Distribution </span>
                     </a>
                  </li>

                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('rnd.finishProduct')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Finish Product Price</span>
                     </a>
                  </li>
                  <li class="m-menu__item " aria-haspopup="true"><a href="{{route('ingredientsPrice')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Ingredients Price</span>
                     </a>
                  </li>

                  <!-- <li class="m-menu__item " aria-haspopup="true">
                     <a href="{{ route('getLeadStagesGrapgh')}}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Leads Stages Grapgh </span>
                     </a>
                  </li> -->


               <?php
               }

               ?>





            </ul>
         </div>
      </li>
<?php

   }
}
?>


<li>
<li class="m-menu__item  m-menu__item" aria-haspopup="true"><a href="{{route('loginActivity')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> User Activity
            <span class="m-menu__link-badge"></span> </span></span></a>
</li>
<li class="m-menu__item  m-menu__item" aria-haspopup="false">
   <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="m-menu__link "><i class="m-menu__link-icon flaticon-user" style="color:#FFF"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> Log Out
            <span class="m-menu__link-badge"></span> </span></span></a>



</li>


<?php
if (Auth::user()->id == 199) {
?>
   <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-paper-plane"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Bulk Orders</span> <span class="m-menu__link-badge"><span class="m-badge m-badge--brand m-badge--wide"></span></span>
            </span></span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
      <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
         <ul class="m-menu__subnav">
            <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcform_getList_BulkList')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                  <span class="m-menu__link-text">Orders List</span>
               </a>
            </li>
            <!-- <li class="m-menu__item " aria-haspopup="true"><a href="{{route('qcFormListViewDispatched')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                     <span class="m-menu__link-text">Orders Dispatched</span>
                  </a>
               </li> -->


         </ul>
      </div>
   </li>

<?php

}


?>







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