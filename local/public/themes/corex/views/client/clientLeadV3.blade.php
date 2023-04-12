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
          							@if ($user_role =="Admin" || $user_role =="SalesHead"|| Auth::user()->id==156 || Auth::user()->id==85)
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
          					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
          						<label>Stages:</label>
          						<select class="form-control m-input" data-col-index="7">
          							<option value="1">Assigned</option>
          							<option value="2">Qualified</option>
          							<option value="3">Sampling</option>
          							<option value="4">Client</option>
          							<option value="5">Repeat Client</option>
          							<option value="6">Lost</option>
          						</select>
          					</div>
          					<div class="col-lg-3">
          						<button style="margin-top: 25px;" class="btn btn-brand m-btn m-btn--icon" id="m_search">
          							<span>
          								<i class="la la-search"></i>
          								<span>Search</span>
          							</span>
          						</button>
          						<button style="margin-top: 25px;" class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
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
          			<table class="table table-striped- table-bordered table-hover table-checkable ajayra" id="m_table_clientList">
          				<thead>
          					<tr>
          						<th>LID</th>
          						<th>Company</th>
          						<th>Brand</th>
          						<th>Name</th>
          						<th>Date Added</th>
          						<th>Sales Person</th>
          						<th>Contact</th>
          						<th>Stage</th>
          						<th>Actions</th>
          					</tr>
          				</thead>

          			</table>

          		</div>
          	</div>

          	<!-- datalist -->

          </div>
          <!-- main  -->


          <!-- m_modal_6 m_modal_79_leadOncredit -->
          <div class="modal fade" id="m_modal_79_leadOncredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          	<div class="modal-dialog modal-dialog-centered" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLongTitle">Lead On Credit Request</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" name="lead_id_credit" id="lead_id_credit" value="">
          				<div class="form-group m-form__group">
          					<label for="exampleInputPassword1">Credit Period</label>
          					<select class="form-control m-input form-control-sm" id="lead_credit_period">
          						<option value="30">30 Days</option>
          						<option value="45">45 Days</option>
          						<option value="60">60 Days</option>
          					</select>
          				</div>

          				<div class="form-group m-form__group">
          					<label for="exampleSelect1">Credit On PDC</label>
          					<select class="form-control m-input form-control-sm" id="lead_credit_pdc">
          						<option value="1">YES</option>
          						<option value="2">NO</option>
          					</select>
          				</div>

          				<div class="form-group m-form__group">
          					<label>Credit Percentage</label>
          					<div class="m-input-icon m-input-icon--left m-input-icon--right">
          						<input type="text" class="form-control m-input m-input--square" id="m_inputmask_6" placeholder="Percentage">

          						<span class="m-input-icon__icon m-input-icon__icon--right"><span style="margin-top: 10px;">%</span></span>
          					</div>
          				</div>


          				<div class="form-group">
          					<label for="message-text" class="form-control-label">*Message:</label>
          					<textarea class="form-control" id="txtCreditMessage" name="txtNotes"></textarea>
          				</div>



          			</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnLeadCreditRequest" class="btn btn-primary">Save</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="m_modal_6_leadNotes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          	<div class="modal-dialog modal-dialog-centered" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLongTitle">Lead Notes</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" name="lead_id" id="lead_id" value="">
          				<div class="form-group">
          					<label for="message-text" class="form-control-label">*Message:</label>
          					<textarea class="form-control" id="txtNotes" name="txtNotes"></textarea>
          				</div>

          				<div class="m-form__group form-group">
          					<label for="">
          						<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Want to schedule Follow Up</span>

          					</label>
          					<div class="m-radio-inline">
          						<label class="m-radio">
          							<input checked type="radio" value="1" name="followUPSET">Yes
          							<span></span>
          						</label>
          						<label class="m-radio">
          							<input type="radio" value="2" name="followUPSET"> No
          							<span></span>
          						</label>

          					</div>

          				</div>





          				<div class="input-group leadNoteDate">
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
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnLeadNotes" class="btn btn-primary">Save</button>
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
          <div class="modal fade" id="m_modal_6_TransferClient_EMAIL_SMS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          	<div class="modal-dialog modal-dialog-centered" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLongTitle">Client Transfer With EMAIL or SMS</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" name="clid" id="clid_email_sms">
          				<div class="form-group m-form__group row">
          					<div class="col-lg-12">
          						<label class="form-control-label">Transfer To:</label>
          						<select name="transTo_SMSEMAIL" class="form-control m-select2" id="m_select2_1" style="width:100%">
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
          					<textarea class="form-control" id="txtTransMessage_SMSEMAIL" name="txtNotes"></textarea>
          				</div>
          				<div class="m-form__group form-group">
          					<label for="">EMAIL or SMS</label>
          					<div class="m-checkbox-inline">
          						<label class="m-checkbox">
          							<input name="sendEMAIL_SMS" value="1" type="checkbox"> EMAIL
          							<span></span>
          						</label>
          						<label class="m-checkbox">
          							<input name="sendEMAIL_SMS" value="2" type="checkbox"> SMS
          							<span></span>
          						</label>

          					</div>

          				</div>
						 
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-6">
													<label>Email:</label>
													<input type="email" class="form-control m-input" id="txtEmailID" placeholder="Enter Email">
													<!-- <span class="m-form__help">Valid Email</span> -->
												</div>
												<div class="col-lg-6">
													<label class="">Phone:</label>
													<input type="text" name="txtCIDPhone" id="m_inputmask_6" class="form-control m-input" placeholder="Enter contact number">
													<!-- <span class="m-form__help">Please enter your contact number </span> -->
												</div>
											</div>
											
											
										</div>
										
									


          			</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnTransferClientEmailSMS" class="btn btn-primary">Submit</button>
          			</div>
          		</div>
          	</div>
          </div>


          <!-- m_modal_6 -->



          <div class="modal fade" id="GeneralViewModelSalesLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-lg" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLabel">Stage Progress of Lead</h5>
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