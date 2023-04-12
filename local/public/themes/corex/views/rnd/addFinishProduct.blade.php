<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Add Finish Product
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">               

               <!-- <li class="m-portlet__nav-item">
               <a href="{{ route('rnd.ingrednetBrandList')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                  <span>
                  <i class="la la-arrow-left"></i>
                  <span>Ingredient Brand List </span>
                  </span>
                  </a>
               </li> -->
            </ul>
         </div>
      </div>     
     
      
      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">          
            <form data-redirect="{{route('rnd.finishProduct')}}" class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint" method="post" action="{{ route('saveFinishProduct')}}">
               @csrf

               <?php 
                        $car_data_arr=AyraHelp::getFinishProductSubCatData();
                        $brand_data_arr=AyraHelp::getIngredientBrand();
                        $supplier_data_arr=AyraHelp::getIngredientSupplier();
                        
                       
                        

                        ?>
            
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* Name:</label>
                            <input type="text"  class="form-control m-input" id="finish_p_name" name="finish_p_name" placeholder="">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Sub Category:</label>                           
                           <select name="finish_p_catid" id="finish_p_catid" class="form-control m-input">
                           <option value="">--SELECT--</option>
                              <?php
                              foreach ($car_data_arr as $key => $value) {
                          
                                 ?>
                                  <option value="{{$value->id}}">{{$value->sub_cat_name}}</option>
      
                                 <?php
                              }
                              ?>
                           </select>

                        </div>
                        
                        
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">Chemist:</label>     
                            <select name="finish_p_chemist" id="finish_p_chemist" class="form-control m-input">
                                <option value="">--SELECT--</option>
                                 <?php 
                                 $datas=AyraHelp::getAllUser();                              
                                 foreach ($datas as $key => $rowID) { 
                                    if($rowID->id==103 || $rowID->id==126 ||  $rowID->id==127 || $rowID->id==128){
                                       if($rowID->id==126){
                                          ?>
                                          <option selected value="{{$rowID->id}}">{{$rowID->name}}</option>
                                          <?php
      
                                       }else{
                                          ?>
                                          <option value="{{$rowID->id}}">{{$rowID->name}}</option>
                                          <?php
      
                                       }
                                      
                                    }                                
                                    
                                 }
                                 ?>

                           </select>                     
                          
                        </div>
                        <!-- <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* SAP SFG ID:</label>
                            <input type="text"  class="form-control m-input" id="finish_p_sap_code" name="finish_p_sap_code" placeholder="">
                        </div> -->
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* Grade:</label>
                            <select name="finish_p_grade" id="finish_p_grade" class="form-control m-input">
                                <option value="">--SELECT--</option>
                                <option value="1">Premium</option>
                                <option value="2">Standard</option>
                                <option value="3">Regular</option>
                            </select>
                        </div>
                       
                       
                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">                       
                        <div class="col-lg-12 m-form__group-sub">
                            <label class="form-control-label">Ingredient:</label>
                            <textarea name="finish_p_ingredient"   id="finish_p_ingredient" class="form-control" data-provide="markdown" rows="5"></textarea>
                        </div>
                        
                     </div>
                  </div>


                  <!-- ajaxNew -->
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-12 m-form__group-sub">
                           <!-- <label class="form-control-label">* Price Per Kg:</label>
                           <input type="text" class="form-control m-input" id="ingb_ppkg" name="ingb_ppkg" placeholder=""> -->
                           <div id="m_repeater_3d">
                              <div class="form-group  m-form__group row">

                                 <div data-repeater-list="sizeRateArrA" class="col-lg-12">

                                    <div data-repeater-item class="row m--margin-bottom-10">
                                       <div class="col-lg-6">
                                          <div class="input-group">
                                             <input type="number" class="form-control m-input" name="rndSizeWith_1" placeholder="Size">
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
                                             <input type="number" class="form-control m-input" name="rndRateWith_1" placeholder="Rate">
                                          </div>
                                       </div>
                                    </div>


                                    <div data-repeater-item class="row m--margin-bottom-10">
                                       <div class="col-lg-6">
                                          <div class="input-group">
                                             <input type="number" class="form-control m-input" name="rndSizeWith_2" placeholder="Size">
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
                                             <input type="number" class="form-control m-input" name="rndRateWith_2" placeholder="Rate">
                                          </div>
                                       </div>
                                    </div>



                                    <div data-repeater-item class="row m--margin-bottom-10">
                                       <div class="col-lg-6">
                                          <div class="input-group">
                                             <input type="number" class="form-control m-input" name="rndSizeWith_3" placeholder="Size">
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
                                             <input type="number" class="form-control m-input" name="rndRateWith_3" placeholder="Rate">
                                          </div>
                                       </div>
                                    </div>

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
                       

                     </div>
                  </div>
                  <!-- ajaxNew -->

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        
                        <!-- <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Cost Price /Kg:</label>
                           <input type="text"  class="form-control m-input" id="finish_p_cost_price" name="finish_p_cost_price" placeholder="">

                        </div> -->
                       
                        
                        <div class="col-lg-12 m-form__group-sub">
                            <label class="form-control-label"> Benefits/Claims :</label>                           
                           <div class="input-group">
                           <textarea name="finish_p_benifit_claim" class="form-control" data-provide="markdown" rows="3"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>

                  <?php 
                  $dataIng=AyraHelp::getRNDIngredentList();                
                 
                  ?>


                  <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Link Formulation</label>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                        <select class="form-control m-select2" id="m_select2_9" name="finish_p_link_formulation[]" multiple>
                            <option></option>
                            <option value="1">Lubrizol</option>
                            
                       </select>
                        </div>
                    </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Link Ingredient</label>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                        <select class="form-control m-select2" id="m_select2_10" name="finish_p_link_ingredient[]" multiple>
                        <?php
                             foreach ($dataIng as $key => $rowData) {                              
                              ?>
                                <option value="{{$rowData->id}}">{{$rowData->name}}</option>
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




