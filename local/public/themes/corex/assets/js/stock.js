var DatatablesExtensionsRowgroup = {
    init: function() {
        $("#m_table_stockList").DataTable({
            responsive: !0,
            order: [
                [1, "desc"]
            ],
            // rowGroup: {
            //     dataSrc: 2
            // },
            columnDefs: [{
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function(a, e, t, n) {
                    return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                }
            }, {
                targets: 8,
                render: function(a, e, t, n) {
                    var s = {
                        1: {
                            title: "Pending",
                            class: "m-badge--brand"
                        },
                        2: {
                            title: "======",
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
                    return void 0 === s[a] ? a : '<span class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + "</span>"
                }
            }, {
                targets: 9,
                render: function(a, e, t, n) {
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
                    return void 0 === s[a] ? a : '<span class="m-badge m-badge--' + s[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[a].state + '">' + s[a].title + "</span>"
                }
            }]
        })
    }
};
jQuery(document).ready(function() {
    DatatablesExtensionsRowgroup.init()
});


//============m_table_RecievedOrders
var DatatablesRecievedOrdersList = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_RecievedOrders").DataTable({
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
                    url:BASE_URL+'/getRecievedOrders',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID","pid","vendor_name", "item_code", "item_name", "qty","rec_qty", "recieved_on", "recieved_by", "Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                }, 
                {
                    data: "pid"
                }, 
                {
                    data: "vendor_name"
                }, 
                {
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                },
                {
                    data: "rec_qty"
                }, {
                    data: "recieved_on"
                }, {
                    data: "recieved_by"
                },  {
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
                columnDefs: [{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                    }
                }, {
                    targets: 8,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Pending",
                                class: "m-badge--brand"
                            },
                            2: {
                                title: "Recieved ",
                                class: " m-badge--success"
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
                    targets: 7,
                    render: function(a, t, e, n) {
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


//============m_table_RecievedOrders

//============m_table_RecievedOrdersListNEW
var DatatablesRecievedOrdersListNew = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_RecievedOrdersListNEW").DataTable({
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
                    url:BASE_URL+'/getRecievedOrdersListNew',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID","pid","vendor_name", "item_code", "item_name", "qty","rec_qty", "recieved_on", "recieved_by", "Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                }, 
                {
                    data: "pid"
                }, 
                {
                    data: "vendor_name"
                }, 
                {
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                },
                {
                    data: "rec_qty"
                }, {
                    data: "recieved_on"
                }, {
                    data: "recieved_by"
                },  {
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
                columnDefs: [{
                    "visible": false,
                    "targets": [0]
                },{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        console.log();
                        var rec_URL=BASE_URL+'/recieved-orders/'+e.RecordID;

                        return `<a href="${rec_URL}" class="btn btn-brand m-btn btn-sm 	m-btn m-btn--icon">
                        <span>
                            
                            <span>Recieved</span>
                        </span>
                    </a>`
                    }
                }, {
                    targets: 9,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Pending",
                                class: "m-badge--brand"
                            },
                            2: {
                                title: "Recieved ",
                                class: " m-badge--success"
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
                    targets: 7,
                    render: function(a, t, e, n) {
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


//============m_table_RecievedOrdersListNEW



// requested reserved item list

var DatatablesStockRequestList = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_StockRequestList").DataTable({
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
                    url:BASE_URL+'/getRequestedItems',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID", "item_code", "item_name", "qty", "req_on", "due_date", "req_by", "Status", "Actions"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    data: "RecordID"
                }, {
                    data: "item_code"
                }, {
                    data: "item_name"
                }, {
                    data: "qty"
                }, {
                    data: "req_on"
                },  {
                    data: "req_by"
                }, {
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
                columnDefs: [{
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, t, e, n) {
                        //console.log(e.Status);
                        var html="";
                        if(e.Status==3){
                            html=``;
                        }else{
                            html=`<a href="javascript::void(0)"  onclick="itemIssueNow(${e.RecordID})" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                            <span>
                               
                                <span>Issue Now</span>
                            </span>
                        </a>`;
                        }
                        return html;
                    }
                }, {
                    targets: 6,
                    render: function(a, t, e, n) {
                        var i = {
                            1: {
                                title: "Pending",
                                class: "m-badge--info"
                            },
                            2: {
                                title: "Pending",
                                class: " m-badge--brand"
                            },
                            3: {
                                title: "Issued",
                                class: " m-badge--brand"
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
                }, ]
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
    DatatablesStockRequestList.init();
    DatatablesRecievedOrdersList.init();
    DatatablesRecievedOrdersListNew.init();

});

// requested reserved item list

function reservedItemsNow(rowid){
    var formData = {
        'rowid':rowid,       
        '_token':$('meta[name="csrf-token"]').attr('content') //need to find data and show and save entry to recifed and issue is to make 
      };
      $.ajax({
        url: BASE_URL+'/reservedNowItems',
        type: 'POST',
        data: formData,
        success: function(res) {
          console.log(res);
          location.reload();
         // window.location.href = BASE_URL+"/recieved-orders"
        }
      });

}

function itemIssueNow(rowid){
    var formData = {
        'rowid':rowid,       
        '_token':$('meta[name="csrf-token"]').attr('content') //need to find data and show and save entry to recifed and issue is to make 
      };
      $.ajax({
        url: BASE_URL+'/IssueNowItems',
        type: 'POST',
        data: formData,
        success: function(res) {
          console.log(res);
          
          location.reload();
          
         // window.location.href = BASE_URL+"/recieved-orders"
        }
      });

}




var DatatablesDataSourceAjaxServerStockEntry = {
    init: function() {
        $("#m_table_stock").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url:BASE_URL+'/getStocks',
                type: "POST",
                data: {
                    columnsDef: ["RecordID", "item_code", "item_cat", "item_name", "item_short_name",  "unit", "qty",  "Actions"],
                    '_token':$('meta[name="csrf-token"]').attr('content')
                }
            },

            columns: [{
                data: "RecordID"
            }, {
                data: "item_code"
            }, {
                data: "item_cat"
            }, {
                data: "item_name"
            }, {
                data: "item_short_name"
            }, {
                data: "unit"
            },{
                data: "qty"
            },{
                data: "Actions"
            } ],
            columnDefs: [{
                targets: -1,
                title: "Actions",
                orderable: !1,
                render: function(a, t, e, n) {
                    //console.log(e.Status);
                    var html="";
                    if(e.Status==3){
                        html=``;
                    }else{
                        html=`<a href="javascript::void()" onclick="itemDeleteStock(${e.RecordID})"  class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>`;
                    }
                    return html;
                }
            },
            ]
           
        })
    }
};
jQuery(document).ready(function() {
    DatatablesDataSourceAjaxServerStockEntry.init()
});


//itemDeleteStock
function itemDeleteStock(rowid){
    swal({
        title: "Are you sure?",
        text: "You won't be able to revert this Message!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes,Delete",
        cancelButtonText: "No, Cancel!",
        reverseButtons: !1
    }).then(function(ey) {
       if(ey.value){
         $.ajax({
              url:BASE_URL+"/delete.items",//delete item with stock enry 
              type: 'POST',
              data: {_token:$('meta[name="csrf-token"]').attr('content'),rowid:rowid},
              success: function (resp) {
                console.log(resp);
                if(resp.status==0){
                  swal("Deleted Alert!", "Cann't not delete", "error").then(function(eyz){
                    if(eyz.value){
                      location.reload();
                    }
                  });
                }else{
                  swal("Deleted!", "Your note has been deleted.", "success").then(function(eyz){
                    if(eyz.value){
                      location.reload();
                    }
                  });
                }
 
 
              },
              dataType : 'json'
          });
 
      }
 
    })
 
 }

 
//itemDeleteStock
