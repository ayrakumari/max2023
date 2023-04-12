<div class="m-content">




                        <form action="{{route('kpiupdateData')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- ajcode  -->
                        <div class="row">
                        <input type="hidden" name="txtKPIID" value="{{$kpi_data->id}}">
                        
							
							<div class="col-xl-12 col-lg-12">
								<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
												
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#emp_tab_1" role="tab">
														JOB  DETAILS 
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
							
							<div class="m-portlet__body">
                                    <!-- view emp -->
									@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                <div class="row">
					<div class="col-xl-12">
						<div class="m-form__section m-form__section--first">
							
							
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Employee:</label>
								<div class="col-xl-9 col-lg-9">
									<select class="form-control m-input"  name="user_id"   id="exampleSelect1">
									<option value="">-SELECT-</option>
                                    <?php 
                                        $datas=AyraHelp::getAllUser();
                                        foreach ($datas as $key => $row) {                                    
                                           
                                            
                                            ?>
                                            <option  value="{{$row->id}}">{{$row->name}}</option>
                                            <?php
                                        }
                                        ?>
								   </select>

								</div>
							</div>



							<?php 
							/*

							?>				
							<div class="form-group m-form__group row">
								<label class="col-xl-3 col-lg-3 col-form-label">* Job Role:</label>
								<div class="col-xl-9 col-lg-9">
                                								
                                

									<select class="form-control m-input"  name="designation"   id="exampleSelect1">
									<option value="">-SELECT-</option>
                                    <?php 
                                        $datas=AyraHelp::getJobRole();
                                        foreach ($datas as $key => $row) {                                    
                                            if($kpi_data->kpi_role==$row->name){
                                                $kpir='selected';
                                            }else{
                                                $kpir='';
                                            }
                                            echo $kpir;
                                            
                                            ?>
                                            <option {{$kpir}} value="{{$row->id}}">{{$row->name}}</option>
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
                                            if($kpi_data->kpi_department==$row->name){
                                                $kpir='selected';
                                            }else{
                                                $kpir='';
                                            }
                                            echo $kpir;
                                            
                                            ?>
                                            <option {{$kpir}} value="{{$row->id}}">{{$row->name}}</option>
                                            <?php
                                        }
                                        ?>
								   </select>

								</div>
							</div>
							<?php 
							*/
							
							?>
							
							<div class="form-group m-form__group row">
							
								<label class="col-xl-2 col-lg-2 col-form-label">KPI Details</label>
								<div class="col-xl-10 col-lg-12">
                                <div id="m_repeater_3">
													<div class="form-group  m-form__group row">
														
														<div data-repeater-list="KPIData" class="col-lg-12">															
                                                            <?php 
                                                             $i=0;
                                                             foreach (json_decode($kpi_data->kpi_detail) as $key => $RowData) {
                                                                ?>
                                                                <div data-repeater-item class="row m--margin-bottom-10">
                                                                <div class="col-lg-4">
																	<div class="input-group">																		
																		<input type="text" value="{{$RowData->kpi_detail}}" name="kpi_detail" class="form-control form-control-danger" placeholder="KPI Information">
																	</div>
																</div>
																<?php 
																
																if(isset($RowData->withNumber)){
																	$RowData->withNumber[0];
																	$ch="checked";

																}else{
																	$ch="";
																}

																?>
																<div class="col-lg-3">
																<div class="m-checkbox-inline">
																	<label class="m-checkbox">
																	<input type="checkbox" <?php echo $ch; ?> name="withNumber" value="1">With Number
																	<span></span>
																	</label>
																</div>



																</div>


                                                                <div class="col-lg-3">
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<span class="input-group-text">
																				<i class="la la-link"></i>
																			</span>
																		</div>
																		<select name="kpi_code" id="" class="form-control">
                                                                        <option value="">-SELECT-</option>
                                                                            <?php 
                                                                            $datas=AyraHelp::kpi_matrix_data();
                                                                            foreach ($datas as $key => $row) {                                                                               
                                                                                ?>
                                                                                <option <?php  echo $RowData->kpi_code==$row->matrix_code ? 'selected':'' ?> value="{{$row->matrix_code}}">{{$row->matix_name}}</option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        

																	</div>
																</div>
                                                                <div class="col-lg-2">
																	<a href="#" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
																		<i class="la la-remove"></i>
																	</a>
																</div>
                                                                </div>

                                                                <?php

                                                             }  
                                                            ?>
																
																
																
															
														</div>
													</div>
													<div class="row">
														<div class="col-lg-3"></div>
														<div class="col">
															<div data-repeater-create="" class="btn btn btn-primary m-btn m-btn--icon">
																<span>
																	<i class="la la-plus"></i>
																	<span>Add</span>
																</span>
															</div>
														</div>
													</div>
												</div>
                                            </div>
									



                                        
									

							


								</div>
							</div>

						</div>
						
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
														<button type="reset" class="btn btn-secondary">Cancel</button>
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
			