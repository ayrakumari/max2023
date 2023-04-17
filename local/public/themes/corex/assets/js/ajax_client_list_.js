var KTSessionTimeoutDemo = {
  init: function ()
  {
    $.sessionTimeout( {
      title: "Session Timeout Notification",
      message: "Your session is about to expire.",
      keepAliveUrl: "/metronic/themes/themes/metronic/dist/preview/inc/api/session-timeout/keepalive.php",
      redirUrl: "?p=page_user_lock_1",
      logoutUrl: "?p=page_user_login_1",
      warnAfter: 3e3,
      redirAfter: 35e3,
      ignoreUserActivity: !0,
      countdownMessage: "Redirecting in {timer} seconds.",
      countdownBar: !0
    } )
  }
};
jQuery( document ).ready( function ()
{
  //KTSessionTimeoutDemo.init()
} );


// block UI
var BlockUIDemo = {
  init: function ()
  {
    $( ".AnchorgetUserID" ).click( function ()
    {
      mApp.blockPage( {
        overlayColor: "#000000",
        type: "loader",
        state: "success",
        message: "Please wait..."
      } ), setTimeout( function ()
      {
        mApp.unblockPage()
      }, 2e3 )
    } )
  },


};
jQuery( document ).ready( function ()
{
  BlockUIDemo.init()
} );

//btnShowPaymentOrdersListWithFilter
$( '#btnShowPaymentOrdersListWithFilter' ).click( function ()
{
  if ( $( '#chkEmail' ).is( ':checked' ) )
  {
    var isEmail = 1;
  } else
  {
    var isEmail = 2;
  }
  var orderFor = $( '#order_for' ).val();
  if ( orderFor == 1 )
  {
    var BURL = BASE_URL + '/getPaymentOrdersListWithFilter';
  }
  if ( orderFor == 2 )
  {
    var BURL = BASE_URL + '/getPaymentOrdersListWithFilterOrder';
  }
  if ( orderFor == 3 )
  {
    var BURL = BASE_URL + '/getPaymentOrdersListWithFilterSample';
  }
  if ( orderFor == 4 )
  {
    var BURL = BASE_URL + '/getPaymentOrdersListWithFilterLead';
  }

  // if(orderFor==1){
  //   var BURL=BASE_URL + '/getPaymentOrdersListWithFilter';
  // }else{

  // }
  var formData = {
    'dateSelected': $( '#m_datepicker_3' ).val(),
    'dateSelectedTo': $( '#m_datepicker_3A' ).val(),
    'user_id': $( '#user_id' ).val(),
    'order_for': $( '#order_for' ).val(),
    'chkEmail': isEmail,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BURL,
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#leadAssignByDate' ).html( res );
    }
  } );

} );

//btnShowPaymentOrdersListWithFilter

//btnShowLeadAssignDateWise
$( '#btnShowLeadAssignDateWise' ).click( function ()
{
  var formData = {
    'dateSelected': $( '#m_datepicker_2' ).val(),
    'dateSelectedTo': $( '#m_datepicker_3' ).val(),
    'assinedby': $( '#assinedby' ).val(),
    'lead_status': $( '#lead_status' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getLeadAssinDateWiseData',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      $( '#leadAssignByDate' ).html( res );
    }
  } );

} );
//btnShowLeadAssignDateWise
// block UI
$( '.AnchorgetUserID' ).click( function ()
{
  var QUERY_ID = $( this ).attr( 'id' );
  $( '#QUERY_ID_ID' ).val( QUERY_ID );
  //ajax
  var formData = {
    'QUERY_ID': QUERY_ID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getLeadDataBYID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '.userName' ).html( " " + res.LeadData.SENDERNAME );
      $( '.userPhone' ).html( " " + res.LeadData.MOB );
      $( '.userEmailAnchor' ).attr( "href", "mailto:" + res.LeadData.SENDEREMAIL );
      $( '.userEmail' ).html( " " + res.LeadData.SENDEREMAIL );

    },
    'dataType': 'json'
  } );
  //ajax

} );



//lead Package
var DatatablesLeadList_PACK = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_pack" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_PACK',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "COUNTRY_ISO",
              "COUNTRY_FLAG",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                  ${ e.st_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';

                //------------------
                if ( UID == 4 )
                {
                  var edit_URL = 'users/lead-pack/' + e.QUERY_ID + '/edit';
                  view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                  sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData_PACK(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>`;



                  //   return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  //             <i class="la la-eye"></i>
                  //           </a>
                  //           <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  //                 <i class="la la-edit"></i>
                  //           </a>
                  //           <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                  //  <i class="la la-ellipsis-h"></i></a>
                  //  <div class="dropdown-menu dropdown-menu-right">
                  //   <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  //   <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  //   <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  //   </div></span>
                  //   <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  //   ${ e.data_source }
                  //   </span>
                  //   `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead-pack/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData_PACK(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>

                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                  <span class="m-widget5__info-label">
                   <strong> ${ e.AssignName }</strong>
                  </span>
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData_PACK(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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

//lead Package

// viewAllOWN_LEAD

//m_table_click2CallActivity
var Datatablesm_table_Click2CallActivity = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_click2CallActivity" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getClick2CallDataFromAPI',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "customer_number", "agent_number", "call_duration", "in_out", "call_on", "call_audio", "call_details", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'userID': $( '#txtUserIDVal' ).val()
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "customer_number"
          },
          {
            data: "agent_number"
          },
          {
            data: "call_duration"
          },
          {
            data: "in_out"
          },
          {
            data: "call_on"
          },
          {
            data: "call_audio"
          },

          {
            data: "call_details"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },
          {
            targets: 6,
            title: "Audio",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              return `<audio controls>

                    <source src="${ e.call_audio }" type="audio/mpeg">
                    Your browser does not support the audio element.
                    </audio>`
            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var HTML = "";



              HTML += `<a href="javascript::void(0)" onclick="viewLoginActivity(${ e.loginDBID },${ e.userid })" title="View Details" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>`;



              return HTML;




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

//m_table_click2CallActivity


//m_table_SOPActivity
//m_table_SOPActivity
var Datatablesm_table_m_table_SOPActivity = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_SOPActivity" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSOPActivityUser',
          type: "GET",
          data: {
            columnsDef: [ "RecordID", "userid", "loginLocation", "loginDBID", "login_date_db", "login_date", "login_name", "first_login", "last_login", "session_hour", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'userID': $( '#txtUserIDVal' ).val()
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "login_date"
          },
          {
            data: "login_name"
          },
          {
            data: "first_login"
          },
          {
            data: "last_login"
          },
          {
            data: "session_hour"
          },
         
          {
            data: "Actions"
          }
        ],

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
              //alert( UID )

              var HTML = "";



              HTML += `<a href="javascript::void(0)" onclick="viewLoginActivity(${ e.loginDBID },${ e.userid })" title="View Details" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>`;



              return HTML;




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


var Datatablesm_table_loginActivity = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_loginActivity" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getLoginActivityUser',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "userid", "loginLocation", "loginDBID", "login_date_db", "login_date", "login_name", "first_login", "last_login", "session_hour", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'userID': $( '#txtUserIDVal' ).val()
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "login_date"
          },
          {
            data: "login_name"
          },
          {
            data: "first_login"
          },
          {
            data: "last_login"
          },
          {
            data: "session_hour"
          },
          {
            data: "loginLocation"
          },
          {
            data: "Actions"
          }
        ],

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
              //alert( UID )

              var HTML = "";



              HTML += `<a href="javascript::void(0)" onclick="viewLoginActivity(${ e.loginDBID },${ e.userid })" title="View Details" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>`;



              return HTML;




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

function viewLoginActivity( rowID, userID )
{

  var formData = {
    'rowID': rowID,
    'userID': userID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getLoginActivityDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.viewLoginActivity' ).html( res )
      $( '#m_modal_4LoginActivity' ).modal( 'show' );
    }
  } );



}

// m_table_1_viewCID_Quation
var DatatablesCID_QUATATION = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_1_viewCID_Quation" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getCID_Quation_data',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "item_name",
              "size",
              "mcp_kg",
              "mcp_pc",
              "bottle", "box", "lable", "labour",
              "margin",
              "cp",
              "qty",
              "qtype",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'QID': $( '#txtQID' ).val(),
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
            data: "size"
          },
          {
            data: "mcp_kg"
          },
          {
            data: "mcp_pc"
          },
          {
            data: "bottle"
          },
          {
            data: "box"
          },
          {
            data: "lable"
          },
          {
            data: "labour"
          },
          {
            data: "margin"
          },
          {
            data: "cp"
          },
          {
            data: "qty"
          },
          {
            data: "qtype"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [

          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              return '';

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


function viewCIDQuatation()
{
  var a;
  $( "#m_table_1_viewCID_Quation" ).dataTable().fnDestroy();





  a = $( "#m_table_1_viewCID_Quation" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getCID_Quation_data',
      type: "POST",
      data: {
        columnsDef: [ "RecordID",
          "item_name",
          "size",
          "mcp_kg",
          "mcp_pc",
          "bottle", "box", "lable", "labour",
          "margin",
          "cp",
          "qty",
          "qtype",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'QID': $( '#txtQID' ).val(),
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
        data: "size"
      },
      {
        data: "mcp_kg"
      },
      {
        data: "mcp_pc"
      },
      {
        data: "bottle"
      },
      {
        data: "box"
      },
      {
        data: "lable"
      },
      {
        data: "labour"
      },
      {
        data: "margin"
      },
      {
        data: "cp"
      },
      {
        data: "qty"
      },
      {
        data: "qtype"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [

      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          return '';

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

// m_table_1_viewCID_Quation
var DatatablesQuatationDataList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_quatationDataList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getAjaxQuatationList',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "QUERY_ID",
              "QID",
              "name",
              "email",
              "status",
              "created_at",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "RecordID"
          },
          {
            data: "QID"
          },
          {
            data: "name"
          },
          {
            data: "email"
          },
          {
            data: "created_at"
          },
          {
            data: "status"
          },

          {
            data: "Actions"
          }
        ],

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

              if ( _UNIB_RIGHT == 'SalesUser' || _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesHead' )
              {
                var view_preview = 'quatation/preview/' + e.QID;


                return `<a href="${ view_preview }"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>



                          `;

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


//leadMangement v1

var DatatablesSalesLeadList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_SALESLEADList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "st_name",
              "LEAD_TYPE",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },
          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                  ${ e.st_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "ActionsB",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( _UNIB_RIGHT == 'SalesUser' || _UNIB_RIGHT == 'Admin' || UID == '102' || UID == '40' || UID == '4' || UID == '3' || UID == '119' || UID == '129' )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>

                          <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-users"></i>
                          </a>
                          <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="flaticon-chat "></i>
                        </a>
                        <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="flaticon-users "></i>
                        </a>

                          `;

              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.created_at } <br>

                  </span>
                  <span class="m-widget5__info-label">
                   <strong> ${ e.AssignName }</strong>
                  </span>
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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

// m_table_OrderApprovalRequestLIST
var DatatablesClientDataOrderApprovalList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_OrderApprovalRequestLIST" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getOrderApprovalListData',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "order_id",
              "client_name",
              "company",
              "brand",
              "OrderVal",
              "client_name",
              "created_at",
              "created_by",
              "qc_link",
              "form_id", ,
              "Actions" ],
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
            data: "OrderVal"
          },
          {
            data: "client_name"
          },

          {
            data: "company"
          },
          {
            data: "brand"
          },
          {
            data: "created_at"
          },
          {
            data: "created_by"
          },


          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {


            view_URL = BASE_URL + '/clientv1/' + e.RecordID + '';


            var HTML = '';
            if ( _UNIB_RIGHT == 'Admin' || UID == 132 || UID == 90 || UID == 176 )
            {

              HTML += `<a href="javascript::void(0)" onclick="viewPayRecViewHIST(${ e.RecordID })"  title="Payment History" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>
                       <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayOrderApprovalModelLIST(${ e.RecordID })" title="Order Approval" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-layer"></i>
                       </a>
                       <a style="margin-top:2px" href="javascript::void(0)"   onclick="addPayOrderApprovalModelInvoice(${ e.RecordID })" title="Add Invoice" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-file"></i>
                       </a>

                       `;




            }


            return HTML;




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

//get Materia per pic
function getMaterialPCRate()
{
  var m_typeahead_2_size = parseInt( $( '#m_typeahead_2_size' ).val() );
  var m_typeahead_2_mcp_kg = parseInt( $( '#m_typeahead_2_mcp_kg' ).val() );
  var one_pc = "";
  if ( m_typeahead_2_mcp_kg == "" )
  {

  } else
  {
    one_pc = ( ( m_typeahead_2_size * m_typeahead_2_mcp_kg ) / 1000 ).toFixed( 2 ) + " PC";
    $( '#m_typeahead_2_mcp_pc' ).val( one_pc );
  }

}
function getMaterialPCRateSUM()
{
  var m_typeahead_2_mcp_pc = parseInt( $( '#m_typeahead_2_mcp_pc' ).val() );
  var m_typeahead_2_mcp_bottle = parseInt( $( '#m_typeahead_2_mcp_bottle' ).val() );
  var m_typeahead_2_mcp_box = parseInt( $( '#m_typeahead_2_mcp_box' ).val() );
  var m_typeahead_2_mcp_babel = parseInt( $( '#m_typeahead_2_mcp_babel' ).val() );
  var m_typeahead_2_mcp_labour = parseInt( $( '#m_typeahead_2_mcp_labour' ).val() );
  var m_typeahead_2_mcp_margin = parseInt( $( '#m_typeahead_2_mcp_margin' ).val() );
  var sumData = ""

  if ( m_typeahead_2_mcp_pc == "" || m_typeahead_2_mcp_bottle == "" || m_typeahead_2_mcp_box == ""
    || m_typeahead_2_mcp_babel == "" || m_typeahead_2_mcp_labour == "" || m_typeahead_2_mcp_labour == "" )
  {

  } else
  {
    sumData = m_typeahead_2_mcp_pc + m_typeahead_2_mcp_bottle + m_typeahead_2_mcp_box + m_typeahead_2_mcp_babel + m_typeahead_2_mcp_labour + m_typeahead_2_mcp_margin;
    $( '#m_typeahead_2_mcp_cp' ).val( sumData );
  }

}

$( '#m_typeahead_2_size' ).focusout( function ()
{
  getMaterialPCRate();
} );
$( '#m_typeahead_2_mcp_kg' ).focusout( function ()
{
  getMaterialPCRate();
} );
//get Materia per pic
$( '#m_typeahead_2_mcp_bottle' ).focusout( function ()
{
  getMaterialPCRateSUM();

} );
$( '#m_typeahead_2_mcp_box' ).focusout( function ()
{
  getMaterialPCRateSUM();

} );
$( '#m_typeahead_2_mcp_babel' ).focusout( function ()
{
  getMaterialPCRateSUM();

} );
$( '#m_typeahead_2_mcp_labour' ).focusout( function ()
{
  getMaterialPCRateSUM();

} );
$( '#m_typeahead_2_mcp_margin' ).focusout( function ()
{
  getMaterialPCRateSUM();

} );




$( '#btnAddMoreData' ).click( function ()
{
  var txtQID = $( '#txtQID' ).val();
  var QUERY_ID = $( '#QUERY_ID' ).val();
  var name = $( '#txtCID_Name' ).val();
  var email = $( '#txtCID_Email' ).val();
  var item_name = $( '#m_typeahead_2_itemname' ).val();
  var item_size = $( '#m_typeahead_2_size' ).val();
  var item_mcp_kg = $( '#m_typeahead_2_mcp_kg' ).val();
  var item_mcp_pc = $( '#m_typeahead_2_mcp_pc' ).val();
  var item_mcp_bottle = $( '#m_typeahead_2_mcp_bottle' ).val();
  var item_mcp_box = $( '#m_typeahead_2_mcp_box' ).val();
  var item_mcp_lable = $( '#m_typeahead_2_mcp_babel' ).val();
  var item_mcp_labour = $( '#m_typeahead_2_mcp_labour' ).val();
  var item_mcp_margin = $( '#m_typeahead_2_mcp_margin' ).val();
  var item_mcp_cp = $( '#m_typeahead_2_mcp_cp' ).val();
  var item_mcp_qty = $( '#m_typeahead_2_mcp_qty' ).val();
  var item_mcp_ptype = $( '#m_typeahead_2_mcp_ptype' ).val();

  var formData = {
    'txtQID': txtQID,
    'QUERY_ID': QUERY_ID,
    'name': name,
    'name': name,
    'email': email,
    'item_name': item_name,
    'item_size': item_size,
    'item_mcp_kg': item_mcp_kg,
    'item_mcp_pc': item_mcp_pc,
    'item_mcp_bottle': item_mcp_bottle,
    'item_mcp_box': item_mcp_box,
    'item_mcp_lable': item_mcp_lable,
    'item_mcp_labour': item_mcp_labour,
    'item_mcp_margin': item_mcp_margin,
    'item_mcp_cp': item_mcp_cp,
    'item_mcp_qty': item_mcp_qty,
    'item_mcp_ptype': item_mcp_ptype,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveQuationDataAsDraft',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );
      $( '#txtQID' ).val( res.QID );

      viewCIDQuatation();


    },
    datatype: 'json'

  } );



} );


$( "input[name=payStatusDetail]" ).click( function ()
{
  var radioValue = $( "input[name='payStatusDetail']:checked" ).val();
  var a;

  $( "#m_table_PaymentRequestLIST" ).dataTable().fnDestroy();

  a = $( "#m_table_PaymentRequestLIST" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getPaymentRequestDataAdmin',
      type: "POST",
      data: {
        columnsDef: [ "RecordID",
          "payment_date",
          "c_name", "c_phone", "c_company",
          "requested_on",
          "created_by",
          "amount",
          "amount_word",
          "bank_name",
          "status",
          "paytype_name",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'radioValue': radioValue
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "payment_date"
      },
      {
        data: "c_name"
      },

      {
        data: "c_company"
      },
      {
        data: "amount"
      },
      {
        data: "bank_name"
      },

      {
        data: "status"
      },
      {
        data: "requested_on"
      },


      {
        data: "Actions"
      }
    ],

    columnDefs: [ {
      targets: -1,
      title: "Actions",
      orderable: !1,
      render: function ( a, t, e, n )
      {


        view_URL = BASE_URL + '/clientv1/' + e.RecordID + '';


        var HTML = '';
        if ( _UNIB_RIGHT == 'Admin' || UID == 132 || UID == 90 || UID == 176 || UID == 171 || UID == 85 )
        {
          if ( UID == 90 || UID == 85 )
          {
            HTML += `<a href="javascript::void(0)" onclick="viewPayRecView(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a>

          <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="flaticon-chat"></i>
          </a>
          <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayOrderApprovalModel(${ e.RecordID })" title="Order Approval List" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="flaticon-layer"></i>
          </a>

          `;
          } else
          {
            HTML += `<a href="javascript::void(0)" onclick="viewPayRecView(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-eye"></i>
                   </a>

                   <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                   <i class="flaticon-chat"></i>
                   </a>
                   <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayOrderApprovalModel(${ e.RecordID })" title="Order Approval List" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                   <i class="flaticon-layer"></i>
                   </a>

                   `;


            if ( e.status == 1 || e.status == 3 )
            {

            } else
            {
              HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeletePayReqData(${ e.RecordID })"  class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">

                     <i class="flaticon-delete"></i>

                 </a>
                 `;
            }

          }





        }


        return HTML;




      }
    },
    {
      targets: 6,
      width: 100,
      render: function ( a, t, e, n )
      {


        var i = {
          0: {
            title: "PENDING",
            class: "m-badge--default"
          },
          1: {
            title: "RECEIVED",
            class: " m-badge--success"
          },
          2: {
            title: "NOT RECEIVED",
            class: " m-badge--danger"
          },
          3: {
            title: "ON HOLD",
            class: " m-badge--warning"
          },

        };

        if ( e.status == 1 )
        {

          if ( UID == 85 )
          {
            return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

          }

          if ( UID == 1 )
          {
            return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

          } else
          {
            return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="NOWAYchangeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
          }



        } else
        {
          if ( UID == 85 )
          {
            return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

          }

          return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
        }
        // return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"


      }
    },
    {
      targets: 4,
      render: function ( a, t, e, n )
      {
        var strPType = "";
        //alert(e.paytype_name);
        switch ( parseInt( e.paytype_name ) )
        {
          case 1:
            // code block
            strPType = 'Advance';
            break;
          case 2:
            // code block
            strPType = 'Balance';
            break;
          case 3:
            // code block
            strPType = 'Final';
            break;
          default:
          // code block

        }

        return `<span title="${ e.amount_word }" class="m-badge m-badge--default m-badge--wide">
             <h4 class="m-section__heading"> ${ e.amount }</h4>
             </span><br style="margin-bottom:5px">
             <strong style="color:#035496">${ strPType }</strong>
             `
      }
    },
    {
      targets: 7,
      render: function ( a, t, e, n )
      {
        return e.requested_on + ` <h6 class="m--font-brand"> ${ e.created_by }</h6>                `
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


} );
// m_table_OrderApprovalRequestLIST
//m_table_PaymentRequestLIST_sample
var DatatablesClientDataPaymentRequestv1_Sample = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_PaymentRequestLIST_sample" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getPaymentRequestDataAdmin_Sample',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "payment_date",
              "c_name", "c_phone", "c_company",
              "requested_on",
              "created_by",
              "sample_code",
              "amount",
              "amount_word",
              "bank_name",
              "status",
              "paytype_name",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "payment_date"
          },
          {
            data: "sample_code"
          },

          {
            data: "c_name"
          },
          {
            data: "amount"
          },
          {
            data: "bank_name"
          },

          {
            data: "status"
          },
          {
            data: "requested_on"
          },


          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {


            view_URL = BASE_URL + '/clientv1/' + e.RecordID + '';


            var HTML = '';
            if ( _UNIB_RIGHT == 'Admin' || UID == 132 || UID == 146 || UID == 176 || UID == 171 || UID == 85 )
            {
              if ( UID == 90 || UID == 146 )
              {
                HTML += `<a href="javascript::void(0)" onclick="viewPayRecViewSAMPLE(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-eye"></i>
              </a>

              <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory_SampleHis(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="flaticon-chat"></i>
              </a>
             

              `;
              } else
              {
                HTML += `<a href="javascript::void(0)" onclick="viewPayRecViewSAMPLE(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>

                       <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory_SampleHis(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-chat"></i>
                       </a>
                      

                       `;


                if ( e.status == 1 || e.status == 3 )
                {

                } else
                {
                  HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeletePayReqData(${ e.RecordID })"  class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">

                         <i class="flaticon-delete"></i>

                     </a>
                     `;
                }

              }





            }


            return HTML;




          }
        },
        {
          targets: 6,
          width: 100,
          render: function ( a, t, e, n )
          {


            var i = {
              0: {
                title: "PENDING",
                class: "m-badge--default"
              },
              1: {
                title: "RECEIVED",
                class: " m-badge--success"
              },
              2: {
                title: "NOT RECEIVED",
                class: " m-badge--danger"
              },
              3: {
                title: "ON HOLD",
                class: " m-badge--warning"
              },

            };

            if ( e.status == 1 )
            {

              if ( UID == 85 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              }

              if ( UID == 1 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              } else
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="NOWAYchangeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
              }



            } else
            {
              if ( UID == 85 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              }

              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
            // return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"


          }
        },
        {
          targets: 4,
          render: function ( a, t, e, n )
          {
            var strPType = "";
            //alert(e.paytype_name);
            switch ( parseInt( e.paytype_name ) )
            {
              case 1:
                // code block
                strPType = 'Advance';
                break;
              case 2:
                // code block
                strPType = 'Balance';
                break;
              case 3:
                // code block
                strPType = 'Final';
                break;
              default:
              // code block

            }

            return `<span title="${ e.amount_word }" class="m-badge m-badge--default m-badge--wide">
                 <h4 class="m-section__heading"> ${ e.amount }</h4>
                 </span><br style="margin-bottom:5px">
                 <strong style="color:#035496">${ strPType }</strong>
                 `
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            return e.requested_on + ` <h6 class="m--font-brand"> ${ e.created_by }</h6>                `
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

//m_table_PaymentRequestLIST_sample

// m_table_PaymentRequestLIST
var DatatablesClientDataPaymentRequestv1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_PaymentRequestLIST" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getPaymentRequestDataAdmin',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "payment_date",
              "c_name", "c_phone", "c_company",
              "requested_on",
              "created_by",
              "amount",
              "amount_word",
              "bank_name",
              "status",
              "paytype_name",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "payment_date"
          },
          {
            data: "c_name"
          },

          {
            data: "c_company"
          },
          {
            data: "amount"
          },
          {
            data: "bank_name"
          },

          {
            data: "status"
          },
          {
            data: "requested_on"
          },


          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "ActionsA",
          orderable: !1,
          render: function ( a, t, e, n )
          {


            view_URL = BASE_URL + '/clientv1/' + e.RecordID + '';


            var HTML = '';
            if ( _UNIB_RIGHT == 'Admin' || UID == 132 || UID == 90 || UID == 176 || UID == 171 || UID == 85 )
            {
              if ( UID == 90 || UID == 85 )
              {
                HTML += `<a href="javascript::void(0)" onclick="viewPayRecView(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-eye"></i>
              </a>

              <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="flaticon-chat"></i>
              </a>
              <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayOrderApprovalModel(${ e.RecordID })" title="Order Approval List" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="flaticon-layer"></i>
              </a>

              `;
              } else
              {
                HTML += `<a href="javascript::void(0)" onclick="viewPayRecView(${ e.RecordID })"  title="Payment Details" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-eye"></i>
                       </a>

                       <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayHistory(${ e.RecordID })" title="Payment History" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-chat"></i>
                       </a>
                       <a style="margin-top:2px" href="javascript::void(0)"   onclick="viewPayOrderApprovalModel(${ e.RecordID })" title="Order Approval List" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-layer"></i>
                       </a>

                       `;


                if ( e.status == 1 || e.status == 3 )
                {

                } else
                {
                  HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeletePayReqData(${ e.RecordID })"  class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">

                         <i class="flaticon-delete"></i>

                     </a>
                     `;
                }

              }





            }


            return HTML;




          }
        },
        {
          targets: 6,
          width: 100,
          render: function ( a, t, e, n )
          {


            var i = {
              0: {
                title: "PENDING",
                class: "m-badge--default"
              },
              1: {
                title: "RECEIVED",
                class: " m-badge--success"
              },
              2: {
                title: "NOT RECEIVED",
                class: " m-badge--danger"
              },
              3: {
                title: "ON HOLD",
                class: " m-badge--warning"
              },

            };

            if ( e.status == 1 )
            {

              if ( UID == 85 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              }

              if ( UID == 1 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              } else
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="NOWAYchangeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
              }



            } else
            {
              if ( UID == 85 )
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICENOAKKK(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

              }

              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusPAYINVOICE(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
            // return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"


          }
        },
        {
          targets: 4,
          render: function ( a, t, e, n )
          {
            var strPType = "";
            //alert(e.paytype_name);
            switch ( parseInt( e.paytype_name ) )
            {
              case 1:
                // code block
                strPType = 'Advance';
                break;
              case 2:
                // code block
                strPType = 'Balance';
                break;
              case 3:
                // code block
                strPType = 'Final';
                break;
              default:
              // code block

            }

            return `<span title="${ e.amount_word }" class="m-badge m-badge--default m-badge--wide">
                 <h4 class="m-section__heading"> ${ e.amount }</h4>
                 </span><br style="margin-bottom:5px">
                 <strong style="color:#035496">${ strPType }</strong>
                 `
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            return e.requested_on + ` <h6 class="m--font-brand"> ${ e.created_by }</h6>                `
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



//viewPayOrderApprovalModel
function viewPayOrderApprovalModel( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENORDER_MODEL' ).modal( 'show' );
  $( '#payOrderApprList' ).html( 'Please Wait ...' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPayOrderApprovalList',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      var OrderHTML = `<table class="table m-table m-table--head-bg-primary">
      <thead>
        <tr>
          <th>#Order No.</th>
          <th>Client Name</th>
          <th>Created at</th>
          <th>Account Note</th>
          <th>Created By</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        `;

      $.each( res.order_data, function ( key, st )
      {
        OrderHTML += `<tr>
        <th scope="row">${ st.order_id }</th>
        <td>${ st.client_name }</td>
        <td>${ st.created_at }</td>
        <td>${ st.accountNote }</td>
        <td>${ st.created_by }</td>
        <td>
        <a href="javascript::void(0)" onclick="payAccountResponse(${ st.form_id })" class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
        <span>
          <i class="fa flaticon-file-1"></i>
          <span>Approved</span>
        </span>
      </a>
     

      </td>

      </tr>`;

      } );
      OrderHTML += `</tbody>
      </table>`;

      $( '#payOrderApprList' ).html( OrderHTML );
    },
    dataType: 'json'
  } );
  //ajax



}

// addPayOrderApprovalModelInvoiceByRequest
function addPayOrderApprovalModelInvoiceByRequest( formID )
{

  $( '#txtPayOrderIDInvAdd' ).val( formID );
  $( '#m_modal_5_account_adminPAYOrderInvoiceAddReqBy' ).modal( 'show' );


}
// addPayOrderApprovalModelInvoiceByRequest
//addPayOrderApprovalModelInvoice
function addPayOrderApprovalModelInvoice( formID )
{

  $( '#txtPayOrderIDInvAdd' ).val( formID );
  $( '#m_modal_5_account_adminPAYOrderInvoiceAdd' ).modal( 'show' );


}
//addPayOrderApprovalModelInvoice

//viewPayOrderApprovalModelLIST
function viewPayOrderApprovalModelLIST( formID )
{

  $( '#txtPayOrderID' ).val( formID );
  $( '#m_modal_5_account_adminPAYOrderConfirm' ).modal( 'show' );


}

//viewPayOrderApprovalModelLIST
$( '#btnDownloadQuatation' ).click( function ()
{
  var QID = $( this ).attr( "data-quatation" );

  // ajax call
  var formData = {
    'QID': QID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/downloadQuatation',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //console.log(res);
      var url = BASE_URL + '/' + res;
      $( '#btnDownloadQuatation' ).attr( "href", url ); // Set herf value
      $( '#btnDownloadQuatation' ).html( `<span>
  <i class="la la-download"></i>
  <span>Download Now</span>
</span>`); // Set herf value


    }

  } );


} );


$( '#btnSendQuatation' ).click( function ()
{
  var QID = $( this ).attr( "data-quatation" );

  // ajax call
  var formData = {
    'QID': QID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/sendEmailQuatation',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

    },
    dataType: "json"
  } );






} );

function payAccountResponse( formID )
{

  $( '#txtPayOrderID' ).val( formID );
  $( '#m_modal_5_account_adminPAYOrderConfirm' ).modal( 'show' );


}
//btnPayOrderRecSubmitINvoice


//btnPayOrderRecSubmitINvoice

//btnPayOrderRecSubmit
$( '#btnPayOrderRecSubmit' ).click( function ()
{
  var payOrderID = $( '#txtPayOrderID' ).val();
  var txtAdminAccountOC = $( '#txtAdminAccountOC' ).val();
  var accOCResp = $( '#accOCResp option:selected' ).val();



  // ajax call
  var formData = {
    'payOrderID': payOrderID,
    'accOCResp': accOCResp,
    'txtAdminAccountOC': txtAdminAccountOC,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setPaymentRecOrder',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Successfully Submitted ', 'Confirm Order' );
        //return false;
        setTimeout( function ()
        {


          location.reload();
        }, 500 );



      }
    },
    dataType: 'json'
  } );
  //ajax


} );


//btnPayOrderRecSubmit
//btnLeadOncreditAction
$( '#btnLeadOncreditAction' ).click( function ()
{
  var txtID = $( '#txtIDLead' ).val();
  var respType = $( '#respType option:selected' ).val();
  var txtEditOrderResponse = $( '#txtEditOrderResponse' ).val();



  // ajax call
  var formData = {
    'txtID': txtID,
    'respType': respType,
    'txtEditOrderResponse': txtEditOrderResponse,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setOncreditResponse',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Successfully Submitted ', 'On Credit Request' );

        setTimeout( function ()
        {


          location.reload();
        }, 800 );



      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnLeadOncreditAction

//btnOrderEditAction
$( '#btnOrderEditAction' ).click( function ()
{
  var txtID = $( '#txtID' ).val();
  var respType = $( '#respType option:selected' ).val();
  var txtEditOrderResponse = $( '#txtEditOrderResponse' ).val();



  // ajax call
  var formData = {
    'txtID': txtID,
    'respType': respType,
    'txtEditOrderResponse': txtEditOrderResponse,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setOrderEditResponse',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Successfully Submitted ', 'Order Edit' );

        setTimeout( function ()
        {


          location.reload();
        }, 800 );



      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnOrderEditAction
//btnPayRecSubmitSample
$( '#btnPayRecSubmitSample' ).click( function ()
{
  var payid = $( '#txtPAAPayID' ).val();
  var txtAdminAccount = $( '#txtAdminAccount' ).val();
  var accResp = $( '#accResp option:selected' ).val();



  // ajax call
  var formData = {
    'payid': payid,
    'accResp': accResp,
    'txtAdminAccount': txtAdminAccount,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setPaymentRecCommnetSample',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Successfully Submitted ', 'Payment' );
        return false;
        setTimeout( function ()
        {


          location.reload();
        }, 500 );



      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnPayRecSubmitSample


//viewPayOrderApprovalModel
//-------------------------
$( '#btnPayRecSubmit' ).click( function ()
{
  var payid = $( '#txtPAAPayID' ).val();
  var txtAdminAccount = $( '#txtAdminAccount' ).val();
  var accResp = $( '#accResp option:selected' ).val();



  // ajax call
  var formData = {
    'payid': payid,
    'accResp': accResp,
    'txtAdminAccount': txtAdminAccount,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setPaymentRecCommnet',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Successfully Submitted ', 'Payment' );
        return false;
        setTimeout( function ()
        {


          location.reload();
        }, 500 );



      }
    },
    dataType: 'json'
  } );
  //ajax


} );
//----------------------------


function changeStatusPAYINVOICE( rowID )
{
  $( '#txtPAAPayID' ).val( rowID );
  $( '#m_modal_5_account_adminPAYApp' ).modal( 'show' );

}

//viewPayHistory_SampleHis

function viewPayHistory_SampleHis( id )
{
  
  $( '#m_modal_6PAYMENTRECDETAIL_HIST_SAMPLE' ).modal( 'show' );
  $( '#payDetalRecSHOW_HIST_SAMPLE' ).html( 'Please Wait ...' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW_HIST_SAMPLE',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '#payDetalRecSHOW_HIST_SAMPLE' ).html( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
  //ajax
}

//viewPayHistory_SampleHis

//viewPayHistory

function viewPayHistory( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENTRECDETAIL_HIST' ).modal( 'show' );
  $( '#payDetalRecSHOW_HIST' ).html( 'Please Wait ...' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW_HIST',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '#payDetalRecSHOW_HIST' ).html( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
  //ajax
}


function viewPayRecView( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENTRECDETAIL' ).modal( 'show' );
  $( '#payDetalRecSHOW' ).html( '' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#payDetalRecSHOW' ).append( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
  //ajax



}

// viewPayRecViewHIST
function viewPayRecViewHIST( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENTRECDETAIL' ).modal( 'show' );
  $( '#payDetalRecSHOW' ).html( '' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW_HIST_ORDER',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#payDetalRecSHOW' ).append( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
  //ajax



}

// viewPayRecViewHIST
//viewPayHistory
//viewPayRecViewRemoveIncentiveDeduction
function viewPayRecViewRemoveIncentiveDeduction( ori_order_amt, user_id, in_month, in_year )
{

  $( '#ori_order_amt' ).val( ori_order_amt );
  $( '#in_user_id' ).val( user_id );
  $( '#in_user_month' ).val( in_month );
  $( '#in_user_year' ).val( in_year );
  $( '#m_modal_6PAYMENTRECDETAIL_removeIncetiveDeduct' ).modal( 'show' );
}
//viewPayRecViewRemoveIncentiveDeduction

// viewPayRecViewRemoveIncentive
function viewPayRecViewRemoveIncentive( id )
{

  $( '#payIDDone' ).val( id )
  $( '#m_modal_6PAYMENTRECDETAIL_removeIncetive' ).modal( 'show' );
}
// viewPayRecViewRemoveIncentive


//viewPayRecViewSAMPLE
function viewPayRecViewSAMPLE( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENTRECDETAIL' ).modal( 'show' );
  $( '#payDetalRecSHOW' ).html( '' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#payDetalRecSHOW' ).append( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
}
//viewPayRecViewSAMPLE

function viewPayRecViewSAMPLE( id )
{
  //alert(id);
  $( '#m_modal_6PAYMENTRECDETAIL_SAMPLE' ).modal( 'show' );
  $( '#payDetalRecSHOW_SAMPLE' ).html( '' );
  // ajax call
  var formData = {
    'rowID': id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPaymentDataDETAILSHOW_SAMPLE',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#payDetalRecSHOW_SAMPLE' ).append( res.HTMLVIEW );
    },
    dataType: 'json'
  } );
  //ajax



}
// m_table_PaymentRequestLIST



var DatatablesClientDataListv1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_clientListv1" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getClientsList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company", "name", "created_on", "created_by", "phone", "last_note_added", "follow_date", "Status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "last_note_added"
          },
          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            // edit_URL=BASE_URL+'/client/'+e.RecordID+'/edit';
            view_URL = BASE_URL + '/clientv1/' + e.RecordID + '';
            // sample_URL=BASE_URL+'/sample/add/'+e.RecordID+'';

            // if(_UNIB_RIGHT=='Admin' || _UNIB_RIGHT=='SalesUser'){
            //   return `<a href="${view_URL}" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
            //   <i class="la la-info"></i>
            // </a>
            // <a href="${edit_URL}" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            //       <i class="la la-edit"></i>
            //     </a>

            // <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${e.RecordID})"
            //  title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="flaticon-delete"></i>
            //                             </a>

            //                             <a href="${sample_URL}"
            //  title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="
            //                             flaticon-box "></i>
            //                             </a>
            //                             <a href="javascript::void(0)" onclick="add_client_notes(${e.RecordID})"
            //  title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="flaticon-chat "></i>
            //                             </a>
            //                             `

            // }else{ //not admin or sales

            //   return `<a href="${view_URL}" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
            //   <i class="la la-info"></i>
            // </a>
            //  <a href="${sample_URL}"
            //  title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="
            //                             flaticon-box "></i>
            //                             </a>

            //                             `


            // }

            var HTML = '';
            if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
            {

              HTML += `<a href="${ view_URL }" title="Client Details" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                         <i class="la la-info"></i>
                       </a>`;
            }


            return HTML;




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

//leadMangement v1
//btnTransferClient
$( '#btnTransferClient' ).click( function ()
{
  var uix = $( '#m_select2_9' ).val();
  var message = $( '#txtTransMessage' ).val();
  var clid = $( '#clid' ).val();

  if ( message == "" )
  {

    swal( {
      title: "Alert",
      text: "Message must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax
  //ajax call
  var formData = {
    'message': message,
    'user_id': uix,
    'clid': clid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/clientTransfer',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", " Transfer successfully", "success" ).then( function ( eyz )
        {
          window.location.href = BASE_URL + '/leads-list'


        } );
      }
    },
    dataType: 'json'
  } );
  //ajax



} );
//btnTransferClient

//btnTransferClientEmailSMS
$('#btnTransferClientEmailSMS').click(function(){
  var uix = $( '#m_select2_1' ).val();
  var message = $( '#txtTransMessage_SMSEMAIL' ).val();
  var clid = $( '#clid_email_sms' ).val(); 
  var txtClientEmailID = $( '#txtEmailID' ).val();
  var txtClientPhone = $("input[name=txtCIDPhone]").val();  
  var emailsmsVal = [];
  $('input[name=sendEMAIL_SMS]:checked').map(function() {
    emailsmsVal.push($(this).val());
  });
  var formData = {
    'message': message,
    'user_id': uix,
    'clid': clid,
    'txtClientEmailID': txtClientEmailID,
    'txtClientPhone': txtClientPhone,
    'emailsmsVal': emailsmsVal,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/clientTransferWithSMSEMAIL',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", " Transfer successfully", "success" ).then( function ( eyz )
        {
          window.location.href = BASE_URL + '/leads-list'


        } );
      }
    },
    dataType: 'json'
  } );
  //ajax


  //console.log(formData);

 



});
//btnTransferClientEmailSMS

//btnRNDSelectType

//btnRNDSelectType

//btnRNDStatusUpdateBase
$('#btnRNDStatusUpdateBase' ).click( function ()
{
  var message = $( 'textarea#messageRNDUpdate' ).val();
  var rowID = $( '#txtRowIDx' ).val();
  var selRNDStatus = $( '#selRNDStatus option:selected' ).val();
  
  var favorite = [];


  if ( message == "" )
  {
    swal( {
      title: "Alert",
      text: "Notes must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax call
  var formData = {
    'message': message,
    'rowID': rowID,
    'selRNDStatus': selRNDStatus,

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/updateRNDStatusNowBase',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", "Submitted  successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {


            location.reload(1);

          }
        } );
      }
    },
    dataType: 'json'
  } );
  //ajax call

} );
//btnRNDStatusUpdateBase


//btnRNDStatusUpdate
$('#btnRNDStatusUpdate' ).click( function ()
{
  var message = $( 'textarea#messageRNDUpdate' ).val();
  var rowID = $( '#txtRowIDx' ).val();
  var selRNDStatus = $( '#selRNDStatus option:selected' ).val();
  
  

  var favorite = [];


  if ( message == "" )
  {
    swal( {
      title: "Alert",
      text: "Notes must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax call
  var formData = {
    'message': message,
    'rowID': rowID,
    'selRNDStatus': selRNDStatus,

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/updateRNDStatusNow',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", "Submitted  successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {


            location.reload(1);

          }
        } );
      }
    },
    dataType: 'json'
  } );
  //ajax call

} );

//btnRNDStatusUpdate


//btnLeadCreditRequest
$( '#btnLeadCreditRequest' ).click( function ()
{
  var message = $( 'textarea#txtCreditMessage' ).val();
  var lead_id = $( '#lead_id_credit' ).val();
  var lead_credit_period = $( '#lead_credit_period option:selected' ).val();
  var lead_credit_pdc = $( '#lead_credit_pdc option:selected' ).val();
  var lead_percentage = $( '#m_inputmask_6' ).val();

  var favorite = [];


  if ( message == "" )
  {
    swal( {
      title: "Alert",
      text: "Credit Request Message must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax call
  var formData = {
    'message': message,
    'lead_id': lead_id,

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveleadCreditRequest',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", "Requested successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {


            window.location.href = BASE_URL + '/leads-list'

          }
        } );
      }
    },
    dataType: 'json'
  } );
  //ajax call

} );

//btnLeadCreditRequest

// btnLeadNotes
$( '#btnLeadNotes' ).click( function ()
{
  var message = $( 'textarea#txtNotes' ).val();
  var lead_id = $( '#lead_id' ).val();
  var favorite = [];
  var radioValue = $( "input[name='followUPSET']:checked" ).val();

  var sh_date = $( '#shdate_input' ).val();
  if ( sh_date === "" )
  {
    var shchk_val = 2;
  } else
  {
    var shchk_val = 1;
  }

  if ( message == "" )
  {
    swal( {
      title: "Alert",
      text: "Note's Message must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax call
  var formData = {
    'message': message,
    'lead_id': lead_id,
    'radioValue': radioValue,
    'shchk_val': shchk_val,
    'sh_date': sh_date,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/addLeadNotes',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", "Note's Message added successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {


            window.location.href = BASE_URL + '/leads-list'

          }
        } );
      }
    },
    dataType: 'json'
  } );
  //ajax call

} );
//btnLeadNotes
//btnClientNotes

$( '#btnClientNotes' ).click( function ()
{
  var message = $( 'textarea#txtNotes' ).val();

  var user_id = $( '#user_id' ).val();

  var favorite = [];




  var sh_date = $( '#shdate_input' ).val();
  if ( sh_date === "" )
  {
    var shchk_val = 2;
  } else
  {
    var shchk_val = 1;
  }





  if ( message == "" )
  {
    swal( {
      title: "Alert",
      text: "Note's Message must not be empty",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
    } )
    return false;
  }
  //ajax call
  var formData = {
    'message': message,
    'user_id': user_id,
    'shchk_val': shchk_val,
    'sh_date': sh_date,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/add.notes',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal( "Success", "Note's Message added successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {


            window.location.href = BASE_URL + '/client'

          }
        } );
      }
    },
    dataType: 'json'
  } );
  //ajax call

} );



//add brand ingredent
var AjaxRND_AddBrand = function ()
{
  // core form

  var add_ingBrandFomr = function ()
  {

    var e, r, i = $( "#m_form_add_ingredeint_brand" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company_name: {
          required: !0
        },
        brand_name: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveINGBrand"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_ingredeint_brand", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Ingredient Brand has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }

  //-----------lead add
  // m_form_3_sampleTechSubmitFeedbackLink
  var addTechDocLink = function ()
  {


    var e, r, i = $( "#m_form_3_sampleTechSubmitFeedbackLink" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company_name: {
          required: !0
        },
        brand_name: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveSampleTechLink"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_3_sampleTechSubmitFeedbackLink", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Submitted successfully",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                _redirect = BASE_URL + "/sample-technical-document-List";
                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }

  // m_form_3_sampleTechSubmitFeedbackLink
  //adasd
  var addTechDocOrder = function ()
  {


    var e, r, i = $( "#m_form_3_OrderTechSubmitFeedbackDOC" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company_name: {
          required: !0
        },
        brand_name: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveSampleTech"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_3_sampleTechSubmitFeedbackDOC", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                _redirect = BASE_URL + "/order-technical-document-List";
                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }

  var addTechDoc = function ()
  {


    var e, r, i = $( "#m_form_3_sampleTechSubmitFeedbackDOC" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company_name: {
          required: !0
        },
        brand_name: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveSampleTech"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_3_sampleTechSubmitFeedbackDOC", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                _redirect = BASE_URL + "/sample-technical-document-List";
                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }

  //finish_p_catid

  $( '.select_tags_finish_p_catid' ).on( 'change', function ()
  {
    var cat_ID = $( this ).find( ":selected" ).val();

    // ajax
    var formData = {
      'cat_ID': cat_ID,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
      url: BASE_URL + '/getSubCategoryFinishProuct',
      type: 'POST',
      data: formData,
      success: function ( res )
      {
        $( '#finish_p_subcatid' ).html( "" );
        $( '#finish_p_subcatid' ).append( res )

      }
    } );
    // ajax

  } );

  //finish_p_catid

  //adasd
  //m_form_3_sampleTechSubmitFeedbackDOC_ApprovalPrice
  var addTechDocApprPrice = function ()
  {


    var e, r, i = $( "#m_form_3_sampleTechSubmitFeedbackDOC_ApprovalPrice" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        txtMin: {
          required: !0
        },
        txtMax: {
          required: !0
        },
        finish_p_catid: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveSampleTechApproval"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_3_sampleTechSubmitFeedbackDOC_ApprovalPrice", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Submitted successfully",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                _redirect = BASE_URL + "/sample-Pending-Aprroval-List";
                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }

  //addTechSampleDispatch
  var addTechSampleDispatch = function ()
  {


    var e, r, i = $( "#frmSampleDispatch" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        txtMin: {
          required: !0
        },
        txtMax: {
          required: !0
        },
        finish_p_catid: {
          required: !0
        },


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveSampleDisptach"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#frmSampleDispatch", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Submitted successfully",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                _redirect = BASE_URL + "/bulkSampleDispatch";
                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }
  //addTechSampleDispatch
  //m_form_3_sampleTechSubmitFeedbackDOC_ApprovalPrice

  var add_ingLEAD_ADDData = function ()
  {

    var e, r, i = $( "#m_form_add_clientLead" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company: {
          required: !0
        },
        contact_person: {
          required: !0
        },
        phone: {
          required: !0
        },
        email: {
          required: !0
        }


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitLeadData"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_ingredeint_brand", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "In House Lead has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                window.location.assign( _redirect );


              }
            } )

          }
        } ) )
    } )
  }



  //-----------lead add


  // core form
  return {
    // public functions
    init: function ()
    {
      add_ingBrandFomr();
      addTechDoc();
      addTechDocOrder();
      addTechDocApprPrice();
      addTechSampleDispatch();
      addTechDocLink();
      add_ingLEAD_ADDData();



    },
  };
}();

//add brand ingredent
var AjaxRND_FINISH_CAT_F = function ()
{
  // core form
  var add_ingFomr_1 = function ()
  {

    var e, r, i = $( "#m_form_add_ingredeint_v2" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        f_category: {
          required: !0
        },
        f_p_subcat: {
          required: !0
        }


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveINGD_v2"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );


      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_qcform", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Successfully  Submitte",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {


                window.location.href = _redirect;

              }
            } )

          }
        } ) )
    } )
  }


  // core form
  return {
    // public functions
    init: function ()
    {
      add_ingFomr_1();



    },
  };
}();



var AjaxRND_FINISH_CAT = function ()
{
  // core form
  var add_ingFomr_1 = function ()
  {

    var e, r, i = $( "#m_form_add_ingredeint_v1" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        f_category: {
          required: !0
        },
        f_p_subcat: {
          required: !0
        }


      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveINGD_1"]' ) ).on( "click", function ( r )
    {

      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_qcform", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Successfully Submittedxd",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                window.location.href = _redirect;




              }
            } )

          }
        } ) )
    } )
  }


  // core form
  return {
    // public functions
    init: function ()
    {
      add_ingFomr_1();



    },
  };
}();



//btnClientNotes

var AjaxRND = function ()
{
  // core form
  var add_ingFomr = function ()
  {

    var e, r, i = $( "#m_form_add_ingredeint" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company_name: {
          required: !0
        },
        finish_p_name: {
          required: !0
        },
        finish_p_catid: {
          required: !0
        },
        finish_p_chemist: {
          required: !0
        },

        finish_p_ingredient: {
          required: !0
        },
        finish_p_cost_price: {
          required: !1
        },
        finish_p_benifit_claim: {
          required: !1
        },






      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submitSaveINGD"]' ) ).on( "click", function ( r )
    {
      _redirect = i.data( "redirect" );

      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_qcform", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Successfully Submitted",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {

                if ( _redirect == 'aba.html' )
                {

                } else
                {
                  URLA = BASE_URL + "/" + 'Ingredients';


                  //window.location.href = URLA;

                }





              }
            } )

          }
        } ) )
    } )
  }


  // core form
  return {
    // public functions
    init: function ()
    {
      add_ingFomr();



    },
  };
}();


//== Class definition
var AjaxClientsList = function ()
{
  //== Private functions

  // m_form_add_ingredeint
  // basic demo
  var add_qcform_modifyRequest = function ()
  {
    var e, r, i = $( "#m_form_add_qcformModifyRequest" );
    $( '#orderEntry' ).val( 'fresh' );
    $( '#order_id' ).val( '' );
    $( '#txtOrderIndex' ).val( '' );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        item_qty: {
          required: !0
        },
        item_size: {
          required: !0
        },
        itemSizeUnitModify: {
          required: !0
        },
        orderModifyRemarks: {
          required: !0
        },

        item_RM_Price: {
          required: !0,
        },
        item_BCJ_Price: {
          required: !0,
        },
        item_Label_Price: {
          required: !0,
        },
        item_Material_Price: {
          required: !0,
        },
        item_LabourConversion_Price: {
          required: !0,
        },

        item_Margin_Price: {
          required: !0,
        },
        item_selling_price: {
          required: !0,
        },
        order_value: {
          required: !0,
        },

        item_RM_Price: {
          required: !0,
        },
       
        inputGroupFile01_PO: {
          required: !0,
        },

        item_BCJ_Price: {
          required: !0,
        },
        item_Label_Price: {
          required: !0,
        },
        item_Material_Price: {
          required: !0,
        },
        item_LabourConversion_Price: {
          required: !0,
        },
        item_Margin_Price: {
          required: !0,
        },
        bulkOrderTypeV1: {
          required: !0,
        },

        f_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
        ,
        f_2: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_3: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_4: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_5: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_6: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_7: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_8: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_9: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_10: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submit"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_qcform", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {
            console.log( resp.order_id );
            $( '#order_id' ).val( resp.order_id );
            $( '#txtOrderIndex' ).val( resp.order_index );

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Order Price part has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                mApp.unblock( "#m_form_add_qcform" );

                window.location.href = BASE_URL + '/v1_getOrderslist'
                // $( '.aj_addmore' ).show();
                // $( '#formLayoutAJ' ).hide();
                // $( '.aj_addmore_save' ).hide();
                // var orderid = $( "input[name=order_id]" ).val();

                // getOrderItemList( orderid );
                // $( '.ajitemTable' ).show();
                // $( '#orderEntry' ).val( 'nextOne' );


              }
            } )

          }
        } ) )
    } )
  }

  var add_qcform = function ()
  {
    var e, r, i = $( "#m_form_add_qcform" );

    $( '#orderEntry' ).val( 'fresh' );
    $( '#order_id' ).val( '' );
    $( '#txtOrderIndex' ).val( '' );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        item_qty: {
          required: !0
        },
        item_size: {
          required: !0
        },
        order_fragrance: {
          required: !0
        },
       

        item_name: {
          required: !0,
        },
        item_selling_price: {
          required: !0,
        },
        brand: {
          required: !0,
        },
        order_type: {
          required: !0,
        },
        order_type_v1: {
          required: !0,
        },

        due_date: {
          required: !0,
        },
        commited_date: {
          required: !0,
        },
        file: {
          required: !0,
        },

        
        bulkOrderTypeV1: {
          required: !0,
        },
        item_batch_mrp_PL: {
          required: !0,
        },
        item_batch_mrp_ml_PL: {
          required: !0,
        },

        f_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
        ,
        f_2: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_3: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_4: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_5: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_6: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_7: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_8: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_9: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_10: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submit"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ),
        mApp.block( "#m_form_add_qcform", {
          overlayColor: "#000000",
          type: "loader",
          state: "success",
          message: "Please wait..."
        } ),
        i.ajaxSubmit( {

          success: function ( resp )
          {
            console.log( resp.order_id );
            $( '#order_id' ).val( resp.order_id );
            $( '#txtOrderIndex' ).val( resp.order_index );

            mApp.unprogress( n ), swal( {
              title: "",
              text: "Order has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                mApp.unblock( "#m_form_add_qcform" );

                //window.location.href = BASE_URL+'/qc-from/list'
                $( '.aj_addmore' ).show();
                $( '#formLayoutAJ' ).hide();
                $( '.aj_addmore_save' ).hide();
                var orderid = $( "input[name=order_id]" ).val();

                getOrderItemList( orderid );
                $( '.ajitemTable' ).show();
                $( '#orderEntry' ).val( 'nextOne' );


              }
            } )

          }
        } ) )
    } )
  }



  var edit_qcform = function ()
  {

    var e, r, i = $( "#m_form_edit_qcform" );

    e = i.validate( {
      ignore: ":hidden",
      rules: {
        item_qty: {
          required: !0
        },
        item_size: {
          required: !0
        },

        item_name: {
          required: !0,
        },
        item_selling_price: {
          required: !0,
        },
        modificationRemarks: {
          required: !0,
        },


        brand: {
          required: !0,
        },
        order_type: {
          required: !0,
        },
        d_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        b_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        l_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        due_date: {
          required: !0,
        },

        f_1: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
        ,
        f_2: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_3: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_4: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_5: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_6: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_7: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_8: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_9: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        },
        f_10: {
          required: function ( element )
          {
            if ( $( '#order_type' ).is( ':checked' ) )
            {
              return !1;

            } else
            {
              return !0;

            }

          }
        }
      },
      invalidHandler: function ( e, r )
      {
        mUtil.scrollTop()
      },
      submitHandler: function ( e ) { }
    } ), ( n = i.find( '[data-wizard-action="submit"]' ) ).on( "click", function ( r )
    {

      r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
        success: function ()
        {
          mApp.unprogress( n ), swal( {
            title: "",
            text: "The QC FOR has been successfully added!",
            type: "success",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
            onClose: function ( e )
            {

              window.location.href = BASE_URL + '/qcform/list'
              //$('.aj_addmore').show();
              //$('#formLayoutAJ').hide();
              //$('.aj_addmore_save').hide();
              // var orderid=$("input[name=order_id]").val();

              // getOrderItemList(orderid);
              //$('.ajitemTable').show();


            }
          } )

        }
      } ) )
    } )
  }





  var demo_lead_edit = function ()
  {
    var e, r, i = $( "#m_form_edit_leads" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        source: {
          required: !0
        },
        name: {
          required: !0
        },

        phone: {
          required: !0,
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
        success: function ( res )
        {

          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The lead has been successfully modified!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/getIndData'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The client alreay added",
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }


  //m_form_add_FAQ

  var demo_add_FAQ = function ()
  {
    var e, r, i = $( "#m_form_add_FAQ" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        txtContentFAQ: {
          required: !0
        },
        txtProductNameFAQ: {
          required: !0
        },
        txtFAQAnswer: {
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "Successfully submitted",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/technical-questions'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "Error !",
              text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }




  var demo_client_add = function ()
  {
    var e, r, i = $( "#m_form_add_client" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company: {
          required: !0
        },
        name: {
          required: !0
        },
        brand: {
          required: !0
        },

        phone: {
          required: !0,
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Lead has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/leads-list'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: res.Message,
              // text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }
  var demo_add_sop= function ()
  {
   
    var e, r, i = $( "#m_form_add_sop" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company: {
          required: !0
        },
        name: {
          required: !0
        },
        brand: {
          required: !0
        },

        phone: {
          required: !0,
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Lead has been successfully added!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/leads-list'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: res.Message,
              // text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }


  //m_form_updateChemistLayout
  var m_form_updateChemistLayoutL = function ()
  {
    var e, r, i = $( "#m_form_updateChemistLayout" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        txtSLimit: {
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Lead has been successfully submitted!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                location.reload( 1 )
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }

  //m_form_updateChemistLayout

  var demo_client_add_sales = function ()
  {
   
    var e, r, i = $( "#m_form_add_client_sales" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company: {
          required: !0
        },
        name: {
          required: !0
        },
        brand: {
          required: !0
        },

        phone: {
          required: !0,
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Lead has been successfully submitted!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/leads-list'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: res.Message,
              // text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }
  var demo_client_add_sales_brand = function ()
  {
 
    var e, r, i = $( "#m_form_add_client_sales_brand" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        next_brand: {
          required: !0
        }
       
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
    } ), ( n = i.find( '[data-wizard-action="submitBrand"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Lead has been successfully submitted!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/leads-list'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: res.Message,
              // text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }

  var demo_orderEDITREQ = function ()
  {
    var e, r, i = $( "#m_orderEDITREQ" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        orderReqType: {
          required: !0
        },

        txtRemarkEDITREQ: {
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
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The  has been successfully submitted!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/v1_getOrderslist'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: res.status,
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }


  //incentive apply table 
  var DatatablesBasicPaginationsIncentiveApply = {
    init: function ()
    {

      $( "#m_table_1_IncentiveApply" ).DataTable( {
        responsive: !0,
        pagingType: "full_numbers",
        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, e, n, t )
          {
            return ''
          }
        }

        ]
      } )
    },
    initA: function ()
    {

      $( "#m_table_1_incetiveDetailViewDataDT" ).DataTable( {
        responsive: !0,
        pagingType: "full_numbers",
        columnDefs: [ {
          targets: -1,
          title: "ActionsS",
          orderable: !1,
          render: function ( a, e, n, t )
          {
            return '5'
          }
        }

        ]
      } )
    },
    initA: function ()
    {



      var formData = {
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
      };
      $.ajax( {
        url: BASE_URL + '/getIncentiveAppliedUsed',
        type: 'GET',
        data: formData,
        success: function ( res )
        {

          var result = res.data;
          $.each( result, function ( index, value )
          {
            //console.log('My array has at position ' + index + ', this value: ' + value.user_id);
            var myID = '#m_table_SalesIncentive_' + value.id;

            $( myID ).DataTable( {
              responsive: !0,
              pagingType: "full_numbers",
              "order": [ [ 1, "desc" ] ],
              columnDefs: [
                {
                  targets: [ 0 ],
                  visible: !1
                },


              ]
            } );


          } );







        }
      } );

    },
    initBRND: function ()
    {



      var formData = {
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
      };
      $.ajax( {
        url: BASE_URL + '/getIncentiveAppliedUsedRND',
        type: 'GET',
        data: formData,
        success: function ( res )
        {

          var result = res.data;
          $.each( result, function ( index, value )
          {
            //console.log('My array has at position ' + index + ', this value: ' + value.user_id);
            var myID = '#m_table_RNDIncentive_' + value.id;

            $( myID ).DataTable( {
              responsive: !0,
              pagingType: "full_numbers",
              "order": [],
              columnDefs: [



              ]
            } );


          } );







        }
      } );

    },
    // m_table_RNDIncentive_

  };
  jQuery( document ).ready( function ()
  {
    DatatablesBasicPaginationsIncentiveApply.init();
    DatatablesBasicPaginationsIncentiveApply.initA();
    DatatablesBasicPaginationsIncentiveApply.initBRND();

  } );





  //incentive apply table 

  //incentive Apply
  var demo_incetiveApply = function ()
  {
    var e, r, i = $( "#m_form_3_INCENTIVEAPPLY" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        usrid: {
          required: !0
        },
        incentiveType: {
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
    } ), ( n = i.find( '[data-wizard-action="submitIncentiveApply"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The incentive has been successfully applied!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL + '/payment-confirmation-request'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "opps!!",
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }

  //incentive Apply

  // payreq
  var demo_client_addPAYREQ = function ()
  {
    var e, r, i = $( "#m_form_3PaymentRequest" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        client_select: {
          required: !0
        },
        pay_date_recieved: {
          required: !0
        },
        payAmt: {
          required: !0
        },
        paytype_id: {
          required: !0
        },

        bank_name: {
          required: !0
        },
        payment_for: {
          required: !0
        },
        order_destination: {
          required: !0
        },
        vLogistic: {
          required: !1
        },
        termsDelivery: {
          required: !0
        },
        Vno_of_cartons: {
          required: !0
        },
        paid_by: {
          required: !0
        },
        paid_by: {
          required: !0
        },
        Vno_of_unit: {
          required: !0
        },
        txtShippingCharge: {
          required: !0
        }
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
    } ), ( n = i.find( '[data-wizard-action="submitPAY"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
        success: function ( res )
        {
          console.log( res );
          if ( res.status == 1 )
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "The Payment has been successfully submitted!",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                window.location.href = BASE_URL + '/payment-confirmation-request'
              }
            } )
          } else
          {
            mApp.unprogress( n ), swal( {
              title: "",
              text: "opps!!",
              type: "error",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                //window.location.href = BASE_URL+'/client'
              }
            } )
          }


        }
      } ) )
    } )
  }


  // payreq


  var demo = function ()
  {





    //add vendor code too here now
    var e, r, i = $( "#m_form_add_vendors" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        vendor_name: {
          required: !0
        },
        name: {
          required: !0
        },

        phone: {
          required: !0,
        },
        address: {
          required: !0,
        },
        location: {
          required: !0,
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
            text: "The Vendor has been successfully added!",
            type: "success",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
            onClose: function ( e )
            {
              // window.location.href = BASE_URL+'/vendors'
            }
          } )

        }
      } ) )
    } )

    //add vendor code too here now




    var datatable = $( '.m_client_list' ).mDatatable( {
      // datasource definition
      data: {
        type: 'remote',

        source: {
          read: {
            url: BASE_URL + '/',
            params: {
              'user_id': UID,
              '_token': _TOKEN,
              headers: {
                '_token': 'BO-INTL'
              }
            },
            map: function ( raw )
            {
              // sample data mapping
              var dataSet = raw;
              if ( typeof raw.data !== 'undefined' )
              {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
        orderable: !0,
      },

      // layout definition
      layout: {
        scroll: false,
        footer: false
      },

      // column sorting
      sortable: true,

      pagination: true,

      toolbar: {
        // toolbar items
        items: {
          // pagination
          pagination: {
            // page size select
            pageSizeSelect: [ 10, 20, 30, 50, 100 ],
          },
        },
      },

      search: {
        input: $( '#generalSearch' ),
      },

      // columns definition
      columns: [
        {
          field: 'index_id',
          title: '#',
          sortable: false, // disable sort for this column
          width: 40,
          selector: false,
          textAlign: 'center',
        }, {
          field: 'company',
          title: 'Company',
          // sortable: 'asc', // default sort
          filterable: false, // disable or enable filtering
          width: 100,
          template: '{{company}} ({{brand}})',

        }, {
          field: 'created_on',
          title: 'Created On',
          width: 100,
        }, {
          field: 'created_by',
          title: 'Added By'
        }, {
          field: 'phone',
          title: 'Phone',
          width: 80,
        },
        {
          field: 'location',
          title: 'Location',
          width: 150,
        },
        {
          field: 'Actions',
          width: 110,
          title: 'Actions',
          sortable: false,
          overflow: 'visible',
          template: function ( row, index, datatable )
          {

            var rowid = row.rowid;
            var dropup = ( datatable.getPageSize() - index ) <= 4 ? 'dropup' : '';
            return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
                                <i class="la la-ellipsis-h"></i>\
                            </a>\
						  	<div class="dropdown-menu dropdown-menu-right">\
						    	<a class="dropdown-item"  onclick="view_client('+ rowid + ')"   href="javascript::void(0)"><i class="la la-edit"></i> View Details</a>\
						    	<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Last Activity</a>\
						    	\
						  	</div>\
						</div>\
						<a href="javascript::void(0)" onclick="edit_client('+ rowid + ')"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript::void(0)"  onclick="delete_client('+ rowid + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
          },
        } ],
    } );

    $( '#m_form_status' ).on( 'change', function ()
    {
      datatable.search( $( this ).val(), 'Status' );
    } );

    $( '#m_form_type' ).on( 'change', function ()
    {
      datatable.search( $( this ).val(), 'Type' );
    } );

    $( '#m_form_status, #m_form_type' ).selectpicker();

  };

  return {
    // public functions
    init: function ()
    {
     
      demo();
      demo_client_add();
      demo_add_sop();
      demo_client_add_sales();
      demo_client_add_sales_brand();
      m_form_updateChemistLayoutL();
      demo_orderEDITREQ();
      demo_add_FAQ();
      demo_lead_edit();
      add_qcform();
      add_qcform_modifyRequest();
      edit_qcform();
      demo_client_addPAYREQ();
      demo_incetiveApply();



    },
  };
}();

jQuery( document ).ready( function ()
{
  AjaxClientsList.init();
  AjaxRND.init();
  AjaxRND_AddBrand.init();
  AjaxRND_FINISH_CAT.init();
  AjaxRND_FINISH_CAT_F.init();
  DatatablesQuatationDataList.init();

} );

//delete client
function delete_client( rowid )
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
        url: BASE_URL + "/softdeleteClient",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), userId: rowid },
        success: function ( resp )
        {
          console.log( resp );
          if ( resp.status == 0 )
          {
            swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your sample has been deleted.", "success" ).then( function ( eyz )
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

// delete_client_note
function delete_client_note( rowid )
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
        url: BASE_URL + "/delete.note",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid },
        success: function ( resp )
        {
          console.log( resp );
          if ( resp.status == 0 )
          {
            swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your sample has been deleted.", "success" ).then( function ( eyz )
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

// delete_client_note

//delete client
//edit_client
function edit_client( rowid )
{
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getClientDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#name' ).val( res.name );
      $( '#email' ).val( res.email );
      $( '#phone' ).val( res.phone );
      $( '#company' ).val( res.company );
      $( '#brand' ).val( res.brand );
      $( '#gst' ).val( res.gst );
      $( '#address' ).val( res.address );
      $( '#edit_rowid' ).val( rowid );
      $( '#m_modal_edit_client' ).modal( 'show' );

    }
  } );



}
//edit_client

//view client
function view_client( rowid )
{
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getClientDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#vm_userid' ).html( res.id );
      $( '#vm_name' ).html( res.name );
      $( '#vm_phone' ).html( res.phone );
      $( '#vm_email' ).html( res.email );
      $( '#vm_company' ).html( res.company );
      $( '#vm_brand' ).html( res.brand_name );
      $( '#vm_address' ).html( res.address );
      $( '#vm_gst' ).html( res.gst_details );
      $( '#vm_remarks' ).html( res.remarks );
      $( '#m_modal_views_client' ).modal( 'show' );
    }
  } );
}

//datagrid Client list //m_table_clientList_todayFollow
var TodayClientFolloup = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_clientList_todayFollow" ).DataTable( {
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

          url: BASE_URL + '/getClientsListTodayFUP',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company", "name", "created_on", "created_by", "phone", "location", "Status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "location"
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
                    title: "RAW",
                    class: "m-badge--brand"
                  },
                  2: {
                    title: "LEAD",
                    class: " m-badge--metal"
                  },
                  3: {
                    title: "QUALIFIED",
                    class: " m-badge--primary"
                  },
                  4: {
                    title: "SAMPLING",
                    class: " m-badge--success"
                  },
                  5: {
                    title: "CUSTOMER",
                    class: " m-badge--info"
                  },
                  6: {
                    title: "LOST",
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

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';



            return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a>

                          <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
                           title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-delete"></i>
                                                      </a>


                                                      <a href="${ sample_URL }"
                           title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="
                                                      flaticon-box "></i>
                                                      </a>
                                                      <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
                           title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-chat "></i>
                                                      </a>
                                                      `
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "RAW",
                class: "m-badge--brand"
              },
              2: {
                title: "LEAD",
                class: " m-badge--metal"
              },
              3: {
                title: "QUALIFIED",
                class: " m-badge--primary"
              },
              4: {
                title: "SAMPLING",
                class: " m-badge--success"
              },
              5: {
                title: "CUSTOMER",
                class: " m-badge--info"
              },
              6: {
                title: "LOST",
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
// DelayedClientFolloup
var DelayedClientFolloup = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_clientList_delayedFollow" ).DataTable( {
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

          url: BASE_URL + '/getClientsListDelayFUP',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company", "name", "created_on", "created_by", "phone", "location", "Status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "location"
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
                    title: "RAW",
                    class: "m-badge--brand"
                  },
                  2: {
                    title: "LEAD",
                    class: " m-badge--metal"
                  },
                  3: {
                    title: "QUALIFIED",
                    class: " m-badge--primary"
                  },
                  4: {
                    title: "SAMPLING",
                    class: " m-badge--success"
                  },
                  5: {
                    title: "CUSTOMER",
                    class: " m-badge--info"
                  },
                  6: {
                    title: "LOST",
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

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';



            return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a>

                          <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
                           title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-delete"></i>
                                                      </a>


                                                      <a href="${ sample_URL }"
                           title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="
                                                      flaticon-box "></i>
                                                      </a>
                                                      <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
                           title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-chat "></i>
                                                      </a>
                                                      `
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "RAW",
                class: "m-badge--brand"
              },
              2: {
                title: "LEAD",
                class: " m-badge--metal"
              },
              3: {
                title: "QUALIFIED",
                class: " m-badge--primary"
              },
              4: {
                title: "SAMPLING",
                class: " m-badge--success"
              },
              5: {
                title: "CUSTOMER",
                class: " m-badge--info"
              },
              6: {
                title: "LOST",
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
// DelayedClientFolloup
//yestarday
//datagrid Client list //m_table_clientList_todayFollow
var YestardayClientFolloup = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_clientList_yestardayFollow" ).DataTable( {
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

          url: BASE_URL + '/getClientsListYestardayFUP',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company", "name", "created_on", "created_by", "phone", "location", "Status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "location"
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
                    title: "RAW",
                    class: "m-badge--brand"
                  },
                  2: {
                    title: "LEAD",
                    class: " m-badge--metal"
                  },
                  3: {
                    title: "QUALIFIED",
                    class: " m-badge--primary"
                  },
                  4: {
                    title: "SAMPLING",
                    class: " m-badge--success"
                  },
                  5: {
                    title: "CUSTOMER",
                    class: " m-badge--info"
                  },
                  6: {
                    title: "LOST",
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

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';



            return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a>

                          <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
                           title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-delete"></i>
                                                      </a>


                                                      <a href="${ sample_URL }"
                           title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="
                                                      flaticon-box "></i>
                                                      </a>
                                                      <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
                           title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="flaticon-chat "></i>
                                                      </a>
                                                      `
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "RAW",
                class: "m-badge--brand"
              },
              2: {
                title: "LEAD",
                class: " m-badge--metal"
              },
              3: {
                title: "QUALIFIED",
                class: " m-badge--primary"
              },
              4: {
                title: "SAMPLING",
                class: " m-badge--success"
              },
              5: {
                title: "CUSTOMER",
                class: " m-badge--info"
              },
              6: {
                title: "LOST",
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
//yestarday


//sales lead
var DatatablesLeadList_SALES_END = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADListSALES_END" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_SALES_END',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", 'current_stage_id', 'st_id', "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "COUNTRY_ISO",
              "COUNTRY_FLAG",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "st_name"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },


          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {


              return `<a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">
                 ${ e.st_name }               
                 </a>
                

                 `;
            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              //LeadSampleAddModelSalesA

              if ( _UNIB_RIGHT == 'Intern' || _UNIB_RIGHT == 'SalesUser' || _UNIB_RIGHT == 'SalesHead' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
                sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';

                addToMyLead = BASE_URL + '/add_to_myLead/' + e.QUERY_ID + '';
                sample_URL = "#";
                sample_URL_LEAD = "#";
                var HTML = "";
                /*
                 <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                     <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                     <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Mark Irrelevant" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa flaticon-paper-plane-1"></i>
                  </a>
                   <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="fa fa-phone-square"></i>
                </a>

                */
                if ( e.st_name == 'Sampling' || e.st_name == 'Negotiation' || e.st_name == 'Converted' )
                {
                  HTML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                   
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  
                  <a style="margin-top:5px" href="javascript::void(0)" onclick="LeadSampleAddModelSales(${ e.QUERY_ID })"   title="Add Samples" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>
                <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>

                    `;

                  HTML += ` <a style="margin-top:5px" href="${ addToMyLead }"  title="Add TO My Lead " class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-plus"></i>
                    </a>`
                  return HTML;

                } else
                {
                  return `  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-edit"></i>
            </a>
            <a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadNoResponseModelSales(${ e.QUERY_ID })" title="No Response" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="flaticon-profile-1"></i>
                </a>
                
                  
               
                <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
                
               


                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                 
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  <a style="margin-top:5px" href="${ sendQutationURL }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-email"></i>
                </a>
               

                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              // return e.LEAD_TYPE;

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>                
                 
                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {
              switch ( e.lead_status )
              {
                case 4:
                  // code block
                  var lead_M = `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">DQ</span>`
                  break;

                default:
                  if ( e.st_name == 'Lost' )
                  {
                    var lead_M = '......';;
                  }
                  else if ( e.st_name == 'Assigned' )
                  {
                    var lead_M = '.';
                  }
                  else if ( e.st_name == 'Sampling' )
                  {
                    var lead_M = '...';
                  }
                  else if ( e.st_name == 'Qualified' )
                  {
                    var lead_M = '..';
                  }
                  else if ( e.st_name == 'Repeat Client' )
                  {
                    var lead_M = '.....';;
                  }
                  else if ( e.st_name == 'Client' )
                  {
                    var lead_M = '....';
                  }
                  else
                  {
                    var lead_M = e.QUERY_ID;
                  }

                // code block
              }

              if ( e.current_stage_id == 88 )
              {
                var NORes = `<span class="m-badge m-badge--warning m-badge--wide">No Response</span>`;
              } else
              {
                var NORes = "";
              }
              return e.LEAD_TYPE + `<br> <strong> ${ e.AssignName }</strong>
              ${ lead_M }
              ${ NORes }





              
              `
            }

          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 40 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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

//LeadSendQuatation
function LeadSendQuatation( rowid )
{
  $( '#m_modal_4_sendQuation_view' ).modal( 'show' );


}
//LeadSendQuatation
//sales lead
// m_table_LEADList_LMLAYOUT
var DatatablesLeadList_LMLAYOUT = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
        responsive: !0,
        dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_LMLayout',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "COUNTRY_ISO",
              "COUNTRY_FLAG",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "SENDERNAME"
          },
          {
            data: "MOB"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "ENQ_MESSAGE"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                  ${ e.st_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';

                //------------------
                if ( UID == 3 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>

                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return e.MOB;


            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                  <span class="m-widget5__info-label">
                   <strong> ${ e.AssignName }</strong>
                  </span>
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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
//DatatablesLeadListAvailabe_ALLVIEW
function viewLeadByFilerLoad()
{


  var buttonCommonLeadVerifed = {
    exportOptions: {
      format: {
        body: function ( data, row, column, node )
        {

          if ( UID == 1 )
          {


            if ( column === 4 )
            {
              return ``;
            } else
            {
              return data;
            }



          } else
          {
            alert( '!Failed' );
          }

        }
      }
    }
  };


  var a;
  var checkVal = parseInt( $( 'input[name="filterLeadMe"]:checked' ).val() );

  var URL_LINK = "";
  if ( UID == 1 || UID == 90 || UID == 156 || UID == 171 )
  {
    URL_LINK = BASE_URL + '/getAvaibleLeadListViewAllAdmin';
  } else
  {
    URL_LINK = BASE_URL + '/getAvaibleLeadListViewAll';
  }

  $( "#m_table_LEADListAvaible_AllView" ).dataTable().fnDestroy()

  a = $( "#m_table_LEADListAvaible_AllView" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 100 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    dom: 'Blfrtip',
    buttons: [

      $.extend( true, {}, buttonCommonLeadVerifed, {
        extend: 'excelHtml5'
      } )

    ],
    ajax: {

      url: URL_LINK,
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_status",
          'SENDEREMAIL',
          "st_name",
          "QTYPE",

          "tags_name",
          "email_sent",
          "sms_sent",
          "verified",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'checkVal': checkVal
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "verified"
      },
      {
        data: "QTYPE"
      },
      {
        data: "tags_name"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.verified )
          {
            case 0:
              day = `Fresh`
              break;
            case 1:
              day = `Verified`
              break;

          }


          return day;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 1 || UID == 90 || UID == 156 || UID == 171 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
            if ( e.email_sent )
            {
              var emailV = '<a href="javascript::void(0)" title="EMAIL SENT on This lead"><span  class="m-badge m-badge--success m-badge--dot"></span></a>';

            } else
            {
              var emailV = '';

            }
            if ( e.sms_sent )
            {
              var smsV = '<a href="javascript::void(0)" title ="SMS SENT on this lead"><span  class="m-badge m-badge--primary m-badge--dot"></span></a>';

            } else
            {
              var smsV = '';

            }


            /*
             <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>

                       <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
               <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
               <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
               <i class="fa fa-hand-rock"></i>

                   
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Claim Lead</a>
             
              

              </div></span>
            */

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartDataALL(${ e.QUERY_ID })" title="View all Data" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-eye"></i>
                        </a>
                       
                        <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAssignModel(${ e.QUERY_ID })" title="Claim Lead" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-hand-pointer-o"></i>
                        </a>

                   
                <span style="margin-top:5px" class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                ${ sourceAPI }
                </span>
               
                ${ emailV }
                ${ smsV }

                `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `${ e.GLUSR_USR_COMPANYNAME }
            ,
            ${ e.SENDERNAME } `;
          // return `

          //     <div class="m-widget5__info">
          //     <span class="m-widget5__info-label">
          //       ${ e.GLUSR_USR_COMPANYNAME }
          //     </span>
          //     <br>
          //     <span class="m-widget5__info-date m--font-info">
          //     ${ e.SENDERNAME } 
          //     </span>                 
          //   </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {


          return `${ e.ENQ_CITY },${ e.ENQ_STATE }`



          // return `<div class="m-widget5__info">
          //     <span class="m-widget5__info-label">
          //       ${ e.ENQ_CITY }
          //     </span>
          //     <br>
          //     <span class="m-widget5__primary-date m--font-primary">
          //     ${ e.ENQ_STATE }
          //     </span>

          //   </div>`
        }
      },


      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == '5SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }

          return ` ${ e.created_at }`

          // return `<div class="m-widget5__info">
          //     <span class="m-widget5__info-label">
          //       <span class="m-badge m-badge--info"> ${ iconD }</span>
          //       <br>
          //       ${ e.created_at }

          //     </span>

          //   </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          return e.QTYPE;
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                        <a href="javascript::void(0)" onclick="viewAllINDMartDataALL(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                        </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
          }




        }
      },



    ]
  } ), $( "#m_searchAS" ).on( "click", function ( t )
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
  } ), $( "#m_resetAS" ).on( "click", function ( t )
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
//DatatablesLeadListAvailabe_ALLVIEW
//m_table_ticketv2_AllView
var DatatablesTickettListAvailabe_ALLVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {



      var a;
      var checkVal = parseInt( $( 'input[name="filterLeadMe"]:checked' ).val() );

      var URL_LINK = "";
     
      URL_LINK = BASE_URL + '/getAvaibleTicketListViewAll';

      a = $( "#m_table_ticketv2_AllView" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: URL_LINK,
          type: "GET",
          data: {
            columnsDef: [
              "RecordID",
              "ticket_type_name",
              "brand_name",
              "order_id",
              "created_at",
              "created_name", 
              "ticket_cm_typeName",
              "priority_id",
              "status",             
              "agoTime",             
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'checkVal': checkVal
          }
        },
        columns: [

          {
            data: "RecordID"
          },
          {
            data: "ticket_type_name"
          },
          {
            data: "brand_name"
          },
          {
            data: "created_at"
          },
          {
            data: "created_name"
          },
          {
            data: "ticket_cm_typeName"
          },
          {
            data: "priority_id"
          },
          {
            data: "status"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

         
    {
      targets: 6,
      render: function ( a, t, e, n )
      {
        var i = {
          1: {
            title: "NORMAL",
            class: "m-badge--seconday"
          },
          2: {
            title: "HIGH",
            class: " m-badge--danger"
          },
          3: {
            title: "MODERATE",
            class: " m-badge--warning"
          },


        };
        return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleJInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
      }
    },
    {
      targets: 7,
      render: function ( a, t, e, n )
      {
        var i = {
          1: {
            title: "OPEN",
            class: "m-badge--primary"
          },
          2: {
            title: "PROCESSING",
            class: " m-badge--warning"
          },
          3: {
            title: "COMPLETED",
            class: " m-badge--success"
          }
         


        };
        return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="TicketResponseSd(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
      }
    },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

             

            
               
               

                return `<a href="javascript::void(0)"  onclick="viewAllTicketDataALL(${ e.RecordID })" title="View all Data" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                         
                          <a style="margin-top:5px" href="javascript::void(0)"  onclick="TicketUpdateModel(${ e.RecordID })" title="Claim Lead" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-hand-pointer-o"></i>
                          </a>

                     
                  <span style="margin-top:5px" class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                ${e.agoTime} updated
                  </span>
                 
                 
                  `
              


            }
          },
         
         


       
         
        



        ]
      } ), $( "#m_searchAS" ).on( "click", function ( t )
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
      } ), $( "#m_resetAS" ).on( "click", function ( t )
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

//m_table_ticketv2_AllView


//m_table_LEADListAvaible_AllView
var DatatablesLeadListAvailabe_ALLVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {

      var buttonCommonLeadVerifedA = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {

              if ( UID == 1 )
              {


                if ( column === 4 )
                {
                  return ``;
                } else
                {
                  return data;
                }



              } else
              {
                alert( '!Failed' );
              }

            }
          }
        }
      };


      var a;
      var checkVal = parseInt( $( 'input[name="filterLeadMe"]:checked' ).val() );

      var URL_LINK = "";
      if ( UID == 1 || UID == 90 || UID == 156 || UID == 171 )
      {
        URL_LINK = BASE_URL + '/getAvaibleLeadListViewAllAdmin';
      } else
      {
        URL_LINK = BASE_URL + '/getAvaibleLeadListViewAll';
      }


      a = $( "#m_table_LEADListAvaible_AllView" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonLeadVerifedA, {
            extend: 'excelHtml5'
          } )

        ],
        ajax: {

          url: URL_LINK,
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_status",
              'SENDEREMAIL',
              "st_name",
              "QTYPE",

              "tags_name",
              "email_sent",
              "sms_sent",
              "verified",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'checkVal': checkVal
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "verified"
          },
          {
            data: "QTYPE"
          },
          {
            data: "tags_name"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.verified )
              {
                case 0:
                  day = `Fresh`
                  break;
                case 1:
                  day = `Verified`
                  break;

              }


              return day;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case 'INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 1 || UID == 90 || UID == 156 || UID == 171 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
                if ( e.email_sent )
                {
                  var emailV = '<a href="javascript::void(0)" title="EMAIL SENT on This lead"><span  class="m-badge m-badge--success m-badge--dot"></span></a>';

                } else
                {
                  var emailV = '';

                }
                if ( e.sms_sent )
                {
                  var smsV = '<a href="javascript::void(0)" title ="SMS SENT on this lead"><span  class="m-badge m-badge--primary m-badge--dot"></span></a>';

                } else
                {
                  var smsV = '';

                }


                /*
                 <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>

                           <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                   <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                   <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
                   <i class="fa fa-hand-rock"></i>

                       
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Claim Lead</a>
                 
                  

                  </div></span>
                */

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartDataALL(${ e.QUERY_ID })" title="View all Data" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                         
                          <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAssignModel(${ e.QUERY_ID })" title="Claim Lead" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-hand-pointer-o"></i>
                          </a>

                     
                  <span style="margin-top:5px" class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                 
                  ${ emailV }
                  ${ smsV }

                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `${ e.GLUSR_USR_COMPANYNAME }
              ,
              ${ e.SENDERNAME } `;
              // return `

              //     <div class="m-widget5__info">
              //     <span class="m-widget5__info-label">
              //       ${ e.GLUSR_USR_COMPANYNAME }
              //     </span>
              //     <br>
              //     <span class="m-widget5__info-date m--font-info">
              //     ${ e.SENDERNAME } 
              //     </span>                 
              //   </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {


              return `${ e.ENQ_CITY },${ e.ENQ_STATE }`



              // return `<div class="m-widget5__info">
              //     <span class="m-widget5__info-label">
              //       ${ e.ENQ_CITY }
              //     </span>
              //     <br>
              //     <span class="m-widget5__primary-date m--font-primary">
              //     ${ e.ENQ_STATE }
              //     </span>

              //   </div>`
            }
          },


          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == '5SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return ` ${ e.created_at }`

              // return `<div class="m-widget5__info">
              //     <span class="m-widget5__info-label">
              //       <span class="m-badge m-badge--info"> ${ iconD }</span>
              //       <br>
              //       ${ e.created_at }

              //     </span>

              //   </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {
              return e.QTYPE;
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartDataALL(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
              }




            }
          },



        ]
      } ), $( "#m_searchAS" ).on( "click", function ( t )
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
      } ), $( "#m_resetAS" ).on( "click", function ( t )
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

//m_table_LEADListAvaible_AllView

// m_table_LEADList_LMLAYOUT
// m_table_LEADList_AllView
var DatatablesLeadList_ALLVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_AllView" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadListViewAll',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "COUNTRY_ISO",
              "COUNTRY_FLAG",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeaFdStage(${ e.QUERY_ID })">

                  ${ e.st_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';

                //------------------
                if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartDataALL(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                         
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>



                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                  <span class="m-widget5__info-label">
                   <strong> ${ e.AssignName }</strong>
                  </span>
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartDataALL(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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


$( "input[name='filterLeadMe']" ).click( function ()
{

  var checkVal = parseInt( $( 'input[name="filterLeadMe"]:checked' ).val() );

  switch ( checkVal )
  {
    case 1:
      // code block









      break;
    case 2:
      // code block



      viewLeadByFilerLoad();

      break;
    case 3:
      // code block

      viewLeadByFilerLoad();

      break;

  }


} );




//m_table_LEADList_LeadMangerVIEWExport
var DatatablesLeadList_LeadMangerExport = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_LeadMangerVIEWExport" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_LeadManger_VIEW_Export',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",

              "lead_status",
              'SENDEREMAIL',
              "st_name",
              "QTYPE",
              "LEAD_TYPE",

              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {
              day = "";
              switch ( e.lead_status )
              {
                case 0:
                  day = "Fresh Lead";
                  break;
                case 1:
                  day = "Irrelevant";
                  break;
                case 4:
                  day = "Unqualified";
                  break;
                case 55:
                  day = "HOLD";
                  break;

              }

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                   ${ day }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case ' INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }

              if ( _UNIB_RIGHT == 'SalesUser' && UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


                //------------------
                if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>


                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
                  
                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME } 
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.LEAD_TYPE )
              {
                case 'IN':
                  DataFrom = "INDIA";
                  break;
                case 'India':
                  DataFrom = "INDIA";
                  break;

                default:
                  DataFrom = "FOREIGN";
                  break;
              }

              return DataFrom;
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ e.QTYPE }</span>
                    ${ e.created_at }<br>

                  </span>
                 
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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

//m_table_LEADList_LeadMangerVIEWExport

//m_table_LEADList_LeadMangerVIEW_ASSIGN_CLAIM
var DatatablesLeadList_LeadManger_ASSIGNCLAIM = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_LeadMangerVIEW_ASSIGN_CLAIM" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_LeadManger_VIEW_WPB_claimAssined',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",

              "lead_status",
              'SENDEREMAIL',
              'AssignName',

              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "email_sent",
              "sms_sent",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {
              // day = "";
              // switch ( e.lead_status )
              // {
              //   case 0:
              //     day = "Fresh Lead";
              //     break;
              //   case 1:
              //     day = "Irrelevant";
              //     break;
              //   case 2:
              //     day = "Assigned";
              //     break;
              //   case 4:
              //     day = "Unqualified";
              //     break;
              //   case 55:
              //     day = "HOLD";
              //     break;

              // }

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                   ${ e.lead_stage_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case 'INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;
                case 'INDMART-9811098426@API_5':
                  sourceAPI = "IM3";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


                //------------------
                if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  


                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>


                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
                if ( e.email_sent )
                {
                  var emailV = '<a href="javascript::void(0)" title="EMAIL SENT"><span  class="m-badge m-badge--success m-badge--dot"></span></a>';

                } else
                {
                  var emailV = '';

                }
                if ( e.sms_sent )
                {
                  var smsV = '<a href="javascript::void(0)" title ="SMS SENT"><span  class="m-badge m-badge--primary m-badge--dot"></span></a>';

                } else
                {
                  var smsV = '';

                }




                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>

                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>

                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-hand-point-up"></i>
                  </a>

                  ${ emailV }
                  ${ smsV }
                  `

              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME } 
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.LEAD_TYPE )
              {
                case 'IN':
                  DataFrom = "INDIA";
                  break;
                case 'India':
                  DataFrom = "INDIA";
                  break;

                default:
                  DataFrom = "FOREIGN";
                  break;
              }

              return DataFrom + " <br><b>" + e.AssignName + "</b>"
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                 
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
              }




            }
          },



        ]
      } ), $( "#m_searchAK" ).on( "click", function ( t )
      {
        t.preventDefault();
        var e = {};
        $( ".m-inputA" ).each( function ()
        {
          var a = $( this ).data( "col-index" );
          e[ a ] ? e[ a ] += "|" + $( this ).val() : e[ a ] = $( this ).val()
        } ), $.each( e, function ( t, e )
        {
          a.column( t ).search( e || "", !1, !1 )
        } ), a.table().draw()
      } ), $( "#m_resetAK" ).on( "click", function ( t )
      {
        t.preventDefault(), $( ".m-inputA" ).each( function ()
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

//m_table_LEADList_LeadMangerVIEW_ASSIGN_CLAIM

// m_table_LEADList_LeadMangerVIEW_Intern
var m_table_LEADList_LeadMangerVIEW_Intern = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_LeadMangerVIEW_Intern" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_LeadManger_VIEW_WPB_Intern',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",

              "lead_status",
              'SENDEREMAIL',

              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "email_sent",
              "sms_sent",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {
              day = "";
              switch ( e.lead_status )
              {
                case 0:
                  day = "Fresh Lead";
                  break;
                case 1:
                  day = "Irrelevant";
                  break;
                case 4:
                  day = "Unqualified";
                  break;
                case 55:
                  day = "HOLD";
                  break;

              }

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                   ${ day }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case 'INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;
                case 'INDMART-9811098426@API_5':
                  sourceAPI = "IM3";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }


              var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
              view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
              sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
              if ( e.email_sent )
              {
                var emailV = '<a href="javascript::void(0)" title="EMAIL SENT"><span  class="m-badge m-badge--success m-badge--dot"></span></a>';

              } else
              {
                var emailV = '';

              }
              if ( e.sms_sent )
              {
                var smsV = '<a href="javascript::void(0)" title ="SMS SENT"><span  class="m-badge m-badge--primary m-badge--dot"></span></a>';

              } else
              {
                var smsV = '';

              }




              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  

                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>

                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-hand-point-up"></i>
                  </a>

                  ${ emailV }
                  ${ smsV }
                  `




            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME } 
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.LEAD_TYPE )
              {
                case 'IN':
                  DataFrom = "INDIA";
                  break;
                case 'India':
                  DataFrom = "INDIA";
                  break;

                default:
                  DataFrom = "FOREIGN";
                  break;
              }

              return DataFrom;
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                 
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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

// m_table_LEADList_LeadMangerVIEW_Intern
//m_table_LEADList_LeadMangerVIEW
var DatatablesLeadList_LeadManger = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_LeadManger_VIEW_WPB',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "intern_user_id", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",

              "lead_status",
              'SENDEREMAIL',

              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "email_sent",
              "sms_sent",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {
              day = "";
              switch ( e.lead_status )
              {
                case 0:
                  day = "Fresh Lead";
                  break;
                case 1:
                  day = "Irrelevant";
                  break;
                case 4:
                  day = "Unqualified";
                  break;
                case 55:
                  day = "HOLD";
                  break;

              }

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                   ${ day }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case 'INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;
                case 'INDMART-9811098426@API_5':
                  sourceAPI = "IM3";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


                //------------------
                if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  


                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>


                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
                if ( e.email_sent )
                {
                  var emailV = '<a href="javascript::void(0)" title="EMAIL SENT"><span  class="m-badge m-badge--success m-badge--dot"></span></a>';

                } else
                {
                  var emailV = '';

                }
                if ( e.sms_sent )
                {
                  var smsV = '<a href="javascript::void(0)" title ="SMS SENT"><span  class="m-badge m-badge--primary m-badge--dot"></span></a>';

                } else
                {
                  var smsV = '';

                }

                if ( e.intern_user_id == null )
                {
                  var internStr = "";
                } else
                {
                  var internStr = e.intern_user_id;
                }


                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>

                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>

                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-hand-point-up"></i>
                  </a>

                  ${ emailV }
                  ${ smsV }
                
                  `

              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME } 
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.LEAD_TYPE )
              {
                case 'IN':
                  DataFrom = "INDIA";
                  break;
                case 'India':
                  DataFrom = "INDIA";
                  break;

                default:
                  DataFrom = "FOREIGN";
                  break;
              }

              return DataFrom;
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                 
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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
//m_table_LEADList_LeadMangerVIEW

//LEAD ADMIN VIEW 
var DatatablesLeadList_ADMIN = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList_ADMINVIEW" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList_ADMIN_VIEW_W',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "SUBJECT", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",

              "lead_status",

              "st_name",
              "QTYPE",
              "LEAD_TYPE",

              "data_source",

              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {
              day = "";
              switch ( e.lead_status )
              {
                case 0:
                  day = "Fresh Lead";
                  break;
                case 1:
                  day = "Irrelevant";
                  break;
                case 4:
                  day = "Unqualified";
                  break;
                case 55:
                  day = "HOLD";
                  break;

              }

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                   ${ day }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var sourceAPI = "";
              switch ( e.data_source )
              {
                case 'INDMART-9999955922@API_1':
                  sourceAPI = "IM1";
                  break;
                case 'INDMART-8929503295@API_2':
                  sourceAPI = "IM2";
                  break;

                case 'TRADEINDIA-8850185@API_3':
                  sourceAPI = "TD1";
                  break;
                case 'INHOUSE-ENTRY':
                  sourceAPI = "IN-H";
                  break;

              }

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


                //------------------
                if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>


                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ sourceAPI }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              switch ( e.LEAD_TYPE )
              {
                case 'IN':
                  DataFrom = "INDIA";
                  break;
                case 'India':
                  DataFrom = "INDIA";
                  break;

                default:
                  DataFrom = "FOREIGN";
                  break;
              }

              return DataFrom;
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                 
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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
//LEAD ADMIN VIEW

// m_table_LEADList_AllView
//lead
var DatatablesLeadList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "st_name",
              "QTYPE",
              "LEAD_TYPE",
              "COUNTRY_ISO",
              "COUNTRY_FLAG",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "PRODUCT_NAME"
          },
          {
            data: "lead_status"
          },
          {
            data: "AssignName"
          },
          {
            data: "LEAD_TYPE"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },

          {
            targets: 5,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                 A  ${ e.st_name }

                  </a>
                `;




            }
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';

                //------------------
                if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
                {

                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>


                  `

                }
                //------------------



                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>
                  <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-edit-1"></i>
                </a>

                    `;

                } else
                {
                  return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-users "></i>
                  </a>

                    `;
                }

              } else
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                          </a>
                          <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

                  </div></span>
                  <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                  ${ e.data_source }
                  </span>
                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-phone-square"></i>
                  </a>
                  `
              }


            }
          },
          {
            targets: 1,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `

                  <div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.GLUSR_USR_COMPANYNAME }
                  </span>
                  <br>
                  <span class="m-widget5__info-date m--font-info">
                  ${ e.SENDERNAME }
                  </span><br>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.MOB }
                  </span>
                </div>`
            }
          },
          {
            targets: 2,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    ${ e.ENQ_CITY }
                  </span>
                  <br>
                  <span class="m-widget5__primary-date m--font-primary">
                  ${ e.ENQ_STATE }
                  </span>

                </div>`
            }
          },

          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {

              var iconD = '';

              if ( _UNIB_RIGHT == 'SalesUser' )
              {
                iconD = '';

              } else
              {
                iconD = e.QTYPE;

              }

              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">

                    <span class="m-badge m-badge--info"> ${ iconD }</span>
                    ${ e.created_at }<br>

                  </span>
                  <span class="m-widget5__info-label">
                   <strong> ${ e.AssignName }</strong>
                  </span>
                </div>`
            }
          },
          {
            targets: 4,
            width: 100,
            render: function ( a, t, e, n )
            {
              var maxLength = 30;

              var myStr = e.ENQ_MESSAGE;

              if ( $.trim( myStr ).length > maxLength )
              {

                var newStr = myStr.substring( 0, 15 ) + '...';

                var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

                return `<p class="show-read-more">${ newStr }
                          <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                          </p>`;


              } else
              {
                return `<p class="show-read-more">${ myStr }</p>`;
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


//AssignToOther
function AssignToOther( rowid )
{
  $( '#QUERY_ID_ToOther' ).val( rowid );
  $( '#m_modal_LeadAssignModel_ToOther' ).modal( 'show' );

}
//AssignToOther
function viewLeadNotesData( rowid )
{ //this function is used to show list of notes added by user to lead
  // ajax
  var formData = {

    'QUERY_ID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getLeadNotesData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '.listaddednoteslist' ).html( res );
      $( '#m_modal_LeadNotesAddedList' ).modal( 'show' );


    }


  } );




  // ajax

}
//viewAllIreevant_V3
function viewAllIreevant_V3()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_v3Irrelevant',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewAllIreevant_V3

//viewUnQualifiedLead_V3
function viewUnQualifiedLead_V3()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_v3disQualified',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewUnQualifiedLead_V3
//viewHOLDLead_V3
//viewHOLDLead_V3_Intern
function viewHOLDLead_V3_Intern()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList_LeadMangerVIEW_Intern" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW_Intern" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_v3Hold_Intern',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewHOLDLead_V3_Intern

function viewHOLDLead_V3()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_v3Hold',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewHOLDLead_V3
//viewDUPLICATELead_V3
function viewDUPLICATELead_V3()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_v3Duplicate',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewDUPLICATELead_V3
//viewAllAssign_V3
function viewAllAssign_V3()
{
  $( '.ajstage' ).show();
  var a;
  var buttonCommonORDERA = {
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

  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 100, 5000, 10000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    dom: 'Blfrtip',
    buttons: [

      $.extend( true, {}, buttonCommonORDERA, {
        extend: 'excelHtml5'
      } ),
      $.extend( true, {}, buttonCommonORDERA, {
        extend: 'pdfHtml5'
      } )

    ],
    ajax: {

      url: BASE_URL + '/getLeadList_v3Assined',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }


          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}


//viewAllAssign_V3
// viewAllAssign
function viewAllAssign()
{
  $( '.ajstage' ).show();
  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "AssignID",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllAssign'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
         <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

          ${ e.st_name }

          </a>
        `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {
          var sendQutationURL = BASE_URL + '/send/quatation/' + e.QUERY_ID + '';


          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            var ajHtML = ``;

            ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>


                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
         <i class="la la-ellipsis-h"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
          <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
          </div></span>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ e.data_source }
          </span>

           `;


            if ( UID == e.AssignID )
            {
              ajHtML += ` <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign to Other" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-users"></i>
           </a>`;
            }
            if ( e.st_name == 'Sampling' )
            {
              ajHtML += `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-edit-1"></i>
          </a>`;

            }

          }
          return ajHtML;



        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.GLUSR_USR_COMPANYNAME }
          </span>
          <br>
          <span class="m-widget5__info-date m--font-info">
          ${ e.SENDERNAME }
          </span><br>
          <span class="m-widget5__primary-date m--font-success">
          ${ e.MOB }
          </span>
        </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
            ${ e.ENQ_CITY }
          </span>
          <br>
          <span class="m-widget5__primary-date m--font-primary">
          ${ e.ENQ_STATE }
          </span>

        </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
          <span class="m-widget5__info-label">
          ${ e.data_source }
            ${ e.created_at }<br>

          </span>
          <span class="m-widget5__info-label">
           <strong> ${ e.AssignName }</strong>
          </span>
        </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                  <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                  </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//m_table_LEADListSaleOwn
var DatatablesLeadListSalesOwnLead = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      a = $( "#m_table_LEADListSaleOwn" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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

          url: BASE_URL + '/getLeadListSalesOwn',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
              "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
              "GLUSR_USR_COMPANYNAME",
              "ENQ_MESSAGE",
              "lead_check",
              "lead_status",
              "lead_noteAV",
              "AssignName",
              "LeadOwner",
              "last_note_added",
              "follow_date",
              "st_name",
              "QTYPE",
              "data_source",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [

          {
            data: "QUERY_ID"
          },
          {
            data: "GLUSR_USR_COMPANYNAME"
          },
          {
            data: "SENDERNAME"
          },
          {
            data: "created_at"
          },
          {
            data: "LeadOwner"
          },
          {
            data: "MOB"
          },
          {
            data: "AssignName"
          },
          {
            data: "st_name"
          },

          {
            data: "Actions"
          }
        ],

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

              if ( _UNIB_RIGHT == 'Admin' )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add-mylead-sample/' + e.QUERY_ID + '';
                var HTML = '';
                HTML += `<a href="javascript::void(0)"  onclick="viewAllOWN_LEAD(${ e.QUERY_ID })" title="View All Lead Details" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Give Access To" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>
                  <a style="margin-top:5px" href="javascript::void(0)"  onclick="MYLeadDelete(${ e.QUERY_ID })" title="Deleted" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-delete"></i>
                    </a>
                  `;
                return HTML;

              }

              if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
              {
                var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
                view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
                sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

                sample_URL_LEAD = BASE_URL + '/add-mylead-sample/' + e.QUERY_ID + '';
                var HTML = '';
                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  HTML = `<a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="fa flaticon-edit-1"></i>
                      </a>
                      <a style="margin-top:5px" href="javascript::void(0)"  onclick="MYLeadDelete(${ e.QUERY_ID })" title="Deleted" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-delete"></i>
                    </a>

                      `
                }

                HTML += `<a href="javascript::void(0)"  onclick="viewAllOWN_LEAD(${ e.QUERY_ID })" title="View All Lead Details" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>

                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Give Access To" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-users"></i>
                    </a>
                    <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-chat "></i>
                  </a>


                    `;
                if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
                {
                  HTML += ``
                } else
                {
                  HTML += `<a style="margin-top:5px" href="javascript::void(0)"  onclick="MYLeadDelete(${ e.QUERY_ID })" title="Deleted" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-delete"></i>
                    </a> `
                }
                return HTML;


              }


            }
          },
          {
            targets: 6,
            width: 100,
            render: function ( a, t, e, n )
            {
              return `<div class="m-widget5__info">
                  <span class="m-widget5__info-label">
                    Last:
                  </span>
                  <span class="m-widget5__info-date m--font-info">
                    ${ e.last_note_added }
                  </span><br>
                  <span class="m-widget5__primary-label">
                    Next:
                  </span>
                  <span class="m-widget5__primary-date m--font-success">
                  ${ e.follow_date }
                  </span>
                </div>`
            }
          },
          {
            targets: 7,
            width: 100,
            render: function ( a, t, e, n )
            {

              return `
                  <a href="javascript::void(0)" onclick="viewLeadStageSalesOWN(${ e.QUERY_ID })">

                  ${ e.st_name }

                  </a>
                `;




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


//click to call
function clickCall( rowid )
{
  swal( {
    title: "Are you sure?",
    text: "want to call",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "YES CALL ",
    cancelButtonText: "NO, CANCEL!",
    reverseButtons: !1
  } ).then( function ( ey )
  {
    if ( ey.value )
    {

      var QUERY_ID = $( '#QUERY_ID_ID' ).val();

      $.ajax( {
        url: BASE_URL + "/clicktoCallAPI",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), QUERY_ID: QUERY_ID },
        success: function ( resp )
        {

          if ( resp.status == 0 )
          {
            swal( "Call Alert!", "Cann't call try again", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                //  location.reload();
              }
            } );
          } else
          {
            swal( "Call !", "Your call started", "success" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                //location.reload();
              }
            } );
          }


        },
        dataType: 'json'
      } );

    }

  } )

}

//MYLeadDelete


//click to call

//m_table_LEADListSaleOwn
//MYLeadDelete
function MYLeadDelete( rowid )
{
  swal( {
    title: "Are you sure?",
    text: "You won't be able to revert this Message!",
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
        url: BASE_URL + "/deleteMyLead",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid },
        success: function ( resp )
        {

          if ( resp.status == 0 )
          {
            swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your Own Lead has been deleted.", "success" ).then( function ( eyz )
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

//MYLeadDelete


// viewTodayLeadLead

function viewTodayLeadLead()
{


  var a;
  $( "#m_table_LEADListSALES_END" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADListSALES_END" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_SALES_END',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "st_name",
          "LEAD_TYPE",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewTodayLeadLead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      }, {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';




            if ( e.st_name == 'Sampling' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
            </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
       
      </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {
          return e.LEAD_TYPE
        }

      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 40 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//lead admin

//viewINHOUSELead
function viewINHOUSELead()
{

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'INHOUSED_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          // if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          if ( UID == 666 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewINHOUSELea

//viewPHONELead
function viewPHONELead()
{

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "call_dataFlag",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'PHONE_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          // if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          if ( UID == 666 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
            var ajHtML = "";
            if ( e.call_dataFlag )
            {
              ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="la la-eye"></i>
                     </a>
                     <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                           <i class="la la-edit"></i>
                     </a>
                     <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
            <i class="la la-ellipsis-h"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
             <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
             <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
             <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
             </div></span>
             <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
             ${ e.data_source }
             </span>

             `;
            } else
            {
              ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="la la-eye"></i>
                     </a>
                     <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                           <i class="la la-edit"></i>
                     </a>
                     <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
            <i class="la la-ellipsis-h"></i></a>
            <div class="dropdown-menu dropdown-menu-right">

             <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
             <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
             </div></span>
             <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
             ${ e.data_source }
             </span>
             <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
             <i class="fa fa-phone-square"></i>
             </a>
             `;
            }


            if ( e.call_dataFlag )
            {

            } else
            {
              if ( UID == 1 || UID == 134 || UID == 84 )
              {
                ajHtML += `<a href="javascript::void(0)" onclick="AddDataCallModel(${ e.QUERY_ID })" title="Data Call" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="la la-plus"></i>
                 </a> `;

              }

            }


            return ajHtML;
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewPHONELead

// viewBUYLead
function viewBUYLead()
{

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'BUY_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {
              var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
              view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
              sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                  </a>
                  <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
              <i class="la la-ellipsis-h"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ e.data_source }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `

            } else
            {
              var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
              view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
              sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                  `;
            }


          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}


// viewBUYLead_LM
//viewDIRECTLead_LM
function viewDIRECTLead()
{

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          // if ( NIB_RIGHT == 'SalesUser' || UID == 102 )
          if ( UID == 666 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>

        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewDIRECTLead_LM

//lead admin

//viewINHOUSELead_LM
function viewINHOUSELead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'INHOUSED_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>


        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewINHOUSELead_LM

//viewPHONELead_LM
function viewPHONELead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "call_dataFlag",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'PHONE_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';
            var ajHtML = "";
            if ( e.call_dataFlag == 1 )
            {
              ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>
                    <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                    </a>
                    <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
           <i class="la la-ellipsis-h"></i></a>
           <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
            <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
            <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
            </div></span>
            <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
            ${ e.data_source }
            </span>
            <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa fa-phone-square"></i>
            </a>


          `  ;

            } else
            {
              ajHtML += `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>
                    <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                    </a>
                    <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
           <i class="la la-ellipsis-h"></i></a>
           <div class="dropdown-menu dropdown-menu-right">

            <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
            <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
            </div></span>
            <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
            ${ e.data_source }
            </span>
            <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa fa-phone-square"></i>
            </a>
            `;

            }

            if ( e.call_dataFlag == 1 )
            {

            } else
            {
              if ( UID == 1 || UID == 134 || UID == 84 )
              {
                ajHtML += `<a href="javascript::void(0)" onclick="AddDataCallModel(${ e.QUERY_ID })" title="Data Call" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-plus"></i>
                  </a> `;

              }
            }

            return ajHtML;




          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewPHONELead_LM

// viewBUYLead_LM
function viewBUYLead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'BUY_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          // if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          if ( UID == 666 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>

        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewFOREIGNLead_V2
function viewFOREIGNLead_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LMForeignview',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewALL_LEAD_V2_NONEFRESH
function viewALL_LEAD_V2_NONEFRESH()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LM_viewALLLead_NONEFRESH',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;
            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }
          if ( UID == 1347 )
          {
            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>
         
  `
          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }
          // iconD = 'H';

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewALL_LEAD_V2_NONEFRESH

//all lead 

function viewALL_LEAD_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LM_viewALLLead',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;
            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }
          if ( UID == 1345 )
          {
            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a>
          <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
          ${ sourceAPI }
          </span>
         
  `
          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              <a href="https://api.whatsapp.com/send?phone=${ e.MOB }&amp;text=We are manufacturers for private label Skin Care and other Cosmetics products based in India. We provide contract manufacturing services to beauty brands - http://www.max.net/Bo_International_Essential_Oils.pdf" target="_blank" data-action="share/whatsapp/share"><i style="color:green" class="fab fa-whatsapp-square"></i></a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }
          // iconD = 'H';

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}


//all lead 
//viewClaimAssined_V2
function viewClaimAssined_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LM_claim_assined',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 1:
              day = "Assinged";
              break;
            case 2:
              day = "Qualified";
              break;
            case 3:
              day = "Sampling";
              break;
            case 4:
              day = "Negotiation";
              break;
            case 5:
              day = "Converted";
              break;
            case 6:
              day = "Lost";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;
            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }
          // iconD = 'H';

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewClaimAssined_V2

// viewVERIFIED_V2
function viewVERIFIED_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LM_verifiedLead',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;
            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }
          // iconD = 'H';

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

// viewVERIFIED_V2

//
//viewFOREIGNLead_V2
//viewINHOUSELead_V2
function viewINHOUSELead_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LMInhouseview',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }
          iconD = 'H';

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//viewINHOUSELead_V2
// viewBUYLead_V2
function viewBUYLead_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LMBuyview',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Unqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "INDIA";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

// viewBUYLead_V2
//viewPHONELead_V2
function viewPHONELead_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LMPhoneview',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "intern_user_id", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              ${ e.intern_user_id }

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
// viewSampleReportList
var DatatablesSampleReportList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_SampleReportList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesCountList',
          type: "POST",
          data: {
            columnsDef: [ 
              "RecordID",
              "today_date",
              "added_count",
              "formulated_count",
              "dispatched_count", 
              "total_peding",        
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'action_name': 'DIRECT_LEAD'
          }
        },
        columns: [

          {
            data: "RecordID"
          },
          {
            data: "today_date"
          },
          {
            data: "added_count"
          },
          {
            data: "formulated_count"
          },
          {
            data: "dispatched_count"
          },
          {
            data: "total_peding"
          },    
    
          {
            data: "Actions"
          }
        ],

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


            return '';




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

// viewSampleReportList

//m_table_SampleReportList


//m_table_LEADList_LeadMangerVIEW

//viewBUYLead_V2
// viewBUYLead_LM
// viewDIRECTLeadLM_V2
function viewDIRECTLeadLM_V2()
{

  var a;
  $( "#m_table_LEADList_LeadMangerVIEW" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LeadMangerVIEW" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout_LMDirectView',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "intern_user_id", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "QTYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },

      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {
          day = "";
          switch ( e.lead_status )
          {
            case 0:
              day = "Fresh Lead";
              break;
            case 1:
              day = "Irrelevant";
              break;
            case 4:
              day = "Unqualified";
              break;
            case 55:
              day = "HOLD";
              break;

          }

          return `
              <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

               ${ day }

              </a>
            `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          var sourceAPI = "";
          switch ( e.data_source )
          {
            case 'INDMART-9999955922@API_1':
              sourceAPI = "IM1";
              break;
            case 'INDMART-8929503295@API_2':
              sourceAPI = "IM2";
              break;
            case 'INDMART-9811098426@API_5':
              sourceAPI = "IM3";
              break;

            case 'TRADEINDIA-8850185@API_3':
              sourceAPI = "TD1";
              break;
            case 'INHOUSE-ENTRY':
              sourceAPI = "IN-H";
              break;

          }

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            sample_URL_LEAD = BASE_URL + '/add_stage_sample/' + e.QUERY_ID + '';


            //------------------
            if ( UID == 3 || UID == 4 || UID == 40 || UID == 119 || UID == 129 )
            {

              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>


              `

            }
            //------------------



            if ( e.st_name == 'Sampling' || e.st_name == 'Client' )
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>
              <a style="margin-top:5px" href="${ sample_URL_LEAD }"   title="Add More Sample" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa flaticon-edit-1"></i>
            </a>

                `;

            } else
            {
              return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>

                <a style="margin-top:5px" href="javascript::void(0)"  onclick="AssignToOther(${ e.QUERY_ID })" title="Assign" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-users"></i>
                </a>
                <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadAddNotesModelSales(${ e.QUERY_ID })" title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-chat "></i>
              </a>
              <a style="margin-top:5px" href="javascript::void(0)"  onclick="LeadUnQlifiedModelSales(${ e.QUERY_ID })" title="Disqualified" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="flaticon-users "></i>
              </a>

                `;
            }

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                      </a>
                      <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
             <i class="la la-ellipsis-h"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadVerifyNowModel(${ e.QUERY_ID })" ><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">VERIFY NOW</span></a>
              <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>

              </div></span>
              <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
              ${ sourceAPI }
              </span>
              <a style="margin-top:5px" href="javascript::void(0)"   onclick="markLeadTags(${ e.QUERY_ID })" title="Mark tags " class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
<i class="fa fa-hand-point-up"></i>
</a>

              <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-phone-square"></i>
              </a>
              ${ e.intern_user_id }
              `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `

              <div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.GLUSR_USR_COMPANYNAME }
              </span>
              <br>
              <span class="m-widget5__info-date m--font-info">
              ${ e.SENDERNAME }
              </span><br>
              <span class="m-widget5__primary-date m--font-success">
              ${ e.MOB }
              </span>
            </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">
                ${ e.ENQ_CITY }
              </span>
              <br>
              <span class="m-widget5__primary-date m--font-primary">
              ${ e.ENQ_STATE }
              </span>

            </div>`
        }
      },
      {
        targets: 7,
        width: 100,
        render: function ( a, t, e, n )
        {

          switch ( e.LEAD_TYPE )
          {
            case 'IN':
              DataFrom = "INDIA";
              break;
            case 'India':
              DataFrom = "INDIA";
              break;

            default:
              DataFrom = "FOREIGN";
              break;
          }

          return DataFrom;
        }
      },

      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {

          var iconD = '';

          if ( _UNIB_RIGHT == 'SalesUser' )
          {
            iconD = '';

          } else
          {
            iconD = e.QTYPE;

          }

          return `<div class="m-widget5__info">
              <span class="m-widget5__info-label">

                <span class="m-badge m-badge--info"> ${ iconD }</span>
                ${ e.created_at }<br>

              </span>
             
            </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                      <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                      </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

// viewDIRECTLeadLM_V2

//viewDIRECTLead_LM
function viewDIRECTLead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'DIRECT_LEAD'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallLead(${ e.QUERY_ID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="fa fa-phone-square"></i>
        </a>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewDIRECTLead_LM



// viewDUPLICATELead_LM
function viewDUPLICATELead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList_LMLayout',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewDUPLICATELead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

// viewDUPLICATELead_LM

// viewTodayLeadLead
// viewHOLDLead_LM
function viewHOLDLead_LM()
{

  var a;
  $( "#m_table_LEADList_LMLAYOUT" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList_LMLAYOUT" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewHOLDLead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}


// viewHOLDLead_LM


// viewHOLDLead
//viewDUPLICATELead
function viewDUPLICATELead()
{

  $( '.ajstage' ).hide();
  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewDUPLICATELead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//viewDUPLICATELead

function viewHOLDLead()
{

  $( '.ajstage' ).hide();
  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewHOLDLead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

// viewHOLDLead

// viewUnQualifiedLead

function viewUnQualifiedLead()
{


  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "st_name",
          "LEAD_TYPE",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewUnQualifiedLead'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}

//get IM1 IM2 Missed call
$( ".ajLeadFilter" ).click( function ()
{
  var radioValue = $( "input[name='filLead']:checked" ).val();
  viewFillterIMLead( radioValue );
} );
function viewFillterIMLead( radioValue )
{

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "LEAD_TYPE",
          "st_name",
          "data_source",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'LEAD_IM' + radioValue
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },

      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
                <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

                ${ e.st_name }

                </a>
              `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          // if ( NIB_RIGHT == 'SalesUser' || UID == 102 )
          if ( UID == 666 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-eye"></i>
                        </a>
                        `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-eye"></i>
                        </a>
                        <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                              <i class="la la-edit"></i>
                        </a>
                        <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
               <i class="la la-ellipsis-h"></i></a>
               <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
                <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
                <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
                </div></span>
                <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
                ${ e.data_source }
                </span>
                `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
                <span class="m-widget5__info-label">
                  ${ e.GLUSR_USR_COMPANYNAME }
                </span>
                <br>
                <span class="m-widget5__info-date m--font-info">
                ${ e.SENDERNAME }
                </span><br>
                <span class="m-widget5__primary-date m--font-success">
                ${ e.MOB }
                </span>
              </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
                <span class="m-widget5__info-label">
                  ${ e.ENQ_CITY }
                </span>
                <br>
                <span class="m-widget5__primary-date m--font-primary">
                ${ e.ENQ_STATE }
                </span>

              </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
                <span class="m-widget5__info-label">

                  ${ e.created_at }<br>

                </span>
                <span class="m-widget5__info-label">
                 <strong> ${ e.AssignName }</strong>
                </span>
              </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                        <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                        </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
//get IM1 IM2 Missed call


// viewUnQualifiedLead
//viewFreshLead
function viewFreshLead()
{

  location.reload( 1 );
}
//viewFreshLead
// viewAllAssign
// viewAllIreevant
function viewAllIreevant()
{
  $( '.ajstage' ).hide();

  var a;
  $( "#m_table_LEADList" ).dataTable().fnDestroy()

  //----------------------------------------
  a = $( "#m_table_LEADList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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

      url: BASE_URL + '/getLeadList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "QUERY_ID", "PRODUCT_NAME", "SENDERNAME", "created_at",
          "created_by", "MOB", "ENQ_CITY", "ENQ_STATE",
          "GLUSR_USR_COMPANYNAME",
          "ENQ_MESSAGE",
          "lead_check",
          "lead_status",
          "lead_noteAV",
          "AssignName",
          "st_name",
          "data_source",
          "LEAD_TYPE",
          "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'action_name': 'viewAllIreevant'
      }
    },
    columns: [

      {
        data: "QUERY_ID"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "GLUSR_USR_COMPANYNAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "PRODUCT_NAME"
      },
      {
        data: "lead_status"
      },
      {
        data: "AssignName"
      },
      {
        data: "LEAD_TYPE"
      },
      {
        data: "Actions"
      }
    ],

    columnDefs: [
      {
        targets: [ 0 ],
        visible: !1
      },
      {
        targets: 5,
        width: 100,
        render: function ( a, t, e, n )
        {

          return `
        <a href="javascript::void(0)" onclick="viewLeadStage(${ e.QUERY_ID })">

        ${ e.st_name }

        </a>
      `;




        }
      },
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          if ( _UNIB_RIGHT == 'SalesUser' || UID == 102 )
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

          } else
          {
            var edit_URL = 'users/lead/' + e.QUERY_ID + '/edit';
            view_URL = BASE_URL + '/client/' + e.QUERY_ID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.QUERY_ID + '';

            return `<a href="javascript::void(0)"  onclick="viewAllINDMartData(${ e.QUERY_ID })" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                </a>
                <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
       <i class="la la-ellipsis-h"></i></a>
       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${ e.QUERY_ID })" ><i class="la la-user"></i> Assign</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${ e.QUERY_ID })" ><i class="la la-leaf"></i> Irrelevant</a>
        <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${ e.QUERY_ID })" ><i class="la la-plus"></i> Add Notes</a>
        </div></span>
        <span class="m-badge m-badge--default m-badge--wide m-badge--rounded">
        ${ e.data_source }
        </span>
        `
          }


        }
      },
      {
        targets: 1,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.GLUSR_USR_COMPANYNAME }
        </span>
        <br>
        <span class="m-widget5__info-date m--font-info">
        ${ e.SENDERNAME }
        </span><br>
        <span class="m-widget5__primary-date m--font-success">
        ${ e.MOB }
        </span>
      </div>`
        }
      },
      {
        targets: 2,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">
          ${ e.ENQ_CITY }
        </span>
        <br>
        <span class="m-widget5__primary-date m--font-primary">
        ${ e.ENQ_STATE }
        </span>

      </div>`
        }
      },
      {
        targets: 6,
        width: 100,
        render: function ( a, t, e, n )
        {
          return `<div class="m-widget5__info">
        <span class="m-widget5__info-label">

          ${ e.created_at }<br>

        </span>
        <span class="m-widget5__info-label">
         <strong> ${ e.AssignName }</strong>
        </span>
      </div>`
        }
      },
      {
        targets: 4,
        width: 100,
        render: function ( a, t, e, n )
        {
          var maxLength = 30;

          var myStr = e.ENQ_MESSAGE;

          if ( $.trim( myStr ).length > maxLength )
          {

            var newStr = myStr.substring( 0, 15 ) + '...';

            var removedStr = myStr.substring( maxLength, $.trim( myStr ).length );

            return `<p class="show-read-more">${ newStr }
                <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e.QUERY_ID })"><span  class="m-badge m-badge--success m-badge--wide m-badge--rounded">Read More</span></a>
                </p>`;


          } else
          {
            return `<p class="show-read-more">${ myStr }</p>`;
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

  //----------------------------------------

}
// viewAllIreevant


$( ".read-more" ).click( function ()
{

  $( this ).siblings( ".more-text" ).contents().unwrap();

  $( this ).remove();

} );

//btnAssign_ToOther_OWN

$( '#btnAssign_ToOther_OWN' ).click( function ()
{

  var assign_user_id = $( '#assign_user_id_toOther' ).val();
  var assign_msg = $( '#assign_msg_ToOther' ).val();
  var QUERY_ID = $( '#QUERY_ID_ToOther' ).val();

  if ( assign_user_id == "" || assign_user_id <= 0 )
  {
    toasterOptions();
    toastr.error( 'Please Select User ', 'Lead Management' );
    return false;
  }
  if ( assign_msg == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {
    'assign_user_id': assign_user_id,
    'assign_msg': assign_msg,
    'QUERY_ID': QUERY_ID,
    'action': 4,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/myLeadTranfer',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        $( '#assign_msg_ToOther' ).val( "" );
        $( '#assign_user_id_toOther' ).prop( 'selectedIndex', 0 );
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAssignModel_ToOther' ).modal( 'toggle' );

        return false;

      }


    },
    dataType: 'json'

  } );




  // ajax



} );

//btnAssign_ToOther_OWN

// btnAssign_ToOther
$( '#btnAssign_ToOther' ).click( function ()
{

  var assign_user_id = $( '#assign_user_id_toOther' ).val();
  var assign_msg = $( '#assign_msg_ToOther' ).val();
  var QUERY_ID = $( '#QUERY_ID_ToOther' ).val();

  if ( assign_user_id == "" || assign_user_id <= 0 )
  {
    toasterOptions();
    toastr.error( 'Please Select User ', 'Lead Management' );
    return false;
  }
  if ( assign_msg == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {
    'assign_user_id': assign_user_id,
    'assign_msg': assign_msg,
    'QUERY_ID': QUERY_ID,
    'action': 4,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        $( '#assign_msg_ToOther' ).val( "" );
        $( '#assign_user_id_toOther' ).prop( 'selectedIndex', 0 );
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAssignModel_ToOther' ).modal( 'toggle' );

        return false;

      }


    },
    dataType: 'json'

  } );




  // ajax



} );

//btnTicketUpdate
$( '#btnTicketUpdate' ).click( function ()
{

  var ticket_id = $( '#ticket_id' ).val();
  var assign_user_idTicket = $( '#assign_user_idTicket' ).val();
  var ticket_id_status = $( '#ticket_id_status' ).val();
  var assign_msgTicket = $( '#assign_msgTicket' ).val();
  
  if ( assign_user_idTicket == "" || assign_user_idTicket <= 0 )
  {
    toasterOptions();
    toastr.error( 'Please Select User ', 'Ticket Management' );
    return false;
  }
  if ( assign_msgTicket == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Ticket Management' );
    return false;
  }
  // ajax
  var formData = {
    'assign_user_id': assign_user_idTicket,
    'assign_msg': assign_msgTicket,
    'ticket_id': ticket_id,    
    'ticket_id_status': ticket_id_status,    
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/updateTicketStatus',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }
      if ( res.status == 22 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }
      if ( res.status == 25 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }



    },
    dataType: 'json'

  } );




  // ajax



} );


//btnTicketUpdate

//btnAssignClain

$( '#btnAssignClain' ).click( function ()
{

  var assign_user_id = $( '#assign_user_id' ).val();
  var assign_msg = $( '#assign_msg' ).val();
  var QUERY_ID = $( '#QUERY_ID' ).val();

  if ( assign_user_id == "" || assign_user_id <= 0 )
  {
    toasterOptions();
    toastr.error( 'Please Select User ', 'Lead Management' );
    return false;
  }
  if ( assign_msg == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {
    'assign_user_id': assign_user_id,
    'assign_msg': assign_msg,
    'QUERY_ID': QUERY_ID,
    'action': 15,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }
      if ( res.status == 22 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }
      if ( res.status == 25 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }



    },
    dataType: 'json'

  } );




  // ajax



} );


//btnAssignClain

// btnAssign_ToOther

$( '#btnAssign' ).click( function ()
{

  var assign_user_id = $( '#assign_user_id' ).val();
  var assign_msg = $( '#assign_msg' ).val();
  var QUERY_ID = $( '#QUERY_ID' ).val();

  if ( assign_user_id == "" || assign_user_id <= 0 )
  {
    toasterOptions();
    toastr.error( 'Please Select User ', 'Lead Management' );
    return false;
  }
  if ( assign_msg == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {
    'assign_user_id': assign_user_id,
    'assign_msg': assign_msg,
    'QUERY_ID': QUERY_ID,
    'action': 1,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAssignModel' ).modal( 'toggle' );
        return false;
      }


    },
    dataType: 'json'

  } );




  // ajax



} );

// btnSubmitLeadResponseVerify
$( '#btnSubmitLeadResponseVerify' ).click( function ()
{


  var txtMessageIreeReponse = $( '#txtMessageIreeReponseVri' ).val();
  var QUERY_IDA = $( '#QUERY_IDAVri' ).val();
  var iIrrelevant_type = $( '#iIrrelevant_typeVri' ).val();
  var iIrrelevant_type_HTML = $( '#iIrrelevant_typeVri option:selected' ).html();

  if ( iIrrelevant_type == "" )
  {
    toasterOptions();
    toastr.error( 'Select Type', 'Lead Management' );

    return false;
  }



  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageIreeReponse': txtMessageIreeReponse,
    'QUERY_ID': QUERY_IDA,
    'iIrrelevant_type': iIrrelevant_type,
    'iIrrelevant_type_HTML': iIrrelevant_type_HTML,

    'action': 28,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        if ( iIrrelevant_type == 6 )
        {
          $( '#m_modal_LeadVerifytModel' ).modal( 'toggle' );
        } else
        {
          $( '#m_modal_LeadIrrelevantModel' ).modal( 'toggle' );
        }

        return false;
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

// btnSubmitLeadResponseVerify


// btnSubmitLeadResponse

$( '#btnSubmitLeadResponse' ).click( function ()
{


  var txtMessageIreeReponse = $( '#txtMessageIreeReponse' ).val();
  var QUERY_IDA = $( '#QUERY_IDA' ).val();
  var iIrrelevant_type = $( '#iIrrelevant_type' ).val();
  var iIrrelevant_type_HTML = $( '#iIrrelevant_type option:selected' ).html();

  if ( iIrrelevant_type == "" )
  {
    toasterOptions();
    toastr.error( 'Select Type', 'Lead Management' );

    return false;
  }



  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageIreeReponse': txtMessageIreeReponse,
    'QUERY_ID': QUERY_IDA,
    'iIrrelevant_type': iIrrelevant_type,
    'iIrrelevant_type_HTML': iIrrelevant_type_HTML,

    'action': 2,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        if ( iIrrelevant_type == 6 )
        {
          $( '#m_modal_LeadVerifytModel' ).modal( 'toggle' );
        } else
        {
          $( '#m_modal_LeadIrrelevantModel' ).modal( 'toggle' );
        }

        return false;
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

// btnSubmitLeadResponse
//btnSubmitNoteOrderPrint
$( '#btnSubmitNoteOrderPrint' ).click( function ()
{
  var txtMessageNoteReponse = $( '#txtMessageNoteReponse' ).val();
  var QUERY_IDB = $( '#QUERY_IDB' ).val();


  if ( txtMessageNoteReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Order print Permissions' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QCID': QUERY_IDB,
    'action': 19,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Order print Permissions' );
        $( '#m_modal_orderAddNotesModelPrint' ).modal( 'toggle' );
        var MyID = "#boOrdID" + QUERY_IDB;
        $( MyID ).css( 'pointer-events', 'all' );
        return false;
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

//btnSubmitNoteOrderPrint

//btnSubmitLeadTags

$( '#btnSubmitLeadTags' ).click( function ()
{

  var txtMessageTagsReponse = $( '#txtMessageTagsReponse' ).val();
  var AjTag = [];
  $( "input:checkbox[name=lead_tag_id]:checked" ).each( function ()
  {
    AjTag.push( $( this ).val() );
  } );

  var lead_tag_id = AjTag;


  var QUERY_IDB = $( '#QUERY_IDBX' ).val();



  if ( txtMessageTagsReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageTagsReponse,
    'QUERY_ID': QUERY_IDB,
    'lead_tag_id': lead_tag_id,
    'action': 3,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };


  $.ajax( {
    url: BASE_URL + '/setLeadTags',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAddTagsModel' ).modal( 'toggle' );
        return false;
      } else
      {
        toasterOptions();
        toastr.error( 'Already Added', 'Lead Management' );
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

//btnSubmitLeadTags

//btnSubmitNote

$( '#btnSubmitNote' ).click( function ()
{


  var txtMessageNoteReponse = $( '#txtMessageNoteReponse' ).val();
  var QUERY_IDB = $( '#QUERY_IDB' ).val();


  if ( txtMessageNoteReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'action': 3,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully', 'Lead Management' );
        $( '#m_modal_LeadAddNotesModel' ).modal( 'toggle' );
        return false;
      }

    },
    dataType: 'json'

  } );




  // ajax



} );
//btnSubmitNote

// viewAllOWN_LEAD
function viewAllOWN_LEAD( rowid )
{
  //ajax call
  $( '.showINDMartData' ).html( '' );
  $( '.showINDMartData_HIST' ).html( '' );

  var formData = {
    'rowid': rowid,
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllLeadData_OWNLEAD',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showINDMartData' ).html( res.HTML_LEAD );
      $( '.showINDMartData_HIST' ).html( res.HTML_ASSIGN_HISTORY );
      $( '#m_modal_ViewINDMartData' ).modal( 'show' );

    },
    dataType: 'json'

  } );

  //ajax call


}

//viewAllINDMartData_PACK
function viewAllINDMartData_PACK( rowid )
{
  //alert(888);
  //ajax call
  $( '.showINDMartData' ).html( '' );
  $( '.showINDMartData_HIST' ).html( '' );

  var formData = {
    'rowid': rowid,
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllLeadDataPack',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showINDMartData' ).html( res.HTML_LEAD );
      $( '.showINDMartData_HIST' ).html( res.HTML_ASSIGN_HISTORY );
      $( '#m_modal_ViewINDMartData' ).modal( 'show' );

    },
    dataType: 'json'

  } );
  //ajax call
}

//viewAllINDMartData_PACK
//viewAllTicketDataALL
function viewAllTicketDataALL( rowid )
{
  //ajax call
  $( '.showINDMartData' ).html( '' );
  $( '.showINDMartData_HIST' ).html( '' );

  var formData = {
    'rowid': rowid,
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllTicketDataID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showINDMartData' ).html( res.HTML_LEAD );
      $( '.showINDMartData_HIST' ).html( res.HTML_ASSIGN_HISTORY );
      $( '#m_modal_ViewTicketHis' ).modal( 'show' );

    },
    dataType: 'json'

  } );

  //ajax call


}

//viewAllTicketDataALL

//viewAllINDMartDataALL
function viewAllINDMartDataALL( rowid )
{
  //ajax call
  $( '.showINDMartData' ).html( '' );
  $( '.showINDMartData_HIST' ).html( '' );

  var formData = {
    'rowid': rowid,
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllLeadDataALL',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showINDMartData' ).html( res.HTML_LEAD );
      $( '.showINDMartData_HIST' ).html( res.HTML_ASSIGN_HISTORY );
      $( '#m_modal_ViewINDMartData' ).modal( 'show' );

    },
    dataType: 'json'

  } );

  //ajax call


}

//viewAllINDMartDataALL

// viewAllOWN_LEAD

function viewAllINDMartData( rowid )
{
  //ajax call
  $( '.showINDMartData' ).html( '' );
  $( '.showINDMartData_HIST' ).html( '' );

  var formData = {
    'rowid': rowid,
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllLeadData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showINDMartData' ).html( res.HTML_LEAD );
      $( '.showINDMartData_HIST' ).html( res.HTML_ASSIGN_HISTORY );
      $( '#m_modal_ViewINDMartData' ).modal( 'show' );

    },
    dataType: 'json'

  } );

  //ajax call


}

//TicketUpdateModel
function TicketUpdateModel( rowid )
{
  $( '#ticket_id' ).val( rowid );
  $( '#m_modal_ticketUpdateModel' ).modal( 'show' );
}
//TicketUpdateModel

function LeadAssignModel( rowid )
{
  $( '#QUERY_ID' ).val( rowid );
  $( '#m_modal_LeadAssignModel' ).modal( 'show' );
}

//LeadVerifyNowModel
function LeadVerifyNowModel( rowid )
{

  $( '#QUERY_IDAVri' ).val( rowid );
  $( 'textarea#txtMessageIreeReponseVri' ).val( "" );
  $( '#m_modal_LeadVerifytModel' ).modal( 'show' );
}



//LeadVerifyNowModel

function LeadIrrelevantModel( rowid )
{
  $( '#QUERY_IDA' ).val( rowid );
  $( 'textarea#txtMessageIreeReponse' ).val( "" );
  $( '#m_modal_LeadIrrelevantModel' ).modal( 'show' );
}

function LeadUnQlifiedModelSales( rowid )
{

  $( '#QUERY_IDA_UNQLI' ).val( rowid );
  $( 'textarea#txtMessageUnQLiFiedReponse' ).val( "" );
  $( '#m_modal_LeadUnQliFiedModel' ).modal( 'show' );


}

// click2CallClient()

function click2CallClient( rowid )
{
  var formData = {


    'CID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setClicktoCallAgentCall_CLIENT',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Call Started', 'Click to Call' );
        return false;
      }
    },
    dataType: 'json'
  } );

}


// click2CallClient()

function click2CallLead( rowid )
{
  var formData = {


    'QUERY_ID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setClicktoCallAgentCall',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Call Started', 'Click to Call' );
        return false;
      }
    },
    dataType: 'json'
  } );

}


//LeadNoResponseModelSales
function LeadNoResponseModelSales( rowid )
{

  $( '#QUERY_IDB_salesNOResp' ).val( rowid );
  $( 'textarea#txtNoRespLead' ).val( "" );
  $( '#m_modal_noResponseModel_sales' ).modal( 'show' );
}

//LeadNoResponseModelSales



function LeadAddNotesModelSales( rowid )
{

  $( '#QUERY_IDB_sales' ).val( rowid );
  $( 'textarea#txtMessageNoteReponse_sales' ).val( "" );
  $( '#m_modal_LeadAddNotesModel_sales' ).modal( 'show' );
}





$( '#btnSubmitUnQlifiedResponse' ).click( function ()
{


  var txtMessageNoteReponse = $( '#txtMessageUnQLiFiedReponse' ).val();
  var QUERY_IDB = $( '#QUERY_IDA_UNQLI' ).val();
  var unqlified_type = $( '#unqlified_type' ).val();
  var unqlified_type_HTML = $( '#unqlified_type option:selected' ).html();

  $( "#salesPerson option:selected" ).val();







  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'unqlified_type': unqlified_type,
    'unqlified_type_HTML': unqlified_type_HTML,
    'action': 6,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        swal( "Lead Management", "Lead Disqualified Successfully", "success" ).then( function ( eyz )
        {
          if ( eyz.value )
          {
            //location.reload();
            $( '#m_modal_LeadUnQliFiedModel' ).modal( 'toggle' );

          }
        } );
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

//
//

$( '#btnLeadNotesSales_OWN' ).click( function ()
{


  var txtMessageNoteReponse = $( '#txtNotesLead' ).val();
  var QUERY_IDB = $( '#QUERY_IDB_sales' ).val();
  var shdate_input = $( '#shdate_input' ).val();

  var sh_date = $( '#shdate_input' ).val();
  if ( sh_date === "" )
  {
    var shchk_val = 2;
  } else
  {
    var shchk_val = 1;
  }


  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'shdate_input': shdate_input,
    'shchk_val': shchk_val,
    'action': 5,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/addNotesONLead',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        swal( "Lead Management", "Note Added Successfully", "success" ).then( function ( eyz )
        {

          if ( eyz.value )
          {
            $( '#m_modal_LeadAddNotesModel_sales' ).modal( 'toggle' );
          }
        } );
      }

    },
    dataType: 'json'

  } );




  // ajax



} );

//btnAddDataCallSales
$( '#btnAddDataCallSales' ).click( function ()
{

  var txtMessageNoteReponse = '';
  var QUERY_IDB = $( '#QUERY_IDB_AddDataCallsales' ).val();
  var assign_user_id_calldata = $( '#assign_user_id_calldata' ).val();
  var txtDataCallMin = $( '#txtDataCallMin' ).val();
  var txtDataCallOption = $( '#txtDataCallOption option:selected' ).val();



  if ( assign_user_id_calldata == "" )
  {
    toasterOptions();
    toastr.error( 'Select User', 'Lead Management' );
    return false;
  }
  if ( txtDataCallMin == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Call Duration in Sec', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'assign_user_id_calldata': assign_user_id_calldata,
    'txtDataCallMin': txtDataCallMin,
    'txtDataCallOption': txtDataCallOption,
    'action': 12,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        swal( "Lead Management", "Data Call Added Successfully", "success" ).then( function ( eyz )
        {

          if ( eyz.value )
          {
            $( '#m_modal_AddDataCallModel_sales' ).modal( 'toggle' );
            //location.reload();
          }
        } );

      }

    },
    dataType: 'json'

  } );




  // ajax



} );

//btnAddDataCallSales

// btnLeadNotesSales_OWN
//btnLeadNoRespSales
$( '#btnLeadNoRespSales' ).click( function ()
{


  var txtMessageNoteReponse = $( '#txtNoRespLead' ).val();
  var QUERY_IDB = $( '#QUERY_IDB_salesNOResp' ).val();




  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Comment', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'action': 555,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        swal( "Lead Management", " NO Respoinse Added Successfully", "success" ).then( function ( eyz )
        {

          if ( eyz.value )
          {
            $( '#m_modal_noResponseModel_sales' ).modal( 'toggle' );
          }
        } );
      }

    },
    dataType: 'json'

  } );




  // ajax



} );
//btnLeadNoRespSales


$( '#btnLeadNotesSales' ).click( function ()
{


  var txtMessageNoteReponse = $( '#txtNotesLead' ).val();
  var QUERY_IDB = $( '#QUERY_IDB_sales' ).val();
  var shdate_input = $( '#shdate_input' ).val();



  if ( txtMessageIreeReponse == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Message', 'Lead Management' );
    return false;
  }
  // ajax
  var formData = {

    'txtMessageNoteReponse': txtMessageNoteReponse,
    'QUERY_ID': QUERY_IDB,
    'shdate_input': shdate_input,
    'action': 5,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setLeadAssign',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        swal( "Lead Management", "Note Added Successfully", "success" ).then( function ( eyz )
        {

          if ( eyz.value )
          {
            $( '#m_modal_LeadAddNotesModel_sales' ).modal( 'toggle' );
          }
        } );
      }

    },
    dataType: 'json'

  } );




  // ajax



} );
//btnSubmitNote
//AddDataCallModel
function AddDataCallModel( rowid )
{

  $( '#QUERY_IDB_AddDataCallsales' ).val( rowid );
  $( '#m_modal_AddDataCallModel_sales' ).modal( 'show' );
}

//AddDataCallModel
//markLeadTags
function markLeadTags( rowid )
{

  $( '#QUERY_IDBX' ).val( rowid );
  $( 'textarea#txtMessageTagsReponse' ).val( "" );
  $( '#m_modal_LeadAddTagsModel' ).modal( 'show' );
}

//markLeadTags


function LeadAddNotesModel( rowid )
{

  $( '#QUERY_IDB' ).val( rowid );
  //$('#txtMessageNoteReponse textarea').val("4354 ");
  $( 'textarea#txtMessageNoteReponse' ).val( "" );
  $( '#m_modal_LeadAddNotesModel' ).modal( 'show' );
}


//lead

//clienthaveOrder
function clienthaveOrder()
{
  var a;
  $( "#m_table_clientList" ).dataTable().fnDestroy();

  a = $( "#m_table_clientList" ).DataTable( {
    responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    // ordering: false,
    order: [],
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
      // url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
      url: BASE_URL + '/getClientsListOrderHave',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "orderCount", "company", "name", "created_on", "created_by", "phone", "last_note_added", "follow_date", "Status", "rawMFlaf", "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "company"
      },
      {
        data: "name"
      },
      {
        data: "created_on"
      },
      {
        data: "created_by"
      },
      {
        data: "phone"
      },
      {
        data: "last_note_added"
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
                title: "RAW",
                class: "m-badge--brand"
              },
              2: {
                title: "LEAD",
                class: " m-badge--metal"
              },
              3: {
                title: "QUALIFIED",
                class: " m-badge--primary"
              },
              4: {
                title: "SAMPLING",
                class: " m-badge--success"
              },
              5: {
                title: "CUSTOMER",
                class: " m-badge--info"
              },
              6: {
                title: "LOST",
                class: " m-badge--danger"
              }

            };
            this.data().unique().sort().each( function ( t, e )
            {
              $( '.m-input[data-col-index="1"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
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

        edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
        view_URL = BASE_URL + '/client/' + e.RecordID + '';
        sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';
        rawMFlaf = e.rawMFlaf;
        if ( rawMFlaf == 0 )
        {
          rowClassM = "default";
        } else
        {
          rowClassM = "success";
        }

        if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
        {
          return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                          </a>

                      <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
                       title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-delete"></i>
                                                  </a>

                                                 
                                                  <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
                       title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-chat "></i>
                                                  </a>
                                                  <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                       title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-box-1"></i>
                                                  </a>
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>

                                                  <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                       title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-share"></i>
                                                  </a>
                                                  ${ e.orderCount }
                                                  

                                                  `

        } else
        { //not admin or sales

          if ( _UNIB_RIGHT == 'SalesHead' )
          {

            if ( e.created_by == 'Pooja Gupta' )
            {
              return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                           <a href="${ sample_URL }"
                           title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="
                                                      flaticon-box "></i>
                                                      </a>
                                                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="la la-edit"></i>
                                                    </a>
                                                    <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                                                    title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="flaticon-box-1"></i>
                                                                               </a>
                                                                               <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="fa fa-phone-square"></i>
                                                                               </a>
                                                                               <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a>

                                                                                `;

            } else
            // <a href="${ sample_URL }"
            // title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                            <i class="
            //                            flaticon-box "></i>
            //                            </a>
            {
              return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          
                                                      <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                       title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-box-1"></i>
                                                  </a>
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>

                                                  <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a><br>
                                                                                                          ${ e.orderCount }
                                                                                                          

                                                      `

            }




          } else
          {
            return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                       <a href="${ sample_URL }"
                       title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="
                                                  flaticon-box "></i>
                                                  </a>
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>
                                                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                        <i class="la la-edit"></i>
                                                      </a>

                                                  `
          }



        }




      }
    },
    {
      targets: 6,
      width: 100,
      render: function ( a, t, e, n )
      {
        return `<div class="m-widget5__info">
                    <span class="m-widget5__info-label">
                      Last:
                    </span>
                    <span class="m-widget5__info-date m--font-info">
                      ${ e.last_note_added }
                    </span><br>
                    <span class="m-widget5__primary-label">
                      Next:
                    </span>
                    <span class="m-widget5__primary-date m--font-success">
                    ${ e.follow_date }
                    </span>
                  </div>`
      }
    },
    {
      targets: 2,
      render: function ( a, t, e, n )
      {
        if ( e.rawMFlaf == 0 )
        {
          return e.name;
        } else
        {
          return e.name + `<br><i style="color:#008080" class="flaticon-box-1"></i>`;
        }

      }
    },
    {
      targets: 7,
      render: function ( a, t, e, n )
      {
        var i = {
          1: {
            title: "RAW",
            class: "m-badge--brand"
          },
          2: {
            title: "LEAD",
            class: " m-badge--metal"
          },
          3: {
            title: "QUALIFIED",
            class: " m-badge--primary"
          },
          4: {
            title: "SAMPLING",
            class: " m-badge--success"
          },
          5: {
            title: "CUSTOMER",
            class: " m-badge--info"
          },
          6: {
            title: "LOST",
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
//clienthaveOrder

//m_table_clientList_TeamClient
var DatatablesSearchOptionsAdvancedSearchClientDataListTeamClient = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      txtGetClientID = $( '#txtGetClientID' ).val();
      var a;
      a = $( "#m_table_clientList_TeamClient" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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
          // url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
          url: BASE_URL + '/getClientsListTeam',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company", "name", "created_on", "created_by", "phone", "last_note_added", "follow_date", "Status", "rawMFlaf", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'txtGetClientID': txtGetClientID
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "last_note_added"
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
                    title: "RAW",
                    class: "m-badge--brand"
                  },
                  2: {
                    title: "LEAD",
                    class: " m-badge--metal"
                  },
                  3: {
                    title: "QUALIFIED",
                    class: " m-badge--primary"
                  },
                  4: {
                    title: "SAMPLING",
                    class: " m-badge--success"
                  },
                  5: {
                    title: "CUSTOMER",
                    class: " m-badge--info"
                  },
                  6: {
                    title: "LOST",
                    class: " m-badge--danger"
                  }

                };
                this.data().unique().sort().each( function ( t, e )
                {
                  $( '.m-input[data-col-index="1"]' ).append( '<option value="' + t + '">' + a[ t ].title + "</option>" )
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

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';
            rawMFlaf = e.rawMFlaf;
            if ( rawMFlaf == 0 )
            {
              rowClassM = "default";
            } else
            {
              rowClassM = "success";
            }

            if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
            {
              return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                     
                                                  

                                                  `

            } else
            { //not admin or sales

              if ( _UNIB_RIGHT == 'SalesHead' )
              {

                if ( e.created_by == 'Pooja Gupta' )
                {
                  return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          
                                                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="la la-edit"></i>
                                                    </a>
                                                    <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                                                    title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="flaticon-box-1"></i>
                                                                               </a>
                                                                               <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="fa fa-phone-square"></i>
                                                                               </a>
                                                                               <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a>

                                                                                `;

                } else
                // <a href="${ sample_URL }"
                // title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                //                            <i class="
                //                            flaticon-box "></i>
                //                            </a>
                {
                  return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          
                                                      <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                       title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-box-1"></i>
                                                  </a>
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>

                                                  <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a>

                                                      `

                }




              } else
              {
                return `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                     
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>
                                                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                        <i class="la la-edit"></i>
                                                      </a>

                                                  `
              }



            }




          }
        },
        {
          targets: 6,
          width: 100,
          render: function ( a, t, e, n )
          {
            return `<div class="m-widget5__info">
                    <span class="m-widget5__info-label">
                      Last:
                    </span>
                    <span class="m-widget5__info-date m--font-info">
                      ${ e.last_note_added }
                    </span><br>
                    <span class="m-widget5__primary-label">
                      Next:
                    </span>
                    <span class="m-widget5__primary-date m--font-success">
                    ${ e.follow_date }
                    </span>
                  </div>`
          }
        },
        {
          targets: 2,
          render: function ( a, t, e, n )
          {
            if ( e.rawMFlaf == 0 )
            {
              return e.name;
            } else
            {
              return e.name + `<br><i style="color:#008080" class="flaticon-box-1"></i>`;
            }

          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "RAW",
                class: "m-badge--brand"
              },
              2: {
                title: "LEAD",
                class: " m-badge--metal"
              },
              3: {
                title: "QUALIFIED",
                class: " m-badge--primary"
              },
              4: {
                title: "SAMPLING",
                class: " m-badge--success"
              },
              5: {
                title: "CUSTOMER",
                class: " m-badge--info"
              },
              6: {
                title: "LOST",
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

//m_table_clientList_TeamClient
//m_table_clientListSalesLeadV1
var DatatablesSearchOptionsAdvancedSearchClientDataListSalesLeadV1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_clientListSalesLeadV1" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        // ordering: false,
        order: [],
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
          // url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
          url: BASE_URL + '/getClientsListSalesLeadV1',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "brand", "company", "name", "created_on", "created_by", "phone", "last_note_added", "follow_date", "Status", "rawMFlaf", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "brand"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },
          {
            data: "last_note_added"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "Action",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            sample_URL = BASE_URL + '/sample/add/' + e.RecordID + '';
            rawMFlaf = e.rawMFlaf;
            if ( rawMFlaf == 0 )
            {
              rowClassM = "default";
            } else
            {
              rowClassM = "success";
            }

            if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
            {
              if ( _UNIB_RIGHT == 'Admin' )
              {
                return `<a  target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-info"></i>
              </a>
              <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-edit"></i>
                  </a>

              <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
               title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-delete"></i>
                                          </a>

                                         
                                          <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
               title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-chat "></i>
                                          </a>
                                          <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
               title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-box-1"></i>
                                          </a>
                                          <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="fa fa-phone-square"></i>
                                          </a>

                                          <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="fa fa-share"></i>
                                          </a>
                                          

                                          `
              } else
              {
                return `<a target="_blank"  href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-info"></i>
              </a>
              <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-edit"></i>
                  </a>

              <a style="margin-bottom:3px;"href="javascript::void(0)" onclick="delete_client(${ e.RecordID })"
               title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-delete"></i>
                                          </a>

                                         
                                          <a href="javascript::void(0)" onclick="add_client_notes(${ e.RecordID })"
               title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-chat "></i>
                                          </a>
                                          <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
               title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="flaticon-box-1"></i>
                                          </a>
                                          <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                          <i class="fa fa-phone-square"></i>
                                          </a>

                                         
                                          

                                          `
              }


            } else
            { //not admin or sales

              if ( _UNIB_RIGHT == 'SalesHead' )
              {

                if ( e.created_by == 'Pooja Gupta' )
                {
                  return `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          
                                                      <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                      <i class="la la-edit"></i>
                                                    </a>
                                                    <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                                                    title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="flaticon-box-1"></i>
                                                                               </a>
                                                                               <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                               <i class="fa fa-phone-square"></i>
                                                                               </a>
                                                                               <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a>

                                                                                `;

                } else
                // <a href="${ sample_URL }"
                // title="Send Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                //                            <i class="
                //                            flaticon-box "></i>
                //                            </a>
                {
                  return `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          
                                                      <a href="javascript::void(0)" onclick="mark_client_AsRowMaterial(${ e.RecordID },${ e.rawMFlaf })"
                       title="Mark as Row Material" class="btn btn-${ rowClassM } m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-box-1"></i>
                                                  </a>
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>

                                                  <a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })"
                                                                               title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                                          <i class="fa fa-share"></i>
                                                                                                          </a>

                                                      `

                }




              } else
              {
                return `<a target="_blank"  href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                     
                                                  <a style="margin-top:5px" href="javascript::void(0)"   onclick="click2CallClient(${ e.RecordID })" title="Click TO CALL " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="fa fa-phone-square"></i>
                                                  </a>
                                                  <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                        <i class="la la-edit"></i>
                                                      </a>

                                                  `
              }



            }




          }
        },
        {
          targets: 7,
          width: 100,
          render: function ( a, t, e, n )
          {
            return `<div class="m-widget5__info">
                    <span class="m-widget5__info-label">
                      Last:
                    </span>
                    <span class="m-widget5__info-date m--font-info">
                      ${ e.last_note_added }
                    </span><br>
                    <span class="m-widget5__primary-label">
                      Next:
                    </span>
                    <span class="m-widget5__primary-date m--font-success">
                    ${ e.follow_date }
                    </span>
                  </div>`
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

//m_table_clientListSalesLeadV1


var DatatablesSearchOptionsAdvancedSearchClientDataList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      if ( UID == 1 || UID == 156 || UID == 90 || UID == 171 || UID == 85 )
      {
        var baseURL = BASE_URL + '/getLeadListV3_AdminView';

      } else
      {
        var baseURL = BASE_URL + '/getLeadListV3';
      }
      var a;
      a = $( "#m_table_clientList" ).DataTable( {
        responsive: !1,
        scrollY: "150vh",
        scrollX: !0,
        // ordering: false,      
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100 ],
        pageLength: 10,

        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {
          // url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
          url: baseURL,
          type: "GET",
          data: {
            columnsDef: [ "RecordID", "brand", "company", "name", "created_on", "created_by", "phone", "last_note_added", "follow_date", "Status", "stage_status", "rawMFlaf", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company"
          },
          {
            data: "brand"
          },
          {
            data: "name"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },
          {
            data: "phone"
          },

          {
            data: "stage_status"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: -1,
          title: "Action",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            add_Order_URL = BASE_URL + '/new-order/' + e.RecordID;
            edit_Order_URL = BASE_URL + '/edit-lead/' + e.RecordID;
            viewLeadAll_details_URL = BASE_URL + '/view-all-lead-details/' + e.RecordID;


            if ( UID == 85 )
            {
              HTML = `<a  style="margin:1px"   href="${ viewLeadAll_details_URL }"   title="View All Details about  Lead " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
               <i class="fa fa-eye"></i>
             </a>`;
              return HTML;

            }

            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.RecordID;
            var HTMLVIEW = `<span class="dropdown" style="color:#000"  z-index: -1;>
            <a href="javascript::void(0)" title="Lead Action View" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
              <i class="la la-ellipsis-h"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">`;
            HTMLVIEW += `<a class="dropdown-item" href="${ add_Order_URL }"><i class="la la-plus"></i>Add Order</a>`;
            HTMLVIEW += `<a class="dropdown-item"  href="javascript::void(0)" onclick="LeadSampleAddModelSalesLead(${ e.RecordID })"   ><i class="la la-plus"></i>Add Sample</a>`;
            HTMLVIEW += `<a class="dropdown-item" href="javascript::void(0)" onclick="add_Lead_notes(${ e.RecordID })"><i class="la la-plus"></i>Add Follow Note</a>`;


            HTMLVIEW += `
              <a class="dropdown-item" href="${ viewLeadAll_details_URL }"><i class="la la-eye"></i> Details All Details </a>`;


            HTMLVIEW += `
           </div>
           </span>
           <a href="${ edit_Order_URL }" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="EDIT LEAD">
               <i class="la la-edit"></i>
           </a>`


            //return HTMLVIEW;
            var HTML = ``;

            HTML += `<a style="margin:1px" href="${ add_Order_URL }" title="Add New Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa fa-plus-square"></i>
          </a>`;

            HTML += `<a  style="margin:1px"   href="javascript::void(0)" onclick="LeadSampleAddModelSalesLead(${ e.RecordID })"  title="Add New Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="fa fa-tasks"></i>
        </a>`;
            HTML += `<a  style="margin:1px"   href="javascript::void(0)" onclick="add_Lead_notes(${ e.RecordID })"  title="Add Notes and schedule " class="btn btn-brand m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="la la-sticky-note-o"></i>
      </a>`;
            HTML += `<a  style="margin:1px"   href="${ viewLeadAll_details_URL }"   title="View All Details about  Lead " class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
      <i class="fa fa-eye"></i>
    </a>`;




            HTML += ` <a href="${ edit_Order_URL }" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill" title="EDIT LEAD">
<i class="la la-edit"></i>
</a>`;
            HTML += `<a href="javascript::void(0)" onclick="add_Lead_onCredit(${ e.RecordID })"  title="Mark as Credit" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa flaticon-bag"></i>
            </a>`;
            if ( UID == 1 || UID == 156 || UID == 90 || UID == 222 )
            {

              HTML += `<a href="javascript::void(0)" onclick="wantToFullTransferClient(${ e.RecordID })" title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
  <i class="fa fa-share"></i>
  </a>`;

  HTML += `<a style="margin-left:5px" href="javascript::void(0)" onclick="wantToFullTransferClientWithEMailSMS(${ e.RecordID })" title="Fully Transfer Client" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
  <i class="fa fa-users"></i>
  </a>`;

            }


            return HTML;

          }
        },

        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "Assigned",
                state: "primary"
              },
              2: {
                title: "Qualified",
                state: "warning"
              },
              3: {
                title: "Sampling",
                state: "accent"
              },
              4: {
                title: "Client",
                state: "success"
              },
              5: {
                title: "Repeat Client",
                state: "danger"
              }
            };
            return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" onclick="viewSalesLeadStage(' + e.RecordID + ')" title="View Stage" style="text-decoration: none">&nbsp;<span class="m--font-bold m--font-' + i[ a ].state + '">' + i[ a ].title + "</span></a>"
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

// nates list
var DatatablesSearchOptionsAdvancedSearchNotesDataList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_NotesList" ).DataTable( {
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
          // url: "https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/server.php",
          url: BASE_URL + '/getClientsNotesList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "client_id", "client_name", "client_company", "message", "sh_on", "created_by", "created_on", "Status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "client_name"
          },
          {
            data: "client_company"
          },
          {
            data: "message"
          },
          {
            data: "sh_on"
          },
          {
            data: "created_by"
          },
          {
            data: "created_on"
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
                    title: "RAW",
                    class: "m-badge--brand"
                  },
                  2: {
                    title: "LEAD",
                    class: " m-badge--metal"
                  },
                  3: {
                    title: "QUALIFIED",
                    class: " m-badge--primary"
                  },
                  4: {
                    title: "SAMPLING",
                    class: " m-badge--success"
                  },
                  5: {
                    title: "CUSTOMER",
                    class: " m-badge--info"
                  },
                  6: {
                    title: "LOST",
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

            edit_URL = BASE_URL + '/client/' + e.RecordID + '/edit';
            view_URL = BASE_URL + '/client/' + e.RecordID + '';
            return `

                            <a href="javascript::void(0)" onclick="delete_client_note(${ e.RecordID })"
                             title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-delete"></i>
                                                        </a>
                                                        <a href="javascript::void(0)" onclick="add_client_notes(${ e.client_id })"
                             title="Add Notes" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                            														<i class="flaticon-chat "></i>
                                                        </a>
                                                        `
          }
        },
        {
          targets: 6,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "UNREAD",
                class: "m-badge--danger"
              },
              2: {
                title: "READ",
                class: " m-badge--success"
              },

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

// nates list

jQuery( document ).ready( function ()
{
  DatatablesSearchOptionsAdvancedSearchClientDataList.init()
  DatatablesSearchOptionsAdvancedSearchClientDataListSalesLeadV1.init()

  DatatablesSearchOptionsAdvancedSearchClientDataListTeamClient.init()
  DatatablesSearchOptionsAdvancedSearchNotesDataList.init()
  TodayClientFolloup.init()
  YestardayClientFolloup.init()
  DelayedClientFolloup.init()
  DatatablesLeadList.init()
  DatatablesLeadList_ADMIN.init()
  DatatablesLeadList_LeadManger.init()
  m_table_LEADList_LeadMangerVIEW_Intern.init()
  DatatablesLeadList_LeadManger_ASSIGNCLAIM.init()
  DatatablesLeadList_LeadMangerExport.init()

  DatatablesLeadList_ALLVIEW.init();
  DatatablesLeadListAvailabe_ALLVIEW.init();
  DatatablesTickettListAvailabe_ALLVIEW.init();

  DatatablesLeadList_LMLAYOUT.init()
  DatatablesCID_QUATATION.init()

  DatatablesLeadList_SALES_END.init()
  DatatablesLeadListSalesOwnLead.init()
  DatatablesSalesLeadList.init()
  DatatablesClientDataListv1.init()
  Datatablesm_table_loginActivity.init()
  Datatablesm_table_m_table_SOPActivity.init()
  Datatablesm_table_Click2CallActivity.init()
  DatatablesLeadList_PACK.init();
  DatatablesClientDataPaymentRequestv1.init()
  DatatablesClientDataPaymentRequestv1_Sample.init();
  DatatablesClientDataOrderApprovalList.init()
  DatatablesSampleReportList.init();



} );

//datagrid Client list

function viewSalesLeadStage( ticket_id )
{

  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': 7,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSaleLeadStages',
    type: 'GET',
    data: formData,
    success: function ( res )
    {



      $( '.ajcustomProgessBar' ).html( `` );

      var HistoryHTML = '';
      $.each( res.stage_action_data, function ( key, st )
      {
        HistoryHTML += `<tr>
      <th scope="row">${ st.id }</th>
      <td>${ st.stage_name }</td>
      <td>${ st.completed_on }</td>
      <td>${ st.msg }</td>
      <td>${ st.completed_by }</td>
    </tr>`;

      } );

      $( '.StageActionHistory' ).html( HistoryHTML );


      //comment





      var HTML = '';
      var pday = 0;
      $.each( res.stages_info, function ( key, st )
      {

        pday = parseInt( pday ) + parseInt( st.process_days );
        var new_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
        var expected_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD-MM" );

        if ( st.started )
        {
          if ( st.started )
          {
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetailsSALESLEAD(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsSALESLEAD(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status })">${ st.stage_name }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsSALESLEAD(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a data-toggle="m-tooltip" data-placement="top" title="Default light skin"  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsSALESLEAD(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status })">${ st.stage_name } </a>`;

          }
        }


      } );

      $( '.ajcustomProgessBar' ).append( HTML );
      $( '#bomVieAw' ).html( '' );

      $( '#bomVieAw' ).append( res.BOM_HTML );


      // $( '#m_modal_4_2_GeneralViewModel' ).modal( 'show' );

      $( '#GeneralViewModelSalesLead' ).modal( 'show' );

    },
    dataType: 'json'
  } );
  //ajax call

}

//viewSalesLeadStage

function StageActionWithDetailsSALESLEAD( process_id, stage_id, ticket_id, stage_access )
{
  if ( stage_access == 0 )
  {
    toasterOptions();
    toastr.error( 'Access Denied  ', 'Stage Process' );
    return true;
  }
  if ( stage_access == 1 )
  {

    $( "#model_BO_salesLead_id" ).modal( 'show' );

    $( '#txtStage_ID_SL' ).val( stage_id );


    $( '#txtTicketID_SL' ).val( ticket_id );
    $( '#txtProcessID_SL' ).val( process_id );



  }

}


function viewLeadStageSalesOWN( ticket_id )
{

  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': 5, //for mylead
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getAllOrderStagev1_MY_lead',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '.ajcustomProgessBar' ).html( `` );
      $( '.ajorderTable' ).html( `<tr>
      <th scope="row">Order ID:<b>${ res.process_data.order_id }/${ res.process_data.subOrder }</b></th>
      <td>Brand Name:<b>${ res.process_data.brand_name }</b></td>
      <td>Sales Person:<b>${ res.created_by }</b></td>
      <td>Order Started: <b>${ res.artwork_start_date }</b></td>
    </tr>`);

      var HistoryHTML = '';
      $.each( res.stage_action_data, function ( key, st )
      {
        HistoryHTML += `<tr>
      <th scope="row">${ st.id }</th>
      <td>${ st.stage_name }</td>
      <td>${ st.completed_on }</td>
      <td>${ st.msg }</td>
      <td>${ st.completed_by }</td>
    </tr>`;

      } );

      $( '.StageActionHistory' ).html( HistoryHTML );

      //comment
      var HistoryHTML = '';
      $.each( res.stage_action_dataComment, function ( key, st )
      {
        HistoryHTML += `<tr>
      <th scope="row">${ st.id }</th>
      <td>${ st.stage_name } 	<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">${ st.remarks }</span> </td>
      <td>${ st.completed_on }</td>
      <td></td>
      <td>${ st.completed_by }</td>
    </tr>`;

      } );

      $( '.StageActionHistoryComments' ).html( HistoryHTML );

      //comment





      var HTML = '';
      var pday = 0;
      $.each( res.stages_info, function ( key, st )
      {

        pday = parseInt( pday ) + parseInt( st.process_days );
        var new_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
        var expected_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD-MM" );

        if ( st.started )
        {
          if ( st.started )
          {
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a data-toggle="m-tooltip" data-placement="top" title="Default light skin"  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount }${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          }
        }


      } );

      $( '.ajcustomProgessBar' ).append( HTML );
      $( '#bomVieAw' ).html( '' );

      $( '#bomVieAw' ).append( res.BOM_HTML );


      $( '#m_modal_4_2_GeneralViewModel' ).modal( 'show' );

    },
    dataType: 'json'
  } );
  //ajax call

}


function viewLeadStage( ticket_id )
{

  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': 4,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getAllOrderStagev1_lead',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '.ajcustomProgessBar' ).html( `` );
      $( '.ajorderTable' ).html( `<tr>
      <th scope="row">Order ID:<b>${ res.process_data.order_id }/${ res.process_data.subOrder }</b></th>
      <td>Brand Name:<b>${ res.process_data.brand_name }</b></td>
      <td>Sales Person:<b>${ res.created_by }</b></td>
      <td>Order Started: <b>${ res.artwork_start_date }</b></td>
    </tr>`);

      var HistoryHTML = '';
      $.each( res.stage_action_data, function ( key, st )
      {
        HistoryHTML += `<tr>
      <th scope="row">${ st.id }</th>
      <td>${ st.stage_name }</td>
      <td>${ st.completed_on }</td>
      <td>${ st.msg }</td>
      <td>${ st.completed_by }</td>
    </tr>`;

      } );

      $( '.StageActionHistory' ).html( HistoryHTML );

      //comment
      var HistoryHTML = '';
      $.each( res.stage_action_dataComment, function ( key, st )
      {
        HistoryHTML += `<tr>
      <th scope="row">${ st.id }</th>
      <td>${ st.stage_name } 	<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">${ st.remarks }</span> </td>
      <td>${ st.completed_on }</td>
      <td></td>
      <td>${ st.completed_by }</td>
    </tr>`;

      } );

      $( '.StageActionHistoryComments' ).html( HistoryHTML );

      //comment





      var HTML = '';
      var pday = 0;
      $.each( res.stages_info, function ( key, st )
      {

        pday = parseInt( pday ) + parseInt( st.process_days );
        var new_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
        var expected_date = moment( st.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD-MM" );

        if ( st.started )
        {
          if ( st.started )
          {
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a data-toggle="m-tooltip" data-placement="top" title="Default light skin"  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount }${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          }
        }


      } );

      $( '.ajcustomProgessBar' ).append( HTML );
      $( '#bomVieAw' ).html( '' );

      $( '#bomVieAw' ).append( res.BOM_HTML );


      $( '#m_modal_4_2_GeneralViewModel' ).modal( 'show' );

    },
    dataType: 'json'
  } );
  //ajax call

}
//wantToFullTransferClient

function wantToFullTransferClient( rowid )
{

  $( '#clid' ).val( rowid );
  $( '#m_modal_6_TransferClient' ).modal( 'show' );


}
function wantToFullTransferClientWithEMailSMS( rowid )
{

  $( '#clid_email_sms' ).val( rowid );
  $( '#m_modal_6_TransferClient_EMAIL_SMS' ).modal( 'show' );


}





//wantToFullTransferClient

//mark_client_AsRowMaterial
function mark_client_AsRowMaterial( rowid, mark_val )
{

  var want_to = '';
  var mark_valset = 0;
  if ( mark_val == 1 )
  {
    mark_valset = 0;

    want_to = 'want to unmark as Raw Material Required!';
  } else
  {
    want_to = 'want to mark as Raw Material Required!';
    mark_valset = 1;
  }


  swal( {
    title: "Are you sure?",
    text: want_to,
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes",
    cancelButtonText: "No, Cancel!",
    reverseButtons: !1
  } ).then( function ( ey )
  {
    if ( ey.value )
    {
      $.ajax( {
        url: BASE_URL + "/mark_as_row_material",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid, mark_valset: mark_valset },
        success: function ( resp )
        {

          if ( resp.status == 0 )
          {
            swal( "Marks Alert!", "Cann't not mark", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                location.reload();
              }
            } );
          } else
          {
            // swal("Client!", "Your note has been deleted.", "success").then(function(eyz){
            //   if(eyz.value){
            //     location.reload();
            //   }
            // });
            toasterOptions();
            toastr.success( 'Mark as Row Material ', 'Raw Material' );
            setTimeout( function ()
            {
              location.reload();


            }, 500 );



          }


        },
        dataType: 'json'
      } );

    }

  } )

}

//mark_client_AsRowMaterial

//add_Lead_onCredit
function add_Lead_onCredit( rowid )
{
  $( '#lead_id_credit' ).val( rowid );
  $( '#m_modal_79_leadOncredit' ).modal( 'show' );

}

//add_Lead_onCredit

//add_Lead_notes
function add_Lead_notes( rowid )
{
  $( '#lead_id' ).val( rowid );
  $( '#m_modal_6_leadNotes' ).modal( 'show' );

}

$( 'input[name=followUPSET]' ).click( function ()
{
  if ( $( this ).prop( "checked" ) == true )
  {
    var selectVal = $( this ).val();

    if ( selectVal == 1 )
    {


    } else
    {

    }
  }

} );


//add_Lead_notes

function add_client_notes( rowid )
{
  $( '#user_id' ).val( rowid );
  $( '#m_modal_6' ).modal( 'show' );

}

function print_SampeBO()
{

  $( '#m_modal_6SamplePrint' ).modal( 'show' );
}


// delte notes
function delete_note( rowid )
{
  swal( {
    title: "Are you sure?",
    text: "You won't be able to revert this Message!",
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
        url: BASE_URL + "/delete.note",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid },
        success: function ( resp )
        {
          console.log( resp );
          if ( resp.status == 0 )
          {
            swal( "Deleted Alert!", "Cann't not delete", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your note has been deleted.", "success" ).then( function ( eyz )
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

// delte notes

// datalist for notes
var DatatablesDataSourceHtml = {
  init: function ()
  {
    $( "#m_table_clientNotesList" ).DataTable( {
      responsive: !0,

      columnDefs: [ {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {
          console.log( e[ 0 ] );
          return '\t\t\t\t\t\t<a href="javascript::void(0)" onclick="delete_note(' + e[ 0 ] + ')"  class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t';

        }
      }
      ]
    } )
  }
};
jQuery( document ).ready( function ()
{
  DatatablesDataSourceHtml.init()
} );




//ajaxDay
var DatatablesAdvancedFooterCalllbackLeadV2 = {
  init: function ()
  {
    $( "#m_table_1_OrderLead_Data" ).DataTable( {
      responsive: !0,
      pageLength: 200,
      lengthMenu: [
        [ 2, 5, 10, 15, -1 ],
        [ 2, 5, 10, 15, "All" ]
      ],
      footerCallback: function ( t, e, n, a, r )
      {
        var o = this.api(),
          l = function ( t )
          {
            return "string" == typeof t ? 1 * t.replace( /[\$,]/g, "" ) : "number" == typeof t ? t : 0
          },
          u = o.column( 5 ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 ),
          i = o.column( 5, {
            page: "current"
          } ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 );
        $( o.column( 5 ).footer() ).html( "<br/> ( Total : <b style='color:#035496'>₹</b> " + mUtil.numberString( u.toFixed( 0 ) ) + " )" )
      }
    } )
  }
};




jQuery( document ).ready( function ()
{
  DatatablesAdvancedFooterCalllbackLeadV2.init()

} );

//ajaxDay