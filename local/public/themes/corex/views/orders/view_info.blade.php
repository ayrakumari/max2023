<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  BOM Information
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
              
               
               <li class="m-portlet__nav-item">
                  <a href="{{route('orders.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
         <ul class="nav nav-pills" role="tablist">
            <li class="nav-item ">
               <a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
               <i class="la la-gear"></i>
               General</a>
            </li>
            <li class="nav-item" style="display:none">
               <a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
               <i class="flaticon-users-1"></i>
               Purchase
               </a>
            </li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">
               <!--begin::Portlet-->
               <div class="m-portlet">
                  <div class="m-portlet__head">
                     <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                           <span class="m-portlet__head-icon">
                           <i class="flaticon-map-location"></i>
                           </span>
                           
                        </div>
                     </div>
                     <div class="m-portlet__head-tools">
                       

                     </div>
                  </div>
                <div class="m-portlet__body">
                  <input type="hidden" name="order_item_id" id="order_item_id" value="{{isset($order_m_items[0]->order_item_id) ? $order_m_items[0]->order_item_id:""}}">
                     <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_orderItemAddedList">
                  <thead>
                  <tr>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Material Name</th>
                  <th>Qty</th>
                  <th>Created  on</th>
                  <th>Created by</th>
                  <th>Remarks</th>                                                          
                  <th>Actions</th>
                  </tr>
                  </thead>
                  </table>
                     </table>
                  </div>
               </div>
               <!--end::Portlet-->
               <!-- general -->
            </div>
            <div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
                 <!-- meterial Planning panel -->


           <div class="m-portlet m-portlet--mobile">
             
             <div class="m-portlet__body">
 <!--begin: Datatable -->
 <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_STOCK_ADDED_TALLYList">
  <thead>
  <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Material Name</th>
          <th>Req.Qty</th>
          <th>In Stock</th>                                               
          <th>Status</th>                                             
         
          <th>Actions</th>
  </tr>
  </thead>
  </table>

               
             </div>
           </div>


                 <!-- meterial Planning panel -->

         </div>
       </div>
         <!-- end tab -->
      </div>
   </div>
</div>
<!-- main  -->


<!-- Modal -->
  <div class="modal fade" id="modal_add_order_bill_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add BIll of Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- modal content -->
          <!--begin::Portlet-->



            <!--begin::Form-->
            <form class="m-form" method="post" action="#" id="frm_submit_billmaterial">
              @csrf
                  <table class="table table-sm m-table m-table--head-bg-brand">
													<thead class="thead-inverse">
														<tr>
															<th>Order ID</th>
															<th>Item Name</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row" id="order_id">1</th>
															<td id="item_name">Jhon</td>
														</tr>

													</tbody>
												</table>
                    <div class="m-separator m-separator--dashed m-separator--sm"></div>
                  <div id="m_repeater_2">
                    <div class="form-group  m-form__group row" id="m_repeater_2">

                      <div data-repeater-list="" class="col-lg-12">
                        <div data-repeater-item class="form-group m-form__group row align-items-center">
                          <div class="col-md-6">
                            <div class="m-form__group m-form__group--inline">
                              <div class="m-form__label">
                                <label>Material:</label>
                              </div>
                              <div class="m-form__control">
                                <input type="text" class="form-control m-input" placeholder="Enter Material Name">
                              </div>
                            </div>
                            <div class="d-md-none m--margin-bottom-10"></div>
                          </div>
                          <div class="col-md-3">
                            <div class="m-form__group m-form__group--inline">
                              <div class="m-form__label">
                                <label class="m-label m-label--single">QTY:</label>
                              </div>
                              <div class="m-form__control">
                                <input type="text" class="form-control m-input" placeholder="Enter QTY">
                              </div>
                            </div>
                            <div class="d-md-none m--margin-bottom-10"></div>
                          </div>

                          <div class="col-md-2">
                            <div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                              <span>
                                <i class="la la-trash-o"></i>
                                <span>Remove</span>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="m-form__group form-group row">
                      <label class="col-lg-2 col-form-label"></label>
                      <div class="col-lg-4">
                        <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                          <span>
                            <i class="la la-plus"></i>
                            <span>Add</span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>



            <!--end::Form-->





          <!-- modal content -->

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="btnSaveBillOfMaterial" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- modal -->
