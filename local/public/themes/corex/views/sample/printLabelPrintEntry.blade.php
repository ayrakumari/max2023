<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Print Preview

                    </h3>
                </div>
            </div>

        </div>

        

        <div class="m-portlet__body" style="margin:5px">
        
            <!--begin::Form-->
            <div class="form-group m-form__group row">
                <input type="text" id="txtdemoScan">
                        <label class="col-form-label col-lg-3 col-sm-12">Sample Code:</label>
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <select class="form-control m-select2 selectSamplePrintLBL" id="m_select2_1" name="param">
                                <?php

                                // echo "<pre>"; 
                                // print_r($data);
                                foreach ($data as $key => $rowData) {

                                ?>
                                    <option value="{{$rowData->id}}">{{$rowData->sample_code}}</option>

                                <?php

                                }
                                // die;
                                ?>



                            </select>
                        </div>
                    </div>
            <form class="m-form m-form--fit m-form--label-align-right" method="get" action="{{route('getSampleLabelPrint')}}">
                @csrf
                <div class="m-portlet__body addSamplePrintLayout">
                   
                    

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-brand">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>



        </div>
    </div>
</div>
<!-- main  -->