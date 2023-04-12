<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
use Carbon\Carbon;
use App\Helpers\AyraHelp;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;
use Pusher;
class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function setAjaxRunCronjonLeadGraph(Request $request)
  {
    //AyraHelp::getLeadDistributionV1();// update statge of fresh and assigned graph
    
    AyraHelp::setAPIDataTocallData();
    AyraHelp::getAllAgentsData();
    AyraHelp::getLast7daysCallRecivedData();
    AyraHelp::getLast30daysCallRecivedData();
    AyraHelp::getcurrentMonthRecivedMissedCallData();
    AyraHelp::getThisMonthAssinedQualifiedLead();
    
    AyraHelp::getClick2ThisMonthDataBoth();
    AyraHelp::getWeeklyDataIndiamart12();
    AyraHelp::getLast30daysKnowlarityINOUTCALLDATA();
    AyraHelp::getThisMonthBuyLeadALL_API(); //save 30
    AyraHelp::getThisMonthKnowlarityMissedCallAPI(); //save 30
    AyraHelp::getLeadProgress();//lead asigned with satges
    AyraHelp::getClick2CallAllCall(); //insert all call
    AyraHelp::getMyAllClient(); //insert all call
   
    

    //AyraHelp::getsetAllKnowlartyData(); //lead assined //Under Approval
    //AyraHelp::getClick2CallAllCallAssinedLead();  this api is used to assign lead of call is 30 sec more with lead activity







    //AyraHelp::setClick2CallThisMonthOutGoing();



  }
  //dashboard lead call and graph

  public function setAjaxRunCronjonLeadCOUNT(Request $request)
  {
    $lead_data = AyraHelp::getLeadDistribution();
    $data_arr_data_fresh = DB::table('indmt_data')->where('lead_status', 0)->get();
    
    $aj1 = 0;
    $aj2 = 0;
    $aj3 = 0;
    $aj4 = 0;
    $aj5 = 0;
    $aj6 = 0;
    $aj7 = 0;
    $unqli = 0;
    
    foreach ($lead_data as $key => $row) {
      $aj1 = intval($aj1) + intval($row['stage_1']);
      $aj2 = intval($aj2) + intval($row['stage_2']);
      $aj3 = intval($aj3) + intval($row['stage_3']);
      $aj4 = intval($aj4) + intval($row['stage_4']);
      $aj5 = intval($aj5) + intval($row['stage_5']);
      $aj6 = intval($aj6) + intval($row['stage_6']);
      $unqli = intval($unqli) + intval($row['unqli']);
      $irvant = intval($unqli) + intval($row['irvant']);

      $aj7 = intval($aj7) + intval($row['stage_totoal']);
    }
    $totaj = intval($aj7) + intval(count($data_arr_data_fresh));





    DB::table('lead_map_data')
      ->where('id', 1)
      ->update([
        'fresh_lead' => count($data_arr_data_fresh),
        'assign_lead' => $aj1,
        'qualified_lead' => $aj2,
        'sample_lead' => $aj3,
        'client_lead' => $aj4,
        'repeat_lead' => $aj5,
        'lost_lead' => $aj6,
        'total_lead' => $totaj,
        'unqualified_lead' => $unqli,
        'irrelevant' => $irvant,
        'update_at' => date('Y-m-d H:i:s'),

      ]);


      //update data those are rest to field 

    $orderDataArr = DB::table('qc_bo_purchaselist')->where('created_at', '>', Carbon::now()->subDays(320))->orderBy('order_id', 'DESC')->get();
    //print_r($orderDataArr);


    //die;
    $i = 0;
    foreach ($orderDataArr as $key => $rowData) {
      $i++;
      $qc_data = AyraHelp::getQCFormDate($rowData->form_id);
      $data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);

      if (isset($data->stage_name)) {
        $Spname = $data->stage_name;
      } else {
        $Spname = 'Completed';
      }
      $data_arr = AyraHelp::getProcessCurrentStagePurchase(2, $rowData->id);


      $SpnameA = $data_arr->stage_name;

      $bomData = AyraHelp::GetBomDetail($rowData->form_id, $rowData->material_name);
      if ($bomData == null) {
        $no_avil = 0;
      } else {
        $no_avil = 1;

        $bom_Type = 5; //no input
        if ($bomData->bom_from == 'From Client' || $bomData->bom_from == 'N/A') {
          $bom_Type = 0; //from cleint
        } else {
          $bom_Type = 1; // order
        }
      }



      $affected = DB::table('qc_bo_purchaselist')
        ->where('id', $rowData->id)
        ->update([
          'order_item_name' =>  optional($qc_data)->item_name,
          'order_pack_img_url' =>  optional($qc_data)->pack_img_url,
          'bom_stage_name' => $SpnameA,
          'order_stage_name' => $Spname,
          'bom_Type_from' => $bom_Type,

        ]);
    }



  }
  public function setAjaxRunCronjonLead(Request $request)
  {

    $this->runCRON_API($request->ApiName, $request->startDate, $request->endDate);
  }
  public function getGMARTData_4()
  {
    $start_date = date("d-M-Y", strtotime('-3 day'));
    $start_dateA = date("Y-m-d", strtotime('-1 day'));
    $stop_date = date("d-M-Y");
   // $start_date = '29-May-2020';
    //$stop_date='01-Jul-2020';

    $url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999525990/GLUSR_MOBILE_KEY/MTU5MzIzOTg0Mi4yMjQ1IzczNjg1Mjk=/Start_Time/' . $start_date . '/End_Time/' . $stop_date . '/';

    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode($data); // decode the JSON feed
    foreach ($characters as $key => $row) {

      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {

        $data_arr = DB::table('indmt_data_pack')->where('QUERY_ID', $row->QUERY_ID)->first();
        if ($data_arr == null) {
          $originalDate = $row->DATE_TIME_RE;
          $newDate = date("Y-m-d H:i:s", strtotime($originalDate));
        
            DB::table('indmt_data_pack')->insert(
              [
                'SENDERNAME' => $row->SENDERNAME,
                'SENDEREMAIL' => $row->SENDEREMAIL,
                'SUBJECT' => $row->SUBJECT,
                'DATE_TIME_RE' => $row->DATE_TIME_RE,
                'GLUSR_USR_COMPANYNAME' => $row->GLUSR_USR_COMPANYNAME,
                'MOB' => $row->MOB,
                'COUNTRY_FLAG' => $row->COUNTRY_FLAG,
                'ENQ_MESSAGE' => $row->ENQ_MESSAGE,
                'ENQ_ADDRESS' => $row->ENQ_ADDRESS,
                'ENQ_CITY' => $row->ENQ_CITY,
                'ENQ_STATE' => $row->ENQ_STATE,
                'PRODUCT_NAME' => $row->PRODUCT_NAME,
                'COUNTRY_ISO' => $row->COUNTRY_ISO,
                'EMAIL_ALT' => $row->EMAIL_ALT,
                'MOBILE_ALT' => $row->MOBILE_ALT,
                'PHONE' => $row->PHONE,
                'PHONE_ALT' => $row->PHONE_ALT,
                'IM_MEMBER_SINCE' => $row->IM_MEMBER_SINCE,
                'QUERY_ID' => $row->QUERY_ID,
                'QTYPE' => $row->QTYPE,
                'ENQ_CALL_DURATION' => $row->ENQ_CALL_DURATION,
                'ENQ_RECEIVER_MOB' => $row->ENQ_RECEIVER_MOB,
                'data_source' => 'INDMART-8929503295@API_2_PACK',
                'data_source_ID' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'DATE_TIME_RE_SYS' => $newDate,
                'assign_to' => 134,

              ]
            );
             //===========================
          // $TLeads = DB::table('indmt_data_pack')->where('data_source','INDMART-8929503295@API_2_PACK')->whereDate('created_at','>=',$start_dateA)->get();   
          $TLeads = 0;

          $this->LeadTally('INDMART-2@API_2_PACK',$row->TOTAL_COUNT,$TLeads);
          //===========================


          
        }
      }
    }

    //----------------------------------
    $tday = date('Y-m-d');
    $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-8929503295@API_2')->first();
    if ($data_arr == null) {

      DB::table('leadcron_run_log')->insert(
        [

          'lrun_day_date' => date('Y-m-d'),
          'last_update' => date('Y-m-d H:i:s'),
          'api_details' => 'INDMART-8929503295@API_2',

        ]
      );
    } else {
      $arr = DB::table('leadcron_run_log')
        ->where('lrun_day_date', $tday)
        ->where('api_details', 'INDMART-8929503295@API_2')
        ->update(['last_update' => date('Y-m-d H:i:s')]);
    }
    //-------------------------------------------


    echo "Completed API 4";
  }


  
  //---------------------------------------
  public function getGMARTData_3()
  {
    $start_date =date("Y-m-d", strtotime( '-2 day' ));
   // $start_date = date("Y-m-d");
    $stop_date = date("Y-m-d");

    //$url='https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/8929503295/GLUSR_MOBILE_KEY/MTU3ODk5OTM0OC4wMTkyIzI3NDI0MjUx/Start_Time/'.$start_date.'/End_Time/'.$stop_date.'/';
    $url = 'https://www.tradeindia.com/utils/my_inquiry.html?userid=8850185&profile_id=12475609&key=43d616a4bf6566bb07c1249f2605deb8&from_date=' . $start_date . '&to_date=' . $stop_date . '&limit=200';

    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode($data); // decode the JSON feed

    foreach ($characters as $key => $row) {

      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {

        $QUERY_ID =$row->generated;       
        
        $data_arr = DB::table('indmt_data')->where('QUERY_ID', $QUERY_ID)->first();
        if ($data_arr == null) {

          $originalDate = $row->generated_date . ' ' . $row->generated_time;
          $newDate = date("Y-m-d H:i:s", strtotime($originalDate));

          $DATE_TIME_RE = date("d-M-Y H:i:s A", strtotime($originalDate));
          //06-Jan-2020 05:19:11 PM
          DB::table('indmt_data')->insert(
            [

              'SENDERNAME' =>  optional($row)->sender_name,
              'SENDEREMAIL' =>  optional($row)->sender_email,
              'SUBJECT' =>  optional($row)->subject,
              'DATE_TIME_RE' => $DATE_TIME_RE,
              'GLUSR_USR_COMPANYNAME' => '',
              'MOB' =>  optional($row)->sender_mobile,
              'COUNTRY_FLAG' => '',
              'ENQ_MESSAGE' =>  optional($row)->message,
              'ENQ_ADDRESS' => optional($row)->address,
              'ENQ_CITY' =>  optional($row)->sender_city,
              'ENQ_STATE' =>  optional($row)->sender_state,
              'PRODUCT_NAME' => optional($row)->product_name,
              'COUNTRY_ISO' =>  optional($row)->sender_country,
              'EMAIL_ALT' => optional($row)->sender_other_emails,
              'MOBILE_ALT' => optional($row)->sender_other_mobiles,
              'PHONE' => '',
              'PHONE_ALT' => '',
              'IM_MEMBER_SINCE' => optional($row)->member_since,
              'QUERY_ID' => $QUERY_ID,
              'QTYPE' => 'W',
              'ENQ_CALL_DURATION' => '',
              'ENQ_RECEIVER_MOB' => '',
              'data_source' => 'TRADEINDIA-8850185@API_3',
              'data_source_ID' => 3,
              'created_at' => date('Y-m-d H:i:s'),
              'DATE_TIME_RE_SYS' => $newDate,
              'assign_to' => 134,
              'json_api_data' => $data,

            ]
          );

        

          //===========================
          //$TLeads = DB::table('indmt_data')->where('data_source','TRADEINDIA-8850185@API_3')->whereDate('created_at',date('Y-m-d'))->get();   

          //$this->LeadTally('TRADEINDIA-8850185@API_3',$row->TOTAL_COUNT,count($TLeads));
          //===========================

        }
      }
    }

    //----------------------------------
    $tday = date('Y-m-d');
    $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'TRADEINDIA-8850185@API_3')->first();
    if ($data_arr == null) {

      DB::table('leadcron_run_log')->insert(
        [

          'lrun_day_date' => date('Y-m-d'),
          'last_update' => date('Y-m-d H:i:s'),
          'api_details' => 'TRADEINDIA-8850185@API_3',

        ]
      );
    } else {
      $arr = DB::table('leadcron_run_log')
        ->where('lrun_day_date', $tday)
        ->where('api_details', 'TRADEINDIA-8850185@API_3')
        ->update(['last_update' => date('Y-m-d H:i:s')]);
    }
    //-------------------------------------------

    AyraHelp::getDuplicateLead();
    echo "Completed API 3";
  }

  //getGMARTData_5
  public function getGMARTData_5()
  {
    $start_date = date("d-M-Y", strtotime('-3 day'));
    $start_dateA = date("Y-m-d", strtotime('-1 day'));
    $stop_date = date("d-M-Y");

    $url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9811098426/GLUSR_MOBILE_KEY/MTYwMDg1NTYzMi43NTU2IzkyMTYwNzc3/Start_Time/' . $start_date . '/End_Time/' . $stop_date . '/';


    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode($data); // decode the JSON feed

    foreach ($characters as $key => $row) {

      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {

        $data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();
        if ($data_arr == null) {
          

          $originalDate = $row->DATE_TIME_RE;
          $newDate = date("Y-m-d H:i:s", strtotime($originalDate));

          DB::table('indmt_data')->insert(
            [

              'SENDERNAME' => $row->SENDERNAME,
              'SENDEREMAIL' => $row->SENDEREMAIL,
              'SUBJECT' => $row->SUBJECT,
              'DATE_TIME_RE' => $row->DATE_TIME_RE,
              'GLUSR_USR_COMPANYNAME' => $row->GLUSR_USR_COMPANYNAME,
              'MOB' => $row->MOB,
              'COUNTRY_FLAG' => $row->COUNTRY_FLAG,
              'ENQ_MESSAGE' => $row->ENQ_MESSAGE,
              'ENQ_ADDRESS' => $row->ENQ_ADDRESS,
              'ENQ_CITY' => $row->ENQ_CITY,
              'ENQ_STATE' => $row->ENQ_STATE,
              'PRODUCT_NAME' => $row->PRODUCT_NAME,
              'COUNTRY_ISO' => $row->COUNTRY_ISO,
              'EMAIL_ALT' => $row->EMAIL_ALT,
              'MOBILE_ALT' => $row->MOBILE_ALT,
              'PHONE' => $row->PHONE,
              'PHONE_ALT' => $row->PHONE_ALT,
              'IM_MEMBER_SINCE' => $row->IM_MEMBER_SINCE,
              'QUERY_ID' => $row->QUERY_ID,
              'QTYPE' => $row->QTYPE,
              'ENQ_CALL_DURATION' => $row->ENQ_CALL_DURATION,
              'ENQ_RECEIVER_MOB' => $row->ENQ_RECEIVER_MOB,
              'data_source' => 'INDMART-9811098426@API_5',
              'data_source_ID' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'DATE_TIME_RE_SYS' => $newDate,
              'assign_to' => 134,

            ]
          );
          //===========================
          //$TLeads = DB::table('indmt_data')->where('data_source','INDMART-9811098426@API_5')->whereDate('created_at',">=",$start_dateA)->get();   
          $TLeads = 0;

          $this->LeadTally('INDMART-9811098426@API_5',$row->TOTAL_COUNT,$TLeads);
          //===========================

        }
      }
    }

    //----------------------------------
    $tday = date('Y-m-d');
    $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-9811098426@API_5')->first();
    if ($data_arr == null) {

      DB::table('leadcron_run_log')->insert(
        [

          'lrun_day_date' => date('Y-m-d'),
          'last_update' => date('Y-m-d H:i:s'),
          'api_details' => 'INDMART-9811098426@API_5',

        ]
      );
    } else {
      $arr = DB::table('leadcron_run_log')
        ->where('lrun_day_date', $tday)
        ->where('api_details', 'INDMART-9811098426@API_5')
        ->update(['last_update' => date('Y-m-d H:i:s')]);
    }
    //-------------------------------------------
    AyraHelp::getDuplicateLead();

    echo "Completed API 5";
  }
  //getGMARTData_5

  //getIndiaMartData_6 Bo NET
  public function getIndiaMartData_6()
  {
    

    $url = 'https://www.max.net/ajtest.php';

   


    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode($data); // decode the JSON feed
  

     foreach ($characters as $key => $row) {

    

   


      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {


        $data_arr = DB::table('indmt_data')->whereNotNull('ori_ID')->where('ori_ID', $row->id)->first();
        if ($data_arr == null) {

          

          DB::table('indmt_data')->insert(
            [

              'SENDERNAME' => $row->first_name."".$row->last_name,
              'SENDEREMAIL' => $row->email,
              'SUBJECT' => $row->subject,
              'DATE_TIME_RE' => $row->created_on,
              'GLUSR_USR_COMPANYNAME' =>$row->company,
              'MOB' => $row->phone,
              'COUNTRY_FLAG' => '',
              'ENQ_MESSAGE' => $row->msg,
              'ENQ_ADDRESS' =>'',
              'ENQ_CITY' => '',
              'ENQ_STATE' => '',
              'PRODUCT_NAME' => '',
              'COUNTRY_ISO' => '',
              'EMAIL_ALT' => '',
              'MOBILE_ALT' =>'',
              'PHONE' => $row->phone,
              'PHONE_ALT' => '',
              'IM_MEMBER_SINCE' => '',
              'QUERY_ID' => "202200".$row->id,
              'QTYPE' => 'W',
              'ENQ_CALL_DURATION' => '',
              'ENQ_RECEIVER_MOB' => '',
              'data_source' => 'BONET@API_6',
              'data_source_ID' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'DATE_TIME_RE_SYS' => date('Y-m-d H:i:s'),
              'assign_to' => 134,
              'ori_ID' => $row->id,

            ]
          );
          //===========================
          //$TLeads = DB::table('indmt_data')->where('data_source','INDMART-8929503295@API_2')->whereDate('created_at','>=',$start_dateA)->get();   
          $TLeads = 0;

          //$this->LeadTally('BONET@API_6',$row->TOTAL_COUNT,$TLeads);
          //===========================

        }
      }
    }

    //----------------------------------
  
    AyraHelp::getDuplicateLead();

    echo "Completed BO NET";
  }
  //getIndiaMartData_6 Bo NET
  //---------------------------------------

  public function getGMARTData_2()
  {
    $start_date = date("d-M-Y", strtotime('-3 day'));
    $start_dateA = date("Y-m-d", strtotime('-1 day'));
    $stop_date = date("d-M-Y");

    $url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/8929503295/GLUSR_MOBILE_KEY/MTU3ODk5OTM0OC4wMTkyIzI3NDI0MjUx/Start_Time/' . $start_date . '/End_Time/' . $stop_date . '/';  


    $data = file_get_contents($url); // put the contents of the file into a variable
    $characters = json_decode($data); // decode the JSON feed

    foreach ($characters as $key => $row) {

      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {

        $data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();
        if ($data_arr == null) {

          $originalDate = $row->DATE_TIME_RE;
          $newDate = date("Y-m-d H:i:s", strtotime($originalDate));

          DB::table('indmt_data')->insert(
            [

              'SENDERNAME' => $row->SENDERNAME,
              'SENDEREMAIL' => $row->SENDEREMAIL,
              'SUBJECT' => $row->SUBJECT,
              'DATE_TIME_RE' => $row->DATE_TIME_RE,
              'GLUSR_USR_COMPANYNAME' => $row->GLUSR_USR_COMPANYNAME,
              'MOB' => $row->MOB,
              'COUNTRY_FLAG' => $row->COUNTRY_FLAG,
              'ENQ_MESSAGE' => $row->ENQ_MESSAGE,
              'ENQ_ADDRESS' => $row->ENQ_ADDRESS,
              'ENQ_CITY' => $row->ENQ_CITY,
              'ENQ_STATE' => $row->ENQ_STATE,
              'PRODUCT_NAME' => $row->PRODUCT_NAME,
              'COUNTRY_ISO' => $row->COUNTRY_ISO,
              'EMAIL_ALT' => $row->EMAIL_ALT,
              'MOBILE_ALT' => $row->MOBILE_ALT,
              'PHONE' => $row->PHONE,
              'PHONE_ALT' => $row->PHONE_ALT,
              'IM_MEMBER_SINCE' => $row->IM_MEMBER_SINCE,
              'QUERY_ID' => $row->QUERY_ID,
              'QTYPE' => $row->QTYPE,
              'ENQ_CALL_DURATION' => $row->ENQ_CALL_DURATION,
              'ENQ_RECEIVER_MOB' => $row->ENQ_RECEIVER_MOB,
              'data_source' => 'INDMART-8929503295@API_2',
              'data_source_ID' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'DATE_TIME_RE_SYS' => $newDate,
              'assign_to' => 134,

            ]
          );
          //===========================
          //$TLeads = DB::table('indmt_data')->where('data_source','INDMART-8929503295@API_2')->whereDate('created_at','>=',$start_dateA)->get();   
          $TLeads = 0;

          $this->LeadTally('INDMART-8929503295@API_2',$row->TOTAL_COUNT,$TLeads);
          //===========================

        }
      }
    }

    //----------------------------------
    $tday = date('Y-m-d');
    $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-8929503295@API_2')->first();
    if ($data_arr == null) {

      DB::table('leadcron_run_log')->insert(
        [

          'lrun_day_date' => date('Y-m-d'),
          'last_update' => date('Y-m-d H:i:s'),
          'api_details' => 'INDMART-8929503295@API_2',

        ]
      );
    } else {
      $arr = DB::table('leadcron_run_log')
        ->where('lrun_day_date', $tday)
        ->where('api_details', 'INDMART-8929503295@API_2')
        ->update(['last_update' => date('Y-m-d H:i:s')]);
    }
    //-------------------------------------------
    AyraHelp::getDuplicateLead();

    echo "Completed API 2";
  }
  //online2Offlineclient
  public function online2Offlineclient()
  {
    $data_arr = DB::table('clients_1')->where('merge',0)->get();
    foreach ($data_arr as $key => $row) {
      $data_arr = DB::table('clients')->where('phone',$row->phone)->first();
      if($data_arr==null){
       echo  $string = preg_replace('/\s+/', '', $row->phone);
        //echo $newstring = substr($string, -10);
        echo "<br>";

      }else{
        echo "yes";
      }

    }


  }
  //online2Offlineclient
  // online2Offline
  public function online2Offline()
  {
   // AyraHelp::leadMerge();
  // AyraHelp::IrrelevantLeadMerge();
    //AyraHelp::AssignedLeadMerge();
  // $phone= "7703886088";
  // $msg= "TEST1";
  // $datasms=$this->PRPSendSMS($phone,$msg);



   //AyraHelp::StagesLeadMerge();
 // AyraHelp::ChatHistLeadMerge();
 // AyraHelp::setAssinedLeadProccessLead();
    // AyraHelp::getLeadProgress();
    //AyraHelp::getLeadDistributionV1();
    //AyraHelp::setSampleLeadData();

    
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
    $eventID='AJ_ID134';

    $data['message'] = 'What are you doing Mr Roby';
    $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/


  }
 //invoiceFileUpload
 public function invoiceFileUpload(Request $request){
  if ($request->hasFile('file')) {
           
          


    $file = $request->file('file');
    $fileName = time() .".". $file->getClientOriginalExtension();
    
    $name_arr=explode(".",$file->getClientOriginalName());
    $fineNameAj=$name_arr[0];
    $journalName = preg_replace('/\s+/', '_', $fineNameAj);

    $destinationPath = 'uploads/video';
    $file->move($destinationPath, $fileName);
    $vlink= url('/uploads/video')."/".$fileName;
   echo "45454";

}


}
//invoiceFileUpload


  // online2Offline

  public function getGMARTData()
  {
    
    $start_date = date("d-M-Y", strtotime('-3 day'));
    $start_dateA = date("Y-m-d", strtotime('-1 day'));
    $stop_date = date("d-M-Y");

    $url='https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/'.$start_date.'/End_Time/'.$stop_date.'/';
    //$url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/16-Jul-2020/End_Time/18-Jul-2020/';
    //$url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/1-Jul-2020/End_Time/15-Jul-2020/';
    //$url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/19-Jul-2020/End_Time/31-Jul-2020/';
    //$url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/01-Jun-2020/End_Time/07-Jun-2020/';


    $data = file_get_contents($url); // put the contents of the file into a variable
   

    $characters = json_decode($data); // decode the JSON feed

    foreach ($characters as $key => $row) {

      if (isset($row->Error_Message)) {
        echo $row->Error_Message;
      } else {



        $originalDate = $row->DATE_TIME_RE;
         $newDate = date("Y-m-d H:i:s", strtotime($originalDate));
        //$newDate = date('Y-m-d H:i:s');
        $data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();
        if ($data_arr == null) {

          DB::table('indmt_data')->insert([


            'SENDERNAME' => $row->SENDERNAME,
            'SENDEREMAIL' => $row->SENDEREMAIL,
            'SUBJECT' => $row->SUBJECT,
            'DATE_TIME_RE' => $row->DATE_TIME_RE,
            'GLUSR_USR_COMPANYNAME' => $row->GLUSR_USR_COMPANYNAME,
            'MOB' => $row->MOB,
            'COUNTRY_FLAG' => $row->COUNTRY_FLAG,
            'ENQ_MESSAGE' => $row->ENQ_MESSAGE,
            'ENQ_ADDRESS' => $row->ENQ_ADDRESS,
            'ENQ_CITY' => $row->ENQ_CITY,
            'ENQ_STATE' => $row->ENQ_STATE,
            'PRODUCT_NAME' => $row->PRODUCT_NAME,
            'COUNTRY_ISO' => $row->COUNTRY_ISO,
            'EMAIL_ALT' => $row->EMAIL_ALT,
            'MOBILE_ALT' => $row->MOBILE_ALT,
            'PHONE' => $row->PHONE,
            'PHONE_ALT' => $row->PHONE_ALT,
            'IM_MEMBER_SINCE' => $row->IM_MEMBER_SINCE,
            'QUERY_ID' => $row->QUERY_ID,
            'QTYPE' => $row->QTYPE,
            'ENQ_CALL_DURATION' => $row->ENQ_CALL_DURATION,
            'ENQ_RECEIVER_MOB' => $row->ENQ_RECEIVER_MOB,
            'data_source' => 'INDMART-9999955922@API_1',
            'data_source_ID' => 1,
            'created_at' => $newDate,
            'DATE_TIME_RE_SYS' => $newDate,
            'assign_to' => 134,

          ]);
          //===========================
          //$TLeads = DB::table('indmt_data')->where('data_source','INDMART-9999955922@API_1')->whereDate('created_at','>=',$start_dateA)->get();   
          $TLeads = 0;        

          $this->LeadTally('INDMART-9999955922@API_1',$row->TOTAL_COUNT,$TLeads);
          //===========================
        }
      }
    }

    //----------------------------------
    $tday = date('Y-m-d');
    $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-9999955922@API_1')->first();
    if ($data_arr == null) {

      DB::table('leadcron_run_log')->insert(
        [

          'lrun_day_date' => date('Y-m-d'),
          'last_update' => date('Y-m-d H:i:s'),
          'api_details' => 'INDMART-9999955922@API_1',

        ]
      );
    } else {
      $arr = DB::table('leadcron_run_log')
        ->where('lrun_day_date', $tday)
        ->where('api_details', 'INDMART-9999955922@API_1')
        ->update(['last_update' => date('Y-m-d H:i:s')]);
    }
    //-------------------------------------------


    echo "Completed API one";
  }

 
  public function setOrderStagesApi()
  {
    AyraHelp::setOrderStagesForApi();
    // AyraHelp::setOrderStagesForApiYestarday();
  }
  public function setOrderStagesApiV1()
  {
    AyraHelp::setOrderStagesForApiV1();
    // AyraHelp::setOrderStagesForApiYestarday();
  }
  public function getOrderStagesDelayAPIV1()
  {
    $arr_data = DB::table('st_process_action')
      ->where('st_process_action.action_status', 0)
      ->select('id', 'stage_id', 'created_at')
      ->get();

    foreach ($arr_data as $key => $rowdata) {
      $rowid = $rowdata->id;
      $Date = $rowdata->created_at;
      $stage_id = $created_at = $rowdata->stage_id;
      $step_data_arr = DB::table('st_process_stages')->select('days_to_done')->where('process_id', 1)->where('stage_id', $stage_id)->first();
      $days_to_done = $step_data_arr->days_to_done;
      $expire_date = strtotime(date('Y-m-d H:i:s', strtotime($Date . ' + ' . $days_to_done . ' days')));

      $today = strtotime(Date('Y-m-d H:i:s'));
      if ($today > $expire_date) {
        $mark = 1; //delay
      } else {
        $mark = 0; //ok
      }



      DB::table('st_process_action')
        ->updateOrInsert(
          ['id' => $rowid],
          ['action_mark' => $mark]
        );
    }
  }


  public function setUserActive(Request $request)
  {

    $arr = DB::table('users_otp')
      ->where('id', $request->id)
      ->update(['ip_verify' => 1]);

    $data = array(
      'status' => 1,
      'data' => $arr,

    );
    return response()->json($data);
  }
  public function getUserList()
  {
    $date = \Carbon\Carbon::today()->subDays(30);
    $data_arr = array();
    $userotp_arr = DB::table('users_otp')->where('ip_verify', 1)->whereDate('expiry', Carbon::today())->orderBy('id', 'DESC')->get();
    foreach ($userotp_arr as $key => $user) {

      $use_arr = AyraHelp::getUser($user->user_id);

      $loc_arr = (array)json_decode($user->location_details);
      $location = $loc_arr['region_name'] . "," . $loc_arr['city'];
      $data_arr[] = array(
        'id' => $user->id,
        'name' => $use_arr->name,
        'otp' => $user->otp,
        'id' => $user->id,
        'id' => $user->id,
        'location' => $location
      );
    }

    if (count($data_arr) > 0) {
      $data = array(
        'status' => 1,
        'data' => $data_arr,

      );
    } else {
      $data = array(
        'status' => 0,
        'data' => $data_arr

      );
    }
    return response()->json($data);
  }
  public function getUserListLive()
  {
    $date = \Carbon\Carbon::today()->subDays(30);
    $data_arr = array();
    $userotp_arr = DB::table('users_otp')->where('ip_verify', 0)->whereDate('expiry', Carbon::today())->orderBy('id', 'DESC')->get();
    foreach ($userotp_arr as $key => $user) {

      $use_arr = AyraHelp::getUser($user->user_id);

      $loc_arr = (array)json_decode($user->location_details);
      $location = $loc_arr['region_name'] . "," . $loc_arr['city'];
      $data_arr[] = array(
        'id' => $user->id,
        'name' => $use_arr->name,
        'otp' => $user->otp,
        'id' => $user->id,
        'id' => $user->id,
        'location' => $location
      );
    }

    if (count($data_arr) > 0) {
      $data = array(
        'status' => 1,
        'data' => $data_arr,

      );
    } else {
      $data = array(
        'status' => 0,
        'data' => $data_arr

      );
    }
    return response()->json($data);
  }


  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => $data['password'],
    ]);
  }
}
