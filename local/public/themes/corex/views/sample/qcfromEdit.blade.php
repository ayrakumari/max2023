<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  QC FORM EDIT
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{ route('qcform.creates')}}" id="btn4NewOrder" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-plus"></i>
                        <span>ADD NEW ORDER </span>
                     </span>
                  </a>
               </li>

               <li class="m-portlet__nav-item">
                  <a href="{{ route('v1_getOrderslist')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-arrow-left"></i>
                        <span>BACK </span>
                     </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <?php
      $order_arr = AyraHelp::getOrderCODE();
      $order_arrIndex = AyraHelp::getOrderCODEIndex();


      ?>

      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_edit_qcform" method="post" action="{{ route('updateQCdataNewWays')}}">
               @csrf

               <input type="hidden" name="formID" value="{{ $qc_form->form_id }}">

               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <input type="hidden" readonly class="form-control m-input" value="{{  $qc_form->order_id}}/{{  $qc_form->subOrder}}" name="order_id" placeholder="Enter Order No.">


                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Select Client:</label>
                           <select class="form-control m-select2 client_name_qcform" id="m_select2_1" name="client_id">

                              <?php
                              foreach (AyraHelp::getClientByadded(Auth::user()->id) as $key => $user) {

                                 if ($qc_form->client_id == $user->id) {

                              ?>
                                    <option selected value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>

                                 <?php
                                 } else {
                                 ?>
                                    <option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>

                              <?php
                                 }
                              }
                              ?>
                           </select>
                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">TARGET:</label>
                           <div class="input-group">
                              <input type="text" name="due_date" value="{{ date('Y-m-d', strtotime($qc_form->due_date))}}" class="form-control" id="m_datepicker_1" readonly placeholder="Select date" />

                           </div>


                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">COMMITTED:</label>

                           <div class="input-group">
                              <input type="text" name="commited_date" value="{{ date('Y-m-d', strtotime($qc_form->commited_date))}}" class="form-control" id="m_datepicker_1" readonly placeholder="Select date" />

                           </div>


                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <div class="m-form__group form-group">

                              <label for="">Order</label>
                              <div class="m-checkbox-inline">
                                 <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                    <input type="radio" <?php echo $qc_form->order_type == 'Private Label' ? 'checked' : '' ?> value="1" name="order_type"> Private Label
                                    <span></span>
                                 </label>
                                 <label style="visibility:hidden" class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                    <input type="radio" <?php echo $qc_form->order_type == 'Bulk' ? 'checked' : '' ?> value="2" id="order_type" name="order_type"> Bulk
                                    <span></span>
                                 </label>

                              </div>

                           </div>



                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">* Order Type:</label>
                           <div class="m-checkbox-inline">
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" <?php echo $qc_form->order_type_v1 == '1' ? 'checked' : '' ?>  value="1" name="order_type_v1"> New
                                 <span></span>
                              </label>
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" <?php echo $qc_form->order_type_v1 == '2' ? 'checked' : '' ?> value="2" name="order_type_v1"> Repeat
                                 <span></span>
                              </label>
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" value="3" <?php echo $qc_form->order_type_v1 == '3' ? 'checked' : '' ?> name="order_type_v1"> Product Addition
                                 <span></span>
                              </label>

                           </div>
                        </div>


                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label"> Brand:</label>
                           <input type="text" value="{{$qc_form->brand_name}}" class="form-control m-input" id="client_address" name="brand" placeholder="">
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                           <label>Repeat Order:</label>
                           <div class="m-radio-inline">
                              <label class="m-radio m-radio">
                                 <input type="radio" <?php echo $qc_form->order_repeat == '2' ? 'checked' : '' ?> name="order_repeat" value="2"> YES
                                 <span></span>
                              </label>
                              <label class="m-radio m-radio">
                                 <input type="radio" <?php echo $qc_form->order_repeat == '1' ? 'checked' : '' ?> name="order_repeat" value="1"> NO
                                 <span></span>
                              </label>
                           </div>
                        </div>

                        <?php
                        if ($qc_form->order_repeat == '2') {
                           $ajstyle = "";
                        } else {
                           $ajstyle = "ajorderhide";
                        }

                        ?>
                        <div class="col-lg-2 m-form__group-sub <?php echo $ajstyle ?>">
                           <label class="form-control-label">Prev Order NO.:</label>
                           <input type="text" class="form-control m-input" name="pre_orderno" placeholder="Previoud Order No" value="{{$qc_form->pre_order_id}}">
                        </div>
                        <div class="col-lg-2 m-form__group-sub ">
                           <label class="form-control-label">Currency:</label>
                           <?php
                           if (strtoupper($qc_form->order_currency) == "USD") {
                              $ajstyleorder = "display:block";
                           } else {
                              $ajstyleorder = "display:none";
                           }

                           ?>

                           <select class="form-control currency_order" name="currency" id="currency">

                              <?php
                              if (strtoupper($qc_form->order_currency) == "INR") {
                              ?>
                                 <option value="INR" selected>INR</option>
                                 <option value="USD">USD</option>
                              <?php


                              } else {
                              ?>
                                 <option value="USD" selected>USD</option>
                                 <option value="INR">INR</option>
                              <?php
                              }
                              ?>

                           </select>

                        </div>
                        <div class="col-lg-2 m-form__group-sub ajorderhiderate" style="<?php echo $ajstyleorder ?>">
                           <label class="form-control-label">Conversion Rate:</label>
                           <input type="text" style="background:burlywood; border:1px solid #035496" class="form-control m-input" name="conv_rate" value="{{ $qc_form->exchange_rate }}" placeholder="">
                        </div>
                     </div>

                  </div>
                  <div id="formLayoutAJITEMS">
                     <table class="table m-table m-table--head-bg-brand ajitemTable">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Item Name</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <th>FM No./Sample No:</th>
                           </tr>
                        </thead>
                        <tbody id="showitemLayout">


                        </tbody>
                     </table>
                     <hr>
                  </div>

                  <div id="formLayoutAJ">
                     <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                           <div class="col-lg-3 m-form__group-sub">
                              <label class="form-control-label"> Item Name:</label>
                              <input type="text" value="{{$qc_form->item_name}}" class="form-control m-input" id="item_name" name="item_name" placeholder="Enter Item Name">
                           </div>
                           <div class="col-lg-2 m-form__group-sub">
                              <label class="form-control-label"> Size:</label>
                              <input type="number" value="{{$qc_form->item_size}}" class="form-control m-input" id="item_size" name="item_size" placeholder="Size">


                           </div>
                           <div class="col-lg-2 m-form__group-sub">
                              <label class="form-control-label">Size Unit</label>
                              <?php
                              echo $qc_form->item_size_unit;
                              ?>
                              <select name="item_size_unit" id="item_size_unit" class="form-control m-input">
                                 <?php
                                 if ($qc_form->order_type == 'Bulk') {


                                 ?>
                                    <option <?php echo $qc_form->item_size_unit == 'Kg' ? 'selected' : '' ?> value="Kg">KG</option>
                                    <option <?php echo $qc_form->item_size_unit == 'L' ? 'selected' : '' ?> value="L">L</option>
                                 <?php
                                 } else {
                                 ?>
                                    <option <?php echo $qc_form->item_size_unit == 'Ml' ? 'selected' : '' ?> value="Ml">ML</option>
                                    <option <?php echo $qc_form->item_size_unit == 'Gm' ? 'selected' : '' ?> value="Gm">Gm</option>
                                 <?php
                                 }
                                 ?>
                              </select>



                           </div>
                           <div class="col-lg-1 m-form__group-sub">
                              <label class="form-control-label"> QTY:</label>
                              <input type="number" value="{{$qc_form->item_qty}}" style="width:90px;" class="form-control m-input" id="item_qty" name="item_qty" placeholder="QTY">
                           </div>
                           <div class="col-lg-2 m-form__group-sub">
                              <label class="form-control-label"> QTY Unit:</label>
                              <select style="width:80px;" name="item_qty_unit" id="item_qty_unit" class="form-control m-input">
                                 <?php
                                 if ($qc_form->order_type == 'Bulk') {
                                 ?>
                                    <option <?php echo $qc_form->item_size_unit == 'Kg' ? 'selected' : '' ?> value="Kg">KG</option>
                                    <option <?php echo $qc_form->item_size_unit == 'L' ? 'selected' : '' ?> value="L">L</option>
                                 <?php
                                 } else {
                                 ?>
                                    <option value="pcs">pcs</option>

                                 <?php
                                 }
                                 ?>
                              </select>


                           </div>
                           <div class="col-lg-2 m-form__group-sub">
                              <label class="form-control-label"> Sample Code:</label>
                              <!-- <label class="form-control-label"> FM No./S. No:</label> -->
                              <!-- <input type="text" title="FM No./Sample. No:" value="{{$qc_form->item_fm_sample_no}}" class="form-control m-input" id="item_fm_sample_no" name="item_fm_sample_no" placeholder="FM No./Sample No"> -->
                              <select class="form-control m-input item_fm_sample_no "  id="item_fm_sample_no" name="item_fm_sample_no_bulk_m">
                              <option value="">SELECT</option>
                                 
                                  <?php
                                    foreach (AyraHelp::getSampleIDByUserIDWithFormulation(Auth::user()->id) as $key => $row) {

                                    ?>
                                       <option value="{{$row->sample_code_with_part}}">{{$row->sample_code_with_part}}</option>
                                    <?php
                                    }
                                    ?>
                                     <?php
                                    foreach (AyraHelp::getSampleIDByUserIDWithFormulationOIL(Auth::user()->id) as $key => $row) {

                                    ?>
                                       <option value="{{$row->sample_code}}">{{$row->sample_code}}</option>
                                    <?php
                                    }
                                    ?>
                                    <!-- <option value="Standard">Standard</option>
                                    <option value="Regular">Regular</option> -->


                              </select>
                             
                              <span id="lblItemS">{{$qc_form->item_fm_sample_no}}</span>
                              <input type="hidden" id="item_fm_sample_no_bulkX" name="item_fm_sample_no" value="{{$qc_form->item_fm_sample_no}}">

                           </div>

                        </div>
                     </div>

                      <!-- price by part  -->
                      <div style="display:block;" class="m-form__section m-form__section--first" style="background-color: #c1c1c1;">
                           <div class="form-group m-form__group row">
                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Row Material Price per Kg" class="form-control-label">RM Price/Kg:</label>
                                 <input title="Enter Row Material Price per Kg" type="number" class="form-control m-input" id="item_RM_Price" name="item_RM_Price" value="{{$qc_form->item_RM_Price }}" placeholder="">
                              </div>

                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Price of Bottle/Jar/Cap" class="form-control-label">Bottle/Cap/Pump:</label>
                                 <input title="Enter Price of Bottle/Jar/Cap" type="number" class="form-control m-input" id="item_BCJ_Price" name="item_BCJ_Price"  value="{{$qc_form->item_BCJ_Price }}"  placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Price of Label" class="form-control-label"> Label Price:</label>
                                 <input title="Enter Price of Label" type="number" class="form-control m-input" id="item_Label_Price" name="item_Label_Price" value="{{$qc_form->item_Label_Price }}"   placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">M.Carton Price:</label>
                                 <input title="Enter Material Carton Price" type="number" class="form-control m-input" id="item_Material_Price" name="item_Material_Price" value="{{$qc_form->item_Material_Price }}"   placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">L & C Price:</label>
                                 <input title="Enter Labour & Conversion Price" type="number" class="form-control m-input" id="item_LabourConversion_Price" name="item_LabourConversion_Price" value="{{$qc_form->item_LabourConversion_Price }}"  placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">Margin:</label>
                                 <input title="Enter Margin" type="number" class="form-control m-input" id="item_Margin_Price" name="item_Margin_Price"  value="{{$qc_form->item_Margin_Price }}"  placeholder="">
                              </div>

                           </div>
                        </div>
                        <!-- price by part  -->

                     <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                           <div class="col-lg-3 m-form__group-sub">
                              <label class="form-control-label"> Selling Price(Rs.):</label>
                              <input type="number" value="{{$qc_form->item_sp}}" class="form-control m-input" id="item_selling_price" name="item_selling_price" placeholder="Selling Price">
                           </div>
                           <div class="col-lg-2 m-form__group-sub">
                              <label class="form-control-label"> Unit:</label>
                              <select name="item_selling_UNIT" id="item_selling_UNIT" class="form-control m-input">
                                 <?php
                                 if ($qc_form->order_type == 'Bulk') {
                                 ?>
                                    <option <?php echo $qc_form->item_sp_unit == 'Kg' ? 'selected' : '' ?> value="Kg">KG</option>
                                    <option <?php echo $qc_form->item_sp_unit == 'L' ? 'selected' : '' ?> value="L">L</option>
                                 <?php
                                 } else {
                                 ?>
                                    <option value="pcs">pcs</option>

                                 <?php
                                 }
                                 ?>
                              </select>


                           </div>
                           <div class="col-lg-3 m-form__group-sub">
                              <label class="form-control-label"> Order Value(Rs.):</label>
                              <input type="text" disabled style="background:darkslateblue;color:floralwhite;font-weight:800" value="{{ $qc_form->item_sp* $qc_form->item_qty}}" class="form-control m-input" id="order_value" name="order_value" placeholder="">
                           </div>
                           <div class="col-lg-4 m-form__group-sub">
                              <div class="m-form__group form-group">
                                 <label for="">Order For:</label>
                                 <div class="m-radio-inline">
                                    <label class="m-radio m-radio--check-bold m-radio--state-primary">
                                       <input type="radio" <?php echo $qc_form->export_domestic == '1' ? 'checked' : '' ?> value="1" name="order_for" checked> Domestic
                                       <span></span>
                                    </label>
                                    <label class="m-radio m-radio--check-bold m-radio--state-primary">
                                       <input type="radio" <?php echo $qc_form->export_domestic == '2' ? 'checked' : '' ?> value="2" id="order_for" name="order_for"> Export
                                       <span></span>
                                    </label>

                                 </div>

                              </div>

                           </div>

                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="m-form__section m-form__section--first">
                              <div class="form-group m-form__group row">
                                 <div class="col-lg-12 m-form__group-sub">
                                    <label class="form-control-label"> Fragrance</label>
                                    <input type="text" value="{{$qc_form->order_fragrance}}" class="form-control m-input" id="order_fragrance" name="order_fragrance" placeholder="Fragrance">
                                 </div>
                              </div>
                           </div>



                        </div>
                        <!-- aja img -->
                        <div class="col-md-5">
                           <div class="form-group m-form__group">
                              <label for="exampleInputEmail1">Packaging Image</label>
                              <div></div>
                              <div class="custom-file">
                                 <input type="file" name="file" id="inputGroupFile01" class="custom-file-input">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div id='img_contain'>
                              <img id="blah" width="180" height="150" align='middle' src="{{ asset($qc_form->pack_img_url) }}" alt="Packaging Images" title='' />
                           </div>
                        </div>
                        <!-- aja img -->
                     </div>
                     <br>

                     <div class="row">
                        <div class="col-xl-6">
                           <div class="m-form__section m-form__section--first">
                              <div class="form-group m-form__group row">
                                 <div class="col-lg-612m-form__group-sub">
                                    <div class="m-form__group form-group">
                                       <label for="">Printed Box</label>
                                       <div class="m-radio-inline">
                                          <?php
                                          $j = 0;
                                          foreach ($qcBOM_form as $key => $value) {
                                             if ($value->m_name == 'Printed Box') {
                                                $j++;
                                          ?>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'Order' ? "checked" : ""  ?> name="printed_box" value="Order"> Order
                                                   <span></span>
                                                </label>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'From Client' ? "checked" : ""  ?> name="printed_box" value="From Client">From Client
                                                   <span></span>
                                                </label>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'N/A' ? "checked" : ""  ?> name="printed_box" value="N/A"> N/A
                                                   <span></span>
                                                </label>
                                             <?php
                                             }
                                          }
                                          if ($j == 0) {
                                             ?>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_box" value="Order"> Order
                                                <span></span>
                                             </label>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_box" value="From Client">From Client
                                                <span></span>
                                             </label>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_box" value="N/A"> N/A
                                                <span></span>
                                             </label>
                                          <?php
                                          }
                                          ?>


                                       </div>
                                       <span class="m-form__help"></span>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>
                        <div class="col-xl-6">
                           <div class="m-form__section m-form__section--first">
                              <div class="form-group m-form__group row">
                                 <div class="col-lg-612m-form__group-sub">
                                    <div class="m-form__group form-group">
                                       <label for="">Printed Label</label>
                                       <div class="m-radio-inline">
                                          <?php
                                          $i = 0;
                                          foreach ($qcBOM_form as $key => $value) {

                                             if ($value->m_name == 'Printed Label') {
                                                $i++;
                                          ?>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'Order' ? "checked" : ""  ?> name="printed_label" value="Order"> Order
                                                   <span></span>
                                                </label>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'From Client' ? "checked" : ""  ?> name="printed_label" value="From Client">From Client
                                                   <span></span>
                                                </label>
                                                <label class="m-radio">
                                                   <input type="radio" <?php echo $value->bom_from == 'N/A' ? "checked" : ""  ?> name="printed_label" value="N/A"> N/A
                                                   <span></span>
                                                </label>
                                             <?php
                                             }
                                          }
                                          if ($i == 0) {
                                             ?>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_label" value="Order"> Order
                                                <span></span>
                                             </label>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_label" value="From Client">From Client
                                                <span></span>
                                             </label>
                                             <label class="m-radio">
                                                <input type="radio" name="printed_label" value="N/A"> N/A
                                                <span></span>
                                             </label>
                                          <?php
                                          }
                                          ?>
                                       </div>
                                       <span class="m-form__help"></span>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="row">
                        <div class="col-xl-12">

                           <div class="m-form__section m-form__section--first">
                              {{-- form repqter --}}
                              <div id="m_repeater_1">
                                 <div class="form-group   row" id="m_repeater_1">
                                    <div data-repeater-list="qc" class="qc_from">
                                       <?php
                                       foreach ($qcBOM_form as $key => $value) {

                                          if ($value->m_name == 'Printed Box' || $value->m_name == 'Printed Label') {
                                          } else {
                                       ?>


                                             <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                                <div class="col-md-1">
                                                   <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                      <i class="fa flaticon-plus"></i>
                                                   </a>
                                                </div>
                                                <div class="col-md-3">

                                                   <input type="text" value="{{$value->m_name}}" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                   <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-md-2">

                                                   <input type="text" value="{{$value->qty}}" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                   <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-md-2">
                                                   <select name="bom_cat" id="" class="form-control m-input">
                                                      <option value="">-SELECT-</option>
                                                      <?php
                                                      $data_arr = AyraHelp::getBOMItemCategory();
                                                      foreach ($data_arr as $dkey => $cvalue) {
                                                      ?>
                                                         <option <?php echo $cvalue->cat_name == $value->bom_cat ? 'selected' : '' ?> value="{{$cvalue->cat_name}}">{{$cvalue->cat_name}}</option>
                                                      <?php
                                                      }
                                                      ?>


                                                   </select>

                                                </div>
                                                <div class="col-md-2">
                                                   <?php
                                                   if ($value->bom_from == 'From Client') {
                                                   ?>
                                                      <div class="m-form__group form-group" style="margin-bottom:10px">
                                                         <div class="m-checkbox-inline">
                                                            <label class="m-checkbox">
                                                               <input type="checkbox" value="from_client" checked name="bom_from"> Client
                                                               <span></span>
                                                            </label>
                                                         </div>
                                                      </div>
                                                   <?php
                                                   } else {
                                                   ?>
                                                      <div class="m-form__group form-group" style="margin-bottom:10px">
                                                         <div class="m-checkbox-inline">
                                                            <label class="m-checkbox">
                                                               <input type="checkbox" value="from_client" name="bom_from"> Client
                                                               <span></span>
                                                            </label>
                                                         </div>
                                                      </div>
                                                   <?php
                                                   }
                                                   ?>


                                                </div>

                                                <div class="col-md-1">
                                                   <div data-repeater-delete="" style="margin-bottom:10px" class="btn btn-danger m-btn m-btn--icon">
                                                      <span>
                                                         <i class="la la-trash-o"></i>

                                                      </span>
                                                   </div>
                                                </div>
                                             </div>

                                          <?php
                                          }
                                          ?>



                                       <?php

                                       }


                                       ?>
                                    </div>

                                 </div>




                                 <div class="m-form__group form-group row">
                                    <label class="col-lg-2 col-form-label"></label>
                                    <div class="col-lg-4">
                                       <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                          <span>
                                             <i class="la la-plus"></i>
                                             <span>Add</span>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <br>

                              </div>
                              {{-- form repqter --}}
                           </div>


                        </div>
                        {{-- end of 6 --}}

                        {{-- end --}}
                     </div>




                     <!--begin:: Widgets/Audit Log-->

                     <!--begin::Preview-->
                     <div class="m-demo ajorderType">
                        <div class="m-demo__preview">
                           <div class="m-list-search">
                              <div class="m-list-search__results">

                                 <span class="m-list-search__result-category m-list-search__result-category--first">
                                    PACKAGING PROCESSES
                                 </span>
                                 <?php
                                 $i = 0;
                                 foreach ($qcPK_form as $key => $value) {
                                    $i++;
                                    // print_r($value->qc_yes);
                                    // print_r($value->qc_no);

                                 ?>
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">{{$value->qc_label}}</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" <?php echo $value->qc_yes == 'YES' ? 'checked' : '' ?> name="f_<?php echo $i ?>" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" <?php echo $value->qc_no == 'NO' ? 'checked' : '' ?> name="f_<?php echo $i ?>" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}

                                 <?php
                                 }
                                 ?>



                              </div>
                           </div>
                        </div>
                     </div>

                     <!--end::Preview-->





                     <!--end::Preview-->

                     <!--begin::Preview-->
                     <div class="m-demo ">
                        <div class="m-demo__preview">
                           <div class="m-list-search">
                              <div class="m-list-search__results">
                                 <span style="color:#035496" class="m-list-search__result-category m-list-search__result-category--first">
                                    Production Remarks
                                 </span>
                                 {{-- tag --}}
                                 <div class="row">
                                    <div class="col-md-12">
                                       <textarea name="production_rmk" class="form-control" id="" cols="1" rows="2">{{$qc_form->production_rmk}}</textarea>
                                    </div>
                                 </div>
                                 {{-- tag --}}
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--end::Preview-->
                     <!--begin::Preview-->
                     <div class="m-demo ">
                        <div class="m-demo__preview">
                           <div class="m-list-search">
                              <div class="m-list-search__results">
                                 <span style="color:#035496" class="m-list-search__result-category m-list-search__result-category--first">
                                    PACKAGING Remarks
                                 </span>
                                 {{-- tag --}}
                                 <div class="row">
                                    <div class="col-md-12">
                                       <textarea name="packeging_rmk" class="form-control" id="" cols="1" rows="2">{{$qc_form->packeging_rmk}}</textarea>
                                    </div>
                                 </div>
                                 {{-- tag --}}
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="m-demo " >
                        <div class="m-demo__preview" style="background:#CCC;">
                           <div class="m-list-search">
                              <div class="m-list-search__results">
                                 <span style="color:#035496" class="m-list-search__result-category m-list-search__result-category--first">
                                    Modification Remarks
                                 </span>
                                 {{-- tag --}}
                                 <div class="row">
                                    <div class="col-md-12">
                                       <textarea name="modificationRemarks" class="form-control" id="" cols="1" rows="2"></textarea>
                                    </div>
                                 </div>
                                 {{-- tag --}}
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--end::Preview-->


                  </div>

               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">

                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submit" class="btn btn-primary aj_updateorder_save">Update </button>

                           <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>

                        <?php
                        $process_data = DB::table('st_process_action')->where('process_id', 1)->where('ticket_id', $qc_form->form_id)->where('action_status', 1)->where('stage_id', 1)->first();

                        if ($process_data = null) {
                           if (Auth::user()->id == 87) {
                        ?>
                              <!-- <div class="col-lg-12">
                              <button type="submit" data-wizard-action="submit" class="btn btn-primary aj_updateorder_save">Update </button>
                             
                              <button type="reset" class="btn btn-secondary">Reset</button>
                           </div> -->

                           <?php
                           }
                        } else {
                           ?>
                           <!-- <div class="col-lg-12">
                              <button type="submit" data-wizard-action="submit" class="btn btn-primary aj_updateorder_save">Update </button>
                             
                              <button type="reset" class="btn btn-secondary">Reset</button>
                           </div> -->
                        <?php
                        }

                        ?>

                     </div>
                  </div>
               </div>
            </form>

         </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->





<!-- ajcode  -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_ChoosePOC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pakaging Catalog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- ajacode  -->
            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="600">

               <div class="m-content">
                  <input type="hidden" id="txtPOCBOMID">


                  <!--begin: Search Form -->
                  <div class="row m--margin-bottom-20">
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Type:</label>
                        <select name="type" id="poc_type" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php
                           $type_arr = AyraHelp::getBOMItemCategory();
                           foreach ($type_arr as $key => $rowData) {


                           ?>
                              <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


                           <?php


                           }
                           ?>
                        </select>

                     </div>
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Material:</label>

                        <select name="material" id="poc_material" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php
                           $type_arr = AyraHelp::getBOMItemMaterial();
                           foreach ($type_arr as $key => $rowData) {

                           ?>
                              <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


                           <?php

                           }
                           ?>
                        </select>
                     </div>
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Size:</label>

                        <select name="size" id="poc_size" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php
                           $type_arr = AyraHelp::getBOMItemSize();
                           foreach ($type_arr as $key => $rowData) {

                           ?>
                              <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


                           <?php

                           }
                           ?>
                        </select>
                     </div>
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Color:</label>
                        <select name="color" id="poc_color" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php
                           $type_arr = AyraHelp::getBOMItemColor();
                           foreach ($type_arr as $key => $rowData) {

                           ?>
                              <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


                           <?php

                           }
                           ?>
                        </select>

                     </div>
                  </div>
                  <div class="row m--margin-bottom-20">
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Shape:</label>

                        <select name="sape" id="poc_sape" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php
                           $type_arr = AyraHelp::getBOMItemSape();
                           foreach ($type_arr as $key => $rowData) {

                           ?>
                              <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


                           <?php

                           }
                           ?>
                        </select>
                     </div>
                     <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <label>Name:</label>
                        <input type="text" id="poc_name" name="name" class="form-control">

                        <span class="m-form__help"></span>
                     </div>

                     <div class="col-lg-6 m--margin-bottom-10-tablet-and-mobile">
                        <button style="margin-top:26px;" class="btn btn-brand m-btn m-btn--icon" id="m_search_POC">
                           <span>
                              <i class="la la-search"></i>
                              <span>Search</span>
                           </span>
                        </button>
                        <button style="margin-top:26px;" class="btn btn-secondary m-btn m-btn--icon" id="m_reset_POC">
                           <span>
                              <i class="la la-close"></i>
                              <span>Reset</span>
                           </span>
                        </button>
                     </div>
                  </div>
                  <div class="m-separator m-separator--md m-separator--dashed"></div>



                  <!-- ajcodefornewlayout -->
                  <!--Begin::Section-->
                  <style>
                     .m-widget19 .m-widget19__content {
                        margin-bottom: -1rem;
                     }
                  </style>
                  <div class="row ajrowFilter">


                     <?php
                     $datas = AyraHelp::getAllPOCData();
                     if (isset($datas)) {


                        foreach ($datas as $key => $rowData) {
                           $img = asset('/local/public/uploads/photos/') . "/" . $rowData->img_1;;
                           $poc_type_arr = AyraHelp::getBOMItemCategoryID($rowData->poc_type);
                           $poc_material_arr = AyraHelp::getBOMItemMaterialID($rowData->poc_material);
                           $poc_size_arr = AyraHelp::getBOMItemSizeID($rowData->poc_size);
                           $poc_color_arr = AyraHelp::getBOMItemColorID($rowData->poc_color);
                           $poc_sape_arr = AyraHelp::getBOMItemSapeID($rowData->poc_sape);





                     ?>


                           <div class="col-md-3" id="ajFileyrt" style="border:1px dotted #f1f1; background:#f4f6f6; padding:10px;">
                              <!--begin:: Widgets/Blog-->
                              <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force">
                                 <div class="m-portlet__head m-portlet__head--fit">
                                    <div class="m-portlet__head-caption">
                                       <div class="m-portlet__head-action">

                                       </div>
                                    </div>
                                 </div>

                                 <div class="m-portlet__body">
                                    <div class="m-widget19">
                                       <a href="javascript::void(0)" onclick="showMeSlide({{$rowData->id}})">
                                          <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px;border:1px solid #f1f1f1; padding:5px">
                                             <img src="{{$img}}" alt="" style="display: block;width: 100%;height: 80%">

                                          </div>
                                       </a>


                                       <div class="m-widget19__content">
                                          <!-- data -->
                                          <div class="m-widget29">

                                             <div class="m-widget19__info" style="margin-top:10px">
                                                <span class="m-widget19__username">

                                                   <b>{{$rowData->poc_code}}</b>

                                                </span><br>
                                                <span class="m-widget19__time">
                                                   {{$poc_type_arr->cat_name}},{{$poc_material_arr->cat_name}},<br>{{$poc_size_arr->cat_name}},<br>{{$poc_color_arr->cat_name}}
                                                   , {{$poc_sape_arr->cat_name}}
                                                </span>

                                             </div>
                                             <a href="javascript::void(0)" id="{{$rowData->poc_code}}:{{$rowData->poc_name}}" class="btnSelectBOM btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                                                <span>
                                                   <i class="fa flaticon-cart"></i>
                                                   <span>Add to Order</span>
                                                </span>
                                             </a>







                                          </div>
                                          <!-- data -->
                                       </div>

                                    </div>
                                 </div>
                              </div>
                           </div>

                     <?php
                        }
                     }
                     ?>


                     {{-- ajaycode  --}}
                     <!-- this will hold all the data -->
                     <!-- loading image -->
                     <!-- <div id="loader_image"><img src="https://www.tankfacts.com/ajaxloader/340.gif" alt="" width="24" height="24"> Loading...please wait</div>
						
							<div id="loader_message"></div> -->
                     {{-- ajaycode  --}}

                  </div>

                  <!--End::Section-->

                  <!-- ajcodefornewlayout -->




               </div>
            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
         </div>
      </div>
   </div>
</div>

<!-- ajacode  -->

</div>
</div>

<!--end::Modal-->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_SlideShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- ajacode -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
               </ol>
               <div class="carousel-inner ajslideMe">

               </div>
               <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </a>
            </div>


            <!-- ajacode -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" id="" class="btn btn-primary btnSelectBOM">Select</button> -->
         </div>
      </div>
   </div>
</div>
<!--end::Modal-->
<!-- ajcode  -->