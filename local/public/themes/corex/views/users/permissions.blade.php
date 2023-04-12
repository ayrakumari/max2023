

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                   Permissions
                </h3>
             </div>
          </div>
          <div class="m-portlet__head-tools">
             <ul class="m-portlet__nav">
                  <li class="m-portlet__nav-item">
                        <a href="{{ route('add.permission.users')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                        <span>
                        <i class="la la-plus"></i>
                        <span>Add Permission To Users </span>
                        </span>
                        </a>
                     </li>
                  <li class="m-portlet__nav-item">
                        <a href="{{ route('permissions.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                        <span>
                        <i class="la la-plus"></i>
                        <span>Add Permission </span>
                        </span>
                        </a>
                     </li>
                <li class="m-portlet__nav-item">
                   <a href="/" class="btn btn-secondary m-btn m-btn--custom m-btn--icon">
                   <span>
                   <i class="la la-arrow-left"></i>
                   <span>BACK </span>
                   </span>
                   </a>
                </li>
             </ul>
          </div>
       </div>
       <div class="m-portlet__body">
          <!-- form  -->

          	<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_permissionList">
									<thead>
										<tr>
											<th>ID</th>
											
                                 <th>Permission Name</th>	
                                 <th>Discrption</th>																				
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
                                            <?php
 
                                            foreach ($permissions as $key => $permission) {
                                                
                                             
                                               ?>
                                               <tr>
                                                    <td>{{optional($permission)->id}}</td>
                                                    <td>{{optional($permission)->name}}</td>                                                    
                                                    <td>{{optional($permission)->permission_desc}}</td>                                                    
                                                    <td nowrap></td>
                                                </tr>
                                               <?php
                                            }
                                            ?>

										
										
									</tbody>
								</table>
							</div>
						</div>

						<!-- END EXAMPLE TABLE PORTLET-->

          <!-- form  -->
       </div>
    </div>
    
 </div>
 
 
 