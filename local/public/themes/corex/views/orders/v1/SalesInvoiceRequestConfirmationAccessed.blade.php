<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <!--begin::Portlet-->
	  <?php
                     $data_arr=AyraHelp::getOrderForDispatch();
                                     
					 


					 ?>

      <div class="m-portlet m-portlet--tabs">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x m-tabs-line--right" role="tablist">
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_3_tab_content" role="tab">
														<i class="fa fa-calendar-check-o" aria-hidden="true"></i>New
													</a>
												</li>
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_2_tab_content" role="tab">
														<i class="fa fa-bar-chart" aria-hidden="true"></i>History
													</a>
												</li>
												<div class="m-portlet__head-tools">
												<ul class="m-portlet__nav">
													<li class="m-portlet__nav-item">
													<div class="m-form__group form-group row">																
														<div class="col-12" style="margin-top:5px">
															<div class="m-checkbox-inline">
																<label class="m-checkbox">
																	<input type="radio" checked   name="txtPartialOrder" value="1" > NEW Order
																	<span></span>
																</label>
																<label class="m-checkbox">
																	<input type="radio" name="txtPartialOrder"   value="2" > Partial Order
																	<span></span>
																</label>
															</div>																	
														</div>
													</div>
													</li>
													</ul>
												</div>

												
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<div class="tab-content">
											<div class="tab-pane active" id="m_portlet_base_demo_2_3_tab_content" role="tabpanel">
											    <!-- tab 1 -->
												<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_salesInvoiceRequestAccess">

                                                @csrf
                                                


												
                                                   

													<div class="col-lg-3 m-form__group-sub">
														<label class="form-control-label">* Order ID</label>                                                        
                                                        <select class="form-control m-input myOrderListSelectAccess" name="formNO" id="myOrderListSelect">
                                                        <?php
                                                $HTML ='';
                                                            foreach ($data_arr as $key => $rowData) {
                                                                $data=AyraHelp::getProcessCurrentStage(1,$rowData->form_id);
                                                                $Spname=$data->stage_name;  
															    if($Spname=='Dispatch'){
                                                                    $HTML .='<option selected value="'.$rowData->form_id.'">'.$rowData->order_id."/".$rowData->subOrder.'</option>';

                                                                }

                                                            }
                                                            echo $HTML;
                                                                                    
                                                          ?>
														</select>
											

                                                        
													</div>
                                                    													
												</div>
												<!-- row -->
												

												<div class="txtRepeatAreaAccess">
												
												</div>


												<!-- row -->
												<div class="form-group m-form__group row">
													<div class="col-lg-6 m-form__group-sub">
                                                        <label class="form-control-label">* Complete Buyer Address : </label>
                                                                                        <input type="text" name="complete_buyer_address" id="complete_buyer_address" class="form-control m-input" placeholder="" >
                                                        </div>
                                                        <div class="col-lg-6 m-form__group-sub">
                                                        <label class="form-control-label">* Delivery Address(if any) </label>
                                                                                        <input type="text" name="delivery_address" id="delivery_address"  class="form-control m-input" placeholder="" >
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
															<input type="radio"  value="2" name="dispatch_through">Own Vehicle
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
												<!-- row -->


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
												<!-- row -->

												<div class="form-group m-form__group row">
													<div class="col-lg-3 m-form__group-sub">
													<label class="form-control-label">* Total Cartons </label>
													<input type="text" name="Vno_of_cartons" class="form-control m-input" placeholder="" value="">
													</div>
													<div class="col-lg-3 m-form__group-sub">
													<label class="form-control-label">* Total UNIT </label>
													<input type="text" name="Vno_of_unitData" class="form-control m-input" placeholder="" value="">
													</div>

												<div class="col-lg-6 m-form__group-sub">
												
                          								<div class="row">
														  <div class="col-lg-5">
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
														<div class="col-lg-7">
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

												<!-- row -->

										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions">
												<div class="row">
													<div class="col-lg-12">
														<button type="submit"  class="btn btn-info">Submit</button>
														<button type="reset" class="btn btn-secondary">Cancel</button>
													</div>
												</div>
											</div>
										</div>
												





												</form>
											    <!-- tab 1 -->
											</div>
											<div class="tab-pane" id="m_portlet_base_demo_2_2_tab_content" role="tabpanel">
												<!-- History  -->
												<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_salesInvoiceRequestHIST">
												<thead>
													<tr>
														<th>ID#</th>
														<th>Sales Person</th>                            
														<th>Order ID</th>
														<th>Requested On</th> 
														<th>Status</th>                                                      
														<th>Actions</th>
													</tr>
												</thead>															
											</table>   
												<!-- History  -->
											</div>
											
										</div>
									</div>
								</div>

								<!--end::Portlet-->
						
     
      

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