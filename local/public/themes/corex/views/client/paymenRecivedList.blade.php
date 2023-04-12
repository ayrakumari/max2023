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
          						<input type="text" class="form-control m-input" placeholder="Company" data-col-index="3">
          					</div>
          					<div class="col-lg-2 m--margin-bottom-1-tablet-and-mobile">
          						<label>Client Name:</label>
          						<input type="text" class="form-control m-input" placeholder="Name" data-col-index="2">
          					</div>
          					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">

          						<button style="margin-top:25px" class="btn btn-brand m-btn m-btn--icon" id="m_search">
          							<span>
          								<i class="la la-search"></i>
          								<span>Search</span>
          							</span>
          						</button>
          						<button style="margin-top:25px" class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
          							<span>
          								<i class="la la-close"></i>
          								<span>Reset</span>
          							</span>
          						</button>
          					</div>
          					<div class="col-lg-6 m--margin-bottom-10-tablet-and-mobile">
          					</div>
          				</div>
          			</form>
          			<div class="m-form__group form-group">
          				<label for="">Payment Status</label>
          				<div class="m-radio-inline">
          					<label class="m-radio">
          						<input checked type="radio" name="payStatusDetail" value="1"> All
          						<span></span>
          					</label>
          					<label class="m-radio">
          						<input type="radio" name="payStatusDetail" value="2"> Received
          						<span></span>
          					</label>
          					<label class="m-radio">
          						<input type="radio" name="payStatusDetail" value="3"> Pending
          						<span></span>
          					</label>
          				</div>
          				<span class="m-form__help">Some help text goes here</span>
          			</div>







          			<!--end::Form-->

          			<!--begin: Datatable -->
          			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_PaymentRequestLIST">
          				<thead>
          					<tr>
          						<th>SN#</th>
          						<th>Payment Date</th>
          						<th>Client Name</th>
          						<th>Company</th>
          						<th>Amount</th>
          						<th>BANK</th>
          						<th>Status</th>
          						<th>Requested On</th>
          						<th>Actions</th>
          					</tr>
          				</thead>

          			</table>

          		</div>
          	</div>

          	<!-- datalist -->

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
          			<span aria-hidden="true">&times;</span>66
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
          							<option value="1">Received</option>
          							<option value="2">Not Received</option>
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