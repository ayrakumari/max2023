

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Lead Manager
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
                                                                <li class="m-portlet__nav-item">
                                                                <a href="{{route('home')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                                                                    <span>
                                                                    <i class="la la-arrow-left"></i>
                                                                    <span>Home </span>
                                                                    </span>
                                                                </a>
                                                                </li>

															</ul>
														</div>
													</div>
													<div class="m-portlet__body">



                                                        <!--begin::Form-->
											<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-2">
													<label>Sales Person:</label>
													<select class="form-control m-input" id="salesPerson">
														<option  value="">-SELECT-</option>
														
												        

												</select>
												</div>
												<div class="col-lg-2">
													<label>Type:</label>
													<select class="form-control m-input" id="lead_status">
														<option  value="2">Assined</option>
														<option  value="1">Irrelevant</option>
														<option  value="5">HOLD</option>




												</select>
												</div>


												<div class="col-lg-2">
													<label class="">Month:</label>
												<select name="" id="txtMonth" class="form-control">
                            <?php

                            for($m=1; $m<=12; ++$m){
							  $date='2019-'.$m.'-1';
							  if($m==date('m')){
								?>
								<option selected value="{{$date}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
								<?php
							  }else{
								?>
                              <option value="{{$date}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                              <?php
							  }

                          }

                        ?>
                        </select>
												</div>


                        <div class="col-lg-2">
													<label class="">Year:</label>
                          <select name="" id="txtyear" class="form-control">
                                <?php

                                for($m=2018; $m<=date('Y'); ++$m){

                                ?>
                                <option <?php echo $m== date('Y') ? 'selected' : ''  ?> value="{{$m}}">{{$m}}</option>
                                <?php
                            }

                            ?>
                          </select>
												</div>
                        <div class="col-lg-4">
                        <button type="button" onclick="getLeadLMGraphFilter()" style="margin-top:25px" class="btn btn-primary">Submit</button>
                        <button type="button" onclick="window.history.go(-1); return false;" style="margin-top:25px"   class="btn btn-secondary">Cancel</button>
												</div>

											</div>


										</div>

									</form>




                                        <div id = "AJIPLEAD"></div>






													</div>
													</div>


					</div>
          <!-- main  -->
