<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Add Finish Product Category 
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

           <div class="row">
           


                </div>
                <div class="col-md-8" style="display:none">

                	<!--begin: Datatable -->
														<table  style="display:none" class="table table-striped- table-bordered table-hover table-checkable" id="m_table_finishproduct_catlist">
															<thead>
																<tr>
																	<th>ID#</th>
																	<th>Category</th>
																	<th>Sub Category</th>
                                                   <th>NO .of Finish Product</th>                                                                    	
																	<th>Actions</th>
																</tr>
															</thead>															
														</table>
													    </div>
												        </div>
						                                <!-- datalist -->


                <form data-redirect="{{route('finishProductSubCategory')}}"   class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint_v1" method="post" action="{{ route('saveFinishCatSubCat')}}">
               @csrf
                <?php 
                   $fp_arr= AyraHelp::getFinishProductCatData();                  
                  
                ?>
               <input type="hidden" name="txtCVal" value="2">
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-6 m-form__group-sub">
                            <label class="form-control-label">Select Category :</label>
                           <select name="f_category" id="" class="form-control">
                           <option value="">-SELECT-</option>
                           <?php 
                            foreach ($fp_arr as $key => $rowData) {
                               
                                ?>
                                 <option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
                                <?php
                               }
                      
                           ?>
                           </select>
                        </div>
                        <div class="col-lg-6 m-form__group-sub">
                            <label class="form-control-label">Sub Category Name:</label>
                            <input type="text"  class="form-control m-input" id="f_p_subcat" name="f_p_subcat" placeholder="">
                        </div>
                       
                     </div>
                  </div>
                         
               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">
                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submitSaveINGD_1" class="btn btn-warning ">Save Sub Category</button>                           
                           <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>


                </div>

           </div>

          
          
         </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->




