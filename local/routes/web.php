<?php
Route::get('/clearme', function () {


    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    //https://www.google.com/recaptcha/admin/site/443615765/setup
    // sudo rm -r ./storage/framework/cache
   

    //sudo shutdown -h +3
    //whereDate('created_at', '>=',$from)->whereDate('created_at', '<=',$to)->whereYear('created_at', date('Y'))->get();

    return view('welcome');
});
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/mypdf', 'HomeController@mypdf')->name('mypdf');
Route::get('/my-sample-list', 'HomeController@downloadEmail_forSampleNotification')->name('downloadEmail_forSampleNotifications');
Route::post('/invoiceFileUploadA', 'HomeController@invoiceFileUpload')->name('invoiceFileUploadA'); //v2

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
Route::resource('posts', 'PostController');
Route::resource('stocks', 'StockController');
Route::resource('purchase', 'PurchaseController');
Route::resource('vendors', 'VendorController');
Route::resource('operationsHealth', 'OperationHealthController');


// v1 : LeadManagement

Route::get('/client-v1-list', 'ClientController@clientv1')->name('clientv1'); //v2
Route::get('/leads-list', 'ClientController@clientLeadV3')->name('clientLeadV3'); //v2
Route::post('saveSalesLeadSample', 'SampleController@saveSalesLeadSample')->name('saveSalesLeadSample'); //v2
Route::post('saveSalesLeadSampleV2', 'SampleController@saveSalesLeadSampleV2')->name('saveSalesLeadSampleV2'); //v2

Route::post('updateChemistLayout', 'SampleController@updateChemistLayout')->name('updateChemistLayout'); //v2



Route::get('/new-order/{cid}', 'OrderController@qcformLead')->name('qcformLead');

Route::get('stage_sales-leadv1/{leadid}/{leadTye}/{userid}', 'SampleController@add_salesLead_sampleV1')->name('add_salesLead_sampleV1s'); //v2
Route::get('stage_sales-leadv1Modify/{leadid}/{leadTye}/{userid}', 'SampleController@add_salesLead_sampleV1Modify')->name('add_salesLead_sampleV1Modify'); //v2


Route::get('stage_sales-leadv2/{leadid}/{leadTye}/{userid}', 'SampleController@add_salesLead_sampleV2')->name('add_salesLead_sampleV2'); //v2
Route::get('stage_sales-leadv2Modify/{sample_item_id}', 'SampleController@add_salesLead_sampleV2Modify')->name('add_salesLead_sampleV2Modify'); //v2


Route::post('/lead-qc-from', 'OrderController@saveLeadQCdata')->name('saveLeadQCdata');
Route::get('/lead-sales-invoce-request/{cid}', 'OrderController@leadSalesInvoiceRequst')->name('leadSalesInvoiceRequst');


Route::get('/ajtrans', 'ClientController@ajtrans')->name('ajtrans'); //v2

Route::get('/payments-recieved-list', 'ClientController@paymentRecievedLIST')->name('paymentRecievedLIST'); //v2
Route::get('/payments-recieved-list-sample', 'ClientController@paymentRecievedLIST_SAMPLE')->name('paymentRecievedLIST_SAMPLE'); //v2


Route::get('/order-approval-list', 'ClientController@orderApprovalList')->name('orderApprovalList'); //v2


Route::post('/getOrderApprovalListData', 'OrderController@getOrderApprovalListData')->name('getOrderApprovalListData'); //v2

Route::get('/get-pack-lead', 'UserController@getPackingLead')->name('getPackingLead'); //v2


Route::get('/setlastActiveUser', 'UserController@setlastActiveUser')->name('setlastActiveUser'); //v2
Route::post('/getAllSalseMemberLeadTrackDays', 'UserController@getAllSalseMemberLeadTrackDays')->name('getAllSalseMemberLeadTrackDays'); //v2

Route::post('/saveOtherSampleName', 'UserController@saveOtherSampleName')->name('saveOtherSampleName'); //v2
Route::post('/deleteUserSoft', 'UserController@deleteUserSoft')->name('deleteUserSoft'); //v2
Route::post('/ActivatUserMAC', 'UserController@ActivatUserMAC')->name('ActivatUserMAC'); //v2


Route::get('/getOrderChemistIncentive', 'UserController@getOrderChemistIncentive')->name('getOrderChemistIncentive'); //v2








Route::get('/clientv1/{clietid}', 'ClientController@viewClientv1')->name('viewClientv1'); //v2


Route::get('/Client-v1-leads', 'ClientController@clientv1Leads')->name('clientv1Leads'); //v2
Route::get('/support-ticket', 'UserController@supportTicket')->name('supportTicket'); //v2

Route::post('/getLeadListViewAll', 'UserController@getLeadListViewAll')->name('getLeadListViewAll'); //v2
Route::post('/getAvaibleLeadListViewAll', 'UserController@getAvaibleLeadListViewAll')->name('getAvaibleLeadListViewAll'); //v2


Route::get('/getAvaibleTicketListViewAll', 'UserController@getAvaibleTicketListViewAll')->name('getAvaibleTicketListViewAll'); //v2


Route::post('/getAvaibleLeadListViewAllAdmin', 'UserController@getAvaibleLeadListViewAllAdmin')->name('getAvaibleLeadListViewAllAdmin'); //v2


Route::post('/getLeadNotesData', 'ClientController@getLeadNotesData')->name('getLeadNotesData'); //v2
Route::post('/getLeadDataBYID', 'UserController@getLeadDataBYID')->name('getLeadDataBYID'); //v2
Route::post('/clicktoCallAPI', 'UserController@clicktoCallAPI')->name('clicktoCallAPI'); //v2



Route::post('/saveNewLead', 'ClientController@saveNewLead')->name('saveNewLead'); //v2



Route::post('/setPaymentRecCommnet', 'ClientController@setPaymentRecCommnet')->name('setPaymentRecCommnet'); //v2
Route::post('/setPaymentRecCommnetSample', 'ClientController@setPaymentRecCommnetSample')->name('setPaymentRecCommnetSample'); //v2



Route::post('/setOrderEditResponse', 'ClientController@setOrderEditResponse')->name('setOrderEditResponse'); //v2
Route::post('/setOncreditResponse', 'ClientController@setOncreditResponse')->name('setOncreditResponse'); //v2





Route::post('/setPaymentRecOrder', 'ClientController@setPaymentRecOrder')->name('setPaymentRecOrder'); //v2
Route::post('/clientTransfer', 'ClientController@clientTransfer')->name('clientTransfer'); //v2
Route::post('/clientTransferWithSMSEMAIL', 'ClientController@clientTransferWithSMSEMAIL')->name('clientTransferWithSMSEMAIL'); //v2





// Route::get('get-leads', 'UserController@getLeadsAcceessList')->name('getLeadsAcceessList');//v2





// v1 : LeadMangement

//v2
Route::resource('client', 'ClientController');
Route::resource('orders', 'OrderController');
Route::post('/getClientsList', 'ClientController@getClientsList')->name('getClientsList'); //v2
Route::get('/getLeadListV3', 'ClientController@getLeadListV3')->name('getLeadListV3'); //v2
Route::get('/getLeadListV3_AdminView', 'ClientController@getLeadListV3_AdminView')->name('getLeadListV3_AdminView'); //v2
Route::get('/view-all-lead-details/{lid}', 'ClientController@viewAllLeadDetails')->name('viewAllLeadDetails'); //v2






Route::get('getSaleLeadStages', 'OrderController@getSaleLeadStages')->name('getSaleLeadStages');
Route::post('/setSaveProcessActionSalesLead', 'OrderController@setSaveProcessActionSalesLead')->name('setSaveProcessActionSalesLead');
Route::get('/edit-lead/{cid}', 'ClientController@qcformLeadEDIT')->name('qcformLeadEDIT');
Route::post('/editNewLeadSales', 'ClientController@editNewLeadSales')->name('editNewLeadSales'); //v2

Route::post('/getClientsListSalesLeadV1', 'ClientController@getClientsListSalesLeadV1')->name('getClientsListSalesLeadV1'); //v2



Route::post('/getClientsListTeam', 'ClientController@getClientsListTeam')->name('getClientsListTeam'); //v2



Route::post('/getClientsListOrderHave', 'ClientController@getClientsListOrderHave')->name('getClientsListOrderHave'); //v2



Route::post('/getLeadList', 'UserController@getLeadList')->name('getLeadList'); //v2
Route::post('/getLeadList_v3Assined', 'UserController@getLeadList_v3Assined')->name('getLeadList_v3Assined'); //v2
Route::post('/getLeadList_v3Irrelevant', 'UserController@getLeadList_v3Irrelevant')->name('getLeadList_v3Irrelevant'); //v2
Route::post('/getLeadList_v3disQualified', 'UserController@getLeadList_v3disQualified')->name('getLeadList_v3disQualified'); //v2
Route::post('/getLeadList_v3Hold', 'UserController@getLeadList_v3Hold')->name('getLeadList_v3Hold'); //v2
Route::post('/getLeadList_v3Hold_Intern', 'UserController@getLeadList_v3Hold_Intern')->name('getLeadList_v3Hold_Intern'); //v2

Route::post('/getLeadList_v3Duplicate', 'UserController@getLeadList_v3Duplicate')->name('getLeadList_v3Duplicate'); //v2













Route::post('/getLeadList_ADMIN_VIEW_W', 'UserController@getLeadList_ADMIN_VIEW_W')->name('getLeadList_ADMIN_VIEW_W'); //v2
Route::post('/getLeadList_LeadManger_VIEW_WPB', 'UserController@getLeadList_LeadManger_VIEW_WPB')->name('getLeadList_LeadManger_VIEW_WPB'); //v2
Route::post('/getLeadList_LeadManger_VIEW_WPB_Intern', 'UserController@getLeadList_LeadManger_VIEW_WPB_Intern')->name('getLeadList_LeadManger_VIEW_WPB_Intern'); //v2



Route::post('/getLeadList_LeadManger_VIEW_WPB_claimAssined', 'UserController@getLeadList_LeadManger_VIEW_WPB_claimAssined')->name('getLeadList_LeadManger_VIEW_WPB_claimAssined'); //v2

Route::post('/getLeadList_LeadManger_VIEW_Export', 'UserController@getLeadList_LeadManger_VIEW_Export')->name('getLeadList_LeadManger_VIEW_Export'); //v2






Route::post('/getLeadList_PACK', 'UserController@getLeadList_PACK')->name('getLeadList_PACK'); //v2

Route::post('/getLeadList_LMLayout', 'UserController@getLeadList_LMLayout')->name('getLeadList_LMLayout'); //v2
Route::post('/getLeadList_LMLayout_LMDirectView', 'UserController@getLeadList_LMLayout_LMDirectView')->name('getLeadList_LMLayout_LMDirectView'); //v2
Route::post('/getSamplesCountList', 'UserController@getSamplesCountList')->name('getSamplesCountList'); //v2



Route::post('/getLeadList_LMLayout_LMPhoneview', 'UserController@getLeadList_LMLayout_LMPhoneview')->name('getLeadList_LMLayout_LMPhoneview'); //v2
Route::post('/getLeadList_LMLayout_LMBuyview', 'UserController@getLeadList_LMLayout_LMBuyview')->name('getLeadList_LMLayout_LMBuyview'); //v2
Route::post('/getLeadList_LMLayout_LMInhouseview', 'UserController@getLeadList_LMLayout_LMInhouseview')->name('getLeadList_LMLayout_LMInhouseview'); //v2
Route::post('/getLeadList_LMLayout_LMForeignview', 'UserController@getLeadList_LMLayout_LMForeignview')->name('getLeadList_LMLayout_LMForeignview'); //v2

Route::post('/getLeadList_LMLayout_LM_verifiedLead', 'UserController@getLeadList_LMLayout_LM_verifiedLead')->name('getLeadList_LMLayout_LM_verifiedLead'); //v2
Route::post('/getLeadList_LMLayout_LM_claim_assined', 'UserController@getLeadList_LMLayout_LM_claim_assined')->name('getLeadList_LMLayout_LM_claim_assined'); //v2


Route::post('/getLeadList_LMLayout_LM_viewALLLead', 'UserController@getLeadList_LMLayout_LM_viewALLLead')->name('getLeadList_LMLayout_LM_viewALLLead'); //v2
Route::post('/getLeadList_LMLayout_LM_viewALLLead_NONEFRESH', 'UserController@getLeadList_LMLayout_LM_viewALLLead_NONEFRESH')->name('getLeadList_LMLayout_LM_viewALLLead_NONEFRESH'); //v2


















Route::post('/getLeadList_SALES_END', 'UserController@getLeadList_SALES_END')->name('getLeadList_SALES_END'); //v2




Route::post('/getLeadListSalesOwn', 'UserController@getLeadListSalesOwn')->name('getLeadListSalesOwn'); //v2



Route::get('/getLeadReports', 'UserController@getLeadReports')->name('getLeadReports'); //v2


Route::get('/login-activity', 'UserController@loginActivity')->name('loginActivity'); //v2
Route::get('/login-activity/{id}', 'UserController@viewLoginActivityData')->name('viewLoginActivityData'); //v2
Route::get('/get-sop-list', 'UserController@getSOPList')->name('getSOPList'); //v2


Route::get('/lead-management', 'UserController@LeadManagementView')->name('LeadManagementView'); //v2
Route::post('/getLoginActivityUser', 'UserController@getLoginActivityUser')->name('getLoginActivityUser'); //v2
Route::get('/getSOPActivityUser', 'UserController@getSOPActivityUser')->name('getSOPActivityUser'); //v2
Route::post('/getLoginActivityDetails', 'UserController@getLoginActivityDetails')->name('getLoginActivityDetails'); //v2
Route::post('/getClick2CallDataFromAPI', 'UserController@getClick2CallDataFromAPI')->name('getClick2CallDataFromAPI'); //v2







Route::get('/getLeadStagesGraph', 'UserController@getLeadStagesGrapgh')->name('getLeadStagesGrapgh'); //v2
Route::get('/getLeadAssinDateWiseData', 'UserController@getLeadAssinDateWiseData')->name('getLeadAssinDateWiseData'); //v2
Route::post('/getPaymentOrdersListWithFilter', 'HomeController@getPaymentOrdersListWithFilter')->name('getPaymentOrdersListWithFilter'); //v2
Route::post('/getPaymentOrdersListWithFilterOrder', 'HomeController@getPaymentOrdersListWithFilterOrder')->name('getPaymentOrdersListWithFilterOrder'); //v2
Route::post('/getPaymentOrdersListWithFilterSample', 'HomeController@getPaymentOrdersListWithFilterSample')->name('getPaymentOrdersListWithFilterSample'); //v2
Route::post('/getPaymentOrdersListWithFilterLead', 'HomeController@getPaymentOrdersListWithFilterLead')->name('getPaymentOrdersListWithFilterLead'); //v2



Route::get('/assigned-list-datewise', 'UserController@getDatewiseLeadAssign')->name('getDatewiseLeadAssign'); //v2
Route::get('/claim-lead-graph', 'UserController@getclaimleadGraph')->name('getclaimleadGraph'); //v2


Route::get('/inbound-call-report', 'UserController@getLeadInboutCallGrapgh')->name('getLeadInboutCallGrapgh'); //v2
Route::get('/combined-lead-transfer', 'UserController@combinedLeadTransfer')->name('combinedLeadTransfer'); //v2
Route::get('/getAllSalesuserClientAppend', 'UserController@getAllSalesuserClientAppend')->name('getAllSalesuserClientAppend'); //v2
Route::post('/setClientTransferSave', 'UserController@setClientTransferSave')->name('setClientTransferSave'); //v2







Route::get('/lead-distribution', 'UserController@getLeadReports_Dist')->name('getLeadReports_Dist'); //v2







Route::post('/getClientsListTodayFUP', 'ClientController@getClientsListTodayFUP')->name('getClientsListTodayFUP'); //v2
Route::post('/getClientsListYestardayFUP', 'ClientController@getClientsListYestardayFUP')->name('getClientsListYestardayFUP'); //v2
Route::post('/getClientsListDelayFUP', 'ClientController@getClientsListDelayFUP')->name('getClientsListDelayFUP'); //v2


Route::post('/getClientsNotesList', 'ClientController@getClientsNotesList')->name('getClientsNotesList'); //v2
Route::get('/getSamplesList', 'SampleController@getSamplesList')->name('getSamplesList'); //v2
Route::get('/getSamplesListFomulation', 'SampleController@getSamplesListFomulation')->name('getSamplesListFomulation'); //v2
Route::get('/getSamplesListFomulationSales', 'SampleController@getSamplesListFomulationSales')->name('getSamplesListFomulationSales'); //v2
Route::post('/saveSampleDispatchBulk', 'SampleController@saveSampleDispatchBulk')->name('saveSampleDispatchBulk'); //v2



Route::get('/getSamplesListHigh', 'SampleController@getSamplesListHigh')->name('getSamplesListHigh'); //v2

Route::post('/getProductFAQ', 'SampleController@getProductFAQ')->name('getProductFAQ'); //v2

Route::post('/getSampleFeedbackData', 'SampleController@getSampleFeedbackData')->name('getSampleFeedbackData'); //v2
Route::post('/getSampleItemDetailPayment', 'SampleController@getSampleItemDetailPayment')->name('getSampleItemDetailPayment'); //v2
Route::post('/savePaymentAmountSample', 'SampleController@savePaymentAmountSample')->name('savePaymentAmountSample'); //v2









Route::post('/getSampleItemsDataTech', 'SampleController@getSampleItemsDataTech')->name('getSampleItemsDataTech'); //v2
Route::post('/getOrderItemsDataTech', 'SampleController@getOrderItemsDataTech')->name('getOrderItemsDataTech'); //v2
Route::post('/saveSampleTechDoc', 'SampleController@saveSampleTechDoc')->name('saveSampleTechDoc'); //v2
Route::post('/saveOrderTechDoc', 'SampleController@saveOrderTechDoc')->name('saveOrderTechDoc'); //v2


Route::post('/saveSamplePriority', 'SampleController@saveSamplePriority')->name('saveSamplePriority'); //v2



Route::post('/getSamplesListTechnicaldata', 'SampleController@getSamplesListTechnicaldata')->name('getSamplesListTechnicaldata'); //v2
Route::post('/getordersListTechnicaldata', 'SampleController@getordersListTechnicaldata')->name('getordersListTechnicaldata'); //v2

Route::post('/saveSampleTechDocFeedback', 'SampleController@saveSampleTechDocFeedback')->name('saveSampleTechDocFeedback'); //v2
Route::post('/saveSampleTechDocFeedback_DOC', 'SampleController@saveSampleTechDocFeedback_DOC')->name('saveSampleTechDocFeedback_DOC'); //v2
Route::post('/saveOrderTechDocFeedback_DOC', 'SampleController@saveOrderTechDocFeedback_DOC')->name('saveOrderTechDocFeedback_DOC'); //v2

Route::post('/saveSampleTechDocFeedback_Appproved_price', 'SampleController@saveSampleTechDocFeedback_Appproved_price')->name('saveSampleTechDocFeedback_Appproved_price'); //v2

Route::post('/saveSampleTechLinkingData', 'SampleController@saveSampleTechLinkingData')->name('saveSampleTechLinkingData'); //v2
Route::post('/sampleResubmit', 'SampleController@sampleResubmit')->name('sampleResubmit'); //v2
Route::get('/sampleHighPriority', 'SampleController@sampleHighPriority')->name('sampleHighPriority'); //v2
Route::get('/sampleFormulationList', 'SampleController@sampleFormulationList')->name('sampleFormulationList'); //v2
Route::get('/sampleFormulationListSales', 'SampleController@sampleFormulationListSales')->name('sampleFormulationListSales'); //v2









Route::post('/getSamplesList_UnassignedList', 'SampleController@getSamplesList_UnassignedList')->name('getSamplesList_UnassignedList'); //v2
Route::post('/getSamplesList_UnassignedList_OILS', 'SampleController@getSamplesList_UnassignedList_OILS')->name('getSamplesList_UnassignedList_OILS'); //v2

Route::post('/getSamplesList_assignedList', 'SampleController@getSamplesList_assignedList')->name('getSamplesList_assignedList'); //v2


Route::post('/saveSampleFormulations', 'SampleController@saveSampleFormulations')->name('saveSampleFormulations'); //v2
Route::post('/saveSampleFormulationsF', 'SampleController@saveSampleFormulationsF')->name('saveSampleFormulationsF'); //v2
Route::post('/getMTDRangeWise', 'HomeController@getMTDRangeWise')->name('getMTDRangeWise'); //v2
Route::post('/getMTDRangeWiseBrand', 'HomeController@getMTDRangeWiseBrand')->name('getMTDRangeWiseBrand'); //v2
Route::get('/getMTDBrandDetails', 'HomeController@getMTDBrandDetails')->name('getMTDBrandDetails'); //v2
Route::post('/getMTDRangeWiseBrandDetails', 'HomeController@getMTDRangeWiseBrandDetails')->name('getMTDRangeWiseBrandDetails'); //v2





Route::post('/getMTDRangeWiseSalesPayment', 'HomeController@getMTDRangeWiseSalesPayment')->name('getMTDRangeWiseSalesPayment'); //v2




Route::post('/getSampleFormulaDetails', 'SampleController@getSampleFormulaDetails')->name('getSampleFormulaDetails'); //v2
Route::post('/getSampleFormulatDetailsView', 'SampleController@getSampleFormulatDetailsView')->name('getSampleFormulatDetailsView'); //v2
Route::get('/getSampleFormulatDetailsViewSample', 'SampleController@getSampleFormulatDetailsViewSample')->name('getSampleFormulatDetailsViewSample'); //v2
Route::get('/getSampleFormulatDetailsViewSampleModi', 'SampleController@getSampleFormulatDetailsViewSampleModi')->name('getSampleFormulatDetailsViewSampleModi'); //v2




















Route::post('/getSamplesList_feedbac_own', 'SampleController@getSamplesList_feedbac_own')->name('getSamplesList_feedbac_own'); //v2
Route::post('/setSampleProcessResponse', 'SampleController@setSampleProcessResponse')->name('setSampleProcessResponse'); //v2






Route::post('/sampleStoreNew', 'SampleController@sampleStoreNew')->name('sampleStoreNew'); //v2
Route::get('/sample/createv1/{id}/{idd}', 'SampleController@sampleCreateV1')->name('sampleCreateV1'); //v2



Route::get('/sample-Pending-Aprroval-List', 'SampleController@samplePendingAprrovalList')->name('samplePendingAprrovalList'); //v2
Route::get('/FAQ-about-Ingredient', 'SampleController@FAQAboutIngredent')->name('FAQAboutIngredent'); //v2
Route::get('/technical-questions', 'SampleController@FAQAboutIngredentList')->name('FAQAboutIngredentList'); //v2

Route::post('/saveFAQ', 'SampleController@saveFAQ')->name('saveFAQ'); //v2
Route::post('/saveFAQAnwers', 'SampleController@saveFAQAnwers')->name('saveFAQAnwers'); //v2





Route::get('/sample-technical-document-List', 'SampleController@sampletechnicalList')->name('sampletechnicalList'); //v2
Route::get('/order-technical-document-List', 'SampleController@ordertechnicalList')->name('ordertechnicalList'); //v2

Route::get('/add-technical-document-sample', 'SampleController@sampleAddTechinalDocument')->name('sampleAddTechinalDocument'); //v2
Route::get('/add-technical-document-order', 'SampleController@sampleAddTechinalDocumentOrder')->name('sampleAddTechinalDocumentOrder'); //v2






Route::post('/getSamplesList_LITE', 'SampleController@getSamplesList_LITE')->name('getSamplesList_LITE');
Route::post('/getSamplesList_LITE_OILS', 'SampleController@getSamplesList_LITE_OILS')->name('getSamplesList_LITE_OILS');
Route::post('/getSamplesList_LITE_COSMATIC', 'SampleController@getSamplesList_LITE_COSMATIC')->name('getSamplesList_LITE_COSMATIC');
Route::post('/getOrderPaymentAccountDetails', 'SampleController@getOrderPaymentAccountDetails')->name('getOrderPaymentAccountDetails');


Route::post('/getSamplesList_LITE_COSMATIC_viewAfterFormulation', 'SampleController@getSamplesList_LITE_COSMATIC_viewAfterFormulation')->name('getSamplesList_LITE_COSMATIC_viewAfterFormulation');




Route::post('/getSamplesList_LITE_HISTORY', 'SampleController@getSamplesList_LITE_HISTORY')->name('getSamplesList_LITE_HISTORY');




Route::post('/getSamplesList_LITE_COSMATIC_unassinedList', 'SampleController@getSamplesList_LITE_COSMATIC_unassinedList')->name('getSamplesList_LITE_COSMATIC_unassinedList');

Route::post('/getSamplesList_LITE_COSMATIC_assinedList', 'SampleController@getSamplesList_LITE_COSMATIC_assinedList')->name('getSamplesList_LITE_COSMATIC_assinedList');
Route::post('/getSamplesList_LITE_COSMATIC_Standard', 'SampleController@getSamplesList_LITE_COSMATIC_Standard')->name('getSamplesList_LITE_COSMATIC_Standard');




Route::post('/getSamplesList_LITE_COSMATIC_assinedListRESTALL', 'SampleController@getSamplesList_LITE_COSMATIC_assinedListRESTALL')->name('getSamplesList_LITE_COSMATIC_assinedListRESTALL');


Route::post('/getSampleItemDetail', 'SampleController@getSampleItemDetail')->name('getSampleItemDetail');
Route::post('/getSampleItemDetailFormulation', 'SampleController@getSampleItemDetailFormulation')->name('getSampleItemDetailFormulation');











Route::post('/getSamplesListNew', 'SampleController@getSamplesListNew')->name('getSamplesListNew'); //v2
Route::post('/getSamplesListUserWise', 'SampleController@getSamplesListUserWise')->name('getSamplesListUserWise'); //v2

Route::post('/getSampleDetails', 'SampleController@getSampleDetails')->name('getSampleDetails'); //v2
Route::post('/softdeleteClient', 'ClientController@softdeleteClient')->name('softdeleteClient');
Route::post('/getClientDetails', 'ClientController@getClientDetails')->name('getClientDetails');
Route::post('/edit/client', 'ClientController@edit_client')->name('edit_client');
Route::resource('sample', 'SampleController'); //v2


Route::get('add_stage_sample/{leadid}', 'SampleController@add_stage_sample')->name('add_stage_sample'); //v2
Route::get('add_stage_sampleV1/{leadid}/{leadTye}/{userid}', 'SampleController@add_stage_sampleV1')->name('add_stage_sampleV1'); //v2
Route::get('add_stage_sampleV2/{leadid}/{leadTye}/{userid}', 'SampleController@add_stage_sampleV2')->name('add_stage_sampleV2'); //v2



Route::get('add-mylead-sample/{leadid}', 'SampleController@add_myLead_sample')->name('add_myLead_sample'); //v2
Route::post('getAllSampleDetails', 'SampleController@getAllSampleDetails')->name('getAllSampleDetails'); //v2
Route::post('getFAQDetailsBYID', 'SampleController@getFAQDetailsBYID')->name('getFAQDetailsBYID'); //v2



Route::post('sample.storeLead', 'SampleController@storeLead')->name('sample.storeLead'); //v2
Route::post('samplestoreLeadv2', 'SampleController@samplestoreLeadv2')->name('samplestoreLeadv2'); //v2

Route::post('deleteSampleTechDoc', 'SampleController@deleteSampleTechDoc')->name('deleteSampleTechDoc'); //v2
Route::post('deleteSampleRNDFormula', 'SampleController@deleteSampleRNDFormula')->name('deleteSampleRNDFormula'); //v2
Route::post('deleteSampleRNDFormulaBase', 'SampleController@deleteSampleRNDFormulaBase')->name('deleteSampleRNDFormulaBase'); //v2






Route::get('sample-list', 'SampleController@sampleListSales')->name('sampleListSales'); //v2
Route::get('sample-list-oils', 'SampleController@sampleListOils')->name('sampleListOils'); //v2
Route::get('sample-list-cosmatic', 'SampleController@sampleListCosmatic')->name('sampleListCosmatic'); //v2

Route::get('sample-list-cosmatic-oil-view', 'SampleController@sampleListCosmatic_OILView')->name('sampleListCosmatic_OILView'); //v2




Route::get('sample-history', 'SampleController@sampleHistory')->name('sampleHistory'); //v2



Route::get('/getSamplesListSalesDash', 'SampleController@getSamplesListSalesDash')->name('getSamplesListSalesDash');
Route::post('/getSamplesListPendingAprroval', 'SampleController@getSamplesListPendingAprroval')->name('getSamplesListPendingAprroval');




Route::post('/deleteSample', 'SampleController@deleteSample')->name('deleteSample'); //v2
Route::post('/deletePaymentRequest', 'ClientController@deletePaymentRequest')->name('deletePaymentRequest'); //v2
Route::post('/deleteOrderEditRequest', 'ClientController@deleteOrderEditRequest')->name('deleteOrderEditRequest'); //v2




Route::resource('rawclientdata', 'RawClientDataController'); //v2

Route::post('import', 'RawClientDataController@import')->name('import'); //v2
Route::post('importAttendance', 'RawClientDataController@importAttendance')->name('importAttendance'); //v2

Route::post('importOrder', 'RawClientDataController@importOrder')->name('importOrder'); //v2


Route::get('export', 'RawClientDataController@export')->name('export'); //v2
Route::get('export_sample', 'RawClientDataController@export_sample')->name('export_sample'); //v2
Route::get('export_sample_attendace', 'RawClientDataController@export_sample_attendace')->name('export_sample_attendace'); //v2
Route::post('getMasterAttenDance', 'UserController@getMasterAttenDance')->name('getMasterAttenDance'); //v2

//highchart
Route::get('getChartReport', 'UserController@getChartReport')->name('getChartReport'); //v2
Route::post('getHighcartOrderValuePaymentRecieved', 'UserController@getHighcartOrderValuePaymentRecieved')->name('getHighcartOrderValuePaymentRecieved'); //v2
Route::get('getHighcartLast7daysCall', 'UserController@getHighcartLast7daysCall')->name('getHighcartLast7daysCall'); //v2

Route::get('getHighcartLast30daysTotalRecivedMissedCall', 'UserController@getHighcartLast30daysTotalRecivedMissedCall')->name('getHighcartLast30daysTotalRecivedMissedCall'); //v2
Route::get('getHighcartLast30daysTotalSamplesAdded', 'UserController@getHighcartLast30daysTotalSamplesAdded')->name('getHighcartLast30daysTotalSamplesAdded'); //v2







Route::post('getHighcartSampleAssigned', 'UserController@getHighcartSampleAssigned')->name('getHighcartSampleAssigned'); //v2



Route::post('getHighcartLeadClaimBySalesTeam', 'UserController@getHighcartLeadClaimBySalesTeam')->name('getHighcartLeadClaimBySalesTeam'); //v2



Route::get('getHighcartPaymentRecievedMonthly', 'UserController@getHighcartPaymentRecievedMonthly')->name('getHighcartPaymentRecievedMonthly'); //v2
Route::get('getHighcartPaymentRecievedMonthly_BULKORDER', 'UserController@getHighcartPaymentRecievedMonthly_BULKORDER')->name('getHighcartPaymentRecievedMonthly_BULKORDER'); //v2
Route::get('getHighcartPaymentRecievedMonthly_PLORDER', 'UserController@getHighcartPaymentRecievedMonthly_PLORDER')->name('getHighcartPaymentRecievedMonthly_PLORDER'); //v2




Route::get('getHighcartOrderPunchedMonthly', 'UserController@getHighcartOrderPunchedMonthly')->name('getHighcartOrderPunchedMonthly'); //v2



Route::post('getHighcartPaymentRecievedMonthlybyUser', 'UserController@getHighcartPaymentRecievedMonthlybyUser')->name('getHighcartPaymentRecievedMonthlybyUser'); //v2


Route::post('getHighcartIncentiveValueMonthlybyUser', 'UserController@getHighcartIncentiveValueMonthlybyUser')->name('getHighcartIncentiveValueMonthlybyUser'); //v2

Route::post('getHighcartFreshLeadRemainigValueMonthly', 'UserController@getHighcartFreshLeadRemainigValueMonthly')->name('getHighcartFreshLeadRemainigValueMonthly'); //v2


Route::post('getHighcartRecievedMissedMonthwise', 'UserController@getHighcartRecievedMissedMonthwise')->name('getHighcartRecievedMissedMonthwise'); //v2








Route::post('getHighcartLeadClaimThisMonth', 'UserController@getHighcartLeadClaimThisMonth')->name('getHighcartLeadClaimThisMonth'); //v2
Route::post('getHighcartLeadVerifedThisMonth', 'UserController@getHighcartLeadVerifedThisMonth')->name('getHighcartLeadVerifedThisMonth'); //v2
Route::post('getHighcartLeadVerifedThisMonthbyUser', 'UserController@getHighcartLeadVerifedThisMonthbyUser')->name('getHighcartLeadVerifedThisMonthbyUser'); //v2
Route::post('getHighcartLeadNEWVerifedClaimThisMonthbyUser', 'UserController@getHighcartLeadNEWVerifedClaimThisMonthbyUser')->name('getHighcartLeadNEWVerifedClaimThisMonthbyUser'); //v2

Route::post('getHighcartLeadClaimThisMonthbyUser', 'UserController@getHighcartLeadClaimThisMonthbyUser')->name('getHighcartLeadClaimThisMonthbyUser'); //v2













//highchart


Route::post('getMyMasterAttenDance', 'UserController@getMyMasterAttenDance')->name('getMyMasterAttenDance'); //v2
Route::post('getIndividualAttendance', 'UserController@getIndividualAttendance')->name('getIndividualAttendance'); //v2

Route::get('myAttendance', 'UserController@myAttendance')->name('myAttendance'); //v2
Route::get('getIndData-viewA', 'UserController@getINDMartData')->name('getINDMartData'); //v2
Route::get('get-ind-leads', 'UserController@getINDMartDatav2')->name('getINDMartDatav2'); //v2


Route::get('getINDMartDataLeadManagerView', 'UserController@getINDMartDataLeadManagerView')->name('getINDMartDataLeadManagerView'); //v2

Route::get('get-lead-list', 'UserController@getINDMartDataLeadManagerView_Intern')->name('getINDMartDataLeadManagerView_Intern'); //v2



Route::get('getINDMartDataLeadManagerViewExport', 'UserController@getINDMartDataLeadManagerViewExport')->name('getINDMartDataLeadManagerViewExport'); //v2





Route::get('get-leads-data', 'UserController@getINDMartDataNEW')->name('getINDMartDataNEW'); //v2

Route::get('get-leads', 'UserController@getLeadsAcceessList')->name('getLeadsAcceessList'); //v2
Route::get('my-leads', 'UserController@getLeadsAcceessListOwn')->name('getLeadsAcceessListOwn'); //v2
Route::get('chemists', 'UserController@getAllChemistLayout')->name('getAllChemistLayout'); //v2
Route::get('bulkSampleDispatch', 'UserController@bulkSampleDispatch')->name('bulkSampleDispatch'); //v2
Route::get('chemistSamplesDetails', 'UserController@chemistSamplesDetails')->name('chemistSamplesDetails'); //v2

Route::get('getSampleDetailsBYID', 'UserController@getSampleDetailsBYID')->name('getSampleDetailsBYID'); //v2





Route::get('my-leads-client', 'UserController@getLeadsAcceessListOwnClient')->name('getLeadsAcceessListOwnClient'); //v2



Route::get('add-new-leads', 'UserController@AddNewLead')->name('AddNewLead'); //v2
Route::get('add_to_myLead/{qid}', 'UserController@AddNewLeadByIndmLead')->name('AddNewLeadByIndmLead'); //v2





Route::get('printLabel/{sampleID}/{newsample}', 'UserController@printLabel')->name('printLabel'); //v2
Route::get('send/quatation/{sampleID}', 'UserController@sendQuationView')->name('sendQuationView'); //v2





Route::get('add-new-lead', 'UserController@add_lead_data')->name('add_lead_data'); //v2
Route::post('updateLeadData', 'UserController@updateLeadData')->name('updateLeadData'); //v2

Route::post('saveLeadData', 'UserController@saveLeadData')->name('saveLeadData'); //v2



Route::get('users/lead/{leadid}/edit', 'UserController@editLead')->name('editLead'); //v2


Route::post('setClientUpdation', 'UserController@setClientUpdation')->name('setClientUpdation'); //v2




Route::get('sample/print/{id}', 'SampleController@print')->name('print_sample'); //v2
Route::get('samples-dispatched', 'SampleController@sampleDispatched')->name('sampleDispatched'); //v2



Route::get('rnd-ingrednts-print/{id}/{batchsize}', 'SampleController@printRNDFormulation')->name('printRNDFormulation'); //v2
Route::get('rnd-ingrednts-print-base/{id}/{batchsize}', 'SampleController@printRNDFormulationBase')->name('printRNDFormulationBase'); //v2

Route::get('rnd-ingrednts-view-base/{id}', 'SampleController@printRNDFormulationViewBase')->name('printRNDFormulationViewBase'); //v2

Route::get('getIncentiveAppliedUsed', 'SampleController@getIncentiveAppliedUsed')->name('getIncentiveAppliedUsed'); //v2
Route::get('getIncentiveAppliedUsedRND', 'SampleController@getIncentiveAppliedUsedRND')->name('getIncentiveAppliedUsedRND'); //v2

Route::get('ticketForm', 'UserController@ticketForm')->name('ticketForm'); //v2




Route::get('sample.print.all', 'SampleController@print_all')->name('sample.print.all'); //v2
Route::get('client.notes', 'ClientController@getClient_notes_view')->name('client.notes'); //v2
Route::get('call-details', 'UserController@getCallDetails')->name('getCallDetails'); //v2

Route::post('add.notes', 'ClientController@add_Note')->name('add.notes'); //v2
Route::post('addLeadNotes', 'ClientController@addLeadNotes')->name('addLeadNotes'); //v2



Route::post('addNotesONLead', 'ClientController@addNotesONLead')->name('addNotesONLead'); //v2

Route::post('myLeadTranfer', 'ClientController@myLeadTranfer')->name('myLeadTranfer'); //v2
Route::post('deleteMyLead', 'ClientController@deleteMyLead')->name('deleteMyLead'); //v2
Route::post('saveQuationDataAsDraft', 'ClientController@saveQuationDataAsDraft')->name('saveQuationDataAsDraft'); //v2
Route::post('getCID_Quation_data', 'ClientController@getCID_Quation_data')->name('getCID_Quation_data'); //v2






Route::post('delete.note', 'ClientController@deleteNote')->name('delete.note'); //v2
Route::post('upload.dropzone', 'HomeController@UploadDropzone')->name('upload.dropzone'); //v2
Route::get('user/profile', 'UserController@userProfile')->name('user.profile'); //v2
Route::post('getOrdersList', 'OrderController@getOrdersList')->name('getOrdersList'); //v2
Route::post('getOrderData', 'OrderController@getOrderData')->name('getOrderData'); //v2
Route::get('getBulkOrders', 'OrderController@getBulkOrders')->name('getBulkOrders'); //v2

Route::post('getSubCategoryFinishProuct', 'OrderController@getSubCategoryFinishProuct')->name('getSubCategoryFinishProuct'); //v2


Route::post('getOrderMainList', 'OrderController@getOrderMainList')->name('getOrderMainList'); //v2
Route::get('getSampleChemistList', 'OrderController@getSampleChemistList')->name('getSampleChemistList'); //v2
Route::get('getSampleChemistListAssigned', 'OrderController@getSampleChemistListAssigned')->name('getSampleChemistListAssigned'); //v2




Route::get('editChem/{user_id}', 'OrderController@editChem')->name('editChem'); //v2
Route::get('editChemOrder/{user_id}', 'OrderController@editChemOrder')->name('editChemOrder'); //v2
Route::get('getSamplewiswOrderByChemist', 'OrderController@getSamplewiswOrderByChemist')->name('getSamplewiswOrderByChemist'); //v2







Route::post('getRawClientData', 'RawClientDataController@getRawClientData')->name('getRawClientData'); //v2
Route::post('getOrderItemsList', 'OrderController@getOrderItemsList')->name('getOrderItemsList'); //v2
Route::post('saveMaterialItem', 'OrderController@saveMaterialItem')->name('saveMaterialItem'); //v2
Route::post('getOrderMaterialItemAddedList', 'OrderController@getOrderMaterialItemAddedList')->name('getOrderMaterialItemAddedList'); //v2
Route::get('getMaterialAttribue', 'OrderController@getMaterialAttribue')->name('getMaterialAttribue'); //v2
Route::get('setMaterialAttribue', 'OrderController@setMaterialAttribue')->name('setMaterialAttribue'); //v2
Route::get('orders-info/{id}', 'OrderController@getOrderInfo')->name('getOrderInfo'); //v2
Route::get('orders-add-material/{id}', 'OrderController@orderAddMaterial')->name('orderAddMaterial'); //v2



Route::get('getCatItems', 'OrderController@getCatItems')->name('getCatItems'); //v2
Route::post('getSalesInvoiceReqestList', 'OrderController@getSalesInvoiceReqestList')->name('getSalesInvoiceReqestList'); //v2
Route::post('getLeadOnCredittList', 'OrderController@getLeadOnCredittList')->name('getLeadOnCredittList'); //v2
Route::get('on-credit-list', 'UserController@oncreditList')->name('oncreditList'); //v2






Route::post('deleteReqInvoice', 'OrderController@deleteReqInvoice')->name('deleteReqInvoice'); //v2



Route::post('getPaymentReqestList', 'OrderController@getPaymentReqestList')->name('getPaymentReqestList'); //v2

Route::post('getPaymentRequestDataAdmin', 'OrderController@getPaymentRequestDataAdmin')->name('getPaymentRequestDataAdmin'); //v2
Route::post('getPaymentRequestDataAdmin_Sample', 'OrderController@getPaymentRequestDataAdmin_Sample')->name('getPaymentRequestDataAdmin_Sample'); //v2



Route::post('saveleadCreditRequest', 'HomeController@saveleadCreditRequest')->name('saveleadCreditRequest'); //v2










Route::post('saveOrderItem', 'OrderController@saveOrderItem')->name('saveOrderItem'); //v2
Route::post('getOrderMItemsAddedList', 'OrderController@getOrderMItemsAddedList')->name('getOrderMItemsAddedList'); //v2
Route::post('deleteItemOrder', 'OrderController@deleteItemOrder')->name('deleteItemOrder'); //v2
Route::post('getStock_AddedList', 'OrderController@getStock_AddedList')->name('getStock_AddedList'); //v2
Route::post('reserveItemfromStock', 'OrderController@reserveItemfromStock')->name('reserveItemfromStock'); //v2
Route::post('reserveItemfromStock', 'OrderController@reserveItemfromStock')->name('reserveItemfromStock'); //v2
Route::post('purchaseItemforStock', 'OrderController@purchaseItemforStock')->name('purchaseItemforStock'); //v2
Route::post('saveCateory', 'OrderController@saveCateory')->name('saveCateory'); //v2
Route::post('saveItemName', 'OrderController@saveItemName')->name('saveItemName'); //v2
Route::post('deleteOrderNow', 'OrderController@deleteOrderNow')->name('deleteOrderNow'); //v2
Route::get('purchase-request-list', 'PurchaseController@purchaseReqAlert')->name('purchase.req.alert'); //v2
Route::get('stock-request-list', 'StockController@stockReqAlert')->name('stock.req.alert'); //v2
Route::get('sample/add/{id}', 'SampleController@addSamplebyID')->name('sample/add'); //v2
Route::post('getPurchaseRequestAlert', 'PurchaseController@getPurchaseRequestAlert')->name('getPurchaseRequestAlert'); //v2

Route::post('getPurchaseRequestGroupTotal', 'PurchaseController@getPurchaseRequestGroupTotal')->name('getPurchaseRequestGroupTotal'); //v2
Route::get('purchase-order/{id}', 'PurchaseController@createPurchaseOrder')->name('createPurchaseOrder'); //v2
Route::post('savePurchaseOrder', 'PurchaseController@savePurchaseOrder')->name('savePurchaseOrder'); //v2
Route::post('getRequestedItems', 'StockController@getRequestedItems')->name('getRequestedItems'); //v2
Route::post('BOMConfirmation', 'OrderController@BOMConfirmation')->name('BOMConfirmation'); //v2
Route::post('deleteBOMItems', 'OrderController@deleteBOMItems')->name('deleteBOMItems'); //v2
Route::get('pending-reserve', 'OrderController@purchaseReserved')->name('purchase.reserved'); //v2
Route::post('getPurchaseReserved', 'OrderController@getPurchaseReservedList')->name('getPurchaseReserved'); //v2
Route::post('purchase-request-entry', 'OrderController@purchaseItemforStock')->name('purchaseRequestEntry'); //v2
Route::get('purchased-orders-list', 'PurchaseController@purchasedOrdersList')->name('purchasedOrdersList'); //v2
Route::post('getPurchasedOrderedlist', 'PurchaseController@getPurchasedOrderedlist')->name('getPurchasedOrderedlist'); //v2


//recieved orders
Route::get('recieved-orders', 'StockController@recievedOrders')->name('recievedOrders'); //v2
Route::post('getRecievedOrders', 'StockController@getRecievedOrders')->name('getRecievedOrders'); //v2
Route::get('orders-recieved', 'StockController@ordersRecieved')->name('ordersRecieved'); //v2
Route::post('getPurchaseOrderData', 'PurchaseController@getPurchaseOrderData')->name('getPurchaseOrderData'); //v2
Route::post('saveRecievedPurchaseOrder', 'StockController@saveRecievedPurchaseOrder')->name('saveRecievedPurchaseOrder'); //v2
Route::get('purchase-list', 'PurchaseController@purchaseList')->name('purchaseList'); //v2
Route::get('purchase-list-printed-box', 'PurchaseController@purchaseListPrintedBOx')->name('purchaseListPrintedBOx'); //v2

Route::post('getRecievedOrdersListNew', 'StockController@getRecievedOrdersListNew')->name('getRecievedOrdersListNew'); //v2
Route::get('recieved-orders/{id}', 'StockController@recievedPendingOrders')->name('recievedPendingOrders'); //v2
Route::post('reservedNowItems', 'StockController@reservedNowItems')->name('reservedNowItems'); //v2
Route::post('IssueNowItems', 'StockController@IssueNowItems')->name('IssueNowItems'); //v2
Route::get('stocks-entry', 'StockController@StockEntry')->name('stocks.entry'); //v2
Route::post('saveStockItems', 'StockController@saveStockItems')->name('saveStockItems'); //v2
Route::post('getStocks', 'StockController@getStocks')->name('getStocks'); //v2
Route::get('import-export', 'HomeController@ImportExport')->name('import-export'); //v2
Route::post('import-data', 'RawClientDataController@importData')->name('import_data'); //v2
Route::post('delete.items', 'StockController@deleteItems')->name('delete.items'); //v2
Route::post('getVendorList', 'VendorController@getVendorList')->name('getVendorList'); //v2
Route::post('userAccess', 'UserController@userAccess')->name('userAccess'); //v2
Route::post('userAccessRemove', 'UserController@userAccessRemove')->name('userAccessRemove'); //v2
Route::post('saveOrderItemsAddmore', 'OrderController@saveOrderItemsAddmore')->name('saveOrderItemsAddmore'); //v2
Route::get('client-leads', 'ClientController@clientLeads')->name('client.leads'); //v2
Route::get('today-client-follow-up', 'ClientController@todayClientFollow')->name('today.clientFollow'); //v2
Route::get('yestarday-client-follow-up', 'ClientController@yestardayClientFollow')->name('yestarday.clientFollow'); //v2
Route::get('delayed-client-follow-up', 'ClientController@delayedClientFollow')->name('delayed.clientFollow'); //v2
Route::get('new-sample', 'SampleController@sampleNew')->name('sample.new'); //v2

Route::get('/getClientsListd', 'ClientController@getClientsListApi')->name('getClientsListApi');





Route::get('/sendMail', 'ClientController@sendMail')->name('sendMail');
Route::post('/saveFeedback', 'SampleController@saveFeedback')->name('saveFeedback');
Route::post('/savePaymentRemovewithReason', 'SampleController@savePaymentRemovewithReason')->name('savePaymentRemovewithReason');
Route::post('/savePaymentRemovewithReasonDeduction', 'SampleController@savePaymentRemovewithReasonDeduction')->name('savePaymentRemovewithReasonDeduction');

Route::post('/saveSampleAssinged', 'SampleController@saveSampleAssinged')->name('saveSampleAssinged');
Route::post('/saveSampleRejectModify', 'SampleController@saveSampleRejectModify')->name('saveSampleRejectModify');


Route::post('/UserResetPassword', 'UserController@UserResetPassword')->name('UserResetPassword');
Route::get('/sendSMS/{phone_number}', 'SMSController@sendSMS');
Route::post('/customLogin', 'Auth\LoginController@customLogin')->name('customLogin');
Route::post('/LoginOTPVerify', 'Auth\LoginController@LoginOTPVerify')->name('LoginOTPVerify');



Route::get('/pending-feedback-sample', 'SampleController@samplePendingFeedback')->name('sample.pending.feedback');
Route::get('/users/permission/{user_id}', 'UserController@userPermissions')->name('userPermissions');
Route::post('/setUserPermission', 'UserController@setUserPermission')->name('setUserPermission');
Route::get('/add-permission-users', 'UserController@addPermissionUsers')->name('add.permission.users');
Route::post('/saveuserPermission', 'UserController@saveuserPermission')->name('saveuserPermission');
Route::get('/reports-sales-graph', 'UserController@reportSalesGraph')->name('reportSalesGraph');
Route::get('/reports-samples', 'UserController@reportSampleReport')->name('reportSampleReport');



Route::post('/sentTicketRequest', 'UserController@sentTicketRequest')->name('sentTicketRequest');
Route::post('/sentTicketRequestOrder', 'UserController@sentTicketRequestOrder')->name('sentTicketRequestOrder');

Route::post('/getTicketListData', 'UserController@getTicketListData')->name('getTicketListData');
Route::post('/getTicketListDatav2', 'UserController@getTicketListDatav2')->name('getTicketListDatav2');

Route::get('/getOrderEditListData', 'UserController@getOrderEditListData')->name('getOrderEditListData');
Route::get('/getOnCreditRequest', 'UserController@getOnCreditRequest')->name('getOnCreditRequest');





Route::post('/getActivityUserListData', 'UserController@getActivityUserListData')->name('getActivityUserListData');



Route::post('/getTicketListDataInfo', 'UserController@getTicketListDataInfo')->name('getTicketListDataInfo');
Route::post('/getTicketListDataInfoV2', 'UserController@getTicketListDataInfoV2')->name('getTicketListDataInfoV2');


Route::post('/sendEmailQuatation', 'ClientController@sendEmailQuatation')->name('sendEmailQuatation');
Route::post('/downloadQuatation', 'ClientController@downloadQuatation')->name('downloadQuatation');





Route::get('/view-tickets', 'UserController@view_ticket_data')->name('view_ticket_data');
Route::get('/view-order-edit-request', 'UserController@view_order_edit_request')->name('view_order_edit_request');





Route::get('/print/qcform/{id}', 'OrderController@print_QCFORM')->name('print.qcform');
Route::get('/view_preview_quatation/{id}', 'ClientController@view_preview_quatation')->name('view_preview_quatation');
Route::get('quatations', 'ClientController@getQutatationList')->name('getQutatationList');
Route::post('getAjaxQuatationList', 'ClientController@getAjaxQuatationList')->name('getAjaxQuatationList');
Route::get('/quatation/preview/{id}', 'ClientController@quationPreview')->name('quationPreview');
Route::get('/add-new-quotation', 'ClientController@addNew_Quotation')->name('addNew_Quotation');



Route::get('/print/qcform-bulk/{id}', 'OrderController@print_QCFORM_BULK')->name('print.qcform_bulk');

Route::get('/qcform/creates', 'OrderController@qcformStore')->name('qcform.creates');
//for member 
Route::get('/qcform/creates-member/{userid}', 'OrderController@qcformStoreMember')->name('qcformStoreMember');



Route::get('missed-cronjob', 'OrderController@viewMissedCronJob')->name('viewMissedCronJob');

Route::post('/save-qc-from', 'OrderController@saveQCdata')->name('saveQCdata');


Route::post('/saveQCdataPricePart', 'OrderController@saveQCdataPricePart')->name('saveQCdataPricePart');



Route::post('/save-qc-from-copy', 'OrderController@saveQC_Copy')->name('saveQC_Copy');








Route::post('/qcform.getList', 'OrderController@qcFormList')->name('qcform.getList');
Route::post('/qcform.getList_v1', 'OrderController@qcFormListV1')->name('qcform.getList_v1');
Route::post('/qcformGetList_v1', 'OrderController@qcformGetList_v1')->name('qcformGetList_v1');
Route::post('/qcformGetList_v1_fast', 'OrderController@qcformGetList_v1_fast')->name('qcformGetList_v1_fast');






Route::post('/getOrderListForTeam', 'OrderController@getOrderListForTeam')->name('getOrderListForTeam');


Route::post('/qcformOrderListAdminView', 'OrderController@qcformOrderListAdminView')->name('qcformOrderListAdminView');
Route::post('/qcformOrderListAdminViewPending', 'OrderController@qcformOrderListAdminViewPending')->name('qcformOrderListAdminViewPending');





Route::post('/qcformOrderPlanOrderView', 'OrderController@qcformOrderPlanOrderView')->name('qcformOrderPlanOrderView');



Route::post('/qcformOrderListAdminViewBulkOrders', 'OrderController@qcformOrderListAdminViewBulkOrders')->name('qcformOrderListAdminViewBulkOrders');



Route::post('/getSampleListbyCatType', 'SampleController@getSampleListbyCatType')->name('getSampleListbyCatType');
Route::get('/mapRNDSampleList', 'SampleController@mapRNDSampleList')->name('mapRNDSampleList');




Route::post('/getPayOrderApprovalList', 'OrderController@getPayOrderApprovalList')->name('getPayOrderApprovalList');
Route::post('/mark_as_row_material', 'ClientController@markAsRawMaterial')->name('mark_as_row_material');


Route::post('/setTicketResponseSELF', 'UserController@setTicketResponseSELF')->name('setTicketResponseSELF');



Route::post('/getOrderQty', 'OrderController@getOrderQty')->name('getOrderQty');

Route::get('/payment-confirmation-request', 'OrderController@PaymentRequestConfirmation')->name('PaymentRequestConfirmation');
Route::get('/payment-confirmation-request/{userid}', 'OrderController@PaymentRequestConfirmationUserID')->name('PaymentRequestConfirmationUserID');


Route::get('/sales-invoice-Request', 'OrderController@SaleInvoiceRequest')->name('SaleInvoiceRequest');
Route::get('/on-credit-lead-list', 'OrderController@oncreditLeadList')->name('oncreditLeadList');




Route::get('/lead-manager-report', 'UserController@getLeadManagerReport')->name('getLeadManagerReport');









Route::post('/qcformGetList_OrderLIst', 'OrderController@qcformGetList_OrderLIst')->name('qcformGetList_OrderLIst');

Route::post('/qcformgetListBulk', 'OrderController@qcformgetListBulk')->name('qcformgetListBulk');



Route::post('/qcform_getList_dispatched', 'OrderController@qcform_getList_dispatched')->name('qcform_getList_dispatched');


Route::post('/getQcOrderStagePendingList', 'OrderController@getQcOrderStagePendingList')->name('getQcOrderStagePendingList');
Route::post('/setSaveProcessAction', 'OrderController@setSaveProcessAction')->name('setSaveProcessAction');




Route::get('/qcform/list', 'OrderController@qcFormListView')->name('qcform.list');
Route::get('/qcform/orders/dispatched', 'OrderController@qcFormListViewDispatched')->name('qcFormListViewDispatched');
Route::get('/qc-bulk-orders', 'OrderController@qcform_getList_BulkList')->name('qcform_getList_BulkList');


Route::get('/feedback/pie/graph', 'SampleController@feedbackSampleGraph')->name('feedbackSampleGraph');
Route::post('/getOrderDataInfo', 'SampleController@getOrderDataInfo')->name('getOrderDataInfo');
Route::get('/back-order-upload', 'OrderController@backOrderUpload')->name('backOrderUpload');
Route::get('/qcform/{form_id}/edit', 'OrderController@qceditForm')->name('qceditForm');
Route::get('/qcform/bulk/{form_id}/edit', 'OrderController@qceditBULKForm')->name('qceditForm');

Route::get('/qcform/{form_id}/copy-order', 'OrderController@qcFormCopy')->name('qcFormCopy');



Route::get('/order-wizard/{orderid}', 'OrderController@orderWizard')->name('orderWizard');
Route::post('updateQCdata', 'OrderController@updateQCdata')->name('updateQCdata');
Route::post('updateQCdataNewWays', 'OrderController@updateQCdataNewWays')->name('updateQCdataNewWays');
Route::post('updateQCdataNewWaysBULK', 'OrderController@updateQCdataNewWaysBULK')->name('updateQCdataNewWaysBULK');
Route::post('getMyQCData', 'OrderController@getMyQCData')->name('getMyQCData');

Route::post('saveSalesInvoiceRequest', 'OrderController@saveSalesInvoiceRequest')->name('saveSalesInvoiceRequest');
Route::post('saveSalesInvoiceRequestAccessed', 'OrderController@saveSalesInvoiceRequestAccessed')->name('saveSalesInvoiceRequestAccessed');

Route::post('savePaymentRecivedClient', 'OrderController@savePaymentRecivedClient')->name('savePaymentRecivedClient');

Route::post('saveOrderProcessDays', 'OrderController@saveOrderProcessDays')->name('saveOrderProcessDays');
Route::get('orders-list', 'OrderController@orderList')->name('orderList');
Route::post('deleteQcForm', 'OrderController@deleteQcForm')->name('deleteQcForm');
Route::post('getOrderWizardList', 'OrderController@getOrderWizardList')->name('getOrderWizardList');
Route::post('save_order_process', 'OrderController@save_order_process')->name('save_order_process');
Route::post('getOrderProcessSteps', 'OrderController@getOrderProcessSteps')->name('getOrderProcessSteps');
Route::post('printSamplewithFilter', 'SampleController@printSamplewithFilter')->name('printSamplewithFilter');
Route::post('printSamplewithFilterV2', 'SampleController@printSamplewithFilterV2')->name('printSamplewithFilterV2');
Route::get('getSampleLabelPrint', 'SampleController@getSampleLabelPrint')->name('getSampleLabelPrint');
Route::get('getSampleLabelPrintEntry', 'SampleController@getSampleLabelPrintEntry')->name('getSampleLabelPrintEntry');
Route::get('getSampleForLBLPrint', 'SampleController@getSampleForLBLPrint')->name('getSampleForLBLPrint');







Route::get('sample-pending-list', 'SampleController@viewSamplePendingList')->name('viewSamplePendingList');

Route::get('sample-assinged-list', 'SampleController@viewSampleAssinedList')->name('viewSampleAssinedList');
Route::get('sample-standard-list', 'SampleController@viewSampleStandardList')->name('viewSampleStandardList');
Route::get('sample-benchmark-list', 'SampleController@viewSampleBenchmarkList')->name('viewSampleBenchmarkList');







Route::get('viewSampleAssinedListMe/{di}', 'SampleController@viewSampleAssinedListMe')->name('viewSampleAssinedListMe');


Route::get('sample-pending-list/{sid}', 'SampleController@viewSamplePendingListBYCat')->name('viewSamplePendingListBYCat');


Route::get('getClientData', 'HomeController@getClientInfo')->name('getClientInfo');
Route::get('purchase-list', 'OrderController@qcFROMPurchaseList')->name('qcform.purchaselist');
Route::get('purchase-list-printed-label', 'OrderController@qcFROMPurchaseListPrintedLabel')->name('qcFROMPurchaseListPrintedLabel');

Route::post('getPurchaseListQCFROM', 'OrderController@getPurchaseListQCFROM')->name('getPurchaseListQCFROM');
Route::post('getPurchaseListQCFROM_V1', 'OrderController@getPurchaseListQCFROM_V1')->name('getPurchaseListQCFROM_V1');
Route::post('getPurchaseListQCFROM_V1_LABEL_BOX', 'OrderController@getPurchaseListQCFROM_V1_LABEL_BOX')->name('getPurchaseListQCFROM_V1_LABEL_BOX');
Route::get('getPurchaseListQCFROM_V1_LABEL_BOX_v1', 'OrderController@getPurchaseListQCFROM_V1_LABEL_BOX_v1')->name('getPurchaseListQCFROM_V1_LABEL_BOX_v1');
Route::get('getUserDataByID', 'UserController@getUserDataByID')->name('getUserDataByID');



Route::post('getPurchaseListQCFROM_V1_MODFIED', 'OrderController@getPurchaseListQCFROM_V1_MODFIED')->name('getPurchaseListQCFROM_V1_MODFIED');





Route::post('getPurchaseListQCFROMArtWork', 'OrderController@getPurchaseListQCFROMArtWork')->name('getPurchaseListQCFROMArtWork');
Route::post('getPurchaseListQCFROMArtWorkAllOther', 'OrderController@getPurchaseListQCFROMArtWorkAllOther')->name('getPurchaseListQCFROMArtWorkAllOther');


Route::post('getPurchaseListHistory', 'OrderController@getPurchaseListHistory')->name('getPurchaseListHistory');

Route::post('setQCPurchaseStatus', 'OrderController@setQCPurchaseStatus')->name('setQCPurchaseStatus');
Route::post('setQCProductionStatus', 'OrderController@setQCProductionStatus')->name('setQCProductionStatus');


//20
//production list
Route::get('production-list', 'OrderController@qcFROMProductionList')->name('qcform.qcFROMProductionList');
Route::post('getQCFromProduction', 'OrderController@getQCFromProduction')->name('getQCFromProduction');
Route::post('setgetQCFromProductionStage', 'OrderController@setgetQCFromProductionStage')->name('setgetQCFromProductionStage');


Route::post('getQCFormOrderData', 'OrderController@getQCFormOrderData')->name('getQCFormOrderData');

Route::post('getQCFormOrderDataPricePart', 'OrderController@getQCFormOrderDataPricePart')->name('getQCFormOrderDataPricePart');



Route::post('UpdateOrderDispatch', 'OrderController@UpdateOrderDispatch')->name('UpdateOrderDispatch');
Route::post('UpdateOrderDispatch_v1', 'OrderController@UpdateOrderDispatch_v1')->name('UpdateOrderDispatch_v1');



Route::get('orders-statges-reports', 'OrderController@orderStagesReport')->name('orderStagesReport');
Route::post('getOrderStatgesReport', 'OrderController@getOrderStatgesReport')->name('getOrderStatgesReport');

Route::get('getOrderList/{step_code}/{my_color}', 'OrderController@getOrderList')->name('getOrderList');


Route::post('getCurrentOrderStagesData', 'OrderController@getCurrentOrderStagesData')->name('getCurrentOrderStagesData');

Route::get('get-stages-report', 'OrderController@getStagesReportbyteam')->name('getStagesReportbyteam');
Route::post('getStagesByTeamWithFilter', 'OrderController@getStagesByTeamWithFilter')->name('getStagesByTeamWithFilter');

Route::get('monthly-sales-report', 'OrderController@getMonthlySalesReport')->name('getMonthlySalesReport');


Route::post('getOperationHealthData', 'OperationHealthController@getOperationHealthData')->name('getOperationHealthData');


Route::get('sapCheckList', 'OrderController@sapCheckList')->name('sapCheckList');
Route::post('getSAPCheckListData', 'OrderController@getSAPCheckListData')->name('getSAPCheckListData');

Route::post('setProcessSAPChecklist', 'OrderController@setProcessSAPChecklist')->name('setProcessSAPChecklist');


Route::get('operation-plan', 'OperationHealthController@operationPlan')->name('operationPlan');
Route::get('order-plan-list', 'OperationHealthController@orderPlanList')->name('orderPlanList');


Route::post('getOperationOrderPlan', 'OperationHealthController@getOperationOrderPlan')->name('getOperationOrderPlan');

Route::post('save_plan_wizard', 'OperationHealthController@save_plan_wizard')->name('save_plan_wizard');

Route::post('savePlanDay3QTY', 'OperationHealthController@savePlanDay3QTY')->name('savePlanDay3QTY');

Route::post('getPlanedOrderDataDay2', 'OperationHealthController@getPlanedOrderDataDay2')->name('getPlanedOrderDataDay2');

Route::get('order-stages-daywise', 'OrderController@getOrderStageDaysWise')->name('getOrderStageDaysWise');
Route::get('order-stages-daywise-v1', 'OrderController@getOrderStageDaysWisev1')->name('getOrderStageDaysWisev1');

Route::post('getFilteruserWiseStageCompleted', 'OrderController@getFilteruserWiseStageCompleted')->name('getFilteruserWiseStageCompleted');
Route::post('getFilterLeadStagesCompleted', 'OrderController@getFilterLeadStagesCompleted')->name('getFilterLeadStagesCompleted');

Route::post('getFilterLeadCallCompleted', 'OrderController@getFilterLeadCallCompleted')->name('getFilterLeadCallCompleted');




Route::post('getFilterLeadLMReportCompleted', 'OrderController@getFilterLeadLMReportCompleted')->name('getFilterLeadLMReportCompleted');




Route::get('BoReports', 'OrderController@BoReports')->name('BoReports');
Route::get('sap-check-list-graph', 'OrderController@sap_chklistGraph')->name('sap_chklistGraph');

Route::get('stage-completed-filter', 'OrderController@stageCompletdFilter')->name('stageCompletdFilter');
Route::get('stage-completed-filter-v1', 'OrderController@stageCompletdFilterV1')->name('stageCompletdFilterV1');


Route::post('getOrderListOfstageCompleted', 'OrderController@getOrderListOfstageCompleted')->name('getOrderListOfstageCompleted');
Route::post('getPaymentDataDETAILSHOW', 'OrderController@getPaymentDataDETAILSHOW')->name('getPaymentDataDETAILSHOW');
Route::post('getPaymentDataDETAILSHOW_SAMPLE', 'OrderController@getPaymentDataDETAILSHOW_SAMPLE')->name('getPaymentDataDETAILSHOW_SAMPLE');




Route::post('getPaymentDataDETAILSHOW_HIST', 'OrderController@getPaymentDataDETAILSHOW_HIST')->name('getPaymentDataDETAILSHOW_HIST');
Route::post('getPaymentDataDETAILSHOW_HIST_SAMPLE', 'OrderController@getPaymentDataDETAILSHOW_HIST_SAMPLE')->name('getPaymentDataDETAILSHOW_HIST_SAMPLE');

Route::post('getPaymentDataDETAILSHOW_HIST_ORDER', 'OrderController@getPaymentDataDETAILSHOW_HIST_ORDER')->name('getPaymentDataDETAILSHOW_HIST_ORDER');





Route::get('pending-process', 'OrderController@pendingProcessReport')->name('pendingProcessReport');

Route::post('getOperatonsInfo', 'OperationHealthController@getOperatonsInfo')->name('getOperatonsInfo');
Route::post('getOperatonsPlanOrderDetails', 'OperationHealthController@getOperatonsPlanOrderDetails')->name('getOperatonsPlanOrderDetails');


Route::post('save_OPHPlan_Day4', 'OperationHealthController@save_OPHPlan_Day4')->name('save_OPHPlan_Day4');
Route::post('getPlanedOrderDay4Data', 'OperationHealthController@getPlanedOrderDay4Data')->name('getPlanedOrderDay4Data');
Route::get('operions-plan-lists', 'OperationHealthController@getOperationHealthPlanList')->name('getOperationHealthPlanList');



Route::post('getOHPlanList', 'OperationHealthController@getOHPlanList')->name('getOHPlanList');
Route::get('dispatched-report', 'OrderController@dispatchedReport')->name('dispatchedReport');



Route::get('plan-view-print/{planid}', 'OperationHealthController@planViewPrint')->name('planViewPrint');

Route::get('add-plan-achieve/{planid}', 'OperationHealthController@addPlanAchieve')->name('addPlanAchieve');

Route::post('SavePlanAchievedData', 'OperationHealthController@SavePlanAchievedData')->name('SavePlanAchievedData');

Route::post('savePlanAchieveData', 'OperationHealthController@savePlanAchieveData')->name('savePlanAchieveData');

Route::get('packing-options-catalog', 'OrderController@packagingOptionCategLog')->name('packagingOptionCategLog');
Route::get('packing-options-catalog-list', 'OrderController@packagingOptionCategLogList')->name('packagingOptionCategLogList');

Route::post('saveOPCDataOnly', 'OrderController@saveOPCDataOnly')->name('saveOPCDataOnly')->middleware('optimizeImages');
Route::post('saveOPCDataOnlyUpdate', 'OrderController@saveOPCDataOnlyUpdate')->name('saveOPCDataOnlyUpdate')->middleware('optimizeImages');


Route::post('getPOCDataAll', 'OrderController@getPOCDataAll')->name('getPOCDataAll');

Route::get('edit-poc/{poc_id}', 'OrderController@editPOC')->name('editPOC');

Route::get('add-view-report/{plan_id}', 'OrderController@viewReportOPlan')->name('viewReportOPlan');

Route::post('getPOCImges', 'OrderController@getPOCImges')->name('getPOCImges');

Route::post('getPartialOrderQty', 'OrderController@getPartialOrderQty')->name('getPartialOrderQty');

Route::post('getPOCFilter', 'OrderController@getPOCFilter')->name('getPOCFilter');
Route::get('getPOCInfinite', 'OrderController@getPOCInfinite')->name('getPOCInfinite');

Route::post('deletePOC', 'OrderController@deletePOC')->name('deletePOC');
Route::post('getClientOrderReportList', 'OrderController@getClientOrderReportList')->name('getClientOrderReportList');
Route::post('getClientOrderReportListFilter', 'OrderController@getClientOrderReportListFilter')->name('getClientOrderReportListFilter');

Route::post('setLeadAssign', 'UserController@setLeadAssign')->name('setLeadAssign');
Route::post('updateTicketStatus', 'UserController@updateTicketStatus')->name('updateTicketStatus');


Route::post('setLeadTags', 'UserController@setLeadTags')->name('setLeadTags');






Route::get('client-orders-report', 'OrderController@client_order_report')->name('client_order_report');

Route::get('payment-recieved-report', 'OrderController@client_paymentRecieved_report')->name('client_paymentRecieved_report');




Route::post('getPaymentRecievedReportListFilter', 'OrderController@getPaymentRecievedReportListFilter')->name('getPaymentRecievedReportListFilter');





Route::get('view-order-details/{client_id}', 'OrderController@viewOrderClient')->name('viewOrderClient');



//ajcode for new stage
Route::get('v1_getOrderslist', 'OrderController@v1_getOrderslist')->name('v1_getOrderslist');
Route::get('v1_getOrderslistPending', 'OrderController@v1_getOrderslistPending')->name('v1_getOrderslistPending');



Route::post('saveOrderEditREQ', 'HomeController@saveOrderEditREQ')->name('saveOrderEditREQ');



//getQCDataForModify
Route::post('getQCDataForModify', 'OrderController@getQCDataForModify')->name('getQCDataForModify');

//getQCDataForModify

Route::get('v1Admin_getOrderslist', 'OrderController@v1Admin_getOrderslist')->name('v1Admin_getOrderslist');


Route::get('get-sales-invoice', 'OrderController@getSalesInoviceRequest')->name('getSalesInoviceRequest');

Route::post('getSalesInvoiceData', 'OrderController@getSalesInvoiceData')->name('getSalesInvoiceData');
Route::post('getLeadOnCreditData', 'OrderController@getLeadOnCreditData')->name('getLeadOnCreditData');



Route::post('saveAccountResponseOnSInvoiceRequest', 'OrderController@saveAccountResponseOnSInvoiceRequest')->name('saveAccountResponseOnSInvoiceRequest');
Route::post('saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce', 'OrderController@saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce')->name('saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce');


Route::post('saveAccountResponseOnSInvoiceRequestFeedback', 'OrderController@saveAccountResponseOnSInvoiceRequestFeedback')->name('saveAccountResponseOnSInvoiceRequestFeedback');






Route::get('QCAccess', 'OrderController@QCAccess')->name('QCAccess');


Route::post('getAllOrderStagev1', 'OrderController@getAllOrderStagev1')->name('getAllOrderStagev1');
Route::post('getAllOrderStagev1_rnd', 'OrderController@getAllOrderStagev1_rnd')->name('getAllOrderStagev1_rnd');
Route::post('getSampleStages', 'OrderController@getSampleStages')->name('getSampleStages');
Route::post('getSampleStagesF', 'OrderController@getSampleStagesF')->name('getSampleStagesF');


Route::post('getAllOrderStagev1_lead', 'OrderController@getAllOrderStagev1_lead')->name('getAllOrderStagev1_lead');
Route::post('getAllOrderStagev1_MY_lead', 'OrderController@getAllOrderStagev1_MY_lead')->name('getAllOrderStagev1_MY_lead');






Route::get('boPurchaseList', 'OrderController@boPurchaseList')->name('boPurchaseList');
Route::get('boPurchaseListLB', 'OrderController@boPurchaseListLB')->name('boPurchaseListLB');
Route::get('boPurchaseListLabelBox', 'OrderController@boPurchaseListLabelBox')->name('boPurchaseListLabelBox');



Route::post('getAllPurchaseStagev1', 'OrderController@getAllPurchaseStagev1')->name('getAllPurchaseStagev1');





//HRMS
Route::get('hr-dashboard', 'UserController@HrDashbaord')->name('hrms_dashboard');
Route::get('employee', 'UserController@employee')->name('employee');
Route::get('job_role', 'UserController@jobRole')->name('jobRole');

Route::post('saveEmployee', 'UserController@saveEmployee')->name('saveEmployee');
Route::post('getEmpListData', 'UserController@getEmpListData')->name('getEmpListData');
Route::post('deleteEMP', 'UserController@deleteEMP')->name('deleteEMP');
Route::post('deleteFromPurchaseListwithID', 'OrderController@deleteFromPurchaseListwithID')->name('deleteFromPurchaseListwithID');


Route::post('/getLocation', 'UserController@getLocation')->name('getLocation');
Route::post('/updateEmpdata', 'UserController@updateEmpdata')->name('updateEmpdata');
Route::post('/saveKPIData', 'UserController@saveKPIData')->name('saveKPIData');
Route::post('/saveKPIReportSubmit', 'UserController@saveKPIReportSubmit')->name('saveKPIReportSubmit');


Route::post('getKPIData', 'UserController@getKPIData')->name('getKPIData');
//Route::post('getEmpListDailyReport', 'UserController@getEmpListDailyReport')->name('getEmpListDailyReport');

Route::post('getKIPDetailsByUserDay', 'UserController@getKIPDetailsByUserDay')->name('getKIPDetailsByUserDay');


Route::get('/emp-view/{emp_id}', 'UserController@empView')->name('empView');
Route::get('/kpi-details-history', 'UserController@kpiDetailHistory')->name('kpiDetailHistory');


Route::get('/kpi-details/{emp_id}', 'UserController@kpiDetails')->name('kpiDetails');
Route::post('/kpiupdateData', 'UserController@kpiupdateData')->name('kpiupdateData');

Route::post('getKPIDataReportHistory', 'UserController@getKPIDataReportHistory')->name('getKPIDataReportHistory');

Route::post('/kpiDetailHistory_all', 'UserController@kpiDetailHistory_all')->name('kpiDetailHistory_all');
Route::get('/kpi-details-history-all/{id}', 'UserController@kpiDetailHistoryEMP')->name('kpiDetailHistoryEMP');

Route::get('upload-attendance', 'UserController@upload_epm_attendance')->name('upload_epm_attendance');
Route::post('setSaveVendorOrder', 'OrderController@setSaveVendorOrder')->name('setSaveVendorOrder');

Route::post('setSaveVendorOrderRecieved', 'OrderController@setSaveVendorOrderRecieved')->name('setSaveVendorOrderRecieved');
Route::get('ingredient-list', 'RNDController@IngredentList')->name('rnd.ingrednetList');

Route::get('download-rnd-pdf/{name}', 'RNDController@downLoadRNDPDF')->name('downLoadRNDPDF');
Route::get('download-rnd-pdfsample/{name}', 'RNDController@downLoadRNDPDFSample')->name('downLoadRNDPDFSample');


Route::get('download-atten-pdf', 'RNDController@downLoadAttrnDPDF')->name('downLoadAttrnDPDF');
Route::get('payment_order_withFilter', 'HomeController@payment_order_withFilter')->name('payment_order_withFilter');
Route::post('setBulkOrderReqIssueProcess', 'HomeController@setBulkOrderReqIssueProcess')->name('setBulkOrderReqIssueProcess');
Route::get('setBulkOrderReqIssueProcessHistory', 'HomeController@setBulkOrderReqIssueProcessHistory')->name('setBulkOrderReqIssueProcessHistory');








Route::get('ingredient-category-list', 'RNDController@ingrednetCategoryList')->name('rnd.ingrednetCategoryList');

Route::post('getFPData', 'RNDController@getFPData')->name('getFPData');



Route::get('finish-product-list', 'RNDController@finishProduct')->name('rnd.finishProduct');
Route::post('getFinishProductDataList', 'RNDController@getFinishProductDataList')->name('getFinishProductDataList');



Route::get('ingredient-brand-list', 'RNDController@IngredentBrandList')->name('rnd.ingrednetBrandList');


Route::post('getIngredentList', 'RNDController@getIngredentList')->name('getIngredentList');
Route::post('getIngredentBrandList', 'RNDController@getIngredentBrandList')->name('getIngredentBrandList');
Route::post('getIngredentCategoryList', 'RNDController@getIngredentCategoryList')->name('getIngredentCategoryList');


Route::get('ingredent-add-supplier', 'RNDController@IngredentAddNew')->name('IngredentAddNew');
Route::get('ingredents-add-brand', 'RNDController@IngredentBrandAddNew')->name('IngredentBrandAddNew');
Route::get('add-ingredient', 'RNDController@addIngredetnView')->name('addIngredetnView');

Route::get('add-ingredient-category', 'RNDController@IngredentAddIngCat')->name('IngredentAddIngCat');


Route::post('getFinishProductList', 'RNDController@getFinishProductList')->name('getFinishProductList');
Route::post('saveFinishProduct', 'RNDController@saveFinishProduct')->name('saveFinishProduct');
Route::post('EditFinishProduct', 'RNDController@EditFinishProduct')->name('EditFinishProduct');
Route::get('view_teams_order/{users_id}', 'OrderController@view_teams_order')->name('view_teams_order');
Route::get('view_teams_client/{users_id}', 'OrderController@view_teams_client')->name('view_teams_client');





Route::get('add-finish-product', 'RNDController@addFinishProduct')->name('addFinishProduct');
Route::get('export-finish-product', 'RNDController@exportExcelFinishProduct')->name('exportExcelFinishProduct');
Route::post('importFinishProduct', 'RNDController@importFinishProduct')->name('importFinishProduct');



Route::get('new-product-development', 'RNDController@NewProductProductDevlopment')->name('NewProductProductDevlopment');
Route::post('saveNewProductDevelopment', 'RNDController@saveNewProductDevelopment')->name('saveNewProductDevelopment');

Route::get('new-product-list', 'RNDController@NewProductProductDevlopmentList')->name('NewProductProductDevlopmentList');





Route::get('Ingredients', 'RNDController@Ingredients')->name('rnd.ingredients');
Route::get('Ingredients-formulation', 'RNDController@IngredientsFormulation')->name('rnd.formulation');
Route::get('formulation-base', 'RNDController@FormulationBase')->name('FormulationBase');


Route::get('ingredients-formulation-with-base', 'RNDController@IngredientsFormulationWithBase')->name('IngredientsFormulationWithBase');
Route::get('getFormulationDataForBase', 'RNDController@getFormulationDataForBase')->name('getFormulationDataForBase');




Route::get('ingredients-formulation-edit/{fid}', 'RNDController@IngredientsFormulationEDIT')->name('IngredientsFormulationEDIT');
Route::get('formula-edit/{fid}', 'RNDController@FormulationEDITv1Base')->name('FormulationEDITv1Base');


Route::get('copy-ingredients-formulation/{fid}', 'RNDController@IngredientsFormulationCopy')->name('IngredientsFormulationCopy');
Route::get('copy-formula-base-formulation/{fid}', 'RNDController@FormulationCopyBasev1')->name('FormulationCopyBasev1');




Route::get('Ingredients-formulation-list', 'RNDController@IngredientsFormulationList')->name('rnd.formulationList');
Route::get('Ingredients-formulation-base-list', 'RNDController@IngredientsFormulationBaseList')->name('IngredientsFormulationBaseList');
Route::get('Ingredients-formulation-base-list-from', 'RNDController@IngredientsFormulationBaseListFrom')->name('IngredientsFormulationBaseListFrom');




Route::post('saveFormulaRND', 'RNDController@saveFormulaRND')->name('saveFormulaRND');
Route::post('saveEditFormulaRND', 'RNDController@saveEditFormulaRND')->name('saveEditFormulaRND');

Route::post('saveEditFormulaRNDv1', 'RNDController@saveEditFormulaRNDv1')->name('saveEditFormulaRNDv1');




Route::post('saveEditCopyFormulaRND', 'RNDController@saveEditCopyFormulaRND')->name('saveEditCopyFormulaRND');
Route::post('saveEditCopyFormulaRNDBaseV1', 'RNDController@saveEditCopyFormulaRNDBaseV1')->name('saveEditCopyFormulaRNDBaseV1');

//base formula 
Route::post('saveFormulaRNDBasev1', 'RNDController@saveFormulaRNDBasev1')->name('saveFormulaRNDBasev1');



Route::post('saveFormulaRND_Base', 'RNDController@saveFormulaRND_Base')->name('saveFormulaRND_Base');



Route::get('getIngreidentFirstPrice', 'RNDController@getIngreidentFirstPrice')->name('getIngreidentFirstPrice');
Route::get('sapUploadFile', 'RNDController@sapUploadFile')->name('sapUploadFile');
Route::get('getCostBaseFormula', 'RNDController@getCostBaseFormula')->name('getCostBaseFormula');







//rnd.formulation

Route::get('Ingredients-price', 'RNDController@ingredientsPrice')->name('ingredientsPrice');

Route::post('getIngredients', 'RNDController@getIngredients')->name('getIngredients');
Route::post('getIngredientsPrice', 'RNDController@getIngredientsPrice')->name('getIngredientsPrice');
Route::get('getRNDFormulataList', 'RNDController@getRNDFormulataList')->name('getRNDFormulataList');
Route::get('getRNDFormulataListView', 'RNDController@getRNDFormulataListView')->name('getRNDFormulataListView');

Route::get('getRNDFormulataListBase', 'RNDController@getRNDFormulataListBase')->name('getRNDFormulataListBase');
Route::get('getRNDFormulataListBaseFrom', 'RNDController@getRNDFormulataListBaseFrom')->name('getRNDFormulataListBaseFrom');




Route::get('rnd-ingrednts-formula/{id}', 'RNDController@rndINGFormula')->name('rndINGFormula');
Route::get('formula-base/{id}', 'RNDController@rndINGFormulav1')->name('rndINGFormulav1');
Route::get('formula-base-from/{id}', 'RNDController@rndINGFormulav1_FROM')->name('rndINGFormulav1_FROM');

Route::get('rnd-ingrednts-formula-base/{id}', 'RNDController@rndINGFormulaBase')->name('rndINGFormulaBase');


Route::get('rnd-ingrednts-formula-cost/{id}', 'RNDController@rndINGFormulaCost')->name('rndINGFormulaCost');
Route::get('rnd-ingrednts-formula-cost-base/{id}', 'RNDController@rndINGFormulaCostBase')->name('rndINGFormulaCostBase');




Route::post('deleteIngredient', 'RNDController@deleteIngredient')->name('deleteIngredient');


Route::post('getNewProductDevelopementList', 'RNDController@getNewProductDevelopementList')->name('getNewProductDevelopementList');



Route::post('ingredentsaveINGdata', 'RNDController@saveINGdata')->name('saveINGdata');
Route::post('saveINGBranddata', 'RNDController@saveINGBranddata')->name('saveINGBranddata');
Route::post('saveSapUploadData', 'RNDController@saveSapUploadData')->name('saveSapUploadData');
Route::post('saveRMToIngredent', 'RNDController@saveRMToIngredent')->name('saveRMToIngredent');



Route::post('saveINGBrand', 'RNDController@saveINGBrand')->name('saveINGBrand');
Route::post('saveINGCategorydata', 'RNDController@saveINGCategorydata')->name('saveINGCategorydata');

Route::post('UpdateINGCategorydata', 'RNDController@UpdateINGCategorydata')->name('UpdateINGCategorydata');


Route::post('updateINGBrand', 'RNDController@updateINGBrand')->name('updateINGBrand');




Route::post('updateINGdata', 'RNDController@updateINGdata')->name('updateINGdata');
Route::post('EditNewProductDevelopment', 'RNDController@EditNewProductDevelopment')->name('EditNewProductDevelopment');



Route::post('updateIngredientdata', 'RNDController@updateIngredientdata')->name('updateIngredientdata');

Route::post('getIngredentListID', 'RNDController@getIngredentListID')->name('getIngredentListID');
Route::post('getIngredentBrandListID', 'RNDController@getIngredentBrandListID')->name('getIngredentBrandListID');
Route::post('saveFinishCatSubCat', 'RNDController@saveFinishCatSubCat')->name('saveFinishCatSubCat');
Route::post('getFinishProductCAT', 'RNDController@getFinishProductCAT')->name('getFinishProductCAT');
Route::post('getFinishProductcatSubListData', 'RNDController@getFinishProductcatSubListData')->name('getFinishProductcatSubListData');



Route::get('edit-ing/{ingid}', 'RNDController@editING')->name('editING');
Route::get('edit-ing-category/{ingid}', 'RNDController@editINGCategory')->name('editINGCategory');

Route::get('edit-ingrednts/{ingid}', 'RNDController@editIngredent')->name('editIngredent');

Route::get('edit-ing-brand/{ingid}', 'RNDController@editBrandING')->name('editBrandING');

Route::get('edit-finish-product/{ingid}', 'RNDController@editINGFinishProduct')->name('editINGFinishProduct');
Route::get('edit-new-product/{ingid}', 'RNDController@editnNewProductList')->name('editnNewProductList');




Route::get('finishProductCategory', 'RNDController@finishProductCategory')->name('finishProductCategory');
Route::get('finishProductSubCategory', 'RNDController@finishProductSubCategory')->name('finishProductSubCategory');

Route::post('getAllLeadData', 'UserController@getAllLeadData')->name('getAllLeadData');
Route::post('getAllLeadDataALL', 'UserController@getAllLeadDataALL')->name('getAllLeadDataALL');
Route::post('getAllTicketDataID', 'UserController@getAllTicketDataID')->name('getAllTicketDataID');




Route::get('getAllLeadUntouch', 'UserController@getAllLeadUntouch')->name('getAllLeadUntouch');
Route::get('get-all-available-leads', 'UserController@getAllAvaibleLeadData')->name('getAllAvaibleLeadData');
Route::get('get-all-complains-list', 'UserController@getAllComplainList')->name('getAllComplainList');


Route::get('get-all-available-leads/{userid}', 'UserController@getAllAvaibleLeadDataUserID')->name('getAllAvaibleLeadDataUserID');






Route::post('getAllLeadDataPack', 'UserController@getAllLeadDataPack')->name('getAllLeadDataPack');

Route::post('getAllLeadData_OWNLEAD', 'UserController@getAllLeadData_OWNLEAD')->name('getAllLeadData_OWNLEAD');




Route::post('setReplayToTicket', 'UserController@setReplayToTicket')->name('setReplayToTicket');

Route::get('productPriceList', 'UserController@productPriceList')->name('productPriceList');
Route::get('userActivityList', 'UserController@userActivityList')->name('userActivityList');










Route::get('add-finish-product-cat-sub', 'RNDController@add_finish_product_cat')->name('add_finish_product_cat');
Route::get('add-finish-product-sub-category', 'RNDController@add_finish_product_subcat')->name('add_finish_product_subcat');


//Team 

Route::get('teams-view', 'TeamController@boteamList')->name('boteamList');
Route::get('add-new-team', 'TeamController@addNewteam')->name('addNewteam');
Route::get('myTeamList', 'TeamController@myTeamList')->name('myTeamList');
Route::get('IncentivePanel', 'TeamController@IncentivePanel')->name('IncentivePanel');
Route::get('RND-Incentive-View', 'TeamController@IncentivePanel_RND')->name('IncentivePanel_RND');



Route::get('MyIncentivePanel', 'TeamController@MyIncentivePanel')->name('MyIncentivePanel');

Route::post('setIncentiveApprovalStutus', 'TeamController@setIncentiveApprovalStutus')->name('setIncentiveApprovalStutus');

Route::post('getTeamMember', 'TeamController@getTeamMember')->name('getTeamMember');

Route::post('CreateMember', 'TeamController@CreateMember')->name('CreateMember');
Route::post('setTeamMember2member', 'TeamController@setTeamMember2member')->name('setTeamMember2member');
Route::post('moveTeamMember2member', 'TeamController@moveTeamMember2member')->name('moveTeamMember2member');





Route::post('/getTree',
'TeamController@getTree')->name('getTree');



//Team 









// Route::post('getEMPPic','UserController@getEMPPic')->name('getEMPPic');
Route::post('deleteING', 'RNDController@deleteING')->name('deleteING');
Route::post('deleteNewProductDev', 'RNDController@deleteNewProductDev')->name('deleteNewProductDev');



Route::post('deleteINGCategory', 'RNDController@deleteINGCategory')->name('deleteINGCategory');

Route::post('deleteINGBrand', 'RNDController@deleteINGBrand')->name('deleteINGBrand');
Route::post('deleteFinishProduct', 'RNDController@deleteFinishProduct')->name('deleteFinishProduct');

Route::post('setSPRange', 'RNDController@setSPRange')->name('setSPRange');
Route::post('getSampleFeedbackPIE', 'SampleController@getSampleFeedbackPIE')->name('getSampleFeedbackPIE');
Route::get('getPendingFormulationSampleList', 'SampleController@getPendingFormulationSampleList')->name('getPendingFormulationSampleList');
Route::post('updateRNDStatusNow', 'HomeController@updateRNDStatusNow')->name('updateRNDStatusNow');
Route::post('updateRNDStatusNowBase', 'HomeController@updateRNDStatusNowBase')->name('updateRNDStatusNowBase');




//call graph
Route::post('getLast7DaysTotalCallAvgCall', 'SampleController@getLast7DaysTotalCallAvgCall')->name('getLast7DaysTotalCallAvgCall');
Route::post('getLast7DaysTotalCallAvgCall_ARMChart', 'SampleController@getLast7DaysTotalCallAvgCall_ARMChart')->name('getLast7DaysTotalCallAvgCall_ARMChart');


Route::post('getLast30DaysRecievedMissedCall', 'SampleController@getLast30DaysRecievedMissedCall')->name('getLast30DaysRecievedMissedCall');


Route::post('getLast30DaysINOUT_knowlarity', 'SampleController@getLast30DaysINOUT_knowlarity')->name('getLast30DaysINOUT_knowlarity');
Route::post('updateSampleTrackingID', 'SampleController@updateSampleTrackingID')->name('updateSampleTrackingID');





Route::post('getThisMonthKnowlarityIN', 'SampleController@getThisMonthKnowlarityIN')->name('getThisMonthKnowlarityIN');
Route::post('getThisMonthKnowlarityOUT', 'SampleController@getThisMonthKnowlarityOUT')->name('getThisMonthKnowlarityOUT');
Route::post('getThisMonthBUYLEAD_API_DATA', 'SampleController@getThisMonthBUYLEAD_API_DATA')->name('getThisMonthBUYLEAD_API_DATA');
Route::post('getThisMonthKNOW_MissedRec_API_DATA', 'SampleController@getThisMonthKNOW_MissedRec_API_DATA')->name('getThisMonthKNOW_MissedRec_API_DATA');




Route::post('getLast30DaysRecievedOnlyCall', 'SampleController@getLast30DaysRecievedOnlyCall')->name('getLast30DaysRecievedOnlyCall');
Route::post('getLast30DaysAssignedQualifiedLead', 'SampleController@getLast30DaysAssignedQualifiedLead')->name('getLast30DaysAssignedQualifiedLead');
Route::post('getWeeklyRecivedMissed', 'SampleController@getWeeklyRecivedMissed')->name('getWeeklyRecivedMissed');
Route::post('getWeeklyRecivedMissed_1', 'SampleController@getWeeklyRecivedMissed_1')->name('getWeeklyRecivedMissed_1');

// sales
Route::post('getSalesClickCall', 'SampleController@getSalesClickCall')->name('getSalesClickCall');
Route::post('getSalesClickCallMonthwise', 'SampleController@getSalesClickCallMonthwise')->name('getSalesClickCallMonthwise');
Route::post('getSalesAllCallRecieved', 'SampleController@getSalesAllCallRecieved')->name('getSalesAllCallRecieved');
Route::post('getSalesAllCallRecievedMonth', 'SampleController@getSalesAllCallRecievedMonth')->name('getSalesAllCallRecievedMonth');


Route::post('setClicktoCallAgentCall', 'UserController@setClicktoCallAgentCall')->name('setClicktoCallAgentCall');
Route::post('setClicktoCallAgentCall_CLIENT', 'UserController@setClicktoCallAgentCall_CLIENT')->name('setClicktoCallAgentCall_CLIENT');






// sales
// incentive 

Route::post('setSaveIncentive', 'UserController@setSaveIncentive')->name('setSaveIncentive');
Route::post('setSaveIncentiveSlab', 'UserController@setSaveIncentiveSlab')->name('setSaveIncentiveSlab');
Route::get('view-incentive-eligibility', 'UserController@viewIncentiveEligibility')->name('viewIncentiveEligibility');
Route::post('incentiveApplied', 'UserController@incentiveApplied')->name('incentiveApplied');
Route::get('/view-incentive-details/{id}/{name}/{month}/{year}','TeamController@viewIncentiveEligibilityPanel')->name('viewIncentiveEligibilityPanel');
Route::get('/view-incentive-details-history/{id}/{name}/{incType}/{in_year}','TeamController@viewIncentiveEligibilityPanel_History')->name('viewIncentiveEligibilityPanel_History');
Route::get('/view-rnd-incentive-details-history/{id}/{name}/{incType}/{in_year}','TeamController@viewIncentiveEligibilityPanel_History_RND')->name('viewIncentiveEligibilityPanel_History_RND');

Route::get('/getMonthwiseOrderDetails/{user_id}/{month}/{year}','TeamController@getMonthwiseOrderDetails')->name('getMonthwiseOrderDetails');










// incentive 




Route::get('pagination/fetch_data', 'UserController@fetch_data');


//

















 //ajcode for new stage   http://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC6v5-2uaq_wusHDktM9ILcqIrlPtnZgEk&latlng=44.4647452,7.3553838&sensor=true
