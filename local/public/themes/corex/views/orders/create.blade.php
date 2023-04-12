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
            <span class="m-nav__link-text">Order Create</span>
          </a>
        </li>    
       
      </ul>
    </div>
    <div>
      
    </div>
  </div>
</div>

<!-- END: Subheader -->

<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Add New Order
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
               Material Planning
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
                           <h3 class="m-portlet__head-text">
                              Order Information
                           </h3>
                        </div>
                     </div>
                     <div class="m-portlet__head-tools">
                     </div>
                  </div>
                  <div class="m-portlet__body">
                     <!-- form  -->
                     <!--begin::Form-->
                     <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_order" method="post" action="{{ route('orders.store')}}">
                        @csrf
                        <div class="m-portlet__body">
                           <div class="m-form__section m-form__section--first">
                              <div class="form-group m-form__group row">
                                 <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">Client:</label>
                                    <select class="form-control m-select2 client_name" id="m_select2_1" name="client_id">
                                       @foreach (AyraHelp::getClientByadded(Auth::user()->id) as $user)
                                       <option value="{{$user->id}}">{{$user->company}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                                 
                                 <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">DUE DATE:</label>
                                    <div class="input-group date">
                                      <input type="text" class="form-control m-input" readonly  name="order_due_date" id="m_datepicker_3" />
                                      <div class="input-group-append">
                                        <span class="input-group-text">
                                          <i class="la la-calendar"></i>
                                        </span>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-3 m-form__group-sub">
                                  <label class="form-control-label">Sales Person:</label>
                                  <select class="form-control m-input" id="catsalesUser" name="catsalesUser">
                                
                                    <?php 
                            $sales_arr= AyraHelp::getSalesAgent();
                            foreach ($sales_arr as $key => $user) {                         
                              if(Auth::user()->id==$user->id){
                                ?>
                                 <option selected  value="{{ $user->id}}">{{$user->name}}</option>
                                <?php
                              }else{
                                ?>
                              <option value="{{ $user->id}}">{{$user->name}}</option>
                                <?php
                              }
                              
                            }
                            ?>
                                  </select>

                               </div>
                              </div>
                           </div>
                           <div class="m-form__section m-form__section--first">
                              <!-- repeater -->
                              <div id="m_repeater_1">
                                 <div class="form-group" id="m_repeater_1">
                                   
                                    <div data-repeater-list="Orders" class="col-lg-12">
                                       <div data-repeater-item class="form-group m-form__group row ">
                                          <div class="col-lg-3">
                                              <label>Item Name:</label>
                                              <input type="text" name="txtOrderItem" class="form-control m-input" placeholder="Enter Item Name">
                                              <span class="m-form__help"></span>
                                            </div>
                                            <div class="col-lg-2">
                                              <label class="">QTY:</label>
                                              <input type="text" name="txtQTY" class="form-control m-input" placeholder="Enter Qty">
                                              <span class="m-form__help"></span>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class=""> Size(ml/gm):</label>
                                                <input type="text" name="txtSize" class="form-control m-input" placeholder="Size(ml/gm)">
                                                <span class="m-form__help"></span>
                                            </div>
                                              <div class="col-lg-3">
                                                  <label class="">Sample ID:</label>
                                                  <input type="text" name="txtSampleID" class="form-control m-input" placeholder="Sample ID if any">
                                                  <span class="m-form__help"></span>
                                                </div>
                                            <div class="col-lg-1">                                         
                                                <a href="javascript::void(0)" style="margin-top:30px" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                    <i class="flaticon-delete"></i>
                                                  </a>                                           
                                               
                                              </div>               
                                         
                                         
                                         
                                       </div>
                                    </div>
                                 </div>
                                 <div class="m-form__group form-group row">
                                   
                                    <div class="col-lg-4">
                                       <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                          <span>
                                          <i class="la la-plus"></i>
                                          <span>
                                          Add More
                                          </span>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- repeater -->
                           </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                           <div class="m-form__actions m-form__actions">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                     <!--end::Form-->
                     <!-- form  -->
                  </div>
               </div>
               <!--end::Portlet-->
               <!-- general -->
            </div>
            <div class="tab-pane" id="m_tabs_3_3" role="tabpanel">
                 <!-- meterial Planning panel -->


           <div class="m-portlet m-portlet--mobile">
             <div class="m-portlet__head">
               <div class="m-portlet__head-caption">
                 <div class="m-portlet__head-title">
                   <h3 class="m-portlet__head-text">
                     Advanced Search Form
                   </h3>
                 </div>
               </div>
              <!-- a -->
             </div>
             <div class="m-portlet__body">

               <!--begin: Search Form -->
               <form class="m-form m-form--fit m--margin-bottom-20" style="display:none">
                 <div class="row m--margin-bottom-20">
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>RecordID:</label>
                     <input type="text" class="form-control m-input" placeholder="E.g: 4590" data-col-index="0">
                   </div>
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>OrderID:</label>
                     <input type="text" class="form-control m-input" placeholder="E.g: 37000-300" data-col-index="1">
                   </div>
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>Country:</label>
                     <select class="form-control m-input" data-col-index="2">
                       <option value="">Select</option>
                     </select>
                   </div>
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>Agent:</label>
                     <input type="text" class="form-control m-input" placeholder="Agent ID or name" data-col-index="4">
                   </div>
                 </div>
                 <div class="row m--margin-bottom-20">
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>Ship Date:</label>
                     <div class="input-daterange input-group" id="m_datepicker">
                       <input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
                       <div class="input-group-append">
                         <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                       </div>
                       <input type="text" class="form-control m-input" name="end" placeholder="To" data-col-index="5" />
                     </div>
                   </div>
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>Status:</label>
                     <select class="form-control m-input" data-col-index="6">
                       <option value="">Select</option>
                     </select>
                   </div>
                   <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                     <label>Type:</label>
                     <select class="form-control m-input" data-col-index="7">
                       <option value="">Select</option>
                     </select>
                   </div>
                 </div>
                 <div class="m-separator m-separator--md m-separator--dashed"></div>
                 <div class="row">
                   <div class="col-lg-12">
                     <button class="btn btn-brand m-btn m-btn--icon" id="m_search">
                       <span>
                         <i class="la la-search"></i>
                         <span>Search</span>
                       </span>
                     </button>
                     &nbsp;&nbsp;
                     <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
                       <span>
                         <i class="la la-close"></i>
                         <span>Reset</span>
                       </span>
                     </button>
                   </div>
                 </div>
               </form>

               <!--begin: Datatable -->
               <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_13">
                 <thead>
                   <tr>
                     <th>ID</th>
                     <th>Order ID</th>
                     <th>Company</th>
                     <th>Created By</th>
                     <th>Created on</th>
                     <th>Due Date</th>
                     <th>Status</th>
                     <th>Actions</th>
                   </tr>
                 </thead>
                 <tfoot>
                   <tr>
                     <th>ID</th>
                     <th>Order ID</th>
                     <th>Company</th>
                     <th>Created By</th>
                     <th>Created on</th>
                     <th>Due Date</th>
                     <th>Status</th>
                     <th>Actions</th>
                   </tr>
                 </tfoot>
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
