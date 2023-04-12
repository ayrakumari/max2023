<!-- main  -->
<div class="m-content">
    <!-- datalist -->

    <div class="m-portlet m-portlet--mobile" style="display:block">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Formulation List::
                    </h3>
                    <!-- <table style="margin-left:30px;">
					</table> -->
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <?php
                        if (Auth::user()->id == 1 || Auth::user()->id == 206) {
                        ?>
                            <a style="display: none;" target="_blank" href="{{route('rnd.formulation')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Add New Formulation</span>
                                </span>
                            </a>
                            <a href="javascript::void(0)" onclick="showBaseModal()" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Add New </span>
                                </span>
                            </a>

                        <?php
                        }
                        ?>

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Search Form -->

            <form class="m-form m-form--fit m--margin-bottom-20" style="display:block ;">
                <div class="row m--margin-bottom-20">
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Formula Name:</label>
                        <input type="text" class="form-control m-input" placeholder="" data-col-index="1">
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Status:</label>
                        <select id="catIDPrice" class="form-control m-input" data-col-index="5">
                            <option value="">-SELECT-</option>
                           
                            <option value="0">DRAFT</option>
                            <option value="1">COMPLETED</option>
                            <!-- <option value="2">REJECTED</option> -->

                        </select>

                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>FM CODE:</label>
                        <input type="text" class="form-control m-input" placeholder="" data-col-index="2">
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Chemist Name::</label>
                        <select id="catIDPrice" class="form-control m-input" data-col-index="4">
                            <option value="">-SELECT-</option>                           
                           <?php 
                            $chemistArr = AyraHelp::getChemist();
                            foreach ($chemistArr as $key => $rowData) {
                            ?>
                                <option value="{{$rowData->name}}">{{$rowData->name}}</option>
                        <?php
                            }

                           ?>

                        </select>

                    </div>
                    



                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px;">
                            <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                            </span>
                        </button>

                    </div>


                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px;">
                            <span>
                                <i class="la la-close"></i>
                                <span>Reset</span>
                            </span>
                        </button>

                    </div>


                </div>

            </form>



            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_RNDFormulation" style="display: ;">
                <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Formula Name</th>
                        <th>FM CODE</th>                                             
                        <th>Created at</th>
                        <th>Chemist</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- datalist -->
</div>
<!-- main  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_4ING_DETAIL_AJ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingredent Details with Batch Size</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="txtRowID">
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">BatchSize:</label>
                    <input type="text" id="txtBatchViewData" class="form-control" id="txtRMName">
                </div>
                <button type="button" id="btnFormulaBatchPrint" class="btn btn-primary">Submit</button>


            </div>

        </div>
    </div>
</div>

<!--end::Modal-->

<!--begin::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="m_select2_modal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Sample Mapping with Formula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right">
                <div class="modal-body">

                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Sample List</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                        <select class="form-control m-select2" id="m_select2_2_modal" multiple="multiple"  name="param">
                                
                              
                        </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-secondary m-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_RNDUpdateFormula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Formulation Updation</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form>
                                        <input type="hidden" id="txtRowIDx">
                                        <div class="form-group m-form__group">
												<label for="exampleSelect1">Status</label>
												<select class="form-control m-input" id="selRNDStatus">
													<option value="0">Pending</option>
													<option value="1">Complete</option>													
												</select>
											</div>
											<div class="form-group">
												<label for="message-text" class="form-control-label">Notes:</label>
												<textarea class="form-control" id="messageRNDUpdate"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										
										<button type="button" id="btnRNDStatusUpdate" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
						</div>



                        <div class="modal fade" id="m_modal_5_RNDBaseAsk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Base Formulation </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="m-form__group form-group">
                        
                        <div class="m-radio-list">
                          
                           <label class="m-radio">
                                <input value="1" name="rdoRNDBaseTypeA" type="radio"> With Base Formulation
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input value="2" name="rdoRNDBaseTypeA" type="radio"> Fresh Formulation
                                <span></span>
                            </label>
                        </div>
                    </div>

                    
                </form>
            </div>
            <div class="modal-footer">

                <button type="button" id="btnRNDSelectType" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>