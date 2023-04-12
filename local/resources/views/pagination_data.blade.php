
    <div class="table-responsive">
     <table class="table table-striped table-bordered">
      <tr>
       <th width="5%">ID</th>
       <th width="38%">Company Details</th>
       <th width="57%">Location</th>
       <th width="57%">Product</th>
       <th width="57%">Message</th>
       <th width="57%">Status</th>
       <th width="57%">Date</th>
       <th width="57%">Source</th>
       <th width="57%">Action</th>
      </tr>
      @foreach($data as $row)
      <tr>
       <td>{{ $row->id }}</td>
       <td>
       {{ $row->SENDERNAME}} <br>
       {{ $row->MOB}} <br>
       {{ $row->GLUSR_USR_COMPANYNAME}} <br>


       </td>
       <td>{{ $row->ENQ_CITY }}
       <br>
       {{ $row->ENQ_STATE }}
       </td>
       <td>{{ $row->PRODUCT_NAME }}</td>
       <td>{{ $out = strlen($row->ENQ_MESSAGE) > 15 ? substr($row->ENQ_MESSAGE,0,15)."..." : $row->ENQ_MESSAGE   }}</td>
       <td>Fresh Lead</td>
       <td>{{ $row->DATE_TIME_RE_SYS }}</td>
       <td>{{ $row->data_source }}</td>
       <td>
       <a href="#" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-circle"></i>
														</a>
                                                        <a href="#" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-exclamation-square"></i>
														</a>
                                                        <a href="#" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-technology-1"></i>
														</a>
       </td>
      </tr>
      @endforeach
     </table>

     {!! $data->links() !!}

    </div>
