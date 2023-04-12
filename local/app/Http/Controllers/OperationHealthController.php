<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OperationHealth;
use App\QCFORM;
use App\HPlanDay;
use App\HPlanDay2;
use App\HPlanDay4;
use App\OPHAchieved;


use Theme;
use App\Helpers\AyraHelp;
use Auth;

class OperationHealthController extends Controller
{

    public function savePlanAchieveData(Request $request)
    {

        $request->plan_id;

        $data_Plan_arr = AyraHelp::getPlanDay4DayFormID($request->formID);


        $flight = OPHAchieved::updateOrCreate(
            ['plan_id' => $request->plan_id, 'form_id' => $request->formID, 'operation_id' => $request->operation_id],
            [$request->input_db_name => $request->inputVal, 'plan_type' => $request->operation_id, 'plan_qty' => $data_Plan_arr->plan_qty, 'created_by' => Auth::user()->id]
        );
        echo "OK";
    }

    public function addPlanAchieve(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.plan_achiveEntry', $data)->render();
    }
    public function planViewPrint(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.plan_viewPrint', $data)->render();
    }
    public function getOHPlanList(Request $request)
    {
        $OPTH_arrs = HPlanDay::get();
        $data_arr_1 = array();
        foreach ($OPTH_arrs as $OPTH_key => $OPTH_arr) {
            // $qc_data=AyraHelp::getQCFormDate($OPTH_arr->form_id);
            // $qc_dataOPH=AyraHelp::getOperationalHealthBYid($OPTH_arr->operation_id);           
            $dataAll = AyraHelp::getPlanDay4Day($OPTH_arr->id);
            //echo "<pre>";
            $avchiQTY = optional($dataAll)->achive_qty;

            $createdby = AyraHelp::getUser($OPTH_arr->created_by)->name;
            $pt = $OPTH_arr->plan_type == 1 ? 'Production' : "Packaging";
            $data_arr_1[] = array(
                'RecordID' => $OPTH_arr->id,
                'planid' => $OPTH_arr->id,
                'plan_date' => $OPTH_arr->plan_date,
                'plan_type' => $pt,
                'tot_man_hours' => 22,
                'shift_hour' => $OPTH_arr->shift_work_hour,
                'manpower_expected' => $OPTH_arr->manpower_expected,
                'status' => $OPTH_arr->h_alloted,
                'created_by' => $createdby,
                'manhours' => $OPTH_arr->manpower_expected * $OPTH_arr->shift_work_hour,
                'avchiQTY' => $avchiQTY

            );
        }


        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'planid'     => true,
            'plan_date'     => true,
            'plan_type'     => true,
            'tot_man_hours'     => true,
            'shift_hour'     => true,
            'manpower_expected'     => true,
            'status'     => true,
            'created_by'     => true,
            'manhours'     => true,
            'avchiQTY'     => true,

        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    public function getOperationHealthPlanList(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.Operation_Plan_list', $data)->render();
    }
    public function getPlanedOrderDay4Data(Request $request)
    {

        $OPTH_arrs = HPlanDay4::where('plan_id', $request->txtPlanID)->where('status', 0)->get();
        $data_arr_1 = array();
        foreach ($OPTH_arrs as $OPTH_key => $OPTH_arr) {
            $qc_data = AyraHelp::getQCFormDate($OPTH_arr->form_id);
            $qc_dataOPH = AyraHelp::getOperationalHealthBYid($OPTH_arr->operation_id);

            $data_arr_1[] = array(
                'RecordID' => $OPTH_arr->id,
                'order_id' => $qc_data->order_id . "/" . $qc_data->subOrder,
                'form_id' => $OPTH_arr->form_id,
                'bran_name' => $qc_data->brand_name,
                'operationName' => $qc_dataOPH->operation_name . "-" . $qc_dataOPH->operation_product,
                'manp_alloted' => $OPTH_arr->mp_alloted,
                'hour_alloted' => $OPTH_arr->h_alloted,
                'manh_alloted' => $OPTH_arr->man_hr_req,
                'achiv_qty' => $OPTH_arr->achive_qty,

            );
        }


        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'order_id'     => true,
            'form_id'     => true,
            'bran_name'     => true,
            'operationName'     => true,
            'manp_alloted'     => true,
            'hour_alloted'     => true,
            'manh_alloted'     => true,
            'achiv_qty' => true,
        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    public function save_OPHPlan_Day4(Request $request)
    {

        $res = HPlanDay4::where('form_id', $request->form_id)->where('plan_id', $request->plan_id)->where('operation_id', $request->operation_id)->delete();
        $objOPH = new HPlanDay4;
        $objOPH->form_id = $request->form_id;
        $objOPH->plan_id = $request->plan_id;
        $objOPH->operation_id = $request->operation_id;
        $objOPH->plan_qty = $request->QTYREQ;
        $objOPH->mpr = $request->MHR;
        $objOPH->mp_alloted = $request->manHrsAlloted;
        $objOPH->h_alloted = $request->HrsAlloted;
        $objOPH->achive_qty = $request->ACHIVQTY;
        $objOPH->man_hr_req = $request->MANHRSREQ;
        $objOPH->save();
        $resp = array(
            'status' => 1,
            'save_id' => $objOPH->id

        );
        return response()->json($resp);
    }
    public function getOperatonsPlanOrderDetails(Request $request)
    {
        $form_id = $request->form_id;
        $plan_id = $request->plan_id;
        $data = HPlanDay2::where('plan_id', $plan_id)->where('form_id', $form_id)->first();
        return response()->json($data);
    }
    //==========================================
    public function getOperatonsInfo(Request $request)
    {
        $operionIDVal = $request->operionIDVal;
        $hOperation_arr = OperationHealth::where('id', $operionIDVal)->first();
        return response()->json($hOperation_arr);
    }
    //==========================================

    public function savePlanDay3QTY(Request $request)
    {

        $qc_data = AyraHelp::getQCFormDate($request->recordID);
        $HPLanObj = new HPlanDay2;
        $HPLanObj->form_id = $request->recordID;
        $HPLanObj->total_qty = $qc_data->item_qty;
        $HPLanObj->plan_qty = $request->plan_qty;
        $HPLanObj->plan_id = $request->txtPlanID;
        $HPLanObj->created_by = Auth::user()->id;
        $HPLanObj->save();
        $resp = array(
            'status' => 1

        );
        return response()->json($resp);
    }
    public function save_plan_wizard(Request $request)
    {
        //  print_r($request->all());
        $plan_date = $request->txtSelectedDate;
        $plan_date = date("Y-m-d", strtotime($plan_date));
        HPlanDay::updateOrCreate(
            [

                'id' => $request->txtPlanID,


            ],
            [
                'plan_date' => $plan_date,
                'plan_type' => $request->plan_type,
                'manpower_expected' => $request->txtManPowerExpected,
                'shift_work_hour' => $request->txtworkShiftHour,
                'created_by' => Auth::user()->id,
            ]
        );
        return 1;
    }

    public function getOperationOrderPlan()
    {
        $OPTH_arrs = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $data_arr_1 = array();
        foreach ($OPTH_arrs as $OPTH_key => $OPTH_arr) {

            $sales_arr = AyraHelp::getUser($OPTH_arr->created_by);
            $update_statge_on = date("d,M Y", strtotime($OPTH_arr->created_at));

            $qc_data_arr = AyraHelp::getCurrentStageByForMID($OPTH_arr->form_id);
            $OD_Selected_arr = HPlanDay2::where('form_id', $OPTH_arr->form_id)->get();

            if (isset($qc_data_arr->order_statge_id)) {
                $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
                $step_code = optional($statge_arr)->step_code;

                if ($step_code == 'PRODUCTION' || $step_code == 'PACKING_ORDER') {
                    if (isset($qc_data_arr->order_statge_id)) {
                        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
                        $Spname = optional($statge_arr)->process_name;
                        $Spname = str_replace('/', '-', $Spname);
                    } else {
                        $Spname = '';
                    }

                    $data_arr_1[] = array(
                        'RecordID' => $OPTH_arr->form_id,
                        'order_id' => $OPTH_arr->order_id . "/" . $OPTH_arr->subOrder,
                        'form_id' => $OPTH_arr->form_id,
                        'bran_name' => $OPTH_arr->brand_name,
                        'item_name' => $OPTH_arr->item_name,
                        'sales_person' => $sales_arr->name,
                        'order_date' => $update_statge_on,
                        'curr_stage' => $Spname,
                        'order_selected_arr' => $OD_Selected_arr,
                        'order_qty' => $OPTH_arr->item_qty,

                    );
                }
            }
        }

        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'order_id'     => true,
            'form_id'     => true,
            'bran_name'     => true,
            'item_name'     => true,
            'sales_person'     => true,
            'order_date'     => true,
            'curr_stage'     => true,
            'order_selected_arr' => true,
            'order_qty'     => true,
        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //======================================

    public function getPlanedOrderDataDay2(Request $request)
    {

        $planday_arr = HPlanDay2::where('plan_id', $request->txtPlanID)->get();
        //planday_arr
        $dataOP = array();
        foreach ($planday_arr as $key => $value) {
            $qc_data = AyraHelp::getQCFormDate($value->form_id);
            $dataOP[] = array(
                'form_id' => $value->form_id,
                'order_id' => $qc_data->order_id . "/" . $qc_data->subOrder . "[" . $qc_data->brand_name . ']',

            );
        }
        $hOperation_arr = OperationHealth::get();


        $data_arr_1 = array();
        foreach ($planday_arr as $key => $value) {

            $data_arr_1[] = array(
                'RecordID' => $value->id,
                'form_id' => $value->form_id,
                'order_id' => $qc_data->order_id . "/" . $qc_data->subOrder,
                'req_qty' => $qc_data->item_qty,
                'manhour_req' => $qc_data->item_qty,
                'alloted_hours' => $qc_data->item_qty,
                'manhour_alloted' => $qc_data->item_qty,
                'plan_qty' => $value->plan_qty,
                'h_operation' => $hOperation_arr,
                'order_arr' => $dataOP,

            );
        }

        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'form_id'     => true,
            'order_id'     => true,
            'req_qty'     => true,
            'manhour_req'     => true,
            'alloted_hours'     => true,
            'manhour_alloted'     => true,
            'plan_qty'     => true,
            'h_operation'     => true,
            'order_arr'     => true,

        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    //======================================
    //orderPlanList
    public function orderPlanList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == '147' || Auth::user()->id == '85' ||  Auth::user()->id == '88' ||  Auth::user()->id == '89' || Auth::user()->id == '196' || Auth::user()->id==185) {
      return $theme->scope('orders.v1.orderListAdminViewPlanOrder', $data)->render();
    }
    // if ($user_role == 'Staff') {
    //   return $theme->scope('orders.v1.orderListStaffView', $data)->render();
    // }
    // return $theme->scope('orders.v1.orderList', $data)->render();
  }

    //orderPlanList


    public function operationPlan(Request $request)
    {

        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.planWizard', $data)->render();
    }
    public function index()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.index', $data)->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'step_code' => ''
        ];
        return $theme->scope('operation.create', $data)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->all());
        $ctime = $request->txtManualTime + $request->txtMachineTime;
        $a = (60 * 60) / $ctime;

        $b = $request->txtRework + $request->txtRejection;
        $c = $a - (($a) * ($b / 100));
        $ophval = $c;

        $opHealthObj = new OperationHealth;
        $opHealthObj->operation_name = $request->txtOperationName;
        $opHealthObj->operation_product = $request->txtproductName;

        $opHealthObj->operation_category = $request->txtOPTCat;
        $opHealthObj->operation_type = $request->txtOPType;
        // $opHealthObj->operation_disc=$request->txtOperationName;
        $opHealthObj->operation_man_power = $request->txtManPower;
        $opHealthObj->operation_manual_time = $request->txtManualTime;
        $opHealthObj->operation_machine_time = $request->txtMachineTime;
        $opHealthObj->operation_cycle_time = $ctime;
        $opHealthObj->operation_output = $request->txtoutputUnit;
        //$opHealthObj->operation_unit=$request->txtOperationName;
        $opHealthObj->operation_rework = $request->txtRework;
        $opHealthObj->rejection = $request->txtRejection;
        $opHealthObj->oph = $ophval;
        $opHealthObj->created_by = Auth::user()->id;
        $opHealthObj->save();
        $resp = array(
            'status' => 1

        );
        return response()->json($resp);
    }
    public function getOperationHealthData()
    {
        $OPTH_arrs = OperationHealth::get();
        $data_arr_1 = array();
        foreach ($OPTH_arrs as $OPTH_key => $OPTH_arr) {


            $ophUnit = $OPTH_arr->operation_unit == 1 ? 'KG' : 'PCS';

            $data_arr_1[] = array(
                'RecordID' => $OPTH_arr->id,
                'operation_name' => $OPTH_arr->operation_name,
                'operation_product' => $OPTH_arr->operation_product,
                'operation_category' => $OPTH_arr->operation_category,
                'operation_type' => $OPTH_arr->operation_type,
                'operation_disc' => $OPTH_arr->operation_disc,
                'operation_man_power' => $OPTH_arr->operation_man_power,
                'operation_manual_time' => $OPTH_arr->operation_manual_time,
                'operation_machine_time' => ($OPTH_arr->operation_machine_time),
                'operation_cycle_time' => $OPTH_arr->operation_cycle_time,
                'operation_output' => $OPTH_arr->operation_output,
                'operation_unit' => $OPTH_arr->operation_unit . " " . $ophUnit,
                'operation_rework' => $OPTH_arr->operation_rework,
                'operation_rejection' => $OPTH_arr->rejection,
                'ophVal' => $OPTH_arr->oph,
                'created_on' => $OPTH_arr->created_on,
                'created_by' => $OPTH_arr->created_by,

            );
        }

        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'operation_name'     => true,
            'operation_product'     => true,
            'operation_category'     => true,
            'operation_type'     => true,
            'operation_disc'     => true,
            'operation_man_power'     => true,
            'operation_manual_time'     => true,
            'operation_machine_time'     => true,
            'operation_cycle_time'     => true,
            'operation_output'     => true,
            'operation_unit'     => true,
            'operation_rework'     => true,
            'operation_rejection'     => true,
            'ophVal'     => true,
            'created_on'     => true,
            'created_by'     => true,

        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
