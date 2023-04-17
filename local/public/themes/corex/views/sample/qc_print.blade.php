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
                        $user = auth()->user();
                        $userRoles = $user->getRoleNames();
                        $user_role = $userRoles[0];
                        if ($user_role == 'Admin' || Auth::user()->id == 90 || $user_role == 'SalesUser') {
                        ?>
                            <strong> :CD:{{ date("d-F-Y", strtotime($qc_data->commited_date))  }}</strong>
                        <?php
                        }
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
                    b, strong {
    font-weight: bold;
    margin-left: 5px;
}

                </style>
                <table cellspacing="0" border="0">
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
                        <td height="30"><b>ORDER NO:</b></td>
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
                        <td colspan=2 height="24" align="left"><b>ITEM NAME/DESCRIPTION</b></td>
                        <td colspan=4 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->item_name }}</strong></font>
                        </td>

                    </tr>
                    <tr>
                        <td colspan=2 height="18" align="left"><b>SALES PERSON</b></td>
                        <td colspan=4 align="left">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong> {{ strtoupper(AyraHelp::getUser($qc_data->created_by)->name) }}</strong></font>
                        </td>

                    </tr>


                </table>

                {{-- stage       --}}
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
                        <td height="30" align="left" valign=middle> <b>DESIGN</b></td>
                        <td align="left"><br></td>
                        <td align="center"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                    </tr>

                    <tr>
                        <td height="30" align="left" valign=middle><b>PURCHASE</b></td>
                        <td align="left"><br></td>
                        <td align="center"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                        <td align="left"><br></td>
                    </tr>
                    <tr>
                        <td height="30" align="left" valign=middle><b>PRODUCTION</b></td>
                        <td align="left"><br></td>
                        <td align="center"><br></td>
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
                {{-- stage       --}}



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
               
                <table  style="margin-top:4px" cellspacing="0" border="1">
                    <colgroup width="50"></colgroup>
                    <colgroup width="192"></colgroup>
                    <colgroup width="80"></colgroup>
                    <colgroup width="85"></colgroup>
                    <colgroup width="80"></colgroup>
                    <colgroup width="95"></colgroup>
                    <colgroup width="90"></colgroup>
                    <td colspan=8 height="35" align="left"><b>1.MATERIAL PLANNING</b></td>
                    </tr>
                    <tr>
                        <td colspan=8 height="34" align="left" valign=middle><b>BILL OF MATERIALS</b></td>
                    </tr>
                    <tr>
                        <td colspan=2 height="31" align="center" valign=middle><b>MATERIAL</b></td>
                        <td align="center" valign=middle><b>QUANTITY REQUIRED</b></td>
                        <td align="center" valign=middle><b>SAP VOUCHER</b></td>
                        <td align="center"><b>QUANTITY ISSUED</b></td>
                        <td align="center"><b>QUANTITY PACKED</b></td>
                        <td align="center" valign=middle><b>RETURNED</b></td>
                        <td align="center" valign=middle><b>WASTAGE</b></td>
                    </tr>
                    <?php

                    foreach ($qc_bom as $key => $value) {


                        //print_r($value->size);
                    ?>
                        <tr>
                            <td height="30" align="left" valign=middle bgcolor="#CCCCCC"><br></td>
                            <?php
                            if ($value->bom_from == 'N/A') {
                            } else {
                                if (isset($value->m_name)) {
                            ?>
                                    <td height="20" align="left" bgcolor="#CCCCCC">
                                        <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->m_name}} {{$value->bom_from}}</strong></font>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td height="20" align="left" bgcolor="#CCCCCC">
                                        <font face="Liberation Serif" size=2 font-weight: 700><strong></strong></font>
                                    </td>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            if ($value->bom_from == 'N/A') {
                            } else {
                            ?>
                                <td height="20" align="center" bgcolor="#CCCCCC">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$value->qty}}</strong></font>
                                </td>
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
                    ?>

<?php

// echo "<pre>";
// print_r($qc_data);
//  $nounit="";
//$batchSize="";
// die;
$sizeUnit = $qc_data->item_size . " " . $qc_data->item_size_unit;

if ($qc_data->item_size_unit == 'Kg' || $qc_data->item_size_unit == 'L') {

    if ($qc_data->item_size_unit == 'Kg') {
        $batchUnitview = " kg";
    } else {
        $batchUnitview = "L";
    }


    $nounit = ($qc_data->item_qty) . " " . $qc_data->item_qty_unit;
    $batchSize = ceil(((($qc_data->item_qty) * ($qc_data->item_size)))) . "" . $batchUnitview;
}

if ($qc_data->item_size_unit == 'Ml' || $qc_data->item_size_unit == 'Gm') {
    if ($qc_data->item_size_unit == 'Ml') {
        $batchUnitview = "L";
    } else {
        $batchUnitview = "Kg";
    }
    $nounit = $qc_data->item_qty . " " . $qc_data->item_qty_unit;
    $batchSize = (ceil((($qc_data->item_qty) * ($qc_data->item_size)) / 1000)) . "" . $batchUnitview;
}


?>


                        <tr>
                        <td></td>
                        <td style="background-color: #FFF;color:#000;" height="20" align="center" valign=middle><b>BULK</b></td>
                        <td style="background-color: #FFF;color:#000;"  height="20" align="center" valign=middle><b>{{$batchSize}}</b></td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td height="30" align="left" valign=middle><b>FRAGRANCE</b></td>
                        <td>{{$qc_data->order_fragrance}}</td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
                        <td><br></td>
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
                </style>
                 
              
                <table  style="margin-top:4px" cellspacing="0" border="1">
                    <colgroup width="218"></colgroup>
                    <colgroup width="125"></colgroup>
                    <colgroup width="110"></colgroup>
                    <colgroup width="152"></colgroup>
                    <colgroup width="118"></colgroup>
                    <td colspan=6 height="20" align="left" valign=middle><b>2.PRODUCTION PROCESS</b></td>
                    </tr>
                    <tr>
                        <td height="32" align="left"><b>REMARKS</b></td>
                        <td colspan=6 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->production_rmk }}</strong></font>
                        </td>

                    </tr>

                    <td height="30" align="left" valign=middle><b>PRODUCTION QC.</b></td>
                    <td colspan=5 align="left"><br></td>
                    </tr>
                    
                    <tr>
                        <td height="32" align="left" valign=middle><b>FM NO. / APPROVED SAMPLE NO.</b></td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->item_fm_sample_no }}
                        </td>
                        <td align="left" valign=middle><b>PREVIOUS ORDER BATCH NO.</b></td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999"><br></td>
                    </tr>
                    <tr>
                        <td height="28" align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                        <td align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="30" align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                        <td align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="25" align="center" valign=middle><b>SIZE OF 1 UNIT </b></td>
                        <td colspan=2 align="center" valign=middle><b>NO OF UNITS </b></td>
                        <td align="left"><b>BATCH SIZE </b></td>
                        <td colspan=2 align="center" valign=middle><b>BATCH NO</b></td>
                    </tr>

                   
                    <tr>
                        <td height="33" align="center" bgcolor="#999999">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $sizeUnit }} </strong></font>
                        </td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $nounit }}</strong></font>
                        </td>
                        <td align="center" bgcolor="#999999">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $batchSize}}</strong></font>
                        </td>
                        <td colspan=2 align="center" valign=middle bgcolor="#999999"><br></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                       
                        <font face="Liberation Serif" size=0.5>#RMKG-{{ optional($qc_data)->item_RM_Price }} JBCP-{{ optional($qc_data)->item_BCJ_Price }} LB-{{ optional($qc_data)->item_Label_Price }} MCP-{{ optional($qc_data)->item_Material_Price }} LC-{{ optional($qc_data)->item_LabourConversion_Price }} MRG-{{ optional($qc_data)->item_Margin_Price }} </font>

                        </td>
                    
                    </tr>
                    <?php 
                    $fg="";
                    $ch="";
                    $ph="";
                    $apr="";
                    $fmy="";
                    $sampleFor = DB::table('samples_formula')
                    ->where('sample_code_with_part', $qc_data->item_fm_sample_no)
                    ->first();
                    if($sampleFor==null){
                        //echo "NA";
                        $fg="";
                        $ch="";
                        $ph="";
                        $apr="";
                        $fmy="";

                    }else{
                        //print_r($sampleFor);
                        $usersCH = DB::table('users')           
            ->where('id',$sampleFor->chemist_id)
            ->first();
                        $fg=optional($sampleFor)->fragrance;
                        $ch=optional($sampleFor)->color_val;
                        $ph=optional($sampleFor)->ph_val;
                        $apr=optional($sampleFor)->apperance_val;
                        $fmy=@$usersCH->name;
                    }

                    ?>

                    <tr colspan=4>
                   
                    
                    <tr>
                        <td height="25" align="center" valign=left><b>Fragrance:</b>{{$fg}} </td>
                        <td height="25" align="center" valign=left><b>Color :</b>{{$ch}} </td>
                        <td height="25" align="center" valign=left><b>PH</b>{{$ph}}</td>
                        <td height="25" align="center" valign=left><b>Appearance:</b>{{$apr}} </td>
                        <td height="25" align="center" valign=left><b> FM BY:</b> {{$fmy}}</td>
                        
                    </tr>   
                    </tr>
                    
                    <tr>
                        <td height="28" align="center" valign=middle><b>QUALITY CHECK</b></td>
                        <td colspan=2 align="center" valign=middle><b>REMARKS</b></td>
                        <td align="center"><b>SIGN FROM CHEMIST</b></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="57" align="left"><b>RAW MATERIAL TESTED AND APPROVED ?</b></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                        <td align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="49" align="left"><b>FINISHED PRODUCT TESTED AND APPROVED ?</b></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                        <td align="center" valign=middle><b>{{ strtoupper(AyraHelp::getUser($qc_data->created_by)->user_prefix) }}</b><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="48" align="left"><b>F.G MATCHES APPROVED SAMPLE</b></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                        <td align="left"><br></td>
                        <td colspan=2 align="center" valign=middle><br></td>
                    </tr>
                    <tr>
                        <td height="55" align="left"><b>F.G MATCHES PREVIOUS ORDER SAMPLE</b></td>
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
                </style>                      
               
                <table  style="margin-top:4px" cellspacing="0" border="0">
                    <colgroup width="100"></colgroup>
                    <colgroup width="120"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="134"></colgroup>
                    <colgroup width="132"></colgroup>
                    <tr>
                        <td colspan="6" height="8" align="left" valign=left>
                        <font face="Liberation Serif" size=0.5>#RM-{{optional($qc_data)->item_RM_Price}} BCP-{{optional($qc_data)->item_BCJ_Price}} LP-{{optional($qc_data)->item_Label_Price}} MCP-{{optional($qc_data)->item_Material_Price}} LCP-{{optional($qc_data)->item_LabourConversion_Price}} M-{{optional($qc_data)->item_Margin_Price}}</font>
                         </td>
                        
                    </tr>
                    <!-- <tr>
                        <td height="38" align="right" sdval="3" sdnum="16393;"></td>
                        <td colspan=2 align="center" valign=middle sdval="3" sdnum="16393;"></td>
                        <td colspan=3 align="center" valign=middle></td>
                    </tr> -->
                </table>
                
                     
               
                           

                <table  style="margin-top:4px"  cellspacing="0" border="1">
                    <colgroup width="218"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="118"></colgroup>
                    <colgroup width="270"></colgroup>
                    <tr>
                        <td height="52" align="center" valign=middle><b>ACTUAL BATCH PRODUCED</b></td>
                        <td colspan=2 align="center" valign=middle><b>MATERIAL ISSUED TO PACKING</b></td>
                        <td colspan=3 align="center" valign=middle><b>SIGN FROM MANUFACTUREING CHEMIST</b></td>
                    </tr>
                    <tr>
                        <td height="38" align="right" sdval="3" sdnum="16393;"></td>
                        <td colspan=2 align="center" valign=middle sdval="3" sdnum="16393;"></td>
                        <td colspan=3 align="center" valign=middle></td>
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
                </style>
               
                <table  style="margin-top:4px" cellspacing="0" border="1">
                    <colgroup width="218"></colgroup>
                    <colgroup width="125"></colgroup>
                    <colgroup width="110"></colgroup>
                    <colgroup width="152"></colgroup>
                    <colgroup width="118"></colgroup>


                    <tr>
                        <td height="32" align="left"><b>4.PACKAGING REMARKS</b></td>
                        <td colspan=6 align="center">
                            <font face="Liberation Serif" size=2 font-weight: 700><strong>{{ $qc_data->packeging_rmk }}</strong></font>
                        </td>

                    </tr>
                </table>

                <?php
                if ($qc_data->order_type != 'Bulk') {

                ?>
                    <table cellspacing="0" border="1">
                        <colgroup width="219"></colgroup>
                        <colgroup width="175"></colgroup>
                        <colgroup width="120"></colgroup>
                        <colgroup width="85"></colgroup>
                        <colgroup width="124"></colgroup>
                        <tr>
                            <td height="35" align="left" valign=middle bgcolor="#B2B2B2"><b>PACKAGING PROCESSES</b></td>
                            <td align="center" valign=middle bgcolor="#B2B2B2"><b>YES</b></td>
                            <td align="center" valign=middle bgcolor="#B2B2B2"><b>NO</b></td>
                            <td colspan=3 align="center" valign=middle bgcolor="#B2B2B2"><b>REMARKS</b></td>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($qc_pp as $key => $valueqc) {
                            $i++;

                            if ($qc_data->order_type == 'Bulk') {
                                $qy = "";;
                                $qn = "";
                            } else {
                                $qy = $valueqc->qc_yes;
                                $qn = $valueqc->qc_no;
                            }
                        ?>
                            <tr>
                                <td height="30" align="left" valign=middle> <b>{{ $i.".".$valueqc->qc_label}}</b></td>
                                <td align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$qy}}</strong></font>
                                </td>
                                <td align="center">
                                    <font face="Liberation Serif" size=2 font-weight: 700><strong>{{$qn}}</strong></font>
                                </td>

                                <td colspan=3 align="right" sdval="56" sdnum="16393;"></td>
                            </tr>
                        <?php


                        }
                        ?>


                    </table>
                <?php
                }
                ?>
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
               
                <table  style="margin-top:4px" cellspacing="0" border="1">
                    <colgroup width="220"></colgroup>
                    <colgroup width="503"></colgroup>
                    <tr>
                        <td height="30" align="left" valign=middle><b>5.DISPATCH</b></td>
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
            </div>
            {{-- end --}}

            <br>
            <?php
            if ($qc_data->account_approval) {
                $Amsg = "Account Approved :on " . optional($qc_data)->account_approved_on . " Remarks " . optional($qc_data)->account_msg;
            ?>
                {!! QrCode::generate($Amsg) !!}
            <?php
            } else {
            }
            ?>

        </div>


    </div>
</div>
<!-- main  -->