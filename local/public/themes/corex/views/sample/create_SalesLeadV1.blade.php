<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Add Sample forSales Lead
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



            <!-- form  -->
            <?php
            // print_r($users);
            $parameters = Request::segment(1);
            if ($parameters == 'stage_sales-leadv1') {
                $sample_from = 3;
            }

           


            //die;
            ?>
            <!--begin::Form-->
            <?php
            // echo "<pre>";
            // print_r($users);

            $data = AyraHelp::getfeedbackAlert(Auth::user()->id);
            $myc = $data['count'];
             $myc=0;
            if ($myc > 0) {
            ?>
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <h3 style="color:red">Kindly add feedback for following samples.</h3>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sample ID</th>
                                    <th>Client Name</th>
                                    <th>Sent On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;

                                foreach ($data['data'] as $key => $RowData) {


                                    $client_arr = AyraHelp::getClientbyid($RowData->client_id);
                                    $i++;


                                ?>
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <td>{{$RowData->sample_code}}</td>
                                        <td>{{optional($client_arr)->firstname}}</td>
                                        <td>{{date("l d,M Y h:iA", strtotime($RowData->sent_on))}}</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Section-->
                <hr>

            <?php
            }
            ?>
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_sample" method="post" action="{{ route('saveSalesLeadSample')}}">
                @csrf
                <input type="hidden" name="added_userid" value="{{Request::segment(4)}}">
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">* Sample ID:</label>
                                <input type="text" readonly class="form-control m-input" value="{{AyraHelp::getSampleIDCode()}}" name="sample_id" placeholder="Enter Company">
                            </div>
                            <input type="hidden" value="{{$sample_from}}" name="sample_from">
                            <div class="col-lg-8 m-form__group-sub">
                                <label class="form-control-label">Select Client:</label>
                                <select class="form-control m-select2 client_name" id="m_select2_1" name="client_id">
                                    <option value="{{$users->id}}">{{optional($users)->firstname}} || {{optional($users)->company}} | {{$users->phone}} | {{$users->email}}</option>
                                </select>
                            </div>
                             <div class="col-md-4" style="margin-top: 2px;">
                                <label style="color:#000">Category:</label>
                                <select class="form-control m-input" id="sampleSelectCat">

                                    <?php
                                    switch (Request::segment(3)) {
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
                            <!-- //-------------------------- -->
                            <div class="col-lg-4">
                                <label style="color:#000">Brand type:</label>
                                <div class="input-group m-input-group m-input-group--square">
                                <select class="form-control" id="selectBrandType" name="sampleBrandType">
                                <option value="">-SELECT-</option>
                                <option value="1">New brand</option>
                                <option value="2">Small brand</option>
                                <option value="3">Medium brand</option>
                                <option value="4">Big brand</option>
                                <option value="5">In-House brand</option>
                                </select>

                                </div>
                                <span class="m-form__help"></span>
                            </div>
                            <div class="col-lg-4">
                                <label style="color:#000">Order size:</label>
                                <div class="input-group m-input-group m-input-group--square">
                                <select class="form-control" id="selectOrderSize" name="sampleOrderSize">
                                <option value="">-SELECT-</option>
                                <option value="1">500-1000 units</option>
                                <option value="2">1000-2000 units</option>
                                <option value="3">2000-5000 units</option>
                                <option value="4">More than 5000 units</option>
                              
                                </select>

                                </div>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                    </div>
                    <!-- sample detaila -->
                    <input type="hidden" name="sample_type" value="{{Request::segment(3)}}">
                    <div class="m-form__section m-form__section--first">
                        <!-- repeater -->
                        <div class="form-group m-form__group row">
                         
                            <div class="col-lg-4">
                                <label class="">Item Name:</label>
                                <select class="form-control m-select2 orderSampleIDViewSample" id="m_select2_9A" name="param">
                                    <?php
                                    $HTML = "";
                                    switch (Request::segment(3)) {

                                        case 2:

                                            $usersD = DB::table('rnd_add_ingredient')->get();
                                            foreach ($usersD as $key => $rowData) {
                                                $HTML .= '<option value=' . '97116' . $rowData->name . '>' . $rowData->name . '</option>';
                                            }
                                            $usersAj = DB::table('sample_itemname')->where('cat_type', 2)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
                                            }

                                            echo $HTML;

                                            break;
                                        case 1:
                                            $usersD = DB::table('rnd_finish_products')->get();
                                            foreach ($usersD as $key => $rowData) {
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
                                            $usersAj = DB::table('samples_formula')->where('user_id', Auth::user()->id)->get();
                                            foreach ($usersAj as $key => $rowData) {
                                                 //$HTML .= '<option value=' . $rowData->sample_code_with_part . '>' . $rowData->sample_code_with_part . '</option>';
                                            }
                                            echo $HTML;
                                            break;
                                    }

                                    ?>
                                </select>
                                <a href="javascript::void(0)" data-toggle="modal" data-target="#m_modal_SampleAddItem" style="margin-top: 1px;color:#FFF" title="Add New item" class="btn btn-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-3x">
                                    <i class="fa flaticon-plus"></i>
                                </a>
                                <span class="viewitemSelect"></span>
                            </div>

                            <div class="col-lg-4">
                                <label>Descriptions:</label>
                                <div class="input-group m-input-group m-input-group--square">

                                    <input type="text" id="txtDisInFO" class="form-control m-input" placeholder="">
                                </div>
                                <span class="m-form__help"></span>
                            </div>

                            <div class="col-lg-2">
                                <label>Target Price/Kg:</label>
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


                        <div class="input_fields_wrap">


                        </div>



                        <!-- repeater -->
                    </div>
                    <!-- sample detaila -->


                    <!-- <address location source>
                              </address> email phone -->

                    <div class="m-form__group form-group">

                        <div class="m-checkbox-inline">
                           <label class="m-checkbox">
                                <input value="2" type="checkbox" id="chkHandedIsDomestic" name="chkHandedIsDomestic"> <strong>International Sample ?</strong>
                                <span></span>
                            </label>
                            <label class="m-checkbox">
                                <input type="checkbox" id="chkHandedOver" name="chkHandedOver"> <strong>Handed Over or SELF PICKUP</strong>
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
                            <div class="col-lg-12 m-form__group-sub">
                                <label class="form-control-label"> Address:</label>
                                <input type="text" class="form-control m-input" id="client_address" value="{{$users->address}}" name="client_address" value="" placeholder="Enter Address">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Location:</label>
                                <input type="text" class="form-control m-input" name="location" value="{{$users->location}}"  placeholder="Enter Location" value="">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Contact:</label>
                                <input type="text" id="client_contact_phone" class="form-control m-input" value="{{$users->phone}}" name="contact_phone" placeholder="Enter Phone">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Remarks:</label>
                                <input type="text" class="form-control m-input" name="remarks" placeholder="Enter Remarks">
                            </div>
                        </div>
                    </div>
                    <!-- <address location source-->
                    <!-- website and remarks -->
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <?php


                            if ($myc > 0) {
                            ?>

                            <?php
                            } else {
                            ?>
                                <div class="col-lg-12">
                                    <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            <?php
                            }





                            ?>
                            <!-- <div class="col-lg-12">
                                    <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div> -->
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