<?php
$user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];

if ($user_role == 'Admin' || Auth::user()->id == 156 || $user_role == 'SalesHead') {
?>
	<div class="m-content">
		<div class="row">
			<div class="col-md-12">
				<!-- lead statge  -->

				<div class="m-section" style="margin-top: -25px;">
					<div class="m-section__content">

						<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
							<thead>
								<tr>
									<th>Fresh</th>
									<th>Assigned</th>
									<th>Qualified</th>
									<th>Sampling</th>
									<th>Negotiation</th>
									<th>Converted</th>
									<th>Lost</th>
									<th>Hold Lead</th>
									<th>Total Lead</th>


								</tr>
							</thead>
							<tbody>
								<tr>

									<?php
									$lead_data = DB::table('indmt_data')->where('lead_status', 0)->count();
									$lead_data_1 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 1)->count();
									$lead_data_2 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 2)->count();
									$lead_data_3 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 3)->count();
									$lead_data_4 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 4)->count();
									$lead_data_5 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 5)->count();
									$lead_data_6 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 6)->count();
									$lead_data_77 = DB::table('lead_assign')->where('created_at', ">=", '2023-08-01')->where('current_stage_id', 77)->count();

									$totLead = $lead_data_1 + $lead_data_2 + $lead_data_3 + $lead_data_4 + $lead_data_5 + $lead_data_6 + $lead_data_77;


									?>
									<td title="Total Fresh Data">
										<b>{{$lead_data}}<b>
									</td>
									<td title="Total Assigned Stage of  Sales Team">
										<b>{{$lead_data_1}}<b>
									</td>
									<td title="Total Qualified Stage of  Sales Team">
										<b>{{$lead_data_2}}<b>
									</td>
									<td title="Total Sampling Stage of  Sales Team">
										<b>{{$lead_data_3}}<b>
									</td>
									<td title="Total Negotiaton Stage of  Sales Team">
										<b>{{$lead_data_4}}<b>
									</td>
									<td title="Total Converted Stage of  Sales Team">
										<b>{{$lead_data_5}}<b>
									</td>
									<td title="Total Lost Stage of  Sales Team">
										<b>{{$lead_data_6}}<b>
									</td>
									<td title="Total Hols Flag  Sales Team">
										<b>{{$lead_data_77}}<b>
									</td>

									<td title="Total Assigned Lead Count">
										<b>{{$totLead}}<b>
												<span style="margin-bottom: -35px;" class="m-badge m-badge--warning m-badge--wide">{{ date("d-M-Y h:i:s A")    }} WEF:01-08-2022</span>
									</td>
									<?php


									?>


								</tr>


							</tbody>
						</table>
					</div>
				</div>
				<!-- lead statge  -->
				<!-- order  -->
				<?php /*
<div class="m-widget29" style="margin-top:-30px">
					<div class="m-widget_content">
						<h3 class="m-widget_content-title">Order Pending By Stages</h3>
						<div class="m-widget_content-items">
							<div class="m-widget_content-items">

								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(1);
									$form_1_data= DB::table('qc_forms')
									->where('is_deleted',0)          
									->where('dispatch_status',1)          
									->where('curr_stage_id',1)->count();


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
									$data = AyraHelp::getOrderStuckStatusByStageV1(2);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(3);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(4);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(5);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(6);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(7);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(8);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(9);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(10);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(11);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(12);
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
									$data = AyraHelp::getOrderStuckStatusByStageV1(13);
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
							<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{ AyraHelp::LastUpdateAtStage()}}</span>

						</div>
					</div>


				</div>
				*/ ?>

				<div class="m-widget29" style="margin-top:-30px">
					<div class="m-widget_content">
						<h3 class="m-widget_content-title">Order Pending By Stages</h3>
						<div class="m-widget_content-items">
							<div class="m-widget_content-items">

								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(1);
									$form_1_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 1)->count();

									$form_2_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 2)->count();

									$form_3_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 3)->count();

									$form_4_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 4)->count();

									$form_5_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 5)->count();

									$form_6_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 6)->count();

									$form_7_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 7)->count();

									$form_8_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 8)->count();

									$form_9_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 9)->count();

									$form_10_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 10)->count();

									$form_11_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 11)->count();

									$form_12_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 12)->count();

									$form_13_data = DB::table('qc_forms')
										->where('is_deleted', 0)
										->where('dispatch_status', 1)
										->where('curr_stage_id', 13)->count();




									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_1_data}}</span></a>

										</span>
									</span>
								</div>

								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(2);
									//$qc_data_arr=AyraHelp::getPendingPurchaseStages();
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_2_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(3);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_3_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(4);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_4_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(5);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_5_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(6);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_6_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(7);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_7_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(8);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_8_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(9);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_9_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(10);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_10_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(11);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_11_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
								<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(12);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_12_data}}</span></a>

										</span>
									</span>
								</div>
								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(13);
									?>
									<span>{{optional($data)->stage_name}}</span>
									<span>
										<span class="m-badge m-badge m-badge-bordered--primary">
											<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{$form_13_data}}</span></a>

										</span>
									</span>
								</div>


							</div>

						</div>
						<div align="right">
							<!-- <span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{ AyraHelp::LastUpdateAtStage()}}</span> -->
							<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{ Date('j F Y H:i:sA')}}</span>

						</div>
					</div>


				</div>

			
				<!-- order 1 -->
				<!-- order value graph -->
				<figure class="highcharts-figure">
					<div id="containerTotalOrderMonthly"></div>
					<p class="highcharts-description">
						<!-- This above chart show total Orders monthly -->
					</p>
				</figure>
				<hr>
				<figure class="highcharts-figure" style="margin-top: -25px;">
					<div id="containerB"></div>
					<p class="highcharts-description">
						<!-- This above chart show total payment received monthly -->
					</p>
				</figure>

				<figure class="highcharts-figure" style="margin-top: -25px;">
					<div id="containerBulkOrder"></div>
					<p class="highcharts-description">
						<!-- This above chart show total payment received monthly -->
					</p>
				</figure>

<hr>
<figure class="highcharts-figure" style="margin-top: -25px;">
					<div id="containerPrivateOrder"></div>
					<p class="highcharts-description">
						<!-- This above chart show total payment received monthly -->
					</p>
				</figure>
				<hr>
				
				<!-- order value graph -->
				<a href="javascript::void(0)" onclick="btnShowChart(7)"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Call Recived/Average (Last 7 days)</span></a>
				<a href="javascript::void(0)" onclick="btnShowChart(30)"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Call Recived/Average (Last 30 days)</span></a>
				<a href="javascript::void(0)" onclick="btnShowChartTotalCallReceived(30)"><span class="m-badge m-badge--brand m-badge--wide m-badge--rounded">Total Received/Missed Call (Last 30 days)</span></a>
				<a href="javascript::void(0)" onclick="btnShowChartTotalSampleAdded(30)"><span class="m-badge m-badge--primary m-primary--wide m-badge--rounded">Total Samples (Last 30 days)</span></a>



				<figure class="highcharts-figure">
					<div id="containerLast7DaysCall"></div>
					<p class="highcharts-description">

					</p>
				</figure>
				
	

			</div>
		</div>
	</div>

<?php
}
?>



<!-- sales user  -->
<?php
if ($user_role == 'SalesUser') {
?>
	<div class="m-content" style="display:block">
		<!-- graph -->
		<!-- graph -->
		<div class="col-xl-12">
			<!-- paymen and order value  -->
			<figure class="highcharts-figure">
				<div id="containerAD"></div>
				<p class="highcharts-description">
					This chart is showing the order values and Actual Payment Received of last 30 days
				</p>
			</figure>


			<div id="perf_divOrderVale"></div>

			<?= Lava::render('ColumnChart', 'FinancesOrderValue', 'perf_divOrderVale') ?>
			<hr>
			<figure class="highcharts-figure">
				<div id="containerC"></div>
				<p class="highcharts-description">
					This chart show total payment received monthly
				</p>
			</figure>
			<hr>
			<figure style="display:block" class="highcharts-figure">
				<div id="containerC_INCData"></div>
				<p class="highcharts-description">
					Values are approximate, this is under construction



				</p>
			</figure>


		</div>

		<hr>
		<div class="row" id="chart_div_2_sR">

		</div>
		<div class="row" id="chart_div_2_sRMonthly">

		</div>



		<div class="row" id="chart_div_1_s">

		</div>

		<div class="row" id="chart_div_2_s">

		</div>

		<!-- <div class="row" id="chart_div_2">

			</div> -->

		<!-- <hr>
			<div class="row" id="chart_div_2">

			</div>
				<hr>
				<div class="row" id="chart_div_3">

				</div>
				<div class="row" id="chart_div_4">

				</div>
					<hr> -->
		<!-- graph -->
		<!-- graph -->

	</div>

<?php
}
?>

<!-- sales user  -->