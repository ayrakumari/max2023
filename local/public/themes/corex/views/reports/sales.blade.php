
          <!-- main  -->
          <div class="m-content">
            <!-- datalist -->
            <!-- <div class="m-demo__preview m-demo__preview--btn">
                    <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter By
                            </button>
                            <div class="dropdown-menu dropdown-menu-left">
                                    @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                    
                                    <a href="javascript::void(0)" onclick="showStageReportFilterAll({{$user->di}})" class="dropdown-item" type="button">{{$user->name}}</a>
                                    @endforeach

                               
                               
                            </div>
                        </div>
                
            </div> -->


                <!--Begin::Section-->
               


        


		<div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    
                        <div class="col-xl-12">							

                            <div id="perf_div"></div>
                
                            <?= Lava::render('ColumnChart', 'Finances', 'perf_div') ?>
                            
                            </div>
                            <hr>
                </div>
            </div>
        </div>
        
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    
                    <div class="col-xl-12">							

                        <div id="perf_div_sample"></div>
            
                        <?= Lava::render('ColumnChart', 'SampleFeeback', 'perf_div_sample') ?>
                        
                        </div>

                            
                        
                    
                    
                    
                </div>
            </div>
        </div>

        
<!--begin:: Widgets/Daily Sales-->
                        <div class="m-widget14">
                            <div class="m-widget14__header m--margin-bottom-30">
                                <h3 class="m-widget14__title">
                                    Last 30 days Sample Added Graph
                                </h3>
                                <span class="m-widget14__desc">
                                    Check out each collumn for more details
                                </span>
                            </div>
                            <div class="m-widget14__chart" style="height:120px;">
                                <canvas id="m_chart_daily_sales"></canvas>
                            </div>
                        </div>						

        <!--End::Section-->
        <div class="row" style="display:none">
            <div class="col-xl-12">
                <div id="chart-div"></div>
                <?= Lava::render('PieChart', 'IMDB', 'chart-div') ?>
            </div>
            
        </div>
        
            
                <?php 
                $sales_arr=AyraHelp::getSalesAgentOnly();       
               foreach ($sales_arr as $key => $value) {
                   $s_userid = $value->id;
                   $bo_level='BO'.$s_userid;
                   $bo_levelDIV='BODIV'.$s_userid;

                   ?>
                   <div class="col-xl-12">							

                           <div id="<?php echo $bo_levelDIV ?>"></div>
                           
                           <?= Lava::render('ColumnChart', $bo_level, $bo_levelDIV) ?>
                       
                       </div>
                   <?php

               }
               ?>     
           
        </div>

