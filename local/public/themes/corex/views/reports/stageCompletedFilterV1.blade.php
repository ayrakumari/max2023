<!-- main  -->
<div class="m-content">
<!-- datalist -->
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
													Order Stages Completed
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-2">
												<label>Filter By:</label>
                                                <select class="form-control m-input" id="filterFor" name="filterFor">
                                                    <option value="1">Today</option>
													<option value="2">Yestarday</option>
													<option value="3">Week</option>
													<option value="4">This month</option>																									</select>                                              

												
												</div>
												<div class="col-lg-3">
                                               		<label>Stage:</label>
													<select class="form-control m-input" name="stageName">
														<option  value="">-SELECT-</option>                                               
														@foreach (AyraHelp::getAllStagesDataV1() as $stage)
														<option  value="{{   $stage->stage_id }}">{{$stage->stage_name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-lg-3">
												<a href="javascript::void(0)" onclick="showFilterStageCompleted()" class="btn btn-primary m-btn m-btn--icon" style="margin-top: 25px;">
															<span>
																<i class="la la-archive"></i>
																<span>Submit</span>
															</span>
														</a>
												</div>
											</div>
											<br>
											<div class="form-group m-form__group row">
												
                                            <!-- ajdatalist -->
                                            <!--begin: Datatable -->
											

								<table class="table table-striped- table-bordered table-hover table-checkable" id="Am_table_ListOfStageCompletedFilter">
									<thead>
										<tr>
											<th>Record ID</th>
											<th>Order ID</th>
											<th>Brand Name</th>
											<th>Item Name</th>
											<th>Created By</th>
											<th>Completed on</th>
											<th>Completed by</th>
											<th>Type</th>
											<th>Actions</th>
										</tr>
									</thead>
									
								</table>

                                            <!-- ajdatalist -->

											</div>
											
										</div>
										
									</form>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->
                                </div>
                                </div>
<!-- datalist -->
</div> 




<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_showOrderStagesData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Stages</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!--begin::Section-->
        <div class="m-section">           
                <div class="m-section__content">
                  <table class="table table-sm m-table m-table--head-bg-brand">
                    <thead class="thead-inverse">
                      <tr>
                        <th>Order ID</th>
                        <th>Brand Name</th>
                        <th>Item Name</th>
                        <th>Recieved On</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="txtOSOrderID"></td>
                        <td id="txtOSBrandName"></td>
                        <td id="txtOSItemName"></td>
                        <td id="txtOSRecivedON"></td>
                      </tr>
    
                     
                          
                       
    
                      
                    </tbody>
                  </table>
                </div>
              </div>
    
              <!--end::Section-->


        <!--begin::Portlet-->
        <div class="m-portlet">
                
                <div class="m-portlet__body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#m_tabs_1_1">
                                Stages Details
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#m_tabs_1_2_bomDetails">
                                BOM Details
                            </a>
                        </li>
                       
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                                <div class="m-widget6">
                                        <div class="m-widget6__head">
                                          <div class="m-widget6__item">
                                            <span class="m-widget6__caption">
                                              Stage Name
                                            </span>
                                            <span class="m-widget6__caption">
                                              Completed Date
                                            </span>
                                            <span class="m-widget6__caption m--align-right">
                                                Completed By
                                            </span>
                                          </div>
                                        </div>
                                        <div class="m-widget6__body aj_orderViewData">
                                          
                                          
                                        </div>
                                        <style>
                                          /* A totally custom override */
                             
                                          .flexer,.progress-indicator{display:-webkit-box;display:-moz-box;display:-ms-flexbox;display:-webkit-flex;display:flex}.no-flexer,.progress-indicator.stacked{display:block}.no-flexer-element{-ms-flex:0;-webkit-flex:0;-moz-flex:0;flex:0}.flexer-element,.progress-indicator>li{-ms-flex:1;-webkit-flex:1;-moz-flex:1;flex:1}.progress-indicator{margin:0 0 1em;padding:0;font-size:80%;text-transform:uppercase}.progress-indicator>li{list-style:none;text-align:center;width:auto;padding:0;margin:0;position:relative;text-overflow:ellipsis;color:#bbb;display:block}.progress-indicator>li:hover{color:#6f6f6f}.progress-indicator>li.completed,.progress-indicator>li.completed .bubble{color:#65d074}.progress-indicator>li .bubble{border-radius:1000px;width:20px;height:20px;background-color:#bbb;display:block;margin:0 auto .5em;border-bottom:1px solid #888}.progress-indicator>li .bubble:after,.progress-indicator>li .bubble:before{display:block;position:absolute;top:9px;width:100%;height:3px;content:'';background-color:#bbb}.progress-indicator>li.completed .bubble,.progress-indicator>li.completed .bubble:after,.progress-indicator>li.completed .bubble:before{background-color:#65d074;border-color:#247830}.progress-indicator>li .bubble:before{left:0}.progress-indicator>li .bubble:after{right:0}.progress-indicator>li:first-child .bubble:after,.progress-indicator>li:first-child .bubble:before{width:50%;margin-left:50%}.progress-indicator>li:last-child .bubble:after,.progress-indicator>li:last-child .bubble:before{width:50%;margin-right:50%}.progress-indicator>li.active,.progress-indicator>li.active .bubble{color:#337AB7}.progress-indicator>li.active .bubble,.progress-indicator>li.active .bubble:after,.progress-indicator>li.active .bubble:before{background-color:#337AB7;border-color:#122a3f}.progress-indicator>li a:hover .bubble,.progress-indicator>li a:hover .bubble:after,.progress-indicator>li a:hover .bubble:before{background-color:#5671d0;border-color:#1f306e}.progress-indicator>li a:hover .bubble{color:#5671d0}.progress-indicator>li.danger .bubble,.progress-indicator>li.danger .bubble:after,.progress-indicator>li.danger .bubble:before{background-color:#d3140f;border-color:#440605}.progress-indicator>li.danger .bubble{color:#d3140f}.progress-indicator>li.warning .bubble,.progress-indicator>li.warning .bubble:after,.progress-indicator>li.warning .bubble:before{background-color:#edb10a;border-color:#5a4304}.progress-indicator>li.warning .bubble{color:#edb10a}.progress-indicator>li.info .bubble,.progress-indicator>li.info .bubble:after,.progress-indicator>li.info .bubble:before{background-color:#5b32d6;border-color:#25135d}.progress-indicator>li.info .bubble{color:#5b32d6}.progress-indicator.stacked>li{text-indent:-10px;text-align:center;display:block}.progress-indicator.stacked>li .bubble:after,.progress-indicator.stacked>li .bubble:before{left:50%;margin-left:-1.5px;width:3px;height:100%}.progress-indicator.stacked .stacked-text{position:relative;z-index:10;top:0;margin-left:60%!important;width:45%!important;display:inline-block;text-align:left;line-height:1.2em}.progress-indicator.stacked>li a{border:none}.progress-indicator.stacked.nocenter>li .bubble{margin-left:0;margin-right:0}.progress-indicator.stacked.nocenter>li .bubble:after,.progress-indicator.stacked.nocenter>li .bubble:before{left:10px}.progress-indicator.stacked.nocenter .stacked-text{width:auto!important;display:block;margin-left:40px!important}@media handheld,screen and (max-width:400px){.progress-indicator{font-size:60%}}
                             
                             
                                 .progress-indicator.custom-complex {
                                     background-color: #f1f1f1;
                                     padding: 10px 5px;
                                     border: 1px solid #ddd;
                                     border-radius: 10px;
                                 }
                                 .progress-indicator.custom-complex > li .bubble {
                                     height: 12px;
                                     width: 99%;
                                     border-radius: 2px;
                                     box-shadow: inset -5px 0 12px rgba(0, 0, 0, 0.2);
                                 }
                                 .progress-indicator.custom-complex > li .bubble:before,
                                 .progress-indicator.custom-complex > li .bubble:after {
                                     display: none;
                                 }
                             
                                 /* Demo for vertical bars */
                             
                                 .progress-indicator.stepped.stacked {
                                     width: 48%;
                                     display: inline-block;
                                 }
                                 .progress-indicator.stepped.stacked > li {
                                     height: 150px;
                                 }
                                 .progress-indicator.stepped.stacked > li .bubble {
                                     padding: 0.1em;
                                 }
                                 .progress-indicator.stepped.stacked > li:first-of-type .bubble {
                                     padding: 0.5em;
                                 }
                                 .progress-indicator.stepped.stacked > li:last-of-type .bubble {
                                     padding: 0em;
                                 }
                             
                                 /* Nocenter */
                             
                                 .progress-indicator.nocenter.stacked > li {
                                     min-height: 100px;
                                 }
                                 .progress-indicator.nocenter.stacked > li span {
                                     display: block;
                                 }
                             
                                 /* Demo for Timeline vertical bars */
                             
                                 #timeline-speaker-example {
                                     background-color: #2b4a6d;
                                     color: white;
                                     padding: 1em 2em;
                                     text-align: center;
                                     border-radius: 10px;
                                 }
                                 #timeline-speaker-example .progress-indicator {
                                     width: 100%;
                                 }
                                 #timeline-speaker-example .bubble {
                                     padding: 0;
                                 }
                                 #timeline-speaker-example .progress-indicator > li {
                                     color: white;
                                 }
                                 #timeline-speaker-example .time {
                                     position: relative;
                                     left: -80px;
                                     top: 30px;
                                     font-size: 130%;
                                     text-align: right;
                                     opacity: 0.6;
                                     font-weight: 100;
                                 }
                                 #timeline-speaker-example .current-time .time {
                                     font-size: 170%;
                                     opacity: 1;
                                 }
                                 #timeline-speaker-example .stacked-text {
                                     top: -37px;
                                     left: -50px;
                                 }
                                 #timeline-speaker-example .subdued {
                                     font-size: 10px;
                                     display: block;
                                 }
                                 #timeline-speaker-example > li:hover {
                                     color: #ff3d54;
                                 }
                                 #timeline-speaker-example > li:hover .bubble,
                                 #timeline-speaker-example > li:hover .bubble:before,
                                 #timeline-speaker-example > li:hover .bubble:after {
                                     background-color: #ff3d54;
                                 }
                                 #timeline-speaker-example .current-time .sub-info {
                                     font-size: 60%;
                                     line-height: 0.2em;
                                     text-transform: capitalize;
                                     color: #6988be;
                                 }
                                 @media handheld, screen and (max-width: 400px) {
                                     .container {
                                         margin: 0;
                                         width: 100%;
                                     }
                                     .progress-indicator.stacked {
                                         display: block;
                                         width: 100%;
                                     }
                                     .progress-indicator.stacked > li {
                                         height: 80px;
                                     }
                                 }
                             
                                 .progress-indicator > li {
                                 list-style: none;
                                 text-align: center;
                                 width: auto;
                                 padding: 0;
                                 margin: 0;
                                 position: relative;
                                 text-overflow: ellipsis;
                                 color: #121111;
                                 display: block;
                             }
                             
                                 </style>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                             
                                              <h3>Stages</h3>
                                              <ul class="progress-indicator aj_statges_individual">
                          
                                              </ul>
                                                
                                            </div>
                                          </div>
                          
                                      </div>
                        </div>
                        <div class="tab-pane" id="m_tabs_1_2_bomDetails" role="tabpanel">
                            
                        </div>
                       
                        
                    </div>
                    
                    
                    
                </div>
            </div>

            <!--end::Portlet-->

        
         

       
      </div>
      <div class="modal-footer" style="display:none">
      
        <button type="button" class="btn btn-primary">Save Stages</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--end::Modal-->