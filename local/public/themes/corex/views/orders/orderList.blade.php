<!-- BEGIN: Subheader -->
<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">Orders</h3>
      <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
          <a href="/" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
          </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
          <a href="" class="m-nav__link">
            <span class="m-nav__link-text">Order Processing  Wizard</span>
          </a>
        </li>    
       
      </ul>
    </div>
    <div>
      
    </div>
  </div>
</div>



<!-- main  -->
<div class="m-content">
       

   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                 Order Process Wizard
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{route('qcform.list')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
         
        
    {{-- aba --}}
    <!--begin: Portlet Body-->
    <div class="m-portlet__body m-portlet__body--no-padding">
        <!--begin: Form Wizard-->
        
        <input type="hidden" value="{{ Request::segment(2)}}" id="form_order_id">
        <div class="m-wizard m-wizard--4 m-wizard--brand" id="m_wizard">
            <div class="row m-row--no-padding">
                <div class="col-xl-6 col-lg-12 m--padding-top-20 m--padding-bottom-15">

                    <!--begin: Form Wizard Head -->
                    <div class="m-wizard__head">

                        <!--begin: Form Wizard Nav -->
                        <div class="m-wizard__nav">
                            <div class="m-wizard__steps">
                                <div class="m-wizard__step m-wizard__step--done" m-wizard-target="m_wizard_form_step_1">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>1</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Order Received
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>2</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Design Received from Client
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                    <div class="m-wizard__step-info" >
                                        <a href="#" class="m-wizard__step-number">
                                            <span style="background-color:#3d3698"><span>3</span></span>
                                        </a>
                                        <div class="m-wizard__step-label" >
                                            Review from Printer and Basic Changes
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                        

                                    </div>
                                    <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">3 DAYS</span>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>4</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Share to client for confiration
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">1 DAYS</span>

                                    
                                </div>


                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>5</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Sample Printing
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">7 DAYS</span>

                                    
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_6">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>6</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Sample sent to client to approval on whatup/email                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>                                       

                                    </div>
                                    <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">1 DAYS</span>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_7">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>7</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            On approval order given for printing
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">10 DAYS</span>

                                   
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_8">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>8</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Production
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">7 DAYS</span>

                                    
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_9">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>9</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Quality Check
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">2 DAYS</span>

                                   
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_10">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>10</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            A sample from production with final packing share with the client
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">3 DAYS</span>

                                   
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_11">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>11</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Final Packaging 
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">3 DAYS</span>

                                    
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_12">
                                    <div class="m-wizard__step-info">
                                        <a href="#" class="m-wizard__step-number">
                                            <span><span>12</span></span>
                                        </a>
                                        <div class="m-wizard__step-label">
                                            Quality/Dispatch
                                        </div>
                                        <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                    </div>
                                        <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">1 DAYS</span>

                                        
                                   
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Nav -->
                    </div>

                    <!--end: Form Wizard Head -->
                </div>
                <div class="col-xl-6 col-lg-12">

                    <!--begin: Form Wizard Form-->
                    <div class="m-wizard__form">

                        <!--
    1) Use m-form--label-align-left class to alight the form input lables to the right
    2) Use m-form--state class to highlight input control borders on form validation
-->
                        <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">

                            <!--begin: Form Body -->
                            <div class="m-portlet__body m-portlet__body--no-padding">

                                <!--begin: Form Wizard Step 1-->
                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Order Received </h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="step_1_days" class="form-control m-input" placeholder="" >
                                                <span class="m-form__help"></span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="step_1_remarks" class="form-control m-input" placeholder="" >
                                                <span class="m-form__help"></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                </div>

                                <!--end: Form Wizard Step 1-->

                                <!--begin: Form Wizard Step 2-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Design Received from Client </h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_2_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_2_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>

                                    </div>
                                    
                                   
                                </div>

                                <!--end: Form Wizard Step 2-->

                                <!--begin: Form Wizard Step 3-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Review from Printer and Basic Changes </h3>
                                        </div>
                                        <input type="hidden" name="step_3" value="3">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_3_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}

                                                    <div class="input-group date">
                                                            <input type="text"  name="step_3_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_3_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_3">Save Now</button>
                                        
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 3-->
                                 <!--begin: Form Wizard Step 4-->
                                 <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Share to client for confiration  </h3>
                                        </div>
                                        <input type="hidden" name="step_4" value="4">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_4_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text" name="step_4_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_4_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_4">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 4-->
                                 <!--begin: Form Wizard Step 5-->
                                 <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Sample Printing </h3>
                                        </div>
                                        <input type="hidden" name="step_5" value="5">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_5_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_5_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_5_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_5">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 5-->
                                  <!--begin: Form Wizard Step 6-->
                                  <div class="m-wizard__form-step" id="m_wizard_form_step_6">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> Sample sent to client to approval on whatup/text  </h3>
                                        </div>
                                        <input type="hidden" name="step_6" value="6">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_6_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_6_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_6_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_6">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 6-->
                                 <!--begin: Form Wizard Step 7-->
                                 <div class="m-wizard__form-step" id="m_wizard_form_step_7">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> On approval order given for printing   </h3>
                                        </div>
                                        <input type="hidden" name="step_7" value="7">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_7_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_7_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_7_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_7">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 7-->
                                <!--begin: Form Wizard Step 8-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_8">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> Production</h3>
                                        </div>
                                        <input type="hidden" name="step_8" value="8">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group date">
                                                                <input type="text"  name="step_8_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                                </div>
                                                         </div>
                                                        <span class="m-form__help"></span>

                                                    {{-- <input type="text" name="step_8_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_8_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_8">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 8-->
                                 <!--begin: Form Wizard Step 9-->
                                 <div class="m-wizard__form-step" id="m_wizard_form_step_9">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> Quality Check </h3>
                                        </div>
                                        <input type="hidden" name="step_9" value="9">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_9_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_9_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_9_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_9">Save Now</button>

                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 9-->
                                <!--begin: Form Wizard Step 10-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_10">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> A sample from production with final packing share with the client </h3>
                                        </div>
                                        <input type="hidden" name="step_10" value="10">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_10_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_10_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_10_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_10">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 10-->
                                <!--begin: Form Wizard Step 11-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_11">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> Final Packaging  </h3>
                                        </div>
                                        <input type="hidden" name="step_11" value="11">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_11_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_11_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_11_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_11">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 11-->
                                <!--begin: Form Wizard Step 12-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_12">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">  Quality/Dispatch  </h3>
                                        </div>
                                        <input type="hidden" name="step_12" value="12">
                                        <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Days:</label>
                                                
                                                <div class="col-xl-9 col-lg-9">
                                                    {{-- <input type="text" name="step_12_days" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span> --}}
                                                    <div class="input-group date">
                                                            <input type="text"  name="step_12_days"  class="form-control m-input" readonly  id="m_datepicker_3" />
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
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Remarks:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input type="text" name="step_12_remarks" class="form-control m-input" placeholder="" >
                                                    <span class="m-form__help"></span>
                                                </div>
                                        </div>
                                        <button class="btn btn-success m-btn m-btn--custom m-btn" id="btnSaveStep_12">Save Now</button>
                                        
                                    </div>
                                </div>

                                <!--end: Form Wizard Step 12-->

                                
                            </div>

                            <!--end: Form Body -->

                            <!--begin: Form Actions -->
                            <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-6 m--align-left">
                                            <a href="#" class="btn btn-brand m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                                <span>
                                                    <i class="la la-arrow-left"></i>&nbsp;&nbsp;
                                                    <span>PREVIOUS</span>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 m--align-right">
                                           
                                            <a href="#" class="btn btn-brand m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                                <span>
                                                    <span> Next </span>&nbsp;&nbsp;
                                                    <i class="la la-arrow-right"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end: Form Actions -->
                        </form>
                    </div>

                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>

        <!--end: Form Wizard-->
    </div>

    <!--end: Portlet Body-->
    {{-- aba --}}
        
      </div>
   </div>
</div>
<!-- main  -->


