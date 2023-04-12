

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Add Permission to users : <strong></strong>
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
          <!-- form  -->
       <form action="{{ route('saveuserPermission')}}" method="POST">         
        @csrf 
        <div class="form-group">
            <h5><b>Users</b></h5>    
            <select name="user_id" id="" class="form-control">
                    <?php 
                    foreach ($users as $key => $user) {
                    ?>
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    <?php
                    }
                    ?>
                
            </select>
        </div>
    <h5><b>Assign Permissions</b></h5>
    @foreach ($permissions as $permission)
        {{Form::checkbox('permissions[]',  $permission->id ) }}
        {{Form::label($permission->name, ucfirst($permission->name)) }}<br>
    @endforeach
    <br>
    {{ Form::submit('submit', array('class' => 'btn btn-primary')) }}         
</form>

          <!-- form  -->
       </div>
    </div>
    
 </div>
 
 
 <?php /*SELECT items.item_name,items.item_id,item_category.cat_name,items.cat_id FROM items JOIN item_category ON items.cat_id=item_category.cat_id  */?>
 