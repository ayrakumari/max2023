
 
<!-- main  -->
<div class="m-content">
						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
						<div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                Print Preview  
                               
                                
                                    </h3>
                                </div>
                            </div>                          
                            <div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="javascript::void(0)" id="btnPrintSample" class="btn btn-info  m-btn--custom m-btn--icon">
												<span>
													<i class="la la-print"></i>
													<span>PRINT</span>
												</span>
											</a>
										</li>
										<li class="m-portlet__nav-item"></li>

									</ul>
								</div>
						</div>
						<div class="m-portlet__body">
						
                        
                          <div id="div_printme" style="border-bottom:1px solid #000"> 
                              <style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Liberation Sans"; font-size:x-small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
	</style>
	
	<div class="row">
		<div class="col-md-6">
		<table cellspacing="0" border="1">
	<colgroup width="5%"></colgroup>
	<colgroup width="5%"></colgroup>
	<colgroup width="25%"></colgroup>
	<tr>
		<td rowspan=3 height="51" align="center" valign=middle>
        <img alt=""  src="{{ asset('local/public/logo.jpeg') }}" style="width: 50px;" />
        </td>
		<td align="left">FROM</td>
		<td colspan=3 rowspan=3 align="left" valign=middle>
        <b><font face="Liberation Serif" size=2>MAX</font></b><br>
        <b><font face="Liberation Serif" size=2>A91-Wazirpur Industrial Area</font></b>,
        <b><font face="Liberation Serif" size=2>New Delhi -110052 , India</font></b>

       
           
         </td>
	</tr>
	<tr>
		<td rowspan=2 align="center" valign=middle><br></td>
		</tr>
	<tr>
		</tr>
	<tr>
		<td colspan=5 height="17" align="center" valign=middle><br></td>
		</tr>
	<tr>
		<td rowspan=4 height="68" align="center" valign=middle><br></td>
		<td align="left"><b>TO</b></td>
		<td colspan=3 rowspan=4 align="center" valign=middle>
        <b><font face="Liberation Serif" size=3>{{optional($sample_data)->ship_address}}</font></b><br>
       
       
        </td>
	</tr>
	<tr>
		<td rowspan=3 align="center" valign=middle><br></td>
		</tr>
	<tr>
		</tr>
	<tr>
		</tr>
		<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><font face="Liberation Serif" size=3>Phone</font></td>
		<td colspan=3 align="left" valign=middle><font face="Liberation Serif" size=3></font></td>
	</tr>
	<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><font face="Liberation Serif" size=3>S#</font></td>
		<td colspan=3 align="left" valign=middle><font face="Liberation Serif" size=3>{{$sample_data->sample_code}}</font></td>
	</tr>
	<tr>
		<td rowspan=4 height="112" align="center" valign=middle></td>
		<td colspan=4 rowspan=4 align="center" valign=middle></td>
	</tr>
</table>
		</div>
		<div class="col-md-6">

		<table cellspacing="0" border="1">
	<colgroup width="5%"></colgroup>
	<colgroup width="5%"></colgroup>
	<colgroup width="25%"></colgroup>
	<tr>
		<td rowspan=3 height="51" align="center" valign=middle>
        <img alt="" src="{{ asset('local/public/logo.jpeg') }}" style="width: 50px;" />
        </td>
		<td align="left">FROM</td>
		<td colspan=3 rowspan=3 align="left" valign=middle>
        <b><font face="Liberation Serif" size=2>MAX</font></b><br>
        <b><font face="Liberation Serif" size=2>A91-Wazirpur Industrial Area</font></b>,
        <b><font face="Liberation Serif" size=2>New Delhi -110052 , India</font></b>

       
           
         </td>
	</tr>
	<tr>
		<td rowspan=2 align="center" valign=middle><br></td>
		</tr>
	<tr>
		</tr>
	<tr>
		<td colspan=5 height="17" align="center" valign=middle><br></td>
		</tr>
	<tr>
		<td rowspan=4 height="68" align="center" valign=middle><br></td>
		<td align="left"><b>TO</b></td>
		<td colspan=3 rowspan=4 align="center" valign=middle>
        <b>
		<font face="Liberation Serif" size=3>
		{{optional($sample_data_1)->ship_address}}</font></b><br>
		

       
       
        </td>
	</tr>
	
	
	<tr>
		<td rowspan=3 align="center" valign=middle><br></td>
		</tr>
	<tr>
		</tr>
	<tr>
		</tr>
		<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><font face="Liberation Serif" size=3>Phone</font></td>
		<td colspan=3 align="left" valign=middle><font face="Liberation Serif" size=3></font></td>
	</tr>
	<tr>
		<td height="17" align="left"><br></td>
		<td align="left"><font face="Liberation Serif" size=3>S#</font></td>
		<td colspan=3 align="left" valign=middle><font face="Liberation Serif" size=3>{{$sample_data_1->sample_code}}</font></td>
	</tr>
	<tr>
		<td rowspan=4 height="112" align="center" valign=middle></td>
		<td colspan=4 rowspan=4 align="center" valign=middle></td>
	</tr>
</table>
		</div>
	</div>



<hr>



                    </div> 
                    <br>
                    {{-- end --}}
                </div>
                
                    </div>
                  </div>
          <!-- main  -->
