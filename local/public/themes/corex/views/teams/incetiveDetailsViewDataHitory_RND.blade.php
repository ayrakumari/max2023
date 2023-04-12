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
										<th>Brnad</th>
										<th>Order Item Name</th>
										<th>Order ID</th>
										<th>Invoice Date </th>
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
									 $monNum = intVal(Request::segment(3));
									  $monYear = intVal(Request::segment(5)); 



									$dataArr = DB::table('rnd_incentives_list')
										// ->where('inc_year','2022')
										// ->where('inc_month',$monNum)
										->where('user_id', $user_id)
										->where('in_month',$monNum)
										->where('in_year',$monYear)
										->get();
										
									$i = 0;
									$amt = 0;
										$totAmt=0;
									foreach ($dataArr as $key => $row) {
										$i++;

										$brandStr="";
										switch ($row->sample_brand_type) {

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
										$qc_formsArrData = DB::table('qc_forms')
										->where('form_id', $row->form_id)
										->first();

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
										
										$smType = @$row->sample_brand_type;

										$Rcode = @$smType . "_" . @$qc_formsArrData->order_type_v1;
										$rndPriceCode = DB::table('rnd_price_matrix')
													->where('code_x', $Rcode)
													->first();

										$totAmt=intVal($totAmt)+intVal(@$rndPriceCode->price);

										$affected = DB::table('rnd_incentives_list')
										->where('id', $row->id)
										->update(['incentive_amt' => @$rndPriceCode->price]);

									?>
									<tr>
										<td>{{$i}}</td>
										<td>{{$row->brand_name}}</td>
										<td>{{$row->order_item_name}}</td>
										<td>{{$row->order_id}}</td>
										<td>{{date('j-M-y',strtotime($row->invoice_date))}}</td>
										<td>{{$row->sample_no}}</td>
										<td>{{$brandStr}}</td>
										<td>{{$strOrd}}</td>
										<td>{{@$rndPriceCode->price}}</td>
										<td></td>
										</tr>
									<?php
									}

									?>
									<tr>
											<td colspan="8">Total Amount:</td>													
											<td>{{$totAmt}}</td>
											
										</tr>
									<?php


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