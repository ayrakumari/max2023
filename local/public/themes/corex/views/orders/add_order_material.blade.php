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
                  <span class="m-nav__link-text">Bill of Material </span>
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
            <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
               <div class="m-portlet__head-title">
                  <h3 class="m-portlet__head-text">
                     Order Material 
                  </h3>
               </div>
            </div>
            <div class="m-portlet__head-tools">
               <ul class="m-portlet__nav">
                  <li class="m-portlet__nav-item">
                     <a href="javascript::void(0)"  onclick="goBack()" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                     <span>
                     <i class="la la-arrow-left"></i>
                     <span>BACK </span>
                     </span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
        </div>
            <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                                        <i class="la la-cog"></i> Add Order Material 
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item" style="display:none">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="false">
                                        <i class="la la-briefcase"></i> Purchase / Reserved 
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item" style="display:none">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="false">
                                        <i class="la la-bell-o"></i>Logs
                                    </a>
                                </li>
                                
                               
                                
              
                            
                            </ul>
                            
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
                            <!--begin::Form-->
                            @php
                             $arr_data=AyraHelp::getReqOrders(Request::segment(2));
                            @endphp
                           
                            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_item_submit">
                                @csrf
                                <input type="hidden" value="{{ Request::segment(2) }}" name="order_item_id" id="order_item_id">
                                                <div class="m-portlet__body">
                                                        <table class="table m-table m-table--head-bg-primary" style="border:1px dotted #f1f1" >
                                                                <thead>
                                                                  <tr>
                                                                        <th>Company Name:</th>
                                                                        <th>Item Name</th>
                                                                        <th>QTY</th>
                                                                        <th>Due Date</th>
                                                                        <th>Sample ID</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <tr>
                                                                  <th scope="row">{{$users_data->company}}</th>
                                                                        <td>{{$arr_data->item_name}}</td>
                                                                        <td>{{$arr_data->item_qty}}</td>
                                                                        <td>{{ date("j M Y",strtotime($orders_data->due_date))}}</td>
                                                                        <td>{{$arr_data->sample_id}}</td>
                                                                  </tr>                                                            
                                                                 
                                                                </tbody>
                                                          </table>
                                                          <div class="m-separator m-separator--md m-separator--dashed"></div>
                                                    <div class="m-form__section m-form__section--first">                                                                                           
                                                        
    
                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-4 m-form__group-sub">
                                                                <label class="form-control-label">* Category: </label>
                                                                {{-- <a href="" data-toggle="modal" data-target="#m_select2_modal_2 "><i class="fa flaticon-add"></i></a> --}}
                                                                <select class="form-control m-input m-select2 aj_item_catcory" id="m_select2_4" name="item_cat">
                                                                   
                                                                    @foreach (AyraHelp::getItemCategory() as $item_cat)
                                                                   
                                                                    <option value="{{$item_cat->cat_id}}">{{$item_cat->cat_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="m-form__help"></span>
                                                            </div>
                                                            <div class="col-lg-4 m-form__group-sub">
                                                                <label class="form-control-label">* Name:  </label>
                                                                {{-- <a href="#" data-toggle="modal" data-target="#m_select2_modal" ><i class="fa flaticon-add"></i></a> --}}
                                                                <select class="form-control m-input m-select2 aj_item_name" id="m_select2_5" name="item_id">
                                                                   
                                                                   
                                                                </select>
                                                                <span class="m-form__help"></span>
                                                               
                                                            </div>
                                                            <div class="col-lg-4 m-form__group-sub">
                                                                <label class="form-control-label">* Qty:</label>
                                                            <input type="number" value="{{$arr_data->item_qty}}" class="form-control m-input" name="item_qty" placeholder="" value="">
                                                            </div>
                                                        </div>
    
                                                        <div class="form-group m-form__group row">
                                                                <div class="col-lg-12 m-form__group-sub">
                                                                    <label class="form-control-label">Item Remarks:</label>
                                                                    <textarea class="form-control m-input" id="exampleTextarea" name="item_remarks" rows="2"></textarea>
                                                                </div>                                                          
                                                                
                                                            </div>
    
                                                    </div> 
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions m-form__actions">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php 
                                                               

                                                                $user = auth()->user();
                                                                $userRoles = $user->getRoleNames();
                                                                $user_role = $userRoles[0];
                                                                if($user_role=='SalesUser'){
                                                                    
                                                                    if($ordersItem_data[0]->sub_order_id==""){
                                                                     
                                                                        $b_desable=""; 
                                                                    }else{
                                                                        $b_desable="disabled";
                                                                    }
                                                                }else{
                                                                    $b_desable="";
                                                                }
                                                               


                                                                    ?>
                                                                <button type="submit" class="btn btn-primary" <?php echo $b_desable; ?>>Save</button>
                                                            <a href="{{route('orders.index')}}" class="btn btn-secondary">Cancel</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="m-separator m-separator--md m-separator--dashed"></div>
                                            <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                       <div class="m-portlet__head-title">
                                                          
                                                          <h3 class="m-portlet__head-text">
                                                             BIll of Material required for : <strong>
                                                                    {{ AyraHelp::getProductItemByid(Request::segment(2))->item_name}}
                                                               </strong>
                                                          </h3>
                                                       </div>
                                                    </div>
                                                    <div class="m-portlet__head-tools">
                                                    </div>
                                                 </div>                                        
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
                                    
                                        <hr>
                                        <?php 
                                             
                                              $stock_entry_status=AyraHelp::getBOMconfirmStatus(Request::segment(2));
                                           //   print_r($stock_entry_status);
                                              
                                              if($stock_entry_status===null){
    
                                              }else{
    
                                                if($stock_entry_status->confirm_status==1){
                                                    ?>
                                                    <a href="javascript::void(0)" id="btnConfirmBOM" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                                                            <span>
                                                                <i class="fa flaticon-time-3"></i>
                                                                <span>Confirm BOM</span>
                                                            </span>
                                                    </a>
                                                    <?php
                                                }
                                                
                                              }
                                            
                                             
                                                               
                                              
                                        ?>
    
                                      
                                            
                            </div>
                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                
                               
                                    <?php 
                                    if($stock_entry_status===null){
    
                                        }else{
    
                                        if($stock_entry_status->confirm_status==2){
                                            ?>
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
                                                 <!--end: Datatable -->
                                            <?php
                                        }
                                        
                                        }
    
                                        ?>
                                        
                                       
    
                             
                                
                                
    
                            </div>
                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                                specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
                            </div>
                        </div>
                    </div>
                </div>
    
       
    </div>
    <!-- main  -->
    
    {{-- modal for name entry --}}
    <!--begin::Modal-->
    <div class="modal fade" id="m_select2_modal" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Enter Item Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>
               
                
                <form class="m-form m-form--fit m-form--label-align-right">
                    <div class="modal-body">
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">Category</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <select class="form-control m-select2" id="m_select2_2_modal" name="param">
                                   <?php 
                                   
                                    $cat_arr=AyraHelp::getItemCategory();               
                                    foreach ($cat_arr as $key => $value) {
                                    ?>
                                    <option value="{{$value->cat_id}}">{{$value->cat_name}}</option>
    
                                    <?php
                                    }
                                ?>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">Enter Name</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input" id="txtAddCat" aria-describedby="emailHelp" placeholder="Enter name" id="txtAddCat">
                                <span class="m-form__help"></span>                        
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnAddItemSubmit" class="btn btn-brand m-btn">Save</button>
                            <button type="button" class="btn btn-secondary m-btn" data-dismiss="modal">Close</button>
                            
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <!--end::Modal-->
    
    
    {{-- modal for name entry --}}
    
    
    {{-- modal for categoryu entry --}}
    <!--begin::Modal-->
    <div class="modal fade" id="m_select2_modal_2" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Enter Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="modal-body">
                                <div class="form-group m-form__group row m--margin-top-20">
                                    <label class="col-form-label col-lg-3 col-sm-12">Enter Category</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <input type="text" class="form-control m-input" id="txtCat" aria-describedby="emailHelp" placeholder="Enter Category" id="txtCategory">
                                        <span class="m-form__help"></span>                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnCatSubmit" class="btn btn-brand m-btn">Save</button>
                                <button type="button" class="btn btn-secondary m-btn" data-dismiss="modal">Close</button>
                                
                            </div>
                        </form>
    
                    
                </div>
            </div>
        </div>
        
        <!--end::Modal-->
        
        
        {{-- modal for category entry --}}
    
    
    