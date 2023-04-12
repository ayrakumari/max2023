

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
													Packaging Options Catalog Add
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
                                    <br>
									<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" action="{{route('saveOPCDataOnly')}}" enctype="multipart/form-data">
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

									

										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-lg-2">
													<label>Type:</label>												
													
													<select name="type" id="txtPOCType" class="form-control">
													<option value="">-SELECT-</option>
													<?php 
													$type_arr=AyraHelp::getBOMItemCategory();
													foreach ($type_arr as $key => $rowData) {
														
														?>
														<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
														

														<?php

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
													$type_arr=AyraHelp::getBOMItemMaterial();
													foreach ($type_arr as $key => $rowData) {
														
														?>
														<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
														

														<?php

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
													$type_arr=AyraHelp::getBOMItemSize();
													foreach ($type_arr as $key => $rowData) {
														
														?>
														<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
														

														<?php

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
													$type_arr=AyraHelp::getBOMItemColor();
													foreach ($type_arr as $key => $rowData) {
														
														?>
														<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
														

														<?php

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
													$type_arr=AyraHelp::getBOMItemSape();
													foreach ($type_arr as $key => $rowData) {
														
														?>
														<option value="{{$rowData->id}}">{{$rowData->cat_name}}</option>
														

														<?php

													}
													?>
													</select>
													<span class="m-form__help"></span>
												</div>
												<div class="col-lg-2">
													<label>Name:</label>
													<input type="text" name="name" class="form-control">																								
												
													<span class="m-form__help">
													
													</span>
												</div>
												<div class="col-lg-2">
													<label>POC CODE:</label>
													<input type="text" name="poc_code" class="form-control">																								
												
													<span class="m-form__help">
													
													</span>
												</div>
												<div class="col-lg-2">
													<label>Price:</label>
													<input type="text" name="poc_price" class="form-control">																								
												
													<span class="m-form__help">
													
													</span>
												</div>

												
											</div>
											<div class="form-group m-form__group row">
												<div class="col-lg-12">
													<div class="form-group m-form__group">
													<label for="exampleInputEmail1">Photo Browser</label>
													<div></div>
													<div class="custom-file">
														<input type="file" name="file_1" class="custom-file-input" id="customFile">
														<label class="custom-file-label" for="customFile">Choose photo</label>
													</div>
													</div>

												</div>
											</div>
											<div class="form-group m-form__group row">
												<div class="col-lg-12">
													<div class="form-group m-form__group">
													<label for="exampleInputEmail1">Photo Browser</label>
													<div></div>
													<div class="custom-file">
														<input type="file" name="file_2" class="custom-file-input" id="customFile">
														<label class="custom-file-label" for="customFile">Choose photo</label>
													</div>
													</div>

												</div>
											</div>
											<div class="form-group m-form__group row">
												<div class="col-lg-12">
													<div class="form-group m-form__group">
													<label for="exampleInputEmail1">Photo Browser</label>
													<div></div>
													<div class="custom-file">
														<input type="file" name="file_3" class="custom-file-input" id="customFile">
														<label class="custom-file-label" for="customFile">Choose photo</label>
													</div>
													</div>

												</div>
											</div>
											
											
										</div>
										<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
											<div class="m-form__actions m-form__actions--solid">
												<div class="row">
													<div class="col-lg-4"></div>
													<div class="col-lg-8">
														<button type="submit"  class="btn btn-primary">Submit</button>
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

