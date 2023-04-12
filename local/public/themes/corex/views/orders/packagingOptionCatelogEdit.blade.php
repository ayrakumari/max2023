<!-- main  -->
<div class="m-content">
	<!--begin::Portlet-->
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Packaging Options Catalog EDIT
					</h3>
				</div>
			</div>
		</div>

		<!--begin::Form-->
		<?php

	 	$img_1 = asset('/local/public/uploads/photos') ."/". $poc_data->img_1;
		$img_2 = asset('/') . $poc_data->img_2;
		$img_3 = asset('/') . $poc_data->img_3;

		// echo "<pre>";
		// print_r($poc_data);
		// [id] => 1
		//     [poc_code] => PM0002
		//     [poc_name] => BOTTLE- 200ML AMBER SQUARE
		//     [poc_type] => 30
		//     [poc_material] => 30
		//     [poc_size] => 30
		//     [poc_color] => 30
		//     [poc_sape] => 32
		//     [img_1] => PM0002_20190806052406.jpg
		//     [img_2] => 
		//     [img_3] => 
		//     [created_by] => 84
		//     [is_active] => 1
		// 	[poc_price] => 

		?>

		<br>
		<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" action="{{route('saveOPCDataOnlyUpdate')}}" enctype="multipart/form-data">
			@csrf
			@if (Session::has('success'))
										<div class="alert alert-success" role="alert">
											{{Session::get('success')}}
										</div>
									@endif
									@if ($errors->any())
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
			<input type="hidden" name="pocID" value="{{$poc_data->id}}">

			<div class="m-portlet__body">

				<div class="form-group m-form__group row">
					<div class="col-lg-2">
						<label>Type:</label>

						<select name="type" id="txtPOCType" class="form-control">
							<option value="">-SELECT-</option>
							<?php
							$type_arr = AyraHelp::getBOMItemCategory();
							foreach ($type_arr as $key => $rowData) {

								if ($poc_data->poc_type == $rowData->id) {
									?>
								<option selected value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php

								} else {
							?>
									<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}
							}
							?>
						</select>
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-2">
						<label>Material:</label>

						<select name="material" id="txtPOCType" class="form-control">
							<option value="">-SELECT-</option>
							<?php
							$type_arr = AyraHelp::getBOMItemMaterial();
							foreach ($type_arr as $key => $rowData) {
								if ($poc_data->poc_material == $rowData->id) {
									?>
								<option selected value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}else{
									?>
								<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}
							

							}
							?>
						</select>
						<span class="m-form__help"></span>
					</div>

					<div class="col-lg-2">
						<label>Size:</label>

						<select name="size" id="txtPOCType" class="form-control">
							<option value="">-SELECT-</option>
							<?php
							$type_arr = AyraHelp::getBOMItemSize();
							foreach ($type_arr as $key => $rowData) {
								if ($poc_data->poc_size == $rowData->id) {
									?>
								<option selected value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php

								}else{
									?>
								<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}
							

							}
							?>
						</select>
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-2">
						<label>Color:</label>

						<select name="color" id="txtPOCType" class="form-control">
							<option value="">-SELECT-</option>
							<?php
							$type_arr = AyraHelp::getBOMItemColor();
							foreach ($type_arr as $key => $rowData) {
								if ($poc_data->poc_color == $rowData->id) {
									?>
								<option selected value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php

								}else{
									?>
								<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}
							

							}
							?>
						</select>
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-2">
						<label>Shape</label>

						<select name="sape" id="txtPOCType" class="form-control">
							<option value="">-SELECT-</option>
							<?php
							$type_arr = AyraHelp::getBOMItemSape();
							foreach ($type_arr as $key => $rowData) {
								if ($poc_data->poc_sape == $rowData->id) {
									?>	
								<option selected value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php

								}else{
									?>	
								<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>


							<?php
								}
							

							}
							?>
						</select>
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-2">
						<label>Name:</label>
						<input value="{{$poc_data->poc_name}}" type="text" name="name" class="form-control">

						<span class="m-form__help">

						</span>
					</div>
					<div class="col-lg-2">
						<label>POC CODE:</label>
						<input value="{{$poc_data->poc_code}}" type="text" name="poc_code" class="form-control">

						<span class="m-form__help">

						</span>
					</div>
					<div class="col-lg-2">
						<label>Price:</label>
						<input value="{{$poc_data->poc_price}}" type="text" name="poc_price" class="form-control">

						<span class="m-form__help">

						</span>
					</div>


				</div>

				<!-- <div class="form-group m-form__group row">
					<div class="col-lg-4">
						<label>Type:</label>
						<input type="text" id="txtPOCType" value="{{$poc_data->poc_type}}" name="type" class="form-control m-input" placeholder="Enter Type">
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-4">
						<label class="">Size:</label>
						<input type="text" id="txtPOCSize" value="{{$poc_data->poc_size}}" name="size" class="form-control m-input" placeholder="Enter Size">
						<span class="m-form__help"></span>
					</div>
					<div class="col-lg-4">
						<label class="">Name:</label>
						<input type="text" id="txtPOCName" value="{{$poc_data->poc_name}}" name="name" class="form-control m-input" placeholder="Enter Name">
						<span class="m-form__help"></span>
					</div>

				</div> -->

				<div class="form-group m-form__group row">
					<div class="col-lg-8">
						<div class="form-group m-form__group">
							<label for="exampleInputEmail1">Photo Browser</label>
							<div></div>
							<div class="custom-file">
								<input type="file" name="file_1" class="custom-file-input" id="customFile">
								<label class="custom-file-label" for="customFile">Choose photo</label>

							</div>
						</div>

					</div>
					<div class="col-lg-4">

						<a href="{{$img_1}}" target="_blank" style="margin-top:31px" class="btn btn-outline-primary btn-sm 	m-btn m-btn--icon">
							<span>
								<i class="la la-eye"></i>
								<span>VIEW</span>
							</span>
						</a>
						<img width="150px" height="auto" src="{{$img_1}}">


					</div>
				</div>

				<br>
				<div class="form-group m-form__group row">
					<div class="col-lg-8">
						<div class="form-group m-form__group">
							<label for="exampleInputEmail1">Photo Browser</label>
							<div></div>
							<div class="custom-file">
								<input type="file" name="file_1" class="custom-file-input" id="customFile">
								<label class="custom-file-label" for="customFile">Choose photo</label>
							</div>
						</div>

					</div>
					<div class="col-lg-4">
						<a href="{{$img_2}}" target="_blank" style="margin-top:31px" class="btn btn-outline-primary btn-sm 	m-btn m-btn--icon">
							<span>
								<i class="la la-eye"></i>
								<span>VIEW</span>
							</span>
						</a>
						<img width="150px" height="auto" src="{{$img_2}}">


					</div>
				</div>

				<br>

				<div class="form-group m-form__group row">
					<div class="col-lg-8">
						<div class="form-group m-form__group">
							<label for="exampleInputEmail1">Photo Browser</label>
							<div></div>
							<div class="custom-file">
								<input type="file" name="file_1" class="custom-file-input" id="customFile">
								<label class="custom-file-label" for="customFile">Choose photo</label>

							</div>
						</div>

					</div>
					<div class="col-lg-4">

						<a href="{{$img_3}}" target="_blank" style="margin-top:31px" class="btn btn-outline-primary btn-sm 	m-btn m-btn--icon">
							<span>
								<i class="la la-eye"></i>
								<span>VIEW</span>
							</span>
						</a>
						<img width="150px" height="auto" src="{{$img_3}}">


					</div>
				</div>



			</div>

			<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
				<div class="m-form__actions m-form__actions--solid">
					<div class="row">
						<div class="col-lg-4"></div>
						<div class="col-lg-8">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-secondary">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!--end::Form-->
	</div>

	<!--end::Portlet-->
</div>
<!-- main  -->