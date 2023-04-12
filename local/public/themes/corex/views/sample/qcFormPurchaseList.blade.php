<!-- main  -->
<div class="m-content">
    

   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h6 class="m-portlet__head-text">
                  Purchase  List
                  <input type="hidden" id="txtPurchaseFlag" value="1">
               </h6>
               <table style="margin-left:30px;">
                <tr>
                  <td>																					
                      <h5 class="m--font-info">Orders Pending </h5>
                  </td>
                  <td>
                    <button type="button"  onclick="filterPurchasebydaysAll()" class="btn btn-warning btn-sm"> View All</span></button> 
          
                </td>
                  <td>
                      <button type="button" id="aj3" onclick="filterPurchasebydays(3)" class="btn btn-outline-primary btn-sm"> 3 Days <span class="m-badge m-badge--info">{{  $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(3)}}</span></button> 
            
                  </td>
                  <td>
                      <button type="button" id="aj7" onclick="filterPurchasebydays(7)" class="btn btn-outline-primary btn-sm"> 7 Days <span class="m-badge m-badge--warning">{{  $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(7)}}</span></button> 
            
                  </td>
                  <td>
                      <button type="button" id="aj15" onclick="filterPurchasebydays(15)" class="btn btn-outline-primary btn-sm"> 15 Days <span class="m-badge m-badge--danger">{{  $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(15)}}</span></button> 
                  </td>
                </tr>
              </table>
              <table style="margin-left:30px;">
                <tr>
                  <td>																					
                      <h5 class="m--font-info">Design Stage </h5>
                  </td>
                  <td>
                  <?php 
                  
                  $spcount=AyraHelp::purchaseArtWork();
                  

                  ?>
                      <button type="button" onclick="purchaseArtWorkVal(1)" class="btn btn-outline-default btn-sm"> Client End (AR) <span class="m-badge m-badge--info">{{$spcount['artwork_count']}}</span></button> 
                     
            
                  </td>
                  <td>
                      <button type="button" onclick="purchaseArtWorKAllOther(2)" class="btn btn-outline-default btn-sm"> Our End(All) <span class="m-badge m-badge--warning">{{$spcount['allothers']}}</span></button> 
            
                  </td>
                  
                </tr>
              </table>
            </div>
          
         </div>
         
         
      </div>
      <div style="margin:8px 0px -16px 27px;">
      <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">NOT STARTED <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(1)}}</span></span>
          <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">DESIGN <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(2)}}</span></span>
          <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">QUOTATION <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(3)}}</span></span>
          <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">SAMPLE <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(4)}}</span></span>
          <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">PAYMENT <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(5)}}</span></span>
          <span style="margin-right:1px;"  class="m-badge m-badge--info m-badge--wide m-badge--rounded">ORDERED <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(6)}}</span></span>
          <span style="margin-right:1px;"  class="m-badge m-badge--info m-badge--wide m-badge--rounded">IN STOCK <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(7)}}</span></span>
          <span style="margin-right:1px;"  class="m-badge m-badge--info m-badge--wide m-badge--rounded">FROM CLIENT <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(8)}}</span></span>
 
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
        <label>Material Name:</label>
        <input type="text" class="form-control m-input" placeholder="Enter Item Name" data-col-index="1">
      </div>
      <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <label>Category:</label>
        
        <select class="form-control m-input" data-col-index="5">
          <option value="">ALL</option>
            <?php 
        $data_arrs=AyraHelp::getBOMItemCategory();
       
        foreach ($data_arrs as $key => $data_arr) {
         
          ?>
           <option value="{{ $data_arr->cat_name}}">{{ $data_arr->cat_name}}</option>
          <?php

        }
        ?>
          </select>

      </div>
      <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <label>Stages:</label>
        <select class="form-control m-input" data-col-index="7">
          <option value="">ALL</option>
          <option value="1">NOT STARTED</option>
          <option value="2">DESIGN AWAITED</option>
          <option value="3">WAITING FOR QUOTATION</option>
          <option value="4">SAMPLE AWAITED</option>
          <option value="5">PAYMENT AWAITED</option>
          <option value="6">ORDERED</option>
          <option value="7">RECEIVED /IN STOCK</option>
          <option value="8">AWAITED FROM CLIENT</option>
          
        </select>
      </div>
      <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <label>Item Name:</label>
        <input type="text" class="form-control m-input" placeholder="Item Name" data-col-index="4">
      </div>
      <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px">
          <span>
            <i class="la la-search"></i>
            <span>Search</span>
          </span>
        </button>
      </div>
      <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
        <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
          <span>
            <i class="la la-close"></i>
            <span>Reset</span>
          </span>
        </button>
        
      </div>

    </div>
    
    
    
  </form>
  <input hidden type="text" id="txtNumberofdays">
  



           {{-- <button type="button" class="btn btn-info btn-arrow-right">At Work</button>
           <button type="button" class="btn btn-warning btn-arrow-right">Purchase</button>
           <button type="button" class="btn btn-danger btn-arrow-right">Production</button>
            --}}
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_QCFORMPurchaseList">
                    <thead>
                        <tr>
                            <th>ID#</th>                                                       
                            <th>Material Name</th>                            
                            <th>Order ID</th>                                             
                            <th>Order Name </th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>QTY</th> 
                            <th>Statge On</th>   
                            <th>Order Statge </th>   
                            <th>Actions</th>
                        </tr>
                    </thead>															
                </table>


    

        
        
      </div>
   </div>



   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              List of Modified Orders 
            </h3>
          </div>
        </div>
        
      </div>
      <div class="m-portlet__body">

       
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_ListOFUpd7atedBOM">
          <thead>
              <tr>
                  <th>ID#</th>                                                       
                  <th>Material Name</th>                            
                  <th>Order ID</th>                                             
                 
                  <th>Item Name</th>
                  <th>Category</th>
                  <th>QTY</th> 
                  <th>Statge On</th>                 
                  <th>Actions</th>
              </tr>
          </thead>
         
        </table>
      </div>
    </div>

  

</div>
<!-- main  -->



<!-- ajayImg -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_showQCFormDataIMG_Purchase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
  <div class="modal-dialog modal-lg" role="document" style="background:transparent">
      <div class="modal-content" style="background: transparent;">    
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>     
          <div class="modal-body">            
              
								<!--begin::Portlet-->
								<div class="m-portlet">
									
									<div class="m-portlet__body">
										<ul class="nav nav-pills nav-fill" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#m_tabs_5_1">Order Packaging Photo</a>
											</li>
											
										
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                          <!--begin::Section-->
										<div class="m-section">
                        <div class="m-section__content">
                            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="400" style="overflow:hidden; height: 580px" >
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-10">
                                        <div class="center" id="MyIMGSHOW">
                                        </div>
                                       
                                    </div>
                                     

                                    </div>
                            </div>
                        </div>
                      </div>
  
                      <!--end::Section-->

											</div>
											
										
										
										</div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                     
                  </div>
								</div>

                <!--end::Portlet-->
                
          </div>
          
      </div>
  </div>
</div>

<!--end::Modal-->
<!-- ajayImg -->
