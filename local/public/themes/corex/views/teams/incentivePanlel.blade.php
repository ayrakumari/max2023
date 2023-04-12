<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <!--Begin::Section-->
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Incentive Panel::
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_inc_1" role="tab"><i class="la la-cloud-upload"></i> Teams</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_inc_2" role="tab"><i class="la la-puzzle-piece"></i> Eligibility Settings</a>
                    </li>

                    <li class="nav-item dropdown m-tabs__item">
                        <a class="nav-link m-tabs__link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="la la-cog"></i> Settings</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-toggle="tab" href="#m_tabs_inc_3">Incentive Type</a>
                            <a class="dropdown-item" data-toggle="tab" href="#m_tabs_inc_4">Incentive Payout</a>
                            <a class="dropdown-item" data-toggle="tab" href="#m_tabs_inc_5">Incentive Apply</a>

                        </div>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_tabs_inc_1" role="tabpanel">
                        <!-- teams  -->
                        <style>
                            .m-accordion .m-accordion__item .m-accordion__item-head .m-accordion__item-title {
                                display: table-cell;
                                vertical-align: middle;
                                width: 100%;
                                font-size: 1.2rem;
                                margin-left: 27px;
                                padding: 5px;
                            }
                        </style>
                        <!--begin::Portlet-->
                        <!--begin::Section-->
                        <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_3" role="tablist">
                            <?php
                            $lead_data = AyraHelp::getAllWorkingUserIncentive();
                            $i = 0;
                            $quertyData = AyraHelp::CurrentQuerterData();
                            // $quarter_start_date = $quertyData->quarter_start_date;
                            // $quarter_end_date = $quertyData->quarter_end_date;

                            $quarter_start_date = date('Y-m-01');
                            $quarter_end_date = date("Y-m-t");


                            foreach ($lead_data as $key => $row) {

                            ?>
                                <!--begin::Item-->
                                <div class="m-accordion__item">
                                    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_{{$row['uid']}}_head" data-toggle="collapse" href="#m_accordion_3_item_{{$row['uid']}}_body" aria-expanded="    false">
                                        <a href="javascript::void(0)" class="m-nav__link m-dropdown__toggle">
                                            <span class="m-topbar__userpic">
                                                <img src="{{$row['profilePic']}}" width="40px" class="m--img-rounded m--marginless" alt="">
                                            </span>
                                            <span class="m-topbar__username m--hide" id="myName">{{$row['sales_name']}} </span>
                                        </a>
                                        <span class="m-accordion__item-title">
                                            <strong style="margin-top: 10px;"> {{$row['sales_name']}}</strong>
                                            <a title="View All Tickets" href="javascript::void(0)" class="btn btn-secondary m-btn btn-sm 	m-btn m-btn--icon">
                                                <span>
                                                    <b>Order Value</b>:
                                                    <span class="m-badge m-badge--primary" title="Order Value from {{date('j F Y',strtotime($quarter_start_date))}} To {{date('j F Y',strtotime($quarter_end_date))}}"> {{AyraHelp::getOrderValuesSalesBetween($row['uid'],$quarter_start_date,$quarter_end_date)}}</span>

                                                </span>
                                            </a>
                                            <a title="View All Tickets" href="javascript::void(0)" class="btn btn-secondary m-btn btn-sm 	m-btn m-btn--icon">
                                                <span>
                                                    <b>Payment Received Value</b>:
                                                    <span class="m-badge m-badge--success" title="Payment Received from {{date('j F Y',strtotime($quarter_start_date))}} To {{date('j F Y',strtotime($quarter_end_date))}}"> {{AyraHelp::getPaymentRecievedSalesBetween($row['uid'],$quarter_start_date,$quarter_end_date)}}</span>

                                                </span>
                                            </a>




                                        </span>
                                        <span style="color:black" class="m-accordion__item-mode"></span>

                                    </div>
                                    <div class="m-accordion__item-body collapse" id="m_accordion_3_item_{{$row['uid']}}_body" class=" " role="tabpanel" aria-labelledby="m_accordion_3_item_{{$row['uid']}}_head" data-parent="#m_accordion_3">
                                        <div class="m-accordion__item-content">

                                            <!-- tab panel  -->
                                            <!--begin::Portlet-->
                                            <div class="m-portlet">

                                                <div style="background-color: #f4f6f7;" class="m-portlet__body">
                                                    <ul class="nav nav-tabs nav-fill" role="tablist">
                                                        <!-- <li class="nav-item">
                                                            <a class="nav-link " data-toggle="tab" href="#m_tabs_2_1_C_{{$row['uid']}}">Current Month</a>
                                                        </li> -->
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-toggle="tab" href="#m_tabs_2_2_H_{{$row['uid']}}">Incentive List</a>
                                                        </li>


                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane " id="m_tabs_2_1_C_{{$row['uid']}}" role="tabpanel">
                                                            <!-- Currening  -->
                                                            <!--begin::m-widget5-->
                                                            <div class="m-widget5">
                                                                <div class="m-widget5__item">
                                                                    <div class="m-widget5__content">
                                                                        <table class="table table-bordered m-table m-table--border-success">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Incentive Type </th>
                                                                                    <th>Duration</th>
                                                                                    <th>Amount</th>
                                                                                    <th>Status</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>

                                                                                    <?php
                                                                                    $dataArr = DB::table('incentive_applied')->where('user_id', $row['uid'])->where('active', 1)->get();
                                                                                    foreach ($dataArr as $key => $rowData) {
                                                                                        $dataArrA = DB::table('incentive_type')->where('id', $rowData->incetive_id)->first();

                                                                                        $durationIncentive = "";
                                                                                        switch ($dataArrA->circle_type) {
                                                                                            case 1:
                                                                                                $dataArrDuration = DB::table('incentive_curr_duration')->where('circle_type', $dataArrA->circle_type)->first();
                                                                                                $durationIncentive = $dataArrDuration->name . " [" . date('j F Y', strtotime($dataArrDuration->start_date)) . " TO " . date('j F Y', strtotime($dataArrDuration->end_date)) . "]";
                                                                                                break;
                                                                                            case 2:
                                                                                                $dataArrDuration = DB::table('incentive_curr_duration')->where('circle_type', $dataArrA->circle_type)->first();
                                                                                                $durationIncentive = $dataArrDuration->name . " [" . date('j F Y', strtotime($dataArrDuration->start_date)) . " TO " . date('j F Y', strtotime($dataArrDuration->end_date)) . "]";
                                                                                                break;
                                                                                        }

                                                                                    ?>
                                                                                <tr>
                                                                                    <td>{{$rowData->id}}</td>
                                                                                    <td>{{$dataArrA->incentive_name}}</td>
                                                                                    <td>{{$durationIncentive}}</td>
                                                                                    <td></td>
                                                                                    <td>Pending</td>
                                                                                    <td>

                                                                                        <a target="_blank" title="View Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air" href="{{route('viewIncentiveEligibilityPanel',['uid'=>$row['uid'],'incentiveType'=>$rowData->incetive_id,'in_month'=>date('m'),'in_year'=>date('Y')])}}">
                                                                                            <i class="fa flaticon-eye"></i>
                                                                                        </a>


                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                                    }

                                                                            ?>


                                                                            </tr>

                                                                            </tbody>
                                                                        </table>



                                                                    </div>
                                                                    <div class="m-widget5__content">

                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <!--end::m-widget5-->

                                                            <!-- Currening  -->
                                                        </div>
                                                        <div class="tab-pane active" id="m_tabs_2_2_H_{{$row['uid']}}" role="tabpanel">
                                                            <!-- History -->
                                                            <!--begin::m-widget5-->

                                                            <div class="m-widget5">
                                                                <div class="m-widget5__item">
                                                                    <div class="m-widget5__content">

                                                                        <table class="table table-bordered m-table m-table--border-success" id="m_table_SalesIncentive_{{$row['uid']}}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Record ID</th>
                                                                                    <th>Incentive Type</th>
                                                                                    <th>Duration</th>
                                                                                    <th>Amount</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                    <!-- current month data  -->
                                                                                <?php
                                                                                $dataArr = DB::table('incentive_applied')->where('user_id', $row['uid'])->where('active', 1)->get();
                                                                                foreach ($dataArr as $key => $rowData) {
                                                                                    $dataArrA = DB::table('incentive_type')->where('id', $rowData->incetive_id)->first();

                                                                                    $durationIncentive = "";
                                                                                    switch ($dataArrA->circle_type) {
                                                                                        case 1:
                                                                                            $dataArrDuration = DB::table('incentive_curr_duration')->where('circle_type', $dataArrA->circle_type)->first();
                                                                                            $durationIncentive = $dataArrDuration->name . " [" . date('j F Y', strtotime($dataArrDuration->start_date)) . " TO " . date('j F Y', strtotime($dataArrDuration->end_date)) . "]";
                                                                                            break;
                                                                                        case 2:
                                                                                            $dataArrDuration = DB::table('incentive_curr_duration')->where('circle_type', $dataArrA->circle_type)->first();
                                                                                            $durationIncentive = $dataArrDuration->name . " [" . date('j F Y', strtotime($dataArrDuration->start_date)) . " TO " . date('j F Y', strtotime($dataArrDuration->end_date)) . "]";
                                                                                            break;
                                                                                    }

                                                                                ?>
                                                                                    <tr>
                                                                                        <td>{{$rowData->id}}</td>
                                                                                        <td>{{$dataArrA->incentive_name}}</td>
                                                                                        <td>{{$durationIncentive}}</td>
                                                                                        <td></td>
                                                                                        <td>Pending</td>
                                                                                        <td>

                                                                                            <a target="_blank" title="View Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air" href="{{route('viewIncentiveEligibilityPanel',['uid'=>$row['uid'],'incentiveType'=>$rowData->incetive_id,'in_month'=>date('m'),'in_year'=>date('Y')])}}">
                                                                                                <i class="fa flaticon-eye"></i>
                                                                                            </a>


                                                                                        </td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                               <!-- current month data  -->
                                                                               <!-- all months except current  -->
                                                                               <?php 
                                                                               $dataArr = DB::table('incentive_applied')->where('user_id', $row['uid'])->where('active', 1)->get();

                                                                               foreach ($dataArr as $key => $rowData) {
                                                                                   $dataArrA = DB::table('incentive_type')->where('id', $rowData->incetive_id)->first();



                                                                                   $incType = $rowData->incetive_id;

                                                                                   $durationIncentive = "";
                                                                                   if ($dataArrA->circle_type == 1) {
                                                                                       $dataArrDuration = DB::table('incentive_curr_duration_history')->where('circle_type', $dataArrA->circle_type)->orderBy('id', 'desc')->get();
                                                                                    //    echo "<pre>";
                                                                                    //    print_r($dataArrDuration);
                                                                                    //    die;
                                                                                       foreach ($dataArrDuration as $key => $rowDataA) {
                                                                                           $durationIncentive = $rowDataA->name . " [" . date('j F Y', strtotime($rowDataA->start_date)) . " TO " . date('j F Y', strtotime($rowDataA->end_date)) . "]";


                                                                               ?>
                                                                           <tr>
                                                                               <td>{{$rowDataA->id}}</td>
                                                                               <td>{{$dataArrA->incentive_name}}</td>
                                                                               <td>{{$durationIncentive}}</td>
                                                                               <td></td>
                                                                               <td>Pending</td>
                                                                               <td>

                                                                                   <a target="_blank" title="View Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air" href="{{route('viewIncentiveEligibilityPanel_History',['uid'=>$row['uid'],$rowDataA->in_month,$incType,$rowDataA->in_year])}}">
                                                                                       <i class="fa flaticon-eye"></i>
                                                                                   </a>


                                                                               </td>
                                                                           </tr>
                                                               <?php

                                                                                       }
                                                                                   }
                                                                               }

                                                                               

                                                                               ?>
                                                                               <!-- all months except current  -->


                                                                            </tbody>
                                                                        </table>


                                                                      
                                                                      

                                                                    </div>
                                                                    <div class="m-widget5__content">

                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <!-- History -->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!--end::Portlet-->
                                            <!-- tab panel  -->



                                        </div>
                                    </div>
                                </div>


                                <!--end::Item-->

                            <?php
                            }
                            ?>





                        </div>

                        <!--end::Section-->


                        <!--end::Portlet-->

                        <!-- teams  -->
                    </div>
                    <div class="tab-pane" id="m_tabs_inc_2" role="tabpanel">

                        <!-- General Eligibility -->
                        <!--begin::Section-->
                        <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="    false">
                                    <span class="m-accordion__item-icon"><i class="fa flaticon-user-ok"></i></span>
                                    <span class="m-accordion__item-title">
                                        <?php
                                        $dataArr = DB::table('incentive_type')->where('id', 1)->first();
                                        $dataArrINC = DB::table('incentive_eligibilty')->where('incentive_type', 1)->where('incentive_circle', 1)->first();

                                        ?>
                                        {{$dataArr->incentive_name}}

                                    </span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_1_item_1_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                                    <div class="m-accordion__item-content">
                                        <!-- <b>{{$dataArr->incentive_name}} Incentive Formula</b> -->
                                        <br><b>Variable:</b><br>
                                        <ul>
                                            <li>no of new client orders=x</li>
                                            <li>Total Collection =y</li>
                                            <li>Salary =z</li>
                                            <li>Min Order =a</li>
                                            <li>Applied payout slab %=p</li>
                                        </ul>
                                        <hr>
                                        <br>
                                        <b>Eligibility</b>:<br>
                                        <ul>
                                            <li>if x >= {{$dataArrINC->no_client_have_order}}</li>
                                            <li>if a >= {{$dataArrINC->min_order_values}}</li>
                                            <li>if Sum of total collecton Y >= z*{{$dataArrINC->salary_times_target}}</li>
                                        </ul>
                                        <b>Calcutations:</b>:<br>
                                        Incentive Amount: y*p
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="    false">
                                    <span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>
                                    <span class="m-accordion__item-title">demo</span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">
                                    <div class="m-accordion__item-content">
                                        <p>

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_3_head" data-toggle="collapse" href="#m_accordion_1_item_3_body" aria-expanded="    false">
                                    <span class="m-accordion__item-icon"><i class="fa  flaticon-alert-2"></i></span>
                                    <span class="m-accordion__item-title">demo1</span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_accordion_1_item_3_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_3_head" data-parent="#m_accordion_1">
                                    <div class="m-accordion__item-content">
                                        <p>

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--end::Item-->
                        </div>

                        <!--end::Section-->
                        <!-- General Eligibility -->


                    </div>
                    <div class="tab-pane" id="m_tabs_inc_3" role="tabpanel">

                        <!-- incentive Type -->
                        <!--begin::Form-->
                        <h3>Incentive Type</h3>
                        <form class="m-form m-form--fit m-form--label-align-right" id="m_form_incentive_Type">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="m-form__content">
                                    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            Oh snap! Change a few things up and try submitting again.
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" data-close="alert" aria-label="Close">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Incentive Name *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type="text" class="form-control m-input" name="inc_name" placeholder="" data-toggle="m-tooltip" title="Tooltip description">
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Circle Period</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="m-input-icon m-input-icon--left">
                                            <select name="inc_circle_period" id="" class="form-control">
                                                <option value="1">Monthly</option>
                                                <option value="2">Quaterly</option>
                                                <option value="3">Half Yearly</option>
                                                <option value="4">Yearly</option>
                                            </select>

                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Is Active</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="m-input-icon m-input-icon--left">
                                            <select name="inc_is_active" id="" class="form-control">
                                                <option value="1">YES</option>
                                                <option value="2">NO</option>

                                            </select>

                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>









                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Incentive Name</th>
                                    <th>Circle Period</th>
                                    <th>Is Active</th>
                                    <th>Created By</th>
                                    <th>Created on</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataArr = DB::table('incentive_type')->get();
                                foreach ($dataArr as $key => $rowData) {
                                    switch ($rowData->circle_type) {
                                        case 1:
                                            $circle_type = "Monthly";
                                            break;
                                        case 2:
                                            $circle_type = "Quaterly";
                                            break;
                                        case 3:
                                            $circle_type = "Half yearly";
                                            break;
                                        case 4:
                                            $circle_type = "Half yearly";
                                            break;
                                    }
                                ?>
                                    <tr>
                                        <td>{{$rowData->id}}</td>
                                        <td>{{$rowData->incentive_name}}</td>
                                        <td>{{$circle_type}}</td>
                                        <td>{{$rowData->is_active==1 ? "Y":"N"}}</td>
                                        <td>{{AyraHelp::getUser($rowData->created_by)->name}}</td>
                                        <td>{{date('j F Y',strtotime($rowData->created_on))}}</td>

                                        <td nowrap></td>
                                    </tr>
                                <?php
                                }

                                ?>



                            </tbody>
                        </table>


                        <hr>


                        <!--end::Form-->
                        <!-- incetive type  -->
                    </div>
                    <div class="tab-pane" id="m_tabs_inc_4" role="tabpanel">
                        Incentive Slab
                        <form class="m-form m-form--fit m-form--label-align-right" id="m_form_incentive_Slab">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="m-form__content">
                                    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            Oh snap! Change a few things up and try submitting again.
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" data-close="alert" aria-label="Close">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Incentive Type *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">

                                        <select name="inc_slab_inc_type" id="" class="form-control">
                                            <?php
                                            $dataArr = DB::table('incentive_type')->get();
                                            foreach ($dataArr as $key => $rowData) {
                                            ?>
                                                <option value="{{$rowData->id}}">{{$rowData->incentive_name}}</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Range From *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-input" name="inc_slab_rangeFrom" placeholder="" data-toggle="m-tooltip" title="">


                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Range To *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-input" name="inc_slab_rangeTO" placeholder="" data-toggle="m-tooltip" title="">

                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12"> Percentage Slab *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control m-input" name="inc_slab_Percentage" placeholder="" data-toggle="m-tooltip" title="">


                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Notes</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="m-input-icon m-input-icon--left">
                                            <textarea class="form-control" name="inc_slab_notes" id="" cols="30" rows="4"></textarea>
                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>


                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="submit" class="btn btn-warning">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <hr>
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Incentive Name</th>
                                    <th>Incentive From</th>
                                    <th>Incentive To</th>
                                    <th>Incentive Percentage</th>
                                    <th>Updated By</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataArr = DB::table('incentive_payout_percentage')->get();
                                foreach ($dataArr as $key => $rowData) {


                                ?>
                                    <tr>
                                        <td>{{$rowData->id}}</td>
                                        <td>{{$rowData->incentive_type_id}}</td>
                                        <td>{{$rowData->target_start}}</td>
                                        <td>{{$rowData->target_stop}}</td>
                                        <td>{{$rowData->payout_percentage}}</td>
                                        <td>{{$rowData->last_updated_by}}</td>
                                        <td>{{$rowData->notes}}</td>
                                        <td nowrap></td>
                                    </tr>
                                <?php
                                }

                                ?>



                            </tbody>
                        </table>


                        <hr>


                    </div>
                    <div class="tab-pane" id="m_tabs_inc_5" role="tabpanel">
                        <!-- apply incetive to user  -->
                        <!--begin::Form-->
                        <form method="post" action="{{route('incentiveApplied')}}" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_INCENTIVEAPPLY">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">Apply Incentive to Users</h3>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <label class="form-control-label">*User's Name:</label>

                                            <select class="form-control m-input" name="usrid" id="">
                                                <?php
                                                $lead_data = AyraHelp::getAllWorkingUserIncentive();
                                                // print_r($lead_data);

                                                foreach ($lead_data as $key => $rowData) {
                                                ?>
                                                    <option value="{{$rowData['uid']}}">{{$rowData['sales_name']}}</option>

                                                <?php
                                                }
                                                ?>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <label class="form-control-label">* Incentive Type:</label>
                                            <select class="form-control m-input" name="incentiveType" id="">
                                                <?php
                                                $dataArr = DB::table('incentive_type')->get();
                                                foreach ($dataArr as $key => $rowData) {
                                                ?>
                                                    <option value="{{$rowData->id}}">{{$rowData->incentive_name}}</option>
                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" data-wizard-action="submitIncentiveApply" class="btn btn-accent">Submit</button>

                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_IncentiveApply">
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>User Name</th>
                                    <th>Incentive Type</th>
                                    <th>Staus</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataArr = DB::table('incentive_applied')->get();
                                foreach ($dataArr as $key => $rowData) {
                                    $dataArrA = DB::table('incentive_type')->where('id', $rowData->incetive_id)->first();
                                ?>
                                    <tr>
                                        <td>{{$rowData->id}}</td>
                                        <td>{{AyraHelp::getUser($rowData->user_id)->name}}</td>
                                        <td>{{$dataArrA->incentive_name}}</td>
                                        <td>{{$rowData->active==1 ? "Active":"Deactive"}}</td>
                                        <td nowrap></td>
                                    </tr>
                                <?php
                                }

                                ?>



                            </tbody>
                        </table>
                        <hr>
                        <!-- apply incetive to user  -->
                    </div>

                </div>

            </div>
        </div>

        <!--end::Portlet-->

        <!--End::Section-->
    </div>
    <!-- datalist -->
</div>
<!-- main  -->