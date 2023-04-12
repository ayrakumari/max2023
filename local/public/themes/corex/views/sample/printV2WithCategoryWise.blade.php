<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Print Preview
						<?php
					
						// echo "<pre>"; 
						// print_r($sample_data);
						// die;
						?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="javascript::void(0)" id="btnPrintSampleX" class="btn btn-info  m-btn--custom m-btn--icon">
							<span>
								<i class="la la-print"></i>
								<span>PRINT</span>
							</span>
						</a>
					</li>
					<li class="m-portlet__nav-item"></li>
					<style type="text/css">
						body,
						div,
						table,
						thead,
						tbody,
						tfoot,
						tr,
						th,
						td,
						p {
							font-family: "Liberation Sans";
							font-size: x-small
						}

						a.comment-indicator:hover+comment {
							background: #ffd;
							position: absolute;
							display: block;
							border: 1px solid black;
							padding: 0.5em;
						}

						a.comment-indicator {
							background: red;
							display: inline-block;
							border: 1px solid black;
							width: 0.5em;
							height: 0.5em;
						}

						comment {
							display: none;
						}
					</style>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			
			<div id="div_printmeX">

				<table cellspacing="0" border="0">
					<colgroup width="104"></colgroup>
					<colgroup width="140"></colgroup>
					<colgroup width="115"></colgroup>
					<colgroup width="94"></colgroup>
					<colgroup width="85"></colgroup>
					<colgroup width="97"></colgroup>
					<colgroup width="94"></colgroup>
					<colgroup width="164"></colgroup>
					<tr>
						<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=8 height="18" align="center" valign=middle bgcolor="#CCCCCC">SAMPLE LIST:{{date('j-F-Y H:iA')}} </td>
					</tr>

				<!-- admin urgert  -->
				<?php foreach ($sample_arr_Admin as $key => $value) : ?>
						<?php







						$samplesDataArr = DB::table('samples')
							->where('id', $value->id)
							->first();
						$clientDataArr = DB::table('clients')
							->where('id', $samplesDataArr->client_id)
							->first();

						$brandStr = "";
						switch (@$samplesDataArr->brand_type) {
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
						$orderStr = "";
						switch (@$samplesDataArr->order_size) {
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
						
						$sampleID = $value->id;
						
						//brand 5 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							// ->where('brand_type', 5)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>8Brand:</b><br>{{@$clientDataArr->brand}}(**)</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{$brandStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 5 end





						?>






					<?php endforeach; ?>
				<!-- admin urgert  -->

				
					<?php foreach ($sample_data as $key => $value) : ?>
						<?php







						$samplesDataArr = DB::table('samples')
							->where('id', $value->id)
							->first();
						$clientDataArr = DB::table('clients')
							->where('id', $samplesDataArr->client_id)
							->first();

						$brandStr = "";
						switch (@$samplesDataArr->brand_type) {
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
						$orderStr = "";
						switch (@$samplesDataArr->order_size) {
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
						
						$sampleID = $value->id;

						//brand 5 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 5)
							->where('admin_status','!=',1)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>Brand:</b><br>{{@$clientDataArr->brand}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{$brandStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
							<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 5 end



						//brand 4 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 4)
							->where('admin_status','!=',1)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>Brand:</b><br>{{ucwords(@$clientDataArr->brand)}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{ucwords($brandStr)}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{ucwords(AyraHelp::getUser($samplesDataArr->created_by)->name)}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 4 end


						//brand 3 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 3)
						->where('admin_status','!=',1)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>Brand:</b><br>{{@$clientDataArr->brand}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{$brandStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 3 end

						//brand 2 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 2)
							->where('admin_status','!=',1)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>Brand:</b><br>{{@$clientDataArr->brand}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{$brandStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 2 end

						//brand 1 
						$samplesDataItemArr = DB::table('sample_items')
							->where('sid', $sampleID)
							->where('sample_v', 2)
							->where('is_formulated', 0)
							->where('sample_cat_id', $sample_cat_id)
							->where('brand_type', 1)
							->where('admin_status','!=',1)
							->get();
							$i=0;
						if (count($samplesDataItemArr) > 0) {
							$i++;
						?>
							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 height="17" align="center" valign=middle><b>Brand:</b><br>{{@$clientDataArr->brand}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Brand Type:</b><br>{{$brandStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Order Value</b><br>{{$orderStr}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Date</b><br>{{date('j-M-y',strtotime($samplesDataArr->created_at))}}</td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Created By:</b><br>{{AyraHelp::getUser($samplesDataArr->created_by)->name}}</td>
							</tr>
							<?php


							foreach ($samplesDataItemArr as $key => $rowData) {
							?>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="47" align="center" valign=middle><b>SID:</b><br>{{@$rowData->sid_partby_code}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Name:</b><br>{{ucwords(@$rowData->item_name)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Category:</b><br>{{ucwords(@$rowData->sample_cat)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Sub Category:</b><br>{{@$rowData->sample_sub_cat}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Colour:</b><br>{{ ucwords(@$rowData->sample_color)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" align="center" valign=middle><b>Fragrance:</b><br>{{ucwords(@$rowData->sample_fragrance)}}</td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=2 align="center" valign=middle><b>Target Price:</b><br>{{@$rowData->price_per_kg}} /KG</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Descriptions:</b></td>
									<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="left" valign=middle>{{ucwords(@$rowData->item_info)}} </td>
								</tr>
							<?php
							}
							?>

							<tr>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" height="17" align="left"><b>Notes:</b></td>
								<td style="border-top: 1px solid #333333; border-bottom: 1px solid #333333; border-left: 1px solid #333333; border-right: 1px solid #333333" colspan=7 align="center" valign=middle><br>{{@$samplesDataArr->remarks}}</td>
							</tr>
							<tr>
								<td height="6" colspan="6"></td>
							</tr>
						<?php

						}
						//brnad 1 end

						?>






					<?php endforeach; ?>

				</table>




			</div>



		</div>
	</div>
</div>
<!-- main  -->