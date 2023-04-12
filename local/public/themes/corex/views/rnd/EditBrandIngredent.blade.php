<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Edit Ingredient Brand
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">               

               <li class="m-portlet__nav-item">
               <a href="{{ route('rnd.ingrednetBrandList')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                  <span>
                  <i class="la la-arrow-left"></i>
                  <span>Ingredient Brand List  </span>
                  </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>     
      
      <?php 
      $select_arr=json_decode($data->supplier_id);

      $supperlier_arr=AyraHelp::getIngredientSupplier();
     //echo "<pre>";
      //print_r($supperlier_arr);
     
      
     

      ?>
      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">          
            <form class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint_brand" method="post" data-redirect="{{route('rnd.ingrednetBrandList')}}" action="{{ route('updateINGBrand')}}">
               @csrf
                <input type="hidden" name="txtbrandID" value="{{$data->id}}">
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label"> Brand Name:</label>
                            <input type="text" value="{{$data->brand_name}}"  class="form-control m-input" id="brand_name" name="brand_name" >
                        </div>
                        <div class="col-lg-8 m-form__group-sub">
                            <label class="form-control-label">Supplier Name:</label>
                            <select class="form-control m-select2" id="m_select2_9" name="supplier_name[]" multiple>

                            <option value="">--SELECT--</option>
                            <?php 
                             foreach ($supperlier_arr as $key => $rowData) {
                              if(in_array($rowData->id, $select_arr))
                              {
                                 ?>
                                 <option selected value="{{ $rowData->id }}">{{$rowData->company_name}}</option>

                                <?php

                              }else{
                                 ?>
                                   <option value="{{ $rowData->id }}">{{$rowData->company_name}}</option><b></b>
                                  <?php
                              }
                              
                             
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
                           <button type="submit" data-wizard-action="submitSaveINGBrand" class="btn btn-primary ajsaveIngdredent">Save</button>                           
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




