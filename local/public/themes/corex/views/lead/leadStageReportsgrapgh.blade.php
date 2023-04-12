

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Leads Stages Reports
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

                                                    <?php 
                                                    /*

														<h4>Fresh Lead Graph</h4>	

														<!-- ajcode -->
														<div id="perf_div_1"></div>
															<?= Lava::render('ColumnChart', 'BOLEAD_G2', 'perf_div_1') ?>
														<!-- ajcode -->
														<hr>
														<h4> Irrevant Lead Graph</h4>

														<!-- ajcode -->
														<div id="perf_div_2"></div>
															<?= Lava::render('ColumnChart', 'BOLEAD_G3', 'perf_div_2') ?>
														<!-- ajcode -->

														<hr>
														<h4> Assigned Lead Graph</h4>

														<!-- ajcode -->
														<div id="perf_div_3"></div>
															<?= Lava::render('ColumnChart', 'BOLEAD_G4', 'perf_div_3') ?>
														<!-- ajcode -->

														<hr>

														<h4>Fresh &  Irrevant Lead Graph</h4>


														<!-- ajcode -->
														<div id="perf_div"></div>
															<?= Lava::render('ColumnChart', 'BOLEAD_G1', 'perf_div') ?>
                                                        <!-- ajcode -->
                                                        */
                                                        ?>

                                                        <!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-3">
													<label>Sales Person:</label>
													<select class="form-control m-input" id="salesPerson">
														<option  value="ALL">ALL</option>
														<?php
                                                $user = auth()->user();
                                                $userRoles = $user->getRoleNames();
                                                $user_role = $userRoles[0];
                                                ?>
                                                @if ($user_role =="Admin" || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==171)
                                                @foreach (AyraHelp::getSalesAgentAdmin() as $user)
												@if ($user->id==130 || $user->id==131
												|| $user->id==78
												|| $user->id==83
												|| $user->id==85
												|| $user->id==84
												|| $user->id==87
												|| $user->id==88
												|| $user->id==89
												|| $user->id==91
												|| $user->id==93
												|| $user->id==95
												|| $user->id==98
												|| $user->id==108
												
												

												)

												@else
												<option  value="{{$user->id}}">{{$user->name}}</option>
												@endif
                                               
                                                @endforeach
                                                @else
                                                <option  value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                                @endif
												<option  value="102">DEEPIKA JOSHI</option>
                                        
						  
												</select>
												</div>
                                                <!-- <div class="col-lg-2">
													<label class="">Stages:</label>
                                                    <select class="form-control m-input"   data-col-index="5" id="txtStages">
                                                <option  value="">-SELECT- </option>                                               
                                                @foreach (AyraHelp::getAllStagesLead() as $stage)
                                                <option  value="{{  str_replace('/', '-', $stage->id) }}">{{$stage->stage_name}}</option>
                                                @endforeach
                                               </select>
												</div> -->

												<div class="col-lg-3">
													<label class="">Month:</label>
												<select name="" id="txtMonth" class="form-control">
                            <?php 
                          
                            for($m=1; $m<=12; ++$m){
                              $date='2019-'.$m.'-1';
                              ?>
                              <option value="{{$date}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                              <?php
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
                        <button type="button" onclick="getLeadStagesGraphFilter()" style="margin-top:25px" class="btn btn-primary">Submit</button>
                        <button type="button" onclick="window.history.go(-1); return false;" style="margin-top:25px"   class="btn btn-secondary">Cancel</button>
												</div>
                      
											</div>
										
											
										</div>
									
									</form>


                                    <?php 
    $allStages=AyraHelp::getAllStagesLead(); 
    foreach ($allStages as $stage_key => $allStage) {
        $myid="AJIPLEAD".$allStage->stage_id;
        ?>
        <div id = "{{$myid}}">
        </div>
        <?php
    }
    ?>

                                    




                    
													</div>
													</div>


					</div>
          <!-- main  -->
