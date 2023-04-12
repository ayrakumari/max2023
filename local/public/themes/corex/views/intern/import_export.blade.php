<div class="m-content">
    <div class="row">
        <div class="col-md-6">

            

            

           

            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Import & Export 
                            </h3>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right " action="{{ route('import_data') }}" method="POST" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                    @csrf
                        <div class="form-group1 m-form__group">
                            <label for="exampleInputEmail1">Import Type</label>
                            <div></div>
                            <select class="custom-select form-control">
                                <option selected value="Item">Item</option>
                                
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="exampleInputEmail1">File Browser</label>
                            <div></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>
    </div>
</div>
