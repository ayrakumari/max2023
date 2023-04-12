

//============m_table_RecievedOrders
var DatatablesVendorsList = function() {
    $.fn.dataTable.Api.register("column().title()", function() {
        return $(this.header()).text().trim()
    });
    return {
        init: function() {
            var a;
            a = $("#m_table_VendortList").DataTable({
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
                    url:BASE_URL+'/getVendorList',
                    type: "POST",
                    data: {
                        columnsDef: ["RecordID","vendor_id","vendor_name", "branch", "name", "phone","email"],
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                {
                    data: "RecordID"
                }, 
                {
                    data: "vendor_id"
                }, 
                {
                    data: "vendor_name"
                }, 
                {
                    data: "name"
                },
                {
                    data: "phone"
                },
                {
                    data: "email"
                },
                {
                    data: ""
                },
                 ],
                
                columnDefs: [
                    {
                        targets: [0],
                        visible: !1
                    },
                    {
                        targets: -1,
                        title: "Actions",
                        orderable: !1,
                        render: function(a, t, e, n) {
                          //console.log(e);
                  

                          var vEDit=BASE_URL+'/vendors/'+e.RecordID+"/edit"
                          return `<a href="${vEDit}" class="btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
                          <span>
                              <i class="fa flaticon-users"></i>
                              <span>Edit</span>
                          </span>
                      </a>`;
      
      
                        }
                    },
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



jQuery(document).ready(function() {
    DatatablesVendorsList.init();
  

});

