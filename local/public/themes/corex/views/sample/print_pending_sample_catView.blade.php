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


            <!-- kk -->

            <!-- kk -->
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

            <style type="text/css">
                body,
                div,
                table,
                thead,
                tbody,
                tfoot,
                tr,
                th,
                td,
                p {
                    font-family: "Liberation Sans";
                    font-size: x-small
                }

                a.comment-indicator:hover+comment {
                    background: #ffd;
                    position: absolute;
                    display: block;
                    border: 1px solid black;
                    padding: 0.5em;
                }

                a.comment-indicator {
                    background: red;
                    display: inline-block;
                    border: 1px solid black;
                    width: 0.5em;
                    height: 0.5em;
                }

                comment {
                    display: none;
                }
            </style>
            <div id="div_printme">

                <table class="table table-bordered m-table m-table--border-primary" style="border:1px: solid #000 !important;">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Pending to dispatch since
                            </th>
                            <td>3 Days: <span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(3)}}</b></span></td>
                            <td>7 Days :<span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(7)}}</b></span></td>
                            <td>15 Days : <span class="m-badge m-badge--info"><b>{{ $spcount=AyraHelp::samplePendingDispatch(15)}}</b></span></td>
                        </tr>
                    </thead>
                </table>
                <h4>3 Days Pending List</h4>
                <table cellspacing="0" border="1">
                    <colgroup width="20"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="337"></colgroup>
                    <colgroup width="210"></colgroup>
                    <?php
                    $i = 0;
                    $scat = Request::segment(2);

                    foreach (AyraHelp::samplePendingDispatchData(3, $scat) as $key => $value) {
                        $i++;
                                                
                        $sType = "";
                        switch ($value->sample_type) {
                            case 1:
                                $sType = "STANDARD COSMETIC";
                                break;
                            case 2:
                                $sType = "OILS";
                                break;
                            case 3:
                                $sType = "GENERAL CHANGES";
                                break;
                            case 4:
                                $sType = "AS PER BENCHMARK";
                                break;
                            case 5:
                                $sType = "MODIFICATIONS";
                                break;
                        }
                    ?>
                        <tr>
                            <td height="20" align="center" valign=middle><b>{{$i}}</b></td>
                            <td height="20" align="center" valign=middle><b>{{$value->sample_code}}</b></td>
                            <td align="center" valign=middle><b>{{date('D d,F Y', strtotime($value->created_at))}}</b></td>
                            <td align="center" valign=middle><b>{{$value->ship_address}}</b></td>
                            <td align="center" valign=middle><b>{{$sType}}</b></td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>

                <h4>7 Days Pending List</h4>
                <table cellspacing="0" border="1">
                    <colgroup width="20"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="337"></colgroup>
                    <colgroup width="210"></colgroup>
                    <?php
                    $i = 0;
                    foreach (AyraHelp::samplePendingDispatchData(7, $scat) as $key => $value) {
                        $i++;
                       
                        $sType = "";
                        switch ($value->sample_type) {
                            case 1:
                                $sType = "STANDARD COSMETIC";
                                break;
                            case 2:
                                $sType = "OILS";
                                break;
                            case 3:
                                $sType = "GENERAL CHANGES";
                                break;
                            case 4:
                                $sType = "AS PER BENCHMARK";
                                break;
                            case 5:
                                $sType = "MODIFICATIONS";
                                break;
                        }
                    ?>
                        <tr>
                            <td height="20" align="center" valign=middle><b>{{$i}}</b></td>
                            <td height="20" align="center" valign=middle><b>{{$value->sample_code}}</b></td>
                            <td align="center" valign=middle><b>{{date('D d,F Y', strtotime($value->created_at))}}</b></td>
                            <td align="center" valign=middle><b>{{$value->ship_address}}</b></td>
                            <td align="center" valign=middle><b>{{$sType}}</b></td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>

                <h4>15 Days Pending List</h4>
                <table cellspacing="0" border="1">
                    <colgroup width="20"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="150"></colgroup>
                    <colgroup width="337"></colgroup>
                    <colgroup width="210"></colgroup>
                    <?php
                    $i = 0;
                    foreach (AyraHelp::samplePendingDispatchData(15, $scat) as $key => $value) {
                        $i++;

                       
                        $sType = "";
                        switch ($value->sample_type) {
                            case 1:
                                $sType = "STANDARD COSMETIC";
                                break;
                            case 2:
                                $sType = "OILS";
                                break;
                            case 3:
                                $sType = "GENERAL CHANGES";
                                break;
                            case 4:
                                $sType = "AS PER BENCHMARK";
                                break;
                            case 5:
                                $sType = "MODIFICATIONS";
                                break;
                        }

                    ?>
                        <tr>
                            <td height="20" align="center" valign=middle><b>{{$i}}</b></td>
                            <td height="20" align="center" valign=middle><b>{{$value->sample_code}}</b></td>
                            <td align="center" valign=middle><b>{{date('D d,F Y', strtotime($value->created_at))}}</b></td>
                            <td align="center" valign=middle><b>{{$value->ship_address}}</b></td>
                            <td align="center" valign=middle><b>{{$sType}}</b></td>
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