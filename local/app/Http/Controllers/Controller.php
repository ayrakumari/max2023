<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mail;
use App\UserLogActivity;
use App\ClientNote;
use App\Client;
use DB;
use Carbon\Carbon;
use App\Helpers\AyraHelp;
use App\QCFORM;
use App\OrderMaster;
use App\QC_BOM_Purchase;
use App\QCPurchaseEditHistory;

use App\QCBOM;
use App\OPDaysBulk;
use App\OPDaysRepeat;
use App\OPDays;
use App\QCPP;
use App\OPData;
use App\OPDataLog;
use Auth;

include 'class-list-util.php';

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /*
//LoggedActicty
$userID=Auth::user()->id;
$LoggedName=AyraHelp::getUser($userID)->name;
$eventName="New Client Add";
$eventINFO="New Client is added by ".$LoggedName." Client Phone NO : ".$request->phone."& Name:".$request->name;
$eventID=$client_obj->id;

$created_atA=date('Y-m-d H:i:s');
$slug_name=url()->full();

$this->LoggedActicty(
  $userID,
  $eventName,
  $eventINFO,
  $eventID,
  $created_atA,
  $slug_name

);
//LoggedActicty
*/
//sendEmailSendgridWaysBulk
protected function sendEmailSendgridWaysBulk($to ,$subLineM,$body){
  require 'vendor/autoload.php';
  //$Apikey = AyraHelp::APISendKey();
  $Apikey = AyraHelp::APISendKey();

  // echo $to;
  // echo $subLineM;
  // print_r($body);
  // print_r($email_template);

  
  //$to="bointldev@gmail.com";

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("nehap@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo($to, '');
    $email->addCc('gupta@max.net', '');
    $email->addCc('pooja@max.net','Pooja Gupta');
    $email->addCc('nitika@max.net', 'Admin');
   // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $email->addContent(
      "text/html",
      $body
    );
    $sendgrid = new \SendGrid($Apikey);
    try {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
       print $response->body() . "\n";
      // $affected = DB::table('indmt_data')
      //         ->where('QUERY_ID', $rows->QUERY_ID)
      //         ->update(['email_sent' => 1]);
      //sms





      //sms


    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }


}

//sendEmailSendgridWaysBulk


protected function sendEmailSendgridWays($to ,$subLineM,$body,$email_template){
  require 'vendor/autoload.php';
  $Apikey = AyraHelp::APISendKey();
  
  
  

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@maxnovahealthcare.com", "MAX");
    $email->setSubject($subLineM);
    $email->addTo('ajay.kumardhubi@gmail.com', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    // $email->addCc('pooja@max.net','Pooja Gupta');
    // $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
  //  $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('mayank@jmac.co.in', 'Ajay');
    $email->addContent(
      "text/html",
      $body
    );
    $sendgrid = new \SendGrid($Apikey);
    try {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
      print $response->body() . "\n";
      





      //sms


    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }


}
protected function sendEmailSendgridWaysToClient($to ,$subLineM,$body,$email_template){
  require 'vendor/autoload.php';
  $Apikey = AyraHelp::APISendKey();
  // echo $to;
  // echo $subLineM;
  // print_r($body);
  // print_r($email_template);

  
  

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo($to, '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    // $email->addCc('pooja@max.net','Pooja Gupta');
    $email->addCc('account1@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
  //  $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $email->addContent(
      "text/html",
      $body
    );
    $sendgrid = new \SendGrid($Apikey);
    try {
      $response = $sendgrid->send($email);
      // print $response->statusCode() . "\n";
      // print_r($response->headers());
      // print $response->body() . "\n";
      // $affected = DB::table('indmt_data')
      //         ->where('QUERY_ID', $rows->QUERY_ID)
      //         ->update(['email_sent' => 1]);
      //sms





      //sms


    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }


}

protected function LeadTally($api_name,$ori_lead,$get_lead)
{
   
    DB::table('lead_tally')
    ->updateOrInsert(
        ['today_date' => date('Y-m-d'),'api_name'=>$api_name],
        [
            'ori_lead' => $ori_lead,
            'get_lead' => $get_lead,
            'last_lead_run' => date('Y-m-d H:i:s'),
        ]
    );


}


  protected function LoggedActicty($userID, $eventName, $eventINFO, $eventID, $created_at, $slug_name)
  {
    DB::table('logged_activity')->insert(
      [
        'user_id' => $userID,
        'event_name' => $eventName,
        'event_info' => $eventINFO,
        'event_id' => $eventID,
        'created_at' => $created_at,
        'slug_name' => $slug_name,

      ]
    );
  }
  protected function PRPSendSMS($phoneNO, $msg)
  {


    //Your authentication key
    $userid = "20200871";
    $pasword = "mYQG9ms9";

    //Multiple mobiles numbers separated by comma
    $mobileNumber = $phoneNO;
    //$mobileNumber = '7703886088';

    //Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = "BOINTL";
    //$msg="Testing Deat data";
    //Your message to send, Add URL encoding here.
    $message = urlencode($msg);
    $url = 'http://164.52.195.161/API/SendMsg.aspx?uname=20200871&pass=mYQG9ms9&send=BOINTL&dest=' . $mobileNumber . '&msg=' . $message . '&priority=1';

   return  $data = file_get_contents($url); // put the contents of the file into a variable




    //echo $output;

  }
  protected function PRPSendSMS_getBalance()
  {


    //Your authentication key
    
    $url = 'http://164.52.195.161/API/BalAlert.aspx?uname=20200871&pass=mYQG9ms9';

   return  $data = file_get_contents($url); // put the contents of the file into a variable




    //echo $output;

  }


  protected function msg91SendSMS($phoneNO, $msg)
  {
    //Your authentication key
    $authKey = "332216Awzufyfy5ee320a3P1";

    //Multiple mobiles numbers separated by comma
    $mobileNumber = $phoneNO;

    //Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = "BOINTL";

    //Your message to send, Add URL encoding here.
    $message = urlencode($msg);

    //Define route
    $route = "4";
    //Prepare you post parameters
    $postData = array(
      'authkey' => $authKey,
      'mobiles' => $mobileNumber,
      'message' => $message,
      'sender' => $senderId,
      'route' => $route
    );

    //API URL
    $url = "http://api.msg91.com/api/sendhttp.php";

    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $postData
      //,CURLOPT_FOLLOWLOCATION => true
    ));


    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    //get response
    $output = curl_exec($ch);

    //Print error if any
    if (curl_errno($ch)) {
      echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

    echo $output;

  }

  protected function runCRON_API($ApiName, $startDate, $endDate)
  {
    switch ($ApiName) {
      case 'API_1':
        //  api 1
        $date_1 = strtotime($startDate);
        $date_2 = strtotime($endDate);

        $start_date = date('Y-m-d', $date_1);
        $stop_date = date('Y-m-d', $date_2);



        //  $start_date =date("d-M-Y", strtotime( '-1 day' ));
        // $stop_date=date("d-M-Y");

        $url = 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/' . $start_date . '/End_Time/' . $stop_date . '/';

        $data = file_get_contents($url); // put the contents of the file into a variable
        $characters = json_decode($data); // decode the JSON feed





        foreach ($characters as $key => $row) {

          if (isset($row->Error_Message)) {
            echo $row->Error_Message;
          } else {

            $data_arr = DB::table('indmt_data')->where('QUERY_ID', $row->QUERY_ID)->first();
            if ($data_arr == null) {

              $originalDate = $row->DATE_TIME_RE;
              $newDate = date("y-m-d H:i:s", strtotime($originalDate));

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
                  'data_source' => 'INDMART-9999955922@API_1',
                  'data_source_ID' => 1,
                  'created_at' => date('Y-m-d H:i:s'),
                  'DATE_TIME_RE_SYS' => $newDate,
                  'assign_to' => 77,

                ]
              );
            }
          }
        }

        //----------------------------------

        $tday = date('Y-m-d', $date_2);
        $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-9999955922@API_1')->first();
        if ($data_arr == null) {

          DB::table('leadcron_run_log')->insert(
            [

              'lrun_day_date' => date('Y-m-d', $date_2),
              'last_update' => date('Y-m-d H:i:s'),
              'api_details' => 'INDMART-9999955922@API_1',
              'st_date' => $start_date,
              'stop_date' => $stop_date,
              'run_status' => 1

            ]
          );
        } else {
          $arr = DB::table('leadcron_run_log')
            ->where('lrun_day_date',  date('Y-m-d', $date_2))
            ->where('api_details', 'INDMART-9999955922@API_1')
            ->update([
              'last_update' => date('Y-m-d H:i:s'),
              'run_status' => 1,
            ]);
        }
        //-------------------------------------------


        echo "Completed 1";


        echo 1;
        //  api 1
        break;
      case 'API_2':
        //  api 2
        $date_1 = strtotime($startDate);
        $date_2 = strtotime($endDate);

        $start_date = date('Y-m-d', $date_1);
        $stop_date = date('Y-m-d', $date_2);



        //$start_date =date("d-M-Y", strtotime( '-1 day' ));
        //$stop_date=date("d-M-Y");

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
              $newDate = date("y-m-d H:i:s", strtotime($originalDate));

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
                  'assign_to' => 77,

                ]
              );
            }
          }
        }

        //----------------------------------
        $tday = date('Y-m-d', $date_2);
        $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'INDMART-8929503295@API_2')->first();
        if ($data_arr == null) {

          DB::table('leadcron_run_log')->insert(
            [

              'lrun_day_date' => date('Y-m-d', $date_2),
              'last_update' => date('Y-m-d H:i:s'),
              'api_details' => 'INDMART-8929503295@API_2',
              'st_date' => $start_date,
              'stop_date' => $stop_date,
              'run_status' => 1

            ]
          );
        } else {
          $arr = DB::table('leadcron_run_log')
            ->where('lrun_day_date', date('Y-m-d', $date_2))
            ->where('api_details', 'INDMART-8929503295@API_2')
            ->update([
              'last_update' => date('Y-m-d H:i:s'),
              'run_status' => 1,
            ]);
        }
        //-------------------------------------------


        echo "Completed 2";

        //  api 2
        break;
      case 'API_3':

        $date_1 = strtotime($startDate);
        $date_2 = strtotime($endDate);

        $start_date = date('Y-m-d', $date_1);
        $stop_date = date('Y-m-d', $date_1);

        // $start_date =date("Y-m-d");
        // $stop_date=date("Y-m-d");

        //$url='https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/8929503295/GLUSR_MOBILE_KEY/MTU3ODk5OTM0OC4wMTkyIzI3NDI0MjUx/Start_Time/'.$start_date.'/End_Time/'.$stop_date.'/';
        $url = 'https://www.tradeindia.com/utils/my_inquiry.html?userid=8850185&profile_id=12475609&key=43d616a4bf6566bb07c1249f2605deb8&from_date=' . $start_date . '&to_date=' . $stop_date . '&limit=200';

        $data = file_get_contents($url); // put the contents of the file into a variable
        $characters = json_decode($data); // decode the JSON feed

        foreach ($characters as $key => $row) {

          if (isset($row->Error_Message)) {
            echo $row->Error_Message;
          } else {

            $QUERY_ID = intval(date('Y') . '1' . $row->generated);

            $data_arr = DB::table('indmt_data')->where('QUERY_ID', $QUERY_ID)->first();
            if ($data_arr == null) {

              $originalDate = $row->generated_date . ' ' . $row->generated_time;
              $newDate = date("Y-m-d H:i:s", strtotime($originalDate));

              $DATE_TIME_RE = date("d-M-Y H:i:s A", strtotime($originalDate));
              //06-Jan-2020 05:19:11 PM
              DB::table('indmt_data')->insert(
                [

                  'SENDERNAME' => $row->sender_name,
                  'SENDEREMAIL' => $row->sender_email,
                  'SUBJECT' => $row->subject,
                  'DATE_TIME_RE' => $DATE_TIME_RE,
                  'GLUSR_USR_COMPANYNAME' => '',
                  'MOB' => $row->sender_mobile,
                  'COUNTRY_FLAG' => '',
                  'ENQ_MESSAGE' => $row->message,
                  'ENQ_ADDRESS' => $row->address,
                  'ENQ_CITY' => $row->sender_city,
                  'ENQ_STATE' => $row->sender_state,
                  'PRODUCT_NAME' => $row->product_name,
                  'COUNTRY_ISO' => $row->sender_country,
                  'EMAIL_ALT' => $row->sender_other_emails,
                  'MOBILE_ALT' => $row->sender_other_mobiles,
                  'PHONE' => '',
                  'PHONE_ALT' => '',
                  'IM_MEMBER_SINCE' => $row->member_since,
                  'QUERY_ID' => $QUERY_ID,
                  'QTYPE' => 'W',
                  'ENQ_CALL_DURATION' => '',
                  'ENQ_RECEIVER_MOB' => '',
                  'data_source' => 'TRADEINDIA-8850185@API_3',
                  'data_source_ID' => 3,
                  'created_at' => date('Y-m-d H:i:s'),
                  'DATE_TIME_RE_SYS' => $newDate,
                  'assign_to' => 77,
                  'json_api_data' => $data,

                ]
              );
            }
          }
        }

        //----------------------------------
        $tday = date('Y-m-d', $date_2);
        $data_arr = DB::table('leadcron_run_log')->where('lrun_day_date', $tday)->where('api_details', 'TRADEINDIA-8850185@API_3')->first();
        if ($data_arr == null) {

          DB::table('leadcron_run_log')->insert(
            [

              'lrun_day_date' => date('Y-m-d', $date_2),
              'last_update' => date('Y-m-d H:i:s'),
              'api_details' => 'TRADEINDIA-8850185@API_3',
              'st_date' => $start_date,
              'stop_date' => $stop_date,
              'run_status' => 1

            ]
          );
        } else {
          $arr = DB::table('leadcron_run_log')
            ->where('lrun_day_date', date('Y-m-d', $date_2))
            ->where('api_details', 'TRADEINDIA-8850185@API_3')
            ->update([
              'last_update' => date('Y-m-d H:i:s'),
              'run_status' => 1,
            ]);
        }
        //-------------------------------------------


        echo "Completed 3";

        //  api 3
        break;
    }
  }

  protected function saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, $at_stage_id = NULL, $sechule_date_time = NULL, $chat_type = NULL)
  {
    DB::table('lead_chat_histroy')->insert(
      [
        'QUERY_ID' => $QUERY_ID,
        'user_id' => $user_id,
        'msg_desc' => $msg_desc,
        'msg' => $msg,
        'created_at' => date('Y-m-d H:i:s'),
        'at_stage_id' => $at_stage_id,
        'sechule_date_time' => $sechule_date_time,
        'chat_type' => $chat_type,


      ]
    );
  }
  // updatePurchaseListQCEDIt
  protected function updatePurchaseListQCEDIt($form_id)
  {
    $bom_stated = DB::table('st_process_action')
      ->where('ticket_id', $form_id)
      ->where('action_status', 1)
      ->first();
    if ($bom_stated != null) {
      $bom_arrs = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
      $QCData = AyraHelp::getQCFormDate($form_id);

      foreach ($bom_arrs as $key_bom_arr => $bom_arr) {
        $form_id = $bom_arr->form_id;
        $m_name = optional($bom_arr)->m_name;
        $qty = optional($bom_arr)->qty;
        $size = optional($bom_arr)->size;
        $bom_from = optional($bom_arr)->bom_from;
        $bom_cat = optional($bom_arr)->bom_cat;
        if ($bom_from == 'From Client' || $bom_from == 'N/A') {

          $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)
            ->where('material_name', $m_name)
            ->first();
          if ($qcPurchase_arrs == null) {
            QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->update([
                'update_status' => 2, //from client
              ]);
          } else {
            // QC_BOM_Purchase::where('form_id',$form_id)->where('material_name',$m_name)->delete(); //delete history
            QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->update([
                'update_status' => 2, //from client
              ]);
          }
        } else {
          //bom update
          $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)
            ->where('material_name', $m_name)
            ->first();
          if ($qcPurchase_arrs == null) {
            $qcbomPObj = new QC_BOM_Purchase;
            $qcbomPObj->order_id = $QCData->order_id;
            $qcbomPObj->form_id = $QCData->form_id;
            $qcbomPObj->sub_order_index = $QCData->subOrder;
            $qcbomPObj->order_name = $QCData->brand_name;
            $qcbomPObj->order_cat = $bom_cat;
            $qcbomPObj->material_name = $m_name;
            $qcbomPObj->qty = $qty;
            $qcbomPObj->status = 1;
            $qcbomPObj->created_by = Auth::user()->id;
            $qcbomPObj->save();
          } else {

            $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->where('status', 5)
              ->first();
            if ($qcPurchase_arrs != null) {
              $qcPurchase_arrsLtF = QC_BOM_Purchase::where('form_id', $form_id)
                ->where('material_name', $m_name)
                ->latest()->first();

              $qtytemp = $qty - $qcPurchase_arrsLtF->qty;
              if ($qtytemp > 0) {
                $qcbomPObj = new QC_BOM_Purchase;
                $qcbomPObj->order_id = $QCData->order_id;
                $qcbomPObj->form_id = $QCData->form_id;
                $qcbomPObj->sub_order_index = $QCData->subOrder;
                $qcbomPObj->order_name = $QCData->brand_name;
                $qcbomPObj->order_cat = $bom_cat;
                $qcbomPObj->material_name = $m_name;
                $qcbomPObj->qty = $qtytemp;
                $qcbomPObj->status = 1;
                $qcbomPObj->created_by = Auth::user()->id;
                $qcbomPObj->update_status = 1;
                $qcbomPObj->save();
              }
            } else {


              $qcPurchase_arrs_new = QC_BOM_Purchase::where('form_id', $form_id)
                ->where('material_name', $m_name)
                ->where('qty', $qty)
                ->first();
              if ($qcPurchase_arrs == null) {

                QC_BOM_Purchase::where('form_id', $form_id)
                  ->where('material_name', $m_name)
                  ->update([
                    'order_cat' => $bom_cat,
                    'qty' => $qty,

                  ]);
              } else {
                QC_BOM_Purchase::where('form_id', $form_id)
                  ->where('material_name', $m_name)
                  ->update([
                    'order_cat' => $bom_cat,
                    'qty' => $qty,
                    'update_status' => 1,
                  ]);
              }
            }
          }

          //bom update
        }
      }
    }
  }
  protected function updatePurchaseListQCEDIt_30DEC($form_id)
  {



    $bom_stated = DB::table('st_process_action')
      ->where('ticket_id', $form_id)
      ->where('action_status', 1)
      ->first();
    if ($bom_stated != null) {

      $bom_arrs = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
      $QCData = AyraHelp::getQCFormDate($form_id);

      foreach ($bom_arrs as $key_bom_arr => $bom_arr) {
        $form_id = $bom_arr->form_id;
        $m_name = optional($bom_arr)->m_name;
        $qty = optional($bom_arr)->qty;
        $size = optional($bom_arr)->size;
        $bom_from = optional($bom_arr)->bom_from;
        $bom_cat = optional($bom_arr)->bom_cat;

        if ($bom_from == 'From Client' || $bom_from == 'N/A') {

          $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)
            ->where('material_name', $m_name)
            ->first();
          if ($qcPurchase_arrs == null) {
            QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->update([
                'update_status' => 2, //from client
              ]);
          } else {
            // QC_BOM_Purchase::where('form_id',$form_id)->where('material_name',$m_name)->delete(); //delete history
            QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->update([
                'update_status' => 2, //from client
              ]);
          }
        } else {

          $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)
            ->where('material_name', $m_name)
            ->first();

          if ($qcPurchase_arrs == null) {

            $qcbomPObj = new QC_BOM_Purchase;
            $qcbomPObj->order_id = $QCData->order_id;
            $qcbomPObj->form_id = $QCData->form_id;
            $qcbomPObj->sub_order_index = $QCData->subOrder;
            $qcbomPObj->order_name = $QCData->brand_name;
            $qcbomPObj->order_cat = $bom_cat;
            $qcbomPObj->material_name = $m_name;
            $qcbomPObj->qty = $qty;
            $qcbomPObj->status = 1;
            $qcbomPObj->created_by = Auth::user()->id;
            $qcbomPObj->save();
          } else {

            $qcPurchase_arrs_new = QC_BOM_Purchase::where('form_id', $form_id)
              ->where('material_name', $m_name)
              ->where('qty', $qty)
              ->first();
            if ($qcPurchase_arrs == null) {

              QC_BOM_Purchase::where('form_id', $form_id)
                ->where('material_name', $m_name)
                ->update([
                  'order_cat' => $bom_cat,
                  'qty' => $qty,

                ]);
            } else {
              QC_BOM_Purchase::where('form_id', $form_id)
                ->where('material_name', $m_name)
                ->update([
                  'order_cat' => $bom_cat,
                  'qty' => $qty,
                  'update_status' => 1,
                ]);
            }




            $qcbomPObj = new QCPurchaseEditHistory;
            $qcbomPObj->order_id = $QCData->order_id;
            $qcbomPObj->form_id = $QCData->form_id;
            $qcbomPObj->sub_order_index = $QCData->subOrder;
            $qcbomPObj->order_name == $QCData->brand_name;
            $qcbomPObj->order_cat = $bom_cat;
            $qcbomPObj->material_name = $m_name;
            $qcbomPObj->qty = $qty;
            $qcbomPObj->status = 1;
            $qcbomPObj->created_by = Auth::user()->id;
            $qcbomPObj->save();
          }
        }
      }
    }
    //update code
    // $users = DB::table('qc_bo_purchaselist')
    //       ->join('qc_forms_bom', 'qc_bo_purchaselist.form_id', '=', 'qc_forms_bom.form_id')
    //       ->where('qc_forms_bom.m_name', '=', 'qc_bo_purchaselist.material_name')
    //       ->get();


    //update code


  }
  protected function updatePurchaseListQCEDIt_25DEC($form_id)
  {
    $bom_arrs = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();

    $QCData = AyraHelp::getQCFormDate($form_id);

    QCPurchaseEditHistory::where('form_id', $form_id)->delete(); //delete history

    $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)->get();

    if (count($qcPurchase_arrs) > 0) {

      foreach ($qcPurchase_arrs as $key_qcPurchase_arrs => $qcPurchase_arr) {

        $qcbomPObj = new QCPurchaseEditHistory;
        $qcbomPObj->order_id = $qcPurchase_arr->order_id;
        $qcbomPObj->form_id = $qcPurchase_arr->form_id;
        $qcbomPObj->sub_order_index = $qcPurchase_arr->sub_order_index;
        $qcbomPObj->order_name = $qcPurchase_arr->order_name;
        $qcbomPObj->order_cat = $qcPurchase_arr->order_cat;
        $qcbomPObj->material_name = $qcPurchase_arr->material_name;
        $qcbomPObj->qty = $qcPurchase_arr->qty;
        $qcbomPObj->status = $qcPurchase_arr->status;
        $qcbomPObj->created_by = $qcPurchase_arr->created_by;
        $qcbomPObj->save();
      }
    }

    QC_BOM_Purchase::where('form_id', $form_id)->delete(); //delete purchase list
    //=============

    //if milta hi then detail dekhaye nahi milta hi then  insert new and
    //delete where form id and  changed_flag=0
    foreach ($bom_arrs as $key_bom_arr => $bom_arr) {
      $form_id = $bom_arr->form_id;
      $m_name = optional($bom_arr)->m_name;
      $qty = optional($bom_arr)->qty;
      $size = optional($bom_arr)->size;
      $bom_from = optional($bom_arr)->bom_from;
      $bom_cat = optional($bom_arr)->bom_cat;



      if ($bom_from == 'From Client' || $bom_from == 'N/A') {
      } else {

        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $QCData->order_id;
        $qcbomPObj->form_id = $QCData->form_id;
        $qcbomPObj->sub_order_index = $QCData->subOrder;
        $qcbomPObj->order_name = $QCData->brand_name;
        $qcbomPObj->order_cat = $bom_cat;
        $qcbomPObj->material_name = $m_name;
        $qcbomPObj->qty = $qty;
        $qcbomPObj->status = 1;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }
  }
  protected function updatePurchaseListQCEDItSK($form_id)
  {
    //-----------------end


    //$res=QC_BOM_Purchase::where('form_id',$form_id)->delete();
    //get data from QCBOM :
    $bom_arrs = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();

    $QCData = AyraHelp::getQCFormDate($form_id);



    foreach ($bom_arrs as $key_bom_arr => $bom_arr) {
      $form_id = $bom_arr->form_id;
      $m_name = optional($bom_arr)->m_name;
      $qty = optional($bom_arr)->qty;
      $size = optional($bom_arr)->size;
      $bom_from = optional($bom_arr)->bom_from;
      $bom_cat = optional($bom_arr)->bom_cat;

      $qcPurchase_arrs = QC_BOM_Purchase::where('form_id', $form_id)->get();
      if (count($qcPurchase_arrs) > 0) {
        echo "welcome";
        die;

        foreach ($qcPurchase_arrs as $key_qcPurchase_arrs => $qcPurchase_arr) {
          if ($qcPurchase_arr->material_name == $m_name) {

            $old_data = array(
              'material_name' => $qcPurchase_arr->material_name,
              'order_cat' => $qcPurchase_arr->order_cat,
              'qty' => $qcPurchase_arr->order_cat,
              'new_material_name' => $m_name,
              'new_order_cat' => $bom_cat,
              'new_qty' => $qty,

            );


            if ($bom_from == 'From Client' || $bom_from == 'N/A') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $QCData->order_id;
              $qcbomPObj->form_id = $form_id;
              $qcbomPObj->sub_order_index = $QCData->subOrder;
              $qcbomPObj->order_name = $QCData->brand_name;

              $qcbomPObj->order_cat = $bom_cat;
              $qcbomPObj->material_name = $m_name;
              $qcbomPObj->qty = $qty;

              $qcbomPObj->created_by = Auth::user()->id;

              $qcbomPObj->changed_flag = 1;
              $qcbomPObj->changed_details = json_encode($old_data);
              $qcbomPObj->accept_changed_flag = 0;
              $qcbomPObj->save();
            }
          } else {
            $old_data = array(
              'material_name' => optional($qcPurchase_arr)->material_name,
              'order_cat' => optional($qcPurchase_arr)->order_cat,
              'qty' => optional($qcPurchase_arr)->order_cat,
              'new_material_name' => $m_name,
              'new_order_cat' => $bom_cat,
              'new_qty' => $qty,

            );


            if ($bom_from == 'From Client' || $bom_from == 'N/A') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $QCData->order_id;
              $qcbomPObj->form_id = $form_id;
              $qcbomPObj->sub_order_index = $QCData->subOrder;
              $qcbomPObj->order_name = $QCData->brand_name;

              $qcbomPObj->order_cat = $bom_cat;
              $qcbomPObj->material_name = $m_name;
              $qcbomPObj->qty = $qty;

              $qcbomPObj->created_by = Auth::user()->id;

              $qcbomPObj->changed_flag = 1;
              $qcbomPObj->changed_details = json_encode($old_data);
              $qcbomPObj->accept_changed_flag = 0;
              $qcbomPObj->save();
            }
          }
        }
      } else {

        if ($bom_from == 'From Client' || $bom_from == 'N/A') {
        } else {

          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $QCData->order_id;
          $qcbomPObj->form_id = $form_id;
          $qcbomPObj->sub_order_index = $QCData->subOrder;
          $qcbomPObj->order_name = $QCData->brand_name;

          $qcbomPObj->order_cat = $bom_cat;
          $qcbomPObj->material_name = $m_name;
          $qcbomPObj->qty = $qty;

          $qcbomPObj->created_by = Auth::user()->id;


          $qcbomPObj->save();
        }
      }





      //delete old data : this will del all old data
      $res = QC_BOM_Purchase::where('form_id', $form_id)->where('changed_flag', 0)->delete();
    }
  }
  // updatePurchaseListQCEDIt


  // saveToOrderMaster
  protected function saveToOrderMaster($form_id, $assign_userid, $order_statge_id, $assigned_by, $action_start)
  {
    if ($action_start == 1) {
      $completed_on = date('Y-m-d H:i:s');
      $data_out = OPDaysBulk::where('step_code', $order_statge_id)->first();
      $expencted_date = Carbon::parse($completed_on)->addDays($data_out->process_days);

      $action_mark = 1;
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $form_id;
      $mstOrderObj->assign_userid = $assign_userid;
      $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
      $mstOrderObj->assigned_by = $assigned_by;
      $mstOrderObj->action_status = $action_start;
      $mstOrderObj->completed_on = $completed_on;
      $mstOrderObj->action_mark = $action_mark;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();

      //next assin
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $form_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = $order_statge_id;
      $mstOrderObj->assigned_by = $assigned_by;
      $mstOrderObj->action_status = 0;
      $mstOrderObj->completed_on = $completed_on;
      $mstOrderObj->action_mark = $action_mark;
      $mstOrderObj->expected_date = $expencted_date;
      $mstOrderObj->assigned_team = 4; //perchase team assign
      $mstOrderObj->save();
    } else {
      $qc_data = AyraHelp::getQCFORMData($form_id);
      $order_type = $qc_data->order_type;
      $order_repeat = $qc_data->order_repeat;
      if ($order_type == 'Private Label' && $order_repeat == '1') {
        $completed_on = date('Y-m-d H:i:s');
        $action_mark = 1;
        $mstOrderObj = new OrderMaster;
        $mstOrderObj->form_id = $form_id;
        $mstOrderObj->assign_userid = 0;
        $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
        $mstOrderObj->assigned_by = $assigned_by;
        $mstOrderObj->action_status = 0;
        $mstOrderObj->completed_on = $completed_on;
        $mstOrderObj->action_mark = $action_mark;
        $mstOrderObj->assigned_team = 1; //sales user
        $mstOrderObj->save();
      } else {

        //repeart order

        $mydata = AyraHelp::isBoxLabelFromClient($form_id);
        if ($mydata) {

          $completed_on = date('Y-m-d H:i:s');
          $action_mark = 1;
          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $form_id;
          $mstOrderObj->assign_userid = $assign_userid;
          $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
          $mstOrderObj->assigned_by = $assigned_by;
          $mstOrderObj->action_status = 1;
          $mstOrderObj->completed_on = $completed_on;
          $mstOrderObj->action_mark = $action_mark;
          $mstOrderObj->assigned_team = 1; //sales user
          $mstOrderObj->save();


          $completed_on = date('Y-m-d H:i:s');
          $action_mark = 1;
          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $form_id;
          $mstOrderObj->assign_userid = $assign_userid;
          $mstOrderObj->order_statge_id = 'PURCHASE_LABEL_BOX';
          $mstOrderObj->assigned_by = $assigned_by;
          $mstOrderObj->action_status = 1;
          $mstOrderObj->completed_on = $completed_on;
          $mstOrderObj->action_mark = $action_mark;
          $mstOrderObj->assigned_team = 1; //sales user
          $mstOrderObj->save();

          $completed_on = date('Y-m-d H:i:s');
          $action_mark = 1;
          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $form_id;
          $mstOrderObj->assign_userid = $assign_userid;
          $mstOrderObj->order_statge_id = 'PRODUCTION';
          $mstOrderObj->assigned_by = $assigned_by;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = $completed_on;
          $mstOrderObj->action_mark = $action_mark;
          $mstOrderObj->assigned_team = 1; //sales user
          $mstOrderObj->save();
        } else {
          $completed_on = date('Y-m-d H:i:s');
          $action_mark = 1;

          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $form_id;
          $mstOrderObj->assign_userid = $assign_userid;
          $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
          $mstOrderObj->assigned_by = $assigned_by;
          $mstOrderObj->action_status = 1;
          $mstOrderObj->completed_on = $completed_on;
          $mstOrderObj->action_mark = $action_mark;
          $mstOrderObj->assigned_team = 1; //sales user
          $mstOrderObj->save();


          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $form_id;
          $mstOrderObj->assign_userid = $assign_userid;
          $mstOrderObj->order_statge_id = 'PURCHASE_LABEL_BOX';
          $mstOrderObj->assigned_by = $assigned_by;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = $completed_on;
          $mstOrderObj->action_mark = $action_mark;
          $mstOrderObj->assigned_team = 1; //sales user
          $mstOrderObj->save();
        }

        //repeart order

      }
    }
  }

  //getRepeatOrderWizardSteps
  protected function getRepeatOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr)
  {


    $data_arr_1 = array(
      'form_id' => $orderList->form_id,
      'client_email' => optional($orderList)->client_email,
      'order_id' => $orderList->order_id,
      'sub_order_id' => $orderList->subOrder,
      'order_id_withsub' => strval($orderList->order_index . "/" . $orderList->subOrder),
      'brand_name' => $orderList->brand_name,
      'Qty' => $orderList->item_qty,
      'item_name' => $orderList->item_name,
      'order_repeat' => $orderList->order_repeat == 2 ? 'REPEAT' : 'NEW',
      'order_type' => $orderList->order_type,
      'artwork_status' => $orderList->artwork_status,
      'artwork_start_date' => $orderList->artwork_start_date,
      'created_by' => $user_arr->name,
      'created_on' => $orderList->created_at,
      'orderSteps' => $opBo_Arr,
      'process_wizard' => $dataOPD_arr,
    );
    return $data_arr_1;
  }
  //getRepeatOrderWizardSteps
  //getBulkOrderWizardSteps
  protected function getBulkOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr)
  {
    $data_arr_1 = array(
      'form_id' => $orderList->form_id,
      'client_email' => optional($orderList)->client_email,
      'order_id' => $orderList->order_id,
      'sub_order_id' => $orderList->subOrder,
      'order_id_withsub' => strval($orderList->order_index . "/" . $orderList->subOrder),
      'brand_name' => $orderList->brand_name,
      'Qty' => $orderList->item_qty,
      'item_name' => $orderList->item_name,
      'order_repeat' => $orderList->order_repeat == 2 ? 'REPEAT' : 'NEW',
      'order_type' => $orderList->order_type,
      'artwork_status' => $orderList->artwork_status,
      'artwork_start_date' => $orderList->artwork_start_date,
      'created_by' => $user_arr->name,
      'created_on' => $orderList->created_at,
      'orderSteps' => $opBo_Arr,
      'process_wizard' => $dataOPD_arr,
    );
    return $data_arr_1;
  }
  //getBulkOrderWizardSteps


  //getPrivateOrderWizardSteps
  protected function getPrivateOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr)
  {
    $data_arr_1 = array(
      'form_id' => $orderList->form_id,
      'client_email' => optional($orderList)->client_email,
      'order_id' => $orderList->order_id,
      'sub_order_id' => $orderList->subOrder,
      'order_id_withsub' => strval($orderList->order_index . "/" . $orderList->subOrder),

      'brand_name' => $orderList->brand_name,
      'Qty' => $orderList->item_qty,
      'item_name' => $orderList->item_name,
      'order_repeat' => $orderList->order_repeat == 2 ? 'REPEAT' : 'NEW',
      'order_type' => $orderList->order_type,
      'artwork_status' => $orderList->artwork_status,
      'artwork_start_date' => $orderList->artwork_start_date,
      'created_by' => $user_arr->name,
      'created_on' => $orderList->created_at,
      'orderSteps' => $opBo_Arr,
      'process_wizard' => $dataOPD_arr,
    );
    return $data_arr_1;
  }

  protected function getOrderWizardStepsFormID($form_Id)
  {
    $data_arr_1 = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    if ($user_role == 'Admin' || $user_role == 'User' || $user_role == 'Staff' || $user_role == 'SalesHead' || $user_role == 'CourierTrk') {
      $orderLists = QCFORM::where('form_id', $form_Id)->where('is_deleted', 0)->get();
    } else {
      $orderLists = QCFORM::where('form_id', $form_Id)->where('is_deleted', 0)->where('created_by', Auth::user()->id)->get();
    }
    //loop
    $dataOPD_arr = OPData::where('order_id_form_id', $form_Id)->where('status', 1)->get()->toArray();

    foreach ($orderLists as $key_orderLists => $orderList) {
      $user_arr =  AyraHelp::getUser($orderList->created_by);
      $form_Id = $orderList->form_id;
      $opBo_Arr = array();
      $max_id_step = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->max('step_id') + 1;
      $max_id_step_data = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->where('step_id', \DB::raw("(select max(`step_id`) from order_process_data)"))->get();
      $date_created = '';
      if (count($max_id_step_data) > 0) {
        $date_created = $max_id_step_data[0]->created_at;
      }

      if ($orderList->order_repeat == 2) { //2 for reperat order 1=no repeat order
        if ($orderList->order_type == 'Private Label') {
          $opd_arr = OPDaysRepeat::get(); //private order
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getPrivateOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        } else {
          $opd_arr = OPDaysBulk::get();
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getBulkOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
      } else {
        if ($orderList->order_type == 'Bulk') { //bulk order
          $opd_arr = OPDaysBulk::get();
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getBulkOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
        if ($orderList->order_type == 'Private Label') {
          $opd_arr = OPDays::get(); //private order
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getPrivateOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
      }
    }
    //loop

    $JSON_Data = json_encode($data_arr_1);

    $columnsDefault = [
      'form_id'     => true,
      'client_email'     => true,
      'order_id'     => true,
      'brand_name'     => true,
      'item_name'     => true,
      'order_repeat'     => true,
      'order_type'     => true,
      'artwork_status'     => true,
      'artwork_start_date'     => true,
      'created_by'  => true,
      'created_on'  => true,
      'orderSteps'  => true,
      'process_wizard'  => true,
      'Actions'      => true,
    ];
    return $data_arr_1;
    // $this->DataGridResponse($JSON_Data,$columnsDefault);

  }

  //getPrivateOrderWizardSteps

  protected function getOrderWizardSteps()
  {
    $data_arr_1 = array();

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $orderLists = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->get();
    } else {
      $orderLists = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->where('created_by', Auth::user()->id)->get();
    }
    //loop
    $dataOPD_arr = OPData::where('status', 1)->get()->toArray();

    foreach ($orderLists as $key_orderLists => $orderList) {
      $user_arr =  AyraHelp::getUser($orderList->created_by);
      $form_Id = $orderList->form_id;
      $opBo_Arr = array();
      $max_id_step = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->max('step_id') + 1;
      $max_id_step_data = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->where('step_id', \DB::raw("(select max(`step_id`) from order_process_data)"))->get();
      $date_created = '';
      if (count($max_id_step_data) > 0) {
        $date_created = $max_id_step_data[0]->created_at;
      }

      if ($orderList->order_repeat == 2) { //2 for reperat order 1=no repeat order
        if ($orderList->order_type == 'Private Label') {
          $opd_arr = OPDaysRepeat::get(); //private order
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getPrivateOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        } else {
          $opd_arr = OPDaysBulk::get();
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getBulkOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
      } else {
        if ($orderList->order_type == 'Bulk') { //bulk order
          $opd_arr = OPDaysBulk::get();
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getBulkOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
        if ($orderList->order_type == 'Private Label') {
          $opd_arr = OPDays::get(); //private order
          $opBo_Arr = $this->getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created);
          $data_arr_1[] = $this->getPrivateOrderWizardSteps($orderList, $user_arr, $opBo_Arr, $dataOPD_arr);
        }
      }
    }
    //loop

    $JSON_Data = json_encode($data_arr_1);

    $columnsDefault = [
      'form_id'     => true,
      'client_email'     => true,
      'order_id'     => true,
      'brand_name'     => true,
      'Qty'     => true,
      'item_name'     => true,
      'order_repeat'     => true,
      'order_type'     => true,
      'artwork_status'     => true,
      'artwork_start_date'     => true,
      'created_by'  => true,
      'created_on'  => true,
      'orderSteps'  => true,
      'process_wizard'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  protected function getOrderCompileWithFormID($opd_arr, $form_Id, $max_id_step, $date_created)
  {

    foreach ($opd_arr as $key_opd_arr => $opd_arr_val) {
      $dataOPDs = OPData::where('step_id', $opd_arr_val->order_step)->where('status', 1)->where('status', 1)->where('order_id_form_id', $form_Id)->first();
      $user = auth()->user();
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user_role == 'SalesUser') {
        $SalesUser = 1;
      } else {
        $SalesUser = 0;
      }

      if (Auth::user()->hasPermissionTo('orderStatgeMaintain')) {
        $p_OrderUpdate = 1;
      } else {
        $p_OrderUpdate = 0;
      }
      $abc = 0;
      if (Auth::user()->hasPermissionTo('designStageMaintainPermission')) {

        if ($opd_arr_val->assign_userid == 82) {
          $abc = Auth::user()->id;
        } else {
          $abc = $opd_arr_val->assign_userid;
        }
      } else {
        $p_OrderUpdate = 1;
      }


      if ($dataOPDs != null) {
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dataOPDs->expected_date);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dataOPDs->process_date);




        $diff_in_days = $to->diffInDays($from);

        $opBo_Arr[] = array(
          'order_step' => $opd_arr_val->order_step,
          'process_days' => $opd_arr_val->process_days,
          'process_name' => $opd_arr_val->process_name,
          'order_type' => '1',
          'assign_userid' => $abc,
          'step_code' => $opd_arr_val->step_code,
          'step_done' => 1,
          'sales_User_permission' => $opd_arr_val->SalesUser,
          'sales_Userornot' => $SalesUser,
          'pOrderUpdate' => $p_OrderUpdate,
          'order_form_id' => $form_Id,
          'next_STEP' => $max_id_step,
          'pro_days' => $diff_in_days,
          'color_code' => $dataOPDs->color_code,
          'date_created' => $date_created,


        );
      } else {
        $opBo_Arr[] = array(
          'order_step' => $opd_arr_val->order_step,
          'process_days' => $opd_arr_val->process_days,
          'process_name' => $opd_arr_val->process_name,
          'order_type' => '1',
          'sales_User_permission' => $opd_arr_val->SalesUser,
          'sales_Userornot' => $SalesUser,
          'pOrderUpdate' => $p_OrderUpdate,
          'assign_userid' => $abc,
          'step_code' => $opd_arr_val->step_code,
          'step_done' => 0,
          'order_form_id' => $form_Id,
          'next_STEP' => $max_id_step
        );
      }
    }
    return $opBo_Arr;
  }

  protected function getDispachedUnits($model_name, $date_filter)
  {
    $arreglo = app("App\\$model_name");
    $chartDatas = $arreglo::select([
      DB::raw('DATE(' . $date_filter . ') AS date'),
      DB::raw('SUM(total_unit) AS count'),
    ])
      ->whereBetween($date_filter, [Carbon::now()->subDays(30), Carbon::now()])
      ->groupBy('date')
      ->orderBy('date', 'DESC')
      ->get()
      ->toArray();


    $chartDataByDay = array();
    foreach ($chartDatas as $data) {
      $chartDataByDay[$data['date']] = $data['count'];
    }

    $date = new Carbon;
    for ($i = 0; $i < 30; $i++) {
      $dateString = $date->format('Y-m-d');
      if (!isset($chartDataByDay[$dateString])) {
        $chartDataByDay[$dateString] = 0;
      }
      $date->subDay();
    }



    $array = array();
    foreach ($chartDataByDay as $key => $value) {
      $key = date('Y-m-d', strtotime($key));
      $array[$key] = $value;
    }
    ksort($array);
    $notes_arr = $array;
    return $notes_arr;
  }




  protected function getBarGraphStackDataAssigned($model_name, $date_filter, $user_id = NULL, $user_field)
  {
    $arreglo = app("App\\$model_name");
    $chartDatas = $arreglo::select([
      DB::raw('DATE(' . $date_filter . ') AS date'),
      DB::raw('COUNT(id) AS count'),
    ])
      ->whereBetween($date_filter, [Carbon::now()->subDays(29), Carbon::now()])
      // ->where($user_field,$user_id)
      ->where('action_on', 1)
      ->where('stage_id', 1)
      ->groupBy('date')
      ->orderBy('date', 'DESC')
      ->get()
      ->toArray();


    $chartDataByDay = array();
    foreach ($chartDatas as $data) {
      $chartDataByDay[$data['date']] = $data['count'];
    }

    $date = new Carbon;
    for ($i = 0; $i < 30; $i++) {
      $dateString = $date->format('Y-m-d');
      if (!isset($chartDataByDay[$dateString])) {
        $chartDataByDay[$dateString] = 0;
      }
      $date->subDay();
    }



    $array = array();
    foreach ($chartDataByDay as $key => $value) {
      $key = date('Y-m-d', strtotime($key));
      $array[$key] = $value;
    }
    ksort($array);
    $notes_arr = $array;
    return $notes_arr;
  }


  protected function getBarGraphStackDataFresh($model_name, $date_filter, $user_id = NULL, $user_field)
  {
    $arreglo = app("App\\$model_name");
    $chartDatas = $arreglo::select([
      DB::raw('DATE(' . $date_filter . ') AS date'),
      DB::raw('COUNT(id) AS count'),
    ])
      ->whereBetween($date_filter, [Carbon::now()->subDays(29), Carbon::now()])
      // ->where($user_field,$user_id)
      //->where('lead_status',0)
      ->groupBy('date')
      ->orderBy('date', 'DESC')
      ->get()
      ->toArray();


    $chartDataByDay = array();
    foreach ($chartDatas as $data) {
      $chartDataByDay[$data['date']] = $data['count'];
    }

    $date = new Carbon;
    for ($i = 0; $i < 30; $i++) {
      $dateString = $date->format('Y-m-d');
      if (!isset($chartDataByDay[$dateString])) {
        $chartDataByDay[$dateString] = 0;
      }
      $date->subDay();
    }



    $array = array();
    foreach ($chartDataByDay as $key => $value) {
      $key = date('Y-m-d', strtotime($key));
      $array[$key] = $value;
    }
    ksort($array);
    $notes_arr = $array;
    return $notes_arr;
  }



  protected function getBarGraphStackDataIrrelevant($model_name, $date_filter, $user_id = NULL, $user_field)
  {
    $arreglo = app("App\\$model_name");
    $chartDatas = $arreglo::select([
      DB::raw('DATE(' . $date_filter . ') AS date'),
      DB::raw('COUNT(id) AS count'),
    ])
      ->whereBetween($date_filter, [Carbon::now()->subDays(29), Carbon::now()])
      // ->where($user_field,$user_id)
      // ->where('lead_status', 1)
      ->whereNotNull('iIrrelevant_type')
      ->groupBy('date')
      ->orderBy('date', 'DESC')
      ->get()
      ->toArray();


    $chartDataByDay = array();
    foreach ($chartDatas as $data) {
      $chartDataByDay[$data['date']] = $data['count'];
    }

    $date = new Carbon;
    for ($i = 0; $i < 30; $i++) {
      $dateString = $date->format('Y-m-d');
      if (!isset($chartDataByDay[$dateString])) {
        $chartDataByDay[$dateString] = 0;
      }
      $date->subDay();
    }



    $array = array();
    foreach ($chartDataByDay as $key => $value) {
      $key = date('Y-m-d', strtotime($key));
      $array[$key] = $value;
    }
    ksort($array);
    $notes_arr = $array;
    return $notes_arr;
  }



  protected function getBarGraphStackData($model_name, $date_filter, $user_id = NULL, $user_field)
  {
    $arreglo = app("App\\$model_name");
    $chartDatas = $arreglo::select([
      DB::raw('DATE(' . $date_filter . ') AS date'),
      DB::raw('COUNT(id) AS count'),
    ])
      ->whereBetween($date_filter, [Carbon::now()->subDays(29), Carbon::now()])
      ->where($user_field, $user_id)
      ->groupBy('date')
      ->orderBy('date', 'DESC')
      ->get()
      ->toArray();


    $chartDataByDay = array();
    foreach ($chartDatas as $data) {
      $chartDataByDay[$data['date']] = $data['count'];
    }

    $date = new Carbon;
    for ($i = 0; $i < 30; $i++) {
      $dateString = $date->format('Y-m-d');
      if (!isset($chartDataByDay[$dateString])) {
        $chartDataByDay[$dateString] = 0;
      }
      $date->subDay();
    }



    $array = array();
    foreach ($chartDataByDay as $key => $value) {
      $key = date('Y-m-d', strtotime($key));
      $array[$key] = $value;
    }
    ksort($array);
    $notes_arr = $array;
    return $notes_arr;
  }

  protected function UserLogActivity($user_id, $lable = 'info', $message, $activity_type = NUll, $email_flag = NULL)
  {


    $ulaObj = new UserLogActivity;
    $ulaObj->user_id = $user_id;
    $ulaObj->lable = $lable;
    $ulaObj->message = $message;
    $ulaObj->activity_type = $activity_type;
    $ulaObj->save();

    $added_by = 'Admin';

    // if($email_flag){
    //   $data = array('name'=>$message);
    //   Mail::send(['text'=>'mail'], $data, function($message) {
    //     $message->to('ryaalmktg1@gmail.com', 'BO ADMIN')->subject
    //        ('Note Added');
    //     $message->from('bointldev@gmail.com','Admin');
    //  });
    // }else{
    //   $data = array('name'=>$message);
    //   Mail::send(['text'=>'mail'], $data, function($message) {
    //     $message->to('ryaalmktg1@gmail.com', 'BO ADMIN')->subject
    //        ('Note Added');
    //     $message->from('bointldev@gmail.com','Admin');
    //  });
    // }



  }

  protected function DataGridResponse($data = [], $columnsDefault = [])
  {

    if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
      $columnsDefault = [];
      foreach ($_REQUEST['columnsDef'] as $field) {
        $columnsDefault[$field] = true;
      }
    }

    // get all raw data
    $alldata = json_decode($data, true);

    $data = [];
    // internal use; filter selected columns only from raw data
    foreach ($alldata as $d) {
      $data[] = $this->filterArray($d, $columnsDefault);
    }

    // count data
    $totalRecords = $totalDisplay = count($data);

    // filter by general search keyword
    if (isset($_REQUEST['search'])) {
      $data         = $this->filterKeyword($data, $_REQUEST['search']);
      $totalDisplay = count($data);
    }

    if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
      foreach ($_REQUEST['columns'] as $column) {
        if (isset($column['search'])) {
          $data         = $this->filterKeyword($data, $column['search'], $column['data']);
          $totalDisplay = count($data);
        }
      }
    }

    // sort
    if (isset($_REQUEST['order'][0]['column']) && $_REQUEST['order'][0]['dir']) {
      $column = $_REQUEST['order'][0]['column'];
      $dir    = $_REQUEST['order'][0]['dir'];
      usort($data, function ($a, $b) use ($column, $dir) {
        $a = array_slice($a, $column, 1);
        $b = array_slice($b, $column, 1);
        $a = array_pop($a);
        $b = array_pop($b);

        if ($dir === 'desc') {
          return $a > $b ? true : false;
        }

        return $a < $b ? true : false;
      });
    }

    // pagination length
    if (isset($_REQUEST['length'])) {
      $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
    }

    // return array values only without the keys
    if (isset($_REQUEST['array_values']) && $_REQUEST['array_values']) {
      $tmp  = $data;
      $data = [];
      foreach ($tmp as $d) {
        $data[] = array_values($d);
      }
    }

    $secho = 0;
    if (isset($_REQUEST['sEcho'])) {
      $secho = intval($_REQUEST['sEcho']);
    }

    $result = [
      'iTotalRecords'        => $totalRecords,
      'iTotalDisplayRecords' => $totalDisplay,
      'sEcho'                => $secho,
      'sColumns'             => '',
      'aaData'               => $data,
    ];

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    echo json_encode($result, JSON_PRETTY_PRINT);
  }


  protected function DataGridResponse_NEW($data = [], $columnsDefault = [])
  {

    if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
      $columnsDefault = [];
      foreach ($_REQUEST['columnsDef'] as $field) {
        $columnsDefault[$field] = true;
      }
    }

    // get all raw data
    $alldata = json_decode($data, true);

    $data = [];
    // internal use; filter selected columns only from raw data
    foreach ($alldata as $d) {
      $data[] = $this->filterArray($d, $columnsDefault);
    }

    // count data
    $totalRecords = $totalDisplay = count($data);

    // filter by general search keyword
    if (isset($_REQUEST['search'])) {
      $data         = $this->filterKeyword($data, $_REQUEST['search']);
      $totalDisplay = count($data);
    }

    if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
      foreach ($_REQUEST['columns'] as $column) {
        if (isset($column['search'])) {
          $data         = $this->filterKeyword($data, $column['search'], $column['data']);
          $totalDisplay = count($data);
        }
      }
    }

    // sort


    // pagination length
    if (isset($_REQUEST['length'])) {
      $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
    }

    // return array values only without the keys
    if (isset($_REQUEST['array_values']) && $_REQUEST['array_values']) {
      $tmp  = $data;
      $data = [];
      foreach ($tmp as $d) {
        $data[] = array_values($d);
      }
    }

    $secho = 0;
    if (isset($_REQUEST['sEcho'])) {
      $secho = intval($_REQUEST['sEcho']);
    }

    $result = [
      'iTotalRecords'        => $totalRecords,
      'iTotalDisplayRecords' => $totalDisplay,
      'sEcho'                => $secho,
      'sColumns'             => '',
      'aaData'               => $data,
    ];

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    echo json_encode($result, JSON_PRETTY_PRINT);
  }

  protected function DatatableResponseMetronic($data = [])
  {
    $resp_jon = json_encode($data);
    $data = $alldata = json_decode($resp_jon);

    $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

    // search filter by keywords
    $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
      ? $datatable['query']['generalSearch'] : '';
    if (!empty($filter)) {
      $data = array_filter($data, function ($a) use ($filter) {
        return (bool) preg_grep("/$filter/i", (array) $a);
      });
      unset($datatable['query']['generalSearch']);
    }

    // filter by field query
    $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
    if (is_array($query)) {
      $query = array_filter($query);
      foreach ($query as $key => $val) {
        $data = list_filter($data, [$key => $val]);
      }
    }

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
    $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'id';

    $meta    = [];
    $page    = !empty($datatable['pagination']['page']) ? (int) $datatable['pagination']['page'] : 1;
    $perpage = !empty($datatable['pagination']['perpage']) ? (int) $datatable['pagination']['perpage'] : -1;

    $pages = 1;
    $total = count($data); // total items in array

    // sort
    usort($data, function ($a, $b) use ($sort, $field) {
      if (!isset($a->$field) || !isset($b->$field)) {
        return false;
      }

      if ($sort === 'desc') {
        return $a->$field > $b->$field ? true : false;
      }

      return $a->$field < $b->$field ? true : false;
    });

    // $perpage 0; get all data
    if ($perpage > 0) {
      $pages  = ceil($total / $perpage); // calculate total pages
      $page   = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
      $page   = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
      $offset = ($page - 1) * $perpage;
      if ($offset < 0) {
        $offset = 0;
      }

      $data = array_slice($data, $offset, $perpage, true);
    }

    $meta = [
      'page'    => $page,
      'pages'   => $pages,
      'perpage' => $perpage,
      'total'   => $total,
    ];


    // if selected all records enabled, provide all the ids
    if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
      $meta['rowIds'] = array_map(function ($row) {
        return $row->id;
      }, $alldata);
    }


    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    $result = [
      'meta' => $meta + [
        'sort'  => $sort,
        'field' => $field,
      ],
      'data' => $data,
    ];

    echo json_encode($result, JSON_PRETTY_PRINT);
  }

  function filterArray($array, $allowed = [])
  {
    return array_filter(
      $array,
      function ($val, $key) use ($allowed) { // N.b. $val, $key not $key, $val
        return isset($allowed[$key]) && ($allowed[$key] === true || $allowed[$key] === $val);
      },
      ARRAY_FILTER_USE_BOTH
    );
  }

  function filterKeyword($data, $search, $field = '')
  {
    $filter = '';
    if (isset($search['value'])) {
      $filter = $search['value'];
    }
    if (!empty($filter)) {
      if (!empty($field)) {
        if (strpos(strtolower($field), 'date') !== false) {
          // filter by date range
          $data = filterByDateRange($data, $filter, $field);
        } else {
          // filter by column
          $data = array_filter($data, function ($a) use ($field, $filter) {
            return (bool) preg_match("/$filter/i", $a[$field]);
          });
        }
      } else {
        // general filter
        $data = array_filter($data, function ($a) use ($filter) {
          return (bool) preg_grep("/$filter/i", (array) $a);
        });
      }
    }

    return $data;
  }

  function filterByDateRange($data, $filter, $field)
  {
    // filter by range
    if (!empty($range = array_filter(explode('|', $filter)))) {
      $filter = $range;
    }

    if (is_array($filter)) {
      foreach ($filter as &$date) {
        // hardcoded date format
        $date = date_create_from_format('m/d/Y', stripcslashes($date));
      }
      // filter by date range
      $data = array_filter($data, function ($a) use ($field, $filter) {
        // hardcoded date format
        $current = date_create_from_format('m/d/Y', $a[$field]);
        $from    = $filter[0];
        $to      = $filter[1];
        if ($from <= $current && $to >= $current) {
          return true;
        }

        return false;
      });
    }

    return $data;
  }


  
}
