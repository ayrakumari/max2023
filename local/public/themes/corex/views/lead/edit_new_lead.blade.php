

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Edit Leads
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
                                                                <li class="m-portlet__nav-item">
                                                                <a href="{{route('home')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                                                                    <span>
                                                                    <i class="la la-arrow-left"></i>
                                                                    <span>Home </span>
                                                                    </span>
                                                                </a>
                                                                </li>

															</ul>
														</div>
													</div>
													<div class="m-portlet__body">
                      <ul class="nav nav-pills" role="tablist">
											<li class="nav-item ">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
                          <i class="la la-gear"></i>
                          Leads</a>
											</li>

											<!-- <li class="nav-item">
												<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
                          <i class="flaticon-users-1"></i>
                          Contacts
                        </a>
											</li> -->

										</ul>

                    <div class="tab-content">
			<div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">

                        <!--begin::Portlet-->
              <div class="m-portlet">
               
                <div class="m-portlet__body">
                  <!-- form  -->
                  <!--begin::Form-->
                                    <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_edit_leads" method="post" action="{{ route('updateLeadData')}}">
                                      @csrf
                                      
                                      <input type="hidden"  value="{{$users->QUERY_ID}}" name="QUERY_ID">
                                      <div class="m-portlet__body">
                                        <div class="m-form__section m-form__section--first">
                                          <div class="form-group m-form__group row">
                                            <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">* Source:</label>
                                               <select class="form-control m-input" id="exampleSelect1" name="source">
                                                @foreach (AyraHelp::getClientSource() as $source)
                                                <?php 
                                                if($source->id==$users->data_source_ID){
                                                    ?>
                                                    <option selected value="{{$source->id}}">{{$source->source_name}}</option>
                                                    <?php
                                                }else{
                                                  ?>
                                                  <option value="{{$source->id}}">{{$source->source_name}}</option>
                                                  <?php
                                                }
                                                ?>
                                              	
                                                @endforeach
                      						   </select>

                                             </div>
                                            <div class="col-lg-4 m-form__group-sub">
                                              <label class="form-control-label">Company:</label>
                                              <input type="text" class="form-control m-input" value="{{$users->GLUSR_USR_COMPANYNAME}}" name="GLUSR_USR_COMPANYNAME" placeholder="Enter Company ">
                                           </div>
                                           <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label"> Contact Person:</label>
                                               <input type="text" class="form-control m-input" value="{{$users->SENDERNAME}}" name="SENDERNAME" placeholder="Enter Contact Person" >
                                             </div>
                                           </div>
                                         </div>
                                         <!-- name email phone -->
                                         <div class="m-form__section m-form__section--first">
                                           <div class="form-group m-form__group row">
                                             
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">*Mobile:</label>
                                               <input type="text" class="form-control m-input" name="MOB" value="{{$users->MOB}}" placeholder="Enter Mobile" >
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label"> Sender Email:</label>
                                               <input type="text" class="form-control m-input"   value="{{$users->SENDEREMAIL}}" name="SENDEREMAIL" placeholder="Enter Email">
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">Product Name:</label>
                                                 <input type="text" class="form-control m-input" name="PRODUCT_NAME" value="{{$users->PRODUCT_NAME}}" placeholder="Enter Product Name" >
                                             </div>
                                           </div>
                                         </div>
                                         <!-- name email phone -->

                                         <!-- name email phone -->
                                         <div class="m-form__section m-form__section--first">
                                           <div class="form-group m-form__group row">
                                             
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">MOBILE ALT:</label>
                                               <input type="text" class="form-control m-input"  value="{{$users->MOBILE_ALT}}" name="MOBILE_ALT" placeholder="Enter Mobile" >
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label"> EMAIL ALT:</label>
                                               <input type="text" class="form-control m-input" value="{{$users->EMAIL_ALT}}"  name="EMAIL_ALT" placeholder="Enter Email">
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">DATE TIME RE:</label>
                                                 <input type="text" class="form-control m-input"  readonly value="{{$users->DATE_TIME_RE}}" name="name" placeholder="Enter Product Name" >
                                             </div>
                                           </div>
                                         </div>
                                         <!-- name email phone -->
                                         <!-- <address location source>

                                         </address> email phone -->
                                         <div class="m-form__section m-form__section--first">
                                           <div class="form-group m-form__group row">
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label"> Address:</label>
                                                 <input type="text" value="{{$users->ENQ_ADDRESS}}"  class="form-control m-input" name="ENQ_ADDRESS" placeholder="Enter Address" >
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">City:</label>
                                               <input type="text" value="{{$users->ENQ_CITY}}" class="form-control m-input" name="ENQ_CITY" placeholder="Enter Location" >
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">State:</label>
                                               <input type="text"  value="{{$users->ENQ_STATE}}" class="form-control m-input" name="ENQ_STATE" placeholder="Enter Location" >
                                             </div>
                                            
                                           </div>
                                         </div>
                                      <!-- <address location source-->
                                      <!-- website and remarks -->
                                      <div class="m-form__section m-form__section--first">
                                        <div class="form-group m-form__group row">
                                          
                                          
                                          <!-- <div class="col-lg-12 m-form__group-sub">
                                            <label class="form-control-label">Message:</label>                                            
                                            <textarea name="remarks"   id="remarks" placeholder="Remarks" class="form-control" data-provide="markdown" rows="5">{{$users->ENQ_MESSAGE}}</textarea>
                                          </div> -->

                                          <div class="col-lg-12 m-form__group-sub">
                                            <label class="form-control-label">Remarks:</label>                                            
                                            <textarea name="remarks"   id="remarks" placeholder="Remarks" class="form-control" data-provide="markdown" rows="5">{{$users->remarks}}</textarea>
                                          </div>
                                         
                                         

                                        </div>
                                      </div>

                                      <!-- website and remarks -->



                                       </div>
                                       <div class="m-portlet__foot m-portlet__foot--fit">
                                         <div class="m-form__actions m-form__actions">
                                           <div class="row">
                                             <div class="col-lg-12">
                                               <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                                               <button type="reset" class="btn btn-secondary">Reset</button>
                                             </div>
                                           </div>
                                         </div>
                                       </div>
                                     </form>

                                     <!--end::Form-->

                   <!-- form  -->

                </div>
              </div>

              <!--end::Portlet-->










											             <!-- general -->

											</div>

											<div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
										              under construction
											</div>

										</div>
                    <!-- end tab -->
                  </div>
                </div>


					</div>
          <!-- main  -->
