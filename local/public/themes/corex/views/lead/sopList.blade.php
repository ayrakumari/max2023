<!-- main  -->
<div class="m-content">

    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        SOP getList
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('home')}}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-arrow-left"></i>
                                <span>Home </span>
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
          <input type="hidden" id="txtUserIDVal" value="90">
            <!-- start  -->
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_SOPActivity">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>SOP NO.</th>
                  <th>Department</th>
                  <th>Name of SOP</th>
                  <th>Submitted By</th>                  
                  <th>Actions</th>
                </tr>
              </thead>

            </table>
            <!-- end  -->
            <!-- end  -->
        </div>
    </div>


</div>
<!-- main  -->

