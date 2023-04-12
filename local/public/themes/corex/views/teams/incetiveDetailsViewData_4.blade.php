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
                            IGM:Incentive Details : Growth Manger : <span style="color:#035496">{{AyraHelp::getUser( Request::segment(2))->name}}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <?php
                $uid = Request::segment(2);
                $userData = AyraHelp::getUser($uid);
                $incentiveCircleType = Request::segment(3);
                $in_month = Request::segment(4);
                $in_year = Request::segment(5);

                //new sales ::1
                if ($incentiveCircleType == 4) {


                    $parentID = $uid;
                    $users_catArr = DB::table('categories')
                        ->where('user_id', $parentID)
                        ->first();

                    $rootAllMember = \App\Category::where('parent_id', $users_catArr->id)->get();
                    $rootAllMember->user_id = $uid;
                    $rootAllMember[] = $rootAllMember;

                    // foreach ($rootAllMember as $key => $rowData) {
                    //    print_r($rowData->user_id);
                    //    echo "<br>";
                    // }


                ?>
                    <!-- incentive detail  -->

                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_INCDetails">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $dataArrDurationData = DB::table('incentive_curr_duration')->where('incentive_type', $incentiveCircleType)->first();

                            // print_r($dataArrDurationData);
                            // die;

                            $start_date = $dataArrDurationData->start_date;
                            $end_date = $dataArrDurationData->end_date;

                            $me = array();

                            $oderVaL = 0;
                            $i = 0;
                            $sum = 0;

                            foreach ($rootAllMember as $key => $rowData) {
                                // print_r($rowData->user_id);

                                $dataArr = DB::table('payment_recieved_from_client')->where('payment_status', 1)->where('created_by', $rowData->user_id)->whereBetween('recieved_on', [$start_date, $end_date])->where('is_deleted', 0)->get();
                                $sumOFRejectedAmt = DB::table('payment_recieved_from_client')->where('is_rejected', 1)->where('payment_status', 1)->where('created_by', $rowData->user_id)->whereBetween('recieved_on', [$start_date, $end_date])->where('is_deleted', 0)->sum('rec_amount');
                                $sum += $sumOFRejectedAmt;


                                foreach ($dataArr as $key => $rowData) {
                                    $i++;
                                    $client_arr = AyraHelp::getClientbyid($rowData->client_id);
                                    $company = isset($client_arr->company) ? $client_arr->company : '';
                                    $brand = isset($client_arr->brand) ? $client_arr->brand : '';
                                    $phone = isset($client_arr->phone) ? $client_arr->phone : '';
                                    $name = isset($client_arr->firstname) ? $client_arr->firstname : '';




                                    // if (isset($rowData->qc_from_bulk)) {
                                    // 	if ($rowData->qc_from_bulk == 1) {
                                    // 		$me[] = $rowData->bulk_order_value;
                                    // 		$oderVaL = $rowData->bulk_order_value;
                                    // 	} else {
                                    // 		$me[] = ($rowData->item_sp) * ($rowData->item_qty);
                                    // 		$oderVaL = ($rowData->item_sp) * ($rowData->item_qty);
                                    // 	}
                                    // } else {
                                    // 	$me[] = ($rowData->item_sp) * ($rowData->item_qty);
                                    // 	$oderVaL =  ($rowData->item_sp) * ($rowData->item_qty);
                                    // }



                                    // $amount =  array_sum($me);
                                    $amount =  $rowData->rec_amount;
                                    $oderVaL = $oderVaL + $amount;

                                    //ajaxdata
                                    DB::table('incentive_userwise_data')
                                        ->updateOrInsert(
                                            [
                                                'user_id' => $rowData->created_by,
                                                'in_month' => $in_month,
                                                'in_year' => $in_year,
                                                'payid' => $rowData->id
                                            ],
                                            [
                                                'user_name' => AyraHelp::getUser($rowData->created_by)->name,
                                                'company' => $company,
                                                'brand' => $brand,
                                                'pay_date' => date('j F Y H:i A', strtotime($rowData->created_at)),
                                                'amount' => $oderVaL,
                                                'is_rejected' => $rowData->is_rejected,
                                                'team_person' => AyraHelp::getUser($uid)->name,
                                            ]
                                        );
                                    //ajaxdata


                            ?>
                                    <tr>
                                        <td>{{$i}}</td>

                                        <td>{{$company}} [{{$name}} ]</td>
                                        <td>{{date('j F Y H:i A',strtotime($rowData->created_at))}}</td>
                                        <td>
                                            <a href="javascript::void(0)" onclick="viewPayRecView({{$rowData->id}})" title="View Payment Details" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                <i class="fa flaticon-eye"></i>
                                            </a>

                                            <?php
                                            if ($rowData->is_rejected == 1) {
                                            ?>
                                                <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Removed</span>
                                                <?php
                                            } else {
                                                if (Auth::user()->id == 1 || Auth::user()->id == 156) {
                                                ?>
                                                    <a title="Remove incentive with reason" href="javascript::void(0)" onclick="viewPayRecViewRemoveIncentive({{$rowData->id}})" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                        <i class="fa flaticon-exclamation-square"></i>
                                                    </a>
                                                    <br>

                                            <?php
                                                }
                                            }

                                            ?>

                                            <?php
                                            echo AyraHelp::getUser($rowData->created_by)->name;
                                            ?>
                                        </td>

                                        <td>{{$amount}}</td>

                                    </tr>



                            <?php
                                }


                                // echo "<br>";
                            }


                            ?>




                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S#</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Sub Total Amount</th>
                                <th>Amount</th>
                            </tr>
                        </tfoot>
                    </table>



                    <!-- incentive detail  -->
                    <hr>
                    <style>
                        .m-widget28 .m-widget28__pic {
                            position: relative;
                            min-height: 18px;
                        }
                    </style>
                    <div class="row">
                    <?php
                                                            $oderVaL = ($oderVaL - $sum);
                                                            ?>

                        <div class="col-xl-6">
                            <?php
                            if (Auth::user()->id == 1 || Auth::user()->id == 156) {
                            ?>
                                <a onclick="viewPayRecViewRemoveIncentiveDeduction(<?php echo $oderVaL ?>,<?php echo $uid ?>,<?php echo intVal($in_month) ?>,<?php echo intVal($in_year) ?>)" href="javascript::void(0)" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                                    <span>
                                       <i class="fa flaticon-line-graph"></i>
                                        <span>Incentive Apply</span>
                                    </span>
                                </a>

                            <?php
                            }
                            ?>
                            <br>
                            <!--begin:: Widgets/Blog-->
                            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height   m-portlet--rounded-force">
                                <div class="m-portlet__head m-portlet__head--fit">

                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget28">
                                        <div class="m-widget28__pic m-portlet-fit--sides"></div>
                                        <div class="m-widget28__container">



                                            <!-- end::Nav pills -->

                                            <!-- begin::Tab Content -->
                                            <div class="m-widget28__tab tab-content">
                                                <div id="menu11" class="m-widget28__tab-container tab-pane active">
                                                    <div class="m-widget28__tab-items">
                                                        <div class="m-widget28__tab-item">



                                                            <span>Total Collection</span>
                                                           
                                                            <span>{{$oderVaL}}</span>
                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <?php
                                                            $ie = 0;
                                                            $salTimes = $userData->salary * 10;
                                                            if ($oderVaL >= $salTimes) {
                                                                $strChkColor = "green";
                                                                $ie++;
                                                            } else {
                                                                $strChkColor = "red";
                                                            }

                                                            ?>

                                                            <span> {{$userData->name}} 's salary <i title="Total collection is not as per salary aspect" style="color:{{$strChkColor}}" class="fa fa-check-square"></i>

                                                            </span>
                                                            <span>
                                                                {{$userData->salary*10}}
                                                                <span class="m-nav__item m-nav__item">
                                                                    <a href="javascript::void(0)" class="m-nav__link" data-toggle="m-tooltip" title="" data-placement="right" data-original-title="Basic Salary: {{$userData->salary}}">
                                                                        <i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
                                                                    </a>



                                                                </span>

                                                            </span>
                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <?php
                                                            // $cCountData = AyraHelp::getNewClient($uid, $in_month, $in_year);
                                                            // $cCountDataMinOrder = AyraHelp::getMinOrderValue($uid, $in_month, $in_year);
                                                            // $cCountDataMinProductAddition = AyraHelp::getMinProductAdditon($uid, $in_month, $in_year);
                                                            //$repearOrderPercentage = AyraHelp::getRepeatOrderPercentage($uid, $in_month, $in_year);



                                                            $c_count = 0;
                                                            $cPayRec_count = 0;
                                                            $cRepeatOrderPercentageALL = 0;
                                                            $cRepeatOrderPercentage = 0;

                                                            $cPAdditionOrderPercentageALL = 0;
                                                            $cPAdditionOrderPercentage = 0;


                                                            foreach ($rootAllMember as $key => $rowDataAx) {


                                                                $data = AyraHelp::getClientCountwithAllPaymentRecieved($rowDataAx->user_id, $in_month, $in_year);

                                                                //print_r($data['t_client']);
                                                                $c_count = $c_count + $data['t_client'];
                                                                $cPayRec_count = $cPayRec_count + $data['tpay'];
                                                                //echo "<br>";
                                                                //print_r($data['tpay']);

                                                                $cRepeatOrderPercentageALL = $cRepeatOrderPercentageALL + AyraHelp::getRepeatOrderPercentageALL($rowDataAx->user_id, $in_month, $in_year);
                                                                $cRepeatOrderPercentage = $cRepeatOrderPercentage + AyraHelp::getRepeatOrderPercentage($rowDataAx->user_id, $in_month, $in_year);

                                                                $cPAdditionOrderPercentageALL = $cPAdditionOrderPercentageALL + AyraHelp::getPAdditonPercentageALL($rowDataAx->user_id, $in_month, $in_year);
                                                                $cPAdditionOrderPercentage = $cPAdditionOrderPercentage + AyraHelp::getPAdditonPercentage($rowDataAx->user_id, $in_month, $in_year);
                                                            }
                                                            // print_r($cPAdditionOrderPercentageALL);
                                                            // print_r($cPAdditionOrderPercentage);
                                                            if ($cRepeatOrderPercentageALL == 0) {
                                                                $cRepeatOrderPercentageALL = 1;
                                                            }
                                                            if ($cPAdditionOrderPercentageALL == 0) {
                                                                $cPAdditionOrderPercentageALL = 1;
                                                            }

                                                            $percentROrder = intVal((($cRepeatOrderPercentage) * 100) / ($cRepeatOrderPercentageALL));

                                                            $percentPAdditonOrder = intVal((($cPAdditionOrderPercentage) * 100) / ($cPAdditionOrderPercentageALL));
                                                            if ($cPayRec_count == 0) {
                                                                $cPayRec_count = 1;
                                                            }
                                                            $percC = intVal(($c_count / $cPayRec_count));

                                                            $percCRecCollection = intVal(($oderVaL * 0.5));

                                                            $targetAmt = 10000000;
                                                            $percCRecCollection = intVal(($targetAmt * 0.5));




                                                            // if ($cCountData >= 3) {
                                                            //     $stC = "green";
                                                            //     $ie++;
                                                            // } else {
                                                            //     $stC = "red";
                                                            // }

                                                            // if ($cCountDataMinOrder >= 3) {
                                                            //     $stCM = "green";
                                                            //     $ie++;
                                                            // } else {
                                                            //     $stCM = "red";
                                                            // }

                                                            if ($oderVaL >= $percCRecCollection) {
                                                                $stCMAPC = "green";
                                                                $ie++;
                                                            } else {
                                                                $stCMAPC = "red";
                                                            }


                                                            if ($percentROrder >= 50) {
                                                                $stCMAOP = "green";
                                                                $ie++;
                                                            } else {
                                                                $stCMAOP = "red";
                                                            }


                                                            if ($percentPAdditonOrder >= 15) {
                                                                $stCMAOPAdd = "green";
                                                                $ie++;
                                                            } else {
                                                                $stCMAOPAdd = "red";
                                                            }

                                                            ?>
                                                            <span title="Payment Recieved of Team">Min 50% Collection({{$percCRecCollection}}) : {{$oderVaL}} <i style="color:{{$stCMAPC}}" class="fa fa-check-square"></i></span>

                                                            <!-- <span>NA</span> -->
                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <span title="Percentage (%) of repeat orders">20% Percentage (%) of repeat orders : <b>{{$percentROrder}} %</b> <i style="color:{{$stCMAOP}}" class="fa fa-check-square"></i> </span>

                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <span>15% Percentage (%) of product addition <b>{{$percentPAdditonOrder}} % </b> <i style="color:{{$stCMAOPAdd}}" class="fa fa-check-square"></i> </span>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- end::Tab Content -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end:: Widgets/Blog-->
                        </div>

                        <!-- next 6  -->
                        <div class="col-xl-6">

                            <!--begin:: Widgets/Blog-->
                            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height   m-portlet--rounded-force">
                                <div class="m-portlet__head m-portlet__head--fit">


                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget28">
                                        <div class="m-widget28__pic m-portlet-fit--sides"></div>
                                        <div class="m-widget28__container">



                                            <!-- end::Nav pills -->

                                            <!-- begin::Tab Content -->
                                            <div class="m-widget28__tab tab-content">
                                                <div id="menu11" class="m-widget28__tab-container tab-pane active">
                                                    <div class="m-widget28__tab-items">
                                                        <div class="m-widget28__tab-item">
                                                            <span>Payout % Applied</span>
                                                            <?php
                                                            $ORI_oderVaL = $oderVaL;

                                                            echo $oderVaL = ($oderVaL * 83.5) / 100;


                                                            $data_ArrInc = AyraHelp::getPayoutDetailByAmount($ORI_oderVaL, $incentiveCircleType);


                                                            if ($data_ArrInc != null) {

                                                            ?>
                                                                <span>{{$data_ArrInc->payout_percentage}} % [{{$data_ArrInc->notes}}]</span>

                                                            <?php
                                                            }

                                                            ?>

                                                        </div>
                                                        <?php
                                                        if ($data_ArrInc != null) {
                                                        ?>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Incentive Amount</span>

                                                                {{( intVal($oderVaL*$data_ArrInc->payout_percentage)/100)}}

                                                            </div>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Incentive Amount</span>
                                                                <span>NA</span>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>
                                                        <br>
                                                        <?php
                                                        $ie;
                                                        if ($ie >= 4) {
                                                        ?>
                                                            <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Eligible for Incentive</span>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Not Eligible Yet</span>
                                                        <?php
                                                        }
                                                        ?>




                                                    </div>

                                                </div>


                                            </div>


                                            <!-- end::Tab Content -->


                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!--end:: Widgets/Blog-->


                        </div>


                        <!-- next 6  -->
                    </div>

                    <!--begin::Form-->
                    <?php
                    $incetiveCode = $uid . $incentiveCircleType . date('dmY', strtotime($start_date));
                    $incentiveAppr = DB::table('incentive_approval')->where('incentive_code', $incetiveCode)->whereNotNull('approved_1')->first();
                    $user = auth()->user();
                    $userRoles = $user->getRoleNames();
                    $user_role = $userRoles[0];
                    if ($user_role == "Admin") {
                        if ($incentiveAppr == null) {
                            $strVa = "display:block";
                            $str = "pending Approval";
                        } else {
                            $strVa = "display:block";
                            $str = "Sales Approved";
                        }
                    } else {
                        if ($incentiveAppr == null) {
                            $strVa = "display:block";
                            $str = "NA";
                        } else {
                            $strVa = "display:none";
                            $str = "Approved";
                        }
                    }



                    ?>


                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_7">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="fa fa-calculator"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text m--font-primary">
                                        Payout Percentage Slab
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">

                                    <li class="m-portlet__nav-item">
                                        <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                                    </li>
                                    <li class="m-portlet__nav-item">
                                        <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px">
                                <!-- Hi welcome  -->
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
                                        $i = 0;
                                        $dataArr = DB::table('incentive_payout_percentage')->where('incentive_type_id', 4)->get();
                                        foreach ($dataArr as $key => $rowData) {
                                            $i++;
                                            $dataArrData = DB::table('incentive_type')->where('id', $rowData->incentive_type_id)->first();



                                        ?>
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$dataArrData->incentive_name}}</td>
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
                                <!-- Hi welcome  -->
                            </div>
                        </div>
                    </div>

                    <!--end::Portlet-->

                    <a href="javascript::void(0)" class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
                        <span>
                            <i class="fa flaticon-time-3"></i>
                            <span>{{$str}}</span>
                        </span>
                    </a>
                    <hr>

                    <form action="" style="background:#CCC; {{$strVa}}" method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_IncetiveApproval">
                        @csrf
                        <?php

                        if ($data_ArrInc == null) {
                            $payPercentage = 0;
                            $Incamt = 0;
                        } else {
                            $payPercentage = $data_ArrInc->payout_percentage;
                            $Incamt = ($oderVaL * $data_ArrInc->payout_percentage) / 100;
                        }
                        // if (is_null($data_ArrInc->payout_percentage)) {
                        // 	$payPercentage = 0;
                        // } else {
                        // 	$payPercentage = $data_ArrInc->payout_percentage;
                        // 	$Incamt = ($oderVaL * $data_ArrInc->payout_percentage) / 100;
                        // }

                        ?>
                        <input type="hidden" name="incentiveCircleType" value="{{$incentiveCircleType}}">
                        <input type="hidden" name="incentivePayoutPercentage" value="{{$payPercentage}}">
                        <input type="hidden" name="incentiveTotalAmount" value="{{$oderVaL}}">
                        <input type="hidden" name="incentiveAmount" value="{{$Incamt}}">
                        <input type="hidden" name="incentiveUser" value="{{$uid}}">

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">Incentive Approval </h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* Remarks:</label>
                                        <textarea name="approved_msg" id="" cols="30" rows="3" class="form-control m-input"></textarea>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* Status:</label>
                                        <select class="form-control m-input" name="approved_status">
                                            <option value="">Select</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-accent">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h3>Approval Remarks</h3>
                    <hr>


                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Approved By</th>
                                <th>Approved On</th>
                                <th>Approved Note</th>
                                <th>Approved Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $incetiveCode = $uid . $incentiveCircleType . date('dmY', strtotime($start_date));
                            $incentiveAppr = DB::table('incentive_approval')->where('incentive_code', $incetiveCode)->first();
                            if ($incentiveAppr != null) {
                                if ($incentiveAppr->approved_2 == '90') {
                            ?>
                                    <tr>
                                        <td>1</td>
                                        <th scope="row">{{$incentiveAppr->approved_by_sales_head}}</th>
                                        <td>{{date('j F Y ',strtotime($incentiveAppr->submitted_on))}}</td>
                                        <td>{{$incentiveAppr->remarks}}</td>
                                        <td>{{$incentiveAppr->status==1 ? "Approved":"Rejected"}}</td>
                                    </tr>
                                <?php
                                }

                                if ($incentiveAppr->approved_1 == '1') {
                                ?>
                                    <tr>
                                        <td>1</td>
                                        <th scope="row">{{$incentiveAppr->admin_approved}}</th>
                                        <td>{{date('j F Y ',strtotime($incentiveAppr->admin_approved_on))}}</td>
                                        <td>{{$incentiveAppr->admin_remarks}}</td>
                                        <td>{{$incentiveAppr->admin_approved_status==1 ? "Approved":"Rejected"}}</td>
                                    </tr>
                            <?php
                                }
                            }


                            ?>


                        </tbody>
                    </table>


                    <!--end::Form-->

                <?php
                }
                //new sales  ::1 
                //growth team::2
                if ($incentiveCircleType == 3) {
                ?>
                    <!-- incentive detail  -->

                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_INCDetails">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Client</th>
                                <th>Date</th>

                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php






                            $dataArrDurationData = DB::table('incentive_curr_duration')->where('circle_type', $incentiveCircleType)->first();
                            $start_date = $dataArrDurationData->start_date;
                            $end_date = $dataArrDurationData->end_date;



                            $me = array();

                            $oderVaL = 0;
                            $i = 0;
                            $dataArr = DB::table('payment_recieved_from_client')->where('payment_status', 1)->where('created_by', $uid)->whereBetween('recieved_on', [$start_date, $end_date])->where('is_deleted', 0)->get();
                            foreach ($dataArr as $key => $rowData) {
                                $i++;
                                $client_arr = AyraHelp::getClientbyid($rowData->client_id);
                                $company = isset($client_arr->company) ? $client_arr->company : '';
                                $phone = isset($client_arr->phone) ? $client_arr->phone : '';
                                $name = isset($client_arr->firstname) ? $client_arr->firstname : '';




                                // if (isset($rowData->qc_from_bulk)) {
                                // 	if ($rowData->qc_from_bulk == 1) {
                                // 		$me[] = $rowData->bulk_order_value;
                                // 		$oderVaL = $rowData->bulk_order_value;
                                // 	} else {
                                // 		$me[] = ($rowData->item_sp) * ($rowData->item_qty);
                                // 		$oderVaL = ($rowData->item_sp) * ($rowData->item_qty);
                                // 	}
                                // } else {
                                // 	$me[] = ($rowData->item_sp) * ($rowData->item_qty);
                                // 	$oderVaL =  ($rowData->item_sp) * ($rowData->item_qty);
                                // }



                                // $amount =  array_sum($me);
                                $amount =  $rowData->rec_amount;
                                $oderVaL = $oderVaL + $amount;

                            ?>
                                <tr>
                                    <td>{{$i}}</td>

                                    <td>{{$company}} [{{$name}} ]</td>
                                    <td>{{date('j F Y H:i A',strtotime($rowData->created_at))}}</td>
                                    <td>{{$amount}}</td>
                                </tr>



                            <?php
                            }
                            ?>




                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S#</th>
                                <th>Order ID</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </tfoot>
                    </table>



                    <!-- incentive detail  -->
                    <hr>
                    <style>
                        .m-widget28 .m-widget28__pic {
                            position: relative;
                            min-height: 18px;
                        }
                    </style>
                    <div class="row">


                        <div class="col-xl-6">

                            <!--begin:: Widgets/Blog-->
                            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height   m-portlet--rounded-force">
                                <div class="m-portlet__head m-portlet__head--fit">


                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget28">
                                        <div class="m-widget28__pic m-portlet-fit--sides"></div>
                                        <div class="m-widget28__container">



                                            <!-- end::Nav pills -->

                                            <!-- begin::Tab Content -->
                                            <div class="m-widget28__tab tab-content">
                                                <div id="menu11" class="m-widget28__tab-container tab-pane active">
                                                    <div class="m-widget28__tab-items">
                                                        <div class="m-widget28__tab-item">
                                                            <span>Total Collection</span>
                                                            <span>{{$oderVaL}}</span>
                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <span> {{$userData->name}} 's salary
                                                                <i class="fa fa-check-circle" style="color:green"></i>
                                                            </span>
                                                            <span>
                                                                {{$userData->salary*10}}
                                                                <span class="m-nav__item m-nav__item">
                                                                    <a href="javascript::void(0)" class="m-nav__link" data-toggle="m-tooltip" title="" data-placement="right" data-original-title="Basic Salary: {{$userData->salary}}">
                                                                        <i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
                                                                    </a>



                                                                </span>

                                                            </span>
                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <span>No .of New Client
                                                                <i class="fa fa-check-circle" style="color:green"></i>
                                                            </span>
                                                            <span>NA</span>

                                                        </div>
                                                        <div class="m-widget28__tab-item">
                                                            <span>Min Order
                                                                <i class="fa fa-check-circle" style="color:green"></i>
                                                            </span>
                                                            <span>NA</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- end::Tab Content -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end:: Widgets/Blog-->
                        </div>

                        <!-- next 6  -->
                        <div class="col-xl-6">

                            <!--begin:: Widgets/Blog-->
                            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height   m-portlet--rounded-force">
                                <div class="m-portlet__head m-portlet__head--fit">


                                </div>
                                <div class="m-portlet__body">
                                    <div class="m-widget28">
                                        <div class="m-widget28__pic m-portlet-fit--sides"></div>
                                        <div class="m-widget28__container">



                                            <!-- end::Nav pills -->

                                            <!-- begin::Tab Content -->
                                            <div class="m-widget28__tab tab-content">
                                                <div id="menu11" class="m-widget28__tab-container tab-pane active">
                                                    <div class="m-widget28__tab-items">
                                                        <div class="m-widget28__tab-item">

                                                            <span>Payout % Applied</span>
                                                            <?php
                                                            $data_ArrInc = AyraHelp::getPayoutDetailByAmount($oderVaL, $incentiveCircleType);
                                                            if ($data_ArrInc != null) {
                                                            ?>
                                                                <span>{{$data_ArrInc->payout_percentage}} % [{{$data_ArrInc->notes}}]</span>

                                                            <?php
                                                            }

                                                            ?>

                                                        </div>
                                                        <?php
                                                        if ($data_ArrInc != null) {
                                                        ?>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Incentive Amount</span>
                                                                <span>
                                                                    {{($oderVaL*$data_ArrInc->payout_percentage)/100}}
                                                                </span>
                                                            </div>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="m-widget28__tab-item">
                                                                <span>Incentive Amount</span>
                                                                <span>NA</span>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>


                                                        <br>
                                                        <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Not Eligibilie </span>
                                                        <i class="fa fa-hand-point-left" style="color:#035496"></i>





                                                    </div>
                                                </div>

                                            </div>

                                            <!-- end::Tab Content -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end:: Widgets/Blog-->
                        </div>

                        <!-- next 6  -->
                    </div>


                    <!--begin::Form-->
                    <form action="" style="background:#CCC" method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_IncetiveApproval">
                        @csrf
                        <?php

                        if (is_null($data_ArrInc->payout_percentage)) {
                            $payPercentage = 0;
                        } else {
                            $payPercentage = $data_ArrInc->payout_percentage;
                            $Incamt = ($oderVaL * $data_ArrInc->payout_percentage) / 100;
                        }

                        ?>
                        <input type="hidden" name="incentiveCircleType" value="{{$incentiveCircleType}}">
                        <input type="hidden" name="incentivePayoutPercentage" value="{{$payPercentage}}">
                        <input type="hidden" name="incentiveTotalAmount" value="{{$oderVaL}}">
                        <input type="hidden" name="incentiveAmount" value="{{$Incamt}}">
                        <input type="hidden" name="incentiveUser" value="{{$uid}}">

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">Incentive Approval </h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* Remarks:</label>
                                        <textarea name="approved_msg" id="" cols="30" rows="3" class="form-control m-input"></textarea>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label class="form-control-label">* Status:</label>
                                        <select class="form-control m-input" name="approved_status">
                                            <option value="">Select</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-accent">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->

                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Approved By</th>
                                <th>Approved On</th>
                                <th>Approved Note</th>
                                <th>Approved Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $incetiveCode = $uid . $incentiveCircleType . date('dmY', strtotime($start_date));
                            $incentiveAppr = DB::table('incentive_approval')->where('incentive_code', $incetiveCode)->first();
                            if ($incentiveAppr != null) {
                                if ($incentiveAppr->approved_2 == '90') {
                            ?>
                                    <tr>
                                        <td>1</td>
                                        <th scope="row">{{$incentiveAppr->approved_by_sales_head}}</th>
                                        <td>{{date('j F Y ',strtotime($incentiveAppr->submitted_on))}}</td>
                                        <td>{{$incentiveAppr->remarks}}</td>
                                        <td>{{$incentiveAppr->status==1 ? "Approved":"Rejected"}}</td>
                                    </tr>
                                <?php
                                }

                                if ($incentiveAppr->approved_1 == '1') {
                                ?>
                                    <tr>
                                        <td>1</td>
                                        <th scope="row">{{$incentiveAppr->admin_approved}}</th>
                                        <td>{{date('j F Y ',strtotime($incentiveAppr->admin_approved_on))}}</td>
                                        <td>{{$incentiveAppr->admin_remarks}}</td>
                                        <td>{{$incentiveAppr->admin_approved_status==1 ? "Approved":"Rejected"}}</td>
                                    </tr>
                            <?php
                                }
                            }

                            ?>


                        </tbody>
                    </table>



                <?php
                }

                //growth team::2


                ?>


            </div>
        </div>

        <!--end::Portlet-->

        <!--End::Section-->
    </div>
    <!-- datalist -->
</div>
<!-- main  -->


<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-content">
            <div class="modal-body">
                <div id="payDetalRecSHOW">
                </div>
            </div>



        </div>
    </div>
</div>





<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL_removeIncetive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-content">
            <div class="modal-body">
                <!-- removeincetie -->
                <div class="modal-body">
                    <input type="hidden" name="payIDDone" id="payIDDone">


                    <div class="form-group m-form__group">
                        <label>Select Reasons For Payment Removal</label>
                        <div class="input-group">
                            <select class="form-control m-input" name="paymentRemovalOption" id="paymentRemovalOption">
                                <option value="">--Select Options-- </option>
                                <?php
                                $sample_feed_arr = DB::table('payment_remove_type')
                                    ->get();
                                foreach ($sample_feed_arr as $key => $value) {
                                ?>
                                    <option value="{{$value->id}}">{{$value->feedback}}</option>
                                <?php
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">*Remarks:</label>
                        <textarea class="form-control" id="paymentRemovalRemarks" name="paymentRemovalRemarks"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btnsaveRemovePayment" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                <!-- removeincetie -->
            </div>



        </div>
    </div>
</div>


<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL_removeIncetiveDeduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-content">
            <div class="modal-body">
                <!-- removeincetie -->
                <div class="modal-body">
                    <input type="hidden" name="in_user_id" id="in_user_id">
                    <input type="hidden" name="in_user_month" id="in_user_month">
                    <input type="hidden" name="in_user_year" id="in_user_year">
                    <input type="hidden" name="ori_order_amt" id="ori_order_amt">


                    <div class="form-group m-form__group">
                        <label>Select Reasons For Incentive Deduction </label>
                        <div class="input-group">
                            <select class="form-control m-input" name="paymentRemovalOptionDeduct" id="paymentRemovalOptionDeduct">
                                <option value="">--Select Options-- </option>
                                <?php
                                $sample_feed_arr = DB::table('payment_remove_type')
                                    ->get();
                                foreach ($sample_feed_arr as $key => $value) {
                                ?>
                                    <option value="{{$value->id}}">{{$value->feedback}}</option>
                                <?php
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">*Amount to be deduct:</label>
                        
                        <input class="form-control" id="amountTobeDeduct" name="amountTobeDeduct" type="text">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">*Remarks:</label>
                        <textarea class="form-control" id="paymentRemovalRemarksDeduct" name="paymentRemovalRemarksDeduct"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btnsaveRemovePaymentDeduct" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                <!-- removeincetie -->
            </div>



        </div>
    </div>
</div>