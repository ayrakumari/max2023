
<!-- BEGIN: Subheader -->

          <!-- main  -->
          <div class="m-content">
		<?php
		$user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];

		 
		  ?>

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Employee Attendance
																</h3>
															</div>
														</div>
														@if ($errors->any())
															@foreach ($errors->all() as $error)
																<div>{{$error}}</div>
															@endforeach
														@endif

														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
																<!-- <li class="m-portlet__nav-item">
																	<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-cart-plus"></i>
																			<span>Add New </span>
																		</span>

																	</a>
																</li> -->
																<?php 
																 
																 if($user->hasPermissionTo('import-attendance')){
																	?>
																	<li class="m-portlet__nav-item">
																	<a href="javascript::void(0)" id="btnImportSample"  class="btn btn-accent m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-cart-plus"></i>
																			<span>Import Data </span>
																		</span>
																	</a>
																</li>
																	<?php
																 }
																?>
																

																<!-- <li class="m-portlet__nav-item">
																	<a href="{{route('export_sample_attendace')}}"  class="btn btn-accent m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-cart-plus"></i>
																			<span>Download Sample </span>
																		</span>
																	</a>
																</li> -->


															</ul>
														</div>
													</div>
													<div class="m-portlet__body">
														<!--begin::Form-->
																<form class="m-form m-form--fit m-form--label-align-right ajfileupload" action="{{ route('importAttendance') }}" method="POST" enctype="multipart/form-data">
																	<div class="m-portlet__body">
																	@csrf
																	<div class="row">
																		<div class="col-md-12">
																		<div class="form-group m-form__group">
																			<label for="exampleInputEmail1">File Browser</label>
																			<div></div>
																			<div class="custom-file">
																				<input type="file" name="file" class="custom-file-input" id="customFile">
																				<label class="custom-file-label" for="customFile">Choose file</label>
																			</div>
																		</div>

																		</div>
																		
																		
																	</div>
																		
																	</div>
																	<div class="m-portlet__foot m-portlet__foot--fit">
																		<div class="m-form__actions">
																			<button type="submit" class="btn btn-primary">Upload Now</button>
																			<button type="button" id="btnImportCancel" class="btn btn-secondary">Cancel</button>
																		</div>
																	</div>
																</form>

																<!--end::Form-->

																<!--begin: Search Form -->
									<form class="m-form m-form--fit m--margin-bottom-20">
										<div class="row m--margin-bottom-20">
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>EMP ID:</label>
												<input type="text" class="form-control m-input" placeholder="E.g: 45" data-col-index="1">
											</div>
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Name:</label>
												<input type="text" class="form-control m-input" placeholder="" data-col-index="2">
											</div>
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Month:</label>

												<select class="form-control m-input m-select2" id="m_select2_1" data-col-index="7">
													<option value="">Select</option>
                                                   
                                                    <option value="setptember">September</option>
                                                    <?php 
                                                    for($m=1; $m<=12; ++$m){   
                                                                                                             
                                                        ?>
                                                         <option value="{{date('F', mktime(0, 0, 0, $m, 1))}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                                                        <?php

                                                    }

                                                    ?>
													
												</select>
											</div>
											
										</div>
										
										<div class="m-separator m-separator--md m-separator--dashed"></div>
										<div class="row">
											<div class="col-lg-12">
												<button class="btn btn-brand m-btn m-btn--icon" id="m_search">
													<span>
														<i class="la la-search"></i>
														<span>Search</span>
													</span>
												</button>
												&nbsp;&nbsp;
												<button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
													<span>
														<i class="la la-close"></i>
														<span>Reset</span>
													</span>
												</button>
											</div>
										</div>
									</form>


					<a href="javascript::void(0)" id="btnDownLoadAttenPDF" style="margin-top:25px" class="btn btn-warning  m-btn  m-btn m-btn--icon">
							<span>
								<i class="fa fa-cloud-download-alt"></i>
								<span>Download</span>
							</span>
						</a>

									
												<br>

														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_rawAttenMAster">
															<thead>
																<tr>
																	<th>#</th>
																	<th>EMPID</th>
																	<th>EMP NAME</th>
																	<th>Present</th>
																	<th>Half Day</th>
																	<th>Fine(Less Then 9 Hour)</th>
																	<th>Holiday</th>																	
																	<th>Month</th>																	
																	<th>Actions</th>
																</tr>
															</thead>

														</table>
													</div>
												</div>

						<!-- datalist -->



					</div>
          <!-- main  -->



<!-- custom model show atten calender -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_AttenCalender" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Employee Attendance </h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			


		</div>
		<div class="modal-body">
			<!-- atten calender view -->
			<!--begin::Portlet-->
			<div class="m-portlet" id="m_portlet">									
			<div class="m-portlet__body ajviewCalender">		
				
			</div>			
			</div>
		    <!--end::Portlet-->

			<!-- atten calender view -->
		</div>
		
	</div>
</div>
</div>

<!--end::Modal-->

<!-- custom model show atten calender -->