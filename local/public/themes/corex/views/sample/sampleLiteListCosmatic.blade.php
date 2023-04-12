<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Sample List
					</h3>
					<table style="margin-left:30px;">
						<tr>
							<td>
								<h5 class="m--font-info">PDS: Total({{AyraHelp::sampleTotalPendingCosmatic()}}) </h5>
							</td>
							<td>
								<button type="button" class="btn btn-outline-default btn-sm"> 3 Days <span class="m-badge m-badge--info">{{ $spcount=AyraHelp::samplePendingDispatch(3)}}</span></button>

							</td>
							<td>
								<button type="button" class="btn btn-outline-default btn-sm"> 7 Days <span class="m-badge m-badge--warning">{{ $spcount=AyraHelp::samplePendingDispatch(7)}}</span></button>

							</td>
							<td>
								<button type="button" class="btn btn-outline-default btn-sm"> 15 Days <span class="m-badge m-badge--danger">{{ $spcount=AyraHelp::samplePendingDispatch(15)}}</span></button>
							</td>

							<!-- <td>
								<button onclick="unAssinedSampleList_Cosmatic()" type="button" class="btn btn-outline-default btn-sm"> Unassigned<span class="m-badge m-badge--warning">{{ $spcount=AyraHelp::sampleUnassigned()}}</span></button>
							</td> -->
							<td>
								<button onclick="AssinedSampleList__Cosmatic()" type="button" class="btn btn-outline-default btn-sm"> Assigned <span class="m-badge m-badge--primary">{{ $spcount=AyraHelp::sampleAssigned()}}</span></button>
							</td>
							<td>
								<button onclick="AfterFormaulationSampleList__Cosmatic()" type="button" class="btn btn-outline-default btn-sm"> After Formulation <span class="m-badge m-badge--danger">{{ $spcount=AyraHelp::sampleAssignedREST()}}</span></button>
							</td>
							<td>
								<button onclick="AfterFormaulationSampleList__REFRESH()" type="button" class="m-badge m-badge--warning m-badge--wide m-badge--rounded"> REFRESH </button>
							</td>
							<td>
								<button onclick="AfterFormaulationSampleList__Cosmatic_Standard()" type="button" class="m-badge m-badge--primary m-badge--wide m-badge--rounded"> STANDARD </button>
							</td>

						</tr>
					</table>
				</div>
			</div>
			
		</div>
		<div class="m-portlet__body">

			<!--begin: Search Form -->
			<form class="m-form m-form--fit m--margin-bottom-20">
				<div class="row m--margin-bottom-20">
					<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
						<label>Sample ID:</label>
						<input type="text" class="form-control m-input" placeholder="" data-col-index="1">
					</div>
					<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
						<label>Company:</label>
						<input type="text" class="form-control m-input" placeholder="" data-col-index="2">
					</div>
					<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
						<label>Sales Person:</label>
						<select class="form-control m-input" data-col-index="6">
							<option value="">-SELECT-</option>
							<?php
							$user = auth()->user();
							$userRoles = $user->getRoleNames();
							$user_role = $userRoles[0];
							?>
							@if ($user_role =="Admin" || $user_role =="SalesHead" || Auth::user()->id==124)
							@foreach (AyraHelp::getSalesAgentAdmin() as $user)
							<option value="{{$user->name}}">{{$user->name}}</option>
							@endforeach
							@else
							<option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
							@endif

						</select>
					</div>
					<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
						<label>Name:</label>
						<input type="text" class="form-control m-input" placeholder="" data-col-index="4">
					</div>
					<div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
						<label>Status:</label>
						<select class="form-control m-input" data-col-index="7">
							<option value="">--ALL--</option>
							<option value="2">APPROVED</option>
							<option value="3">FORMULATION</option>
							<option value="4">PACKING</option>
							<!-- <option value="5">DISPATCH</option> -->
						</select>
					</div>

					

				</div>


				<div class="row">
					<div class="col-lg-2">
						<button class="btn btn-brand m-btn m-btn--icon" id="m_search">
							<span>
								<i class="la la-search"></i>
								<span>Search</span>
							</span>
						</button>
					</div>
					<div class="col-lg-2">
						<button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
							<span>
								<i class="la la-close"></i>
								<span>Reset</span>
							</span>
						</button>
					</div>
					<div class="col-lg-2">
						<a href="#">
							<div class="m-timeline-2__item-text m-timeline-2__item-text--bold">
								Feedback
							</div>
						</a>
					</div>
				</div>
				<div class="m-separator m-separator--md m-separator--dashed"></div>

				

			</form>
			<input type="hidden" id="txtSampleAction" value="show_all">


			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_SampletList_LITE_COSMATIC">
				<thead>
					<tr>
						<th>ID#</th>
						<th>Sample ID</th>
						<th>Company</th>
						<th>Contact</th>
						<th>Name</th>
						<th>Date </th>
						<th>Sales Person</th>
						<th>Status</th>	
						<th>Sample Type</th>						
						<th>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- datalist -->
</div>
<!-- main  -->



<div class="modal fade" id="m_modal_6_assinedSampleTo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Sample Assignment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="sampleIDA" id="sampleIDA">


				<div class="form-group m-form__group">
					<label>Chemist</label>
					<div class="input-group">
						<select class="form-control m-input" name="chemistID" id="chemistID">
							
						<?php 
              $activeChemietArr=AyraHelp::getChemist();
              foreach ($activeChemietArr as $key => $rowData) {
               ?>
               <option value="{{$rowData->id}}">{{$rowData->name}}</option>
               <?php
              }
              ?>
                                
                                
						</select>


					</div>
				</div>
				<div class="form-group">
					<label for="message-text" class="form-control-label">*Remarks:</label>
					<textarea class="form-control" id="txtSampleAssinedRemark" name="txtSampleAssinedRemark"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnSaveSampleAssingn" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="view_sent_sample_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Sample</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- modal content -->
				<table class="table m-table">
					<thead>

					</thead>
					<tbody>
						<tr>
							<th><strong>Sample ID:</strong></th>
							<td colspan="3" id="s_id"></td>
							<td><strong>Company:</strong>:</td>
							<td id="s_company"></td>


						</tr>
						<tr>
							<th><strong>Name:</strong></th>
							<td id="s_contactName"></td>
							<td><strong>Phone:</strong>:</td>
							<td id="s_contactPhone"></td>

						</tr>


						<tr>
							<th><strong>Samples</strong></th>
							<td colspan="4">
								<table class="table table-sm m-table m-table--head-bg-metal">
									<thead class="thead-inverse">
										<tr>
											<th style="color:#000">#</th>
											<th style="color:#000">Item</th>
											<th style="color:#000">Description</th>

										</tr>
									</thead>
									<tbody id="itemdata">



									</tbody>
								</table>

							</td>
							<td></td>
							<td></td>
						</tr>

						<tr>
							<th><strong>Shipping Address</strong></th>
							<td colspan="3" id="s_ship_address">444</td>
							<td>Location</td>
							<td id="s_location">444</td>
						</tr>

						<tr>
							<th><strong>Status</strong></th>
							<td colspan="3" id="s_status">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="ajrow_tr_c">
							<th><strong>Courier</strong></th>
							<td colspan="3">
								<table class="table table-sm m-table m-table--head-bg-metal">
									<thead class="thead-inverse">
										<tr>

											<th style="color:#000">Courier Name</th>
											<th style="color:#000">Tracking ID</th>
											<th style="color:#000">Sent on</th>

										</tr>
									</thead>
									<tbody>
										<tr>

											<td id="s_courier_name">

											</td>
											<td id="s_track_id">

											</td>
											<td id="s_sent_on">

											</td>

										</tr>
										<tr colspan="3">
											<td>
												Courier Remarks
											</td>
											<td id="s_remarks">

											</td>

										</tr>

									</tbody>
								</table>
							</td>
							<td></td>
							<td></td>
						</tr>

					</tbody>
				</table>
				<div class="ajrow_tr_new">
					<div class="form-group m-form__group row">
						<div class="col-lg-4">
							<label>Courier:</label>


							<select class="form-control m-input m-input--air" id="courier_data">
								<option value="NULL">-SELECT-</option>

								@foreach (AyraHelp::getCourier() as $courier)
								<option value="{{$courier->id}}">{{$courier->courier_name}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-lg-4">
							<label class="">Sent Date:</label>
							<div class="input-group date">
								<input type="text" class="form-control m-input" readonly id="m_datepicker_3" />
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<label>Status:</label>
							<select class="form-control m-input m-input--air" id="status_sample">
								<option value="1">NEW</option>
								<option value="2">SENT</option>
								<option value="3">RECEIVED</option>
								<option value="4">FEEDBACK</option>
							</select>

						</div>
					</div>
					<input type="hidden" name="v_s_id" id="v_s_id">
					<div class="form-group m-form__group row">
						<div class="col-lg-4">
							<label>Track ID:</label>
							<input type="text" class="form-control m-input" id="track_id" placeholder="Enter TracK ID">

						</div>
						<div class="col-lg-8">
							<label>Remarks:</label>
							<textarea class="form-control m-input m-input--air" id="txtRemarksArea" rows="2"></textarea>
						</div>
					</div>
				</div>
				<div class="row" style="display:none">
					<div class="col-lg-4">
						<label>Sample Feedback:</label>

						<select name="feedback_option" id="feedback_option">
							<option value="0">--Select Options-- </option>
							<?php
							$sample_feed_arr = AyraHelp::getSampleFeedback();
							foreach ($sample_feed_arr as $key => $value) {
							?>
								<option value="{{$value->id}}">{{$value->feedback}}</option>
							<?php
							}

							?>
						</select>
					</div>
					<div class="col-lg-8">
						<label>Others Feedback:</label>
						<textarea class="form-control m-input m-input--air" id="feedback_other" rows="3"></textarea>
					</div>
					<button type="button" id="btnSaveSampleSentFeedback" class="btn btn-primary">Save Feedback</button>
				</div>






				<!-- modal content -->

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnSaveSampleSent" disabled class="btn btn-primary ajrow_tr_new">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- modal -->



<div class="modal fade" id="m_modal_6_feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Sample Feedback</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="v_s_id" id="v_s_id" value="">


				<div class="form-group m-form__group">
					<label>Feedback Options</label>
					<div class="input-group">
						<select class="form-control m-input" name="feedback_option1" id="feedback_option1">
							<option value="">--Select Options-- </option>
							<?php
							$sample_feed_arr = AyraHelp::getSampleFeedback();
							foreach ($sample_feed_arr as $key => $value) {
							?>
								<option value="{{$value->id}}">{{$value->feedback}}</option>
							<?php
							}

							?>
						</select>


					</div>
				</div>
				<div class="form-group">
					<label for="message-text" class="form-control-label">*Remarks:</label>
					<textarea class="form-control" id="txtFeedbackRemarks" name="txtFeedbackRemarks"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnsaveFeedback" class="btn btn-primary">Save Feedback</button>
			</div>
		</div>
	</div>
</div>

<!-- m_modal_6 -->


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