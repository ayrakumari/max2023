

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    EDIT : <strong>{{$permission->name}}</strong>
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

          {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Permission Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
       
    </div>
    <div class="form-group">
            {{ Form::label('name', 'Descriptions') }}
            {{ Form::text('permission_desc', null, array('class' => 'form-control')) }}
           
        </div>

    <br>
    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

          <!-- form  -->
       </div>
    </div>
    
 </div>
 
 
 