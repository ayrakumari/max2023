<div class="m-content">

						


                        <!-- ajcode  -->
                        <div class="row">
							
							<div class="col-xl-12 col-lg-12">
								<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
												
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#emp_tab_1" role="tab">
                                                        JOB ROLE
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

										
						
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
								          Job Roles:
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="javascript::void(0)"  id="btnAddEmployeeJobRole" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
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

								
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_KPILIST">
									<thead>
										<tr>
											<th>ID</th>					                       
											<th>Role</th>																					
											<th>Status</th>																				
											<th>Actions</th>
										</tr>
									</thead>
									
								</table>
							</div>
						</div>

						




											<!-- list of emp -->
										</div>
										
									
									</div>
								</div>
							</div>
						</div>
					

                        <!-- ajcode  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_AddEmployeeJobRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="exampleModalLabel">Add New Job Role</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			
			<!-- add employee -->
            <!--begin::Form-->
									<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_KPIData" action="{{route('saveKPIData')}}" method="post">
                                    @csrf
										<div class="m-portlet__body">
											<div class="m-form__section m-form__section--first">
												<div class="m-form__heading">
													<h3 class="m-form__heading-title">Job Entry</h3>
												</div>


												<div class="form-group m-form__group row">
												<div class="col-lg-12">
														<label class="form-control-label">* Employee:</label>
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
												

												?>
												<div class="form-group m-form__group row">
												<div class="col-lg-12">
														<label class="form-control-label">* Job Roles:</label>
														<select class="form-control m-input"  name="job_role"   id="exampleSelect1">
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
													<div class="col-lg-12">
														<label class="form-control-label">* Department:</label>
														<select class="form-control m-input"  name="department_data"   id="exampleSelect1">
																<option value="">-SELECT-</option>
																<?php 
																$datas=AyraHelp::getDepartment();
																foreach ($datas as $key => $row) {
																	
																	?>
																	<option value="{{$row->name}}">{{$row->name}}</option>
																	<?php
																}
																?>
														</select>
													</div>
												</div>
												

												
												</div>
											</div>
                                            <br>
                                            <div id="m_repeater_3">
													<div class="form-group  m-form__group row">
														<label class="col-lg-1 col-form-label">KPI:</label>
														<div data-repeater-list="KPIData" class="col-lg-12">
															<div data-repeater-item class="row m--margin-bottom-10">
																<div class="col-lg-4">
																	<div class="input-group">																		
																		<input type="text" name="kpi_detail" class="form-control form-control-danger" placeholder="KPI Information">
																	</div>
																</div>
																<div class="col-lg-3">
																<div class="m-form__group form-group">
																
																<div class="m-checkbox-inline">
																	<label class="m-checkbox">
																		<input type="checkbox" name="withNumber" value="1">With Number
																		<span></span>
																	</label>
																	
																	
																</div>
															
															</div>

																</div>																
																<div class="col-lg-3">
																	<div class="input-group">
																		
																		<select name="kpi_code" id="" class="form-control">
                                                                        <option value="">-SELECT-</option>
                                                                            <?php 
                                                                            $datas=AyraHelp::kpi_matrix_data();
                                                                            foreach ($datas as $key => $row) {                                                                               
                                                                                ?>
                                                                                <option value="{{$row->matrix_code}}">{{$row->matix_name}}</option>
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
									
								
											
										
										
										
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions">
												<div class="row">
													<div class="col-lg-12">
														<button type="submit" class="btn btn-accent">Save</button>
														<button type="reset" class="btn btn-secondary">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>

									<!--end::Form-->


								

			<!-- add employee -->

		</div>
		
	</div>
</div>
</div>
<!--end::Modal-->

						
						

						

						

						

						

</div>
				

				<!--</div>-->
			