<?php 
                $sales_arr=AyraHelp::getSalesAgent();       
               foreach ($sales_arr as $key => $value) {
                   $s_userid = $value->id;
                   $bo_level='BO'.$s_userid;
                   $bo_levelDIV='BODIV'.$s_userid;

                   ?>
                   
                   <?php

               }
               ?>     

<div class="m-content">
						<div class="row">
							<div class="col-lg-12">

								<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
												<h3 class="m-portlet__head-text">
													PIE Chart of Sample Feedback
												</h3>
											</div>
										</div>
									</div>

									<div class="row">
                                    
							            <div class="col-md-12">
                                        <div id="ahat"></div>

                                         <?= Lava::render('PieChart','PIEFinancesOrderValue', 'ahat') ?>

                                        </div>
                                    </div>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->

								

								<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Sample Filter Feedback
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-4">
													<label>Sales Person:</label>
													<select class="form-control m-input" id="salesPerson">
														
														<?php
														$user = auth()->user();
														$userRoles = $user->getRoleNames();
														$user_role = $userRoles[0];
														?>
														@if ($user_role =="Admin")
														@foreach (AyraHelp::getSalesAgentOnly() as $user)
														<option  value="{{$user->id}}">{{$user->name}}</option>
														@endforeach
														@else
														<option  value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
														@endif
						  
												</select>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label class="">Month:</label>
													<select name="" id="txtMonth" class="form-control">
													<option  value="ALL">ALL</option>
                                                            <?php 
                                                        
                                                            for($m=1; $m<=12; ++$m){
                                                            $date='2019-'.$m.'-1';
                                                            ?>
                                                            <option value="{{$date}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                                                            <?php
                                                        }

                                                        ?>
                                                        </select>

													<span class="m-form__help"></span>
												</div>
                                                <div class="col-lg-4">
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
                                                        
													<span class="m-form__help"></span>
												</div>
												
											</div>											
											
										</div>
										<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions--solid">
												<div class="row">
													<div class="col-lg-4"></div>
													<div class="col-lg-8">
														<button type="button" class="btn btn-primary" id="btnShowFiletPIEChart">Submit</button>
														<button type="reset" class="btn btn-secondary">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>
                                    <div id="b_sale"></div>
                                    

									<!--end::Form-->
								</div>

								<!--end::Portlet-->

								
								</div>

								<!--end::Portlet-->
							</div>
                            