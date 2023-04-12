
          <!-- main  -->
          <div class="m-content">
						<!-- datalist -->
						<div class="m-portlet m-portlet--mobile">
													<div class="m-portlet__head">
														<div class="m-portlet__head-caption">
															<div class="m-portlet__head-title">
																<h3 class="m-portlet__head-text">
															Client Data
																</h3>
															</div>
														</div>


                            <!-- kk -->

                            <!-- kk -->
                            <div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											{{-- <a href="javascript::void(0)" id="btnPrintSample" class="btn btn-info  m-btn--custom m-btn--icon">
												<span>
													<i class="la la-print"></i>
													<span>PRINT</span>
												</span>
											</a> --}}
										</li>
										<li class="m-portlet__nav-item"></li>

									</ul>
								</div>
							</div>




													<div class="m-portlet__body">

                                                        <style type="text/css">
                                                            body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Liberation Sans"; font-size:x-small }
                                                            a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
                                                            a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
                                                            comment { display:none;  } 
                                                        </style>
                          <div id="div_printme" >
                             
                                <h4>ORDER CLIENTS LIST</h4>
                                <table cellspacing="0" border="1">
                                        <colgroup width="20"></colgroup>
                                        <colgroup width="150"></colgroup>
                                        <colgroup width="150"></colgroup>
                                        <colgroup width="110"></colgroup>
                                        <colgroup width="210"></colgroup>
                                        <colgroup width="210"></colgroup>
                                        <colgroup width="210"></colgroup>
                                    <?php 
                                    $i=0;
                                foreach ($data as $key => $value) {
                                    $i++;
                                    ?>
                                   <tr>
                                   <td height="20" align="center" valign=middle><b>{{$i}}</b></td>
                                    <td height="20" align="center" valign=middle><b>{{$value['form_id']}}</b></td>
                                        <td align="center" valign=middle><b>{{$value['order_id']}}</b></td>
                                        <td align="center" valign=middle><b>{{$value['brand_name']}}</b></td>
                                        <td align="center" valign=middle><b>{{$value['email']}}</b></td>
                                        <td align="center" valign=middle><b>{{$value['client_name']}}</b></td>
                                        <td align="center" valign=middle><b>{{$value['added_by']}}</b></td>
                                    </tr>
                                    <?php
                                }
                                ?>        
                                   
                                </table>

                                


                           


                          </div>                         


					                </div>
                    </div>
                  </div>
          <!-- main  -->
