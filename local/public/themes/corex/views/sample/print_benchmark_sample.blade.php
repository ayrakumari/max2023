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


      <!-- kk -->

      <!-- kk -->
      <div class="m-portlet__head-tools">
        <ul class="m-portlet__nav">
          <li class="m-portlet__nav-item">
            <a href="javascript::void(0)" id="btnPrintSample" class="btn btn-info  m-btn--custom m-btn--icon">
              <span>
                <i class="la la-print"></i>
                <span>PRINT</span>
              </span>
            </a>
          </li>
          <li class="m-portlet__nav-item"></li>

        </ul>
      </div>
    </div>




    <div class="m-portlet__body">

      <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
          font-family: "Liberation Sans";
          font-size: x-small
        }

        a.comment-indicator:hover+comment {
          background: #ffd;
          position: absolute;
          display: block;
          border: 1px solid black;
          padding: 0.5em;
        }

        a.comment-indicator {
          background: red;
          display: inline-block;
          border: 1px solid black;
          width: 0.5em;
          height: 0.5em;
        }

        comment {
          display: none;
        }
      </style>
      <div id="div_printme">
        <!-- this is print area  -->
        <!-- niti gupta  -->



        <?php

        use App\Helpers\AyraHelp;

        $sampleArr = DB::table('samples')->where('status',1)->where('is_deleted',0)->where('sample_type', '=',4)->where('sample_stage_id', '=', 2)->get();
        // print_r($sampleArr);
        // die;

        if (count($sampleArr) > 0) {
        ?>
          <H4><strong>BENCHMARK COSMETIC : {{count($sampleArr)}}</strong></H4><br>
        <?php
        }
        foreach ($sampleArr as $key => $value) {
          // print_r($rowData);

          $client_data = AyraHelp::getClientbyid($value->client_id);
          if ($value->created_at != null) {
            $sample_created = date("j-M-Y", strtotime($value->created_at));
          } else {
            $sample_created = '';
          }
          $cname = isset($client_data->firstname) ? $client_data->firstname : "";
          $cbran = isset($client_data->company) ? $client_data->company : "";
            $AssingedTo = AyraHelp::getUser($value->assingned_to)->name;
            $AssingedOn = date('j-M-Y', strtotime($value->assingned_on));
        //   $AssingedTo ='';
          // $AssingedOn ='';


          $brandStr = "";
          switch (@$value->brand_type) {
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
                $brandStr = "In-House brand";
                break;
          }

          $orderStr = "";
          switch (@$value->order_size) {
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

          <div style="border:1px dotted #000">
            <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
              <tbody>
                <tr>
                  <th width="100px"><strong>Sample ID:</strong></th>
                  <td width="110px">{{$value->sample_code}}</td>
                  <th><strong>Name:</strong></th>
                  <td width="250px">{{$cname . "(" . $cbran . ")"}}</td>
                  <th></th>
                  <td></td>
                  <th><strong>Date:</strong></th>
                  <td>{{ $sample_created}}</td>
                  <th><strong>Assigned To:</strong></th>
                  <td width="110px"><b>{{ $AssingedTo}}</b></td>
                  <th><strong>Assigned On:</strong></th>
                  <td width="100px">{{ $AssingedOn}}</td>
                  <th><b>{{$brandStr}}</b>({{$orderStr}})</th>
                </tr>

                <tr>
                  <th><strong>Details:</strong></th>

                  <td colspan="12">
                    <!-- table -->
                    <table class="table table-sm m-table m-table--head-bg-brand">
                      <thead class="thead-inverse">
                        <tr>
                          <th>#</th>
                          <th>Category</th>
                          <th>Item Name</th>
                          <th>Descriptions</th>


                        </tr>
                      </thead>
                      <tbody>
                        <?php




                        $i = 0;
                        foreach (json_decode($value->sample_details) as $key => $items) {
                          $i++;


                          $sType = optional($items)->sample_type;
                          switch ($sType) {
                            case 1:
                              $sTypeName = "STANDARD COSMETIC";
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
                            <th>{{$i}}</th>
                            <td>{{$sTypeName}}</td>
                            <td>{{$items->txtItem}}</td>
                            <td>{{$items->txtDiscrption}}</td>

                          </tr>
                        <?php
                        }
                        ?>


                      </tbody>
                    </table>
                    <!-- table -->

                  </td>

                </tr>
                <tr>
                  <th><strong>Remarks:</strong></th>
                  <td colspan="6">
                  {{$value->remarks}}

                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <hr>


        <?php


        }

        ?>
        <!-- anita hari das  -->



       
        <!-- this is print area  -->
      </div>
    </div>
  </div>
</div>
<!-- main  -->