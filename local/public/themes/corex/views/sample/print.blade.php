<!-- main  -->
<div class="m-content">
  <!-- datalist -->
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Print Preview
            <?php
            // echo "<pre>"; 
            // print_r($sample_data);
            // die;
            ?>
          </h3>
        </div>
      </div>
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
      <div id="div_printme">
        <table class="table table-bordered m-table m-table--border-primary" style="border:1px: solid #000 !important;">
          <thead class="thead-inverse">
            <tr> 
              <th>
                Total Pending :<b>Total({{AyraHelp::sampleTotalPendingCosmatic()}})</b> Pending to dispatch since
                <br>
                Total Formulation :<b>Total({{AyraHelp::sampleTotalPendingCosmaticFormulation()}})</b> Pending to dispatch since
              </th>
              <td>3 Days: <span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(3)}}</b></span>
              </td>
              <td>7 Days :<span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(7)}}</b></span>
              </td>
              <td>15 Days : <span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(15)}}</b></span>
               <br><b>Printed on:</b><?php echo date('j-M-y H:iA', strtotime(date('Y-m-d H:i:s')))?>
              </td>
            </tr>
          </thead>

        </table>
        <h1>
        <?php 
          echo "Total Sample By Filter:".$sample_data[0]['countSample'];  
        ?>
        </h1>

        <?php foreach ($sample_data as $key => $value) : ?>

          <?php


          $brandStr = "";
          switch (@$value['brand_type']) {
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
          switch (@$value['order_size']) {
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
          <?php
        //  echo "<pre>";
        //  print_r($value);
        $stmM="";
         if($value['is_paid_status']==0){
          $stmM="Not Paid Yet";
         }
         if($value['is_paid_status']==2){
          $stmM="Payment Approved";
         }

          //  echo "Total Sample:".$value['countSample'];
          //urgent 
          if (@$value['admin_status'] == 1) {
          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}}  <br><b>Urgent</b></td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:{{$brandStr}}

                    </th>
                    <td>Unit:{{$orderStr}}</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$items->txtItem}}
                              <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                              </td>
                              <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>


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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
          }
          //urgent 

          //In house brand 
          if (@$value['brand_type'] == 5) {
            if (@$value['admin_status'] !=1) {

         
            
            ?>
              <div style="border:1px dotted #000">
                <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                  <tbody>
                    <tr>
                      <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                      <td width="110px">{{$value['sample_code']}}</td>
                      <th><strong>Name:</strong></th>
                      <td width="150px">{{$value['client_name']}}</td>
                      <th>Type:{{$brandStr}}
  
                      </th>
                      <td>Unit:{{$orderStr}}</td>
                      <th><strong>Created Date:</strong></th>
                      <td>{{ $value['sample_created']}}</td>
                      <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>
  
                    </tr>
  
                    <tr>
                      <th><strong>Details:</strong></th>
  
                      <td colspan="7">
                        <!-- table -->
                        <table class="table table-sm m-table m-table--head-bg-brand">
                          <thead class="thead-inverse">
                            <tr>
                              <th>#</th>
                              <th>Category</th>
                              <th>Item Name</th>
                              <th>Descriptions</th>
                              <th>Target Price</th>
                              <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>

  
  
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            foreach ($value['sample_details'] as $key => $items) {
  
                              $i++;
                              // print_r($items);
  
                              $sType = optional($items)->sample_type;
                              $sType = $value['sample_type'];
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
                                <td>{{$items->txtItem}}
                                <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                                </td>
                                <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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
  
                        {{ $value['sample_remarks'] }}
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <hr>
            <?php
               }
            }
            ////in House brand  

          //big brand 
          if (@$value['brand_type'] == 4) {
            if (@$value['admin_status'] !=1) {

          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}}</td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:{{$brandStr}}

                    </th>
                    <td>Unit:{{$orderStr}}</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);
                            // die;

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$items->txtItem}}
                              <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                              </td>
                              <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
            }
          }
          ////big brand  


          //medium brand 
          if (@$value['brand_type'] == 3) {
            if (@$value['admin_status'] !=1) {

          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}}</td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:{{$brandStr}}

                    </th>
                    <td>Unit:{{$orderStr}}</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$items->txtItem}}
                              <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                              </td>
                              <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
            }
          }
          ////medium brand  

          //small brand 
          if (@$value['brand_type'] == 2) {
            if (@$value['admin_status'] !=1) {

          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}} </td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:{{$brandStr}}

                    </th>
                    <td>Unit:{{$orderStr}}</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$sTypeName}}
                              
                              </td>
                              <td>{{$items->txtItem}}
                                <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>

                              </td>
                              <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
            }
          }
          ////small brand  


          //new brand 
          if (@$value['brand_type'] == 1) {
            if (@$value['admin_status'] !=1) {
          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}} </td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:{{$brandStr}}

                    </th>
                    <td>Unit:{{$orderStr}}</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$items->txtItem}}
                              <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                              </td>
                              <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
            }
          }
          ////new brand  


          // echo "==========================================";


          ?>


        <?php endforeach; ?>

        <hr>
        <?php foreach ($sample_data as $key => $value) : ?>

          <?php


          $brandStr = "";
          switch (@$value['brand_type']) {
            case 1:
              $brandStr = "New Brand";
              break;
            case 2:
              $brandStr = "Small Brand";
              break;
            case 3:
              $brandStr = "Medium brand";
              break;
            case 4:
              $brandStr = "Big brand";
              break;
          }

          $orderStr = "";
          switch (@$value['order_size']) {
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
          <?php
          // print_r($value['admin_status']);




          //new brand 
          if (empty($value['brand_type'])) {
            if (@$value['admin_status'] !=1) {
          ?>
            <div style="border:1px dotted #000">
              <table class="table table-sm" style="font-size:14px;border:0px solid #ccc">
                <tbody>
                  <tr>
                    <th width="100px"><strong>Sample ID:({{$stmM}})</strong></th>
                    <td width="110px">{{$value['sample_code']}}</td>
                    <th><strong>Name:</strong></th>
                    <td width="150px">{{$value['client_name']}}</td>
                    <th>Type:NA

                    </th>
                    <td>Unit:NA</td>
                    <th><strong>Created Date:</strong></th>
                    <td>{{ $value['sample_created']}}</td>
                    <th><strong>Assinged To:</strong><b>{{ $value['assigneTO']}}</b></th>

                  </tr>

                  <tr>
                    <th><strong>Details:</strong></th>

                    <td colspan="7">
                      <!-- table -->
                      <table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Descriptions</th>
                            <th>Target Price</th>
                            <th>Color</th>
                            <th>Fragrance</th>
                            <th>Pack Type:</th>
                            <th>Sample Category</th>


                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 0;
                          foreach ($value['sample_details'] as $key => $items) {

                            $i++;
                            // print_r($items);

                            $sType = optional($items)->sample_type;
                            $sType = $value['sample_type'];
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
                              <td>{{$items->txtItem}}
                              <?php 
                                if(!empty($value['modify_sample_pre_code'])){
                                  echo "<br><b>MID:".$value['modify_sample_pre_code']."</b>";
                                }
                                ?>
                              </td>
                             <td>{{$items->txtDiscrption}}</td>
                              <td>{{optional($items)->price_per_kg}}</td>
                              <td>{{optional($items)->color}}</td>
                              <td>{{optional($items)->fragrance}}</td>
                              <td>{{optional($items)->packing_type_name}}</td>
                              <td>{{optional($items)->sample_cat}}</td>
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

                      {{ $value['sample_remarks'] }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <hr>
          <?php
            }
          }
          ////new brand  

          ?>


        <?php endforeach; ?>




      </div>



    </div>
  </div>
</div>
<!-- main  -->