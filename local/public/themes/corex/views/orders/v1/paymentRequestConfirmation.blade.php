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
								<i class="fa fa-calendar-check-o" aria-hidden="true"></i>Payment Request
							</a>
						</li>
						<!-- <li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_3A_tab_content" role="tab">
														<i class="fa fa-bar-chart" aria-hidden="true"></i>
													</a>
												</li> -->

					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="tab-content">
					<div class="tab-pane active" id="m_portlet_base_demo_1_2A_tab_content" role="tabpanel">


						<!--begin::Form-->
						<form class="m-form m-form--state m-form--fit m-form--label-align-right" action="{{route('savePaymentRecivedClient')}}" method="post" enctype="multipart/form-data" id="m_form_3PaymentRequest">
							<div class="m-portlet__body">
								<div class="m-form__section m-form__section--first">
									@csrf
									<?php
									$useID = Request::segment(2);
									if (isset($useID)) {
									?>
										<input type="hidden" name="assined_user" value="{{$useID}}">

									<?php
									} else {
									?>
										<input type="hidden" name="assined_user" value="{{Auth::user()->id}}">
									<?php
									}

									?>

									<!-- row -->
									<div class="form-group m-form__group row">

										<div class="col-lg-8 m-form__group-sub">
											<label class="form-control-label">* Client:</label>
											<select class="form-control m-select2 m-select2-general" name="client_select">
												<option value=''>--SELECT CLIENT--</option>
												<?php

												if (isset($useID)) {
												?>
													@foreach (AyraHelp::getClientByadded($useID) as $user)
													<?php
													$data_arrCLData = AyraHelp::IsClientHaveOrderList($user->id);
													// if($data_arrCLData>=1){

													// }

													?>
													<option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
													<?php

													?>
													@endforeach
												<?php
												} else {
												?>
													@foreach (AyraHelp::getClientByadded(Auth::user()->id) as $user)
													<?php
													$data_arrCLData = AyraHelp::IsClientHaveOrderList($user->id);
													// if($data_arrCLData>=1){

													// }

													?>
													<option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
													<?php

													?>
													@endforeach
												<?php
												}
												?>

											</select>
										</div>
										<div class="col-lg-4 m-form__group-sub">
											<label class="form-control-label">* Payment received Date:</label>
											<input type="text" name="pay_date_recieved" class="form-control" id="m_datepicker_1PAY" readonly placeholder="Select date" />
										</div>


									</div>


									<!-- row -->
									<div class="form-group m-form__group row" style="display: none;">
										<div class="col-lg-3 m-form__group-sub">
											<label class="form-control-label">* Order ID:</label>
											<select class="form-control m-input " name="formNO" id="">
												<option value="">--Select Order--</option>
												<?php
												$orderArr = DB::table('qc_forms')
													->select('form_id', 'order_id', 'subOrder')
													->where('created_by', Auth::user()->id)
													->where('dispatch_status', '!=', 0)
													->get();
												foreach ($orderArr as $key => $rowData) {
												?>
													<option value="{{$rowData->form_id}}">{{$rowData->order_id}}/{{$rowData->subOrder}}</option>
												<?php
												}

												?>
											</select>


										</div>
										<div class="col-lg-6 m-form__group-sub">
											<label class="form-control-label">* Item Details:</label>
											<input type="text" name="" id="" class="form-control" placeholder="" readonly />
										</div>
										<div class="col-lg-3 m-form__group-sub">

											<!-- <button style="margin-top:25px" type="button"  class="btn btn-primary">Add</button> -->

										</div>

									</div>
									<!-- row -->
									<div class="form-group m-form__group row">

										<div class="col-lg-3 m-form__group-sub">
											<label class="form-control-label">* Amount:</label>
											<input type="text" name="payAmt" id="payAmt" class="form-control" placeholder="Enter Amount" />
										</div>
										<div class="col-lg-9 m-form__group-sub">
											<label class="form-control-label">* Rs.(In Words):</label>
											<input type="text" style="text-transform: capitalize;" name="Ls" id="rsWords" class="form-control" readonly placeholder="" />
										</div>


									</div>

									<!-- row -->




									<!-- row -->
									<div class="form-group m-form__group row">
									<div class="col-lg-2 m-form__group-sub">
											<label class="form-control-label">* Payment For:</label>
											<select class="form-control m-input" name="payment_for">
												<option value="">Select</option>
												<?php
												$payment_rec_typeArr = DB::table('payment_for')
													->where('is_active', 1)
													->get();
												foreach ($payment_rec_typeArr as $key => $row) {
												?>
													<option value="{{$row->id}}">{{$row->name}}</option>
													

												<?php
												}

												?>


											</select>
										</div>

										<div class="col-lg-2 m-form__group-sub">
											<label class="form-control-label">* DEPOSIT TO:</label>
											<select class="form-control m-input" name="bank_name">
												<option value="">Select</option>
												<?php
												$payment_rec_typeArr = DB::table('payment_rec_type')
													->where('is_active', 1)
													->get();
												foreach ($payment_rec_typeArr as $key => $row) {
												?>
													<option value="{{$row->id}}">{{$row->name}}</option>
													

												<?php
												}

												?>


											</select>
										</div>
										<div class="col-lg-3 m-form__group-sub">
											<label class="form-control-label">* Payment Type:</label>
											<select class="form-control m-input" name="paytype_id">
												<option value="">Select Type</option>
												<option value="1">Advance</option>
												<option value="2">Balance</option>
												<option value="3">Final</option>

											</select>
										</div>
										<div class="col-lg-5 m-form__group-sub">
											<label class="form-control-label"> Payment Screenshot:</label>
											<div class="custom-file">
												<input type="file" name="payIMG" class="custom-file-input" id="customFile">
												<label class="custom-file-label" for="customFile">Choose file</label>
											</div>
										</div>

									</div>

									<!-- row -->
									<div class="form-group m-form__group row">
										<div class="col-lg-12">
											<label class="form-control-label">*Remarks:</label>
											<textarea class="form-control m-input" id="exampleTextarea" name="txtMessagePAYDATA" rows="3"></textarea>
										</div>
									</div>

								</div>


							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions m-form__actions">
									<div class="row">
										<div class="col-lg-12">
											<button type="submit" data-wizard-action="submitPAY" class="btn btn-accent">Submit</button>
											<button type="reset" class="btn btn-secondary">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</form>

						<!--end::Form-->

						<!-- History PAYMENT -->
						<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_PAYMENT_REQUEST">
							<thead>
								<tr>
									<th>ID#</th>
									<th>Payment Date</th>
									<th>Client Name</th>
									<th>Company</th>
									<th>Phone</th>
									<th>Requested on</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
						</table>


					</div>
					<div class="tab-pane" id="m_portlet_base_demo_1_3A_tab_content" role="tabpanel">
						<!-- History PAYMENT -->

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