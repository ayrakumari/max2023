<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Production  List
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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

            <style>
               .dt-buttons{
              margin-left: 144px !important;
   
    margin-bottom: -46px !important;

}
                  .btn {
  /* just for this demo. */
  
  margin-top: 5px;
}

.btn-arrow-right,
.btn-arrow-left {
  position: relative;
  padding-left: 18px;
  padding-right: 18px;
}

.btn-arrow-right {
  padding-left: 36px;
}

.btn-arrow-left {
  padding-right: 36px;
}

.btn-arrow-right:before,
.btn-arrow-right:after,
.btn-arrow-left:before,
.btn-arrow-left:after {
  /* make two squares (before and after), looking similar to the button */
  
  content: "";
  position: absolute;
  top: 5px;
  /* move it down because of rounded corners */
  
  width: 22px;
  /* same as height */
  
  height: 22px;
  /* button_outer_height / sqrt(2) */
  
  background: inherit;
  /* use parent background */
  
  border: inherit;
  /* use parent border */
  
  border-left-color: transparent;
  /* hide left border */
  
  border-bottom-color: transparent;
  /* hide bottom border */
  
  border-radius: 0px 4px 0px 0px;
  /* round arrow corner, the shorthand property doesn't accept "inherit" so it is set to 4px */
  
  -webkit-border-radius: 0px 4px 0px 0px;
  -moz-border-radius: 0px 4px 0px 0px;
}

.btn-arrow-right:before,
.btn-arrow-right:after {
  transform: rotate(45deg);
  /* rotate right arrow squares 45 deg to point right */
  
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
}

.btn-arrow-left:before,
.btn-arrow-left:after {
  transform: rotate(225deg);
  /* rotate left arrow squares 225 deg to point left */
  
  -webkit-transform: rotate(225deg);
  -moz-transform: rotate(225deg);
  -o-transform: rotate(225deg);
  -ms-transform: rotate(225deg);
}

.btn-arrow-right:before,
.btn-arrow-left:before {
  /* align the "before" square to the left */
  
  left: -11px;
}

.btn-arrow-right:after,
.btn-arrow-left:after {
  /* align the "after" square to the right */
  
  right: -11px;
}

.btn-arrow-right:after,
.btn-arrow-left:before {
  /* bring arrow pointers to front */
  
  z-index: 1;
}

.btn-arrow-right:before,
.btn-arrow-left:after {
  /* hide arrow tails background */
  
  background-color: white;
}

               </style>

<!--begin: Search Form -->
<form class="m-form m-form--fit m--margin-bottom-20">
  <div class="row m--margin-bottom-20">
    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
      <label>Item Name:</label>
      <input type="text" class="form-control m-input" placeholder="" data-col-index="1">
    </div>
    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
      <label>Order ID</label>
      <input type="text" class="form-control m-input" placeholder="E.g: 37000-300" data-col-index="10">
    </div>
    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
      <label>Production Stages:</label>
      <select class="form-control m-input" data-col-index="9">
        <option value="">Select</option>
        <option value="1">NOT STARTED</option>
        <option value="2">RM PURCHASE</option>
        <option value="3">PLANNED</option>
        <option value="4">IN PROGRESS</option>
        <option value="5">QUALITY CHECK</option>
        <option value="6">COMPLETED</option>
        
      </select>
    </div>
    
    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <label>Order Stages:</label>
        <select class="form-control m-input"   data-col-index="10">
            <option  value="">-SELECT-</option>
           
            @foreach (AyraHelp::getAllStagesData() as $stage)
            <option  value="{{  str_replace('/', '-', $stage->process_name) }}">{{$stage->process_name}}</option>
            @endforeach
           
           
           
    
    </select>
    </div>
    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
      <label>Purchase Stages:</label>
      <select class="form-control m-input" data-col-index="11">
        <option value="">Select</option>
        
        <option value="1">PENDING</option>
        <option value="2">RECIEVED</option>
        
        
      </select>
    </div>

    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
      <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top: 25px;">
        <span>
          <i class="la la-search"></i>
          <span>Search</span>
        </span>
      </button>
      <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top: 25px;">
        <span>
          <i class="la la-close"></i>
          <span>Reset</span>
        </span>
      </button>
    </div>
  
  </div>  
</form>

            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_QCFORMProductionList">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Item Name</th>                            
                            <th>FM/Sample No</th>                                             
                            <th>Order ID </th>
                            <th>Order Name</th>
                            <th>Order Date</th> 
                            <th>Unit Size</th>   
                            <th>No.of Units</th>                           
                            <th>Batch Size</th>                           
                            <th>Production Stage</th> 
                            <th>Order Stage</th>                                                     
                            <th>Purchase Status</th>                                                     
                            <th>Actions</th>
                        </tr>
                    </thead>															
                </table>


    

        
        
      </div>
   </div>
</div>
<!-- main  -->

