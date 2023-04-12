<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Add Base Formulations:
                    </h3>
                    <!-- <table style="margin-left:30px;">
					</table> -->
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <?php
                        if (Auth::user()->id == 14444 || Auth::user()->id == 14456) {
                        ?>
                            <a target="_blank" href="{{route('addIngredetnView')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Add New Ingredient</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>
                    <li class="m-portlet__nav-item">
                        <?php
                        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
                        ?>
                            <a target="_blank" href="{{route('rnd.formulationList')}}" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Formulation List:</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>


                    <li class="m-portlet__nav-item">
                        <?php
                        $user = auth()->user();
                        $userRoles = $user->getRoleNames();
                        $user_role = $userRoles[0];

                        if (Auth::user()->id == 145445 || Auth::user()->id == 156345 || $user_role == '4chemist') {
                        ?>
                            <a href="javascript::void(0)" id="btnaddNEWRM" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>ADD NEW RM</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>




                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <?php
            $max_id = DB::table('bo_formuation_v1')->max('id') + 1;
            $uname = 'BSFM-';
            $num = $max_id;
            $str_length = 5;
            $sid_code = $uname . substr("000{$num}", -$str_length);
            ?>


            <form id="btnSaveFormuationRND" class="m-form m-form--fit m-form--label-align-right m-form" action="{{route('saveFormulaRNDBasev1')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="txtUID" value="{{$max_id}}">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-2">
                            <label>*Name:</label>
                            <input type="text" name="txtFMName" class="form-control m-input" placeholder="Enter Formulation Name">


                        </div>
                        <div class="col-lg-2">
                            <label>BASE Code:</label>
                            <input type="text" name="txtBaseCode"    class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2">
                            <label>FM Code::</label>
                            <input type="text" name="txtFMCode" style="background-color:#035496;color:#f1f1f1;" value="{{$sid_code}}" readonly class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-3" style="">
                            <label>*Sample ID</label>
                            
                            <input id="m_inputmask_67" type="hidden" name="txtMFGQTY" style="background-color:grey;color:#f1f1f1;" class="form-control m-input" placeholder="">

                            
                            <select class="form-control m-select2" id="m_select2_3" name="txtSampleID">
                            <optgroup label="Select Other">
                                <option selected value="">Other</option>
                            </optgroup>
                            <?php 
                             $sampleArr = DB::table('samples')
                             ->where('is_deleted', 0)
                             ->where('status', 1)
                             ->orderBy('id', 'desc')
                             ->get();

                            

                             foreach ($sampleArr as $key => $row) { 
                                 ?>
                                 <optgroup label="{{$row->sample_code}}">

                                 <?php
                                $sampleArrITEM = DB::table('sample_items')->whereNull('chemist_id')->where('sid',$row->id)->get();
                                foreach ($sampleArrITEM as $key => $rowData) {
                                    ?>
                                    <option value="{{$rowData->id}}">{{$rowData->sid_partby_code}} ({{$rowData->item_name}}) </option>
                                    <?php
                                }

                                ?>
                                 </optgroup>
                                <?php
                             }

                            ?>     
                           
							</select>



                        </div>

                        <div class="col-lg-3">
                            <label>Formulated By:</label>

                            <select class="form-control" name="txtFormulatedBy">
                                <?php

                                if (Auth::user()->id == 1 || Auth::user()->id == 156 || Auth::user()->id == 89 || Auth::user()->id == 206) {
                                    $chemistArr = AyraHelp::getChemist();
                                    foreach ($chemistArr as $key => $rowData) {
                                    ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                <?php
                                    }

                              

                                } else {
                                    ?>
                                    <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>

                                    <?php
                                }

                                ?>
                            </select>


                        </div>

                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-2">
                            <label>pH Value:</label>
                            <input type="text" name="txt_ph_val"  style="background-color:gray;color:#f1f1f1;" class="form-control m-input" placeholder="">


                        </div>
                        <div class="col-lg-2">
                            <label>Viscosity</label>
                            <input type="text" name="txt_vescocity_val" style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2" style="">
                            <label>Fragrance</label>
                            <input type="text" name="txt_fragrance_val" style="background-color:gray;color:#f1f1f1;"  class="form-control m-input" placeholder="">

                        </div>

                        <div class="col-lg-2">
                            <label>Color:</label>
                            <input type="text" name="txt_color_val" style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2">
                            <label>Apperance:</label>
                            <input type="text" name="txt_apperance_val" style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2">
                            <label>Date:</label>
                            <input type="text" name="formula_date" class="form-control" id="m_datepicker_1" readonly="" placeholder="Select date">

                        </div>

                    </div>
                    <br>
                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-primary" style="background-color:#f1f1f1;">
                        <thead>
                            <tr>
                                <th>*Ingredient Name</th>
                                <th>*Dose (%)</th>
                                <th>*Phase</th>
                                <th>Price(<span id="txtRSize"></span>/<span id="txtRPrice"></span>)</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="350px">
                                    <input type="hidden"  id="txtRMID">
                                    <input type="hidden"  id="txtRMTEXT">
                                   

                                    <div class="m-typeahead">
									<input class="form-control m-input kt_typeahead_4" id="kt_typeahead_4" type="text" dir="ltr" placeholder="name">
									</div>


                                </th>

                                <td width="100px">
                                    <input type="text" id="m_inputmask_6" name="txtDose" class="form-control m-input" placeholder="">
                                </td>
                                <td width="150px">

                                    <select class="form-control" name="txtPhase" id="txtPhase">
                                        <?php
                                        foreach (range('A', 'H') as $char) {

                                        ?>
                                            <option value="{{$char}}">{{$char}}</option>
                                        <?php
                                        }

                                        ?>

                                    </select>

                                </td>



                                <td>
                                    <input type="text" name="txtIPrice" class="form-control m-input" placeholder="">
                                </td>
                                <td width="180px">
                                    <input type="text" readonly id="txtRNDCost" name="txtRNDCost" class="form-control m-input" placeholder="">
                                </td>
                                <td>
                                    <a href="#" style="margin-top: 1px;" class="add_field_buttonFormualtion btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                                        <span>
                                           ADD 

                                        </span>
                                    </a>

                                </td>
                            </tr>



                        </tbody>
                    </table>

                    <hr>
                    <table class="table table-bordered m-table m-table--border-primary m-table--head-bg-success" style="background-color:#f1f1f1;">
                        <thead>
                            <tr>
                                <th>Ingredient Name</th>
                                <th>Dose (%)</th>
                                <th>Phase</th>

                                <th>Price</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="input_fields_wrapFormulation">




                        </tbody>
                    </table>


                    <table class="table table-striped m-table" style="background-color:#f1f1f1;">

                        <tbody>
                            <tr>
                                <th width="250px">
                                </th>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalDose" id="txtTotalDose">
                                    <b>Total Dose:</b> <span id="txtPView">(%)</span>
                                </td>
                                <td width="83px">
                                </td>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalPr" id="">

                                </td>
                                <td>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalCostP" id="">
                                    <b>Cost Price:</b>₹. <span id="txtTotalCostP">0</span>
                                </td>
                                </td>

                                <td>

                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand ">
                        <thead>
                            <tr>
                                <th>Phase</th>
                                <th>Process</th>
                                <th>RPM</th>
                                <th>TEMP °C</th>
                                <th> Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="ajphaseProcessClass">
                            <!-- <tr>
                                <td>
                                    <select class="form-control " name="txtPhaseEntry[]" id="txtPhaseEntry">
                                        <?php
                                        foreach (range('A', 'Z') as $char) {

                                        ?>
                                            <option value="{{$char}}">{{$char}}</option>
                                        <?php
                                        }

                                        ?>

                                    </select>
                                </td>
                                <td>
                                    <textarea class="form-control" name="txtProcessEntry[]" id="" cols="30" rows="1"></textarea>
                                </td>
                                <td>
                                   

                                </td>
                            </tr> -->

                        </tbody>
                    </table>

                    <div id="textdiv" class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary submitView">Submit</button>
                                    <button type="reset" id="btnResetRND" class="btn btn-secondary">Add NEW</button>
                                </div>
                            </div>
                        </div>
                    </div>


            </form>

            <!--end::Form-->





            <!-- save  -->

        </div>
    </div>

    <div class="m-portlet m-portlet--mobile" style="display:none">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Ingredients Formulations List
                    </h3>
                    <!-- <table style="margin-left:30px;">
					</table> -->
                </div>
            </div>

        </div>
        <div class="m-portlet__body">

            <!--begin: Search Form -->

            <form class="m-form m-form--fit m--margin-bottom-20" style="display:none ;">
                <div class="row m--margin-bottom-20">
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Ingredient Name:</label>
                        <input type="text" class="form-control m-input" placeholder="" data-col-index="1">
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Category:</label>
                        <select id="catIDPrice" class="form-control m-input" data-col-index="2">
                            <option value="">-SELECT-</option>
                            <?php
                            $ing_arr = AyraHelp::getIngredientCategory();
                            foreach ($ing_arr as $key => $rowData) {
                            ?>
                                <option value="{{$rowData->category_name}}">{{$rowData->category_name}}</option>
                            <?php
                            }

                            ?>
                            <option value="ALL">ALL</option>

                        </select>

                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Other Name:</label>
                        <input type="text" class="form-control m-input" placeholder="" data-col-index="3">
                    </div>

                    <?php
                    if (Auth::user()->id == 1 || Auth::user()->id == 156 || Auth::user()->id == 90) {
                    ?>
                        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                            <a href="javascript::void(0)" id="btnDownLoadRndPrice" style="margin-top:25px" class="btn btn-warning  m-btn  m-btn m-btn--icon">
                                <span>
                                    <i class="fa fa-cloud-download-alt"></i>
                                    <span>Download</span>
                                </span>
                            </a>
                            <a href="javascript::void(0)" id="btnDownLoadRndPriceSample">
                                <span>
                                    <i class="fa fa-cloud-download-alt"></i>

                                </span>
                            </a>

                        </div>
                    <?php
                    }
                    ?>




                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px;">
                            <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                            </span>
                        </button>

                    </div>


                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px;">
                            <span>
                                <i class="la la-close"></i>
                                <span>Reset</span>
                            </span>
                        </button>

                    </div>


                </div>

            </form>



            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_RNDFormulation" style="display: ;">
                <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Formula Name</th>
                        <th>FM CODE</th>
                        <th>Created at</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- datalist -->
</div>
<!-- main  -->



<div class="modal fade" id="m_select2_4_modal_AddNewRM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Batsize</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">BatchSize:</label>
                        <input type="text" class="form-control" id="txtRMName">
                    </div>
                   
                   
                </form>
            </div>
            <div class="modal-footer">
                
                <button type="button" id="btnAddRMProduct" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_4ING_DETAILA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Batch Sheet </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
           
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">BatchSize:</label>
                        <input type="text" class="form-control" id="txtRMName">
                    </div>
                    <button type="button" id="btnAddRMProduct" class="btn btn-primary">Submit</button>
                   
  

            </div>

        </div>
    </div>
</div>

<!--end::Modal-->

<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="view_sent_sample_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Sample</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- modal content -->
                <table class="table m-table">
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <th><strong>Sample ID:</strong></th>
                            <td colspan="3" id="s_id"></td>
                            <td><strong>Company:</strong>:</td>
                            <td id="s_company"></td>


                        </tr>
                        <tr>
                            <th><strong>Name:</strong></th>
                            <td id="s_contactName"></td>
                            <td><strong>Phone:</strong>:</td>
                            <td id="s_contactPhone"></td>

                        </tr>


                        <tr>
                            <th><strong>Samples</strong></th>
                            <td colspan="4">
                                <table class="table table-sm m-table m-table--head-bg-metal">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th style="color:#000">#</th>
                                            <th style="color:#000">Item</th>
                                            <th style="color:#000">Description</th>
                                            <th style="color:#000">Price/Kg</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemdata">



                                    </tbody>
                                </table>

                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <th><strong>Shipping Address</strong></th>
                            <td colspan="3" id="s_ship_address">444</td>
                            <td>Location</td>
                            <td id="s_location">444</td>
                        </tr>

                        <tr>
                            <th><strong>Status</strong></th>
                            <td colspan="3" id="s_status">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="ajrow_tr_c">
                            <th><strong>Courier</strong></th>
                            <td colspan="3">
                                <table class="table table-sm m-table m-table--head-bg-metal">
                                    <thead class="thead-inverse">
                                        <tr>

                                            <th style="color:#000">Courier Name</th>
                                            <th style="color:#000">Tracking ID</th>
                                            <th style="color:#000">Sent on</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td id="s_courier_name">

                                            </td>
                                            <td id="s_track_id">

                                            </td>
                                            <td id="s_sent_on">

                                            </td>

                                        </tr>
                                        <tr colspan="3">
                                            <td>
                                                Courier Remarks
                                            </td>
                                            <td id="s_remarks">

                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
                <div class="ajrow_tr_new">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>Courier:</label>


                            <select class="form-control m-input m-input--air" id="courier_data">
                                <option value="NULL">-SELECT-</option>

                                @foreach (AyraHelp::getCourier() as $courier)
                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="">Sent Date:</label>
                            <div class="input-group date">
                                <input type="text" class="form-control m-input" readonly id="m_datepicker_3" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Status:</label>
                            <select class="form-control m-input m-input--air" id="status_sample">
                                <option value="1">NEW</option>
                                <option value="2">SENT</option>
                                <option value="3">RECEIVED</option>
                                <option value="4">FEEDBACK</option>
                            </select>

                        </div>
                    </div>
                    <input type="hidden" name="v_s_id" id="v_s_id">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>Track ID:</label>
                            <input type="text" class="form-control m-input" id="track_id" placeholder="Enter TracK ID">

                        </div>
                        <div class="col-lg-8">
                            <label>Remarks:</label>
                            <textarea class="form-control m-input m-input--air" id="txtRemarksArea" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:none">
                    <div class="col-lg-4">
                        <label>Sample Feedback:</label>

                        <select name="feedback_option" id="feedback_option">
                            <option value="0">--Select Options-- </option>
                            <?php
                            $sample_feed_arr = AyraHelp::getSampleFeedback();
                            foreach ($sample_feed_arr as $key => $value) {
                            ?>
                                <option value="{{$value->id}}">{{$value->feedback}}</option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-lg-8">
                        <label>Others Feedback:</label>
                        <textarea class="form-control m-input m-input--air" id="feedback_other" rows="3"></textarea>
                    </div>
                    <button type="button" id="btnSaveSampleSentFeedback" class="btn btn-primary">Save Feedback</button>
                </div>






                <!-- modal content -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSaveSampleSent" disabled class="btn btn-primary ajrow_tr_new">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- modal -->



<div class="modal fade" id="m_modal_6_feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Sample Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="v_s_id" id="v_s_id" value="">


                <div class="form-group m-form__group">
                    <label>Feedback Options</label>
                    <div class="input-group">
                        <select class="form-control m-input" name="feedback_option1" id="feedback_option1">
                            <option value="">--Select Options-- </option>
                            <?php
                            $sample_feed_arr = AyraHelp::getSampleFeedback();
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
                    <textarea class="form-control" id="txtFeedbackRemarks" name="txtFeedbackRemarks"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnsaveFeedback" class="btn btn-primary">Save Feedback</button>
            </div>
        </div>
    </div>
</div>

<!-- m_modal_6 -->