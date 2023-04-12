<?php

namespace App\Http\Controllers;

use App\RawClientData;
use Illuminate\Http\Request;
use Theme;
use App\User;
use App\Sample;
use App\Company;
use App\Client;
use App\RowClient;

use App\ContactClient;
use Auth;
use App\Helpers\AyraHelp;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Imports\ItemImport;
use App\Imports\ItemImportAttendance;
use DB;
use App\Imports\OrderImport;

use App\Exports\UsersRawExport;
use App\Exports\UsersRawExportAttendance;

// include 'class-list-util.php';
use Maatwebsite\Excel\Facades\Excel;
class RawClientDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $theme = Theme::uses('corex')->layout('layout');
      $users = User::orderby('id', 'desc')->get();
      $data = ['users' =>$users];
      return $theme->scope('rawclientdata.index', $data)->render();

    }
    public function importAttendance(Request $request){
      $validatedData = $request->validate([
        'file' => 'required',
       


    ]);
     DB::table('demo_attn')->truncate();  

  Excel::import(new ItemImportAttendance,request()->file('file'));
 // AyraHelp::getAttenDemo(); //this function is user to filter to table: demo_attn
  //AyraHelp::setAttenRowBind();//this function save data to emp_attendance_data
  
  DB::table('bo_settings')
  ->where('id', 1)
  ->update(['atten_upload_flag' => 1]);


  return back();


    }
    public function importData(Request $request){
      $validatedData = $request->validate([
        'file' => 'required',

    ]);

  Excel::import(new ItemImport,request()->file('file'));
  return back();

    }
    public function import(Request $request){
      $validatedData = $request->validate([
              'file' => 'required',

          ]);

        Excel::import(new UsersImport,request()->file('file'));
        return back();

    }
    public function importOrder(Request $request){
      $validatedData = $request->validate([
              'file' => 'required',

          ]);

        Excel::import(new OrderImport,request()->file('file'));
        return back();

    }


    

    public function export()

    {
      
        return Excel::download(new UsersExport, 'users.xlsx');
       

    }
    public function export_sample()

    {

        return Excel::download(new UsersRawExport, 'rawsample.xlsx');

    }
    public function export_sample_attendace()

    {

        return Excel::download(new UsersRawExportAttendance, 'rawsampleAttendance.xlsx');

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
     * @param  \App\RawClientData  $rawClientData
     * @return \Illuminate\Http\Response
     */
    public function show(RawClientData $rawClientData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawClientData  $rawClientData
     * @return \Illuminate\Http\Response
     */
    public function edit(RawClientData $rawClientData,$id)
    {

      $theme = Theme::uses('corex')->layout('layout');
      $users = User::orderby('id', 'desc')->get();
      $raw_data = $rawClientData::where('id',$id)->first();
      $data = ['raw_data' =>$raw_data];
      return $theme->scope('rawclientdata.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawClientData  $rawClientData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawClientData $rawClientData)
    {
        RawClientData::where('id', $request->rowid)

          ->update([
            'product' => $request->product,
            'company_name' => $request->company,
            'location' => $request->location,
            'contact_no' => $request->contact,
            'website' => $request->website,
            'application' => $request->application,
            'group_status' => $request->group_status,
            ]);
            $data = array(
              'status' => '1',
              'message' => 'updated successfully',
             );
            return response()->json($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawClientData  $rawClientData
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawClientData $rawClientData,$id)
    {

      $rowdata_arr =RawClientData::find($id);
      $rowdata_arr->delete();
      $data = array(
        'status' => '1',
        'message' => 'Deleted successfully',
       );

    return response()->json($data);





    }

    //datatable



public function getRawClientData(){
  $user = auth()->user();
  $userRoles = $user->getRoleNames();
  $user_role = $userRoles[0];
  if($user_role=='Admin' || $user_role=='Staff'){
  $p_edit=1;
  $p_delete=1;
  }else{
   $p_edit=0;
   $p_delete=0;
  }
$rowdata=RawClientData::get();
$i=0;
foreach ($rowdata as $key => $value) {
  $i++;
  $rowdata_arrr[] = array(
    'RecordID' => $i,
    'rowid' => $value->id,
    'product' => $value->product ,
    'location' => $value->location ,
    'company' => $value->company_name ,
    'contact' => $value->contact_no ,
    'website' => $value->website ,
    'application' => $value->application ,
    'Status' => $value->group_status ,
    'p_edit' => $p_edit ,
    'p_delete' => $p_delete ,
    'Actions' => null ,
  );
}



$JSON_Data =json_encode($rowdata_arrr);

$columnsDefault = [
  'RecordID'     => true,
  'company'      => true,
  'location'      => true,
  'rowid'      => true,
  'product'      => true,
  'contact'     => true,
  'website'     => true,
  'application'     => true,
  'Status' =>true,
  'p_edit' =>true,
  'p_delete' =>true,
  'Actions'      => true,
];

$this->DataGridResponse($JSON_Data,$columnsDefault);
    //datatable
}



}
