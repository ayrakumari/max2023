<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New Quatation
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
            <!--begin::Portlet-->
            <!-- form  -->
            <!--begin::Form-->
            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_client" method="post" action="{{ route('saveNewLead')}}">
                @csrf

                <input type="hidden" id="QUERY_ID" name="QUERY_ID" value="{{$users->QUERY_ID}}">


                <!-- name email phone -->
                <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                    <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* QID:</label>
                            <input type="text" class="form-control m-input" id="txtQID" readonly placeholder="">
                        </div>

                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">* Name:</label>
                            <input type="text" class="form-control m-input" id="txtCID_Name" value="{{optional($users)->SENDERNAME}}" name="name" placeholder="Enter Name">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label">*Phone:</label>
                            <input type="text" class="form-control m-input" value="{{optional($users)->MOB}}" name="phone" placeholder="Enter Phone">
                        </div>
                        <div class="col-lg-3 m-form__group-sub">
                            <label class="form-control-label"> Email:</label>
                            <input type="text" class="form-control m-input" id="txtCID_Email" name="email" value="{{optional($users)->SENDEREMAIL}}" placeholder="Enter Email">
                        </div>
                    </div>
                </div>
                <!-- name email phone -->
                <!-- <address location source>

                                         </address> email phone -->
                <div class="m-form__section m-form__section--first">

                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Item Name:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_itemname" type="text" dir="ltr" placeholder="Item Name">
                            </div>


                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Size:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_size" type="text" dir="ltr" placeholder="">
                            </div>


                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Mat.CP/kg:</label>
                            
                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_kg" type="text" dir="ltr" placeholder="">
                            </div>


                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Mat.CP/Pc:</label>
                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_pc" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Bottle:</label>
                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_bottle" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label">Box:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_box" type="text" dir="ltr" placeholder="">
                            </div>


                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Label:</label>
                            
                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_babel" type="text" dir="ltr" placeholder="">
                            </div>


                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Labor:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_labour" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">Margin:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_margin" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">CP /pc:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_cp" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-2">
                            <label class="col-form-label">QTY /pc:</label>

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_qty" type="text" dir="ltr" placeholder="">
                            </div>

                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label">Packaging Type:</label>
                          

                            <div class="m-typeahead">
                                <input class="form-control m-input" id="m_typeahead_2_mcp_ptype" type="text" dir="ltr" placeholder="">
                            </div>


                        </div>
                        <div class="col-lg-3">
                            <button type="button" style="margin-top:38px" id="btnAddMoreData" class="btn btn-primary">Add </button>
                            <a href="{{route('view_preview_quatation',$users->QUERY_ID)}}" style="margin-top:38px"  class="btn btn-primary">Preview </a>

                        </div>
                    </div>

                </div>



            </form>

            <!--end::Form-->

            <!-- form  -->

        </div>

        <div class="m-portlet__body">
            <!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_viewCID_Quation">
									<thead>
										<tr>
											<th>S#</th>
											<th>Item Name</th>
											<th>Size</th>
											<th>Mat .C/KG</th>
											<th>Mat .C/Pc</th>
                                            <th>Bottle</th>
                                            <th>Box</th>
											<th>Label</th>
											<th>Labour</th>
											<th>Margin</th>
											<th>CP</th>
											<th>QTY</th>
											<th>PType</th>
											<th>Actions</th>
										</tr>
									</thead>
									
                                </table>
                                
        </div>


        <!--end::Portlet-->

    </div>
</div>


</div>
<!-- main  -->