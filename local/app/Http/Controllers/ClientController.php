<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sample;
use App\Company;
use App\Client;
use App\ClientNote;
use App\UserAccess;
use Khill\Lavacharts\Lavacharts;
use Mail;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Theme;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Helpers\AyraHelp;
//include 'class-list-util.php';
use DB;
use Carbon\Carbon;
use PDF;
use Pusher;

class ClientController extends Controller
{


  public function __construct()
  {

    // $this->middleware(['auth', 'isAdmin'])->except(['samples']);

  }

  //editNewLeadSales
  public function editNewLeadSales(Request $request)
  {
    $txtLeadID = $request->txtLeadID;
    $phone = str_replace(' ', '', $request->phone);

    Client::where('id', $txtLeadID)
      ->update([
        'firstname' => $request->name,
        'email' => $request->email,
        'phone' => trim($phone),
        'company' => $request->company,
        'brand' =>  $request->brand,
        'gstno' => $request->gst,
        'address' => $request->address,
        'source' => $request->source,
        'website' => $request->website,
        'location' => $request->location,
        'remarks' => $request->remarks

      ]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Client Edit  successfully.',
    );
    return response()->json($res_arr);
  }
  //editNewLeadSales

  public function qcformLeadEDIT($lid)
  {


    $leadDataArr = AyraHelp::getLeadDataByID($lid);
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => $leadDataArr];
    return $theme->scope('client.newleadFormEDIT', $data)->render();
  }

  public function downloadQuatation(Request $request)
  {
    $QID = $request->QID;
    //print_r($request->all());

    $fileName = 'PDF/QuatationA' . rand() . $QID . ".pdf";
    $html = file_get_contents("test.html");

    //$html='<h1>welcome</h1>';
    $paper_size = array(0, 0, 360, 360);
    PDF::loadHTML($html)->setPaper('A4', 'portrait')->setWarnings(false)->save($fileName);
    echo $fileName;
  }
  public function sendEmailQuatation(Request $request)
  {
    $QID = $request->QID;
    $users = DB::table('client_quatation_data')->where('QID', $QID)->get();
    $users_basic = DB::table('client_quatation')->where('QID', $QID)->first();

    $data = array(
      'basic' => $users_basic,
      'data' => $users,
    );
    $subLine = "subjectline";
    $sent_to = 'bointldev@gmail.com';

    Mail::send('mail_quatation', $data, function ($message) use ($sent_to,  $subLine) {

      $message->to($sent_to, 'Bo')->subject($subLine);
      // $message->cc($use_data->email, $use_data->name = null);
      // $message->bcc('udita.bointl@gmail.com', 'UDITA');
      $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
    });
  }
  public function quationPreview($id)
  {
    $users = DB::table('client_quatation_data')->where('qid', $id)->get();



    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data_arr' => $users];
    return $theme->scope('sample.print_quation', $data)->render();
  }

  public function addNew_Quotation()
  {
    $theme = Theme::uses('corex')->layout('layout');


    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead') {
      //return $theme->scope('client.add_new_quatation', $data)->render();
      return $theme->scope('client.add_new_quatationV1', $data)->render();
    } else {
      abort('401');
    }
  }
  public function getAjaxQuatationList(Request $request)
  {

    $data_arr = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      $client_arr = DB::table('client_quatation')->get();
    } else {
      $client_arr = DB::table('client_quatation')->where('created_by', Auth::user()->id)->get();
    }


    foreach ($client_arr as $key => $value) {





      $data_arr[] = array(
        'RecordID' => $value->id,
        'QUERY_ID' => optional($value)->QUERY_ID,
        'QID' => optional($value)->QID,
        'name' => optional($value)->name,
        'email' => optional($value)->email,
        'created_at' => optional($value)->created_at,
        'status' => optional($value)->sent,
        'created_by' => optional($value)->created_by,

      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'QUERY_ID'      => true,
      'QID'      => true,
      'name'      => true,
      'email'      => true,
      'created_at'      => true,
      'sent'      => true,
      'created_by'      => true

    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function getQutatationList()
  {
    $theme = Theme::uses('corex')->layout('layout');


    $data = ['users' => ''];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesUser') {
      return $theme->scope('client.quatation_List', $data)->render();
    } else {
      abort('401');
    }
  }
  public function getCID_Quation_data(Request $request)
  {
    $data_arr = array();
    $client_arr = DB::table('client_quatation_data')->where('QID', $request->QID)->get();

    foreach ($client_arr as $key => $value) {





      $data_arr[] = array(
        'RecordID' => $value->id,
        'item_name' => optional($value)->item_name,
        'size' => optional($value)->size,
        'mcp_kg' => optional($value)->mcp_kg,
        'mcp_pc' => optional($value)->mcp_pc,
        'bottle' => optional($value)->bottle,
        'box' => optional($value)->box,
        'lable' => optional($value)->lable,
        'labour' => optional($value)->labour,
        'margin' => optional($value)->margin,
        'cp' => optional($value)->cp,
        'qty' => optional($value)->qty,
        'qtype' => optional($value)->ptype,
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'item_name'      => true,
      'size'      => true,
      'mcp_kg'      => true,
      'mcp_pc'      => true,
      'bottle'      => true,
      'box'      => true,
      'lable'      => true,
      'labour'     => true,
      'margin'     => true,
      'cp'      => true,
      'qty'      => true,
      'qtype'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function saveQuationDataAsDraft(Request $request)
  {

    if (empty($request->txtQID)) {
      $QID = AyraHelp::getQID();
    } else {
      $QID = $request->txtQID;
    }


    // getQID
    DB::table('client_quatation')
      ->updateOrInsert(
        ['QID' => $QID],
        [
          'name' => $request->name,
          'email' => $request->email,
          'created_by' => Auth::user()->id
        ]
      );
    $lid = DB::getPdo()->lastInsertId();

    //insert data in client_quatation_data
    DB::table('client_quatation_data')->insert(

      [
        'item_name' => $request->item_name,
        'QID' => $QID,
        'size' => $request->item_size,
        'mcp_kg' => $request->item_mcp_kg,
        'mcp_pc' => $request->item_mcp_pc,
        'bottle' => $request->item_mcp_bottle,
        'box' => $request->item_mcp_box,
        'lable' => $request->item_mcp_lable,
        'labour' => $request->item_mcp_labour,
        'margin' => $request->item_mcp_margin,
        'cp' => $request->item_mcp_cp,
        'qty' => $request->item_mcp_qty,
        'ptype' => $request->item_mcp_ptype

      ]
    );
    //insert data in client_quatation_data

    $res_arr = array(
      'status' => 1,
      'Message' => 'Admin',
      'QID' => $QID,
    );
    return response()->json($res_arr);
  }
  public function markAsRawMaterial(Request $request)
  {
    $cid = $request->rowid;
    $mark_valset = $request->mark_valset;
    $affected = DB::table('clients')
      ->where('id', $cid)
      ->update(['mark_raw_material' => $mark_valset]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Client Already added with company',
    );
    return response()->json($res_arr);
  }

  public function saveNewLead(Request $request) //v2
  {
    $comp = $request->company;
   
    $phoneStar = $request->phone;
    $phone = str_replace(' ', '', $phoneStar);
    
    $email = $request->email;
    $brand = $request->brand;
    $client_crated_by = $request->client_crated_by;


    // print_r($request->all());
    // if(!empty($request->gst)){
    //   $data_arr=Client::where('gstno',$request->gst)->first();
    //   if($data_arr!=null){
    //     $res_arr = array(
    //       'status' => 2,
    //       'Message' => 'Client Already added with GST',
    //     );
    //     return response()->json($res_arr);
    //   }
    // }

    if (!empty($request->company)) {

      $data_arr1 = Client::where('company', $comp)->first();
      if ($data_arr1 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Company already exits',
        );
        return response()->json($res_arr);
      }
    }
    if (!empty($request->phone)) {

      $data_arr2 = Client::where('phone', trim($phone))->first();
      if ($data_arr2 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Phone already exits',
        );
        return response()->json($res_arr);
      }
    }
    if (!empty($request->email)) {

      $data_arr3 = Client::where('email', trim($email))->first();
      if ($data_arr3 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Email already exits',
        );
        return response()->json($res_arr);
      }
    }
    if (!empty($request->brand)) {

      $data_arr3 = Client::where('brand', $brand)->first();
      if ($data_arr3 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Brand already exits',
        );
        return response()->json($res_arr);
      }
    }



    $client_obj = new Client;
    $client_obj->firstname = trim($request->name);
    $client_obj->email = $request->email;
    $client_obj->phone = $phone;
    $client_obj->company = isset($request->company) ? $request->company : '';
    $client_obj->city = 12;
    $client_obj->country = 1;
    $client_obj->brand = $request->brand;
    $client_obj->gstno = $request->gst;
    $client_obj->location = $request->location;
    $client_obj->address = $request->address;
    $client_obj->source = $request->source;
    $client_obj->website = $request->website;
    $client_obj->remarks = $request->remarks;
    $client_obj->added_by = $client_crated_by;
    $client_obj->added_name = Auth::user()->name;    
    if(isset($request->leadID)){
      $client_obj->lead_QUERY_ID = $request->leadID;
      $client_obj->client_from = 1;
      
    }

    $client_obj->save();
    DB::table('st_process_sales_lead_v1')->insert(
      [
          'process_id' => 7,
          'stage_id' => 1,
          'action_on' => 1,
          'ticket_id' => $client_obj->id,
          'remarks' => 'New Created',
          'assigned_id' => Auth::user()->id,
          'updated_by' =>Auth::user()->id,
          'completed_by' => Auth::user()->id,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s')
         
      ]
  );

  $affected = DB::table('clients')
  ->where('id', $client_obj->client_id)
  ->update([
    'lead_statge' => 1,

  ]);

    $res_arr = array(
      'status' => 1,
      'Message' => 'Client saved successfully.',
    );
    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $eventName = "New Client Add";
    $eventINFO = "New Client is added by " . $LoggedName . " Client Phone NO : " . $request->phone . "& Name:" . $request->name;
    $eventID = $client_obj->id;

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
    return response()->json($res_arr);
  }


  public function saveNewLeadK(Request $request)
  {

    //saved data to client_sales_lead
    $QUERY_ID = $request->client_crated_by . AyraHelp::getSALE_QUERYID();
    DB::table('client_sales_lead')->insert(
      [
        'QUERY_ID' => $QUERY_ID,
        'SENDERNAME' =>  $request->name,
        'SENDEREMAIL' => $request->email,
        'SUBJECT' => '',
        'DATE_TIME_RE' => '',
        'GLUSR_USR_COMPANYNAME' => $request->company,
        'GLUSR_USR_BRANDNAME' => $request->brand,
        'MOB' =>  $request->phone,
        //'COUNTRY_FLAG' => 0,
        //'ENQ_MESSAGE' => 0,
        'ENQ_ADDRESS' => $request->address,
        'ENQ_CITY' => $request->location,
        //'ENQ_STATE' => 0,
        //'PRODUCT_NAME' => 0,
        //'COUNTRY_ISO' => 0,
        'EMAIL_ALT' => $request->email,
        //'MOBILE_ALT' => 0,
        'PHONE' => $request->phone,
        //'PHONE_ALT' => 0,
        //'IM_MEMBER_SINCE' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'data_source' => $request->source,
        // 'data_source_ID' => 0,
        // 'updated_by' => 0,
        // 'lead_check' => 0,
        // 'lead_status' => 0,
        'remarks' => $request->remarks,
        // 'DATE_TIME_RE_SYS' => 0,
        'assign_to' => $request->client_crated_by,
        'assign_on' => date('Y-m-d H:i:s'),
        'assign_by' =>  $request->client_crated_by,

        // 'QTYPE' => 0,
        // 'ENQ_CALL_DURATION' => 0,
        // 'ENQ_RECEIVER_MOB' => 0,
        // 'view_status' => 0,
        // 'json_api_data' => 0,
        // 'last_note_updated' => 0,
        // 'follow_date' => 0,
        // 'lead_ori_owner' => 0,
        // 'is_deleted' => 0,
      ]
    );

    //saved data to client_sales_lead
    $res_arr = array(
      'status' => 1,
      'Message' => 'Admin',
    );
    return response()->json($res_arr);
  }
  //deleteMyLead
  public function deleteMyLead(Request $request)
  {

    DB::table('client_sales_lead')
      ->where('QUERY_ID', $request->rowid)
      ->update(['is_deleted' => 1]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Admin',
    );
    return response()->json($res_arr);
  }
  //deleteMyLead
  public function myLeadTranfer(Request $request)
  {


    DB::table('client_sales_lead')
      ->where('QUERY_ID', $request->QUERY_ID)
      ->update([
        'assign_to' => $request->assign_user_id,
        'lead_ori_owner' => Auth::user()->id,
      ]);

    $res_arr = array(
      'status' => 1,
      'Message' => 'Admin',
    );
    return response()->json($res_arr);
  }
  public function ajtrans(Request $request)
  {
    //AyraHelp::ClientAccessFullTRANSFER();
    AyraHelp::ClientAccessTRANSFER_fromTO();

    //AyraHelp::getDuplicateLead();
    //AyraHelp::setClientALLAccessToUser();

    die;
  }


  public function getLeadNotesData(Request $request)
  {

    $notes_arr = DB::table('lead_notes')->where('QUERY_ID', $request->QUERY_ID)->get();





    $HTML = '<!--begin::Section-->
      <div class="m-section">
        <div class="m-section__content">
          <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr >
                <th>S#</th>
                <th>Message</th>
                <th>Created by</th>
                <th>Created on</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;

    foreach ($notes_arr as $key => $rowData) {
      $addedby = AyraHelp::getUser($rowData->created_by)->name;
      // $created_on=date('j M Y H:i:s',strtime($rowData->create_at));
      $created_on = date('j-M-Y H:i A', strtotime($rowData->created_at));

      $i++;
      $HTML .= '
              <tr>
                <th scope="row">' . $i . '</th>
                <td>' . $rowData->msg . '</td>
                <td>' . $addedby . '</td>
                <td>' . $created_on . '</td>
              </tr>';
    }






    $HTML .= '
            </tbody>
          </table>
        </div>
      </div>

      <!--end::Section-->';
    echo $HTML;
  }
  // v1:LeadManagement
  // clientv1Leads
  public function clientv1Leads()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->with('roles')->get();

    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser') {
      return $theme->scope('client.leadsList', $data)->render();
    } else {
      abort('401');
    }
  }


  public function clientv1()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'users' => '',
    ];
    if ($user_role == 'Admin' || $user_role == 'SalesUser') {
      return $theme->scope('client.indexv1', $data)->render();
    } else {
      abort('401');
    }
  }
  //clientTransfer
  public function clientTransfer(Request $request)
  {

    $message = $request->message;
    $clid = $request->clid;
    $client_arr = AyraHelp::getClientbyid($clid);
    $user_from = $client_arr->added_by;



    $user_to = $request->user_id;
    $transEmail = AyraHelp::getUser($request->user_id)->email;
    $transName = AyraHelp::getUser($request->user_id)->name;
    $transFromName = AyraHelp::getUser($user_from)->name;
    $transFromEmail = AyraHelp::getUser($user_from)->email;

    //client updated
    DB::table('clients')
      ->where('id', $clid)
      ->update([
        'added_by' => $user_to,
        'client_owner_too' => $user_from,
        'added_name' => $transName,
      ]);

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
      ]);


      DB::table('payment_recieved_from_client')
      ->where('client_id', $clid)
      ->update([
        'transfer_to' => $user_to,
        'transfer_to_name' => $transFromName,
        'transfer_at' => date('Y-m-d H:i:s'),
      ]);
    //orders updated

    //UPDATE `clients` SET `added_by` = '100' WHERE `clients`.`id` = 1808;
    //UPDATE `samples` SET `created_by` = '100' WHERE `samples`.`client_id` = 1808;
    //UPDATE `client_notes` SET `user_id` = '100' WHERE `client_notes`.`clinet_id` = 1808;
    //UPDATE `qc_forms` SET `created_by` = '100' WHERE `qc_forms`.`client_id` = 1808;

    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $AssineTo = AyraHelp::getUser($user_to)->name;

    $eventName = "Client Transfer";
    $eventINFO = 'Client Full Transfer of client:' . $client_arr->company . " and Assined to  " . $AssineTo . " by" . $LoggedName . "Message :" . $message;
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

    $sent_to = $transFromEmail;

    // EMAIL
    //from account email 
    $to = $sent_to;
    $subject = "Client Transfer Notification";

    $data = array(
      'name' => $client_arr->firstname,
      'company' => $client_arr->company,
      'transferto' => $transName,
      'transferfrom' => $transFromName,
      'transferDate' => date('Y-m-d H:i:s'),
      'transferBy' => Auth::user()->name,
      'note' => $message


    );

    $body = '<h1>Client Transfer from :  ' . $data['transferfrom'] . ' </h1>
    Name:' . $data['name'] . "LID-".$client_arr->id.'
    <br>  
    Company Name:' . $data['company'] . '
    <br>
    Transfer to : ' . $data['transferto'] . '
    <br>Transferd Date : ' . $data['transferDate'] . '
    <br>
    Transferd By : ' . $data['transferBy'] . '
    <br>Note : ' . $data['note'] . '
    ';

    $email_template = "mail_trans_from";

    $this->sendEmailSendgridWays($to, $subject, $body, $email_template);

    //from account email 
    //send emmail to accou t

    $to = $transEmail;
    $subject = "Client Transfer Notification";

    $data = array(
      'name' => $client_arr->firstname,
      'company' => $client_arr->company,
      'transferto' => $transName,
      'transferfrom' => $transFromName,
      'transferDate' => date('Y-m-d H:i:s'),
      'transferBy' => Auth::user()->name,
      'note' => $message


    );
    //  print_r($data['name']);
    //  die;
    $body = '<h1>Client Transfer to   ' . $data['transferto'] . '</h1>
    
    Name:' . $data['name'] . "LID-".$client_arr->id.'
    <br>    
    Company Name:' . $data['company'] . '
    <br>
    Transfer from : ' . $data['transferfrom'] . '
    <br>Transferd Date : ' . $data['transferDate'] . '
    <br>
    Transferd By : ' . $data['transferBy'] . '
    <br>Note : ' . $data['note'] . '
    
    ';

    $email_template = "mail_trans_from";

    $this->sendEmailSendgridWays($to, $subject, $body, $email_template);

    //send emmail to accou t

    // EMAIL




    $res_arr = array(
      'status' => 1,
      'Message' => 'Account',
    );
    return response()->json($res_arr);
  }
  //clientTransfer

  //clientTransferWithSMSEMAIL

  public function clientTransferWithSMSEMAIL(Request $request)
  {

    $message = $request->message;
    
   
   


    $clid = $request->clid;
    $client_arr = AyraHelp::getClientbyid($clid);
    $user_from = $client_arr->added_by;



    $user_to = $request->user_id;
    $transEmail = AyraHelp::getUser($request->user_id)->email;
    $transName = AyraHelp::getUser($request->user_id)->name;
    $transPhone = AyraHelp::getUser($request->user_id)->phone;
    $transFromName = AyraHelp::getUser($user_from)->name;
    $transFromEmail = AyraHelp::getUser($user_from)->email;
    $transFromPhone = AyraHelp::getUser($user_from)->phone;

    //client updated
    // DB::table('clients')
    //   ->where('id', $clid)
    //   ->update([
    //     'added_by' => $user_to,
    //     'client_owner_too' => $user_from,
    //     'added_name' => $transName,
    //   ]);

    //client updated
    //sample updated
    // DB::table('samples')
    //   ->where('client_id', $clid)
    //   ->update([
    //     'created_by' => $user_to
    //   ]);

    //sample updated


    //notes updated
    // DB::table('client_notes')
    //   ->where('clinet_id', $clid)
    //   ->update([
    //     'user_id' => $user_to
    //   ]);

    //notes updated


    //orders updated
    // DB::table('qc_forms')
    //   ->where('client_id', $clid)
    //   ->update([
    //     'created_by' => $user_to,
    //     'client_owner_too' => $user_from,
    //   ]);

   
    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $AssineTo = AyraHelp::getUser($user_to)->name;

    $eventName = "Client TransferTEST";
    $eventINFO = 'Client Full Transfer of client:' . $client_arr->company . " and Assined to  " . $AssineTo . " by" . $LoggedName . "Message :" . $message;
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

    $sent_to = $transFromEmail;

    // EMAIL
    //from account email 
    $to = $sent_to;
    $subject = "Client Transfer Notification";

    $data = array(
      'name' => $client_arr->firstname,
      'company' => $client_arr->company,
      'transferto' => $transName,
      'transferfrom' => $transFromName,
      'transferDate' => date('Y-m-d H:i:s'),
      'transferBy' => Auth::user()->name,
      'note' => $message


    );

    
    $body = '<h1>Client Transfer from :  ' . $data['transferfrom'] . ' </h1>
    Name:' . $data['name'] . "LID-".$client_arr->id.'
    <br>  
    Company Name:' . $data['company'] . '
    <br>
    Transfer to : ' . $data['transferto'] . '
    <br>Transferd Date : ' . $data['transferDate'] . '
    <br>
    Transferd By : ' . $data['transferBy'] . '
    <br>Note : ' . $data['note'] . '
    ';

    $email_template = "mail_trans_from";

    //$this->sendEmailSendgridWays($to, $subject, $body, $email_template);

    //from account email 
    //send emmail to accou t

    $to = $transEmail;
    $subject = "Client Transfer Notification";

    $data = array(
      'name' => $client_arr->firstname,
      'company' => $client_arr->company,
      'transferto' => $transName,
      'transferfrom' => $transFromName,
      'transferDate' => date('Y-m-d H:i:s'),
      'transferBy' => Auth::user()->name,
      'note' => $message


    );
    //  print_r($data['name']);
    //  die;
    $body = '<h1>Client Transfer to   ' . $data['transferto'] . '</h1>
    
    Name:' . $data['name'] . "LID-".$client_arr->id.'
    <br>    
    Company Name:' . $data['company'] . '
    <br>
    Transfer from : ' . $data['transferfrom'] . '
    <br>Transferd Date : ' . $data['transferDate'] . '
    <br>
    Transferd By : ' . $data['transferBy'] . '
    <br>Note : ' . $data['note'] . '
    
    ';

    $email_template = "mail_trans_from";

    //$this->sendEmailSendgridWays($to, $subject, $body, $email_template);

    //send emmail to accou t

    // EMAIL

    // send mail to cleint 
    $txtClientEmailID = $request->txtClientEmailID;
    $txtClientPhone = $request->txtClientPhone;
    $email_templateForClient = "mail_trans_fromToClient";

    if(isset($request->emailsmsVal)){
      $emailsmsVal = $request->emailsmsVal;
    
      foreach ($emailsmsVal as $key => $rID) {       
       
        if($rID==1){
          $subject="New Account Manager from MAX";
          $bodyM ='Dear Sir/Madam

          Greetings from MAX!!
          
          We would like to inform you that your account is transferring to '.$transName.' for further communication from our side on the Order Placement, Sample Status, Order Dispatch Status, and any other query. 
          
          Earlier '.$transFromName.' was handling your account from our organization, but now '.$transFromName.' is not available in the system. 
          
          You can contact '.$transName.' at Mobile No:'.$transPhone.' and "Email Id .'.$transEmail.'".
          
          In case of any further assistance, please write to us at info@max.net.';

          $body='Dear Sir/Madam <br>

          Greetings from MAX!!  <br>
          
          We would like to inform you that '.$transName.' will be your new Relationship Manager. <br> He will be in touch with you for Order Placement, Sample Status, Order Dispatch Status, and any other concerns.<br>
          
          You may contact :'.$transName.' at <br>
          Mobile No : '.$transPhone.' <br>
          Email Id : '.$transEmail.' <br>
          
          In case of any further assistance, please write to us at <br>
          info@max.net.';


          $this->sendEmailSendgridWaysToClient($txtClientEmailID, $subject, $body, $email_templateForClient);

        }
        if($rID==2){

        }
      }
    }
    // send mail to cleint 


    $res_arr = array(
      'status' => 1,
      'Message' => 'Account',
    );
    return response()->json($res_arr);


  }


  //clientTransferWithSMSEMAIL


  //setPaymentRecOrder
  public function setPaymentRecOrder(Request $request)
  {
    $payOrderID = $request->payOrderID;
    $txtAdminAccountOC = $request->txtAdminAccountOC;
    // if(Auth::user()->id==1){
    //   DB::table('payment_recieved_from_client')
    //   ->where('id', $request->payid)
    //   ->update([
    //     'admin_remarks' => $txtAdminAccount,
    //    // 'payment_status' => 2,

    //     ]);
    //     $res_arr = array(
    //       'status' => 1,
    //       'Message' => 'Admin',
    //     );

    // }
    if (Auth::user()->id == 132 || Auth::user()->id == 1 ||  Auth::user()->id == 176) {
      DB::table('qc_forms')
        ->where('form_id', $payOrderID)
        ->update([
          'account_approval' => $request->accOCResp,
          'account_msg' => $txtAdminAccountOC,
          'account_approved_on' => date('Y-m-d H:i:s')

        ]);

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;
      $eventName = "Order Approve";
      $eventINFO = 'QC FORM :' . $payOrderID . " Approved with message" . $txtAdminAccountOC . "by" . $LoggedName;
      $eventID = $payOrderID;
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



      $res_arr = array(
        'status' => 1,
        'Message' => 'Account',
      );
    }

    return response()->json($res_arr);
  }

  //setPaymentRecOrder
  //setOncreditResponse
  public function setOncreditResponse(Request $request)
  {
 
    $txtID=$request->txtID;
    $respType=$request->respType;
    $txtEditOrderResponse=$request->txtEditOrderResponse;
    $affected = DB::table('lead_credit_request')
    ->where('id', $txtID)
    ->update([
      'action_by' => Auth::user()->id,
      'action_on' => date('Y-m-d H:i:s'),
      'action_message' => $txtEditOrderResponse,
      'status' => $respType
      ]);
      if($respType==2){
        //is_online_created
        $reqArr = DB::table('lead_credit_request')
        ->where('id', $txtID)->first();
  
        $affected = DB::table('clients')
        ->where('id', $reqArr->client_id)
        ->update(['oncredit_id' =>1]);

      }
    


    $res_arr = array(
      'status' => 1,
      'Message' => 'Done',
    );
    return response()->json($res_arr);
  }

  //setOncreditResponse


  //setOrderEditResponse
  public function setOrderEditResponse(Request $request)
  {
    $txtID=$request->txtID;
    $respType=$request->respType;
    $txtEditOrderResponse=$request->txtEditOrderResponse;
    $affected = DB::table('order_edit_requests')
    ->where('id', $txtID)
    ->update([
      'approved_by' => Auth::user()->id,
      'approved_at' => date('Y-m-d H:i:s'),
      'approved_msg' => $txtEditOrderResponse,
      'status' => $respType
      ]);
      if($respType==1){
        $reqArr = DB::table('order_edit_requests')
        ->where('id', $txtID)->first();
  
        $affected = DB::table('qc_forms')
        ->where('form_id', $reqArr->form_id)
        ->update(['editByReqStatus' =>1]);

      }
    


    $res_arr = array(
      'status' => 1,
      'Message' => 'Done',
    );
    return response()->json($res_arr);
  }
  //setOrderEditResponse
  //setPaymentRecCommnetSample
  public function setPaymentRecCommnetSample(Request $request)
  {
    $payid = $request->payid;
    $txtAdminAccount = $request->txtAdminAccount;
    if (Auth::user()->id == 1) {
      DB::table('payment_recieved_from_client_for_sample')
        ->where('id', $request->payid)
        ->update([
          'admin_remarks' => $txtAdminAccount,
          'account_remarks_updated_at' =>date('Y-m-d H:i:s'),
          'rec_by_name' => Auth::user()->name
          // 'payment_status' => 2,

        ]);

        $sampleArrID = DB::table('payment_recieved_from_client_for_sample')
            ->where('id', $payid)
            ->first();

        $affected = DB::table('samples')
        ->where('id', $sampleArrID->sample_id)
        ->update([
          'is_paid_status' => 2, //  need to upload payment
         
        ]);

      $res_arr = array(
        'status' => 1,
        'Message' => 'Admin',
      );
    }
    if (Auth::user()->id == 132 || Auth::user()->id == 146) {
      DB::table('payment_recieved_from_client_for_sample')
        ->where('id', $request->payid)
        ->update([
          'account_remarks' => $txtAdminAccount,
          'payment_status' => $request->accResp,
          'account_remarks_updated_at' =>date('Y-m-d H:i:s'),
          'rec_by_name' => Auth::user()->name

        ]);
        $sampleArrID = DB::table('payment_recieved_from_client_for_sample')
            ->where('id', $payid)
            ->first();

        $affected = DB::table('samples')
        ->where('id', $sampleArrID->sample_id)
        ->update([
          'is_paid_status' => 2, //  need to upload payment
         
        ]);
        
      $res_arr = array(
        'status' => 1,
        'Message' => 'Account',
      );
    }
    $ajk=0;

    $sapArr = DB::table('payment_recieved_from_client_for_sample')
    ->where('id', $request->payid)
            ->first();

    if ($ajk==0) {


      //ajaj
      $ticket_id = $sapArr->sample_id;


      $data = DB::table('st_process_action_6')->where('ticket_id', $ticket_id)->where('process_id', 6)->where('stage_id', 2)->where('action_on', 1)->first();

      if ($data == null) {

        DB::table('st_process_action_6')->insert(
          [
            'ticket_id' => $ticket_id,
            'process_id' => 6,
            'stage_id' => 2,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Auto Approval',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );
        $affected = DB::table('samples')
          ->where('id', $ticket_id)
          ->update([
            'sample_stage_id' => 2,

          ]);

        $sampleChidListArr = DB::table('sample_items')
          ->where('sid', $ticket_id)
          ->get();
        foreach ($sampleChidListArr as $key => $rowS) {
          // save stages of child samples
          $ticket_idA = $rowS->id;
          DB::table('st_process_action_6v2')->insert(
            [
              'ticket_id' => $ticket_idA,
              'process_id' => 6,
              'stage_id' => 2,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto Approval Item Add',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          // save stages of child samples
          $affected = DB::table('sample_items')
            ->where('id', $ticket_idA)
            ->update([
              'stage_id' => 2,

            ]);
        }



        $data_arr = array(
          'status' => 1,
          'msg' => 'Added  successfully'
        );




        //AyraHelp::setSampleAssinedThisAsNow($ticket_id); //auto assigned 



      } else {
        $data_arr = array(
          'status' => 0,
          'Message' => 'Already Done'
        );
      }

      //ajaj
    }


     //LoggedActicty
     $userID = Auth::user()->id;
     $LoggedName = AyraHelp::getUser($userID)->name;
     $eventName = "payment Approved Log Sample";
     $eventINFO = 'Payment Approved by ' . $LoggedName . " PAYID" . $request->payid . " on " . date('j F Y H:i:s');
     $eventID = $request->payid;
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


    return response()->json($res_arr);
  }

  //setPaymentRecCommnetSample


  public function setPaymentRecCommnet(Request $request)
  {
    $payid = $request->payid;
    $txtAdminAccount = $request->txtAdminAccount;
    if (Auth::user()->id == 1) {
      DB::table('payment_recieved_from_client')
        ->where('id', $request->payid)
        ->update([
          'admin_remarks' => $txtAdminAccount,
          'account_remarks_updated_at' =>date('Y-m-d H:i:s'),
          'rec_by_name' => Auth::user()->name
          // 'payment_status' => 2,

        ]);
      $res_arr = array(
        'status' => 1,
        'Message' => 'Admin',
      );
    }
    if (Auth::user()->id == 132 || Auth::user()->id == 176) {
      DB::table('payment_recieved_from_client')
        ->where('id', $request->payid)
        ->update([
          'account_remarks' => $txtAdminAccount,
          'payment_status' => $request->accResp,
          'account_remarks_updated_at' =>date('Y-m-d H:i:s'),
          'rec_by_name' => Auth::user()->name

        ]);
      $res_arr = array(
        'status' => 1,
        'Message' => 'Account',
      );
    }


     //LoggedActicty
     $userID = Auth::user()->id;
     $LoggedName = AyraHelp::getUser($userID)->name;
     $eventName = "payment Approved Log";
     $eventINFO = 'Payment Approved by ' . $LoggedName . " PAYID" . $request->payid . " on " . date('j F Y H:i:s');
     $eventID = $request->payid;
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

    return response()->json($res_arr);
  }

  //deleteOrderEditRequest
  public function deleteOrderEditRequest(Request $request)
  {


    $users = DB::table('order_edit_requests')->where('id', $request->s_id)->first();


   
    if ($users == null) {
      $data = array(
        'status' => '0',
        'message' => 'Could not delete',
      );
    } else {

      //  $users = DB::table('sales_invoice_request')->where('id',$request->s_id)->delete();

      DB::table('order_edit_requests')
        ->where('id', $request->s_id)
        ->update(['is_deleted' => 1]);


      $data = array(
        'status' => '1',
        'message' => 'Deleted successfully',
      );
    }

    return response()->json($data);
  }

  //deleteOrderEditRequest

  public function deletePaymentRequest(Request $request)
  {


    $users = DB::table('payment_recieved_from_client')->where('id', $request->s_id)->first();


    $sample = Sample::find($request->s_id);
    if ($users == null) {
      $data = array(
        'status' => '0',
        'message' => 'Could not delete',
      );
    } else {

      //  $users = DB::table('sales_invoice_request')->where('id',$request->s_id)->delete();

      DB::table('payment_recieved_from_client')
        ->where('id', $request->s_id)
        ->update(['is_deleted' => 1]);


      $data = array(
        'status' => '1',
        'message' => 'Deleted successfully',
      );
    }

    return response()->json($data);
  }


  // orderApprovalList
  public function orderApprovalList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'users' => '',
    ];
    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 90 || Auth::user()->id == 176 ||  Auth::user()->id == 171) {
      return $theme->scope('client.orderApprovalList', $data)->render();
    } else {
      abort('401');
    }
  }
  // orderApprovalList

  //paymentRecievedLIST_SAMPLE
  public function paymentRecievedLIST_SAMPLE()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'users' => '',
    ];
    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 90 ||  Auth::user()->id == 176 ||  Auth::user()->id == 146 ||  Auth::user()->id == 85) {
      return $theme->scope('client.paymenRecivedListSample', $data)->render();
    } else {
      abort('401');
    }
  }

  //paymentRecievedLIST_SAMPLE

  public function paymentRecievedLIST()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'users' => '',
    ];
    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 90 ||  Auth::user()->id == 176 ||  Auth::user()->id == 171 ||  Auth::user()->id == 85) {
      return $theme->scope('client.paymenRecivedList', $data)->render();
    } else {
      abort('401');
    }
  }



  public function viewClientv1($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $client_data = Client::where('id', $id)->first();

    $user = auth()->user();
    if ($user->hasAnyPermission(['view-all-notes'])) {
      $client_notes = ClientNote::where('clinet_id', $id)->orderBy('id', 'desc')->get();
    } else {
      $client_notes = ClientNote::where('clinet_id', $id)->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
    }

    $data = ['client_data' => $client_data, 'client_notes' => $client_notes];
    //client order grapgh
    $lava = new Lavacharts; // See note below for Laravel

    $client_orderValue = $lava->DataTable();
    $client_orderValue->addDateColumn('Year')
      ->addNumberColumn('Order Value')
      ->setDateTimeFormat('Y-m-d');

    for ($x = 4; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

      // $active_date=date('Y')."-".$x."-1";
      if ($x >= 5) {
        $active_date = "2023-" . $x . "-1";
      } else {
        $active_date = date('Y') . "-" . $x . "-1";
      }


      $data_output = AyraHelp::getClientOrderValMonthWise($x, $id);
      $client_orderValue->addRow([$active_date, $data_output]);
    }

    $bo_level = 'BO_CLIENT_ORDER';


    $donutchart = \Lava::ColumnChart($bo_level, $client_orderValue, [
      'title' => 'Order Value of ' . optional($client_data)->company,
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],

    ]);

    //client order grapgh



    return $theme->scope('client.viewv1', $data)->render();
  }

  // v1:LeadManagement

  public function getMissedFollowupList(Request $request)
  {
    $date = \Carbon\Carbon::today()->subDays(1);
    $clients = Client::where('follow_date', '<', date($date))->get();
  }

  //
  public function clientLeadV3()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'User') {
      if(Auth::user()->id==189){
        return $theme->scope('client.clientLeadV3', $data)->render();
      }else{
        abort(401);
      }
      
    } else {
      return $theme->scope('client.clientLeadV3', $data)->render();
    }
  }

  //clientLeadV3

  public function index()
  {
    abort(401);
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
      return $theme->scope('client.index', $data)->render();
    }
  }


  public function todayClientFollow(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('client.today_follow_up', $data)->render();
  }
  public function yestardayClientFollow(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('client.yestarday_follow_up', $data)->render();
  }
  public function delayedClientFollow(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('client.delayed_follow_up', $data)->render();
  }

  /*
    |--------------------------------------------------------------------------
    | function name:clientLeads
    |--------------------------------------------------------------------------
    | This function is used to get clients notes
    */
  public function clientLeads(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('client.index', $data)->render();
  }



  /*
    |--------------------------------------------------------------------------
    | function name:getClient_notes
    |--------------------------------------------------------------------------
    | This function is used to get clients notes
    */
  public function getClient_notes_view(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['info' => 'Hello World'];
    return $theme->scope('client.notes', $data)->render();
  }

  public function getClientsNotesList(Request $request)
  {
    $data_arr = array();
    $client_arr = Client::where('is_deleted', '!=', 1)->get();

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $client_arr = ClientNote::get();
    }
    if ($user_role == 'SalesUser') {
      $client_arr = ClientNote::where('user_id', Auth::user()->id)->get();
    }



    foreach ($client_arr as $key => $value) {

      $client_id = $value->clinet_id;
      $user_arr = AyraHelp::getClientbyid($client_id);
      $sales_name = AyraHelp::getUserName($value->user_id);
      $created_on = date('j M Y', strtotime($value->created_at));
      if ($value->date_schedule == null or empty($value->date_schedule)) {
        $sh_on = 'N/A';
      } else {
        $sh_on = date('j M Y H:i:A', strtotime($value->date_schedule));
      }



      $data_arr[] = array(
        'RecordID' => $value->id,
        'client_id' => isset($user_arr->id) ? $user_arr->id : 0,
        'client_name' => isset($user_arr->firstname) ? $user_arr->firstname : '',
        'client_company' => isset($user_arr->company) ? $user_arr->company : '',
        'message' => isset($value->message) ? $value->message : '',
        'sh_on' => $sh_on,
        'created_by' => $sales_name,
        'created_on' => $created_on,
        'Status' => $value->is_read,
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'client_id'      => true,
      'client_name'      => true,
      'client_company'      => true,
      'message'      => true,
      'sh_on'      => true,
      'created_by'      => true,
      'created_on'     => true,
      'Status'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  public function getClientsListYestardayFUP(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin') {
        $users_arr = Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::yesterday())->orderBy('follow_date', 'ASC')->get();
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }


          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser') {
        $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->whereDate('follow_date', Carbon::yesterday())->orderBy('follow_date', 'ASC')->get();
        // $user_access_arr = UserAccess::where('access_to',Auth::user()->id)->get();
        // foreach ($user_access_arr as $key => $value) {
        //   print_r($value->client_id);
        //   $users_arr = Client::where('is_deleted','!=',1)->where('added_by',$user_id)->orderBy('id', 'desc')->get();

        // }

        // die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }
  public function getClientsListDelayFUP(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions

      if ($user_role == 'Admin') {
        $users_arr = Client::where('is_deleted', '!=', 1)->whereDate('follow_date',  Carbon::now()->subDays(365))->orderBy('follow_date', 'ASC')->get();
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }


          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser') {
        $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->whereDate('follow_date',  Carbon::now()->subDays(365))->orderBy('follow_date', 'ASC')->get();
        // $user_access_arr = UserAccess::where('access_to',Auth::user()->id)->get();
        // foreach ($user_access_arr as $key => $value) {
        //   print_r($value->client_id);
        //   $users_arr = Client::where('is_deleted','!=',1)->where('added_by',$user_id)->orderBy('id', 'desc')->get();

        // }

        // die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }


  public function getClientsListTodayFUP(Request $request)
  {

    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin') {
        $users_arr = Client::where('is_deleted', '!=', 1)->whereDate('follow_date', Carbon::today())->orderBy('follow_date', 'ASC')->get();
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }


          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser') {
        $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->whereDate('follow_date', Carbon::today())->orderBy('follow_date', 'ASC')->get();
        // $user_access_arr = UserAccess::where('access_to',Auth::user()->id)->get();
        // foreach ($user_access_arr as $key => $value) {
        //   print_r($value->client_id);
        //   $users_arr = Client::where('is_deleted','!=',1)->where('added_by',$user_id)->orderBy('id', 'desc')->get();

        // }

        // die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'created_by' => $created_by,
            'status' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }


  /*
    |--------------------------------------------------------------------------
    | function name:getClientsList
    |--------------------------------------------------------------------------
    | Used to get list of all client as permissions
    */
  public function getClientsListApi(Request $request)
  {

    $users_arr = DB::table('clients')
      ->leftJoin('users_access', 'clients.id', '=', 'users_access.client_id')

      ->select('clients.*')
      ->orderBy('clients.id', 'DESC')
      ->where('clients.added_by', 4)
      ->orwhere('users_access.access_to', 4)
      ->where('clients.is_deleted', '!=', 1)
      ->get();

    //newcode
    //  $users_arr = DB::table('samples')
    //  ->leftJoin('users_access', 'samples.created_by', '=', 'users_access.access_by')
    //  ->select('samples.*')
    //  ->orderBy('samples.id', 'DESC')
    //  ->orwhere('users_access.access_to',Auth::user()->id)
    // ->get();
    //newcode
    return json_decode($users_arr);
  }

  //getClientsListOrderHave
  public function getClientsListOrderHave(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin' ||  $user->hasPermissionTo('view-client-list')) {
        $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('follow_date', 'asc')->whereNotNull('have_order_count')->get();
        // print_r(json_encode($users_arr));
        //   die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }
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
          if ($user_role == 'Admin' || $user_role == 'SalesUser') {

            $phon = $value->phone;
          } else {
            //$phon = "";
            $phon = $value->phone;
          }
          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $phon,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
            'orderCount' => $value->have_order_count,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser' || $user_role == 'Staff' || $user_role == 'CourierTrk') {


        //newcode
        if ($user_role == 'SalesUser' || $user_role == 'CourierTrk') {
          $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->orderBy('follow_date', 'asc')->get();
        }
        if ($user_role == 'Staff') {
          $users_arr = DB::table('clients as t1')
            ->leftJoin('users_access', 't1.id', '=', 'users_access.client_id')

            ->select('t1.*')
            ->orderBy('t1.id', 'DESC')
            ->where('t1.added_by', Auth::user()->id)
            ->orwhere('users_access.access_to', Auth::user()->id)
            //->orwhere('t1.client_owner_too',Auth::user()->id)
            ->where('t1.is_deleted', '!=', 1)
            ->get();
        }

        //newcode




        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";
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

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
            'orderCount' => $value->have_order_count,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'last_note_added' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'orderCount' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }

  //getClientsListTeam
  public function getClientsListTeam(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin' ||  $user->hasPermissionTo('view-client-list')) {
        $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('follow_date', 'asc')->get();
        //print_r(json_encode($users_arr));
        //  die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }
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
          if ($user_role == 'Admin' || $user_role == 'SalesUser') {

            $phon = $value->phone;
          } else {
            //$phon = "";
            $phon = $value->phone;
          }
          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $phon,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser' || $user_role == 'Staff' || $user_role == 'CourierTrk') {


        //newcode
        if ($user_role == 'SalesUser' || $user_role == 'CourierTrk') {
          $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $request->txtGetClientID)->orderBy('follow_date', 'asc')->get();
        }
        if ($user_role == 'Staff') {
          $users_arr = DB::table('clients as t1')
            ->leftJoin('users_access', 't1.id', '=', 'users_access.client_id')

            ->select('t1.*')
            ->orderBy('t1.id', 'DESC')
            ->where('t1.added_by', Auth::user()->id)
            ->orwhere('users_access.access_to', Auth::user()->id)
            //->orwhere('t1.client_owner_too',Auth::user()->id)
            ->where('t1.is_deleted', '!=', 1)
            ->get();
        }

        //newcode




        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";
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

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'last_note_added' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }

  //getClientsListTeam
  //getClientsListSalesLeadV1
  public function getClientsListSalesLeadV1(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin' ||  $user->hasPermissionTo('view-client-list')) {
        $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('follow_date', 'asc')->get();
        //print_r(json_encode($users_arr));
        //  die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }
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
          if ($user_role == 'Admin' || $user_role == 'SalesUser') {

            $phon = $value->phone;
          } else {
            //$phon = "";
            $phon = $value->phone;
          }
          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $phon,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser' || $user_role == 'Staff' || $user_role == 'CourierTrk') {


        //newcode
        if ($user_role == 'SalesUser' || $user_role == 'CourierTrk') {
          $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->where('have_order', 1)->orderBy('follow_date', 'asc')->get();
        }
        if ($user_role == 'Staff') {
          $users_arr = DB::table('clients as t1')
            ->leftJoin('users_access', 't1.id', '=', 'users_access.client_id')

            ->select('t1.*')
            ->orderBy('t1.id', 'DESC')
            ->where('t1.added_by', Auth::user()->id)
            ->orwhere('users_access.access_to', Auth::user()->id)
            //->orwhere('t1.client_owner_too',Auth::user()->id)
            ->where('t1.is_deleted', '!=', 1)
            ->get();
        }

        //newcode




        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";
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

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'last_note_added' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }

  //getClientsListSalesLeadV1
  //viewAllLeadDetails
  public function viewAllLeadDetails($lid)
  {
    $users_arr = Client::where('is_deleted', '!=', 1)->where('id', $lid)->first();

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => $users_arr];
    return $theme->scope('client.viewAllLeadDetails', $data)->render();
  }

  //viewAllLeadDetails
  //getLeadListV3_AdminView
  public function getLeadListV3_AdminView(Request $request)
  {

    $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $data_arr[] = array(
        'RecordID' => $value->id,
        'rowid' => $value->id,
        'company' => $value->company,
        'brand' => $value->brand,
        'name' => $value->firstname,
        'phone' => $value->phone,
        'email' => $value->email,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $value->added_name,
        'stage_status' => $value->lead_statge


      );
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'rowid'      => true,
      'company'      => true,
      'brand'      => true,
      'name'      => true,
      'phone'     => true,
      'email'     => true,
      'created_on' => true,
      'created_by' => true,
      'stage_status' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadListV3_AdminView

  //getLeadListV3
  public function getLeadListV3(Request $request)
  {

    $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('follow_date', 'asc')->where('added_by', Auth::user()->id)->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $data_arr[] = array(
        'RecordID' => $value->id,
        'rowid' => $value->id,
        'company' => $value->company,
        'brand' => $value->brand,
        'name' => $value->firstname,
        'phone' => $value->phone,
        'email' => $value->email,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $value->added_name,
        'stage_status' => $value->lead_statge


      );
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'rowid'      => true,
      'company'      => true,
      'brand'      => true,
      'name'      => true,
      'phone'     => true,
      'email'     => true,
      'created_on' => true,
      'created_by' => true,
      'stage_status' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadListV3
  //getClientsListOrderHave
  public function getClientsList(Request $request)
  {
    $user_id = Auth::user()->id;
    $edit_client_permission = 0;
    $delete_client_permission = 0;
    $user = auth()->user();
    if ($user->hasAnyPermission(['view-client-list'])) {
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if ($user->hasAnyPermission(['edit-client'])) {
        $edit_client_permission = 1;
      }
      if ($user->hasAnyPermission(['soft-delete-client'])) {
        $delete_client_permission = 1;
      }
      //start of admin permissions
      if ($user_role == 'Admin' ||  $user->hasPermissionTo('view-client-list')) {
        $users_arr = Client::where('is_deleted', '!=', 1)->orderBy('follow_date', 'asc')->get();
        //print_r(json_encode($users_arr));
        //  die;
        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);

          $location = $value->location;
          if (empty($value->brand)) {
            $comp = $value->company . "" . " <br>" . $location;
          } else {
            $comp = $value->company . "<br>( " . $value->brand . " )" . " <br>" . $location;
          }
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
          if ($user_role == 'Admin' || $user_role == 'SalesUser') {

            $phon = $value->phone;
          } else {
            //$phon = "";
            $phon = $value->phone;
          }
          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $phon,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }

      //end of admin permissions
      if ($user_role == 'SalesUser' || $user_role == 'Staff' || $user_role == 'CourierTrk') {


        //newcode
        if ($user_role == 'SalesUser' || $user_role == 'CourierTrk') {
          $users_arr = Client::where('is_deleted', '!=', 1)->where('added_by', $user_id)->orderBy('follow_date', 'asc')->get();
        }
        if ($user_role == 'Staff') {
          $users_arr = DB::table('clients as t1')
            ->leftJoin('users_access', 't1.id', '=', 'users_access.client_id')

            ->select('t1.*')
            ->orderBy('t1.id', 'DESC')
            ->where('t1.added_by', Auth::user()->id)
            ->orwhere('users_access.access_to', Auth::user()->id)
            //->orwhere('t1.client_owner_too',Auth::user()->id)
            ->where('t1.is_deleted', '!=', 1)
            ->get();
        }

        //newcode




        $data_arr = array();
        $i = 0;
        foreach ($users_arr as $key => $value) {
          $i++;
          $created_by = AyraHelp::getUserName($value->added_by);


          $location = $value->location;
          $comp = $value->company . "( " . $value->brand . " )";
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

          $data_arr[] = array(
            'RecordID' => $value->id,
            'rowid' => $value->id,
            'company' => $comp,
            'brand' => $value->brand,
            'location' => $location,
            'name' => $value->firstname,
            'phone' => $value->phone,
            'email' => $value->email,
            'created_on' => date('j M Y', strtotime($value->created_at)),
            'last_note_added' => $lastNote,
            'follow_date' => $followdate,
            'created_by' => $created_by,
            'status_user' => $value->status,
            'Status' => $value->group_status,
            'edit_p' => $edit_client_permission,
            'delete_p' => $delete_client_permission,
            'rawMFlaf' => $value->mark_raw_material,
          );
        }
      }
      //end of sales

      $JSON_Data = json_encode($data_arr);
      $columnsDefault = [
        'RecordID'     => true,
        'rowid'      => true,
        'company'      => true,
        'location'      => true,
        'name'      => true,
        'phone'     => true,
        'email'     => true,
        'created_on' => true,
        'last_note_added' => true,
        'created_by' => true,
        'status' => true,
        'group_status' => true,
        'Actions'      => true,
      ];

      $this->DataGridResponse($JSON_Data, $columnsDefault);
    } else {
      echo "Permission denied :L-38-Clinet";
    }
  }



  /*
    |--------------------------------------------------------------------------
    | function name:store
    |--------------------------------------------------------------------------
    | this is used to save client information to database
    */
  public function store(Request $request) //v2
  {
    $comp = $request->company;
    $phone = $request->phone;
    $email = $request->email;
    $client_crated_by = $request->client_crated_by;


    // print_r($request->all());
    // if(!empty($request->gst)){
    //   $data_arr=Client::where('gstno',$request->gst)->first();
    //   if($data_arr!=null){
    //     $res_arr = array(
    //       'status' => 2,
    //       'Message' => 'Client Already added with GST',
    //     );
    //     return response()->json($res_arr);
    //   }
    // }

    if (!empty($request->company)) {

      $data_arr1 = Client::where('company', $comp)->first();
      if ($data_arr1 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Client Already added with company',
        );
        return response()->json($res_arr);
      }
    }
    if (!empty($request->phone)) {

      $data_arr2 = Client::where('phone', $phone)->first();
      if ($data_arr2 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Client Already added with phone',
        );
        return response()->json($res_arr);
      }
    }
    if (!empty($request->email)) {

      $data_arr3 = Client::where('email', $email)->first();
      if ($data_arr3 != null) {
        $res_arr = array(
          'status' => 2,
          'Message' => 'Client Already added with email',
        );
        return response()->json($res_arr);
      }
    }

    $client_obj = new Client;
    $client_obj->firstname = $request->name;
    $client_obj->email = $request->email;
    $client_obj->phone = $request->phone;
    $client_obj->company = isset($request->company) ? $request->company : '';
    $client_obj->city = 12;
    $client_obj->country = 1;
    $client_obj->brand = $request->brand;
    $client_obj->gstno = $request->gst;
    $client_obj->location = $request->location;
    $client_obj->address = $request->address;
    $client_obj->source = $request->source;
    $client_obj->website = $request->website;
    $client_obj->remarks = $request->remarks;

    $client_obj->added_by = $client_crated_by;

    $client_obj->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Client saved successfully.',
    );
    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $eventName = "New Client Add";
    $eventINFO = "New Client is added by " . $LoggedName . " Client Phone NO : " . $request->phone . "& Name:" . $request->name;
    $eventID = $client_obj->id;

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
    return response()->json($res_arr);
  }


  public function softdeleteClient(Request $request)
  { //v2


    $userid = $request->userId;
    $sample_arr = Sample::where('client_id', $userid)->first();
    if ($sample_arr == null) {
      Client::where('id', $userid)
        ->update(['is_deleted' => 1]);
      $data = array(
        'status' => '1',
        'message' => 'Sent for Deleted Deleted successfully',
      );
    } else {
      $data = array(
        'status' => '0',
        'message' => 'Sample added for this client',
      );
    }



    return response()->json($data);
  }

  public function getClientDetails(Request $request)
  { //v2

    $client_arr = Client::where('id', $request->recordID)->first();

    $client_data = array(
      'name' => isset($client_arr->firstname) ? $client_arr->firstname : '',
      'user_id' => isset($client_arr->user_id) ? $client_arr->user_id : '',
      'id' => isset($client_arr->id) ? $client_arr->id : '',
      'email' => isset($client_arr->email) ? $client_arr->email : '',
      'phone' => isset($client_arr->phone) ? $client_arr->phone : '',
      'company' => isset($client_arr->company) ? $client_arr->company : '',
      'address' => isset($client_arr->address) ? $client_arr->address : '',
      'gst' => isset($client_arr->gstno) ? $client_arr->gstno : '',
      'brand' => isset($client_arr->brand) ? $client_arr->brand : '',
      'remarks' => isset($client_arr->remarks) ? $client_arr->remarks : '',
      'added_by' => isset($client_arr->added_by) ? $client_arr->added_by : '',
      'city' => isset($client_arr->city) ? $client_arr->city : '',
      'country' => isset($client_arr->country) ? $client_arr->country : '',
    );
    return response()->json($client_data);
  }

  public function edit_client(Request $request)
  { //

    $rowid = $request->rowid;
    $gstI = $request->gst;

    Client::where('id', $rowid)
      ->update([
        'firstname' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'company' => $request->company,
        'brand' =>  $request->brand,
        'gstno' => $gstI,
        'address' => $request->address,
        'remarks' => $request->remarks
      ]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Client Edit  successfully.',
    );
    return response()->json($res_arr);
  }
  /*
|--------------------------------------------------------------------------
| function name:create
|--------------------------------------------------------------------------
| this is used to create client
*/

  public function create()
  {
    abort(401);
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['info' => 'Hello World'];
    return $theme->scope('client.create', $data)->render();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);
  }
  protected function validator_without_email(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);
  }

  public function store_(Request $request)
  {
    if ($request->email == "") {
      $no_email = 'NoEmail_' . date('ymdHis') . '@boitel.xyzz';
      $request->merge(['email' => $no_email]);
      $user = User::create($request->only('email', 'name', 'password', 'created_by', 'phone'));
      $user->assignRole('Client');
      $insertedId = $user->id;
      $comp_obj = new Company;
      $comp_obj->user_id = $insertedId;
      $comp_obj->company_name = $request->company;
      $comp_obj->user_role = 'RootClient';
      $comp_obj->brand_name = $request->brnad_name;
      $comp_obj->gst_details = $request->gst;
      $comp_obj->address = $request->address;
      $comp_obj->sale_agent_id = $request->created_by;
      $comp_obj->remarks = $request->remarks;
      $comp_obj->save();
    } else {
      $this->validate($request, [
        'name' => 'required|max:120',
        'phone' => 'required|max:120',
        'email' => 'required|email|unique:users'

      ]);
      $user = User::create($request->only('email', 'name', 'password', 'created_by', 'phone'));

      $user->assignRole('Client');

      $insertedId = $user->id;
      $comp_obj = new Company;
      $comp_obj->user_id = $insertedId;
      $comp_obj->company_name = $request->company;
      $comp_obj->user_role = 'RootClient';
      $comp_obj->brand_name = $request->brnad_name;
      $comp_obj->gst_details = $request->gst;
      $comp_obj->address = $request->address;
      $comp_obj->sale_agent_id = $request->created_by;
      $comp_obj->remarks = $request->remarks;
      $comp_obj->save();
    }
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }

  /*
     |--------------------------------------------------------------------------
     | function name:show
     |--------------------------------------------------------------------------
     | this is used to view client information
     */
  public function show($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $client_data = Client::where('id', $id)->first();

    $user = auth()->user();
    if ($user->hasAnyPermission(['view-all-notes'])) {
      $client_notes = ClientNote::where('clinet_id', $id)->orderBy('id', 'desc')->get();
    } else {
      $client_notes = ClientNote::where('clinet_id', $id)->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
    }

    $data = ['client_data' => $client_data, 'client_notes' => $client_notes];
    //client order grapgh
    $lava = new Lavacharts; // See note below for Laravel

    $client_orderValue = $lava->DataTable();
    $client_orderValue->addDateColumn('Year')
      ->addNumberColumn('Order Value')
      ->setDateTimeFormat('Y-m-d');

    for ($x = 4; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

      //$active_date=date('Y')."-".$x."-1";
      if ($x >= 5) {
        $active_date = "2021-" . $x . "-1";
      } else {
        $active_date = date('Y') . "-" . $x . "-1";
      }

      $data_output = AyraHelp::getClientOrderValMonthWise($x, $id);
      $client_orderValue->addRow([$active_date, $data_output]);
    }

    $bo_level = 'BO_CLIENT_ORDER';


    $donutchart = \Lava::ColumnChart($bo_level, $client_orderValue, [
      'title' => 'Order Value of ' . optional($client_data)->company,
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],

    ]);

    //client order grapgh



    return $theme->scope('client.view', $data)->render();
  }
  // addNotesONLead
  public function addNotesONLead(Request $request)
  {


    $datesh = $request->shdate_input;



    //$sh_date_exp =date('Y-m-d', strtotime($date_1));

    $sh_date = date('Y-m-d', strtotime($datesh));



    $note_date = date("Y-m-d");
    //-----------------------
    DB::table('client_sales_lead')
      ->where('QUERY_ID', $request->QUERY_ID)
      ->update(['last_note_updated' => $note_date]);

    if ($request->shchk_val == 1) {

      DB::table('client_sales_lead')
        ->where('QUERY_ID', $request->QUERY_ID)
        ->update(['follow_date' => $sh_date]);
    } else {
      $sh_date = null;
    }

    //--------------------------



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





    $res_arr = array(
      'status' => 1,
      'Message' => 'Note saved successfully.',
    );
    return response()->json($res_arr);
  }

  // addNotesONLead

  /*
    |--------------------------------------------------------------------------
    | function name:add_Note
    |--------------------------------------------------------------------------
    | this is used to add client notes
    */

  //addLeadNotes
  public function addLeadNotes(Request $request)
  {
    $datesh = $request->sh_date;
    $radioValue = $request->radioValue;
    $sh_date = date('Y-m-d', strtotime($datesh));

    $note_date = date("Y-m-d");
    Client::where('id', $request->lead_id)
      ->update(['last_note_updated' => $note_date]);



    if ($request->shchk_val == 1) {

      if($radioValue==1){
        Client::where('id', $request->lead_id)
        ->update(['follow_date' => $sh_date]);
      }
     
    } else {
      $sh_date = null;
    }

    $clienNote = new ClientNote;
    $clienNote->clinet_id = $request->lead_id;
    $clienNote->is_schedule = $request->shchk_val;
    $clienNote->date_schedule = $sh_date;

    $clienNote->user_id = Auth::user()->id;
    $clienNote->message = $request->message;
    $clienNote->note_type = 'NOTES';
    $clienNote->save();
    $username = AyraHelp::getUserName(Auth::user()->id);


    
    $res_arr = array(
      'status' => 1,
      'Message' => 'Note saved successfully.',
    );
    return response()->json($res_arr);
  }

  //addLeadNotes

  public function add_Note(Request $request)
  {
    $datesh = $request->sh_date;
    $sh_date = date('Y-m-d', strtotime($datesh));

    $note_date = date("Y-m-d");
    Client::where('id', $request->user_id)
      ->update(['last_note_updated' => $note_date]);


    if ($request->shchk_val == 1) {

      Client::where('id', $request->user_id)
        ->update(['follow_date' => $sh_date]);
    } else {
      $sh_date = null;
    }

    $clienNote = new ClientNote;
    $clienNote->clinet_id = $request->user_id;
    $clienNote->is_schedule = $request->shchk_val;
    $clienNote->date_schedule = $sh_date;

    $clienNote->user_id = Auth::user()->id;
    $clienNote->message = $request->message;
    $clienNote->save();
    $username = AyraHelp::getUserName(Auth::user()->id);


    $this->UserLogActivity(
      Auth::user()->id,
      'warning',
      $username . ': New Note added to client ' . AyraHelp::getClientbyid($request->user_id)->firstname . '<br>Message' . $request->message,
      1
    );

    $res_arr = array(
      'status' => 1,
      'Message' => 'Note saved successfully.',
    );
    return response()->json($res_arr);
  }
  /*
    |--------------------------------------------------------------------------
    | function name:deleteNote
    |--------------------------------------------------------------------------
    | this is used to delete client notes
    */
  public function deleteNote(Request $request)
  {

    $notes = ClientNote::find($request->rowid);
    $notes->delete();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Note deleted successfully.',
    );
    return response()->json($res_arr);
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
    $client_data = Client::where('id', $id)->first();
    $data = ['data' => $client_data];
    return $theme->scope('client.edit', $data)->render();
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

    Client::where('id', $id)
      ->update([
        'firstname' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'company' => $request->company,
        'brand' =>  $request->brand,
        'gstno' => $request->gst,
        'address' => $request->address,
        'source' => $request->source,
        'website' => $request->website,
        'location' => $request->location,
        'group_status' => $request->client_group_status,
        'remarks' => $request->remarks

      ]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Client Edit  successfully.',
    );
    return response()->json($res_arr);
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

  public function sendMail()
  {
    $data = array('name' => "Virat ");

    Mail::send(['text' => 'mail'], $data, function ($message) {
      $message->to('bointldev@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
      $message->from('bointldev@gmail.com', 'Virat ');
    });
    echo "Basic Email Sent. Check your inbox.";
  }
}
