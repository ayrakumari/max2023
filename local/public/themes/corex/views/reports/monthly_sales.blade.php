
          <!-- main  -->
          <div class="m-content">
            <!-- datalist -->
           


                <!--Begin::Section-->
                <div class="m-portlet">
                        <div class="m-portlet__body  m-portlet__body--no-padding">
                            <div class="row m-row--no-padding m-row--col-separator-xl">
                                
                                    <div class="col-xl-12">							
            
                                        <?php 
                                        $sales_arr=AyraHelp::getSalesAgentOnlyWITHSTAFF();       
                                       foreach ($sales_arr as $key => $value) {
                                        if($value->id=='88' 
                                        || $value->id=='77'
                                        || $value->id=='78'
                                        || $value->id=='84'
                                        || $value->id=='87'
                                        || $value->id=='89'
                                        || $value->id=='91'
                                        || $value->id=='93'
                                        || $value->id=='95'
                                        || $value->id=='130'
                                        || $value->id=='131'
                                        || $value->id=='132'

                                         ){

                                        }else{
                                            $s_userid = $value->id;
                                           $bo_level='BO_SALES'.$s_userid;
                                           $bo_levelDIV='BODIVMONTLY'.$s_userid;
                        
                                           ?>
                                           <div class="col-xl-12">							
                        
                                                   <div id="<?php echo $bo_levelDIV ?>"></div>
                                                   
                                                   <?= Lava::render('ColumnChart', $bo_level, $bo_levelDIV) ?>
                                               
                                               </div>
                                           <?php
                                        }
                                           
                        
                                       }
                                       ?>     
            
                                        
                                    
                                
                                
                             </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet">
                        <div class="m-portlet__body  m-portlet__body--no-padding">
                            <div class="row m-row--no-padding m-row--col-separator-xl">
                                       
                                       <?php
                                       $data_arr=AyraHelp::getAllRepeatOrNewValue();
                                        ?>

                                    <div class="col-xl-12">	
                                    Total Values of Repeat Order: {{$data_arr['repeat_order_val']}}
                                    </div>
                                    <div class="col-xl-12">	
                                    Total Values of NEW Order: {{$data_arr['new_order_val']}}
                                    </div>
                            </div>
                        </div>
                     </div>   

                    

          </div>
        
        


