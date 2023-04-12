<!-- main  -->
<div class="m-content">

    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Edit Sample Details:
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('sample.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>BACK </span>
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <?php
            $data_Arr = json_decode($samples->sample_details);
            // print_r($data_Arr[0]->sample_type);


            ?>
            <!-- form  -->
            <!--begin::Form-->
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_sample" method="post" action="{{ route('sample.update', $samples->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="sample_from" value="{{$samples->sample_from}}">
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">* Sample ID:</label>
                                <input type="text" class="form-control m-input" value="{{$samples->sample_code}}" value="{{$samples->sample_code}}" name="sample_id" placeholder="Enter Company">
                            </div>
                            <?php
                            $user = auth()->user();
                            $userRoles = $user->getRoleNames();
                            $user_role = $userRoles[0];
                            if ($user_role == 'Admin' || $user_role == 'SalesUser') {
                                $view = "";
                            } else {
                                $view = "visibility:hidden";
                            }
                            ?>

                            <div class="col-lg-8 m-form__group-sub" style="<?php echo $view; ?>">

                                <label class="form-control-label">Select Client:</label>
                                <select class="form-control m-select2 client_name" id="m_select2_1" name="client_id">
                                    <?php
                                    if ($samples->sample_from == 1) {
                                    ?>

                                        <option value="{{$usersdata->QUERY_ID}}" selected>{{$usersdata->SENDERNAME}} | {{$usersdata->MOB}} | {{$usersdata->SENDEREMAIL}}</option>
                                        <?php

                                    } else {
                                        foreach (AyraHelp::getClientByadded(Auth::user()->id) as $key => $value) {

                                            if ($samples->client_id == $value->id) {
                                        ?>
                                                <option value="{{$value->id}}" selected>{{$value->firstname}} | {{$value->phone}} | {{$value->email}}</option>

                                            <?php
                                            } else {
                                            ?>
                                                <option value="{{$value->id}}">{{$value->firstname}} | {{$value->phone}} | {{$value->email}}</option>

                                    <?php

                                            }
                                        }
                                    }



                                    ?>

                                </select>
                            </div>
                            <div class="col-lg-4" style="<?php echo $view; ?>">
                            <label>Category:</label>
                            <select class="form-control m-input" id="sampleSelectCat">

                                <?php
                                switch ($data_Arr[0]->sample_type) {
                                    case 1:
                                ?>
                                        <option value="1">COSMETIC</option>
                                    <?php

                                        break;

                                    case 2:
                                    ?>
                                        <option value="2">OILS</option>
                                    <?php
                                        break;
                                    case 3:
                                    ?>
                                        <option value="3">General Changes</option>
                                    <?php
                                        break;
                                    case 4:
                                    ?>
                                        <option value="4">Benchmark</option>
                                    <?php
                                        break;
                                    case 5:
                                    ?>
                                        <option value="5">Modifications</option>
                                <?php

                                        break;
                                    default;
                                        break;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label style="color:#FFF">Brand type:</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <select class="form-control"  id="selectBrandType"  name="sampleBrandType">
                                    <option value="">-SELECT-</option>
                                    <option <?php echo $samples->brand_type==1 ? "selected":"" ?> value="1">New brand</option>
                                    <option <?php echo $samples->brand_type==2 ? "selected":"" ?>  value="2">Small brand</option>
                                    <option <?php echo $samples->brand_type==3 ? "selected":"" ?>  value="3">Medium brand</option>
                                    <option <?php echo $samples->brand_type==4 ? "selected":"" ?> value="4">Big brand</option>
                                    <option <?php echo $samples->brand_type==5 ? "selected":"" ?> value="5">In-House brand</option>
                                </select>

                            </div>
                            <span class="m-form__help"></span>
                        </div>
                        <div class="col-lg-4">
                            <label style="color:#FFF">Order size:</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <select class="form-control"  id="selectOrderSize"  name="sampleOrderSize">
                                    <option value="">-SELECT-</option>
                                    <option <?php echo $samples->order_size==1 ? "selected":"" ?> value="1">500-1000 units</option>
                                    <option <?php echo $samples->order_size==2 ? "selected":"" ?> value="2">1000-2000 units</option>
                                    <option <?php echo $samples->order_size==3 ? "selected":"" ?> value="3">2000-5000 units</option>
                                    <option <?php echo $samples->order_size==4 ? "selected":"" ?> value="4">More than 5000 units</option>

                                </select>

                            </div>
                            <span class="m-form__help"></span>
                        </div>


                        </div>
                       



                    </div>
                    
                    <!-- item edit section -->
                    <div class="m-form__section m-form__section--first">

                        <!-- repeater -->
                        <div class="form-group m-form__group row">

                            <div class="col-lg-4">
                                <label class="">Item Name:</label>
                                <select class="form-control m-select2" id="m_select2_9A" name="param">
                                    <?php

                                    $HTML = "";
                                    switch ($data_Arr[0]->sample_type) {

                                        case 2:

                                            $users = DB::table('rnd_add_ingredient')->get();
                                            foreach ($users as $key => $rowData) {
                                                $HTML .= '<option value=' . '97116' . $rowData->name . '>' . $rowData->name . '</option>';
                                            }
                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 2)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }

                                            echo $HTML;

                                            break;
                                        case 1:
                                            $users = DB::table('rnd_finish_products')->where('is_availabe', 1)->get();
                                            foreach ($users as $key => $rowData) {
                                                $HTML .= '<option value=' . '97116' . $rowData->product_name . '>' . $rowData->product_name . '</option>';
                                            }
                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 1)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }
                                            echo $HTML;
                                            break;
                                        case 3:
                                            $usersD = DB::table('rnd_finish_products')->get();
                                            foreach ($usersD as $key => $rowData) {
                                                $HTML .= '<option value=' . '987116' . $rowData->product_name . '>' . $rowData->product_name . '</option>';
                                            }
                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 1)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }
                                            echo $HTML;
                                            break;
                                        case 4:

                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 1)->where('created_by', Auth::user()->id)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }
                                            echo $HTML;
                                            break;
                                        case 5:
                                            $usersD = DB::table('samples')->where('created_by', Auth::user()->id)->get();
                                            foreach ($usersD as $key => $rowData) {
                                                $HTML .= '<option value=' . '9571165' . $rowData->id . '>' . $rowData->sample_code . '</option>';
                                            }
                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 1)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                //$HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }
                                            echo $HTML;
                                            break;
                                    }

                                    ?>



                                </select>
                                <a href="javascript::void(0)" data-toggle="modal" data-target="#m_modal_SampleAddItem" style="margin-top: 1px;" title="Add New item" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-3x">
                                    <i class="fa flaticon-plus"></i>
                                </a>
                            </div>

                            <div class="col-lg-4">
                                <label>Descriptions:</label>
                                <div class="input-group m-input-group m-input-group--square">

                                    <input type="text" id="txtDisInFO" class="form-control m-input" placeholder="">
                                </div>
                                <span class="m-form__help"></span>
                            </div>
                            <div class="col-lg-2">
                                <label style="color:#000">Target Price/Kg:</label>
                                <div class="input-group m-input-group m-input-group--square">

                                    <input style="text-align: right;" type="text" id="m_inputmask_6" class="form-control m-input" placeholder="">

                                </div>
                                <span class="m-form__help"></span>
                            </div>

                            <div class="col-lg-2">
                                <a href="#" style="margin-top: 29px;" class="add_field_button btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                                    <span>
                                        <i class="fa flaticon-list-2"></i>
                                        <span>Add</span>
                                    </span>
                                </a>

                            </div>
                        </div>



                        <!-- repeater -->
                    </div>

                    <div class="input_fields_wrap">
                        <?php

                        foreach ($data_Arr as $key => $rowData) {
                            // print_r($rowData);
                            if ($rowData->txtDiscrption == 'STANDARD') {
                                $strVal = "readonly";
                            } else {
                                $strVal = "readonly";
                            }
                        ?>



                            <?php
                            // echo "<pre>";
                            // print_r($rowData);

                            ?>


                            <select style="visibility:hidden" name="sampleType[]" class="form-control m-input" id="exampleSelect1">



                                <?php
                                switch ($rowData->sample_type) {
                                    case 1:
                                ?>
                                        <option value="1">COSMETIC</option>
                                    <?php

                                        break;

                                    case 2:
                                    ?>
                                        <option value="2">OILS</option>
                                    <?php
                                        break;
                                    case 3:
                                    ?>
                                        <option value="3">General Changes</option>
                                    <?php
                                        break;
                                    case 4:
                                    ?>
                                        <option value="4">Benchmark</option>
                                    <?php
                                        break;
                                    case 5:
                                    ?>
                                        <option value="5">Modifications</option>
                                <?php

                                        break;
                                    default;
                                        break;
                                }
                                ?>




                            </select>

                            <?php
                            //print_r($rowData);
                            $brandType = optional($rowData)->brand_type;
                            switch ($brandType) {
                                case 1:
                                    $brandTypeName = "New Brand";
                                    break;
                                case 2:
                                    $brandTypeName = "Small Brand";
                                    break;
                                case 3:
                                    $brandTypeName = "Medium Brand";
                                    break;
                                case 4:
                                    $brandTypeName = "Big Brand";
                                    break;

                                default:
                                    $brandTypeName = "";
                                    break;
                            }
                            $order_size = optional($rowData)->order_size;
                            switch ($order_size) {
                                case 1:
                                    $orderTypeName = "500-1000 units";
                                    break;
                                case 2:
                                    $orderTypeName = "2000-5000 unit";
                                    break;
                                case 3:
                                    $orderTypeName = "More than 5000 unit";
                                    break;

                                default:
                                    $orderTypeName = "";
                                    break;
                            }


                            ?>


                            <div class="form-group m-form__group row">

                                <div class="col-lg-4">
                                    <label class="">Item Name:</label>
                                    <select name="sampleItemName[]" class="form-control " id="m_selec5t2_9A" name="param">
                                        <option value="{{$rowData->txtItem}}">{{$rowData->txtItem}}</option>

                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Descriptions:</label>
                                    <input <?php echo $strVal ?> name="sampleDiscription[]" value="{{$rowData->txtDiscrption}}" type="text" class="form-control m-input" placeholder="">

                                </div>
                                <div class="col-lg-2">
                                    <label style="color:#000">Target Price/Kg:</label>
                                    <div class="input-group m-input-group m-input-group--square">

                                        <input readonly value="{{optional($rowData)->price_per_kg}}" style="" type="text" name="price_per_kg[]" class="form-control m-input" placeholder="">
                                    </div>
                                    <span class="m-form__help"></span>
                                </div>
                               

                                <div class="col-lg-2">
                                    <a href="#" style="margin-top:31px;" title="DELETE" class="remove_field btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                        <i class="flaticon-delete"></i>
                                    </a>

                                </div>

                            </div>


                        <?php
                        }
                        ?>
                    </div>
                    <!-- item edit section -->
                    <br>
                    <div class="m-form__group form-group">

                        <div class="m-checkbox-inline">
                            <label class="m-checkbox">
                                <input <?php echo $samples->chkHandedOver == 1 ? "checked" : "" ?> type="checkbox" id="chkHandedOver" value="{{$samples->chkHandedOver}}" name="chkHandedOver"> <strong>Handed Over or SELF PICKUP</strong>
                                <span></span>
                            </label>
                            <label class="m-checkbox">
                                <input value="1" type="checkbox" id="paidSample" name="paidSample"> <strong>Paid Sample</strong>
                                <span></span>
                            </label>

                            <label class="m-checkboxt">
                          
                          <select class="form-control" name="paymentID" id="paymentID" >
                              <option value="">-SELECT-</option>
                              <?php 
                              
                              $payMentArr = DB::table('payment_recieved_from_client')
                                 ->where('is_deleted', 0)
                                 ->where('created_by', Auth::user()->id)
                                 ->where('payment_for', 2)
                                 ->get();
                                 foreach ($payMentArr as $key => $rowData) {
                                     ?>
                                     <option title="{{$rowData->rec_amount_words}}" value="{{$rowData->id}}">₹. {{$rowData->rec_amount}}-{{$rowData->payment_status==1 ? "PAID":"PENDING FROM Account"}}</option>
                                     <?php
                                 }
 
                                 ?>
                            
                              </select>
                              <span></span>
                          </label>

                        </div>

                    </div>

                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"> Address:</label>
                                <input type="text" class="form-control m-input" id="client_address" value="{{$samples->ship_address}}" name="client_address" placeholder="Enter Address">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Location:</label>
                                <input type="text" class="form-control m-input" value="{{$samples->location}}" name="location" placeholder="Enter Location">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Remarks:</label>
                                <input type="text" class="form-control m-input" value="{{$samples->remarks}}" name="remarks" placeholder="Enter Remarks">
                            </div>
                        </div>
                    </div>
                    <?php
                    $user = auth()->user();
                    $userRoles = $user->getRoleNames();
                    $user_role = $userRoles[0];
                    if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk' || $user_role == 'Sampler') {

                    ?>

                        <!-- <address location source-->
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> Courier:</label>


                                    <select class="form-control m-input m-input--air" id="3" name="courier_id">
                                        <?php
                                        foreach (AyraHelp::getCourier() as $key => $cour) {
                                            if ($samples->courier_id == $cour->id) {
                                        ?>

                                                <option selected value="{{$cour->id}}">{{$cour->courier_name}}</option>
                                            <?php
                                            } else {
                                            ?>

                                                <option value="{{$cour->id}}">{{$cour->courier_name}}</option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">Sent Date:</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input" readonly value="{{date("d-M-Y", strtotime($samples->sent_on))}}" name="sent_on" id="m_datepicker_3" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">Status:</label>
                                    <?php

                                    ?>
                                    <select class="form-control m-input m-input--air" id="status_sample" name="sample_status">
                                        <option {{$samples->status==1 ?'selected':"" }} value="1">NEW</option>
                                        <option {{$samples->status==2 ?'selected':"" }} value="2">SENT</option>
                                        <option {{$samples->status==3 ?'selected':"" }} value="3">RECEIVED</option>
                                        <option {{$samples->status==4 ?'selected':"" }} value="4">FEEDBACK</option>

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label"> Track ID:</label>
                                    <input type="text" class="form-control m-input" id="trackiii" value="{{$samples->track_id}}" name="track_id" placeholder="Enter TracK Id">
                                </div>
                                <div class="col-lg-8 m-form__group-sub">
                                    <label class="form-control-label">Courier Remarks:</label>
                                    <input type="text" class="form-control m-input" value="{{$samples->courier_remarks}}" name="courier_remarks" placeholder="Enter Courier Remarks">
                                </div>

                            </div>
                        </div>
                    <?php
                    }

                    ?>


                    <!-- website and remarks -->



                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->

            <!-- form  -->



            <!--end::Portlet-->





        </div>
    </div>


</div>
<!-- main  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_SampleAddItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Sample Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>


                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Item Name:</label>
                        <input type="text" id="txtSampleNewItem" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSaveSampleItem" class="btn btn-primary">Save Item</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->