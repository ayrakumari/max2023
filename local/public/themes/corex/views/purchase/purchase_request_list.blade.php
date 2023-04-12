
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
	  <div class="mr-auto">
		<h3 class="m-subheader__title m-subheader__title--separator">Purchase</h3>
		<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
		  <li class="m-nav__item m-nav__item--home">
			<a href="/" class="m-nav__link m-nav__link--icon">
			  <i class="m-nav__link-icon la la-home"></i>
			</a>
		  </li>
		  <li class="m-nav__separator">-</li>
		  <li class="m-nav__item">
			<a href="" class="m-nav__link">
			  <span class="m-nav__link-text">Pending for Purchase List </span>
			</a>
		  </li>    
		 
		</ul>
	  </div>
	  <div>
		
	  </div>
	</div>
  </div>
  
  <!-- END: Subheader -->
<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                   Pending for Purchase List
                </h3>
             </div>
          </div>
          <div class="m-portlet__head-tools">
             <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item" style="display:none">
                   <a href="{{route('orders.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                   <span>
                   <i class="la la-plus"></i>
                   <span>Add New </span>
                   </span>
                   </a>
                </li>
                <li class="m-portlet__nav-item" style="display:none">
                   <a href="{{route('sample.print.all')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon">
                   <span>
                   <i class="la la-print"></i>
                   <span>PRINT </span>
                   </span>
                   </a>
                </li>
             </ul>
          </div>
       </div>
       <div class="m-portlet__body">
          
         <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
               <div class="m-portlet__head-tools">
                  <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
                     <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_1_tab_content" role="tab" aria-selected="true">
                           <i class="la la-cog"></i> Consolidated
                        </a>
                     </li>
                     <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_2_tab_content" role="tab" aria-selected="false">
                           <i class="la la-briefcase"></i> Individual
                        </a>
                     </li>
                    
                  </ul>
               </div>
            </div>
            <div class="m-portlet__body">
               <div class="tab-content">
                  <div class="tab-pane active show" id="m_portlet_base_demo_1_1_tab_content" role="tabpanel">
                     <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_PurchaseRequestTotalList">
                           <thead>
                              <tr>
                                 <th>ID#</th>    
                                 <th>Item Category</th>               
                                 <th>Item code</th>
                                 <th>Item Name</th>
                                 <th>QTY</th>                  
                                 <th>Due Date</th>        
                                 <th>Status</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                        </table>
                        <!--begin: Datatable -->

                  </div>
                  <div class="tab-pane" id="m_portlet_base_demo_1_2_tab_content" role="tabpanel">
                    
                     <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_PurchaseRequestAlertList">
                        <thead>
                           <tr>
                              <th>ID#</th>    
                              <th>Order#</th>
                              <th>Order#S#</th>               
                              <th>Item code</th>
                              <th>Item Name</th>
                              <th>Qty</th>
                              <th>Requested on</th>
                                         
                              <th>Due Date</th>   
                              <th>Requested by</th>           
                              <th>Status</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                     </table>
                     <!--begin: Datatable -->


                  </div>
                  
               </div>
            </div>
         <div></div></div>



       

         
          

       </div>
    </div>
    <!-- datalist -->
 </div>
 <!-- main  -->
 <!-- modal -->
 <!-- Modal -->
 <div class="modal fade" id="view_sent_sample_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLongTitle">Sample</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body">
             <!-- modal content -->
             <table class="table m-table">
                <thead>
                </thead>
                <tbody>
                   <tr>
                      <th><strong>Sample ID</strong></th>
                      <td colspan="3" id="s_id">3</td>
                      <td>Company</td>
                      <td id="s_company" >thsksjkjskjk</td>
                   </tr>
                   <tr>
                      <th><strong>Samples</strong></th>
                      <td colspan="4">
                         <table class="table table-sm m-table m-table--head-bg-metal">
                            <thead class="thead-inverse">
                               <tr>
                                  <th style="color:#000" >#</th>
                                  <th style="color:#000">Item</th>
                                  <th style="color:#000" >Description</th>
                                  <th style="color:#000" >Price/Kg</th>
                               </tr>
                            </thead>
                            <tbody id="itemdata">
                            </tbody>
                         </table>
                      </td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <th><strong>Shipping Address</strong></th>
                      <td colspan="3" id="s_ship_address">444</td>
                      <td>Location</td>
                      <td id="s_location" >444</td>
                   </tr>
                   <tr>
                      <th><strong>Status</strong></th>
                      <td colspan="3" id="s_status">
                      </td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr class="ajrow_tr_c">
                      <th><strong>Courier</strong></th>
                      <td colspan="3">
                         <table class="table table-sm m-table m-table--head-bg-metal">
                            <thead class="thead-inverse">
                               <tr>
                                  <th  style="color:#000">Courier Name</th>
                                  <th  style="color:#000">Tracking ID</th>
                                  <th style="color:#000" >Sent on</th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td id="s_courier_name">
                                  </td>
                                  <td id="s_track_id">
                                  </td>
                                  <td id="s_sent_on">
                                  </td>
                               </tr>
                               <tr colspan="3">
                                  <td>
                                     Courier Remarks
                                  </td>
                                  <td id="s_remarks">
                                  </td>
                               </tr>
                            </tbody>
                         </table>
                      </td>
                      <td></td>
                      <td></td>
                   </tr>
                </tbody>
             </table>
             <div class="ajrow_tr_new">
                <div class="form-group m-form__group row">
                   <div class="col-lg-4">
                      <label>Courier:</label>
                      <select class="form-control m-input m-input--air" id="courier_data">
                         <option value="NULL">-SELECT-</option>
                         @foreach (AyraHelp::getCourier() as $courier)
                         <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                         @endforeach
                      </select>
                   </div>
                   <div class="col-lg-4">
                      <label class="">Sent Date:</label>
                      <div class="input-group date">
                         <input type="text" class="form-control m-input" readonly  id="m_datepicker_3" />
                         <div class="input-group-append">
                            <span class="input-group-text">
                            <i class="la la-calendar"></i>
                            </span>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-4">
                      <label>Status:</label>
                      <select class="form-control m-input m-input--air" id="status_sample">
                         <option value="1">NEW</option>
                         <option value="2">SENT</option>
                         <option value="3">RECEIVED</option>
                         <option value="4">FEEDBACK</option>
                      </select>
                   </div>
                </div>
                <input type="hidden" name="v_s_id" id="v_s_id">
                <div class="form-group m-form__group row">
                   <div class="col-lg-4">
                      <label>Track ID:</label>
                      <input type="text" class="form-control m-input" id="track_id" placeholder="Enter TracK ID">
                   </div>
                   <div class="col-lg-8">
                      <label>Remarks:</label>
                      <textarea class="form-control m-input m-input--air" id="txtRemarksArea" rows="3"></textarea>
                   </div>
                </div>
             </div>
             <!-- modal content -->
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button type="button" id="btnSaveSampleSent" disabled class="btn btn-primary ajrow_tr_new">Save changes</button>
          </div>
       </div>
    </div>
 </div>
 <!-- modal -->
 
 