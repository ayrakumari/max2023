<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <!--begin::Portlet-->
        <?php
        $data_arr = AyraHelp::getMyOrder();
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];



        ?>

        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x m-tabs-line--right" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_3_tab_content" role="tab">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>New
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_2_tab_content" role="tab">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>History
                            </a>
                        </li>
                        <div class="m-portlet__head-tools" style="display: none;">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <div class="m-form__group form-group row">
                                        <div class="col-12" style="margin-top:5px">
                                            <div class="m-checkbox-inline">
                                                <label class="m-checkbox">
                                                    <input type="radio" checked name="txtPartialOrder" value="1"> NEW Order
                                                    <span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="radio" name="txtPartialOrder" value="2"> Partial Order
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>


                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <?php
                // echo "<pre>";
                //   print_r($qc_form_id);
                //   die;
                $form_data = AyraHelp::getQCFormDate($qc_form_id);

                $leadDataArr = AyraHelp::getLeadDataByID($form_data->client_id);
                // print_r($leadDataArr);
                // die;



                ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_portlet_base_demo_2_3_tab_content" role="tabpanel">
                        <!-- tab 1 -->
                        <form class="" id="m_form_3_salesInvoiceRequest">

                            @csrf



                            <div class="form-group m-form__group row">
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">* Client:</label>
                                    <select class="form-control client_name_qcformSIR" name="client_id">
                                        <option selected value="{{$leadDataArr->id}}">{{$leadDataArr->firstname}} | {{$leadDataArr->phone}} | {{$leadDataArr->email}}</option>



                                    </select>
                                </div>
                                <div class="col-lg-3 m-form__group form-group">

                                    <label for="">GST Registered ?</label>
                                    <div class="m-checkbox-inline">
                                        <label class="m-checkbox">
                                            <input type="checkbox"> YES
                                            <span></span>
                                        </label>
                                        <label class="m-checkbox">NO
                                            <span></span>
                                        </label>

                                    </div>



                                </div>

                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">* GSTIN</label>
                                    <input type="text" name="txtMyGSTNO" id="txtMyGSTNO" class="form-control" placeholder="GSTIN" />

                                </div>

                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">* Order ID:</label>
                                    <select class="form-control m-input  m-select2 myOrderListSelectA" name="formNO" id="m_select2_1_invoiceOrder">
                                        <option value="">--Select Order--</option>
                                        <?php

                                        if ($user_role == "Admin" || $user_role == "SalesHead") {
                                            $orderArr = DB::table('qc_forms')
                                                ->select('form_id', 'order_id', 'subOrder')
                                                ->where('dispatch_status', '!=', 0)
                                                ->get();
                                        } else {

                                            $orderArr = DB::table('qc_forms')
                                                ->select('form_id', 'order_id', 'subOrder')
                                                ->where('created_by', Auth::user()->id)
                                                ->where('dispatch_status', '!=', 0)
                                                ->get();
                                        }

                                        foreach ($orderArr as $key => $rowData) {
                                        ?>
                                            <option value="{{$rowData->form_id}}">{{$rowData->order_id}}/{{$rowData->subOrder}}</option>
                                        <?php
                                        }

                                        ?>
                                    </select>

                                </div>

                            </div>
                            <!-- row -->


                            <div id="txtRepeatArea">

                            </div>


                            <!-- row -->
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">* Complete Buyer Address : </label>
                                    <input type="text" name="complete_buyer_address" id="complete_buyer_address" class="form-control m-input" placeholder="">
                                </div>
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">* Delivery Address(if any) </label>
                                    <input type="text" name="delivery_address" id="delivery_address" class="form-control m-input" placeholder="">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 m-form__group-sub">
                                    <div class="m-form__group form-group">
                                        <label for="">Material Dispatch Through</label>
                                        <div class="m-checkbox-inline">
                                            <label class="m-checkbox">
                                                <input type="radio" value="1" name="dispatch_through"> Transport
                                                <span></span>
                                            </label>
                                            <label class="m-checkbox">
                                                <input type="radio" value="2" name="dispatch_through">Own Vehicle
                                                <span></span>
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="form-control-label">* Destination </label>
                                    <input type="text" name="order_destination" class="form-control m-input" placeholder="" value="">
                                </div>
                            </div>
                            <!-- row -->


                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="col-form-label col-lg-12 col-sm-12">Vehicle/Logistic Details *</label>
                                    <textarea class="form-control m-input" name="vLogistic" placeholder="Enter Vehicle/Logistic Details "></textarea>

                                </div>
                                <div class="col-lg-6 m-form__group-sub">
                                    <label class="col-form-label col-lg-12 col-sm-12">Terms of Delivery</label>
                                    <textarea class="form-control m-input" name="termsDelivery" placeholder="Enter Terms of Delivery"></textarea>

                                </div>
                            </div>
                            <!-- row -->

                            <div class="form-group m-form__group row">
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">* Total Cartons </label>
                                    <input type="text" name="Vno_of_cartons" class="form-control m-input" placeholder="" value="">
                                </div>
                                <div class="col-lg-3 m-form__group-sub">
                                    <label class="form-control-label">* Total UNIT </label>
                                    <input type="text" readonly name="Vno_of_unit" id="Vno_of_unitAJ" class="form-control m-input" placeholder="" value="">
                                </div>

                                <div class="col-lg-6 m-form__group-sub">

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <label class="m-option">
                                                <span class="m-option__control">
                                                    <span class="m-radio m-radio--state-brand">
                                                        <input type="radio" name="paid_by" value="1">
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="m-option__label">
                                                    <span class="m-option__head">
                                                        <span class="m-option__focus">
                                                            Paid By US
                                                        </span>

                                                    </span>

                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-lg-7">
                                            <label class="m-option">
                                                <span class="m-option__control">
                                                    <span class="m-radio m-radio--state-brand">
                                                        <input type="radio" name="paid_by" value="2">
                                                        <span></span>
                                                    </span>
                                                </span>
                                                <span class="m-option__label">
                                                    <span class="m-option__head">
                                                        <span class="m-option__focus">
                                                            Paid By Customer
                                                        </span>

                                                    </span>

                                                </span>
                                            </label>
                                        </div>


                                    </div>

                                </div>

                            </div>

                            <!-- aad  -->
                            <div class="form-group m-form__group row">
                                <div class="col-lg-8 m-form__group-sub">
                                    <label class="form-control-label">* Remarks </label>
                                    <input type="text" name="txtRemarksNote" class="form-control m-input" placeholder="" value="">
                                </div>
                                <div class="col-lg-4 m-form__group-sub">
                                    <label class="form-control-label">* Shipping Charge </label>
                                    <input type="text" name="txtShippingCharge" class="form-control m-input" placeholder="" value="">
                                </div>

                            </div>
                            <!-- aad  -->


                            <!-- row -->

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" id="IVReqSubmit" class="btn btn-info">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </form>
                        <!-- tab 1 -->
                    </div>
                    <div class="tab-pane" id="m_portlet_base_demo_2_2_tab_content" role="tabpanel">
                        <!-- History  -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_salesInvoiceRequestHIST">
                            <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Sales Person</th>
                                    <th>Order ID</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- History  -->
                    </div>

                </div>
            </div>
        </div>

        <!--end::Portlet-->




    </div>
</div>
<!-- main  -->



<!--begin::Modal-->
<div class="modal fade" id="m_modal_SalesInvoiceViewDetailsFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sales Invoice Feecback </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" name="ReqID" id="ReqID">

                </div>
                <input type="hidden" id="ReqID">
                <div class="form-group m-form__group">
                    <label for="exampleSelect1">Feedback Status</label>
                    <select class="form-control m-input" id="sirRespStatus">
                        <?php
                        if (Auth::user()->id == 132) {
                        ?>
                            <option value="3">DONE</option>

                        <?php
                        } else {
                        ?>
                            <option value="1">Completed</option>
                            <option value="2">Change</option>
                        <?php
                        }
                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="message-text" class="form-control-label">Message:</label>
                    <textarea class="form-control" id="sirMessage"></textarea>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="btnSubmitInvSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_SalesInvoiceViewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details:Sale Invoice Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewDataSaleInvReq">

                </div>
            </div>

        </div>
    </div>
</div>
<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_saleInvoiceResponceAddS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sales Invoice Reponse </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Order ID :<b><span id="sirOID"></b></span></label>

                    </div>
                    <input type="hidden" id="ReqID">
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="sirMessageA"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSIRSubmit">Send message</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->