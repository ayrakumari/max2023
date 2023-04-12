

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                   Users List
                </h3>
             </div>
          </div>
          <div class="m-portlet__head-tools">
             <ul class="m-portlet__nav">
                  <li class="m-portlet__nav-item">
                        <a href="{{ route('users.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                        <span>
                        <i class="la la-plus"></i>
                        <span>ADD USER </span>
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
								<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_usersList">
									<thead>
										<tr>
											<th>ID</th>
											<th>Prefix</th>
											<th>Name</th>
											<th>Email</th>
                                 <th>Phone</th>											
											<th>Role</th>
											<th>Created On</th>											
											<th>Status</th>											
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
                                            <?php
 
                                            foreach ($users as $key => $user) {
                                              $user_arr=AyraHelp::getUserRole($user->id);
                                              //echo "<pre>";
                                                $userrole="";
                                             
                                              foreach ($user->roles as $key => $role) {
                                                $userrole .=$role->name;
                                              }

                                              $affected = DB::table('users')
                                             ->where('id', $user->id)
                                             ->update(['role_name' =>$userrole]);


                                               ?>
                                               <tr>
                                                    <td>{{optional($user)->id}}</td>
                                                    <td>{{optional($user)->user_prefix}}</td>
                                                    <td>{{optional($user)->name}}</td>
                                                    <td>{{optional($user)->email}}</td>
                                                    <td>{{optional($user)->phone}}</td>
                                                    <td>{{ $userrole}}</td>
                                                    <td>{{  date('j M Y', strtotime(optional($user)->created_at)) }}</td>
                                                    <td>{{optional($user)->status}}</td>                                                    
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
 
 
 