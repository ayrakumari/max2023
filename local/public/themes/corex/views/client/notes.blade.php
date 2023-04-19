

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Client Notes
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">

															</ul>
														</div>
													</div>
													<div class="m-portlet__body">

                            <!--begin::Form-->
                  <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    <div class="m-portlet__body">
                      <div class="form-group m-form__group row">
                        <div class="col-lg-2">
                          <label>Client Name:</label>
                          <input type="text" class="form-control m-input" placeholder="Enter " data-col-index="1">
                          <span class="m-form__help"></span>
                        </div>


                        <div class="col-lg-4">
                          <label>.</label><br>
                          <button type="button" class="btn btn-primary" id="m_search">Search</button>
                        </div>
                      </div>

                    </div>

                  </form>

                  <!--end::Form-->


														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_NotesList">
															<thead>
																<tr>
																<th>Schedule</th>
																	<th>Name</th>
																	<th>Company</th>
																	<th>Message</th>
																	
																	<th>Created By</th>
																	<th>Created On</th>

																	<th>Actions</th>
																</tr>
															</thead>
															
														</table>

													</div>
												</div>

						<!-- datalist -->

					</div>
          <!-- main  -->
<!-- m_modal_6 -->
              <!-- Modal -->
							<div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Client Notes</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
						<input type="hidden" name="user_id" id="user_id" value="">
						<div class="form-group">
													<label for="message-text" class="form-control-label">*Message:</label>
													<textarea class="form-control" id="txtNotes"  name="txtNotes"></textarea>
											</div>																					

													
													<div class="form-group m-form__group">
														<label>Next Follow Up</label>
														<div class="input-group">
															<input type="text" readonly id="shdate_input" class="form-control" aria-label="Text input with dropdown button">
															<div class="input-group-append">
																<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<i class="la la-calendar glyphicon-th"></i>
																</button>
																<div class="dropdown-menu">
																	<a class="dropdown-item" href="javascript::void(0)" id="aj_today">Today</a>
																	<a class="dropdown-item" href="javascript::void(0)" id="aj_3days" >3 Days</a>
																	<a class="dropdown-item" href="javascript::void(0)" id="aj_7days" >7 Days</a>																	
																	<a class="dropdown-item" href="javascript::void(0)" id="aj_15days" >15 Days</a>
																	<a class="dropdown-item" href="javascript::void(0)" id="aj_next_month" >Next Month</a>
																</div>
															</div>
														</div>
													</div>
										</div>
										<div class="modal-footer">
											<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="button" id="btnClientNotes" class="btn btn-primary">Save</button>
										</div>
									</div>
								</div>
							</div>
			
					<!-- m_modal_6 -->
			