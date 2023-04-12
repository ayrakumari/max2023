<!-- main  -->
<div class="m-content">
   <!-- datalist -->

   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Order Form
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="javascript::void(0)" id="btnNewOrder" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-plus"></i>
                        <span>NEW ORDER </span>
                     </span>
                  </a>
               </li>

               <li class="m-portlet__nav-item">
                  <a href="{{ route('qcform.list')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-arrow-left"></i>
                        <span>Orders List </span>
                     </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <?php

      use App\Helpers\AyraHelp;

      $order_arr = AyraHelp::getOrderCODE();
      $order_arrIndex = AyraHelp::getOrderCODEIndex();
      $frsh = "fresh";
      ?>
      <style>
         .bulkOrderArea {
            display: none;
         }
      </style>

      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_qcform" method="post" action="{{ route('saveQCdata')}}">
               @csrf
               <input type="hidden" name="txtOrderIndex" id="txtOrderIndex">
               <input type="hidden" name="txtOrderTypeNew" id="txtOrderTypeNew">
               <input type="hidden" name="orderEntry" id="orderEntry" value="{{ $frsh }}">

               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <input type="hidden" readonly class="form-control m-input" id="order_id" name="order_id" placeholder="Order No.">


                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Select Client:</label>
                           <select class="form-control m-select2 client_name_qcform" id="m_select2_1" name="client_id">
                              <option>--SELECT CLIENT--</option>
                              <?php
                              $useID = Request::segment(3);
                              if (isset($useID)) {
                              ?>
                                 @foreach (AyraHelp::getClientByadded($useID) as $user)
                                 <option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
                                 @endforeach

                              <?php
                              } else {
                              ?>
                                 @foreach (AyraHelp::getClientByadded(Auth::user()->id) as $user)
                                 <option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
                                 @endforeach
                              <?php
                              }
                              ?>


                           </select>
                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">TARGET :</label>
                           <div class="input-group">
                              <input type="text" name="due_date" class="form-control" id="m_datepicker_1" readonly placeholder="Select date" />
                           </div>
                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">COMMITTED :</label>
                           <div class="input-group">
                              <input type="text" name="commited_date" class="form-control" id="m_datepicker_1" readonly placeholder="Select date" />
                           </div>
                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <div class="m-form__group form-group">
                              <label for="">Order</label>
                              <div class="m-checkbox-inline">
                                 <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                    <input type="radio" value="1" name="order_type"> Private
                                    <span></span>
                                 </label>
                                 <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                    <input type="radio" value="2" id="order_type" name="order_type"> Bulk
                                    <span></span>
                                 </label>

                              </div>

                           </div>
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">* Order Type:</label>
                           <div class="m-checkbox-inline">
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" value="1" name="order_type_v1"> New
                                 <span></span>
                              </label>
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" value="2" name="order_type_v1"> Repeat
                                 <span></span>
                              </label>
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                 <input type="radio" value="3" name="order_type_v1"> Product Addition
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
                           <input type="text" readonly class="form-control m-input" id="client_address" name="brand" placeholder="">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label>Repeat Order:</label>
                           <div class="m-radio-inline">
                              <label class="m-radio m-radio">
                                 <input type="radio" name="order_repeat" value="2"> YES
                                 <span></span>
                              </label>
                              <label class="m-radio m-radio">
                                 <input type="radio" name="order_repeat" checked value="1"> NO
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="col-lg-2 m-form__group-sub ajorderhide">
                           <label class="form-control-label">Prev Order NO.:</label>
                           <input type="text" class="form-control m-input" name="pre_orderno" placeholder="Prev Order No">
                        </div>
                        <div class="col-lg-2 m-form__group-sub ">
                           <label class="form-control-label">Currency:</label>
                           <select class="form-control currency_order" name="currency" id="currency">
                              <option value="INR">INR</option>
                              <option value="USD">USD</option>
                           </select>

                        </div>
                        <div class="col-lg-2 m-form__group-sub ajorderhiderate">
                           <label class="form-control-label">Conversion Rate:</label>
                           <input type="text" style="background:burlywood; border:1px solid #035496" class="form-control m-input" name="conv_rate" placeholder="">
                        </div>
                     </div>
                     
                  </div>
                  


                  <div class="bulkOrderArea">
                     {{-- Welcome bulk order  --}}
                     <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                           <div class="col-lg-4 m-form__group-sub">
                              <label class="form-control-label">Sample ID.:</label>
                              <!-- <label class="form-control-label"> FM No./S. No:</label> -->
                              <!-- <input type="text" title="FM No./Sample. No:" class="form-control m-input" id="item_fm_sample_no" name="item_fm_sample_no_bulk" placeholder="FM No./Sample No"> -->

                              <select class="form-control m-select2 m-input orderSampleIDView" id="item_fm_sample_bulk_N" name="item_fm_sample_bulk_N">
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
                           </div>
                           <div class="col-lg-6 m-form__group-sub">
                              <div class="m-form__group form-group">
                                 <label for="">Bulk Order Type</label>
                                 <div class="m-radio-inline">
                                    <label class="m-radio">
                                       <input type="radio" name="bulkOrderTypeV1" value="1"> Oils
                                       <span></span>
                                    </label>
                                    <label class="m-radio">
                                       <input type="radio" name="bulkOrderTypeV1" value="2"> Cosmetics
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
                           <div class="viewitemSelect">

                           </div>
                        </div>
                     </div>

                     <div class="m-form__section m-form__section--first">
                        {{-- form repqter --}}
                        <div id="m_repeater_1">
                           <div class="form-group   row" id="m_repeater_1">
                              <div data-repeater-list="qcBulkOrder" class="qc_from">

                                 <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                    <div class="col-md-3">


                                       <input type="text" name="bulk_material_name" class="form-control m-input" placeholder="Material Name">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulkItem_qty" class="form-control m-input" placeholder="Quantity">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2" style="width: 70px;">
                                       <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">
                                          <option value="L">L</option>
                                          <option value="Kg">Kg</option>
                                          <option value="PCS">PCS</option>
                                       </select>
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulk_rate" class="form-control m-input" placeholder="Rate">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulk_packing" class="form-control m-input" placeholder="Packing">
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
                                 <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                    <div class="col-md-3">
                                       <input type="text" name="bulk_material_name" class="form-control m-input" placeholder="Material Name">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulkItem_qty" class="form-control m-input" placeholder="Quantity">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">

                                       </select>
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulk_rate" class="form-control m-input" placeholder="Rate">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulk_packing" class="form-control m-input" placeholder="Packing">
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
                                 <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                    <div class="col-md-3">
                                       <input type="text" name="bulk_material_name" class="form-control m-input" placeholder="Material Name">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulkItem_qty" class="form-control m-input" placeholder="Quantity">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">

                                       </select>
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulk_rate" class="form-control m-input" placeholder="Rate">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulk_packing" class="form-control m-input" placeholder="Packing">
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
                                 <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                    <div class="col-md-3">
                                       <input type="text" name="bulk_material_name" class="form-control m-input" placeholder="Material Name">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulkItem_qty" class="form-control m-input" placeholder="Quantity">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">

                                       </select>
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulk_rate" class="form-control m-input" placeholder="Rate">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulk_packing" class="form-control m-input" placeholder="Packing">
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
                                 <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                    <div class="col-md-3">
                                       <input type="text" name="bulk_material_name" class="form-control m-input" placeholder="Material Name">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulkItem_qty" class="form-control m-input" placeholder="Quantity">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <select name="bulk_sizeUnit" id="bulk_sizeUnit" class="form-control m-input item_size_unitBULK">

                                       </select>
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="number" name="bulk_rate" class="form-control m-input" placeholder="Rate">
                                       <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="text" name="bulk_packing" class="form-control m-input" placeholder="Packing">
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
                                       <textarea name="production_rmk_bulk" class="form-control" id="" cols="1" rows="2"></textarea>
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
                                       <textarea name="packeging_rmk_bulk" class="form-control" id="" cols="1" rows="2"></textarea>
                                    </div>
                                 </div>
                                 {{-- tag --}}
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--end::Preview-->
                     {{-- Welcome bulk order  --}}


                  </div>
                  <div class="PrivateOrder">


                     <div id="formLayoutAJITEMS">
                        <table class="table m-table m-table--head-bg-brand ajitemTable">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Item Name </th>
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
                                 <input type="text" class="form-control m-input" id="item_name" name="item_name" placeholder="Enter Item Name">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label"> Size:</label>
                                 <input type="number" class="form-control m-input" id="item_size" name="item_size" placeholder="Size">


                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">Size Unit</label>
                                 <select name="item_size_unit" id="item_size_unit" class="form-control m-input">

                                 </select>



                              </div>
                              <div class="col-lg-1 m-form__group-sub">
                                 <label class="form-control-label"> QTY:</label>
                                 <input type="number" style="width:90px;" class="form-control m-input" id="item_qty" name="item_qty" placeholder="QTY">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label"> QTY Unit:</label>
                                 <select style="width:80px;" name="item_qty_unit" id="item_qty_unit" class="form-control m-input">


                                 </select>


                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label"> Sample ID::</label>
                                 <!-- <input type="text" title="FM No./Sample. No:" class="form-control m-input" id="item_fm_sample_no" name="item_fm_sample_no" placeholder="FM No./Sample No"> -->
                                 <select class="form-control m-input orderSampleIDView" id="item_fm_sample_no_bulk_N" name="item_fm_sample_no_bulk_N">
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
                                    <option value="Standard">Standard</option>
                                    <option value="Regular">Regular</option>

                                 </select>


                              </div>
                           </div>
                           <div class="viewitemSelect">

                           </div>
                        </div>

                        <!-- price by part  -->
                        <div style="display:block;" class="m-form__section m-form__section--first" style="background-color: #c1c1c1;">
                           <div class="form-group m-form__group row">
                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Row Material Price per Kg" class="form-control-label">RM Price/Kg:</label>
                                 <input title="Enter Row Material Price per Kg" type="number" class="form-control m-input" id="item_RM_Price" name="item_RM_Price" placeholder="">
                              </div>

                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Price of Bottle/Jar/Cap" class="form-control-label">Bottle/Cap/Pump:</label>
                                 <input title="Enter Price of Bottle/Jar/Cap" type="number" class="form-control m-input" id="item_BCJ_Price" name="item_BCJ_Price" placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label title="Price of Label" class="form-control-label"> Label Price:</label>
                                 <input title="Enter Price of Label" type="number" class="form-control m-input" id="item_Label_Price" name="item_Label_Price" placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">M.Carton Price:</label>
                                 <input title="Enter Material Carton Price" type="number" class="form-control m-input" id="item_Material_Price" name="item_Material_Price" placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">L & C Price:</label>
                                 <input title="Enter Labour & Conversion Price" type="number" class="form-control m-input" id="item_LabourConversion_Price" name="item_LabourConversion_Price" placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label">Margin:</label>
                                 <input title="Enter Margin" type="number" class="form-control m-input" id="item_Margin_Price" name="item_Margin_Price" placeholder="">
                              </div>

                           </div>
                        </div>
                        <!-- price by part  -->
                        <div class="m-form__section m-form__section--first">
                           <div class="form-group m-form__group row">
                              <div class="col-lg-3 m-form__group-sub">
                                 <label class="form-control-label"> Selling Price Per(₹):</label>
                                 <input style="background-color:#c1c1c1" type="number" readonly class="form-control m-input" id="item_selling_price" name="item_selling_price" placeholder="">
                              </div>
                              <div class="col-lg-2 m-form__group-sub">
                                 <label class="form-control-label"> Unit:</label>
                                 <select name="item_selling_UNIT" id="item_selling_UNIT" class="form-control m-input">
                                    <option value="pcs">Pcs</option>
                                    <option value="Kg">Kg</option>
                                    <option value="ML">ml</option>
                                    <option value="GM">gm</option>
                                 </select>


                              </div>
                              <div class="col-lg-3 m-form__group-sub">
                                 <label class="form-control-label"> Order Value(₹):</label>
                                 <input type="text" disabled style="background:darkslateblue;color:floralwhite;font-weight:800" class="form-control m-input" id="order_value" name="order_value" placeholder="">
                              </div>
                              <div class="col-lg-4 m-form__group-sub">
                                 <div class="m-form__group form-group">
                                    <label for="">Order For:</label>
                                    <div class="m-checkbox-inline">
                                       <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                          <input type="radio" value="1" name="order_for" checked> Domestic
                                          <span></span>
                                       </label>
                                       <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                          <input type="radio" value="2" id="order_for" name="order_for"> Export
                                          <span></span>
                                       </label>

                                    </div>

                                 </div>

                              </div>

                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xl-5">
                              <div class="m-form__section m-form__section--first">
                                 <div class="form-group m-form__group row">
                                    <div class="col-lg-6 m-form__group-sub">
                                       <label class="form-control-label"> Fragrance</label>
                                       <input type="text" class="form-control m-input" id="order_fragrance" name="order_fragrance" placeholder="Fragrance">
                                    </div>

                                    <div class="col-lg-6 m-form__group-sub">
                                       <label class="form-control-label">Order For</label>
                                       <select name="order_crated_by" id="order_crated_by" class="form-control">
                                          <?php
                                          $useID = Request::segment(3);
                                          if (isset($useID)) {

                                             $udataArr = AyraHelp::getUser($useID);
                                          ?>
                                             <option value="{{$udataArr->id}}"> {{$udataArr->name}} </option>
                                          <?php

                                          } else {

                                             $user = auth()->user();
                                             $userRoles = $user->getRoleNames();
                                             $user_role = $userRoles[0];
                                          ?>

                                             <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                             @if ($user_role =="Admin" || $user_role =="Staff")
                                             @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                             <option value="{{$user->id}}">{{$user->name}}</option>

                                             @endforeach
                                             <!-- <option value="102">DEEPIKA JOSHI</option> -->
                                             @else

                                             @endif
                                          <?php

                                          }

                                          ?>

                                       </select>

                                    </div>
                                 </div>
                              </div>



                              {{-- aa --}}

                           </div>
                           <div class="col-md-4">
                              <div class="form-group m-form__group">
                                 <label for="exampleInputEmail1">Packaging Image</label>
                                 <div></div>
                                 <div class="custom-file">
                                    <input type="file" name="file" id="inputGroupFile01" class="custom-file-input">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div id='img_contain'>
                                 <img id="blah" width="180" height="150" align='middle' src="http://www.clker.com/cliparts/c/W/h/n/P/W/generic-image-file-icon-hi.png" alt="your image" title='' />
                              </div>
                           </div>

                        </div>

                        {{-- ajaja layout chnage --}}
                        <br>
                        <div class="row">
                           <div class="col-xl-12">
                              <div class="row">
                                 <div class="col-xl-6">
                                    <div class="m-form__section m-form__section--first">
                                       <div class="form-group m-form__group row">
                                          <div class="col-lg-612m-form__group-sub">
                                             <div class="m-form__group form-group">
                                                <label for="">Printed Box</label>
                                                <div class="m-radio-inline">
                                                   <label class="m-radio">
                                                      <input type="radio" name="printed_box" value="Order"> Order
                                                      <span></span>
                                                   </label>
                                                   <label class="m-radio">
                                                      <input type="radio" name="printed_box" value="From Client">From Client
                                                      <span></span>
                                                   </label>
                                                   <label class="m-radio">
                                                      <input type="radio" checked name="printed_box" value="N/A"> N/A
                                                      <span></span>
                                                   </label>
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
                                                   <label class="m-radio">
                                                      <input type="radio" name="printed_label" value="Order"> Order
                                                      <span></span>
                                                   </label>
                                                   <label class="m-radio">
                                                      <input type="radio" name="printed_label" value="From Client">From Client
                                                      <span></span>
                                                   </label>
                                                   <label class="m-radio">
                                                      <input type="radio" checked name="printed_label" value="N/A"> N/A
                                                      <span></span>
                                                   </label>
                                                </div>
                                                <span class="m-form__help"></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                 </div>
                                 
                                 <!-- aja -->
                                
                                 <!-- aja -->
                                 
                              </div>
                              <div class="col-lg-12 m-form__group-sub">
                           <label class="form-control-label">* Artwork Approval:</label>
                           <div class="m-checkbox">
                              <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-primary">
                                 <input type="checkbox" value="1" name="artwork_approval_status"> <b>PACKAGING HAS BEEN FINALIZED AND CAN BE ORDERED BEFORE ARTWORK APPROVAL.</b>

                                 <span></span>
                              </label>

                           </div>
                        </div>
                              <br>



                              <div class="m-form__section m-form__section--first">
                                 {{-- form repqter --}}
                                 <div id="m_repeater_2">
                                    <div class="form-group   row" id="m_repeater_1">
                                       <div data-repeater-list="qc" class="qc_from">

                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>

                                             <div class="col-md-3">

                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from"> Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>

                                          </div>
                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from">Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>
                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>

                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from">Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>
                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from"> Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>

                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from"> Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>

                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from"> Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>


                                          <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">
                                             <div class="col-md-1">
                                                <a href="javascript::void(0)" name="addMoreJS" style="margin-top: -21px;" class="ajPICPOC btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
                                                   <i class="fa flaticon-plus"></i>
                                                </a>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="text" name="bom" class="form-control m-input" placeholder="Bill of Material Name">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <input type="text" name="bom_qty" class="form-control m-input" placeholder="Quantity">
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <select name="bom_cat" id="" class="form-control m-input">
                                                   <option value="">-SELECT-</option>
                                                   <?php
                                                   $data_arr = AyraHelp::getBOMItemCategory();
                                                   foreach ($data_arr as $key => $value) {
                                                   ?>
                                                      <option value="{{$value->cat_name}}">{{$value->cat_name}}</option>
                                                   <?php
                                                   }
                                                   ?>


                                                </select>
                                                <span class="m-form__help"></span>
                                             </div>
                                             <div class="col-md-2">
                                                <div class="m-form__group form-group" style="margin-bottom:15px">
                                                   <div class="m-checkbox-inline">
                                                      <label class="m-checkbox">
                                                         <input type="checkbox" value="from_client" name="bom_from">Client
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-1">
                                                <div data-repeater-delete="" style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
                                                   <span>
                                                      <i class="la la-trash-o"></i>
                                                      <span></span>
                                                   </span>
                                                </div>
                                             </div>
                                          </div>








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


                        </div>
                        {{-- ajaja layout chnage --}}

                        <!-- ajcode for shrink and seal and plug -->
                        <div class="row" style="display:none">
                           <div class="col-md-4">

                              <div class="m-form__group form-group">
                                 <div class="m-checkbox-inline">
                                    <label class="m-checkbox">
                                       <input type="checkbox" value='SHRINK' name="txtShrink"> SHRINK
                                       <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                       <input type="checkbox" value='SEAL/PLUG' name="txtSealPlug"> SEAL/PLUG
                                       <span></span>
                                    </label>

                                 </div>
                                 <span class="m-form__help"></span>
                              </div>

                           </div>
                           <div class="col-md-4">
                              <div class="form-group m-form__group">
                                 <label for="exampleTextarea">OTHERS</label>
                                 <textarea class="form-control m-input" id="exampleTextarea" rows="2" name="txtOthers_1"></textarea>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group m-form__group">
                                 <label for="exampleTextarea">OTHERS</label>
                                 <textarea class="form-control m-input" id="exampleTextarea" rows="2" name="txtOthers_2"></textarea>
                              </div>
                           </div>

                        </div>
                        <!-- ajcode for shrink and seal and plug -->




                        <!--begin:: Widgets/Audit Log-->

                        <!--begin::Preview-->
                        
                        

                        <div class="m-demo ajorderType">
                           <div class="m-demo__preview">
                              <div class="m-list-search">
                                 <div class="m-list-search__results">

                                    <span class="m-list-search__result-category m-list-search__result-category--first">
                                       PACKAGING PROCESSES
                                    </span>

                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">FILLING</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_1" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_1" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">SEAL</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_2" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_2" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">CAPPING</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_3" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_3" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text"> LABEL</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_4" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_4" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text"> CODING ON LABEL</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_5" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_5" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text"> BOXING</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_6" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_6" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">CODING ON BOX</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_7" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_7" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text"> SHRINK WRAP</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_8" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_8" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {{-- tag --}}

                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <a href="javascript::void(0)" class="m-list-search__result-item">
                                             <span class="m-list-search__result-item-icon"><i class="flaticon-interface-3 m--font-primary"></i></span>
                                             <span class="m-list-search__result-item-text">CARTONIZE</span>
                                          </a>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="m-form__group form-group">
                                             <div class="m-checkbox-inline">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_9" value="YES"> YES
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <label class="m-checkbox">
                                                         <input type="radio" name="f_9" value="NO"> NO
                                                         <span></span>
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
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
                                       Production Remarks
                                    </span>
                                    {{-- tag --}}
                                    <div class="row">
                                       <div class="col-md-12">
                                          <textarea name="production_rmk" class="form-control" id="" cols="1" rows="2"></textarea>
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
                                          <textarea name="packeging_rmk" class="form-control" id="" cols="1" rows="2"></textarea>
                                       </div>
                                    </div>
                                    {{-- tag --}}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--end::Preview-->

                     </div>
                     <!--end of private la-->


                  </div>

               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">
                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submit" class="btn btn-primary aj_addmore_save">Save</button>
                           <button type="button" class="btn btn-primary aj_addmore">Add More</button>
                           <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
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



<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_gst_addrees_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Client Updatation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form>
               <input type="hidden" id="txtCID">
               <div class="form-group">
                  <label for="recipient-name" class="form-control-label">GST NO.:</label>
                  <input type="text" class="form-control" id="txtClientGST">
               </div>
               <div class="form-group">
                  <label for="message-text" class="form-control-label">Address:</label>
                  <textarea class="form-control" id="txtClientAddress"></textarea>
               </div>
            </form>
         </div>
         <div class="modal-footer">

            <button type="button" class="btn btn-primary" id="btnSaveGSTAddess">Save Changes</button>
         </div>
      </div>
   </div>
</div>

<!--end::Modal-->