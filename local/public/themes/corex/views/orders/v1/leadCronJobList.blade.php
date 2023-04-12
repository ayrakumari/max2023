<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Cron Job Missed
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            
              
         </div>
      </div>
     
      <div class="m-portlet__body">

         <?php 
         // echo "<pre>";
          $data_lm=AyraHelp::getLeadMissedRun();
        //   print_r($data_lm);
        //   die;

         ?>

         <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_LEADRUNCRON">
									<thead>
										<tr>
											<th>ID</th>
											<th>Start Date</th>
											<th>Stop Date</th>
											<th>API NAME:</th>											
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
                                    <?php 
                                    $i=0;
                                    foreach ($data_lm as $key => $rowData) {
                                        $i++;
                                       
                                       $data_arr= explode("@",$rowData['api']);
                                       
                                       switch ($data_arr[1]) {
                                        case 'API_1':
                                        $api='INDIAMART-9999XXX@API_1';      
                                               break;
                                        case 'API_2':
                                            $api='INDIAMART-89295XXX@API_2'; 
                                        break;
                                        case 'API_3':
                                            $api='TRADEINDIA-885XXXX@API_3'; 
                                            break;

                                           
                                          
                                       }


                                       ?>
                                            <tr>
											<td>{{$i}}</td>
											<td>{{$rowData['start_date']}}</td>
											<td>{{$rowData['stop_date']}}</td>
											<td>{{{$api}}}</td>											
											<td nowrap></td>
										</tr>
                                       <?php
                                    }
                                    ?>
										
										
									</tbody>
								</table>


    

        
        
      </div>
   </div>
</div>
<!-- main  -->

