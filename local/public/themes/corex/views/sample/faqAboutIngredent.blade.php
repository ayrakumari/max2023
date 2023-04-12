<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                     Technical Questions
                    </h3>

                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <a href="{{route('FAQAboutIngredentList')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Technical Questions List</span>
                        </span>
                    </a>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin:  -->

            <div class="row">
                <div class="col-md-10">


                    <!--begin::Form-->
                    <form id="m_form_add_FAQ" method="post" action="{{route('saveFAQ')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    @csrf
                        <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                                <div class="col-lg-12">
                                    <label>Enter Product Name:</label>
                                                                        
                                        <input name="txtProductNameFAQ" class="form-control" type="text">

                                </div>

                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-12">
                                    <label>Enter Your Question:</label>
                                    <textarea name="txtContentFAQ" class="form-control" data-provide="markdown" rows="10"></textarea>


                                </div>

                            </div>


                        </div>
                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-6">
                                    <button type="submit" data-wizard-action="submit" class="btn btn-primary">Submit</button>

                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->





                </div>

                <div class="col-md-2">


                </div>
            </div>


            <!--end:: Widgets/Support Tickets -->


            <!--stop: -->

        </div>
    </div>
    <!-- datalist -->
</div>
<!-- main  -->


<?php 
/* <div class="m-widget3" >
                        <div class="m-widget3__item" >
                            <div class="m-widget3__header">
                                <div class="m-widget3__user-img">
                                    <img class="m-widget3__img" src="http://demo.local/local/public/img/avatar.jpg" alt="">
                                </div>
                                <div class="m-widget3__info">
                                    <span class="m-widget3__username">
                                        Melania Trump
                                    </span><br>
                                    <span class="m-widget3__time">
                                        2 day ago
                                    </span>
                                </div>
                                <span class="m-widget3__status m--font-info">
                                    Pending
                                </span>
                            </div>
                            <div class="m-widget3__body">
                                <p class="m-widget3__text">
                                    Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.
                                </p>
                            </div>
                        <hr>
                             <!-- ajaz -->
                             <div class="row">
                                <div class="col-md-6">
                                <a href="#" class="btn btn-secondary btn-sm m-btn  m-btn m-btn--icon">
															<span>
                                                            <i class="flaticon-like"></i>
																<span>Like <span class="m-badge m-badge--brand">3</span></span>
															</span>
														</a>
                                                        <a href="#" class="btn btn-secondary btn-sm m-btn  m-btn m-btn--icon">
															<span>
                                                            <i class="flaticon-comment"></i>
																<span>Comment <span class="m-badge m-badge--brand">3</span></span>
															</span>
														</a>

                                </div>
                                <div class="col-md-6">

                                <div class="m-list-pics m-list-pics--sm m--padding-left-20">
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
                                                            <a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															<a href="#"><img src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
															
                                                           
														</div>


                                </div>

                             </div>
                             <!-- ajaz -->

                        </div>
                        <div class="m-widget3__item">
                            <div class="m-widget3__header">
                                <div class="m-widget3__user-img">
                                    <img class="m-widget3__img" src="http://demo.local/local/public/img/avatar.jpg" alt="">
                                </div>
                                <div class="m-widget3__info">
                                    <span class="m-widget3__username">
                                        Lebron King James
                                    </span><br>
                                    <span class="m-widget3__time">
                                        1 day ago
                                    </span>
                                </div>
                                <span class="m-widget3__status m--font-brand">
                                    Open
                                </span>
                            </div>
                            <div class="m-widget3__body">
                                <p class="m-widget3__text">
                                    Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.Ut wisi enim ad minim veniam,quis nostrud exerci tation ullamcorper.
                                </p>
                            </div>
                        </div>
                        <div class="m-widget3__item">
                            <div class="m-widget3__header">
                                <div class="m-widget3__user-img">
                                    <img class="m-widget3__img" src="http://demo.local/local/public/img/avatar.jpg" alt="">
                                </div>
                                <div class="m-widget3__info">
                                    <span class="m-widget3__username">
                                        Deb Gibson
                                    </span><br>
                                    <span class="m-widget3__time">
                                        3 weeks ago
                                    </span>
                                </div>
                                <span class="m-widget3__status m--font-success">
                                    Closed
                                </span>
                            </div>
                            <div class="m-widget3__body">
                                <p class="m-widget3__text">
                                    Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.
                                </p>
                            </div>
                        </div>
                    </div>
                    /*?>
