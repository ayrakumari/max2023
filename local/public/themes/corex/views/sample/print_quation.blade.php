<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                       Qutatation Data
                    </h3>
                </div>
            </div>
            <!-- kk -->

            <!-- kk -->
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" data-quatation="{{ Request::segment(3) }}"  id="btnSendQuatation" class="btn btn-info  m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-send"></i>
                                <span>SEND QUATATION</span>
                            </span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" data-quatation="{{ Request::segment(3) }}"  id="btnDownloadQuatation" class="btn btn-warning  m-btn--custom m-btn--icon">
                            PDF
                        </a>
                    </li>
                   

                </ul>
            </div>
        </div>




        <div class="m-portlet__body">


            <div id="div_printme">

                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table m-table m-table--head-bg-primary">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Items</th>
                                    <th>Size(gm/ml)</th>
                                    <th>Cost(per/kg)</th>
                                    <th>QTY</th>
                                    <th>Packaging type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;

                                foreach ($data_arr as $key => $rowData) {
                                   // print_r($data_arr);
                                   $i++;
                                    ?>
                                     <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$rowData->item_name}}</td>
                                    <td>{{$rowData->size}}</td>
                                    <td>{{$rowData->mcp_kg}}</td>
                                    <td>{{$rowData->qty}}</td>
                                    <td>{{$rowData->ptype}}</td>
                                </tr>

                                    <?php
                                }
                                ?>

                               

                            </tbody>
                        </table>
                    </div>
                </div>

                <!--end::Section-->



            </div>



        </div>
    </div>
</div>
<!-- main  -->