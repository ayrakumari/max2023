<!-- main  -->
<div class="m-content">
   <!-- datalist -->

   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Edit Ingredient 
                 
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">

               <li class="m-portlet__nav-item">
                  <a href="{{ route('rnd.ingrednetBrandList')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-arrow-left"></i>
                        <span>Ingredient Brand List </span>
                     </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>

      <?php

      //print_r($data);

      ?>
      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
            <form data-redirect="Ingredients" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_ingredeint" method="post" action="{{ route('updateIngredientdata')}}">
               @csrf
               <?php
               $car_data_arr = AyraHelp::getIngredientCategory();
               $brand_data_arr = AyraHelp::getIngredientBrand();
               $supplier_data_arr = AyraHelp::getIngredientSupplier();

               ?>
               <input type="hidden" name="txtInGID" value="{{$data->id}}">
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">* Name:</label>
                           <input type="text" class="form-control m-input" id="ingb_name" value="{{$data->name}}" name="ingb_name" placeholder="">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Category:</label>

                           <select name="ingb_cat" id="ingb_cat" class="form-control m-input">
                              <option value="">--SELECT--</option>
                              <?php
                              foreach ($car_data_arr as $key => $value) {
                                 if ($data->cat_id == $value->id) {
                              ?>
                                    <option selected value="{{$value->id}}">{{$value->category_name}}</option>

                                 <?php
                                 } else {
                                 ?>
                                    <option value="{{$value->id}}">{{$value->category_name}}</option>

                              <?php
                                 }
                              }
                              ?>
                           </select>

                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Brand:</label>
                           <select name="ingb_brand" id="ingb_brand" class="form-control m-input">
                              <option value="">--SELECT--</option>
                              <?php
                              foreach ($brand_data_arr as $key => $value) {
                                 if ($data->ing_brand_name == $value->id) {
                              ?>
                                    <option selected value="{{$value->id}}">{{$value->brand_name}}</option>
                                 <?php

                                 } else {
                                 ?>
                                    <option value="{{$value->id}}">{{$value->brand_name}}</option>
                              <?php
                                 }
                              }
                              ?>
                           </select>
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">*Other Name:</label>
                           <input type="text"  value="{{$data->ingb_other_name}}" class="form-control m-input" id="ingb_other_name" name="ingb_other_name" placeholder="">
                        </div>


                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-12 m-form__group-sub">
                           <!-- <label class="form-control-label">* Price Per Kg:</label> -->
                           <!-- <input type="text" value ="{{$data->ppkg}}"   class="form-control m-input" id="ingb_ppkg" name="ingb_ppkg" placeholder=""> -->


                           <div id="m_repeater_3">
                              <div class="form-group  m-form__group row">

                                 <div data-repeater-list="sizeRateArr" class="col-lg-12">
                                    <?php
                                    $RndSizePriceArr = json_decode($data->size_price);
                                    
                                    foreach ($RndSizePriceArr as $key => $value) {
                                       
                                    ?>
                                       <div data-repeater-item class="row m--margin-bottom-10">

                                          <div class="col-lg-6">
                                             <div class="input-group">
                                                <input type="number" value="{{$value->sizeData}}" class="form-control m-input" name="rndSizeWith" placeholder="Size">
                                                <div class="input-group-append">
                                                   <span class="input-group-text">KG</span>
                                                </div>
                                             </div>
                                          </div>



                                          <div class="col-lg-6">
                                             <div class="input-group">
                                                <div class="input-group-append">
                                                   <span class="input-group-text"><i class="fa fa-rupee-sign"></i></span>
                                                </div>
                                                <input type="number" value="{{$value->rateData}}" class="form-control m-input" name="rndRateWith" placeholder="Rate">
                                             </div>
                                          </div>


                                       </div>

                                    <?php
                                    }

                                    ?>


                                 </div>
                              </div>
                              <!-- <div class="row">
                              <div class="col-lg-3"></div>
                              <div class="col">
                                 <div data-repeater-create="" class="btn btn btn-primary m-btn m-btn--icon">
                                    <span>
                                       <i class="la la-plus"></i>
                                       <span>Add More</span>
                                    </span>
                                 </div>
                              </div>
                           </div> -->
                           </div>



                        </div>
                        <div style="display:none"  class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">Recommendation Loose:</label>
                           <input type="text" value="{{$data->recommandation_dose}}" class="form-control m-input" id="ingb_rdose" name="ingb_rdose" placeholder="">

                        </div>
                        <div style="display:none"  class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label"> Standard Package Size :</label>
                           <div class="input-group">
                              <input type="text" value="{{$data->recommandation_dose}}" name="ingb_spz" class="form-control" placeholder="" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">


                        <!-- confta  -->
                        <div class="col-lg-4 m-form__group-sub">
                           <div class="form-group m-form__group">
                              <label for="exampleInputEmail1" style="color:#035496">COA File Browser</label>
                              <div></div>
                              <div class="custom-file">
                                 <input title="PDF file only" accept="application/pdf" type="file" name="customFileCOA" class="custom-file-input" id="customFileCOA">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-4 m-form__group-sub">
                           <div class="form-group m-form__group">
                              <label for="exampleInputEmail1" style="color:#035496">MSDS File Browser</label>
                              <div></div>
                              <div class="custom-file">
                                 <input title="PDF file only" accept="application/pdf" type="file" name="customFileMSDS" class="custom-file-input" id="customFileMSDS">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-4 m-form__group-sub">
                           <div class="form-group m-form__group">
                              <label for="exampleInputEmail1"style="color:#035496" >GC File Browser</label>
                              <div></div>
                              <div class="custom-file">
                                 <input title="PDF file only"  accept="application/pdf" type="file" name="customFileGS" class="custom-file-input" id="customFileGS">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                        </div>
                        

                        <!-- confta  -->

                     </div>
                  </div>
                  
                  

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div style="display:none"   class="col-lg-4 m-form__group-sub">
                           <label for="">Available Loose</label>
                           <div class="m-radio-inline">
                              <?php
                              if ($data->av_lose == 1) {
                              ?>
                                 <label class="m-radio">
                                    <input type="radio" checked name="av_dose" value="1"> YES
                                    <span></span>
                                 </label>
                                 <label class="m-radio">
                                    <input type="radio" name="av_dose" value="2"> NO
                                    <span></span>
                                 </label>
                              <?php

                              } else {
                              ?>
                                 <label class="m-radio">
                                    <input type="radio" name="av_dose" value="1"> YES
                                    <span></span>
                                 </label>
                                 <label class="m-radio">
                                    <input type="radio" checked name="av_dose" value="2"> NO
                                    <span></span>
                                 </label>

                              <?php
                              }
                              ?>


                           </div>
                           <span class="m-form__help"></span>



                        </div>
                        <div style="display:none"  class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label">Lead time(Days):</label>
                           <input type="text" value="{{$data->lead_type}}" class="form-control m-input" id="ingb_ltime" name="ingb_ltime" placeholder="">

                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label"> SAP Item Code :</label>
                           <div class="input-group">
                              <input type="text" value="{{$data->sap_code}}" name="ingb_sapcode" class="form-control" placeholder="" />
                           </div>
                        </div>
                     </div>
                  </div>



                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Link Brand</label>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                           <select class="form-control m-select2" id="m_select2_9" name="paramLinkBrand[]" multiple>
                              <option></option>
                              <?php
                              foreach ($brand_data_arr as $key => $value) {
                                 if ($data->ing_brand_name == $value->id) {

                              ?>
                                    <option selected value="{{$value->id}}">{{$value->brand_name}}</option>

                                 <?php

                                 } else {
                                 ?>
                                    <option value="{{$value->id}}">{{$value->brand_name}}</option>

                              <?php
                                 }
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Add Supplier</label>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                           <select class="form-control m-select2" id="m_select2_10" name="paramLinkSupplier[]" multiple>
                              <option></option>
                              <option value="1">Lubrizol</option>
                           </select>
                        </div>
                     </div>
                  </div>


                  <?php 
                  if(Auth::user()->id==1){
                    
                     ?>
                     <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Admin Remarks</label>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                        
                        <textarea class="form-control" name="ing_remarks" id="ing_remarks" cols="30" rows="10">{{$data->ing_remarks}}</textarea>
                        </div>
                     </div>
                  </div>

                     <?php
                  }
                  ?>            
                  


                  



               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">
                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submitSaveINGD" class="btn btn-primary ajsaveIngdredent">Save</button>
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