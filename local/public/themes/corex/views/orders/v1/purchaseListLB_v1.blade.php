<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h6 class="m-portlet__head-text">
                        Purchase List 
                        <input type="hidden" id="txtPurchaseFlag" value="1">
                    </h6>
                    <table style="margin-left:30px;">
                        <tr>
                            <td>
                                <h5 class="m--font-info">Orders Pending </h5>
                            </td>
                            <td>
                                <button type="button" onclick="filterPurchasebydaysAll()" class="btn btn-warning btn-sm"> View All</span></button>

                            </td>
                            <td>
                                <button type="button" id="aj3" onclick="filterPurchasebydays(3)" class="btn btn-outline-primary btn-sm"> 3 Days <span class="m-badge m-badge--info">{{ $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(3)}}</span></button>

                            </td>
                            <td>
                                <button type="button" id="aj7" onclick="filterPurchasebydays(7)" class="btn btn-outline-primary btn-sm"> 7 Days <span class="m-badge m-badge--warning">{{ $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(7)}}</span></button>

                            </td>
                            <td>
                                <button type="button" id="aj15" onclick="filterPurchasebydays(15)" class="btn btn-outline-primary btn-sm"> 15 Days <span class="m-badge m-badge--danger">{{ $spcount=AyraHelp::purchasePendingOrderTostartOrderOnly(15)}}</span></button>
                            </td>
                        </tr>
                    </table>
                    <table style="margin-left:30px;">
                        <tr>
                            <td>
                                <h5 class="m--font-info">Design Stage </h5>
                            </td>
                            <td>
                                <?php

                                $spcount = AyraHelp::purchaseArtWork();


                                ?>
                                <button type="button" onclick="purchaseArtWorkVal(1)" class="btn btn-outline-default btn-sm"> Client End (AR) <span class="m-badge m-badge--info">{{$spcount['artwork_count']}}</span></button>


                            </td>
                            <td>
                                <button type="button" onclick="purchaseArtWorKAllOther(2)" class="btn btn-outline-default btn-sm"> Our End(All) <span class="m-badge m-badge--warning">{{$spcount['allothers']}}</span></button>

                            </td>

                        </tr>
                    </table>
                </div>

            </div>


        </div>
        <div style="margin:8px 0px -16px 27px;">
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">NOT STARTED <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(1,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">DESIGN <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(2,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded"> SAMPLE<span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(3,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">QUOTATION <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(4,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">ORDERED <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(5,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">IN STOCK <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(6,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">FROM CLIENT <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(7,0)}}</span></span>
            <span style="margin-right:1px;" class="m-badge m-badge--info m-badge--wide m-badge--rounded">REMOVED <span class="m-badge m-badge--warning">{{AyraHelp::PurchaseStageCount(8,0)}}</span></span>
        </div>

        <div class="m-portlet__body">
            <form class="m-form m-form--fit m--margin-bottom-20">
                <div class="row m--margin-bottom-20">
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Material Name:</label>
                        <input type="text" class="form-control m-input" placeholder="Enter Item Name" data-col-index="1">
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Category:</label>

                        <select class="form-control m-input" data-col-index="5">
                            <option value="">ALL</option>
                            <?php
                            $data_arrs = AyraHelp::getBOMItemCategory();

                            foreach ($data_arrs as $key => $data_arr) {

                            ?>
                                <option value="{{ $data_arr->cat_name}}">{{ $data_arr->cat_name}}</option>
                            <?php

                            }
                            ?>
                        </select>

                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Stages:</label>
                        <?php
                        $data_purch_arr = AyraHelp::getPurchaseStageLIST();


                        ?>
                        <select class="form-control m-input" data-col-index="7">
                            <option value="">ALL</option>
                            <?php
                            foreach ($data_purch_arr as $key => $rowData) {

                            ?>
                                <option value="{{$rowData->stage_id}}">{{$rowData->stage_name}}</option>
                            <?php
                            }

                            ?>

                        </select>
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <label>Item Name:</label>
                        <input type="text" class="form-control m-input" placeholder="Item Name" data-col-index="4">
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-brand m-btn m-btn--icon" id="m_search" style="margin-top:25px">
                            <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                            </span>
                        </button>
                    </div>
                    <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                        <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset" style="margin-top:25px">
                            <span>
                                <i class="la la-close"></i>
                                <span>Reset</span>
                            </span>
                        </button>

                    </div>

                </div>



            </form>

            <input hidden type="text" id="txtNumberofdays">



            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_QCFORMPurchaseListBOV1_LABEL_BOX_v1">
                <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Material Name</th>
                        <th>Order ID</th>
                        <th>Order Name </th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>QTY</th>
                        <th>Statge On</th>
                        <th>Order Statge </th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->



</div>
</div>
</div>








<!-- v1 model -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_purchaseView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Stage Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- ajtab -->
                <style>
                    .breadcrumb {
                        /*centering*/
                        display: inline-block;
                        box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.35);
                        overflow: hidden;
                        border-radius: 5px;
                        /*Lets add the numbers for each link using CSS counters. flag is the name of the counter. to be defined using counter-reset in the parent element of the links*/
                        counter-reset: flag;
                    }

                    .breadcrumb a {
                        text-decoration: none;
                        outline: none;
                        display: block;
                        float: left;
                        font-size: 12px;
                        line-height: 36px;
                        color: white;
                        /*need more margin on the left of links to accomodate the numbers*/
                        padding: 0 10px 0 60px;
                        background: #035496;
                        background: linear-gradient(#035496, #035496);
                        position: relative;
                    }

                    /*since the first link does not have a triangle before it we can reduce the left padding to make it look consistent with other links*/
                    .breadcrumb a:first-child {
                        padding-left: 46px;
                        border-radius: 5px 0 0 5px;
                        /*to match with the parent's radius*/
                    }

                    .breadcrumb a:first-child:before {
                        left: 14px;
                    }

                    .breadcrumb a:last-child {
                        border-radius: 0 5px 5px 0;
                        /*this was to prevent glitches on hover*/
                        padding-right: 20px;
                    }

                    /*hover/active styles*/
                    .breadcrumb a.active,
                    .breadcrumb a:hover {
                        background: #008031;
                        background: linear-gradient(#008031, #008031);
                    }

                    .breadcrumb a.active:after,
                    .breadcrumb a:hover:after {
                        background: #008031;
                        background: linear-gradient(135deg, #008031, #008031);
                    }

                    /*adding the arrows for the breadcrumbs using rotated pseudo elements*/
                    .breadcrumb a:after {
                        content: '';
                        position: absolute;
                        top: 0;
                        right: -18px;
                        /*half of square's length*/
                        /*same dimension as the line-height of .breadcrumb a */
                        width: 36px;
                        height: 36px;
                        /*as you see the rotated square takes a larger height. which makes it tough to position it properly. So we are going to scale it down so that the diagonals become equal to the line-height of the link. We scale it to 70.7% because if square's: 
    length = 1; diagonal = (1^2 + 1^2)^0.5 = 1.414 (pythagoras theorem)
    if diagonal required = 1; length = 1/1.414 = 0.707*/
                        transform: scale(0.707) rotate(45deg);
                        /*we need to prevent the arrows from getting buried under the next link*/
                        z-index: 1;
                        /*background same as links but the gradient will be rotated to compensate with the transform applied*/
                        background: #035496;
                        background: linear-gradient(135deg, #035496, #035496);
                        /*stylish arrow design using box shadow*/
                        box-shadow:
                            2px -2px 0 2px rgba(0, 0, 0, 0.4),
                            3px -3px 0 2px rgba(255, 255, 255, 0.1);
                        /*
        5px - for rounded arrows and 
        50px - to prevent hover glitches on the border created using shadows*/
                        border-radius: 0 5px 0 50px;
                    }

                    /*we dont need an arrow after the last link*/
                    .breadcrumb a:last-child:after {
                        content: none;
                    }

                    /*we will use the :before element to show numbers*/
                    .breadcrumb a:before {
                        content: counter(flag);
                        counter-increment: flag;
                        /*some styles now*/
                        border-radius: 100%;
                        width: 20px;
                        height: 20px;
                        line-height: 20px;
                        margin: 8px 0;
                        position: absolute;
                        top: 0;
                        left: 30px;
                        background: #444;
                        background: linear-gradient(#444, #222);
                        font-weight: bold;
                    }


                    .flat a,
                    .flat a:after {
                        background: white;
                        color: black;
                        transition: all 0.5s;
                    }

                    .flat a:before {
                        background: white;
                        box-shadow: 0 0 0 1px #ccc;
                    }

                    .flat a:hover,
                    .flat a.active,
                    .flat a:hover:after,
                    .flat a.active:after {
                        background: #008080;
                    }

                    .ajkumar {
                        /* background: gray !important; */

                    }

                    li:disabled {
                        background: #dddddd;
                    }
                </style>

                <!--begin::Section-->
                <div class="m-section">

                    <div class="m-section__content">
                        <table class="table table-sm m-table m-table--head-bg-brand">

                            <tbody class="ajorderTable">


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--end::Section-->


                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-sm m-table m-table--head-bg-brand"">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Stage Name</th>
                                                <th>Completed Date</th>
                                                <th>Status</th>
                                                <th>Completed By</th>
                                            </tr>
                                            </thead>
                                            <tbody class=" StageActionHistory">


                            </tbody>
                        </table>
                    </div>
                </div>





                <!-- a simple div with some links -->
                <div class="breadcrumb ajcustomProgessBar" style="text-align: center;">

                </div>




                <!-- ajtab -->

            </div>

        </div>
    </div>
</div>

<!--end::Modal-->
<!-- v1 model -->


<div class="modal fade" id="m_modal_4_showQCFormPricePart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <!-- show data  -->
                <div class="row">
                    <div class="col-md-12">
                        <!--begin::Portlet-->
                        <div class="m-portlet m-portlet--warning m-portlet--head-solid-bg">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">

                                        <h3 class="m-portlet__head-text">
                                            Current Price
                                        </h3>
                                    </div>
                                </div>

                            </div>
                            <div class="m-portlet__body viewPricePart">

                            </div>

                        </div>

                        <!--end::Portlet-->

                    </div>
                    <div class="col-md-6" style="display: none;">

                        <!--begin::Portlet-->
                        <div class="m-portlet m-portlet--success m-portlet--head-solid-bg">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">

                                        <h3 class="m-portlet__head-text">
                                            New Price
                                        </h3>
                                    </div>
                                </div>

                            </div>
                            <div class="m-portlet__body">
                                <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td> RM Price/Kg: </td>
                                            <td>
                                                <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td> Bottle/Cap/Pump: </td>
                                            <td>
                                                <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td> Label Price: </td>
                                            <td>
                                                <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td> M.Carton Price: </td>
                                            <td>
                                                <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>L & C Price: </td>
                                            <td>
                                                <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </td>
                                        </tr>
                                        <th scope="row">6</th>
                                        <td>Margin: </td>
                                        <td>
                                            <input type="text" style="width: 115px;background-color:#035496;color:#FFFF" class="form-control form-control-sm m-input" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </td>
                                        </tr>



                                    </tbody>
                                </table>

                            </div>
                            <div class="m-portlet__foot">
                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                        </div>

                        <!--end::Portlet-->

                    </div>
                </div>
                <!-- show data  -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
