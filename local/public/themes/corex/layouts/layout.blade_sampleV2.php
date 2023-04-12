<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use App\Helpers\AyraHelp;
    use Illuminate\Support\Facades\Auth;

    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    ?>
    {!! meta_init() !!}
    <meta name="keywords" content="@get('keywords')">
    <meta name="description" content="@get('description')">
    <meta name="author" content="@get('author')">
    <meta name="BASE_URL" content="{{ url('/') }}" />
    <meta name="UUID" content="{{Auth::user()->id}}" />
    <meta name="BASE_URL" content="{{ url('/') }}" />
    <meta name="UNIB" content="{{ $user_role }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@get('title')</title>
    <link href="{{ asset('local/public/themes/corex/assets/vendors/base/vendors.bundle.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('local/public/themes/corex/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('local/public/themes/corex/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('local/public/themes/corex/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('local/public/img/logo/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('local/public/themes/corex/assets/owl/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('local/public/themes/corex/assets/owl/owl.theme.default.min.css')}}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> -->
    <link rel="stylesheet" href="{{ asset('local/public/themes/corex/assets/core_tree/Treant.css')}} ">
    <link rel="stylesheet" href="{{ asset('local/public/themes/corex/assets/core_tree/basic-example.css')}} ">

    <!--begin::Web font -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script> -->

    <!--end::Web font -->

</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">



        @partial('header')
        @partial('leftside')


        <!-- <div id="current">Initializing...</div> -->

        @content()



        @partial('footer')
        <!-- <div id="map_canvas" style="width:0; height:0" style="display:none"></div> -->

        @partial('quicknav')
        <!--begin::Global Theme Bundle -->

        <script src="{{ asset('local/public/themes/corex/assets/vendors/base/vendors.bundle.js') }} " type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/demo/default/base/scripts.bundle.js') }} " type="text/javascript"></script>

        <!--end::Global Theme Bundle -->

        <!--begin::Page Vendors -->
        <script src="{{ asset('local/public/themes/corex/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>

        <!--end::Page Vendors -->


        <!--begin::Page Scripts -->

        <script src="{{ asset('local/public/themes/corex/assets/app/js/datalist.js') }} " type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/ajax_client_list_.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/ajax_sample_list_.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/ajax_orders_list_.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/stock.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/purchase.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/js/vendors.js') }}" type="text/javascript"></script>
        
        <script src="{{ asset('local/public/themes/corex/assets/dropzone.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            BASE_URL = $('meta[name="BASE_URL"]').attr('content');
            UID = $('meta[name="UUID"]').attr('content');
            _TOKEN = $('meta[name="csrf-token"]').attr('content');
            _UNIB_RIGHT = $('meta[name="UNIB"]').attr('content');
        </script>
        <script>
            if (UID != 1 || UID != 156) {

                    $(document).bind('keydown', function(e) {
                  if(e.ctrlKey && (e.which == 83)) {
                    e.preventDefault();
                   // alert('Ctrl+S');
                    return false;
                  }
                });

                $(document).bind('keydown', function(e) {
                  if(e.ctrlKey && (e.which == 85)) {
                    e.preventDefault();
                   // alert('Ctrl+S');
                    // return false;
                  }
                });



                $(document).ready(function() {
                    // $(document).bind("contextmenu",function(e){
                    //    return false;
                    // });
                });

            }
        </script>
        <!-- highchart graph -->
        <script src="{{ asset('local/public/Highcharts820/code/highcharts.js')}}"></script>
        <script src="{{ asset('local/public/Highcharts820/code/highcharts-3d.js')}}"></script>
        <script src="{{ asset('local/public/Highcharts820/code/modules/exporting.js')}}"></script>
        <script src="{{ asset('local/public/Highcharts820/code/modules/export-data.js')}}"></script>
        <script src="{{ asset('local/public/Highcharts820/code/modules/accessibility.js')}}"></script>

        <?php
        if (Auth::user()->id == 1 || Auth::user()->id == 90 ||Auth::user()->id == 171 ) {
        ?>
            <script src="{{ asset('local/public/themes/corex/assets/js/high_chart.js')}}" type="text/javascript"></script>
        <?php

        }
        ?>
        <?php
        if (Auth::user()->id != 1 || Auth::user()->id != 90 || Auth::user()->id != 134 || Auth::user()->id != 141) {
        ?>
            <script src="{{ asset('local/public/themes/corex/assets/js/high_chart_sales.js')}}" type="text/javascript"></script>
        <?php

        }
        ?>
        <?php
        if (Auth::user()->id != 1 || Auth::user()->id != 90 || Auth::user()->id != 134 || Auth::user()->id != 141) {
        ?>
            <script src="{{ asset('local/public/themes/corex/assets/js/high_chart_lead_manager.js')}}" type="text/javascript"></script>
        <?php

        }
        ?>

        <!-- highchart graph -->

        <!-- Resources -->
        <script src="{{ asset('local/amcharts4/core.js') }} "></script>
        <script src="{{ asset('local/amcharts4/charts.js') }}"></script>
        <script src="{{ asset('local/amcharts4/themes/animated.js') }}"></script>
        <script src="{{ asset('local/amcharts4Chart.js') }}"></script>



        <!-- Resources -->
        <!-- <script src="{{ asset('local/public/themes/corex/assets/js/geoPosition.js') }}" type="text/javascript" charset="utf-8"></script> -->
        <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->

      
        <!-- <script src="{{ asset('local/public/themes/corex/assets/js/loader.js') }}" type="text/javascript"></script> -->

        


        <script src="{{ asset('local/public/themes/corex/assets/js/form_validation.js') }}" type="text/javascript"></script>

        <script src="{{ asset('local/public/themes/corex/assets/js/ayra.js') }}" type="text/javascript"></script>
        <script src="{{ asset('local/public/themes/corex/assets/app/js/dashboard.js') }} " type="text/javascript"></script>

        <script src="{{ asset('local/public/themes/corex/assets/demo/default/custom/crud/forms/widgets/summernote.js')}}" type="text/javascript"></script>

        <?php


        if (\Request::fullUrl() == Request::root() || Request::segment(1) == "inbound-call-report") {
            if (Auth::user()->id == 1 || Auth::user()->id == 90 ||  Auth::user()->id == 156 ||  Auth::user()->id == 171) {
        ?>
                <!-- <script src="{{ asset('local/public/themes/corex/assets/js/googleMap.js') }}" type="text/javascript"></script> -->
            <?php

            } else {
            ?>
                <!-- <script src="{{ asset('local/public/themes/corex/assets/js/googleMapSale.js') }}" type="text/javascript"></script> -->
        <?php
            }
        }
        ?>





        <script>
            $(document).ready(function() {


                //sampleSelectCat
                // $('#sampleSelectCat').click(funct);
                $('#sampleSelectCat').on('change', function() {

                    // ajax 
                    var formData = {
                        'catType': this.value,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    $.ajax({
                        url: BASE_URL + '/getSampleListbyCatType',
                        type: 'POST',
                        data: formData,
                        success: function(res) {



                            $('#m_select2_9A')
                                .find('option')
                                .remove()
                                .end()
                                .append(res)
                                .val('1');



                        }
                    });
                    // ajax 
                });

                $('#m_select2_9A').on('change', function() {

                    var selectCat9A = $('#m_select2_9A').find('option:selected');
                    var valueSELECTA = selectCat9A.val(); //to get content of "value" attrib
                    var textSELECTA = selectCat9A.text();
                    var index = valueSELECTA.indexOf("97116");
                    var textDesc = "";
                    var accessFiled = "";

                    if (index !== -1) {
                        accessFiled = "readonly";
                        textDesc = "STANDARD";
                        $('#txtDisInFO').val(textDesc);
                        $('#txtDisInFO').attr("readonly", true);


                    } else {
                        accessFiled = "";
                        textDesc = "";
                        $('#txtDisInFO').val(textDesc);
                        $('#txtDisInFO').attr("readonly", false);
                    }

                });
                //sampleSelectCat

                //btnSaveSampleItem
                $('#btnSaveSampleItem').click(function() {
                    var itemName = $('#txtSampleNewItem').val();


                    var selectCat = $('#sampleSelectCat').find('option:selected');
                    var valueSELECT = selectCat.val(); //to get content of "value" attrib

                    if (valueSELECT == "") {
                        toasterOptions();
                        toastr.error('Please Select Category ', 'Sample Alert');
                        return false;
                    }
                    //ajax
                    var formData = {
                        'catType': valueSELECT,
                        'itemName': itemName,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    $.ajax({
                        url: BASE_URL + '/saveOtherSampleName',
                        type: 'POST',
                        data: formData,
                        success: function(res) {
                            console.log(res);
                            $('#m_select2_9A').append(`<option  value="${res.item_name}">${res.item_name}</option>`)
                                .filter("[value=${itemName}]")
                                .attr('selected', true);

                        },
                        dataType: 'json'

                    });
                    //ajax
                    $('#m_modal_SampleAddItem').modal('toggle');
                })
                //btnSaveSampleItem

                var max_fields = 100; //maximum input boxes allowed
                var wrapper = $(".input_fields_wrap"); //Fields wrapper
                var add_button = $(".add_field_button"); //Add button ID
                
               

                var x = 1; //initlal text box count
                $(add_button).click(function(e) { //on add input button click
                    var sampleSelectCatVal=$("#sampleSelectCat option:selected").val();  

                   
                  

                    e.preventDefault();
                    if (x < max_fields) { //max input box allowed
                        x++; //text box increment

                        var selectCat = $('#sampleSelectCat').find('option:selected');
                        var valueSELECT = selectCat.val(); //to get content of "value" attrib
                        var textSELECT = selectCat.text();

                        var selectCat9A = $('#m_select2_9A').find('option:selected');
                        var valueSELECTA = selectCat9A.val(); //to get content of "value" attrib
                        var textSELECTA = selectCat9A.text();
                        var ajvalSEL = valueSELECTA;
                        var pricePerKg = $('#m_inputmask_6').val();

                        // brand 
                        var selectBrandType = $('#selectBrandType').find('option:selected');
                        var valueSELECTBrandType = selectBrandType.val(); //to get content of "value" attrib
                        var textSELECTBrandType = selectBrandType.text();
                       

                        //order size
                        var selectOrderSize = $('#selectOrderSize').find('option:selected');
                        var valueOrderSize = selectOrderSize.val(); //to get content of "value" attrib
                        var textOrderSize = selectOrderSize.text();
                        if (valueSELECTBrandType === "") {
                            toasterOptions();
                            toastr.error('ERROR', 'Select Brand Type');
                            return false;

                        }
                        if (valueOrderSize === "") {
                            toasterOptions();
                            toastr.error('ERROR', 'Select order Size');
                            return false;

                        }

                        if (pricePerKg === "") {
                            toasterOptions();
                            toastr.error('ERROR', 'Invalid Price');
                            return false;

                        }
                       


                        var index = valueSELECTA.indexOf("97116");
                        var textDesc = "";
                        var accessFiled = "";

                        if (index !== -1) {



                            accessFiled = "readonly";
                            textDesc = "STANDARD";

                        } else {


                            accessFiled = "";
                            textDesc = "";
                        }
                        var txtDescINFO = $('#txtDisInFO').val();
                      //  $('#selectBrandType').attr('disabled', 'disabled');
                        //$('#selectOrderSize').attr('disabled', 'disabled');

                       
                        if(sampleSelectCatVal==5){
                            $('.add_field_button').css('display', 'block');
                            
                            $('.orderSampleIDViewSample').attr("disabled", true);

                        }else{
                            $('.add_field_button').css('display', 'block');
                            $('.orderSampleIDViewSample').attr("disabled", false);
                        }
                

                        $(wrapper).append(`
                        <select style="visibility:hidden" name="sampleType[]" class="form-control m-input" id="exampleSelect1">                                           
                                            <option value="${valueSELECT}">${textSELECT}</option>                                            
                                        </select>

                        <div class="form-group m-form__group row">
                                   
                                    <div class="col-lg-4">
                                        <label class="">Item Name:</label>
                                        <select name="sampleItemName[]" class="form-control " id="m_selec5t2_9A" name="param">
                                        <option value="${textSELECTA}">${textSELECTA}</option> 
                                           
                                        </select>
                                    </div>
                                  
                                    <div class="col-lg-4">    
                                    <label style="color:#000">Descriptions:</label>
                                        <div class="input-group m-input-group m-input-group--square">

                                            <input ${accessFiled}  value ="${txtDescINFO}" style="" type="text" name="sampleDiscription[]" class="form-control m-input" placeholder="">
                                        </div>

                                            
                                        
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <label style="color:#000">Target Price/Kg:</label>
                                        <div class="input-group m-input-group m-input-group--square">

                                            <input readonly value ="${pricePerKg}" style="" type="text" name="price_per_kg[]" class="form-control m-input" placeholder="">
                                        </div>
                                        <span class="m-form__help"></span>
                                    </div>
                                   

                                    <div class="col-lg-2">
                                        
                                        <a href="#"  style="margin-top:30px" title="DELETE" class="remove_field btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                    <i class="flaticon-delete"></i>
														</a>
                                    </div>



                                    
                                </div>`); //add input box
                    }
                });

                $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text

                    e.preventDefault();
                    toasterOptions();
                    toastr.success('Deleted items ', 'Sample ');
                    $(this).parent().parent('div').remove();
                    x--;
                    return false;


                })
            });
        </script>

        <script src="{{ asset('local/public/themes/corex/assets/demo/default/custom/crud/forms/widgets/typeahead.js')}}" type="text/javascript"></script>

        <script type="text/javascript">
            function chkInternetStatus() {
                if (navigator.onLine) {
                    //alert("Hurray! You're online!!!");
                } else {
                    alert("Oops! You're offline. Please check your network connection...");
                }
            }


            setInterval(function() {

                if (UID == 84 || UID == 27 || UID == 95) {
                    chkInternetStatus();
                }

            }, 5000);
        </script>
        <script src="{{ asset('local/public/themes/corex/assets/owl/dist/owl.carousel.min.js')}}"></script>



        <script>
            function submit6Dispatach(e) {
                //  alert(555);
                $data = $("myFormFinalDispatchV1").serialize();
                console.log($data);
                e.preventDefault();
                return false;


                // $.ajax({
                // url: BASE_URL+'/setSaveProcessAction',
                // type: 'POST',
                // data: formData,
                //     success: function(res) {

                //     }
                // });

            }
            //btnGenPurchaseOrderDone
            function btnGenPurchaseRecivedDone() {
                var BOMIDRV = $('#BOMIDRV').val();
                var txtRECQTY = $('#txtRECQTY').val();
                var txtGRPONumber = $('#txtGRPONumber').val();
                var txtRemarks = $('#txtRemarks_REC').val();
                //ajax
                var formData = {
                    'BOMIDRV': BOMIDRV,
                    'txtRECQTY': txtRECQTY,
                    'txtGRPONumber': txtGRPONumber,
                    'txtRemarks': txtRemarks,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveVendorOrderRecieved',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Purcase Stage Process');
                            return false;
                        }
                        if (res.status == 1) {
                            toasterOptions();
                            toastr.success(res.msg, 'Purcase Stage Process');
                            //location.reload();
                            return false;
                        }


                    }
                });
                //ajax



            }

            function btnGenPurchaseOrderDone() {
                var BOMID = $('#BOMID').val();
                var txtPO_NO = $('#txtPO_NO').val();
                var txtETA = $('#m_datepicker_1ETA').val();
                var txtRemarks = $('#txtRemarks').val();

                var venderID = $("#venderID option:selected").val();
                //ajax
                var formData = {
                    'BOMID': BOMID,
                    'txtPO_NO': $('#txtPO_NO').val(),
                    'venderID': $('#venderID').html(),
                    'txtETA': txtETA,
                    'txtRemarks': txtRemarks,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveVendorOrder',
                    type: 'POST',
                    data: formData,
                    success: function(res) {
                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Purcase Stage Process');
                            return false;
                        }
                        if (res.status == 1) {
                            toasterOptions();
                            toastr.success(res.msg, 'Purcase Stage Process');
                            //location.reload();
                            return false;
                        }




                    },
                    dataType: 'json'

                });
                //ajax






            }
            //btnGenPurchaseOrderDone



            function btnGenCommentDone() {
                var formData = {
                    'txtStage_ID': $('#txtStage_ID').val(),
                    'txtTicketID': $('#txtTicketID').val(),
                    'txtProcessID': $('#txtProcessID').val(),
                    'txtDependentTicketID': $('#txtDependentTicketID').val(),
                    'txtRemarks': $('#message-text').val(),
                    'action_on': 0,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveProcessAction',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Stage Process');
                            return false;

                        } else {
                            toasterOptions();
                            toastr.success(res.msg, 'Stage Process');
                            //location.reload();
                            $('#model_BO_task_12').modal('hide');

                        }
                    },
                    dataType: 'json'
                });

                //ajax call
            }


            //btnGenProcessDoneSAMPLE_DISPATCH
            function btnGenProcessDoneSAMPLE_DISPATCH() {
                //ajax call
                var txtStage_ID = $('#txtStage_ID').val();
                var pid = $('#txtProcessID').val();
                var msg = $('#message-text').val();
                var tikID = $('#txtTicketID').val();
                var courier_data_5 = $('#courier_data_5').val()
                var dataSent = $('#m_datepicker_3_5').val()
                var track_id_5 = $('#track_id_5').val()

                if (courier_data_5 == "" || dataSent == "" || track_id_5 == "") {
                    toasterOptions();
                    toastr.error('Invalid Entry', 'Stage Process');
                    return false;

                }
                var dateData = $('#m_datepicker_3_5').val();

                if (dateData == null) {
                    toasterOptions();
                    toastr.error('Enter date Of Dispatch', 'Dispatch Sample');
                    return false;
                }





                var formData = {
                    'txtStage_ID': $('#txtStage_ID').val(),
                    'txtTicketID': $('#txtTicketID').val(),
                    'txtProcessID': $('#txtProcessID').val(),
                    'txtDependentTicketID': $('#txtDependentTicketID').val(),
                    'txtRowCount': $('#txtRowCount').val(),
                    'txtRemarks': $('#message-text').val(),
                    'courier_data': $('#courier_data_5').val(),
                    'm_datepicker_3': $('#m_datepicker_3_5').val(),
                    'track_id': $('#track_id_5').val(),
                    'action_on': 1,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveProcessAction',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Stage Process');
                            // $('#model_BO_task_4').modal('toggle');
                            return false;

                        } else {
                            toasterOptions();
                            toastr.success(res.msg, 'Stage Process');
                            //location.reload();
                            //$('#model_BO_task_4').modal('toggle');
                            // if (pid == 4 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add_stage_sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            // if (pid == 5 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add-mylead-sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            //$('#model_BO_task_1').modal('hide');

                        }
                    },
                    dataType: 'json'
                });

                //ajax call

            }

            //btnGenProcessDoneSAMPLE_DISPATCH

            //btnGenProcessDoneSAMPLE
            function btnGenProcessDoneSAMPLE() {
                //ajax call
                var txtStage_ID = $('#txtStage_ID').val();
                var pid = $('#txtProcessID').val();
                var msg = $('#message-text').val();
                var tikID = $('#txtTicketID').val();

                if ($('#txtFormulationID').val() == "") {
                    toasterOptions();
                    toastr.error('Enter Formulation', 'Sample Stage Process');
                    $('#txtFormulationID').focus();
                    return false;

                }
                if ($('#txtFragranceName').val() == "") {
                    toasterOptions();
                    toastr.error('Enter Fragrance Name', 'Sample Stage Process');
                    $('#txtFragranceName').focus();
                    return false;

                }

                if ($('#txtColorName').val() == "") {
                    toasterOptions();
                    toastr.error('Enter Color Name', 'Sample Stage Process');
                    $('#txtColorName').focus();
                    return false;

                }

                if ($('#txtChemistID').val() == "") {
                    toasterOptions();
                    toastr.error('Enter Chemist Name', 'Sample Stage Process');
                    $('#txtChemistID').focus();
                    return false;

                }


                if ($('#message-text').val() == "") {
                    toasterOptions();
                    toastr.error('Enter Remarks ', 'Sample Stage Process');
                    $('#message-text').focus();
                    return false;

                }








                var formData = {
                    'txtStage_ID': $('#txtStage_ID').val(),
                    'txtTicketID': $('#txtTicketID').val(),
                    'txtProcessID': $('#txtProcessID').val(),
                    'txtDependentTicketID': $('#txtDependentTicketID').val(),
                    'txtRowCount': $('#txtRowCount').val(),
                    'txtRemarks': $('#message-text').val(),
                    'txtFormulationID': $('#txtFormulationID').val(),
                    'txtFragranceName': $('#txtFragranceName').val(),
                    'txtColorName': $('#txtColorName').val(),
                    'txtChemistID': $('#txtChemistID').val(),
                    'action_on': 1,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveProcessAction',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Stage Process');
                            $('#model_BO_task_4').modal('toggle');
                            return false;

                        } else {
                            toasterOptions();
                            toastr.success(res.msg, 'Stage Process');
                            location.reload();
                            //$('#model_BO_task_4').modal('toggle');

                            // if (pid == 4 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add_stage_sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            // if (pid == 5 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add-mylead-sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            //$('#model_BO_task_1').modal('hide');

                        }
                    },
                    dataType: 'json'
                });

                //ajax call

            }


            //btnGenProcessDoneSAMPLE
            function btnGenProcessDone() {
                //ajax call
                var txtStage_ID = $('#txtStage_ID').val();
                var pid = $('#txtProcessID').val();
                var msg = $('#message-text').val();
                var tikID = $('#txtTicketID').val();

                if (pid == 4 && txtStage_ID == 6 && msg == "") {
                    toasterOptions();
                    toastr.error('Enter Message for lost', 'Stage Process');
                    return false;

                }

                //           if(pid==4 && txtStage_ID==3){
                //     _redirect_sample =BASE_URL+'/add_stage_sample/'+tikID
                //     window.location.assign(_redirect_sample);

                // }
                //return false;



                var formData = {
                    'txtStage_ID': $('#txtStage_ID').val(),
                    'txtTicketID': $('#txtTicketID').val(),
                    'txtProcessID': $('#txtProcessID').val(),
                    'txtDependentTicketID': $('#txtDependentTicketID').val(),
                    'txtRowCount': $('#txtRowCount').val(),
                    'txtRemarks': $('#message-text').val(),
                    'action_on': 1,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveProcessAction',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Stage Process');
                            $('#model_BO_task_1').modal('toggle');
                            return false;

                        } else {
                            toasterOptions();
                            toastr.success(res.msg, 'Stage Process');
                            //location.reload();
                            $('#model_BO_task_1').modal('toggle');
                            // if (pid == 4 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add_stage_sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            // if (pid == 5 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add-mylead-sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            //$('#model_BO_task_1').modal('hide');

                        }
                    },
                    dataType: 'json'
                });

                //ajax call

            }
        </script>


        <!--begin::Modal-->
        <div class="modal fade" id="model_BO_task_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stage Action</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtStage_ID">
                        <input type="hidden" id="txtTicketID">
                        <input type="hidden" id="txtDependentTicketID">
                        <input type="hidden" id="txtProcessID">
                        <input type="hidden" id="txtRowCount">
                        <form>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                        <a href="javascript::void(0)" onclick="btnGenCommentDone()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-commenting"></i>
                                <span>Comment</span>
                            </span>
                        </a>
                        <a href="javascript::void(0)" onclick="btnGenProcessDone()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Completed</span>
                            </span>
                        </a>


                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->
        <style>
            .modalA {
                max-width: 1111px;
            }
        </style>
        <div class="modal fade" id="model_sampleFormulaAppsViews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modalA" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Sample Formulation Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ajsampleFormulaviewDetail" style="background-color:#FFF">
                        <!-- ajcode sample  -->

                        <!-- ajcode sample  -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

        <!--begin::Modal-->
        <div class="modal fade" id="model_BO_task_51" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modalA" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Sample Formulation Form Actions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color:#16425b">
                        <!-- ajcode sample  -->
                        <!--begin::Form-->
                        <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_3_sampleIngredntSave">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title " style="color:#FFF">Sample ID:<b class="sampleICode">AZS-1010</b></h3>
                                    </div>
                                    <input type="hidden" name="txtSIDValue" id="txtSIDValue">
                                    <div class="sampleItemView">

                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-accent">Sumit</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- ajcode sample  -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->


        <!--begin::Modal-->
        <div class="modal fade" id="model_BO_task_515" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Formulations Stage Actions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtStage_ID">
                        <input type="hidden" id="txtTicketID">
                        <input type="hidden" id="txtDependentTicketID">
                        <input type="hidden" id="txtProcessID">
                        <input type="hidden" id="txtRowCount">
                        <form>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Formulation No:</label>

                                <input required type="text" id="txtFormulationID" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Fragrance:</label>

                                <input required type="text" id="txtFragranceName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Colour:</label>

                                <input required type="text" id="txtColorName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Chemist:</label>

                                <select required name="" id="txtChemistID" class="form-control">
                                    <option value="149">Niti Gupta</option>
                                    <option value="126">Anita Hari Das</option>
                                    <option value="124">Amit Singh</option>
                                    <option value="150">Bhuvan</option>
                                    <option value="151">Priyanka chaudhary</option>
                                    <option value="152">Md. Shahbaz Shams</option>
                                    <option value="153">Pooja Sharma</option>
                                    <option value="154">Anamika Singh</option>
                                    <option value="155">Sanoj kumar sharma</option>


                                </select>

                            </div>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea required class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">


                        <a href="javascript::void(0)" onclick="btnGenProcessDoneSAMPLE()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Submit</span>
                            </span>
                        </a>


                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->

        <!--begin::Modal-->
        <div class="modal fade" id="model_BO_task_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Dispatch Stage Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtStage_ID">
                        <input type="hidden" id="txtTicketID">
                        <input type="hidden" id="txtDependentTicketID">
                        <input type="hidden" id="txtProcessID">
                        <input type="hidden" id="txtRowCount">
                        <form>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Courier:</label>

                                <select required class="form-control m-input m-input--air" id="courier_data_5">
                                    <option value="">-SELECT-</option>
                                    <option value="1">DTDC</option>
                                    <option value="2">BLUE DART</option>
                                    <option value="3">OTHER</option>
                                    <option value="4">HANDED OVER</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Sent Date::</label>

                                <input required type="text" class="form-control m-input" readonly="" id="m_datepicker_3_5">

                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Tracking ID:</label>

                                <input required type="text" class="form-control m-input" id="track_id_5" placeholder="Enter TracK ID">
                            </div>


                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">


                        <a href="javascript::void(0)" onclick="btnGenProcessDoneSAMPLE_DISPATCH()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Submit</span>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->






        <div class="modal fade" id="model_BO_task_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Vender</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="BOMID">
                        <form>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Select Vender</label>
                                <select name="venderID" id="venderID" class="form-control">
                                    <?php
                                    $datas = AyraHelp::getAllVendors();
                                    foreach ($datas as $key => $rowData) {
                                    ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}-{{$rowData->vendor_name}} </option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">PO No.:</label>
                                <input type="text" class="form-control" id="txtPO_NO"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">ETA(Estimated Time of Arrival):</label>
                                <input type="text" class="form-control" id="m_datepicker_1ETA"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea class="form-control" id="txtRemarks"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                        <!-- <a href="javascript::void(0)" onclick="btnGenCommentDone()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
        <span>
        <i class="la la-commenting"></i>
            <span>Comment</span>
        </span>
		</a> -->
                        <a href="javascript::void(0)" onclick="btnGenPurchaseOrderDone()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Order Now</span>
                            </span>
                        </a>


                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->


        <div class="modal fade" id="model_BO_task_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Received Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="BOMIDRV">

                        <form>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">GRPO No.:</label>
                                <input type="text" class="form-control" id="txtGRPONumber"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Received QTY.:</label>
                                <input type="text" class="form-control" id="txtRECQTY"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea class="form-control" id="txtRemarks_REC"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                        <!-- <a href="javascript::void(0)" onclick="btnGenCommentDone()" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
        <span>
        <i class="la la-commenting"></i>
            <span>Comment</span>
        </span>
		</a> -->
                        <a href="javascript::void(0)" onclick="btnGenPurchaseRecivedDone()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Recived Now</span>
                            </span>
                        </a>


                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->


        <script>
            $(document).ready(function() {


                $("#owl-demo").owlCarousel({

                    navigation: true, // Show next and prev buttons
                    slideSpeed: 300,
                    paginationSpeed: 400,
                    singleItem: true

                    // "singleItem:true" is a shortcut for:
                    // items : 1,
                    // itemsDesktop : false,
                    // itemsDesktopSmall : false,
                    // itemsTablet: false,
                    // itemsMobile : false

                });




                //general process
                $('#btnGenProcessDone').click(function() {

                    //ajax call
                    var formData = {
                        'txtStage_ID': $('#txtStage_ID').val(),
                        'txtTicketID': $('#txtTicketID').val(),
                        'txtProcessID': $('#txtProcessID').val(),
                        'txtProcessID': $('#txtProcessID').val(),
                        'txtRowCount': $('#txtRowCount').val(),
                        'txtRemarks': $('#message-text').val(),
                        'action_on': 1,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    $.ajax({
                        url: BASE_URL + '/setSaveProcessAction',
                        type: 'POST',
                        data: formData,
                        success: function(res) {

                            if (res.status == 0) {
                                toasterOptions();
                                toastr.error(res.msg, 'Stage Process');
                                return false;

                            } else {
                                toasterOptions();
                                toastr.success(res.msg, 'Stage Process');
                                //location.reload();
                                $('#model_BO_task_1').modal('hide');

                            }
                        },
                        dataType: 'json'
                    });

                    //ajax call
                });

                //general process
                // select name, count(name) from contacts group by name;
                //general commnet
                //btnStageProcessCompletedNow
                $('#btnGenCommentDone').click(function() {

                    //ajax call
                    var formData = {
                        'txtStage_ID': $('#txtStage_ID').val(),
                        'txtTicketID': $('#txtTicketID').val(),
                        'txtProcessID': $('#txtProcessID').val(),
                        'txtProcessID': $('#txtProcessID').val(),
                        'txtRemarks': $('#message-text').val(),
                        'action_on': 0,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    };
                    $.ajax({
                        url: BASE_URL + '/setSaveProcessAction',
                        type: 'POST',
                        data: formData,
                        success: function(res) {

                            if (res.status == 0) {
                                toasterOptions();
                                toastr.error(res.msg, 'Stage Process');
                                return false;

                            } else {
                                toasterOptions();
                                toastr.success(res.msg, 'Stage Process');
                                //location.reload();
                                $('#model_BO_task_12').modal('hide');

                            }
                        },
                        dataType: 'json'
                    });

                    //ajax call
                });
                //general commnet




            });
        </script>



        <!--begin::Modal-->
        <div class="modal fade" id="model_BO_task_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderString"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--begin::Form-->
                        <form id="myFormFinalDispatchV1" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="{{ route('UpdateOrderDispatch_v1')}}" method="post">
                            @csrf
                            <input type="hidden" id="txtorderStepID_v1" name="txtorderStepID1">
                            <input type="hidden" id="txtOrderID_FORMI_v1" name="txtOrderID_FORMID1">
                            <input type="hidden" id="txtProcess_days_v1" name="txtProcess_days1">
                            <input type="hidden" id="txtProcess_Name_v1" name="txtProcess_Name1">
                            <input type="hidden" id="txtStepCode_v1" name="txtStepCode1">
                            <input type="hidden" id="expectedDate_v1" value="{{date('Y-m-d')}}" name="expectedDate1">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>Resp .Person:</label>
                                        <select name="order_crated_by" id="order_crated_by" class="form-control">
                                            <?php
                                            $user = auth()->user();
                                            $userRoles = $user->getRoleNames();
                                            $user_role = $userRoles[0];
                                            ?>
                                            @if ($user_role =="Admin" || $user_role =="Staff")
                                            @foreach (AyraHelp::getSalesAgentAdmin() as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                            @else
                                            <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                            @endif
                                        </select>
                                        <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="message-text" class="form-control-label">Comment:</label>
                                        <textarea class="form-control" id="orderComment" name="orderComment">done</textarea>
                                        <span class="m-form__help"></span>
                                    </div>

                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-3">
                                        <label class="">Client Email:</label>
                                        <input type="text" id="txtClientEmail" name="txtClientEmail" class="form-control m-input" placeholder="Client Email">
                                        <span class="m-form__help"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="">Client Notify:</label>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox">
                                                <input type="checkbox" id="client_notify" name="client_notify" value="1"> Email Sent
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="">Total Order Units:</label>
                                        <input type="text" id="GtxtTotalOrderUnit" name="txtTotalOrderUnit" class="form-control m-input" placeholder="5000">
                                        <span class="m-form__help"></span>

                                    </div>
                                    <div class="col-lg-3">

                                        <div class="m-form__group form-group" style="display:none">
                                            <label for="">Dispatch Type</label>
                                            <div class="m-radio-inline">
                                                <label class="m-radio">
                                                    <input type="radio" name="dispatch_type" checked value="1"> Complete
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="dispatch_type" value="2"> Partial
                                                    <span></span>
                                                </label>

                                            </div>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                </div>
                                {{-- aja --}}
                                <?php
                                if (Auth::user()->id != 1 || Auth::user()->id != 156) {
                                ?>
                                    <style>
                                        .ajayra {
                                            -webkit-user-select: none;
                                            -khtml-user-select: none;
                                            -moz-user-select: none;
                                            -o-user-select: none;
                                            user-select: none;
                                        }
                                    </style>
                                <?php
                                }
                                ?>

                                <div id="m_repeater_3">
                                    <div class="row" id="m_repeater_3">
                                        <div data-repeater-list="orderFromData" class="col-lg-12" style="background-color:#ccc;border:1px red">
                                            <div data-repeater-item class="form-group m-form__group row">

                                                <div class="col-lg-3">
                                                    <label class="">LR NO:</label>
                                                    <input type="text" id="txtLRNo" name="txtLRNo" required class="form-control m-input" placeholder="LR NO">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Transpoter:</label>
                                                    <input <?php Auth::user()->id == 146 ? "required" : "required" ?> type="text" id="txtTransport" name="txtTransport" class="form-control m-input" placeholder="Transpoter">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Cartons:</label>
                                                    <input type="text" id="txtCartons" name="txtCartons" required class="form-control m-input" placeholder="Cartons">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Cartons(Units):</label>
                                                    <input value="0" type="text" id="txtCartonsEachUnit" name="txtCartonsEachUnit" <?php Auth::user()->id == 146 ? "required" : "" ?> class="form-control m-input" placeholder="Units in Cartons">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Total Units:</label>
                                                    <input value="0" type="text" id="txtTotalUnit" name="txtTotalUnit" <?php Auth::user()->id == 146 ? "required" : "" ?> class="form-control m-input" placeholder="Total Units">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Booking For: </label>
                                                    <input value="-" type="text" id="txtBookingFor" <?php Auth::user()->id == 146 ? "required" : "" ?> name="txtBookingFor" class="form-control m-input" placeholder="Booking For">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">PO NO.:</label>
                                                    <input type="text" id="txtPONumber" name="txtPONumber" <?php Auth::user()->id == 146 ? "required" : "" ?> class="form-control m-input" placeholder="">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Invoice No:</label>
                                                    <input value="-" type="text" id="txtInvoice" name="txtInvoice" class="form-control m-input" <?php Auth::user()->id == 146 ? "required" : "" ?> placeholder="Invoice No">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Per Unit Price:</label>
                                                    <input type="text" id="txtPerUnitPrice" name="txtPerUnitPrice" class="form-control m-input" <?php Auth::user()->id == 146 ? "required" : "" ?> placeholder="Per Unit price ">
                                                    <span class="m-form__help"></span>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label class="">Disptach Date:</label>
                                                    <input type="text" id="m_datepicker_1" name="txtDispatchDate" class="form-control m-input" required placeholder="Dispatch Date">
                                                    <span class="m-form__help"></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="">Client Email:</label>
                                                    <input type="text" id="txtClientEmailSend" name="txtClientEmailSend" class="form-control m-input" placeholder="Client Email">
                                                    <span class="m-form__help"></span>
                                                </div>


                                                <div class="col-md-3">
                                                    <div data-repeater-delete="" style="margin-top:31px" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                                                        <span>
                                                            <i class="la la-trash-o"></i>
                                                            <span>Remove</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="m-form__group form-group row">
                                        <label class="col-lg-2 col-form-label"></label>
                                        <div class="col-lg-4">
                                            <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>Add</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- aja --}}
                            </div>



                            <!--end::Form-->


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                            <span>
                                <span>Process Complete</span>
                            </span>
                        </button>


                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--end::Modal-->
        <script>
            $(document).ready(function() {

                $('.ajproview').hover(function() {
                    userId = $(this).attr('id');
                    photo = $(this).data("photo");
                    name = $(this).data("name");
                    phone = $(this).data("phone");
                    $('#txtEMPName').html(name);
                    $('.viewProfilePIC').html(`<!--begin:: Widgets/Blog-->
								<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force">
									<div class="m-portlet__head m-portlet__head--fit">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-action">
												<button type="button" class="btn btn-sm m-btn--pill  btn-brand"></button>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">
										<div class="m-widget19">
											<div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px">
												<img src="${photo}" alt="">

												<div class="m-widget19__shadow"></div>
											</div>
											<div class="m-widget19__content">
												<div class="m-widget19__header">

													<div class="m-widget19__info">
														<span class="m-widget19__username">
                                                        Phone:
														</span><br>

													</div>
													<div class="m-widget19__stats">
														<span class="m-widget19__number m--font-brand">
														${phone}
														</span>

													</div>
												</div>

											</div>

										</div>
									</div>
								</div>

								<!--end:: Widgets/Blog-->`);





                    $('#viewEMPPic').modal('show');

                });

                $("#myFormFinalDispatchV1").submit(function(e) {

                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);
                    var url = form.attr('action');

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function(res) {

                            if (res.status == 0) {
                                toasterOptions();
                                toastr.error(res.Message, 'Order Process');
                                return false;
                            } else {
                                toasterOptions();
                                toastr.success(res.Message, 'Order Process');
                                return false;
                            }


                        },
                        dataType: 'json'
                    });


                });



            });
        </script>


        <!--begin::Modal-->
        <div class="modal fade" id="viewEMPPic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="txtEMPName"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body viewProfilePIC">


                    </div>

                </div>
            </div>
        </div>

        <!--end::Modal-->

        <script type="text/javascript">


            //btnShowchemistWaiseOrder
            $('#btnShowchemistWaiseOrder').click(function() {
                $('.showChemistOrdersampleDetails').html("");
                var userid = $('#salesPerson').val();
                var txtMonth = $('#txtMonth').val();
                var txtyear = $('#txtyearData option:selected').val()

                var formData = {
                    'userid': userid,
                    'txtMonth': txtMonth,
                    'txtyear': txtyear,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/getSamplewiswOrderByChemist',
                    type: 'GET',
                    data: formData,
                    success: function(res) {
                        $('.showChemistOrdersampleDetails').html(res);
                    }
                });

            });
            //btnShowchemistWaiseOrder

            $('#btnShowFiletPIEChart').click(function() {

                var salesPerson = $('#salesPerson').val();
                var txtMonth = $('#txtMonth').val();
                var txtyear = $('#txtyear').val();



                // Load the Visualization API and the piechart package.
                google.charts.load('current', {
                    'packages': ['corechart']
                });

                // Set a callback to run when the Google Visualization API is loaded.
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var formData = {

                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'salesPerson': salesPerson,
                        'txtMonth': txtMonth,
                        'txtyear': txtyear,

                    };


                    var jsonData = $.ajax({
                        url: BASE_URL + '/getSampleFeedbackPIE',
                        dataType: "json",
                        type: "POST",
                        data: formData,
                        async: false
                    }).responseText;

                    // Create our data table out of JSON data loaded from server.
                    var data = new google.visualization.DataTable(jsonData);

                    console.log(jsonData);


                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById('b_sale'));
                    chart.draw(data, {
                        width: 400,
                        height: 240
                    });
                }

            });


            $('.carousel-main').owlCarousel({
                items: 3,
                loop: true,
                autoplay: false,
                autoplayTimeout: 1500,
                margin: 10,
                nav: true,
                dots: false,
                navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>'],
            })
        </script>


        <script>
            $(document).ready(function() {


                $(document).on('click', '.pagination a', function(event) {
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    fetch_data(page);
                });

                function fetch_data(page) {
                    $.ajax({
                        url: "/pagination/fetch_data?page=" + page,
                        success: function(data) {
                            $('#table_data').html(data);
                        }
                    });
                }

            });
        </script>

        <script type="text/javascript">
            var idleTime = 0;
            var mcount = 0;
            var keycount = 0;

            $(document).ready(function() {
                $('#btnRefesh').click(function() {
                    window.location.reload();
                });
                //Increment the idle time counter every minute.
                var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

                //Zero the idle timer on mouse movement.
                $(this).mousemove(function(e) {
                    idleTime = 0;
                    mcount = mcount + 1;
                    if (mcount == 350) {
                        //setActiveUserTODB(1);
                        mcount = 0;
                    }


                });
                $(this).keypress(function(e) {
                    idleTime = 0;
                    keycount = keycount + 1;
                    if (keycount == 100) {
                        //  setActiveUserTODB(1);
                        keycount = 0;
                    }
                    //setActiveUserTODB(1);
                });
            });

            function timerIncrement() {
                idleTime = idleTime + 1;
                if (idleTime >= 200) { // 20 minutes
                    idleTime = 0;
                    setActiveUserTODB(2); //idle
                    //window.location.reload();


                }
                if (idleTime == 200) { // 20 minutes
                    //  idleTime = 0;
                    setActiveUserTODB(1); //idle
                    //window.location.reload();


                }
            }

            function setActiveUserTODB(setType) {
                var formData = {
                    'setType': setType,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setlastActiveUser',
                    type: 'GET',
                    data: formData,
                    success: function(res) {
                        //  console.log(res);
                        if (res == "2") {
                            window.location.reload();
                        }
                    }
                });

            }


              //btnGenProcessDoneLeadSales
              function btnGenProcessDoneLeadSales() {
                var txtStage_ID = $('#txtStage_ID_SL').val();
                var pid = $('#txtProcessID_SL').val();
                var msg = $('#messagetextSL').val();
                var tikID = $('#txtTicketID_SL').val();
                if (pid == 7 && txtStage_ID == 6 && msg == "") {
                    toasterOptions();
                    toastr.error('Enter Message for lost', 'Stage Process');
                    return false;

                }
                //ajax 
                var formData = {
                    'txtStage_ID': $('#txtStage_ID_SL').val(),
                    'txtTicketID': $('#txtTicketID_SL').val(),
                    'txtProcessID': $('#txtProcessID_SL').val(),                    
                    'txtRemarks': msg,
                    'action_on': 1,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    url: BASE_URL + '/setSaveProcessActionSalesLead',
                    type: 'POST',
                    data: formData,
                    success: function(res) {

                        if (res.status == 0) {
                            toasterOptions();
                            toastr.error(res.msg, 'Stage Process');
                            $('#model_BO_salesLead_id').modal('toggle');
                            return false;

                        } else {
                            toasterOptions();
                            toastr.success(res.msg, 'Stage Process');
                            //location.reload();
                            $('#model_BO_salesLead_id').modal('toggle');
                            // if (pid == 7 && txtStage_ID == 3) {
                            //      _redirect_sample = BASE_URL + '/sales-lead-sample/' + tikID
                            //       window.location.assign(_redirect_sample);
                            // }

                            // if (pid == 4 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add_stage_sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            // if (pid == 5 && txtStage_ID == 3) {
                            //     _redirect_sample = BASE_URL + '/add-mylead-sample/' + tikID
                            //     window.location.assign(_redirect_sample);

                            // }
                            //$('#model_BO_task_1').modal('hide');

                        }
                    },
                    dataType: 'json'
                });

                
                //ajax 



            }
            //btnGenProcessDoneLeadSales
            
        </script>










        <!--begin::Modal-->
        <div class="modal fade" id="m_modal_4_sendQuation_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send message</button>
                        <button type="button" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->


      


        <!-- google report  -->

        <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->

        <!-- <script src="{{ asset('local/public/themes/corex/assets/js/pusher.min.js')}}" type="text/javascript"></script> -->

        <script src="{{ asset('local/public/themes/corex/assets/core_tree/Treant.js')}}"></script>

        <script>
            // Enable pusher logging - don't include this in production
            // Pusher.logToConsole = true;

            // var pusher = new Pusher('9dfaf98953e291c9be80', {
            //     cluster: 'ap2'
            // });

            // var channel = pusher.subscribe('BO_CHANNEL');
            // var EventID = 'AJ_ID' + UID;
            // channel.bind(EventID, function(data) {
            //     $('.pushLeadHTML').html(data.message);
            //     $('#m_modal_3PushAlert').modal('show');

            // });
        </script>


        <div class="modal fade" id="m_modal_3PushAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pushLeadHTML">

                    </div>

                </div>
            </div>
        </div>





        <!-- add new sample confirmation  -->
        <!--begin::Modal-->
        <div class="modal fade" id="m_modal_1_addSampleConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sample Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- data view      -->
                        <input type="hidden" id="txtUseriDSampleAdd" name="txtUseriDSampleAdd" value="{{Auth::user()->id}}">

                        <div class="m-form__section">

                            <div class="form-group m-form__group">
                                <div class="row">
                                    <div class="col-lg-4" style="">
                                        <label class="m-option">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--state-brand">
                                                    <input type="radio" name="sampleTypeVal" value="2">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">

                                                    <span class="m-option__focus">
                                                        OILS /RAW MATERIALS
                                                    </span>

                                                </span>


                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4" style="">
                                        <label class="m-option">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--state-brand">
                                                    <input type="radio" name="sampleTypeVal" value="1">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">

                                                    <span class="m-option__focus">
                                                        STANDARD COSMETIC
                                                    </span>
                                                </span>


                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4" style="">
                                        <label class="m-option">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--state-brand">
                                                    <input type="radio" name="sampleTypeVal" value="3">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">

                                                    <span class="m-option__focus">
                                                        GENERAL CHANGES
                                                    </span>
                                                </span>


                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-4" style="">
                                        <label class="m-option">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--state-brand">
                                                    <input type="radio" name="sampleTypeVal" value="4">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">

                                                    <span class="m-option__focus">
                                                        AS PER BENCHMARK
                                                    </span>
                                                </span>


                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4" style="">
                                        <label class="m-option">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--state-brand">
                                                    <input type="radio" name="sampleTypeVal" value="5">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">

                                                    <span class="m-option__focus">
                                                        MODIFICATIONS
                                                    </span>
                                                </span>


                                            </span>
                                        </label>
                                    </div>



                                </div>

                            </div>
                        </div>


                        <!-- data view      -->

                    </div>
                    <div class="modal-footer">

                        <button type="button" id="btnSampleChooseTypeA" class="btn btn-warning">CONTINUE</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->

        <!-- add new sample confirmation  -->







        <div class="modal fade" id="model_BO_salesLead_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stage Action</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtStage_ID_SL">
                        <input type="hidden" id="txtTicketID_SL">                       
                        <input type="hidden" id="txtProcessID_SL">                        
                        <form>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Remarks:</label>
                                <textarea class="form-control" id="messagetextSL"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                      
                        <a href="javascript::void(0)" onclick="btnGenProcessDoneLeadSales()" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="la la-check"></i>
                                <span>Submit</span>
                            </span>
                        </a>


                    </div>
                </div>
            </div>
        </div>



</body>

</html>