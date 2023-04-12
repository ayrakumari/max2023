         <!-- main  -->
          <div class="m-content">
						<!-- datalist -->
          

						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	SAP CheckList
																</h3>
															</div>
														</div>
														
													</div>
													<div class="m-portlet__body">
                          
						
							            
                            
                            <!--begin: Search Form -->
								<form class="m-form m-form--fit m--margin-bottom-20">
									<div class="row m--margin-bottom-20">
										
										<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
											<label>Stages:</label>
                      <select class="form-control m-input"   data-col-index="4">
                      <option  value="">-SELECT-</option>                      
                      @foreach (AyraHelp::getAllStagesData() as $stage)
                      <option  value="{{  str_replace('/', '-', $stage->process_name) }}">{{$stage->process_name}}</option>
                      @endforeach
                      </select>
										</div>
                    <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px">
												<span>
													<i class="la la-search"></i>
													<span>Search</span>
												</span>
											</button>
                      <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
												<span>
													<i class="la la-close"></i>
													<span>Reset</span>
												</span>
											</button>
                    </div>
									

                    <div class="col-lg-4 m--margin-bottom-10-tablet-and-mobile">
                    <form class="m-form">
                      <div class="m-form__group form-group">
                        <label for="">Filter Option</label>
                        <div class="m-radio-inline">
                          <label class="m-radio">
                            <input type="radio" name="req_val" value="1" checked> Pending
                            <span></span>
                          </label>
                          <label class="m-radio">
                            <input type="radio" name="req_val" value="2"> Completed
                            <span></span>
                          </label>
                          
                        </div>
                        
                      </div>
                      </div>
                    </form>



									</div>
									
									<div class="m-separator m-separator--md m-separator--dashed"></div>
									
								</form>
                <div class="row">
                
                                <div class="col-md-12">
                                <div class="m-form__group form-group">
                                   
                                    <div class="m-checkbox-inline">
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox" class="ajSap" name="sapCHKFilter" value='1'> Sale Order <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(1)}}</a>  
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox" class="ajSap"  name="sapCHKFilter" value='2'> FG BOM <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(2)}}</a>  
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox"  class="ajSap" name="sapCHKFilter" value='3'> SFG BOM <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(3)}}</a>  
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox"  class="ajSap" name="sapCHKFilter" value='4'> Production <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(4)}}</a>  
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox"  class="ajSap" name="sapCHKFilter" value='5'> Invoice <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(5)}}</a>  
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                            <input type="checkbox"  class="ajSap" name="sapCHKFilter" value='6'> Dispatch <a class="m-badge m-badge--warning">{{ $data_ar=AyraHelp::getSAPLISTPending(6)}}</a>  
                                            <span></span>
                                        </label>                                       
                                    </div>
                                </div>
                               
                            </div>
                            

							              </div>
						

														<!--begin: Datatable -->
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_SAP_CHECKList">
															<thead>
																<tr>
																	<th>ID#</th>
																	<th>Order ID</th>
																	<th>Brand</th>
																	<th>Item Name</th>
																	<th>Current Stage </th>
																	<th>Sales Order</th>
																	<th>FG BOM</th>
                                  <th>SFG BOM</th>
                                  <th>Production</th>
                                  <th>Invoice</th>
                                  <th>Dispatch</th>                                                                   
                                                                                                                                        
																</tr>
															</thead>
															
														</table>

                                                        

													</div>
												</div>

						<!-- datalist -->

					</div>
          <!-- main  -->


          <!-- modal -->
          <!-- Modal -->
						<div class="modal fade" id="view_sent_sample_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Sample</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<!-- modal content -->
                    <table class="table m-table">
                    <thead>

                    </thead>
                    <tbody>
                      <tr>
                        <th><strong>Sample ID</strong></th>
                        <td colspan="3" id="s_id">3</td>
                        <td>Company</td>
                        <td id="s_company" >thsksjkjskjk</td>
                      </tr>


                      <tr>
                        <th><strong>Samples</strong></th>
                        <td colspan="4">
                          <table class="table table-sm m-table m-table--head-bg-metal">
                          <thead class="thead-inverse">
                            <tr>
                              <th style="color:#000" >#</th>
                              <th style="color:#000">Item</th>
                              <th style="color:#000" >Description</th>
                              <th style="color:#000" >Price/Kg</th>
                            </tr>
                          </thead>
                          <tbody id="itemdata">



													</tbody>
												</table>

                        </td>
                        <td></td>
                        <td></td>
                      </tr>

                      <tr>
                        <th><strong>Shipping Address</strong></th>
                        <td colspan="3" id="s_ship_address">444</td>
                        <td>Location</td>
                        <td id="s_location" >444</td>
                      </tr>

                      <tr>
                        <th><strong>Status</strong></th>
                        <td colspan="3" id="s_status">
                        </td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr class="ajrow_tr_c">
                        <th><strong>Courier</strong></th>
                        <td colspan="3">
                          <table class="table table-sm m-table m-table--head-bg-metal">
  													<thead class="thead-inverse">
  														<tr>

  															<th  style="color:#000">Courier Name</th>
  															<th  style="color:#000">Tracking ID</th>
  															<th style="color:#000" >Sent on</th>

  														</tr>
  													</thead>
  													<tbody>
  														<tr>

  															<td id="s_courier_name">

                                </td>
                                <td id="s_track_id">

                                </td>
                                <td id="s_sent_on">

                                </td>

  														</tr>
                              <tr colspan="3">
                                <td>
                                  Courier Remarks
                                </td>
                                <td id="s_remarks">

                                </td>

                              </tr>

  													</tbody>
  												</table>
                        </td>
                        <td></td>
                        <td></td>
                      </tr>

                    </tbody>
                  </table>
                  <div class="ajrow_tr_new">
                    <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                      <label>Courier:</label>


                      <select class="form-control m-input m-input--air" id="courier_data">
                        <option value="NULL">-SELECT-</option>

                              @foreach (AyraHelp::getCourier() as $courier)
                              <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                              @endforeach
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label class="">Sent Date:</label>
                      <div class="input-group date">
                        <input type="text" class="form-control m-input" readonly  id="m_datepicker_3" />
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="la la-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <label>Status:</label>
                      <select class="form-control m-input m-input--air" id="status_sample">
                        <option value="1">NEW</option>
                        <option value="2">SENT</option>
                        <option value="3">RECEIVED</option>
                        <option value="4">FEEDBACK</option>
                      </select>

                    </div>
                  </div>
                  <input type="hidden" name="v_s_id" id="v_s_id">
                  <div class="form-group m-form__group row">
                  <div class="col-lg-4">
                    <label>Track ID:</label>
                    <input type="text" class="form-control m-input" id="track_id" placeholder="Enter TracK ID">

                  </div>
                  <div class="col-lg-8">
                    <label>Remarks:</label>
                    <textarea class="form-control m-input m-input--air" id="txtRemarksArea" rows="3"></textarea>
                  </div>
                  </div>
                  </div>





										<!-- modal content -->

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" id="btnSaveSampleSent" disabled class="btn btn-primary ajrow_tr_new">Save changes</button>
									</div>
								</div>
							</div>
						</div>

          <!-- modal -->
