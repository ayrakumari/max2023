<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Theme;
use PDF;
use App\ClientNote;
use Illuminate\Database\Eloquent\Model;
use App\Client;
use App\Events\WhatIsHappening;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;
use DB;
use Mail;
use App\Helpers\AyraHelp;
use App\QCFORM;
use App\QCBOM;
use App\OrderEditRequest;
use Pusher;
use App\QCPP;
use App\Sample;
use App\QC_BOM_Purchase;
use App\OrderMaster;
use App\OPData;
use AWS;
use App\Exports\SampleExport;
use Maatwebsite\Excel\Facades\Excel;
use Swift;
// use Schema;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class HomeController extends Controller
{

//getRMData
public function getRMData($restaurant)
{
  

  // $datasArr = DB::table('rnd_add_ingredient')->where()->where('is_deleted', 0)->get();
  // $indArr=array();
  // foreach ($datasArr as $key => $row) {
  //   // print_r($row);
  //    $tokensArr=explode(" ",$row->name);
  //    $indArr[]=array(
  //     'year'=>$row->id,
  //     'value'=>$row->name,
  //     'tokens'=>$tokensArr
  //    );
  // }
  
  // header('Content-Type" => application/json');
  // return response()->json($indArr);

  $restaurants   =  DB::table('rnd_add_ingredient')->where('is_deleted', 0)->where('name', 'LIKE', "%$restaurant%")->get(
    array(
      'name','id','price_1'
      )
  );
  return response()->json($restaurants);

  
}
//getRMData


  //updateRNDChemistNameToQC
  public function updateRNDChemistNameToQC(Request $request)
  {
    $monNum=date('m');
    $monYear=date('Y');
    //$monNum=8;
   // $monYear=2022;

     $qc_formsArrData = DB::table('qc_forms')
    ->where('is_deleted', 0)
    ->whereNotNull('item_fm_sample_no')
    // ->where('account_approval', 1)
    ->where('item_fm_sample_no','!=', 'Regular')
    ->where('item_fm_sample_no','!=', 'Standard')
    ->where('curr_stage_name', 'Dispatch')
    ->whereMonth('curr_stage_updated_on', $monNum)
    ->whereYear('curr_stage_updated_on', $monYear)   
    ->get();
  

    foreach ($qc_formsArrData as $key => $row) {
     $sample_id=$row->item_fm_sample_no;

      $sampleFormula = DB::table('samples_formula')
            ->where('sample_code_with_part',$sample_id)
            ->first();

            
            $sampleArr = DB::table('samples')
            ->where('id',@$sampleFormula->sample_id)
            ->first();
            



      DB::table('rnd_incentives_list')
      ->updateOrInsert(
          [
            'user_id' =>@$sampleFormula->chemist_id, 
            'in_month' =>intVal($monNum),
            'in_year' => intVal($monYear),
            'sample_no' => $sample_id,
            'form_id' => @$row->form_id
          ],
          [
            'sample_no' => $sample_id,
            'sample_brand_type' => @$sampleArr->brand_type,
            'sample_order_type' => @$sampleArr->order_size,
            'formulated_on' => @$sampleFormula->created_on,
            'brand_name' => @$row->brand_name,
            'order_item_name' => @$row->item_name,
            'sample_item_name' => @$sampleFormula->item_name,
            'form_id' => @$row->form_id,
            'order_id' => @$row->order_id.'/'.$row->subOrder,
            'formula_id' => @$sampleFormula->id,
            'invoice_date' => @$row->curr_stage_updated_on
          ]
      );  

      

    }


  }
  //updateRNDChemistNameToQC

  //sendMailtoClient
  public function sendMailtoClient(Request $request)
  {









    //$queries = \DB::getQueryLog();
    //return dd($queries);
  }
  //sendMailtoClient

  //einvoiceSave
  public function einvoiceSave(Request $request)
  {


    $invTranDtls = array(
      'TaxSch' => 'GST',
      'SupTyp' => 'B2B',
      'RegRev' => 'Y',
      'EcmGstin' => null,
      'IgstOnIntra' => 'N',
    );

    $DocDtls = array(
      'Typ' => 'BO',
      'No' => 'BO/2022-23/0001',
      'Dt' => '25/03/2022'
    );

    $SellerDtls = array(
      'Gstin' => '37ARZPT4384Q1MT',
      'LglNm' => 'NIC company pvt ltd',
      'TrdNm' => 'NIC Industries',
      'Addr1' => '5th block, kuvempu layout',
      'Addr2' => 'kuvempu layout',
      'Loc' => 'GANDHINAGAR',
      'Pin' => 518001,
      'Stcd' => '37',
      'Ph' => '9000000000',
      'Em' => 'abc@gmail.com'
    );

    $BuyerDtls = array(
      'Gstin' => '29AWGPV7107B1Z1',
      'LglNm' => 'XYZ company pvt ltd',
      'TrdNm' => 'XYZ Industries',
      'Pos' => '12',
      'Addr1' => '7th block, kuvempu layout',
      'Addr2' => 'kuvempu layout',
      'Loc' => 'GANDHINAGAR',
      'Pin' => 562160,
      'Stcd' => '29',
      'Ph' => '9111111111',
      'Em' => 'xyz@yahoo.com',
    );

    $DispDtls = array(
      'Nm' => 'ABC company pvt ltd',
      'Addr1' => '7th block, kuvempu layout',
      'Addr2' => 'kuvempu layout',
      'Loc' => 'Banagalore',
      'Pin' => 562160,
      'Stcd' => '29'
    );

    $ShipDtls = array(
      'Gstin' => '29AWGPV7107B1Z1',
      'LglNm' => 'CBE company pvt ltd',
      'TrdNm' => 'kuvempu layout',
      'Addr1' => '7th block, kuvempu layout',
      'Addr2' => 'kuvempu layout',
      'Loc' => 'Banagalore',
      'Pin' => 562160,
      'Stcd' => '29'
    );
    $ItemList = array(
      "SlNo" => "1",
      "PrdDesc" => "Rice",
      "IsServc" => "N",
      "HsnCd" => "1001",
      "Barcde" => "123456",
      "Qty" => 100.345,
      "FreeQty" => 10,
      "Unit" => "BAG",
      "UnitPrice" => 99.545,
      "TotAmt" => 9988.84,
      "Discount" => 10,
      "PreTaxVal" => 1,
      "AssAmt" => 9978.84,
      "GstRt" => 12,
      "IgstAmt" => 1197.46,
      "CgstAmt" => 0,
      "SgstAmt" => 0,
      "CesRt" => 5,
      "CesAmt" => 498.94,
      "CesNonAdvlAmt" => 10,
      "StateCesRt" => 12,
      "StateCesAmt" => 1197.46,
      "StateCesNonAdvlAmt" => 5,
      "OthChrg" => 10,
      "TotItemVal" => 12897.7,
      "OrdLineRef" => "3256",
      "OrgCntry" => "AG",
      "PrdSlNo" => "12345",
      "BchDtls" => array(
        "Nm" => "123456",
        "ExpDt" => "01/08/2020",
        "WrDt" => "01/09/2020"
      ),
      "AttribDtls" => array(
        array(
          "Nm" => "Rice",
          "Val" => "10000"
        )
      )
    );


    $ValDtls = array(
      "AssVal" => 9978.84,
      "CgstVal" => 0,
      "SgstVal" => 0,
      "IgstVal" => 1197.46,
      "CesVal" => 508.94,
      "StCesVal" => 1202.46,
      "Discount" => 10,
      "OthChrg" => 20,
      "RndOffAmt" => 0.3,
      "TotInvVal" => 12908,
      "TotInvValFc" => 12897.7
    );

    $PayDtls = array(
      "Nm" => "ABCDE",
      "AccDet" => "5697389713210",
      "Mode" => "Cash",
      "FinInsBr" => "SBIN11000",
      "PayTerm" => "100",
      "PayInstr" => "Gift",
      "CrTrn" => "test",
      "DirDr" => "test",
      "CrDay" => 100,
      "PaidAmt" => 10000,
      "PaymtDue" => 5000
    );



    $RefDtls = array(
      'InvRm' => 'TEST',
      'DocPerdDtls' => array(
        "InvStDt" => "01/08/2020",
        "InvEndDt" => "01/09/2020"
      ),
      'PrecDocDtls' => array(array(
        "InvNo" => "DOC/002",
        "InvDt" => "01/08/2020",
        "OthRefNo" => "123456"
      )),
      'ContrDtls' => array(array(
        "RecAdvRefr" => "Doc/003",
        "RecAdvDt" => "01/08/2020",
        "TendRefr" => "Abc001",
        "ContrRefr" => "Co123",
        "ExtRefr" => "Yo456",
        "ProjRefr" => "Doc-456",
        "PORefr" => "Doc-789",
        "PORefDt" => "01/08/2020"
      )),



    );

    $AddlDocDtls = array(
      "Url" => "https://einv-apisandbox.nic.in",
      "Docs" => "Test Doc",
      "Info" => "Document Test"
    );
    $ExpDtls = array(
      "ShipBNo" => "A-248",
      "ShipBDt" => "01/08/2020",
      "Port" => "INABG1",
      "RefClm" => "N",
      "ForCur" => "AED",
      "CntCode" => "AE",
      "ExpDuty" => null
    );
    $EwbDtls = array(
      "TransId" => "12AWGPV7107B1Z1",
      "TransName" => "XYZ EXPORTS",
      "Distance" => 100,
      "TransDocNo" => "DOC01",
      "TransDocDt" => "18/08/2020",
      "VehNo" => "ka123456",
      "VehType" => "R",
      "TransMode" => "1"
    );
    $invoiceArr = array(
      'Version' => '1.1',
      'TranDtls' => $invTranDtls,
      'DocDtls' => $DocDtls,
      'SellerDtls' => $SellerDtls,
      'BuyerDtls' => $BuyerDtls,
      'DispDtls' => $DispDtls,
      'ShipDtls' => $ShipDtls,
      'ItemList' => array($ItemList),
      'ValDtls' => $ValDtls,
      'PayDtls' => $PayDtls,
      'RefDtls' => $RefDtls,
      'AddlDocDtls' => array($AddlDocDtls),
      'ExpDtls' => $ExpDtls,
      'EwbDtls' => $EwbDtls,

    );

    $invDataJSON = json_encode($invoiceArr);

    DB::table('tbl_invoices')->insert([
      'app_ver' => '1.1',
      'inv_data' => $invDataJSON
    ]);
  }

  //einvoiceSave

  //getPaymentOrdersListWithFilterLead
  public function getPaymentOrdersListWithFilterLead(Request $request)
  {
    $dateme = date('Y-m-d', strtotime($request->dateSelected));
    $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
    $chkEmail = $request->chkEmail;

    $startMonth = date('m', strtotime($request->dateSelected));
    $stopMonth = date('m', strtotime($request->dateSelectedTo));
    $year = date('Y', strtotime($request->dateSelectedTo));
    $users = AyraHelp::getSalesAgentAdmin();
    $HTML = '';
    $HTDA = '';
    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTDA .= '<td>' . $monthName . '</td>';
    }
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Name</td>
    ' . $HTDA . '
    </tr>';
    if ($request->user_id == "ALL") {
      foreach ($users as $key => $rowData) {
        $HTD = "";
        for ($i = $startMonth; $i <= $stopMonth; $i++) {
          // echo $i;

          $amt = AyraHelp::getLeadValuesFilter($rowData->id, $i, $year);
          $monthNum = $i;
          $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
          $monthName; // Output: May
          $HTD .= '<td><b>' . $amt . '</b></td>';
        }

        //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
        $HTML .= '<tr> <td>' . $rowData->name . '</td>
         ' . $HTD . '
         </tr>';
      }
    } else {

      $HTD = "";
      for ($i = $startMonth; $i <= $stopMonth; $i++) {
        // echo $i;

        $amt = AyraHelp::getLeadValuesFilter($request->user_id, $i, $year);
        $monthNum = $i;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $monthName; // Output: May
        $HTD .= '<td><b>' . $amt . '</b></td>';
      }
      $name = AyraHelp::getUser($request->user_id)->name;
      //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
      $HTML .= '<tr> <td>' . $name . '</td>
         ' . $HTD . '
         </tr>';
    }






    $HTML .= '</table>';

    echo $HTML;
    if ($chkEmail == 1) {
      require 'vendor/autoload.php';
      $Apikey = "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";
      $subTitle = "Date :" . $dateme . "- " . $datemeTo;
      $subLineM = "Lead Assined or Claim Count Saleswise Report " . ":" . $subTitle;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject($subLineM);
      $email->addTo('gupta@max.net', '');
      // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // $email->addTo('bointlresearch@gmail.com', 'Anitha');
      //$email->addCc('pooja@max.net', 'Pooja Gupta');
      $email->addCc('nitika@max.net', 'Admin');
      // $email->addCc('pooja@max.net', 'Pooja Gupta');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
      $email->addBcc('bointldev@gmail.com', 'Ajay');
      $i = 0;
      $body = $HTML;
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
      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }
    }
  }

  //getPaymentOrdersListWithFilterLead

  //getPaymentOrdersListWithFilterSample
  public function getPaymentOrdersListWithFilterSample(Request $request)
  {
    $dateme = date('Y-m-d', strtotime($request->dateSelected));
    $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
    $chkEmail = $request->chkEmail;

    $startMonth = date('m', strtotime($request->dateSelected));
    $stopMonth = date('m', strtotime($request->dateSelectedTo));
    $year = date('Y', strtotime($request->dateSelectedTo));
    $users = AyraHelp::getSalesAgentAdmin();
    $HTML = '';
    $HTDA = '';
    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTDA .= '<td>' . $monthName . '</td>';
    }
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Name</td>
    ' . $HTDA . '
    </tr>';
    if ($request->user_id == "ALL") {
      foreach ($users as $key => $rowData) {
        $HTD = "";
        for ($i = $startMonth; $i <= $stopMonth; $i++) {
          // echo $i;

          $amt = AyraHelp::getSampleValuesFilter($rowData->id, $i, $year);
          $monthNum = $i;
          $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
          $monthName; // Output: May
          $HTD .= '<td><b>' . $amt . '</b></td>';
        }

        //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
        $HTML .= '<tr> <td>' . $rowData->name . '</td>
         ' . $HTD . '
         </tr>';
      }
    } else {

      $HTD = "";
      for ($i = $startMonth; $i <= $stopMonth; $i++) {
        // echo $i;

        $amt = AyraHelp::getSampleValuesFilter($request->user_id, $i, $year);
        $monthNum = $i;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $monthName; // Output: May
        $HTD .= '<td><b>' . $amt . '</b></td>';
      }
      $name = AyraHelp::getUser($request->user_id)->name;
      //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
      $HTML .= '<tr> <td>' . $name . '</td>
         ' . $HTD . '
         </tr>';
    }






    $HTML .= '</table>';

    echo $HTML;
    if ($chkEmail == 1) {
      require 'vendor/autoload.php';
      $Apikey = "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";
      $subTitle = "Date :" . $dateme . "- " . $datemeTo;
      $subLineM = "Samples Count Saleswise Report " . ":" . $subTitle;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject($subLineM);
      $email->addTo('gupta@max.net', '');
      // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // $email->addTo('bointlresearch@gmail.com', 'Anitha');
      //$email->addCc('pooja@max.net', 'Pooja Gupta');
      $email->addCc('nitika@max.net', 'Admin');
      // $email->addCc('pooja@max.net', 'Pooja Gupta');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
      $email->addBcc('bointldev@gmail.com', 'Ajay');
      $i = 0;
      $body = $HTML;
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
      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }
    }
  }

  //getPaymentOrdersListWithFilterSample
  public function IND_money_format($money)
  {
    $fmt = new \NumberFormatter($locale = 'en_IN', \NumberFormatter::DECIMAL);
    return $fmt->format($money);
  }
  //getPaymentOrdersListWithFilterOrder
  public function getPaymentOrdersListWithFilterOrder(Request $request)
  {
    $dateme = date('Y-m-d', strtotime($request->dateSelected));
    $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
    $chkEmail = $request->chkEmail;

    $startMonth = date('m', strtotime($request->dateSelected));
    $stopMonth = date('m', strtotime($request->dateSelectedTo));
    $year = date('Y', strtotime($request->dateSelectedTo));
    $users = AyraHelp::getSalesAgentAdmin();
    $HTML = '';
    $HTDA = '';
    $HTDA2 = '';
    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTDA .= '<th colspan="3">' . $monthName . '</th>';
      $HTDA2 .= '<td><b>Values</b></td><td><b>Count</b></td><td><b>Average</b></td>';
    }
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Name</td>' . $HTDA . '</tr>';
    $HTML .= '<tr style="background-color:#e5e5e5 "><td></td>' . $HTDA2 . '</tr>';

    if ($request->user_id == "ALL") {
      foreach ($users as $key => $rowData) {
        $HTD = "";

        for ($i = $startMonth; $i <= $stopMonth; $i++) {
          // echo $i;


          $amt = AyraHelp::getOrderValuesFilter($rowData->id, $i, $year);
          $ordeCount = AyraHelp::getOrderCountValuesFilter($rowData->id, $i, $year);
          $avgOrder = 0;
          if ($ordeCount > 0) {

            // echo $amount;

            //  $avgOrder=number_format(($amt/$ordeCount),0);
            $avgOrder = $this->IND_money_format(intVal(($amt / $ordeCount)));
          }
          $monthNum = $i;
          $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
          $monthName; // Output: May
          $HTD .= '<td style="color:#035496">
         
          <b>' . $this->IND_money_format(intVal($amt)) . '</b>
          </td>
          <td>' . $ordeCount . '
          </td>
          <td style="color:#035496">' . $avgOrder . '
          </td>
         
          ';
        }

        //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  

        $HTML .= '<tr> <td>' . $rowData->name . '</td>
         ' . $HTD . '
         </tr>';
      }
    } else {

      $HTD = "";
      for ($i = $startMonth; $i <= $stopMonth; $i++) {
        // echo $i;

        $amt = AyraHelp::getOrderValuesFilter($request->user_id, $i, $year);
        $ordeCount = AyraHelp::getOrderCountValuesFilter($request->user_id, $i, $year);
        $avgOrder = 0;
        if ($ordeCount > 0) {

          // echo $amount;

          //  $avgOrder=number_format(($amt/$ordeCount),0);
          $avgOrder = $this->IND_money_format(intVal(($amt / $ordeCount)));
        }

        $monthNum = $i;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $monthName; // Output: May
        $HTD .= '<td style="color:#035496">
         
          <b>' . $this->IND_money_format(intVal($amt)) . '</b>
          </td>
          <td>' . $ordeCount . '
          </td>
          <td style="color:#035496">' . $avgOrder . '
          </td>
         
          ';
      }
      $name = AyraHelp::getUser($request->user_id)->name;
      //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
      $HTML .= '<tr> <td>' . $name . '</td>
         ' . $HTD . '
         </tr>';
    }






    $HTML .= '</table>';

    echo $HTML;
    if ($chkEmail == 1) {
      require 'vendor/autoload.php';
      $Apikey = "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";
      // $Apikey = "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";
      $subTitle = "Date :" . $dateme . "- " . $datemeTo;
      $subLineM = "Order Values Saleswise Report " . ":" . $subTitle;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject($subLineM);
      $email->addTo('gupta@max.net', '');
      // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // $email->addTo('bointlresearch@gmail.com', 'Anitha');
      //$email->addCc('pooja@max.net', 'Pooja Gupta');
      $email->addCc('nitika@max.net', 'Admin');
      // $email->addCc('pooja@max.net', 'Pooja Gupta');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
      $email->addBcc('bointldev@gmail.com', 'Ajay');
      $i = 0;
      $body = $HTML;
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
      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }
    }
  }
  //getPaymentOrdersListWithFilterOrder

  //setBulkOrderReqIssueProcess
  public function setBulkOrderReqIssueProcess(Request $request)
  {

    $affected = DB::table('qc_forms')
      ->where('form_id', $request->form_id)
      ->update([
        'is_req_for_issue' => $request->reqStatus,
        'is_req_for_issue_date' => date('Y-m-d H:i:s')
      ]);
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;

    switch ($request->reqStatus) {
      case 1:
        $strM = "Requested";
        break;
      case 2:
        $strM = "Accepted";
        break;
      case 3:
        $strM = "Hold";
        break;
      case 4:
        $strM = "Rejected";
        break;
      case 5:
        $strM = "Completed";
        break;
    }


    $eventName = "BulkOrderRequestHis";
    $eventINFO = 'Bulk Order::' . $strM . " by  " . $LoggedName . " on" . date('Y-m-d H:i:s') . " Msg:" . $request->reqMsg;

    $eventID = $request->form_id;
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

    );

    return response()->json($resp);
  }
  //setBulkOrderReqIssueProcess


  public function getPaymentOrdersListWithFilter(Request $request)
  {
    $dateme = date('Y-m-d', strtotime($request->dateSelected));
    $datemeTo = date('Y-m-d', strtotime($request->dateSelectedTo));
    $chkEmail = $request->chkEmail;

    $startMonth = date('m', strtotime($request->dateSelected));
    $stopMonth = date('m', strtotime($request->dateSelectedTo));
    $year = date('Y', strtotime($request->dateSelectedTo));
    $users = AyraHelp::getSalesAgentAdmin();
    $HTML = '';
    $HTDA = '';
    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTDA .= '<td>' . $monthName . '</td>';
    }
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Name</td>
    ' . $HTDA . '
    </tr>';
    if ($request->user_id == "ALL") {
      foreach ($users as $key => $rowData) {
        $HTD = "";
        for ($i = $startMonth; $i <= $stopMonth; $i++) {
          // echo $i;

          $amt = AyraHelp::getPaymentRecFilter($rowData->id, $i, $year);
          $monthNum = $i;
          $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
          $monthName; // Output: May
          $HTD .= '<td style="color:#035496"><b>' . $this->IND_money_format(intVal($amt)) . '</b></td>';
        }

        //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
        $HTML .= '<tr> <td>' . $rowData->name . '</td>
         ' . $HTD . '
         </tr>';
      }
    } else {

      $HTD = "";
      for ($i = $startMonth; $i <= $stopMonth; $i++) {
        // echo $i;

        $amt = AyraHelp::getPaymentRecFilter($request->user_id, $i, $year);
        $monthNum = $i;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $monthName; // Output: May
        $HTD .= '<td><b>' . $amt . '</b></td>';
      }
      $name = AyraHelp::getUser($request->user_id)->name;
      //$HTML .='<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';  
      $HTML .= '<tr> <td>' . $name . '</td>
         ' . $HTD . '
         </tr>';
    }






    $HTML .= '</table>';

    echo $HTML;
    if ($chkEmail == 1) {
      require 'vendor/autoload.php';
      $Apikey = "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";
      $subTitle = "Date :" . $dateme . "- " . $datemeTo;
      $subLineM = "Payment Received Saleswise Report " . ":" . $subTitle;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject($subLineM);
      $email->addTo('gupta@max.net', '');
      //  $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // $email->addTo('bointlresearch@gmail.com', 'Anitha');
      //$email->addCc('pooja@max.net', 'Pooja Gupta');
      //$email->addCc('nitika@max.net', 'Admin');
      // $email->addCc('pooja@max.net', 'Pooja Gupta');
      //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
      // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
      $email->addBcc('bointldev@gmail.com', 'Ajay');
      $i = 0;
      $body = $HTML;
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
      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }
    }
  }

  //payment_order_withFilter
  public function payment_order_withFilter(Request $request)
  {

    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => ''];
    return $theme->scope('sample.payment_order_withFilter', $data)->render();
  }

  //payment_order_withFilter

  public function combos($data, &$all = array(), $group = array(), $val = null, $i = 0)
  {
    if (isset($val)) {
      array_push($group, $val);
    }
    if ($i >= count($data)) {
      array_push($all, $group);
    } else {
      foreach ($data[$i] as $v) {
        $this->combos($data, $all, $group, $v, $i + 1);
      }
    }
    return $all;
  }




  //getCustomProductData
  public function getCustomProductData(Request $request)
  {
    //this is code done 
    $data = array(
      array('body_frame_thin', 'body_frame_medium', 'body_frame_ligre'),
      array('is_sweet_less', 'is_sweet_medium', 'is_sweet_a_lot'),
      array('appetite_irregular', 'appetite_strong', 'appetite_normal'),
      array('hair_volume_fine', 'hair_volume_medium', 'hair_volume_thick'),
      array('hair_type_wavy', 'hair_type_straight', 'hair_type_thick'),
      array('hair_texture_rough_and_dry', 'hair_texture_Silky and smooth', 'hair_texture_Full and lustrous'),
      array('scalp_texture__dry', 'scalp_texture_oily', 'scalp_texture_normal_oily'),
      array('dandruff_yes', 'dandruff_yes'),
      array('gender_male', 'gender_female'),
    );
    $combos = $this->combos($data);

    foreach ($combos as $key => $rowData) {
      # code...DB::table('users')

      // print_r($rowData[0]);
      // print_r($rowData[1]);
      // print_r($rowData[2]);
      // print_r($rowData[3]);
      // print_r($rowData[4]);
      // print_r($rowData[5]);
      // print_r($rowData[6]);
      // print_r($rowData[7]);
      // print_r($rowData[8]);
      // print_r($rowData[9]);

      DB::table('tbl_combinations')
        ->updateOrInsert(
          [
            'val_1' => $rowData[0],
            'val_2' => $rowData[1],
            'val_3' => $rowData[2],
            'val_4' => $rowData[3],
            'val_5' => $rowData[4],
            'val_6' => $rowData[5],
            'val_7' => $rowData[6],
            'val_8' => $rowData[7],
            'val_9' => $rowData[8]

          ],
          [
            'val_1' => $rowData[0],
            'val_2' => $rowData[1],
            'val_3' => $rowData[2],
            'val_4' => $rowData[3],
            'val_5' => $rowData[4],
            'val_6' => $rowData[5],
            'val_7' => $rowData[6],
            'val_8' => $rowData[7],
            'val_9' => $rowData[8]
          ]
        );
    }

    //echo '<pre>'; print_r($combos); echo '</pre>';

    //this is done come 
  }

  //getCustomProductData


  //chemistIncentiveProcess
  public function chemistIncentiveProcess(Request $request)
  {

    $formulatedArr = DB::table('samples_formula')->get();
    foreach ($formulatedArr as $key => $rowData) {
      print_r($rowData->id);
    }
  }
  //chemistIncentiveProcess


  //removeOrdersByOrderID
  public function removeOrdersByOrderID(Request $request)
  {
    $orderArr = DB::table('dispatch_order_v1')
      ->where('is_deleted_status', 0)
      ->get();
    foreach ($orderArr as $key => $rowData) {

      $orderArr = explode("/", $rowData->order_id);

      $order_id = $orderArr[0];
      $order_subid = $orderArr[1];
      $qcformArrData = DB::table('qc_forms')
        ->where('order_id', $order_id)
        ->where('subOrder', $order_subid)
        ->first();
      if ($qcformArrData == null) {
      } else {
        $affected = DB::table('qc_forms')
          ->where('form_id', $qcformArrData->form_id)
          ->update([
            'dispatch_status' => 0,
            'dis_type' => 'SMT_EXCEL',
          ]);
        $affected = DB::table('dispatch_order_v1')
          ->where('id', $rowData->id)
          ->update([
            'is_deleted_status' => 1,
            'form_id' => $qcformArrData->form_id,
            'created_at' => date('Y-m-d H:i:s')
          ]);
      }


      // print_r($affected->form_id);
      // die;


    }
  }
  //removeOrdersByOrderID

  //getLeadDataMTD
  public function getLeadDataMTD(Request $request)
  {
    // print_r($request->all());   

    //show lead count  yet 
    //show claim yet
    //sample staage 
    //Qualified stage
    //negosiation stage
    //lost statge 
    //also with all user 
    //--start
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $from = date('Y-m-01');
    $to = date("Y-m-d");

    //$from = "2021-06-01";
    //$to = "2021-06-30";

    $subTitle = "Date :" . $from . "- " . $to;
    $subLineM = "Lead Report " . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    // $email->addTo('gupta@max.net', '');
    $email->addTo('bointldev@gmail.com', 'Ajay kumar6');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    //$email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    //$email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Lead Count </th>
                              <th>Claim/Assined </th>
                              <th>Qualified </th>
															<th>Sampling </th>														
															<th>Negosiation </th>														
															<th>Converted </th>														
                              <th>Lost </th>														
                              <th>Total </th>														
                              <th>HOLD </th>														
														</tr>
													</thead>
													<tbody>';


    //sample

    $dataArr = AyraHelp::getLeadReportFirsttoYet($from, $to);


    foreach ($dataArr as $key => $rowData) {
      $i++;
      $body .= '<tr>
              <th scope="row">' . $i . '</th>
              <td>' . $rowData['lead_count'] . '</td>
              <td>' . $rowData['claim_assigned'] . '</td>
              <td>' . $rowData['qualified'] . '</td>
              <td>' . $rowData['sampling'] . '</td>                             
              <td>' . $rowData['negosiation'] . '</td>                             
              <td>' . $rowData['converted'] . '</td>                             
              <td>' . $rowData['lost'] . '</td>      
              <td>' . $rowData['total'] . '</td>      
              <td>' . $rowData['hold'] . '</td>                             
            
            </tr>';
    }


    //sample



    $body .= '</tbody>
												</table>';
    //sales person
    $dataArrName = AyraHelp::getLeadReportFirsttoYetPersonWise($from, $to);


    $body .= '<table  border="1" style="background-color:#ccc">
                        <thead class="thead-inverse">
                          <tr>
                            <th>S#</th>
                            <th>Name </th>
                            <th>Claim/Assined </th>
                            <th>Qualified </th>
                            <th>Sampling </th>														
                            <th>Negosiation </th>														
                            <th>Converted </th>														
                            <th>Lost </th>		
                            <th>Total </th>	
                            <th>HOLD </th>																		
                          </tr>
                        </thead>
                        <tbody>';
    $j = 0;
    foreach ($dataArrName as $key => $rowData) {
      $j++;
      $body .= '<tr>
                                  <th scope="row">' . $i . '</th>
                                  <td>' . $rowData['sales_name'] . '</td>
                                  <td>' . $rowData['stage_1'] . '</td>
                                  <td>' . $rowData['stage_2'] . '</td>
                                  <td>' . $rowData['stage_3'] . '</td>                             
                                  <td>' . $rowData['stage_4'] . '</td>                             
                                  <td>' . $rowData['stage_5'] . '</td>   
                                  <td>' . $rowData['stage_6'] . '</td>
                                  <td>' . $rowData['stage_totoal'] . '</td>
                                  <td>' . $rowData['stage_hold'] . '</td>                             
                                </tr>';
    }
    //sales person

    $body .= '</tbody>
												</table>';


    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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


    //--end 


  }
  //getLeadDataMTD

  //updateClientData
  public function updateClientData(Request $request)
  {
    $clientsArr = DB::table('clients')
            ->select('id')
            ->where('is_deleted',0)
            ->where('have_order',1)
            ->get();
            echo count($clientsArr);
            foreach ($clientsArr as $key => $rowData) {

              $OrderCount = DB::table('qc_forms')             
               ->where('is_deleted',0)
               ->where('client_id',$rowData->id)
              ->count();

              $qcLatestArr = DB::table('qc_forms')
              ->where('is_deleted',0)
              ->where('client_id',$rowData->id)
              ->latest()                
              ->first();

              if($OrderCount>0){

                $qcFormDataArr = DB::table('qc_forms')             
                ->where('is_deleted',0)
                ->where('client_id',$rowData->id)
                ->get();
                $orderV=0;
                foreach ($qcFormDataArr as $key => $rowDataOdr) {
                  
                   if ($rowDataOdr->qc_from_bulk == 1) {
                    $orderV = $orderV+ $rowDataOdr->bulk_order_value;

                   }else{
                    $orderV = $orderV+ceil($rowDataOdr->item_qty * $rowDataOdr->item_sp);

                   }
                  
                
              $affected = DB::table('clients')
              ->where('id', $rowData->id)
              ->update(
                [
                  'tot_orders_value' => $orderV,
                  'tot_orders' => $OrderCount,
                  'last_order_date' => $qcLatestArr->created_at
                ]
              );


              }
                

              }
            }




  }
  //updateClientData


  //getUserTest
  public function getUserTest(Request $request)
  {

    echo  $keyword = $request->keyword;

    $users = DB::table('name_test')
      ->Where('name', 'RLIKE', '[[:<:]]' . $keyword . '[[:>:]]')
      ->get();
    print_r($users);
  }
  //getUserTest
  public function getClientProductbyDuration(Request $request)
  {
    $itemA = '';
    $qcDataArr = DB::table('qc_forms')
      ->where('is_deleted', 0)
      ->where('created_at', '>=', '2022-06-01')
      ->where('created_at', '<=', '2022-06-12')
      ->orderBy('form_id', 'ASC')
      ->get();

    //foreach
    foreach ($qcDataArr as $key => $rowDataOdr) {


      if ($rowDataOdr->qc_from_bulk == 1) {
        $oderType = 'BULK';
        $orderVal = $rowDataOdr->bulk_order_value;
        $bulkOrderArr = DB::table('qc_bulk_order_form')
          ->where('form_id', $rowDataOdr->form_id)
          ->get();
        $qty = 0;
        foreach ($bulkOrderArr as $key => $rowA) {
          //print_r($row->item_name);
          if (!empty($rowA->item_name)) {
            $itemA .= $rowA->item_name . "|";
            $qty = $qty + $rowA->qty;
          }
        }
        $item_name = $itemA;
      } else {
        $orderVal = ceil($rowDataOdr->item_qty * $rowDataOdr->item_sp);
        $item_name = $rowDataOdr->item_name;
        $oderType = 'PRIVATE  LABEL';
        $qty = $rowDataOdr->item_qty;
      }
      $client_arr = AyraHelp::getClientbyidWithDelete($rowDataOdr->client_id);

      DB::table('client_product_list_1')->insert([
        'client_name' => @$client_arr->company,
        'brand' => @$client_arr->brand,
        'cid' => @$client_arr->id,
        'form_id' => $rowDataOdr->form_id,
        'order_id' => $rowDataOdr->order_id . "/" . $rowDataOdr->subOrder,
        'subOrder' => $rowDataOdr->subOrder,
        'order_value' => $orderVal,
        'created_by' => AyraHelp::getUser($rowDataOdr->created_by)->name,
        'created_on' => $rowDataOdr->created_at,
        'status' => $rowDataOdr->dispatch_status,
        'item_name' => $item_name,
        'order_type' => $oderType,
        'kind_type' => $rowDataOdr->order_type_v1,
        'qty' => $qty,

      ]);
    }


    //foreach


  }

  //getClientProductbyDuration
  public function getClientProductbyDurationA(Request $request)
  {
    $clientArr = DB::table('clients')
      ->where('is_deleted', 0)
      ->get();
    // $i=0;
    $itemA = '';
    $order_data = array();
    foreach ($clientArr as $key => $rowData) {
      $cid = $rowData->id;
      $qcData = DB::table('qc_forms')
        ->where('is_deleted', 0)
        ->where('client_id', $cid)
        ->first();
      if ($qcData == null) {
      } else {
        // $i++;
        $qcDataArr = DB::table('qc_forms')
          ->where('is_deleted', 0)
          // ->where('created_at', '>=', '2021-01-01')
          ->where('client_id', $cid)
          ->orderBy('form_id', 'ASC')
          ->get();
        foreach ($qcDataArr as $key => $rowDataOdr) {


          if ($rowDataOdr->qc_from_bulk == 1) {
            $oderType = 'BULK';
            $orderVal = $rowDataOdr->bulk_order_value;
            $bulkOrderArr = DB::table('qc_bulk_order_form')
              ->where('form_id', $rowDataOdr->form_id)
              ->get();


            foreach ($bulkOrderArr as $key => $rowA) {
              //print_r($row->item_name);
              if (!empty($rowA->item_name)) {
                $itemA .= $rowA->item_name . "|";
              }
            }
            $item_name = $itemA;
          } else {
            $orderVal = ceil($rowDataOdr->item_qty * $rowDataOdr->item_sp);
            $item_name = $rowDataOdr->item_name;
            $oderType = 'PRIVATE  LABEL';
          }

          DB::table('client_product_list_1')->insert([
            'client_name' => $rowData->company,
            'brand' => $rowData->brand,
            'cid' => $rowData->id,
            'form_id' => $rowDataOdr->form_id,
            'order_id' => $rowDataOdr->order_id . "/" . $rowDataOdr->subOrder,
            'order_value' => $orderVal,
            'created_by' => AyraHelp::getUser($rowDataOdr->created_by)->name,
            'created_on' => $rowDataOdr->created_at,
            'status' => $rowDataOdr->dispatch_status,
            'item_name' => $item_name,
            'order_type' => $oderType,
            'kind_type' => $rowDataOdr->order_type_v1,

          ]);
        }
      }
    }
    //  echo $i;


  }
  //getClientProductbyDuration

  //client_id_name
  public function client_id_name(Request $request)
  {
    $clientArr = DB::table('clients')
      ->whereNull('added_name')
      ->get();
    foreach ($clientArr as $key => $rowData) {
      $added_by = $rowData->added_by;
      $affected = DB::table('clients')
        ->where('id', $rowData->id)
        ->update(['added_name' => AyraHelp::getUser($added_by)->name]);
    }
  }
  //client_id_name


  public function online_to_offline_DataMerge(Request $request)
  {
    //AyraHelp::online2OfflineClient();
    //AyraHelp::online2OfflineClientMerge(); //116 will be added 

    //AyraHelp::online2OfflineOrderMerge(); //116 will be added dd
    //AyraHelp::updateClientIDfromOnlineToOffline();
    //AyraHelp::online2OfflineOrderBOMMerge();
    //AyraHelp::online2OfflineOrderBulkMerge();
    //AyraHelp::online2OfflineOrderPrivatePackingMerge();
    //AyraHelp::online2OfflineOrderStagesMerge();

    //Sample 
    //AyraHelp::online2OfflineSamplesMerge();
    //AyraHelp::online2OfflineSamplesStagesMerge();
    //AyraHelp::online2OfflineSamplesClientMerge();
    //AyraHelp::online2OfflineSamplesFormulationMerge();

    //AyraHelp::online2OfflinePaymentRecievedMerge();
    //AyraHelp::online2OfflineSalesInvoiceRequestMerge();


    //purchase is done 

    //Samples



  }

  //getSalesPersonAllOrder
  public function getSalesPersonAllOrder(Request $request)
  {
    //sales_all_order_data
    AyraHelp::getMyAllClientV1();
    die;

    $created_by = 133;
    DB::table('sales_all_order_data')->truncate();

    $clientArr = DB::table('qc_forms')
      ->where('is_deleted', 0)
      ->where('created_by', $created_by)
      ->get();
    foreach ($clientArr as $key => $rowData) {

      $clientArrData = DB::table('clients')->where('id', $rowData->client_id)->first();

      $newOrders = AyraHelp::getTotalOrdersValueByFormID($rowData->form_id);

      switch ($rowData->dispatch_status) {
        case 1:
          $orderStatus = "PENDING";
          break;
        case 2:
          $orderStatus = "PARTIAL DISPATCHED";
          break;
        case 0:
          $orderStatus = "DISPATCHED";
          break;
      }
      DB::table('sales_all_order_data')->insert([
        'company' => $clientArrData->company,
        'brand' => $clientArrData->brand,
        'order_value' => $newOrders,
        'order_id' => $rowData->order_id . "/" . $rowData->subOrder,
        'order_date' => $rowData->created_at,
        'current_status' => $orderStatus,
        'current_stage' => @$rowData->curr_stage_name,
        'sales_person' => AyraHelp::getUser($created_by)->name,




      ]);
    }
  }
  //getSalesPersonAllOrder
  //getOrderDataParam
  
  public function getOrderDataParam(Request $request)
  {
    //print_r($request->request);
    echo $m_data=$request->m_data;
    echo $y_data=$request->y_data;
    echo $getTotalOrderPL = AyraHelp::getTotalOrderPL($m_data,$y_data);
    echo $getTotalOrderBULK = AyraHelp::getTotalOrderBULK($m_data,$y_data);
    echo $getTotalOrderUNIT = AyraHelp::getTotalOrderUNIT($m_data,$y_data);    
    echo $getTotalOrderBATCHSIZE = AyraHelp::getTotalOrderBATCHSIZE($m_data,$y_data);
    echo $getTotalOrderUNIT_PL = AyraHelp::getTotalOrderUNIT_PL($m_data,$y_data);
    echo $getTotalOrderBATCHSIZE_PL = AyraHelp::getTotalOrderBATCHSIZE_PL($m_data,$y_data);
    echo $getTotalPaymentDataAll = AyraHelp::getTotalPaymentDataAll($m_data,$y_data);

    echo $getTotalOrderPL_COUNT = AyraHelp::getTotalOrderPL_COUNT($m_data,$y_data);
    echo $getTotalOrderBULK_COUNT = AyraHelp::getTotalOrderBULK_COUNT($m_data,$y_data);
    



    DB::table('report_order_data')
    ->updateOrInsert(
        [
          'm_data' => $m_data, 
          'y_data' => $y_data
        ],
        [
          'order_pl_count' => $getTotalOrderPL,
          'order_bulk_count' => $getTotalOrderBULK,
          'total_unit' => $getTotalOrderUNIT,
          'tolal_base_size' => $getTotalOrderBATCHSIZE,
          'total_unit_pl' => $getTotalOrderUNIT_PL,
          'tolal_base_size_bulk' => $getTotalOrderBATCHSIZE_PL,
          'payment' => $getTotalPaymentDataAll,
          'order_count_pl' => $getTotalOrderPL_COUNT,
          'order_count_bulk' => $getTotalOrderBULK_COUNT
          
        ]
    );


  }
  //getOrderDataParam

  //getActualClientData
  public function getActualClientData(Request $request)
  {
    $from = '2017-01-01';
    $to = '2020-12-31';

    $clientArr = DB::table('clients')
      ->whereDate('created_at', '>=', $from)
      ->whereDate('created_at', '<=', $to)
      ->where('is_deleted', 0)
      ->get();

    foreach ($clientArr as $key => $rowData) {
      $cid = $rowData->id;
      $createdName = AyraHelp::getUser($rowData->added_by)->name;
      //  echo "|";
      $revenueData = AyraHelp::getTotalRevenueBYCID($from, $to, $cid);
      // echo "|";
      $newOrders = AyraHelp::getTotalOrdersValueByCID($from, $to, $cid);
      // echo "<|>";
      $clientOrderCount = DB::table('qc_forms')
        ->where('client_id', $cid)
        ->where('is_deleted', 0)
        ->count();
      //  echo "<br>";
      //  die; 
      if ($clientOrderCount > 0) {
        DB::table('tbl_actual_client_data')
          ->updateOrInsert(
            ['client_id' => $cid],
            [
              'name' => @$rowData->firstname,
              'company' => @$rowData->company,
              'brand' => @$rowData->brand,
              'order_cound' => $clientOrderCount,
              'client_added_on' => @$rowData->created_at,
              'created_by_name' => @$createdName,
              'order_val' => $newOrders,
              'payment_val' => $revenueData,
            ]
          );
      }
    }
  }
  //getActualClientData

  //getClientOrderPaymentMonthWise
  public function getClientOrderPaymentMonthWise(Request $request)
  {

    // DB::table('client_order_monthwise')->truncate();

    $clientArr = DB::table('cldata')
      // ->where('have_order', 1)
      ->get();
    $from = date('Y-m-01');
    $to = date("Y-m-d");
    $from = '2020-12-1';
    $to = '2020-12-31';

    foreach ($clientArr as $key => $row) {
      $cid = $row->client_id;
      $revenueData = AyraHelp::getTotalRevenueBYCID($from, $to, $cid);
      $newOrders = AyraHelp::getTotalOrdersValueByCID($from, $to, $cid);

      DB::table('client_order_monthwise')->insert([
        'client_id' => $cid,
        'first_name' =>  $row->firstname,
        'brand' => $row->brand,
        'company' => $row->company,
        'order_val' => $newOrders,
        'payment_recieved' => $revenueData,
        'month_name' => 'DEC-2020',
        'year_name' => 0

      ]);
    }
  }
  //getClientOrderPaymentMonthWise
  //getDailyTeamwiseReport
  public function getDailyTeamwiseReport(Request $request)
  {
    $teamArrData = DB::table('team_wise_sales_data')->distinct('team_id')->get('team_id');
    // $teamArrData = DB::table('team_wise_sales_data')
    //         ->select('team_id')
    //         ->groupBy('team_id')
    //         ->get();

    // print_r($teamArrData);
    // die;


    $dataArr = DB::table('teamwise_users')->get();
    $dataArrStore = [];
    DB::table('team_wise_sales_data')->truncate();
    foreach ($dataArr as $key => $rowData) {
      $userid = $rowData->user_id;
      $user_name = $rowData->user_name;
      $target_amt = $rowData->target_amt;
      $team_id = $rowData->team_id;
      $team_name = $rowData->team_name;
      $from = date('Y-m-01');
      $to = date("Y-m-d");

      $revenueData = AyraHelp::getTotalRevenue($from, $to, $userid);
      $newOrders = AyraHelp::getTotalNewOrders($from, $to, $userid);
      $repeatOrders = AyraHelp::getTotalRepeatOrders($from, $to, $userid);
      $additonOrders = AyraHelp::getTotalAdditonOrders($from, $to, $userid);
      $totalOrdersValue = AyraHelp::getTotalOrdersValue($from, $to, $userid);
      $totalOrdersCount = AyraHelp::getTotalOrdersCount($from, $to, $userid);
      $aov = 0;
      if ($totalOrdersCount > 0) {
        $aov = ($totalOrdersValue / $totalOrdersCount);
      }


      $totalCallCount = AyraHelp::getTotalCallCount($from, $to, $userid);
      $callConv = 0;
      if ($totalCallCount > 0) {
        $callConv = $totalOrdersCount / $totalCallCount;
      }


      $totalSampleCount = AyraHelp::getTotalSampleCount($from, $to, $userid);
      $totalLeadClaimCount = AyraHelp::getTotalLeadClaimCount($from, $to, $userid);


      // print_r($revenueData);
      // echo "<br>";

      $mtd = ($revenueData * 100) / $target_amt;


      DB::table('team_wise_sales_data')->insert([
        'team_id' => $team_id,
        'team_name' => $team_name,
        'user_id' => $userid,
        'user_name' => $user_name,
        'target_amt' => $target_amt,
        'revenue' => $revenueData,
        'mtd_achievement' => $mtd,
        'new_product' => $newOrders,
        'repeat_product' => $repeatOrders,
        'product_addition' => $additonOrders,
        'total_orders_count' => $totalOrdersCount,
        'order_value' => $totalOrdersValue,
        'aov' => $aov,
        'total_call' => $totalCallCount,
        'conv_percentage' => $callConv,
        'sample' => $totalSampleCount,
        'lead_claim' => $totalLeadClaimCount,
        'from_start' => $from,
        'to_start' => $to,

      ]);
    }

    //  send email report 
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $fromA = date('Y-m-01');
    $toA = date("Y-m-d");
    $subTitle = "From :" . $fromA . " To " . $toA;
    $subLineM = "Sales Report Team wise" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    //$email->addTo('gupta@max.net', '');   
    //$email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    //$email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //team 1
    $body = '';
    $body .= '<table   border="1" style="border: 1px solid black;border-collapse: collapse">
    <thead class="thead-inverse">
      <tr>
        <th>S#</th>														
        <th>Sales Person </th>
        <th>Target </th>
        <th>Revenue </th>														
        <th>Achievement % </th>														
        <th>New</th>														
        <th>Repeat</th>														
        <th>Addition</th>																																									
        <th>Order Count </th>														
        <th>Order Value </th>														
        <th>AOV </th>														
        <th>Total Calls </th>														
        <th>Conversion % </th>														
        <th>Sample </th>														
        <th>Lead Assinged </th>																													
        <th>Duration </th>																													
        <th>Batch Size </th>																													
      </tr>
    </thead>
    <tbody>';

    foreach ($teamArrData as $key => $rowDataV) {
      $team_idDyan = $rowDataV->team_id;
      //team dyanmic 1
      $teamArr = DB::table('team_wise_sales_data')
        ->where('team_id', $team_idDyan)
        ->get();
      $body .= '<tr>
      <th colspan="17"><b>
      ' . $teamArr[0]->team_name . '</b>
      </th>
      </tr>';


      //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");



      //sample



      $target_amtTeam = 0;
      $revenueTeam = 0;
      $mtd_achievementTeam = 0;
      $new_productTeam = 0;

      $repeat_productTeam = 0;
      $product_additionTeam = 0;
      $total_orders_countTeam = 0;
      $order_valueTeam = 0;
      $sampleTeam = 0;
      $lead_claimTeam = 0;



      foreach ($teamArr as $key => $rowData) {
        $i++;
        $target_amtTeam = $target_amtTeam + $rowData->target_amt;
        $revenueTeam = $revenueTeam + $rowData->revenue;
        $mtd_achievementTeam = $mtd_achievementTeam + $rowData->mtd_achievement;

        $new_productTeam = $new_productTeam + $rowData->new_product;
        $repeat_productTeam = $repeat_productTeam + $rowData->repeat_product;
        $product_additionTeam = $product_additionTeam + $rowData->product_addition;
        $total_orders_countTeam = $total_orders_countTeam + $rowData->total_orders_count;
        $order_valueTeam = $order_valueTeam + $rowData->order_value;
        $sampleTeam = $sampleTeam + $rowData->sample;
        $lead_claimTeam = $lead_claimTeam + $rowData->lead_claim;

        $body .= '<tr style="background-color:#FFF">
                <th scope="row">' . $i . '</th>
               
                <td>' . $rowData->user_name . '</td>
                <td>₹' . $rowData->target_amt . '</td>
                <td>₹' . $rowData->revenue . '</td>                             
                <td>' . $rowData->mtd_achievement . '%</td>                             
                <td>' . $rowData->new_product . '</td>                             
                <td>' . $rowData->repeat_product . '</td>                             
                <td>' . $rowData->product_addition . '</td>                             
                <td>' . $rowData->total_orders_count . '</td>                             
                <td>₹' . $rowData->order_value . '</td>                             
                <td>' . $rowData->aov . '%</td>                             
                <td>' . $rowData->total_call . '</td>                             
                <td>' . $rowData->conv_percentage . '%</td>                             
                <td>' . $rowData->sample . '</td>                             
                <td>' . $rowData->lead_claim . '</td>                             
                <td>' . date('j-M-Y ', strtotime($rowData->from_start)) . '-TO-<br>' . date('j-M-Y ', strtotime($rowData->to_start)) . '</td>                             
                <td>
                ---
                </td>
                                       
              
                  </tr>';
      }


      //sample
      $body .= '<tr style="background-color:#035496;color#FFF">
    <th scope="row"></th>
   <td></td>
  
    <td><b>₹' . $target_amtTeam . '</b></td>
    <td><b>₹' . $revenueTeam . '</b></td>                    
    <td><b>' . $mtd_achievementTeam . '%</b></td>                       
    <td><b>' . $new_productTeam . '</b></td>                           
    <td><b>' . $repeat_productTeam . '</b></td>                     
    <td><b>' . $product_additionTeam . '</b></td>                   
    <td><b>' . $total_orders_countTeam . '</b></td>                            
    <td><b>₹' . $order_valueTeam . '</b></td>                     
    <td></td>                          
    <td></td>                           
    <td></td>                             
    <td><b>' . $sampleTeam . '</b></td>                  
    <td><b>' . $lead_claimTeam . '</b></td>           
    <td>' . date('j-M-Y ', strtotime($teamArr[0]->from_start)) . '-TO-<br>' . date('j-M-Y ', strtotime($teamArr[0]->to_start)) . '</td>                             
                           
  
      </tr>';





      //team dyanmic 1
    }
    $body .= '</tbody>
    </table>';





    //team 1



    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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

    //  send email report 



  }
  //getDailyTeamwiseReport

  //getSalesOrderPaymentData
  public function getSalesOrderPaymentData(Request $request)
  {
    //tbl_monthly_sales_order_data

    $salesData = array();
    $data_userArr = AyraHelp::getSalesAgentAdmin();
    foreach ($data_userArr as $key => $rowData) {
      // print_r($rowData->id);
      $userID = $rowData->id;
      $name = $rowData->name;
      $qcDataArr = DB::table('qc_forms')
        ->where('created_by', $userID)
        ->where('is_deleted', 0)
        ->where('created_at', 'LIKE', '2023-02%')
        ->distinct()
        ->get('client_id');

      foreach ($qcDataArr as $key => $row) {
        $cid = $row->client_id;
        $ClientDataArr = DB::table('clients')
          ->where('id', $cid)
          ->first();

        $qcDataArrCount = DB::table('qc_forms')
          ->where('client_id', $cid)
          ->where('is_deleted', 0)
          ->where('created_at', 'LIKE', '2023-02%')
          ->count();

        //client_orderValue
        $from = "2023-02-01";
        $to = "2023-02-28";
        $datas = QCFORM::where('is_deleted', 0)->where('client_id', $cid)->whereBetween('created_at', [$from, $to])->whereYear('created_at', date('Y'))->get();
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

        //client_orderValue
        //payment_recieved_from_client
        $qcDataArrCountPaymentSuM = DB::table('payment_recieved_from_client')
          ->where('client_id', $cid)
          ->where('is_deleted', 0)
          ->where('payment_status', 1)
          ->where('created_at', 'LIKE', '2023-02%')
          ->sum('rec_amount');

        $qcDataArrCountPaymentSuMRec = DB::table('payment_recieved_from_client')
          ->where('client_id', $cid)
          ->where('is_deleted', 0)
          ->where('payment_status', 1)
          ->where('recieved_on', 'LIKE', '2023-02%')
          ->sum('rec_amount');

        //payment_recieved_from_client

        DB::table('tbl_monthly_sales_order_data')->insert([
          'sales_person' => $name,
          'brand_company' => optional($ClientDataArr)->company . "[" . optional($ClientDataArr)->brand . "]",
          'order_count' => $qcDataArrCount,
          'order_values' => $sumTotal,
          'payment_collection_by_added' => $qcDataArrCountPaymentSuM,
          'payment_collection_by_recieved' => $qcDataArrCountPaymentSuMRec,
          'month_name' => 'February',
          'year' => '2023'

        ]);
      }
      echo "<br>";
    }
  }
  //getSalesOrderPaymentData


  //setLeadIncentive
  public function setLeadIncentive(Request $request)
  {
    //client phone to phone_v1
    //     echo "<pre>";
    //     $dataArr = DB::table('clients')->get();
    //     foreach ($dataArr as $key => $rowData) {
    //       $str= trim($rowData->phone);
    //       echo $rowData->added_by;
    //       echo "--";
    //       echo $new_str = str_replace(' ', '', $str);
    //       echo "<br>";

    //     }
    // die;

    //==============STEP 1
    // $dataArr = DB::table('indmt_data')
    // // ->where('assign_by',134)
    //  ->where('verified_by',134)
    // ->get();

    // foreach ($dataArr as $key => $rowData) {


    //   DB::table('lead_incentives')
    //   ->updateOrInsert(
    //       ['QUERY_ID' => $rowData->QUERY_ID],
    //       [
    //         'user_assigned' => $rowData->assign_by,
    //         'user_verify' => $rowData->verified_by,           
    //         'mob' => $rowData->MOB,    
    //         'email' =>$rowData->SENDEREMAIL,    
    //         'lead_created_at' => $rowData->DATE_TIME_RE_SYS

    //       ]
    //   );


    // }
    // die;
    //==============STEP 2 //check is client by email or phone
    $dataArr = DB::table('lead_incentives')
      ->select('email', 'mob', 'QUERY_ID')
      //  ->where('verified_by',134)
      ->get();

    foreach ($dataArr as $key => $rowData) {
      $email = $rowData->email;
      $phone = $rowData->mob;
      //emai
      // $dataArrCount = DB::table('clients')
      //   ->where('email', $email)
      //   ->first();
      // if ($dataArrCount == null) {
      //   //echo "NO";
      // } else {
      //   $dataArrCount->id;
      //   $dataArrCountEMAIL = DB::table('payment_recieved_from_client')
      //     ->where('client_id', $dataArrCount->id)
      //     ->first();
      //   if ($dataArrCountEMAIL == null) {
      //   } else {
      //     echo $email;
      //     echo "<br>";
      //   }
      // }
      //phone
      $dataArrCount = DB::table('clients')
        ->where('phone', 'LIKE', "%" . $phone . "%")
        //  ->where('email', $email)       
        //  ->where('phone', $phone)       
        ->first();

      if ($dataArrCount == null) {
        //echo "NO";
      } else {
        $dataArrCount->id;
        $dataArrCountEMAIL = DB::table('qc_forms')
          ->where('client_id', $dataArrCount->id)
          ->first();
        if ($dataArrCountEMAIL == null) {
        } else {
          echo $phone;
          echo "<br>";

          $affected = DB::table('lead_incentives')
            ->where('QUERY_ID', $rowData->QUERY_ID)
            ->update([
              'is_client' => 1,
              'client_id' => $dataArrCount->id,
              'client_added_at' => $dataArrCount->created_at,
              'order_added_at' => $dataArrCountEMAIL->created_at,

            ]);
        }
      }


      //echo $dataArrCount;


    }



    //==============
  }

  public function setLeadIncentiveA(Request $request)
  {
    // echo "44";


    $dataArr = DB::table('indmt_data')
      //->where('assign_by',134)
      ->whereDate('created_at', '>=', '2022-03-01')
      ->whereNull('SUBJECT')
      ->get();
    $i = 0;
    foreach ($dataArr as $key => $rowS) {
      $QUERY_ID = $rowS->QUERY_ID;
      // print_r($dataArr);
      $i++;


      $row = DB::table('indmt_data_missed')->where('QUERY_ID', 'LIKE', $QUERY_ID)->first();

      if ($row != null) {
        //         echo "dd";
        //         die;
        // die;


        DB::table('indmt_data')->updateOrInsert(
          ['QUERY_ID' => $QUERY_ID],
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
            'data_source' => $row->data_source,
            'data_source_ID' => 1,
            'created_at' => $row->DATE_TIME_RE_SYS,
            'DATE_TIME_RE_SYS' => $row->DATE_TIME_RE_SYS,
            'assign_to' => $rowS->assign_to,
            'assign_on' => $rowS->assign_on,
            'assign_by' => $rowS->assign_by,
            'lead_status' => $rowS->lead_status,
            'iIrrelevant_type' => $rowS->iIrrelevant_type,
            'sms_sent' => 1,
            'email_sent' => 1,
            'claim_by' => $rowS->claim_by,
            'claim_at' => $rowS->claim_at,

          ]
        );
      }
    }
    $i;
    die;

    $dataArr = DB::table('lead_chat_histroy')
      //->where('assign_by',134)
      ->whereDate('created_at', '>=', '2023-03-01')
      ->where('msg_desc', 'like', '%LOST%')
      ->whereNull('at_stage_id')
      //  ->where('user_id',100)
      ->get();

    $i = 0;
    foreach ($dataArr as $key => $rowData) {
      $i++;
      DB::table('indmt_data')
        ->updateOrInsert(
          ['QUERY_ID' => $rowData->QUERY_ID],
          [
            'lead_status' => 4,
            'iIrrelevant_type' =>  8

          ]
        );
    }
    echo $i;
    //print_r($dataArr);

    die;

    //dddddddddddddddddddddd
    // die;
    $dataArr = DB::table('indmt_data')
      //->where('assign_by',134)
      ->where('verified_by', 134)
      ->get();

    foreach ($dataArr as $key => $rowData) {


      DB::table('lead_incentives')
        ->updateOrInsert(
          ['QUERY_ID' => $rowData->QUERY_ID],
          [
            'user_assigned' => $rowData->assign_by,
            'user_verify' => $rowData->verified_by,
            'mob' => $rowData->MOBIndex,
            'email' => $rowData->SENDEREMAIL,
            'lead_created_at' => date('Y-m-d H:i:s')

          ]
        );
    }
  }
  //setLeadIncentive

  //   public function getSMSDeliveryReport(){
  //     $request = $_REQUEST["data"];
  //     $jsonData = json_decode($request,true);
  //   foreach($jsonData as $key => $value){
  //     // request id
  //      $requestID = $value['requestId'];
  //      $userId = $value['userId'];
  //      $senderId = $value['senderId'];
  //      foreach($value['report'] as $key1 => $value1)
  //     {
  //       $desc = $value1['desc'];
  //        // status of each number
  //        $status = $value1['status'];
  //        // destination number
  //        $receiver = $value1['number'];
  //        //delivery report time
  //        $date = $value1['date'];
  //
  //       DB::table('sms_delivery')->insert(
  //           [
  //             'requestId' =$requestID,
  //             'user_id' =>$userId,
  //             'sender_id' => $senderId,
  //             'date' =>$date,
  //             'receiver' => $receiver,
  //             'status' => $status,
  //             'description' => $desc
  //
  //
  //           ]
  //       );
  //     }
  //
  //
  //
  // }
  //
  //   }
  //standardSampleList
  public function standardSampleList(Request $request)
  {
    // $samples = DB::table('samples')->select('sample_details')->where('sample_type',1)->whereDate('created_at','>=','2020-11-01')->where('is_deleted',0)->get();

    // foreach ($samples as $key => $rowData) {

    //   $dataArr=json_decode($rowData->sample_details);
    //   print_r($dataArr);
    // }
    $data = array();
    $finishProduct = DB::table('rnd_finish_products')->where('is_deleted', 0)->get();
    foreach ($finishProduct as $key => $rowData) {
      // print_r(strtolower($rowData->product_name));
      $samples = DB::table('sample_items')->where('item_name', $rowData->product_name)->where('sample_type', 1)->whereDate('created_at', '>=', '2020-11-01')->count();

      $data[] = array(
        'item_name' => $rowData->product_name,
        'item_count' => $samples,
      );

      DB::table('tamp_sample_count')->insert([
        'item_name' => $rowData->product_name,
        'item_count' => $samples,
      ]);
    }
    // echo "<pre>";
    //print_r($data);



  }
  //standardSampleList


  //samplebypart
  public function samplebypart(Request $request)
  {

    $samples = DB::table('samples')->whereDate('created_at', '<=', '2022-01-21')->where('is_deleted', 0)->where('status', 2)->get();
    print_r(count($samples));
  }

  //samplebypart

  // invoiceFileUpload
  public function invoiceFileUpload(Request $request)
  {

    $filename = '';
    if ($request->hasfile('file')) {
      $file = $request->file('file');
      $filename = "img_1_INVOICE" . $request->orderid . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('photos', $filename);
    }
    $users = DB::table('qc_forms')->where('form_id', $request->orderid)->first();
    $client_arr = AyraHelp::getClientbyid($users->client_id);
    $name = optional($client_arr)->firstname;
    $compName = optional($client_arr)->company;


    $id =  DB::table('order_invoice_doc')->insert(
      [
        'form_id' => $request->orderid,
        'created_by' => Auth::user()->id,
        'created_name' => Auth::user()->name,
        'invoice_doc' => $filename,
        'notes' => ucwords($request->notes),
        'client_id' => $users->client_id,

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

    $eventID = 'AJ_ID' . $users->created_by;

    $data['message'] = 'Invoice is upload of client:' . $name . "-" . $compName . "<br>Account Message : " . ucwords($request->notes);

    $pusher->trigger('BO_CHANNEL', $eventID, $data);
*/
    //puhser 

    //LoggedActicty
    $userID = Auth::user()->id;
    $LoggedName = AyraHelp::getUser($userID)->name;
    $eventName = "Invoice UPLOAD";
    $eventINFO = 'Invoice is upload of client:' . $name . "-" . $compName . "<br>Account Message : " . ucwords($request->notes) . 'By:' . Auth::user()->name;

    $eventID = $users->client_id;

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





    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);
  }
  // invoiceFileUpload
  public function downloadEmail_forSampleNotification()
  {
    $sample_arr = Sample::where('status', 1)->get();
    //  DB::table('samples_xls_format')->delete();
    DB::table('samples_xls_format')->truncate();


    DB::table('samples_xls_format')->insert(
      [
        'id' => 'S',
        'sample_code' => 'Sample CODE',
        'client_name' => 'Client/Company',
        'sales_name' => 'Sales Person',
        'created_at' => 'Created on',
        'pending_since' => 'Pending Since',
        'client_count' => 'Client Count',
        'current_status' => 'Current Status',
        'expecting_date' => 'Expected Date',
        'Notes' => 'Remarks',
        'sample_assigned_to' => 'Assigned To',
        'sample_assigned_on' => 'Assigned On',
        'formulated' => 'Formulated',


      ]
    );

    $i = 0;
    //$sample_assingned_on="";
    foreach ($sample_arr as $key => $value) {


      $users = Client::where('id', $value->client_id)->first();
      if ($value->created_at != null) {
        $sample_created = date("Y-m-d", strtotime($value->created_at));

        $today = date('Y-m-d');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $sample_created);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
        $diff_in_days = $from->diffInDays($to);
        $createdWITH = $diff_in_days . " days before";
      } else {
        $sample_created = '';
        $createdWITH = $sample_created;
      }

      if (is_null($value->assingned_on)) {
        $sample_assingned_on = '';
      } else {
        $sample_assingned_on = date("Y-m-d", strtotime($value->assingned_on));
      }

      $sample_code = $value->sample_code;
      $client_data = AyraHelp::getClientbyid($value->client_id);
      $firstname = isset($client_data->firstname) ? $client_data->firstname : "";
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $salesAssingedTo = @AyraHelp::getUser($value->assingned_to)->name;

      $CLcount = DB::table('samples')->where('client_id', $value->client_id)->count();
      $i++;
      if ($value->sample_stage_id >= 2) {
        $strFormulated = "YES";
      } else {
        $strFormulated = "";
      }

      DB::table('samples_xls_format')->insert(
        [
          'id' => $i,
          'sample_code' => $sample_code,
          'client_name' => $firstname,
          'sales_name' => $salesPrrname,
          'created_at' => $sample_created,
          'pending_since' => $createdWITH,
          'client_count' => $CLcount,
          'sample_assigned_to' => $salesAssingedTo,
          'sample_assigned_on' => $sample_assingned_on,
          'formulated' => $strFormulated,


        ]
      );
    }

    $samle = date('Y-m-d-h-i') . '_pending_samples_list.xlsx';

    return  Excel::download(new SampleExport, $samle);
  }
  //sendEmail_forOrderNotification

  //sampleSendDemo
  public function sampleSendDemo()
  {

    //temp_sample_sales_count
    $sampleArr = DB::table('samples')
      ->where('is_deleted', 0)
      ->where('created_at', '>', '2020-11-01')
      ->distinct()
      ->get('created_by');

    foreach ($sampleArr as $key => $rowData) {
      $userID = $rowData->created_by;

      $sampleArrCount = DB::table('samples')
        ->where('is_deleted', 0)
        ->where('created_at', '>', '2020-11-01')
        ->where('created_by', $userID)
        ->count();

      $sampleArrData = DB::table('samples')
        ->where('is_deleted', 0)
        ->where('created_at', '>', '2020-11-01')
        ->where('created_by', $userID)
        ->get();
      $clC = 0;
      $clCData = "";
      foreach ($sampleArrData as $key => $rw) {

        $ClientArrData = DB::table('clients')
          ->where('is_deleted', 0)
          ->where('id', $rw->client_id)
          ->where('created_at', '>', '2020-11-01')
          ->first();
        if ($ClientArrData != null) {

          $ClientArrDataForm = DB::table('qc_forms')
            ->where('is_deleted', 0)
            ->where('client_id', $rw->client_id)
            ->where('created_at', '>', '2020-11-01')
            ->first();
          if ($ClientArrDataForm != null) {
            $clC++;
            $clCData .= $rw->client_id . "-";
          }
        }
      }
      // echo $clC;
      // echo "==";
      // echo $clCData;

      // die;



      DB::table('temp_sample_sales_count')->insert([
        'sales_name' => AyraHelp::getUser($rowData->created_by)->name,
        'sample_count' => $sampleArrCount,
        'new_client' => $clC,
        'clinet_ids' => $clCData,
      ]);
    }
    //temp_sample_sales_count

  }

  //getLeadIncentiveData
  public function getLeadIncentiveData()
  {
    echo "dd";
  }

  //getLeadIncentiveData

  //updateRNDStatusNowBase
  public function updateRNDStatusNowBase(Request $request)
  {
     //print_r($request->all());
     
     
     $rowID=$request->rowID;
     $selRNDStatus=$request->selRNDStatus;



     $affected = DB::table('bo_formuation_v1')
              ->where('id', $rowID)
              ->update(['status' => $selRNDStatus]);

     $userID = Auth::user()->id;
     $LoggedName = AyraHelp::getUser($userID)->name;

     

     $eventName = "RNDFormulaUpdate BASE";
     $eventINFO = 'RND formula No::' . $rowID . " by  " . $LoggedName . " on" . date('Y-m-d H:i:s') . " Msg:" . $request->message;
 
     $eventID = $request->rowID;
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

    );

    return response()->json($resp);


  }

  //updateRNDStatusNowBase

  //updateRNDStatusNow
  public function updateRNDStatusNow(Request $request)
  {
     //print_r($request->all());
     
     
     $rowID=$request->rowID;
     $selRNDStatus=$request->selRNDStatus;



     $affected = DB::table('bo_formuation')
              ->where('id', $rowID)
              ->update(['status' => $selRNDStatus]);

     $userID = Auth::user()->id;
     $LoggedName = AyraHelp::getUser($userID)->name;

     

     $eventName = "RNDFormulaUpdate";
     $eventINFO = 'RND formula No::' . $rowID . " by  " . $LoggedName . " on" . date('Y-m-d H:i:s') . " Msg:" . $request->message;
 
     $eventID = $request->rowID;
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

    );

    return response()->json($resp);


  }
  //updateRNDStatusNow

  //saveleadCreditRequest
  public function saveleadCreditRequest(Request $request)
  {
    DB::table('lead_credit_request')->insert(
      [
        'client_id' => $request->lead_id,
        'message' => $request->message,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
        'status' => 1, //1 request 2:approved 2:hold:4:rejected:5:cancel

      ]
    );
    $client_arr = DB::table('clients')->where('id', $request->lead_id)->first();



    //send email 
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email

    $to = date("Y-m-d");

    //$from = "2021-06-01";
    //$to = "2021-06-30";

    $subTitle = "Of Lead: " . $client_arr->company . " - " . $client_arr->brand . " on: " . $to;
    $subLineM = "Requested for Credit Order By" . ":" . Auth::user()->name . " " . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    // $email->addTo('pooja@max.net', 'Pooja Gupta');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    //  $email->addCc('pooja@max.net','Pooja Gupta');
    //  $email->addCc('nitika@max.net', 'Admin');
    // // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //  $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addTo('bointldev@gmail.com', 'Ajay');
    $i = 1;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Name </th>
                              <th>Company </th>
                              <th>Brand </th>
															<th>Requested by </th>														
															<th>Requested on </th>														
															<th>Message </th>														
														</tr>
													</thead>
													<tbody>';


    //sample

    $body .= '<tr>
    <th scope="row">' . $i . '</th>
    <td>' . $client_arr->firstname . '</td>
    <td>' . $client_arr->company  . '</td>
    <td>' .  $client_arr->brand  . '</td>                            
    <td>' . Auth::user()->name . '</td>                             
    <td>' . date('Y-m-d h:i:s') . '</td>  
    <td>' .  $request->message . '</td>                            
 
  </tr>';


    //sample



    $body .= '</tbody>
												</table>
                        Note:please need to response on ERP 
                        ';


    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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

    //send email 

    $resp = array(
      'status' => 1,
      'data' => ''

    );

    return response()->json($resp);
  }
  //saveleadCreditRequest


  //getMTDRangeWiseSalesPayment
  public function getMTDRangeWiseSalesPayment(Request $request)
  {
    //print_r($request->all());
    $from = $request->st_date;
    $to = $request->end_date;


    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";


    $subTitle = "Date :" . $from . "- " . $to . " . Request By:" . Auth::user()->name;
    $subLineM = "SALES PERSON WISE PAYEMNT FROM  " . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->setSubject($subLineM);
    $email->addTo('gupta@max.net', 'Admin');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay Kumar');

    $body = '';

    $allUsers = AyraHelp::getSalesAgentAdmin();
    DB::table('sales_payments')->truncate();
    foreach ($allUsers as $key => $rowData) {
      if ($rowData->id == 186 || $rowData->id == 156 || $rowData->id == 108) {
      } else {
        // $body .='<h6>'.$rowData->name.'</h6>';
        // $body .='<h6>'.$rowData->id.'</h6>';
        $user_id = $rowData->id;
        $dataArr = AyraHelp::getSalesPaymentRecSalesWise($user_id, $from, $to);


        $body .= '<table  border="1" style="background-color:#ccc;margin-top:8px">
        <thead class="thead-inverse">
        <tr>
            <th colspan="6" style="background-color:#FFF; color:#000">' . $rowData->name . '</th>
           	
          </tr>

          <tr>
            <th>S#</th>
            <th>Brand </th>
            <th>Company </th>
            <th>Amount  </th>
            <th>Received on </th>
            <th>Added By </th>		
          </tr>
        </thead>
        <tbody>';

        $sumAmt = 0;
        $i = 0;
        foreach ($dataArr as $key => $row) {
          $i++;
          $clientData = AyraHelp::getClientByIDData($row->client_id);
          $sumAmt += $row->rec_amount;

          $body .= '<tr>
                                      <th scope="row">' . $i . '</th>
                                      <td>' . @$clientData->brand . '</td>
                                      <td>' . @$row->compamy_name . '</td>
                                      <td>' . $row->rec_amount . '</td>
                                      <td>' . date('j F Y', strtotime($row->recieved_on)) . '</td>                             
                                      <td>' . $rowData->name . '</td>                            
                                                                 
                                   
                                    </tr>';
        }
        //update total payment 

        $fromTO = $from . "To" . $to;
        DB::table('sales_payments')->insert([
          'user_id' => $rowData->id,
          'name' => $rowData->name,
          'amount' => $sumAmt,
          'from_to_date' => $fromTO,
        ]);

        //update total payment 
        $body .= '<tr>
        <th scope="row"></th>
        <td></td>
        <td><b>TOTAL</b></td>
        <td><b>' . $sumAmt . '</b></td>
        <td></td>                             
        <td></td>                            
                                   
     
      </tr>';
      }
      $body .= '</tbody>
    </table>';
    }




    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");

    //  echo $body;
    // die;


    //sample







    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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

  public function getMTDRangeWiseSalesPaymentOK(Request $request)
  {
    //print_r($request->all());
    $from = $request->st_date;
    $to = $request->end_date;


    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";


    $subTitle = "Date :" . $from . "- " . $to . " . Request By:" . Auth::user()->name;
    $subLineM = "SALES PERSON WISE PAYEMNT FROM  " . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->setSubject($subLineM);
    $email->addTo('gupta@max.net', 'Admin');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay Kumar');

    $body = '';

    $allUsers = AyraHelp::getSalesAgentAdmin();

    foreach ($allUsers as $key => $rowData) {
      if ($rowData->id == 186 || $rowData->id == 156 || $rowData->id == 108) {
      } else {
        // $body .='<h6>'.$rowData->name.'</h6>';
        // $body .='<h6>'.$rowData->id.'</h6>';
        $user_id = $rowData->id;
        $dataArr = AyraHelp::getSalesPaymentRecSalesWise($user_id, $from, $to);


        $body .= '<table  border="1" style="background-color:#ccc;margin-top:8px">
        <thead class="thead-inverse">
        <tr>
            <th colspan="6" style="background-color:#FFF; color:#000">' . $rowData->name . '</th>
           	
          </tr>

          <tr>
            <th>S#</th>
            <th> Brand </th>
            <th> Company </th>
            <th>Amount  </th>
            <th>Received on </th>
            <th>Added By </th>		
          </tr>
        </thead>
        <tbody>';

        $sumAmt = 0;
        $i = 0;
        foreach ($dataArr as $key => $row) {
          $i++;
          $clientData = AyraHelp::getClientByIDData($row->client_id);
          $sumAmt += $row->rec_amount;

          $body .= '<tr>
                                      <th scope="row">' . $i . '</th>
                                      <td>' . @$clientData->brand . '</td>
                                      <td>' . @$row->compamy_name . '</td>
                                      <td>' . $row->rec_amount . '</td>
                                      <td>' . date('j F Y', strtotime($row->recieved_on)) . '</td>                             
                                      <td>' . $rowData->name . '</td>                            
                                                                 
                                   
                                    </tr>';
        }
        $body .= '<tr>
        <th scope="row"></th>
        <td></td>
        <td><b>TOTAL</b></td>
        <td><b>' . $sumAmt . '</b></td>
        <td></td>                             
        <td></td>                            
                                   
     
      </tr>';
      }
      $body .= '</tbody>
    </table>';
    }




    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");

    //  echo $body;
    // die;


    //sample







    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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

  //getMTDBrandDetails
  public function getMTDBrandDetails()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => ''];
    return $theme->scope('sample.getMTDBrandDetails', $data)->render();
  }
  //getMTDBrandDetails
  //getMTDRangeWiseSalesPayment
  //getMTDRangeWiseBrandDetails
  public function getMTDRangeWiseBrandDetails(Request $request)
  {
    //print_r($request->all);
    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);


  }
  //getMTDRangeWiseBrandDetails

  //getMTDRangeWiseBrand
  public function getMTDRangeWiseBrand(Request $request)
  {

  
    $HTML = '';
    $HTDA = ''; 
    $HTDAT = '';

    $period = \Carbon\CarbonPeriod::create('2022-10-01', '1 month', '2023-03-31');
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    foreach ($period as $dt) {
      //  echo $dt->format("Y-m") . "<br>\n";
      $yearNumber = $dt->format("Y");
      $monthNum = $dt->format("m");
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $HTDAT .= '<td>' . $monthName . '-' . $yearNumber . '</td>';

    // $type = 'string';
    // $length = 254;
    //  $fieldName = $monthName."_".$yearNumber;    
    // Schema::table('brand_data', function (Blueprint $table) use ($type, $length, $fieldName) {
    //     $table->$type($fieldName, $length)->nullable;
    // });

    }
    $HTML .= '<tr><td>Brand</td>

    ' . $HTDAT . ' 
    </tr>';
    
    $aj='';


     
    $client_id = $request->client_id;

      $client_arr = AyraHelp::getClientbyid($client_id);
      $users = DB::table('users')
        ->where('id', $client_arr->added_by)
        ->first();
  
      $brandName = @$client_arr->brand . '-' . @$client_arr->company;
  
      
      foreach ($period as $dt) {
        $yearNumber = $dt->format("Y");
        $monthNum = $dt->format("m");
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        //$fieldName = $monthName."_".$yearNumber;
        

        
  
  
     $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $monthNum, $yearNumber);
     $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $monthNum, $yearNumber);
     $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $monthNum, $yearNumber);
     $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $monthNum, $yearNumber);
     $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $monthNum, $yearNumber);
  
     $aj ='
     Sales Person:' . $users->name . ' |
     Order Value: ' . $orderV . '|
     Payment Received:' . $payRec . '|
     Total orders:' . $dataArr['NoProductAdded'] . '|
     Total orders:' . $dataArr['NoProductAdded'] . '|
     No. of Repeat Orders:' . $dataArr['NoProductRepeat']  . '|
     No. of Product Addition: ' . $dataArr['NewProductRepeat']  . '|
     No. of UNIT:' . $unitOrder  . '|
     No. of Batch:' . $OrderBatchSize  . '|
     ';
      $HTDA .= '<td>
          '.$aj.'
           </td>';
  
        // DB::table('brand_data')
        // ->updateOrInsert(
        //     ['client_id' => $client_id],
        //     [
        //       $fieldName => $aj,
        //       'brand_name' =>$brandName,
        //     ]
        // );

  
        // $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $monthNum, $yearNumber);
        // $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $monthNum, $yearNumber);
        // $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $monthNum, $yearNumber);
        // $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $monthNum, $yearNumber);
        // $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $monthNum, $yearNumber);
        // $HTDA .= '<td>
        //    Sales Person:<b style="color:#035496">' . $users->name . '</b><br>
        //    Order Value: <b style="color:#035496">' . $orderV . '</b><br>
        //    Payment Received:<b style="color:#035496">' . $payRec . '</b><br>
        //    Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
        //    Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
     
     
        //    No. of Repeat Orders:<b style="color:#035496">' . $dataArr['NoProductRepeat']  . '</b><br>
        //    No. of Product Addition: <b style="color:#035496">' . $dataArr['NewProductRepeat']  . '</b><br>
        //    No. of UNIT: <b style="color:#035496">' . $unitOrder  . '</b><br>
        //    No. of Batch: <b style="color:#035496">' . $OrderBatchSize  . '</b><br>
        //    </td>';

       

      }
     

     


    
 
     
      $HTML .= '<tr><td>' . $brandName . '</td>
      ' . $HTDA . ' 
      </tr>';
  
      

    
$HTML .= '</table>';
   
    echo $HTML;
    die;


  }
  public function getMTDRangeWiseBrandA(Request $request)
  {

    /*ajaj
    $HTML = '';
    $HTDA = ''; 
    $HTDAT = '';

    $period = \Carbon\CarbonPeriod::create('2021-10-01', '1 month', '2022-03-31');
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    foreach ($period as $dt) {
      //  echo $dt->format("Y-m") . "<br>\n";
      $yearNumber = $dt->format("Y");
      $monthNum = $dt->format("m");
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $HTDAT .= '<td>' . $monthName . '-' . $yearNumber . '</td>';

    // $type = 'string';
    // $length = 254;
     $fieldName = $monthName."_".$yearNumber;
    
    // Schema::table('brand_data', function (Blueprint $table) use ($type, $length, $fieldName) {
    //     $table->$type($fieldName, $length)->nullable;
    // });

    }
    $HTML .= '<tr><td>Brand</td>

    ' . $HTDAT . ' 
    </tr>';
    $clietArrData = DB::table('clients')
    ->where('is_deleted',0)
    ->where('have_order',1)
     ->skip(20)->take(10)
    ->get();
    $aj='';
foreach ($clietArrData as $key => $rowData) {

     
      $client_id = $rowData->id;

      $client_arr = AyraHelp::getClientbyid($client_id);
      $users = DB::table('users')
        ->where('id', $client_arr->added_by)
        ->first();
  
      $brandName = $client_arr->brand . '-' . $client_arr->company;
  
      
      foreach ($period as $dt) {
        $yearNumber = $dt->format("Y");
        $monthNum = $dt->format("m");
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $fieldName = $monthName."_".$yearNumber;
        

        
  
  
     $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $monthNum, $yearNumber);
     $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $monthNum, $yearNumber);
     $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $monthNum, $yearNumber);
     $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $monthNum, $yearNumber);
     $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $monthNum, $yearNumber);
  
     $aj ='
     Sales Person:' . $users->name . ' |
     Order Value: ' . $orderV . '|
     Payment Received:' . $payRec . '|
     Total orders:' . $dataArr['NoProductAdded'] . '|
     Total orders:' . $dataArr['NoProductAdded'] . '|
     No. of Repeat Orders:' . $dataArr['NoProductRepeat']  . '|
     No. of Product Addition: ' . $dataArr['NewProductRepeat']  . '|
     No. of UNIT:' . $unitOrder  . '|
     No. of Batch:' . $OrderBatchSize  . '|
     ';
    
  
        DB::table('brand_data')
        ->updateOrInsert(
            ['client_id' => $client_id],
            [
              $fieldName => $aj,
              'brand_name' =>$brandName,
            ]
        );

  
        // $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $monthNum, $yearNumber);
        // $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $monthNum, $yearNumber);
        // $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $monthNum, $yearNumber);
        // $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $monthNum, $yearNumber);
        // $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $monthNum, $yearNumber);
        // $HTDA .= '<td>
        //    Sales Person:<b style="color:#035496">' . $users->name . '</b><br>
        //    Order Value: <b style="color:#035496">' . $orderV . '</b><br>
        //    Payment Received:<b style="color:#035496">' . $payRec . '</b><br>
        //    Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
        //    Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
     
     
        //    No. of Repeat Orders:<b style="color:#035496">' . $dataArr['NoProductRepeat']  . '</b><br>
        //    No. of Product Addition: <b style="color:#035496">' . $dataArr['NewProductRepeat']  . '</b><br>
        //    No. of UNIT: <b style="color:#035496">' . $unitOrder  . '</b><br>
        //    No. of Batch: <b style="color:#035496">' . $OrderBatchSize  . '</b><br>
        //    </td>';

       

      }
     

     


    }
    die;
     
      $HTML .= '<tr><td>' . $brandName . '</td>
      ' . $HTDA . ' 
      </tr>';
  
      

    
$HTML .= '</table>';
   
    echo $HTML;
    die;



    // print_r($request->all());
    // die;
    // $from = $request->st_date;
    // $to = $request->end_date;
    $from = '2021-06-01';
    $to = '2022-03-31';
    echo "<pre>";
    $client_id = $request->client_id;
    $mtdArrData = AyraHelp::getAllMTDBrandWise($client_id, $from, $to);
    print_r($mtdArrData);






    ///die;
//ajcode
*/

  $from = $request->st_date;
    $to = $request->end_date;
    // $from = '2021-10-01';
    // $to = '2021-12-31';


    $client_id = $request->client_id;
    $client_arr = AyraHelp::getClientbyid($client_id);

    $startMonth = date('m', strtotime($from));
    $stopMonth = date('m', strtotime($to));
    $yearFrom = date('Y', strtotime($from));
    $year = date('Y', strtotime($to));



    $brandName = @$client_arr->brand . '-' . @$client_arr->company;
    $users = DB::table('users')
      ->where('id', $client_arr->added_by)
      ->first();


    $HTML = '';
    $HTDA = '';

    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName;
      $HTDA .= '<td>' . $monthName . '</td>';
    }

    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Brand</td>
    ' . $HTDA . '
    </tr>';
    $HTD = "";
    for ($i = $startMonth; $i <= $stopMonth; $i++) {

      $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $i, $year);
      $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $i, $year);
      $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $i, $year);
      $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $i, $year);
      $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $i, $year);

      $monthNum = $i;

      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTD .= '<td>
      Sales Person:<b style="color:#035496">' . $users->name . '</b><br>
      Order Value: <b style="color:#035496">' . $orderV . '</b><br>
      Payment Received:<b style="color:#035496">' . $payRec . '</b><br>
      Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
      Total orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>


      No. of Repeat Orders:<b style="color:#035496">' . $dataArr['NoProductRepeat']  . '</b><br>
      No. of Product Addition: <b style="color:#035496">' . $dataArr['NewProductRepeat']  . '</b><br>
      No. of UNIT: <b style="color:#035496">' . $unitOrder  . '</b><br>
      No. of Batch: <b style="color:#035496">' . $OrderBatchSize  . '</b><br>
      </td>';
    }

    $HTML .= '<tr>
       <td>' . $brandName . '</td>
     ' . $HTD . '
     </tr>';

    $HTML .= '</table>';
    echo $HTML;
  }

  public function getMTDRangeWiseBrandOK(Request $request)
  {
    // print_r($request->all());
    // die;
    $from = $request->st_date;
    $to = $request->end_date;
    $client_id = $request->client_id;
    $client_arr = AyraHelp::getClientbyid($client_id);

    $startMonth = date('m', strtotime($request->st_date));
    $stopMonth = date('m', strtotime($request->end_date));
    $year = date('Y', strtotime($request->end_date));
    $brandName = $client_arr->brand . '-' . $client_arr->company;
    $users = DB::table('users')
      ->where('id', $client_arr->added_by)
      ->first();


    $HTML = '';
    $HTDA = '';

    for ($i = $startMonth; $i <= $stopMonth; $i++) {
      $monthNum = $i;
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName;
      $HTDA .= '<td>' . $monthName . '</td>';
    }
    $HTML .= '<table border="1" class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">';
    $HTML .= '<tr><td>Brand</td>
    ' . $HTDA . '
    </tr>';
    $HTD = "";
    for ($i = $startMonth; $i <= $stopMonth; $i++) {

      $payRec = AyraHelp::getPaymentRecFilterByClinetID($client_id, $i, $year);
      $orderV = AyraHelp::getOrderValuesSalesByClientID($client_id, $i, $year);
      $dataArr = AyraHelp::getOrderCountVByClientID($client_id, $i, $year);
      $unitOrder = AyraHelp::getOrderUnitByClientID($client_id, $i, $year);
      $OrderBatchSize = AyraHelp::getOrderBatchSizeByClientID($client_id, $i, $year);

      $monthNum = $i;

      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
      $monthName; // Output: May
      $HTD .= '<td>
      Sales Person:<b style="color:#035496">' . $users->name . '</b><br>
      Order Value: <b style="color:#035496">' . $orderV . '</b><br>
      Payment Received:<b style="color:#035496">' . $payRec . '</b><br>
      No. of  orders:<b style="color:#035496">' . $dataArr['NoProductAdded'] . '</b><br>
      No. of Repeat Orders:<b style="color:#035496">' . $dataArr['NoProductRepeat']  . '</b><br>
      No. of Product Addition: <b style="color:#035496">' . $dataArr['NewProductRepeat']  . '</b><br>
      No. of UNIT: <b style="color:#035496">' . $unitOrder  . '</b><br>
      No. of Batch: <b style="color:#035496">' . $OrderBatchSize  . '</b><br>
      </td>';
    }

    $HTML .= '<tr>
       <td>' . $brandName . '</td>
     ' . $HTD . '
     </tr>';

    $HTML .= '</table>';
    echo $HTML;

    //ajcode



    die;

    require 'vendor/autoload.php';

    $Apikey = "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";
    //$from = "2021-06-01";
    //$to = "2021-06-30";

    $subTitle = "Date :" . $from . "- " . $to . "Request By:" . Auth::user()->name;
    $subLineM = "Bradwise Details" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo('gupta@max.net', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Brand Name </th>
                              <th>Order Values </th>
                              <th>Payment Received </th>
															<th>No. of Products orders </th>														
															<th>No. of Repeat Orders </th>														
															<th>No. of New Orders </th>			
                              <th>Units </th>														
                              <th>Batch Size </th>												
														</tr>
													</thead>
													<tbody>';


    //sample

    $dataArr = AyraHelp::getSalesReportFirsttoYet($from, $to);


    foreach ($dataArr as $key => $rowData) {
      $i++;
      $body .= '<tr>
      <th scope="row">' . $i . '</th>
      <td>' . $rowData['name'] . '</td>
      <td>' . $rowData['order'] . '</td>
      <td>' . $rowData['payment'] . '</td>
      <td>' . $rowData['sample'] . '</td>                             
      <td>' . $rowData['OrderCount'] . '</td>                             
      <td>' . $rowData['LeadCount'] . '</td>     
      <td>' . $rowData['OrderUnit'] . '</td>                             
      <td>' . $rowData['OrderBatchSize'] . '</td>   
      </tr>';
    }


    //sample



    $body .= '</tbody>
												</table>';


    // $body .='<a href="'.$alink.'">Donwload Order</a>';

    $email->addContent(
      "text/html",
      $body
    );


    $sendgrid = new \SendGrid($Apikey);
    try {
      // $response = $sendgrid->send($email);
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

  //getMTDRangeWiseBrand


  // AyraHelp::getSalesReportFirsttoYet();
  public function getMTDRangeWise(Request $request)
  {
    //print_r($request->all());
    $from = $request->st_date;
    $to = $request->end_date;


    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    // $Apikey = "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";
    //email
    //$from = date('Y-m-01');
    //$to = date("Y-m-d");

    //$from = "2021-06-01";
    //$to = "2021-06-30";

    $subTitle = "Date :" . $from . "- " . $to . "Request By:" . Auth::user()->name;
    $subLineM = "OFFLINE :Sales Report :Orders|Payments|Samples|Order Count | Lead Count" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo('pooja@max.net', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
   // $email->addCc('pooja@max.net', 'Pooja Gupta');
   // $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Name </th>
                              <th>Order Values </th>
                              <th>Payment Received </th>
															<th>Samples </th>														
															<th>Orders Count </th>														
															<th>Leads Assined/Claim Count </th>		
                              <th>Units </th>														
                              <th>Batch Size </th>												
														</tr>
													</thead>
													<tbody>';


    //sample

    $dataArr = AyraHelp::getSalesReportFirsttoYet($from, $to);


    foreach ($dataArr as $key => $rowData) {
      $i++;
      $body .= '<tr>
    															<th scope="row">' . $i . '</th>
    															<td>' . $rowData['name'] . '</td>
                                  <td>' . $rowData['order'] . '</td>
                                  <td>' . $rowData['payment'] . '</td>
                                  <td>' . $rowData['sample'] . '</td>                             
                                  <td>' . $rowData['OrderCount'] . '</td>                             
                                  <td>' . $rowData['LeadCount'] . '</td>     
                                  <td>' . $rowData['OrderUnit'] . '</td>                             
                                  <td>' . $rowData['OrderBatchSize'] . '</td>                         
                               
                                </tr>';
    }


    //sample



    $body .= '</tbody>
												</table>';


    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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
  //daily_previous_day
  public function daily_previous_day()
  {


    // $today_Date="2021-12-24";
    $todayA = new Carbon();

    if ($todayA->dayOfWeek == Carbon::MONDAY) {
      $today_Date = date('Y-m-d', strtotime("-2 days"));
    } else {
      $today_Date = date('Y-m-d', strtotime("-1 days"));
    }
    //$today_Date="2022-05-04"; 

    $total_lead = DB::table('indmt_data')->whereDate('created_at', $today_Date)->count();
    $total_buy_lead = DB::table('indmt_data')->whereDate('created_at', $today_Date)->where('QTYPE', 'B')->count();

    $buy_lead_claim = DB::table('indmt_data')->whereDate('created_at', $today_Date)->where('QTYPE', 'B')->whereNotNull('assign_on')->count();
    $total_claim = DB::table('indmt_data')->whereDate('created_at', $today_Date)->whereNotNull('assign_on')->count();
    $call_anwer = DB::table('indmt_data')->whereDate('created_at', $today_Date)->where('QTYPE','P')->count();
    $call_missed = DB::table('indmt_data')->whereDate('created_at', $today_Date)->whereNotNull('assign_on')->count();
    $total_W_lead = DB::table('indmt_data')->whereDate('created_at', $today_Date)->where('QTYPE', 'W')->count();

    DB::table('daily_previous_day')
      ->updateOrInsert(
        ['lead_date' => $today_Date],
        [
          'total_lead' => $total_lead,
          'total_buy_lead' => $total_buy_lead,
          'buy_lead_claim' => $buy_lead_claim,
          'total_claim' => $total_claim,
          'total_lead_converted' => 0,
          'top_sales_lc' => 0,
          'lowest_sales_lc' => 0,
          'lead_date' => $today_Date,
          'call_anwer' => $call_anwer,
          'call_missed' => $call_missed,
          'total_W_lead' => $total_W_lead
        ]
      );


    // DB::table('daily_previous_day')->insert([
    //   'total_lead' => $total_lead,
    //   'total_buy_lead' => $total_buy_lead,
    //   'buy_lead_claim' => $buy_lead_claim,
    //   'total_claim' => $total_claim,
    //   'total_lead_converted' => 0,
    //   'top_sales_lc' => 0,
    //   'lowest_sales_lc' => 0,
    //   'lead_date' => $today_Date
    // ]);
    //email template
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";
    $subTitle = "Date :" . $today_Date;
    $subLineM = "Previous Day Lead Details" . ":" . $subTitle;


    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    //$email->addTo('gupta@max.net', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addTo('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
                           <thead class="thead-inverse">
                             <tr>
                               <th>S#</th>
                               <th>Date </th>
                               <th>Total Lead </th>
                               <th>Total Lead Claim </th>
                               <th>Total Buy Lead </th>														
                               <th>Total Buy Lead Claim </th>														                               
                               <th>Total Direct Lead </th>														                               
                             </tr>
                           </thead>
                           <tbody>';

    $total_leadArr = DB::table('daily_previous_day')->whereDate('lead_date', $today_Date)->first();
    if ($total_leadArr != null) {
      $body .= '<tr>
                            <th scope="row">1</th>
                            <td>' . date('j F Y', strtotime($total_leadArr->lead_date)) . '</td>
                            <td>' . $total_leadArr->total_lead . '</td>
                            <td>' . $total_leadArr->total_claim . '</td>
                            <td>' . $total_leadArr->total_buy_lead . '</td>
                            <td>' . $total_leadArr->buy_lead_claim . '</td>
                            <td>' . $total_leadArr->total_W_lead . '</td>
                         
                         
                          </tr>';
    }
    $body .= '</tbody>
                           </table>';

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





    //email template

  }
  //daily_previous_day

  //updateQCBalanceQTY
  public function updateQCBalanceQTY()
  {
    $qcArrData = DB::table('qc_forms')
            ->where('is_deleted',0)
            ->where('dispatch_status',2)
            ->get();
            $totoUNIT=0;
    foreach ($qcArrData as $key => $rowData) {
      $form_id=$rowData->form_id;     

      if ($rowData->qc_from_bulk == 1) {
        $totoUNIT = DB::table('qc_bulk_order_form')
        ->where('form_id',$form_id)        
        ->sum('qty');

    } else {
        $totoUNIT=$rowData->item_qty;
    }

     //sales_invoice_request
     $total_unitsAdd = DB::table('sales_invoice_request')
        ->where('form_id',$form_id)        
        ->where('status',1)        
        ->sum('total_units');

    $qty_balance = DB::table('qc_forms')
    ->where('form_id', $form_id)
    ->update([
      'totol_qty' => $totoUNIT,
      'qty_balance' => $total_unitsAdd

    ]);


    


    ///sales_invoice_request

    }

   


       
  }
  //updateQCBalanceQTY


  public function sendEmail_SalesReportFirsttoYet()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";

    //$sent_toEmail="bointldev@gmail.com";
    //email
    $from = date('Y-m-01');
    $to = date("Y-m-d");

    //$from = "2021-12-01";
    //$to = "2021-12-12";

    $subTitle = "Date :" . $from . "- " . $to;
    $subLineM = "OFFLINE :Sales Report :Orders|Payments|Samples|Order Count | Lead Count" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo('gupta@max.net', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    $email->addCc('nitika@max.net', 'Admin');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    // // $email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Name </th>
                              <th>Order Values </th>
                              <th>Payment Received </th>
															<th>Samples </th>														
															<th>Orders Count </th>														
															<th>Leads Assined/Claim Count </th>														
                              <th>Units </th>														
                              <th>Batch Size </th>														
														</tr>
													</thead>
													<tbody>';


    //sample

    $dataArr = AyraHelp::getSalesReportFirsttoYet($from, $to);


    foreach ($dataArr as $key => $rowData) {
      $i++;
      $body .= '<tr>
    															<th scope="row">' . $i . '</th>
    															<td>' . $rowData['name'] . '</td>
                                  <td>' . $rowData['order'] . '</td>
                                  <td>' . $rowData['payment'] . '</td>
                                  <td>' . $rowData['sample'] . '</td>                             
                                  <td>' . $rowData['OrderCount'] . '</td>                             
                                  <td>' . $rowData['LeadCount'] . '</td>                             
                                  <td>' . $rowData['OrderUnit'] . '</td>                             
                                  <td>' . $rowData['OrderBatchSize'] . '</td>                             
                               
                                </tr>';
    }


    //sample



    $body .= '</tbody>
												</table>';


    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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

  //email



  // AyraHelp::getSalesReportFirsttoYet();

  //sampleSendDemo
  public function sendEmail_forOrderNotification()
  {




    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $today_Date = Carbon::yesterday();
    $todayA = new Carbon();

    if ($todayA->dayOfWeek == Carbon::MONDAY) {
      $dateOLD = Carbon::now()->subDays(2);
      $subLineM = "Order Added in ERP on Saturday : " . $dateOLD;
    } else {
      $subLineM = "Order Added in ERP on Yestarday : " . $today_Date;
    }


    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    $email->addTo('gupta@max.net', '');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('nitika@max.net', 'Admin');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    //$email->addCc('pooja@max.net', 'Pooja Gupta');
    //  $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    //$email->addTo('bointldev@gmail.com', 'Ajay kumar');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Order ID </th>
                              <th>Brand Name </th>
                              <th>Sales Person </th>
                              <th>Order Type </th>
															<th>Item Name </th>
															<th>Order Value </th>
															<th>Created on</th>
														</tr>
													</thead>
													<tbody>';


    //sample
    $todayA = new Carbon();

    if ($todayA->dayOfWeek == Carbon::MONDAY) {
      $dateOLD = Carbon::now()->subDays(2);
      $sample_arr = QCFORM::where('is_deleted', 0)->whereDate('created_at', $dateOLD)->get();
    } else {
      $sample_arr = QCFORM::where('is_deleted', 0)->whereDate('created_at', Carbon::yesterday())->get();
    }
    // $sample_arr = QCFORM::where('is_deleted', 0)->where('qc_from_bulk',1)->limit(11)->get();



    foreach ($sample_arr as $key => $value) {
      $oderType = "";
      $itemA = "";
      $i++;
      $users = Client::where('id', $value->client_id)->first();

      $OrderID = $value->order_id . "/" . $value->subOrder;
      $brand_name = $value->brand_name;


      if ($value->qc_from_bulk == 1) {
        $oderType = 'BULK';
        $orderVal = $value->bulk_order_value;

        $bulkOrderArr = DB::table('qc_bulk_order_form')
          ->where('form_id', $value->form_id)
          ->get();


        foreach ($bulkOrderArr as $key => $rowA) {
          //print_r($row->item_name);
          if (!empty($rowA->item_name)) {
            $itemA .= $rowA->item_name . "|";
          }
        }
        $item_name = $itemA;
      } else {
        $orderVal = ceil($value->item_qty * $value->item_sp);
        $item_name = $value->item_name;
        $oderType = 'PRIVATE  LABEL';
      }




      $createdWITH = date('j F Y H:i', strtotime($value->created_at));
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $body .= '<tr>
              <th scope="row">' . $i . '</th>
              <td>' . $OrderID . '</td>
              <td>' . $brand_name . '</td>
              <td>' . $salesPrrname . '</td>
              <td>' . $oderType . '</td>
              <td>' . $item_name . '</td>
              <td>' . $orderVal . '</td>
              <td>' . $createdWITH . '</td>
              </tr>';

      //   DB::table('tbl_3month_order')->insert(
      //     [
      //       'orderid' => $OrderID,
      //       'brand_name' => $brand_name,
      //       'sales_name' => $salesPrrname,
      //       'item_name' => $item_name,
      //       'order_value' =>$orderVal,
      //       'created_at' => $createdWITH,
      //     ]
      // );

    }


    //sample



    $body .= '</tbody>
												</table>';
    $alink = url('/') . '/my-order-list';

    // $body .='<a href="'.$alink.'">Donwload Order</a>';

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



    //email


  }

  //send email except oil category 
  //sendEmail_forOrderNotification
  public function sendEmail_forSampleNotification_ExceptOils()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $today_Date = date('Y-m-d');
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject("Pending Samples List with Category | " . $today_Date);
    // $email->addTo('bointl.anamika@gmail.com', 'Anamika');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('gupta@max.net');
    // $email->addTo('ajay.boint@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
                           <thead class="thead-inverse">
                             <tr>
                               <th>S#</th>
                               <th>Sample ID </th>
                               <th>Customer Name </th>
                               <th>Sales Person </th>
                               <th>Created on</th>
                               <th>Category </th>
                             </tr>
                           </thead>
                           <tbody>';


    //sample
    $sample_arr = Sample::where('status', 1)->where('sample_type', '!=', 2)->where('is_deleted', 0)->whereDate('created_at', '>=', '2020-06-15')->get();
    foreach ($sample_arr as $key => $value) {
      $i++;
      $users = Client::where('id', $value->client_id)->first();
      if ($value->created_at != null) {
        $sample_created = date("Y-m-d", strtotime($value->created_at));
        $today = date('Y-m-d');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $sample_created);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
        $diff_in_days = $from->diffInDays($to);
        $createdWITH = $sample_created . " <strong style='color:red'>( " . $diff_in_days . " days before)</strong>";
      } else {
        $sample_created = '';
        $createdWITH = $sample_created;
      }
      $sTypeStr = "";
      switch ($value->sample_type) {
        case 1:
          $sTypeStr = "Standard Cosmetics";
          break;
        case 2:
          $sTypeStr = "Oils";
          break;
        case 3:
          $sTypeStr = "General Changes";
          break;
        case 4:
          $sTypeStr = "As per benchmark";
          break;
        case 5:
          $sTypeStr = "Modifications";
          break;
      }

      $sample_code = $value->sample_code;
      $client_data = AyraHelp::getClientbyid($value->client_id);

      $firstname = isset($client_data->firstname) ? $client_data->firstname : "";
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $body .= '<tr>
                 <th scope="row">' . $i . '</th>
                 <td>' . $sample_code . '</td>
               <td>' . $firstname . '</td>
               <td>' . $salesPrrname . '</td>
                 <td>' . $createdWITH . '</td>
                 <td>' . $sTypeStr . '</td>
               </tr>';
    }


    //sample



    $body .= '</tbody>
                         </table>';
    $alink = url('/') . '/my-sample-list';

    $body .= '<a href="' . $alink . '">Donwload Sample</a>';

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



    //email


  }


  //send email except oil category 

  //send oil catehory samples
  //sendEmail_forOrderNotification
  public function sendEmail_forSampleNotification_oils()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $today_Date = date('Y-m-d');
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject("Pending Samples List with OILS| " . $today_Date);
    // $email->addTo('bointl.anamika@gmail.com', 'Anamika');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    // $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('gupta@max.net');
    $email->addTo('ajay.boint@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Sample ID </th>
                              <th>Customer Name </th>
															<th>Sales Person </th>
                              <th>Created on</th>
                              <th>Category </th>
														</tr>
													</thead>
													<tbody>';


    //sample
    $sample_arr = Sample::where('status', 1)->where('sample_type', 2)->where('is_deleted', 0)->whereDate('created_at', '>=', '2020-06-15')->get();
    foreach ($sample_arr as $key => $value) {
      $i++;
      $users = Client::where('id', $value->client_id)->first();
      if ($value->created_at != null) {
        $sample_created = date("Y-m-d", strtotime($value->created_at));
        $today = date('Y-m-d');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $sample_created);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
        $diff_in_days = $from->diffInDays($to);
        $createdWITH = $sample_created . " <strong style='color:red'>( " . $diff_in_days . " days before)</strong>";
      } else {
        $sample_created = '';
        $createdWITH = $sample_created;
      }
      $sTypeStr = "";
      switch ($value->sample_type) {
        case 1:
          $sTypeStr = "Standard Cosmetics";
          break;
        case 2:
          $sTypeStr = "Oils";
          break;
        case 3:
          $sTypeStr = "General Changes";
          break;
        case 4:
          $sTypeStr = "As per benchmark";
          break;
        case 5:
          $sTypeStr = "Modifications";
          break;
      }

      $sample_code = $value->sample_code;
      $client_data = AyraHelp::getClientbyid($value->client_id);

      $firstname = isset($client_data->firstname) ? $client_data->firstname : "";
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $body .= '<tr>
                <th scope="row">' . $i . '</th>
                <td>' . $sample_code . '</td>
              <td>' . $firstname . '</td>
              <td>' . $salesPrrname . '</td>
                <td>' . $createdWITH . '</td>
                <td>' . $sTypeStr . '</td>
              </tr>';
    }


    //sample



    $body .= '</tbody>
												</table>';
    $alink = url('/') . '/my-sample-list';

    $body .= '<a href="' . $alink . '">Donwload Sample</a>';

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



    //email


  }

  //send oil catehory samples

  //saveOrderEditREQ
  public function saveOrderEditREQEEE(Request $request)
  {
    //  send email report 
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email

    $subTitle = 44;

    $subLineM = "Order Edit Request -" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    // $email->setFrom($fromEmail,$fromName);
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    //$email->addTo('gupta@max.net', '');  
    // $email->addTo('pooja@gmail.com', 'Ajay kumar'); 
    // $email->addTo('pooja@gmail.com', 'Ajay kumar'); 
    // $email->addTo('pooja@max.net', 'Pooja Gupta');
    $email->addTo('bointldev@gmail.com', 'Pooja Gupta');
    // $email->addTo('anujranaTemp@max.net', 'Anuj Rana');
    // $email->addCc($fromEmail,$fromName);
    // $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;
    $body = 'Approval Required';
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
      echo "dddd";
      die;
      // // $affected = DB::table('indmt_data')
      // //         ->where('QUERY_ID', $rows->QUERY_ID)
      // //         ->update(['email_sent' => 1]);
      // //sms





      //sms


    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
  }
  public function saveOrderEditREQ(Request $request)
  {

    //order_edit_requests


    $orderOBJ = new OrderEditRequest;
    $orderOBJ->form_id = $request->txtFOMID;
    $orderOBJ->type_id = $request->orderReqType;
    $orderOBJ->notes = $request->txtRemarkEDITREQ;
    $orderOBJ->created_by = Auth::user()->id;
    $orderOBJ->save();
    $filename = 0;
    if ($request->hasfile('file')) {
      $file = $request->file('file');
      $filename = "img_1ORDEREDIT" . $request->txtFOMID . "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();
      // save to local/uploads/photo/ as the new $filename
      $path = $file->storeAs('photos', $filename);
      OrderEditRequest::where('id', $orderOBJ->id)
        ->update(['file_name' => $filename]);
    }
    //send mail 


    $data_qc_arr = QCFORM::where('form_id', $request->txtFOMID)->get()->first();
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

    $qcData = array(
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
      'orderVal' => '<i class="fa fa-rupee-sign"></i> ' . $data_qc_arr->item_sp * $data_qc_arr->item_qty,
      'sp_view' => $sp_view,
      'img_url' => optional($data_qc_arr)->pack_img_url,
    );

    $orderTypeArr = DB::table('order_edit_type')
      ->where('id', $request->orderReqType)
      ->first();
    $fromEmail = Auth::user()->email;
    $fromName = Auth::user()->name;

    //  send email report 
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";

    //$sent_toEmail="bointldev@gmail.com";
    //email

    $subTitle = $orderTypeArr->name;

    $subLineM = "Order Edit Request -" . ":" . $subTitle;

    $email = new \SendGrid\Mail\Mail();
    // $email->setFrom($fromEmail,$fromName);
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject($subLineM);
    // $email->addTo('gupta@max.net', '');  
    // $email->addTo('pooja@gmail.com', 'Ajay kumar'); 
    //  $email->addTo('pooja@gmail.com', 'Ajay kumar'); 
    // $email->addTo('pooja@max.net', 'Pooja Gupta');
    $email->addTo('pooja@max.net', 'Pooja Gupta');
    //  $email->addTo('anujranaTemp@max.net', 'Anuj Rana');
    $email->addCc($fromEmail, $fromName);
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    $i = 0;

    //team 1
    $request_FOR = $orderTypeArr->name;
    $request_REMARK = $request->txtRemarkEDITREQ;
    $request_ORDERID = $qcData['order_id'] . "(" . $qcData['order_type'] . ")";
    $request_BRAND = $qcData['brand_name'] . "-" . $qcData['client_name'];
    $request_CREATED_AT = $qcData['created_at'];
    $request_CREATED_BY = $qcData['sales_person'];
    $request_ACCOUNT_STATUS = $data_qc_arr->account_approval == 1 ? "APPROVED" : "PENDING";
    $request_SAMPLE = $qcData['fms'];
    $request_ACCOUNT_NOTES = $data_qc_arr->account_msg;
    $request_ERP_SENT_ON = date('Y-m-d H:iA');

    $body = file_get_contents('qc_private.php');
    $body = str_replace('{{--request_FOR--}}', $request_FOR, $body);
    $body = str_replace('{{--request_REMARK--}}', $request_REMARK, $body);
    $body = str_replace('{{--request_ORDERID--}}', $request_ORDERID, $body);
    $body = str_replace('{{--request_BRAND--}}', $request_BRAND, $body);
    $body = str_replace('{{--request_CREATED_AT--}}', $request_CREATED_AT, $body);
    $body = str_replace('{{--request_CREATED_BY--}}', $request_CREATED_BY, $body);
    $body = str_replace('{{--request_ACCOUNT_STATUS--}}', $request_ACCOUNT_STATUS, $body);
    $body = str_replace('{{--request_SAMPLE--}}', $request_SAMPLE, $body);
    $body = str_replace('{{--request_ACCOUNT_NOTES--}}', $request_ACCOUNT_NOTES, $body);
    $body = str_replace('{{--request_ERP_SENT_ON--}}', $request_ERP_SENT_ON, $body);

    $body .= 'Approval Required';








    //team 1



    // $body .='<a href="'.$alink.'">Donwload Order</a>';
    if ($filename == 0) {

      $email->addContent(
        "text/html",
        $body
      );
    } else {
      $email->addContent(
        "text/html",
        $body
      );
      $fileAdd = asset('local/public/uploads/photos') . "/" . $filename;
      $file_encoded = base64_encode(file_get_contents($fileAdd));

      $email->addAttachment(
        $file_encoded,
        "application/jpg",
        $filename,
        "attachment"
      );
    }







    $sendgrid = new \SendGrid($Apikey);
    try {


      $response = $sendgrid->send($email);
      // print $response->statusCode() . "\n";
      //  print_r($response->headers());
      //  print $response->body() . "\n";
      //  echo "dddd";
      //  die;
      // // $affected = DB::table('indmt_data')
      // //         ->where('QUERY_ID', $rows->QUERY_ID)
      // //         ->update(['email_sent' => 1]);
      // //sms





      //sms


    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }

    //  send email report 

    //send mail

    $resp = array(
      'status' => 1,

    );

    return response()->json($resp);


    //order_edit_requests

  }
  //saveOrderEditREQ

  //getOrderCosting
  //setBulkOrderReqIssueProcessHistory
  public function setBulkOrderReqIssueProcessHistory(Request $request)
  {
    //print_r($request->all());
    $form_id = $request->form_id;

    $eventHisArr = DB::table('logged_activity')
      ->where('event_name', 'BulkOrderRequestHis')
      ->where('event_id', $form_id)
      ->get();
    $HTML = '<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
              <tr>
                <th>#</th>
                <th>Created By</th>
                <th>Message</th>
                <th>Created on</th>
              </tr>
            </thead>
            <tbody>';
    $i = 0;
    foreach ($eventHisArr as $key => $value) {
      $i++;
      $HTML .= '<tr>
              <th scope="row">' . $i . '</th>
              <td>' . AyraHelp::getUser($value->user_id)->name . '</td>
              <td>' . $value->event_info . '</td>
              <td>' . date('j F Y', strtotime($value->created_at)) . '</td>
            </tr>';
    }
    $HTML .= '	</tbody>
            </table>';


    $resp = array(
      'status' => 1,
      'HTML' => $HTML,

    );

    return response()->json($resp);
  }
  //setBulkOrderReqIssueProcessHistory

  //getNewLeadOrderfromSource
  public function getNewLeadOrderfromSource()
  {
    $st_date = "2011-11-01";
    $et_date = "2021-10-31";
    $leadArr = DB::table('lead_order_firstime_source')
      ->get();
    foreach ($leadArr as $key => $rowData) {
      $client_id = $rowData->client_id;
      $qc_arrData = QCFORM::where('client_id', $client_id)->where('is_deleted', 0)->whereDate('created_at', '>=', $st_date)->whereDate('created_at', '<=', $et_date)->orderby('form_id', 'asc')->first();
      if ($qc_arrData == null) {
      } else {
        $affected = DB::table('lead_order_firstime_source')
          ->where('client_id', $qc_arrData->client_id)
          ->update(['countOrder' => 5]);
      }
    }





    die;




    foreach ($qc_arrData as $key => $rowData) {





      $orderID = $rowData->order_id . "/" . $rowData->subOrder;
      $client_id = $rowData->client_id;
      $client_arr = AyraHelp::getClientbyid($client_id);
      $company = isset($client_arr->company) ? $client_arr->company : '';
      $brand = isset($client_arr->brand) ? $client_arr->brand : '';
      $brandCompany = $brand . "(<b>" . $company . "</b>)";
      $sumTotal = 0;

      if ($rowData->order_type == 'Bulk') {
        $strOT = "BULK";
        $sum = $rowData->bulk_order_value;
        $sumTotal = $sum + $sumTotal;
      } else {
        $strOT = "PRIVATE LABEL";
        $sum = $rowData->item_qty * $rowData->item_sp;
        $sumTotal = $sum + $sumTotal;
      }
      switch ($rowData->order_type_v1) {
        case 1:
          $strN = "NEW";
          break;
        case 2:
          # code...
          $strN = "REPEAT";
          break;
        case 3:
          # code...
          $strN = "ADDITION";
          break;
      }
      $salesPrrname = AyraHelp::getUser($rowData->created_by)->name;
      $isInd = "";
      $lemail = DB::table('indmt_data')
        ->where('SENDEREMAIL', $client_arr->email)
        ->count();
      if ($lemail >= 0) {
        $isInd = "INDM";
      }
      $lcomp = DB::table('indmt_data')
        ->where('GLUSR_USR_COMPANYNAME', $company)
        ->whereNotNull('GLUSR_USR_COMPANYNAME')
        ->count();
      if ($lcomp >= 0) {
        $isInd = "INDM";
      }




      $leadOrderArr = DB::table('lead_order_firstime_source')
        ->where('client_id', $client_id)
        ->first();

      if ($leadOrderArr == null) {
        DB::table('lead_order_firstime_source')->insert([
          'form_id' => $rowData->form_id,
          'order_id' => $orderID,
          'brand' => $brand,
          'company' => $company,
          'phone' => $client_arr->phone,
          'email' => @$client_arr->email,
          'type' => $strOT,
          'sales_person' => $salesPrrname,
          'order_type' => $strN,
          'source' => '',
          'order_created_at' =>  $rowData->created_at,
          'sumTotal' =>  $sumTotal,
          'lead_created_on' => $client_arr->created_at,
          'client_id' => $client_id,
          // 'lead_on_indiamart' => $client_arr->created_at,

        ]);
      }
    }
  }
  //getNewLeadOrderfromSource

  //getOrderCosting_V1
  public function getOrderCosting()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $todayA = new Carbon();

    if ($todayA->dayOfWeek == Carbon::MONDAY) {
      $today_Date = date('Y-m-d', strtotime("-2 days"));
    } else {
      $today_Date = date('Y-m-d', strtotime("-1 days"));

    }
    //$today_Date="2022-05-04";

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject("Order Costing  Report of  :" . $today_Date);

    $email->addTo('gupta@max.net', 'Admin');
    $email->addTo('nitika@max.net', 'Admin');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    //  $email->addTo('bointldev@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '
    <table  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
													<thead class="thead-inverse">
														<tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;" >S#</th>
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Order ID </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Brand-Company </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Order Type </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Details </th>                             
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Created On </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Created By</th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Account Details </th>                             
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Unit</th>                             
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Order Kinds </th>                             
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Batch Size </th>                             


														</tr>
													</thead>
													<tbody>';
    // $today_Date = "2021-09-01";
    if ($todayA->dayOfWeek == Carbon::MONDAY) {
      $today_Date = date('Y-m-d', strtotime("-2 days"));
    } else {
      $today_Date = date('Y-m-d', strtotime("-1 days"));
    }


    $qc_arrData = QCFORM::where('is_deleted', 0)->whereDate('created_at', '>=', $today_Date)->get();
    foreach ($qc_arrData as $key => $rowData) {
      $orderID = $rowData->order_id . "/" . $rowData->subOrder;
      $client_id = $rowData->client_id;
      $client_arr = AyraHelp::getClientbyid($client_id);
      $company = isset($client_arr->company) ? $client_arr->company : '';
      $brand = isset($client_arr->brand) ? $client_arr->brand : '';


      $brandCompany = $brand . "(<b>" . $company . "</b>)";

      if ($rowData->account_approval == 1) {
        $strAcc = "Approved";
      } else {
        $strAcc = "Pending";
      }
      $priceDetailV = "";
      $itemDetailV = "";
      $UnitQTY = 0;
      $BatchSize = 0;
      $ajUNIT = 0;
      if ($rowData->order_type == 'Bulk') {
        $bulkOrder = DB::table('qc_bulk_order_form')
          ->where('form_id', $rowData->form_id)
          ->whereNotNull('item_name')
          ->get();
        $priceDetailV .= '<table border="0">';

        foreach ($bulkOrder as $key => $row) {
          $ajUNIT++;
          $valA = $row->item_sell_p * $row->qty;
          // $UnitQTY=$UnitQTY+$row->qty;
          $BatchSize = $BatchSize + $row->qty;
          $priceDetailV .= '
                <tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $row->item_name . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>QTY</b><br>:' . $row->qty . ' ' . $row->item_size . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Price:</b><br>' . $row->item_sell_p . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Rate:</b><br>' . $row->rate . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Value:</b><br>' . $valA . '</td>
                </tr>
                ';
        }
        $priceDetailV .= '</table>';
      } else {
        $priceDetailV .= '<table  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">';
        $priceDetailV .= '
        <tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $rowData->item_name . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>RM Price/Kg</b><br>:' . $rowData->item_RM_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Bottle/Cap/Pump:</b><br>' . $rowData->item_BCJ_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Label Price::</b><br>' . $rowData->item_Label_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>M.Carton Price:</b><br>' . $rowData->item_Material_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>L & C Price:</b><br>' . $rowData->item_LabourConversion_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Margin:</b><br>' . $rowData->item_Margin_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Selling Price Per(₹):</b><br>' . $rowData->item_sp . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Order Value(₹):</b><br>' . ($rowData->item_qty) * ($rowData->item_sp) . '</td>
        </tr>
        ';
        $priceDetailV .= '</table>';
        $ajUNIT = $ajUNIT + $rowData->item_qty;
        //$ajUNIT=1;
        $BatchSize = ($rowData->item_qty * $rowData->item_size) / 1000;
      }

      $created_at = date('j ,F Y', strtotime($rowData->created_at));
      $salesPrrname = AyraHelp::getUser($rowData->created_by)->name;
      $order_type_v1 = "";
      switch ($rowData->order_type_v1) {
        case 1:
          # code...
          $order_type_v1 = "NEW";
          break;
        case 2:
          # code...
          $order_type_v1 = "REPEAT";
          break;
        case 3:
          # code...
          $order_type_v1 = "ADDITION";
          break;
      }

      $body .= '<tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
                <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;" scope="row">' . $i . '</th>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $orderID . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $brandCompany . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $rowData->order_type . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $priceDetailV . '</td>               
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $created_at . '</td>                             
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $salesPrrname . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $strAcc . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $ajUNIT . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $order_type_v1 . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $BatchSize . '</td>
               
              </tr>';
    }


    //sample



    $body .= '</tbody>
                        </table><br><hr>';




    // $alink = url('/') . '/my-sample-list';

    // $body .= '<a href="' . $alink . '">Donwload Sample</a>';

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



    //email


  }
  //getOrderCosting_V1
  public function getOrderCostingAAOk()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    // $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $today_Date = date('Y-m-d', strtotime("-1 days"));
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject("Order Costing  Report of  :" . $today_Date);

    $email->addTo('gupta@max.net', 'Admin');
    $email->addTo('nitika@max.net', 'Admin');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    // $email->addTo('bointldev@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '
    <table  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
													<thead class="thead-inverse">
														<tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;" >S#</th>
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Order ID </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Brand-Company </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Order Type </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Details </th>                             
															<th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Created On </th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Created By</th>
                              <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">Account Details </th>                             
														</tr>
													</thead>
													<tbody>';
    // $today_Date = "2021-09-01";
    $today_Date = date('Y-m-d', strtotime("-1 days"));

    $qc_arrData = QCFORM::where('is_deleted', 0)->whereDate('created_at', '>=', $today_Date)->get();
    foreach ($qc_arrData as $key => $rowData) {
      $orderID = $rowData->order_id . "/" . $rowData->subOrder;
      $client_id = $rowData->client_id;
      $client_arr = AyraHelp::getClientbyid($client_id);
      $company = isset($client_arr->company) ? $client_arr->company : '';
      $brand = isset($client_arr->brand) ? $client_arr->brand : '';


      $brandCompany = $brand . "(<b>" . $company . "</b>)";

      if ($rowData->account_approval == 1) {
        $strAcc = "Approved";
      } else {
        $strAcc = "Pending";
      }
      $priceDetailV = "";
      $itemDetailV = "";

      if ($rowData->order_type == 'Bulk') {
        $bulkOrder = DB::table('qc_bulk_order_form')
          ->where('form_id', $rowData->form_id)
          ->whereNotNull('item_name')
          ->get();
        $priceDetailV .= '<table border="0">';
        foreach ($bulkOrder as $key => $row) {
          $valA = $row->item_sell_p * $row->qty;
          $priceDetailV .= '
                <tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $row->item_name . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>QTY</b><br>:' . $row->qty . ' ' . $row->item_size . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Price:</b><br>' . $row->item_sell_p . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Rate:</b><br>' . $row->rate . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Value:</b><br>' . $valA . '</td>
                </tr>
                ';
        }
        $priceDetailV .= '</table>';
      } else {
        $priceDetailV .= '<table  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">';
        $priceDetailV .= '
        <tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $rowData->item_name . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>RM Price/Kg</b><br>:' . $rowData->item_RM_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Bottle/Cap/Pump:</b><br>' . $rowData->item_BCJ_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Label Price::</b><br>' . $rowData->item_Label_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>M.Carton Price:</b><br>' . $rowData->item_Material_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>L & C Price:</b><br>' . $rowData->item_LabourConversion_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Margin:</b><br>' . $rowData->item_Margin_Price . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Selling Price Per(₹):</b><br>' . $rowData->item_sp . '</td>
        <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;"><b>Order Value(₹):</b><br>' . ($rowData->item_qty) * ($rowData->item_sp) . '</td>
        </tr>
        ';
        $priceDetailV .= '</table>';
      }

      $created_at = date('j ,F Y', strtotime($rowData->created_at));
      $salesPrrname = AyraHelp::getUser($rowData->created_by)->name;

      $body .= '<tr  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">
                <th  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;" scope="row">' . $i . '</th>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $orderID . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $brandCompany . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $rowData->order_type . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $priceDetailV . '</td>               
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $created_at . '</td>                             
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $salesPrrname . '</td>
                <td  style="background-color:#FFF; border: 1px solid black;  border-collapse: collapse;">' . $strAcc . '</td>
               
              </tr>';
    }


    //sample



    $body .= '</tbody>
                        </table><br><hr>';




    // $alink = url('/') . '/my-sample-list';

    // $body .= '<a href="' . $alink . '">Donwload Sample</a>';

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



    //email


  }

  //getOrderCosting

  //sendEmail_forOrderNotification
  public function sendEmail_forSampleNotification()
  {

    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";
    //$sent_toEmail="bointldev@gmail.com";
    //email
    $today_Date = date('Y-m-d');
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@max.net", "MAX");
    $email->setSubject("Pending Samples List with category | Assinged | Formulated status " . $today_Date);
    $email->addTo('bo.sampling@gmail.com', 'Yasir');
    // $email->addTo('bointlresearch@gmail.com', 'Anitha');
    $email->addCc('nitika@max.net', 'Admin');
    $email->addCc('pooja@max.net', 'Pooja Gupta');
    // $email->addCc('anujranaTemp@max.net', 'Anuj Rana');
    $email->addCc('gupta@max.net');
    $email->addBcc('bointldev@gmail.com', 'Ajay');
    // $email->addTo('bointldev@gmail.com', 'Ajay Kumar');
    $i = 0;
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $body = '<table  border="1" style="background-color:#ccc">
													<thead class="thead-inverse">
														<tr>
															<th>S#</th>
															<th>Sample ID </th>
                              <th>Customer Name </th>
															<th>Sales Person </th>
                              <th>Created on</th>
                              <th>Category </th>
                              <th>Assigned To </th>
                              <th>Assigned on </th>
                              <th>Formulated </th>
														</tr>
													</thead>
													<tbody>';


    //sample
    $sample_arr = Sample::where('status', 1)->where('is_deleted', 0)->whereDate('created_at', '>=', '2020-06-15')->get();
    foreach ($sample_arr as $key => $value) {
      $i++;
      $users = Client::where('id', $value->client_id)->first();
      if ($value->created_at != null) {
        $sample_created = date("Y-m-d", strtotime($value->created_at));
        $today = date('Y-m-d');
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $sample_created);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
        $diff_in_days = $from->diffInDays($to);
        $createdWITH = $sample_created . " <strong style='color:red'>( " . $diff_in_days . " days before)</strong>";
      } else {
        $sample_created = '';
        $createdWITH = $sample_created;
      }
      $sTypeStr = "";
      switch ($value->sample_type) {
        case 1:
          $sTypeStr = "Standard Cosmetics";
          break;
        case 2:
          $sTypeStr = "Oils";
          break;
        case 3:
          $sTypeStr = "General Changes";
          break;
        case 4:
          $sTypeStr = "As per benchmark";
          break;
        case 5:
          $sTypeStr = "Modifications";
          break;
      }

      $sample_code = $value->sample_code;
      $assingneTo = optional(AyraHelp::getUser($value->assingned_to))->name;
      if ($value->sample_stage_id >= 3) {
        $formulated = 'YES';
      } else {
        $formulated = '';
      }

      // st_process_action_6
      $usersDone = DB::table('st_process_action_6')
        ->where('ticket_id', $value->id)
        ->where('stage_id', 3)
        ->first();
      if ($usersDone == null) {
        $strdoneON = "";
      } else {
        $strdoneON = date('j M Y', strtotime($usersDone->created_at));
      }

      // st_process_action_6

      if (is_null($value->assingned_on)) {
        $assingneON = "";
      } else {
        $assingneON = date('j ,F Y', strtotime($value->assingned_on));
      }




      $client_data = AyraHelp::getClientbyid($value->client_id);

      $firstname = isset($client_data->firstname) ? $client_data->firstname : "";
      $salesPrrname = AyraHelp::getUser($value->created_by)->name;
      $body .= '<tr>
                <th scope="row">' . $i . '</th>
                <td>' . $sample_code . '</td>
              <td>' . $firstname . '</td>
              <td>' . $salesPrrname . '</td>
                <td>' . $createdWITH . '</td>
                <td>' . $sTypeStr . '</td>
                <td>' . $assingneTo . '</td>
                <td>' . $assingneON . '</td>
                <td>' . $formulated . '</td>
                <td>' . $strdoneON . '</td>
              </tr>';
    }


    //sample



    $body .= '</tbody>
                        </table><br><hr>';

    //sample list cout
    // echo "<pre>";
    $dataSampleActiArr = AyraHelp::getSampleActivityList();



    $body .= '<table  border="1" style="background-color:#ccc">
<thead class="thead-inverse">
  <tr>
   
    <th>Pending:(Added-Dispatched) </th>   
    <th>Pending Samples of Standard Cosmetic </th>
    <th>Pending Samples of General Changes </th>
    <th>Pending Samples of Modification </th>
    <th>Pending Samples of As Per Benchmark </th>
    <th>Pending Samples of Oils </th>
  </tr>
</thead>
<tbody>';
    $body .= '<tr>

<td>' . ($dataSampleActiArr['No_of_Samples_Added'] - $dataSampleActiArr['No_of_Samples_Dispatched']) . '</td>

<td>' . $dataSampleActiArr['Pending_Samples_of_Standard_Cosmetic'] . '</td>
<td>' . $dataSampleActiArr['Pending_Samples_of_General_Changes'] . '</td>
<td>' . $dataSampleActiArr['Pending_Samples_of_Modification'] . '</td>
<td>' . $dataSampleActiArr['Pending_Samples_of_As_Per_Benchmark'] . '</td>
<td>' . $dataSampleActiArr['Pending_Samples_of_Oils'] . '</td>
</tr>';
    $body .= '</tbody>
</table><br><hr>';

    //sample list cout

    //sample pending list 
    $dataSamplePendingArr = AyraHelp::getSamplePendingListCount();



    $body .= '<h4>Pending List count </h4><br><table  border="1" style="background-color:#ccc">
 <thead class="thead-inverse">
   <tr>   
     <th>Pending :0-3 days </th>   
     <th>Pending :4-7 days </th>
     <th>Pending :8-15 days </th>
     <th>Pending :16-30 days </th>
     <th>Pending :Above 30 days </th>    
   </tr>
 </thead>
 <tbody>';

    //  $body .= '<tr>

    //  <td>' . $dataSamplePendingArr['0_3days'] . '</td>
    //  <td>' . $dataSamplePendingArr['4_7days'] . '</td>
    //  <td>' . $dataSamplePendingArr['8_15days'] . '</td>
    //  <td>' . $dataSamplePendingArr['16_30days'] . '</td>
    //  <td>' . $dataSamplePendingArr['30_above'] . '</td>
    //  </tr>';

    $body .= '</tbody>
 </table><br><hr>';
    //sample pending list 


    $alink = url('/') . '/my-sample-list';

    $body .= '<a href="' . $alink . '">Donwload Sample</a>';

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



    //email


  }
  public function getClientInfo()
  {
    $mydata = array();
    $order_arr = QCFORM::where('is_deleted', '!=', 1)->get();
    foreach ($order_arr as $key => $value) {
      $client_arr = AyraHelp::getClientByBrandName($value->brand_name);
      $added_arr = AyraHelp::getUser($value->created_by);
      $mydata[] = array(
        'form_id' => $value->form_id,
        'order_id' => $value->order_id,
        'brand_name' => $value->brand_name,
        'email' => optional($client_arr)->email,
        'client_name' => optional($client_arr)->firstname,
        'added_by' => optional($added_arr)->name,
      );
    }
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['data' => $mydata];
    return $theme->scope('sample.print_temp_client', $data)->render();
  }

  public function setSinceFromApiV1()
  {

    $order_arr = DB::table('qc_forms')->where('is_deleted', 1)->where('dispatch_status', 1)->get();

    foreach ($order_arr as $key => $rowData) {
      $fid = $rowData->form_id;
      $data = AyraHelp::getProcessCurrentStage(1, $fid);
      if ($data->stage_id == 1) {
        $data = AyraHelp::getQCFormDate($fid);

        $date = Carbon::parse($data->created_at);
        $now = Carbon::now();
        $diff = $date->diffInDays($now);
      } else {
        $users = DB::table('st_process_action')
          ->where('process_id', '=', 1)
          ->where('ticket_id', '=', $fid)
          ->where('stage_id', '=', $data->stage_id)
          ->first();
        if ($users != null) {
          $date = Carbon::parse($users->created_at);
          $now = Carbon::now();
          $diff = $date->diffInDays($now);
        } else {
          $diff = 0;
        }
      }
      // update
      echo $diff;
      echo "<br>";
      DB::table('qc_forms')
        ->where('form_id', $fid)
        ->update(['since_from' => $diff]);

      // update



    }
  } ///////////////////

  public function sendSMS2Lead()
  {
    //$users = DB::table('indmt_data')->where('DATE_TIME_RE_SYS', '>=', '2020-09-09')->where('sms_sent', 0)->where('duplicate_lead_status', 0)->get();
    $users = DB::table('indmt_data')->where('id', '>=', 155000)->where('sms_sent', 0)->where('duplicate_lead_status', 0)->get();

    foreach ($users as $key => $rows) {

      $phone = substr($rows->MOB, -10);
      $msg = "Greetings from MAX! We are manufacturers of Private Label Personal Care products and Essential Oils. Please whatsapp us on +917290011547 for pricing and catalog. You can also email us on info@max.net";
      $phL = strlen($phone);

      if ($phL == 10) {
        $affected = DB::table('indmt_data')
          ->where('QUERY_ID', $rows->QUERY_ID)
          ->update(['sms_sent' => 1]);
        $datasms = $this->PRPSendSMS($phone, $msg);
      }
    }

    echo "sms sent";
  }

  public function sendEmail2Lead()
  {
    //email 
    require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";

    $users = DB::table('indmt_data')->where('SENDEREMAIL', '!=', '')->where('created_at', '>=', '2020-09-09')->where('email_sent', 0)->where('duplicate_lead_status', 0)->get();

    //$users = DB::table('indmt_data')->where('QUERY_ID','1433740647')->get();
    foreach ($users as $key => $rows) {
      //  $sent_toEmail='bointldev@gmail.com';
      //  $senderName="Ajay Kumar";

      $senderName = ucwords($rows->SENDERNAME);
      $sent_toEmail = $rows->SENDEREMAIL;
      //send send 
      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject("Private Label Skincare Products and Essential Oils");
      $email->addTo($sent_toEmail, $senderName);
      $email->setReplyTo('pooja@max.net', 'info@max.net');
      // $email->addBcc('bointldev@gmail.com', $senderName);

      //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
      $body = file_get_contents('bo_email_sendgrid.html');
      $customNumber = $senderName;
      $body = str_replace('{{--customNumber--}}', $customNumber, $body);
      $body = str_replace('{{--QUERY_ID--}}', $rows->QUERY_ID, $body);

      $email->addContent(
        "text/html",
        $body
      );

      //$file_encoded = base64_encode('a1.pdf');
      $file_encoded = base64_encode(file_get_contents('Bo_International_Cosmetic_Products.pdf'));

      $email->addAttachment(
        $file_encoded,
        "application/pdf",
        "MAX Cosmetic Products.pdf",
        "attachment"
      );
      $file_encoded = base64_encode(file_get_contents('Bo_International_Essential_Oils.pdf'));
      $email->addAttachment(
        $file_encoded,
        "application/pdf",
        "MAX_Essential Oils.pdf",
        "attachment"
      );



      $sendgrid = new \SendGrid($Apikey);
      try {
        $response = $sendgrid->send($email);
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
        $affected = DB::table('indmt_data')
          ->where('QUERY_ID', $rows->QUERY_ID)
          ->update(['email_sent' => 1]);
        // sms





        //sms


      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }


      //email 





    }

    echo "Email sent";
  }


  //setSampleAutoAssingmenetProcess_All
  public function setSampleAutoAssingmenetProcess_All()
  {
    // AyraHelp::setAllSampleAssinedNow();
  }
  //setSampleAutoAssingmenetProcess_All

  //
  //

  //sampletoIngrednentApproval
  public function sampletoIngrednentApproval()
  {
    AyraHelp::sampletoIngrednentApprovalInsert();
  }

  //sampletoIngrednentApproval





  // sendEmailSMS2Lead_PACKING
  public function sendEmailSMS2Lead_PACKING()
  {
    $users = DB::table('indmt_data_pack')->where('DATE_TIME_RE_SYS', '>=', '2020-09-10')->where('sms_sent', 0)->get();

    foreach ($users as $key => $rows) {

      $phone = substr($rows->MOB, -10);
      $msg = "For any requirement of cosmetic packaging,PET bottle, pumps, contact Cosmopack Industries, New Delhi. Our whatsapp no is +919811098426. Message us for price and catalogue. ";
      $phL = strlen($phone);
      if ($phL == 10) {
        //$phone='9999955922';
        $affected = DB::table('indmt_data_pack')
          ->where('QUERY_ID', $rows->QUERY_ID)
          ->update(['sms_sent' => 1, 'sms_senton' => date('Y-m-d H:i:s')]);
        $datasms = $this->PRPSendSMS($phone, $msg);
      }
    }
    //sms //


  }
  // sendEmailSMS2Lead_PACKING
  //tempRndIngedent
  public function tempRndIngedent()
  {
    $arrDataArr = DB::table('table_201')->get();

    foreach ($arrDataArr as $key => $rowData) {
      $dataArrS = array();
      $dataArrS_1 = array();
      $name = $rowData->name;
      $cat = $rowData->cat;
      $size_1 = empty($rowData->size_1) ? "" : $rowData->size_1 . "Kg";
      $price_1 = empty($rowData->price_1) ? "" : "Rs." . $rowData->price_1;
      $size_2 = empty($rowData->size_2) ? "" : $rowData->size_2 . "Kg";
      $price_2 = empty($rowData->price_2) ? "" : "Rs." . $rowData->price_2;
      $size_3 = empty($rowData->size_3) ? "" : $rowData->size_3 . "Kg";
      $price_3 = empty($rowData->price_3) ? "" : "Rs." . $rowData->price_3;




      $dataArrS[] = array(
        'sizeData' => $size_1,
        'rateData' => $price_1,
      );
      $dataArrS[] = array(
        'sizeData' => $size_2,
        'rateData' => $price_2,
      );
      $dataArrS[] = array(
        'sizeData' => $size_3,
        'rateData' => $price_3,
      );
      $dataAA = json_encode($dataArrS);



      $size_1_A = empty($rowData->size_1) ? "" : $rowData->size_1;
      $price_1_A = empty($rowData->price_1) ? "" : $rowData->price_1;
      $size_2_A = empty($rowData->size_2) ? "" : $rowData->size_2;
      $price_2_A = empty($rowData->price_2) ? "" : $rowData->price_2;
      $size_3_A = empty($rowData->size_3) ? "" : $rowData->size_3;
      $price_3_A = empty($rowData->price_3) ? "" : $rowData->price_3;


      $dataArrS_1[] = array(
        'sizeData' => $size_1_A,
        'rateData' => $price_1_A,
      );
      $dataArrS_1[] = array(
        'sizeData' => $size_2_A,
        'rateData' => $price_2_A,
      );
      $dataArrS_1[] = array(
        'sizeData' => $size_3_A,
        'rateData' => $price_3_A,
      );
      $dataAA_1 = json_encode($dataArrS_1);


      DB::table('rnd_add_ingredient')
        ->updateOrInsert(
          ['name' =>  $name],
          [
            'brand_name' => '[""]',
            'supplier_name' => '[""]',
            'created_by' => 21,
            'cat_id' => $cat,
            'size_price' => $dataAA_1,
            'size_1' => $size_1,
            'price_1' => $price_1,
            'size_2' => $size_2,
            'price_2' => $price_2,
            'size_3' => $size_3,
            'price_3' => $price_3,
            'size_1' => $size_1,
            'upload_flag' => 1,
          ]
        );

      // DB::table('rnd_add_ingredient')->insert([
      //   'brand_name' => '[""]',
      //   'supplier_name' => '[""]',
      //   'created_by' => 1,
      //   'cat_id' => $cat,
      //   'name' => $name,
      //   'size_price' => $dataAA_1,
      //   'size_1' => $size_1,
      //   'price_1' => $price_1,
      //   'size_2' => $size_2,
      //   'price_2' => $price_2,
      //   'size_3' => $size_3,
      //   'price_3' => $price_3,
      //   'size_1' => $size_1,
      // ]);

    }
  }
  //tempRndIngedent
  public function getSamplesListWithItems()
  {

    $samples = DB::table('samples')
      ->where('is_deleted', 0)
      ->where('status', 1)
      ->where('is_formulated', 0)
      ->where('sample_stage_id', '<=', 2)
      ->whereDate('created_at', ">=", '2023-06-01')
      ->whereDate('created_at', "<=", '2023-08-31')
      ->get();


    $data = array();
    foreach ($samples as $key => $rowData) {
      $sampleDArr = json_decode($rowData->sample_details);


      if ($rowData->sample_from == 0) {
        $clientArr = DB::table('clients')
          ->where('id', $rowData->client_id)
          ->first();
        $brand = @$clientArr->brand;
        $company = @$clientArr->company;
      }
      if ($rowData->sample_from == 3) {
        $clientArr = DB::table('clients')
          ->where('id', $rowData->client_id)
          ->first();
        $brand = @$clientArr->brand;
        $company = @$clientArr->company;
      }
      if ($rowData->sample_from == 1) {
        $clientArr = DB::table('clients')
          ->where('id', $rowData->client_id)
          ->first();
        $brand = @$rowData->lead_name;
        $company = @$rowData->lead_company;
      }



      foreach ($sampleDArr as $key => $row) {

        switch ($rowData->sample_type) {
          case 1:
            $strType = " STANDARD COSMETIC";
            break;
          case 2:
            $strType = "OIL";
            break;
          case 3:
            $strType = "GENERAL CHANGES";
            break;
          case 4:
            $strType = "AS PER BENCHMARK";
            break;
          case 5:
            $strType = "MODIFICATIONS";
            break;
        }
        $brandType = optional($rowData)->brand_type;
        switch ($brandType) {
          case 1:
            $brandStr = "New Brand";
            break;
          case 2:
            $brandStr = "Small Brand";
            break;
          case 3:
            $brandStr = "Medium Brand";
            break;
          case 4:
            $brandStr = "Big Brand";
            break;
          case 5:
            $brandStr = "In-House brand";
            break;
        }
        $order_size = optional($rowData)->order_size;
        switch ($order_size) {
          case 1:
            $orderStr = "500-1000 units";
            break;
          case 2:
            $orderStr = "1000-2000 units";
            break;
          case 3:
            $orderStr = "2000-5000 units";
            break;
          case 4:
            $orderStr = "More than 5000 units";
            break;
        }

        switch ($rowData->sample_stage_id) {
          case 1:
            $StageStr = "NEW";
            break;
          case 2:
            $StageStr = "APPROVED";
            break;
          case 3:
            $StageStr = "FORMULATED";
            break;
          case 4:
            $StageStr = "PACKING";
            break;
          case 5:
            $StageStr = "DISPATCH";
            break;
        }


        $data[] = array(
          'sample_code' => $rowData->sample_code,
          'created_at' => $rowData->created_at,
          'brand_name' => $brand,
          'company_name' => $company,
          'created_by' => AyraHelp::getUser($rowData->created_by)->name,
          'status' => $rowData->status == 2 ? "SENT" : "PENDING",
          'sample_type' => $strType,
          'item_name' => $row->txtItem,
          'price_per_kg' => @$row->price_per_kg,
          'info' => $row->txtDiscrption,
          'sid' => $rowData->id,
          'stage' => $StageStr,
          'brand_type' => @$brandStr,
          'order_size' => @$orderStr,


        );
      }
    }
    foreach ($data as $key => $rowData) {
      # code...//

      DB::table('samples_item_data')->insert([
        'sample_code' => $rowData['sample_code'],
        'created_at' => $rowData['created_at'],
        'brand_name' => $rowData['brand_name'],
        'company_name' => $rowData['company_name'],
        'created_by' => $rowData['created_by'],
        'status' => $rowData['status'],
        'sample_type' => $rowData['sample_type'],
        'item_name' => $rowData['item_name'],
        'price_per_kg' => $rowData['price_per_kg'],
        'info' => $rowData['info'],
        'sid' => $rowData['sid'],
        'stage' => $rowData['stage'],
        'brand_type' => @$rowData['brand_type'],
        'order_size' => @$rowData['order_size'],


      ]);
    }
    print_r($data);
    die;
  }

  //v2
  public function index()
  {



    if (date('d') == 1) {  //this update sample and qc serial number 
      //echo date('d');
      $formID = QCFORM::max('form_id');
      $affected = DB::table('qc_forms')
        ->where('form_id', $formID)
        ->update([
          'yr' => date('Y'),
          'mo' => date('m')
        ]);

      $sid = Sample::max('id');

      $affected = DB::table('samples')
        ->where('id', $sid)
        ->update([
          'yr' => date('Y'),
          'mo' => date('m')
        ]);
    }



    // header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    // header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    // header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    // header("Cache-Control: post-check=0, pre-check=0", false);
    // header("Pragma: no-cache");

    // $this->PRPSendSMS('9810585825','OTP-AJA:4545');
    //9305017111 Admin@9711

    // $data = array(
    //   'basic' => '99',
    //   'data' => 454,
    // );
    // $subLine = "subjectline";
    // $sent_to = 'bointldev@gmail.com';

    // Mail::send('aj_mail', $data, function ($message) use ($sent_to,  $subLine) {

    //   $message->to($sent_to, 'Bo')->subject($subLine);
    //   // $message->cc($use_data->email, $use_data->name = null);
    //   // $message->bcc('udita.bointl@gmail.com', 'UDITA');
    //   $message->from('bointldev@gmail.com', 'Bo Intl Operations');
    // });




    // die;

    //AyraHelp::getMinOrderValue(119,12,2020);
    //die;
    //AyraHelp::getNewClient(8,12,2020);
    //die;
    // $msg='Greetings from MAX!';
    // $phone="7703886088";
    // $this->msg91SendSMS($phone,$msg);
    // die;

    //     echo "<pre>";
    // $dataSampleActiArr=AyraHelp::setUniqueLead();
    // print_r($dataSampleActiArr);
    // die;

    // echo "<pre>";
    // $dataSampleActiArr=AyraHelp::getSampleActivityList();
    // print_r($dataSampleActiArr);
    // die;

    // echo "<pre>";
    // $rmdata_Arr = DB::table('rm_data')->get();
    // foreach ($rmdata_Arr as $key => $rowData) {
    //   // print_r($rowData->name);
    //   // print_r($rowData->min_val);
    //   // print_r($rowData->max_val);


    //   DB::table('rnd_finish_products')->insert(
    //     [
    //       'product_name' => $rowData->name,
    //        'chemist_by' => 126,
    //        'sp_min' => $rowData->min_val,
    //        'sp_max' => $rowData->max_val,
    //        'formulation_link' =>'[""]',
    //        'ingredent_link' =>'[""]',


    //     ]
    //   );

    // }
    // die;



    //AyraHelp::setLoadIncentiveDuration();
    //  $smsBal=$this->PRPSendSMS_getBalance();

    //  if($smsBal<=5000 && $smsBal>4980  ){
    //    $this->PRPSendSMS(7703886088,'PRP SMS Low with:Recharge'.$smsBal); //as now Disbaled
    //  }

    if (Auth::user()) {
      if (Auth::user()->id != 1 || Auth::user()->id != 90 || Auth::user()->id != 134 || Auth::user()->id != 141) {
        //AyraHelp::setAssinedCallPickUpLeadToMe(Auth::user()->id, Auth::user()->phone);
      }
    }
    // AyraHelp::setSampleFirstStage();


    //AyraHelp::getLeadStageDistributionBymonth(44);
    //die;
    //$user=array('ajay');

    //event(new WhatIsHappening($user));




    //AyraHelp::getsetAllKnowlartyData();
    //AyraHelp::sendEmail_SMSToLeadIndiaMart();
    //   $msg='Greetings from MAX!
    // You just talked to Sahil Gupta. His direct whatsapp no is +919999910101.
    // His email id is sahilg@max.net
    // If you are not satisfied by the response please email us on info@max.net or whatsapp on +917290011547';
    //


    // AyraHelp::getErrLead();
    //die;

    //echo "<pre>";

    //  die;
    //echo AyraHelp::getPhoneCallDuplicate('P','+919582507838');
    //AyraHelp::getLeadCallDuractionByAgent();
    //die;

    //AyraHelp::LeadCorrection();
    //AyraHelp::LeadCorrection1();
    //AyraHelp::LeadCorrection2(); //as per current lead need to update statge

    //====================
    //AyraHelp::getMyAllClient();
    //AyraHelp::getMyAllClient2();
    //die;

    //    $data_arr_data = DB::table('indmt_data')
    //    ->join('lead_assign', 'indmt_data.QUERY_ID', '=', 'lead_assign.QUERY_ID')
    //    ->where('lead_assign.assign_user_id', '=',76)
    //    ->orderBy('indmt_data.DATE_TIME_RE_SYS','desc')
    //    ->select('indmt_data.*', 'lead_assign.assign_by', 'lead_assign.msg')
    //    ->get();
    // print_r((count($data_arr_data)));
    //    die;

    //$data=AyraHelp::getDuplicateLead();
    //die;
    //$data=AyraHelp::getTodayLeadData();
    //die;

    //AyraHelp::getLeadMissedRun();
    // echo "<pre>";
    // AyraHelp::AssignToRUN();

    // die;

    //nidhibhardwaj791
    //echo "<pre>";
    //echo AyraHelp::getLeadTable();

    //die;


    //  echo  AyraHelp::IsRepeatClientCheck($phone, $email);
    //  die;

    //  AyraHelp::getMACAddress();
    //AyraHelp::getActualClientAsNow();
    //AyraHelp::getFreshLead();
    //die;


    //AyraHelp::runLeadDateUpdate();
    //die;

    //AyraHelp::NewOrderScript();
    //AyraHelp::NewOrderScript2();

    //AyraHelp::NewOrderScript3(); //insert current stage in temp_action table
    //AyraHelp::NewOrderScript4(); //this will save data in st_process_action_temp
    //echo "<pre>";
    //AyraHelp::NewPurchaseScript1(); //this will save data in temp_purchase_curr_statge
    //AyraHelp::NewPurchaseScript2(); //this will save data in temp_purchase_curr_statge
    //AyraHelp::NewPurchaseScript3(); //this will save data in temp_purchase_curr_statge
    //AyraHelp::checkArtWorkStated(); //check and delete from purchaselist
    //die;






    // AyraHelp::getStayFromOrder(1429);

    // die;

    // echo "<pre>";

    //  $data=AyraHelp::OldtoNewPurchaseScript();
    //  print_r($data);
    //  die;

    //  $data=AyraHelp::OldtoNewOrderScript();
    //  print_r($data);
    //  die;

    // $data=AyraHelp::getEMPCODE();
    // print_r($data);
    // die;

    // AyraHelp::UpdateSAPCHKLIST();
    //
    //echo   AyraHelp::getAttenPunch(5);
    //echo   AyraHelp::getAttenPunchEntryTime(5);





    // die;

    //echo "<pre>";
    //   $data=AyraHelp::getTopClient(10);
    //   print_r($data);
    //  die;
    //$currentMonth = date('m');
    // $currentMonth=8;
    // $datas=QCFORM::where('is_deleted',0)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->distinct('client_id')->pluck('client_id');
    // foreach ($datas as $key => $dataRow) {
    //   print_r($dataRow);

    // }


    // $data=AyraHelp::getProcessCurrentStage(1,1052);
    // print_r($data);
    // die;





    //AyraHelp::getUserCompletedStage(1,1);
    // echo  AyraHelp::getPurcahseStockRecivedOrder(6);
    //die;


    //$data_output=AyraHelp::ScriptForStartDefaultNEW();
    //QCFORM::query()->truncate();
    //QCBOM::query()->truncate();
    //QC_BOM_Purchase::query()->truncate();
    //QCPP::query()->truncate();
    //OrderMaster::query()->truncate();
    //OPData::query()->truncate();

    // echo "<pre>";
    // $data=AyraHelp::getfeedbackAlert(40);
    // print_r($data);
    // die;


    //$data_output=AyraHelp::ScriptForPurchaseListReady();

    // AyraHelp::getAttenCalulation(1);



    //ajacode
    $bo_setting = DB::table('bo_settings')->where('atten_upload_flag', 1)->first();

    if ($bo_setting != null) {

      AyraHelp::getAttenDemo(); //this function is user to filter to table: demo_attn
      AyraHelp::setAttenRowBind(); //this function save data to emp_attendance_data
      DB::table('bo_settings')
        ->where('id', 1)
        ->update(['atten_upload_flag' => 0]);
    }



    //ajcode


    $userRoles = [];
    if (Auth::user()) {   // Check is user logged in
      $user = auth()->user();
      $userRoles = $user->getRoleNames();
      $user_role = $userRoles[0];
    } else {
      $user_role = 'GUEST';
    }
    switch ($user_role) {
      case 'Admin':
        return $this->CoreDashboard();
        break;
      case 'Client':
        return $this->ClinetDashboard();
        break;
      case 'Staff':
        return $this->CoreDashboard();
        break;
      case 'SalesUser':
        return $this->CoreDashboard();
        break;
      case 'CourierTrk':
        return $this->CoreDashboard();
        break;
      case 'Sampler':
        return $this->CoreDashboard();
        break;
      case 'User':
        return $this->UserDashboard();
        break;
      case 'SalesHead':
        return $this->CoreDashboard();
        break;
      case 'Intern':
        return $this->InternDashboard();
        break;
        case 'chemist':
          return $this->ChemistDashboard();
          break;
          case 'QAQC':
            return $this->QAQCDashboard();
            break;
            case 'LeadMgmt':
              return $this->LeadMgmtDashboard();
              break;
      default:
        return $this->Front();
        break;
    }
  }
  public function UserDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      "name" => "Ajay",

    ];
    return $theme->scope('dash.index', $data)->render();
  }
  public function InternDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      "name" => "Ajay",

    ];
    return $theme->scope('intern.index', $data)->render();
  }
  public function ChemistDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      "name" => "Ajay",

    ];
    return $theme->scope('chemist.index', $data)->render();
  }

  //QAQCDashboard
  public function QAQCDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      "name" => "Ajay",

    ];
    return $theme->scope('qaqc.index', $data)->render();
  }
  //LeadMgmtDashboard
  public function LeadMgmtDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = [
      "name" => "Ajay",

    ];
    return $theme->scope('leadM.index', $data)->render();
  }



  public function SalesHeadDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel


    //code for order values
    $finances_orderValue = $lava->DataTable();

    $finances_orderValue->addDateColumn('Year')
      ->addNumberColumn('Order Value')
      ->setDateTimeFormat('Y-m-d');
    for ($x = 1; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));


      if ($x >= 4) {
        $active_date = "2022-" . $x . "-1";
      } else {
        $active_date = "2023" . "-" . $x . "-1";
      }
      $data_output = AyraHelp::getOrderValueFilter($x);
      $finances_orderValue->addRow([$active_date, $data_output]);
    }




    $donutchart = \Lava::ColumnChart('FinancesOrderValue', $finances_orderValue, [
      'title' => 'Order Value ...A',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],

    ]);



    //code for order values


    //=================================================
    $finances = $lava->DataTable();
    $finances->addStringColumn('Year')
      ->addNumberColumn('NOTES')
      ->addNumberColumn('FOLLOWUP')
      ->addNumberColumn('Add Client');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountNotedAddedby($s_userid, 30);
        $followups = AyraHelp::getCountFollowupAddedby($s_userid, 30);
        $client_added = AyraHelp::getCountClientupAddedby($s_userid, 30);

        $finances->addRow([strtoupper($sname[0]), $notes, $followups, $client_added]);
      }
    }
    $donutchart = \Lava::ColumnChart('Finances', $finances, [
      'title' => 'Last 30 Days Notes ,Follow Up & Added Client ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],

    ]);

    //===================================================
    //=================================================
    $samples = $lava->DataTable();
    $samples->addStringColumn('Year')
      ->addNumberColumn('SAMPLES SENT')
      ->addNumberColumn('FEEDBACK ');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountSampleAddedby($s_userid, 30);
        $followups = AyraHelp::getCountSampleFeedbackAddedby($s_userid, 30);
        $samples->addRow([strtoupper($sname[0]), $notes, $followups]);
      }
    }
    $donutchart = \Lava::ColumnChart('SampleFeeback', $samples, [
      'title' => 'Last 30 Days Sample Sent and Feedback ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'colors' => ['#164252', '#008080'],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
    ]);

    //===================================================

    //----------------------------
    $reasons = $lava->DataTable();
    $feed_arr = AyraHelp::getSampleFeedbackCount(8, 30);
    $reasons->addStringColumn('Reasons')
      ->addNumberColumn('Percent')
      ->addRow(['Changes suggest resend samples', $feed_arr['option_1']])
      ->addRow(['Did not like', $feed_arr['option_2']])
      ->addRow(['Stopped Responding', $feed_arr['option_3']])
      ->addRow(['Sample Selected', $feed_arr['option_4']]);

    $donutpiechart = \Lava::PieChart('IMDB', $reasons, [
      'title' => 'Last 30 Days Feeback Piechart : Deepak',
      'is3D'   => true,
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'slices' => [
        ['offset' => 0.2],
        ['offset' => 0.25],
        ['offset' => 0.3]
      ]
    ]);
    //-----------------------------


    $today_node = ClientNote::whereDate('created_at', Carbon::today())->get();


    $data = [
      "name" => "Ajay",
      "today_node" => $today_node,
    ];
    //return $theme->scope('dash.index', $data)->render();
    return $theme->scope('salesHead.index', $data)->render();
  }


  public function CoreDashboard()
  {
    $theme = Theme::uses('corex')->layout('layout');
    $lava = new Lavacharts; // See note below for Laravel


    //code for order values
    $finances_orderValue = $lava->DataTable();

    $finances_orderValue->addDateColumn('Year')
      ->addNumberColumn('Order Value')
      ->setDateTimeFormat('Y-m-d');
    for ($x = 1; $x <= 12; $x++) {
      $d = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));


      if ($x >= date('m') + 1) {
        $active_date = "2022-" . $x . "-1";
      } else {
        $active_date = "2023" . "-" . $x . "-1";
      }
      $data_output = AyraHelp::getOrderValueFilter($x);
      // $data_output = 2542;
      $finances_orderValue->addRow([$active_date, $data_output]);
    }




    $donutchart = \Lava::ColumnChart('FinancesOrderValue', $finances_orderValue, [
      'title' => 'Order Value ..B ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],

    ]);



    //code for order values


    //=================================================
    $finances = $lava->DataTable();
    $finances->addStringColumn('Year')
      ->addNumberColumn('NOTES')
      ->addNumberColumn('FOLLOWUP')
      ->addNumberColumn('Add Client');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountNotedAddedby($s_userid, 30);
        $followups = AyraHelp::getCountFollowupAddedby($s_userid, 30);
        $client_added = AyraHelp::getCountClientupAddedby($s_userid, 30);

        $finances->addRow([strtoupper($sname[0]), $notes, $followups, $client_added]);
      }
    }
    $donutchart = \Lava::ColumnChart('Finances', $finances, [
      'title' => 'Last 30 Days Notes ,Follow Up & Added Client ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],

    ]);

    //===================================================
    //=================================================
    $samples = $lava->DataTable();
    $samples->addStringColumn('Year')
      ->addNumberColumn('SAMPLES SENT')
      ->addNumberColumn('FEEDBACK ');
    $sales_arr = AyraHelp::getSalesAgentOnly();
    foreach ($sales_arr as $key => $value) {
      $s_userid = $value->id;
      if ($s_userid == '88') {
      } else {
        $sname = explode(" ", $value->name);
        $notes = AyraHelp::getCountSampleAddedby($s_userid, 30);
        $followups = AyraHelp::getCountSampleFeedbackAddedby($s_userid, 30);
        $samples->addRow([strtoupper($sname[0]), $notes, $followups]);
      }
    }
    $donutchart = \Lava::ColumnChart('SampleFeeback', $samples, [
      'title' => 'Last 30 Days Sample Sent and Feedback ',
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'colors' => ['#164252', '#008080'],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
    ]);

    //===================================================

    //----------------------------
    $reasons = $lava->DataTable();
    $feed_arr = AyraHelp::getSampleFeedbackCount(8, 30);
    $reasons->addStringColumn('Reasons')
      ->addNumberColumn('Percent')
      ->addRow(['Changes suggest resend samples', $feed_arr['option_1']])
      ->addRow(['Did not like', $feed_arr['option_2']])
      ->addRow(['Stopped Responding', $feed_arr['option_3']])
      ->addRow(['Sample Selected', $feed_arr['option_4']]);

    $donutpiechart = \Lava::PieChart('IMDB', $reasons, [
      'title' => 'Last 30 Days Feeback Piechart : Deepak',
      'is3D'   => true,
      'titleTextStyle' => [
        'color'    => '#035496',
        'fontSize' => 14
      ],
      'legend' => [
        'position'    => 'top',
        'maxLines' => 3

      ],
      'slices' => [
        ['offset' => 0.2],
        ['offset' => 0.25],
        ['offset' => 0.3]
      ]
    ]);
    //-----------------------------


    $today_node = ClientNote::whereDate('created_at', Carbon::today())->get();


    $data = [
      "name" => "Ajay",
      "today_node" => $today_node,
    ];
    return $theme->scope('dash.index', $data)->render();
  }


  public function ClinetDashboard()
  {
    echo "under process";
  }
  //v2
  public function ImportExport(Request $request)
  {
    $theme = Theme::uses('corex')->layout('layout');
    $data = ['info' => 'This is user information'];
    return $theme->scope('dash.import_export', $data)->render();
  }

  public function UploadDropzone(Request $request)
  {
    print_r($request->all());
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function mypdf()
  {

    AyraHelp::UpdateSAPCHKLIST();

    //  $theme = Theme::uses('admin')->layout('layout');
    //  $data=["name"=>"Ajay"];
    //  PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    //  $pdf = PDF::loadView('pdf.sample', $data);
    //  return $pdf->download('invoice.pdf');
  }

  public function AdminDashboard()
  {
    $theme = Theme::uses('admin')->layout('layout');
    $data = ['info' => 'Hello World'];
    return $theme->scope('home.index', $data)->render();
  }
  public function StaffDashboard()
  {

    $theme = Theme::uses('staff')->layout('layout');
    $data = ['info' => 'This is user information'];
    return $theme->scope('home.index', $data)->render();
  }
  public function SalesUserDashboard()
  {

    $theme = Theme::uses('salesagent')->layout('layout');
    $data = ['info' => 'This is user information'];
    return $theme->scope('home.index', $data)->render();
  }
  public function Front()
  {
    $theme = Theme::uses('default')->layout('layout');
    $data = ['info' => 'Hello World'];
    return $theme->scope('index', $data)->render();
  }
  //  anoops@max.net
  //sahilg@max.net


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
