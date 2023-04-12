
          <!-- main  -->
          <div class="m-content">
            <!-- datalist -->
            
              						

                    
                <?php 
                  $allStages= DB::table('st_process_stages')->where('process_id',1)->get();  


                   // $allStages=AyraHelp::getAllStagesData();
                    foreach ($allStages as $stage_key => $allStage) {
                        ?>
                        <div id="perf_div_dailyAJ<?php  echo $allStage->stage_id;?>"></div>

                         <?= Lava::render('ColumnChart', "AJ".$allStage->stage_id, 'perf_div_dailyAJ'.$allStage->stage_id) ?>
                        <?php
                        
                    }
                ?>
                <hr>
              </div> 

