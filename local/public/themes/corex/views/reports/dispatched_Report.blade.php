
<!-- main  -->
<div class="m-content">
<div class="row">
<div class="col-xl-12">	
    <div id="perf_div_Monthly"></div>
    <?= Lava::render('ColumnChart', 'BODISPATCH', 'perf_div_Monthly') ?>
    </div>
</div> 

<hr>
<div class="col-xl-12">	
    <div id="perf_div_Dispatch_Monthly"></div>
    <?= Lava::render('ColumnChart', 'BODISPATCH_MONTHLY', 'perf_div_Dispatch_Monthly') ?>
    </div>
</div> 

<hr>
<?php 
 $user = auth()->user();
 $userRoles = $user->getRoleNames();
 $user_role = $userRoles[0];
 
 if($user_role=='Admin'){
    ?>
    <div class="col-xl-12">	
    <div id="perf_div_Dispatch_MonthlyA"></div>
    <?= Lava::render('ColumnChart', 'BODISPATCH_MONTHLYValue', 'perf_div_Dispatch_MonthlyA') ?>
    </div>
    </div> 
    <?php
 }
?>



</div>





<!-- main  -->