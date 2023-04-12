<!-- main  -->
<div class="m-content">
  
<!--begin::Portlet-->
<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													PLan Sheet
												</h3>
											</div>
										</div>
                                        <div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="javascript::void(0)" id="btnPrintPlanList" class="btn btn-info  m-btn--custom m-btn--icon">
												<span>
													<i class="la la-print"></i>
													<span>PRINT</span>
												</span>
											</a>
										</li>
										<li class="m-portlet__nav-item"></li>

									</ul>
							</div>
									</div>
									<div class="m-portlet__body">
									<?php 
								      $segmentID = Request::segment(2);
									
										$data=AyraHelp::getAllPlanDataByPlanID($segmentID);
																			
										$plan_arr=AyraHelp::getPlanOpertionCatID($data['plan_data']->plan_type);
										

																	

										?>
                                    <div id="div_printme"> 
                                   
										<!--begin::Section-->
										<div class="m-section">
											<div class="m-section__content">
                                            
												<table class="table table-bordered m-table m-table--border-brand" style="border: 1px solid #000;">
													<thead>
														<tr>
															<th>Date: <strong>{{date('j-M-Y', strtotime($data['plan_data']->plan_date))}}</strong></th>
															<th>Plan Type:<strong>{{$plan_arr->plan_name}}</strong></th>
															<th>Man Power:<strong>{{$data['plan_data']->manpower_expected}}</th>
															<th>Shift Hour <strong>{{$data['plan_data']->shift_work_hour}}</th>
															<th></th>
														</tr>
													</thead>
													
												</table>
											</div>
										</div>

										<!--end::Section-->
                                        <!--begin::Section-->
										
										
											
												<table  class="table table-bordered m-table m-table--border-brand" border="1" cellpadding="0"  cellspacing="0">
													<thead>
														<tr>
															<th>Order ID</th>
															<th>Name</th>
															<th>Operation</th>
															<th>Manpower Alloted</th>
															<th>Hour Alloted</th>
															<th>Manhours Alloted</th>
															<th>Achievable Qty</th>
														</tr>
													</thead>
													<tbody>
													<?php 
													$i=0;
													$j=0;
													foreach ($data['planDay4_data'] as $key => $value) {
														
														$myqc_data=AyraHelp::getQCFormDate($value->form_id);
														$orderid=$myqc_data->order_id."/".$myqc_data->subOrder;
														
														$option_data=AyraHelp::getOperationalHealthBYid($value->operation_id);
														$j=$j+$value->man_hr_req;
														?>
														<tr>
															<th scope="row">{{$orderid}}</th>
															<td>{{$myqc_data->brand_name}}</td>
															<td>{{$option_data->operation_name}}-{{$option_data->operation_product}}</td>
															<td>{{$value->mp_alloted}}</td>
															<td>{{$value->h_alloted}}</td>
															<td>{{$value->man_hr_req}}</td>														
																											
															<td>{{$value->achive_qty}}</td>														
															</tr>

														<?php

													}
													


													?>
													<tr>
															<th scope="row"></th>
															<td></td>
															<td></td>
															<td colspan="2"> Total Alloted Hour</td>
															
															<td><strong>{{$j}}</strong></td>														
																											
															<td></td>														
															</tr>
														
													</tbody>
												</table>
										
										<!--end::Section-->

										</div>

										
									</div>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->


</div>
<!-- main  -->


