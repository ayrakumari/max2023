<div class="tab-pane active" id="m_tabs_3_1_Lead" role="tabpanel">
						<!-- lead panel  -->
						<?php
						$user = auth()->user();
						$userRoles = $user->getRoleNames();
						$user_role = $userRoles[0];
						if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == 134 || Auth::user()->id == 3 || Auth::user()->id == 4 || Auth::user()->id == 40) {
						?>
							<div class="m-demo__preview m-demo__preview--btn">
								<!-- <a href="javascript::void(0)" onclick="viewAllAssign_V3()" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
									<span>
										<i class="fa flaticon-users"></i>
										<span>Assigned</span>
									</span>
								</a> -->
								<a href="javascript::void(0)" onclick="viewAllIreevant_V3()" class=" btn btn-secondary btn-sm m-btn 	m-btn m-btn--icon">
									<span>
										<i class="fa flaticon-list-3"></i>
										<span>Irrelevant</span>
									</span>
								</a>
								<a href="javascript::void(0)" onclick="viewFreshLead()" class="btn btn-secondary btn-sm m-btn 	m-btn m-btn--icon">
									<span>
										<i class="fa flaticon-list"></i>
										<span>Fresh Lead</span>
									</span>
								</a>

								<a href="javascript::void(0)" onclick="viewUnQualifiedLead_V3()" class=" btn btn-info btn-sm m-btn 	m-btn m-btn--icon">
									<span>
										<i class="fa flaticon-list"></i>
										<span>Disqualified Lead</span>
									</span>
								</a>
								<a href="javascript::void(0)" onclick="viewHOLDLead_V3()" class="  btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
									<span>
										<i class="fa fa-hand-point-right"></i>
										<span>HOLD Lead</span>
									</span>
								</a>
								<a href="javascript::void(0)" onclick="viewDUPLICATELead_V3()" class=" btn btn-default btn-sm m-btn 	m-btn m-btn--icon">
									<span>
										<i class="fa fa-hand-point-right"></i>
										<b><span>DUPLICATE</span></b>
									</span>
								</a>



								<div style="margin-bottom:10px "></div>
								<style media="screen">
									.ajstage {
										display: none;

									}
								</style>

								<!--begin: Search Form -->
								<form class="m-form m-form--fit m--margin-bottom-20">
									<div class="row m--margin-bottom-20">


										<!-- <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile ajstage">
											<label><b>Stages</b></label>
											<select class="form-control m-input" data-col-index="5">
												<option value="">-SELECT- </option>
												@foreach (AyraHelp::getAllStagesLead() as $stage)
												<option value="{{  str_replace('/', '-', $stage->stage_name) }}">{{$stage->stage_name}}</option>
												@endforeach
											</select>
										</div> -->


										<!-- <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile ajstage">
											<label><b>Assigned Users</b></label>
											<select class="form-control m-input" data-col-index="6">
												<option value="">-SELECT-</option>
												<?php
												$user = auth()->user();
												$userRoles = $user->getRoleNames();
												$user_role = $userRoles[0];
												?>
												@if ($user_role =="Admin" || Auth::user()->id==77 || Auth::user()->id==90)
												@foreach (AyraHelp::getSalesAgentAdmin() as $user)
												@if ($user->id==130 || $user->id==131
												|| $user->id==78
												|| $user->id==83
												|| $user->id==85
												|| $user->id==84
												|| $user->id==87
												|| $user->id==88
												|| $user->id==89
												|| $user->id==91
												|| $user->id==93
												|| $user->id==95
												|| $user->id==98
												|| $user->id==108



												)

												@else
												<option value="{{$user->name}}">{{$user->name}}</option>
												@endif

												@endforeach
												@else
												<option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
												@endif
												<option value="DEEPIKA JOSHI">DEEPIKA JOSHI</option>

											</select>
										</div> -->



										<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
											<label><b>LEAD FROM</b></label>
											<select class="form-control m-input" data-col-index="7">
												<option value="">-SELECT-</option>
												<option value="INDIA">INDIA</option>
												<option value="FOREIGN">FOREIGN</option>
											</select>
										</div>

										<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
											<button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px">
												<span>
													<i class="la la-search"></i>
													<span>Search</span>
												</span>
											</button>

											<!-- <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
												<span>
													<i class="la la-close"></i>
													<span>Reset</span>
												</span>

											</button> -->

										</div>
										<div class="ajstage col-lg-4 m--margin-bottom-10-tablet-and-mobile">
											<div class="m-form__group form-group">
												<label for="">Radio Filter</label>
												<div class="m-checkbox-inline">
													<label class="m-checkbox">
														<input type="radio" class="ajLeadFilter" name="filLead" value="1"> IM 1
														<span></span>
													</label>
													<label class="m-checkbox">
														<input type="radio" class="ajLeadFilter" name="filLead" value="2"> IM 2
														<span></span>
													</label>
													<label class="m-checkbox">
														<input type="radio" class="ajLeadFilter" name="filLead" value="3"> Missed
														<span></span>
													</label>
												</div>

											</div>

										</div>






									</div>



								</form>






							</div>

						<?php
						} else {
						?>

							<a href="javascript::void(0)" title="Click here to refresh Lead List" onclick="viewFreshLead()" class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
								<span>
									<i class="fa flaticon-list"></i>
									<span>Refresh Lead</span>
								</span>
							</a>
							<a href="javascript::void(0)" onclick="viewUnQualifiedLead_V3()" class="btn btn-info btn-sm m-btn 	m-btn m-btn--icon">
								<span>
									<i class="fa flaticon-list"></i>
									<span>Disqualified Lead</span>
								</span>
							</a>
							<?php

							$data_arr_data_data = DB::table('indmt_data')
								->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
								->where('lead_assign.assign_user_id', '=', Auth::user()->id)
								//->where('indmt_data.lead_status', '=', 0)
								->whereDate('lead_assign.created_at', date('Y-m-d'))
								->orderBy('lead_assign.created_at', 'desc')
								->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
								->get();

							?>
							<a href="javascript::void(0)" onclick="viewTodayLeadLead()" class="btn btn-secondary btn-sm m-btn 	m-btn m-btn--icon">

								<span>
									<i class="fa flaticon-list"></i>
									<span><b>Today Lead</b>
										<span class="m-badge m-badge--warning"> {{count($data_arr_data_data)}}</span>
									</span>
								</span>
							</a>

							<div class="m-separator m-separator--dashed m--margin-top-1"></div>

						<?php
						}
						?>





						<!--end::Section-->

						<!-- form  -->
						<!--begin::Section-->
						<div class="m-section" style="display:block">
							<span class="m-section__sub">Fresh Lead filter by:</span>
							<div class="m-section__content">
								<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">


									<a href="javascript::void(0)" onclick="viewDIRECTLeadLM_V2()" class="btn btn-outline-primary btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="fa flaticon-list-2"></i>
											<span>DIRECT</span>
										</span>
									</a>
									<a href="javascript::void(0)" onclick="viewBUYLead_V2()" class="btn btn-outline-accent btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="fa flaticon-multimedia-2"></i>
											<span>BUY</span>
										</span>
									</a>
									<a href="javascript::void(0)" onclick="viewPHONELead_V2()" class="btn btn-outline-success btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="flaticon-support"></i>
											<span>PHONE</span>
										</span>
									</a>
									<a href="javascript::void(0)" onclick="viewINHOUSELead_V2()" class="btn btn-outline-warning 	btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="fa flaticon-file"></i>
											<span>IN HOUSE</span>
										</span>
									</a>
									<a href="javascript::void(0)" onclick="viewFOREIGNLead_V2()" class="btn btn-outline-warning 	btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="fa flaticon-file"></i>
											<span>FOREIGN</span>
										</span>
									</a>
									<a href="javascript::void(0)" onclick="viewVERIFIED_V2()" class="btn btn-outline-success 	btn-sm 	m-btn m-btn--icon">
										<span>
											<i class="fa flaticon-file"></i>
											<span>VERIFIED LEAD</span>
										</span>
									</a>



								</div>
							</div>
						</div>

						<!--end::Section-->


						<!--begin: Datatable -->
						<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_LEADList_LeadMangerVIEW">
							<thead>
								<tr>

									<th>LID</th>
									<th>Company</th>
									<th>Location</th>
									<th>Product</th>
									<th>Message</th>
									<th>Status</th>

									<th>Date</th>
									<th>Source</th>

									<th>Actions</th>
								</tr>
							</thead>

						</table>

						<!--begin: Datatable -->

						<!-- lead panel  -->
					</div>
					<div class="tab-pane" id="m_tabs_3_3_assinedLead" role="tabpanel">
						<!-- assined lead  -->

						<!--begin: Search Form -->
						<form class="m-form m-form--fit m--margin-bottom-20">
									<div class="row m--margin-bottom-20">
										
										<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
											<label>Users:</label>
											<select class="form-control m-inputA" data-col-index="6">
												<option value="">-SELECT-</option>
												<?php
												$user = auth()->user();
												$userRoles = $user->getRoleNames();
												$user_role = $userRoles[0];
												?>
												@if ($user_role =="Admin" || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==171)
												@foreach (AyraHelp::getSalesAgentAdmin() as $user)
												@if ($user->id==130 || $user->id==131
												|| $user->id==78
												|| $user->id==83
												|| $user->id==85
												|| $user->id==84
												|| $user->id==87
												|| $user->id==88
												|| $user->id==89
												|| $user->id==91
												|| $user->id==93
												|| $user->id==95
												|| $user->id==98
												|| $user->id==108



												)

												@else
												<option value="{{$user->name}}">{{$user->name}}</option>
												@endif

												@endforeach
												@else
												<option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
												@endif
												<option value="DEEPIKA JOSHI">DEEPIKA JOSHI</option>

											</select>

										</div>
										<div class="col-lg-4 m--margin-bottom-10-tablet-and-mobile">
										<button style="margin-top:25px" class="btn btn-brand m-btn m-btn--icon" id="m_searchAK">
												<span>
													<i class="la la-search"></i>
													<span>Search</span>
												</span>
											</button>
											&nbsp;&nbsp;
											<button style="margin-top:25px" class="btn btn-secondary m-btn m-btn--icon" id="m_resetAK">
												<span>
													<i class="la la-close"></i>
													<span>Reset</span>
												</span>
											</button>
										</div>
										
									</div>
								
									<div class="m-separator m-separator--md m-separator--dashed"></div>
									
								</form>


						<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_LEADList_LeadMangerVIEW_ASSIGN_CLAIM">
							<thead>
								<tr>

									<th>LID</th>
									<th>Company</th>
									<th>Location</th>
									<th>Product</th>
									<th>Message</th>
									<th>Status</th>

									<th>Date</th>
									<th>Source</th>

									<th>Actions</th>
								</tr>
							</thead>

						</table>

						<!-- assined lead  -->

					</div>