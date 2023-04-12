          <!-- main  -->
          <div class="m-content">

          	<div class="m-portlet m-portlet--mobile">
          		<div class="m-portlet__head">
          			<div class="m-portlet__head-caption">
          				<div class="m-portlet__head-title">
          					<h3 class="m-portlet__head-text">
          						Order Approval List
          					</h3>
          				</div>
          			</div>

          		</div>
          		<div class="m-portlet__body">

          			<!--begin: Search Form -->
          			<form class="m-form m-form--fit m--margin-bottom-20">
          				<div class="row m--margin-bottom-20">

          					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
          						<label>OrderID:</label>
          						<input type="text" class="form-control m-input" placeholder="E.g: 37000-300" data-col-index="1">
          					</div>
          					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
          						<label>Client Name:</label>
          						<select class="form-control m-input" data-col-index="2">
          							<option value="">Select</option>
          						</select>
          					</div>

          				</div>



          			</form>

          			<!--begin: Datatable -->
          			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_OrderApprovalRequestLIST">
          				<thead>
          					<tr>
          						<th>Record ID</th>
          						<th>Order ID</th>
          						<th>Order Value</th>
          						<th>Client Name</th>
          						<th>Company</th>
          						<th>Brand</th>
          						<th>Created on</th>
          						<th>Sales Person</th>
          						<th>Actions</th>
          					</tr>
          				</thead>

					  </table>
					  
					  <div class="form-group m-form__group row">
          						
          						<div class="col-lg-12 col-md-12 col-sm-12">
          							<div class="m-dropzone dropzone m-dropzone--success" action="{{route('invoiceFileUpload')}}" id="imajkumar">
          								<div class="m-dropzone__msg dz-message needsclick">
										  {{ csrf_field() }}
          									<h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
          									<span class="m-dropzone__msg-desc">Only image, pdf and psd files are allowed for upload</span>
          								</div>
          							</div>
          						</div>
							  </div>
							  
          		</div>
          	</div>

          	<!-- END EXAMPLE TABLE PORTLET-->
          </div>
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

          <!--end::Modal-->



          <div class="modal fade" id="m_modal_6PAYMENTRECDETAIL_HIST" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-lg" role="document">
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
          		</button>

          		<div class="modal-content">
          			<div class="modal-body">
          				<div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="450">

          					<div id="payDetalRecSHOW_HIST">

          					</div>

          				</div>
          			</div>



          		</div>
          	</div>
          </div>

          <!--end::Modal-->

          <!-- m_modal_6PAYMENORDER_MODEL -->
          <div class="modal fade" id="m_modal_6PAYMENORDER_MODEL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-lg" role="document">
          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
          		</button>

          		<div class="modal-content">
          			<div class="modal-body">
          				<div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="450">

          					<div id="payOrderApprList">

          					</div>

          				</div>
          			</div>



          		</div>
          	</div>
          </div>


          <!-- m_modal_6PAYMENORDER_MODEL -->



          <!--begin::Modal-->
          <div class="modal fade" id="m_modal_5_account_adminPAYApp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-sm" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" id="txtPAAPayID">
          				<form>
          					<div class="form-group m-form__group">
          						<label for="exampleSelect1">Response</label>
          						<select class="form-control m-input" id="accResp" name="accResp">
          							<option value="1">Recieved</option>
          							<option value="2">Not Recieved</option>
          							<option value="3">On Hold</option>
          						</select>
          					</div>

          					<div class="form-group">
          						<label for="message-text" class="form-control-label">Message:</label>
          						<textarea class="form-control" id="txtAdminAccount"></textarea>
          					</div>
          				</form>
          			</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnPayRecSubmit" class="btn btn-primary">Submit message</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!--end::Modal-->

          <!-- payment order confirm -->
          <!--begin::Modal-->
          <div class="modal fade" id="m_modal_5_account_adminPAYOrderConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-sm" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLabel">Order Confirmation</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<div class="modal-body">
          				<input type="hidden" id="txtPayOrderID">
          				<form>
          					<div class="form-group m-form__group">
          						<label for="exampleSelect1">Response</label>
          						<select class="form-control m-input" id="accOCResp" name="accOCResp">
          							<option value="1">Completed</option>
          							<!-- <option value="2">Not Recieved</option>
													<option value="3">On Hold</option>																										 -->
          						</select>
          					</div>

          					<div class="form-group">
          						<label for="message-text" class="form-control-label">Message:</label>
          						<textarea class="form-control" id="txtAdminAccountOC"></textarea>
          					</div>
          				</form>
          			</div>
          			<div class="modal-footer">
          				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          				<button type="button" id="btnPayOrderRecSubmit" class="btn btn-primary">Submit message</button>
          			</div>
          		</div>
          	</div>
          </div>

          <!--end::Modal-->

          <!-- payment order confirm -->


          <!-- payment order confirm -->
          <!--begin::Modal-->
          <div class="modal fade" id="m_modal_5_account_adminPAYOrderInvoiceAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-lm" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLabel">Invoice Attachment</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			
          				<div class="modal-body">
          					<input type="text" id="txtPayOrderIDInvAdd">
          					<div class="form-group">
          						<label for="message-text" class="form-control-label">Message:</label>
          						<textarea class="form-control" id="txtAdminAccountOCInvoice"></textarea>
          					</div>
          					


          				</div>
          				

          			
          		</div>
          	</div>
          </div>

          <!--end::Modal-->

          <!-- payment order confirm -->