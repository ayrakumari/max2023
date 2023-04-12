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
                        // print_r($sample_arr_Admin);
                        // die;
                        ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" id="btnPrintSampleX" class="btn btn-info  m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-print"></i>
                                <span>PRINT</span>
                            </span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item"></li>
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
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <div id="div_printmeX">

                <table cellspacing="0" border="0">
                    <colgroup width="121"></colgroup>
                    <colgroup width="25"></colgroup>
                    <colgroup width="147"></colgroup>
                    <colgroup width="94"></colgroup>
                    <colgroup width="116"></colgroup>
                    <colgroup width="83"></colgroup>
                    <colgroup width="101"></colgroup>
                    <colgroup width="85"></colgroup>
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=8 height="17" align="center" valign=middle><b>SAMPLE LIST-{{date('j-F-Y H:iA')}}</b></td>
                    </tr>
                    <!-- admin urgert  -->
                    <?php foreach ($sample_arr_Admin as $key => $value) : ?>
                        <?php


                        $samplesDataArr = DB::table('samples')
                            ->where('id', $value->id)
                            ->first();
                        $clientDataArr = DB::table('clients')
                            ->where('id', $samplesDataArr->client_id)
                            ->first();

                        $brandStr = "";
                        switch (@$samplesDataArr->brand_type) {
                            case 1:
                                $brandStr = "New";
                                break;
                            case 2:
                                $brandStr = "Small";
                                break;
                            case 3:
                                $brandStr = "Medium";
                                break;
                            case 4:
                                $brandStr = "Big";
                                break;
                            case 5:
                                $brandStr = "In-House";
                                break;
                        }
                        $orderStr = "";
                        switch (@$samplesDataArr->order_size) {
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

                        $sampleID = $value->id;

                        //brand 5 
                        $samplesDataItemArr = DB::table('sample_items')
                        ->where('sid', $sampleID)
                        ->where('sample_v', 2)
                        ->where('is_formulated', 0)
                        ->where('sample_cat_id', $sample_cat_id)
                        // ->where('brand_type', 5)
                        ->get();
                        $i = 0;
                        if (count($samplesDataItemArr) > 0) {
                            $i++;
                        ?>
                            <tr>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}(**)</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                    <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                </td>
                            </tr>
                        <?php

                            foreach ($samplesDataItemArr as $key => $rowData) {
                               
                                if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>

                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                    <span style="font-size: 12px;">Discriptions</span>
                                </b></td>
                            <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                        </tr>
                       



                        <tr>
                            <td height="5" colspan="6"></td>
                        </tr>
                        <!-- row  count  -->

                                <?php
                            }
                        }

                        ?>                                            
                              
                    <?php endforeach; ?>
                      <!-- admin urgert  stop -->

                         <!-- rest not admin uget start  -->
                    <?php foreach ($sample_data as $key => $value) : ?>
                        <?php


                        $samplesDataArr = DB::table('samples')
                            ->where('id', $value->id)
                            ->first();
                        $clientDataArr = DB::table('clients')
                            ->where('id', $samplesDataArr->client_id)
                            ->first();

                        $brandStr = "";
                        switch (@$samplesDataArr->brand_type) {
                            case 1:
                                $brandStr = "New";
                                break;
                            case 2:
                                $brandStr = "Small";
                                break;
                            case 3:
                                $brandStr = "Medium";
                                break;
                            case 4:
                                $brandStr = "Big";
                                break;
                            case 5:
                                $brandStr = "In-House";
                                break;
                        }
                        $orderStr = "";
                        switch (@$samplesDataArr->order_size) {
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

                        $sampleID = $value->id;

                        //brand 5 
                        $samplesDataItemArr = DB::table('sample_items')
                        ->where('sid', $sampleID)
                        ->where('sample_v', 2)
                        ->where('is_formulated', 0)
                        ->where('sample_cat_id', $sample_cat_id)
                        ->where('brand_type', 5)
                        ->where('admin_status','!=',1)
                        ->get();
                        $i = 0;
                        if (count($samplesDataItemArr) > 0) {
                            $i++;
                        ?>
                            <tr>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                    <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                </td>
                                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                    <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                </td>
                            </tr>
                        <?php

                            foreach ($samplesDataItemArr as $key => $rowData) {
                               

                               
                                 if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                    <span style="font-size: 12px;">Discriptions</span>
                                </b></td>
                                <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                        </tr>
                       



                        <tr>
                            <td height="6" colspan="6"></td>
                        </tr>
                        <!-- row  count  -->

                                <?php
                            }
                        }


                        //brand 5  stop 

                          //brand 4 start 
                          $samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 4)
							->where('admin_status','!=',1)
							->get();
                          $i = 0;
                          if (count($samplesDataItemArr) > 0) {
                              $i++;
                          ?>
                              <tr>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                  </td>
                              </tr>
                          <?php
  
                              foreach ($samplesDataItemArr as $key => $rowData) {
                                 
  
                                if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                              </td>
                          </tr>
                          <tr>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                      <span style="font-size: 12px;">Discriptions</span>
                                  </b></td>
                                  <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                          </tr>
                          
  
  
  
                          <tr>
                              <td height="6" colspan="6"></td>
                          </tr>
                          <!-- row  count  -->
  
                                  <?php
                              }
                          }
  
  
                          //brand 4  stop 


                          //brand 3 start 
                          $samplesDataItemArr = DB::table('sample_items')
                          ->where('sid', $sampleID)
                          ->where('sample_v', 2)
                          ->where('is_formulated', 0)
                          ->where('sample_cat_id', $sample_cat_id)
                          ->where('brand_type', 3)
                      ->where('admin_status','!=',1)
                          ->get();
                          $i = 0;
                          if (count($samplesDataItemArr) > 0) {
                              $i++;
                          ?>
                              <tr>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                  </td>
                              </tr>
                          <?php
  
                              foreach ($samplesDataItemArr as $key => $rowData) {
                                 
  
                                if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                              </td>
                          </tr>
                          <tr>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                      <span style="font-size: 12px;">Discriptions</span>
                                  </b></td>
                                  <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                          </tr>
                         
  
  
  
                          <tr>
                              <td height="6" colspan="6"></td>
                          </tr>
                          <!-- row  count  -->
  
                                  <?php
                              }
                          }
  
  
                          //brand 3  stop 


                          //brand 2 start 
                       
						$samplesDataItemArr = DB::table('sample_items')
                        ->where('sid', $sampleID)
                        ->where('sample_v', 2)
                        ->where('is_formulated', 0)
                        ->where('sample_cat_id', $sample_cat_id)
                        ->where('brand_type', 2)
                        ->where('admin_status','!=',1)
                        ->get();
                          $i = 0;
                          if (count($samplesDataItemArr) > 0) {
                              $i++;
                          ?>
                              <tr>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                  </td>
                              </tr>
                          <?php
  
                              foreach ($samplesDataItemArr as $key => $rowData) {
                                 
  
                                if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                              </td>
                          </tr>
                          <tr>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                      <span style="font-size: 12px;">Discriptions</span>
                                  </b></td>
                                  <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                          </tr>
                          
  
  
  
                          <tr>
                              <td height="6" colspan="6"></td>
                          </tr>
                          <!-- row  count  -->
  
                                  <?php
                              }
                          }
  
  
                          //brand 2  stop 

                           //brand 1 start 
                       
                           $samplesDataItemArr = DB::table('sample_items')
                           ->where('sid', $sampleID)
                           ->where('sample_v', 2)
                           ->where('is_formulated', 0)
                           ->where('sample_cat_id', $sample_cat_id)
                           ->where('brand_type', 1)
                           ->where('admin_status','!=',1)
                           ->get();
                          $i = 0;
                          if (count($samplesDataItemArr) > 0) {
                              $i++;
                          ?>
                              <tr>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="26" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand</b> {{@$clientDataArr->brand}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Brand Type</b>:{{$brandStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>Order Value</b>:{{$orderStr}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                      <span style="font-size: 12px;">{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</span>
                                  </td>
                                  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>
                                      <span style="font-size: 12px;"><b>By</b>:{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</span>
                                  </td>
                              </tr>
                          <?php
  
                              foreach ($samplesDataItemArr as $key => $rowData) {
                                 
  
                                 
                                if($samplesDataArr->is_modify_sample==1){
                                    $strModifyLink=$samplesDataArr->modify_sample_pre_code."(M)";
                                }else{
                                    $strModifyLink="";
                                }

                               
                                ?>
                                 <tr>
                           <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle>
                            <b>
                                    <span style="font-size: 12px;"><b>{{@$rowData->sid_partby_code}}</b></span>
                                    <span style="font-size: 8px;"><b>{{@$strModifyLink}}</b></span>
                                </b>
                            </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Name</b>:<br>{{ucwords(strtolower(@$rowData->item_name))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Cat:</b><br>{{ucwords(@$rowData->sample_cat)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Color:</b><br>{{ ucwords(strtolower(@$rowData->sample_color))}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</span>
                              </td>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                                  <span style="font-size: 12px;"><b>Target Price:</b><br>{{@$rowData->price_per_kg}}/KG</span>
                              </td>
                          </tr>
                          <tr>
                              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>
                                      <span style="font-size: 12px;">Discriptions</span>
                                  </b></td>
                                  <td style="background:#f1f1f1;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left">
                                <span style="font-size: 12px;">{{ucwords(strtolower(@$rowData->item_info))}} </span>
                            </td>
                          </tr>
                         
  
  
  
                          <tr>
                              <td height="6" colspan="6"></td>
                          </tr>
                          <!-- row  count  -->
  
                                  <?php
                              }
                          }
  
  
                          //brand 1  stop 




                        ?>                                            
                              
                    <?php endforeach; ?>
                     <!-- rest not admin uget start  -->

                </table>




            </div>



        </div>
    </div>
</div>
<!-- main  -->