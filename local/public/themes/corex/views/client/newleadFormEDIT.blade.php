<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New Lead Edit
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" onclick="goBack()" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
            <?php
            // echo "<pre>";
            // print_r($data);
            ?>
            <!--begin::Portlet-->
            <!-- form  -->
            <!--begin::Form-->
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_client_sales" method="post" action="{{ route('editNewLeadSales')}}">
                @csrf
                <input type="hidden" name="txtLeadID" value="{{$data->id}}">
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">* Company:</label>
                                <input type="text" class="form-control m-input" name="company" value="{{$data->company}}" placeholder="Enter Company">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Primary Brand:</label>
                                <input type="text" class="form-control m-input" name="brand" value="{{$data->brand}}" placeholder="Enter Brand">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">GSTIN:</label>
                                <input type="text" class="form-control m-input" name="gst" value="{{$data->gstno}}" placeholder="Enter GSTIN">
                            </div>
                        </div>
                    </div>
                    <!-- name email phone -->
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">*Name:</label>
                                <input type="text" class="form-control m-input" name="name" value="{{$data->firstname}}" placeholder="Enter Name">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">*Phone:</label>
                                <input type="text" id="m_inputmask_6" class="form-control m-input" value="{{$data->phone}}" name="phone" placeholder="Enter proper phone">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Email:</label>
                                <input type="text" class="form-control m-input" name="email" value="{{$data->email}}" placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <!-- name email phone -->
                    <!-- <address location source>

                                         </address> email phone -->
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"> Address:</label>
                                <input type="text" class="form-control m-input" name="address" value="{{$data->address}}" placeholder="Enter Address">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Location:</label>
                                <input type="text" class="form-control m-input" name="location" value="{{$data->location}}" placeholder="Enter Location">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Source:</label>
                                <select class="form-control m-input" id="exampleSelect1" name="source">
                                    @foreach (AyraHelp::getClientSource() as $source)
                                    <option value="{{$source->id}}">{{$source->source_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <!-- <address location source-->
                    <!-- website and remarks -->
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label"> Website:</label>
                                <input type="text" class="form-control m-input" name="website" value="{{$data->website}}" placeholder="Enter Website">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Remarks:</label>
                                <input type="text" class="form-control m-input" name="remarks" value="{{$data->remarks}}" placeholder="Enter Remarks">
                            </div>
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">Sales Person:</label>
                                <select name="client_crated_by" id="order_crated_by" class="form-control">
                                    <?php
                                    $user = auth()->user();
                                    $userRoles = $user->getRoleNames();
                                    $user_role = $userRoles[0];
                                    ?>
                                    <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                    @if ($user_role =="Admin" || $user_role =="Staff")
                                    @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>

                                    @endforeach
                                    @else

                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- website and remarks -->



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
        <hr>       
        <div class="m-portlet__body">
        <h1><strong>Add New Brand</strong></h1>
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_client_sales_brand" method="post" action="{{ route('addNewBrandtoClient')}}">
                @csrf
                <input type="hidden" name="txtLeadID" value="{{$data->id}}">
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 m-form__group-sub">
                                <label class="form-control-label">* Brand:</label>
                                <input type="text" class="form-control m-input" name="next_brand" value="" placeholder="Enter Brand">
                            </div>

                        </div>
                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" data-wizard-action="submitBrand" class="btn btn-success">Save Brand</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--end::Portlet-->

    </div>
</div>


</div>
<!-- main  -->