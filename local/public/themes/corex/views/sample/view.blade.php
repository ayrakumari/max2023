<!-- main  -->
<div class="m-content">
  <?php
  if ($sample_data->sample_from == 1) {
    $company = $client_data->GLUSR_USR_COMPANYNAME;
    $brand = $client_data->GLUSR_USR_COMPANYNAME;
    $firstname = $client_data->SENDERNAME;
  } else {
    $company = $client_data->company;
    $brand = $client_data->brand;
    $firstname = $client_data->firstname;
  }
  ?>

  <?php


  $brandStr = "";
  switch ($sample_data->brand_type) {
    case 1:
      $brandStr = "New Brand";
      break;
    case 2:
      $brandStr = "Small Brand";
      break;
    case 3:
      $brandStr = "Medium Brand";
      break;
    case 4:
      $brandStr = "Big Brand";
      break;
    case 5:
      $brandStr = "In House Brand";
      break;
  }

  $orderStr = "";
  switch ($sample_data->order_size) {
    case 1:
      $orderStr = "500-1000 units";
      break;
    case 2:
      $orderStr = "1000-2000 units";
      break;
    case 3:
      $orderStr = "2000-5000 units";
      break;
    case 4:
      $orderStr = "More than 5000 units";
      break;
  }
  ?>

  <!-- datalist -->
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Sample Information
          </h3>
        </div>
      </div>
      <div class="m-portlet__head-tools">
        <ul class="m-portlet__nav">
          <li class="m-portlet__nav-item">
            <a href="{{route('sample.index')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
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
          <a class="nav-link active" data-toggle="tab" href="#m_tabs_3_1">
            <i class="la la-gear"></i>
            Sample</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " data-toggle="tab" href="#m_tabs_3_3">
            <i class="flaticon-file-2"></i>
            Feedback
          </a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="m_tabs_3_1" role="tabpanel">


          <!--begin::Portlet-->
          <div class="m-portlet">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                  <span class="m-portlet__head-icon">
                    <i class="la la-thumb-tack m--font-primary"></i>
                  </span>
                  <h3 class="m-portlet__head-text m--font-primary">
                    Sample Information :
                    <?php
                    if ($sample_data->admin_urgent_status == 1) {
                    ?>
                      <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">HIGH PRIORITY</span>
                      <h6>({{@$sample_data->admin_urgent_remarks}}</h6>)

                      <?php
                      if (Auth::user()->id == 1 || Auth::user()->id == 90 || Auth::user()->id == 171) {
                      ?>
                        :{{AyraHelp::getUser($sample_data->admin_urgent_by)->name}}
                    <?php
                      }
                    }
                    ?>
                  </h3>
                </div>
              </div>

            </div>
            <div class="m-portlet__body">
              <?php
              if ($sample_data->is_rejected == 1) {
              ?>
                NOTE:<b style="color:red">{{$sample_data->is_rejected_msg}}</b>
              <?php
              }
              ?>
              <table class="table m-table">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <th><strong>Sample ID</strong></th>
                    <td colspan="3">{{$sample_data->sample_code}}
                      <?php
                      if ($sample_data->is_paid == 1) {
                      ?>
                        <a title="View  Request" href="javascript::void(0)" onclick="viewPayReqData({{$sample_data->payment_id}})" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                          <span>
                            <i class="fa fa-rupee-sign"></i>
                            <span>PAID SAMPLE</span>
                          </span>
                        </a>
                      <?php
                      }
                      ?>

                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Company</strong></th>
                    <td colspan="3">{{$company}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Brand</strong></th>
                    <td colspan="3">{{$brand}}</td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <th><strong>Name</strong></th>
                    <td colspan="3">{{$firstname}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php

                  
                               $sType = optional($sample_data)->sample_type;

                              switch ($sType) {
                                case 1:
                                  $sTypeName = "COSMETIC";
                                  break;
                                case 2:
                                  $sTypeName = "OILS";
                                  break;
                                case 3:
                                  $sTypeName = "GENERAL CHANGES";
                                  break;
                                case 4:
                                  $sTypeName = "AS PER BENCHMARK";
                                  break;
                                case 5:
                                  $sTypeName = "MODIFICATIONS";
                                  break;

                                default:
                                  $sTypeName = "";
                                  break;
                              }




                             
                            
                            ?>
                          
                   <tr>
                    <th><strong>Sample Category</strong></th>
                    <td colspan="3"><b style="color:#035496">{{$sTypeName}}</b></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <th><strong>Brand Type</strong></th>
                    <td colspan="3"><b>{{$brandStr}}</b></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <th><strong>Order Size</strong></th>
                    <td colspan="3"><b>{{$orderStr}}</b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  if ($sample_data->is_modify_sample == 1) {
                    ?>
                     <tr>
                    <th><strong>Previous SID(<b style="color:#035496">MODIFY<b>)</strong></th>
                    <td colspan="3"><b>{{$sample_data->modify_sample_pre_code}}</b></td>
                    <td></td>
                    <td></td>
                  </tr>
                    <?php
                  }
                  ?>
                 

                  <?php
                  if ($sample_data->sample_v == 2) {
                  ?>
                    <tr>
                      <th><strong>Samples</strong></th>
                      <td colspan="3">
                        <table class="table table-sm m-table m-table--head-bg-metal">
                          <thead class="thead-inverse">
                            <tr>
                              <th style="color:#000">#</th>
                              <th style="color:#000">Item</th>
                              <th style="color:#000">Category</th>
                              <th style="color:#000">Sub Categoyr</th>
                              <th style="color:#000">Color</th>
                              <th style="color:#000">Fragrance</th>
                              <th style="color:#000">Pack Type:</th>
                              <th style="color:#000">T. Price/Kg:</th>
                              <th style="color:#000">Description</th>
                              <th style="color:#000">Stage Name</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            // echo "<pre>";
                            //  print_r($sample_data);
                            //  print_r($sample_data->sample_details);
                            $sampleItemArrData = DB::table('sample_items')
                              ->where('sid', $sample_data->id)
                              ->get();
                            $i = 0;
                            foreach ($sampleItemArrData as $key => $value) {
$i++;
                              
                            $stageN = "";
                            switch ($value->stage_id) {
                              case 1:
                                $stageN = "NEW";
                                break;
                              case 2:
                                $stageN = "APPROVED";
                                break;
                              case 3:
                                $stageN = "FORMULATION";
                                break;
                              case 4:
                                $stageN = "PACKING ";
                                break;
                              case 5:
                                $stageN = "DISPATCH ";
                                break;
                            }


                            ?>
                              <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$value->item_name}}</td>
                                <td>{{$value->sample_cat}}</td>
                                <td>{{$value->sample_sub_cat}}</td>
                                <td>{{optional($value)->sample_color}}</td>                                
                                <td>{{optional($value)->sample_fragrance}}</td>
                                <td>{{optional($value)->txtSample_packType_name}}</td>                                
                                <td>{{optional($value)->price_per_kg}}/KG</td>
                                <td>{{optional($value)->item_info}}</td>
                                <td>{{$stageN}}</td>
                              <?php
                            }


                            ?>
                            </tr>
                          </tbody>
                        </table>

                      </td>
                      <td></td>
                      <td></td>
                    </tr>

                  <?php
                  } else {
                  ?>
                    <tr>
                      <th><strong>Samples</strong></th>
                      <td colspan="3">
                        <table class="table table-sm m-table m-table--head-bg-metal">
                          <thead class="thead-inverse">
                            <tr>
                              <th style="color:#000">#</th>
                              <th style="color:#000">Category</th>
                              <th style="color:#000">Item</th>
                              <th style="color:#000">Description</th>
                              <th style="color:#000">Target price/Kg</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            //echo "<pre>";
                            //  print_r($sample_data);
                            //  print_r($sample_data->sample_details);
                            $sample_items = json_decode($sample_data->sample_details);
                            $i = 0;
                            foreach ($sample_items as $key => $value) {
                              //print_r($value->txtItem);
                              //print_r($value->txtDiscrption);
                              $sType = optional($value)->sample_type;
                              switch ($sType) {
                                case 1:
                                  $sTypeName = "COSMETIC";
                                  break;
                                case 2:
                                  $sTypeName = "OILS";
                                  break;
                                case 3:
                                  $sTypeName = "GENERAL CHANGES";
                                  break;
                                case 4:
                                  $sTypeName = "AS PER BENCHMARK";
                                  break;
                                case 5:
                                  $sTypeName = "MODIFICATIONS";
                                  break;

                                default:
                                  $sTypeName = "";
                                  break;
                              }




                              $i++;
                            ?>
                              <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$sTypeName}}</td>
                                <td>{{$value->txtItem}}</td>
                                <td>{{$value->txtDiscrption}}</td>
                                <td>{{optional($value)->price_per_kg}}</td>


                              </tr>
                            <?php
                            }


                            ?>
                          </tbody>
                        </table>

                      </td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php
                  }
                  ?>



                  <tr>
                    <th><strong>Shipping Address</strong></th>
                    <td colspan="3">{{$sample_data->ship_address}}</td>
                    <td></td>
                    <td></td> 
                  </tr>
                  <tr>
                    <th><strong>Created on</strong></th>
                    <td colspan="3">{{date('j F Y h:iA', strtotime($sample_data->created_at))}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Location</strong></th>
                    <td colspan="3">{{$sample_data->location}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Contact Person NO.</strong></th>
                    <td colspan="3">{{$sample_data->contact_phone}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Sample Remarks</strong></th>
                    <td colspan="3">{{$sample_data->remarks}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Status</strong></th>
                    <td colspan="3">

                      @switch($sample_data->status)
                      @case(1)
                      <span class="m-badge m-badge--brand m-badge--wide m-badge--rounded">NEW</span>
                      @break
                      @case(2)
                      <span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">SENT</span>
                      @break
                      @case(3)
                      <span class="m-badge m-badge--primary m-badge--wide m-badge--rounded">RECIEVED</span>
                      @break
                      @case(4)
                      <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">FEEDBACK</span>

                      @break



                      @endswitch
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th><strong>Courier</strong></th>
                    <td colspan="3">
                      <table class="table table-sm m-table m-table--head-bg-metal">
                        <thead class="thead-inverse">
                          <tr>

                            <th style="color:#000">Courier Name</th>
                            <th style="color:#000">Tracking ID</th>
                            <th style="color:#000">Sent on</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>

                            <td>
                              <?php
                              if ($sample_data->courier_id != NULL) {
                              ?>
                                {{AyraHelp::getCouriers($sample_data->courier_id)->courier_name}}
                              <?php
                              }
                              ?>


                            </td>
                            <td>

                              <?php
                              if ($sample_data->track_id != NULL) {
                              ?>
                                {{$sample_data->track_id}}
                              <?php
                              }
                              ?>
                            </td>
                            <td>
                              <?php
                              if ($sample_data->sent_on != NULL) {
                              ?>
                                {{date('j M Y', strtotime($sample_data->sent_on))}}
                              <?php
                              }
                              ?>

                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </td>
                    <td></td>
                    <td></td>
                  </tr>

                </tbody>
              </table>





            </div>
          </div>

          <!--end::Portlet-->


        </div>

        <div class="tab-pane" id="m_tabs_3_3" role="tabpanel">



          <div class="modal-body">
            <input type="hidden" name="s_id" id="v_s_id" value="{{$sample_data->id}}">


            <div class="form-group m-form__group">
              <label>Feedback Options</label>
              <div class="input-group">
                <select class="form-control m-input" name="feedback_option1" id="feedback_option1">
                  <option value="">--Select Options-- </option>
                  <option value="1">Changes suggest resend samples</option>
                  <option value="2">Did not like</option>
                  <option value="3">Stopped Responding</option>
                  <option value="4">Sample Selected</option>
                </select>


              </div>
            </div>
            <div class="form-group">
              <label for="message-text" class="form-control-label">*Remarks:</label>
              <textarea class="form-control" id="txtFeedbackRemarks" name="txtFeedbackRemarks"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="btnsaveFeedback" class="btn btn-primary">Save Feedback</button>
          </div>


          <!--begin::Portlet-->
          <div class="m-portlet" style="display:none">
            <div class="m-portlet__head">
              <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                  <span class="m-portlet__head-icon">
                    <i class="la la-thumb-tack m--font-success"></i>
                  </span>
                  <h3 class="m-portlet__head-text m--font-success">
                    Notes
                  </h3>
                </div>
              </div>
              <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                  <li class="m-portlet__nav-item">
                    <a href="javascript::void(0)" data-toggle="modal" data-target="#m_modal_6" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                      <span>
                        <i class="flaticon-file-2"></i>
                        <span>Add New</span>
                      </span>
                    </a>

                  </li>


                </ul>
              </div>
            </div>
            <div class="m-portlet__body">

              <!--begin: Datatable -->

              <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_clientNotesList">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Created By</th>
                    <th>Created On</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>




                </tbody>
              </table>


              <!-- END EXAMPLE TABLE PORTLET-->




            </div>
          </div>

          <!--end::Portlet-->

          <!-- m_modal_6 -->
          <!-- Modal -->
          <div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Client Notes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="user_id" id="user_id" value="{{$client_data->id}}">
                  <div class="form-group">
                    <label for="message-text" class="form-control-label">*Message:</label>
                    <textarea class="form-control" id="txtNotes" name="txtNotes"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="btnClientNotes" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </div>

          <!-- m_modal_6 -->

        </div>

      </div>
      <!-- end tab -->
    </div>
  </div>

</div>
<!-- main  -->



<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>

    <div class="modal-content">
      <div class="modal-body">
        <div id="payDetalRecSHOW">
        </div>
      </div>



    </div>
  </div>
</div>