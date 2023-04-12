<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
    @endif

    <div class="m-portlet m-portlet--mobile">
        <!--begin::Portlet-->
        <form action="{{route('setClientTransferSave')}}" method="post">
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">                
                <div class="m-portlet__head-wrapper">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Bulk Lead Transfer
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                        <div class="col-lg-8 col-md-9 col-sm-12">
                            <select class="form-control m-select2" id="m_select2_1_salesPar" name="transferFromUserID">
                                <option value="">--Select Sales Person--</option>
                                <?php
                                $allUsers = AyraHelp::getSalesAgentAdminNotDeleted();
                                foreach ($allUsers as $key => $rowData) {
                                ?>
                                    <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>



                        <a href="javascript::void(0)" id="btnAppendSalesClient" class="btn btn-primary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                            <span>
                                <i class="la la-users"></i>
                                <span>Show</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
         
            @csrf
                <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                    <thead>
                        <tr>
                            <th>#LID</th>
                            <th>Lead Details </th>
                            <th>Order Details </th>
                            <th>Samples Details </th>
                            <th>Notes </th>
                        </tr>
                    </thead>
                    <tbody class="showClietAppend">
                        
                      

                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-sm-12">Transfer To:</label>
                            <div class="col-lg-12 col-md-9 col-sm-12">
                                <select class="form-control m-select2" id="m_select2_1" name="transferToUserID">
                                    <option value="">--Select Sales Person--</option>
                                    <?php
                                    $allUsers = AyraHelp::getSalesAgentAdmin();
                                    foreach ($allUsers as $key => $rowData) {
                                    ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group">
                            <label for="exampleTextarea">Remarks</label>
                            <textarea class="form-control m-input" id="exampleTextarea" name="uni_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                <i class="la la-mail-forward"></i>
                        <span>Transfer Now</span>
                    </span>
                </button>

            </form>





            </div>
        </div>

        <!--end::Portlet-->




    </div>
</div>
<!-- main  -->