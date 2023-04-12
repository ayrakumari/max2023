<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
	<i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<?php

use Illuminate\Support\Facades\Auth;

$user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];
if ($user_role == 'Intern' || $user_role == 'QAQC' || $user_role == 'chemist') {
	// echo "Ayra";
	?>
	<ul class="m-nav-sticky" style="margin-top: 30px;">
	<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="RND Incentive Panel" data-placement="left">
				<a href="{{ route('IncentivePanel_RND')}}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-graph"></i>
				</a>

			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">

		
			
		
			<a href="javascript::void(0)"  data-toggle="modal" data-target="#m_modal_4TicketWindow" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
				<i style="color:#000" class="la la-life-ring"></i>
			</a>


		</li>
	</ul>
	<?php
} else {
?>
	<!-- begin::Quick Nav -->
	<ul class="m-nav-sticky" style="margin-top: 30px;">
	<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">

			<!-- <a class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only" href="javascript::void(0)" onclick="BOSupportReport()"  ><i  style="color:#000" class="la la-life-ring"></i></a> -->
			<a href="javascript::void(0)"  data-toggle="modal" data-target="#m_modal_4TicketWindow" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
				<i style="color:#000" class="la la-life-ring"></i>
			</a>
			<a title="SOP" href="javascript::void(0)" style="margin-top: 4px;"  data-toggle="modal" data-target="#m_modal_4TicketWindowSOP" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
			<i style="color:#000" class="m-menu__link-icon flaticon-clipboard"></i>
			</a>
			<!-- <a href="{{ route('supportTicket')}}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
				<i style="color:#000" class="la la-life-ring"></i>
			</a> -->


		</li>
		<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Request Sales Invoice" data-placement="left">


			<a href="{{ route('SaleInvoiceRequest')}}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only">
				<i style="color:#000" class="fa flaticon-envelope"></i>
			</a>
			<!-- <a href="javascript::void(0)" id="viewSalesInvoiceRequest" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only">
    <i style="color:#000" class="fa flaticon-envelope"></i>
  </a> -->



		</li>
		<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Request Payment" data-placement="left">


			<a href="{{ route('PaymentRequestConfirmation')}}" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
				<i style="color:#000" class="fa flaticon-paper-plane-1"></i>
			</a>


		</li>

		

		<!-- <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Add New Order" data-placement="left">
      <a href="{{ route('orders.create')}}" ><i class="flaticon-notepad "></i></a> -->
		</li>
		<!-- <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Share Product Catalog" data-placement="left">
		<a href="https://api.whatsapp.com/send?phone=+917703886088&text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://s1.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share" target="_blank"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
	</li> -->
		<?php

		if(Auth::user()->id==132){
			?>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Incentive Panel" data-placement="left">
				<a href="{{ route('IncentivePanel')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-graph"></i>
				</a>

			</li>
			
			<?php
		}
		if (Auth::user()->id == 171 || Auth::user()->id == 156 || Auth::user()->id == 1 || Auth::user()->id == 90 || Auth::user()->id == 132) {
		?>
			<!-- <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Product Price" data-placement="left">
		<a href="{{ route('productPriceList')}}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
			<i style="color:#000" class="flaticon-notepad"></i>
		</a>

		</li> -->
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="View User Activity" data-placement="left">
				<a href="{{ route('userActivityList')}}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
					<i style="color:#000" class="flaticon-notepad"></i>
				</a>

			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="My Team" data-placement="left">
				<a href="{{ route('myTeamList')}}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#035496" class="flaticon-users-1"></i>
				</a>

			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Incentive Panel" data-placement="left">
				<a href="{{ route('IncentivePanel')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-graph"></i>
				</a>

			</li>



		<?php
		} else {
		?>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="My Team" data-placement="left">
				<a href="{{ route('myTeamList')}}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#035496" class="flaticon-users-1"></i>
				</a>

			</li>

			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="My Incentive Panel" data-placement="left">
				<a href="{{ route('MyIncentivePanel')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-graph"></i>
				</a>

			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="On Credit Lead List" data-placement="left">
				<a href="{{ route('oncreditLeadList')}}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-user"></i>
				</a>

			</li>

		<?php
		}
		?>

		<?php
		if (Auth::user()->id == 1 || Auth::user()->id == 124) {
		?>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Chemist Panel" data-placement="left">


				<a href="{{ route('getAllChemistLayout')}}" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
					<i style="color:#000" class="fa flaticon-paper-plane-1"></i>
				</a>


			</li>
		<?php
		}
		if(Auth::user()->id == 1 || Auth::user()->id == 90 || Auth::user()->id == 132 ){
			?>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="RND Incentive Panel" data-placement="left">
				<a href="{{ route('IncentivePanel_RND')}}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">

					<i style="color:#FFFFFF" class="flaticon-graph"></i>
				</a>

			</li>

			<?php
		}
		if (Auth::user()->id == 14  || Auth::user()->id == 146 || Auth::user()->id == 189) {
		?>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Bulk Sample Dispatch" data-placement="left">
				<a  href="{{ route('bulkSampleDispatch')}}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">
					<i class="flaticon-reply"></i>
				</a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Chemist Sample Details" data-placement="left">

				<a  href="{{ route('chemistSamplesDetails')}}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">
					<i class="flaticon-eye"></i>
				</a>


			</li>

		<?php
		}
		?>

	</ul>
<?php

}
?>





<!-- m_modal_BOSupportReport_1 -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_BOSupportReport_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

		<div class="modal-content">

			<!-- tab -->
			<!--begin::Portlet-->
			<div class="m-portlet">

				<div class="m-portlet__body">
					<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_7_1" role="tab"><i class="la la-list"></i> Ticket List</a>
						</li>

						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_2" role="tab"><i class="la la-plus-circle"></i> Create New Ticket</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_3" role="tab"><i class="la la-hand-o-right"></i> Dashboard</a>
						</li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="m_tabs_7_1" role="tabpanel">
							<!-- tab1 -->
							A
							<!-- tab1 -->
						</div>
						<div class="tab-pane" id="m_tabs_7_2" role="tabpanel">
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
										<style>
											.select2-container--default .select2-selection--multiple .select2-selection__rendered {
												color:
													#575962;
												width: 680px !important;
											}
										</style>

										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="form-control-label">Assined to:</label><br>
												<select class="form-control m-select2" id="m_select2_3Aj" name="ticket_user[]" multiple="multiple">
													<?php

													$users = \DB::table('users')
														->join('hrm_emp', 'users.id', '=', 'hrm_emp.user_id')
														->where('hrm_emp.user_status', 0)
														->select('users.*')
														->get();
													foreach ($users as $key => $userData) {
													?>
														<option value="{{$userData->id}}">{{$userData->name}}</option>

													<?php
													}

													?>
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

						</div>
						<div class="tab-pane" id="m_tabs_7_3" role="tabpanel">
							c
						</div>
					</div>




				</div>
			</div>

			<!--end::Portlet-->
			<!-- tab -->

		</div>
	</div>
</div>

<!--end::Modal-->


<!-- m_modal_BOSupportReport_1 -->



<!-- begin::Quick Nav -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_QuickNav_1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sales Invoice Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background:#FFF;">
				<!-- ajaya -->
				<!--begin::Form-->
				<?php
				$data_arr = AyraHelp::getMyOrder();


				?>
				<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_salesInvoiceRequest">
					<div class="m-portlet__body">
						<div class="m-form__section m-form__section--first">
							@csrf

							<div class="form-group m-form__group row">
								<div class="col-lg-6 m-form__group-sub">
									<label class="form-control-label">Select Client:</label>
									<select class="form-control m-select2 " id="m_select2_2" name="client_id">
										<option>--SELECT CLIENT--</option>
										@foreach (AyraHelp::getClientByadded(Auth::user()->id) as $user)
										<option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
										@endforeach

									</select>

								</div>
								<div class="col-lg-3 m-form__group-sub">
									<label class="form-control-label">*GSTIN </label>
									<input type="text" name="gstNO" id="gstNO" class="form-control m-input" placeholder="">
								</div>
								<div class="col-lg-3 m-form__group-sub">
									<label class="form-control-label">* CONTACT NO </label>
									<input type="text" name="contNO" id="contNO" class="form-control m-input" placeholder="">
								</div>

							</div>


							<div id="m_repeater_4">
								<div class="form-group  m-form__group row" id="m_repeater_4">

									<div data-repeater-list="boOrder" class="col-md-12">
										<div data-repeater-item class="form-group">



											<!-- ajcdoe -->
											<div class="form-group m-form__group row">
												<div class="col-lg-3 m-form__group-sub">
													<label class="form-control-label">Order ID:</label>
													<select class="form-control m-input myOrderListSelect" name="formNO">
														<option value="">--Select Order--</option>
														<?php
														foreach ($data_arr as $key => $rowData) {
															$data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);
															$Spname = $data->stage_name;
															if ($Spname == 'Dispatch') {
														?>
																<option value="{{$rowData->form_id}}">{{$rowData->order_id."/".$rowData->subOrder}}</option>


														<?php

															}
														}
														?>


													</select>
												</div>
												<div class="col-lg-4 m-form__group-sub">
													<label class="form-control-label">* GSTIN No.:</label>
													<input type="text" id="txtMyGSTNO" name="txtMyGSTNO" class="form-control m-input" placeholder="">
												</div>

												<div class="col-lg-3 m-form__group-sub">
													<label class="form-control-label">* Contact NO.:</label>
													<input type="text" id="txtMyContactNO" name="txtMyContactNO" class="form-control m-input" placeholder="" value="">



												</div>
												<div class="col-lg-1 m-form__group-sub">
													<a href="#" style="margin-top:30px" target="_blank" id="myQCFORMLink" style="margin-bottom:3px" title="View QC Form" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
														<i class="la la-eye"></i>
													</a>


												</div>

												<div class="col-lg-1 m-form__group-sub">

													<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon" style="margin-top:25px">
														<span>
															<i class="la la-trash-o"></i>
															<span>DEL</span>
														</span>
													</div>

												</div>







											</div>

											<!-- ajcdoe -->


										</div>
									</div>
								</div>

								<div class="m-form__group form-group row">
									<label class="col-lg-2 col-form-label"></label>
									<div class="col-lg-4">
										<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
											<span>
												<i class="la la-plus"></i>
												<span>Add more</span>
											</span>
										</div>
									</div>
								</div>
							</div>


							<div class="form-group m-form__group row">
								<div class="col-lg-4 m-form__group-sub">
									<label class="form-control-label">Order ID:</label>
									<select class="form-control m-input myOrderListSelect" name="formNO">
										<option value="">--Select Order--</option>
										<?php
										foreach ($data_arr as $key => $rowData) {
											$data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);
											$Spname = $data->stage_name;
											if ($Spname == 'Dispatch') {
										?>
												<option value="{{$rowData->form_id}}">{{$rowData->order_id."/".$rowData->subOrder}}</option>


										<?php

											}
										}
										?>


									</select>
								</div>
								<div class="col-lg-4 m-form__group-sub">
									<label class="form-control-label">* GSTIN No.:</label>
									<input type="text" id="txtMyGSTNO" name="txtMyGSTNO" class="form-control m-input" placeholder="">
								</div>

								<div class="col-lg-3 m-form__group-sub">
									<label class="form-control-label">* Contact NO.:</label>
									<input type="text" id="txtMyContactNO" name="txtMyContactNO" class="form-control m-input" placeholder="" value="">



								</div>
								<div class="col-lg-1 m-form__group-sub">
									<a href="#" style="margin-top:30px" target="_blank" id="myQCFORMLink" style="margin-bottom:3px" title="View QC Form" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
										<i class="la la-eye"></i>
									</a>
								</div>


							</div>




						</div>

						<div class="form-group m-form__group row">
							<div class="col-lg-6 m-form__group-sub">
								<label class="form-control-label">* Complete Buyer Address : </label>
								<input type="text" name="complete_buyer_address" id="complete_buyer_address" class="form-control m-input" placeholder="">
							</div>
							<div class="col-lg-6 m-form__group-sub">
								<label class="form-control-label">* Delivery Address(if any) </label>
								<input type="text" name="delivery_address" id="delivery_address" class="form-control m-input" placeholder="">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<div class="col-lg-6 m-form__group-sub">
								<div class="m-form__group form-group">
									<label for="">Material Dispach Through</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="radio" value="1" name="dispatch_through"> Transport
											<span></span>
										</label>
										<label class="m-checkbox">
											<input type="radio" value="2" name="dispatch_through">Own Vehicle
											<span></span>
										</label>

									</div>

								</div>

							</div>
							<div class="col-lg-6 m-form__group-sub">
								<label class="form-control-label">* Destination </label>
								<input type="text" name="order_destination" class="form-control m-input" placeholder="" value="">
							</div>
						</div>


						<div class="form-group m-form__group row">
							<div class="col-lg-6 m-form__group-sub">
								<label class="col-form-label col-lg-12 col-sm-12">Vehicle/Logistic Details *</label>
								<textarea class="form-control m-input" name="vLogistic" placeholder="Enter Vehicle/Logistic Details "></textarea>

							</div>
							<div class="col-lg-6 m-form__group-sub">
								<label class="col-form-label col-lg-12 col-sm-12">Terms of Delivery</label>
								<textarea class="form-control m-input" name="termsDelivery" placeholder="Enter Terms of Delivery"></textarea>

							</div>
						</div>


						<div class="form-group m-form__group row">
							<div class="col-lg-3 m-form__group-sub">
								<label class="form-control-label">* Total Cartons </label>
								<input type="text" name="Vno_of_cartons" class="form-control m-input" placeholder="" value="">


							</div>
							<div class="col-lg-3 m-form__group-sub">
								<label class="form-control-label">* Total UNIT </label>
								<input type="text" name="Vno_of_unit" class="form-control m-input" placeholder="" value="">


							</div>

							<div class="col-lg-6 m-form__group-sub">
								<div class="row">
									<div class="col-lg-6">
										<label class="m-option">
											<span class="m-option__control">
												<span class="m-radio m-radio--state-brand">
													<input type="radio" name="paid_by" value="1">
													<span></span>
												</span>
											</span>
											<span class="m-option__label">
												<span class="m-option__head">
													<span class="m-option__focus">
														Paid By US
													</span>

												</span>

											</span>
										</label>
									</div>
									<div class="col-lg-6">
										<label class="m-option">
											<span class="m-option__control">
												<span class="m-radio m-radio--state-brand">
													<input type="radio" name="paid_by" value="2">
													<span></span>
												</span>
											</span>
											<span class="m-option__label">
												<span class="m-option__head">
													<span class="m-option__focus">
														Paid By Customer
													</span>

												</span>

											</span>
										</label>
									</div>
								</div>

							</div>
						</div>









					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-12">
									<button type="submit" id="IVReqSubmit" class="btn btn-info">Submit</button>
									<button type="reset" class="btn btn-secondary">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<!--end::Form-->

				<!-- ajaya -->
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="m_modal_5TICKETRESPSamleid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sample Process Response</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Response type:</label>
						<select class="form-control m-input" id="txtSampleSelectResp">
							<option value="1">Process Stated</option>
							<option value="2">Process Hold</option>
							<option value="3">Process Cancelled</option>
							<option value="4">Process Deleted</option>
						</select>

						<input type="hidden" id="txtTicIDSID">
					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtSampleprocessRepMessage"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnSampleprocessResponse" class="btn btn-primary">Submit </button>
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