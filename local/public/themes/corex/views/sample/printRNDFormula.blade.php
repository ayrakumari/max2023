<!-- main  -->
<div class="m-content">
  <!-- datalist -->
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Print Preview Formulation
            <?php
            // echo "<pre>";
            // print_r($data);
            $boFormulaChildArr = DB::table('bo_formuation_child')
              ->where('fm_id', $data->id)
              ->get();
              $boFormulaChildArrUniq = DB::table('bo_formuation_child')
              ->where('fm_id', $data->id)              
              ->distinct()              
              ->orderBy('phase', 'asc')  
              ->get('phase');

            
            $boFormulaChildArrFIRST = DB::table('bo_formuation')
              ->where('id', $data->id)
              ->first();
            // print_r($boFormulaChildArrFIRST);

            $boFormulaChildProcessArr = DB::table('bo_formuation_child_process')
              ->where('fm_id', $data->id)
              ->get();

            $boFormulaChildArrSum = DB::table('bo_formuation_child')
              ->where('fm_id', $data->id)
              ->sum('mfg_pecentage');

            $batchVal = $batchSize;
            // die;
            ?>
          </h3>
        </div>
      </div>
      <div class="m-portlet__head-tools">
        <ul class="m-portlet__nav">
          <li class="m-portlet__nav-item">
            <a href="javascript::void(0)" id="btnPrintSampleRNDFormula" class="btn btn-info  m-btn--custom m-btn--icon">
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
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
  th, td {
    padding: 1px;
  }

        </style>
    <div class="m-portlet__body">
      <div id="div_printmeRND">


        <table cellspacing="0" border="0">
          <colgroup width="39"></colgroup>
          <colgroup width="85"></colgroup>
          <colgroup width="96"></colgroup>
          <colgroup width="50"></colgroup>
          <colgroup width="75"></colgroup>
          <colgroup width="85"></colgroup>
          <colgroup width="139"></colgroup>
          <colgroup width="56"></colgroup>
          <colgroup width="72"></colgroup>
          <colgroup width="53"></colgroup>
          <colgroup width="50"></colgroup>
          <colgroup width="71"></colgroup>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 height="58" align="center" valign=middle><br><img src="{{asset('logoBo.png')}}" width=51 height=51 hspace=37 vspace=5>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=2 align="center" valign=middle>
              <font size=4>MAX</font>
            </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=2 align="center" valign=middle>
              <font size=3>A-91, Block A, Wazirpur Industrial Area, Delhi , 110052</font>
            </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 height="17" align="center" valign=middle><b>BATCH PROCESSING RECORD</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle><b>Product Name</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 align="left" valign=middle>{{$boFormulaChildArrFIRST->formula_name}}</td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch No. </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Pack Size</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle><b>M.L.No.:</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="32" align="left" valign=middle>Manufacturer : MAX Pvt. Ltd, A-91,Wazirpur Insustrial Area, New Delhi -110052</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left" valign=middle><b>Manufactured For :</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch Size {{$batchVal}} Kg</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Mfg. Date</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle><b>Exp. Date :</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 height="17" align="left" valign=middle><b>Shelf Life</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right"><b>Market:</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle>Domestic/Export</td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 rowspan=2 height="34" align="center" valign=middle><b><u>
                  <font size=3>Manufacturing Process</font>
                </u></b></td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 height="20" align="center" valign=middle><b>
                <font size=3>Manufacturing Instructions</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>Time</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>Sign</td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" valign=middle><b>
                <font size=1>Phase</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                <font size=1>Ingredient Name</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1></font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>MFG QT(KG)</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                <font size=1>Process</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>RPM</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>TEMP</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>From </font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>To</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b> <font size=1>Chemist</font></b></td>
          </tr>
          <?php 
           foreach ($boFormulaChildArrUniq as $key => $rowData) {

            $boFormulaChildProcessArrChild = DB::table('bo_formuation_child_process')
            ->where('fm_id', $data->id)
            ->where('phase_code', $rowData->phase)
            ->first();

              ?>
              <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" valign=middle>
            {{$rowData->phase}}
          </td>

            <td colspan="4"   align="center" valign=middle>
                <table cellspacing="0" border="1">
                  <?php 
                  $boFormulaChildArr = DB::table('bo_formuation_child')
                  ->where('fm_id', $data->id)
                  ->where('phase', $rowData->phase)
                  ->orderBy('dos_percentage', 'desc')   
                  ->get();

                  foreach ($boFormulaChildArr as $key => $rowChild) {
                    $batchPFormula=(floatval($rowChild->dos_percentage)/100)*floatval($batchVal);

                      ?>
                       <tr>
                      <td   height="50" align= "left" width="237px">
                        {{$rowChild->ingredent_name}}
                      </td>
                      <!-- <td align="center" width="40px">
                        {{$rowChild->dos_percentage}}
                      </td> -->
                      <td  align="center" width="70px">
                         {{$batchPFormula}} Kg
                        </td>
                      </tr>

                      <?php

                  }
                  ?>

                 
                </table>
          </td>
           
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle>{{@$boFormulaChildProcessArrChild->Process}} </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="2000" sdnum="16393;">{{@$boFormulaChildProcessArrChild->rpm}}</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>{{@$boFormulaChildProcessArrChild->temp}}</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="16393;0;HH:MM:SS"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
          </tr>

              <?php
           }
          ?>
          
          <tr>
            <td height="40"  style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" colspan="8" align="left"><b>Sample Drawn By (Sign IPQA Chemist)</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="4" align="center"><b>Date:</b></td>             
          </tr>         
        </table>
        <hr>
        <div style="page-break-before: always"></div>
        <table cellspacing="0" border="0">
          <colgroup width="39"></colgroup>
          <colgroup width="85"></colgroup>
          <colgroup width="96"></colgroup>
          <colgroup width="50"></colgroup>
          <colgroup width="75"></colgroup>
          <colgroup width="85"></colgroup>
          <colgroup width="139"></colgroup>
          <colgroup width="56"></colgroup>
          <colgroup width="72"></colgroup>
          <colgroup width="53"></colgroup>
          <colgroup width="50"></colgroup>
          <colgroup width="71"></colgroup>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 height="58" align="center" valign=middle><br><img src="{{asset('logoBo.png')}}" width=51 height=51 hspace=37 vspace=5>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=2 align="center" valign=middle>
              <font size=4>MAX</font>
            </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=2 align="center" valign=middle>
              <font size=3>A-91, Block A, Wazirpur Industrial Area, Delhi , 110052</font>
            </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 height="17" align="center" valign=middle><b>BATCH PROCESSING RECORD</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle><b>Product Name</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 align="left" valign=middle>{{$boFormulaChildArrFIRST->formula_name}}</td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch No. </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Pack Size</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle><b>M.L.No.:</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="32" align="left" valign=middle>Manufacturer : MAX Pvt. Ltd, A-91,Wazirpur Insustrial Area, New Delhi -110052</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=7 align="left" valign=middle><b>Manufactured For :</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch Size {{$batchVal}} Kg</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Mfg. Date</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle><b>Exp. Date :</b></td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 height="17" align="left" valign=middle><b>Shelf Life</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right"><b>Market:</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="left" valign=middle>Domestic/Export</td>
          </tr>
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 rowspan=2 height="34" align="center" valign=middle><b><u>
                  <font size=3>Requisition Slip (Raq Materials) </font>
                </u></b></td>
          </tr>
          <tr>
          </tr>
        
          <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" valign=middle><b>
                <font size=1>S. No.</font>
              </b></td>
            <td colspan="4" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                <font size=1>Ingredient Name</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>QTY <br> Required<br> (Kg/L)</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
            <font size=1>QTY <br>Issued <br>(Kg/L)</font>
              </b></td>
           
            <td  colspan="2" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>A.R. No.</font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>Issued By </font>
              </b></td>
              <td  colspan="2" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>Checked By </font>
              </b></td>
           
            
          </tr>
          <?php 
                  $boFormulaChildArr = DB::table('bo_formuation_child')
                  ->where('fm_id', $data->id)
                  ->orderBy('dos_percentage', 'desc')   
                  
                  ->get();
                      $i=0;
                  foreach ($boFormulaChildArr as $key => $rowChild) {
                    $batchPFormula=(floatval($rowChild->dos_percentage)/100)*floatval($batchVal);
                    $i++;
                    ?>
                    <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" valign=middle><b>
                <font size=1>{{$i}}</font>
              </b></td>
            <td colspan="4" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>
                <font size=1>
                {{$rowChild->ingredent_name}}
                </font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1>
                {{$batchPFormula}} Kg
                </font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
            <font size=1></font>
              </b></td>
           
            <td  colspan="2" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1></font>
              </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1> </font>
              </b></td>
              <td  colspan="2" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>
                <font size=1> </font>
              </b></td>
           
            
          </tr>
                    <?php

                  }

                  ?>



          
        </table>


      </div>
    </div>

  </div>
</div>
<!-- main  -->