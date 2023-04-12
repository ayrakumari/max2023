<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use App\User;
use App\Vendors;
use Auth;

class VendorController extends Controller
{


    //getVendorList
    /*
|--------------------------------------------------------------------------
| function name:getVendorList
|--------------------------------------------------------------------------
| this function is used to  get vendors list
*/



    public function getVendorList(Request $request)
    {

        $item_arr = Vendors::get();

        $data_arr = array();

        foreach ($item_arr as $key => $value) {


            $data_arr[] = array(
                'RecordID' => $value->id,
                'vendor_id' => $value->vendor_id,
                'vendor_name' => $value->vendor_name,
                'branch' => $value->branch,
                'name' => $value->name,
                'phone' => $value->phone,
                'email' => $value->email,
                'Actions' => ""
            );
        }

        $JSON_Data = json_encode($data_arr);
        $columnsDefault = [
            'RecordID'     => true,
            'vendor_id'      => true,
            'vendor_name'      => true,
            'branch'      => true,
            'name'      => true,
            'phone'  => true,
            'email'  => true,
            'Actions'      => true,
        ];

        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        return $theme->scope('vendors.index', $data)->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme = Theme::uses('corex')->layout('layout');
        // $max_id = Sample::max('sample_index')+1;
        $data = [
            'users' => '$users',
            'sample_id' => ''
        ];
        return $theme->scope('vendors.create', $data)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $max_id = Vendors::max('id') + 1;
        $num = $max_id;
        $str_length = 4;
        $vendor_id = "VN-" . substr("0000{$num}", -$str_length);

        $vendor = new Vendors;
        $vendor->vendor_id = $vendor_id;
        $vendor->vendor_name = $request->vendor_name;
        $vendor->branch = $request->vendor_branch;
        $vendor->phone = $request->phone;
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->address_1 = $request->address;
        $vendor->city = $request->location;
        $vendor->vendor_remarks = $request->remarks;
        $vendor->created_by = Auth::user()->id;
        $vendor->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $vendor_arr = Vendors::where('id', $id)->first();
        $data = [
            'users' => '$users',
            'vendor_data' => $vendor_arr
        ];
        return $theme->scope('vendors.edit', $data)->render();
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


        Vendors::where('id', $id)
            ->update([
                'vendor_name' => $request->vendor_name,
                'branch' => $request->vendor_branch,
                'phone' => $request->phone,
                'name' => $request->name,
                'email' => $request->email,
                'address_1' => $request->address,
                'city' => $request->location,
                'vendor_remarks' => $request->remarks,
            ]);
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
