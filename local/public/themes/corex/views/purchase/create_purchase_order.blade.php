

<!-- main  -->
<div class="m-content">
   <!-- datalist -->
   <div class="m-portlet m-portlet--mobile">
      <div class="m-portlet__head">
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text">
                  Pending Purchase Item
               </h3>
            </div>
         </div>
         <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
               <li class="m-portlet__nav-item">
                  <a href="{{route('purchase.req.alert')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
            
             <!--begin::Form-->
             <form class="m-form m-form--state m-form--fit m-form--label-align-right"   id="m_form_add_purchase_order" method="post" action="{{ route('savePurchaseOrder')}}">
               @csrf
               <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label">* PID:</label>
                        <input type="text" class="form-control m-input" value="{{ AyraHelp::getPIDCode()}}" name="pid" placeholder="">
                        </div>
                        <div class="col-lg-8 m-form__group-sub">
                           <label class="form-control-label">Select Vendor:</label>
                           <select class="form-control m-select2 client_name" id="m_select2_1" name="vendor_id">
                              <option value="0">-SELECT-</option>
                              @foreach (AyraHelp::getVendorsByadded(Auth::user()->id) as $user)
                              <option value="{{$user->id}}">{{$user->vendor_name}} | {{$user->phone}}  | {{$user->email}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>
                  <!-- name email phone -->
                 
                  
                  <div class="m-form__section m-form__section--first">
                     <div class="form-group m-form__group row">
                        <div class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label"> Item Code:</label>
                        <input type="text" readonly value="{{$data->item_id}}" class="form-control m-input" id="item_code" name="item_code" placeholder="Enter Item Code" >
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label">Item Name:</label>
                           <input type="text" readonly value="{{$data->item_name}}" class="form-control m-input" name="item_name" id="item_name" placeholder="Enter Item Name" >
                        </div>
                        <div class="col-lg-4 m-form__group-sub">
                           <label class="form-control-label">QTY:</label>
                           <input type="text" readonly value="{{$data->qty}}" class="form-control m-input" name="qty" id="qty" placeholder="Enter QTY" >
                        </div>
                     </div>
                  </div>
                  <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                           <div class="col-lg-12 m-form__group-sub">
                              <label class="form-control-label"> Remarks:</label>
                              <textarea name="remarks" class="form-control" data-provide="markdown" rows="10"></textarea>
                              
                           </div>                                  
                          
                        </div>
                     </div>
                 
               </div>
               <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                     <div class="row">
                        <div class="col-lg-12">
                           <button type="submit" data-wizard-action="submit" class="btn btn-primary">Save</button>
                           <button type="submit" class="btn btn-warning">Save & Email</button>

                           <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <!--end::Form-->
         </div>
         <!--end::Portlet-->
         <!-- general -->
      </div>
      <!-- end tab -->
   </div>
</div>
</div>
<!-- main  -->

