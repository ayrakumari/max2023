          <!-- main  -->
          <div class="m-content">
						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Client List
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
																<li class="m-portlet__nav-item">
																		@can('add-clients') 
																		<a href="{{route('client.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
																			<span>
																				<i class="la la-plus"></i>
																				<span>Add New </span>
																			</span>
																		</a>
																		@endcan
																</li>
															</ul>
														</div>
													</div>
													<div class="m-portlet__body">

																<!--begin: Search Form -->
								<form class="m-form m-form--fit m--margin-bottom-0">
										<div class="row m--margin-bottom-0">
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Company:</label>
												<input type="text" class="form-control m-input" placeholder="Company" data-col-index="1">
											</div>
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Name:</label>
												<input type="text" class="form-control m-input" placeholder="Name" data-col-index="2">
											</div>
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Sales Person:</label>
												<select class="form-control m-input" data-col-index="4">
														<option  value="">-SELECT-</option>
														<?php
														$user = auth()->user();
														$userRoles = $user->getRoleNames();
														$user_role = $userRoles[0];
														?>
														@if ($user_role =="Admin")
														@foreach (AyraHelp::getSalesAgent() as $user)
														<option  value="{{$user->name}}">{{$user->name}}</option>
														@endforeach
														@else
														<option  value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
														@endif
						  
												</select>
											</div>
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Contact:</label>
												<input type="text" class="form-control m-input" placeholder="Contact No" data-col-index="5">
											</div>
										</div>
										<div class="row m--margin-bottom-0">
											
											<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
												<label>Status:</label>
												<select class="form-control m-input" data-col-index="7">
													<option value="2">LEAD</option>
													<option value="3">QUALIFIED</option>
													<option value="4">SAMPLING</option>
													<option value="5">CUSTOMER</option>
													<option value="6">LOST</option>
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


																
									

									<!--end::Form-->

														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable ajayra" id="m_table_clientList_yestardayFollow">
															<thead>
																<tr>
																	<th>Client ID</th>
																	<th>Company</th>
																	<th>Name</th>
																	<th>Date Added</th>
																	<th>Sales Person</th>
																	<th>Contact</th>
																	<th>Reminders</th>
																	<th>Status</th>
																	<th>Actions</th>
																</tr>
															</thead>

														</table>

													</div>
												</div>

						<!-- datalist -->

					</div>
          <!-- main  -->


		  <!-- m_modal_6 -->
              <!-- Modal -->
			  <div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Client Notes</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
			<input type="hidden" name="user_id" id="user_id" value="">
			<div class="form-group">
										<label for="message-text" class="form-control-label">*Message:</label>
										<textarea class="form-control" id="txtNotes"  name="txtNotes"></textarea>
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
												<a class="dropdown-item" href="javascript::void(0)" id="aj_3days" >3 Days</a>
												<a class="dropdown-item" href="javascript::void(0)" id="aj_7days" >7 Days</a>																	
												<a class="dropdown-item" href="javascript::void(0)" id="aj_15days" >15 Days</a>
												<a class="dropdown-item" href="javascript::void(0)" id="aj_next_month" >Next Month</a>
											</div>
										</div>
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" id="btnClientNotes" class="btn btn-primary">Save</button>
							</div>
						</div>
					</div>
				</div>

	  <!-- m_modal_6 -->

	  