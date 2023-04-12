<?php

$user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];
if ($user_role == 'Admin') {
	$client_arr_data = AyraHelp::getClientCountbyid();
} else {
	$client_arr_data = AyraHelp::getClientCountbyid(Auth::user()->id);
}
if ($user_role == 'Admin') {
	$sample_arr_data = AyraHelp::getSampleCountbyid();
} else {
	$sample_arr_data = AyraHelp::getSampleCountbyid(Auth::user()->id);
}

use Carbon\Carbon;

if ($user_role == 'Admin') {
	$today_node = App\Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::today())->orderBy('follow_date', 'ASC')->get();
	$yesterday_node = App\Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::yesterday())->orderBy('follow_date', 'ASC')->get();
	$without_sch = App\Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::now()->subDays(365))->orderBy('follow_date', 'ASC')->get();
} else {
	$today_node = App\Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::today())->where('user_id', Auth::user()->id)->orderBy('follow_date', 'ASC')->get();
	$yesterday_node = App\Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::yesterday())->where('user_id', Auth::user()->id)->orderBy('follow_date', 'ASC')->get();
	$without_sch = App\Client::where('is_deleted', '!=', 1)->where('user_id', Auth::user()->id)->whereDate('follow_date', Carbon::now()->subDays(365))->orderBy('follow_date', 'ASC')->get();
}




?>

<?php
$user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];


?>

<style>
	.show-read-more .more-text {

		display: none;

	}
</style>

<?php
if ($user_role == "Admin") {

?>
	<div class="m-content" style="display:block">
		<!-- old  -->
		<div class="row">

			<div class="col-xl-12">
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
				<!-- order  -->
				<div class="m-widget29">
					<div class="m-widget_content">
						<h3 class="m-widget_content-title">Order Pending By Stages</h3>
						<div class="m-widget_content-items">
							<div class="m-widget_content-items">

								<div class="m-widget_content-item">
									<?php
									$data = AyraHelp::getOrderStuckStatusByStageV1(1);

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

				<!-- order 1 -->
				
				
				<figure class="highcharts-figure">
					<div id="containerTotalOrderMonthly"></div>
					<p class="highcharts-description">
						This above chart show total Orders monthly
					</p>
				</figure>
				<!-- order value 1 -->

				<hr>
				<figure class="highcharts-figure">
					<div id="containerB"></div>
					<p class="highcharts-description">
						This above chart show total payment received monthly
					</p>
				</figure>

				<!-- order value  -->


			</div>
		</div>
		<!-- old  -->
		<div class="col-xl-12">
			
			<div class="m-portlet m-portlet--mobile">
				<!-- graph -->
				
				<hr>
				<!-- graph -->
			</div>
		</div>


		<!-- new add  -->
		<!-- fina -->
		
		<!-- fina -->
		<!-- sample  -->
		
		
	

		<!-- sample  -->
		<!-- row view  -->
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
				if ($user_role == 'Admin5') {
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
										{{ $spcount=AyraHelp::samplePendingDispatch(3)}}
									</span>
								</div>
								<div class="m-widget_content-item">
									<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">7 Days</span>
									</span>
									<span class="m--font-brand">
										{{ $spcount=AyraHelp::samplePendingDispatch(7)}}
									</span>
								</div>
								<div class="m-widget_content-item">
									<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">15 Days</span>
									</span>
									<span>
										{{ $spcount=AyraHelp::samplePendingDispatch(15)}}
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

		<!-- row view  -->

		<!-- new add  -->


	<?php
} //admin end

	?>


	<?php
	if ($user_role == 'Admin') {
	?>
		<hr>
		<div id="perf_div_sample"></div>

		<?= Lava::render('ColumnChart', 'SampleFeeback', 'perf_div_sample') ?>

	</div>
	<hr>
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
	<hr>

	<div class="m-widget29">
		<div class="m-widget_content">
			<h3 class="m-widget_content-title">Samples pending for dispatch since</h3>
			<div class="m-widget_content-items">
				<div class="m-widget_content-item">
					<span>
						<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">3 Days</span>
					</span>
					<span class="m--font-accent">
						{{ $spcount=AyraHelp::samplePendingDispatch(3)}}
					</span>
				</div>
				<div class="m-widget_content-item">
					<span>
						<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">7 Days</span>
					</span>
					<span class="m--font-brand">
						{{ $spcount=AyraHelp::samplePendingDispatch(7)}}
					</span>
				</div>
				<div class="m-widget_content-item">
					<span>
						<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">15 Days</span>
					</span>
					<span>
						{{ $spcount=AyraHelp::samplePendingDispatch(15)}}
					</span>
				</div>
			</div>
		</div>


	</div>

	<!--end::Widget 29-->
<?php
	}

?>


<!-- main  -->
<?php
if ($user_role == "SalesUser") {
?>
	<div class="m-content" style="display:block">
		<!-- graph -->
		<!-- graph -->
		<div class="col-xl-12">
			<!-- paymen and order value  -->
			<figure class="highcharts-figure">
				<div id="containerAD"></div>
				<p class="highcharts-description">
					This chart is showing the order values and Actual Payment Recieved of last 30 days
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
			<figure style ="display:block" class="highcharts-figure">
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

<!--begin::Modal-->
<div class="modal fade" id="m_modal_ViewINDMartData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<div class="modal-content">
			<div class="modal-body ">

				<!--begin::Portlet-->
				<div class="m-portlet">

					<div class="m-portlet__body">
						<ul class="nav nav-pills nav-fill" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#m_tabs_5_1">LEAD INFO</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#m_tabs_5_2">HISTORY </a>
							</li>
							<li class="nav-item">
								<a class="nav-link disabled" data-toggle="tab" href="#m_tabs_5_3"></a>
							</li>
							<li class="nav-item">
								<a class="nav-link disabled" data-toggle="tab" href="#m_tabs_5_4"></a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="showINDMartData tab-pane active " id="m_tabs_5_1" role="tabpanel">

							</div>
							<div class="showINDMartData_HIST tab-pane" id="m_tabs_5_2" role="tabpanel">
								It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of - Lorem Ipsum passages, and more
								recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
							</div>
							<div class="tab-pane" id="m_tabs_5_3" role="tabpanel">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
								specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
							</div>
							<div class="tab-pane" id="m_tabs_5_4" role="tabpanel">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
								specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
								industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
							</div>
						</div>
					</div>
				</div>

				<!--end::Portlet-->

			</div>

		</div>
	</div>
</div>

<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadNotesAddedList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body listaddednoteslist">

			</div>

		</div>
	</div>
</div>

<!--end::Modal-->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadAssignModel_ToOther" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Assignment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_ID_ToOther">
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Sales Person:</label>
						<select class="form-control m-input" id="assign_user_id_toOther">
							<option value="">-SELECT-</option>

							<option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>


						</select>

					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="assign_msg_ToOther"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnAssign_ToOther">Assign Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadAssignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Assignment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_ID">
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Sales Person:</label>
						<select class="form-control m-input" id="assign_user_id">

							<option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>

						</select>

					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="assign_msg"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnAssign">Assign Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal UnQualified -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadUnQliFiedModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead UnQualifed</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_IDA_UNQLI">
					<div class="form-group">
						<label for="message-text" class="form-control-label">Unqualified Type:</label>
						<select name="unqlified_type" id="unqlified_type" class="form-control">
							<option value="">--SELECT--</option>
							<?php
							$arr_data = DB::table('iIrrelevant_type')->get();
							foreach ($arr_data as $key => $rowData) {
							?>
								<option value="{{$rowData->id}}">{{$rowData->Irrelevant_name}}</option>
							<?php
							}

							?>
						</select>

					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtMessageUnQLiFiedReponse"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSubmitUnQlifiedResponse">Submit Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->







<!-- m_modal_LeadVerifytModel -->
<div class="modal fade" id="m_modal_LeadVerifytModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Verification</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_IDAVri">
					<div class="form-group">
						<label for="message-text" class="form-control-label">Type:</label>
						<select name="iIrrelevant_typeVri" id="iIrrelevant_typeVri" class="form-control">
							<option value="6">Verified</option>
						</select>

					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtMessageIreeReponseVri"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSubmitLeadResponseVerify">Submit Now</button>
			</div>
		</div>
	</div>
</div>
<!-- m_modal_LeadVerifytModel -->

<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadIrrelevantModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Irrelevant</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_IDA">
					<div class="form-group">
						<label for="message-text" class="form-control-label">Irrelevant Type:</label>
						<select name="iIrrelevant_type" id="iIrrelevant_type" class="form-control">
							<option value="">--SELECT--</option>

							<?php
							$arr_data = DB::table('iIrrelevant_type')->get();
							foreach ($arr_data as $key => $rowData) {
							?>
								<option value="{{$rowData->id}}">{{$rowData->Irrelevant_name}}</option>
							<?php
							}

							?>
						</select>

					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtMessageIreeReponse"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSubmitLeadResponse">Submit Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->

<!-- Modal -->
<div class="modal fade" id="m_modal_LeadAddNotesModel_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Lead Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="QUERY_IDB_sales">
				<div class="form-group">
					<label for="message-text" class="form-control-label">*Message:</label>
					<textarea class="form-control" id="txtNotesLead" name="txtNotesLead"></textarea>
				</div>

				<div class="form-group m-form__group">
					<label>Next Follow Up</label>
					<div class="input-group">
						<input type="text" readonly id="shdate_input" class="form-control" aria-label="Text input with dropdown button">
						<div class="input-group-append">
							<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="la la-calendar glyphicon-th"></i>
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="javascript::void(0)" id="aj_today">Today</a>
								<a class="dropdown-item" href="javascript::void(0)" id="aj_3days">3 Days</a>
								<a class="dropdown-item" href="javascript::void(0)" id="aj_7days">7 Days</a>
								<a class="dropdown-item" href="javascript::void(0)" id="aj_15days">15 Days</a>
								<a class="dropdown-item" href="javascript::void(0)" id="aj_next_month">Next Month</a>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnLeadNotesSales" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- m_modal_6 -->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadAddN5otesModel_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Notes :Sales</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_IDB_sales">
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtMessageNoteReponse_sales"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="bt6nSubmitNote">Submit Note Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_LeadAddNotesModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Lead Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" id="QUERY_IDB">



					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtMessageNoteReponse"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSubmitNote">Submit Note Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_2_GeneralViewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Stage Progress</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- ajtab -->
				<style>
					.breadcrumb {
						/*centering*/
						display: inline-block;
						box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.35);
						overflow: hidden;
						border-radius: 5px;
						/*Lets add the numbers for each link using CSS counters. flag is the name of the counter. to be defined using counter-reset in the parent element of the links*/
						counter-reset: flag;
					}

					.breadcrumb a {
						text-decoration: none;
						outline: none;
						display: block;
						float: left;
						font-size: 12px;
						line-height: 36px;
						color: white;
						/*need more margin on the left of links to accomodate the numbers*/
						padding: 0 10px 0 60px;
						background: #035496;
						background: linear-gradient(#035496, #035496);
						position: relative;
					}

					/*since the first link does not have a triangle before it we can reduce the left padding to make it look consistent with other links*/
					.breadcrumb a:first-child {
						padding-left: 46px;
						border-radius: 5px 0 0 5px;
						/*to match with the parent's radius*/
					}

					.breadcrumb a:first-child:before {
						left: 14px;
					}

					.breadcrumb a:last-child {
						border-radius: 0 5px 5px 0;
						/*this was to prevent glitches on hover*/
						padding-right: 20px;
					}

					/*hover/active styles*/
					.breadcrumb a.active,
					.breadcrumb a:hover {
						background: #008031;
						background: linear-gradient(#008031, #008031);
					}

					.breadcrumb a.active:after,
					.breadcrumb a:hover:after {
						background: #008031;
						background: linear-gradient(135deg, #008031, #008031);
					}

					/*adding the arrows for the breadcrumbs using rotated pseudo elements*/
					.breadcrumb a:after {
						content: '';
						position: absolute;
						top: 0;
						right: -18px;
						/*half of square's length*/
						/*same dimension as the line-height of .breadcrumb a */
						width: 36px;
						height: 36px;
						/*as you see the rotated square takes a larger height. which makes it tough to position it properly. So we are going to scale it down so that the diagonals become equal to the line-height of the link. We scale it to 70.7% because if square's:
    length = 1; diagonal = (1^2 + 1^2)^0.5 = 1.414 (pythagoras theorem)
    if diagonal required = 1; length = 1/1.414 = 0.707*/
						transform: scale(0.707) rotate(45deg);
						/*we need to prevent the arrows from getting buried under the next link*/
						z-index: 1;
						/*background same as links but the gradient will be rotated to compensate with the transform applied*/
						background: #035496;
						background: linear-gradient(135deg, #035496, #035496);
						/*stylish arrow design using box shadow*/
						box-shadow:
							2px -2px 0 2px rgba(0, 0, 0, 0.4),
							3px -3px 0 2px rgba(255, 255, 255, 0.1);
						/*
        5px - for rounded arrows and
        50px - to prevent hover glitches on the border created using shadows*/
						border-radius: 0 5px 0 50px;
					}

					/*we dont need an arrow after the last link*/
					.breadcrumb a:last-child:after {
						content: none;
					}

					/*we will use the :before element to show numbers*/
					.breadcrumb a:before {
						content: counter(flag);
						counter-increment: flag;
						/*some styles now*/
						border-radius: 100%;
						width: 20px;
						height: 20px;
						line-height: 20px;
						margin: 8px 0;
						position: absolute;
						top: 0;
						left: 30px;
						background: #444;
						background: linear-gradient(#444, #222);
						font-weight: bold;
					}


					.flat a,
					.flat a:after {
						background: white;
						color: black;
						transition: all 0.5s;
					}

					.flat a:before {
						background: white;
						box-shadow: 0 0 0 1px #ccc;
					}

					.flat a:hover,
					.flat a.active,
					.flat a:hover:after,
					.flat a.active:after {
						background: #008080;
					}

					.ajkumar {
						/* background: gray !important; */

					}

					li:disabled {
						background: #dddddd;
					}
				</style>

				<!--begin::Section-->
				<div class="m-section">

					<div class="m-section__content">
						<table class="table table-sm m-table m-table--head-bg-brand">
							<thead class="thead-inverse">
								<tr>
									<th>#</th>
									<th>Stage Name</th>
									<th>Created at</th>
									<th>Message</th>
									<th>Completed By</th>
								</tr>
							</thead>

							<tbody class="StageActionHistory">


							</tbody>
						</table>
					</div>
				</div>

				<!--end::Section-->

			</div>
			<!-- a simple div with some links -->
			<div class="breadcrumb ajcustomProgessBar" style="text-align: center;">

			</div>




			<!-- ajtab -->

		</div>

	</div>
</div>
</div>

<!--end::Modal-->
<!-- v1 model -->