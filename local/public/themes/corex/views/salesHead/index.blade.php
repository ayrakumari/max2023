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
<div class="m-content">


	@if (session('status'))
	<div class="alert alert-danger">
		{{ session('status') }}
	</div>
	@endif







	<div class="row">

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
									<b>{{optional($lead_data)->fresh_lead}}<b>
								</td>
								<td>
									<strong>{{optional($lead_data)->assign_lead}}</strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->qualified_lead}}</<strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->sample_lead}}</<strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->client_lead}}</strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->repeat_lead}}</strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->lost_lead}}</strong>
								</td>
								<td>
									<span>
										<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
											<strong>{{optional($lead_data)->total_lead}}</strong>
										</span>
									</span>


								</td>
								<td>
									<strong>{{optional($lead_data)->unqualified_lead}}</strong>
								</td>
								<td>
									<strong>{{optional($lead_data)->irrelevant}}</strong>
									<span style="margin-bottom: -35px;" class="m-badge m-badge--warning m-badge--wide">{{ date("d-M-Y h:i:s A", strtotime(optional($lead_data)->update_at) )   }}</span>
								</td>

							</tr>

						</tbody>
					</table>
				</div>
			</div>

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

				<!-- order value  -->
{{-- order value --}}
				<div id="perf_divOrderVale"></div>

				<?= Lava::render('ColumnChart', 'FinancesOrderValue', 'perf_divOrderVale') ?>

				{{-- order value --}}

				<hr>
				<figure class="highcharts-figure">
					<div id="containerB"></div>
					<p class="highcharts-description">
						This chart show total payment received monthly
					</p>
				</figure>

				<!-- order value  -->

			<!--end::Section-->

			<!-- ajcode for lead stage -->

			<div class="col-xl-12">
			<style>
				#chartdiv_LeadQualified {
					width: 100%;
					height: 200px;
				}
			</style>
			<div class="m-portlet m-portlet--mobile">
				<!-- graph -->
				<div class="row" id="chart_div_1">
				</div>
				<hr>
				<div class="row" id="chart_div_3">

				</div>
				<hr>
				<div class="row" id="chart_div_knowRecv_saleswise">

				</div>
				<hr>
				<div class="row" id="chart_div_knowRecv">

				</div>
				<hr>
				<div class="row" id="chart_div_knowOutv">

				</div>
				<hr>
				<div class="row" id="chart_div_KnowMissedCall_AJ999">

				</div>
				<hr>

				<div class="row" id="chart_div_2">

				</div>


				<div class="row" id="chart_div_4">

				</div>
				<hr>
				<div class="row" id="chart_div_BUYLEAD_ALL_API">

				</div>
				<hr>
				<!-- graph -->
			</div>
		</div>



		<!-- fina -->
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

		<!-- fina -->
		<!-- sample  -->
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
		<div id="chartdiv_LeadQualified"></div>
		<!-- <div id="chartdiv"></div> -->

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





		</div>
	</div>
</div>