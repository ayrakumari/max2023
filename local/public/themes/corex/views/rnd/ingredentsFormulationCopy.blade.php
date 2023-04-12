<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Copy and Add New  Formulations
                    </h3>
                    <!-- <table style="margin-left:30px;">
					</table> -->
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <?php
                        //echo "<pre>";

                        $bo_formuation = DB::table('bo_formuation')
                            ->where('id', $fid)
                            ->first();

                        $bo_formuation_child = DB::table('bo_formuation_child')
                            ->where('fm_id', $fid)
                            ->get();

                        $bo_formuation_child_process = DB::table('bo_formuation_child_process')
                        ->where('fm_id', $fid)
                        ->whereNotNull('Process')
                        ->get();


                        //  print_r($bo_formuation_child);

                        // print_r($bo_formuation_child);
                        // print_r($bo_formuation_child_process);


                        if (Auth::user()->id == 14444 || Auth::user()->id == 14456) {
                        ?>
                            <a target="_blank" href="{{route('addIngredetnView')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Add New Ingredient</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>
                    <li class="m-portlet__nav-item">
                        <?php
                        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
                        ?>
                            <a target="_blank" href="{{route('rnd.formulationList')}}" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Formulation List</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>


                    <li class="m-portlet__nav-item">
                        <?php
                        $user = auth()->user();
                        $userRoles = $user->getRoleNames();
                        $user_role = $userRoles[0];

                        if (Auth::user()->id == 145445 || Auth::user()->id == 156345 || $user_role == '4chemist') {
                        ?>
                            <a href="javascript::void(0)" id="btnaddNEWRM" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>ADD NEW RM</span>
                                </span>
                            </a>
                        <?php
                        }
                        ?>
                    </li>




                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <?php
            //  echo "<pre>";
            //  print_r($bo_formuation);

            ?>

            <?php
            $max_id = DB::table('bo_formuation')->max('id') + 1;
            $uname = 'FM-';
            $num = $max_id;
            $str_length = 5;
            $sid_code = $uname . substr("000{$num}", -$str_length);
            ?>


            <form id="btnSaveFormuationRND" class="m-form m-form--fit m-form--label-align-right m-form" action="{{route('saveEditCopyFormulaRND')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="txtFMID" value="{{$bo_formuation->id}}">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label>*Formulation Name:</label>
                            <input type="text" value="{{$bo_formuation->formula_name}}" name="txtFMName" class="form-control m-input" placeholder="Enter Formulation Name">


                        </div>
                        <div class="col-lg-2">
                            <label>FM Code:</label>
                            <input type="text" value="{{$bo_formuation->fm_code}}" name="txtFMCode" style="background-color:#035496;color:#f1f1f1;" readonly class="form-control m-input" placeholder="">

                        </div>
                        
                        <div class="col-lg-4" style="">
                        <input id="m_inputmask_67" type="hidden" name="txtMFGQTY" style="background-color:grey;color:#f1f1f1;" class="form-control m-input" placeholder="">

                            <label>*Sample ID</label>
                            
                            <input id="m_inputmask_67" type="hidden" name="txtMFGQTY" style="background-color:grey;color:#f1f1f1;" class="form-control m-input" placeholder="">

                            
                            <select class="form-control m-select2" id="m_select2_3" name="txtSampleID">
                            <optgroup label="Sample">
                                <option selected value="">Select Sample</option>
                            </optgroup>
                            <?php 
                             $sampleArr = DB::table('samples')
                             ->where('is_deleted', 0)
                             ->where('status', 1)
                             ->orderBy('id', 'desc')
                             ->get();

                            

                             foreach ($sampleArr as $key => $row) { 
                                 ?>
                                 <optgroup label="{{$row->sample_code}}">

                                 <?php
                                $sampleArrITEM = DB::table('sample_items')->whereNull('chemist_id')->where('sid',$row->id)->get();
                                foreach ($sampleArrITEM as $key => $rowData) {
                                    ?>
                                    <option value="{{$rowData->id}}">{{$rowData->sid_partby_code}} ({{$rowData->item_name}}) </option>
                                    <?php
                                }

                                ?>
                                 </optgroup>
                                <?php
                             }

                            ?>     
                           
							</select>



                        </div>


                        <div class="col-lg-2">
                            <label>Formulated By:</label>

                            <select class="form-control" name="txtFormulatedBy">
                                <?php

                                if (Auth::user()->id != 1 || Auth::user()->id != 156) {

                                ?>
                                    <option selected value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>

                                    <?php

                                } else {
                                    $chemistArr = AyraHelp::getChemist();
                                    foreach ($chemistArr as $key => $rowData) {
                                        if ($bo_formuation->fm_addedby == $rowData->id) {
                                    ?>
                                            <option selected value="{{$rowData->id}}">{{$rowData->name}}</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                <?php
                                        }
                                    }
                                }

                                ?>
                            </select>


                        </div>

                    </div>
                    <br>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-2">
                            <label>pH Value:</label>
                            <input type="text" name="txt_ph_val" value="{{$bo_formuation->ph_val}}"  style="background-color:gray;color:#f1f1f1;" class="form-control m-input" placeholder="">


                        </div>
                        <div class="col-lg-2">
                            <label>Viscosity</label>
                            <input type="text" name="txt_vescocity_val" value="{{$bo_formuation->vescocity_val}}"   style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2" style="">
                            <label>Fragrance</label>
                            <input type="text" name="txt_fragrance_val" value="{{$bo_formuation->fragrance_val}}"  style="background-color:gray;color:#f1f1f1;"  class="form-control m-input" placeholder="">

                        </div>

                        <div class="col-lg-2">
                            <label>Color:</label>
                            <input type="text" name="txt_color_val" value="{{$bo_formuation->color_val}}"  style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2">
                            <label>Apperance:</label>
                            <input type="text" name="txt_apperance_val" value="{{$bo_formuation->apperance_val}}"  style="background-color:gray;color:#f1f1f1;"   class="form-control m-input" placeholder="">

                        </div>
                        <div class="col-lg-2">
                            <label>Date:</label>
                            <input type="text" name="formula_date" value="{{$bo_formuation->formula_date}}"  class="form-control" id="m_datepicker_1" readonly="" placeholder="Select date">

                        </div>

                    </div>
                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-primary" style="background-color:#f1f1f1;">
                        <thead>
                            <tr>
                                <th>*Ingredient Name</th>
                                <th>*Dose (%)</th>
                                <th>*Phase</th>
                                <th>Price(<span id="txtRSize"></span>/<span id="txtRPrice"></span>)</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="350px">
                                    <input type="hidden" id="txtRMID">
                                    <input type="hidden" id="txtRMTEXT">


                                    <div class="m-typeahead">
                                        <input class="form-control m-input kt_typeahead_4" id="kt_typeahead_4" type="text" dir="ltr" placeholder="name">
                                    </div>


                                </th>

                                <td width="100px">
                                    <input type="text" id="m_inputmask_6" name="txtDose" class="form-control m-input" placeholder="">
                                </td>
                                <td width="150px">

                                    <select class="form-control" name="txtPhase" id="txtPhase">
                                        <?php
                                        foreach (range('A', 'H') as $char) {

                                        ?>
                                            <option value="{{$char}}">{{$char}}</option>
                                        <?php
                                        }

                                        ?>

                                    </select>

                                </td>



                                <td>
                                    <input type="text" name="txtIPrice" class="form-control m-input" placeholder="">
                                </td>
                                <td width="180px">
                                    <input type="text" readonly id="txtRNDCost" name="txtRNDCost" class="form-control m-input" placeholder="">
                                </td>
                                <td>
                                    <a href="#" style="margin-top: 1px;" class="add_field_buttonFormualtion btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                                        <span>
                                            ADD

                                        </span>
                                    </a>

                                </td>
                            </tr>



                        </tbody>
                    </table>

                    <hr>
                    <table class="table table-bordered m-table m-table--border-primary m-table--head-bg-success" style="background-color:#f1f1f1;">
                        <thead>
                            <tr>
                                <th>Ingredient Name</th>
                                <th>Dose (%)</th>
                                <th>Phase</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="input_fields_wrapFormulation">
                            <!-- edit data  -->
                            <?php 
                           $perCTot=0;
                           $perPriceTot=0;
                            foreach ($bo_formuation_child as $key => $row) {
                                $perCTot=$perCTot+$row->dos_percentage;
                                $perPriceTot=$perPriceTot+$row->cost;
                                ?>
                                <tr>
                                <td width="350px">
                                    <input type="hidden" name="txtINGID[]" value="{{$row->ingredent_id}}">
                                    {{$row->ingredent_name}}
                                </td>

                                <td width="100px">
                                    <input type="text" name="txtDoseData[]"  value="{{$row->dos_percentage}}" class="form-control m-input ajdoseClassEdit" placeholder="">

                                </td>
                                <td width="100px">
                                    <select class="form-control ajRowPhaseSelectEdit" name="txtPhaseData[]">
                                        <option <?php echo $row->phase=="A" ? "selected":"" ?> value="A">A</option>
                                        <option <?php echo $row->phase=="B" ? "selected":"" ?> value="B">B</option>
                                        <option <?php echo $row->phase=="C" ? "selected":"" ?> value="C">C</option>
                                        <option <?php echo $row->phase=="D" ? "selected":"" ?> value="D">D</option>
                                        <option <?php echo $row->phase=="E" ? "selected":"" ?> value="E">E</option>
                                        <option <?php echo $row->phase=="F" ? "selected":"" ?> value="F">F</option>
                                        <option <?php echo $row->phase=="G" ? "selected":"" ?> value="G">G</option>
                                        <option <?php echo $row->phase=="H" ? "selected":"" ?> value="H">H</option>
                                    </select>
                                </td>



                                <td width="100px">
                                    <input type="text"  name="txtPriceData[]" value="{{$row->price}}" class="form-control m-input ajPriceClassEdit" placeholder="">
                                </td>
                                <td width="180px">
                                    <input type="text" readonly="" name="txtRNDCost[]" value="{{$row->cost}}" class="form-control m-input ajCostClass" placeholder="">
                                </td>
                                <td>

                                    <a href="#" style="margin-top: 1px;" class="remove_fieldForm btn btn-danger  m-btn 	m-btn m-btn--icon">
                                        <span>
                                            <i class="la la-trash"></i>

                                        </span>
                                    </a>

                                </td>
                            </tr>

                                <?php

                            }
                            ?>
                            

                            <!-- edit data  -->



                        </tbody>
                    </table>


                    <table class="table table-striped m-table" style="background-color:#f1f1f1;">

                        <tbody>
                            <tr>
                                <th width="250px">
                                </th>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalDose" id="txtTotalDose">
                                    <b>Total Dose:</b> <span id="txtPView">{{$perCTot}}(%)</span>
                                </td>
                                <td width="83px">
                                </td>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalPr" id="">

                                </td>
                                <td>
                                <td>
                                    <input type="hidden" value="0" name="txtTotalCostP" id="">
                                    <b>Cost Price:</b>₹. <span id="txtTotalCostP">{{$perPriceTot}}</span>
                                </td>
                                </td>

                                <td>

                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand ">
                        <thead>
                            <tr>
                                <th>Phase</th>
                                <th>Process</th>
                                <th>RPM</th>
                                <th>TEMP °C</th>
                                <th> Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="ajphaseProcessClass">
                           <?php 
                          

                            foreach ($bo_formuation_child_process as $key => $row) {
                                ?>
                                <tr>
                                <td>
                                    <select class="form-control" name="txtPhaseEntry[]" id="txtPhaseEntry">
                                    <option value="{{$row->phase_code}}">{{$row->phase_code}}</option>
                                    
                                    </select>
                                </td>
                                <td>
                                    <textarea class="form-control" name="txtProcessEntry[]" id="" cols="30" rows="1">{{$row->Process}}</textarea>
                                </td>
                                <td width="100px">
                                    <input type="text"  value="{{$row->rpm}}" name="txtRPMData[]" class="form-control m-input" placeholder="">
                                </td>

                                <td width="110px">
                                    <input type="text" value="{{$row->temp}}" name="txtTEMPData[]" class="form-control m-input" placeholder="">
                                </td>
                                
                                <td>
                                    <a href="#" style="margin-top: 1px;" class="remove_fieldFormPhaseProcess btn btn-danger  m-btn 	m-btn m-btn--icon">
                                        <span>
                                            <i class="la la-trash"></i>

                                        </span>
                                    </a>

                                </td>
                            </tr>

                                <?php
                            }
                           ?>

                        </tbody>
                    </table>

                    <div id="textdiv" class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary submitView">Submit</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


            </form>

            <!--end::Form-->





            <!-- save  -->

        </div>
    </div>

    <div class="m-portlet m-portlet--mobile" style="display:none">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Ingredients Formulations List
                    </h3>
                    <!-- <table style="margin-left:30px;">
					</table> -->
                </div>
            </div>

        </div>
        <div class="m-portlet__body">

            <!--begin: Search Form -->

           



            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_RNDFormulation" style="display: ;">
                <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Formula Name</th>
                        <th>FM CODE</th>
                        <th>Created at</th>
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











