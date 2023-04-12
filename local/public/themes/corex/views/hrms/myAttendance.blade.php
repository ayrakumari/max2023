
<!-- BEGIN: Subheader -->

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	My Attendance
																</h3>
															</div>
														</div>
														

														
													</div>
													<div class="m-portlet__body">
														
									<!--begin: Search Form -->
									<form class="m-form m-form--fit m--margin-bottom-20">
										<div class="row m--margin-bottom-20">
											
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

                                            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                            <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px;">
													<span>
														<i class="la la-search"></i>
														<span>Search</span>
													</span>
												</button>

                                                <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
													<span>
														<i class="la la-close"></i>
														<span>Reset</span>
													</span>
												</button>

											</div>

											
										</div>
										
									
									</form>




														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_rawAttenMAsterMyAtten">
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