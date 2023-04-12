<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  QC FORM : Upload Form Data
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">                 

               <li class="m-portlet__nav-item">
                  <a href="/" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                  <span>
                  <i class="la la-arrow-left"></i>
                  <span>BACK </span>
                  </span>
                  </a>
               </li>
               <li class="m-portlet__nav-item">
                <a href="javascript::void(0)" id="btnImportSample"  class="btn btn-accent m-btn m-btn--custom m-btn--icon">
                    <span>
                        <i class="la la-cart-plus"></i>
                        <span>Import Data </span>
                    </span>
                </a>
            </li>
            </ul>
         </div>
      </div>
     
     
      <div class="m-portlet__body">
         <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">          
         <!--begin::Form-->
         <form class="m-form m-form--fit m-form--label-align-right ajfileupload" action="{{ route('importOrder') }}" method="POST" enctype="multipart/form-data">
            <div class="m-portlet__body">
            @csrf
                <div class="form-group m-form__group">
                    <label for="exampleInputEmail1">File Browser</label>
                    <div></div>
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <button type="submit" class="btn btn-primary">Upload Now</button>
                    <button type="button" id="btnImportCancel" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>

        <!--end::Form--> 
          
         </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->

