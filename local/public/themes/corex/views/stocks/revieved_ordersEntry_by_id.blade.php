

<!-- main  -->
<div class="m-content">
        <!-- datalist -->
        <div class="m-portlet m-portlet--mobile">
           <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                 <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                       Recieve Purchase Order Entry
                    </h3>
                 </div>
              </div>
              <div class="m-portlet__head-tools">
                 <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                       <a href="{{route('recievedOrders')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
              <div class="m-portlet">
                 
                 <div class="m-portlet__body">
                    <!-- form  -->
                    <!--begin::Form-->
                    @php
                       // print_r($data);
                    @endphp
                    
                   
                   

                       <div class="m-portlet__body">
                          <div class="m-form__section m-form__section--first">
                             <div class="form-group m-form__group row">
                                <div class="col-lg-4 m-form__group-sub">
                                   <label class="form-control-label">* PID:</label>
                                <input type="text" class="form-control m-input" value="{{$data->p_order_id}}" name="pid" id="pid_event" placeholder="Enter Purchase Order ID">
                                </div>
                                <div class="col-lg-8 m-form__group-sub">
                                   <label class="form-control-label">Select Vendor:</label>
                                   <select class="form-control vendorLists"  name="vendor_id" id="vendor_id">
                                      <option value="0">-SELECT-</option>
                                      <?php 
                                      foreach (AyraHelp::getVendorsByadded(Auth::user()->id) as $key => $user) {
                                          if($user->id==$data->ven_id){
                                              ?>
                                               <option selected value="{{$user->id}}">{{$user->vendor_name}} | {{$user->phone}}  | {{$user->email}}</option>
                                              <?php
                                          }else{
                                              ?>
                                               <option  value="{{$user->id}}">{{$user->vendor_name}} | {{$user->phone}}  | {{$user->email}}</option>
                                              <?php
                                          }
                                      }
                                      ?>
                                   
                                   </select>
                                </div>
                             </div>
                          </div>
                          <!-- name email phone -->
                          
                          
                          <div class="m-form__section m-form__section--first">
                             <div class="form-group m-form__group row">
                                <div class="col-lg-2 m-form__group-sub">
                                   <label class="form-control-label"> Item Code:</label>
                                <input type="text"  class="form-control m-input" id="item_code"  value="{{ $data->item_code}}" name="item_code" placeholder="Enter Item Code" >
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                   <label class="form-control-label">Item Name:</label>
                                   <input type="text"  class="form-control m-input" name="item_name" value="{{ $data->item_name}}"  id="item_name" placeholder="Enter Item Name" >
                                </div>
                                <div class="col-lg-2 m-form__group-sub">
                                   <label class="form-control-label">QTY:</label>
                                   <input type="text"  class="form-control m-input" name="qty" value="{{ $data->item_qty}}" id="qty" placeholder="Enter QTY" >
                                </div>
                                <div class="col-lg-2 m-form__group-sub">
                                        <label class="form-control-label">Rec. QTY:</label>
                                        <input type="text"  class="form-control m-input" name="rec_qty" id="rec_qty" placeholder="Enter QTY" >
                                     </div>
                                     <div class="col-lg-2 m-form__group-sub">
                                            <label class="form-control-label">Invoice NO.:</label>
                                            <input type="text"  class="form-control m-input" name="invoice_no" id="invoice_no" placeholder="Invoice No" >
                                     </div>
                             </div>
                          </div>
                          
                          <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group row">
                                   <div class="col-lg-12 m-form__group-sub">
                                      <label class="form-control-label"> Recieved Remarks:</label>
                                      <textarea name="rec_remarks" id="rec_remarks" class="form-control" data-provide="markdown" rows="4"></textarea>
                                      
                                   </div>                                  
                                  
                                </div>
                             </div>
                         
                       </div>
                       <div class="m-portlet__foot m-portlet__foot--fit">
                          <div class="m-form__actions m-form__actions">
                             <div class="row">
                                <div class="col-lg-12">
                                   <button type="button" id="btnSavePurchaseOrder" class="btn btn-primary">Save</button>
                                  

                                   <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                             </div>
                          </div>
                       </div>
                  
                    <!--end::Form-->
                    <!-- form  -->
                 </div>
              </div>
              <!--end::Portlet-->
              <!-- general -->
           </div>
           <!-- end tab -->
        </div>
     </div>
     </div>
     <!-- main  -->
     
     