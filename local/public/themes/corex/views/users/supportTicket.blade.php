<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--tabs">
			<div class="m-portlet__head">
				<div class="m-portlet__head-tools">
					<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x m-tabs-line--right" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_1_2A_tab_content" role="tab">
								<i class="fa fa-calendar-check-o" aria-hidden="true"></i>Support Tickets
							</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_3A_tab_content" role="tab">
								<i class="fa fa-bar-chart" aria-hidden="true"></i> Create New
							</a>
						</li>

					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="tab-content">
					<div class="tab-pane active" id="m_portlet_base_demo_1_2A_tab_content" role="tabpanel">


						<!-- ticket list -->
						<!--begin: Datatable -->
						<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_TicketListUser">
							<thead>
								<tr>
									<th>TID#</th>
									<th>Status</th>
									<th>Category</th>
									<th>Raised by </th>
									<th>Assign to</th>
									<th>Priority</th>
									<th>Created At</th>
									<th>Actions</th>
								</tr>
							</thead>
						</table>



						<!-- ticket list -->




					</div>
					<div class="tab-pane" id="m_portlet_base_demo_1_3A_tab_content" role="tabpanel">
						<!-- History PAYMENT -->
						<!--begin::Form-->
						<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_ticketRequest">
							<div class="m-portlet__body">
								@csrf
								<div class="m-form__section m-form__section--first">
									<div class="form-group m-form__group row">
										<div class="col-lg-8">
											<label class="form-control-label">Category:</label>
											<select class="form-control m-input getTicketDataSelect" id="exampleSelect1" name="ticketType"> <?php
																																			$support_type = \DB::table('ticket_type')->where('is_deleted', 0)->get();
																																			foreach ($support_type as $key => $rowData) {
																																			?>
													<option id="{{$rowData->ticket_subject}}" value="{{$rowData->id}}">{{$rowData->ticket_type}}</option>
												<?php
																																			}
												?>
											</select>
										</div>
										<div class="col-lg-4">
											<label class="form-control-label">Priority:</label>
											<select class="form-control m-input" id="exampleSelect1" name="ticketPriority">
												<?php
												$support_type = \DB::table('ticket_priority_type')->where('is_deleted', 0)->get();
												foreach ($support_type as $key => $rowData) {
												?>
													<option value="{{$rowData->id}}">{{$rowData->priority_name}}</option>
												<?php
												}
												?>
											</select>


										</div>



									</div>


									<div class="form-group m-form__group row">
										<div class="col-lg-12">
											<label class="form-control-label">Assined to:</label>
											<select name="ticket_user[]" class="form-control m-select2" id="m_select2_9" style="width:100%" name="param">
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


									<div class="form-group m-form__group row">
										<div class="col-lg-12">
											<label class="form-control-label">Subject:</label>
											<input type="text" name="ticket_subject" id="ticket_subject" class="form-control m-input" placeholder="" value="">
										</div>

									</div>
									<div class="form-group m-form__group row">
										<div class="col-lg-12">
											<label class="form-control-label">Message:</label>
											<textarea name="txtTicketMessage" class="form-control" data-provide="markdown" rows="5"></textarea>

											<span class="m-form__help">Please enter a message within word length range 10 and 200.</span>

										</div>
									</div>


								</div>

							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions m-form__actions">
									<div class="row">
										<div class="col-lg-12">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="reset" class="btn btn-secondary">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</form>

						<!--end::Form-->
						<!-- History PAYMENT -->
					</div>

				</div>
			</div>
		</div>

		<!--end::Portlet-->




	</div>
</div>
<!-- main  -->

<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

		<div class="modal-content">
			<div class="modal-body">
				<div id="payDetalRecSHOW">
				</div>
			</div>



		</div>
	</div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_TicketDataINFO" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Support Tickets </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewDataTICKETINFO">

				</div>
			</div>

		</div>
	</div>
</div>
<!--end::Modal-->




<!--begin::Modal-->
<div class="modal fade" id="m_modal_5TICKETRESP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ticket Response</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Ticket Need to:</label>
						<select class="form-control m-input" id="txtTicketSelectResp">
							<option value="2">CLOSE</option>
							<option value="3">RE-OPEN</option>
						</select>

						<input type="hidden" id="txtTicID">
					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtTicketRepMessage"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnTicketResponse" class="btn btn-primary">Submit </button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->