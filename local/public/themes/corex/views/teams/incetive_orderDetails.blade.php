<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <!--Begin::Section-->
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Incentive Order Details : <span style="color:#035496">{{AyraHelp::getUser( Request::segment(2))->name}}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_OrderLead_Data">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Created On</th>
                            <th>Brand</th>
                            <th>Created By</th>
                            <th>Action</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $uid = Request::segment(2);
                        $b_month = Request::segment(3);
                        $b_year = Request::segment(4);
                        $userData = AyraHelp::getUser($uid);
                        $dataArr = AyraHelp::getOrderApprovedDetailIncentive($uid, $b_month, $b_year);
                        
                        $me = 0;

                        foreach ($dataArr as $key => $row) {
                            //print_r($rowData);

                            $orderID = $row->order_id . "/" . $row->subOrder;
                          
                      
                                if (isset($row->qc_from_bulk)) {
                                    if ($row->qc_from_bulk == 1) {
                                        $me= $row->bulk_order_value;
                                    } else {
                                        $me = ($row->item_sp) * ($row->item_qty);
                                    }
                                } else {
                                    $me = ($row->item_sp) * ($row->item_qty);
                                }
                        
                    
                            //$sumVal= array_sum($me);

                            //die;
                        ?>
                            <!--begin: Datatable -->


                            <tr>
                                <td>{{$orderID}}</td>
                                <td>{{date('D,j-F-Y',strtotime($row->created_at))}}</td>
                                <td>{{$row->brand_name}}</td>
                                <td>{{AyraHelp::getUser($row->created_by)->name}}</td>
                                <td>VIEW</td>
                                <td>{{$me}}</td>
                            </tr>



                        <?php
                        }

                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Order ID</th>
                            <th>Created On</th>
                            <th>Brand</th>
                            <th>Created By</th>
                            <th>Action</th>
                            <th>Total</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>
        <!--end::Portlet-->

        <!--End::Section-->
    </div>
    <!-- datalist -->
</div>
<!-- main  -->


<div class="modal fade" id="m_modal_6PAYMENTRECDETAIL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="modal-content">
            <div class="modal-body">
                <div id="payDetalRecSHOW">
                </div>
            </div>



        </div>
    </div>
</div>