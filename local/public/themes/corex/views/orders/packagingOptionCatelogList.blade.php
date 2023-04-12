<div class="m-content">

	<div class="m-portlet m-portlet--mobile">

		<div class="m-portlet__body">
			<!--begin: Search Form -->
			<div class="row m--margin-bottom-20">
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Type:</label>
					<select name="type" id="poc_type" class="form-control">
						<option value="">-SELECT-</option>
						<?php
						$type_arr = AyraHelp::getBOMItemCategory();
						foreach ($type_arr as $key => $rowData) {

						?>
							<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>

						<?php

						}
						?>
					</select>
				</div>
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Material:</label>

					<select name="material" id="poc_material" class="form-control">
						<option value="">-SELECT-</option>
						<?php
						$type_arr = AyraHelp::getBOMItemMaterial();
						foreach ($type_arr as $key => $rowData) {

						?>
							<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


						<?php

						}
						?>
					</select>
				</div>
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Size:</label>

					<select name="size" id="poc_size" class="form-control">
						<option value="">-SELECT-</option>
						<?php
						$type_arr = AyraHelp::getBOMItemSize();
						foreach ($type_arr as $key => $rowData) {

						?>
							<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


						<?php

						}
						?>
					</select>
				</div>
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Color:</label>
					<select name="color" id="txtPOCColorN" class="form-control">
						<option value="">-SELECT-</option>
						<?php
						$type_arr = AyraHelp::getBOMItemColor();
						foreach ($type_arr as $key => $rowData) {

						?>
							<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


						<?php

						}
						?>
					</select>

				</div>
			</div>
			<div class="row m--margin-bottom-20">
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Shape</label>

					<select name="sape" id="txtPOCSapeN" class="form-control">
						<option value="">-SELECT-</option>
						<?php
						$type_arr = AyraHelp::getBOMItemSape();
						foreach ($type_arr as $key => $rowData) {
						?>
							<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>

						<?php
						}
						?>
					</select>
				</div>
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<label>Name:</label>
					<input type="text" name="name" id="txtPOCN" class="form-control">
					<span class="m-form__help"></span>
				</div>
				<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
					<button style="margin-top:26px;" class="btn btn-brand m-btn m-btn--icon" id="m_search_POC">
						<span>
							<i class="la la-search"></i>
							<span>Search</span>
						</span>
					</button>
					<button style="margin-top:26px;" class="btn btn-secondary m-btn m-btn--icon" id="m_reset_POC">
						<span>
							<i class="la la-close"></i>
							<span>Reset</span>
						</span>
					</button>
				</div>
			</div>
			<div class="m-separator m-separator--md m-separator--dashed"></div>



			<!-- ajcodefornewlayout -->
			<!--Begin::Section-->
			<style>
				.m-widget19 .m-widget19__content {
					margin-bottom: -1rem;
				}
			</style>
			<div class="row ajrowFilter">


				<?php
				$datas = AyraHelp::getAllPOCData();
				if (isset($datas)) {

					foreach ($datas as $key => $rowData) {
						$img = asset('/local/public/uploads/photos/') . "/" . $rowData->img_1;;
						$poc_type_arr = AyraHelp::getBOMItemCategoryID($rowData->poc_type);
						$poc_material_arr = AyraHelp::getBOMItemMaterialID($rowData->poc_material);
						$poc_size_arr = AyraHelp::getBOMItemSizeID($rowData->poc_size);
						$poc_color_arr = AyraHelp::getBOMItemColorID($rowData->poc_color);
						$poc_sape_arr = AyraHelp::getBOMItemSapeID($rowData->poc_sape);

				?>


						<div class="col-md-3" id="ajFileyrt">
							<!--begin:: Widgets/Blog-->
							<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force">
								<div class="m-portlet__head m-portlet__head--fit">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-action">

										</div>
									</div>
								</div>

								<div class="m-portlet__body">
									<div class="m-widget19">
										<a href="javascript::void(0)" onclick="showMeSlide({{$rowData->id}})">
											<div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px;border:1px solid #f1f1f1">
												<img src="{{$img}}" alt="" style="display: block;width: 100%;height: 80%">

											</div>
										</a>


										<div class="m-widget19__content">
											<!-- data -->
											<div class="m-widget29">

												<div class="m-widget19__info" style="margin-top:10px">
													<span class="m-widget19__username">
														{{$rowData->poc_code}}
														<b>{{$rowData->poc_name}}</b>

													</span><br>
													<span class="m-widget19__time">
														{{$poc_type_arr->cat_name}},{{$poc_material_arr->cat_name}},{{$poc_size_arr->cat_name}},<br>{{$poc_color_arr->cat_name}}
														, {{$poc_sape_arr->cat_name}}
													</span>
													<span class="m-widget19__time">														
														<br>Price:₹ <b style="color:#035496">{{$rowData->poc_price}}</b>
													</span>
												</div>
												<?php
												if (Auth::user()->id == 85 || Auth::user()->id == 1) {
												?>
													<!-- <a href="javascript::void(0)"  class="" style="color:brown;text-decoration:none">
															<span onclick="deletePOC({{$rowData->id}})">
															Delete
																
															</span>
														</a> -->
													<a href="{{route('editPOC',$rowData->id)}}" class="" style="text-decoration:block">
														<span >
															Edit

														</span>
													</a>
												<?php
												}
												?>






											</div>
											<!-- data -->
										</div>

									</div>
								</div>
							</div>
						</div>

				<?php
					}
				}
				?>


				{{-- ajaycode  --}}
				<!-- this will hold all the data -->
				<!-- loading image -->
				<!-- <div id="loader_image"><img src="https://www.tankfacts.com/ajaxloader/340.gif" alt="" width="24" height="24"> Loading...please wait</div>
						
							<div id="loader_message"></div> -->
				{{-- ajaycode  --}}

			</div>

			<!--End::Section-->

			<!-- ajcodefornewlayout -->




		</div>
	</div>

	<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
</div>



<!--begin::Modal-->
<div class="modal fade" id="m_modal_4_SlideShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- ajacode -->
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					</ol>
					<div class="carousel-inner ajslideMe">

					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>


				<!-- ajacode -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Select</button>
			</div>
		</div>
	</div>
</div>
<!--end::Modal-->