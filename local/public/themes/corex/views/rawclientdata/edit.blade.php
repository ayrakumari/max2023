
<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">Raw Data Edit</h3>
								<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
									<li class="m-nav__item m-nav__item--home">
										<a href="/" class="m-nav__link m-nav__link--icon">
											<i class="m-nav__link-icon la la-home"></i>
										</a>
									</li>
									<li class="m-nav__separator">-</li>
									<li class="m-nav__item">
										<a href="" class="m-nav__link">
											<span class="m-nav__link-text">raw data</span>
										</a>
									</li>

									<li class="m-nav__separator">-</li>
									<li class="m-nav__item">
											<span class="m-nav__link-text">Edit</span>
									</li>
								</ul>
							</div>
						</div>
					</div>

          <!-- main  -->
          <div class="m-content">

						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
																	Raw Data Edit
																</h3>
															</div>
														</div>
														<div class="m-portlet__head-tools">
															<ul class="m-portlet__nav">
																<li class="m-portlet__nav-item">
																	<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
																		<span>
																			<i class="la la-cart-plus"></i>
																			<span>Add New </span>
																		</span>
																	</a>
																</li>





															</ul>
														</div>
													</div>
													<div class="m-portlet__body">
														<!--begin::Form-->

										<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" action="{{ route('rawclientdata.update', $raw_data->id) }}" id="frm_edit_raw_data">
											@method('PATCH')
	        						@csrf
											<input type="hidden" id="rowid_edit" name="rowid" value="{{$raw_data->id}}">
											<div class="m-portlet__body">
												<div class="form-group m-form__group row">
													<div class="col-lg-4">
														<label>Product:</label>
														<input type="text" name="product" class="form-control m-input" value ="{{$raw_data->product}}" placeholder="Enter product">
														<span class="m-form__help"></span>
													</div>
													<div class="col-lg-4">
														<label class="">Company:</label>
														<input type="text" name="company" class="form-control m-input" value="{{$raw_data->company_name}}" placeholder="Enter Company">
														<span class="m-form__help"></span>
													</div>
													<div class="col-lg-4">
														<label>Location:</label>
														<div class="input-group m-input-group m-input-group--square">
															<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
															<input type="text" name="location" class="form-control m-input" value="{{$raw_data->location }}" placeholder="">
														</div>
														<span class="m-form__help"></span>
													</div>
												</div>
												<div class="form-group m-form__group row">
													<div class="col-lg-4">
														<label class="">Contact:</label>
														<input type="text" name="contact" value="{{$raw_data->contact_no }}" class="form-control m-input" placeholder="Enter contact number">
														<span class="m-form__help"></span>
													</div>
													<div class="col-lg-4">
														<label class="">Website:</label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" name="website" class="form-control m-input" value="{{$raw_data->website }}" placeholder="Enter Website">
															<span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-info-circle"></i></span></span>
														</div>
														<span class="m-form__help"></span>
													</div>
													<div class="col-lg-4">
														<label>Application:</label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" name="application" class="form-control m-input" value="{{$raw_data->application }}" placeholder="Enter your application">
															<span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
														</div>
														<span class="m-form__help"></span>
													</div>
												</div>
												<div class="form-group m-form__group row">


													<div class="col-lg-4">
														<label>Status:</label>

														<div class="m-input-icon m-input-icon--right">
															<select class="form-control m-input form-control-sm" id="exampleSelect1" name="group_status">
															<option {{ $raw_data->group_status==1 ? 'selected':'' }} value="1">RAW</option>
															<option {{ $raw_data->group_status==2 ? 'selected':'' }} value="2">LEAD</option>
															<option {{ $raw_data->group_status==3 ? 'selected':'' }} value="3">QUALIFIED</option>
															<option {{ $raw_data->group_status==4 ? 'selected':'' }} value="4">SAMPLING</option>
															<option {{ $raw_data->group_status==5 ? 'selected':'' }} value="5">CUSTOMER</option>
															<option {{ $raw_data->group_status==6 ? 'selected':'' }} value="6">LOST</option>

															</select>
															<span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-map-marker"></i></span></span>
														</div>
														<span class="m-form__help"></span>
													</div>
												</div>

											</div>
											<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
												<div class="m-form__actions m-form__actions--solid">
													<div class="row">
														<div class="col-lg-4"></div>
														<div class="col-lg-8">
															<button type="submit" class="btn btn-primary">Save changes</button>
															<button type="reset" class="btn btn-secondary">Reset</button>
														</div>
													</div>
												</div>
											</div>
										</form>

										<!--end::Form-->
		</div>
	</div>

	</div>
          <!-- main  -->
