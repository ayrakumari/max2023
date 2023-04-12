
function toasterOptions()
{
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "100",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "show",
        "hideMethod": "hide"
    };
};
//== Class definition


var AjaxOperatonHealth = function ()
{
    //== Private functions
    // basic demo
    var demoHelth = function ()
    {


        var e, r, i = $( "#m_form_add_operation" );
        e = i.validate( {
            ignore: ":hidden",
            rules: {
                txtOperationName: {
                    required: !0
                },
                txtoutputCycleTime: {
                    required: !0
                },
                txtManPower: {
                    required: !0
                },
                txtproductName: {
                    required: !0
                }

            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTop();
            },
            submitHandler: function ( form )
            {
                //ajax call
                $.ajax( {
                    url: BASE_URL + '/operationsHealth',
                    type: 'POST',
                    data: $( form ).serialize(),
                    success: function ( res )
                    {

                        toasterOptions();
                        toastr.success( 'Saved successfully!', 'Operation Health' )
                        setTimeout( function ()
                        {
                            window.location.href = BASE_URL + '/operationsHealth'
                            //location.reload();


                        }, 500 );


                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );
                //ajax call

            }
        } )

    };

    return {
        // public functions
        init: function ()
        {
            demoHelth();
        },
    };
}();




var AjaxOrdersList = function ()
{
    //== Private functions
    // basic demo
    var demo = function ()
    {


        var e, r, i = $( "#m_form_add_order" );
        e = i.validate( {
            ignore: ":hidden",
            rules: {
                client_id: {
                    required: !0
                },
                order_due_date: {
                    required: !0
                },
                m_datepicker_3: {
                    required: !0
                }

            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTop();
            },
            submitHandler: function ( form )
            {
                //ajax call
                $.ajax( {
                    url: BASE_URL + '/orders',
                    type: 'POST',
                    data: $( form ).serialize(),
                    success: function ( res )
                    {

                        window.location.href = BASE_URL + '/orders/' + res;
                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );
                //ajax call

            }
        } )

    };

    return {
        // public functions
        init: function ()
        {
            demo();
        },
    };
}();


jQuery( document ).ready( function ()
{
    AjaxOrdersList.init();
    AjaxOperatonHealth.init();
} );

//===update
var AjaxOrdersListUpdate = function ()
{
    //== Private functions
    // basic demo
    var demoUpdate = function ()
    {
        var order_index = $( '#order_index' ).val();

        var e, r, i = $( "#m_form_update_order" );
        e = i.validate( {
            ignore: ":hidden",
            rules: {
                client_id: {
                    required: !0
                },
                order_due_date: {
                    required: !0
                }

            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTop();
            },
            submitHandler: function ( form )
            {
                //ajax call
                $.ajax( {
                    url: BASE_URL + '/orders/' + order_index,
                    type: 'PUT',
                    data: $( form ).serialize(),
                    success: function ( res )
                    {

                        window.location.href = BASE_URL + '/orders/' + res;
                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );
                //ajax call

            }
        } )

    };

    return {
        // public functions
        init: function ()
        {
            demoUpdate();
        },
    };
}();

jQuery( document ).ready( function ()
{
    AjaxOrdersListUpdate.init();
} );
//==update


var DatatablesSearchOptionsAdvancedSearchOrderList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_13" ).DataTable( {
                responsive: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getOrdersList',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "order_id", "company", "created_by", "created_on", "due_date", "Status", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                }, {
                    data: "order_id"
                }, {
                    data: "company"
                }, {
                    data: "created_by"
                }, {
                    data: "created_on"
                }, {
                    data: "due_date"
                }, {
                    data: "Status"
                }, {
                    data: "Actions"
                } ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {
                        switch ( this.title() )
                        {
                            case "Country":
                                this.data().unique().sort().each( function ( a, t )
                                {
                                    $( '.m-input[data-col-index="2"]' ).append( '<option value="' + a + '">' + a + "</option>" )
                                } );
                                break;
                            case "Status":
                                var a = {
                                    1: {
                                        title: "Pending5",
                                        class: "m-badge--brand"
                                    },
                                    2: {
                                        title: "Delivered",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Canceled",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "Success",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Info",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "Danger",
                                        class: " m-badge--danger"
                                    },
                                    7: {
                                        title: "Warning",
                                        class: " m-badge--warning"
                                    }
                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } );
                                break;
                            case "Type":
                                a = {
                                    1: {
                                        title: "Online",
                                        state: "danger"
                                    },
                                    2: {
                                        title: "Retail",
                                        state: "primary"
                                    },
                                    3: {
                                        title: "Direct",
                                        state: "accent"
                                    }
                                }, this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="7"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } )
                        }
                    } )
                },
                columnDefs: [ {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        return '\n<span class="dropdown">\n<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="javascript::void(0)" onclick="m_add_order_bill_material(' + e.RecordID + ')" ><i class="la la-edit"></i>Add Bill of Material</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                    }
                }, {
                    targets: 6,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "New Order",
                                class: "m-badge--brand"
                            },
                            2: {
                                title: "Production",
                                class: " m-badge--metal"
                            },
                            3: {
                                title: "Dispatched",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "Delivered",
                                class: " m-badge--success"
                            },

                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                }, {
                    targets: 7,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "Online",
                                state: "danger"
                            },
                            2: {
                                title: "Retail",
                                state: "primary"
                            },
                            3: {
                                title: "Direct",
                                state: "accent"
                            }
                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge m-badge--' + i[ a ].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + i[ a ].state + '">' + i[ a ].title + "</span>"
                    }
                } ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();
jQuery( document ).ready( function ()
{
    DatatablesSearchOptionsAdvancedSearchOrderList.init()
} );
//



//datagrid Client list
var DatatablesSearchOptionsAdvancedSearchSAP_CHECKList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {

            var a;
            var buttonCommon = {
                exportOptions: {
                    format: {
                        body: function ( data, row, column, node )
                        {
                            // Strip $ from salary column to make it numeric
                            // return column === 5 ?
                            //     data.replace( /[$,]/g, '' ) :
                            //     data;
                            if ( column === 5 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }
                            if ( column === 6 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }
                            if ( column === 7 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }
                            if ( column === 8 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }
                            if ( column === 9 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }
                            if ( column === 10 )
                            {
                                var str2 = 'BLNK';
                                if ( data.indexOf( str2 ) != -1 )
                                {
                                    return '';
                                } else
                                {
                                    return 'YES';
                                }

                            }

                            return data;
                        }
                    }
                }
            };


            a = $( "#m_table_SAP_CHECKList" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                dom: 'Bfrltip',
                buttons: [
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    } ),

                ],


                ajax: {

                    url: BASE_URL + '/getSAPCheckListData',
                    type: "POST",
                    data: {
                        columnsDef: [
                            "RecordID",
                            "order_id",
                            "brand_name",
                            "item_name",
                            "curr_stage",
                            "sap_so",
                            "sap_fg",
                            "sap_sfg",
                            "sap_production",
                            "sap_invoice",
                            "sap_dispatch",
                        ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "order_id"
                },
                {
                    data: "brand_name"
                },
                {
                    data: "item_name"
                },
                {
                    data: "curr_stage"
                },




                ],

                columnDefs: [ {
                    targets: [ 0 ],
                    visible: !1
                },
                {
                    targets: 5,
                    title: "Sales Orders",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {

                        var chID = 'BO' + e.RecordID + 'AJ' + 1;

                        return `<div class="m-checkbox-list">
                           <label class="m-checkbox m-checkbox--solid m-checkbox--success">
																		<input ${ e.sap_so } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },1)">
																		<span></span>
																	</label>
                       </div>`;

                    }
                },
                {
                    targets: 6,
                    title: "FG",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        var chID = 'BO' + e.RecordID + 'AJ' + 2;

                        return `<div class="m-checkbox-list">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                         <input ${ e.sap_fg } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },2)">
                                                                         <span></span>
                                                                     </label>
                        </div>`;

                    }
                },
                {
                    targets: 7,
                    title: "SFG",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        var chID = 'BO' + e.RecordID + 'AJ' + 3;

                        return `<div class="m-checkbox-list">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                         <input  ${ e.sap_sfg } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },3)">
                                                                         <span></span>
                                                                     </label>
                        </div>`;

                    }
                },
                {
                    targets: 8,
                    title: "PRODUCTION",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        var chID = 'BO' + e.RecordID + 'AJ' + 4;

                        return `<div class="m-checkbox-list">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                         <input   ${ e.sap_production }  type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },4)">
                                                                         <span></span>
                                                                     </label>
                        </div>`;

                    }
                },
                {
                    targets: 9,
                    title: "INVOICING",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        var chID = 'BO' + e.RecordID + 'AJ' + 5;

                        return `<div class="m-checkbox-list">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                         <input ${ e.sap_invoice } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },5)">
                                                                         <span></span>
                                                                     </label>
                        </div>`;

                    }
                },
                {
                    targets: 10,
                    title: "DISPATCHED",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {

                        var chID = 'BO' + e.RecordID + 'AJ' + 6;

                        return `<div class="m-checkbox-list">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                         <input ${ e.sap_dispatch }  type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },6)">
                                                                         <span></span>
                                                                     </label>
                        </div>`;

                    }
                },


                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )

        }
    }
}();








//datagrid Client list
var DatatablesSearchOptionsAdvancedSearchOperationHealthDataList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_OperationMainList" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getOperationHealthData',
                    type: "POST",
                    data: {
                        columnsDef: [
                            "RecordID",
                            "operation_name",
                            "operation_product",
                            "operation_category",
                            "created_on", "created_by",
                            "operation_type",
                            "operation_disc",
                            "operation_man_power",
                            "operation_manual_time",
                            "operation_machine_time",
                            "operation_cycle_time",
                            "operation_output",
                            "ophVal",
                            "operation_unit",
                            "operation_rework",
                            "operation_rejection",
                            "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "operation_category"
                },
                {
                    data: "operation_type"
                },
                {
                    data: "operation_name"
                },
                {
                    data: "operation_product"
                },
                {
                    data: "operation_man_power"
                },
                {
                    data: "operation_manual_time"
                },
                {
                    data: "operation_machine_time"
                },
                {
                    data: "operation_cycle_time"
                },
                {
                    data: "ophVal"
                },
                {
                    data: "operation_unit"
                },
                {
                    data: "operation_rejection"
                },
                {
                    data: "operation_rework"
                },
                {
                    data: "Actions"
                }
                ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {

                        switch ( this.title() )
                        {

                            case "Status":

                                var a = {
                                    1: {
                                        title: "DRAFT",
                                        class: "m-badge--warning"
                                    },
                                    2: {
                                        title: "Addded BOM",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Processing",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "PRODUCTION",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Dispatched",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "DELIVERED",
                                        class: " m-badge--danger"
                                    }

                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } );
                                break;
                        }
                    } )
                },
                columnDefs: [ {
                    targets: [ 0 ],
                    visible: !1
                }, {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {



                        var html = `<a href="javascript::void(0)" title="INFO" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i> 
														</a>`;




                        return html;
                    }
                },
                {
                    targets: 1,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "Production",
                                class: "m-badge--success"
                            },
                            2: {
                                title: "Packaging",
                                class: " m-badge--accent"
                            },


                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                },

                {
                    targets: 2,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "Automatic",
                                class: "m-badge--warning"
                            },
                            2: {
                                title: "Manual",
                                class: " m-badge--secondary"
                            },


                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                },
                {
                    targets: 9,
                    render: function ( a, t, e, n )
                    {
                        return e.ophVal
                    }
                }

                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

// 

$( '#viewSalesInvoiceRequest' ).click( function ()
{
    $( '#m_modal_QuickNav_1' ).modal( 'show' );
} );







function BOSupportReport()
{
    $( '#m_modal_BOSupportReport_1' ).modal( 'show' );
}



var arrORD = [];
var aj = 0;

function checkValue( value, arr )
{
    var status = 'Not exist';

    for ( var i = 0; i < arr.length; i++ )
    {
        var name = arr[ i ];
        if ( name == value )
        {
            status = 'Exist';
            break;
        }
    }

    return status;
}

$( "select.getTicketDataSelect" ).change( function ()
{
    var selectedFormID = $( this ).children( "option:selected" ).attr( 'id' );
    $( '#ticket_subject' ).val( selectedFormID );

} );



function myGreating()
{
    if ( $( '#txtdemoScan' ).val() != "" )
    {
        alert( $( '#txtdemoScan' ).val() );
        $( '#txtdemoScan' ).val( "" );
    }
}


$( '#txtdemoScan' ).focus( function ()
{
    // const myTimeout = setTimeout(myGreating, 5000);    
} );

$( "select.selectSamplePrintLBL" ).change( function ()
{
    var selectedFormID = $( this ).children( "option:selected" ).val();
    if ( selectedFormID == "" )
    {
        toastr.error( 'Please Select Order!', 'Order ' )
    }
    //ajax
    var formData = {
        'sample_id': selectedFormID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getSampleForLBLPrint',
        type: 'GET',
        data: formData,
        success: function ( res )
        {
            $( '.addSamplePrintLayout' ).append( `<div class="form-group m-form__group row">
            <div class="col-lg-2 m-form__group-sub">
                <label class="form-control-label">*Sample ID:</label>
                <input  style="background-color:#035496;color:#FFF" type="text" class="form-control m-input" name="sample_code[]" value="${ res.sample_code }">
            </div>
            <div class="col-lg-2 m-form__group-sub">
            <label class="form-control-label">*Tracking ID:</label>
            <input style="background-color:#035496;color:#FFF" type="text" class="form-control m-input" name="track_id[]" value="${ res.track_id }">
            </div>
            <div class="col-lg-3 m-form__group-sub">
                <label class="form-control-label">* Name:</label>
                <input  style="background-color:#035496;color:#FFF" type="text" class="form-control m-input" name="name[]"  value="${ res.lead_name }">
            </div>
            <div class="col-lg-2 m-form__group-sub">
                <label class="form-control-label">* Phone:</label>
                <input  style="background-color:#035496;color:#FFF" type="text" class="form-control m-input" name="phone[]"  value="${ res.contact_phone }">
            </div>
            <div class="col-lg-3 m-form__group-sub">
                <label class="form-control-label">* Address:</label>
                <textarea style="background-color:#035496;color:#FFF" class="form-control m-input" name="address[]" rows="3">${ res.ship_address }</textarea>

            </div>
        </div>`);
        },
        dataType: 'json'
    } );
    //ajax

} );




$( '#IVReqSubmit' ).attr( 'disabled', true );

$( "select.myOrderListSelectTicket" ).change( function ()
{
    $( '#client_name' ).val( "" );
    $( '#txtFromIDTicket' ).val( "" );
    //$( '.ajdetailView' ).html("");

    var selectedFormID = $( this ).children( "option:selected" ).val();
    if ( selectedFormID == "" )
    {
        toastr.error( 'Please Select Order!', 'Order ' )
    }

    // ajax call
    var formData = {
        'recordID': selectedFormID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getMyQCData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {

            //    console.log(res);
            if ( res.status == 1 )
            {
                $( '#client_name' ).val( res.qc_client.email );
                $( '#txtFromIDTicket' ).val( res.qc_data.form_id );
                $( '.vOrder' ).html( res.qc_data.order_id + '/' + res.qc_data.subOrder + "-" + res.Otype );

            }




        },
        dataType: 'json'
    } );

    // ajax call


    //alert("You have selected the ORDER ID - " + selectedFormID);

} );

//txtViewOrderDetailTicket
$( '#txtViewOrderDetailTicket' ).click( function ()
{

    var recordID = $( '#txtFromIDTicket' ).val();
    var formData = {
        'recordID': recordID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getMyQCData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            var orderid = res.qc_data.order_id + '/' + res.qc_data.subOrder + "-" + res.Otype;
            if ( res.qc_data.qc_from_bulk == 1 )
            {
                var bulk = BASE_URL + '/print/qcform-bulk/' + res.qc_data.form_id;
            } else
            {
                var bulk = BASE_URL + '/print/qcform/' + res.qc_data.form_id
            }
            //qc_client
            console.log( res.qc_client );
            $( '#client_name' ).val( res.qc_client.email );

            $( '#oderDetailVie' ).html( `<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
            <thead>
                <tr>
                   
                    <th>Order Id:</th>
                    <th>Brand</th>
                    <th>Order Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">${ orderid }</th>
                    <td>${ res.qc_data.brand_name }</td>
                    <td>${ res.Otype }</td>
                    <td><a target="_blank" href="${ bulk }">VIEW</a></td>
                </tr>
               
            </tbody>
        </table>`);
            $( '#m_modal_OrderDetailTicket' ).modal( 'show' );
        }
    } );


} );
//txtViewOrderDetailTicket


$( "select.myOrderListSelectA" ).change( function ()
{


    $( '#IVReqSubmit' ).attr( 'disabled', true );

    toasterOptions();
    $( '#txtMyContactNO' ).val( '' );
    $( '#txtMyGSTNO' ).val( '' );
    $( '#complete_buyer_address' ).val( '' );
    $( '#delivery_address' ).val( '' );



    var selectedFormID = $( this ).children( "option:selected" ).val();
    if ( selectedFormID == "" )
    {
        toastr.error( 'Please Select Order!', 'Order ' )
    }

    // ajax call
    var formData = {
        'recordID': selectedFormID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getMyQCData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {

            $( '#txtRepeatArea' ).on( "click", ".remove_field", function ( e )
            { //user click on remove text
                e.preventDefault(); $( this ).parent( 'div' ).parent( 'div' ).remove(); x--;
            } )

            if ( res.status == 1 )
            {


                if ( checkValue( res.qc_data.form_id, arrORD ) == 'Exist' )
                {
                    toasterOptions();
                    toastr.error( 'Already Added in list', 'Order' )
                    return false;
                } else
                {
                    arrORD[ aj++ ] = res.qc_data.form_id;
                }
                var orderid = res.qc_data.order_id + '/' + res.qc_data.subOrder + "-" + res.Otype;

                $( '#txtRepeatArea' ).append( `
                   <div class="form-group m-form__group row">
                   <input type="hidden" name="AJFORMID[]" style="background:#c1c1c1" class="form-control m-input"  value ="${ res.qc_data.form_id }" readonly>                       

                    <div class="col-lg-4">
                        <label><b>Order ID:</b></label>
                        <input title="${ res.oderName }" type="text" name="orderID[]" style="background:#c1c1c1" class="form-control m-input" placeholder="" value ="${ orderid }" readonly>                       
                    </div>
                    <div class="col-lg-4">
                        <label class=""><b>Total UNIT:</b></label>
                        <input type="text"  name="totUNIT[]" style="background:#f1f1f1"  class="form-control m-input priceAJ" value="${ res.total_UNIT }" placeholder="">
                        
                    </div>
                    <div class="col-lg-3">
                        <label class=""><b>Rate:</b></label>
                        <input type="text" name="toRate[]" style="background:#f1f1f1" class="form-control m-input" value="${ res.total_rate }" placeholder="">                       
                    </div>
                    <div class="col-lg-1">
                    <a href="#" style="margin-top:30px" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only remove_field">
                    <i class="fa flaticon-delete"></i>
                   </a>
                    </div>
                   </div>`);

                summationMenyPrice();
                $( '.priceAJ' ).focusout( function ()
                {
                    toasterOptions();
                    toastr.success( 'Quantity Updated', 'Order' )

                    summationMenyPrice();
                } );


                $( '#txtMyContactNO' ).val( res.qc_client.phone );
                $( '#txtMyGSTNO' ).val( res.qc_client.gstno );
                $( '#complete_buyer_address' ).val( res.qc_client.address );
                $( '#delivery_address' ).val( res.qc_client.location );
                if ( res.qc_data.qc_from_bulk == 1 )
                {
                    $bulk = BASE_URL + '/print/qcform-bulk/' + res.qc_data.form_id;
                } else
                {
                    $bulk = BASE_URL + '/print/qcform/' + res.qc_data.form_id
                }
                $( '#myQCFORMLink' ).attr( "href", $bulk ); // Set herf value
                $( '#IVReqSubmit' ).attr( 'disabled', false );

            } else
            {
                $( '#IVReqSubmit' ).attr( 'disabled', true );
                toasterOptions();
                toastr.error( 'Please check Order Stage', 'Order' )
                return false;
            }



        },
        dataType: 'json'
    } );

    // ajax call


    //alert("You have selected the ORDER ID - " + selectedFormID);

} );

function summationMenyPrice()
{
    var sum = 0;
    $( '.priceAJ' ).each( function ()
    {
        sum += Number( parseInt( $( this ).val() ) );
    } );


    $( '#Vno_of_unitAJ' ).val( sum );
}



//showPayment Recived data
function getFilterPaymentRecievdReport()
{
    $( "#m_table_PaymentRecievdReport" ).dataTable().fnDestroy();
    var sales_userid = $( "#salesPerson option:selected" ).val();
    var txtMonth = $( "#txtMonth option:selected" ).val();
    var txtYear = $( "#txtYearPayRec option:selected" ).val();
    var a;
    a = $( "#m_table_PaymentRecievdReport" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        //dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        //  lengthMenu: [5, 10, 25, 50, 100,500,1500],
        lengthMenu: [
            [ 5, 10, 25, 50, 100, -1 ],
            [ 5, 10, 25, 50, 100, "All" ]
        ],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        footerCallback: function ( t, e, n, a, r )
        {
            var o = this.api(),
                l = function ( t )
                {
                    return "string" == typeof t ? 1 * t.replace( /[\$,]/g, "" ) : "number" == typeof t ? t : 0
                },
                u = o.column( 6 ).data().reduce( function ( t, e )
                {
                    return l( t ) + l( e )
                }, 0 ),
                i = o.column( 6, {
                    page: "current"
                } ).data().reduce( function ( t, e )
                {
                    return l( t ) + l( e )
                }, 0 );
            $( o.column( 6 ).footer() ).html( '<i class="fa fa-rupee-sign"></i>' + mUtil.numberString( u.toFixed( 1 ) ) + "" )
        },
        processing: !1,
        serverSide: !1,
        dom: 'Bfrltip',
        buttons: [
            'excel', 'pdf'
        ],
        order: [ [ 3, "desc" ] ],
        ajax: {

            url: BASE_URL + '/getPaymentRecievedReportListFilter',
            type: "POST",
            data: {
                columnsDef: [ "RecordID",
                    "created_by", "recieved_on", "created_at", "client_name", "compamy_name", "brand", "rec_amount", "rec_amount_words", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                'sales_userid': sales_userid,
                'txtMonth': txtMonth,
                'txtYear': txtYear,

            }
        },
        columns: [
            {
                data: "RecordID"
            },
            {
                data: "recieved_on"
            },
            {
                data: "created_by"
            },
            {
                data: "client_name"
            },
            {
                data: "compamy_name"
            },
            {
                data: "brand"
            },
            {
                data: "rec_amount"
            },
            {
                data: "created_at"
            },

            {
                data: "Actions"
            }
        ],

        columnDefs: [ {
            targets: -1,
            title: "Actions",

            render: function ( a, t, e, n )
            {
                console.log( e.client_id );
                var URL_CLIENT_ORDER = BASE_URL + '/view-order-details/' + e.client_id
                return '';
                //return `<a href="${URL_CLIENT_ORDER}" class="btn btn-primary btn-sm m-btn m-btn--custom">View Orders <span class="m-badge m-badge--warning">0</span></a>`;
            }
        },
        {
            targets: 6,
            title: "Amount",
            orderable: !1,
            render: function ( a, t, e, n )
            {


                return `<a href="javascript::void(0)" title="${ e.rec_amount_words }">${ e.rec_amount }</a>`
            }
        },

        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } )


}

//showPayment Recived data

function getFilterClientReport()
{
    $( "#m_table_OrderClientReport" ).dataTable().fnDestroy();
    var sales_userid = $( "#salesPerson option:selected" ).val();
    var txtMonth = $( "#txtMonth option:selected" ).val();
    var a;
    a = $( "#m_table_OrderClientReport" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        //dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        //  lengthMenu: [5, 10, 25, 50, 100,500,1500],
        lengthMenu: [
            [ 5, 10, 25, 50, 100, -1 ],
            [ 5, 10, 25, 50, 100, "All" ]
        ],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !1,
        serverSide: !1,
        dom: 'Bfrltip',
        buttons: [
            'excel', 'pdf'
        ],
        order: [ [ 3, "desc" ] ],
        ajax: {

            url: BASE_URL + '/getClientOrderReportListFilter',
            type: "POST",
            data: {
                columnsDef: [ "RecordID", "client_id", "company_name", "brand_name", "sales_person", "order_value", "order_percent", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                'sales_userid': sales_userid,
                'txtMonth': txtMonth,

            }
        },
        columns: [
            {
                data: "company_name"
            },
            {
                data: "brand_name"
            },
            {
                data: "sales_person"
            },
            {
                data: "order_value"
            },
            {
                data: "order_percent"
            },
            {
                data: "Actions"
            }
        ],

        columnDefs: [ {
            targets: -1,
            title: "Actions",

            render: function ( a, t, e, n )
            {
                console.log( e.client_id );
                var URL_CLIENT_ORDER = BASE_URL + '/view-order-details/' + e.client_id

                return `<a href="${ URL_CLIENT_ORDER }" class="btn btn-primary btn-sm m-btn m-btn--custom">View Orders <span class="m-badge m-badge--warning">0</span></a>`;
            }
        },
        {
            targets: 3,
            title: "Order Value",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                console.log( e.client_id );

                return parseInt( e.order_value )
            }
        },

        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } )


}

//datagrid Client list
var DatatablesSearchOptionsAdvancedSearchOrderClientReport = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {

            var a;
            a = $( "#m_table_OrderClientReport" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                //dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                //  lengthMenu: [5, 10, 25, 50, 100,500,1500],
                lengthMenu: [
                    [ 5, 10, 25, 50, 100, -1 ],
                    [ 5, 10, 25, 50, 100, "All" ]
                ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !1,
                serverSide: !1,
                dom: 'Bfrltip',
                buttons: [
                    'excel', 'pdf'
                ],
                order: [ [ 3, "desc" ] ],
                ajax: {

                    url: BASE_URL + '/getClientOrderReportList',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "orderCount", "client_id", "company_name", "brand_name", "sales_person", "order_value", "order_percent", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [
                    {
                        data: "company_name"
                    },
                    {
                        data: "brand_name"
                    },
                    {
                        data: "sales_person"
                    },
                    {
                        data: "order_value"
                    },
                    {
                        data: "order_percent"
                    },
                    {
                        data: "orderCount"
                    },
                    {
                        data: "Actions"
                    }
                ],

                columnDefs: [ {
                    targets: -1,
                    title: "Actions",

                    render: function ( a, t, e, n )
                    {
                        console.log( e.client_id );
                        var URL_CLIENT_ORDER = BASE_URL + '/view-order-details/' + e.client_id

                        return `<a href="${ URL_CLIENT_ORDER }" class="btn btn-primary btn-sm m-btn m-btn--custom">View Orders <span class="m-badge m-badge--warning">0</span></a>`;
                    }
                },
                {
                    targets: 3,
                    title: "Order Value",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        console.log( e.client_id );

                        return parseInt( e.order_value )
                    }
                },

                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

//m_table_SampleChemistAssignedLIST
var DatatablesSearchOptionsAdvancedSearchSampleChemistAssingedList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            var userid = $( '#txtUserID' ).val();

            a = $( "#m_table_SampleChemistAssignedLIST" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getSampleChemistListAssigned',
                    type: "GET",
                    data: {
                        columnsDef: [ "RecordID", "index_id", "sample_id", "assigned_at", "created_at", "sample_type", "sample_statge", "sales_person", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                        userid: userid

                    }
                },
                columns: [ {
                    data: "index_id"
                },
                {
                    data: "sample_id"
                },

                {
                    data: "created_at"
                },
                {
                    data: "assigned_at"
                },
                {
                    data: "sample_type"
                },
                {
                    data: "sales_person"
                },
                {
                    data: "sample_statge"
                },

                {
                    data: "Actions"
                }
                ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    }, {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var editChem = BASE_URL + "/editChem/" + e.RecordID;
                            var html = `<a href="${ editChem }"  title="View And Modify" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                        </a>`;

                            return '';
                        }
                    },
                    {
                        targets: 4,
                        render: function ( a, t, e, n )
                        {
                            var i = {
                                1: {
                                    title: "COSMETIC",
                                    class: "m-badge--metal"
                                },
                                3: {
                                    title: "G.CHANGES ",
                                    class: " m-badge--primary"
                                },
                                4: {
                                    title: "BENCHMARK ",
                                    class: " m-badge--primary"
                                },
                                5: {
                                    title: "MODIFICATIONS ",
                                    class: " m-badge--success"
                                },



                            };
                            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                        }
                    },
                    {
                        targets: 6,
                        render: function ( a, t, e, n )
                        {
                            var i = {
                                1: {
                                    title: "NEW",
                                    class: "m-badge--metal"
                                },
                                2: {
                                    title: "APPROVED",
                                    class: " m-badge--primary"
                                },
                                3: {
                                    title: "FORMULATION",
                                    class: " m-badge--success"
                                },
                                4: {
                                    title: "PACKING",
                                    class: " m-badge--warning"
                                },
                                5: {
                                    title: "PACKING",
                                    class: " m-badge--brand"
                                },


                            };
                            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                        }
                    },
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

//m_table_SampleChemistAssignedLIST


//m_table_SampleChemistLIST
var DatatablesSearchOptionsAdvancedSearchSampleChemistList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_SampleChemistLIST" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getSampleChemistList',
                    type: "GET",
                    data: {
                        columnsDef: [ "RecordID", "name", "cate_1", "cate_2", "cate_3", "cate_4", "cate_5", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "name"
                },
                {
                    data: "cate_1"
                },
                {
                    data: "cate_2"
                },
                {
                    data: "cate_3"
                },
                {
                    data: "cate_4"
                },

                {
                    data: "Actions"
                }
                ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    }, {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var editChem = BASE_URL + "/editChem/" + e.RecordID;
                            var editChemOrder = BASE_URL + "/editChemOrder/" + e.RecordID;
                            var html = '';
                            html += `<a href="${ editChem }"  title="View And Modify" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                        </a>`;
                            html += `<a style="margin:1px" href="${ editChemOrder }"  title="View And Modify" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                    </a>`;

                            return html;
                        }
                    },
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();



//datagrid Client list
var DatatablesSearchOptionsAdvancedSearchOrderMainDataList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_OrderMainList" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getOrderMainList',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "order_id", "company", "phone", "created_on", "created_by", "due_date", "Status", "sent_access", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "order_id"
                },
                {
                    data: "company"
                },
                {
                    data: "phone"
                },
                {
                    data: "created_on"
                },
                {
                    data: "created_by"
                },
                {
                    data: "due_date"
                },
                {
                    data: "Status"
                },
                {
                    data: "Actions"
                }
                ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {

                        switch ( this.title() )
                        {

                            case "Status":

                                var a = {
                                    1: {
                                        title: "DRAFT",
                                        class: "m-badge--warning"
                                    },
                                    2: {
                                        title: "Addded BOM",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Processing",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "PRODUCTION",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Dispatched",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "DELIVERED",
                                        class: " m-badge--danger"
                                    }

                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } );
                                break;
                        }
                    } )
                },
                columnDefs: [ {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        //  console.log();
                        // <a href="${edit_URL}" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        // 									<i class="la la-edit"></i>
                        // 								</a>

                        edit_URL = BASE_URL + '/orders/' + e.RecordID + '/edit';
                        print_URL = BASE_URL + '/orders/print/' + e.RecordID;

                        view_URL = BASE_URL + '/orders/' + e.RecordID + '';
                        var html = `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i>
														</a>
                           

                            <a href="javascript::void(0)" onclick="delete_ordernow(${ e.RecordID })"
                             title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-delete"></i>
                            														</a>


                                                        `;
                        if ( e.sent_access )
                        {
                            html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="SENT SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                        }


                        return html;
                    }
                },
                {
                    targets: 7,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "DRAFT",
                                class: "m-badge--metal"
                            },
                            2: {
                                title: "NEW",
                                class: " m-badge--primary"
                            },
                            3: {
                                title: "Processing",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "PRODUCTION",
                                class: " m-badge--success"
                            },
                            5: {
                                title: "Dispatched",
                                class: " m-badge--info"
                            },
                            6: {
                                title: "DELIVERED",
                                class: " m-badge--danger"
                            }


                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                }
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();


// purchase-reserved list
var DatatablesPurchaseReservedList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_PurchaseReservedList" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getPurchaseReserved',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "order_id", "sub_order_id", "item_code", "item_name", "req_qty", "stock_in", "created_by", "Status", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "order_id"
                },
                {
                    data: "sub_order_id"
                },
                {
                    data: "item_code"
                },
                {
                    data: "item_name"
                },
                {
                    data: "req_qty"
                },
                {
                    data: "stock_in"
                },
                {
                    data: "created_by"
                },

                {
                    data: "Status"
                },
                {
                    data: "Actions"
                }
                ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {

                        switch ( this.title() )
                        {

                            case "Status":

                                var a = {
                                    1: {
                                        title: "DRAFT",
                                        class: "m-badge--warning"
                                    },
                                    2: {
                                        title: "Addded BOM",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Processing",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "PRODUCTION",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Dispatched",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "DELIVERED",
                                        class: " m-badge--danger"
                                    }

                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    // $('.m-input[data-col-index="8"]').append('<option value="' + t + '">' + a[t].title + "</option>")
                                } );
                                break;
                        }
                    } )
                },
                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    }, {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            // console.log(e.Status);
                            edit_URL = BASE_URL + '/orders/' + e.RecordID + '/edit';
                            print_URL = BASE_URL + '/orders/print/' + e.RecordID;
                            var html = ``;
                            view_URL = BASE_URL + '/orders/' + e.RecordID + '';
                            if ( e.Status == 1 )
                            {
                                html += `<a href="javascript::void(0)" onclick="itemsReserved(${ e.RecordID })" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                                <span>                                
                                    <span>RESERVE  NOW</span>
                                </span>
                            </a>`;
                            }
                            if ( e.Status == 2 )
                            {
                                html += `<a href="javascript::void(0)" onclick="itemsRequestPurchase(${ e.RecordID })" class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                 
                                   <span>Purchase </span>
                               </span>
                           </a>`;
                            }
                            if ( e.Status == 3 )
                            {
                                html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">                                
                               <span>REQUESTED </span>
                           </span>
                       `;
                            }
                            if ( e.Status == 4 )
                            {
                                html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">                                
                           <span>REQUESTED </span>
                       </span>
                   `;
                            }
                            if ( e.Status == 5 )
                            {
                                html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">                                
                       <span>REQUESTED </span>
                   </span>
               `;
                            }
                            if ( e.Status == 6 )
                            {
                                html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">                                
                   <span>REQUESTED </span>
               </span>
           `;
                            }




                            return html;
                        }
                    },
                    {
                        targets: 8,
                        render: function ( a, t, e, n )
                        {
                            //console.log(e);

                            var i = {
                                1: {
                                    title: "Available",
                                    class: "m-badge--success"
                                },
                                2: {
                                    title: "Out of Stock",
                                    class: " m-badge--danger"
                                },
                                3: {
                                    title: 'Reserved',
                                    class: " m-badge--info"
                                },
                                4: {
                                    title: 'Purchase',
                                    class: " m-badge--warning"
                                },
                                5: {
                                    title: 'purchase ordered',
                                    class: " m-badge--warning"
                                },
                                6: {
                                    title: 'Ordered Recieved',
                                    class: " m-badge--warning"
                                }



                            };
                            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                        }
                    }
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

//reserved now button click event
function reserved_now( rowid )
{
    // ajax call
    var formData = {
        'recordID': rowid,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/purchase-request-entry',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            //console.log(res);
            toasterOptions();
            toastr.success( 'Saved successfully!', 'Order Material' )
            setTimeout( function ()
            {
                //window.location.href = BASE_URL+'/orders'
                //location.reload();


            }, 500 );


        }
    } );

    // ajax call

}

// purchase-reserved list


//order manage list
var DatatablesSearchOptionsAdvancedSearchOrderManageDataList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;

            var order_index = $( '#order_index' ).val();
            a = $( "#m_table_OrderItemList" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getOrderItemsList',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "order_id", "sub_order_id", "company", "item_name", "item_qty", "created_on", "Status", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                        'order_index': order_index,
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "order_id"
                },
                {
                    data: "sub_order_id"
                },
                {
                    data: "company"
                },
                {
                    data: "item_name"
                },
                {
                    data: "item_qty"
                },
                {
                    data: "created_on"
                },
                {
                    data: "Status"
                },

                {
                    data: "Actions"
                }
                ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {

                        switch ( this.title() )
                        {

                            case "Status":

                                var a = {
                                    1: {
                                        title: "DRAFT",
                                        class: "m-badge--warning"
                                    },
                                    2: {
                                        title: "Addded BOM",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Processing",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "PRODUCTION",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Dispatched",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "DELIVERED",
                                        class: " m-badge--danger"
                                    }

                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    //  $('.m-input[data-col-index="3"]').append('<option value="' + t + '">' + a[t].title + "</option>")
                                } );
                                break;
                        }
                    } )
                },
                columnDefs: [ {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        //  console.log(e.item_name);
                        aj = e.item_name;
                        edit_URL = BASE_URL + '/orders/' + e.RecordID + '/edit';
                        print_URL = BASE_URL + '/orders/print/' + e.RecordID;
                        view_URL = BASE_URL + '/orders/' + e.RecordID + '';
                        view_INFO = BASE_URL + '/orders-info/' + e.RecordID + '';
                        add_Material = BASE_URL + '/orders-add-material/' + e.RecordID + '';
                        var html = `<a href="${ add_Material }"  title="Add Material" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-plus-circle"></i>
														</a>
                            <a href="${ view_INFO }"  title="View Added Material" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
    															<i class="la la-info"></i>
    														</a>

                            <a href="javascript::void(0)" onclick="delete_OrderItem(${ e.RecordID })"
                             title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-delete"></i>
                            														</a>

                                                        `;
                        if ( e.sent_access )
                        {
                            html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="SENT SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                        }


                        return html;
                    }
                },
                {
                    "visible": false,
                    "targets": 0
                },
                {
                    targets: 7,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "DRAFT",
                                class: "m-badge--metal"
                            },
                            2: {
                                title: "NEW",
                                class: " m-badge--primary"
                            },
                            3: {
                                title: "Processing",
                                class: " m-badge--info"
                            },
                            4: {
                                title: "PRODUCTION",
                                class: " m-badge--success"
                            },
                            5: {
                                title: "Dispatched",
                                class: " m-badge--info"
                            },
                            6: {
                                title: "DELIVERED",
                                class: " m-badge--danger"
                            }


                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                }
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();
//order manage list

var DatatablesBOMList = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;

            var order_index = $( '#rowidItem' ).val();
            a = $( "#m_table_MaterialItemLists" ).DataTable( {
                responsive: !0,
                // scrollY: "50vh",
                scrollX: !0,
                scrollCollapse: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getOrderMaterialItemAddedList',
                    type: "POST",
                    data: {
                        columnsDef: [ "rowid", "item_code", "item_name", "item_qty", "remarks", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                        'order_index': order_index,
                    }
                },
                columns: [ {
                    data: "rowid"
                },
                {
                    data: "item_code"
                },
                {
                    data: "item_name"
                },
                {
                    data: "item_qty"
                },
                {
                    data: "remarks"
                },


                {
                    data: "Actions"
                }
                ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {

                        switch ( this.title() )
                        {

                            case "Status":

                                var a = {
                                    1: {
                                        title: "DRAFT",
                                        class: "m-badge--warning"
                                    },
                                    2: {
                                        title: "Addded BOM",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Processing",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "PRODUCTION",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Dispatched",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "DELIVERED",
                                        class: " m-badge--danger"
                                    }

                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } );
                                break;
                        }
                    } )
                },
                columnDefs: [ {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {
                        //  console.log(e.item_name);
                        aj = e.item_name;
                        edit_URL = BASE_URL + '/orders/' + e.RecordID + '/edit';
                        print_URL = BASE_URL + '/orders/print/' + e.RecordID;
                        view_URL = BASE_URL + '/orders/' + e.RecordID + '';
                        view_INFO = BASE_URL + '/orders-info/' + e.RecordID + '';
                        var html = `<a href="${ view_INFO }"  title="Edit Added Material" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
    															<i class="la la-edit"></i>
    														</a>

                            <a href="javascript::void(0)" onclick="delete_item(${ e.RecordID })"
                             title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-delete"></i>
                            														</a>

                                                        `;
                        if ( e.sent_access )
                        {
                            html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="SENT SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                        }


                        return html;
                    }
                },
                {
                    "visible": false,
                    "targets": 0
                },
                {
                    targets: 5,
                    render: function ( a, t, e, n )
                    {
                        var i = {
                            1: {
                                title: "DRAFT",
                                class: "m-badge--metal"
                            },
                            2: {
                                title: "BOM",
                                class: " m-badge--metal"
                            },
                            3: {
                                title: "Processing",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "PRODUCTION",
                                class: " m-badge--success"
                            },
                            5: {
                                title: "Dispatched",
                                class: " m-badge--info"
                            },
                            6: {
                                title: "DELIVERED",
                                class: " m-badge--danger"
                            }


                        };
                        return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                    }
                }
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();



var DatatablesSearchOptionsColumnSearch = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_tableOPerationHealthPlan" ).DataTable( {
                responsive: !0,
                dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {

                    url: BASE_URL + '/getOperationOrderPlan',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "order_selected_arr", "form_id", "order_id", "bran_name", "item_name", "sales_person", "order_date", "curr_stage", "order_qty", "Actions" ],
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

                    }
                },
                columns: [ {
                    data: "RecordID"
                }, {
                    data: "order_id"
                }, {
                    data: "bran_name"
                }, {
                    data: "item_name"
                }, {
                    data: "sales_person"
                }, {
                    data: "order_date"
                }, {
                    data: "curr_stage"
                }, {
                    data: "order_qty"
                }, {
                    data: "Plan QTY"
                }, {
                    data: "Actions"
                } ],
                initComplete: function ()
                {
                    this.api().columns().every( function ()
                    {
                        switch ( this.title() )
                        {
                            case "Country":
                                this.data().unique().sort().each( function ( a, t )
                                {
                                    $( '.m-input[data-col-index="2"]' ).append( '<option value="' + a + '">' + a + "</option>" )
                                } );
                                break;
                            case "Status":
                                var a = {
                                    1: {
                                        title: "Pending",
                                        class: "m-badge--brand"
                                    },
                                    2: {
                                        title: "Delivered",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Canceled",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "Success",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Info",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "Danger",
                                        class: " m-badge--danger"
                                    },
                                    7: {
                                        title: "Warning",
                                        class: " m-badge--warning"
                                    }
                                };
                                this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } );
                                break;
                            case "Type":
                                a = {
                                    1: {
                                        title: "Online",
                                        state: "danger"
                                    },
                                    2: {
                                        title: "Retail",
                                        state: "primary"
                                    },
                                    3: {
                                        title: "Direct",
                                        state: "accent"
                                    }
                                }, this.data().unique().sort().each( function ( t, e )
                                {
                                    $( '.m-input[data-col-index="7"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                } )
                        }
                    } )
                },
                columnDefs: [ {
                    targets: [ 0 ],
                    visible: !1
                }, {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function ( t, a, e, n )
                    {
                        // console.log(e);
                        return `<a  href="javascript::void(0)" onclick="addToPlanQTY(${ e.form_id })"  class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                                <i class="fa flaticon-interface-8"></i>
                                <span>Add to Plan</span>
                            </span>
                        </a>`
                    }
                },
                {
                    targets: 8,
                    title: "Planned QTY",
                    orderable: !1,
                    render: function ( t, a, e, n )
                    {
                        var boPid = 'BOPLAN' + e.form_id + 'AJ';

                        return `<input value="${ e.order_qty }"  id="${ boPid }" style =" color:#000000; border:1px solid #c1c1c1;" type="text" class="form-control form-control-sm form-filter m-input" data-col-index="0">`
                    }
                }, ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();
jQuery( document ).ready( function ()
{
    DatatablesSearchOptionsColumnSearch.init();
    DatatablesSearchOptionsAdvancedSearchOrderClientReport.init();

} );



// var DatatablesSearchOptionsColumnSearch = function() {
//     $.fn.dataTable.Api.register("column().title()", function() {
//         return $(this.header()).text().trim()
//     });
//     return {
//         init: function() {
//             var t;
//             t = $("#m_tableOPerationHealthPlan").DataTable({
//                 responsive: !0,
//                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
//                 lengthMenu: [5, 10, 25, 50],
//                 pageLength: 10,
//                 language: {
//                     lengthMenu: "Display _MENU_"
//                 },
//                 searchDelay: 500,
//                 processing: !0,
//                 serverSide: !0,
//                 ajax: {

//                     url: BASE_URL + '/getOperationOrderPlan',
//                     type: "POST",
//                     data: {
//                         columnsDef: ["RecordID","order_id" ,"bran_name", "item_name", "sales_person", "order_date","curr_stage","order_qty", "Actions"],
//                         '_token': $('meta[name="csrf-token"]').attr('content'),

//                     }
//                 },
//                 columns: [{
//                     data: "RecordID"
//                 }, {
//                     data: "order_id"
//                 }, {
//                     data: "bran_name"
//                 }, {
//                     data: "item_name"
//                 }, {
//                     data: "sales_person"
//                 }, {
//                     data: "order_date"
//                 }, {
//                     data: "curr_stage"
//                 }, {
//                     data: "order_qty"
//                 }, {
//                     data: "Plan QTY"
//                 },{
//                     data: "Actions"
//                 }],

//                 columnDefs: [{
//                     targets: [0],
//                     visible: !1
//                 },{
//                     targets: -1,
//                     title: "Actions",
//                     orderable: !1,
//                     render: function(t, a, e, n) {
//                         return `<a href="#" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
//                         <span>
//                             <i class="fa flaticon-interface-8"></i>
//                             <span>Add to Plan</span>
//                         </span>
//                     </a>`
//                     }
//                 },
//                 {
//                     targets: 8,
//                     title: "Planned QTY",
//                     orderable: !1,
//                     render: function(t, a, e, n) {
//                         return `<input  style =" color:#000000; border:1px solid #c1c1c1;" type="text" class="form-control form-control-sm form-filter m-input" data-col-index="0">`
//                     }
//                 },
//              ]
//             })
//         }
//     }
// }();
// jQuery(document).ready(function() {
//     DatatablesSearchOptionsColumnSearch.init()
// });


jQuery( document ).ready( function ()
{
    DatatablesSearchOptionsAdvancedSearchOrderMainDataList.init()
    DatatablesSearchOptionsAdvancedSearchSampleChemistList.init();
    DatatablesSearchOptionsAdvancedSearchSampleChemistAssingedList.init();
    DatatablesSearchOptionsAdvancedSearchOrderManageDataList.init()
    //  DatatablesMaterialItemDataList.init()
    DatatablesBOMList.init()
    DatatablesSearchOptionsAdvancedSearchOperationHealthDataList.init();
    DatatablesSearchOptionsAdvancedSearchSAP_CHECKList.init();
    //DatatablesSearchOptionsAdvancedSearchOperationHealthPLANOrderDataList.init();


} );
setInterval( function ()
{
    var ajCountTIC = $( '.ajCountTIC' ).html();
    var myDlink = BASE_URL + '/support-ticket';

    if ( UID != 1 )
    {
        if ( ajCountTIC > 0 )
        {
            swal( {
                title: "Support Ticket",
                html: `<a href="${ myDlink }" class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                    <i class="fa flaticon-chat"></i> 															
        <span class="m-badge m-badge--warning">${ ajCountTIC }</span>
        
                </span>
            </a>`,
                animation: !1,
                customClass: "animated tada"
            } )
        }
    }



}, 10000000 );




function delete_ordernow( rowid )
{
    swal( {
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    } ).then( function ( ey )
    {
        if ( ey.value )
        {
            $.ajax( {
                url: BASE_URL + "/deleteOrderNow",
                type: 'POST',
                data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), order_id: rowid },
                success: function ( resp )
                {
                    // console.log(resp);
                    if ( resp.status == 0 )
                    {
                        swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                //location.reload();
                            }
                        } );
                    } else
                    {
                        swal( "Deleted!", "Your Order Item has been deleted.", "success" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                location.reload();
                            }
                        } );
                    }


                },
                dataType: 'json'
            } );

        }

    } )

}


function delete_OrderItem( rowid )
{
    swal( {
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    } ).then( function ( ey )
    {
        if ( ey.value )
        {
            $.ajax( {
                url: BASE_URL + "/deleteItemOrder",
                type: 'POST',
                data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), req_id: rowid },
                success: function ( resp )
                {
                    // console.log(resp);
                    if ( resp.status == 0 )
                    {
                        swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                //location.reload();
                            }
                        } );
                    } else
                    {
                        swal( "Deleted!", "Your Order Item has been deleted.", "success" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                location.reload();
                            }
                        } );
                    }


                },
                dataType: 'json'
            } );

        }

    } )

}

//datagrid Client list

function m_add_order_bill_material( rowid )
{
    //alert(rowid);
    var formData = {
        'recordID': rowid,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getOrderData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            $( '#modal_add_order_bill_material' ).modal( 'show' );
        }
    } );

}

// view_MaterialItem
function view_MaterialItem( rowid, name )
{
    $( '#4item_for_material' ).html( name );
    $( '#rowidItem' ).val( rowid );
    var a;

    var order_index = $( '#rowidItem' ).val();
    a = $( "#m_table_MaterialItemLists" ).DataTable( {
        responsive: !0,
        scrollY: "50vh",
        scrollX: !0,
        bDestroy: true,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100 ],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

            url: BASE_URL + '/getOrderMaterialItemAddedList',
            type: "POST",
            data: {
                columnsDef: [ "rowid", "item_code", "item_name", "item_qty", "remarks", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                'order_index': rowid,
            }
        },
        columns: [ {
            data: "rowid"
        },
        {
            data: "item_code"
        },
        {
            data: "item_name"
        },
        {
            data: "item_qty"
        },
        {
            data: "remarks"
        },
        {
            data: "Actions"
        }
        ],
        initComplete: function ()
        {
            this.api().columns().every( function ()
            {

                switch ( this.title() )
                {

                    case "Status":

                        var a = {
                            1: {
                                title: "DRAFT",
                                class: "m-badge--warning"
                            },
                            2: {
                                title: "Addded BOM",
                                class: " m-badge--metal"
                            },
                            3: {
                                title: "Processing",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "PRODUCTION",
                                class: " m-badge--success"
                            },
                            5: {
                                title: "Dispatched",
                                class: " m-badge--info"
                            },
                            6: {
                                title: "DELIVERED",
                                class: " m-badge--danger"
                            }

                        };
                        this.data().unique().sort().each( function ( t, e )
                        {
                            $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                        } );
                        break;
                }
            } )
        },
        columnDefs: [ {
            targets: 5,
            title: "Actions",
            render: function ( a, t, e, n )
            {
                //  console.log(e.item_name);
                aj = e.item_name;

                var html = `<a href="javascript::void(0)" title="Delete Items" onclick='delete_MaterialItem(${ e.RecordID },\""+aj+"\")' title="Add Material" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="la la-trash-o"></i>  														</a>
                                                          `;


                return html;
            }
        },


        ]
    } )




    $( '#m_select26_modal' ).modal( 'show' );

}
// view_MaterialItem

//=========================

function add_MaterialItem( rowid, name )
{
    $( '#txtMaterialName' ).val( "" );
    $( '#txtMaterialQTY' ).val( "" );
    $( '#txtMaterialRemarks' ).val( "" );
    $( '#item_for_material' ).html( name );
    $( '#rowid' ).val( rowid );
    $( '#m_select2_modal' ).modal( 'show' );
}

//btnAppendSalesClient
$( '#btnAppendSalesClient' ).click( function ()
{
    var salesUserID = $( '#m_select2_1_salesPar' ).select2().val();

    var formData = {
        'salesUserID': salesUserID,

        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/getAllSalesuserClientAppend',
        type: 'GEt',
        data: formData,
        success: function ( res )
        {
            $( '.showClietAppend' ).html( res );
        }
    } );





} );
//btnAppendSalesClient

// add_MaterialItem
$( '#btnSaveBillMaterial' ).click( function ()
{
    var rowid = $( '#rowid' ).val();
    var items = $( '#m_select2_4_modal' ).select2().val();

    var formData = {
        'recordID': rowid,
        'item_code': items,
        'txtMaterialQTY': $( '#txtMaterialQTY' ).val(),
        'txtMaterialRemarks': $( 'textarea#txtMaterialRemarks' ).val(),
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/saveMaterialItem',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            //console.log(res);
            toasterOptions();
            toastr.success( 'Saved successfully!', 'Order Material' )
            setTimeout( function ()
            {
                //window.location.href = BASE_URL+'/orders'
                location.reload();


            }, 2000 );


        }
    } );

    // ajax call


} );
// 
var DatatablesDataSourceHtml_LEADRUNCRON = {
    init: function ()
    {
        $( "#m_table_1_LEADRUNCRON" ).DataTable( {
            responsive: !0,
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function ( a, t, e, n )
                {

                    return `<a href="javascript::void(0)" onclick="startCronJOB(${ e[ 0 ] },'${ e[ 1 ] }','${ e[ 2 ] }','${ e[ 3 ] }')"  class="btn btn-warning btn-sm m-btn  m-btn m-btn--icon">
                    <span>
                        <i class="fa flaticon-refresh"></i>
                        <span>START NOW</span>
                    </span>
                </a>`
                }
            },


            ]
        } )
    }
};

function startCronJOB( rowid, startDate, endDate, ApiName )
{


    var arrayData = ApiName.split( "@" );

    var formData = {
        'startDate': startDate,
        'endDate': endDate,
        'ApiName': arrayData[ 1 ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/api/setAjaxRunCronjonLead',
        type: 'GET',
        data: formData,
        success: function ( res )
        {

            swal( "Please Wait...", "Cron Job Running.....", "info" ).then( function ( eyz )
            {


            } );

        }
    } );


}

// m_table_1_LEADRUNCRON

//HTML Material List Datalist
var DatatablesDataSourceHtml_MaterialItem = {
    init: function ()
    {
        $( "#m_table_1" ).DataTable( {
            responsive: !0,
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function ( a, t, e, n )
                {
                    return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                }
            }, {
                targets: 8,
                render: function ( a, t, e, n )
                {
                    var s = {
                        1: {
                            title: "Pending",
                            class: "m-badge--brand"
                        },
                        2: {
                            title: "Delivered",
                            class: " m-badge--metal"
                        },
                        3: {
                            title: "Canceled",
                            class: " m-badge--primary"
                        },
                        4: {
                            title: "Success",
                            class: " m-badge--success"
                        },
                        5: {
                            title: "Info",
                            class: " m-badge--info"
                        },
                        6: {
                            title: "Danger",
                            class: " m-badge--danger"
                        },
                        7: {
                            title: "Warning",
                            class: " m-badge--warning"
                        }
                    };
                    return void 0 === s[ a ] ? a : '<span class="m-badge ' + s[ a ].class + ' m-badge--wide">' + s[ a ].title + "</span>"
                }
            }, {
                targets: 9,
                render: function ( a, t, e, n )
                {
                    var s = {
                        1: {
                            title: "Online",
                            state: "danger"
                        },
                        2: {
                            title: "Retail",
                            state: "primary"
                        },
                        3: {
                            title: "Direct",
                            state: "accent"
                        }
                    };
                    return void 0 === s[ a ] ? a : '<span class="m-badge m-badge--' + s[ a ].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[ a ].state + '">' + s[ a ].title + "</span>"
                }
            } ]
        } )
    }
};

jQuery( document ).ready( function ()
{
    DatatablesDataSourceHtml_MaterialItem.init()
    DatatablesDataSourceHtml_LEADRUNCRON.init()
} );

//HTML Material List Datalist

function add_MaterialItemMore( rowid )
{
    //alert(rowid);
    $( '#m_select27_modal' ).modal( 'show' );

}

// add_MaterialItem on chnage
$( '#btnAddMatItemType' ).click( function ()
{
    var formData = {

        'item_name': $( '#txt_m_type_name' ).val(),
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/setMaterialAttribue',
        type: 'GET',
        data: formData,
        success: function ( res )
        {
            $( "#m_select2_4_modal" ).append( res );
            $( '#m_select2_4_modal' ).trigger( 'change' );
            $( '#m_select27_modal' ).modal( 'hide' );
        }
    } );
    // ajax call
} );

function updateRNDFormulationStatus( row )
{
    $( '#txtRowIDx' ).val( row );
    $( '#m_modal_5_RNDUpdateFormula' ).modal( 'show' );


}
function showSampleMap( row )
{
    var formData = {

        'txtRMName': '33',
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/getPendingFormulationSampleList',
        type: 'GET',
        data: formData,
        success: function ( res )
        {

            $( '#txtRowID' ).val( row );
            $( '#m_select2_2_modal' ).html( res );
            $( '#m_select2_modal' ).modal( 'show' );



        }
    } );


}
function showBaseModal()
{

    // $( '#m_modal_5_RNDBaseAsk' ).modal( 'show' );
    $( '#m_modal_4TicketWindowRND_BASE' ).modal( 'show' );
}
function showBatchSizr( row )
{
    $( '#txtRowID' ).val( row );
    $( '#m_modal_4ING_DETAIL_AJ' ).modal( 'show' );
}
//btnFormulaBatchPrintBase
$( '#btnFormulaBatchPrintBase' ).click( function ()
{
    var txtBatchViewData = $( '#txtBatchViewData' ).val();
    var txtRowID = $( '#txtRowID' ).val();
    var rLink = BASE_URL + '/rnd-ingrednts-print-base/' + txtRowID + "/" + txtBatchViewData;

    window.location.href = rLink;


} );
//btnFormulaBatchPrintBase

$( '#btnFormulaBatchPrint' ).click( function ()
{
    var txtBatchViewData = $( '#txtBatchViewData' ).val();
    var txtRowID = $( '#txtRowID' ).val();
    var rLink = BASE_URL + '/rnd-ingrednts-print/' + txtRowID + "/" + txtBatchViewData;

    window.location.href = rLink;


} );



$( '#btnAddRMProduct' ).click( function ()
{

    var txtRMName = $( '#txtRMName' ).val();
    var txtRMPrice = $( '#txtRMprice' ).val();
    if ( txtRMName == null )
    {
        toastr.error( 'RM name is required', 'Formulation' );
        return false;
    }
    var formData = {

        'txtRMName': txtRMName,
        'txtRMPrice': txtRMPrice,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/saveRMToIngredent',
        type: 'POST',
        data: formData,
        success: function ( res )
        {

            if ( res.status == 1 )
            {

                toastr.success( 'Submitted Successfully', 'Formulation' );


                $( '#m_select2_4_modal_AddNewRM' ).modal( 'hide' );

            }


        }
    } );



} );

//baseFormulaID

$( "#m_select2_3_baseFormulaH" ).change( function ()
{

    var fm_id = $( this ).val();
    var formData = {
        'fm_id': fm_id,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/getFormulationDataForBase',
        type: 'GET',
        data: formData,
        success: function ( res )
        {
            $( '.input_fields_wrapFormulationBase' ).html();

            var bo_formuation_childArr = res.bo_formuation_child;
            var bo_formuation_child_processArr = res.bo_formuation_child_process;

            $.each( bo_formuation_childArr, function ( index, value )
            {
                console.log( value );
                // Will stop running after "three"


            $( '.input_fields_wrapFormulationBase' ).append( `<tr>
            <td width="350px">
            <input type ="hidden" name="txtINGID[]" value="${value.ingredent_id}" >
                ${value.ingredent_name}
            </td>
           
            <td width="100px">
            <input type="text"  name="txtDoseData[]" data-Enterprice="" value="${value.dos_percentage}" class="form-control m-input ajdoseClass" placeholder="">
           
            </td>
            
            <td width="100px"  >
            <input type="text" readonly name="txtPriceData[]" value="${value.price}"  class="form-control m-input ajPriceClass" placeholder="">
            </td>
            <td width="180px">
            <input type="text" readonly name="txtRNDCost[]" value="${value.cost}" class="form-control m-input ajCostClass" placeholder="">
            </td>
            <td>
            
            <a href="#" style="margin-top: 1px;" class="remove_fieldForm btn btn-danger  m-btn 	m-btn m-btn--icon">
        <span>
            <i class="la la-trash"></i>

        </span>
    </a>

            </td>
        </tr>`);

               
            } );


        }
    } );


} );

//baseFormulaID
$( '#m_select2_4_modal' ).change( function ()
{
    var item_type_code = $( this ).val();
    var formData = {

        'item_type_code': item_type_code,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    // ajax call
    $.ajax( {
        url: BASE_URL + '/getMaterialAttribue',
        type: 'GET',
        data: formData,
        success: function ( res )
        {

            $( "#m_select2_3_modal" ).html( '' ).append( res );
            $( '#m_select2_3_modal' ).trigger( 'change' );
        }
    } );

    // Set selected
    //  $('#sel_users').val(value);
    //$('#sel_users').select2().trigger('change');

} );

// add_MaterialItem on chnage


//version two
var DatatablesOrderItemAddedList = {
    init: function ()
    {
        var item_id = $( '#order_item_id' ).val();
        $( "#m_table_orderItemAddedList" ).DataTable( {
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {

                url: BASE_URL + '/getOrderMItemsAddedList',
                type: "POST",
                data: {
                    columnsDef: [ "RecordID", "product_name", "item_cat", "item_material_name", "item_qty", "created_on", "created_by", "remarks", "Actions" ],
                    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                    'item_id': item_id,
                }
            },
            columns: [ {
                data: "RecordID"
            }, {
                data: "product_name"
            }, {
                data: "item_cat"
            }, {
                data: "item_material_name"
            }, {
                data: "item_qty"
            }, {
                data: "created_on"
            }, {
                data: "created_by"
            }, {
                data: "remarks"
            }, {
                data: "Actions"
            } ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function ( a, e, t, n )
                {
                    return `<a href="#" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-edit"></i>
                </a>
                <a href="javascript::void(0)" onclick="delete_OrderItemAdded(26)" title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-delete"></i>
                </a>
                `
                }
            }, {
                "visible": false,
                "targets": 0
            },
            ]
        } )
    }
};




var DatatablesSTOCKAddedList = {
    init: function ()
    {
        var item_id = $( '#order_item_id' ).val();
        $( "#m_table_STOCK_ADDED_TALLYList" ).DataTable( {
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {

                url: BASE_URL + '/getStock_AddedList',
                type: "POST",
                data: {
                    columnsDef: [ "RecordID", "stock_flag", "product_name", "item_cat", "item_material_name", "item_qty", "stock_in", "stock_status", "Actions" ],
                    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                    'item_id': item_id,
                }
            },
            columns: [ {
                data: "RecordID"
            }, {
                data: "product_name"
            }, {
                data: "item_cat"
            }, {
                data: "item_material_name"
            }, {
                data: "item_qty"
            }, {
                data: "stock_in"
            }, {
                data: "stock_status"
            }, {
                data: "Actions"
            } ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function ( a, e, t, n )
                {
                    // console.log(t);
                    var html = "";
                    if ( t.stock_flag == 1 )
                    {
                        html += `<a href="javascript::void(0)" onclick="itemsReserved(${ t.RecordID })" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn">
                       </i>RESERVE NOW
                    </a>`;
                    }
                    if ( t.stock_flag == 2 )
                    {

                        html += `<a href="javascript::void(0)" onclick="itemsRequestPurchase(${ t.RecordID })" title="EDIT" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn">
                        </i>PURCHASE NOW
                     </a>`;

                    }

                    if ( t.stock_flag == 3 )
                    {

                        html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">REQUESTED </span>`;
                    }
                    if ( t.stock_flag == 4 )
                    {

                        html += `<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">REQUESTED </span>`;
                    }

                    return html;


                }
                ,
            },
            {
                targets: 6,
                render: function ( a, t, e, n )
                {
                    var i = {

                        1: {
                            title: "Availabe",
                            class: " m-badge--success"
                        },
                        2: {
                            title: "Out of Stock",
                            class: "m-badge--danger"
                        },
                        3: {
                            title: "Reserved",
                            class: "m-badge--info"
                        },
                        4: {
                            title: "Purchase",
                            class: "m-badge--warning"
                        },
                        5: {
                            title: "Ordered",
                            class: "m-badge--info"
                        },
                        5: {
                            title: "Reserved Now",
                            class: "m-badge--info"
                        },

                    };
                    return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                }
            },
            {
                "visible": true,
                "targets": 0
            },
            ]
        } )
    }
};


var DatatablesOrderItemAddedList = {
    init: function ()
    {
        var item_id = $( '#order_item_id' ).val();
        $( "#m_table_orderItemAddedList" ).DataTable( {
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {

                url: BASE_URL + '/getOrderMItemsAddedList',
                type: "POST",
                data: {
                    columnsDef: [ "RecordID", "product_name", "item_cat", "item_material_name", "item_qty", "created_on", "created_by", "remarks", "Actions" ],
                    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                    'item_id': item_id,
                }
            },
            columns: [ {
                data: "RecordID"
            }, {
                data: "product_name"
            }, {
                data: "item_cat"
            }, {
                data: "item_material_name"
            }, {
                data: "item_qty"
            }, {
                data: "created_on"
            }, {
                data: "created_by"
            }, {
                data: "remarks"
            }, {
                data: "Actions"
            } ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function ( a, e, t, n )
                {

                    return `
                <a href="javascript::void(0)" onclick="deleteBOMItem(${ t.RecordID })" title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-delete"></i>
                            														</a>
                `
                }
            }, {
                "visible": false,
                "targets": 0
            },
            ]
        } )
    }
};
jQuery( document ).ready( function ()
{
    DatatablesOrderItemAddedList.init()
    DatatablesSTOCKAddedList.init()
    DatatablesPurchaseReservedList.init();

} );


//v2



function itemsReserved( rowid )
{



    //ajax request
    var formData = {
        'rowid': rowid,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/reserveItemfromStock',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {
                toasterOptions();
                toastr.success( 'Reserved successfully', 'Stock Reserved' )
                setTimeout( function ()
                {


                    location.reload();
                }, 500 );
            }
        },
        dataType: 'json'
    } );

    //ajax request

}

//request for purchase
function itemsRequestPurchase( rowid )
{
    //ajax request
    var formData = {
        'rowid': rowid,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

    };

    $.ajax( {
        url: BASE_URL + '/purchaseItemforStock',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {
                toasterOptions();
                toastr.success( 'Request for purchase successfully', 'Stock Purchase ' )
                setTimeout( function ()
                {

                    //location.reload();
                }, 2000 );
            }
        },
        dataType: 'json'
    } );

    //ajax request

}


//btnCnfBOMItems
$( '#btnConfirmBOM' ).click( function ()
{

    //ajax request
    var formData = {
        'order_item_id': $( '#order_item_id' ).val(),
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

    };

    $.ajax( {
        url: BASE_URL + '/BOMConfirmation',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {
                toasterOptions();
                toastr.success( 'You have successfully confirm', 'BOM Confirmation' )
                setTimeout( function ()
                {
                    location.reload();
                }, 2000 );
            }
        },
        dataType: 'json'
    } );

    //ajax request


} );
//btnCnfBOMItems


//deleteBOMItem



function deleteBOMItem( rowid )
{
    var order_item_id = $( '#order_item_id' ).val();
    swal( {
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    } ).then( function ( ey )
    {
        if ( ey.value )
        {
            $.ajax( {
                url: BASE_URL + "/deleteBOMItems",
                type: 'POST',
                data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), order_id: rowid },
                success: function ( resp )
                {
                    // console.log(resp);
                    if ( resp.status == 0 )
                    {
                        swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                //location.reload();
                            }
                        } );
                    } else
                    {
                        swal( "Deleted!", "Your BOM Item has been deleted.", "success" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {

                                window.location.href = BASE_URL + "/orders/" + order_item_id;
                            }
                        } );
                    }


                },
                dataType: 'json'
            } );

        }

    } )

}



//deleteBOMItem







var WizardORDERFROM = function ()
{
    $( "#m_wizard" );
    var e, r, i = $( "#m_form" );
    return {
        init: function ()
        {
            var n;
            $( "#m_wizard" ), i = $( "#m_form" ), ( r = new mWizard( "m_wizard", {
                startStep: 1
            } ) ).on( "beforeNext", function ( r )
            {
                !0 !== e.form() && r.stop()
                //ajax all next save here
                $( '#m_form' ).ajaxSubmit();
                var stepN = r.getStep();
                if ( stepN == 2 )
                {
                    //show data in text fields.   
                    $( '#txtPDDate' ).val( $( "input[name=txtSelectedDate]" ).val() );
                    $( '#txtPType' ).val( $( "#plan_type option:selected" ).html() );
                    $( '#txtPManPower' ).val( $( "input[name=txtManPowerExpected]" ).val() );
                    $( '#txtPShiftHour' ).val( $( "input[name=txtworkShiftHour]" ).val() );
                    var mpe = $( "input[name=txtManPowerExpected]" ).val();
                    var mwh = $( "input[name=txtworkShiftHour]" ).val();
                    $( '#txtPManHours' ).val( mpe * mwh );
                    $( '#txtAjVal' ).val( mpe );
                    //show data in text fields.
                }
                if ( stepN == 3 )
                {
                    // code to show data of plan4
                    $( "#m_tableOPerationHealthPlan4" ).dataTable().fnDestroy();
                    var a;
                    var txtPlanID = $( '#txtPlanID' ).val();


                    a = $( "#m_tableOPerationHealthPlan4" ).DataTable( {
                        responsive: !0,
                        dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                        lengthMenu: [ 5, 10, 25, 50 ],
                        pageLength: 10,
                        dom: 'Bfrtip',
                        buttons: [

                            { extend: 'excelHtml5', footer: true },
                            { extend: 'pdfHtml5', footer: true }
                        ],

                        footerCallback: function ( t, e, n, a, r )
                        {
                            var o = this.api();

                            $( o.column( 1 ).footer() ).html( '<stong></strong>' )

                        },

                        language: {
                            lengthMenu: "Display _MENU_"
                        },
                        searchDelay: 500,
                        processing: !0,
                        serverSide: !0,
                        ajax: {
                            url: BASE_URL + '/getPlanedOrderDay4Data',
                            type: "POST",
                            data: {
                                columnsDef: [ "RecordID", "order_id", "form_id", "bran_name", "operationName", "manp_alloted", "hour_alloted", "manh_alloted", "achiv_qty", "Actions" ],
                                _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                                'txtPlanID': txtPlanID
                            }
                        },
                        columns: [ {
                            data: "RecordID"
                        }, {
                            data: "order_id"
                        }, {
                            data: "bran_name"
                        }, {
                            data: "operationName"
                        }, {
                            data: "manp_alloted"
                        }, {
                            data: "hour_alloted"
                        }, {
                            data: "manh_alloted"
                        }, {
                            data: "achiv_qty"
                        }, {
                            data: "Actions"
                        } ],
                        initComplete: function ()
                        {
                            this.api().columns().every( function ()
                            {
                                switch ( this.title() )
                                {
                                    case "Country":
                                        this.data().unique().sort().each( function ( a, t )
                                        {
                                            $( '.m-input[data-col-index="2"]' ).append( '<option value="' + a + '">' + a + "</option>" )
                                        } );
                                        break;
                                    case "Status":
                                        var a = {
                                            1: {
                                                title: "Pending",
                                                class: "m-badge--brand"
                                            },
                                            2: {
                                                title: "Delivered",
                                                class: " m-badge--metal"
                                            },
                                            3: {
                                                title: "Canceled",
                                                class: " m-badge--primary"
                                            },
                                            4: {
                                                title: "Success",
                                                class: " m-badge--success"
                                            },
                                            5: {
                                                title: "Info",
                                                class: " m-badge--info"
                                            },
                                            6: {
                                                title: "Danger",
                                                class: " m-badge--danger"
                                            },
                                            7: {
                                                title: "Warning",
                                                class: " m-badge--warning"
                                            }
                                        };
                                        this.data().unique().sort().each( function ( t, e )
                                        {
                                            $( '.m-input[data-col-index="6"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                        } );
                                        break;
                                    case "Type":
                                        a = {
                                            1: {
                                                title: "Online",
                                                state: "danger"
                                            },
                                            2: {
                                                title: "Retail",
                                                state: "primary"
                                            },
                                            3: {
                                                title: "Direct",
                                                state: "accent"
                                            }
                                        }, this.data().unique().sort().each( function ( t, e )
                                        {
                                            $( '.m-input[data-col-index="7"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
                                        } )
                                }
                            } )
                        },
                        columnDefs: [ {
                            targets: [ 0 ],
                            visible: !1
                        }, {
                            targets: -1,
                            title: "Actions",
                            orderable: !1,
                            render: function ( a, t, e, n )
                            {
                                return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                            }
                        }, {
                            targets: 6,
                            render: function ( a, t, e, n )
                            {
                                var i = {
                                    1: {
                                        title: "Pending",
                                        class: "m-badge--brand"
                                    },
                                    2: {
                                        title: "Delivered",
                                        class: " m-badge--metal"
                                    },
                                    3: {
                                        title: "Canceled",
                                        class: " m-badge--primary"
                                    },
                                    4: {
                                        title: "Success",
                                        class: " m-badge--success"
                                    },
                                    5: {
                                        title: "Info",
                                        class: " m-badge--info"
                                    },
                                    6: {
                                        title: "Danger",
                                        class: " m-badge--danger"
                                    },
                                    7: {
                                        title: "Warning",
                                        class: " m-badge--warning"
                                    }
                                };
                                return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                            }
                        }, {
                            targets: 7,
                            render: function ( a, t, e, n )
                            {
                                var i = {
                                    1: {
                                        title: "Online",
                                        state: "danger"
                                    },
                                    2: {
                                        title: "Retail",
                                        state: "primary"
                                    },
                                    3: {
                                        title: "Direct",
                                        state: "accent"
                                    }
                                };
                                return void 0 === i[ a ] ? a : '<span class="m-badge m-badge--' + i[ a ].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + i[ a ].state + '">' + i[ a ].title + "</span>"
                            }
                        } ]
                    } ), $( "#m_search" ).on( "click", function ( t )
                    {
                        t.preventDefault();
                        var e = {};
                        $( ".m-input" ).each( function ()
                        {
                            var a = $( this ).data( "col-index" );
                            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                        } ), $.each( e, function ( t, e )
                        {
                            a.column( t ).search( e || "", !1, !1 )
                        } ), a.table().draw()
                    } ), $( "#m_reset" ).on( "click", function ( t )
                    {
                        t.preventDefault(), $( ".m-input" ).each( function ()
                        {
                            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                        } ), a.table().draw()
                    } ), $( "#m_datepicker" ).datepicker( {
                        todayHighlight: !0,
                        templates: {
                            leftArrow: '<i class="la la-angle-left"></i>',
                            rightArrow: '<i class="la la-angle-right"></i>'
                        }
                    } )

                    // code to show data of plan4
                }
                //ajax all
            } ), r.on( "change", function ( e )
            {
                mUtil.scrollTop()
            } ), r.on( "change", function ( e )
            {
                1 === e.getStep()
            } ), e = i.validate( {
                ignore: ":hidden",
                rules: {
                    txtSelectedDate: {
                        required: !0
                    }, txtManPowerExpected: {
                        required: !0
                    },

                },

                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTop(), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    } )
                },
                submitHandler: function ( e ) { }
            } ), ( n = i.find( '[data-wizard-action="submit"]' ) ).on( "click", function ( r )
            {
                r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
                    success: function ()
                    {
                        mApp.unprogress( n ), swal( {
                            title: "",
                            text: "The plan  has been successfully submitted!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        } )
                    }
                } ) )
            } ),
                ( n = i.find( '[data-wizard-action="nextSave"]' ) ).on( "click", function ( r )
                {
                    r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
                        success: function ()
                        {
                            toasterOptions();
                            toastr.success( 'Operation Plan saved!', 'Operation Health' )
                            setTimeout( function ()
                            {

                                // $('input[type="submit"]').attr('disabled','disabled');
                                //window.location.href = BASE_URL+'/orders'
                                //location.reload();


                            }, 500 );

                        }
                    } ) )
                } )
        }
    }
}();
jQuery( document ).ready( function ()
{
    WizardORDERFROM.init() //checking any error occur nor not
} );


//$(btnFinalDispatch).click();


// $("#btnFinalDispatch").click(function(){        

//     $("#myFormFinalDispatch").submit(); // Submit the form

// });

$( "#myFormFinalDispatch" ).submit( function ( e )
{



    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $( this );
    var url = form.attr( 'action' );

    $.ajax( {
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function ( data )
        {
            //console.log(data);
            if ( data.status == 0 )
            {
                toasterOptions();
                toastr.error( 'Invalid Entry!', 'Order Dispatch' )
                setTimeout( function ()
                {
                    //window.location.href = BASE_URL+'/orders'
                    //location.reload();


                }, 500 );

            } else
            {
                toasterOptions();
                toastr.success( 'Success!', 'Order Dispatch' )
                setTimeout( function ()
                {
                    //window.location.href = BASE_URL+'/orders'
                    //   location.reload();


                }, 500 );
            }
        }, dataType: 'json'
    } );


} );

function updateSAPList( form_id, Ord_type_id )
{
    //BO783AJ1
    var sapCHKID = '#BO' + form_id + 'AJ' + Ord_type_id;
    var sap_flag = 0;
    var SAPType = '';

    if ( $( sapCHKID ).is( ":checked" ) )
    {

        sap_flag = 1;

    } else
    {
        sap_flag = 0;
    }
    switch ( Ord_type_id )
    {
        case 1:

            SAPType = 'sap_so';
            break;
        case 2:
            SAPType = 'sap_fg';
            break;
        case 3:
            SAPType = 'sap_sfg';
            break;
        case 4:
            SAPType = 'sap_production';
            break;
        case 5:
            SAPType = 'sap_invoice';
            break;
        case 6:
            SAPType = 'sap_dispatch';
            break;


    }


    var formData = {
        'form_id': form_id,
        'sap_flag': sap_flag,
        'SAPType': SAPType,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/setProcessSAPChecklist',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {
                toasterOptions();
                toastr.success( 'Process Successfully ', 'SAP Checklist' );
                return true;
            }
        }
    } );




}

//order filer by asc and desc by since 
$( "input[name=stay_from]" ).click( function ()
{
    var radioValue = $( "input[name='stay_from']:checked" ).val();


    $( "#m_table_QCFORMList_v1OrderList" ).dataTable().fnDestroy()


    //-------------------------------------------
    var buttonCommonORDER = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node )
                {
                    // Strip $ from salary column to make it numeric
                    //console.log(data);
                    if ( column === 9 )
                    {

                        return '';

                    } else
                    {
                        if ( column === 10 )
                        {
                            return '';
                        } else
                        {
                            if ( column == 8 )
                            {
                                var myStr = data;

                                var subStr = myStr.match( "Details'>(.*)</h6>" );


                                return subStr[ 1 ]

                            }
                            return data;
                        }


                    }


                }
            }
        }
    };


    a = $( "#m_table_QCFORMList_v1OrderList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        lengthMenu: [ 5, 10, 25, 50, 100, 200 ],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        //dom: 'Blfrtip',
        buttons: [

            $.extend( true, {}, buttonCommonORDER, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommonORDER, {
                extend: 'pdfHtml5'
            } )

        ],
        ajax: {

            url: BASE_URL + '/qcform.getList_v1',
            type: "POST",
            data: {
                columnsDef: [ "RecordID", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        },
        columns: [
            {
                data: "RecordID"
            },
            {
                data: "order_id"
            },
            {
                data: "brand_name"
            },

            {
                data: "order_repeat"
            },

            {
                data: "item_name"
            },
            {
                data: "order_value"
            },
            {
                data: "created_on"
            },
            {
                data: "created_by"
            },
            {
                data: "curr_order_statge"
            },
            {
                data: "order_type"
            },
            {
                data: "Actions"
            }
        ],

        columnDefs: [ {
            targets: [ 0, -2 ],
            visible: !1
        },
        {
            targets: 4,
            title: "Item Name",
            orderable: !0,
            render: function ( a, t, e, n )
            {
                // console.log(e.bulk_data);
                var JS_HTML = '';
                if ( e.order_typeNew == 1 )
                {
                    return e.bulkCount;

                } else
                {
                    return e.item_name;
                }

            }
        },
        {
            targets: 6,
            title: "Created On",
            orderable: !0,
            render: function ( a, t, e, n )
            {
                //console.log(e);
                var htmlcreated = e.created_on + ' [' + e.stay_from + ']';
                return htmlcreated;

            }
        },

        {
            targets: 5,
            title: "Order Value",
            orderable: !0,
            render: function ( a, t, e, n )
            {
                // console.log(e);
                if ( e.role_data == 'Admin' || e.role_data == 'SalesUser' || e.role_data == 'SalesHead' )
                {

                    var userAj = $( 'meta[name="UUID"]' ).attr( 'content' );
                    if ( userAj == 88 )
                    {
                        return 'NA';

                    } else
                    {
                        if ( e.order_typeNew == 1 )
                        {
                            return e.bulkOrderValueData;
                        } else
                        {
                            return e.order_value;
                        }
                    }




                } else
                {

                    return 'NA';
                }

            }
        },
        {
            targets: -3,
            title: "Current Stages",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                var process_id = 1;
                return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


            }
        },
        {
            targets: -1,
            title: "Actions$",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                //console.log(e.qc_from_bulk);
                if ( e.role_data != 'Admin' )
                {
                    $( '.buttons-html5' ).hide();

                }

                if ( e.qc_from_bulk == 1 )
                {
                    edit_URL = BASE_URL + '/qcform/' + e.form_id + '/edit';
                    manageOrder_URL = BASE_URL + '/order-wizard/' + e.form_id;
                    print_URL = BASE_URL + '/print/qcform-bulk/' + e.form_id;
                    view_URL = BASE_URL + '/sample/' + e.RecordID + '';
                } else
                {
                    edit_URL = BASE_URL + '/qcform/' + e.form_id + '/edit';
                    manageOrder_URL = BASE_URL + '/order-wizard/' + e.form_id;
                    print_URL = BASE_URL + '/print/qcform/' + e.form_id;
                    view_URL = BASE_URL + '/sample/' + e.RecordID + '';
                }

                //edit_URL=BASE_URL+'/qcform/'+e.form_id+'/edit';
                if ( e.order_type == 'Private Label' )
                {
                    edit_URL = BASE_URL + '/qcform/' + e.form_id + '/edit';
                } else
                {
                    edit_URL = '#';
                }
                copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';

                if ( e.role_data == 'Staff' )
                {

                    if ( UID == 102 )
                    {
                        var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-print"></i>
              </a> 
              
            
              <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-trash"></i>
            </a>  
             <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-eye"></i>
              </a> 
              </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-image"></i>
            </a> 
            </a>  <a href="${ copy_URL }"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-copy"></i>
          </a> 
              
               `;

                    } else
                    {
                        var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-print"></i>
              </a> 
              <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-eye"></i>
            </a>
              `;

                        if ( e.edit_qc_from )
                        {
                            // console.log(e.edit_qc_from);
                            //console.log('CAN  EDIT');
                            html += ` <a href="${ edit_URL }" style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                 <i class="la la-print"></i>
               </a>  
               <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
               <i class="la la-eye"></i>
             </a>  
             <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
               <i class="la la-image"></i>
             </a>                   
               `;



                        }

                    }



                }
                if ( e.role_data == 'Admin' )
                {
                    var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a> 
          
          <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-edit"></i>
          </a>
          <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-trash"></i>
          </a> 
          <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-image"></i>
        </a> 
        </a>  <a href="${ copy_URL }"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-copy"></i>
        </a> 
          
           `;
                }

                //   <a href="${edit_URL}"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                //   <i class="la la-edit"></i>
                // </a> 

                if ( e.role_data == 'SalesUser' )
                {
                    var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a> 
          
        
          <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-trash"></i>
        </a>  
         <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a> 
          </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-image"></i>
        </a> 
        </a>  <a href="${ copy_URL }"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="la la-copy"></i>
      </a> 
          
           `;
                }

                if ( e.role_data == 'CourierTrk' )
                {
                    var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a> 
          
          <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-edit"></i>
          </a> 
          <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-trash"></i>
        </a>  
         <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a> 
          </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-image"></i>
        </a> 
        </a>  <a href="${ copy_URL }"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="la la-copy"></i>
      </a> 
          
           `;
                }

                if ( e.role_data == 'SalesHead' )
                {
                    var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a>          
         <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a> 
          </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-image"></i>
        </a> 
        </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessList(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="la la-plus"></i>
      </a>

           `;
                }


                return html;

            }
        },

        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } )

    //--------------------------------------------


} );

//order filer by asc and desc by since 

//fitler 
$( ".ajSap" ).click( function ()
{

    var favorite = [];

    $.each( $( "input[name='sapCHKFilter']:checked" ), function ()
    {

        favorite.push( $( this ).val() );

    } );

    var chkOption = 0;

    $.each( $( "input[name='req_val']:checked" ), function ()
    {

        //chkOption.push($(this).val());
        chkOption = $( this ).val();

    } );

    var a;
    $( "#m_table_SAP_CHECKList" ).dataTable().fnDestroy()


    var buttonCommonA = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node )
                {
                    // Strip $ from salary column to make it numeric
                    // return column === 5 ?
                    //     data.replace( /[$,]/g, '' ) :
                    //     data;
                    if ( column === 5 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }
                    if ( column === 6 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }
                    if ( column === 7 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }
                    if ( column === 8 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }
                    if ( column === 9 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }
                    if ( column === 10 )
                    {
                        var str2 = 'BLNK';
                        if ( data.indexOf( str2 ) != -1 )
                        {
                            return '';
                        } else
                        {
                            return 'YES';
                        }

                    }

                    return data;
                }
            }
        }
    };




    a = $( "#m_table_SAP_CHECKList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
        pageLength: 10,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Bfrltip',
        buttons: [
            $.extend( true, {}, buttonCommonA, {
                extend: 'pdfHtml5'
            } )
        ],


        ajax: {
            url: BASE_URL + '/getSAPCheckListData',
            type: "POST",
            data: {
                columnsDef: [
                    "RecordID",
                    "order_id",
                    "brand_name",
                    "item_name",
                    "curr_stage",
                    "sap_so",
                    "sap_fg",
                    "sap_sfg",
                    "sap_production",
                    "sap_invoice",
                    "sap_dispatch",
                ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                'favorite': favorite,
                'req_val': chkOption
            }
        },
        columns: [ {
            data: "RecordID"
        },
        {
            data: "order_id"
        },
        {
            data: "brand_name"
        },
        {
            data: "item_name"
        },
        {
            data: "curr_stage"
        },




        ],

        columnDefs: [ {
            targets: [ 0 ],
            visible: !1
        },
        {
            targets: 5,
            title: "Sales Orders",
            orderable: !1,
            render: function ( a, t, e, n )
            {

                var chID = 'BO' + e.RecordID + 'AJ' + 1;

                return `<div class="m-checkbox-list">
                   <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                <input ${ e.sap_so } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },1)">
                                                                <span></span>
                                                            </label>
               </div>`;

            }
        },
        {
            targets: 6,
            title: "FG",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                var chID = 'BO' + e.RecordID + 'AJ' + 2;

                return `<div class="m-checkbox-list">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                 <input ${ e.sap_fg } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },2)">
                                                                 <span></span>
                                                             </label>
                </div>`;

            }
        },
        {
            targets: 7,
            title: "SFG",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                var chID = 'BO' + e.RecordID + 'AJ' + 3;

                return `<div class="m-checkbox-list">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                 <input  ${ e.sap_sfg } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },3)">
                                                                 <span></span>
                                                             </label>
                </div>`;

            }
        },
        {
            targets: 8,
            title: "PRODUCTION",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                var chID = 'BO' + e.RecordID + 'AJ' + 4;

                return `<div class="m-checkbox-list">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                 <input   ${ e.sap_production }  type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },4)">
                                                                 <span></span>
                                                             </label>
                </div>`;

            }
        },
        {
            targets: 9,
            title: "INVOICING",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                var chID = 'BO' + e.RecordID + 'AJ' + 5;

                return `<div class="m-checkbox-list">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                 <input ${ e.sap_invoice } type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },5)">
                                                                 <span></span>
                                                             </label>
                </div>`;

            }
        },
        {
            targets: 10,
            title: "DISPATCHED",
            orderable: !1,
            render: function ( a, t, e, n )
            {

                var chID = 'BO' + e.RecordID + 'AJ' + 6;

                return `<div class="m-checkbox-list">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                 <input ${ e.sap_dispatch }  type="checkbox" id="${ chID }" onclick="updateSAPList(${ e.RecordID },6)">
                                                                 <span></span>
                                                             </label>
                </div>`;

            }
        },


        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } )






} );

//reqForIssueOrder

function reqForIssueOrderModel( form_id )
{

    $( '#txtQCFId' ).val( form_id );

    $( '#m_modal_reqForIssueOrder' ).modal( 'show' );


}
//reqForIssueOrderModelHistory
function reqForIssueOrderModelHistory( form_id )
{

    var formData = {
        'form_id': form_id,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/setBulkOrderReqIssueProcessHistory',
        type: 'GET',
        data: formData,
        success: function ( resp )
        {
            $( '.showReqForIssueOrderHistory' ).html( resp.HTML );
            $( '#m_modal_reqForIssueOrderHistory' ).modal( 'show' );

        },
        dataType: 'json'
    } );




}


///reqForIssueOrderModelHistory

//reqForIssueOrder
$( '#btnSendMessage' ).click( function ()
{

    var opclass = '#txtreqStatus option:selected';
    var reqStatus = $( opclass ).val();

    var formData = {
        'form_id': $( '#txtQCFId' ).val(),
        'reqStatus': reqStatus,
        'reqMsg': $( 'textarea#reqMessage' ).val(),
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/setBulkOrderReqIssueProcess',
        type: 'POST',
        data: formData,
        success: function ( resp )
        {
            // console.log(resp);
            if ( resp.status == 0 )
            {
                swal( "Alert!", "opps Error", "error" ).then( function ( eyz )
                {
                    if ( eyz.value )
                    {
                        //location.reload();
                    }
                } );
            } else
            {
                swal( "Issue Bulk Order!", "Successfully Submitted.", "success" ).then( function ( eyz )
                {
                    if ( eyz.value )
                    {
                        location.reload();
                    }
                } );
            }


        },
        dataType: 'json'
    } );


} )

//viewOrderPaymentAccount
function viewOrderPaymentAccount( form_id )
{

    var formData = {
        'form_id': form_id,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/getOrderPaymentAccountDetails',
        type: 'POST',
        data: formData,
        success: function ( res )
        {

            $( '.viewPaymentAccount' ).html( res );
            $( '#m_modal_viewPaymentAccount' ).modal( 'show' );

        }
    } );
    //ajax


    //$('#txtMessageNoteReponse textarea').val("4354 ");

}

//viewOrderPaymentAccount


// viewOrderDataAccessList
function viewOrderDataAccessList( rowid )
{


    $( '#QUERY_IDB' ).val( rowid );
    //$('#txtMessageNoteReponse textarea').val("4354 ");
    $( 'textarea#txtMessageNoteReponse' ).val( "" );
    $( '#m_modal_orderAddNotesModelPrint' ).modal( 'show' );
}

// viewOrderDataAccessList


function addToPlanQTY( form_id )
{
    var boPid = '#BOPLAN' + form_id + 'AJ';

    //table.row(boPid).remove().draw( false );
    var txtPlanID = $( '#txtPlanID' ).val();




    var plan_qty = $( boPid ).val();


    if ( plan_qty == "" || plan_qty <= 0 )
    {
        toasterOptions();
        toastr.error( 'Invalid Plan Qty ', 'Planned Quantity' );
        return false;
    }
    // return false;
    var formData = {
        'recordID': form_id,
        'plan_qty': plan_qty,
        'txtPlanID': txtPlanID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/savePlanDay3QTY',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {
                //reload OpAllotedArea
                $( '#OpAllotedArea' ).html( 'Welcome' );
                //reload OpAllotedArea
                $( boPid ).parent().parent().remove();

                toasterOptions();
                toastr.success( 'Added Successfully ', 'Planned Quantity' );

                //reinitialise datatable 
                $( "#m_table_OPHealthPlan3" ).dataTable().fnDestroy();
                var txtPlanID = $( '#txtPlanID' ).val();
                var mallotedQTy = 0;
                a = $( "#m_table_OPHealthPlan3" ).DataTable( {
                    responsive: !0,
                    dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    lengthMenu: [ 5, 10, 25, 50 ],
                    pageLength: 10,
                    language: {
                        lengthMenu: "Display _MENU_"
                    },
                    searchDelay: 500,
                    processing: !0,
                    serverSide: !0,
                    ajax: {
                        url: BASE_URL + '/getPlanedOrderDataDay2',
                        type: "POST",
                        data: {
                            columnsDef: [
                                "RecordID",
                                "order_id",
                                "form_id",
                                "req_qty",
                                "manhour_req",
                                "alloted_hours",
                                "manhour_alloted",
                                "plan_qty",
                                "h_operation",
                                "order_arr",
                            ],
                            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                            'txtPlanID': txtPlanID

                        }
                    },
                    columns: [ {
                        data: "RecordID"
                    }, {
                        data: "order_id"
                    }, {
                        data: "req_qty"
                    }, {
                        data: "manhour_req"
                    }, {
                        data: "alloted_hours"
                    }, {
                        data: "manhour_alloted"
                    }, {
                        data: "plan_qty"
                    },

                    ],

                    columnDefs: [ {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: 1,
                        title: "Select Order",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            var opclass = 'ajOpclassOrder' + e.RecordID + 'optOrderID';

                            var HTML = '';
                            $.each( e.order_arr, function ( index, value )
                            {
                                HTML += `<option value="${ value.form_id }" >${ value.order_id }</option>`;

                            } );

                            return `<div class="form-group m-form__group">                      
                                        <select class="form-control m-input ajOperationOrder" id="${ opclass }" style="width:150px">
                                           ${ HTML }                       
                                        </select>
                                    </div>`;

                        }
                    },
                    {
                        targets: 2,
                        title: "Select Operation",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            var opclass = 'ajOpclass' + e.RecordID + 'optName';

                            var HTML = '';
                            $.each( e.h_operation, function ( index, value )
                            {
                                // console.log();
                                HTML += `<option value="${ value.id }">${ value.operation_name }-${ value.operation_product }</option>`;

                                // Will stop running after "three"
                                //return (value !== 'three');
                            } );



                            return `<div class="form-group m-form__group">                      
                       <select class="form-control m-input ajOperation " id="${ opclass }" style="width:150px">
                          ${ HTML }                       
                       </select>
                   </div>`;

                        }
                    },
                    {
                        targets: 3,
                        title: "Req. QTY",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {


                            // return e.req_qty;
                            var cellIDMHR = 'QTYREQ' + e.RecordID;

                            return `<span id="${ cellIDMHR }"></span>`;

                        }
                    },
                    {
                        targets: 4,
                        title: "Man Power Req.",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {

                            var cellIDMHR = 'MHR' + e.RecordID;
                            var cellIDOPH = 'OPH' + e.RecordID;

                            return `<span id="${ cellIDMHR }"></span>
                        <input type="hidden" id="${ cellIDOPH }">
                        `;

                        }
                    },
                    {
                        targets: 5,
                        title: "Manpower Alloted",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            var cellIDMHR = 'MANHRSAlloted' + e.RecordID;

                            return `<div class="form-group m-form__group">
                      
                       <input type="text" class="form-control m-input m-input--square ajManHourAlloted" id="${ cellIDMHR }" placeholder="" color: #000000;
                       border: 1px solid #c1c1c1; background-color:#035496;>
                        </div>`;

                        }
                    },
                    {
                        targets: 6,
                        title: "Hours Alloted",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            //return e.alloted_hours;
                            var cellIDMHR = 'MANHourSAlloted' + e.RecordID;

                            return `<div class="form-group m-form__group">
                      
                       <input type="text" class="form-control m-input m-input--square ajHourAlloted" id="${ cellIDMHR }" placeholder="" color: #000000;
                       border: 1px solid #c1c1c1;>
                        </div>`;


                        }
                    },

                    {
                        targets: 7,
                        title: "Achievable Quantity",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            //return e.plan_qty; 
                            var cellIDMHR = 'ACHIVQTY' + e.RecordID;

                            return `<span id="${ cellIDMHR }"></span>`;
                        }
                    },
                    {
                        targets: 8,
                        title: "Manhours Req.",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            //return e.plan_qty; 
                            var cellIDMHR = 'MANHRSREQ' + e.RecordID;

                            return `<span id="${ cellIDMHR }"></span>`;
                        }
                    },
                    {
                        targets: 9,
                        title: "Action",
                        orderable: !1,
                        width: 200,
                        render: function ( a, t, e, n )
                        {
                            var saveID = "SaveID" + e.RecordID;

                            return `<div id="${ saveID }"  onclick="saveRowDataOperation(${ e.RecordID })" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide">
                        <span>
                            <i class="la la-plus"></i>
                            <span>Save Now</span>
                        </span>
                    </div>`
                        }
                    },

                    ]
                } ).on( "change", ".ajOperation", function ()
                {
                    var optionId = "#" + $( this ).attr( 'id' ) + " option:selected";
                    operionIDVal = $( optionId ).val();

                    var myStr = $( this ).attr( 'id' );

                    var subStr = myStr.match( "ajOpclass(.*)optName" );

                    var cellIDMHR = '#MHR' + subStr[ 1 ];
                    var cellIDOPH = '#OPH' + subStr[ 1 ];

                    $( cellIDMHR ).html( `<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>` );



                    //code to get man power required
                    var formData = {
                        'operionIDVal': operionIDVal,
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    };
                    $.ajax( {
                        url: BASE_URL + '/getOperatonsInfo',
                        type: 'POST',
                        data: formData,
                        success: function ( res )
                        {
                            //console.log(res);
                            var oph = parseInt( res.oph )
                            $( cellIDMHR ).html( res.operation_man_power );
                            $( cellIDOPH ).val( oph );

                        },
                        dataType: 'json'
                    } );


                    //code to get man power required               

                } ).on( "click", ".ajOperationOrder", function ()
                {

                    var optionId = "#" + $( this ).attr( 'id' ) + " option:selected";
                    operionIDVal = $( optionId ).val();
                    var myStr = $( this ).attr( 'id' );
                    var subStr = myStr.match( "ajOpclassOrder(.*)optOrderID" );
                    var QTYREQ = '#QTYREQ' + subStr[ 1 ];
                    $( QTYREQ ).html( `<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>` );

                    // var cellIDMHRA='#ACHIVQTY'+subStr[1]; 
                    //  $(cellIDMHRA).html(`<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>`);


                    //code to get req req qty and achive value required          
                    //plan id and form id 
                    var formData = {
                        'form_id': operionIDVal,
                        'plan_id': $( '#txtPlanID' ).val(),
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    };
                    $.ajax( {
                        url: BASE_URL + '/getOperatonsPlanOrderDetails',
                        type: 'POST',
                        data: formData,
                        success: function ( res )
                        {
                            console.log( res );
                            //$(cellIDMHR).html(res.total_qty);   
                            $( QTYREQ ).html( res.plan_qty );

                        },
                        dataType: 'json'
                    } );

                    //code to get req req qty and achive value required   

                } ).on( "change", ".ajOperationOrder", function ()
                {

                    var optionId = "#" + $( this ).attr( 'id' ) + " option:selected";
                    operionIDVal = $( optionId ).val();
                    var myStr = $( this ).attr( 'id' );
                    var subStr = myStr.match( "ajOpclassOrder(.*)optOrderID" );
                    var QTYREQ = '#QTYREQ' + subStr[ 1 ];
                    $( QTYREQ ).html( `<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>` );

                    // var cellIDMHRA='#ACHIVQTY'+subStr[1]; 
                    //  $(cellIDMHRA).html(`<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>`);


                    //code to get req req qty and achive value required          
                    //plan id and form id 
                    var formData = {
                        'form_id': operionIDVal,
                        'plan_id': $( '#txtPlanID' ).val(),
                        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    };
                    $.ajax( {
                        url: BASE_URL + '/getOperatonsPlanOrderDetails',
                        type: 'POST',
                        data: formData,
                        success: function ( res )
                        {
                            console.log( res );
                            //$(cellIDMHR).html(res.total_qty);   
                            $( QTYREQ ).html( res.plan_qty );

                        },
                        dataType: 'json'
                    } );

                    //code to get req req qty and achive value required   

                } ).on( "focusout", ".ajManHourAlloted", function ()
                {

                    var optionId = "#" + $( this ).attr( 'id' );
                    var one = $( optionId ).val();
                    var txtManPowerExpected = $( "input[name=txtManPowerExpected]" ).val();
                    var txtAjVal = $( "input[name=txtAjVal]" ).val();
                    mallotedQTy = parseInt( mallotedQTy ) + parseInt( one );


                    if ( parseInt( txtAjVal ) > parseInt( one ) )
                    {
                        //alert('OK');

                    } else
                    {
                        // alert('Nope! invalid');
                        //return false;
                    }
                    // $("input[name=txtAjVal]").val(parseInt(txtAjVal)-parseInt(one));    


                    var myStr = $( this ).attr( 'id' );
                    var subStr = myStr.match( "MANHRSAlloted(.*)" );
                    var cellIDMHR = '#MANHourSAlloted' + subStr[ 1 ];
                    var two = $( cellIDMHR ).val();
                    var total = parseInt( one ) * parseInt( two );
                    var ja = '#MANHRSREQ' + subStr[ 1 ];
                    $( ja ).html( total );


                    var CellODOPH = '#OPH' + subStr[ 1 ];
                    var ophVal = $( CellODOPH ).val();
                    var achiveQTY = ophVal * total;
                    var cellIDMHR = '#ACHIVQTY' + subStr[ 1 ];
                    $( cellIDMHR ).html( achiveQTY );

                    //MANHRSAlloted48

                } ).on( "focusout", ".ajHourAlloted", function ()
                {

                    var optionId = "#" + $( this ).attr( 'id' );
                    var one = $( optionId ).val();
                    var myStr = $( this ).attr( 'id' );
                    var subStr = myStr.match( "MANHourSAlloted(.*)" );
                    var cellIDMHR = '#MANHRSAlloted' + subStr[ 1 ];
                    var two = $( cellIDMHR ).val();
                    var total = parseInt( one ) * parseInt( two );
                    var ja = '#MANHRSREQ' + subStr[ 1 ];
                    $( ja ).html( total );

                    var CellODOPH = '#OPH' + subStr[ 1 ];
                    var ophVal = $( CellODOPH ).val();
                    var achiveQTY = ophVal * total;
                    var cellIDMHR = '#ACHIVQTY' + subStr[ 1 ];
                    $( cellIDMHR ).html( achiveQTY );

                    //MANHRSAlloted48

                } ),
                    $( "#m_search" ).on( "click", function ( t )
                    {
                        t.preventDefault();
                        var e = {};
                        $( ".m-input" ).each( function ()
                        {
                            var a = $( this ).data( "col-index" );
                            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                        } ), $.each( e, function ( t, e )
                        {
                            a.column( t ).search( e || "", !1, !1 )
                        } ), a.table().draw()
                    } ), $( "#m_reset" ).on( "click", function ( t )
                    {
                        t.preventDefault(), $( ".m-input" ).each( function ()
                        {
                            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                        } ), a.table().draw()
                    } ), $( "#m_datepicker" ).datepicker( {
                        todayHighlight: !0,
                        templates: {
                            leftArrow: '<i class="la la-angle-left"></i>',
                            rightArrow: '<i class="la la-angle-right"></i>'
                        }
                    } )

                //reinitialise datatable 

                return true;
            }


        }
    } );


}



//---------------OPlan 3 ---
var OPerationHealthPlan3 = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;




        }
    }
}();
jQuery( document ).ready( function ()
{
    OPerationHealthPlan3.init()

} );

//---------------OPlan 3---



function saveRowDataOperation( rowid )
{
    //alert(rowid);

    // var opclass='.ajOpclass'+rowid+'optName  option:selected';
    // var hotel = $(opclass).val();

    // var cellIDMHR='#MHR'+rowid; 

    // $(cellIDMHR).html(55);




    var plan_id = $( '#txtPlanID' ).val();
    var opclassOrder = '#ajOpclassOrder' + rowid + 'optOrderID  option:selected';
    var form_id = $( opclassOrder ).val();

    var opclass = '#ajOpclass' + rowid + 'optName  option:selected';
    var operation_id = $( opclass ).val();

    var manHrsAlloted = $( '#MANHRSAlloted' + rowid ).val();
    var HrsAlloted = $( '#MANHourSAlloted' + rowid ).val();
    var QTYREQ = $( '#QTYREQ' + rowid ).html();
    var MHR = $( '#MHR' + rowid ).html();
    var ACHIVQTY = $( '#ACHIVQTY' + rowid ).html();
    var MANHRSREQ = $( '#MANHRSREQ' + rowid ).html();



    if ( QTYREQ == "" )
    {
        toasterOptions();
        toastr.error( 'Please Select Order', 'Operation Health' );
        return false;
    }
    if ( MHR == "" )
    {
        toasterOptions();
        toastr.error( 'Please Select Operation', 'Operation Health' );
        return false;
    }
    if ( manHrsAlloted == "" )
    {
        toasterOptions();
        toastr.error( 'Enter Manpower Alloted', 'Operation Health' );
        return false;
    }
    if ( HrsAlloted == "" )
    {
        toasterOptions();
        toastr.error( 'Enter Hours Alloted', 'Operation Health' );
        return false;
    }

    if ( HrsAlloted == "" )
    {
        toasterOptions();
        toastr.error( 'Enter Hours Alloted', 'Operation Health' );
        return false;
    }
    if ( ACHIVQTY == "" )
    {
        toasterOptions();
        toastr.error( 'Invalid Input', 'Operation Health' );
        return false;
    }


    //save data to plan4
    var formData = {
        'form_id': form_id,
        'plan_id': $( '#txtPlanID' ).val(),
        'operation_id': operation_id,
        'manHrsAlloted': manHrsAlloted,
        'HrsAlloted': HrsAlloted,
        'QTYREQ': QTYREQ,
        'MHR': MHR,
        'ACHIVQTY': ACHIVQTY,
        'MANHRSREQ': MANHRSREQ,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
        url: BASE_URL + '/save_OPHPlan_Day4',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            if ( res.status )
            {

                var SaveID = '#SaveID' + rowid;
                $( SaveID ).css( 'pointer-events', 'none' );
                $( SaveID ).css( 'background', '#ccc' );
                $( SaveID ).css( 'border', '1px solid #ccc' );
                toasterOptions();
                toastr.success( 'Added Succefully', 'Operation Health' );
                return false;
            }
        },
        dataType: 'json'
    } );


    //save data to plan4
}




var DatatablesSearchOptionsAdvancedSearchOPL_VIEW = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_OperationHealthPlanListView" ).DataTable( {
                responsive: !0,
                //dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50 ],
                pageLength: 10,
                dom: 'Bfrtip',
                keys: true,
                rowReorder: true,
                buttons: [

                    { extend: 'excelHtml5', footer: true },

                    { extend: 'pdfHtml5', footer: true }
                ],
                language: {
                    lengthMenu: "Display _MENU_"
                },
                footerCallback: function ( t, e, n, a, r )
                {
                    var o = this.api();

                    $( o.column( 1 ).footer() ).html( '<stong></strong>' )

                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getOHPlanList',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "avchiQTY", "manpower_expected", "planid", "plan_date", "plan_type", "manhours", "created_on", "tot_man_hours", "shift_hour", "created_by", "status", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                }, {
                    data: "planid"
                }, {
                    data: "plan_date"
                }, {
                    data: "plan_type"
                }, {
                    data: "manpower_expected"
                }, {
                    data: "manhours"
                },
                {
                    data: "avchiQTY"
                },
                {
                    data: "created_by"
                },
                {
                    data: "Action"
                },
                ],

                columnDefs: [ {
                    targets: [ 0, 1 ],
                    visible: !1
                }, {
                    targets: -1,
                    title: "Actions",
                    width: 110,
                    orderable: !1,
                    render: function ( a, t, e, n )
                    {

                        var viewPrintPlan = BASE_URL + '/plan-view-print/' + e.planid;
                        var addPlanAchive = BASE_URL + '/add-plan-achieve/' + e.planid;
                        var addPlanReport = BASE_URL + '/add-view-report/' + e.planid;


                        return `<a href="${ viewPrintPlan }" title="View and Print Details" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only">
                        <i class="fa flaticon-calendar-1"></i>
                    </a> <a href="${ addPlanAchive }" title="Add Achievement" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
                    <i class="fa flaticon-plus"></i>
                </a> <a href="${ addPlanReport }" title="View Achivement Report" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">
                    <i class="fa flaticon-book"></i>
                </a>
                ` ;
                    }
                },
                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )




        }
    }
}();
jQuery( document ).ready( function ()
{
    DatatablesSearchOptionsAdvancedSearchOPL_VIEW.init();
} );




var DatatablesDataSourceHtmlPlanView = {
    init: function ()
    {
        $( "#m_table_PlanViewData" ).DataTable( {


        } )
    }
};
jQuery( document ).ready( function ()
{
    DatatablesDataSourceHtmlPlanView.init();
} );

//getting order

function purchaseArtWorkVal( rowID )
{
    $( "#m_table_QCFORMPurchaseList" ).dataTable().fnDestroy();
    var purchaseFlag = $( '#txtPurchaseFlag' ).val();



    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node )
                {
                    // Strip $ from salary column to make it numeric
                    //console.log(data);
                    if ( column === 9 )
                    {
                        //return  row;                   
                        return '';
                    } else
                    {

                        if ( column === 7 )
                        {
                            var myStr = data;
                            var subStr = myStr.match( 'wide">(.*)</' );
                            return subStr[ 1 ]
                        }
                        return data;
                    }

                }
            }
        }
    };



    var a;
    a = $( "#m_table_QCFORMPurchaseList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        ordering: false,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ],
        lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
        pageLength: 10,
        ajax: {

            url: BASE_URL + '/getPurchaseListQCFROMArtWork',
            type: "POST",
            data: {
                columnsDef: [ "RecordID", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                '_days_count': $( '#txtNumberofdays' ).val(),
                'rowID': rowID,
                'purchaseFlag': purchaseFlag
            }
        },
        columns: [
            {
                data: "RecordID"
            },
            {
                data: "item_name"
            },
            {
                data: "order_id"
            },
            {
                data: "brand_name"
            },
            {
                data: "order_item_name"
            },
            {
                data: "category"
            },
            {
                data: "qty"
            },

            {
                data: "status"
            },
            {
                data: "order_statge"
            },

            {
                data: "Actions"
            }
        ],
        //pack_img

        columnDefs: [ {
            targets: [ 0 ],
            visible: !1
        }, {
            targets: 2,
            title: "Order ID",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                return `${ e.order_id }`;

            }
        },
        {
            targets: 7,
            render: function ( a, t, e, n )
            {
                var i = {
                    1: {
                        title: "NOT STARTED",
                        class: "m-badge--secondary"
                    },
                    2: {
                        title: "DESIGN AWAITED",
                        class: " m-badge--info"
                    },
                    3: {
                        title: "WAITING FOR QUOTATION",
                        class: " m-badge--primary"
                    },
                    4: {
                        title: "SAMPLE AWAITED",
                        class: " m-badge--danger"
                    },
                    5: {
                        title: "PAYMENT AWAITED",
                        class: " m-badge--warning"
                    },
                    6: {
                        title: "ORDERED",
                        class: " m-badge--metal"
                    },
                    7: {
                        title: "RECEIVED /IN STOCK",
                        class: " m-badge--success"
                    },
                    8: {
                        title: "AWAITED FROM CLIENT",
                        class: " m-badge--brand"
                    }
                };
                return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
            }
        },

        {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                //console.log(e);
                return `<span class="dropdown"><a href="#" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                     <i class="la la-ellipsis-h"></i></a>
                     <div class="dropdown-menu dropdown-menu-right">                          
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },2)"> ${ e.status == 2 ? '<i class="fa fa-hand-point-right faa-horizontal animated" style="color:#008080"></i>' : '' } DESIGN AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },3)"> ${ e.status == 3 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } WAITING FOR QUOTATION</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },4)"> ${ e.status == 4 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } SAMPLE AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },5)"> ${ e.status == 5 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' }  PAYMENT AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },6)"> ${ e.status == 6 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } ORDERED </a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },7)"> ${ e.status == 7 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } RECEIVED /IN STOCK</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },8)"> ${ e.status == 8 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } AWAITED FROM CLIENT</a>
                     </div>
                     </span> <a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-image"></i>
                   </a>`;


            }
        },

        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } );



}
//getting order



function purchaseArtWorKAllOther( rowID )
{
    $( "#m_table_QCFORMPurchaseList" ).dataTable().fnDestroy();

    var purchaseFlag = $( '#txtPurchaseFlag' ).val();


    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node )
                {
                    // Strip $ from salary column to make it numeric
                    //console.log(data);
                    if ( column === 9 )
                    {
                        //return  row;

                        return '';



                    } else
                    {



                        if ( column === 7 )
                        {
                            var myStr = data;

                            var subStr = myStr.match( 'wide">(.*)</' );

                            return subStr[ 1 ]
                        }

                        // 

                        return data;
                    }

                }
            }
        }
    };



    var a;
    a = $( "#m_table_QCFORMPurchaseList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        language: {
            lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        ordering: false,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ],
        lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
        pageLength: 10,
        ajax: {

            url: BASE_URL + '/getPurchaseListQCFROMArtWorkAllOther',
            type: "POST",
            data: {
                columnsDef: [ "RecordID", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                '_days_count': $( '#txtNumberofdays' ).val(),
                'rowID': rowID,
                'purchaseFlag': purchaseFlag
            }
        },
        columns: [
            {
                data: "RecordID"
            },
            {
                data: "item_name"
            },
            {
                data: "order_id"
            },
            {
                data: "brand_name"
            },
            {
                data: "order_item_name"
            },
            {
                data: "category"
            },
            {
                data: "qty"
            },

            {
                data: "status"
            },
            {
                data: "order_statge"
            },

            {
                data: "Actions"
            }
        ],
        //pack_img

        columnDefs: [ {
            targets: [ 0 ],
            visible: !1
        }, {
            targets: 2,
            title: "Order ID",
            orderable: !1,
            render: function ( a, t, e, n )
            {

                return `${ e.order_id }`;


            }
        },
        {
            targets: 7,
            render: function ( a, t, e, n )
            {
                var i = {
                    1: {
                        title: "NOT STARTED",
                        class: "m-badge--secondary"
                    },
                    2: {
                        title: "DESIGN AWAITED",
                        class: " m-badge--info"
                    },
                    3: {
                        title: "WAITING FOR QUOTATION",
                        class: " m-badge--primary"
                    },
                    4: {
                        title: "SAMPLE AWAITED",
                        class: " m-badge--danger"
                    },
                    5: {
                        title: "PAYMENT AWAITED",
                        class: " m-badge--warning"
                    },
                    6: {
                        title: "ORDERED",
                        class: " m-badge--metal"
                    },
                    7: {
                        title: "RECEIVED /IN STOCK",
                        class: " m-badge--success"
                    },
                    8: {
                        title: "AWAITED FROM CLIENT",
                        class: " m-badge--brand"
                    }
                };
                return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
            }
        },

        {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
                //console.log(e);
                return `<span class="dropdown"><a href="#" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                     <i class="la la-ellipsis-h"></i></a>
                     <div class="dropdown-menu dropdown-menu-right">                          
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },2)"> ${ e.status == 2 ? '<i class="fa fa-hand-point-right faa-horizontal animated" style="color:#008080"></i>' : '' } DESIGN AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },3)"> ${ e.status == 3 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } WAITING FOR QUOTATION</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },4)"> ${ e.status == 4 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } SAMPLE AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },5)"> ${ e.status == 5 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' }  PAYMENT AWAITED</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },6)"> ${ e.status == 6 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } ORDERED </a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },7)"> ${ e.status == 7 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } RECEIVED /IN STOCK</a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStage(${ e.RecordID },8)"> ${ e.status == 8 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } AWAITED FROM CLIENT</a>
                     </div>
                     </span> <a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-image"></i>
                   </a>`;


            }
        },

        ]
    } ), $( "#m_search" ).on( "click", function ( t )
    {
        t.preventDefault();
        var e = {};
        $( ".m-input" ).each( function ()
        {
            var a = $( this ).data( "col-index" );
            e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
            a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_reset" ).on( "click", function ( t )
    {
        t.preventDefault(), $( ".m-input" ).each( function ()
        {
            $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
        } ), a.table().draw()
    } ), $( "#m_datepicker" ).datepicker( {
        todayHighlight: !0,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    } );



}
//getting order
$( '.blink' ).hide();
$( '.ajviewData' ).focusout( function ()
{

    var input_name = $( this ).attr( 'name' );
    var res = input_name.split( '#AJ' );
    var formID = res[ 1 ];
    var inputVal = $( this ).val();
    var input_db_name = res[ 0 ];
    var operation_id = $( '#operation_idAJ' + formID ).val();
    var plan_id = $( '#txtPlanID_Achivement' ).val();

    // ajax call
    var formData = {
        'formID': formID,
        'plan_id': plan_id,
        'inputVal': inputVal,
        'operation_id': operation_id,
        'input_db_name': input_db_name,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/savePlanAchieveData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            $( '.blink' ).fadeOut( 500 );
            $( '.blink' ).fadeIn( 500 );
            setTimeout( function ()
            {

                $( '.blink' ).fadeOut( '500' );

            }, 800 );



        }
    } );

    // ajax call



} );


$( '.ajviewData' ).keyup( function ()
{

    var input_name = $( this ).attr( 'name' );
    var res = input_name.split( '#AJ' );
    var formID = res[ 1 ];
    var inputVal = $( this ).val();
    var input_db_name = res[ 0 ];
    var operation_id = $( '#operation_idAJ' + formID ).val();
    var plan_id = $( '#txtPlanID_Achivement' ).val();

    // ajax call
    var formData = {
        'formID': formID,
        'plan_id': plan_id,
        'inputVal': inputVal,
        'operation_id': operation_id,
        'input_db_name': input_db_name,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/savePlanAchieveData',
        type: 'POST',
        data: formData,
        success: function ( res )
        {




        }
    } );

    // ajax call



} );




//add emp wizard 
var WizardDemoAddEmp = function ()
{
    $( "#m_wizardA" );
    var e, r, i = $( "#m_formA" );
    return {
        init: function ()
        {
            var n;
            $( "#m_wizardA" ), i = $( "#m_formA" ), ( r = new mWizard( "m_wizardA", {
                startStep: 1
            } ) ).on( "beforeNext", function ( r )
            {
                !0 !== e.form() && r.stop()
            } ), r.on( "change", function ( e )
            {
                mUtil.scrollTop()
            } ), r.on( "change", function ( e )
            {
                1 === e.getStep()
            } ), e = i.validate( {
                ignore: ":hidden",
                rules: {
                    name: {
                        required: !0
                    },
                    email: {
                        required: !0,
                        email: !0
                    },
                    phone: {
                        required: !0,

                    },
                    address1: {
                        required: !0
                    },
                    city: {
                        required: !0
                    },
                    state: {
                        required: !0
                    },
                    city: {
                        required: !0
                    },
                    country: {
                        required: !0
                    },
                    birth_date: {
                        required: !0,

                    },
                    pincode: {
                        required: !0,
                        minlength: 6
                    },

                },
                messages: {
                    "account_communication[]": {
                        required: "You must select at least one communication option"
                    },
                    accept: {
                        required: "You must accept the Terms and Conditions agreement!"
                    }
                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTop(), swal( {
                        title: "",
                        text: "Please fill all required input",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    } )
                },
                submitHandler: function ( e ) { }
            } ), ( n = i.find( '[data-wizard-action="submit"]' ) ).on( "click", function ( r )
            {

                r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
                    success: function ()
                    {
                        mApp.unprogress( n ), swal( {
                            title: "",
                            text: "The employee has been successfully submitted!",
                            type: "success",
                            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        } )

                        setTimeout( function ()
                        {
                            //window.location.href = BASE_URL+'/orders'
                            location.reload( 1 );


                        }, 900 );

                    }
                } ) )
            } )
        }
    }
}();
jQuery( document ).ready( function ()
{
    WizardDemoAddEmp.init()
} );
//add emp wizard 





var BO_KPILISTHistory = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {


            function format( d )
            {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Full name:</td>' +
                    '<td>' + d.name + '</td>' +
                    '</tr>' +

                    '<tr>' +
                    '<td>Extra info:</td>' +
                    '<td>And any further details here (images etc)...</td>' +
                    '</tr>' +
                    '</table>';
            }


            var a;
            a = $( "#m_table_KPIHistroyLIST" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getKPIDataReportHistory',
                    type: "POST",
                    data: {
                        columnsDef: [ "id", "kpi_date", "kpi_month", "kpi_today", "kpi_remark", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "id"
                },

                {
                    data: "kpi_date"
                },
                {
                    data: "kpi_month"
                },
                {
                    data: "kpi_today"
                },

                {
                    data: "kpi_remark"
                },
                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var view_kpi_histroy = BASE_URL + '/kpi-details-history';

                            return `<a href="javascript::void(0)" onclick="viewKIPDetail(${ e.id });" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                        <span>
                            <i class="fa flaticon-file-1"></i>
                            <span>View KIP Details</span>
                        </span>
                    </a>`;


                        }
                    },




                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();


var BO_KPILISTHistoryEMPLIST = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {

            var empID = $( '#txtEMPID' ).val();

            function format( d )
            {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Full name:</td>' +
                    '<td>' + d.name + '</td>' +
                    '</tr>' +

                    '<tr>' +
                    '<td>Extra info:</td>' +
                    '<td>And any further details here (images etc)...</td>' +
                    '</tr>' +
                    '</table>';
            }


            var a;
            a = $( "#m_table_KPIHistroyLISTEMPLIST" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/kpiDetailHistory_all',
                    type: "POST",
                    data: {
                        columnsDef: [ "id", "kpi_date", "kpi_month", "kpi_today", "kpi_remark", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                        empID: empID
                    }
                },
                columns: [ {
                    data: "id"
                },

                {
                    data: "kpi_date"
                },
                {
                    data: "kpi_month"
                },
                {
                    data: "kpi_today"
                },

                {
                    data: "kpi_remark"
                },
                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var view_kpi_histroy = BASE_URL + '/kpi-details-history';

                            return `<a href="javascript::void(0)" onclick="viewKIPDetail(${ e.id });" class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                        <span>
                            <i class="fa flaticon-file-1"></i>
                            <span>View KIP Details</span>
                        </span>
                    </a>`;


                        }
                    },




                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

function viewKIPDetail( rowID )
{
    $( '.showKIPDetails' ).html( "" );

    var formData = {
        'rowID': rowID,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
        url: BASE_URL + '/getKIPDetailsByUserDay',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
            $( '.showKIPDetails' ).html( res );
        }
    } );

    $( '#m_modal_KPIDetailsShow' ).modal( 'show' );
}




// admin report 
var BO_KPILISTuserAdmin = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_KPILISTUserAdmin" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getEmpListData',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "user_status", "job_role", "user_id", "photo", "name", "email", "phone", "empID", "office_email", "department", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },

                {
                    data: "photo"
                },
                {
                    data: "name"
                },
                {
                    data: "job_role"
                },



                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            _UNIB_RIGHT = $( 'meta[name="UNIB"]' ).attr( 'content' );

                            if ( _UNIB_RIGHT != 'Admin' )
                            {
                                var view_kpi_histroy = BASE_URL + '/kpi-details-history';
                            } else
                            {
                                var view_kpi_histroy = BASE_URL + '/kpi-details-history-all/' + e.user_id;
                            }


                            return `
                    
                                                        <a href="${ view_kpi_histroy }"   class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
                                                        <span>
                                                            <i class="fa flaticon-time-3"></i>
                                                            <span>View History <span class="m-badge m-badge--danger">5</span></span>
                                                        </span>
                                                    </a>
                    `;
                            // return `<span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                            // <i class="la la-ellipsis-h"></i>
                            // </a><div class="dropdown-menu dropdown-menu-right">
                            // <a class="dropdown-item" href="${view_more}"><i class="la la-trash"></i> View</a>                    

                            // </div></span>
                            // <a href="javascript::void(0)" onclick="deleteEMP(${e.RecordID})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                            //  <i class="la la-trash"></i> </a>`;

                        }
                    },
                    {
                        targets: 1,
                        title: "Photo",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {



                            return `<a href="javascript::void(0)"  class="m-nav__link m-dropdown__toggle ajproview" data-name="${ e.name }" data-phone="${ e.phone }"   data-photo="${ e.photo }" id="${ e.RecordID }">
                            <span class="m-topbar__userpic">
                                <img src="${ e.photo }" style="width: 41px;
                                height: 46px;" class="m--img-rounded m--marginless" alt="">
                            </span>
                            <span class="m-topbar__username m--hide">Nick</span>
                        </a>`;
                        }
                    },




                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

// admin report 



var BO_KPILISTuser = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_KPILISTUser" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getKPIData',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "user_name", "user_ID", "kpi_role", "kpi_department", "kpi_details", "status", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },

                {
                    data: "user_name"
                },
                {
                    data: "status"
                },

                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            _UNIB_RIGHT = $( 'meta[name="UNIB"]' ).attr( 'content' );

                            if ( _UNIB_RIGHT != 'Admin' )
                            {
                                var view_kpi_histroy = BASE_URL + '/kpi-details-history';
                            } else
                            {
                                var view_kpi_histroy = BASE_URL + '/kpi-details-history-all/' + e.user_ID;
                            }


                            return `<a href="javascript::void(0)" onclick="submit_dailyWorkReport(${ e.user_ID },${ e.kpi_role })"  class="btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
                        <span>
                            <i class="fa flaticon-list-3"></i>
                            <span>Submit Report</span>
                        </span>
                    </a>
                    <a href="javascript::void(0)"  class="btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
															<span>
																<i class="fa flaticon-time-3"></i>
																<span>View Details</span>
															</span>
                                                        </a>
                                                        <a href="${ view_kpi_histroy }"   class="btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
                                                        <span>
                                                            <i class="fa flaticon-time-3"></i>
                                                            <span>View History</span>
                                                        </span>
                                                    </a>
                    `;
                            // return `<span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                            // <i class="la la-ellipsis-h"></i>
                            // </a><div class="dropdown-menu dropdown-menu-right">
                            // <a class="dropdown-item" href="${view_more}"><i class="la la-trash"></i> View</a>                    

                            // </div></span>
                            // <a href="javascript::void(0)" onclick="deleteEMP(${e.RecordID})" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                            //  <i class="la la-trash"></i> </a>`;

                        }
                    },
                    {
                        targets: 2,
                        render: function ( a, t, e, n )
                        {
                            var i = {
                                1: {
                                    title: "Active",
                                    class: "m-badge--brand"
                                },


                            };
                            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                        }
                    },



                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();


//submit_dailyWorkReport
function submit_dailyWorkReport( kpi_userid, kpi_job_role )
{
    console.log( kpi_userid );
    console.log( kpi_job_role );


    $( '#m_modal_dailyReportSubmit' ).modal( 'show' );


}
//submit_dailyWorkReport





var BO_KPILIST = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_KPILIST" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getKPIData',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "user_name", "kpi_role", "kpi_department", "kpi_details", "status", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },

                //  
                {
                    data: "kpi_role"
                },

                {
                    data: "status"
                },

                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var view_more = BASE_URL + '/kpi-details/' + e.RecordID;


                            return `<span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-h"></i>
                        </a><div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="${ view_more }"><i class="la la-trash"></i> View</a>                    
                        
                        </div></span>
                        <a href="javascript::void(0)" onclick="deleteKPI(${ e.RecordID })" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                         <i class="la la-trash"></i> </a>`;

                        }
                    },
                    {
                        targets: 2,
                        render: function ( a, t, e, n )
                        {
                            var i = {
                                1: {
                                    title: "Active",
                                    class: "m-badge--brand"
                                },


                            };
                            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
                        }
                    },



                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();




//emplist
var BO_EMPLIST = function ()
{
    $.fn.dataTable.Api.register( "column().title()", function ()
    {
        return $( this.header() ).text().trim()
    } );
    return {
        init: function ()
        {
            var a;
            a = $( "#m_table_EMPLIST" ).DataTable( {
                responsive: !0,
                // dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                lengthMenu: [ 5, 10, 25, 50, 100, 500 ],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url: BASE_URL + '/getEmpListData',
                    type: "POST",
                    data: {
                        columnsDef: [ "RecordID", "user_status", "photo", "name", "email", "phone", "empID", "office_email", "department", "Actions" ],
                        _token: $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                },
                columns: [ {
                    data: "RecordID"
                },
                {
                    data: "empID"
                },
                {
                    data: "photo"
                },
                {
                    data: "name"
                }, {
                    data: "email"
                }, {
                    data: "phone"
                }, {
                    data: "office_email"
                }, {
                    data: "department"
                },
                {
                    data: "Actions"
                } ],

                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {
                            var view_more = BASE_URL + '/emp-view/' + e.RecordID;


                            return `<span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-h"></i>
                        </a><div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="${ view_more }"><i class="la la-trash"></i> View</a>                    
                        
                        </div></span>
                        <a href="javascript::void(0)" onclick="deleteEMP(${ e.RecordID })" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                         <i class="la la-trash"></i> </a>`;

                        }
                    },
                    {
                        targets: 2,
                        title: "Photo",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {



                            return `<a href="javascript::void(0)"  class="m-nav__link m-dropdown__toggle ajproview" data-name="${ e.name }"  data-phone="${ e.phone }"    data-photo="${ e.photo }"  id="${ e.RecordID }">
                            <span class="m-topbar__userpic">
                                <img src="${ e.photo }" style="width: 41px;
                                height: 46px;" class="m--img-rounded m--marginless" alt="">
                            </span>
                            <span class="m-topbar__username m--hide">Nick</span>
                        </a>`;
                        }
                    },
                    {
                        targets: 3,
                        title: "Name",
                        orderable: !1,
                        render: function ( a, t, e, n )
                        {

                            if ( e.user_status == 1 )
                            {
                                return `<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">${ e.name }</span>`;
                            } else
                            {
                                return e.name;
                            }


                        }
                    },

                ]
            } ), $( "#m_search" ).on( "click", function ( t )
            {
                t.preventDefault();
                var e = {};
                $( ".m-input" ).each( function ()
                {
                    var a = $( this ).data( "col-index" );
                    e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
                } ), $.each( e, function ( t, e )
                {
                    a.column( t ).search( e || "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_reset" ).on( "click", function ( t )
            {
                t.preventDefault(), $( ".m-input" ).each( function ()
                {
                    $( this ).val( "" ), a.column( $( this ).data( "col-index" ) ).search( "", !1, !1 )
                } ), a.table().draw()
            } ), $( "#m_datepicker" ).datepicker( {
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            } )
        }
    }
}();

jQuery( document ).ready( function ()
{
    BO_EMPLIST.init()
    BO_KPILIST.init()
    BO_KPILISTuser.init()
    BO_KPILISTuserAdmin.init()
    BO_KPILISTHistory.init()
    BO_KPILISTHistoryEMPLIST.init()



} );





//emplist
function deleteEMP( rowid )
{
    swal( {
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    } ).then( function ( ey )
    {
        if ( ey.value )
        {
            $.ajax( {
                url: BASE_URL + "/deleteEMP",
                type: 'POST',
                data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), emp_id: rowid },
                success: function ( resp )
                {
                    // console.log(resp);
                    if ( resp.status == 0 )
                    {
                        swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                //location.reload();
                            }
                        } );
                    } else
                    {
                        swal( "Deleted!", "Employee has been deleted.", "success" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                location.reload();
                            }
                        } );
                    }


                },
                dataType: 'json'
            } );

        }

    } )

}

//=================================
function deleteKPI( rowid )
{
    swal( {
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    } ).then( function ( ey )
    {
        if ( ey.value )
        {
            $.ajax( {
                url: BASE_URL + "/deleteKPI",
                type: 'POST',
                data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), emp_id: rowid },
                success: function ( resp )
                {
                    // console.log(resp);
                    if ( resp.status == 0 )
                    {
                        swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                //location.reload();
                            }
                        } );
                    } else
                    {
                        swal( "Deleted!", "KPI  has been deleted.", "success" ).then( function ( eyz )
                        {
                            if ( eyz.value )
                            {
                                location.reload();
                            }
                        } );
                    }


                },
                dataType: 'json'
            } );

        }

    } )

}

