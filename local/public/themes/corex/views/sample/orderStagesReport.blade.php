<!-- main  -->
<div class="m-content">
	<!-- datalist -->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Order Stage Report
					</h3>

				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">

					<li style="display:none" class="m-portlet__nav-item">
						<a href="{{route('sample.print.all')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon">
							<span>
								<i class="la la-print"></i>
								<span>PRINT ALL </span>
							</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_OrderStageReport_1">
				<thead>
					<tr>

						<th>Sales Person</th>
						<th>Pending </th>
						<th>Orders</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- datalist -->
</div>
<!-- main  -->