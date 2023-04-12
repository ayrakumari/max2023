var DatatablesSearchOptionsAdvancedSearch = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_PurchaseRequestAlertList").DataTable({
                responsive: !0,
                
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url:BASE_URL+'/getPurchaseRequestAlert',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID", "order_id", "order_sub_id","item_code", "item_name", "qty", "req_on", "due_date", "req_by", "Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                },  {
                    data: "order_id"
                },{
                    data: "order_sub_id"
                },{
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                },  {
                    data: "req_on"
                },
                {
                    data: "due_date"
                },
                {
                    data: "req_by"
                },
                {
                    data: "Status"
                }, {
                    data: "Actions"
                }],
                initComplete: function() {
                    this.api().columns().every(function() {
                        switch (this.title()) {
                            case "Country":
                                this.data().unique().sort().each(function(a, t) {
                                    $('.m-input[data-col-index="2"]').append('<option value="' + a + '">' + a + "</option>")
                                });
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
                                this.data().unique().sort().each(function(t, e) {
                                    $('.m-input[data-col-index="6"]').append('<option value="' + t + '">' + a[t].title + "</option>")
                                });
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
                                }, this.data().unique().sort().each(function(t, e) {
                                    $('.m-input[data-col-index="7"]').append('<option value="' + t + '">' + a[t].title + "</option>")
                                })
                        }
                    })
                },
                columnDefs: [
                    {
                        "visible": false,
                        "targets": [0,8]
                    },{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                    }
                }, {
                    targets: 9,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Ordered",
                                class: "m-badge--info"
                            },
                            2: {
                                title: "Requested",
                                class: " m-badge--warning"
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
                        return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"
                    }
                }
            ]
            }), $("#m_search").on("click", function(t) {
                t.preventDefault();
                var e = {};
                $(".m-input").each(function() {
                    var a = $(this).data("col-index");
                    e[a] ? e[a] += "|" + $(this).val() : e[a] = $(this).val()
                }), $.each(e, function(t, e) {
                    a.column(t).search(e || "", !1, !1)
                }), a.table().draw()
            }), $("#m_reset").on("click", function(t) {
                t.preventDefault(), $(".m-input").each(function() {
                    $(this).val(""), a.column($(this).data("col-index")).search("", !1, !1)
                }), a.table().draw()
            }), $("#m_datepicker").datepicker({
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            })
        }
    }
}();



var DatatablePurchasedOrderedList= function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_PurchaseOrderdList").DataTable({
                responsive: !0,
                
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url:BASE_URL+'/getPurchasedOrderedlist',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID",  "pid",  "vendor_name","item_code", "item_name", "qty",  "due_date","created_at","Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                }, {
                    data: "pid"
                },{
                    data: "vendor_name"
                }, {
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                },  
                {
                    data: "due_date"
                }, 
                {
                    data: "created_at"
                }, 
                {
                    data: "Status"
                },                
                {
                    data: "Actions"
                }],
                
                columnDefs: [
                    {
                        "visible": false,
                        "targets": [0,9]
                    },{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        console.log(e.RecordID);
                    var order_nowURL=BASE_URL+'/purchase-order/'+e.RecordID;
                    
                        return '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                    }
                }, {
                    targets: 8,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Ordered",
                                class: "m-badge--accent"
                            },
                            2: {
                                title: "Received",
                                class: " m-badge--info"
                            },
                            3: {
                                title: "Pending",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "Cancel",
                                class: " m-badge--danger"
                            },
                            
                        };
                        return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"
                    }
                }, {
                    targets: 5,
                    render: function(a, t, e, n) {
                        var i = {
                            10: {
                                title: "Requested",
                                state: "info"
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
                        return void 0 === i[a] ? a : '<span class="m-badge m-badge--' + i[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + i[a].state + '">' + i[a].title + "</span>"
                    }
                }]
            }), $("#m_search").on("click", function(t) {
                t.preventDefault();
                var e = {};
                $(".m-input").each(function() {
                    var a = $(this).data("col-index");
                    e[a] ? e[a] += "|" + $(this).val() : e[a] = $(this).val()
                }), $.each(e, function(t, e) {
                    a.column(t).search(e || "", !1, !1)
                }), a.table().draw()
            }), $("#m_reset").on("click", function(t) {
                t.preventDefault(), $(".m-input").each(function() {
                    $(this).val(""), a.column($(this).data("col-index")).search("", !1, !1)
                }), a.table().draw()
            }), $("#m_datepicker").datepicker({
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            })
        }
    }
}();

//===============================================

var DatatablesRequestTotalList = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_PurchaseRequestTotalList").DataTable({
                responsive: !0,
                
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_"
                },
                searchDelay: 500,
                processing: !0,
                serverSide: !0,
                ajax: {
                    url:BASE_URL+'/getPurchaseRequestGroupTotal',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID",  "item_cat", "item_code", "item_name", "qty",  "due_date","Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                },  {
                    data: "item_cat"
                },{
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                },  
                {
                    data: "due_date"
                }, 
                {
                    data: "Status"
                },                
                {
                    data: "Actions"
                }],
                
                columnDefs: [
                    {
                        "visible": true,
                        "targets": 0
                    },{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        console.log(e.RecordID);
                    var order_nowURL=BASE_URL+'/purchase-order/'+e.item_code;

                    
                        return `<a href="${order_nowURL}" class="btn btn-brand m-btn btn-sm 	m-btn m-btn--icon">
                        <span>
                            <i class="fa flaticon-time-2"></i>
                            <span>Order Now</span>
                        </span>
                    </a>`;
                    }
                }, {
                    targets: 5,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Ordered",
                                class: "m-badge--Info"
                            },
                            2: {
                                title: "Requested",
                                class: " m-badge--warning"
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
                        return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"
                    }
                }, {
                    targets: 3,
                    render: function(a, t, e, n) {
                        var i = {
                            0: {
                                title: "Requested",
                                state: "info"
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
                        return void 0 === i[a] ? a : '<span class="m-badge m-badge--' + i[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + i[a].state + '">' + i[a].title + "</span>"
                    }
                }]
            }), $("#m_search").on("click", function(t) {
                t.preventDefault();
                var e = {};
                $(".m-input").each(function() {
                    var a = $(this).data("col-index");
                    e[a] ? e[a] += "|" + $(this).val() : e[a] = $(this).val()
                }), $.each(e, function(t, e) {
                    a.column(t).search(e || "", !1, !1)
                }), a.table().draw()
            }), $("#m_reset").on("click", function(t) {
                t.preventDefault(), $(".m-input").each(function() {
                    $(this).val(""), a.column($(this).data("col-index")).search("", !1, !1)
                }), a.table().draw()
            }), $("#m_datepicker").datepicker({
                todayHighlight: !0,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            })
        }
    }
}();


jQuery(document).ready(function() {
    DatatablesSearchOptionsAdvancedSearch.init();
    DatatablesRequestTotalList.init();
    DatatablePurchasedOrderedList.init();

});

var BootstrapMarkdown={init:function(){}};jQuery(document).ready(function(){BootstrapMarkdown.init()});



var e, r, i = $("#m_form_add_purchase_order");
e=i.validate({
                ignore: ":hidden",
                rules: {
                    item_code: {
                        required: !0
                    },
                    item_name: {
                        required: !0
                    },

                    qty: {
                        required: !0,
                    },
                },
                invalidHandler: function(e, r) {
                    mUtil.scrollTop(), swal({
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"

                    })
                },
                submitHandler: function(e) {}
            }), (n = i.find('[data-wizard-action="submit"]')).on("click", function(r) {
                r.preventDefault(), e.form() && (mApp.progress(n), i.ajaxSubmit({
                    success: function() {
                        mApp.unprogress(n), 
                        window.location.href = BASE_URL+'/purchased-orders-list'

                    }
                }))
            })

