<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use App\User;
use App\Sample;
use App\SampleItem;
use App\Company;
use App\Client;
use App\QCFORM;
use Khill\Lavacharts\Lavacharts;
use App\RowClient;
use App\ContactClient;
use Auth;
use DB;
use App\Events\WhatIsHappening;
use Pusher;
use Carbon\Carbon;
use App\Helpers\AyraHelp;
//include 'class-list-util.php';
class SampleController extends Controller
{
  public function __construct()
  {

    //$this->middleware(['auth', 'clinetPermission','isAdmin'])->except('getSampleGraphList','print_all','print','getPrintSampleListOwn','getPrintSampleList','getROWClientsList','softdeleteClient','deleteClient','clients_edit','getClientDetails','getClientsListforDelete','deleteSample','samples_edit','samples_edit_info','saveSampleCourier','getSampleDetails','getClientAddress','getClientsList', 'getClientList','getSampleList','getSamplesList','samples');
    $this->middleware(['auth', 'isAdmin'])->except('samplePendingFeedback')->except(
      'getSampleGraphList',
      'getClientAddress',
      'saveSampleCourier',
      'print_all',
      'print',
      'getPrintSampleListOwn',
      'getPrintSampleList',
      'getROWClientsList',
      'softdeleteClient',
      'deleteClient',
      'clients_edit',
      '
   getClientDetails',
      'getClientsListforDelete',
      'deleteSample',
      'samples_edit',
      'samples_edit_info',
      'getOrderDataInfo',
      'getSampleDetails',
      'getClientsList',
      'getClientList',
      'getSampleList',
      'getSamplesList',
      'getClientBrandName',
      'feedbackSampleGraph',
      'printSamplewithFilter',
      'viewSamplePendingList',
      'viewSamplePendingListBYCat',
      'getDispachStageOrderListData',
      'samples'
    );
  }


  //add_salesLead_sampleV2Modify
  public function add_salesLead_sampleV2Modify($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;

    $data_arr_dataItem = DB::table('sample_items')
      ->where('id', '=', $leadid)
      ->first();
    $data_arr_dataItemSample = DB::table('samples')
      ->where('id', '=', $data_arr_dataItem->sid)
      ->first();

    $data_arr_data = DB::table('clients')
      ->where('id', '=', $data_arr_dataItemSample->client_id)
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id,
      'samples_data' => $data_arr_dataItemSample,
      'samples_data_items' => $data_arr_dataItem,

    ];
    return $theme->scope('sample.create_SalesLeadV2Modify', $data)->render();
  }

  //add_salesLead_sampleV2Modify

  //add_salesLead_sampleV2
  public function add_salesLead_sampleV2($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('clients')
      ->where('id', '=', $leadid)
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_SalesLeadV2', $data)->render();
  }

  //add_salesLead_sampleV2

  //add_salesLead_sampleV1Modify
  public function add_salesLead_sampleV1Modify($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('clients')
      ->where('id', '=', $leadid)
      ->first();
    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_SalesLeadV1Modify', $data)->render();
  }

  //add_salesLead_sampleV1Modify

  //add_salesLead_sampleV1
  public function add_salesLead_sampleV1($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('clients')
      ->where('id', '=', $leadid)
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_SalesLeadV1', $data)->render();
  }

  //updateChemistLayout
  public function updateChemistLayout(Request $request)
  {
    //print_r($request->all());
    $user_id = $request->user_id;
    $max_id = $request->txtSLimit;
    $sampleCatTypeArr = $request->sampleCatType;

    $affected = DB::table('sample_assigned_list')
      ->where('user_id', $user_id)
      ->update(['max_id' => $max_id]);
    DB::table('sample_for_users')->where('user_id', '=', $user_id)->delete();

    foreach ($sampleCatTypeArr as $key => $row) {

      DB::table('sample_for_users')->insert([
        'user_id' => $user_id,
        'sample_type_id' => $row,
        'is_active' => 1
      ]);
    }

    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }
  //updateChemistLayout

  public function saveSalesLeadSampleV2(Request $request)
  {
    // echo "<pre>";
    // print_r($request->all());
    // die;
    $txtIsModify = 0;
    $txtIsModifyItem = "";
    if ($request->txtIsModify == 1) {
      $txtIsModify = 1;
      $txtIsModifyItem = $request->previousSample_id;
    }

    $is_paid = 0;
    $payment_id = null;
    if ($request->paidSample == 1) {
      $is_paid = 1;
      $payment_id = $request->paymentID;
    }
    $sampleIDModi = null;
    if ($request->sample_type == 50) {
      $sidCode = $request->sampleItemName[0];
      $samArrData = Sample::where('sample_code', $sidCode)->first();
      $sampleIDModi = $samArrData->id;
    }

    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleBrandType = $request->sampleBrandType;
      $sampleOrderSize = $request->sampleOrderSize;
      $sample_type = $request->sample_type;
      $txtSample_Name_Arr = $request->txtSample_Name;
      $txtSample_Cat_Arr = $request->txtSample_Cat;
      $txtSample_SubCat_Arr = $request->txtSample_SubCat;
      $txtSample_Fragrance_Arr = $request->txtSample_Fragrance;
      $txtSample_Color_Arr = $request->txtSample_Color;
      $txtSample_packType_Arr = $request->txtSample_packType;
      $txtSample_tprice_Arr = $request->txtSample_tprice;
      $txtSample_Info_Arr = $request->txtSample_Info;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;
      $ordercouT = 'NA';
      $LEAD_Data = DB::table('clients')->where('id', $request->client_id)->first();
      $name = $LEAD_Data->firstname;
      $phone = $LEAD_Data->phone;
      $company = $LEAD_Data->company;
      $added_userid = $LEAD_Data->added_by;

      $sid_code = AyraHelp::getSampleIDCodeBYUserID($added_userid);

      $ajata = array();
      $i = 0;
      $j = 0;
      $M = 0;

      foreach ($txtSample_Name_Arr as $key => $rowData) {
        $M++;
        $samples_category_Data = DB::table('samples_category')
          ->where('id', $txtSample_Cat_Arr[$i])
          ->first();
        $samples_SubCategory_Data = DB::table('samples_category_sub')
          ->where('id', $txtSample_SubCat_Arr[$i])
          ->first();
        $samples_PackType_Data = DB::table('samples_packing_type')
          ->where('id', $txtSample_packType_Arr[$i])
          ->first();
        //

        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $txtSample_Name_Arr[$i]),
          'txtDiscrption' => $txtSample_Info_Arr[$i],
          'sample_type' => $sample_type,
          'price_per_kg' => $txtSample_tprice_Arr[$i],
          'color' => $txtSample_Color_Arr[$i],
          'fragrance' => $txtSample_Fragrance_Arr[$i],
          'packing_type' => $txtSample_packType_Arr[$i],
          'packing_type_name' => $samples_PackType_Data->name,
          'sample_cat' => $samples_category_Data->name,
          'sample_sub_cat' => $samples_SubCategory_Data->name,
          'sample_cat_id' => $samples_category_Data->id,
          'sample_sub_cat_id' => $samples_SubCategory_Data->id,
          'sid_partby_code' => $sid_code . "-" . $M,
          'sid_partby_id' => $M,
          'sample_type' => $request->sampleType


        );
        $j++;
        $i++;
      }
      //------------------------------
      $sample_data = json_encode($ajata);


      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      //$ordercouT = AyraHelp::getClientHaveOrder($request->client_id);



      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      //$sample->created_by = Auth::user()->id;
      $sample->created_by = $added_userid;
      $sample->created_by_ori = Auth::user()->id;


      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;

      $sample->sample_v = 2; //new category wise 
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->sample_from = $request->sample_from; //added by lead
      $sample->chkHandedOver = $request->chkHandedOver; //added by lead
      $sample->is_domestic = $request->chkHandedIsDomestic; //added by lead
      $sample->status = 1;
      $sample->brand_type = $sampleBrandType;
      $sample->order_size = $sampleOrderSize;
      //$sample->sample_from_id = $request->client_id;
      $sample->contact_phone = $request->contact_phone;
      $sample->is_paid = $is_paid;
      $sample->payment_id = $payment_id;
      $sample->modi_sample_id = $sampleIDModi;
      $sample->is_modify_sample = $txtIsModify;
      $sample->modify_sample_pre_code = $txtIsModifyItem;
      $sample->save();  //save all data in db

      //----------------------------------
      //save to samples item
      $i = 0;
      foreach ($ajata as $key => $rowData) {



        DB::table('sample_items')->insert([
          'sid' => $sample->id,
          'item_name' => $rowData['txtItem'],
          'item_info' => $rowData['txtDiscrption'],
          'sample_type' => $rowData['sample_type'],
          'price_per_kg' => $rowData['price_per_kg'],
          'sid_partby_code' => $rowData['sid_partby_code'],
          'sid_partby_id' => $rowData['sid_partby_id'],
          'brand_type' => $sampleBrandType,
          'order_size' => $sampleOrderSize,
          'sample_cat' => $rowData['sample_cat'],
          'sample_sub_cat' => $rowData['sample_sub_cat'],
          'sample_cat_id' => $rowData['sample_cat_id'],
          'sample_sub_cat_id' => $rowData['sample_sub_cat_id'],
          'sample_fragrance' => $rowData['fragrance'],
          'sample_color' => $rowData['color'],
          'sample_v' => 2,
          'stage_id' => 1,
          'admin_status' => 55,
          'txtSample_packType' => $rowData['packing_type'],
          'txtSample_packType_name' => $rowData['packing_type_name']
        ]);

        /*
        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id, 'item_name' => $rowData['txtItem']],
            [

              'item_name' => $rowData['txtItem'],
              'item_info' => $rowData['txtDiscrption'],
              'sample_type' => $rowData['sample_type'],
              'price_per_kg' => $rowData['price_per_kg'],
              'sid_partby_code' => $rowData['sid_partby_code'],
              'sid_partby_id' => $rowData['sid_partby_id'],
              'brand_type' => $sampleBrandType,
              'order_size' => $sampleOrderSize,
              'sample_cat' => $rowData['sample_cat'],
              'sample_sub_cat' => $rowData['sample_sub_cat'],
              'sample_cat_id' => $rowData['sample_cat_id'],
              'sample_sub_cat_id' => $rowData['sample_sub_cat_id'],
              'sample_fragrance' => $rowData['fragrance'],
              'sample_color' => $rowData['color'],
              'sample_v' => 2,
              'stage_id' => 1,
              'admin_status' => 55,
              'txtSample_packType' => $rowData['packing_type'],
              'txtSample_packType_name' => $rowData['packing_type_name']

            ]
          );
          */

        $i++;
        $lid = DB::getPdo()->lastInsertId();
        //save stages of child samples
        $ticket_id = $lid;
        DB::table('st_process_action_6v2')->insert(
          [
            'ticket_id' => $ticket_id,
            'process_id' => 6,
            'stage_id' => 1,
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
        //save stages of child samples
      }

      //save to sample item
      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done
      // if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {

      //if client's order is approved by account then  free sample else paid 
      $orderCountQC = DB::table('qc_forms')
        ->where('is_deleted', 0)
        ->where('account_approval', 1)
        ->where('client_id', $request->client_id)
        ->count();

      if($orderCountQC>0){
        $ajk=0;  
      }else{
        //now check brand as now small and medium 
        $ajV=0;
        $samples_brands_approvalArr = DB::table('samples_brands_approval')
        ->where('brand_type', $sampleBrandType)
        ->where('is_paid_approved', 1) // 1 paid
        ->first();
        if ($samples_brands_approvalArr != null) {
          $ajV++;
        }
        // $samples_typesArr = DB::table('samples_types')
        // ->where('samples_type', optional($request)->sample_type)
        // ->where('is_approved', 1)
        // ->first();
        // if ($samples_typesArr != null) {
        //   $ajV++;
        // }
        if($ajV==0){
          $ajk=0;
        }else{
         
          $affected = DB::table('samples')
          ->where('id', $sample->id)
          ->update([
            'is_paid_status' => 1, //  need to upload payment
            'is_paid_brand_type' => $sampleBrandType,
            'is_paid_sample_type' => @$request->sample_type,
          ]);
          $ajk=4;
        }

      }
      

      if ($ajk == 0) {


        //ajaj
        $ticket_id = $sample->id;


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
      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );


      //-----   now update client statge also check client or not 
      $data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 3)->where('action_on', 1)->first();

      if ($data == null) {
        //check qualified statge is complete or not if not then make it
        $dataA = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 2)->where('action_on', 1)->first();
        if ($dataA == null) {

          DB::table('st_process_sales_lead_v1')->insert(
            [
              'ticket_id' => $request->client_id,
              'process_id' => 7,
              'stage_id' => 2,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Add Sample Qualified',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
        }

        //check qualified statge is complete or not if not then make it
        //sample staege also complete
        DB::table('st_process_sales_lead_v1')->insert(
          [
            'ticket_id' => $request->client_id,
            'process_id' => 7,
            'stage_id' => 3,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Add Sample Stage:Sampling Completed',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );


        $dataClientArr = DB::table('clients')->where('id', $request->client_id)->where('lead_statge', '>=', 3)->where('lead_statge', '<=', 5)->first();
        if ($dataClientArr == null) {
          $affected = DB::table('clients')
            ->where('id', $request->client_id)
            ->update([
              'lead_statge' => 3,

            ]);
        }
      } //sample staege also complete 

      //--------------------------------------------------------

    } //end of null


    return response()->json($res_arr);
  }  //end of sample add v2
  //saveSalesLeadSample

  //saveSalesLeadSampleV2
  
  public function saveSalesLeadSample(Request $request)
  {
    // echo "<pre>";
    // print_r($request->all());

    $is_paid = 0;
    $payment_id = null;
    if ($request->paidSample == 1) {
      $is_paid = 1;
      $payment_id = $request->paymentID;
    }
    $sampleIDModi = null;
    if ($request->sample_type == 5) {
      $sidCode = $request->sampleItemName[0];
      $samArrData = Sample::where('sample_code', $sidCode)->first();
      $sampleIDModi = $samArrData->id;
    }


    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleItemName_Arr = $request->sampleItemName;
      $sampleDiscription_Arr = $request->sampleDiscription;
      $samplsampleType_Arr = $request->sampleType;
      $price_per_kg_Arr = $request->price_per_kg;
      $sampleBrandType = $request->sampleBrandType;
      $sampleOrderSize = $request->sampleOrderSize;


      $ajata = array();
      $i = 0;
      $j = 0;

      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );
        $j++;
        $i++;
      }

      //$sample_data = json_encode($request->aj);
      $sample_data = json_encode($ajata);

      // $max_sample_index = Sample::max('sample_index')+1;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

      $sid_code = AyraHelp::getSampleIDCode();

      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      //$ordercouT = AyraHelp::getClientHaveOrder($request->client_id);
      $ordercouT = 'NA';

      $LEAD_Data = DB::table('clients')->where('id', $request->client_id)->first();


      $name = $LEAD_Data->firstname;
      $phone = $LEAD_Data->phone;
      $company = $LEAD_Data->company;
      //-------


      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      //$sample->created_by = Auth::user()->id;
      $sample->created_by = $request->added_userid;
      $sample->created_by_ori = Auth::user()->id;


      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;

      $sample->sample_v = 1;
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->sample_from = $request->sample_from; //added by lead
      $sample->chkHandedOver = $request->chkHandedOver; //added by lead
      $sample->is_domestic = $request->chkHandedIsDomestic; //added by lead
      $sample->status = 1;
      $sample->brand_type = $sampleBrandType;
      $sample->order_size = $sampleOrderSize;
      //$sample->sample_from_id = $request->client_id;
      $sample->contact_phone = $request->contact_phone;
      $sample->is_paid = $is_paid;
      $sample->payment_id = $payment_id;
      $sample->modi_sample_id = $sampleIDModi;


      $sample->save();
      $i = 0;
      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );

        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id, 'item_name' => $rowData[$i]],
            [

              'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
              'item_info' => $sampleDiscription_Arr[$i],
              'sample_type' => $samplsampleType_Arr[$i],
              'price_per_kg' => $price_per_kg_Arr[$i],

            ]
          );
        $i++;
      }


      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done

      //event(new WhatIsHappening($sample));
      // AyraHelp::setSampleSalesLeadData(); // thos function same lead data to sample table

      // AyraHelp::setAllSampleAssinedNow(); //auto assigned
      // if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {
  //check old or new client if old then 0 else 1
   $orderCountQC = DB::table('qc_forms')
        ->where('is_deleted', 0)
        ->where('account_approval', 1)
        ->where('client_id', $request->client_id)
        ->count();

      if($orderCountQC>0){
        $ajk=0;  
      }else{
        //now check brand as now small and medium 
        $ajV=0;
        $samples_brands_approvalArr = DB::table('samples_brands_approval')
        ->where('brand_type', $sampleBrandType)
        ->where('is_paid_approved', 1) // 1 paid
        ->first();
        if ($samples_brands_approvalArr != null) {
          $ajV++;
        }
        // $samples_typesArr = DB::table('samples_types')
        // ->where('samples_type', optional($request)->sample_type)
        // ->where('is_approved', 1)
        // ->first();
        
        // if ($samples_typesArr != null) {
        //   $ajV++;
        // }

        if($ajV==0){
          $ajk=0;
        }else{
         
          $affected = DB::table('samples')
          ->where('id', $sample->id)
          ->update([
            'is_paid_status' => 1, //  need to upload payment
            'is_paid_brand_type' => $sampleBrandType,
            'is_paid_sample_type' => @$request->sample_type,
          ]);
          $ajk=4;
        }
                 
      }
      
      if ($ajk == 0) {


        //ajaj
        $ticket_id = $sample->id;


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

          $data_arr = array(
            'status' => 1,
            'msg' => 'Added  successfully'
          );

          $affected = DB::table('samples')
            ->where('id', $ticket_id)
            ->update([
              'sample_stage_id' => 2,

            ]);
          //AyraHelp::setAllSampleAssinedNow_AP(); //auto assigned
          // AyraHelp::setSampleAssinedThisAsNow($ticket_id); //auto assigned 



        } else {
          $data_arr = array(
            'status' => 0,
            'Message' => 'Already Done'
          );
        }

        //ajaj
      }



      // event(new WhatIsHappening($sample));
      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );
    }


    $data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 3)->where('action_on', 1)->first();

    if ($data == null) {
      //check qualified statge is complete or not if not then make it
      $dataA = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 2)->where('action_on', 1)->first();
      if ($dataA == null) {

        DB::table('st_process_sales_lead_v1')->insert(
          [
            'ticket_id' => $request->client_id,
            'process_id' => 7,
            'stage_id' => 2,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Add Sample Qualified',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );
      }

      //check qualified statge is complete or not if not then make it
      //sample staege also complete
      DB::table('st_process_sales_lead_v1')->insert(
        [
          'ticket_id' => $request->client_id,
          'process_id' => 7,
          'stage_id' => 3,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Sample Add Stage completed',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
        ]
      );


      $affected = DB::table('clients')
        ->where('id', $request->client_id)
        ->update([
          'lead_statge' => 3,

        ]);

      //sample staege also complete


    }

    return response()->json($res_arr);
  }
  //saveSalesLeadSample

  //savePaymentAmountSample
  public function savePaymentAmountSample(Request $request)
  {


    $client_arr = AyraHelp::getClientbyid($request->client_select);
    $filename = '';
    if ($request->hasfile('payIMG')) {
      $file = $request->file('payIMG');
      $filename = "img_1_PAYM_sample" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);
    }


    $id =  DB::table('payment_recieved_from_client_for_sample')->insert(
      [
        'sample_id' => $request->sample_id_pay,
        'recieved_on' => date('Y-m-d H:i:s'),
        'rec_amount' => $request->payAmt,
        // 'rec_amount_words' => ucwords($request->Ls),
        'bank_name' => $request->bank_name,
        'request_remarks' => $request->txtPayRemak,
        'payment_img' =>  $filename,
        'created_by' =>  Auth::user()->id,
        'created_by_ori' =>  Auth::user()->id,

        'payment_for' =>   '2'
      ]
    );

    return redirect()->back()->with('success', 'Submitted successfully');
  }
  //savePaymentAmountSample


  //getSampleItemDetailPayment
  public function getSampleItemDetailPayment(Request $request)
  {
    $sampleArr = DB::table('samples')
      ->where('id', $request->recordID)
      ->first();

    $SampleArrData = json_decode($sampleArr->sample_details);
    $i = 0;
    $HTML = '<table class="table table-bordered m-table m-table--border-success">
    <thead>
      <tr>
        <th>#</th>
        <th>Item Name</th>   
        <th>Amount</th>      
      </tr>
    </thead>
    <tbody>';

    $amt = 100;

    foreach ($SampleArrData as $key => $rowData) {
      $i++;

      $HTML .= '
      <tr>
        <th scope="row">' . $i . '</th>
        <td>' . $rowData->txtItem . '</td> 
        <td>' . $amt . '</td>        
      </tr>';
    }

    $HTML .= ' </tbody>
</table>';


    // print_r($sampleArr->sample_details);

    $resp = array(
      'status' => 1,
      'itemQTY' => $i,
      'itemQTYAMT' => $i * $amt,
      'HTML' => $HTML

    );


    //ajcode


    return response()->json($resp);
  }
  //getSampleItemDetailPayment

  //getSampleFeedbackData
  public function getSampleFeedbackData(Request $request)
  {
    //print_r($request->all());

    $sample = DB::table('samples')
      ->select('id', 'sample_feedback', 'sample_feedback_other', 'feedback_addedon')
      ->where('id', $request->recordID)
      ->first();

    $resp = array(
      'status' => 1,
      'data' => $sample
    );


    //ajcode


    return response()->json($resp);
  }
  //getSampleFeedbackData
  //sampleResubmit
  public function sampleResubmit(Request $request)
  {

    $s_id = $request->s_id;
    $affected = DB::table('samples')
      ->where('id', $s_id)
      ->update(['is_rejected' => 0]);
    $resp = array(
      'status' => 1,
      'Msg' => 'dare',
    );


    //ajcode


    return response()->json($resp);
  }

  //sampleResubmit

  //saveSampleTechLinkingData
  public function saveSampleTechLinkingData(Request $request)
  {

    $txtSampleID = $request->txtSampleID;
    $tech_item_name = $request->tech_item_name;
    $select_sample_id_ori = $request->select_sample_id_ori;
    $tech_notes = $request->tech_notes;
    $sample_by_part_idArr = $request->sample_by_part_id;
    $sample_by_part_idNArr = $request->sample_by_part_idN;
    $dataArr = array();
    foreach ($sample_by_part_idNArr as $key => $rowData) {
      $dataArr[] = array(
        'sample_item_name' => $rowData
      );
    }
    $data = json_encode($dataArr);







    DB::table('samples_for_approval_list')
      ->updateOrInsert(
        ['sample_tech_id' => $txtSampleID],
        [
          'sample_id' => $select_sample_id_ori,
          'sample_item_data' => $data,
          'created_by' => Auth::user()->id,
          'created_at' => date('Y-m-d'),
          'notes' => $tech_notes
        ]
      );
  }
  //saveSampleTechLinkingData
  //saveSampleTechDocFeedback_Appproved_price
  public function saveSampleTechDocFeedback_Appproved_price(Request $request)
  {
    // print_r($request->all());
    $id = $request->txtSampleID_DOC;
    $txtMin = 0;
    $txtMax = 0;
    $txtSize_1 = $request->txtSize_1;
    $txtPrice_1 = $request->txtPrice_1;
    $finish_p_catid = $request->finish_p_catid;
    $finish_p_subcatid = $request->finish_p_subcatid;
    $tech_notes_approval = $request->tech_notes_approval;

    $samples_for_approval_listArr = DB::table('samples_for_approval_list')
      ->where('id', $id)
      ->first();

    // $FinishProductArr = DB::table('rnd_finish_product_cat')
    // ->where('id', $finish_p_catid)
    // ->first();



    // print_r($samples_for_approval_listArr);



    DB::table('rnd_finish_products')
      ->updateOrInsert(
        ['sample_approval_id' => $id],
        [
          'product_name' => $samples_for_approval_listArr->item_name,
          'cat_id' => $finish_p_catid,
          'sub_cat_id' => $finish_p_subcatid,
          'ingredents_details' => '',
          'chemist_by' => '21',
          'sp_min' => $txtMin,
          'sp_max' => $txtMax,
          'size_1' => $txtSize_1,
          'price_1' => $txtPrice_1,
          'sample_approval_id' => $id,
          'sample_approval_by' => Auth::user()->id,
          'sample_approval_on' => date('Y-m-d H:i:s'),
        ]
      );


    DB::table('samples_for_approval_list')
      ->updateOrInsert(
        ['id' => $id],
        [

          'cat_id' => $finish_p_catid,
          'sub_cat_id' => $finish_p_subcatid,
          'min_price' => $txtMin,
          'max_price' => $txtMax,
          'size_1' => $txtSize_1,
          'price_1' => $txtPrice_1,
          'status' => 1,

        ]
      );
  }

  //saveSampleTechDocFeedback_Appproved_price
  //getFAQDetailsBYID
  public function getFAQDetailsBYID(Request $request)
  {
    $recordID = $request->recordID;

    $FAQArrTech = DB::table('samples_faq')
      ->where('id', $recordID)
      ->first();


    $HTML = "";
    $HTML .= '

    <table class="table table-bordered .table-sm m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
          <tr>
            <th colspan="4">Question: <b>' . $FAQArrTech->posts . '</b></th>

          </tr>
        </thead>
        <tbody>
          <tr>
          <td>Asked By: <b>' . AyraHelp::getUser($FAQArrTech->created_by)->name . '</b></td>
            <td>Created On:<b>' . date('j M Y H:iA', strtotime($FAQArrTech->created_at)) . '</b></td>

            <td colspan="2">Product Name:<b>' . $FAQArrTech->product_name . '</b> </td>
          </tr>


        </tbody>
      </table>

  ';


    $HTMLAns = "";
    $FAQArrTechAns = DB::table('samples_faq_answered')
      ->where('q_id', $recordID)
      ->get();

    foreach ($FAQArrTechAns as $key => $row) {
      $HTMLAns .= '

    <table class="table table-bordered .table-sm m-table m-table--border-success m-table--head-bg-success">
        <thead>
          <tr>
            <th colspan="4">Answered By: <b>' . AyraHelp::getUser($row->created_by)->name  . '</b>
            Answerd on:<b>' . date(' j M y H:iA', strtotime($row->created_at)) . '</b>

            </th>

          </tr>
        </thead>
        <tbody>
          <tr>
          <td>
          ' . $row->answes . '
          </td>



          </tr>


        </tbody>
      </table>

  ';
    }






    // <th colspan="4" scope="row">Chemist Name:<b>' .@AyraHelp::getUser($samplesArrData->assingned_to)->name . '</b></th>
    //echo $HTML;
    $resp = array(
      'status' => 1,
      'Question' => $HTML,
      'QuestionAns' => $HTMLAns
    );


    //ajcode


    return response()->json($resp);
  }

  //getFAQDetailsBYID

  //getAllSampleDetails
  public function getAllSampleDetails(Request $request)
  {
    $recordID = $request->recordID;

    $samplesArrTech = DB::table('samples_tech_list')
      ->where('id', $recordID)
      ->first();
    $sample_id = $samplesArrTech->sample_id;

    $samplesArrData = DB::table('samples')
      ->where('id', $sample_id)
      ->first();
    // echo "<pre>";
    // print_r($samplesArrData);
    // die;  //ss

    if ($samplesArrData->sample_from == 0) {
      $clientData = DB::table('clients')
        ->where('id', $samplesArrData->client_id)
        ->first();
      $company = optional($clientData)->company . "" . optional($clientData)->brand;
    } else {

      $company = optional($samplesArrData)->lead_name . "" . optional($samplesArrData)->lead_company;
    }
    if ($samplesArrData->status == 1) {
      $status = "NEW";
    } else {
      $status = "DISPATCH";
    }

    $HTML = "";
    $HTML .= '<div class="m-section">
    <div class="m-section__content">
    <table class="table table-bordered .table-sm m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
          <tr>
            <th colspan="4">Sample Details</th>

          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Sample Code:<b>' . $samplesArrData->sample_code . '</b></th>
            <td>Created On:<b><br>' . date('j M Y H:i:s', strtotime($samplesArrData->created_at)) . '</b></td>
            <td>Created By: <b>' . AyraHelp::getUser($samplesArrData->created_by)->name . '</b></td>
            <td>Company:<b>' . $company . '</b> </td>
          </tr>
          <tr>
          <th scope="row">Sample Status:<b><br>' . $status . '</b></th>
          <td>Approved By:<b></b></td>
          <td>Price Per Kg : <b>' . $samplesArrData->price_per_kg . '</b></td>
          <td>Dispatched ON:<b><br>' . date('j M Y H:i:s', strtotime($samplesArrData->sent_on)) . '</b></td>
        </tr>
        <tr>
                     
                      <td colspan="12">
                        <table class="table table-sm m-table m-table--head-bg-metal">
                          <thead class="thead-inverse">
                            <tr>
                              <th style="color:#000">#</th>
                              <th style="color:#000">Item</th>
                              <th style="color:#000">Category</th>
                              <th style="color:#000">Sub Category</th>
                              <th style="color:#000">Color</th>
                              <th style="color:#000">Fragrance</th>
                              <th style="color:#000">Pack Type:</th>
                              <th style="color:#000">T. Price/Kg:</th>
                              <th style="color:#000">Description</th>
                            </tr>
                          </thead>
                          <tbody>';
    $sampleItemArrData = DB::table('sample_items')
      ->where('sid', $samplesArrData->id)
      ->get();
    $i = 0;
    foreach ($sampleItemArrData as $key => $value) {
      $i++;
      $HTML .= '<tr>
                          <th style="color:#000">' . $i . '</th>
                          <th style="color:#000">' . $value->item_name . '</th>
                          <th style="color:#000">' . $value->sample_cat . '</th>
                          <th style="color:#000">' . $value->sample_sub_cat . '</th>
                          <th style="color:#000">' . $value->sample_color . '</th>
                          <th style="color:#000">' . $value->sample_fragrance . '</th>
                          <th style="color:#000">' . $value->txtSample_packType_name . '</th>
                          <th style="color:#000">' . $value->price_per_kg . '</th>
                          <th style="color:#000">' . $value->item_info . '</th>                         
                           </tr>';
    }

    $HTML .= '</tbody>
                          </table>
                          </td>
                          </tr>
        </tbody>
      </table>
    </div>
  </div>';


    $HTML .= '<div class="m-section">
    <div class="m-section__content">
    <table class="table table-bordered .table-sm m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
          <tr>
            <th colspan="4">Ingredent Details</th>

          </tr>
        </thead>
        <tbody>
        <tr>
        <th colspan="4" scope="row"><b>Note' . optional($samplesArrTech)->notes . '</b></th>

      </tr>
          <tr>
            <th colspan="4" scope="row"><b>' . optional($samplesArrTech)->ingredent_data . '</b></th>

          </tr>



        </tbody>
      </table>
    </div>
  </div>';
    echo $samplesArrTech->sample_code;
    $samplesDataFormulaArr = DB::table('samples_formula')
      ->where('sample_code_with_part', $samplesArrTech->sample_code)
      ->get();
    // print_r($samplesDataFormulaArr);
    // die;



    if (count($samplesDataFormulaArr) > 0) {

      $HTML .= '<div class="m-section">
  <div class="m-section__content">
  <table class="table table-bordered .table-sm m-table m-table--border-brand m-table--head-bg-brand">
      <thead>
        <tr>
          <th colspan="8">Formulations</th>
        </tr>
      </thead>
      <tbody>';
      foreach ($samplesDataFormulaArr as $key => $rowData) {

        $HTML .= '<tr>
        <tr>

                <td><b>Fragrance:</b><br>' . @$rowData->fragrance . '</td>
                <td><b>Color:</b><br>' . @$rowData->color_val . '</td>
                <td><b>PH:</b><br>' . @$rowData->ph_val . '</td>
                <td><b>Apperance:</b><br>' . @$rowData->apperance_val . '</td>
                <td><b>Chemist:</b><br>' . @AyraHelp::getUser($rowData->chemist_id)->name . '</td>
                <td><b>Formulated on:</b><br>' . date('j-F-Y H:iA', strtotime($rowData->formulated_on)) . '</td>
                <td><b>Completed by:</b><br>' . @AyraHelp::getUser($rowData->created_by)->name . '</td>
                <td><b>Completed on:</b><br>' . date('j F Y', strtotime($rowData->created_on)) . '</td>

            </tr>

      </tr>';
      }





      $HTML .= '</tbody>
    </table>
  </div>
</div>';
    }





    // <th colspan="4" scope="row">Chemist Name:<b>' .@AyraHelp::getUser($samplesArrData->assingned_to)->name . '</b></th>
    // 'sample_code_with_part' => $rowData->sample_code_with_part,
    //     'item_name' => $rowData->item_name,
    //     'key_ingredent' => $rowData->key_ingredent,
    //     'fragrance' => $rowData->fragrance,
    //     'color_val' => $rowData->color_val,
    //     'ph_val' => $rowData->ph_val,
    //     'apperance_val' => $rowData->apperance_val,
    //     'chemist_id' => AyraHelp::getUser($rowData->chemist_id)->name,
    //     'created_on' => date('j F Y', strtotime($rowData->created_on)),
    //     'created_by' => $rowData->created_by,
    //     'formulated_on' => date('j-F-Y H:iA', strtotime($rowData->formulated_on)),

    echo $HTML;
  }
  //getAllSampleDetails

  //saveOrderTechDocFeedback_DOC
  public function saveOrderTechDocFeedback_DOC(Request $request)
  {
    if (isset($request->tech_ingredents)) {
      $filename = '';
      if ($request->hasfile('customFileTechDoc')) {
        // echo "ddd";
        // die;
        $file = $request->file('customFileTechDoc');
        $filename = "img_order_tech" . $request->txtSampleID_DOC . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename);

        DB::table('order_tech_list')
          ->updateOrInsert(
            ['id' => $request->txtSampleID_DOC],
            [
              'doc_name' => $filename

            ]
          );
      }
    } else {

      //aa
      $filename = '';
      if ($request->hasfile('customFileTechDoc')) {
        // echo "ddd";
        // die;
        $file = $request->file('customFileTechDoc');
        $filename = "img_sample_tech" . $request->txtSampleID_DOC . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename);

        DB::table('order_tech_list')
          ->updateOrInsert(
            ['id' => $request->txtSampleID_DOC],
            [
              'doc_name' => $filename

            ]
          );


        ///send email to

        require 'vendor/autoload.php';
        $Apikey = AyraHelp::APISendKey();
        // echo $to;
        // echo $subLineM;
        // print_r($body);
        // print_r($email_template);


        $sampleData = DB::table('order_tech_list')
          ->where('id', $request->txtSampleID_DOC)
          ->first();

        $body = "Sample ID:" . $sampleData->order_id . "<br>Item Name: " . $sampleData->item_name . " has been uploaded please check in ERP";


        $to = AyraHelp::getUser($sampleData->created_by)->email;


        $subLineM = "Order Technical Document uploaded in ERP";

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("info@max.net", "MAX");
        $email->setSubject($subLineM);
        // $email->addTo($to, '');
        // $email->addTo('bointldev@gmail.com', 'Ajay');
        // $email->addCc('pooja@max.net','Pooja Gupta');
        // $email->addCc('nitika@max.net ', 'Admin');
        // $email->addCc('pooja@max.net', 'Pooja Gupta');
        // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
        // $email->addCc('botechdocs@max.net', 'Anuj Rana');
        // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
        // $email->addBcc('bointldev@gmail.com', 'Ajay');
        //$email->addBcc('botechdocs@gmail.com', 'Neha');
        $email->addTo('bointldev@gmail.com', 'Ajay');
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

        ///send email to

      }
      //aa
    }


    $resp = array(
      'status' => 1,
      'Msg' => 'dare',
    );


    //ajcode


    return response()->json($resp);
  }

  //saveOrderTechDocFeedback_DOC

  //saveSampleTechDocFeedback_DOC
  public function saveSampleTechDocFeedback_DOC(Request $request)
  {
    if (isset($request->tech_ingredents)) {
      $filename = '';
      if ($request->hasfile('customFileTechDoc')) {
        // echo "ddd";
        // die;
        $file = $request->file('customFileTechDoc');
        $filename = "img_sample_tech" . $request->txtSampleID_DOC . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename);

        DB::table('samples_tech_list')
          ->updateOrInsert(
            ['id' => $request->txtSampleID_DOC],
            [
              'doc_name' => $filename

            ]
          );
      }
      DB::table('samples_tech_list')
        ->updateOrInsert(
          ['id' => $request->txtSampleID_DOC],
          [
            'doc_name' => $filename,
            'ingredent_data' => $request->tech_ingredents

          ]
        );
    } else {

      //aa
      $filename = '';
      if ($request->hasfile('customFileTechDoc')) {
        // echo "ddd";
        // die;
        $file = $request->file('customFileTechDoc');
        $filename = "img_sample_tech" . $request->txtSampleID_DOC . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename);

        DB::table('samples_tech_list')
          ->updateOrInsert(
            ['id' => $request->txtSampleID_DOC],
            [
              'doc_name' => $filename

            ]
          );


        ///send email to

        require 'vendor/autoload.php';
        $Apikey = AyraHelp::APISendKey();
        // echo $to;
        // echo $subLineM;
        // print_r($body);
        // print_r($email_template);


        $sampleData = DB::table('samples_tech_list')
          ->where('id', $request->txtSampleID_DOC)
          ->first();
        $sentTo = $sampleData->sample_id;

        $sampleDataA = DB::table('samples')
          ->where('id', $sentTo)
          ->first();

        $body = "Sample ID:" . $sampleData->sample_code . "<br>Item Name: " . $sampleData->item_name . " has been uploaded please check in ERP";


        $to = AyraHelp::getUser($sampleData->created_by)->email;


        $subLineM = "Technical Document uploaded in ERP";

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("info@max.net", "MAX");
        $email->setSubject($subLineM);
        $email->addTo($to, '');
        // $email->addTo('bointldev@gmail.com', 'Ajay');
        // $email->addCc('pooja@max.net','Pooja Gupta');
        // $email->addCc('nitika@max.net ', 'Admin');
        // $email->addCc('pooja@max.net', 'Pooja Gupta');
        // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
        // $email->addCc('botechdocs@max.net', 'Anuj Rana');
        // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
        // $email->addBcc('bointldev@gmail.com', 'Ajay');
        $email->addBcc('botechdocs@gmail.com', 'Neha');
        // $email->addBcc('bointldev@gmail.com', 'Ajay');
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

        ///send email to

      }
      //aa
    }


    $resp = array(
      'status' => 1,
      'Msg' => 'dare',
    );


    //ajcode


    return response()->json($resp);
  }
  //saveSampleTechDocFeedback_DOC
  //saveSampleTechDocFeedback
  public function saveSampleTechDocFeedback(Request $request)
  {
    $txtSampleID = $request->txtSampleID;
    // $tech_item_name=$request->tech_item_name;
    // $tech_status=1;
    $tech_notes = $request->tech_notes;

    DB::table('samples_tech_list')
      ->updateOrInsert(
        ['id' => $txtSampleID],
        [
          'status' => 1,
          'agent_approved' => 1,
          'feedback_addedby' => Auth::user()->id,
          'feedback_addedon' => date('Y-m-d H:i:s'),
          'feedback_notes' => $tech_notes
        ]
      );

    $resp = array(
      'status' => 1,
      'Msg' => 'dare',
    );


    //ajcode


    return response()->json($resp);
  }

  //saveSampleTechDocFeedback

  //setSampleProcessResponse
  public function setSampleProcessResponse(Request $request)
  {

    $sid = $request->sid;
    $txtMess = $request->txtMess;
    $respType = $request->respType;
    switch ($respType) {
      case 1:
        $sps = "Start Process";
        break;

      default:
        $sps = "Please Wait";
        break;
    }

    $affected = DB::table('samples')
      ->where('id', $sid)
      ->update(['process_status' => $respType]);

    DB::table('sample_process')->insert(
      [
        'sample_id' => $sid,
        'created_by' => Auth::user()->id,
        'created_on' => date('Y-m-d H:i:s'),
        'notes' => $txtMess,
        'status' => $respType
      ]
    );


    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;


    $eventName = "Sample Process";
    $eventINFO = 'Sample ID:' . $sid . "  proceees with message  " . $txtMess . " by" . $LoggedName;
    $eventID = $sid;
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
    $sample_arr = Sample::where('id', $sid)->first();

    //pusher
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

    $eventID = 'AJ_ID' . $sample_arr->created_by;

    $data['message'] = 'Sample code: ' . $sample_arr->sample_code . "<br>has been ".$sps." with message ".$txtMess;


    $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
    //puhser


    $resp = array(
      'status' => 1,
      'Msg' => 'dare',
    );


    //ajcode


    return response()->json($resp);
  }


  //setSampleProcessResponse

  //getThisMonthKNOW_MissedRec_API_DATA
  public function getThisMonthKNOW_MissedRec_API_DATA(Request $request)
  {
    $main_arr[] = array('Date', 'KNW Missed', 'KNW Received');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_currentm_knowlarity_missed_call')->get();
    } else {
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->where('user_id',Auth::user()->id)->get();
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    }

    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j F Y', strtotime($rowData->day_date)), intVal($rowData->missed_call), intVal($rowData->recieved_call));
    }
    return json_encode($main_arr);
  }


  //getThisMonthKNOW_MissedRec_API_DATA
  //getThisMonthBUYLEAD_API_DATA
  public function getThisMonthBUYLEAD_API_DATA(Request $request)
  {
    $main_arr[] = array('Date', '9999955922@API_1', '8929503295@API_2', 'INDMART-9811098426@API_5');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_currentm_buylead_all_api')->get();
    } else {
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->where('user_id',Auth::user()->id)->get();
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    }

    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j F Y', strtotime($rowData->day_date)), intVal($rowData->api_1), intVal($rowData->api_2), intVal($rowData->api_3));
    }
    return json_encode($main_arr);
  }


  //getThisMonthBUYLEAD_API_DATA
  //getThisMonthKnowlarityIN_OUT
  public function getThisMonthKnowlarityIN(Request $request)
  {
    $main_arr[] = array('Date', 'Received Call');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_currentm_knowlaritydata')->get();
    } else {
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->where('user_id',Auth::user()->id)->get();
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    }

    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j F Y', strtotime($rowData->day_date)), intVal($rowData->in_call));
    }
    return json_encode($main_arr);
  }


  //getThisMonthKnowlarityIN_OUT

  //getThisMonthKnowlarityIN_OUT
  public function getThisMonthKnowlarityOUT(Request $request)
  {
    $main_arr[] = array('Date', 'Outgoing Call');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_currentm_knowlaritydata')->get();
    } else {
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->where('user_id',Auth::user()->id)->get();
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    }

    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j F Y', strtotime($rowData->day_date)), intVal($rowData->out_call));
    }
    return json_encode($main_arr);
  }


  //getThisMonthKnowlarityIN_OUT


  public function getDispachStageOrderListData(Request $request)
  {

    if ($request->poFlag == 1) {


      $cid = $request->cid;
      $client_arr = Client::where('id', $cid)->first();

      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('client_id', $cid)->where('dispatch_status', '=', 1)->get();

      $HTML = '<option value="">-SELECT ORDER-</option>';

      foreach ($qc_arr as $key => $rowData) {
        $data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);
        $Spname = $data->stage_name;
        if ($Spname == 'Dispatch') {

          $HTML .= '<option selected value="' . $rowData->form_id . '">' . $rowData->order_id . "/" . $rowData->subOrder . '</option>';
        } else {
          //$HTML .='<option value="">NA</option>';

        }
      }


      $resp = array(
        'HTML_LIST' => $HTML,
        'clientData' => $client_arr,
      );
    } else {
      //ajcode
      $cid = $request->cid;
      $client_arr = Client::where('id', $cid)->first();

      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('client_id', $cid)->where('dispatch_status', '=', 2)->get();

      $HTML = '<option value="">-SELECT ORDER-</option>';

      foreach ($qc_arr as $key => $rowData) {
        $data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);
        $Spname = $data->stage_name;
        if ($Spname == 'Dispatch') {

          $HTML .= '<option selected value="' . $rowData->form_id . '">' . $rowData->order_id . "/" . $rowData->subOrder . '</option>';
        } else {
          //$HTML .='<option value="">NA</option>';

        }
      }


      $resp = array(
        'HTML_LIST' => $HTML,
        'clientData' => $client_arr,
      );


      //ajcode

    }
    return response()->json($resp);
  }

  // add_myLead_sample
  public function add_myLead_sample($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;

    $data_arr_data = DB::table('client_sales_lead')
      ->where('assign_to', '=', Auth::user()->id)
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_lead', $data)->render();
  }

  // add_myLead_sample
  //deleteSampleRNDFormulaBase
  public function deleteSampleRNDFormulaBase(Request $request)
  {

    $rowid = $request->rowid;
    $affected = DB::table('bo_formuation_v1')
      ->where('id', $rowid)
      ->update(['is_deleted' => 1]);


    $data = array(
      'status' => '1',
      'message' => 'Deleted successfully',
    );
    return response()->json($data);
  }

  //deleteSampleRNDFormulaBase

  //deleteSampleRNDFormula
  public function deleteSampleRNDFormula(Request $request)
  {

    $rowid = $request->rowid;
    $affected = DB::table('bo_formuation')
      ->where('id', $rowid)
      ->update(['is_deleted' => 1]);


    $data = array(
      'status' => '1',
      'message' => 'Deleted successfully',
    );
    return response()->json($data);
  }

  //deleteSampleRNDFormula

  //deleteSampleTechDoc
  public function deleteSampleTechDoc(Request $request)
  {

    $form_id = $request->form_id;
    $affected = DB::table('samples_tech_list')
      ->where('id', $form_id)
      ->update(['is_deleted' => 1]);


    $data = array(
      'status' => '1',
      'message' => 'Deleted successfully',
    );
    return response()->json($data);
  }

  //deleteSampleTechDoc

  //add_stage_sampleV2
  public function add_stage_sampleV2($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('indmt_data')
      ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
      ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
      ->where('indmt_data.QUERY_ID', '=', $leadid)
      ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
      ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
      ->first();

    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_leadV2', $data)->render();
  }

  //add_stage_sampleV2

  //add_stage_sampleV1
  public function add_stage_sampleV1($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('indmt_data')
      ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
      ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
      ->where('indmt_data.QUERY_ID', '=', $leadid)
      ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
      ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_leadV1', $data)->render();
  }

  //add_stage_sampleV1

  public function add_stage_sample($leadid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data_arr_data = DB::table('indmt_data')
      ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
      ->where('lead_assign.assign_user_id', '=', Auth::user()->id)
      ->where('indmt_data.QUERY_ID', '=', $leadid)
      ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
      ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
      ->first();


    $data = [
      'users' => $data_arr_data,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_lead', $data)->render();
  }

  // viewSamplePendingListBYCat
  public function viewSamplePendingListBYCat(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_pending_sample_catView', $data)->render();
  }

  // viewSamplePendingListBYCat

  //viewSampleAssinedListMe
  public function viewSampleAssinedListMe(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_assigned_sampleMe', $data)->render();
  }

  //viewSampleAssinedListMe

  public function viewSampleAssinedList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_assigned_sample', $data)->render();
  }
  //viewSampleBenchmarkList
  public function viewSampleBenchmarkList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_benchmark_sample', $data)->render();
  }

  //viewSampleBenchmarkList

  //viewSampleStandardList
  public function viewSampleStandardList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_standard_sample', $data)->render();
  }

  //viewSampleStandardList



  public function viewSamplePendingList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'users' => '$users',
      'sample_id' => '',
      'sample_data' => ''
    ];
    return $theme->scope('sample.print_pending_sample', $data)->render();
  }
  //getSampleLabelPrint
  public function getSampleLabelPrint(Request $request)
  {
    // print_r($request->all());
    DB::table('tbl_sample_print_lbl')->truncate();
    $sample_codeArr = $request->sample_code;
    $sample_track_idArr = $request->track_id;
    $sample_nameArr = $request->name;
    $sample_AddressArr = $request->address;
    $sample_phoneArr = $request->phone;

    foreach ($sample_codeArr as $key => $rowData) {


      DB::table('tbl_sample_print_lbl')->insert([
        'sample_code' => $sample_codeArr[$key],
        'track_id' => $sample_track_idArr[$key],
        'name' => $sample_nameArr[$key],
        'address' =>  $sample_AddressArr[$key],
        'phone' => $sample_phoneArr[$key],

      ]);
    }


    $theme = Theme::uses('corex')->layout('layout');
    $today = date('Y-m-d');
    //$sample_arr = Sample::where('status', 2)->whereDate('sent_on', $today)->orderBy('sent_on', 'asc')->get();
    $sample_arr = DB::table('tbl_sample_print_lbl')->get();

    $data = [
      'today_dispatch_sent' => $sample_arr,


    ];

    return $theme->scope('sample.printLabelPrint', $data)->render();
  }
  //getSampleLabelPrint
  //getSampleLabelPrintEntry
  public function getSampleLabelPrintEntry(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $today = date('Y-m-d');
    $sample_arr = Sample::where('status', 2)->whereYear('sent_on', $today)->orderBy('sent_on', 'asc')->get();



    //$sample_arr = DB::table('tbl_sample_print_lbl')->get();

    $data = [
      'data' => $sample_arr,


    ];

    return $theme->scope('sample.printLabelPrintEntry', $data)->render();
  }
  //getSampleForLBLPrint
  public function getSampleForLBLPrint(Request $request)
  {

    $data = Sample::where('id', $request->sample_id)->first();

    return response()->json($data);
  }
  //getSampleForLBLPrint


  //getSampleLabelPrintEntry

  //printSamplewithFilterV2
  public function printSamplewithFilterV2(Request $request)
  {
    // print_r($request->request);
    // die;
    $txtSampleCat = $request->txtSampleCat;
    // sample_items

    $print_sample_date = $request->print_sample_date_v2;
    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $print_sample_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffInDays($to);
    $date = \Carbon\Carbon::today()->subDays($diff_in_days);



    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Sampler' ||  $user_role == 'CourierTrk' || $user_role == 'SalesHead' || Auth::user()->id == 146 || Auth::user()->id == 124 || Auth::user()->id == 189) {

      //$sample_arr = SampleItem::where('is_formulated', 0)->where('is_deleted', 0)->where('sample_cat_id', $txtSampleCat)->whereDate('created_at', '>=', $date)->distinct()->get('sid');
      $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->whereDate('created_at', '>=', $date)->orderBy('brand_type', 'DESC')->get();
      $sample_arr_Admin = Sample::where('status', 1)->where('is_deleted', 0)->whereDate('created_at', '>=', $date)->where('admin_urgent_status', 1)->get();


      // sample print 

      if (count($sample_arr) <= 0) {
        // return redirect()->route('qcform.list');
        $sample_search = date("d,F Y", strtotime($to));
        return redirect('/')->with('status', 'No sample found from ' . $sample_search);
      } else {
        $data = [
          'sample_data' => $sample_arr,
          'sample_cat_id' => $txtSampleCat,
          'sample_arr_Admin' => $sample_arr_Admin,

        ];

        return $theme->scope('sample.printV2WithCategoryWiseV2', $data)->render();
      }


      // sample print 

    } else {
      abort(401);
    }
  }
  //printSamplewithFilterV2
  public function printSamplewithFilter(Request $request)
  {
    $samplePrintCat = $request->samplePrintCat;
    $print_sample_date = $request->print_sample_date;
    $print_sample_date_to = $request->print_sample_date_to;

    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $print_sample_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffInDays($to);
    $date = \Carbon\Carbon::today()->subDays($diff_in_days);

    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $fromDate = $print_sample_date;
    $ToDate = $print_sample_date_to;



    if ($user_role == 'Admin' || $user_role == 'Sampler' ||  $user_role == 'CourierTrk' || $user_role == 'SalesHead' || Auth::user()->id == 146 || Auth::user()->id == 124 || Auth::user()->id == 189 || Auth::user()->id == 89 || Auth::user()->id == 206) {

      switch ($samplePrintCat) {
        case 1:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 1)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 2:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 2)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 3:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 3)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 4:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 4)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 5:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 5)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 6:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();
          break;
        case 7:

          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('is_formulated', 0)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->get();



          break;
        case 8:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->orderBy('id', 'desc')->where('is_formulated', 0)->get();

          break;
        case 9:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
        case 10:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('admin_urgent_status', 1)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('is_formulated', 0)->get();

          break;
        case 11:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('brand_type', 4)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
        case 12:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->where('brand_type', '!=', 4)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
      }

      if (count($sample_arr) <= 0) {
        // return redirect()->route('qcform.list');
        $sample_search = date("d,F Y", strtotime($to));
        return redirect('/')->with('status', 'No sample found from ' . $sample_search);
      }
    } else {
      if ($user_role == 'SalesUser') {
        $sample_arr = Sample::where('status', 1)->where('created_by', Auth::user()->id)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $ToDate)->get();
        if (count($sample_arr) <= 0) {
          // return redirect()->route('qcform.list');
          $sample_search = date("d,F Y", strtotime($to));
          return redirect('/')->with('status', 'No sample found from ' . $sample_search);
        }
      } else {
        $sample_arr1 = DB::table('samples')
          ->join('users_access', function ($join) {
            $join->on('samples.client_id', '=', 'users_access.client_id');
            $join->on('users_access.access_by', '=', 'samples.created_by');
          })
          ->select('samples.*')
          ->orderBy('samples.id', 'DESC')
          ->orwhere('users_access.access_to', Auth::user()->id)
          ->where('samples.status', 1)
          ->get();
      }
    }

    foreach ($sample_arr as $key => $value) {



      $users = Client::where('id', $value->client_id)->first();

      $client_data = AyraHelp::getClientbyid($value->client_id);
      if ($value->created_at != null) {
        $sample_created = date("d,F Y", strtotime($value->created_at));
      } else {
        $sample_created = '';
      }
      $cname = isset($client_data->firstname) ? $client_data->firstname : "";
      $cbran = isset($client_data->company) ? $client_data->company : "";

      $sample_data[] = array(
        'sample_code' => $value->sample_code,
        'client_name' => $cname . "(" . $cbran . ")",
        'client_phone' => optional($users)->phone,
        'client_address' => optional($value)->ship_address,
        'client_company' => optional($users)->company,
        'sample_created' => $sample_created,
        'sample_remarks' => optional($value)->remarks,
        'sample_details' => json_decode(optional($value)->sample_details),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,
        'admin_status' => $value->admin_urgent_status,
        'assigneTO' => @$value->assingned_name,
        'countSample' => count($sample_arr),
        'modify_sample_pre_code' => @$value->modify_sample_pre_code,
        'sample_type' => @$value->sample_type,
        'is_paid_status' => @$value->is_paid_status,

      );
    }

    $data = [
      'users' => '$users',
      'sample_id' => $max_id,
      'sample_data' => $sample_data
    ];


    //return $theme->scope('sample.print', $data)->render();
    if ($samplePrintCat == 8) {
      return $theme->scope('sample.printLatest', $data)->render();
    } else {
      if ($samplePrintCat == 10) {
        return $theme->scope('sample.printUrgent', $data)->render();
      } else {
        if ($samplePrintCat == 11) {



          return $theme->scope('sample.printBigBrand', $data)->render();
        } else {
          if ($samplePrintCat == 11) {
            return $theme->scope('sample.printBigBrand', $data)->render();
          } else {
            return $theme->scope('sample.print', $data)->render();
          }
        }
      }
    }
  }
  public function printSamplewithFilterORIOK(Request $request)
  {
    $samplePrintCat = $request->samplePrintCat;
    $print_sample_date = $request->print_sample_date;
    $print_sample_date_to = $request->print_sample_date_to;

    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $print_sample_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffInDays($to);
    $date = \Carbon\Carbon::today()->subDays($diff_in_days);

    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Sampler' ||  $user_role == 'CourierTrk' || $user_role == 'SalesHead' || Auth::user()->id == 146 || Auth::user()->id == 124 || Auth::user()->id == 189) {

      switch ($samplePrintCat) {
        case 1:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 1)->where('created_at', '>=', $date)->get();

          break;
        case 2:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 2)->where('created_at', '>=', $date)->get();

          break;
        case 3:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 3)->where('created_at', '>=', $date)->get();

          break;
        case 4:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 4)->where('created_at', '>=', $date)->get();

          break;
        case 5:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', 5)->where('created_at', '>=', $date)->get();

          break;
        case 6:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('created_at', '>=', $date)->get();
          break;
        case 7:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('created_at', '>=', $date)->get();

          break;
        case 8:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('created_at', '>=', $date)->orderBy('id', 'desc')->get();

          break;
        case 9:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('created_at', '>=', $date)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
        case 10:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('admin_urgent_status', 1)->get();


          break;
        case 11:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('created_at', '>=', $date)->where('brand_type', 4)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
        case 12:
          $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->where('sample_type', '!=', 2)->where('created_at', '>=', $date)->where('brand_type', '!=', 4)->where('is_formulated', 0)->orderBy('id', 'desc')->get();

          break;
      }

      if (count($sample_arr) <= 0) {
        // return redirect()->route('qcform.list');
        $sample_search = date("d,F Y", strtotime($to));
        return redirect('/')->with('status', 'No sample found from ' . $sample_search);
      }
    } else {
      if ($user_role == 'SalesUser') {
        $sample_arr = Sample::where('status', 1)->where('created_by', Auth::user()->id)->where('created_at', '>=', $date)->get();
        if (count($sample_arr) <= 0) {
          // return redirect()->route('qcform.list');
          $sample_search = date("d,F Y", strtotime($to));
          return redirect('/')->with('status', 'No sample found from ' . $sample_search);
        }
      } else {
        $sample_arr1 = DB::table('samples')
          ->join('users_access', function ($join) {
            $join->on('samples.client_id', '=', 'users_access.client_id');
            $join->on('users_access.access_by', '=', 'samples.created_by');
          })
          ->select('samples.*')
          ->orderBy('samples.id', 'DESC')
          ->orwhere('users_access.access_to', Auth::user()->id)
          ->where('samples.status', 1)
          ->get();
      }
    }

    foreach ($sample_arr as $key => $value) {

      $users = Client::where('id', $value->client_id)->first();

      $client_data = AyraHelp::getClientbyid($value->client_id);
      if ($value->created_at != null) {
        $sample_created = date("d,F Y", strtotime($value->created_at));
      } else {
        $sample_created = '';
      }
      $cname = isset($client_data->firstname) ? $client_data->firstname : "";
      $cbran = isset($client_data->company) ? $client_data->company : "";

      $sample_data[] = array(
        'sample_code' => $value->sample_code,
        'client_name' => $cname . "(" . $cbran . ")",
        'client_phone' => optional($users)->phone,
        'client_address' => optional($value)->ship_address,
        'client_company' => optional($users)->company,
        'sample_created' => $sample_created,
        'sample_remarks' => optional($value)->remarks,
        'sample_details' => json_decode(optional($value)->sample_details),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,
        'admin_status' => $value->admin_urgent_status,
        'assigneTO' => @$value->assingned_name,
        'countSample' => count($sample_arr),
        'modify_sample_pre_code' => @$value->modify_sample_pre_code,
        'sample_type' => @$value->sample_type,

      );
    }

    $data = [
      'users' => '$users',
      'sample_id' => $max_id,
      'sample_data' => $sample_data
    ];


    //return $theme->scope('sample.print', $data)->render();
    if ($samplePrintCat == 8) {
      return $theme->scope('sample.printLatest', $data)->render();
    } else {
      if ($samplePrintCat == 10) {
        return $theme->scope('sample.printUrgent', $data)->render();
      } else {
        if ($samplePrintCat == 11) {



          return $theme->scope('sample.printBigBrand', $data)->render();
        } else {
          if ($samplePrintCat == 11) {
            return $theme->scope('sample.printBigBrand', $data)->render();
          } else {
            return $theme->scope('sample.print', $data)->render();
          }
        }
      }
    }
  }


  //-----------------------

  public function getOrderDataInfo(Request $request)
  {
    $orderid = $request->orderid;
    $data = QCFORM::where('order_id', $orderid)->get();
    return response()->json($data);
  }
  // getWeeklyRecivedMissed
  public function getWeeklyRecivedMissed(Request $request)
  {
    $main_arr[] = array('Week Range', 'Received', 'Missed');
    $agentArr = DB::table('graph_weeklydays')->get();
    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array($rowData->day_date, intVal($rowData->recieved_call), intVal($rowData->missed_call));
    }
    return json_encode($main_arr);
  }
  public function getWeeklyRecivedMissed_1(Request $request)
  {
    $main_arr[] = array('Week Range', 'Received', 'Missed');
    $agentArr = DB::table('graph_weeklydays_1')->get();
    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array($rowData->day_date, intVal($rowData->recieved_call), intVal($rowData->missed_call));
    }
    return json_encode($main_arr);
  }


  //getLast30DaysINOUT_knowlarity
  public function getLast30DaysINOUT_knowlarity(Request $request)
  {

    $main_arr[] = array('Name', 'Outgoing');

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_30days_knowlarity')->orderBy('missed_call', 'desc')->get();
    } else {
      //$agentArr = DB::table('graph_30days')->orderBy('recieved_call', 'desc')->where('user_id',Auth::user()->id)->get();
    }

    foreach ($agentArr as $key => $rowData) {

      $main_arr[] = array(trim($rowData->name), intVal($rowData->missed_call));
    }
    return json_encode($main_arr);
  }


  //getLast30DaysINOUT_knowlarity
  // getWeeklyRecivedMissed
  //getLast30DaysRecievedOnlyCall
  public function getLast30DaysRecievedOnlyCall(Request $request)
  {

    $main_arr[] = array('Name', 'Received', 'Average');

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_30days')->orderBy('recieved_call', 'desc')->get();
    } else {
      //$agentArr = DB::table('graph_30days')->orderBy('recieved_call', 'desc')->where('user_id',Auth::user()->id)->get();
    }

    foreach ($agentArr as $key => $rowData) {

      $main_arr[] = array(trim($rowData->name), intVal($rowData->recieved_call), intVal($rowData->average_call));
    }
    return json_encode($main_arr);
  }

  public function getLast30DaysRecievedOnlyCall_OLD_OK(Request $request)
  {
    $main_arr[] = array('Name', 'Received', 'Average');

    $agentArr = DB::table('agents')->distinct('user_id')->get('user_id');
    foreach ($agentArr as $key => $rowData) {
      $name = AyraHelp::getUser($rowData->user_id)->name;
      $totalCallDuration = AyraHelp::getTotalCallDuration($rowData->user_id, 30);
      $main_arr[] = array($name, $totalCallDuration['NoofCall'], $totalCallDuration['totAvg']);
    }
    //print_r($main_arr);
    return json_encode($main_arr);
  }

  //getLast30DaysAssignedQualifiedLead

  public function getLast30DaysAssignedQualifiedLead(Request $request)
  {
    $main_arr[] = array('Date', 'Assined', 'Qualified');

    $agentArr = DB::table('graph_currentm_assined_qualified')->get();
    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j-F Y', strtotime($rowData->day_date)), intVal($rowData->assined), intVal($rowData->qualified));
    }


    return json_encode($main_arr);
  }


  public function getLast30DaysAssignedQualifiedLead_OLDOK(Request $request)
  {
    $main_arr[] = array('Date', 'Assined', 'Qualified');

    $list = array();
    $month = date('m');
    $year = date('Y');

    for ($d = 1; $d <= 31; $d++) {
      $time = mktime(12, 0, 0, $month, $d, $year);
      if (date('m', $time) == $month)
        $list[] = date('Y-m-d', $time);
    }

    //print_r($list);
    foreach ($list as $key => $row) {
      $totalCallDuration = AyraHelp::getTotalAssinedQualifiedLeadThisMonth($row);
      $main_arr[] = array($row, $totalCallDuration['assined'], $totalCallDuration['qualified']);
    }
    return json_encode($main_arr);
  }
  // getLast30DaysAssignedQualifiedLead


  //getLast30DaysRecievedOnlyCall

  //getLast30DaysRecievedMissedCall

  public function getLast30DaysRecievedMissedCall(Request $request)
  {
    $main_arr[] = array('Date', 'Received', 'Missed');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    } else {
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->where('user_id',Auth::user()->id)->get();
      //$agentArr = DB::table('graph_l30daysmissed_recieved')->get();
    }

    foreach ($agentArr as $key => $rowData) {
      $main_arr[] = array(date('j F Y', strtotime($rowData->day_date)), intVal($rowData->recieved_call), intVal($rowData->missed_call));
    }
    return json_encode($main_arr);
  }

  //getSalesAllCallRecieved
  public function getSalesAllCallRecieved(Request $request)
  {
    $main_arr[] = array('Date', 'Received', 'Duration');

    $list = array();
    $month = date('m');
    $year = date('Y');

    for ($d = 1; $d <= 31; $d++) {
      $time = mktime(12, 0, 0, $month, $d, $year);
      if (date('m', $time) == $month)
        $list[] = date('Y-m-d', $time);
    }

    //print_r($list);
    foreach ($list as $key => $row) {
      $totalCallDuration = AyraHelp::getAllRecivedCallandDuration(Auth::user()->phone, $row);

      $main_arr[] = array($row, $totalCallDuration['NoofCall'], $totalCallDuration['Duration']);
    }
    return json_encode($main_arr);
  }


  //getSalesAllCallRecieved

  //getSalesClickCallMonthwise
  public function getSalesClickCallMonthwise(Request $request)
  {
    $main_arr[] = array('Date', 'Outgoing Call');

    $list = array();
    $month = date('m');
    $year = date('Y');

    for ($d = 1; $d <= 31; $d++) {
      $time = mktime(12, 0, 0, $month, $d, $year);
      if (date('m', $time) == $month)
        $list[] = date('Y-m-d', $time);
    }

    //print_r($list);
    foreach ($list as $key => $row) {
      $totalCallDuration = AyraHelp::getoutGoingCallbyPhoneAndDate(Auth::user()->phone, $row);

      $main_arr[] = array($row, $totalCallDuration);
    }
    return json_encode($main_arr);
  }

  //getSalesClickCallMonthwise

  public function getLast30DaysRecievedMissedCall_OLDOK(Request $request)
  {
    $main_arr[] = array('Date', 'Received', 'Missed');

    $list = array();
    $month = date('m');
    $year = date('Y');

    for ($d = 1; $d <= 31; $d++) {
      $time = mktime(12, 0, 0, $month, $d, $year);
      if (date('m', $time) == $month)
        $list[] = date('Y-m-d', $time);
    }

    //print_r($list);
    foreach ($list as $key => $row) {
      $totalCallDuration = AyraHelp::getTotalRecivedMessedCallThisMonth($row);


      $main_arr[] = array($row, $totalCallDuration['received'], $totalCallDuration['missed']);
    }
    return json_encode($main_arr);
  }

  //getLast30DaysRecievedMissedCall

  //getSalesClickCall
  public function getSalesClickCall(Request $request)
  {
    $agentArr = DB::table('graph_l7salesdays')->where('user_id', Auth::user()->id)->get();
    $main_arr = array();
    foreach ($agentArr as $key => $rowData) {

      $main_arr[] = array(trim(date('j F Y', strtotime($rowData->day_date))), intVal($rowData->recieved_call), intVal($rowData->average_call));
    }
    return json_encode($main_arr);
  }
  //getSalesClickCall

  //getSalesAllCallRecievedMonth
  public function getSalesAllCallRecievedMonth(Request $request)
  {
    $main_arr[] = array('Name', 'Received', 'Average');

    for ($x = 1; $x <= 12; $x++) {
      $active_date = date('Y') . "-" . $x . "-1";
      $m_digit = $x;
      $ydigit = date('Y');
      $monthName = date("F", mktime(0, 0, 0, $m_digit, 10));

      $users = DB::table('agent_calldata')->where('phone', Auth::user()->phone)->whereMonth('created_at', $m_digit)->whereYear('created_at', $ydigit)->get();
      $usersTotla = DB::table('agent_calldata')->where('phone', Auth::user()->phone)->whereMonth('created_at', $m_digit)->whereYear('created_at', $ydigit)->sum('call_duration');

      if (count($users) == 0) {
        $avg = 0;
      } else {
        $avg = $usersTotla / count($users);
      }

      $main_arr[] = array(trim($monthName), intVal(count($users)), $avg);
    }
    return json_encode($main_arr);
  }
  //getSalesAllCallRecievedMonth

  //  getLast7DaysTotalCallAvgCall_ARMChart
  public function getLast7DaysTotalCallAvgCall_ARMChart(Request $request)
  {
    $main_arr = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_7days')->orderBy('recieved_call', 'desc')->get();
    } else {
      //  $agentArr = DB::table('graph_7days')->orderBy('recieved_call', 'desc')->where('user_id',Auth::user()->id)->get();
    }

    foreach ($agentArr as $key => $rowData) {

      //$main_arr[]=array(''>trim($rowData->name),intVal($rowData->recieved_call),intVal($rowData->average_call));

      $main_arr[] = array(
        'sales_name' => $rowData->name,
        'callRecieved' => $rowData->recieved_call,
        'avgcall' => $rowData->average_call,
      );
    }
    return json_encode($main_arr);
  }

  //  getLast7DaysTotalCallAvgCall_ARMChart

  //getLast7DaysTotalCallAvgCall
  public function getLast7DaysTotalCallAvgCall(Request $request)
  {
    $main_arr[] = array('Name', 'Received', 'Average');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      $agentArr = DB::table('graph_7days')->orderBy('recieved_call', 'desc')->get();
    } else {
      //  $agentArr = DB::table('graph_7days')->orderBy('recieved_call', 'desc')->where('user_id',Auth::user()->id)->get();
    }

    foreach ($agentArr as $key => $rowData) {

      $main_arr[] = array(trim($rowData->name), intVal($rowData->recieved_call), intVal($rowData->average_call));
    }
    return json_encode($main_arr);
  }

  public function getLast7DaysTotalCallAvgCall_OLDOK(Request $request)
  {
    $main_arr[] = array('Name', 'Received', 'Average');

    $agentArr = DB::table('agents')->distinct('user_id')->get('user_id');
    foreach ($agentArr as $key => $rowData) {
      $name = AyraHelp::getUser($rowData->user_id)->name;
      $totalCallDuration = AyraHelp::getTotalCallDuration($rowData->user_id, 7);
      $main_arr[] = array($name, $totalCallDuration['NoofCall'], $totalCallDuration['totAvg']);
    }
    return json_encode($main_arr);
  }

  //getLast7DaysTotalCallAvgCall
  //getPendingFormulationSampleList
  public function getPendingFormulationSampleList(Request $request)
  {
    $sampleArr = DB::table('samples')
      ->where('is_deleted', 0)
      ->where('status', 1)
      ->orderBy('id', 'desc')
      ->get();
    $HTML = "";
    foreach ($sampleArr as $key => $row) {
      $HTML .= '<optgroup label="' . $row->sample_code . '">';
      $sampleArrITEM = DB::table('sample_items')->where('sid', $row->id)->get();
      foreach ($sampleArrITEM as $key => $rowData) {
        $HTML .= '<option value="' . $rowData->id . '">' . $rowData->sid_partby_code . ' (' . $rowData->item_name . ')</option>';
      }
      $HTML .= '</optgroup>';
    }
    echo $HTML;
  }
  //getPendingFormulationSampleList

  public function getSampleFeedbackPIE(Request $request)
  {
    //print_r($request->all());

    //$users = DB::table('order_stages_count')->get();
    $datafeed =  AyraHelp::getFeedbackDataByUser($request->salesPerson, $request->txtMonth, $request->txtyear);

    $users1 = array(
      'stage_id' => 'Changes suggest resend samples',
      'red_count' => $datafeed['feed_1']
    );
    $users2 = array(
      'stage_id' => 'Did not like',
      'red_count' => $datafeed['feed_2']
    );
    $users3 = array(
      'stage_id' => 'Stopped Responding',
      'red_count' => $datafeed['feed_3']
    );
    $users4 = array(
      'stage_id' => 'Sample Selected',
      'red_count' => $datafeed['feed_4']
    );
    $users = array($users1, $users2, $users3, $users4);

    foreach ($users as $key => $result) {

      //  print_r($result->red_count);
      $rows[] = array("c" => array("0" => array("v" => $result['stage_id'], "f" => NULL), "1" => array("v" => (int) $result['red_count'], "f" => NULL)));
    }
    echo $format = '{
      "cols":
      [
      {"id":"","label":"Subject","pattern":"","type":"string"},
      {"id":"","label":"Number","pattern":"","type":"number"}
      ],
      "rows":' . json_encode($rows) . '}';






    //return response()->json($data);

  }
  public function feedbackSampleGraph(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $lava = new Lavacharts; // See note below for Laravel
    $finances_orderValue = $lava->DataTable();
    $datafeed =  AyraHelp::getFeedbackData();


    $finances_orderValue->addStringColumn('Reasons')
      ->addNumberColumn('Percent')
      ->addRow(['Changes suggest resend samples', $datafeed['feed_1']])
      ->addRow(['Did not like', $datafeed['feed_2']])
      ->addRow(['Stopped Responding', $datafeed['feed_3']])
      ->addRow(['Sample Selected', $datafeed['feed_4']]);


    $donutchart = \Lava::PieChart('PIEFinancesOrderValue', $finances_orderValue, [
      'title'  => 'Sample Feedback',
      'is3D'   => true,
      'slices' => [
        ['offset' => 0.2],
        ['offset' => 0.25],
        ['offset' => 0.3]
      ]
    ]);



    $data = ['users' => $users];
    return $theme->scope('reports.pending_feedbackpie_graph', $data)->render();
  }

  public function samplePendingFeedback(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      return $theme->scope('sample.pending_feedback', $data)->render();
    } else {
      return $theme->scope('sample.pending_feedback_own', $data)->render();
    }
  }
  public function getSampleGraphList(Request $request)
  {
    $date = \Carbon\Carbon::today()->subDays(30);
    $usrid = $request->userid;
    if ($usrid == 1) {
      $samples = Sample::where('created_at', '>=', date($date))->get();
    } else {
      $samples = Sample::where('created_at', '>=', date($date))->where('created_by', $usrid)->get();
    }




    if ($usrid == 1) {
      //-------------------------
      $chartDatas = Sample::select([
        DB::raw('DATE(created_at) AS date'),
        DB::raw('COUNT(id) AS count'),
      ])
        ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])

        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get()
        ->toArray();
      //-------------------------
    } else {
      //-------------------------
      $chartDatas = Sample::select([
        DB::raw('DATE(created_at) AS date'),
        DB::raw('COUNT(id) AS count'),
      ])
        ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
        ->where('created_by', $usrid)
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get()
        ->toArray();
      //-------------------------
    }

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


    foreach ($chartDataByDay as $key => $value) {

      $aj_label[] = date('D d,F Y', strtotime($key));
      $aj_val[] = $value;
    }


    $data = array(
      'lable' => $aj_label,
      'DataVal' => $aj_val,
      'DataTotal' => count($samples),


    );
    return response()->json($data);
  }
  //saveSamplePriority
  public function saveSamplePriority(Request $request)
  {

    $flag_id = $request->flag_id;
    $note = $request->txtSampleAssinedRemark;

    Sample::where('id', $request->sampleIDA)
      ->update([
        'admin_urgent_status' => $flag_id,
        'admin_urgent_remarks' => $note,
        'admin_urgent_by' => Auth::user()->id,
      ]);
    SampleItem::where('sid', $request->sampleIDA)
      ->update([
        'admin_status' => $flag_id
      ]);



    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;


    $eventName = "Sample Set priority";
    $eventINFO = 'Sample ID:' . $request->sampleIDA . " set priority by" . $LoggedName . "MSG-" . $note;
    $eventID = $request->sampleIDA;
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



    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }

  //saveSampleRejectModify
  public function saveSampleRejectModify(Request $request)
  {
    $sid = $request->sampleIDA;
    $note = $request->txtSampleAssinedRemark;

    Sample::where('id', $request->sampleIDA)
      ->update([
        'is_rejected' => 1,
        'is_rejected_msg' => $note,
      ]);



    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;


    $eventName = "Sample Rejected or Modify";
    $eventINFO = 'Sample ID:' . $request->sampleIDA . " and Rejected or modify  by" . $LoggedName . "MSG-" . $note;
    $eventID = $request->sampleIDA;
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



    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }
  //saveSampleRejectModify
  //public
  public function saveSampleAssinged(Request $request)
  {

    Sample::where('id', $request->sampleIDA)
      ->update([
        'assingned_to' => $request->chemistID,
        'assingned_by' => Auth::user()->id,
        'assingned_name' => AyraHelp::getUser($request->chemistID)->name,
        'assingned_on' => date('Y-m-d H:i:s'),
        'assingned_notes' => $request->txtSampleAssinedRemark,
      ]);



    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $AssineTo = AyraHelp::getUser($request->chemistID)->name;

    $eventName = "Sample Assigned";
    $eventINFO = 'Sample ID:' . $request->sampleIDA . " and Re-Assined to  " . $AssineTo . " by" . $LoggedName;
    $eventID = $request->sampleIDA;
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



    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }


  //savePaymentRemovewithReasonDeduction
  public function savePaymentRemovewithReasonDeduction(Request $request)
  {
    //print_r($request->all());
    $amountTobeDeduct = $request->amountTobeDeduct;
    $ori_order_amt = $request->ori_order_amt;
    $in_user_id = $request->in_user_id;
    $in_user_month = $request->in_user_month;
    $in_user_year = $request->in_user_year;
    $feedback_option = $request->feedback_option;
    $feedback_other = $request->feedback_other;

    DB::table('incentive_applied_deduction')
      ->updateOrInsert(
        [
          'user_id' => $in_user_id,
          'in_month' => $in_user_month,
          'in_year' => $in_user_year
        ],
        [
          'user_id' => $in_user_id,
          'in_month' => $in_user_month,
          'in_year' => $in_user_year,
          'created_at' => date('Y-m-d H:i:s'),
          'created_by' => Auth::user()->id,
          'with_reason' => $feedback_other,
          'option_id' => $feedback_option,
          'status' => 1,
          'ori_order_amt' => $ori_order_amt,
          'amt_to_be_deduct' => $amountTobeDeduct,
        ]
      );

    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }
  //savePaymentRemovewithReasonDeduction

  //savePaymentRemovewithReason

  public function savePaymentRemovewithReason(Request $request)
  {



    $affected = DB::table('payment_recieved_from_client')
      ->where('id', $request->payIDDone)
      ->update([
        'is_rejected' => 1,
        'rejected_by' => Auth::user()->id,
        'rejected_reason' => $request->feedback_other,
        'rejected_at' => date('Y-m-d H:i:s'),
        'rejected_status' => $request->feedback_option,
      ]);


    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }

  //savePaymentRemovewithReason

  public function saveFeedback(Request $request)
  {
    Sample::where('id', $request->s_id)
      ->update([
        'sample_feedback' => $request->feedback_option,
        'sample_feedback_other' => $request->feedback_other,
        'feedback_addedon' => date('Y-m-d H:i:s')
      ]);
    $data = array(
      'status' => '1',
      'message' => 'Saved successfully',
    );
    return response()->json($data);
  }
  //add sample by id
  public function sampleNew(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    return $theme->scope('sample.new_sample', $data)->render();
  }

  public function addSamplebyID($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $client_arr = Client::where('id', $id)->first();

    $data = [
      'client_data' => $client_arr,
      'sample_id' => $max_id
    ];
    return $theme->scope('sample.create_add', $data)->render();
  }

  //add sample by id

  public function print_all()
  {

    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Sampler' ||  $user_role == 'CourierTrk') {
      $sample_arr = Sample::where('status', 1)->get();
    } else {
      if ($user_role == 'SalesUser') {
        $sample_arr = Sample::where('status', 1)->where('created_by', Auth::user()->id)->get();
      } else {
        $sample_arr = DB::table('samples')
          ->join('users_access', function ($join) {
            $join->on('samples.client_id', '=', 'users_access.client_id');
            $join->on('users_access.access_by', '=', 'samples.created_by');
          })
          ->select('samples.*')
          ->orderBy('samples.id', 'DESC')
          ->orwhere('users_access.access_to', Auth::user()->id)
          ->where('samples.status', 1)
          ->get();
      }
    }
    foreach ($sample_arr as $key => $value) {

      $users = Client::where('id', $value->client_id)->first();

      $client_data = AyraHelp::getClientbyid($value->client_id);
      if ($value->created_at != null) {
        $sample_created = date("d,F Y", strtotime($value->created_at));
      } else {
        $sample_created = '';
      }


      $sample_data[] = array(
        'sample_code' => $value->sample_code,
        'client_name' => isset($client_data->firstname) ? $client_data->firstname : "",
        'client_phone' => optional($users)->phone,
        'client_address' => optional($value)->ship_address,
        'client_company' => optional($users)->company,
        'sample_created' => $sample_created,
        'sample_remarks' => optional($value)->remarks,
        'sample_details' => json_decode(optional($value)->sample_details),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,
        'admin_status' => $value->admin_urgent_status,
      );
    }

    $data = [
      'users' => '$users',
      'sample_id' => $max_id,
      'sample_data' => $sample_data
    ];
    return $theme->scope('sample.print', $data)->render();
  }



  //getIncentiveAppliedUsed
  public function getIncentiveAppliedUsed(Request $request)
  {

    $clients_arr = User::where('is_deleted', 0)->where('is_incentive_active', 1)->whereNotNull('mac_address')->whereHas("roles", function ($q) {
      $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead")->orwhere("name", "Staff")->orwhere("name", "User");
    })->get();


    $data = array(
      'data' => $clients_arr,
      'message' => 'list of incetive ussers',
    );
    return response()->json($data);
  }
  //getIncentiveAppliedUsed
  //getIncentiveAppliedUsedRND


  //getIncentiveAppliedUsedRND

  //ticketForm
  public function getIncentiveAppliedUsedRND(Request $request)
  {

    $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
      $q->where("name", "chemist");
    })->get();


    $data = array(
      'data' => $clients_arr,
      'message' => 'list of incetive ussers',
    );
    return response()->json($data);
  }

  //ticketForm


  //printRNDFormulationViewBase
  public function printRNDFormulationViewBase($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $formData = DB::table('base_bo_formuation')
      ->where('id', $id)
      ->first();

    $formDataOri = DB::table('bo_formuation')
      ->where('id', $formData->fm_id)
      ->first();
    $formDataData = DB::table('base_bo_formuation_child')
      ->where('fm_base_id', $id)
      ->sum('dos_percentage');

    $data = [
      'data' => $formDataOri,
      'batchSize' => $formDataData,

    ];
    return $theme->scope('sample.printRNDFormulaBase', $data)->render();
  }

  //printRNDFormulationViewBase
  //printRNDFormulationBase
  public function printRNDFormulationBase($id, $batchsize)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $formData = DB::table('bo_formuation_v1')
      ->where('id', $id)
      ->first();
    

    $data = [
      'data' => $formData,
      'batchSize' => $batchsize,

    ];
    return $theme->scope('sample.printRNDFormulaBase', $data)->render();
  }
  //printRNDFormulationBase


  //printRNDFormulation
  public function printRNDFormulation($id, $batchsize)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $formData = DB::table('bo_formuation')
      ->where('id', $id)
      ->first();
    $data = [
      'data' => $formData,
      'batchSize' => $batchsize,

    ];
    return $theme->scope('sample.printRNDFormula', $data)->render();
  }
  //printRNDFormulation


  public function print($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $sample_arr = Sample::where('id', $id)->get();
    } else {
      $sample_arr = Sample::where('id', $id)->where('created_by', Auth::user()->id)->get();
    }
    $sample_data = array();
    foreach ($sample_arr as $key => $value) {
      $users = Client::where('id', $value->client_id)->first();

      $sample_data[] = array(
        'sample_code' => $value->sample_code,
        'client_name' => AyraHelp::getClientbyid($value->client_id)->firstname,
        'client_phone' => $users->phone,
        'client_address' => $value->ship_address,
        'client_company' => $users->company,
        'sample_details' => json_decode($value->sample_details),
      );
    }

    $data = [
      'users' => '$users',
      'sample_id' => $max_id,
      'sample_data' => $sample_data
    ];
    return $theme->scope('sample.print', $data)->render();
  }
  public function getPrintSampleListOwn($id)
  {
    $sample_arr = Sample::where('created_by', $id)->get();
    $HTML = '';
    foreach ($sample_arr as $key => $value) {
      $users = User::find($value->client_name);
      $HTML .= '<table class="table">
        <tbody>
          <tr>
            <th>ID</th>
            <td>' . $value->sample_id . '</td>
            <th>Name</th>
            <td>' . $users->name . '</td>
            <th>Phone</th>
            <td width="150">' . $users->phone . '</td>
          </tr>
          <tr>
            <th>Details</th>
            <td colspan="5">
              ' . $value->sample_details . '
            </td>
          </tr>
          <tr>
            <th>Address</th>
            <td colspan="5"> ' . $value->ship_address . '</td>
          </tr>

        </tbody>
      </table><hr>';
    }

    echo $HTML;
  }

  public function getPrintSampleList(Request $request)
  {
    $sample_arr = Sample::get();
    $HTML = '';
    foreach ($sample_arr as $key => $value) {
      $users = User::find($value->client_name);
      $HTML .= '<table class="table">
          <tbody>
            <tr>
              <th>ID</th>
              <td>' . $value->sample_id . '</td>
              <th>Name</th>
              <td>' . $users->name . '</td>
              <th>Phone</th>
              <td width="150">' . $users->phone . '</td>
            </tr>
            <tr>
              <th>Details</th>
              <td colspan="5">
                ' . $value->sample_details . '
              </td>
            </tr>
            <tr>
              <th>Address</th>
              <td colspan="5"> ' . $value->ship_address . '</td>
            </tr>

          </tbody>
        </table><hr>';
    }

    echo $HTML;
  }
  public function softdeleteClient(Request $request)
  {
    $userid = $request->userId;
    User::where('id', $userid)
      ->update(['is_deleted' => 1]);
    $data = array(
      'status' => '1',
      'message' => 'Sent for Deleted Deleted successfully',
    );
    return response()->json($data);
  }

  public function deleteClient(Request $request)
  {
    $userid = $request->userId;
    $users = User::find($userid);
    $users->delete();
    $res = Company::where('user_id', $userid)->delete();
    $data = array(
      'status' => '1',
      'message' => 'Deleted successfully',
    );
    return response()->json($data);
  }
  public function clients_edit(Request $request)
  {
    $user_id = $request->user_id;
    if ($request->email == "") {
      $no_email = 'NoEmail_' . date('ymdHis') . '@boitel.xyzz';
      User::where('id', $user_id)
        ->update([
          'name' => $request->name,
          'email' => $no_email,
          'phone' => $request->phone
        ]);
      Company::where('user_id', $user_id)
        ->update([
          'company_name' => $request->company,
          'brand_name' => $request->brnad_name,
          'gst_details' => $request->gst,
          'address' => $request->address,
          'remarks' => $request->remarks
        ]);
    } else {

      User::where('id', $user_id)
        ->update([
          'name' => $request->name,
          'email' => $request->email,
          'phone' => $request->phone
        ]);
      Company::where('user_id', $user_id)
        ->update([
          'company_name' => $request->company,
          'brand_name' => $request->brnad_name,
          'gst_details' => $request->gst,
          'address' => $request->address,
          'remarks' => $request->remarks
        ]);
    }

    $data = array(
      'status' => '1',
      'message' => 'Updated successfully',
    );
    return response()->json($data);
  }
  public function deleteSample(Request $request)
  {

    $sample = Sample::find($request->s_id);

    if ($sample->status != 1) {
      $data = array(
        'status' => '0',
        'message' => 'Could not delete',
      );
    } else {
      //$sample->delete();
      $flight = Sample::find($request->s_id);
      $flight->is_deleted = 1;
      $flight->save();

      $flightA = SampleItem::where('sid', $request->s_id)->first();
      $flightA->is_deleted = 1;
      $flightA->save();

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;


      $eventName = "Sample DELETE";
      $eventINFO = 'Sample ID :' . $request->s_id . " and deleted by  " . $LoggedName;
      $eventID = $request->s_id;
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


      $data = array(
        'status' => '1',
        'message' => 'Deleted A successfully',
      );
    }

    return response()->json($data);
  }

  public function samples_edit_info(Request $request)
  {
    $sent_datev = date("Y-m-d", strtotime($request->sent_on));
    Sample::where('id', $request->s_id)
      ->update([
        'client_name' => $request->client_name,
        'sample_details' => $request->sample_details,
        'courier_details' => $request->courier_name,
        'track_id' => $request->track_id,
        'sample_sent_on' => $sent_datev,
        'status' => $request->status,
        'remarks' => $request->remarks,
        'ship_address' => $request->client_address,

      ]);
    Company::where('user_id', $request->client_name)
      ->update([
        'address' => $request->client_address
      ]);

    $data = array(
      'status' => '1',
      'message' => 'Data updated successfully'
    );

    return response()->json($data);
  }
  public function samples_edit(Request $request)
  {
    Sample::where('id', $request->s_id)
      ->update([
        'client_name' => $request->client_name,
        'sample_details' => $request->sample_details,
        'courier_details' => $request->courier_name,
        'track_id' => $request->track_id,
        //'status' => $request->status,
        'remarks' => $request->remarks,
        'ship_address' => $request->client_address,

      ]);
    Company::where('user_id', $request->client_name)
      ->update([
        'address' => $request->client_address
      ]);

    $data = array(
      'status' => '1',
      'message' => 'Data updated successfully'
    );

    return response()->json($data);
  }

  public function saveSampleCourier(Request $request)
  {
    $sent_date = $request->sent_date;
    $sent_datev = date("Y-m-d", strtotime($sent_date));


    $sample_arr = Sample::where('id', $request->s_id)->first();
    Sample::where('id', $request->s_id)
      ->update([
        'courier_id' => $request->courier_id,
        'track_id' => $request->track_id,
        'status' => $request->sample_status,
        'courier_remarks' => $request->remarks,
        'sent_on' => $sent_datev,
        'track_updatedby' => 1,
        'track_updatedon' => date('Y-m-d H:i:s'),
      ]);

    //pusher
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

    $eventID = 'AJ_ID' . $sample_arr->created_by;

    $data['message'] = 'Sample code: ' . $sample_arr->sample_code . "<br>Courier details have been added, Please check.";


    $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
    //puhser


    $data = array(
      'status' => '1',
      'message' => 'Data saved successfully'
    );
    return response()->json($data);
  }


  public function getClientsListforDelete(Request $request)
  {
    $users_arr = User::where('is_deleted', '!=', 0)->whereHas("roles", function ($q) {
      $q->where("name", "Client");
    })->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $use_name = AyraHelp::getUserName($value->id);
      $sale_agent = AyraHelp::getUserName($value->created_by);
      $data_arr[] = array(
        'id' => $i,
        'rowid' => $value->id,
        'client_name' => $use_name,
        'email' => $value->email,
        'staff_name' => $sale_agent,
        'status' => $value->status
      );
    }

    $resp_jon = json_encode($data_arr);
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

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
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

  public function getClientDetails(Request $request)
  {
    $User_arr = User::where('id', $request->recordID)->first();
    $client_arr = Company::where('user_id', $request->recordID)->first();
    $ContactClient_arr = ContactClient::where('parent_userid', $request->recordID)->get();


    //ajemail
    $email = $User_arr->email;
    if (strpos($email, 'NoEmail_') !== false) {
      $email_ = '';
    } else {
      $email_ = $email;
    }

    $client_data = array(
      'name' => isset($User_arr->name) ? $User_arr->name : '',
      'user_id' => $User_arr->id,
      'email' => isset($email_) ? $email_ : '',
      'phone' => isset($User_arr->phone) ? $User_arr->phone : '',
      'company' => isset($client_arr->company_name) ? $client_arr->company_name : '',
      'address' => isset($client_arr->address) ? $client_arr->address : '',
      'gst_details' => isset($client_arr->gst_details) ? $client_arr->gst_details : '',
      'brand_name' => isset($client_arr->brand_name) ? $client_arr->brand_name : '',
      'remarks' => isset($client_arr->remarks) ? $client_arr->remarks : '',
    );
    $client_contact_data = array(
      'name' => isset($ContactClient_arr->name) ? $ContactClient_arr->name : '',
      'user_id' => $User_arr->id,
      'email' => isset($ContactClient_arr->email) ? $ContactClient_arr->email : '',
      'phone' => isset($ContactClient_arr->phone) ? $ContactClient_arr->phone : '',

    );

    $data = array(
      'client_data' => $client_data,
      'agent_data' => $client_data,
      'sample_details' => $client_data,
      'client_contact' => json_encode($ContactClient_arr),

    );
    return response()->json($data);
  }

  public function getSampleDetails(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $edit_pe = "";
    if ($user_role == 'Admin') {
      $edit_pe = 1;
    }
    if ($user_role == 'Staff' || $user->hasPermissionTo('view-sample')) {
      $edit_pe = 1;
    }
    if ($user_role == 'SalesUser') {
      $edit_pe = 0;
    }

    $edit_pe = 1;
    $sample_arr = Sample::where('id', $request->recordID)->first();
    //print_r($sample_arr);
    if ($sample_arr->sample_from == 1) {

      $dataCLIENT = DB::table('indmt_data')
        ->where('indmt_data.QUERY_ID', '=', $sample_arr->QUERY_ID)
        ->first();


      $name = isset($dataCLIENT->SENDERNAME) ? $dataCLIENT->SENDERNAME : '';
      $company = isset($dataCLIENT->GLUSR_USR_COMPANYNAME) ? $dataCLIENT->GLUSR_USR_COMPANYNAME : '';
      $cid = $dataCLIENT->QUERY_ID;
      $first_name = $dataCLIENT->SENDERNAME;
      $email = isset($dataCLIENT->SENDEREMAIL) ? $dataCLIENT->SENDEREMAIL : '';
      $phone = isset($dataCLIENT->MOB) ? $dataCLIENT->MOB : '';
    } else {
      $client_id = $sample_arr->client_id;
      $client_arr = Client::where('id', $client_id)->first();

      $name = isset($client_arr->name) ? $client_arr->name : '';
      $company = isset($client_arr->company) ? $client_arr->company : '';
      $cid = $client_arr->id;
      $first_name = $client_arr->firstname;
      $email = isset($client_arr->email) ? $client_arr->email : '';
      $phone = isset($client_arr->phone) ? $client_arr->phone : '';
    }


    $sales_agentid = $sample_arr->created_by;




    $agent_arr = User::where('id', $sales_agentid)->first();


    $client_data = array(
      'name' => $name,
      'sample_code' => isset($sample_arr->sample_code) ? $sample_arr->sample_code : '',
      'company' => $company,
      'user_id' => 43,
      's_id' => $sample_arr->id,
      'edit_pe' => $edit_pe,
      'contact_name' => $first_name,
      'email' => $email,
      'phone' => $phone,
      'status' => isset($sample_arr->status) ? $sample_arr->status : 1,
      'location' => isset($sample_arr->location) ? $sample_arr->location : '',
      'address' => isset($sample_arr->ship_address) ? $sample_arr->ship_address : '',
      'gst_details' => isset($client_comp_arr->gst_details) ? $client_comp_arr->gst_details : '',
      'brand_name' => isset($client_comp_arr->brand_name) ? $client_comp_arr->brand_name : '',
      'remarks' => isset($client_comp_arr->remarks) ? $client_comp_arr->remarks : '',
      'sent_on' => isset($sample_arr->sent_on) ?  date("d-M-Y", strtotime($sample_arr->sent_on)) : '',
    );
    $agent_data = array(
      'name' => $agent_arr->name,
      'email' => $agent_arr->email,
      'phone' => $agent_arr->phone,

    );
    switch ($sample_arr->status) {
      case '1':
        $status_HTML = '<span style="width: 100px;"><span class="m-badge  m-badge--primary m-badge--wide">NEW</span></span>';

        break;
      case '2':
        $status_HTML = '<span style="width: 100px;"><span class="m-badge  m-badge--info m-badge--wide">SENT</span></span>';

        break;
      case '3':
        $status_HTML = '<span style="width: 100px;"><span class="m-badge  m-badge--success m-badge--wide">RECIEVED</span></span>';

        break;
      case '4':
        $status_HTML = '<span style="width: 100px;"><span class="m-badge  m-badge--warnnig m-badge--wide">FEEDBACK</span></span>';
        break;
    }

    if (empty($sample_arr->courier_details)) {
      $courier_details = "";
    } else {
      $courier_details = AyraHelp::getCouriers($sample_arr->courier_details)->courier_name . " | " . AyraHelp::getCouriers($sample_arr->courier_details)->courier_address;
    }




    $cour_arr = AyraHelp::getCouriers($sample_arr->courier_id);
    $c_name = isset($cour_arr->courier_name) ? $cour_arr->courier_name : '';




    $sample_data = array(
      'sid_code' => $sample_arr->sid_code,
      'sample_id' => $sample_arr->sample_id,
      'sample_details' => $sample_arr->sample_details,
      'courier_details' => $courier_details,
      'courier_id' => $sample_arr->courier_id,
      'courier_name' => $c_name,
      'track_id' => $sample_arr->track_id,
      'created_at' => date('d,F Y', strtotime($sample_arr->created_at->toDateString())),
      'status' => $status_HTML,
      'status_id' => $sample_arr->status,
      'created_by' => AyraHelp::getUserName($sample_arr->created_by),
      'remarks' => $sample_arr->remarks,
      'courier_remarks' => $sample_arr->courier_remarks,
      'feedback' => $sample_arr->feedback,
      'is_rejected' => $sample_arr->is_rejected,
      'is_rejected_msg' => $sample_arr->is_rejected_msg,
      'is_paid' => $sample_arr->is_paid,

    );

    $data = array(
      'client_data' => $client_data,
      'agent_data' => $agent_data,
      'sample_details' => $sample_data,
    );
    return response()->json($data);
  }
  public function getClientAddress(Request $request)
  {
    $cid = $request->cid;
    $comp_arr = Client::where('id', $cid)->first();
    $data = array(
      'address' => $comp_arr->address,
      'location' => $comp_arr->location
    );
    return response()->json($data);
  }
  public function getClientBrandName(Request $request)
  {
    $cid = $request->cid;
    $comp_arr = Client::where('id', $cid)->first();
    $gstno = $comp_arr->gstno;
    $address = $comp_arr->address;



    if (strlen($gstno) < 15) {

      $resp = array(
        'status' => 1,
        'gst' => $gstno,
        'address' => $address,
      );
      return response()->json($resp);
    } else {
      if ($address == NULL) {
        $resp = array(
          'status' => 1,
          'gst' => $gstno,
          'address' => $address,
        );
        return response()->json($resp);
      } else {
        if (empty($comp_arr->brand)) {

          $resp = array(
            'status' => 0,
            'comp' => $comp_arr->company,

          );
          return response()->json($resp);
        } else {

          $resp = array(
            'status' => 0,
            'comp' => $comp_arr->brand,

          );
          return response()->json($resp);
        }
      }
    }
  }
  //saveFAQAnwers
  public function saveFAQAnwers(Request $request)
  {
    $txtfaqID = $request->txtfaqID;
    $txtFAQAnswer = $request->txtFAQAnswer;

    DB::table('samples_faq_answered')->insert([
      'q_id' => $txtfaqID,
      'answes' => $txtFAQAnswer,
      'is_deleted' => 0,
      'created_by' => Auth::user()->id,
      'created_at' => date('Y-m-d H:i:s')
    ]);

    $affected = DB::table('samples_faq')
      ->where('id', $txtfaqID)
      ->update(['is_answered' => 1]);

    $res_arr = array(
      'status' => 1
    );

    return response()->json($res_arr);
  }
  //saveFAQAnwers

  //saveFAQ
  public function saveFAQ(Request $request)
  {
    //  print_r($request->all());
    $txtContentFAQ = $request->txtContentFAQ;
    $txtProductNameFAQ = $request->txtProductNameFAQ;
    $posts = DB::table('samples_faq')
      ->where('posts', $txtContentFAQ)
      ->first();
    if ($posts == null) {

      DB::table('samples_faq')->insert([
        'posts' => $txtContentFAQ,
        'product_name' => $txtProductNameFAQ,
        'is_deleted' => 0,
        'created_by' => Auth::user()->id,
        'is_answered' => 0,
        'is_read' => 0,
        'category' => 0,
        'created_at' => date('Y-m-d H:i:s')
      ]);
      $res_arr = array(
        'status' => 1
      );
    } else {
      $res_arr = array(
        'status' => 0
      );
    }

    return response()->json($res_arr);
  }
  //saveFAQ
  //FAQAboutIngredentList
  public function FAQAboutIngredentList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      return $theme->scope('sample.faqAboutIngredentList', $data)->render();
    } else {
      return $theme->scope('sample.faqAboutIngredentList', $data)->render();
    }
  }

  //FAQAboutIngredentList
  // FAQAboutIngredent
  public function FAQAboutIngredent()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      return $theme->scope('sample.faqAboutIngredent', $data)->render();
    } else {
      return $theme->scope('sample.faqAboutIngredent', $data)->render();
    }
  }

  //FAQAboutIngredent

  //samplePendingAprrovalList
  public function samplePendingAprrovalList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      return $theme->scope('sample.sampleListForApproval', $data)->render();
    } else {
      abort(401);
    }
  }

  //samplePendingAprrovalList
  // ordertechnicalList
  public function ordertechnicalList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead' || Auth::user()->id == 124 || Auth::user()->id == 172 || Auth::user()->id == 146 || Auth::user()->id == 89 || Auth::user()->id == 189) {
      return $theme->scope('sample.orderList_technical_document', $data)->render();
    } else {
      abort(401);
    }
  }

  // ordertechnicalList

  //sampletechnicalList
  public function sampletechnicalList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead' || Auth::user()->id == 124 || Auth::user()->id == 172 || Auth::user()->id == 146 || Auth::user()->id == 89 || Auth::user()->id == 189) {
      return $theme->scope('sample.sampleList_technical_document', $data)->render();
    } else {
      abort(401);
    }
  }

  //sampletechnicalList
  //getProductFAQ
  public function getProductFAQ(Request $request)
  {

    $users_arr = DB::table('samples_faq')->get();




    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_at = date('j F Y', strtotime($value->created_at));
      $product_name = optional($value)->product_name;
      $is_answered = optional($value)->is_answered;
      $posts = optional($value)->posts;

      $anscount = DB::table('samples_faq_answered')
        ->where('q_id', $value->id)
        ->count();
      if ($anscount > 0) {
        $anscountVal = '<span class="m-badge m-badge--success">' . $anscount . '</span>';
      } else {
        $anscountVal = '<span class="m-badge m-badge--danger">0</span>';
      }




      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'created_at' => $created_at,
        'posts' => $posts,
        'product_name' => $product_name,
        'created_by' => $created_by,
        'anscount' => $anscountVal,
        'is_answered' => $is_answered
      );
    }






    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'created_at'      => true,
      'posts'      => true,
      'product_name'      => true,
      'created_by'      => true,
      'anscount'      => true,
      'is_answered'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getProductFAQ
  //getordersListTechnicaldata
  public function getordersListTechnicaldata(Request $request)
  {
    $action_status = $request->action_status;
    $data_arr = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $users_arrData = array();

    if ($user_role == 'SalesHead' || $user_role == 'Admin' || Auth::user()->id == 124 || Auth::user()->id == 172 || Auth::user()->id == 146 ||  Auth::user()->id == 89 || Auth::user()->id == 189) {
      switch ($action_status) {
        case 1:

          $users_arrData = DB::table('order_tech_list')
            ->where('is_deleted', 0)
            ->whereNull('is_done')
            ->get();
          break;
        case 2:
          $users_arrData = DB::table('order_tech_list')
            ->where('is_deleted', 0)
            ->whereNotNull('is_done')
            ->get();
          break;
        case 3:
          $users_arrData = DB::table('order_tech_list')
            ->where('is_deleted', 0)
            ->get();
          break;
        default:
          $users_arrData = DB::table('order_tech_list')
            ->where('is_deleted', 0)
            ->whereNull('is_done')
            ->get();
      }
    } else {

      switch ($action_status) {
        case 1:

          $users_arrData = DB::table('order_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            ->whereNull('is_done')
            ->get();
          break;
        case 2:
          $users_arrData = DB::table('order_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            ->whereNotNull('is_done')
            ->get();
          break;
        case 3:
          $users_arrData = DB::table('order_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            ->get();
          break;
        default:
          $users_arrData = DB::table('order_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            // ->whereNull('is_done')
            ->get();
      }

      //$data_arr = array();

    }



    $i = 0;
    foreach ($users_arrData as $key => $value) {
      $i++;
      $qcDatA = DB::table('qc_forms')->where('form_id', $value->form_id)->first();
      // echo "<pre>";
      // print_r($qcDatA);
      // die;


      $img_photo = asset('local/public/uploads/photos') . "/" . optional($value)->doc_name;
      if (is_null($value->doc_name) || empty($value->doc_name)) {
        $imgStatus = 0;
      } else {
        $imgStatus = 1;
      }
      if ($value->item_requirement == 1) {
        if (isset($value->ingredent_data)) {
          $status = 1;
        } else {
          $status = 0;
        }
      } else {
        if ($imgStatus == 1) {
          $status = 1;
        } else {
          $status = 0;
        }
      }

      if ($status == 0) {
        $strAJ = "Pending";
      } else {
        $strAJ = "Completed";
        $affected = DB::table('order_tech_list')
          ->where('id', $value->id)
          ->whereNull('is_done')
          ->update(['is_done' => 1]);
      }
      //update is_done
      // $affected = DB::table('samples_tech_list')
      //         ->where('id', $value->id)
      //         ->whereNull('is_done')
      //         ->update(['is_done' => 1]);

      //update is_done
      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => $qcDatA->order_id . '-' . $qcDatA->subOrder,
        'form_id' => $value->form_id,
        'item_name' => $value->item_name,
        's_created_at' => date('j M Y', strtotime($value->s_created_at)),
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $value->created_name,
        'item_requirement' => $value->item_requirement,
        'doc_name' => $img_photo,
        'imgStatus' => $imgStatus,
        'status_data' => $strAJ,
        // 'sample_created_by' => @AyraHelp::getUser($sampleDataV->assingned_to)->name,
        'sample_created_by' => '',

      );
    }



    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'item_name'      => true,
      's_created_at'      => true,
      'created_on'      => true,
      'created_by'      => true,
      'item_requirement'     => true,
      'doc_name'     => true,
      'imgStatus'     => true,
      'status_data'     => true,
      'sample_created_by'     => true,
      'ingredent_data'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getordersListTechnicaldata

  //getSampleListbyCatType
  public function mapRNDSampleList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = ['users' => ''];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead' || Auth::user()->id == 124) {
      return $theme->scope('sample.AddTechnicalDocumentOrder', $data)->render();
    } else {
      abort(401);
    }
  }
  //getSampleListbyCatType

  //getSamplesListTechnicaldata
  public function getSamplesListTechnicaldata(Request $request)
  {
    $action_status = $request->action_status;
    $data_arr = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $users_arrData = array();

    if ($user_role == 'SalesHead' || $user_role == 'Admin' || Auth::user()->id == 124 || Auth::user()->id == 172 || Auth::user()->id == 146 ||  Auth::user()->id == 89 || Auth::user()->id == 189) {
      switch ($action_status) {
        case 1:
          if (Auth::user()->id == 1) {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNull('is_done')
              // ->where('id','>',3670)
              ->get();
          } else {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNull('is_done')
              ->where('id', '>', 3670)
              ->get();
          }


          break;
        case 2:
          if (Auth::user()->id == 1) {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNotNull('is_done')
              // ->where('id','>',3670)
              ->get();
          } else {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNotNull('is_done')
              ->where('id', '>', 3670)
              ->get();
          }

          break;
        case 3:
          if (Auth::user()->id == 1) {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              // ->where('id','>',3670)
              ->get();
          } else {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->where('id', '>', 3670)
              ->get();
          }

          break;
        default:
          if (Auth::user()->id == 1) {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNull('is_done')
              // ->where('id','>',3670)
              ->get();
          } else {
            $users_arrData = DB::table('samples_tech_list')
              ->where('is_deleted', 0)
              ->whereNull('is_done')
              ->where('id', '>', 3670)
              ->get();
          }
      }
    } else {

      switch ($action_status) {
        case 1:

          $users_arrData = DB::table('samples_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            ->whereNull('is_done')
            // ->where('id','>',3670)
            ->get();
          break;
        case 2:
          $users_arrData = DB::table('samples_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            ->whereNotNull('is_done')
            // ->where('id','>',3670)
            ->get();
          break;
        case 3:
          $users_arrData = DB::table('samples_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            // ->where('id','>',3670)
            ->get();
          break;
        default:
          $users_arrData = DB::table('samples_tech_list')->where('created_by', Auth::user()->id)
            ->where('is_deleted', 0)
            // ->whereNull('is_done')
            // ->where('id','>',3670)
            ->get();
      }

      //$data_arr = array();

    }



    $i = 0;
    foreach ($users_arrData as $key => $value) {
      $i++;
      $sampleDataV = DB::table('samples')->where('sample_index', $value->sample_id)->first();
      //       echo "<pre>";
      // print_r($sampleDataV);
      // die;


      $img_photo = asset('local/public/uploads/photos') . "/" . optional($value)->doc_name;
      if (is_null($value->doc_name) || empty($value->doc_name)) {
        $imgStatus = 0;
      } else {
        $imgStatus = 1;
      }
      if ($value->item_requirement == 1) {
        if (isset($value->ingredent_data)) {
          $status = 1;
        } else {
          $status = 0;
        }
      } else {
        if ($imgStatus == 1) {
          $status = 1;
        } else {
          $status = 0;
        }
      }

      if ($status == 0) {
        $strAJ = "Pending";
      } else {
        $strAJ = "Completed";
        $affected = DB::table('samples_tech_list')
          ->where('id', $value->id)
          ->whereNull('is_done')
          ->update(['is_done' => 1]);
      }
      //update is_done
      // $affected = DB::table('samples_tech_list')
      //         ->where('id', $value->id)
      //         ->whereNull('is_done')
      //         ->update(['is_done' => 1]);

      //update is_done
      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'item_name' => $value->item_name,
        's_created_at' => date('j M Y', strtotime($value->s_created_at)),
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $value->created_name,
        'item_requirement' => $value->item_requirement,
        'doc_name' => $img_photo,
        'imgStatus' => $imgStatus,
        'status_data' => $strAJ,
        // 'sample_created_by' => @AyraHelp::getUser($sampleDataV->assingned_to)->name,
        'sample_created_by' => '',
        'ingredent_data' => $value->ingredent_data,
      );
    }



    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'item_name'      => true,
      's_created_at'      => true,
      'created_on'      => true,
      'created_by'      => true,
      'item_requirement'     => true,
      'doc_name'     => true,
      'imgStatus'     => true,
      'status_data'     => true,
      'sample_created_by'     => true,
      'ingredent_data'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesListTechnicaldata

  //saveSampleTechDoc
  public function saveSampleTechDocA(Request $request)
  {
    $sample_by_part_id_Arr = $request->sample_by_part_id;
    $sample_by_part_idN_Arr = $request->sample_by_part_idN;
    $sampleTechRequirement = $request->sampleTechRequirement;
    // echo "<pre>";
    // print_r($sampleTechRequirement);
    // print_r($sample_by_part_id_Arr);
    // print_r($sample_by_part_idN_Arr);
    $sampleData = DB::table('samples')
      ->where('sample_index', $request->sample_id)
      ->first();


    foreach ($sample_by_part_id_Arr as $key => $rowData) {
      $dataArr = explode("@@", $rowData);


      DB::table('samples_tech_list')
        ->insert(

          [
            'sample_id' => $request->sample_id,
            'sample_code' => $dataArr[0],
            'item_name' => $dataArr[1],
            's_created_at' => $sampleData->created_at,
            'item_requirement' => 1,
            'created_by' => Auth::user()->id,
            'created_name' => Auth::user()->name,
            'created_at' => date('Y-m-d H:i:s'),
            'notes' => $request->sampletechRemarks,
            'client_id' => $sampleData->client_id
          ]
        );
    }

    $res_arr = array(
      'data' => 1
    );
    return response()->json($res_arr);
  }
  //saveOrderTechDoc
  public function get_string_between($string, $start, $end)
  {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
  }

  public function saveOrderTechDoc(Request $request)
  {

    $this->validate($request, [
      'order_by_part_id' => 'required'
    ]);


    // echo "<pre>";
    // print_r($request->all());
    $order_by_part_idArr = $request->order_by_part_id;
    $form_id = $request->form_id;
    $qc_data = AyraHelp::getQCFormDate($form_id);

    $ordertechRemarks = $request->ordertechRemarks;
    foreach ($order_by_part_idArr as $key => $rowData) {

      $parsedReqId = $this->get_string_between($rowData, '-@@-', '-XX-');
      $parsedArr = explode("-@@-", $rowData);
      $parsedArrOID = explode("-XX-", $rowData);
      $parsedOrderName = $parsedArr[0];
      $ordetTypeId = $parsedArrOID[1];
      $parsedReqId;
      foreach ($request->orderTechRequirement as $key => $rowIndex) {
        switch ($rowIndex) {
          case 1:
            DB::table('order_tech_list')
              ->insert(
                [
                  'form_id' => $form_id,
                  'order_id' => $qc_data->order_id . '-' . $qc_data->subOrder,
                  'item_name' => $parsedOrderName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 1,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => $ordertechRemarks,
                  'client_id' => ''
                ]
              );
            break;
          case 2:
            DB::table('order_tech_list')
              ->insert(
                [
                  'form_id' => $form_id,
                  'order_id' => $qc_data->order_id . '-' . $qc_data->subOrder,
                  'item_name' => $parsedOrderName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 2,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => $ordertechRemarks,
                  'client_id' => ''
                ]
              );
            break;
          case 3:
            DB::table('order_tech_list')
              ->insert(
                [
                  'form_id' => $form_id,
                  'order_id' => $qc_data->order_id . '-' . $qc_data->subOrder,
                  'item_name' => $parsedOrderName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 3,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => $ordertechRemarks,
                  'client_id' => ''
                ]
              );
            break;
        }
      }
    }


    //order_tech_list
    //order_tech_list
    $res_arr = array(
      'data' => 1
    );
    return response()->json($res_arr);
  }
  //saveOrderTechDoc

  public function saveSampleTechDoc(Request $request)
  {
    //print_r($request->all());
    $this->validate($request, [
      'sample_by_part_id' => 'required',

    ]);

    //text box
    $maxID = DB::table('samples_tech_list')->max('id');


    if ($request->sample_id == 9999999) {
      $itemName = $request->sample_by_part_id;



      //fors
      foreach ($request->sampleTechRequirement as $key => $rowIndex) {

        switch ($rowIndex) {
          case 1:

            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $maxID,
                  'sample_code' => Auth::user()->user_prefix . "-R" . $maxID,
                  'item_name' => $itemName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 1,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );


            break;
          case 2:
            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $maxID,
                  'sample_code' => Auth::user()->user_prefix . "-R" . $maxID,
                  'item_name' => $itemName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 2,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );
            break;
          case 3:
            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $maxID,
                  'sample_code' => Auth::user()->user_prefix . "-R" . $maxID,
                  'item_name' => $itemName,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 3,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );
            break;
        }
      }

      //fors
      $res_arr = array(
        'data' => 1
      );
      return response()->json($res_arr);
    }

    //text box
    $sample_by_part_id_Arr = $request->sample_by_part_id;

    $sampleData = DB::table('samples')
      ->where('sample_code', $request->sample_id)
      ->first();


    foreach ($request->sampleTechRequirement as $key => $rowIndex) {

      switch ($rowIndex) {
        case 1:
          foreach ($sample_by_part_id_Arr as $key => $rowData) {
            $datArrView = explode('@@', $rowData);
            $sample_id = $request->sample_id;
            $sample_code = $datArrView[0];
            $item_name = $datArrView[1];

            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $sampleData->id,
                  'sample_code' => $sample_code,
                  'item_name' => $item_name,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 1,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );
          }
          break;
        case 2:
          foreach ($sample_by_part_id_Arr as $key => $rowData) {
            $datArrView = explode('@@', $rowData);
            $sample_id = $request->sample_id;
            $sample_code = $datArrView[0];
            $item_name = $datArrView[1];

            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $sampleData->id,
                  'sample_code' => $sample_code,
                  'item_name' => $item_name,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 2,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );
          }
          break;
        case 3:
          foreach ($sample_by_part_id_Arr as $key => $rowData) {
            $datArrView = explode('@@', $rowData);
            $sample_id = $request->sample_id;
            $sample_code = $datArrView[0];
            $item_name = $datArrView[1];

            DB::table('samples_tech_list')
              ->insert(
                [
                  'sample_id' => $sampleData->id,
                  'sample_code' => $sample_code,
                  'item_name' => $item_name,
                  's_created_at' => date('Y-m-d H:i:s'),
                  'item_requirement' => 3,
                  'created_by' => Auth::user()->id,
                  'created_name' => Auth::user()->name,
                  'created_at' => date('Y-m-d H:i:s'),
                  'notes' => 'It is requested for standard',
                  'client_id' => ''
                ]
              );
          }
          break;
      }
    }



    $res_arr = array(
      'data' => 1
    );
    return response()->json($res_arr);
  }

  public function saveSampleTechDocAA(Request $request)
  {
    $sample_by_part_id_Arr = $request->sample_by_part_id;
    $sample_by_part_idN_Arr = $request->sample_by_part_idN;
    $sampleTechRequirement = $request->sampleTechRequirement;

    $maxID = DB::table('samples_tech_list')->max('id');

    if ($request->sample_id == 9999999) {
      //ajax
      foreach ($sampleTechRequirement as $key => $row) {
        //------------------------------------------------

        DB::table('samples_tech_list')
          ->insert(
            [
              'sample_id' => $maxID,
              'sample_code' => Auth::user()->user_prefix . "-R" . $maxID,
              'item_name' => $sample_by_part_id_Arr,
              's_created_at' => date('Y-m-d H:i:s'),
              'item_requirement' => $row,
              'created_by' => Auth::user()->id,
              'created_name' => Auth::user()->name,
              'created_at' => date('Y-m-d H:i:s'),
              'notes' => 'It is requested for standard',
              'client_id' => ''
            ]
          );

        //-------------------------------------------------
      }
      //ajax
    } else {
      $this->validate($request, [
        'sample_by_part_id' => 'required',

      ]);
      $sampleData = DB::table('samples')
        ->where('sample_index', $request->sample_id)
        ->first();


      foreach ($sampleTechRequirement as $key => $row) {
        //------------------------------------------------
        foreach ($sample_by_part_id_Arr as $key => $rowData) {
          DB::table('samples_tech_list')
            ->updateOrInsert(
              ['sample_code' => $rowData, 'item_requirement' => $row],
              [
                'sample_id' => $request->sample_id,
                'item_name' => $sample_by_part_idN_Arr[$key],
                's_created_at' => $sampleData->created_at,
                'item_requirement' => $row,
                'created_by' => Auth::user()->id,
                'created_name' => Auth::user()->name,
                'created_at' => date('Y-m-d H:i:s'),
                'notes' => $request->sampletechRemarks,
                'client_id' => $sampleData->client_id
              ]
            );
        }
        //-------------------------------------------------

      }
    }

    $res_arr = array(
      'data' => 1
    );
    return response()->json($res_arr);
  }
  //saveSampleTechDoc

  //getOrderItemsDataTech
  public function getOrderItemsDataTech(Request $request)
  {
    $form_id = $request->form_ID;

    $qc_dataArr = DB::table('qc_forms')
      ->where('form_id', $form_id)
      ->where('is_deleted', 0)
      ->first();
    $arrData = array();

    if ($qc_dataArr->order_type == 'Private Label') {
      $arrData[] = array(
        'item_name' => $qc_dataArr->item_name,
        'order_type' => 1, //private,
        'id' => $form_id

      );
    } else {
      $qc_dataArrA = DB::table('qc_bulk_order_form')
        ->where('form_id', $form_id)
        ->select('id', 'item_name')
        ->whereNotNull('item_name')
        ->get();
      if (count($qc_dataArrA) > 0) {

        foreach ($qc_dataArrA as $key => $rowData) {

          $arrData[] = array(
            'item_name' => @$rowData->item_name,
            'order_type' => 2, //bulk,
            'id' => $rowData->id
          );
        }
      }
    }


    $res_arr = array(
      'data' => $arrData,
    );
    return response()->json($res_arr);
  }

  //getOrderItemsDataTech

  //getSampleItemsDataTech
  public function getSampleItemsDataTech(Request $request)
  {
    $usersSample = DB::table('samples')
      ->where('sample_code', $request->SID)
      ->first();
    $arrData = array();

    $dataArr = json_decode($usersSample->sample_details);
    $i = 0;
    foreach ($dataArr as $key => $rowData) {
      $i++;

      $arrData[] = array(
        'sample_id' => $usersSample->sample_code . "-" . $i,
        'sample_itemname' => ucwords($rowData->txtItem)
      );
    }
    $res_arr = array(
      'data' => $arrData,
      'dataSample' => $usersSample
    );
    return response()->json($res_arr);
  }
  //getSampleItemsDataTech

  //sampleAddTechinalDocumentOrder
  public function sampleAddTechinalDocumentOrder()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead' || Auth::user()->id == 124) {
      return $theme->scope('sample.AddTechnicalDocumentOrder', $data)->render();
    } else {
      abort(401);
    }
  }

  //sampleAddTechinalDocumentOrder

  //sampleAddTechinalDocument
  public function sampleAddTechinalDocument()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesUser' || $user_role == 'SalesHead' || Auth::user()->id == 124) {
      return $theme->scope('sample.AddTechnicalDocument', $data)->render();
    } else {
      abort(401);
    }
  }
  //sampleAddTechinalDocument

  //sampleFormulationListSales
  public function sampleFormulationListSales()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    return $theme->scope('sample.sample_FormulationListSales', $data)->render();
  }

  //sampleFormulationListSales

  //sampleFormulationList
  public function sampleFormulationList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    return $theme->scope('sample.sample_FormulationList', $data)->render();
  }

  //sampleFormulationList

  //sampleHighPriority
  public function sampleHighPriority()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    return $theme->scope('sample.sample_highpriority', $data)->render();
  }

  //sampleHighPriority


  public function index()
  {
   
    
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Intern' || $user_role == 'SalesUser' || Auth::user()->id == 85) {

      return $theme->scope('sample.sampleSaleList', $data)->render();
    } else {
      return $theme->scope('sample.index', $data)->render();
    }
  }
  //sampleDispatched
  public function sampleDispatched()
  {

    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Intern' || $user_role == 'SalesUser' || Auth::user()->id == 85) {

      return $theme->scope('sample.sampleSaleList', $data)->render();
    } else {
      return $theme->scope('sample.sampleDispatched', $data)->render();
    }
  }

  //sampleDispatched

  //sampleListOils
  public function sampleListOils()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    if (Auth::user()->id == 146 || Auth::user()->id == 189) {
      return $theme->scope('sample.sampleLiteListOils', $data)->render();
    } else {
      abort(401);
    }
  }
  //sampleListOils
  //sampleHistory
  public function sampleHistory()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    if (Auth::user()->id == 146 || Auth::user()->id == 124 || Auth::user()->id == 189) {
      return $theme->scope('sample.sampleHistory', $data)->render();
    } else {
      abort(401);
    }
  }

  //sampleHistory
  //sampleListCosmatic_OILView
  public function sampleListCosmatic_OILView()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    if (Auth::user()->id == 146 || Auth::user()->id == 189) {
      return $theme->scope('sample.sampleLiteListCosmatic_OILView', $data)->render();
    } else {
      abort(401);
    }
  }

  //sampleListCosmatic_OILView

  //sampleListCosmatic
  public function sampleListCosmatic()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    if (Auth::user()->id == 124 || Auth::user()->id == 126 || Auth::user()->id == 1) {
      return $theme->scope('sample.sampleLiteListCosmatic', $data)->render();
    } else {
      abort(401);
    }
  }
  //sampleListCosmatic

  public function sampleListSales()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $users = User::orderby('id', 'desc')->get();
    $data = ['users' => $users];
    // return $theme->scope('sample.sampleSaleList', $data)->render();

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    if ($user_role == 'SalesUser' || Auth::user()->id == 85) {
      return $theme->scope('sample.sampleSaleList', $data)->render();
    } else {
      if ($user_role == 'CourierTrk') {
        return $theme->scope('sample.sampleLiteList', $data)->render();
      } else {
        return $theme->scope('sample.index', $data)->render();
      }
    }
  }



  public function getROWClientsList()
  {
    $users_arr = RowClient::get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;

      $data_arr[] = array(
        'id' => $i,
        'rowid' => $value->id,
        'client_id' => $value->id,
        'email' => $value->email,
        'name' => $value->name,
        'phone' => $value->phone,
        'status' => $value->client_group
      );
    }

    $resp_jon = json_encode($data_arr);
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

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
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




  public function getClientList(Request $request, $userid)
  {
    $users_arr = User::where('created_by', $userid)->where('is_deleted', '!=', 1)->get();

    $data_arr_ = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $use_name = AyraHelp::getUserName($value->id);
      $companys = AyraHelp::getCompany($value->id);


      if (isset($companys->company_name)) {
        $comp_name = $companys->company_name;
      } else {
        $comp_name = "";
      }

      $email = $value->email;


      if (strpos($email, 'NoEmail_') !== false) {
        $email_ = '';
      } else {
        $email_ = $email;
      }

      $data_arr_[] = array(
        'id' => $i,
        'rowid' => $value->id,
        'client_name' => $use_name,
        'phone' => $value->phone,
        'company' => $comp_name,
        'email' => $email_,
        'status' => $value->status
      );
    }
    $resp_jon = json_encode($data_arr_);
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

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
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


  public function getSamplesListNew(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $users_arr = Sample::where('status', '1')->orderBy('id', 'desc')->get();
      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $client_arr = AyraHelp::getClientbyid($value->client_id);

        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => $value->sample_code,
          'company' => isset($client_arr->company) ? $client_arr->company : '',
          'phone' => isset($client_arr->phone) ? $client_arr->phone : '',
          'name' => isset($client_arr->firstname) ? $client_arr->firstname : '',
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'sent_access' => 1
        );
      }
    }
    if ($user_role == 'SalesUser') {
      $users_arr = Sample::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->get();
      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $client_arr = AyraHelp::getClientbyid($value->client_id);

        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => $value->sample_code,
          'company' => $client_arr->company,
          'phone' => $client_arr->phone,
          'name' => isset($client_arr->firstname) ? $client_arr->firstname : '',
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'sent_access' => 1
        );
      }
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'sent_access' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //saveSampleFormulationsF
  public function saveSampleFormulationsF(Request $request)
  {
    $txtIngredentArr = $request->txtIngredent;
    $txtFragranceArr = $request->txtFragrance;
    $txtColorArr = $request->txtColor;
    $txtPHValueArr = $request->txtPHValue;
    $txtAppearanceArr = $request->txtAppearance;
    $txtChemistIDArr = $request->txtChemistID;
    $txtSampleIDPartArr = $request->txtSampleIDPart;
    $txtSampleItemNameArr = $request->txtSampleItemName;
    //$ticketid = $request->txtSID;
    $sidParent = $request->txtSIDValue;
    $sitemArr = $request->sitemID;

    foreach ($sitemArr as $key => $rowData) {
      $ticket_id = $rowData;
      $usersSampleItemArr = DB::table('sample_items')
        ->where('id', $ticket_id)
        ->first();
      $usersSampleArr = DB::table('samples')
        ->where('id', $usersSampleItemArr->sid)
        ->first();

      $txtIngredent = 'NA';
      $txtFragrance = $txtFragranceArr[$key];
      $txtColor = $txtColorArr[$key];
      $txtPHValue = $txtPHValueArr[$key];
      $txtAppearance = $txtAppearanceArr[$key];
      $txtChemistID = $txtChemistIDArr[$key];
      $txtSampleIDPart = $txtSampleIDPartArr[$key];
      $txtSampleItemName = $txtSampleItemNameArr[$key];
      $data = DB::table('st_process_action_6v2')->where('ticket_id', $ticket_id)->where('process_id', 6)->where('stage_id', 3)->where('action_on', 1)->first();
      if ($data == null) {


        DB::table('samples_formula')
          ->updateOrInsert(
            ['sample_id' => $request->txtSIDValue, 'sample_code_with_part' => $txtSampleIDPart],
            [
              'sample_id' => $request->txtSIDValue,
              'sample_code_with_part' => $txtSampleIDPart,
              'key_ingredent' => $txtIngredent,
              'fragrance' => $txtFragrance,
              'color_val' => $txtColor,
              'ph_val' => $txtPHValue,
              'apperance_val' => $txtAppearance,
              'chemist_id' => $txtChemistID,
              'item_name' => $txtSampleItemName,
              'created_on' => date('Y-m-d H:i:s'),
              'created_by' => Auth::user()->id,
              'user_id' => $usersSampleArr->created_by,
              'client_id' => $usersSampleArr->client_id,
            ]
          );
        //----------------------------
        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);
        $affected = DB::table('sample_items')
          ->where('id', $ticket_id)
          ->update([
            'is_formulated' => 1,
            'stage_id' => 3,
            'chemist_id' => $txtChemistID,
            'formulated_on' => date('Y-m-d H:i:s'),
          ]);
        DB::table('st_process_action_6v2')->insert(
          [
            'ticket_id' => $ticket_id,
            'process_id' => 6,
            'stage_id' => 3,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Added Formulation Auto',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );

        //ajtak_1
        $dataA = DB::table('st_process_action_6')->where('ticket_id', $sidParent)->where('process_id', 6)->where('stage_id', 3)->where('action_on', 1)->first();
        if ($dataA == null) {
          DB::table('st_process_action_6')->insert(
            [
              'ticket_id' => $sidParent,
              'process_id' => 6,
              'stage_id' => 3,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Added Auto formuation by LAB ..',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
        }
        //ajtak_1


        $affected = DB::table('samples')
          ->where('id', $sidParent)
          ->update([
            'formatation_status' => 1,
            'is_formulated' => 1

          ]);




        //----------------------------



      } else {
        //echo "Z";
      }
    }
    $resp = array(
      'status' => 1,
      'msg' => 'OK updated '

    );
    return response()->json($resp);
  }
  public function saveSampleFormulationsFOK29(Request $request)
  {

    $txtIngredentArr = $request->txtIngredent;

    $txtFragranceArr = $request->txtFragrance;
    $txtColorArr = $request->txtColor;
    $txtPHValueArr = $request->txtPHValue;
    $txtAppearanceArr = $request->txtAppearance;
    $txtChemistIDArr = $request->txtChemistID;
    $txtSampleIDPartArr = $request->txtSampleIDPart;
    $txtSampleItemNameArr = $request->txtSampleItemName;
    $ticketid = $request->txtSID;
    $sidParent = $request->txtSIDValue;
    $sitemArr = $request->sitemID;


    foreach ($sitemArr as $key => $rowData) {
      echo  $ticket_id = $rowData;

      $usersSampleItemArr = DB::table('sample_items')
        ->where('id', $ticket_id)
        ->first();
      $usersSampleArr = DB::table('samples')
        ->where('id', $usersSampleItemArr->sid)
        ->first();
      $data = DB::table('st_process_action_6v2')->where('ticket_id', $ticketid)->where('process_id', 6)->where('stage_id', 3)->where('action_on', 1)->first();

      $txtIngredent = $txtIngredentArr[$key];
      $txtFragrance = $txtFragranceArr[$key];
      $txtColor = $txtColorArr[$key];
      $txtPHValue = $txtPHValueArr[$key];
      $txtAppearance = $txtAppearanceArr[$key];
      $txtChemistID = $txtChemistIDArr[$key];
      $txtSampleIDPart = $txtSampleIDPartArr[$key];
      $txtSampleItemName = $txtSampleItemNameArr[$key];

      if ($data == null) {
        //if not formuated 



        DB::table('samples_formula')->insert([
          'sample_id' => $request->txtSIDValue,
          'sample_code_with_part' => $txtSampleIDPart,
          'key_ingredent' => $txtIngredent,
          'fragrance' => $txtFragrance,
          'color_val' => $txtColor,
          'ph_val' => $txtPHValue,
          'apperance_val' => $txtAppearance,
          'chemist_id' => $txtChemistID,
          'item_name' => $txtSampleItemName,
          'created_on' => date('Y-m-d H:i:s'),
          'created_by' => Auth::user()->id,
          'user_id' => $usersSampleArr->created_by,
          'client_id' => $usersSampleArr->client_id,

        ]);

        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);

        $affected = DB::table('sample_items')
          ->where('id', $ticket_id)
          ->update([
            'is_formulated' => 1,
            'stage_id' => 3,
            'chemist_id' => $txtChemistID,
            'formulated_on' => date('Y-m-d H:i:s'),
          ]);

        DB::table('st_process_action_6v2')->insert(
          [
            'ticket_id' => $ticketid,
            'process_id' => 6,
            'stage_id' => 3,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Added Formulation Auto',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );







        //update parent stage
        DB::table('st_process_action_6')->insert(
          [
            'ticket_id' => $sidParent,
            'process_id' => 6,
            'stage_id' => 3,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Added Auto formuation by LAB ..',
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
          ->where('id', $sidParent)
          ->update([
            'formatation_status' => 1,
            'is_formulated' => 1

          ]);

        $resp = array(
          'status' => 1,
          'msg' => 'Inserted '

        );
        return response()->json($resp);

        //update parent statge


      } else {
        // if alread formulated 
        //update sample_item 
        //update sample_formuala
        // print_r($txtChemistIDArr);
        // die;
        //echo $ticket_id;
        //echo $txtChemistID;


        DB::table('samples_formula')
          ->update(
            ['sample_id' => $request->txtSIDValue, 'sample_code_with_part' => $txtSampleIDPart],
            [

              'sample_id' => $request->txtSIDValue,
              'sample_code_with_part' => $txtSampleIDPart,
              'key_ingredent' => $txtIngredent,
              'fragrance' => $txtFragrance,
              'color_val' => $txtColor,
              'ph_val' => $txtPHValue,
              'apperance_val' => $txtAppearance,
              'chemist_id' => $txtChemistID,
              'item_name' => $txtSampleItemName,
              'created_on' => date('Y-m-d H:i:s'),
              'created_by' => Auth::user()->id,
              'user_id' => $usersSampleArr->created_by,
              'client_id' => $usersSampleArr->client_id,
            ]
          );


        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);

        $affected = DB::table('sample_items')
          ->where('id', $ticket_id)
          ->update([
            'chemist_id' => $txtChemistID,
            'formulated_on' => date('Y-m-d H:i:s'),
          ]);




        // $resp = array(
        //   'status' => 1,
        //   'msg' => 'Update data'

        // );
        // return response()->json($resp);







      }
    }
  }
  public function saveSampleFormulationsFOKORI(Request $request)
  {
    //update sample items wise and if all done then update    


    $txtIngredentArr = $request->txtIngredent;
    $txtFragranceArr = $request->txtFragrance;
    $txtColorArr = $request->txtColor;
    $txtPHValueArr = $request->txtPHValue;
    $txtAppearanceArr = $request->txtAppearance;
    $txtChemistIDArr = $request->txtChemistID;
    $txtSampleIDPartArr = $request->txtSampleIDPart;
    $txtSampleItemNameArr = $request->txtSampleItemName;
    $ticketid = $request->txtSID;
    $sidParent = $request->txtSIDValue;
    $sitemID = $request->sitemID;

    $usersSample = DB::table('sample_items')
      ->where('id', $request->txtSID)
      ->first();
    $usersSampleArr = DB::table('samples')
      ->where('id', $usersSample->sid)
      ->first();



    $data = DB::table('st_process_action_6v2')->where('ticket_id', $ticketid)->where('process_id', 6)->where('stage_id', 3)->where('action_on', 1)->first();

    if ($data == null) {

      foreach ($txtIngredentArr as $key => $row) {
        $txtIngredent = $txtIngredentArr[$key];
        $txtFragrance = $txtFragranceArr[$key];
        $txtColor = $txtColorArr[$key];
        $txtPHValue = $txtPHValueArr[$key];
        $txtAppearance = $txtAppearanceArr[$key];
        $txtChemistID = $txtChemistIDArr[$key];
        $txtSampleIDPart = $txtSampleIDPartArr[$key];
        $txtSampleItemName = $txtSampleItemNameArr[$key];

        DB::table('samples_formula')->insert([
          'sample_id' => $request->txtSIDValue,
          'sample_code_with_part' => $txtSampleIDPart,
          'key_ingredent' => $txtIngredent,
          'fragrance' => $txtFragrance,
          'color_val' => $txtColor,
          'ph_val' => $txtPHValue,
          'apperance_val' => $txtAppearance,
          'chemist_id' => $txtChemistID,
          'item_name' => $txtSampleItemName,
          'created_on' => date('Y-m-d H:i:s'),
          'created_by' => Auth::user()->id,
          'user_id' => $usersSampleArr->created_by,
          'client_id' => $usersSampleArr->client_id,

        ]);

        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $request->$txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);
      }

      $affected = DB::table('sample_items')
        ->where('sid', $sidParent)
        ->update([
          'is_formulated' => 1,
          'stage_id' => 3,
          'chemist_id' => $request->$txtChemistID,
          'formulated_on' => date('Y-m-d H:i:s'),
        ]);

      //check formulation for parent 
      $isFormulatedChk = DB::table('sample_items')
        ->where('sid', $sidParent)
        ->where('is_formulated', 0)
        ->count();
      if ($isFormulatedChk <= 0) {
        DB::table('st_process_action_6')->insert(
          [
            'ticket_id' => $sidParent,
            'process_id' => 6,
            'stage_id' => 3,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Added Auto formuation by LAB',
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
          ->where('id', $sidParent)
          ->update([
            'formatation_status' => 1,
            'is_formulated' => 1

          ]);
      }

      //check formulation for parent 

      DB::table('st_process_action_6v2')->insert(
        [
          'ticket_id' => $ticketid,
          'process_id' => 6,
          'stage_id' => 3,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Added Formulation Auto',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
        ]
      );




      $resp = array(
        'status' => 1

      );
      return response()->json($resp);
    } else {


      //update
      foreach ($txtIngredentArr as $key => $row) {
        $txtIngredent = $txtIngredentArr[$key];
        $txtFragrance = $txtFragranceArr[$key];
        $txtColor = $txtColorArr[$key];
        $txtPHValue = $txtPHValueArr[$key];
        $txtAppearance = $txtAppearanceArr[$key];
        $txtChemistID = $txtChemistIDArr[$key];
        $txtSampleIDPart = $txtSampleIDPartArr[$key];
        $txtSampleItemName = $txtSampleItemNameArr[$key];

        DB::table('samples_formula')
          ->updateOrInsert(
            ['sample_id' => $request->txtSIDValue, 'sample_code_with_part' => $txtSampleIDPart],
            [

              'key_ingredent' => $txtIngredent,
              'fragrance' => $txtFragrance,
              'color_val' => $txtColor,
              'ph_val' => $txtPHValue,
              'apperance_val' => $txtAppearance,
              'chemist_id' => $txtChemistID,
              'item_name' => $txtSampleItemName,
              'created_on' => date('Y-m-d H:i:s'),
              'created_by' => Auth::user()->id,
              'user_id' => $usersSampleArr->created_by
            ]
          );



        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $request->$txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);
      }

      //update



      $resp = array(
        'status' => 1

      );
      return response()->json($resp);
    }



    // stage update

    // stage update



  }
  //saveSampleFormulationsF

  //saveSampleFormulations
  public function saveSampleFormulations(Request $request)
  {

    $txtIngredentArr = $request->txtIngredent;
    $txtFragranceArr = $request->txtFragrance;
    $txtColorArr = $request->txtColor;
    $txtPHValueArr = $request->txtPHValue;
    $txtAppearanceArr = $request->txtAppearance;
    $txtChemistIDArr = $request->txtChemistID;
    $txtSampleIDPartArr = $request->txtSampleIDPart;
    $txtSampleItemNameArr = $request->txtSampleItemName;
    $ticketid = $request->txtSIDValue;

    $usersSample = DB::table('samples')
      ->where('id', $request->txtSIDValue)
      ->first();



    $data = DB::table('st_process_action_6')->where('ticket_id', $ticketid)->where('process_id', 6)->where('stage_id', 3)->where('action_on', 1)->first();

    if ($data == null) {

      foreach ($txtIngredentArr as $key => $row) {
        $txtIngredent = $txtIngredentArr[$key];
        $txtFragrance = $txtFragranceArr[$key];
        $txtColor = $txtColorArr[$key];
        $txtPHValue = $txtPHValueArr[$key];
        $txtAppearance = $txtAppearanceArr[$key];
        $txtChemistID = $txtChemistIDArr[$key];
        $txtSampleIDPart = $txtSampleIDPartArr[$key];
        $txtSampleItemName = $txtSampleItemNameArr[$key];

        DB::table('samples_formula')->insert([
          'sample_id' => $request->txtSIDValue,
          'sample_code_with_part' => $txtSampleIDPart,
          'key_ingredent' => $txtIngredent,
          'fragrance' => $txtFragrance,
          'color_val' => $txtColor,
          'ph_val' => $txtPHValue,
          'apperance_val' => $txtAppearance,
          'chemist_id' => $txtChemistID,
          'item_name' => $txtSampleItemName,
          'created_on' => date('Y-m-d H:i:s'),
          'created_by' => Auth::user()->id,
          'user_id' => $usersSample->created_by

        ]);

        $affected = DB::table('sample_assigned_list')
          ->where('user_id', $request->$txtChemistID)
          ->update([
            'last_dispatcha_at' => date('Y-m-d H:i:s')

          ]);
      }

      $affected = DB::table('samples')
        ->where('id', $request->txtSIDValue)
        ->update([
          'formatation_status' => 1,
          'sample_stage_id' => 3,
          'is_formulated' => 1
        ]);



      DB::table('st_process_action_6')->insert(
        [
          'ticket_id' => $ticketid,
          'process_id' => 6,
          'stage_id' => 3,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Added Formulation Auto',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
        ]
      );




      $resp = array(
        'status' => 1

      );
      return response()->json($resp);
    } else {
      $resp = array(
        'status' => 0

      );
      return response()->json($resp);
    }



    // stage update

    // stage update



  }

  //saveSampleFormulations

  //getSampleItemDetailFormulation
  public function getSampleItemDetailFormulation(Request $request)
  {
    $samplesItem = DB::table('sample_items')
      ->where('id', $request->sample_id)
      ->first();
    // echo  $samplesItem->sid;
    // die;
    $samples = DB::table('samples')
      ->where('id', 9632)
      ->first();

    $daraArr = json_decode($samples->sample_details);



    $samplesUser = DB::table('sample_for_users')
      // ->where('is_active',0)
      ->get();
    //assingned_to //
    $sHTML = "<select name='txtChemistID[]' class='form-control'>";
    $activeChemietArr = AyraHelp::getChemist();
    foreach ($activeChemietArr as $key => $rowData) {


      $sHTML .= '<option  value="' . $rowData->id . '">' . $rowData->name . '</option>';
    }
    $sHTML .= "<select class='form-control'>";
    // echo $sHTML;
    // die;
    $dataArr = DB::table('sample_items')
      ->where('sid', $samplesItem->sid)
      ->get();
    $sampleDatArr = array();
    foreach ($dataArr as $key => $rowDV) {

      $sampleDatArr[] = array(
        'sample_subCode' => $rowDV->sid_partby_code,
        'sample_item' => $rowDV->item_name,
        'sample_color' => $rowDV->sample_color,
        'sample_fragrance' => $rowDV->sample_fragrance,
        'sitemID' => $rowDV->id

      );
    }

    $resp = array(
      'data' => $sampleDatArr,
      'sid' => $samplesItem->sid,
      'psid' => $samplesItem->sid,
      'sHTML' => $sHTML,
    );
    return response()->json($resp);
  }
  public function getSampleItemDetailFormulationOKORI(Request $request)
  {
    $samples = DB::table('sample_items')
      ->where('id', $request->sample_id)
      ->first();
    $samplesUser = DB::table('sample_for_users')
      // ->where('is_active',0)
      ->get();
    //assingned_to
    $sHTML = "<select name='txtChemistID[]' class='form-control'>";
    $activeChemietArr = AyraHelp::getChemist();
    foreach ($activeChemietArr as $key => $rowData) {


      if ($rowData->id == $samples->assinged_to) {
        $sHTML .= '<option selected value="' . $rowData->id . '">' . $rowData->name . '</option>';
      } else {
        $sHTML .= '<option  value="' . $rowData->id . '">' . $rowData->name . '</option>';
      }
    }
    // foreach ($samplesUser as $key => $sUser) {
    //   // echo "-".$samples->assingned_to;
    //   // echo "A-".$sUser->user_id;
    //   // echo "<br>";

    //   if ($samples->assingned_to == $sUser->user_id) {

    //     $sHTML .= '<option selected value="' . $sUser->user_id . '">' . AyraHelp::getUser($sUser->user_id)->name . '</option>';
    //   } else {
    //     $sHTML .= '<option  value="' . $sUser->user_id . '">' . AyraHelp::getUser($sUser->user_id)->name . '</option>';
    //   }
    // }
    $sHTML .= "<select class='form-control'>";
    // echo $sHTML;
    // die;

    $sampleDatArr[] = array(
      'sample_subCode' => $samples->sid_partby_code,
      'sample_item' => $samples->item_name,
      'sample_color' => $samples->sample_color,
      'sample_fragrance' => $samples->sample_fragrance

    );


    $resp = array(
      'data' => $sampleDatArr,
      'sid' => $samples->sid,
      'psid' => $samples->sid,
      'sHTML' => $sHTML,
    );
    return response()->json($resp);
  }
  //getSampleItemDetailFormulation

  //getSampleItemDetail
  public function getSampleItemDetail(Request $request)
  {
    $samples = DB::table('samples')
      ->where('id', $request->sample_id)
      ->first();
    $samplesUser = DB::table('sample_for_users')
      // ->where('is_active',0)
      ->get();
    //assingned_to
    $sHTML = "<select name='txtChemistID[]' class='form-control'>";
    $activeChemietArr = AyraHelp::getChemist();
    foreach ($activeChemietArr as $key => $rowData) {
      if ($rowData->id == $samples->assingned_to) {
        $sHTML .= '<option selected value="' . $rowData->user_id . '">' . $rowData->name . '</option>';
      } else {
        $sHTML .= '<option  value="' . $rowData->user_id . '">' . $rowData->name . '</option>';
      }
    }
    // foreach ($samplesUser as $key => $sUser) {
    //   // echo "-".$samples->assingned_to;
    //   // echo "A-".$sUser->user_id;
    //   // echo "<br>";

    //   if ($samples->assingned_to == $sUser->user_id) {

    //     $sHTML .= '<option selected value="' . $sUser->user_id . '">' . AyraHelp::getUser($sUser->user_id)->name . '</option>';
    //   } else {
    //     $sHTML .= '<option  value="' . $sUser->user_id . '">' . AyraHelp::getUser($sUser->user_id)->name . '</option>';
    //   }
    // }
    $sHTML .= "<select class='form-control'>";
    // echo $sHTML;
    // die;

    $daraArr = json_decode($samples->sample_details);
    $sampleDatArr = array();
    $i = 0;
    foreach ($daraArr as $key => $rowData) {
      $i++;
      $sampleDatArr[] = array(
        'sample_subCode' => $samples->sample_code . "-" . $i,
        'sample_item' => $rowData->txtItem

      );
    }

    $resp = array(
      'data' => $sampleDatArr,
      'sid' => $samples->sample_code,
      'sHTML' => $sHTML,
    );
    return response()->json($resp);
  }
  //getSampleItemDetail
  public function getSamplesListUserWise(Request $request)
  {
    $uid = $request->userid;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $data_arr = array();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'SalesHead') {
      $users_arr = Sample::where('client_id', $uid)->orderBy('id', 'desc')->get();
      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $client_arr = AyraHelp::getClientbyid($value->client_id);



        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => $value->sample_code,
          'company' => isset($client_arr->company) ? $client_arr->company : '',
          'phone' => isset($client_arr->phone) ? $client_arr->phone : '',
          'name' => isset($client_arr->firstname) ? $client_arr->firstname : '',
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'sent_access' => 1
        );
      }
    }
    if ($user_role == 'SalesUser') {
      $users_arr = Sample::where('client_id', $uid)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->get();
      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $client_arr = AyraHelp::getClientbyid($value->client_id);

        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => $value->sample_code,
          'company' => optional($client_arr)->company,
          'phone' => optional($client_arr)->phone,
          'name' => isset($client_arr->firstname) ? $client_arr->firstname : '',
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'sent_access' => 1
        );
      }
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'sent_access' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesListPendingAprroval
  public function getSamplesListPendingAprroval(Request $request)
  {
    $data_arr = array();

    $samples_formulaArr = DB::table('samples_for_approval_list')
      ->orderby('id', 'asc')
      ->get();
    // echo "<pre>";
    // print_r($samples_formulaArr);
    // diel


    foreach ($samples_formulaArr as $key => $row) {
      $data_arr[] = array(
        'RecordID' => $row->id,
        'sample_id' => $row->sample_id,
        'sample_code' => $row->sample_code,
        'sid' => $row->sample_id,
        'item_name' => $row->item_name,
        'client_brand' => $row->client_name,
        'agent' => AyraHelp::getUser($row->sale_person_id)->name,
        'created_at' => $row->sample_created_at,
        'feedback' => $row->sample_feedback,
        'status' => $row->status,
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_id'      => true,
      'sid'      => true,
      'item_name'      => true,
      'client_brand'      => true,
      'agent'      => true,
      'created_at'      => true,
      'feedback'     => true,
      'status'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesListPendingAprroval
  //updateSampleTrackingID
  public function updateSampleTrackingID(Request $request)
  {
    $sampleIDA = $request->sampleIDA;
    $txtTrackIDV = $request->txtTrackIDV;
    $txtSampleAssinedRemark = $request->txtSampleAssinedRemark;

    $affected = DB::table('samples')
      ->where('id', $sampleIDA)
      ->update(['track_id' => $txtTrackIDV]);

    DB::table('tbl_sample_tracking')->insert([
      'sid' => $sampleIDA,
      'track_id' => $txtTrackIDV,
      'created_by' => Auth::user()->id,
      'notes' => $txtSampleAssinedRemark,
    ]);

    $res_arr = array(
      'status' => 1,

    );
    return response()->json($res_arr);
  }
  //updateSampleTrackingID


  public function getSamplesListSalesDash(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();

    if ($sample_action == 'pending_feedback') {
      $users_arr = Sample::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->whereNull('feedback_addedon')->where('status', 2)->where('is_deleted', 0)->get();
    }
    if ($sample_action == 'show_all') {
      $users_arr = Sample::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->where('is_deleted', 0)->get();
    }

    if (Auth::user()->id == 85) {
      $users_arr = Sample::orderBy('id', 'desc')->where('is_deleted', 0)->get();
    }





    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $data_arr_data = DB::table('indmt_data')
          ->where('indmt_data.QUERY_ID', '=', $value->QUERY_ID)
          ->where('assign_to', Auth::user()->id)
          ->first();

        $company = optional($data_arr_data)->GLUSR_USR_COMPANYNAME;
        $phone = optional($data_arr_data)->MOB;
        $name = optional($data_arr_data)->SENDERNAME . ' <span class="m-badge m-badge--info">L</span>';
        $client_order_info = 0;
      } else {

        if ($value->sample_from == 2) {
          $data_arr_data = DB::table('client_sales_lead')
            ->where('QUERY_ID', '=', $value->QUERY_ID)
            ->where('assign_to', Auth::user()->id)
            ->first();

          $company = optional($data_arr_data)->GLUSR_USR_COMPANYNAME;
          $phone = optional($data_arr_data)->MOB;
          $name = optional($data_arr_data)->SENDERNAME . ' <span class="m-badge m-badge--accent">ML</span>';
          $client_order_info = 0;
        } else {
          $client_arr = AyraHelp::getClientbyid($value->client_id);
          // $client_order_info=AyraHelp::getClientHaveOrder($value->client_id);
          $client_order_inf = 0;
          $company = optional($client_arr)->company;
          $phone = optional($client_arr)->phone;
          $name = optional($client_arr)->firstname;

          $data_arr_dataUpdatToday = DB::table('samples')
            ->where('id', $value->id)
            ->whereDate('update_today', date('Y-m-d'))
            ->first();
          if ($data_arr_dataUpdatToday == null) {
            $affected = DB::table('samples')
              ->where('id', $value->id)
              ->update([
                'lead_name' => $name,
                'lead_phone' => $phone,
                'lead_company' => $company,
                'update_today' => date('Y-m-d')

              ]);
          } else {
          }
        }
      }

      //---------------------------------------

      //$client_arr=AyraHelp::getClientbyid($value->client_id);

      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }
      if ($value->sample_stage_id == 1) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }



      if ($value->sample_v == 2) {

        $sampleIArr = DB::table('sample_items')
          ->where('sid', $value->id)
          ->orderBy('stage_id', 'asc')
          ->first();

        $stGID = @$sampleIArr->stage_id;
      } else {
        $stGID = $value->sample_stage_id;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => optional($value)->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $stGID,
        'order_status' => '',
        'sent_access' => 1,
        'edit_right' => $edit_right,
        'process_status' => $value->process_status,
        'chkHandedOver' => $value->chkHandedOver,
        'assignedTo' => optional($value)->assingned_name,
        'is_rejected' => optional($value)->is_rejected,
        'is_paid_status' => optional($value)->is_paid_status,
        'isEncrypt' => AyraHelp::AyraCrypt($value->id)


      );
    }
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'edit_right' => true,
      'process_status' => true,
      'chkHandedOver' => true,
      'assignedTo' => true,
      'is_rejected' => true,
      'is_paid_status' => true,
      'isEncrypt' => true,
      'Actions'      => true,
    ];
    AyraHelp::setSampleFirstStage();
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesList_LITE_COSMATIC

  //getOrderPaymentAccountDetails
  public function getOrderPaymentAccountDetails(Request $request)
  {
    //account_msg  /account_approval

    $DataVa = DB::table('qc_forms')
      ->where('form_id', $request->form_id)
      ->first();

    $payStatus = $DataVa->account_approval == 1 ? "Approved" : "Pending";

    $HTML = "";
    $HTML .= '

    <table class="table table-bordered .table-sm m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
          <tr>
            <th colspan="2">Payment Details: </b></th>

          </tr>
        </thead>
        <tbody>
          <tr>
          <td>
          Paymeny Status: <b>' . $payStatus . '</b>
          </td>
          <td>
          Paymeny Details: <b>' . @$DataVa->account_msg . '</b>
          </td>
          </tr>


        </tbody>
      </table>

  ';
    echo $HTML;
  }
  //getOrderPaymentAccountDetails

  //getSamplesList_LITE_COSMATIC_assinedListRESTALL
  public function getSamplesList_LITE_COSMATIC_assinedListRESTALL(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->whereNotNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 2)->where('sample_stage_id', '>=', 2)->where('formatation_status', '!=', 0)->get();

    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $value->sample_stage_id,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sent_access' => 1,
        'sample_catType' => $value->sample_type,
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_COSMATIC_assinedListRESTALL
  //getSamplesList_LITE_COSMATIC_Standard
  public function getSamplesList_LITE_COSMATIC_Standard(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '=', 1)->where('sample_stage_id', '>=', 2)->get();

    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $value->sample_stage_id,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sent_access' => 1,
        'sample_catType' => $value->sample_type,
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_COSMATIC_Standard

  //getSamplesList_LITE_COSMATIC_assinedList
  public function getSamplesList_LITE_COSMATIC_assinedList(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->whereNotNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 2)->where('sample_stage_id', '<=', 2)->where('formatation_status', '=', 0)->get();

    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $value->sample_stage_id,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sent_access' => 1,
        'sample_catType' => $value->sample_type,
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesList_LITE_COSMATIC_assinedList
  //getSamplesList_LITE_COSMATIC_unassinedList
  public function getSamplesList_LITE_COSMATIC_unassinedList(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('sample_stage_id', '<=', 1)->whereNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 2)->get();

    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $value->sample_stage_id,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sent_access' => 1,
        'sample_catType' => $value->sample_type,
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_COSMATIC_viewAfterFormulation
  public function getSamplesList_LITE_COSMATIC_viewAfterFormulation(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    //$users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 2)->where('sample_stage_id', '>', 2)->get();
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 2)->where('formatation_status', 1)->get();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      if ($value->sample_v == 2) {

        $sampleIArr = DB::table('sample_items')
          ->where('sid', $value->id)
          ->orderBy('stage_id', 'asc')
          ->first();
        $stGID = @$sampleIArr->stage_id;
      } else {
        $stGID = $value->sample_stage_id;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $stGID,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sample_type' => $value->sample_type,
        'is_domestic' => $value->is_domestic,
        'sample_catType' => $value->sample_type,

        'sent_access' => 1
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_type' => true,
      'is_domestic' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_COSMATIC_viewAfterFormulation

  //getSamplesList_LITE_COSMATIC_unassinedList

  public function getSamplesList_LITE_COSMATIC(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=', 1)->where('sample_type', '!=', 2)->where('sample_stage_id', '>=', 2)->get();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'sample_stage_id' => $value->sample_stage_id,
        'order_status' => $client_order_info,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'sent_access' => 1
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'sample_assignedTo' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_COSMATIC

  //getSamplesList_LITE_OILS
  public function getSamplesList_LITE_OILS(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    //$users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_stage_id','>=',2)->where('sample_type', 2)->get();
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->where('sample_type', 2)->get();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {


        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $client_order_info,
        'sample_stage_id' => $value->sample_stage_id,
        'is_domestic' => $value->is_domestic,
        'sent_access' => 1
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'is_domestic' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_OILS

  //getSamplesList_LITE_HISTORY
  public function getSamplesList_LITE_HISTORYJ(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 2)->get();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {

        // $data_arr_data = DB::table('indmt_data')
        //   ->where('indmt_data.QUERY_ID', '=', $value->QUERY_ID)
        //   ->first();
        //     $company = $data_arr_data->GLUSR_USR_COMPANYNAME;
        //     $phone = $data_arr_data->MOB;
        //     $name = $data_arr_data->SENDERNAME . "<span>Lead</span>";
        //     $client_order_info = 'Lead';

        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $client_order_info,
        'sample_stage_id' => $value->sample_stage_id,
        'sent_access' => 1
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_LITE_HISTORY

  // getSamplesList_LITE
  public function getSamplesList_LITE(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 1)->get();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      //----------------------------------
      if ($value->sample_from == 1) {

        // $data_arr_data = DB::table('indmt_data')
        //   ->where('indmt_data.QUERY_ID', '=', $value->QUERY_ID)
        //   ->first();
        //     $company = $data_arr_data->GLUSR_USR_COMPANYNAME;
        //     $phone = $data_arr_data->MOB;
        //     $name = $data_arr_data->SENDERNAME . "<span>Lead</span>";
        //     $client_order_info = 'Lead';

        $company = 'NA';
        $phone = 'NA';
        $name = 'NA';
        $client_order_info = 'Lead';
      } else {

        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);

        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';
      }
      //---------------------------------------

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => $company,
        'phone' => $phone,
        'name' => $name,
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $client_order_info,
        'sample_stage_id' => $value->sample_stage_id,
        'sent_access' => 1
      );
    }
    //fore
    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'sample_stage_id' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesList_feedbac_own
  public function getSamplesList_feedbac_own(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    //$users_arr = Sample::orderBy('id', 'desc')->get();
    $users_arr = Sample::where('is_deleted', 0)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->whereNull('feedback_addedon')->where('status', 2)->get();

    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1
      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_feedbac_own
  //getSamplesList_UnassignedList_OILS
  public function getSamplesList_UnassignedList_OILS(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('is_rejected', 0)->where('status', 1)->where('sample_stage_id', 1)->where('sample_type', '=', 2)->orderBy('id', 'desc')->get();
    // $users_arr = Sample::where('is_deleted', 0)->where('is_rejected', 0)->where('status', 1)->whereNull('assingned_to')->orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);


      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $value->sample_stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'is_rejected' => $value->is_rejected,
        'edit_right' => 1
      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'is_rejected' => true,
      'Actions'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesList_UnassignedList_OILS

  //getSamplesList_UnassignedList
  public function getSamplesList_UnassignedList(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('is_rejected', 0)->where('status', 1)->where('sample_type', '!=', 2)->where('sample_stage_id', '=', 1)->whereNull('assingned_to')->orderBy('id', 'desc')->get();
    // $users_arr = Sample::where('is_deleted', 0)->where('is_rejected', 0)->where('status', 1)->whereNull('assingned_to')->orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);


      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $value->sample_stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'is_rejected' => $value->is_rejected,
        'edit_right' => 1
      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'is_rejected' => true,
      'Actions'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesList_UnassignedList

  //getSamplesList_assignedList
  public function getSamplesList_assignedList(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('status', 1)->whereNotNull('assingned_to')->orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);


      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $value->sample_stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1
      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'Actions'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSamplesList_assignedList
  // getSamplesList_LITE



  public function getSamplesList_LITE_HISTORY(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);


      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $value->sample_stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1
      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'Actions'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getSampleFormulatDetailsViewSample

  public function getSampleFormulatDetailsViewSampleModi(Request $request)
  {
    $recordID = $request->SID;
    $sampleArr = DB::table('samples')
      ->where('sample_code', $recordID)
      ->first();
    if ($sampleArr != null) {
      $formualArr = array();
      $sampArrData = json_decode($sampleArr->sample_details);


      foreach ($sampArrData as $key => $rowData) {
        $itemName = $rowData->txtItem;
        $itemNumber = strlen($itemName);
        $dashCount = substr_count($itemName, "-");


        $formualArr[] = array(
          'item_name' => $itemName,
          'itemNumber' => $itemNumber,
          'dashCount' => $dashCount,


        );
      }
      return response()->json($formualArr);
    } else {
      $res_arr = array(
        'status' => 2,

      );
      return response()->json($res_arr);
    }
  }

  public function getSampleFormulatDetailsViewSample(Request $request)
  {
    $recordID = $request->SID;
    $sampleArr = DB::table('samples_formula')
      ->where('sample_code_with_part', 'like', '%' . $recordID . '%')
      ->get();
    if (count($sampleArr) > 0) {
      $formualArr = array();
      foreach ($sampleArr as $key => $rowData) {
        $formualArr[] = array(
          'sample_code_with_part' => $rowData->sample_code_with_part,
          'item_name' => @$rowData->item_name,
          'key_ingredent' => $rowData->key_ingredent,
          'fragrance' => $rowData->fragrance,
          'color_val' => $rowData->color_val,
          'ph_val' => $rowData->ph_val,
          'apperance_val' => $rowData->apperance_val,
          'chemist_id' => AyraHelp::getUser($rowData->chemist_id)->name,
          'created_on' => $rowData->created_on,
          'created_by' => $rowData->created_by,
        );
      }
      return response()->json($formualArr);
    } else {
      $res_arr = array(
        'status' => 2,

      );
      return response()->json($res_arr);
    }
  }

  //getSampleFormulatDetailsViewSample

  //getSampleFormulatDetailsView
  public function getSampleFormulatDetailsView(Request $request)
  {

    $recordID = $request->SID;
    $sampleArr = DB::table('samples_formula')
      ->where('sample_code_with_part', $recordID)
      ->get();
    if (count($sampleArr) > 0) {
      $formualArr = array();
      foreach ($sampleArr as $key => $rowData) {

        $formualArr[] = array(
          'sample_code_with_part' => $rowData->sample_code_with_part,
          'item_name' => $rowData->item_name,
          'key_ingredent' => $rowData->key_ingredent,
          'fragrance' => $rowData->fragrance,
          'color_val' => $rowData->color_val,
          'ph_val' => $rowData->ph_val,
          'apperance_val' => $rowData->apperance_val,
          'chemist_id' => @AyraHelp::getUser($rowData->chemist_id)->name,
          'created_on' => $rowData->created_on,
          'created_by' => $rowData->created_by,
        );
      }



      return response()->json($formualArr);
    } else {
      $res_arr = array(
        'status' => 2,

      );
      return response()->json($res_arr);
    }
  }

  //getSampleFormulatDetailsView

  //getSampleFormulaDetails
  public function getSampleFormulaDetails(Request $request)
  {

    $recordID = $request->recordID;
    $sampleArr = DB::table('samples_formula')
      ->where('sample_id', $recordID)
      ->get();
    $formualArr = array();
    foreach ($sampleArr as $key => $rowData) {

      $formualArr[] = array(
        'sample_code_with_part' => $rowData->sample_code_with_part,
        'item_name' => $rowData->item_name,
        'key_ingredent' => $rowData->key_ingredent == NULL ? "" : $rowData->key_ingredent,
        'fragrance' => $rowData->fragrance == NULL ? "" : $rowData->fragrance,
        'color_val' => $rowData->color_val,
        'ph_val' => $rowData->ph_val == NUll ? "" : $rowData->ph_val,
        'apperance_val' => $rowData->apperance_val == NULL ? "" : $rowData->apperance_val,
        'chemist_id' => @AyraHelp::getUser($rowData->chemist_id)->name == Null ? "" : @AyraHelp::getUser($rowData->chemist_id)->name,
        'created_on' => date('j F Y', strtotime($rowData->created_on)),
        'created_by' => $rowData->created_by,
        'formulated_on' => date('j-F-Y H:iA', strtotime($rowData->formulated_on)),
      );
    }



    return response()->json($formualArr);
  }

  //getSamplesListHigh
  public function getSamplesListHigh(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('admin_urgent_status', 1)->orderBy('created_at', 'ASC')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);


      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $value->sample_stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1,
        'formatation_status' => $value->formatation_status,
        'is_rejected' => $value->is_rejected,
        'admin_urgent_status' => $value->admin_urgent_status,
        'isEncrypt' => AyraHelp::AyraCrypt($value->id),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,


      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'formatation_status' => true,
      'is_rejected' => true,
      'admin_urgent_status' => true,
      'isEncrypt' => true,
      'Actions'      => true,
      'brand_type'      => true,
      'order_size'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesListHigh
  //saveSampleDispatchBulk
  public function saveSampleDispatchBulk(Request $request)
  {
    print_r($request->all());
  }
  //saveSampleDispatchBulk

  //getSamplesListFomulationSales
  public function getSamplesListFomulationSales(Request $request)
  {
    // AyraHelp::updateSamplesItem(Auth::user()->id);
    // AyraHelp::updateSamplesItem_OIL(Auth::user()->id);
    // AyraHelp::updateSamplesItem_Delete(Auth::user()->id);
    // AyraHelp::updateSamplesOnlineSampleToItem(Auth::user()->id);

    $users_arr = array();
    // $users_arr = SampleItem::where('is_deleted', 0)->where('sample_v', 2)->orderBy('created_at', 'ASC')->get();
    $users_arr = DB::table('sample_items')
      ->join('samples', 'sample_items.sid', '=', 'samples.id')
      ->select('sample_items.*', 'samples.is_formulated as isformulated')
      ->where('samples.is_deleted', 0)
      ->where('samples.sample_stage_id', '>', 2)
      ->where('samples.sample_type', '!=', 2)
      ->where('sample_items.sample_type', '!=', 2)
      ->where('samples.created_by', Auth::user()->id)
      ->get();


    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      // echo "<pre>";
      // print_r($value);
      // die;


      $i++;



      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }
      $users_arrPSample = Sample::where('id', $value->sid)->first();
      $created_by = AyraHelp::getUserName($users_arrPSample->created_by);

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sid_partby_code,
        'company' => isset($users_arrPSample->lead_company) ? $users_arrPSample->lead_company : '',
        'phone' => isset($users_arrPSample->lead_phone) ? $users_arrPSample->lead_phone : '',
        'name' => isset($users_arrPSample->lead_name) ? $users_arrPSample->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => 'locaton',
        'Status' => 1,
        'order_status' => 3,
        'lead_name' => isset($users_arrPSample->lead_name) ? $users_arrPSample->lead_name : '',
        'lead_phone' => isset($users_arrPSample->lead_phone) ? $users_arrPSample->lead_phone : '',
        'lead_company' => isset($users_arrPSample->lead_company) ? $users_arrPSample->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_cat,
        'order_count' => 6,
        'sent_access' => 1,
        'sample_stage_id' => $value->stage_id,
        'sample_assignedTo' => @$value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1,
        'formatation_status' => $value->isformulated,
        'is_rejected' => 6,
        'admin_urgent_status' => 11,
        'isEncrypt' => AyraHelp::AyraCrypt($value->id),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,
        'item_name' => $value->item_name,


      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'formatation_status' => true,
      'is_rejected' => true,
      'admin_urgent_status' => true,
      'isEncrypt' => true,
      'Actions'      => true,
      'brand_type'      => true,
      'order_size'      => true,
      'order_size'      => true,
    ];
    // AyraHelp::setSampleFirstStageV2();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesListFomulationSales

  //getSamplesListFomulation
  public function getSamplesListFomulation(Request $request)
  {
    $users_arr = array();
    $users_arr = SampleItem::where('is_deleted', 0)->where('sample_v', 2)->orderBy('created_at', 'ASC')->get();

    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {

      $i++;



      if (date('Ymd') == date('Ymd', strtotime($value->created_at))) {
        $edit_right = 1;
      } else {
        $edit_right = 0;
      }
      $users_arrPSample = Sample::where('id', $value->sid)->first();
      $created_by = AyraHelp::getUserName($users_arrPSample->created_by);

      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sid_partby_code,
        'company' => isset($users_arrPSample->lead_company) ? $users_arrPSample->lead_company : '',
        'phone' => isset($users_arrPSample->lead_phone) ? $users_arrPSample->lead_phone : '',
        'name' => isset($users_arrPSample->lead_name) ? $users_arrPSample->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => 'locaton',
        'Status' => 1,
        'order_status' => 3,
        'lead_name' => isset($users_arrPSample->lead_name) ? $users_arrPSample->lead_name : '',
        'lead_phone' => isset($users_arrPSample->lead_phone) ? $users_arrPSample->lead_phone : '',
        'lead_company' => isset($users_arrPSample->lead_company) ? $users_arrPSample->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_cat,
        'order_count' => 6,
        'sent_access' => 1,
        'sample_stage_id' => $value->stage_id,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1,
        'formatation_status' => $value->is_formulated,
        'is_rejected' => 6,
        'admin_urgent_status' => 11,
        'isEncrypt' => AyraHelp::AyraCrypt($value->id),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,
        'item_name' => $value->item_name,


      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'formatation_status' => true,
      'is_rejected' => true,
      'admin_urgent_status' => true,
      'isEncrypt' => true,
      'Actions'      => true,
      'brand_type'      => true,
      'order_size'      => true,
      'order_size'      => true,
    ];
    // AyraHelp::setSampleFirstStageV2();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSamplesListFomulation


  //getSampleFormulaDetails
  public function getSamplesList(Request $request)
  {
    $sample_action = $request->sample_action;
    $sidStatus = $request->sidStatus;
    $users_arr = array();
    $users_arr = Sample::where('is_deleted', 0)->where('status', $sidStatus)->orderBy('created_at', 'ASC')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);



      if ($sidStatus == 1) {
        //----------------------
        if ($value->sample_v == 2) {

          $sampleIArr = DB::table('sample_items')
            ->where('sid', $value->id)
            ->orderBy('stage_id', 'asc')
            ->first();
          $stGID = @$sampleIArr->stage_id;
        } else {
          $stGID = $value->sample_stage_id;
        }
        //-----------------------


      } else {

        if (Auth::user()->id == 1) {
          $stGID = $value->sample_stage_id;
        } else {
          if ($value->sample_v == 2) {

            $sampleIArr = DB::table('sample_items')
              ->where('sid', $value->id)
              ->orderBy('stage_id', 'asc')
              ->first();
            $stGID = @$sampleIArr->stage_id;
          } else {
            $stGID = $value->sample_stage_id;
          }
        }
      }



      $data_arr[] = array(
        'RecordID' => $value->id,
        'sample_code' => $value->sample_code,
        'company' => isset($value->lead_company) ? $value->lead_company : '',
        'phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'name' => isset($value->lead_name) ? $value->lead_name : '',
        'created_on' => date('j M Y', strtotime($value->created_at)),
        'created_by' => $created_by,
        'location' => $value->location,
        'Status' => $value->status,
        'order_status' => $value->order_count,
        'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
        'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
        'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
        'sample_v' => $value->sample_v,
        'sample_type' => $value->sample_type,
        'sample_catType' => $value->sample_type,
        'order_count' => $value->order_count,
        'sent_access' => 1,
        'sample_stage_id' => $stGID,
        'sample_assignedTo' => $value->assingned_name == null ? '' : $value->assingned_name,
        'edit_right' => 1,
        'formatation_status' => $value->formatation_status,
        'is_rejected' => $value->is_rejected,
        'admin_urgent_status' => $value->admin_urgent_status,
        'isEncrypt' => AyraHelp::AyraCrypt($value->id),
        'brand_type' => $value->brand_type,
        'order_size' => $value->order_size,


      );
    } //end


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'lead_name' => true,
      'lead_phone' => true,
      'lead_company' => true,
      'sample_v' => true,
      'sample_type' => true,
      'sample_catType' => true,
      'order_count' => true,
      'edit_right' => true,
      'sample_stage_id' => true,
      'sample_stage_id' => true,
      'formatation_status' => true,
      'is_rejected' => true,
      'admin_urgent_status' => true,
      'isEncrypt' => true,
      'Actions'      => true,
      'brand_type'      => true,
      'order_size'      => true,
    ];
    AyraHelp::setSampleFirstStage();

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //-------------lite sample admin


  public function getSamplesList2SEP(Request $request)
  {
    $sample_action = $request->sample_action;
    $users_arr = array();
    $data_arr = array();
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user->hasPermissionTo('view-sample')) {
      if ($sample_action == 'pending_feedback') {
        $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->whereNull('feedback_addedon')->where('status', 2)->get();
      }
      if ($sample_action == 'show_all') {
        $users_arr = Sample::where('is_deleted', 0)->orderBy('id', 'desc')->get();
      }

      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);

        //----------------------------------
        $client_arr = AyraHelp::getClientbyid($value->client_id);
        $client_order_info = AyraHelp::getClientHaveOrder($value->client_id);


        $company = isset($client_arr->company) ? $client_arr->company : '';
        $phone = isset($client_arr->phone) ? $client_arr->phone : '';
        $name = isset($client_arr->firstname) ? $client_arr->firstname : '';

        //---------------------------------------

        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => $value->sample_code,
          'company' => $company,
          'phone' => $phone,
          'name' => $name,
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'order_status' => $client_order_info,
          'lead_name' => isset($value->lead_name) ? $value->lead_name : '',
          'lead_phone' => isset($value->lead_phone) ? $value->lead_phone : '',
          'lead_company' => isset($value->lead_company) ? $value->lead_company : '',
          'sample_v' => $value->sample_v,
          'sample_type' => $value->sample_type,
          'order_count' => $value->order_count,
          'sent_access' => 1
        );
      }
    }
    if ($user_role == 'SalesUser'  || $user_role == 'Staff') {

      if ($sample_action == 'pending_feedback') {
        $users_arr = Sample::where('is_deleted', 0)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->whereNull('feedback_addedon')->where('status', 2)->get();
      }
      if ($sample_action == 'show_all') {
        $users_arr = Sample::where('is_deleted', 0)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->get();
        //   $users_arr = DB::table('samples')

        //   ->join('users_access', function ($join) {
        //     $join->on('samples.client_id', '=', 'users_access.client_id');
        //     $join->on('users_access.access_by', '=', 'samples.created_by');
        //    })
        //   ->select('samples.*')
        //   ->orderBy('samples.id', 'DESC')
        //   ->orwhere('users_access.access_to',Auth::user()->id)
        //  ->get();

      }

      if (Auth::user()->id == 85) {
        $users_arr = Sample::orderBy('id', 'desc')->get();
      }





      $data_arr = array();
      $i = 0;
      foreach ($users_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);

        //----------------------------------
        if ($value->sample_from == 1) {

          $data_arr_data = DB::table('indmt_data')
            ->where('indmt_data.QUERY_ID', '=', $value->QUERY_ID)
            ->where('assign_to', Auth::user()->id)
            ->first();

          $company = optional($data_arr_data)->GLUSR_USR_COMPANYNAME;
          $phone = optional($data_arr_data)->MOB;
          $name = optional($data_arr_data)->SENDERNAME . ' <span class="m-badge m-badge--info">L</span>';
          $client_order_info = 0;
        } else {

          $client_arr = AyraHelp::getClientbyid($value->client_id);
          // $client_order_info=AyraHelp::getClientHaveOrder($value->client_id);
          $client_order_inf = 0;

          $company = optional($client_arr)->company;
          $phone = optional($client_arr)->phone;
          $name = optional($client_arr)->firstname;
        }
        //---------------------------------------

        //$client_arr=AyraHelp::getClientbyid($value->client_id);


        $data_arr[] = array(
          'RecordID' => $value->id,
          'sample_code' => optional($value)->sample_code,
          'company' => $company,
          'phone' => $phone,
          'name' => $name,
          'created_on' => date('j M Y', strtotime($value->created_at)),
          'created_by' => $created_by,
          'location' => $value->location,
          'Status' => $value->status,
          'order_status' => '',
          'sent_access' => 1
        );
      }
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'      => true,
      'sample_code'      => true,
      'company'      => true,
      'phone'      => true,
      'name'      => true,
      'created_on'      => true,
      'created_by'     => true,
      'location'     => true,
      'Status' => true,
      'order_status' => true,
      'sent_access' => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function getSamplesList_(Request $request)
  {
    $users_arr = Sample::orderBy('id', 'desc')->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;

      $client_arr = AyraHelp::getClientbyid($value->client_id);
      $sales_user = AyraHelp::getUser($value->created_by);
      $data_arr[] = array(
        'id' => $i,
        'rowid' => $value->id,
        'client_name' => $client_arr->firstname,
        'sid_code' => $value->sid_code,
        'sample_id' => $value->sample_code,
        'sample_details' => $value->sample_details,
        'created_by' => $sales_user->name,
        'created_by_id' => $sales_user->id,

        'courier_details' => $value->courier_details,
        'track_id' =>  $value->track_id,
        'status' =>  $value->status

      );
    }
    $resp_jon = json_encode($data_arr);
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

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
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



  public function getSampleList(Request $request, $userid)
  {
    $users_arr = Sample::where('is_deleted', 0)->where('created_by', $userid)->get();
    $data_arr = array();
    $i = 0;
    foreach ($users_arr as $key => $value) {
      $i++;
      $use_name = AyraHelp::getUserName($value->client_name);
      $companys = AyraHelp::getCompany($value->client_name);


      if (isset($companys->company_name)) {
        $comp_name = $companys->company_name;
      } else {
        $comp_name = "";
      }

      $data_arr[] = array(
        'id' => $i,
        'rowid' => $value->id,
        'sid_code' => $value->sid_code,
        'sample_id' => $value->sample_id,
        'company' => $comp_name,
        'client_name' => $use_name,
        'sample_details' => $value->sample_details,
        'courier_details' => $value->courier_details,
        'track_id' =>  $value->track_id,
        'status' =>  $value->status

      );
    }
    $resp_jon = json_encode($data_arr);
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

    $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'desc';
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


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function sampleCreateV1()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data = [
      'users' => '$users',
      'sample_id' => $max_id
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('sample.createNew', $data)->render();
    } else {
      //return $theme->scope('sample.create', $data)->render();
      return $theme->scope('sample.createNew', $data)->render();
    }
  }
  public function create()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $data = [
      'users' => '$users',
      'sample_id' => $max_id
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      return $theme->scope('sample.createNew', $data)->render();
    } else {
      return $theme->scope('sample.create', $data)->render();
    }
  }
  //getSampleListbyCatType
  public function getSampleListbyCatType(Request $request)
  {
    $HTML = "";
    switch ($request->catType) {

      case 2:

        $users = DB::table('rnd_add_ingredient')->get();
        foreach ($users as $key => $rowData) {
          $HTML .= '<option value=' . '97116' . $rowData->name . '>' . $rowData->name . '</option>';
        }
        $usersAj = DB::table('sample_itemname')->where('cat_type', 2)->get();
        foreach ($usersAj as $key => $rowData) {
          $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
        }

        return $HTML;

        break;
      case 1:
        $users = DB::table('rnd_finish_products')->get();
        foreach ($users as $key => $rowData) {
          $HTML .= '<option value=' . '97116' . $rowData->product_name . '>' . $rowData->product_name . '</option>';
        }
        $usersAj = DB::table('sample_itemname')->where('cat_type', 1)->get();
        foreach ($usersAj as $key => $rowData) {
          $HTML .= '<option value=' . $rowData->item_name . '>' . $rowData->item_name . '</option>';
        }
        return $HTML;

        break;
    }
  }
  //getSampleListbyCatType

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function sampleStoreNew(Request $request)
  {
    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleItemName_Arr = $request->sampleItemName;
      $sampleDiscription_Arr = $request->sampleDiscription;
      $samplsampleType_Arr = $request->sampleType;
      $price_per_kg_Arr = $request->price_per_kg;

      $sampleBrandType = $request->sampleBrandType;
      $sampleOrderSize = $request->sampleOrderSize;



      $ajata = array();
      $i = 0;
      $j = 0;

      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i]


        );
        $j++;
        $i++;
      }

      //$sample_data = json_encode($request->aj);
      $sample_data = json_encode($ajata);

      // $max_sample_index = Sample::max('sample_index')+1;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

      $sid_code = AyraHelp::getSampleIDCode();

      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      $ordercouT = AyraHelp::getClientHaveOrder($request->client_id);
      $client_arr = AyraHelp::getClientbyid($request->client_id);
      $company = optional($client_arr)->company;
      $phone = optional($client_arr)->phone;
      $name = optional($client_arr)->firstname;

      //-------


      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      //$sample->sample_code = $request->sample_id;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      // $sample->created_by = Auth::user()->id;
      $sample->created_by = $request->added_userid;
      $sample->created_by_ori = Auth::user()->id;

      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;
      //$sample->price_per_kg = $request->price_per_kg;
      $sample->sample_v = 1;
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->contact_phone = $request->contact_phone;

      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->status = 1;
      $sample->chkHandedOver = optional($request)->chkHandedOver;

      $sample->brand_type = $sampleBrandType;
      $sample->order_size = $sampleOrderSize;

      $sample->save();




      $i = 0;
      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );

        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id],
            [

              'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
              'item_info' => $sampleDiscription_Arr[$i],
              'sample_type' => $samplsampleType_Arr[$i],
              'price_per_kg' => $price_per_kg_Arr[$i],



            ]
          );
        $i++;
      }



      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done

      //event(new WhatIsHappening($sample));
      AyraHelp::setSampleLeadData(); // this function same lead data to sample table

      if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {


        //ajaj
        $ticket_id = $sample->id;


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

          $data_arr = array(
            'status' => 1,
            'msg' => 'Added  successfully'
          );

          $affected = DB::table('samples')
            ->where('id', $ticket_id)
            ->update([
              'sample_stage_id' => 2,

            ]);
          AyraHelp::setAllSampleAssinedNow_AP(); //auto assigned


        } else {
          $data_arr = array(
            'status' => 0,
            'Message' => 'Already Done'
          );
        }

        //ajaj
      }
      // AyraHelp::setAllSampleAssinedNow(); //auto assigned

      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );
    }
    return response()->json($res_arr);
  }


  public function sampleStoreNew26MAyOk(Request $request)
  {
    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleItemName_Arr = $request->sampleItemName;
      $sampleDiscription_Arr = $request->sampleDiscription;
      $samplsampleType_Arr = $request->sampleType;
      $price_per_kg_Arr = $request->price_per_kg;

      $ajata = array();
      $i = 0;
      $j = 0;

      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );
        $j++;
        $i++;
      }

      //$sample_data = json_encode($request->aj);
      $sample_data = json_encode($ajata);

      // $max_sample_index = Sample::max('sample_index')+1;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

      $sid_code = AyraHelp::getSampleIDCode();

      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      $ordercouT = AyraHelp::getClientHaveOrder($request->client_id);
      $client_arr = AyraHelp::getClientbyid($request->client_id);
      $company = optional($client_arr)->company;
      $phone = optional($client_arr)->phone;
      $name = optional($client_arr)->firstname;

      //-------


      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      //$sample->sample_code = $request->sample_id;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      // $sample->created_by = Auth::user()->id;
      $sample->created_by = $request->added_userid;
      $sample->created_by_ori = Auth::user()->id;

      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;
      //$sample->price_per_kg = $request->price_per_kg;
      $sample->sample_v = 1;
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->contact_phone = $request->contact_phone;

      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->status = 1;
      $sample->chkHandedOver = optional($request)->chkHandedOver;
      $sample->save();




      $i = 0;
      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],


        );

        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id],
            [

              'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
              'item_info' => $sampleDiscription_Arr[$i],
              'sample_type' => $samplsampleType_Arr[$i],
              'price_per_kg' => $price_per_kg_Arr[$i],

            ]
          );
        $i++;
      }



      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done

      //event(new WhatIsHappening($sample));
      AyraHelp::setSampleLeadData(); // this function same lead data to sample table

      if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {


        //ajaj
        $ticket_id = $sample->id;


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

          $data_arr = array(
            'status' => 1,
            'msg' => 'Added  successfully'
          );

          $affected = DB::table('samples')
            ->where('id', $ticket_id)
            ->update([
              'sample_stage_id' => 2,

            ]);
          AyraHelp::setAllSampleAssinedNow_AP(); //auto assigned


        } else {
          $data_arr = array(
            'status' => 0,
            'Message' => 'Already Done'
          );
        }

        //ajaj
      }
      // AyraHelp::setAllSampleAssinedNow(); //auto assigned

      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );
    }
    return response()->json($res_arr);
  }

  public function sampleStoreNewA(Request $request)
  {


    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {


      $sampleItemName_Arr = $request->sampleItemName;
      $sampleDiscription_Arr = $request->sampleDiscription;
      $samplsampleType_Arr = $request->sampleType;

      $ajata = array();
      $i = 0;
      $j = 0;

      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],

        );
        $j++;
        $i++;
      }

      //$sample_data = json_encode($request->aj);
      $sample_data = json_encode($ajata);

      // $max_sample_index = Sample::max('sample_index')+1;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

      $sid_code = AyraHelp::getSampleIDCode();

      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      $ordercouT = AyraHelp::getClientHaveOrder($request->client_id);
      $client_arr = AyraHelp::getClientbyid($request->client_id);
      $company = optional($client_arr)->company;
      $phone = optional($client_arr)->phone;
      $name = optional($client_arr)->firstname;

      //-------


      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      //$sample->sample_code = $request->sample_id;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      // $sample->created_by = Auth::user()->id;
      $sample->created_by = $request->added_userid;
      $sample->created_by_ori = Auth::user()->id;

      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;
      $sample->sample_v = 1;
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->contact_phone = $request->contact_phone;

      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->status = 1;
      $sample->chkHandedOver = optional($request)->chkHandedOver;
      $sample->save();




      $i = 0;
      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],

        );

        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id],
            [

              'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
              'item_info' => $sampleDiscription_Arr[$i],
              'sample_type' => $samplsampleType_Arr[$i],

            ]
          );
        $i++;
      }



      AyraHelp::setSampleFirstStage();

      //event(new WhatIsHappening($sample));
      AyraHelp::setSampleLeadData();

      //AyraHelp::setAllSampleAssinedNow(); //auto assigned

      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );
    }
    return response()->json($res_arr);
  }

  //samplestoreLeadv2

  public function samplestoreLeadv2(Request $request)
  {
    // echo "<pre>";
    // print_r($request->all());
    $sample_from;

    $is_paid = 0;
    $payment_id = null;
    if ($request->paidSample == 1) {
      $is_paid = 1;
      $payment_id = $request->paymentID;
    }
    $sampleIDModi = null;
    if ($request->sample_type == 5) {
      $sidCode = $request->sampleItemName[0];
      $samArrData = Sample::where('sample_code', $sidCode)->first();
      $sampleIDModi = $samArrData->id;
    }

    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleBrandType = $request->sampleBrandType;
      $sampleOrderSize = $request->sampleOrderSize;
      $sample_type = $request->sampleType;


      $txtSample_Name_Arr = $request->txtSample_Name;
      $txtSample_Cat_Arr = $request->txtSample_Cat;
      $txtSample_SubCat_Arr = $request->txtSample_SubCat;
      $txtSample_Fragrance_Arr = $request->txtSample_Fragrance;
      $txtSample_Color_Arr = $request->txtSample_Color;
      $txtSample_packType_Arr = $request->txtSample_packType;
      $txtSample_tprice_Arr = $request->txtSample_tprice;
      $txtSample_Info_Arr = $request->txtSample_Info;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;
      $ordercouT = 'NA';
      $LEAD_Data = DB::table('indmt_data')->select('SENDERNAME', 'GLUSR_USR_COMPANYNAME as company', 'MOB as phone')->where('QUERY_ID', $request->client_id)->first();

      //$LEAD_Data = DB::table('clients')->where('id', $request->client_id)->first();
      $name = $LEAD_Data->SENDERNAME;
      $phone = $LEAD_Data->phone;
      $company = $LEAD_Data->company;
      $added_userid = Auth::user()->id;

      $sid_code = AyraHelp::getSampleIDCodeBYUserID($added_userid);

      $ajata = array();
      $i = 0;
      $j = 0;
      $M = 0;

      foreach ($txtSample_Name_Arr as $key => $rowData) {
        $M++;
        $samples_category_Data = DB::table('samples_category')
          ->where('id', $txtSample_Cat_Arr[$i])
          ->first();
        $samples_SubCategory_Data = DB::table('samples_category_sub')
          ->where('id', $txtSample_SubCat_Arr[$i])
          ->first();
        $samples_PackType_Data = DB::table('samples_packing_type')
          ->where('id', $txtSample_packType_Arr[$i])
          ->first();
        //

        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $txtSample_Name_Arr[$i]),
          'txtDiscrption' => $txtSample_Info_Arr[$i],
          'sample_type' => $sample_type,
          'price_per_kg' => $txtSample_tprice_Arr[$i],
          'color' => $txtSample_Color_Arr[$i],
          'fragrance' => $txtSample_Fragrance_Arr[$i],
          'packing_type' => $txtSample_packType_Arr[$i],
          'packing_type_name' => $samples_PackType_Data->name,
          'sample_cat' => $samples_category_Data->name,
          'sample_sub_cat' => $samples_SubCategory_Data->name,
          'sample_cat_id' => $samples_category_Data->id,
          'sample_sub_cat_id' => $samples_SubCategory_Data->id,
          'sid_partby_code' => $sid_code . "-" . $M,
          'sid_partby_id' => $M,
          'sample_type' => $request->sampleType


        );
        $j++;
        $i++;
      }
      //------------------------------
      $sample_data = json_encode($ajata);


      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      //$ordercouT = AyraHelp::getClientHaveOrder($request->client_id);



      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      //$sample->created_by = Auth::user()->id;
      $sample->created_by = $added_userid;
      $sample->created_by_ori = Auth::user()->id;


      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;

      $sample->sample_v = 2; //new category wise 
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->QUERY_ID = $request->client_id;
      $sample->sample_from = 1; //added by lead
      $sample->chkHandedOver = $request->chkHandedOver; //added by lead
      $sample->status = 1;
      $sample->brand_type = $sampleBrandType;
      $sample->order_size = $sampleOrderSize;
      //$sample->sample_from_id = $request->client_id;
      $sample->contact_phone = $request->contact_phone;
      $sample->is_paid = $is_paid;
      $sample->payment_id = $payment_id;
      $sample->modi_sample_id = $sampleIDModi;
      $sample->save();  //save all data in db

      //----------------------------------
      //save to samples item
      $i = 0;
      foreach ($ajata as $key => $rowData) {


        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id, 'item_name' => $rowData['txtItem']],
            [

              'item_name' => $rowData['txtItem'],
              'item_info' => $rowData['txtDiscrption'],
              'sample_type' => $rowData['sample_type'],
              'price_per_kg' => $rowData['price_per_kg'],
              'sid_partby_code' => $rowData['sid_partby_code'],
              'sid_partby_id' => $rowData['sid_partby_id'],
              'brand_type' => $sampleBrandType,
              'order_size' => $sampleOrderSize,
              'sample_cat' => $rowData['sample_cat'],
              'sample_sub_cat' => $rowData['sample_sub_cat'],
              'sample_cat_id' => $rowData['sample_cat_id'],
              'sample_sub_cat_id' => $rowData['sample_sub_cat_id'],
              'sample_fragrance' => $rowData['fragrance'],
              'sample_color' => $rowData['color'],
              'sample_v' => 2,
              'stage_id' => 1,
              'admin_status' => 55,
              'txtSample_packType' => $rowData['packing_type'],
              'txtSample_packType_name' => $rowData['packing_type_name']

            ]
          );
        $i++;
        $lid = DB::getPdo()->lastInsertId();
        //save stages of child samples
        $ticket_id = $lid;
        DB::table('st_process_action_6v2')->insert(
          [
            'ticket_id' => $ticket_id,
            'process_id' => 6,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Auto Approval Item Add Lead API',
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
          ]
        );
        //save stages of child samples
      }

      //save to sample item
      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done
      if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {


        //ajaj
        $ticket_id = $sample->id;


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
      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );


      //-----   now update client statge also check client or not 


      //--------------------------------------------------------

    } //end of null


    return response()->json($res_arr);
  }
  //samplestoreLeadv2

  // save sample lead
  public function storeLead(Request $request)
  {
    $is_paid = 0;
    $payment_id = null;
    if ($request->paidSample == 1) {
      $is_paid = 1;
      $payment_id = $request->paymentID;
    }

    $max_sample_indexID = Sample::where('sample_code', $request->sample_id)->first();
    if ($max_sample_indexID == null) {

      $sampleItemName_Arr = $request->sampleItemName;
      $sampleDiscription_Arr = $request->sampleDiscription;
      $samplsampleType_Arr = $request->sampleType;
      $price_per_kg_Arr = $request->price_per_kg;
      $sampleBrandType = $request->sampleBrandType;
      $sampleOrderSize = $request->sampleOrderSize;


      $ajata = array();
      $i = 0;
      $j = 0;

      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );
        $j++;
        $i++;
      }

      //$sample_data = json_encode($request->aj);
      $sample_data = json_encode($ajata);

      // $max_sample_index = Sample::max('sample_index')+1;
      $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

      $sid_code = AyraHelp::getSampleIDCode();

      $this->validate($request, [
        'client_id' => 'required|max:120',
      ]);
      //$ordercouT = AyraHelp::getClientHaveOrder($request->client_id);
      $ordercouT = 'NA';
      $LEAD_Data = DB::table('indmt_data')->select('SENDERNAME', 'GLUSR_USR_COMPANYNAME as company', 'MOB as phone')->where('QUERY_ID', $request->client_id)->first();

      $name = $LEAD_Data->SENDERNAME;
      $phone = $LEAD_Data->phone;
      $company = $LEAD_Data->company;
      //-------


      $sample = new Sample;
      $sample->sample_index = $max_sample_index;
      $sample->sample_code = $sid_code;
      $sample->yr = date('Y');
      $sample->mo = date('m');
      $sample->sample_details = $sample_data;
      $sample->client_id = $request->client_id;
      //$sample->created_by = Auth::user()->id;
      $sample->created_by = $request->added_userid;
      $sample->created_by_ori = Auth::user()->id;


      $sample->remarks = $request->remarks;
      $sample->ship_address = $request->client_address;
      $sample->location = $request->location;

      $sample->sample_v = 1;
      $sample->lead_name = $name;
      $sample->lead_phone = $phone;
      $sample->lead_company = $company;
      $sample->order_count = $ordercouT;
      $sample->sample_type = optional($request)->sample_type;
      $sample->QUERY_ID = $request->client_id;
      $sample->sample_from = $request->sample_from; //added by lead
      $sample->chkHandedOver = $request->chkHandedOver; //added by lead
      $sample->status = 1;
      $sample->is_paid = $is_paid;
      $sample->payment_id = $payment_id;
      $sample->brand_type = $sampleBrandType;
      $sample->order_size = $sampleOrderSize;

      $sample->save();
      $i = 0;
      foreach ($sampleItemName_Arr as $key => $rowData) {
        $ajata[] = array(
          'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
          'txtDiscrption' => $sampleDiscription_Arr[$i],
          'sample_type' => $samplsampleType_Arr[$i],
          'price_per_kg' => $price_per_kg_Arr[$i],

        );

        DB::table('sample_items')
          ->updateOrInsert(
            ['sid' => $sample->id, 'item_name' => $rowData[$i]],
            [

              'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
              'item_info' => $sampleDiscription_Arr[$i],
              'sample_type' => $samplsampleType_Arr[$i],
              'price_per_kg' => $price_per_kg_Arr[$i],

            ]
          );
        $i++;
      }


      AyraHelp::setSampleFirstStage(); //first stage complete as soon as done

      //event(new WhatIsHappening($sample));
      AyraHelp::setSampleLeadData(); // thos function same lead data to sample table

      // AyraHelp::setAllSampleAssinedNow(); //auto assigned

      if (Auth::user()->id == 3 || Auth::user()->id == 40 || Auth::user()->id == 76 || Auth::user()->id == 142 || Auth::user()->id == 102) {


        //ajaj
        $ticket_id = $sample->id;


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

          $data_arr = array(
            'status' => 1,
            'msg' => 'Added  successfully'
          );

          $affected = DB::table('samples')
            ->where('id', $ticket_id)
            ->update([
              'sample_stage_id' => 2,

            ]);
          //AyraHelp::setAllSampleAssinedNow_AP(); //auto assigned
          //AyraHelp::setSampleAssinedThisAsNow($ticket_id); //auto assigned 



        } else {
          $data_arr = array(
            'status' => 0,
            'Message' => 'Already Done'
          );
        }

        //ajaj
      }


      // event(new WhatIsHappening($sample));
      $res_arr = array(
        'status' => 1,
        'Message' => 'Data saved successfully.',
      );
    } else {
      $res_arr = array(
        'status' => 2,
        'Message' => 'Data saved successfully.',
      );
    }
    return response()->json($res_arr);
  }

  // save sample lead



  public function storeLead2SEP(Request $request)
  {
    //print_r($request->all());
    $sample_data = json_encode($request->aj);
    $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;
    $sid_code = AyraHelp::getSampleIDCode();
    $this->validate($request, [
      'client_id' => 'required|max:120',
    ]);

    $sample = new Sample;
    $sample->sample_index = $max_sample_index;
    $sample->sample_code = $sid_code;
    $sample->yr = date('Y');
    $sample->mo = date('m');
    $sample->sample_details = $sample_data;
    $sample->client_id = $request->client_id;
    $sample->created_by = Auth::user()->id;
    $sample->remarks = $request->remarks;
    $sample->ship_address = $request->client_address;
    $sample->location = $request->location;
    $sample->status = 1;
    $sample->status = 1;

    $sample->QUERY_ID = $request->client_id;
    $sample->sample_from = $request->sample_from; //added by lead

    $sample->save();

    $res_arr = array(
      'status' => 1,
      'Message' => 'Sample Added  successfully.',
    );



    return response()->json($res_arr);
  }
  public function store(Request $request)
  {

    $sample_data = json_encode($request->aj);
    // $max_sample_index = Sample::max('sample_index')+1;
    $max_sample_index = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

    $sid_code = AyraHelp::getSampleIDCode();

    $this->validate($request, [
      'client_id' => 'required|max:120',
    ]);

    $sample = new Sample;
    $sample->sample_index = $max_sample_index;
    $sample->sample_code = $sid_code;
    //$sample->sample_code = $request->sample_id;
    $sample->yr = date('Y');
    $sample->mo = date('m');
    $sample->sample_details = $sample_data;
    $sample->client_id = $request->client_id;
    $sample->created_by = Auth::user()->id;
    $sample->remarks = $request->remarks;
    $sample->ship_address = $request->client_address;
    $sample->location = $request->location;
    $sample->status = 1;
    $sample->save();
    event(new WhatIsHappening($sample));
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $sample_data = Sample::where('id', $id)->first();

    if ($sample_data->sample_from == 1) {
      $client_data = DB::table('indmt_data')
        ->where('indmt_data.QUERY_ID', '=', $sample_data->QUERY_ID)
        ->first();
    } else {
      $client_data = Client::where('id', $sample_data->client_id)->first();
    }




    //
    // $user = auth()->user();
    // if($user->hasAnyPermission(['view-all-notes'])){
    //   $client_notes=ClientNote::where('clinet_id',$id)->orderBy('id', 'desc')->get();
    // }else{
    //   $client_notes=ClientNote::where('clinet_id',$id)->where('user_id',Auth::user()->id)->orderBy('id', 'desc')->get();
    // }

    $data = ['client_data' => $client_data, 'sample_data' => $sample_data];
    return $theme->scope('sample.view', $data)->render();
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($EncID)
  {
    $id = AyraHelp::AyraEnCrypt($EncID);

    $theme = Theme::uses('corex')->layout('layout');
    $sample = Sample::where('id', $id)->first();
    if ($sample->sample_from == 1) {

      $client = DB::table('indmt_data')
        ->where('indmt_data.QUERY_ID', '=', $sample->QUERY_ID)
        ->first();
    } else {
      $client = Client::where('id', $sample->client_id)->first();
    }

    $data = [
      'usersdata' => $client,
      'samples' => $sample,
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead') {
      //return $theme->scope('sample.editV1', $data)->render();
      return $theme->scope('sample.editV2', $data)->render();
    } else {
      //return $theme->scope('sample.edit', $data)->render();
      return $theme->scope('sample.editV2', $data)->render();
    }
  }
  public function edit_($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $sample = Sample::where('id', $id)->first();
    $client = Client::where('id', $sample->client_id)->first();
    $data = [
      'usersdata' => $client,
      'samples' => $sample,
    ];
    return $theme->scope('sample.edit', $data)->render();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function samples_update(Request $request)
  {


    $sample = Sample::find($request->sample_id);
    $sample->client_name = $request->clinet_name;
    $sample->sample_details = $request->sample_details;
    $sample->courier_details = $request->courier_details;
    $sample->track_id = $request->track_id;
    $sample->status =  $request->status;
    $sample->remarks =  $request->remarks;
    $sample->ship_address = $request->client_address;
    $sample->save();
    return redirect()->route('users.sampleList')
      ->with(
        'flash_message',
        'Sample successfully updated.'
      );
  }

  public function update(Request $request, $id)
  {
    $is_paid = 0;
    $payment_id = null;
    if ($request->paidSample == 1) {
      $is_paid = 1;
      $payment_id = $request->paymentID;
    }


    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $sent_datev = date("Y-m-d", strtotime($request->sent_on));
    $sample = Sample::find($id);
    if ($request->sample_from == 1) {
    } else {
      $sample->client_id = $request->client_id;
    }

    //json_encode($request->aj)
    $sampleItemName_Arr = $request->sampleItemName;
    $sampleDiscription_Arr = $request->sampleDiscription;
    $samplsampleType_Arr = $request->sampleType;
    $price_per_kg_Arr = $request->price_per_kg;

    $sampleBrandType = $request->sampleBrandType;
    $sampleOrderSize = $request->sampleOrderSize;



    $ajata = array();
    $i = 0;
    $j = 0;


    foreach ($sampleItemName_Arr as $key => $rowData) {
      $ajata[] = array(
        'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
        'txtDiscrption' => $sampleDiscription_Arr[$i],
        'sample_type' => $samplsampleType_Arr[$i],
        'price_per_kg' => $price_per_kg_Arr[$i],

      );
      $j++;
      $i++;
    }
    $sample_details = json_encode($ajata);

    $sample->sample_details = $sample_details;
    $sample->remarks =  $request->remarks;
    $sample->ship_address = $request->client_address;
    $sample->location = $request->location;
    $sample->chkHandedOver = $request->chkHandedOver;
    //$sample->is_rejected = 0;

    $sample->remarks = $request->remarks;
    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $sample->courier_id = $request->courier_id;
      $sample->sent_on = $sent_datev;
      $sample->status = $request->sample_status;
      $sample->track_id = $request->track_id;
      $sample->courier_remarks = $request->courier_remarks;
    }
    $sample->brand_type = $sampleBrandType;
    $sample->order_size = $sampleOrderSize;
    $sample->is_paid = $is_paid;
    $sample->payment_id = $payment_id;
    $sample->save();

    $i = 0;


    DB::table('sample_items')->where('sid', $sample->id)->delete();

    foreach ($sampleItemName_Arr as $key => $rowData) {
      $ajata[] = array(
        'txtItem' => str_replace("97116", "", $sampleItemName_Arr[$i]),
        'txtDiscrption' => $sampleDiscription_Arr[$i],
        'sample_type' => $samplsampleType_Arr[$i],
        'price_per_kg' => $price_per_kg_Arr[$i],

      );

      DB::table('sample_items')
        ->updateOrInsert(
          ['sid' => $sample->id, 'item_name' => $sampleItemName_Arr[$i]],
          [

            'item_name' => str_replace("97116", "", $sampleItemName_Arr[$i]),
            'item_info' => $sampleDiscription_Arr[$i],
            'sample_type' => $samplsampleType_Arr[$i],
            'price_per_kg' => $price_per_kg_Arr[$i],


          ]
        );
      $i++;
    }

    $res_arr = array(
      'status' => 1,
      'Message' => 'Data updated successfully.',
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
  public function delete_sample($id)
  {
    // $sample = Sample::find($id);
    // $sample->delete();
    $flight = Sample::find($id);
    $flight->is_deleted = 1;
    $flight->save();

    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;


    $eventName = "Sample DELETE";
    $eventINFO = 'Sample ID :' . $id . " and deleted by  " . $LoggedName;
    $eventID = $id;
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




    return redirect()->route('sample.index')
      ->with(
        'flash_message',
        'Sample successfully deleted.'
      );
  }
  public function edit_sample($userid, $id)
  {
    $theme = Theme::uses('staff')->layout('layout');
    $sample_data = Sample::where('id', $id)
      ->where('created_by', $userid)
      ->get();


    $users = User::where('created_by', $userid)->get();
    $data = ['samples' => $sample_data, 'users' => $users];
    return $theme->scope('sample.edit', $data)->render();
  }
  public function edit_samples_($id)
  {
    $theme = Theme::uses('admin')->layout('layout');
    $sample_data = Sample::where('id', $id)
      ->where('created_by', Auth::user()->id)
      ->get();
    $users = User::where('created_by', Auth::user()->id)->get();
    $data = ['samples' => $sample_data, 'users' => $users];
    return $theme->scope('users.edit_sample', $data)->render();
  }
  public function edit_samples($id)
  {
    $theme = Theme::uses('admin')->layout('layout');
    $data = ['samples' => $id, 'users' => '33'];
    return $theme->scope('users.edit_sample', $data)->render();
  }
}
