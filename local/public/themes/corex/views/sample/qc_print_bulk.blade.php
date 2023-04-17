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

                    b,
                    strong {
                        font-weight: bold;
                        margin-left: 5px;
                    }
                    
                </style>
                <table cellspacing="0" border="1">
                    <colgroup width="111"></colgroup>
                    <colgroup width="117"></colgroup>
                    <colgroup width="60"></colgroup>
                    <colgroup width="142"></colgroup>
                    <colgroup width="123"></colgroup>
                    <colgroup width="171"></colgroup>
                    <tr>
                        <td colspan=6 height="23" align="center"><b>
                                <font face="Liberation Serif" size=4>ORDER FORM</font>
                            </b></td>
                    </tr>
                    <tr>
                        <td height="30" align="left"><b>ORDER NO:</b></td>
                        <td align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$qc_data->order_id}}/{{$qc_data->subOrder}}</strong></font>
                        </td>
                        <td colspan=2 align="left"><b>BRAND /REF NAME: </b></td>
                        <td colspan=2 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->brand_name }}</strong></font>
                        </td>
                    </tr>

                    <tr>
                        <td colspan=2 height="30" align="left"><b>PREVIOUS ORDER NO. IF REPEAT</b></td>
                        <td align="center">{{ $qc_data->order_repeat ==2 ? 'YES':'NO'}}</td>
                        <td colspan=2 align="left"><b>PREVIOUS ORDER DT</b></td>
                        <td align="center" sdval="525252" sdnum="16393;">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->order_repeat ==2 ? $qc_data->pre_order_id :''}}</strong></font>
                        </td>
                    </tr>

                    <tr>


                        <td colspan=4 align="left"><b>TARGET DELIVERY DATE</b></td>
                        <td align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ date("d-F-Y", strtotime($qc_data->due_date))  }}</strong></font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2 height="18" align="left"><b>SALES PERSON</b></td>
                        <td colspan=4 align="left">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong> {{ strtoupper(AyraHelp::getUser($qc_data->created_by)->name) }}</strong></font>
                        </td>

                    </tr>


                </table>

                <style type="text/css">
                    table {
                        border-collapse: collapse;
                    }

                    table,
                    td,
                    th {
                        border: 1px solid black;
                    }

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

                <table style="margin-top:4px" cellspacing="0" border="1">
                    <colgroup width="144"></colgroup>
                    <colgroup width="113"></colgroup>
                    <colgroup width="121"></colgroup>
                    <colgroup width="116"></colgroup>
                    <colgroup span="2" width="116"></colgroup>
                    <tr>
                        <td height="32" align="left" valign=middle bgcolor="#B2B2B2"><b>STAGE</b></td>
                        <td align="center" valign=middle bgcolor="#B2B2B2"><b>RECEIVE TARGET</b></td>
                        <td align="center" valign=middle bgcolor="#B2B2B2"><b>TARGET COMPLETE DT</b></td>
                        <td align="center" bgcolor="#B2B2B2"><b>ACTUAL COMPLETE</b></td>
                        <td align="center" bgcolor="#B2B2B2"><b>DAYS OF DELAY</b></td>
                        <td align="center" bgcolor="#B2B2B2"><b>REASON OF DELAY</b></td>
                    </tr>
                    <tr>
                        <td height="30" align="left" valign=middle><b>ORDER RECEIVE</b> </td>
                        <td align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ date("d-F-Y", strtotime($qc_data->created_at))  }}</strong></font>
                        </td>
                        <td align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ date("d-F-Y", strtotime($qc_data->due_date))  }}</strong></font>
                        </td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                    </tr>

                    <tr>
                        <td height="30" align="left" valign=middle><b>PACKING</b></td>
                        <td align="left"><br></td>
                        <td align="center"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                    </tr>
                    <tr>
                        <td height="30" align="left" valign=middle><b>DISPATCH</b></td>
                        <td align="center"></td>
                        <td align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ date("d-F-Y", strtotime($qc_data->due_date))  }}</strong></font>
                        </td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                    </tr>
                    <tr>

                </table>


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
                <br>
                <table cellspacing="0" border="1">
                    <colgroup width="50"></colgroup>
                    <colgroup width="154"></colgroup>
                    <colgroup width="80"></colgroup>
                    <colgroup width="85"></colgroup>
                    <colgroup width="80"></colgroup>
                    <colgroup width="80"></colgroup>
                    <colgroup width="85"></colgroup>
                    <colgroup width="95"></colgroup>

                    </tr>
                    <tr>
                        <td colspan=9 height="30" align="left" valign=middle><b>ORDER ITEMS</b></td>
                    </tr>
                    <tr>
                        <td colspan=2 height="25" align="center" valign=middle><b>MATERIAL NAME</b></td>
                        <td align="center"><b>SAP VOUCHER</b></td>
                        <td align="center" valign=middle><b>RATE</b></td>
                        <td align="center" valign=middle><b>QUANTITY</b></td>
                        <td align="center" valign=middle><b>TOTAL AMT</b></td>
                        <td align="center"><b>GRADE<br>/SPECS</b></td>
                        <td align="center" align=left><b>PACKING</b></td>
                        <td align="center" align=left><b>QC</b></td>

                    </tr>
                    <?php

                    /*foreach ($qc_bulkorder as $key => $value) {
                                         
                                          
                                            //print_r($value->size);
                                            ?>
                                             <tr>
                                            <td height="30"  align="left" valign=middle bgcolor="#CCCCCC"><br></td>
                                            <?php 
                                            if($value->item_name==''){
                                               
                                            }else{
                                                if(isset($value->item_name)){
                                                    ?>
                                                  <td  height="20" align="left" bgcolor="#CCCCCC"><font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->item_name}}</strong></font></td>
                                                <?php
                                                }else{
                                                    ?>
                                                  <td  height="20" align="left" bgcolor="#CCCCCC"><font face="Liberation Serif" size=2 font-weight: 700><strong></strong></font></td>
                                                <?php
                                                }
                                                
                                            }
                                            ?>
                                            <?php 
                                            if($value->qty==''){
                                               
                                            }else{
                                                ?>
                                                 <td height="20" align="center" bgcolor="#CCCCCC"><font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->qty}}</strong></font></td>
                                                 
                                                <?php
                                            }
                                            ?>
                                            
                                           
                                           
                                            <td height="20" align="left"><br></td>
                                            <td height="20" align="left"><br></td>
                                            <td height="20" align="left"><br></td>
                                            <td height="20" align="left"><br></td>
                                            <td height="20" align="left"><br></td>
                                            
                                            
                                                </tr>
                                            <?php
                                        }
                                        */
                    foreach ($qc_bulkorder as $key => $value) {
                    ?>
                        <tr>
                            <td height="30" align="left" valign=middle bgcolor="#CCCCCC"><br></td>
                            <td height="30" align="left" bgcolor="#CCCCCC">
                                <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->item_name}}</strong></font>
                            </td>
                            <td height="20" align="left"><br></td>
                            <?php
                            if (empty($value->qty)) {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><b></b></font>
                                </td>
                            <?php
                            } else {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><b>{{$value->rate}}/{{$value->item_size}}</b></font>
                                </td>
                            <?php
                            }
                            ?>

                            <?php
                            if (empty($value->qty)) {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong></strong></font>
                                </td>
                            <?php
                            } else {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->qty}} {{$value->item_size}}</strong></font>
                                </td>
                            <?php
                            }
                            ?>

                            <?php
                            if (empty($value->qty)) {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong> </strong></font>
                                </td>
                            <?php
                            } else {
                            ?>
                                <td height="30" align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>₹ {{($value->rate*$value->qty)}} </strong></font>
                                </td>
                            <?php
                            }
                            ?>



                            <td height="20" align="left"><br></td>
                            <td height="30" align="center">
                                <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->packing}}</strong></font>
                            </td>
                            <td height="30" align="center">
                                <font face="Liberation Serif" size=2 font-weight: 700><strong></strong></font>
                            </td>


                        </tr>
                    <?php
                    }

                    ?>


                </table>

                {{-- stage       --}}

                {{-- <style type="text/css">
                                body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Liberation Sans"; font-size:x-small }
                                a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
                                a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
                                comment { display:none;  } 
                            </style>
                            <br>
                           <table cellspacing="0" border="1">
                            <colgroup width="215"></colgroup>
                            <colgroup width="125"></colgroup>
                            <colgroup width="110"></colgroup>
                            <colgroup width="152"></colgroup>
                            <colgroup width="121"></colgroup>
                        <td colspan=6 height="30"  align="left" valign=middle><b>2.PRODUCTION PROCESS</b></td>
                        </tr>
                            <tr>
                                <td height="32" align="left"><b>REMARKS</b></td>
                                <td  colspan=6  align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->production_rmk }}</strong></font>
                </td>
                <tr>
                    <td height="32" align="left" valign=middle><b>FM NO. / APPROVED SAMPLE NO.</b></td>
                    <td colspan=2 align="center" valign=middle bgcolor="#999999">
                        <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->item_fm_sample_no }}
                    </td>
                    <td align="left" valign=middle><b>PREVIOUS ORDER BATCH NO.</b></td>
                    <td colspan=2 align="center" valign=middle bgcolor="#999999"><br></td>
                </tr>



                <tr>
                    <td height="28" align="center" valign=middle><b>QUALITY CHECK</b></td>
                    <td colspan=2 align="center" valign=middle><b>REMARKS</b></td>
                    <td align="center"><b>SIGN FROM CHEMIST</b></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                </tr>
                <tr>
                    <td height="30" align="left"><b>RAW MATERIAL TESTED AND APPROVED ?</b></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                    <td align="left"><br></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                </tr>
                <tr>
                    <td height="30" align="left"><b>FINISHED PRODUCT TESTED AND APPROVED ?</b></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                    <td align="left"><br></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                </tr>
                <tr>
                    <td height="30" align="left"><b>F.G MATCHES APPROVED SAMPLE</b></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                    <td align="left"><br></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                </tr>
                <tr>
                    <td height="30" align="left"><b>F.G MATCHES PREVIOUS ORDER SAMPLE</b></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                    <td align="left"><br></td>
                    <td colspan=2 align="center" valign=middle><br></td>
                </tr>
                </table>
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
                </style><br>

                <table cellspacing="0" border="1">
                    <colgroup width="215"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="272"></colgroup>
                    <tr>
                        <td height="30" align="center" valign=middle><b>ACTUAL BATCH PRODUCED</b></td>
                        <td colspan=2 align="center" valign=middle><b>MATERIAL ISSUED TO PACKING</b></td>
                        <td colspan=3 align="center" valign=middle><b>SIGN FROM MANUFACTUREING CHEMIST</b></td>
                    </tr>
                    <tr>
                        <td height="38" align="right" sdval="3" sdnum="16393;"></td>
                        <td colspan=2 align="center" valign=middle sdval="3" sdnum="16393;"></td>
                        <td colspan=3 align="center" valign=middle></td>
                    </tr>
                </table> --}}


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
                <br>
                <table cellspacing="0" border="1">
                    <colgroup width="215"></colgroup>
                    <colgroup width="508"></colgroup>
                    <tr>
                        <td height="30" align="left" valign=middle><b>DISPATCH</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="24" align="left" valign=middle><b>TRANSPORTER</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="22" align="left" valign=middle><b>CARTONS</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="27" align="left" valign=middle><b>UNITS IN EACH CARTOON</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="25" align="left" valign=middle><b> UNITS</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="35" align="left" valign=middle><b>ACCOUNTS NOC</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                    <tr>
                        <td height="40" align="left" valign=middle><b>APPROVED BY</b></td>
                        <td colspan=5 align="center" valign=middle sdval="1" sdnum="16393;"></td>
                    </tr>
                </table>



                <br>
                <table cellspacing="0" border="1">
                    <colgroup width="215"></colgroup>
                    <colgroup width="125"></colgroup>
                    <colgroup width="110"></colgroup>
                    <colgroup width="152"></colgroup>
                    <colgroup width="121"></colgroup>

                    <tr>
                        <td height="32" align="left"><b>PRODUCTION REMARKS</b></td>
                        <td colspan=6 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->production_rmk }}</strong></font>
                        </td>

                    </tr>
                    <tr>
                        <td height="32" align="left"><b>PACKING REMARKS</b></td>
                        <td colspan=6 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->packeging_rmk }}</strong></font>
                        </td>

                    </tr>

                    <tr>
                        <td height="32" align="left" valign=middle><b>FM NO. / APPROVED SAMPLE NO.</b></td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->item_fm_sample_no }}
                        </td>
                        <td align="left" valign=middle><b>PREVIOUS ORDER BATCH NO.</b></td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999"><br></td>
                    </tr>




                </table>

            </div>
            {{-- end --}}
            <br>
            <?php
            if ($qc_data->account_approval) {
                $Amsg = "Account Approved :on " . optional($qc_data)->account_approved_on . " Remarks " . optional($qc_data)->account_msg;
            ?>
                {!! QrCode::generate($Amsg); !!}
            <?php
            } else {
            }
            ?>


        </div>

    </div>
</div>
<!-- main  -->