<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
      
        <div class="m-portlet__body">

            <!--begin::Form-->
            <form method="post" action="{{route('saveSampleDispatchBulk')}}" class="m-form m-form--state m-form--fit m-form--label-align-right" id="frmSampleDispatch">
                @csrf
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">*Samples</label>
                                <select class="form-control m-select2 selectSampleData" id="m_select2_1" name="billing_card_exp_month">
                                    <option value="">Select</option> 
                                    <?php
                                    foreach ($data as $key => $rowData) {
                                    ?>
                                        <option value="{{$rowData->id}}">{{$rowData->sample_code}}</option>

                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-8 m-form__group-sub" >  
                                <textarea name="conten5t" id="summernoteA" class="form-control summernoteA"  rows="2"></textarea>
									
									
                            </div>

                        </div>
                    </div>

                    <div class="m-form__section  ">

                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
													<thead>
														<tr>
															<th>Sample ID</th>
															<th>ITEM NAME</th>
															<th>ITEM INFO</th>
															<th>FORMULATED</th>
															<th>CREATED ON</th>
															<th>DETAILS</th>
														</tr>
													</thead>
													<tbody class="sampleDetails">
														
														
													</tbody>
												</table>

                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row" style="display: none;">
                            <div class="col-lg-12">
                                
                                <button type="submit" data-wizard-action="submitSaveSampleDisptach" class="btn btn-primary submitSaveSampleTech">Submit</button>

                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>




        </div>
        <!-- main  -->