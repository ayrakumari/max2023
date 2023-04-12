<div class="m-content">


<?php 
                                                $img_photo=asset('local/public/uploads/photos')."/".optional($user_data)->photo;
                                                ?>


                        <form action="{{route('updateEmpdata')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- ajcode  -->
                        <div class="row">
                        <input type="hidden" name="txtUserID" value="{{$user_data->id}}">
                        <input type="hidden" name="txtEMPCODE" value="{{$user_data->emp_code}}">
							
							<div class="col-xl-12 col-lg-12">
								<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
												
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#emp_tab_1" role="tab">
														EMPLOYEE DETAILS
													</a>
												</li>
												<!-- <li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab">
														Document
													</a>
												</li> -->
											</ul>
										</div>
										
									</div>
									<div class="tab-content">
										<div class="tab-pane active" id="emp_tab_1">
											<!-- list of emp -->
                                            @if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
										
						
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
										
												<!-- <span class="m-topbar__userpic">

													<img src="{{$img_photo}}" width="100" class="m--img-1 m--marginless" alt="" width="200">
												</span> -->
												
											

												{{ ucwords($user_data->name)}} : [ <strong>{{ ucwords($user_data->emp_code)}}</strong> ]
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="javascript::void(0)"  id="btnAddEmployee" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
												<span>
													<i class="la la-users"></i>
													<span>Add New</span>
												</span>
											</a>
										</li>
										<li class="m-portlet__nav-item"></li>
										
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
                                    <!-- view emp -->
                                    <div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Employee Details</h3>
							</div>
                            <div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Photo:</label>
                               
                                                 
								<div class="col-xl-6 col-lg-6">
									<div class="custom-file">
														<input type="file" name="emp_photo"  class="custom-file-input" id="customFile" name="pan_doc">
														<label class="custom-file-label" for="customFile">Choose file</label>
													</div>
												
								</div>
								<div class="col-xl-3 col-lg-3">
										<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="{{$img_photo}}" width="100" class="m--img-1 m--marginless" alt="" width="200">
												</span>
												
											</a>
								</div>
                                

                               
							</div>

                            
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Name:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="name" value="{{$user_data->name}}" class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Email:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="email" name="email" value="{{$user_data->email}}"  class="form-control m-input" placeholder="" >
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Phone</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
										<input type="text" name="phone" value="{{$user_data->phone}}"  class="form-control m-input" placeholder="">
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Gender</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
									
										<div class="m-form__group form-group">
															
																<div class="m-radio-inline">
																	<label class="m-radio">
																		<input type="radio" <?php echo $user_data->gender==1 ?'checked':'' ?> name="gender" value="1"> Male
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio" <?php echo $user_data->gender==2 ?'checked':'' ?>  name="gender" value="2"> Female
																		<span></span>
																	</label>
																	
																</div>
																<span class="m-form__help"></span>
															</div>
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Birth Date</label>
								<div class="col-xl-9 col-lg-9">
                                <?php                                 
                                 $created_on=date('j M Y', strtotime($user_data->dob));
                                 ?>
									<div class="input-group date">
										<input type="text" name="birth_date" value="{{$created_on}}" class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>
										

								</div>
							</div>

						</div>

						<div class="m-form__section">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">
									Mailing Address
									<i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i>
								</h3>
							</div>
							

							



							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Address Line</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="address" value="{{$user_data->address}}" class="form-control m-input" placeholder="" >
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* pincode:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="pincode" value="{{$user_data->pincode}}"  class="form-control m-input pincode" placeholder="" >
								</div>
							</div>
							
							
							<div class="form-group m-form__group row ">
								<label class="col-xl-3 col-lg-3 col-form-label">* City:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="loccity" value="{{$user_data->city}}" class="form-control m-input" placeholder="" >
								</div>
							</div>
							<div class="form-group m-form__group row ">
								<label class="col-xl-3 col-lg-3 col-form-label">* State:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="locstate" value="{{$user_data->state}}"   class="form-control m-input" placeholder="" >
								</div>
							</div>
							
						</div>
					</div>
				</div>


                <div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Official</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Offcial Email:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="offcial_email" value="{{$user_data->comp_email}}" class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Designation:</label>
								<div class="col-xl-9 col-lg-9">									
									<select class="form-control m-input"  name="designation"   id="exampleSelect1">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getDesignation();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Department</label>
								<div class="col-xl-9 col-lg-9">
									
									<select class="form-control m-input"  name="department"   id="exampleSelect1">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getDepartment();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Job Roles</label>
								<div class="col-xl-9 col-lg-9">
									
									<select class="form-control m-input"  name="jobrole">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getJobRole();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							
							
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Join Date</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
                                   
                                    <?php                                 
                                     $created_on=date('j M Y', strtotime($user_data->doj));
                                    ?>
										<input type="text" name="join_date" value="{{$created_on}}" class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>
							<div class="form-group m-form__group row">
										<label class="col-xl-3 col-lg-3 col-form-label">*Biomatric ID:</label>
										<div class="col-xl-9 col-lg-9">
											<input type="text" name="emp_code" value="{{$user_data->emp_code}}"  class="form-control m-input" placeholder="Enter Attendance Employee ID">
											<span class="m-form__help"></span>
										</div>
									</div>
									

							<?php
							 $user = auth()->user();
							 $userRoles = $user->getRoleNames();
							 $user_role = $userRoles[0];
							 if($user_role=='Admin' || Auth::user()->id==83){
									?>
									<div class="form-group m-form__group row">
										<label class="col-xl-3 col-lg-3 col-form-label">* Basic Salary:</label>
										<div class="col-xl-9 col-lg-9">
											<input type="text" name="basic_salary"  value="{{$user_data->basic_salary}}"  class="form-control m-input" placeholder="Enter Basic Salary">
											<span class="m-form__help"></span>
										</div>
									</div>
									


									<!-- ajcode -->
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* BANK NAME</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="bank_name"  value="{{$user_data->bank_name}}" class="form-control m-input" placeholder=""  />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Account No.</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="account_no" value="{{$user_data->account_no}}"  class="form-control m-input"  />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>

							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* IFSC Code.</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="ifsc_code"  value="{{$user_data->ifsc_code}}"  class="form-control m-input"  />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>
							



							

							

							<!-- ajcode -->


									<?php
							 }

							?>

							<?php 
							
                                 
							$exit_on=date('j M Y', strtotime($user_data->doe));
							
							

							?>

								<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Exit Date</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="exit_date"  value="{{$exit_on}}"  class="form-control m-input"  placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>

							<?php 
							 $active_status=$user_data->user_status;
							

							?>

							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Status</label>
								<div class="col-xl-9 col-lg-9">
									<select name="user_status" id="" class="form-control">
									<?php 
									if($active_status==0){
										?>
										<option value="0" selected >Active</option>
										<option value="1"  >Deactive</option>
										<?php
									}else{
										?>
										<option value="0"  >Active</option>
										<option value="1"selected  >Deactive</option>
										<?php

									}
									?>
									
									
									</select>
								</div>
							</div>
							


						</div>
						
					</div>
				</div>



                <div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Documentation</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* PAN No.:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="pan_no" value="{{$user_data->pan_card}}"  class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* PAN DOC:</label>
                                <?php 
                                                $img_pan=asset('local/public/uploads/photos')."/".$user_data->pan_doc_img;
                                                ?>
                                                 
								<div class="col-xl-9 col-lg-9">
								<div class="custom-file">
													<input type="file" name="pan_doc"  class="custom-file-input" id="customFile" name="pan_doc">
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div><br>
                                               
                                                <img class="m-widget7__img" width="442px" height="200px"  src="{{$img_pan}}" alt="">     
								</div>
                               
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Aadhar No. </label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
                                    <?php 
                                                $img_adhar=asset('local/public/uploads/photos')."/".$user_data->aadhar_doc_img;
                                                ?>
										
										<input type="text" name="aadhar_no" value="{{$user_data->aadhar_card}}" class="form-control m-input" placeholder="">
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Aadhar DOC</label>
								<div class="col-xl-9 col-lg-9">
								<div class="custom-file">
													<input type="file" name="aadhar_doc"  class="custom-file-input" id="customFile" name=""aadhar_doc>
													<label class="custom-file-label" for="customFile">Choose file</label>
                                                    <br>
                                               
                                                <img class="m-widget7__img" width="442px" height="200px"  src="{{$img_adhar}}" alt=""> 

												</div>
								</div>
							</div>
							
							

						</div>
                        <br>
                        <br>
                        <br>
						
					</div>

				</div>
                



                                    <!-- view emp -->
								
							
							</div>
                            
                            
						</div>

						

                        <div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions--solid">
												<div class="row">
													<div class="col-3">
													</div>
													<div class="col-9">
														<button type="submit" class="btn btn-brand">Save Changes</button>
													
														<a href="{{route('employee')}}" class="btn btn-metal">Cancel</a>
													</div>
												</div>
											</div>
										</div>

                                    </form>
											<!-- list of emp -->
										</div>
										
									
									</div>
								</div>
							</div>
						</div>
					

                        <!-- ajcode  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_AddEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="exampleModalLabel">Add New Employee</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			
			<!-- add employee -->
			
									
			<!--begin: Form Wizard-->
			<div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizardA">

<!--begin: Message container -->
<div class="m-portlet__padding-x">

	<!-- Here you can put a message or alert -->
</div>

<!--end: Message container -->

<!--begin: Form Wizard Head -->
<div class="m-wizard__head m-portlet__padding-x">

	<!--begin: Form Wizard Progress -->
	<div class="m-wizard__progress">
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	</div>

	<!--end: Form Wizard Progress -->

	<!--begin: Form Wizard Nav -->
	<div class="m-wizard__nav">
		<div class="m-wizard__steps">
			<div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
				<a href="#" class="m-wizard__step-number">
					<span><i class="fa  flaticon-placeholder"></i></span>
				</a>
				<div class="m-wizard__step-info">
					<div class="m-wizard__step-title">
						1. 
					</div>
					
				</div>
			</div>
			<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
				<a href="#" class="m-wizard__step-number">
					<span><i class="fa  flaticon-layers"></i></span>
				</a>
				<div class="m-wizard__step-info">
					<div class="m-wizard__step-title">
						2. 
					</div>
					
				</div>
			</div>
			<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
				<a href="#" class="m-wizard__step-number">
					<span><i class="fa  flaticon-layers"></i></span>
				</a>
				<div class="m-wizard__step-info">
					<div class="m-wizard__step-title">
						3. 
					</div>
				
				</div>
			</div>
		</div>
	</div>

	<!--end: Form Wizard Nav -->
</div>

<!--end: Form Wizard Head -->

<!--begin: Form Wizard Form-->
<div class="m-wizard__form">

	<!--
1) Use m-form--label-align-left class to alight the form input lables to the right
2) Use m-form--state class to highlight input control borders on form validation
-->
	<form class="m-form m-form--label-align-left- m-form--state-" id="m_formA" enctype="multipart/form-data" method="post" action="{{route('saveEmployee')}}">
@csrf
		<!--begin: Form Body -->
		<div class="m-portlet__body">

			<!--begin: Form Wizard Step 1-->
			<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Employee Details</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Name:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="name" class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Email:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="email" name="email" class="form-control m-input" placeholder="" >
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Phone</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
										<input type="text" name="phone" class="form-control m-input" placeholder="">
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Gender</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
									
										<div class="m-form__group form-group">
															
																<div class="m-radio-inline">
																	<label class="m-radio">
																		<input type="radio" name="gender" value="1"> Male
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio" name="gender" value="2"> Female
																		<span></span>
																	</label>
																	
																</div>
																<span class="m-form__help"></span>
															</div>
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Birth Date</label>
								<div class="col-xl-9 col-lg-9">
									

											<div class="input-group date">
												<input type="text" name="birth_date"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
												<div class="input-group-append">
													<span class="input-group-text">
														<i class="la la-calendar-check-o"></i>
													</span>
												</div>
											</div>
										

								</div>
							</div>

						</div>

						<div class="m-form__section">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">
									Mailing Address
									<i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i>
								</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Address Line</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="address" class="form-control m-input" placeholder="" >
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* pincode:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="pincode" class="form-control m-input pincode" placeholder="" >
								</div>
							</div>
							
							
							<div class="form-group m-form__group row ajrow">
								<label class="col-xl-3 col-lg-3 col-form-label">* City:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="loccity" class="form-control m-input" placeholder="" >
								</div>
							</div>
							<div class="form-group m-form__group row ajrow">
								<label class="col-xl-3 col-lg-3 col-form-label">* State:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="locstate" class="form-control m-input" placeholder="" >
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>

			<!--end: Form Wizard Step 1-->

			<!--begin: Form Wizard Step 2-->
			<div class="m-wizard__form-step" id="m_wizard_form_step_2">
				<!-- step 2 -->
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Official</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Offcial Email:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="offcial_email" class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Designation:</label>
								<div class="col-xl-9 col-lg-9">									
									<select class="form-control m-input"  name="designation"   id="exampleSelect1">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getDesignation();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Department</label>
								<div class="col-xl-9 col-lg-9">
									
									<select class="form-control m-input"  name="department"   id="exampleSelect1">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getDepartment();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Job Roles</label>
								<div class="col-xl-9 col-lg-9">
									
									<select class="form-control m-input"  name="jobrole"   id="exampleSelect1">
									<option value="">-SELECT-</option>
									<?php 
									$datas=AyraHelp::getJobRole();
									foreach ($datas as $key => $row) {
										
										?>
										<option value="{{$row->id}}">{{$row->name}}</option>
										<?php
									}
									?>
								   </select>

								</div>
							</div>
							
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Join Date</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="join_date"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>


							<!-- ajcode -->
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* BANK NAME</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="bank_name"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Account No.</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="account_no"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>

							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* IFSC Code.</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="ifsc_code"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>


							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Exit Date</label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group date">
										<input type="text" name="exit_date"  class="form-control m-input" readonly placeholder="Select date" id="m_datepicker_3" />
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>										

								</div>
							</div>

							<!-- ajcode -->

						</div>
						
					</div>
				</div>
				<!-- step 2 -->
			   
			</div>

			<!--end: Form Wizard Step 2-->

			<!--begin: Form Wizard Step 3-->
			<div class="m-wizard__form-step" id="m_wizard_form_step_3">
				 <!-- step code 3 -->
				 	
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="m-form__section m-form__section--first">
							<div class="m-form__heading">
								<h3 class="m-form__heading-title">Documentation</h3>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* PAN No.:</label>
								<div class="col-xl-9 col-lg-9">
									<input type="text" name="pan_no" class="form-control m-input" placeholder="">
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* PAN DOC:</label>
								<div class="col-xl-9 col-lg-9">
								<div class="custom-file">
													<input type="file" name="pan_doc" class="custom-file-input" id="customFile" name="pan_doc">
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Aadhar No. </label>
								<div class="col-xl-9 col-lg-9">
									<div class="input-group">
										
										<input type="text" name="aadhar_no" class="form-control m-input" placeholder="">
									</div>
									<span class="m-form__help"></span>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Aadhar DOC</label>
								<div class="col-xl-9 col-lg-9">
								<div class="custom-file">
													<input type="file" name="aadhar_doc"  class="custom-file-input" id="customFile" name=""aadhar_doc>
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div>
								</div>
							</div>
							
							

						</div>
						
					</div>
				</div>
				
				 <!-- step code 3 -->
			</div>

			<!--end: Form Wizard Step 3-->
		</div>

		<!--end: Form Body -->

		<!--begin: Form Actions -->
		<div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
			<div class="m-form__actions">
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-4 m--align-left">
						<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
							<span>
								<i class="la la-arrow-left"></i>&nbsp;&nbsp;
								<span>Back</span>
							</span>
						</a>
					</div>
					<div class="col-lg-4 m--align-right">
						<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
							<span>
								<i class="la la-check"></i>&nbsp;&nbsp;
								<span>Submit</span>
							</span>
						</a>
						<a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
							<span>
								<span>Save & Continue</span>&nbsp;&nbsp;
								<i class="la la-arrow-right"></i>
							</span>
						</a>
					</div>
					<div class="col-lg-2"></div>
				</div>
			</div>
		</div>

		<!--end: Form Actions -->
	</form>
</div>

<!--end: Form Wizard Form-->
</div>

<!--end: Form Wizard-->


								

			<!-- add employee -->

		</div>
		
	</div>
</div>
</div>
<!--end::Modal-->

						
						

						

						

						

						

</div>
				

				<!--</div>-->
			