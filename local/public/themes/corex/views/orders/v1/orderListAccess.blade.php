<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Orders List 
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
              
         </div>
      </div>
     
      <div class="m-portlet__body">

      <?php

// ajcode



// ajcode


$form_datas = DB::table('qc_forms')

->where('created_by',Auth::user()->id)

->where('is_deleted',0)

->where('dispatch_status',1)

->get();     

 $i=0;

foreach ($form_datas as $key => $rowData) {     

    $fomr_id=$rowData->form_id;
   $form_action_data = DB::table('st_process_action')
   ->where('ticket_id',$fomr_id)   
   ->where('stage_id',1)
   ->first();

   if($form_action_data==null){

    $i++;


     // Start :save on stage 

        DB::table('st_process_action')->insert(

            [

                'ticket_id' => $fomr_id,           

                'process_id' => 1,

                'stage_id' => 1,

                'action_on' => 1,

                'created_at' => date('Y-m-d H:i:s'),

                'expected_date' => date('Y-m-d H:i:s'),

                'remarks' =>'Auto s Completed :DP:1',

                'attachment_id' =>0,

                'assigned_id' =>Auth::user()->id,

                'undo_status' => 1,

                'updated_by' => Auth::user()->id,

                'created_status' => 1,

                'completed_by' => Auth::user()->id,

                'statge_color' => 'completed',

                'action_mark' => 0,

                'action_status' => 0,

            ]

        );

     // Start :save on stage 


    

   }else{

   


   }


}

//echo $i;



 ?>



              
								


            <style>
                .dt-buttons{
              margin-left: 144px !important;
   
    margin-bottom: -46px !important;

}
                  .btn {
  /* just for this demo. */
  
  margin-top: 5px;
}

.btn-arrow-right,
.btn-arrow-left {
  position: relative;
  padding-left: 18px;
  padding-right: 18px;
}

.btn-arrow-right {
  padding-left: 36px;
}

.btn-arrow-left {
  padding-right: 36px;
}

.btn-arrow-right:before,
.btn-arrow-right:after,
.btn-arrow-left:before,
.btn-arrow-left:after {
  /* make two squares (before and after), looking similar to the button */
  
  content: "";
  position: absolute;
  top: 5px;
  /* move it down because of rounded corners */
  
  width: 22px;
  /* same as height */
  
  height: 22px;
  /* button_outer_height / sqrt(2) */
  
  background: inherit;
  /* use parent background */
  
  border: inherit;
  /* use parent border */
  
  border-left-color: transparent;
  /* hide left border */
  
  border-bottom-color: transparent;
  /* hide bottom border */
  
  border-radius: 0px 4px 0px 0px;
  /* round arrow corner, the shorthand property doesn't accept "inherit" so it is set to 4px */
  
  -webkit-border-radius: 0px 4px 0px 0px;
  -moz-border-radius: 0px 4px 0px 0px;
}

.btn-arrow-right:before,
.btn-arrow-right:after {
  transform: rotate(45deg);
  /* rotate right arrow squares 45 deg to point right */
  
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
}

.btn-arrow-left:before,
.btn-arrow-left:after {
  transform: rotate(225deg);
  /* rotate left arrow squares 225 deg to point left */
  
  -webkit-transform: rotate(225deg);
  -moz-transform: rotate(225deg);
  -o-transform: rotate(225deg);
  -ms-transform: rotate(225deg);
}

.btn-arrow-right:before,
.btn-arrow-left:before {
  /* align the "before" square to the left */
  
  left: -11px;
}

.btn-arrow-right:after,
.btn-arrow-left:after {
  /* align the "after" square to the right */
  
  right: -11px;
}

.btn-arrow-right:after,
.btn-arrow-left:before {
  /* bring arrow pointers to front */
  
  z-index: 1;
}

.btn-arrow-right:before,
.btn-arrow-left:after {
  /* hide arrow tails background */
  
  background-color: white;
}

               </style>


           {{-- <button type="button" class="btn btn-info btn-arrow-right">At Work</button>
           <button type="button" class="btn btn-warning btn-arrow-right">Purchase</button>
           <button type="button" class="btn btn-danger btn-arrow-right">Production</button>
            --}}
            <!--begin: Search Form -->
								<form class="m-form m-form--fit m--margin-bottom-20">
									<div class="row m--margin-bottom-20">
										<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
											<label>Sales Person:</label>
											<select class="form-control m-input"   data-col-index="7">
                                                <option  value="">-SELECT-</option>
                                                <?php
                                                $user = auth()->user();
                                                $userRoles = $user->getRoleNames();
                                                $user_role = $userRoles[0];
                                                ?>
                                               	@if ($user_role =="Admin" || $user_role =="SalesHead" || Auth::user()->id==118)
                                                @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                                <option  value="{{$user->name}}">{{$user->name}}</option>
                                                @endforeach
                                                @else
                                                <option  value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
                                                @endif
                                        
                                        </select>
										</div>
										<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
											<label>Stages:</label>
											<select class="form-control m-input"   data-col-index="8">
                                                <option  value="">-SELECT-</option>                                               
                                                @foreach (AyraHelp::getAllStagesDataV1() as $stage)
                                                <option  value="{{  str_replace('/', '-', $stage->stage_name) }}">{{$stage->stage_name}}</option>
                                                @endforeach
                                        </select>

										</div>
                                        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                        <label>Order Type:</label>
											<select class="form-control m-input"   data-col-index="9">
                                                <option  value="">-SELECT-</option>
                                                <option  value="Bulk">Bulk</option>
                                                <option  value="Private Label">Private Label</option>
                                               
                                               
                                               
                                               
                                               
                                        
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
                                        
									</div>
									
									
									
                                </form>
                               
                                
            <table class="table table-striped- table-bordered table-hover table-checkable ajayra" id="m_table_QCFORMList_v1OrderListAcccess">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>ORDER ID</th>                            
                            <th>Brand Name</th>                                                     
                            <th>Item Name </th>                        
                            <th>Created On</th> 
                            <th>Created by</th>   
                            <th>Current Stage</th>                                                                                   
                            <th>Actions</th>
                        </tr>
                    </thead>															
                </table>


    

        
        
      </div>
   </div>
</div>
<!-- main  -->

<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_showQCFormData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
  <div class="modal-dialog modal-lg" role="document" style="background:transparent">
      <div class="modal-content" style="background: transparent;">    
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>     
          <div class="modal-body">            
              
								<!--begin::Portlet-->
								<div class="m-portlet">
									
									<div class="m-portlet__body">
										<ul class="nav nav-pills nav-fill" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_5_1">Order Details</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#m_tabs_5_2">Stages</a>
											</li>
										
										
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                          <!--begin::Section-->
										<div class="m-section">
                        <div class="m-section__content">
                            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="400" style="overflow:hidden; height: 580px">
                          <table class="table m-table m-table--head-bg-primary">
                           
                            <tbody>
                              <tr>
                                <th scope="row"><strong>Order ID<strong></th>
                                <td id="txtOrderId"></td>
                                
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Order Type</strong></th>
                                  <td id="txtOrderType"></td>                                 
                              </tr>
                              <tr>
                                  <th scope="row"><strong> Person</strong></th>
                                  <td id="txtSalesPerson"></td>                                   
                              </tr>
                              <tr>
                                <th scope="row"><strong>Brand Name</strong></th>
                                <td id="txtBrandName"></td> 
                               
                              </tr>
                              <tr>
                                <th scope="row"><strong>Company</strong></th>
                                <td id="txtClientCompany"></td> 
                               
                              </tr>
                              <tr>
                                <th scope="row"><strong>Client GSTNO</strong></th>
                                <td id="txtClientGSTNO"></td> 
                               
                              </tr>
                              <tr>
                                <th scope="row"><strong>Client Address</strong></th>
                                <td id="txtClientAddress"></td> 
                               
                              </tr>
                              <tr>
                                <th scope="row"><strong>Item Name</strong></th>
                                <td id="txtItemName"></td> 
                               
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Client Name</strong></th>
                                  <td id="txtClientName"></td>                               
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Client Email</strong></th>
                                  <td id="txtClientEmail"></td>                               
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Client Phone</strong></th>
                                  <td id="txtClientPhone"></td>                               
                              </tr>
                              
                              <tr>
                                  <th scope="row"><strong>Order Repeat</strong></th>
                                  <td id="txtOrderRepeat"></td>                             
                              </tr>
                              <tr>
                                  <th scope="row"><strong>FM No./S. No</strong></th>
                                  <td id="txtFmS"></td>                                
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Size</strong></th>
                                  <td id="txtSize"></td>                                
                              </tr>

                              <tr>
                                  <th scope="row"><strong>Qty</strong></th>
                                  <td id="txtQty"></td>                                 
                              </tr>

                              <tr>
                                  <th scope="row"><strong>S.P</strong></th>
                                  <td id="txtSP"></td>                                  
                              </tr>
                              <tr>
                                  <th scope="row"><strong>Order Value</strong></th>
                                  <td id="txtOrderval"></td>                                  
                              </tr>
                             
                              <tr>
                                  <th scope="row"><strong>Order For</strong></th>
                                  <td id="txtOrderFor"></td>                                 
                              </tr>

                              <tr>
                                  <th scope="row"><strong>Fragrance</strong></th>
                                  <td id="txtFragrance"></td>                               
                              </tr>
                            </tbody>
                          </table>
                          <div class="moreDataQC">

</div>
                            </div>
                        </div>
                      </div>
  
                     
                      <!--end::Section-->

											</div>
											<div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
											    
											</div>
										
										
										</div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                     
                  </div>
								</div>

                <!--end::Portlet-->
                
          </div>
          
      </div>
  </div>
</div>

<!--end::Modal-->

<!-- ajayImg -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_showQCFormDataIMG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
  <div class="modal-dialog modal-lg" role="document" style="background:transparent">
      <div class="modal-content" style="background: transparent;">    
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>     
          <div class="modal-body">            
              
								<!--begin::Portlet-->
								<div class="m-portlet">
									
									<div class="m-portlet__body">
										<ul class="nav nav-pills nav-fill" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_5_1">Order Packaging Photo</a>
											</li>
											
										
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                          <!--begin::Section-->
										<div class="m-section">
                        <div class="m-section__content">
                            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="400" style="overflow:hidden; height: 580px" >
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                        <div class="center" id="MyIMGSHOW">
                                        </div>
                                       
                                    </div>
                                     

                                    </div>
                            </div>
                        </div>
                      </div>
  
                      <!--end::Section-->

											</div>
											
										
										
										</div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                     
                  </div>
								</div>

                <!--end::Portlet-->
                
          </div>
          
      </div>
  </div>
</div>

<!--end::Modal-->
<!-- ajayImg -->



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
            <form id="myFormFinalDispatch"  class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="{{ route('UpdateOrderDispatch')}}" method="post">
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
                                                        <textarea class="form-control" id="orderComment" name="orderComment">done</textarea>
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
                                                                        <label class="">Transpoter:</label>
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
                                                                        <label class="">Total Units:</label>
                                                                        <input type="text" id="txtTotalUnit"  name="txtTotalUnit" class="form-control m-input" placeholder="Total Units">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Booking For:</label>
                                                                        <input type="text" id="txtBookingFor"  name="txtBookingFor" class="form-control m-input" placeholder="Booking For">
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">PO NO.:</label>
                                                                        <input type="text" id="txtPONumber" name="txtPONumber" class="form-control m-input" placeholder="">                                               
                                                                        <span class="m-form__help"></span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                        <label class="">Invoice No:</label>
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
                <button type="submit" id="" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
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
                <button type="button" id="btnProcessComment_orderList" class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
                        <span>                              
                            <span>Process Comment</span>
                        </span>
                </button>
                <button type="button" id="btnProcessComplete_OrderList" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                        <span>                              
                            <span>Process Complete</span>
                        </span>
                </button>

            
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->



<style>

</style>

<!-- v1 model -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_1_2_GeneralViewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Stage Progress</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
                                         <!-- ajtab -->
                                         <style>
                                         .breadcrumb {
                                                 /*centering*/
    display: inline-block;
    box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.35);
    overflow: hidden;
    border-radius: 5px;
    /*Lets add the numbers for each link using CSS counters. flag is the name of the counter. to be defined using counter-reset in the parent element of the links*/
    counter-reset: flag; 
}

.breadcrumb a {
    text-decoration: none;
    outline: none;
    display: block;
    float: left;
    font-size: 12px;
    line-height: 36px;
    color: white;
    /*need more margin on the left of links to accomodate the numbers*/
    padding: 0 10px 0 60px;
    background: #035496;
    background: linear-gradient(#035496, #035496);
    position: relative;
}
/*since the first link does not have a triangle before it we can reduce the left padding to make it look consistent with other links*/
.breadcrumb a:first-child {
    padding-left: 46px;
    border-radius: 5px 0 0 5px; /*to match with the parent's radius*/
}
.breadcrumb a:first-child:before {
    left: 14px;
}
.breadcrumb a:last-child {
    border-radius: 0 5px 5px 0; /*this was to prevent glitches on hover*/
    padding-right: 20px;
}

/*hover/active styles*/
.breadcrumb a.active, .breadcrumb a:hover{
    background: #008031;
    background: linear-gradient(#008031, #008031);
}
.breadcrumb a.active:after, .breadcrumb a:hover:after {
    background: #008031;
    background: linear-gradient(135deg, #008031, #008031);
}

/*adding the arrows for the breadcrumbs using rotated pseudo elements*/
.breadcrumb a:after {
    content: '';
    position: absolute;
    top: 0; 
    right: -18px; /*half of square's length*/
    /*same dimension as the line-height of .breadcrumb a */
    width: 36px; 
    height: 36px;
    /*as you see the rotated square takes a larger height. which makes it tough to position it properly. So we are going to scale it down so that the diagonals become equal to the line-height of the link. We scale it to 70.7% because if square's: 
    length = 1; diagonal = (1^2 + 1^2)^0.5 = 1.414 (pythagoras theorem)
    if diagonal required = 1; length = 1/1.414 = 0.707*/
    transform: scale(0.707) rotate(45deg);
    /*we need to prevent the arrows from getting buried under the next link*/
    z-index: 1;
    /*background same as links but the gradient will be rotated to compensate with the transform applied*/
    background: #035496;
    background: linear-gradient(135deg, #035496, #035496);
    /*stylish arrow design using box shadow*/
    box-shadow: 
        2px -2px 0 2px rgba(0, 0, 0, 0.4), 
        3px -3px 0 2px rgba(255, 255, 255, 0.1);
    /*
        5px - for rounded arrows and 
        50px - to prevent hover glitches on the border created using shadows*/
    border-radius: 0 5px 0 50px;
}
/*we dont need an arrow after the last link*/
.breadcrumb a:last-child:after {
    content: none;
}
/*we will use the :before element to show numbers*/
.breadcrumb a:before {
    content: counter(flag);
    counter-increment: flag;
    /*some styles now*/
    border-radius: 100%;
    width: 20px;
    height: 20px;
    line-height: 20px;
    margin: 8px 0;
    position: absolute;
    top: 0;
    left: 30px;
    background: #444;
    background: linear-gradient(#444, #222);
    font-weight: bold;
}


.flat a, .flat a:after {
    background: white;
    color: black;
    transition: all 0.5s;
}
.flat a:before {
    background: white;
    box-shadow: 0 0 0 1px #ccc;
}
.flat a:hover, .flat a.active, 
.flat a:hover:after, .flat a.active:after{
    background: #008080;
}

.ajkumar{
    /* background: gray !important; */
   
}

li:disabled {
  background: #dddddd;
}






</style>

                                       <!--begin::Section-->
										<div class="m-section">
											
											<div class="m-section__content">
												<table class="table table-sm m-table m-table--head-bg-brand">
													
													<tbody class="ajorderTable">
														
														
													</tbody>
												</table>
											</div>
										</div>

										<!--end::Section-->
                                        <div class="m-section">
                                        <div class="m-section__content">
                                        <p><span class="m--font-boldest">Order Remarks</span></p>

                                        <table class="table table-sm m-table m-table--head-bg-brand"">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Stage Name | Remarks</th>
                                                <th>Completed Date</th>
                                                <th>Status</th>
                                                <th>Completed By</th>
                                            </tr>
                                            </thead>
                                            <tbody class="StageActionHistoryComments">
                                            
                                            
                                            </tbody>
                                        </table>
                                        <p><span class="m--font-boldest">Order Stages Completed </span></p>

                                        <table class="table table-sm m-table m-table--head-bg-brand"">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Stage Name</th>
                                                <th>Completed Date</th>
                                                <th>Status</th>
                                                <th>Completed By</th>
                                            </tr>
                                            </thead>
                                            <tbody class="StageActionHistory">
                                            
                                            
                                            </tbody>
                                        </table>
                                        

                                       
                                    </div>
                                    <p><span class="m--font-boldest">BOM Details</span></p>
                                    <div id="bomVieAw"></a>
                                     </div>
                                        <!-- a simple div with some links -->
                                        <div class="breadcrumb ajcustomProgessBar" style="text-align: center;">

                                        </div>




                                         <!-- ajtab -->
										
									</div>
									
								</div>
							</div>
						</div>

						<!--end::Modal-->
<!-- v1 model -->








  
       