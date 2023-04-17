<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Client;
use App\OrderItemMaterial;
use App\OrderMasterV1;
use App\ItemMaster;
use App\ItemMasterType;
use App\Item;
use ImageOptimizer;
use App\ItemStock;
use App\POCatalogData;
use App\ItemCat;
use App\ItemStockEntry;
use App\PurchaseItemRequest;
use App\PurchaseItemRequested;
use App\PurchaseItemGroup;
use App\OrderEditRequest;
use App\OrderDispatchData;
use App\OrderMaster;
use App\QC_ProductionLog;
use App\OPHAchieved;

use App\QCFORM;
use Khill\Lavacharts\Lavacharts;
use App\QCBOM;
use App\QC_BOM_Purchase;
use App\QC_BOM_PurchaseLog;
use App\QCPurchaseEditHistory;
use App\SAP_CHECKLISt;



use App\OPDaysBulk;
use App\OPDaysRepeat;
use App\OPDays;
use App\QCPP;
use Carbon\Carbon;
use App\ItemStockReserved;
use App\OPData;
use App\QCBULK_ORDER;
use App\OPDataLog;
use App\PurchaseOrderRecieved;
use Auth;
use Illuminate\Http\Request;
use App\Helpers\AyraHelp;
use DB;
use Theme;
use Mail;
use Pusher;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{

  public function __construct()
  {
    $this->middleware(['auth', 'isAdmin'])->except(['samples']);
  }


  //saveLeadQCdata
  public function saveLeadQCdata(Request $request)
  {

    //getOrderCODE_OIL
    

    $orderEntry = $request->orderEntry;
    if ($orderEntry == 'fresh') {
      
      if($request->order_type==1){
        //$order_id = AyraHelp::getOrderCODE();
      }else{
       // $order_id = AyraHelp::getOrderCODE_OIL();
      }
      $order_id = AyraHelp::getOrderCODE();
     
      $order_index = AyraHelp::getOrderCODEIndex();
      $subOrder = 1;
    } else {
      $rcorder_arr = QCFORM::where('order_id', $request->order_id)->get();
      $order_id = $request->order_id;
      $order_index = $request->txtOrderIndex;
      $subOrder = count($rcorder_arr) + 1;
    }
    if($request->order_type==1){
       
    }else{
      $order_id= str_replace("O","MX",$order_id);
    }

    // START:Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form

    if ($request->txtOrderTypeNew == 2) {

      $qcformObj = new QCFORM;
      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->client_from = 1; //0=client 1=lead             

      $qcformObj->created_by = $request->order_crated_by;
      $qcformObj->created_by_name = AyraHelp::getUser($request->order_crated_by)->name;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->qc_from_bulk = 1;
      $qcformObj->bulkOrderTypeV1 = $request->bulkOrderTypeV1;

      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_bulk_N);

      $qcformObj->item_sp = 0;


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';
      $otStr = 'Bulk';
      $qcformObj->order_type = 'Bulk';

      $qcformObj->batch_no = $order_id.'-'.$subOrder;
      // $qcformObj->batch_no_mfg = $request->batch_no_mfg;
      // $qcformObj->batch_no_exp_date = $request->batch_no_exp_date;
      $qcformObj->batch_no_mrp = $request->item_batch_mrp;
      $qcformObj->batch_no_per_ml = $request->item_batch_mrp;


      $qcformObj->order_type_v1 = $request->order_type_v1;
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk_bulk;
      $qcformObj->packeging_rmk = $request->packeging_rmk_bulk;


      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();
      $fomr_id = $qcformObj->id;

      $bsp = 0;
      $itemQty = 0;
      $qcBulkOrder_arr = $request->qcBulkOrder;
      $aj = 0;
      $arryBulkITEM = array();
      foreach ($qcBulkOrder_arr as $key => $boRow) {
        $aj++;
        $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $itemQty = $itemQty + $boRow['bulkItem_qty'];
        $qcbolkObj = new QCBULK_ORDER;
        $qcbolkObj->form_id = $fomr_id;
        $qcbolkObj->item_name = $boRow['bulk_material_name'];
        $qcbolkObj->qty = $boRow['bulkItem_qty'];
        $qcbolkObj->rate = $boRow['bulk_rate'];
        $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
        $qcbolkObj->packing = $boRow['bulk_packing'];
        $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $qcbolkObj->save();
        $arryBulkITEM[] = array(
          'item_name' => $boRow['bulk_material_name'],
          'qty' => $boRow['bulkItem_qty'],
          'rate' => $boRow['bulk_rate'],
          'item_size' => $boRow['bulk_sizeUnit'],
          'packing' => $boRow['bulk_packing'],
          'item_sell_p' => ($boRow['bulk_rate']) * ($boRow['bulkItem_qty'])

        );
      }

      $bulkB=intVal($bsp);
     if($bulkB>0){
      QCFORM::where('form_id', $fomr_id)
      ->update(['builk_item_data' => json_encode($arryBulkITEM), 'bulk_order_value' => $bsp, 'item_qty' => $itemQty, 'bo_bulk_cound' => $aj++]);
     }else{
      QCFORM::where('form_id', $fomr_id)
      ->update(['builk_item_data' => json_encode($arryBulkITEM), 'bulk_order_value' => $bsp, 'item_qty' => $itemQty, 'bo_bulk_cound' => $aj++,'is_deleted'=>1]);

     }
      // QCFORM::where('form_id', $fomr_id)
      //   ->update(['builk_item_data' => json_encode($arryBulkITEM), 'bulk_order_value' => $bsp, 'item_qty' => $itemQty, 'bo_bulk_cound' => $aj++]);

      // olde stage
      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();


    
      // olde stage


      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );

      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 9,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 0,
        ]
      );

      //Stop :save on stage
      //save lead stage client if added order 
      $data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 4)->where('action_on', 1)->first();
      if ($data == null) {
        DB::table('st_process_sales_lead_v1')->insert(
          [
            'ticket_id' => $request->client_id,
            'process_id' => 7,
            'stage_id' => 4,
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
            'lead_statge' => 4,

          ]);
      }
      //save lead stage client if added order 


      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );

      return response()->json($res_arr);
    }
    // STOP Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form
    //22 OCT 2019
    //START save old bulk and private order
    //save data
    $ot = $request->order_type;
    if ($ot == 1) {
      $otStr = 'Private Label';
    } else {
      $otStr = 'Bulk';
    }
    $qcformObj = new QCFORM;

    $qcformObj->order_id = $order_id;
    $qcformObj->order_index = $order_index;
    $qcformObj->subOrder = $subOrder;

    $qcformObj->client_id = $request->client_id;
    $qcformObj->client_from = 1; //0=client 1=lead         
    // $qcformObj->client_from_id = $request->client_id;

    $qcformObj->created_by = $request->order_crated_by;
    $qcformObj->created_by_name = AyraHelp::getUser($request->order_crated_by)->name;
    
    $qcformObj->created_by_ori = Auth::user()->id;
    $qcformObj->brand_name = $request->brand;
    $qcformObj->subOrder = $subOrder;
    $qcformObj->yr = date('Y');
    $qcformObj->mo = date('m');
    $qcformObj->order_repeat = $request->order_repeat;
    $qcformObj->pre_order_id = $request->pre_orderno;
    $qcformObj->item_name = ucwords($request->item_name);
    $qcformObj->item_size = ucwords($request->item_size);
    $qcformObj->item_size_unit = ucwords($request->item_size_unit);

    $qcformObj->item_qty = $request->item_qty;
    $qcformObj->item_qty_unit = $request->item_qty_unit;
    $bomqty_aj = $request->item_qty;

    $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no_bulk_N);

    $qcformObj->item_sp = $request->item_selling_price;
    $qcformObj->item_sp_unit = $request->item_selling_UNIT;


    $qcformObj->design_client = '';
    $qcformObj->bottle_jar_client = '';
    $qcformObj->lable_client = '';

    $qcformObj->order_type = $otStr;
      $qcformObj->batch_no = $order_id.'-'.$subOrder;
      // $qcformObj->batch_no_mfg = $request->batch_no_mfg_PL;
      // $qcformObj->batch_no_exp_date = $request->batch_no_exp_date_PL;
      $qcformObj->batch_no_mrp = $request->item_batch_mrp_PL;
      $qcformObj->batch_no_per_ml = $request->item_batch_mrp_ml_PL;

    $qcformObj->order_type_v1 = $request->order_type_v1;
    $qcformObj->due_date = $request->due_date;
    $qcformObj->commited_date = $request->commited_date;
    $qcformObj->production_rmk = $request->production_rmk;
    $qcformObj->packeging_rmk = $request->packeging_rmk;
    $qcformObj->export_domestic = $request->order_for;
    $qcformObj->order_currency = $request->currency;
    $qcformObj->exchange_rate = $request->conv_rate;
    $qcformObj->order_fragrance = $request->order_fragrance;
    $qcformObj->order_color = $request->order_color;
    $qcformObj->order_composition = $request->order_composition;
    $qcformObj->order_print_quality = $request->order_print_quality;
    $qcformObj->mfg_location = $request->mfg_location;

    $qcformObj->artwork_approval_status = $request->artwork_approval_status;
    $qcformObj->dispatch_status = 1;
    if ($otStr == 'Bulk' || $request->order_repeat == 2) {
      $qcformObj->artwork_status = 1;
      $action_start = 1;
      $step_code_may = 'PRODUCTION';
    } else {
      if ($ot == 1 && $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
      } else {
        $qcformObj->artwork_status = 0;
      }

      $action_start = 0;
      $step_code_may = 'ART_WORK_REVIEW';
    }
    $qcformObj->artwork_start_date = date('Y-m-d');

    // new price 
   

    $qcformObj->save();

    $fomr_id = $qcformObj->id;


    //  form image upload
    if ($request->hasfile('fileAA')) {
      $file = $request->file('file');
      $img = Image::make($request->file('file'));
      // resize image instance
      $img->resize(320, 240);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
    }
    if ($request->hasfile('file')) {

      $filename = '';

      $file = $request->file('file');
      $filename =  rand(10, 100) . Auth::user()->id . "img" .  date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);


      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'local/public/uploads/photos/' . $filename]);
    }
    if ($request->hasfile('file_PO')) {

      $filename = '';

      $file = $request->file('file_PO');
      $filename =  rand(10, 100) . Auth::user()->id . "imgPO" .  date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);


      QCFORM::where('form_id', $fomr_id)
        ->update(['po_img_url' => 'local/public/uploads/photos/' . $filename]);
    }

    if ($request->hasfile('file_comp')) {
      $file = $request->file('file_comp');
      $img = Image::make($request->file('file_comp'));
      // resize image instance
      $img->resize(320, 240);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "img_file_comp" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      QCFORM::where('form_id', $fomr_id)
        ->update(['order_composition_img' => 'uploads/qc_form/' . $filename]);
    }

    //  form image upload

    $qc_bom_arr = $request->qc;

    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Box';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_box;
    $qcBOMObj->bom_cat = 'BOX';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_box == 'Order') {
        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'BOX';
        $qcbomPObj->material_name = 'Printed Box';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }


    // if printed box and level is order


    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Label';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_label;
    $qcBOMObj->bom_cat = 'LABEL';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_label == 'Order') {

        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'LABEL';
        $qcbomPObj->material_name = 'Printed Label';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }



    // if printed box and level is order





    foreach ($qc_bom_arr as $key => $value) {
      $bom = $value['bom'];
      $bom_qty = $value['bom_qty'];
      $bom_cat = $value['bom_cat'];

      if (isset($value['bom_from'])) {
        $client_bom_from = 'From Client';
      } else {
        $client_bom_from = '';
      }

      $bom_size = '';
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = $bom;
      $qcBOMObj->qty = $bom_qty;
      $qcBOMObj->size = $bom_size;
      $qcBOMObj->bom_from = $client_bom_from;
      $qcBOMObj->bom_cat = $bom_cat;
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();



      //save data to QC_BOM_Purchase:qc_bo_purchaselist
      if (isset($bom)) {
        if (isset($value['bom_from'])) {
          // $client_bom_from='FromClient';
        } else {
          if ($ot == 1 && $request->order_repeat == 1) {
          } else {

            if ($client_bom_from == 'FromClient' || $client_bom_from == 'FromClient') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $order_id;
              $qcbomPObj->form_id = $fomr_id;
              $qcbomPObj->sub_order_index = $subOrder;
              $qcbomPObj->order_name = $request->brand;
              $qcbomPObj->order_cat = $bom_cat;
              $qcbomPObj->material_name = $bom;
              $qcBOMObj->bom_from = $client_bom_from;
              $qcbomPObj->qty = $bom_qty;
              $qcbomPObj->created_by = Auth::user()->id;
              $qcbomPObj->save();
            }
          }
        }
      }

      //save data to QC_BOM_Purchase:qc_bo_purchaselist
    }




    switch ($request->f_1) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_2) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_3) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_4) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------

    //-----------------------
    //-----------------------
    switch ($request->f_5) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_6) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_7) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_8) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_9) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_10) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'TAMPER PROOFING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'TAMPER PROOFING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'TAMPER PROOFING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }

    //STOP :save old bulk and private order

    // now check if order is bulk  start
    if ($ot == 1) {
      //$otStr='Private Label';
      if ($request->order_repeat == 2) {

        if ($request->printed_label == 'From Client' && $request->printed_box == 'From Client') {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 3;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          //Stop :save on stage


          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 3,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 4,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 0,
            ]
          );

          //Stop :save on stage


        } else {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();



          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 1,
            ]
          );

          //Stop :save on stage

        }
      } else {
        // Start :save on stage
        DB::table('st_process_action')->insert(
          [
            'ticket_id' => $fomr_id,

            'process_id' => 1,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Auto s Completed :DP:1',
            'attachment_id' => 0,
            'assigned_id' => Auth::user()->id,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
            'action_mark' => 0,
            'action_status' => 0,
          ]
        );
        //Stop :save on stage
      }
    } else {

      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();



      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );
      //Stop :save on stage

    }

    //save data

    //check order is bulk and repeat if yes then add to order master model
    // $this->saveToOrderMaster($fomr_id, Auth::user()->id, $step_code_may, Auth::user()->id, $action_start);

    //if check then save BOM
    $artworkChK = DB::table('qc_forms')
      ->where('form_id', $fomr_id)
      ->where('artwork_approval_status', 1)
      ->first();
    $form_id = $fomr_id;
    //  if statge is first then save to bom
    if ($artworkChK != null) {

      $qcboms = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
      foreach ($qcboms as $key => $qcbom) {
        if ($qcbom->bom_from != 'From Client') {
          $myqc_data = AyraHelp::getQCFormDate($form_id);
          if ($qcbom->bom_from == 'N/A' || $qcbom->bom_from == 'From Client' || $qcbom->bom_from == 'FromClient') {
          } else {
            $qcbomPObj = new QC_BOM_Purchase;
            $qcbomPObj->order_id = $myqc_data->order_id;
            $qcbomPObj->form_id = $form_id;
            $qcbomPObj->sub_order_index = $myqc_data->subOrder;
            $qcbomPObj->order_name = $myqc_data->brand_name;
            $qcbomPObj->order_cat = $qcbom->bom_cat;
            $qcbomPObj->material_name = $qcbom->m_name;
            $qcbomPObj->qty = $qcbom->qty;
            $qcbomPObj->created_by = Auth::user()->id;
            $qcbomPObj->save();
          }
        }
      }

      //update status of
      QCFORM::where('form_id', $form_id)
        ->update([
          'artwork_status' => 1
        ]);
      //now skpi purchase and set to art review

      //now skpi purchase and set to art review
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $form_id,
          'dependent_ticket_id' => 0,
          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto Update by checkbox',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );

      //now update stage name and stage id and since

      $data = AyraHelp::getProcessCurrentStage(1, $form_id);
      $Spname = $data->stage_name;
      $stage_id = $data->stage_id;
      $days_stayFrom = AyraHelp::getStayFromOrder($form_id);

      $affected = DB::table('qc_forms')
        ->where('form_id', $form_id)
        //->whereNull('curr_stage_id')
        ->update([
          'curr_stage_id' => $stage_id,
          'curr_stage_name' => $Spname,
          'curr_stage_updated_on' => $days_stayFrom
        ]);

      //now update stage name and 



    }
    //  if statge is first


    //if check then save BOM
    //save lead stage client if added order 
    $data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->client_id)->where('process_id', 7)->where('stage_id', 4)->where('action_on', 1)->first();
    if ($data == null) {
      DB::table('st_process_sales_lead_v1')->insert(
        [
          'ticket_id' => $request->client_id,
          'process_id' => 7,
          'stage_id' => 4,
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
          'lead_statge' => 4,

        ]);
    }
    //save lead stage client if added order 

    $res_arr = array(
      'order_id' => $order_id,
      'order_index' => $order_index,
      'subOrder' => $subOrder,
      'Message' => 'Item added  successfully ',
    );
    return response()->json($res_arr);
  }
  //saveLeadQCdata

  public function getSaleLeadStages(Request $request)
  {
    $ticket_id = $request->form_id;

    $process_id = 7;



    return AyraHelp::getMasterStageResponseSALESLEAD($process_id, $ticket_id);
  }

  //getSamplewiswOrderByChemist
  public function getSamplewiswOrderByChemist(Request $request)
  {
      $userid=$request->userid;
     $txtMonth=$request->txtMonth;
     $txtyear=$request->txtyear;

    $dateStar=$txtyear."-".$txtMonth."%";

    


     $samplesArr = DB::table('samples')
            ->where('is_formulated', 1)
            ->where('assingned_to', $userid)
            ->whereMonth('assingned_on',$txtMonth)
            ->whereYear('assingned_on',$txtyear)
            ->get();

      $sampleArrData=array();
      foreach ($samplesArr as $key => $rowData) {

        $qcFormArr = DB::table('qc_forms')
        ->where('is_deleted', 0)        
        ->where('item_fm_sample_no','like',"%".$rowData->sample_code."%")
        ->count();
        $qcFormArrData = DB::table('qc_forms')
        ->where('is_deleted', 0)        
        ->where('item_fm_sample_no','like',"%".$rowData->sample_code."%")
        ->get();
        $arayOrderArr=array();
        foreach ($qcFormArrData as $key => $row) {
          $arayOrderArr[]=array(
            'order_id'=>$row->order_id."".$row->subOrder,
            
          );
        }

        $sampleArrData[]=array(
          'sample_code'=>$rowData->sample_code,
          'assingned_name'=>$rowData->assingned_name,
          'assingned_on'=>$rowData->assingned_on,
          'orderCount'=>$qcFormArr,
          'orderDetails'=>json_encode($arayOrderArr),

        );
       

      }

      $html='<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
      <thead>
        <tr>
          <th>#</th>
          <th>Sample Code</th>
          <th>Chemist Name</th>
          <th>Assinged on</th>
          <th>Order Count </th>
          <th>Order Details </th>
        </tr>
      </thead>
      <tbody>';
$i=0;

$ordeStra="";

      foreach ($sampleArrData as $key => $rowData) {
        $i++;

        //  $orderArr=json_decode($rowData->orderDetails);
         //print_r($rowData);
        $daraArr=json_decode($rowData['orderDetails']);
        if(!empty($daraArr)){
         

         
          foreach ($daraArr as $key => $row) {
            $ordeStra.=$row->order_id."<br>";
          }

        }else{
         $ordeStra="";
        }


      //   if (array_key_exists('orderDetails', $rowData)) {
      //     echo "The 'first' element is in the array";
         
      //     //$orderArr=json_decode($rowData->orderDetails);
      //      print_r($rowData);

      // }else{
      //   echo "no";
      // }


        
       

        // if($arrD>0){
        //   echo "55";
        //   die;
        //   $orderArr=json_decode($rowData->orderDetails);

         
        //   foreach ($orderArr as $key => $row) {
        //     $ordeStra.=$row['order_id'];
        //   }
        // }
       
        

        $html .='<tr>
        <th scope="row">'.$i.'</th>
        <td>'.$rowData['sample_code'].'</td>
        <td>'.$rowData['assingned_name'].'</td>
        <td>'.$rowData['assingned_on'].'</td>
        <td>'.$rowData['orderCount'].'</td>
        <td>'.$ordeStra.'</td>
      </tr>';

      }
      $html .='</tbody>
      </table>';
     echo $html;
    
     



  }
  //getSamplewiswOrderByChemist

  //editChemOrder
  public function editChemOrder($lid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'user_id' => $lid
    ];


    return $theme->scope('users.chemistListOrder', $data)->render();
  }
  //editChemOrder
  //editChem
  public function editChem($lid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'user_id' => $lid
    ];


    return $theme->scope('users.chemistList', $data)->render();
  }

  //editChem


  //leadSalesInvoiceRequst
  public function leadSalesInvoiceRequst($lid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_form_id' => $lid
    ];


    return $theme->scope('orders.v1.SalesInvoiceRequestConfirmationV1', $data)->render();
  }

  //leadSalesInvoiceRequst


  //setSaveProcessActionSalesLead
  public function setSaveProcessActionSalesLead(Request $request)
  {
    $form_id = $request->txtTicketID;
    // code
    $data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();


    if ($data == null) {

      if ($request->txtStage_ID == 4) {

        // $affected = DB::table('clients_as_lead')
        //   ->where('id', $request->txtTicketID)
        //   ->update([
        //     'is_client_active' => 1,

        //   ]);
      }
      if ($request->txtStage_ID == 3) {

        // $affected = DB::table('clients_as_lead')
        //   ->where('id', $request->txtTicketID)
        //   ->update([
        //     'is_sample_active' => 1,

        //   ]);

        $dataA = DB::table('st_process_sales_lead_v1')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', 2)->where('action_on', 1)->first();

        if ($dataA == null) {
          DB::table('st_process_sales_lead_v1')->insert(
            [
              'ticket_id' => $request->txtTicketID,
              'process_id' => $request->txtProcessID,
              'stage_id' => 2,
              'action_on' => $request->action_on,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Qualified by Sample Stage',
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
      }


      DB::table('st_process_sales_lead_v1')->insert(
        [
          'ticket_id' => $request->txtTicketID,
          'process_id' => $request->txtProcessID,
          'stage_id' => $request->txtStage_ID,
          'action_on' => $request->action_on,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => $request->txtRemarks,
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
        ->where('id', $request->txtTicketID)
        ->update([
          'lead_statge' => $request->txtStage_ID,

        ]);

      $data_arr = array(
        'status' => 1,
        'msg' => 'Submitted  successfully'
      );
    } else {
      $data_arr = array(
        'status' => 0,
        'msg' => 'Already Done'
      );
    }


    return response()->json($data_arr);

    //code 
  }
  // qcformLead
  public function qcformLead($lid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'data' => $lid
    ];
    return $theme->scope('sample.qc_createSalesLead', $data)->render();
  }

  //qcformLead
  //getBulkOrders
  public function getBulkOrders(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    // $user = auth()->user();
    // $userRoles = $user->getRoleNames();
    // $user_role = $userRoles[0];
    if (Auth::user()->id == 146 || Auth::user()->id == 27) {
      return $theme->scope('orders.v1.bulkOrders', $data)->render();
    }
    return $theme->scope('orders.v1.bulkOrders', $data)->render();
  }

  //getBulkOrders

  // getPayOrderApprovalList
  public function getPayOrderApprovalList(Request $request)
  {
    $rowID = $request->rowID;
    $payment = DB::table('payment_recieved_from_client')->select('client_id')->where('id', $rowID)->first();




    $date_from = '2019-03-12 16:00:00';


    $paymentOrderArr = DB::table('qc_forms')->where('created_at', '>=', $date_from)->where('account_approval', 0)->where('client_id', $payment->client_id)->get();
    $qc_Data = array();
    foreach ($paymentOrderArr as $key => $rowData) {
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));



      $qc_Data[] = array(
        'order_id' => $rowData->order_id . "/" . $rowData->subOrder,
        'client_name' => AyraHelp::getClientbyid($rowData->client_id)->firstname,
        'created_at' => $created_on,
        'accountNote' => is_null($rowData->account_msg) ? "" : optional($rowData)->account_msg,
        'created_by' => AyraHelp::getUser($rowData->created_by)->name,
        'qc_link' => AyraHelp::getUser($rowData->created_by)->name,
        'form_id' => $rowData->form_id

      );
    }

    $resp = array(
      'order_data' => $qc_Data,

    );

    return response()->json($resp);
  }
  // getPayOrderApprovalList
  //getPaymentDataDETAILSHOW_HIST_ORDER
  public function getPaymentDataDETAILSHOW_HIST_ORDER(Request $request)
  {
    $FPData_arr = DB::table('qc_forms')->where('form_id', $request->rowID)->where('is_deleted', 0)->first();

    $client_data = DB::table('clients')->where('id', $FPData_arr->client_id)->where('is_deleted', 0)->first();


    $FPData = DB::table('payment_recieved_from_client')->where('client_id', $FPData_arr->client_id)->where('is_deleted', 0)->get();









    $HTML = '<!--begin::Section-->

    <div class="m-section">
      <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-secondary">
													<thead class="thead-inverse">
														<tr>
															<th><b>Client Name:</b>' . $client_data->firstname . '</th>
															<th><b>Phone:</b>' . $client_data->phone . '</th>
															<th><b>Company :</b>' . $client_data->company . '</th>

														</tr>
                          </thead>
                          </table>
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr>
              <th>Payment Date</th>
              <th>Amount</th>
              <th>Bank Name</th>
              <th>Status</th>
              <th>Screenshot</th>
              <th>Account NOTE</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {


      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $completed_on = date('j M Y h:i A', strtotime($rowData->recieved_on));
      $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->payment_img;






      $i++;
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }



      switch ($rowData->payment_status) {
        case 0:
          $payment_status = 'PENDING';
          break;
        case 1:
          $payment_status = 'VIEW';
          break;
        case 2:
          $payment_status = 'COMPLETED';
          break;
      }






      $HTML .= '
            <tr>

              <td><strong>' . $completed_on . '</strong></td>
              <td><a href="#" title="' . $rowData->rec_amount_words . '"><strong>' . $rowData->rec_amount . '</strong></a></td>
              <td><strong>' . $bank . '</strong></td>
              <td><strong>' . $payment_status . '</strong></td>
              <td><strong><a target ="_blank"href="' . $img_photo . '">SCREENSHORT</a></strong></td>
              <td><strong>' . $rowData->account_remarks . '</strong></td>


            </tr>';
    }






    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTMLVIEW' => $HTML,


    );
    return response()->json($resp);
  }



  public function getPaymentDataDETAILSHOW_HIST_SAMPLE(Request $request)
  {
   

   

    $FPData_arr = DB::table('payment_recieved_from_client_for_sample')->where('id', $request->rowID)->where('is_deleted', 0)->first();
    $sampleArr = DB::table('samples')
    ->where('id',$FPData_arr->sample_id)
    ->first();
    $ClientArr = DB::table('clients')
    ->where('id',$sampleArr->client_id)
    ->first();
    // print_r($ClientArr);
    // die;


    $FPData = DB::table('payment_recieved_from_client_for_sample')->where('id', $request->rowID)->where('is_deleted', 0)->get();
    
    $HTML = '<!--begin::Section-->

    <div class="m-section">
      <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-secondary">
													<thead class="thead-inverse">
														<tr>
															<th><b>Client Name:</b>' . $ClientArr->firstname . '</th>
															<th><b>Brand:</b>' . $ClientArr->brand . '</th>
															<th><b>Company :</b>' . $ClientArr->company . '</th>

														</tr>
                          </thead>
                          </table>
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr>
              <th>Payment Date</th>
              <th>Amount</th>
              <th>Bank Name</th>
              <th>Status</th>
              <th>Screenshot</th>
              <th>Account NOTE</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {


      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $completed_on = date('j M Y h:i A', strtotime($rowData->recieved_on));
      $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->payment_img;




      $bank='';

      $i++;
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }



      switch ($rowData->payment_status) {
        case 0:
          $payment_status = 'PENDING';
          break;
        case 1:
          $payment_status = 'VIEW';
          break;
        case 2:
          $payment_status = 'COMPLETED';
          break;
      }






      $HTML .= '
            <tr>

              <td><strong>' . $completed_on . '</strong></td>
              <td><a href="#" title="' . $rowData->rec_amount_words . '"><strong>' . $rowData->rec_amount . '</strong></a></td>
              <td><strong>' . $bank . '</strong></td>
              <td><strong>' . $payment_status . '</strong></td>
              <td><strong><a target ="_blank"href="' . $img_photo . '">SCREENSHORT</a></strong></td>
              <td><strong>' . $rowData->account_remarks . '</strong>
              <br>
              Update on:
               <b> ' . $rowData->account_remarks_updated_at . '</b>BY
               <b> ' . @$rowData->rec_by_name . '</b>
              </td>


            </tr>';
    }






    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTMLVIEW' => $HTML,


    );
    return response()->json($resp);
  }

  //getPaymentDataDETAILSHOW_HIST_ORDER

  public function getPaymentDataDETAILSHOW_HIST(Request $request)
  {
    $FPData_arr = DB::table('payment_recieved_from_client')->where('id', $request->rowID)->where('is_deleted', 0)->first();

    $FPData = DB::table('payment_recieved_from_client')->where('client_id', $FPData_arr->client_id)->where('is_deleted', 0)->get();
    
    $HTML = '<!--begin::Section-->

    <div class="m-section">
      <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-secondary">
													<thead class="thead-inverse">
														<tr>
															<th><b>Client Name:</b>' . $FPData_arr->client_name . '</th>
															<th><b>Phone:</b>' . $FPData_arr->client_phone . '</th>
															<th><b>Company :</b>' . $FPData_arr->compamy_name . '</th>

														</tr>
                          </thead>
                          </table>
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr>
              <th>Payment Date</th>
              <th>Amount</th>
              <th>Bank Name</th>
              <th>Status</th>
              <th>Screenshot</th>
              <th>Account NOTE</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {


      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $completed_on = date('j M Y h:i A', strtotime($rowData->recieved_on));
      $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->payment_img;






      $i++;
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }



      switch ($rowData->payment_status) {
        case 0:
          $payment_status = 'PENDING';
          break;
        case 1:
          $payment_status = 'VIEW';
          break;
        case 2:
          $payment_status = 'COMPLETED';
          break;
      }






      $HTML .= '
            <tr>

              <td><strong>' . $completed_on . '</strong></td>
              <td><a href="#" title="' . $rowData->rec_amount_words . '"><strong>' . $rowData->rec_amount . '</strong></a></td>
              <td><strong>' . $bank . '</strong></td>
              <td><strong>' . $payment_status . '</strong></td>
              <td><strong><a target ="_blank"href="' . $img_photo . '">SCREENSHORT</a></strong></td>
              <td><strong>' . $rowData->account_remarks . '</strong>
              <br>
              Update on:
               <b> ' . $rowData->account_remarks_updated_at . '</b>BY
               <b> ' . @$rowData->rec_by_name . '</b>
              </td>


            </tr>';
    }






    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTMLVIEW' => $HTML,


    );
    return response()->json($resp);
  }

  //getPaymentDataDETAILSHOW_SAMPLE

  public function getPaymentDataDETAILSHOW_SAMPLE(Request $request)
  {
    
    $FPData = DB::table('payment_recieved_from_client_for_sample')->where('id', $request->rowID)->get();

    DB::table('payment_recieved_from_client_for_sample')
      ->where('id', $request->rowID)
      ->update([
        'view_read' => 1
      ]);

     



    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3">Payment Details</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {

      $sampleArr = DB::table('samples')
      ->where('id',$rowData->sample_id)
      ->first();
      $ClientArr = DB::table('clients')
      ->where('id',$sampleArr->client_id)
      ->first();

      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $completed_on = date('j M Y h:i A', strtotime($rowData->recieved_on));

      $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->payment_img;

      $payFor='-';
      switch ($rowData->payment_for) {
        case 1:
         $payFor='Order';
      
         break;
         case 2:
          $payFor='Sample';
       
          break;
        default:
          # code...
          break;
      }
      






      $i++;


      $HTML .= '
      <tr>
        <td scope="row">Payment For </td>
        <td><strong>' . @$payFor . '</strong></td>
      </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Client Name</td>
              <td><strong>' . @$ClientArr->firstname . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Brand</td>
              <td><strong>' . @$ClientArr->brand . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Company Name 	</td>
              <td><strong>' . @$ClientArr->company   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Amount 	</td>
              <td><strong>' . $rowData->rec_amount   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Amount (In Words)	</td>
              <td><strong>' . $rowData->rec_amount_words   . '</strong></td>
            </tr>';
  $bank='';
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }
      $HTML .= '
            <tr>
              <td scope="row">BANK NAME:</td>
              <td><strong>' . $bank . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Remarks</td>
              <td><strong>' . $rowData->request_remarks . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Account Notes</span></td>
              <td><strong>' . $rowData->account_remarks . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Admin Notes</span></td>
              <td>
              <strong>' . $rowData->admin_remarks . '</strong>
            
              </td>
            </tr>';







      $HTML .= '
            <tr>
              <td scope="row">Account Reponse at:</td>
              <td>
              <strong>' . $completed_on . '</strong>
              <strong>' . @$rowData->rec_by_name . '</strong>
              </td>
            </tr>';
      $HTML .= '
            <tr>
              <td scope="row">Shipping Charge :</td>
              <td><strong>' . @$rowData->ship_charge . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Tally Invoice No.:</td>
              <td><strong>' . optional($rowData)->txtTallyNo . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Screenshot:</td>
              <td><strong><a target ="_blank"href="' . $img_photo . '">VIEW SCREENSHORT</a></strong></td>
            </tr>';
    }






    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTMLVIEW' => $HTML,


    );
    return response()->json($resp);
  }

  //getPaymentDataDETAILSHOW_SAMPLE



  public function getPaymentDataDETAILSHOW(Request $request)
  {
    $FPData = DB::table('payment_recieved_from_client')->where('id', $request->rowID)->get();

    DB::table('payment_recieved_from_client')
      ->where('id', $request->rowID)
      ->update([
        'view_read' => 1
      ]);



    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3">Payment Details</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {


      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $completed_on = date('j M Y h:i A', strtotime($rowData->recieved_on));

      $img_photo = asset('local/public/uploads/photos') . "/" . optional($rowData)->payment_img;

      $payFor='-';
      switch ($rowData->payment_for) {
        case 1:
         $payFor='Order';
      
         break;
         case 2:
          $payFor='Sample';
       
          break;
        default:
          # code...
          break;
      }
      






      $i++;


      $HTML .= '
      <tr>
        <td scope="row">Payment For </td>
        <td><strong>' . @$payFor . '</strong></td>
      </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Client Name</td>
              <td><strong>' . $rowData->client_name . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Client Phone</td>
              <td><strong>' . $rowData->client_phone . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Company Name 	</td>
              <td><strong>' . $rowData->compamy_name   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Amount 	</td>
              <td><strong>' . $rowData->rec_amount   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Amount (In Words)	</td>
              <td><strong>' . $rowData->rec_amount_words   . '</strong></td>
            </tr>';

      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }
      $HTML .= '
            <tr>
              <td scope="row">BANK NAME:</td>
              <td><strong>' . $bank . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Remarks</td>
              <td><strong>' . $rowData->request_remarks . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Account Notes</span></td>
              <td><strong>' . $rowData->account_remarks . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Admin Notes</span></td>
              <td>
              <strong>' . $rowData->admin_remarks . '</strong>
            
              </td>
            </tr>';







      $HTML .= '
            <tr>
              <td scope="row">Account Reponse at:</td>
              <td>
              <strong>' . $completed_on . '</strong>
              <strong>' . @$rowData->rec_by_name . '</strong>
              </td>
            </tr>';
      $HTML .= '
            <tr>
              <td scope="row">Shipping Charge :</td>
              <td><strong>' . @$rowData->ship_charge . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Tally Invoice No.:</td>
              <td><strong>' . optional($rowData)->txtTallyNo . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Screenshot:</td>
              <td><strong><a target ="_blank"href="' . $img_photo . '">VIEW SCREENSHORT</a></strong></td>
            </tr>';
    }






    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTMLVIEW' => $HTML,


    );
    return response()->json($resp);
  }
  //getLeadOnCreditData
  public function getLeadOnCreditData(Request $request)
  {

    $FPData = DB::table('lead_credit_request')->where('id', $request->rowID)->first();


    // DB::table('sales_invoice_request')
    //   ->where('id', $request->rowID)
    //   ->update([
    //     'view_status' => 1,

    //   ]);


    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3"Lead on credit  request information is as below</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

   

     // $data = AyraHelp::getQCFormDate($rowData->form_id);
      $created_on = date('j M Y h:i A', strtotime($FPData->created_at));
     

      $client_arr = AyraHelp::getClientbyid($FPData->client_id);
    


      $i++;
     


      $HTML .= '
            <tr>
              <td scope="row">Name</td>
              <td><strong>' . $client_arr->firstname . '</strong></td>
            </tr>';
      $HTML .= '
            <tr>
              <td scope="row">Company Name</td>
              <td><strong>' . $client_arr->company . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Contact NO</td>
              <td><strong>' . $client_arr->phone . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">GSTIN</td>
              <td><strong>' . $client_arr->gstno . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Complete Address 	</td>
              <td><strong>' . $client_arr->address   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Order Count 	</td>
              <td><strong>' . $client_arr->have_order_count   . '</strong></td>
            </tr>';


      
            $HTML .= '
            <tr>
              <td scope="row">Request Message 	</td>
              <td><strong>' . $FPData->message   . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">Request By 	</td>
              <td><strong>' . AyraHelp::getUser($FPData->created_by)->name   . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">Status 	</td>
              <td><strong>' . $FPData->status   . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">Response By 	</td>
              <td><strong>' . @AyraHelp::getUser($FPData->action_by)->name   . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">Response At 	</td>
              <td><strong>' . @$FPData->action_on   . '</strong></td>
            </tr>';





    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

   ';



    $resp = array(
      'HTML_LIST' => $HTML,


    );
    return response()->json($resp);
  }

  //getLeadOnCreditData

  public function getSalesInvoiceData(Request $request)
  {

    $FPData = DB::table('sales_invoice_request')->where('id', $request->rowID)->get();


    DB::table('sales_invoice_request')
      ->where('id', $request->rowID)
      ->update([
        'view_status' => 1,

      ]);


    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >
              <th colspan="3">Sales invoice request information is as below</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;

    foreach ($FPData as $key => $rowData) {

      $data = AyraHelp::getQCFormDate($rowData->form_id);
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      if(isset($rowData->completed_on)){
        $completed_on = date('j M Y h:i A', strtotime($rowData->completed_on));
      }else{
        $completed_on = '';
      }
      

      $client_arr = AyraHelp::getClientbyid($data->client_id);
      // print_r($client_arr->firstname);

      //die;



      // if($data->qc_from_bulk==1){
      //   $qc_URL='print/qcform-bulk/'.$rowData->form_id;
      // }else{
      //   $qc_URL='print/qcform/'.$rowData->form_id;
      // }



      $order_data_arr = json_decode($rowData->order_data_json);

      //print_r($order_data_arr->orderid);







      $i++;
      $HTML .= '
            <tr>
              <td scope="row">Order Details:
              <a href=#"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                       <span><b>
                        ' . $rowData->paid_by . '</b>

                       </span>
                     </a>
                     <br>SAP Invoice Request
                     <table class="table table-bordered m-table m-table--border-primary">
												
                          <tbody>
                          <tr>
                          <td>
                          Party No:<br><b>'.$rowData->sap_party_no.'</b>

                          </td
                          <tr>
                          <td>
                          Note:<br><b>'.$rowData->sap_message.'</b>

                          </td
                          <tr>
                          
                          </tr>
                          </body>
                          </table>
                     
              </td>
              <td>
              <!--begin::Section-->
										<div class="m-section">
											<div class="m-section__content">
												<table class="table table-bordered m-table m-table--border-primary">
													<thead>
														<tr>
															<th>#</th>
															<th>ORDER ID</th>
															<th>TOTAL UNIT</th>
															<th>RATE</th>
                              <th>Update QTY</th>
														</tr>
													</thead>
                          <tbody>';
      $aj = 0;

      for ($k = count($order_data_arr->orderid); $k > 0; $k--) {

        $oridIDQC = optional($order_data_arr)->QCFID[$k - 1];

        $data_mydata = AyraHelp::getQCFormDate($oridIDQC);
        if (optional($data_mydata)->qc_from_bulk == 1) {
          $ac_link = asset('/print/qcform-bulk/' . $oridIDQC);
        } else {
          $ac_link = asset('/print/qcform/' . $oridIDQC);
        }


        $aj++;
        $HTML .= '<tr>
                            <th scope="row">' . $aj . '</th>
                            <td><a title ="View QC FORM" target="_blank"  href="' . $ac_link . '">' . $order_data_arr->orderid[$k - 1] . '</a></td>
                            <td>' . $order_data_arr->orderunt[$k - 1] . '</td>
                            <td>' . $order_data_arr->orderrat[$k - 1] . '</td>
                            <td><input type="text" value="'.intVal($order_data_arr->orderunt[$k - 1]).'" class="form-control txtNewQTy"></td>
                          </tr>';
      }



      $HTML .= '</tbody>
												</table>
											</div>
										</div>

										<!--end::Section-->
              </td>
            </tr>';

      if (!empty($rowData->txtRemarksNote)) {
        $HTML .= '
              <tr>
                <td>
                <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">NOTES</strong></span>
                <td>
                <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded"> <strong>' . $rowData->txtRemarksNote . '</strong></span>
  
               </td>
              </tr>';
      }

    if(Auth::user()->id==185){

    }else{
      $HTML .= '
      <tr>
        <td scope="row">Name</td>
        <td><strong>' . optional($client_arr)->firstname . '</strong></td>
      </tr>';
$HTML .= '
      <tr>
        <td scope="row">Company Name</td>
        <td><strong>' . $client_arr->company . '</strong></td>
      </tr>';


$HTML .= '
      <tr>
        <td scope="row">Contact NO</td>
        <td><strong>' . $rowData->contact_no . '</strong></td>
      </tr>';

    }
     
      $HTML .= '
            <tr>
              <td scope="row">GSTIN</td>
              <td><strong>' . $rowData->gstno . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Complete Address 	</td>
              <td><strong>' . $rowData->complete_address   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Delivery Address 	</td>
              <td><strong>' . $rowData->delivey_address   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Material Dispatch Through  	</td>
              <td><strong>' . $rowData->material_through   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Destination  	</td>
              <td><strong>' . $rowData->destination   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Vehicle/Losistic Details  	</td>
              <td><strong>' . $rowData->vehicle_details   . '</strong></td>
            </tr>';



      $HTML .= '
            <tr>
              <td scope="row">Terms of Delivery</td>
              <td><strong>' . $rowData->terms_delivery   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Total Cartons</td>
              <td><strong>' . $rowData->total_cartons   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Total Units</td>
              <td><strong>' . $rowData->total_units   . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Paid By</td>
              <td><strong>' . $rowData->paid_by   . '</strong></td>
            </tr>';


      $HTML .= '
            <tr>
              <td scope="row">Account Remarks:</td>
              <td><strong>' . $rowData->account_remarks   . '</strong></td>
            </tr>';
      $HTML .= '
            <tr>
              <td scope="row">Account Reponse at:</td>
              <td><strong>' . $completed_on . '</strong></td>
            </tr>';

      $HTML .= '
            <tr>
              <td scope="row">Shipping Charge :</td>
              <td><strong>' . @$rowData->ship_charge . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">PO Number :</td>
              <td><strong>' . @$rowData->ponum . '</strong></td>
            </tr>';
            $HTML .= '
            <tr>
              <td scope="row">PO Date :</td>
              <td><strong>' . @$rowData->ponum_date . '</strong></td>
            </tr>';



            if($rowData->inv_type==2){
              $spname=@AyraHelp::getUser($rowData->sap_is_done_by)->name;
              $HTML .= '
              <tr>
                <td scope="row">SAP Invoice No.:</td>
                <td><b>' . optional($rowData)->txtTallyNo . '</b> completed by:'.$spname.'</td>
              </tr>';

            
            }else{
              $HTML .= '
              <tr>
                <td scope="row">Tally Invoice No.:</td>
                <td><strong>' . optional($rowData)->txtTallyNo . '</strong></td>
              </tr>';
            }


     
    }













    $HTML .= '
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';

    $HTML .= '<hr>';
    $HTML .= '<table class="table table-sm m-table m-table--head-bg-brand">
    <thead class="thead-inverse">
      <tr>
        <th>#</th>
        <th>Status</th>
        <th>Message</th>
        <th>Created By</th>
        <th>Created on</th>
      </tr>
    </thead>
    <tbody>';

    $feedArr = DB::table('sales_invoice_request_feedback')
      ->where('inv_id', $request->rowID)
      ->orderBy('id', 'desc')
      ->get();
    $i = 0;
    foreach ($feedArr as $key => $rowData) {
      $i++;
      switch ($rowData->status) {
        case 1:
          $strSt = '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Approved</span>';
          break;
        case 2:
          $strSt = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Modification</span>';
          break;
        case 3:
          $strSt = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">DONE</span>';
          break;
      }
      $HTML .= ' <tr>
      <th scope="row">' . $i . '</th>
      <td>' . $strSt . '</td>
      <td>' . $rowData->notes . '</td>
      <td>' . AyraHelp::getUser($rowData->created_by)->name . '</td>
      <td>' . date('j F Y, h:iA', strtotime($rowData->created_at)) . '</td>
    </tr>';
    }



    $HTML .= '</tbody>';


    $resp = array(
      'HTML_LIST' => $HTML,


    );
    return response()->json($resp);
  }

  //

  // getOrderApprovalList
  public function getOrderApprovalListData(Request $request)
  {
    $date_from = '2017-03-12 16:10:00';


    //$paymentOrderArr = DB::table('qc_forms')->where('is_deleted', 0)->where('created_at', '>=', $date_from)->where('account_approval', 0)->orderBy('form_id', 'desc')->get();
    $paymentOrderArr = DB::table('qc_forms')->where('is_deleted', 0)->where('created_at', '>=', $date_from)->where('account_approval', 0)->orderBy('form_id', 'desc')->get();
    //$paymentOrderArr = DB::table('qc_forms')->where('is_deleted', 0)->where('created_at', '>=', $date_from)->orderBy('form_id', 'desc')->get();

    $data_arr_1 = array();
    foreach ($paymentOrderArr as $key => $rowData) {
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $company = optional(AyraHelp::getClientbyid($rowData->client_id))->company;
      $brand = optional(AyraHelp::getClientbyid($rowData->client_id))->brand;

      if ($rowData->qc_from_bulk == 1) {
        $orderV = optional($rowData)->bulk_order_value;
      } else {
        $orderV = ceil($rowData->item_qty * $rowData->item_sp);
      }

      $data_arr_1[] = array(
        'RecordID' => $rowData->form_id,
        'order_id' => $rowData->order_id . "/" . $rowData->subOrder,
        'client_name' => optional(AyraHelp::getClientbyid($rowData->client_id))->firstname,
        'company' => $company,
        'brand' => $brand,
        'OrderVal' => $orderV,
        'created_at' => $created_on,
        'created_by' => AyraHelp::getUser($rowData->created_by)->name,
        'qc_link' => AyraHelp::getUser($rowData->created_by)->name,
        'form_id' => $rowData->form_id

      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id' => true,
      'client_name'      => true,
      'company'      => true,
      'brand'      => true,
      'OrderVal'      => true,
      'created_at'      => true,
      'created_by'      => true,
      'qc_link'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getPaymentRequestDataAdmin_Sample
  public function getPaymentRequestDataAdmin_Sample(Request $request)
  {
    if(isset($request->radioValue)){
      if($request->radioValue==1){
        $data = DB::table('payment_recieved_from_client_for_sample')->orderBy('id', 'desc')->where('is_deleted', 0)->get();

      }
      if($request->radioValue==2){
      $data = DB::table('payment_recieved_from_client_for_sample')->where('payment_status',1)->orderBy('id', 'desc')->where('is_deleted', 0)->get();
      }
      if($request->radioValue==3){
        $data = DB::table('payment_recieved_from_client_for_sample')->where('payment_status',0)->orderBy('id', 'desc')->where('is_deleted', 0)->get();

      }
      

    }else{
      $data = DB::table('payment_recieved_from_client_for_sample')->orderBy('id', 'desc')->where('is_deleted', 0)->get();
    }
    
    $data_arr_1 = array();

    foreach ($data as $key => $rowData) {
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $recieved_on = date('j-M-y', strtotime($rowData->recieved_on));
      $bank = "";
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }

      $SampleArr = DB::table('samples')->where('id', $rowData->sample_id)->first();


      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'payment_date' => $recieved_on,
        'created_by' => AyraHelp::getUser($rowData->created_by)->name,
        'c_name' =>  $SampleArr->lead_name." | ". $SampleArr->lead_company,
        'sample_code' => $SampleArr->sample_code,
        'c_phone' => '$rowData->client_phone',
        'bank_name' => $bank,
        'c_company' =>' $rowData->compamy_name',
        'requested_on' => $created_on,
        'amount' => $rowData->rec_amount,
        'amount_word' => $rowData->rec_amount_words,
        'status' => $rowData->payment_status,
        'paytype_name' => $rowData->paytype_name,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'payment_date' => true,
      'c_name'      => true,
      'created_by'      => true,
      'c_phone'      => true,
      'bank_name'      => true,
      'c_company'      => true,
      'requested_on'      => true,
      'amount'      => true,
      'amount_word'      => true,
      'status'      => true,
      'paytype_name'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getPaymentRequestDataAdmin_Sample

  // getOrderApprovalList
  public function getPaymentRequestDataAdmin(Request $request)
  {
    if(isset($request->radioValue)){
      if($request->radioValue==1){
        $data = DB::table('payment_recieved_from_client')->orderBy('id', 'desc')->where('is_deleted', 0)->get();

      }
      if($request->radioValue==2){
      $data = DB::table('payment_recieved_from_client')->where('payment_status',1)->orderBy('id', 'desc')->where('is_deleted', 0)->get();
      }
      if($request->radioValue==3){
        $data = DB::table('payment_recieved_from_client')->where('payment_status',0)->orderBy('id', 'desc')->where('is_deleted', 0)->get();

      }
      

    }else{
      $data = DB::table('payment_recieved_from_client')->orderBy('id', 'desc')->where('is_deleted', 0)->get();
    }
    
    $data_arr_1 = array();

    foreach ($data as $key => $rowData) {
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $recieved_on = date('j-M-y', strtotime($rowData->recieved_on));
      $bank = "";
      switch ($rowData->bank_name) {
        case 1:
          $bank = 'ICICI BANK';
          break;
        case 2:
          $bank = 'PNB BANK';
          break;
        case 3:
          $bank = 'CASH';
          break;
        case 4:
          $bank = 'PAYPAL';
          break;
        case 5:
          $bank = 'AXIS';
          break;
        case 6:
          $bank = 'INDIAMART';
          break;
        case 7:
          $bank = 'PAYTM';
          break;
        case 8:
          $bank = 'OTHERS';
          break;
      }

      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'payment_date' => $recieved_on,
        'created_by' => AyraHelp::getUser($rowData->created_by)->name,
        'c_name' => $rowData->client_name,
        'c_phone' => $rowData->client_phone,
        'bank_name' => $bank,
        'c_company' => $rowData->compamy_name,
        'requested_on' => $created_on,
        'amount' => $rowData->rec_amount,
        'amount_word' => $rowData->rec_amount_words,
        'status' => $rowData->payment_status,
        'paytype_name' => $rowData->paytype_name,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'payment_date' => true,
      'c_name'      => true,
      'created_by'      => true,
      'c_phone'      => true,
      'bank_name'      => true,
      'c_company'      => true,
      'requested_on'      => true,
      'amount'      => true,
      'amount_word'      => true,
      'status'      => true,
      'paytype_name'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  //getPaymentReqestList
  public function getPaymentReqestList(Request $request)
  {
    $data = DB::table('payment_recieved_from_client')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->get();
    $data_arr_1 = array();

    foreach ($data as $key => $rowData) {
      $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
      $recieved_on = date('j-M-Y', strtotime($rowData->recieved_on));

      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'payment_date' => $recieved_on,
        'c_name' => $rowData->client_name,
        'c_phone' => $rowData->client_phone,
        'c_company' => $rowData->compamy_name,
        'requested_on' => $created_on,
        'amount' => $rowData->rec_amount,
        'amount_word' => $rowData->rec_amount_words,
        'status' => $rowData->payment_status,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'payment_date' => true,
      'c_name'      => true,
      'c_phone'      => true,
      'c_company'      => true,
      'requested_on'      => true,
      'amount'      => true,
      'amount_word'      => true,
      'status'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getPaymentReqestList


  //getLeadOnCredittList
  public function getLeadOnCredittList(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
     $user_role = $userRoles[0];
  
    $data_arr_1 = array();
    if ($user_role == 'Admin' || $user_role == 'SalesHead'){
      $data_data = DB::table('lead_credit_request')->where('is_deleted', 0)->get();
  }else{
      $data_data = DB::table('lead_credit_request')->where('created_by',Auth::user()->id)->where('is_deleted', 0)->get();
  }
    


    foreach ($data_data as $key => $rowData) {
     $clientArr=AyraHelp::getClientbyid($rowData->client_id);
    
     $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
     $created_on_lead = date('j M Y h:i A', strtotime($clientArr->created_at));

      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'sales_person' => AyraHelp::getUser($rowData->created_by)->name,
        'company' => $clientArr->company,
        'brand' => $clientArr->brand,
        'firstname' => $clientArr->firstname,
        'phone' => $clientArr->phone,
        'created_at_lead' => $created_on_lead,
        'have_order_count' => $clientArr->have_order_count==NULL ? "":$clientArr->have_order_count,
        'created_at' => $created_on,
        'status' => $rowData->status,       
        'Actions' => ""
      );

    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'sales_person'      => true,
      'company'      => true,
      'brand'      => true,
      'firstname'      => true,
      'phone'      => true,
      'created_at_lead'      => true,
      'have_order_count'      => true,
      'created_at'      => true,
      'status'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getLeadOnCredittList

  public function getSalesInvoiceReqestList(Request $request)
  {


    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $data_arr_1 = array();
    if ($user_role == 'Admin' || Auth::user()->id == 90 || Auth::user()->id == 132 || Auth::user()->id == 88 ||  Auth::user()->id == 147 ||   Auth::user()->id == 176  ||   Auth::user()->id == 175 || Auth::user()->id == 185) {
      //$data=DB::table('sales_invoice_request')->where('status', 0)->get();
     
      if(Auth::user()->id == 185){
        $data_data = DB::table('sales_invoice_request')->where('is_deletd', 0)->where('sap_invoice_action','!=',0)->get();
      }else{
        $data_data = DB::table('sales_invoice_request')->where('is_deletd', 0)->get();

      }


      foreach ($data_data as $key => $rowData) {
        $data = AyraHelp::getQCFormDate($rowData->form_id);
        $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
        if (optional($data)->qc_from_bulk == 1) {
          $qc_URL = 'print/qcform-bulk/' . $rowData->form_id;
        } else {
          $qc_URL = 'print/qcform/' . $rowData->form_id;
        }
        //doc
        $invoiceDocArr = DB::table('order_invoice_doc')
          ->where('form_id',  $rowData->form_id)
          ->first();
        if ($invoiceDocArr == null) {
          $strFocFile = 0;
          $Cid = 0;
        } else {

          $strFocFile = asset('local/public/uploads/photos') . "/" . optional($invoiceDocArr)->invoice_doc;
          $Cid = $invoiceDocArr->client_id;
        }
        //doc
        $feedcount = DB::table('sales_invoice_request_feedback')
          ->where('inv_id', $rowData->id)
          ->count();
        

        $data_arr_1[] = array(
          'RecordID' => $rowData->id,
          'sales_person' => AyraHelp::getUser($rowData->created_by)->name,
          'order_id' => $data->order_id . "/" . $data->subOrder,
          'qc_URL' => $qc_URL,        
          'brand' =>$data->brand_name,
          'form_id' => $rowData->form_id,
          'client_id' => $Cid,
          'created_at' => $created_on,
          'status' => $rowData->status,
          'feedcount' => $feedcount,
          'Actions' => ""
        );
      }
    } else {


      $data_arr_data = DB::table('sales_invoice_request')->where('is_deletd', 0)->where('created_by', Auth::user()->id)->get();


      foreach ($data_arr_data as $key => $rowData) {
        $data = AyraHelp::getQCFormDate($rowData->form_id);
        $created_on = date('j M Y h:i A', strtotime($rowData->created_at));
        if ($data->qc_from_bulk == 1) {
          $qc_URL = 'print/qcform-bulk/' . $rowData->form_id;
        } else {
          $qc_URL = 'print/qcform/' . $rowData->form_id;
        }

        //doc
        $invoiceDocArr = DB::table('order_invoice_doc')
          ->where('form_id',  $rowData->form_id)
          ->first();
        if ($invoiceDocArr == null) {
          $strFocFile = 0;
          $Cid = 0;
        } else {

          $strFocFile = asset('local/public/uploads/photos') . "/" . optional($invoiceDocArr)->invoice_doc;
          $Cid = $invoiceDocArr->client_id;
        }
        //doc

        $feedcount = DB::table('sales_invoice_request_feedback')
          ->where('inv_id', $rowData->id)
          ->count();

        $data_arr_1[] = array(
          'RecordID' => $rowData->id,
          'sales_person' => AyraHelp::getUser($rowData->created_by)->name,
          'order_id' => $data->order_id . "/" . $data->subOrder,
          'qc_URL' => $qc_URL,
          'brand' =>@$rowData->brand_name,
          'form_id' => $rowData->form_id,
          'client_id' => $Cid,
          'created_at' => $created_on,
          'status' => $rowData->status,
          'strFocFile' => $strFocFile,
          'feedcount' => $feedcount,
          'Actions' => ""
        );
      }
    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'sales_person'      => true,
      'order_id'      => true,
      'qc_URL'      => true,
      'brand'      => true,
      'form_id'      => true,
      'created_at'      => true,
      'status'      => true,
      'strFocFile'      => true,
      'feedcount'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function viewMissedCronJob()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    return $theme->scope('orders.v1.leadCronJobList', $data)->render();
  }
  //saveAccountResponseOnSInvoiceRequestFeedback
  public function saveAccountResponseOnSInvoiceRequestFeedback(Request $request)
  {
    DB::table('sales_invoice_request_feedback')->insert([
      'inv_id' => $request->rowID,
      'created_at' => date('Y-m-d H:i:s'),
      'status' => $request->sirRespStatus,
      'notes' => $request->sirMessage,

      'created_by' => Auth::user()->id,

    ]);

    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);
  }
  //getSubCategoryFinishProuct
  public function getSubCategoryFinishProuct(Request $request)
  {
    $cat_ID = $request->cat_ID;
    $catArrData = DB::table('rnd_finish_product_subcat')
      ->where('cat_id', $cat_ID)
      ->get();
    $HTML = "";

    foreach ($catArrData as $key => $rowData) {
      //  print_r($rowData);
      $HTML .= "<option value=" . $rowData->id . ">" . $rowData->sub_cat_name . "</option>";
    }
    echo $HTML;
  }

  //getSubCategoryFinishProuct


  //saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce
  public function saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce(Request $request)
  {
    print_r($request->all());
    die;
    $rowID=$request->rowID;
    $sirMessageSAP=$request->sirMessageSAP;
    $txtPartyNo=$request->txtPartyNo;

    $affected = DB::table('sales_invoice_request')
              ->where('id', $rowID)
              ->update([
                'sap_invoice_action' => 1,
                'sap_party_no' => $txtPartyNo,
                'sap_message' => $sirMessageSAP,
                'sap_inv_requested_on' => date('Y-m-d h:i:s'),
                'sap_inv_requested_by' => Auth::user()->id,

              ]);
              $resp = array(
                'status' => 1,
          
              );
              $affectedDataArr = DB::table('sales_invoice_request')
              ->where('id', $rowID)
              ->first();
              $form_id=$affectedDataArr->form_id;             

          
              return response()->json($resp);

  }
  //saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce

  //saveAccountResponseOnSInvoiceRequestFeedback
  public function saveAccountResponseOnSInvoiceRequest(Request $request)
  {


   

    if ($request->sirRespStatus == 1) {
     
      $invArr = DB::table('sales_invoice_request')
        ->where('id', $request->rowID)
        ->first();
      $dataArrJSON = json_decode($invArr->order_data_json);
      $orderArr = $dataArrJSON->QCFID;
      foreach ($orderArr as $key => $row) {

        $formID = $row;
        //ajax H
        $data = AyraHelp::getQCFormDate($formID);

        $processDataCount = DB::table('st_process_action')
          ->where('process_id', 1)
          ->where('ticket_id', $formID)
          ->where('action_status', 1)
          ->get();

        if ($data->order_type == "Private Label") {
        
          //repeat need to check 
          if ($data->order_repeat == 2) {
           
            
            $dataStage = [1, 2, 7, 8, 9, 10, 12];
            foreach ($dataStage as $key => $dataStage) {
              $x = $dataStage;
              $processDataCountCHK = DB::table('st_process_action')
                ->where('process_id', 1)
                ->where('ticket_id', $formID)
                ->where('action_status', 1)
                ->where('stage_id', $x)
                ->where('action_on', 1)
                ->first();
              if ($processDataCountCHK == null) {

                DB::table('st_process_action')
                  ->updateOrInsert(
                    [
                      'ticket_id' => $formID,
                      'process_id' => 1,
                      'stage_id' => $x,
                    ],
                    [
                      'ticket_id' => $formID,
                      'process_id' => 1,
                      'stage_id' => $x,
                      'action_on' => 1,
                      'created_at' => date('Y-m-d H:i:s'),
                      'expected_date' => date('Y-m-d H:i:s'),
                      'remarks' => 'Auto Completed by Invoice Completed',
                      'attachment_id' => 0,
                      'assigned_id' => 1,
                      'undo_status' => 1,
                      'action_status' => 1,
                      'updated_by' => Auth::user()->id,
                      'created_status' => 1,
                      'completed_by' => Auth::user()->id,
                      'statge_color' => 'completed',
                    ]
                  );
              } else {
              }

              //update order 
              DB::table('qc_forms')
                ->updateOrInsert(
                  ['form_id' => $formID],
                  [
                    'curr_stage_id' => 8,
                    'curr_stage_updated_on' => date('Y-m-d H:i:s'),
                    'curr_stage_name' => 'Dispatch'
                  ]
                );
              //update order 


            }
          } else {
            //echo "New Order"; //12
           
            

            $dataStage = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            foreach ($dataStage as $key => $dataStage) {
              $x = $dataStage;

              $processDataCountCHK = DB::table('st_process_action')
                ->where('process_id', 1)
                ->where('ticket_id', $formID)
                ->where('action_status', 1)
                ->where('stage_id', $x)
                ->where('action_on', 1)
                ->first();

               


              if ($processDataCountCHK == null) {

                DB::table('st_process_action')
                  ->updateOrInsert(
                    [
                      'ticket_id' => $formID,
                      'process_id' => 1,
                      'stage_id' => $x,
                    ],
                    [
                      'ticket_id' => $formID,
                      'process_id' => 1,
                      'stage_id' => $x,
                      'action_on' => 1,
                      'created_at' => date('Y-m-d H:i:s'),
                      'expected_date' => date('Y-m-d H:i:s'),
                      'remarks' => 'Auto Completed by Invoice Completed',
                      'attachment_id' => 0,
                      'assigned_id' => 1,
                      'undo_status' => 1,
                      'action_status' => 1,
                      'updated_by' => Auth::user()->id,
                      'created_status' => 1,
                      'completed_by' => Auth::user()->id,
                      'statge_color' => 'completed',
                    ]
                  );
              } else {

              }
              //update order 
              DB::table('qc_forms')
                ->updateOrInsert(
                  ['form_id' => $formID],
                  [
                    'curr_stage_id' => 13,
                    'curr_stage_updated_on' => date('Y-m-d H:i:s'),
                    'curr_stage_name' => 'Dispatch'
                  ]
                );
              //update order 

            }
          }
        } else {
          //echo "Bulk Order"; //3
          $dataStage = [1, 9, 12];
          foreach ($dataStage as $key => $dataStage) {
            $x = $dataStage;
            $processDataCountCHK = DB::table('st_process_action')
              ->where('process_id', 1)
              ->where('ticket_id', $formID)
              ->where('action_status', 1)
              ->where('stage_id', $x)
              ->where('action_on', 1)
              ->first();
            if ($processDataCountCHK == null) {

              DB::table('st_process_action')
                ->updateOrInsert(
                  [
                    'ticket_id' => $formID,
                    'process_id' => 1,
                    'stage_id' => $x,
                  ],
                  [
                    'ticket_id' => $formID,
                    'process_id' => 1,
                    'stage_id' => $x,
                    'action_on' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'expected_date' => date('Y-m-d H:i:s'),
                    'remarks' => 'Auto Completed by Invoice Completed',
                    'attachment_id' => 0,
                    'assigned_id' => 1,
                    'undo_status' => 1,
                    'action_status' => 1,
                    'updated_by' => Auth::user()->id,
                    'created_status' => 1,
                    'completed_by' => Auth::user()->id,
                    'statge_color' => 'completed',
                  ]
                );
            } else {
            }

            //update order 
            DB::table('qc_forms')
              ->updateOrInsert(
                ['form_id' => $formID],
                [
                  'curr_stage_id' => 4,
                  'curr_stage_updated_on' => date('Y-m-d H:i:s'),
                  'curr_stage_name' => 'Dispatch'
                ]
              );
            //update order 


          }
        }

        //ajax H

      }
    }












    DB::table('sales_invoice_request')
      ->where('id', $request->rowID)
      ->update([
        'status' => $request->sirRespStatus,
        'account_remarks' => $request->sirMessage,
        'txtTallyNo' => $request->txtTallyNo,
        'completed_on' => date('Y-m-d H:i:s'),
        'request_at_time' => 2,
        'inv_type' => $request->inv_type,
        'sap_is_done' =>1,
        'sap_is_done_by' =>Auth::user()->id,
        'sap_is_done_on' =>date('Y-m-d H:i:s')

      ]);
    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);
  }


  public function savePaymentRecivedClient(Request $request)
  {

    $client_arr = AyraHelp::getClientbyid($request->client_select);
    $filename = '';
    if ($request->hasfile('payIMG')) {
      $file = $request->file('payIMG');
      $filename = "img_1_PAYM" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);
    }


    $id =  DB::table('payment_recieved_from_client')->insert(
      [
        'client_id' => $client_arr->id,
        'recieved_on' => $request->pay_date_recieved,
        'rec_amount' => $request->payAmt,
        'rec_amount_words' => ucwords($request->Ls),
        'bank_name' => $request->bank_name,
        'request_remarks' => $request->txtMessagePAYDATA,
        'client_name' => $client_arr->firstname,
        'client_phone' => $client_arr->phone,
        'compamy_name' =>  $client_arr->company,
        'payment_img' =>  $filename,
        'created_by' => $request->assined_user,
        'created_by_ori' =>  Auth::user()->id,
        'paytype_name' =>   $request->paytype_id,
        'payment_for' =>   $request->payment_for,
      ]
    );


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
    $eventID = 'AJ_ID132';

    $data['message'] = 'Please check payment details upload by : ' . Auth::user()->name . ' <strong>Company</strong> : ' . $client_arr->firstname . ' of Amount: ' . $request->payAmt . "<br> Rs.(in words) " . ucwords($request->Ls) . "<br><b style='color:#035496'>Message</b> :" . $request->txtMessagePAYDATA;

    $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
    //puhser 







    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);
  }



  public function saveSalesInvoiceRequestAccessed(Request $request)
  {


    $FPData = DB::table('sales_invoice_request')->where('form_id', $request->formNO)->where('request_at_time', 1)->where('is_deletd', 0)->first();
    if ($FPData == null) {


      $totUNIT = $request->totUNIT;
      $toRate = $request->toRate;
      $toratFID = $request->AJFORMID;

      $ord = array();
      $unt = array();
      $rat = array();
      $ratFID = array();
      foreach ($request->orderID as $key => $myData) {

        $ord[] = $myData;
        $unt[] = $totUNIT[$key];
        $rat[] = $toRate[$key];
        $ratFID[] = $toratFID[$key];
      }
      $resp_order_data = array(
        'orderid' => $ord,
        'orderunt' => $unt,
        'orderrat' => $rat,
        'QCFID' => $ratFID,

      );


      DB::table('sales_invoice_request')->insert(
        [
          'form_id' => $request->formNO,
          'gstno' => '',
          'contact_no' => '',
          'complete_address' => $request->complete_buyer_address,
          'delivey_address' => $request->delivery_address,
          'material_through' => $request->dispatch_through == 1 ?  'Transport' : 'Own Vehicle',
          'destination' => $request->order_destination,
          'vehicle_details' => $request->vLogistic,
          'terms_delivery' => $request->termsDelivery,
          'total_cartons' => $request->Vno_of_cartons,
          'txtRemarksNote' => $request->txtRemarksNote,
          'ship_charge' => $request->txtShippingCharge,
          'total_units' => $request->Vno_of_unit,
          'request_at_time' => 1,
          'paid_by' => $request->paid_by == 1 ? 'Paid By US' : 'Paid By Customer',
          'created_by' => Auth::user()->id,
          'order_data_json' => json_encode($resp_order_data)
        ]
      );
      $resp = array(
        'status' => 1,

      );
    } else {
      $resp = array(
        'status' => 0,

      );
    }
    return response()->json($resp);
  }



  public function saveSalesInvoiceRequest(Request $request)
  {


    $FPData = DB::table('sales_invoice_request')->where('form_id', $request->formNO)->where('request_at_time', '>=', 20)->where('is_deletd', 0)->first();
    if ($FPData == null) {

      // $data_json=array(
      //   $request->orderID,
      // $request->totUNIT,
      //   $request->toRate
      // );
      $totUNIT = $request->totUNIT;
      $toRate = $request->toRate;
      $toratFID = $request->AJFORMID;

      $ord = array();
      $unt = array();
      $rat = array();
      $ratFID = array();
      foreach ($request->orderID as $key => $myData) {

        $ord[] = $myData;
        $unt[] = $totUNIT[$key];
        $rat[] = $toRate[$key];
        $ratFID[] = $toratFID[$key];
      }
      $resp_order_data = array(
        'orderid' => $ord,
        'orderunt' => $unt,
        'orderrat' => $rat,
        'QCFID' => $ratFID,

      );


      DB::table('sales_invoice_request')->insert(
        [
          'form_id' => $request->formNO,
          'gstno' => $request->txtMyGSTNO,
          'contact_no' => $request->txtMyContactNO,
          'complete_address' => $request->complete_buyer_address,
          'delivey_address' => $request->delivery_address,
          'material_through' => $request->dispatch_through == 1 ?  'Transport' : 'Own Vehicle',
          'destination' => $request->order_destination,
          'vehicle_details' => $request->vLogistic,
          'terms_delivery' => $request->termsDelivery,
          'total_cartons' => $request->Vno_of_cartons,
          'total_units' => $request->Vno_of_unit,
          'request_at_time' => 1,
          'paid_by' => $request->paid_by == 1 ? 'Paid By US' : 'Paid By Customer',
          'created_by' => Auth::user()->id,
          'created_at' => date('Y-m-d H:i:s'),
          'txtRemarksNote' => $request->txtRemarksNote,
          'ship_charge' => $request->txtShippingCharge,
          'ponum' => $request->txtPONUM,
          'ponum_date' => date('Y-m-d',strtotime($request->txtPONUM_Date)),
          'order_data_json' => json_encode($resp_order_data)
        ]
      );
      $resp = array(
        'status' => 1,

      );
    } else {
      $resp = array(
        'status' => 0,

      );
    }
    return response()->json($resp);
  }

  public function getMyQCData(Request $request)
  {
    $qc_data = QCFORM::where('form_id', $request->recordID)->first();
    $client_arr = Client::where('id', $qc_data->client_id)->first();
    $data = AyraHelp::getProcessCurrentStage(1, $request->recordID);
    $Spname = $data->stage_name;
    $Spname = "Dispatch";
    if ($Spname == 'Dispatch') {



      if ($qc_data->qc_from_bulk == 1) {
        //$nounit
        $itemA = "";

        $qcbulk_arr = QCBULK_ORDER::where('form_id', $qc_data->form_id)->get();

        $qty = 0;
        $rate = 0;
        foreach ($qcbulk_arr as $key => $rowData) {
          $qty = $qty + $rowData->qty;
          $rate = $rate + $rowData->item_sell_p;
          if (!empty($rowData->item_name)) {
            $itemA .= $rowData->item_name . "|";
          }
        }



        $nounit = $qty;
        $rate = $rate;
        $oType = 'BULK';
        $oderName = $itemA;
      } else {
        $sizeUnit = $qc_data->item_size . " " . $qc_data->item_size_unit;

        if ($qc_data->item_size_unit == 'Kg' || $qc_data->item_size_unit == 'L') {

          if ($qc_data->item_size_unit == 'Kg') {
            $batchUnitview = " kg";
          } else {
            $batchUnitview = "L";
          }


          $nounit = ($qc_data->item_qty) . " " . $qc_data->item_qty_unit;
          $batchSize = ceil(((($qc_data->item_qty) * ($qc_data->item_size)))) . "" . $batchUnitview;
        }

        if ($qc_data->item_size_unit == 'Ml' || $qc_data->item_size_unit == 'Gm') {

          if ($qc_data->item_size_unit == 'Ml') {
            $batchUnitview = "L";
          } else {
            $batchUnitview = "Kg";
          }
          $nounit = $qc_data->item_qty . " " . $qc_data->item_qty_unit;
          $batchSize = (ceil((($qc_data->item_qty) * ($qc_data->item_size)) / 1000)) . "" . $batchUnitview;
        }

        $rate = $qc_data->item_sp;
        //$rate=$qc_data->item_qty*$qc_data->item_sp;
        $oType = 'PRIVATE LABLE';
        $oderName = $qc_data->item_name;
      }






      $resp = array(
        'status' => 1,
        'qc_data' => $qc_data,
        'qc_client' => $client_arr,
        'total_UNIT' => $nounit,
        'total_rate' => $rate,
        'Otype' => $oType,
        'oderName' => $oderName

      );
    } else {

      $resp = array(
        'status' => 0,
        'qc_data' => $qc_data,
        'qc_client' => $client_arr,
      );
    }



    return response()->json($resp);
  }

  public function getMyQCDataA(Request $request)
  {
    $qc_data = QCFORM::where('form_id', $request->recordID)->first();
    $client_arr = Client::where('id', $qc_data->client_id)->first();
    $data = AyraHelp::getProcessCurrentStage(1, $request->recordID);
    $Spname = $data->stage_name;
    $Spname = "Dispatch";
    if ($Spname == 'Dispatch') {



      if ($qc_data->qc_from_bulk == 1) {
        //$nounit

        $qcbulk_arr = QCBULK_ORDER::where('form_id', $qc_data->form_id)->get();

        $qty = 0;
        $rate = 0;
        foreach ($qcbulk_arr as $key => $rowData) {
          $qty = $qty + $rowData->qty;
          $rate = $rate + $rowData->item_sell_p;
        }



        $nounit = $qty;
        $rate = $rate;
        $oType = 'BULK';
      } else {
        $sizeUnit = $qc_data->item_size . " " . $qc_data->item_size_unit;

        if ($qc_data->item_size_unit == 'Kg' || $qc_data->item_size_unit == 'L') {

          if ($qc_data->item_size_unit == 'Kg') {
            $batchUnitview = " kg";
          } else {
            $batchUnitview = "L";
          }


          $nounit = ($qc_data->item_qty) . " " . $qc_data->item_qty_unit;
          $batchSize = ceil(((($qc_data->item_qty) * ($qc_data->item_size)))) . "" . $batchUnitview;
        }

        if ($qc_data->item_size_unit == 'Ml' || $qc_data->item_size_unit == 'Gm') {

          if ($qc_data->item_size_unit == 'Ml') {
            $batchUnitview = "L";
          } else {
            $batchUnitview = "Kg";
          }
          $nounit = $qc_data->item_qty . " " . $qc_data->item_qty_unit;
          $batchSize = (ceil((($qc_data->item_qty) * ($qc_data->item_size)) / 1000)) . "" . $batchUnitview;
        }

        $rate = $qc_data->item_sp;
        //$rate=$qc_data->item_qty*$qc_data->item_sp;
        $oType = 'PRIVATE LABLE';
      }






      $resp = array(
        'status' => 1,
        'qc_data' => $qc_data,
        'qc_client' => $client_arr,
        'total_UNIT' => $nounit,
        'total_rate' => $rate,
        'Otype' => $oType,

      );
    } else {

      $resp = array(
        'status' => 0,
        'qc_data' => $qc_data,
        'qc_client' => $client_arr,
      );
    }



    return response()->json($resp);
  }
  public function deleteFromPurchaseListwithID(Request $request)
  {
    $data_arr = QC_BOM_Purchase::where('id', $request->rowid)->delete();
    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }

  //v1
  public function getOrderQty(Request $requset)
  {
    //print_r($requset->all());
    $fid = $requset->ticket_id;
    $data = AyraHelp::getQCFormDate($fid);
    echo $data->item_qty;
  }
  public function setSaveVendorOrderRecieved(Request $requset)
  {

    $BOMIDRV = $requset->BOMIDRV;
    $txtRECQTY = $requset->txtRECQTY;
    $txtGRPONumber = $requset->txtGRPONumber;
    $txtRemarks = $requset->txtRemarks;


    $data = PurchaseOrderRecieved::where('purchase_id', $BOMIDRV)->where('received_status', 1)->first();

    if ($data != null) {
      $data_arr = array(
        'status' => 0,
        'msg' => 'Already process done'
      );
      return response()->json($data_arr);
    } else


      DB::table('st_process_action_2')->insert(
        [
          'ticket_id' => $BOMIDRV,
          'process_id' => 2,
          'stage_id' => 6,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => '',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_status' => 1,
        ]
      );

    DB::table('qc_bo_purchaselist')
      ->where('id', $BOMIDRV)
      ->update([
        'status' => 6,

      ]);


    DB::table('purchase_order_recieved')
      ->where('purchase_id', $BOMIDRV)
      ->update([
        'qty_recieved' => $txtRECQTY,
        'grpo' => $txtGRPONumber,
        'rec_remark' => $txtRemarks,
        'received_status' => 1,
        'received_on' => date('Y-m-d'),
      ]);




    $data_arr = array(
      'status' => 1,
      'msg' => 'Added  successfully'
    );
    return response()->json($data_arr);
  }
  public function setSaveVendorOrder(Request $request)
  {


    // send email  to vendor

    $sent_to = 'bointldev@gmail.com';

    $subLine = "Order Information";

    $data = array(
      'orderID' => 44,
      'orderName' => 44,
      'ItemName' => '44',
      'qty' => 44,
      // 'po_no'=>$row['txtPONumber'],
      'OrderDate' => date('d-m-Y')


    );
    // Mail::send('mail_vendor', $data, function($message) use ($sent_to,$subLine) {

    //    $message->to($sent_to, 'BO')->subject
    //       ($subLine);
    //       //$message->cc($use_data->email,$use_data->name = null);
    //       $message->bcc('udita.bointl@gmail.com','UDITA');
    //       $message->from('bointloperations@gmail.com','Bo Intl Operations');
    // });
    //echo "ddddddddddddd";
    // send email  to vendor

    $BOMID = $request->BOMID;
    $txtPO_NO = $request->txtPO_NO;
    $txtETA = $request->txtETA;
    $venderID = $request->venderID;
    $txtRemarks = $request->txtRemarks;

    $data = PurchaseOrderRecieved::where('purchase_id', $BOMID)->first();

    if ($data != null) {
      $data_arr = array(
        'status' => 0,
        'msg' => 'Already process done'
      );
      return response()->json($data_arr);
    }


    $data_arr = AyraHelp::getPurchaseListDataWith($BOMID);

    $purchaseObj = new PurchaseOrderRecieved;
    $purchaseObj->order_no = $data_arr->form_id;
    $purchaseObj->sub_order_no = $data_arr->sub_order_index;
    $purchaseObj->bom_name = $data_arr->material_name;
    $purchaseObj->purchase_id = $BOMID;
    $purchaseObj->po_no = $txtPO_NO;
    $purchaseObj->eta = $txtETA;
    $purchaseObj->order_remark = $txtRemarks;
    $purchaseObj->vendor_name = $venderID;
    $purchaseObj->save();


    DB::table('st_process_action_2')->insert(
      [
        'ticket_id' => $BOMID,
        'process_id' => 2,
        'stage_id' => 5,
        'action_on' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'expected_date' => date('Y-m-d H:i:s'),
        'remarks' => '',
        'attachment_id' => 0,
        'assigned_id' => 1,
        'undo_status' => 1,
        'updated_by' => Auth::user()->id,
        'created_status' => 1,
        'completed_by' => Auth::user()->id,
        'statge_color' => 'completed',
      ]
    );

    DB::table('qc_bo_purchaselist')
      ->where('id', $BOMID)
      ->update([
        'status' => 5
      ]);


    $data_arr = array(
      'status' => 1,
      'msg' => 'Added  successfully'
    );
    return response()->json($data_arr);
  }
  //sent_on
  public function setSaveProcessAction(Request $request)
  {
    $form_id = $request->txtTicketID;

    if ($request->txtProcessID == 6) {

      if ($request->txtStage_ID == 2) {

        $data = DB::table('st_process_action_6')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();

        if ($data == null) {

          DB::table('st_process_action_6')->insert(
            [
              'ticket_id' => $request->txtTicketID,
              'process_id' => $request->txtProcessID,
              'stage_id' => $request->txtStage_ID,
              'action_on' => $request->action_on,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => $request->txtRemarks,
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
            ->where('id', $request->txtTicketID)
            ->update([
              'sample_stage_id' => $request->txtStage_ID,

            ]);

            
          //AyraHelp::setAllSampleAssinedNow(); //auto assigned 
         // AyraHelp::setSampleAssinedThisAsNow($request->txtTicketID); //auto assigned 
         $sampleChidListArr = DB::table('sample_items')
         ->where('sid', $request->txtTicketID)
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
             'remarks' =>$request->txtRemarks,
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



        } else {
          $data_arr = array(
            'status' => 0,
            'msg' => 'Already Done'
          );
        }
      }
      //packing 
      if ($request->txtStage_ID == 3) {

        $data = DB::table('st_process_action_6')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();

        if ($data == null) {

          DB::table('st_process_action_6')->insert(
            [
              'ticket_id' => $request->txtTicketID,
              'process_id' => $request->txtProcessID,
              'stage_id' => $request->txtStage_ID,
              'action_on' => $request->action_on,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => $request->txtRemarks,
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
            ->where('id', $request->txtTicketID)
            ->update([
              'sample_stage_id' => $request->txtStage_ID,
              'sample_FM' => $request->txtFormulationID,
              'sample_fragrance' => $request->txtFragranceName,
              'sample_color' => $request->txtColorName,
              'sample_chemist' => $request->txtChemistID,
              'sample_notes' => $request->txtRemarks,

            ]);
        } else {
          $data_arr = array(
            'status' => 0,
            'msg' => 'Already Done'
          );
        }
      }


      //packing 

      //Dispatch 
      if ($request->txtStage_ID == 5) {

        $data = DB::table('st_process_action_6')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();

        if ($data == null) {
          $affected = DB::table('samples')
            ->where('id', $request->txtTicketID)
            ->update([
              'sample_stage_id' => $request->txtStage_ID,
              'status' => 2,
              'courier_id' => $request->courier_data,
              'track_id' => $request->track_id,
              'sent_on' => date('Y-m-d H:i:s', strtotime($request->m_datepicker_3)),
              'courier_remarks' => $request->txtRemarks,

            ]);

            $affected = DB::table('sample_items')
            ->where('sid', $request->txtTicketID)
            ->update([
              'stage_id' => $request->txtStage_ID            

            ]);


          DB::table('st_process_action_6')->insert(
            [
              'ticket_id' => $request->txtTicketID,
              'process_id' => $request->txtProcessID,
              'stage_id' => $request->txtStage_ID,
              'action_on' => $request->action_on,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => $request->txtRemarks,
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
        } else {
          $data_arr = array(
            'status' => 0,
            'msg' => 'Already Done'
          );
        }
      }


      //Dispatch





      return response()->json($data_arr);
    }


    //statge 5 own lead
    if ($request->txtProcessID == 5) {
      $data = DB::table('st_process_action_5_mylead')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();

      if ($data == null) {
        DB::table('st_process_action_5_mylead')->insert(
          [
            'ticket_id' => $request->txtTicketID,
            'process_id' => $request->txtProcessID,
            'stage_id' => $request->txtStage_ID,
            'action_on' => $request->action_on,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => $request->txtRemarks,
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


        //--------------------------------
        //  $QUERY_ID=$request->txtTicketID;
        //  $user_id=Auth::user()->id;
        //  $msg=$request->txtRemarks;
        //  $st_id=$request->txtStage_ID;
        //  $data_sta_arr= AyraHelp::getStageDataBYpostionID($st_id,4);


        //   $msg_desc=$data_sta_arr->stage_name.' :Stage is  completed by'.AyraHelp::getUser($user_id)->name." on ".date('j F Y H:i:s');

        //    $this->saveLeadHistory($QUERY_ID,$user_id,$msg_desc,$msg,$st_id,NULL);
        //----------------------------



      } else {
        $data_arr = array(
          'status' => 0,
          'msg' => 'Already Done'
        );
      }



      return response()->json($data_arr);
    }


    //statge 5 own lead
    if ($request->txtProcessID == 4) {
      $data = DB::table('st_process_action_4')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();
      if ($data == null) {
        DB::table('st_process_action_4')->insert(
          [
            'ticket_id' => $request->txtTicketID,
            'process_id' => $request->txtProcessID,
            'stage_id' => $request->txtStage_ID,
            'action_on' => $request->action_on,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => $request->txtRemarks,
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


        //--------------------------------
        $QUERY_ID = $request->txtTicketID;
        $user_id = Auth::user()->id;
        $msg = $request->txtRemarks;
        $st_id = $request->txtStage_ID;
        $data_sta_arr = AyraHelp::getStageDataBYpostionID($st_id, 4);

        $affected = DB::table('lead_assign')
        ->where('QUERY_ID', $QUERY_ID)
        ->update([
          'current_stage_id' => $data_sta_arr->stage_id,
          'current_lead_stage_name' => $data_sta_arr->stage_name,
        ]);

        $msg_desc = $data_sta_arr->stage_name . ' :Stage is  completed by ' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s');

        $this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, $st_id, NULL);
        //----------------------------

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
        $eventID = 'AJ_ID134';

        $data['message'] = $msg_desc;
        $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
        //puhser 


      } else {
        $data_arr = array(
          'status' => 0,
          'msg' => 'Already Done'
        );
      }



      return response()->json($data_arr);
    }

    //TART :process id is 3: for  NPD
    if ($request->txtProcessID == 3) {

      $data = DB::table('st_process_action_3')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();


      // if($data!=null){
      //   $data_arr= array(
      //     'status'=>0,
      //     'msg'=>'Already process done RND'
      //   );
      //   return response()->json($data_arr);
      // }
      DB::table('st_process_action_3')->insert(
        [
          'ticket_id' => $request->txtTicketID,
          'process_id' => $request->txtProcessID,
          'stage_id' => $request->txtStage_ID,
          'action_on' => $request->action_on,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => $request->txtRemarks,
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
      return response()->json($data_arr);
    }

    //STOP:process id is 3: for  NPD


    if ($request->txtProcessID == 2) {

      //save data if action is perform
      $data = DB::table('st_process_action_2')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->first();

      if ($data != null) {
        $data_arr = array(
          'status' => 0,
          'msg' => 'Already process done'
        );
        return response()->json($data_arr);
      }



      DB::table('st_process_action_2')->insert(
        [
          'ticket_id' => $request->txtTicketID,
          'process_id' => $request->txtProcessID,
          'stage_id' => $request->txtStage_ID,
          'action_on' => $request->action_on,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => $request->txtRemarks,
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_status' => 1,
        ]
      );


      DB::table('qc_bo_purchaselist')
        ->where('id', $request->txtTicketID)
        ->update([
          'status' =>  $request->txtStage_ID,
          'update_statge_on' =>  date('Y-m-d H:i:s'),
          'update_statge_by' =>  Auth::user()->id,
          //'created_at' => date('Y-m-d H:i:s'),
          'bom_Type_from' => null,
          'bom_stage_name_id' =>$request->txtStage_ID,
          'updated_on' => date('Y-m-d H:i:s'),

        ]);


      $data_arr = array(
        'status' => 1,
        'msg' => 'Completed   successfully'
      );
      return response()->json($data_arr);
    }



    if (!$request->action_on) {

      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $request->txtTicketID,
          'process_id' => $request->txtProcessID,
          'stage_id' => $request->txtStage_ID,
          'action_on' => $request->action_on,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => $request->txtRemarks,
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
        'msg' => 'Added Comment successfully'
      );
      return response()->json($data_arr);
    }

    //$data_started=DB::table('st_process_action')->where('ticket_id', $request->txtTicketID)->where('process_id',$request->txtProcessID)->where('stage_id',1)->where('action_on',1)->first();

    if ($request->txtProcessID == 2) {
    } else {
      //check order is started
      $data_started = DB::table('st_process_action')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', 1)->where('action_on', 1)->where('action_status', 1)->first();
      if ($data_started == null) {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if (Auth::user()->id == 85) {
        } else {
          if ($user_role != 'SalesUser') {
            if ($user_role == 'Admin' || $user_role == 'CourierTrk' || Auth::user()->id == 102 || Auth::user()->id == 90) {
            } else {
              $data_arr = array(
                'status' => 0,
                'msg' => 'Order is not started'
              );
              return response()->json($data_arr);
            }
          }
        }
      }

      //check order is started
    }





    //save data if action is perform
    $data = DB::table('st_process_action')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->where('action_status', 1)->first();

    if ($data != null) {
      $data_arr = array(
        'status' => 0,
        'msg' => 'Already process done'
      );
      return response()->json($data_arr);
    } else {

      // ajcode
      //get ordet type
      $form_data = AyraHelp::getQCFormDate($request->txtTicketID);

      $orderType = optional($form_data)->order_type;
      $define_stage_arr = array();
      if ($orderType == 'Private Label') {
        if ($form_data->order_repeat == 2) {

          $define_stage_arr = [1, 0, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
        } else {
          // echo "no repeat";
          $define_stage_arr = [1, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
        }
      }
      if ($orderType == 'Bulk' || $orderType == 'BULK') {
        if ($form_data->qc_from_bulk == 1) {

          $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
        } else {
          $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
        }
      }
      //get ordet type


      foreach ($define_stage_arr as $key => $value) {
        if ($value == 0) {
        } else {

          if ($value == $request->txtStage_ID) {
            if ($value == 1) {
              $sid = 1;
            } else {
              $sid = $define_stage_arr[$key - 1];
            }
          }
        }
      }
      //  get next stage
      for ($i = $request->txtStage_ID; $i < 13; $i++) {
        if ($define_stage_arr[$i] == 0) {
        } else {
          $sid_new = $define_stage_arr[$i];
          break;
        }
      }
      //  get next stage

      // echo $sid_new;
      //  if statge is first then save to bom
      if ($request->txtStage_ID == 1) {

        $qcboms = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
        foreach ($qcboms as $key => $qcbom) {
          if ($qcbom->bom_from != 'From Client') {
            $myqc_data = AyraHelp::getQCFormDate($form_id);
            if ($qcbom->bom_from == 'N/A' || $qcbom->bom_from == 'From Client' || $qcbom->bom_from == 'FromClient') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $myqc_data->order_id;
              $qcbomPObj->form_id = $form_id;
              $qcbomPObj->sub_order_index = $myqc_data->subOrder;
              $qcbomPObj->order_name = $myqc_data->brand_name;
              $qcbomPObj->order_cat = $qcbom->bom_cat;
              $qcbomPObj->material_name = $qcbom->m_name;
              $qcbomPObj->qty = $qcbom->qty;
              $qcbomPObj->created_by = Auth::user()->id;
              $qcbomPObj->save();
            }
          }
        }

        //update status of
        QCFORM::where('form_id', $form_id)
          ->update([
            'artwork_status' => 1
          ]);
        //now skpi purchase and set to art review

        //now skpi purchase and set to art review





      }
      //  if statge is first


      // ajcode
      //check previous is need to done then procced action

      $data_stage_arr = DB::table('st_process_stages')->where('process_id', $request->txtProcessID)->where('stage_id', $sid)->where('prev_done_check', 1)->first(); //1 true 0 false


      if ($data_stage_arr != null) {

        $data = DB::table('st_process_action')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $sid)->where('action_on', 1)->where('action_status', 1)->first();
        if ($data == null) {
          $data_arr = array(
            'status' => 0,
            'msg' => 'Previous Stage yet not completed'
          );
          return response()->json($data_arr);
        }
      }

      //check this stage is dependent if yes
      //make them auto completed them also it self too complete.
      // AyraHelp::getStageDependentFlagChild($request->txtProcessID,$request->txtStage_ID,$request->txtTicketID); //0= no 1=dependent
      // AyraHelp::getStageDependentFlagParent($request->txtProcessID,$request->txtStage_ID,$request->txtTicketID,$request->txtRowCount,$request->txtDependentTicketID); //0= no 1=dependent

      $data_arrme = DB::table('st_process_action')->where('ticket_id', $request->txtTicketID)->where('process_id', $request->txtProcessID)->where('stage_id', $request->txtStage_ID)->where('action_on', 1)->where('action_status', 0)->first();
      if ($data_arrme == null) {

        DB::table('st_process_action')->insert(
          [
            'ticket_id' => $request->txtTicketID,
            'dependent_ticket_id' => $request->txtDependentTicketID,
            'process_id' => $request->txtProcessID,
            'stage_id' => $request->txtStage_ID,
            'action_on' => $request->action_on,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => $request->txtRemarks,
            'attachment_id' => 0,
            'assigned_id' => Auth::user()->id,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
            'action_mark' => 0,
            'action_status' => 1,
          ]
        );
      } else {
        DB::table('st_process_action')
          ->where('ticket_id', $request->txtTicketID)
          ->where('stage_id', $request->txtStage_ID)
          ->where('process_id', $request->txtProcessID)
          ->update(['action_status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'completed_by' => Auth::user()->id]);

        DB::table('st_process_action')->insert(
          [
            'ticket_id' => $request->txtTicketID,
            'dependent_ticket_id' => $request->txtDependentTicketID,
            'process_id' => $request->txtProcessID,
            'stage_id' => $sid_new,
            'action_on' => $request->action_on,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => $request->txtRemarks,
            'attachment_id' => 0,
            'assigned_id' => 1,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
            'action_mark' => 0,
            'action_status' => 0,
          ]
        );

        //skip purchase process
        //   DB::table('st_process_action')->insert(
        //     [
        //       'ticket_id' => $request->txtTicketID,
        //       'dependent_ticket_id' => 0,
        //       'process_id' => $request->txtProcessID,
        //       'stage_id' =>3,
        //       'action_on' => $request->action_on,
        //       'created_at' => date('Y-m-d H:i:s'),
        //       'expected_date' => date('Y-m-d H:i:s'),
        //       'remarks' => $request->txtRemarks,
        //       'attachment_id' =>0,
        //       'assigned_id' => Auth::user()->id,
        //       'undo_status' => 1,
        //       'updated_by' => Auth::user()->id,
        //       'created_status' => 1,
        //       'completed_by' => Auth::user()->id,
        //       'statge_color' => 'completed',
        //       'action_mark' => 0,
        //       'action_status' => 0,
        //     ]
        // );

        //skip purchase process
      }
      //now update stage name and stage id and since

      $data = AyraHelp::getProcessCurrentStage(1, $request->txtTicketID);
      $Spname = $data->stage_name;
      $stage_id = $data->stage_id;
      $days_stayFrom = AyraHelp::getStayFromOrder($request->txtTicketID);

      $affected = DB::table('qc_forms')
        ->where('form_id', $request->txtTicketID)
        //->whereNull('curr_stage_id')
        ->update([
          'curr_stage_id' => $stage_id,
          'curr_stage_name' => $Spname,
          'curr_stage_updated_on' => $days_stayFrom
        ]);

      //now update stage name and 


      $data_arr = array(
        'status' => 1,
        'msg' => 'Process completed successfully'
      );
      return response()->json($data_arr);
    }
  }


  // getAllOrderStagev1_MY_lead
  public function getAllOrderStagev1_MY_lead(Request $request)
  {
    $ticket_id = $request->form_id;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 5:
        $data = DB::table('client_sales_lead')->where('QUERY_ID', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 1:

        break;

      case 2:

        break;
    }

    return AyraHelp::getMasterStageResponseMY_LEAD($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }

  // getAllOrderStagev1_MY_lead


  public function getAllOrderStagev1_lead(Request $request)
  {
    $ticket_id = $request->form_id;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 4:
        $data = DB::table('indmt_data')->where('QUERY_ID', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 1:

        break;

      case 2:

        break;
    }

    return AyraHelp::getMasterStageResponseLEAD($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }

  //view_teams_client
  public function view_teams_client($user_id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'user_id' => $user_id,
    ];


    if ($user_role == 'Admin' || Auth::user()->id == 90 || $user_role == 'SalesUser') {

      return $theme->scope('orders.v1.view_teams_client', $data)->render();
    } else {
      abort('401');
    }
  }

  //view_teams_client

  //view_teams_order
  public function view_teams_order($user_id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'user_id' => $user_id,
    ];


    if ($user_role == 'Admin' || Auth::user()->id == 90 || $user_role == 'SalesUser') {

      return $theme->scope('orders.v1.view_teams_order', $data)->render();
    } else {
      abort('401');
    }
  }
  //view_teams_order
  //getSampleStagesF
  public function getSampleStagesF(Request $request)
  {
    $ticket_id = $request->sampleID;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 6:
        $data = DB::table('sample_items')->where('id', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 1:

        break;

      case 2:

        break;
    }

    return AyraHelp::getMasterStageResponseSAMPLE_Fv2($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }
  //getSampleStagesF

  //getSampleStages
  public function getSampleStages(Request $request)
  {
    $ticket_id = $request->sampleID;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 6:
        $data = DB::table('samples')->where('id', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 1:

        break;

      case 2:

        break;
    }

    return AyraHelp::getMasterStageResponseSAMPLE($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }

  //getSampleStages


  public function getAllOrderStagev1_rnd(Request $request)
  {
    $ticket_id = $request->form_id;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 3:
        $data = DB::table('rnd_new_product_development')->where('id', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 1:

        break;

      case 2:

        break;
    }

    return AyraHelp::getMasterStageResponseRND($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }


  public function getAllOrderStagev1(Request $request)
  {
    $ticket_id = $request->form_id;

    $process_id = $request->process_id;

    switch ($process_id) {
      case 1:
        $data = QCFORM::where('form_id', $ticket_id)->first();
        $rowCount = 1;
        $dependent_ticket = 0;
        break;
      case 2:
        $dependent_ticket = $request->dependent_ticket;
        $data = QC_BOM_Purchase::where('id', $ticket_id)->first();
        $rowCount = AyraHelp::getProcessRowCount($process_id, $ticket_id);
        break;
    }

    return AyraHelp::getMasterStageResponse($process_id, $ticket_id, $data, $rowCount, $dependent_ticket);
  }


  // deleteReqInvoice

  public function deleteReqInvoice(Request $request)
  {


    DB::table('sales_invoice_request')
      ->where('id', $request->form_id)
      ->update(['is_deletd' => 1]);


    $res_arr = array(
      'status' => 1,
      'Message' => 'Deleted Successfully ',
    );


    return response()->json($res_arr);
  }
  // deleteReqInvoice


  public function getSalesInoviceRequest(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    $data = [
      'poc_data' => '',
    ];


    if (Auth::user()->id == 147 || $user_role == 'Admin' || Auth::user()->id == 95 || Auth::user()->id == 132 || Auth::user()->id == 175 || Auth::user()->id == 176 || Auth::user()->id == 185) {

      return $theme->scope('orders.v1.salesInvoiceRequest', $data)->render();
    } else {
      abort('401');
    }
  }

  //getQCDataForModify
  public function getQCDataForModify(Request $request)
  {

    $QCDataArr = DB::table('qc_forms')
      ->select(
        'item_size',
        'item_sp',
        'item_size_unit',
        'item_qty',
        'item_RM_Price',
        'item_BCJ_Price',
        'item_Label_Price',
        'item_Material_Price',
        'item_LabourConversion_Price',
        'item_Margin_Price'
      )
      ->where('form_id', $request->form_id)
      ->first();

    $resp = array(
      'order_data' => $QCDataArr,

    );

    return response()->json($resp);
  }
  //getQCDataForModify

  public function v1Admin_getOrderslist(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    return $theme->scope('orders.v1.admin_orderList', $data)->render();
  }
  public function v1_getOrderslist(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == '147' || Auth::user()->id == '85' ||  Auth::user()->id == '88' ||  Auth::user()->id == '89' || Auth::user()->id == '196' || Auth::user()->id==185 || Auth::user()->id==212 || Auth::user()->id==219 || Auth::user()->id==233 || Auth::user()->id==249) {
      return $theme->scope('orders.v1.orderListAdminView', $data)->render();
    }
    if ($user_role == 'Staff') {
      return $theme->scope('orders.v1.orderListStaffView', $data)->render();
    }
    return $theme->scope('orders.v1.orderList', $data)->render();
  }
  //v1_getOrderslistPending
  public function v1_getOrderslistPending(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == '147' || Auth::user()->id == '85' ||  Auth::user()->id == '88' ||  Auth::user()->id == '89' || Auth::user()->id == '196' || Auth::user()->id==185 || Auth::user()->id==212 || Auth::user()->id==219 || Auth::user()->id==233) {
      return $theme->scope('orders.v1.orderListAdminViewPending', $data)->render();
    }
    if ($user_role == 'Staff') {
      return $theme->scope('orders.v1.orderListStaffView', $data)->render();
    }
    return $theme->scope('orders.v1.orderList', $data)->render();
  }

  //v1_getOrderslistPending



  public function QCAccess(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    if (Auth::user()->id == 1 || Auth::user()->id == 118 ||  Auth::user()->id == 95) {
      return $theme->scope('orders.v1.orderListAccess', $data)->render();
    } else {
      abort('401');
    }
  }
  public function boPurchaseList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    return $theme->scope('orders.v1.purchaseList', $data)->render();
  }
  //boPurchaseListLabelBox
  public function boPurchaseListLabelBox(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    //return $theme->scope('orders.v1.purchaseListLB', $data)->render();
    return $theme->scope('orders.v1.purchaseListLB_v2', $data)->render();
  }

  //boPurchaseListLabelBox

  public function boPurchaseListLB(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    //return $theme->scope('orders.v1.purchaseListLB', $data)->render();
    return $theme->scope('orders.v1.purchaseListLB_v1', $data)->render();
  }




  //v1


  public function viewOrderClient(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    return $theme->scope('orders.viewOrderClient', $data)->render();
  }


  public function getClientOrderReportListFilter(Request $request)
  {
    $data_arr_1 = array();
    if ($request->sales_userid == 'ALL') {
      $month = \Carbon\Carbon::createFromFormat('Y-m-d', $request->txtMonth)->month;
      $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->distinct('client_id')->pluck('client_id');
    } else {
      $month = \Carbon\Carbon::createFromFormat('Y-m-d', $request->txtMonth)->month;

      $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->where('created_by', $request->sales_userid)->distinct('client_id')->pluck('client_id');
    }


    foreach ($datas as $key => $dataRow) {

      $data = AyraHelp::getClientOrderValueFilter($dataRow, $request->txtMonth, $request->sales_userid);
      $client_arr = AyraHelp::getClientbyid($dataRow);
      if (isset($client_arr->added_by)) {
        $cname = AyraHelp::getUser(optional($client_arr)->added_by)->name;
      } else {
        $cname = '';
      }



      $data_arr_1[] = array(
        'RecordID' => 1,
        'company_name' => optional($client_arr)->company,
        'brand_name' => optional($client_arr)->brand,
        'client_id' => optional($client_arr)->id,
        'sales_person' => $cname,
        'order_value' => $data['order_val'],
        'order_percent' => $data['order_percentage'],
        'Actions' => ""
      );
    }






    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'company_name'      => true,
      'brand_name'      => true,
      'client_id'      => true,
      'order_value'      => true,
      'sales_person'      => true,
      'order_percent'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getClientOrderReportList(Request $request)
  {

    $datas = QCFORM::where('is_deleted', 0)->distinct('client_id')->pluck('client_id');

    foreach ($datas as $key => $dataRow) {

      $data = AyraHelp::getClientOrderValue($dataRow);
      $orderCount = AyraHelp::getOrderCountBYClientID($dataRow);
      $client_arr = AyraHelp::getClientbyid($dataRow);
      if (isset($client_arr->added_by)) {
        $cname = AyraHelp::getUser(optional($client_arr)->added_by)->name;
      } else {
        $cname = '';
      }



      $data_arr_1[] = array(
        'RecordID' => 1,
        'company_name' => optional($client_arr)->company,
        'brand_name' => optional($client_arr)->brand,
        'client_id' => optional($client_arr)->id,
        'sales_person' => $cname,
        'order_value' => $data['order_val'],
        'order_percent' => $data['order_percentage'],
        'orderCount' => $orderCount,
        'Actions' => ""
      );
    }






    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'company_name'      => true,
      'brand_name'      => true,
      'client_id'      => true,
      'order_value'      => true,
      'sales_person'      => true,
      'order_percent'      => true,
      'orderCount'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function client_order_report(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];
    return $theme->scope('orders.client_order_report', $data)->render();
  }

  public function client_paymentRecieved_report(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => '',
    ];


    //=================================================
    $lava = new Lavacharts; // See note below for Laravel

    $finances = $lava->DataTable();
    $finances->addStringColumn('Year')
      ->addNumberColumn('Payment Recieved');


    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);

        $client_added = AyraHelp::getCountPaymentRecClientupAddedby($s_userid, 30);

        $finances->addRow([strtoupper($sname[0]), $client_added]);
      }
    }
    $donutchart = \Lava::ColumnChart('FinancesPaymentGF', $finances, [
      'title' => 'Payment Received  History ',
      'titleTextStyle' => [
        'color'    => '#80008',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],

    ]);

    //===================================================


    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];

    if ($user_role == 'Admin' || Auth::user()->id == 90 || Auth::user()->id == 171) {
      return $theme->scope('orders.client_paymentRecieved_report', $data)->render();
    } else {
      abort(401);
    }
  }



  public function getPaymentRecievedReportListFilter(Request $request)
  {
    $yr=$request->txtYear;

    if (empty($request->txtMonth)) {
       $year = intVal(date('Y', strtotime($request->txtYear)));
    
     
      $payment_arr = DB::table('payment_recieved_from_client')
        ->where('created_by', $request->sales_userid)
        ->where('payment_status', 1)
        //->whereMonth('created_at', '=', $month)
        ->whereYear('recieved_on',$yr)
        ->get();
       
    } else {
      $month = date('m', strtotime($request->txtMonth));
      $year = date('Y', strtotime($request->txtYear));

      $payment_arr = DB::table('payment_recieved_from_client')
        ->where('created_by', $request->sales_userid)
        ->where('payment_status', 1)
        ->whereMonth('recieved_on',  $month)
        ->whereYear('recieved_on',$yr)
        ->get();
    }


    $data_arr_1 = array();


    foreach ($payment_arr as $key => $rowData) {
      $client_arr = AyraHelp::getClientbyid($rowData->client_id);
      $recieved_on = date('j-M-Y', strtotime($rowData->recieved_on));
      $created_at = date('j-M-Y : h A', strtotime($rowData->created_at));

      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'recieved_on' => $recieved_on,
        'created_at' => $created_at,
        'rec_amount' => $rowData->rec_amount,
        'rec_amount_words' => $rowData->rec_amount_words,
        'payment_img' => $rowData->payment_img,
        'created_by' => AyraHelp::getUser($rowData->created_by)->name,
        'client_name' => $rowData->client_name,
        'compamy_name' => $rowData->compamy_name,
        'brand' => @$client_arr->brand,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'   => true,
      'recieved_on'      => true,
      'created_at'      => true,
      'rec_amount'      => true,
      'rec_amount_words'      => true,
      'payment_img'      => true,
      'created_by'      => true,
      'client_name'      => true,
      'compamy_name'      => true,
      'brand'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function deletePOC(Request $request)
  {

    $data_arr = POCatalogData::where('id', $request->rowid)->delete();
    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function getPOCInfinite(Request $request)
  {
    $limit = (intval($_GET['limit']) != 0) ? $_GET['limit'] : 10;
    $offset = (intval($_GET['offset']) != 0) ? $_GET['offset'] : 0;

    $results = DB::table('packaging_options_catalog')
      ->select('packaging_options_catalog.*')
      ->skip($offset)
      ->take($limit)
      ->get();

    $HTML = '';

    if (count($results) > 0) {
      foreach ($results as $key => $dataRow) {

        $HTML .= '';
      }
    }
    echo $HTML;
  }

  public function getPOCFilter(Request $request)
  {


    $users = POCatalogData::where('is_active', true);
    $mydata = array();
    \DB::enableQueryLog();

    if (isset($request->poc_type)) {
      $users->where('poc_type', '=', $request->poc_type);
    }
    if (isset($request->poc_material)) {
      $users->where('poc_material', $request->poc_material);
    }

    if (isset($request->poc_color)) {
      $users->where('poc_color', $request->poc_color);
    }
    if (isset($request->poc_sape)) {
      $users->where('poc_sape', $request->poc_sape);
    }
    if (isset($request->poc_name)) {

      $users->where('poc_code', $request->poc_name);
    }

    if (isset($request->poc_code)) {
      $users->where('poc_code	', $request->poc_code);
    }

    if (isset($request->poc_size)) {
      $users->where(function ($query) use ($request) {

        $query->where('poc_size', $request->poc_size);
      });
    }

    $data = $users->get();
    //          $query = \DB::getQueryLog();
    //  print_r(end($query));

    foreach ($data as $key => $rowData) {
      $poc_type_arr = AyraHelp::getBOMItemCategoryID($rowData->poc_type);

      $poc_material_arr = AyraHelp::getBOMItemMaterialID($rowData->poc_material);
      $poc_size_arr = AyraHelp::getBOMItemSizeID($rowData->poc_size);
      $poc_color_arr = AyraHelp::getBOMItemColorID($rowData->poc_color);
      $poc_sape_arr = AyraHelp::getBOMItemSapeID($rowData->poc_sape);


      $mydata[] = array(
        'poc_name' => $rowData->poc_name,
        'img_1' => $rowData->img_1,
        'id' => $rowData->id,
        'poc_type' => $poc_type_arr->cat_name,
        'poc_material' => $poc_material_arr->cat_name,
        'poc_size' => $poc_size_arr->cat_name,
        'poc_color' => $poc_color_arr->cat_name,
        'poc_sape' => $poc_sape_arr->cat_name,
        'poc_code' => $rowData->poc_code,
      );
    }


    return response()->json($mydata);
  }
  public function getPartialOrderQty(Request $request)
  {


    $qcdata_arr_chk = DB::table('order_dispatch_data')->where('form_id', $request->rowid)->where('dispatch_check', 1)->first();
    if ($qcdata_arr_chk == null) {

      //$total_qty_arr = DB::table('order_dispatch_data')->where('form_id',$request->rowid)->latest()->first();
      $total_qty_arr = DB::table('qc_forms')->where('form_id', $request->rowid)->first();

      $total_qty_dispatch = DB::table('order_dispatch_data')->where('form_id', $request->rowid)->sum('unit_in_each_carton');

      $total_qty = $total_qty_arr->item_qty;

      if ($total_qty_dispatch <= $total_qty) {
        return $total_qty - $total_qty_dispatch;
      }
    } else {
      //echo "d";
    }

    //$myqc_data=AyraHelp::getQCFormDate($request->rowid);






  }
  public function getPOCImges(Request $request)
  {
    $datas = POCatalogData::where('id', $request->slideid)->first();
    $data = array(
      'img_1' => $datas->img_1,
      'img_2' => $datas->img_2,
      'img_3' => $datas->img_3,

    );
    return response()->json($data);
  }
  public function viewReportOPlan($plan_id)
  {
    $datas = OPHAchieved::where('plan_id', $plan_id)->get();

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'plan_achived' => $datas,
      'plan_id' => $plan_id,

    ];
    return $theme->scope('sample.viewReportOPlan', $data)->render();
  }
  public function editPOC($poc_id)
  {

    $datas = POCatalogData::where('id', $poc_id)->first();

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'poc_data' => $datas,
    ];
    return $theme->scope('orders.packagingOptionCatelogEdit', $data)->render();
  }
  public function getPOCDataAll()
  {
    $datas = POCatalogData::get();
    foreach ($datas as $key => $rowData) {
      $data_arr_1[] = array(
        'RecordID' => $rowData->id,
        'type' => $rowData->poc_type,
        'size' => $rowData->poc_size,
        'name' => $rowData->poc_name,
        'img_1' => $rowData->img_1,
        'img_2' => $rowData->img_2,
        'img_3' => $rowData->img_3,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'type'      => true,
      'size'      => true,
      'name'      => true,
      'img_1'      => true,
      'img_2'      => true,
      'img_3'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function packagingOptionCategLogList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('orders.packagingOptionCatelogList', $data)->render();
  }
  //saveOPCDataOnlyUpdate
  public function saveOPCDataOnlyUpdate(Request $request)
  {
    $pocID = $request->pocID;

    $validatedData = $request->validate([
      'name' => 'required',
      'material' => 'required',
      'poc_code' => 'required',
      'size' => 'required',
      'color' => 'required',
      'sape' => 'required',
      'poc_price' => 'required',
    ]);


    $objPOC = POCatalogData::find($pocID);
    $objPOC->poc_type = $request->type;
    $objPOC->poc_code = $request->poc_code;
    $objPOC->poc_material = $request->material;
    $objPOC->poc_size = $request->size;
    $objPOC->poc_color = $request->color;
    $objPOC->poc_sape = $request->sape;
    $objPOC->poc_name = $request->name;
    $objPOC->poc_price = $request->poc_price;
    $objPOC->created_by = Auth::user()->id;
    $objPOC->save();
    $saveID = $pocID;


    if ($request->hasfile('file_1')) {
      $file = $request->file('file_1');
      $filename = "img_1" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_1' => $filename]);
    }
    if ($request->hasfile('file_2')) {
      $file = $request->file('file_2');
      $filename = "img_2" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_2' => $filename]);
    }
    if ($request->hasfile('file_3')) {
      $file = $request->file('file_3');

      $filename = "img_3" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_3' => $filename]);
    }
    return back()->with('success', 'Modified Successfully');
  }

  //saveOPCDataOnlyUpdate

  public function saveOPCDataOnly(Request $request)
  {

    $validatedData = $request->validate([
      'name' => 'required',
      'material' => 'required',
      'poc_code' => 'required',
      'size' => 'required',
      'color' => 'required',
      'sape' => 'required',
      'poc_price' => 'required',
    ]);

    $poc_arr = POCatalogData::where('poc_type', $request->type)
      ->where('poc_material', $request->material)
      ->where('poc_size', $request->size)
      ->where('poc_color', $request->color)
      ->where('poc_sape', $request->sape)
      ->where('poc_name', $request->name)
      ->where('poc_price', $request->poc_price)
      ->first();
    if ($poc_arr == null) {
      $objPOC = new POCatalogData;
      $objPOC->poc_type = $request->type;
      $objPOC->poc_code = $request->poc_code;
      $objPOC->poc_material = $request->material;
      $objPOC->poc_size = $request->size;
      $objPOC->poc_color = $request->color;
      $objPOC->poc_sape = $request->sape;
      $objPOC->poc_name = $request->name;
      $objPOC->poc_price = $request->poc_price;
      $objPOC->created_by = Auth::user()->id;
      $objPOC->save();
      $saveID = $objPOC->id;

      if ($request->hasfile('file_1')) {
        $file = $request->file('file_1');
        $filename = "img_1" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);
        POCatalogData::where('id', $saveID)
          ->update(['img_1' => $filename]);
      }
      if ($request->hasfile('file_2')) {
        $file = $request->file('file_2');
        $filename = "img_2" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);
        POCatalogData::where('id', $saveID)
          ->update(['img_2' => $filename]);
      }
      if ($request->hasfile('file_3')) {
        $file = $request->file('file_3');

        $filename = "img_3" . $request->poc_code . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);
        POCatalogData::where('id', $saveID)
          ->update(['img_3' => $filename]);
      }
      return back()->with('success', 'Save Successfully');
    } else {
      return back()->with('success', 'Already Added');
    }
  }
  public function saveOPCDataOnlyBKP(Request $request)
  {

    $objPOC = new POCatalogData;
    $objPOC->poc_type = $request->type;
    $objPOC->poc_size = $request->size;
    $objPOC->poc_name = $request->name;
    $objPOC->created_by = Auth::user()->id;
    $objPOC->save();
    $saveID = $objPOC->id;

    //img 1
    if ($request->hasfile('file_1')) {
      $file = $request->file('file_1');
      $img = Image::make($request->file('file_1'));
      // resize image instance
      $img->resize(500, 450);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "imgPOC" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_1' => 'uploads/qc_form/' . $filename]);
    }
    //img 1
    //img 2
    if ($request->hasfile('file_2')) {
      $file = $request->file('file_2');
      $img = Image::make($request->file('file_2'));
      // resize image instance
      $img->resize(500, 450);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "imgPOC" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_2' => 'uploads/qc_form/' . $filename]);
    }
    //img 2
    //img 3
    if ($request->hasfile('file_3')) {
      $file = $request->file('file_3');
      $img = Image::make($request->file('file_3'));
      // resize image instance
      $img->resize(500, 450);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "imgPOC" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      POCatalogData::where('id', $saveID)
        ->update(['img_3' => 'uploads/qc_form/' . $filename]);
    }
    //img 3

    return back()->with('success', 'Save Successfully');
  }
  public function packagingOptionCategLog(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('orders.packagingOptionCatelog', $data)->render();
  }
  public function dispatchedReport(Request $request)
  {




    //=================================================
    $lava = new Lavacharts;
    $financesDispatch = $lava->DataTable();
    $financesDispatch->addDateColumn('Year')
      ->addNumberColumn('UNITS')
      ->setDateTimeFormat('Y-m-d');
    $follow_arr = $this->getDispachedUnits('OrderDispatchData', 'dispatch_on');

    $data = array();
    foreach ($follow_arr as $key => $value) {
      $data[] = $value;
    }
    $i = 0;

    foreach ($follow_arr as $key => $value) {

      if ($i == 30) {
      } else {
        $financesDispatch->addRow([$key, $data[$i]]);
        $i++;
      }
    }

    $donutchart = \Lava::ColumnChart('BODISPATCH', $financesDispatch, [
      'title' => 'Last 30 Days Dispatched Units :',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'titleTextStyle' => [
        'color'    => '#008080',
        'fontSize' => 14

      ]
    ]);


    //===================================================

    //==========================Monthly=======================
    $lava = new Lavacharts;
    $financesDispatchMonthly = $lava->DataTable();
    $financesDispatchMonthly->addDateColumn('Year')
      ->addNumberColumn('PRICE')
      ->setDateTimeFormat('Y-m-d');
    for ($x = 4; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

      //$active_date=date('Y')."-".$x."-1";


      if ($x >= 5) {
        $active_date = "2021-" . $x . "-1";
      } else {
        $active_date = date('Y') . "-" . $x . "-1";
      }


      $data_output = AyraHelp::getMonthlyDispatchUnits($x);
      $financesDispatchMonthly->addRow([$active_date, $data_output]);
    }

    $donutchart = \Lava::ColumnChart('BODISPATCH_MONTHLY', $financesDispatchMonthly, [
      'title' => 'Monthwise Dispatched Graph :',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'titleTextStyle' => [
        'color'    => '#008089',
        'fontSize' => 14

      ]
    ]);


    //===================================================




    //==========================Monthly====value===================
    $lava = new Lavacharts;
    $financesDispatchMonthlyValue = $lava->DataTable();
    $financesDispatchMonthlyValue->addDateColumn('Year')
      ->addNumberColumn('RS.')

      ->setDateTimeFormat('Y-m-d');
    for ($x = 4; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

      //$active_date=date('Y')."-".$x."-1";

      if ($x >= 5) {
        $active_date = "2021-" . $x . "-1";
      } else {
        $active_date = date('Y') . "-" . $x . "-1";
      }


      $data_output = AyraHelp::getMonthlyDispatchUnits($x);
      $data_outputPrice = AyraHelp::getMonthlyDispatchUnitsPrice($x);

      $financesDispatchMonthlyValue->addRow([$active_date, $data_outputPrice]);
    }

    $donutchart = \Lava::ColumnChart('BODISPATCH_MONTHLYValue', $financesDispatchMonthlyValue, [
      'title' => 'Monthwise dispatch value :',
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'titleTextStyle' => [
        'color'    => '#005411',
        'fontSize' => 14

      ]
    ]);


    //==========================Month_Value=========================


    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.dispatched_Report', $data)->render();
  }
  public function pendingProcessReport(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.pending_process', $data)->render();
  }
  //ajcode new v1
  public function getOrderListOfstageCompleted(Request $request)
  {

    $filter_with = $request->filterFor;
    $stageName = $request->stageName;

    $yesterday = date("Y-m-d", strtotime('-1 days'));
    $today = date("Y-m-d", strtotime('-0 days'));

    $week = date("Y-m-d", strtotime('-1 week'));
    $months = date("Y-m-d", strtotime('-1 months'));
    $filterWithDays = 0;
    if ($filter_with == 1) {
      $filterWithDays = $today;
    }
    if ($filter_with == 2) {
      $filterWithDays = $yesterday;
    }
    if ($filter_with == 3) {
      $filterWithDays = $week;
    }
    if ($filter_with == 3) {
      $filterWithDays = $months;
    }
    //order_statge_id
    //echo $filterWithDays;
    $orderCompleted_arrs = OrderMasterV1::whereDate('completed_on', '>=', $filterWithDays)->where('action_status', 1)->where('stage_id', $stageName)->get();


    // echo "<pre>";


    // print_r($orderCompleted_arrs);
    // die;
    $data_arr_1 = array();

    foreach ($orderCompleted_arrs as $kye => $rowData) {
      // print_r($rowData->form_id);
      $fid = $rowData->ticket_id;

      $user = auth()->user();
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if (Auth::user()->hasPermissionTo('edit-qc-from')) {
        $edit_qc_from = 1;
      } else {
        $edit_qc_from = 0;
      }

      if ($user_role == 'Admin' || $user_role == 'Staff') {
        $qc_arr = QCFORM::where('form_id', $fid)->where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
      } else {
        $qc_arr = QCFORM::where('form_id', $fid)->where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
      }


      $i = 0;

      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));


        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


        if (isset($qc_data_arr->order_statge_id)) {
          $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
          $Spname = optional($statge_arr)->process_name;
          $Spname = str_replace('/', '-', $Spname);
        } else {
          $Spname = '';
        }


        $bulkCount = AyraHelp::getBULKCount($value->form_id);

        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'completed_by' => '44',
          'role_data' => $user_role,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'Actions' => ""
        );
      }
    }






    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'completed_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //ajcode new v1


  public function getOrderListOfstageCompleted_BKP(Request $request)
  {

    $filter_with = $request->filterFor;
    $stageName = $request->stageName;

    $yesterday = date("Y-m-d", strtotime('-1 days'));
    $today = date("Y-m-d", strtotime('-0 days'));

    $week = date("Y-m-d", strtotime('-1 week'));
    $months = date("Y-m-d", strtotime('-1 months'));
    $filterWithDays = 0;
    if ($filter_with == 1) {
      $filterWithDays = $today;
    }
    if ($filter_with == 2) {
      $filterWithDays = $yesterday;
    }
    if ($filter_with == 3) {
      $filterWithDays = $week;
    }
    if ($filter_with == 3) {
      $filterWithDays = $months;
    }

    //echo $filterWithDays;
    $orderCompleted_arrs = OrderMaster::whereDate('completed_on', '>=', $filterWithDays)->where('action_status', 1)->where('order_statge_id', $stageName)->get();

    // echo "<pre>";


    // print_r($orderCompleted_arrs);
    // die;
    $data_arr_1 = array();

    foreach ($orderCompleted_arrs as $kye => $rowData) {
      // print_r($rowData->form_id);
      $fid = $rowData->form_id;

      $user = auth()->user();
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
      if (Auth::user()->hasPermissionTo('edit-qc-from')) {
        $edit_qc_from = 1;
      } else {
        $edit_qc_from = 0;
      }

      if ($user_role == 'Admin' || $user_role == 'Staff') {
        $qc_arr = QCFORM::where('form_id', $fid)->where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
      } else {
        $qc_arr = QCFORM::where('form_id', $fid)->where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
      }


      $i = 0;

      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));


        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


        if (isset($qc_data_arr->order_statge_id)) {
          $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
          $Spname = optional($statge_arr)->process_name;
          $Spname = str_replace('/', '-', $Spname);
        } else {
          $Spname = '';
        }


        $bulkCount = AyraHelp::getBULKCount($value->form_id);

        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'completed_by' => '44',
          'role_data' => $user_role,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'Actions' => ""
        );
      }
    }






    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'completed_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  public function stageCompletdFilterV1()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.stageCompletedFilterV1', $data)->render();
  }


  public function stageCompletdFilter()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.stageCompletedFilter', $data)->render();
  }

  public function BoReports(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layoutReport');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.master', $data)->render();
  }
  // getFilterLeadLMReportCompleted
  public function getFilterLeadLMReportCompleted(Request $request)
  {


    $filterType = $request->lead_status;

    switch ($filterType) {
      case 2:
        //assined lead
        $monthY = date('m', strtotime($request->txtMonth));
        $today = date('Y-m-d', strtotime($request->txtMonth));
        $yearR = $request->txtYear;
        $lastDayofMonth =    \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();
        $last_day = date('d', strtotime($lastDayofMonth));
        $assig_name = "assined by:" . AyraHelp::getUser($request->salesPerson)->name;
        $mydata = [];
        $mydata[] = ['Total', 'Total'];
        for ($i = 1; $i <= $last_day; $i++) {
          $daYA = $i . "-" . $monthY . "-2023";
          $active_date = date('Y-m-d', strtotime($daYA));
          $active_dateShow = date('d M', strtotime($daYA));
          $lead_data = DB::table('lead_assign')->where('assign_by', $request->salesPerson)->whereDate('created_at', $active_date)->count();

          $data_output = $lead_data;
          $mydata[] = [$active_dateShow, $data_output];
        }
        $lead_dataT = DB::table('lead_assign')->where('assign_by', $request->salesPerson)->whereMonth('created_at', $monthY)->count();

        $data[] = array(
          //'step_name'=>$allStage->stage_name,
          'step_name' => 'Lead Assign by:' . $assig_name,
          'step_code' => "AJIPLEAD",
          'step_data' => $mydata,
          'step_totalCount' => $lead_dataT
        );

        //assined lead
        break;

      case 1:
        //irelevent lead
        $monthY = date('m', strtotime($request->txtMonth));
        $today = date('Y-m-d', strtotime($request->txtMonth));
        $yearR = $request->txtYear;
        $lastDayofMonth =    \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();
        $last_day = date('d', strtotime($lastDayofMonth));
        $assig_name = "irrelevant by:" . AyraHelp::getUser($request->salesPerson)->name;
        $mydata = [];
        $mydata[] = ['Total', 'Total'];
        for ($i = 1; $i <= $last_day; $i++) {
          $daYA = $i . "-" . $monthY . "-2023";
          $active_date = date('Y-m-d', strtotime($daYA));
          $active_dateShow = date('d M', strtotime($daYA));
          $lead_data = DB::table('lead_Irrelevant')->where('created_by', $request->salesPerson)->whereDate('created_at', $active_date)->count();
          $data_output = $lead_data;
          $mydata[] = [$active_dateShow, $data_output];
        }
        $lead_dataT = DB::table('lead_Irrelevant')->where('created_by', $request->salesPerson)->whereMonth('created_at', $monthY)->count();

        $data[] = array(
          //'step_name'=>$allStage->stage_name,
          'step_name' => 'Lead ' . $assig_name,
          'step_code' => "AJIPLEAD",
          'step_data' => $mydata,
          'step_totalCount' => $lead_dataT
        );

        //irelevent lead

        break;
      case 5:
        //hold leads
        //irelevent lead
        $monthY = date('m', strtotime($request->txtMonth));
        $today = date('Y-m-d', strtotime($request->txtMonth));
        $yearR = $request->txtYear;
        $lastDayofMonth =    \Carbon\Carbon::parse($today)->endOfMonth()->toDateString();
        $last_day = date('d', strtotime($lastDayofMonth));
        $assig_name = "Hold  by:" . AyraHelp::getUser($request->salesPerson)->name;
        $mydata = [];
        $mydata[] = ['Total', 'Total'];
        for ($i = 1; $i <= $last_day; $i++) {
          $daYA = $i . "-" . $monthY . "-2023";
          $active_date = date('Y-m-d', strtotime($daYA));
          $active_dateShow = date('d M', strtotime($daYA));
          $lead_data = DB::table('lead_Irrelevant')->where('iIrrelevant_type', 5)->where('created_by', $request->salesPerson)->whereDate('created_at', $active_date)->count();
          $data_output = $lead_data;
          $mydata[] = [$active_dateShow, $data_output];
        }
        $lead_dataT = DB::table('lead_Irrelevant')->where('iIrrelevant_type', 5)->where('created_by', $request->salesPerson)->whereMonth('created_at', $monthY)->count();

        $data[] = array(
          //'step_name'=>$allStage->stage_name,
          'step_name' => 'Lead ' . $assig_name,
          'step_code' => "AJIPLEAD",
          'step_data' => $mydata,
          'step_totalCount' => $lead_dataT
        );


        //hold leads
        break;
    }





    return response()->json($data);
  }
  public function getFilterLeadLMReportCompleted99(Request $request)
  {

    $monthY = $request->txtMonth;
    $yearR = $request->txtYear;


    $allStages = AyraHelp::getAllStagesLead();

    $uid = $request->salesPerson;

    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getLeadStageCompletedCountData(30, $allStage->stage_id);
      //$data_outputTotal=200;

      $mydata = [];

      $mydata[] = ['Total', 'Total'];
      for ($x = 30; $x >= 0; $x--) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));
        $active_dateShow = date('d M', strtotime($daYA));
        $data_output = AyraHelp::getLeadStageCompletedCountAjax($active_date, $allStage->stage_id, $uid);
        // $data_output=10;

        $mydata[] = [$active_dateShow, 100];
      }

      $data[] = array(
        //'step_name'=>$allStage->stage_name,
        'step_name' => $allStage->stage_name,
        'step_code' => "AJIPLEAD" . $allStage->stage_id,
        'step_data' => $mydata,
        'step_totalCount' => $data_outputTotal
      );
    }





    return response()->json($data);
  }

  //getFilterLeadCallCompleted
  public function getFilterLeadCallCompleted(Request $request)
  {

    //$allStages = AyraHelp::getAllStagesLead();
    $allStages = DB::table('call_type')->get();



    $uid = $request->salesPerson;

    foreach ($allStages as $stage_key => $allStage) {
      //$data_outputTotal = AyraHelp::getLeadStageCompletedCountData(30, $allStage->stage_id);
      $data_outputTotal = 200;

      $mydata = [];

      $mydata[] = ['Total', 'Total'];
      for ($x = 30; $x >= 0; $x--) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));
        $active_dateShow = date('d M', strtotime($daYA));
        //$data_output = AyraHelp::getLeadStageCompletedCountAjax($active_date, $allStage->stage_id, $uid);
        $data_output = $x;

        $mydata[] = [$active_dateShow, $data_output];
      }

      $data[] = array(
        //'step_name'=>$allStage->stage_name,
        'step_name' => $allStage->name,
        'step_code' => "AJIPLEAD" . $allStage->id,
        'step_data' => $mydata,
        'step_totalCount' => $data_outputTotal
      );
    }





    return response()->json($data);
  }


  //getFilterLeadCallCompleted

  // getFilterLeadLMReportCompleted
  public function getFilterLeadStagesCompleted(Request $request)
  {

    $allStages = AyraHelp::getAllStagesLead();

    $uid = $request->salesPerson;

    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getLeadStageCompletedCountData(30, $allStage->stage_id);
      //$data_outputTotal=200;

      $mydata = [];

      $mydata[] = ['Total', 'Total'];
      for ($x = 30; $x >= 0; $x--) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));
        $active_dateShow = date('d M', strtotime($daYA));
        $data_output = AyraHelp::getLeadStageCompletedCountAjax($active_date, $allStage->stage_id, $uid);
        // $data_output=10;

        $mydata[] = [$active_dateShow, $data_output];
      }

      $data[] = array(
        //'step_name'=>$allStage->stage_name,
        'step_name' => $allStage->stage_name,
        'step_code' => "AJIPLEAD" . $allStage->stage_id,
        'step_data' => $mydata,
        'step_totalCount' => $data_outputTotal
      );
    }





    return response()->json($data);
  }

  public function getFilteruserWiseStageCompleted(Request $request)
  {

    $allStages = AyraHelp::getAllStagesData();

    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getOrderStageCompletedCountData(20, $allStage->step_code);

      $mydata = [];

      $mydata[] = ['Total', 'Total'];
      for ($x = 0; $x <= 20; $x++) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));
        $active_dateShow = date('d M', strtotime($daYA));
        $data_output = AyraHelp::getOrderStageCompletedCountAjax($active_date, $allStage->step_code, $request->user_id);

        $mydata[] = [$active_dateShow, $data_output];
      }

      $data[] = array(
        'step_name' => $allStage->process_name . " by " . AyraHelp::getUser($request->user_id)->name,
        'step_code' => "AJIP" . $allStage->step_code,
        'step_data' => $mydata,
        'step_totalCount' => $data_outputTotal
      );
    }





    return response()->json($data);
  }

  public function getOrderStageDaysWisev1()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel

    //dayswise statge comppleted

    //$allStages=AyraHelp::getAllStagesData();
    $allStages = DB::table('st_process_stages')->where('process_id', 1)->get();


    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getOrderStageCompletedCountDataV1(20, $allStage->stage_id);


      $finances_StageCount = $lava->DataTable();
      $finances_StageCount->addDateColumn('Year')
        ->addNumberColumn('Total:' . $data_outputTotal)
        ->setDateTimeFormat('Y-m-d');

      for ($x = 0; $x <= 19; $x++) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));

        $data_output = AyraHelp::getOrderStageCompletedCountV1($active_date, $allStage->stage_id);

        $finances_StageCount->addRow([$active_date, $data_output]);
      }
      $ajcode = 'AJ' . $allStage->stage_id;



      $donutchart = \Lava::ColumnChart($ajcode, $finances_StageCount, [
        'title' => $allStage->stage_name,
        'titleTextStyle' => [
          'color'    => '#002ee',
          'fontSize' => 14
        ],

      ]);
    }
    $data = [
      'step_code' => ''
    ];

    // echo "<pre>";
    // print_r($donutchart);
    // die;


    //dayswise statge comppleted
    return $theme->scope('reports.orderStageDaywiseV1', $data)->render();
  }


  public function getOrderStageDaysWise()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel

    //dayswise statge comppleted

    $allStages = AyraHelp::getAllStagesData();

    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getOrderStageCompletedCountData(20, $allStage->step_code);

      $finances_StageCount = $lava->DataTable();
      $finances_StageCount->addDateColumn('Year')
        ->addNumberColumn('Total:' . $data_outputTotal)
        ->setDateTimeFormat('Y-m-d');
      for ($x = 0; $x <= 19; $x++) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));

        $data_output = AyraHelp::getOrderStageCompletedCount($active_date, $allStage->step_code);

        $finances_StageCount->addRow([$active_date, $data_output]);
      }
      $donutchart = \Lava::ColumnChart($allStage->step_code, $finances_StageCount, [
        'title' => $allStage->process_name,
        'titleTextStyle' => [
          'color'    => '#002ee',
          'fontSize' => 14
        ],

      ]);
    }
    $data = [
      'step_code' => ''
    ];

    //dayswise statge comppleted
    return $theme->scope('reports.orderStageDaywise', $data)->render();
  }


  public function setProcessSAPChecklist(Request $request)
  {

    $data = SAP_CHECKLISt::where('form_id', $request->form_id)->first();


    if ($data == null) {
      //   DB::table('sap_checklist')->insert(
      //     [
      //        $request->SAPType => $request->sap_flag,
      //       'created_by' => Auth::user()->id,
      //       'form_id' =>$request->form_id,
      //       'updated_by' => Auth::user()->id,
      //       'update_on' => date('Y-m-d H:i:s')
      //    ]
      // );

    } else {
      DB::table('sap_checklist')
        ->where('form_id', $request->form_id)
        ->update([
          $request->SAPType => $request->sap_flag,
          'created_by' => Auth::user()->id,
          'updated_by' => Auth::user()->id,
          'update_on' => date('Y-m-d H:i:s')

        ]);
    }
    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }

  public function setProcessSAPChecklistDEV(Request $request)
  {
    $flight = SAP_CHECKLISt::updateOrCreate(
      ['form_id' => $request->form_id],
      [
        $request->SAPType => $request->sap_flag,
        'created_by' => Auth::user()->id,
        'updated_by' => Auth::user()->id,
        'update_on' => date('Y-m-d H:i:s')
      ]
    );

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function sapCheckList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('operation.sap_checklist', $data)->render();
  }

  public function sap_chklistGraph()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel

    //dayswise statge comppleted

    $allStages = AyraHelp::getAllStagesData();

    foreach ($allStages as $stage_key => $allStage) {
      $data_outputTotal = AyraHelp::getOrderStageCompletedCountData(20, $allStage->step_code);

      $finances_StageCount = $lava->DataTable();
      $finances_StageCount->addDateColumn('Year')
        ->addNumberColumn('Total:' . $data_outputTotal)
        ->setDateTimeFormat('Y-m-d');
      for ($x = 0; $x <= 19; $x++) {
        $daYA = 'today -' . $x . 'days';
        $active_date = date('Y-m-d', strtotime($daYA));

        $data_output = AyraHelp::getOrderStageCompletedCount($active_date, $allStage->step_code);

        $finances_StageCount->addRow([$active_date, $data_output]);
      }
      $donutchart = \Lava::ColumnChart($allStage->step_code, $finances_StageCount, [
        'title' => $allStage->process_name,
        'titleTextStyle' => [
          'color'    => '#002ee',
          'fontSize' => 14
        ],

      ]);
    }
    $data = [
      'step_code' => ''
    ];

    //dayswise statge comppleted
    return $theme->scope('reports.sap_checklist', $data)->render();
  }

  public function getSAPCheckListData(Request $request)
  {

    AyraHelp::SetOrderDataToSAPCHECKLIST(); //insert if not added in saplist

    $data_arr_1 = array();
    $req_val = $request->req_val;
    if ($req_val == 1) {
      $ch = 0;
    } else {
      $ch = 1;
    }
    if (isset($request->favorite)) {
      $favData = $request->favorite;
      $Y = count($favData);
      $query = SAP_CHECKLISt::query();
      $query = $query->leftJoin('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id');
      $query = $query->where('qc_forms.dispatch_status', 1);
      $query = $query->where('qc_forms.is_deleted', 0);

      for ($x = 0; $x < $Y; $x++) {
        if ($favData[$x] == 1) {
          $query = $query->where('sap_so', $ch);
        }
        if ($favData[$x] == 2) {
          $query = $query->where('sap_fg', $ch);
        }
        if ($favData[$x] == 3) {
          $query = $query->where('sap_sfg', $ch);
        }
        if ($favData[$x] == 4) {
          $query = $query->where('sap_production', $ch);
        }
        if ($favData[$x] == 5) {
          $query = $query->where('sap_invoice', $ch);
        }
        if ($favData[$x] == 6) {
          $query = $query->where('sap_dispatch', $ch);
        }
      }

      $rowData = $query->get();
      foreach ($rowData as $qcdata_arrs_key => $qcdata_arrs) {

        $sapdata_arr = AyraHelp::getSAP_CHECKLISTDataINNER($qcdata_arrs->form_id);
        if ($sapdata_arr == null) {
          $sap_so = 'BLNK';
          $sap_fg = 'BLNK';
          $sap_sfg = 'BLNK';
          $sap_production = 'BLNK';
          $sap_invoice = 'BLNK';
          $sap_dispatch = 'BLNK';
        } else {
          $sap_so = $sapdata_arr->sap_so == 0 ? 'BLNK' : 'checked';
          $sap_fg = $sapdata_arr->sap_fg == 0 ? 'BLNK' : 'checked';
          $sap_sfg = $sapdata_arr->sap_sfg == 0 ? 'BLNK' : 'checked';
          $sap_production = $sapdata_arr->sap_production == 0 ? 'BLNK' : 'checked';
          $sap_invoice = $sapdata_arr->sap_invoice == 0 ? 'BLNK' : 'checked';
          $sap_dispatch = $sapdata_arr->sap_dispatch == 0 ? 'BLNK' : 'checked';
        }

        $qc_data_arr = AyraHelp::getCurrentStageByForMID($qcdata_arrs->form_id);

        if (isset($qc_data_arr->order_statge_id)) {
          $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
          $Spname = optional($statge_arr)->process_name;
          $Spname = str_replace('/', '-', $Spname);
        } else {
          $Spname = '';
        }
        $myqc_data = AyraHelp::getQCFormDate($qcdata_arrs->form_id);

        $data_arr_1[] = array(
          'RecordID' => $myqc_data->form_id,
          'order_id' => $myqc_data->order_id . "/" . $myqc_data->subOrder,
          'brand_name' => $myqc_data->brand_name,
          'item_name' => $myqc_data->item_name,
          'curr_stage' => $Spname,
          'sap_so' => $sap_so,
          'sap_fg' => $sap_fg,
          'sap_sfg' => $sap_sfg,
          'sap_production' => $sap_production,
          'sap_invoice' => $sap_invoice,
          'sap_dispatch' => $sap_dispatch,

        );
      }


      // $select_arr=explode(',',$request->favorite);

      //SAP_CHECKLISt::where()->get();

    } else {


      //$qcdata_arrs=QCFORM::where('is_deleted',0)->get();
      $qcdata_arrs = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->get();
      foreach ($qcdata_arrs as $qcdata_arrs_key => $qcdata_arrs) {

        $sapdata_arr = AyraHelp::getSAP_CHECKLISTData($qcdata_arrs->form_id);

        if ($sapdata_arr == null) {

          $sap_so = 'BLNK';
          $sap_fg = 'BLNK';
          $sap_sfg = 'BLNK';
          $sap_production = 'BLNK';
          $sap_invoice = 'BLNK';
          $sap_dispatch = 'BLNK';
        } else {

          $sap_so = $sapdata_arr->sap_so == 0 ? 'BLNK' : 'checked';
          $sap_fg = $sapdata_arr->sap_fg == 0 ? 'BLNK' : 'checked';
          $sap_sfg = $sapdata_arr->sap_sfg == 0 ? 'BLNK' : 'checked';
          $sap_production = $sapdata_arr->sap_production == 0 ? 'BLNK' : 'checked';
          $sap_invoice = $sapdata_arr->sap_invoice == 0 ? 'BLNK' : 'checked';
          $sap_dispatch = $sapdata_arr->sap_dispatch == 0 ? 'BLNK' : 'checked';
        }

        $qc_data_arr = AyraHelp::getCurrentStageByForMID($qcdata_arrs->form_id);


        if (isset($qc_data_arr->order_statge_id)) {
          $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
          $Spname = optional($statge_arr)->process_name;
          $Spname = str_replace('/', '-', $Spname);
        } else {
          $Spname = '';
        }

        $data_arr_1[] = array(
          'RecordID' => $qcdata_arrs->form_id,
          'order_id' => $qcdata_arrs->order_id . "/" . $qcdata_arrs->subOrder,
          'brand_name' => $qcdata_arrs->brand_name,
          'item_name' => $qcdata_arrs->item_name,
          'curr_stage' => $Spname,
          'sap_so' => $sap_so,
          'sap_fg' => $sap_fg,
          'sap_sfg' => $sap_sfg,
          'sap_production' => $sap_production,
          'sap_invoice' => $sap_invoice,
          'sap_dispatch' => $sap_dispatch,

        );
      }
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'brand_name'     => true,
      'item_name'     => true,
      'curr_stage'     => true,
      'sap_so'     => true,
      'sap_fg'     => true,
      'sap_sfg'     => true,
      'sap_production'     => true,
      'sap_invoice'     => true,
      'sap_dispatch'     => true,

    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function getStagesByTeamWithFilter(Request $request)
  {
    $filter_with = $request->filterType;
    $today = date("Y-m-d", strtotime('-0 days'));
    $yesterday = date("Y-m-d", strtotime('-1 days'));
    $week = date("Y-m-d", strtotime('-1 week'));
    $months = date("Y-m-d", strtotime('-1 months'));
    if ($filter_with == 1) {
      $filterWithDays = $yesterday;
    }
    if ($filter_with == 2) {
      $filterWithDays = $week;
    }
    if ($filter_with == 3) {
      $filterWithDays = $months;
    }
    if ($filter_with == 4) {
      $filterWithDays = $today;
    }
    // echo $filterWithDays;
    $opd_arrs = OPDays::get(); //private order
    $HTML = '';
    foreach ($opd_arrs as  $key => $rows) {
      $step_id = $rows->order_step;
      $mydata = array();

      $countData = OPData::where('step_id', $step_id)->where('status', 1)->whereDate('created_at', $filterWithDays)->distinct()->get(['created_by']);
      foreach ($countData as $key => $row) {
        $countData = OPData::where('created_by', $row->created_by)->where('step_id', $step_id)->where('status', 1)->whereDate('created_at', $filterWithDays)->get();
        $user = AyraHelp::getUser($row->created_by);
        $mydata[] = array(
          'name' => $user->name,
          'count' => count($countData)

        );
      }
      //HTML CODE
      $HTML .= '<div class="col-md-4">
        <!--begin::Portlet-->
            <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon">
                                                    <i class="la la-thumb-tack m--font-success"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text m--font-primary">
                                                   ' . $rows->process_name . '
                                                </h3>
                                            </div>
                                        </div>
                                        </div>

                                    <div class="m-portlet__body">
                                       <!--begin::Preview-->
                    <div class="m-demo">
                                                    <div class="m-demo__preview">
                                                        <div class="m-list-search">
                                                            <div class="m-list-search__results">';


      foreach ($mydata as $key => $myval) {

        $HTML .= '<a href="#" class="m-list-search__result-item">
                                                            <span class="m-list-search__result-item-pic"><span class="m-badge m-badge--primary">' . $myval['count'] . '</span></span>
                                                       <span class="m-list-search__result-item-text">' . $myval['name'] . '</span>
                                                        </a>';
      }






      $HTML .= '</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--end::Preview-->

                                    </div>
                                </div>

                                <!--end::Portlet-->

    </div>';
      //HTML CODE


    }
    echo $HTML;
  }

  public function getStagesReportbyteam(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => ''
    ];
    return $theme->scope('reports.Stagesbyteam', $data)->render();
  }

  public function getCurrentOrderStagesData(Request $request)
  {
    $form_id = $request->form_id;
    //get purchase details with status
    $bom_arrs = QC_BOM_Purchase::where('form_id', $form_id)->get();
    $BO_HTML = '';
    $BO_HTML .= '<div class="m-section">

  <div class="m-section__content">
    <table class="table table-sm m-table m-table--head-bg-brand">
      <thead class="thead-inverse">
        <tr>
          <th>#</th>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Stage Name</th>
          <th>Last Updates</th>
          <th>Updated by</th>
        </tr>
      </thead>
      <tbody>';
    $i = 0;
    foreach ($bom_arrs as $key => $myRow) {
      $item_name = $myRow->material_name;
      $qty = $myRow->qty;
      $i++;
      if (isset($myRow->update_statge_on)) {
        $update_statge_on = date("l d,M Y h:iA", strtotime($myRow->update_statge_on));
      } else {
        $update_statge_on = 'N/A';
      }

      $up_arr = AyraHelp::getUser($myRow->update_statge_by);

      $stage = '';

      switch ($myRow->status) {
        case 1:
          $stage = 'NOT STARTED';
          break;
        case 2:
          $stage = 'DESIGN AWAITED';
          break;
        case 3:
          $stage = 'WAITING FOR QUOTATION';
          break;
        case 4:
          $stage = 'SAMPLE AWAITED';
          break;
        case 5:
          $stage = 'PAYMENT AWAITED';
          break;
        case 6:
          $stage = 'ORDERED';
          break;
        case 7:
          $stage = 'RECEIVED /IN STOCK';
          break;
        case 8:
          $stage = 'AWAITED FROM CLIENT';
          break;
      }
      $BO_HTML .= '
            <tr>
              <th scope="row">' . $i . '</th>
              <td>' . $item_name . '</td>
              <td>' . $qty . '</td>
              <td>' . $stage . '</td>
              <td>' . $update_statge_on . '</td>
              <td>' . optional($up_arr)->name . '</td>
            </tr>';
    }
    $BO_HTML .= '
          </tbody>
          </table>
        </div>
      </div>';
    //get purchase details with status


    $qc_data = AyraHelp::getQCFormDate($form_id);
    $master_datas = AyraHelp::getOrderMaster($form_id);
    $data_arr_1 = array();
    foreach ($master_datas as $key_opd => $master_data) {
      $step_code = $master_data->order_statge_id;
      $completed_on = date("d,M Y", strtotime($master_data->completed_on));
      $step_arr = AyraHelp::getStageNameByCode($step_code);
      $user_arr = AyraHelp::getUser($master_data->assigned_by);
      $data_arr_1[] = array(
        'statgeName' => $step_arr->process_name,
        'completed_on' => $completed_on,
        'completed_by' => $user_arr->name
      );
    }
    $dp_data = AyraHelp::getDispatchedDataView($form_id);

    $resp = array(
      'qc_data' => $qc_data,
      'qc_dispatched' => $dp_data,
      'order_stages' => $data_arr_1,
      'BOM_HTML' => $BO_HTML,
      'order_stagesList' => $this->getOrderWizardStepsFormID($form_id)
    );
    return response()->json($resp);
  }

  public function getOrderList($step_code, $mycolor)
  {
    if ($mycolor == 'my_green') {
      $action_mark = 1;
    } else {
      $action_mark = 0;
    }
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'step_code' => $step_code,
      'action_mark' => $action_mark,
    ];
    return $theme->scope('sample.qc_orderPendingList', $data)->render();
  }

  public function getOrderList_($step_code, $mycolor)
  {

    if ($mycolor == 'my_green') {
      $action_mark = 1;
    } else {
      $action_mark = 0;
    }
    $arr_data_green = OrderMaster::where('order_statge_id', $step_code)->where('action_status', 0)->where('action_mark', $action_mark)->get();
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'data' => $arr_data_green

    ];
    return $theme->scope('sample.orderStagesReportList', $data)->render();
  }
  public function getOrderStatgesReport(Request $request)
  {
    $sales_arr = AyraHelp::getSalesAgentAdmin();
    foreach ($sales_arr as $key_opd => $users) {
      //$data_qc_arr=OrderMaster::where('assigned_by',$users->id)->where('action_status',0)->where('order_statge_id','ART_WORK_RECIEVED')->get();
     // $data_qc_arr = DB::table('st_process_action')->where('completed_by', $users->id)->where('action_status', 0)->where('stage_id', 1)->count();

      $data_qc_arr = DB::table('qc_forms')
      ->join('st_process_action', 'qc_forms.form_id', '=', 'st_process_action.ticket_id')      
      ->where('qc_forms.is_deleted',0)
      ->where('st_process_action.completed_by',$users->id)
      ->where('st_process_action.action_status',0)
      ->where('st_process_action.stage_id',1)
      ->count();






      $data_arr_1[] = array(
        'sale_person' => $users->name,
        'pending_count' => $data_qc_arr,
        'order_data' => ''
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'sale_person'     => true,
      'pending_count'     => true,
      'order_data'     => true,

    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function orderStagesReport(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'order_process_days' => '',

    ];
    return $theme->scope('sample.orderStagesReport', $data)->render();
  }

  //getQCFormOrderDataPricePart
  public function getQCFormOrderDataPricePart(Request $request)
  {
    $data_qc_arr = QCFORM::where('form_id', $request->rowid)->get()->first();


    $data_qc_arrReq = DB::table('qcforms_pricepart_edit_request')->where('form_id', $request->rowid)
      ->first();

    $qcData = array(
      'item_RM_Price' => $data_qc_arr->item_RM_Price,
      'item_BCJ_Price' => $data_qc_arr->item_BCJ_Price,
      'item_Label_Price' => $data_qc_arr->item_Label_Price,
      'item_Material_Price' => $data_qc_arr->item_Material_Price,
      'item_LabourConversion_Price' => $data_qc_arr->item_LabourConversion_Price,
      'item_Margin_Price' => $data_qc_arr->item_Margin_Price,
      'price_part_status' => $data_qc_arr->price_part_status,
      'item_qty' => $data_qc_arr->item_qty,
      'item_sp' => $data_qc_arr->item_sp,
      'orderVal' => ($data_qc_arr->item_qty * $data_qc_arr->item_sp)

    );

    if ($data_qc_arrReq == null) {
      $qcDataREQ = array();
    } else {
      $qcDataREQ = array(
        'item_RM_Price' => $data_qc_arrReq->item_RM_Price,
        'item_BCJ_Price' => $data_qc_arrReq->item_BCJ_Price,
        'item_Label_Price' => $data_qc_arrReq->item_Label_Price,
        'item_Material_Price' => $data_qc_arrReq->item_Material_Price,
        'item_LabourConversion_Price' => $data_qc_arrReq->item_LabourConversion_Price,
        'item_Margin_Price' => $data_qc_arrReq->item_Margin_Price,
        'item_qty' => $data_qc_arrReq->item_qty,
        'item_sp' => $data_qc_arrReq->item_sp,
        'item_size' => $data_qc_arrReq->item_size,
        'orderVal' => ($data_qc_arrReq->item_qty * $data_qc_arrReq->item_sp)

      );
    }



    $resp = array(
      'qc_dataPrice' => $qcData,
      'qc_dataPriceReq' => $qcDataREQ
    );

    return response()->json($resp);
  }
  //getQCFormOrderDataPricePart


  public function getQCFormOrderData(Request $request)
  {

    $data_qc_arr = QCFORM::where('form_id', $request->rowid)->get()->first();
    $usr_arr = AyraHelp::getUser($data_qc_arr->created_by);
    $usr_arr_client = AyraHelp::getClientbyid($data_qc_arr->client_id);
    $orR = $data_qc_arr->order_repeat == 2 ? "YES" : "No";
    if ($orR == 'YES') {
      $ajORP = $orR . "(" . $data_qc_arr->pre_order_id . ")";
    } else {
      $ajORP = $orR;
    }
    if (Auth::user()->hasPermissionTo('viewOrderSp')) {
      $sp_view = 1;
    } else {
      $sp_view = 0;
    }

    
    if($data_qc_arr->order_type=="Private Label"){
      $qc_data_MoreStatus="Private Label";
      $qc_forms_bomData = DB::table('qc_forms_bom')
      ->where('form_id', $request->rowid)
      ->whereNotNull('m_name')
      ->get();


      $qc_forms_packing_processArr = DB::table('qc_forms_packing_process')
      ->where('qc_from_id', $request->rowid)
     
      ->get();
      
      

      $HTML="";
      
      $HTML .='<table class="table table-bordered m-table m-table--border-success">
													<thead>
														<tr>
															<th>MATERIAL</th>
															<th>QUANTITY REQUIRED</th>
															<th>FROM</th>
															<th>CATEGORY</th>
														</tr>
													</thead>
													<tbody>';
                          foreach ($qc_forms_bomData as $key => $rowData) {
                            $HTML .='<tr>
                            <th scope="row">'.@$rowData->m_name.'</th>
                            <th scope="row">'.@$rowData->qty.'</th>
                            <th scope="row">'.@$rowData->bom_from.'</th>
                            <th scope="row">'.@$rowData->bom_cat.'</th>
                          </tr>';
                          }
                          
													
													
													$HTML .='</tbody>
												</table>';


                        $HTML .='<table class="table table-bordered m-table m-table--border-success">
                        <thead>
                          <tr>
                            <th>LABEL</th>
                            <th>YES</th>
                            <th>NO</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>';
                        foreach ($qc_forms_packing_processArr as $key => $rowData) {
                          $HTML .='<tr>
                          <th scope="row">'.@$rowData->qc_label.'</th>
                          <th scope="row">'.@$rowData->qc_yes.'</th>
                          <th scope="row">'.@$rowData->qc_no.'</th>
                          <th scope="row"></th>
                          
                        </tr>';
                        }
                        
                        
                        
                        $HTML .='</tbody>
                      </table>';



    }else{
      $qc_data_MoreStatus="Bulk";
      
      $qc_bulk_order_formArr = DB::table('qc_bulk_order_form')
            ->where('form_id', $request->rowid)
            ->whereNotNull('item_name')
            ->get();
            $HTML="";
            
      
            $HTML .='<table class="table table-bordered m-table m-table--border-success">
                                <thead>
                                  <tr>
                                    <th>MATERIAL NAME</th>
                                    <th>RATE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL AMT</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                $kgSum=0;
                                $ICSum=0;
                                foreach ($qc_bulk_order_formArr as $key => $rowData) {
                                  $kgSum=$kgSum+$rowData->qty;
                                  $ICSum=$ICSum+$rowData->item_sell_p;
                                  $HTML .='<tr>
                                  <th scope="row">'.@$rowData->item_name.'</th>
                                  <th scope="row">'.@$rowData->rate.'</th>
                                  <th scope="row">'.@$rowData->qty.' '.@$rowData->item_size.'</th>
                                  <th scope="row">'.@$rowData->item_sell_p.'</th>
                                 
                                </tr>';

                                }
                                $HTML .='<tr>
                                <th scope="row" colspan="2" >SUM</th>
                               
                                <th scope="row">'.@$kgSum.'</th>
                                <th scope="row">₹. '.@$ICSum.' .</th>
                               
                              </tr>';
                                 
                                 
                                $HTML .='</tbody>
                              </table>';


    }
    //Private Label
    

    $qcData = array(
      'form_id' => $data_qc_arr->form_id,
      'order_id' => $data_qc_arr->order_id . "/" . $data_qc_arr->subOrder,
      'order_type' => $data_qc_arr->order_type,
      'sales_person' => $usr_arr->name,
      'brand_name' => $data_qc_arr->brand_name,
      'item_name' => $data_qc_arr->item_name,
      'client_name' => optional($usr_arr_client)->firstname,
      'client_email' => optional($usr_arr_client)->email,
      'client_phone' => optional($usr_arr_client)->phone,
      'client_company' => optional($usr_arr_client)->company,
      'client_gstno' => optional($usr_arr_client)->gstno,
      'client_address' => optional($usr_arr_client)->address,
      'created_at' => date('j F Y H:iA', strtotime($data_qc_arr->created_at)),
      'order_repeat' => $ajORP,
      'fms' => $data_qc_arr->item_fm_sample_no,
      'size' => $data_qc_arr->item_size . " " . $data_qc_arr->item_size_unit,
      'qty' => $data_qc_arr->item_qty . " " . $data_qc_arr->item_qty_unit,
      'sp' => '<i class="fa fa-rupee-sign"></i> ' . $data_qc_arr->item_sp . "/" . $data_qc_arr->item_sp_unit,
      'orderFor' => $data_qc_arr->export_domestic == 1 ? "DOMESTIC" : "EXPORT",
      'fragrance' => $data_qc_arr->order_fragrance,
      'order_color' => $data_qc_arr->order_color,
      
      'orderVal' => '<i class="fa fa-rupee-sign"></i> ' . $data_qc_arr->item_sp * $data_qc_arr->item_qty,
      'sp_view' => $sp_view,
      'img_url' => optional($data_qc_arr)->pack_img_url,
    );
    $resp = array(
      'qc_data' => $qcData,      
      'qc_data_MoreData' => $HTML,
      'qc_data_MoreStatus' => $qc_data_MoreStatus,

    );

    return response()->json($resp);
  }

  public function setgetQCFromProductionStage(Request $request)
  {
    QC_BOM_Purchase::where('id', $request->recordID)->update(['status' => $request->s_status]);
    $myorderStagelogObj = new QC_BOM_PurchaseLog;
    $myorderStagelogObj->purchase_id = $request->recordID;
    $myorderStagelogObj->status = $request->s_status;
    $myorderStagelogObj->created_by = Auth::user()->id;
    $myorderStagelogObj->save();
    $res_arr = array(
      'status' => 1,
      'data' => '',
      'Message' => 'Purchase Order Staging ',
    );
    return response()->json($res_arr);
  }

  public function setQCPurchaseStatus(Request $request)
  {
    $plist_arr = QC_BOM_Purchase::where('id', $request->recordID)->first();
    $doneOk = AyraHelp::checkPurchaeStageIsDone($plist_arr->form_id);
    QC_BOM_Purchase::where('id', $request->recordID)->update(['status' => $request->s_status, 'update_statge_on' => date('Y-m-d H:i:s'), 'update_statge_by' => Auth::user()->id]);
    $myorderStagelogObj = new QC_BOM_PurchaseLog;
    $myorderStagelogObj->purchase_id = $request->recordID;
    $myorderStagelogObj->status = $request->s_status;
    $myorderStagelogObj->created_by = Auth::user()->id;
    $myorderStagelogObj->save();
    if ($doneOk) {
      $QCData = AyraHelp::getQCFormDate($plist_arr->form_id);
      if ($QCData->order_type == 'Bulk') {
      } else {

        $mydatarr = OPData::where('order_id_form_id', $plist_arr->form_id)->where('step_id', 2)->where('status', 1)->first();
        if ($mydatarr == null) {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $plist_arr->form_id; //formid and order id
          $opdObj->step_id = 2;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Completed by Purchase Side';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = 0;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second after';
          $opdObj->save();
        }



        // OrderMaster::where('form_id', $plist_arr->form_id)
        // ->where('order_statge_id','$mystage_arr_ori->step_code')
        // ->update(['action_status' => 1,'completed_on' => date('Y-m-d')]); //done




      }
    }

    $res_arr = array(
      'status' => 1,
      'data' => '',

      'Message' => 'Purchase Order Staging ',
    );
    return response()->json($res_arr);
  }
  //setQCProductionStatus

  public function setQCProductionStatus(Request $request)
  {
    QCFORM::where('form_id', $request->recordID)->update(['production_curr_statge' => $request->s_status]);

    $myorderStagelogObj = new QC_ProductionLog;
    $myorderStagelogObj->form_id = $request->recordID;
    $myorderStagelogObj->status = $request->s_status;
    $myorderStagelogObj->created_by = Auth::user()->id;
    $myorderStagelogObj->save();



    if ($request->s_status == 6) {
      //completed that production
      $qc_data = QCFORM::where('form_id', $request->recordID)->first();
      if ($qc_data->order_type == 'Bulk') {

        $mydata_arr = OPData::where('order_id_form_id', $request->recordID)->where('step_id', 2)->first();

        if ($mydata_arr == null) {

          $opdObj = new OPData;
          $opdObj->order_id_form_id = $request->recordID; //formid and order id
          $opdObj->step_id = 2;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Completed by production';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = 0;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second after';
          $opdObj->save();



          // $mstOrderObj=new OrderMaster;
          // $mstOrderObj->form_id =$request->recordID;
          // $mstOrderObj->assign_userid =0;
          // $mstOrderObj->order_statge_id ='PRODUCTION';
          // $mstOrderObj->assigned_by =Auth::user()->id;
          // $mstOrderObj->assigned_on =date('Y-m-d');
          // $mstOrderObj->expected_date =date('Y-m-d');
          // $mstOrderObj->action_status =1;
          // $mstOrderObj->completed_on =date('Y-m-d');
          // $mstOrderObj->action_mark =1;
          // $mstOrderObj->assigned_team =4; //sales user
          // $mstOrderObj->save();


          OrderMaster::where('form_id', $request->recordID)
            ->where('order_statge_id', 'PRODUCTION')
            ->update([
              'action_status' => 1,
            ]);

          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $request->recordID;
          $mstOrderObj->assign_userid = 0;
          $mstOrderObj->order_statge_id = 'QC_CHECK';
          $mstOrderObj->assigned_by = Auth::user()->id;
          $mstOrderObj->assigned_on = date('Y-m-d');
          $mstOrderObj->expected_date = date('Y-m-d');
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = date('Y-m-d');
          $mstOrderObj->action_mark = 1;
          $mstOrderObj->assigned_team = 2; //sales user
          $mstOrderObj->save();
        }
      } else {
        if ($qc_data->order_repeat == 1) {
          //PL-N
          $mydata_arr = OPData::where('order_id_form_id', $request->recordID)->where('step_id', 8)->first();

          if ($mydata_arr == null) {
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->recordID; //formid and order id
            $opdObj->step_id = 8;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Completed by production';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = 0;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second after';
            $opdObj->save();

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->recordID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PRODUCTION';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = date('Y-m-d');
            $mstOrderObj->action_status = 1;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 4; //sales user
            $mstOrderObj->save();

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->recordID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'QC_CHECK';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = date('Y-m-d');
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
        }
        if ($qc_data->order_repeat == 2) {
          //PL-R
          $mydata_arr = OPData::where('order_id_form_id', $request->recordID)->where('step_id', 4)->first();

          if ($mydata_arr == null) {

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->recordID; //formid and order id
            $opdObj->step_id = 4;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Completed by production';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = 0;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second after';
            $opdObj->save();

            OrderMaster::where('form_id', $request->recordID)
              ->where('order_statge_id', 'PRODUCTION')
              ->update([
                'action_status' => 1,
              ]);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->recordID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'QC_CHECK';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = date('Y-m-d');
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
        }
      }



      // $opdObj=new OPData;
      // $opdObj->order_id_form_id=$plist_arr->form_id; //formid and order id
      // $opdObj->step_id=2;
      // $opdObj->expected_date=date('Y-m-d');
      // $opdObj->remaks='Completed by Purchase Side';
      // $opdObj->created_by=Auth::user()->id;
      // $opdObj->assign_userid=0;
      // $opdObj->status=1;
      // $opdObj->step_status=0;
      // $opdObj->color_code='completed';
      // $opdObj->diff_data='1 second after';
      // $opdObj->save();
    }




    $res_arr = array(
      'status' => 1,
      'data' => '',

      'Message' => 'Purchase Order Staging ',
    );
    return response()->json($res_arr);
  }

  public function getMonthlySalesReport()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'order_process_days' => '',
    ];
    //code for show sales values monthly
    //code for order values
    $lava = new Lavacharts; // See note below for Laravel




    $sales_arrA = AyraHelp::getSalesAgentOnlyWITHSTAFF();

    foreach ($sales_arrA as $key => $value) {

      $finances_orderValue = $lava->DataTable();
      $finances_orderValue->addDateColumn('Year')
        ->addNumberColumn('Order Value')
        ->setDateTimeFormat('Y-m-d');

      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        //code to show data
        $sname = explode(" ", $value->name);

        for ($x = 1; $x <= 12; $x++) {
          $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));

          //$active_date=date('Y')."-".$x."-1";
          if ($x >= date('m')+1) {
            $active_date = "2022-" . $x . "-1";
          } else {
            //$active_date = date('Y') . "-" . $x . "-1";
            $active_date = "2023-" . $x . "-1";
          }

          $data_output = AyraHelp::getOrderValueFilterByUser($x, $s_userid);
          $finances_orderValue->addRow([$active_date, $data_output]);
        }


        //   $finances_orderValue->addRow([strtoupper($sname[0]),$notes,$followups,$client_added]);


        //code to show data

      }


      $bo_level = 'BO_SALES' . $s_userid;


      $donutchart = \Lava::ColumnChart($bo_level, $finances_orderValue, [
        'title' => 'Order Value of ' . $value->name,
        'titleTextStyle' => [
          'color'    => '#008080',
          'fontSize' => 14
        ],

      ]);
    }









    //code for order values
    //code for show sales values monthly

    return $theme->scope('reports.monthly_sales', $data)->render();
  }

  public function getQCFromProduction(Request $request)
  {
    $orderData = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {
      $sent_datev = date("d,M Y", strtotime($orderval->created_at));
      //unit code

      $sizeUnit = $orderval->item_size . " " . $orderval->item_size_unit;

      if ($orderval->item_size_unit == 'Kg' || $orderval->item_size_unit == 'L') {

        if ($orderval->item_size_unit == 'Kg') {
          $batchUnitview = " kg";
        } else {
          $batchUnitview = "L";
        }

        $nounit = ($orderval->item_qty) . " " . $orderval->item_qty_unit;
        $batchSize = ceil(((($orderval->item_qty) * ($orderval->item_size)))) . "" . $batchUnitview;
      }

      if ($orderval->item_size_unit == 'Ml' || $orderval->item_size_unit == 'Gm') {
        if ($orderval->item_size_unit == 'Ml') {
          $batchUnitview = "L";
        } else {
          $batchUnitview = "Kg";
        }
        $nounit = $orderval->item_qty . " " . $orderval->item_qty_unit;
        $batchSize = (ceil((($orderval->item_qty) * ($orderval->item_size)) / 1000)) . "" . $batchUnitview;
      }

      //unit code
      // current order stage
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
      } else {
        $Spname = '';
      }

      // current order stage
      //get data or purchase stock availeb
      $mydata = AyraHelp::getPurcahseStockRecivedOrder($orderval->form_id);
      //get data or purchase stock availeb




      $data_arr_1[] = array(
        'RecordID' => $orderval->form_id,
        'order_id' => $orderval->order_id . "/" . $orderval->subOrder,
        'brand_name' => $orderval->brand_name,
        'order_index' => $orderval->order_index,
        'item_name' => $orderval->item_name,
        'purchaseReciveInStock' => $mydata,
        'fm_sampleno' => $orderval->item_fm_sample_no,
        'created_at' => $sent_datev,
        'item_size_unit' => $sizeUnit,
        'item_qty_unit' => $nounit,
        'batch_size' => $batchSize,
        'order_statge' => 1,
        'order_statge_curr' => $orderval->production_curr_statge,
        'order_stageData' => $Spname,
        'sales_person' => $orderval->item_qty_unit
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'brand_name'     => true,
      'order_index'     => true,
      'item_name'     => true,
      'purchaseReciveInStock' => true,
      'fm_sampleno'  => true,
      'created_at'  => true,
      'item_size_unit'  => true,
      'item_qty_unit'  => true,
      'batch_size'  => true,
      'order_statge'  => true,
      'order_statge_curr'  => true,
      'order_stageData'  => true,
      'sales_person'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getPurchaseListHistory(Request $request)
  {



    $orderData = QCPurchaseEditHistory::orderBy('order_id', 'DESC')->get();

    //


    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {

      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);

      //current  order statge
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
      } else {
        $Spname = '';
      }

      //current  order statge





      $data_arr_1[] = array(
        'RecordID' => $orderval->id,
        'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
        'brand_name' => $orderval->order_name,
        'order_item_name' => $qc_data->item_name,
        'order_index' => $mydataOK[1],
        'item_name' => $orderval->material_name,
        'qty' => $orderval->qty,
        'category' => $orderval->order_cat,
        'Status' => $orderval->status,
        'order_statge' => $Spname,
        'sales_person' => '',
      );
    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,

      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'Status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }


  public function getPurchaseListQCFROMArtWorkAllOther(Request $request)
  {
    $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('status', 2)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {


      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);

      //current  order statge
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
        $ajStepCode = optional($statge_arr)->step_code;
      } else {
        $Spname = '';
        $ajStepCode = '';
      }
      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);



      if ($ajStepCode != 'ART_WORK_RECIEVED') {
        // ajcode
        if ($request->purchaseFlag == 1) {
          //not lanel and box
          if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          } else {
            $data_arr_1[] = array(
              'RecordID' => $orderval->id,
              'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
              'brand_name' => $orderval->order_name,
              'order_item_name' => $qc_data->item_name,
              'order_index' => $mydataOK[1],
              'item_name' => $orderval->material_name,
              'pack_img' => $qc_dataForm->pack_img_url,
              'form_id' => $qc_dataForm->form_id,
              'qty' => $orderval->qty,
              'category' => $orderval->order_cat,
              'status' => $orderval->status,
              'order_statge' => $Spname,
              'sales_person' => '',
            );
          }
          //not lanel and box
        } else {
          //yes only lable and box
          if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
            $data_arr_1[] = array(
              'RecordID' => $orderval->id,
              'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
              'brand_name' => $orderval->order_name,
              'order_item_name' => $qc_data->item_name,
              'order_index' => $mydataOK[1],
              'item_name' => $orderval->material_name,
              'pack_img' => $qc_dataForm->pack_img_url,
              'form_id' => $qc_dataForm->form_id,
              'qty' => $orderval->qty,
              'category' => $orderval->order_cat,
              'status' => $orderval->status,
              'order_statge' => $Spname,
              'sales_person' => '',
            );
          } else {
          }
          //yes only lable and box
        }

        // ajcode




      }

      //current  order statge




    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }

  public function getPurchaseListQCFROMArtWork(Request $request)
  {
    $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('status', 2)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {

      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);

      //current  order statge
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
        $ajStepCode = optional($statge_arr)->step_code;
      } else {
        $Spname = '';
        $ajStepCode = '';
      }
      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);

      if ($ajStepCode == 'ART_WORK_RECIEVED') {


        // ajcode
        if ($request->purchaseFlag == 1) {
          //not lanel and box
          if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          } else {
            $data_arr_1[] = array(
              'RecordID' => $orderval->id,
              'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
              'brand_name' => $orderval->order_name,
              'order_item_name' => $qc_data->item_name,
              'order_index' => $mydataOK[1],
              'item_name' => $orderval->material_name,
              'pack_img' => $qc_dataForm->pack_img_url,
              'form_id' => $qc_dataForm->form_id,
              'qty' => $orderval->qty,
              'category' => $orderval->order_cat,
              'status' => $orderval->status,
              'order_statge' => $Spname,
              'sales_person' => '',
            );
          }
          //not lanel and box
        } else {
          //yes only lable and box
          if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
            $data_arr_1[] = array(
              'RecordID' => $orderval->id,
              'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
              'brand_name' => $orderval->order_name,
              'order_item_name' => $qc_data->item_name,
              'order_index' => $mydataOK[1],
              'item_name' => $orderval->material_name,
              'pack_img' => $qc_dataForm->pack_img_url,
              'form_id' => $qc_dataForm->form_id,
              'qty' => $orderval->qty,
              'category' => $orderval->order_cat,
              'status' => $orderval->status,
              'order_statge' => $Spname,
              'sales_person' => '',
            );
          } else {
          }
          //yes only lable and box
        }

        // ajcode


      }

      //current  order statge




    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }


  public function getPurchaseListQCFROM_V1_MODFIED(Request $request)
  {

    //ajcode
    $days = $request->_days_count;
    if ($days >= 3) {
      $orderData = DB::table('qc_bo_purchaselist_edit_history')->where('dispatch_status', 1)->distinct()
        ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 7)->get();
    } else {
      $orderData = DB::table('qc_bo_purchaselist_edit_history')->where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    }

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {

      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);


      $data = AyraHelp::getProcessCurrentStage(1, $orderval->form_id);

      if (isset($data->stage_name)) {
        $Spname = $data->stage_name;
      } else {
        $Spname = 'Completed';
      }



      $data_arr = AyraHelp::getProcessCurrentStagePurchase(2, $orderval->id);


      $SpnameA = $data_arr->stage_name;
      // $SpnameA='dd';





      //current  order statge







      $string = $orderval->material_name;
      $startStr = 'PM';
      $endStr = ':';

      $startpos = strpos($string, $startStr);
      $endpos = strpos($string, $endStr, $startpos);
      $endpos = $endpos - $startpos;
      $string = substr($string, $startpos, $endpos);
      $pm_code = $string;
      if (strpos($pm_code, 'PM') !== false) {
        $img_url = AyraHelp::getBOMImage($pm_code);
      } else {
        $img_url = asset('local/public/1.jpg');
        $pm_code = '';
      }





      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);
      // ajcode
      if ($request->purchaseFlag == 1) {
        //not lanel and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'sales_person' => '',
          );
        } else {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'sales_person' => '',
          );
        }
        //not lanel and box
      } else {
        //yes only lable and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'sales_person' => '',
          );
        } else {
        }
        //yes only lable and box
      }

      // ajcode


    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'img_url'  => true,
      'PMCODE'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);


    //ajcode


  }
  public function getPurchaseListQCFROM_V1_LABEL_BOX_v1OOO(Request $request)
  {
    $data_arr_1 = array();
    $orderData = DB::table('qc_forms')
            ->join('qc_bo_purchaselist', 'qc_forms.form_id', '=', 'qc_bo_purchaselist.form_id')
            ->select('qc_bo_purchaselist.*')
            ->where('qc_forms.dispatch_status','!=',0)
            ->where('qc_forms.is_deleted','=',0)
            ->where('qc_bo_purchaselist.dispatch_status', 1)->where('qc_bo_purchaselist.is_deleted', 0)->orderBy('qc_bo_purchaselist.order_id', 'DESC')
            ->get();
            foreach ($orderData as $key_opd => $orderval) {
              $qcDataArr = DB::table('qc_forms')
              ->where('form_id', $orderval->form_id)
              ->first();

              $data_arr_1[] = array(
                'RecordID' => $orderval->id,
                'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
                'brand_name' => $orderval->order_name,
                'order_item_name' =>  $orderval->order_item_name,
                'order_index' => 1,
                'item_name' => $orderval->material_name,
                'pack_img' => $orderval->order_pack_img_url,
                'form_id' => $orderval->form_id,
                'qty' => $orderval->qty,
                'category' => $orderval->order_cat,
                'status' => $qcDataArr->curr_stage_name,
                'order_statge' => $qcDataArr->curr_stage_name,
                'img_url' => 1,
                'PMCODE' =>  1,
                'no_avil' => 1,
                'bom_Type' => $orderval->bom_Type_from,
                'bom_stage' => $orderval->bom_stage_name_id,
                'update_status' => $orderval->update_status,
                'sales_person' => '',
                'pricePartStatus' => 1,
              );
            }

            $JSON_Data = json_encode($data_arr_1);
            $columnsDefault = [
              'RecordID'     => true,
              'order_id'     => true,
              'order_index'     => true,
              'brand_name'     => true,
              'order_item_name'     => true,
              'pack_img'     => true,
              'form_id'     => true,
              'item_name'     => true,
              'qty'  => true,
              'category'  => true,
              'status'  => true,
              'order_statge'  => true,
              'sales_person'  => true,
              'update_status'  => true,
              'img_url'  => true,
              'PMCODE'  => true,
              'pricePartStatus'  => true,
              'Actions'      => true,
            ];
            $this->DataGridResponse_New($JSON_Data, $columnsDefault);

  }

  public function getPurchaseListQCFROM_V1_LABEL_BOX_v1(Request $request)
  {



    $data_arr_1 = array();
   // $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    $orderData = DB::table('qc_forms')
    ->join('qc_bo_purchaselist', 'qc_forms.form_id', '=', 'qc_bo_purchaselist.form_id')
    ->select('qc_bo_purchaselist.*')
    ->where('qc_forms.dispatch_status','!=',0)
    ->where('qc_forms.is_deleted','=',0)
    ->where('qc_bo_purchaselist.dispatch_status', 1)->where('qc_bo_purchaselist.is_deleted', 0)->orderBy('qc_bo_purchaselist.order_id', 'DESC')
    ->get();

    foreach ($orderData as $key_opd => $orderval) {


      $string = $orderval->material_name;
      $startStr = 'PM';
      $endStr = ':';

      $startpos = strpos($string, $startStr);
      $endpos = strpos($string, $endStr, $startpos);
      $endpos = $endpos - $startpos;
      $string = substr($string, $startpos, $endpos);
      $pm_code = $string;
      if (strpos($pm_code, 'PM') !== false) {
        $img_url = AyraHelp::getBOMImage($pm_code);
      } else {
        $img_url = asset('local/public/1.jpg');
        $pm_code = '';
      }
      // $bomData = AyraHelp::GetBomDetail($orderval->form_id, $orderval->material_name);
      // if ($bomData == null) {
      //   $no_avil = 0;
      // } else {
      //   $no_avil = 1;


      //   if ($bomData->bom_from == 'From Client' || $bomData->bom_from == 'N/A') {
      //     $bom_Type = 0; //from cleint
      //   } else {
      //     $bom_Type = 1; // order
      //   }
      // }

      $qcDataArr = DB::table('qc_forms')
        ->where('form_id', $orderval->form_id)
        ->first();
        
      

        $qcupdateDateArr = DB::table('qc_bo_purchaselist')
        ->where('id', $orderval->id)      
        ->whereDate('updated_on',date('Y-m-d'))      
        ->first();

        if($qcupdateDateArr==null){

          $qcStageDataA = DB::table('st_process_action_2')
        ->where('ticket_id', $orderval->id)
        ->orderBy('id','desc')
        ->first();
        if($qcStageDataA==null){
          $st_idP=1;
        }else{
          $st_idP=$qcStageDataA->stage_id;
        }

          $affected = DB::table('qc_bo_purchaselist')
          ->where('id', $orderval->id)
          ->update([
            'status' => $st_idP,
            'bom_stage_name_id' => $st_idP,
            'updated_on' => date('Y-m-d'),
            ]);
        }
      



        


      $data_arr_1[] = array(
        'RecordID' => $orderval->id,
        'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
        'brand_name' => $orderval->order_name,
        'order_item_name' =>  $orderval->order_item_name,
        'order_index' => 1,
        'item_name' => $orderval->material_name,
        'pack_img' => $orderval->order_pack_img_url,
        'form_id' => $orderval->form_id,
        'qty' => $orderval->qty,
        'category' => $orderval->order_cat,
        'status' => $qcDataArr->curr_stage_name,
        'order_statge' => $qcDataArr->curr_stage_name,
        'img_url' => $img_url,
        'PMCODE' =>  $pm_code,
        'no_avil' => 1,
        'bom_Type' => $orderval->bom_Type_from,
        'bom_stage' => $orderval->bom_stage_name_id,
        'update_status' => $orderval->update_status,
        'sales_person' => '',
        'pricePartStatus' => $qcDataArr->price_part_status,
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'update_status'  => true,
      'img_url'  => true,
      'PMCODE'  => true,
      'pricePartStatus'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }


  //getPurchaseListQCFROM_V1_LABEL_BOX_v1
  public function getPurchaseListQCFROM_V1_LABEL_BOX_v1_OKBUT(Request $request)
  {



    $data_arr_1 = array();
    $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    foreach ($orderData as $key_opd => $orderval) {


      $string = $orderval->material_name;
      $startStr = 'PM';
      $endStr = ':';

      $startpos = strpos($string, $startStr);
      $endpos = strpos($string, $endStr, $startpos);
      $endpos = $endpos - $startpos;
      $string = substr($string, $startpos, $endpos);
      $pm_code = $string;
      if (strpos($pm_code, 'PM') !== false) {
        $img_url = AyraHelp::getBOMImage($pm_code);
      } else {
        $img_url = asset('local/public/1.jpg');
        $pm_code = '';
      }
      // $bomData = AyraHelp::GetBomDetail($orderval->form_id, $orderval->material_name);
      // if ($bomData == null) {
      //   $no_avil = 0;
      // } else {
      //   $no_avil = 1;


      //   if ($bomData->bom_from == 'From Client' || $bomData->bom_from == 'N/A') {
      //     $bom_Type = 0; //from cleint
      //   } else {
      //     $bom_Type = 1; // order
      //   }
      // }

      $qcDataArr = DB::table('qc_forms')
        ->where('form_id', $orderval->form_id)
        ->first();



      $data_arr_1[] = array(
        'RecordID' => $orderval->id,
        'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
        'brand_name' => $orderval->order_name,
        'order_item_name' =>  $orderval->order_item_name,
        'order_index' => 1,
        'item_name' => $orderval->material_name,
        'pack_img' => $orderval->order_pack_img_url,
        'form_id' => $orderval->form_id,
        'qty' => $orderval->qty,
        'category' => $orderval->order_cat,
        'status' => $orderval->bom_stage_name,
        'order_statge' => $orderval->order_stage_name,
        'img_url' => $img_url,
        'PMCODE' =>  $pm_code,
        'no_avil' => 1,
        'bom_Type' => $orderval->bom_Type_from,
        'update_status' => $orderval->update_status,
        'sales_person' => '',
        'pricePartStatus' => $qcDataArr->price_part_status,
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'update_status'  => true,
      'img_url'  => true,
      'PMCODE'  => true,
      'pricePartStatus'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }
  //getPurchaseListQCFROM_V1_LABEL_BOX_v1


  // getPurchaseListQCFROM_V1_LABEL_BOX
  public function getPurchaseListQCFROM_V1_LABEL_BOX(Request $request)
  {
    $days = $request->_days_count;
    if ($days >= 3) {
      $orderData = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()
        ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 7)->get();
    } else {
      $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    }

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {




      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);


      $data = AyraHelp::getProcessCurrentStage(1, $orderval->form_id);

      if (isset($data->stage_name)) {
        $Spname = $data->stage_name;
      } else {
        $Spname = 'Completed';
      }



      $data_arr = AyraHelp::getProcessCurrentStagePurchase(2, $orderval->id);


      $SpnameA = $data_arr->stage_name;
      // $SpnameA='dd';





      //current  order statge







      $string = $orderval->material_name;
      $startStr = 'PM';
      $endStr = ':';

      $startpos = strpos($string, $startStr);
      $endpos = strpos($string, $endStr, $startpos);
      $endpos = $endpos - $startpos;
      $string = substr($string, $startpos, $endpos);
      $pm_code = $string;
      if (strpos($pm_code, 'PM') !== false) {
        $img_url = AyraHelp::getBOMImage($pm_code);
      } else {
        $img_url = asset('local/public/1.jpg');
        $pm_code = '';
      }



      //$request->purchaseFlag

      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);
      // ajcode
      if ($request->purchaseFlag == 0) {
        //not lanel and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
        } else {


          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'update_status' => $orderval->update_status,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'sales_person' => '',
          );
        }
        //not lanel and box
      } else {
        //yes only lable and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {

          $bomData = AyraHelp::GetBomDetail($orderval->form_id, $orderval->material_name);
          if ($bomData == null) {
            $no_avil = 0;
          } else {
            $no_avil = 1;


            if ($bomData->bom_from == 'From Client' || $bomData->bom_from == 'N/A') {
              $bom_Type = 0; //from cleint
            } else {
              $bom_Type = 1; // order
            }
          }

          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => optional($qc_data)->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => optional($qc_dataForm)->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'no_avil' => $no_avil,
            'bom_Type' => $bom_Type,
            'update_status' => $orderval->update_status,
            'sales_person' => '',
          );
        } else {
        }
        //yes only lable and box
      }

      // ajcode


    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'update_status'  => true,
      'img_url'  => true,
      'PMCODE'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }

  // getPurchaseListQCFROM_V1_LABEL_BOX


  public function getPurchaseListQCFROM_V1(Request $request)
  {
    $days = $request->_days_count;
    if ($days >= 3) {
      $orderData = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()
        ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 7)->get();
    } else {
      $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    }

    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {

      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);


      $data = AyraHelp::getProcessCurrentStage(1, $orderval->form_id);

      if (isset($data->stage_name)) {
        $Spname = $data->stage_name;
      } else {
        $Spname = 'Completed';
      }



      $data_arr = AyraHelp::getProcessCurrentStagePurchase(2, $orderval->id);


      $SpnameA = $data_arr->stage_name;
      // $SpnameA='dd';





      //current  order statge







      $string = $orderval->material_name;
      $startStr = 'PM';
      $endStr = ':';

      $startpos = strpos($string, $startStr);
      $endpos = strpos($string, $endStr, $startpos);
      $endpos = $endpos - $startpos;
      $string = substr($string, $startpos, $endpos);
      $pm_code = $string;
      if (strpos($pm_code, 'PM') !== false) {
        $img_url = AyraHelp::getBOMImage($pm_code);
      } else {
        $img_url = asset('local/public/1.jpg');
        $pm_code = '';
      }





      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);
      // ajcode
      if ($request->purchaseFlag == 1) {
        //not lanel and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
        } else {
          $bom_Type = '';

          $bomData = AyraHelp::GetBomDetail($orderval->form_id, $orderval->material_name);
          if ($bomData == null) {
            $no_avil = 0;
          } else {
            $no_avil = 1;


            if ($bomData->bom_from == 'From Client' || $bomData->bom_from == 'N/A') {
              $bom_Type = 0; //from cleint
            } else {
              $bom_Type = 1; // order
            }
          }


          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'no_avil' => $no_avil,
            'bom_Type' => $bom_Type,
            'update_status' => $orderval->update_status,
            'sales_person' => '',
          );
        }
        //not lanel and box
      } else {
        //yes only lable and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $SpnameA,
            'order_statge' => $Spname,
            'img_url' => $img_url,
            'PMCODE' => $pm_code,
            'update_status' => $orderval->update_status,
            'sales_person' => '',
          );
        } else {
        }
        //yes only lable and box
      }

      // ajcode


    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'img_url'  => true,
      'PMCODE'  => true,
      'update_status'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }



  public function getPurchaseListQCFROM(Request $request)
  {


    $days = $request->_days_count;


    if ($days >= 3) {
      $orderData = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()
        ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 7)->get();
    } else {
      $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
    }
    //


    $data_arr_1 = array();
    foreach ($orderData as $key_opd => $orderval) {

      $datame = $orderval->order_id;
      $mydataOK = explode('O#', $datame);
      $qc_data = AyraHelp::getQCFormDate($orderval->form_id);

      //current  order statge
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
      } else {
        $Spname = '';
      }

      //current  order statge


      $qc_dataForm = AyraHelp::getQCFormDate($orderval->form_id);



      // ajcode
      if ($request->purchaseFlag == 1) {
        //not lanel and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
        } else {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $orderval->status,
            'order_statge' => $Spname,
            'sales_person' => '',
          );
        }
        //not lanel and box
      } else {
        //yes only lable and box
        if ($orderval->material_name == 'Printed Box' || $orderval->material_name == 'Printed Label') {
          $data_arr_1[] = array(
            'RecordID' => $orderval->id,
            'order_id' => $orderval->order_id . "/" . $orderval->sub_order_index,
            'brand_name' => $orderval->order_name,
            'order_item_name' => $qc_data->item_name,
            'order_index' => $mydataOK[1],
            'item_name' => $orderval->material_name,
            'pack_img' => $qc_dataForm->pack_img_url,
            'form_id' => $qc_dataForm->form_id,
            'qty' => $orderval->qty,
            'category' => $orderval->order_cat,
            'status' => $orderval->status,
            'order_statge' => $Spname,
            'sales_person' => '',
          );
        } else {
        }
        //yes only lable and box
      }

      // ajcode


    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'     => true,
      'order_index'     => true,
      'brand_name'     => true,
      'order_item_name'     => true,
      'pack_img'     => true,
      'form_id'     => true,
      'item_name'     => true,
      'qty'  => true,
      'category'  => true,
      'status'  => true,
      'order_statge'  => true,
      'sales_person'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse_New($JSON_Data, $columnsDefault);
  }

  public function qcFROMProductionList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'order_process_days' => '',
    ];
    return $theme->scope('sample.qcFormProductionList', $data)->render();
  }

  public function qcFROMPurchaseList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'order_process_days' => '',

    ];
    return $theme->scope('sample.qcFormPurchaseList', $data)->render();
  }
  public function qcFROMPurchaseListPrintedLabel(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'order_process_days' => '',

    ];
    return $theme->scope('sample.qcFormPurchaseListPrintedLabel', $data)->render();
  }



  public function getOrderWizardList(Request $request)
  { //this function is used to show list of pending order with statges
    $this->getOrderWizardSteps();
  }
  public function UpdateOrderDispatch_v1(Request $request)
  {

    $txtTotalOrderUnit = $request->txtTotalOrderUnit;
    $OverTotalOrderUnitAllow = $txtTotalOrderUnit + ($txtTotalOrderUnit * 40) / 100;
    $OdData_arr = $request->orderFromData;


    $totQty = 0;


    $iFlag = 0;
    foreach ($OdData_arr as $key => $row) {
      $totQty = $totQty + $row['txtTotalUnit'];
      if ($row['txtTransport'] == "") {
        $iFlag++;
      }
      if ($row['txtTotalUnit'] == "") {
        $iFlag++;
      }
      if ($row['txtBookingFor'] == "") {
        $iFlag++;
      }
      if ($row['txtInvoice'] == "") {
        $iFlag++;
      }
    }
    if ($iFlag > 0) {

      $res_arr = array(
        'status' => 0,
        'data' => '',

        'Message' => 'Invalid Entry  ! ',
      );
      return response()->json($res_arr);
    }

    if ($totQty > $OverTotalOrderUnitAllow) {
      $res_arr = array(
        'status' => 0,
        'data' => '',

        'Message' => 'Over try to dispatch ',
      );
      return response()->json($res_arr);
    }

    $dueQty = $txtTotalOrderUnit - $totQty;

    $formid = $request->txtOrderID_FORMID1;
    $myqcForm_data = AyraHelp::getQCFormDate($formid);

    if (isset($myqcForm_data->qc_from_bulk)) {
      if ($myqcForm_data->qc_from_bulk == 1) {

        $mTName = AyraHelp::getBulkITEMName($formid);
      } else {
        $mTName = $myqcForm_data->item_name;
      }
    } else {
      $mTName = $myqcForm_data->item_name;
    }



    $sta = 1;
    $expected_date = date('Y-m-d');
    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $expected_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffForHumans($to);
    $diff_data = $diff_in_days;

    $day_arr = explode(' ', $diff_in_days);

    // if($request->dispatch_type==1){
    //   $c_code="completed";
    // }else{
    //   $c_code="warning";
    // }


    if ($totQty == $txtTotalOrderUnit) {
      $c_code = "completed";
      $dispatch_type = 1;
    }
    if ($totQty < $txtTotalOrderUnit) {
      $c_code = "warning";
      $dispatch_type = 0;
    }
    if ($totQty > $txtTotalOrderUnit) {
      $c_code = "completed";
      $dispatch_type = 1;
    }
    $email_sent = 0;
    if (isset($request->client_notify)) {
      $email_sent = 1;
    }




    if ($dispatch_type == 1) { //full dispatach

      foreach ($OdData_arr as $key => $row) {


        $mydispatch_data = OrderDispatchData::where('form_id', $formid)->where('txtBookingFor', $row['txtBookingFor'])->first();
        if ($mydispatch_data == null) {

          $odDataObj = new OrderDispatchData;
          $odDataObj->form_id = $formid; //formid and order id
          $odDataObj->lr_no = $row['txtLRNo'];
          $odDataObj->transport = $row['txtTransport'];
          $odDataObj->cartons = $row['txtCartons'];
          $odDataObj->unit_in_each_carton = $row['txtCartonsEachUnit'];
          $odDataObj->total_unit = $row['txtTotalUnit'];
          $odDataObj->txtBookingFor = $row['txtBookingFor'];
          $odDataObj->txtPONumber = $row['txtPONumber'];
          $odDataObj->txtInvoice = $row['txtInvoice'];
          $odDataObj->dispatch_by = Auth::user()->id;
          $odDataObj->dispatch_on = $row['txtDispatchDate'];
          $odDataObj->dispatch_remarks = $request->orderComment;
          $odDataObj->client_email = $row['txtClientEmailSend'];
          $odDataObj->totalUnit = $request->txtTotalOrderUnit;
          $odDataObj->dueUnit = $dueQty;
          $odDataObj->txtPerUnitPrice = $row['txtPerUnitPrice'];
          $odDataObj->email_sent = $email_sent;
          $odDataObj->save();


          //send email code
          if ($request->client_notify) {

            $qc_data = QCFORM::where('form_id', $formid)->first();

            $use_data = AyraHelp::getUser($qc_data->created_by);

            $sent_to = $row['txtClientEmailSend'];
            //$myorder=$row['txtPONumber'];
            $myorder = $qc_data->order_id . "/" . $qc_data->subOrder;
            $brandNameMy = $qc_data->brand_name . "/MAX";
            $subLine = "[ORDER NO] " . $myorder . " " . $brandNameMy;

            $data = array(
              'transport_name' => $row['txtTransport'],
              'lr_no' => $row['txtLRNo'],
              'ship_date' => $row['txtDispatchDate'],
              'booking' => $row['txtBookingFor'],
              // 'po_no'=>$row['txtPONumber'],
              'po_no' => $qc_data->order_id . "/" . $qc_data->subOrder,
              'cartons' => $row['txtCartons'],
              'totalUnitEntry' => $row['txtTotalUnit'],

              // 'material_name'=>$qc_data->item_name,
              'material_name' => $mTName,
              'no_of_pack' => $row['txtCartonsEachUnit'],
              'invoice_number' => $row['txtInvoice'],

            );
            Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

              $message->to($sent_to, 'Bo')->subject($subLine);
              $message->cc($use_data->email, $use_data->name = null);
              //$message->bcc('udita.bointl@gmail.com', 'UDITA');
              $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
            });
          }

          //send email code
          //email code


        }



        //email code



      }


      QCFORM::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0
        ]);


      // OrderMaster::where('form_id', $request->txtOrderID_FORMID1)
      // ->where('order_statge_id', 'DISPATCH_ORDER')
      // ->update([
      //    'action_status' => 1,
      //   ]);

      QC_BOM_Purchase::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0,
        ]);

      // $opdObj=new OPData;
      // $opdObj->order_id_form_id=$request->txtOrderID_FORMID1; //formid and order id
      // $opdObj->step_id=$request->txtorderStepID1;
      // $opdObj->expected_date=$request->expectedDate1;
      // $opdObj->remaks=$request->orderComment;
      // $opdObj->created_by=Auth::user()->id;
      // $opdObj->assign_userid=$request->assign_user;
      // $opdObj->status=$sta;
      // $opdObj->step_status=0;
      // $opdObj->color_code=$c_code;
      // $opdObj->diff_data=$diff_data;
      // $opdObj->save();




    } else {
      foreach ($OdData_arr as $key => $row) {
        $mydispatch_data = OrderDispatchData::where('form_id', $formid)->where('txtBookingFor', $row['txtBookingFor'])->where('txtInvoice', $row['txtInvoice'])->first();
        if ($mydispatch_data == null) {

          $odDataObj = new OrderDispatchData;
          $odDataObj->form_id = $formid; //formid and order id
          $odDataObj->lr_no = $row['txtLRNo'];
          $odDataObj->transport = $row['txtTransport'];
          $odDataObj->cartons = $row['txtCartons'];
          $odDataObj->unit_in_each_carton = $row['txtCartonsEachUnit'];
          $odDataObj->total_unit = $row['txtTotalUnit'];
          $odDataObj->txtBookingFor = $row['txtBookingFor'];
          $odDataObj->txtPONumber = $row['txtPONumber'];
          $odDataObj->txtInvoice = $row['txtInvoice'];
          $odDataObj->dispatch_by = Auth::user()->id;
          $odDataObj->dispatch_on = $row['txtDispatchDate'];
          $odDataObj->dispatch_remarks = $request->orderComment;
          $odDataObj->client_email = $row['txtClientEmailSend'];
          $odDataObj->totalUnit = $request->txtTotalOrderUnit;
          $odDataObj->dueUnit = $dueQty;
          $odDataObj->email_sent = $email_sent;
          $odDataObj->save();


          //send email code
          if ($request->client_notify) {

            $qc_data = QCFORM::where('form_id', $formid)->first();

            $use_data = AyraHelp::getUser($qc_data->created_by);
            $sent_to = $row['txtClientEmailSend'];
            $myorder = $qc_data->order_id . "/" . $qc_data->subOrder;
            //$myorder=$row['txtPONumber'];
            $brandNameMy = $qc_data->brand_name . "/MAX";
            $subLine = "[ORDER NO] " . $myorder . " " . $brandNameMy;

            $data = array(
              'transport_name' => $row['txtTransport'],
              'lr_no' => $row['txtLRNo'],
              'ship_date' => $row['txtDispatchDate'],
              'booking' => $row['txtBookingFor'],
              //'po_no'=>$row['txtPONumber'],
              'po_no' => $qc_data->order_id . "/" . $qc_data->subOrder,
              'cartons' => $row['txtCartons'],
              'totalUnitEntry' => $row['txtTotalUnit'],


              // 'material_name'=>$qc_data->item_name,
              'material_name' => $mTName,
              'no_of_pack' => $row['txtCartonsEachUnit'],
              'invoice_number' => $row['txtInvoice'],

            );
            Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

              $message->to($sent_to, 'BO')->subject($subLine);
              $message->cc($use_data->email, $use_data->name = null);
              //$message->bcc('udita.bointl@gmail.com', 'UDITA');
              $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
            });
          }

          //send email code


        }
        //email code




      }

      QCFORM::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 2
        ]);

      // OrderMaster::where('form_id', $request->txtOrderID_FORMID1)
      // ->where('order_statge_id', 'DISPATCH_ORDER')
      // ->update([
      //    'action_status' => 1,
      //   ]);

      QC_BOM_Purchase::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0,
        ]);



      // $opdObj=new OPData;
      // $opdObj->order_id_form_id=$request->txtOrderID_FORMID1; //formid and order id
      // $opdObj->step_id=$request->txtorderStepID1;
      // $opdObj->expected_date=$request->expectedDate1;
      // $opdObj->remaks=$request->orderComment;
      // $opdObj->created_by=Auth::user()->id;
      // $opdObj->assign_userid=$request->assign_user;
      // $opdObj->status=$sta;
      // $opdObj->step_status=0;
      // $opdObj->color_code=$c_code;
      // $opdObj->diff_data=$diff_data;
      // $opdObj->save();


    }

    //updated by and updated on
    // AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID1);
    //updated by and updated on
    DB::table('st_process_action')->insert(
      [
        'process_id' => 1,
        'stage_id' => 13,
        'created_at' => date('Y-m-d'),
        'expected_date' => date('Y-m-d'),
        'assigned_id' => 1,
        'action_on' => 1,
        'completed_by' => 1,
        'ticket_id' => $request->txtOrderID_FORMID1,
        'statge_color' => 'completed'
      ]
    );


    $res_arr = array(
      'status' => 1,
      'data' => '',

      'Message' => 'Sucessfully sent  ',
    );
    return response()->json($res_arr);
  }
  public function UpdateOrderDispatch(Request $request)
  {
    $txtTotalOrderUnit = $request->txtTotalOrderUnit;
    $OverTotalOrderUnitAllow = $txtTotalOrderUnit + ($txtTotalOrderUnit * 40) / 100;
    $OdData_arr = $request->orderFromData;
    $totQty = 0;

    $iFlag = 0;
    foreach ($OdData_arr as $key => $row) {
      // print_r($row['txtTransport']);
      $totQty = $totQty + $row['txtTotalUnit'];
      if ($row['txtTransport'] == "") {
        $iFlag++;
      }
      if ($row['txtTotalUnit'] == "") {
        $iFlag++;
      }
      if ($row['txtBookingFor'] == "") {
        $iFlag++;
      }
      if ($row['txtInvoice'] == "") {
        $iFlag++;
      }
    }
    if ($iFlag > 0) {

      $res_arr = array(
        'status' => 0,
        'data' => '',

        'Message' => 'Invalid Entry  ! ',
      );
      return response()->json($res_arr);
    }

    if ($totQty > $OverTotalOrderUnitAllow) {
      $res_arr = array(
        'status' => 0,
        'data' => '',

        'Message' => 'Over try to dispatch ',
      );
      return response()->json($res_arr);
    }

    $dueQty = $txtTotalOrderUnit - $totQty;

    $formid = $request->txtOrderID_FORMID1;
    $myqcForm_data = AyraHelp::getQCFormDate($formid);

    if (isset($myqcForm_data->qc_from_bulk)) {
      if ($myqcForm_data->qc_from_bulk == 1) {

        $mTName = AyraHelp::getBulkITEMName($formid);
      } else {
        $mTName = $myqcForm_data->item_name;
      }
    } else {
      $mTName = $myqcForm_data->item_name;
    }



    $sta = 1;
    $expected_date = $request->expectedDate1;
    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $expected_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffForHumans($to);
    $diff_data = $diff_in_days;

    $day_arr = explode(' ', $diff_in_days);

    // if($request->dispatch_type==1){
    //   $c_code="completed";
    // }else{
    //   $c_code="warning";
    // }


    if ($totQty == $txtTotalOrderUnit) {
      $c_code = "completed";
      $dispatch_type = 1;
    }
    if ($totQty < $txtTotalOrderUnit) {
      $c_code = "warning";
      $dispatch_type = 0;
    }
    if ($totQty > $txtTotalOrderUnit) {
      $c_code = "completed";
      $dispatch_type = 1;
    }
    $email_sent = 0;
    if (isset($request->client_notify)) {
      $email_sent = 1;
    }




    if ($dispatch_type == 1) { //full dispatach

      foreach ($OdData_arr as $key => $row) {


        $mydispatch_data = OrderDispatchData::where('form_id', $formid)->where('txtBookingFor', $row['txtBookingFor'])->first();
        if ($mydispatch_data == null) {

          $odDataObj = new OrderDispatchData;
          $odDataObj->form_id = $formid; //formid and order id
          $odDataObj->lr_no = $row['txtLRNo'];
          $odDataObj->transport = $row['txtTransport'];
          $odDataObj->cartons = $row['txtCartons'];
          $odDataObj->unit_in_each_carton = $row['txtCartonsEachUnit'];
          $odDataObj->total_unit = $row['txtTotalUnit'];
          $odDataObj->txtBookingFor = $row['txtBookingFor'];
          $odDataObj->txtPONumber = $row['txtPONumber'];
          $odDataObj->txtInvoice = $row['txtInvoice'];
          $odDataObj->dispatch_by = Auth::user()->id;
          $odDataObj->dispatch_on = $row['txtDispatchDate'];
          $odDataObj->dispatch_remarks = $request->orderComment;
          $odDataObj->client_email = $row['txtClientEmailSend'];
          $odDataObj->totalUnit = $request->txtTotalOrderUnit;
          $odDataObj->dueUnit = $dueQty;
          $odDataObj->email_sent = $email_sent;
          $odDataObj->save();


          //send email code
          if ($request->client_notify) {

            $qc_data = QCFORM::where('form_id', $formid)->first();

            $use_data = AyraHelp::getUser($qc_data->created_by);
            $sent_to = $row['txtClientEmailSend'];
            //$myorder=$row['txtPONumber'];
            $myorder = $qc_data->order_id . "/" . $qc_data->subOrder;
            $brandNameMy = $qc_data->brand_name . "/MAX";
            $subLine = "[ORDER NO] " . $myorder . " " . $brandNameMy;

            $data = array(
              'transport_name' => $row['txtTransport'],
              'lr_no' => $row['txtLRNo'],
              'ship_date' => $row['txtDispatchDate'],
              'booking' => $row['txtBookingFor'],
              // 'po_no'=>$row['txtPONumber'],
              'po_no' => $qc_data->order_id . "/" . $qc_data->subOrder,
              'cartons' => $row['txtCartons'],
              'totalUnitEntry' => $row['txtTotalUnit'],

              // 'material_name'=>$qc_data->item_name,
              'material_name' => $mTName,
              'no_of_pack' => $row['txtCartonsEachUnit'],
              'invoice_number' => $row['txtInvoice'],

            );
            Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

              $message->to($sent_to, 'BO')->subject($subLine);
              $message->cc($use_data->email, $use_data->name = null);
              $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
            });
          }

          //send email code
          //email code


        }



        //email code



      }


      QCFORM::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0
        ]);


      OrderMaster::where('form_id', $request->txtOrderID_FORMID1)
        ->where('order_statge_id', 'DISPATCH_ORDER')
        ->update([
          'action_status' => 1,
        ]);

      QC_BOM_Purchase::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0,
        ]);

      $opdObj = new OPData;
      $opdObj->order_id_form_id = $request->txtOrderID_FORMID1; //formid and order id
      $opdObj->step_id = $request->txtorderStepID1;
      $opdObj->expected_date = $request->expectedDate1;
      $opdObj->remaks = $request->orderComment;
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = $request->assign_user;
      $opdObj->status = $sta;
      $opdObj->step_status = 0;
      $opdObj->color_code = $c_code;
      $opdObj->diff_data = $diff_data;
      $opdObj->save();
    } else {
      foreach ($OdData_arr as $key => $row) {
        $mydispatch_data = OrderDispatchData::where('form_id', $formid)->where('txtBookingFor', $row['txtBookingFor'])->where('txtInvoice', $row['txtInvoice'])->first();
        if ($mydispatch_data == null) {

          $odDataObj = new OrderDispatchData;
          $odDataObj->form_id = $formid; //formid and order id
          $odDataObj->lr_no = $row['txtLRNo'];
          $odDataObj->transport = $row['txtTransport'];
          $odDataObj->cartons = $row['txtCartons'];
          $odDataObj->unit_in_each_carton = $row['txtCartonsEachUnit'];
          $odDataObj->total_unit = $row['txtTotalUnit'];
          $odDataObj->txtBookingFor = $row['txtBookingFor'];
          $odDataObj->txtPONumber = $row['txtPONumber'];
          $odDataObj->txtInvoice = $row['txtInvoice'];
          $odDataObj->dispatch_by = Auth::user()->id;
          $odDataObj->dispatch_on = $row['txtDispatchDate'];
          $odDataObj->dispatch_remarks = $request->orderComment;
          $odDataObj->client_email = $row['txtClientEmailSend'];
          $odDataObj->totalUnit = $request->txtTotalOrderUnit;
          $odDataObj->dueUnit = $dueQty;
          $odDataObj->email_sent = $email_sent;
          $odDataObj->save();


          //send email code
          if ($request->client_notify) {

            $qc_data = QCFORM::where('form_id', $formid)->first();

            $use_data = AyraHelp::getUser($qc_data->created_by);
            $sent_to = $row['txtClientEmailSend'];
            $myorder = $qc_data->order_id . "/" . $qc_data->subOrder;
            //$myorder=$row['txtPONumber'];
            $brandNameMy = $qc_data->brand_name . "/MAX";
            $subLine = "[ORDER NO] " . $myorder . " " . $brandNameMy;

            $data = array(
              'transport_name' => $row['txtTransport'],
              'lr_no' => $row['txtLRNo'],
              'ship_date' => $row['txtDispatchDate'],
              'booking' => $row['txtBookingFor'],
              //'po_no'=>$row['txtPONumber'],
              'po_no' => $qc_data->order_id . "/" . $qc_data->subOrder,
              'cartons' => $row['txtCartons'],
              'totalUnitEntry' => $row['txtTotalUnit'],


              // 'material_name'=>$qc_data->item_name,
              'material_name' => $mTName,
              'no_of_pack' => $row['txtCartonsEachUnit'],
              'invoice_number' => $row['txtInvoice'],

            );
            Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

              $message->to($sent_to, 'BO')->subject($subLine);
              $message->cc($use_data->email, $use_data->name = null);
              $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
            });
          }

          //send email code


        }
        //email code




      }

      QCFORM::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 2
        ]);

      OrderMaster::where('form_id', $request->txtOrderID_FORMID1)
        ->where('order_statge_id', 'DISPATCH_ORDER')
        ->update([
          'action_status' => 1,
        ]);

      QC_BOM_Purchase::where('form_id', $request->txtOrderID_FORMID1)
        ->update([
          'dispatch_status' => 0,
        ]);



      $opdObj = new OPData;
      $opdObj->order_id_form_id = $request->txtOrderID_FORMID1; //formid and order id
      $opdObj->step_id = $request->txtorderStepID1;
      $opdObj->expected_date = $request->expectedDate1;
      $opdObj->remaks = $request->orderComment;
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = $request->assign_user;
      $opdObj->status = $sta;
      $opdObj->step_status = 0;
      $opdObj->color_code = $c_code;
      $opdObj->diff_data = $diff_data;
      $opdObj->save();
    }

    //updated by and updated on
    AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID1);
    //updated by and updated on


    $res_arr = array(
      'status' => 1,
      'data' => '',

      'Message' => 'Sucessfully sent  ',
    );
    return response()->json($res_arr);
  }
  public function getOrderProcessSteps(Request $request)
  {
    $order_id = $request->orderid;
    $step_id = $request->step_id;

    $data_pro_arr = OPData::where('order_id_form_id', $order_id)->where('step_id', $step_id)->get();
    $data_pro_arr_comments = OPData::where('order_id_form_id', $order_id)->where('status', 0)->get();
    $mydata = array();
    foreach ($data_pro_arr_comments as $key => $row) {
      $completed_on = date("d,M Y", strtotime($row->created_at));
      $user_arr = AyraHelp::getUser($row->created_by);

      $mydata[] = array(
        'StageNo' => $row->step_id,
        'Comments' => $row->remaks,
        'completed_by' => $user_arr->name,
        'completed_on' => $completed_on,
      );
    }

    $master_datas = AyraHelp::getOrderMaster($order_id);

    $data_arr_1 = array();
    foreach ($master_datas as $key_opd => $master_data) {
      $step_code = $master_data->order_statge_id;
      $completed_on = date("d,M Y", strtotime($master_data->completed_on));
      $step_arr = AyraHelp::getStageNameByCode($step_code);
      $user_arr = AyraHelp::getUser($master_data->assigned_by);
      $data_arr_1[] = array(
        'stage_name' => $step_arr->process_name,
        'completed_on' => $completed_on,
        'completed_by' => $user_arr->name
      );
    }



    $res_arr = array(
      'status' => 1,
      'data' => $data_pro_arr,
      'alldata' => $data_arr_1,
      'dataComments' => $mydata,
      'Message' => 'Successfully added ',
    );
    return response()->json($res_arr);
  }
  public function save_order_process(Request $request)
  {
    $checkOrderMaster = AyraHelp::checkOrderMasterDataDuplicte($request->txtOrderID_FORMID, $request->txtStepCode);
    $checkOrderProcess = AyraHelp::checkOrderProcesDuplicte($request->txtOrderID_FORMID, $request->txtorderStepID);

    if ($checkOrderMaster) {
      $res_arr = array(
        'status' => 1,
        'Message' => 'already have opps',
      );
      return response()->json($res_arr);
    }

    if ($checkOrderProcess) {
      $res_arr = array(
        'status' => 1,
        'Message' => 'already have opps ok',
      );
      return response()->json($res_arr);
    }


    $c_code = "";
    $diff_data = "";
    $process_step = $request->txtorderStepID;
    $form_id = $request->txtOrderID_FORMID;
    if ($request->order_process_type == 'comment') {
      $sta = 0;
      $opdObj = new OPData;
      $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
      $opdObj->step_id = $request->txtorderStepID;
      $opdObj->expected_date = $request->expectedDate;
      $opdObj->remaks = $request->orderComment;
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = $request->assign_user;
      $opdObj->status = $sta;
      $opdObj->step_status = 0;
      $opdObj->color_code = $c_code;
      $opdObj->diff_data = $diff_data;
      $opdObj->save();
    }
    //if process done
    if ($request->order_process_type == 'done') {
      $sta = 1;
      $expected_date = $request->expectedDate;
      $today = date('Y-m-d');
      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $expected_date);
      $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
      $diff_in_days = $from->diffForHumans($to);
      $day_arr = explode(' ', $diff_in_days);
      if ($day_arr['1'] == "second") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "second") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "day" && $day_arr['2'] == "before") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "day" && $day_arr['2'] == "after") {
        $c_code = "danger";
      }
      if ($day_arr['1'] == "days" && $day_arr['2'] == "before") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "days" && $day_arr['2'] == "after") {
        $c_code = "danger";
      }

      if ($day_arr['1'] == "weeks" && $day_arr['2'] == "before") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "weeks" && $day_arr['2'] == "after") {
        $c_code = "danger";
      }
      if ($day_arr['1'] == "week" && $day_arr['2'] == "before") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "week" && $day_arr['2'] == "after") {
        $c_code = "danger";
      }
      if ($day_arr['1'] == "month" && $day_arr['2'] == "before") {
        $c_code = "completed";
      }
      if ($day_arr['1'] == "month" && $day_arr['2'] == "after") {
        $c_code = "danger";
      }
      $diff_data = $diff_in_days;
      //==================================STEP 1 :START============================
      //IF STEP 1 :start by sales :Start
      if ($process_step == 1) {

        QCFORM::where('form_id', $request->txtOrderID_FORMID)
          ->update([
            'artwork_start_date' => date('Y-m-d'),
            'artwork_status' => 1,
          ]);

        //  task 1: save BOM to purchase bom if not from client for all order type
        //also need start qc from

        $qcboms = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
        foreach ($qcboms as $key => $qcbom) {
          if ($qcbom->bom_from != 'From Client') {
            $myqc_data = AyraHelp::getQCFormDate($form_id);
            if ($qcbom->bom_from == 'N/A' || $qcbom->bom_from == 'From Client' || $qcbom->bom_from == 'FromClient') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $myqc_data->order_id;
              $qcbomPObj->form_id = $form_id;
              $qcbomPObj->sub_order_index = $myqc_data->subOrder;
              $qcbomPObj->order_name = $myqc_data->brand_name;
              $qcbomPObj->order_cat = $qcbom->bom_cat;
              $qcbomPObj->material_name = $qcbom->m_name;
              $qcbomPObj->qty = $qcbom->qty;
              $qcbomPObj->created_by = Auth::user()->id;
              $qcbomPObj->save();
            }
          }
        }

        //  task 1: save BOM to purchase bom if not from client for all order type :start
        // task  1: skip order statges if box and label from client up 7 stages is before production
        //also check first the  islable and box is from client then other wise need to skip only purchase only
        //assign to art work review
        $mydata = AyraHelp::isBoxLabelFromClient($form_id);
        if ($mydata) {  //if true //skip
          for ($x = 1; $x <= 7; $x++) {
            if ($x != 2) { //except 2 all upto 7 done

              $opdObj = new OPData;
              $opdObj->order_id_form_id = $form_id; //formid and order id
              $opdObj->step_id = $x;
              $opdObj->expected_date = $request->expectedDate;
              $opdObj->remaks = $request->orderComment;
              $opdObj->created_by = Auth::user()->id;
              $opdObj->assign_userid = $request->assign_user;
              $opdObj->status = 1;
              $opdObj->step_status = 0;
              $opdObj->color_code = $c_code;
              $opdObj->diff_data = $diff_data;
              $opdObj->save();

              //now completing stages part first part completed and rest too insert done:start
              $mystage_arr = AyraHelp::getOrderStageCodeByID($x, $form_id);
              if ($mystage_arr->step_code == 'ART_WORK_RECIEVED') {

                OrderMaster::where('form_id', $request->txtOrderID_FORMID)
                  ->where('order_statge_id', 'ART_WORK_RECIEVED')
                  ->update([
                    'action_status' => 1,
                  ]);
              } else {
                $mystage_arr = AyraHelp::getOrderStageCodeByID($x, $form_id);
                $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

                $mstOrderObj = new OrderMaster;
                $mstOrderObj->form_id = $request->txtOrderID_FORMID;
                $mstOrderObj->assign_userid = 0;
                $mstOrderObj->order_statge_id = $mystage_arr->step_code;
                $mstOrderObj->assigned_by = Auth::user()->id;
                $mstOrderObj->assigned_on = date('Y-m-d');
                $mstOrderObj->expected_date = $expencted_date;
                $mstOrderObj->action_status = 1;
                $mstOrderObj->completed_on = date('Y-m-d');
                $mstOrderObj->action_mark = 1;
                $mstOrderObj->assigned_team = 2; //sales user
                $mstOrderObj->save();
              }
              //now completing stages part first part completed and rest too insert done:stop

            }
          }
          //assign to prodution
          $mystage_arr = AyraHelp::getOrderStageCodeByID(8, $form_id);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);
          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $request->txtOrderID_FORMID;
          $mstOrderObj->assign_userid = 0;
          $mstOrderObj->order_statge_id = 'PRODUCTION';
          $mstOrderObj->assigned_by = Auth::user()->id;
          $mstOrderObj->assigned_on = date('Y-m-d');
          $mstOrderObj->expected_date = $expencted_date;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = date('Y-m-d');
          $mstOrderObj->action_mark = 1;
          $mstOrderObj->assigned_team = 4; //sales user
          $mstOrderObj->save();
          //assign to prodution

        } else {  //order need to skip PM

          $opdObj = new OPData;
          $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
          $opdObj->step_id = $request->txtorderStepID;
          $opdObj->expected_date = $request->expectedDate;
          $opdObj->remaks = $request->orderComment;
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = $request->assign_user;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = $c_code;
          $opdObj->diff_data = $diff_data;
          $opdObj->save();



          //assign to art work
          $mystage_arr = AyraHelp::getOrderStageCodeByID(3, $form_id);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $request->txtOrderID_FORMID;
          $mstOrderObj->assign_userid = 0;
          $mstOrderObj->order_statge_id = 'ART_WORK_REVIEW';
          $mstOrderObj->assigned_by = Auth::user()->id;
          $mstOrderObj->assigned_on = date('Y-m-d');
          $mstOrderObj->expected_date = $expencted_date;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = date('Y-m-d');
          $mstOrderObj->action_mark = 1;
          $mstOrderObj->assigned_team = 2; //sales user
          $mstOrderObj->save();

          //update previou stage i.e first :start
          OrderMaster::where('form_id', $request->txtOrderID_FORMID)
            ->where('order_statge_id', 'ART_WORK_RECIEVED')
            ->update([
              'action_status' => 1,
            ]);
          //update previou stage i.e first :stop
        }
        //  task 1: save BOM to purchase bom if not from client for all order type :start
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on

      }
      //IF STEP 1 :start by sales : Stop

      //==================================STEP 1 :STOP============================

      //==================================STEP 2 :START============================
      // for PL-NEW :setp 2 is PM: task: if PM is done then done not other task
      // for PL-REPEAT :setp 2 is PM: if PM is done then done not do other task
      //if order is bulk then setp 2 is :PRODUCTION  if done the  assign to next
      if ($process_step == 2) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          //BULK-NR : production is done then make production list completed with 6
          // and in order update order master and make asssign too .
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
          $opdObj->step_id = $request->txtorderStepID;
          $opdObj->expected_date = $request->expectedDate;
          $opdObj->remaks = $request->orderComment;
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = $request->assign_user;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = $c_code;
          $opdObj->diff_data = $diff_data;
          $opdObj->save();

          QCFORM::where('form_id', $request->txtOrderID_FORMID)
            ->update(['production_curr_statge' => 6]); //production is completed

          $nextStageid = $request->txtorderStepID + 1;
          $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
          $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);


          OrderMaster::where('form_id', $request->txtOrderID_FORMID)
            ->where('order_statge_id', $mystage_arr_ori->step_code)
            ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

          $mystage_arr = AyraHelp::getOrderStageCodeByID(3, $request->txtOrderID_FORMID);
          $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);


          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $request->txtOrderID_FORMID;
          $mstOrderObj->assign_userid = 0;
          $mstOrderObj->order_statge_id = 'QC_CHECK';
          $mstOrderObj->assigned_by = Auth::user()->id;
          $mstOrderObj->assigned_on = date('Y-m-d');
          $mstOrderObj->expected_date = $expencted_date;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = date('Y-m-d');
          $mstOrderObj->action_mark = 1;
          $mstOrderObj->assigned_team = 4; //sales user
          $mstOrderObj->save();
        } else {

          //PL-N and PL-R
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
          $opdObj->step_id = $request->txtorderStepID;
          $opdObj->expected_date = $request->expectedDate;
          $opdObj->remaks = $request->orderComment;
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = $request->assign_user;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = $c_code;
          $opdObj->diff_data = $diff_data;
          $opdObj->save();

          QC_BOM_Purchase::where('form_id', $request->txtOrderID_FORMID)
            ->update(['status' => 7]);
        }
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on

      }

      //==================================STEP 2 :STOP============================

      //==================================STEP 3 :START============================
      if ($process_step == 3) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          //BULK-NR
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
          $opdObj->step_id = $request->txtorderStepID;
          $opdObj->expected_date = $request->expectedDate;
          $opdObj->remaks = $request->orderComment;
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = $request->assign_user;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = $c_code;
          $opdObj->diff_data = $diff_data;
          $opdObj->save();

          $nextStageid = $request->txtorderStepID + 1;
          $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
          $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);


          OrderMaster::where('form_id', $request->txtOrderID_FORMID)
            ->where('order_statge_id', $mystage_arr_ori->step_code)
            ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

          $mystage_arr = AyraHelp::getOrderStageCodeByID(4, $request->txtOrderID_FORMID);
          $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
          $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

          $mstOrderObj = new OrderMaster;
          $mstOrderObj->form_id = $request->txtOrderID_FORMID;
          $mstOrderObj->assign_userid = 0;
          $mstOrderObj->order_statge_id = 'DISPATCH_ORDER';
          $mstOrderObj->assigned_by = Auth::user()->id;
          $mstOrderObj->assigned_on = date('Y-m-d');
          $mstOrderObj->expected_date = $expencted_date;
          $mstOrderObj->action_status = 0;
          $mstOrderObj->completed_on = date('Y-m-d');
          $mstOrderObj->action_mark = 1;
          $mstOrderObj->assigned_team = 4; //sales user
          $mstOrderObj->save();
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(4, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'CLIENT_ART_CONFIRM';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();

            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(4, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PRODUCTION';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 3);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 3 :STOP============================
      //==================================STEP 4 :START============================
      if ($process_step == 4) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulk";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(5, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PRINT_SAMPLE';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();

            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(4, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'QC_CHECK';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
            //since it is prouction so need to update qc form like bulk 2
            QCFORM::where('form_id', $request->txtOrderID_FORMID)
              ->update(['production_curr_statge' => 6]); //production is completed
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 4);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 5 :STOP============================
      if ($process_step == 5) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulk";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(6, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'SAMPLE_ARRROVAL';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(6, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PACKING_ORDER';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 5);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 5 :STOP============================
      //==================================STEP 6 :START============================
      if ($process_step == 6) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulk";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(7, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PURCHASE_LABEL_BOX';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(7, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'DISPATCH_ORDER';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 6);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 6 :STOP============================
      //==================================STEP 7 :START============================
      if ($process_step == 7) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulkA";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(8, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'PRODUCTION';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            echo "bulk";
            die;
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 7);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 7 :STOP============================
      //==================================STEP 8 :START============================
      if ($process_step == 8) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulkA";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID(9, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = 'QC_CHECK';
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();

            //since it is prouction so need to update qc form like bulk 2
            QCFORM::where('form_id', $request->txtOrderID_FORMID)
              ->update(['production_curr_statge' => 6]); //production is completed


          }
          if ($QCData->order_repeat == 2) {
            //PL-R
            echo "bulk";
            die;
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, 8);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 8 :STOP============================
      //==================================STEP 9-10-11 :START============================
      if ($process_step == 9 || $process_step == 10 || $process_step == 11) {
        $QCData = AyraHelp::getQCFormDate($form_id);
        if ($QCData->order_type == 'Bulk') {
          echo "bulkA";
          die;
        } else {
          if ($QCData->order_repeat == 1) {
            //PL-N
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $request->txtOrderID_FORMID; //formid and order id
            $opdObj->step_id = $request->txtorderStepID;
            $opdObj->expected_date = $request->expectedDate;
            $opdObj->remaks = $request->orderComment;
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = $request->assign_user;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = $c_code;
            $opdObj->diff_data = $diff_data;
            $opdObj->save();


            $nextStageid = $request->txtorderStepID + 1;
            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            OrderMaster::where('form_id', $request->txtOrderID_FORMID)
              ->where('order_statge_id', $mystage_arr_ori->step_code)
              ->update(['action_status' => 1, 'completed_on' => date('Y-m-d')]); //done

            $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $request->txtOrderID_FORMID);
            $mystage_arr_ori = AyraHelp::getOrderStageCodeByID($request->txtorderStepID, $request->txtOrderID_FORMID);
            $expencted_date = Carbon::parse($request->expectedDate)->addDays($mystage_arr->process_days);

            $mstOrderObj = new OrderMaster;
            $mstOrderObj->form_id = $request->txtOrderID_FORMID;
            $mstOrderObj->assign_userid = 0;
            $mstOrderObj->order_statge_id = $mystage_arr->step_code;
            $mstOrderObj->assigned_by = Auth::user()->id;
            $mstOrderObj->assigned_on = date('Y-m-d');
            $mstOrderObj->expected_date = $expencted_date;
            $mstOrderObj->action_status = 0;
            $mstOrderObj->completed_on = date('Y-m-d');
            $mstOrderObj->action_mark = 1;
            $mstOrderObj->assigned_team = 2; //sales user
            $mstOrderObj->save();
          }
          if ($QCData->order_repeat == 2) {
            //PL-N
            echo "repeat";
            die;
          }
        }
        //this code for previous stage is done
        $mystatus = AyraHelp::completePreviousStageDone($request->txtOrderID_FORMID, $request->txtorderStepID);
        //updated by and updated on
        AyraHelp::UpdatedByUpdatedOnOrderMaster($request->txtOrderID_FORMID);
        //updated by and updated on
      }
      //==================================STEP 9-10-11 :STOP============================
    }

    $res_arr = array(
      'status' => 1,
      'Message' => 'Successfully added',
    );
    return response()->json($res_arr);
  }


  public function getOrderWizardListOLD(Request $request)
  {

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $orderLists = QCFORM::where('dispatch_status', '!=', 0)->get();
    } else {
      $orderLists = QCFORM::where('dispatch_status', '!=', 0)->where('created_by', Auth::user()->id)->get();
    }

    $opd_arr = OPDays::get();
    // $opd_arr=OPDaysBulk::get();

    $i = 0;
    $data_arr_1 = array();


    $dataOPD_arr = OPData::where('status', 1)->get()->toArray();


    foreach ($orderLists as $key_orderLists => $orderList) {

      $opBo_Arr = array();
      $user_arr =  AyraHelp::getUser($orderList->created_by);
      $max_id_step = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->max('step_id') + 1;
      $max_id_step_data = OPData::where('status', 1)->where('order_id_form_id', $orderList->form_id)->where('step_id', \DB::raw("(select max(`step_id`) from order_process_data)"))->get();

      $date_created = '';
      if (count($max_id_step_data) > 0) {
        $date_created = $max_id_step_data[0]->created_at;
      }

      foreach ($opd_arr as $key_opd_arr => $opd_arr_val) {

        $dataOPDs = OPData::where('step_id', $opd_arr_val->order_step)->where('status', 1)->where('order_id_form_id', $orderList->form_id)->first();





        if ($dataOPDs != null) {
          $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dataOPDs->expected_date);
          $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dataOPDs->process_date);


          $diff_in_days = $to->diffInDays($from);



          $opBo_Arr[] = array(
            'order_step' => $opd_arr_val->order_step,
            'process_days' => $opd_arr_val->process_days,
            'process_name' => $opd_arr_val->process_name,
            'order_type' => '1',
            'assign_userid' => $opd_arr_val->assign_userid,
            'step_done' => 1,
            'order_form_id' => $orderList->form_id,
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
            'assign_userid' => $opd_arr_val->assign_userid,
            'step_done' => 0,
            'order_form_id' => $orderList->form_id,
            'next_STEP' => $max_id_step
          );
        }
      }




      $data_arr_1[] = array(
        'form_id' => $orderList->form_id,
        'order_id' => $orderList->order_id,
        'sub_order_id' => $orderList->subOrder,
        'brand_name' => $orderList->brand_name,
        'order_type' => $orderList->order_type,
        'created_by' => $user_arr->name,
        'created_on' => $orderList->created_at,
        'orderSteps' => $opBo_Arr,
        'process_wizard' => $dataOPD_arr,
      );
    }


    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'     => true,
      'brand_name'     => true,
      'order_type'     => true,
      'created_by'  => true,
      'created_on'  => true,
      'orderSteps'  => true,
      'process_wizard'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //=======================================


  public function deleteQcForm(Request $request)
  {
    $form_id = $request->form_id;
    QCFORM::where('form_id', $form_id)
      ->update(['is_deleted' => 1]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Deleted Successfully ',
    );
    QC_BOM_Purchase::where('form_id', $form_id)
      ->update(['is_deleted' => 1]);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Deleted Successfully ',
    );

    return response()->json($res_arr);
  }

  public function orderList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $opd_arr = OPDays::get();
    $orderList = QCFORM::get();

    $data = [
      'order_process_days' => $opd_arr,
      'orderData' => $orderList
    ];
    return $theme->scope('sample.orderList', $data)->render();
  }

  public function saveOrderProcessDays(Request $request)
  {
    $orderData_Arr = AyraHelp::getStepDays($request->step);
    $created_on = date('Y-m-d', strtotime($request->step_days));
    $opdata_arr = OPData::where('order_id_form_id', $request->form_id)->where('step_id', $request->step)->first();
    if ($opdata_arr == null) {
      //new insert
      $opdObj = new OPData;
      $opdObj->order_id_form_id = $request->form_id;
      $opdObj->step_id = $request->step;
      $opdObj->req_days = $orderData_Arr->process_days;
      $opdObj->process_date = $created_on;
      $opdObj->remaks = $request->step_remark;
      $opdObj->created_by = Auth::user()->id;
      $opdObj->save();
    } else {
      //new update
      OPData::where('order_id_form_id', $request->form_id)
        ->where('step_id', $request->step)
        ->update([
          'process_date' => $created_on,
          'remaks' => $request->step_remark,
          'created_by' => Auth::user()->id,
          'created_at' => date('Y-m-d H:i:s'),

        ]);
    }


    // logsave

    $opdLogObj = new OPDataLog;
    $opdLogObj->order_id_form_id = $request->form_id;
    $opdLogObj->step_id = $request->step;
    $opdLogObj->process_date = $created_on;
    $opdLogObj->remarks = $request->step_remark;
    $opdLogObj->created_by = Auth::user()->id;
    $opdLogObj->save();
    // logsave

  }
  public function orderWizard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_form' => '',

    ];
    return $theme->scope('orders.order_wizard', $data)->render();
  }


  public function updateQCdataNewWaysBULK(Request $request)
  {
   
    $formID = $request->formID;
    //update his
    $update_id= AyraHelp::getOrderOLDDataBULK($formID,1);

    //update  his 

    $ordertype = $request->order_type;
    $dataa = $ordertype == 2 ? 'Bulk' : 'Private Label';
    if ($ordertype == 2) {

      $data = AyraHelp::getProcessCurrentStage(1, $formID);


      if ($data->stage_id > 9) {
      
      } else {
      

        QCFORM::where('form_id', $formID)
          ->update([
            'client_id' => $request->client_id,
            'order_repeat' => $request->order_repeat,
            'pre_order_id' => $request->pre_orderno,
            'item_fm_sample_no' => $request->item_fm_sample_no_bulk,
            'order_type' => $dataa,
            'order_type_v1' => $request->order_type_v1,
            'bulkOrderTypeV1' => $request->bulkOrderTypeV1,
            'due_date' => $request->due_date,
            'commited_date' => $request->commited_date,
            'production_rmk' => $request->production_rmk_bulk,
            'packeging_rmk' => $request->packeging_rmk_bulk,
            'order_currency' => $request->currency,
            'exchange_rate' => $request->conv_rate,
            'modification_remarks_updatedby_lasttime' => Auth::user()->id,
            'modification_remarks' => $request->modificationRemarks,
            


          ]);

        //now update BOM Bulk order
        QCBULK_ORDER::where('form_id', $formID)->delete();

        $bsp = 0;
        $itemQty = 0;
        $qcBulkOrder_arr = $request->qcBulkOrder;
        foreach ($qcBulkOrder_arr as $key => $boRow) {

          if (isset($boRow['bulk_sizeUnit'])) {
            $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
            $itemQty = $itemQty + $boRow['bulkItem_qty'];
            $qcbolkObj = new QCBULK_ORDER;
            $qcbolkObj->form_id = $formID;
            $qcbolkObj->item_name = $boRow['bulk_material_name'];
            $qcbolkObj->qty = $boRow['bulkItem_qty'];
            $qcbolkObj->rate = $boRow['bulk_rate'];
            $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
            $qcbolkObj->packing = $boRow['bulk_packing'];
            $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
            $qcbolkObj->save();
          }
        }

        QCFORM::where('form_id', $formID)
          ->update(['bulk_order_value' => $bsp, 'item_qty' => $itemQty,'editByReqStatus'=>0]);

          AyraHelp::getOrderOLDDataUpdateBULK($formID,$update_id);

        //LoggedActicty
        $userID = Auth::user()->id;
        $LoggedName = AyraHelp::getUser($userID)->name;

        $eventName = "Order Edit";
        $eventINFO = 'BULK Order ID ' . $formID . " and edit by to  " . $LoggedName . " on" . date('Y-m-d H:i:s') . " Message" . $request->modificationRemarks;

        $eventID = $formID;
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

        //now update BOM Bulk order

      }
    }
  }


  public function updateQCdataNewWays(Request $request)
  {
    $formID = $request->formID;
    //update his
    $update_id= AyraHelp::getOrderOLDData($formID,1);

    //update  his 
    $ordertype = $request->order_type;
    $dataa = $ordertype == 2 ? 'Bulk' : 'Private Label';
    //Start:updation for private label
    if ($ordertype == 1) {

      QCFORM::where('form_id', $formID)
        ->update([
          'brand_name' => $request->brand,
          'client_id' => $request->client_id,
          'order_repeat' => $request->order_repeat,
          'pre_order_id' => $request->pre_orderno,
          'item_name' => $request->item_name,
          'item_size' => $request->item_size,
          'item_size_unit' => $request->item_size_unit,
          'item_qty' => $request->item_qty,
          'item_qty_unit' => $request->item_qty_unit,
          'item_fm_sample_no' => $request->item_fm_sample_no,
          'item_sp' => $request->item_selling_price,
          'item_sp_unit' => $request->item_selling_UNIT,
          'order_type' => $dataa,
          'order_type_v1' => $request->order_type_v1,
          'due_date' => $request->due_date,
          'commited_date' => $request->commited_date,
          'production_rmk' => $request->production_rmk,
          'packeging_rmk' => $request->packeging_rmk,
          'export_domestic' => $request->order_for,
          'order_currency' => $request->currency,
          'exchange_rate' => $request->conv_rate,
          'order_fragrance' => $request->order_fragrance,
          'order_color' => $request->order_color,
          'modification_remarks_updatedby_lasttime' => Auth::user()->id,
          'modification_remarks' => $request->modificationRemarks,
          'item_RM_Price' => $request->item_RM_Price,
          'item_BCJ_Price' => $request->item_BCJ_Price,
          'item_Label_Price' => $request->item_Label_Price,
          'item_Material_Price' => $request->item_Material_Price,
          'item_LabourConversion_Price' => $request->item_LabourConversion_Price,
          'item_Margin_Price' => $request->item_Margin_Price,
          'price_part_status' => 1,
          'editByReqStatus' => 0,
          
        ]);

      //--------------------------------
      if ($request->hasfile('file')) {
        $file = $request->file('file');
        $img = Image::make($request->file('file'));
        // resize image instance
        $img->resize(320, 240);

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
        $img->save('uploads/qc_form/' . $filename);
        QCFORM::where('form_id', $formID)
          ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
      }
      //--------------------------------//
      //start BOM: private
      //-------------------------------------------
      $res = QCBOM::where('form_id', $formID)->delete();

      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Box';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_box;
      $qcBOMObj->bom_cat = 'BOX';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();
      //---------------------------------------------
      // if printed box and level is order
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Label';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_label;
      $qcBOMObj->bom_cat = 'LABEL';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();
      //--------------------------------------------
      $qc_bom_arr = $request->qc;
      foreach ($qc_bom_arr as $key => $value) {
        $bom = $value['bom'];
        $bom_qty = $value['bom_qty'];
        $bom_cat = $value['bom_cat'];

        $bom_size = '';
        if (isset($value['bom_from'])) {
          $client_bom_from = 'From Client';
        } else {
          $client_bom_from = '';
        }
        $qcBOMObj = new QCBOM;
        $qcBOMObj->m_name = $bom;
        $qcBOMObj->qty = $bom_qty;
        $qcBOMObj->size = $bom_size;
        $qcBOMObj->bom_from = $client_bom_from;
        $qcBOMObj->bom_cat = $bom_cat;
        $qcBOMObj->form_id = $formID;
        $qcBOMObj->save();
      }


      $res = QCPP::where('qc_from_id', $formID)->delete();
      $fomr_id = $formID;
      switch ($request->f_1) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      switch ($request->f_2) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_3) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_4) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------

      //-----------------------
      //-----------------------
      switch ($request->f_5) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_6) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_7) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_8) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_9) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      switch ($request->f_10) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'TAMPER PROOFING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'TAMPER PROOFING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'TAMPER PROOFING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      
      //stop BOM: private
      $this->updatePurchaseListQCEDIt($fomr_id);
    }
    //Stop:updation for private label
//update his

AyraHelp::getOrderOLDDataUpdate($formID,$update_id);



//update  his
    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;

    $eventName = "Order Edit";
    $eventINFO = 'Order ID ' . $fomr_id . " and edit by to  " . $LoggedName . " on" . date('Y-m-d H:i:s') . " Message" . $request->modificationRemarks;

    $eventID = $fomr_id;
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
  public function updateQCdataNewWays_25DEC(Request $request)
  {
    $formID = $request->formID;
    $ordertype = $request->order_type;
    $dataa = $ordertype == 2 ? 'Bulk' : 'Private Label';

    if ($ordertype == 2) {
      $qc_data = AyraHelp::getQCFormDate($formID);
      if (isset($qc_data->qc_from_bulk)) {
        if ($qc_data->qc_from_bulk == 1) {
        } else {
        }
      } else {
      }
    }
    //update private label
    if ($ordertype == 1) {
      QCFORM::where('form_id', $formID)
        ->update([
          'brand_name' => $request->brand,
          'client_id' => $request->client_id,
          'order_repeat' => $request->order_repeat,
          'pre_order_id' => $request->pre_orderno,
          'item_name' => $request->item_name,
          'item_size' => $request->item_size,
          'item_size_unit' => $request->item_size_unit,
          'item_qty' => $request->item_qty,
          'item_qty_unit' => $request->item_qty_unit,
          'item_fm_sample_no' => $request->item_fm_sample_no,
          'item_sp' => $request->item_selling_price,
          'item_sp_unit' => $request->item_selling_UNIT,
          'order_type' => $dataa,
          'due_date' => $request->due_date,
          'commited_date' => $request->commited_date,
          'production_rmk' => $request->production_rmk,
          'packeging_rmk' => $request->packeging_rmk,
          'export_domestic' => $request->order_for,
          'order_currency' => $request->currency,
          'exchange_rate' => $request->conv_rate,
          'order_fragrance' => $request->order_fragrance,
          'order_color' => $request->order_color,
        ]);

      //  form image upload
      if ($request->hasfile('file')) {
        $file = $request->file('file');
        $img = Image::make($request->file('file'));
        // resize image instance
        $img->resize(320, 240);

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
        // insert a watermark
        //$img->insert('public/watermark.png');
        // save image in desired format
        $img->save('uploads/qc_form/' . $filename);
        QCFORM::where('form_id', $formID)
          ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
      }
      //  form image upload
    }
    //update private lable

    //-------------------------------------------
    $res = QCBOM::where('form_id', $formID)->delete();

    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Box';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_box;
    $qcBOMObj->bom_cat = 'BOX';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $formID;
    $qcBOMObj->save();
    //---------------------------------------------
    // if printed box and level is order
    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Label';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_label;
    $qcBOMObj->bom_cat = 'LABEL';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $formID;
    $qcBOMObj->save();
    //--------------------------------------------
    $qc_bom_arr = $request->qc;
    foreach ($qc_bom_arr as $key => $value) {
      $bom = $value['bom'];
      $bom_qty = $value['bom_qty'];
      $bom_cat = $value['bom_cat'];

      $bom_size = '';
      if (isset($value['bom_from'])) {
        $client_bom_from = 'From Client';
      } else {
        $client_bom_from = '';
      }
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = $bom;
      $qcBOMObj->qty = $bom_qty;
      $qcBOMObj->size = $bom_size;
      $qcBOMObj->bom_from = $client_bom_from;
      $qcBOMObj->bom_cat = $bom_cat;
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();
    }


    $res = QCPP::where('qc_from_id', $formID)->delete();
    $fomr_id = $formID;
    switch ($request->f_1) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_2) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_3) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_4) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------

    //-----------------------
    //-----------------------
    switch ($request->f_5) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_6) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_7) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_8) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_9) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }

    $this->updatePurchaseListQCEDIt($fomr_id);

    //update private lable






  }
  public function updateQCdataNewWays_22OCt(Request $request)
  {
    $formID = $request->formID;
    $ordertype = $request->order_type;
    $dataa = $ordertype == 2 ? 'Bulk' : 'Private Label';

    if ($ordertype == 2) {
      $qc_data = AyraHelp::getQCFormDate($formID);
      if (isset($qc_data->qc_from_bulk)) {
        if ($qc_data->qc_from_bulk == 1) {
        } else {
        }
      } else {
      }
    }
    if ($ordertype == 1) {



      QCFORM::where('form_id', $formID)
        ->update([
          'brand_name' => $request->brand,
          'client_id' => $request->client_id,
          'order_repeat' => $request->order_repeat,
          'pre_order_id' => $request->pre_orderno,
          'item_name' => $request->item_name,
          'item_size' => $request->item_size,
          'item_size_unit' => $request->item_size_unit,
          'item_qty' => $request->item_qty,
          'item_qty_unit' => $request->item_qty_unit,
          'item_fm_sample_no' => $request->item_fm_sample_no,
          'item_sp' => $request->item_selling_price,
          'item_sp_unit' => $request->item_selling_UNIT,
          'order_type' => $dataa,
          'due_date' => $request->due_date,
          'commited_date' => $request->commited_date,
          'production_rmk' => $request->production_rmk,
          'packeging_rmk' => $request->packeging_rmk,
          'export_domestic' => $request->order_for,
          'order_currency' => $request->currency,
          'exchange_rate' => $request->conv_rate,
          'order_fragrance' => $request->order_fragrance,
          'order_color' => $request->order_color,
        ]);

      //  form image upload
      if ($request->hasfile('file')) {
        $file = $request->file('file');
        $img = Image::make($request->file('file'));
        // resize image instance
        $img->resize(320, 240);

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
        // insert a watermark
        //$img->insert('public/watermark.png');
        // save image in desired format
        $img->save('uploads/qc_form/' . $filename);
        QCFORM::where('form_id', $formID)
          ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
      }
      //  form image upload

      //-------------------------------------------
      $res = QCBOM::where('form_id', $formID)->delete();
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Box';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_box;
      $qcBOMObj->bom_cat = 'BOX';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();
      //---------------------------------------------
      // if printed box and level is order
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Label';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_label;
      $qcBOMObj->bom_cat = 'LABEL';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();
      //--------------------------------------------
      $qc_bom_arr = $request->qc;
      foreach ($qc_bom_arr as $key => $value) {
        $bom = $value['bom'];
        $bom_qty = $value['bom_qty'];
        $bom_cat = $value['bom_cat'];

        $bom_size = '';
        if (isset($value['bom_from'])) {
          $client_bom_from = 'From Client';
        } else {
          $client_bom_from = '';
        }
        $qcBOMObj = new QCBOM;
        $qcBOMObj->m_name = $bom;
        $qcBOMObj->qty = $bom_qty;
        $qcBOMObj->size = $bom_size;
        $qcBOMObj->bom_from = $client_bom_from;
        $qcBOMObj->bom_cat = $bom_cat;
        $qcBOMObj->form_id = $formID;
        $qcBOMObj->save();
      }


      $res = QCPP::where('qc_from_id', $formID)->delete();
      $fomr_id = $formID;
      switch ($request->f_1) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      switch ($request->f_2) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_3) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_4) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------

      //-----------------------
      //-----------------------
      switch ($request->f_5) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_6) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_7) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_8) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_9) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }



      $qc_data_arr = AyraHelp::getCurrentStageByForMID($fomr_id);
      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);

        $ajStepCode = optional($statge_arr)->step_code;
      } else {

        $ajStepCode = '';
      }


      if ($ajStepCode != 'ART_WORK_RECIEVED') {
        $this->updatePurchaseListQCEDIt($fomr_id);
      }

      //now update purchase list :start


      //now update purchase list : stop

    } //end of private label

  }
  public function updateQCdata(Request $request)
  {

    $formID = $request->formID;
    $ordertype = $request->order_type;
    $dataa = $ordertype == 2 ? 'Bulk' : 'Private Label';

    QCFORM::where('form_id', $formID)
      ->update([
        'brand_name' => $request->brand,
        'client_id' => $request->client_id,
        'order_repeat' => $request->order_repeat,
        'pre_order_id' => $request->pre_orderno,
        'item_name' => $request->item_name,
        'item_size' => $request->item_size,
        'item_size_unit' => $request->item_size_unit,
        'item_qty' => $request->item_qty,
        'item_qty_unit' => $request->item_qty_unit,
        'item_fm_sample_no' => $request->item_fm_sample_no,
        'item_sp' => $request->item_selling_price,
        'item_sp_unit' => $request->item_selling_UNIT,
        'design_client' => $request->d_1,
        'bottle_jar_client' => $request->b_1,
        'lable_client' => $request->l_1,
        'order_type' => $dataa,
        'due_date' => $request->due_date,
        'commited_date' => $request->commited_date,

        'production_rmk' => $request->production_rmk,
        'packeging_rmk' => $request->packeging_rmk,
        'export_domestic' => $request->order_for,
        'order_currency' => $request->currency,
        'exchange_rate' => $request->conv_rate,
        'order_fragrance' => $request->order_fragrance,
        'order_color' => $request->order_color,


      ]);

    $res = QCBOM::where('form_id', $formID)->delete();
    $res = QC_BOM_Purchase::where('form_id', $formID)->delete();

    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Box';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_box;
    $qcBOMObj->bom_cat = 'BOX';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $formID;
    $qcBOMObj->save();

    // if printed box and level is order
    if ($request->printed_box == 'Order') {
      $ac_data = AyraHelp::getQCFormDate($formID);
      $qcbomPObj = new QC_BOM_Purchase;
      $qcbomPObj->form_id = $formID;
      $qcbomPObj->order_id = $ac_data->order_id;
      $qcbomPObj->sub_order_index = $ac_data->subOrder;
      $qcbomPObj->order_name = $request->brand;
      $qcbomPObj->order_cat = 'BOX';
      $qcbomPObj->material_name = 'Printed Box';
      $qcbomPObj->qty = $request->item_qty;
      $qcbomPObj->created_by = Auth::user()->id;
      $qcbomPObj->save();
    }

    // if printed box and level is order


    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Label';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_label;
    $qcBOMObj->bom_cat = 'LABEL';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $formID;
    $qcBOMObj->save();

    // if printed label and level is order
    if ($request->printed_label == 'Order') {
      $ac_data = AyraHelp::getQCFormDate($formID);
      $qcbomPObj = new QC_BOM_Purchase;
      $qcbomPObj->form_id = $formID;
      $qcbomPObj->order_id = $ac_data->order_id;
      $qcbomPObj->sub_order_index = $ac_data->subOrder;
      $qcbomPObj->order_name = $request->brand;
      $qcbomPObj->order_cat = 'LABEL';
      $qcbomPObj->material_name = 'Printed Label';
      $qcbomPObj->qty = $request->item_qty;
      $qcbomPObj->created_by = Auth::user()->id;
      $qcbomPObj->save();
    }

    // if printed lebel and level is order



    $qc_bom_arr = $request->qc;
    foreach ($qc_bom_arr as $key => $value) {
      $bom = $value['bom'];
      $bom_qty = $value['bom_qty'];
      $bom_cat = $value['bom_cat'];

      $bom_size = '';
      if (isset($value['bom_from'])) {
        $client_bom_from = 'From Client';
      } else {
        $client_bom_from = '';
      }

      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = $bom;
      $qcBOMObj->qty = $bom_qty;
      $qcBOMObj->size = $bom_size;
      $qcBOMObj->bom_from = $client_bom_from;
      $qcBOMObj->bom_cat = $bom_cat;
      $qcBOMObj->form_id = $formID;
      $qcBOMObj->save();


      //save data to QC_BOM_Purchase:qc_bo_purchaselist
      if (isset($bom)) {
        if (isset($value['bom_from'])) {
          // $client_bom_from='FromClient';
        } else {
          $ac_data = AyraHelp::getQCFormDate($formID);
          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $ac_data->order_id;
          $qcbomPObj->form_id = $formID;
          $qcbomPObj->sub_order_index = $ac_data->subOrder;
          $qcbomPObj->order_name = $request->brand;
          $qcbomPObj->order_cat = $bom_cat;
          $qcbomPObj->material_name = $bom;
          $qcbomPObj->qty = $bom_qty;
          $qcbomPObj->created_by = Auth::user()->id;
          $qcbomPObj->save();
        }
      }

      //save data to QC_BOM_Purchase:qc_bo_purchaselist

    }




    $res = QCPP::where('qc_from_id', $formID)->delete();
    $fomr_id = $formID;
    switch ($request->f_1) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_2) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_3) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_4) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------

    //-----------------------
    //-----------------------
    switch ($request->f_5) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_6) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_7) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_8) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_9) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }

    //$this->saveToOrderMaster($fomr_id,Auth::user()->id,$step_code_may,Auth::user()->id,$action_start);




  }



  public function qceditBULKForm($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $qc_arr = QCFORM::where('form_id', $id)->first();
    $qcBOM_arr = QCBOM::where('form_id', $id)->get();
    $qcPK_arr = QCPP::where('qc_from_id', $id)->get();
    $qcBULK_arr = QCBULK_ORDER::where('form_id', $id)->get();


    $data = [
      'qc_form' => $qc_arr,
      'qcBOM_form' => $qcBOM_arr,
      'qcPK_form' => $qcPK_arr,
      'qcBULK_arr' => $qcBULK_arr,
    ];

    return $theme->scope('sample.qcfromBulkEdit', $data)->render();
  }


  public function qceditForm($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $qc_arr = QCFORM::where('form_id', $id)->first();
    $qcBOM_arr = QCBOM::where('form_id', $id)->get();
    $qcPK_arr = QCPP::where('qc_from_id', $id)->get();

    $data = [
      'qc_form' => $qc_arr,
      'qcBOM_form' => $qcBOM_arr,
      'qcPK_form' => $qcPK_arr,
    ];

    return $theme->scope('sample.qcfromEdit', $data)->render();
  }

  public function qcFormCopy($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $qc_arr = QCFORM::where('form_id', $id)->first();
    $qcBOM_arr = QCBOM::where('form_id', $id)->get();
    $qcPK_arr = QCPP::where('qc_from_id', $id)->get();

    $data = [
      'qc_form' => $qc_arr,
      'qcBOM_form' => $qcBOM_arr,
      'qcPK_form' => $qcPK_arr,
    ];
    echo "this feature is under maintance. please create new order";
    //return $theme->scope('sample.qcfromCopy', $data)->render();


  }

  public function backOrderUpload()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('sample.uploadOrder_QC', $data)->render();
  }
  public function qcFormListView(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    //abort('401');
    return redirect('v1_getOrderslist');


    //return $theme->scope('sample.qc_list', $data)->render();
  }

  public function PaymentRequestConfirmation(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('orders.v1.paymentRequestConfirmation', $data)->render();
  }
  public function PaymentRequestConfirmationUserID(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('orders.v1.paymentRequestConfirmation', $data)->render();
  }



//oncreditLeadList
public function oncreditLeadList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    return $theme->scope('orders.v1.oncreditLeadRequest', $data)->render();

  }

//oncreditLeadList


  public function SaleInvoiceRequest(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'SalesHead' || Auth::user()->id == 95) {
      return $theme->scope('orders.v1.SalesInvoiceRequestConfirmationAccessed', $data)->render();
    } else {
      return $theme->scope('orders.v1.SalesInvoiceRequestConfirmation', $data)->render();
    }
  }



  public function qcform_getList_BulkList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('sample.qc_list_bulk', $data)->render();
  }

  public function qcFormListViewDispatched(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('sample.qc_list_dispatched', $data)->render();
  }

  public function getQcOrderStagePendingList(Request $request)
  {

    $arr_data_green = OrderMaster::where('order_statge_id', $request->txtStepCode)->where('action_status', 0)->where('action_mark', $request->txtMyMark)->get();



    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || $user_role == 'Staff') {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->get();

      $qc_arr = DB::table('order_master')
        ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
        ->where('order_master.order_statge_id', $request->txtStepCode)
        ->where('order_master.action_status', 0)
        ->where('order_master.action_mark', $request->txtMyMark)
        ->where('qc_forms.is_deleted', 0)
        ->select('qc_forms.*')
        ->get();
    } else {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->where('created_by',Auth::user()->id)->get();

      $qc_arr = DB::table('order_master')
        ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
        ->where('order_master.order_statge_id', $request->txtStepCode)
        ->where('order_master.action_status', 0)
        ->where('order_master.action_mark', $request->txtMyMark)
        ->where('qc_forms.is_deleted', 0)
        ->where('qc_forms.created_by', Auth::user()->id)
        ->select('qc_forms.*')
        ->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
      } else {
        $Spname = '';
      }





      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'Qty' => optional($value)->item_qty,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'Qty'      => true,
      'order_value'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function qcform_getList_dispatched(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }
    

    if ($user_role == 'Admin' || $user_role == 'Staff' || Auth::user()->id == 88 || $user_role == 'SalesHead' || Auth::user()->id == 147 || Auth::user()->id == 146 || Auth::user()->id == 189 || Auth::user()->id == 219 || Auth::user()->id == 249) {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->where('dispatch_status','!=',1)->get();

      // $qc_arr = DB::table('order_dispatch_data')
      //   ->join('qc_forms', 'order_dispatch_data.form_id', '=', 'qc_forms.form_id')
      //   // ->where('qc_forms.dispatch_status','!=',1)
      //   // ->where('qc_forms.is_deleted',0)
      //   ->orderBy('order_dispatch_data.id', 'asc')
      //   ->select('qc_forms.*', 'order_dispatch_data.txtBookingFor', 'order_dispatch_data.dispatch_on as ajdis')
      //   ->get();

      // 'print_r($qc_arr);
      // die;'
      $qc_arr = DB::table('qc_forms')        
      ->where('qc_forms.dispatch_status', '!=', 1)
      ->where('qc_forms.is_deleted', 0)
      // ->where('qc_forms.created_by', Auth::user()->id)
      ->orderBy('qc_forms.form_id', 'asc')
      ->select('qc_forms.*')
      ->get();


    } else {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->where('dispatch_status','!=',1)->where('created_by',Auth::user()->id)->get();
      // $qc_arr = DB::table('order_dispatch_data')
      //   ->join('qc_forms', 'order_dispatch_data.form_id', '=', 'qc_forms.form_id')
      //   ->where('qc_forms.dispatch_status', '!=', 1)
      //   ->where('qc_forms.is_deleted', 0)
      //   ->where('qc_forms.created_by', Auth::user()->id)
      //   ->orderBy('order_dispatch_data.id', 'asc')
      //   ->select('qc_forms.*', 'order_dispatch_data.txtBookingFor', 'order_dispatch_data.dispatch_on as ajdis')
      //   ->get();

        $qc_arr = DB::table('qc_forms')        
        ->where('qc_forms.dispatch_status', '!=', 1)
        ->where('qc_forms.is_deleted', 0)
        ->where('qc_forms.created_by', Auth::user()->id)
        ->orderBy('qc_forms.form_id', 'asc')
        ->select('qc_forms.*')
        ->get();

    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {

      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      //$qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      // if (isset($qc_data_arr->order_statge_id)) {
      //   $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
      //   $Spname = optional($statge_arr)->process_name;
      // } else {
      //   $Spname = '';
      // }
      // echo "<pre>";
      // print_r($value);
      // die;
      $Spname="";

      //$dp_data = AyraHelp::getDispatchedData($value->form_id);



      // $dispatch_on = date('j M Y', strtotime($value->ajdis));


      // if ($value->bulk_order_value > 0) {
      //   $po_value = $value->bulk_order_value;
      // } else {
      //   $po_value = ceil($value->item_qty * $value->item_sp);
      // }


      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => '',
        'order_type' => $value->order_type,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'edit_qc_from' => $edit_qc_from,
        'dispatched_on' => '--',
        'dispatched_status' => optional($value)->dispatch_status,
        'dispatched_for' => optional($value)->txtBookingFor,
        'curr_order_statge' => $Spname,
        //'dispatch_details'=>$dp_data[0],
        'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'edit_qc_from'  => true,
      'dispatched_on'  => true,
      'dispatched_status'  => true,
      'dispatched_for'  => true,
      'dispatch_details'  => true,
      'curr_order_statge'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function qcform_getList_dispatched_1(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || $user_role == 'Staff' || Auth::user()->id == 88 || $user_role == 'SalesHead' || Auth::user()->id == 147 || Auth::user()->id == 146 || Auth::user()->id == 189) {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->where('dispatch_status','!=',1)->get();

      $qc_arr = DB::table('order_dispatch_data')
        ->join('qc_forms', 'order_dispatch_data.form_id', '=', 'qc_forms.form_id')
        // ->where('qc_forms.dispatch_status','!=',1)
        // ->where('qc_forms.is_deleted',0)
        ->orderBy('order_dispatch_data.id', 'asc')
        ->select('qc_forms.*', 'order_dispatch_data.txtBookingFor', 'order_dispatch_data.dispatch_on as ajdis')
        ->get();

      // 'print_r($qc_arr);
      // die;'


    } else {
      //$qc_arr=QCFORM::where('is_deleted','!=',1)->where('dispatch_status','!=',1)->where('created_by',Auth::user()->id)->get();
      $qc_arr = DB::table('order_dispatch_data')
        ->join('qc_forms', 'order_dispatch_data.form_id', '=', 'qc_forms.form_id')
        ->where('qc_forms.dispatch_status', '!=', 1)
        ->where('qc_forms.is_deleted', 0)
        ->where('qc_forms.created_by', Auth::user()->id)
        ->orderBy('order_dispatch_data.id', 'asc')
        ->select('qc_forms.*', 'order_dispatch_data.txtBookingFor', 'order_dispatch_data.dispatch_on as ajdis')
        ->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {

      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
      } else {
        $Spname = '';
      }
      // echo "<pre>";
      // print_r($value);
      // die;


      $dp_data = AyraHelp::getDispatchedData($value->form_id);




      $dispatch_on = date('j M Y', strtotime($value->ajdis));


      if ($value->bulk_order_value > 0) {
        $po_value = $value->bulk_order_value;
      } else {
        $po_value = ceil($value->item_qty * $value->item_sp);
      }


      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => $po_value,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'edit_qc_from' => $edit_qc_from,
        'dispatched_on' => $dispatch_on,
        'dispatched_status' => optional($value)->dispatch_status,
        'dispatched_for' => optional($value)->txtBookingFor,
        'curr_order_statge' => $Spname,
        //'dispatch_details'=>$dp_data[0],
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'edit_qc_from'  => true,
      'dispatched_on'  => true,
      'dispatched_status'  => true,
      'dispatched_for'  => true,
      'dispatch_details'  => true,
      'curr_order_statge'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  public function qcformGetList_OrderLIst(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || $user_role == 'Staff' || Auth::user()->id == 88) {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('client_id', '=', $request->client_ID)->get();
    } else {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
        $Spname = str_replace('/', '-', $Spname);
      } else {
        $Spname = '';
      }


      $bulkCount = AyraHelp::getBULKCount($value->form_id);
      //$bulkData=AyraHelp::getBULKData($value->form_id);






      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //qcformOrderListAdminViewBulkOrders
  public function qcformOrderListAdminViewBulkOrders(Request $request)
  {

    //admin
    $edit_qc_from = 1;
    //$qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
    if(Auth::user()->id==199){
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('is_req_for_issue', '>=', 1)->where('is_req_for_issue', '<=',3 )->get();

    }else{
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('m/d/Y', strtotime($value->created_at));
      // $created_on = date('j M Y', strtotime($value->created_at));
      // $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);



      $users = DB::table('qc_forms')->whereNull('curr_stage_id')->where('form_id', $value->form_id)->first();
      if ($users != null) {

        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;
        $stage_id = $data->stage_id;

        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);



        $affected = DB::table('qc_forms')
          ->where('form_id', $value->form_id)
          //->whereNull('curr_stage_id')
          ->update([
            'curr_stage_id' => $stage_id,
            'curr_stage_name' => $Spname,
            'curr_stage_updated_on' => $days_stayFrom,
            'bo_bulk_cound' => $bulkCount,
          ]);
        $days_stayFrom = $days_stayFrom;
        $Spname = $Spname;
        $bulkCount = $bulkCount;
      } else {
        $days_stayFrom = $value->curr_stage_updated_on;
        $Spname = $value->curr_stage_name;
        $bulkCount = $value->bo_bulk_cound;
      }


      $qc_appr = DB::table('qc_forms')
        ->where('form_id', $value->form_id)
        ->where('account_approval', 0)
        ->first();
      if ($qc_appr != null) {
        $AccApproval = 1;
      } else {
        $AccApproval = 0;
      }



      // $AccApproval = 0;
      // $Spname="KKK";




      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => 'Admin',
        'stay_from' => $days_stayFrom,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'AccApproval' => $AccApproval,
        'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
        'is_req_for_issue' => $value->is_req_for_issue,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);




    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'pricePartStatus'  => true,
      'is_req_for_issue'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //qcformOrderListAdminViewBulkOrders

//qcformOrderPlanOrderView
public function qcformOrderPlanOrderView(Request $request)
  {

    //admin
   
   
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->orderBy('created_at', 'ASC')->get();
    
    

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('m/d/Y', strtotime($value->created_at));
      $due_date = date('j F Y', strtotime($value->due_date));
    


      $unitNo=AyraHelp::getOrderUnitNumber($value->form_id);
      $BatchSizeNo=AyraHelp::getOrderBatchSize($value->form_id);

      
      


      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => 'Admin',
        'stay_from' => 3,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => 1,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => 0,
        'curr_order_statge' => $value->curr_stage_name,
        'AccApproval' => 1,
        'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
        'orderUNIT' => $unitNo,
        'orderBatchSize' => $BatchSizeNo,
        'fillingType' => 1,
        'targetDate' => $due_date,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    
    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'pricePartStatus'  => true,
      'orderUNIT'  => true,
      'orderBatchSize'  => true,
      'fillingType'  => true,
      'targetDate'  => true,      
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

//qcformOrderPlanOrderView

//qcformOrderListAdminViewPending
public function qcformOrderListAdminViewPending(Request $request)
{

  //admin
  $edit_qc_from = 1;
  if(Auth::user()->id==1 || Auth::user()->id==147){
    $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 2)->orderBy('created_at', 'ASC')->get();
  }else{
    $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 2)->orderBy('created_at', 'ASC')->where('client_id','!=','4723')->get();

  }
  

  $i = 0;
  $data_arr_1 = array();
  foreach ($qc_arr as $key => $value) {
    $i++;
    $created_by = AyraHelp::getUserName($value->created_by);
    $created_on = date('m/d/Y', strtotime($value->created_at));
    // $created_on = date('j M Y', strtotime($value->created_at));
    // $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);



    $users = DB::table('qc_forms')->whereNull('curr_stage_id')->where('form_id', $value->form_id)->first();
    if ($users != null) {

      $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
      $Spname = $data->stage_name;
      $stage_id = $data->stage_id;

      $bulkCount = AyraHelp::getBULKCount($value->form_id);
      $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);



      $affected = DB::table('qc_forms')
        ->where('form_id', $value->form_id)
        //->whereNull('curr_stage_id')
        ->update([
          'curr_stage_id' => $stage_id,
          'curr_stage_name' => $Spname,
          'curr_stage_updated_on' => $days_stayFrom,
          'bo_bulk_cound' => $bulkCount,
        ]);
      $days_stayFrom = $days_stayFrom;
      $Spname = $Spname;
      $bulkCount = $bulkCount;
    } else {
      $days_stayFrom = $value->curr_stage_updated_on;
      $Spname = $value->curr_stage_name;
      $bulkCount = $value->bo_bulk_cound;
    }


    $qc_appr = DB::table('qc_forms')
      ->where('form_id', $value->form_id)
      ->where('account_approval', 0)
      ->first();
    if ($qc_appr != null) {
      $AccApproval = 1;
    } else {
      $AccApproval = 0;
    }



    // $AccApproval = 0;
    // $Spname="KKK";




    $data_arr_1[] = array(
      'RecordID' => $i,
      'form_id' => $value->form_id,
      'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
      'brand_name' => optional($value)->brand_name,
      'order_value' => ceil($value->item_qty * $value->item_sp),
      'order_type' => $value->order_type,
      'qc_from_bulk' => $value->qc_from_bulk,
      //'order_value' =>'testdata',
      'item_name' => optional($value)->item_name,
      'client_id' => ($value)->client_id,
      'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
      'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
      'created_by' => $created_by,
      'created_on' => $created_on,
      'role_data' => 'Admin',
      'stay_from' => $days_stayFrom,
      'order_typeNew' => optional($value)->qc_from_bulk,
      'bulkCount' => $bulkCount,
      'bulkOrderValueData' => optional($value)->bulk_order_value,
      'edit_qc_from' => $edit_qc_from,
      'curr_order_statge' => $Spname,
      'AccApproval' => $AccApproval,
      'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
      'Actions' => ""
    );
  }
  $JSON_Data = json_encode($data_arr_1);




  //global

  $columnsDefault = [
    'form_id'     => true,
    'order_id'      => true,
    'brand_name'      => true,
    'item_name'      => true,
    'order_value'      => true,
    'order_type'      => true,
    'qc_from_bulk'      => true,
    'client_id'      => true,
    'order_repeat'      => true,
    'pre_order_id' => true,
    'created_by'  => true,
    'created_on'  => true,
    'role_data'  => true,
    'stay_from'  => true,
    'order_typeNew'  => true,
    'bulkCount'  => true,
    'bulkOrderValueData'  => true,
    'edit_qc_from'  => true,
    'curr_order_statge'  => true,
    'bulk_data'  => true,
    'AccApproval'  => true,
    'pricePartStatus'  => true,
    'Actions'      => true,
  ];
  $this->DataGridResponse($JSON_Data, $columnsDefault);
}

//qcformOrderListAdminViewPending

  //qcformOrderListAdminView
  public function qcformOrderListAdminView(Request $request)
  {

    //admin
    $edit_qc_from = 1;
    if(Auth::user()->id==1 || Auth::user()->id==147){
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->orderBy('created_at', 'ASC')->get();
    }else{
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->orderBy('created_at', 'ASC')->where('client_id','!=','4723')->get();

    }
    
    

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('m/d/Y', strtotime($value->created_at));
      // $created_on = date('j M Y', strtotime($value->created_at));
      // $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);



      $users = DB::table('qc_forms')->whereNull('curr_stage_id')->where('form_id', $value->form_id)->first();
      if ($users != null) {

        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;
        $stage_id = $data->stage_id;

        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);



        $affected = DB::table('qc_forms')
          ->where('form_id', $value->form_id)
          //->whereNull('curr_stage_id')
          ->update([
            'curr_stage_id' => $stage_id,
            'curr_stage_name' => $Spname,
            'curr_stage_updated_on' => $days_stayFrom,
            'bo_bulk_cound' => $bulkCount,
          ]);
        $days_stayFrom = $days_stayFrom;
        $Spname = $Spname;
        $bulkCount = $bulkCount;
      } else {
        $days_stayFrom = $value->curr_stage_updated_on;
        $Spname = $value->curr_stage_name;
        $bulkCount = $value->bo_bulk_cound;
      }


      $qc_appr = DB::table('qc_forms')
        ->where('form_id', $value->form_id)
        ->where('account_approval', 0)
        ->first();
      if ($qc_appr != null) {
        $AccApproval = 1;
      } else {
        $AccApproval = 0;
      }



      // $AccApproval = 0;
      // $Spname="KKK";




      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => 'Admin',
        'stay_from' => $days_stayFrom,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'AccApproval' => $AccApproval,
        'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);




    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'pricePartStatus'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  public function getOrderListForTeam(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    $user_id = $request->UserID;

    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 89 ||  Auth::user()->id == 87 || Auth::user()->id == 95 || Auth::user()->id == 84 || Auth::user()->id == 91 ||  Auth::user()->id == 85 || Auth::user()->id == 88 || Auth::user()->id == 118 || $user_role == 'SalesHead') {
      //admin
      $edit_qc_from = 1;
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', $user_id)->get();

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if ($dateTimestamp1 > $dateTimestamp2) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }



        if ($user_role == 'Admin' || $user_role == 'ASalesHead') {
          $AccApproval = 0;
        }




        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);
    } else {
      //sales
      if (Auth::user()->hasPermissionTo('edit-qc-from')) {
        $edit_qc_from = 1;
      } else {
        $edit_qc_from = 0;
      }

      if ($user_role != 'Staff') {
        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', $user_id)->get();
      } else {

        $qc_arr = DB::table('qc_forms')
          ->join('clients', 'qc_forms.client_id', '=', 'clients.id')
          ->select('qc_forms.*')
          ->where('qc_forms.is_deleted', '!=', 1)
          ->where('qc_forms.dispatch_status', '=', 1)
          ->where('qc_forms.created_by', $user_id)
          //->orwhere('clients.client_owner_too',Auth::user()->id)
          ->get();
      }

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if ($dateTimestamp1 > $dateTimestamp2) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }


        // $AccApproval=0;



        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);

      //sales
    }
    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //qcformOrderListAdminView
//qcformGetList_v1_fast
public function qcformGetList_v1_fast(Request $request)
  {

    //admin
    $edit_qc_from = 1;
    $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->orderBy('created_at', 'ASC')->get();

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('m/d/Y', strtotime($value->created_at));
      // $created_on = date('j M Y', strtotime($value->created_at));
      // $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);



      $users = DB::table('qc_forms')->whereNull('curr_stage_id')->where('form_id', $value->form_id)->first();
      if ($users != null) {

        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;
        $stage_id = $data->stage_id;

        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);



        $affected = DB::table('qc_forms')
          ->where('form_id', $value->form_id)
          //->whereNull('curr_stage_id')
          ->update([
            'curr_stage_id' => $stage_id,
            'curr_stage_name' => $Spname,
            'curr_stage_updated_on' => $days_stayFrom,
            'bo_bulk_cound' => $bulkCount,
          ]);
        $days_stayFrom = $days_stayFrom;
        $Spname = $Spname;
        $bulkCount = $bulkCount;
      } else {
        $days_stayFrom = $value->curr_stage_updated_on;
        $Spname = $value->curr_stage_name;
        $bulkCount = $value->bo_bulk_cound;
      }


      $qc_appr = DB::table('qc_forms')
        ->where('form_id', $value->form_id)
        ->where('account_approval', 0)
        ->first();
      if ($qc_appr != null) {
        $AccApproval = 1;
      } else {
        $AccApproval = 0;
      }



      // $AccApproval = 0;
      // $Spname="KKK";




      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => 'Admin',
        'stay_from' => $days_stayFrom,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'AccApproval' => $AccApproval,
        'pricePartStatus' => is_null($value->item_RM_Price) ? 0 : 1,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);




    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'pricePartStatus'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
//qcformGetList_v1_fast

  //qcformGetList_v1
  public function qcformGetList_v1(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 89 ||  Auth::user()->id == 87 || Auth::user()->id == 124 || Auth::user()->id == 84 || Auth::user()->id == 91 ||  Auth::user()->id == 85 || Auth::user()->id == 88 || Auth::user()->id == 118 || $user_role == 'SalesHead' || Auth::user()->id == 173 || Auth::user()->id == 176 || Auth::user()->id == 185  || Auth::user()->id==233 || Auth::user()->id==249) {
      //admin 
      $edit_qc_from = 1;
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('client_id','!=','4723')->get();

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if ($dateTimestamp1 > $dateTimestamp2) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }



        if ($user_role == 'Admin' || $user_role == 'ASalesHead') {
          $AccApproval = 0;
        }




        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'price_part_status' => $value->price_part_status,
          'editByReqStatus' => $value->editByReqStatus,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);
    } else {
      //sales
      if (Auth::user()->hasPermissionTo('edit-qc-from')) {
        $edit_qc_from = 1;
      } else {
        $edit_qc_from = 0;
      }

      if ($user_role != 'Staff') {
        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
      } else {

        $qc_arr = DB::table('qc_forms')
          ->join('clients', 'qc_forms.client_id', '=', 'clients.id')
          ->select('qc_forms.*')
          ->where('qc_forms.is_deleted', '!=', 1)
          ->where('qc_forms.dispatch_status', '=', 1)
          ->where('qc_forms.created_by', Auth::user()->id)
          //->orwhere('clients.client_owner_too',Auth::user()->id)
          ->get();
      }

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if (strtotime($dateTimestamp1) > strtotime($dateTimestamp2)) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }


        // $AccApproval=0;



        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'price_part_status' => $value->price_part_status,
          'dispatch_status' =>  $value->dispatch_status,
          'editByReqStatus' => $value->editByReqStatus,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);

      //sales
    }
    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'price_part_status'  => true,
      'editByReqStatus'  => true,
      'dispatch_status' => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //qcformGetList_v1

  public function qcFormListV1(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 89 ||  Auth::user()->id == 87 || Auth::user()->id == 124 || Auth::user()->id == 84 || Auth::user()->id == 91 ||  Auth::user()->id == 85 || Auth::user()->id == 88 || Auth::user()->id == 118 || $user_role == 'SalesHead' || Auth::user()->id == 173 || Auth::user()->id == 176 || Auth::user()->id==233) {
      //admin
      $edit_qc_from = 1;
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if ($dateTimestamp1 > $dateTimestamp2) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }



        if ($user_role == 'Admin' || $user_role == 'ASalesHead') {
          $AccApproval = 0;
        }




        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'price_part_status' => $value->price_part_status,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);
    } else {
      //sales
      if (Auth::user()->hasPermissionTo('edit-qc-from')) {
        $edit_qc_from = 1;
      } else {
        $edit_qc_from = 0;
      }

      if ($user_role != 'Staff') {
        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
      } else {

        $qc_arr = DB::table('qc_forms')
          ->join('clients', 'qc_forms.client_id', '=', 'clients.id')
          ->select('qc_forms.*')
          ->where('qc_forms.is_deleted', '!=', 1)
          ->where('qc_forms.dispatch_status', '=', 1)
          ->where('qc_forms.created_by', Auth::user()->id)
          //->orwhere('clients.client_owner_too',Auth::user()->id)
          ->get();
      }

      $i = 0;
      $data_arr_1 = array();
      foreach ($qc_arr as $key => $value) {
        $i++;
        $created_by = AyraHelp::getUserName($value->created_by);
        $created_on = date('j M Y', strtotime($value->created_at));
        $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
        $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
        $Spname = $data->stage_name;


        $bulkCount = AyraHelp::getBULKCount($value->form_id);
        $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

        //$bulkData=AyraHelp::getBULKData($value->form_id);

        $date1 = '2020-03-12 16:45:10';
        $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
        $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

        if ($dateTimestamp1 > $dateTimestamp2) {
          //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
          $AccApproval = 0;
        } else {
          //check approved or not if approved then 1 else 2
          $qc_appr = DB::table('qc_forms')
            ->where('form_id', $value->form_id)
            ->where('account_approval', 0)
            ->first();
          if ($qc_appr != null) {
            $AccApproval = 1;
          } else {
            $AccApproval = 0;
          }
        }


        // $AccApproval=0;



        $data_arr_1[] = array(
          'RecordID' => $i,
          'form_id' => $value->form_id,
          'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
          'brand_name' => optional($value)->brand_name,
          'order_value' => ceil($value->item_qty * $value->item_sp),
          'order_type' => $value->order_type,
          'qc_from_bulk' => $value->qc_from_bulk,
          //'order_value' =>'testdata',
          'item_name' => optional($value)->item_name,
          'client_id' => ($value)->client_id,
          'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
          'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
          'created_by' => $created_by,
          'created_on' => $created_on,
          'role_data' => $user_role,
          'stay_from' => $days_stayFrom,
          'order_typeNew' => optional($value)->qc_from_bulk,
          'bulkCount' => $bulkCount,
          'bulkOrderValueData' => optional($value)->bulk_order_value,
          'edit_qc_from' => $edit_qc_from,
          'curr_order_statge' => $Spname,
          'AccApproval' => $AccApproval,
          'price_part_status' => $value->price_part_status,
          'Actions' => ""
        );
      }
      $JSON_Data = json_encode($data_arr_1);

      //sales
    }
    //global

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'price_part_status'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function qcFormListV1_BK(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || Auth::user()->id == 132 || Auth::user()->id == 89 ||  Auth::user()->id == 87 || Auth::user()->id == 95 || Auth::user()->id == 84 || Auth::user()->id == 91 ||  Auth::user()->id == 85 || Auth::user()->id == 88 || Auth::user()->id == 118 || $user_role == 'SalesHead' || Auth::user()->id==233) {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
    } else {

      if ($user_role != 'Staff') {
        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
      } else {

        $qc_arr = DB::table('qc_forms')
          ->join('clients', 'qc_forms.client_id', '=', 'clients.id')
          ->select('qc_forms.*')
          ->where('qc_forms.is_deleted', '!=', 1)
          ->where('qc_forms.dispatch_status', '=', 1)
          ->where('qc_forms.created_by', Auth::user()->id)
          //->orwhere('clients.client_owner_too',Auth::user()->id)
          ->get();
      }
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));
      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);
      $data = AyraHelp::getProcessCurrentStage(1, $value->form_id);
      $Spname = $data->stage_name;


      $bulkCount = AyraHelp::getBULKCount($value->form_id);
      $days_stayFrom = AyraHelp::getStayFromOrder($value->form_id);

      //$bulkData=AyraHelp::getBULKData($value->form_id);

      $date1 = '2020-03-12 16:45:10';
      $dateTimestamp1 =  date('Y-m-d H:i', strtotime($date1));
      $dateTimestamp2 = date('Y-m-d H:i', strtotime($value->created_at));

      if ($dateTimestamp1 > $dateTimestamp2) {
        //echo "$dateTimestamp1 is latestA than $dateTimestamp2";
        $AccApproval = 0;
      } else {
        //check approved or not if approved then 1 else 2
        $qc_appr = DB::table('qc_forms')
          ->where('form_id', $value->form_id)
          ->where('account_approval', 0)
          ->first();
        if ($qc_appr != null) {
          $AccApproval = 1;
        } else {
          $AccApproval = 0;
        }
      }






      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'stay_from' => $days_stayFrom,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'AccApproval' => $AccApproval,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);

    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'stay_from'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'AccApproval'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }




  public function qcFormList(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || $user_role == 'Staff' || Auth::user()->id == 88) {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->get();
    } else {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
        $Spname = str_replace('/', '-', $Spname);
      } else {
        $Spname = '';
      }


      $bulkCount = AyraHelp::getBULKCount($value->form_id);
      //$bulkData=AyraHelp::getBULKData($value->form_id);






      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function qcformgetListBulk(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if (Auth::user()->hasPermissionTo('edit-qc-from')) {
      $edit_qc_from = 1;
    } else {
      $edit_qc_from = 0;
    }

    if ($user_role == 'Admin' || $user_role == 'Staff') {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('order_type', '=', 'Bulk')->where('dispatch_status', '=', 1)->get();
    } else {
      $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('order_type', '=', 'Bulk')->where('dispatch_status', '=', 1)->get();
    }

    $i = 0;
    $data_arr_1 = array();
    foreach ($qc_arr as $key => $value) {
      $i++;
      $created_by = AyraHelp::getUserName($value->created_by);
      $created_on = date('j M Y', strtotime($value->created_at));


      $qc_data_arr = AyraHelp::getCurrentStageByForMID($value->form_id);


      if (isset($qc_data_arr->order_statge_id)) {
        $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
        $Spname = optional($statge_arr)->process_name;
        $Spname = str_replace('/', '-', $Spname);
      } else {
        $Spname = '';
      }


      $bulkCount = AyraHelp::getBULKCount($value->form_id);
      //$bulkData=AyraHelp::getBULKData($value->form_id);






      $data_arr_1[] = array(
        'RecordID' => $i,
        'form_id' => $value->form_id,
        'order_id' => optional($value)->order_id . "/" . optional($value)->subOrder,
        'brand_name' => optional($value)->brand_name,
        'order_value' => ceil($value->item_qty * $value->item_sp),
        'order_type' => $value->order_type,
        'qc_from_bulk' => $value->qc_from_bulk,
        //'order_value' =>'testdata',
        'item_name' => optional($value)->item_name,
        'client_id' => ($value)->client_id,
        'order_repeat' => $value->order_repeat == 2 ? 'YES' : 'NO',
        'pre_order_id' => optional($value)->order_repeat == 2 ? $value->pre_order_id : '',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'role_data' => $user_role,
        'order_typeNew' => optional($value)->qc_from_bulk,
        'bulkCount' => $bulkCount,
        'bulkOrderValueData' => optional($value)->bulk_order_value,
        'edit_qc_from' => $edit_qc_from,
        'curr_order_statge' => $Spname,
        'is_req_for_issue' => $value->is_req_for_issue,
        'Actions' => ""
      );
    }
    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'form_id'     => true,
      'order_id'      => true,
      'brand_name'      => true,
      'item_name'      => true,
      'order_value'      => true,
      'order_type'      => true,
      'qc_from_bulk'      => true,
      'client_id'      => true,
      'order_repeat'      => true,
      'pre_order_id' => true,
      'created_by'  => true,
      'created_on'  => true,
      'role_data'  => true,
      'order_typeNew'  => true,
      'bulkCount'  => true,
      'bulkOrderValueData'  => true,
      'edit_qc_from'  => true,
      'curr_order_statge'  => true,
      'bulk_data'  => true,
      'is_req_for_issue'  => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function saveQC_Copy(Request $request)
  {
    $orderEntry = $request->orderEntry;
    if ($orderEntry == 'fresh') {
    } else {
      $rcorder_arr = QCFORM::where('order_id', $request->order_id)->get();
      $order_id = $request->order_id;
      $order_index = $request->txtOrderIndex;
      $subOrder = count($rcorder_arr) + 1;
    }

    $order_id = AyraHelp::getOrderCODE();
    $order_index = AyraHelp::getOrderCODEIndex();
    $subOrder = 1;

    //Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form
    if ($request->txtOrderTypeNew == 2) {



      // save data qcform
      $qcformObj = new QCFORM;
      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = $request->order_crated_by;;
      $qcformObj->created_by_ori = Auth::user()->id;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->qc_from_bulk = 1;


      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no);

      $qcformObj->item_sp = 0;
      // $qcformObj->item_sp_unit='';


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';
      $otStr = 'Bulk';
      $qcformObj->order_type = 'Bulk';
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk;
      $qcformObj->packeging_rmk = $request->packeging_rmk;

      // $qcformObj->export_domestic=$request->order_for;
      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();
      $fomr_id = $qcformObj->id;

      $bsp = 0;
      $itemQty = 0;
      $qcBulkOrder_arr = $request->qcBulkOrder;
      foreach ($qcBulkOrder_arr as $key => $boRow) {
        $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $itemQty = $itemQty + $boRow['bulkItem_qty'];

        $qcbolkObj = new QCBULK_ORDER;
        $qcbolkObj->form_id = $fomr_id;
        $qcbolkObj->item_name = $boRow['bulk_material_name'];
        $qcbolkObj->qty = $boRow['bulkItem_qty'];
        $qcbolkObj->rate = $boRow['bulk_rate'];
        $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
        $qcbolkObj->packing = $boRow['bulk_packing'];
        $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $qcbolkObj->save();
      }

      QCFORM::where('form_id', $fomr_id)
        ->update(['bulk_order_value' => $bsp, 'item_qty' => $itemQty]);


      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();


      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 1;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();

      //next assin
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'PRODUCTION';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 0;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();


      // save data qcform


      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );
    } else {    //Update code :V1: 2019-07-19 // also make auto start and assign to next too stages



      //save data
      $ot = $request->order_type;
      if ($ot == 1) {
        $otStr = 'Private Label';
      } else {
        $otStr = 'Bulk';
      }
      $qcformObj = new QCFORM;

      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = Auth::user()->id;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->item_name = ucwords($request->item_name);
      $qcformObj->item_size = ucwords($request->item_size);
      $qcformObj->item_size_unit = ucwords($request->item_size_unit);

      $qcformObj->item_qty = $request->item_qty;
      $qcformObj->item_qty_unit = $request->item_qty_unit;
      $bomqty_aj = $request->item_qty;

      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no);

      $qcformObj->item_sp = $request->item_selling_price;
      $qcformObj->item_sp_unit = $request->item_selling_UNIT;


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';

      $qcformObj->order_type = $otStr;
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk;
      $qcformObj->packeging_rmk = $request->packeging_rmk;

      $qcformObj->export_domestic = $request->order_for;
      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repea == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      } else {
        if ($ot == 1 && $request->order_repeat == 2) {
          $qcformObj->artwork_status = 1;
        } else {
          $qcformObj->artwork_status = 0;
        }

        $action_start = 0;
        $step_code_may = 'ART_WORK_REVIEW';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();

      $fomr_id = $qcformObj->id;


      //  form image upload
      if ($request->hasfile('file')) {
        $file = $request->file('file');
        $img = Image::make($request->file('file'));
        // resize image instance
        $img->resize(600, 600);

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
        // insert a watermark
        //$img->insert('public/watermark.png');
        // save image in desired format
        $img->save('uploads/qc_form/' . $filename);
        QCFORM::where('form_id', $fomr_id)
          ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
      }
      //  form image upload

      $qc_bom_arr = $request->qc;

      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Box';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_box;
      $qcBOMObj->bom_cat = 'BOX';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();
      // if printed box and level is order
      if ($ot == 1 && $request->order_repeat == 1) {
      } else {
        if ($request->printed_box == 'Order') {
          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $order_id;
          $qcbomPObj->form_id = $fomr_id;
          $qcbomPObj->sub_order_index = $subOrder;
          $qcbomPObj->order_name = $request->brand;
          $qcbomPObj->order_cat = 'BOX';
          $qcbomPObj->material_name = 'Printed Box';
          $qcbomPObj->qty = $bomqty_aj;
          $qcbomPObj->created_by = Auth::user()->id;
          $qcbomPObj->save();
        }
      }


      // if printed box and level is order


      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Label';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_label;
      $qcBOMObj->bom_cat = 'LABEL';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();
      // if printed box and level is order
      if ($ot == 1 && $request->order_repeat == 1) {
      } else {
        if ($request->printed_label == 'Order') {

          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $order_id;
          $qcbomPObj->form_id = $fomr_id;
          $qcbomPObj->sub_order_index = $subOrder;
          $qcbomPObj->order_name = $request->brand;
          $qcbomPObj->order_cat = 'LABEL';
          $qcbomPObj->material_name = 'Printed Label';
          $qcbomPObj->qty = $bomqty_aj;
          $qcbomPObj->created_by = Auth::user()->id;
          $qcbomPObj->save();
        }
      }



      // if printed box and level is order





      foreach ($qc_bom_arr as $key => $value) {
        $bom = $value['bom'];
        $bom_qty = $value['bom_qty'];
        $bom_cat = $value['bom_cat'];

        if (isset($value['bom_from'])) {
          $client_bom_from = 'From Client';
        } else {
          $client_bom_from = '';
        }

        $bom_size = '';
        $qcBOMObj = new QCBOM;
        $qcBOMObj->m_name = $bom;
        $qcBOMObj->qty = $bom_qty;
        $qcBOMObj->size = $bom_size;
        $qcBOMObj->bom_from = $client_bom_from;
        $qcBOMObj->bom_cat = $bom_cat;
        $qcBOMObj->form_id = $fomr_id;
        $qcBOMObj->save();



        //save data to QC_BOM_Purchase:qc_bo_purchaselist
        if (isset($bom)) {
          if (isset($value['bom_from'])) {
            // $client_bom_from='FromClient';
          } else {
            if ($ot == 1 && $request->order_repeat == 1) {
            } else {

              if ($client_bom_from == 'FromClient' || $client_bom_from == 'FromClient') {
              } else {
                $qcbomPObj = new QC_BOM_Purchase;
                $qcbomPObj->order_id = $order_id;
                $qcbomPObj->form_id = $fomr_id;
                $qcbomPObj->sub_order_index = $subOrder;
                $qcbomPObj->order_name = $request->brand;
                $qcbomPObj->order_cat = $bom_cat;
                $qcbomPObj->material_name = $bom;
                $qcBOMObj->bom_from = $client_bom_from;
                $qcbomPObj->qty = $bom_qty;
                $qcbomPObj->created_by = Auth::user()->id;
                $qcbomPObj->save();
              }
            }
          }
        }

        //save data to QC_BOM_Purchase:qc_bo_purchaselist
      }


      switch ($request->f_1) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      switch ($request->f_2) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_3) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_4) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------

      //-----------------------
      //-----------------------
      switch ($request->f_5) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_6) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_7) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_8) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_9) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------


      // now check if order is bulk  start
      if ($ot == 1) {
        //$otStr='Private Label';
        if ($request->order_repeat == 2) {

          if ($request->printed_label == 'From Client' && $request->printed_box == 'From Client') {
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 1;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 3;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();
          } else {
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 1;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();
          }
        }
      } else {

        $opdObj = new OPData;
        $opdObj->order_id_form_id = $fomr_id; //formid and order id
        $opdObj->step_id = 1;
        $opdObj->expected_date = date('Y-m-d');
        $opdObj->remaks = 'Order starts as added order';
        $opdObj->created_by = Auth::user()->id;
        $opdObj->assign_userid = Auth::user()->id;
        $opdObj->status = 1;
        $opdObj->step_status = 0;
        $opdObj->color_code = 'completed';
        $opdObj->diff_data = '1 second before';
        $opdObj->save();
      }

      //save data

      //check order is bulk and repeat if yes then add to order master model
      $this->saveToOrderMaster($fomr_id, Auth::user()->id, $step_code_may, Auth::user()->id, $action_start);

      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );
    }

    return response()->json($res_arr);
  }

  //saveQCdataPricePart
  public function saveQCdataPricePart(Request $request)
  {
    //print_r($request->all());
    //qcforms_pricepart_edit_request
    $dataView = array(
      'item_size' => $request->item_size,
      'item_qty' => $request->item_qty,
      'item_RM_Price' => $request->item_RM_Price,
      'item_BCJ_Price' => $request->item_BCJ_Price,
      'item_Label_Price' => $request->item_Label_Price,
      'item_Material_Price' => $request->item_Material_Price,
      'item_LabourConversion_Price' => $request->item_LabourConversion_Price,
      'item_Margin_Price' => $request->item_Margin_Price,
      'item_sp' => $request->item_selling_price,
      'orderVal' => $request->order_value,
      'remarks' => $request->orderModifyRemarks,
      'request_by' => Auth::user()->id,
      'requset_on' => date('Y-m-d H:i:s'),
      'req_json_data' => $request->itemSizeModify,
    );

    DB::table('qcforms_pricepart_edit_request')
      ->updateOrInsert(
        ['form_id' => $request->order_idModify],
        [
          'item_size' => $request->item_size,
          'item_qty' => $request->item_qty,
          'item_RM_Price' => $request->item_RM_Price,
          'item_BCJ_Price' => $request->item_BCJ_Price,
          'item_Label_Price' => $request->item_Label_Price,
          'item_Material_Price' => $request->item_Material_Price,
          'item_LabourConversion_Price' => $request->item_LabourConversion_Price,
          'item_Margin_Price' => $request->item_Margin_Price,
          'item_sp' => $request->item_selling_price,
          'orderVal' => $request->order_value,
          'remarks' => $request->orderModifyRemarks,
          'request_by' => Auth::user()->id,
          'requset_on' => date('Y-m-d H:i:s'),
          'req_json_data' => json_encode($dataView)
        ]
      );


    //qcforms_pricepart_edit_request
  }

  //saveQCdataPricePart


  public function saveQCdata(Request $request)
  {

    //artwork_approval_status

    //artwork_approval_status


    //  print_r($request->all());
    //  die;
    //production_rmk_bulk

    $orderEntry = $request->orderEntry;
    if ($orderEntry == 'fresh') {
      $order_id = AyraHelp::getOrderCODE();
      $order_index = AyraHelp::getOrderCODEIndex();
      $subOrder = 1;
    } else {
      $rcorder_arr = QCFORM::where('order_id', $request->order_id)->get();
      $order_id = $request->order_id;
      $order_index = $request->txtOrderIndex;
      $subOrder = count($rcorder_arr) + 1;
    }



    // START:Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form

    if ($request->txtOrderTypeNew == 2) {

      $qcformObj = new QCFORM;
      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = $request->order_crated_by;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->qc_from_bulk = 1;
      $qcformObj->bulkOrderTypeV1 = $request->bulkOrderTypeV1;

      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_bulk_N);

      $qcformObj->item_sp = 0;


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';
      $otStr = 'Bulk';
      $qcformObj->order_type = 'Bulk';
      $qcformObj->order_type_v1 = $request->order_type_v1;
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk_bulk;
      $qcformObj->packeging_rmk = $request->packeging_rmk_bulk;


      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();
      $fomr_id = $qcformObj->id;

      $bsp = 0;
      $itemQty = 0;
      $qcBulkOrder_arr = $request->qcBulkOrder;
      $aj = 0;
      foreach ($qcBulkOrder_arr as $key => $boRow) {
        $aj++;
        $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $itemQty = $itemQty + $boRow['bulkItem_qty'];
        $qcbolkObj = new QCBULK_ORDER;
        $qcbolkObj->form_id = $fomr_id;
        $qcbolkObj->item_name = $boRow['bulk_material_name'];
        $qcbolkObj->qty = $boRow['bulkItem_qty'];
        $qcbolkObj->rate = $boRow['bulk_rate'];
        $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
        $qcbolkObj->packing = $boRow['bulk_packing'];
        $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $qcbolkObj->save();
      }


      QCFORM::where('form_id', $fomr_id)
        ->update(['bulk_order_value' => $bsp, 'item_qty' => $itemQty, 'bo_bulk_cound' => $aj++]);

      // olde stage
      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();


      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 1;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();

      //next assin
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'PRODUCTION';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 0;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();


      // olde stage


      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );

      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 9,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 0,
        ]
      );

      //Stop :save on stage



      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );

      return response()->json($res_arr);
    }
    // STOP Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form
    //22 OCT 2019
    //START save old bulk and private order
    //save data
    $ot = $request->order_type;
    if ($ot == 1) {
      $otStr = 'Private Label';
    } else {
      $otStr = 'Bulk';
    }
    $qcformObj = new QCFORM;

    $qcformObj->order_id = $order_id;
    $qcformObj->order_index = $order_index;
    $qcformObj->subOrder = $subOrder;

    $qcformObj->client_id = $request->client_id;
    $qcformObj->created_by = $request->order_crated_by;
    $qcformObj->created_by_ori = Auth::user()->id;
    $qcformObj->brand_name = $request->brand;
    $qcformObj->subOrder = $subOrder;
    $qcformObj->yr = date('Y');
    $qcformObj->mo = date('m');
    $qcformObj->order_repeat = $request->order_repeat;
    $qcformObj->pre_order_id = $request->pre_orderno;
    $qcformObj->item_name = ucwords($request->item_name);
    $qcformObj->item_size = ucwords($request->item_size);
    $qcformObj->item_size_unit = ucwords($request->item_size_unit);

    $qcformObj->item_qty = $request->item_qty;
    $qcformObj->item_qty_unit = $request->item_qty_unit;
    $bomqty_aj = $request->item_qty;

    $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no_bulk_N);

    $qcformObj->item_sp = $request->item_selling_price;
    $qcformObj->item_sp_unit = $request->item_selling_UNIT;


    $qcformObj->design_client = '';
    $qcformObj->bottle_jar_client = '';
    $qcformObj->lable_client = '';

    $qcformObj->order_type = $otStr;
    $qcformObj->order_type_v1 = $request->order_type_v1;
    $qcformObj->due_date = $request->due_date;
    $qcformObj->commited_date = $request->commited_date;
    $qcformObj->production_rmk = $request->production_rmk;
    $qcformObj->packeging_rmk = $request->packeging_rmk;
    $qcformObj->export_domestic = $request->order_for;
    $qcformObj->order_currency = $request->currency;
    $qcformObj->exchange_rate = $request->conv_rate;
    $qcformObj->order_fragrance = $request->order_fragrance;
    $qcformObj->order_color = $request->order_color;
    $qcformObj->artwork_approval_status = $request->artwork_approval_status;
    $qcformObj->dispatch_status = 1;
    if ($otStr == 'Bulk' || $request->order_repea == 2) {
      $qcformObj->artwork_status = 1;
      $action_start = 1;
      $step_code_may = 'PRODUCTION';
    } else {
      if ($ot == 1 && $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
      } else {
        $qcformObj->artwork_status = 0;
      }

      $action_start = 0;
      $step_code_may = 'ART_WORK_REVIEW';
    }
    $qcformObj->artwork_start_date = date('Y-m-d');

    // new price 
    $qcformObj->item_RM_Price = $request->item_RM_Price;
    $qcformObj->item_BCJ_Price = $request->item_BCJ_Price;
    $qcformObj->item_Label_Price = $request->item_Label_Price;
    $qcformObj->item_Material_Price = $request->item_Material_Price;
    $qcformObj->item_LabourConversion_Price = $request->item_LabourConversion_Price;
    $qcformObj->item_Margin_Price = $request->item_Margin_Price;    // new price 
    $qcformObj->price_part_status = 1;    // new price 

    $qcformObj->save();

    $fomr_id = $qcformObj->id;


    //  form image upload
    if ($request->hasfile('fileAA')) {
      $file = $request->file('file');
      $img = Image::make($request->file('file'));
      // resize image instance
      $img->resize(320, 240);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
    }
    if ($request->hasfile('file')) {

      $filename = '';

      $file = $request->file('file');
      $filename =  rand(10, 100) . Auth::user()->id . "img" .  date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);


      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'local/public/uploads/photos/' . $filename]);
    }

    //  form image upload

    $qc_bom_arr = $request->qc;

    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Box';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_box;
    $qcBOMObj->bom_cat = 'BOX';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_box == 'Order') {
        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'BOX';
        $qcbomPObj->material_name = 'Printed Box';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }


    // if printed box and level is order


    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Label';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_label;
    $qcBOMObj->bom_cat = 'LABEL';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_label == 'Order') {

        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'LABEL';
        $qcbomPObj->material_name = 'Printed Label';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }



    // if printed box and level is order





    foreach ($qc_bom_arr as $key => $value) {
      $bom = $value['bom'];
      $bom_qty = $value['bom_qty'];
      $bom_cat = $value['bom_cat'];

      if (isset($value['bom_from'])) {
        $client_bom_from = 'From Client';
      } else {
        $client_bom_from = '';
      }

      $bom_size = '';
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = $bom;
      $qcBOMObj->qty = $bom_qty;
      $qcBOMObj->size = $bom_size;
      $qcBOMObj->bom_from = $client_bom_from;
      $qcBOMObj->bom_cat = $bom_cat;
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();



      //save data to QC_BOM_Purchase:qc_bo_purchaselist
      if (isset($bom)) {
        if (isset($value['bom_from'])) {
          // $client_bom_from='FromClient';
        } else {
          if ($ot == 1 && $request->order_repeat == 1) {
          } else {

            if ($client_bom_from == 'FromClient' || $client_bom_from == 'FromClient') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $order_id;
              $qcbomPObj->form_id = $fomr_id;
              $qcbomPObj->sub_order_index = $subOrder;
              $qcbomPObj->order_name = $request->brand;
              $qcbomPObj->order_cat = $bom_cat;
              $qcbomPObj->material_name = $bom;
              $qcBOMObj->bom_from = $client_bom_from;
              $qcbomPObj->qty = $bom_qty;
              $qcbomPObj->created_by = Auth::user()->id;
              $qcbomPObj->save();
            }
          }
        }
      }

      //save data to QC_BOM_Purchase:qc_bo_purchaselist
    }




    switch ($request->f_1) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_2) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_3) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_4) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------

    //-----------------------
    //-----------------------
    switch ($request->f_5) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_6) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_7) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_8) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_9) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------

    //STOP :save old bulk and private order

    // now check if order is bulk  start
    if ($ot == 1) {
      //$otStr='Private Label';
      if ($request->order_repeat == 2) {

        if ($request->printed_label == 'From Client' && $request->printed_box == 'From Client') {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 3;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          //Stop :save on stage


          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 3,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 4,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 0,
            ]
          );

          //Stop :save on stage


        } else {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();



          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 1,
            ]
          );

          //Stop :save on stage

        }
      } else {
        // Start :save on stage
        DB::table('st_process_action')->insert(
          [
            'ticket_id' => $fomr_id,

            'process_id' => 1,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Auto s Completed :DP:1',
            'attachment_id' => 0,
            'assigned_id' => Auth::user()->id,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
            'action_mark' => 0,
            'action_status' => 0,
          ]
        );
        //Stop :save on stage
      }
    } else {

      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();



      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );
      //Stop :save on stage


    }

    //save data

    //check order is bulk and repeat if yes then add to order master model
    $this->saveToOrderMaster($fomr_id, Auth::user()->id, $step_code_may, Auth::user()->id, $action_start);

    //if check then save BOM
    $artworkChK = DB::table('qc_forms')
      ->where('form_id', $fomr_id)
      ->where('artwork_approval_status', 1)
      ->first();
    $form_id = $fomr_id;
    //  if statge is first then save to bom
    if ($artworkChK != null) {

      $qcboms = QCBOM::where('form_id', $form_id)->whereNotNull('m_name')->get();
      foreach ($qcboms as $key => $qcbom) {
        if ($qcbom->bom_from != 'From Client') {
          $myqc_data = AyraHelp::getQCFormDate($form_id);
          if ($qcbom->bom_from == 'N/A' || $qcbom->bom_from == 'From Client' || $qcbom->bom_from == 'FromClient') {
          } else {
            $qcbomPObj = new QC_BOM_Purchase;
            $qcbomPObj->order_id = $myqc_data->order_id;
            $qcbomPObj->form_id = $form_id;
            $qcbomPObj->sub_order_index = $myqc_data->subOrder;
            $qcbomPObj->order_name = $myqc_data->brand_name;
            $qcbomPObj->order_cat = $qcbom->bom_cat;
            $qcbomPObj->material_name = $qcbom->m_name;
            $qcbomPObj->qty = $qcbom->qty;
            $qcbomPObj->created_by = Auth::user()->id;
            $qcbomPObj->save();
          }
        }
      }

      //update status of
      QCFORM::where('form_id', $form_id)
        ->update([
          'artwork_status' => 1
        ]);
      //now skpi purchase and set to art review

      //now skpi purchase and set to art review
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $form_id,
          'dependent_ticket_id' => 0,
          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto Update by checkbox',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );

      //now update stage name and stage id and since

      $data = AyraHelp::getProcessCurrentStage(1, $form_id);
      $Spname = $data->stage_name;
      $stage_id = $data->stage_id;
      $days_stayFrom = AyraHelp::getStayFromOrder($form_id);

      $affected = DB::table('qc_forms')
        ->where('form_id', $form_id)
        //->whereNull('curr_stage_id')
        ->update([
          'curr_stage_id' => $stage_id,
          'curr_stage_name' => $Spname,
          'curr_stage_updated_on' => $days_stayFrom
        ]);

      //now update stage name and 



    }
    //  if statge is first


    //if check then save BOM

    $res_arr = array(
      'order_id' => $order_id,
      'order_index' => $order_index,
      'subOrder' => $subOrder,
      'Message' => 'Item added  successfully ',
    );
    return response()->json($res_arr);
  }



  public function saveQCdata13Apr(Request $request)
  {


    //  print_r($request->all());
    //  die;
    //production_rmk_bulk

    $orderEntry = $request->orderEntry;
    if ($orderEntry == 'fresh') {
      $order_id = AyraHelp::getOrderCODE();
      $order_index = AyraHelp::getOrderCODEIndex();
      $subOrder = 1;
    } else {
      $rcorder_arr = QCFORM::where('order_id', $request->order_id)->get();
      $order_id = $request->order_id;
      $order_index = $request->txtOrderIndex;
      $subOrder = count($rcorder_arr) + 1;
    }
    // START:Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form

    if ($request->txtOrderTypeNew == 2) {

      $qcformObj = new QCFORM;
      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = $request->order_crated_by;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->qc_from_bulk = 1;
      $qcformObj->bulkOrderTypeV1 = $request->bulkOrderTypeV1;

      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_bulk_N);

      $qcformObj->item_sp = 0;


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';
      $otStr = 'Bulk';
      $qcformObj->order_type = 'Bulk';
      $qcformObj->order_type_v1 = $request->order_type_v1;
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk_bulk;
      $qcformObj->packeging_rmk = $request->packeging_rmk_bulk;


      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();
      $fomr_id = $qcformObj->id;

      $bsp = 0;
      $itemQty = 0;
      $qcBulkOrder_arr = $request->qcBulkOrder;
      $aj = 0;
      foreach ($qcBulkOrder_arr as $key => $boRow) {
        $aj++;
        $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $itemQty = $itemQty + $boRow['bulkItem_qty'];
        $qcbolkObj = new QCBULK_ORDER;
        $qcbolkObj->form_id = $fomr_id;
        $qcbolkObj->item_name = $boRow['bulk_material_name'];
        $qcbolkObj->qty = $boRow['bulkItem_qty'];
        $qcbolkObj->rate = $boRow['bulk_rate'];
        $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
        $qcbolkObj->packing = $boRow['bulk_packing'];
        $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $qcbolkObj->save();
      }


      QCFORM::where('form_id', $fomr_id)
        ->update(['bulk_order_value' => $bsp, 'item_qty' => $itemQty, 'bo_bulk_cound' => $aj++]);

      // olde stage
      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();


      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 1;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();

      //next assin
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'PRODUCTION';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 0;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();


      // olde stage


      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );

      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 9,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => 1,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 0,
        ]
      );

      //Stop :save on stage



      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );

      return response()->json($res_arr);
    }
    // STOP Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form
    //22 OCT 2019
    //START save old bulk and private order
    //save data
    $ot = $request->order_type;
    if ($ot == 1) {
      $otStr = 'Private Label';
    } else {
      $otStr = 'Bulk';
    }
    $qcformObj = new QCFORM;

    $qcformObj->order_id = $order_id;
    $qcformObj->order_index = $order_index;
    $qcformObj->subOrder = $subOrder;

    $qcformObj->client_id = $request->client_id;
    $qcformObj->created_by = $request->order_crated_by;
    $qcformObj->created_by_ori = Auth::user()->id;
    $qcformObj->brand_name = $request->brand;
    $qcformObj->subOrder = $subOrder;
    $qcformObj->yr = date('Y');
    $qcformObj->mo = date('m');
    $qcformObj->order_repeat = $request->order_repeat;
    $qcformObj->pre_order_id = $request->pre_orderno;
    $qcformObj->item_name = ucwords($request->item_name);
    $qcformObj->item_size = ucwords($request->item_size);
    $qcformObj->item_size_unit = ucwords($request->item_size_unit);

    $qcformObj->item_qty = $request->item_qty;
    $qcformObj->item_qty_unit = $request->item_qty_unit;
    $bomqty_aj = $request->item_qty;

    $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no_bulk_N);

    $qcformObj->item_sp = $request->item_selling_price;
    $qcformObj->item_sp_unit = $request->item_selling_UNIT;


    $qcformObj->design_client = '';
    $qcformObj->bottle_jar_client = '';
    $qcformObj->lable_client = '';

    $qcformObj->order_type = $otStr;
    $qcformObj->order_type_v1 = $request->order_type_v1;
    $qcformObj->due_date = $request->due_date;
    $qcformObj->commited_date = $request->commited_date;
    $qcformObj->production_rmk = $request->production_rmk;
    $qcformObj->packeging_rmk = $request->packeging_rmk;
    $qcformObj->export_domestic = $request->order_for;
    $qcformObj->order_currency = $request->currency;
    $qcformObj->exchange_rate = $request->conv_rate;
    $qcformObj->order_fragrance = $request->order_fragrance;
    $qcformObj->order_color = $request->order_color;
    $qcformObj->dispatch_status = 1;
    if ($otStr == 'Bulk' || $request->order_repea == 2) {
      $qcformObj->artwork_status = 1;
      $action_start = 1;
      $step_code_may = 'PRODUCTION';
    } else {
      if ($ot == 1 && $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
      } else {
        $qcformObj->artwork_status = 0;
      }

      $action_start = 0;
      $step_code_may = 'ART_WORK_REVIEW';
    }
    $qcformObj->artwork_start_date = date('Y-m-d');

    // new price 
    $qcformObj->item_RM_Price = $request->item_RM_Price;
    $qcformObj->item_BCJ_Price = $request->item_BCJ_Price;
    $qcformObj->item_Label_Price = $request->item_Label_Price;
    $qcformObj->item_Material_Price = $request->item_Material_Price;
    $qcformObj->item_LabourConversion_Price = $request->item_LabourConversion_Price;
    $qcformObj->item_Margin_Price = $request->item_Margin_Price;    // new price 
    $qcformObj->price_part_status = 1;    // new price 

    $qcformObj->save();

    $fomr_id = $qcformObj->id;


    //  form image upload
    if ($request->hasfile('fileAA')) {
      $file = $request->file('file');
      $img = Image::make($request->file('file'));
      // resize image instance
      $img->resize(320, 240);

      $extension = $file->getClientOriginalExtension(); // getting image extension
      $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
      // insert a watermark
      //$img->insert('public/watermark.png');
      // save image in desired format
      $img->save('uploads/qc_form/' . $filename);
      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
    }
    if ($request->hasfile('file')) {

      $filename = '';

      $file = $request->file('file');
      $filename =  rand(10, 100) . Auth::user()->id . "img" .  date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);


      QCFORM::where('form_id', $fomr_id)
        ->update(['pack_img_url' => 'local/public/uploads/photos/' . $filename]);
    }

    //  form image upload

    $qc_bom_arr = $request->qc;

    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Box';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_box;
    $qcBOMObj->bom_cat = 'BOX';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_box == 'Order') {
        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'BOX';
        $qcbomPObj->material_name = 'Printed Box';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }


    // if printed box and level is order


    $qcBOMObj = new QCBOM;
    $qcBOMObj->m_name = 'Printed Label';
    $qcBOMObj->qty = $request->item_qty;
    $qcBOMObj->bom_from = $request->printed_label;
    $qcBOMObj->bom_cat = 'LABEL';
    $qcBOMObj->size = '';
    $qcBOMObj->form_id = $fomr_id;
    $qcBOMObj->save();
    // if printed box and level is order
    if ($ot == 1 && $request->order_repeat == 1) {
    } else {
      if ($request->printed_label == 'Order') {

        $qcbomPObj = new QC_BOM_Purchase;
        $qcbomPObj->order_id = $order_id;
        $qcbomPObj->form_id = $fomr_id;
        $qcbomPObj->sub_order_index = $subOrder;
        $qcbomPObj->order_name = $request->brand;
        $qcbomPObj->order_cat = 'LABEL';
        $qcbomPObj->material_name = 'Printed Label';
        $qcbomPObj->qty = $bomqty_aj;
        $qcbomPObj->created_by = Auth::user()->id;
        $qcbomPObj->save();
      }
    }



    // if printed box and level is order





    foreach ($qc_bom_arr as $key => $value) {
      $bom = $value['bom'];
      $bom_qty = $value['bom_qty'];
      $bom_cat = $value['bom_cat'];

      if (isset($value['bom_from'])) {
        $client_bom_from = 'From Client';
      } else {
        $client_bom_from = '';
      }

      $bom_size = '';
      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = $bom;
      $qcBOMObj->qty = $bom_qty;
      $qcBOMObj->size = $bom_size;
      $qcBOMObj->bom_from = $client_bom_from;
      $qcBOMObj->bom_cat = $bom_cat;
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();



      //save data to QC_BOM_Purchase:qc_bo_purchaselist
      if (isset($bom)) {
        if (isset($value['bom_from'])) {
          // $client_bom_from='FromClient';
        } else {
          if ($ot == 1 && $request->order_repeat == 1) {
          } else {

            if ($client_bom_from == 'FromClient' || $client_bom_from == 'FromClient') {
            } else {
              $qcbomPObj = new QC_BOM_Purchase;
              $qcbomPObj->order_id = $order_id;
              $qcbomPObj->form_id = $fomr_id;
              $qcbomPObj->sub_order_index = $subOrder;
              $qcbomPObj->order_name = $request->brand;
              $qcbomPObj->order_cat = $bom_cat;
              $qcbomPObj->material_name = $bom;
              $qcBOMObj->bom_from = $client_bom_from;
              $qcbomPObj->qty = $bom_qty;
              $qcbomPObj->created_by = Auth::user()->id;
              $qcbomPObj->save();
            }
          }
        }
      }

      //save data to QC_BOM_Purchase:qc_bo_purchaselist
    }




    switch ($request->f_1) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'FILLING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    switch ($request->f_2) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SEAL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_3) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CAPPING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_4) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------

    //-----------------------
    //-----------------------
    switch ($request->f_5) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON LABEL';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_6) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'BOXING';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_7) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CODING ON BOX';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_8) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'SHRINK WRAP';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------
    //-----------------------
    switch ($request->f_9) {
      case 'YES':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = 'YES';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      case 'NO':
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = 'NO';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
        break;
      default:
        $qcPPObj = new QCPP;
        $qcPPObj->qc_label = 'CARTONIZE';
        $qcPPObj->qc_yes = '';
        $qcPPObj->qc_no = '';
        $qcPPObj->qc_from_id = $fomr_id;
        $qcPPObj->save();
    }
    //-----------------------

    //STOP :save old bulk and private order

    // now check if order is bulk  start
    if ($ot == 1) {
      //$otStr='Private Label';
      if ($request->order_repeat == 2) {

        if ($request->printed_label == 'From Client' && $request->printed_box == 'From Client') {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 3;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();

          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          //Stop :save on stage


          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 3,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
            ]
          );
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 4,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => 1,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 0,
            ]
          );

          //Stop :save on stage


        } else {
          $opdObj = new OPData;
          $opdObj->order_id_form_id = $fomr_id; //formid and order id
          $opdObj->step_id = 1;
          $opdObj->expected_date = date('Y-m-d');
          $opdObj->remaks = 'Order starts as added order';
          $opdObj->created_by = Auth::user()->id;
          $opdObj->assign_userid = Auth::user()->id;
          $opdObj->status = 1;
          $opdObj->step_status = 0;
          $opdObj->color_code = 'completed';
          $opdObj->diff_data = '1 second before';
          $opdObj->save();



          // Start :save on stage
          DB::table('st_process_action')->insert(
            [
              'ticket_id' => $fomr_id,

              'process_id' => 1,
              'stage_id' => 1,
              'action_on' => 1,
              'created_at' => date('Y-m-d H:i:s'),
              'expected_date' => date('Y-m-d H:i:s'),
              'remarks' => 'Auto s Completed :DP:1',
              'attachment_id' => 0,
              'assigned_id' => Auth::user()->id,
              'undo_status' => 1,
              'updated_by' => Auth::user()->id,
              'created_status' => 1,
              'completed_by' => Auth::user()->id,
              'statge_color' => 'completed',
              'action_mark' => 0,
              'action_status' => 1,
            ]
          );

          //Stop :save on stage

        }
      } else {
        // Start :save on stage
        DB::table('st_process_action')->insert(
          [
            'ticket_id' => $fomr_id,

            'process_id' => 1,
            'stage_id' => 1,
            'action_on' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'expected_date' => date('Y-m-d H:i:s'),
            'remarks' => 'Auto s Completed :DP:1',
            'attachment_id' => 0,
            'assigned_id' => Auth::user()->id,
            'undo_status' => 1,
            'updated_by' => Auth::user()->id,
            'created_status' => 1,
            'completed_by' => Auth::user()->id,
            'statge_color' => 'completed',
            'action_mark' => 0,
            'action_status' => 0,
          ]
        );
        //Stop :save on stage
      }
    } else {

      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();



      // Start :save on stage
      DB::table('st_process_action')->insert(
        [
          'ticket_id' => $fomr_id,

          'process_id' => 1,
          'stage_id' => 1,
          'action_on' => 1,
          'created_at' => date('Y-m-d H:i:s'),
          'expected_date' => date('Y-m-d H:i:s'),
          'remarks' => 'Auto s Completed :DP:1',
          'attachment_id' => 0,
          'assigned_id' => Auth::user()->id,
          'undo_status' => 1,
          'updated_by' => Auth::user()->id,
          'created_status' => 1,
          'completed_by' => Auth::user()->id,
          'statge_color' => 'completed',
          'action_mark' => 0,
          'action_status' => 1,
        ]
      );
      //Stop :save on stage


    }

    //save data

    //check order is bulk and repeat if yes then add to order master model
    $this->saveToOrderMaster($fomr_id, Auth::user()->id, $step_code_may, Auth::user()->id, $action_start);

    $res_arr = array(
      'order_id' => $order_id,
      'order_index' => $order_index,
      'subOrder' => $subOrder,
      'Message' => 'Item added  successfully ',
    );
    return response()->json($res_arr);
  }
  public function saveQCdata_22OCT(Request $request)
  {



    $orderEntry = $request->orderEntry;
    if ($orderEntry == 'fresh') {
      $order_id = AyraHelp::getOrderCODE();
      $order_index = AyraHelp::getOrderCODEIndex();
      $subOrder = 1;
    } else {
      $rcorder_arr = QCFORM::where('order_id', $request->order_id)->get();
      $order_id = $request->order_id;
      $order_index = $request->txtOrderIndex;
      $subOrder = count($rcorder_arr) + 1;
    }
    //Update code :V1: 2019-07-19 //this code for save all data in qc form as well as bulk form
    if ($request->txtOrderTypeNew == 2) {
      // save data qcform
      $qcformObj = new QCFORM;
      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = $request->order_crated_by;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->qc_from_bulk = 1;


      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no);

      $qcformObj->item_sp = 0;
      // $qcformObj->item_sp_unit='';


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';
      $otStr = 'Bulk';
      $qcformObj->order_type = 'Bulk';
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk;
      $qcformObj->packeging_rmk = $request->packeging_rmk;

      // $qcformObj->export_domestic=$request->order_for;
      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repeat == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();
      $fomr_id = $qcformObj->id;

      $bsp = 0;
      $itemQty = 0;
      $qcBulkOrder_arr = $request->qcBulkOrder;
      foreach ($qcBulkOrder_arr as $key => $boRow) {
        $bsp = $bsp + ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $itemQty = $itemQty + $boRow['bulkItem_qty'];

        $qcbolkObj = new QCBULK_ORDER;
        $qcbolkObj->form_id = $fomr_id;
        $qcbolkObj->item_name = $boRow['bulk_material_name'];
        $qcbolkObj->qty = $boRow['bulkItem_qty'];
        $qcbolkObj->rate = $boRow['bulk_rate'];
        $qcbolkObj->item_size = $boRow['bulk_sizeUnit'];
        $qcbolkObj->packing = $boRow['bulk_packing'];
        $qcbolkObj->item_sell_p = ($boRow['bulk_rate']) * ($boRow['bulkItem_qty']);
        $qcbolkObj->save();
      }

      QCFORM::where('form_id', $fomr_id)
        ->update(['bulk_order_value' => $bsp, 'item_qty' => $itemQty]);


      $opdObj = new OPData;
      $opdObj->order_id_form_id = $fomr_id; //formid and order id
      $opdObj->step_id = 1;
      $opdObj->expected_date = date('Y-m-d');
      $opdObj->remaks = 'Order starts as added order';
      $opdObj->created_by = Auth::user()->id;
      $opdObj->assign_userid = Auth::user()->id;
      $opdObj->status = 1;
      $opdObj->step_status = 0;
      $opdObj->color_code = 'completed';
      $opdObj->diff_data = '1 second before';
      $opdObj->save();


      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 1;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();

      //next assin
      $mstOrderObj = new OrderMaster;
      $mstOrderObj->form_id = $fomr_id;
      $mstOrderObj->assign_userid = 0;
      $mstOrderObj->order_statge_id = 'PRODUCTION';
      $mstOrderObj->assigned_by = Auth::user()->id;
      $mstOrderObj->action_status = 0;
      $mstOrderObj->completed_on = date('Y-m-d');
      $mstOrderObj->action_mark = 1;
      $mstOrderObj->assigned_team = 1; //sales user
      $mstOrderObj->save();


      // save data qcform


      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );
    } else {    //Update code :V1: 2019-07-19 // also make auto start and assign to next too stages



      //save data
      $ot = $request->order_type;
      if ($ot == 1) {
        $otStr = 'Private Label';
      } else {
        $otStr = 'Bulk';
      }
      $qcformObj = new QCFORM;

      $qcformObj->order_id = $order_id;
      $qcformObj->order_index = $order_index;
      $qcformObj->subOrder = $subOrder;

      $qcformObj->client_id = $request->client_id;
      $qcformObj->created_by = $request->order_crated_by;
      $qcformObj->brand_name = $request->brand;
      $qcformObj->subOrder = $subOrder;
      $qcformObj->yr = date('Y');
      $qcformObj->mo = date('m');
      $qcformObj->order_repeat = $request->order_repeat;
      $qcformObj->pre_order_id = $request->pre_orderno;
      $qcformObj->item_name = ucwords($request->item_name);
      $qcformObj->item_size = ucwords($request->item_size);
      $qcformObj->item_size_unit = ucwords($request->item_size_unit);

      $qcformObj->item_qty = $request->item_qty;
      $qcformObj->item_qty_unit = $request->item_qty_unit;
      $bomqty_aj = $request->item_qty;

      $qcformObj->item_fm_sample_no = ucwords($request->item_fm_sample_no);

      $qcformObj->item_sp = $request->item_selling_price;
      $qcformObj->item_sp_unit = $request->item_selling_UNIT;


      $qcformObj->design_client = '';
      $qcformObj->bottle_jar_client = '';
      $qcformObj->lable_client = '';

      $qcformObj->order_type = $otStr;
      $qcformObj->due_date = $request->due_date;
      $qcformObj->commited_date = $request->commited_date;

      $qcformObj->production_rmk = $request->production_rmk;
      $qcformObj->packeging_rmk = $request->packeging_rmk;

      $qcformObj->export_domestic = $request->order_for;
      $qcformObj->order_currency = $request->currency;
      $qcformObj->exchange_rate = $request->conv_rate;
      $qcformObj->order_fragrance = $request->order_fragrance;
      $qcformObj->order_color = $request->order_color;
      $qcformObj->dispatch_status = 1;
      if ($otStr == 'Bulk' || $request->order_repea == 2) {
        $qcformObj->artwork_status = 1;
        $action_start = 1;
        $step_code_may = 'PRODUCTION';
      } else {
        if ($ot == 1 && $request->order_repeat == 2) {
          $qcformObj->artwork_status = 1;
        } else {
          $qcformObj->artwork_status = 0;
        }

        $action_start = 0;
        $step_code_may = 'ART_WORK_REVIEW';
      }
      $qcformObj->artwork_start_date = date('Y-m-d');
      $qcformObj->save();

      $fomr_id = $qcformObj->id;


      //  form image upload
      if ($request->hasfile('file')) {
        $file = $request->file('file');
        $img = Image::make($request->file('file'));
        // resize image instance
        $img->resize(320, 240);

        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename = rand(10, 100) . Auth::user()->id . "img" . date('Ymdhis') . '.' . $extension;
        // insert a watermark
        //$img->insert('public/watermark.png');
        // save image in desired format
        $img->save('uploads/qc_form/' . $filename);
        QCFORM::where('form_id', $fomr_id)
          ->update(['pack_img_url' => 'uploads/qc_form/' . $filename]);
      }
      //  form image upload

      $qc_bom_arr = $request->qc;

      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Box';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_box;
      $qcBOMObj->bom_cat = 'BOX';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();
      // if printed box and level is order
      if ($ot == 1 && $request->order_repeat == 1) {
      } else {
        if ($request->printed_box == 'Order') {
          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $order_id;
          $qcbomPObj->form_id = $fomr_id;
          $qcbomPObj->sub_order_index = $subOrder;
          $qcbomPObj->order_name = $request->brand;
          $qcbomPObj->order_cat = 'BOX';
          $qcbomPObj->material_name = 'Printed Box';
          $qcbomPObj->qty = $bomqty_aj;
          $qcbomPObj->created_by = Auth::user()->id;
          $qcbomPObj->save();
        }
      }


      // if printed box and level is order


      $qcBOMObj = new QCBOM;
      $qcBOMObj->m_name = 'Printed Label';
      $qcBOMObj->qty = $request->item_qty;
      $qcBOMObj->bom_from = $request->printed_label;
      $qcBOMObj->bom_cat = 'LABEL';
      $qcBOMObj->size = '';
      $qcBOMObj->form_id = $fomr_id;
      $qcBOMObj->save();
      // if printed box and level is order
      if ($ot == 1 && $request->order_repeat == 1) {
      } else {
        if ($request->printed_label == 'Order') {

          $qcbomPObj = new QC_BOM_Purchase;
          $qcbomPObj->order_id = $order_id;
          $qcbomPObj->form_id = $fomr_id;
          $qcbomPObj->sub_order_index = $subOrder;
          $qcbomPObj->order_name = $request->brand;
          $qcbomPObj->order_cat = 'LABEL';
          $qcbomPObj->material_name = 'Printed Label';
          $qcbomPObj->qty = $bomqty_aj;
          $qcbomPObj->created_by = Auth::user()->id;
          $qcbomPObj->save();
        }
      }



      // if printed box and level is order





      foreach ($qc_bom_arr as $key => $value) {
        $bom = $value['bom'];
        $bom_qty = $value['bom_qty'];
        $bom_cat = $value['bom_cat'];

        if (isset($value['bom_from'])) {
          $client_bom_from = 'From Client';
        } else {
          $client_bom_from = '';
        }

        $bom_size = '';
        $qcBOMObj = new QCBOM;
        $qcBOMObj->m_name = $bom;
        $qcBOMObj->qty = $bom_qty;
        $qcBOMObj->size = $bom_size;
        $qcBOMObj->bom_from = $client_bom_from;
        $qcBOMObj->bom_cat = $bom_cat;
        $qcBOMObj->form_id = $fomr_id;
        $qcBOMObj->save();



        //save data to QC_BOM_Purchase:qc_bo_purchaselist
        if (isset($bom)) {
          if (isset($value['bom_from'])) {
            // $client_bom_from='FromClient';
          } else {
            if ($ot == 1 && $request->order_repeat == 1) {
            } else {

              if ($client_bom_from == 'FromClient' || $client_bom_from == 'FromClient') {
              } else {
                $qcbomPObj = new QC_BOM_Purchase;
                $qcbomPObj->order_id = $order_id;
                $qcbomPObj->form_id = $fomr_id;
                $qcbomPObj->sub_order_index = $subOrder;
                $qcbomPObj->order_name = $request->brand;
                $qcbomPObj->order_cat = $bom_cat;
                $qcbomPObj->material_name = $bom;
                $qcBOMObj->bom_from = $client_bom_from;
                $qcbomPObj->qty = $bom_qty;
                $qcbomPObj->created_by = Auth::user()->id;
                $qcbomPObj->save();
              }
            }
          }
        }

        //save data to QC_BOM_Purchase:qc_bo_purchaselist
      }




      switch ($request->f_1) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'FILLING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      switch ($request->f_2) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SEAL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_3) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CAPPING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_4) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------

      //-----------------------
      //-----------------------
      switch ($request->f_5) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON LABEL';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_6) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'BOXING';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_7) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CODING ON BOX';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_8) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'SHRINK WRAP';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------
      //-----------------------
      switch ($request->f_9) {
        case 'YES':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = 'YES';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        case 'NO':
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = 'NO';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
          break;
        default:
          $qcPPObj = new QCPP;
          $qcPPObj->qc_label = 'CARTONIZE';
          $qcPPObj->qc_yes = '';
          $qcPPObj->qc_no = '';
          $qcPPObj->qc_from_id = $fomr_id;
          $qcPPObj->save();
      }
      //-----------------------


      // now check if order is bulk  start
      if ($ot == 1) {
        //$otStr='Private Label';
        if ($request->order_repeat == 2) {

          if ($request->printed_label == 'From Client' && $request->printed_box == 'From Client') {
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 1;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();

            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 3;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();
          } else {
            $opdObj = new OPData;
            $opdObj->order_id_form_id = $fomr_id; //formid and order id
            $opdObj->step_id = 1;
            $opdObj->expected_date = date('Y-m-d');
            $opdObj->remaks = 'Order starts as added order';
            $opdObj->created_by = Auth::user()->id;
            $opdObj->assign_userid = Auth::user()->id;
            $opdObj->status = 1;
            $opdObj->step_status = 0;
            $opdObj->color_code = 'completed';
            $opdObj->diff_data = '1 second before';
            $opdObj->save();
          }
        }
      } else {

        $opdObj = new OPData;
        $opdObj->order_id_form_id = $fomr_id; //formid and order id
        $opdObj->step_id = 1;
        $opdObj->expected_date = date('Y-m-d');
        $opdObj->remaks = 'Order starts as added order';
        $opdObj->created_by = Auth::user()->id;
        $opdObj->assign_userid = Auth::user()->id;
        $opdObj->status = 1;
        $opdObj->step_status = 0;
        $opdObj->color_code = 'completed';
        $opdObj->diff_data = '1 second before';
        $opdObj->save();
      }

      //save data

      //check order is bulk and repeat if yes then add to order master model
      $this->saveToOrderMaster($fomr_id, Auth::user()->id, $step_code_may, Auth::user()->id, $action_start);

      $res_arr = array(
        'order_id' => $order_id,
        'order_index' => $order_index,
        'subOrder' => $subOrder,
        'Message' => 'Item added  successfully ',
      );
    }

    return response()->json($res_arr);
  }
  // qcformStoreMember
  public function qcformStoreMember()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('sample.qc_create', $data)->render();
  }


  // qcformStoreMember

  public function qcformStore()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => ''
    ];
    return $theme->scope('sample.qc_create', $data)->render();
  }

  public function print_QCFORM_BULK($id)
  {

    $qcform_arr = QCFORM::where('form_id', $id)->first();
    $qcpp_arr = QCPP::where('qc_from_id', $qcform_arr->form_id)->get();
    $qcbom_arr = QCBOM::where('form_id', $qcform_arr->form_id)->get();
    $qcbulk_arr = QCBULK_ORDER::where('form_id', $qcform_arr->form_id)->get();

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => $qcform_arr,
      'qc_pp' => $qcpp_arr,
      'qc_bom' => $qcbom_arr,
      'qc_bulkorder' => $qcbulk_arr,

    ];
    return $theme->scope('sample.qc_print_bulk', $data)->render();
  }


  public function print_QCFORM($id)
  {

    $qcform_arr = QCFORM::where('form_id', $id)->first();
    // print_r($qcform_arr);

    $qcpp_arr = QCPP::where('qc_from_id', $qcform_arr->form_id)->get();
    $qcbom_arr = QCBOM::where('form_id', $qcform_arr->form_id)->get();
    //print_r($qcform_arr);
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'qc_data' => $qcform_arr,
      'qc_pp' => $qcpp_arr,
      'qc_bom' => $qcbom_arr,

    ];
    return $theme->scope('sample.qc_print', $data)->render();
  }


  /*
|--------------------------------------------------------------------------
| function name:saveOrderItemsAddmore
|--------------------------------------------------------------------------
| this function is used to save extra items of order
*/
  public function saveOrderItemsAddmore(Request $request)
  {
    $max_id = OrderItem::where('order_index', $request->txtOrderID)->max('sub_index') + 1;

    $ordeerObj = new OrderItem;
    $ordeerObj->item_name = $request->txtItemName;
    $ordeerObj->item_qty = $request->txtItemQTY;
    $ordeerObj->order_index = $request->txtOrderID;
    $ordeerObj->sub_index = $max_id;
    $ordeerObj->item_size = $request->txtSize;
    $ordeerObj->sample_id = $request->txtSampleId;
    $ordeerObj->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Item added  successfully ',
    );
    return response()->json($res_arr);
  }


  /*
|--------------------------------------------------------------------------
| function name:getPurchaseReservedList
|--------------------------------------------------------------------------
| this function is used to show list of purchase and reserved
*/
  public function getPurchaseReservedList(Request $request)
  {
    $clientOrderItemMat_arr = OrderItemMaterial::where('confirm_status', 2)->where('req_status', 1)->where('purchase_reserved_status', 1)->get();
    foreach ($clientOrderItemMat_arr as $key => $value) {
    }
    $data_arr_1 = array();
    $data_arr_2 = array();
    $data_arr_3 = array();

    foreach ($clientOrderItemMat_arr as $key => $value) {
      $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $items_stock = AyraHelp::getStockBYItemID($value->item_id);
      $created_by = AyraHelp::getUserName($value->added_by);
      $orderItem_arr = AyraHelp::getRESPUR($value->id);
      $order_index = $value->order_index;
      $order_Arr = Order::where('order_index', $order_index)->first();

      $order_ArrData = OrderItem::where('id', $value->order_item_id)->first();

      if ($orderItem_arr->req_status == 1) {
        if ($value->m_qty < $items_stock->qty) {
          $rp_status = 1; //available
          $data_arr_1[] = array(
            'RecordID' => $value->id,
            'order_id' => $order_Arr->pri_order_id,
            'sub_order_id' => $order_ArrData->sub_order_id,
            'item_code' => $value->item_id,
            'item_name' => $items_arr->item_name,
            'req_qty' => $value->m_qty,
            'stock_in' => $items_stock->qty,
            'created_by' => $created_by,
            'Status' => $rp_status,
            'Actions' => ""
          );
        }
      }
    }
    //check material confirm =2 req_status =2 and not exits in reserved table
    $OrderItemMat_arr_data = OrderItemMaterial::where('confirm_status', 2)->where('req_status', 2)->where('purchase_reserved_status', 1)->get();


    foreach ($OrderItemMat_arr_data as $key => $value) {
      $order_index = $value->order_index;
      $isresrve = ItemStockReserved::where('order_id', $order_index)->first();
      if ($isresrve == null) {
        // echo "not exits";
        $req_qty = $value->m_qty;
        $item_id = $value->item_id;
        $item_stock_arr = ItemStock::where('item_id', $item_id)->first();
        $stock_qty = $item_stock_arr->qty;


        if ($stock_qty >= $req_qty) {
          $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
          $order_Arr = Order::where('order_index', $order_index)->first();

          $order_ArrData = OrderItem::where('id', $value->order_item_id)->first();
          $created_by = AyraHelp::getUserName($value->added_by);
          $rp_status = 1; //available
          $data_arr_2[] = array(
            'RecordID' => $value->id,
            'order_id' => $order_Arr->pri_order_id,
            'sub_order_id' => $order_ArrData->sub_order_id,
            'item_code' => $value->item_id,
            'item_name' => $items_arr->item_name,
            'req_qty' => $value->m_qty,
            'stock_in' => $stock_qty,
            'created_by' => $created_by,
            'Status' => $rp_status,
            'Actions' => ""
          );
        }
      }
    }



    $data_arr = array_merge($data_arr_1, $data_arr_2);

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'sub_order_id'      => true,
      'item_code'      => true,
      'item_name'      => true,
      'req_qty' => true,
      'item_qty'  => true,
      'stock_in'      => true,
      'created_by'      => true,
      'Status'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
    //  echo "<pre>";
    //  print_r($clientOrderItemMat_arr);
    //  die;

  }


  //==============================================
  public function getPurchaseReservedList__(Request $request)
  {
    //get data from item stock reserved
    //get data from purchased item requested
    //we have to show list of BIM items with status and action too
    $clientOrderItemMat_arr = OrderItemMaterial::where('confirm_status', 2)->where('req_status', 1)->get();
    $data_arr_1 = array();
    $data_arr_2 = array();
    $data_arr_3 = array();

    foreach ($clientOrderItemMat_arr as $key => $value) {

      $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $items_stock = AyraHelp::getStockBYItemID($value->item_id);
      $created_by = AyraHelp::getUserName($value->added_by);
      $orderItem_arr = AyraHelp::getRESPUR($value->id);
      //get order id
      $order_item_id = $value->order_item_id;
      $orderItemData = OrderItem::where('order_index', $order_item_id)->first();


      $order_Arr = Order::where('order_index', $order_item_id)->first();


      //get order id
      if ($orderItem_arr->req_status == 1) {
        if ($value->m_qty < $items_stock->qty) {
          $rp_status = 1; //available
        } else {
          $rp_status = 1; //out of stock
        }
      }


      $data_arr_1[] = array(
        'RecordID' => $value->id,
        'order_id' => $order_Arr,
        'item_code' => $value->item_id,
        'item_name' => $items_arr->item_name,
        'req_qty' => $value->m_qty,
        'stock_in' => $items_stock->qty,
        'created_by' => $created_by,
        'Status' => $rp_status,
        'Actions' => ""
      );
    }
    //get data from item stock reserved
    $clientOrderItemMat_arr = ItemStockReserved::where('status', 2)->where('issue_status', 1)->get();

    foreach ($clientOrderItemMat_arr as $key => $value) {

      $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $items_stock = AyraHelp::getStockBYItemID($value->item_id);
      $created_by = AyraHelp::getUserName($value->created_by);
      $orderItem_arr = AyraHelp::getRESPUR($value->id);

      if ($value->status == 2) {
        $rp_status = 3; //reserved requesred
      }



      $data_arr_2[] = array(
        'RecordID' => $value->id,
        'order_id' => $value->id,
        'item_code' => $value->item_id,
        'item_name' => $value->item_name,
        'req_qty' => $value->qty,
        'stock_in' => $items_stock->qty,
        'created_by' => $created_by,
        'Status' => $rp_status,
        'Actions' => ""
      );
    }
    //we have to show list of BIM items with status and action too
    $clientOrderItemMat_arr = PurchaseItemRequested::get();

    foreach ($clientOrderItemMat_arr as $key => $value) {

      $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $items_stock = AyraHelp::getStockBYItemID($value->item_id);
      $created_by = AyraHelp::getUserName($value->created_by);
      $orderItem_arr = AyraHelp::getRESPUR($value->id);

      if ($value->status == 2) {
        $rp_status = 4; // purchase requesred
      }
      if ($value->status == 1) {
        $rp_status = 5; //ordered
      }
      if ($value->status == 3) {
        $rp_status = 6; //ordered recived
      }



      $data_arr_3[] = array(
        'RecordID' => $value->id,
        'order_id' => $value->id,
        'item_code' => $value->item_id,
        'item_name' => $value->item_name,
        'req_qty' => $value->qty,
        'stock_in' => $items_stock->qty,
        'created_by' => $created_by,
        'Status' => $rp_status,
        'Actions' => ""
      );
    }

    $data_arr = array_merge($data_arr_1, $data_arr_2);

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'item_code'      => true,
      'item_name'      => true,
      'req_qty' => true,
      'item_qty'  => true,
      'stock_in'      => true,
      'created_by'      => true,
      'Status'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function getPurchaseReservedList_(Request $request)
  {
    $clientOrderItemMat_arr = OrderItemMaterial::where('confirm_status', 2)->get();


    $data_arr = array();
    foreach ($clientOrderItemMat_arr as $key => $value) {

      $items_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $items_stock = AyraHelp::getStockBYItemID($value->item_id);
      $created_by = AyraHelp::getUserName($value->added_by);
      $orderItem_arr = AyraHelp::getRESPUR($value->id);

      if ($orderItem_arr->req_status == 1) {
        if ($value->m_qty < $items_stock->qty) {
          $rp_status = 1; //available
        } else {
          $rp_status = 2; //out of stock
        }
      } else {
        $rp_status = 3; //Requested  either purchase or reserved
      }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => 1,
        'item_code' => $value->item_id,
        'item_name' => $items_arr->item_name,
        'req_qty' => $value->m_qty,
        'stock_in' => $items_stock->qty,
        'created_by' => $created_by,
        'Status' => $rp_status,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'item_code'      => true,
      'item_name'      => true,
      'req_qty' => true,
      'item_qty'  => true,
      'stock_in'      => true,
      'created_by'      => true,
      'Status'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  /*
|--------------------------------------------------------------------------
| function name:purchaseReserved
|--------------------------------------------------------------------------
| this function is used to show list of purchase and reserved
*/
  public function purchaseReserved(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'data' > ''
    ];
    return $theme->scope('orders.purchase_reserved_list', $data)->render();
  }



  /*
|--------------------------------------------------------------------------
| function name:deleteBOMItems
|--------------------------------------------------------------------------
| this function is used to delete BOMItems
*/

  public function deleteBOMItems(Request $request)
  {
    $order_id = $request->order_id;
    $orerItemMArr = OrderItemMaterial::where('id', $order_id)->first();
    $order_item_id = $orerItemMArr->order_item_id;
    $item_id = $orerItemMArr->item_id;
    $orerItemMArr->confirm_status;

    if ($orerItemMArr->confirm_status == 1) {


      $orderItem = OrderItemMaterial::find($order_id);
      $orderItem->delete();
      $res_arr = array(
        'status' => 1,
        'Message' => 'deleted successfully ',
      );
    } else {
      $res_arr = array(
        'status' => 0,
        'Message' => 'can not delete',
      );
    }


    return response()->json($res_arr);
  }

  /*
|--------------------------------------------------------------------------
| function name:BOMConfirmation
|--------------------------------------------------------------------------
| this function is used to request for purchase
*/

  public function BOMConfirmation(Request $request)
  {
    $order_item_id = $request->order_item_id;

    OrderItemMaterial::where('order_item_id', $order_item_id)
      ->update(['confirm_status' => 2]); //lock to edit only admin can do it

    $check_order_arr = OrderItem::where('id', $order_item_id)->first(); //get the order index  generate  primary order id
    if ($check_order_arr != null) {

      OrderItem::where('order_index', $check_order_arr->order_index)
        ->update(['bom_status' => 2]);

      $order_index = $check_order_arr->order_index;
      $order_arr = Order::where('order_index', $order_index)->first();

      if (empty($order_arr->pri_order_id)) {
        //echo "EMPTY"; then generte order pri ID;
        $max_id = Order::max('order_index');
        $num = $order_index;
        $str_length = 4;
        $PriOrderID = "O#" . substr("0000{$num}", -$str_length);
        Order::where('order_index', $order_index)
          ->update(['pri_order_id' => $PriOrderID, 'status' => 2]); //2=new status

        // $suborder_id=$PriOrderID."/".$order_item_id;
        // OrderItem::where('id',$order_item_id)
        // ->update(['sub_order_id' => $suborder_id]);
        $orderItem_arr = OrderItem::where('order_index', $order_index)->get();
        foreach ($orderItem_arr as $key => $orderItem) {
          $suborder_id = $PriOrderID . "/" . $orderItem->sub_index;
          OrderItem::where('id', $orderItem->id)
            ->update(['sub_order_id' => $suborder_id]);
        }
      } else {
        $PriOrderID = $order_arr->pri_order_id;

        //  $suborder_id=$PriOrderID."/".$order_item_id;
        //       OrderItem::where('id',$order_item_id)
        //       ->update(['sub_order_id' => $suborder_id]);
        $orderItem_arr = OrderItem::where('order_index', $order_index)->get();
        foreach ($orderItem_arr as $key => $orderItem) {
          $suborder_id = $PriOrderID . "/" . $orderItem->sub_index;
          OrderItem::where('id', $orderItem->id)
            ->update(['sub_order_id' => $suborder_id]);
        }

        //get the order id
        // and update item sub order

      }
    }

    //now save data to
    //purchased_items_request :PurchaseItemRequested
    //purchased_items_group:PurchaseItemGroup
    $orderIM_Arr_data = OrderItemMaterial::where('order_item_id', $order_item_id)->get();
    foreach ($orderIM_Arr_data as $key => $orderIM_Arr) {
      $R_qty = $orderIM_Arr->m_qty;
      $R_item_id = $orderIM_Arr->item_id;
      $item_stock_arr = ItemStock::where('item_id', $R_item_id)->first();


      //------------------A
      //if check
      if ($R_qty >= $item_stock_arr->qty) {
        // echo "need to purchade";
        OrderItemMaterial::where('order_item_id', $order_item_id)
          ->update(['req_status' => 2]); //make is request defaut too

        $order_index = $orderIM_Arr->order_index;
        $itemALL = AyraHelp::getItemsbyItemID($orderIM_Arr->item_id);
        $orderArr = Order::where('id', $order_index)->first();
        $purobj = new PurchaseItemRequested;
        $purobj->order_id = $orderArr->pri_order_id;
        $purobj->item_id = $orderIM_Arr->item_id;
        $purobj->item_name = $itemALL->item_name;
        $purobj->qty = $orderIM_Arr->m_qty;
        $purobj->qty_unit = '';
        $purobj->created_by = Auth::user()->id;
        $purobj->status = 2;
        $purobj->save();
      } else {
        // echo "Its Ok  availabe";
      }

      //-------------------A-

    }








    $res_arr = array(
      'status' => 1,
      'Message' => 'Confirmation successfully submitted.',
    );
    return response()->json($res_arr);
  }

  public function BOMConfirmation_(Request $request)
  {
    $order_item_id = $request->order_item_id;

    OrderItemMaterial::where('order_item_id', $order_item_id)
      ->update(['confirm_status' => 2]);

    $check_order_arr = OrderItem::where('id', $order_item_id)->first(); //get the order index  generate  primary order id
    if ($check_order_arr != null) {
      OrderItem::where('id', $order_item_id)
        ->update(['bom_status' => 2]);

      $order_index = $check_order_arr->order_index;
      $order_arr = Order::where('order_index', $order_index)->first();

      if (empty($order_arr->pri_order_id)) {
        //echo "EMPTY"; then generte order pri ID;
        $max_id = Order::max('order_index');
        $num = $order_index;
        $str_length = 4;
        $PriOrderID = "O#" . substr("0000{$num}", -$str_length);
        Order::where('order_index', $order_index)
          ->update(['pri_order_id' => $PriOrderID]);
      } else {
      }
    }

    $res_arr = array(
      'status' => 1,
      'Message' => 'Confirmation successfully submitted.',
    );
    return response()->json($res_arr);
  }


  /*
|--------------------------------------------------------------------------
| function name:deleteOrderNow
|--------------------------------------------------------------------------
| this function is used to request for purchase
*/
  public function deleteOrderNow(Request $request)
  {
    //need bussiness logic for if order is cancel and delete then what will be .
    echo "need bussiness logic";
  }

  /*
|--------------------------------------------------------------------------
| function name:saveItemName
|--------------------------------------------------------------------------
| this function is used to request  for purchase
*/
  public function saveItemName(Request $request)
  {

    $stock_check = Item::where('cat_id', '=', $request->cat_id)->where('item_name', '=', $request->item_name)->first();
    if ($stock_check === null) {
      $item_idcreated = "BOI-" . date('yis');
      $obje = new Item;
      $obje->cat_id = $request->cat_id;
      $obje->item_id = $item_idcreated;
      $obje->item_name = $request->item_name;
      $obje->item_short_name = '';
      $obje->item_discription = '';
      $obje->created_by = 1;
      $obje->save();
      //save this item to stock

      $objes = new ItemStock;
      $objes->item_id = $item_idcreated;
      $objes->qty = 0;
      $objes->save();
    }
  }
  /*
|--------------------------------------------------------------------------
| function name:saveCateory
|--------------------------------------------------------------------------
| this function is used to request  for purchase
*/
  public function saveCateory(Request $request)
  {
    $max_id = ItemCat::max('cat_index') + 1;

    $num = $max_id;
    $str_length = 4;
    $catID = "BO-ICAT-" . substr("0000{$num}", -$str_length);


    $stock_check = ItemCat::where('cat_name', '=', $request->category)->first();
    if ($stock_check === null) {
      $obje = new ItemCat;
      $obje->cat_name = $request->category;
      $obje->cat_id = $catID;
      $obje->created_by = Auth::user()->id;
      $obje->cat_index = $max_id;

      $obje->save();
    }
    $item_arr = ItemCat::get();
    $html = "";
    foreach ($item_arr as $items) {
      $html .= '<option value="' . $items->cat_id . '">' . $items->cat_name . '</option>';
    }
    echo $html;
  }
  /*

|--------------------------------------------------------------------------
| function name:purchaseItemforStock
|--------------------------------------------------------------------------
| this function is used to request  for purchase
*/
  public function purchaseItemforStock(Request $request)
  {
    $rowid = $request->rowid;
    $orderItemM_arr = OrderItemMaterial::where('id', $rowid)->first();
    //update req_status =2 //beacuse it show that requested for reserved and stock qty decrser now .
    OrderItemMaterial::where('id', $rowid)->update([
      'req_status' => 2
    ]);

    //now save data to Purchase Item Request
    $item_arr =  AyraHelp::getItemsbyItemID($orderItemM_arr->item_id);
    $item_id = $orderItemM_arr->item_id;
    $isr = new PurchaseItemRequested;
    $isr->order_id = $orderItemM_arr->order_item_id;
    $isr->item_id = $orderItemM_arr->item_id;
    $isr->item_name = $item_arr->item_name;
    $isr->qty = $orderItemM_arr->m_qty;
    $isr->created_by = Auth::user()->id;
    $isr->status = 2;
    $isr->save();

    //  now save data for group entry that is consolidated
    $purchase_entrycheck = PurchaseItemGroup::where('item_id', $item_id)->where('status', 2)->get();
    $itmes_arrdata = AyraHelp::getItemsbyItemID($item_id);

    if ($purchase_entrycheck->isEmpty()) {
      $max_id = PurchaseItemGroup::max('purchase_index') + 1;
      $itemSEntry = new PurchaseItemGroup;
      $itemSEntry->item_id = $item_id;
      $itemSEntry->item_name = $itmes_arrdata->item_name;
      $itemSEntry->qty = $orderItemM_arr->m_qty;
      $itemSEntry->status = 2;
      $itemSEntry->purchase_index = $max_id;
      $itemSEntry->pid = '';  //purchase id
      $itemSEntry->save();
    } else {
      $purchasecheck = PurchaseItemGroup::where('item_id', $item_id)->where('status', 2)->first();
      if ($purchasecheck != null) {
        $purchasecheck = PurchaseItemGroup::where('item_id', $item_id)->where('status', 2)->increment('qty', $orderItemM_arr->m_qty);
      }
    }

    $res_arr = array(
      'status' => 1,
      'Message' => 'Request for purchased now successfully.',
    );
    return response()->json($res_arr);
  }
  public function purchaseItemforStock_(Request $request)
  {
    $item_id_ = $request->rowid;
    $orderM_arr = OrderItemMaterial::where('id', $item_id_)->first();
    $order_item_arr = OrderItem::where('id', $orderM_arr->order_item_id)->first();
    $order_id = $order_item_arr->order_index;
    $m_qty = $orderM_arr->m_qty;
    $item_id = $orderM_arr->item_id;

    $stock_check = ItemStock::where('item_id', '=', $item_id)->first();
    if ($stock_check === null) {

      echo "not exits item ";
    } else {

      OrderItemMaterial::where('id', $request->rowid)
        ->update(['req_status' => 2]);
      $stock_entrycheck = ItemStockEntry::where('order_index', '=', $order_id)->where('item_id', '=', $item_id)->where('purchase_reserve_flag', 2)->first();
      if ($stock_entrycheck === null) {
        $itemSEntry = new ItemStockEntry;
        $itemSEntry->order_index = $order_id;
        $itemSEntry->item_id = $item_id;
        $itemSEntry->purchase_reserve_flag = 2;
        $itemSEntry->created_by = Auth::user()->id;
        $itemSEntry->purchase_reserved_status = 2;
        $itemSEntry->qty = $m_qty;
        $itemSEntry->product_id = $orderM_arr->order_item_id;
        $itemSEntry->save();
      }
      //check if item is already sent for purchase then new entry
      //if not sent then add qty++

      $purchase_entrycheck = PurchaseItemRequest::where('item_id', $item_id)->where('status', 1)->get();
      $itmes_arrdata = AyraHelp::getItemsbyItemID($item_id);

      if ($purchase_entrycheck->isEmpty()) {
        $max_id = PurchaseItemRequest::max('purchase_index') + 1;

        $itemSEntry = new PurchaseItemRequest;
        $itemSEntry->item_id = $item_id;
        $itemSEntry->qty = $m_qty;
        $itemSEntry->status = 1;
        $itemSEntry->purchase_index = $max_id;

        $itemSEntry->pid = '';  //purchase id
        $itemSEntry->item_name = $itmes_arrdata->item_name;
        $itemSEntry->save();
      } else {
        $purchasecheck = PurchaseItemRequest::where('item_id', $item_id)->where('status', 1)->first();
        if ($purchasecheck != null) {
          $purchasecheck = PurchaseItemRequest::where('item_id', $item_id)->where('status', 1)->increment('qty', $m_qty);
        }
      }



      $res_arr = array(
        'status' => 1,
        'Message' => 'Reserved now successfully.',
      );
      return response()->json($res_arr);
    }
  }
  /*
|--------------------------------------------------------------------------
| function name:reserveItemfromStock
|--------------------------------------------------------------------------
| reserve from stock
*/
  public function reserveItemfromStock(Request $request)
  {
    $rowid = $request->rowid;
    $orderItemM_arr = OrderItemMaterial::where('id', $rowid)->first();
    //update req_status =2 //beacuse it show that requested for reserved and stock qty decrser now .
    OrderItemMaterial::where('id', $rowid)->update([
      'req_status' => 2,
      'purchase_reserved_status' => 2

    ]);
    //now save data to item stock reserved
    $item_arr =  AyraHelp::getItemsbyItemID($orderItemM_arr->item_id);
    $isr = new ItemStockReserved;
    $isr->order_id = $orderItemM_arr->order_item_id;
    $isr->item_id = $orderItemM_arr->item_id;
    $isr->item_name = $item_arr->item_name;
    $isr->qty = $orderItemM_arr->m_qty;
    $isr->created_by = Auth::user()->id;
    $isr->status = 2;
    $isr->save();
    ItemStock::where('item_id', $orderItemM_arr->item_id)->decrement('qty', $orderItemM_arr->m_qty);
    $res_arr = array(
      'status' => 1,
      'Message' => 'Request for Reserved now successfully.',
    );
    return response()->json($res_arr);
  }


  public function reserveItemfromStock_(Request $request)
  {
    $item_id_ = $request->rowid;
    $orderM_arr = OrderItemMaterial::where('id', $item_id_)->first();
    $order_item_arr = OrderItem::where('id', $orderM_arr->order_item_id)->first();
    $order_id = $order_item_arr->order_index;
    $m_qty = $orderM_arr->m_qty;
    $item_id = $orderM_arr->item_id;

    OrderItemMaterial::where('id', $request->rowid)
      ->update(['req_status' => 2]);

    $stock_entrycheck = ItemStockEntry::where('order_index', '=', $order_id)->where('item_id', '=', $item_id)->where('purchase_reserve_flag', 2)->first();
    if ($stock_entrycheck === null) {
      $itemSEntry = new ItemStockEntry;
      $itemSEntry->order_index = $order_id;
      $itemSEntry->item_id = $item_id;
      $itemSEntry->purchase_reserve_flag = 1;
      $itemSEntry->created_by = Auth::user()->id;
      $itemSEntry->purchase_reserved_status = 1;
      $itemSEntry->qty = $m_qty;
      $itemSEntry->product_id = $orderM_arr->order_item_id;
      $itemSEntry->save();

      //save data to item_stock_reserved
      $item_arr =  AyraHelp::getItemsbyItemID($item_id);

      $itemSEntry = new ItemStockReserved;
      $itemSEntry->order_id = 11;
      $itemSEntry->item_id = $item_id;
      $itemSEntry->item_name = $item_arr->item_name;
      $itemSEntry->qty = $m_qty;
      $itemSEntry->created_by = Auth::user()->id;
      $itemSEntry->status = 2;
      $itemSEntry->issue_status = 1;
      $itemSEntry->save();
      ItemStock::where('item_id', $item_id)->decrement('qty', $m_qty);
      //ItemStockEntry::where('id',$item_id_)->update(['purchase_reserved_status'=>1]);
      //save data to item_stock_reserved

    }
    $res_arr = array(
      'status' => 1,
      'Message' => 'Request for Reserved now successfully.',
    );
    return response()->json($res_arr);
  }

  /*
|--------------------------------------------------------------------------
| function name:deleteItemOrder
|--------------------------------------------------------------------------
| delete added items of order
*/
  public function deleteItemOrder(Request $request)
  {
    $res = OrderItem::where('id', $request->req_id)->delete();
    $res = OrderItemMaterial::where('order_item_id', $request->req_id)->delete();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data Deleted successfully.',
    );

    return response()->json($res_arr);
  }



  /*
|--------------------------------------------------------------------------
| function name:getStock_AddedList
|--------------------------------------------------------------------------
| get the list of stock and item required list
*/
  public function getStock_AddedList(Request $request)
  {
    $item_id = $request->item_id;
    $clientOrderItemMat_arr = OrderItemMaterial::where('order_item_id', $item_id)->where('req_status', 1)->get();
    $data_arr_1 = array();
    $data_arr_2 = array();
    $data_arr_3 = array();


    $diffHTML = "";
    foreach ($clientOrderItemMat_arr as $key => $value) {
      $item_arr_pro = AyraHelp::getProductItemByid($item_id);

      $itemcat_arr = AyraHelp::getItemCatbyItemID($value->item_cat_id);
      $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $itemcatStock_arr = AyraHelp::getStockQTYbyItemID($value->item_id);
      $stock_qty = $itemcatStock_arr->qty;
      $req_qty = $value->m_qty;

      if ($req_qty <= $stock_qty) { //if stock is higher than demand
        $diffHTML = "Available";
        $stock_flag = 1; //1 is available
      } else {
        $diffHTML = "Out of stock";
        $stock_flag = 2; //1 is available
      }


      $data_arr_1[] = array(
        'RecordID' => $value->id,
        'product_name' => isset($item_arr_pro->item_name) ? $item_arr_pro->item_name : "",
        'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
        'item_material_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->m_qty) ? $value->m_qty : "",
        'stock_in' => isset($itemcatStock_arr->qty) ? $itemcatStock_arr->qty : "",
        'stock_status' => $stock_flag,
        'stock_flag' => $stock_flag,
        'Actions' => ""
      );
    }
    //again check data is reserved or not if yes then merge in this array

    $itemStockResreved_arr = ItemStockReserved::where('order_id', $item_id)->where('issue_status', 1)->get();


    foreach ($itemStockResreved_arr as $key => $value) {

      $item_arr_pro = AyraHelp::getProductItemByid($item_id);
      $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $itemcat_arr = AyraHelp::getItemCatbyItemID($item_arr->cat_id);

      $itemcatStock_arr = AyraHelp::getStockQTYbyItemID($value->item_id);
      $diffHTML = "Reserved";
      if ($value->status == 1) {
        $stock_flag = 3; //4 is resered requested
      }
      if ($value->status == 2) {
        $stock_flag = 6; //4 is resereded Now
      }
      $stock_flag = 3; //3 is reserved

      $data_arr_2[] = array(
        'RecordID' => $value->id,
        'product_name' => isset($item_arr_pro->item_name) ? $item_arr_pro->item_name : "",
        'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
        'item_material_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->qty) ? $value->qty : "",
        'stock_in' => '',
        'stock_status' => $stock_flag,
        'stock_flag' => $stock_flag,
        'Actions' => ""
      );
    }
    //again check data is requested to purchaed or not if yes then merged
    $itemStockResreved_arr = PurchaseItemRequested::where('order_id', $item_id)->where('recieved_status', 1)->get();


    foreach ($itemStockResreved_arr as $key => $value) {

      $item_arr_pro = AyraHelp::getProductItemByid($item_id);
      $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $itemcat_arr = AyraHelp::getItemCatbyItemID($item_arr->cat_id);

      $itemcatStock_arr = AyraHelp::getStockQTYbyItemID($value->item_id);
      $diffHTML = "Purchase Requested";
      if ($value->status == 1) {
        $stock_flag = 5; //4 is purchased requested
      }
      if ($value->status == 2) {
        $stock_flag = 4; //4 is purchased requested
      }


      $data_arr_3[] = array(
        'RecordID' => $value->id,
        'product_name' => isset($item_arr_pro->item_name) ? $item_arr_pro->item_name : "",
        'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
        'item_material_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->qty) ? $value->qty : "",
        'stock_in' => '',
        'stock_status' => $stock_flag,
        'stock_flag' => $stock_flag,
        'Actions' => ""
      );
    }


    $data_arr = array_merge($data_arr_1, $data_arr_2, $data_arr_3);

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'product_name'      => true,
      'item_cat'      => true,
      'item_material_name'      => true,
      'item_qty'  => true,
      'stock_in'      => true,
      'stock_status'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getStock_AddedList_(Request $request)
  {
    $clientOrderItemMat_arr = OrderItemMaterial::where('order_item_id', $request->item_id)->get();
    $itemID = $request->item_id;


    $data_arr = array();
    foreach ($clientOrderItemMat_arr as $key => $value) {

      $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $item_arr_pro = AyraHelp::getProductItemByid($itemID);

      $itemcatStock_arr = AyraHelp::getStockQTYbyItemID($value->item_id);

      $itemcat_arr = AyraHelp::getItemCatbyItemID($value->item_cat_id);



      $created_by = AyraHelp::getUserName($value->added_by);
      $created_on = date('j M Y', strtotime($value->added_on));
      $diff_amt = ($itemcatStock_arr->qty) - ($value->m_qty);



      //check in in db that item is sent for purchase or reserved
      $stock_entrycheck = ItemStockEntry::where('product_id', '=', $value->order_item_id)->where('item_id', '=', $value->item_id)->first();
      if ($stock_entrycheck === null) {
        $diffHTML = "Pending";
        $stock_flag = 1;
      } else {
        if ($stock_entrycheck->purchase_reserve_flag == 1) {
          //reserved Requeste
          switch ($stock_entrycheck->purchase_reserved_status) {
            case '2':
              $diffHTML = "Pending";
              $stock_flag = 1;
              break;
            case '1':
              $diffHTML = "Reserved";
              $stock_flag = 2;
              break;

            default:
              # code...
              break;
          }
        } else {
          //purchased Requested
          switch ($stock_entrycheck->purchase_reserved_status) {
            case '1':
              $diffHTML = "Requested for Purchase";
              $stock_flag = 3;
              break;
            case '2':
              $diffHTML = "Reserved";
              $stock_flag = 4;
              break;

            default:
              # code...
              break;
          }
        }
      }


      if ($value->m_qty > $itemcatStock_arr->qty) {
        $stock_flag = 3; //purchase flag
        $diffHTML = "Purchase Request";
      }





      $data_arr[] = array(
        'RecordID' => $value->id,
        'product_name' => isset($item_arr_pro->item_name) ? $item_arr_pro->item_name : "",
        'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
        'item_material_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->m_qty) ? $value->m_qty : "",
        'stock_in' => isset($itemcatStock_arr->qty) ? $itemcatStock_arr->qty : "",
        'stock_status' => $diffHTML,
        'stock_flag' => $stock_flag,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'product_name'      => true,
      'item_cat'      => true,
      'item_material_name'      => true,
      'item_qty'  => true,
      'stock_in'      => true,
      'stock_status'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }





  /*
|--------------------------------------------------------------------------
| function name:getOrderMItemsAddedList
|--------------------------------------------------------------------------
| get the list of order materins item added against items
*/
  public function getOrderMItemsAddedList(Request $request)
  {
    $clientOrderItemMat_arr = OrderItemMaterial::where('order_item_id', $request->item_id)->get();
    $itemID = $request->item_id;


    $data_arr = array();
    foreach ($clientOrderItemMat_arr as $key => $value) {
      $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
      $item_arr_pro = AyraHelp::getProductItemByid($itemID);


      $itemcat_arr = AyraHelp::getItemCatbyItemID($value->item_cat_id);


      $created_by = AyraHelp::getUserName($value->added_by);
      $created_on = date('j M Y', strtotime($value->added_on));

      $data_arr[] = array(
        'RecordID' => $value->id,
        'product_name' => isset($item_arr_pro->item_name) ? $item_arr_pro->item_name : "",
        'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
        'item_material_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->m_qty) ? $value->m_qty : "",
        'created_on' => isset($created_on) ? $created_on : "",
        'created_by' => isset($created_by) ? $created_by : "",
        'remarks' => isset($value->m_remarks) ? $value->m_remarks : "",
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'product_name'      => true,
      'item_cat'      => true,
      'item_material_name'      => true,
      'item_qty'  => true,
      'created_on'      => true,
      'created_by'      => true,
      'remarks'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  /*
|--------------------------------------------------------------------------
| function name:saveOrderItem
|--------------------------------------------------------------------------
| this is used to save
*/
  public function saveOrderItem(Request $request)
  {
    $max_id = Order::max('id') + 1;
    $num = $max_id;
    $str_length = 4;
    $order_code = "BO-" . substr("0000{$num}", -$str_length);
    //if item id is same then update qty and remrks
    //getStockBYItemID($request->item_id);
    $order_check = OrderItemMaterial::where('item_id', '=', $request->item_id)->where('order_item_id', '=', $request->order_item_id)->first();
    if ($order_check === null) {
      // user doesn't exist
      $orderM_obj = new OrderItemMaterial;
      $orderItem_D_arr = OrderItem::where('id', $request->order_item_id)->first();

      $orderM_obj->order_index = $orderItem_D_arr->order_index;
      $orderM_obj->order_item_id = $request->order_item_id;
      $orderM_obj->item_cat_id = $request->item_cat;
      $orderM_obj->item_id = $request->item_id;
      $orderM_obj->m_qty = $request->item_qty;
      $orderM_obj->m_remarks = $request->item_remarks;
      $orderM_obj->added_by = Auth::user()->id;
      $orderM_obj->save();
    } else {
      // user exits exist
      OrderItemMaterial::where('item_id', $request->item_id)
        ->update([
          'm_qty' => $order_check->m_qty + $request->item_qty,
          'm_remarks' => $request->item_remarks
        ]);
    }
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );

    return response()->json($res_arr);
  }

  /*
|--------------------------------------------------------------------------
| function name:getCatItems
|--------------------------------------------------------------------------
| this is used to get all items based on item_indexSKU
*/
  public function getCatItems(Request $request)
  {

    $item_arr = Item::where('cat_id', $request->item_cat)->get();
    $html = "";
    foreach ($item_arr as $items) {
      $html .= '<option value="' . $items->item_id . '">' . $items->item_name . '</option>';
    }
    echo $html;
  }
  /*
|--------------------------------------------------------------------------
| function name:orderAddMaterial
|--------------------------------------------------------------------------
| this is used to show layout for add material againt items
*/
  public function orderAddMaterial($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $orderItem = OrderItem::where('id', $id)->get();
    $order = Order::where('id', $orderItem[0]->order_index)->first();
    //$orderItem= OrderItem::where('order_index',$order->order_index)->get();
    $client = Client::where('id', $order->client_id)->first();
    $data = [
      'users_data' => $client,
      'orders_data' => $order,
      'ordersItem_data' => $orderItem,
    ];
    return $theme->scope('orders.add_order_material', $data)->render();
  }


  /*
|--------------------------------------------------------------------------
| function name:getOrderData
|--------------------------------------------------------------------------
| get the list of all orders in datagrid
*/
  public function getOrderInfo($id)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $OrderMItem_arr = OrderItemMaterial::where('order_item_id', $id)->get();
    $data = [
      'order_m_items' => $OrderMItem_arr,
    ];
    return $theme->scope('orders.view_info', $data)->render();
  }

  /*
|--------------------------------------------------------------------------
| function name:setMaterialAttribue
|--------------------------------------------------------------------------
| save the material name
*/
  public function setMaterialAttribue(Request $request)
  {

    $item_name = $request->item_name;

    $max_id = ItemMasterType::max('item_code') + 1;
    $num = $max_id;
    $str_length = 4;
    $order_code = "BO-" . substr("0000{$num}", -$str_length);
    $orderM_obj = new ItemMasterType;
    $orderM_obj->item_code = $max_id;
    $orderM_obj->item_name = $request->item_name;
    $orderM_obj->added_by = Auth::user()->id;
    $orderM_obj->save();
    echo "<option value=" . $max_id . ">$item_name</options>";
  }

  /*
|--------------------------------------------------------------------------
| function name:getMaterialAttribue
|--------------------------------------------------------------------------
| get the list of  Material attribule
*/
  public function getMaterialAttribue(Request $request)
  {

    $item_type_code = $request->item_type_code;
    $item_master_arr = ItemMaster::where('item_master_type_index', $item_type_code)->get();

    $html = '';
    foreach ($item_master_arr as $key => $value) {
      $html .= "<option value=" . $value->item_code . ">$value->item_name</option>";
    }
    echo $html;
  }


  /*
|--------------------------------------------------------------------------
| function name:getOrderMaterialItemAddedList
|--------------------------------------------------------------------------
| get the list of order Material item added
*/
  public function getOrderMaterialItemAddedList(Request $request)
  {
    $clientOrderItemMat_arr = OrderItemMaterial::where('item_index', $request->order_index)->get();

    $data_arr = array();
    foreach ($clientOrderItemMat_arr as $key => $value) {
      $item_arr = AyraHelp::getMasterItemsTypebyCode($value->item_code);


      $data_arr[] = array(
        'rowid' => $value->id,
        'item_code' => isset($value->item_code) ? $value->item_code : "",
        'item_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
        'item_qty' => isset($value->m_qty) ? $value->m_qty : "",
        'remarks' => isset($value->m_remarks) ? $value->m_remarks : "",
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'rowid'     => true,
      'item_code'      => true,
      'item_name'      => true,
      'item_qty'  => true,
      'remarks'      => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  /*
|--------------------------------------------------------------------------
| function name:saveMaterialItem
|--------------------------------------------------------------------------
| save Material items against order
*/
  public function saveMaterialItem(Request $request)
  {


    $max_id = Order::max('id') + 1;
    $num = $max_id;
    $str_length = 4;
    $order_code = "BO-" . substr("0000{$num}", -$str_length);
    $orderM_obj = new OrderItemMaterial;
    $orderM_obj->item_index = $request->recordID;
    $orderM_obj->item_code = $request->item_code;
    $orderM_obj->m_qty = $request->txtMaterialQTY;
    $orderM_obj->m_remarks = $request->txtMaterialRemarks;
    $orderM_obj->added_by = Auth::user()->id;
    $orderM_obj->save();
    $res_arr = array(
      'status' => 1,
      'Message' => 'Data saved successfully.',
    );
    return response()->json($res_arr);
  }

  /*
|--------------------------------------------------------------------------
| function name:getOrderItemsList
|--------------------------------------------------------------------------
| get the list of all orders items in datagrid
*/
  public function getOrderItemsList(Request $request)
  {
    $clientOrderItem_arr = OrderItem::where('order_index', $request->order_index)->get();

    $data_arr = array();
    foreach ($clientOrderItem_arr as $key => $value) {

      $clientOrder_arr = Order::where('order_index', $value->order_index)->first();

      $user_arr = AyraHelp::getClientbyid($clientOrder_arr->client_id);
      $created_by = AyraHelp::getUserName($clientOrder_arr->created_by);
      $created_on = date('j M Y', strtotime($clientOrder_arr->created_at));


      $confirBOM_arr = OrderItemMaterial::where('order_item_id', $value->id)->first();
      if ($confirBOM_arr == null) {
        $status = 1;
        $or_sub = "";
      } else {
        if ($value->sub_order_id == null) {
          $status = 1;
        } else {
          $status = 2;
        }
        $or_sub = $value->sub_order_id;
      }




      //this code to save data not complted need to do

      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => $clientOrder_arr->pri_order_id,
        'sub_order_id' => $or_sub,
        'item_name' => $value->item_name,
        'company' => isset($user_arr->company) ? $user_arr->company . "(" . $user_arr->brand . ")" : '',
        'item_name' => $value->item_name,
        'item_qty' => $value->item_qty,
        'created_on' => $created_on,
        'Status' => $status,
      );
    }


    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'sub_order_id'      => true,
      'company'      => true,
      'item_name'      => true,
      'item_qty'  => true,
      'created_on'      => true,
      'Status'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  /*
|--------------------------------------------------------------------------
| function name:getOrderMainList
|--------------------------------------------------------------------------
| get the list of all orders in datagrid
*/
//getSampleChemistListAssigned
public function getSampleChemistListAssigned(Request $request)
{

  $userid=$request->userid;

  $countSamUseArr = DB::table('samples')
   ->where('assingned_to', $userid)
  ->where('is_deleted', 0)
  ->where('is_formulated', 0)
  ->get();
  $i=0;
  foreach ($countSamUseArr as $key => $rowData) {
    $i++;
    $data_arr[] = array(
      'RecordID' => $rowData->id,
      'index_id' => $i,
      'sample_id' => $rowData->sample_code,
      'assigned_at' =>date('j F Y H:iA',strtotime($rowData->assingned_on)),
      'created_at' => date('j F Y H:iA',strtotime($rowData->created_at)),
      'sample_type' => $rowData->sample_type,
      'sample_statge' => $rowData->sample_stage_id,
      'sales_person' => AyraHelp::getUser($rowData->created_by)->name,
      
    );
  }

  $JSON_Data = json_encode($data_arr);
  $columnsDefault = [
    'RecordID'     => true,
    'name'      => true,
    'cate_1'      => true,
    'cate_2'  => true,
    'cate_3'      => true,
    'cate_4'     => true,
    'cate_5'     => true,      
    'Actions'      => true,
  ];

  $this->DataGridResponse($JSON_Data, $columnsDefault);
}

//getSampleChemistListAssigned

  //getSampleChemistList
  public function getSampleChemistList(Request $request)
  {

    $clientOrder_arr = AyraHelp::getChemist();
    $categoryArr=array(1,3,4,5);

    $data_arr = array();
    foreach ($clientOrder_arr as $key => $value) {

      
      $countSamUse = DB::table('samples')
      ->where('assingned_to', $value->id)
      ->where('is_deleted', 0)
      ->where('is_formulated', 0)
      ->where('status', 1)
      // ->where('sample_type', '!=',2)
      ->count();

      $affected = DB::table('sample_assigned_list')
        ->where('user_id', $value->id)
        ->update(['pending_count' => $countSamUse]);




        $usersData = DB::table('sample_assigned_list')
            ->where('user_id', $value->id)            
            ->first();
            if($usersData==null){
              $limitData="";
            }else{
              $limitData="(".$usersData->pending_count."/".$usersData->max_id.")";
            }
           
          



      $catStr_1="-";
     if($categoryArr[0]==1){
      $users = DB::table('sample_for_users')
            ->where('user_id', $value->id)
            ->where('sample_type_id', 1)
            ->first();
            if($users==null){
              $catStr_1="--";
            }else{
              $catStr_1="YES";
            }

     }
     $catStr_3="--";
     if($categoryArr[1]==3){
      $users = DB::table('sample_for_users')
            ->where('user_id', $value->id)
            ->where('sample_type_id', 3)
            ->first();
            if($users==null){
              $catStr_3="--";
            }else{
              $catStr_3="YES";
            }

     }
     $catStr_4="--";
     if($categoryArr[2]==4){
      $users = DB::table('sample_for_users')
            ->where('user_id', $value->id)
            ->where('sample_type_id', 4)
            ->first();
            if($users==null){
              $catStr_4="--";
            }else{
              $catStr_4="YES";
            }

     }
     $catStr_5="";
     if($categoryArr[3]==5){
      $users = DB::table('sample_for_users')
            ->where('user_id', $value->id)
            ->where('sample_type_id', 5)
            ->first();
            if($users==null){
              $catStr_5="--";
            }else{
              $catStr_5="YES";
            }

     }


      $data_arr[] = array(
        'RecordID' => $value->id,
        'name' => $value->name.$limitData,
        'cate_1' => $catStr_1,
        'cate_2' => $catStr_3,
        'cate_3' => $catStr_4,
        'cate_4' => $catStr_5,
        'cate_5' => 1,
        'Status' => 1
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'name'      => true,
      'cate_1'      => true,
      'cate_2'  => true,
      'cate_3'      => true,
      'cate_4'     => true,
      'cate_5'     => true,      
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  //getSampleChemistList

  public function getOrderMainList(Request $request)
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin') {
      $clientOrder_arr = Order::get();
    } else {
      $clientOrder_arr = Order::where('created_by', Auth::user()->id)->get();
    }

    $data_arr = array();
    foreach ($clientOrder_arr as $key => $value) {
      $client_id = $value->client_id;

      $user_arr = AyraHelp::getClientbyid($client_id);
      $created_by = AyraHelp::getUserName($value->created_by);

      $created_on = date('j M Y', strtotime($value->created_at));
      $due_date = date('j M Y', strtotime($value->due_date));
      $brand = isset($user_arr->brand) ? $user_arr->brand : '';

      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => isset($value->pri_order_id) ? $value->pri_order_id : '',
        'phone' => isset($user_arr->phone) ? $user_arr->phone : '',
        'company' => isset($user_arr->company) ? $user_arr->company . "(" . $brand . ")" : 'Ajay',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'due_date' => $due_date,
        'Status' => $value->status,
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'phone'      => true,
      'company'  => true,
      'created_by'      => true,
      'created_on'     => true,
      'due_date'     => true,
      'Status'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  /*
  |--------------------------------------------------------------------------
  | function name:getOrdersList
  |--------------------------------------------------------------------------
  | get the list of all orders in datagrid
  */
  public function getOrdersList(Request $request)
  {

    $clientOrder_arr = Order::get();
    $data_arr = array();
    foreach ($clientOrder_arr as $key => $value) {
      $client_id = $value->clinet_id;
      $user_arr = AyraHelp::getClientbyid($client_id);
      $created_by = AyraHelp::getUserName($value->created_by);

      $created_on = date('j M Y', strtotime($value->created_at));
      $due_date = date('j M Y', strtotime($value->due_date));



      $data_arr[] = array(
        'RecordID' => $value->id,
        'order_id' => isset($value->order_id) ? $value->order_id : '',
        'company' => isset($user_arr->company) ? $user_arr->company : 'Ajay',
        'created_by' => $created_by,
        'created_on' => $created_on,
        'due_date' => $due_date,
        'Status' => $value->status,
      );
    }

    $JSON_Data = json_encode($data_arr);
    $columnsDefault = [
      'RecordID'     => true,
      'order_id'      => true,
      'company'  => true,
      'created_by'      => true,
      'created_on'     => true,
      'due_date'     => true,
      'Status'     => true,
      'Actions'      => true,
    ];

    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  /*
  |--------------------------------------------------------------------------
  | function name:index
  |--------------------------------------------------------------------------
  | get the list of all orders
  */
  public function index()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('orders.index', $data)->render();
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
      'users' => '',
    ];
    return $theme->scope('orders.create', $data)->render();
  }

  /*
    |--------------------------------------------------------------------------
    | function name:store
    |--------------------------------------------------------------------------
    | save order data to order and items in order_items
    */
  public function store(Request $request)
  {



    $max_id = Order::max('id') + 1;
    $num = $max_id;
    $str_length = 4;
    $order_code = "BO-" . substr("0000{$num}", -$str_length);

    $order_obj = new Order;
    $order_obj->order_index = $max_id;
    $order_obj->client_id = $request->client_id;
    $order_obj->sample_code = $request->sample_id;
    $order_obj->sales_person_id = $request->catsalesUser;

    $order_obj->due_date = date("Y-m-d", strtotime($request->order_due_date));
    $order_obj->created_by = Auth::user()->id;
    $order_obj->item_qty = count($request->Orders);

    $order_obj->save();
    $lastinsertID = $order_obj->id;
    foreach ($request->Orders as $key => $value) {
      $sub_max_id = OrderItem::where('order_index', $max_id)->max('sub_index') + 1;
      $orderItem_obj = new OrderItem;
      $orderItem_obj->item_name = $value['txtOrderItem'];
      $orderItem_obj->item_qty = $value['txtQTY'];
      $orderItem_obj->item_size = $value['txtSize'];
      $orderItem_obj->sample_id = $value['txtSampleID'];
      $orderItem_obj->sub_index = $sub_max_id;
      $orderItem_obj->order_index = $max_id;
      $orderItem_obj->save();
    }
    echo $lastinsertID;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $order = Order::where('id', $id)->first();
    $orderItem = OrderItem::where('order_index', $order->order_index)->get();

    $client = Client::where('id', $order->client_id)->first();
    $data = [
      'users_data' => 'ss',
      'orders_data' => '',
      'ordersItem_data' => '',
    ];


    return $theme->scope('orders.process', $data)->render();
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $order = Order::where('id', $id)->first();
    $orderItem = OrderItem::where('order_index', $order->order_index)->get();

    $client = Client::where('id', $order->client_id)->first();
    $data = [
      'users_data' => $client,
      'orders_data' => $order,
      'ordersItem_data' => $orderItem,
    ];


    return $theme->scope('orders.edit', $data)->render();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    $sent_datev = date("Y-m-d", strtotime($request->sent_on));
    $order_obj = Order::find($id);
    $order_obj->sample_code = $request->sample_id;
    $order_obj->client_id = $request->client_id;
    $order_obj->due_date = $sent_datev;
    $order_obj->item_qty = count($request->Orders);
    $order_obj->save();
    //find and delete

    $res = OrderItem::where('order_index', $request->order_index)->delete();

    foreach ($request->Orders as $key => $value) {
      $orderItem_obj = new OrderItem;
      $orderItem_obj->item_name = $value['txtOrderItem'];
      $orderItem_obj->item_qty = $value['txtQTY'];
      $orderItem_obj->sample_id = $value['txtSampleID'];
      $orderItem_obj->item_size = $value['txtSize'];
      $orderItem_obj->order_index = $request->order_index;
      $orderItem_obj->save();
    }

    echo $id;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    //
  }
}
