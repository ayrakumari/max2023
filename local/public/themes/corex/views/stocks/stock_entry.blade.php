<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Stock </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Stock Entry</span>
                    </a>
                </li>
                
            </ul>
        </div>
        
    </div>
</div>

<!-- END: Subheader -->

<div class="m-content">
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false">
                            <i class="la la-cog"></i> Stock Entry
                            
                        </a>
                    </li>
                   
                    
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">


                    <!--begin: Form Wizard Form-->
								<div class="m-wizard__form">

                                       
                                        <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
    
                                            <!--begin: Form Body -->
                                            <div class="m-portlet__body">
    
                                                <!--begin: Form Wizard Step 1-->
                                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                                    <div class="row">
                                                        <div class="col-xl-8 offset-xl-2">
                                                            <div class="m-form__section m-form__section--first">                                                               
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">* Category:</label>
                                                                    <div class="col-xl-7 col-lg-7">
                                                                            <select class="form-control m-select2 catName" id="m_select2_1" name="param">
                                                                                    <?php 
                                                                                    
                                                                                     $cat_arr=AyraHelp::getItemCategory();               
                                                                                     foreach ($cat_arr as $key => $value) {
                                                                                     ?>
                                                                                     <option value="{{$value->cat_id}}">{{$value->cat_name}}</option>
                                                     
                                                                                     <?php
                                                                                     }
                                                                                 ?>
                                                                                   
                                                                                 </select>
                                                                        <span class="m-form__help"></span>
                                                                    </div>
                                                                    <div class="col-xl-1 col-lg-1">
                                                                            <a href="javascript::void(0)" id="btnAddCategory"  class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill m-btn--air">
                                                                                    <i class="fa flaticon-plus"></i>
                                                                                </a>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-4 col-lg-4 col-form-label">* Item Name:</label>
                                                                    <div class="col-xl-8 col-lg-8">
                                                                        <input type="text"  id="itemName" class="form-control m-input" placeholder="Enter Item Name" >
                                                                        <span class="m-form__help"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label"> Short Name:</label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <input type="text" id="shortName" class="form-control m-input" placeholder="Enter Short Name">
                                                                            <span class="m-form__help"></span>
                                                                        </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label"> Unit:</label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                                <select class="form-control m-input"  id="unitName" >
                                                                                        <option value="PCS">PCS</option>
                                                                                      
                                                                                    </select>

                                                                           
                                                                            <span class="m-form__help"></span>
                                                                        </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label"> Opening Balance:</label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <input type="number" id="stock_qty" class="form-control m-input" placeholder="Enter Opening Balance" >
                                                                            <span class="m-form__help"></span>
                                                                        </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="m-portlet__foot m-portlet__foot--fit">
                                                                    <div class="m-form__actions">
                                                                        <button type="button" id="btnSaveStockEntry" class="btn btn-primary">Save </button>
                                                                       
                                                                    </div>
                                                                </div>
                                                           
                                                            
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <!--end: Form Wizard Step 1-->

                                                {{-- table --}}

                                                <!--begin::Portlet-->
										<div class="m-portlet m-portlet--bordered m-portlet--rounded  m-portlet--last">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                Stock Items List
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body">
                                                   <!--begin: Datatable -->
							    	<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_stock">
                                            <thead>
                                                <tr>
                                                    <th>Record ID</th>
                                                    <th>Item Code</th>
                                                    <th>Category</th>
                                                    <th>Item Name</th>
                                                    <th>Short Name</th>
                                                    <th>Unit</th>
                                                    <th>In Stock</th>
                                                    <th>In Stock</th>
                                                   
                                                </tr>
                                            </thead>
                                        </table>
                                        
                                                </div>
                                            </div>
    
                                            <!--end::Portlet-->

                                               
                                                {{-- table --}}


                                                
                    
                </div>
              
              
            </div>
        </div>
    </div>
        </div>
    </div>

</div>


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
                            <button type="button" id="btnCatSubmitStockEntry" class="btn btn-brand m-btn">Save</button>
                            <button type="button" class="btn btn-secondary m-btn" data-dismiss="modal">Close</button>
                            
                        </div>
                    </form>

                
            </div>
        </div>
    </div>
    
    <!--end::Modal-->
    
    