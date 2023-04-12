<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/getSampleList/{userid}','SampleController@getSampleList')->name('getSampleList');
Route::post('/getSamplesList','SampleController@getSamplesList')->name('getSamplesList');








Route::post('/getClientList/{userid}','SampleController@getClientList')->name('getClientList');
Route::post('/getClientsList','SampleController@getClientsList')->name('getClientsList');
Route::post('/getROWClientsList','SampleController@getROWClientsList')->name('getROWClientsList');

Route::get('/getCity','UserController@getCity')->name('getCity'); //v2
Route::get('/getCountry/{id}','UserController@getCountry')->name('getCountry'); //v2



Route::get('/getClientAddress','SampleController@getClientAddress')->name('getClientAddress');
Route::get('/getClientBrandName','SampleController@getClientBrandName')->name('getClientBrandName');

Route::get('/getDispachStageOrderListData','SampleController@getDispachStageOrderListData')->name('getDispachStageOrderListData');



//Route::get('/getClientBrandName','SampleController@getClientBrandName')->name('getClientBrandName');
Route::get('/setSinceFromApiV1','HomeController@setSinceFromApiV1')->name('setSinceFromApiV1');




Route::post('/getSampleDetails','SampleController@getSampleDetails')->name('getSampleDetails');
Route::post('/saveSampleCourier','SampleController@saveSampleCourier')->name('saveSampleCourier');
//Route::get('/delete_sample/{userid}','SampleController@delete_sample')->name('delete_sample');
Route::post('/getClientDetails','SampleController@getClientDetails')->name('getClientDetails');
Route::post('/getClientsListforDelete','SampleController@getClientsListforDelete')->name('getClientsListforDelete');
Route::get('/getPrintSampleList','SampleController@getPrintSampleList')->name('getPrintSampleList');
Route::get('/getPrintSampleList/{userid}','SampleController@getPrintSampleListOwn')->name('getPrintSampleListOwn');
Route::post('/getRawClientData','RawClientDataController@getRawClientData')->name('getRawClientData');
Route::get('/getSampleGraphList','SampleController@getSampleGraphList')->name('getSampleGraphList');
Route::get('/getMissedFollowupList','ClientController@getMissedFollowupList')->name('getMissedFollowupList');

Route::get('/getClientsListApi','ClientController@getClientsListApi')->name('getClientsListApi');

Route::get('/getUserList','Auth\RegisterController@getUserList')->name('getUserList');
Route::get('/getUserListLive','Auth\RegisterController@getUserListLive')->name('getUserListLive');

Route::post('/setUserActive','Auth\RegisterController@setUserActive')->name('setUserActive');
Route::get('/setOrderStagesApi','Auth\RegisterController@setOrderStagesApi')->name('setOrderStagesApi');
Route::get('/setOrderStagesApiV1','Auth\RegisterController@setOrderStagesApiV1')->name('setOrderStagesApiV1');
Route::get('/getOrderStagesDelayAPIV1','Auth\RegisterController@getOrderStagesDelayAPIV1')->name('getOrderStagesDelayAPIV1');

Route::get('/getIndiaMartData','Auth\RegisterController@getGMARTData')->name('getGMARTData');
Route::get('/getIndiaMartData_2','Auth\RegisterController@getGMARTData_2')->name('getGMARTData_2');
Route::get('/getIndiaMartData_3','Auth\RegisterController@getGMARTData_3')->name('getGMARTData_3');
Route::get('/getIndiaMartData_4','Auth\RegisterController@getGMARTData_4')->name('getGMARTData_4'); //packageing api

Route::get('/getIndiaMartData_5','Auth\RegisterController@getGMARTData_5')->name('getGMARTData_5'); //life science api
Route::get('/getIndiaMartData_6','Auth\RegisterController@getIndiaMartData_6')->name('getIndiaMartData_6'); //Bo .net




Route::get('/setAjaxRunCronjonLead', 'Auth\RegisterController@setAjaxRunCronjonLead')->name('setAjaxRunCronjonLead');
Route::get('/setAjaxRunCronjonLeadGraph', 'Auth\RegisterController@setAjaxRunCronjonLeadGraph')->name('setAjaxRunCronjonLeadGraph');
Route::get('/getOrderCosting', 'HomeController@getOrderCosting')->name('getOrderCosting');
Route::get('/getOrderCosting_V1', 'HomeController@getOrderCosting_V1')->name('getOrderCosting_V1');//pooja
Route::get('/getNewLeadOrderfromSource', 'HomeController@getNewLeadOrderfromSource')->name('getNewLeadOrderfromSource');//pooja




Route::get('/setAjaxRunCronjonLeadCOUNT', 'Auth\RegisterController@setAjaxRunCronjonLeadCOUNT')->name('setAjaxRunCronjonLeadCOUNT');
Route::get('/sendSMS2Lead', 'HomeController@sendSMS2Lead')->name('sendSMS2Lead');
Route::get('/sendEmail2Lead', 'HomeController@sendEmail2Lead')->name('sendEmail2Lead');

Route::get('/sendEmail_forSampleNotification', 'HomeController@sendEmail_forSampleNotification')->name('sendEmail_forSampleNotification');
Route::get('/sendEmail_forSampleNotification_oils', 'HomeController@sendEmail_forSampleNotification_oils')->name('sendEmail_forSampleNotification_oils');
Route::get('/sendEmail_forSampleNotification_ExceptOils', 'HomeController@sendEmail_forSampleNotification_ExceptOils')->name('sendEmail_forSampleNotification_ExceptOils');


Route::get('/sendEmail_forOrderNotification', 'HomeController@sendEmail_forOrderNotification')->name('sendEmail_forOrderNotification');
Route::get('/sendEmail_SalesReportFirsttoYet', 'HomeController@sendEmail_SalesReportFirsttoYet')->name('sendEmail_SalesReportFirsttoYet');
Route::get('/getLeadIncentiveData', 'HomeController@getLeadIncentiveData')->name('getLeadIncentiveData');

Route::post('/getSMSDeliveryReport', 'HomeController@getSMSDeliveryReport')->name('getSMSDeliveryReport');



Route::get('/online2Offline', 'Auth\RegisterController@online2Offline')->name('online2Offline');
Route::get('/online2Offlineclient', 'Auth\RegisterController@online2Offlineclient')->name('online2Offlineclient');

Route::get('/sendEmailSMS2Lead_PACKING', 'HomeController@sendEmailSMS2Lead_PACKING')->name('sendEmailSMS2Lead_PACKING');
// Route::get('/setSampleAutoAssingmenetProcess_1', 'HomeController@setSampleAutoAssingmenetProcess_1')->name('setSampleAutoAssingmenetProcess_1');
// Route::get('/setSampleAutoAssingmenetProcess_3', 'HomeController@setSampleAutoAssingmenetProcess_3')->name('setSampleAutoAssingmenetProcess_3');
// Route::get('/setSampleAutoAssingmenetProcess_4', 'HomeController@setSampleAutoAssingmenetProcess_4')->name('setSampleAutoAssingmenetProcess_4');
// Route::get('/setSampleAutoAssingmenetProcess_5', 'HomeController@setSampleAutoAssingmenetProcess_5')->name('setSampleAutoAssingmenetProcess_5');
Route::get('/setSampleAutoAssingmenetProcess_All', 'HomeController@setSampleAutoAssingmenetProcess_All')->name('setSampleAutoAssingmenetProcess_All');

Route::get('/tempRndIngedent', 'HomeController@tempRndIngedent')->name('tempRndIngedent');
Route::get('/samplebypart', 'HomeController@samplebypart')->name('samplebypart');
Route::get('/standardSampleList', 'HomeController@standardSampleList')->name('standardSampleList');
Route::get('/sampleSendDemo', 'HomeController@sampleSendDemo')->name('sampleSendDemo');
Route::get('/sampletoIngrednentApproval', 'HomeController@sampletoIngrednentApproval')->name('sampletoIngrednentApproval');
Route::get('/setLeadIncentive', 'HomeController@setLeadIncentive')->name('setLeadIncentive');
Route::get('/getSalesOrderPaymentData', 'HomeController@getSalesOrderPaymentData')->name('getSalesOrderPaymentData');
Route::get('/getDailyTeamwiseReport', 'HomeController@getDailyTeamwiseReport')->name('getDailyTeamwiseReport');
Route::get('/getClientOrderPaymentMonthWise', 'HomeController@getClientOrderPaymentMonthWise')->name('getClientOrderPaymentMonthWise');
Route::get('/getSalesPersonAllOrder', 'HomeController@getSalesPersonAllOrder')->name('getSalesPersonAllOrder');
Route::get('/online_to_offline_DataMerge', 'HomeController@online_to_offline_DataMerge')->name('online_to_offline_DataMerge');
Route::get('/client_id_name', 'HomeController@client_id_name')->name('client_id_name');
Route::get('/getClientProductbyDuration', 'HomeController@getClientProductbyDuration')->name('getClientProductbyDuration');
Route::get('/getUserTest', 'HomeController@getUserTest')->name('getUserTest');
Route::get('/getSamplesListWithItems', 'HomeController@getSamplesListWithItems')->name('getSamplesListWithItems');
Route::get('/getLeadDataMTD', 'HomeController@getLeadDataMTD')->name('getLeadDataMTD'); // this api is used to send lead data 
Route::get('/removeOrdersByOrderID', 'HomeController@removeOrdersByOrderID')->name('removeOrdersByOrderID'); // this api is used to send lead data 
Route::get('/chemistIncentiveProcess', 'HomeController@chemistIncentiveProcess')->name('chemistIncentiveProcess'); // this api is used to send lead data 
Route::get('/getCustomProductData', 'HomeController@getCustomProductData')->name('getCustomProductData'); // this api is used to send lead data 
Route::get('/getActualClientData', 'HomeController@getActualClientData')->name('getActualClientData'); // this api is used to send lead data 
Route::get('/daily_previous_day', 'HomeController@daily_previous_day')->name('daily_previous_day'); // this api is used to send lead data 



Route::get('/einvoiceSave', 'HomeController@einvoiceSave')->name('einvoiceSave'); // this api is used to send lead data 
Route::get('/sendMailtoClient', 'HomeController@sendMailtoClient')->name('sendMailtoClient'); // this api is used to send lead data 
Route::get('/updateRNDChemistNameToQC', 'HomeController@updateRNDChemistNameToQC')->name('updateRNDChemistNameToQC'); // this api is used update chemist name in order
Route::get('/getRMData/{id}', 'HomeController@getRMData')->name('getRMData'); // this api is used update chemist name in order
Route::get('/updateClientData', 'HomeController@updateClientData')->name('updateClientData'); // this api is used update chemist name in order
Route::post('/getOrderDataParam', 'HomeController@getOrderDataParam')->name('getOrderDataParam'); // this api is used update chemist name in order
Route::post('/updateQCBalanceQTY', 'HomeController@updateQCBalanceQTY')->name('updateQCBalanceQTY'); // this api is used to update QTY of balance




































//https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/9999955922/GLUSR_MOBILE_KEY/MTU3ODA1ODQ2Ny43NzY0IzQzODcwNjE2/Start_Time/03-JAN-2020%2019:00:00/End_Time/04-JAN-2020%2010:00:00/
