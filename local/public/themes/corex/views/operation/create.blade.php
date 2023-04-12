<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Add New Operation
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{route('operationsHealth.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
								

<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="m_form_add_operation" method="post" action="{{ route('orders.store')}}">
@csrf
    <div class="m-portlet__body">
    <div class="form-group m-form__group row">
            <div class="col-lg-6">                
            <label>Category:</label>
            
                <select class="form-control m-input" id="txtOPTCat" name="txtOPTCat">
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
            <div class="col-lg-6">
                <label class="">Type:</label>
                <select class="form-control m-input" id="txtOPType" name="txtOPType" >
                    <option value="1">Automatic</option>
                    <option value="2">Manual</option>                    
                </select>
                <span class="m-form__help"></span>
            </div>            
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label>Operation Name:</label>
                <input type="text" name="txtOperationName" id="txtOperationName" class="form-control m-input" placeholder="">
                <span class="m-form__help"></span>
            </div>
            <div class="col-lg-6">
                <label class="">Product Name:</label>
                <input type="text" name="txtproductName" id="txtproductName" class="form-control m-input" placeholder="">
                <span class="m-form__help"></span>
            </div>            
        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label>Man Power:</label>

                <input type='text'  name="txtManPower" class="form-control m-input" id="m_inputmask_6" type="text" />
                
                <span class="m-form__help"></span>
            </div>
            <div class="col-lg-6">
                <label class="">Manual Time(seconds):</label>
               
                <input type='text'  name="txtManualTime" class="form-control m-input" id="m_inputmask_6A1" type="text" />


                <span class="m-form__help"></span>
            </div>            
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label>Machine Time(seconds):</label>
                
                <input type='text'  name="txtMachineTime" class="form-control m-input" id="m_inputmask_6A2" type="text" />

                <span class="m-form__help"></span>
            </div>
            <div class="col-lg-6">
                <label class="">Output per Cycle Time(seconds):</label>
                <input type="text" name="txtoutputCycleTime" id="txtoutputCycleTime" class="form-control m-input" placeholder="">
                <span class="m-form__help"></span>
            </div>            
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-4">
                <label>Output Unit:</label>                
                <select name="txtoutputUnit" id="txtoutputUnit" class="form-control m-input">
                <option value="1">KG</option>
                <option value="2">PCS</option>
                </select>
                <span class="m-form__help"></span>
            </div>
            <div class="col-lg-4">
                <label class="">Rework %:</label>
                
                <input type='text'  name="txtRework" class="form-control m-input" id="m_inputmask_6A3" type="text" />

                <span class="m-form__help"></span>
            </div>  
            <div class="col-lg-4">
                <label class="">Rejection %:</label>
                
                <input type='text'  name="txtRejection" class="form-control m-input" id="m_inputmask_6A4" type="text" />

                <span class="m-form__help"></span>
            </div>            
        </div>
      
        
    </div>
    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="submit" data-wizard-action="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>							
								<!--end::Portlet-->

        
       </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->


