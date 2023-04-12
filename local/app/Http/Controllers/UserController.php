<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\RowClient;
use App\ContactClient;
use App\UserAccess;
use App\Employee;
use App\Sample;
use App\KPIData;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\KPIReport;
use App\MHP;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Mail;
use Theme;
use Khill\Lavacharts\Lavacharts;
use App\Helpers\AyraHelp;
use Pusher;
use App\OTP;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'isAdmin'])->except(['samples']);
  }


  //oncreditList
  public function oncreditList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('orders.v1.oncreditRequestData', $data)->render();
  }
  //oncreditList


  //incentiveApplied
  public function incentiveApplied(Request $request)
  {


    DB::table('incentive_applied')->insert(
      [
        'user_id' => $request->usrid,
        'incetive_id' => $request->incentiveType,
        'active' => 1,

      ]
    );

    $resp = array(
      'status' => 1,
      'data' => ''

    );

    return response()->json($resp);
  }
  //incentiveApplied

  //viewIncentiveEligibility
  public function viewIncentiveEligibility($uid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.incentiveEligibilityDetails', $data)->render();
    } else {
      abort('401');
    }
  }
  //viewIncentiveEligibility
  //setSaveIncentiveSlab
  public function setSaveIncentiveSlab(Request $request)
  {

    DB::table('incentive_payout_percentage')->insert(
      [
        'incentive_type_id' => $request->inc_slab_inc_type,
        'target_start' => $request->inc_slab_rangeFrom,
        'target_stop' => $request->inc_slab_rangeTO,
        'payout_percentage' => $request->inc_slab_Percentage,
        'last_updated_by' => Auth::user()->id,
        'notes' => $request->inc_slab_notes
      ]
    );

    $resp = array(
      'status' => 0,
      'data' => ''

    );

    return response()->json($resp);
  }

  //setSaveIncentiveSlab
  //setSaveIncentive
  public function setSaveIncentive(Request $request)
  {

    DB::table('incentive_type')->insert(
      [
        'incentive_name' => $request->inc_name,
        'is_active' => $request->inc_is_active,
        'circle_type' => $request->inc_circle_period,
        'created_by' => Auth::user()->id,
        'created_on' => date('Y-m-d')
      ]
    );

    $resp = array(
      'status' => 0,
      'data' => ''

    );

    return response()->json($resp);
  }
  //setSaveIncentive
  //getUserDataByID
  public function getUserDataByID(Request $request)
  {
    $data = AyraHelp::getUser($request->userid);

    $emp_arr = AyraHelp::getProfilePIC($request->userid);
    if (!isset($emp_arr->photo)) {
      $img_photo = asset('local/public/img/avatar.jpg');
    } else {
      $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
    }

    $usrData = array(
      'user_name' => $data->name,
      'user_phone' => $data->phone,
      'user_photo' => $img_photo

    );
    return response()->json($usrData);
  }
  //getUserDataByID

  //getHighcartLeadClaimThisMonthbyUser
  public function getHighcartLeadClaimThisMonthbyUser(Request $request)
  {
    $monthlyVal1 = array();
    $monthlyVal2 = array();
    $monthName = array();
    $dateActiveA = date('Y') . "-" . date('m');
    for ($x = 1; $x <= $maxDays = date('t'); $x++) {
      $dateActive = $dateActiveA . "-" . $x;
      $monthlyVal1[] = AyraHelp::getLeadClaimByDayUser($dateActive, 134);
      $monthlyVal2[] = AyraHelp::getLeadClaimByDayUser($dateActive, 141);

      // $monthlyVal1[]=53;
      // $monthlyVal2[]=333;

      $monthName[] = $x;
    }
    $resp = array(
      'monthlyValue1' => $monthlyVal1,
      'monthlyValue2' => $monthlyVal2,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartLeadNEWVerifedClaimThisMonthbyUser
  public function getHighcartLeadNEWVerifedClaimThisMonthbyUser(Request $request)
  {
    $monthlyVal1 = array();
    $monthlyVal2 = array();
    $monthName = array();
    $dateActiveA = date('Y') . "-" . date('m');
    for ($x = 1; $x <= $maxDays = date('t'); $x++) {
      $dateActive = $dateActiveA . "-" . $x;
      $monthlyVal1[] = AyraHelp::getLeadNEWByDay($dateActive);
      $monthlyVal2[] = AyraHelp::getLeadVerifiedByDay($dateActive);
      $monthlyVal3[] = AyraHelp::getLeadClaimByNEWDay($dateActive);
      $monthlyVal4[] = AyraHelp::getLeadDuplicateDay($dateActive);
      $monthlyVal5[] = AyraHelp::getLeadPhonePickupDay($dateActive);

      // $monthlyVal1[]=53;
      // $monthlyVal2[]=333;

      $monthName[] = $x;
    }
    $resp = array(
      'monthlyValue1NEW' => $monthlyVal1,
      'monthlyValue2Verified' => $monthlyVal2,
      'monthlyValue2Claim' => $monthlyVal3,
      'monthlyValue2Duplocate' => $monthlyVal4,
      'monthlyValue2PhonePickup' => $monthlyVal5,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }
  //getHighcartLeadNEWVerifedClaimThisMonthbyUser

  //getHighcartLeadClaimThisMonthbyUser

  //getHighcartLeadVerifedThisMonthbyUser
  public function getHighcartLeadVerifedThisMonthbyUser(Request $request)
  {
    $monthlyVal1 = array();
    $monthlyVal2 = array();
    $monthName = array();
    $dateActiveA = date('Y') . "-" . date('m');
    for ($x = 1; $x <= $maxDays = date('t'); $x++) {
      $dateActive = $dateActiveA . "-" . $x;
      $monthlyVal1[] = AyraHelp::getLeadVerifedByDayUser($dateActive, 134);
      $monthlyVal2[] = AyraHelp::getLeadVerifedByDayUser($dateActive, 141);

      // $monthlyVal1[]=53;
      // $monthlyVal2[]=333;

      $monthName[] = $x;
    }
    $resp = array(
      'monthlyValue1' => $monthlyVal1,
      'monthlyValue2' => $monthlyVal2,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartLeadVerifedThisMonthbyUser


  //getHighcartLeadVerifedThisMonth
  public function getHighcartLeadVerifedThisMonth(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();
    $dateActiveA = date('Y') . "-" . date('m');
    for ($x = 1; $x <= $maxDays = date('t'); $x++) {
      $dateActive = $dateActiveA . "-" . $x;
      $monthlyVal[] = AyraHelp::getLeadVerifedByDay($dateActive);

      $monthName[] = $x;
    }
    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartLeadVerifedThisMonth

  //getHighcartLeadClaimThisMonth
  public function getHighcartLeadClaimThisMonth(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();
    $dateActiveA = date('Y') . "-" . date('m');
    for ($x = 1; $x <= $maxDays = date('t'); $x++) {
      $dateActive = $dateActiveA . "-" . $x;
      $monthlyVal[] = AyraHelp::getLeadClaimByDay($dateActive);

      $monthName[] = $x;
    }
    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }


  //getHighcartLeadClaimThisMonth 
  //getHighcartRecievedMissedMonthwise
  public function getHighcartRecievedMissedMonthwise(Request $request)
  {
    $monthlyVal = array();
    $monthMissed = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getRecievedCallDataApi($x, $year_digit);
      $data_outputMissed = AyraHelp::getMissedCallDataApi($x, $year_digit);

      $monthlyVal[] = (float)$data_output;
      $monthMissed[] = ((float)$data_outputMissed);

      $month = $x;
      $month = substr($month, -2, 2);
      $mN = date('M-Y', strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }


    for ($x = 1; $x <= date('m'); $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getRecievedCallDataApi($x, $year_digit);
      $data_outputMissed = AyraHelp::getMissedCallDataApi($x, $year_digit);

      $monthlyVal[] = (float)$data_output;
      $monthMissed[] = ((float)$data_outputMissed);

      $month = $x;
      $month = substr($month, -2, 2);
      $mN = date('M-Y', strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }


    $resp = array(
      'monthlyValue' => $monthlyVal,
      'monthlyMissed' => $monthMissed,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartRecievedMissedMonthwise
  //getHighcartFreshLeadRemainigValueMonthly
  public function getHighcartFreshLeadRemainigValueMonthly(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getFreshLeadValueBySlabFilterRemain($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;
      $month = substr($month, -2, 2);
      $mN = date('M-Y', strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }

    for ($x = 1; $x <= date('m'); $x++) {



      $year_digit = "2022";

      $data_output = AyraHelp::getFreshLeadValueBySlabFilterRemain($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;
      $month = substr($month, -2, 2);
      $mN = date('M-Y', strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartFreshLeadRemainigValueMonthly

  //getHighcartIncentiveValueMonthlybyUser
  public function getHighcartIncentiveValueMonthlybyUser(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m')+1; $x <= 12; $x++) {

      $data_output = AyraHelp::getIncentiveValueBySlabFilterByUser($x);

      $monthlyVal[] = (float)$data_output;

      $month = $x;
      if ($x > date('m')) {
        $year_digit = "2022"; 
      } else {
        $year_digit = "2023";
      }
      $month = substr($month, -2, 2);
      //$mN = date('M', strtotime(date('Y-' . $month . '-d')));
      $mN = date('M' . $year_digit, strtotime(date('Y-' . $month . '-d')));

      $monthName[] = $mN;
    }


    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }
  //getHighcartIncentiveValueMonthlybyUser

  //getHighcartPaymentRecievedMonthlybyUser
  public function getHighcartPaymentRecievedMonthlybyUser(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x =  date('m') + 1; $x <= 12; $x++) {

      $data_output = AyraHelp::getOrderValuePaymentRecFilterByUser($x);

      $monthlyVal[] = (float)$data_output;

      $month = $x;

      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $month = substr($month, -2, 2);
      $mN = date('M' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
    }


    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartPaymentRecievedMonthlybyUser

  //getHighcartOrderPunchedMonthly
  public function getHighcartOrderPunchedMonthly(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getOrderValuePuchRecFilter($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
       $monthName[] = $mN;
      //$monthName[] = $x."-".$year_digit;
      
    }


    for ($x = 1; $x <= date('m'); $x++) {
      $year_digit = "2023";
      $data_output = AyraHelp::getOrderValuePuchRecFilter($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
       $monthName[] = $mN;
      //$monthName[] = $x."-".$year_digit;
    }



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartOrderPunchedMonthly
//getHighcartPaymentRecievedMonthly_PLORDER
public function getHighcartPaymentRecievedMonthly_PLORDER(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getOrderValuePaymentRecFilterPL($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
     //$monthName[] = $x."-".$year_digit;
    }


    for ($x = 1; $x <= date('m'); $x++) {
      $year_digit = "2023";
      $data_output = AyraHelp::getOrderValuePaymentRecFilterPL($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
      //$monthName[] = $x."-".$year_digit;
    }



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

//getHighcartPaymentRecievedMonthly_PLORDER

  //getHighcartPaymentRecievedMonthly_BULKORDER
  public function getHighcartPaymentRecievedMonthly_BULKORDER(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getOrderValuePaymentRecFilterBULK($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
     //$monthName[] = $x."-".$year_digit;
    }


    for ($x = 1; $x <= date('m'); $x++) {
      $year_digit = "2023";
      $data_output = AyraHelp::getOrderValuePaymentRecFilterBULK($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
      //$monthName[] = $x."-".$year_digit;
    }



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartPaymentRecievedMonthly_BULKORDER

  //getHighcartPaymentRecievedMonthly
  public function getHighcartPaymentRecievedMonthly(Request $request)
  {
    $monthlyVal = array();
    $monthName = array();

    for ($x = date('m') + 1; $x <= 12; $x++) {


      if ($x > date('m')) {
        $year_digit = "2022";
      } else {
        $year_digit = "2023";
      }

      $data_output = AyraHelp::getOrderValuePaymentRecFilter($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
     //$monthName[] = $x."-".$year_digit;
    }


    for ($x = 1; $x <= date('m'); $x++) {
      $year_digit = "2023";
      $data_output = AyraHelp::getOrderValuePaymentRecFilter($x, $year_digit);

      $monthlyVal[] = (float)$data_output;

      $month = $x;


      $month = substr($month, -2, 2);
      $mN = date('M-' . $year_digit, strtotime(date('Y-' . $month . '-d')));
      $monthName[] = $mN;
      //$monthName[] = $x."-".$year_digit;
    }



    $resp = array(
      'monthlyValue' => $monthlyVal,
      'MonthName' => $monthName,

    );
    return response()->json($resp);
  }

  //getHighcartLeadClaimBySalesTeam
  public function getHighcartLeadClaimBySalesTeam(Request $request)
  {
    $daysCount = date('t');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $pName = array();
    $newDataSort = array();
    $pOrderValue = array();
    $pPaymentRecieved = array();

    // if ($user_role == 'Admin' || $user_role == 'SalesHead') {

    // } else {
    //   $uid = Auth::user()->id;
    //   $pName[] = Auth::user()->name;
    //   // $pLeadClaimValue[] = AyraHelp::getTotalLeadClaimofCurrentMonth($uid, $daysCount);
    // }

    $usersArr = AyraHelp::getSalesAgentAdmin();
    foreach ($usersArr as $key => $rowData) {
      $pName[] = $rowData->name;
      //$pLeadClaimValue[] = AyraHelp::getTotalLeadClaimofCurrentMonth($rowData->id, $daysCount);
      $newDataSort[] = array(
        'name' => $rowData->name,
        'y' => AyraHelp::getTotalLeadClaimofCurrentMonth($rowData->id, $daysCount),

      );
    }



    $persons = $pName;
    // $OrderValue = $pLeadClaimValue;

    $resp = array(
      'persons' => $persons,
      'pLeadClaimValue' => $newDataSort,


    );

    return response()->json($resp);
  }

  //getHighcartLeadClaimBySalesTeam

  //getHighcartPaymentRecievedMonthly
  public function getHighcartSampleAssigned(Request $request)
  {
    $daysCount = $request->daysCount;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $pName = array();
    $pOrderValue = array();
    $pPaymentRecieved = array();

    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $usersArr = AyraHelp::getChemist();


      foreach ($usersArr as $key => $rowData) {
        $pName[] = $rowData->name;
        $pOrderValue[] = 4;
        $pPaymentRecieved[] = AyraHelp::getTotalAssinedSampleByUserID($rowData->id, $daysCount);
      }
    }
    // $pName[] = 'Anita Hari Das';
    // $pOrderValue[] = 4;
    // $pPaymentRecieved[] = AyraHelp::getTotalAssinedSampleByUserID(126, $daysCount);

    // $pName[] = 'Amit Singh';
    // $pOrderValue[] = 4;
    // $pPaymentRecieved[] = AyraHelp::getTotalAssinedSampleByUserID(124, $daysCount);


    $persons = $pName;
    $OrderValue = $pOrderValue;
    $paymentRecieved = $pPaymentRecieved;
    $resp = array(
      'persons' => $persons,
      'OrderValue' => $OrderValue,
      'paymentRecieved' => $paymentRecieved,

    );

    return response()->json($resp);
  }

  //getHighcartLast30daysTotalSamplesAdded
  public function getHighcartLast30daysTotalSamplesAdded(Request $request)
  {
    $daysCount = $request->daysCount;

    for ($i = 0; $i <= 30; $i++) {
      $todayD = 'today -' . $i . 'days';
      $date = date('Y-m-d', strtotime($todayD));
      $dataV = date('j-F-y', strtotime($todayD));
      $pName[] = $dataV;

      $samples = Sample::whereDate('created_at', '=', date($date))->where('is_deleted', 0)->count();

      $pOrderValue[] = intVal($samples);
      $pPaymentRecieved[] = intVal($samples);
    }
    $persons = $pName;
    $OrderValue = $pOrderValue;
    $paymentRecieved = $pPaymentRecieved;

    $resp = array(
      'persons' => $persons,
      'OrderValue' => $OrderValue,
      'paymentRecieved' => $paymentRecieved,

    );

    return response()->json($resp);
  }
  //getHighcartLast30daysTotalSamplesAdded

  //getHighcartLast30daysTotalRecivedMissedCall
  public function getHighcartLast30daysTotalRecivedMissedCall(Request $request)
  {
    AyraHelp::getcurrentMonthRecivedMissedCallData();

    $daysCount = $request->daysCount;


    // for ($i=1; $i <= 30; $i++) { 
    //   $todayD='today -'.$i.'days';      
    //   $dataV= date('j-F-y', strtotime($todayD));
    //   $pName[] = $dataV;
    //   $agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    //   $pOrderValue[] = intVal($agentArr->recieved_call);
    //   $pPaymentRecieved[] = intVal($agentArr->missed_call);


    // }
    $agentArr = DB::table('graph_l30daysmissed_recieved')->orderBy('id', 'desc')->get();
    foreach ($agentArr as $key => $rowData) {

      $pName[] = date('j-F-y', strtotime($rowData->day_date));
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
      $pOrderValue[] = intVal($rowData->recieved_call);
      $pPaymentRecieved[] = intVal($rowData->missed_call);
    }


    $persons = $pName;
    $OrderValue = $pOrderValue;
    $paymentRecieved = $pPaymentRecieved;

    $resp = array(
      'persons' => $persons,
      'OrderValue' => $OrderValue,
      'paymentRecieved' => $paymentRecieved,

    );

    return response()->json($resp);
  }
  //getHighcartLast30daysTotalRecivedMissedCall

  //getHighcartLast7daysCall
  public function getHighcartLast7daysCall(Request $request)
  {
    $daysCount = $request->daysCount;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $pName = array();
    $pOrderValue = array();
    $pPaymentRecieved = array();

    $usersArr = AyraHelp::getSalesAgentAdmin();
    foreach ($usersArr as $key => $rowData) {
      if ($rowData->id == 108 || $rowData->id == 156 || $rowData->id == 171) {
      } else {
        $pName[] = $rowData->name;
        $pOrderValue[] = AyraHelp::getHighTotal7DaysCall($rowData->id, $daysCount);
        $pPaymentRecieved[] = AyraHelp::getHighTotal7DaysCall_average_call($rowData->id, $daysCount);
      }
    }




    $persons = $pName;
    $OrderValue = $pOrderValue;
    $paymentRecieved = $pPaymentRecieved;
    $resp = array(
      'persons' => $persons,
      'OrderValue' => $OrderValue,
      'paymentRecieved' => $paymentRecieved,

    );

    return response()->json($resp);
  }

  //getHighcartLast7daysCall

  // highchart
  public function getHighcartOrderValuePaymentRecieved(Request $request)
  {
    $daysCount = $request->daysCount;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $pName = array();
    $pOrderValue = array();
    $pPaymentRecieved = array();

    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $usersArr = AyraHelp::getSalesAgentAdminNotDeleted();
      foreach ($usersArr as $key => $rowData) {
        $pName[] = $rowData->name;
        $pOrderValue[] = AyraHelp::getTotalOrderValueOfDays($rowData->id, $daysCount);
        $pPaymentRecieved[] = AyraHelp::getTotalOrderValueRecievedOfDays($rowData->id, $daysCount);
      }
    } else {
      $uid = Auth::user()->id;
      $pName[] = Auth::user()->name;
      $pOrderValue[] = AyraHelp::getTotalOrderValueOfDays($uid, $daysCount);
      $pPaymentRecieved[] = AyraHelp::getTotalOrderValueRecievedOfDays($uid, $daysCount);
    }




    $persons = $pName;
    $OrderValue = $pOrderValue;
    $paymentRecieved = $pPaymentRecieved;
    $resp = array(
      'persons' => $persons,
      'OrderValue' => $OrderValue,
      'paymentRecieved' => $paymentRecieved,

    );

    return response()->json($resp);
  }
  // highchart

  public function getChartReport()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.highchart_graph_1', $data)->render();
    } else {
      abort('401');
    }
  }

  //ActivatUserMAC
  public function ActivatUserMAC(Request $request)
  {
    $otp = AyraHelp::getOTP();
   $user_id=$request->rowid;
   $myMacAddress = AyraHelp::getMyMACAddress();
   $myIP = $_SERVER['REMOTE_ADDR'];
    
    $forToday=$request->forToday;
    if($forToday==1){ //permanat 
      

      $users_otpFirst = DB::table('users_otp')
      ->where('user_id', $user_id)
      ->orderBy('id', 'DESC')->first();
    
      $affected = DB::table('users')
      ->where('id',  $request->rowid)
      ->update(['mac_address' =>  @$users_otpFirst->mac_address]);


                 
              
                

    }else{

      $users_otpFirst = DB::table('users_otp')
      ->where('user_id', $user_id)
      ->orderBy('id', 'DESC')->first();
     
      $affected = DB::table('users_otp')
              ->where('id', $users_otpFirst->id)
              ->update(['ip_verify' => 1]);
 

      
    

    }
  
   
     $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }


  //ActivatUserMAC


  //deleteUserSoft
  public function deleteUserSoft(Request $request)
  {
$i=0;
    $clientCount = DB::table('clients')
            ->where('added_by', Auth::user()->id)
            ->count();
            if($clientCount>0){
              $i++;
            }
    $QcCount = DB::table('qc_forms')
    ->where('created_by', Auth::user()->id)
    ->count();
    if($QcCount>0){
      $i++;
    }
    if($i!=2){
      DB::table('users')
      ->updateOrInsert(
        ['id' => $request->rowid],
        [
          'is_deleted' => 1       
          
        ]
      );

    $resp = array(
      'status' => 1,
     

    );
    }else{
      
    $resp = array(
      'status' => 0,
     

    );

    }


 

    return response()->json($resp);
  }

  //deleteUserSoft

  public function saveOtherSampleName(Request $request)
  {

    DB::table('sample_itemname')
      ->updateOrInsert(
        ['item_name' => $request->itemName, 'cat_type' =>  $request->catType],
        [
          'item_name' => ucwords($request->itemName),
          'cat_type' => $request->catType,
          'created_by' => Auth::user()->id,
          'created_on' => date('Y-m-d H:i:s'),
        ]
      );

    $resp = array(
      'status' => 0,
      'item_name' => ucwords($request->itemName),
      'cat_type' => $request->catType,

    );

    return response()->json($resp);
  }
  public function getAllSalseMemberLeadTrackDays()
  {

    $usersCallArr = DB::table('graph_lead_trackdays')->orderBy('assined', 'desc')->get();
    $data = array();
    foreach ($usersCallArr as $key => $rowData) {
      $narr = explode(" ", $rowData->name);
      $data[] = array(
        'name' => $narr[0],
        'assined' => $rowData->assined,
        'qualified' => $rowData->qualified,
        'sampling' => $rowData->sampling,
      );
    }
    return  json_encode($data);
  }
  public function getDatewiseLeadAssign()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 134 ||  Auth::user()->id == 141 || $user_role == 'SalesHead' || Auth::user()->id == 217 || Auth::user()->id == 202  || Auth::user()->id == 221  ) {
      return $theme->scope('users.getDatewiseLeadAssign', $data)->render();
    } else {
      abort('401');
    }
  }
  public function getclaimleadGraph()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 134 ||  Auth::user()->id == 141 || $user_role == 'SalesHead' || Auth::user()->id == 217 || Auth::user()->id == 202 ||  Auth::user()->id == 221) {
      return $theme->scope('users.getClaimLeadGraph', $data)->render();
    } else {
      abort('401');
    }
  }

  public function getCallDetails()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead') {
      return $theme->scope('users.ind_mart_data_pack', $data)->render();
    } else {
      abort('401');
    }
  }
  //setClicktoCallAgentCall_CLIENT
  public function setClicktoCallAgentCall_CLIENT(Request $request)
  {
    //  print_r($request->all());



    $data_arr_data = DB::table('clients')->where('id', $request->CID)->first();
    $pstr = trim($data_arr_data->phone);
    $new_str = str_replace(' ', '', $pstr);
    $n = 10;

    // Starting index of the string
    // where the new string begins
    $start = strlen($new_str) - $n;
    $str1 = '';

    for ($x = $start; $x < strlen($new_str); $x++) {

      // Appending characters to the new string
      $str1 .= $new_str[$x];
    }

    // Print new string
    $clientPhone = "+91" . intval($str1);
    $agentPhone = "+91" . Auth::user()->phone;


    //$agentPhone="+919999955922";

    //$clientPhone="+919960664886";
    //$clientPhone="+917703886088";

    DB::table('click_calldata_attemps')->insert(
      [
        'user_id' => Auth::user()->id,
        'agent_number' => $agentPhone,
        'client_number' => $clientPhone,
        'QUERY_ID' => $request->CID,
        'call_type' => 1,
        'created_at' => date('Y-m-d H:i:s')

      ]
    );


    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://kpi.knowlarity.com/Basic/v1/account/call/makecall",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n\"k_number\":\"+919555066066\",\n\"agent_number\":\"$agentPhone\",\n\"customer_number\":\"$clientPhone\",\n\"cli_number\":\"+911141124756\"\n}",
      CURLOPT_HTTPHEADER => array(
        "x-api-key: GmfYXV6B887gFuYkCLtO65rWgQrKKONI8Do7YFt9",
        "Authorization: 6fa1c47c-9f98-4812-9ee3-e3fb282f927b",
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);

    $response_arr = json_decode($response);



    $err = curl_close($curl);

    if ($response_arr->success->status == "success") {

      DB::table('click_calldata')->insert(
        [
          'user_id' => Auth::user()->id,
          'agent_number' => $agentPhone,
          'client_number' => $clientPhone,
          'QUERY_ID' => $request->CID,
          'call_type' => 1,
          'created_at' => date('Y-m-d H:i:s')

        ]
      );




      if (Auth::user()->id == 1444 || Auth::user()->id == 1445) {
        //sms
        $msg = "Greetings from MAX! just talked to ";
        $msg .= Auth::user()->name . ". His direct whatsapp no is +917290011547";

        $msg .= "His email id is: " . Auth::user()->email;
        $msg .= " If you are not satisfied by the response please email us on info@max.net or whatsapp on +917290011547";

        $phone = $clientPhone;
        $this->PRPSendSMS($phone, $msg);
        //sms
      } else {
        //sms
        $msg = "Greetings from MAX! You just talked to ";
        $msg .= Auth::user()->name . ". His direct whatsapp no is +91" . Auth::user()->phone;

        $msg .= "His email id is: " . Auth::user()->email;
        $msg .= " If you are not satisfied by the response please email us on info@max.net or whatsapp on +917290011547";

        $phone = $clientPhone;
        $this->PRPSendSMS($phone, $msg);
        //sms
      }




      $resp = array(
        'status' => 1

      );
    } else {
      $resp = array(
        'status' => 0,
        'data' => $response_arr->error->message

      );
    }
    return response()->json($resp);
  }
  //setClicktoCallAgentCall_CLIENT

  // setClicktoCallAgentCall
  public function setClicktoCallAgentCall(Request $request)
  {
    $data_arr_data = DB::table('indmt_data')->where('QUERY_ID', $request->QUERY_ID)->first();
    $phone_arr = explode("-", $data_arr_data->MOB);
    $clientPhone = $phone_arr[0] . $phone_arr[1];
    $agentPhone = "+91" . Auth::user()->phone;


    //$agentPhone="+919999955922";

    //    $clientPhone="+918287308662";
    //$clientPhone="+917703886088";

    DB::table('click_calldata_attemps')->insert(
      [
        'user_id' => Auth::user()->id,
        'agent_number' => $agentPhone,
        'client_number' => $clientPhone,
        'QUERY_ID' => $request->QUERY_ID,
        'call_type' => 0,
        'created_at' => date('Y-m-d H:i:s')

      ]
    );



    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://kpi.knowlarity.com/Basic/v1/account/call/makecall",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n\"k_number\":\"+919555066066\",\n\"agent_number\":\"$agentPhone\",\n\"customer_number\":\"$clientPhone\",\n\"cli_number\":\"+911141124756\"\n}",
      CURLOPT_HTTPHEADER => array(
        "x-api-key: GmfYXV6B887gFuYkCLtO65rWgQrKKONI8Do7YFt9",
        "Authorization: 6fa1c47c-9f98-4812-9ee3-e3fb282f927b",
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);

    $response_arr = json_decode($response);




    curl_close($curl);
    if ($response_arr->success->status == "success") {


      DB::table('click_calldata')->insert(
        [
          'user_id' => Auth::user()->id,
          'agent_number' => $agentPhone,
          'client_number' => $clientPhone,
          'QUERY_ID' => $request->QUERY_ID,
          'created_at' => date('Y-m-d H:i:s')

        ]
      );
      if (Auth::user()->id == 1444 || Auth::user()->id == 1454) {
        //sms
        $msg = "Greetings from MAX!
         You just talked to ";
        $msg .= Auth::user()->name . ". His/her direct whatsapp no is +917290011547 ";

        $msg .= " His email id is: " . Auth::user()->email;
        $msg .= " If you are not satisfied by the response please email us on info@max.net";
        //$agentPhone="7703886088";
        $phone = $agentPhone;
        $this->PRPSendSMS($phone, $msg);
        //sms


      } else {
        //sms
        $msg = "Greetings from MAX!
      You just talked to ";
        $msg .= Auth::user()->name . ". His/her direct whatsapp no is +91" . Auth::user()->phone;

        $msg .= " His email id is: " . Auth::user()->email;
        $msg .= " If you are not satisfied by the response please email us on info@max.net or whatsapp on +917290011547";

        $phone = $agentPhone;
        $this->PRPSendSMS($phone, $msg);
        //sms

      }

      $resp = array(
        'status' => 1

      );
    }
    return response()->json($resp);
  }

  // setClicktoCallAgentCall
  //clicktoCallAPI
  public function clicktoCallAPI(Request $request)
  {
    $data_arr_data = DB::table('indmt_data')->where('QUERY_ID', $request->QUERY_ID)->first();
    $phone_arr = explode("-", $data_arr_data->MOB);
    $clientPhone = $phone_arr[0] . $phone_arr[1];

    $agentPhone = Auth::user()->phone;

    // $agentPhone="+917703886088";

    //    $clientPhone="+918287308662";
    $clientPhone = "+917703886088";

    DB::table('click_calldata_attemps')->insert(
      [
        'user_id' => Auth::user()->id,
        'agent_number' => $agentPhone,
        'client_number' => $clientPhone,
        'QUERY_ID' => $request->QUERY_ID,
        'call_type' => 0,
        'created_at' => date('Y-m-d H:i:s')

      ]
    );


    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://kpi.knowlarity.com/Basic/v1/account/call/makecall",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n\"k_number\":\"+919555066066\",\n\"agent_number\":\"$agentPhone\",\n\"customer_number\":\"$clientPhone\",\n\"cli_number\":\"+911141124756\"\n}",
      CURLOPT_HTTPHEADER => array(
        "x-api-key: GmfYXV6B887gFuYkCLtO65rWgQrKKONI8Do7YFt9",
        "Authorization: 6fa1c47c-9f98-4812-9ee3-e3fb282f927b",
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $response_arr = json_decode($response);



    curl_close($curl);
    if ($response_arr->success->status == "success") {

      DB::table('click_calldata')->insert(
        [
          'user_id' => Auth::user()->id,
          'agent_number' => $agentPhone,
          'client_number' => $clientPhone,
          'QUERY_ID' => $request->QUERY_ID,
          'created_at' => date('Y-m-d H:i:s')

        ]
      );

      $resp = array(
        'status' => 1

      );
    }
    return response()->json($resp);
  }
  //clicktoCallAPI

  //getAllLeadDataPack
  public function getAllLeadDataPack(Request $request)
  {
    $users = DB::table('indmt_data_pack')->where('QUERY_ID', $request->rowid)->first();

    DB::table('indmt_data_pack')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);


    $assign_to = AyraHelp::getUser($users->assign_to)->name;

    if ($users->updated_by == NULL) {
      $updated_by = 'Harsit';
    } else {
      $updated_by = AyraHelp::getUser($users->updated_by)->name;
    }


    $assign_on = date("j M Y h:i:sA", strtotime($users->assign_on));
    $users_lead_assign = DB::table('lead_assign')->where('QUERY_ID', $request->rowid)->first();
    $users_lead_moves = DB::table('lead_moves')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_notesby_sales = DB::table('lead_notesby_sales')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_lead_notes = DB::table('lead_notes')->where('QUERY_ID', $request->rowid)->get();

    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->get();




    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
      <thead class="thead-inverse">
        <tr>

          <th>User</th>
          <th>Stage</th>
          <th>Message</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>';


      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $assign_by = AyraHelp::getUser($Leadrow->user_id)->name;

        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];

        $HTML_HIST .= '<tr>

        <td>' . $assign_by . '</td>
        <td></td>
        <td>' . $Leadrow->msg . '</td>
        <td>' . $users_lead_move_created_on . '</td>
      </tr>';
      }


      $HTML_HIST .= '<tr>

      <td>Auto</td>
      <td>Fresh Lead</td>
      <td>5</td>
      <td>' . $created_on . '</td>
    </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

      <td>' . $updated_by . '</td>
      <td>Remaks</td>
      <td>' . $users->remarks . '</td>
      <td></td>
    </tr>';
      }


      //remarks


      $HTML_HIST .= '</tbody> </table>';
    } else {
      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
                <thead class="thead-inverse">
                  <tr>

                    <th>User</th>
                    <th>Stage</th>
                    <th>Message</th>
                    <th>Created</th>
                  </tr>
                </thead>
                <tbody>';

      $HTML_HIST .= '<tr>

                    <td>Auto</td>
                    <td>Fresh Lead</td>
                    <td></td>
                    <td>' . $created_on . '</td>
                  </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

                    <td>' . $updated_by . '</td>
                    <td>Remaks</td>
                    <td>' . $users->remarks . '</td>
                    <td></td>
                  </tr>';
      }


      //remarks

      if ($users_lead_assign != null) {
        $assign_by = AyraHelp::getUser($users_lead_assign->assign_by)->name;
        $assign_user_id = AyraHelp::getUser($users_lead_assign->assign_user_id)->name;
        $users_lead_assign_created_on = date('j M Y h:iA', strtotime($users_lead_assign->created_at));

        $HTML_HIST .= '<tr>

                    <td>' . $assign_user_id . '</td>
                    <td>Assigned</td>
                    <td>' . $users_lead_assign->msg . '</td>
                    <td>' . $users_lead_assign_created_on . '</td>
                  </tr>';
      }

      if (count($users_lead_moves) > 0) {

        foreach ($users_lead_moves as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->assign_by)->name;
          $assign_to = AyraHelp::getUser($Leadrow->assign_to)->name;
          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];
          if ($user_role == 'Admin') {
            $mgdata = $Leadrow->msg . "(" . $Leadrow->assign_remarks . ")";
          } else {
            $mgdata = $Leadrow->msg;
          }

          $HTML_HIST .= '<tr>

                      <td>' . $assign_to . '</td>
                      <td>' . optional($Leadrow)->stage_name . '</td>
                      <td>' . $mgdata . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }

      if (count($users_lead_notesby_sales) > 0) {

        foreach ($users_lead_notesby_sales as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->added_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];


          $HTML_HIST .= '<tr>

                      <td>' . $assign_by . '</td>
                      <td></td>
                      <td>' . $Leadrow->message . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }

      if (count($users_lead_lead_notes) > 0) {

        foreach ($users_lead_lead_notes as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->created_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];

          $HTML_HIST .= '<tr>

                      <td>' . $assign_by . '</td>
                      <td></td>
                      <td>' . $Leadrow->msg . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }






      $HTML_HIST .= '</tbody> </table>';
    }



    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3">Leads Full Information</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;



    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td>Assign Message</td>
    //   <td>'.optional($users_lead_assign)->msg.'</td>

    // </tr>';

    // $HTML .='
    // <tr>

    //   <td colspan="3">'.$MyTable.'</td>

    // </tr>';



    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>QUERY_ID</td>
              <td>' . $users->QUERY_ID . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SENDER NAME</td>
              <td>' . $users->SENDERNAME . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SENDERE MAIL</td>
              <td>' . $users->SENDEREMAIL . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SUBJECT</td>
              <td>' . $users->SUBJECT . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>DATE TIME</td>
              <td>' . $users->DATE_TIME_RE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>COMPANY NAME</td>
              <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MOBILE No.</td>
              <td>' . $users->MOB . '</td>

            </tr>';



    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>COUNTRY FLAG

              </td>
              <td><img src="' . $users->COUNTRY_FLAG . '"></td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MESSAGE

              </td>
              <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>ADDRESS

              </td>
              <td>' . $users->ENQ_ADDRESS . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>CITY

              </td>
              <td>' . $users->ENQ_CITY . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>STATE

              </td>
              <td>' . $users->ENQ_STATE . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>STATE

              </td>
              <td>' . $users->ENQ_STATE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>PRODUCT NAME

              </td>
              <td>' . $users->PRODUCT_NAME . '</td>

            </tr>';


    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td> 	COUNTRY ISO

    //   </td>
    //   <td>'.$users->COUNTRY_ISO.'</td>

    // </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>EMAIL ALT

              </td>
              <td>' . $users->EMAIL_ALT . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MOBILE  ALT

              </td>
              <td>' . $users->MOBILE_ALT . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>PHONE

              </td>
              <td>' . $users->PHONE . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>PHONE ALT

              </td>
              <td>' . $users->PHONE_ALT . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MEMBER SINCE

              </td>
              <td>' . $users->IM_MEMBER_SINCE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Created At

              </td>
              <td>' . $created_on . '</td>

            </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }
    if ($LS == 'INDMART-8929503295@API_2_PACK' || $LS == 'INDMART-8929503295@API_2_PACK') {
      $lsource = 'PACK API';
    }


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Lead Souce

              </td>
              <td>' . $lsource . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Remarks

              </td>
              <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

            </tr>';









    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);
  }



  //getAllLeadDataPack

  public function setlastActiveUser(Request $request)
  {
    switch ($request->setType) {
      case 1:
        $sessID = Auth::user()->user_session_id;
        $affected1 = DB::table('login_activity')
          ->where('session_id', $sessID)
          ->update(['logout_start' => date('Y-m-d H:i:s')]);
        $affected = DB::table('users')
          ->where('id', Auth::user()->id)
          ->update(['last_activetime' => date('Y-m-d H:i:s')]);
        //echo "Activeted ";

        break;
      case 2:
        $sessID = optional(Auth::user())->user_session_id;
        $affected1 = DB::table('login_activity')
          ->where('session_id', $sessID)
          ->update(['logout_start' => date('Y-m-d H:i:s')]);

        $affected = DB::table('users')
          ->where('id', Auth::user()->id)
          ->update(['user_session_id' => "Y"]);
        Auth::logout();

        echo "2";


        break;
    }
  }

  //getLeadList_PACK
  public function getLeadList_PACK(Request $request)
  {

    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    // if($user_role=='Admin' || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==130 || Auth::user()->id==131){
    $i = 0;

    if (isset($request->action_name)) {
      if ($request->action_name == 'viewAllAssign') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 2)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewAllIreevant') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewUnQualifiedLead') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 4)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewHOLDLead') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewDUPLICATELead') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('duplicate_lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }


      if ($request->action_name == 'BUY_LEAD') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'B')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'DIRECT_LEAD') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'W')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'PHONE_LEAD') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'P')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'INHOUSED_LEAD') {
        $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
    } else {
      $data_arr_data = DB::table('indmt_data_pack')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'W')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }
      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }
      if ($LS == 'INDMART-8929503295@API_2_PACK' || $LS == 'INDMART-8929503295@API_2_PACK') {
        $lsource = 'PACK API';
      }


      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }
      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;
      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';

          break;
      }

      // $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);
      //----------------------------
      if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4 || $value->lead_status == 55) {
        switch ($value->lead_status) {
          case 0:
            $st_name = 'Fresh Lead';
            break;
          case 1:
            $st_name = 'Irrelevant';
            break;
          case 4:
            $st_name = 'Unqualified';
            break;
          case 55:
            $st_name = 'HOLD';
            break;
        }
      } else {


        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
        $st_name = optional($curr_lead_stage)->stage_name;
      }

      //----------------------------
      // LEAD_TYPE
      switch ($value->COUNTRY_ISO) {
        case 'IN':
          $LEAD_TYPE = 'INDIA';
          break;
        case 'India':
          $LEAD_TYPE = 'INDIA';
          break;

        default:
          $LEAD_TYPE = 'FOREIGN';
          break;
      }
      // LEAD_TYPE

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';


      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $LEAD_TYPE,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  //getLeadList_PACK

  public function getPackingLead()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 158 || Auth::user()->id == 4) {
      return $theme->scope('users.ind_mart_data_pack', $data)->render();
    } else {
      abort('401');
    }


    //return view('users.index')->with('users', $users);
  }


  public function getLoginActivityDetails(Request $request)
  {
    //$login_arr=DB::table('login_activity')->where('created_on',$request->rowID)->get();
    $login_arr = DB::table('login_activity')->where('user_id', $request->userID)->where('created_on', $request->rowID)->get();


    $HTML = '<table class="table table-sm m-table m-table--head-bg-brand">
                        <thead class="thead-inverse">
                          <tr>
                            <th>#</th>
                            <th>Session Start</th>
                            <th>Session Start</th>
                            <th>Session Active</th>
                          </tr>
                        </thead>
                        <tbody>';
    $i = 0;
    foreach ($login_arr as $key => $data) {
      $st_login = date('j M Y H:iA', strtotime($data->login_start));
      $st_stop = date('j M Y H:iA', strtotime($data->logout_start));

      $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->login_start);
      $end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->logout_start);
      //$different_days = $end_date->diffForHumans($start_date);
      $diff = $start_date->diffInSeconds($end_date);
      // print_r($diff->h);
      $different_days =  gmdate('H:i:s', $diff);


      $i++;
      $HTML .= '<tr>
      <th scope="row">' . $i . '</th>
      <td>' . $st_login . '</td>
      <td>' . $st_stop . '</td>
      <td>' . $different_days . '</td>
    </tr>';
    }
    $HTML .= '	</tbody>
</table>';
    echo $HTML;
  }

  //getSOPActivityUser
  public function getSOPActivityUser(Request $request)
  {

    $data_arr[] = array(
      'RecordID' => 1,
      'userid' =>1,
      'login_date' => date('Y-m-d'),
      'login_date_db' => date('Y-m-d'),
      'login_name' => 'ajau',
      'first_login' => date('Y-m-d'),
      'last_login' =>  date('Y-m-d'),
      'session_hour' => 44,
      'loginDBID' => 3444,
      'loginLocation' => 444


    );
    $JSON_Data = json_encode($data_arr);


    $columnsDefault = [
      'RecordID' => true,
      'userid' => true,
      'login_date' => true,
      'login_date_db' => true,
      'login_name' => true,
      'first_login' => true,
      'last_login' => true,
      'session_hour' => true,
      'loginDBID' => true,
      'loginLocation' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);


  }
  //getSOPActivityUser

  public function getLoginActivityUser(Request $request)
  {
    if (isset($request->userID)) {
      $login_arr = DB::table('login_activity')->where('user_id', $request->userID)->distinct()->orderBy('id', 'desc')->get(['created_on']);
    } else {
      $login_arr = DB::table('login_activity')->where('user_id', Auth::user()->id)->distinct()->orderBy('id', 'desc')->get(['created_on']);
    }



    $data_arr = array();
    foreach ($login_arr as $key => $value) {
      $loginLocation = "";

      if (isset($request->userID)) {
        $login_first_arr = DB::table('login_activity')->where('user_id', $request->userID)->where('created_on', $value->created_on)->orderBy('id', 'ASC')->first();
        $login_last_arr = DB::table('login_activity')->where('user_id', $request->userID)->where('created_on', $value->created_on)->orderBy('id', 'DESC')->first();
        $actualHour = AyraHelp::getUserActualHour($request->userID, $value->created_on);
        $dbotp_arr = DB::table('users_otp')->where('user_id', $request->userID)->where('ip_verify', 1)->latest()->first();


        $loginLocation_arr = json_decode($dbotp_arr->location_details);
        // print_r($loginLocation_arr->region_name);
        // print_r($loginLocation_arr->city);
        // print_r($loginLocation_arr->zip);
        //AIzaSyAJzMwHsMAmdqgG9SntExDSJbT82f7HnTI

        $loginLocation = optional($loginLocation_arr)->region_name . "-" . optional($loginLocation_arr)->city . "-" . optional($loginLocation_arr)->zip;



        //$loginLocation="";
      } else {
        $login_first_arr = DB::table('login_activity')->where('user_id', Auth::user()->id)->where('created_on', $value->created_on)->orderBy('id', 'ASC')->first();
        $login_last_arr = DB::table('login_activity')->where('user_id', Auth::user()->id)->where('created_on', $value->created_on)->orderBy('id', 'DESC')->first();
        $actualHour = AyraHelp::getUserActualHour(Auth::user()->id, $value->created_on);
        $loginLocation = "";
      }
      $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $login_first_arr->login_start);
      $end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $login_last_arr->logout_start);
      $diff = $start_date->diffInSeconds($end_date);
      // print_r($diff->h);
      $different_days =  gmdate('H:i:s', $diff);

      //$different_days = $end_date->diffForHumans($start_date);


      //dd($different_days);





      $data_arr[] = array(
        'RecordID' => $login_first_arr->id,
        'userid' => $login_first_arr->user_id,
        'login_date' => date('j M Y ', strtotime($login_first_arr->login_start)),
        'login_date_db' => $login_first_arr->login_start,
        'login_name' => $login_first_arr->user_name,
        'first_login' => date('j M Y H:iA', strtotime($login_first_arr->login_start)),
        'last_login' =>  date('j M Y H:iA', strtotime($login_last_arr->logout_start)),
        'session_hour' => $actualHour,
        'loginDBID' => $login_last_arr->created_on,
        'loginLocation' => $loginLocation,


      );
    }

    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'userid' => true,
      'login_date' => true,
      'login_date_db' => true,
      'login_name' => true,
      'first_login' => true,
      'last_login' => true,
      'session_hour' => true,
      'loginDBID' => true,
      'loginLocation' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function viewLoginActivityData($id)
  {
    $users = User::find($id);
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => $users];
    return $theme->scope('lead.login_activity_admin_userView', $data)->render();
  }
  //getSOPList
  public function getSOPList()
  {
    
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => 1];
    return $theme->scope('lead.sopList', $data)->render();
  }
  //getSOPList

  public function LeadManagementView()
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.lead_managementLayout', $data)->render();
  }

  //getLeadDataBYID
  public function getLeadDataBYID(Request $request)
  {
    $data_arr_data = DB::table('indmt_data')->where('QUERY_ID', $request->QUERY_ID)->first();
    $resp = array(
      'LeadData' => $data_arr_data

    );
    return response()->json($resp);
  }
  //getLeadDataBYID
  //getAvaibleLeadListViewAllAdmin

  public function getAvaibleLeadListViewAllAdmin(Request $request)
  {
    $i = 0;


    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('QTYPE', '!=', 'P')->where('duplicate_lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->where('is_unique',1)->get();

    if ($request->checkVal == 1) {
      $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }
    if ($request->checkVal == 2) {
      $data_arr_data = DB::table('indmt_data')->whereNull('GLUSR_USR_COMPANYNAME')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }
    if ($request->checkVal == 3) {
      $data_arr_data = DB::table('indmt_data')->whereNotNull('GLUSR_USR_COMPANYNAME')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'tags_name' => $value->tags_name,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
        'verified' =>  $value->verified,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'tags_name' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'verified' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  //getAvaibleLeadListViewAllAdmin

  //getAvaibleTicketListViewAll
  public function getAvaibleTicketListViewAll(Request $request)
  {
    $i = 0;


    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if($user_role == 'Admin' || $user_role == 'SalesHead'){
      $data_arr_data = DB::table('bo_tickets')->where('is_deleted',0)->get();
    }else{
      $data_arr_data = DB::table('bo_tickets')->where('assinged_to',Auth::user()->id)->where('is_deleted',0)->get();      
    }
      


   


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $qcFormData = DB::table('qc_forms')->where('form_id', $value->ticket_item_id)->first();
// print_r($qcFormData);

  $orderID=$qcFormData->order_id.'/'.$qcFormData->subOrder;


  $date = Carbon::parse($value->created_at);
     


  $created_at = $date->diffForHumans();
  $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
  $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
  $created_at = str_replace([' hours', ' hour'], ' Hrs', $created_at);
  $created_at = str_replace([' months', ' month'], ' M', $created_at);

  if (preg_match('(years|year)', $created_at)) {
    $created_at = $this->created_at->toFormattedDateString();
  }



      $data_arr[] = array(
        'RecordID' => $value->id,
        'ticket_type_name' => $value->ticket_type_name,
        'brand_name' => $qcFormData->brand_name,
        'order_id' => $orderID,
        'created_at' =>date('j F Y', strtotime($value->created_at)),
        'created_name' =>$value->created_by_name,
        'ticket_cm_typeName' =>$value->ticket_cm_typeName,
        'priority_id' =>$value->priority_id,
        'status' =>$value->status,
        'agoTime' =>$created_at
       
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'ticket_type_name' => true,
      'brand_name' => true,
      'order_id' => true,
      'created_at' => true,
      'created_name' => true,
      'ticket_cm_typeName' => true,
      'priority_id' => true,
      'agoTime' => true,
      'status' => true,
      
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getAvaibleTicketListViewAll

  //getAvaibleLeadListViewAll
  public function getAvaibleLeadListViewAll(Request $request)
  {
    $i = 0;


    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('QTYPE', '!=', 'P')->where('duplicate_lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->where('is_unique',1)->get();
    //ajok $data_arr_data = DB::table('indmt_data')->whereNull('intern_user_id')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->where('is_distribute_seller', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    // if (Auth::user()->id == 159 || Auth::user()->id == 160 || Auth::user()->id == 162 || Auth::user()->id == 161 || Auth::user()->id == 162 || Auth::user()->id == 163 || Auth::user()->id == 164  || Auth::user()->id == 165 || Auth::user()->id == 166 || Auth::user()->id == 167 || Auth::user()->id == 168 || Auth::user()->id == 169 || Auth::user()->id == 170) {
    //   $data_arr_data = DB::table('indmt_data')->where('COUNTRY_ISO', 'like', 'IN%')->whereNull('intern_user_id')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->whereNotNull('tags_name')->where(function ($q) {
    //     $q->where('tags_name', 'LIKE', "%Ingredient%")->orWhere('tags_name', 'LIKE', "%Essential Oils%")->orWhere('tags_name', 'LIKE', "%Private Label%")->orWhere('tags_name', 'LIKE', "%Distributership%");
    //   })->get();
    // } else {
    //   if(Auth::user()->id==180){
    //     $data_arr_data = DB::table('indmt_data')->whereNull('intern_user_id')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->limit(15)->get();
    //   }else{
    //     $data_arr_data = DB::table('indmt_data')->whereNull('intern_user_id')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //   }

    // }
    //Big Buyer


    // $data_arr_data = DB::table('indmt_data')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->where(function ($q) {
    //   $q->where('tags_name', 'LIKE', "%Ingredient%")->orWhere('tags_name', 'LIKE', "%Essential Oils%")->orWhere('tags_name', 'LIKE', "%Private Label%")->orWhere('tags_name', 'LIKE', "%Distributership%")->orWhere('tags_name', 'LIKE', "%Big Buyer%")->whereNull('tags_name');
    // })->get();

    $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'tags_name' => $value->tags_name,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
        'verified' =>  $value->verified,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'tags_name' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'verified' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getAvaibleLeadListViewAll

  // getLeadListViewAll
  public function getLeadListViewAll(Request $request)
  {

    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    // if($user_role=='Admin' || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==130 || Auth::user()->id==131){
    $i = 0;

    if (isset($request->action_name)) {
      if ($request->action_name == 'viewAllAssign') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 2)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewAllIreevant') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewUnQualifiedLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 4)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewHOLDLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewDUPLICATELead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('duplicate_lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }


      if ($request->action_name == 'BUY_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', Carbon::yesterday())->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'B')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'DIRECT_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', Carbon::yesterday())->where('lead_status', 0)->where('QTYPE', 'W')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'PHONE_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', Carbon::yesterday())->where('lead_status', 0)->where('QTYPE', 'P')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'INHOUSED_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', Carbon::yesterday())->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
    } else {



      $data_arr_data = DB::table('indmt_data')->whereDate('created_at', Carbon::yesterday())->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }
      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }

      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }
      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;
      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';

          break;
      }

      // $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);
      //----------------------------
      if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4 || $value->lead_status == 55) {
        switch ($value->lead_status) {
          case 0:
            $st_name = 'Fresh Lead';
            break;
          case 1:
            $st_name = 'Irrelevant';
            break;
          case 4:
            $st_name = 'Unqualified';
            break;
          case 55:
            $st_name = 'HOLD';
            break;
        }
      } else {


        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
        $st_name = optional($curr_lead_stage)->stage_name;
      }

      //----------------------------
      // LEAD_TYPE
      switch ($value->COUNTRY_ISO) {
        case 'IN':
          $LEAD_TYPE = 'INDIA';
          break;
        case 'India':
          $LEAD_TYPE = 'INDIA';
          break;

        default:
          $LEAD_TYPE = 'FOREIGN';
          break;
      }
      // LEAD_TYPE

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';


      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        // 'MOB' => $value->MOB,
        'MOB' => '',
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $LEAD_TYPE,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  // getLeadListViewAll

  //getAllLeadDataALL
  public function getAllLeadDataALLOKwait(Request $request)
  {
    $users = DB::table('indmt_data')->where('QUERY_ID', $request->rowid)->first();

    DB::table('indmt_data')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);


    $assign_to = AyraHelp::getUser($users->assign_to)->name;

    if ($users->updated_by == NULL) {
      $updated_by = 'Harsit';
    } else {
      $updated_by = AyraHelp::getUser($users->updated_by)->name;
    }


    $assign_on = date("j M Y h:i:sA", strtotime($users->assign_on));
    $users_lead_assign = DB::table('lead_assign')->where('QUERY_ID', $request->rowid)->first();
    $users_lead_moves = DB::table('lead_moves')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_notesby_sales = DB::table('lead_notesby_sales')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_lead_notes = DB::table('lead_notes')->where('QUERY_ID', $request->rowid)->get();

    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->get();




    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
      <thead class="thead-inverse">
        <tr>

          <th>User</th>
          <th>Stage</th>
          <th>Message</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>';


      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $assign_by = AyraHelp::getUser($Leadrow->user_id)->name;

        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];

        $HTML_HIST .= '<tr>

        <td>' . $assign_by . '</td>
        <td></td>
        <td>' . $Leadrow->msg . '</td>
        <td>' . $users_lead_move_created_on . '</td>
      </tr>';
      }


      $HTML_HIST .= '<tr>

      <td>Auto</td>
      <td>Fresh Lead</td>
      <td>5</td>
      <td>' . $created_on . '</td>
    </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

      <td>' . $updated_by . '</td>
      <td>Remaks</td>
      <td>' . $users->remarks . '</td>
      <td></td>
    </tr>';
      }


      //remarks


      $HTML_HIST .= '</tbody> </table>';
    } else {
      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
                <thead class="thead-inverse">
                  <tr>

                    <th>User</th>
                    <th>Stage</th>
                    <th>Message</th>
                    <th>Created</th>
                  </tr>
                </thead>
                <tbody>';

      $HTML_HIST .= '<tr>

                    <td>Auto</td>
                    <td>Fresh Lead</td>
                    <td></td>
                    <td>' . $created_on . '</td>
                  </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

                    <td>' . $updated_by . '</td>
                    <td>Remaks</td>
                    <td>' . $users->remarks . '</td>
                    <td></td>
                  </tr>';
      }


      //remarks

      if ($users_lead_assign != null) {
        $assign_by = AyraHelp::getUser($users_lead_assign->assign_by)->name;
        $assign_user_id = AyraHelp::getUser($users_lead_assign->assign_user_id)->name;
        $users_lead_assign_created_on = date('j M Y h:iA', strtotime($users_lead_assign->created_at));

        $HTML_HIST .= '<tr>

                    <td>' . $assign_user_id . '</td>
                    <td>Assigned</td>
                    <td>' . $users_lead_assign->msg . '</td>
                    <td>' . $users_lead_assign_created_on . '</td>
                  </tr>';
      }

      if (count($users_lead_moves) > 0) {

        foreach ($users_lead_moves as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->assign_by)->name;
          $assign_to = AyraHelp::getUser($Leadrow->assign_to)->name;
          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];
          if ($user_role == 'Admin') {
            $mgdata = $Leadrow->msg . "(" . $Leadrow->assign_remarks . ")";
          } else {
            $mgdata = $Leadrow->msg;
          }

          $HTML_HIST .= '<tr>

                      <td>' . $assign_to . '</td>
                      <td>' . optional($Leadrow)->stage_name . '</td>
                      <td>' . $mgdata . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }

      if (count($users_lead_notesby_sales) > 0) {

        foreach ($users_lead_notesby_sales as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->added_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];


          $HTML_HIST .= '<tr>

                      <td>' . $assign_by . '</td>
                      <td></td>
                      <td>' . $Leadrow->message . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }

      if (count($users_lead_lead_notes) > 0) {

        foreach ($users_lead_lead_notes as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->created_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];

          $HTML_HIST .= '<tr>

                      <td>' . $assign_by . '</td>
                      <td></td>
                      <td>' . $Leadrow->msg . '</td>
                      <td>' . $users_lead_move_created_on . '</td>
                    </tr>';
        }
      }






      $HTML_HIST .= '</tbody> </table>';
    }



    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3">Leads Full Information</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;



    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td>Assign Message</td>
    //   <td>'.optional($users_lead_assign)->msg.'</td>

    // </tr>';

    // $HTML .='
    // <tr>

    //   <td colspan="3">'.$MyTable.'</td>

    // </tr>';



    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>QUERY_ID</td>
              <td>' . $users->QUERY_ID . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SENDER NAME</td>
              <td>' . $users->SENDERNAME . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SENDERE MAIL</td>
              <td>' . $users->SENDEREMAIL . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>SUBJECT</td>
              <td>' . $users->SUBJECT . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>DATE TIME</td>
              <td>' . $users->DATE_TIME_RE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>COMPANY NAME</td>
              <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

            </tr>';

    // $HTMLA .= '
    //           <tr>
    //             <th scope="row">1</th>
    //             <td>MOBILE No.</td>
    //             <td>' . $users->MOB . '</td>
    //
    //           </tr>';



    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>COUNTRY FLAG

              </td>
              <td><img src="' . $users->COUNTRY_FLAG . '"></td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MESSAGE

              </td>
              <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>ADDRESS

              </td>
              <td>' . $users->ENQ_ADDRESS . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>CITY

              </td>
              <td>' . $users->ENQ_CITY . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>STATE

              </td>
              <td>' . $users->ENQ_STATE . '</td>

            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>STATE

              </td>
              <td>' . $users->ENQ_STATE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>PRODUCT NAME

              </td>
              <td>' . $users->PRODUCT_NAME . '</td>

            </tr>';


    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td> 	COUNTRY ISO

    //   </td>
    //   <td>'.$users->COUNTRY_ISO.'</td>

    // </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>EMAIL ALT

              </td>
              <td>' . $users->EMAIL_ALT . '</td>

            </tr>';


    // $HTML .= '
    //           <tr>
    //             <th scope="row">1</th>
    //             <td>MOBILE  ALT
    //
    //             </td>
    //             <td>' . $users->MOBILE_ALT . '</td>
    //
    //           </tr>';

    // $HTML .= '
    //           <tr>
    //             <th scope="row">1</th>
    //             <td>PHONE
    //
    //             </td>
    //             <td>' . $users->PHONE . '</td>
    //
    //           </tr>';


    // $HTML .= '
    //           <tr>
    //             <th scope="row">1</th>
    //             <td>PHONE ALT
    //
    //             </td>
    //             <td>' . $users->PHONE_ALT . '</td>
    //
    //           </tr>';


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>MEMBER SINCE

              </td>
              <td>' . $users->IM_MEMBER_SINCE . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Created At

              </td>
              <td>' . $created_on . '</td>

            </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }


    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Lead Souce

              </td>
              <td>' . $lsource . '</td>

            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Remarks

              </td>
              <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

            </tr>';









    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);
  }


  //getAllLeadDataALL




  public function getAllLeadUntouch()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || $user_role == "SalesUser" || $user_role == "Staff") {
      return $theme->scope('lead.untoch_lead', $data)->render();
    } else {
      about(401);
      //return $theme->scope('lead.login_activity', $data)->render();
    }
  }

  //getAllComplainList
  public function getAllComplainList()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    return $theme->scope('lead.complainList', $data)->render();
    
  }


  //getAllComplainList


  //getAllAvaibleLeadData
  public function getAllAvaibleLeadData()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || $user_role == "SalesUser" || Auth::user()->id==217 || Auth::user()->id==202 ) {
      return $theme->scope('lead.avaibleLeads', $data)->render();
    } else {
      about(401);
      //return $theme->scope('lead.login_activity', $data)->render();
    }
  }


  // getAllAvaibleLeadData
  //getAllAvaibleLeadDataUserID
  public function getAllAvaibleLeadDataUserID()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || $user_role == "SalesUser") {
      return $theme->scope('lead.avaibleLeads', $data)->render();
    } else {
      about(401);
      //return $theme->scope('lead.login_activity', $data)->render();
    }
  }
  //getAllAvaibleLeadDataUserID


  public function getClick2CallDataFromAPI()
  {
    $phone = "+91" . Auth::user()->phone;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {

      $login_first_arr = DB::table('click_calldata_api')->orderBy('id', 'DESC')->get();
    } else {
    }
    $login_first_arr = DB::table('click_calldata_api')->where('destination', $phone)->orderBy('id', 'DESC')->get();

    $data_arr = array();
    foreach ($login_first_arr as $key => $value) {
      $data_arr[] = array(
        'RecordID' => $value->id,
        'customer_number' => $value->customer_number,
        'agent_number' => $value->destination,
        'call_duration' =>  $value->call_duration,
        'in_out' => $value->Call_Type == 0 ? "IN" : "OUT",
        'call_on' => $value->call_date,
        'call_audio' =>  $value->call_recording,
        'call_details' => $value->agent_number,

      );
    }

    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'customer_number' => true,
      'agent_number' => true,
      'call_duration' => true,
      'in_out' => true,
      'call_on' => true,
      'call_audio' => true,
      'call_details' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function loginActivity()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('lead.login_activity_admin', $data)->render();
    } else {
      return $theme->scope('lead.login_activity', $data)->render();
    }
  }


  public function sendQuationView($id)
  {
    $users = DB::table('indmt_data')->where('QUERY_ID', $id)->first();

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => $users];
    return $theme->scope('client.send_quatation_view', $data)->render();
  }
  public function AddNewLead(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('client.add_new_lead', $data)->render();
  }
  public function AddNewLeadByIndmLead($QUERY_ID)
  {

    $indData = DB::table('indmt_data')
      ->where('QUERY_ID', $QUERY_ID)
      ->first();

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => $indData];
    return $theme->scope('client.add_new_lead_byindmLead', $data)->render();
  }





  public function setReplayToTicket(Request $request)
  {

    DB::table('ticket_chats')->insert(
      [

        'ticket_id' => $request->ticketid,
        'user_from' => Auth::user()->id,
        'user_message' => $request->txtReplay,
        'created_at' => date('Y-m-d H:i:s')


      ]
    );
    $resp = array(
      'status' => 1,

    );
    return response()->json($resp);
  }
  public function setTicketResponseSELF(Request $request)
  {
    //print_r($request->all());

    DB::table('ticket_list')
      ->where('id', $request->TID)
      ->update([
        'ticket_closed_at' => date('Y-m-d H:i:s'),
        'ticket_closed_by' => Auth::user()->id,
        'ticket_status' => $request->txtTicketSelectResp,
      ]);
    $resp = array(
      'status' => 1,

    );
    return response()->json($resp);
  }
  
  public function ticketForm(Request $request) //this is for universal ticket
  {
    // print_r($request->all());
    // die;
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['boTicketType' => $request->boTicketType];
    
    if( $request->boTicketType==1){
      return $theme->scope('users.ticketForm', $data)->render();
    }
     
    if( $request->boTicketType==2){
      return $theme->scope('users.ticketForm', $data)->render();
    }

   
  }


  public function supportTicket(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('users.supportTicket', $data)->render();
  }
  // getTicketListDataInfoV2

  public function getTicketListDataInfoV2(Request $request)
  {
    $tType_arr = DB::table('bo_tickets')->where('id', $request->rowID)->first();
  $qcFormData = DB::table('qc_forms')->where('form_id', $tType_arr->ticket_item_id)->first();
// print_r($qcFormData);

  $orderID=$qcFormData->order_id.'/'.$qcFormData->subOrder;


      
      $HTML ='<table class="table m-table m-table--head-bg-brand">
      <thead>
        <tr>
          <th>#</th>
          <th>Ticket For</th>
          <th>'.$tType_arr->ticket_type_name.'</th>
         
        </tr>
      </thead>
      <tbody>
      <tr>
      <th scope="row">3</th>
      <td>Complain For:</td>
      <td>'.@$tType_arr->ticket_cm_typeName.'</td>         
    </tr>
        <tr>
          <th scope="row">1</th>
          <td>Order ID</td>
          <td>'.$orderID.'</td>
        
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Created_at</td>
          <td>'.date('j F Y',strtotime($qcFormData->created_at)).'</td>
        
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Brand Name</td>
          <td>'.$qcFormData->brand_name.'</td>         
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Item  Name</td>
          <td>'.$tType_arr->item_name.'</td>         
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Sample ID</td>
        <td>'.$qcFormData->item_fm_sample_no.'</td>         
      </tr>

      <tr>
      <th scope="row">3</th>
      <td>Invoice On:</td>
      <td>'.@$qcFormData->curr_stage_updated_on.'</td>         
    </tr>

   
      

      </tbody>
    </table>';
  
    
   
    $resp = array(
      'status' => 1,
      'HTML' => $HTML      
    );
    return response()->json($resp);
  }

  // getTicketListDataInfoV2

  public function getTicketListDataInfo(Request $request)
  {
    $tType_arr = DB::table('ticket_list')->where('id', $request->rowID)->get();



    $user_data = array();
    $rep_data = array();
    foreach ($tType_arr as $key => $row) {

      $emp_arr = AyraHelp::getProfilePIC($row->created_by);

      $user_arr = AyraHelp::getUser($row->created_by);


      if (!isset($emp_arr->photo)) {
        $img_photo = asset('local/public/img/avatar.jpg');
      } else {
        $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
      }


      $date = Carbon::parse($row->created_at);
      $now = Carbon::now();


      $created_at = $date->diffForHumans();
      $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
      $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
      $created_at = str_replace([' hours', ' hour'], ' Hrs', $created_at);
      $created_at = str_replace([' months', ' month'], ' M', $created_at);

      if (preg_match('(years|year)', $created_at)) {
        $created_at = $this->created_at->toFormattedDateString();
      }
      switch ($row->ticket_status) {
        case 0:
          $t_status = 'PENDING';
          break;
        case 1:
          $t_status = 'OPEN';
          break;
        case 2:
          $t_status = 'CLOSED';
          break;
        case 3:
          $t_status = 'RE-OPEN';
          break;
      }


      $replay_data = DB::table('ticket_chats')->where('ticket_id', $request->rowID)->get();

      foreach ($replay_data as $key => $rDATA) {

        $emp_arr = AyraHelp::getProfilePIC($rDATA->user_from);


        if (!isset($emp_arr->photo)) {
          $img_photo = asset('local/public/img/avatar.jpg');
        } else {
          $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
        }
        $date2 = Carbon::parse($rDATA->created_at);
        $created_at1 = $date2->diffForHumans();
        $created_at1 = str_replace([' seconds', ' second'], ' sec', $created_at1);
        $created_at1 = str_replace([' minutes', ' minute'], ' min', $created_at1);
        $created_at1 = str_replace([' hours', ' hour'], ' Hrs', $created_at1);
        $created_at1 = str_replace([' months', ' month'], ' M', $created_at1);

        if (preg_match('(years|year)', $created_at1)) {
          $created_at1 = $this->created_at1->toFormattedDateString();
        }


        $rep_data[] = array(
          'name' => AyraHelp::getUser($rDATA->user_from)->name,
          'profile_pic' => $img_photo,
          'user_msg' => $rDATA->user_message,
          'time_ag' => $created_at1,
        );
      }


      $user_data[] = array(
        'userid' => $user_arr->id,
        'ticketid' => $request->rowID,
        'name' => $user_arr->name,
        'profile_pic' => $img_photo,
        'ticket_ago' => $created_at,
        'ticket_msg' => $row->ticket_message,
        'ticket_status' => $t_status,

      );
    }
    $resp = array(
      'status' => 1,
      'user_data' => $user_data,
      'replay_data' => $rep_data
    );
    return response()->json($resp);
  }
  //getActivityUserListData
  public function getActivityUserListData(Request $request)
  {
    $data_arr = array();
    $actvityuser_arr = DB::table('logged_activity')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

    foreach ($actvityuser_arr as $key => $value) {

      $user_arr = AyraHelp::getUser($value->user_id);
      $emp_arr = AyraHelp::getProfilePIC($user_arr->id);
      if (!isset($emp_arr->photo)) {
        $img_photo = asset('local/public/img/avatar.jpg');
      } else {
        $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
      }

      $data_arr[] = array(
        'RecordID' => $value->id,
        'event_name' => $value->event_name,
        'event_id' => $value->event_id,
        'created_by' => AyraHelp::getUser($value->user_id)->name,
        'created_photo' => $img_photo,
        'created_at' => date('j M y, h:i A', strtotime($value->created_at)),
        'event_info' => $value->event_info,
      );
    }

    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'event_name' => true,
      'event_id' => true,
      'created_by' => true,
      'created_photo' => true,
      'created_at' => true,
      'event_info' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getActivityUserListData

  //getOnCreditRequest
  public function getOnCreditRequest(Request $request)
  {
    $regArr = DB::table('lead_credit_request')->where('is_deleted', 0)->orderBy('status', 'desc')->get();
    $data_arr=array();
    foreach ($regArr as $key => $rowData) {

      $clientArr = AyraHelp::getLeadDataByID($rowData->client_id);

      $data_arr[] = array(
        'RecordID' => $rowData->id,
        'brand' => $clientArr->brand,
        'company' => $clientArr->company,
        'name' => $clientArr->firstname,
        'phone' => $clientArr->phone,
        'created_by' => @AyraHelp::getUser($rowData->created_by)->name,
        'approved_on' => $rowData->action_on,
        'approved_by' => @AyraHelp::getUser($rowData->action_by)->name,
        'approvedmsg' => $rowData->action_message,
        'created_at' => date('j-M-y h:iA', strtotime($rowData->created_at)),
        'status' => $rowData->status,
        'file_link' => $rowData->file_attach,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'brand' => true,
      'company' => true,
      'name' => true,
      'phone' => true,
      'created_by' => true,
      'approved_on' => true,
      'approved_by' => true,
      'approvedmsg' => true,
      'status' => true,
      'file_link' => true,
      'created_at' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getOnCreditRequest

  //getOrderEditListData
  public function getOrderEditListData(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $data_arr = array();

    if ($user_role == 'Admin' || $user_role == 'SalesHead' ||  Auth::user()->id == 156) {

      $ticket_arr = DB::table('order_edit_requests')->where('is_deleted', 0)->orderBy('status', 'desc')->get();
    } else {
      $ticket_arr = DB::table('order_edit_requests')->where('is_deleted', 0)->orderBy('status', 'desc')->where('created_by', Auth::user()->id)->get();
    }
    foreach ($ticket_arr as $key => $value) {

      $QCData = AyraHelp::getQCFormDate($value->form_id);


      $img_photo = asset('local/public/uploads/photos') . "/" . optional($value)->file_name;


      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => $QCData->order_id . '/' . $QCData->subOrder,
        'edit_type' => $value->type_id,
        'notes' => $value->notes,
        'created_by' => @AyraHelp::getUser($value->created_by)->name,
        'approved_on' => $value->approved_at,
        'approved_by' => @AyraHelp::getUser($value->approved_by)->name,
        'approvedmsg' => $value->approved_msg,
        'created_at' => date('j-M-y h:iA', strtotime($value->created_at)),
        'status' => $value->status,
        'file_link' => $img_photo,
      );
    }


    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'order_id' => true,
      'edit_type' => true,
      'notes' => true,
      'created_at' => true,
      'created_by' => true,
      'approved_on' => true,
      'approved_by' => true,
      'approvedmsg' => true,
      'status' => true,
      'file_link' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getOrderEditListData

  //getTicketListDatav2
  public function getTicketListDatav2(Request $request)
  {

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $data_arr = array();

    if ($user_role == 'Admin' || Auth::user()->id == 112) {
      $ticket_arr = DB::table('bo_tickets')->get();
    } else {

    
        $ticket_arr = DB::table('bo_tickets')->where('created_by',Auth::user()->id)->get();
    }








    foreach ($ticket_arr as $key => $value) {


     
     
      $date = Carbon::parse($value->created_at);
     


      $created_at = $date->diffForHumans();
      $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
      $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
      $created_at = str_replace([' hours', ' hour'], ' Hrs', $created_at);
      $created_at = str_replace([' months', ' month'], ' M', $created_at);

      if (preg_match('(years|year)', $created_at)) {
        $created_at = $this->created_at->toFormattedDateString();
      }

      if (!isset($value->attachment)) {
        $img_photo = '';
      } else {
        $img_photo = asset('local/public/uploads/photos') . "/" . optional($value)->attachment;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'status' => $value->status,
        'ticket_type_name' => $value->ticket_type_name,       
        'created_by_name' => $value->created_by_name,
        'assinged_to_name' => $value->assinged_to_name,
        'priority_name' => $value->priority_name,       
        'priority_id' => $value->priority_id,       
        'created_at' => date('j M Y h:i A', strtotime($value->created_at)),
        'since_ago' => $created_at,
        'docURl' => $img_photo
      );
      
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'status' => true,
      'ticket_type_name' => true,
      'created_by_name' => true,
      'assinged_to_name' => true,
      'priority_name' => true,
      'priority_id' => true,
      'created_at' => true,    
      'since_ago' => true,
      'docURl' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  //getTicketListDatav2

  public function getTicketListData(Request $request)
  {

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $data_arr = array();

    if ($user_role == 'Admin' || Auth::user()->id == 112) {
      $ticket_arr = DB::table('ticket_list')->get();
    } else {

      $ticket_arr = DB::table('ticket_list')
        ->join('ticket_assign_to', 'ticket_list.ticket_id', '=', 'ticket_assign_to.ticket_id')
        ->where('ticket_assign_to.assign_to', Auth::user()->id)
        ->orWhere('ticket_list.created_by', Auth::user()->id)
        ->select('ticket_list.*', 'ticket_assign_to.read_status', 'ticket_assign_to.assign_to')
        ->get();
    }








    foreach ($ticket_arr as $key => $value) {


      $tType_arr = DB::table('ticket_type')->where('id', $value->ticket_type)->first();
      $assin_arr = DB::table('ticket_assign_to')->where('ticket_id', $value->ticket_id)->get();


      foreach ($assin_arr as $key => $user) {


        $user_arr = AyraHelp::getUser($user->assign_to);
        $emp_arr = AyraHelp::getProfilePIC($user_arr->id);

        if (!isset($emp_arr->photo)) {
          $img_photo = asset('local/public/img/avatar.jpg');
        } else {
          $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
        }

        $assin_user[] = array(
          'user_id' => $user->id,
          'name' => $user_arr->name,
          'profile_pic' => $img_photo,
        );
      }

      $date = Carbon::parse($value->created_at);
      $now = Carbon::now();


      $created_at = $date->diffForHumans();
      $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
      $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
      $created_at = str_replace([' hours', ' hour'], ' Hrs', $created_at);
      $created_at = str_replace([' months', ' month'], ' M', $created_at);

      if (preg_match('(years|year)', $created_at)) {
        $created_at = $this->created_at->toFormattedDateString();
      }



      $data_arr[] = array(
        'RecordID' => $value->id,
        'ticket_id' => $value->ticket_id,
        'ticket_type' => $tType_arr->ticket_type,
        'ticket_subject' => $value->ticket_subject,
        'ticket_status' => $value->ticket_status,
        'created_by' => AyraHelp::getUser($value->created_by)->name,
        'priority_type' => $value->priority_type,
        'assignTo' => json_encode($assin_user),
        'created_at' => date('j M Y h:i A', strtotime($value->created_at)),
        'since_ago' => $created_at,
      );
      $assin_user = (array) null;
    }

    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'ticket_id' => true,
      'ticket_type' => true,
      'ticket_subject' => true,
      'ticket_status' => true,
      'created_by' => true,
      'priority_type' => true,
      'created_at' => true,
      'assignTo' => true,
      'since_ago' => true,
      'Actions'      => true,

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //view_order_edit_request
  public function view_order_edit_request()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('orders.v1.orderEditRequestedData', $data)->render();
  }

  //view_order_edit_request


  public function view_ticket_data()
  {


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('orders.v1.ticketRequestedData', $data)->render();
  }
  //sentTicketRequestOrder
  public function sentTicketRequestOrder(Request $request)
  {
    // print_r($request->all());
    // die;
    
    DB::table('bo_tickets')->insert(
      [

        'ticket_type' => 1,
        'ticket_type_name' => 'Order',
        'ticket_item_id' => $request->formID,
        'ticket_date' => $request->m_datepicker_1,
        'assinged_to' => $request->assignedUserID,
        'assinged_to_name' => AyraHelp::getUser($request->assignedUserID)->name,
        'subject' => $request->ticket_subject,
        'item_name' => $request->ticket_item_name,
        'ticket_msg' => $request->txtTicketMessage,
        'created_by' => Auth::user()->id,
        'created_by_name' => Auth::user()->name,
        'priority_id' => $request->ticketPriority,
        'priority_name' => $request->ticketPriorityName,        
        'ticket_cm_typeID' => $request->ticket_cm_typeID,
        'ticket_cm_typeName' => $request->ticket_cm_typeName,
        'client_email' => $request->client_email,
        'status' => 1


      ]
    );
    $lid = DB::getPdo()->lastInsertId();


    if ($request->hasFile('fileAttach')) {
      $file = $request->file('fileAttach');
      $filename = $lid . "_ticket" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      $affected = DB::table('bo_tickets')
      ->where('id', $lid)
      ->update(['attachment' =>$filename]);

    }
    $resp = array(
      'status' => 1
    );
    return response()->json($resp);


  }
  //sentTicketRequestOrder

  // sentTicketRequest
  public function sentTicketRequest(Request $request)
  {

  
    $getTicketID = AyraHelp::getTicketID();

    DB::table('ticket_list')->insert(
      [

        'ticket_id' => $getTicketID,
        'ticket_type' => $request->ticketType,
        'ticket_subject' => $request->ticket_subject,
        'priority_type' => $request->ticketPriority,
        'ticket_message' => $request->txtTicketMessage,
        // 'ticket_message' => $request->txtTicketMessage,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id

      ]
    );
    //assign to
    $assign_arr = $request->ticket_user;

    foreach ($assign_arr as $key => $user) {
      DB::table('ticket_assign_to')->insert(
        [

          'ticket_id' => $getTicketID,
          'assign_to' => $user,
          'assign_by' => Auth::user()->id

        ]
      );

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $AssineTo = AyraHelp::getUser($user)->name;

      $eventName = "Support";
      $eventINFO = 'Requested Support by ticket ID :' . $getTicketID . " and Assined to  " . $AssineTo . " by" . $LoggedName . "<br><strong>Message</strong>:" . $request->txtTicketMessage;
      $eventID = $getTicketID;
      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();
      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
      //LoggedActicty


      // pusher 
      /*
      $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
      );
      $pusher = new Pusher\Pusher(
        '9dfaf98953e291c9be80',
        '79bcb9731c4b2951e422',
        '1057116',
        $options
      );
      $eventID = 'AJ_ID' . $user;

      $msg_descA = 'You have request support ' . ' By ' . AyraHelp::getUser(Auth::user()->id)->name;

      $HTML = '<div class="m-section">     
    <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-brand">
        <thead class="thead-inverse">
        <h4>' . ucwords($msg_descA) . '</h4><br>
          <tr>          
            <th>Type</th>
            <th>Message</th>              
          </tr>
        </thead>';

      $HTML .= '<tbody>
          <tr>
          <td>' . $request->ticketType . '</td>
            <td>' . $request->txtTicketMessage . '</td>
           
           
          </tr>';

      $HTML . '   
        </tbody>
      </table>
    </div>
  </div>';

      $data['message'] = $HTML;
      $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
      // pusher 

    }
    //assign to








    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  // sentTicketRequest
  public function saveLeadData(Request $request)
  {


    $QUERY_ID = AyraHelp::getSponsorID();
    $addby=Auth::user()->name;
    DB::table('indmt_data')->insert(
      [

        'SENDERNAME' => $request->contact_person,
        'SENDEREMAIL' => $request->email,
        'SUBJECT' => 'In House Data-Added by'.$addby,
        'DATE_TIME_RE' => date('j F Y h:iA'),
        'GLUSR_USR_COMPANYNAME' => $request->company,
        'MOB' => $request->phone,
        'COUNTRY_FLAG' => 'https://1.imimg.com/country-flags/small/in_flag_s.png',
        'ENQ_MESSAGE' => $request->remarks,
        'ENQ_ADDRESS' => $request->address,
        'ENQ_CITY' => $request->city,
        'ENQ_STATE' => $request->state,
        'PRODUCT_NAME' => $request->product_name,
        'COUNTRY_ISO' => 'IN',
        'EMAIL_ALT' => '',
        'MOBILE_ALT' => '',
        'PHONE' => '',
        'PHONE_ALT' => '',
        'IM_MEMBER_SINCE' => '',
        'QUERY_ID' => intval($QUERY_ID),
        'data_source' => 'INHOUSE-ENTRY',
        'data_source_ID' => 6,
        'created_at' => date('Y-m-d H:i:s'),
        'DATE_TIME_RE_SYS' => date('Y-m-d H:i:s'),
        'assign_to' => 134,

      ]
    );

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  //setLeadTags
  public function setLeadTags(Request $request)
  {
    //print_r($request->all());
    $tgName = "";
    //setLeadTags
    $darArr = $request->lead_tag_id;
    foreach ($darArr as $key => $rowDataA) {
      $tgName .= $rowDataA . " | ";
    }


    $tagArr = DB::table('leads_by_tags')
      ->where('QUERY_ID', $request->QUERY_ID)
      ->where('tag_id', $request->lead_tag_id)
      ->first();
    if ($tagArr == null) {

      DB::table('leads_by_tags')->insert([
        'QUERY_ID' => $request->QUERY_ID,
        'tag_id_name' => $tgName,
        'tag_id' => 999,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
        'msg' => $request->txtMessageNoteReponse,

      ]);


      // save with verified 
      DB::table('indmt_data')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update([
          'verified' => 1,
          'iIrrelevant_type' => 6,
          'remarks' => $request->txtMessageNoteReponse,
          'verified_on' => date('Y-m-d H:i:s'),
          'verified_by' => Auth::user()->id,
          'tags_name' => $tgName,
          'intern_user_id' => NULL

        ]);


      foreach ($darArr as $key => $rowDataA) {
        if ($rowDataA == "Distributership") {
          DB::table('indmt_data')
            ->where('QUERY_ID', $request->QUERY_ID)
            ->update([
              'is_distribute' => 1,
              'is_distribute_seller' => 1

            ]);
        }
        if ($rowDataA == "Seller") {
          DB::table('indmt_data')
            ->where('QUERY_ID', $request->QUERY_ID)
            ->update([
              'is_seller' => 1,
              'is_distribute_seller' => 1

            ]);
        }
      }


      DB::table('lead_Irrelevant')->insert(
        [
          'QUERY_ID' => $request->QUERY_ID,
          'iIrrelevant_type' => 6,
          'created_by' => Auth::user()->id,
          'msg' => $request->txtMessageNoteReponse,
          'created_at' => date('Y-m-d H:i:s'),
          'status' => 1,

        ]
      );
      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageNoteReponse;



      $iIrrelevant_type_HTML = $tgName;


      $msg_desc = 'This lead is Verifed mark by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . " with tag :" . $iIrrelevant_type_HTML;

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
      //----------------------------


      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $eventName = "Lead Verifiction With Tags";
      $eventINFO = 'Lead verify with tag  by ' . $LoggedName . " Lead QUERY ID" . $QUERY_ID . " on " . date('j F Y H:i:s');
      $eventID = $QUERY_ID;
      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();
      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
      //LoggedActicty

      // save with verified 
      $resp = array(
        'status' => 1
      );
    } else {
      $resp = array(
        'status' => 2
      );
    }





    return response()->json($resp);
  }

  //setLeadTags
  //updateTicketStatus
  public function updateTicketStatus(Request $request)
  {
      $assign_user_id = $request->assign_user_id;
      $assign_msg = $request->assign_msg;
      $ticket_id = $request->ticket_id;
      $ticket_id_status = $request->ticket_id_status;
    
     


      DB::table('bo_tickets_logs')->insert(
        [
          'ticket_id' => $ticket_id,
          'created_by' => $assign_user_id,
          'created_by_name' => AyraHelp::getUser($assign_user_id)->name,
          'status_id' => $ticket_id_status,
          'msg' => $assign_msg,
          
        ]
      );
      $resp = array(
        'status' => 1
      );

      $affected = DB::table('bo_tickets')
              ->where('id', $ticket_id)
              ->update(['status' =>$ticket_id_status]);

      return response()->json($resp);

  }
  //updateTicketStatus

  //LEAD
  public function setLeadAssign(Request $request)
  {
    if ($request->action == 12) { //add data call
      $QUERY_ID = $request->QUERY_ID;
      $txtMessageNoteReponse = $request->txtMessageNoteReponse;
      $txtDataCallMin = $request->txtDataCallMin;
      $txtDataCallOption = $request->txtDataCallOption;
      $assign_user_id_calldata = $request->assign_user_id_calldata;
      //  $leadArr = DB::table('lead_assign')->where('QUERY_ID',$QUERY_ID)->first();


      DB::table('lead_datacall')->insert(
        [
          'QUERY_ID' => $QUERY_ID,
          'call_type' => $txtDataCallOption,
          'call_min' => $txtDataCallMin,
          'call_message' => $txtMessageNoteReponse,
          'call_pick_userid' => $assign_user_id_calldata
        ]
      );
      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    } //add data call


    if ($request->action == 6) { //lead notes unqlified

      DB::table('indmt_data')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update([
          'lead_status' => 4,
          'iIrrelevant_type' =>  $request->unqlified_type,
          'remarks' => $request->txtMessageNoteReponse,
        ]);
      $unqlified_type_HTML = $request->unqlified_type_HTML;

      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageNoteReponse;

      $msg_desc = 'This is disqualified by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . "With reason by :" . $unqlified_type_HTML;

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
      //----------------------------
      $affected = DB::table('lead_assign')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update([
          'current_stage_id' => 77,
          'current_lead_stage_name' => 'HOLD',
        ]);


      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }
    if ($request->action == 555) { //lead notes unqlified


      $unqlified_type_HTML = $request->unqlified_type_HTML;

      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageNoteReponse;

      $msg_desc = 'NO RESPONSE  :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . "With reason by :" . $unqlified_type_HTML;

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
      //----------------------------
      $affected = DB::table('lead_assign')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update([
          'current_stage_id' => 88,
          'current_lead_stage_name' => 'NO RESPONSE',
        ]);


      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }


    if ($request->action == 5) { //lead notes sales


      DB::table('lead_notesby_sales')->insert(
        [
          'QUERY_ID' => $request->QUERY_ID,
          'added_by' => Auth::user()->id,
          'message' => $request->txtMessageNoteReponse,
          'created_at' => date('Y-m-d H:i:s'),
          'date_schedule' => $request->shdate_input,

        ]
      );


      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageNoteReponse;
      $sechule_date_time = $request->shdate_input;
      $msg_desc = 'Reminder is added by Sales:  :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s');

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, $sechule_date_time);
      //----------------------------



      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }

    if ($request->action == 4) { //lead moves

      $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));

      $arr_data = DB::table('lead_moves')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->where('assign_to', $request->assign_user_id)->first();
      if ($arr_data == null) {

        $assign_user_name = AyraHelp::getUser($request->assign_user_id)->name;

        $stage_data = AyraHelp::getCurrentStageLEAD($request->QUERY_ID);

        DB::table('lead_moves')->insert(
          [
            'QUERY_ID' => $request->QUERY_ID,
            'assign_to' => $request->assign_user_id,
            'assign_by' => Auth::user()->id,
            'msg' => $request->assign_msg,
            'assign_remarks' => 'This lead tranfer to :' . $assign_user_name,
            'stage_name' => $stage_data->stage_name,
            'stage_id' => $stage_data->stage_id,
            'created_at' => date('Y-m-d H:i:s'),

          ]
        );


        DB::table('indmt_data')
          ->where('QUERY_ID', $request->QUERY_ID)
          ->update([
            'assign_to' => $request->assign_user_id
          ]);


        DB::table('lead_assign')
          ->where('QUERY_ID', $request->QUERY_ID)
          ->update([
            'assign_user_id' => $request->assign_user_id
          ]);


        //--------------------------------
        $QUERY_ID = $request->QUERY_ID;
        $user_id = Auth::user()->id;
        $msg = $request->assign_msg;

        $msg_desc = 'This is Lead moves to  :' . AyraHelp::getUser($request->assign_user_id)->name . " on " . date('j F Y H:i:s') . "by :" . AyraHelp::getUser($user_id)->name;

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
        //----------------------------



      }










      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }
    // order print permission 
    if ($request->action == 19) { //add notes

      //--------------------------------

      $orderArr = DB::table('qc_forms')->where('form_id', $request->QCID)->first();

      $msg = $request->txtMessageNoteReponse;
      $user_id = Auth::user()->id;
      $msg_desc = 'Order ID :' . $orderArr->order_id . "/" . $orderArr->subOrder . " is taken print by " . AyraHelp::getUser(Auth::user()->id)->name . " on " . date('j F Y H:i:s') . " for " . $msg;
      $this->saveLeadHistory($request->QCID, $user_id, $msg_desc, $msg);
      //----------------------------

      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }

    // order print permission 

    if ($request->action == 3) { //add notes
      $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));
      DB::table('lead_notes')->insert(
        [
          'QUERY_ID' => $request->QUERY_ID,
          'created_by' => Auth::user()->id,
          'msg' => $request->txtMessageNoteReponse,
          'expire_time' => $expire_time,
          'created_at' => date('Y-m-d H:i:s'),
          'status' => 1,

        ]
      );

      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageNoteReponse;
      $msg_desc = 'Note is added by :' . AyraHelp::getUser(Auth::user()->id)->name . " on " . date('j F Y H:i:s');

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg);
      //----------------------------

      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }
    //action=claim lead 15
    if ($request->action == 15) { //lead assign

      //this start 13
      // $month = date('m');
      // $assinedCM = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)       
      //   ->whereMonth('created_at', $month)
      //   ->whereYear('created_at', date('Y'))
      //   ->count();


      // $assinedCMConveted = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 5)
      //   ->orwhere('current_stage_id', 3)
      //   ->orwhere('current_stage_id', 6)
      //   ->orwhere('current_stage_id', 77)
      //   ->whereMonth('created_at', $month)
      //   ->whereYear('created_at', date('Y'))
      //   ->count();

      // $totRm = intVal($assinedCM) - intVal($assinedCMConveted);
      // if ($totRm >= 50) {
      //   $resp = array(
      //     'status' => 25,
      //     'msg' => 'Limit exceed',
      //   );
      //   return response()->json($resp);
      // }

      // $assinedC = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 1)
      //   ->whereDate('created_at', '>', "2021-07-31")
      //   ->count();

      // if ($assinedC >= 10) {
      //   $resp = array(
      //     'status' => 22,
      //     'msg' => 'Limit exceed Assigned Stage',
      //   );
      //   return response()->json($resp);
      // }

      // $assinedC = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 2)
      //   ->whereDate('created_at', '>', "2021-07-31")
      //   ->count();

      // if ($assinedC >= 10) {
      //   $resp = array(
      //     'status' => 22,
      //     'msg' => 'Limit exceed Qualified Stage',

      //   );
      //   return response()->json($resp);
      // }

      // $assinedC = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 3)
      //   ->whereDate('created_at', '>', "2021-07-31")
      //   ->count();

      // if ($assinedC >= 10) {
      //   $resp = array(
      //     'status' => 22,
      //     'msg' => 'Limit exceed Sampling Stage',
      //   );
      //   return response()->json($resp);
      // }

      // $assinedC = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 4)
      //   ->whereDate('created_at', '>', "2021-07-31")
      //   ->count();

      // if ($assinedC >= 20) {
      //   $resp = array(
      //     'status' => 22,
      //     'msg' => 'Limit exceed Negotiation Stage',
      //   );
      //   return response()->json($resp);
      // }
      // $assinedC = DB::table('lead_assign')
      //   ->where('assign_user_id', Auth::user()->id)
      //   ->where('current_stage_id', 4)
      //   ->whereDate('created_at', '>', "2021-07-31")
      //   ->count();

      //this start 13



      $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));


      $arr_data = DB::table('lead_assign')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->first();
      if ($arr_data == null) {






        DB::table('indmt_data')
          ->where('QUERY_ID', $request->QUERY_ID)
          ->update([
            'lead_status' => 2,
            'assign_to' => $request->assign_user_id,
            'assign_on' => date('Y-m-d H:i:s'),
            'assign_by' => Auth::user()->id,
            'remarks' => $request->assign_msg,
            'claim_by' =>  Auth::user()->id,
            'claim_at' => date('Y-m-d H:i:s'),
          ]);


        //--------------------------------
        $QUERY_ID = $request->QUERY_ID;
        $user_id = Auth::user()->id;
        $msg = $request->assign_msg;
        $at_stage_id = 1;
        $msg_desc = 'This lead is claim By :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s');

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, $at_stage_id); //----------------------------

        DB::table('st_process_action_4')->insert(
          [
            'ticket_id' => $request->QUERY_ID,
            'process_id' => 4,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Assign ',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => $request->assign_user_id,
            'statge_color' => 'completed',
          ]
        );
        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($request->QUERY_ID);

        //---------------------
        DB::table('lead_assign')->insert(
          [
            'QUERY_ID' => $request->QUERY_ID,
            'assign_user_id' => $request->assign_user_id,
            'assign_by' => Auth::user()->id,
            'msg' => $request->assign_msg,
            'expire_time' => $expire_time,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 1,
            'current_stage_id' => $curr_lead_stage->stage_id,
            'current_lead_stage_name' => $curr_lead_stage->stage_name,

          ]
        );

        //LoggedActicty
        $userID = Auth::user()->id;
        $LoggedName = AyraHelp::getUser($userID)->name;
        $eventName = "Lead Claim";
        $eventINFO = 'Lead claim by ' . $LoggedName . " Lead QUERY ID" . $request->QUERY_ID . " on " . date('j F Y H:i:s');
        $eventID = $request->QUERY_ID;
        $created_atA = date('Y-m-d H:i:s');
        $slug_name = url()->full();
        $this->LoggedActicty(
          $userID,
          $eventName,
          $eventINFO,
          $eventID,
          $created_atA,
          $slug_name

        );
        //LoggedActicty



      }


      // pusher 
      /*
      $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
      );
      $pusher = new Pusher\Pusher(
        '9dfaf98953e291c9be80',
        '79bcb9731c4b2951e422',
        '1057116',
        $options
      );
      $eventID = 'AJ_ID' . $request->assign_user_id;

      $msg_descA = 'Lead ID :' . $request->QUERY_ID . ' is claimed By ' . AyraHelp::getUser(Auth::user()->id)->name;

      $HTML = '<div class="m-section">     
      <div class="m-section__content">
        <table class="table table-sm m-table m-table--head-bg-brand">
          <thead class="thead-inverse">
            <tr>
            
              <th>QUERY ID</th>
              <th>Message</th>              
            </tr>
          </thead>';

      $HTML .= '<tbody>
            <tr>
             
              <td>' . $request->QUERY_ID . '</td>
              <td>' . $msg_descA . '</td>
             
            </tr>';

      $HTML . '   
          </tbody>
        </table>
      </div>
    </div>';

      $data['message'] = $HTML;
      $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
      // pusher 


      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }

    //action=claim lead 15

    if ($request->action == 1) { //lead assign

      $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));


      $arr_data = DB::table('lead_assign')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->first();
      if ($arr_data == null) {

        DB::table('lead_assign')->insert(
          [
            'QUERY_ID' => $request->QUERY_ID,
            'assign_user_id' => $request->assign_user_id,
            'assign_by' => Auth::user()->id,
            'msg' => $request->assign_msg,
            'expire_time' => $expire_time,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 1,

          ]
        );

        DB::table('indmt_data')
          ->where('QUERY_ID', $request->QUERY_ID)
          ->update([
            'lead_status' => 2,
            'assign_to' => $request->assign_user_id,
            'assign_on' => date('Y-m-d H:i:s'),
            'assign_by' => Auth::user()->id,
            'remarks' => $request->assign_msg,
          ]);


        //--------------------------------
        $QUERY_ID = $request->QUERY_ID;
        $user_id = Auth::user()->id;
        $msg = $request->assign_msg;
        $at_stage_id = 1;
        $msg_desc = 'This lead is asign to  :' . AyraHelp::getUser($request->assign_user_id)->name . " on " . date('j F Y H:i:s') . ' By ' . AyraHelp::getUser(Auth::user()->id)->name;

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, $at_stage_id); //----------------------------

        DB::table('st_process_action_4')->insert(
          [
            'ticket_id' => $request->QUERY_ID,
            'process_id' => 4,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Assign ',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => $request->assign_user_id,
            'statge_color' => 'completed',
          ]
        );

        //---------------------

      }


      // pusher 
      /*
      $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
      );
      $pusher = new Pusher\Pusher(
        '9dfaf98953e291c9be80',
        '79bcb9731c4b2951e422',
        '1057116',
        $options
      );
      $eventID = 'AJ_ID' . $request->assign_user_id;

      $msg_descA = 'A Lead is assigned to you ' . ' By ' . AyraHelp::getUser(Auth::user()->id)->name;

      $HTML = '<div class="m-section">     
      <div class="m-section__content">
        <table class="table table-sm m-table m-table--head-bg-brand">
          <thead class="thead-inverse">
            <tr>
            
              <th>QUERY ID</th>
              <th>Message</th>              
            </tr>
          </thead>';

      $HTML .= '<tbody>
            <tr>
             
              <td>' . $request->QUERY_ID . '</td>
              <td>' . $msg_descA . '</td>
             
            </tr>';

      $HTML . '   
          </tbody>
        </table>
      </div>
    </div>';

      $data['message'] = $HTML;
      $pusher->trigger('BO_CHANNEL', $eventID, $data);
      */
      // pusher 


      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }

    //28
    if ($request->action == 28) {
      DB::table('indmt_data')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update([
          'verified' => 1,
          'iIrrelevant_type' =>  $request->iIrrelevant_type,
          'remarks' => $request->txtMessageIreeReponse,
          'verified_on' => date('Y-m-d H:i:s'),
          'verified_by' => Auth::user()->id

        ]);

      DB::table('lead_Irrelevant')->insert(
        [
          'QUERY_ID' => $request->QUERY_ID,
          'iIrrelevant_type' => $request->iIrrelevant_type,
          'created_by' => Auth::user()->id,
          'msg' => $request->txtMessageIreeReponse,
          'created_at' => date('Y-m-d H:i:s'),
          'status' => 1,

        ]
      );
      //--------------------------------
      $QUERY_ID = $request->QUERY_ID;
      $user_id = Auth::user()->id;
      $msg = $request->txtMessageIreeReponse;
      $iIrrelevant_type_HTML = $request->iIrrelevant_type_HTML;
      $msg_desc = 'This lead is Verifed mark by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . " with  :" . $iIrrelevant_type_HTML;

      $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
      //----------------------------


      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $eventName = "Lead Verifiction";
      $eventINFO = 'Lead verify by ' . $LoggedName . " Lead QUERY ID" . $QUERY_ID . " on " . date('j F Y H:i:s');
      $eventID = $QUERY_ID;
      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();
      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
      //LoggedActicty


      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }

    //28
    if ($request->action == 2) { //ireeleavant



      if ($request->iIrrelevant_type == 5) {
        DB::table('indmt_data')
          ->where('QUERY_ID', $request->QUERY_ID)
          ->update([
            'lead_status' => 55,
            'iIrrelevant_type' =>  $request->iIrrelevant_type,
            'remarks' => $request->txtMessageIreeReponse,

          ]);
      } else {

        if ($request->iIrrelevant_type == 6) {
          DB::table('indmt_data')
            ->where('QUERY_ID', $request->QUERY_ID)
            ->update([
              'verified' => 1,
              'iIrrelevant_type' =>  $request->iIrrelevant_type,
              'remarks' => $request->txtMessageIreeReponse,
              'verified_on' => date('Y-m-d H:i:s'),
              'verified_by' => Auth::user()->id

            ]);
        } else {
          DB::table('indmt_data')
            ->where('QUERY_ID', $request->QUERY_ID)
            ->update([
              'lead_status' => 1,
              'iIrrelevant_type' => $request->iIrrelevant_type,
              'remarks' => $request->txtMessageIreeReponse,

            ]);
        }
      }




      DB::table('lead_Irrelevant')->insert(
        [
          'QUERY_ID' => $request->QUERY_ID,
          'iIrrelevant_type' => $request->iIrrelevant_type,
          'created_by' => Auth::user()->id,
          'msg' => $request->txtMessageIreeReponse,
          'created_at' => date('Y-m-d H:i:s'),
          'status' => 1,

        ]
      );

      if ($request->iIrrelevant_type == 6) { //verified
        //--------------------------------
        $QUERY_ID = $request->QUERY_ID;
        $user_id = Auth::user()->id;
        $msg = $request->txtMessageIreeReponse;
        $iIrrelevant_type_HTML = $request->iIrrelevant_type_HTML;
        $msg_desc = 'This lead is Verifed mark by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . " with  :" . $iIrrelevant_type_HTML;

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
        //----------------------------


      } else {
        //--------------------------------
        $QUERY_ID = $request->QUERY_ID;
        $user_id = Auth::user()->id;
        $msg = $request->txtMessageIreeReponse;
        $iIrrelevant_type_HTML = $request->iIrrelevant_type_HTML;
        $msg_desc = 'This lead is Irrelevant mark by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . " with reason type :" . $iIrrelevant_type_HTML;

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, NULL, NULL);
        //----------------------------

      }




      $resp = array(
        'status' => 1
      );
      return response()->json($resp);
    }
  }

  // getLeadListSalesOwn
  public function getLeadListSalesOwn(Request $request)
  {



    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $i = 0;
    if ($user_role == 'Admin') {
      $data_arr_data = DB::table('client_sales_lead')

        // ->where('assign_to', '=', Auth::user()->id)
        ->where('is_deleted', '=', 0)
        //->where('indmt_data.lead_status', '=', 0)
        ->orderBy('created_at', 'desc')

        ->get();
    } else {
      $data_arr_data = DB::table('client_sales_lead')

        ->where('assign_to', '=', Auth::user()->id)
        ->where('is_deleted', '=', 0)
        //->where('indmt_data.lead_status', '=', 0)
        ->orderBy('created_at', 'desc')

        ->get();
    }






    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);

      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }

      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }
      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }


      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;

      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';
        case 'OC':
          $QTYPE_ICON = 'M';

          break;
      }
      //  $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);

      // $value->lead_status,
      //----------------------------
      if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4) {
        switch ($value->lead_status) {
          case 0:
            $st_name = 'Fresh';
            break;
          case 1:
            $st_name = 'Irrelevant';
            break;
          case 4:
            $st_name = 'Unqualified';
            break;
        }
      } else {

        $curr_lead_stage = AyraHelp::getCurrentStageMYLEAD($value->QUERY_ID);
        $st_name = $curr_lead_stage->stage_name;
      }

      //----------------------------



      if ($value->last_note_updated != null) {
        $lastNote = date('j M Y', strtotime($value->last_note_updated));
      } else {
        $lastNote = 'N/A';
      }
      if ($value->follow_date != null) {
        $followdate = date('j M Y', strtotime($value->follow_date));
      } else {
        $followdate = 'N/A';
      }


      //$st_name='Unqualified';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => IS_NULL($value->ENQ_MESSAGE) ? '' : utf8_encode($value->ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'lead_status' => $st_name,
        'st_name' => $st_name,
        'last_note_added' => $lastNote,
        'follow_date' => $followdate,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'LeadOwner' => AyraHelp::getUser($value->assign_to)->name,

        'remarks' => $value->remarks,
      );
    }

    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'last_note_added' => true,
      'follow_date' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'LeadOwner' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  // getLeadListSalesOwn


  //getLeadList_SALES_END
  public function getLeadList_SALES_END(Request $request)
  {



    $i = 0;
    // $data_arr_data=DB::table('indmt_data')->orderBy('QUERY_ID','desc')->get();



    if ($request->action_name == 'viewUnQualifiedLead') {
      $data_arr_data = DB::table('indmt_data')
        ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
        ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
        ->where('indmt_data.lead_status', '=', 4)
        ->orderBy('lead_assign.created_at', 'desc')
        ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg', 'lead_assign.current_stage_id')
        ->get();
    } else {
      if ($request->action_name == 'viewTodayLeadLead') {
        $data_arr_data = DB::table('indmt_data')
          ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
          ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
          //->where('indmt_data.lead_status', '=', 0)
          ->whereDate('lead_assign.created_at', date('Y-m-d'))
          ->orderBy('lead_assign.created_at', 'desc')
          ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg', 'lead_assign.current_stage_id')
          ->get();
      } else {

        // $data_arr_data = DB::table('indmt_data')
        //   ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
        //   ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
        //   //->where('indmt_data.lead_status', '=', 0)
        //   //->where('indmt_data.lead_status', '!=', 4)
        //   ->orderBy('lead_assign.created_at', 'desc')
        //   ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
        //   ->get();

        $data_arr_data = DB::table('lead_assign')
          ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
          ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
          //->where('indmt_data.lead_status', '=', 0)
          ->where('indmt_data.lead_status', '!=', 4)
          ->orderBy('lead_assign.created_at', 'desc')
          ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg', 'lead_assign.current_stage_id')
          ->get();
      }
    }


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);

      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }

      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }
      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }

      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;

      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';

          break;
      }
      //  $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);

      //$value->lead_status,
      //----------------------------
      if ($value->lead_status == 4) {
        switch ($value->lead_status) {
          case 4:
            $st_name = 'disqualified';
            $stage_id = 55;
            break;
        }
      } else {
        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
        $st_name = $curr_lead_stage->stage_name;
        $stage_id = $curr_lead_stage->stage_id;
      }
      // $affected = DB::table('lead_assign')
      //         ->where('QUERY_ID', $value->QUERY_ID)
      //         ->update([
      //           'current_stage_id' => $curr_lead_stage->stage_id,
      //           'current_lead_stage_name' => $curr_lead_stage->stage_name,
      //         ]);


      //$curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      //$st_name = $curr_lead_stage->stage_name;
      //$st_name="UNKNOW";

      //----------------------------

      // LEAD_TYPE
      switch ($value->COUNTRY_ISO) {
        case 'IN':
          $LEAD_TYPE = 'INDIA';
          break;
        case 'India':
          $LEAD_TYPE = 'INDIA';
          break;

        default:
          $LEAD_TYPE = 'FOREIGN';
          break;
      }
      // LEAD_TYPE


      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => IS_NULL($value->ENQ_MESSAGE) ? '' : utf8_encode($value->ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'lead_status' => $value->lead_status,
        'LEAD_TYPE' => $LEAD_TYPE,
        'st_name' => $st_name,
        'st_id' => $stage_id,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'current_stage_id' => $value->current_stage_id,
      );
    }


    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'LEAD_TYPE' => true,
      'st_name' => true,
      'st_id' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'current_stage_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadList_SALES_END
  //get all lead 

  //getLeadList_LMLayout_LM_viewALLLead_NONEFRESH
  public function getLeadList_LMLayout_LM_viewALLLead_NONEFRESH(Request $request)
  {
    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'P')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr_data = DB::table('indmt_data')->where('lead_status', '!=', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->whereDate('DATE_TIME_RE_SYS','>=','2023-04-01')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LM_viewALLLead_NONEFRESH

  public function getLeadList_LMLayout_LM_viewALLLead(Request $request)
  {
    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'P')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  //get all lead 
  //getLeadList_LMLayout_LM_claim_assined
  public function getLeadList_LMLayout_LM_claim_assined(Request $request)
  {
    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'P')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->whereNotNull('assign_on')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();



    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $data_arr_dataAssigned = DB::table('lead_assign')->where('QUERY_ID', $value->QUERY_ID)->first();




      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => @$data_arr_dataAssigned->current_stage_id,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LM_claim_assined

  //getLeadList_LMLayout_LM_verifiedLead
  public function getLeadList_LMLayout_LM_verifiedLead(Request $request)
  {
    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'P')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('verified', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LM_verifiedLead

  //getLeadList_LMLayout_LMPhoneview
  public function getLeadList_LMLayout_LMPhoneview(Request $request)
  {
    $i = 0;
    $days = 7;
    $date = \Carbon\Carbon::today()->subDays($days);

    //whereDate('created_at', '>=', $date)->


    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'P')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'P')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    // $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', $date)->where('verified', 0)->where('QTYPE', 'P')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'P')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'P')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();



    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';
      if (is_null($value->intern_user_id)) {
        $strInter = "";
      } else {
        $strInter = @AyraHelp::getUser($value->intern_user_id)->name;
      }

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'intern_user_id' => $strInter,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LMPhoneview
  //getLeadList_LMLayout_LMBuyview
  public function getLeadList_LMLayout_LMBuyview(Request $request)
  {
    $i = 0;
    $days = 7;
    $date = \Carbon\Carbon::today()->subDays($days);

    //whereDate('created_at', '>=', $date)->


    // $data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('COUNTRY_ISO', 'like', 'IN%')->where('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    // $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', $date)->where('verified', 0)->where('COUNTRY_ISO', 'like', 'IN%')->where('QTYPE', 'B')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'B')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadList_LMLayout_LMBuyview
  //getLeadList_LMLayout_LMForeignview
  public function getLeadList_LMLayout_LMForeignview(Request $request)
  {
    $i = 0;

    //$data_arr_data = DB::table('indmt_data')->where('COUNTRY_ISO', '!=', 'IN')->where('COUNTRY_ISO', '!=', 'India')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    // $data_arr_data = DB::table('indmt_data')->where('COUNTRY_ISO', '!=', 'IN')->where('COUNTRY_ISO', '!=', 'India')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('COUNTRY_ISO', '!=', 'IN')->where('COUNTRY_ISO', '!=', 'India')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LMForeignview

  //getLeadList_LMLayout_LMInhouseview
  public function getLeadList_LMLayout_LMInhouseview(Request $request)
  {
    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->orwhere('data_source', 'INHOUSE-ENTRY')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('data_source', 'INHOUSE-ENTRY')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('data_source', 'INHOUSE-ENTRY')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $myCollection = collect($data_arr_data);
    $uniqueCollection = $myCollection->unique('SENDEREMAIL');
    $data_arr_dataA = $uniqueCollection->all();

    $myCollection = collect($data_arr_dataA);
    $uniqueCollection = $myCollection->unique('MOB');
    $data_arr_dataA = $uniqueCollection->all();



    $data_arr = array();
    foreach ($data_arr_dataA as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LMInhouseview

//getSamplesCountList
public function getSamplesCountList(Request $request)
{
  

  $data_arr_data = DB::table('tbl_samples_report')->where('is_active', 0)->orderBy('today_date', 'desc')->get();
  $data_arr = array();
  foreach ($data_arr_data as $key => $value) {

  $data_arr[] = array(
        'RecordID' => $value->id,
        'today_date' => $value->today_date,
        'added_count' => $value->added_count,
        'formulated_count' => $value->formulated_count,
        'dispatched_count' => $value->dispatched_count,
        'total_peding' => $value->total_peding
       
        
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'today_date' => true,
      'added_count' => true,
      'formulated_count' => true,
      'dispatched_count' => true,
      'total_peding' => true,
     
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);


}
//getSamplesCountList

  //getLeadList_LMLayout_LMDirectView
  public function getLeadList_LMLayout_LMDirectView(Request $request)
  {
    $i = 0;
    $days = 7;
    $date = \Carbon\Carbon::today()->subDays($days);

    //whereDate('created_at', '>=', $date)->

    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'W')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    // $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', $date)->where('verified', 0)->where('QTYPE', 'W')->where('COUNTRY_ISO', 'like', 'IN%')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'W')->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();




    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      if (is_null($value->intern_user_id)) {
        $strInter = "";
      } else {
        $strInter = AyraHelp::getUser($value->intern_user_id)->name;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,
        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'intern_user_id' => $strInter,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'QTYPE' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'intern_user_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LMLayout_LMDirectView

  // getLeadList_LMLayout
  public function getLeadList_LMLayout(Request $request)
  {

    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    // if($user_role=='Admin' || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==130 || Auth::user()->id==131){
    $i = 0;

    if (isset($request->action_name)) {
      if ($request->action_name == 'viewAllAssign') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 2)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewAllIreevant') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewUnQualifiedLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 4)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewHOLDLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewDUPLICATELead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('duplicate_lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }

      if ($request->action_name == 'BUY_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('QTYPE', 'B')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'DIRECT_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('QTYPE', 'W')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'PHONE_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('QTYPE', 'P')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'INHOUSED_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
    } else {

      $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2021-07-26')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }
      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }

      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }
      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;
      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';

          break;
      }

      // $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);
      //----------------------------
      if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4 || $value->lead_status == 55) {
        switch ($value->lead_status) {
          case 0:
            $st_name = 'Fresh Lead';
            break;
          case 1:
            $st_name = 'Irrelevant';
            break;
          case 4:
            $st_name = 'Unqualified';
            break;
          case 55:
            $st_name = 'HOLD';
            break;
        }
      } else {


        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
        $st_name = optional($curr_lead_stage)->stage_name;
      }

      //----------------------------
      // LEAD_TYPE
      switch ($value->COUNTRY_ISO) {
        case 'IN':
          $LEAD_TYPE = 'INDIA';
          break;
        case 'India':
          $LEAD_TYPE = 'INDIA';
          break;

        default:
          $LEAD_TYPE = 'FOREIGN';
          break;
      }
      // LEAD_TYPE

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';
      $calldata_arr = DB::table('lead_datacall')->where('QUERY_ID', $value->QUERY_ID)->get();
      if (count($calldata_arr) > 0) {
        $call_data_flag = 1;
      } else {
        $call_data_flag = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $LEAD_TYPE,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => $call_data_flag
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  // getLeadList_LMLayout

  public function getLeadList05AUG(Request $request)
  {
    $i = 0;
    $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => 1,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' =>  utf8_encode($value->ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => 1,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 1,
        'LEAD_TYPE' => 1,

        'lead_status' => 1,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadList_LeadManger_VIEW_Export
  public function getLeadList_LeadManger_VIEW_Export(Request $request)
  {
    $i = 0;

    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', '!=', 'IN')->where('COUNTRY_ISO', '!=', 'India')->where('data_source', '!=', 'INHOUSE-ENTRY')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('COUNTRY_ISO', '!=', 'IN')->where('COUNTRY_ISO', '!=', 'India')->where('data_source', '!=', 'INHOUSE-ENTRY')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LeadManger_VIEW_Export
  //getLeadList_LeadManger_VIEW_WPB_claimAssined
  public function getLeadList_LeadManger_VIEW_WPB_claimAssined(Request $request)
  {
    $i = 0;
    $days = 20;
    $date = \Carbon\Carbon::today()->subDays($days);

    //whereDate('created_at', '>=', $date)->

    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('lead_status', 0)->where('duplicate_lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //nw $data_arr_data = DB::table('indmt_data')->whereNotNull('claim_by')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('indmt_data')->whereNotNull('assign_to')->whereNotNull('assign_on')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    // $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', $date)->where('verified', 0)->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $myCollection = collect($data_arr_data);
    $uniqueCollection = $myCollection->unique('SENDEREMAIL');
    $data_arr_dataA = $uniqueCollection->all();


    $myCollection = collect($data_arr_dataA);
    $uniqueCollection = $myCollection->unique('MOB');
    $data_arr_dataA = $uniqueCollection->all();



    $data_arr = array();
    foreach ($data_arr_dataA as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      // if ($value->lead_status == 4) {
      //   switch ($value->lead_status) {
      //     case 4:
      //       $st_name = 'disqualified';
      //       break;
      //   }
      // } else {
      //   $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      //   $st_name = $curr_lead_stage->stage_name;
      // }

      // $affected = DB::table('indmt_data')
      //         ->where('QUERY_ID',  $value->QUERY_ID)
      //         ->update(['lead_stage_name' => $st_name]);




      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $value->lead_stage_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => AyraHelp::getUser($value->assign_to)->name,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LeadManger_VIEW_WPB_Intern
  public function getLeadList_LeadManger_VIEW_WPB_Intern(Request $request)
  {

    //assined
    $leadCountTodayGet = DB::table('indmt_data')->where('intern_user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->count();
    //echo $leadCountTodayGet;
    if ($leadCountTodayGet < 16) {
      //-----------------------------start
      $data_arr_dataAjMData = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->count();

      // $data_arr_dataAjMData = DB::table('indmt_data')->where('lead_status', 0)->where('QTYPE','!=', 'B')->whereNull('intern_user_id')->count();
      // echo "<pre>";
      // print_r($data_arr_dataAjMData);
      // die;
      $data_arrInterData = DB::table('lead_assigned_list_intern')->where('user_id', Auth::user()->id)->first();
      $maxData = $data_arrInterData->max_id;
      $restLead = intVal($data_arr_dataAjMData);
      $assinedLeadCount = $maxData - $restLead;

      if ($assinedLeadCount > 0) {
        // data
        $daysA = 1;
        $dateAA = \Carbon\Carbon::today()->subDays($daysA);

        $data_arr_dataADara = DB::table('indmt_data')
          // ->whereDate('created_at', '<=', $dateAA)
          ->where('verified', 0)
          ->whereNull('intern_user_id')
          ->where('lead_status', 0)
          ->where('QTYPE', '!=', 'B')
          ->limit($assinedLeadCount)
          ->where('COUNTRY_ISO', 'like', 'IN%')
          ->orderBy('created_at', 'desc')->get();


        foreach ($data_arr_dataADara as $key => $rowData) {

          $affected = DB::table('indmt_data')
            ->where('QUERY_ID', $rowData->QUERY_ID)
            ->update(['intern_user_id' => Auth::user()->id]);
        }
        // data
      }
      //assined
      //-------------------stop

    }





    // list
    $i = 0;




    $data_arr_dataAj = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();





    $data_arr = array();
    foreach ($data_arr_dataAj as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);

    // list








  }


  //getLeadList_LeadManger_VIEW_WPB_Intern
  public function getLeadList_LeadManger_VIEW_WPB_InternAA(Request $request)
  {

    //assined
    $data_arr_dataAjMData = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->count();
    $data_arrInterData = DB::table('lead_assigned_list_intern')->where('user_id', Auth::user()->id)->first();
    $maxData = $data_arrInterData->max_id;
    $restLead = intVal($data_arr_dataAjMData);
    $assinedLeadCount = $maxData - $restLead;
    if ($assinedLeadCount > 0) {
      // data 
      $daysA = 1;
      $dateAA = \Carbon\Carbon::today()->subDays($daysA);

      $data_arr_dataADara = DB::table('indmt_data')
        // ->whereDate('created_at', '<=', $dateAA)
        ->where('verified', 0)
        ->whereNull('intern_user_id')
        ->where('lead_status', 0)
        ->where('QTYPE', '!=', 'B')
        ->limit($assinedLeadCount)
        ->where('COUNTRY_ISO', 'like', 'IN%')
        ->orderBy('created_at', 'desc')->get();


      foreach ($data_arr_dataADara as $key => $rowData) {

        $affected = DB::table('indmt_data')
          ->where('QUERY_ID', $rowData->QUERY_ID)
          ->update(['intern_user_id' => Auth::user()->id]);
      }
      // data  
    }
    //assined

    // list 
    $i = 0;




    $data_arr_dataAj = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();





    $data_arr = array();
    foreach ($data_arr_dataAj as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);

    // list 








  }
  public function getLeadList_LeadManger_VIEW_WPB_InternA(Request $request)
  {


    $data_arr_dataAjMData = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->orderBy('DATE_TIME_RE_SYS', 'desc')->count();

    if ($data_arr_dataAjMData <= 0) {
      $days = 15;
      $daysA = 15;
      $date = \Carbon\Carbon::today()->subDays($days);
      $dateAA = \Carbon\Carbon::today()->subDays($daysA);


      $data_arrInterData = DB::table('lead_assigned_list_intern')->where('user_id', Auth::user()->id)->first();
      $maxID = $data_arrInterData->max_id;
      $pending_countData = $data_arrInterData->pending_count;

      $CountTOAssinged = intVal($maxID) - intVal($data_arrInterData->pending_count);



      if ($CountTOAssinged > 0) {

        $data_arr_dataAjM = DB::table('indmt_data')->where('intern_user_id', Auth::user()->id)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
        $meA = intVal($CountTOAssinged) - intVal(count($data_arr_dataAjM));
        $data_arr_dataADara = DB::table('indmt_data')->whereDate('created_at', '<=', $dateAA)->where('verified', 0)->whereNull('intern_user_id')->where('lead_status', 0)->limit($meA)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

        foreach ($data_arr_dataADara as $key => $rowData) {

          $affected = DB::table('indmt_data')
            ->where('QUERY_ID', $rowData->QUERY_ID)
            ->update(['intern_user_id' => Auth::user()->id]);
        }


        $affected = DB::table('lead_assigned_list_intern')
          ->where('user_id', Auth::user()->id)
          ->update(['pending_count' => $CountTOAssinged]);
      }
    }
    $i = 0;



    //whereDate('created_at', '>=', $date)->

    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('lead_status', 0)->where('duplicate_lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_dataAj = DB::table('indmt_data')->where('lead_status', 0)->where('intern_user_id', Auth::user()->id)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    // $myCollection = collect($data_arr_data);
    // $uniqueCollection = $myCollection->unique('SENDEREMAIL');
    // $data_arr_dataA = $uniqueCollection->all();


    // $myCollection = collect($data_arr_dataA);
    // $uniqueCollection = $myCollection->unique('MOB');
    // $data_arr_dataA = $uniqueCollection->all();



    $data_arr = array();
    foreach ($data_arr_dataAj as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LeadManger_VIEW_WPB_Intern

  //getLeadList_LeadManger_VIEW_WPB
  public function getLeadList_LeadManger_VIEW_WPB(Request $request)
  {
    $i = 0;
    $days = 30;
    $date = \Carbon\Carbon::today()->subDays($days);


    $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();





    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';



      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
        'intern_user_id' => ''
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'intern_user_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function getLeadList_LeadManger_VIEW_WPB_OKAJ16aug(Request $request)
  {
    $i = 0;
    $days = 30;
    $date = \Carbon\Carbon::today()->subDays($days);

    //whereDate('created_at', '>=', $date)->

    //$data_arr_data = DB::table('indmt_data')->orwhere('QTYPE', 'W')->orwhere('QTYPE', 'P')->orwhere('QTYPE', 'B')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    //$data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('lead_status', 0)->where('duplicate_lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    if (Auth::user()->id = 134) {
      $data_arr_data = DB::table('indmt_data')->where('verified', 0)->where('QTYPE', 'B')->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    } else {
      $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', $date)->where('verified', 0)->where('lead_status', 0)->where('COUNTRY_ISO', 'like', 'IN%')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }



    $myCollection = collect($data_arr_data);
    $uniqueCollection = $myCollection->unique('SENDEREMAIL');
    $data_arr_dataA = $uniqueCollection->all();


    $myCollection = collect($data_arr_dataA);
    $uniqueCollection = $myCollection->unique('MOB');
    $data_arr_dataA = $uniqueCollection->all();



    $data_arr = array();
    foreach ($data_arr_dataA as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      if (is_null($value->intern_user_id)) {
        $strInter = "";
      } else {
        $strInter = @AyraHelp::getUser($value->intern_user_id)->name;
      }

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => IS_NULL($value->SENDEREMAIL) ? '' : $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1,
        'email_sent' =>  $value->email_sent,
        'sms_sent' =>  $value->sms_sent,
        'intern_user_id' => $strInter
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'email_sent' => true,
      'sms_sent' => true,
      'intern_user_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_LeadManger_VIEW_WPB

  public function getLeadList_ADMIN_VIEW_W(Request $request)
  {
    $i = 0;

    $data_arr_data = DB::table('indmt_data')->where('QTYPE', 'W')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    //$data_arr_data = DB::table('indmt_data')->where('lead_status',0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => 'Ajay',
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $value->lead_status,
        'AssignName' => 1,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 1
      );
    }
    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_v3Irrelevant
  public function getLeadList_v3Irrelevant(Request $request)
  {


    $i = 0;

    $data_arr_data = DB::table('indmt_data')->where('lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();





    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      // $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);







      //$curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      //$st_name = optional($curr_lead_stage)->stage_name;
      $st_name = 'Irrelevant';

      //----------------------------


      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';





      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => '',
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_v3Irrelevant
  // getLeadList_v3disQualified
  public function getLeadList_v3disQualified(Request $request)
  {
    $i = 0;
    $data_arr_data = DB::table('indmt_data')->where('lead_status', 4)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      $st_name = optional($curr_lead_stage)->stage_name;
      //----------------------------
      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  // getLeadList_v3disQualified
  //getLeadList_v3Hold_Intern
  public function getLeadList_v3Hold_Intern(Request $request)
  {
    $i = 0;
    $data_arr_data = DB::table('indmt_data')->where('intern_user_id', Auth::user()->id)->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      $st_name = optional($curr_lead_stage)->stage_name;

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_v3Hold_Intern

  //getLeadList_v3Hold
  public function getLeadList_v3Hold(Request $request)
  {
    $i = 0;
    $data_arr_data = DB::table('indmt_data')->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      $st_name = optional($curr_lead_stage)->stage_name;

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_v3Hold
  //getLeadList_v3Duplicate
  public function getLeadList_v3Duplicate(Request $request)
  {

    $i = 0;

    $data_arr_data = DB::table('indmt_data')->where('lead_status', 0)->where('duplicate_lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();

    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      //$AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);



      $st_name = 'Fresh';




      //----------------------------


      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';





      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => '',
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getLeadList_v3Duplicate
  //getLeadList_v3Assined
  public function getLeadList_v3Assined(Request $request)
  {

    $i = 0;

    // $data_arr_data = DB::table('indmt_data')->where('lead_status', 2)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    $data_arr_data = DB::table('lead_assign')
      ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
      // ->where('lead_assign.assign_user_id', '=', $userID)
      //->where('indmt_data.lead_status', '=', 0)
      ->where('indmt_data.lead_status', '!=', 4)
      ->orderBy('lead_assign.created_at', 'desc')
      ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
      ->get();


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
      $st_name = optional($curr_lead_stage)->stage_name;
      //----------------------------
      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';




      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $value->QTYPE,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $value->data_source,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $value->COUNTRY_ISO,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => 0
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadList_v3Assined
  public function getLeadList(Request $request)
  {

    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    // if($user_role=='Admin' || Auth::user()->id==77 || Auth::user()->id==90 || Auth::user()->id==130 || Auth::user()->id==131){


    $i = 0;

    if (isset($request->action_name)) {
      if ($request->action_name == 'viewAllAssign') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 2)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewAllIreevant') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewUnQualifiedLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 4)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewHOLDLead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 55)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'viewDUPLICATELead') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('duplicate_lead_status', 1)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }


      if ($request->action_name == 'BUY_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'B')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'DIRECT_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'W')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'PHONE_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'P')->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      if ($request->action_name == 'INHOUSED_LEAD') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }

      // LEAD_IM1
      if ($request->action_name == 'LEAD_IM1') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('data_source', 'INDMART-9999955922@API_1')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      // LEAD_IM1
      // LEAD_IM2
      if ($request->action_name == 'LEAD_IM2') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('data_source', 'INDMART-8929503295@API_2')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      // LEAD_IM2
      // LEAD_IM3
      if ($request->action_name == 'LEAD_IM3') {
        $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->whereNull('ENQ_RECEIVER_MOB')->orwhere('ENQ_RECEIVER_MOB', 'False')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
      }
      // LEAD_IM3

    } else {
      $data_arr_data = DB::table('indmt_data')->whereDate('created_at', '>=', '2020-05-20')->where('lead_status', 0)->where('QTYPE', 'W')->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->get();
    }


    $data_arr = array();
    foreach ($data_arr_data as $key => $value) {
      $i++;
      $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
      $lsource = "";

      $LS = $value->data_source;
      if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
        $lsource = 'IM1';
      }
      if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
        $lsource = 'IM2';
      }
      if ($LS == 'TRADEINDIA-8850185@API_3' || $LS == 'TRADEINDIA-8850185@API_3') {
        $lsource = 'TD1';
      }

      if ($LS == 'INHOUSE-ENTRY') {
        $lsource = 'IN';
      }
      $QTYPE = IS_NULL($value->QTYPE) ? 'NA' : $value->QTYPE;
      switch ($QTYPE) {
        case 'NA':
          $QTYPE_ICON = '';
          break;
        case 'W':
          $QTYPE_ICON = 'D';
          break;
        case 'P':
          $QTYPE_ICON = 'P';
          break;
        case 'B':
          $QTYPE_ICON = 'B';

          break;
      }

      // $leadNoteCount=AyraHelp::getLeadCountWithNoteID($value->QUERY_ID);
      //----------------------------
      if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4 || $value->lead_status == 55) {
        switch ($value->lead_status) {
          case 0:
            $st_name = 'Fresh Lead';
            break;
          case 1:
            $st_name = 'Irrelevant';
            break;
          case 4:
            $st_name = 'Unqualified';
            break;
          case 55:
            $st_name = 'HOLD';
            break;
        }
      } else {


        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
        $st_name = optional($curr_lead_stage)->stage_name;
      }

      //----------------------------
      // LEAD_TYPE
      switch ($value->COUNTRY_ISO) {
        case 'IN':
          $LEAD_TYPE = 'INDIA';
          break;
        case 'India':
          $LEAD_TYPE = 'INDIA';
          break;

        default:
          $LEAD_TYPE = 'FOREIGN';
          break;
      }
      // LEAD_TYPE

      $ENQ_MESSAGE = substr(optional($value)->ENQ_MESSAGE, 0, 30) . '...';

      $calldata_arr = DB::table('lead_datacall')->where('QUERY_ID', $value->QUERY_ID)->get();
      if (count($calldata_arr) > 0) {
        $call_data_flag = 1;
      } else {
        $call_data_flag = 0;
      }



      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => $value->QUERY_ID,
        'QTYPE' => $QTYPE_ICON,
        'SENDERNAME' => IS_NULL($value->SENDERNAME) ? '' : $value->SENDERNAME,
        'SENDEREMAIL' => $value->SENDEREMAIL,
        'SUBJECT' => $value->SUBJECT,
        'DATE_TIME_RE' => $value->DATE_TIME_RE,
        'GLUSR_USR_COMPANYNAME' => IS_NULL($value->GLUSR_USR_COMPANYNAME) ? '' : $value->GLUSR_USR_COMPANYNAME,
        'MOB' => $value->MOB,
        'created_at' => $value->DATE_TIME_RE,
        'COUNTRY_FLAG' => $value->COUNTRY_FLAG,
        'ENQ_MESSAGE' => utf8_encode($ENQ_MESSAGE),
        'ENQ_ADDRESS' => $value->ENQ_ADDRESS,
        'ENQ_CITY' => IS_NULL($value->ENQ_CITY) ? '' : $value->ENQ_CITY,
        'ENQ_STATE' => IS_NULL($value->ENQ_STATE) ? '' : $value->ENQ_STATE,
        'PRODUCT_NAME' => IS_NULL($value->PRODUCT_NAME) ? '' : $value->PRODUCT_NAME,
        'COUNTRY_ISO' => $value->COUNTRY_ISO,
        'EMAIL_ALT' => $value->EMAIL_ALT,
        'MOBILE_ALT' => $value->MOBILE_ALT,
        'PHONE' => $value->PHONE,
        'PHONE_ALT' => $value->PHONE_ALT,
        'IM_MEMBER_SINCE' => $value->IM_MEMBER_SINCE,
        'data_source' => $lsource,
        'data_source_ID' => $value->data_source_ID,
        'updated_by' => $value->updated_by,
        'lead_check' => $value->lead_check,
        'st_name' => $st_name,
        'LEAD_TYPE' => $LEAD_TYPE,

        'lead_status' => $st_name,
        'AssignName' => $AssignName,
        'AssignID' => $value->assign_to,
        'remarks' => $value->remarks,
        'call_dataFlag' => $call_data_flag
      );
    }




    $JSON_Data = json_encode($data_arr);

    $columnsDefault = [
      'RecordID' => true,
      'QUERY_ID' => true,
      'SENDERNAME' => true,
      'SENDEREMAIL' => true,
      'SUBJECT' => true,
      'DATE_TIME_RE' => true,
      'GLUSR_USR_COMPANYNAME' => true,
      'MOB' => true,
      'created_at' => true,
      'COUNTRY_FLAG' => true,
      'ENQ_MESSAGE' => true,
      'ENQ_ADDRESS' => true,
      'ENQ_CITY' => true,
      'ENQ_STATE' => true,
      'PRODUCT_NAME' => true,
      'COUNTRY_ISO' => true,
      'EMAIL_ALT' => true,
      'MOBILE_ALT' => true,
      'PHONE' => true,
      'PHONE_ALT' >= true,
      'IM_MEMBER_SINCE' => true,
      'data_source' => true,
      'data_source_ID' => true,
      'updated_by' => true,
      'lead_check' => true,
      'lead_status' => true,
      'st_name' => true,
      'LEAD_TYPE' => true,
      'remarks' => true,
      'AssignName' => true,
      'AssignID' => true,
      'call_dataFlag' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function updateLeadData(Request $request)
  {
    // print_r($request->all());
    // die;
    $rmk = $request->remarks;

    DB::table('indmt_data')
      ->where('QUERY_ID', $request->QUERY_ID)
      ->update([
        'GLUSR_USR_COMPANYNAME' => $request->GLUSR_USR_COMPANYNAME,
        'SENDERNAME' => $request->SENDERNAME,
        'MOB' => $request->MOB,
        'SENDEREMAIL' => $request->SENDEREMAIL,
        'PRODUCT_NAME' => $request->PRODUCT_NAME,
        'MOBILE_ALT' => $request->MOBILE_ALT,
        'EMAIL_ALT' => $request->EMAIL_ALT,
        'ENQ_ADDRESS' => $request->ENQ_ADDRESS,
        'ENQ_CITY' => $request->ENQ_CITY,
        'ENQ_STATE' => $request->ENQ_STATE,
        'updated_by' => Auth::user()->id,
        'remarks' => $rmk,

      ]);

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function editLead($leadID)
  {

    $users_data = DB::table('indmt_data')->where('QUERY_ID', $leadID)->first();

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => $users_data];
    return $theme->scope('lead.edit_new_lead', $data)->render();
  }



  public function getLeadReports_Dist()
  {






    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.leadReports_dist', $data)->render();
  }


  //getAllSalesuserClientAppend
  public function getAllSalesuserClientAppend(Request $request)
  {


    $html = "";
    $salesUserID = $request->salesUserID;
    $users = DB::table('clients')
      ->where('added_by', $salesUserID)
      ->where('have_order', 1)
      ->get();
      $i=0;
    foreach ($users as $key => $rowData) {
      $i++;
      $clientid = $rowData->id;
      $clientCount = DB::table('qc_forms')
        ->where('client_id', $clientid)
        ->where('is_deleted', 0)
        ->count();
      $SampleCount = DB::table('samples')
        ->where('client_id', $clientid)
        ->where('is_deleted', 0)
        ->count();


      $html .= '<tr>
<th scope="row">'.$i.'</th>
<td>
    <label class="m-checkbox">
        <input name="clientArr[]" value="' . $rowData->id . '" type="checkbox"> Company:<b>' . $rowData->company . '</b>  Brand: <b>' . $rowData->brand . '</b> <br>
        Name:<b>' . $rowData->firstname . '</b>
        <span></span>
    </label>
    <br>
    Email:' . $rowData->email . '
    <br>
    Phone:' . $rowData->phone.'

  
</td>

<td>Order:' . $clientCount . '</td>
<td>Samples:' . $SampleCount . '</td>
<td><div class="form-group m-form__group">

<input type="text" name="clientNoteArr[]" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Notess">
</div></td>

</tr>';
    }




    echo $html;
  }
  //getAllSalesuserClientAppend
  //setClientTransferSave
  public function setClientTransferSave(Request $request)
  { //same note allowed
    // print_r($request->all());
    $transferFromUserID = $request->transferFromUserID;
    $clientArr = $request->clientArr;
    $clientNoteArr = $request->clientNoteArr;
    $transferToUserID = $request->transferToUserID;
    $uni_notes = $request->uni_notes;
    $message = $uni_notes;
    //code 
    foreach ($clientArr as $key => $rowData) {
      $clid = $rowData;
      $spNote = $clientNoteArr[$key];
      $client_arr = AyraHelp::getClientbyidWithDel($clid);
      $user_from = $client_arr->added_by;
      $user_to = $transferToUserID;

      $transEmail = AyraHelp::getUser($user_to)->email;
      $transName = AyraHelp::getUser($user_to)->name;
      $transFromName = AyraHelp::getUser($transferFromUserID)->name;
      $transFromEmail = AyraHelp::getUser($transferFromUserID)->email;
      $user_from_name = AyraHelp::getUser($user_from)->name;

      //client updated
      DB::table('clients')
        ->where('id', $clid)
        ->update([
          'added_by' => $user_to,
          'client_owner_too' => $user_from,
          'added_name' => $transName,
        ]);

        $clinetArr = DB::table('clients')
        ->where('id', $clid)
            ->first();


      //client updated
      //sample updated
      DB::table('samples')
        ->where('client_id', $clid)
        ->update([
          'created_by' => $user_to
        ]);

      //sample updated


      //notes updated
      DB::table('client_notes')
        ->where('clinet_id', $clid)
        ->update([
          'user_id' => $user_to
        ]);

      //notes updated


      //orders updated
      DB::table('qc_forms')
        ->where('client_id', $clid)
        ->update([
          'created_by' => $user_to,
          'client_owner_too' => $user_from,
          'created_by_name' => $user_from_name,
        
        ]);

        //insert to be sent mail 
      
        DB::table('lead_transfers')->insert([
          'client_id' => $clid,
          'client_email' => $clinetArr->email,
          'client_phone' => $clinetArr->phone,
          'whom' => $transFromName,
          'whom_to' => $transName,
          'when_date' => date('Y-m-d H:i:s'),
          'client_message' => $message,
          'email_sent' =>0,
          'sms_sent' => 0,
          'task_done' => 0
         
          
      ]);


      DB::table('payment_recieved_from_client')
      ->where('client_id', $clid)
      ->update([
        'transfer_to' => $user_to,
        'transfer_to_name' => $user_from_name,
        'transfer_at' => date('Y-m-d H:i:s'),
      ]);


        //insert  to be sent mail
      //orders updated

      //UPDATE `clients` SET `added_by` = '100' WHERE `clients`.`id` = 1808;
      //UPDATE `samples` SET `created_by` = '100' WHERE `samples`.`client_id` = 1808;
      //UPDATE `client_notes` SET `user_id` = '100' WHERE `client_notes`.`clinet_id` = 1808;
      //UPDATE `qc_forms` SET `created_by` = '100' WHERE `qc_forms`.`client_id` = 1808;

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $AssineTo = AyraHelp::getUser($user_to)->name;

      $eventName = "Client Transfer BULK";
      $eventINFO = 'Client Full Transfer of client:' . $client_arr->company . " and Assined to  " . $AssineTo . " by " . $LoggedName . "<br><b>:" . $message . "</b>";
      $eventID = $clid;
      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();
      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
      //LoggedActicty

      $emailMsg[] = $eventINFO;
    }
    //code 
    $html = '<h2>Lead Transfer Information</h2>

  <table border="1">
    <tr>
      <th>Details</th>
      <th>Transfer To</th>
      <th>Transfer On</th>     
      <th>Transfer From</th>     
    </tr>';



    foreach ($emailMsg as $key => $row) {

      $html .= ' <tr>
    <td>' . $row . '</td>
    <td>' . $transName . '</td>
    <td>' . date('jF Y H:iA') . '</td>
    <td>' . $transFromName . '</td>
    
  </tr>
 ';
    }
    $html .= '</table>';

    $body = $html;
    $to = $transEmail;
    $subject = "Client Transfer Notification Bulk";
    $this->sendEmailSendgridWaysBulk($to, $subject, $body);
//    echo "done";
    return redirect()->back()->with('success', 'Successfully Submitted');   


  }
  //setClientTransferSave

  //combinedLeadTransfer
  public function combinedLeadTransfer()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'sample_data' => ''

    ];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.combinedLeadTransfer', $data)->render();
    } else {
      abort(401);
    }
  }

  //combinedLeadTransfer

  public function getLeadInboutCallGrapgh()
  {
    $lava = new Lavacharts; // See note below for Laravel

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.leadInboud_callReportsgrapgh', $data)->render();
  }

  //getPaymentOrdersListWithFilter
 
  public function getPaymentOrdersListWithFilterA(Request $request)
  {
     $dateme = date('Y-m-d', strtotime($request->dateSelected));
     $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
    $order_for=$request->order_for;
    $HTD="";
    $HTML="";
    if($order_for==1){
      $HTML = '
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
         
         ';
           $startMonth=date('m', strtotime($request->dateSelected));
           $stopMonth=date('m', strtotime($request->dateSelectedTo));
           $year=date('Y', strtotime($request->dateSelectedTo));
           
        for ($i=$startMonth; $i <=$stopMonth ; $i++) { 
            // echo $i;
            
            $amt=AyraHelp::getPaymentRecFilter($startMonth,$year);


            $monthNum = $i;
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
            $monthName; // Output: May
            $HTD .='<td>'.$monthName.'-'.$amt.'</td>';
        }
        // echo $HTD;
        // die;

      if ($request->user_id == "ALL") {
        $users=AyraHelp::getSalesAgentAdmin() ;
        foreach ($users as $key => $rowData) {
            $HTML .='<tr>
            <td>
            '.$rowData->name.'
            </td>
            '.$HTD.'
           
            </tr>'; 
        }
        $HTML .='</table>';

      } else {
        echo $request->user_id;
      }
    }
   

    echo $HTML;
   
  }
  //getPaymentOrdersListWithFilter
  public function getLeadAssinDateWiseDataOk(Request $request)
  {
     $dateme = date('Y-m-d', strtotime($request->dateSelected));
     $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
  

    if ($request->assinedby == "ALL" && $request->lead_status == "ALL") {
      $users_data = DB::table('indmt_data')->whereDate('created_at', '>=', $dateme)->whereDate('created_at', '<=', $datemeTo)->limit(10000)->get();
      // print_r($users_data);
      // die;
      // echo "444";
      // die;

    }else{
      if ($request->assinedby == "ALL") {
        $users_data = DB::table('indmt_data')->where('lead_status',$request->lead_status)->whereDate('created_at', '>=', $dateme)->limit(10000)->whereDate('created_at', '<=', $datemeTo)->get();

      }else{
        $users_data = DB::table('indmt_data')->where('assign_to', $request->assinedby)->where('lead_status',$request->lead_status)->limit(10000)->whereDate('created_at', '>=', $dateme)->whereDate('created_at', '<=', $datemeTo)->get();

      }
      

    }
    // print_r($users_data);
    // die;
    // die;

    $HTML = '<div class="m-section">
    <div class="m-section__content">
      <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
          <tr>
            <th>#</th>
            <th>QUERY ID</th>
            <th>Name </th>
            <th>PHONE </th>
            <th>Assign To </th>
            <th>Assign By </th>
            <th>Assigned on </th>
            <th>Action </th>
          </tr>
        </thead>
        <tbody>';

  $i = 0;
  foreach ($users_data as $key => $row) {
    $i++;

    $assign_to = @AyraHelp::getUser($row->assign_to)->name;
    $assign_by = @AyraHelp::getUser($row->assign_by)->name;

   //$lead_data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();



    $HTML .= '<tr>
          <th scope="row">' . $i . '</th>
          <td>' . intVal($row->QUERY_ID) . '
         
           </td>
          <td>' . $row->SENDERNAME . '</td>
          <td>' . $row->MOB . '</td>
          <td>' . $assign_to . '</td>
          <td>' . $assign_by . '</td>

          <td>' . date('j F Y H:i:s ', strtotime($row->created_at)) . '</td>
          <td><a href="javascript::void(0)" onclick="viewAllINDMartData(' . $row->QUERY_ID . ')"> <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VIEW</span></a></td>

        </tr>';
  }
  $HTML .= '
                  </tbody>
                </table>
              </div>
            </div>';
  echo $HTML;

  }
  //getLeadAssinDateWiseData
  public function getLeadAssinDateWiseData(Request $request)
  {
    //ss
    // //data 
    // $users_data = DB::table('lead_assign')->whereMonth('created_at', '08')->get();
    // // print_r(count($users_data));
    // // die;
    // $i = 0;
    // foreach ($users_data as $key => $row) {
    //   $i++;

    //   $assign_to = AyraHelp::getUser($row->assign_user_id)->name;
    //   $assign_by = AyraHelp::getUser($row->assign_by)->name;
    //   $lead_data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();
    //   DB::table('tbl_leadassinede_data')->insert(
    //     [
    //       'QUERY_ID' => $row->QUERY_ID,
    //       'name' => $lead_data_arr->SENDERNAME,
    //       'phone' =>$lead_data_arr->MOB,
    //       'assined_to' => $assign_to,
    //       'assined_by' => $assign_by,
    //       'assined_on' => $row->created_at,

    //     ]
    //   );
    //   echo $i;
    //   echo "<br>";


    // }
    // //data 
    // die;

    $dateme = date('Y-m-d', strtotime($request->dateSelected));
    $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));

    //$users_data = DB::table('lead_assign')->whereDate('created_at', $dateme)->get();
    if ($request->assinedby == "ALL") {

      $users_data = DB::table('lead_assign')->whereDate('created_at', '>=', $dateme)->whereDate('created_at', '<=', $datemeTo)->get();
    } else {
      $users_data = DB::table('lead_assign')->where('assign_by', $request->assinedby)->whereDate('created_at', '>=', $dateme)->whereDate('created_at', '<=', $datemeTo)->get();
    }



    $HTML = '<div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr>
              <th>#</th>
              <th>QUERY ID</th>
              <th>Name </th>
              <th>PHONE </th>
              <th>Assign To </th>
              <th>Assign By </th>
              <th>Assigned on </th>
              <th>Action </th>
            </tr>
          </thead>
          <tbody>';

    $i = 0;
    foreach ($users_data as $key => $row) {
      $i++;

      $assign_to = AyraHelp::getUser($row->assign_user_id)->name;
      $assign_by = AyraHelp::getUser($row->assign_by)->name;

      $lead_data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();



      $HTML .= '<tr>
            <th scope="row">' . $i . '</th>
            <td>' . intVal($row->QUERY_ID) . '
           
             </td>
            <td>' . $lead_data_arr->SENDERNAME . '</td>
            <td>' . $lead_data_arr->MOB . '</td>
            <td>' . $assign_to . '</td>
            <td>' . $assign_by . '</td>

            <td>' . date('j F Y H:i:s ', strtotime($row->created_at)) . '</td>
            <td><a href="javascript::void(0)" onclick="viewAllINDMartData(' . $row->QUERY_ID . ')"> <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VIEW</span></a></td>

          </tr>';
    }
    $HTML .= '
                    </tbody>
                  </table>
                </div>
              </div>';
    echo $HTML;
  }

  //getLeadAssinDateWiseData

  public function getLeadStagesGrapgh()
  {
    $lava = new Lavacharts; // See note below for Laravel

    //get Assign lead

    //get Assign lead




    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.leadStageReportsgrapgh', $data)->render();
  }

  public function getLeadReports()
  {



    //=================================================
    $lava = new Lavacharts; // See note below for Laravel

    $finances = $lava->DataTable();
    $finances->addDateColumn('Year')
      ->addNumberColumn('Total Lead')
      ->addNumberColumn('Irrelevant')
      ->setDateTimeFormat('Y-m-d');
    //echo "<pre>";
    $fl_userid = 77;
    $freshlead_arr = $this->getBarGraphStackDataFresh('LeadData', 'created_at', $fl_userid, 'assign_to');

    $fl_userid = 77;
    $Irrelevant_arr = $this->getBarGraphStackDataIrrelevant('LeadData', 'created_at', $fl_userid, 'assign_to');




    $data = array();
    foreach ($freshlead_arr as $key => $value) {
      $data[] = $value;
    }

    $i = 0;

    foreach ($Irrelevant_arr as $key => $value) {

      if ($i == 30) {
      } else {
        $finances->addRow([$key, $data[$i], $value]);
        $i++;
      }
    }





    $bo_level = 'BOLEAD_G1';


    $donutchart = \Lava::ColumnChart($bo_level, $finances, [
      'title' => 'Last 30 Days Total Lead |  Irrelevant ',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3,


      ],

      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14

      ]
    ]);





    //===================================================




    //***************************** */
    $finances_g1 = $lava->DataTable();
    $finances_g1->addDateColumn('Year')
      ->addNumberColumn('Total Lead')
      ->setDateTimeFormat('Y-m-d');
    //echo "<pre>";
    $fl_userid = 77;
    $freshlead_arr = $this->getBarGraphStackDataFresh('LeadData', 'created_at', $fl_userid, 'assign_to');


    $i = 0;

    foreach ($freshlead_arr as $key => $value) {

      if ($i == 30) {
      } else {
        $finances_g1->addRow([$key, $value]);
        $i++;
      }
    }





    $bo_level = 'BOLEAD_G2';


    $donutchart = \Lava::ColumnChart($bo_level, $finances_g1, [
      'title' => 'Last 30 Days Total Lead ',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3,
        'color'    => '#035496'

      ],
      'colors' => ['DodgerBlue'],
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14

      ]
    ]);


    //***************************** */


    //***************************** */
    $finances_g2 = $lava->DataTable();
    $finances_g2->addDateColumn('Year')
      ->addNumberColumn('Irrelevant')
      ->setDateTimeFormat('Y-m-d');
    //echo "<pre>";
    $fl_userid = 77;
    $ireelead_arr = $this->getBarGraphStackDataIrrelevant('LeadData', 'created_at', $fl_userid, 'assign_to');







    $i = 0;

    foreach ($ireelead_arr as $key => $value) {

      if ($i == 30) {
      } else {
        $finances_g2->addRow([$key, $value]);
        $i++;
      }
    }





    $bo_level = 'BOLEAD_G3';


    $donutchart = \Lava::ColumnChart($bo_level, $finances_g2, [
      'title' => 'Last 30 Days  Irrelevant Lead ',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'colors' => ['Tomato'],
      'titleTextStyle' => [
        'color'    => '#000000',
        'fontSize' => 14

      ]
    ]);


    //***************************** */

    //***************************** */
    $finances_g3 = $lava->DataTable();
    $finances_g3->addDateColumn('Year')
      ->addNumberColumn('Assigned')
      ->setDateTimeFormat('Y-m-d');
    //echo "<pre>";
    $fl_userid = 77;
    $ireelead_arr = $this->getBarGraphStackDataAssigned('LeadDataProcess', 'created_at', $fl_userid, 'assign_to');
    $i = 0;

    foreach ($ireelead_arr as $key => $value) {

      if ($i == 30) {
      } else {
        $finances_g3->addRow([$key, $value]);
        $i++;
      }
    }





    $bo_level = 'BOLEAD_G4';


    $donutchart = \Lava::ColumnChart($bo_level, $finances_g3, [
      'title' => 'Last 30 Days Assign Lead ',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'colors' => ['#035496'],
      'titleTextStyle' => [
        'color'    => '#000000',
        'fontSize' => 14

      ]
    ]);


    //***************************** */



    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.leadReports', $data)->render();
  }
  //userActivityList
  public function userActivityList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'sample_data' => ''

    ];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.userActivityList', $data)->render();
    } else {
      abort(401);
    }
  }

  //userActivityList

  //productPriceList
  public function productPriceList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'sample_data' => ''

    ];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.createProductPrice', $data)->render();
    } else {
      abort(401);
    }
  }
  //productPriceList

  public function printLabel($sampleID, $newSaple = null)
  {
    $users_data = DB::table('samples')->where('sample_code', $sampleID)->first();
    $users_data_1 = DB::table('samples')->where('sample_code', $newSaple)->first();



    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'sample_data' => $users_data,
      'sample_data_1' => $users_data_1
    ];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'CourierTrk') {
      return $theme->scope('sample.sampleLablePrint', $data)->render();
    } else {
      abort(401);
    }
  }






  public function add_lead_data()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('lead.add_new_lead', $data)->render();
  }
  //LEAD

  //HRMS
  public function setClientUpdation(Request $request)
  {
    $cid = $request->cid;
    $txtClientGST = $request->txtClientGST;
    $txtClientAddress = $request->txtClientAddress;
    DB::table('clients')
      ->where('id', $cid)
      ->update([
        'gstno' => $txtClientGST,
        'address' => $txtClientAddress
      ]);
  }
  public function myAttendance()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('hrms.myAttendance', $data)->render();
  }
  public function getIndividualAttendance(Request $request)
  {
    $recordID = $request->recordID;
    $users_data = DB::table('emp_attendance_data')->where('id', $recordID)->first();
    $data_arrs = json_decode($users_data->atten_data);
    $HTML = '<div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Timing</th>
              </tr>
            </thead>
            <tbody>';

    $i = 0;
    foreach ($data_arrs as $key => $row) {
      $i++;
      $yr = $users_data->atten_yr;
      $mo = $users_data->attn_month;
      $dateON = $yr . "-" . $mo . "-" . $i;
      $created_on = date('l jS F Y', strtotime($dateON));
      //ajcode
      $contains = Str::contains($row[0], ':');
      if ($contains == 1) {

        //get hour of day
        $today_arr = explode(" ", $row[0]);
        // print_r($today_arr);
        if (empty($today_arr[1])) {
          $entime = $today_arr[0];
        } else {
          $entime = $today_arr[1];
        }
        $t1 = '2019-08-01 ' . $today_arr[0] . ":00";
        $t2 = '2019-08-01 ' . $entime . ":00";

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $t1);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $t2);

        $days = $startDate->diffInDays($endDate);
        $hours = $startDate->copy()->addDays($days)->diffInHours($endDate);
        $minutes = $startDate->copy()->addDays($days)->addHours($hours)->diffInMinutes($endDate);

        $day_hour[] = $hours . ":" . $minutes;

        //  if($hours<9){
        //      $lf++;
        //  }
        $badata = $hours . "Hr " . $minutes . "m";
        $totmin = $hours * 60 + $minutes;
        if (intVal($totmin) >= 525) {
          $badge = '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">' . $badata . '</span>';
        } else {
          $badge = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">' . $badata . '</span>';
        }
        $whour = $row[0] . ":" . $badge;
      } else {
        $whour = '';
      }

      //ajcode





      $HTML .= '<tr>
              <th scope="row">' . $i . '</th>
              <td>' . $created_on . '</td>
              <td>' . $whour . '.</td>

            </tr>';
    }
    $HTML .= '
                      </tbody>
                    </table>
                  </div>
                </div>';
    echo $HTML;
  }



  public function getMyMasterAttenDance(Request $request)
  {
    $users_data = DB::table('emp_attendance_data')->where('emp_id', Auth::user()->atten_id)->get();
    $data_arr_1 = array();
    foreach ($users_data as $key => $rowData) {
      $data_cal_arr = AyraHelp::getAttenCalulation($rowData->id);


      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'emp_id' => $rowData->emp_id,
        'emp_name' => $rowData->name,
        'month' => date("F", mktime(0, 0, 0, $rowData->attn_month, 10)),
        'present' => $data_cal_arr['present_day'],
        'half_day' => '',
        'late_fine' => $data_cal_arr['hour_less_count'],
        'total_day' => '',
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'emp_id'     => true,
      'emp_name'     => true,
      'month'  => true,
      'present'  => true,
      'half_day'  => true,
      'late_fine'  => true,
      'total_day'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getMasterAttenDance(Request $request)
  {
    $users_data = DB::table('emp_attendance_data')->get();
    $data_arr_1 = array();
    foreach ($users_data as $key => $rowData) {
      $data_cal_arr = AyraHelp::getAttenCalulation($rowData->id);


      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'emp_id' => $rowData->emp_id,
        'emp_name' => $rowData->name,
        'month' => date("F", mktime(0, 0, 0, $rowData->attn_month, 10)),
        'present' => $data_cal_arr['present_day'],
        'half_day' => '',
        'late_fine' => $data_cal_arr['hour_less_count'],
        'total_day' => '',
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'emp_id'     => true,
      'emp_name'     => true,
      'month'  => true,
      'present'  => true,
      'half_day'  => true,
      'late_fine'  => true,
      'total_day'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function upload_epm_attendance()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('hrms.empAttendance', $data)->render();
  }
  public function getKIPDetailsByUserDay(Request $request)
  {
    $kpi_arrs = KPIReport::where('id', $request->rowID)->first();
    $HTML = '<div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr>
                <th>#</th>
                <th>KPI</th>
                <th>Achivement QTY</th>
                <th>Hours Spend</th>
              </tr>
            </thead>
            <tbody>';





    $i = 0;
    foreach (json_decode($kpi_arrs->kpi_own_task) as $key => $row) {
      $i++;
      $HTML .= '<tr>
        <th scope="row">' . $i . '</th>
        <td>' . $row->task_v1 . '</td>
        <td>' . $row->task_qty_v1 . '</td>
        <td>' . $row->task_spend_hour_v1 . '</td>
      </tr>';
    }
    $HTML .= '
                </tbody>
              </table>
            </div>
          </div>';

    $HTML . '<hr>';


    //-------------------
    $HTML .= '<div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr>
                <th>#</th>
                <th>Task Discrption</th>
                <th>Achievement</th>
                <th>Hours Spend</th>
              </tr>
            </thead>
            <tbody>';





    $i = 0;

    foreach (json_decode($kpi_arrs->kpi_own_task) as $key => $rowData) {

      $i++;
      $HTML .= '<tr>
        <th scope="row">' . $i . '</th>
        <td>' . $rowData->task_v1 . '</td>
        <td>' . $rowData->task_qty_v1 . '</td>
        <td>' . $rowData->task_spend_hour_v1 . '</td>
      </tr>';
    }
    $HTML .= '
                </tbody>
              </table>
            </div>
          </div>';

    $HTML . '<hr>';
    $HTML .= '<div class="m-section">
          <div class="m-section__content">
            <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
              <thead>
                <tr>

                  <th>Remarks</th>

                </tr>
              </thead>
              <tbody>';







    $HTML .= '<tr>
          <th scope="row">' . $kpi_arrs->kpi_remarks . '</th>

        </tr>';

    $HTML .= '
                  </tbody>
                </table>
              </div>
            </div>';

    $HTML . '<hr>';



    echo $HTML;
  }


  public function kpiDetailHistory_all(Request $request)
  {
    $kpi_arrs = KPIReport::where('user_id', $request->empID)->get();
    $data_arr_1 = array();
    foreach ($kpi_arrs as $key => $rows) {
      //print_r($kpi_arrs);
      $data_arr_1[] = array(
        'id' => $rows->id,
        'kpi_date' => date('j F Y h:i A', strtotime($rows->kpi_date)),
        'kpi_month' => $rows->kpi_month_goal,
        'kpi_today' => $rows->kpi_today_goal,
        'kpi_remark' => $rows->kpi_remarks,

      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'id'     => true,
      'kpi_date'     => true,
      'kpi_month'     => true,
      'kpi_today'  => true,
      'kpi_remark'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getKPIDataReportHistory(Request $request)
  {
    $kpi_arrs = KPIReport::where('user_id', Auth::user()->id)->get();
    $data_arr_1 = array();
    foreach ($kpi_arrs as $key => $rows) {
      //print_r($kpi_arrs);
      $data_arr_1[] = array(
        'id' => $rows->id,
        'kpi_date' => date('j F Y h:i A', strtotime($rows->kpi_date)),
        'kpi_month' => $rows->kpi_month_goal,
        'kpi_today' => $rows->kpi_today_goal,
        'kpi_remark' => $rows->kpi_remarks,

      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'id'     => true,
      'kpi_date'     => true,
      'kpi_month'     => true,
      'kpi_today'  => true,
      'kpi_remark'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function kpiDetailHistoryEMP(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('hrms.kpiReportEMP', $data)->render();
  }

  public function kpiDetailHistory(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('hrms.kpiReport', $data)->render();
  }
  public function saveKPIReportSubmit(Request $request)
  {
    $kpi_date = date('Y-m-d H:i:s', strtotime($request->kpi_date));
    $kpi_month = date('F', strtotime($request->kpi_date));

    //ajcode

    $taskAks = $request->taskAks;



    //ajcode

    //  $kpi_d_arr=$request->kpi_details;


    //  $kpi_n_arr=$request->kpi_number;
    //  $kpi_sph_arr=$request->kpi_spendhour;
    //  $kpi_data_arr=array();
    //  foreach ($kpi_d_arr as $key => $row) {
    //    $kpi_data_arr[]=array(
    //      'kpi_detail'=>$row,
    //      'kpi_number'=>$kpi_n_arr[$key],
    //      'kpi_shour'=>$kpi_sph_arr[$key],
    //    );

    //  }

    $kpi_data_arr_other[] = array(
      'kpi_detail' => $request->kpi_other_discption,
      'kpi_number' => $request->kpi_other_acthmentNo,
      'kpi_shour' => $request->kpi_other_spendHour,
    );
    $kpiObj = new KPIReport;
    $kpiObj->kpi_month_goal = $request->goal_for_month;
    $kpiObj->kpi_today_goal = $request->goal_for_today;
    $kpiObj->kpi_date = $kpi_date;
    $kpiObj->kpi_month = $kpi_month;
    $kpiObj->user_id = Auth::user()->id;
    // $kpiObj->kpi_detail=json_encode($kpi_data_arr);
    $kpiObj->kpi_other_details = json_encode($kpi_data_arr_other);
    $kpiObj->kpi_own_task = json_encode($taskAks);
    $kpiObj->kpi_remarks = $request->kpi_remarks;
    $kpiObj->save();

    //send email
    $sent_to = 'bointldev@gmail.com';
    //$myorder=$row['txtPONumber'];
    $html = "<p>This is </p>";
    $empName = 'AJAY KUMAR';
    $toaj = date('F');
    $curr_date = date('d-m-Y');
    $subLine = "Daily Report [ " . $curr_date . " ] " . "[" . $toaj . "]" . $empName;
    $myreport = array('3,4');
    $data = array(
      'html_report_data' => $myreport,
      'name' => 'Ajay',
      'designation' => 'WEB IT',
      'phoneNO' => '9711309624',
      'email' => 'ajayits2020@avas.com',
      'today_report' => date('j M Y'),
      'html' => $html



    );
    Mail::send('mail_daily_report', $data, function ($message) use ($sent_to, $data, $subLine) {

      $message->to($sent_to, 'Bo | Daily Report')->subject($subLine);
      //$message->cc($use_data->email,$use_data->name = null);
      $message->setBody($data['html'], 'text/html');
      $message->bcc('bointldev@gmail.com', 'HR Department');
      $message->from('bointldev@gmail.com', 'MAX');
    });

    //send email


    return 1;
  }
  public function kpiDetails($kpi_id)
  {
    $emp_arr = KPIData::where('id', $kpi_id)->first();


    $theme = Theme::uses('corex')->layout('layout');
    $data = ['kpi_data' => $emp_arr];
    return $theme->scope('hrms.kpi_viewDeatils', $data)->render();
  }
  public function getKPIData()
  {

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'SalesUser') {
      $where_role = 'SALES';
    }
    if ($user_role == 'Staff') {
      $where_role = 'STAFF';
    }

    $data_arr_1 = array();
    $data_arr_2 = array();
    $aj_arr = array();

    if ($user_role == 'Admin') {
      $kpi_arr = KPIData::get();


      foreach ($kpi_arr as $key => $rowData) {
        $user_arr = AyraHelp::getUser($rowData->user_id);
        if ($user_arr != null) {
          $u_name = $user_arr->name;
        } else {
          $u_name = '';
        }

        $aj_arr[] = array(
          'RecordID' => $rowData->id,
          'kpi_role' => $rowData->kpi_role,
          'user_ID' => $rowData->user_id,
          'user_name' => $u_name,
          'kpi_department' => $rowData->kpi_department,
          'status' => 1
        );
      }
    } else {

      $kpi_arr = KPIData::where('user_id', Auth::user()->id)->get();
      $data_emp = Employee::where('user_id', Auth::user()->id)->first();
      $kpi_arr1 = KPIData::where('kpi_role', optional($data_emp)->job_role)->get();

      foreach ($kpi_arr as $key => $rowData) {
        $user_arr = AyraHelp::getUser($rowData->user_id);
        if ($user_arr != null) {
          $u_name = $user_arr->name;
        } else {
          $u_name = '';
        }

        $data_arr_1[] = array(
          'RecordID' => $rowData->id,
          'kpi_role' => $rowData->kpi_role,
          'user_ID' => $rowData->user_id,
          'user_name' => $u_name,
          'kpi_department' => $rowData->kpi_department,
          'status' => 1
        );
      }
      foreach ($kpi_arr1 as $key => $rowData) {
        $user_arr = AyraHelp::getUser($rowData->user_id);
        if ($user_arr != null) {
          $u_name = $user_arr->name;
        } else {
          $u_name = '';
        }

        $data_arr_2[] = array(
          'RecordID' => $rowData->id,
          'kpi_role' => $rowData->kpi_role,
          'user_ID' => $rowData->user_id,
          'user_name' => $u_name,
          'kpi_department' => $rowData->kpi_department,
          'status' => 1
        );
      }

      $aj_arr = array_merge($data_arr_1, $data_arr_2);
    }






    $JSON_Data = json_encode($aj_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'kpi_role'     => true,
      'user_ID'     => true,
      'user_name'     => true,
      'kpi_department'     => true,
      'status'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function saveKPIData(Request $request)
  {


    // $objKPIData=new KPIData;
    // $objKPIData->user_id=$request->user_id;
    // $objKPIData->kpi_role=$request->job_role;
    // $objKPIData->kpi_department=$request->department_data;
    // $objKPIData->kpi_detail=json_encode($request->KPIData);
    // $objKPIData->save();

    //  return 1;
    //admin can add kpi for particular user as well as role and all add  more to user

    if (isset($request->user_id)) {
      $user_id = $request->user_id;
      DB::table('kpi_data')->insert(
        [
          'user_id' => $request->user_id,
          'kpi_department' => $request->department_data,
          'kpi_detail' => json_encode($request->KPIData)
        ]
      );
    }
    if (isset($request->job_role)) {

      $job_role = $request->job_role;

      DB::table('kpi_data')->insert(
        [
          'kpi_role' => $job_role,
          'kpi_department' => $request->department_data,
          'kpi_detail' => json_encode($request->KPIData)
        ]
      );
    }

    return 1;
  }

  public function jobRole(Request $request)
  {
    $theme = Theme::uses('corex')->layout('hrmsLayout');
    $data = ['users' => ''];
    return $theme->scope('hrms.job_role', $data)->render();
  }
  public function deleteEMP(Request $request)
  {
    Employee::where('id', $request->emp_id)
      ->update(['is_deleted' => 1]);
    $data_arr = array(
      'status' => 1,
      'msg' => 'Deleted successfully'
    );
    return response()->json($data_arr);
  }

  public function empView($emp_id)
  {
    $emp_arr = Employee::where('id', $emp_id)->first();
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['user_data' => $emp_arr];
    return $theme->scope('hrms.employee_view', $data)->render();
  }

  public function getEmpListData(Request $request)
  {

    $data_arr_1 = array();
    $emp_arr = Employee::where('is_deleted', 0)->get();
    //$emp_arr=Employee::get();
    $i = 0;
    foreach ($emp_arr as $key => $Row) {
      $i++;
      // http://demo.local/local/public/img/avatar.jpg
      if (isset($Row->photo)) {
        $img_photo = asset('local/public/uploads/photos') . "/" . optional($Row)->photo;
      } else {
        $img_photo = asset('local/public/img/avatar.jpg');
      }
      if (!empty($Row->job_role)) {
        $jobRoleArr = AyraHelp::getJobRoleByid($Row->job_role);
        $role_name = $jobRoleArr->name;
      } else {
        $role_name = 'N/A';
      }



      $data_arr_1[] = array(
        'RecordID' => $Row->id,
        'photo' => $img_photo,
        'empID' => $Row->emp_code,
        'name' => $Row->name,
        'user_id' => $Row->user_id,
        'email' => $Row->email,
        'office_email' => $Row->comp_email,
        'phone' => $Row->phone,
        'department' => $Row->phone,
        'job_role' => $role_name,
        'user_status' => $Row->user_status,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'  => true,
      'photo'     => true,
      'empID'     => true,
      'name'      => true,
      'user_id'   => true,
      'email'      => true,
      'office_email' => true,
      'phone'      => true,
      'department' => true,
      'job_role'   => true,
      'is_deleted' => true,
      'Actions'    => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function getLocation(Request $request)
  {
    $pincode_arr = AyraHelp::getAddressByPincode($request->pincode);
    if ($pincode_arr == null) {
      $res_arr = array(
        'status' => 0,
        'data' => '',
        'Message' => 'Location by pincode',
      );
    } else {
      $res_arr = array(
        'status' => 1,
        'data' => $pincode_arr,
        'Message' => 'Location by pincode',
      );
    }
    return response()->json($res_arr);
  }

  public function kpiupdateData(Request $request)
  {

    // echo "<pre>";
    // print_r($request->all());
    //DB::table('kpi_data')->where('id',$request->txtKPIID)->delete();

    $validatedData = $request->validate([
      'user_id' => 'required',

    ]);


    if (isset($request->user_id)) {
      $user_id = $request->user_id;
      DB::table('kpi_data')
        ->where('id', $request->txtKPIID)
        ->update([
          'user_id' => $request->user_id,
          'kpi_department' => $request->department_data,
          'kpi_detail' => json_encode($request->KPIData)
        ]);

      // $ida= DB::table('kpi_data')->insert(
      //  [
      //    'user_id' => $request->user_id,
      //    'kpi_department' =>$request->department_data,
      //    'kpi_detail' =>json_encode($request->KPIData)
      //  ]
      // );
      return redirect()->route('jobRole');
    }
    if (isset($request->job_role)) {

      $job_role = $request->job_role;

      $ida = DB::table('kpi_data')->insert(
        [
          'kpi_role' => $job_role,
          'kpi_department' => $request->department_data,
          'kpi_detail' => json_encode($request->KPIData)
        ]
      );
      return redirect()->route('kpiDetails', ['id' => $ida]);
    }




    //return back()->with('success', 'Saved Changes Successfully..');




  }

  public function updateEmpdata(Request $request)
  {



    $epm_id = $request->txtUserID;
    $empCODE = $request->txtEMPCODE;
    $num = $request->atten_ID;
    $user_status = $request->user_status;



    $str_length = 4;

    if (isset($request->emp_code)) {
      $sid_code = $request->emp_code;
    } else {
      $sid_code = "EMP" . substr("0000{$num}", -$str_length);
    }


    Employee::where('id', $request->txtUserID)
      ->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'dob' => date("Y-m-d", strtotime($request->birth_date)),
        'doj' => date("Y-m-d", strtotime($request->join_date)),

        'department_id' => $request->department,
        'designation_id' => $request->designation,
        'gender' => $request->gender,
        'address' => $request->address,
        'pincode' => $request->pincode,
        'city' => $request->loccity,
        'state' => $request->locstate,
        'comp_email' => $request->offcial_email,
        'pan_card' => $request->pan_no,
        'aadhar_card' => $request->aadhar_no,
        'basic_salary' => $request->basic_salary,
        'atten_ID' => $request->atten_ID,
        'user_status' => $request->user_status,
        'emp_code' => $sid_code,
        'bank_name' => $request->bank_name,
        'account_no' => $request->account_no,
        'ifsc_code' => $request->ifsc_code,
        'job_role' => $request->jobrole,
        'doe' => date("Y-m-d", strtotime($request->exit_date)),
      ]);



    if ($request->hasFile('pan_doc')) {
      $file = $request->file('pan_doc');
      $filename = $empCODE . "_pan" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['pan_doc_img' => $filename]);
    }

    if ($request->hasFile('emp_photo')) {

      $file = $request->file('emp_photo');
      $filename = $empCODE . "_EMPPhoto" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['photo' => $filename]);
    }

    if ($request->hasFile('aadhar_doc')) {
      $file = $request->file('aadhar_doc');
      $filename = $empCODE . "_adhar" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['aadhar_doc_img' => $filename]);
    }


    return back()->with('success', 'Saved Changes Successfully..');
  }
  public function saveEmployee(Request $request)
  {

    $empCODE = AyraHelp::getEMPCODE();
    $objEmp = new Employee;
    $objEmp->emp_code = 'N/A';
    $objEmp->name = $request->name;
    $objEmp->email = $request->email;
    $objEmp->phone = $request->phone;
    $objEmp->dob = date("Y-m-d", strtotime($request->birth_date));
    $objEmp->doj = date("Y-m-d", strtotime($request->join_date));
    $objEmp->department_id = $request->department;
    $objEmp->designation_id = $request->designation;
    $objEmp->gender = $request->gender;
    $objEmp->address = $request->address;
    $objEmp->pincode = $request->pincode;
    $objEmp->city = $request->loccity;
    $objEmp->state = $request->locstate;
    $objEmp->comp_email = $request->offcial_email;
    $objEmp->pan_card = $request->pan_no;
    $objEmp->aadhar_card = $request->aadhar_no;
    $objEmp->pan_card = $request->pan_no;
    $objEmp->aadhar_card = $request->aadhar_no;


    // $objEmp->bank_name=$request->bank_name;
    // $objEmp->account_no=$request->account_no;
    // $objEmp->ifsc_code=$request->ifsc_code;

    $objEmp->created_by = Auth::user()->id;
    $objEmp->save();
    $epm_id = $objEmp->id;

    if ($request->hasFile('pan_doc')) {
      $file = $request->file('pan_doc');
      $filename = $empCODE . "_pan" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['pan_doc_img' => $filename]);
    }

    if ($request->hasFile('emp_photo')) {
      $file = $request->file('emp_photo');
      $filename = $empCODE . "_EMPPhoto" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['photo' => $filename]);
    }

    if ($request->hasFile('aadhar_doc')) {
      $file = $request->file('aadhar_doc');
      $filename = $empCODE . "_adhar" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      Employee::where('id', $epm_id)
        ->update(['aadhar_doc_img' => $filename]);
    }
  }
  public function HrDashbaord(Request $request)
  {
    $theme = Theme::uses('corex')->layout('hrmsLayout');
    $data = ['users' => ''];
    return $theme->scope('hrms.dashboard', $data)->render();
  }
  public function employee(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['users' => ''];
    return $theme->scope('hrms.employee', $data)->render();
  }


  //HRMS

//reportSampleReport
public function reportSampleReport(Request $request)
{
  $theme = Theme::uses('corex')->layout('layout');
  $data = array();
  return $theme->scope('reports.SampleReport', $data)->render();
}
//reportSampleReport



  public function reportSalesGraph(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel




    //code for show sales values monthly
    //code for order values
    // $finances_orderValue = $lava->DataTable();
    // $finances_orderValue->addDateColumn('Year')
    //   ->addNumberColumn('Order Value')
    //   ->setDateTimeFormat('Y-m-d');
    // for ($x = 4; $x <= 12; $x++) {
    //   $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

    //   //$active_date=date('Y')."-".$x."-1";

    //   if ($x >= date('m')+1) {
    //     $active_date = "2020-" . $x . "-1";
    //   } else {
    //     $active_date = date('Y') . "-" . $x . "-1";
    //   }

    //   $data_output = AyraHelp::getOrderValueFilter($x);
    //   $finances_orderValue->addRow([$active_date, $data_output]);
    // }




    // $donutchart = \Lava::ColumnChart('FinancesOrderValueMonthly', $finances_orderValue, [
    //   'title' => 'Order Value ',
    //   'titleTextStyle' => [
    //     'color'    => '#035496',
    //     'fontSize' => 14
    //   ],

    // ]);



    //code for order values
    //code for show sales values monthly



    //=================================================
    $finances = $lava->DataTable();
    $finances->addStringColumn('Year')
      ->addNumberColumn('NOTES')
      ->addNumberColumn('FOLLOWUP')
      ->addNumberColumn('Add Client');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountNotedAddedby($s_userid, 30);
        $followups = AyraHelp::getCountFollowupAddedby($s_userid, 30);
        $client_added = AyraHelp::getCountClientupAddedby($s_userid, 30);

        $finances->addRow([strtoupper($sname[0]), $notes, $followups, $client_added]);
      }
    }
    $donutchart = \Lava::ColumnChart('Finances', $finances, [
      'title' => 'Last 30 Days Notes ,Follow Up & Added Client ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],

    ]);

    //===================================================
    //=================================================
    $samples = $lava->DataTable();
    $samples->addStringColumn('Year')
      ->addNumberColumn('SAMPLES SENT')
      ->addNumberColumn('FEEDBACK ');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountSampleAddedby($s_userid, 30);
        $followups = AyraHelp::getCountSampleFeedbackAddedby($s_userid, 30);
        $samples->addRow([strtoupper($sname[0]), $notes, $followups]);
      }
    }
    $donutchart = \Lava::ColumnChart('SampleFeeback', $samples, [
      'title' => 'Last 30 Days Sample Sent and Feedback ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'colors' => ['#164252', '#008080'],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
    ]);

    //===================================================

    //----------------------------
    $reasons = $lava->DataTable();
    $feed_arr = AyraHelp::getSampleFeedbackCount(8, 30);
    $reasons->addStringColumn('Reasons')
      ->addNumberColumn('Percent')
      ->addRow(['Changes suggest resend samples', $feed_arr['option_1']])
      ->addRow(['Did not like', $feed_arr['option_2']])
      ->addRow(['Stopped Responding', $feed_arr['option_3']])
      ->addRow(['Sample Selected', $feed_arr['option_4']]);

    $donutpiechart = \Lava::PieChart('IMDB', $reasons, [
      'title' => 'Last 30 Days Feeback Piechart : Deepak',
      'is3D'   => true,
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'slices' => [
        ['offset' => 0.2],
        ['offset' => 0.25],
        ['offset' => 0.3]
      ]
    ]);
    //-----------------------------


    $sales_arr = AyraHelp::getSalesAgentOnly();

    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      $sname = $value->name;

      $finances = $lava->DataTable();
      $finances->addDateColumn('Year')
        ->addNumberColumn('NOTES')
        ->addNumberColumn('FOLLOW UP')
        ->setDateTimeFormat('Y-m-d');




      $clinet_arr = $this->getBarGraphStackData('ClientNote', 'created_at', $s_userid, 'user_id');

      $follow_arr = $this->getBarGraphStackData('Client', 'follow_date', $s_userid, 'added_by');


      $data = array();
      foreach ($follow_arr as $key => $value) {
        $data[] = $value;
      }
      $i = 0;

      foreach ($clinet_arr as $key => $value) {

        if ($i == 30) {
        } else {
          $finances->addRow([$key, $value, $data[$i]]);
          $i++;
        }
      }





      $bo_level = 'BO' . $s_userid;


      $donutchart = \Lava::ColumnChart($bo_level, $finances, [
        'title' => 'Last 30 Days Notes & Follow Up :' . $sname,
        'legend' => [
          'position'    => 'top',
          'maxLines' => 3

        ],
        'titleTextStyle' => [
          'color'    => '#035496',
          'fontSize' => 14

        ]
      ]);
    }






    return $theme->scope('reports.sales', $data)->render();
  }
  public function saveuserPermission(Request $request)
  {

    foreach ($request->permissions as $key => $perms) {

      $mhp_data = MHP::where('permission_id', $perms)->where('model_id', $request->user_id)->first();
      if ($mhp_data == null) {
        $mhpobe = new MHP;
        $mhpobe->permission_id = $perms;
        $mhpobe->model_type = 'App\User';
        $mhpobe->model_id = $request->user_id;
        $mhpobe->save();
      } else {
      }
    }
    //

  }
  public function addPermissionUsers(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::all();
    $permissions = Permission::all();

    $data = ['users' => $users, 'permissions' => $permissions];
    return $theme->scope('users.add_permission_user', $data)->render();
  }

  public function setUserPermission(Request $request)
  {
    $uid = $request->user_id;
    $perm_state = $request->perm_state;
    $perm_data = $request->perm_data;
    $user = User::find($request->user_id);
    if ($perm_state === 'true' || $perm_state === 'TRUE') {

      //  $mhpobe=new MHP;
      //  $mhpobe->permission_id=$perm_data;
      //  $mhpobe->model_type='App\User';
      //  $mhpobe->model_id=$uid;
      //  $mhpobe->save();
      $user->givePermissionTo($perm_data);
      $res_arr = array(
        'status' => 1,
        'type' => 'success',
        'Message' => $perm_data . " Permission added successfully",
      );
    }
    if ($perm_state === 'false' || $perm_state === 'FALSE') {

      // MHP::where('permission_id', $perm_data)->where('model_id', $uid)->delete();
      $user->revokePermissionTo($perm_data);
      $res_arr = array(
        'status' => 1,
        'type' => 'warning',
        'Message' => $perm_data . " Permission Removed successfully",
      );
    }

    return response()->json($res_arr);
  }

  public function userPermissions()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();

    $data = ['users' => $users];
    return $theme->scope('users.user_permission', $data)->render();
  }
  public function UserResetPassword(Request $request)
  {

    if (!(Hash::check($request->get('current'), Auth::user()->password))) {
      // The passwords matches
      $res_arr = array(
        'status' => 2,
        'Message' => 'Your current password does not matches with the password you provided. Please try again..',
      );
      return response()->json($res_arr);
    }
    if (strcmp($request->get('current'), $request->get('password')) == 0) {
      //Current password and new password are same
      $res_arr = array(
        'status' => 3,
        'Message' => 'New Password cannot be same as your current password. Please choose a different password..',
      );
      return response()->json($res_arr);
    }

    $id = $request->user_id;
    $user = User::findOrFail($id);
    $this->validate($request, [
      'password' => 'required'
    ]);

    $input = $request->only(['password']);
    $user->fill($input)->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Password saved successfully.',
    );
    return response()->json($res_arr);
  }

  // userAccessRemove
  public function userAccessRemove(Request $request)
  {

    $user = UserAccess::find($request->rowid);
    $user->delete();
  }
  // userAccessRemove

  //userAccess
  public function userAccess(Request $request)
  {
    $checkuser = UserAccess::where('access_by', Auth::user()->id)->where('access_to', $request->catsalesUser)->where('client_id', $request->client_id)->first();
    if ($checkuser == null) {
      //echo "inset now";
      $userAccessobj = new UserAccess;
      $userAccessobj->access_by = Auth::user()->id;
      $userAccessobj->client_id = $request->client_id;

      $userAccessobj->access_to = $request->catsalesUser;
      $userAccessobj->created_by = Auth::user()->id;
      $userAccessobj->remarks = '';
      $userAccessobj->user_exp_date = date('Y-m-d');
      $userAccessobj->save();
    } else {
      //echo "update time perios";
    }
  }

  //userProfile
  public function userProfile()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();

    $data = ['users' => $users];
    return $theme->scope('users.profile', $data)->render();
  }
  //userProfile


  //getCountry
  public function getCountry(Request $request, $id)
  {

    $getAttr = DB::table('country_cities')->select('country_id')->where('id', $id)->first();
    $getAttrC = DB::table('countries')->where('id', $getAttr->country_id)->first();
    $data = array('id' => $getAttrC->id, 'name' => $getAttrC->name);
    return response()->json($data);
  }
  //getCountry
  public function getCity(Request $request)
  {
    $q = $request->q;


    $getAttr = DB::table('country_cities')->select('id', 'name')->where('name', 'like', "$q%")->get();
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    $data = array(
      'total_count' => 1222,
      'incomplete_results' => 1222,
      'items' => $getAttr,
    );
    return response()->json($data);
  }
  public function setContactClient(Request $request)
  {
    $contactClient = new ContactClient;
    $contactClient->name = $request->name;
    $contactClient->email = $request->email;
    $contactClient->phone = $request->phone;
    $contactClient->parent_userid = $request->recordID;
    $contactClient->addedby = $request->added_by;
    $contactClient->created_at = date('Y-m-d H:i:s');
    $contactClient->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }

  public function saveRowClient(Request $request)
  {
    $rowClient = new RowClient;
    $rowClient->name = $request->name;
    $rowClient->email = $request->email;
    $rowClient->phone = $request->phone;
    $rowClient->company = $request->company;
    $rowClient->remarks = $request->remarks;
    $rowClient->brand_name = $request->brand_name;
    $rowClient->gst = $request->gst;
    $rowClient->address = $request->address;
    $rowClient->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }
  // save row client

  public function rowClientList()
  {
    $theme = Theme::uses('admin')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $users_staff = User::role('Staff')->get();
    $data = ['users' => $users, 'users_staff' => $users_staff];
    return $theme->scope('users.row_client_list', $data)->render();
  }
  public function add_ajax_clients(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:120',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6|confirmed'
    ]);
    $user = User::create($request->only('email', 'name', 'password'));
    $role_r = 'Client';
    $user->assignRole($role_r);

    $insertedId = $user->id;
    $comp_obj = new Company;
    $comp_obj->user_id = $insertedId;
    $comp_obj->company_name = $request->compname;
    $comp_obj->user_role = 'RootClient';
    $comp_obj->brand_name = $request->brand_name;
    $comp_obj->gst_details = $request->gst_details;
    $comp_obj->address = $request->address;
    $comp_obj->sale_agent_id = $request->sale_agent;
    $comp_obj->remarks = $request->remarks;
    $comp_obj->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }

  public function clinetListforDelete()
  {
    $theme = Theme::uses('admin')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $users_staff = User::role('Staff')->get();
    $data = ['users' => $users, 'users_staff' => $users_staff];
    return $theme->scope('users.view_clientsfordelte', $data)->render();
  }
  public function clinetList()
  {
    $theme = Theme::uses('admin')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $users_staff = User::role('Staff')->get();
    $data = ['users' => $users, 'users_staff' => $users_staff];
    return $theme->scope('users.view_clients', $data)->render();
  }
  public function sampleList()
  {
    $theme = Theme::uses('admin')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    return $theme->scope('users.view_samples', $data)->render();
  }


  public function index()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->where('is_deleted', 0)->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      return $theme->scope('users.index', $data)->render();
    } else {
      abort('401');
    }


    //return view('users.index')->with('users', $users);
  }
  // getAllLeadData_OWNLEAD

  public function getAllLeadData_OWNLEAD(Request $request)
  {
    $users = DB::table('client_sales_lead')->where('QUERY_ID', $request->rowid)->first();

    DB::table('client_sales_lead')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);


    $assign_to = AyraHelp::getUser($users->assign_to)->name;

    if ($users->updated_by == NULL) {
      $updated_by = 'Harsit';
    } else {
      $updated_by = AyraHelp::getUser($users->updated_by)->name;
    }


    $assign_on = date("j M Y h:i:sA", strtotime($users->assign_on));
    $users_lead_assign = DB::table('lead_assign')->where('QUERY_ID', $request->rowid)->first();
    $users_lead_moves = DB::table('lead_moves')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_notesby_sales = DB::table('lead_notesby_sales')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_lead_notes = DB::table('lead_notes')->where('QUERY_ID', $request->rowid)->get();

    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->get();




    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
        <thead class="thead-inverse">
          <tr>

            <th>User</th>
            <th>Stage</th>
            <th>Message</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>';


      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $assign_by = AyraHelp::getUser($Leadrow->user_id)->name;

        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];

        $HTML_HIST .= '<tr>

          <td>' . $assign_by . '</td>
          <td></td>
          <td>' . $Leadrow->msg . '</td>
          <td>' . $users_lead_move_created_on . '</td>
        </tr>';
      }


      $HTML_HIST .= '<tr>

        <td>Auto</td>
        <td>Fresh Lead</td>
        <td>5</td>
        <td>' . $created_on . '</td>
      </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

        <td>' . $updated_by . '</td>
        <td>Remaks</td>
        <td>' . $users->remarks . '</td>
        <td></td>
      </tr>';
      }


      //remarks


      $HTML_HIST .= '</tbody> </table>';
    } else {
      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
                  <thead class="thead-inverse">
                    <tr>

                      <th>User</th>
                      <th>Stage</th>
                      <th>Message</th>
                      <th>Created</th>
                    </tr>
                  </thead>
                  <tbody>';

      $HTML_HIST .= '<tr>

                      <td>Auto</td>
                      <td>Fresh Lead</td>
                      <td></td>
                      <td>' . $created_on . '</td>
                    </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

                      <td>' . $updated_by . '</td>
                      <td>Remaks</td>
                      <td>' . $users->remarks . '</td>
                      <td></td>
                    </tr>';
      }


      //remarks

      if ($users_lead_assign != null) {
        $assign_by = AyraHelp::getUser($users_lead_assign->assign_by)->name;
        $assign_user_id = AyraHelp::getUser($users_lead_assign->assign_user_id)->name;
        $users_lead_assign_created_on = date('j M Y h:iA', strtotime($users_lead_assign->created_at));

        $HTML_HIST .= '<tr>

                      <td>' . $assign_user_id . '</td>
                      <td>Assigned</td>
                      <td>' . $users_lead_assign->msg . '</td>
                      <td>' . $users_lead_assign_created_on . '</td>
                    </tr>';
      }

      if (count($users_lead_moves) > 0) {

        foreach ($users_lead_moves as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->assign_by)->name;
          $assign_to = AyraHelp::getUser($Leadrow->assign_to)->name;
          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];
          if ($user_role == 'Admin') {
            $mgdata = $Leadrow->msg . "(" . $Leadrow->assign_remarks . ")";
          } else {
            $mgdata = $Leadrow->msg;
          }

          $HTML_HIST .= '<tr>

                        <td>' . $assign_to . '</td>
                        <td>' . optional($Leadrow)->stage_name . '</td>
                        <td>' . $mgdata . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }

      if (count($users_lead_notesby_sales) > 0) {

        foreach ($users_lead_notesby_sales as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->added_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];


          $HTML_HIST .= '<tr>

                        <td>' . $assign_by . '</td>
                        <td></td>
                        <td>' . $Leadrow->message . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }

      if (count($users_lead_lead_notes) > 0) {

        foreach ($users_lead_lead_notes as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->created_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];

          $HTML_HIST .= '<tr>

                        <td>' . $assign_by . '</td>
                        <td></td>
                        <td>' . $Leadrow->msg . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }






      $HTML_HIST .= '</tbody> </table>';
    }



    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th colspan="3">Leads Full Information</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;



    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td>Assign Message</td>
    //   <td>'.optional($users_lead_assign)->msg.'</td>

    // </tr>';

    // $HTML .='
    // <tr>

    //   <td colspan="3">'.$MyTable.'</td>

    // </tr>';



    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>QUERY_ID</td>
                <td>' . $users->QUERY_ID . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SENDER NAME</td>
                <td>' . $users->SENDERNAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SENDERE MAIL</td>
                <td>' . $users->SENDEREMAIL . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SUBJECT</td>
                <td>' . $users->SUBJECT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>DATE TIME</td>
                <td>' . $users->DATE_TIME_RE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>COMPANY NAME</td>
                <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MOBILE No.</td>
                <td>' . $users->MOB . '</td>

              </tr>';



    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>COUNTRY FLAG

                </td>
                <td><img src="' . $users->COUNTRY_FLAG . '"></td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MESSAGE

                </td>
                <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>ADDRESS

                </td>
                <td>' . $users->ENQ_ADDRESS . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>CITY

                </td>
                <td>' . $users->ENQ_CITY . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PRODUCT NAME

                </td>
                <td>' . $users->PRODUCT_NAME . '</td>

              </tr>';


    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td> 	COUNTRY ISO

    //   </td>
    //   <td>'.$users->COUNTRY_ISO.'</td>

    // </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>EMAIL ALT

                </td>
                <td>' . $users->EMAIL_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MOBILE  ALT

                </td>
                <td>' . $users->MOBILE_ALT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PHONE

                </td>
                <td>' . $users->PHONE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PHONE ALT

                </td>
                <td>' . $users->PHONE_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MEMBER SINCE

                </td>
                <td>' . $users->IM_MEMBER_SINCE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Created At

                </td>
                <td>' . $created_on . '</td>

              </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Lead Souce

                </td>
                <td>' . $lsource . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Remarks

                </td>
                <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

              </tr>';









    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';


    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);
  }

  //getAllTicketDataID
  public function getAllTicketDataID(Request $request)
  {
   
    DB::table('bo_tickets')
      ->where('id', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);
      $tickeArr = DB::table('bo_tickets')->where('id', $request->rowid)->first();
      // print_r($tickeArr);
      // die;

      $qcFormData = DB::table('qc_forms')->where('form_id', $tickeArr->ticket_item_id)->first();
      $orderId=$qcFormData->order_id."/".$qcFormData->subOrder;
      

    $users_lead_lead_chat_histroy = DB::table('bo_tickets_logs')->where('ticket_id', $request->rowid)->orderBy('id', 'desc')->get();
    $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
        <thead class="thead-inverse">
          <tr>
            <th>S#</th>
            <th>Name</th>
            <th>Message</th>
            <th>Status</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>';

    //$created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $i = 0;
      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $i++;
        
        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
        $strM="";
       
        switch ($Leadrow->status_id) {
          case 1:
            $strM="OPEN";
          break;
          case 2:
            $strM="PROCESSING";
          break;
          case 3:
            $strM="COMPLETED";
          break;
          
        }


        $HTML_HIST .= '<tr>
  
            <td>' . $i . '</td>
            <td>' . optional($Leadrow)->created_by_name . '</td>           
            <td>' . optional($Leadrow)->msg . '</td>
            <td>' . $strM . '</td>
            <td>' . $users_lead_move_created_on . '</td>
          </tr>';
      }
    }
    $HTML_HIST .= '</tbody> </table>';

    //========================================================
    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th colspan="3">Full Information</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;

    $HTML .= '
              <tr>              
                <td>Ticket ID</td>
                <td>'.$request->rowid.'</td>
              </tr>';

              $HTML .= '
              <tr>              
                <td>Ticket for </td>
                <td>'.$tickeArr->ticket_type_name.'</td>
              </tr>';

    $HTML .= '
              <tr>              
                <td>Related to </td>
                <td>'.$tickeArr->ticket_cm_typeName.'</td>
              </tr>';

              $HTML .= '
              <tr>              
                <td>Subject </td>
                <td>'.$tickeArr->subject.'</td>
              </tr>';


              $HTML .= '              
              <tr>              
                <td>Order No. </td>
                <td>'.$orderId.'</td>
              </tr>';


              $HTML .= '              
              <tr>              
                <td>Item Name </td>
                <td>'.$tickeArr->item_name.'</td>
              </tr>';
              $HTML .= '              
              <tr>              
                <td>Sample ID </td>
                <td>'.@$qcFormData->item_fm_sample_no.'</td>
              </tr>';

              $HTML .= '
              <tr>              
                <td>Message </td>
                <td>'.$tickeArr->ticket_msg.'</td>
              </tr>';


              $HTML .= '
              <tr>              
                <td>Created by </td>
                <td>'.$tickeArr->created_by_name.'</td>
              </tr>';



              $HTML .= '
              <tr>              
                <td>Assigned to </td>
                <td>'.$tickeArr->assinged_to_name.'</td>
              </tr>';





    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';






  

    //LoggedActicty

    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);

    //========================================================

  }

  //getAllTicketDataID

  // getAllLeadDataALL
  public function getAllLeadDataALL(Request $request)
  {
    $users = DB::table('indmt_data')->where('QUERY_ID', $request->rowid)->first();
    DB::table('indmt_data')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);
    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->orderBy('id', 'desc')->get();
    $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
        <thead class="thead-inverse">
          <tr>
            <th>S#</th>
            <th>Details</th>
            <th>Message</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>';

    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $i = 0;
      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $i++;
        $StrSting = "";
        $strMSG = "";
        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));

        if ($Leadrow->at_stage_id != null) {
          $usersChArr = DB::table('st_process_stages')->where('process_id', 4)->where('stage_id', $Leadrow->at_stage_id)->first();
          $StrSting = $usersChArr->stage_name;
          $strMSG = ' <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">' . $StrSting . '</span>';
        }
        if ($Leadrow->sechule_date_time != null) {
          $rmdate = date('j M Y h:iA', strtotime($Leadrow->sechule_date_time));


          $strMSG = ' <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Reminder:' . $rmdate . '</span>';
        }


        $HTML_HIST .= '<tr>
  
            <td>' . $i . '</td>
            <td>' . optional($Leadrow)->msg_desc . $strMSG . '</td>           
            <td>' . optional($Leadrow)->msg . '</td>
            <td>' . $users_lead_move_created_on . '</td>
          </tr>';
      }
    }
    $HTML_HIST .= '</tbody> </table>';

    //========================================================
    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th colspan="3">Leads Full Information</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>QUERY_ID</td>
                <td>' . $users->QUERY_ID . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">2</th>
                <td>SENDER NAME</td>
                <td>' . $users->SENDERNAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">3</th>
                <td>SENDER MAIL</td>
                <td>' . $users->SENDEREMAIL . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">4</th>
                <td>SUBJECT</td>
                <td>' . $users->SUBJECT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">5</th>
                <td>DATE TIME</td>
                <td>' . $users->DATE_TIME_RE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">6</th>
                <td>COMPANY NAME</td>
                <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

              </tr>';
    if ($users->claim_by == "") {
      if (Auth::user()->id == 1) {
        $HTML .= '
              <tr>
                <th scope="row">7</th>
                <td>MOBILE No.</td>
                <td>' . $users->MOB . '</td>

              </tr>';
      }
    } else {
      $HTML .= '
              <tr>
                <th scope="row">7</th>
                <td>MOBILE No.</td>
                <td>' . $users->MOB . '</td>

              </tr>';
    }



    $HTML .= '
              <tr>
                <th scope="row">8</th>
                <td>COUNTRY FLAG

                </td>
                <td><img src="' . $users->COUNTRY_FLAG . '"></td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">9</th>
                <td>MESSAGE

                </td>
                <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

              </tr>';
    $HTML .= '
              <tr>
                <th scope="row">10</th>
                <td>ADDRESS

                </td>
                <td>' . $users->ENQ_ADDRESS . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">11</th>
                <td>CITY

                </td>
                <td>' . $users->ENQ_CITY . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">12</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">13</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">14</th>
                <td>PRODUCT NAME

                </td>
                <td>' . $users->PRODUCT_NAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">15</th>
                <td>EMAIL ALT

                </td>
                <td>' . $users->EMAIL_ALT . '</td>

              </tr>';

    if ($users->claim_by == "") {
    } else {
      $HTML .= '
                <tr>
                  <th scope="row">16</th>
                  <td>MOBILE  ALT
  
                  </td>
                  <td>' . $users->MOBILE_ALT . '</td>
  
                </tr>';
    }

    if ($users->claim_by == "") {
    } else {
      $HTML .= '
                <tr>
                  <th scope="row">17</th>
                  <td>PHONE
  
                  </td>
                  <td>' . $users->PHONE . '</td>
  
                </tr>';
    }



    $HTML .= '
              <tr>
                <th scope="row">18</th>
                <td>PHONE ALT

                </td>
                <td>' . $users->PHONE_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">19</th>
                <td>MEMBER SINCE

                </td>
                <td>' . $users->IM_MEMBER_SINCE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">20</th>
                <td>CREATED AT

                </td>
                <td>' . $created_on . '</td>

              </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }
    if ($LS == 'INHOUSE-ENTRY') {
      $lsource = 'INHOUSE-ENTRY';
    }
    if ($LS == 'TRADEINDIA-8850185@API_3') {
      $lsource = 'TRADEINDIA';
    }
    if ($LS == 'INDMART-9811098426@API_5') {
      $lsource = 'INDMART-9811098426';
    }
    if ($LS == 'BONET@API_6') {
      $lsource = 'BONET';
    }
    if ($LS == 'FB') {
      $lsource = 'Facebook';
    }


    $HTML .= '
              <tr>
                <th scope="row">22</th>
                <td>LEAD SOURCE

                </td>
                <td>' . $lsource . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">23</th>
                <td>REMARKS

                </td>
                <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

              </tr>';









    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';






    //LoggedActicty
    $dbotp_arr = DB::table('st_process_action_4')->where('ticket_id', $request->rowid)->latest()->first();
    if ($dbotp_arr != null) {
      $stage_arrData = AyraHelp::getStageDataBYpostionID($dbotp_arr->stage_id, 4);

      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $eventName = "View Lead";
      $eventINFO = $LoggedName . " View Lead of stage : " . $stage_arrData->stage_name . "& Lead Phone NO:" . $users->MOB;
      $eventID = $users->QUERY_ID;

      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();

      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
    }


    //LoggedActicty

    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);

    //========================================================

  }


  // getAllLeadDataALL

  // getAllLeadData_OWNLEAD
  public function getAllLeadData(Request $request)
  {
    $users = DB::table('indmt_data')->where('QUERY_ID', $request->rowid)->first();
    DB::table('indmt_data')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);
    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->orderBy('id', 'desc')->get();
    $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
        <thead class="thead-inverse">
          <tr>
            <th>S#</th>
            <th>Details</th>
            <th>Message</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>';

    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $i = 0;
      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $i++;
        $StrSting = "";
        $strMSG = "";
        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));

        if ($Leadrow->at_stage_id != null) {
          $usersChArr = DB::table('st_process_stages')->where('process_id', 4)->where('stage_id', $Leadrow->at_stage_id)->first();
          $StrSting = $usersChArr->stage_name;
          $strMSG = ' <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">' . $StrSting . '</span>';
        }
        if ($Leadrow->sechule_date_time != null) {
          $rmdate = date('j M Y h:iA', strtotime($Leadrow->sechule_date_time));


          $strMSG = ' <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Reminder:' . $rmdate . '</span>';
        }


        $HTML_HIST .= '<tr>
  
            <td>' . $i . '</td>
            <td>' . optional($Leadrow)->msg_desc . $strMSG . '</td>           
            <td>' . optional($Leadrow)->msg . '</td>
            <td>' . $users_lead_move_created_on . '</td>
          </tr>';
      }
    }
    $HTML_HIST .= '</tbody> </table>';

    //========================================================
    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th colspan="3">Leads Full Information</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>QUERY_ID</td>
                <td>' . $users->QUERY_ID . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">2</th>
                <td>SENDER NAME</td>
                <td>' . $users->SENDERNAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">3</th>
                <td>SENDER MAIL</td>
                <td>' . $users->SENDEREMAIL . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">4</th>
                <td>SUBJECT</td>
                <td>' . $users->SUBJECT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">5</th>
                <td>DATE TIME</td>
                <td>' . $users->DATE_TIME_RE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">6</th>
                <td>COMPANY NAME</td>
                <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">7</th>
                <td>MOBILE No.</td>
                <td>' . $users->MOB . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">8</th>
                <td>COUNTRY FLAG

                </td>
                <td><img src="' . $users->COUNTRY_FLAG . '"></td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">9</th>
                <td>MESSAGE

                </td>
                <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

              </tr>';
    $HTML .= '
              <tr>
                <th scope="row">10</th>
                <td>ADDRESS

                </td>
                <td>' . $users->ENQ_ADDRESS . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">11</th>
                <td>CITY

                </td>
                <td>' . $users->ENQ_CITY . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">12</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">13</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">14</th>
                <td>PRODUCT NAME

                </td>
                <td>' . $users->PRODUCT_NAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">15</th>
                <td>EMAIL ALT

                </td>
                <td>' . $users->EMAIL_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">16</th>
                <td>MOBILE  ALT

                </td>
                <td>' . $users->MOBILE_ALT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">17</th>
                <td>PHONE

                </td>
                <td>' . $users->PHONE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">18</th>
                <td>PHONE ALT

                </td>
                <td>' . $users->PHONE_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">19</th>
                <td>MEMBER SINCE

                </td>
                <td>' . $users->IM_MEMBER_SINCE . '</td>

              </tr>';
    $HTML .= '
              <tr>
                <th scope="row">19</th>
                <td>CALL DURATION

                </td>
                <td>' . $users->ENQ_CALL_DURATION . '</td>

              </tr>';

    $userA = User::where('phone', $users->ENQ_RECEIVER_MOB)->whereNotNull('phone')->first();
    if ($userA != null) {
      $pickBy = $userA->name;
    } else {
      $pickBy = 'Unknown :' . $users->ENQ_RECEIVER_MOB;
    }
    $HTML .= '
              <tr>
                <th scope="row">19</th>
                <td>CALL PICKUP PHONE

                </td>
                <td>' . $pickBy . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">20</th>
                <td>CREATED AT

                </td>
                <td>' . $created_on . '</td>

              </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }

    if ($LS == 'INDMART-9811098426@API_5') {
      $lsource = 'IM3';
    }



    $HTML .= '
              <tr>
                <th scope="row">22</th>
                <td>LEAD SOURCE

                </td>
                <td>' . $lsource . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">23</th>
                <td>REMARKS

                </td>
                <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

              </tr>';









    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';






    //LoggedActicty
    $dbotp_arr = DB::table('st_process_action_4')->where('ticket_id', $request->rowid)->latest()->first();
    if ($dbotp_arr != null) {
      $stage_arrData = AyraHelp::getStageDataBYpostionID($dbotp_arr->stage_id, 4);

      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $eventName = "View Lead";
      $eventINFO = $LoggedName . " View Lead of stage : " . $stage_arrData->stage_name . "& Lead Phone NO:" . $users->MOB;
      $eventID = $users->QUERY_ID;

      $created_atA = date('Y-m-d H:i:s');
      $slug_name = url()->full();

      $this->LoggedActicty(
        $userID,
        $eventName,
        $eventINFO,
        $eventID,
        $created_atA,
        $slug_name

      );
    }


    //LoggedActicty

    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);

    //========================================================

  }


  public function getAllLeadData_7AugBKP(Request $request)
  {
    $users = DB::table('indmt_data')->where('QUERY_ID', $request->rowid)->first();

    DB::table('indmt_data')
      ->where('QUERY_ID', $request->rowid)
      ->update([
        'view_status' => 1,
      ]);


    $assign_to = AyraHelp::getUser($users->assign_to)->name;

    if ($users->updated_by == NULL) {
      $updated_by = '';
    } else {
      $updated_by = AyraHelp::getUser($users->updated_by)->name;
    }


    $assign_on = date("j M Y h:i:sA", strtotime($users->assign_on));
    $users_lead_assign = DB::table('lead_assign')->where('QUERY_ID', $request->rowid)->first();
    $users_lead_moves = DB::table('lead_moves')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_notesby_sales = DB::table('lead_notesby_sales')->where('QUERY_ID', $request->rowid)->get();
    $users_lead_lead_notes = DB::table('lead_notes')->where('QUERY_ID', $request->rowid)->get();

    $users_lead_lead_chat_histroy = DB::table('lead_chat_histroy')->where('QUERY_ID', $request->rowid)->get();




    $created_on = date('j M Y h:i A', strtotime($users->created_at));

    if (count($users_lead_lead_chat_histroy) > 0) {

      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
        <thead class="thead-inverse">
          <tr>

            <th>User</th>
            <th>Stage</th>
            <th>Message</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>';


      foreach ($users_lead_lead_chat_histroy as $key => $Leadrow) {
        $assign_by = AyraHelp::getUser($Leadrow->user_id)->name;

        $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];

        $HTML_HIST .= '<tr>

          <td>' . $assign_by . '</td>
          <td></td>
          <td>' . $Leadrow->msg . '</td>
          <td>' . $users_lead_move_created_on . '</td>
        </tr>';
      }


      $HTML_HIST .= '<tr>

        <td></td>
        <td>Fresh Lead</td>
        <td>5</td>
        <td>' . $created_on . '</td>
      </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

        <td>' . $updated_by . '</td>
        <td>Remaks</td>
        <td>' . $users->remarks . '</td>
        <td></td>
      </tr>';
      }


      //remarks


      $HTML_HIST .= '</tbody> </table>';
    } else {
      $HTML_HIST = '   <table class="table table-sm m-table m-table--head-bg-primary">
                  <thead class="thead-inverse">
                    <tr>

                      <th>User</th>
                      <th>Stage</th>
                      <th>Message</th>
                      <th>Created</th>
                    </tr>
                  </thead>
                  <tbody>';

      $HTML_HIST .= '<tr>

                      <td>Auto</td>
                      <td>Fresh Lead</td>
                      <td></td>
                      <td>' . $created_on . '</td>
                    </tr>';
      //remarks

      if (isset($users->remarks)) {
        $HTML_HIST .= '<tr>

                      <td>' . $updated_by . '</td>
                      <td>Remaks</td>
                      <td>' . $users->remarks . '</td>
                      <td></td>
                    </tr>';
      }


      //remarks

      if ($users_lead_assign != null) {
        $assign_by = AyraHelp::getUser($users_lead_assign->assign_by)->name;
        $assign_user_id = AyraHelp::getUser($users_lead_assign->assign_user_id)->name;
        $users_lead_assign_created_on = date('j M Y h:iA', strtotime($users_lead_assign->created_at));

        $HTML_HIST .= '<tr>

                      <td>' . $assign_user_id . '</td>
                      <td>Assigned</td>
                      <td>' . $users_lead_assign->msg . '</td>
                      <td>' . $users_lead_assign_created_on . '</td>
                    </tr>';
      }

      if (count($users_lead_moves) > 0) {

        foreach ($users_lead_moves as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->assign_by)->name;
          $assign_to = AyraHelp::getUser($Leadrow->assign_to)->name;
          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];
          if ($user_role == 'Admin') {
            $mgdata = $Leadrow->msg . "(" . $Leadrow->assign_remarks . ")";
          } else {
            $mgdata = $Leadrow->msg;
          }

          $HTML_HIST .= '<tr>

                        <td>' . $assign_to . '</td>
                        <td>' . optional($Leadrow)->stage_name . '</td>
                        <td>' . $mgdata . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }

      if (count($users_lead_notesby_sales) > 0) {

        foreach ($users_lead_notesby_sales as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->added_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];


          $HTML_HIST .= '<tr>

                        <td>' . $assign_by . '</td>
                        <td></td>
                        <td>' . $Leadrow->message . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }

      if (count($users_lead_lead_notes) > 0) {

        foreach ($users_lead_lead_notes as $key => $Leadrow) {
          $assign_by = AyraHelp::getUser($Leadrow->created_by)->name;

          $users_lead_move_created_on = date('j M Y h:iA', strtotime($Leadrow->created_at));
          $user = auth()->user();
          $userRoles = $user->getRoleNames();
          $user_role = $userRoles[0];

          $HTML_HIST .= '<tr>

                        <td>' . $assign_by . '</td>
                        <td></td>
                        <td>' . $Leadrow->msg . '</td>
                        <td>' . $users_lead_move_created_on . '</td>
                      </tr>';
        }
      }






      $HTML_HIST .= '</tbody> </table>';
    }



    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th colspan="3">Leads Full Information</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;



    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td>Assign Message</td>
    //   <td>'.optional($users_lead_assign)->msg.'</td>

    // </tr>';

    // $HTML .='
    // <tr>

    //   <td colspan="3">'.$MyTable.'</td>

    // </tr>';



    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>QUERY_ID</td>
                <td>' . $users->QUERY_ID . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SENDER NAME</td>
                <td>' . $users->SENDERNAME . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SENDERE MAIL</td>
                <td>' . $users->SENDEREMAIL . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>SUBJECT</td>
                <td>' . $users->SUBJECT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>DATE TIME</td>
                <td>' . $users->DATE_TIME_RE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>COMPANY NAME</td>
                <td>' . $users->GLUSR_USR_COMPANYNAME . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MOBILE No.</td>
                <td>' . $users->MOB . '</td>

              </tr>';



    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>COUNTRY FLAG

                </td>
                <td><img src="' . $users->COUNTRY_FLAG . '"></td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MESSAGE

                </td>
                <td>' . utf8_encode($users->ENQ_MESSAGE) . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>ADDRESS

                </td>
                <td>' . $users->ENQ_ADDRESS . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>CITY

                </td>
                <td>' . $users->ENQ_CITY . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>STATE

                </td>
                <td>' . $users->ENQ_STATE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PRODUCT NAME

                </td>
                <td>' . $users->PRODUCT_NAME . '</td>

              </tr>';


    // $HTML .='
    // <tr>
    //   <th scope="row">1</th>
    //   <td> 	COUNTRY ISO

    //   </td>
    //   <td>'.$users->COUNTRY_ISO.'</td>

    // </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>EMAIL ALT

                </td>
                <td>' . $users->EMAIL_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MOBILE  ALT

                </td>
                <td>' . $users->MOBILE_ALT . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PHONE

                </td>
                <td>' . $users->PHONE . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>PHONE ALT

                </td>
                <td>' . $users->PHONE_ALT . '</td>

              </tr>';


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>MEMBER SINCE

                </td>
                <td>' . $users->IM_MEMBER_SINCE . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Created At

                </td>
                <td>' . $created_on . '</td>

              </tr>';

    $lsource = "";

    $LS = $users->data_source;
    if ($LS == 'INDMART-9999955922@API_1' || $LS == 'INDMART-9999955922') {
      $lsource = 'IM1';
    }
    if ($LS == 'INDMART-8929503295@API_2' || $LS == 'INDMART-8929503295') {
      $lsource = 'IM2';
    }
    if ($LS == 'INDMART-9811098426@API_5') {
      $lsource = 'IM3';
    }


    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Lead Souce

                </td>
                <td>' . $lsource . '</td>

              </tr>';

    $HTML .= '
              <tr>
                <th scope="row">1</th>
                <td>Remarks

                </td>
                <td><strong style="color:#035496">' . $users->remarks . '</strong></td>

              </tr>';









    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';






    //LoggedActicty
    // $dbotp_arr=DB::table('st_process_action_4')->where('ticket_id',$request->rowid)->latest()->first();
    //
    //  $stage_arrData = AyraHelp::getStageDataBYpostionID($dbotp_arr->stage_id, 4);
    //
    // $userID=Auth::user()->id;
    // $LoggedName=AyraHelp::getUser($userID)->name;
    // $eventName="View Lead";
    // $eventINFO=$LoggedName." View Lead of stage : ".$stage_arrData->stage_name."& Lead Phone NO:".$users->MOB;
    // $eventID=$users->QUERY_ID;
    //
    // $created_atA=date('Y-m-d H:i:s');
    // $slug_name=url()->full();
    //
    // $this->LoggedActicty(
    //   $userID,
    //   $eventName,
    //   $eventINFO,
    //   $eventID,
    //   $created_atA,
    //   $slug_name
    //
    // );
    //LoggedActicty

    $resp = array(
      'HTML_LEAD' => $HTML,
      'HTML_ASSIGN_HISTORY' => $HTML_HIST,

    );
    return response()->json($resp);
  }

  public function getLeadManagerReport()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' ||  $user_role == 'SalesHead') {

      return $theme->scope('lead.leadManagerReport', $data)->render();
    } else {

      abort('401');
    }


    //return view('users.index')->with('users', $users);
  }

  public function getINDMartDataNEW()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = DB::table('indmt_data')->paginate(10);


    return $theme->scope('users.ind_mart_dataTEST', compact('data'))->render();
  }
  function fetch_data(Request $request)
  {

    if ($request->ajax()) {
      $data = DB::table('indmt_data')->paginate(10);
      return view('pagination_data', compact('data'))->render();
    }
  }

  //getINDMartDatav2
  public function getINDMartDatav2()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('users.ind_mart_data_ADMINVIEW_v2', $data)->render();
      // return $theme->scope('users.ind_mart_data', $data)->render();
    } else {
      if (Auth::user()->id == 217 || Auth::user()->id == 202 ) {
        return $theme->scope('users.ind_mart_data_LMLayout', $data)->render();
      } else {
        abort('401');
      }
    }
  }
  //getINDMartDatav2
  public function getINDMartData()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 119 || Auth::user()->id == 129  || Auth::user()->id == 3  || Auth::user()->id == 40  || Auth::user()->id == 4 ||  $user_role == 'SalesHead') {
      return $theme->scope('users.ind_mart_data_ADMINVIEW', $data)->render();
      // return $theme->scope('users.ind_mart_data', $data)->render();
    } else {
      if (Auth::user()->id == 144 || Auth::user()->id == 145 || Auth::user()->id == 141 || Auth::user()->id == 142 || Auth::user()->id == 134 || Auth::user()->id == 139 || Auth::user()->id == 140  || Auth::user()->id == 135 || Auth::user()->id == 136 || Auth::user()->id == 84) {
        return $theme->scope('users.ind_mart_data_LMLayout', $data)->render();
      } else {
        abort('401');
      }
    }


    //return view('users.index')->with('users', $users);
  }
  //getINDMartDataLeadManagerViewExport
  public function getINDMartDataLeadManagerViewExport()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => ''];

    return $theme->scope('users.ind_mart_data_LeadMangerViewExport', $data)->render();
    //return $theme->scope('users.ind_mart_data_ADMINVIEW', $data)->render();





    //return view('users.index')->with('users', $users);
  }



  //getINDMartDataLeadManagerViewExport

  public function getINDMartDataLeadManagerView()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => ''];
    
    return $theme->scope('users.ind_mart_data_LeadMangerView', $data)->render();
    //return $theme->scope('users.ind_mart_data_ADMINVIEW', $data)->render();





    //return view('users.index')->with('users', $users);
  }

  public function getINDMartDataLeadManagerView_Intern()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => ''];

    return $theme->scope('intern.ind_mart_data_LeadMangerView_Intern', $data)->render();
    //return $theme->scope('users.ind_mart_data_ADMINVIEW', $data)->render();





    //return view('users.index')->with('users', $users);
  }





  //getLeadsAcceessListOwnClient
  public function getLeadsAcceessListOwnClient()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'User') {
      abort(401);
    } else {
      return $theme->scope('client.leadClients', $data)->render();
    }
  }

  //getLeadsAcceessListOwnClient

  //getSampleDetailsBYID
  public function getSampleDetailsBYID(Request $request)
  {
    // print_r($request->all());
    $sampleArr = DB::table('samples')
      ->where('id', $request->sid)
      ->first();
    $sample_data = DB::table('sample_items')
      ->where('sid', $request->sid)
      ->get();
    $HTML = "To,<br>";
    $HTML .= '<b>' . ucwords($sampleArr->lead_name) . "</b><br>";
    $HTML .= '<b>Mob:</b>' . $sampleArr->contact_phone . "<br>";
    $HTML .= $sampleArr->ship_address;


    $resp = array(
      'status' => 1,
      'data' => $sample_data,
      'ship_address' => $HTML,


    );

    return response()->json($resp);
  }
  //getSampleDetailsBYID
  //chemistSamplesDetails
  public function chemistSamplesDetails()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $sample = Sample::select('id', 'sample_code')->orderby('id', 'desc')->where('status', 1)->get();
    $data = [
      'data' => $sample
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    return $theme->scope('users.chemistSampleDetail', $data)->render();
  }

  //chemistSamplesDetails
  //getOrderChemistIncentive
  public function getOrderChemistIncentive(Request $request)
  {
    //print_r($request->all());
    $fromDate = $request->st_dateChemist;
    $ToDate = $request->ed_dateChemist;
    $HTML = '<table style="margin-top:10px" class="table table-bordered m-table m-table--border-primary">
    <thead>
      <tr>
        <th>#</th>
        <th>Dispatch Status</th>
        <th>Order Recieved</th>
        <th>Modification</th>
        <th>Re Order Count</th>
        <th>Sample ID</th>
        <th>Chemist Name</th>
      </tr>
    </thead>
    <tbody>';




    $dataArr = DB::table('qc_forms')
      ->whereNotNull('item_fm_sample_no')->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)
      ->get();
    $i = 0;
    foreach ($dataArr as $key => $rowData) {
      $i++;
      //print_r($rowData);
      $orderID = $rowData->order_id . "-" . $rowData->subOrder;

      $HTML .= ' <tr>
              <th scope="row">' . $i . '</th>
              <td>--</td>
              <td>' . $orderID . '</td>
              <td>1</td>
              <td>2</td>
              <td>' . $rowData->item_fm_sample_no . '</td>
              <td>3</td>
              ';
    }
    $HTML .= ' </tbody>
            </table>';

    echo $HTML;
  }
  //getOrderChemistIncentive


  //bulkSampleDispatch
  public function bulkSampleDispatch()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $sample = Sample::select('id', 'sample_code')->orderby('id', 'desc')->where('status', 1)->get();

    $data = [
      'data' => $sample
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    return $theme->scope('users.bulkSampleDispatch', $data)->render();



    //return view('users.index')->with('users', $users);
  }

  //bulkSampleDispatch

  //getAllChemistLayout
  public function getAllChemistLayout()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    return $theme->scope('users.chemisLayout', $data)->render();



    //return view('users.index')->with('users', $users);
  }

  //getAllChemistLayout

  public function getLeadsAcceessListOwn()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    return $theme->scope('users.salesOwnLead', $data)->render();



    //return view('users.index')->with('users', $users);
  }


  public function getLeadsAcceessList()
  {
    // $users = User::all();
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Intern' || $user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead'  || Auth::user()->id == 102) {

      if ($user_role == "Admin") {
        return $theme->scope('users.ind_mart_data', $data)->render();
      } else {
        return $theme->scope('users.ind_mart_dataSales', $data)->render();
      }
    } else {
      abort('401');
    }


    //return view('users.index')->with('users', $users);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::get();
    return view('users.create', ['roles' => $roles]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:120',
      'phone' => 'required|max:10|unique:users',
      'user_prefix' => 'required|max:3',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6|confirmed'
    ]);

    $user = User::create($request->only('email', 'name','phone','user_prefix', 'password'));

    $roles = $request['roles'];

    if (isset($roles)) {

      foreach ($roles as $role) {
        $role_r = Role::where('id', '=', $role)->firstOrFail();
        $user->assignRole($role_r);
      }
    }

    return redirect()->route('users.index')
      ->with(
        'flash_message',
        'User successfully added.'
      );
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return redirect('users');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = User::findOrFail($id);
    $roles = Role::get();
    $data = ['user' => $user, 'roles' => $roles];
    return $theme->scope('users.user_edit', $data)->render();
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
    $user = User::findOrFail($id);
    $this->validate($request, [
      'name' => 'required|max:120',
      'phone' => 'required|max:10|unique:users',
      'user_prefix' => 'required|max:3',
      'email' => 'required|email|unique:users,email,' . $id,
      'password' => 'required|min:6|confirmed'
    ]);

    $input = $request->only(['name', 'email','phone','user_prefix', 'password']);
    $roles = $request['roles'];
    $user->fill($input)->save();

    if (isset($roles)) {
      $user->roles()->sync($roles);
    } else {
      $user->roles()->detach();
    }
    return redirect()->route('users.index')
      ->with(
        'flash_message',
        'User successfully edited.'
      );
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('users.index')
      ->with(
        'flash_message',
        'User successfully deleted.'
      );
  }
}
