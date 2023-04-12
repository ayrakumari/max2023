

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Edit Order
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

															</ul>
														</div>
													</div>
													<div class="m-portlet__body">
                      <ul class="nav nav-pills" role="tablist">
											<li class="nav-item ">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
                          <i class="la la-gear"></i>
                          General</a>
											</li>

											<li class="nav-item" style="display:none">
												<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
                          <i class="flaticon-users-1"></i>
                          Material Planning
                        </a>
											</li>

										</ul>

                    <div class="tab-content">
											<div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">

                        <!--begin::Portlet-->
              <div class="m-portlet">
                <div class="m-portlet__head">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <span class="m-portlet__head-icon">
                        <i class="flaticon-map-location"></i>
                      </span>
                      <h3 class="m-portlet__head-text">
                      Order  Information
                      </h3>
                    </div>
                  </div>
                  <div class="m-portlet__head-tools">

                  </div>
                </div>
                <div class="m-portlet__body">
                   <!-- form  -->
                   <!--begin::Form-->
                   
                                     <form class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_update_order" method="post" action="{{ route('orders.update', $orders_data->id) }}">
                                       @csrf
																			 @method('PATCH')
                                       <input type="hidden" name="order_index" id="order_index" value="{{$orders_data->order_index}}">
                                       <div class="m-portlet__body">
                                          <div class="m-form__section m-form__section--first">
                                             <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                   <label class="form-control-label">Client:</label>
                                                   <select class="form-control m-select2 client_name" id="m_select2_1" name="client_id">
    																								 <?php

    	 																							foreach (AyraHelp::getClientByadded(Auth::user()->id) as $key => $value) {

    	 																								 if($orders_data->client_id==$value->id){
    	 																								 ?>
    	 																									 <option  value="{{$value->id}}" selected>{{$value->company}} </option>

    	 																								 <?php
    	 																								 }else{
    	 																									 ?>
    	 																										 <option  value="{{$value->id}}" >{{$value->company}}</option>

    	 																									 <?php

    	 																								 }
    	 																							}
    	 																							 ?>

    		 																					</select>
                                                </div>
                                                <div class="col-lg-3 m-form__group-sub" style="display:none">
                                                   <label class="form-control-label">SAMPLE ID:</label>
                                                   <input type="text"  class="form-control m-input" value ="{{$orders_data->sample_code}}" name="sample_id" id="sample_id">
                                                </div>
                                                <div class="col-lg-3 m-form__group-sub">
                                                   <label class="form-control-label">DUE DATE:</label>
                                                   <div class="input-group date">
                                                     <input type="text" class="form-control m-input" readonly value="{{date("d-M-Y", strtotime($orders_data->due_date))}}" name="order_due_date" id="m_datepicker_3" />
                                                     <div class="input-group-append">
                                                       <span class="input-group-text">
                                                         <i class="la la-calendar"></i>
                                                       </span>
                                                     </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="m-form__section m-form__section--first">
                                            <!-- repeater -->

                      <div id="m_repeater_1">
                      <div class="form-group  m-form__group row" id="m_repeater_1">
                     
                      <div data-repeater-list="Orders" class="col-lg-12">
                        @foreach ($ordersItem_data as $orderitem)

                          <div data-repeater-item class="form-group m-form__group row">
                              <div class="col-lg-3">
                                  <label>Item Name:</label>
                                  <input type="text" name="txtOrderItem" value="{{$orderitem['item_name'] }}" class="form-control m-input" placeholder="Enter Item Name">
                                  <span class="m-form__help"></span>
                              </div>
                              <div class="col-lg-2">
                              <label class="">QTY:</label>
                              <input type="text" name="txtQTY" value="{{$orderitem['item_qty'] }}"  class="form-control m-input" placeholder="Enter Qty">
                              <span class="m-form__help"></span>
                            </div>
                            <div class="col-lg-3">
                                <label class=""> Size(ml/gm):</label>
                                <input type="text" name="txtSize" value="{{$orderitem['item_size'] }}" class="form-control m-input" placeholder="Size(ml/gm)">
                                <span class="m-form__help"></span>
                            </div>
                            <div class="col-lg-3">
                                <label class="">Sample ID:</label>
                                <input type="text" name="txtSampleID" value="{{$orderitem['sample_id'] }}"  class="form-control m-input" placeholder="Sample ID if any">
                                <span class="m-form__help"></span>
                              </div>
                              <div class="col-lg-1">                                         
                                  <a href="javascript::void(0)" style="margin-top:30px" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                      <i class="flaticon-delete"></i>
                                    </a>                                           
                                 
                                </div> 
                          </div>


                      @endforeach






                      </div>
                      </div>
                      <div class="m-form__group form-group row">
                      <label class="col-lg-2 col-form-label"></label>
                      <div class="col-lg-4">
                        <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                          <span>
                            <i class="la la-plus"></i>
                            <span>
                                Add More
                            </span>
                          </span>
                        </div>
                      </div>
                      </div>
                      </div>
                      <!-- repeater -->
                                          </div>
                                       </div>
                                       <div class="m-portlet__foot m-portlet__foot--fit">
                                         <div class="m-form__actions m-form__actions">
                                           <div class="row">
                                             <div class="col-lg-12">
                                               <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save Changes</button>
                                               <button type="reset" class="btn btn-secondary">Reset</button>
                                             </div>
                                           </div>
                                         </div>
                                       </div>
                                     </form>

                                     <!--end::Form-->

                   <!-- form  -->

                </div>
              </div>

              <!--end::Portlet-->










											             <!-- general -->

											</div>

											<div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
										              under construction
											</div>

										</div>
                    <!-- end tab -->
                  </div>
                </div>


					</div>
          <!-- main  -->
