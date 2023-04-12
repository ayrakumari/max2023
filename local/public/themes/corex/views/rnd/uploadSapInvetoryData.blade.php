<!-- main  -->
<div class="m-content">
   <!-- datalist -->

   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Upload SAP Invertory Data
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">

               <li class="m-portlet__nav-item">
                  <a href="{{ route('rnd.ingredients')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                     <span>
                        <i class="la la-arrow-left"></i>
                        <span>Ingredient List </span>
                     </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>


      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
            <form data-redirect="Ingredients" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_ingredeint" method="post" action="{{ route('saveSapUploadData')}}">
               @csrf
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">* Name:</label>
                           <input type="text" class="form-control m-input" id="ingb_name" name="ingb_name" placeholder="">
                        </div>
                        <?php
                        $car_data_arr = AyraHelp::getIngredientCategory();
                        $brand_data_arr = AyraHelp::getIngredientBrand();
                        $supplier_data_arr = AyraHelp::getIngredientSupplier();




                        ?>
                         <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">*INCI:</label>
                           <input type="text" class="form-control m-input" id="inci_name" name="inci_name" placeholder="">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                           <label class="form-control-label">Category:</label>

                           <select name="ingb_cat" id="ingb_cat" class="form-control m-input">
                              <option value="">--SELECT--</option>
                              <?php
                              foreach ($car_data_arr as $key => $value) {

                              ?>
                                 <option value="{{$value->id}}">{{$value->category_name}}</option>

                              <?php
                              }
                              ?>
                           </select>

                        </div>
                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">Brand:</label>
                           <select name="ingb_brand" id="ingb_brand" class="form-control m-input">
                              <option value="">--SELECT--</option>
                              <?php
                              foreach ($brand_data_arr as $key => $value) {
                              ?>
                                 <option value="{{$value->id}}">{{$value->brand_name}}</option>
                              <?php
                              }
                              ?>
                           </select>

                        </div>

                        <div class="col-lg-2 m-form__group-sub">
                           <label class="form-control-label">*Other Name:</label>
                           <input type="text" class="form-control m-input" id="ingb_other_name" name="ingb_other_name" placeholder="">
                        </div>
                       


                     </div>
                  </div>
                

                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">


                        <!-- confta  -->
                        <div class="col-lg-12 m-form__group-sub">
                           <div class="form-group m-form__group">
                              <label for="exampleInputEmail1" style="color:#035496">SAP File Browser</label>
                              <div></div>
                              <div class="custom-file">
                                 <input title="xlsx Format Only" type="file" name="customFileSap" class="custom-file-input" id="customFileSap">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                        </div>                    

                       
                        

                        <!-- confta  -->

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