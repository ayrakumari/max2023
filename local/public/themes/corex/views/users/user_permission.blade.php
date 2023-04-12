

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    User Permission : <strong></strong>
                </h3>
             </div>
          </div>
          <div class="m-portlet__head-tools">
             <ul class="m-portlet__nav">
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

        <!--begin::Section-->
        <div class="m-section">
               
                <div class="m-section__content">
                    <?php 
                        //$user = auth()->user();                    
                       // $user->givePermissionTo('Create Post');
                        //$user->revokePermissionTo('Create Post');
                        $per_arr=Spatie\Permission\Models\Permission::all();                   
                      
                        $user = App\User::find(Request::segment(3));
                        $permissions = $user->permissions;                          
                        foreach ($per_arr as $key => $perms) {
                           
                            if(isset($permissions[$key]['name'])){
                             //  echo  $per_arr[$key]['name'];
                            }else{
                               // echo $per_arr[$key]['name'];
                            }                
                           
                            
                        }
                        
                        ?>

                    <!--begin::Preview-->
                    <input type="hidden" id="p_userid" value="{{ Request::segment(3) }}">
                    <div class="m-demo">

                        <div class="m-demo__preview">
                            <div class="m-list-timeline">
                                <div class="m-list-timeline__items">


                                    <?php 
                                foreach ($per_arr as $key => $perms) {                           
                                    if(isset($permissions[$key]['name'])){
                                      
                                        ?>
                                        <div class="m-list-timeline__item"> 
                                                <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                <span class="m-list-timeline__icon flaticon-user"></span>
                                                <span class="m-list-timeline__text"><span class="m-badge m-badge--brand m-badge--wide m-badge--rounded">{{$permissions[$key]['name']}} </span> {{ $permissions[$key]['permission_desc']}}</span>
                                                <span class="m-list-timeline__time"> <input data-on-color="success" class="status" data="{{$permissions[$key]['name']}}" data-switch="true" data-size="small" type="checkbox" data-on-text="YES"  data-off-text="NO" checked="checked"></span>
                                            </div>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="m-list-timeline__item"> 
                                                <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                                <span class="m-list-timeline__icon flaticon-user"></span>
                                                <span class="m-list-timeline__text">{{$per_arr[$key]['name']}} | {{ $per_arr[$key]['permission_desc']}}</span>
                                                <span class="m-list-timeline__time"> <input data-on-color="success" class="status" data="{{$per_arr[$key]['name']}}" data-switch="true" data-size="small" type="checkbox" data-on-text="YES"  data-off-text="NO"></span>
                                            </div>
                                        <?php
                                    } 
                                }

                                    ?>
                                   
                                   
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Preview-->

                   
                </div>
            </div>

            <!--end::Section-->
          <!-- form  -->
        <!--begin::Form-->
							
                               
         
          <!-- form  -->
       </div>
    </div>
    
 </div>
 

 <?php /*
  <?php 
                                    foreach ($per_arr as $key => $perms) {
                                            //print_r($perms->name);
                                            foreach ($permissions as $key => $permission) {
                                                
                                                 if($permission->name==$perms->name){
                                                    ?>
                                            <div class="m-list-timeline__item"> 
                                                <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                                <span class="m-list-timeline__icon flaticon-user"></span>
                                                <span class="m-list-timeline__text">{{$perms->name}} | {{$perms->permission_desc}}</span>
                                                <span class="m-list-timeline__time"> <input data-on-color="success" class="status" data="{{$perms->name}}" data-switch="true" data-size="small" type="checkbox" data-on-text="YES"  data-off-text="NO" checked="checked"></span>
                                            </div>
                                            <?php
                                                 }
                                            }

                                            
                                            ?>
                                            <div class="m-list-timeline__item">
                                                <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                <span class="m-list-timeline__icon flaticon-user"></span>
                                                <span class="m-list-timeline__text">{{$perms->name}} | {{$perms->permission_desc}}</span>
                                                <span class="m-list-timeline__time"> <input data-on-color="success" class="status" data="{{$perms->name}}" data-switch="true" data-size="small" type="checkbox" data-on-text="YES"  data-off-text="NO" ></span>
                                            </div>
                                            <?php
                                    }

                                        ?>
 *?>
 
 