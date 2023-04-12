
          <!-- main  -->
          <div class="m-content">
            <!-- datalist -->
            <div class="row">
							<div class="col-xl-12">
             <!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Pending proccess List
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">


										<!--begin::Section-->
										<div class="m-section">
											<div class="m-section__content">
												<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
													<thead>
														<tr>
															
															<th>Process Name</th>
															<th>Quantity</th>
															
														</tr>
													</thead>
													<tbody>
														<tr>
                                                        
															<td>MANUFACTURING </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(1)}}</td>	
															
														</tr>
                                                        <tr>
                                                       

															<td>FILLING </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(2)}}</td>	
															
														</tr>
                                                        <tr>
                                                        
															<td>SEAL </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(3)}}</td>												
														</tr>
                                                        <tr>
                                                        
															<td>CAPPING </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(4)}}</td>													
														</tr>
                                                        <tr>
															
															<td>LABEL </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(5)}}</td>															
														</tr>
                                                        <tr>
															
															<td> CODING ON LABEL </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(6)}}</td>															
														</tr>
                                                        <tr>
															
															<td>BOXING </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(7)}}</td>														
														</tr>
                                                        <tr>
														
															<td>CODING ON BOX </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(8)}}</td>																													
														</tr>
                                                        <tr>
															
															<td>SHRINK WRAP </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(9)}}</td>																												
														</tr>
                                                        <tr>
															
															<td>CARTONIZE </td>
															<td>{{$data=AyraHelp::getPendingProcessCount(10)}}</td>																												
														</tr>

														
													</tbody>
												</table>
												<hr>
												<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
													<thead>
														<tr>
															
															<th></th>
															<th></th>
															
														</tr>
													</thead>
													<tbody>
														<tr>                                                        
														<td>Pending Orders </td>
														<td><strong>{{$data=AyraHelp::getPendingOrderCountwithValue(1)}}</strong></td>																
														</tr>  
														<tr>                                                        
														<td>Pending Orders Value </td>
														<td>Rs. <strong>{{$data=AyraHelp::getPendingOrderCountwithValue(2)}}</strong></td>																
														</tr>                                                      
														
													</tbody>
												</table>
												
											</div>
										</div>

										<!--end::Section-->

										
									</div>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->
                                </div>
                                </div>

              						
            <!-- datalist -->
                    
                
               
              </div> 

