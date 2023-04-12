<!-- main  -->
<?php 
 $data_arr = AyraHelp::getMyOrder();
 $user = auth()->user();
 $userRoles = $user->getRoleNames();
 $user_role = $userRoles[0];

?>
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x m-tabs-line--right" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link " data-toggle="tab" href="#m_portlet_base_demo_1_2A_tab_content" role="tab">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>Tickets List
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_1_3A_tab_content" role="tab">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i> Create New
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="tab-content">
                    <div class="tab-pane " id="m_portlet_base_demo_1_2A_tab_content" role="tabpanel">


                        <!-- ticket list -->
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_TicketV2List">
                            <thead>
                                <tr>
                                    <th>TID#</th>
                                    <th>Status</th>
                                    <th>Ticket For</th>
                                    <th>Raised by </th>
                                    <th>Assign to</th>
                                    <th>Priority</th>
                                    <th>Created At</th>
                                    <th>Attachement</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>



                        <!-- ticket list -->




                    </div>
                    <div class="tab-pane active" id="m_portlet_base_demo_1_3A_tab_content" role="tabpanel">
                        <!-- History PAYMENT -->
                        <!--begin::Form-->
                        <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_ticketFromOrder" enctype="multipart/form-data"  style="background-color:#FFF;">
                            <div class="m-portlet__body">
                                @csrf
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                       
                                        <div class="col-lg-3">
                                            <label class="form-control-label">Order No:</label>
                                            <select class="form-control m-input  m-select2 myOrderListSelectTicket" name="formID" id="m_select2_1_invoiceOrder">
                                        <option value="">--Select Order--</option>
                                        <?php

                                        if ($user_role == "Admin" || $user_role == "SalesHead") {
                                            $orderArr = DB::table('qc_forms')
                                                ->select('form_id', 'order_id', 'subOrder')
                                                ->where('account_approval', '=', 1)
                                                ->get();
                                        } else {

                                            $orderArr = DB::table('qc_forms')
                                                ->select('form_id', 'order_id', 'subOrder')
                                                ->where('created_by', Auth::user()->id)
                                                ->where('account_approval', '=', 1)
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
                                        <div class="col-lg-3 ajdetailView">
                                            <input type="hidden" id="txtFromIDTicket">
                                        <a href="javascript::void(0)" id="txtViewOrderDetailTicket"  style="margin-top: 28px;" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
															<span>
																<i class="la la-eye"></i>
																<span class="vOrder">View Details</span>
															</span>
														</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label">*Client Email:</label>
                                            <input type="text" name="client_email" id="client_email" class="form-control m-input" placeholder="">
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-control-label">Complain On:</label>
                                            <div class="input-group">
                                                <input type="text" name="complain_date" class="form-control" id="m_datepicker_1" readonly placeholder="Select date" />
                                            </div>
                                        </div>
                                        



                                    </div>


                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="form-control-label">Assined to:</label>
                                            <select name="assignedUserID" class="form-control m-select2 assignedUserID" id="m_select2_9" style="width:100%" name="param">
                                                <option value="">-SELECT USER-</option>
                                                <?php

                                                $users = \DB::table('users')->where('is_deleted', 0)->whereNotNull('phone')->get();
                                                foreach ($users as $key => $userData) {
                                                ?>
                                                    <option value="{{$userData->id}}">{{$userData->name}}</option>

                                                <?php
                                                }

                                                ?>
                                            </select>

                                            </select>

                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label">Priority:</label>
                                            <select class="form-control m-input" id="ticketPriority" name="ticketPriority">
												<?php
												$support_type = \DB::table('ticket_priority_type')->where('is_deleted', 0)->get();
												foreach ($support_type as $key => $rowData) {
												?>
													<option value="{{$rowData->id}}">{{$rowData->priority_name}}</option>
												<?php
												}
												?>
											</select>

                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-control-label">Complain For:</label>
                                            <select class="form-control m-input ticket_cm_type" id="ticket_cm_type" name="ticket_cm_type">
												<?php
												$support_type = \DB::table('ticket_cm_type')->where('is_deleted', 0)->get();
												foreach ($support_type as $key => $rowData) {
												?>
													<option value="{{$rowData->id}}">{{$rowData->name}}</option>
												<?php
												}
												?>
											</select>

                                        </div>

                                    </div>


                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="form-control-label">Subject:</label>
                                            <input type="text" name="ticket_subject" id="ticket_subject" class="form-control m-input" placeholder="" value="">
                                        </div>
                                        <div class="col-lg-8">
                                            <label class="form-control-label">Item Name:</label>
                                            <input type="text" name="ticket_item_name" id="ticket_item_name" class="form-control m-input" placeholder="" value="">
                                        </div>
                                        

                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <label class="form-control-label">Complain Message:</label>
                                            <textarea name="txtTicketMessage" id="txtTicketMessage" class="form-control" data-provide="markdown" rows="5"></textarea>

                                            <span class="m-form__help">Please enter a message within word length range 10 and 200.</span>

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
												<label for="exampleInputEmail1">File Browser(Attachement)</label>
												<div></div>
												<div class="custom-file">
													<input type="file" id="fileAttach" name="fileAttach" class="custom-file-input" id="customFile">
													<label class="custom-file-label" for="customFile">Choose file</label>
												</div>
									</div>


                                </div>

                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!--end::Form-->
                        <!-- History PAYMENT -->
                    </div>

                </div>
            </div>
        </div>

        <!--end::Portlet-->




    </div>
</div>
<!-- main  -->

<div class="modal fade" id="m_modal_OrderDetailTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-content">
            <div class="modal-body">
                <div id="oderDetailVie">
                </div>
            </div>



        </div>
    </div>
</div>


