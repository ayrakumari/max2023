<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Add New Ingredient Supplier
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">               

               <li class="m-portlet__nav-item">
               <a href="{{ route('rnd.ingrednetList')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
            <form data-redirect="aba.html"  class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_ingredeint" method="post" action="{{ route('saveINGdata')}}">
               @csrf
            
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-2 m-form__group-sub">
                            <label class="form-control-label">* IG No:</label>
                        <input type="text" readonly class="form-control m-input" id="ig_no" name="ig_no" placeholder="IG NO.">
                        </div>
                        <div class="col-lg-5 m-form__group-sub">
                            <label class="form-control-label">Company Name:</label>
                           <input type="text"  class="form-control m-input" id="company_name" name="company_name" placeholder="Company Name">

                        </div>
                        <div class="col-lg-5 m-form__group-sub">
                            <label class="form-control-label"> Full Address :</label>                           
                           <div class="input-group">
                              <input type="text" name="full_address" class="form-control" placeholder="Full Address" />                              
                           </div>
                        </div>
                       
                       
                     </div>
                  </div>
                  
                  <div class="m-form__section m-form__section--first">                     
                        {{-- form repqter --}}                           
                        <div id="m_repeater_1">
                           <div class="form-group   row" id="m_repeater_1">
                              <div data-repeater-list="ingContact" class="qc_from">

                                    <div data-repeater-item class="form-group  row align-items-center" style="margin-left: 29px;">                                         

                                          <div class="col-md-3">                                                                           
                                             <input type="text" name="contact_name" class="form-control m-input" placeholder="Contact Name">
                                             <span class="m-form__help"></span>
                                          </div>
                                          <div class="col-md-3">                                            
                                             <input type="text" name="contact_phone" class="form-control m-input" placeholder="Phone">
                                             <span class="m-form__help"></span>
                                          </div>
                                          <div class="col-md-3">                                            
                                             <input type="text" name="contact_email" class="form-control m-input" placeholder="Email">
                                             <span class="m-form__help"></span>
                                          </div>                                                                                
                                          <div class="col-md-3">
                                             <div data-repeater-delete=""  style="margin-bottom: 16px;" class="btn-m btn btn-danger m-btn m-btn--icon">
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
                                 <div data-repeater-create="" class="btn btn btn-sm btn-warning m-btn m-btn--icon m-btn--pill m-btn--wide">
                                    <span>
                                    <i class="la la-plus"></i>
                                    <span>Add More Contact</span>
                                    </span>
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




