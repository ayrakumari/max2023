<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Team List
					</h3>

				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						@can('add-samples')
						<a href="{{route('addNewteam')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
							<span>
								<i class="la la-plus"></i>
								<span>Add New </span>
							</span>
						</a>
						@endcan
					</li>

				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="tblTeamMember">
				<thead>
					<tr>
						<th>S#</th>
						<th>Team </th>
						<th>Members</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
			

		</div>
		<div style="background-color: #ccc; width:1200px; height: 600px" class="chart" id="botreeLayout"></div>
	</div>
	<!-- datalist -->
</div>
<!-- main  -->

<!-- m_modal_5_MoveTeamMember -->
<div class="modal fade" id="m_modal_5_MoveTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Move User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" name="txtUserID" id="txtUserID">
					<div class="form-group">
						<label for="message-text" class="form-control-label">Move Label 3 User:</label>
						
						<select style="width:260px" class="form-control m-select2 mangerIDataSelect1" id="m_select2_5" name="param_member">
							<?php
							$allUsers = AyraHelp::getSalesAgentAdmin();

							foreach ($allUsers as $key => $rowData) {
								$users = DB::table('categories')->where('user_id', $rowData->id)->first();
								if ($users!= null) {
									if($rowData->parent_id!=1 && $rowData->id!=1 ){
										?>
										<option value="{{$rowData->id}}">{{$rowData->name}}</option>
								<?php
									}
						
								}
							}



							?>

						</select>

					</div>


					<div class="form-group">
						<label for="message-text" class="form-control-label">TO Lebel 2 Users:</label>
						
						<select style="width:260px" class="form-control m-select2 mangerIDataSelect2" id="m_select2_7" name="param_member">
						<?php
							$allUsers = AyraHelp::getSalesAgentAdmin();

							foreach ($allUsers as $key => $rowData) {
								$users = DB::table('categories')->where('user_id', $rowData->id)->first();
								if ($users!= null) {
									if($rowData->parent_id==1){
										?>
										<option value="{{$rowData->id}}">{{$rowData->name}}</option>
								<?php
									}
						
								}
							}



							?>

						</select>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnSavewithMoveL3inL2" class="btn btn-primary">Move  Now</button>
			</div>
		</div>
	</div>
</div>

<!-- m_modal_5_MoveTeamMember -->
<!-- add new team member  -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_5_addnewTeamMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" name="txtUserID" id="txtUserID">
					<div class="form-group">
						<div class="m-dropdown__inner">
							<div class="m-dropdown__header m--align-center" style="background: url(assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
								<div class="m-card-user m-card-user--skin-dark">
									<div class="m-card-user__pic ajpicAva">									

									</div>
									<div class="m-card-user__details">
										<span class="m-card-user__name ajmName m--font-weight-500" style="color:#035496"></span>
										<a href="#" class="m-card-user__email ajphone m--font-weight-300 m-link" style="color:#035496"></a>
										<a href="#" class="m-card-user__email  m--font-weight-300 m-link" style="color:#035496">
										<span class="m-badge m-badge--primary m-badge--wide">Level 2</span>
										</a>
									</div>
								</div>
							</div>

						</div>

					</div>

					<div class="form-group">
						<label for="message-text" class="form-control-label">Users:</label>
						
						<select style="width:260px" class="form-control m-select2 mangerIDataSelect" id="m_select2_1" name="param_member">
							<?php
							$allUsers = AyraHelp::getSalesAgentAdmin();

							foreach ($allUsers as $key => $rowData) {
								$users = DB::table('categories')->where('user_id', $rowData->id)->first();
								if ($users == null) {
							?>
									<option value="{{$rowData->id}}">{{$rowData->name}}</option>
							<?php
								}
							}



							?>

						</select>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="btnSaveL3inL2" class="btn btn-primary">Submit Now</button>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->

<!-- add new team member  -->