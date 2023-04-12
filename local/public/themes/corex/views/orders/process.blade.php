<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
	  <div class="mr-auto">
		<h3 class="m-subheader__title m-subheader__title--separator">Orders</h3>
		<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
		  <li class="m-nav__item m-nav__item--home">
			<a href="/" class="m-nav__link m-nav__link--icon">
			  <i class="m-nav__link-icon la la-home"></i>
			</a>
		  </li>
		  <li class="m-nav__separator">-</li>
		  <li class="m-nav__item">
			<a href="" class="m-nav__link">
			  <span class="m-nav__link-text">Order Processing</span>
			</a>
		  </li>    
		 
		</ul>
	  </div>
	  <div>
		
	  </div>
	</div>
	</div>
	<?php 
	
	$client_arr=AyraHelp::ClinentInfoByOrderID(Request::segment(2));
	//print_r($client_arr);


	?>
  
  <!-- END: Subheader -->

<!-- main  -->
<div class="m-content">

	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Order For: <strong>{{$client_arr->company}}</strong>,{{$client_arr->brand}} {{$client_arr->location}}
							</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<a href="{{route('orders.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
								<span>
								<i class="la la-arrow-left"></i>
								<span>BACK </span>
								</span>
								</a>
							</li>
							<li class="m-portlet__nav-item">
									<a href="javascript::void(0)" id="btnAddMoreOrderItem" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
									<span>
									<i class="la la-arrow-left"></i>
									<span>Add More </span>
									</span>
									</a>
								</li>
					</ul>
				</div>
		</div>
		<div class="m-portlet__body">
				<ul class="nav nav-pills" role="tablist">
					<li class="nav-item ">
							<a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
							<i class="la la-gear"></i>
							Items List</a>
					</li>
					<li class="nav-item" style="display:none">
							<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
							<i class="flaticon-users-1"></i>
							Purchase
							</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
							<!--begin::Portlet-->
							<div class="m-portlet">
								
								<div class="m-portlet__body">
										<!--begin: Datatable -->
										<input type="hidden" name="order_index" id="order_index" value="{{Request::segment(2)}}">
										<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_OrderItemList">
											<thead>
													<tr>
													<th>ID#</th>
													<th>Order#</th>
													<th>Order#S#</th>
														<th>Company</th>
														<th>Item Name</th>
														<th>QTY</th>
														<th>Added on</th>
														<th>Status</th>
														<th>Actions</th>
													</tr>
											</thead>
										</table>
								</div>
							</div>
							<!-- datalist -->
					</div>
					<div class="tab-pane " id="m_tabs_3_3" role="tabpanel">
							-----
					</div>
				</div>
				<!--end::Portlet-->
				<!-- general -->
		</div>
	</div>
	<!-- end tab -->
</div>

<!-- main  -->

<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_addmoreorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">	Item For: <strong>{{$client_arr->company}}</strong>,{{$client_arr->brand}} {{$client_arr->location}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
							<input type="hidden" id="txtOrderId" value="{{Request::segment(2)}}">
						<div class="form-group">
							<label for="recipient-name" class="form-control-label">Item Name::</label>
							<input type="text" class="form-control" id="txtItemName">
						</div>
						<div class="form-group">
							<label for="message-text" class="form-control-label">QTY:</label>
							<input type="text" class="form-control" id="txtItemQTY">
						</div>
						<div class="form-group">
								<label for="message-text" class="form-control-label">Size(ml/gm)::</label>
								<input type="text" class="form-control" id="txtSize" >
							</div>
							<div class="form-group">
									<label for="message-text" class="form-control-label">Sample ID:</label>
									<input type="text" class="form-control"id="txtSampleId" >
							</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="btnSaveOrderItem" class="btn btn-primary">Save Now</button>
				</div>
			</div>
		</div>
	</div>

	<!--end::Modal-->