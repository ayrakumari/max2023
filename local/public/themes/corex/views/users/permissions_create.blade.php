

<!-- main  -->
<div class="m-content">
   
    <div class="m-portlet m-portlet--mobile">
       <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
             <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Add Permission : 
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
        {{ Form::open(array('url' => 'permissions')) }}

        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('name', 'Discrption') }}
            {{ Form::text('permission_desc', '', array('class' => 'form-control')) }}
        </div>
        
        <br>
    
        @if(!$roles->isEmpty())
    
            <h4>Assign Permission to Roles</h4>
    
            @foreach ($roles as $role) 
                {{ Form::checkbox('roles[]',  $role->id ) }}
                {{ Form::label($role->name, ucfirst($role->name)) }}<br>
    
            @endforeach
    
        @endif
        
        <br>
        {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
    
        {{ Form::close() }}

         
       </div>
    </div>
    
 </div>
 
 
 