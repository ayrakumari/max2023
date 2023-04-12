<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
					Sample :Technical Document Request
					</h3>

				</div>
			</div>  
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<!-- <li class="m-portlet__nav-item">
						@can('add-samples')
						<a href="{{route('sampleAddTechinalDocument')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
							<span>
								<i class="la la-plus"></i>
								<span>Add New Request </span>
							</span>
						</a>
						@endcan
					</li> -->
					<li class="m-portlet__nav-item">
						<a href="javascript::void(0)" onclick="goBack()" class="btn btn-accent m-btn m-btn--custom m-btn--icon">
							<span>
								<i class="la la-left"></i>
								<span>BACK </span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<!-- Docuement  -->




			<!--begin::Form-->
			<form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_sampleTechSubmit">
				<div class="m-portlet__body">
					<div class="m-form__section m-form__section--first">
					@csrf
						<div class="form-group m-form__group row">
							<div class="col-lg-6">
								<label class="form-control-label">*<b> Select Sample ID:</b></label>
								<select class="form-control m-select2 showSampleItemTechDataSelect" id="m_select2_1_technical" name="sample_id">
								<option value="">-SELECT-</option>

									<?php
									  $user = auth()->user();
									  $userRoles = $user->getRoleNames();
									  $user_role = $userRoles[0];

									if($user_role=='Admin' || $user_role=='SalesHead'){
										//$samples = DB::table('samples')->where('is_deleted', 0)->where('status', 2)->where('sample_type','!=',2)->orderBy('id', 'desc')->get();
										$samples = DB::table('samples')->where('is_deleted', 0)->orderBy('id', 'desc')->get();

									}else{
										//$samples = DB::table('samples')->where('created_by',Auth::user()->id)->where('is_deleted', 0)->where('sample_type','!=',2)->orderBy('id', 'desc')->where('status', 2)->get();
										//$samples = DB::table('samples')->where('created_by',Auth::user()->id)->where('is_deleted', 0)->orderBy('id', 'desc')->where('status', 2)->get();
										$samples = DB::table('samples')->where('created_by',Auth::user()->id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

									}
									
									foreach ($samples as $key => $rowData) {
									?>
										<option value="{{$rowData->sample_code}}">{{$rowData->sample_code}}</option>
									<?php
									}
									?>
									<option value="9999999">Standard</option>
								</select>
							</div>
							<div class="col-lg-6">
								<!-- <label class="form-control-label">* Details:</label> -->

							</div>
						</div>
						<div class="form-group m-form__group row">
							<div class="col-lg-12">
								<label class="form-control-label">* <b>Select or Enter Items:</b></label>
								<div class="m-form__group form-group showSampleItemTechData">

									

								</div>

							</div>
						</div>


						<div class="form-group m-form__group row">
							<div class="col-lg-12">
								<label class="form-control-label">*<b> Select Requirement:</b></label>
								<div class="m-form__group form-group">

									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input  value="1" name="sampleTechRequirement[]" type="checkbox"> Ingredients
											<span></span>
										</label>
										<label class="m-checkbox">
											<input value="2" name="sampleTechRequirement[]"  type="checkbox"> COA
											<span></span>
										</label>
										<label class="m-checkbox">
											<input value="3" name="sampleTechRequirement[]"  type="checkbox"> MSDS
											<span></span>
										</label>
									</div>

								</div>

							</div>
						</div>

						<div class="form-group m-form__group row">
							<div class="col-lg-12">
							<label for="exampleTextarea">Remarks</label>
							<textarea class="form-control m-input" id="exampleTextarea" name="sampletechRemarks" rows="2"></textarea>
							</div>
						</div>




					</div>

				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-12">
								<button type="submit" id="btnSampleTechSubmit" disabled class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-secondary">Reset</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!--end::Form-->


			<!--end::Portlet-->

			<!-- Docuement  -->
		</div>
	</div>
	<!-- datalist -->
</div>
<!-- main  -->
<!-- modal -->
<!-- Modal -->