<!-- main  -->
<div class="m-content">
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Technical Questions
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{route('FAQAboutIngredent')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
							<span>
								<i class="la la-cart-plus"></i>
								<span>Add New</span>
							</span>
						</a>
					</li>
					<li class="m-portlet__nav-item"></li>
					<li class="m-portlet__nav-item">
						<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
							<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
								<i class="la la-ellipsis-h m--font-brand"></i>
							</a>

						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_FAQList">
				<thead>
					<tr>
						<th>Record ID</th>
						<th>Date</th>
						<th>Question</th>
						<th>Product Name</th>
						<th>Asked By</th>
						<th>Answers</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>




	<!-- datalist -->

	<!-- datalist -->
</div>
<!-- main  -->



<!--begin::Modal-->
<div class="modal fade" id="m_select2_modal_FAQ_detail" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Questions Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>
			</div>
			<div class="modal-body ">
			<div class="showFAQQuestionDetails">
			</div>
				
				<form id="m_form_add_FAQ" method="post" action="{{route('saveFAQAnwers')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
					@csrf
					<input type="hidden" id="txtfaqID" name="txtfaqID">
						<div class="form-group m-form__group row">
							<div class="col-lg-10">							

								<input placeholder="Enter Your answer" name="txtFAQAnswer" class="form-control" type="text">

							</div>
							<div class="col-lg-2">
								<button  type="submit" data-wizard-action="submit" class="btn btn-success">Submit</button>
							</div>
						</div>
					

				</form>
				<hr>

				<div class="showFAQQuestionDetailsAns">
			    </div>

			</div>
		</div>
	</div>
</div>

<!--end::Modal-->