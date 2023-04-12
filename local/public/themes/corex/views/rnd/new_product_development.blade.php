<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 New Product Developement
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
            <form data-redirect="aba.html" class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint" method="post" action="{{ route('saveNewProductDevelopment')}}">
               @csrf

               <?php 
                        //$car_data_arr=AyraHelp::getIngredientCategory();
                        $brand_data_arr=AyraHelp::getIngredientBrand();
                        $supplier_data_arr=AyraHelp::getIngredientSupplier();
                        $car_data_arr=AyraHelp::getFinishProductSubCatData();
                       
                        

                        ?>
            
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* Type:</label>
                            <select name="product_type" id="product_type" class="form-control m-input">
                           <option value="">--SELECT--</option>
                           <option value="1">Client</option>
                           <option value="2">In House</option>

                           </select>

                        </div>
                        <div class="col-lg-6 m-form__group-sub">
                            <label class="form-control-label">Item Name:</label>                           
                            <input type="text"  class="form-control m-input" id="product_name" name="product_name" placeholder="">


                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">Sub Category:</label>     
                             <select name="cat_id" id="cat_id" class="form-control m-input">
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
                        
                       
                       
                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">                       
                        <div class="col-lg-12 m-form__group-sub">
                            <label class="form-control-label">Discrptions:</label>
                            <textarea name="product_info"   id="product_info" class="form-control" data-provide="markdown" rows="5"></textarea>
                        </div>
                        
                     </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Claim Required</label>
                           <input type="text"  class="form-control m-input" id="claim_required" name="claim_required" placeholder="">

                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Benchmark Provided</label>
                           <input type="text"  class="form-control m-input" id="benchmark_provided" name="benchmark_provided" placeholder="">

                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Benchmark URL/Website</label>
                           <input type="text"  class="form-control m-input" id="benchmark_url" name="benchmark_url" placeholder="">

                        </div>
                       
                     </div>
                  </div>



                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        
                        <div class="col-lg-12 m-form__group-sub">
                            <label class="form-control-label">Suggested Ingredient</label>
                            <textarea name="suggested_ingredient"   id="suggested_ingredient" class="form-control" data-provide="markdown" rows="5"></textarea>

                        </div>
                 </div>


                 <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Color</label>
                           <input type="text"  class="form-control m-input" id="p_color" name="p_color" placeholder="">

                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Fragrance</label>
                           <input type="text"  class="form-control m-input" id="p_fragrance" name="p_fragrance" placeholder="">

                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">Target Sell Price</label>
                           <input type="text"  class="form-control m-input" id="p_target_sell_price" name="p_target_sell_price" placeholder="">

                        </div>
                       
                     </div>
                  </div>


                  <?php 
                  $data=AyraHelp::getRNDIngredentList();
                  
                 
                  ?>

                  <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Link Ingredient</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                        <select class="form-control m-select2" id="m_select2_9" name="finish_p_link_formulation[]" multiple>
                            <option></option>
                            <?php
                             foreach ($data as $key => $rowData) {
                              
                              ?>
                                <option value="{{$rowData->id}}">{{$rowData->name}}</option>

                              <?php
                           }

                             ?>
                          
                       </select>
                        </div>
                    </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Add Suggested Formulation</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                        <select class="form-control m-select2" id="m_select2_10" name="finish_p_link_ingredient[]" multiple>
                            <option></option>
                            
                       </select>
                        </div>
                    </div>
                  </div>

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        
                        <div class="col-lg-12 m-form__group-sub">
                            <label class="form-control-label">Remarks</label>
                            <textarea   id="npdev_remarks"  name="npdev_remarks" class="form-control" data-provide="markdown" rows="3"></textarea>

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




