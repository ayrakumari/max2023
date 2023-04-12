

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Client Details
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
                                                                <li class="m-portlet__nav-item">
                                                                <a href="{{route('clientv1')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
											<li class="nav-item">
												<a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
                          <i class="flaticon-file-2"></i>
                          Notes
                        </a>
                      </li>
                      <li class="nav-item">
												<a class="nav-link " data-toggle="tab" href="#m_tabs_3_4">
                          <i class="flaticon-box"></i>
                          Sample
                        </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link disabled " data-toggle="tab" href="#m_tabs_3_5">
                            <i class="flaticon-users-1 "></i>
                            Access
                          </a>
                        </li>
                         <li class="nav-item">
                          <a class="nav-link " data-toggle="tab" href="#m_tabs_3_6">
                            <i class="flaticon-users-1 "></i>
                            Orders                            
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
													<i class="la la-thumb-tack m--font-primary"></i>
												</span>
												<h3 class="m-portlet__head-text m--font-primary">
													Client General Information
												</h3>
											</div>
										</div>

									</div>
									<div class="m-portlet__body">
                    <table class="table m-table">
                    <thead>

                    </thead>
                    <tbody>
                      <tr>
                        <th><strong>Company</strong></th>
                        <td colspan="3">{{$client_data->company}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Brand</strong></th>
                        <td colspan="3">{{$client_data->brand}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>GSTIN</strong></th>
                        <td colspan="3">{{$client_data->gstno}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Name</strong></th>
                        <td colspan="3">{{optional($client_data)->firstname}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php 
                      $user = auth()->user();
                      $userRoles = $user->getRoleNames();
                      $user_role = $userRoles[0];
                      if($user_role=='Admin' ||  $user_role=='SalesUser'){
                        ?>
                         <tr>
                        <th><strong>Email</strong></th>
                        <td colspan="3">{{$client_data->email}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Phone</strong></th>
                        <td colspan="3">{{$client_data->phone}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                        <?php                       

                      }
                      ?>
                    
                     

                      <tr>
                        <th><strong>Address</strong></th>
                        <td colspan="3">{{$client_data->address}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Location</strong></th>
                        <td colspan="3">{{$client_data->location}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Webite</strong></th>
                        <td colspan="3">{{$client_data->website}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th><strong>Source</strong></th>
                        <td colspan="3">{{AyraHelp::getClientSource($client_data->source)[0]->source_name}}</td>
                        <td></td>
                        <td></td>
                      </tr>
                      
                      <tr>
                        <th><strong>Status</strong></th>
                        <td colspan="3">

                          <?php 
                           
                            switch ($client_data->group_status) {
                              case '1':
                                 echo '<span class="m-badge m-badge--brand m-badge--wide m-badge--rounded">RAW</span>';
                                break;
                                case '2':
                                  echo '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">LEAD</span>';
                                break;
                                case '3':
                                echo '<span class="m-badge m-badge--primary m-badge--wide m-badge--rounded">QUALIFIED</span>';
                                break;
                                case '4':
                                 echo '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">SAMPLING</span>';
                                break;
                                case '5':
                                 '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">CUSTOMER</span>';
                                break;
                                case '6':
                                 '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">LOST</span>';
                                break;
                                
                              
                              default:
                                # code...
                                break;
                            }

                            ?>
                          
                        </td>
                        <td></td>
                        <td></td>
                      </tr>

                    </tbody>
                  </table>


									</div>
								</div>

								<!--end::Portlet-->


											</div>

						<div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
            <!--begin::Portlet-->
              <div class="m-portlet">
                <div class="m-portlet__head">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <span class="m-portlet__head-icon">
                        <i class="la la-thumb-tack m--font-success"></i>
                      </span>
                      <h3 class="m-portlet__head-text m--font-success">
                      Notes
                      </h3>
                    </div>
                  </div>
                  <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                      <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" data-toggle="modal" data-target="#m_modal_6" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
															<span>
																<i class="flaticon-file-2"></i>
																<span>Add New</span>
															</span>
														</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="m-portlet__body">

                  <!--begin: Datatable -->

								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_clientNotesList">
									<thead>
										<tr>
											<th>ID</th>
                      <th>Message</th>
                      <th>Sechule</th>
											<th>Created By</th>
											<th>Created On</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
                    @foreach ($client_notes as $note)
                    <tr>
                      <td>{{$note->id}}</td>
                      <td>{{$note->message}}</td>
                      <td>
                        <?php 
                          if($note->date_schedule==null or empty($note->date_schedule)){
                            $sh_date="N/A";
                          }else{
                            $sh_date=date('j M Y , H:iA', strtotime($note->date_schedule)) ;
                          }
                          ?>
                        {{$sh_date }}
                      </td>
                      <td>{{ AyraHelp::getUserName($note->user_id)}}</td>
                      <td>{{ date('j M Y , H:iA', strtotime($note->created_at)) }}</td>

                      <td nowrap></td>
                    </tr>
                    @endforeach
                    
									</tbody>
								</table>


						<!-- END EXAMPLE TABLE PORTLET-->

                </div>
              </div>

              <!--end::Portlet-->

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
                    <input type="hidden" name="user_id" id="user_id" value="{{$client_data->id}}">
                    <div class="form-group">
												<label for="message-text" class="form-control-label">*Message:</label>
												<textarea class="form-control" id="txtNotes"  name="txtNotes"></textarea>
                    </div>
                    <div class="form-group m-form__group">
                      <label>Schedule</label>
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

                      </div>
                      
                      
                      <div class="tab-pane" id="m_tabs_3_4" role="tabpanel">
                          {{-- show list of sample  --}}
                         
                          <table class="table " id="m_table_SampletListUserWise">
                            <thead>
                              <tr>
                                <th>ID#</th>
                                <th>Sample ID</th>
                                <th>Company</th>
                                <th>Contact</th>
                                <th>Name</th>
                                <th>Date </th>
                                <th>Sales Person</th>
                                <th>Location</th>
                                <th>Status</th>
                             
                                <th>Actions</th>
                              </tr>
                            </thead>															
                          </table>
                          {{-- show list of sample  --}}

                      </div>
                      <div class="tab-pane" id="m_tabs_3_5" role="tabpanel">
                          
                        {{-- user Access --}}
                        <!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-4">
													<label>Client::</label>
                          <select class="form-control m-input" id="client_id">
                            <option value="{{$client_data->id}}">{{optional($client_data)->firstname}} | {{$client_data->phone}}  | {{$client_data->email}}</option>
                              
                           
                          </select>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label class="">Users:</label>
                          <select class="form-control m-input" id="catsalesUser">
                                
                            <?php 
                    $sales_arr= AyraHelp::getSalesAgent();
                    foreach ($sales_arr as $key => $user) {                         
                      if(Auth::user()->id==$user->id){

                      }else{
                        ?>
                      <option value="{{ $user->id}}">{{$user->name}}</option>
                        <?php
                      }
                      
                    }
                    ?>
                          </select>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-4">
													<label>Duration:</label>
													<div class="input-group m-input-group m-input-group--square">
														<div class='input-group pull-right' id='m_daterangepicker_6'>
                              <input type='text' id="exp_date_range" class="form-control m-input" readonly placeholder="Select date range" />
                              <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                              </div>
                            </div>
														
													</div>
													<span class="m-form__help"></span>
												</div>
											</div>
										
										</div>
										<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions--solid">
												<div class="row">
													<div class="col-lg-4"></div>
													<div class="col-lg-8">
														<button type="button" disabled  id="btnUserAccessRight"  class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-secondary">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</form>

									<!--end::Form-->

                        



                        {{-- user Access --}}

                        {{-- panel --}}
                        <div class="m-portlet m-portlet--mobile">
                          <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                              <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                  Multiple Access List
                                </h3>
                              </div>
                            </div>
                            
                          </div>
                          <div class="m-portlet__body">
            
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                              <thead>
                                <tr>
                                  <th>Record ID</th>
                                  <th>Sales Person Name</th>
                                  <th>Client Name</th>
                                  <th>Contact Name</th>
                                  <?php 
                                    $userRoles=[];
                                    if (Auth::user()) {   // Check is user logged in
                                    $user = auth()->user();
                                    $userRoles = $user->getRoleNames();
                                    $user_role = $userRoles[0];
                                    if($user_role=='Admin'){
                                      ?>
                                       <th>Time Period</th>
                                      <?php
                                    }
                                    }

                                  ?>
                                 
                                  <th>Status</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                              
                                <?php 
                                if(Auth::user()->id!=1){

                                
                                $userAccess_data=AyraHelp::getUserAcessListByUserId(Auth::user()->id);                              
                               
                                foreach ($userAccess_data as $key => $user_data) {
                                 
                                  $now = time(); // or your date as well
                                  $your_date = strtotime($user_data->user_exp_date);
                                  $datediff = $now - $your_date;
                                  $day_c=round($datediff / (60 * 60 * 24));

                                  if(abs($day_c)>=0){
                                    $html="Active";
                                  }else{
                                    $html="Deactived";
                                  }
                                  ?>
                                   <tr>
                                   <td>{{$user_data->id}}</td>
                                   <td>{{AyraHelp::getUserName($user_data->access_to)}}</td>
                                   <td>{{optional(AyraHelp::getClientbyid($user_data->client_id))->firstname}} | {{optional(AyraHelp::getClientbyid($user_data->client_id))->company}}|  {{optional(AyraHelp::getClientbyid($user_data->client_id))->phone}} </td>
                                   <td>{{AyraHelp::getUser($user_data->access_to)->phone}}</td>
                                   <?php 
                                   
                                    $userRoles=[];
                                    if (Auth::user()) {   // Check is user logged in
                                    $user = auth()->user();
                                    $userRoles = $user->getRoleNames();
                                    $user_role = $userRoles[0];
                                    if($user_role=='Admin'){
                                      ?>
                                         <td>{{abs($day_c) }}  days left</td>
                                      <?php
                                    }
                                    }

                                  ?>

                                 
                                  <td>{{$html}}</td>                                 
                                      <td nowrap>
                                          <a href="javascript::void(0)" onclick="deleteUserAccess(<?php echo $user_data->id; ?>)" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                              <i class="fa  flaticon-delete "></i>
                                            </a>
                                      </td>
                                    </tr>
                                  <?php

                                }
                              }
                                  ?>
                               
                                
                              </tbody>
                            </table>
                          </div>

                         
                        </div>
                       
                          {{-- panel --}}

                        </div>
                        <!-- tab start -->
                        <div class="tab-pane " id="m_tabs_3_6" role="tabpanel">
                            
                            

                            list of all orders of Particular Client
                                  
                                  
                             

                        </div>  
                        <!-- tab stop -->

										</div>
                    <!-- end tab -->
                  </div>
                </div>

                            <div id="BO_CLIENT_ORDER_DIV"></div>
                                  
                                  <?= Lava::render('ColumnChart', 'BO_CLIENT_ORDER', 'BO_CLIENT_ORDER_DIV') ?>
                              
                        
					</div>
          <!-- main  -->

      
         