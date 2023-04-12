<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Theme;
use App\Helpers\AyraHelp;
use App\NPD_Data;
use DB;
use PDF;
use Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class RNDController extends Controller
{

  public function getFPData(Request $request)
  {

    $FPData = DB::table('client_quatation_data')->distinct('item_name')->get();
    $fp_data = array();
    foreach ($FPData as $key => $row) {

      $fp_data[] = ucwords(strtolower($row->item_name));
    }
    return response()->json($fp_data);
  }
  public function getFPData_(Request $request)
  {

    $FPData = DB::table('rnd_finish_products')->get();
    $fp_data = array();
    foreach ($FPData as $key => $row) {

      $fp_data[] = ucwords(strtolower($row->product_name)) . " (" . $row->sap_code . ")";
    }
    return response()->json($fp_data);
  }

  public function getFinishProductDataList(Request $request)
  {



    $FPData = DB::table('rnd_finish_products')->where('id', $request->FPID)->first();




    $HTML = '<!--begin::Section-->
    <div class="m-section">
      <div class="m-section__content">
        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
          <thead>
            <tr >               
              <th colspan="3">Finish Product Information</th>
            </tr>
          </thead>
          <tbody>';
    $i = 0;






    $HTML .= '
            <tr>
              <th scope="row">1</th>
              <td>Product Name:</td>
              <td>' . ucwords(strtolower($FPData->product_name)) . '</td>
              
            </tr>';
    $fp_arr = AyraHelp::getFinishPSubCatDetail($FPData->cat_id);
    $fp_arr_data = AyraHelp::getFinishPCatDetail($fp_arr->cat_id);





    $HTML .= '
            <tr>
              <th scope="row">2</th>
              <td>Product Category:</td>
              <td>' . optional($fp_arr_data)->cat_name . '</td>
              
            </tr>';


    $HTML .= '
            <tr>
              <th scope="row">3</th>
              <td>Product Sub Category:</td>
              <td>' . optional($fp_arr)->sub_cat_name . '</td>
              
            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">4</th>
              <td>Ingredent Details:</td>
              <td>' . ucwords(strtolower(optional($FPData)->ingredents_details)) . '</td>
              
            </tr>';
    $pR = ucwords(strtolower(optional($FPData)->sp_min)) . "-" . ucwords(strtolower(optional($FPData)->sp_max));

    $HTML .= '
            <tr>
              <th scope="row">5</th>
              <td>Price Range /Kg:</td>
              <td>' . $pR . '</td>              
            </tr>';

    $HTML .= '
            <tr>
              <th scope="row">6</th>
              <td>Chemist By </td>
              <td>' . @AyraHelp::getUser($FPData->chemist_by)->name . '</td>              
            </tr>';












    $HTML .= '              
          </tbody>
        </table>
      </div>
    </div>

    <!--end::Section-->';


    $resp = array(
      'HTML_FPLIST' => $HTML,


    );
    return response()->json($resp);
  }
  public function setSPRange(Request $request)
  {

    DB::table('rnd_finish_products')
      ->where('id', $request->rowid)
      ->update([
        'sp_min' => $request->spMin,
        'sp_max' => $request->spMax
      ]);


    $eventName = "FINISH PRODUCT";
    $AssineTo = Auth::user()->id;
    $userID = Auth::user()->id;
    $eventINFO = 'Price updated of finish product: of id' . $request->rowid . " by  " . $AssineTo . " Min Price:" . $request->spMin . "<br>Max Price:" . $request->spMax;

    $eventID =  $request->rowid;
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


    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function getFinishProductcatSubListData(Request $request)
  {
    $datas = DB::table('rnd_finish_product_subcat')
      ->get();

    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $created_on = date('j M Y', strtotime($dataRow->created_at));
      $dataP_arr = AyraHelp::getFinishPCatDetail($dataRow->cat_id);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'created_at' => $created_on,
        'cat_name' => optional($dataP_arr)->cat_name,
        'sub_cat_name' => optional($dataRow)->sub_cat_name,
        'no_product' => 1,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'created_at'     => true,
      'cat_name'      => true,
      'sub_cat_name'      => true,
      'no_product'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }




  //---------------
  public function getFinishProductCAT(Request $request)
  {
    $datas = DB::table('rnd_finish_product_subcat')
      ->get();

    // $datas = DB::table('rnd_finish_product_subcat')
    //         ->rightJoin('rnd_finish_product_cat', 'rnd_finish_product_cat.id', '=', 'rnd_finish_product_subcat.cat_id')                                            
    //         ->get();
    // echo "<pre>";
    // print_r($datas);  
    // die;          


    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $created_on = date('j M Y', strtotime($dataRow->created_at));
      $dataP_arr = AyraHelp::getFinishPCatDetail($dataRow->cat_id);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'created_at' => $created_on,
        'cat_name' => optional($dataP_arr)->cat_name,
        'sub_cat_name' => optional($dataRow)->sub_cat_name,
        'no_product' => 1,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'created_at'     => true,
      'cat_name'      => true,
      'sub_cat_name'      => true,
      'no_product'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //---------------
  public function getFinishProductCAT_(Request $request)
  {
    $datas = DB::table('rnd_finish_product_cat')
      ->get();
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $created_on = date('j M Y', strtotime($dataRow->created_at));
      $dataP_arr = AyraHelp::getFinishPSubCatDetail($dataRow->id);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'created_at' => $created_on,
        'cat_name' => optional($dataRow)->cat_name,
        'sub_cat_name' => optional($dataP_arr)->sub_cat_name,
        'no_product' => 1,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'created_at'     => true,
      'cat_name'      => true,
      'sub_cat_name'      => true,
      'no_product'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function saveFinishCatSubCat(Request $request)
  {

    if ($request->txtCVal == 1) {

      DB::table('rnd_finish_product_cat')->insert(
        ['cat_name' => $request->f_p_cat]
      );
    }
    if ($request->txtCVal == 2) {


      DB::table('rnd_finish_product_subcat')->insert(
        [
          'cat_id' => $request->f_category,
          'sub_cat_name' => $request->f_p_subcat,
        ]
      );
    }
  }
  public function add_finish_product_cat()
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.add_finish_product_cat_sub', $data)->render();
  }

  public function add_finish_product_subcat()
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.add_finish_product_cat_sub_v1', $data)->render();
  }



  public function finishProductCategory()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.finish_product_category', $data)->render();
  }
  public function finishProductSubCategory()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.finish_product_subcategory', $data)->render();
  }



  public function editNewProductDevelopment(Request $request)
  {

    DB::table('rnd_new_product_development')
      ->where('id', $request->txtPID)
      ->update(
        [
          'type' => $request->product_type,
          'name' => $request->product_name,
          'sub_cat_id' => $request->cat_id,
          'discription_info' => $request->product_info,
          'claim_required' => $request->claim_required,
          'benchmark_provided' => $request->benchmark_provided,
          'website_url' => $request->benchmark_url,
          'suggested_ingredent' => $request->suggested_ingredient,
          'color' => $request->p_color,
          'fragrance' => $request->p_fragrance,
          'target_sell_price' => $request->p_target_sell_price
        ]
      );
  }


  public function editnNewProductList($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $datas = DB::table('rnd_new_product_development')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];
    return $theme->scope('rnd.editNewProductDevelopment', $data)->render();
  }
  public function deleteNewProductDev(Request $request)
  {
    //$datas = DB::table('rnd_new_product_development')->where('id',$request->rowid)->delete();

    DB::table('rnd_new_product_development')
      ->where('id', $request->rowid)
      ->update([
        'is_deleted' => 1,

      ]);

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function getNewProductDevelopementList()
  {
    $datas = DB::table('rnd_new_product_development')
      ->where('is_deleted', 0)
      ->get();
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $created_on = date('j M Y', strtotime($dataRow->created_at));

      $pd_sub_arr = AyraHelp::getFinishPSubCatDetail($dataRow->sub_cat_id);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'created_at' => $created_on,
        'type' => optional($dataRow)->name == 1 ? 'Client' : 'In House',
        'name' => optional($dataRow)->name,
        'sub_category' => optional($pd_sub_arr)->sub_cat_name,
        'URL' => optional($dataRow)->website_url,
        'benchmark_provided' => optional($dataRow)->benchmark_provided,
        'color' => optional($dataRow)->color,
        'npd_stage' => 'Concept',
        'sp' => optional($dataRow)->target_sell_price,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'created_at'     => true,
      'type'      => true,
      'name'      => true,
      'sub_category'      => true,
      'URL'      => true,
      'benchmark_provided'      => true,
      'color'      => true,
      'npd_stage'      => true,
      'sp'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //editINGFinishProduct

  public function editINGFinishProduct($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $datas = DB::table('rnd_finish_products')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];
    return $theme->scope('rnd.editFinishProduct', $data)->render();
  }


  //editINGFinishProduct


  public function updateINGdata(Request $request)
  {
    $txtINGNO = $request->txtINGNO;
    $company_name = $request->company_name;
    $full_address = $request->full_address;
    $link_brand = json_encode($request->paramLinkBrand);
    $ingContact = json_encode($request->ingContact);

    DB::table('rnd_ingredient_supplier')
      ->where('id', $txtINGNO)
      ->update([
        'company_name' => $company_name,
        'full_address' => $full_address,
        'contact_details' => $ingContact,
        'link_brands' => $link_brand,
        'created_by' => Auth::user()->id
      ]);
  }
  public function saveINGdata(Request $request)
  {

    $company_name = $request->company_name;
    $full_address = $request->full_address;
    $ingContact = json_encode($request->ingContact);
    $aj = array();
    DB::table('rnd_ingredient_supplier')->insert(
      [
        'company_name' => $company_name,
        'full_address' => $full_address,
        'contact_details' => $ingContact,
        'created_by' => Auth::user()->id,
        'link_brands' => '[""]'

      ]
    );
  }


  public function IngredentBrandAddNew(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.AddNewBrandIngredent', $data)->render();
  }
  public function deleteIngredient(Request $request)
  {
    //$datas = DB::table('rnd_add_ingredient')->where('id',$request->rowid)->delete();
    $rowid = $request->rowid;
    $affected = DB::table('rnd_add_ingredient')
      ->where('id', $rowid)
      ->update(['is_deleted' => 1]);

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function editIngredent($id)
  {


    $theme = Theme::uses('corex')->layout('layout');


    $datas = DB::table('rnd_add_ingredient')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];
    return $theme->scope('rnd.EditIngredentData', $data)->render();

    // $theme = Theme::uses('corex')->layout('layout');

    // $data = [
    //   'data' => '',
    // ];
    // return $theme->scope('rnd.AddIngredent', $data)->render();
  }
  public function addIngredetnView(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');

    $data = [
      'data' => '',
    ];
    return $theme->scope('rnd.AddIngredent', $data)->render();
  }
  public function updateINGBrand(Request $request)
  {
    DB::table('rnd_supplier_brands')->where('id', '=', $request->txtbrandID)->delete();

    DB::table('rnd_supplier_brands')->insert(
      [
        'brand_name' => $request->brand_name,
        'supplier_id' => json_encode($request->supplier_name),
      ]
    );
  }
  public function editBrandING($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $datas = DB::table('rnd_supplier_brands')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];
    return $theme->scope('rnd.EditBrandIngredent', $data)->render();
  }

  public function saveINGBrand(Request $request)
  {

    $data_bran_suppr = DB::table('rnd_supplier_brands')->where('brand_name', $request->brand_name)->first();
    if ($data_bran_suppr == null) {

      DB::table('rnd_supplier_brands')->insert(
        [
          'brand_name' => optional($request)->brand_name,
          'supplier_id' => json_encode($request->supplier_name),
          'created_by' => Auth::user()->id

        ]
      );
    }
  }

  public function saveINGCategorydata(Request $request)
  {


    DB::table('rnd_ingredient_category')->insert(
      [
        'category_name' => optional($request)->ingbcatName,
        'brand_name' => optional($request)->ingbcatBrandAvailable,
        'no_of_ing' => optional($request)->ingbcatNoIngredient,
        'no_of_formula' => optional($request)->ingbcatNoFormulation,
        'no_of_finish_prouduct' => optional($request)->ingbcatNoProductio,
        'created_by' => Auth::user()->id

      ]
    );
  }
  //add ingredent category

  public function IngredentAddIngCat(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.AddIngredentCategory', $data)->render();
  }

  //add ingredent category

  public function IngredentAddNew(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.AddNewIngredent', $data)->render();
  }

  public function updateIngredientdata(Request $request)
  {

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == "Admin" || $user_role == "CourierTrk") {
      //admin 
      foreach ($request->sizeRateArr as $key => $rowData) {

        $priceSize[] = array(
          'sizeData' => $rowData['rndSizeWith'],
          'rateData' => $rowData['rndRateWith'],

        );
      }


      //print_r($request->all());

      DB::table('rnd_add_ingredient')
        ->where('id',  $request->txtInGID)
        ->update([
          'brand_name' => json_encode($request->paramLinkBrand),
          'supplier_name' => json_encode($request->paramLinkSupplier),
          'name' => $request->ingb_name,
          'ing_brand_name' => $request->ingb_brand,
          'cat_id' => $request->ingb_cat,
          'size_price' => json_encode($priceSize),
          'recommandation_dose' => $request->ingb_rdose,
          'spz' => $request->ingb_spz,
          'av_lose' => $request->av_dose,
          'lead_type' => $request->ingb_ltime,
          'sap_code' => $request->ingb_sapcode,
          'ingb_other_name' => $request->ingb_other_name,
          'created_by' => Auth::user()->id,
          'ing_remarks' => $request->ing_remarks,

        ]);



      //dataarrA

      $lid = $request->txtInGID;



      if ($request->hasfile('customFileCOA')) {
        $file = $request->file('customFileCOA');
        $filename = "Bo_document_COA" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileCOA' => $filename

          ]);
      }
      if ($request->hasfile('customFileMSDS')) {
        $file = $request->file('customFileMSDS');
        $filename = "Bo_document_MSDS_customFileMSDS" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileMSDS' => $filename

          ]);
      }

      if ($request->hasfile('customFileGS')) {
        $file = $request->file('customFileGS');
        $filename = "Bo_document_GC__customFileGC" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileGS' => $filename

          ]);
      }



      $i = 0;
      foreach ($request->sizeRateArr as $key => $rData) {

        //  print_r($rData['rndSizeWith']);
        //  die;
        if (!empty($rData['rndSizeWith'])) {
          $i++;
          // echo $i;

          if ($i == 1) {
            // echo "dd3";
            // die;
            $affected = DB::table('rnd_add_ingredient')
              ->where('id', $lid)
              ->update([
                'size_1' => $rData['rndSizeWith'] . "Kg",
                'price_1' => "Rs." . $rData['rndRateWith'],

              ]);
          }
          if ($i == 2) {
            $affected = DB::table('rnd_add_ingredient')
              ->where('id', $lid)
              ->update([
                'size_2' => $rData['rndSizeWith'] . "Kg",
                'price_2' => "Rs." . $rData['rndRateWith'],

              ]);
          }

          if ($i == 3) {
            $affected = DB::table('rnd_add_ingredient')
              ->where('id', $lid)
              ->update([
                'size_3' => $rData['rndSizeWith'] . "Kg",
                'price_3' => "Rs." . $rData['rndRateWith'],

              ]);
          }
        }
      }
      //dataarrA

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;


      $eventName = "RND Ingredent";
      $eventINFO = 'Ingredent ID:' . $lid . " modified by  " . $LoggedName;
      $eventID = $lid;
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

      //admin 
    } else {
      // other 
      //dataarrA

      $lid = $request->txtInGID;

      $myFile = "";

      if ($request->hasfile('customFileCOA')) {
        $file = $request->file('customFileCOA');
        $filename = "Bo_document_COA" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileCOA' => $filename

          ]);
        $myFile .= $filename;
      }
      if ($request->hasfile('customFileMSDS')) {
        $file = $request->file('customFileMSDS');
        $filename = "Bo_document_MSDS_customFileMSDS" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileMSDS' => $filename

          ]);
        $myFile .= $filename;
      }

      if ($request->hasfile('customFileGS')) {
        $file = $request->file('customFileGS');
        $filename = "Bo_document_GC__customFileGC" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
        // save to local/uploads/photo/ as the new $filename
        $path = $file->storeAs('photos', $filename);

        $affected = DB::table('rnd_add_ingredient')
          ->where('id', $lid)
          ->update([
            'customFileGS' => $filename

          ]);
        $myFile .= $filename;
      }




      //dataarrA

      //LoggedActicty
      $userID = Auth::user()->id;
      $LoggedName = AyraHelp::getUser($userID)->name;


      $eventName = "RND Ingredent";
      $eventINFO = 'Ingredent ID:' . $lid . " file uploaded by  " . $LoggedName . "File :" . $myFile;
      $eventID = $lid;
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


      // other 
    }
  }
  //saveRMToIngredent
  public function saveRMToIngredent(Request $request)
  {
    $name = $request->txtRMName;
    $txtRMPrice = $request->txtRMPrice;
    $priceSize = array(
      'sizeData' => '1Kg',
      'rateData' => $txtRMPrice

    );

    $datArr = DB::table('rnd_add_ingredient')
            ->where('name', $name)
            ->first();
    if($datArr!=null){

    DB::table('rnd_add_ingredient')
    ->updateOrInsert(
        ['name' =>$name],
        [
          'created_by' => Auth::user()->id,
          'created_at' => date('Y-m-d'),
          'updated_at' => date('Y-m-d'),
          'name' => $name,
          'size_price' => json_encode([$priceSize]),
          'size_1' => '1Kg',
          'price_1' => "Rs." . $txtRMPrice,
          'price_check' =>$txtRMPrice,
        ]
    );


      // DB::table('rnd_add_ingredient')->insert([
      //   'created_by' => Auth::user()->id,
      //   'created_at' => date('Y-m-d'),
      //   'updated_at' => date('Y-m-d'),
      //   'name' => $name,
      //   'size_price' => json_encode([$priceSize]),
      //   'size_1' => '1Kg',
      //   'price_1' => "Rs." . $txtRMPrice,
      //   'price_check' =>$txtRMPrice,
      // ]);
      // $lid = DB::getPdo()->lastInsertId();
      $resp = array(
        'status' => 1,
        'data' => array(
          'id'=>$datArr->id,
          'name'=>$datArr->name,
        ),
  
      );

    }else{
       DB::table('rnd_add_ingredient')->insert([
      'created_by' => Auth::user()->id,
      'created_at' => date('Y-m-d'),
      'updated_at' => date('Y-m-d'),
      'name' => $name,
      'size_price' => json_encode([$priceSize]),
      'size_1' => '1Kg',
      'price_1' => "Rs." . $txtRMPrice,
    ]);
    $lid = DB::getPdo()->lastInsertId();
    $resp = array(
      'status' => 1,
      'data' => array(
        'id'=>$lid,  
        'name'=>$name,
      ),

    );
    }

   
    return response()->json($resp);
    
  }

  //saveRMToIngredent

  //saveSapUploadData
  public function saveSapUploadData(Request $request)
  {
    // print_r($request->all());
    $filename = $_FILES["customFileSap"]["tmp_name"];
    if ($_FILES["customFileSap"]["size"] > 0) {
      $file = fopen($filename, "r");
      $i = 0;
      $priceSize = array();
      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $i++;
        if ($i >= 3) {
          //print_r($getData[0]);
          $num = $getData[7];
          $numS = str_replace(' ', '', $num);
          $numRS = trim(str_replace("INR", "", $numS));
          $numRSVal = trim(str_replace(",", "", $numRS));

          $FloatRS = (float)$numRSVal;

          $priceSize = array(
            'sizeData' => '1Kg',
            'rateData' => $FloatRS

          );


          if (!empty($getData[1])) {
            DB::table('rnd_add_ingredient')
              ->updateOrInsert(
                ['sap_code' => $getData[0]],
                [
                  'created_by' => Auth::user()->id,
                  'created_at' => date('Y-m-d'),
                  'updated_at' => date('Y-m-d'),
                  'name' => $getData[1],
                  'size_price' => json_encode([$priceSize]),
                  'size_1' => '1Kg',
                  'price_1' => "Rs." . $FloatRS,
                ]
              );
          }
        }
      }
    }
  }

  //saveSapUploadData

  public function saveINGBranddata(Request $request)
  {





    foreach ($request->sizeRateArr as $key => $rowData) {

      $priceSize[] = array(
        'sizeData' => $rowData['rndSizeWith'],
        'rateData' => $rowData['rndRateWith'],

      );
    }



    DB::table('rnd_add_ingredient')->insert(
      [
        'brand_name' => json_encode($request->paramLinkBrand),
        'supplier_name' => json_encode($request->paramLinkSupplier),
        'name' => $request->ingb_name,
        'ing_brand_name' => $request->ingb_brand,
        'inci' => $request->inci_name,
        'cat_id' => $request->ingb_cat,
        'size_price' => json_encode($priceSize),
        'recommandation_dose' => $request->ingb_rdose,
        'spz' => $request->ingb_spz,
        'av_lose' => $request->av_dose,
        'lead_type' => $request->ingb_ltime,
        'sap_code' => $request->ingb_sapcode,
        'ingb_other_name' => $request->ingb_other_name,
        'created_by' => Auth::user()->id

      ]
    );

    //dataarrA

    $lid = DB::getPdo()->lastInsertId();

    /*
    if ($request->hasfile('customFileCOA')) {
      $file = $request->file('customFileCOA');
      $filename = "img_1_RND" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
      ->where('id', $lid)
      ->update([
        'customFileCOA' =>$filename        

      ]);
     
    }

    if ($request->hasfile('customFileCOA')) {
      $file = $request->file('customFileCOA');
      $filename = "img_1_RND_customFileCOA" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
      ->where('id', $lid)
      ->update([
        'customFileCOA' =>$filename        

      ]);
     
    }

    if ($request->hasfile('customFileMSDS')) {
      $file = $request->file('customFileMSDS');
      $filename = "img_1_RND_customFileMSDS" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
      ->where('id', $lid)
      ->update([
        'customFileMSDS' =>$filename        

      ]);
     
    }

    if ($request->hasfile('customFileGS')) {
      $file = $request->file('customFileGS');
      $filename = "img_1_RND_customFileGS" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
      ->where('id', $lid)
      ->update([
        'customFileGS' =>$filename        

      ]);
     
    }
    */
    if ($request->hasfile('customFileCOA')) {
      $file = $request->file('customFileCOA');
      $filename = "Bo_document_COA" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
        ->where('id', $lid)
        ->update([
          'customFileCOA' => $filename

        ]);
    }
    if ($request->hasfile('customFileMSDS')) {
      $file = $request->file('customFileMSDS');
      $filename = "Bo_document_MSDS_customFileMSDS" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
        ->where('id', $lid)
        ->update([
          'customFileMSDS' => $filename

        ]);
    }

    if ($request->hasfile('customFileGS')) {
      $file = $request->file('customFileGS');
      $filename = "Bo_document_GC__customFileGC" . $lid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);

      $affected = DB::table('rnd_add_ingredient')
        ->where('id', $lid)
        ->update([
          'customFileGS' => $filename

        ]);
    }





    $i = 0;
    foreach ($request->sizeRateArr as $key => $rData) {

      //  print_r($rData['rndSizeWith']);
      //  die;
      if (!empty($rData['rndSizeWith'])) {
        $i++;
        // echo $i;

        if ($i == 1) {
          // echo "dd3";
          // die;
          $affected = DB::table('rnd_add_ingredient')
            ->where('id', $lid)
            ->update([
              'size_1' => $rData['rndSizeWith'] . "Kg",
              'price_1' => "Rs." . $rData['rndRateWith'],

            ]);
        }
        if ($i == 2) {
          $affected = DB::table('rnd_add_ingredient')
            ->where('id', $lid)
            ->update([
              'size_2' => $rData['rndSizeWith'] . "Kg",
              'price_2' => "Rs." . $rData['rndRateWith'],

            ]);
        }

        if ($i == 3) {
          $affected = DB::table('rnd_add_ingredient')
            ->where('id', $lid)
            ->update([
              'size_3' => $rData['rndSizeWith'] . "Kg",
              'price_3' => "Rs." . $rData['rndRateWith'],

            ]);
        }
      }
    }
    //dataarrA


    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;


    $eventName = "RND Ingredent";
    $eventINFO = 'Ingredent ID:' . $lid . "created by  " . $LoggedName;
    $eventID = $lid;
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


  //sapUploadFile
  public function sapUploadFile()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.uploadSapInvetoryData', $data)->render();
  }

  //sapUploadFile
  //getIngreidentFirstPrice
  public function getIngreidentFirstPrice(Request $request)
  {
    $data = DB::table('rnd_add_ingredient')
      ->where('id', $request->rndID)
      ->first();
    $price = explode("Rs.", $data->price_1);
    $costRND = (intVal($price[1]) * 4) / 100;
    $dataA = array(
      'size_1' => $data->size_1,
      'price_1' => $price[1],
      'costRND' => $costRND,
    );

    $resp = array(
      'status' => 1,
      'data' => $dataA,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }
  //getIngreidentFirstPrice

  //saveEditFormulaRNDv1
  public function saveEditFormulaRNDv1(Request $request)
  {
   // echo "<pre>";
    //print_r($request->all());
    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name;

    $affected = DB::table('bo_formuation_v1')
              ->where('id', $request->txtFMID)
              ->update([
                'created_by' => $request->txtFormulatedBy,
                'created_name' => $FMname,
                'formula_name' => $request->txtFMName,
                // 'fm_code' => $request->txtFMCode,
                'updated_at' => date('Y-m-d H:i:s'),
                'fm_addedby' => Auth::user()->id,
                'fm_addedby_name' =>  Auth::user()->name,
                'base_code' => $request->txtBaseCode,
                'ph_val' =>  @$request->txt_ph_val,
                'vescocity_val' =>   @$request->txt_vescocity_val,
                'fragrance_val' =>   @$request->txt_fragrance_val,
                'color_val' =>   @$request->txt_color_val,
                'apperance_val' =>  @$request->txt_apperance_val,
                'formula_date' =>  @$request->formula_date,
               
              ]);
              $deletedChild = DB::table('bo_formuation_child_v1')->where('fm_id',$request->txtFMID )->delete();
              $deletedChild_process = DB::table('bo_formuation_child_process_v1')->where('fm_id',$request->txtFMID )->delete();
              



              $txtINGIDArr = $request->txtINGID;
              $txtDoseDataArr = $request->txtDoseData;
              $txtPhaseDataArr = $request->txtPhaseData;
              $txtPriceDataArr = $request->txtPriceData;
              $txtRNDCostArr = $request->txtRNDCost;
          
          
              $txtPhaseEntryArr = $request->txtPhaseEntry;
              $txtProcessEntryArr = $request->txtProcessEntry;
              $txtRPMDataArr = $request->txtRPMData;
              $txtTEMPDataArr = $request->txtTEMPData;
              // print_r($txtRPMDataArr);
              // die;
          
          
              $lid = $request->txtFMID;
              foreach ($txtINGIDArr as $key => $rowData) {
                $txtINGID = $txtINGIDArr[$key];
                $txtDoseData = $txtDoseDataArr[$key];
                $txtPhaseDataArrData = $txtPhaseDataArr[$key];
                $txtPriceData = $txtPriceDataArr[$key];
                $txtRNDCostData = $txtRNDCostArr[$key];
          
                $rndArr = DB::table('rnd_add_ingredient')
                  ->where('id', $txtINGID)
                  ->first();
                // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);
                $d_cost=($txtPriceData*$txtDoseData)/100;

                DB::table('bo_formuation_child_v1')->insert([
                  'fm_id' => $lid,
                  'ingredent_id' => $txtINGID,
                  'ingredent_name' => @$rndArr->name,
                  'dos_percentage' => $txtDoseData,
                  'phase' => $txtPhaseDataArrData,
                  'price' => $txtPriceData,
                  'cost' => $d_cost,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'created_by_name' => $FMname,
                  'created_by' => $request->txtFormulatedBy,
                  'mfg_pecentage' => '',
          
          
                ]);
              }
          
              foreach ($txtPhaseEntryArr as $key => $row) {
          
                $txtPhaseEntryData = $txtPhaseEntryArr[$key];
                $txtProcessEntry = $txtProcessEntryArr[$key];
                $txtRPMData = $txtRPMDataArr[$key];
                $txtTEMPData = $txtTEMPDataArr[$key];
          
                $checkChildProcess = DB::table('bo_formuation_child_process_v1')
                      ->where('fm_id', $lid)
                      ->where('phase_code', $txtPhaseEntryData)
                      ->first();
                  if($checkChildProcess==null){
                    if(!empty($txtProcessEntry)){
                      DB::table('bo_formuation_child_process_v1')->insert([
                        'fm_id' => $lid,
                        'phase_code' => $txtPhaseEntryData,
                        'Process' => $txtProcessEntry,
                        'rpm' => $txtRPMData,
                        'temp' => $txtTEMPData
                
                      ]);
                    }
                   
                  }
          
          
              
              }


              $eventName = "FORMULA-RND-EDIT-BASE";
              $eventINFO = 'FMID:' . $request->txtFMID . " and added by  " . Auth::user()->name;
          
              $eventID = $request->txtFMID;
              $userID = Auth::user()->id;
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


              $resp = array(
                'status' => 1,
                'Message' => 'Submitted successfully',
              );
              return response()->json($resp);
              

  }

  //saveEditFormulaRNDv1

  //saveEditFormulaRND
  public function saveEditFormulaRND(Request $request)
  {
   // echo "<pre>";
    //print_r($request->all());
    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name;

    $affected = DB::table('bo_formuation')
              ->where('id', $request->txtFMID)
              ->update([
                'created_by' => $request->txtFormulatedBy,
                'created_name' => $FMname,
                'formula_name' => $request->txtFMName,
                'ph_val' => $request->txt_ph_val,
                'vescocity_val' => $request->txt_vescocity_val,
                'fragrance_val' => $request->txt_fragrance_val,
                'color_val' => $request->txt_color_val,
                'apperance_val' => $request->txt_apperance_val,
                'formula_date' => $request->formula_date,
                // 'fm_code' => $request->txtFMCode,
                'updated_at' => date('Y-m-d H:i:s'),
                'fm_addedby' => Auth::user()->id,
                'fm_addedby_name' =>  Auth::user()->name,
               
              ]);
              $deletedChild = DB::table('bo_formuation_child')->where('fm_id',$request->txtFMID )->delete();
              $deletedChild_process = DB::table('bo_formuation_child_process')->where('fm_id',$request->txtFMID )->delete();
              



              $txtINGIDArr = $request->txtINGID;
              $txtDoseDataArr = $request->txtDoseData;
              $txtPhaseDataArr = $request->txtPhaseData;
              $txtPriceDataArr = $request->txtPriceData;
              $txtRNDCostArr = $request->txtRNDCost;
          
          
              $txtPhaseEntryArr = $request->txtPhaseEntry;
              $txtProcessEntryArr = $request->txtProcessEntry;
              $txtRPMDataArr = $request->txtRPMData;
              $txtTEMPDataArr = $request->txtTEMPData;
              // print_r($txtRPMDataArr);
              // die;
          
          
              $lid = $request->txtFMID;
              foreach ($txtINGIDArr as $key => $rowData) {
                $txtINGID = $txtINGIDArr[$key];
                $txtDoseData = $txtDoseDataArr[$key];
                $txtPhaseDataArrData = $txtPhaseDataArr[$key];
                $txtPriceData = $txtPriceDataArr[$key];
                $txtRNDCostData = $txtRNDCostArr[$key];
          
                $rndArr = DB::table('rnd_add_ingredient')
                  ->where('id', $txtINGID)
                  ->first();
                // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);
                $d_cost=($txtPriceData*$txtDoseData)/100;

                DB::table('bo_formuation_child')->insert([
                  'fm_id' => $lid,
                  'ingredent_id' => $txtINGID,
                  'ingredent_name' => @$rndArr->name,
                  'dos_percentage' => $txtDoseData,
                  'phase' => $txtPhaseDataArrData,
                  'price' => $txtPriceData,
                  'cost' => $d_cost,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'created_by_name' => $FMname,
                  'created_by' => $request->txtFormulatedBy,
                  'mfg_pecentage' => '',
          
          
                ]);
              }
          
              foreach ($txtPhaseEntryArr as $key => $row) {
          
                $txtPhaseEntryData = $txtPhaseEntryArr[$key];
                $txtProcessEntry = $txtProcessEntryArr[$key];
                $txtRPMData = $txtRPMDataArr[$key];
                $txtTEMPData = $txtTEMPDataArr[$key];
          
                $checkChildProcess = DB::table('bo_formuation_child_process')
                      ->where('fm_id', $lid)
                      ->where('phase_code', $txtPhaseEntryData)
                      ->first();
                  if($checkChildProcess==null){
                    if(!empty($txtProcessEntry)){
                      DB::table('bo_formuation_child_process')->insert([
                        'fm_id' => $lid,
                        'phase_code' => $txtPhaseEntryData,
                        'Process' => $txtProcessEntry,
                        'rpm' => $txtRPMData,
                        'temp' => $txtTEMPData
                
                      ]);
                    }
                   
                  }
          
          
              
              }


              $eventName = "FORMULA-RND-EDIT";
              $eventINFO = 'FMID:' . $request->txtFMID . " and added by  " . Auth::user()->name;
          
              $eventID = $request->txtFMID;
              $userID = Auth::user()->id;
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


              $resp = array(
                'status' => 1,
                'Message' => 'Submitted successfully',
              );
              return response()->json($resp);
              

  }
  //saveEditFormulaRND

  //saveEditCopyFormulaRNDBaseV1
  public function saveEditCopyFormulaRNDBaseV1(Request $request)
  {
    // echo "<pre>";
    // print_r($request->all());
    // die;
    $max_id = DB::table('bo_formuation_v1')->max('id') + 1;
    $uname = 'BSFM-';
    $num = $max_id;
    $str_length = 5;
    $txtFMCode = $uname . substr("000{$num}", -$str_length);

    $sampleArrITEMData = DB::table('sample_items')->where('id',$request->txtSampleID)->first();

    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name; 

    DB::table('bo_formuation_v1')->insert([
      'created_by' => $request->txtFormulatedBy,
      'created_name' => $FMname,
      'formula_name' => $request->txtFMName,
      'fm_code' => $txtFMCode,
      'created_at' => date('Y-m-d H:i:s'),
      'fm_addedby' => Auth::user()->id,
      'fm_addedby_name' =>  Auth::user()->name,
      'mfg_qty' =>  $request->txtMFGQTY,
      'sample_id' =>  @$sampleArrITEMData->sid,
      'sample_code' =>  @$sampleArrITEMData->sid_partby_code,

    ]);

    $txtINGIDArr = $request->txtINGID;
    $txtDoseDataArr = $request->txtDoseData;
    $txtPhaseDataArr = $request->txtPhaseData;
    $txtPriceDataArr = $request->txtPriceData;
    $txtRNDCostArr = $request->txtRNDCost;


    $txtPhaseEntryArr = $request->txtPhaseEntry;
    $txtProcessEntryArr = $request->txtProcessEntry;
    $txtRPMDataArr = $request->txtRPMData;
    $txtTEMPDataArr = $request->txtTEMPData;
    // print_r($txtRPMDataArr);
    // die;


    $lid = DB::getPdo()->lastInsertId();
    foreach ($txtINGIDArr as $key => $rowData) {
      $txtINGID = $txtINGIDArr[$key];
      $txtDoseData = $txtDoseDataArr[$key];
      $txtPhaseDataArrData = $txtPhaseDataArr[$key];
      $txtPriceData = $txtPriceDataArr[$key];
      $txtRNDCostData = $txtRNDCostArr[$key];

      $rndArr = DB::table('rnd_add_ingredient')
        ->where('id', $txtINGID)
        ->first();
      // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);
      $d_cost=($txtPriceData*$txtDoseData)/100;

      DB::table('bo_formuation_child_v1')->insert([
        'fm_id' => $lid,
        'ingredent_id' => @$txtINGID,
        'ingredent_name' => @$rndArr->name,
        'dos_percentage' => $txtDoseData,
        'phase' => $txtPhaseDataArrData,
        'price' => $txtPriceData,
        'cost' => $d_cost,
        'created_by_name' => $FMname,
        'created_by' => $request->txtFormulatedBy,
        'mfg_pecentage' => '',


      ]);
    }

    foreach ($txtPhaseEntryArr as $key => $row) {

      $txtPhaseEntryData = $txtPhaseEntryArr[$key];
      $txtProcessEntry = $txtProcessEntryArr[$key];
      $txtRPMData = $txtRPMDataArr[$key];
      $txtTEMPData = $txtTEMPDataArr[$key];

      $checkChildProcess = DB::table('bo_formuation_child_process_v1')
            ->where('fm_id', $lid)
            ->where('phase_code', $txtPhaseEntryData)
            ->first();
        if($checkChildProcess==null){
          if(!empty($txtProcessEntry)){
            DB::table('bo_formuation_child_process_v1')->insert([
              'fm_id' => $lid,
              'phase_code' => $txtPhaseEntryData,
              'Process' => $txtProcessEntry,
              'rpm' => $txtRPMData,
              'temp' => $txtTEMPData
      
            ]);
          }
         
        }


    
    }





    $eventName = "FORMULA-RND-BASECOPY";
    $eventINFO = 'Formula FM Code :' . $txtFMCode . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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


    $resp = array(
      'status' => 1,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }

  //saveEditCopyFormulaRNDBaseV1

  //saveEditCopyFormulaRND
  public function saveEditCopyFormulaRND(Request $request)
  {
    // echo "<pre>";
    // print_r($request->all());
    // die;
    $max_id = DB::table('bo_formuation')->max('id') + 1;
    $uname = 'FM-';
    $num = $max_id;
    $str_length = 5;
    $txtFMCode = $uname . substr("000{$num}", -$str_length);

    $sampleArrITEMData = DB::table('sample_items')->where('id',$request->txtSampleID)->first();

    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name; 

    DB::table('bo_formuation')->insert([
      'created_by' => $request->txtFormulatedBy,
      'created_name' => $FMname,
      'formula_name' => $request->txtFMName,
      'fm_code' => $txtFMCode,
      'created_at' => date('Y-m-d H:i:s'),
      'fm_addedby' => Auth::user()->id,
      'fm_addedby_name' =>  Auth::user()->name,
      'ph_val' =>  @$request->txt_ph_val,
      'vescocity_val' =>   @$request->txt_vescocity_val,
      'fragrance_val' =>   @$request->txt_fragrance_val,
      'color_val' =>   @$request->txt_color_val,
      'apperance_val' =>  @$request->txt_apperance_val,
      'formula_date' =>  @$request->formula_date,
      'mfg_qty' =>  $request->txtMFGQTY,
      'sample_id' =>  @$sampleArrITEMData->sid,
      'sample_code' =>  @$sampleArrITEMData->sid_partby_code,

    ]);

    $txtINGIDArr = $request->txtINGID;
    $txtDoseDataArr = $request->txtDoseData;
    $txtPhaseDataArr = $request->txtPhaseData;
    $txtPriceDataArr = $request->txtPriceData;
    $txtRNDCostArr = $request->txtRNDCost;


    $txtPhaseEntryArr = $request->txtPhaseEntry;
    $txtProcessEntryArr = $request->txtProcessEntry;
    $txtRPMDataArr = $request->txtRPMData;
    $txtTEMPDataArr = $request->txtTEMPData;
    // print_r($txtRPMDataArr);
    // die;


    $lid = DB::getPdo()->lastInsertId();
    foreach ($txtINGIDArr as $key => $rowData) {
      $txtINGID = $txtINGIDArr[$key];
      $txtDoseData = $txtDoseDataArr[$key];
      $txtPhaseDataArrData = $txtPhaseDataArr[$key];
      $txtPriceData = $txtPriceDataArr[$key];
      $txtRNDCostData = $txtRNDCostArr[$key];

      $rndArr = DB::table('rnd_add_ingredient')
        ->where('id', $txtINGID)
        ->first();
      // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);
      $d_cost=($txtPriceData*$txtDoseData)/100;

      DB::table('bo_formuation_child')->insert([
        'fm_id' => $lid,
        'ingredent_id' => @$txtINGID,
        'ingredent_name' => @$rndArr->name,
        'dos_percentage' => $txtDoseData,
        'phase' => $txtPhaseDataArrData,
        'price' => $txtPriceData,
        'cost' => $d_cost,
        'created_by_name' => $FMname,
        'created_by' => $request->txtFormulatedBy,
        'mfg_pecentage' => '',


      ]);
    }

    foreach ($txtPhaseEntryArr as $key => $row) {

      $txtPhaseEntryData = $txtPhaseEntryArr[$key];
      $txtProcessEntry = $txtProcessEntryArr[$key];
      $txtRPMData = $txtRPMDataArr[$key];
      $txtTEMPData = $txtTEMPDataArr[$key];

      $checkChildProcess = DB::table('bo_formuation_child_process')
            ->where('fm_id', $lid)
            ->where('phase_code', $txtPhaseEntryData)
            ->first();
        if($checkChildProcess==null){
          if(!empty($txtProcessEntry)){
            DB::table('bo_formuation_child_process')->insert([
              'fm_id' => $lid,
              'phase_code' => $txtPhaseEntryData,
              'Process' => $txtProcessEntry,
              'rpm' => $txtRPMData,
              'temp' => $txtTEMPData
      
            ]);
          }
         
        }


    
    }





    $eventName = "FORMULA-RND";
    $eventINFO = 'Formula FM Code :' . $txtFMCode . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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


    $resp = array(
      'status' => 1,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }

  //saveEditCopyFormulaRND

  //saveFormulaRND_Base
  public function saveFormulaRND_Base(Request $request)
  {
    
  

  
    $max_id = DB::table('base_bo_formuation_From')->max('id') + 1;
    $uname = 'BO-FBASE-';
    $num = $max_id;
    $str_length = 5;
    $txtFMCode = $uname . substr("000{$num}", -$str_length);


    $FMname = Auth::user()->id;

    
    $sampleArrITEMData = DB::table('sample_items')->where('id',$request->txtSampleID)->first();


    $boDataForArr=DB::table('bo_formuation')->where('id',$request->baseFormulaID)->first();


    DB::table('base_bo_formuation_From')->insert([
      'created_by' => Auth::user()->id,
      'created_name' => Auth::user()->name,      
      'formula_name' => $request->txtFMName,
      'fm_code_base' => $txtFMCode,
      'created_at' => date('Y-m-d H:i:s'),
      'fm_addedby' => Auth::user()->id,
      'fm_addedby_name' =>  Auth::user()->name,
      'base_fm_code' =>  $request->txtBaseFMCode,
      'sample_id' =>  1,
      'sample_child_id' =>  1,
     
    ]);

    
   
    
   
    


    $txtINGIDArr = $request->txtINGID;
    $txtDoseDataArr = $request->txtDoseData;
    $txtPhaseDataArr = $request->txtPhaseData;
    $txtPriceDataArr = $request->txtPriceData;
    $txtRNDCostArr = $request->txtRNDCost;


    $txtPhaseEntryArr = $request->txtPhaseEntry;
    $txtProcessEntryArr = $request->txtProcessEntry;
    $txtRPMDataArr = $request->txtRPMData;
    $txtTEMPDataArr = $request->txtTEMPData;



    $lid = DB::getPdo()->lastInsertId();



    ///bo_formuation_samplesmaps

    //bo_formuation_samplesmaps

    foreach ($txtINGIDArr as $key => $rowData) {
      $txtINGID = $txtINGIDArr[$key];
      $txtDoseData = $txtDoseDataArr[$key];
      $txtPhaseDataArrData = $txtPhaseDataArr[$key];
      $txtPriceData = $txtPriceDataArr[$key];
      $txtRNDCostData = $txtRNDCostArr[$key];

      $rndArr = DB::table('rnd_add_ingredient')
        ->where('id', $txtINGID)
        ->first();
        $d_price=($txtDoseData*$txtPriceData)/100;
      // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);

      DB::table('base_bo_formuation_child_From')->insert([
        'fm_id' => $lid,
        'ingredent_id' => @$txtINGID,
        'ingredent_name' => @$rndArr->name,
        'dos_percentage' => $txtDoseData,
        'phase' => $txtPhaseDataArrData,
        'price' => $txtPriceData,
        'cost' => $d_price,
        'created_by_name' => $FMname,
        'created_by' => Auth::user()->id      


      ]);
    }

 

    foreach ($txtPhaseEntryArr as $key => $row) {

      $txtPhaseEntryData = $txtPhaseEntryArr[$key];
      $txtProcessEntry = $txtProcessEntryArr[$key];
      $txtRPMData = $txtRPMDataArr[$key];
      $txtTEMPData = $txtTEMPDataArr[$key];

      $checkChildProcess = DB::table('base_bo_formuation_child_process_From')
            ->where('fm_id', $lid)
            ->where('phase_code', $txtPhaseEntryData)
            ->first();
        if($checkChildProcess==null){
          if(!empty($txtProcessEntry)){
            DB::table('base_bo_formuation_child_process_From')->insert([
              'fm_id' => $lid,
              'phase_code' => $txtPhaseEntryData,
              'Process' => $txtProcessEntry,
              'rpm' => $txtRPMData,
              'temp' => $txtTEMPData
      
            ]);
          }
         
        }


    
    }


    
  



    $eventName = "FORMULA-RND-BASE";
    $eventINFO = 'Formula FM Code :' . $txtFMCode . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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


    $resp = array(
      'status' => 1,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }

  //saveFormulaRND_Base
  
  //saveFormulaRND
  public function saveFormulaRND(Request $request)
  {
    // echo "<pre>"; txtSampleID
    // print_r($request->all());
    // die;
    $boDataForArr=DB::table('bo_formuation')->where('uid',$request->txtUID)->first();
    if($boDataForArr!=null){
      // $resp = array(
      //   'status' => 1,
      //   'Message' => 'Duplicate Entry',
      // );
      // return response()->json($resp);
    }
    
  
    $max_id = DB::table('bo_formuation')->max('id') + 1;
    $uname = 'FM-';
    $num = $max_id;
    $str_length = 5;
    $txtFMCode = $uname . substr("000{$num}", -$str_length);


    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name;

    
    $sampleArrITEMData = DB::table('sample_items')->where('id',$request->txtSampleID)->first();


    $boDataForArr=DB::table('bo_formuation')->where('uid',$request->txtUID)->first();


    DB::table('bo_formuation')->insert([
      'created_by' => $request->txtFormulatedBy,
      'created_name' => $FMname,
      'formula_name' => $request->txtFMName,
      'fm_code' => $txtFMCode,
      'created_at' => date('Y-m-d H:i:s'),
      'fm_addedby' => Auth::user()->id,
      'fm_addedby_name' =>  Auth::user()->name,
      'mfg_qty' =>  $request->txtMFGQTY,
      'uid' =>  $request->txtUID,
      'sample_id' =>  @$sampleArrITEMData->sid,
      'sample_code' =>  @$sampleArrITEMData->sid_partby_code,
      'ph_val' =>  @$request->txt_ph_val,
      'vescocity_val' =>   @$request->txt_vescocity_val,
      'fragrance_val' =>   @$request->txt_fragrance_val,
      'color_val' =>   @$request->txt_color_val,
      'apperance_val' =>  @$request->txt_apperance_val,
      'formula_date' =>  @$request->formula_date

    ]);

    $txtINGIDArr = $request->txtINGID;
    $txtDoseDataArr = $request->txtDoseData;
    $txtPhaseDataArr = $request->txtPhaseData;
    $txtPriceDataArr = $request->txtPriceData;
    $txtRNDCostArr = $request->txtRNDCost;


    $txtPhaseEntryArr = $request->txtPhaseEntry;
    $txtProcessEntryArr = $request->txtProcessEntry;
    $txtRPMDataArr = $request->txtRPMData;
    $txtTEMPDataArr = $request->txtTEMPData;
    // print_r($txtRPMDataArr);
    // die;


    $lid = DB::getPdo()->lastInsertId();



    ///bo_formuation_samplesmaps

    //bo_formuation_samplesmaps

    foreach ($txtINGIDArr as $key => $rowData) {
      $txtINGID = $txtINGIDArr[$key];
      $txtDoseData = $txtDoseDataArr[$key];
      $txtPhaseDataArrData = $txtPhaseDataArr[$key];
      $txtPriceData = $txtPriceDataArr[$key];
      $txtRNDCostData = $txtRNDCostArr[$key];

      $rndArr = DB::table('rnd_add_ingredient')
        ->where('id', $txtINGID)
        ->first();
        $d_price=($txtDoseData*$txtPriceData)/100;
      // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);

      DB::table('bo_formuation_child')->insert([
        'fm_id' => $lid,
        'ingredent_id' => @$txtINGID,
        'ingredent_name' => @$rndArr->name,
        'dos_percentage' => $txtDoseData,
        'phase' => $txtPhaseDataArrData,
        'price' => $txtPriceData,
        'cost' => $d_price,
        'created_by_name' => $FMname,
        'created_by' => $request->txtFormulatedBy,
        'mfg_pecentage' => '',


      ]);
    }

    foreach ($txtPhaseEntryArr as $key => $row) {

      $txtPhaseEntryData = $txtPhaseEntryArr[$key];
      $txtProcessEntry = $txtProcessEntryArr[$key];
      $txtRPMData = $txtRPMDataArr[$key];
      $txtTEMPData = $txtTEMPDataArr[$key];

      $checkChildProcess = DB::table('bo_formuation_child_process')
            ->where('fm_id', $lid)
            ->where('phase_code', $txtPhaseEntryData)
            ->first();
        if($checkChildProcess==null){
          if(!empty($txtProcessEntry)){
            DB::table('bo_formuation_child_process')->insert([
              'fm_id' => $lid,
              'phase_code' => $txtPhaseEntryData,
              'Process' => $txtProcessEntry,
              'rpm' => $txtRPMData,
              'temp' => $txtTEMPData
      
            ]);
          }
         
        }


    
    }





    $eventName = "FORMULA-RND";
    $eventINFO = 'Formula FM Code :' . $txtFMCode . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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


    $resp = array(
      'status' => 1,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }
  //saveFormulaRND


  //getCostBaseFormula
  public function getCostBaseFormula(Request $request)
  {
    $txtBaseFMCode=$request->txtBaseFMCode;
    $sumCost = DB::table('bo_formuation_child_v1')->where('fm_id',$txtBaseFMCode)->sum('cost');
    
    $resp = array(
      'status' => 1,
      'data' => number_format($sumCost, 2)
    );
      return response()->json($resp);




  }
  //getCostBaseFormula

  //saveFormulaRNDBasev1
  public function saveFormulaRNDBasev1(Request $request)
  {
    // echo "<pre>"; txtSampleID
    // print_r($request->all());
    // die;
    $boDataForArr=DB::table('bo_formuation_v1')->where('uid',$request->txtUID)->first();
    if($boDataForArr!=null){
      // $resp = array(
      //   'status' => 1,
      //   'Message' => 'Duplicate Entry',
      // );
      // return response()->json($resp);
    }
    
  
    $max_id = DB::table('bo_formuation_v1')->max('id') + 1;
    $uname = 'BSFM-';
    $num = $max_id;
    $str_length = 5;
    $txtFMCode = $uname . substr("000{$num}", -$str_length);


    $FMname = AyraHelp::getUser($request->txtFormulatedBy)->name;

    
    $sampleArrITEMData = DB::table('sample_items')->where('id',$request->txtSampleID)->first();


    $boDataForArr=DB::table('bo_formuation_v1')->where('uid',$request->txtUID)->first();


    DB::table('bo_formuation_v1')->insert([
      'created_by' => $request->txtFormulatedBy,
      'created_name' => $FMname,
      'formula_name' => $request->txtFMName,
      'fm_code' => $txtFMCode,
      'created_at' => date('Y-m-d H:i:s'),
      'fm_addedby' => Auth::user()->id,
      'fm_addedby_name' =>  Auth::user()->name,
      'mfg_qty' =>  $request->txtMFGQTY,
      'uid' =>  $request->txtUID,
      'sample_id' =>  @$sampleArrITEMData->sid,
      'sample_code' =>  @$sampleArrITEMData->sid_partby_code,
      'ph_val' =>  @$request->txt_ph_val,
      'vescocity_val' =>   @$request->txt_vescocity_val,
      'fragrance_val' =>   @$request->txt_fragrance_val,
      'color_val' =>   @$request->txt_color_val,
      'apperance_val' =>  @$request->txt_apperance_val,
      'formula_date' =>  @$request->formula_date,
      'base_code' =>  @$request->txtBaseCode
      

    ]);

    $txtINGIDArr = $request->txtINGID;
    $txtDoseDataArr = $request->txtDoseData;
    $txtPhaseDataArr = $request->txtPhaseData;
    $txtPriceDataArr = $request->txtPriceData;
    $txtRNDCostArr = $request->txtRNDCost;


    $txtPhaseEntryArr = $request->txtPhaseEntry;
    $txtProcessEntryArr = $request->txtProcessEntry;
    $txtRPMDataArr = $request->txtRPMData;
    $txtTEMPDataArr = $request->txtTEMPData;
    // print_r($txtRPMDataArr);
    // die;


    $lid = DB::getPdo()->lastInsertId();



    ///bo_formuation_samplesmaps

    //bo_formuation_samplesmaps

    foreach ($txtINGIDArr as $key => $rowData) {
      $txtINGID = $txtINGIDArr[$key];
      $txtDoseData = $txtDoseDataArr[$key];
      $txtPhaseDataArrData = $txtPhaseDataArr[$key];
      $txtPriceData = $txtPriceDataArr[$key];
      $txtRNDCostData = $txtRNDCostArr[$key];

      $rndArr = DB::table('rnd_add_ingredient')
        ->where('id', $txtINGID)
        ->first();
        $d_price=($txtDoseData*$txtPriceData)/100;
      // $mfg_pecentage=($request->txtMFGQTY)*($txtDoseData/100);

      DB::table('bo_formuation_child_v1')->insert([
        'fm_id' => $lid,
        'ingredent_id' => @$txtINGID,
        'ingredent_name' => @$rndArr->name,
        'dos_percentage' => $txtDoseData,
        'phase' => $txtPhaseDataArrData,
        'price' => $txtPriceData,
        'cost' => $d_price,
        'created_by_name' => $FMname,
        'created_by' => $request->txtFormulatedBy,
        'mfg_pecentage' => '',


      ]);
    }

    foreach ($txtPhaseEntryArr as $key => $row) {

      $txtPhaseEntryData = $txtPhaseEntryArr[$key];
      $txtProcessEntry = $txtProcessEntryArr[$key];
      $txtRPMData = $txtRPMDataArr[$key];
      $txtTEMPData = $txtTEMPDataArr[$key];

      $checkChildProcess = DB::table('bo_formuation_child_process_v1')
            ->where('fm_id', $lid)
            ->where('phase_code', $txtPhaseEntryData)
            ->first();
        if($checkChildProcess==null){
          if(!empty($txtProcessEntry)){
            DB::table('bo_formuation_child_process_v1')->insert([
              'fm_id' => $lid,
              'phase_code' => $txtPhaseEntryData,
              'Process' => $txtProcessEntry,
              'rpm' => $txtRPMData,
              'temp' => $txtTEMPData
      
            ]);
          }
         
        }


    
    }





    $eventName = "FORMULA-RND-BASEv1";
    $eventINFO = 'Formula FM Code :' . $txtFMCode . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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


    $resp = array(
      'status' => 1,
      'Message' => 'Submitted successfully',
    );
    return response()->json($resp);
  }

  //saveFormulaRNDBasev1


  //IngredientsFormulation
  public function IngredientsFormulation()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredentsFormulation', $data)->render();
  }
  public function FormulationBase()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.FormulationBase', $data)->render();
  }


  //FormulationBase
  //FormulationBase


  //IngredientsFormulationWithBase
  public function IngredientsFormulationWithBase()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredentsFormulation_with_base', $data)->render();
  }

  //getFormulationDataForBase
  public function getFormulationDataForBase(Request $request)
  {
    //print_r($request->all());

    $bo_formuation_childArr = DB::table('bo_formuation_child')
            ->where('fm_id', $request->fm_id)
            ->get();
    $bo_formuation_child_processArr = DB::table('bo_formuation_child_process')
    ->where('fm_id', $request->fm_id)
    ->get();


            $resp = array(
              'bo_formuation_child' => $bo_formuation_childArr,
              'bo_formuation_child_process' => $bo_formuation_child_processArr,
            );
            return response()->json($resp);



  }
  //getFormulationDataForBase

  //IngredientsFormulationWithBase

  //IngredientsFormulationEDIT
  public function IngredientsFormulationEDIT($fid)
  {

    

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'fid' => $fid,
     
    ];
    return $theme->scope('rnd.ingredentsFormulationEdit', $data)->render();
  }

  //FormulationEDITv1Base
  public function FormulationEDITv1Base($fid)
  {   
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'fid' => $fid,
     
    ];
    return $theme->scope('rnd.ingredentsFormulationEditBaseV1', $data)->render();
  }

  //FormulationEDITv1Base

  //IngredientsFormulationEDIT

  //FormulationCopyBasev1
  public function FormulationCopyBasev1($fid)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
     'fid' => $fid,
    
   ];
    return $theme->scope('rnd.ingredentsFormulationCopyBaseV1', $data)->render();
  }
  //FormulationCopyBasev1

   //IngredientsFormulationCopy
   public function IngredientsFormulationCopy($fid)
   {
     $theme = Theme::uses('corex')->layout('layout');
     $data = [
      'fid' => $fid,
     
    ];
     return $theme->scope('rnd.ingredentsFormulationCopy', $data)->render();
   }
 
   //IngredientsFormulationCopy

  //IngredientsFormulationList
  public function IngredientsFormulationList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'chemist' || Auth::user()->id==89) {
      return $theme->scope('rnd.ingredentsFormulationList', $data)->render();
    } else {
      abort(404);
    }
  }
  //IngredientsFormulationList

  public function IngredientsFormulationBaseListFrom()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id==206 || Auth::user()->id==89 || Auth::user()->id==249 ) {
      return $theme->scope('rnd.ingredentsFormulationBaseListFrom', $data)->render();
    } else {
      abort(401);
    }
  }
  //IngredientsFormulationBaseList
  public function IngredientsFormulationBaseList()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || Auth::user()->id==206 || Auth::user()->id==89 || Auth::user()->id==249) {
      return $theme->scope('rnd.ingredentsFormulationBaseList', $data)->render();
    } else {
      abort(401);
    }
  }

  //IngredientsFormulationBaseList


  //IngredientsFormulation

  public function Ingredients()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredents', $data)->render();
  }
  //ingredientsPrice
  public function ingredientsPrice()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredentsPrice', $data)->render();
  }
  //ingredientsPrice
  public function ingrednetCategoryList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredent_category_list', $data)->render();
  }
  public function IngredentBrandList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredent_brand_list', $data)->render();
  }



  public function finishProduct(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'SalesUser' || $user_role == 'SalesHead') {
      return $theme->scope('rnd.finish_product_SalesDash', $data)->render();
    } else {
      return $theme->scope('rnd.finish_product', $data)->render();
    }
  }


  public function IngredentList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.ingredent_list', $data)->render();
  }
  public function editING($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $datas = DB::table('rnd_ingredient_supplier')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];
    return $theme->scope('rnd.ingredent_edit', $data)->render();
  }


  public function deleteINGBrand(Request $request)
  {

    //$datas = DB::table('rnd_ingredient_brands')->where('id',$request->rowid)->delete();


    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }


  public function deleteING(Request $request)
  {

    //$datas = DB::table('rnd_ingredient_supplier')->where('id',$request->rowid)->delete();


    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }


  public function getIngredentBrandListID(Request $request)
  {
    $datas = DB::table('rnd_ingredient_brands')->where('id', $request->rowid)->first();
    foreach ($datas as $key => $row) {
      $ingData = array(
        'brand_name' => optional($datas)->brand_name,
        'supplier_name' => optional($datas)->supplier_name,
        'no_of_ing' => optional($datas)->no_of_ing,
        'no_of_formula' => optional($datas)->no_of_formula,
        'no_of_finish_prouduct' => optional($datas)->no_of_finish_prouduct,
      );
    }
    return response()->json($ingData);
  }

  public function getIngredentListID(Request $request)
  {

    $datas = DB::table('rnd_ingredient_supplier')->where('id', $request->rowid)->first();
    //$brands_arr=json_decode($datas->link_brands);
    $sid = $request->rowid;
    $ingBrand = array();
    $brands_arr = DB::table('rnd_supplier_brands')->get();
    $i = 0;
    foreach ($brands_arr as $key => $value) {


      $array = json_decode($value->supplier_id, true);


      if (in_array($sid, $array)) {
        $i++;

        $ingBrand[] = array(
          'brand_name' => optional($value)->brand_name,
          'brand_id' => $i
        );
      }
    }





    // $brands_arr = DB::table('rnd_supplier_brands')->where('id',$request->rowid)->get();

    // $ingBrand=array();
    // foreach ($brands_arr as $key => $row) {            

    //     $ingBrand[]=array(
    //       'brand_id'=>optional($row)->id,
    //       'brand_name'=>optional($row)->brand_name,

    //     );
    // }   
    $ingData = array(
      'company_name' => $datas->company_name,
      'full_address' => $datas->full_address,
      'contact_details' => json_decode($datas->contact_details),
      'link_brands' => $ingBrand,
      'created_by' => $datas->created_by,
    );
    return response()->json($ingData);
  }


  //getRNDFormulataListView
  public function getRNDFormulataListView(Request $request)
  {
    if (Auth::user()->id == 1 || Auth::user()->id == 156) {
      $datas = DB::table('bo_formuation_child')
        ->where('fm_id', $request->sample_action)
        ->get();
    } else {
      $datas = DB::table('bo_formuation_child')
        ->where('fm_id', $request->sample_action)
        ->where('created_by', Auth::user()->id)
        ->get();
    }





    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {


      $datasArr = DB::table('rnd_add_ingredient')
        ->where('id', $dataRow->ingredent_name)
        ->first();

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'ingredent_name' => $dataRow->ingredent_name,
        'dos_percentage' => $dataRow->dos_percentage,
        'mfg_pecentage' => $dataRow->mfg_pecentage,
        'phase' => $dataRow->phase,
        'price' => $dataRow->price,
        'cost' => $dataRow->cost,
        'created_by_name' => $dataRow->created_by_name,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'ingredent_name'      => true,
      'dos_percentage'      => true,
      'mfg_pecentage'      => true,
      'phase'      => true,
      'price'      => true,
      'cost'      => true,
      'created_by_name'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  //getRNDFormulataListView
 //getRNDFormulataListBase
 public function getRNDFormulataListBaseFrom()
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == "Admin") {
      $datas = DB::table('base_bo_formuation_From')->where('is_deleted',0)->where('status',1)
        ->get();
    } else {
      if(Auth::user()->id==89 || Auth::user()->id==206){
        $datas = DB::table('base_bo_formuation_From')->where('is_deleted',0)->get();
      }else{
        $datas = DB::table('base_bo_formuation_From')
        ->where('created_by', Auth::user()->id)
        ->where('is_deleted',0)
        ->get();
      }
     
    }
  
    $totalcost=0;
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $totalcost = DB::table('base_bo_formuation_child_From')
      ->where('fm_id', $dataRow->id)
      ->sum('cost');

    //bo_formuation_v1

    
    $fmCodeArr = DB::table('bo_formuation_v1')
            ->where('id', $dataRow->base_fm_code)
            ->first();


      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'formula_name' => $dataRow->formula_name,
        'fm_code' => $dataRow->fm_code_base,
        'mfg_qty' => $fmCodeArr->mfg_qty,
        'created_by' => AyraHelp::getUser($dataRow->created_by)->name,
        'created_at' => date('j-F-Y', strtotime($dataRow->created_at)),
        'status' => $dataRow->status,
        'created_by' => $dataRow->created_by,
        'created_name' => $dataRow->created_name,
        'totalcost' => "₹".number_format((float)$totalcost, 3, '.', ''),
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'formula_name'      => true,
      'fm_code'      => true,
      'mfg_qty'      => true,
      'created_by'      => true,
      'created_at'      => true,
      'status'      => true,
      'created_by'      => true,
      'created_name'      => true,
      'totalcost'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);


  }


  //getRNDFormulataListBase
  public function getRNDFormulataListBase()
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == "Admin") {
      $datas = DB::table('bo_formuation_v1')->where('is_deleted',0)->where('status',1)
        ->get();
    } else {
      if(Auth::user()->id==89 || Auth::user()->id==206 || Auth::user()->id==249){
        $datas = DB::table('bo_formuation_v1')->where('is_deleted',0)->get();
      }else{
        $datas = DB::table('bo_formuation_v1')
        ->where('created_by', Auth::user()->id)
        ->where('is_deleted',0)
        ->get();
      }
     
    }
  
    $totalcost=0;
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $totalcost = DB::table('bo_formuation_child_v1')
      ->where('fm_id', $dataRow->id)
      ->sum('cost');



      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'formula_name' => $dataRow->formula_name,
        'fm_code' => $dataRow->fm_code,
        'mfg_qty' => $dataRow->mfg_qty,
        'created_by' => AyraHelp::getUser($dataRow->created_by)->name,
        'created_at' => date('j-F-Y', strtotime($dataRow->created_at)),
        'status' => $dataRow->status,
        'created_by' => $dataRow->created_by,
        'created_name' => $dataRow->created_name,
        'totalcost' => "₹".number_format((float)$totalcost, 3, '.', ''),
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'formula_name'      => true,
      'fm_code'      => true,
      'mfg_qty'      => true,
      'created_by'      => true,
      'created_at'      => true,
      'status'      => true,
      'created_by'      => true,
      'created_name'      => true,
      'totalcost'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);


  }

  //getRNDFormulataListBase

  //getRNDFormulataList
  public function getRNDFormulataList()
  {
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == "Admin") {
      $datas = DB::table('bo_formuation')->where('is_deleted',0)->where('status',1)
        ->get();
    } else {
      if(Auth::user()->id==89 || Auth::user()->id==206 || Auth::user()->id==206){
        $datas = DB::table('bo_formuation')->where('is_deleted',0)->get();
      }else{
        $datas = DB::table('bo_formuation')
        ->where('created_by', Auth::user()->id)
        ->where('is_deleted',0)
        ->get();
      }
     
    }
  
    $totalcost=0;
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $totalcost = DB::table('bo_formuation_child')
      ->where('fm_id', $dataRow->id)
      ->sum('cost');



      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'formula_name' => $dataRow->formula_name,
        'fm_code' => $dataRow->fm_code,
        'mfg_qty' => $dataRow->mfg_qty,
        'created_by' => AyraHelp::getUser($dataRow->created_by)->name,
        'created_at' => date('j-F-Y', strtotime($dataRow->created_at)),
        'status' => $dataRow->status,
        'created_by' => $dataRow->created_by,
        'created_name' => $dataRow->created_name,
        'totalcost' => "₹".number_format((float)$totalcost, 3, '.', ''),
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'formula_name'      => true,
      'fm_code'      => true,
      'mfg_qty'      => true,
      'created_by'      => true,
      'created_at'      => true,
      'status'      => true,
      'created_by'      => true,
      'created_name'      => true,
      'totalcost'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);


  }
  //getRNDFormulataList
  //rndINGFormulaBase
  public function rndINGFormulaBase($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $formData = DB::table('base_bo_formuation')
    ->where('id',$id)
    ->first();

    $data = [
    'data' => $formData

    ];
    return $theme->scope('rnd.ingredentsFormulationViewBase', $data)->render();
  }

  //rndINGFormulaBase
  //rndINGFormulav1_FROM
  public function rndINGFormulav1_FROM($id)
{
  $theme = Theme::uses('corex')->layout('layout');
  $formData = DB::table('base_bo_formuation_From')
  ->where('id',$id)
  ->first();
  $data = [
  'data' => $formData
  ];
  return $theme->scope('rnd.ingredentsFormulationViewV1_From', $data)->render();
}



  //rndINGFormulav1_FROM
///rndINGFormulav1
public function rndINGFormulav1($id)
{
  $theme = Theme::uses('corex')->layout('layout');
  $formData = DB::table('bo_formuation_v1')
  ->where('id',$id)
  ->first();
  $data = [
  'data' => $formData
  ];
  return $theme->scope('rnd.ingredentsFormulationViewV1', $data)->render();
}

//rndINGFormulav1

  //rndINGFormula
  public function rndINGFormula($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $formData = DB::table('bo_formuation')
    ->where('id',$id)
    ->first();
$data = [
'data' => $formData

];
    return $theme->scope('rnd.ingredentsFormulationView', $data)->render();
  }
  //rndINGFormula
  //rndINGFormulaCostBase
  public function rndINGFormulaCostBase($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $formData = DB::table('bo_formuation')
    ->where('id',$id)
    ->first();
      $data = [
      'data' => $formData

      ];
    return $theme->scope('rnd.ingredentsFormulationCostViewBase', $data)->render();
  }

  //rndINGFormulaCostBase

  // rndINGFormulaCost
  public function rndINGFormulaCost($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $formData = DB::table('bo_formuation')
    ->where('id',$id)
    ->first();
      $data = [
      'data' => $formData

      ];
    return $theme->scope('rnd.ingredentsFormulationCostView', $data)->render();
  }


  //getIngredientsPrice
  public function getIngredientsPrice()
  {
    // if(Auth::user()->id==901 || Auth::user()->id=1){
    //   $datas = DB::table('rnd_add_ingredient')      
    //   ->get();
    // }else{
    //   $datas = DB::table('rnd_add_ingredient')
    //   ->where('cat_id', '34')
    //   ->get();
    // }
    if (Auth::user()->id == 134 ||Auth::user()->id == 141 || Auth::user()->id == 137 ) {
      $datas = DB::table('rnd_add_ingredient')->where('is_deleted', 0)
        ->get();
        
    } else {
      $datas = DB::table('rnd_add_ingredient')
        ->where('is_deleted', 0)
        ->where('cat_id', 34)
        ->orwhere('cat_id', 35)
        ->orwhere('cat_id', 36)
        ->get();
    }


    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $data_arr = AyraHelp::getRNDIngredientCatID($dataRow->cat_id);


      $data_arr_brand = AyraHelp::getRNDIngredientBrandID($dataRow->ing_brand_name);

      $size_priceArr = json_decode($dataRow->size_price);
      $SRHTML = "";
      foreach ($size_priceArr as $key => $rData) {
        if (!empty($rData->rateData)) {
          $SRHTML .= "₹" . $rData->rateData . "-" . $rData->sizeData . "Kg<br>";
        }
      }

      if (!empty($dataRow->customFileCOA)) {

        $customFileCOA = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileCOA;
      } else {
        $customFileCOA = optional($dataRow)->customFileCOA;
      }

      if (!empty($dataRow->customFileMSDS)) {

        $customFileMSDS = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileMSDS;
      } else {
        $customFileMSDS = optional($dataRow)->customFileMSDS;
      }



      if (!empty($dataRow->customFileGS)) {

        $customFileGS = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileGS;
      } else {
        $customFileGS = optional($dataRow)->customFileGS;
      }



      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'name' => optional($dataRow)->name,
        'cat_id' => optional($data_arr)->category_name,
        'ing_brand_name' => optional($data_arr_brand)->brand_name,
        'ppkg' => optional($dataRow)->ppkg,
        'recommandation_dose' => optional($dataRow)->recommandation_dose,
        'spz' => optional($dataRow)->spz,
        'av_lose' => optional($dataRow)->av_lose,
        'lead_type' => optional($dataRow)->lead_type,
        'sap_code' => optional($dataRow)->sap_code,
        'SRHTML' => $SRHTML,
        'size_1' => optional($dataRow)->size_1,
        'price_1' => optional($dataRow)->price_1,
        'size_2' => optional($dataRow)->size_2,
        'price_2' => optional($dataRow)->price_2,
        'size_3' => optional($dataRow)->size_3,
        'price_3' => optional($dataRow)->price_3,
        'customFileCOA' => $customFileCOA,
        'customFileMSDS' => $customFileMSDS,
        'customFileGS' => $customFileGS,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'name'      => true,
      'cat_id'      => true,
      'ing_brand_name'      => true,
      'ppkg'      => true,
      'recommandation_dose'      => true,
      'spz'      => true,
      'av_lose'      => true,
      'lead_type'      => true,
      'sap_code'      => true,
      'SRHTML'      => true,
      'size_1'      => true,
      'price_1'      => true,
      'size_2'      => true,
      'price_2'      => true,
      'size_3'      => true,
      'price_3'      => true,
      'customFileCOA'      => true,
      'customFileMSDS'      => true,
      'customFileGS'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  function total_sun($month, $year)
  {
    $sundays = 0;
    $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i = 1; $i <= $total_days; $i++)
      if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7)
        $sundays++;
    return $sundays;
  }

  //getIngredientsPrice
  public function downLoadAttrnDPDF()
  {
    //echo $name;
    $No_Sun = $this->total_sun(date('m'), date('Y'));
    // emp_attendance_data


    $QID = 1;
    //print_r($request->all());
    $html = "";
    $fileName = 'PDF/Ingredent_priceList' . rand() . $QID . ".pdf";
    $html = file_get_contents("atten_print.html");




    $rndDataArr = DB::table('emp_attendance_data')->get();
    foreach ($rndDataArr as $key => $rowdata) {


      $data_arrs = json_decode($rowdata->atten_data);
      $ajhtml = "";
      $x = 0;
      foreach ($data_arrs as $key => $row) {

        $contains = Str::contains($row[0], ':');
        $i = 0;
        if ($contains == 1) {


          //get hour of day
          $today_arr = explode(" ", $row[0]);
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

          $i = 0;
          //  if($hours<9){
          //      $lf++;
          //  }
          $badata = $hours . "Hr " . $minutes . "m";
          $totmin = $hours * 60 + $minutes;
          $tM = intVal($totmin);
          // if (intVal($totmin) >= 510) {

          //   $badge = '<span  style="color:green">' . $badata . '</span>';
          // } else {

          //   $badge = '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">' . $badata . '</span>';
          // }

          // $whour = $row[0] . ":" . $badge;
          if ($tM >= 510) {
            $x++;
            $whour = $row[0] . ":" . $badata;
            $ajhtml .= '<td style=" background-color:green;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $whour . '</td>';
          }
          if ($tM < 495) {
            $x++;
            $whour = $row[0] . ":" . $badata;
            $ajhtml .= '<td style=" background-color:red;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $whour . '</td>';
          }

          if ($tM >= 495 && $tM < 510) {
            $x++;
            $whour = $row[0] . ":" . $badata;
            $ajhtml .= '<td style=" background-color:orange;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $whour . '</td>';
          }

          $whour = $row[0] . "*" . $tM;

          //$ajhtml .='<td style=" background-color:white;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">'.$whour.'</td>';


        } else {
          $whour = '';
          $ajhtml .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $whour . '</td>';
        }
      }
      $str_length = 8;
      $num = $rowdata->emp_id;
      $Eid_code = "ID:" . substr("00000000{$num}", -$str_length);
      $days = intVal($x) + intVal($No_Sun);

      $ajhtml .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $Eid_code . '</td>';
      $ajhtml .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">' . $days . '</td>';




      $html .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="right" sdval="1" sdnum="16393;">' . $i . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">' . $rowdata->name . '(' . $rowdata->emp_id . ')</td>';
      $html = $html . $ajhtml;


      $html .= '</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		';

      $data_arrs = json_decode($rowdata->atten_data);
      $ajhtml = "";
      $x = 0;
      $toHour = 0;
      foreach ($data_arrs as $key => $row) {

        $contains = Str::contains($row[0], ':');
        $i = 0;
        if ($contains == 1) {


          //get hour of day
          $today_arr = explode(" ", $row[0]);
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

          $i = 0;
          //  if($hours<9){
          //      $lf++;
          //  }
          $badata = $hours . "Hr " . $minutes . "m";
          $totmin = $hours * 60 + $minutes;
          $tM = intVal($totmin);



          $whour = $tM;

          //$ajhtml .='<td style=" background-color:white;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="5" sdnum="16393;">'.$whour.'</td>';


        } else {
          $whour = 0;
        }


        if ($whour > 540) {
          $overTimeHour = $whour - 540;
          $hours = floor($overTimeHour / 60);
          $min = $overTimeHour - $hours * 60;
          if ($hours >= 1) {

            if ($hours == 1) {
              if ($min >= 30) {
                $overH = 3;
                $toHour = $toHour + $overH;
              } else {
                $overH = 2;
                $toHour = $toHour + $overH;
              }
            }
            if ($hours == 2) {
              $overH = 3;
              $toHour = $toHour + $overH;
            }
            if ($hours == 3) {
              $overH = 4;
              $toHour = $toHour + $overH;
            }
            if ($hours == 4) {
              $overH = 5;
              $toHour = $toHour + $overH;
            }
          } else {
            $overH = 0;
            $toHour = $toHour + $overH;
          }
        } else {
          $overTimeHour = "";
          $hours = "";
          $min = "";
          $overH = 0;
          $toHour = $toHour + $overH;
        }


        $html .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br>' . $overH . '</td>';
      }



      $html .= '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br>' . $toHour . '</td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><br></td>
	</tr>';
    }

    $html .= '</table>
  
  </body>
  
  </html>
  ';

    echo $html;
    die;


    //$html='<h1>welcome</h1>';
    $paper_size = array(0, 0, 400, 400);

    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

    $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait')->setWarnings(false)->save($fileName);
    //echo $fileName;
    return $pdf->stream();
  }

  //downLoadRNDPDFSample
  public function downLoadRNDPDFSample($name)
  {
    //echo $name;
    if ($name == "ALL") {
      $rndDataArr = DB::table('rnd_add_ingredient')
        // ->where('cat_id',$catid)
        ->get();
    } else {

      $rndData = DB::table('rnd_ingredient_category')
        ->where('category_name', $name)
        ->orderBy('category_name')
        ->first();
      $catid = $rndData->id;

      $rndDataArr = DB::table('rnd_add_ingredient')
        ->where('cat_id', $catid)
        ->get();
    }






    $QID = 1;
    //print_r($request->all());
    $html = "";
    $fileName = 'PDF/Ingredent_priceList' . rand() . $QID . ".pdf";
    $html = file_get_contents("rnd_print.html");
    $html .= '
	<tr>
  <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle>1</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle><b>Product Name</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Category</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg1</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate1</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg2</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate2</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg3</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate3</b></td>
	</tr>';


    foreach ($rndDataArr as $key => $rowData) {


      $html .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle>' . @$rowData->id . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle>' . @$rowData->name . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>' . @$name . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>' . @$rowData->size_1 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="522.22" sdnum="16393;">' . @$rowData->price_1 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' . @$rowData->size_2 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="252.22" sdnum="16393;">' . @$rowData->price_2 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' . @$rowData->size_3 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="124.22" sdnum="16393;">' . @$rowData->price_3 . '</td>
	</tr>';


      //aaa


    }






    $html .= '<tr>
 <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=7 height="119" align="center" valign=middle><br><img src="https://res.cloudinary.com/imajkumar/image/upload/v1609831985/bointl/boBotton.jpg" width=719 height=83 hspace=28 vspace=21>
 </td>
 </tr>

</table>

</body>

</html>';


    //$html='<h1>welcome</h1>';
    $paper_size = array(0, 0, 400, 400);

    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

    $pdf = PDF::loadHTML($html)->setPaper('A4', 'landscape')->setWarnings(false)->save($fileName);
    //echo $fileName;
    return $pdf->stream();
  }

  //downLoadRNDPDFSample

  //downLoadRNDPDF
  public function downLoadRNDPDF($name)
  {
    //echo $name;
    if ($name == "ALL") {
      $rndDataArr = DB::table('rnd_add_ingredient')
        // ->where('cat_id',$catid)
        ->get();
    } else {
      $rndData = DB::table('rnd_ingredient_category')
        ->where('category_name', $name)
        ->orderBy('category_name')
        ->first();
      $catid = $rndData->id;

      $rndDataArr = DB::table('rnd_add_ingredient')
        ->where('cat_id', $catid)
        ->get();
    }






    $QID = 1;
    //print_r($request->all());
    $html = "";
    $fileName = 'PDF/Ingredent_priceList' . rand() . $QID . ".pdf";
    $html = file_get_contents("rnd_print.html");
    $html .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 height="20" align="center" valign=middle bgcolor="#FFFF00"><b><font size=3>PRICE LIST  (w.e.f ' . Date('j F Y ') . ')</font></b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle><b>Product Name</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Category</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg1</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate1</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg2</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate2</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Pkg3</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><b>Rate3</b></td>
	</tr>';


    foreach ($rndDataArr as $key => $rowData) {

      //aaa
      //   $html .='<tr>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left">'.$rowData->name.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">'.$name.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"></td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>'.$rowData->size_1.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right">'.$rowData->price_1.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>'.$rowData->size_2.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right">'.$rowData->price_2.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>'.$rowData->size_3.'</td>
      //   <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right">'.$rowData->price_3.'</td>
      // </tr>';
      $html .= '<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="center" valign=middle>' . @$rowData->name . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>' . @$name . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>' . @$rowData->size_1 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="522.22" sdnum="16393;">' . @$rowData->price_1 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' . @$rowData->size_2 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="252.22" sdnum="16393;">' . @$rowData->price_2 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center">' . @$rowData->size_3 . '</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" sdval="124.22" sdnum="16393;">' . @$rowData->price_3 . '</td>
	</tr>';


      //aaa


    }






    $html .= '<tr>
 <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 rowspan=7 height="119" align="center" valign=middle><br><img src="https://res.cloudinary.com/imajkumar/image/upload/v1609831985/bointl/boBotton.jpg" width=719 height=83 hspace=28 vspace=21>
 </td>
 </tr>

</table>

</body>

</html>';


    //$html='<h1>welcome</h1>';
    $paper_size = array(0, 0, 400, 400);

    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

    $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait')->setWarnings(false)->save($fileName);
    //echo $fileName;
    return $pdf->stream();
  }
  //downLoadRNDPDF

  public function getIngredients()
  {
    $datas = DB::table('rnd_add_ingredient')->where('is_deleted', 0)
      ->get();
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $data_arr = @AyraHelp::getRNDIngredientCatID($dataRow->cat_id);


      $data_arr_brand = @AyraHelp::getRNDIngredientBrandID($dataRow->ing_brand_name);

      $size_priceArr = json_decode($dataRow->size_price);
      $SRHTML = "";
      $i = 0;
      foreach ($size_priceArr as $key => $rData) {

        // if(!empty($rData->rateData)){
        //   $i++;
        //   $SRHTML .="₹".$rData->rateData."-".$rData->sizeData."Kg<br>";
        //   if($i==1){
        //     $affected = DB::table('rnd_add_ingredient')
        //     ->where('id', $dataRow->id)
        //     ->update([
        //       'size_1' =>$rData->sizeData."Kg",
        //       'price_1' =>"Rs.".$rData->rateData,

        //     ]
        //     );
        //   }
        //   if($i==2){
        //     $affected = DB::table('rnd_add_ingredient')
        //     ->where('id', $dataRow->id)
        //     ->update([
        //       'size_2' =>$rData->sizeData."Kg",
        //       'price_2' =>"Rs.".$rData->rateData,

        //     ]
        //     );
        //   }

        //   if($i==3){
        //     $affected = DB::table('rnd_add_ingredient')
        //     ->where('id', $dataRow->id)
        //     ->update([
        //       'size_3' =>$rData->sizeData."Kg",
        //       'price_3' =>"Rs.".$rData->rateData,

        //     ]
        //     );
        //   }



        // }

      }

      //
      if (!empty($dataRow->customFileCOA)) {

        $customFileCOA = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileCOA;
      } else {
        $customFileCOA = optional($dataRow)->customFileCOA;
      }

      if (!empty($dataRow->customFileMSDS)) {

        $customFileMSDS = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileMSDS;
      } else {
        $customFileMSDS = optional($dataRow)->customFileMSDS;
      }



      if (!empty($dataRow->customFileGS)) {

        $customFileGS = asset('local/public/uploads/photos') . "/" . optional($dataRow)->customFileGS;
      } else {
        $customFileGS = optional($dataRow)->customFileGS;
      }



      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'name' => optional($dataRow)->name,
        'inci' => optional($dataRow)->inci,
        'cat_id' => optional($data_arr)->category_name,
        'ing_brand_name' => optional($data_arr_brand)->brand_name,
        'ppkg' => optional($dataRow)->ppkg,
        'recommandation_dose' => optional($dataRow)->recommandation_dose,
        'spz' => optional($dataRow)->spz,
        'av_lose' => optional($dataRow)->av_lose,
        'lead_type' => optional($dataRow)->lead_type,
        'sap_code' => optional($dataRow)->sap_code,
        'size_1' => optional($dataRow)->size_1,
        'price_1' => optional($dataRow)->price_1,
        'size_2' => optional($dataRow)->size_2,
        'price_2' => optional($dataRow)->price_2,
        'size_3' => optional($dataRow)->size_3,
        'price_3' => optional($dataRow)->price_3,
        'ingb_other_name' => optional($dataRow)->ingb_other_name,
        'SRHTML' => $SRHTML,
        'customFileCOA' => $customFileCOA,
        'customFileMSDS' => $customFileMSDS,
        'customFileGS' => $customFileGS,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'name'      => true,
      'cat_id'      => true,
      'ing_brand_name'      => true,
      'ppkg'      => true,
      'recommandation_dose'      => true,
      'spz'      => true,
      'av_lose'      => true,
      'lead_type'      => true,
      'sap_code'      => true,
      'SRHTML'      => true,
      'size_1'      => true,
      'price_1'      => true,
      'size_2'      => true,
      'price_2'      => true,
      'size_3'      => true,
      'price_3'      => true,
      'customFileCOA'      => true,
      'customFileMSDS'      => true,
      'customFileGS'      => true,
      'ingb_other_name'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }

  public function deleteFinishProduct(Request $request)
  {
    //$datas = DB::table('rnd_finish_products')->where('id',$request->rowid)->delete();

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }
  public function saveNewProductDevelopment(Request $request)
  {



    $npd_data = new NPD_Data;
    $npd_data->type = $request->product_type;
    $npd_data->name = $request->product_name;
    $npd_data->sub_cat_id = $request->cat_id;
    $npd_data->discription_info = $request->product_info;
    $npd_data->claim_required = $request->claim_required;
    $npd_data->benchmark_provided = $request->benchmark_provided;
    $npd_data->website_url = $request->benchmark_url;
    $npd_data->suggested_ingredent = $request->suggested_ingredient;
    $npd_data->color = $request->p_color;
    $npd_data->fragrance = $request->p_fragrance;
    $npd_data->target_sell_price = $request->p_target_sell_price;
    $npd_data->remarks = $request->npdev_remarks;


    $npd_data->save();

    //   $data= DB::table('rnd_new_product_development')->insert(
    //     [
    //       'type' =>$request->product_type, 
    //       'name' =>$request->product_name,
    //       'sub_cat_id' =>$request->cat_id,
    //       'discription_info' =>$request->product_info,
    //       'claim_required' =>$request->claim_required,
    //       'benchmark_provided' =>$request->benchmark_provided,
    //       'website_url' =>$request->benchmark_url,
    //       'suggested_ingredent' =>$request->suggested_ingredient,
    //       'color' =>$request->p_color,
    //       'fragrance' =>$request->p_fragrance,
    //       'target_sell_price' =>$request->p_target_sell_price
    //       ]
    // );
    // print_r($data);
    // die;


    DB::table('st_process_action_3')->insert(
      [
        'ticket_id' => $npd_data->id,
        'process_id' => 3,
        'stage_id' => 1,
        'action_on' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'expected_date' => date('Y-m-d H:i:s'),
        'remarks' => 'Auto Completed:by added ',
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



  public function NewProductProductDevlopment(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.new_product_development', $data)->render();
  }

  public function NewProductProductDevlopmentList(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.new_product_developmentList', $data)->render();
  }






  public function EditFinishProduct(Request $request)
  {
    // print_r($request->all);

    DB::table('rnd_finish_products')
      ->where('id', $request->txtPDID)
      ->update(
        [
          'product_name' => $request->finish_p_name,
          'cat_id' => $request->finish_p_catid,
          'chemist_by' => $request->finish_p_chemist,
          'grade_id' => $request->finish_p_grade,
          'ingredents_details' => $request->finish_p_ingredient,
          'cost_price' => $request->finish_p_cost_price,
          'benifit_claim' => $request->finish_p_benifit_claim,
          'size_1' => $request->rndSizeWith_1,
          'price_1' => $request->rndRateWith_1,
          'size_2' => $request->rndSizeWith_2,
          'price_2' => $request->rndRateWith_2,
          'size_3' => $request->rndSizeWith_3,
          'price_3' => $request->rndRateWith_3,
          'last_updated_on' => date('Y-m-d H:i:s'),
          'updated_by' => Auth::user()->id,
          'formulation_link' => '[""]',
          'ingredent_link' => '[""]'

        ]
      );
    $lid = $request->txtPDID;

    $eventName = "Finish Product Updated";
    $eventINFO = 'Finish proudct of ID  :' . $lid . " and updated by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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
  }

  public function saveFinishProduct(Request $request)
  {

    // echo "<pre>";
    //  print_r($request->all());
    // die;

    DB::table('rnd_finish_products')->insert(
      [
        'product_name' => $request->finish_p_name,
        'cat_id' => $request->finish_p_catid,
        'chemist_by' => $request->finish_p_chemist,
        'grade_id' => $request->finish_p_grade,
        'ingredents_details' => $request->finish_p_ingredient,
        'cost_price' => $request->finish_p_cost_price,
        'benifit_claim' => $request->finish_p_benifit_claim,
        'size_1' => $request->rndSizeWith_1,
        'price_1' => $request->rndRateWith_1,
        'size_2' => $request->rndSizeWith_2,
        'price_2' => $request->rndRateWith_2,
        'size_3' => $request->rndSizeWith_3,
        'price_3' => $request->rndRateWith_3,
        'last_updated_on' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
        'formulation_link' => '[""]',
        'ingredent_link' => '[""]'

      ]
    );
    $lid = DB::getPdo()->lastInsertId();

    $eventName = "Finish Product";
    $eventINFO = 'Finish proudct of ID :' . $lid . " and added by  " . Auth::user()->name;

    $eventID = $lid;
    $userID = Auth::user()->id;
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
  }

  public function saveFinishProductAA(Request $request)
  {

    DB::table('rnd_finish_products')->insert(
      [
        'product_name' => $request->finish_p_name,
        'cat_id' => $request->finish_p_catid,
        'chemist_by' => $request->finish_p_chemist,
        'sap_code' => $request->finish_p_sap_code,
        'ingredents_details' => $request->finish_p_ingredient,
        'cost_price' => $request->finish_p_cost_price,
        'benifit_claim' => $request->finish_p_benifit_claim,
        'formulation_link' => '[""]',
        'ingredent_link' => '[""]'

      ]
    );
  }

  //importFinishProduct
  public function importFinishProduct(Request $request)
  {
    // print_r($request->all());
    $validator = Validator::make(
      [
        'm_csvfile' => $request,
        'extension' => strtolower($request->m_csvfile->getClientOriginalExtension()),
      ],
      [
        'm_csvfile' => 'required',
        'extension' => 'required|in:csv',
      ]
    )->validate();

    if ($file = $request->hasFile('m_csvfile')) {
      $file = $request->file('m_csvfile');
      $fileName = time() . $file->getClientOriginalName();
      //$destinationPath = ITEM_IMG_PATH;
      $FinishProductArr = $this->csvToArray($file);
      // echo "<pre>";
      foreach ($FinishProductArr as $key => $row) {

        $product_name = $row[0];
        $product_catName = $row[1];
        $size_1 = str_replace("KG", "", $row[2]);
        $price_1 = $row[3];

        $size_2 = str_replace("KG", "", $row[4]);
        $price_2 = $row[5];

        $size_3 = str_replace("KG", "", $row[6]);
        $price_3 = $row[7];



        $finalArrData = DB::table('rnd_finish_product_cat')
          ->where('cat_name', $product_catName)
          ->first();

        $finalArrDataSub = DB::table('rnd_finish_product_subcat')
          ->where('cat_id', $finalArrData->id)
          ->first();



        DB::table('rnd_finish_products')
          ->updateOrInsert(
            [
              'product_name' => $product_name
            ],
            [
              'size_1' => $size_1,
              'cat_id' => $finalArrDataSub->id,
              'price_1' => $price_1,
              'size_2' => $size_2,
              'price_2' => $price_2,
              'size_3' => $size_3,
              'price_3' => $price_3,
              'last_updated_on' => date('Y-m-d H:i:s'),
              'updated_by' => 21,
            ]
          );
      }
    }
  }
  //importFinishProduct

  function csvToArray($filename = '', $delimiter = ',')
  {
    if (!file_exists($filename) || !is_readable($filename))
      return false;

    $header = null;
    $data = array();

    if (($handle = fopen($filename, 'r')) !== false) {
      while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {

        if (!$header)
          $header = $row;
        else
          $data[] = $row;
      }
      fclose($handle);
    }

    return $data;
  }



  //exportExcelFinishProduct
  public function exportExcelFinishProduct(Request $request)
  {
    $dataData = DB::table('rnd_finish_products')->whereNotNull('cat_id')->get();
    $leadReposts = array();
    foreach ($dataData as $key => $rowData) {

      $leadReposts[] = $rowData;
    }

    $headers = array(
      'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
      'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
      'Content-Disposition' => 'attachment; filename=abc.csv',
      'Expires' => '0',
      'Pragma' => 'public',
    );
    $filename = "uploads/reports.csv";
    $handle = fopen($filename, 'w');
    fputcsv($handle, [
      "ID",
      "Product Name",
      "Grade",
      "Category",
      "Sub Category",
      "Size_1(KG)",
      "Price_1(Rs.)",
      "Size_2(KG)",
      "Price_2(Rs.)",
      "Size_3(KG)",
      "Price_3(Rs.)",


    ]);
    $i = 1;
    foreach ($leadReposts as $lead) {
      // print_r($lead);
      // die;
      $fp_arr = AyraHelp::getFinishPSubCatDetail($lead->cat_id);
      $fp_arr_data = AyraHelp::getFinishPCatDetail($fp_arr->cat_id);
      $catName = ucwords(strtolower(optional($fp_arr_data)->cat_name));
      $subCatName = ucwords(strtolower(optional($fp_arr)->sub_cat_name));

      switch ($lead->grade_id) {
        case 1:
          $strLeadGrade = "Premium";
          break;
        case 2:
          $strLeadGrade = "Standard";
          break;
        case 3:
          $strLeadGrade = "Regular";
          break;

        default:
          $strLeadGrade = "NA";
          break;
      }
      fputcsv($handle, [
        $lead->id,
        $lead->product_name,
        $strLeadGrade,
        $catName,
        $subCatName,
        $lead->size_1 .
          $lead->price_1,
        $lead->size_2,
        $lead->price_2,
        $lead->size_3,
        $lead->price_3


      ]);
      $i++;
    }
    fclose($handle);
    return Response::download($filename, "finish_product_pricesList.xlsx", $headers);


    //--------------------------------
  }

  //exportExcelFinishProduct
  public function addFinishProduct(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      'users' => '',
    ];
    return $theme->scope('rnd.addFinishProduct', $data)->render();
  }
  public function getFinishProductList(Request $request)
  {

    $datas = DB::table('rnd_finish_products')->whereNotNull('cat_id')->get();
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      // $contact_arr=json_decode($dataRow->contact_details);
      // $link_brands_arr=json_decode($dataRow->link_brands);
      $fp_arr = AyraHelp::getFinishPSubCatDetail($dataRow->cat_id);
      $fp_arr_data = AyraHelp::getFinishPCatDetail($fp_arr->cat_id);
      $fp_arr_dataSCount = AyraHelp::getSampleCountFinishProduct(strtoupper(strtolower(optional($dataRow)->product_name)));

      if (empty($dataRow->grade_id)) {
        $grade = "NA";
      } else {
        switch ($dataRow->grade_id) {
          case 1:
            $grade = "Premium";
            break;
          case 2:
            $grade = "Standard";
            break;
          case 3:
            $grade = "Regular";
            break;
        }
      }

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'product_name' => strtoupper(strtolower(optional($dataRow)->product_name)),
        'cat' => ucwords(strtolower(optional($fp_arr_data)->cat_name)),
        //'cat' => 'NA',
        'subcat' => ucwords(strtolower(optional($fp_arr)->sub_cat_name)),
        'sap_code' => optional($dataRow)->sap_code,
        'chemist_by' => @AyraHelp::getUser($dataRow->chemist_by)->name,
        'cost_price' => optional($dataRow)->cost_price,
        'sample_sent' => $fp_arr_dataSCount,
        'sp_min' => IS_NULL(optional($dataRow)->sp_min) ? '' : optional($dataRow)->sp_min,
        'sp_max' => IS_NULL(optional($dataRow)->sp_max) ? '' : optional($dataRow)->sp_max,
        'size_1' => strtoupper(strtolower(optional($dataRow)->size_1)) . "Kg",
        'size_2' => strtoupper(strtolower(optional($dataRow)->size_2)) . "Kg",
        'size_3' => strtoupper(strtolower(optional($dataRow)->size_3)) . "Kg",
        'price_1' => "Rs." . strtoupper(strtolower(optional($dataRow)->price_1)),
        'price_2' => "Rs." . strtoupper(strtolower(optional($dataRow)->price_2)),
        'price_3' => "Rs." . strtoupper(strtolower(optional($dataRow)->price_3)),
        'grade_id' => $grade,
        'order_recieved' => '',
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID' => true,
      'product_name' => true,
      'cat' => true,
      'subcat'  => true,
      'sap_code' => true,
      'chemist_by' => true,
      'cost_price' => true,
      'sample_sent' => true,
      'sp_min' => true,
      'sp_max' => true,
      'order_recieved' => true,
      'size_1' => true,
      'size_2' => true,
      'size_3' => true,
      'price_1' => true,
      'price_2' => true,
      'price_3' => true,
      'grade_id' => true,
      'Actions'  => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
  public function UpdateINGCategorydata(Request $request)
  {

    DB::table('rnd_ingredient_category')
      ->where('id', $request->txtCatId)
      ->update([
        'category_name' => $request->ingbcatName,
        'brand_name' => $request->ingbcatBrandAvailable,
        'no_of_ing' => $request->ingbcatNoIngredient,
        'no_of_formula' => $request->ingbcatNoFormulation,
        'no_of_finish_prouduct' => $request->ingbcatNoProduction,
        'created_by' => Auth::user()->id
      ]);
  }
  public function editINGCategory($id)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $datas = DB::table('rnd_ingredient_category')->where('id', $id)->first();

    $data = [
      'data' => $datas,
    ];

    return $theme->scope('rnd.editINGCategory', $data)->render();
  }
  public function deleteINGCategory(Request $request)
  {
    // $datas = DB::table('rnd_ingredient_category')->where('id',$request->rowid)->delete();

    $resp = array(
      'status' => 1
    );
    return response()->json($resp);
  }

  public function getIngredentCategoryList(Request $request)
  {
    $datas = DB::table('rnd_ingredient_category')
      ->get();
    $data_arr_1 = array();

    foreach ($datas as $key => $dataRow) {

      // $contact_arr=json_decode($dataRow->contact_details);
      // $link_brands_arr=json_decode($dataRow->link_brands);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'category_name' => optional($dataRow)->category_name,
        'brand_name' => optional($dataRow)->brand_name,
        'no_of_ing' => optional($dataRow)->no_of_ing,
        'no_of_formula' => optional($dataRow)->no_of_formula,
        'no_of_finish_prouduct' => optional($dataRow)->no_of_finish_prouduct,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'category_name'      => true,
      'brand_name'      => true,
      'no_of_ing'      => true,
      'no_of_formula'      => true,
      'no_of_finish_prouduct'      => true,
      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }



  public function getIngredentBrandList(Request $request)
  {
    $datas = DB::table('rnd_supplier_brands')
      ->get();
    $data_arr_1 = array();




    foreach ($datas as $key => $dataRow) {
      $suplier = array();
      $link_brands_arr = json_decode($dataRow->supplier_id);
      foreach ($link_brands_arr as $key => $value) {

        $data_arr = AyraHelp::getRNDSupplerDetails($link_brands_arr[$key]);

        $suplier[] = optional($data_arr)->company_name;
      }






      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'brand_name' => optional($dataRow)->brand_name,
        'supplier_name' => $suplier,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'supplier_name'      => true,
      'brand_name'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }


  public function getIngredentList(Request $request)
  {
    $datas = DB::table('rnd_ingredient_supplier')
      ->get();
    $data_arr_1 = array();
    foreach ($datas as $key => $dataRow) {

      $contact_arr = json_decode($dataRow->contact_details);
      $link_brands_arr = json_decode($dataRow->link_brands);

      $data_arr_1[] = array(
        'RecordID' => $dataRow->id,
        'company_name' => optional($dataRow)->company_name,
        'contact_person' => $contact_arr[0]->contact_name,
        'contact_phone' => $contact_arr[0]->contact_phone,
        'contact_email' => $contact_arr[0]->contact_email,
        'company_location' => optional($dataRow)->full_address,
        // 'company_brands' =>optional($link_brands_arr[0])->name,                     
        'c_details' => $contact_arr,
        //'b_details' =>$link_brands_arr,
        'Actions' => ""
      );
    }

    $JSON_Data = json_encode($data_arr_1);
    $columnsDefault = [
      'RecordID'     => true,
      'company_name'      => true,
      'contact_person'      => true,
      'contact_phone'      => true,
      'contact_email'      => true,
      'company_location'      => true,

      'Actions'      => true,
    ];
    $this->DataGridResponse($JSON_Data, $columnsDefault);
  }
}
