<!-- main  -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile" style="display:#">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Formulations Base Details::
                        <?php
                        // echo "<pre>";
                        // print_r($data);
                        $boFormulaChildArr = DB::table('base_bo_formuation_child')
                            ->where('fm_id', $data->id)
                            ->get();

                            $boFormulaChildArrUniq = DB::table('base_bo_formuation_child')
                            ->where('fm_id', $data->id)    
                            ->orderBy('phase', 'asc')          
                            ->distinct()              
                            ->get('phase');
                        $boFormulaChildProcessArr = DB::table('base_bo_formuation_child_process')
                            ->where('fm_id', $data->id)
                            ->get();

                        ?>
                    </h3>
                </div>
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

                    table,
                    th,
                    td {
                        border: 1px solid black;
                        border-collapse: collapse;
                    }

                    th,
                    td {
                        padding: 3px;
                    }
                </style>
                <table cellspacing="0" border="0">
                    <colgroup width="69"></colgroup>
                    <colgroup width="156"></colgroup>
                    <colgroup width="77"></colgroup>
                    <colgroup width="85"></colgroup>
                    <colgroup width="297"></colgroup>
                    <colgroup width="73"></colgroup>
                    <colgroup width="84"></colgroup>
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="40" align="left"><b>Product </b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>pH Range </b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>FM CODE:</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">{{@$data->fm_code}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>Sample ID</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">Batch Size</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">{{@$data->mfg_qty}}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Formulated on:</b>16 April 2022</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Formulated By</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">{{$data->created_name}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>Phase</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Ingredient Name</b></td>
                        <td colspan="2" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right"><b></b></td>
                        <!-- <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>MFG qty</b></td> -->
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><b>Process</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>RPM</b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Temp</b></td>
                    </tr>

                    <?php 
                      $totV=0;
                      
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

            <td colspan="3"   align="center" valign=middle>
                <table cellspacing="0" border="1">
                  <?php 
                  $boFormulaChildArr = DB::table('bo_formuation_child')
                  ->where('fm_id', $data->id)
                  ->where('phase', $rowData->phase)                  
                  ->orderBy('dos_percentage', 'desc')   
                  ->get();
                

                  foreach ($boFormulaChildArr as $key => $rowChild) {
                    $totV=$totV+$rowChild->dos_percentage;

                      ?>
                       <tr>
                      <td   height="50" align= "left" width="350px">
                        {{$rowChild->ingredent_name}}
                      </td>
                      <td align="center" width="40px">
                        {{$rowChild->dos_percentage}}
                      </td>
                     
                      </tr>

                      <?php

                  }
                  ?>

                 
                </table>
          </td>
           
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" valign=middle>{{@$boFormulaChildProcessArrChild->Process}} </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="2000" sdnum="16393;">{{@$boFormulaChildProcessArrChild->rpm}}</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>{{@$boFormulaChildProcessArrChild->temp}}</td>
           
           
           
          </tr>

              <?php
           }
          ?>



                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><br></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">SUM</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="right" sdval="100" sdnum="16393;">{{$totV}}</td>
                        
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
                    </tr>
                </table>



            </div>
        </div>



        <!--begin: Search Form -->
        <input type="hidden" id="txtSampleAction" value="{{Request::segment(2)}}">



        <!--begin: Datatable -->
        <table style="display:none" class="table table-striped- table-bordered table-hover table-checkable" id="m_table_RNDFormulationView5" style="display: ;">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Ingredient</th>
                    <th>Dose(%)</th>
                    <th>MGF QTY(gm %)</th>
                    <th>Phase</th>
                    <th>Cost</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- datalist -->
</div>
<!-- main  -->


<!--begin::Modal-->
<div class="modal fade" id="m_modal_4ING_DETAIL45" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingredent Details4</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">sdf
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Enter BatchZise:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                  
                    <div class="modal-footer">
                    
                    <button type="button" class="btn btn-primary">Genereate</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>










<!-- m_modal_6 -->