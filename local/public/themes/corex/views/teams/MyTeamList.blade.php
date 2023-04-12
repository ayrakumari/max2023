<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">


        <!--begin: Datatable -->
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12">

                <!--begin:: Widgets/Best Sellers-->
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Team Performace
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                                <!-- <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget5_tab1_content" role="tab">
                                        Last Month
                                    </a>
                                </li> -->
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget5_tab2_content" role="tab">
                                        Current Month
                                    </a>
                                </li>
                                <!-- <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget5_tab3_content" role="tab">
                                        All
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="row">
                            <!--begin::m-widget5-->
                            <div class="m-widget5">
                                <?php
                                //child data 
                                $quertyData = AyraHelp::CurrentQuerterData();
                                $quarter_start_date = $quertyData->quarter_start_date;
                                $quarter_end_date = $quertyData->quarter_end_date;

                                $emp_arr = AyraHelp::getProfilePIC(Auth::user()->id);
                                $userArrData = AyraHelp::getUser(Auth::user()->id);
                                if (!isset($emp_arr->photo)) {
                                    $img_photo1 = asset('local/public/img/avatar.jpg');
                                } else {
                                    $img_photo1 = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                                }

                                //child data 
                                ?>
                                <div class="m-widget5__item">
                                    <div class="m-widget5__content">
                                        <div class="m-widget5__pic">
                                            <img class="m-widget7__img" src="{{$img_photo1}}" alt="">
                                        </div>
                                        <div class="m-widget5__section">
                                            <h4 class="m-widget5__title">
                                                <b>{{$userArrData->user_prefix}}</b> - {{$userArrData->name}}
                                            </h4>
                                            <span class="m-widget5__desc">
                                                PH:<b style="color:#035496">{{$userArrData->phone}}</b> , EMAIL: {{$userArrData->email}}
                                            </span>
                                            <div class="m-widget5__info">
                                                <span class="m-widget5__author">
                                                    Sales Value:
                                                </span>
                                                <span class="m-widget5__info-author m--font-info">
                                                    <i class="fas fa-rupee-sign"></i>
                                                    {{AyraHelp::getOrderValuesSalesBetween(Auth::user()->id,$quarter_start_date,$quarter_end_date)}}
                                                </span>
                                                <span class="m-widget5__info-label">
                                                    Received Value:
                                                </span>
                                                <span class="m-widget5__info-date m--font-info">
                                                    <i class="fas fa-rupee-sign"></i>
                                                    {{AyraHelp::getPaymentRecievedSalesBetween(Auth::user()->id,$quarter_start_date,$quarter_end_date)}}

                                                </span>
                                            </div>
                                            <div class="m-widget5__info">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget5__content">
                                        <!-- NA -->
                                        <!-- grapgh  -->

                                        <figure class="highcharts-figure" style="width: 350px;">
                                            <div id="containerGrowthSelf"></div>

                                        </figure>



                                        <!-- grapgh  -->
                                        <!-- NA -->
                                    </div>
                                </div>




                            </div>

                            <!--end::m-widget5-->

                        </div>
                        <b>Member</b>
                        <hr>

                        <!--begin::Content-->
                        <div class="tab-content">
                            <div class="tab-pane " id="m_widget5_tab1_content" aria-expanded="true">

                                <!--begin::m-widget5-->


                                <!--end::m-widget5-->
                            </div>
                            <div class="tab-pane active" id="m_widget5_tab2_content" aria-expanded="false">

                                <!--begin::m-widget5-->
                                <div class="m-widget5">
                                    <?php

                                    use App\Category;

                                    if (Auth::user()->id == 90) {
                                        $node = Category::where('user_id', '=', 1)->first();
                                    } else {
                                        $node = Category::where('user_id', '=', Auth::user()->id)->first();
                                    }


                                    foreach ($node->getImmediateDescendants() as $descendant) {

                                        //child data 
                                        $emp_arr = AyraHelp::getProfilePIC($descendant->user_id);
                                        $userArrData = AyraHelp::getUser($descendant->user_id);
                                        if (!isset($emp_arr->photo)) {
                                            $img_photo1 = asset('local/public/img/avatar.jpg');
                                        } else {
                                            $img_photo1 = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                                        }

                                        //child data 
                                    ?>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__pic">
                                                    <img class="m-widget7__img" src="{{$img_photo1}}" alt="">
                                                </div>
                                                <div class="m-widget5__section">
                                                    <h4 class="m-widget5__title">
                                                        <b>{{$userArrData->user_prefix}}</b> - {{$userArrData->name}}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        PH:<b style="color:#035496">{{$userArrData->phone}}</b> , EMAIL: {{$userArrData->email}}

                                                    </span>
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Sales Value:
                                                        </span>
                                                        <span class="m-widget5__info-author m--font-info">
                                                            <i class="fas fa-rupee-sign"></i>
                                                            {{AyraHelp::getOrderValuesSalesBetween($userArrData->id,$quarter_start_date,$quarter_end_date)}}

                                                        </span>
                                                        <span class="m-widget5__info-label">
                                                            Received Value:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            <i class="fas fa-rupee-sign"></i>
                                                            {{AyraHelp::getPaymentRecievedSalesBetween($userArrData->id,$quarter_start_date,$quarter_end_date)}}

                                                        </span>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                        <a href="javascript::void(0)" onclick="addSampleFORMemberbyManager({{$userArrData->id}})" data-userid="{{$userArrData->id}}" id="btnAddSampleForMemberbyManager_{{$userArrData->id}}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-plus"></i>
                                                                <span>Sample</span>
                                                            </span>
                                                        </a>
                                                        <a href="javascript::void(0)" onclick="addOrderFORMemberbyManager({{$userArrData->id}})" data-userid="{{$userArrData->id}}" id="btnAddOrderForMemberbyManager_{{$userArrData->id}}" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-plus"></i>
                                                                <span>Order</span>
                                                            </span>
                                                        </a>
                                                        <a href="javascript::void(0)" onclick="addPaymentFORMemberbyManager({{$userArrData->id}})" data-userid="{{$userArrData->id}}" id="btnAddPaymentFORMemberbyManager_{{$userArrData->id}}" class="btn btn-accent btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-plus"></i>
                                                                <span>Payment</span>
                                                            </span>
                                                        </a>
                                                        <a href="javascript::void(0)" onclick="addLeadClaimFORMemberbyManager({{$userArrData->id}})" data-userid="{{$userArrData->id}}" id="btnLeadClaimFORMemberbyManager_{{$userArrData->id}}" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-plus"></i>
                                                                <span>Lead</span>
                                                            </span>
                                                        </a>
                                                        <hr>

                                                        <a href="{{route('view_teams_order',$userArrData->id)}}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-eye"></i>
                                                                <span>View Orders</span>
                                                            </span>
                                                        </a>
                                                        <a href="{{route('view_teams_client',$userArrData->id)}}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon m-btn--pill">
                                                            <span>
                                                                <i class="fa flaticon-eye"></i>
                                                                <span>View client</span>
                                                            </span>
                                                        </a>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget5__content">
                                                <figure class="highcharts-figure" style="width: 350px;">
                                                    <div id="containerGrowthSelf_133"></div>

                                                </figure>
                                            </div>
                                        </div>

                                    <?php


                                    }

                                    ?>


                                </div>

                                <!--end::m-widget5-->
                            </div>
                            <div class="tab-pane" id="m_widget5_tab3_content" aria-expanded="false">

                                <!--begin::m-widget5-->


                                <!--end::m-widget5-->
                            </div>
                        </div>

                        <!--end::Content-->
                    </div>
                </div>

                <!--end:: Widgets/Best Sellers-->
            </div>

        </div>

        <!--End::Section-->



        <div style="background-color: #ccc; width:965px; height: 600px" class="chart" id="botreeLayout"></div>
    </div>
    <!-- datalist -->
</div>
<!-- main  -->

<!-- m_modal_5_MoveTeamMember -->
<div class="modal fade" id="m_modal_5_MoveTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Move User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="txtUserID" id="txtUserID">
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Move Label 3 User:</label>

                        <select style="width:260px" class="form-control m-select2 mangerIDataSelect1" id="m_select2_5" name="param_member">
                            <?php
                            $allUsers = AyraHelp::getSalesAgentAdmin();

                            foreach ($allUsers as $key => $rowData) {
                                $users = DB::table('categories')->where('user_id', $rowData->id)->first();
                                if ($users != null) {
                                    if ($rowData->parent_id != 1 && $rowData->id != 1) {
                            ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                            <?php
                                    }
                                }
                            }



                            ?>

                        </select>

                    </div>


                    <div class="form-group">
                        <label for="message-text" class="form-control-label">TO Lebel 2 Users:</label>

                        <select style="width:260px" class="form-control m-select2 mangerIDataSelect2" id="m_select2_7" name="param_member">
                            <?php
                            $allUsers = AyraHelp::getSalesAgentAdmin();

                            foreach ($allUsers as $key => $rowData) {
                                $users = DB::table('categories')->where('user_id', $rowData->id)->first();
                                if ($users != null) {
                                    if ($rowData->parent_id == 1) {
                            ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                            <?php
                                    }
                                }
                            }



                            ?>

                        </select>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSavewithMoveL3inL2" class="btn btn-primary">Move Now</button>
            </div>
        </div>
    </div>
</div>

<!-- m_modal_5_MoveTeamMember -->
<!-- add new team member  -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_addnewTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="txtUserID" id="txtUserID">
                    <div class="form-group">
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__header m--align-center" style="background: url(assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                <div class="m-card-user m-card-user--skin-dark">
                                    <div class="m-card-user__pic ajpicAva">

                                    </div>
                                    <div class="m-card-user__details">
                                        <span class="m-card-user__name ajmName m--font-weight-500" style="color:#035496"></span>
                                        <a href="#" class="m-card-user__email ajphone m--font-weight-300 m-link" style="color:#035496"></a>
                                        <a href="#" class="m-card-user__email  m--font-weight-300 m-link" style="color:#035496">
                                            <span class="m-badge m-badge--primary m-badge--wide">Level 2</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Users:</label>

                        <select style="width:260px" class="form-control m-select2 mangerIDataSelect" id="m_select2_1" name="param_member">
                            <?php
                            $allUsers = AyraHelp::getSalesAgentAdmin();

                            foreach ($allUsers as $key => $rowData) {
                                $users = DB::table('categories')->where('user_id', $rowData->id)->first();
                                if ($users == null) {
                            ?>
                                    <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                            <?php
                                }
                            }



                            ?>

                        </select>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSaveL3inL2" class="btn btn-primary">Submit Now</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->

<!-- add new team member  -->