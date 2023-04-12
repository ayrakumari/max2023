<?php 
$user = auth()->user();
							$userRoles = $user->getRoleNames();
							$user_role = $userRoles[0];
if($user_role=='Admin'){
$client_arr_data=AyraHelp::getClientCountbyid();
}else{
$client_arr_data=AyraHelp::getClientCountbyid(Auth::user()->id);
}
if($user_role=='Admin'){
$sample_arr_data=AyraHelp::getSampleCountbyid();
}else{
$sample_arr_data=AyraHelp::getSampleCountbyid(Auth::user()->id);

}	

use Carbon\Carbon;
if($user_role=='Admin'){
	$today_node = App\Client::where('is_deleted','!=',1)->whereDate('follow_date', Carbon::today())->orderBy('follow_date','ASC')->get();
	$yesterday_node = App\Client::where('is_deleted','!=',1)->whereDate('follow_date', Carbon::yesterday())->orderBy('follow_date','ASC')->get();
	$without_sch = App\Client::where('is_deleted','!=',1)->whereDate('follow_date', Carbon::now()->subDays(365))->orderBy('follow_date','ASC')->get();

}else{
	$today_node = App\Client::where('is_deleted','!=',1)->whereDate('follow_date', Carbon::today())->where('user_id',Auth::user()->id)->orderBy('follow_date','ASC')->get();
	$yesterday_node = App\Client::where('is_deleted','!=',1)->whereDate('follow_date', Carbon::yesterday())->where('user_id',Auth::user()->id)->orderBy('follow_date','ASC')->get();
	$without_sch = App\Client::where('is_deleted','!=',1)->where('user_id',Auth::user()->id)->whereDate('follow_date', Carbon::now()->subDays(365))->orderBy('follow_date','ASC')->get();
}




?>
	<div class="m-content">	

			
			@if (session('status'))
			<div class="alert alert-danger">
				{{ session('status') }}
			</div>
		@endif



		<?php 
		if($user_role=='Staff'){
			?>
			
			<div class="row">
				<div class="col-xl-12">
						<!--begin::Widget 29-->
						
						<!--begin::Widget 29-->
						<div class="m-widget29">
									<div class="m-widget_content">
										<h3 class="m-widget_content-title">Order Pending By Stages</h3>
										<div class="m-widget_content-items">
										<div class="m-widget_content-items">
	
										<div class="m-widget_content-item">
										<?php 
										$data=AyraHelp::getOrderStuckStatusByStageV1(1);
										
										?>
										<span>{{optional($data)->stage_name}}</span>
										<span>
										<span class="m-badge m-badge m-badge-bordered--primary">															
										<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
										<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
										</span>
										</span>
										</div>
	
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(2);
												//$qc_data_arr=AyraHelp::getPendingPurchaseStages();
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">	
	
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(3);
												
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">0</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">0</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(4);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(5);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(6);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(7);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(8);
												?>
												<span>{{$data->stage_name}}</span>
												
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(9);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(10);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(11);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(12);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(13);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>

															
											</div>
										
										</div>
										<div align="right">
												<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{  AyraHelp::LastUpdateAtStage()}}</span>
												
										</div>
									</div>
								
									
									
								</div>
								<hr>
								{{-- order value --}}
								<div id="perf_divOrderVale"></div>
								
								<?= Lava::render('ColumnChart', 'FinancesOrderValue', 'perf_divOrderVale') ?>

								{{-- order value --}}


							<!--begin::Portlet-->
				
					<div class="m-portlet m-portlet--mobile m-portlet--body-progress-" style="display:none">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Daily Report 5
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
											<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_KPILISTUser">
											<thead>
												<tr>
													<th>ID</th>			                       
													<th>Name</th>			                       																							
													<th>Status</th>																				
													<th>Actions</th>
												</tr>
											</thead>
											
										</table>

									</div>
								</div>

								<!--end::Portlet-->

							
			<?php
		}
		
		
		if($user_role=='Admin' || $user_role=='SalesUser'){

			?>
			<div class="row" >
			
					<div class="col-xl-12" >
							<!--begin::Widget 29-->
							
							<?php 
							if($user_role=='Admin'){
								?>
								<div class="row m-row--no-padding m-row--col-separator-xl">				
										<div class="col-xl-12">	
											 <!-- ajcode for lead stage -->
											 <!--begin::Section-->
											 <h4>Lead Stages</h4>
										<div class="m-section">
											<div class="m-section__content">
												<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
													<thead>
															<tr>
															<th>Fresh</th>
															<th>Assigned</th>
															<th>Qualified</th>
															<th>Sampling</th>
															<th>Client</th>
															<th>Repeat Client</th>
															<th>Lost</th>
															<th>Total Lead</th>
															<th>Unqualified</th>
															<th>Irrelevant</th>
														</tr>
													</thead>
													<tbody>
													

														
														<?php 
														$lead_data = DB::table('lead_map_data')->first();							

														?>
										 <tr>
														<td>
														<b>{{$lead_data->fresh_lead}}<b>
														</td>
														<td>
														<strong>{{$lead_data->assign_lead}}</strong>
														</td>
														<td>
														<strong>{{$lead_data->qualified_lead}}</<strong>
														</td>
														<td>
														<strong>{{$lead_data->sample_lead}}</<strong>
														</td>
														<td>
														<strong>{{$lead_data->client_lead}}</strong>
														</td>
														<td>
														<strong>{{$lead_data->repeat_lead}}</strong>
														</td>
														<td>
														<strong>{{$lead_data->lost_lead}}</strong>
														</td>
														<td>
														<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
										<strong>{{$lead_data->total_lead}}</strong>
										</span>
								</span>

														
														</td>
														<td>
														<strong>{{$lead_data->unqualified_lead}}</strong>
														</td>
														<td>
														<strong>{{$lead_data->irrelevant}}</strong>
														
														<span style="margin-bottom: -35px;" class="m-badge m-badge--warning m-badge--wide">{{ date("d-M-Y h:i:s A", strtotime($lead_data->update_at) )   }}</span>

														</td>
														
														</tr>
														
														
													</tbody>
												</table>
											</div>
										</div>

										<!--end::Section-->

											 <!-- ajcode for lead stage -->
										</div>
								</div>

							<div class="m-widget29">
									<div class="m-widget_content">
										<h3 class="m-widget_content-title">Order Pending By Stages</h3>
										<div class="m-widget_content-items">
										<div class="m-widget_content-items">
	
										<div class="m-widget_content-item">
										<?php 
										$data=AyraHelp::getOrderStuckStatusByStageV1(1);
										
										?>
										<span>{{optional($data)->stage_name}}</span>
										<span>
										<span class="m-badge m-badge m-badge-bordered--primary">															
										<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
										<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
										</span>
										</span>
										</div>
	
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(2);
												//$qc_data_arr=AyraHelp::getPendingPurchaseStages();
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">	
	
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">0</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">0</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(3);
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(4);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(5);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(6);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(7);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(8);
												?>
												<span>{{$data->stage_name}}</span>
												
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(9);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(10);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(11);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(12);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(13);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>

															
											</div>
										
										</div>
										<div align="right">
												<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{  AyraHelp::LastUpdateAtStage()}}</span>
												
										</div>
									</div>						
									
									
								</div>
								<hr>
								<?php


							}
							?>
							

								{{-- order value --}}
								<div id="perf_divOrderVale"></div>
								
								<?= Lava::render('ColumnChart', 'FinancesOrderValue', 'perf_divOrderVale') ?>

								{{-- order value --}}



									<!--begin::Portlet-->
									<hr>
									<?php 
									if($user_role=='AdminU'){
										?>

					<div class="m-portlet m-portlet--mobile m-portlet--body-progress-" style="display:none">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Daily Report  
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
											<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_KPILISTUserAdmin">
											<thead>
												<tr>
													<th>ID</th>	
													<th>Avatar</th>
													<th>Name</th>
													<th>Role</th>														
													<th>Actions</th>
												</tr>
											</thead>
											
										</table>

									</div>
								</div>

								<!--end::Portlet-->
								
	
					</div>

										<?php

									}
									?>
				
					
			
			

			<?php 
			if($user_role=='SalesUser'){
			?>
			    	<?php 
							if($user_role=='SalesUser'){
								?>
								<div class="row m-row--no-padding m-row--col-separator-xl">				
										<div class="col-xl-12">	
											 <!-- ajcode for lead stage -->
											 <!--begin::Section-->
											 <h4>Lead Stages</h4>
										<div class="m-section">
											<div class="m-section__content">
												<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
													<thead>
														<tr>
															<th>Fresh Lead</th>
															<th>Qualified</th>
															<th>Sampling</th>
															<th>Client</th>
														</tr>
													</thead>
													<tbody>
													<?php
													 $data_arr_data_fresh = DB::table('indmt_data')
													 ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')           
													 ->where('lead_assign.assign_user_id', '=', Auth::user()->id)  
													 ->where('lead_assign.lead_status', 0)        
													 ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
													 ->get();

													 $data_arr_data_qualified = DB::table('indmt_data')
													 ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')           
													 ->where('lead_assign.assign_user_id', '=', Auth::user()->id)  
													 ->where('lead_assign.lead_status', 1)        
													 ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
													 ->get();

													

													 ?>
														<tr>
															<th scope="row">
															<span class="m-badge m-badge--warning">{{count($data_arr_data_fresh)}}</span>

															</th>
															<td>
															<span class="m-badge m-badge--success">{{count($data_arr_data_qualified)}}</span>
															</td>
															<td></td>
															<td></td>
														</tr>
														
														
													</tbody>
												</table>
											</div>
										</div>

										<!--end::Section-->

											 <!-- ajcode for lead stage -->
										</div>
								</div>

							<div class="m-widget29">
									<div class="m-widget_content">
										<h3 class="m-widget_content-title">Order Pending By Stages: ({{Auth::user()->name}})</h3>
										<div class="m-widget_content-items">
										<div class="m-widget_content-items">
	
										<div class="m-widget_content-item">
										<?php 
										$data=AyraHelp::getOrderStuckStatusByStageV1(1);
										
										?>
										<span>{{optional($data)->stage_name}}</span>
										<span>
										<span class="m-badge m-badge m-badge-bordered--primary">															
										<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
										<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
										</span>
										</span>
										</div>
	
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(2);
												//$qc_data_arr=AyraHelp::getPendingPurchaseStages();
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">	
	
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">0</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">0</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(3);
												
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(4);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(5);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(6);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(7);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(8);
												?>
												<span>{{$data->stage_name}}</span>
												
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(9);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(10);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(11);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(12);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStageV1(13);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>

															
											</div>
										
										</div>
										<div align="right">
												<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{  AyraHelp::LastUpdateAtStage()}}</span>
												
										</div>
									</div>						
									
									
								</div>
								<hr>
								<?php


							}
							?>


		
		
			
	


					
		<div class="m-portlet">
		
				<div class="m-portlet__body  m-portlet__body--no-padding">
					<div class="row m-row--no-padding m-row--col-separator-xl">
						
							<div class="col-xl-12">							
	
								<div id="perf_div"></div>
					
								<?= Lava::render('ColumnChart', 'Finances', 'perf_div') ?>
								
								</div>
								<hr>
	
								
							
						
						
						
					</div>
				</div>
			</div>
			
			<div class="m-portlet">
			
				<div class="m-portlet__body  m-portlet__body--no-padding">
					<div class="row m-row--no-padding m-row--col-separator-xl">
						
						<div class="col-xl-12">							
	
							<div id="perf_div_sample"></div>
				
							<?= Lava::render('ColumnChart', 'SampleFeeback', 'perf_div_sample') ?>
							
							</div>
	
								
							
						
						
						
					</div>
				</div>
			</div>
	
			
	<!--begin:: Widgets/Daily Sales-->
	
							<div class="m-widget14">
								<div class="m-widget14__header m--margin-bottom-30">
									<h3 class="m-widget14__title">
										Last 30 days Sample Added Graph
									</h3>
									<span class="m-widget14__desc">
										Check out each collumn for more details
									</span>
								</div>
								<div class="m-widget14__chart" style="height:120px;">
									<canvas id="m_chart_daily_sales"></canvas>
								</div>
							</div>						
	
			<!--End::Section-->
			<div class="row" style="display:none">
				<div class="col-xl-12">
					<div id="chart-div"></div>
					<?= Lava::render('PieChart', 'IMDB', 'chart-div') ?>
				</div>
				
			</div>
			

			<?php

		}
		

			?>


			<div class="row">
					<div class="col-xl-4">
						<!--begin::Preview-->
						<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
								<div class="m-demo__preview">
										<ul class="m-nav">
												<li class="m-nav__section m-nav__section--first">
													<span class="m-nav__section-text">Clients</span>
												</li>
												<li class="m-nav__item">
												<a href="{{ route('client.index')}}" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">Total </span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--info m-badge--wide">{{ $client_arr_data['total']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
												<li class="m-nav__item">
														<a href="{{ route('client.leads')}}" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">LEAD</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{ $client_arr_data['lead']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
												<li class="m-nav__item">
														<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-box"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">SAMPLING</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{ $client_arr_data['sampling']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
	
												<li class="m-nav__item">
														<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">CUSTOMER</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{ $client_arr_data['customer']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>	
																						
												
												
											</ul>
											
	
									
								</div>
								
							</div>
	
							<!--end::Preview-->
							<!--begin::Widget 29-->
							<?php
	if($user_role=='Admin'){
		?>
			<div class="m-widget29">
					<div class="m-widget_content">
						<h3 class="m-widget_content-title">Samples pending for dispatch since</h3>
						<div class="m-widget_content-items">
							<div class="m-widget_content-item">
								<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">3 Days</span>
								</span>
								<span class="m--font-accent">
									{{  $spcount=AyraHelp::samplePendingDispatch(3)}}
								</span>
							</div>
							<div class="m-widget_content-item">
								<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">7 Days</span>
								</span>
								<span class="m--font-brand">
										{{  $spcount=AyraHelp::samplePendingDispatch(7)}}
								</span>
							</div>
							<div class="m-widget_content-item">
								<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">15 Days</span>
								</span>
								<span>
										{{  $spcount=AyraHelp::samplePendingDispatch(15)}}
								</span>
							</div>
						</div>
					</div>
					
					
				</div>

				<!--end::Widget 29-->
		<?php
	}

	 ?>

							
	
	
					</div>
						
					<div class="col-xl-4">
						<!--begin::Preview-->
						<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
								<div class="m-demo__preview">
										<ul class="m-nav">
												<li class="m-nav__section m-nav__section--first">
													<span class="m-nav__section-text">Samples</span>
												</li>
												<li class="m-nav__item">
												<a href="{{ route('sample.index')}}" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">Total </span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--info m-badge--wide">{{$sample_arr_data['total']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
												<li class="m-nav__item">
														<a href="{{ route('sample.new')}}" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">NEW</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{$sample_arr_data['new']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
												<li class="m-nav__item">
														<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">SENT</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{$sample_arr_data['sent']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>
	
												<li class="m-nav__item">
														<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-users"></i>
																<span class="m-nav__link-title">
																	<span class="m-nav__link-wrap">
																		<span class="m-nav__link-text">FEEDBACK</span>
																		<span class="m-nav__link-badge">
																			<span class="m-badge m-badge--secondary m-badge--wide">{{$sample_arr_data['feedback_addedon']}}</span>
																		</span>
																	</span>
																</span>
															</a>
												</li>										
											</ul>							
								</div>
							</div>
	
							<!--end::Preview-->
							
	
	
	
							
	
					</div>
					<div class="col-xl-4">
	
								<!--begin::Preview-->
								<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
										<div class="m-demo__preview">
												<ul class="m-nav">
														<li class="m-nav__section m-nav__section--first">
															<span class="m-nav__section-text">Follow Up</span>
														</li>
														<li class="m-nav__item">
																<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-users"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">Total </span>
																				<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--info m-badge--wide">{{ count($today_node)+count($without_sch)+count($yesterday_node)}} </span>
																				</span>
																			</span>
																		</span>
																	</a>
														</li>
														<li class="m-nav__item">
																<a href="{{ route('today.clientFollow')}}" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-users"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">Today</span>
																				<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--info m-badge--wide">{{ count($today_node)}}</span>
																				</span>
																			</span>
																		</span>
																	</a>
														</li>
														<li class="m-nav__item">
																<a href="{{ route('yestarday.clientFollow')}}" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-users"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">Yestarday</span>
																				<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--secondary m-badge--wide">{{ count($yesterday_node)}}</span>
																				</span>
																			</span>
																		</span>
																	</a>
														</li>
														<li class="m-nav__item">
																<a href="{{ route('delayed.clientFollow')}}" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-users"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">Delayed</span>
																				<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--secondary m-badge--wide">{{ count($without_sch)}}</span>
																				</span>
																			</span>
																		</span>
																	</a>
														</li>
														
			
																							
													</ul>							
										</div>
									</div>
			
									<!--end::Preview-->
	
							
					</div>
			</div>

			

			<?php
		}
			?>	
			<!-- ajcode for user dashbaor -->
			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--tab">
									

									<!--begin::Form-->
									<?php 		
									if($user_role=='User'){

										if(Auth::user()->id==112){

											$bdata=AyraHelp::getTodayBirday();
											// print_r($bdata);
											
											// die;



											?>
											<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Birthday Notification
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
									<div class="row">
										<div class="col-xl-6">
										
											<!--begin::m-widget5-->
											<div class="m-widget5">

													<?php 
														foreach ($bdata as $key => $birthUser) {
															?>
															<div class="m-widget5__item">
														
														<div class="m-widget5__content">
															<div class="m-widget5__pic">
																<img class="m-widget7__img" src="{{$birthUser['profile_pic']}}" alt="">
															</div>
															<div class="m-widget5__section">
																<h4 class="m-widget5__title">
																{{$birthUser['name']}}
																</h4>
																<span class="m-widget5__desc">
																	Happy Birthday <strong>{{$birthUser['name']}}</strong> !
																</span>
																<div class="m-widget5__info">
																	<span class="m-widget5__author">
																		Email:
																	</span>
																	<span class="m-widget5__info-label">
																	{{$birthUser['email']}}:
																	</span>
																	<br>
																	<span class="m-widget5__info-author-name">
																		Phone:
																	</span>
																	<span class="m-widget5__info-label">
																	{{$birthUser['phone']}}:
																	</span>
																
																	<span class="m-widget5__info-date m--font-info">
																	{{ date('j-M-Y', strtotime($birthUser['dob']))}}
																	</span>
																</div>
															</div>
														</div>
														
													</div>
															<?php
														}
														?>

													
													
													
												</div>

												<!--end::m-widget5-->

										</div>
										<div class="col-xl-6" style="display:none">
										<?php 
										$dataList_arr=AyraHelp::getBirthdayList(10);
										//echo "<pre>";
										//print_r($dataList_arr);

										?>

										<div class="m-widget3">
											<div class="m-widget3__item">
												<div class="m-widget3__header">
													<div class="m-widget3__user-img">
														<img class="m-widget3__img" src="assets/app/media/img/users/user1.jpg" alt="">
													</div>
													<div class="m-widget3__info">
														<span class="m-widget3__username">
															Melania Trump
														</span><br>
														<span class="m-widget3__time">
															2 day ago
														</span>
													</div>
													<span class="m-widget3__status m--font-info">
														Pending
													</span>
												</div>
												<div class="m-widget3__body">
													<p class="m-widget3__text">
														Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.
													</p>
												</div>
											</div>
									</div>

											

										</div>
									</div>

									</div>
								</div>

											<?php
										}
											?>
											<!--begin::Portlet-->
					
								<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Daily Report
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
											<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_KPILISTUser">
											<thead>
												<tr>
													<th>ID</th>				                       
													<th>Name</th>							
													<th>Status</th>																				
													<th>Actions</th>
												</tr>
											</thead>
											
										</table>
									</div>
								</div>

								<!--end::Portlet-->
											<?php
									}
									?>
															

									<!--end::Form-->
								</div>

								<!--end::Portlet-->
								
			<!-- ajcode for user dashbaor -->
		
			

	
	

		
		
		<!--End::Section-->
	</div>



<!--begin::Modal-->
<div class="modal fade" id="m_modal_dailyReportSubmit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Work Report</h5>
										
										

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									<!-- ajcode -->
									<!--begin::Form-->
									<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_KPIDataSubmitReport">
										@csrf
										<div class="m-portlet__body">
											<div class="m-form__section m-form__section--first">
												
												<div class="form-group m-form__group row">											
									
												   

													<div class="col-lg-4">
													<label class="form-control-label">Date:</label>
													<div class="input-group date">
													
														<input type="text" name="kpi_date" class="form-control m-input" readonly  id="m_datepicker_3" />
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
														</div>
													</div>

													</div>
											
													<div class="col-lg-8">
														<label class="form-control-label">*Major Goal for <b> {{Date('F')}} :</label>
														<input type="text" name="goal_for_month" class="form-control m-input" placeholder="" value="">
													</div>
												</div>
												<div class="form-group m-form__group row">
													<div class="col-lg-12">
														<label class="form-control-label">* Major Goal for <b> {{Date('j F ')}}</label>
														<input type="text" name="goal_for_today" class="form-control m-input" placeholder="" value="">
													</div>
												</div>
												
											</div>
											
											<div class="form-group m-form__group row">


											
											<?php 
											   $user = auth()->user();
											   $userRoles = $user->getRoleNames();
											   $user_role = $userRoles[0];
											   if($user_role=='SalesUser'){
												 $where_role='SALES';
											   }
											  if($user_role=='Staff'){
												$where_role='STAFF';
											  }
											  if($user_role=='Admin'){
												$where_role='STAFF';
											  }
											  if($user_role=='CourierTrk'){
												$where_role='STAFF';
											  }
											  if($user_role=='User'){
												$where_role='STAFF';
											  }

											$kpi_data=AyraHelp::getKPIBYRole($where_role);
											$kpi_data=AyraHelp::getKPIBYUser(Auth::user()->id);
											if(count($kpi_data)>0){

										

											foreach ($kpi_data as $key => $row) {
												
												?>
												<div class="col-lg-4">
													<label>KPI:</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" value="{{optional($row)->kpi_detail}}"  name="kpi_details[]" class="form-control m-input" placeholder="">
													
													</div>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label class="">Achievement(Number only):</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" class="form-control m-input" name="kpi_number[]"  placeholder="">
														
													</div>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label class="">Hours Spend:</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" class="form-control m-input" name="kpi_spendhour[]" placeholder="">
														
													</div>
													<span class="m-form__help"></span>
												</div>

												<?php
											}
										}
											?>
												

											</div>
											<!-- ajaykumar -->
											<div id="m_repeater_2">
													<div class="form-group  m-form__group row">
														
														<div data-repeater-list="taskAks" class="col-lg-12">
															<div data-repeater-item class="m--margin-bottom-10">
															<div class="row">
																<div class="col-lg-4">
																	<div class="form-group">																	
																		
																		<div class="m-input-icon m-input-icon--right">
																			<input type="text" name="task_v1" placeholder="Task " class="form-control m-input" placeholder="">																		
																		</div>
																		<span class="m-form__help"></span>
																	</div>

																</div>
																<div class="col-lg-2">
																	<div class="form-group">																	
																		
																		<div class="m-input-icon m-input-icon--right">
																			<input type="text" name="task_qty_v1" placeholder="Achievement(Number only):"  class="form-control m-input" placeholder="">																		
																		</div>
																		<span class="m-form__help"></span>
																	</div>

																</div>
																<div class="col-lg-2">
																<div class="form-group">																	
																		
																		<div class="m-input-icon m-input-icon--right">
																			<input type="text" name="task_spend_hour_v1" placeholder="Hours Spend" class="form-control m-input" placeholder="">																		
																		</div>
																		<span class="m-form__help"></span>
																	</div>
																</div>
																<div class="col-md-4">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>Delete</span>
																</span>
															</div>
														</div>
																
															</div>

															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-3"></div>
														<div class="col">
															<div data-repeater-create="" class="btn btn btn-warning m-btn m-btn--icon">
																<span>
																	<i class="la la-plus"></i>
																	<span>Add More</span>
																</span>
															</div>
														</div>
													</div>
											</div>
											<!-- ajaykumar -->

											<!-- <div class="form-group m-form__group row">								
											
											
											
												<div class="col-lg-4">
													<label>Task Discrption:</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" name="kpi_other_discption"  class="form-control m-input" placeholder="">
													
													</div>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
												<label class="">Achievement(Number only):</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" name="kpi_other_acthmentNo" class="form-control m-input" placeholder="">
														
													</div>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label class="">Hours Spend:</label>
													<div class="m-input-icon m-input-icon--right">
														<input type="text" name="kpi_other_spendHour"  class="form-control m-input" placeholder="">
														
													</div>
													<span class="m-form__help"></span>
												</div>

												

											</div> -->

											<div class="form-group m-form__group row m--margin-top-10">
												<label class="col-form-label col-lg-3 col-sm-12">Remarks (Optional)</label>
												<div class="col-lg-9 col-md-9 col-sm-12">
												  <textarea name="kpi_remarks" id="" cols="30" rows="2" class="form-control"></textarea>
												</div>
											</div>


											
											
											
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions">
												<div class="row">
													<div class="col-lg-12">
														<button type="submit" class="btn btn-accent">Submit Report</button>
													
													</div>
												</div>
											</div>
										</div>
									</form>

									<!--end::Form-->


									<!-- ajcode -->



								
							</div>
						</div>

						<!--end::Modal-->



<!-- work history -->

