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
              $batchVal=$batchSize;
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
    <div class="m-portlet__body">
      <div id="div_printmeRND">
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
    padding: 3px;
  }

        </style>
       

        <table cellspacing="0" border="0">
	<colgroup width="39"></colgroup>
	<colgroup width="85"></colgroup>
	<colgroup width="96"></colgroup>
	<colgroup width="50"></colgroup>
	<colgroup width="75"></colgroup>
	<colgroup width="85"></colgroup>
	<colgroup width="186"></colgroup>
	<colgroup width="70"></colgroup>
	<colgroup width="77"></colgroup>
	<colgroup width="53"></colgroup>
	<colgroup width="58"></colgroup>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 height="58" align="center" valign=middle><br><img src="{{asset('logoBo.png')}}" width=55 height=55 hspace=30 vspace=3>
		</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 rowspan=2 align="center" valign=middle><font size=4>MAX</font></td>
		</tr>
	<tr>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 rowspan=2 align="center" valign=middle><font size=3>A-91, Block A, Wazirpur Industrial Area, Delhi , 110052</font></td>
		</tr>
	<tr>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 height="17" align="center" valign=middle><b>BATCH PROCESSING RECORD</b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="left" valign=middle><b>Product Name</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 align="left" valign=left>{{$boFormulaChildArrFIRST->formula_name}}</td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch No.</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pack Size</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="left" valign=middle><b>M.L.No.:</b> </td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="32" align="left" valign=middle><b>Manufacturer</b> : MAX Pvt. Ltd, A-91,Wazirpur Insustrial Area, New Delhi -110052</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="left" valign=top><b>Manufactured For :</b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b>Batch Size:<b> {{$batchVal}} Kg</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Mfg. Date</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="left" valign=middle><b>Exp. Date :</b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 height="17" align="left" valign=middle><b>Shelf Life</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Market:</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="left" valign=middle>Domestic/Export</td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=11 rowspan=2 height="34" align="center" valign=middle><b><font size=3>Manufacturing Process</font></b></td>
		</tr>
	<tr>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 height="20" align="center" valign=middle><b><font size=3>Manufacturing Instructions</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b>Time</b></td>
		</tr>

	
</table>

        <table cellspacing="0" border="0">
          <colgroup width="29"></colgroup>
          <colgroup width="156"></colgroup>
          <colgroup width="77"></colgroup>
          <colgroup width="85"></colgroup>
          <colgroup width="260"></colgroup>
          <colgroup width="73"></colgroup>
          <colgroup width="76"></colgroup>
          <colgroup width="56"></colgroup>
          <colgroup width="55"></colgroup>
          
          
          <tr>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>Phase</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Ingredient Name</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b></b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>MFG QT(KG)</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Process</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>RPM</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Temp</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>From</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>To</b></td>
          </tr>

          <?php
           

          foreach ($boFormulaChildProcessArr as $key => $rowData) {
          ?>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" height="17">
              {{$rowData->phase_code}}
              </td>
              <td colspan="3" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17">
                  <table>
                    <?php 
                     
                foreach ($boFormulaChildArr as $key => $row) {
                  if($rowData->phase_code==$row->phase){
                    $batchPFormula=(floatval($row->dos_percentage)/100)*floatval($batchVal)
                    ?>
                    <tr>
                   
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  height="30" align= "center" width="153px">
                    {{$row->ingredent_name}}
                      </td>
                      <td align="center" width="79px">
                      {{$row->dos_percentage}}
                      </td>
                      <td  align="center" width="79px">
                      {{$batchPFormula}} Kg
                      </td>

                    
                     </tr>
                    <?php

                  }
                 

                }
                 ?>

                    
                   
                  </table>
              </td>
             
             
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" height="17">
                {{$rowData->Process}}
              </td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" height="17">
              {{$rowData->rpm}}
              </td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" height="17">
              {{$rowData->temp}} °C
              </td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" height="17">
              
              </td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" height="17">
             
              </td>

            </tr>

          <?php
          }
          ?>

          

          
          <!-- <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">SUM</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" sdval="100" sdnum="16393;">100</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>BATCH SIZE</b>: {{$batchVal}}Kg</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
          </tr> -->

          <tr>
            <td height="40"  style="border-top: 0px solid #000000; border-bottom: 0px solid #000000; border-left: 0px solid #000000; border-right: 0px solid #000000" height="17" colspan="5" align="left"><b>Sample Drawn By (Sign IPQA Chemist)</b></td>
            <td style="border-top: 0px solid #000000; border-bottom: 0px solid #000000; border-left: 0px solid #000000; border-right: 0px solid #000000" colspan="4" align="center"><b>Date:</b></td> 
            
          </tr>
        </table>



      </div>
    </div>
    
  </div>
</div>
<!-- main  -->