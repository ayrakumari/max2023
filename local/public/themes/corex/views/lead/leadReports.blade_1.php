<!-- main  -->
<div class="m-content">

	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Leads Reports
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{route('home')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
							<span>
								<i class="la la-arrow-left"></i>
								<span>Home </span>
							</span>
						</a>
					</li>

				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<ul class="nav nav-pills" role="tablist">
				<li class="nav-item ">
					<a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
						<i class="la la-gear"></i>
						Assign Leads </a>
				</li>

				<li class="nav-item">
					<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
						<i class="flaticon-users-1"></i>
						Irrelevant Irrelevant
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " data-toggle="tab" href="#m_tabs_3_4">
						<i class="flaticon-users-1"></i>
						Lead Action
					</a>
				</li>

			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
					<?php
					//echo "<pre>";
					$lead_data = AyraHelp::getLeadDistribution();
					//  print_r($lead_data);






					?>
					<!--begin::Section-->
					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<h3 class="m-portlet__head-text">
										Lead Distribution Table
									</h3>
								</div>
							</div>
						</div>

						<div class="m-section">
							<div class="m-section__content">
								<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
									<thead>

										<tr>
											<th>Name</th>
											<th>Assigned</th>
											<th>Qualified</th>
											<th>Sampling</th>
											<th>Client</th>
											<th>Repeat Client</th>
											<th>Lost</th>
											<th>Total Lead</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($lead_data as $key => $row) {
										?>
											<tr>
												<th scope="row">
													<a href="#" class="m-nav__link m-dropdown__toggle">
														<span class="m-topbar__userpic">
															<img src="{{$row['profilePic']}}" class="m--marginless" width="30" alt="">
														</span>
														<span class="m-topbar__username m--hide">Aayush </span>
													</a>
													<b>{{$row['sales_name']}}</b>
												</th>
												<td>{{$row['stage_1']}}</td>
												<td>{{$row['stage_2']}}</td>
												<td>{{$row['stage_3']}}</td>
												<td>{{$row['stage_4']}}</td>
												<td>{{$row['stage_5']}}</td>
												<td>{{$row['stage_6']}}</td>
												<td>{{$row['stage_totoal']}}</td>
											</tr>
										<?php
										}
										?>





									</tbody>
								</table>

							</div>
						</div>


						<!--end::Section-->



					</div>


				</div>

				<div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
					under construction f



				</div>

				<div class="tab-pane " id="m_tabs_3_4" role="tabpanel">
					<!-- ajcode -->


					<div id="perf_div"></div>

					<?= Lava::render('ColumnChart', 'BOLEAD_G1', 'perf_div') ?>



					<!-- ajcode -->

				</div>

			</div>
			<!-- end tab -->
		</div>
	</div>


</div>
<!-- main  -->