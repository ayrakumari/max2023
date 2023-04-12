<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						On Credit Request List
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">

			</div>
		</div>

		<div class="m-portlet__body">





			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_leadOncreditRequest">
				<thead>
					<tr>
						<th>ID#</th>
						<th>Brand</th>
						<th>Company</th>
						<th>Name </th>
						<th>Phone</th>
						<th>Details</th>
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
<div class="modal fade" id="m_modal_leadCreditDataINFO" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">On Credit Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtIDLead">
				<form>
					<div class="form-group m-form__group">
						<label for="exampleSelect1">Response</label>
						<select class="form-control m-input" id="respType" name="respType">
							<option value="2">Approved</option>
							<option value="3">Rejected</option>
							<option value="4">On Hold</option>
							<!-- <option value="1">Pending</option> -->
						</select>
					</div>

					<div class="form-group">
						<label for="message-text" class="form-control-label">Message:</label>
						<textarea class="form-control" id="txtEditOrderResponse"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnLeadOncreditAction" class="btn btn-primary">Submit</button>
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