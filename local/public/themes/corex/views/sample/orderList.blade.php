<!-- main  -->
<div class="m-content">       

   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Order Process Stages
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{route('qcform.list')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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

      <div class="row">
					<div class="col-xl-12">
							<!--begin::Widget 29-->
							<div class="m-widget29">
									<div class="m-widget_content">
										<h3 class="m-widget_content-title">Order Pending By Stages</h3>
										<div class="m-widget_content-items">
										<div class="m-widget_content-items">
	
										<div class="m-widget_content-item">
										<?php 
										$data=AyraHelp::getOrderStuckStatusByStage(1);
										?>
										<span>{{optional($data)->stage_name}}</span>
										<span>
										<span class="m-badge m-badge m-badge-bordered--primary">															
										<a href="{{ route('getOrderList', ['ART_WORK_RECIEVED','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
										<a href="{{ route('getOrderList', ['ART_WORK_RECIEVED','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
										</span>
										</span>
										</div>
	
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(2);
												//$qc_data_arr=AyraHelp::getPendingPurchaseStages();
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">	
	
												<a href="#" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
												<a href="#" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(3);
												?>
												<span>{{optional($data)->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['ART_WORK_REVIEW','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{optional($data)->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['ART_WORK_REVIEW','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{optional($data)->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(4);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['CLIENT_ART_CONFIRM','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['CLIENT_ART_CONFIRM','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(5);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['PRINT_SAMPLE','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['PRINT_SAMPLE','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(6);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['SAMPLE_ARRROVAL','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['SAMPLE_ARRROVAL','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(7);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['PURCHASE_LABEL_BOX','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['PURCHASE_LABEL_BOX','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(8);
												?>
												<span>{{$data->stage_name}}</span>
												
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['PRODUCTION','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['PRODUCTION','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(9);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['QC_CHECK','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['QC_CHECK','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(10);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['SAMPLE_MADE_APPROVAL','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['SAMPLE_MADE_APPROVAL','red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(11);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['PACKING_ORDER','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['PACKING_ORDER','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
										<div class="m-widget_content-item">
												<?php 
												$data=AyraHelp::getOrderStuckStatusByStage(12);
												?>
												<span>{{$data->stage_name}}</span>
												<span>
												<span class="m-badge m-badge m-badge-bordered--primary">															
												<a href="{{ route('getOrderList', ['DISPATCH_ORDER','my_green']) }}" title="Count of Processing"><span class="m-badge m-badge--success">{{$data->green_count}}</span></a> 
												<a href="{{ route('getOrderList', ['DISPATCH_ORDER','my_red']) }}" title="Count of Delayed"><span class="m-badge m-badge--danger">{{$data->red_count}}</span></a>													
												</span>
												</span>
										</div>
															
											</div>
										
										</div>
										<div align="right">
												<span style="margin-bottom: -41px;" class="m-badge m-badge--warning m-badge--wide">Last Updated:{{  AyraHelp::LastUpdateAtStage()}}</span>
												
										</div>
									</div>
								
									
									
								</div>
                                </div>
                                </div>
                 
                           
          {{-- //datalist --}}
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
    
    
         <!--begin: Datatable -->
        {{-- <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_OrderListWizard">
                <thead>
                    
                    <tr>                        
                      
                        <th>Actions</th>
                    </tr>
                </thead>
            </table> --}}
         <!--begin: Datatable -->

<!--begin: Search Form -->
<form class="m-form m-form--fit m--margin-bottom-20">
    <div class="row m--margin-bottom-20">
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <label>Order ID:</label>
            <input type="text" class="form-control m-input" placeholder="E.g: 235" data-col-index="1">
        </div>
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <label>Order Type:</label>
            <select class="form-control m-input" data-col-index="4">
                    <option value="">Select</option>
                    <option value="Private Label">Private Label</option>
                    <option value="Bulk">Bulk</option>
                </select>
        </div>
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <label>Sales Person:</label>
            <select class="form-control m-input"   data-col-index="5">
					<option  value="">-SELECT-</option>
					<?php
					$user = auth()->user();
					$userRoles = $user->getRoleNames();
					$user_role = $userRoles[0];
					?>
					@if ($user_role =="Admin")
					@foreach (AyraHelp::getSalesAgentOnly() as $user)
					<option  value="{{$user->name}}">{{$user->name}}</option>
					@endforeach
					@else
					<option  value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
					@endif
			
			</select>
        </div>
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <label>Brand Name:</label>
            <input type="text" class="form-control m-input" placeholder="Brand Name" data-col-index="3">
        </div>
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px">
                <span>
                    <i class="la la-search"></i>
                    <span>Search</span>
                </span>
            </button>

        </div>
        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
            <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
                <span>
                    <i class="la la-close"></i>
                    <span>Reset</span>
                </span>
            </button>
        </div>
    </div>
    {{-- <div class="row m--margin-bottom-20">
            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Form ID():</label>
                    <input type="text" class="form-control m-input" placeholder="Form ID" data-col-index="6">
                </div>
        
        
    </div> --}}
   
    
</form>

        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_AK">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Order ID</th>
                    <th>Item Name</th>
                    <th>Brand Name</th>
                    <th>Order Type</th>
                    <th>Sales Person</th>                   
                    
                </tr>
            </thead>
            
        </table>
     <!--begin: Datatable -->


        </div>
    </div>
</div>
<!-- main  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_orderComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderString"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="txtorderStepID">
                    <input type="hidden" id="txtOrderID_FORMID">
                    <input type="hidden" id="txtProcess_days">
                    <input type="hidden" id="txtProcess_Name"> 
                    <input type="hidden" id="txtStepCode"> 
                    <input type="hidden" id="expectedDate"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Resp. Person:</label>
                                <select name="order_crated_by" id="order_crated_by" class="form-control">
                                        <?php
                                        $user = auth()->user();
                                        $userRoles = $user->getRoleNames();
                                        $user_role = $userRoles[0];
                                        ?>
                                        @if ($user_role =="Admin" || $user_role =="Staff")
                                        @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                        <option  value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                        @else
                                        <option  value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                        @endif
                                  </select>
                                        
                                </div>   
                        </div>
                       
                    </div>
                    

                                   
                    
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Comment:</label>
                        <textarea class="form-control" id="orderComment">done</textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnProcessComment" class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
                        <span>                              
                            <span>Process Comment</span>
                        </span>
                </button>
                <button type="button" id="btnProcessComplete" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                        <span>                              
                            <span>Process Complete</span>
                        </span>
                </button>

            
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_orderCommentDisplay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="strTitle">Hhh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Icon Tabs
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_1_1_ajcompleted">
													<i class="la la-exclamation-triangle"></i> Completed
												</a>
											</li>
											
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#m_tabs_1_1_ajcommments">
													<i class="la la-cloud-download"></i> Comments
												</a>
											</li>
											
											
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="m_tabs_1_1_ajcompleted" role="tabpanel">
												ddd
											</div>
											<div class="tab-pane" id="m_tabs_1_1_ajcommments" role="tabpanel">
												vff
											</div>
											
											
										</div>
										
										
										
										
										
										
									</div>
								</div>

                                <!--end::Portlet-->
                                
            <div class="modal-body" id="showProDateHere">
               
            
            </div>
            
        </div>
    </div>
</div>




<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_orderDispatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderString"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <!--begin::Form-->
            <form id="myFormFinalDispatch" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="{{ route('UpdateOrderDispatch')}}" method="post">
                                        @csrf
                                            <input type="hidden" id="txtorderStepID1" name="txtorderStepID1">
                                            <input type="hidden" id="txtOrderID_FORMID1" name="txtOrderID_FORMID1">
                                            <input type="hidden" id="txtProcess_days1" name="txtProcess_days1">
                                            <input type="hidden" id="txtProcess_Name1" name="txtProcess_Name1"> 
                                            <input type="hidden" id="txtStepCode1" name="txtStepCode1"> 
                                            <input type="hidden" id="expectedDate1" name="expectedDate1"> 
                                            <div class="m-portlet__body">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-4">
                                                        <label>Resp .Person:</label>
                                                        <select name="order_crated_by" id="order_crated_by" class="form-control">
                                                                <?php
                                                                $user = auth()->user();
                                                                $userRoles = $user->getRoleNames();
                                                                $user_role = $userRoles[0];
                                                                ?>
                                                                @if ($user_role =="Admin" || $user_role =="Staff")
                                                                @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                                                <option  value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                                @else
                                                                <option  value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                                                @endif
                                                        </select>
                                                        <span class="m-form__help"></span>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label for="message-text" class="form-control-label">Comment:</label>
                                                        <textarea class="form-control" id="orderComment" name="orderComment"></textarea>
                                                        <span class="m-form__help"></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-3">
                                                        <label class="">Client Email:</label>
                                                        <input type="text" id="txtClientEmail" name="txtClientEmail"  class="form-control m-input" placeholder="Client Email">
                                                        <span class="m-form__help"></span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="">Client Notify:</label>
                                                        <div class="m-checkbox-list">
                                                                <label class="m-checkbox">
                                                                    <input type="checkbox" id="client_notify" name="client_notify" value="1"> Email Sent
                                                                    <span></span>
                                                                </label>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-lg-3">
                                                            <label class="">Total Order Units:</label>
                                                            <input type="text" id="txtTotalOrderUnit" name="txtTotalOrderUnit"  class="form-control m-input" placeholder="5000">
                                                            <span class="m-form__help"></span>

                                                    </div>
                                                    <div class="col-lg-3">
                                                       
                                                        <div class="m-form__group form-group" style="display:none">
																<label for="">Dispatch Type</label>
																<div class="m-radio-inline">
																	<label class="m-radio">
																		<input type="radio" name="dispatch_type" checked value="1"> Complete 
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio" name="dispatch_type" value="2"> Partial 
																		<span></span>
																	</label>
																	
																</div>
																<span class="m-form__help"></span>
														</div>
                                                    </div>
                                                </div>
                                                {{-- aja --}}
                                                <div id="m_repeater_1">
                                                        <div class="row" id="m_repeater_1">                                                            
                                                            <div data-repeater-list="orderFromData" class="col-lg-12" style="background-color:#ccc;border:1px red">
                                                                <div data-repeater-item class="form-group m-form__group row">
                                                                    
                                                                <div class="col-lg-3">
                                                                        <label class="">LR NO:</label>
                                                                        <input type="text" id="txtLRNo"  name="txtLRNo" class="form-control m-input" placeholder="LR NO">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Transpoter:<span  style="color:red">*</span></label>
                                                                        <input type="text" id="txtTransport"  name="txtTransport" class="form-control m-input" placeholder="Transpoter">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Cartons:</label>
                                                                        <input type="text" id="txtCartons" name="txtCartons"  class="form-control m-input" placeholder="Cartons">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Cartons(Units):</label>
                                                                        <input type="text" id="txtCartonsEachUnit" name="txtCartonsEachUnit" class="form-control m-input" placeholder="Units in Cartons">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Total Units:<span  style="color:red">*</span></label>
                                                                        <input type="text" id="txtTotalUnit"  name="txtTotalUnit" class="form-control m-input" placeholder="Total Units">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Booking For:<span  style="color:red">*</span></label>
                                                                        <input type="text" id="txtBookingFor"  name="txtBookingFor" class="form-control m-input" placeholder="Booking For">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">PO NO.:</label>
                                                                        <input type="text" id="txtPONumber" name="txtPONumber" class="form-control m-input" placeholder="">                                               
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Invoice No:<span  style="color:red">*</span></label>
                                                                        <input type="text" id="txtInvoice" name="txtInvoice" class="form-control m-input" placeholder="Invoice No">                                               
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="">Disptach Date:</label>
                                                                    <input type="text" id="m_datepicker_1" name="txtDispatchDate" class="form-control m-input" placeholder="Dispatch Date">                                               
                                                                    <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Client Email:</label>
                                                                        <input type="text" id="txtClientEmailSend" name="txtClientEmailSend"  class="form-control m-input" placeholder="Client Email">
                                                                        <span class="m-form__help"></span>
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <div data-repeater-delete="" style="margin-top:31px" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                                                                        <span>
                                                                            <i class="la la-trash-o"></i>
                                                                            <span>Remove</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="m-form__group form-group row">
                                                            <label class="col-lg-2 col-form-label"></label>
                                                            <div class="col-lg-4">
                                                                <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                                                    <span>
                                                                        <i class="la la-plus"></i>
                                                                        <span>Add</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                              
                                           
                                                {{-- aja --}}
                                            </div>
                                            
                                      
    
                                        <!--end::Form-->

                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnFinalDispatch" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                        <span>                              
                            <span>Process Complete</span>
                        </span>
                </button>

            
            </div>
        </form>
        </div>
    </div>
</div>

<!--end::Modal-->
