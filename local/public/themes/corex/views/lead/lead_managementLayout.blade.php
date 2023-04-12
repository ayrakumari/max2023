<!-- main  -->
<style media="screen">
.m-scroller:not(.m-scrollable--track)>.ps__rail-y>.ps__thumb-y, .m-scrollable:not(.m-scrollable--track)>.ps__rail-y>.ps__thumb-y {
background: #002447;
opacity: 1;
}
.m-body .m-content {
    padding: 5px 8px;
    padding-top: 5px;
    padding-right: 8px;
    padding-bottom: 5px;
    padding-left: 8px;
}
.input-group .input-group-append>.input-group-text, .input-group .input-group-prepend>.input-group-text {
    border-color: #ebedf2;
    background-color: #212529;
    color: #eee;
}
.m-widget3 .m-widget3__item {
    border-bottom: 0.07rem solid #002447;
      background-color: #f1f1f1;
}

.m-demo .m-demo__preview {
    background: white;
    border: 4px solid #f7f7fa;
    border-top-color: rgb(247, 247, 250);
    border-top-style: solid;
    border-top-width: 4px;
    border-right-color: rgb(247, 247, 250);
    border-right-style: solid;
    border-right-width: 4px;
    border-bottom-color: rgb(247, 247, 250);
    border-bottom-style: solid;
    border-bottom-width: 4px;
    border-left-color: rgb(247, 247, 250);
    border-left-style: solid;
    border-left-width: 4px;
    border-image-source: initial;
    border-image-slice: initial;
    border-image-width: initial;
    border-image-outset: initial;
    border-image-repeat: initial;
    padding: 5px;
    padding-top: 5px;
    padding-right: 5px;
    padding-bottom: 5px;
    padding-left: 15px;
}
.m-scrollableA{

  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-family: "Roboto", sans-serif;
  margin: 0;
  padding: 0;
  height: 100%;
  background:url(https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png);
  background-repeat: repeat;
  background-size:cover;

}

.col-carousel {
	margin: 10px 0;
}

/* owl nav */
.owl-prev span, .owl-next span {
	color: #FFF;
}

.owl-prev span:hover,
.owl-next span:hover {
	color: #035496;
}

.owl-prev, .owl-next {
	position: absolute;
	top: 0;
	height: 100%;
}

.owl-prev {
	left: 7px;
}

.owl-next {
	right: 7px;
}

/* removing blue outline from buttons */
button:focus, button:active {
   outline: none;
}

.m-widget5 .m-widget5__item .m-widget5__content:last-child {
  float: left !important;
  border: 0px solid #ccc;
  width: 100%;
}

.m-widget5 .m-widget5__item a:hover {
  background-color: yellow;
}

</style>
<?php

  $data_arr_data = DB::table('indmt_data')->where('QTYPE', 'W')->where('lead_status', 0)->where('duplicate_lead_status', 0)->orderBy('DATE_TIME_RE_SYS', 'desc')->limit(20)->get();
  $leadCount=count($data_arr_data);
?>
<div class="m-content">
  <div class="row">

  							<div class="col-lg-5">
                  <!--begin::Portlet-->
								<div class="m-portlet">
                  <div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													All Lead({{$leadCount}})

												</h3>
                        <div class="m-portlet__head-tools">
    											<ul class="m-portlet__nav">
    												<li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
    													<a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
    												<i class="la la-hand-o-down"></i>
    													</a>
    													<div class="m-dropdown__wrapper">
    														<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
    														<div class="m-dropdown__inner">
    															<div class="m-dropdown__body">
    																<div class="m-dropdown__content">
    																	<ul class="m-nav">
    																		<li class="m-nav__item">
    																			<a href="" class="m-nav__link">
    																				<i class="m-nav__link-icon flaticon-share"></i>
    																				<span class="m-nav__link-text">All Lead</span>
    																			</a>
    																		</li>
    																		<li class="m-nav__item">
    																			<a href="" class="m-nav__link">
    																				<i class="m-nav__link-icon flaticon-chat-1"></i>
    																				<span class="m-nav__link-text">Recieved Lead</span>
    																			</a>
    																		</li>
    																		<li class="m-nav__item">
    																			<a href="" class="m-nav__link">
    																				<i class="m-nav__link-icon flaticon-info"></i>
    																				<span class="m-nav__link-text">MY Posted Lead</span>
    																			</a>
    																		</li>

    																	</ul>
    																</div>
    															</div>
    														</div>
    													</div>
    												</li>
    											</ul>
    										</div>


											</div>
										</div>
										<div class="m-portlet__head-tools">
                      <a href="">
                        <i class="flaticon-calendar-with-a-clock-time-tools"></i>

                      </a>

											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
													<a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
														<i class="la la-ellipsis-h m--font-brand"></i>
													</a>
													<div class="m-dropdown__wrapper">
														<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
														<div class="m-dropdown__inner">
															<div class="m-dropdown__body">
																<div class="m-dropdown__content">
																	<ul class="m-nav">
																		<li class="m-nav__item">
																			<a href="" class="m-nav__link">
																				<i class="m-nav__link-icon flaticon-share"></i>
																				<span class="m-nav__link-text">ADD LEAD</span>
																			</a>
																		</li>
																		<li class="m-nav__item">
																			<a href="" class="m-nav__link">
																				<i class="m-nav__link-icon flaticon-chat-1"></i>
																				<span class="m-nav__link-text">HIDE LEAD</span>
																			</a>
																		</li>
																		<li class="m-nav__item">
																			<a href="" class="m-nav__link">
																				<i class="m-nav__link-icon flaticon-info"></i>
																				<span class="m-nav__link-text">FAQ</span>
																			</a>
																		</li>

																	</ul>
																</div>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>

									</div>

                   <div class="form-group m-form__group">
												<div class="input-group">
													<input type="text" class="form-control m-input" placeholder="Search by Name, Product, City, Company..." aria-describedby="basic-addon2">
													<div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                            <i class="fa fa-search"></i>
                            </span>
                          </div>
												</div>
                      </div>

									<!--begin::Form-->

									<!--end::Form-->
                  <div class="m-portlet__body m-scrollable" data-scrollable="true" data-height="400" data-scrollbar-shown="true" >
                    <!--begin::m-widget5-->
												<div class="m-widget5" style="background-color:#f1f1f1">

                          <?php
                          foreach ($data_arr_data as $key => $rowData) {
                              $ENQ_MESSAGE = substr(optional($rowData)->ENQ_MESSAGE, 0, 100) . '...';

                            ?>

                            <div class="m-widget5__item" style="border:1px solid #16412">
                                <a href="javascript::void(0)" class="AnchorgetUserID" id="{{$rowData->QUERY_ID}}">
                              <div class="m-widget5__content">

                                <div class="m-widget5__section">
                                  <h4 class="m-widget5__title">
                                    <i class="la la-user"></i>
                                  {{$rowData->SENDERNAME}}
                                    <i class="la la-phone"></i>
                                      {{$rowData->MOB}} <br>


                                  </h4>
                                  <span class="m-widget5__desc">
                                    <b style="color:#035496">{{$rowData->PRODUCT_NAME}}</b><br>
                                    {{$ENQ_MESSAGE}}

                                  </span>
                                  <div class="m-widget5__info">

                                    <span class="m-widget5__info-label">
                                      Date:
                                    </span>
                                    <span class="m-widget5__info-date m--font-info">
                                      {{$rowData->DATE_TIME_RE}}
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </a>
                            </div>

                            <?php
                          }
                          ?>


												</div>

												<!--end::m-widget5-->



  								</div>

								</div>







								<!--end::Portlet-->

                </div>
                <div class="col-lg-7">
                  <!--begin::Portlet-->
                  <input type="hidden" name="QUERY_ID_ID" id="QUERY_ID_ID" value="">
								<div class="m-portlet">
									<div class="m-portlet__head">
                    <ul class="m-nav m-nav--inline">
                      <li class="m-nav__item">
                        <a href="javascript::void(0)" class="m-nav__link">
                            <i class="fa fa-user-circle"></i>
                            <span class="m--font-boldest userName">

                        </span>
                        </a>
                      </li>
                      <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <i class="fa fa-phone-volume"></i>
                            <span class="m--font-boldest userPhone">

                        </span>
                        </a>
                      </li>
                      <li class="m-nav__item">
                        <a href="mailto:bointldev@gmail.com" class="m-nav__link userEmailAnchor">
                          <i class="flaticon-mail"></i>
                            <span class="m--font-boldest userEmail">

                        </span>
                        </a>
                      </li>
                      <li class="m-nav__item">
                        <a href="javascript::void(0)" data-toggle="modal" data-target="#myModal" class="m-nav__link">
                        <i class="flaticon-layers"></i>

                        </a>
                      </li>
                    </ul>
									</div>
                  <!--begin::Preview-->
												<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
													<div class="m-demo__preview">
														<ul class="m-nav m-nav--inline">
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																<i class="flaticon-clock-2"></i>
																	<span class="m-nav__link-text"> Set Reminder</span>
																</a>
															</li>
                              <li class="m-nav__item">
                                <a href="" class="m-nav__link">
                                  <i class="flaticon-file-1"></i>
                                  <span class="m-nav__link-text">Add Notes</span>
                                  <span class="m-nav__link-badge">
                                    <span class="m-badge m-badge--success m-badge--wide">23</span>
                                  </span>
                                </a>
                              </li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="flaticon-interface-9"></i>
																	<span class="m-nav__link-text"> Add Label</span>
																</a>
															</li>
                              <li class="m-nav__item">

                                <a href="javascript::void()" onclick="clickCall()" class="btn btn-success m-btn m-btn--icon m-btn--pill">
  															<span>
  															<i class="la la-headphones"></i>
  																<span>CALL NOW</span>
  															</span>
  														</a>
															</li>


														</ul>

                            <div class="m-scrollableA" data-scrollable="true" data-height="400" data-scrollbar-shown="true">

    										     </div>
                             <!-- addRow -->
                             <div class="container">
                              	<div class="row align-items-center">
                              		<div class="col-12 col-carousel" style="display:none">
                              			<div class="owl-carousel carousel-main">
                              				<div>
                                        Ajay Kumar
                                      </div>
                              				<div>

                                        Ram Kumar
                                        </div>
                              				<div><img src="http://via.placeholder.com/350x200/FECA57/FFF.jpg?text=3"></div>
                              				<div><img src="http://via.placeholder.com/350x200/FECA57/FFF.jpg?text=4"></div>
                              				<div><img src="http://via.placeholder.com/350x200/FECA57/FFF.jpg?text=5"></div>
                              				<div><img src="http://via.placeholder.com/350x200/FECA57/FFF.jpg?text=6"></div>
                              			</div>
                              		</div>
                              	</div>
                              </div>

                             <!-- addRow -->

													</div>

												</div>




												<!--end::Preview-->


									<!--begin::Form-->


									<!--end::Form-->
								</div>

								<!--end::Portlet-->

                </div>


</div>
<!-- main  -->

<!--begin::Modal-->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Details</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body viewLoginActivity">

									</div>

								</div>
							</div>
						</div>

						<!--end::Modal-->
