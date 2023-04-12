<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  QC BULK EDIT FORM
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

      // echo "<pre>";
      // print_r($qc_form->production_rmk);
      // print_r($qc_form->packeging_rmk);





      ?>

      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_edit_qcform" method="post" action="{{ route('updateQCdataNewWaysBULK')}}">
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
                                    <input type="radio" <?php echo $qc_form->order_type == 'Bulk' ? 'checked' : '' ?> value="2" id="order_type" name="order_type"> Bulk
                                    <span></span>
                                 </label>
                                 <label style="visibility:hidden" class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                    <input type="radio" <?php echo $qc_form->order_type == 'Private Label' ? 'checked' : '' ?> value="1" name="order_type"> Private Label
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

                  <?php
                  //echo $qc_form->order_repeat;
                  // die;
                  ?>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label"> Brand:</label>
                           <input type="text" class="form-control m-input" id="client_address" name="brand" placeholder="" value="<?php echo $qc_form->brand_name ?>">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label>Repeat Order:</label>
                           <div class="m-radio-inline">
                              <label class="m-radio m-radio">
                                 <input type="radio" name="order_repeat" <?php echo $qc_form->order_repeat == '2' ? 'checked' : '' ?> value="2"> YES
                                 <span></span>
                              </label>
                              <label class="m-radio m-radio">
                                 <input type="radio" name="order_repeat" <?php echo $qc_form->order_repeat == '1' ? 'checked' : '' ?> value="1"> NO
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
                        <div class="col-lg-2 m-form__group-sub <?php echo $ajstyle ?> ">
                           <label class="form-control-label">Prev Order NO.:</label>
                           <input type="text" class="form-control m-input" name="pre_orderno" placeholder="Prev Order No" value="{{$qc_form->pre_order_id}}">
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
                           <input type="text" style="background:burlywood; border:1px solid #035496" class="form-control m-input" name="conv_rate" placeholder="">
                        </div>
                     </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                     {{-- Welcome bulk order  --}}
                     <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                           <div class="col-lg-4 m-form__group-sub">
                              <!-- <label class="form-control-label"> FM No./S. No:</label> -->
                              <label class="form-control-label"> Sample Code:</label>
                              <!-- <input type="text" title="FM No./Sample. No:" value="{{$qc_form->item_fm_sample_no}}" class="form-control m-input" id="item_fm_sample_no" name="item_fm_sample_no_bulk" placeholder="FM No./Sample No"> -->
                              <select class="form-control m-input"  id="item_fm_sample_no" name="item_fm_sample_no_bulk">
                              <option value="">SELECT</option>
                                 <?php
                                 foreach (AyraHelp::getSampleIDByUserID(Auth::user()->id) as $key => $row) {

                                    if($row->sample_code==$qc_form->item_fm_sample_no){
                                       ?>
                                       <option selected value="{{$row->sample_code}}">{{$row->sample_code}}</option>
                                    <?php
                                    }else{
                                       ?>
                                       <option value="{{$row->sample_code}}">{{$row->sample_code}}</option>
                                    <?php
                                    }
                                
                                 }
                                 ?>
                              </select>

                           </div>

                           <div class="col-lg-6 m-form__group-sub">
                              <div class="m-form__group form-group">
                                 <label for="">Bulk Order Type</label>
                                 <div class="m-radio-inline">
                                    <label class="m-radio">
                                       <input type="radio" <?php echo $qc_form->bulkOrderTypeV1==1 ? "checked":"" ?> name="bulkOrderTypeV1" value="1"> Oils
                                       <span></span>
                                    </label>
                                    <label class="m-radio">
                                       <input type="radio" <?php echo $qc_form->bulkOrderTypeV1==2 ? "checked":"" ?> name="bulkOrderTypeV1" value="2"> Cosmetics
                                       <span></span>
                                    </label>
                                 </div>
                                 <span class="m-form__help">Please select Bulk order Type</span>
                              </div>

                              <!-- <label class="form-control-label">Bulk Order Type </label>
                              <select class="form-control  m-input" id="bulkOrderType" name="bulkOrderType">
                                 <option value="1">OILS</option>
                                 <option value="2">Cosmetic</option>
                              </select> -->
                           </div>

                        </div>
                     </div>

                     <div class="m-form__section m-form__section--first">
                        {{-- form repqter --}}
                        <div id="m_repeater_1">
                           <div class="form-group   row" id="m_repeater_1">
                              <div data-repeater-list="qcBulkOrder" class="qc_from">
                                 <?php
                                 foreach ($qcBULK_arr as $key => $rowData) {
                                    // echo "<pre>";

                                    // print_r($rowData);

                                 ?>

                                    <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                       <div class="col-md-3">


                                          <input type="text" name="bulk_material_name" value="{{$rowData->item_name}}" class="form-control m-input" placeholder="Material Name">
                                          <span class="m-form__help"></span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="number" name="bulkItem_qty" value="{{$rowData->qty}}" class="form-control m-input" placeholder="Quantity">
                                          <span class="m-form__help"></span>
                                       </div>
                                       <div class="col-md-2" style="width: 70px;">
                                          <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">
                                             <?php
                                             if ($rowData->item_size == 'Kg') {
                                             ?>
                                                <option value="L">L</option>
                                                <option selected value="Kg">Kg</option>
                                                <option value="PCS">PCS</option>
                                             <?php
                                             }
                                             if ($rowData->item_size == 'L') {
                                             ?>
                                                <option selected value="L">L</option>
                                                <option value="Kg">Kg</option>
                                                <option value="PCS">PCS</option>
                                             <?php

                                             }
                                             if ($rowData->item_size == 'PCS') {
                                             ?>
                                                <option value="L">L</option>
                                                <option value="Kg">Kg</option>
                                                <option selected value="PCS">PCS</option>
                                             <?php

                                             }
                                             ?>

                                          </select>
                                          <span class="m-form__help"></span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="number" name="bulk_rate" class="form-control m-input" value="{{$rowData->rate}}" placeholder="Rate">
                                          <span class="m-form__help"></span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="text" name="bulk_packing" class="form-control m-input" value="{{$rowData->packing}}" placeholder="Packing">
                                          <span class="m-form__help"></span>
                                       </div>

                                       <div class="col-md-1">
                                          <div data-repeater-delete="" style="margin-bottom: 16px;margin-left: -27px;" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                                             <span>
                                                <i class="la la-trash-o"></i>
                                                <span>Del</span>
                                             </span>
                                          </div>
                                       </div>
                                    </div>


                                 <?php
                                 }


                                 ?>


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
                                          <textarea name="production_rmk_bulk" class="form-control" id="" cols="1" rows="2">
                                          {{$qc_form->production_rmk}}
                                          </textarea>
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
                                          <textarea name="packeging_rmk_bulk" class="form-control" id="" cols="1" rows="2">
                                          {{$qc_form->packeging_rmk}}
                                          </textarea>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--end::Preview-->
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


                     </div>















                  </div>

               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">

                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submit" class="btn btn-primary aj_updateorder_save_bulk">Update Bulk Order </button>

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