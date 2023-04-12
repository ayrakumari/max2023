<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Client;
use App\OrderItemMaterial;
use App\ItemMaster;
use App\ItemMasterType;
use App\ItemRecievedOrders;
use App\PurchaseOrders;
use App\ItemStockReserved;
use App\Item;
use App\ItemStock;
use App\ItemStockEntry;
use App\ItemStockIssue;
use Auth;
use App\Helpers\AyraHelp;
use Illuminate\Http\Request;
use Theme;

class StockController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }
    /*
|--------------------------------------------------------------------------
| function name:deleteItems
|--------------------------------------------------------------------------
| this function is used to  delete items form items and stock entry too
*/
    public function deleteItems(Request $request)
    {
        print_r($request->all());
    }

    /*
|--------------------------------------------------------------------------
| function name:getStocks
|--------------------------------------------------------------------------
| this function is used to  show stock information
*/
    public function getStocks(Request $request)
    {

        $item_arr = ItemStock::get();

        $data_arr = array();

        foreach ($item_arr as $key => $value) {

            $item_arr_data = AyraHelp::getItemsbyItemID($value->item_id);
            $cat_arr = AyraHelp::getItemCategory($item_arr_data->cat_id);
            $data_arr[] = array(
                'RecordID' => $value->id,
                'item_code' => $value->item_id,
                'item_cat' => $cat_arr[0]->cat_name,
                'item_name' => $item_arr_data->item_name,
                'item_short_name' => $item_arr_data->item_short_name,
                'qty' => $value->qty,
                'unit' => $item_arr_data->item_unit,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'item_code'      => true,
            'item_cat'      => true,
            'item_name'      => true,
            'item_short_name'  => true,
            'qty'  => true,
            'unit'  => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    /*
|--------------------------------------------------------------------------
| function name:saveStockItems
|--------------------------------------------------------------------------
| this function is used to  save data in items with by generation item code too now
*/
    public function saveStockItems(Request $request)
    {

        $max_id = Item::max('item_index') + 1;
        $num = $max_id;
        $str_length = 4;
        $item_code = "BOI-" . substr("0000{$num}", -$str_length);
        $itemcheck = Item::where('item_name', $request->itemName)->first();
        if ($itemcheck == null) {
            $itemobj = new Item;
            $itemobj->item_index = $max_id;
            $itemobj->item_id = $item_code;
            $itemobj->cat_id = $request->catName;
            $itemobj->item_name = $request->itemName;
            $itemobj->item_discription = '';
            $itemobj->item_short_name = $request->shortName;
            $itemobj->created_by = Auth::user()->id;
            $itemobj->item_unit = $request->unitName;
            $itemobj->save();

            $itemobj = new ItemStock;
            $itemobj->item_id = $item_code;
            $itemobj->qty = $request->stock_qty;
            $itemobj->save();
            $data = array(
                'status' => '1',
                'message' => 'Item saved Succfully',
            );
        } else {
            $data = array(
                'status' => '1',
                'message' => 'Item Already Succfully',
            );
        }


        return response()->json($data);
    }

    /*
|--------------------------------------------------------------------------
| function name:StockEntry
|--------------------------------------------------------------------------
| this function is used to  show the form to stock entry
*/

    public function StockEntry(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');

        $data = [
            'data' => ''

        ];
        return $theme->scope('stocks.stock_entry', $data)->render();
    }

    /*
|--------------------------------------------------------------------------
| function name:IssueNowItems
|--------------------------------------------------------------------------
| this function is used to  issue items 
| after issue update status 3 in stock entry and add log to item_stock_issue
*/
    public function IssueNowItems(Request $request)
    {
        //print_r($request->all());
        $rowid = $request->rowid;
        ItemStockReserved::where('id', $rowid)->update(['issue_status' => 2]);
        $stock_arr = ItemStockReserved::where('id', $rowid)->first();
        $itemStockIssue = new ItemStockIssue;
        $itemStockIssue->order_index = $stock_arr->order_id;
        $itemStockIssue->product_id = 1; //this dummy now
        $itemStockIssue->item_id = $stock_arr->item_id;
        $itemStockIssue->qty = $stock_arr->qty;
        $itemStockIssue->created_by = Auth::user()->id;
        $itemStockIssue->save();
        $data = array(
            'status' => '1',
            'message' => 'Item Reserved Successfully',
        );
        return response()->json($data);
    }

    /*
|--------------------------------------------------------------------------
| function name:reservedNowItems
|--------------------------------------------------------------------------
| this function is used to  to reserved items .
| if reserved and unreserd then stock plus and minus
*/
    public function reservedNowItems(Request $request)
    {
        $rowid = $request->rowid;
        $itemstockEntrycheck = ItemStockEntry::where('id', $rowid)->first();
        if ($itemstockEntrycheck != null) {
            $item_arr =  AyraHelp::getItemsbyItemID($itemstockEntrycheck->item_id);

            $itemSEntry = new ItemStockReserved;
            $itemSEntry->order_id = 11;
            $itemSEntry->item_id = $itemstockEntrycheck->item_id;
            $itemSEntry->item_name = $item_arr->item_name;
            $itemSEntry->qty = $itemstockEntrycheck->qty;
            $itemSEntry->created_by = Auth::user()->id;
            $itemSEntry->status = 2;
            $itemSEntry->issue_status = 1;

            $itemSEntry->save();
        }
        $data = array(
            'status' => '1',
            'message' => 'Item Reserved Succfully',
        );
        return response()->json($data);
    }

    /*
|--------------------------------------------------------------------------
| function name:recievedPendingOrders
|--------------------------------------------------------------------------
| this function is used to  to show layotu to recice orders
*/
    public function recievedPendingOrders($id)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $purchase_arr = PurchaseOrders::where('id', $id)->first();
        $data = [
            'data' => $purchase_arr

        ];
        return $theme->scope('stocks.revieved_ordersEntry_by_id', $data)->render();
    }

    /*
|--------------------------------------------------------------------------
| function name:getRecievedOrdersListNew
|--------------------------------------------------------------------------
| this function is used to show data in datalist of pending order list with entry too
*/
    public function getRecievedOrdersListNew(Request $request)
    {


        $item_arr = PurchaseOrders::where('status', 1)->get();

        $data_arr = array();

        foreach ($item_arr as $key => $value) {

            $item_arr = AyraHelp::getItemsbyItemID($value->item_code);




            if (isset($value->recived_on)) {
                $recived_on = date('j M Y', strtotime($value->recived_on));
            } else {
                $recived_on = "";
            }
            if (isset($value->recived_by)) {
                $created_by = AyraHelp::getUserName($value->recived_by);
            } else {
                $created_by = "";
            }




            $req_date = date('j M Y', strtotime($value->created_at));



            $due_date = "???";
            $vendor_arr = AyraHelp::getVendors($value->ven_id);
            $data_arr[] = array(
                'RecordID' => $value->id,
                'pid' => $value->p_order_id,
                'vendor_name' => $vendor_arr->vendor_name . " ( " . $vendor_arr->phone . " )",
                'item_code' => $value->item_code,
                'item_name' => $item_arr->item_name,
                'qty' => $value->item_qty,
                'rec_qty' => $value->rec_qty,
                'recieved_on' => $recived_on,
                'recieved_by' => $created_by,
                'Status' => $value->status,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'pid'      => true,
            'vendor_name'      => true,
            'item_code'      => true,
            'item_name'      => true,
            'qty'  => true,
            'rec_qty'  => true,
            'recieved_on'      => true,
            'recieved_by'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    /*
|--------------------------------------------------------------------------
| function name:saveRecievedPurchaseOrder
|--------------------------------------------------------------------------
| this function is used to save purchsase orders
*/


    public function saveRecievedPurchaseOrder(Request $request)
    {

        $purchasecheck = PurchaseOrders::where('p_order_id', $request->pid)->first();
        if ($purchasecheck != null) {

            PurchaseOrders::where('p_order_id', $request->pid)
                ->update([
                    'status' => 2,
                    'rec_qty' => $request->rec_qty,
                    'rec_remarks' => $request->rec_remarks,
                    'recived_on' => date('Y-m-d H:i:s'),
                    'recived_by' => Auth::user()->id,
                    'invoice_no' => $request->invoice_no,

                ]);
            ItemStock::where('item_id', $purchasecheck->item_code)->increment('qty', $request->rec_qty);
        } else {
            echo "alredy entered";
        }
    }


    public function saveRecievedPurchaseOrder_(Request $request)
    {

        $purchasecheck = PurchaseOrders::where('p_order_id', $request->pid)->first();
        if ($purchasecheck != null) {
            $purchasRececheck = ItemRecievedOrders::where('p_order_id', $request->pid)->first();
            if ($purchasRececheck == null) {
                $itemSEntry = new ItemRecievedOrders;
                $itemSEntry->p_order_id = $purchasecheck->p_order_id;
                $itemSEntry->ven_id = $purchasecheck->ven_id;
                $itemSEntry->item_code = $purchasecheck->item_code;
                $itemSEntry->item_name = $purchasecheck->item_name;
                $itemSEntry->item_qty = $purchasecheck->item_qty;
                $itemSEntry->rec_qty = $request->rec_qty;
                $itemSEntry->rec_remarks = $request->rec_remarks;
                $itemSEntry->status = 2;
                $itemSEntry->created_by = Auth::user()->id;
                $itemSEntry->save();
                PurchaseOrders::where('p_order_id', $purchasecheck->p_order_id)
                    ->update([
                        'status' => 2,
                        'rec_qty' => $request->rec_qty,
                        'rec_remarks' => $request->rec_remarks,
                        'recived_on' => date('Y-m-d H:i:s'),
                        'recived_by' => Auth::user()->id,
                        'status' => 2,
                        'status' => 2,
                        'status' => 2,

                    ]);
                ItemStock::where('item_id', $purchasecheck->item_code)->increment('qty', $request->rec_qty);
            } else {
                echo "alredy entered";
            }
        }
    }


    /*
|--------------------------------------------------------------------------
| function name:ordersRecieved
|--------------------------------------------------------------------------
| this function is used to recieved orders
*/
    public function ordersRecieved()
    {
        $theme = Theme::uses('corex')->layout('layout');

        $data = [
            'data' => ''

        ];
        return $theme->scope('stocks.revieved_ordersEntry', $data)->render();
    }


    /*
|--------------------------------------------------------------------------
| function name:getRecievedOrders
|--------------------------------------------------------------------------
| this function is used to get the lists of recvied items
*/

    public function getRecievedOrders(Request $request)
    {


        $item_arr = ItemRecievedOrders::where('status', 2)->get();

        $data_arr = array();

        foreach ($item_arr as $key => $value) {

            $item_arr = AyraHelp::getItemsbyItemID($value->item_code);

            $created_by = AyraHelp::getUserName($value->created_by);
            $req_date = date('j M Y', strtotime($value->created_at));
            $recived_on = date('j M Y', strtotime($value->recived_on));
            $due_date = "???";
            $vendor_arr = AyraHelp::getVendors($value->ven_id);
            $data_arr[] = array(
                'RecordID' => $value->id,
                'pid' => $value->p_order_id,
                'vendor_name' => $vendor_arr->vendor_name . " ( " . $vendor_arr->phone . " )",
                'item_code' => $value->item_code,
                'item_name' => $item_arr->item_name,
                'qty' => $value->item_qty,
                'rec_qty' => $value->rec_qty,
                'recieved_on' => $recived_on,
                'recieved_by' => $created_by,
                'Status' => $value->status,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'pid'      => true,
            'vendor_name'      => true,
            'item_code'      => true,
            'item_name'      => true,
            'qty'  => true,
            'rec_qty'  => true,
            'recieved_on'      => true,
            'recieved_by'      => true,
            'Status'      => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }

    /*
|--------------------------------------------------------------------------
| function name:recievedOrders
|--------------------------------------------------------------------------
| this function is used to recievedOrders Layout
*/
    public function recievedOrders(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'users_data' => ''

        ];
        return $theme->scope('stocks.recieved_orders', $data)->render();
    }
    /*
|--------------------------------------------------------------------------
| function name:getRequestedItems
|--------------------------------------------------------------------------
| this function is used to get the list of  requested items to rerserved
*/
    public function getRequestedItems(Request $request)
    {

        $item_arr = ItemStockReserved::where('issue_status', 1)->get();
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
                'item_code' => $value->item_id,
                'item_code' => $value->item_id,
                'item_name' => $value->item_name,
                'qty' => $value->qty,
                'req_on' => $req_date,
                'due_date' => $due_date,
                'req_by' => $created_by,
                'Status' => $value->issue_status,
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
| function name:stockReqAlert
|--------------------------------------------------------------------------
| this function is used to show list of purchase request alert layout
*/
    public function stockReqAlert(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $data = [
            'users_data' => ''

        ];
        return $theme->scope('stocks.stock_request_list', $data)->render();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $theme = Theme::uses('corex')->layout('layout');
        $items_arr = Item::get();


        foreach ($items_arr as $key => $value) {

            $item_arr = AyraHelp::getItemsbyItemID($value->item_id);
            $itemstock_arr = AyraHelp::getStockBYItemID($value->item_id);
            $itemstockEntry_arr = AyraHelp::getStockReservedByID($value->item_id);



            $itemcat_arr = AyraHelp::getItemCatbyItemID($value->cat_id);

            $data_arr[] = array(
                'id' => $value->id,
                'rowid' => $value->id,
                'item_id' => isset($item_arr->item_id) ? $item_arr->item_id : "",
                'item_cat' => isset($itemcat_arr->cat_name) ? $itemcat_arr->cat_name : "",
                'item_name' => isset($item_arr->item_name) ? $item_arr->item_name : "",
                'item_discrption' => isset($item_arr->item_discription) ? $item_arr->item_discription : "",
                'stock_in' => isset($itemstock_arr->qty) ? $itemstock_arr->qty : "",
                'reserved_in' => isset($itemstockEntry_arr) ? $itemstockEntry_arr : "",
                'stock_minLevel' => isset($itemstock_arr->min_qty_level) ? $itemstock_arr->min_qty_level : "",


                'Actions' => ""
            );
        }



        $data = [
            'data' => $data_arr,
        ];
        return $theme->scope('stocks.index', $data)->render();
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
            'data' => ''

        ];
        return $theme->scope('stocks.stock_entry', $data)->render();
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
