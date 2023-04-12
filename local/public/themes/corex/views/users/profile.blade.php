

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
															Profile
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                  <a href="/" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                                    <span>
                                  	<i class="la la-arrow-left"></i>
                                      <span>BACK </span>
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
                          My profile</a>
											</li>

											<li class="nav-item">
												<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
                          <i class="flaticon-users-1"></i>
                          Settings
                        </a>
											</li>

										</ul>

                    <div class="tab-content">
											<div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">

                        <!--begin::Portlet-->
              <div class="m-portlet">
                <div class="m-portlet__head">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <span class="m-portlet__head-icon">
                        <i class="flaticon-map-location"></i>
                      </span>

                    </div>
                  </div>
                  <div class="m-portlet__head-tools">

                  </div>
                </div>
                <div class="m-portlet__body">
                   <!-- form  -->
                   <!--begin::Form-->
                                     <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_client" method="post" action="{{ route('client.store')}}">
                                       @csrf
                                       <div class="m-portlet__body">
                                         <div class="m-form__section m-form__section--first">
                                           <div class="form-group m-form__group row">
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">* Name:</label>
                                                 <input type="text" class="form-control m-input" value ="{{Auth::user()->name}}" name="name" placeholder="Enter Name">
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">Email:</label>
                                                 <input type="text" class="form-control m-input" value="{{Auth::user()->email}}" name="email" placeholder="Enter Email">
                                             </div>
                                             <div class="col-lg-4 m-form__group-sub">
                                               <label class="form-control-label">Phone</label>
                                                <input type="phone" class="form-control m-input" value="{{Auth::user()->phone}}" name="phone" placeholder="Enter Phone" >
                                             </div>
                                           </div>
                                         </div>

                                       </div>
                                       <div class="m-portlet__foot m-portlet__foot--fit">
                                         <div class="m-form__actions m-form__actions">
                                           <div class="row">
                                             <div class="col-lg-12">
                                               <button type="button" data-wizard-action="submitANeedtoDoCode" class="btn btn-primary">Save Changes</button>
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
										              <!-- Settings -->
                                  <!--begin::Portlet-->
						<div class="m-portlet m-portlet--space">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
										My Settings
										</h3>
									</div>
								</div>

							</div>
							<div class="m-portlet__body">
								<div class="row">
									<div class="col-xl-4">
										<div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
											<ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg m-nav--font-bold m--margin-bottom-20 m--margin-top-10 m--margin-right-40" id="m_nav" role="tablist">
												<li class="m-nav__item">
													<a class="m-nav__link m-tabs__item m-tabs__item--active" data-tab-target="#m_section_1" href="#">
														<span class="m-nav__link-text">Password </span>
													</a>
												</li>
												

											</ul>
										</div>
									</div>
									<div class="col-xl-8">
										<div class="m-tabs-content" id="m_sections">

											<!--begin::Section 1-->
											<div class="m-tabs-content__item m-tabs-content__item--active" id="m_section_1">
												<h4 class="m--font-bold m--margin-top-15 m--margin-bottom-20">Password Reset</h4>
												<div class="m-accordion m-accordion--section m-accordion--padding-lg" id="m_section_1_content">

													<!--begin::Item-->
													<div class="m-accordion__item">

														<div class="m-accordion__item-body collapse show" id="m_section_1_content_1_body" role="tabpanel" aria-labelledby="m_section_1_content_1_head" data-parent="#m_section_1_content">
															<div class="m-accordion__item-content">
															   <!-- password reset -->
                                 <!--begin::Portlet-->



 									<!--begin::Form-->
 									<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_2_reset">
 										<div class="m-portlet__body">
 											<div class="m-form__content">
 												<div class="m-alert m-alert--icon alert alert-warning m--hide" role="alert" id="m_form_2_msg">
 													<div class="m-alert__icon">
 														<i class="la la-warning"></i>
 													</div>


 												</div>
 											</div>
 										
 											<div class="form-group m-form__group row">
 												<label class="col-form-label col-lg-4 col-sm-12">Current Password</label>
 												<div class="col-lg-8 col-md-8 col-sm-12">
 													<div class="m-input-icon m-input-icon--left">
 														<input type="text" class="form-control m-input" name="current"  id="current" placeholder="*************************">
 														<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-key"></i></span></span>
 													</div>
 													<span class="m-form__help"></span>
 												</div>
											 </div>
											 <div class="form-group m-form__group row">
												<label class="col-form-label col-lg-4 col-sm-12">New Password</label>
												<div class="col-lg-8 col-md-8 col-sm-12">
													<div class="m-input-icon m-input-icon--left">
														<input type="text" class="form-control m-input" name="password" id="password"  placeholder="">
														<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-key"></i></span></span>
													</div>
													<span class="m-form__help"></span>
												</div>
											</div>
											<div class="form-group m-form__group row">
												<label class="col-form-label col-lg-4 col-sm-12">Confirm Password</label>
												<div class="col-lg-8 col-md-8 col-sm-12">
													<div class="m-input-icon m-input-icon--left">
														<input type="text" class="form-control m-input"  name="confirmed" id="confirmed" placeholder="">
														<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-key"></i></span></span>
													</div>
													<span class="m-form__help"></span>
												</div>
											</div>		
 										
 										</div>
 										<div class="m-portlet__foot m-portlet__foot--fit">
 											<div class="m-form__actions m-form__actions">
 												<div class="row">
 													<div class="col-lg-9 ml-lg-auto">
 														<button type="button" id="btnPasswordReset" class="btn btn-warning">Reset Password</button>
 														<button type="reset" class="btn btn-secondary">Cancel</button>
 													</div>
 												</div>
 											</div>
 										</div>
 									</form>

 									<!--end::Form-->
 								

 								<!--end::Portlet-->


															   <!-- password reset -->

															</div>
														</div>
													</div>

													<!--end::Item-->



												</div>
											</div>

										


										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end::Portlet-->
										              <!-- Settings -->

											</div>

										</div>
                    <!-- end tab -->
                  </div>
                </div>


					</div>
          <!-- main  -->
