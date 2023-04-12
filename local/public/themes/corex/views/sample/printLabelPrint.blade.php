<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Print Preview
                        <?php

                        // echo "<pre>"; 
                        // print_r($sample_arr_Admin);
                        // die;
                        ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" id="btnPrintSampleXL_P" class="btn btn-info  m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-print"></i>
                                <span>PRINT</span>
                            </span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item"></li>
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
                </ul>
            </div>
        </div>
        <div class="m-portlet__body0" style="margin:1px">

            <div id="div_printmeXL_P" style="margin-left: 15px;">

                <?php
                // print_r($today_dispatch_sent)


                foreach ($today_dispatch_sent as $key => $row) {

                ?>

                    <table cellspacing="0" border="0" style="margin:5px">
                        <colgroup span="4" width="85"></colgroup>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=4 height="55" align="center" valign=middle><br><img src="logo_1.jpg" width=270 height=55 hspace=38 vspace=6>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="17" align="center" valign=middle bgcolor="#FFFFFF">ID: <b>{{@$row->sample_code}}<b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle> TID:<b>{{@$row->track_id}}<b></td>
                        </tr>


                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 0px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle style="mar"><b> To,</b></td>
                        </tr>
                        <tr>
                            <td style="border-top: 0px solid #000000; border-bottom: 0px solid #FFFF; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="17" align="left" valign=middle><b> {{@$row->name}}</b></td>
                        </tr>
                        <tr>
                            <td style="border-top: 0px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=4 height="59" align="left" valign=top><b> {{@$row->address}}</b></td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><b>Phone</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle> <b>{{$row->phone}}</b></td>
                        </tr>




                    </table>





                <?php

                }
                ?>






            </div>



        </div>
    </div>
</div>
<!-- main  -->