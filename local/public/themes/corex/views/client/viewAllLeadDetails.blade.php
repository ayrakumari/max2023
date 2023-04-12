<!-- main  -->
<div class="m-content">

    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Lead View Details
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('client.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item ">
                    <a class="nav-link " data-toggle="tab" href="#m_tabs_3_1">
                        <i class="la la-gear"></i>
                        Lead Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
                        <i class="flaticon-file-2"></i>
                        History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#m_tabs_3_4">
                        <i class="flaticon-box"></i>
                        Sample
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#m_tabs_3_5">
                        <i class="flaticon-box"></i>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#m_tabs_3_6">
                        <i class="flaticon-file-2"></i>

                        Invoice Invoice
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#m_tabs_3_7">
                        <i class="flaticon-file-2"></i>

                        Lead Payment
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane " id="m_tabs_3_1" role="tabpanel">


                    <table class="table m-table">
                        <thead>

                        </thead>
                        <tbody>
                        

                            <tr>
                                <th><strong>Company</strong></th>
                                <td colspan="3">{{$data->company}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>Brand</strong></th>
                                <td colspan="3">{{$data->brand}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>GSTIN</strong></th>
                                <td colspan="3">{{$data->gstno}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>Name</strong></th>
                                <td colspan="3">{{optional($data)->firstname}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                            $user = auth()->user();
                            $userRoles = $user->getRoleNames();
                            $user_role = $userRoles[0];
                            if ($user_role == 'Admin' ||  $user_role == 'SalesUser') {
                            ?>
                                <tr>
                                    <th><strong>Email</strong></th>
                                    <td colspan="3">{{$data->email}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><strong>Phone</strong></th>
                                    <td colspan="3">{{$data->phone}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php

                            }
                            ?>



                            <tr>
                                <th><strong>Address</strong></th>
                                <td colspan="3">{{$data->address}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>Location</strong></th>
                                <td colspan="3">{{$data->location}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>Website</strong></th>
                                <td colspan="3">{{$data->website}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th><strong>Source</strong></th>
                                <td colspan="3">{{AyraHelp::getClientSource($data->source)[0]->source_name}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                           
                            if($data->client_from==1){
                                ?>
                                 <tr>
                                <th><strong>FROM LEAD</strong></th>
                                <td colspan="3">QUERY_ID:{{$data->lead_QUERY_ID}}</td>
                                <td></td>
                                <td></td>
                            </tr>

                                <?php
                            }

                             ?>
                           

                            <tr>
                                <th><strong>Status</strong></th>
                                <td colspan="3">

                                    <?php

                                    switch ($data->lead_statge) {
                                        case '1':
                                            echo '<span class="m-badge m-badge--brand m-badge--wide m-badge--rounded">Assigned</span>';
                                            break;
                                        case '2':
                                            echo '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">Qualified</span>';
                                            break;
                                        case '3':
                                            echo '<span class="m-badge m-badge--primary m-badge--wide m-badge--rounded">Sampling</span>';
                                            break;
                                        case '4':
                                            echo '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Client</span>';
                                            break;
                                        case '5':
                                            '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Repeat Client</span>';
                                            break;
                                        case '6':
                                            '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Lost</span>';
                                            break;


                                        default:
                                            # code...
                                            break;
                                    }

                                    ?>

                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>

                    <!--end::Portlet-->


                </div>

                <div class="tab-pane" id="m_tabs_3_3" role="tabpanel">


                    <div class="m-radio-inline">
                        <label class="m-radio">
                            <input checked value="1" type="radio" name="leadHis">All
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input value="2" type="radio" name="leadHis">Notes
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input value="2" type="radio" name="leadHis">Orders
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input value="2" type="radio" name="leadHis">Samples
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input value="2" type="radio" name="leadHis">Payment
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input value="2" type="radio" name="leadHis">Invoice Request
                            <span></span>
                        </label>
                    </div>


                    <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Message</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $leadnotesArr = DB::table('client_notes')
                                ->where('clinet_id', $data->id)
                                ->orderBy('id', 'desc')
                                ->get();
                            $i = 0;



                            foreach ($leadnotesArr as $key => $rowData) {
                                $i++;

                            ?>
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td><b>{{@$rowData->note_type}}</b></td>
                                    <td>{{@$rowData->message}}
                                        <span class="m-badge m-badge--warning m-badge--dot"></span> Created on <b> {{date('j-M-y',strtotime($rowData->created_at))}}</b>
                                        <span class="m-badge m-badge--warning m-badge--dot"></span> Created By <b> {{AyraHelp::getUser($rowData->user_id)->name}}</b>


                                    </td>

                                </tr>
                            <?php

                            }

                            ?>


                        </tbody>
                    </table>

                </div>


                <div class="tab-pane" id="m_tabs_3_4" role="tabpanel">
                    <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Sample Code </th>
                                <th>Sample Item </th>
                                <th>Status </th>
                                <th>Orders </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $leadnotesArr = DB::table('samples')
                                ->where('client_id', $data->id)
                                ->orderBy('id', 'desc')
                                ->get();
                            $i = 0;


                            $i = 0;
                            foreach ($leadnotesArr as $key => $rowData) {

                                $i++;
                                $orderCount = DB::table('qc_forms')
                                    ->where('item_fm_sample_no', $rowData->sample_code)
                                    ->count();




                                if ($rowData->status == 2) {
                                    $strStatus = "Dispatched on " . $rowData->sent_on;
                                } else {
                                    $strStatus = "Not Dispatched" . $rowData->sent_on;
                                }

                                $urlLink = \URL::to('/') . "/sample/" . $rowData->id
                            ?>
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <th scope="row"><a href="{{$urlLink}}">{{$rowData->sample_code}}</a></th>
                                    <th scope="row">
                                        <div class="m-scrollable" data-scrollable="true" style="height: 80px">
                                            <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Item Name</th>
                                                        <th>Price/Kg</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $sample_details = json_decode($rowData->sample_details);


                                                    $sampleITEM = "";

                                                    $j = 0;
                                                    foreach ($sample_details as $key => $rowValA) {


                                                        $j++;
                                                        $strTy = "";
                                                        switch (@$rowValA->sample_type == 1) {
                                                            case 1:
                                                                $strTy = "Cosmatic";
                                                                break;
                                                            case 2:
                                                                $strTy = "Oil/Raw";
                                                                break;
                                                            case 3:
                                                                $strTy = "GENERAL CHANGES ";
                                                                break;
                                                            case 4:
                                                                $strTy = "BENCHMARK  ";
                                                                break;
                                                            case 5:
                                                                $strTy = "MODIFICATIONS  ";
                                                                break;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <th scope="row">{{$j}}</th>
                                                            <td>{{$strTy}}</td>
                                                            <td>{{@$rowValA->txtItem}}</td>
                                                            <td>{{@$rowValA->price_per_kg}}</td>

                                                        </tr>
                                                    <?php
                                                    }

                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </th>
                                    <th scope="row">{{$strStatus}}</th>
                                    <th scope="row">{{$orderCount}}</th>

                                    </td>

                                </tr>
                            <?php

                            }

                            ?>


                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="m_tabs_3_5" role="tabpanel">
                    <!-- order  -->
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Order ID</th>
                                <th>Order Type</th>
                                <th>Order Values</th>
                                <th>Order Details</th>
                                <th>Created on</th>
                                <th>Account Approved on</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $leadOrderArr = DB::table('qc_forms')
                                ->where('client_id', $data->id)
                                //  ->where('is_deleted', 0)
                                ->orderBy('form_id', 'desc')
                                ->get();
                            $i = 0;
                            foreach ($leadOrderArr as $key => $rowData) {
                                $i++;
                            ?>
                                <tr>
                                    <td>{{$i}}</td>

                                    <td>{{$rowData->order_id}}/{{$rowData->subOrder}}</td>
                                    <td>{{$rowData->order_type}}</td>
                                      <td>
                                      <?php
                                            if ($rowData->order_type == 'Bulk') {
                                                echo optional($rowData)->bulk_order_value;
                                            }else{
                                                echo  ceil($rowData->item_qty * $rowData->item_sp);
                                            }
                                            ?>
                                      </td>
                                    <td>
                                        <table>
                                            <?php
                                            if ($rowData->order_type == 'Bulk') {

                                                // $rowData->form_id;
                                                $leadOrderArrBulk = DB::table('qc_bulk_order_form')
                                                    ->where('form_id', $rowData->form_id)
                                                    ->orderBy('form_id', 'desc')
                                                    ->get();
                                                foreach ($leadOrderArrBulk as $key => $bulkRow) {
                                            ?>
                                                    <tr>
                                                        <td>{{$bulkRow->item_name}}
                                                        </td>
                                                        <td>QTY:{{$bulkRow->qty}}{{$bulkRow->item_size}}<br>
                                                            Rate:Rs.{{$bulkRow->rate}}<br>
                                                            Price:{{$bulkRow->item_sell_p}}<br>
                                                        </td>

                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td>
                                                    {{$rowData->item_name}}
                                                    </td>
                                                    <td>
                                                    QTY:{{$rowData->item_qty}}
                                                    Unit:{{$rowData->item_size}} {{$rowData->item_size_unit}}
                                                    </td>
                                                    <td>SP.{{$rowData->item_sp}}
                                                    </td>
                                                    <td>Remarks:
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </table>
                                    </td>
                                    <td>{{date('j F Y',strtotime($rowData->created_at))}}</td>
                                    <td>{{$rowData->account_approval==1 ? "Approved":"Pending"}}
                                    <br>
                                      {{$rowData->account_msg}}
                                      <br>
                                      {{$rowData->account_approved_on}}
                                    </td>
                                    <td> {{$rowData->curr_stage_name}}</td>

                                    <td nowrap></td>
                                </tr>
                            <?php
                            }

                            ?>


                        </tbody>
                    </table>
                    <!-- order  -->


                </div>
                <!-- tab start -->
                <div class="tab-pane active " id="m_tabs_3_6" role="tabpanel">
                    <!--begin::Section-->
                    <div class="m-section">
            <span class="m-section__sub">
              List of all Invoice Uploaded
            </span>
            <div class="m-section__content">
              <table class="table table-sm m-table m-table--head-bg-brand">
                <thead class="thead-inverse">
                  <tr>
                    <th>#</th>
                    <th>Created By</th>
                    <th>Uploaded On</th>
                    <th>Message</th>
                    <th>File</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $users = DB::table('order_invoice_doc')->where('client_id', Request::segment(2))->orderBy('id', 'desc')->get();
                  //print_r($users);
                  foreach ($users as $key => $rowData) {
                    $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->invoice_doc;

                  ?>
                    <tr>
                      <th scope="row"><?php echo $rowData->id; ?></th>
                      <td><?php echo $rowData->created_name; ?></td>
                      <td><?php echo $rowData->created_at; ?></td>
                      <td><?php echo $rowData->notes ?></td>
                      <td>
                        <a href="<?php echo $img_photo ?>" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                          <i class="fa fa-file-pdf"></i>


                        </a>



                      </td>
                    </tr>

                  <?php
                  }



                  ?>



                </tbody>
              </table>
            </div>
          </div>
                    <!--end::Section-->



                </div>

                <!-- m_tabs_3_7 -->
                <div class="tab-pane " id="m_tabs_3_7" role="tabpanel">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_CPInvoivxe">
            <thead>
              <tr>
                <th>ID</th>
                <th>Received On</th>
                <th>Requested On</th>
                <th>Details</th>
                <th>Bank Name</th>
                <th>Payment Status</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $uid = Request::segment(2);

              $paymetArrData = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('client_id', $uid)->get();
              foreach ($paymetArrData as $key => $rowData) {

                switch ($rowData->bank_name) {
                  case 1:
                    $strBank = "ICICI BANK";
                    break;
                  case "blue":
                    $strBank = "PNG BANK";
                    break;
                  case "green":
                    $strBank = "CASH ";
                    break;
                  default:
                    $strBank = "";
                }
                $paymentIMG = asset('local/public/uploads/photos') . "/" . $rowData->payment_img;



              ?>
                <tr>
                  <td>{{$rowData->id}}</td>
                  <td>{{date("j F Y",strtotime($rowData->recieved_on))}}</td>
                  <td>{{date("j F Y",strtotime($rowData->created_at))}}</td>
                  <td>
                    <?php
                    if (!empty($rowData->payment_img)) {
                    ?>
                      <a target="_blank" href="{{$paymentIMG}} ">Payment DOC</a>

                      <?php
                    } else {
                      ?>NA
                    <?php
                    }
                    ?>

                  </td>
                  <td>{{$strBank}}</td>
                  <td>{{$rowData->payment_status==0 ? "Waiting":"Approved" }}</td>
                  <td>{{$rowData->rec_amount}}</td>
                </tr>

              <?php
              }

              ?>


              </tr>
              </tfoot>
          </table>

                    <!-- Hi  -->
                </div>
                <!-- m_tabs_3_7 -->
                <!-- tab stop -->

            </div>
            <!-- end tab -->
        </div>
    </div>


    <!-- main  -->