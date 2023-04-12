
          <!-- main  -->
<div class="m-content">  
<div class="m-demo__preview m-demo__preview--btn">
                    <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter By
                            </button>
                            <div class="dropdown-menu dropdown-menu-left">
                                <?php 
                                 
                                $user_data=AyraHelp::OrderStageCompletedByUserList();
                                foreach ($user_data as $key => $value) {
                                    // print_r($value);
                                    // die;
                                    ?>
                                       <a href="javascript::void(0)" onclick="showUserwiseDailyStageCopleted({{$value['user_id']}})" class="dropdown-item" type="button">{{$value['user_name']}}</a>

                                    <?php
                                }


                                ?>
                             
                                
                            </div>
                        </div>
                
</div>
<div class="row">
<div class="col-md-12">
    
    <?php 
    $allStages=AyraHelp::getAllStagesData(); 
    foreach ($allStages as $stage_key => $allStage) {
        $myid="AJIP".$allStage->step_code;
        ?>
        <div id = "{{$myid}}">
        </div>
        <?php
    }
    ?>


</div>
</div>




            <div class="m-demo__preview m-demo__preview--btn">
                    <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter By
                            </button>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a href="javascript::void(0)" onclick="showStageReportFilterAll(4)" class="dropdown-item" type="button">Today</a>
                                <a href="javascript::void(0)" onclick="showStageReportFilterAll(1)" class="dropdown-item" type="button">Yestarday</a>
                                <a href="javascript::void(0)" onclick="showStageReportFilterAll(2)" class="dropdown-item" type="button">Last Week</a>
                                <a href="javascript::void(0)" onclick="showStageReportFilterAll(3)" class="dropdown-item" type="button">Last Month</a>
                            </div>
                        </div>
                
            </div>

    <div class="row ajrowShowStagesTeam">
        <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Art work Recived
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(1,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->

           <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Purchase PM
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(2,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


           <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Artwork Review
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(3,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->

          <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Client Art Confirm
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(4,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->

                    <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Print Sample
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(5,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


                              <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Sample Approval Print
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(6,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->

           <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Purchase Box/Label
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(7,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->

          <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Production
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(8,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


          <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Quality Check
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(9,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


           <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Sample Approval product
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(10,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


           <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Packaging
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(11,1);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->


          <!---ajay--------->
        <div class="col-md-4">
            <!--begin::Portlet-->
								<div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon">
                                                        <i class="la la-thumb-tack m--font-success"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text m--font-primary">
                                                        Dispatch
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                   
                                                   
                                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                                        <a href="#" class="m-portlet__nav-link btn btn-secondary  m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill   m-dropdown__toggle">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li  class="m-nav__section m-nav__section--first">
                                                                                <span class="m-nav__section-text">Filter by</span>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                    <a href="javascript::void(0)"  onclick="showStageReportFilter(1,1)" class="m-nav__link">
                                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                                        <span class="m-nav__link-text">Yestarday</span>
                                                                                    </a>
                                                                                </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,2)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Week</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="javascript::void(0)"  onclick="showStageReportFilter(1,3)" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">Last Month</span>
                                                                                </a>
                                                                            </li>                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                           <!--begin::Preview-->
												<div class="m-demo">
                                                        <div class="m-demo__preview">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <?php
                                                                     $mydatas=AyraHelp::getUserCompletedStage(12,1);
                                                                    // print_r($getUserCompletedStage);
                                                                    foreach ($mydatas as $key => $row) {
                                                                       ?>
                                                                       <a href="#" class="m-list-search__result-item">
                                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">{{$row['count']}}</span></span>
                                                                       <span class="m-list-search__result-item-text">{{$row['name']}}</span>
                                                                        </a>
                                                                       <?php
                                                                    }

                                                                     ?>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <!--end::Preview-->

                                        </div>
                                    </div>
    
                                    <!--end::Portlet-->

        </div>
          <!---ajay--------->




          
    </div>       
           
</div>

 <!-- main  -->