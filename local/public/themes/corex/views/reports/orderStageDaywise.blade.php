
          <!-- main  -->
          <div class="m-content">
            <!-- datalist -->
            
              						

                    
                <?php 
                    $allStages=AyraHelp::getAllStagesData();
                    foreach ($allStages as $stage_key => $allStage) {
                        ?>
                        <div id="perf_div_daily<?php  echo $allStage->step_code;?>"></div>

                         <?= Lava::render('ColumnChart', $allStage->step_code, 'perf_div_daily'.$allStage->step_code) ?>
                        <?php
                        
                    }
                ?>
                <hr>
              </div> 

