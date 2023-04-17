<?php
//app/Helpers/AyraHelp.php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Sample;
use App\Http\Controllers;
use App\QCFORM;
use App\OrderDispatchData;
use App\QCPP;
use Auth;
use App\PurchaseItemRequest;
use App\PurchaseItemGroup;
use App\Category;
use App\PurchaseOrders;
use App\OrderStageCount;
use App\OrderStageCountNew;
use App\ClientNote;
use App\POCatalogData;
use App\HPlanDay2;
use App\OPDays;
use App\OPData;
use App\PaymentRec;
use App\QCBOM;
use App\QC_BOM_Purchase;
use App\PurchaseOrderRecieved;

use App\OrderMaster;
use App\LeadDataProcess;
use App\OrderMasterV1;
use Illuminate\Support\Str;
use App\OPDaysBulk;
use App\OPDaysRepeat;
use App\QCBULK_ORDER;
use App\SAP_CHECKLISt;
use \DateTime;
use App\Client;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Mail;

class AyraHelp
{

   
    

    //online2OfflineSalesInvoiceRequestMerge
    public static function online2OfflineSalesInvoiceRequestMerge()
    {
        $client_arrBOM = DB::table('sales_invoice_request_online')->where('is_deletd', 0)->where('is_done', 0)->get(); //256
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) { //
            $form_id = $rowData->form_id;
            $client_arrORI = DB::table('qc_forms')->where('online_form_id', $form_id)->first();
            if ($client_arrORI == null) {
                echo $form_id;
            } else {
                $i++;
                DB::table('sales_invoice_request')
                    ->updateOrInsert(
                        ['online_form_id' => $rowData->form_id],
                        [
                            'form_id' =>  $client_arrORI->form_id,
                            'gstno' =>   $rowData->gstno,
                            'contact_no' =>   $rowData->contact_no,
                            'complete_address' =>   $rowData->complete_address,
                            'delivey_address' =>   $rowData->delivey_address,
                            'material_through' =>   $rowData->material_through,
                            'destination' =>   $rowData->destination,
                            'vehicle_details' =>   $rowData->vehicle_details,
                            'terms_delivery' =>   $rowData->terms_delivery,
                            'total_cartons' =>   $rowData->total_cartons,
                            'total_units' =>   $rowData->total_units,
                            'paid_by' =>   $rowData->paid_by,
                            'created_at' =>   $rowData->created_at,
                            'status' =>   $rowData->status,
                            'account_remarks' =>   $rowData->account_remarks,
                            'created_by' =>   $rowData->created_by,
                            'view_status' =>   $rowData->view_status,
                            'request_at_time' =>   $rowData->request_at_time,
                            'completed_on' =>   $rowData->completed_on,
                            'order_data_json' =>   $rowData->order_data_json,
                            'is_deletd' =>   $rowData->is_deletd,
                            'txtRemarksNote' =>   $rowData->txtRemarksNote,
                            'txtTallyNo' =>   $rowData->txtTallyNo,
                            'ship_charge' =>   $rowData->ship_charge,
                            'online_form_id' =>  $rowData->form_id

                        ]
                    );


                $affected = DB::table('sales_invoice_request_online')
                    ->where('form_id', $rowData->form_id)
                    ->update([
                        'offline_form_id' => $client_arrORI->form_id,
                        'is_done' => 1
                    ]);
            }
        }
        echo $i;
    }
    //online2OfflineSalesInvoiceRequestMerge


    //online2OfflinePaymentRecievedMerge
    public static function online2OfflinePaymentRecievedMerge()
    {
        $client_arrBOM = DB::table('payment_recieved_from_client_online')->where('is_deleted', 0)->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) { //
            $online_cid = $rowData->client_id;
            $client_arrORI = DB::table('clients')->where('on_id', $online_cid)->first();
            if ($client_arrORI == null) {



                DB::table('payment_recieved_from_client')
                    ->updateOrInsert(
                        ['online_id' => $rowData->id],
                        [
                            'client_id' =>  null,
                            'temp_cid' =>   $rowData->temp_cid,
                            'created_at' =>  $rowData->created_at,
                            'recieved_on' =>  $rowData->recieved_on,
                            'rec_amount' =>  $rowData->rec_amount,
                            'rec_amount_words' =>  $rowData->rec_amount_words,
                            'bank_name' =>  $rowData->bank_name,
                            'payment_img' =>  $rowData->payment_img,
                            'request_remarks' =>  $rowData->request_remarks,
                            'payment_status' =>  $rowData->payment_status,
                            'account_remarks' =>  $rowData->account_remarks,
                            'admin_remarks' =>  $rowData->admin_remarks,
                            'created_by' =>  $rowData->created_by,
                            'client_name' =>  $rowData->client_name,
                            'client_phone' =>  $rowData->client_phone,
                            'compamy_name' =>  $rowData->compamy_name,
                            'is_deleted' =>  $rowData->is_deleted,
                            'view_read' =>  $rowData->view_read,
                            'paytype_name' =>  $rowData->paytype_name,
                            'created_by_ori' =>  $rowData->created_by_ori,
                            'is_rejected' =>  $rowData->is_rejected,
                            'rejected_by' =>  $rowData->rejected_by,
                            'rejected_reason' =>  $rowData->rejected_reason,
                            'rejected_at' =>  $rowData->rejected_at,
                            'rejected_status' =>  $rowData->rejected_status,
                            // 'payment_for' =>  $rowData->payment_for,
                            'online_id' =>  $rowData->id,
                            'online_client_id' =>  $rowData->client_id
                        ]
                    );
                $lid = DB::getPdo()->lastInsertId();


                $affected = DB::table('payment_recieved_from_client_online')
                    ->where('id', $rowData->id)
                    ->update([
                        'offline_id' => $lid,
                        'is_done' => 1
                    ]);
            } else {
                $i++;

                DB::table('payment_recieved_from_client')
                    ->updateOrInsert(
                        ['online_id' => $rowData->id],
                        [
                            'client_id' =>  $client_arrORI->id,
                            'temp_cid' =>   $rowData->temp_cid,
                            'created_at' =>  $rowData->created_at,
                            'recieved_on' =>  $rowData->recieved_on,
                            'rec_amount' =>  $rowData->rec_amount,
                            'rec_amount_words' =>  $rowData->rec_amount_words,
                            'bank_name' =>  $rowData->bank_name,
                            'payment_img' =>  $rowData->payment_img,
                            'request_remarks' =>  $rowData->request_remarks,
                            'payment_status' =>  $rowData->payment_status,
                            'account_remarks' =>  $rowData->account_remarks,
                            'admin_remarks' =>  $rowData->admin_remarks,
                            'created_by' =>  $rowData->created_by,
                            'client_name' =>  $rowData->client_name,
                            'client_phone' =>  $rowData->client_phone,
                            'compamy_name' =>  $rowData->compamy_name,
                            'is_deleted' =>  $rowData->is_deleted,
                            'view_read' =>  $rowData->view_read,
                            'paytype_name' =>  $rowData->paytype_name,
                            'created_by_ori' =>  $rowData->created_by_ori,
                            'is_rejected' =>  $rowData->is_rejected,
                            'rejected_by' =>  $rowData->rejected_by,
                            'rejected_reason' =>  $rowData->rejected_reason,
                            'rejected_at' =>  $rowData->rejected_at,
                            'rejected_status' =>  $rowData->rejected_status,
                            // 'payment_for' =>  $rowData->payment_for,
                            'online_id' =>  $rowData->id,
                            'online_client_id' =>  $rowData->client_id
                        ]
                    );
                $lid = DB::getPdo()->lastInsertId();


                $affected = DB::table('payment_recieved_from_client_online')
                    ->where('id', $rowData->id)
                    ->update([
                        'offline_id' => $lid,
                        'is_done' => 1
                    ]);
            }
        }
        echo $i;
    }
    //online2OfflinePaymentRecievedMerge


    //online2OfflineSamplesFormulationMerge
    public static function online2OfflineSamplesFormulationMerge()
    {
        $client_arrBOM = DB::table('samples_formula_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {
            $bomFormID = $rowData->sample_id;

            $QCFormArr = DB::table('samples')->where('on_sample_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {


                $i++;
                DB::table('samples_formula')
                    ->updateOrInsert(
                        ['online_id' => $QCFormArr->id, 'user_id' => $rowData->user_id],
                        [
                            'sample_id' =>  $QCFormArr->id,
                            'sample_code_with_part' =>   $rowData->sample_code_with_part,
                            'key_ingredent' =>  $rowData->key_ingredent,
                            'fragrance' =>  $rowData->fragrance,
                            'color_val' =>  $rowData->color_val,
                            'ph_val' =>  $rowData->ph_val,
                            'apperance_val' =>  $rowData->apperance_val,
                            'chemist_id' =>  $rowData->chemist_id,
                            'created_on' =>  $rowData->created_on,
                            'created_by' =>  $rowData->created_by,
                            'item_name' =>  $rowData->item_name,
                            'is_old_script' =>  $rowData->is_old_script,
                            'client_name' =>  $rowData->client_name,
                            'sales_user' =>  $rowData->sales_user,
                            'sample_created_at' =>  $rowData->sample_created_at,
                            'sample_feeback' =>  $rowData->sample_feeback,
                            'formulated_on' =>  $rowData->formulated_on,
                            'online_id' =>  $rowData->id,




                        ]
                    );

                $affected = DB::table('samples_formula_online')
                    ->where('sample_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->id,
                        'is_done' => 1
                    ]);
            }
        }
    }
    //online2OfflineSamplesFormulationMerge

    //st_process_action_6

    //online2OfflineSamplesStagesMerge
    public static function online2OfflineSamplesStagesMerge()
    {
        $client_arrBOM = DB::table('st_process_action_6_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {

            $bomFormID = $rowData->ticket_id;
            $QCFormArr = DB::table('samples')->where('on_sample_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {

                $i++;
                DB::table('st_process_action_6')
                    ->updateOrInsert(
                        ['ticket_id' => $QCFormArr->id, 'stage_id' => $rowData->stage_id],
                        [
                            'process_id' =>  $rowData->process_id,
                            'stage_id' =>   $rowData->stage_id,
                            'action_on' =>  $rowData->action_on,
                            //  'ticket_id' =>  $rowData->ticket_id,
                            'dependent_ticket_id' =>   $rowData->dependent_ticket_id,
                            'ticket_name' =>   $rowData->ticket_name,
                            'created_at' =>   $rowData->created_at,
                            'expected_date' =>   $rowData->expected_date,
                            'remarks' =>   $rowData->remarks,
                            'attachment_id' =>   $rowData->attachment_id,
                            'assigned_id' =>   $rowData->assigned_id,
                            'undo_status' =>   $rowData->undo_status,
                            'updated_by' =>   $rowData->updated_by,
                            'created_status' =>   $rowData->created_status,
                            'completed_by' =>   $rowData->completed_by,
                            'statge_color' =>   $rowData->statge_color,
                            //    'action_mark' =>   $rowData->action_mark,    
                            //    'action_status' =>   $rowData->action_status,    
                            //    'completed_on' =>   $rowData->completed_on,    
                            //'is_dispatched' =>   $rowData->is_dispatched,    

                        ]
                    );

                $affected = DB::table('st_process_action_6_online')
                    ->where('ticket_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->id,
                        'is_done' => 1
                    ]);
            }
        }
        echo $i;
    }
    //online2OfflineSamplesStagesMerge


    //online2OfflineSamplesMerge
    public static function online2OfflineSamplesMerge()
    {
        $client_arr = DB::table('samples_online')->where('is_deleted', 0)->where('is_done', 0)->get();
        foreach ($client_arr as $key => $rowData) {  //626  

            //$sample_index = DB::table('samples')->max('sample_index') + 1;

            DB::table('samples')
                ->updateOrInsert(
                    ['on_sample_id' => $rowData->id],
                    [
                        'created_at' => $rowData->created_at,
                        'is_deleted' => $rowData->is_deleted,
                        'sample_index' => $rowData->sample_index,
                        'sample_code' => $rowData->sample_code,
                        'yr' => $rowData->yr,
                        'mo' => $rowData->mo,
                        'client_id' => $rowData->client_id,
                        'sample_details' => $rowData->sample_details,
                        'courier_id' => $rowData->courier_id,
                        'track_id' => $rowData->track_id,
                        'updated_at' => $rowData->updated_at,
                        'status' => $rowData->status,
                        'sample_dispacth_type' => $rowData->sample_dispacth_type,
                        'created_by' => $rowData->created_by,
                        'remarks' => $rowData->remarks,
                        'feedback' => $rowData->feedback,
                        'sent_on' => $rowData->sent_on,
                        'ship_address' => $rowData->ship_address,
                        'ship_contact' => $rowData->ship_contact,
                        'location' => $rowData->location,
                        'courier_remarks' => $rowData->courier_remarks,
                        'sample_feedback' => $rowData->sample_feedback,
                        'sample_feedback_other' => $rowData->sample_feedback_other,
                        'feedback_addedon' => $rowData->feedback_addedon,
                        'sample_from' => $rowData->sample_from,
                        'QUERY_ID' => $rowData->QUERY_ID,
                        'lead_sample_type' => $rowData->lead_sample_type,
                        'have_order' => $rowData->have_order,
                        'client_owner_too' => $rowData->client_owner_too,
                        'sample_type' => $rowData->sample_type,
                        'sample_v' => $rowData->sample_v,
                        'order_count' => $rowData->order_count,
                        'lead_name' => $rowData->lead_name,
                        'lead_phone' => $rowData->lead_phone,
                        'lead_company' => $rowData->lead_company,
                        'track_updatedby' => $rowData->track_updatedby,
                        'track_updatedon' => $rowData->track_updatedon,
                        'contact_phone' => $rowData->contact_phone,
                        'chkHandedOver' => $rowData->chkHandedOver,
                        'process_status' => $rowData->process_status,
                        'created_by_ori' => $rowData->created_by_ori,
                        'sample_stage_id' => $rowData->sample_stage_id,
                        'sample_FM' => $rowData->sample_FM,
                        'sample_fragrance' => $rowData->sample_fragrance,
                        'sample_color' => $rowData->sample_color,
                        'sample_chemist' => $rowData->sample_chemist,
                        'sample_notes' => $rowData->sample_notes,
                        'assingned_to' => $rowData->assingned_to,
                        'assingned_by' => $rowData->assingned_by,
                        'assingned_on' => $rowData->assingned_on,
                        'assingned_notes' => $rowData->assingned_notes,
                        'assingned_name' => $rowData->assingned_name,
                        'formatation_status' => $rowData->formatation_status,
                        'sample_assigned_to' => $rowData->sample_assigned_to,
                        'sample_assigned_on' => $rowData->sample_assigned_on,
                        'modify_sample_code' => $rowData->modify_sample_code,
                        'is_formulated' => $rowData->is_formulated,
                        'is_bypart' => $rowData->is_bypart,
                        'is_tech_done' => $rowData->is_tech_done,
                        'is_done_stoi' => $rowData->is_done_stoi,
                        'is_rejected' => $rowData->is_rejected,
                        'is_rejected_msg' => $rowData->is_rejected_msg,
                        'price_per_kg' => $rowData->price_per_kg,
                        'brand_type' => $rowData->brand_type,
                        'order_size' => $rowData->order_size,
                        'admin_urgent_status' => $rowData->admin_urgent_status,
                        'admin_urgent_remarks' => $rowData->admin_urgent_remarks,
                        //'update_today' => $rowData->update_today,
                        //'is_paid' => $rowData->is_paid,
                        //'modi_sample_id' => $rowData->modi_sample_id,
                        'on_sample_id' => $rowData->id,
                        'on_client_id' => $rowData->client_id,





                    ]
                );

            $lid = DB::getPdo()->lastInsertId();

            $affected = DB::table('samples_online')
                ->where('id', $rowData->id)
                ->update([
                    'off_sample_id' => $lid, //new created id 
                    'online_client_in' => $rowData->client_id,
                    'is_done' => 1,
                ]);
        }
    }
    //online2OfflineSamplesMerge


    //online to offline 
    //online2OfflineOrderMerge
    public static function online2OfflineOrderMerge()
    {
        $client_arr = DB::table('qc_forms_online')->where('is_deleted', 0)->whereNull('new_off_form_id')->get();

        foreach ($client_arr as $key => $rowData) {  //359           

            DB::table('qc_forms')
                ->updateOrInsert(
                    ['online_form_id' => $rowData->form_id],
                    [
                        'is_deleted' => $rowData->is_deleted,
                        'created_by' => $rowData->created_by,
                        'dispatch_status' => $rowData->dispatch_status,
                        'order_id' => $rowData->order_id,
                        'dis_type' => $rowData->dis_type,
                        'subOrder' => $rowData->subOrder,
                        'yr' => $rowData->yr,
                        'mo' => $rowData->mo,
                        'item_sp' => $rowData->item_sp,
                        'item_qty' => $rowData->item_qty,
                        'brand_name' => $rowData->brand_name,
                        // 'client_id' => null,
                        'order_repeat' => $rowData->order_repeat,
                        'pre_order_id' => $rowData->pre_order_id,
                        'item_name' => $rowData->item_name,
                        'item_size' => $rowData->item_size,
                        'item_size_unit' => $rowData->item_size_unit,
                        'item_qty_unit' => $rowData->item_qty_unit,
                        'item_fm_sample_no' => $rowData->item_fm_sample_no,
                        'item_sp_unit' => $rowData->item_sp_unit,
                        'created_at' => $rowData->created_at,
                        'design_client' => $rowData->design_client,
                        'bottle_jar_client' => $rowData->bottle_jar_client,
                        'lable_client' => $rowData->lable_client,
                        'order_type' => $rowData->order_type,
                        'production_rmk' => $rowData->production_rmk,
                        'packeging_rmk' => $rowData->packeging_rmk,
                        'export_domestic' => $rowData->export_domestic,
                        'order_currency' => $rowData->order_currency,
                        'exchange_rate' => $rowData->exchange_rate,
                        'order_fragrance' => $rowData->order_fragrance,
                        'lr_no' => $rowData->lr_no,
                        'transport' => $rowData->transport,
                        'cartons' => $rowData->cartons,
                        'unit_in_each_carton' => $rowData->unit_in_each_carton,
                        'total_unit' => $rowData->total_unit,
                        'dispatch_remarks' => $rowData->dispatch_remarks,
                        'txtBookingFor' => $rowData->txtBookingFor,
                        'txtPONumber' => $rowData->txtPONumber,
                        'txtInvoice' => $rowData->txtInvoice,
                        'dispatch_by' => $rowData->dispatch_by,
                        'dispatch_on' => $rowData->dispatch_on,
                        'artwork_status' => $rowData->artwork_status,
                        'artwork_start_date' => $rowData->artwork_start_date,
                        'client_email' => $rowData->client_email,
                        'client_phone' => $rowData->client_phone,
                        'production_curr_statge' => $rowData->production_curr_statge,
                        'qc_from_bulk' => $rowData->qc_from_bulk,
                        'bulk_order_value' => $rowData->bulk_order_value,
                        'commited_date' => $rowData->commited_date,
                        'pack_img_url' => $rowData->pack_img_url,
                        'since_from' => $rowData->since_from,
                        'client_owner_too' => $rowData->client_owner_too,
                        'account_approval' => $rowData->account_approval,
                        'account_msg' => $rowData->account_msg,
                        'account_approved_on' => $rowData->account_approved_on,
                        'curr_stage_id' => $rowData->curr_stage_id,
                        'curr_stage_updated_on' => $rowData->curr_stage_updated_on,
                        'curr_stage_name' => $rowData->curr_stage_name,
                        'bo_bulk_cound' => $rowData->bo_bulk_cound,
                        'order_type_v1' => $rowData->order_type_v1,
                        'created_by_ori' => $rowData->created_by_ori,
                        'modification_remarks_updatedby_lasttime' => $rowData->modification_remarks_updatedby_lasttime,
                        'modification_remarks' => $rowData->modification_remarks,
                        'item_RM_Price' => $rowData->item_RM_Price,
                        'item_BCJ_Price' => $rowData->item_BCJ_Price,
                        'item_Label_Price' => $rowData->item_Label_Price,
                        'item_Material_Price' => $rowData->item_Material_Price,
                        'item_LabourConversion_Price' => $rowData->item_LabourConversion_Price,
                        'item_Margin_Price' => $rowData->item_Margin_Price,
                        'price_part_status' => $rowData->price_part_status,
                        'bulkOrderTypeV1' => $rowData->bulkOrderTypeV1,
                        'artwork_approval_status' => $rowData->artwork_approval_status,
                        'client_from' => 0,
                        'builk_item_data' => null,
                        'online_form_id' => $rowData->form_id,
                        'on_client_id' => $rowData->client_id



                    ]
                );

            $lid = DB::getPdo()->lastInsertId();

            $affected = DB::table('qc_forms_online')
                ->where('form_id', $rowData->form_id)
                ->update([
                    'new_off_form_id' => $lid, //new created id 
                    'online_cid' => $rowData->client_id,
                ]);
        }
    }
    //online2OfflineOrderMerge
    //online2OfflineSamplesClientMerge
    public static function online2OfflineSamplesClientMerge()
    {
        $client_arr = DB::table('samples')->where('is_deleted', 0)->whereNotNull('on_client_id')->get();


        foreach ($client_arr as $key => $rowData) {
            $online_cid = $rowData->on_client_id;
            $client_arrORI = DB::table('clients')->where('on_id', $online_cid)->first();
            if ($client_arrORI == null) {
                // $affected = DB::table('samples')
                // ->where('id', $rowData->id)
                // ->update(['client_id' => $rowData->client_id]);

            } else {
                $affected = DB::table('samples')
                    ->where('id', $rowData->id)
                    ->update(['client_id' => $client_arrORI->id]);
            }
        }
    }

    //online2OfflineSamplesClientMerge

    // updateClientIDfromOnlineToOffline
    public static function updateClientIDfromOnlineToOffline()
    {
        $client_arr = DB::table('qc_forms')->where('is_deleted', 0)->whereNotNull('on_client_id')->get();


        foreach ($client_arr as $key => $rowData) {
            $online_cid = $rowData->on_client_id;
            $client_arrORI = DB::table('clients')->where('on_id', $online_cid)->first();
            if ($client_arrORI != null) {
                // echo "44";
                // die;
                $affected = DB::table('qc_forms')
                    ->where('form_id', $rowData->form_id)
                    ->update(['client_id' => $client_arrORI->id]);
            }
        }
    }


    //online2OfflineOrderStagesMerge
    public static function online2OfflineOrderStagesMerge()
    {
        $client_arrBOM = DB::table('st_process_action_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {

            $bomFormID = $rowData->ticket_id;
            $QCFormArr = DB::table('qc_forms')->where('online_form_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {
                $i++;
                DB::table('st_process_action')
                    ->updateOrInsert(
                        ['ticket_id' => $QCFormArr->form_id, 'stage_id' => $rowData->stage_id],
                        [
                            'process_id' =>  $rowData->process_id,
                            'stage_id' =>   $rowData->stage_id,
                            'action_on' =>  $rowData->action_on,
                            //  'ticket_id' =>  $rowData->ticket_id,
                            'dependent_ticket_id' =>   $rowData->dependent_ticket_id,
                            'ticket_name' =>   $rowData->ticket_name,
                            'created_at' =>   $rowData->created_at,
                            'expected_date' =>   $rowData->expected_date,
                            'remarks' =>   $rowData->remarks,
                            'attachment_id' =>   $rowData->attachment_id,
                            'assigned_id' =>   $rowData->assigned_id,
                            'undo_status' =>   $rowData->undo_status,
                            'updated_by' =>   $rowData->updated_by,
                            'created_status' =>   $rowData->created_status,
                            'completed_by' =>   $rowData->completed_by,
                            'statge_color' =>   $rowData->statge_color,
                            'action_mark' =>   $rowData->action_mark,
                            'action_status' =>   $rowData->action_status,
                            'completed_on' =>   $rowData->completed_on,
                            'is_dispatched' =>   $rowData->is_dispatched,

                        ]
                    );

                $affected = DB::table('st_process_action_online')
                    ->where('ticket_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->form_id,
                        'is_done' => 1
                    ]);
            }
        }
    }
    //online2OfflineOrderStagesMerge

    //online2OfflineOrderBOMMerge
    public static function online2OfflineOrderBOMMerge()
    {
        $client_arrBOM = DB::table('qc_forms_bom_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {

            $bomFormID = $rowData->form_id;
            $QCFormArr = DB::table('qc_forms')->where('online_form_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {
                $i++;
                // insert form bom
                DB::table('qc_forms_bom')
                    ->updateOrInsert(
                        ['form_id' => $QCFormArr->form_id, 'm_name' => $rowData->m_name],
                        [
                            'form_id' =>  $QCFormArr->form_id,
                            'm_name' =>   $rowData->m_name,
                            'qty' =>  $rowData->qty,
                            'size' =>  $rowData->size,
                            'bom_from' =>   $rowData->bom_from,
                            'bom_cat' =>   $rowData->bom_cat,


                        ]
                    );


                $affected = DB::table('qc_forms_bom_online')
                    ->where('form_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->form_id,
                        'is_done' => 1
                    ]);
            }
        }
        echo "44" . $i;
    }

    //online2OfflineOrderBOMMerge
    //online2OfflineOrderPrivatePackingMerge
    //online2OfflineOrderPrivatePackingMerge
    public static function online2OfflineOrderPrivatePackingMerge()
    {
        $client_arrBOM = DB::table('qc_forms_packing_process_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {

            $bomFormID = $rowData->qc_from_id;
            $QCFormArr = DB::table('qc_forms')->where('online_form_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {
                $i++;
                // echo bomFormID;

                DB::table('qc_forms_packing_process')
                    ->updateOrInsert(
                        ['qc_from_id' => $QCFormArr->form_id, 'qc_label' => $rowData->qc_label],
                        [
                            'qc_from_id' =>  $QCFormArr->form_id,
                            'qc_label' =>   $rowData->qc_label,
                            'qc_yes' =>  $rowData->qc_yes,
                            'qc_no' =>  $rowData->qc_no,
                            // 'qc_remarks' =>   $rowData->qc_remarks,                       ,    
                            'on_form_id' =>   $bomFormID,


                        ]
                    );

                $affected = DB::table('qc_forms_packing_process_online')
                    ->where('qc_from_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->form_id,
                        'is_done' => 1
                    ]);
            }
        }
    }

    //online2OfflineOrderBulkMerge
    public static function online2OfflineOrderBulkMerge()
    {
        $client_arrBOM = DB::table('qc_bulk_order_form_online')->where('is_done', 0)->get();
        $i = 0;
        foreach ($client_arrBOM as $key => $rowData) {

            $bomFormID = $rowData->form_id;
            $QCFormArr = DB::table('qc_forms')->where('online_form_id', $bomFormID)->first();
            if ($QCFormArr == null) {
                echo $bomFormID;
                echo "<br>";
            } else {
                $i++;

                DB::table('qc_bulk_order_form')
                    ->updateOrInsert(
                        ['form_id' => $QCFormArr->form_id, 'item_name' => $rowData->item_name],
                        [
                            'form_id' =>  $QCFormArr->form_id,
                            'item_name' =>   $rowData->item_name,
                            'qty' =>  $rowData->qty,
                            'item_sell_p' =>  $rowData->item_sell_p,
                            'item_size' =>   $rowData->item_size,
                            'packing' =>   $rowData->packing,
                            'rate' =>   $rowData->rate,
                            'on_form_id' =>   $bomFormID,


                        ]
                    );


                $affected = DB::table('qc_bulk_order_form_online')
                    ->where('form_id', $bomFormID)
                    ->update([
                        'off_form_id' => $QCFormArr->form_id,
                        'is_done' => 1
                    ]);
            }
        }
    }
    //online2OfflineOrderBulkMerge


    // online2OfflineClientMerge
    public static function online2OfflineClientMerge()
    {
        $client_arr = DB::table('clients_online')->where('is_deleted', 0)->whereNull('off_id')->get();

        foreach ($client_arr as $key => $rowData) {

            DB::table('clients')
                ->updateOrInsert(
                    ['on_id' => $rowData->id],
                    [
                        'created_at' => $rowData->created_at,
                        'added_by' => $rowData->added_by,
                        'firstname' => $rowData->firstname,
                        'follow_date' => $rowData->follow_date,
                        'last_note_updated' => $rowData->last_note_updated,
                        'email' => $rowData->email,
                        'company' => $rowData->company,
                        'brand' => $rowData->brand,
                        'address' => $rowData->address,
                        'gstno' => $rowData->gstno,
                        'lastname' => $rowData->lastname,
                        'phone' => $rowData->phone,
                        'is_deleted' => $rowData->is_deleted,
                        'status' => $rowData->status,
                        'remarks' => $rowData->remarks,
                        'group_status' => $rowData->group_status,
                        'city' => $rowData->city,
                        'country' => $rowData->country,
                        'location' => $rowData->location,
                        'source' => $rowData->source,
                        'website' => $rowData->website,
                        'manage_by' => $rowData->manage_by,
                        'user_id' => $rowData->user_id,
                        'temp_deleted' => $rowData->temp_deleted,
                        'client_owner_too' => $rowData->client_owner_too,
                        'mark_raw_material' => $rowData->mark_raw_material,
                        'have_order' => $rowData->have_order,
                        'have_order_count' => $rowData->have_order_count,
                        'is_lead' => $rowData->is_lead,
                        'lead_statge' => $rowData->lead_statge,
                        'lead_QUERY_ID' => null,
                        'added_name' => null,
                        'client_from' => 0,
                        'stage_status' => null,
                        'is_online_created' => 1
                    ]
                );

            $lid = DB::getPdo()->lastInsertId();

            $affected = DB::table('clients_online')
                ->where('id', $rowData->id)
                ->update([
                    'off_id_new' => $lid,
                    'off_id' => 9999999,
                    'is_done' => 1
                ]);
        }
    }
    // online2OfflineClientMerge

    public static function online2OfflineClient()
    {
        $client_arr = DB::table('clients_online')->where('is_deleted', 0)->get();
        foreach ($client_arr as $key => $rowData) {
            $client_arrEmail = DB::table('clients')->where('is_deleted', 0)->where('email', $rowData->email)->whereNotNull('email')->first();
            if ($client_arrEmail != null) {

                $affected = DB::table('clients_online')
                    ->where('id', $rowData->id)
                    ->update([
                        'off_id' => $client_arrEmail->id,
                        'is_offline_exit' => 1,
                        'is_done' => 1,

                    ]);
                $affected = DB::table('clients')
                    ->where('id', $client_arrEmail->id)
                    ->update([
                        'on_id' => $rowData->id,


                    ]);
            }
            $client_arrPhone = DB::table('clients')->where('is_deleted', 0)->where('phone', $rowData->phone)->whereNotNull('phone')->first();
            if ($client_arrPhone != null) {

                $affected = DB::table('clients_online')
                    ->where('id', $rowData->id)
                    ->update([
                        'off_id' => $client_arrPhone->id,
                        'is_offline_exit' => 1,
                        'is_done' => 1,
                    ]);
                $affected = DB::table('clients')
                    ->where('id', $client_arrPhone->id)
                    ->update([
                        'on_id' => $rowData->id,


                    ]);
            }



            $client_arrCompany = DB::table('clients')->where('is_deleted', 0)->where('company', $rowData->company)->whereNotNull('company')->first();
            if ($client_arrCompany != null) {

                $affected = DB::table('clients_online')
                    ->where('id', $rowData->id)
                    ->update([
                        'off_id' => $client_arrCompany->id,
                        'is_offline_exit' => 1,
                        'is_done' => 1,
                    ]);

                $affected = DB::table('clients')
                    ->where('id', $client_arrCompany->id)
                    ->update([
                        'on_id' => $rowData->id,


                    ]);
            }
        }
    }

    // online to offline 

    public static function getOrderOLDData($form_id, $action)
    {

        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('form_id', $form_id)->first();

        if ($action == 1) {
            $update_id = DB::table('order_edit_requests_history')->max('id') + 1;

            DB::table('order_edit_requests_history')->insert([
                'form_id' => $form_id,
                'old_data' => json_encode($datas),
                'created_by' => Auth::user()->id,
                'order_type' => 1,
                'update_id' => $update_id,

            ]);
        }
        return $update_id;
    }

    public static function getOrderOLDDataUpdate($form_id, $update_id)
    {


        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('form_id', $form_id)->first();
        //print_r($datas);
        $newdata = json_encode($datas);

        $affected = DB::table('order_edit_requests_history')
            ->where('id', $update_id)
            ->update([
                'new_data' => $newdata
            ]);



        return $update_id;
    }

    //bulk order 
    public static function getOrderOLDDataBULK($form_id, $action)
    {

        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('form_id', $form_id)->first();
        $datasBULK = DB::table('qc_bulk_order_form')->where('form_id', $form_id)->first();

        if ($action == 1) {
            $update_id = DB::table('order_edit_requests_history')->max('id') + 1;

            DB::table('order_edit_requests_history')->insert([
                'form_id' => $form_id,
                'old_data' => json_encode($datas),
                'bulk_form_data' => json_encode($datasBULK),
                'created_by' => Auth::user()->id,
                'order_type' => 2,
                'update_id' => $update_id,

            ]);
        }
        return $update_id;
    }

    public static function getOrderOLDDataUpdateBULK($form_id, $update_id)
    {


        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('form_id', $form_id)->first();
        $datasBULK = DB::table('qc_bulk_order_form')->where('form_id', $form_id)->first();

        //print_r($datas);
        $newdata = json_encode($datas);
        $newdataBULK = json_encode($datasBULK);

        $affected = DB::table('order_edit_requests_history')
            ->where('id', $update_id)
            ->update([
                'new_data' => $newdata,
                'bulk_form_data_new' => $newdataBULK

            ]);



        return $update_id;
    }

    //bulk order 




    public static function getLeadDataByID($id)
    {
        $user_arr = DB::table('clients')->where('id', $id)->where('is_deleted', '!=', 1)->first();


        return $user_arr;
    }

    public static function getMyAllClientV1() //leasd as cleint
    {
        $client_arr = DB::table('clients')->where('is_deleted', 0)->where('group_status', '!=', 6)->where('temp_deleted', 0)->get();
        $i = 0;

        foreach ($client_arr as $key => $row) {
            $i++;

            $DATE_TIME_RE = date("d-M-Y H:i:s A", strtotime($row->created_at));
            $QUERY_ID = AyraHelp::getSALE_QUERYID();

            // DB::table('clients_as_lead')->insert(
            //     [

            //         'created_at' => $row->created_at,
            //         'added_by' => $row->added_by,
            //         'firstname' => $row->firstname,
            //         'follow_date' => $row->follow_date,
            //         'last_note_updated' => $row->last_note_updated,
            //         'email' => $row->email,
            //         'company' => $row->company,
            //         'brand' => $row->brand,
            //         'address' => $row->address,
            //         'gstno' => $row->gstno,
            //         'lastname' => $row->lastname,
            //         'phone' => $row->phone,
            //         'is_deleted' =>$row->is_deleted,
            //         //'is_lost' => $row->is_lost,
            //         'remarks' => $row->remarks,
            //         'stage_status' => 1,
            //         'city' => $row->city,
            //         'country' => $row->country,
            //         'location' =>$row->location,
            //         'source' => $row->source,
            //         'website' =>$row->website,
            //         'manage_by' => $row->added_by,
            //         'user_id' => $row->user_id,
            //         'lead_ori_owner' => $row->added_by,
            //         'have_order' =>$row->have_order,
            //         'have_order_count' => $row->have_order_count,
            //         'added_by_name' => AyraHelp::getUser($row->added_by)->name,
            //         'is_sample_active' => 1,
            //         'is_client_active' => $row->have_order==1 ? 1:0,
            //         'lead_status' => 1,
            //         'old_cid' => $row->id


            //     ]
            // );
            // $lid = DB::getPdo()->lastInsertId();
            //save to st_process_action_5_mylead
            DB::table('st_process_sales_lead_v1')->insert(
                [
                    'process_id' => 7,
                    'stage_id' => 1,
                    'action_on' => 1,
                    'ticket_id' => $row->id,
                    'remarks' => 'Migrated',
                    'assigned_id' => $row->added_by,
                    'updated_by' => $row->added_by,
                    'completed_by' => $row->added_by,
                    'created_at' => $row->created_at,
                    'expected_date' => $row->created_at,

                ]
            );
            //save to st_process_action_5_mylead
            // $affected = DB::table('clients')
            // ->where('id', $row->id)
            // ->update(['temp_deleted' => 1]);
            $affected = DB::table('clients')
                ->where('id', $row->id)
                ->update(['added_name' => AyraHelp::getUser($row->added_by)->name]);

            //  ///save to st_process_action_5_mylead
            // $affected = DB::table('qc_forms')
            // ->where('client_id', $row->id)
            // ->update(['lead_id' => $lid]);



        }
        echo $i;

        //print_r($orderHave);



    }


    //getMasterStageResponseSALESLEAD
    public static function getMasterStageResponseSALESLEAD($process_id, $ticket_id)
    {

        $stage_data = AyraHelp::getStagesListSALESLEAD($process_id, $ticket_id);
        $data_action_done_arr = AyraHelp::getSalesLeadStageProcessCompletedHistory($process_id, $ticket_id);

        $data_arr = array(
            'stages_info' => $stage_data,



            'stage_action_data' => $data_action_done_arr, //0 not 1 accesabe


        );
        return response()->json($data_arr);
    }
    //getMasterStageResponseSALESLEAD


    //getStagesListSALESLEAD
    public static function getStagesListSALESLEAD($process_id, $ticket_id)
    {



        if ($process_id == 7) {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5, 6, 7];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================

                        $get_stage_data = AyraHelp::getStageActionSALESLEAD($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe                           
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );
                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageActionSALESLEAD($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                    } else {
                        $stage_started = 1;
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe                      


                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }

            return $data_arr;
        }
    }

    //getStagesListSALESLEAD

    //getStageActionSALESLEAD
    public static function getStageActionSALESLEAD($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_sales_lead_v1')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }

    //getStageActionSALESLEAD
    //getSalesLeadStageProcessCompletedHistory
    public static function getSalesLeadStageProcessCompletedHistory($process_id, $ticket_id)
    {
        $process_data = DB::table('st_process_sales_lead_v1')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();

        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {
                $i++;

                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                $stage_data2 = optional($stage_arrData)->stage_name;

                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_data2,
                    'msg' => $rowData->remarks,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }

    //getSalesLeadStageProcessCompletedHistory



    //getTotalLeadClaimCount
    public static function getTotalLeadClaimCount($from, $to, $userid)
    {
        $datas = DB::table('indmt_data')->where('lead_status', '!=', 0)->where('assign_to', $userid)->whereNotNull('assign_on')->whereBetween('assign_on', [$from, $to])->whereYear('assign_on', date('Y'))->count();
        return $datas;
    }

    //getTotalLeadClaimCount
    //getTotalSampleCount
    public static function getTotalSampleCount($from, $to, $userid)
    {
        $datas = DB::table('samples')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->count();
        return $datas;
    }

    //getTotalSampleCount

    //getTotalCallCount
    public static function getTotalCallCount($from, $to, $userid)
    {
        $datas = DB::table('agent_calldata')->where('user_id', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->count();
        return $datas;
    }

    //getTotalCallCount

    //getTotalOrdersCount
    public static function getTotalOrdersCount($from, $to, $userid)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->count();



        return $datas;
    }

    //getTotalOrdersCount
    public static function getTotalOrdersValueByFormID($form_id)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('form_id', $form_id)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }

    public static function getTotalOrderPL($month,$year)
    {



        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                // $sum = $rowData->bulk_order_value;
                // $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }
    //getTotalOrderPL_COUNT
    public static function getTotalOrderPL_COUNT($month,$year)
    {

        $i=0;

        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                // $sum = $rowData->bulk_order_value;
                // $sumTotal = $sum + $sumTotal;
            } else {
                $i++;
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $i;
    }

    //getTotalOrderPL_COUNT


    public static function getTotalOrderBULK($month,$year)
    {



        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                // $sum = $rowData->item_qty * $rowData->item_sp;
                // $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }

    //getTotalOrderBULK_COUNT
    public static function getTotalOrderBULK_COUNT($month,$year)
    {

        $i=0;

        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
                $i++;
            } else {
                // $sum = $rowData->item_qty * $rowData->item_sp;
                // $sumTotal = $sum + $sumTotal;
            }
        }
        return $i;
    }

    //getTotalOrderBULK_COUNT

    public static function getTotalOrderUNIT($month,$year)
    {

        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $totalUnit = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $totalUnit = $totalUnit + $row->qty;
                }
            } else {
                $totalUnit = $totalUnit + $rowData->item_qty;
            }
        }
        return $totalUnit;
    }
    //getTotalOrderUNIT_PL
    public static function getTotalOrderUNIT_PL($month,$year)
    {

        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $totalUnit = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                // $bulkOrder = DB::table('qc_bulk_order_form')
                //     ->where('form_id', $rowData->form_id)
                //     ->whereNotNull('item_name')
                //     ->get();
                // foreach ($bulkOrder as $key => $row) {
                //     $totalUnit = $totalUnit + $row->qty;
                // }
            } else {
                $totalUnit = $totalUnit + $rowData->item_qty;
            }
        }
        return $totalUnit;
    }

    //getTotalOrderUNIT_PL


    //getTotalOrderBATCHSIZE
    public static function getTotalOrderBATCHSIZE($month,$year)
    {

        
        
        
        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $BatchSize = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $BatchSize = $BatchSize + $row->qty;
                }
            } else {
                $BatchSize =$BatchSize+ ($rowData->item_qty * $rowData->item_size) / 1000;
            }
        }
        return $BatchSize;
    }

    //getTotalOrderBATCHSIZE_PL
    public static function getTotalOrderBATCHSIZE_PL($month,$year)
    {

        
        
        
        $datas = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();


        $BatchSize = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $BatchSize = $BatchSize + $row->qty;
                }
            } else {
               // $BatchSize =$BatchSize+ ($rowData->item_qty * $rowData->item_size) / 1000;
            }
        }
        return $BatchSize;
    }

    //getTotalOrderBATCHSIZE_PL

    //getTotalOrderBATCHSIZE
    public static function getTotalPaymentDataAll($month,$year)
    {

        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->whereMonth('recieved_on', $month)->whereYear('recieved_on', $year)->get();
        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }

    //getTotalOrdersValueByCID
    public static function getTotalOrdersValueByCID($from, $to, $userid)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $userid)->whereBetween('created_at', [$from, $to])->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }

    //getTotalOrdersValueByCID

    //getTotalOrdersValue
    public static function getTotalOrdersValue($from, $to, $userid)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }

    //getTotalOrdersValue

    //getTotalNewOrders
    public static function getTotalNewOrders($from, $to, $userid)
    {
        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->where('order_type_v1', 1)->count();
        return $datas;
    }
    public static function getTotalRepeatOrders($from, $to, $userid)
    {
        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->where('order_type_v1', 2)->count();
        return $datas;
    }
    public static function getTotalAdditonOrders($from, $to, $userid)
    {
        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->where('order_type_v1', 3)->count();
        return $datas;
    }

    //getTotalNewOrders
    //getTotalRevenueBYCID
    public static function getTotalRevenueBYCID($from, $to, $userid)
    {


        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('client_id', $userid)->whereBetween('recieved_on', [$from, $to])->get();





        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }
    //getTotalRevenueBYCID

    // getTotalRevenue
    public static function getTotalRevenue($from, $to, $userid)
    {


        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereBetween('recieved_on', [$from, $to])->whereYear('recieved_on', date('Y'))->get();





        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }

    // getTotalRevenue
    //getRepeatOrderPercentage
    public static function getRepeatOrderPercentageALL($user_id, $monthId, $year)
    {
        $qc_data = DB::table('qc_forms')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->count();

        return  $qc_data;
    }
    public static function getRepeatOrderPercentage($user_id, $monthId, $year)
    {
        $qc_data = DB::table('qc_forms')->where('order_type_v1', 2)->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->count();

        return  $qc_data;
    }
    //getRepeatOrderPercentage

    //getPAdditonPercentageALL
    public static function getPAdditonPercentageALL($user_id, $monthId, $year)
    {
        $qc_data = DB::table('qc_forms')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->count();

        return  $qc_data;
    }

    public static function getPAdditonPercentage($user_id, $monthId, $year)
    {
        $qc_data = DB::table('qc_forms')->where('order_type_v1', 3)->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->count();

        return  $qc_data;
    }

    //getPAdditonPercentageALL
    //getNewOrderAdded
    public static function getNewOrderAdded($user_id, $monthId, $year)
    {
        $qc_data = DB::table('payment_recieved_from_client')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('recieved_on', '=', $year)->whereMonth('recieved_on', '=', $monthId)->where('payment_status', 1)->orderBy('recieved_on', 'asc')->distinct()->get('client_id');
        $i = 0;
        foreach ($qc_data as $key => $row) {

            $data = AyraHelp::checkClientNewOrNot($row->client_id, $monthId, $year);
            // print_r($data);
            // echo "<br>";
            if ($data <= 0) {
                $i++;
            }
        }
        return $i;
    }
    public static function checkClientNewOrNot($clientID, $monthId, $year)
    {
        $dateCurDate = date('Y-m-d', strtotime('01-' . $monthId . "-" . $year));
        $qc_data = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('client_id', $clientID)->whereYear('recieved_on', '<', $dateCurDate)->where('payment_status', 1)->orderBy('recieved_on', 'asc')->count();
        return $qc_data;
    }

    //getNewOrderAdded

    //getMinProductAdditon

    public static function getMinProductAdditon($user_id, $monthId, $year)
    {
        $qc_data = DB::table('qc_forms')->where('order_type_v1', 3)->select('form_id', 'bulk_order_value', 'qc_from_bulk', 'item_sp', 'item_qty', 'form_id')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->count();

        return  $qc_data;
    }
    //getClientCountwithAllPaymentRecieved

    public static function getClientCountwithAllPaymentRecieved($user_id, $monthId, $year)
    {
        //    echo "<pre>";
        //      DB::enableQueryLog(); // Enable query log

        $qc_data = DB::table('qc_forms')->distinct()->where('created_by', $user_id)->where('is_deleted', 0)->get('client_id');
        //dd(DB::getQueryLog()); // Show results of log
        $t_client = count($qc_data);


        $pay_client = DB::table('payment_recieved_from_client')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('payment_status', 1)->distinct()->get('client_id');
        $t_client_payment = count($pay_client);




        return array('t_client' => $t_client, 'tpay' => $t_client_payment);
    }

    //getClientCountwithAllPaymentRecieved


    //getMinProductAdditon

    //getMinOrderValue
    public static function getMinOrderValue($user_id, $monthId, $year)
    {
        $i = 0;

        $qc_data = DB::table('qc_forms')->select('form_id', 'bulk_order_value', 'qc_from_bulk', 'item_sp', 'item_qty', 'form_id')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->get();
        //        echo "<pre>";
        //    print_r($qc_data);
        //    die;


        foreach ($qc_data as $key => $row) {
            if (isset($row->qc_from_bulk)) {
                if ($row->qc_from_bulk == 1) {
                    $me = $row->bulk_order_value;
                } else {
                    $me = ($row->item_sp) * ($row->item_qty);
                }
            } else {
                $me = ($row->item_sp) * ($row->item_qty);
            }

            if ($me >= 75000) {
                $i++;
            }
        }


        return  $i;
    }

    //getMinOrderValue

    public static function getNewClient($user_id, $monthId, $year)
    {
        $i = 0;
        //echo "<pre>";
        $paymentOrderArr = DB::table('qc_forms')->where('subOrder', 1)->select('client_id')->where('created_by', $user_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->where('account_approval', 1)->orderBy('form_id', 'desc')->get();
        // print_r($paymentOrderArr);
        // die;
        // echo count($paymentOrderArr);
        // die;


        foreach ($paymentOrderArr as $key => $rows) {
            $paymentOrderArr = DB::table('clients')->where('id', $rows->client_id)->where('is_deleted', 0)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $monthId)->orderBy('id', 'desc')->first();
            if ($paymentOrderArr != null) {
                $i++;
            }
        }
        return  $i;
    }
    public static function getSMSBALPRP()
    {
        //$url = 'http://164.52.195.161/API/BalAlert.aspx?uname=20200871&pass=mYQG9ms9';

        //return  $data = file_get_contents($url); // put the contents of the file into a variable
        return 4;

    }

    //getPayoutDetails by amout 
    public static function getPayoutDetailByAmount($amount, $incentive_type_id)
    {
        //  $amount;
        //  $incentive_type_id;
        // echo $amount;
        $incentive_payout_percentage =
            DB::table('incentive_payout_percentage')
            ->where('incentive_type_id', '=', $incentive_type_id)
            ->where('target_start', '<=', $amount)
            ->where('target_stop', '>=', $amount)

            ->first();






        return $incentive_payout_percentage;
    }
    //getSamplePendingListCount
    public static function getSamplePendingListCount()
    {


        $allAB = date('Y-m-d', strtotime("-31 days"));

        $D0_3days = DB::table('samples')->whereBetween('created_at', [date('Y-m-d'), date('Y-m-d', strtotime("-3 days"))])->count();
        $D4_7days = DB::table('samples')->whereBetween('created_at', [date('Y-m-d', strtotime("-4 days")), date('Y-m-d', strtotime("-7 days"))])->count();
        $D8_15days = DB::table('samples')->whereBetween('created_at', [date('Y-m-d', strtotime("-8 days")), date('Y-m-d', strtotime("-15 days"))])->count();
        $D16_30days = DB::table('samples')->whereBetween('created_at', [date('Y-m-d', strtotime("-16 days")), date('Y-m-d', strtotime("-30 days"))])->count();
        $D30_above = DB::table('samples')->whereDate('created_at', '>=', $allAB)->count();

        $data = array(
            '0_3days' => $D0_3days,
            '4_7days' => $D4_7days,
            '8_15days' => $D8_15days,
            '16_30days' => $D16_30days,
            '30_above' => $D30_above,

        );
        return $data;
    }
    //getSamplePendingListCount

    //getSampleActivityList
    public static function getSampleActivityList()
    {

        $todayA = new Carbon();
        if ($todayA->dayOfWeek == Carbon::MONDAY) {
            $dateOLD = Carbon::now()->subDays(2);
            $No_of_Samples_Added = DB::table('samples')->whereDate('created_at', $dateOLD)->count();
            $No_of_Samples_Dispatched = DB::table('st_process_action_6')->where('stage_id', 4)->where('action_on', 1)->whereDate('created_at', $dateOLD)->count();

            $Pending_Samples_of_Standard_Cosmetic = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 1)->count();
            $Pending_Samples_of_General_Changes = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 3)->count();
            $Pending_Samples_of_Modification = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 5)->count();
            $Pending_Samples_of_As_Per_Benchmark = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 4)->count();
            $Pending_Samples_of_Oils = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 2)->count();
        } else {
            $dateOLD = Carbon::yesterday();
            $No_of_Samples_Added = DB::table('samples')->whereDate('created_at', $dateOLD)->count();
            $No_of_Samples_Dispatched = DB::table('st_process_action_6')->where('stage_id', 4)->where('action_on', 1)->whereDate('created_at', $dateOLD)->count();

            $Pending_Samples_of_Standard_Cosmetic = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 1)->count();
            $Pending_Samples_of_General_Changes = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 3)->count();
            $Pending_Samples_of_Modification = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 5)->count();
            $Pending_Samples_of_As_Per_Benchmark = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 4)->count();
            $Pending_Samples_of_Oils = DB::table('samples')->where('is_deleted', 0)->where('status', 1)->where('sample_type', 2)->count();
        }



        $data = array(
            'No_of_Samples_Added' => $No_of_Samples_Added,
            'No_of_Samples_Dispatched' => $No_of_Samples_Dispatched,
            'Pending_Samples_of_Standard_Cosmetic' => $Pending_Samples_of_Standard_Cosmetic,
            'Pending_Samples_of_General_Changes' => $Pending_Samples_of_General_Changes,
            'Pending_Samples_of_Modification' => $Pending_Samples_of_Modification,
            'Pending_Samples_of_As_Per_Benchmark' => $Pending_Samples_of_As_Per_Benchmark,
            'Pending_Samples_of_Oils' => $Pending_Samples_of_Oils,

        );
        return $data;
    }

    //getSampleActivityList
    //getPayoutDetails by amout 
    //AssinedSampleByType
    public static function AssinedSampleByType($userID, $sample_type_id, $sampleID)
    {

        //echo $sample_type_id;

        switch ($sample_type_id) {
            case 1:
                $users = DB::table('sample_assigned_list')->where('user_id', $userID)->first();
                break;
            case 3:
                //$users = DB::table('sample_assigned_list')->where('user_id', $userID)->whereDate('last_dispatcha_at', '!=', date('Y-m-d'))->first();
                $users = DB::table('sample_assigned_list')->where('user_id', $userID)->first();
                break;
            case 4:
                //$users = DB::table('sample_assigned_list')->where('user_id', $userID)->whereDate('last_dispatcha_at', '!=', date('Y-m-d'))->first();
                $users = DB::table('sample_assigned_list')->where('user_id', $userID)->first();
                break;
            case 5:
                //$users = DB::table('sample_assigned_list')->where('user_id', $userID)->whereDate('last_dispatcha_at', '!=', date('Y-m-d'))->first();
                $users = DB::table('sample_assigned_list')->where('user_id', $userID)->first();
                break;
        }


        //$users = DB::table('sample_assigned_list')->where('user_id', $userID)->whereDate('last_dispatcha_at', '!=', date('Y-m-d'))->first();

        // print_r($users);

        // die;

        if ($sample_type_id == 5) {
            $pendingV = $users->pending_count;
            $pendingV++;

            $usersCHK = DB::table('sample_assigned_list_data')->where('sample_id', $sampleID)->first();
            if ($usersCHK == null) {

                DB::table('sample_assigned_list_data')->insert(
                    [
                        'user_id' => $userID,
                        'sample_id' => $sampleID,
                        'assined_on' => date('Y-m-d H:i:s'),
                        'assined_by' => 21,
                        'msg' => 'Auto Script Assigment-' . $sample_type_id,
                        'sample_type_id' => $sample_type_id

                    ]
                );

                $affected = DB::table('sample_assigned_list')
                    ->where('user_id', $userID)
                    ->update(['pending_count' => $pendingV]);


                Sample::where('id', $sampleID)
                    ->update([
                        'assingned_to' => $userID,
                        'assingned_by' => 21,
                        'assingned_name' => AyraHelp::getUser($userID)->name,
                        'assingned_on' => date('Y-m-d H:i:s'),
                        'assingned_notes' => 'Auto Assigned List'
                    ]);
            }
        } else {
            $max_id = $users->max_id;
            $pendingV = $users->pending_count;

            if ($max_id > $pendingV) {
                $pendingV++;

                $usersCHK = DB::table('sample_assigned_list_data')->where('sample_id', $sampleID)->first();
                if ($usersCHK == null) {

                    DB::table('sample_assigned_list_data')->insert(
                        [
                            'user_id' => $userID,
                            'sample_id' => $sampleID,
                            'assined_on' => date('Y-m-d H:i:s'),
                            'assined_by' => 21,
                            'msg' => 'Auto Script Assigment-' . $sample_type_id,
                            'sample_type_id' => $sample_type_id

                        ]
                    );

                    $affected = DB::table('sample_assigned_list')
                        ->where('user_id', $userID)
                        ->update(['pending_count' => $pendingV]);


                    Sample::where('id', $sampleID)
                        ->update([
                            'assingned_to' => $userID,
                            'assingned_by' => 21,
                            'assingned_name' => AyraHelp::getUser($userID)->name,
                            'assingned_on' => date('Y-m-d H:i:s'),
                            'assingned_notes' => 'Auto Assigned List'
                        ]);
                }
            }
        }
    }
    //AssinedSampleByType
    public static function getSampleAssinedData()
    {

        $users = DB::table('sample_for_users')
            ->where('is_active', 1)
            ->get();

        foreach ($users as $key => $rowData) {

            // DB::enableQueryLog(); // Enable query log
            $sampleCount = DB::table('samples')
                ->where('is_deleted', 0)
                ->where('formatation_status', 0)
                ->where('assingned_to', $rowData->user_id)
                ->where('sample_stage_id', 2)
                ->count();

            // // dd(DB::getQueryLog()); // Show results of log
            // // die;
            // echo $rowData->user_id;
            // echo "<br>";
            // echo $sampleCount;
            // echo "<br>";

            $affected = DB::table('sample_assigned_list')
                ->where('user_id', $rowData->user_id)
                ->update(['pending_count' => $sampleCount]);
        }
    }


    public static function setAllSampleAssinedNow_AP()
    {


        AyraHelp::setSampleAutoAssingmenetProcess_1_AP();
        //AyraHelp::setSampleAutoAssingmenetProcess_2();
        AyraHelp::setSampleAutoAssingmenetProcess_3_AP();
        AyraHelp::setSampleAutoAssingmenetProcess_4_AP();
        AyraHelp::setSampleAutoAssingmenetProcess_5_AP();
        AyraHelp::getSampleAssinedData();
    }

    public static function setSampleAutoAssingmenetProcess_1_AP()
    {

        // $sample_Arr = DB::table('samples')->where('sample_stage_id', 2)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 1)->whereNull('assingned_to')->get();
        $sample_Arr = DB::table('samples')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 1)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 1)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {
                //       echo $rows->id;
                // echo "<br>";
                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    public static function setSampleAutoAssingmenetProcess_3_AP()
    {
        // $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 2)->where('status', 1)->where('sample_type', '=', 3)->whereNull('assingned_to')->get();
        $sample_Arr = DB::table('samples')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 3)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;


        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 3)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {

                //             echo $rows->id;
                //  echo "<br>";

                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    public static function setSampleAutoAssingmenetProcess_4_AP()
    {
        $sample_Arr = DB::table('samples')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 4)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 4)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {

                //             echo $rows->id;
                //  echo "<br>";

                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    //==============================AK===================

    public static function setSampleAutoAssingmenetProcess_5_AP()
    {
        // $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 2)->where('status', 1)->where('sample_type', '=', 5)->whereNull('assingned_to')->get();
        $sample_Arr = DB::table('samples')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 5)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            if ($rows->modi_sample_id == null) {
                //check user for type based chemist 
                $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 5)->get();


                foreach ($users as $key => $rowsA) {

                    AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
                }

                //check user for type based chemist 
            } else {
                $assingned_to = $rows->assingned_to;
                if ($assingned_to == null) {

                    $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 5)->get();


                    foreach ($users as $key => $rowsA) {

                        AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
                    }
                } else {
                    AyraHelp::AssinedSampleByType($assingned_to, 5, $rows->id);
                }
            }
        }
    }

    //setSampleAssinedThisAsNow
    public static function setSampleAssinedThisAsNow($sample_id)
    {
        $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('id', $sample_id)->first();
        $sample_type = $sample_Arr->sample_type;

        if ($sample_type == 5) {
            $modiSID = $sample_Arr->modi_sample_id;
            $sampleMoDi_Arr = DB::table('samples')->where('is_deleted', 0)->where('id', $modiSID)->first();

            $assingned_to = $sampleMoDi_Arr->assingned_to;
            if ($assingned_to == null) {

                $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', $sample_type)->get();



                foreach ($users as $key => $rowsA) {

                    AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $sample_Arr->id);
                }
            } else {
                AyraHelp::AssinedSampleByType($assingned_to, $sample_type, $sample_Arr->id);
            }
        } else {
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', $sample_type)->get();
            foreach ($users as $key => $rowsA) {

                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $sample_Arr->id);
            }
        }
    }
    //setSampleAssinedThisAsNow


    public static function setAllSampleAssinedNow() //dipreciated
    {


        AyraHelp::setSampleAutoAssingmenetProcess_1();
        //AyraHelp::setSampleAutoAssingmenetProcess_2();
        AyraHelp::setSampleAutoAssingmenetProcess_3();
        AyraHelp::setSampleAutoAssingmenetProcess_4();
        AyraHelp::setSampleAutoAssingmenetProcess_5();
        AyraHelp::getSampleAssinedData();
    }
    //auto assined 
    public static function setSampleAutoAssingmenetProcess_1()
    {
        $sample_Arr = DB::table('samples')->where('sample_stage_id', 2)->where('is_deleted', 0)->where('status', 1)->where('sample_type', '=', 1)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 1)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {
                //       echo $rows->id;
                // echo "<br>";
                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    public static function setSampleAutoAssingmenetProcess_3()
    {
        $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 2)->where('status', 1)->where('sample_type', '=', 3)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 3)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {

                //             echo $rows->id;
                //  echo "<br>";

                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    public static function setSampleAutoAssingmenetProcess_4()
    {
        $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 2)->where('status', 1)->where('sample_type', '=', 4)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {

            //check user for type based chemist 
            $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 4)->get();
            //   print_r(count($users));
            // die;

            foreach ($users as $key => $rowsA) {

                //             echo $rows->id;
                //  echo "<br>";

                AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
            }

            //check user for type based chemist 


        }
    }

    public static function setSampleAutoAssingmenetProcess_5()
    {


        $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 2)->where('status', 1)->where('sample_type', '=', 5)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;

        foreach ($sample_Arr as $key => $rows) {


            if ($rows->modi_sample_id == null) {
                //check user for type based chemist 
                $users = DB::table('sample_for_users')->where('is_active', 1)->where('sample_type_id', 5)->get();
                //   print_r(count($users));
                // die;

                foreach ($users as $key => $rowsA) {

                    //             echo $rows->id;
                    //  echo "<br>";

                    AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
                }
            } else {

                echo "4444";
                echo $assingned_to = $rows->assingned_to;
                die;
                if ($assingned_to == null) {

                    $users = DB::table('sample_for_users')->where('is_active', 1)->get();


                    foreach ($users as $key => $rowsA) {

                        AyraHelp::AssinedSampleByType($rowsA->user_id, $rowsA->sample_type_id, $rows->id);
                    }
                } else {
                    AyraHelp::AssinedSampleByType($assingned_to, 5, $rows->id);
                }
            }

            //check user for type based chemist 


        }
    }


    public static function setSampleAutoAssingmenetProcess_5New()
    {
        $sample_Arr = DB::table('samples')->where('is_deleted', 0)->where('sample_stage_id', 1)->where('status', 1)->where('sample_type', '=', 5)->whereNull('assingned_to')->get();
        // print_r(count($sample_Arr));
        // die;
        $sample_type_id = 5;

        foreach ($sample_Arr as $key => $rows) {
            $sampleID = $rows->id;
            //update and inset data 
            $usersCHK = DB::table('sample_assigned_list_data')->where('sample_id', $sampleID)->first();
            if ($usersCHK == null) {

                $sample_ArrOLDArr = DB::table('samples')->where('id', $rows->sampleStoreNew)->first();


                DB::table('sample_assigned_list_data')->insert(
                    [
                        'user_id' => $sample_ArrOLDArr->assingned_to,
                        'sample_id' => $sampleID,
                        'assined_on' => date('Y-m-d H:i:s'),
                        'assined_by' => 21,
                        'msg' => 'Auto Script Assigment-' . $sample_type_id,
                        'sample_type_id' => $sample_type_id

                    ]
                );
                $users = DB::table('sample_assigned_list')->where('user_id', $sample_ArrOLDArr->assingned_to)->first();
                $pendingV = $users->pending_count;
                $pendingVA = $pendingV + 1;

                $affected = DB::table('sample_assigned_list')
                    ->where('user_id', $sample_ArrOLDArr->assingned_to)
                    ->update(['pending_count' => $pendingVA]);


                Sample::where('id', $sampleID)
                    ->update([
                        'assingned_to' => $sample_ArrOLDArr->assingned_to,
                        'assingned_by' => 21,
                        'assingned_name' => AyraHelp::getUser($sample_ArrOLDArr->assingned_to)->name,
                        'assingned_on' => date('Y-m-d H:i:s'),
                        'assingned_notes' => 'Auto Assigned List Again'
                    ]);
            }
        }
    }


    //auto assined 

    public static function setAssinedCallPickUpLeadToMe($userID, $phone)
    {
        $startDateA = new Carbon('first day of this month');
        $startDate = date("Y-m-d", strtotime($startDateA));


        $usersCallArrCount = DB::table('indmt_data')->where('lead_status', 0)->whereDate('created_at', '>=', $startDate)->where('ENQ_RECEIVER_MOB', $phone)->where('duplicate_lead_status', 0)->count();
        if ($usersCallArrCount > 0) {

            $usersCallArr = DB::table('indmt_data')->where('lead_status', 0)->whereDate('created_at', '>=', $startDate)->where('ENQ_RECEIVER_MOB', $phone)->where('duplicate_lead_status', 0)->get();


            foreach ($usersCallArr as $key => $rowData) {


                $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));


                $arr_data = DB::table('lead_assign')
                    ->where('QUERY_ID', $rowData->QUERY_ID)
                    ->first();
                if ($arr_data == null) {

                    DB::table('lead_assign')->insert(
                        [
                            'QUERY_ID' => $rowData->QUERY_ID,
                            'assign_user_id' => Auth::user()->id, //auto assined 
                            'assign_by' => 17,
                            'msg' => 'Auto assined by call pickup',
                            'expire_time' => $expire_time,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 1,

                        ]
                    );

                    DB::table('indmt_data')
                        ->where('QUERY_ID', $rowData->QUERY_ID)
                        ->update([
                            'lead_status' => 2,
                            'assign_to' => Auth::user()->id, //auto assined 
                            'assign_on' => date('Y-m-d H:i:s'),
                            'assign_by' => 17,
                            'remarks' => 'Auto assined by call pickup',
                        ]);


                    //--------------------------------
                    $QUERY_ID = $rowData->QUERY_ID;
                    $user_id = 17;
                    $msg = 'Auto assined by call pickup';
                    $at_stage_id = 1;
                    $msg_desc = 'This lead is asign to  :' . AyraHelp::getUser(Auth::user()->id)->name . " on " . date('j F Y H:i:s') . ' By ' . AyraHelp::getUser(17)->name;


                    DB::table('lead_chat_histroy')->insert(
                        [
                            'QUERY_ID' => $QUERY_ID,
                            'user_id' => $user_id,
                            'msg_desc' => $msg_desc,
                            'msg' => $msg,
                            'created_at' => date('Y-m-d H:i:s'),
                            'at_stage_id' => $at_stage_id,
                            'sechule_date_time' => null,
                            'chat_type' => null,


                        ]
                    );

                    $userID = Auth::user()->id;
                    $LoggedName = AyraHelp::getUser(17)->name;
                    $AssineTo = AyraHelp::getUser(Auth::user()->id)->name;

                    $eventName = "Call PICKUP LEAD";
                    $eventINFO = 'Call PICKUP Lead Assined QUERY_ID:' . $QUERY_ID . " and Assined to  " . $AssineTo . " by" . $LoggedName;
                    $eventID = $QUERY_ID;
                    $created_atA = date('Y-m-d H:i:s');
                    $slug_name = url()->full();

                    DB::table('logged_activity')->insert(
                        [
                            'user_id' => $userID,
                            'event_name' => $eventName,
                            'event_info' => $eventINFO,
                            'event_id' => $eventID,
                            'created_at' => $created_atA,
                            'slug_name' => $slug_name,

                        ]
                    );



                    DB::table('st_process_action_4')->insert(
                        [
                            'ticket_id' => $rowData->QUERY_ID,
                            'process_id' => 4,
                            'stage_id' => 1,
                            'action_on' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'remarks' => 'Assign Auto by call pickup ',
                            'attachment_id' => 0,
                            'assigned_id' => 1,
                            'undo_status' => 1,
                            'updated_by' => Auth::user()->id,
                            'created_status' => 1,
                            'completed_by' => Auth::user()->id,
                            'statge_color' => 'completed',
                        ]
                    );

                    //---------------------

                }
            }
        }
    }
    //set sample first stage 
    public static function setSampleFirstStage()
    {

        $process_data = DB::table('samples')->where('status', 1)->whereNull('sample_stage_id')->get();
        foreach ($process_data as $key => $row) {


            DB::table('st_process_action_6')->insert(
                [
                    'ticket_id' => $row->id,
                    'process_id' => 6,
                    'stage_id' => 1,
                    'action_on' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'expected_date' => date('Y-m-d H:i:s'),
                    'remarks' => 'Auto Completed',
                    'attachment_id' => 0,
                    'assigned_id' => 1,
                    'undo_status' => 1,
                    'updated_by' => $row->created_by,
                    'created_status' => 1,
                    'completed_by' => $row->created_by,
                    'statge_color' => 'completed',
                ]
            );

            $data_arr = array(
                'status' => 1,
                'msg' => 'Added  successfully'
            );

            $affected = DB::table('samples')
                ->where('id', $row->id)
                ->update(['sample_stage_id' => 1]);
        }
    }
    public static function setSampleFirstStageV2()
    {

        $process_data = DB::table('sample_items')->whereNull('sample_stage_id')->get();
        foreach ($process_data as $key => $row) {


            DB::table('st_process_action_6')->insert(
                [
                    'ticket_id' => $row->id,
                    'process_id' => 6,
                    'stage_id' => 1,
                    'action_on' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'expected_date' => date('Y-m-d H:i:s'),
                    'remarks' => 'Auto Completed',
                    'attachment_id' => 0,
                    'assigned_id' => 1,
                    'undo_status' => 1,
                    'updated_by' => $row->created_by,
                    'created_status' => 1,
                    'completed_by' => $row->created_by,
                    'statge_color' => 'completed',
                ]
            );

            $data_arr = array(
                'status' => 1,
                'msg' => 'Added  successfully'
            );

            $affected = DB::table('samples')
                ->where('id', $row->id)
                ->update(['sample_stage_id' => 1]);
        }
    }


    public static function setLoadIncentiveDuration()
    {
        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month  = date('Y-m-t');
        $currMonth = date('F');



        DB::table('incentive_curr_duration')
            ->updateOrInsert(
                ['circle_type' => 1],
                [
                    'name' => date('F') . " Month Incentive",
                    'start_date' => $first_day_this_month,
                    'end_date' => $last_day_this_month
                ]
            );

        //quater 1st 
        if ($currMonth == "April" || $currMonth == "May" ||  $currMonth == "June") {

            $first_Q1_this_month = date('Y-04-01');
            $last_Q1_this_month = date('Y-06-30');

            DB::table('incentive_curr_duration')
                ->updateOrInsert(
                    ['circle_type' => 2],
                    [
                        'name' => " April May June (Q1)  Incentive",
                        'start_date' => $first_Q1_this_month,
                        'end_date' => $last_Q1_this_month
                    ]
                );
        }

        //quater 2nd 
        if ($currMonth == "July" || $currMonth == "August" ||  $currMonth == "September") {

            $first_Q1_this_month = date('Y-07-01');
            $last_Q1_this_month = date('Y-09-30');

            DB::table('incentive_curr_duration')
                ->updateOrInsert(
                    ['circle_type' => 2],
                    [
                        'name' => " July August September (Q2)  Incentive",
                        'start_date' => $first_Q1_this_month,
                        'end_date' => $last_Q1_this_month
                    ]
                );
        }

        //quater 3rd 
        if ($currMonth == "October" || $currMonth == "November" ||  $currMonth == "December") {

            $first_Q1_this_month = date('Y-10-01');
            $last_Q1_this_month = date('Y-12-31');

            DB::table('incentive_curr_duration')
                ->updateOrInsert(
                    ['circle_type' => 2],
                    [
                        'name' => " October- November-December (Q3)  Incentive",
                        'start_date' => $first_Q1_this_month,
                        'end_date' => $last_Q1_this_month
                    ]
                );
        }
        //quater 4th 
        if ($currMonth == "January" || $currMonth == "February" ||  $currMonth == "March") {

            $first_Q1_this_month = date('Y-01-01');
            $last_Q1_this_month = date('Y-03-31');

            DB::table('incentive_curr_duration')
                ->updateOrInsert(
                    ['circle_type' => 2],
                    [
                        'name' => " January February March (Q4)  Incentive",
                        'start_date' => $first_Q1_this_month,
                        'end_date' => $last_Q1_this_month
                    ]
                );
        }




        //quater

    }

    //set sample first stage 


    public static function CurrentQuerterData()
    {


        $process_data = DB::table('quarter_settings')->whereMonth('quarter_start_month', 11)->first();
        return $process_data;
    }

    //getLeadReportFirsttoYetPersonWise
    public static function getLeadReportFirsttoYetPersonWise($startDate, $endDate)
    {
        $from = $startDate;
        $to = $endDate;

        $data = array();
        $allUsers = AyraHelp::getSalesAgentAdmin();
        $mydata = array();
        foreach ($allUsers as $key => $user) {
            if ($user->id == 1 || $user->id == 108 || $user->id == 156 || $user->id == 186) {
            } else {
                $emp_arr = AyraHelp::getProfilePIC($user->id);
                $name = AyraHelp::getUser($user->id)->name;
                if (!isset($emp_arr->photo)) {
                    $img_photo = asset('local/public/img/avatar.jpg');
                } else {
                    $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                }

                $leadArrData_1 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 1)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_2 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 2)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_3 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 3)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_4 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 4)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_5 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 5)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_6 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 6)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
                $leadArrData_77 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 77)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();

                $totLead = $leadArrData_1
                    + $leadArrData_2
                    + $leadArrData_3
                    + $leadArrData_4
                    + $leadArrData_5
                    + $leadArrData_6;
                $data[] = array(
                    'sales_name' => $name,
                    'uid' => $user->id,

                    'profilePic' => $img_photo,
                    'stage_1' => $leadArrData_1,
                    'stage_2' =>  $leadArrData_2,
                    'stage_3' => $leadArrData_3,
                    'stage_4' => $leadArrData_4,
                    'stage_5' => $leadArrData_5,
                    'stage_6' => $leadArrData_6,
                    'stage_hold' => $leadArrData_77,
                    'stage_totoal' => $totLead,

                );
            }
        }
        return $data;
    }
    //getLeadReportFirsttoYetPersonWise

    //getLeadCountClaimBetweenReport
    public static function getLeadCountClaimBetweenReport($stage_id, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;
        $leadCount = DB::table('lead_assign')->where('current_stage_id', $stage_id)
            ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
        return $leadCount;
    }
    //getLeadCountClaimBetweenReport

    //getLeadCountBetweenReport
    public static function getLeadCountBetweenReport($startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;
        $leadCount = DB::table('indmt_data')
            ->where('duplicate_lead_status', 0)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
        return $leadCount;
    }

    //getLeadCountBetweenReport

    //get order values of sales between date 
    public static function getOrderValuesSalesBetweenReport($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;


        //$datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->get();
        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();



        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }
    public static function getAllMTDBrandWise($client_id, $startDate, $endDate){
        $dataArr=array(
            'orderVal'=>'',
            'paymentVal'=>'',
            'orderVal'=>'',
            'totalOrderCount'=>'',
            'totalOrderNewOrder'=>'',
            'totalOrderRepeatOrder'=>'',
        );
        

    }
    public static function getOrderUnitByClientID($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;        
        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $userid)->whereMonth('created_at', $from)->whereYear('created_at',$to)->get();
        $totalUnit = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $totalUnit = $totalUnit + $row->qty;
                }
            } else {
                $totalUnit = $totalUnit + $rowData->item_qty;
            }
        }
        return $totalUnit;
    }


    public static function getOrderUnitNumber($form_id)
    {

      


      
        $datas = QCFORM::where('is_deleted', 0)->where('form_id', $form_id)->first();


        $totalUnit = 0;
       
            if ($datas->qc_from_bulk == 1) {
                $totalUnit = DB::table('qc_bulk_order_form')
                    ->where('form_id', $datas->form_id)
                    ->whereNotNull('item_name')
                    ->sum('qty');
                // foreach ($bulkOrder as $key => $row) {
                //     $totalUnit = $totalUnit + $row->qty;
                // }

            } else {
                $totalUnit = $totalUnit + $datas->item_qty;
            }
            return number_format((float)$totalUnit, 2, '.', '');

        // return $totalUnit;
    }

    //getOrderValuesSalesBetweenReportOrderUnit
    public static function getOrderValuesSalesBetweenReportOrderUnit($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;


        // $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->get();
        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();


        $totalUnit = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $totalUnit = $totalUnit + $row->qty;
                }
            } else {
                $totalUnit = $totalUnit + $rowData->item_qty;
            }
        }
        return $totalUnit;
    }

    //getOrderValuesSalesBetweenReportOrderUnit
    //getOrderBatchSizeByClientID
    public static function getOrderBatchSizeByClientID($client_id, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;
        // $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->get();
        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at',  $from)->whereYear('created_at',$to)->get();

        $BatchSize = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $BatchSize = $BatchSize + $row->qty;
                }
            } else {
                $BatchSize =$BatchSize+ ($rowData->item_qty * $rowData->item_size) / 1000;
            }
        }
        return $BatchSize;
    }

    //getOrderBatchSizeByClientID
    public static function getOrderBatchSize($formID)
    {

      
        $datas = QCFORM::where('is_deleted', 0)->where('form_id', $formID)->first();

        $BatchSize = 0;
       
            if ($datas->qc_from_bulk == 1) {
                $BatchSize = DB::table('qc_bulk_order_form')
                    ->where('form_id', $datas->form_id)
                    ->whereNotNull('item_name')
                    ->sum('qty');
                // foreach ($bulkOrder as $key => $row) {
                //     $BatchSize = $BatchSize + $row->qty;
                // }
            } else {
                $BatchSize =$BatchSize+ ($datas->item_qty * $datas->item_size) / 1000;
            }
        
            return number_format((float)$BatchSize, 2, '.', '');
        
    }

    //getOrderValuesSalesBetweenReportOrderBatchSize
    public static function getOrderValuesSalesBetweenReportOrderBatchSize($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;
        // $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->get();
        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

        $BatchSize = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $bulkOrder = DB::table('qc_bulk_order_form')
                    ->where('form_id', $rowData->form_id)
                    ->whereNotNull('item_name')
                    ->get();
                foreach ($bulkOrder as $key => $row) {
                    $BatchSize = $BatchSize + $row->qty;
                }
            } else {
                $BatchSize =$BatchSize+ ($rowData->item_qty * $rowData->item_size) / 1000;
            }
        }
        return $BatchSize;
    }

    //getOrderValuesSalesBetweenReportOrderBatchSize


    //getFormulatedBetweenDate
    public static function getFormulatedBetweenDate($userid, $startDate, $endDate)
    {
        $datas = DB::table('samples_formula')->where('chemist_id', $userid)->whereDate('created_on', '>=', $startDate)->whereDate('created_on', '<=', $endDate)->count();
        return $datas;
    }
    public static function getSampleProductiondBetweenDate($userid, $startDate, $endDate)
    {
        $datasArr = DB::table('qc_forms')->where('is_deleted', 0)->whereNotNull('item_fm_sample_no')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get();
        $i = 0;
        $sampleData = array();
        foreach ($datasArr as $key => $row) {
            $sampleLIke = $row->item_fm_sample_no;
            $datas = DB::table('samples_formula')->where('sample_code_with_part', 'like', '%' . $sampleLIke)->where('chemist_id', $userid)->first();
            if ($datas != null) {
                $i++;
                //print_r($datas);
                $sampleData[] = $datas->sample_code_with_part;
            }
        }



        //return $datas;
        $aj = array(
            'count' => $i,
            'data' => $sampleData,
        );

        return $aj;
    }


    //getFormulatedBetweenDate

    public static function getOrderValuesSalesBetween($userid, $startDate, $endDate)
    {

        $from = date('Y-m-01');
        $to = date("Y-m-t");


        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->get();
        // print_r(count($datas));
        // die;

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }
    //get order values of sales between date 
    //getSamplesCount
    public static function getSamplesCount($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;



        //$datas = DB::table('samples')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->count();
        // $datas = DB::table('samples')->where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->whereYear('created_at', date('Y'))->count();
        $datas = DB::table('samples')->where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->count();




        // print_r(count($datas));
        // die;


        return $datas;
    }

    public static function getOrdersDataCount($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;



        // $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('created_by', $userid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->count();
        $datas = DB::table('qc_forms')->where('is_deleted', 0)->where('created_by', $userid)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->count();



        // print_r(count($datas));
        // die;


        return $datas;
    }

    public static function getLeadAssinedDataCount($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;



        // $datas = DB::table('indmt_data')->where('assign_to', $userid)->whereBetween('assign_on', [$from, $to])->whereYear('assign_on', date('Y'))->count();
        // $datas = DB::table('indmt_data')->where('assign_to', $userid)->whereDate('assign_on', '>=', $from)->whereDate('assign_on', '<=', $to)->whereYear('assign_on', date('Y'))->count();
        $datas = DB::table('indmt_data')->where('assign_to', $userid)->whereDate('assign_on', '>=', $from)->whereDate('assign_on', '<=', $to)->count();



        // print_r(count($datas));
        // die;


        return $datas;
    }





    //getSamplesCount
    //getSalesPaymentRecSalesWise
    public static function getSalesPaymentRecSalesWise($userid, $startDate, $endDate)
    {
        $from = $startDate;
        $to = $endDate;
        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereDate('recieved_on', '>=', $from)->whereDate('recieved_on', '<=', $to)->whereYear('recieved_on', date('Y'))->orderBy('client_id', 'asc')->get();
        return $datas;
    }
    //getSalesPaymentRecSalesWise

    //getPaymentRecievedSalesBetweenReportFilter
    public static function getPaymentRecievedSalesBetweenReportFilter($userid, $month, $year)
    {






        //$datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereBetween('recieved_on', [$from, $to])->whereYear('recieved_on', date('Y'))->get();
        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereMonth('recieved_on', '=', $month)->whereYear('recieved_on', $year)->get();




        // print_r(count($datas));
        // die;

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }

    //getPaymentRecievedSalesBetweenReportFilter


    public static function getPaymentRecievedSalesBetweenReport($userid, $startDate, $endDate)
    {

        $from = $startDate;
        $to = $endDate;



        //$datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereBetween('recieved_on', [$from, $to])->whereYear('recieved_on', date('Y'))->get();
        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereDate('recieved_on', '>=', $from)->whereDate('recieved_on', '<=', $to)->get();




        // print_r(count($datas));
        // die;

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }


    // get order payment received  sales between date
    public static function getPaymentRecievedSalesBetween($userid, $startDate, $endDate)
    {

        $from = date('Y-m-01');
        $to = date("Y-m-t");



        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('created_by', $userid)->whereBetween('recieved_on', [$from, $to])->whereYear('recieved_on', date('Y'))->get();



        // print_r(count($datas));
        // die;

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;
    }

    // get order payment received  sales between date


    //get Quately days 
    public static function firstDayOf($period, DateTime $date = null)
    {
        $period = strtolower($period);
        $validPeriods = array('year', 'quarter', 'month', 'week');

        if (!in_array($period, $validPeriods))
            throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));

        $newDate = ($date === null) ? new DateTime() : clone $date;

        switch ($period) {
            case 'year':
                $newDate->modify('first day of january ' . $newDate->format('Y'));
                break;
            case 'quarter':
                $month = $newDate->format('n');

                if ($month < 4) {
                    $newDate->modify('first day of january ' . $newDate->format('Y'));
                } elseif ($month > 3 && $month < 7) {
                    $newDate->modify('first day of april ' . $newDate->format('Y'));
                } elseif ($month > 6 && $month < 10) {
                    $newDate->modify('first day of july ' . $newDate->format('Y'));
                } elseif ($month > 9) {
                    $newDate->modify('first day of october ' . $newDate->format('Y'));
                }
                break;
            case 'month':
                $newDate->modify('first day of this month');
                break;
            case 'week':
                $newDate->modify(($newDate->format('w') === '0') ? 'monday last week' : 'monday this week');
                break;
        }

        return $newDate;
    }

    public static function lastDayOf($period, DateTime $date = null)
    {
        $period = strtolower($period);
        $validPeriods = array('year', 'quarter', 'month', 'week');

        if (!in_array($period, $validPeriods))
            throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));

        $newDate = ($date === null) ? new DateTime() : clone $date;

        switch ($period) {
            case 'year':
                $newDate->modify('last day of december ' . $newDate->format('Y'));
                break;
            case 'quarter':
                $month = $newDate->format('n');

                if ($month < 4) {
                    $newDate->modify('last day of march ' . $newDate->format('Y'));
                } elseif ($month > 3 && $month < 7) {
                    $newDate->modify('last day of june ' . $newDate->format('Y'));
                } elseif ($month > 6 && $month < 10) {
                    $newDate->modify('last day of september ' . $newDate->format('Y'));
                } elseif ($month > 9) {
                    $newDate->modify('last day of december ' . $newDate->format('Y'));
                }
                break;
            case 'month':
                $newDate->modify('last day of this month');
                break;
            case 'week':
                $newDate->modify(($newDate->format('w') === '0') ? 'now' : 'sunday this week');
                break;
        }

        return $newDate;
    }


    public static function getCurrentQuarterDay()
    {
        return $firstDayOf = self::firstDayOf('quarter');
        $lastDayOf = self::lastDayOf('quarter');
    }

    //get Quately days 

    public static function getLastEMAILSEND()
    {

        $process_data = DB::table('indmt_data')->where('email_sent', 1)->select('created_at')->latest()->first();
        return @$process_data->created_at;
    }
    public static function getLastSMSSEND()
    {

        $process_data = DB::table('indmt_data')->where('sms_sent', 1)->select('created_at')->latest()->first();
        return @$process_data->created_at;
    }


    public static function getSampleIDByUserID_BYClient($user_id)
    {
        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
            $process_data = DB::table('samples')->where('is_deleted', 0)->where('is_formulated', 0)->where('status', 2)->get();
        } else {
            $process_data = DB::table('samples')->where('is_deleted', 0)->where('is_formulated', 0)->where('status', 2)->where('client_id', $user_id)->get();
        }


        return $process_data;
    }


    public static function getSampleIDByUserID($user_id)
    {
        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
            $process_data = DB::table('samples')->where('is_formulated', 0)->where('status', 2)->get();
        } else {
            $process_data = DB::table('samples')->where('is_formulated', 0)->where('status', 2)->where('created_by', $user_id)->get();
        }


        return $process_data;
    }

    //208/1
    //208/2
    //getPreviousOrderbyClientID
    public static function getPreviousOrderbyClientID($client_id)
    {
        $process_data = DB::table('qc_forms')->select('order_id', 'subOrder')->where('is_deleted', 0)->where('client_id', $client_id)->get();
        return $process_data;
    }
    //getPreviousOrderbyClientID


    //getSampleIDByUserIDWithFormulationWithClient
    public static function getSampleIDByUserIDWithFormulationWithClientID($client_id)
    {

        $process_data = DB::table('samples')->select('id')->where('is_deleted', 0)->where('client_id', $client_id)->get();
        $sampleArr = array();
        foreach ($process_data as $key => $row) {

            $process_dataArr = DB::table('sample_items')->where('sid', $row->id)->get();
            foreach ($process_dataArr as $key => $row) {
                $sampleArr[] = array(
                    'sid_partby_code' => $row->sid_partby_code,
                    'sid_partby_id' => $row->sid_partby_id,
                );
            }
        }
        return $sampleArr;
    }
    //getSampleIDByUserIDWithFormulationWithClient


    public static function getSampleIDByUserIDWithFormulation_BYClient($user_id)
    {

        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
            $process_data = DB::table('samples_formula')->whereNotNull('formulated_on')->get();
        } else {
            $process_data = DB::table('samples_formula')->whereNotNull('formulated_on')->where('user_id', $user_id)->get();
        }


        return $process_data;
    }


    public static function getSampleIDByUserIDWithFormulation($user_id)
    {

        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
            $process_data = DB::table('samples_formula')->get();
        } else {
            // $process_data = DB::table('samples_formula')->where('user_id', $user_id)->get();
            $process_data = DB::table('samples')
            ->join('samples_formula', 'samples.id', '=', 'samples_formula.sample_id')
            ->where('samples.created_by',  $user_id)
            ->select('samples_formula.*')
            ->get();

        }


        return $process_data;
    }
    public static function getSampleIDByUserIDWithFormulationOIL($user_id)
    {

        if (Auth::user()->id == 1 || Auth::user()->id == 156) {
            $process_data = DB::table('samples')->get();
        } else {
            $process_data = DB::table('samples')->where('created_by', $user_id)->where('sample_type', 2)->get();
        }


        return $process_data;
    }


    public static function getOrderValuesSalesByClientID($client_id, $month, $year)
    {

        // echo $month;
        // echo $year;
      
            
        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        //print_r($datas);
      
        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }
    // getOrderCountByClientID
    public static function getOrderCountVByClientID($client_id, $month, $year)
    {
   
       
      
             
        $NoProductAdded = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $NoProductRepeat = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('order_type_v1',2)->count();
        $NewProductRepeat = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('order_type_v1',3)->count();

        
        $data=array(
            'NoProductAdded'=>$NoProductAdded,
            'NoProductRepeat'=>$NoProductRepeat,
            'NewProductRepeat'=>$NewProductRepeat
        );
      
        
        return $data;
    }

    // getOrderCountByClientID

    //getPaymentRecFilterByClinetID
    public static function getPaymentRecFilterByClinetID($client_id, $month, $year){

        
        $datas = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->where('client_id', $client_id)->whereMonth('recieved_on', '=', $month)->whereYear('recieved_on', $year)->get();
        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            $sum = $rowData->rec_amount;
            $sumTotal = $sum + $sumTotal;
        }
        return $sumTotal;

    }
    //getPaymentRecFilterByClinetID

    //getPaymentRecFilter
    public static function getPaymentRecFilter($user_id, $month, $year)
    {
        return
            $paymentAmt = AyraHelp::getPaymentRecievedSalesBetweenReportFilter($user_id, $month, $year);
    }
    //getLeadValuesFilter
    public static function getLeadValuesFilter($user_id, $month, $year)
    {
        $paymentAmt = AyraHelp::getLeadValuesSalesBetweenReportFilter($user_id, $month, $year);
        return $paymentAmt;
    }
    public static function getLeadValuesSalesBetweenReportFilter($userid, $month, $year)
    {

        $users = DB::table('lead_assign')->where('assign_user_id', $userid)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->count();

        return $users;
    }

    //getLeadValuesFilter

    //getSampleValuesFilter
    public static function getSampleValuesFilter($user_id, $month, $year)
    {
        $paymentAmt = AyraHelp::getSampleValuesSalesBetweenReportFilter($user_id, $month, $year);
        return $paymentAmt;
    }
    public static function getSampleValuesSalesBetweenReportFilter($userid, $month, $year)
    {

        $users = DB::table('samples')->where('is_deleted', 0)->where('created_by', $userid)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->count();






        return $users;
    }
    //getSampleValuesFilter
    //getOrderCountValuesFilter
    public static function getOrderCountValuesFilter($user_id, $month, $year)
    {

        $paymentAmt = AyraHelp::getOrderCountValuesSalesBetweenReportFilter($user_id, $month, $year);
        return $paymentAmt;
    }

    public static function getOrderCountValuesSalesBetweenReportFilter($userid, $month, $year)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->count();

        return $datas;
    }
    //getOrderCountValuesFilter


    public static function getOrderValuesFilter($user_id, $month, $year)
    {

        $paymentAmt = AyraHelp::getOrderValuesSalesBetweenReportFilter($user_id, $month, $year);
        return $paymentAmt;
    }

    public static function getOrderValuesSalesBetweenReportFilter($userid, $month, $year)
    {



        $datas = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->get();


        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        return $sumTotal;
    }



    //getPaymentRecFilter


    public static function getMyMACAddress()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        // $ip="192.168.1.147";

        $macAddr = false;
        $arp = `arp -n`;
        $lines = explode("\n", $arp);

        foreach ($lines as $line) {
            $cols = preg_split('/\s+/', trim($line));
            if ($cols[0] == $ip) {
                $macAddr = $cols[2];
            }
        }
        // $affected = DB::table('users')
        //       ->where('id', Auth::user()->id)
        //       ->update(['mac_address' => trim($macAddr)]);

        return trim($macAddr);
    }
    public static function setSampleLeadData()
    {
        $usersCallArr = DB::table('samples')->whereNotNull('QUERY_ID')->whereNull('lead_name')->get();
        foreach ($usersCallArr as $key => $rowData) {
            $QUERY_ID = $rowData->QUERY_ID;
            $LEAD_Data = DB::table('indmt_data')->select('SENDERNAME', 'GLUSR_USR_COMPANYNAME as company', 'MOB as phone')->where('QUERY_ID', $QUERY_ID)->first();
            $affected = DB::table('samples')
                ->where('id', $rowData->id)
                ->update([
                    'lead_name' => $LEAD_Data->SENDERNAME,
                    'lead_phone' => $LEAD_Data->phone,
                    'lead_company' => $LEAD_Data->company,
                ]);
        }
        $usersCallArrA = DB::table('samples')->whereNull('QUERY_ID')->whereNull('lead_name')->get();
        foreach ($usersCallArrA as $key => $rowData) {

            $ordercouT = AyraHelp::getClientHaveOrder($rowData->client_id);
            $client_arr = AyraHelp::getClientbyid($rowData->client_id);
            $company = isset($client_arr->company) ? $client_arr->company : '';
            $phone = isset($client_arr->phone) ? $client_arr->phone : '';
            $name = isset($client_arr->firstname) ? $client_arr->firstname : '';

            $affected = DB::table('samples')
                ->where('id', $rowData->id)
                ->update([
                    'lead_name' => $name,
                    'lead_phone' => $phone,
                    'lead_company' => $company,
                    'order_count' => $ordercouT,
                ]);
        }
    }
    public static function getLeadProgress()
    {
        $usersCallArr = DB::table('lead_assign')->distinct('assign_user_id')->get(['assign_user_id']);

        DB::table('graph_lead_trackdays')->delete();

        foreach ($usersCallArr as $key => $row) {
            $userID = $row->assign_user_id;
            $data = AyraHelp::getAssinedLeadbyDay($userID, 7);

            if (AyraHelp::getUser($data['userid'])->is_deleted == 1) {
            } else {

                $name = AyraHelp::getUser($data['userid'])->name;
                $phone = optional(AyraHelp::getUser($data['userid']))->phone;
                DB::table('graph_lead_trackdays')
                    ->updateOrInsert(
                        ['user_id' =>  $userID],
                        [
                            'name' => $name,
                            'phone' => $phone,
                            'assined' => $data['lead_assignCount'],
                            'qualified' => $data['lead_QualifiedCount'],
                            'sampling' => 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'clinet' => $data['lead_QualifiedCount'],
                            'repeat_clinet' => $data['lead_QualifiedCount'],
                            'lost' =>  $data['lead_QualifiedCount'],
                            'move' => $data['lead_QualifiedCount']


                        ]
                    );
            }
        }
    }
    //------------------------------------------
    public static function getAssinedLeadbyDay($user_id, $days)
    {
        $date = \Carbon\Carbon::today()->subDays($days);

        $callArr = DB::table('lead_assign')->where('assign_user_id', $user_id)->whereDate('created_at', '>=', $date)->count();

        $callArrQualified = DB::table('st_process_action_4')->where('stage_id', 2)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();
        $callArrSampling = DB::table('st_process_action_4')->where('stage_id', 3)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();
        $callArrClient = DB::table('st_process_action_4')->where('stage_id', 4)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();
        $callArrRepeat = DB::table('st_process_action_4')->where('stage_id', 5)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();
        $callArrLost = DB::table('st_process_action_4')->where('stage_id', 6)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();
        $callArrMove = DB::table('st_process_action_4')->where('stage_id', 6)->where('completed_by', $user_id)->whereDate('created_at', '>=', $date)->count();




        $data = array(
            'lead_assignCount' => $callArr,
            'lead_QualifiedCount' => $callArrQualified,
            'lead_SamplingCount' => $callArrSampling,
            'lead_SamplingClient' => $callArrClient,
            'lead_SamplingRepeat' => $callArrRepeat,
            'lead_SamplintLost' => $callArrLost,
            'lead_moveCount' => $callArrMove,
            'userid' => $user_id,
        );
        return $data;
    }
    //------------------------------------------


    //merge code 
    public static function leadMerge()
    {
        $data_arr = DB::table('indmt_data_2')->where('is_merge', 0)->get();
        foreach ($data_arr as $key => $row) {
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
                    'IM_MEMBER_SINCE' => $row->IM_MEMBER_SINCE . '...',
                    'QUERY_ID' => $row->QUERY_ID,
                    'QTYPE' => $row->QTYPE,
                    'ENQ_CALL_DURATION' => $row->ENQ_CALL_DURATION,
                    'ENQ_RECEIVER_MOB' => $row->ENQ_RECEIVER_MOB,
                    'data_source' => $row->data_source,
                    'data_source_ID' => $row->data_source_ID,
                    'created_at' => $row->DATE_TIME_RE_SYS,
                    'DATE_TIME_RE_SYS' => $row->DATE_TIME_RE_SYS,
                    'assign_to' => 134,
                    'sms_sent' => $row->sms_sent,
                    'email_sent' => $row->email_sent,

                ]);
                $affected = DB::table('indmt_data_2')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->update(['is_merge' => 1]);
            } else {
                $affected = DB::table('indmt_data')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->update(['is_already' => 1]);
            }
        }
    }

    public static function IrrelevantLeadMerge()
    {
        //irrelevant Type
        $data_arr = DB::table('indmt_data_2')->where('mergeIrrevant', 0)->get();
        foreach ($data_arr as $key => $row) {


            if ($row->iIrrelevant_type == 5) {
                DB::table('indmt_data')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->update([
                        'lead_status' => 55,
                        'iIrrelevant_type' =>  $row->iIrrelevant_type,
                        'remarks' => $row->remarks,

                    ]);
            } else {

                DB::table('indmt_data')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->update([
                        'lead_status' => 1,
                        'iIrrelevant_type' => $row->iIrrelevant_type,
                        'remarks' => $row->remarks,

                    ]);
            }




            DB::table('lead_Irrelevant')->insert(
                [
                    'QUERY_ID' => $row->QUERY_ID,
                    'iIrrelevant_type' => $row->iIrrelevant_type,
                    'created_by' => 134,
                    'msg' => $row->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 1,

                ]
            );


            //--------------------------------
            $QUERY_ID = $row->QUERY_ID;
            $user_id = 134;
            $msg = optional($row)->remarks;
            $iIrrelevant_type_HTML = $row->iIrrelevant_type;
            $msg_desc = 'This lead is Irrelevant mark by :' . AyraHelp::getUser($user_id)->name . " on " . date('j F Y H:i:s') . " with reason type :" . $iIrrelevant_type_HTML;

            DB::table('lead_chat_histroy')->insert(
                [
                    'QUERY_ID' => $QUERY_ID,
                    'user_id' => $user_id,
                    'msg_desc' => $msg_desc,
                    'msg' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'at_stage_id' => NULL,
                    'sechule_date_time' => NULL,
                    'chat_type' => NULL


                ]
            );


            //----------------------------


            $affected = DB::table('indmt_data_2')
                ->where('QUERY_ID', $row->QUERY_ID)
                ->update(['mergeIrrevant' => 1]);
        }

        //irrelevant Type
    }
    public static function AssignedLeadMerge()
    {
        $arr_data = DB::table('lead_assign_1')->where('merge', 0)->get();
        //  echo count($arr_data);

        $i = 0;
        foreach ($arr_data as $key => $row) {
            $arr_data = DB::table('lead_assign')
                ->where('QUERY_ID', $row->QUERY_ID)
                ->first();
            if ($arr_data == null) {
                DB::table('lead_assign')->insert(
                    [
                        'QUERY_ID' => $row->QUERY_ID,
                        'assign_user_id' => $row->assign_user_id,
                        'assign_by' => $row->assign_by,
                        'msg' =>  $row->msg,
                        'expire_time' => $row->expire_time,
                        'created_at' => $row->created_at,
                        'status' => $row->status

                    ]
                );

                $affected = DB::table('lead_assign_1')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->update(['merge' => 1]);
            } else {
                $arr_dataA = DB::table('indmt_data')
                    ->where('QUERY_ID', $row->QUERY_ID)
                    ->first();
                if ($arr_dataA != null) {

                    DB::table('indmt_data')
                        ->where('QUERY_ID', $row->QUERY_ID)
                        ->update([
                            'lead_status' => $arr_dataA->lead_status,
                            'assign_to' => $arr_dataA->assign_to,
                            'assign_on' => $arr_dataA->assign_on,
                            'assign_by' => $arr_dataA->assign_by,
                            'remarks' => $arr_dataA->remarks,
                        ]);

                    $affected = DB::table('lead_assign_1')
                        ->where('QUERY_ID', $row->QUERY_ID)
                        ->update(['merge' => 1]);
                }
            }
        }
        echo $i;
    }
    //ChatHistLeadMerge
    public static function ChatHistLeadMerge()
    {

        $arr_data = DB::table('lead_chat_histroy_1')->where('merge', 0)->get();
        foreach ($arr_data as $key => $row) {
            // print_r($row);
            $arr_data = DB::table('lead_chat_histroy')->where('QUERY_ID', $row->QUERY_ID)->where('created_at', $row->created_at)->first();


            if ($arr_data == null) {
                DB::table('lead_chat_histroy')->insert(
                    [
                        'QUERY_ID' => $row->QUERY_ID,
                        'user_id' => $row->user_id,
                        'msg_desc' => $row->msg_desc,
                        'msg' =>  $row->msg,
                        'created_at' =>  $row->created_at,
                        'at_stage_id' => $row->at_stage_id,
                        'sechule_date_time' => $row->sechule_date_time,
                        'v1' => $row->v1,
                        'chat_type' => $row->chat_type

                    ]
                );

                $affected = DB::table('lead_chat_histroy_1')
                    ->where('QUERY_ID', $row->QUERY_ID)->where('created_at', $row->created_at)
                    ->update(['merge' => 1]);
            }
        }
    }
    //ChatHistLeadMerge

    public static function StagesLeadMerge()
    {

        $arr_data = DB::table('st_process_action_4_1')->where('merge', 0)->get();
        foreach ($arr_data as $key => $row) {
            echo  $sid = $row->stage_id;
            echo $tickid = $row->ticket_id;




            $arr_data = DB::table('st_process_action_4')->where('stage_id', $row->stage_id)->where('ticket_id', $row->ticket_id)->first();

            if ($arr_data == null) {


                DB::table('st_process_action_4')->insert(
                    [
                        'process_id' => $row->process_id,
                        'stage_id' => $row->stage_id,
                        'action_on' => $row->action_on,
                        'ticket_id' =>  $row->ticket_id,
                        'remarks' =>  $row->remarks,
                        'assigned_id' => $row->assigned_id,
                        'updated_by' => $row->updated_by,
                        'completed_by' => $row->completed_by,
                        'created_at' => $row->created_at,
                        'expected_date' => $row->expected_date,
                        'expected_date' => $row->expected_date,
                    ]
                );

                $affected = DB::table('st_process_action_4_1')
                    ->where('stage_id', $row->stage_id)->where('ticket_id', $row->ticket_id)
                    ->update(['merge' => 1]);
            } else {
                echo "d";
            }
        }
    }
    //merge code 


    public static function sendEmail_forSampleNotification()
    {
    }

    public static function sendEmail_SMSToLeadIndiaMart()
    {

        $users = DB::table('indmt_data')->where('SENDEREMAIL', '!=', '')->where('created_at', '>=', '2020-07-18')->where('data_source_ID', 1)->where('email_sent', 0)->get();
        $i = 0;
        foreach ($users as $key => $rows) {
            $i++;
            $sent_to = $rows->SENDEREMAIL;

            //send email
            $sent_to = 'bointldev@gmail.com';
            //$myorder=$row['txtPONumber'];
            $html = "<p>This is </p>";
            $empName = 'AJAY KUMAR';
            $toaj = date('F');
            $curr_date = date('d-m-Y');
            $subLine = "Lead Notification Subject line";
            $html = "A";
            $data = array(
                'lead_name' => $rows->SENDERNAME,
                'sales_name' => 'Ajay',
                'sales_phone' => '7703886088',
                'html' => $html
            );
            Mail::send('mail_lead_sent', $data, function ($message) use ($sent_to, $data, $subLine) {

                $message->to($sent_to, 'Bo Lead Notify')->subject($subLine);
                //$message->cc($use_data->email,$use_data->name = null);
                $message->setBody($data['html'], 'text/html');
                //$message->bcc('pooja@max.net', 'Sales Head');
                $message->from('nehap@max.net', 'MAX');
            });
            die;
            //send email


        }
        die;
    }
    public static function getsetAllKnowlartyData()
    {

        $knowArrObj = DB::table('click_calldata_api')->where('Call_Type', 0)->whereNull('QUERY_ID')->where('call_duration', '>=', 30)->where('destination', '!=', '')->get();
        foreach ($knowArrObj as $key => $rowData) {
            $phoneArr = explode("+91", $rowData->destination);
            $phone = $phoneArr[1];


            $phoneC = $rowData->customer_number;
            $boUserArr = DB::table('users')->where('phone', $phone)->first();
            if ($boUserArr != null) {
                //  echo $rowData->id."-".$phone."-".$boUserArr->id."-".$boUserArr->name."<br>";

                //added lead to lead
                $QUERY_ID = AyraHelp::getSponsorID();

                DB::table('indmt_data')->insert(
                    [

                        'SENDERNAME' => 'NA',
                        'SENDEREMAIL' => 'NA',
                        'SUBJECT' => 'In knowlarity Data Incoming',
                        'DATE_TIME_RE' => date('j F Y h:iA'),
                        'GLUSR_USR_COMPANYNAME' => 'NA',
                        'MOB' => "+91-" . $phoneC,
                        'COUNTRY_FLAG' => '',
                        'ENQ_MESSAGE' => 'knowlarity',
                        'ENQ_ADDRESS' => '',
                        'ENQ_CITY' => '',
                        'ENQ_STATE' => '',
                        'PRODUCT_NAME' => '',
                        'COUNTRY_ISO' => 'IN',
                        'EMAIL_ALT' => '',
                        'MOBILE_ALT' => '',
                        'PHONE' => '',
                        'PHONE_ALT' => '',
                        'IM_MEMBER_SINCE' => '',
                        'QUERY_ID' => intval($QUERY_ID),
                        'data_source' => 'KNW-ENTRY',
                        'data_source_ID' => 7,
                        'created_at' => date('Y-m-d H:i:s'),
                        'DATE_TIME_RE_SYS' => date('Y-m-d H:i:s'),
                        'assign_to' => $boUserArr->id

                    ]
                );

                $affected = DB::table('click_calldata_api')
                    ->where('uuid', $rowData->uuid)
                    ->update(['QUERY_ID' => $QUERY_ID]);
                //stop lead in lead section  . now assigne to relative saels
                $expire_time = date("Y-m-d H:i:s", strtotime('1 day'));
                $arr_data = DB::table('lead_assign')
                    ->where('QUERY_ID', $QUERY_ID)
                    ->first();
                if ($arr_data == null) {
                    DB::table('lead_assign')->insert(
                        [
                            'QUERY_ID' => $QUERY_ID,
                            'assign_user_id' => $boUserArr->id,
                            'assign_by' => 134,
                            'msg' => 'Auto Assined knowlarity',
                            'expire_time' => $expire_time,
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 1,

                        ]
                    );
                    DB::table('indmt_data')
                        ->where('QUERY_ID', $QUERY_ID)
                        ->update([
                            'lead_status' => 2,
                            'assign_to' => $boUserArr->id,
                            'assign_on' => date('Y-m-d H:i:s'),
                            'assign_by' => Auth::user()->id,
                            'remarks' => 'Auto Assined knowlarity'
                        ]);
                    //--------------------------------
                    $QUERY_ID = $QUERY_ID;
                    $user_id = Auth::user()->id;
                    $msg =  'Auto Assined knowlarity';
                    $at_stage_id = 1;
                    $msg_desc = 'This lead is asign to  :' . AyraHelp::getUser($boUserArr->id)->name . " on " . date('j F Y H:i:s') . ' By ' . AyraHelp::getUser(Auth::user()->id)->name;

                    //$this->saveLeadHistory($QUERY_ID, $user_id, $msg_desc, $msg, $at_stage_id);
                    DB::table('st_process_action_4')->insert(
                        [
                            'ticket_id' => $QUERY_ID,
                            'process_id' => 4,
                            'stage_id' => 1,
                            'action_on' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'remarks' => 'Auto Assined knowlarity ',
                            'attachment_id' => 0,
                            'assigned_id' => 1,
                            'undo_status' => 1,
                            'updated_by' => Auth::user()->id,
                            'created_status' => 1,
                            'completed_by' => $boUserArr->id,
                            'statge_color' => 'completed',
                        ]
                    );

                    //---------------------

                }
                //leas assign




            }
        }
        // die;


    }
    public static function getErrLead()
    {
        $usersGetDataArr = DB::table('t1')->get();
        foreach ($usersGetDataArr as $key => $row) {
            //DB::table('indmt_data')->where('QUERY_ID', '=', $row->QUERY_ID)->delete();
        }
    }


    public static function getThisMonthAssinedQualifiedLead()
    {
        //this month lead assigned and qualified
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }

        DB::table('graph_currentm_assined_qualified')->delete();
        foreach ($list as $key => $row) {
            $totalCallDuration = AyraHelp::getTotalAssinedQualifiedLeadThisMonth($row);


            DB::table('graph_currentm_assined_qualified')->insert(
                [

                    'day_date' => $row,
                    'assined' => $totalCallDuration['assined'],
                    'qualified' => $totalCallDuration['qualified'],
                    'average_lead' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }

        //graph_currentm_assined_qualified

    }
    public static function getAllRecivedCallandDuration($phone, $date)
    {

        $usersGetDataArr = DB::table('agent_calldata')->where('phone', $phone)->whereDate('created_at', $date)->get();
        $usersGetDataArrCNT = DB::table('agent_calldata')->where('phone', $phone)->whereDate('created_at', $date)->count();


        $i = 0;
        $r = 0;
        foreach ($usersGetDataArr as $key => $rowData) {
            $r++;
            $i = $i + $rowData->call_duration;
        }

        $NoofCall = $usersGetDataArrCNT; //no of call
        if ($r == 0) {
            $totalCallAvg = 0;
        } else {
            $totalCallAvg = $i / $NoofCall; //total call divide by no of call
        }


        return  array('NoofCall' => $NoofCall, 'Duration' => $totalCallAvg);
    }
    public static function getoutGoingCallbyPhoneAndDate($phone, $date)
    {
        $phoneA = "+91" . $phone;
        $getClick2CallData = DB::table('click_calldata_api')->where('call_type', 1)->where('destination', $phoneA)->whereDate('call_date', $date)->count();

        return $getClick2CallData;
    }
    public static function setClick2CallThisMonthOutGoing()
    {
        $getClick2CallData = DB::table('click_calldata_api')->where('call_type', 1)->get();
        foreach ($getClick2CallData as $key => $rowData) {

            $phone = $rowData->destination;
            $cutomerphone = $rowData->customer_number;
            $duration = $rowData->call_duration;
            $dateTime = $rowData->start_time;
        }
    }
    public static function getWeeklyDataIndiamart12()
    {
        $now = Carbon::now();
        $currWeekNo = $now->weekOfYear;
        $stWeek = $currWeekNo - 17;
        //API_1
        DB::table('graph_weeklydays')->delete();

        for ($i = $stWeek; $i <= $currWeekNo; $i++) {

            $week = $i;
            $year = date('Y');
            $date = \Carbon\Carbon::now();
            $date->setISODate($year, $week);
            $startDate = date('Y-m-d', strtotime($date->startOfWeek(Carbon::SUNDAY)));
            $endDate = date('Y-m-d', strtotime($date->endOfWeek(Carbon::SATURDAY)));

            //$CallReArr = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->whereNotNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->where('ENQ_RECEIVER_MOB','!=',"False")->where('data_source','INDMART-9999955922@API_1')->get();
            $CallReArr = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->where('QTYPE', 'P')->whereNotNull('ENQ_RECEIVER_MOB')->where('ENQ_RECEIVER_MOB', '!=', "False")->where('data_source', 'INDMART-9999955922@API_1')->count();
            $CallReArrNULL = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE', 'P')->where('data_source', 'INDMART-9999955922@API_1')->count();
            $CallReArrFalse = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->where('ENQ_RECEIVER_MOB', "=", 'False')->where('QTYPE', 'P')->where('data_source', 'INDMART-9999955922@API_1')->count();
            DB::table('graph_weeklydays')->insert(
                [
                    'day_date' => $startDate . "-" . $endDate,
                    'recieved_call' => $CallReArr,
                    'missed_call' => $CallReArrNULL + $CallReArrFalse,
                    'average_call' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
        //API_1
        //API_2
        DB::table('graph_weeklydays_1')->delete();

        for ($i = $stWeek; $i <= $currWeekNo; $i++) {

            $week = $i;
            $year = date('Y');
            $date = \Carbon\Carbon::now();
            $date->setISODate($year, $week);
            $startDate = date('Y-m-d', strtotime($date->startOfWeek(Carbon::SUNDAY)));
            $endDate = date('Y-m-d', strtotime($date->endOfWeek(Carbon::SATURDAY)));

            //$CallReArr = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->whereNotNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->where('ENQ_RECEIVER_MOB','!=',"False")->where('data_source','INDMART-9999955922@API_1')->get();
            $CallReArr = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->where('QTYPE', 'P')->whereNotNull('ENQ_RECEIVER_MOB')->where('ENQ_RECEIVER_MOB', '!=', "False")->where('data_source', 'INDMART-8929503295@API_2')->count();
            $CallReArrNULL = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE', 'P')->where('data_source', 'INDMART-8929503295@API_2')->count();
            $CallReArrFalse = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->where('ENQ_RECEIVER_MOB', "=", 'False')->where('QTYPE', 'P')->where('data_source', 'INDMART-8929503295@API_2')->count();
            DB::table('graph_weeklydays_1')->insert(
                [
                    'day_date' => $startDate . "-" . $endDate,
                    'recieved_call' => $CallReArr,
                    'missed_call' => $CallReArrNULL + $CallReArrFalse,
                    'average_call' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
        //API_2


        //API_3
        DB::table('graph_weeklydays_c1')->delete();

        for ($i = $stWeek; $i <= $currWeekNo; $i++) {

            $week = $i;
            $year = date('Y');
            $date = \Carbon\Carbon::now();
            $date->setISODate($year, $week);
            $startDate = date('Y-m-d', strtotime($date->startOfWeek(Carbon::SUNDAY)));
            $endDate = date('Y-m-d', strtotime($date->endOfWeek(Carbon::SATURDAY)));

            //$CallReArr = DB::table('indmt_data')->whereBetween('DATE_TIME_RE_SYS', [$startDate, $endDate])->whereNotNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->where('ENQ_RECEIVER_MOB','!=',"False")->where('data_source','INDMART-9999955922@API_1')->get();
            $CallReArr = DB::table('click_calldata_api')->whereBetween('call_date', [$startDate, $endDate])->count();
            $CallReArrNULL = 0;
            $CallReArrFalse = 0;
            DB::table('graph_weeklydays_c1')->insert(
                [
                    'day_date' => $startDate . "-" . $endDate,
                    'recieved_call' => $CallReArr,
                    'missed_call' => $CallReArrNULL + $CallReArrFalse,
                    'average_call' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
        //API_3




    }
    public static function setAPIDataTocallData()
    {

        $usersAgentArr = DB::table('indmt_data')->where('data_source_ID', 1)->where('QTYPE', 'P')->get();
        $i = 0;
        foreach ($usersAgentArr as $key => $rowData) {
            $usersGetDataArr = DB::table('agent_calldata')->where('QUERY_ID', $rowData->QUERY_ID)->first();
            if ($usersGetDataArr == null) {

                $agentArrData = DB::table('agents')->where('phone', $rowData->ENQ_RECEIVER_MOB)->first();
                if ($agentArrData == null) {
                    $name = $rowData->ENQ_RECEIVER_MOB;
                    $user_id = "99999999";
                } else {
                    $name = AyraHelp::getUser($agentArrData->user_id)->name;
                    $user_id = $agentArrData->user_id;
                }

                DB::table('agent_calldata')->insert(
                    [
                        'user_id' => $user_id,
                        'phone' => $rowData->ENQ_RECEIVER_MOB,
                        'call_duration' => intVal($rowData->ENQ_CALL_DURATION),
                        'from_where' => 1,
                        'QUERY_ID' => $rowData->QUERY_ID,
                        'api_name' => $rowData->data_source,
                        'created_at' => $rowData->DATE_TIME_RE_SYS,
                    ]
                );
            }
        }
    }
    public static function getcurrentMonthRecivedMissedCallData()
    {
        // $list = array();
        // $month = date('m');
        // $year = date('Y');

        // for ($d = 1; $d <= 31; $d++) {
        //     $time = mktime(12, 0, 0, $month, $d, $year);
        //     if (date('m', $time) == $month)
        //         $list[] = date('Y-m-d', $time);
        // }



        $list = array();
        for ($i = 0; $i < 31; $i++)
            $list[] = date("Y-m-d", strtotime('-' . $i . ' days'));

        sort($list);
        //print_r($d);

        DB::table('graph_l30daysmissed_recieved')->delete();
        //print_r($list);
        foreach ($list as $key => $row) {
            $totalCallDuration = AyraHelp::getTotalRecivedMessedCallThisMonth($row);

            DB::table('graph_l30daysmissed_recieved')->insert(
                [

                    'day_date' => $row,
                    'recieved_call' => $totalCallDuration['received'],
                    'missed_call' => $totalCallDuration['missed'],
                    'average_call' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
        //last 30 days recived and missed get_called_class

    }
    //Last 30 Days knowlarity sales in or out call
    public static function getLast30daysKnowlarityINOUTCALLDATA()
    {
        $callKnowObjArr = DB::table('click_calldata_api')->where('destination', '!=', '')->distinct('destination')->get(['destination']);
        foreach ($callKnowObjArr as $key => $rowData) {
            $phoneArr = explode("91", $rowData->destination);


            $phone = $phoneArr[1];
            $agentArrData = DB::table('users')->where('phone', $phone)->first();
            if ($agentArrData == null) {
                $name = $phone;
                $user_id = "77777777";
            } else {
                $name = $agentArrData->name;
                $user_id = $agentArrData->id;
            }

            //$callKnowObjArrData =DB::table('click_calldata_api')->where('Call_Type',0)->where('destination',$rowData->destination)->get();
            //$callKnowObjArrData =DB::table('click_calldata_api')->where('Call_Type',1)->where('destination',$rowData->destination)->get();
            $callKnowObjArrData = AyraHelp::getTotalCallIN_OUT($rowData->destination, 30);


            DB::table('graph_30days_knowlarity')
                ->updateOrInsert(
                    ['phone' =>  $rowData->destination],
                    [
                        'name' => $name,
                        'user_id' => $user_id,
                        'recieved_call' => $callKnowObjArrData['inCall'],
                        'missed_call' => $callKnowObjArrData['outCall'],
                        'average_call' => 0,
                        'updated_at' => date('Y-m-d H:i:s'),

                    ]
                );
        }
    }


    //Last 30 Days knowlarity sales in or out call

    //LAST 30 DAYS
    public static function getLast30daysCallRecivedData()
    {
        //insert 7 days call recived
        $agentArr = DB::table('agents_used')->whereNotNull('phone')->where('phone', '!=', 'False')->get();

        foreach ($agentArr as $key => $rowData) {

            $agentArrData = DB::table('agents')->where('phone', $rowData->phone)->first();
            if ($agentArrData == null) {
                $name = $rowData->phone;
                $user_id = "99999999";
            } else {
                $name = AyraHelp::getUser($rowData->user_id)->name;
                $user_id = $rowData->user_id;
            }
            $totalCallDuration = AyraHelp::getTotalCallDuration($rowData->phone, 30);

            DB::table('graph_30days')
                ->updateOrInsert(
                    ['phone' =>  $rowData->phone],
                    [
                        'name' => $name,
                        'user_id' => $user_id,
                        'recieved_call' => $totalCallDuration['NoofCall'],
                        'missed_call' => 0,
                        'average_call' => $totalCallDuration['totAvg'],
                        'updated_at' => date('Y-m-d H:i:s'),

                    ]
                );
        }
        //insert 7 days call recived

    }

    //LAST 30 DAYS
    public static function getLast7daysCallRecivedData()
    {
        //insert 7 days call recived
        $agentArr = DB::table('agents_used')->whereNotNull('phone')->where('phone', '!=', 'False')->get();

        foreach ($agentArr as $key => $rowData) {

            $agentArrData = DB::table('agents')->where('phone', $rowData->phone)->first();
            if ($agentArrData == null) {
                $name = $rowData->phone;
                $user_id = "99999999";
            } else {
                $name = AyraHelp::getUser($rowData->user_id)->name;
                $user_id = $rowData->user_id;
            }
            $totalCallDuration = AyraHelp::getTotalCallDuration($rowData->phone, 7);

            DB::table('graph_7days')
                ->updateOrInsert(
                    ['phone' =>  $rowData->phone],
                    [
                        'name' => $name,
                        'user_id' => $user_id,
                        'recieved_call' => $totalCallDuration['NoofCall'],
                        'missed_call' => 0,
                        'average_call' => $totalCallDuration['totAvg'],
                        'updated_at' => date('Y-m-d H:i:s'),

                    ]
                );
        }
        //insert 7 days call recived

    }
    //getClick2CallAllCallAssinedLead
    public static function getClick2CallAllCallAssinedLead()
    {
        $usersCallArr = DB::table('agents_used')->whereNotNull('phone')->where('phone', '!=', 'False')->get();
        foreach ($usersCallArr as $key => $rowData) {
            $phone = "+91" . $rowData->phone;
            AyraHelp::AssingedClicktoCallLead($phone);
        }
    }
    public static function AssingedClicktoCallLead($phone)
    {
        $usersCallArr = DB::table('click_calldata_api')->where('destination', $phone)->where('business_call_type', 'Phone')->whereNotNull('QUERY_ID')->get();
        foreach ($usersCallArr as $key => $rowData) {
            $clientNO = $rowData->customer_number;
            $QUERY_ID = $rowData->uuid;
            $call_duration = $rowData->call_duration;
            $agnetNO = $rowData->destination;
            $call_date = $rowData->call_date;
            $MOB = str_replace("+91", "+91-", $clientNO);
            $agnetNOP = str_replace("+91", "+91-", $agnetNO);
            DB::table('indmt_data')->insert(
                [
                    'SENDERNAME' => 'NA',
                    'SENDEREMAIL' => 'NA',
                    'SUBJECT' => 'NA',
                    'DATE_TIME_RE' => $call_date,
                    'GLUSR_USR_COMPANYNAME' => 'NA',
                    'MOB' => $MOB,
                    'COUNTRY_FLAG' => 'NA',
                    'ENQ_MESSAGE' => 'NA',
                    'ENQ_ADDRESS' => 'NA',
                    'ENQ_CITY' => 'NA',
                    'ENQ_STATE' => 'NA',
                    'PRODUCT_NAME' => 'NA',
                    'COUNTRY_ISO' => 'NA',
                    'EMAIL_ALT' => 'NA',
                    'MOBILE_ALT' => 'NA',
                    'PHONE' => 'NA',
                    'PHONE_ALT' => 'NA',
                    'IM_MEMBER_SINCE' => 'NA',
                    'QUERY_ID' => $QUERY_ID,
                    'QTYPE' => 'KNW',
                    'ENQ_CALL_DURATION' => $call_duration,
                    'ENQ_RECEIVER_MOB' => $agnetNOP,
                    'data_source' => 'KNW_LEAD',
                    'data_source_ID' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'DATE_TIME_RE_SYS' => $call_date,
                    'assign_to' => 134,

                ]
            );
        }
    }
    //getAllAgentsData
    public static function getAllAgentsData()
    {
        //save all number that  is used to call recieved : 14 JULY
        $usersCallArr = DB::table('indmt_data')->where('QTYPE', 'P')->where('data_source_ID', 1)->distinct('ENQ_RECEIVER_MOB')->get(['ENQ_RECEIVER_MOB']);

        foreach ($usersCallArr as $key => $rowData) {
            $users = DB::table('agents')->where('phone', $rowData->ENQ_RECEIVER_MOB)->first();

            DB::table('agents_used')
                ->updateOrInsert(
                    ['phone' => $rowData->ENQ_RECEIVER_MOB],
                    [
                        'user_id' => optional($users)->user_id,
                        'name' => optional($users)->name
                    ]
                );
        }
    }
    //getThisMonthKnowlarityMissedCallAPI
    public static function getThisMonthKnowlarityMissedCallAPI()
    {
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }
        DB::table('graph_currentm_knowlarity_missed_call')->delete();
        foreach ($list as $key => $row) {

            $users_API_1 = DB::table('indmt_data')->where('QTYPE', 'B')->where('data_source', 'INDMART-9999955922@API_1')->whereDate('DATE_TIME_RE_SYS', $row)->get();
            $users_API_1 = DB::table('indmt_data')->where('QTYPE', 'B')->where('data_source', 'INDMART-8929503295@API_2')->whereDate('DATE_TIME_RE_SYS', $row)->get();

            DB::table('graph_currentm_knowlarity_missed_call')->insert(
                [

                    'day_date' => $row,
                    'missed_call' => 33,
                    'recieved_call' => 33,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
    }
    //getThisMonthKnowlarityMissedCallAPI
    // getThisMonthBuyLeadALL_API
    public static function getThisMonthBuyLeadALL_API()
    {
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }
        DB::table('graph_currentm_buylead_all_api')->delete();
        foreach ($list as $key => $row) {

            $users_API_1 = DB::table('indmt_data')->where('QTYPE', 'B')->where('data_source', 'INDMART-9999955922@API_1')->whereDate('DATE_TIME_RE_SYS', $row)->count();
            $users_API_2 = DB::table('indmt_data')->where('QTYPE', 'B')->where('data_source', 'INDMART-8929503295@API_2')->whereDate('DATE_TIME_RE_SYS', $row)->count();
            $users_API_5 = DB::table('indmt_data')->where('QTYPE', 'B')->where('data_source', 'INDMART-9811098426@API_5')->whereDate('DATE_TIME_RE_SYS', $row)->count();

            DB::table('graph_currentm_buylead_all_api')->insert(
                [

                    'day_date' => $row,
                    'api_1' => $users_API_1,
                    'api_2' => $users_API_2,
                    'api_3' => $users_API_5,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
    }
    // getThisMonthBuyLeadALL_API
    //getAllAgentsData
    public static function getClick2ThisMonthDataBoth()
    {

        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }
        DB::table('graph_currentm_knowlaritydata')->delete();
        foreach ($list as $key => $row) {

            $users_r = DB::table('click_calldata_api')->where('Call_Type', 0)->whereDate('call_date', $row)->count();
            $users_o = DB::table('click_calldata_api')->where('Call_Type', 1)->whereDate('call_date', $row)->count();

            DB::table('graph_currentm_knowlaritydata')->insert(
                [

                    'day_date' => $row,
                    'in_call' => $users_r,
                    'out_call' => $users_o,
                    'average_lead' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),

                ]
            );
        }
    }

    //getClick2CallAllCallAssinedLead
    public static function getClick2CallAllCall()
    {


        //save all number that  is used to call recieved 14 July

        $today = date('Y-m-d');
        $latDate = date('Y-m-d', strtotime('-1 day', strtotime($today)));


        $stDate = $latDate . '%2012:00:00+05:30';
        $etDate = date('Y-m-d') . '%2023:59:59+05:30';

        //$stDate='2020-07-1%2012:00:00+05:30';
        //$etDate='2020-07-20%2023:59:00+05:30';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kpi.knowlarity.com/Basic/v1/account/calllog?start_time='.$stDate.'&end_time='.$etDate.'&limit=500",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-api-key: GmfYXV6B887gFuYkCLtO65rWgQrKKONI8Do7YFt9",
                "Authorization: 6fa1c47c-9f98-4812-9ee3-e3fb282f927b"
            ),
        ));

        $response = curl_exec($curl);

        $mydata_arr = json_decode($response);
        if (isset($mydata_arr)) {

            foreach ($mydata_arr->objects as $key => $rowData) {
                $users = DB::table('click_calldata_api')->where('uuid', $rowData->uuid)->first();
                if ($users == null) {
                    $dateStr = explode('+', $rowData->start_time);
                    DB::table('click_calldata_api')->insert(
                        [
                            'user_id' => '1',
                            'agent_number' => $rowData->agent_number,
                            'customer_number' => $rowData->customer_number,
                            'uuid' => $rowData->uuid,
                            'agent_number_name' => 'd',
                            'call_duration' => $rowData->call_duration,
                            'business_call_type' => $rowData->business_call_type,
                            'api_id' => $rowData->id,
                            'order_id' => $rowData->order_id,
                            'destination' => $rowData->destination,
                            'Call_Type' => $rowData->Call_Type,
                            'call_recording' => $rowData->call_recording,
                            'knowlarity_number' => $rowData->knowlarity_number,
                            'start_time' => $rowData->start_time,
                            'call_date' => $dateStr[0],
                            'timezone_offset' => $rowData->timezone_offset,
                        ]
                    );
                }
            }
        }




        curl_close($curl);
    }
    public static function getActiveAgent()
    {
        $usersAgentArr = DB::table('agents')->where('is_active', 1)->get();


        return $usersAgentArr;
    }
    public static function getTotalDurationByAgentInsert($phone, $user_id)
    {
        //
        //save all number that  is used to call recieved : 14 JULY
        $usersCallArr = DB::table('indmt_data')->distinct('ENQ_RECEIVER_MOB')->get(['ENQ_RECEIVER_MOB']);
        foreach ($usersCallArr as $key => $rowData) {
            $users = DB::table('agents')->where('phone', $rowData->ENQ_RECEIVER_MOB)->first();

            DB::table('agents_used')
                ->updateOrInsert(
                    ['phone' => $rowData->ENQ_RECEIVER_MOB],
                    [
                        'user_id' => optional($users)->user_id,
                        'name' => optional($users)->name
                    ]
                );
        }


        //save all number that  is used to call recieved 14 July

        $i = 0;
        // $usersAgentArr = DB::table('indmt_data')->where('ENQ_RECEIVER_MOB',$phone)->where('ENQ_CALL_DURATION', '>=', 10)->get();/

        $usersAgentArr = DB::table('indmt_data')->where('ENQ_RECEIVER_MOB', $phone)->get();

        if (count($usersAgentArr) > 0) {

            $affected = DB::table('agents')
                ->where('phone', $phone)
                ->update(['is_bind' => 1]);

            foreach ($usersAgentArr as $key => $rowData) {


                $usersGetDataArr = DB::table('agent_calldata')->where('QUERY_ID', $rowData->QUERY_ID)->first();
                if ($usersGetDataArr == null) {
                    $i = $i + intVal($rowData->ENQ_CALL_DURATION);

                    // DB::table('agent_calldata')->insert(
                    //   [
                    //      'user_id' => $user_id,
                    //      'phone' => $rowData->ENQ_RECEIVER_MOB,
                    //      'call_duration' => intVal($rowData->ENQ_CALL_DURATION),
                    //      'from_where' => 1,
                    //      'QUERY_ID' => $rowData->QUERY_ID,
                    //      'api_name' => $rowData->data_source,
                    //      'created_at' => $rowData->DATE_TIME_RE_SYS,
                    //    ]
                    // );

                }
            }
        }


        return $i;
    }
    public static function getLeadCallDuractionByAgent()
    {

        $usersAgentArr = AyraHelp::getActiveAgent();
        foreach ($usersAgentArr as $key => $rowData) {
            $phone = $rowData->phone;
            $user_id = $rowData->user_id;
            AyraHelp::getTotalDurationByAgentInsert($phone, $user_id);
        }
    }

    public static function getTotalRecivedCallDurationThisMonth($date)
    {
        $callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->count();
        $callArrMissed = DB::table('indmt_data')->whereDate('created_at', '=', $date)->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE', 'P')->count();
        $callArrMissedA = DB::table('indmt_data')->whereDate('created_at', '=', $date)->where('ENQ_RECEIVER_MOB', "False")->where('QTYPE', 'P')->count();

        $data = array(
            'received' => $callArr,
            'missed' => $callArrMissed + $callArrMissedA
        );
        return $data;
    }


    //getMissedCallDataApi
    public static function getMissedCallDataApi($monthDigit, $year_digit)
    {
        $yearID = $year_digit;

        //$callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->whereNotNull('phone')->where('phone','!=','False')->get();
        // $callArr = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('user_id', '!=', '99999999')->count();

        // $callArrMissed = DB::table('indmt_data')->whereDate('created_at', '=', $date)->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->get();
        // $callArrMissedA = DB::table('indmt_data')->whereDate('created_at', '=', $date)->where('ENQ_RECEIVER_MOB',"False")->where('QTYPE','P')->get();

        $callArrMissed = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->whereNull('phone')->count();
        $callArrMissedA = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('phone', '=', 'False')->count();



        return $callArrMissed + $callArrMissedA;
    }

    //getMissedCallDataApi

    //getRecievedCallDataApi
    public static function getRecievedCallDataApi($monthDigit, $year_digit)
    {
        $yearID = $year_digit;

        //$callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->whereNotNull('phone')->where('phone','!=','False')->get();
        $callArr = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('user_id', '!=', '99999999')->count();

        // $callArrMissed = DB::table('indmt_data')->whereDate('created_at', '=', $date)->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->get();
        // $callArrMissedA = DB::table('indmt_data')->whereDate('created_at', '=', $date)->where('ENQ_RECEIVER_MOB',"False")->where('QTYPE','P')->get();

        // $callArrMissed = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->whereNull('phone')->count();
        // $callArrMissedA = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('phone', '=', 'False')->count();


        // $data = array(
        //     'received' => $callArr,
        //     'missed' => $callArrMissed + $callArrMissedA
        // );
        return $callArr;
    }
    //getRecievedCallDataApi

    public static function getTotalRecivedMessedCallMonthWise($monthDigit)
    {
        $yearID = 2023;

        //$callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->whereNotNull('phone')->where('phone','!=','False')->get();
        $callArr = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('user_id', '!=', '99999999')->count();

        // $callArrMissed = DB::table('indmt_data')->whereDate('created_at', '=', $date)->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->get();
        // $callArrMissedA = DB::table('indmt_data')->whereDate('created_at', '=', $date)->where('ENQ_RECEIVER_MOB',"False")->where('QTYPE','P')->get();

        $callArrMissed = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->whereNull('phone')->count();
        $callArrMissedA = DB::table('agent_calldata')->whereMonth('created_at', '=', $monthDigit)->whereYear('created_at', '=', $yearID)->where('phone', '=', 'False')->count();


        $data = array(
            'received' => $callArr,
            'missed' => $callArrMissed + $callArrMissedA
        );
        return $data;
    }


    public static function getTotalRecivedMessedCallThisMonth($date)
    {
        //$callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->whereNotNull('phone')->where('phone','!=','False')->get();
        $callArr = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->where('user_id', '!=', '99999999')->count();

        // $callArrMissed = DB::table('indmt_data')->whereDate('created_at', '=', $date)->whereNull('ENQ_RECEIVER_MOB')->where('QTYPE','P')->get();
        // $callArrMissedA = DB::table('indmt_data')->whereDate('created_at', '=', $date)->where('ENQ_RECEIVER_MOB',"False")->where('QTYPE','P')->get();

        $callArrMissed = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->whereNull('phone')->count();
        $callArrMissedA = DB::table('agent_calldata')->whereDate('created_at', '=', $date)->where('phone', '=', 'False')->count();


        $data = array(
            'received' => $callArr,
            'missed' => $callArrMissed + $callArrMissedA
        );
        return $data;
    }
    public static function getTotalCallDurationONLY($user_id, $days)
    {
        //$days=15;
        $date = \Carbon\Carbon::today()->subDays($days);
        $callArr = DB::table('agent_calldata')->where('user_id', $user_id)->where('created_at', '>=', $date)->get();
        $callArrTC = DB::table('agent_calldata')->where('user_id', $user_id)->where('created_at', '>=', $date)->count();
        $totCall = 0;
        $r = 0;
        foreach ($callArr as $key => $rowData) {
            $totCall = $totCall + $rowData->call_duration;
            $r++;
        }

        $NoofCall = $callArrTC; //no of call
        if ($r == 0) {
            $totalCallAvg = 0;
        } else {
            $totalCallAvg = $totCall / $NoofCall; //total call divide by no of call
        }



        return  array('NoofCall' => $NoofCall, 'totAvg' => $totalCallAvg);
    }
    // getTotalCallDurationWeekly
    public static function getTotalCallDurationWeekly($user_id)
    {
        //$days=15;
        //$date = \Carbon\Carbon::today()->subDays($days);

        $mond = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $sund = Carbon::now()->endOfWeek(Carbon::SATURDAY);


        $callArr = DB::table('agent_calldata')->where('user_id', $user_id)->whereBetween('created_at', [$mond, $sund])->get();
        $callArrTC = DB::table('agent_calldata')->where('user_id', $user_id)->whereBetween('created_at', [$mond, $sund])->count();

        $totCall = 0;
        $r = 0;
        foreach ($callArr as $key => $rowData) {
            $totCall = $totCall + $rowData->call_duration;
            $r++;
        }

        $NoofCall = $callArrTC; //no of call
        if ($r == 0) {
            $totalCallAvg = 0;
        } else {
            $totalCallAvg = $totCall / $NoofCall; //total call divide by no of call
        }



        return  array('NoofCall' => $NoofCall, 'totAvg' => $totalCallAvg);
    }


    // getTotalCallIN_OUT
    public static function getTotalCallIN_OUT($phone, $days)
    {
        //$days=15;
        $date = \Carbon\Carbon::today()->subDays($days);

        //  $callArr = DB::table('agent_calldata')->where('phone',$phone)->where('created_at', '>=', $date)->get();
        $phoneA = "+91" + $phone;
        $callArrClickCallIN = DB::table('click_calldata_api')->where('Call_Type', 0)->where('destination', $phone)->where('call_date', '>=', $date)->count();
        $callArrClickCallOUT = DB::table('click_calldata_api')->where('Call_Type', 1)->where('destination', $phone)->where('call_date', '>=', $date)->count();
        return  array('inCall' => $callArrClickCallIN, 'outCall' => $callArrClickCallOUT);
    }


    // getTotalCallIN_OUT

    // getTotalCallDurationWeekly

    public static function getTotalCallDuration($phone, $days)
    {
        //$days=15;
        $date = \Carbon\Carbon::today()->subDays($days);

        $callArr = DB::table('agent_calldata')->where('phone', $phone)->where('created_at', '>=', $date)->get();
        $callArrTC = DB::table('agent_calldata')->where('phone', $phone)->where('created_at', '>=', $date)->count();
        $phoneA = "+91" + $phone;

        // $callArrClickCall = DB::table('click_calldata_api')->where('destination', $phoneA)->where('call_date', '>=', $date)->get();
        // $totClick = count($callArrClickCall);


        $totCall = 0;
        $r = 0;
        foreach ($callArr as $key => $rowData) {
            $totCall = $totCall + $rowData->call_duration;
            $r++;
        }

        $NoofCall = $callArrTC; //no of call
        if ($r == 0) {
            $totalCallAvg = 0;
        } else {
            $totalCallAvg = $totCall / $NoofCall; //total call divide by no of call
        }



        return  array('NoofCall' => $NoofCall, 'totAvg' => $totalCallAvg);
    }

    public static function getTotalAssinedQualifiedLeadThisMonth($date)
    {
        $assinLead = DB::table('lead_assign')->whereDate('created_at', $date)->count();
        $qualifiedLead = DB::table('st_process_action_4')->whereDate('created_at', $date)->where('stage_id', 2)->where('action_on', 1)->count();
        return  array('assined' => $assinLead, 'qualified' => $qualifiedLead);
    }
    //=============================
    public static function getUserActualHour($uid, $sessID)
    {
        // echo $uid;
        // echo $sessID."<br>";



        $usersLogin = DB::table('login_activity')->where('user_id', $uid)->where('created_on', $sessID)->get();
        $totHour = 0;
        foreach ($usersLogin as $key => $rowData) {
            //  print_r($usersLogin);
            $startTime1 = $rowData->login_start;
            $finishTime1 = $rowData->logout_start;

            $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime1);
            $finishTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $finishTime1);
            $miVal = $finishTime->diffInSeconds($startTime);

            $totHour = $totHour + $miVal;
        }
        $s = $totHour % 60;
        $m = floor(($totHour % 3600) / 60);
        $h = floor(($totHour % 86400) / 3600);
        $d = floor(($totHour % 2592000) / 86400);
        $M = floor($totHour / 2592000);

        //return "$M months, $d days, $h hours, $m minutes, $s seconds";
        return "$h Hr, $m min, $s sec";
    }


    public static function getUserActiveStatus($uid)
    {

        $str = "";
        $users = DB::table('users')->select('last_activetime', 'email as user_email')->where('id', $uid)->first();
        if ($users == null) {
            $str = "error";
        } else {
            $startTime1 = optional($users)->last_activetime;
            if (IS_NULL($startTime1)) {
                $startTime1 = "2020-05-21 20:10:02";
            }
            $todayTime = date('Y-m-d H:i:s');
            $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime1);
            $finishTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $todayTime);
            $miVal = $finishTime->diffInSeconds($startTime) / 60;
            //echo $miVal=gmdate('s', $totalDuration);


            if ($miVal <= 5) {
                $str = "success";
            }

            if ($miVal >= 5 && $miVal <= 14) {
                $str = "warning";
            }
            if ($miVal >= 15) {
                $str = "danger";
            }
        }

        return $str;
    }

    public static function ClientAccessTRANSFER_fromTO()
    {
        //UPDATE `clients` SET `added_by` = '100' WHERE `clients`.`id` = 1808;
        //UPDATE `samples` SET `created_by` = '100' WHERE `samples`.`client_id` = 1808;
        //UPDATE `client_notes` SET `user_id` = '100' WHERE `client_notes`.`clinet_id` = 1808;
        //UPDATE `qc_forms` SET `created_by` = '100' WHERE `qc_forms`.`client_id` = 1808;


    }

    public static function setClientALLAccessToUser()
    {
        $accessTo = 85;
        $users_arr = DB::table('clients')->where('is_deleted', 0)->get();

        foreach ($users_arr as $key => $rowData) {
            $created_by = $rowData->added_by;
            $clientid = $rowData->id;
            DB::table('users_access')
                ->updateOrInsert(
                    ['access_to' => $accessTo, 'client_id' => $clientid],
                    [
                        'access_by' => $created_by,
                        'access_to' => $accessTo,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => $created_by,
                        'user_exp_date' => '2020-10-10',
                        'client_id' => $clientid,
                        'access_from' => 1,
                    ]
                );
        }
    }

    public static function getPhoneCallDuplicate($QTYPE, $MOB)
    {


        if ($QTYPE == 'P') {

            $mylead = DB::table('indmt_data')
                ->where('QTYPE', $QTYPE)
                ->where('MOB', $MOB)
                ->first();

            if ($mylead != null) {
                return  0; //mil gaya
            } else {
                return  1; //nahi mila
            }
        } else {
            return  1; //nahi mila
        }
    }
    public static function ClientAccessFullTRANSFER()
    {
        $user_from = 99;
        $user_to = 133;
        $data_arr_data = DB::table('clients')->where('added_by', $user_from)->get();
        //client
        foreach ($data_arr_data as $key => $rowData) {

            DB::table('clients')
                ->where('added_by', $user_from)
                ->update(['client_owner_too' => $user_from]);
        }

        foreach ($data_arr_data as $key => $rowData) {

            DB::table('clients')
                ->where('added_by', $user_from)
                ->update(['added_by' => $user_to]);
        }
        //sample

        $data_arr_data_SAMPLE = DB::table('samples')->where('created_by', $user_from)->get();

        foreach ($data_arr_data_SAMPLE as $key => $rowData) {

            DB::table('samples')
                ->where('created_by', $user_from)
                ->update(['client_owner_too' => $user_from]);
        }
        foreach ($data_arr_data_SAMPLE as $key => $rowData) {

            DB::table('samples')
                ->where('created_by', $user_from)
                ->update(['created_by' => $user_to]);
        }

        //notes


        $data_arr_data_NOTES = DB::table('client_notes')->where('user_id', $user_from)->get();

        foreach ($data_arr_data_NOTES as $key => $rowData) {

            DB::table('client_notes')
                ->where('user_id', $user_from)
                ->update(['client_owner_too' => $user_from]);
        }
        foreach ($data_arr_data_NOTES as $key => $rowData) {

            DB::table('client_notes')
                ->where('user_id', $user_from)
                ->update(['user_id' => $user_to]);
        }
        //orders

        $data_arr_data_ORDERS = DB::table('qc_forms')->where('created_by', $user_from)->get();

        foreach ($data_arr_data_ORDERS as $key => $rowData) {

            DB::table('qc_forms')
                ->where('created_by', $user_from)
                ->update(['client_owner_too' => $user_from]);
        }
        foreach ($data_arr_data_ORDERS as $key => $rowData) {

            DB::table('qc_forms')
                ->where('created_by', $user_from)
                ->update(['created_by' => $user_to]);
        }

        echo "completed";
        die;


        //UPDATE `clients` SET `added_by` = '100' WHERE `clients`.`id` = 1808;
        //UPDATE `samples` SET `created_by` = '100' WHERE `samples`.`client_id` = 1808;
        //UPDATE `client_notes` SET `user_id` = '100' WHERE `client_notes`.`clinet_id` = 1808;
        //UPDATE `qc_forms` SET `created_by` = '100' WHERE `qc_forms`.`client_id` = 1808;




    }
    public static function LeadCorrection2()
    {
        //$data_arr_data = DB::table('temp_lead_sale_statge')->get();

        $data_arr_data = DB::table('temp_lead_sale_statge')
            ->join('indmt_data', 'temp_lead_sale_statge.QUERY_ID', '=', 'indmt_data.QUERY_ID')
            ->where('temp_lead_sale_statge.assign_person', '=', 76)
            //->orderBy('lead_assign.created_at','desc')
            ->select('indmt_data.assign_to')
            ->get();
        echo "<pre>";
        print_r(count($data_arr_data));


        die;

        foreach ($data_arr_data as $key => $rowData) {

            switch ($rowData->curr_stage_name) {
                case 'Assigned':
                    $st = 1;
                    break;
                case 'Qualified':
                    $st = 2;
                    break;
                case 'Sampling':
                    $st = 3;
                    break;
                case 'Client':
                    $st = 4;
                    break;
                case 'Repeat Client':
                    $st = 5;
                    break;
                case 'Lost':
                    $st = 6;
                    break;
            }


            // $data_arr_data_arr = DB::table('st_process_action_4')->where('ticket_id',$rowData->QUERY_ID)->where('stage_id',$st)->get();
            // if(count($data_arr_data_arr)>1){
            //     echo $rowData->QUERY_ID."->";
            //     echo $rowData->assign_person."<br>";

            // }

            $data_arr_data_arr = DB::table('st_process_action_4')->where('ticket_id', $rowData->QUERY_ID)->where('stage_id', $st)->first();

            if ($data_arr_data_arr == null) {

                if ($st == 1) {
                    DB::table('st_process_action_4')->insert(
                        [
                            'process_id' => 4,
                            'stage_id' => $st,
                            'action_on' => 1,
                            'ticket_id' => $rowData->QUERY_ID,
                            'remarks' => 'Scrpted',
                            'assigned_id' => $rowData->assign_person,
                            'updated_by' => 77,
                            'completed_by' => 77,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                        ]
                    );
                } else {
                    DB::table('st_process_action_4')->insert(
                        [
                            'process_id' => 4,
                            'stage_id' => 1,
                            'action_on' => 1,
                            'ticket_id' => $rowData->QUERY_ID,
                            'remarks' => 'Scrpted',
                            'assigned_id' => $rowData->assign_person,
                            'updated_by' => 77,
                            'completed_by' => 77,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                        ]
                    );
                    DB::table('st_process_action_4')->insert(
                        [
                            'process_id' => 4,
                            'stage_id' => $st,
                            'action_on' => 1,
                            'ticket_id' => $rowData->QUERY_ID,
                            'remarks' => 'Scrpted',
                            'assigned_id' => $rowData->assign_person,
                            'updated_by' => 77,
                            'completed_by' => 77,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                        ]
                    );
                }
            }
        }
    }
    public static function LeadCorrection1()
    {
        $data_arr_data = DB::table('temp_lead_sale_statge')->get();
        foreach ($data_arr_data as $key => $rowData) {

            $data_arr_data = DB::table('lead_assign')->where('QUERY_ID', $rowData->QUERY_ID)->first();
            if ($data_arr_data == null) {
            } else {

                DB::table('lead_assign')
                    ->where('QUERY_ID', $rowData->QUERY_ID)
                    ->where('assign_user_id', $rowData->assign_person)
                    ->update(['temp_del' => 7]);
            }
        }
    }
    public static function LeadCorrection()
    {

        $user_arr = [1, 8, 9, 40, 96, 86, 76, 100, 119, 4, 3, 102, 90, 85, 129, 99];
        foreach ($user_arr as $key => $usrs) {
            // echo $usrs."<br>";


            //$user_id=76;
            $data_arr_data = DB::table('indmt_data')
                ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
                ->where('lead_assign.assign_user_id', '=', $usrs)
                ->orderBy('lead_assign.created_at', 'desc')
                ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                ->get();

            foreach ($data_arr_data as $key => $value) {
                $AssignName = AyraHelp::getLeadAssignUser($value->QUERY_ID);
                //echo $value->QUERY_ID;
                //----------------------------
                if ($value->lead_status == 0 ||  $value->lead_status == 1 || $value->lead_status == 4) {
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
                    }
                } else {
                    $data_leadAssign = AyraHelp::isAssignLea($value->QUERY_ID);
                    if ($data_leadAssign == 1) {
                        $curr_lead_stage = AyraHelp::getCurrentStageLEAD($value->QUERY_ID);
                        $st_name = $curr_lead_stage->stage_name;
                    } else {
                    }
                }

                //----------------------------

                switch ($st_name) {
                    case 'Assigned':
                        $st = 1;

                        break;
                    case 'Qualified':
                        $st = 2;
                        break;
                    case 'Sampling':
                        $st = 3;
                        break;
                    case 'Client':
                        $st = 4;
                        break;
                    case 'Repeat Client':
                        $st = 5;
                        break;
                    case 'Lost':
                        $st = 6;
                        break;
                }

                if ($st_name == 'Assigned' || $st_name == 'Qualified' || $st_name == 'Sampling' || $st_name == 'Client' || $st_name == 'Repeat Client' ||  $st_name == 'Lost'  ||  $st_name == 'Unqualified') {


                    $data_arr_data_arr = DB::table('temp_lead_sale_statge')->where('QUERY_ID', $value->QUERY_ID)->first();
                    if ($data_arr_data_arr == null) {

                        DB::table('temp_lead_sale_statge')->insert(
                            [
                                'QUERY_ID' => $value->QUERY_ID,
                                'assign_person' => $usrs,
                                'curr_statge_id' => 5,
                                'curr_stage_name' => $st_name,
                                'assigned_name' => $AssignName,
                            ]
                        );
                    }
                }


                // echo "<br>";
            }
        }

        //print_r(count($data_arr_data));




    }
    //setUniqueLead
    public static function setUniqueLead()
    {
        $data_arr_data = DB::table('indmt_data')->select('id', 'MOB', 'SENDEREMAIL')->where('lead_status', 0)->get();
        foreach ($data_arr_data as $key => $rowData) {
            //  print_r($rowData->MOB);
            //print_r($rowData->id);
            $affected = DB::table('indmt_data')
                ->where('SENDEREMAIL', $rowData->SENDEREMAIL)
                ->where('lead_status', 0)
                ->limit(1)
                ->update(['is_uniqueLead' => 1]);

            // $data_arr_dataA = DB::table('indmt_data')->where('MOB', $rowData->MOB)->count();       
            // if($data_arr_dataA>1){

            //     $affected = DB::table('indmt_data')
            //     ->where('MOB', $rowData->MOB)
            //     ->where('lead_status', 0)
            //     ->limit(1)                
            //     ->update(['is_uniqueLead' => 1]);

            // }







        }
    }
    //setUniqueLead


    public static function getOrderForDispatch()
    {

        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', 1)->get();


        return $qc_arr;
    }
    //get duplicateLead
    public static function getDuplicateLead()
    {
        $days = 3;
        $date = \Carbon\Carbon::today()->subDays($days);

        $duplicates = DB::table('indmt_data')
            ->select('QUERY_ID', 'MOB')
            ->where('lead_status', 0)
            ->whereDate('created_at', '>=', $date)
            //->whereNotNull('ENQ_MESSAGE')
            ->whereIn('MOB', function ($q) {
                $q->select('MOB')
                    ->from('indmt_data')
                    ->groupBy('MOB')
                    ->havingRaw('COUNT(*) > 1');
            })->get();
        // echo count($duplicates);


        foreach ($duplicates as $key => $rowData) {
            //print_r($rowData->QUERY_ID);
            //------------------------
            DB::table('indmt_data')
                ->where('QUERY_ID', $rowData->QUERY_ID)
                ->update([
                    'duplicate_lead_status' => 1,
                    'lead_status' => 101,
                ]);
            //-----------------------

        }

        $duplicates = DB::table('indmt_data')
            ->select('QUERY_ID', 'SENDEREMAIL')
            ->where('lead_status', 0)
            ->whereDate('created_at', '>=', $date)
            //->whereNotNull('ENQ_MESSAGE')
            ->whereIn('SENDEREMAIL', function ($q) {
                $q->select('SENDEREMAIL')
                    ->from('indmt_data')
                    ->groupBy('SENDEREMAIL')
                    ->havingRaw('COUNT(*) > 1');
            })->get();
        // echo count($duplicates);


        foreach ($duplicates as $key => $rowData) {
            //print_r($rowData->QUERY_ID);
            //-----------------------
            DB::table('indmt_data')
                ->where('QUERY_ID', $rowData->QUERY_ID)
                ->update([
                    'duplicate_lead_status' => 1,
                    'lead_status' => 101
                ]);
            //-----------------------

        }
    }

    //get duplicateLead

    public static function getTodayLeadData()
    {
        $qcdata_arr = DB::table('indmt_data')->whereDate('created_at', '=', date('Y-m-d'))->get();

        foreach ($qcdata_arr as $key => $rowData) {
            echo $rowData->QUERY_ID . "=" . $rowData->SENDERNAME . "=" . $rowData->SENDEREMAIL . "=" . $rowData->PHONE . "<br>";
        }
        //return $qcdata_arr;

    }

    public static function AssignToRUN()
    {

        $FPData = DB::table('indmt_data')
            ->rightjoin('lead_notes', 'indmt_data.QUERY_ID', '=', 'lead_notes.QUERY_ID')
            ->select('indmt_data.*')
            ->get();

        foreach ($FPData as $key => $rowData) {

            $FPDataList = DB::table('lead_assign')->where('QUERY_ID', $rowData->QUERY_ID)->first();
            if ($FPDataList == null) {

                // DB::table('indmt_data')
                // ->where('QUERY_ID',$rowData->QUERY_ID)
                // ->update(['lead_status' =>55]);

            }
        }
    }


    // public static function getMyAllClientHaveOrderByCID($cid){

    //     $order_arrTC = DB::table('qc_forms')->where('account_approval',1)->where('client_id', $cid)->where('is_deleted', 0)->count();
    //     if($order_arrTC>0){
    //         DB::table('clients')
    //         ->where('id', $cid)
    //         ->update(['have_order' => 1,'have_order_count' => $order_arrTC]);
    //     }
    // }


    public static function getMyAllClient()
    {
        $client_arr = DB::table('clients')->where('is_deleted', 0)->get();

        foreach ($client_arr as $key => $clientRow) {

            //$order_arr = DB::table('qc_forms')->where('client_id', $clientRow->id)->where('is_deleted', 0)->get();
            //$order_arrTC = DB::table('qc_forms')->where('account_approval',1)->where('client_id', $clientRow->id)->where('is_deleted', 0)->count();
            $order_arrTC = DB::table('qc_forms')->where('client_id', $clientRow->id)->where('is_deleted', 0)->count();


            if ($order_arrTC > 0) {
                DB::table('clients')
                    ->where('id', $clientRow->id)
                    ->update(['have_order' => 1, 'have_order_count' => $order_arrTC]);
            }



            // if (count($order_arr) > 0) {
            //     $orderHave[] = array(
            //         'cid' => $clientRow->id,
            //         'firstname' => $clientRow->firstname,
            //         'company' => $clientRow->company,
            //         'brand' => $clientRow->brand,
            //         'sid' => $clientRow->added_by,
            //         'sid_name' => AyraHelp::getUser($clientRow->added_by)->name,
            //         'order_count' => $order_arrTC

            //     );
            // } else {
            //     DB::table('clients')
            //         ->where('id', $clientRow->id)
            //         ->update(['temp_deleted' => 1]);

            //     //      DB::table('samples')
            //     // ->where('client_id', $clientRow->id)
            //     // ->update(['have_order' => 1]);


            // }
        }

        //print_r($orderHave);



    }
    public static function getMyAllClient2()
    {
        $client_arr = DB::table('clients')->where('is_deleted', 0)->where('temp_deleted', 1)->get();
        $i = 0;

        foreach ($client_arr as $key => $row) {
            $i++;

            $DATE_TIME_RE = date("d-M-Y H:i:s A", strtotime($row->created_at));
            $QUERY_ID = AyraHelp::getSALE_QUERYID();

            DB::table('client_sales_lead')->insert(
                [

                    'SENDERNAME' => $row->firstname,
                    'SENDEREMAIL' => $row->email,
                    'SUBJECT' => 'Archived Client Lead',
                    'DATE_TIME_RE' => $DATE_TIME_RE,
                    'GLUSR_USR_COMPANYNAME' => $row->company,
                    'GLUSR_USR_BRANDNAME' => $row->brand,
                    'MOB' => $row->phone,
                    'COUNTRY_FLAG' => '',
                    'ENQ_MESSAGE' => 'Archived Client Lead',
                    'ENQ_ADDRESS' => $row->address,
                    'ENQ_CITY' => $row->city,
                    'ENQ_STATE' => '',
                    'PRODUCT_NAME' => '',
                    'COUNTRY_ISO' => $row->country,
                    'EMAIL_ALT' => '',
                    'MOBILE_ALT' => '',
                    'PHONE' => '',
                    'PHONE_ALT' => '',
                    'IM_MEMBER_SINCE' => '',
                    'QUERY_ID' => $QUERY_ID,
                    'QTYPE' => 'OC',
                    'ENQ_CALL_DURATION' => '',
                    'ENQ_RECEIVER_MOB' => '',
                    'data_source' => 'OC_LEAD',
                    'data_source_ID' => 5,
                    'created_at' => $row->created_at,
                    'DATE_TIME_RE_SYS' => $row->created_at,
                    'assign_to' => $row->added_by,
                    'json_api_data' => json_encode($row),

                ]
            );
            ///save to st_process_action_5_mylead
            DB::table('st_process_action_5_mylead')->insert(
                [
                    'process_id' => 5,
                    'stage_id' => 1,
                    'action_on' => 1,
                    'ticket_id' => $QUERY_ID,
                    'remarks' => 'Auto Added ',
                    'assigned_id' => $row->added_by,
                    'updated_by' => $row->added_by,
                    'completed_by' => $row->added_by,
                    'created_at' => $row->created_at,
                    'expected_date' => $row->created_at,
                    'expected_date' => $row->created_at,
                ]
            );
            ///save to st_process_action_5_mylead




        }
        echo $i;

        //print_r($orderHave);



    }

    public static function getSaleInvoiceRequestCount()
    {
        $FPData = DB::table('sales_invoice_request')->where('is_deletd', 0)->where('view_status', 0)->count();


        return $FPData;
    }

    public static function getMyOrder()
    {
        $qc_arr = QCFORM::where('is_deleted', '!=', 1)->where('dispatch_status', '=', 1)->where('created_by', Auth::user()->id)->get();
        return $qc_arr;
    }
    public static function IsRepeatClientCheck($phone, $email)
    {
        $process_data = DB::table('clients')->where()->get();
    }
    public static function getLeadMissedRun()
    {
        $m = date('m');
        $daycountMonth = \Carbon\Carbon::now()->daysInMonth;

        $api_1 = array();
        $api_2 = array();
        $api_3 = array();
        $api_ori = array();
        for ($i = 1; $i <= $daycountMonth; $i++) {

            if ($i < date('d')) {
                //start 1

                //--------
                $products = DB::table('leadcron_run_log')
                    ->whereMonth('lrun_day_date', $m)
                    ->whereDay('lrun_day_date', $i)
                    ->where('api_details', 'INDMART-8929503295@API_2')
                    ->first();
                if ($products == null) {

                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_1[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'INDMART-8929503295@API_2',
                        );
                    }
                }
                //--------
                //stop 1
                //start 2
                //--------
                $products = DB::table('leadcron_run_log')
                    ->whereMonth('lrun_day_date', $m)
                    ->whereDay('lrun_day_date', $i)
                    ->where('api_details', 'INDMART-9999955922@API_1')
                    ->first();
                if ($products == null) {

                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_1[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'INDMART-9999955922@API_1',
                        );
                    }
                }
                //--------
                //stop 2
                //start 3
                //--------
                $products = DB::table('leadcron_run_log')
                    ->whereMonth('lrun_day_date', $m)
                    ->whereDay('lrun_day_date', $i)
                    ->where('api_details', 'TRADEINDIA-8850185@API_3')
                    ->first();
                if ($products == null) {

                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_1[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'TRADEINDIA-8850185@API_3',
                        );
                    }
                }
                //--------
                //stop 3



            }
        }

        $api_ori = array_merge($api_1, $api_2, $api_3);


        return $api_ori;
    }
    public static function getLeadMissedRunD()
    {

        $m = 2;
        // $process_data = DB::table('leadcron_run_log')->where()->get();
        $api_1 = array();
        $api_2 = array();
        $api_3 = array();
        $api_ori = array();


        for ($i = 1; $i <= 31; $i++) {

            //-------------------------------------
            $products = DB::table('leadcron_run_log')
                ->whereMonth('created_at', $m)
                ->whereDay('created_at', $i)
                ->where('run_status', 0)
                ->where('api_details', 'INDMART-8929503295@API_2')
                ->first();
            if ($products == null) {
                if (isset($products->last_update)) {
                    echo '44';
                } else {
                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_1[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'INDMART-8929503295@API_2',
                        );
                    }
                }
            }

            //-------------------------------------


            //-------------------------------------
            $products = DB::table('leadcron_run_log')
                ->whereMonth('created_at', $m)
                ->whereDay('created_at', $i)
                ->where('run_status', 0)
                ->where('api_details', 'INDMART-9999955922@API_1')
                ->first();
            if ($products == null) {

                if (isset($products->last_update)) {
                    echo '44';
                } else {
                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_2[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'INDMART-9999955922@API_1'
                        );
                    }
                }
            }

            //-------------------------------------

            //-------------------------------------
            $products = DB::table('leadcron_run_log')
                ->whereMonth('created_at', $m)
                ->whereDay('created_at', $i)
                ->where('run_status', 0)
                ->where('api_details', 'TRADEINDIA-8850185@API_3')
                ->first();
            if ($products == null) {
                if (isset($products->last_update)) {
                    echo '44';
                } else {
                    $input = $i . "-" . $m . "-" . date('Y') . " 19:00:00";
                    $date = strtotime($input);
                    $st = date('d-M-Y H:i:s', $date);
                    $start_date = date('d-M-Y H:i:s', strtotime($st . '-1 day'));
                    $stop_date = date('d-M-Y H:i:s', strtotime($st . '+4 hour'));

                    $dateTimestamp1 = strtotime($stop_date);
                    $dateTimestamp2 = strtotime(date('d-M-Y H:i:s'));

                    if ($dateTimestamp1 >= $dateTimestamp2) {
                    } else {
                        $api_3[] = array(
                            'start_date' => $start_date,
                            'stop_date' => $stop_date,
                            'api' => 'TRADEINDIA-8850185@API_3'
                        );
                    }
                }
            }

            //-------------------------------------


        }
        $api_ori = array_merge($api_1, $api_2, $api_3);


        return $api_ori;
    }



    public static function getAllIrrevantLeadDonebyUser($userid)
    {
        $data_arr_data = DB::table('indmt_data')

            //->where('lead_assign.assign_user_id', '=',$userid)
            ->where('indmt_data.lead_status', '=', 1)


            ->count();
        return $data_arr_data;
    }


    public static function getAllUnQlifiedLeadDonebyUser($userID)
    {
        // $data_arr_data = DB::table('indmt_data')
        //     ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
        //     ->where('lead_assign.assign_user_id', '=', $userid)
        //     ->where('indmt_data.lead_status', '=', 4)
        //     ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
        //     ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
        //     ->get();
        $data_arr_dataLUNQ = DB::table('indmt_data')
            ->where('indmt_data.assign_to', '=', $userID)
            ->where('indmt_data.lead_status', '=', 4)
            ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
            ->select('indmt_data.*')
            ->count();

        return $data_arr_dataLUNQ;
    }
    public static function getLeadAssigntCountByUser($userid)
    {
        // $userid=76;
        if ($userid == 1 || $userid == 76 || $userid == 129 || $userid == 9 || $userid == 8 || $userid == 100 || $userid == 99 || $userid == 3 || $userid == 102 || $userid == 90 || $userid == 2  || $userid == 86 || $userid == 40 || $userid == 86 || $userid == 125 || $userid == 4 || $userid == 119 || $userid == 120 || $userid == 96 || $userid == 133 || $userid == 137) {

            //------------------------------

            $data_arr_data = DB::table('indmt_data')
                ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
                ->where('lead_assign.assign_user_id', '=', $userid)
                // ->where('indmt_data.assign_to', '=',$userid)
                ->orderBy('indmt_data.DATE_TIME_RE_SYS', 'desc')
                ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                ->get();




            $st_1 = 0;
            $st_2 = 0;
            $st_3 = 0;
            $st_4 = 0;
            $st_5 = 0;
            $st_6 = 0;


            foreach ($data_arr_data as $key => $rowData) {
                $QUERY_ID = $rowData->QUERY_ID;
                $curr_lead_stage = AyraHelp::getCurrentStageLEAD($QUERY_ID);

                $st_name = $curr_lead_stage->stage_name;
                switch ($curr_lead_stage->stage_id) {
                    case 1:
                        $st_1++;
                        break;
                    case 2:
                        $st_2++;
                        break;
                    case 3:
                        $st_3++;
                        break;
                    case 4:
                        $st_4++;
                        break;
                    case 5:
                        $st_5++;
                        break;
                    case 6:
                        $st_6++;
                        break;
                }
            }

            $mydata = array(
                'st_1' => $st_1,
                'st_2' => $st_2,
                'st_3' => $st_3,
                'st_4' => $st_4,
                'st_5' => $st_5,
                'st_6' => $st_6,
                'st_tot' => ($st_1 + $st_2 + $st_3 + $st_4 + $st_5 + $st_6)

            );
            //------------------------------



        } else {


            $mydata = array(
                'st_1' => '',
                'st_2' => '',
                'st_3' => '',
                'st_4' => '',
                'st_5' => '',
                'st_6' => '',
                'st_tot' => '',

            );
        }


        return $mydata;
    }
    //setAssinedLeadProccessLead
    public static function setAssinedLeadProccessLead()
    {

        $process_data = DB::table('lead_assign')->get();
        foreach ($process_data as $key => $rowData) {
            $QUERY_ID = $rowData->QUERY_ID;
            $process_data_arr = DB::table('st_process_action_4_temp')->where('merge', 0)->where('ticket_id', $QUERY_ID)->get();
            foreach ($process_data_arr as $key => $row) {

                $process_data_arr = DB::table('st_process_action_4')->where('stage_id', $row->stage_id)->where('ticket_id', $row->ticket_id)->first();
                if ($process_data_arr == null) {
                    DB::table('st_process_action_4')->insert(
                        [
                            'process_id' => $row->process_id,
                            'stage_id' => $row->stage_id,
                            'action_on' => $row->action_on,
                            'ticket_id' =>  $row->ticket_id,
                            'remarks' =>  $row->remarks,
                            'assigned_id' => $row->assigned_id,
                            'updated_by' => $row->updated_by,
                            'completed_by' => $row->completed_by,
                            'created_at' => $row->created_at,
                            'expected_date' => $row->expected_date,
                            'expected_date' => $row->expected_date,
                            'is_added' => 1,
                        ]
                    );

                    $affected = DB::table('st_process_action_4_temp')
                        ->where('stage_id', $row->stage_id)->where('ticket_id', $row->ticket_id)
                        ->update(['merge' => 1]);
                } else {
                    $affected = DB::table('st_process_action_4_temp')
                        ->where('stage_id', $row->stage_id)->where('ticket_id', $row->ticket_id)
                        ->update(['merge' => 9]);
                }
            }
        }
    }
    //getAllWorkingUserIncentive
    public static function getAllWorkingUserIncentive()
    {
        $clients_arr = User::where('is_deleted', 0)->where('is_incentive_active', 1)->whereNotNull('mac_address')->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead")->orwhere("name", "Staff")->orwhere("name", "User");
        })->get();
        foreach ($clients_arr as $key => $rowData) {
            $emp_arr = AyraHelp::getProfilePIC($rowData->id);
            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }
            $data[] = array(
                'sales_name' => $rowData->name,
                'uid' => $rowData->id,
                'profilePic' => $img_photo,

            );
        }
        return $data;
    }
    //getAllWorkingUserIncentive
    public static function getAllWorkingUserIncentiveRND()
    {
        $clients_arr = User::where('is_deleted', 0)->where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "chemist");
        })->get();
        foreach ($clients_arr as $key => $rowData) {
            $emp_arr = AyraHelp::getProfilePIC($rowData->id);
            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }
            $data[] = array(
                'sales_name' => $rowData->name,
                'uid' => $rowData->id,
                'profilePic' => $img_photo,

            );
        }
        return $data;
    }

    //setAssinedLeadProccessLead
    public static function getAllWorkingUser()
    {
        $clients_arr = User::where('is_deleted', 0)->whereNotNull('mac_address')->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead")->orwhere("name", "Staff")->orwhere("name", "User");
        })->get();
        foreach ($clients_arr as $key => $rowData) {
            $emp_arr = AyraHelp::getProfilePIC($rowData->id);
            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }
            $data[] = array(
                'sales_name' => $rowData->name,
                'uid' => $rowData->id,
                'profilePic' => $img_photo,

            );
        }
        return $data;
    }

    public static function getLeadStageDistributionBymonth($month_id)
    {
        $usersCallArr = DB::table('lead_assign')->distinct('assign_user_id')->get(['assign_user_id']);
        foreach ($usersCallArr as $key => $rowData) {
            $userID = $rowData->assign_user_id;
            // $userID=40;
            $st_1 = 0;
            $st_2 = 0;
            $st_3 = 0;
            $st_4 = 0;
            $st_5 = 0;
            $st_6 = 0;

            $data_arr_dataLUNQ = DB::table('lead_assign')
                ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
                ->where('lead_assign.assign_user_id', '=', $userID)
                //->where('indmt_data.lead_status', '=', 0)
                ->where('indmt_data.lead_status', '=', 4)
                ->whereMonth('indmt_data.created_at', '=', '08')
                // ->whereMonth('indmt_data.created_at', '=', '08')
                // ->whereYear('indmt_data.created_at', '=', 2020)
                ->orderBy('lead_assign.created_at', 'desc')
                ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                ->get();

            $data_arr_dataLUNQ_TC = DB::table('lead_assign')
                ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
                ->where('lead_assign.assign_user_id', '=', $userID)
                //->where('indmt_data.lead_status', '=', 0)
                ->where('indmt_data.lead_status', '=', 4)
                ->whereMonth('indmt_data.created_at', '=', '08')
                // ->whereMonth('indmt_data.created_at', '=', '08')
                // ->whereYear('indmt_data.created_at', '=', 2020)
                ->orderBy('lead_assign.created_at', 'desc')
                ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                ->get();

            $process_data = DB::table('st_process_action_4')->where('completed_by', $userID)->whereMonth('created_at', '=', '08')->get();

            foreach ($process_data as $key => $rowData) {
                //print_r($rowData->stage_id);

                switch ($rowData->stage_id) {
                    case 1:
                        $st_1++;
                        break;

                    case 2:
                        $st_2++;
                        break;
                    case 3:
                        $st_3++;
                        break;
                    case 4:
                        $st_4++;
                        break;
                    case 5:
                        $st_5++;
                        break;
                    case 6:
                        $st_6++;
                        break;
                }
            }

            DB::table('tbl_leadstage_reports')
                ->updateOrInsert(
                    ['user_id' => $userID],
                    [
                        'name' => AyraHelp::getUser($userID)->name,
                        'month' => 'AUG',
                        'assined' => $st_1,
                        'qualified' => $st_2,
                        'sampling' => $st_3,
                        'repeat_client' => $st_4,
                        'client' => $st_5,
                        'lost' => $st_6,
                        'disqualified' => $data_arr_dataLUNQ_TC



                    ]
                );
        }
    }
    public static function getLeadDistributionV1()
    {



        $usersCallArr = DB::table('lead_assign')->distinct('assign_user_id')->get(['assign_user_id']);
        foreach ($usersCallArr as $key => $rowData) {
            $userID = $rowData->assign_user_id;
            $dataID = AyraHelp::getUser($userID)->is_deleted;
            if ($dataID == 0) {



                // $userID=40;
                $st_1 = 0;
                $st_2 = 0;
                $st_3 = 0;
                $st_4 = 0;
                $st_5 = 0;
                $st_6 = 0;


                $data_arr_data = DB::table('lead_assign')
                    ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
                    ->where('lead_assign.assign_user_id', '=', $userID)
                    //->where('indmt_data.lead_status', '=', 0)
                    ->where('indmt_data.lead_status', '!=', 4)
                    //  ->whereMonth('lead_assign.created_at', '=', '08')
                    // ->whereYear('lead_assign.created_at', '=', '2020')
                    ->orderBy('lead_assign.created_at', 'desc')
                    ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                    ->get();


                $data_arr_dataLUNQ = DB::table('lead_assign')
                    ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
                    ->where('lead_assign.assign_user_id', '=', $userID)
                    //->where('indmt_data.lead_status', '=', 0)
                    ->where('indmt_data.lead_status', '=', 4)
                    //  ->whereMonth('lead_assign.created_at', '=', '08')
                    // ->whereYear('lead_assign.created_at', '=', '2020')
                    ->orderBy('lead_assign.created_at', 'desc')
                    ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                    ->get();
                $data_arr_dataLUNQTC = DB::table('lead_assign')
                    ->join('indmt_data', 'lead_assign.QUERY_ID', '=', 'indmt_data.QUERY_ID')
                    ->where('lead_assign.assign_user_id', '=', $userID)
                    //->where('indmt_data.lead_status', '=', 0)
                    ->where('indmt_data.lead_status', '=', 4)
                    //  ->whereMonth('lead_assign.created_at', '=', '08')
                    // ->whereYear('lead_assign.created_at', '=', '2020')
                    ->orderBy('lead_assign.created_at', 'desc')
                    ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
                    ->count();





                foreach ($data_arr_data as $key => $rowIND) {
                    $QUERY_ID = $rowIND->QUERY_ID;

                    $process_data = DB::table('st_process_action_4')->where('action_on', 1)->where('ticket_id', $QUERY_ID)->latest()->first();

                    switch ($process_data->stage_id) {
                        case 1:
                            $st_1++;
                            break;

                        case 2:
                            $st_2++;
                            break;
                        case 3:
                            $st_3++;
                            break;
                        case 4:
                            $st_4++;
                            break;
                        case 5:
                            $st_5++;
                            break;
                        case 6:
                            $st_6++;
                            break;
                    }
                }


                DB::table('lead_distribution')
                    ->updateOrInsert(
                        ['user_id' => $userID],
                        [
                            'assined_lead' => $st_1,
                            'qualified_lead' => $st_2,
                            'sample_lead' => $st_3,
                            'clinet_lead' => $st_4,
                            'repeat_lead' => $st_5,
                            'lost_lead' => $st_6,
                            'disqualified' => $data_arr_dataLUNQTC,
                            'update_at' => date('Y-m-d H:i:s'),

                        ]
                    );


                //lead_distribution_month
                // DB::table('lead_distribution_month')
                // ->updateOrInsert(
                //     ['user_id' =>$userID ],
                //     [
                //         'assined_lead' => $st_1,
                //         'qualified_lead' => $st_2,
                //         'sample_lead' => $st_3,
                //         'clinet_lead' => $st_4,
                //         'repeat_lead' => $st_5,
                //         'lost_lead' => $st_6,
                //         'disqualified' => count($data_arr_dataLUNQ),
                //         'update_at' => date('Y-m-d H:i:s'),

                //     ]
                // );

                //lead_distribution_month




            }
        }
    }

    public static function getLeadDistribution()
    {
        $data = array();
        //$allUsers=User::get();
        $allUsers = AyraHelp::getSalesAgentAdmin();

        $mydata = array();
        foreach ($allUsers as $key => $user) {
            $emp_arr = AyraHelp::getProfilePIC($user->id);
            $name = AyraHelp::getUser($user->id)->name;

            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }

            $leadArrData_1 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 1)->count();
            $leadArrData_2 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 2)->count();
            $leadArrData_3 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 3)->count();
            $leadArrData_4 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 4)->count();
            $leadArrData_5 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 5)->count();
            $leadArrData_6 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 6)->count();
            $leadArrData_77 = DB::table('lead_assign')->where('assign_user_id', $user->id)->where('current_stage_id', 77)->count();

            $totLead = $leadArrData_1
                + $leadArrData_2
                + $leadArrData_3
                + $leadArrData_4
                + $leadArrData_5
                + $leadArrData_6;
            $data[] = array(
                'sales_name' => $name,
                'uid' => $user->id,

                'profilePic' => $img_photo,
                'stage_1' => $leadArrData_1,
                'stage_2' =>  $leadArrData_2,
                'stage_3' => $leadArrData_3,
                'stage_4' => $leadArrData_4,
                'stage_5' => $leadArrData_5,
                'stage_6' => $leadArrData_6,
                'unqli' => $leadArrData_77,
                'irvant' => 55,

                'stage_totoal' => $totLead,

            );
        }
        return $data;
    }
    public static function getLeadDistributionOK17Aug()
    {
        $data = array();
        $leadArrData = DB::table('lead_distribution')->get();
        foreach ($leadArrData as $key => $rowData) {

            $emp_arr = AyraHelp::getProfilePIC($rowData->user_id);
            $name = AyraHelp::getUser($rowData->user_id)->name;
            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }
            $totLead = $rowData->assined_lead + $rowData->qualified_lead + $rowData->sample_lead + $rowData->clinet_lead + $rowData->repeat_lead + $rowData->lost_lead;




            $data[] = array(
                'sales_name' => $name,
                'uid' => $rowData->user_id,

                'profilePic' => $img_photo,
                'stage_1' => $rowData->assined_lead,
                'stage_2' =>  $rowData->qualified_lead,
                'stage_3' => $rowData->sample_lead,
                'stage_4' => $rowData->clinet_lead,
                'stage_5' => $rowData->repeat_lead,
                'stage_6' => $rowData->lost_lead,
                'unqli' => $rowData->disqualified,
                'irvant' => 55,

                'stage_totoal' => $totLead,

            );
        }

        return $data;
    }

    public static function getLeadDistributionAA()
    {

        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead")->orwhere("name", "Staff");
        })->get();
        $data = array();


        foreach ($clients_arr as $key => $rowData) {



            if (
                $rowData->id == 88
                || $rowData->id == 108
                || $rowData->id == 77
                || $rowData->id == 78
                || $rowData->id == 83
                || $rowData->id == 84
                || $rowData->id == 85
                || $rowData->id == 87
                || $rowData->id == 89
                || $rowData->id == 91
                || $rowData->id == 93
                || $rowData->id == 95
                || $rowData->id == 98
                || $rowData->id == 101
                || $rowData->id == 130
                || $rowData->id == 131

                || $rowData->id == 132
                || $rowData->id == 135
            ) {
            } else {



                $emp_arr = AyraHelp::getProfilePIC($rowData->id);
                if (!isset($emp_arr->photo)) {
                    $img_photo = asset('local/public/img/avatar.jpg');
                } else {
                    $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                }


                $data_count_arr = AyraHelp::getLeadAssigntCountByUser($rowData->id);
                $UnQlifieddata_count_arr = AyraHelp::getAllUnQlifiedLeadDonebyUser($rowData->id);
                $Irrevant_count_arr = AyraHelp::getAllIrrevantLeadDonebyUser($rowData->id);


                $data[] = array(
                    'sales_name' => $rowData->name,
                    'uid' => $rowData->id,

                    'profilePic' => $img_photo,
                    'stage_1' => $data_count_arr['st_1'],
                    'stage_2' => $data_count_arr['st_2'],
                    'stage_3' => $data_count_arr['st_3'],
                    'stage_4' => $data_count_arr['st_4'],
                    'stage_5' => $data_count_arr['st_5'],
                    'stage_6' => $data_count_arr['st_6'],
                    'unqli' => $UnQlifieddata_count_arr,
                    'irvant' => $Irrevant_count_arr,

                    'stage_totoal' => $data_count_arr['st_tot'],

                );
            }
        }

        return $data;
    }


    public static function getLeadDistribution_4()
    {

        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead")->orwhere("name", "Staff");
        })->get();
        $data = array();


        foreach ($clients_arr as $key => $rowData) {


            if (
                $rowData->id == 88
                || $rowData->id == 108
                || $rowData->id == 77
                || $rowData->id == 78
                || $rowData->id == 83
                || $rowData->id == 84
                || $rowData->id == 85
                || $rowData->id == 87
                || $rowData->id == 89
                || $rowData->id == 91
                || $rowData->id == 93
                || $rowData->id == 95
                || $rowData->id == 98
                || $rowData->id == 101
                || $rowData->id == 130
                || $rowData->id == 131

                || $rowData->id == 132
                || $rowData->id == 135
                || $rowData->id == 134


            ) {
            } else {



                $emp_arr = AyraHelp::getProfilePIC($rowData->id);
                if (!isset($emp_arr->photo)) {
                    $img_photo = asset('local/public/img/avatar.jpg');
                } else {
                    $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                }


                $data_count_arr = AyraHelp::getLeadAssigntCountByUser($rowData->id);
                $UnQlifieddata_count_arr = AyraHelp::getAllUnQlifiedLeadDonebyUser($rowData->id);
                $Irrevant_count_arr = AyraHelp::getAllIrrevantLeadDonebyUser($rowData->id);


                $data[] = array(
                    'sales_name' => $rowData->name,
                    'profilePic' => $img_photo,
                    'stage_1' => $data_count_arr['st_1'],
                    'stage_2' => $data_count_arr['st_2'],
                    'stage_3' => $data_count_arr['st_3'],
                    'stage_4' => $data_count_arr['st_4'],
                    'stage_5' => $data_count_arr['st_5'],
                    'stage_6' => $data_count_arr['st_6'],
                    'unqli' => $UnQlifieddata_count_arr,
                    'irvant' => $Irrevant_count_arr,

                    'stage_totoal' => $data_count_arr['st_tot'],

                );
            }
        }

        return $data;
    }
    public static function isAssignLea($QUERY_ID)
    {
        //$process_data = DB::table('clients')->where()->get();
        $process_data = DB::table('st_process_action_4')->where('action_on', 1)->where('stage_id', 1)->where('ticket_id', $QUERY_ID)->first();



        if ($process_data == null) {
            return 0;
        } else {
            return 1;
        }
    }


    public static function getLeadCountWithNoteID($QUERY_ID)
    {
        $lead_notes_data = DB::table('lead_notes')->where('QUERY_ID', $QUERY_ID)->get();
        $lead_notes_dataTC = DB::table('lead_notes')->where('QUERY_ID', $QUERY_ID)->count();

        $lnote = array();

        if (count($lead_notes_data) > 0) {
            $lnote = array(
                'lcout' => $lead_notes_dataTC,
                'leadAV' => 1
            );
        } else {
            $lnote = array(
                'lcout' => 0,
                'leadAV' => 0
            );
        }
        return $lnote;
    }

    //bolead_clients_irrelevant
    //bolead_clients_fresh

    public static function getFreshLead()
    {
        $process_data = DB::table('indmt_data')->get();
        // echo count($process_data);
        // die;
        $i = 0;

        foreach ($process_data as $key => $rowData) {
            if ($rowData->lead_status == 0) {
                $i++;
                DB::table('bolead_clients_fresh')->insert(
                    [

                        'QUERY_ID' => $rowData->QUERY_ID,
                        'created_at' => $rowData->created_at,
                        'added_by' => 77,
                        'firstname' => $rowData->SENDERNAME,
                        'email' => $rowData->SENDEREMAIL,
                        'company' => $rowData->GLUSR_USR_COMPANYNAME,
                        'brand' => $rowData->GLUSR_USR_COMPANYNAME,
                        'address' => $rowData->ENQ_ADDRESS,
                        'gstno' => 'NA',
                        'phone' => trim($rowData->MOB),
                        'remarks' => $rowData->remarks,
                        'location' => $rowData->ENQ_CITY,
                        //'country' =>$rowData->COUNTRY_ISO,
                        'source' => $rowData->data_source,
                        'website' => '',
                        'lead_json' => json_encode($rowData),

                    ]
                );
            }
            if ($rowData->lead_status == 1) {
                // DB::table('bolead_clients_irrelevant')->insert(
                //     [

                //         'QUERY_ID' => $rowData->QUERY_ID,
                //         'created_at' => $rowData->created_at,
                //         'added_by' =>77,
                //         'firstname' => $rowData->SENDERNAME,
                //         'email' => $rowData->SENDEREMAIL,
                //         'company' => $rowData->GLUSR_USR_COMPANYNAME,
                //         'brand' => $rowData->GLUSR_USR_COMPANYNAME,
                //         'address' => $rowData->ENQ_ADDRESS,
                //         'gstno' =>'NA',
                //         'phone' =>trim($rowData->MOB),
                //         'remarks' =>$rowData->remarks,
                //         'location' =>$rowData->ENQ_CITY,
                //        // 'country' =>$rowData->COUNTRY_ISO,
                //         'source' =>$rowData->data_source,
                //         'website' =>'',
                //         'lead_json' =>json_encode($rowData),

                //     ]
                // );
            }
        }
        echo $i;
    }
    public static function getActualClientAsNow()
    {
        $process_data = DB::table('clients')->get();

        $i = 0;
        foreach ($process_data as $key => $rowData) {
            $client_data = DB::table('qc_forms')->where('client_id', $rowData->id)->get();
            if (count($client_data) > 0) {

                $i++;
                DB::table('bolead_clients')->insert(
                    [
                        'id' => $rowData->id,
                        'created_at' => $rowData->created_at,
                        'added_by' => $rowData->added_by,
                        'firstname' => $rowData->firstname,
                        'email' => $rowData->email,
                        'company' => $rowData->company,
                        'brand' => $rowData->brand,
                        'address' => $rowData->address,
                        'gstno' => $rowData->gstno,
                        'phone' => trim($rowData->phone),
                        'remarks' => $rowData->remarks,
                        'location' => $rowData->location,
                        'country' => $rowData->country,
                        'source' => $rowData->source,
                        'website' => $rowData->website,

                    ]
                );
            } else {
                DB::table('bolead_clients_sample_only')->insert(
                    [
                        'id' => $rowData->id,
                        'created_at' => $rowData->created_at,
                        'added_by' => $rowData->added_by,
                        'firstname' => $rowData->firstname,
                        'email' => $rowData->email,
                        'company' => $rowData->company,
                        'brand' => $rowData->brand,
                        'address' => $rowData->address,
                        'gstno' => $rowData->gstno,
                        'phone' => trim($rowData->phone),
                        'remarks' => $rowData->remarks,
                        'location' => $rowData->location,
                        'country' => $rowData->country,
                        'source' => $rowData->source,
                        'website' => $rowData->website,

                    ]
                );
            }
        }
        echo $i;
    }

    public static function getClientHaveOrder($client_id)
    {
        $process_data = DB::table('qc_forms')->where('client_id', $client_id)->get();
        $process_dataTC = DB::table('qc_forms')->where('client_id', $client_id)->count();

        if (count($process_data) > 0) {
            $orders = $process_dataTC;
        } else {
            $orders = 'NA';
        }
        return $orders;
    }
    public static function getTodayBirday()
    {

        $orderData = DB::table('users')
            ->join('hrm_emp', 'users.id', '=', 'hrm_emp.user_id')
            // ->where('users.is_deleted',0)
            ->select('users.*', 'hrm_emp.dob', 'hrm_emp.photo', 'hrm_emp.phone')
            ->get();
        $birday_arr = array();
        foreach ($orderData as $key => $row) {
            $birthdate = $row->dob;
            $time = strtotime($birthdate);
            if (date('m-d') == date('m-d', $time)) {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($row)->photo;
                $birday_arr[] = array(
                    'user_id' => $row->id,
                    'profile_pic' => $img_photo,
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'dob' => $row->dob,
                );
            }
        }

        return $birday_arr;
    }


    public static function getProfilePIC($userid)
    {
        $orderData = DB::table('hrm_emp')->where('user_id', $userid)->first();
        return $orderData;
    }
    public static function getBirthdayList($dayAgo)
    {

        $orderData = DB::table('users')
            ->join('hrm_emp', 'users.id', '=', 'hrm_emp.user_id')
            // ->where('users.is_deleted',0)
            ->select('users.*', 'hrm_emp.dob', 'hrm_emp.photo', 'hrm_emp.phone')
            ->get();
        $birday_arr = array();
        foreach ($orderData as $key => $row) {
            $birthdate = $row->dob;

            $inform_days = date('m-d', strtotime('-10 days', strtotime($birthdate)));

            $today = date('m-d');




            if ($today > $inform_days) {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($row)->photo;
                $birday_arr[] = array(
                    'user_id' => $row->id,
                    'profile_pic' => $img_photo,
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'dob' => $row->dob,
                );
            }
        }

        return $birday_arr;
    }


    public static function getCurrentStageLEAD($QUERY_ID)
    {
        $process_data = DB::table('st_process_action_4')->where('action_on', 1)->where('ticket_id', $QUERY_ID)->latest()->first();

        if ($process_data == null) {
            //echo "ZNOW23-" . $QUERY_ID;
            //die;
            $newsid = '1';
        } else {
            $newsid = $process_data->stage_id;
            // INSERT INTO `st_process_action_4` (`id`, `process_id`, `stage_id`, `action_on`, `ticket_id`, `dependent_ticket_id`, `ticket_name`, `created_at`, `expected_date`, `remarks`, `attachment_id`, `assigned_id`, `undo_status`, `updated_by`, `created_status`, `completed_by`, `statge_color`)VALUES (NULL, '4', '1', '1', '133825048', NULL, NULL, '2020-01-27 10:28:06', '2020-01-27 10:28:06', 'Assign ', '0', '1', '1', '77', '1', '77', 'completed')

        }

        // $newsid=$process_data->stage_id;


        return $process_dataS = DB::table('st_process_stages')->where('process_id', 4)->where('stage_position', $newsid)->first();
    }
    public static function getCurrentStageMYLEAD($QUERY_ID)
    {
        $process_data = DB::table('st_process_action_5_mylead')->where('action_on', 1)->where('ticket_id', $QUERY_ID)->latest()->first();

        if ($process_data == null) {
            // echo "ZNOW23-" . $QUERY_ID;
            // die;
            $newsid = '1';
        } else {
            $newsid = $process_data->stage_id;
            // INSERT INTO `st_process_action_4` (`id`, `process_id`, `stage_id`, `action_on`, `ticket_id`, `dependent_ticket_id`, `ticket_name`, `created_at`, `expected_date`, `remarks`, `attachment_id`, `assigned_id`, `undo_status`, `updated_by`, `created_status`, `completed_by`, `statge_color`)VALUES (NULL, '4', '1', '1', '133825048', NULL, NULL, '2020-01-27 10:28:06', '2020-01-27 10:28:06', 'Assign ', '0', '1', '1', '77', '1', '77', 'completed')

        }

        // $newsid=$process_data->stage_id;


        return $process_dataS = DB::table('st_process_stages')->where('process_id', 4)->where('stage_position', $newsid)->first();
    }

    public static function getTicketID()
    {
        $length = 9;
        $number = '';
        do {
            for ($i = $length; $i--; $i > 0) {
                $number .= mt_rand(1, 9);
            }
        } while (!empty(DB::table('ticket_list')->where('ticket_id', $number)->first(['ticket_id'])));
        return $number;
    }


    public static function getSponsorID()
    {
        $length = 7;
        $number = '';
        do {
            for ($i = $length; $i--; $i > 0) {
                $number .= mt_rand(1, 9);
            }
            $numberA=$number+date('dy');
        }
        while (!empty(DB::table('indmt_data')->where('QUERY_ID', $numberA)->first(['QUERY_ID'])));
        return intVal($numberA);
    }
    public static function getSALE_QUERYID()
    {
        $length = 10;
        $number = '';
        do {
            for ($i = $length; $i--; $i > 0) {
                $number .= mt_rand(0, 9);
            }
        } while (!empty(DB::table('client_sales_lead')->where('QUERY_ID', $number)->first(['QUERY_ID'])));
        return $number;
    }

    public static function getQID()
    {
        // $length = 5;
        // $number = '';
        // do {
        //     for ($i = $length; $i--; $i > 0) {
        //         $number .= mt_rand(0, 9);
        //     }
        // } while (!empty(DB::table('client_quatation')->where('QID', $number)->first(['QUERY_ID'])));
        // return $number;

        $max_id = DB::table('client_quatation')->max('id') + 1;
        $uname = 'QID';
        $num = $max_id;
        $str_length = 4;
        $sid_code = $uname . substr("00{$num}", -$str_length);
        return $sid_code;
    }



    public static function getAllRepeatOrNewValue()
    {
        $bom_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('order_repeat', 1)->get();
        $no_val = 0;
        foreach ($bom_arr as $key => $row) {
            $oval = ($row->item_sp) * ($row->item_qty);
            $no_val = $no_val + $oval;
        }
        //-----------------------------------
        $bom_arr_2 = DB::table('qc_forms')->where('is_deleted', 0)->where('order_repeat', 2)->get();
        $no_val_1 = 0;
        foreach ($bom_arr_2 as $key => $row_1) {
            $oval_1 = ($row_1->item_sp) * ($row_1->item_qty);
            $no_val_1 = $no_val_1 + $oval_1;
        }



        $data = array(
            'new_order_val' => $no_val,
            'repeat_order_val' => $no_val_1
        );
        return $data;
    }
    public static function runLeadDateUpdate()
    {
        $originalDate = "13-Jan-2020 09:40:33 PM";
        //  echo $newDate = date("y-m-d H:i:s", strtotime($originalDate));
        $bom_arr = DB::table('indmt_data')->get();
        foreach ($bom_arr as $key => $row) {
            $originalDate = $row->DATE_TIME_RE;
            $newDate = date("y-m-d H:i:s", strtotime($originalDate));

            DB::table('indmt_data')
                ->where('QUERY_ID', $row->QUERY_ID)
                ->update(['DATE_TIME_RE_SYS' => $newDate]);
        }
    }
    public static function getLeadAssignUser($leadID)
    {
        $bom_arr = DB::table('lead_assign')->where('QUERY_ID', $leadID)->get();
        $myname = '';
        if (count($bom_arr) > 0) {
            foreach ($bom_arr as $key => $rowData) {

                $myname .= AyraHelp::getUser($rowData->assign_user_id)->name . "<br>";
            }
            return $myname;
        } else {
            return '';
        }
    }

    public static function getINDMArtData()
    {
        $bom_arr = DB::table('indmt_data')->orderBy('id', 'desc')->get();
        return $bom_arr;
    }

    public static function checkArtWorkStated()
    {

        $bom_arr = DB::table('qc_bo_purchaselist')->get();
        foreach ($bom_arr as $key => $row) {

            $arr_data = DB::table('st_process_action')
                ->where('ticket_id', $row->form_id)->where('stage_id', 1)
                ->where('action_status', 1)->first();
            if ($arr_data == null) {
                $bom_arr = DB::table('qc_bo_purchaselist')->where('form_id', $row->form_id)->delete();
            } else {
            }
        }
    }
    public static function NewPurchaseScript3()
    {
        $bom_arr = DB::table('qc_bo_purchaselist_temp')->get();
        $i = 0;
        foreach ($bom_arr as $key => $rowData) {


            $temp_purchase__arr = DB::table('temp_purchase_curr_statge')->where('form_id', $rowData->form_id)->where('m_name', $rowData->material_name)->first();
            if ($temp_purchase__arr == null) {
            } else {

                switch ($temp_purchase__arr->stage_id) {
                    case 1:
                        $stid = 1;
                        break;

                    case 2:
                        $stid = 3;
                        break;

                    case 3:
                        $stid = 3;
                        break;

                    case 4:
                        $stid = 1;
                        break;

                    case 5:
                        $stid = 5;
                        break;

                    case 6:
                        $stid = 5;
                        break;

                    case 7:
                        $stid = 6;
                        break;

                    case 8:
                        $stid = 8;
                        break;
                }

                DB::table('qc_bo_purchaselist_temp')
                    ->where('form_id', $rowData->form_id)->where('material_name', $rowData->material_name)
                    ->update(['status' => $stid]);
                DB::table('temp_purchase_curr_statge')
                    ->where('form_id', $rowData->form_id)->where('m_name', $rowData->material_name)
                    ->update(['status' => 1]);
            }
        }
        echo $i;
    }
    public static function NewPurchaseScript2()
    {
        $order_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $i = 0;
        foreach ($order_arr as $key => $rowData) {

            $bom_arr = DB::table('qc_forms_bom')
                ->where('form_id', $rowData->form_id)
                ->whereNotNull('m_name')
                ->where('bom_from', '!=', 'From Client')
                ->where('bom_from', '!=', 'N/A')
                ->get();
            foreach ($bom_arr as $key => $rowBOM) {

                $bom_arr = DB::table('qc_bo_purchaselist_temp')
                    ->where('form_id', $rowData->form_id)
                    ->where('material_name', $rowBOM->m_name)
                    ->where('qty', $rowBOM->qty)
                    ->first();
                if ($bom_arr == null) {
                    DB::table('qc_bo_purchaselist_temp')->insert(
                        [
                            'form_id' => $rowData->form_id,
                            'order_id' => $rowData->order_id,
                            'sub_order_index' => $rowData->subOrder,
                            'order_name' => $rowData->brand_name,
                            'order_cat' => $rowBOM->bom_cat,
                            'material_name' => $rowBOM->m_name,
                            'qty' => $rowBOM->qty,
                            'status' => 1,
                            'created_by' => $rowData->created_by,

                        ]
                    );

                    $i++;
                }
            }
        }
        echo $i;
    }

    public static function NewPurchaseScript1()
    {
        $order_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $i = 0;
        foreach ($order_arr as $key => $rowData) {

            $bom_arr = DB::table('qc_forms_bom')
                ->where('form_id', $rowData->form_id)
                ->whereNotNull('m_name')
                ->where('bom_from', '!=', 'From Client')
                ->where('bom_from', '!=', 'N/A')
                ->get();
            foreach ($bom_arr as $key => $rowBOM) {

                $data = AyraHelp::getPurchaseScriptStageFind($rowBOM->m_name, $rowData->form_id);
                //print_r($data);

                DB::table('temp_purchase_curr_statge')->insert(
                    [
                        'order_id' => "#" . $rowData->order_id . "/" . $rowData->subOrder,
                        'form_id' => $rowData->form_id,
                        'stage_id' => optional($data)->status == NULL ? '1' : $data->status,
                        'm_name' => $rowBOM->m_name,

                    ]
                );


                $i++;
            }


            //$data=AyraHelp::getProcessCurrentStagePurchase(2,$rowData->form_id);



            // DB::table('temp_purchase_curr_statge')->insert(
            //     [
            //         'order_id' =>"#".$rowData->order_id."/".$rowData->subOrder,
            //         'form_id' => $rowData->form_id,
            //         'stage_id' => $data->stage_id,
            //         'stage_name' => $data->stage_name,
            //         //'st_array_json' =>json_encode($define_stage_arr),
            //     ]
            // );




        }
        echo $i;
    }

    public static function NewOrderScript4()
    {
        $order_arr = DB::table('temp_action')->get();

        foreach ($order_arr as $key => $rowData) {

            if ($rowData->stage_id == 1) {
                $order_action = DB::table('st_process_action_temp')->where('ticket_id', $rowData->form_id)->where('stage_id', $rowData->stage_id)->first();
                if ($order_action == null) {

                    // Start :save on stage

                    DB::table('st_process_action_temp')->insert(
                        [
                            'ticket_id' => $rowData->form_id,

                            'process_id' => 1,
                            'stage_id' => 1,
                            'action_on' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'expected_date' => date('Y-m-d H:i:s'),
                            'remarks' => 'Script:Auto s Completed :DP:1',
                            'attachment_id' => 0,
                            'assigned_id' => Auth::user()->id,
                            'undo_status' => 1,
                            'updated_by' => Auth::user()->id,
                            'created_status' => 1,
                            'completed_by' => AyraHelp::getOrderByFormID($rowData->form_id)->created_by,
                            'statge_color' => 'completed',
                            'action_mark' => 0,
                            'action_status' => 0,
                        ]
                    );
                    // Start :save on stage
                    DB::table('temp_action')
                        ->where('form_id', $rowData->form_id)->where('stage_id', 1)
                        ->update(['status' => 1]);
                }
            }

            //new stage
            if ($rowData->stage_id >= 2) {
                //echo $rowData->stage_id."<br>";
                $st_array = json_decode($rowData->st_array_json);

                foreach ($st_array as $key => $rowVal) {

                    if ($rowVal == 1 || $rowVal == 2) {
                    } else {

                        if ($rowVal <= $rowData->stage_id) {

                            if ($rowVal == $rowData->stage_id) {
                                //  echo "-".$rowVal."Current";
                                // Start :save on stage
                                $order_action = DB::table('st_process_action_temp')->where('ticket_id', $rowData->form_id)->where('stage_id', $rowVal)->first();
                                if ($order_action == null) {
                                    DB::table('st_process_action_temp')->insert(
                                        [
                                            'ticket_id' => $rowData->form_id,

                                            'process_id' => 1,
                                            'stage_id' => $rowVal,
                                            'action_on' => 1,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'expected_date' => date('Y-m-d H:i:s'),
                                            'remarks' => 'Script:Auto s Completed :DP:1',
                                            'attachment_id' => 0,
                                            'assigned_id' => Auth::user()->id,
                                            'undo_status' => 1,
                                            'updated_by' => Auth::user()->id,
                                            'created_status' => 1,
                                            'completed_by' => AyraHelp::getOrderByFormID($rowData->form_id)->created_by,
                                            'statge_color' => 'completed',
                                            'action_mark' => 0,
                                            'action_status' => 0,
                                        ]
                                    );
                                    DB::table('temp_action')
                                        ->where('form_id', $rowData->form_id)->where('stage_id', $rowVal)
                                        ->update(['status' => 1]);
                                }

                                // Start :save on stage


                            } else {
                                //  print_r($rowVal);
                                // Start :save on stage
                                // Start :save on stage
                                $order_action = DB::table('st_process_action_temp')->where('ticket_id', $rowData->form_id)->where('stage_id', 1)->first();
                                if ($order_action == null) {
                                    DB::table('st_process_action_temp')->insert(
                                        [
                                            'ticket_id' => $rowData->form_id,

                                            'process_id' => 1,
                                            'stage_id' => 1,
                                            'action_on' => 1,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'expected_date' => date('Y-m-d H:i:s'),
                                            'remarks' => 'Script:Auto s Completed :DP:1',
                                            'attachment_id' => 0,
                                            'assigned_id' => Auth::user()->id,
                                            'undo_status' => 1,
                                            'updated_by' => Auth::user()->id,
                                            'created_status' => 1,
                                            'completed_by' => AyraHelp::getOrderByFormID($rowData->form_id)->created_by,
                                            'statge_color' => 'completed',
                                            'action_mark' => 0,
                                            'action_status' => 1,
                                        ]
                                    );
                                }

                                $order_action = DB::table('st_process_action_temp')->where('ticket_id', $rowData->form_id)->where('stage_id', $rowVal)->first();
                                if ($order_action == null) {
                                    DB::table('st_process_action_temp')->insert(
                                        [
                                            'ticket_id' => $rowData->form_id,

                                            'process_id' => 1,
                                            'stage_id' => $rowVal,
                                            'action_on' => 1,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'expected_date' => date('Y-m-d H:i:s'),
                                            'remarks' => 'Script:Auto s Completed :DP:1',
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
                                    DB::table('temp_action')
                                        ->where('form_id', $rowData->form_id)->where('stage_id', $rowVal)
                                        ->update(['status' => 1]);
                                }

                                // Start :save on stage

                            }
                        }
                    }
                }
            }
            //new stage

        }
    }

    public static function NewOrderScript3()
    {
        $order_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('dispatch_status', 1)->get();
        foreach ($order_arr as $key => $rowData) {
            $data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);

            $form_data = AyraHelp::getQCFormDate($rowData->form_id);

            $orderType = optional($form_data)->order_type;
            $define_stage_arr = array();
            if ($orderType == 'Private Label') {
                if ($form_data->order_repeat == 2) {
                    $define_stage_arr = [1, 2, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
                } else {
                    // echo "no repeat";
                    $define_stage_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                }
            }

            if ($orderType == 'Bulk' || $orderType == 'BULK') {
                if ($form_data->qc_from_bulk == 1) {
                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                } else {
                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                }
            }


            DB::table('temp_action')->insert(
                [
                    'order_id' => "#" . $rowData->order_id . "/" . $rowData->subOrder,
                    'form_id' => $rowData->form_id,
                    'stage_id' => $data->stage_id,
                    'stage_name' => $data->stage_name,
                    'st_array_json' => json_encode($define_stage_arr),
                ]
            );
        }
    }
    public static function NewOrderScript3OLD()
    {
        $user_id = 4;
        $order_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $i = 0;
        $j = 0;
        foreach ($order_arr as $key => $rowData) {
            $i++;
            $data = AyraHelp::getProcessCurrentStage(1, $rowData->form_id);
            //echo "<pre>";
            //print_r($data->stage_id);


            if ($data->stage_id == 1) {
                // Start :save on stage
                DB::table('st_process_action_temp')->insert(
                    [
                        'ticket_id' => $rowData->form_id,

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
                // Start :save on stage



            } else {


                //  echo  $data->stage_id."#".$rowData->order_id."/".$rowData->subOrder."=>".$data->stage_id."=>".$data->stage_name."<br>";
                //ajcode


                $form_data = AyraHelp::getQCFormDate($rowData->form_id);

                $orderType = optional($form_data)->order_type;
                $define_stage_arr = array();
                if ($orderType == 'Private Label') {
                    if ($form_data->order_repeat == 2) {

                        $define_stage_arr = [1, 2, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
                        // echo "#".$rowData->order_id."/".$rowData->subOrder."=>".$data->stage_id."=>".$data->stage_name."<br>";


                    } else {
                        // echo "no repeat";
                        $define_stage_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                        // echo "#".$rowData->order_id."/".$rowData->subOrder."=>".$data->stage_id."=>".$data->stage_name."<br>";
                    }
                }

                if ($orderType == 'Bulk' || $orderType == 'BULK') {
                    if ($form_data->qc_from_bulk == 1) {

                        $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                    } else {
                        $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                    }
                }



                for ($i = $data->stage_id; $i >= 3; $i--) {
                    if ($define_stage_arr[$i - 1] == 0) {
                    } else {
                        $sid = $define_stage_arr[$i - 2];

                        $order_action = DB::table('st_process_action_temp')->where('ticket_id', $rowData->form_id)->where('stage_id', $sid)->first();
                        if ($order_action == null) {
                            // Start :save on stage
                            DB::table('st_process_action_temp')->insert(
                                [
                                    'ticket_id' => $rowData->form_id,

                                    'process_id' => 1,
                                    'stage_id' => $sid,
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
                            // Start :save on stage

                        } else {
                            // DB::table('st_process_action')
                            // ->where('ticket_id',$rowData->form_id)->where('stage_id',$sid)
                            // ->update(['action_status' => 1]);

                        }







                        //break;
                    }
                }



                //insert and update
                //insert and update

                //ajcode



            }
        }
        // echo $i;
        die;
    }
    public static function NewOrderScript2()
    {
        $order_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $i = 0;
        foreach ($order_arr as $key => $rowData) {
            $order_action = DB::table('st_process_action')->where('ticket_id', $rowData->form_id)->where('stage_id', 1)->first();
            if ($order_action == null) {
                $i++;
                // Start :save on stage
                DB::table('st_process_action')->insert(
                    [
                        'ticket_id' => $rowData->form_id,

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
                // Start :save on stage

            } else {
            }
        }
        echo $i;
    }
    public static function NewOrderScript()
    {


        $i = 0;
        $j = 0;
        $order_action = DB::table('st_process_action')->get();
        foreach ($order_action as $key => $rowAction) {

            $order_arr = DB::table('qc_forms')->where('form_id', $rowAction->ticket_id)->where('is_deleted', 0)->where('dispatch_status', 1)->first();
            if ($order_arr == null) {
                $i++;
                DB::table('st_process_action')->where('ticket_id', $rowAction->ticket_id)->delete();
            } else {
                $j++;
            }
        }
        echo $i;
        echo "<br>";
        echo $j;
    }


    public static function getBOMQTY($form_id, $m_name)
    {
        $users = DB::table('qc_forms_bom')->where('form_id', $form_id)->where('m_name', $m_name)->first();
        return $users;
    }


    public static function getPurchaseScriptStageFind($m_name, $form_id)
    {
        $users = DB::table('qc_bo_purchaselist')->where('form_id', $form_id)->where('material_name', $m_name)->first();
        return $users;
    }

    public static function GetBomDetail($form_id, $m_name)
    {
        $users = DB::table('qc_forms_bom')->where('form_id', $form_id)->where('m_name', $m_name)->first();
        return $users;
    }

    public static function getFinishPCatDetail($id)
    {
        $users = DB::table('rnd_finish_product_cat')->where('id', $id)->first();
        return $users;
    }
    public static function getSampleCountFinishProduct($product_name)
    {

        $samples = DB::table('sample_items')->where('item_name', $product_name)->count();
        return $samples;
    }




    public static function getFinishProductCatData()
    {
        $users = DB::table('rnd_finish_product_cat')->get();
        return $users;
    }
    public static function getFinishProductSubCatData()
    {
        $users = DB::table('rnd_finish_product_subcat')->get();
        return $users;
    }
    public static function getFinishPSubCatDetail($id)
    {
        $users = DB::table('rnd_finish_product_subcat')->where('id', $id)->first();
        return $users;
    }


    public static function getRNDIngredentList()
    {
        $users = DB::table('rnd_add_ingredient')->get();
        return $users;
    }
    public static function getStayFromOrder($fid)
    {

        $data = AyraHelp::getProcessCurrentStage(1, $fid);

        if ($data->stage_id == 1) {
            //$data=AyraHelp::getQCFormDate($fid);
            $data = AyraHelp::getQCFormDate($fid);
            $date = Carbon::parse($data->created_at);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            return "Since " . $diff . " days";
        } else {

            $users = DB::table('st_process_action')

                ->where('process_id', '=', 1)
                ->where('ticket_id', '=', $fid)
                // ->where('stage_id', '=', $data->stage_id)
                ->latest()
                ->first();
            if ($users != null) {


                $date = Carbon::parse($users->created_at);
                $now = Carbon::now();
                $diff = $date->diffInDays($now);
                return "Since " . $diff . " days";
            } else {
                return '';
            }




            //print_r($users);


        }
    }


    public static function getMACAddress()
    {
        $ipconfig =   shell_exec("ifconfig -a | grep -Po 'HWaddr \K.*$'");
        // display those informations
        echo $ipconfig;
    }
    //curl --header "DY-X-Authorization: 4ef7f4d3f784d7c9e1029713414cab2a28e7e728" https://ifsc.datayuge.com/api/v1/RATN0000114

    public static function getIngredientCategory()
    {
        $users = DB::table('rnd_ingredient_category')->get();
        return $users;
    }
    public static function getFNDIngredientCategory()
    {
        $users = DB::table('rnd_finish_product_cat')->get();
        return $users;
    }
    public static function getFNDIngredientSubCategory()
    {
        $users = DB::table('rnd_finish_product_subcat')->get();
        return $users;
    }




    public static function getIngredientBrand()
    {
        $users = DB::table('rnd_supplier_brands')->get();
        return $users;
    }
    public static function getIngredientSupplier()
    {
        $users = DB::table('rnd_ingredient_supplier')->get();
        return $users;
    }
    public static function getRNDSupplerDetailsData()
    {
        $users = DB::table('rnd_ingredient_supplier')->distinct('company_name')->get();
        return $users;
    }
    public static function getRNDSupplerDetails($id)
    {
        $users = DB::table('rnd_ingredient_supplier')->where('id', $id)->first();
        return $users;
    }
    public static function getRNDIngredientCatID($id)
    {
        $users = DB::table('rnd_ingredient_category')->where('id', $id)->first();
        return $users;
    }

    public static function getRNDIngredientBrandID($id)
    {
        $users = DB::table('rnd_supplier_brands')->where('id', $id)->first();
        return $users;
    }




    public static function getPurchaseListDataWith($id)
    {
        $users = DB::table('qc_bo_purchaselist')->where('id', $id)->first();
        return $users;
    }
    public static function OldtoNewPurchaseScript()
    {
        echo "<pre>";
        //$datas=QC_BOM_Purchase::where('id', '<=', 1033)->limit(1033)->get();
        $datas = QC_BOM_Purchase::where('id', '>', 3408)->limit(413)->get();
        foreach ($datas as $key => $valRow) {
            $dticketID = $valRow->form_id;
            $stage_id = $valRow->status;
            $ticketID = $valRow->id;
            switch ($stage_id) {
                case 2:
                    $dticketID = $valRow->form_id;
                    AyraHelp::SavePurchaseProcess(1, $ticketID, $dticketID);

                    break;
                case 3:
                    AyraHelp::SavePurchaseProcess(2, $ticketID, $dticketID);
                    break;
                case 4:
                    AyraHelp::SavePurchaseProcess(3, $ticketID, $dticketID);
                    break;
                case 5:
                    AyraHelp::SavePurchaseProcess(4, $ticketID, $dticketID);
                    break;
                case 6:
                    AyraHelp::SavePurchaseProcess(5, $ticketID, $dticketID);
                    break;
                case 7:
                    AyraHelp::SavePurchaseProcess(6, $ticketID, $dticketID);
                    break;
            }
        }
    }
    public static function getBOMImage($pm_code)
    {
        $orderData = DB::table('packaging_options_catalog')->where('poc_code', $pm_code)->first();
        return asset('/local/public/uploads/photos') . "/" . optional($orderData)->img_1;
    }

    public static function SaveOrderProcess($stage_id, $ticket_id)
    {
        DB::table('st_process_action')->insert(
            [
                'process_id' => 1,
                'stage_id' => $stage_id,
                'created_at' => date('Y-m-d'),
                'expected_date' => date('Y-m-d'),
                'assigned_id' => 1,
                'action_on' => 1,
                'completed_by' => 1,
                'ticket_id' => $ticket_id,
                'statge_color' => 'completed'
            ]
        );
    }
    public static function SavePurchaseProcess($stage_id, $ticket_id, $dticketid)
    {

        DB::table('st_process_action_2')->insert(
            [
                'process_id' => 2,
                'stage_id' => $stage_id,
                'created_at' => date('Y-m-d'),
                'expected_date' => date('Y-m-d'),
                'assigned_id' => 1,
                'action_on' => 1,
                'completed_by' => 1,
                'ticket_id' => $ticket_id,
                'dependent_ticket_id' => $dticketid,
                'statge_color' => 'completed'
            ]
        );
    }


    public static function OldtoNewOrderScript()
    {
        $data_arr = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->where('artwork_status', 1)->get();
        foreach ($data_arr as $key => $qcROW) {
            echo $qcROW->order_id . "/" . $qcROW->subOrder;
            $orderData = DB::table('order_master')->where('form_id', $qcROW->form_id)->where('action_status', 1)->get();
            foreach ($orderData as $key => $rowData) {
                echo ":" . $rowData->order_statge_id;
                echo "-";
                switch ($rowData->order_statge_id) {
                    case 'ART_WORK_RECIEVED':
                        AyraHelp::SaveOrderProcess(1, $qcROW->form_id);
                        break;
                    case 'ART_WORK_REVIEW':
                        AyraHelp::SaveOrderProcess(3, $qcROW->form_id);
                        break;
                    case 'CLIENT_ART_CONFIRM':
                        AyraHelp::SaveOrderProcess(4, $qcROW->form_id);
                        break;
                    case 'PRINT_SAMPLE':
                        AyraHelp::SaveOrderProcess(5, $qcROW->form_id);
                        break;
                    case 'SAMPLE_ARRROVAL':
                        AyraHelp::SaveOrderProcess(6, $qcROW->form_id);
                        break;
                    case 'PURCHASE_LABEL_BOX':
                        AyraHelp::SaveOrderProcess(7, $qcROW->form_id);
                        break;
                    case 'PRODUCTION':
                        AyraHelp::SaveOrderProcess(8, $qcROW->form_id);
                        AyraHelp::SaveOrderProcess(9, $qcROW->form_id);
                        break;
                    case 'QC_CHECK':
                        AyraHelp::SaveOrderProcess(10, $qcROW->form_id);
                        break;
                    case 'SAMPLE_MADE_APPROVAL':
                        AyraHelp::SaveOrderProcess(11, $qcROW->form_id);
                        break;
                    case 'PACKING_ORDER':
                        AyraHelp::SaveOrderProcess(12, $qcROW->form_id);
                        break;
                    case 'DISPATCH_ORDER':
                        AyraHelp::SaveOrderProcess(13, $qcROW->form_id);
                        break;
                }
            }
            $orderData = DB::table('order_master')->where('form_id', $qcROW->form_id)->where('action_status', 0)->get();

            echo "-<br>";
        }
    }
    public static function OldtoNewOrderScript__latestbkp()
    {
        $data_arr = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->where('artwork_status', 1)->get();

        foreach ($data_arr as $key => $row) {
            $qc_data_arr = AyraHelp::getCurrentStageByForMID($row->form_id);


            echo $row->order_id . "/" . $row->subOrder;
            echo '-';
            print_r($qc_data_arr->order_statge_id);
            echo '-';
            print_r($qc_data_arr->form_id);

            switch ($qc_data_arr->order_statge_id) {

                case 'ART_WORK_RECIEVED':
                    $step_code = 1;
                    break;
                case 'PURCHASE_PM':
                    $step_code = 0;
                    break;
                case 'ART_WORK_REVIEW':
                    $step_code = 2;
                    break;
                case 'CLIENT_ART_CONFIRM':
                    $step_code = 3;
                    break;
                case 'PRINT_SAMPLE':
                    $step_code = 5;
                    break;
                case 'SAMPLE_ARRROVAL':
                    $step_code = 6;
                    break;
                case 'PURCHASE_LABEL_BOX':
                    $step_code = 7;
                    break;
                case 'PRODUCTION':
                    $step_code = 8;
                    break;
                case 'QC_CHECK':
                    $step_code = 8;
                    break;
                case 'SAMPLE_MADE_APPROVAL':
                    $step_code = 9;
                    break;
                case 'PACKING_ORDER':
                    $step_code = 10;
                    break;
                case 'DISPATCH_ORDER':
                    $step_code = 11;
                    break;
            }


            echo '-';
            echo $step_code;
            echo "<br>";
            if ($step_code == 0) {
            }
            DB::table('st_process_action')->insert(
                [
                    'process_id' => 1,
                    'stage_id' => $step_code,
                    'created_at' => date('Y-m-d'),
                    'expected_date' => date('Y-m-d'),
                    'assigned_id' => 1,
                    'action_on' => 1,
                    'completed_by' => 1,
                    'ticket_id' => $row->form_id,
                    'statge_color' => 'completed'
                ]
            );
        }
    }
    public static function BKPOldtoNewOrderScript()
    {
        echo "<pre>";
        $data_arr = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->where('artwork_status', 1)->get();
        echo count($data_arr);
        die;
        foreach ($data_arr as $key => $rowData) {
            $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
            // print_r($rowData->order_id);
            // echo '-';
            // print_r($rowData->subOrder);
            // print_r($qc_data_arr->order_statge_id);
            // print_r($qc_data_arr->form_id);
            // echo "<pre>";
            switch ($qc_data_arr->order_statge_id) {
                case 'ART_WORK_RECIEVED':
                    $step_code = 1;
                    break;
                case 'PURCHASE_PM':
                    $step_code = 2;
                    break;
                case 'ART_WORK_REVIEW':
                    $step_code = 3;
                    break;
                case 'CLIENT_ART_CONFIRM':
                    $step_code = 4;
                    break;
                case 'PRINT_SAMPLE':
                    $step_code = 5;
                    break;
                case 'SAMPLE_ARRROVAL':
                    $step_code = 6;
                    break;
                case 'PURCHASE_LABEL_BOX':
                    $step_code = 7;
                    break;
                case 'PRODUCTION':
                    $step_code = 8;
                    break;
                case 'QC_CHECK':
                    $step_code = 9;
                    break;
                case 'SAMPLE_MADE_APPROVAL':
                    $step_code = 10;
                    break;
                case 'PACKING_ORDER':
                    $step_code = 11;
                    break;
                case 'DISPATCH_ORDER':
                    $step_code = 12;
                    break;
            }


            switch ($step_code) {
                case '1':
                    $stage_id = 1;
                    break;
                case '2':
                    $stage_id = 2;
                    break;
                case '3':
                    $stage_id = 3;
                    break;
                case '4':
                    $stage_id = 4;
                    break;
                case '5':
                    $stage_id = 5;
                    break;
                case '6':
                    $stage_id = 6;
                    break;
                case '7':
                    $stage_id = 7;
                    break;
                case '8':
                    $stage_id = 9;
                    break;
                case '9':
                    $stage_id = 10;
                    break;
                case '10':
                    $stage_id = 11;
                    break;
                case '11':
                    $stage_id = 12;
                    break;
                case '12':
                    $stage_id = 13;
                    break;
            }



            // print_r($rowData->order_id);
            // echo '-';
            // print_r($rowData->subOrder);
            // echo '-';
            // echo $stage_id;
            // echo "<br>";
            for ($i = $stage_id; $i > 0; $i--) {

                //save data to new stage
                DB::table('st_process_action_1')->insert(
                    [
                        'process_id' => 1,
                        'stage_id' => $i,
                        'created_at' => date('Y-m-d'),
                        'expected_date' => date('Y-m-d'),
                        'assigned_id' => 1,
                        'action_on' => 1,
                        'completed_by' => 1,
                        'ticket_id' => $rowData->form_id,
                        'statge_color' => 'completed'
                    ]
                );
                //save data to new stage

            }
        }
    }

    public static function SetOrderDataToSAPCHECKLIST()
    {
        $datas = QCFORM::where('is_deleted', 0)->get();
        foreach ($datas as $key => $rowData) {

            $ch_data = SAP_CHECKLISt::where('form_id', $rowData->form_id)->first();
            if ($ch_data == null) {
                //--------------------------
                DB::table('sap_checklist')->insert(
                    [

                        'created_by' => Auth::user()->id,
                        'form_id' => $rowData->form_id,
                        'updated_by' => Auth::user()->id,
                        'update_on' => date('Y-m-d H:i:s')
                    ]
                );
                //--------------------------

            }
        }
    }
    //attendance
    public static function getAttenCalulation($rowID)
    {

        $atten_arr = DB::table('emp_attendance_data')->select('atten_data')->where('id', $rowID)->first();
        $atten_data = json_decode($atten_arr->atten_data);

        $day_hour = array();
        $i = 0;
        $avrHour = 0;
        $avrmin = 0;
        $lf = 0;
        foreach ($atten_data as $key => $dayRow) {
            //  print_r($dayRow);
            $contains = Str::contains($dayRow[0], ':');
            if ($contains == 1) {
                $i++;
                //get hour of day
                $today_arr = explode(" ", $dayRow[0]);
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
                $avrHour += $hours;
                $avrmin += $minutes;
                $totMin = $hours * 60 + $minutes;
                if ($totMin < 525) {
                    $lf++;
                }
            }
        }

        $data_atten = array(
            'present_day' => $i,
            'day_hour' => $day_hour,
            'avr_hour' => $avrHour,
            'avr_min' => $avrmin,
            'hour_less_count' => $lf,


        );
        return $data_atten;
    }
    public static function getAttenDemo()
    {
        $atten_arr = DB::table('demo_attn')->get();
        $rowCount = count($atten_arr);
        $i = 0;
        foreach ($atten_arr as $key => $row) {
            //  print_r($row->id);
            $i++;
            $nextID = $row->id + 1;
            //print_r($row->attn_value);
            if ($i != $rowCount) {
                $myatten = AyraHelp::getAttenPunch(intval($nextID));
                if ($myatten == 1) {

                    $myatten_data = AyraHelp::getAttenPunchEntryTime($row->id);
                    if ($myatten_data == 1) {
                        $atten_arr = DB::table('demo_attn')->where('id', $row->id)->delete();
                    }
                }
            }
        }
    }
    public static function getAttenPunch($id)
    {

        $atten_arr = DB::table('demo_attn')->where('id', $id)->first();
        if ($atten_arr != null) {
            $data_arr = json_decode($atten_arr->attn_value);
            $contains = Str::contains($data_arr[0], 'ID');
            if ($contains == 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public static function getAttenPunchEntryTime($id)
    {

        $atten_arr = DB::table('demo_attn')->where('id', $id)->first();
        $data_arr = json_decode($atten_arr->attn_value);
        $contains = Str::contains($data_arr[0], 'ID');
        if ($contains == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function setAttenRowBind()
    {

        //$detail=array();
        $atten_arr = DB::table('demo_attn')->get();
        foreach ($atten_arr as $key => $rowVal) {
            $data_arr = json_decode($rowVal->attn_value);
            $contains = Str::contains($data_arr[0], 'ID');
            if ($contains == 1) {
                $emp_data = explode(' ', $data_arr[0]);
                $data = explode(':', $emp_data[0]);
                $dataName = explode(':', $emp_data[2]);

                $attrn_data = AyraHelp::getAllAtttenPuch($rowVal->id);
                $detail[] = array(
                    'emp_id' => intVal($data[1]),
                    'name' => $dataName[1],
                    'atten_data' => $attrn_data,
                    'atten_month' => $rowVal->atten_month,
                    'atten_year' => $rowVal->atten_yr,


                );
            }
        }



        foreach ($detail as $key => $rowData) {
            $users = DB::table('emp_attendance_data')
                ->where('emp_id', $rowData['emp_id'])
                ->where('attn_month', $rowData['atten_month'])
                ->where('atten_yr', $rowData['atten_year'])
                ->first();
            if ($users == null) {

                DB::table('emp_attendance_data')->insert(
                    [
                        'emp_id' => $rowData['emp_id'],
                        'name' => $rowData['name'],
                        'atten_data' => $rowData['atten_data'],
                        'attn_month' => $rowData['atten_month'],
                        'atten_yr' => $rowData['atten_year'],

                    ]
                );
            }
        }
    }
    public static function  getAllAtttenPuch($emp_id)
    {

        $atten_arr = DB::table('demo_attn')->where('id', $emp_id)->get();
        $myattendata = array();
        foreach ($atten_arr as $key => $rowVal) {

            $nextData = DB::table('demo_attn')->where('id', '>', $rowVal->id)->orderBy('id')->get();

            foreach ($nextData as $key => $RowData) {
                $data_arr = json_decode($RowData->attn_value);
                $contains = Str::contains($data_arr[0], 'ID');
                if ($contains != 1) {
                    $myattendata[] = $data_arr;
                } else {
                    // print_r($data_arr);
                    break;
                }
            }
            //return $myattendata;
            $data = array();
            foreach ($myattendata as $key => $finalRow) {

                for ($i = 0; $i < 31; $i++) {
                    //print_r($finalRow[$i]);
                    $data[$i][] = $finalRow[$i];
                }
            }
            return json_encode($data);
            //print_r($data);



            // exit();


        }
    }
    //attendace



    public static function getEMPCODE()
    {
        $max_id = DB::table('hrm_emp')->max('id') + 1;
        $uname = 'EMP';
        $num = $max_id;
        $str_length = 4;
        $sid_code = $uname . substr("00{$num}", -$str_length);
        return $sid_code;
    }
    public static function getEMPDetail($user_id)
    {

        $max_id = DB::table('hrm_emp')->where('user_id', $user_id)->first();
        if ($max_id == null) {
            return false;
        } else {
            return $max_id;
        }
    }


    public static function kpi_matrix_data()
    {
        $process_data = DB::table('kpi_matrix_data')->get();
        return $process_data;
    }


    public static function getSampleCountYestardayToYet($sample_id)
    {

        $today = \Carbon\Carbon::today();

        if ($today->dayOfWeek == \Carbon\Carbon::MONDAY) {

            $count = DB::table('sample_items')
                ->where('sample_cat_id', $sample_id)
                ->whereDate('created_at', '>=', date('Y-m-d', strtotime("-3 days")))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($today)))
                ->count();
            return $count;
        } else {
            $count = DB::table('sample_items')
                ->where('sample_cat_id', $sample_id)
                ->whereDate('created_at', '>=', date('Y-m-d', strtotime("-1 days")))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($today)))
                ->count();
            return $count;
        }
    }

    public static function getStageDataBYpostionID($position_id, $process_id)
    {

        $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', $position_id)->first();
        return $process_data;
    }
    public static function getDepartment()
    {

        $process_data = DB::table('hrms_department')->get();
        return $process_data;
    }
    public static function getKPIBYRole($role)
    {

        $process_data = DB::table('kpi_data')->where('kpi_role', $role)->first();

        return json_decode(optional($process_data)->kpi_detail);
    }
    public static function getKPIBYUser($user_id)
    {

        $process_data = DB::table('kpi_data')->where('user_id', $user_id)->first();
        if ($process_data == null) {
            return array();
        } else {
            return json_decode(optional($process_data)->kpi_detail);
        }
    }


    public static function getDesignation()
    {
        $process_data = DB::table('hrms_designation')->get();
        return $process_data;
    }
    public static function getJobRole()
    {
        $process_data = DB::table('hrms_roles')->get();
        return $process_data;
    }
    public static function getJobRoleByid($id)
    {
        $process_data = DB::table('hrms_roles')->where('id', $id)->first();
        return $process_data;
    }
    public static function getAddressByPincode($pincode)
    {
        $json = file_get_contents('http://postalpincode.in/api/pincode/' . $pincode);
        $obj = json_decode($json);
        return $obj->PostOffice[0];
    }




    public static function getStageProcessCommentHistory($process_id, $ticket_id)
    {

        $process_data = DB::table('st_process_action')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 0)->where('action_status', 0)->get();

        //return $process_data;
        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {

                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);
                $i++;
                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_arrData->stage_name,
                    'remarks' => $rowData->remarks,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }
    //getLeadStageProcessCompletedHistory_SAMPLE_Fv2
    public static function getLeadStageProcessCompletedHistory_SAMPLE_Fv2($process_id, $ticket_id)
    {
        $process_data = DB::table('st_process_action_6v2')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();
        $dataSample = array();
        $cName = "";
        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {
                $i++;
                $msgDetail = "";
                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                $stage_data2 = optional($stage_arrData)->stage_name;
                if ($rowData->stage_id == 1) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 3) {
                    $dataSample = DB::table('samples')->where('id', $ticket_id)->first();

                    $user = auth()->user();
                    $userRoles = $user->getRoleNames();
                    $user_role = $userRoles[0];
                    if ($user_role == "Admin" || Auth::user()->id == 89) {
                        // data 
                        $dataSampleArr = DB::table('samples_formula')->where('sample_id', $ticket_id)->get();
                        if ($dataSampleArr == null) {
                            $msgDetail = "DONE";
                        } else {
                            foreach ($dataSampleArr as $key => $rowDataS) {

                                $msgDetail .= '<table class="table table-sm m-table m-table--head-bg-brand">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>' . $rowDataS->sample_code_with_part . '</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">Fragrance:' . $rowDataS->fragrance . '</td>
                                    </tr>
                                    <tr>

                                    <td scope="row">Color:' . $rowDataS->color_val . '</td>
                                    </tr>
                                    <tr>
                                    <td scope="row">PH:' . $rowDataS->ph_val . '</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Apperance:' . $rowDataS->apperance_val . '</th>
                                    </tr>
                                    <tr>
                                    <th scope="row">Chemist:' . optional(AyraHelp::getUser(optional($rowDataS)->chemist_id))->name . '</th>
                                    </tr>
                                    <tr>
                                    <th scope="row">Created by:' . optional(AyraHelp::getUser(optional($rowDataS)->created_by))->name . '</th>
                                    </tr>
                                   
                                </tr>
                               
                            </tbody>
                        </table>';
                            }
                        }
                        // data 
                    } else {
                        // data aa
                        // data 
                        $dataSampleArr = DB::table('samples_formula')->where('sample_id', $ticket_id)->get();
                        if ($dataSampleArr == null) {
                            $msgDetail = "DONE";
                        } else {
                            foreach ($dataSampleArr as $key => $rowDataS) {

                                $msgDetail .= '<table class="table table-sm m-table m-table--head-bg-brand">
                                 <thead class="thead-inverse">
                                     <tr>
                                         <th>' . $rowDataS->sample_code_with_part . '</th>                                   
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td scope="row"><b>Fragrance:</b>' . $rowDataS->fragrance . '</td>
                                         </tr>
                                         <tr>
     
                                         <td scope="row"><b>Color:</b>' . $rowDataS->color_val . '</td>
                                         </tr>
                                         <tr>
                                         <td scope="row"><b>PH:</b>' . $rowDataS->ph_val . '</td>
                                         </tr>
                                         <tr>
                                         <th scope="row"><b>Apperance:</b>' . $rowDataS->apperance_val . '</th>
                                         </tr>
                                        
                                         <tr>
                                         <th scope="row"><b>Created by:</b>' . optional(AyraHelp::getUser(optional($rowDataS)->created_by))->name . '</th>
                                         </tr>
                                        
                                     </tr>
                                    
                                 </tbody>
                             </table>';
                            }
                        }
                        // data 
                        // data aa
                    }
                }
                if ($rowData->stage_id == 2) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 3) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 4) {
                    $msgDetail = $rowData->remarks;
                }

                if ($rowData->stage_id == 5) {
                    $dataSample = DB::table('samples')->where('id', $ticket_id)->first();

                    switch (optional($dataSample)->courier_id) {
                        case 1:
                            $cName = "DTDC";
                            break;
                        case 2:
                            $cName = "BLUE DART";
                            break;
                        case 3:
                            $cName = "OTHER";
                            break;
                        case 4:
                            $cName = "HAND OVER";
                            break;
                    }
                    $msgDetail = "<b>Courier:</b>" . $cName .
                        "<br><b>Tracking ID:</b>" . optional($dataSample)->track_id .
                        "<br><b>Sent On:</b>" . date('j-M-Y', strtotime(optional($dataSample)->sent_on));
                }

                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_data2,
                    'msg' => $msgDetail,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }

    //getLeadStageProcessCompletedHistory_SAMPLE_Fv2

    //getLeadStageProcessCompletedHistory_SAMPLE
    public static function getLeadStageProcessCompletedHistory_SAMPLE($process_id, $ticket_id)
    {
        $process_data = DB::table('st_process_action_6')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();
        $dataSample = array();
        $cName = "";
        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {
                $i++;
                $msgDetail = "";
                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                $stage_data2 = optional($stage_arrData)->stage_name;
                if ($rowData->stage_id == 1) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 3) {
                    $dataSample = DB::table('samples')->where('id', $ticket_id)->first();

                    $user = auth()->user();
                    $userRoles = $user->getRoleNames();
                    $user_role = $userRoles[0];
                    if ($user_role == "Admin" || Auth::user()->id == 89) {
                        // data 
                        $dataSampleArr = DB::table('samples_formula')->where('sample_id', $ticket_id)->get();
                        if ($dataSampleArr == null) {
                            $msgDetail = "DONE";
                        } else {
                            foreach ($dataSampleArr as $key => $rowDataS) {

                                $msgDetail .= '<table class="table table-sm m-table m-table--head-bg-brand">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>' . $rowDataS->sample_code_with_part . '</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">Fragrance:' . $rowDataS->fragrance . '</td>
                                    </tr>
                                    <tr>

                                    <td scope="row">Color:' . $rowDataS->color_val . '</td>
                                    </tr>
                                    <tr>
                                    <td scope="row">PH:' . $rowDataS->ph_val . '</td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Apperance:' . $rowDataS->apperance_val . '</th>
                                    </tr>
                                    <tr>
                                    <th scope="row">Chemist:' . optional(AyraHelp::getUser(optional($rowDataS)->chemist_id))->name . '</th>
                                    </tr>
                                    <tr>
                                    <th scope="row">Created by:' . optional(AyraHelp::getUser(optional($rowDataS)->created_by))->name . '</th>
                                    </tr>
                                   
                                </tr>
                               
                            </tbody>
                        </table>';
                            }
                        }
                        // data 
                    } else {
                        // data aa
                        // data 
                        $dataSampleArr = DB::table('samples_formula')->where('sample_id', $ticket_id)->get();
                        if ($dataSampleArr == null) {
                            $msgDetail = "DONE";
                        } else {
                            foreach ($dataSampleArr as $key => $rowDataS) {

                                $msgDetail .= '<table class="table table-sm m-table m-table--head-bg-brand">
                                 <thead class="thead-inverse">
                                     <tr>
                                         <th>' . $rowDataS->sample_code_with_part . '</th>                                   
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                         <td scope="row"><b>Fragrance:</b>' . $rowDataS->fragrance . '</td>
                                         </tr>
                                         <tr>
     
                                         <td scope="row"><b>Color:</b>' . $rowDataS->color_val . '</td>
                                         </tr>
                                         <tr>
                                         <td scope="row"><b>PH:</b>' . $rowDataS->ph_val . '</td>
                                         </tr>
                                         <tr>
                                         <th scope="row"><b>Apperance:</b>' . $rowDataS->apperance_val . '</th>
                                         </tr>
                                        
                                         <tr>
                                         <th scope="row"><b>Created by:</b>' . optional(AyraHelp::getUser(optional($rowDataS)->created_by))->name . '</th>
                                         </tr>
                                        
                                     </tr>
                                    
                                 </tbody>
                             </table>';
                            }
                        }
                        // data 
                        // data aa
                    }
                }
                if ($rowData->stage_id == 2) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 3) {
                    $msgDetail = $rowData->remarks;
                }
                if ($rowData->stage_id == 4) {
                    $msgDetail = $rowData->remarks;
                }

                if ($rowData->stage_id == 5) {
                    $dataSample = DB::table('samples')->where('id', $ticket_id)->first();

                    switch (optional($dataSample)->courier_id) {
                        case 1:
                            $cName = "DTDC";
                            break;
                        case 2:
                            $cName = "BLUE DART";
                            break;
                        case 3:
                            $cName = "OTHER";
                            break;
                        case 4:
                            $cName = "HAND OVER";
                            break;
                    }
                    $msgDetail = "<b>Courier:</b>" . $cName .
                        "<br><b>Tracking ID:</b>" . optional($dataSample)->track_id .
                        "<br><b>Sent On:</b>" . date('j-M-Y', strtotime(optional($dataSample)->sent_on));
                }

                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_data2,
                    'msg' => $msgDetail,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }

    //getLeadStageProcessCompletedHistory_SAMPLE
    // getLeadStageProcessCompletedHistory_MYLEAD
    public static function getLeadStageProcessCompletedHistory_MYLEAD($process_id, $ticket_id)
    {
        $process_data = DB::table('st_process_action_5_mylead')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();

        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {
                $i++;

                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                $stage_data2 = optional($stage_arrData)->stage_name;

                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_data2,
                    'msg' => $rowData->remarks,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }

    // getLeadStageProcessCompletedHistory_MYLEAD

    public static function getLeadStageProcessCompletedHistory($process_id, $ticket_id)
    {
        $process_data = DB::table('st_process_action_4')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();

        if (count($process_data) > 0) {
            $i = 0;
            foreach ($process_data as $key => $rowData) {
                $i++;

                $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                $stage_data2 = optional($stage_arrData)->stage_name;

                $stage_data[] = array(
                    'id' => $i,
                    'stage_name' => $stage_data2,
                    'msg' => $rowData->remarks,
                    'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                    'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                );
            }
            return $stage_data;
        } else {
            return array();
        }
    }

    public static function getStageProcessCompletedHistory($process_id, $ticket_id)
    {

        if ($process_id == 2) {
            $process_data = DB::table('st_process_action_2')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->get();
            //return $process_data;
            if (count($process_data) > 0) {
                $i = 0;
                foreach ($process_data as $key => $rowData) {

                    $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);

                    $stage_data2 = $stage_arrData->stage_name;
                    if ($stage_arrData->stage_name == 'Ordered') {
                        $data_pur = PurchaseOrderRecieved::where('purchase_id', $ticket_id)->first();
                        $stage_data2 = "Ordered" . " PO No.:" . optional($data_pur)->po_no . '<br>';
                        $stage_data2 .= "ETA :" . date("j-M-y", strtotime(optional($data_pur)->eta)) . '<br>';
                        $stage_data2 .= "Note:" . optional($data_pur)->order_remark . '<br>';
                    }
                    if ($stage_arrData->stage_name == 'Received in Stock ') {
                        $data_pur = PurchaseOrderRecieved::where('purchase_id', $ticket_id)->first();
                        //$stage_data2="Received in Stock".": QTY:".optional($data_pur)->qty_recieved;
                        $stage_data2 = "Received in Stock" . " GRPO No.:" . optional($data_pur)->grpo . '<br>';
                        $stage_data2 .= "QTY :" . optional($data_pur)->qty_recieved . '<br>';
                        $stage_data2 .= "Note:" . optional($data_pur)->rec_remark . '<br>';
                    }
                    //ajay@codemunch.in




                    $i++;
                    $stage_data[] = array(
                        'id' => $i,
                        'stage_name' => $stage_data2,
                        'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                        'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                    );
                }
                return $stage_data;
            } else {
                return array();
            }
        } else {


            $process_data = DB::table('st_process_action')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_on', 1)->where('action_status', 1)->get();
            // echo "<pre>";
            // print_r($process_data);
            // die;

            //return $process_data;
            if (count($process_data) > 0) {
                $i = 0;
                foreach ($process_data as $key => $rowData) {

                    $stage_arrData = AyraHelp::getStageDataBYpostionID($rowData->stage_id, $process_id);
                    $i++;
                    $stage_data[] = array(
                        'id' => $i,
                        'stage_name' => optional($stage_arrData)->stage_name,
                        'completed_on' => date('j-M-y h:i A', strtotime($rowData->created_at)),
                        'completed_by' => AyraHelp::getUser($rowData->completed_by)->name
                    );
                }
                return $stage_data;
            } else {
                return array();
            }
        }
    }



    public static function getProcessCurrentStageOrder($process_id, $ticket_id)
    {
        //================================
        $process_data = DB::table('st_process_action')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->latest()->first();

        if ($process_data == null) {
            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', 1)->first();
        } else {



            $process_data = DB::table('st_process_stages')->where('stage_position', $process_data->stage_id)->first();

            $newsid = $process_data->stage_id + 1;


            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', $newsid)->first();
        }
        //===========================


    }

    public static function getProcessCurrentStagePurchase($process_id, $ticket_id)
    {


        //================================
        // ajcode

        $process_data = DB::table('qc_bo_purchaselist')->where('id', $ticket_id)->first();


        //$process_data = DB::table('st_process_action_2')->where('process_id',$process_id)->where('ticket_id',$ticket_id)->latest()->first();

        if ($process_data == null) {
            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', 1)->first();
        } else {





            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', $process_data->status)->first();
        }
        //===========================


    }



    public static function getPurchaseStageLIST()
    {
        return DB::table('st_process_stages')->where('process_id', 2)->get();
    }

    public static function getProcessCurrentStage($process_id, $ticket_id)
    {

        $process_data = DB::table('st_process_action')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->where('action_status', 1)->orderBy('stage_id', 'desc')->first();



        if ($process_data == null) {
            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', 1)->first();
        } else {
            //ajcode
            //get ordet type
            $form_data = AyraHelp::getQCFormDate($ticket_id);

            $orderType = optional($form_data)->order_type;
            $define_stage_arr = array();
            if ($orderType == 'Private Label') {
                if ($form_data->order_repeat == 2) {

                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
                } else {
                    // echo "no repeat";
                    if ($process_data->action_status == 1) {
                        $define_stage_arr = [1, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                    } else {
                        $define_stage_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                    }
                }
            }
            if ($orderType == 'Bulk' || $orderType == 'BULK') {
                if ($form_data->qc_from_bulk == 1) {

                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                } else {
                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                }
            }






            $process_data = DB::table('st_process_stages')->where('stage_position', $process_data->stage_id)->first();
            //echo $newsid=$process_data->stage_id+1;
            $newsid = optional($process_data)->stage_id;

            if ($newsid == count($define_stage_arr)) {
                $datamy = array('stage_name' => 'completed');
                return (object) $datamy;
            } else {
                foreach ($define_stage_arr as $key => $rowVal) {

                    if ($rowVal > $newsid) {
                        if ($rowVal == 0) {
                        } else {
                            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', $rowVal)->first();
                        }
                    }
                }
            }



            // die;
            //get ordet type

            //ajcode
            // $process_data = DB::table('st_process_stages')->where('stage_position',$process_data->stage_id)->first();
            // $newsid=$process_data->stage_id+1;




        }
    }
    public static function getProcessCurrentStage_($process_id, $ticket_id)
    {


        $process_data = DB::table('st_process_action')->where('process_id', $process_id)->where('ticket_id', $ticket_id)->latest()->first();


        if ($process_data == null) {
            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', 1)->first();
        } else {
            //ajcode
            //get ordet type
            $form_data = AyraHelp::getQCFormDate($ticket_id);

            $orderType = optional($form_data)->order_type;
            $define_stage_arr = array();
            if ($orderType == 'Private Label') {
                if ($form_data->order_repeat == 2) {

                    $define_stage_arr = [1, 2, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
                } else {
                    // echo "no repeat";
                    $define_stage_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
                }
            }
            if ($orderType == 'Bulk' || $orderType == 'BULK') {
                if ($form_data->qc_from_bulk == 1) {

                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                } else {
                    $define_stage_arr = [1, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 12, 13];
                }
            }





            $process_data = DB::table('st_process_stages')->where('stage_position', $process_data->stage_id)->first();
            //echo $newsid=$process_data->stage_id+1;
            $newsid = $process_data->stage_id;

            if ($newsid == count($define_stage_arr)) {
                $datamy = array('stage_name' => 'completed');
                return (object) $datamy;
            } else {
                foreach ($define_stage_arr as $key => $rowVal) {

                    if ($rowVal > $newsid) {
                        if ($rowVal == 0) {
                        } else {
                            return $process_data = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_position', $rowVal)->first();
                        }
                    }
                }
            }



            // die;
            //get ordet type

            //ajcode
            // $process_data = DB::table('st_process_stages')->where('stage_position',$process_data->stage_id)->first();
            // $newsid=$process_data->stage_id+1;




        }
    }
    public static function getProcessRowCount($process_id, $ticket_id)
    {

        switch ($process_id) {
            case 1:
                $data = QCFORM::where('form_id', $ticket_id)->first();
                return 1;
                break;
            case 2:
                $data = QC_BOM_Purchase::where('id', $ticket_id)->first();
                $data_arr = QC_BOM_Purchase::where('form_id', $data->form_id)->count();
                return $data_arr;
                break;
        }
    }
    public static function getStageDependentFlagParent($process_id, $stageid, $ticket_id, $txtRowCount, $dependent_ticket_id)
    {
        $process_arr = DB::table('st_process_stages')->where('process_id', $process_id)->where('process_dependent', 1)->get();
        $mYstageCount = count($process_arr);
        $chdata = $mYstageCount - 1;



        if ($mYstageCount > 0) {


            //yes dependent with parent and check all statage neet to complete of child i.e my
            //then complete parenet stage
            $data_childCount = DB::table('st_process_action')->where('ticket_id', $ticket_id)->where('process_id', $process_id)->where('action_on', 1)->get();

            if (count($data_childCount) == $chdata) {
                // echo count($data_childCount);
                // echo $chdata;
                // die;


                //need to check is row dependent i no then ok if yes
                //find count of row is to be completed then belcode code execute
                $process_row_arr = DB::table('st_process_stages')->where('process_id', $process_id)->where('row_depenent', 1)->get();
                $mYstageRowCount = count($process_arr);




                if ($mYstageRowCount > 0) {
                    $multirowcount = $txtRowCount * $mYstageCount; //21
                    $mYstageRowCount; //7




                    $rowdata = DB::table('st_process_action')->where('dependent_ticket_id', $dependent_ticket_id)->where('process_id', $process_id)->where('action_on', 1)->get();


                    if ($multirowcount == count($rowdata) + 1) {
                        $data_pid_arr = explode("_", $process_arr[0]->process_dependent_stage_code);
                        $pid = $data_pid_arr[2];
                        $stid = $data_pid_arr[3];
                        $data = DB::table('st_process_action')->where('ticket_id', $ticket_id)->where('process_id', $pid)->where('stage_id', $stid)->where('action_on', 1)->first();
                        if ($data == null) {
                            DB::table('st_process_action')->insert(
                                [
                                    'ticket_id' => $dependent_ticket_id,

                                    'process_id' => $pid,
                                    'stage_id' => $stid,
                                    'action_on' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'expected_date' => date('Y-m-d H:i:s'),
                                    'remarks' => 'Auto s Completed :DP:' . $pid,
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
                        return 1;
                    } else {
                        return 1;
                    }
                } else {
                    $data_pid_arr = explode("_", $process_arr[0]->process_dependent_stage_code);
                    $pid = $data_pid_arr[2];
                    $stid = $data_pid_arr[3];
                    $data = DB::table('st_process_action')->where('ticket_id', $ticket_id)->where('process_id', $pid)->where('stage_id', $stid)->where('action_on', 1)->first();
                    if ($data == null) {
                        DB::table('st_process_action')->insert(
                            [
                                'ticket_id' => $dependent_ticket_id,
                                'process_id' => $pid,
                                'stage_id' => $stid,
                                'action_on' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'expected_date' => date('Y-m-d H:i:s'),
                                'remarks' => 'Auto . Completed :DP:' . $pid,
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
                    return 1;
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    public static function getStageDependentFlagChild($process_id, $stageid, $ticket_id)
    {
        $process_arr = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_id', $stageid)->where('dependent', 1)->first();

        if ($process_arr == null) {
            return 1;
        } else {

            $dp_process_id = Str::after($process_arr->dependent_with_process_id, 'DP_PID_');
            $all_process_arr = self::getAllStageBYProcessID($dp_process_id);
            foreach ($all_process_arr as $key => $myRow) {
                $data = DB::table('st_process_action')->where('ticket_id', $ticket_id)->where('process_id', $process_id)->where('stage_id', $myRow->stage_id)->where('action_on', 1)->first();
                if ($data == null) {

                    //save data all belongs to that stages
                    if ($process_id == 2) {
                        DB::table('st_process_action')->insert(
                            [
                                'ticket_id' => $ticket_id,
                                'process_id' => $dp_process_id,
                                'stage_id' => $myRow->stage_id,
                                'action_on' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'expected_date' => date('Y-m-d H:i:s'),
                                'remarks' => 'Auto Completed :DP:' . $process_id,
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
                    if ($process_id == 1) {
                        $data_arr = QC_BOM_Purchase::where('form_id', $ticket_id)->get();
                        $i = 1;
                        foreach ($data_arr as $key => $RowData) {

                            DB::table('st_process_action')->insert(
                                [
                                    'ticket_id' => $RowData->id,
                                    'process_id' => $dp_process_id,
                                    'stage_id' => $i,
                                    'action_on' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'expected_date' => date('Y-m-d H:i:s'),
                                    'remarks' => 'Auto Completed :DP:' . $process_id,
                                    'attachment_id' => 0,
                                    'assigned_id' => 1,
                                    'undo_status' => 1,
                                    'updated_by' => Auth::user()->id,
                                    'created_status' => 1,
                                    'completed_by' => Auth::user()->id,
                                    'statge_color' => 'completed',
                                ]
                            );
                            $i++;
                        }
                    }
                }
            }
            return 1;
        }
    }
    public static  function getAllStageBYProcessID($process_id)
    {
        $process_arr = DB::table('st_process_stages')->where('process_id', $process_id)->get();
        return $process_arr;
    }

    // getMasterStageResponseMY_LEAD
    public static function getMasterStageResponseMY_LEAD($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {
        $stage_data = AyraHelp::getStagesListMY_LEAD($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = DB::table('client_sales_lead')->where('QUERY_ID', $ticket_id)->first();
        $data_action_done_arr = AyraHelp::getLeadStageProcessCompletedHistory_MYLEAD($process_id, $ticket_id);


        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => 11,
            'process_data' => $data,
            'created_by' => 44,
            'qc_data' => $myqc_data,
            'BOM_HTML' => '',
            'artwork_start_date' => date('Y-m-d'),
            'stage_action_data' => $data_action_done_arr, //0 not 1 accesabe
            'stage_action_dataComment' => '', //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    // getMasterStageResponseMY_LEAD




    public static function getMasterStageResponseLEAD($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {
        $stage_data = AyraHelp::getStagesListLEAD($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = DB::table('indmt_data')->where('QUERY_ID', $ticket_id)->first();
        $data_action_done_arr = AyraHelp::getLeadStageProcessCompletedHistory($process_id, $ticket_id);


        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => 11,
            'process_data' => $data,
            'created_by' => 44,
            'qc_data' => $myqc_data,
            'BOM_HTML' => '',
            'artwork_start_date' => date('Y-m-d'),
            'stage_action_data' => $data_action_done_arr, //0 not 1 accesabe
            'stage_action_dataComment' => '', //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    //getMasterStageResponseSAMPLE_Fv2
    public static function getMasterStageResponseSAMPLE_Fv2($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {


        $stage_data = AyraHelp::getStagesListSAMPLE_Fv2($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = DB::table('samples')->where('id', $ticket_id)->first();
        $data_action_done_arr = AyraHelp::getLeadStageProcessCompletedHistory_SAMPLE_Fv2($process_id, $ticket_id);

        //get purchase details with status

        $bom_arrs = DB::table('st_process_action_6v2')->where('ticket_id', $ticket_id)->get();


        $BO_HTML = '';
        $BO_HTML .= '<div class="m-section">
  
    <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-brand">
        <thead class="thead-inverse">
          <tr>
            <th>#</th>
            <th>Stage Name</th>
            <th>Details</th>
            <th>Completed by</th>
            <th>Completed On</th>            
          </tr>
        </thead>
        <tbody>';
        $i = 0;
        foreach ($bom_arrs as $key => $myRow) {

            $BO_HTML .= '
              <tr>
                <th scope="row">' . $i . '</th>
                <td>' . $myRow->stage_id . '</td>
                <td>' . $myRow->stage_id . '</td>
                <td>' . $myRow->completed_by . '</td>
                <td>' . $myRow->stage_id . '</td>
                
              </tr>';
        }
        $BO_HTML .= '
            </tbody>
            </table>
          </div>
        </div>';
        //get purchase details with status


        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => 11,
            'process_data' => $data,
            'created_by' => 44,
            'qc_data' => $myqc_data,
            'BOM_HTML' => $BO_HTML,
            'artwork_start_date' => date('Y-m-d'),
            'stage_action_data' => $data_action_done_arr,
            'stage_action_dataComment' => '', //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    //getMasterStageResponseSAMPLE_Fv2

    //getMasterStageResponseSAMPLE
    public static function getMasterStageResponseSAMPLE($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {
        $stage_data = AyraHelp::getStagesListSAMPLE($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = DB::table('samples')->where('id', $ticket_id)->first();
        $data_action_done_arr = AyraHelp::getLeadStageProcessCompletedHistory_SAMPLE($process_id, $ticket_id);

        //get purchase details with status

        $bom_arrs = DB::table('st_process_action_6')->where('id', $ticket_id)->get();


        $BO_HTML = '';
        $BO_HTML .= '<div class="m-section">
  
    <div class="m-section__content">
      <table class="table table-sm m-table m-table--head-bg-brand">
        <thead class="thead-inverse">
          <tr>
            <th>#</th>
            <th>Stage Name</th>
            <th>Details</th>
            <th>Completed by</th>
            <th>Completed On</th>            
          </tr>
        </thead>
        <tbody>';
        $i = 0;
        foreach ($bom_arrs as $key => $myRow) {

            $BO_HTML .= '
              <tr>
                <th scope="row">' . $i . '</th>
                <td>' . $myRow->stage_id . '</td>
                <td>' . $myRow->stage_id . '</td>
                <td>' . $myRow->completed_by . '</td>
                <td>' . $myRow->stage_id . '</td>
                
              </tr>';
        }
        $BO_HTML .= '
            </tbody>
            </table>
          </div>
        </div>';
        //get purchase details with status


        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => 11,
            'process_data' => $data,
            'created_by' => 44,
            'qc_data' => $myqc_data,
            'BOM_HTML' => $BO_HTML,
            'artwork_start_date' => date('Y-m-d'),
            'stage_action_data' => $data_action_done_arr,
            'stage_action_dataComment' => '', //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    //getMasterStageResponseSAMPLE

    public static function getMasterStageResponseRND($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {
        $stage_data = AyraHelp::getStagesListRND($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = DB::table('rnd_new_product_development')->where('id', $ticket_id)->first();

        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => 11,
            'process_data' => $data,
            'created_by' => 44,
            'qc_data' => $myqc_data,
            'BOM_HTML' => '',
            'artwork_start_date' => date('Y-m-d'),
            'stage_action_data' => '', //0 not 1 accesabe
            'stage_action_dataComment' => '', //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    public static function getMasterStageResponse($process_id, $ticket_id, $data, $rowCount, $dependent_ticket)
    {
        $stage_data = AyraHelp::getStagesList($process_id, $ticket_id, $rowCount, $dependent_ticket);
        $myqc_data = AyraHelp::getQCFormDate($data->form_id);

        $data_action_done_arr = AyraHelp::getStageProcessCompletedHistory($process_id, $ticket_id);
        $data_actionComment_done_arr = AyraHelp::getStageProcessCommentHistory($process_id, $ticket_id);



        //get purchase details with status
        $bom_arrs = QC_BOM_Purchase::where('form_id', $ticket_id)->get();

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
                $update_statge_on = 'NA';
            }

            $up_arr = AyraHelp::getUser($myRow->update_statge_by);

            $stage = '';

            switch ($myRow->status) {
                case 1:
                    $stage = 'Not started';
                    break;
                case 2:
                    $stage = 'Design Awaited';
                    break;
                case 3:
                    $stage = 'Sample Awaited';
                    break;
                case 4:
                    $stage = 'Waiting for Quotation';
                    break;
                case 5:
                    $stage = 'Ordered';
                    break;
                case 6:
                    $stage = 'Received in Stock ';
                    break;
                case 7:
                    $stage = 'Received From Client';
                    break;
                case 8:
                    $stage = 'Removed';
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



        $data_arr = array(
            'stages_info' => $stage_data,
            'itm_qty' => $data->item_qty,
            'process_data' => $data,
            'created_by' => AyraHelp::getUser($data->created_by)->name,
            'qc_data' => $myqc_data,
            'BOM_HTML' => $BO_HTML,
            'artwork_start_date' => date('j-M-y', strtotime($myqc_data->artwork_start_date)),
            'stage_action_data' => $data_action_done_arr, //0 not 1 accesabe
            'stage_action_dataComment' => $data_actionComment_done_arr, //0 not 1 accesabe

        );
        return response()->json($data_arr);
    }

    public static function getStageAction($ticket_id, $process_id, $statge_id)
    {
        $stage_action_data = DB::table('st_process_action')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('action_status', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();
        return $stage_action_data;
    }
    //getStageActionSAMPLE
    public static function getStageActionSAMPLE($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_action_6')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }
    public static function getStageActionSAMPLE_FV2($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_action_6v2')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }

    //getStageActionSAMPLE

    public static function getStageActionRND($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_action_3')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }



    public static function getStageActionMY_LEAD($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_action_5_mylead')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }


    public static function getStageActionLEAD($ticket_id, $process_id, $statge_id)
    {


        $stage_action_data = DB::table('st_process_action_4')->where('ticket_id', $ticket_id)->where('action_on', 1)->where('process_id', $process_id)->where('stage_id', $statge_id)->first();

        return $stage_action_data;
    }



    public static function getStageActionCHKAccessCode($access_code, $role_name)
    {

        $stage_action_data_arr = DB::table('st_user_access_action')->where('access_code', $access_code)->where('role_name', $role_name)->first();
        if ($stage_action_data_arr == null) {
            $stage_action_data = DB::table('st_user_access_action')->where('access_code', $access_code)->where('user_id', Auth::user()->id)->first();
        } else {
            $stage_action_data = DB::table('st_user_access_action')->where('access_code', $access_code)->where('role_name', $role_name)->first();
        }


        if ($stage_action_data == null) {
            return 0;
        } else {
            return 1;
        }
    }


    // getStagesListMY_LEAD

    public static function getStagesListMY_LEAD($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {


        $data_arr = array();

        if ($process_id == 5) {

            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5, 6, 7];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================

                        $get_stage_data = AyraHelp::getStageActionMY_LEAD($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );
                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageActionLEAD($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                    } else {
                        $stage_started = 1;
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe
                        'form_id' => $rowData->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }

            return $data_arr;
        }
    }

    // getStagesListMY_LEAD

    public static function getStagesListLEAD($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {



        if ($process_id == 4) {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5, 6, 7];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================

                        $get_stage_data = AyraHelp::getStageActionLEAD($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );
                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageActionLEAD($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                    } else {
                        $stage_started = 1;
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe
                        'form_id' => $rowData->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }

            return $data_arr;
        }
    }

    //getStagesListSAMPLE
    //getStagesListSAMPLE_Fv2
    public static function getStagesListSAMPLE_Fv2($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {



        if ($process_id == 6) {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================
                        //  echo "dd";
                        //  echo $ticket_id;
                        //  echo $process_id;
                        //  echo $rowData->stage_id;
                        //  die;
                        $get_stage_data = AyraHelp::getStageActionSAMPLE_FV2($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );

                        //===================================
                    }
                } else {
                    //================================
                    // $get_stage_data = AyraHelp::getStageActionRND($ticket_id, $process_id, $rowData->stage_id);
                    // if ($get_stage_data == null) {
                    //     $stage_started = 0;
                    // } else {
                    //     $stage_started = 1;
                    // }
                    // $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    // $data_arr[] = array(
                    //     'stage_name' => $rowData->stage_name,
                    //     'stage_id' => $rowData->stage_id,
                    //     'process_id' => $process_id,
                    //     'stage_access_status' => $access_stage, //0 not 1 accesabe
                    //     'started' => $stage_started, //0 not 1 accesabe
                    //     'form_id' => $rowData->frm_id, //0 not 1 accesabe
                    //     'rowCount' => $rowCount, //0 not 1 accesabe
                    //     'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                    //     'exp_date' => $rowCount, //0 not 1 accesabe
                    //     'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                    //     'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    // );
                    //===================================
                }
            }

            return $data_arr;
        }
    }

    //getStagesListSAMPLE_Fv2


    public static function getStagesListSAMPLE($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {



        if ($process_id == 6) {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================
                        //  echo "dd";
                        //  echo $ticket_id;
                        //  echo $process_id;
                        //  echo $rowData->stage_id;
                        //  die;
                        $get_stage_data = AyraHelp::getStageActionSAMPLE($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );

                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageActionRND($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                    } else {
                        $stage_started = 1;
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe
                        'form_id' => $rowData->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }

            return $data_arr;
        }
    }

    //getStagesListSAMPLE

    public static function getStagesListRND($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {



        if ($process_id == 3) {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();



            $define_stage_arr = [1, 2, 3, 4, 5, 6];


            //get ordet type
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================
                        //  echo "dd";
                        //  echo $ticket_id;
                        //  echo $process_id;
                        //  echo $rowData->stage_id;
                        //  die;
                        $get_stage_data = AyraHelp::getStageActionRND($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                        } else {
                            $stage_started = 1;
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );
                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageActionRND($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                    } else {
                        $stage_started = 1;
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe
                        'form_id' => $rowData->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }

            return $data_arr;
        }
    }
    public static function getStagesList($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {





        if ($process_id == 2) {
            //purchase process

            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            // ----------ajcode


            // ----------ajcode

            //$process_arr_2= DB::table('st_process_action_2')->where('process_id',$process_id)->where('ticket_id',$ticket_id)->first();
            $process_arr_2 = DB::table('qc_bo_purchaselist')->where('id', $ticket_id)->first();




            if ($process_arr_2 == null) {


                for ($i = 1; $i <= 8; $i++) {

                    $stage_arr = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_id', $i)->first();

                    $access_stage = AyraHelp::getStageActionCHKAccessCode($stage_arr->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $stage_arr->stage_name,
                        'stage_id' => $stage_arr->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => 0, //0 not 1 accesabe
                        'form_id' => $stage_arr->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $stage_arr->days_to_done, //0 not 1 accesabe

                    );
                }
            } else {


                //$results= DB::table('st_process_stages')->where('process_id',$process_id)->where('stage_id',$process_arr_2->stage_id)->first();
                $results = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_id', $process_arr_2->status)->first();



                // print_r($process_arr_2->stage_id);
                $stageid = ($process_arr_2->status);
                for ($i = 1; $i <= 8; $i++) {

                    $stage_arr = DB::table('st_process_stages')->where('process_id', $process_id)->where('stage_id', $i)->first();

                    $access_stage = AyraHelp::getStageActionCHKAccessCode($stage_arr->access_code, $user_role);
                    if ($i > $stageid) {
                        $started = 0;
                    } else {
                        $started = 1;
                    }

                    $data_arr[] = array(
                        'stage_name' => $stage_arr->stage_name,
                        'stage_id' => $stage_arr->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $started, //0 not 1 accesabe
                        'form_id' => $stage_arr->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                        'process_days' => $stage_arr->days_to_done, //0 not 1 accesabe

                    );
                }
            }



            //purchase process
        } else {
            $user = auth()->user();
            $userRoles = $user->getRoleNames();
            $user_role = $userRoles[0];
            $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();
            //get ordet type
            $form_data = AyraHelp::getQCFormDate($ticket_id);

            $orderType = optional($form_data)->order_type;
            $define_stage_arr = array();
            if ($orderType == 'Private Label') {
                if ($form_data->order_repeat == 2) {

                    $define_stage_arr = [1, 2, 0, 0, 0, 0, 7, 8, 9, 10, 0, 12, 13];
                } else {
                    // echo "no repeat";
                    $define_stage_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
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
            foreach ($results as $key => $rowData) {

                if (count($define_stage_arr) > 0) {
                    if ($define_stage_arr[$key] == $rowData->stage_id) {
                        //================================
                        $get_stage_data = AyraHelp::getStageAction($ticket_id, $process_id, $rowData->stage_id);
                        if ($get_stage_data == null) {
                            $stage_started = 0;
                            $stat_Date = '';
                            $dayAlet = '';
                        } else {


                            $stage_started = 1;
                            $dayAlet = '';
                            if ($rowData->stage_id == 1) { // if stage is 1 then check now long he started if same day then waring else delay days show with red ..

                                $created_date = date('Y-m-d', strtotime($form_data->created_at));
                                $stated_date = date('Y-m-d', strtotime($get_stage_data->created_at));
                                if ($created_date == $stated_date) {

                                    $dayAlet = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">1</span>';
                                } else {
                                    $created_date1 = \Carbon\Carbon::createFromFormat('Y-m-d', $created_date);
                                    $stated_date1 = \Carbon\Carbon::createFromFormat('Y-m-d', $stated_date);

                                    $diff_in_days = $stated_date1->diffForHumans($created_date1);
                                    $day_arr = explode(' ', $diff_in_days);
                                    $dayAlet = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">' . $day_arr[0] . '</span>';


                                    //echo "find diff of days to start";
                                }
                            } else {
                                $stat_Date = date('Y-m-d', strtotime($get_stage_data->created_at));
                                $dt = Carbon::parse($stat_Date);
                                $expected_date = $dt->addDays($rowData->days_to_done);
                                $completed_date = date('Y-m-d', strtotime($get_stage_data->completed_on));


                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $completed_date);
                                $diff_in_days = $expected_date->diffForHumans($from);
                                $day_arr = explode(' ', $diff_in_days);
                                if ($day_arr[0] > $rowData->days_to_done) {
                                    $dayAlet = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">' . $day_arr[0] . '</span>';
                                } else {
                                    $dayAlet = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">' . $day_arr[0] . '</span>';
                                }
                            }
                        }
                        $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                        $data_arr[] = array(
                            'stage_name' => $rowData->stage_name,
                            'stage_id' => $rowData->stage_id,
                            'process_id' => $process_id,
                            'stage_access_status' => $access_stage, //0 not 1 accesabe
                            'started' => $stage_started, //0 not 1 accesabe
                            'form_id' => $rowData->frm_id, //0 not 1 accesabe
                            'rowCount' => $rowCount, //0 not 1 accesabe
                            'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                            'exp_date' => $rowCount, //0 not 1 accesabe
                            'artwork_start_date' => $dayAlet, //0 not 1 accesabe
                            'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                        );
                        //===================================
                    }
                } else {
                    //================================
                    $get_stage_data = AyraHelp::getStageAction($ticket_id, $process_id, $rowData->stage_id);
                    if ($get_stage_data == null) {
                        $stage_started = 0;
                        $stat_Date = '';
                    } else {
                        $stage_started = 1;
                        $stat_Date = $get_stage_data->created_at;
                        $stat_Date = $get_stage_data->created_at->diffForHumans();
                    }
                    $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

                    $data_arr[] = array(
                        'stage_name' => $rowData->stage_name,
                        'stage_id' => $rowData->stage_id,
                        'process_id' => $process_id,
                        'stage_access_status' => $access_stage, //0 not 1 accesabe
                        'started' => $stage_started, //0 not 1 accesabe
                        'form_id' => $rowData->frm_id, //0 not 1 accesabe
                        'rowCount' => $rowCount, //0 not 1 accesabe
                        'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                        'exp_date' => $rowCount, //0 not 1 accesabe
                        'artwork_start_date' => $stat_Date, //0 not 1 accesabe
                        'process_days' => $rowData->days_to_done, //0 not 1 accesabe

                    );
                    //===================================
                }
            }
        }




        return $data_arr;
    }

    public static function getStagesList_temp($process_id, $ticket_id, $rowCount, $dependent_ticket)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        $results = DB::table('st_process_stages')->where('process_id', $process_id)->orderBy('stage_position', 'asc')->get();

        foreach ($results as $key => $rowData) {
            $get_stage_data = AyraHelp::getStageAction($ticket_id, $process_id, $rowData->stage_id);
            if ($get_stage_data == null) {
                $stage_started = 0;
            } else {
                $stage_started = 1;
            }
            $access_stage = AyraHelp::getStageActionCHKAccessCode($rowData->access_code, $user_role);

            $data_arr[] = array(
                'stage_name' => $rowData->stage_name,
                'stage_id' => $rowData->stage_id,
                'process_id' => $process_id,
                'stage_access_status' => $access_stage, //0 not 1 accesabe
                'started' => $stage_started, //0 not 1 accesabe
                'form_id' => $rowData->frm_id, //0 not 1 accesabe
                'rowCount' => $rowCount, //0 not 1 accesabe
                'dependent_ticket' => $dependent_ticket, //0 not 1 accesabe
                'exp_date' => $rowCount, //0 not 1 accesabe
                'artwork_start_date' => '2019-09-09', //0 not 1 accesabe
                'process_days' => $rowData->days_to_done, //0 not 1 accesabe

            );
        }
        return $data_arr;
    }





    public static function UpdateSAPCHKLIST()
    {

        $form_arr = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->get();
        foreach ($form_arr as $key => $rowData) {

            $flight = SAP_CHECKLISt::updateOrCreate(
                ['form_id' => $rowData->form_id],
                [

                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'update_on' => date('Y-m-d H:i:s')
                ]
            );
        }
    }


    public static function getClientOrderValMonthWise($m_digit, $client_id)
    {





        // $datasAll=QCFORM::where('is_deleted',0)->get();
        // $sumTotalAll=0;
        // foreach($datasAll as $key=> $rowDataAll){
        //     $sumAll=$rowDataAll->item_qty*$rowDataAll->item_sp;
        //     $sumTotalAll=$sumAll+$sumTotalAll;

        // }
        // $sumTotalAll;

        $year_digit = "2023";

        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
        // print_r(count($datas));
        // die;

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }


        return $sumTotal;
    }


    //getOrderCountBYClientID
    public static function getOrderCountBYClientID($client_id)
    {
        $datasAll = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->get();
        return count($datasAll);
    }
    //getOrderCountBYClientID

    public static function getClientOrderValue($client_id)
    {




        // $datasAll = QCFORM::where('is_deleted', 0)->get();
        // $sumTotalAll = 0;
        // foreach ($datasAll as $key => $rowDataAll) {
        //     $sumAll = $rowDataAll->item_qty * $rowDataAll->item_sp;
        //     $sumTotalAll = $sumAll + $sumTotalAll;
        // }
        // $sumTotalAll;
        $sumTotalAll1 = QCFORM::where('is_deleted', 0)->where('order_type', 'Private Label')
            ->value(DB::raw("SUM(item_qty * item_sp)"));
        $sumTotalAll2 = QCFORM::where('is_deleted', 0)->where('order_type', 'Private Bulk')
            ->sum('bulk_order_value');

        $sumTotalAll = $sumTotalAll1 + $sumTotalAll2;


        // $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->get();
        // $sumTotal = 0;
        // foreach ($datas as $key => $rowData) {
        //     if ($rowData->qc_from_bulk == 1) {
        //         $sum = $rowData->bulk_order_value;
        //         $sumTotal = $sum + $sumTotal;
        //     } else {
        //         $sum = $rowData->item_qty * $rowData->item_sp;
        //         $sumTotal = $sum + $sumTotal;
        //     }
        // }
        // $sumTotal;
        $sumTotal1 = QCFORM::where('is_deleted', 0)->where('order_type', 'Bulk')->where('client_id', $client_id)->sum('bulk_order_value');
        $sumTotal2 = QCFORM::where('is_deleted', 0)->where('order_type', 'Private Label')->where('client_id', $client_id)->value(DB::raw("SUM(item_qty * item_sp)"));
        $sumTotal = $sumTotal1 + $sumTotal2;


        $orderP = ($sumTotal * 100) / $sumTotalAll;

        $data = array(
            'order_val' => $sumTotal,
            'order_percentage' => substr($orderP, 0, 4)

        );
        return $data;
    }

    public static function getClientOrderValueFilter($client_id, $month_date, $sales_user)
    {



        $month = \Carbon\Carbon::createFromFormat('Y-m-d', $month_date)->month;




        if ($sales_user == 'ALL') {
            $datasAll = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->get();
        } else {
            $datasAll = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $month)->where('created_by', $sales_user)->get();
        }

        $sumTotalAll = 0;
        foreach ($datasAll as $key => $rowDataAll) {
            $sumAll = $rowDataAll->item_qty * $rowDataAll->item_sp;
            $sumTotalAll = $sumAll + $sumTotalAll;
        }
        $sumTotalAll;

        if ($sales_user == 'ALL') {
            $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->get();
        } else {
            $datas = QCFORM::where('is_deleted', 0)->where('client_id', $client_id)->whereMonth('created_at', $month)->where('created_by', $sales_user)->get();
        }

        $sumTotal = 0;
        foreach ($datas as $key => $rowData) {
            if ($rowData->qc_from_bulk == 1) {
                $sum = $rowData->bulk_order_value;
                $sumTotal = $sum + $sumTotal;
            } else {
                $sum = $rowData->item_qty * $rowData->item_sp;
                $sumTotal = $sum + $sumTotal;
            }
        }
        $sumTotal;
        $orderP = ($sumTotal * 100) / $sumTotalAll;

        $data = array(
            'order_val' => $sumTotal,
            'order_percentage' => substr($orderP, 0, 4)

        );
        return $data;
    }


    public static function ARPData($plan_id)
    {
        $datas = OPHAchieved::where('plan_id', $plan_id)->get();

        return $datas;
    }
    public static function getAllPOCData()
    {
        $datas = POCatalogData::get();
        return $datas;
    }

    public static function getMonthlyDispatchUnitsPrice($m_digit)
    {
        $ydigit = "2023";
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        $qc_data = array();
        if ($user_role == 'Admin') {
            $qc_data = OrderDispatchData::whereMonth('dispatch_on', $m_digit)->whereYear('dispatch_on', $ydigit)->get();
        }
        $me = array();
        $i = 0;
        foreach ($qc_data as $key => $row) {
            $qc_data = AyraHelp::getQCFormDate($row->form_id);
            $b = intval(optional($qc_data)->item_sp) * intval($row->total_unit);
            $i = $b;
            $me[] = $i;
        }
        return array_sum($me);
    }

    public static function purchaseArtWork()
    {
        $orderData = QC_BOM_Purchase::where('dispatch_status', 1)->where('status', 2)->where('is_deleted', 0)->orderBy('order_id', 'DESC')->get();
        $i = 0;
        foreach ($orderData as $key_opd => $orderval) {
            //current  order statge
            $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
            if (isset($qc_data_arr->order_statge_id)) {
                $statge_arr = AyraHelp::getStageNameByCode($qc_data_arr->order_statge_id);
                $Spname = optional($statge_arr)->step_code;
            } else {
                $Spname = '';
            }
            if ($Spname == 'ART_WORK_RECIEVED') {
                $i++;
            }
            //current  order statge

        }
        $data = array(
            'artwork_count' => $i,
            'allothers' => count($orderData) - $i,
        );
        return $data;
    }
    public static function getTopClient($digit)
    {
        //   $chartDatas = QCFORM::select([
        //      DB::raw('item_sp*item_qty AS orderVal,form_id'),

        //   ])

        //   ->orderBy('form_id', 'DESC')
        //   ->take($digit)
        //   ->get();

        $chartDatas = DB::table('qc_forms')
            ->leftJoin('clients', 'qc_forms.client_id', '=', 'clients.id')
            ->sum(DB::raw('qc_forms.item_sp * qc_forms.item_qty'));
        return $chartDatas;
    }

    public static function getMonthlyDispatchUnits($m_digit)
    {
        $ydigit = "2023";
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        $qc_data = array();

        $qc_data = OrderDispatchData::whereMonth('dispatch_on', $m_digit)->whereYear('dispatch_on', $ydigit)->get();


        $me = array();
        $i = 0;
        foreach ($qc_data as $key => $row) {
            $i = intval($row->total_unit);
            $me[] = $i;
        }



        return array_sum($me);
    }
    public static function AyraCrypt($data)
    {
        return $encrypted = Crypt::encryptString($data);
    }
    public static function AyraEnCrypt($data)
    {
        return $decrypted = Crypt::decryptString($data);
    }

    public static function getOrderListByPlan($form_id)
    {
        $data_arr = HPlanDay2::where('form_id', $form_id)->get();
    }

    public static function getRNDStageNOW()
    {
        $data_planDay4Only_arr = DB::table('st_process_stages')->where('process_id', 3)->get();
        return $data_planDay4Only_arr;
    }

    public static function getPlanDay4Day($PlanId)
    {
        $data_planDay4Only_arr = DB::table('h_plan_day_4')->where('plan_id', $PlanId)->first();
        return $data_planDay4Only_arr;
    }

    public static function getPlanDay4DayFormID($form_id)
    {
        $data_planDay4Only_arr = DB::table('h_plan_day_4')->where('form_id', $form_id)->first();
        return $data_planDay4Only_arr;
    }
    public static function getAllPlanDataByPlanID($PlanId)
    {
        $data_plan_arr = DB::table('h_plan_day')->where('id', $PlanId)->first();
        $data_planDay4_arr = DB::table('h_plan_day_4')->where('plan_id', $PlanId)->get();


        $data = array(
            'plan_data' => $data_plan_arr,
            'planDay4_data' => $data_planDay4_arr

        );
        return $data;
    }


    public static function getPendingOrderCountwithValue($id)
    {
        switch ($id) {
            case 1:
                $orderData = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->get();
                return count($orderData);
                break;
            case 2:
                $qc_data = array();

                $qc_data = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->get();







                $me = array();
                foreach ($qc_data as $key => $row) {
                    if (isset($row->qc_from_bulk)) {
                        if ($row->qc_from_bulk == 1) {
                            $me[] = $row->bulk_order_value;
                        } else {
                            $me[] = ($row->item_sp) * ($row->item_qty);
                        }
                    } else {
                        $me[] = ($row->item_sp) * ($row->item_qty);
                    }
                }

                $amount = array_sum($me);
                setlocale(LC_MONETARY, 'en_IN');
                $amount = money_format('%!i', $amount);
                $pieces = explode(".", $amount);
                return $pieces[0];


                break;
        }
    }
    public static function getPendingProcessCount($id)
    {
        switch ($id) {
            case 1:
                # code...
                $orderData = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                // $orderData =DB::table('order_master')
                //     ->join('qc_forms', 'qc_forms.form_id', '=', 'order_master.form_id')
                //     ->where('qc_forms.dispatch_status',1)
                //     ->where('qc_forms.order_type','!=','Bulk')
                //     ->where('qc_forms.artwork_status',1)
                //     ->where('qc_forms.is_deleted',0)
                //     ->where('order_master.order_statge_id','!=','DISPATCH_ORDER')
                //     ->select('qc_forms.*')
                //     ->get();


                $i = 0;
                foreach ($orderData as $key_opd => $orderval) {
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($orderval->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $orderval->form_id;


                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = $batchSize = (ceil((($orderval->item_qty) * ($orderval->item_size)) / 1000));
                        $i = $i + $mydata;
                    }
                }
                return $i . " KG";
                break;
            case 2:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();
                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    // print_r($rowData->form_id);
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'FILLING')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }
                }

                return $j . ' PCS';
                # code...
                break;
            case 3:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();
                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'SEAL')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
            case 4:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();
                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {

                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'CAPPING')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;

            case 5:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    // print_r($rowData->form_id);
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'LABEL')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
            case 6:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();
                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    // print_r($rowData->form_id);
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'CODING ON LABEL')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
            case 7:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    // print_r($rowData->form_id);
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'BOXING')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
            case 8:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'CODING ON BOX')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------



                }
                return $j . ' PCS';
                # code...
                break;
            case 9:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'SHRINK WRAP')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
            case 10:
                # code...
                $data_arr = QCFORM::where('dispatch_status', 1)->where('order_type', '!=', 'Bulk')->where('artwork_status', 1)->where('is_deleted', 0)->get();

                $i = 0;
                $j = 0;
                foreach ($data_arr as $dataKey => $rowData) {
                    //-----------
                    $qc_data_arr = AyraHelp::getCurrentStageByForMID($rowData->form_id);
                    if (isset($qc_data_arr->order_statge_id)) {
                        $step_code = $qc_data_arr->order_statge_id;
                    } else {
                        $step_code = optional($qc_data_arr)->order_statge_id;
                    }
                    if ($step_code != 'DISPATCH_ORDER') {
                        $mydata = QCPP::where('qc_from_id', $rowData->form_id)->where('qc_label', 'CARTONIZE')->where('qc_yes', 'YES')->first();
                        if ($mydata != null) {
                            $i++;
                            $j = $j + $rowData->item_qty;
                        }
                    }

                    //------------


                }
                return $j . ' PCS';
                # code...
                break;
        }
        // return $i;

    }

    public static function getSAPLISTPending($sapid)
    {

        switch ($sapid) {
            case '1':
                //$datas = DB::table('sap_checklist')->where('sap_so',0)->get();
                $datas = DB::table('sap_checklist')
                    ->join('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_so', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();


                break;
            case '2':
                // $datas = DB::table('sap_checklist')->where('sap_fg',0)->get();
                $datas = DB::table('sap_checklist')
                    ->join('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_fg', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();

                break;
            case '3':
                // $datas = DB::table('sap_checklist')->where('sap_sfg',0)->get();
                $datas = DB::table('sap_checklist')
                    ->join('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_sfg', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();

                break;
            case '4':
                // $datas = DB::table('sap_checklist')->where('sap_production',0)->get();
                $datas = DB::table('sap_checklist')
                    ->join('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_production', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();


                break;
            case '5':
                // $datas = DB::table('sap_checklist')->where('sap_invoice',0)->get();
                $datas = DB::table('sap_checklist')
                    ->join('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_invoice', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();

                break;
            case '6':
                //$datas = DB::table('sap_checklist')->where('sap_dispatch',0)->get();
                $datas = DB::table('sap_checklist')
                    ->rightjoin('qc_forms', 'qc_forms.form_id', '=', 'sap_checklist.form_id')
                    ->where('sap_checklist.sap_dispatch', 0)
                    ->where('qc_forms.dispatch_status', 1)
                    ->where('qc_forms.is_deleted', 0)
                    ->get();

                break;
        }



        return count($datas);
    }

    public static function getPurcahseStockRecivedOrder($form_id)
    {
        $purdatas = QC_BOM_Purchase::where('form_id', $form_id)->get();
        $pcount = count($purdatas);
        $tq = 7 * $pcount;


        $i = 0;
        foreach ($purdatas as $key => $Row) {
            $s = $Row->status;
            $i += $s;
        }

        if ($i == $tq) {
            return 2;
        } else {
            return 1;
        }
    }
    public static function getOperationalHealth()
    {
        $data = DB::table('h_operation')->get();
        return $data;
    }
    public static function getPlanOpertionCat()
    {
        $data = DB::table('plan_type_category')->get();
        return $data;
    }
    public static function getPlanOpertionCatID($id)
    {
        $data = DB::table('plan_type_category')->where('id', $id)->first();
        return $data;
    }

    public static function getOperationalHealthBYid($id)
    {
        $data = DB::table('h_operation')->where('id', $id)->first();
        return $data;
    }
    public static function getBulkITEMName($form_id)
    {
        $mydatas = DB::table('qc_bulk_order_form')->where('form_id', $form_id)->get();
        $name = "";
        foreach ($mydatas as $key => $Row) {
            if (isset($Row->item_name)) {
                $name .= $Row->item_name . ",";
            }
        }
        return $name;
    }
    public static function getSAP_CHECKLISTData($form_id)
    {
        $data = SAP_CHECKLISt::where('form_id', $form_id)->first();
        return $data;
    }
    public static function getSAP_CHECKLISTDataINNER($form_id)
    {
        $data = SAP_CHECKLISt::where('form_id', $form_id)->first();
        return $data;
    }
    public static function OrderStageCompletedByUserList()
    {
        $data_arr = OrderMaster::distinct('assigned_by')->get(['assigned_by']);
        $userData = array();
        foreach ($data_arr as $key => $value_data) {

            $userData[] = array(
                'user_id' => $value_data->assigned_by,
                'user_name' => AyraHelp::getUser($value_data->assigned_by)->name
            );
        }
        return $userData;
    }

    public static function getPlanID()
    {

        $qcdata_arrs = DB::table('h_plan_day')->max('id') + 1;


        return $qcdata_arrs;
    }
    public static function getAllUser()
    {

        $qcdata_arrs = DB::table('users')->where('is_deleted', 0)->get();


        return $qcdata_arrs;
    }



    public static function getBULKCount($form_id)
    {
        $data = QCBULK_ORDER::where('form_id', $form_id)->whereNotNull('item_name')->count();
        return $data;
    }
    public static function getBULKData($form_id)
    {
        $data = QCBULK_ORDER::where('form_id', $form_id)->whereNotNull('item_name')->get();
        return $data;
    }



    public static function getOrderStageCompletedCountDataV1($days, $step_code)
    {

        $chartDatas = OrderMasterV1::select([
            DB::raw('DATE(completed_on) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('completed_on', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('stage_id', $step_code)
            ->where('process_id', 1)
            ->where('action_status', 1)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }




    public static function getLeadStageCompletedCountData($days, $step_code)
    {

        $chartDatas = LeadDataProcess::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('stage_id', $step_code)
            ->where('action_on', 1)

            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }


    public static function getOrderStageCompletedCountData($days, $step_code)
    {

        $chartDatas = OrderMaster::select([
            DB::raw('DATE(completed_on) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('completed_on', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('order_statge_id', $step_code)
            ->where('action_status', 1)

            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }
    public static function getINGBrands()
    {


        $brands = DB::table('rnd_brands')->get();
        return $brands;
    }
    public static function getINGBrandByID($id)
    {


        $brands = DB::table('rnd_brands')->where('id', $id)->first();
        return $brands;
    }

    public static function getOrderStageCompletedCount($active_date, $step_code)
    {


        $qc_data = array();
        $qc_data = OrderMaster::where('order_statge_id', $step_code)->where('action_status', 1)->whereDate('completed_on', $active_date)->count();
        return $qc_data;
    }
    public static function getOrderStageCompletedCountV1($active_date, $step_code)
    {


        $qc_data = array();
        $qc_data = OrderMasterV1::where('stage_id', $step_code)->where('action_status', 1)->whereDate('completed_on', $active_date)->count();
        return $qc_data;
    }




    public static function getLeadStageCompletedCountAjax($active_date, $stage_id, $user_id)
    {
        $process_data_1 = array();
        if ($user_id == 'ALL') {
            $process_data_1 = DB::table('st_process_action_4')->where('action_on', 1)->where('stage_id', $stage_id)->whereDate('created_at', $active_date)->count();
        } else {
            $process_data_1 = DB::table('st_process_action_4')->where('action_on', 1)->where('stage_id', $stage_id)->whereDate('created_at', $active_date)->where('completed_by', $user_id)->count();
        }

        //$qc_data=OrderMaster::where('order_statge_id',$step_code)->where('assigned_by',$user_id)->where('action_status',1)->whereDate('completed_on', $active_date)->get();
        return $process_data_1;
    }



    public static function getOrderStageCompletedCountAjax($active_date, $step_code, $user_id)
    {


        $qc_data = array();
        $qc_data = OrderMaster::where('order_statge_id', $step_code)->where('assigned_by', $user_id)->where('action_status', 1)->whereDate('completed_on', $active_date)->count();
        return $qc_data;
    }


    public static function getUserCompletedStage($step_id, $filter_with)
    {

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
        return $mydata;
    }

    // getMangers
    public static function getMangers()
    {

        $countData = Category::get();
        return $countData;
    }
    // getMangers


    public static function getUserCompletedStage_OK($step_id, $filter_with)
    {




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




        //$allUsers=User::get();
        $allUsers = AyraHelp::getSalesAgentAdmin();

        $mydata = array();
        foreach ($allUsers as $key => $user) {

            $countData = OPData::where('created_by', $user->id)->where('step_id', $step_id)->where('status', 1)->whereDate('created_at', $filterWithDays)->get();
            $countDataTC = OPData::where('created_by', $user->id)->where('step_id', $step_id)->where('status', 1)->whereDate('created_at', $filterWithDays)->count();

            $mydata[] = array(
                'name' => $user->name,
                'count' => $countDataTC

            );
        }
        return $mydata;
    }

    public static function getOrderByFormID($formid)
    {
        $qc_data = QCFORM::where('form_id', $formid)->first();
        return $qc_data;
    }
    public static function getOrderValueFilterByUser($m_digit, $userid)
    {


        if ($m_digit >= date('m') + 1) {
            $ydigit = "2022";
        } else {
            $ydigit = "2023";
        }
        $qc_data = array();

        $qc_data = QCFORM::where('is_deleted', 0)->where('created_by', $userid)->whereMonth('created_at', $m_digit)->whereYear('created_at', $ydigit)->get();







        $me = array();
        foreach ($qc_data as $key => $row) {
            if (isset($row->qc_from_bulk)) {
                if ($row->qc_from_bulk == 1) {
                    $me[] = $row->bulk_order_value;
                } else {
                    $me[] = ($row->item_sp) * ($row->item_qty);
                }
            } else {
                $me[] = ($row->item_sp) * ($row->item_qty);
            }
        }


        $amount =  array_sum($me);
        // setlocale(LC_MONETARY, 'en_IN');
        // $amount = money_format('%!i', $amount);
        return $amount;
    }
    //getFreshLeadValueBySlabFilterRemain

    public static function getFreshLeadValueBySlabFilterRemain($m_digit, $year_digit)
    {

        // if($m_digit>1){
        //     $year_digit = "2020";
        // }else{
        //     $year_digit = "2021";
        // }
        $me = array();
        $amount = 0;
        $incentiveVal = 0;
        $qc_data = array();

        $qc_data = DB::table('indmt_data')->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->count();


        return $qc_data;
    }

    //getFreshLeadValueBySlabFilterRemain

    //getIncentiveValueBySlabFilterByUser
    public static function getIncentiveValueBySlabFilterByUser($m_digit)
    {
        //$year_digit = "2020";
        if ($m_digit > date('m')) {
            $year_digit = "2022";
        } else {
            $year_digit = "2023";
        }

        $me = array();
        $amount = 0;
        $incentiveVal = 0;
        $qc_data = array();

        $qc_data = DB::table('payment_recieved_from_client')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('payment_status', 1)->whereMonth('recieved_on', $m_digit)->whereYear('recieved_on', $year_digit)->get();
        foreach ($qc_data as $key => $row) {
            $me[] = $row->rec_amount;
        }
        $oderVaL = array_sum($me);
        $oderVaLA = ($oderVaL * 83.5) / 100;

        $data_ArrInc = AyraHelp::getPayoutDetailByAmount($oderVaLA, 1);

        if ($data_ArrInc == null) {
            $incentiveVal = 0;
        } else {
            $incentiveVal = ($oderVaLA * $data_ArrInc->payout_percentage) / 100;
        }

        return $incentiveVal;
    }

    //getIncentiveValueBySlabFilterByUser

    //getOrderValuePaymentRecFilterByUser
    public static function getOrderValuePaymentRecFilterByUser($m_digit)
    {
        if ($m_digit > date('m')) {
            $year_digit = "2022";
        } else {
            $year_digit = "2023";
        }

        $me = array();
        $qc_data = array();

        $qc_data = DB::table('payment_recieved_from_client')->where('created_by', Auth::user()->id)->where('is_deleted', 0)->where('payment_status', 1)->whereMonth('recieved_on', $m_digit)->whereYear('recieved_on', $year_digit)->get();
        foreach ($qc_data as $key => $row) {
            $me[] = $row->rec_amount;
        }
        return array_sum($me);
    }
    //getOrderValuePaymentRecFilterByUser
    //getOrderValuePuchRecFilter
    public static function getOrderValuePuchRecFilter($m_digit, $year_digit)
    {
        if ($m_digit >= date('m') + 1) {

            $year_digit = "2022";
        } else {
            $year_digit = "2023";
        }

        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        $qc_data = array();
        if ($user_role == 'Admin' || $user_role == 'SalesHead') {
            $qc_data = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
        }
        if ($user_role == 'SalesUser') {
            $qc_data = QCFORM::where('is_deleted', 0)->where('created_by', Auth::user()->id)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
        }




        $me = array();
        foreach ($qc_data as $key => $row) {
            if (isset($row->qc_from_bulk)) {
                if ($row->qc_from_bulk == 1) {
                    $me[] = $row->bulk_order_value;
                } else {
                    $me[] = ($row->item_sp) * ($row->item_qty);
                }
            } else {
                $me[] = ($row->item_sp) * ($row->item_qty);
            }
        }


        return array_sum($me);
    }

    //getOrderValuePuchRecFilter
//getOrderValuePaymentRecFilterBULK
public static function getOrderValuePaymentRecFilterBULK($m_digit, $year_digit)
{
    //    echo $m_digit."-";
    //    echo $year_digit;
    //    echo "<br>==";

    // if($m_digit>=4){
    //     $year_digit = "2020";
    // }else{
    //     $year_digit = "2021";
    // }

    $me = array();
    $qc_data = array();
    // DB::enableQueryLog();
    $qc_data = DB::table('qc_forms')->where('is_deleted', 0)->where('order_type','Bulk')->where('account_approval', 1)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
    //  dd(DB::getQueryLog());
    foreach ($qc_data as $key => $row) {
        $me[] = $row->bulk_order_value;
    }
    return array_sum($me);
}

//getOrderValuePaymentRecFilterBULK


//getOrderValuePaymentRecFilterPL
public static function getOrderValuePaymentRecFilterPL($m_digit, $year_digit)
{
    //    echo $m_digit."-";
    //    echo $year_digit;
    //    echo "<br>==";

    // if($m_digit>=4){
    //     $year_digit = "2020";
    // }else{
    //     $year_digit = "2021";
    // }

    $me = array();
    $qc_data = array();
    // DB::enableQueryLog();
    $qc_data = DB::table('qc_forms')->where('is_deleted', 0)->where('order_type','Private Label')->where('account_approval', 1)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
    //  dd(DB::getQueryLog());
    foreach ($qc_data as $key => $row) {
        $me[] = $row->bulk_order_value;
    }
    return array_sum($me);
}

//getOrderValuePaymentRecFilterPL

    //getOrderValuePaymentRecFilter
    public static function getOrderValuePaymentRecFilter($m_digit, $year_digit)
    {
        //    echo $m_digit."-";
        //    echo $year_digit;
        //    echo "<br>==";

        // if($m_digit>=4){
        //     $year_digit = "2020";
        // }else{
        //     $year_digit = "2021";
        // }

        $me = array();
        $qc_data = array();
        // DB::enableQueryLog();
        $qc_data = DB::table('payment_recieved_from_client')->where('is_deleted', 0)->where('payment_status', 1)->whereMonth('recieved_on', $m_digit)->whereYear('recieved_on', $year_digit)->get();
        //  dd(DB::getQueryLog());
        foreach ($qc_data as $key => $row) {
            $me[] = $row->rec_amount;
        }
        return array_sum($me);
    }
    //getOrderValuePaymentRecFilter

    //getOrderApprovedDetailIncentive
    public static function getOrderApprovedDetailIncentive($uid, $month, $year)
    {
        $orderArr = DB::table('qc_forms')
            ->where('created_by', $uid)
            ->where('is_deleted', 0)
            ->where('account_approval', 1)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderby('form_id', 'desc')
            ->get();
        return $orderArr;
    }
    //getOrderApprovedDetailIncentive

    public static function getOrderValueFilter($m_digit)
    {


        if ($m_digit >= date('m') + 1) {

            $year_digit = "2022";
        } else {
            $year_digit = "2023";
        }

        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        $qc_data = array();
        if ($user_role == 'Admin' || $user_role == 'SalesHead') {
            $qc_data = QCFORM::where('is_deleted', 0)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
        }
        if ($user_role == 'SalesUser') {
            $qc_data = QCFORM::where('is_deleted', 0)->where('created_by', Auth::user()->id)->whereMonth('created_at', $m_digit)->whereYear('created_at', $year_digit)->get();
        }




        $me = array();
        foreach ($qc_data as $key => $row) {
            if (isset($row->qc_from_bulk)) {
                if ($row->qc_from_bulk == 1) {
                    $me[] = $row->bulk_order_value;
                } else {
                    $me[] = ($row->item_sp) * ($row->item_qty);
                }
            } else {
                $me[] = ($row->item_sp) * ($row->item_qty);
            }
        }

        return array_sum($me);
    }


    public static function getFeedbackDataByUser($user_id, $m, $y)
    {
        if ($m == 'ALL') {

            $users_1 = DB::table('samples')->where('created_by', $user_id)->where('yr', $y)->where('sample_feedback', '=', 1)->count();
            $users_2 = DB::table('samples')->where('created_by', $user_id)->where('yr', $y)->where('sample_feedback', '=', 2)->count();
            $users_3 = DB::table('samples')->where('created_by', $user_id)->where('yr', $y)->where('sample_feedback', '=', 3)->count();
            $users_4 = DB::table('samples')->where('created_by', $user_id)->where('yr', $y)->where('sample_feedback', '=', 4)->count();


            $datafeed_ar = array(
                'feed_1' => $users_1,
                'feed_2' => $users_2,
                'feed_3' => $users_3,
                'feed_4' => $users_4,
            );
            return $datafeed_ar;
        } else {
            $time = strtotime($m);
            $m = date("m", $time);
            $users_1 = DB::table('samples')->where('created_by', $user_id)->where('mo', $m)->where('yr', $y)->where('sample_feedback', '=', 1)->count();
            $users_2 = DB::table('samples')->where('created_by', $user_id)->where('mo', $m)->where('yr', $y)->where('sample_feedback', '=', 2)->count();
            $users_3 = DB::table('samples')->where('created_by', $user_id)->where('mo', $m)->where('yr', $y)->where('sample_feedback', '=', 3)->count();
            $users_4 = DB::table('samples')->where('created_by', $user_id)->where('mo', $m)->where('yr', $y)->where('sample_feedback', '=', 4)->count();


            $datafeed_ar = array(
                'feed_1' => $users_1,
                'feed_2' => $users_2,
                'feed_3' => $users_3,
                'feed_4' => $users_4,
            );
            return $datafeed_ar;
        }
    }


    public static function getFeedbackData()
    {

        $users_1 = DB::table('samples')->where('sample_feedback', '=', 1)->count();
        $users_2 = DB::table('samples')->where('sample_feedback', '=', 2)->count();
        $users_3 = DB::table('samples')->where('sample_feedback', '=', 3)->count();
        $users_4 = DB::table('samples')->where('sample_feedback', '=', 4)->count();


        $datafeed_ar = array(
            'feed_1' => $users_1,
            'feed_2' => $users_2,
            'feed_3' => $users_3,
            'feed_4' => $users_4,
        );
        return $datafeed_ar;
    }

    public static function LastUpdateAtStageNew()
    {
        $data = OrderStageCountNew::first();
        $today = date('Y-m-d H:i:s');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->update_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $today);
        $diff_in_days = $to->diffForHumans($from);
        return $diff_in_days . " at:" . date("h:i:s", strtotime($data->update_at));
    }


    public static function LastUpdateAtStage()
    {
        $data = OrderStageCount::first();
        $today = date('Y-m-d H:i:s');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->update_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $today);
        $diff_in_days = $to->diffForHumans($from);
        return $diff_in_days . " at:" . date("h:i:s", strtotime($data->update_at));
    }

    public static function setOrderStagesForApiYestarday()
    {
    }

    public static function getOrderStagesDelayAPIV1()
    {
        //this api is used to make green and red database with order_stages_countNew

        $arr_data = DB::table('st_process_action')
            ->where('st_process_action.action_status', 0)
            ->select('st_process_action.*')
            ->get();

        foreach ($arr_data as $key => $rowdata) {
            $rowid = $rowdata->id;
            $Date = $rowdata->created_at;
            $stage_id =  $rowdata->stage_id;
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
    public static function setOrderStagesForApiV1()
    {
        //-------------------------------------------
        $step_data_arr = DB::table('st_process_stages')->where('process_id', 1)->get();
        foreach ($step_data_arr as $key => $row) {
            $stage_id = $row->stage_id;
            $stepcode_insert = $row->access_code;
            $stage_name_insert = $row->stage_name;
            $days_to_done = $row->days_to_done;
            //adding data to database
            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->select('qc_forms.*')
                ->get();

            $j = 0;
            foreach ($qc_data as $key => $row) {

                $qc_dataRed = DB::table('st_process_action')
                    ->where('st_process_action.ticket_id', $row->form_id)
                    ->where('st_process_action.stage_id', $stage_id)
                    ->where('st_process_action.action_status', 0)
                    ->where('st_process_action.action_on', 1)
                    ->where('st_process_action.action_mark', 0)
                    ->select('st_process_action.*')
                    ->get();
                $j = $j + count($qc_dataRed);
            }
            $arr_data_green = $j;


            $k = 0;
            foreach ($qc_data as $key => $row) {

                $qc_dataRed = DB::table('st_process_action')
                    ->where('st_process_action.ticket_id', $row->form_id)
                    ->where('st_process_action.stage_id', $stage_id)
                    ->where('st_process_action.action_status', 0)
                    ->where('st_process_action.action_on', 1)
                    ->where('st_process_action.action_mark', 1)
                    ->select('st_process_action.*')
                    ->get();
                $k = $k + count($qc_dataRed);
            }
            $arr_data_red = $k;


            $flight = OrderStageCountNew::updateOrCreate(
                ['stage_id' => $stepcode_insert],
                [
                    'stage_id' => $stepcode_insert,
                    'stage_name' => $stage_name_insert,
                    //'stage_name' => $stage_name_insert,
                    'red_count' => $arr_data_red,
                    'green_count' => $arr_data_green,
                    'update_at' => date('Y-m-d H:i:s')
                ]
            );

            //adding data to database
        }

        //-------------------------------------------
    }
    public static function setOrderStagesForApi()
    {
        $step_data_arr = OPDays::get();
        foreach ($step_data_arr as $key => $row) {
            $stage_id = $row->order_step;
            $stepcode_insert = $row->step_code;
            $stage_name_insert = $row->process_name;

            $data_out = OPDays::where('order_step', $stage_id)->first();
            $daystoDone = $data_out->process_days;
            $today = date('Y-m-d H:i:s');
            //=======code for update color in order master============
            $arr_datas = DB::table('order_master')
                ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
                ->where('order_master.order_statge_id', $data_out->step_code)
                ->where('order_master.action_status', 0)
                ->where('qc_forms.is_deleted', 0)
                ->select('order_master.*')
                ->get();



            foreach ($arr_datas as $key => $arr_data) {
                $to = Carbon::createFromFormat('Y-m-d H:i:s', $arr_data->expected_date);
                $from = Carbon::createFromFormat('Y-m-d H:i:s', $today);
                $diff_in_days = $from->diffInDays($to);
                $date = new Carbon;
                if ($date > $arr_data->expected_date) {
                    OrderMaster::where('form_id', $arr_data->form_id)
                        ->update(['action_mark' => 0]); //red
                } else {
                    OrderMaster::where('form_id', $arr_data->form_id)
                        ->update(['action_mark' => 1]); //green

                }
            }

            //=======code for update color in order master===stop=========
            //=======code for update order stages===start=========
            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->select('qc_forms.*')
                ->get();

            $j = 0;
            foreach ($qc_data as $key => $row) {

                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 1)
                    ->select('order_master.*')
                    ->get();
                $j = $j + count($qc_dataRed);
            }

            $arr_data_green = $j;

            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->select('qc_forms.*')
                ->get();
            $i = 0;
            foreach ($qc_data as $key => $row) {

                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 0)
                    ->select('order_master.*')
                    ->get();
                $i = $i + count($qc_dataRed);
            }
            $arr_data_red = $i;


            //=======code for update order stages===stop=========

            //update or insert
            //  DB::table('order_stages_count')
            //  ->updateOrInsert(
            //      [
            //          'stage_id' => $stepcode_insert,
            //          'red_count' => $arr_data_red,
            //          'green_count' => $arr_data_green,
            //          'update_at' => date('Y-m-d H:i:s')
            //      ],
            //      ['stage_id' => $stepcode_insert]
            //  );

            $flight = OrderStageCount::updateOrCreate(
                ['stage_id' => $stepcode_insert],
                [
                    'stage_id' => $stepcode_insert,
                    'stage_name' => $stage_name_insert,
                    'red_count' => $arr_data_red,
                    'green_count' => $arr_data_green,
                    'update_at' => date('Y-m-d H:i:s')
                ]
            );
            //update or insert



        }

        //update for purchase
        $qcdata_arrs = DB::table('qc_bo_purchaselist')->where('is_deleted', 0)->where('dispatch_status', 1)->distinct()->get(['form_id']);
        $iaj = 0;
        foreach ($qcdata_arrs as $key => $qcdata_arr) {
            $data = AyraHelp::checkPurchaeStageIsDone($qcdata_arr->form_id);
            if (!$data) {
                $iaj++;
            }
        }

        OrderStageCount::where('stage_id', 'PURCHASE_PM')
            ->update(['red_count' => $iaj]);
        //update for purchase
    }

    public static function UpdatedByUpdatedOnOrderMaster($form_id)
    {
        OrderMaster::where('form_id', $form_id)
            ->update(['update_by' => Auth::user()->id, 'update_on' => date('Y-m-d H:i:s')]); //green

    }


    public static function getOrderStuckStatusByStageV1($stage_id)
    {
        $mydata_arr = OrderStageCountNew::where('id', $stage_id)->first();
        return $mydata_arr;
    }


    public static function getOrderStuckStatusByStage($stage_id)
    {
        $mydata_arr = OrderStageCount::where('id', $stage_id)->first();
        return $mydata_arr;
    }
    public static function getOrderStuckStatusByStageYestarday($stage_id)
    {
        $data_outData = OPDays::where('order_step', $stage_id)->first();
        $daystoDone = $data_outData->process_days;
        $stepCode = $data_outData->step_code;

        $yesterday = date("Y-m-d", strtotime('-1 days'));
        $data_out = OPData::where('status', 1)->whereDate('created_at', $yesterday)->get();
        $i = 0;
        foreach ($data_out as $key => $RowData) {
            $form_id = $RowData->order_id_form_id;
            $data_arr = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $stepCode)->where('action_status', 1)->first();
            if ($data_arr !== null) {
                $i++;
            }
        }


        $data = array(
            'stage_name' => $data_outData->process_name,
            'green_count' => $i,
            'red_count' => 0

        );
        return (object) $data;
    }


    public static function getOrderStuckStatusByStageOLD($stage_id)
    {

        $data_out = OPDays::where('order_step', $stage_id)->first();
        $daystoDone = $data_out->process_days;

        //code for red and green status
        $today = date('Y-m-d H:i:s');
        //$today='2019-10-2 10:10:10';
        // $arr_datas=OrderMaster::where('order_statge_id',$data_out->step_code)->where('action_status',0)->get();

        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff') {
            $arr_datas = DB::table('order_master')
                ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
                ->where('order_master.order_statge_id', $data_out->step_code)
                ->where('order_master.action_status', 0)
                ->where('qc_forms.is_deleted', 0)

                ->select('order_master.*')
                ->get();
        } else {
            $arr_datas = DB::table('order_master')
                ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
                ->where('order_master.order_statge_id', $data_out->step_code)
                ->where('order_master.action_status', 0)
                ->where('qc_forms.is_deleted', 0)

                ->where('qc_forms.created_by', Auth::user()->id)
                ->select('order_master.*')
                ->get();
        }

        foreach ($arr_datas as $key => $arr_data) {

            $to = Carbon::createFromFormat('Y-m-d H:i:s', $arr_data->expected_date);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $today);
            $diff_in_days = $from->diffInDays($to);

            $date = new Carbon;
            if ($date > $arr_data->expected_date) {
                OrderMaster::where('form_id', $arr_data->form_id)
                    ->update(['action_mark' => 0]); //red
            } else {
                OrderMaster::where('form_id', $arr_data->form_id)
                    ->update(['action_mark' => 1]); //green

            }
        }

        //code for red and green status

        if ($user_role == 'Admin' || $user_role == 'Staff') {

            // $arr_data_green = DB::table('order_master')
            // ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
            // ->where('order_master.order_statge_id',$data_out->step_code)
            // ->where('order_master.action_status',0)
            // ->where('order_master.action_mark',1)
            // ->where('qc_forms.is_deleted',0)
            // ->select('order_master.*')
            // ->get();

            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->select('qc_forms.*')
                ->get();

            //$posts = Post::all();
            //Redis::set('posts.all', $posts);

            $j = 0;
            foreach ($qc_data as $key => $row) {


                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 1)
                    ->select('order_master.*')
                    ->get();
                $j = $j + count($qc_dataRed);
            }

            $arr_data_green = $j;


            // $arr_data_red = DB::table('order_master')
            // ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
            // ->where('order_master.order_statge_id',$data_out->step_code)
            // ->where('order_master.action_status',0)
            // ->where('order_master.action_mark',0)
            // ->where('qc_forms.is_deleted',0)

            // ->select('order_master.*')
            // ->get();

            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->select('qc_forms.*')
                ->get();
            $i = 0;
            foreach ($qc_data as $key => $row) {


                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 0)
                    ->select('order_master.*')
                    ->get();
                $i = $i + count($qc_dataRed);
            }
            $arr_data_red = $i;
        } else {



            /*
        $arr_data_red = DB::table('order_master')
        ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
        ->where('order_master.order_statge_id',$data_out->step_code)
        ->where('order_master.action_status',0)
        ->where('order_master.action_mark',0)
        ->where('qc_forms.is_deleted',0)

        ->where('qc_forms.created_by',Auth::user()->id)
        ->select('order_master.*')
        ->get();

             $arr_data_green = DB::table('order_master')
            ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
            ->where('order_master.order_statge_id',$data_out->step_code)
            ->where('order_master.action_status',0)
            ->where('order_master.action_mark',1)
            ->where('qc_forms.is_deleted',0)

            ->where('qc_forms.created_by',Auth::user()->id)
            ->select('order_master.*')
            ->get();
            */
            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->where('qc_forms.created_by', Auth::user()->id)
                ->select('qc_forms.*')
                ->get();
            $j = 0;
            foreach ($qc_data as $key => $row) {


                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 1)
                    ->select('order_master.*')
                    ->get();
                $j = $j + count($qc_dataRed);
            }

            $arr_data_green = $j;

            $qc_data = DB::table('qc_forms')
                ->where('qc_forms.is_deleted', 0)
                ->where('qc_forms.dispatch_status', 1)
                ->where('qc_forms.created_by', Auth::user()->id)
                ->select('qc_forms.*')
                ->get();
            $i = 0;
            foreach ($qc_data as $key => $row) {


                $qc_dataRed = DB::table('order_master')
                    ->where('order_master.form_id', $row->form_id)
                    ->where('order_master.order_statge_id', $data_out->step_code)
                    ->where('order_master.action_status', 0)
                    ->where('order_master.action_mark', 0)
                    ->select('order_master.*')
                    ->get();
                $i = $i + count($qc_dataRed);
            }
            $arr_data_red = $i;
        }


        // $arr_data_green=OrderMaster::where('order_statge_id',$data_out->step_code)->where('action_status',0)->where('action_mark',1)->get();
        //$arr_data_red=OrderMaster::where('order_statge_id',$data_out->step_code)->where('action_status',0)->where('action_mark',0)->get();


        $mydatra = array(
            'statge_name' => optional($data_out)->process_name,
            'step_code' => optional($data_out)->step_code,
            'green_count' => $arr_data_green,
            'red_count' => $arr_data_red

        );


        return $mydatra;
    }
    public static function checkOrderMasterDataDuplicte($form_id, $stepCode)
    {
        $orderdata = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $stepCode)->where('action_status', 1)->first();

        if ($orderdata == null) {
            return 0; //ok can insert
        } else {
            return 1; //no can not insert alreay have
        }
    }
    //public 

    public static function updateSamplesItem($user_id)
    {
        $sample_arr = DB::table('sample_items')
            ->join('samples', 'sample_items.sid', '=', 'samples.id')
            ->select('sample_items.*', 'samples.is_formulated as isformulated', 'samples.sample_code as samplecode')
            ->where('samples.is_deleted', 0)
            ->where('samples.sample_stage_id', '>', 2)
            ->where('samples.sample_type', '!=', 2)
            ->where('sample_items.sample_type', '!=', 2)
            ->whereNull('sample_items.sid_partby_code')
            // ->where('samples.created_by',$user_id)
            ->get();
        foreach ($sample_arr as $key => $rowData) {
            $s_code = $rowData->samplecode;

            $affected = DB::table('sample_items')
                ->where('id', $rowData->id)
                ->update(['sid_partby_code' => $s_code]);
        }
    }
    public static function updateSamplesItem_OIL($user_id)
    {
        $sample_arr = DB::table('sample_items')
            ->join('samples', 'sample_items.sid', '=', 'samples.id')
            ->select('sample_items.*', 'samples.is_formulated as isformulated', 'samples.sample_code as samplecode')
            ->where('samples.is_deleted', 0)
            // ->where('samples.sample_stage_id','>',2)
            ->where('samples.sample_type', '=', 2)
            ->where('sample_items.sample_type', '=', 2)
            ->whereNull('sample_items.sid_partby_code')
            // ->where('samples.created_by',$user_id)
            ->get();
        foreach ($sample_arr as $key => $rowData) {
            $s_code = $rowData->samplecode;

            $affected = DB::table('sample_items')
                ->where('id', $rowData->id)
                ->update(['sid_partby_code' => $s_code]);
        }
    }
    //updateSamplesItem_Delete

    //updateSamplesOnlineSampleToItem
    public static function updateSamplesOnlineSampleToItem($user_id)
    {
        $sampleArr = DB::table('samples')
            ->where('created_by', 4)
            ->whereNotNull('on_client_id')
            ->get();
        foreach ($sampleArr as $key => $rowData) {

            $dataJArr = json_decode($rowData->sample_details);
            foreach ($dataJArr as $key => $row) {

                $itemName = $row->txtItem;
                $item_info = $row->txtDiscrption;
                $sample_type = $row->sample_type;
                $price_per_kg = $row->price_per_kg;


                DB::table('sample_items')
                    ->updateOrInsert(
                        ['sid' => $rowData->id, 'sample_type' => $sample_type, 'item_name' => $itemName],
                        [
                            'item_info' => $item_info,
                            'item_info' => $item_info,
                            'sid_partby_code' => $rowData->sample_code,
                            'price_per_kg' => $price_per_kg

                        ]
                    );
            }
        }
    }
    //updateSamplesOnlineSampleToItem


    public static function updateSamplesItem_Delete($user_id)
    {

        $sample_arr = DB::table('samples')->select('id')->where('created_by', $user_id)->where('is_deleted', 1)->get();
        foreach ($sample_arr as $key => $rowData) {
            $affected = DB::table('sample_items')
                ->where('sid', $rowData->id)
                ->update(['is_deleted' => 1]);
        }
    }

    //public 
    public static function PurchaseStageCount($step_id, $puriD)
    {

        if ($step_id == 2) {
        } else {

            $data_arr = DB::table('qc_forms')
                ->join('qc_bo_purchaselist', 'qc_forms.form_id', '=', 'qc_bo_purchaselist.form_id')
                ->select('qc_bo_purchaselist.*')
                ->where('qc_forms.dispatch_status', '!=', 0)
                ->where('qc_forms.is_deleted', '=', 0)
                ->where('qc_bo_purchaselist.status', $step_id)->where('qc_bo_purchaselist.is_deleted', 0)->where('qc_bo_purchaselist.dispatch_status', 1)->count();


            //$data_arr = QC_BOM_Purchase::where('status', $step_id)->where('is_deleted', 0)->where('dispatch_status', 1)->count();
            return $data_arr;
        }
    }
    public static function ScriptForPurchaseListReady()
    {
        //QC_BOM_Purchase
        $qc_data = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->where('artwork_status', 1)->get();
        foreach ($qc_data as $key => $row) {

            $bom_data = QCBOM::where('form_id', $row->form_id)->get();

            foreach ($bom_data as $bomkey => $bomRow) {

                if ($bomRow->bom_from == 'N/A' || $bomRow->bom_from == 'FromClient' || $bomRow->bom_from == 'From Client') {
                } else {
                    //print_r($bomRow->m_name);
                    if (!empty($bomRow->m_name)) {
                        $pu_data = QC_BOM_Purchase::where('form_id', $row->form_id)->where('material_name', $bomRow->m_name)->first();
                        if ($pu_data == null) {
                            $bompObj = new QC_BOM_Purchase;
                            $bompObj->order_no = 3;
                            $bompObj->order_id = $row->order_id;
                            $bompObj->sub_order_index = $row->subOrder;
                            $bompObj->order_name = optional($row)->brand_name;
                            $bompObj->order_cat = optional($bomRow)->bom_cat;
                            $bompObj->material_name = optional($bomRow)->m_name;
                            $bompObj->qty = optional($bomRow)->qty;
                            $bompObj->created_by = optional($row)->created_by;
                            $bompObj->form_id = optional($row)->form_id;
                            $bompObj->dispatch_status = 1;
                            $bompObj->created_at = $row->created_at;
                            $bompObj->is_deleted = 0;
                            $bompObj->save();
                        }
                    }
                }
            }
        }
        //update status with backup
        $pur_dataBKP = DB::table('qc_bo_purchaselist_BKP')->get();
        foreach ($pur_dataBKP as $keybp => $rowbkp) {
            $pu_databkp = QC_BOM_Purchase::where('form_id', $rowbkp->form_id)->where('material_name', $rowbkp->material_name)->first();
            if ($pu_databkp != null) {

                // QC_BOM_Purchase::where('form_id', $rowbkp->form_id)
                // ->where('material_name', $rowbkp->material_name)
                // ->update(['status' => $rowbkp->status]);

            }
        }
    }

    public static function ScriptForStartDefaultNEW()
    {
        $qc_datas = QCFORM::where('is_deleted', 0)->where('dispatch_status', 1)->get();
        $i = 0;
        $c_code = 'completed';
        $diff_data = '1 second after';
        foreach ($qc_datas as $key => $qc_data) {
            if ($qc_data->order_type == 'Bulk') {

                $opdObj = new OPData;
                $opdObj->order_id_form_id = $qc_data->form_id; //formid and order id
                $opdObj->step_id = 1;
                $opdObj->expected_date = date('Y-m-d');
                $opdObj->remaks = 'auto start by script';
                $opdObj->created_by = $qc_data->created_by;
                $opdObj->assign_userid = 0;
                $opdObj->status = 1;
                $opdObj->step_status = 0;
                $opdObj->color_code = $c_code;
                $opdObj->diff_data = $diff_data;
                $opdObj->save();

                //ordermaster
                $mstOrderObj = new OrderMaster;
                $mstOrderObj->form_id = $qc_data->form_id;
                $mstOrderObj->assign_userid = 0;
                $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
                $mstOrderObj->assigned_by = $qc_data->created_by;
                $mstOrderObj->assigned_on = date('Y-m-d');
                $mstOrderObj->expected_date = date('Y-m-d');
                $mstOrderObj->action_status = 1;
                $mstOrderObj->completed_on = date('Y-m-d');
                $mstOrderObj->action_mark = 1;
                $mstOrderObj->assigned_team = 2; //sales user
                $mstOrderObj->save();

                $mstOrderObj = new OrderMaster;
                $mstOrderObj->form_id = $qc_data->form_id;
                $mstOrderObj->assign_userid = 0;
                $mstOrderObj->order_statge_id = 'PRODUCTION';
                $mstOrderObj->assigned_by = $qc_data->created_by;
                $mstOrderObj->assigned_on = date('Y-m-d');
                $mstOrderObj->expected_date = date('Y-m-d');
                $mstOrderObj->action_status = 0;
                $mstOrderObj->completed_on = date('Y-m-d');
                $mstOrderObj->action_mark = 1;
                $mstOrderObj->assigned_team = 2; //sales user
                $mstOrderObj->save();
                //ordermaster

            } else {
                if ($qc_data->order_repeat == 1) {
                    //ordermaster
                    $mstOrderObj = new OrderMaster;
                    $mstOrderObj->form_id = $qc_data->form_id;
                    $mstOrderObj->assign_userid = 0;
                    $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
                    $mstOrderObj->assigned_by = $qc_data->created_by;
                    $mstOrderObj->assigned_on = date('Y-m-d');
                    $mstOrderObj->expected_date = date('Y-m-d');
                    $mstOrderObj->action_status = 0;
                    $mstOrderObj->completed_on = date('Y-m-d');
                    $mstOrderObj->action_mark = 1;
                    $mstOrderObj->assigned_team = 2; //sales user
                    $mstOrderObj->save();

                    //ordermaster

                }
                if ($qc_data->order_repeat == 2) {

                    $opdObj = new OPData;
                    $opdObj->order_id_form_id = $qc_data->form_id; //formid and order id
                    $opdObj->step_id = 1;
                    $opdObj->expected_date = date('Y-m-d');
                    $opdObj->remaks = 'auto start by script';
                    $opdObj->created_by = $qc_data->created_by;
                    $opdObj->assign_userid = 0;
                    $opdObj->status = 1;
                    $opdObj->step_status = 0;
                    $opdObj->color_code = $c_code;
                    $opdObj->diff_data = $diff_data;
                    $opdObj->save();

                    //ordermaster
                    $mstOrderObj = new OrderMaster;
                    $mstOrderObj->form_id = $qc_data->form_id;
                    $mstOrderObj->assign_userid = 0;
                    $mstOrderObj->order_statge_id = 'ART_WORK_RECIEVED';
                    $mstOrderObj->assigned_by = $qc_data->created_by;
                    $mstOrderObj->assigned_on = date('Y-m-d');
                    $mstOrderObj->expected_date = date('Y-m-d');
                    $mstOrderObj->action_status = 1;
                    $mstOrderObj->completed_on = date('Y-m-d');
                    $mstOrderObj->action_mark = 1;
                    $mstOrderObj->assigned_team = 2; //sales user
                    $mstOrderObj->save();

                    $mstOrderObj = new OrderMaster;
                    $mstOrderObj->form_id = $qc_data->form_id;
                    $mstOrderObj->assign_userid = 0;
                    $mstOrderObj->order_statge_id = 'PURCHASE_LABEL_BOX';
                    $mstOrderObj->assigned_by = $qc_data->created_by;
                    $mstOrderObj->assigned_on = date('Y-m-d');
                    $mstOrderObj->expected_date = date('Y-m-d');
                    $mstOrderObj->action_status = 0;
                    $mstOrderObj->completed_on = date('Y-m-d');
                    $mstOrderObj->action_mark = 1;
                    $mstOrderObj->assigned_team = 2; //sales user
                    $mstOrderObj->save();
                    //ordermaster


                }
            }
        }
        //end of foreach




    }
    public static function ScriptForStartDefault()
    {
        $qc_datas = QCFORM::get();
        foreach ($qc_datas as $key => $qc_data) {

            if ($qc_data->order_type == 'Bulk') {

                OrderMaster::where('form_id', $qc_data->form_id)->whereNotIn('order_statge_id', ['ART_WORK_RECIEVED', 'PRODUCTION'])->delete();
                OrderMaster::where('form_id', $qc_data->form_id)
                    ->where('order_statge_id', 'PRODUCTION')
                    ->update([
                        'action_status' => 0,
                    ]);
                OPData::where('order_id_form_id', $qc_data->form_id)->whereNotIn('step_id', [1])->delete();
            } else {
                if ($qc_data->order_repeat == 1) {
                    OrderMaster::where('form_id', $qc_data->form_id)->whereNotIn('order_statge_id', ['ART_WORK_RECIEVED'])->delete();
                    //OrderMaster::where('form_id',$qc_data->form_id)->delete();

                    OrderMaster::where('form_id', $qc_data->form_id)
                        ->where('order_statge_id', 'ART_WORK_RECIEVED')
                        ->update([
                            'action_status' => 0,
                        ]);
                    OPData::where('order_id_form_id', $qc_data->form_id)->delete();
                }
                if ($qc_data->order_repeat == 2) {
                    OrderMaster::where('form_id', $qc_data->form_id)->whereNotIn('order_statge_id', ['ART_WORK_RECIEVED', 'PURCHASE_LABEL_BOX'])->delete();
                    OrderMaster::where('form_id', $qc_data->form_id)
                        ->where('order_statge_id', 'PURCHASE_LABEL_BOX')
                        ->update([
                            'action_status' => 0,
                        ]);
                    OPData::where('order_id_form_id', $qc_data->form_id)->whereNotIn('step_id', [1])->delete();
                }
            }
        }
    }


    public static function completePreviousStageDone($form_id, $stepid)
    {

        $qc_data = AyraHelp::getQCFormDate($form_id);

        //  print_r($qc_data);
        if ($qc_data->order_type == 'Bulk') {
            // print_r($qc_data);
            $opd_arrs = OPDaysBulk::get();

            //===========================
            foreach ($opd_arrs as $key => $opd_arr) {

                if ($opd_arr->order_step <= $stepid) {

                    if ($opd_arr->order_step != 1) {
                        //insert in OPData
                        $checkOrderProcess = AyraHelp::checkOrderProcesDuplicte($form_id, $opd_arr->order_step);
                        if (!$checkOrderProcess) {

                            $mydata_arr = OPData::where('order_id_form_id', $form_id)->where('step_id', $opd_arr->order_step)->first();
                            if ($mydata_arr == null) {
                                $opdObj = new OPData;
                                $opdObj->order_id_form_id = $form_id; //formid and order id
                                $opdObj->step_id = $opd_arr->order_step;
                                $opdObj->expected_date = date('Y-m-d');
                                $opdObj->remaks = 'Auto Completed by with previous statges';
                                $opdObj->created_by = Auth::user()->id;
                                $opdObj->assign_userid = 0;
                                $opdObj->status = 1;
                                $opdObj->step_status = 0;
                                $opdObj->color_code = 'completed';
                                $opdObj->diff_data = '1 second after';
                                $opdObj->save();
                            }
                        }
                        //insert in OPData
                        //insert in OrderMaster
                        $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                        if (!$checkOrderProcess) {
                            $myorderMasterData = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $opd_arr->step_code)->first();
                            if ($myorderMasterData != null) {
                                OrderMaster::where('form_id', $form_id)
                                    ->where('order_statge_id', $opd_arr->step_code)
                                    ->update([
                                        'action_status' => 1,
                                    ]);
                            } else {

                                $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $opd_arr->step_code)->first();
                                if ($mymaster_data == null) {

                                    $mstOrderObj = new OrderMaster;
                                    $mstOrderObj->form_id = $form_id;
                                    $mstOrderObj->assign_userid = 0;
                                    $mstOrderObj->order_statge_id = $opd_arr->step_code;
                                    $mstOrderObj->assigned_by = Auth::user()->id;
                                    $mstOrderObj->assigned_on = date('Y-m-d');
                                    $mstOrderObj->expected_date = date('Y-m-d');
                                    $mstOrderObj->action_status = 1;
                                    $mstOrderObj->completed_on = date('Y-m-d');
                                    $mstOrderObj->action_mark = 1;
                                    $mstOrderObj->assigned_team = 4; //sales user
                                    $mstOrderObj->save();
                                }



                                $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                                if (!$checkOrderProcess) {
                                    $nextStageid = $opd_arr->order_step + 1;
                                    $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $form_id);

                                    $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $mystage_arr->step_code)->first();
                                    if ($mymaster_data == null) {
                                        $mstOrderObj = new OrderMaster;
                                        $mstOrderObj->form_id = $form_id;
                                        $mstOrderObj->assign_userid = 0;
                                        $mstOrderObj->order_statge_id = $mystage_arr->step_code;
                                        $mstOrderObj->assigned_by = Auth::user()->id;
                                        $mstOrderObj->assigned_on = date('Y-m-d');
                                        $mstOrderObj->expected_date = date('Y-m-d');
                                        $mstOrderObj->action_status = 0;
                                        $mstOrderObj->completed_on = date('Y-m-d');
                                        $mstOrderObj->action_mark = 1;
                                        $mstOrderObj->assigned_team = 4; //sales user
                                        $mstOrderObj->save();
                                    }
                                }
                            }
                        }
                        //insert in OrderMaster
                    }
                }
            }
            //===================


        } else {
            if ($qc_data->order_repeat == 1) {
                //print_r($qc_data);
                $opd_arrs = OPDays::get(); //private order Repaer
                //===========================
                foreach ($opd_arrs as $key => $opd_arr) {

                    if ($opd_arr->order_step <= $stepid) {

                        if ($opd_arr->order_step != 2) {
                            //insert in OPData
                            $checkOrderProcess = AyraHelp::checkOrderProcesDuplicte($form_id, $opd_arr->order_step);
                            if (!$checkOrderProcess) {
                                $mydata_arr = OPData::where('order_id_form_id', $form_id)->where('step_id', $opd_arr->order_step)->first();
                                if ($mydata_arr == null) {
                                    $opdObj = new OPData;
                                    $opdObj->order_id_form_id = $form_id; //formid and order id
                                    $opdObj->step_id = $opd_arr->order_step;
                                    $opdObj->expected_date = date('Y-m-d');
                                    $opdObj->remaks = 'Auto Completed by with previous statges';
                                    $opdObj->created_by = Auth::user()->id;
                                    $opdObj->assign_userid = 0;
                                    $opdObj->status = 1;
                                    $opdObj->step_status = 0;
                                    $opdObj->color_code = 'completed';
                                    $opdObj->diff_data = '1 second after';
                                    $opdObj->save();
                                }
                            }
                            //insert in OPData
                            //insert in OrderMaster
                            $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                            if (!$checkOrderProcess) {
                                $myorderMasterData = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $opd_arr->step_code)->first();
                                if ($myorderMasterData != null) {
                                    OrderMaster::where('form_id', $form_id)
                                        ->where('order_statge_id', $opd_arr->step_code)
                                        ->update([
                                            'action_status' => 1,
                                        ]);
                                } else {

                                    $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $opd_arr->step_code)->first();
                                    if ($mymaster_data == null) {
                                        $mstOrderObj = new OrderMaster;
                                        $mstOrderObj->form_id = $form_id;
                                        $mstOrderObj->assign_userid = 0;
                                        $mstOrderObj->order_statge_id = $opd_arr->step_code;
                                        $mstOrderObj->assigned_by = Auth::user()->id;
                                        $mstOrderObj->assigned_on = date('Y-m-d');
                                        $mstOrderObj->expected_date = date('Y-m-d');
                                        $mstOrderObj->action_status = 1;
                                        $mstOrderObj->completed_on = date('Y-m-d');
                                        $mstOrderObj->action_mark = 1;
                                        $mstOrderObj->assigned_team = 4; //sales user
                                        $mstOrderObj->save();
                                    }


                                    $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                                    if (!$checkOrderProcess) {
                                        $nextStageid = $opd_arr->order_step + 1;
                                        $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $form_id);

                                        $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $mystage_arr->step_code)->first();
                                        if ($mymaster_data == null) {
                                            $mstOrderObj = new OrderMaster;
                                            $mstOrderObj->form_id = $form_id;
                                            $mstOrderObj->assign_userid = 0;
                                            $mstOrderObj->order_statge_id = $mystage_arr->step_code;
                                            $mstOrderObj->assigned_by = Auth::user()->id;
                                            $mstOrderObj->assigned_on = date('Y-m-d');
                                            $mstOrderObj->expected_date = date('Y-m-d');
                                            $mstOrderObj->action_status = 0;
                                            $mstOrderObj->completed_on = date('Y-m-d');
                                            $mstOrderObj->action_mark = 1;
                                            $mstOrderObj->assigned_team = 4; //sales user
                                            $mstOrderObj->save();
                                        }
                                    }
                                }
                            }
                            //insert in OrderMaster
                        }
                    }
                }
                //===================
            }
            if ($qc_data->order_repeat == 2) {

                $opd_arrs = OPDaysRepeat::get(); //private order Repaer
                //===========================
                foreach ($opd_arrs as $key => $opd_arr) {
                    if ($opd_arr->order_step <= $stepid) {

                        if ($opd_arr->order_step != 2) {
                            //insert in OPData
                            $checkOrderProcess = AyraHelp::checkOrderProcesDuplicte($form_id, $opd_arr->order_step);
                            if (!$checkOrderProcess) {

                                $mydata_arr = OPData::where('order_id_form_id', $form_id)->where('step_id', $opd_arr->order_step)->first();
                                if ($mydata_arr == null) {
                                    $opdObj = new OPData;
                                    $opdObj->order_id_form_id = $form_id; //formid and order id
                                    $opdObj->step_id = $opd_arr->order_step;
                                    $opdObj->expected_date = date('Y-m-d');
                                    $opdObj->remaks = 'Auto Completed by with previous statges';
                                    $opdObj->created_by = Auth::user()->id;
                                    $opdObj->assign_userid = 0;
                                    $opdObj->status = 1;
                                    $opdObj->step_status = 0;
                                    $opdObj->color_code = 'completed';
                                    $opdObj->diff_data = '1 second after';
                                    $opdObj->save();
                                }
                            }
                            //insert in OPData
                            //insert in OrderMaster
                            $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                            if (!$checkOrderProcess) {
                                $myorderMasterData = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $opd_arr->step_code)->first();
                                if ($myorderMasterData != null) {
                                    OrderMaster::where('form_id', $form_id)
                                        ->where('order_statge_id', $opd_arr->step_code)
                                        ->update([
                                            'action_status' => 1,
                                        ]);
                                } else {
                                    $nextStageid = $opd_arr->order_step + 1;
                                    $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $form_id);

                                    $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $mystage_arr->step_code)->first();
                                    if ($mymaster_data == null) {
                                        $mstOrderObj = new OrderMaster;
                                        $mstOrderObj->form_id = $form_id;
                                        $mstOrderObj->assign_userid = 0;
                                        $mstOrderObj->order_statge_id = $opd_arr->step_code;
                                        $mstOrderObj->assigned_by = Auth::user()->id;
                                        $mstOrderObj->assigned_on = date('Y-m-d');
                                        $mstOrderObj->expected_date = date('Y-m-d');
                                        $mstOrderObj->action_status = 1;
                                        $mstOrderObj->completed_on = date('Y-m-d');
                                        $mstOrderObj->action_mark = 1;
                                        $mstOrderObj->assigned_team = 4; //sales user
                                        $mstOrderObj->save();
                                    }



                                    $checkOrderProcess = AyraHelp::checkOrderMasterDataDuplicte($form_id, $opd_arr->step_code);
                                    if (!$checkOrderProcess) {
                                        $nextStageid = $opd_arr->order_step + 1;
                                        $mystage_arr = AyraHelp::getOrderStageCodeByID($nextStageid, $form_id);

                                        $mymaster_data = OrderMaster::where('form_id', $form_id)->where('order_statge_id', $mystage_arr->step_code)->first();
                                        if ($mymaster_data == null) {
                                            $mstOrderObj = new OrderMaster;
                                            $mstOrderObj->form_id = $form_id;
                                            $mstOrderObj->assign_userid = 0;
                                            $mstOrderObj->order_statge_id = $mystage_arr->step_code;
                                            $mstOrderObj->assigned_by = Auth::user()->id;
                                            $mstOrderObj->assigned_on = date('Y-m-d');
                                            $mstOrderObj->expected_date = date('Y-m-d');
                                            $mstOrderObj->action_status = 0;
                                            $mstOrderObj->completed_on = date('Y-m-d');
                                            $mstOrderObj->action_mark = 1;
                                            $mstOrderObj->assigned_team = 4; //sales user
                                            $mstOrderObj->save();
                                        }
                                    }
                                }
                            }
                            //insert in OrderMaster
                        }
                    }
                }
                //===================



            }
        }
    }


    public static function getAllStagesData()
    {
        $clients_arr = OPDays::get();
        return $clients_arr;
    }
    public static function getAllStagesDataV1()
    {
        $qcdata_arrs = DB::table('st_process_stages')->where('process_id', 1)->get();

        return $qcdata_arrs;
    }

    public static function getAllStagesLead()
    {
        $qcdata_arrs = DB::table('st_process_stages')->where('process_id', 4)->get();
        return $qcdata_arrs;
    }


    public static function checkOrderProcesDuplicte($form_id, $stepid)
    {
        $orderdata = OPData::where('order_id_form_id', $form_id)->where('step_id', $stepid)->where('status', 1)->first();

        if ($orderdata == null) {
            return 0; //ok can insert
        } else {
            return 1; //no can not insert alreay have
        }
    }
    public static function checkPurchaeStageIsDone($form_id)
    {
        $qcdata_arrs = DB::table('qc_bo_purchaselist')->where('form_id', $form_id)->where('dispatch_status', 1)->get();
        $my_data = array();
        foreach ($qcdata_arrs as $key => $qcdata_arr) {

            $my_data[] = $qcdata_arr->status;
        }
        if (in_array(6, $my_data, true)) {
            return 1; //yes done
        } else {
            return 0; //no done
        }
    }
    public static function getPendingPurchaseStages()
    {
        $qcdata_arrs = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()->get(['form_id']);

        $i = 0;
        foreach ($qcdata_arrs as $key => $qcdata_arr) {
            //print_r($qcdata_arr->form_id);
            $data = AyraHelp::checkPurchaeStageIsDone($qcdata_arr->form_id);
            if (!$data) {
                $i++;
            }
        }
        return $i;
    }


    public static function getOrderMaster($form_id)
    {
        $myorder_arr = OrderMaster::where('form_id', $form_id)->where('action_status', 1)->get();
        return $myorder_arr;
    }
    public static function isBoxLabelFromClient($form_id)
    {
        $data_arrs = QCBOM::where('form_id', $form_id)->get();
        $i = 0;
        foreach ($data_arrs as $key => $data_arr) {
            if ($data_arr->m_name == 'Printed Box' && $data_arr->bom_from == 'From Client') {
                $i++;
            }
            if ($data_arr->m_name == 'Printed Label' && $data_arr->bom_from == 'From Client') {
                $i++;
            }
        }

        if ($i == 2) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function OTPEnableStatus()
    {
        $qcdata_arr = DB::table('bo_settings')->where('id', 1)->first();
        return $qcdata_arr->otp_enable;
    }

    public static function getIPKEY()
    {
        $qcdata_arr = DB::table('otp_key')->where('status', 1)->first();
        return $qcdata_arr->ip_key;
    }
    public static function getCurrentStageByForMID($form_id)
    {
        $qcdata_arr = DB::table('order_master')->where('form_id', $form_id)->where('action_status', 0)->orderby('id', 'desc')->first();
        return $qcdata_arr;
    }

    public static function getQCFormDate($form_id)
    {
        $qcdata_arr = DB::table('qc_forms')->where('form_id', $form_id)->first();
        return $qcdata_arr;
    }

    public static function getDispatchedDataView($form_id)
    {
        $qcdata_arr = DB::table('order_dispatch_data')->where('form_id', $form_id)->get();
        return $qcdata_arr;
    }
    public static function getDispatchedData($form_id)
    {
        //$qcdata_arr = DB::table('order_dispatch_data')->where('form_id',$form_id)->first();

        $mydata = array();
        $qcdata_arr = DB::table('order_dispatch_data')->where('form_id', $form_id)->get();
        foreach ($qcdata_arr as $key => $value) {

            if (isset($value->dispatch_on)) {
                $dispatchedon = $value->dispatch_on;
            } else {
                $dispatchedon = $value->created_at;
            }

            $mydata[] = array(

                'dispatch_on' => $dispatchedon,


            );
        }
        return $mydata;
    }
    public static function getStageNameByCode($step_code)
    {
        $qcdata_arr = DB::table('order_process_days')->where('step_code', $step_code)->first();
        return $qcdata_arr;
    }
    /*
public static function ScriptForOrderUpdateOrder(){
    //need to write code for update order data
    $qcdata_arr = DB::table('qc_forms')->where('is_deleted',0)->where('dispatch_status',1)->get();

    foreach ($qcdata_arr as $key => $qcdata) {
        if($qcdata->order_type=='Bulk'){

            $opdObj=new OPData;
            $opdObj->order_id_form_id=$qcdata->form_id; //formid and order id
            $opdObj->step_id=1;
            $opdObj->expected_date=$qcdata->created_at;
            $opdObj->remaks='auto start';
            $opdObj->created_by=$qcdata->created_by;
            $opdObj->assign_userid=$qcdata->created_by;
            $opdObj->status=1;
            $opdObj->step_status=4;
            $opdObj->color_code='completed';
            $opdObj->diff_data='1 second before';
            $opdObj->save();

        }else{
            if($qcdata->order_type=='Private Label' && $qcdata->order_repeat=='1'){

            }else{
            $opdObj=new OPData;
            $opdObj->order_id_form_id=$qcdata->form_id; //formid and order id
            $opdObj->step_id=1;
            $opdObj->expected_date=$qcdata->created_at;
            $opdObj->remaks='auto start';
            $opdObj->created_by=$qcdata->created_by;
            $opdObj->assign_userid=$qcdata->created_by;
            $opdObj->status=1;
            $opdObj->step_status=4;
            $opdObj->color_code='completed';
            $opdObj->diff_data='1 second before';
            $opdObj->save();
            }
        }
    }
}

public static function ScriptForOrderUpdate(){
    //this code is for  update states data
    $qcdata_arr = DB::table('qc_forms')->where('is_deleted',0)->where('dispatch_status',1)->get();


    foreach ($qcdata_arr as $key => $qcdata) {

          if($qcdata->order_type=='Bulk'){
                $action_start=1;
                $completed_on=$qcdata->created_at;
                $data_out=OPDaysBulk::where('step_code','PRODUCTION')->first();
                $expencted_date= Carbon::parse($qcdata->artwork_start_date)->addDays($data_out->process_days);

                $action_mark=1;
                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$qcdata->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';
                $mstOrderObj->assigned_by =$qcdata->created_by;
                $mstOrderObj->action_status =$action_start;
                $mstOrderObj->assigned_on =$completed_on;
                $mstOrderObj->completed_on =$completed_on;
                $mstOrderObj->action_mark =$action_mark;
                $mstOrderObj->assigned_team =1;//sales user
                $mstOrderObj->save();

                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$qcdata->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='PRODUCTION';
                $mstOrderObj->assigned_by =$qcdata->created_by;
                $mstOrderObj->assigned_on =$completed_on;
                $mstOrderObj->action_status =0;
                $mstOrderObj->completed_on =$completed_on;
                $mstOrderObj->action_mark =$action_mark;
                $mstOrderObj->expected_date =$expencted_date;
                $mstOrderObj->assigned_team =4;//perchase team assign
                $mstOrderObj->save();


          }else{
            if($qcdata->order_type=='Private Label' && $qcdata->order_repeat=='1'){
                $action_start=0;
                $action_mark=1;
                $completed_on=$qcdata->created_at;
                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$qcdata->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';
                $mstOrderObj->assigned_by =$qcdata->created_by;
                $mstOrderObj->action_status =$action_start;
                $mstOrderObj->assigned_on =$completed_on;
                $mstOrderObj->completed_on =$completed_on;
                $mstOrderObj->action_mark =$action_mark;
                $mstOrderObj->assigned_team =1;//sales user
                $mstOrderObj->save();

            }else{
                $action_start=1;
                $completed_on=$qcdata->created_at;
                $action_mark=1;

                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$qcdata->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';
                $mstOrderObj->assigned_by =$qcdata->created_by;
                $mstOrderObj->action_status =$action_start;
                $mstOrderObj->assigned_on =$completed_on;
                $mstOrderObj->completed_on =$completed_on;
                $mstOrderObj->action_mark =$action_mark;
                $mstOrderObj->assigned_team =1;//sales user
                $mstOrderObj->save();

                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$qcdata->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='ART_WORK_REVIEW';
                $mstOrderObj->assigned_by =$qcdata->created_by;
                $mstOrderObj->assigned_on =$completed_on;
                $mstOrderObj->action_status =0;
                $mstOrderObj->completed_on =$completed_on;
                $mstOrderObj->action_mark =$action_mark;
                $mstOrderObj->assigned_team =1;//sales user
                $mstOrderObj->save();
            }
          }



    }
}
*/

    public static function getOrderStageCodeByID($stage_id, $form_id)
    {
        $qc_data = AyraHelp::getQCFORMData($form_id);

        $order_type = $qc_data->order_type;
        $order_repeat = $qc_data->order_repeat;

        if ($order_type == 'Private Label' && $order_repeat == '1') {
            $data_out = OPDays::where('order_step', $stage_id)->first();
        }
        if ($order_type == 'Private Label' && $order_repeat == '2') {
            $data_out = OPDaysRepeat::where('order_step', $stage_id)->first();
        }
        if ($order_type == 'Bulk') {
            $data_out = OPDaysBulk::where('order_step', $stage_id)->first();
        }


        return $data_out;
    }


    public static function getOrderStageInfoBulk($stage_id)
    {

        $qcdata_arr_get = DB::table('order_process_data')
            ->join('qc_forms', 'order_process_data.order_id_form_id', '=', 'qc_forms.form_id')
            ->where('order_process_data.status', 1)
            ->where('order_process_data.step_id', $stage_id)
            ->where('qc_forms.order_type', 'Bulk')
            ->where('qc_forms.dispatch_status', 1)
            ->select('order_process_data.*', 'qc_forms.*')
            ->count();
        $data_out = OPDaysBulk::where('order_step', $stage_id)->first();
        $data_pendingdata = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->where('order_type', 'Bulk')->count();






        $mydatra = array(
            'statge_name' => optional($data_out)->process_name,
            'days_to_done' => optional($data_out)->process_days,
            'countme' => $qcdata_arr_get,
            'pending_count' => $data_pendingdata
        );



        return $mydatra;
    }
    public static function getOrderStageInfoNewPrivateLabel($stage_id)
    {
        $qcdata_arr_get = DB::table('order_process_data')
            ->join('qc_forms', 'order_process_data.order_id_form_id', '=', 'qc_forms.form_id')
            ->where('order_process_data.status', 1)
            ->where('order_process_data.step_id', $stage_id)
            ->where('qc_forms.order_type', 'Private Label')
            ->where('qc_forms.order_repeat', 1)
            ->where('qc_forms.dispatch_status', 1)
            ->select('order_process_data.*', 'qc_forms.*')

            ->count();
        $data_out = OPDays::where('order_step', $stage_id)->first();
        $data_pendingdata = QCFORM::where('dispatch_status', 1)->where('is_deleted', 0)->where('order_repeat', 1)->where('order_type', 'Private Label')->count();

        $mydatra = array(
            'statge_name' => optional($data_out)->process_name,
            'countme' => $qcdata_arr_get,
            'pending_count' => $data_pendingdata
        );


        return $mydatra;
    }
    public static function getOrderStageInfoRepeat($stage_id)
    {
        $qcdata_arr_get = DB::table('order_process_data')
            ->join('qc_forms', 'order_process_data.order_id_form_id', '=', 'qc_forms.form_id')
            ->where('order_process_data.status', 1)
            ->where('order_process_data.step_id', $stage_id)
            ->where('qc_forms.order_type', 'Private Label')
            ->where('qc_forms.order_repeat', 2)
            ->where('qc_forms.dispatch_status', 1)
            ->select('order_process_data.*', 'qc_forms.*')
            ->count();
        $data_out = OPDaysRepeat::where('order_step', $stage_id)->first();
        $data_pendingdata = QCFORM::where('dispatch_status', 1)->where('order_type', 'Private Label')->where('is_deleted', 0)->where('order_repeat', 2)->count();





        $mydatra = array(
            'statge_name' => optional($data_out)->process_name,
            'countme' => $qcdata_arr_get,
            'pending_count' => $data_pendingdata
        );


        return $mydatra;
    }
    public static function getOrderStageInfo($stage_id, $orderType)
    {

        $qcdata_arr_get = DB::table('order_process_data')
            ->join('qc_forms', 'order_process_data.order_id_form_id', '=', 'qc_forms.form_id')
            ->where('order_process_data.status', 1)
            ->where('order_process_data.step_id', $stage_id)
            ->where('qc_forms.order_type', $orderType)
            ->select('order_process_data.*', 'qc_forms.*')
            ->count();

        switch ($orderType) {
            case 'Bulk':
                $data_out = OPDaysBulk::where('order_step', $stage_id)->first();
                break;
            case 'Private Label':
                $data_out = OPDays::where('order_step', $stage_id)->first();
                break;
            case 'RepeatOrder':
                $data_out = OPDaysRepeat::where('order_step', $stage_id)->first();
                break;
        }


        $mydatra = array(
            'statge_name' => optional($data_out)->process_name,
            'countme' => $qcdata_arr_get
        );
        return $mydatra;
    }

    public static function getBOMScript()
    {

        $qcdata_arr = DB::table('temp_bom_1')->where('from_what', 'Order')->get();
        foreach ($qcdata_arr as $key => $value) {
            //print_r($value);
            $form_id = $value->id;
            $m_name = $value->bom_name;
            $qty = $value->qty;
            $bom_from = $value->from_what;
            $bom_cat = $value->cat;
            $order_id = $value->order_id;
            $part_id = $value->part_id;
            $qc_data = AyraHelp::getQCFORMData($form_id);



            //==============================
            /*
       $qcdata_arr_bom = DB::table('qc_forms_bom')->where('form_id',$form_id)->where('m_name',$m_name)->first();
       if($qcdata_arr_bom==null){

        DB::table('qc_forms_bom')->insert(
            [
                'form_id' => $form_id,
                'm_name' => $m_name,
                'qty' => $qty,
                'bom_from' => $bom_from,
                'bom_cat' => $bom_cat,
                ]
        );

       }
       */
            //============================================
            //==============================
            $qcdata_arr_bom = DB::table('qc_bo_purchaselist')->where('form_id', $form_id)->where('material_name', $m_name)->first();
            if ($qcdata_arr_bom == null) {


                DB::table('qc_bo_purchaselist')->insert(
                    [
                        'form_id' => $form_id,
                        'material_name' => $m_name,
                        'qty' => $qty,
                        'order_cat' => $bom_cat,
                        'order_id' => $order_id,
                        'sub_order_index' => $part_id,
                        'order_name' => $qc_data->brand_name,
                        'created_by' => $qc_data->created_by,

                    ]
                );
            }
            //============================================


        }
    }

    public static function getPurchaseOrderListHelper($form_id)
    {
        $qcdata_arr = DB::table('qc_forms_bom')->where('form_id', $form_id)->get();
        foreach ($qcdata_arr as $key => $value) {

            // print_r($value);
        }
    }
    public static function getQCFORMData($form_id)
    {
        $client_arr = DB::table('qc_forms')->where('form_id', $form_id)->first();
        return $client_arr;
    }
    public static function getClientByBrandName($brand_name)
    {
        $client_arr = DB::table('clients')->where('brand', $brand_name)->orwhere('company', $brand_name)->first();
        return $client_arr;
    }
    public static function getClientByIDData($cid)
    {
        $client_arr = DB::table('clients')->where('id', $cid)->first();
        return $client_arr;
    }

    public static function getBOMItemCategory()
    {
        $client_arr = DB::table('bom_item_category')->get();
        return $client_arr;
    }
    public static function getBOMItemCategoryID($id)
    {
        $client_arr = DB::table('bom_item_category')->where('id', $id)->first();
        return $client_arr;
    }

    public static function getBOMItemMaterial()
    {
        $client_arr = DB::table('bom_item_material')->get();
        return $client_arr;
    }
    public static function getBOMItemMaterialID($id)
    {
        $client_arr = DB::table('bom_item_material')->where('id', $id)->first();
        return $client_arr;
    }
    public static function getBOMItemSize()
    {
        $client_arr = DB::table('bom_item_size')->get();
        return $client_arr;
    }
    public static function getBOMItemSizeID($id)
    {
        $client_arr = DB::table('bom_item_size')->where('id', $id)->first();
        return $client_arr;
    }

    public static function getBOMItemColor()
    {
        $client_arr = DB::table('bom_item_color')->get();
        return $client_arr;
    }
    public static function getBOMItemColorID($id)
    {
        $client_arr = DB::table('bom_item_color')->where('id', $id)->first();
        return $client_arr;
    }
    public static function getBOMItemSape()
    {
        $client_arr = DB::table('bom_item_sape')->get();
        return $client_arr;
    }
    public static function getBOMItemSapeID($id)
    {
        $client_arr = DB::table('bom_item_sape')->where('id', $id)->first();
        return $client_arr;
    }

    public static function getfeedbackAlert($user_id)
    {
        $date_60 = \Carbon\Carbon::today()->subDays(90);
        $date_30 = \Carbon\Carbon::today()->subDays(30);

        $from = $date_60;
        $to = $date_30;



        $getStepDays = DB::table('samples')->where('status', 2)->where('created_by', $user_id)->whereNull('sample_feedback')->whereBetween('sent_on', [$from, $to])->get();
        $getStepDaysTC = DB::table('samples')->where('status', 2)->where('created_by', $user_id)->whereNull('sample_feedback')->whereBetween('sent_on', [$from, $to])->count();

        $data = array(
            'data' => $getStepDays,
            'count' => $getStepDaysTC,

        );

        return $data;
    }

    //sampletoIngrednentApprovalInsert
    public static function sampletoIngrednentApprovalInsert()
    {
        $sampleArrData = DB::table('samples')
            ->where('status', 2)
            ->where('sample_type', '!=', 0)
            ->where('sample_type', '!=', 2)
            ->where('is_done_stoi', '=', 0)
            ->where('is_deleted', '=', 0)
            ->orderBy('id', 'desc')
            ->get();
        // echo "<pre>";
        // print_r($sampleArrData);
        // die;


        // echo count($sampleArrData);
        // die;

        foreach ($sampleArrData as $key => $rowData) {


            $sample_detailsArr = json_decode($rowData->sample_details);
            // print_r($sample_detailsArr);
            // die;


            foreach ($sample_detailsArr as $key => $row) {


                DB::table('samples_for_approval_list')
                    ->updateOrInsert(
                        [
                            'sample_id' => $rowData->id,
                            'sample_code' => $rowData->sample_code,
                            'item_name' => $row->txtItem
                        ],
                        [
                            'sale_person_id' => $rowData->created_by,
                            'client_id' => $rowData->client_id,
                            'item_name' => $row->txtItem,
                            'sample_type' => $row->sample_type,
                            'client_name' => $rowData->lead_name . $rowData->lead_company,
                            'sample_created_at' => $rowData->created_at,
                            'sample_feedback' => $rowData->sample_feedback_other
                        ]
                    );
            }
        }
    }
    //sampletoIngrednentApprovalInsert

    //sampleUnassigned
    public static function sampleUnassigned()
    {
        $getStepDays = DB::table('samples')
            //  ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('is_rejected', 0)
            ->where('sample_type', '!=', 2)
            ->where('sample_stage_id', '=', 1)
            ->whereNull('assingned_to')
            ->get();

        return count($getStepDays);
    }
    public static function sampleUnassigned_OILONLY()
    {
        $getStepDays = DB::table('samples')
            //  ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('is_rejected', 0)
            ->where('sample_stage_id', 1)
            ->where('sample_type', '=', 2)
            // ->where('sample_stage_id', '<=', 2)
            ->get();

        return count($getStepDays);
    }



    //sampleAssignedREST
    public static function sampleAssignedREST()
    {
        $getStepDays = DB::table('samples')
            //  ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('sample_type', '!=', 2)->where('sample_stage_id', '>=', 2)->where('formatation_status', '!=', 0)
            ->whereNotNull('assingned_to')->get();

        return count($getStepDays);
        //$users_arr = Sample::where('is_deleted', 0)->whereNotNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=',2)->where('sample_stage_id','<=',2)->where('formatation_status','=',0)->get();

    }

    //sampleAssignedREST

    public static function sampleAssigned()
    {
        $getStepDays = DB::table('samples')
            //  ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('sample_type', '!=', 2)
            ->where('sample_stage_id', '<=', 2)->where('formatation_status', '=', 0)
            ->whereNotNull('assingned_to')->get();

        return count($getStepDays);
        //$users_arr = Sample::where('is_deleted', 0)->whereNotNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=',2)->where('sample_stage_id','<=',2)->where('formatation_status','=',0)->get();

    }
    public static function sampleAssignedAdmin()
    {
        $getStepDays = DB::table('samples')
            //  ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->whereNotNull('assingned_to')->get();

        return count($getStepDays);
        //$users_arr = Sample::where('is_deleted', 0)->whereNotNull('assingned_to')->orderBy('id', 'desc')->where('status', 1)->where('sample_type', '!=',2)->where('sample_stage_id','<=',2)->where('formatation_status','=',0)->get();

    }
    //sampleUnassigned
    //get pending samples since dispatch 
    public static function samplePendingDispatchData($days, $sid = NULL)
    {

        switch ($sid) {
            case 1:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();

                break;
            case 2:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();

                break;

            case 3:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();

                break;
            case 4:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();

                break;
            case 5:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();

                break;



            default:
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('is_deleted', 0)
                    ->where('status', 1)->get();
                break;
        }

        // $user = auth()->user();
        // $userRoles = $user->getRoleNames();
        // $user_role = $userRoles[0];
        // if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk' || $user_role == 'SalesHead') {
        //     if($sid ==3 || $sid==null){
        //         $getStepDays = DB::table('samples')                               
        //         ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
        //         ->where('is_deleted',0)
        //         ->where('status', 1)->get();

        //     }else{
        //         $getStepDays = DB::table('samples')                               
        //         ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
        //         ->where('status', 1)
        //         ->where('is_deleted',0)
        //         ->where('sample_type', $sid)->get();
        //     }


        // } else {
        //      if($sid ==3 || $sid==null){
        //         $getStepDays = DB::table('samples')
        //         ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
        //         ->where('created_by', Auth::user()->id)
        //         ->where('status', 1)->get();

        //      }else{
        //         $getStepDays = DB::table('samples')
        //         ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
        //         ->where('created_by', Auth::user()->id)
        //         ->where('status', 1)
        //         ->where('sample_type', $sid)->get();
        //      }

        // }

        return $getStepDays;
    }
    //get pending samples since dispatch 

    public static function samplePendingDispatchDataOK($days, $sid = NULL)
    {

        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk' || $user_role == 'SalesHead') {
            if ($sid == 3 || $sid == null) {
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('is_deleted', 0)
                    ->where('status', 1)->get();
            } else {
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('sample_type', $sid)->get();
            }
        } else {
            if ($sid == 3 || $sid == null) {
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('created_by', Auth::user()->id)
                    ->where('status', 1)->get();
            } else {
                $getStepDays = DB::table('samples')
                    ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                    ->where('created_by', Auth::user()->id)
                    ->where('status', 1)
                    ->where('sample_type', $sid)->get();
            }
        }

        return $getStepDays;
    }

    //sampleTotalPendingCosmaticFormulation
    public static function sampleTotalPendingCosmaticFormulation()
    {



        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'SalesHead' || $user_role == 'CourierTrk' || Auth::user()->id == 124) {
            $getStepDays = DB::table('samples')
                //->whereDate('created_at', '>', Carbon::now()->subDays($days))                
                ->where('is_deleted', 0)
                ->where('status', 1)
                ->where('is_formulated', 0)
                ->where('sample_type', '!=', 2)->count();
        } else {
            $getStepDays = DB::table('samples')

                ->where('created_by', Auth::user()->id)
                ->where('is_deleted', 0)
                ->where('status', 1)
                ->where('sample_type', '!=', 2)->count();
        }

        return $getStepDays;
    }


    //sampleTotalPendingCosmaticFormulation

    public static function sampleTotalPendingCosmatic()
    {



        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'SalesHead' || $user_role == 'CourierTrk' || Auth::user()->id == 124) {
            $getStepDays = DB::table('samples')
                //->whereDate('created_at', '>', Carbon::now()->subDays($days))                
                ->where('is_deleted', 0)
                ->where('status', 1)
                ->where('sample_type', '!=', 2)->count();
        } else {
            $getStepDays = DB::table('samples')

                ->where('created_by', Auth::user()->id)
                ->where('is_deleted', 0)
                ->where('status', 1)
                ->where('sample_type', '!=', 2)->count();
        }

        return $getStepDays;
    }

    public static function samplePendingDispatch($days)
    {



        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'SalesHead' || $user_role == 'CourierTrk' || Auth::user()->id == 124) {
            $getStepDays = DB::table('samples')
                //->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('is_deleted', 0)
                ->where('status', 1)->count();
        } else {
            $getStepDays = DB::table('samples')
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('created_by', Auth::user()->id)
                ->where('is_deleted', 0)
                ->where('status', 1)->count();
        }

        return $getStepDays;
    }
    public static function purchasePendingTostart($days)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk') {

            $getStepDays = DB::table('qc_bo_purchaselist')
                //->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('status', 1)->count();
        } else {
            $getStepDays = DB::table('qc_bo_purchaselist')
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('created_by', Auth::user()->id)
                ->where('status', 1)->count();
        }

        return $getStepDays;
    }

    public static function purchasePendingOrderTostartOrderOnly($days)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk') {

            //$getStepDays = DB::table('qc_bo_purchaselist')

            //->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            //->where('status','!=',7)->get();


            $qcdata_arrs = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 6)->get(['form_id', 'order_id']);
            //   print_r($qcdata_arrs);
            //   die;
            $i = 0;
            foreach ($qcdata_arrs as $key => $qcdata_arr) {

                $data = AyraHelp::checkPurchaeStageIsDone($qcdata_arr->form_id);
                if (!$data) {
                    $i++;
                }
            }
            $i;
        } else {
            // $getStepDays = DB::table('qc_bo_purchaselist')
            // ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
            // ->where('created_by',Auth::user()->id)
            // ->where('status','!=',7)->get();

            $qcdata_arrs = DB::table('qc_bo_purchaselist')->where('dispatch_status', 1)->distinct()
                ->where('created_by', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())->where('status', '!=', 7)->get(['form_id']);

            $i = 0;
            foreach ($qcdata_arrs as $key => $qcdata_arr) {

                $data = AyraHelp::checkPurchaeStageIsDone($qcdata_arr->form_id);
                if (!$data) {
                    $i++;
                }
            }
            $i;
        }

        return $i;
    }
    public static function purchasePendingOrderTostart($days)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'Staff' || $user_role == 'CourierTrk') {

            $getStepDays = DB::table('qc_bo_purchaselist')
                //->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('status', '!=', 7)->count();
        } else {
            $getStepDays = DB::table('qc_bo_purchaselist')
                ->where('created_at', '<=', Carbon::now()->subDays($days)->toDateString())
                ->where('created_by', Auth::user()->id)
                ->where('status', '!=', 7)->count();
        }

        return $getStepDays;
    }




    public static function getStepDays($step)
    {
        $getStepDays = DB::table('order_process_days')->where('order_step', $step)->first();
        return $getStepDays;
    }

    public static function getOrderCODE()
    {
        $max_id = QCFORM::where('yr', date('Y'))->where('mo', date('m'))->max('order_index') + 1;
        $uname = 'O';
        $num = $max_id;
        $str_length = 4;
        $prifix = "24-";
        $sid_code = $uname . "#" . $prifix . substr("0000{$num}", -$str_length);
        // $sid_code = $prifix . substr("0000{$num}", -$str_length);
        return $sid_code;
    }
    public static function getOrderCODEIndex()
    {
        $max_id =  QCFORM::where('yr', date('Y'))->where('mo', date('m'))->max('order_index') + 1;
        return $max_id;
    }


    //oil 
    public static function getOrderCODE_OIL()
    {
        $max_id = QCFORM::where('yr', date('Y'))->where('mo', date('m'))->max('order_index') + 1;
        $uname = 'VO';
        $num = $max_id;
        $str_length = 4;
        $prifix = "24-";
        $sid_code = $uname . "#" . $prifix . substr("0000{$num}", -$str_length);
        // $sid_code = $prifix . substr("0000{$num}", -$str_length);
        return $sid_code;
    }   

    //oil 

    public static function getSampleFeedbackCount($userid, $days)
    {
        $chartDatas = Sample::select([
            DB::raw('DATE(feedback_addedon) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('feedback_addedon', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->where('sample_feedback', 1)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum_type_1 = 0;
        foreach ($chartDatas as $key => $value) {
            $sum_type_1 += $value->count;
        }
        $sum_type_1;

        $chartDatas = Sample::select([
            DB::raw('DATE(feedback_addedon) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('feedback_addedon', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->where('sample_feedback', 2)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum_type_2 = 0;
        foreach ($chartDatas as $key => $value) {
            $sum_type_2 += $value->count;
        }
        $sum_type_2;

        $chartDatas = Sample::select([
            DB::raw('DATE(feedback_addedon) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('feedback_addedon', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->where('sample_feedback', 3)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum_type_3 = 0;
        foreach ($chartDatas as $key => $value) {
            $sum_type_3 += $value->count;
        }
        $sum_type_3;

        $chartDatas = Sample::select([
            DB::raw('DATE(feedback_addedon) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('feedback_addedon', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->where('sample_feedback', 4)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum_type_4 = 0;
        foreach ($chartDatas as $key => $value) {
            $sum_type_4 += $value->count;
        }
        $sum_type_4;
        $data = array(
            'option_1' => $sum_type_1,
            'option_2' => $sum_type_2,
            'option_3' => $sum_type_3,
            'option_4' => $sum_type_4,
        );
        return $data;
    }


    public static function getCountPaymentRecClientupAddedby($userid, $days)
    {

        //   $chartDatas=PaymentRec::sum('rec_amount')
        //   //->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
        //   ->where('created_by',$userid)
        //   ->groupBy('date')
        //   ->orderBy('date', 'DESC')
        //   ->get();

        $chartDatas = DB::table("payment_recieved_from_client")
            ->where('created_by', $userid)
            ->where('payment_status', 1)
            ->get()->sum("rec_amount");



        return $chartDatas;
    }


    public static function getCountClientupAddedby($userid, $days)
    {
        $chartDatas = Client::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('added_by', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }
    public static function getCountSampleAddedby($userid, $days)
    {
        $chartDatas = Sample::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->where('status', 2)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }
    public static function getCountSampleFeedbackAddedby($userid, $days)
    {
        $chartDatas = Sample::select([
            DB::raw('DATE(feedback_addedon) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('feedback_addedon', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('created_by', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }
    //---------------------------------
    public static function getAssignedLead($userid, $days)
    {
        $chartDatas = ClientNote::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('user_id', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }

    public static function getIrrelevantLead($userid, $days)
    {
        $chartDatas = ClientNote::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('user_id', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }

    public static function getFreshArrived($userid, $days)
    {
        $chartDatas = ClientNote::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('user_id', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }

    //---------------------------------
    public static function getCountNotedAddedby($userid, $days)
    {
        $chartDatas = ClientNote::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('user_id', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }
    public static function getCountFollowupAddedby($userid, $days)
    {
        $chartDatas = Client::select([
            DB::raw('DATE(follow_date) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('follow_date', [Carbon::now()->subDays($days), Carbon::now()])
            ->where('added_by', $userid)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        $sum = 0;
        foreach ($chartDatas as $key => $value) {
            $sum += $value->count;
        }
        return $sum;
    }

    public static function getOTP()
    {

        $env = strtoupper(trim(config('app.env')));
        if (in_array($env, ['DEV', 'DEVELOPMENT'])) {
            $otp = '11111';
        } else {
            $otp = rand(10000, 99999);
        }

        return $otp;
    }
    public static function StockAvailabilitywithItemIDQTY($item_id, $qty)
    {
        $item_stock = DB::table('item_stock')->where('item_id', $item_id)->first();
        $curr_in_stock_qty = $item_stock->qty;
        if ($curr_in_stock_qty > $qty) {
            $stock_flag = 1; //available
        } else {
            $stock_flag = 2; //not availble
        }
        return $stock_flag;
    }
    public static function getMissedFollowup($user_id)
    {
        $date = \Carbon\Carbon::today()->subDays(1);
        $clients = Client::where('added_by', $user_id)->where('follow_date', '<', date($date))->get();
        $clientsTC = Client::where('added_by', $user_id)->where('follow_date', '<', date($date))->count();



        $data = array(
            'client_count' => $clientsTC,
            'client_data' => $clients,
        );
        return $data;
    }

    public static function getAlarm($user_id = NULL)
    {
        if (empty($user_id)) {
            $alert_alert = DB::table('user_activity')->take(10)->get();
        } else {
            $alert_alert = DB::table('user_activity')->where('user_id', $user_id)->take(10)->get();
        }

        return $alert_alert;
    }

    public static function ClinentInfoByOrderID($id)
    {
        $items_orders = DB::table('orders')->where('order_index', $id)->first();
        $client_id = $items_orders->client_id;
        $client_arr = AyraHelp::getClientbyid($client_id);
        return $client_arr;
    }

    public static function getVendors($id)
    {
        $items_master = DB::table('vendors')->where('id', $id)->first();

        return $items_master;
    }
    public static function getAllVendors()
    {
        $items_master = DB::table('vendors')->get();

        return $items_master;
    }
    public static function getUserAcessListByUserId($userid)
    {
        $items_master = DB::table('users_access')->where('access_by', $userid)->get();
        return $items_master;
    }
    public static function getRESPUR($id)
    {
        $items_master = DB::table('orders_items_material')->where('id', $id)->first();
        return $items_master;
    }

    public static function getBOMconfirmStatus($id)
    {
        $items_master = DB::table('orders_items_material')->where('order_item_id', $id)->first();
        return $items_master;
    }
    public static function getReqOrders($id)
    {

        $items_master = DB::table('orders_req_items')->where('id', $id)->first();
        return $items_master;
    }


    public static function getPIDCode()
    {
        $max_id = PurchaseOrders::max('purchase_index') + 1;

        $num = $max_id;
        $str_length = 4;
        $sid_code = "PR-" . substr("0000{$num}", -$str_length);
        return $sid_code;
    }


    //get last 30 days sample list
    //get item stok by item_id
    public static function getStockQTYbyItemID($item_id)
    {
        $items_master = DB::table('item_stock')->where('item_id', $item_id)->first();
        return $items_master;
    }

    public static function getSample30Days()
    {
        $users = DB::table("users")
            ->select('*')
            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->get();
        return $users;
    }
    //this is used to get item category
    public static function getItemCategory($id_SKU = NULL)
    {
        if ($id_SKU) {
            $items_category = DB::table('item_category')->where('cat_id', $id_SKU)->get();
        } else {
            $items_category = DB::table('item_category')->get();
        }


        return $items_category;
    }
    public static function getSampleFeedback()
    {
        $items_master = DB::table('sample_feedbacktype')->get();
        return $items_master;
    }

    //this is used to get att_values
    public static function getMasterItemsType()
    {
        $items_master = DB::table('items_master_type')->get();
        return $items_master;
    }
    public static function getStockBYItemID($item_id)
    {
        $items_master = DB::table('item_stock')->where('item_id', $item_id)->first();
        return $items_master;
    }

    public static function getStockReservedByID($item_id)
    {
        $items_master = DB::table('item_stock_entry')->where('item_id', $item_id)->where('purchase_reserve_flag', 1)->where('purchase_reserved_status', 2)->sum('qty');

        $data = DB::table("item_stock_entry")

            ->select(DB::raw("SUM(qty) as count"))
            ->where('item_id', $item_id)
            ->where('purchase_reserve_flag', 1)
            ->where('purchase_reserved_status', 2)
            ->get();

        return $data[0]->count;
    }
    public static function getItemsbyItemID($code_id)
    {

        $items_master = DB::table('items')->where('item_id', $code_id)->first();
        return $items_master;
    }
    public static function getProductItemByid($item_id)
    {

        $items_master_data = DB::table('orders_req_items')->where('id', $item_id)->first();

        return $items_master_data;
    }
    public static function getItemCatbyItemID($code_id)
    {
        $items_master = DB::table('item_category')->where('cat_id', $code_id)->first();
        return $items_master;
    }
    //this is used to get att_values
    public static function getUserName($user_id)
    {
        $user_arr = DB::table('users')->where('id', $user_id)->get();
        return $user_arr[0]->name;
    }
    public static function getUser($user_id)
    {
        $user_arr = DB::table('users')->where('id', $user_id)->first();
        return $user_arr;
    }
    public static function getClientSource()
    {
        $user_arr = DB::table('clients_source')->get();
        return $user_arr;
    }
    public static function getUserPrefix($user_id)
    {
        $user_arr = DB::table('users')->where('id', $user_id)->get();
        return $user_arr[0]->user_prefix;
    }

    public static function getVendorsByadded($user_id)
    {
        $user_arr = DB::table('vendors')->where('created_by', '=', $user_id)->get();
        return $user_arr;
    }

    public static function IsClientHaveOrderList($user_id)
    {

        $user_arr = DB::table('qc_forms')->where('is_deleted', 0)->where('client_id', '=', $user_id)->count();
        return $user_arr;
    }
    
    //getClientByaddedA
    public static function getClientByaddedA($user_id)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'SalesHead'|| $user_role == 'CourierTrk' || $user_role == 'Sampler') {
            $user_arr = DB::table('clients')->where('is_deleted', '!=', 1)->where('have_order', '=', 1)->get();
        } else {
            //$user_arr = DB::table('clients')->where('is_deleted','!=',1)->where('added_by', $user_id)->get();
            //newcode
            $user_arr = DB::table('clients')
                ->leftJoin('users_access', 'clients.id', '=', 'users_access.client_id')
                ->select('clients.*')
                ->orderBy('clients.id', 'DESC')
                ->where('clients.added_by', $user_id)
                ->where('clients.is_deleted', '!=', 1)
                ->orwhere('users_access.access_to', $user_id)
                ->get();
            //newcode


        }

        return $user_arr;
    }

    //getClientByaddedA

    public static function getClientByadded($user_id)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == 'Admin' || $user_role == 'SalesHead'|| $user_role == 'CourierTrk' || $user_role == 'Sampler') {
            $user_arr = DB::table('clients')->where('is_deleted', '!=', 1)->get();
        } else {
            //$user_arr = DB::table('clients')->where('is_deleted','!=',1)->where('added_by', $user_id)->get();
            //newcode
            $user_arr = DB::table('clients')
                ->leftJoin('users_access', 'clients.id', '=', 'users_access.client_id')
                ->select('clients.*')
                ->orderBy('clients.id', 'DESC')
                ->where('clients.added_by', $user_id)
                ->where('clients.is_deleted', '!=', 1)
                ->orwhere('users_access.access_to', $user_id)
                ->get();
            //newcode


        }

        return $user_arr;
    }
    public static function getClientbyid($user_id)
    {
        $user_arr = DB::table('clients')->where('is_deleted', '!=', 1)->where('id', $user_id)->first();
        return $user_arr;
    }
    public static function getClientbyidWithDel($user_id)
    {
        $user_arr = DB::table('clients')->where('id', $user_id)->first();
        return $user_arr;
    }
    public static function getClientbyidWithDelete($user_id)
    {
        $user_arr = DB::table('clients')->where('id', $user_id)->first();
        return $user_arr;
    }
    public static function getClientCountbyid($user_id = NULL)
    {
        if ($user_id == null) {

            $user_arr = DB::table('clients')->where('is_deleted', '!=', 1)->count();

            $user_arr_lead = DB::table('clients')->where('group_status', 2)->where('is_deleted', '!=', 1)->count();
            $user_arr_sampling = DB::table('clients')->where('group_status', 4)->where('is_deleted', '!=', 1)->count();
            $user_arr_customer = DB::table('clients')->where('group_status', 5)->where('is_deleted', '!=', 1)->count();
        } else {

            $user_arr = DB::table('clients')->where('is_deleted', '!=', 1)->where('added_by', $user_id)->count();

            $user_arr_lead = DB::table('clients')->where('group_status', 2)->where('is_deleted', '!=', 1)->where('added_by', $user_id)->count();
            $user_arr_sampling = DB::table('clients')->where('group_status', 4)->where('is_deleted', '!=', 1)->where('added_by', $user_id)->count();
            $user_arr_customer = DB::table('clients')->where('group_status', 5)->where('is_deleted', '!=', 1)->where('added_by', $user_id)->count();
        }

        $user_data = array(
            'total' => $user_arr,
            'lead' => $user_arr_lead,
            'sampling' => $user_arr_sampling,
            'customer' => $user_arr_customer,
        );
        return $user_data;
    }
    public static function getSampleCountbyid($user_id = NULL)
    {
        if ($user_id == null) {

            $user_arr = DB::table('samples')->count();

            $user_arr_new = DB::table('samples')->where('status', 1)->count();
            $user_arr_sent = DB::table('samples')->where('status', 2)->count();
            $feedback_addedon = DB::table('samples')->where('status', 2)->whereNotNull('feedback_addedon')->count();
        } else {

            $user_arr = DB::table('samples')->where('created_by', $user_id)->count();

            $user_arr_new = DB::table('samples')->where('status', 1)->where('created_by', $user_id)->count();
            $user_arr_sent = DB::table('samples')->where('status', 2)->where('created_by', $user_id)->count();
            $feedback_addedon = DB::table('samples')->where('status', 2)->where('created_by', $user_id)->whereNotNull('feedback_addedon')->count();
        }

        $user_data = array(
            'total' => $user_arr,
            'new' => $user_arr_new,
            'sent' => $user_arr_sent,
            'feedback_addedon' => $feedback_addedon,

        );
        return $user_data;
    }

    public static function getAttr()
    {
        $getAttr = DB::table('bo_attr')->get();
        return $getAttr;
    }
    public static function getCity()
    {
        $getAttr = DB::table('country_cities')->select('id', 'name')->get();
        return $getAttr;
    }
    public static function getCityByID($id)
    {
        $getAttr = DB::table('country_cities')->select('id', 'name')->where('id', $id)->first();
        return $getAttr;
    }
    public static function getCountryByID($id)
    {
        $getAttr = DB::table('countries')->select('id', 'iso_code_3')->where('id', $id)->first();
        return $getAttr;
    }


    //this is used to get name of user
    public static function getEmail($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();

        return (isset($user->email) ? $user->email : '');
    }
    public static function getCompany($user_id)
    {
        $companys = DB::table('client_company')->where('user_id', $user_id)->first();

        return $companys;
    }
    public static function getCourier()
    {
        $getCourier = DB::table('courier')->get();

        return $getCourier;
    }
    public static function getCouriers($id)
    {
        $getCourier = DB::table('courier')->where('id', $id)->first();

        return $getCourier;
    }
    public static function getCouriersBySamnpleid($id)
    {
        $samples = DB::table('samples')->where('id', $id)->first();

        $getCourier = DB::table('courier')->where('id', $samples->courier_details)->first();

        return $getCourier;
    }

    public static function getClientUsers()
    {
        $user = DB::table('users')->where('created_by', Auth::user()->id)->get();

        return $user;
    }


    public static function getSampleCount($userid)
    {
        $user = DB::table('samples')->where('status', '0')->where('created_by', $userid)->get()->toArray();

        return count($user);
    }
    public static function getUserRole($user_id)
    {
        $clients_arr = User::with('roles')->where('is_deleted', 0)->where('id', $user_id)->get();
        return $clients_arr;
    }
    public static function getSalesAgent()
    {
        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Staff")->orwhere("name", "Admin");
        })->get();
        return $clients_arr;
    }
    //get total new verifed claim lead 

    public static function getLeadDuplicateDay($x)
    {
        $user = DB::table('indmt_data')->where('duplicate_lead_status', '1')->whereDate('created_at', $x)->count();
        return $user;
    }
    public static function getLeadPhonePickupDay($x)
    {
        $user = DB::table('indmt_data')->where('call_picked_assined', '1')->whereDate('created_at', $x)->count();
        return $user;
    }
    //$P$Bjc1PkjkKIgaj.MxeCCrvVKmV7dqZC/    
    public static function getLeadNEWByDay($x)
    {
        $user = DB::table('indmt_data')->whereDate('created_at', $x)->count();
        return $user;
    }
    public static function getLeadVerifiedByDay($x)
    {
        $user = DB::table('indmt_data')->where('verified', '1')->whereDate('verified_on', $x)->count();
        return $user;
    }
    public static function getLeadClaimByNEWDay($x)
    {
        $user = DB::table('indmt_data')->where('verified', '1')->whereDate('claim_at', $x)->count();
        return $user;
    }



    //get total new verifed claim lead 
    //getLeadClaimByDayUser
    public static function getLeadClaimByDayUser($x, $userID)
    {


        $user = DB::table('indmt_data')->whereNotNull('claim_by')->where('verified_by', $userID)->where('verified', '1')->whereDate('verified_on', $x)->count();


        return $user;
    }

    //getLeadClaimByDayUser

    //getLeadVerifedByDayUser
    public static function getLeadVerifedByDayUser($x, $userID)
    {


        $user = DB::table('indmt_data')->where('verified_by', $userID)->where('verified', '1')->whereDate('verified_on', $x)->count();


        return $user;
    }

    //getLeadVerifedByDayUser
    //getLeadReportFirsttoYet
    public static function getLeadReportFirsttoYet($start_date, $end_date)
    {

        $leadCount = AyraHelp::getLeadCountBetweenReport($start_date, $end_date);
        $leadCounClaim = AyraHelp::getLeadCountClaimBetweenReport(1, $start_date, $end_date);
        $leadCounQualified = AyraHelp::getLeadCountClaimBetweenReport(2, $start_date, $end_date);
        $leadCounSampling = AyraHelp::getLeadCountClaimBetweenReport(3, $start_date, $end_date);
        $leadCounNegosiation = AyraHelp::getLeadCountClaimBetweenReport(4, $start_date, $end_date);
        $leadCounConverted = AyraHelp::getLeadCountClaimBetweenReport(5, $start_date, $end_date);
        $leadCounLost = AyraHelp::getLeadCountClaimBetweenReport(6, $start_date, $end_date);
        $leadCounHOLD = AyraHelp::getLeadCountClaimBetweenReport(77, $start_date, $end_date);


        $total = $leadCounClaim
            + $leadCounQualified
            + $leadCounSampling
            + $leadCounNegosiation
            + $leadCounConverted
            + $leadCounLost
            + $leadCounHOLD;


        $i = 1;
        $data[] = array(
            'id' => $i,
            'lead_count' => $leadCount,
            'claim_assigned' => $leadCounClaim,
            'qualified' => $leadCounQualified,
            'sampling' => $leadCounSampling,
            'negosiation' => $leadCounNegosiation,
            'converted' => $leadCounConverted,
            'lost' => $leadCounLost,
            'total' => $total,
            'hold' => $leadCounHOLD,
        );


        return $data;
    }

    //getLeadReportFirsttoYet


    //getSalesReportFirsttoYet
    public static function getSalesReportFirsttoYet($start_date, $end_date)
    {
        $data = array();
        $data_userArr = AyraHelp::getSalesAgentAdmin();
        $i = 0;
        // $start_date="2021-02-01";
        // $end_date="2021-02-28";
        //$start_date = date('Y-m-01');
        //$end_date = date("Y-m-t");

        //$start_date = "2021-06-01";
        //$end_date = "2021-06-30";

        foreach ($data_userArr as $key => $rowData) {
            $i++;

            $orderAmt = AyraHelp::getOrderValuesSalesBetweenReport($rowData->id, $start_date, $end_date);
            $paymentAmt = AyraHelp::getPaymentRecievedSalesBetweenReport($rowData->id, $start_date, $end_date);
            $samplesCount = AyraHelp::getSamplesCount($rowData->id, $start_date, $end_date);
            $orderCount = AyraHelp::getOrdersDataCount($rowData->id, $start_date, $end_date);
            $LeadCount = AyraHelp::getLeadAssinedDataCount($rowData->id, $start_date, $end_date);
            $OrderUnit = AyraHelp::getOrderValuesSalesBetweenReportOrderUnit($rowData->id, $start_date, $end_date);
            $OrderBatchSize = AyraHelp::getOrderValuesSalesBetweenReportOrderBatchSize($rowData->id, $start_date, $end_date);


            $data[] = array(
                'id' => $i,
                'name' => ucwords(strtolower($rowData->name)),
                'order' => $orderAmt,
                'payment' => $paymentAmt,
                'sample' => $samplesCount,
                'OrderCount' => $orderCount,
                'LeadCount' => $LeadCount,
                'OrderUnit' => $OrderUnit,
                'OrderBatchSize' => $OrderBatchSize,
            );
        }

        return $data;
    }
    //getSalesReportFirsttoYet


    // getLeadVerifedByDay
    public static function getLeadVerifedByDay($x)
    {


        $user = DB::table('indmt_data')->where('verified', '1')->whereDate('verified_on', $x)->count();


        return $user;
    }

    // getLeadVerifedByDay

    public static function getLeadClaimByDay($x)
    {

        // $user = DB::table('indmt_data')->where('verified', '1')->whereNotNull('claim_by')->whereDate('verified_on', $x)->count();
        $user = DB::table('indmt_data')->whereNotNull('assign_to')->whereDate('assign_on', $x)->count();
        return $user;
    }

    public static function getSalesAgentAdminOK()
    {
        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead");
        })->get();
        return $clients_arr;
    }
    public static function getSalesAgentAdmin()
    {
        $clients_arr = User::where('is_deleted',0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead");
        })->get();
        return $clients_arr;
    }
    public static function getSalesAgentAdminNotDeleted()
    {
        $clients_arr = User::whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead");
        })->get();
        return $clients_arr;
    }
    public static function getSalesAgentAdminWithDeleted()
    {
        $clients_arr = User::whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Admin")->orwhere("name", "SalesHead");
        })->get();
        return $clients_arr;
    }

    public static function getChemist()
    {
        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "chemist");
        })->get();
        return $clients_arr;
    }

    // get total lead claim by sales team in current month 
    // getTotalLeadClaimofCurrentMonth
    public static function getTotalLeadClaimofCurrentMonth($userid, $days)
    {
        // $Lastdays = "-" . $days . " days";
        //$lastDate = date("Y-m-d", strtotime($Lastdays));

        // $QcArr = DB::table('qc_forms')->where('created_by',$userid)->where('is_deleted',0)->whereDate('created_at','>=',$lastDate)->get();
        //  $QcArr = DB::table('qc_forms')->where('created_by', $userid)->where('is_deleted', 0)->whereDate('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->get();
        //$QcArrSH = DB::table('indmt_data')->where('verified_by', 141)->where('claim_by', $userid)->whereDate('claim_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->count();
        //$QcArrSH = DB::table('indmt_data')->where('verified_by', 141)->where('claim_by', $userid)->whereDate('claim_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->count();
        // $QcArrRO = DB::table('indmt_data')->where('verified_by', 134)->where('claim_by', $userid)->whereDate('claim_at', '>=', Carbon::now()->subDays(30))->count();
        // $QcArrSH = DB::table('indmt_data')->where('verified_by', 134)->where('claim_by', $userid)->whereDate('claim_at', '>=', Carbon::now()->subDays(30))->count();

        $QcArrSHAj = DB::table('indmt_data')->where('assign_to', $userid)->whereNotNull('assign_on')->whereDate('assign_on', '>=', Carbon::now()->subDays(30))->count();
        // return ($QcArrRO + $QcArrSH);
        return $QcArrSHAj;
    }

    // getTotalLeadClaimofCurrentMonth

    // get total lead claim by sales team in current month 
    //getTotalAssinedSampleByUserID
    public static function getTotalAssinedSampleByUserID($userid, $days)
    {
        $Lastdays = "-" . $days . " days";
        $lastDate = date("Y-m-d", strtotime($Lastdays));


        // $QcArr = DB::table('qc_forms')->where('created_by',$userid)->where('is_deleted',0)->whereDate('created_at','>=',$lastDate)->get();
        $QcArr = DB::table('samples')->where('assingned_to', $userid)->where('is_deleted', 0)->whereDate('assingned_on', '>=', $lastDate)->count();
        //$QcArr = DB::table('samples')->where('assingned_to', $userid)->where('is_deleted', 0)->count();


        return $QcArr;
    }

    //getTotalAssinedSampleByUserID
    //getHighTotal7DaysCall
    public static function getHighTotal7DaysCall($userid, $days)
    {
        $Lastdays = "-" . $days . " days";
        $lastDate = date("Y-m-d", strtotime($Lastdays));
        if ($days == 7) {
            $agentArr = DB::table('graph_7days')->where('user_id', $userid)->first();
        }
        if ($days == 30) {
            $agentArr = DB::table('graph_30days')->where('user_id', $userid)->first();
        }


        if ($agentArr == null) {
            return 0;
        } else {
            return $agentArr->recieved_call;
        }
    }
    public static function getHighTotal7DaysCall_average_call($userid, $days)
    {
        $Lastdays = "-" . $days . " days";
        $lastDate = date("Y-m-d", strtotime($Lastdays));

        $agentArr = DB::table('graph_7days')->where('user_id', $userid)->first();

        if ($agentArr == null) {
            return 0;
        } else {
            return $agentArr->average_call;
        }
    }
    //getHighTotal7DaysCall

    //order value of last 30 days
    public static function getTotalOrderValueOfDays($userid, $days)
    {
        $Lastdays = "-" . $days . " days";
        $lastDate = date("Y-m-d", strtotime($Lastdays));

        // $QcArr = DB::table('qc_forms')->where('created_by',$userid)->where('is_deleted',0)->whereDate('created_at','>=',$lastDate)->get();
        $QcArr = DB::table('qc_forms')->where('created_by', $userid)->where('is_deleted', 0)->whereDate('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->get();

        $totalVal = 0;
        foreach ($QcArr as $key => $rowData) {
            $qc_from_bulk = $rowData->qc_from_bulk;
            if ($qc_from_bulk == 1) {
                $totalVal = $totalVal + $rowData->bulk_order_value;
            } else {
                $totalVal = $totalVal + ($rowData->item_qty * $rowData->item_sp);
            }
        }
        return $totalVal;
    }
    //order value of last 30 days
    public static function getTotalOrderValueRecievedOfDays($userid, $days)
    {
        $Lastdays = "-" . $days . " days";
        $lastDate = date("Y-m-d", strtotime($Lastdays));

        // $QcArr = DB::table('payment_recieved_from_client')->where('created_by',$userid)->where('is_deleted',0)->whereDate('created_at','>=',$lastDate)->get();
        $QcArr = DB::table('payment_recieved_from_client')->where('payment_status', 1)->where('created_by', $userid)->where('is_deleted', 0)->whereDate('recieved_on', '>=', Carbon::now()->firstOfMonth()->toDateTimeString())->get();

        $totalVal = 0;
        foreach ($QcArr as $key => $rowData) {
            $totalVal = $totalVal + $rowData->rec_amount;
        }
        return $totalVal;
    }



    public static function getSalesAgentOnly()
    {
        $clients_arr = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser");
        })->get();
        return $clients_arr;
    }

    public static function getSalesAgentOnlyWITHSTAFF()
    {
        $clients_arrS = User::where('is_deleted', 0)->whereHas("roles", function ($q) {
            $q->where("name", "SalesUser")->orwhere("name", "Staff");
        })->get();
        return $clients_arrS;
    }

    public static function getAllClients()
    {
        $clients_arr = User::where('is_deleted', '!=', 1)->whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return $clients_arr;
    }
    public static function getClientByAuth()
    {
        $clients_arr = User::where('created_by', Auth::user()->id)->where('is_deleted', '!=', 1)->whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return $clients_arr;
    }
    public static function getSampleIDCode()
    {

        $max_id = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

        $uname = strtoupper(AyraHelp::getUserPrefix(Auth::user()->id));
        $uname = substr($uname, 0, 3);
        $yearDigit = "24";
        $num = $max_id;
        $str_length = 4;
        $sid_code = $uname . "-" . $yearDigit . "-" . substr("0000{$num}", -$str_length);
        return $sid_code;
    }
    public static function getSampleIDCodeBYUserID($user_id)
    {

        $max_id = Sample::where('yr', date('Y'))->where('mo', date('m'))->max('sample_index') + 1;

        $uname = strtoupper(AyraHelp::getUserPrefix($user_id));
        $uname = substr($uname, 0, 3);
        $yearDigit = "24";
        $num = $max_id;
        $str_length = 4;
        $sid_code = $uname . "-" . $yearDigit . "-" . substr("0000{$num}", -$str_length);
        return $sid_code;
    }
    public static function getSamples($id)
    {
        $sample = DB::table('samples')->where('id', $id)->get();
        return $sample;
    }
    public static function getTotalRequestFor()
    {
        $users_arr = User::where('is_deleted', '!=', 0)->whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->count();
        return $users_arr;
    }



    //this function is used to get baseurl and route path
    public static function getBaseURL()
    {
        return url('/');
    }
    public static function getRouteName()
    {
        $route_arr = explode(url('/') . "/", url()->current());
        if (array_key_exists(1, $route_arr)) {
            return $route_arr[1];
        }
    }
}
