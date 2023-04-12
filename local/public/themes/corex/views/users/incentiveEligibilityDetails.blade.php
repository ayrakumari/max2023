<!-- main  -->
<div class="m-content">

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Incentive Eligibility Details of {!! "&nbsp;" !!} <b>{{ AyraHelp::getUser(Request::segment(2))->name}}</b>
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
            <h5>All Approved Order's Revenue Chart</h5>
            <br>
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_IncentiveEligibilityData">
                <thead>
                    <tr>
                        <th>S#</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                        <th>Ship Address</th>
                        <th>Company Agent</th>
                        <th>Company Name</th>
                        <th>Total Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>61715-075</td>
                        <td>CN</td>
                        <td>Tieba</td>
                        <td>746 Pine View Junction</td>
                        <td>Nixie Sailor</td>
                        <td>Gleichner, Ziemann and Gutkowski</td>
                        <td>100.65</td>
                    </tr>
                    <tr>
                        <td>63629-4697</td>
                        <td>ID</td>
                        <td>Cihaur</td>
                        <td>01652 Fulton Trail</td>
                        <td>Emelita Giraldez</td>
                        <td>Rosenbaum-Reichel</td>
                        <td>100.41</td>
                    </tr>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Order ID</th>
                        <th>Ship Country</th>
                        <th>Ship City</th>
                        <th>Ship Address</th>
                        <th>Company Agent</th>
                        <th>Company Name</th>
                        <th>Total Payment</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <!-- form  -->


</div>
</div>

<!-- END EXAMPLE TABLE PORTLET-->

<!-- form  -->
</div>
</div>

</div>