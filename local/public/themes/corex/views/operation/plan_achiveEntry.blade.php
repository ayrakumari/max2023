<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Make Achievement Report 
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{route('getOperationHealthPlanList')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
            <!--begin::Portlet-->							
            <!--begin: Datatable -->
            <?php 
            $segmentID = Request::segment(2);        
            $data=AyraHelp::getAllPlanDataByPlanID($segmentID); 
            $plan_arr=AyraHelp::getPlanOpertionCatID($data['plan_data']->plan_type);
            ?>
                        
                        
  
                        

                        
                         <input type="hidden" name="txtPlanID_Achivement" id="txtPlanID_Achivement"  value="{{$segmentID}}">
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_PlanViewData">
									<thead>
										<tr>
											
											<th>Order ID</th>
											<th>Brand Name</th>
											<th>Operation</th>
											<th>QTY Achieved</th>
											<th>Manhours Consumed</th>
											<th>Break Down Time</th>
											<th>RM Wait Time</th>
											<th>Rework Time</th>
											<th>Rejection</th>
                                 <th>Remarks</th>
											
										</tr>
									</thead>
									<tbody>
                                    <?php
                                    $i=0;
                                    foreach ($data['planDay4_data'] as $key => $value) {
                                       $i++;
                                    $myqc_data=AyraHelp::getQCFormDate($value->form_id);
                                    $orderid=$myqc_data->order_id."/".$myqc_data->subOrder;
                                    $fid=$value->form_id;                                    
                                    $option_data=AyraHelp::getOperationalHealthBYid($value->operation_id);
                                  ?>
                                        
                                 <tr>
                                 <input class="form-control" type="hidden" value="{{$value->form_id}}"  name="txtFormID#AJ{{$fid}}">                                        
                                 <input class="form-control" type="hidden" value="{{$value->operation_id}}"  id="operation_idAJ{{$fid}}" name="operation_id#AJ{{$fid}}">                                        
											<td>{{$orderid}}</td>
											<td>{{$myqc_data->brand_name}}</td>
											<td>{{$option_data->operation_name}}-{{$option_data->operation_product}}</td>
											
                                 <td><input class="form-control ajviewData"  type="text"  name="achive_qty#AJ{{$fid}}"> </td>
											<td><input class="form-control ajviewData" type="text" name="man_used#AJ{{$fid}}"></td>
											<td><input class="form-control ajviewData" type="text" name="breakdown_time#AJ{{$fid}}" ></td>
											<td><input class="form-control ajviewData" type="text" name="rmwait_time#AJ{{$fid}}"></td>
											<td><input class="form-control ajviewData" type="text" name="rework_time#AJ{{$fid}}"></td>								
                                 <td><input class="form-control ajviewData" type="text" name="rej_pcs#AJ{{$fid}}"></td>								
                                 <td><input class="form-control ajviewData" type="text" name="remarks#AJ{{$fid}}"></td>																	
											
                                 
											
									    	</tr>
                                        <?php
                                    }
                                    ?>

										
										
									</tbody>
								</table>
                       
                        <span class="m-badge m-badge--success m-badge--wide m-badge--rounded blink">Saving....</span>
                       
                       
                        
                     

		
		    <!--end::Portlet-->       
       </div>
         <!-- end tab -->
         
      </div>
   </div>
</div>
<!-- main  -->


