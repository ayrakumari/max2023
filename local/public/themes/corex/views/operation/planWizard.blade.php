<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile" style="margin-top: -94px;">
      
      
     
            <!--begin::Portlet-->
								
<!--begin: Form Wizard-->
<div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">


<!--end: Message container -->

<!--begin: Form Wizard Head -->
<div class="m-wizard__head m-portlet__padding-x">

    <!--begin: Form Wizard Progress -->
    <div class="m-wizard__progress">
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <!--end: Form Wizard Progress -->

    <!--begin: Form Wizard Nav -->
    <div class="m-wizard__nav">
        <div class="m-wizard__steps">
            <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                <a href="#" class="m-wizard__step-number">
                    <span><i class="fa  flaticon-placeholder"></i></span>
                </a>
                <div class="m-wizard__step-info">
                    <div class="m-wizard__step-title">
                        1. Plan 
                    </div>                    
                </div>
            </div>
            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                <a href="#" class="m-wizard__step-number">
                    <span><i class="fa  flaticon-layers"></i></span>
                </a>
                <div class="m-wizard__step-info">
                    <div class="m-wizard__step-title">
                        2. Plan
                    </div>
                    
                </div>
            </div>
            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                <a href="#" class="m-wizard__step-number">
                    <span><i class="fa  flaticon-layers"></i></span>
                </a>
                <div class="m-wizard__step-info">
                    <div class="m-wizard__step-title">
                        3. Plan 
                    </div>
                    
                </div>
            </div>
            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                <a href="#" class="m-wizard__step-number">
                    <span><i class="fa  flaticon-layers"></i></span>
                </a>
                <div class="m-wizard__step-info">
                    <div class="m-wizard__step-title">
                        4. Plan 
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    <!--end: Form Wizard Nav -->
</div>

<!--end: Form Wizard Head -->

<!--begin: Form Wizard Form-->
<div class="m-wizard__form" style="margin-top: -50px;">

    <!--
1) Use m-form--label-align-left class to alight the form input lables to the right
2) Use m-form--state class to highlight input control borders on form validation
-->
    <form class="m-form m-form--label-align-left- m-form--state-" id="m_form" action="{{ route('save_plan_wizard')}}"  method="post">
    @csrf
        <!--begin: Form Body -->
        <input type="hidden" id="txtPlanID" name="txtPlanID"  value="{{AyraHelp::getPlanID()}}">
        <div class="m-portlet__body">

            <!--begin: Form Wizard Step 1-->
            <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2">
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Plan Details</h3>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-lg-4 col-form-label">* Select Date:</label>
                                <div class="col-xl-8 col-lg-8">
                                <div class="input-group date">
                                <input type="text" name="txtSelectedDate" class="form-control m-input" readonly  id="m_datepicker_3AB" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
								</div>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-lg-4 col-form-label">* Plan Type:</label>
                                
                                <div class="col-xl-8 col-lg-8">
                                  <select name="plan_type" id="plan_type" class="form-control">
                                  <?php 
                                    $datas=AyraHelp::getPlanOpertionCat();
                                    foreach ($datas as $key => $data) {
                                    ?>
                                        <option value="{{$data->id}}">{{$data->plan_name}}</option>
                                        
                                    <?php
                                    }
                                    ?>      
                                  </select>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-lg-4 col-form-label">* Manpower Expected</label>
                                <div class="col-xl-8 col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-users"></i></span></div>
                                        <input type='text'  name="txtManPowerExpected" class="form-control m-input" id="m_inputmask_6" type="text" />
                                    </div>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-lg-4 col-form-label">* Shift Hours</label>
                                <div class="col-xl-8 col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-clock-o"></i></span></div>
                                        <input type='text'  name="txtworkShiftHour" class="form-control m-input" id="m_inputmask_6A5" type="text" />
                                    </div>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <!-- <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <a href="#" class="btn btn-success" data-wizard-action="nextSave">                                                        
                                            <span>
                                                <span> Save</span>&nbsp;&nbsp;
                                                <i class="la la-save"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div> -->
						</div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end: Form Wizard Step 1-->

            <!--begin: Form Wizard Step 2-->
            <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Select Order to  process</h3>
                            </div>
                            <!--begin: Search Form -->
                                <form class="m-form m-form--fit m--margin-bottom-20">
                                <div class="row m--margin-bottom-20">
                                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                                        <label>Order Stages:</label>
                                        <select class="form-control m-input"   data-col-index="6">
                                            <option  value="">-SELECT-</option>           
                                            @foreach (AyraHelp::getAllStagesData() as $stage)
                                                @if($stage->process_name=='Packaging' || $stage->step_code=='PRODUCTION')
                                                <option  value="{{ $stage->process_name }}">{{$stage->process_name}}</option>
                                                @endif           
                                            @endforeach
                                    </select>
                                    </div>
                                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                                    <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top: 25px;">
                                        <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                        </span>
                                    </button>
                                    </div>
                                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                                    <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top: 25px;">
                                        <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                        </span>
                                    </button>
                                    </div>
                                </div>  
                                </form>

                            
                           <!-- order datable -->
                              <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_tableOPerationHealthPlan">
									<thead>
										<tr>
											<th>Record ID</th>
											<th>Order ID</th>
											<th>Brand Name</th>
											<th>Item Name</th>
											<th>Sales Person</th>
											<th>Date</th>
											<th>Stage</th>
											<th>QTY</th>
                                            <th>Plan QTY</th>
											<th>Actions</th>
										</tr>
									</thead>
									
								</table>

                           <!-- order datable -->

                           
                            
                        </div>
                       

                        
                        
                    </div>
                </div>
            </div>

            <!--end: Form Wizard Step 2-->

            <!--begin: Form Wizard Step 3-->
            <div class="m-wizard__form-step" id="m_wizard_form_step_3">               

                <div class="row">
                    <div class="col-xl-12 offset-xl-0">
                    <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Select Operations & Allot Manpower</h3>
                    </div>       
                    <!--begin::Portlet-->
								<div class="m-portlet">

                                <input type="hidden" id="txtAjVal" name="txtAjVal">
										<!--begin::Section-->
										<div class="m-section">
											<div class="m-section__content">
                                          
												<table class="table table-bordered m-table">
													<thead>
														<tr>
															<th>Date:<input id="txtPDDate" readonly type="text" value="" class="form-control"></th>
															<th>Plan Type:<input id="txtPType"  readonly type="text" value="" class="form-control"></th>
															<th>Man Power:<input id="txtPManPower"  readonly type="text" value="" class="form-control"></th>
															<th>Shift Hour:<input id="txtPShiftHour"  readonly  type="text" value="" class="form-control"></th>
                                                            <th>Manhours:<input id="txtPManHours"  readonly type="text" value="" class="form-control"></th>
                                                           
														</tr>
													</thead>
													<tbody>
														<tr>
															<th colspan="2" scope="row">Total Manhours Remaining to Alloted </th>															

                                                            <th colspan="4"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">456</span></th>															
														</tr>													
														
													</tbody>
												</table>
											</div>
										</div>

										<!--end::Section-->
									

									<!--end::Form-->
								</div>

								<!--end::Portlet-->


                    
                        <!--bigin::Section-->
                        <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_OPHealthPlan3">
									<thead>
										<tr>
											<th>Record ID</th>
											<th>Select Order</th>
											<th>Select Operation</th>
											<th>Req. Qty</th>
											<th>Manhours Req.</th>
											<th>Manpower Alloted</th>
											<th>Hour Alloted</th>                                            
											<th>Achievable Quantity</th>
                                            <th>Manhours Req.</th>
                                            <th>Action</th>
											
										</tr>
									</thead>
									
								</table>

                        <!--end::Section-->
                       
                        
                    </div>
                </div>
            </div>

            <!--end: Form Wizard Step 3-->
             <!--begin: Form Wizard Step 4-->
             <div class="m-wizard__form-step" id="m_wizard_form_step_4">             


                  <!-- order datable -->
                              <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_tableOPerationHealthPlan4">
									<thead>
										<tr>
											<th>Record ID</th>
											<th>Order ID</th>
											<th>Brand Name</th>
											<th>Operation</th>
											<th>Manpower Alloted</th>
											<th>Hours Alloted</th>
											<th>Manhours Alloted</th>
											<th>Achiviable QTY</th>                                           
											<th>Actions</th>
										</tr>
									</thead>
                                    <tfoot>
                                    <tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>                                           
											<th></th>
										</tr>
									</tfoot>
									
								</table>

                           <!-- order datable -->

                          
             </div>
             <!--begin: Form Wizard Step 4-->
        </div>

        <!--end: Form Body -->

        <!--begin: Form Actions -->
        <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4 m--align-left">
                        <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                            <span>
                                <i class="la la-arrow-left"></i>&nbsp;&nbsp;
                                <span>Back</span>
                            </span>
                        </a>
                    </div>
                    <div class="col-lg-4 m--align-right">
                    <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                                        
                                                        <span>
                                                            <span>  Next</span>&nbsp;&nbsp;
                                                            <i class="la la-arrow-right"></i>
                                                        </span>
                                                    </a>

                        
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>

        <!--end: Form Actions -->
    </form>
</div>

<!--end: Form Wizard Form-->




<!--end: Form Wizard-->



		     <!--end::Portlet-->       
       </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->


