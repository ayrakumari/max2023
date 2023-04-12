<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Add Ingredient  Category
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
     <?php 
        // print_r($data);
     ?>
      
      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">          
            <form data-redirect="aba.html" class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint" method="post" action="{{ route('UpdateINGCategorydata')}}">
               @csrf
               <input type="hidden" value="{{$data->id}}" name="txtCatId">
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">Category Name:</label>
                        <input type="text"  value="{{$data->category_name}}" class="form-control m-input" id="ingbcatName" name="ingbcatName" placeholder="">
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">Brand Available:</label>
                        <input type="text" value="{{$data->brand_name}}"  class="form-control m-input" id="ingbcatBrandAvailable" name="ingbcatBrandAvailable" placeholder="">
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">No .of Ingredient:</label>
                        <input type="text"  value="{{$data->no_of_ing}}"  class="form-control m-input" id="ingbcatNoIngredient" name="ingbcatNoIngredient" placeholder="">
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">No .of Formulations:</label>
                        <input type="text" value="{{$data->no_of_formula}}"   class="form-control m-input" id="ingbcatNoFormulation" name="ingbcatNoFormulation" placeholder="">
                        </div>

                       
                       
                       
                       
                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                            <label class="form-control-label">No .of Finish Products:</label>
                        <input type="text" value="{{$data->no_of_finish_prouduct}}"    class="form-control m-input" id="ingbcatNoProduction" name="ingbcatNoProduction" placeholder="">
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




