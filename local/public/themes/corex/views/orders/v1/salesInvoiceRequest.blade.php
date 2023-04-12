<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Sales Invoice List with Invoice File
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">

			</div>
		</div>

		<div class="m-portlet__body">





			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_salesInvoiceRequest">
				<thead>
					<tr>
						<th>ID#</th>
						<th>Sales Person</th>
						<th>Order ID</th>
						<th>Brand</th>
						<th>Requested On </th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>



		</div>
	</div>
</div>
<!-- main  -->

<!--begin::Modal-->
<div class="modal fade" id="m_modal_SalesInvoiceViewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Details:Sale Invoice Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewDataSaleInvReq">

				</div>
			</div>

		</div>
	</div>
</div>
<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_saleInvoiceResponceAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sales Invoice Reponse </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Order ID :<b><span id="sirOID"></b></span></label>

					</div>
					<input type="hidden" id="ReqID">
					<div class="form-group m-form__group">
						<label for="exampleSelect1">Response Status</label>
						<select class="form-control m-input" id="sirRespStatus">
							<option value="1">Completed</option>
							<option value="2">Hold on</option>
						</select>
					</div>
					<div class="m-form__group form-group">
						<label for="">Invoice From</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input checked type="radio" name="inv_type" value="1"> Tally
								<span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="inv_type" value="2"> SAP
								<span></span>
							</label>

						</div>
						<span class="m-form__help">Some help text goes here</span>
					</div>
					<div class="form-group">
						<label for="message-text" class="form-control-label">Invoice ID:</label>

						<input class="form-control" id="txtTallyNo" type="text">

					</div>

					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="sirMessage"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSIRSubmit">Send message</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_account_adminPAYOrderInvoiceAddReqBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Invoice Attachment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<input type="hidden" name="txtPayOrderIDInvAdd" id="txtPayOrderIDInvAdd">
				<div class="form-group">
					<label for="message-text" class="form-control-label">Message:</label>
					<textarea class="form-control" name="txtAdminAccountOCInvoice" id="txtAdminAccountOCInvoice"></textarea>
				</div>
				<div class="form-group m-form__group row">

					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="m-dropzone dropzone m-dropzone--success" action="{{route('invoiceFileUploadA')}}" id="imajkumar">
							<div class="m-dropzone__msg dz-message needsclick">

								<h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
								<span class="m-dropzone__msg-desc">Only image, pdf and psd files are allowed for upload</span>
							</div>
						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
</div>

<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_SalesInvoiceViewDetailsFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sales Invoice Feecback </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<input type="hidden" name="ReqID" id="ReqID">

				</div>
				<input type="hidden" id="ReqID">
				<div class="form-group m-form__group">
					<label for="exampleSelect1">Feedback Status</label>
					<select class="form-control m-input" id="sirRespStatus">
						<?php
						if (Auth::user()->id == 132 ) {
						?>
							<option value="3">DONE</option>
							<option value="2">Change</option>

						<?php
						} else {
						?>
							<option value="1">Completed</option>
							<option value="2">Change</option>
						<?php
						}
						?>

					</select>
				</div>

				<div class="form-group">
					<label for="message-text" class="form-control-label">Message6:</label>
					<textarea class="form-control" id="sirMessageAM"></textarea>
				</div>

			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-primary" id="btnSubmitInvSubmitAM">Submit</button>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" id="m_modal_saleInvoiceResponceAdd_SAPApprval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sales Invoice SAP Approval Reponse </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Order ID :<b><span id="sirOID_A"></b></span></label>

					</div>
					<input type="hidden" id="ReqID_A">

					<div class="form-group">
						<label for="message-text" class="form-control-label">Party ID:</label>
						<input class="form-control" id="txtPartyNo" type="text">

					</div>

					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="sirMessageSAP"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSIRSubmitSAP">Approved for SAP Invoice</button>
			</div>
		</div>
	</div>
</div>