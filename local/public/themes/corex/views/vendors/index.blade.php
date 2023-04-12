
          <!-- main  -->
          <div class="m-content">
						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Vendors List
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
																<li class="m-portlet__nav-item">
																	<a href="{{route('vendors.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-plus"></i>
																			<span>Add New </span>
																		</span>
																	</a>
																</li>
                                <li class="m-portlet__nav-item" style="display:none">
																	<a href="{{route('sample.print.all')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-print"></i>
																			<span>PRINT ALL </span>
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</div>
													<div class="m-portlet__body">

                            




														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_VendortList">
															<thead>
																<tr>
																	<th>ID#</th>
																	<th>Vendor Id</th>
																	<th>Vendor Name</th>																
																	<th>Name </th>	
																	<th>phone</th>
																	<th>Email</th>
																	<th>Action</th>																															
																
																
																</tr>
															</thead>
															
														</table>

													</div>
												</div>

						<!-- datalist -->

					</div>
          <!-- main  -->


         