<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<!--Begin::Section-->
		<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Incentive Details RND :: <span style="color:#035496">{{AyraHelp::getUser( Request::segment(2))->name}}</span>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="m-widget5">
					<div class="m-widget5__item">
						<div class="m-widget5__content">
							<table class="table table-bordered m-table m-table--border-success">
								<thead>
									<tr>
										<th>#</th>
										<th>Client</th>
										<th>Item Name</th>
										<th>Order ID</th>
										<th>Dispatch Date </th>
										<th>Sample No</th>
										<th>Brand Type</th>
										<th>Order Type</th>
										<th>Incentive Amt</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php
									$user_id = Request::segment(2);
									$monNum = Request::segment(3);
									$monYear = Request::segment(5);


									$dispatchData = DB::table('order_dispatch_data')
										->whereMonth('dispatch_on', $monNum)
										->whereYear('dispatch_on', $monYear)
										->get();
									$i = 0;
									$totAmt=0;
									foreach ($dispatchData as $key => $rowData) {
										



										$qc_formsArrData = DB::table('qc_forms')
											->where('form_id', $rowData->form_id)
											->first();
										if ($qc_formsArrData->item_fm_sample_no == "Regular" || $qc_formsArrData->item_fm_sample_no == "Standard") {
										} else {

											if (@$qc_formsArrData->chemist_id == $user_id) {
												$i++;

												$client_arr = AyraHelp::getClientbyid($qc_formsArrData->client_id);
												$clientId = optional($client_arr)->company . " | " . optional($client_arr)->brand;
												$disDate = date('j-M-y', strtotime($rowData->dispatch_on));

												$sampleItemArr = DB::table('sample_items')
													->where('sid_partby_code', 'LIKE', "%{$qc_formsArrData->item_fm_sample_no}")
													->first();
												$brandStr = "";
												if ($sampleItemArr == null) {
													\DB::connection()->enableQueryLog();
													$sampleItemArrXcode = DB::table('samples')
														->where('sample_code', 'LIKE', "%{ substr($qc_formsArrData->item_fm_sample_no, 0, 11)}")
														->first();
													$queries = \DB::getQueryLog();

													$smType = @$sampleItemArrXcode->brand_type;


													switch ($smType) {

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
												} else {
													$sampleItemArrORI = DB::table('samples')
														->where('id', $sampleItemArr->sid)
														->first();
													$amt = 0;
													$smType = @$sampleItemArrORI->brand_type;


													switch ($smType) {

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
												}

												//$Rcode=$qc_formsArrData->order_type_v1."_".@$smType;
												$Rcode = @$smType . "_" . @$qc_formsArrData->order_type_v1;
												switch ($qc_formsArrData->order_type_v1) {
													case 1:
														# code...
														$strOrd = "NEW";
														break;

													case 2:
														# code...
														$strOrd = "REPEAT";
														break;
													case 3:
														# code...
														$strOrd = "ADDITION";
														break;
												}

												$rndPriceCode = DB::table('rnd_price_matrix')
													->where('code_x', $Rcode)
													->first();


												// echo $qc_formsArrData->form_id."-".$user_id."<br>";
												if ($qc_formsArrData->order_type == "Private Label") {
													$imName = $qc_formsArrData->item_name;
												} else {

													$bulkOrder = DB::table('qc_bulk_order_form')
														->where('form_id', $qc_formsArrData->form_id)
														->whereNotNull('item_name')
														->get();
														foreach ($bulkOrder as $key => $row) {
															$imName .=$row->item_name;
														  }



												}
												$totAmt=intVal($totAmt)+intVal($rndPriceCode->price)
									?>
												<tr>
													<td>{{$i}}</td>
													<td>{{$clientId}}</td>
													<td>{{$imName}}</td>
													<td>{{$qc_formsArrData->order_id}}/{{$qc_formsArrData->subOrder}}</td>

													<td>{{$disDate}}</td>
													<td> {{$qc_formsArrData->item_fm_sample_no}}</td>
													<td>{{$brandStr}}</td>
													<td>{{$strOrd}}</td>
													<!-- <td>{{@$rndPriceCode->price}} ($Rcode)</td> -->
													<td>{{@$rndPriceCode->price}} </td>
													<td></td>
													
												</tr>

												

									<?php
									// MAcKwjs3RFGWESxs8XgQ

											}
											
										}
										
									}
									?>
											<tr>
													<td colspan="8">Total Amount:</td>													
													<td>{{$totAmt}}</td>
													
												</tr>
											<?php





									// $s_date = $monYear . "-" . $monNum . "-1";

									// // echo $row['uid'];
									// $start_date = date("Y-m-1", strtotime($s_date));

									// $end_date = date("Y-m-t", strtotime($s_date));

									?>

								</tbody>
							</table>



						</div>
						<div class="m-widget5__content">

						</div>
					</div>

				</div>

			</div>
		</div>

	</div>
	<!-- datalist -->
</div>
<!-- main  -->