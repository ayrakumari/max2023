<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Client;
use App\OrderItemMaterial;
use App\PurchaseOrders;
use App\ItemMaster;
use App\ItemMasterType;
use App\PurchaseItemRequest;
use App\PurchaseItemRequested;
use App\PurchaseItemGroup;


use App\Item;
use App\ItemStock;
use App\ItemCat;
use App\ItemStockEntry;
use Auth;
use App\Helpers\AyraHelp;
use Theme;
use DB;

class PurchaseController extends Controller
{
    //4799320579000836



    /*
|--------------------------------------------------------------------------
| function name:purchaseList
|--------------------------------------------------------------------------
| this function is show the list of purchased order that is revied too
*/
    public function purchaseList()
    {
        $theme = Theme::uses('corex')->layout('layout');

        $data = [
            'data' => ''

        ];
        return $theme->scope('purchase.purchase_list', $data)->render();
    }
    public function purchaseListPrintedBOx()
    {
        $theme = Theme::uses('corex')->layout('layout');

        $data = [
            'data' => ''

        ];
        return $theme->scope('purchase.purchase_listPrintedBox', $data)->render();
    }


    /*
|--------------------------------------------------------------------------
| function name:getPurchaseOrderData
|--------------------------------------------------------------------------
| this function is used to get purchse order data by pid
*/
    public function getPurchaseOrderData(Request $request)
    {

        $purchasecheck = PurchaseOrders::where('p_order_id', $request->pid)->first();
        if ($purchasecheck != null) {
            $res_arr = array(
                'status' => 1,
                'data' => $purchasecheck,
                'Message' => 'Purchase Order  list created successfully.',
            );
        } else {
            $res_arr = array(
                'status' => 0,
                'data' => '',
                'Message' => 'not found.',
            );
        }




        return response()->json($res_arr);
    }

    /*
|--------------------------------------------------------------------------
| function name:getPurchasedOrderedlist
|--------------------------------------------------------------------------
| this function is used to show the list of purchase ordeded 
*/
    public function getPurchasedOrderedlist(Request $request)
    {

        $item_arr = PurchaseOrders::where('status', 1)->get();
        $data_arr = array();

        foreach ($item_arr as $key => $value) {

            $item_arr_all = AyraHelp::getItemsbyItemID($value->item_id);
            $created_at = date('j M Y', strtotime($value->created_at));
            $vendor_arr = AyraHelp::getVendors($value->ven_id);
            $data_arr[] = array(
                'RecordID' => $value->id,
                'pid' => $value->p_order_id,
                'vendor_name' => $vendor_arr->vendor_name . " ( " . $vendor_arr->phone . " )",
                'item_code' => $value->item_code,
                'item_name' => $value->item_name,
                'qty' => $value->item_qty,
                'due_date' => 'ASAP',
                'created_at' => $created_at,
                'Status' => $value->status,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,

            'pid'      => true,
            'item_code'      => true,
            'vendor_name'      => true,
            'item_name'      => true,
            'qty'  => true,
            'due_date'      => true,
            'created_at'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    /*
|--------------------------------------------------------------------------
| function name:purchasedOrdersList
|--------------------------------------------------------------------------
| this function is used to show the list of purchase orded placed layout
*/
    public function purchasedOrdersList()
    {
        $theme = Theme::uses('corex')->layout('layout');

        $data = [
            'data' => ''

        ];
        return $theme->scope('purchase.purchased_order_list', $data)->render();
    }


    /*
|--------------------------------------------------------------------------
| function name:savePurchaseOrder
|--------------------------------------------------------------------------
| this function is used to save data in purchase_orders tables
*/
    public function savePurchaseOrder(Request $request)
    {
        // $created_at=date('j M Y', strtotime($value->created_at));
        //$created_by=AyraHelp::getUserName();
        $max_id = PurchaseOrders::max('purchase_index') + 1;
        $pur_obj = new PurchaseOrders;
        $pur_obj->ven_id = $request->vendor_id;
        $pur_obj->p_order_id = $request->pid;
        $pur_obj->purchase_index = $max_id;
        $pur_obj->item_code = $request->item_code;
        $pur_obj->item_name = $request->item_name;
        $pur_obj->item_qty = $request->qty;
        $pur_obj->status = 1;
        // $pur_obj->created_at=$created_at;
        $pur_obj->created_by = Auth::user()->id;
        $pur_obj->save();
        //consolidate update status 


        //indiviula update order
        PurchaseItemRequested::where('item_id', $request->item_code)->where('status', 2)
            ->update(['status' => 1, 'pid' => $request->pid]);



        $res_arr = array(
            'status' => 1,
            'Message' => 'Purchase Order created successfully.',
        );

        return response()->json($res_arr);
    }


    /*
|--------------------------------------------------------------------------
| function name:createPurchaseOrder
|--------------------------------------------------------------------------
| this function is used to show  to purchase Layout
*/
    public function createPurchaseOrder($item_id)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $item_arr_data = DB::table('purchased_items_request')
            ->select('item_id', DB::raw('SUM(qty) as sum'))
            ->groupBy('item_id')
            ->where('status', 2)
            ->where('item_id', $item_id)
            ->where('recieved_status', 1)
            ->first();
        $item_arr_all = AyraHelp::getItemsbyItemID($item_id);
        //again check that it is less orer so need puchase again.

        if (!empty($item_arr_data)) {
            $data_arr = (object) array(
                'item_id' => $item_arr_data->item_id,
                'item_name' => $item_arr_all->item_name,
                'qty' => $item_arr_data->sum,

            );
        } else {
            $POrder_arr = PurchaseOrders::where('status', 2)->where('item_code', $item_id)->get();

            foreach ($POrder_arr as $key => $porderVal) {

                if ($porderVal->item_qty > $porderVal->rec_qty) {
                    //make another request 
                    $item_id = $porderVal->item_code;
                    $qty = $porderVal->item_qty; //required qty
                    $availale_flag = AyraHelp::StockAvailabilitywithItemIDQTY($item_id, $qty);
                    if ($availale_flag == "2") { //2 =not availne 1=availe in stock

                        $item_arr_all_data = AyraHelp::getItemsbyItemID($item_id);
                        $qty_next = ($porderVal->item_qty) - ($porderVal->rec_qty);
                        $data_arr = (object) array(
                            'item_id' => $item_id,
                            'item_name' => $item_arr_all_data->item_name,
                            'qty' => $qty_next,

                        );
                    }
                }
            }
        }







        $data = [
            'data' => $data_arr

        ];

        return $theme->scope('purchase.create_purchase_order', $data)->render();
    }
    /*
|--------------------------------------------------------------------------
| function name:getPurchaseRequestGroupTotal
|--------------------------------------------------------------------------
| this function is used to show list of purchae request as api
*/

    public function getPurchaseRequestGroupTotal(Request $request)
    {
        //case 1: status =2: 
        //case 2: checked status =1 ordered and recived =2  then check qty is avaible or not
        // if not then then make again list to purchase 


        $data_arr = array();
        $data_arr_1 = array();
        $data_arr_2 = array();

        $item_arr_data = DB::table('purchased_items_request')
            ->select('item_id', DB::raw('SUM(qty) as sum'))
            ->groupBy('item_id')
            ->where('status', 2)
            ->where('recieved_status', 1)
            ->get();
        $i = 0;

        foreach ($item_arr_data as $key => $value) {
            $i++;
            $item_id = $value->item_id;
            $sum_qty = $value->sum;
            $item_arr_all = AyraHelp::getItemsbyItemID($item_id);


            $data_arr_1[] = array(
                'RecordID' => $i,
                'item_cat' => $item_arr_all->cat_id,
                'item_code' => $item_id,
                'item_name' => $item_arr_all->item_name,
                'qty' => $sum_qty,
                'due_date' => 'ASAP',
                'Status' => 2,
                'Actions' => ""
            );
        }

        // //case 2: checked status =1 ordered and recived =2  then check qty is avaible or not
        // if not then then make again list to purchase 
        $POrder_arr = PurchaseOrders::where('status', 2)->get();
        $j = 0;
        foreach ($POrder_arr as $key => $porderVal) {

            if ($porderVal->item_qty > $porderVal->rec_qty) {
                //make another request 
                $item_id = $porderVal->item_code;
                $qty = $porderVal->item_qty; //required qty
                $availale_flag = AyraHelp::StockAvailabilitywithItemIDQTY($item_id, $qty);
                if ($availale_flag == "2") { //2 =not availne 1=availe in stock
                    $j++;
                    $item_arr_all_data = AyraHelp::getItemsbyItemID($item_id);
                    $qty_next = ($porderVal->item_qty) - ($porderVal->rec_qty);
                    $data_arr_2[] = array(
                        'RecordID' => $j,
                        'item_cat' => $item_arr_all_data->cat_id,
                        'item_code' => $item_id,
                        'item_name' => $item_arr_all_data->item_name,
                        'qty' => $qty_next,
                        'due_date' => 'ASAP',
                        'Status' => 2,
                        'Actions' => ""
                    );
                }





                //now check stock that this item is avalnle or not if not then make order to purchase.


            }
        }


        $data_arr = array_merge($data_arr_1, $data_arr_2);

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'item_code'      => true,
            'item_cat'      => true,
            'item_name'      => true,
            'qty'  => true,
            'due_date'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    public function getPurchaseRequestGroupTotal__(Request $request)
    {
        //case 1: status =2: 
        //case 2: checked status =1 ordered and recived =2  then check qty is avaible or not
        // if not then then make again list to purchase 


        $data_arr = array();
        $item_arr_data = DB::table('purchased_items_request')
            ->select('item_id', DB::raw('SUM(qty) as sum'))
            ->groupBy('item_id')
            ->where('status', 2)
            ->where('recieved_status', 1)
            ->get();
        $i = 0;

        foreach ($item_arr_data as $key => $value) {
            $i++;
            $item_id = $value->item_id;
            $sum_qty = $value->sum;
            $item_arr_all = AyraHelp::getItemsbyItemID($item_id);

            $data_arr[] = array(
                'RecordID' => $i,
                'item_code' => $item_id,
                'item_name' => $item_arr_all->item_name,
                'qty' => $sum_qty,
                'due_date' => 'ASAP',
                'Status' => 2,
                'Actions' => ""
            );
        }
        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'item_code'      => true,
            'item_name'      => true,
            'qty'  => true,
            'due_date'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    /*
|--------------------------------------------------------------------------
| function name:getPurchaseRequestAlert
|--------------------------------------------------------------------------
| this function is used to show list of purchae request as api
*/
    public function getPurchaseRequestAlert(Request $request)
    {
        $item_arr = PurchaseItemRequested::where('status', 2)->where('recieved_status', 1)->get(); //get who is requested not recived yet    
        $data_arr = array();
        foreach ($item_arr as $key => $value) {

            $item_arr = AyraHelp::getItemsbyItemID($value->item_id);

            $created_by = AyraHelp::getUserName($value->created_by);
            $req_date = date('j M Y', strtotime($value->created_at));
            $due_date = date('j M Y', strtotime($value->created_at));
            $due_date = "---";

            $data_arr[] = array(
                'RecordID' => $value->id,
                'order_id' => $value->order_id,
                'order_sub_id' => $value->order_sub_id,
                'item_code' => $value->item_id,
                'item_name' => $item_arr->item_name,
                'qty' => $value->qty,
                'req_on' => $req_date,
                'due_date' => $due_date,
                'req_by' => $created_by,
                'Status' => $value->status,
                'Actions' => ""
            );
        }
        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'req_on'      => true,
            'order_id'      => true,
            'order_sub_id'      => true,
            'item_code'      => true,
            'item_name'      => true,
            'qty'  => true,
            'req_by'      => true,
            'due_date'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    public function getPurchaseRequestAlert_(Request $request)
    {
        $item_arr = ItemStockEntry::where('purchase_reserve_flag', 2)->get();

        $data_arr = array();

        foreach ($item_arr as $key => $value) {

            $item_arr = AyraHelp::getItemsbyItemID($value->item_id);

            $created_by = AyraHelp::getUserName($value->created_by);
            $req_date = date('j M Y', strtotime($value->created_at));
            $due_date = date('j M Y', strtotime($value->created_at));
            $due_date = "???";

            $data_arr[] = array(
                'RecordID' => $value->id,
                'item_code' => $value->item_id,
                'item_name' => $item_arr->item_name,
                'qty' => $value->qty,
                'req_on' => $req_date,
                'due_date' => $due_date,
                'req_by' => $created_by,
                'Status' => 1,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'req_on'      => true,
            'item_code'      => true,
            'item_name'      => true,
            'qty'  => true,
            'req_by'      => true,
            'due_date'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
    /*
|--------------------------------------------------------------------------
| function name:purchaseReqAlert
|--------------------------------------------------------------------------
| this function is used to show list of purchase request alert layout
*/
    public function purchaseReqAlert(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'users_data' => ''

        ];
        return $theme->scope('purchase.purchase_request_list', $data)->render();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
