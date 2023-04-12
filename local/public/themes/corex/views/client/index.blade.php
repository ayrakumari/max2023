          <!-- main  -->
          <div class="m-content">
          	<!-- datalist -->
          	<div class="m-portlet m-portlet--mobile">

          		<div class="m-portlet__body">
          			<!--begin: Search Form -->
          			<form class="m-form m-form--fit m--margin-bottom-0">
          				<div class="row m--margin-bottom-5">
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label>Company:</label>
          						<input type="text" class="form-control m-input" placeholder="Company" data-col-index="1">
          					</div>
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label>Name:</label>
          						<input type="text" class="form-control m-input" placeholder="Name" data-col-index="3">
          					</div>
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label>Sales Person:</label>
          						<select class="form-control m-input" data-col-index="5">
          							<option value="">-SELECT-</option>
          							<?php
										$user = auth()->user();
										$userRoles = $user->getRoleNames();
										$user_role = $userRoles[0];
										?>
          							@if ($user_role =="Admin" || $user_role =="SalesHead")
          							@foreach (AyraHelp::getSalesAgent() as $user)
          							<option value="{{$user->name}}">{{$user->name}}</option>
          							@endforeach
          							@else
          							<option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
          							@endif

          						</select>
          					</div>
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label>Contact:</label>
          						<input type="text" class="form-control m-input" placeholder="Contact No" data-col-index="6">
          					</div>
          					
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label style="visibility:hidden">Name:</label>
          						@can('add-clients')
          						<a href="{{route('client.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
          							<span>
          								<i class="la la-plus"></i>
          								<span>Add New </span>
          							</span>
          						</a>
          						@endcan
          					</div>
          					<?php
								$missedFollow = AyraHelp::getMissedFollowup(Auth::user()->id);


								?>

          				</div>


          				<div class="row m--margin-bottom-0">

          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label style="visibility:hidden">Name:</label>
          						<button class="btn btn-brand m-btn m-btn--icon" id="m_search">
          							<span>
          								<i class="la la-search"></i>
          								<span>Search</span>
          							</span>
          						</button>
          					</div>
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label style="visibility:hidden">Name:</label>
          						<button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
          							<span>
          								<i class="la la-close"></i>
          								<span>Reset</span>
          							</span>
          						</button>
          					</div>
          					<div class="col-lg-3 m--margin-bottom-1-tablet-and-mobile">
          						<label style="visibility:hidden">Name:</label>


          						<div class="m-timeline-2__item-text m-timeline-2__item-text--bold">
          							Missed Followup:<a href="{{route('client.index')}}"> <span class="m-badge m-badge--danger">{{$missedFollow['client_count']}}</span> </a>
								  </div>
								 

          						
							  </div>
							  <div class="col-lg-3 m--margin-bottom-1-tablet-and-mobile">
							  <a  style="margin-top:19px" href="javascript::void(0)" onclick="clienthaveOrder()"  class="btn btn-warning m-btn m-btn--icon"> 
									  Client Order List
								 </a>

							  </div>



          				</div>

          			</form>
          			<div class="m-separator m-separator--md m-separator--dashed"></div>





          			<!--end::Form-->

          			<!--begin: Datatable -->
          			<table class="table table-striped- table-bordered table-hover table-checkable ajayra" id="m_table_clientList">
          				<thead>
          					<tr>
          						<th>Client ID</th>
          						<th>Company</th>
								<th>Brand</th>
          						<th>Name</th>
          						<th>Date Added</th>
          						<th>Sales Person</th>
          						<th>Contact</th>
          						<th>Follow Up</th>
          						<!-- <th>Status</th> -->
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
          					<textarea class="form-control" id="txtNotes" name="txtNotes"></textarea>
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
          				<button type="button" id="btnClientNotes" class="btn btn-primary">Save</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- m_modal_6 -->

          <!-- Modal -->
          <div class="modal fade" id="m_modal_6_TransferClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          	<div class="modal-dialog modal-dialog-centered" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLongTitle">Client Transfer</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" name="clid" id="clid" value="">
          				<div class="form-group m-form__group row">
          					<div class="col-lg-12">
          						<label class="form-control-label">Transfer to:</label>
          						<select name="transTo" class="form-control m-select2" id="m_select2_9" style="width:100%">
          							<option value="">-SELECT USER-</option>
          							<?php

										$users = \DB::table('users')->where('is_deleted', 0)->whereNotNull('phone')->get();
										foreach ($users as $key => $userData) {
										?>
          								<option value="{{$userData->id}}">{{$userData->name}}</option>

          							<?php
										}

										?>
          						</select>

          						</select>

          					</div>

          				</div>

          				<div class="form-group">
          					<label for="message-text" class="form-control-label">*Message:</label>
          					<textarea class="form-control" id="txtTransMessage" name="txtNotes"></textarea>
          				</div>



          			</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnTransferClient" class="btn btn-primary">Save</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- m_modal_6 -->